<?php
session_start();

$db = null;
include "../../private/connect.php";
include "../../private/book.php";
include "../../private/tag.php";

$id = null;
check_and_create($db);
header('Content-Type: application/json');

// check session
if (!isset($_SESSION["id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] == 0) {
    echo json_encode(["error" => "Unauthorized access!"]);
    exit();
}

if (isset($_POST["id"])) {
    $id = htmlspecialchars($_POST["id"]);
} else {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

$insertStatement = $db->prepare("DELETE FROM user where id = :id");

if ($insertStatement) {
    $insertStatement->bindValue(':id', $id, SQLITE3_INTEGER);
    
    if ($insertStatement->execute()) {
        echo json_encode(["success" => "User deleted successfully.", "id" => $id]);
    } else {
        echo json_encode(["error" => "Failed to add tag."]);
    }
} else {
    echo json_encode(["error" => "Failed to prepare statement."]);
}

close_db($db);
