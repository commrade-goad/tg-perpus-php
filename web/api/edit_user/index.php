<?php
session_start();

$db = null;
include "../../private/connect.php";
include "../../private/user.php";

$id = null;
$password = "";
$name = "";
check_and_create($db);
header('Content-Type: application/json');

// check session
if (!isset($_SESSION["id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] != 1) {
    echo json_encode(["error" => "Unauthorized access!"]);
    exit();
}

if (isset($_POST["id"])) {
    $id = (int)$_POST["id"];
} else {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

if (isset($_POST["password"])) {
    $password = $_POST["password"];
} else {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

if (isset($_POST["name"])) {
    $name = $_POST["name"];
} else {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

if ($password == null || $password == "") {
    $updateStatement = $db->prepare("UPDATE user SET name = :name where id = :id");
    if ($updateStatement) {
        $updateStatement->bindValue(':id', $id, SQLITE3_TEXT);
        $updateStatement->bindValue(':name', $name, SQLITE3_TEXT);
    }
    if (!$updateStatement->execute()) {
        echo json_encode(["error" => "Failed to update user."]);
        exit();
    }
    echo json_encode(["success" => "User updated.", "id" => $id]);
} else {
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $updateStatement = $db->prepare("UPDATE user SET password = :pass, name = :name where id = :id");
    if ($updateStatement) {
        $updateStatement->bindValue(':pass', $hashed, SQLITE3_TEXT);
        $updateStatement->bindValue(':id', $id, SQLITE3_TEXT);
        $updateStatement->bindValue(':name', $name, SQLITE3_TEXT);
    }
    if (!$updateStatement->execute()) {
        echo json_encode(["error" => "Failed to update user."]);
        exit();
    }
    echo json_encode(["success" => "User updated.", "id" => $id]);
}
close_db($db);
