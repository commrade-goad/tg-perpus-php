<?php

$db = null;
include "../../private/connect.php";
include "../../private/book.php";
include "../../private/tag.php";

$books = array();
$sort = "ASC";
$from = 0;
$range = 10000;
check_and_create($db);
header('Content-Type: application/json');

if (isset($_GET["id"])) {
    $tmp_id = $_GET["id"];
    $book = null;
    $statement = "select * from book where book_id = " . $tmp_id . " limit 1";
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
            $row["prodi"],
            $row["pos"]
        );
        $book = $tmp;
    }
    $sec_statement = "
        SELECT at.name, at.tags_id, at.img 
        FROM book_tags bt 
        JOIN all_tags at ON bt.tags_id = at.tags_id 
        WHERE bt.book_id = " . $book->id . " ORDER BY at.name ASC";
    $result = $db->query($sec_statement);
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        array_push($book->tags, new Tag ($row["tags_id"], $row["name"], $row["img"]));
    }
    echo json_encode($book);
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

$statement = "select * from book order by title " . $sort . " limit " . $range . " offset " . $from;
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
        $row["prodi"],
        $row["pos"],
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
