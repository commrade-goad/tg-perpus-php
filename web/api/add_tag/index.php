<?php

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

$statement = "SELECT COUNT(*) AS count FROM all_tags";
$result = $db->query($statement);
if ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $count = $row["count"] + 1;
}

$insertStatement = $db->prepare("INSERT INTO all_tags (tags_id, name, img) VALUES (:tags_id, :name, :img)");

if ($insertStatement) {
    $insertStatement->bindValue(':tags_id', $count, SQLITE3_INTEGER);
    $insertStatement->bindValue(':name', $name, SQLITE3_TEXT);
    $insertStatement->bindValue(':img', $img, SQLITE3_TEXT);
    
    if ($insertStatement->execute()) {
        echo json_encode(["success" => "Tag added successfully.", "tags_id" => $count]);
    } else {
        echo json_encode(["error" => "Failed to add tag."]);
    }
} else {
    echo json_encode(["error" => "Failed to prepare statement."]);
}

close_db($db);
