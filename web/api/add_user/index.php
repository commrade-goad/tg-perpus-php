<?php
session_start();

$db = null;
include "../../../private/connect.php";
include "../../../private/book.php";
include "../../../private/tag.php";

$id = null;
$pass = "";
$type = null;
check_and_create($db);
header('Content-Type: application/json');

// check session
if (!isset($_SESSION["id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] == 0) {
    echo json_encode(["error" => "Unauthorized access!"]);
    exit();
}

if (isset($_GET["id"])) {
    $id = htmlspecialchars($_GET["id"]);
} else {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

if (isset($_GET["password"])) {
    $pass = htmlspecialchars($_GET["password"]);
}

if ($pass == "") {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

if (isset($_GET["type"])) {
    $type = htmlspecialchars($_GET["type"]);
} else {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

$insertStatement = $db->prepare("INSERT INTO user (id, password, type) VALUES (:id, :pass, :type)");

if ($insertStatement) {
    $hashed = password_hash($pass, PASSWORD_DEFAULT);
    $insertStatement->bindValue(':id', $id, SQLITE3_INTEGER);
    $insertStatement->bindValue(':pass', $hashed, SQLITE3_TEXT);
    $insertStatement->bindValue(':type', $type, SQLITE3_INTEGER);
    
    if ($insertStatement->execute()) {
        echo json_encode(["success" => "User added successfully.", "id" => $id]);
    } else {
        echo json_encode(["error" => "Failed to add tag."]);
    }
} else {
    echo json_encode(["error" => "Failed to prepare statement."]);
}

close_db($db);
