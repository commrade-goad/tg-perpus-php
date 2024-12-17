<?php
session_start();

$db = null;
include "../../../private/connect.php";
include "../../../private/book.php";
include "../../../private/tag.php";


$id = null;
check_and_create($db);
header('Content-Type: application/json');

// check session
if (!isset($_SESSION["id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] == 0) {
    echo json_encode(["error" => "Unauthorized access!"]);
    exit();
}

if (isset($_POST["id"])) {
    $id = (int)$_POST["id"];
}

if ($id == null) {
    echo json_encode(["error" => "Not Valid!"]);
    exit();
}

$statement = "delete from book where book_id = " . $id;
if (!$db->exec($statement)) {
    echo json_encode(["error" => "Failed to delete!"]);
    exit();
}

$statement = "delete from book_tags where book_id = " . $id;
if (!$db->exec($statement)) {
    echo json_encode(["error" => "Failed to delete!"]);
    exit();
}

echo json_encode(["success" => "deleted book!", "tags_id" => $id]);
close_db($db);
