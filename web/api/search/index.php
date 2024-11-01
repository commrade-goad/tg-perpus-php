<?php

$db = null;
include "../../../private/connect.php";
include "../../../private/book.php";
include "../../../private/tag.php";

$books = [];
$sort = "ASC";
$from = 0;
$range = 50;
$query = "";
check_and_create($db);
header('Content-Type: application/json');

if (isset($_GET["q"])) {
    $query = $_GET["q"];
}

if (empty($query)) {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

if (isset($_GET["sort"]) && strtoupper($_GET["sort"]) == "DESC") {
    $sort = "DESC";
}

if (isset($_GET["from"])) {
    $from = (int)$_GET["from"];
}

if (isset($_GET["range"])) {
    $range = (int)$_GET["range"];
}

// Define classes and functions
class SearchResult implements JsonSerializable {
    public Book $book;
    public float $score;

    public function __construct(Book $book, float $score) {
        $this->book = $book;
        $this->score = $score;
    }

    public function jsonSerialize(): array {
        return [
            'book' => $this->book,
            'score' => $this->score,
        ];
    }
}

class SortedData {
    public int $index;
    public float $score;

    public function __construct(int $index, float $score) {
        $this->index = $index;
        $this->score = $score;
    }
}

function vectorizeBook(array $documents): array {
    $allWordCount = [];

    foreach ($documents as $doc) {
        $wordCount = [];

        foreach (explode(' ', $doc->title) as $word) {
            $wordCount[strtolower($word)] = ($wordCount[strtolower($word)] ?? 0) + 1.0;
        }
        foreach (explode(' ', $doc->author) as $word) {
            $wordCount[strtolower($word)] = ($wordCount[strtolower($word)] ?? 0) + 1.0;
        }
        foreach ($doc->tags as $tag) {
            $wordCount[strtolower($tag->name)] = ($wordCount[strtolower($tag->name)] ?? 0) + 1.0;
        }
        $wordCount[(string)$doc->year] = ($wordCount[(string)$doc->year] ?? 0) + 1.0;

        $allWordCount[] = $wordCount;
    }

    return $allWordCount;
}

function vectorizeWord(string $words, array $vectorBook): array {
    $result = [];
    $keywords = array_map('strtolower', preg_split('/\s+/', $words));

    foreach ($keywords as $w) {
        $result[$w] = ($result[$w] ?? 0) + 1.0;

        foreach ($vectorBook as $obj) {
            foreach ($obj as $key => $value) {
                if (strpos($key, $w) !== false) {
                    $result[$key] = ($result[$key] ?? 0) + 1.0;
                }
            }
        }
    }

    return $result;
}

function cosineSimilarity(array $vec1, array $vec2): float {
    $dotProduct = 0.0;
    $magnitude1 = 0.0;
    $magnitude2 = 0.0;

    foreach ($vec1 as $key => $value1) {
        if (isset($vec2[$key])) {
            $dotProduct += $value1 * $vec2[$key];
        }
        $magnitude1 += $value1 * $value1;
    }

    foreach ($vec2 as $value2) {
        $magnitude2 += $value2 * $value2;
    }

    $magnitude1 = sqrt($magnitude1);
    $magnitude2 = sqrt($magnitude2);

    return ($magnitude1 == 0.0 || $magnitude2 == 0.0) ? 0.0 : $dotProduct / ($magnitude1 * $magnitude2);
}

$statement = "SELECT * FROM book ORDER BY title $sort LIMIT $range OFFSET $from";
$result = $db->query($statement);
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $tmp = new Book(
        $row["book_id"],
        $row["title"],
        $row["author"],
        $row["desc"],
        [],
        $row["year"],
        $row["cover"]
    );
    $books[] = $tmp;
}

foreach ($books as $book) {
    $sec_statement = "
        SELECT at.name, at.tags_id 
        FROM book_tags bt 
        JOIN all_tags at ON bt.tags_id = at.tags_id 
        WHERE bt.book_id = " . $book->id . " ORDER BY at.name ASC";
    $result = $db->query($sec_statement);
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $book->tags[] = new Tag($row["tags_id"], $row["name"]);
    }
}

$vectorizedBook = vectorizeBook($books);
$vectorizedKeyword = vectorizeWord($query, $vectorizedBook);

$arraySimilarity = [];
foreach ($vectorizedBook as $i => $tmp_obj) {
    $score = cosineSimilarity($vectorizedKeyword, $tmp_obj);
    $arraySimilarity[] = new SortedData($i, $score);
}

usort($arraySimilarity, function($a, $b) {
    return $b->score <=> $a->score;
});

$searchedBook = [];
foreach ($arraySimilarity as $sim) {
    if ($sim->score > 0.0) {
        $searchedBook[] = new SearchResult($books[$sim->index], $sim->score);
    }
}

echo json_encode($searchedBook);
close_db($db);
