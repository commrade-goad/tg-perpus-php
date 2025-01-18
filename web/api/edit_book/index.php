<?php
session_start();

$db = null;
include "../../private/connect.php";
include "../../private/book.php";
include "../../private/tag.php";

$id = null;
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

if (isset($_POST["id"])) {
    $tmp_id = $_POST["id"];
    $id = (int)$tmp_id;
} else {
    echo json_encode(["error" => "Need a tag id!"]);
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

$checkProdi = $db->query("SELECT * FROM prodi");
$foundProdi = false;
if ($checkProdi) {
    while ($row = $checkProdi->fetchArray(SQLITE3_ASSOC)) {
        if ($row["name"] == $prodi) {
            $foundProdi = true;
            break;
        }
    }
}

if (!$foundProdi) {
    $insertNewProdi = $db->prepare("INSERT INTO prodi(name) VALUES (:name)");

    if ($insertNewProdi) {
        $insertNewProdi->bindValue(':name', $prodi, SQLITE3_TEXT);

        if ($insertNewProdi->execute()) {
            $count = $db->lastInsertRowID();
        } else {
            echo json_encode(["error" => "Failed to add the new prodi."]);
        }
    } else {
        echo json_encode(["error" => "Failed to prepare statement for new prodi."]);
    }
}

$insertStatement = $db->prepare("UPDATE book set title = :title, author = :author, desc = :desc, year = :year, cover = :cover,  pos = :pos, prodi = :prodi where book_id = :book_id");

if ($insertStatement) {
    $insertStatement->bindValue(':book_id', $id, SQLITE3_INTEGER);
    $insertStatement->bindValue(':title', $title, SQLITE3_TEXT);
    $insertStatement->bindValue(':author', $author, SQLITE3_TEXT);
    $insertStatement->bindValue(':desc', $desc, SQLITE3_TEXT);
    $insertStatement->bindValue(':year', $year, SQLITE3_TEXT);
    $insertStatement->bindValue(':cover', $cover, SQLITE3_TEXT);
    $insertStatement->bindValue(':prodi', $prodi, SQLITE3_TEXT);
    $insertStatement->bindValue(':pos', $pos, SQLITE3_TEXT);
    
    if ($insertStatement->execute()) {
        echo json_encode(["success" => "Tag added successfully.", "book_id" => $id]);
    } else {
        echo json_encode(["error" => "Failed to add tag."]);
    }
} else {
    echo json_encode(["error" => "Failed to prepare statement."]);
}

// DELETE THE TAG BEFORE RE-ADDING THEM
$delstatement = $db->prepare("DELETE FROM book_tags WHERE book_id = :book_id");
if ($delstatement) {
    $delstatement->bindValue(':book_id', $id, SQLITE3_INTEGER);

    if (!$delstatement->execute()) {
        echo json_encode(["error" => "Failed to delete existing tags."]);
        return; 
    }
} else {
    echo json_encode(["error" => "Failed to prepare delete statement."]);
    return;
}

$n = 0;
foreach ($tags as $tag) {
    $insertStatement = $db->prepare("INSERT INTO book_tags (btag_id, book_id, tags_id) VALUES (:btag_id, :book_id, :tags_id)");

    if ($insertStatement) {
        $btag_id = $id . "-" . $n; // Generate unique btag_id
        $insertStatement->bindValue(':btag_id', $btag_id, SQLITE3_TEXT);
        $insertStatement->bindValue(':book_id', $id, SQLITE3_INTEGER);
        $insertStatement->bindValue(':tags_id', (int)$tag, SQLITE3_INTEGER);

        if (!$insertStatement->execute()) {
            echo json_encode(["error" => "Failed to add tag: $btag_id."]);
        }
    } else {
        echo json_encode(["error" => "Failed to prepare insert statement."]);
    }
    $n += 1;
}

close_db($db);
