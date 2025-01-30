<?php
session_start();

$db = null;
include "../../private/connect.php";
include "../../private/book.php";
include "../../private/tag.php";

$id = null;
$pass = "";
$name = "";
$type = null;
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

if (isset($_POST["password"])) {
    $pass = htmlspecialchars($_POST["password"]);
}

if ($pass == "") {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

if (isset($_POST["name"])) {
    $name = htmlspecialchars($_POST["name"]);
}

if (isset($_POST["type"])) {
    $type = htmlspecialchars($_POST["type"]);
} else {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

$insertStatement = $db->prepare("INSERT INTO user (id, name, password, type) VALUES (:id, :name, :pass, :type)");

if ($insertStatement) {
    $hashed = password_hash($pass, PASSWORD_DEFAULT);
    $insertStatement->bindValue(':id', $id, SQLITE3_INTEGER);
    $insertStatement->bindValue(':pass', $hashed, SQLITE3_TEXT);
    $insertStatement->bindValue(':type', $type, SQLITE3_INTEGER);
    $insertStatement->bindValue(':name', $name, SQLITE3_TEXT);
    
    if ($insertStatement->execute()) {
        echo json_encode(["success" => "User added successfully.", "id" => $id]);
    } else {
        echo json_encode(["error" => "Failed to add tag."]);
    }
} else {
    echo json_encode(["error" => "Failed to prepare statement."]);
}

close_db($db);
