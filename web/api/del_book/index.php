<?php

$db = null;
include "../../../private/connect.php";
include "../../../private/book.php";
include "../../../private/tag.php";


$id = null;
check_and_create($db);
header('Content-Type: application/json');

if (isset($_GET["id"])) {
    $id = (int)$_GET["id"];
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
