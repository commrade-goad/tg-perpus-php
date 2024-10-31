<?php
session_start();

$db = null;
include "../../../private/connect.php";
include "../../../private/book.php";
include "../../../private/tag.php";

$tags = array();
$id = null;
$name = "";
$img = "";
check_and_create($db);
header('Content-Type: application/json');

// check session
if (!isset($_SESSION["id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] == 0) {
    echo json_encode(["error" => "Unauthorized access!"]);
    exit();
}

if (isset($_GET["id"])) {
    $id = (int)htmlspecialchars($_GET["id"]);
} else {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

if (isset($_GET["name"])) {
    $name = htmlspecialchars($_GET["name"]);
}

if ($name == "") {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

if (isset($_GET["img"])) {
    $img = htmlspecialchars($_GET["img"]);
}

$insertStatement = $db->prepare("UPDATE all_tags set name = :name, img = :img where tags_id = :tag");

if ($insertStatement) {
    $insertStatement->bindValue(':name', $name, SQLITE3_TEXT);
    $insertStatement->bindValue(':img', $img, SQLITE3_TEXT);
    $insertStatement->bindValue(':tag', $id, SQLITE3_INTEGER);
    
    if ($insertStatement->execute()) {
        echo json_encode(["success" => "Tag edited successfully.", "tags_id" => $id]);
    } else {
        echo json_encode(["error" => "Failed to add tag."]);
    }
} else {
    echo json_encode(["error" => "Failed to prepare statement."]);
}

close_db($db);