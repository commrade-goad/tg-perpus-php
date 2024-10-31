<?php
session_start();

$db = null;
include "../../../private/connect.php";
include "../../../private/user.php";

$id = null;
$password = "";
check_and_create($db);
header('Content-Type: application/json');

// check session
if (!isset($_SESSION["id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] != 1) {
    echo json_encode(["error" => "Unauthorized access!"]);
    exit();
}

if (isset($_GET["id"])) {
    $id = (int)$_GET["id"];
} else {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

if (isset($_GET["password"])) {
    $password = $_GET["password"];
} else {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

if ($password == "") {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

$hashed = password_hash($password, PASSWORD_DEFAULT);
$updateStatement = $db->prepare("UPDATE user SET password = :pass where id = :id");
if ($updateStatement) {
    $updateStatement->bindValue(':pass', $hashed, SQLITE3_TEXT);
    $updateStatement->bindValue(':id', $id, SQLITE3_TEXT);
}
if (!$updateStatement->execute()) {
    echo json_encode(["error" => "Failed to update user."]);
    exit();
}
echo json_encode(["success" => "User updated.", "id" => $id]);
close_db($db);
