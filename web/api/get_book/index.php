<?php

$db = null;
include "../../../private/connect.php";
include "../../../private/book.php";
include "../../../private/tag.php";

$books = array();
check_and_create($db);

// SELECT b.book_id, b.title, b.author, b.desc, b.year, b.cover
// FROM book b
// JOIN book_tags bt ON b.book_id = bt.book_id
// JOIN all_tags at ON bt.tags_id = at.tags_id
// WHERE at.tags_id = {} ORDER BY b.title {} limit {} offset {}

$statement = "select * from book";
$result = $db->query($statement);
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $tmp = new Book (
        $row["book_id"],
        $row["title"],
        $row["author"],
        $row["desc"],
        array(),
        $row["year"],
        $row["cover"]
    );
    array_push($books, $tmp);
}

foreach ($books as $book) {
    $sec_statement = "
        SELECT at.name, at.tags_id 
        FROM book_tags bt 
        JOIN all_tags at ON bt.tags_id = at.tags_id 
        WHERE bt.book_id = " . $book->id . " ORDER BY at.name ASC";
    $result = $db->query($sec_statement);
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        array_push($book->tags, new Tag ($row["tags_id"], $row["name"]));
    }
}

header('Content-Type: application/json');
echo json_encode($books);
close_db($db);
