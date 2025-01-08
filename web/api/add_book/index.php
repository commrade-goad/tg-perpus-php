<?php
session_start();

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
$pos = "";
$prodi = "";

check_and_create($db);
header('Content-Type: application/json');

// check session
if (!isset($_SESSION["id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] == 0) {
    echo json_encode(["error" => "Unauthorized access!"]);
    exit();
}

// =======================

if (isset($_POST["title"])) {
    $title = $_POST["title"];
}

if ($title == "") {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

// =======================

if (isset($_POST["author"])) {
    $author = $_POST["author"];
}

if ($author == "") {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

// =======================

if (isset($_POST["desc"])) {
    $desc = $_POST["desc"];
}

if ($desc == "") {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

// =======================

if (isset($_POST["tags"])) {
    $tmp = $_POST["tags"];
    $tags = preg_split('/\s+/', $tmp);
}

// =======================

if (isset($_POST["year"])) {
    $year = $_POST["year"];
}

if ($year == "") {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

// =======================

if (isset($_POST["img"])) {
    $cover = $_POST["img"];
}

// =======================

// =======================

if (isset($_POST["prodi"])) {
    $prodi = $_POST["prodi"];
}

if ($prodi == "") {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

// =======================

// =======================

if (isset($_POST["pos"])) {
    $pos = $_POST["pos"];
}

if ($pos == "") {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

// =======================

$statement = "SELECT COUNT(*) AS count FROM book";
$result = $db->query($statement);
if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $count = $row["count"] + 1;
}

$insertStatement = $db->prepare("INSERT INTO book (title, author, desc, year, cover, prodi, pos) VALUES (:title, :author, :desc, :year, :cover, :prodi, :pos)");

if ($insertStatement) {
    $insertStatement->bindValue(':title', $title, SQLITE3_TEXT);
    $insertStatement->bindValue(':author', $author, SQLITE3_TEXT);
    $insertStatement->bindValue(':desc', $desc, SQLITE3_TEXT);
    $insertStatement->bindValue(':year', $year, SQLITE3_TEXT);
    $insertStatement->bindValue(':cover', $cover, SQLITE3_TEXT);
    $insertStatement->bindValue(':prodi', $prodi, SQLITE3_TEXT);
    $insertStatement->bindValue(':pos', $pos, SQLITE3_TEXT);
    
    if ($insertStatement->execute()) {
        $count = $db->lastInsertRowID();
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
