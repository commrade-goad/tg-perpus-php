<?php
session_start();

$db = null;
include "../../../private/connect.php";
include "../../../private/book.php";
include "../../../private/tag.php";

$tags = array();
$count = 0;
$name = "";
$img = "";
check_and_create($db);
header('Content-Type: application/json');

// check session
if (!isset($_SESSION["id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] == 0) {
    echo json_encode(["error" => "Unauthorized access!"]);
    exit();
}

if (isset($_POST["name"])) {
    $name = $_POST["name"];
}

if ($name == "") {
    echo json_encode(["error" => "Not a valid name!"]);
    exit();
}

if (isset($_POST["img"])) {
    $img = $_POST["img"];
}

$statement = "SELECT COUNT(*) AS count FROM all_tags";
$result = $db->query($statement);
if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $count = $row["count"] + 1;
}

$insertStatement = $db->prepare("INSERT INTO all_tags (name, img) VALUES (:name, :img)");

if ($insertStatement) {
    $insertStatement->bindValue(':name', $name, SQLITE3_TEXT);
    $insertStatement->bindValue(':img', $img, SQLITE3_TEXT);
    
    if ($insertStatement->execute()) {
        $lastId = $db->lastInsertRowID();
        echo json_encode(["success" => "Tag added successfully.", "tags_id" => $lastId]);
    } else {
        echo json_encode(["error" => "Failed to add tag : " . $name . ", " . $img]);
    }
} else {
    echo json_encode(["error" => "Failed to prepare statement."]);
}

close_db($db);
