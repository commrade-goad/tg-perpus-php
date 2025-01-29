<?php

$db = null;
include "../../private/connect.php";
include "../../private/book.php";
include "../../private/tag.php";

$books = array();
$id = null;
$sort = "ASC";
$from = 0;
$range = 10000;
check_and_create($db);
header('Content-Type: application/json');

if (isset($_GET["id"])) {
    $tmp_id = $_GET["id"];
    $id = (int)$tmp_id;
} else {
    echo json_encode(["error" => "Need a tag id!"]);
    exit();
}

if (isset($_GET["sort"])) {
    if (strtoupper($_GET["sort"]) == "DESC") {
        $sort = "DESC";
    }
}

if (isset($_GET["from"])) {
    $tmp = $_GET["from"];
    $from = (int)$tmp;
}

if (isset($_GET["range"])) {
    $tmp = $_GET["range"];
    $range = (int)$tmp;
}

$statement = "
    SELECT b.book_id, b.title, b.author, b.desc, b.year, b.cover, b.pos, b.prodi
    FROM book b
    JOIN book_tags bt ON b.book_id = bt.book_id
    JOIN all_tags at ON bt.tags_id = at.tags_id
    WHERE at.tags_id = " . $id . " ORDER BY b.title " . $sort . " limit " . $range . " offset " . $from;
$result = $db->query($statement);
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $tmp = new Book (
        $row["book_id"],
        $row["title"],
        $row["author"],
        $row["desc"],
        array(),
        $row["year"],
        $row["cover"],
        $row["pos"],
        $row["prodi"],
    );
    array_push($books, $tmp);
}

foreach ($books as $book) {
    $sec_statement = "
        SELECT at.name, at.tags_id, at.img 
        FROM book_tags bt 
        JOIN all_tags at ON bt.tags_id = at.tags_id 
        WHERE bt.book_id = " . $book->id . " ORDER BY at.name ASC";
    $result = $db->query($sec_statement);
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        array_push($book->tags, new Tag ($row["tags_id"], $row["name"], $row["img"]));
    }
}

echo json_encode($books);
close_db($db);
