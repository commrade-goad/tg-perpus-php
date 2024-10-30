<?php

$db = null;
include "../../../private/connect.php";
include "../../../private/book.php";
include "../../../private/tag.php";

$book = null;
$count = 0;
$title = "";
$author = "";
$desc = "";
$tags = array(); 
$year = "";
$cover = "";

check_and_create($db);
header('Content-Type: application/json');

// =======================

if (isset($_GET["title"])) {
    $title = htmlspecialchars($_GET["title"]);
}

if ($title == "") {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

// =======================

if (isset($_GET["author"])) {
    $author = htmlspecialchars($_GET["author"]);
}

if ($author == "") {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

// =======================

if (isset($_GET["desc"])) {
    $desc = htmlspecialchars($_GET["desc"]);
}

if ($desc == "") {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

// =======================

if (isset($_GET["tags"])) {
    $tmp = htmlspecialchars($_GET["tags"]);
    $tags = preg_split('/\s+/', $tmp);
}

// =======================

if (isset($_GET["year"])) {
    $year = htmlspecialchars($_GET["year"]);
}

if ($year == "") {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

// =======================

if (isset($_GET["img"])) {
    $cover = htmlspecialchars($_GET["img"]);
}

// =======================

$statement = "SELECT COUNT(*) AS count FROM book";
$result = $db->query($statement);
if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $count = $row["count"] + 1;
}

$insertStatement = $db->prepare("INSERT INTO book (book_id, title, author, desc, year, cover) VALUES (:book_id, :title, :author, :desc, :year, :cover)");

if ($insertStatement) {
    $insertStatement->bindValue(':tags_id', $count, SQLITE3_INTEGER);
    $insertStatement->bindValue(':title', $title, SQLITE3_TEXT);
    $insertStatement->bindValue(':author', $author, SQLITE3_TEXT);
    $insertStatement->bindValue(':desc', $desc, SQLITE3_TEXT);
    $insertStatement->bindValue(':year', $year, SQLITE3_TEXT);
    $insertStatement->bindValue(':cover', $cover, SQLITE3_TEXT);
    
    if ($insertStatement->execute()) {
        echo json_encode(["success" => "Tag added successfully.", "book_id" => $count]);
    } else {
        echo json_encode(["error" => "Failed to add tag."]);
    }
} else {
    echo json_encode(["error" => "Failed to prepare statement."]);
}

$n = 0;
foreach ($tags as $tag) {
    $insertStatement = $db->prepare("INSERT INTO book_tags (btag_id, book_id, tags_id) VALUES (:btag_id, :book_id, :tags_id)");

    if ($insertStatement) {
        $insertStatement->bindValue(':btag_id', $count . "-" . $n, SQLITE3_TEXT);
        $insertStatement->bindValue(':book_id', $count, SQLITE3_INTEGER);
        $insertStatement->bindValue(':tags_id', (int)$tag, SQLITE3_INTEGER);

        if (!$insertStatement->execute()) {
            echo json_encode(["error" => "Failed to add tag."]);
        }
    } else {
        echo json_encode(["error" => "Failed to prepare statement."]);
    }
    $n += 1;
}

close_db($db);
