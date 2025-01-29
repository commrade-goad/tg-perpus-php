<?php
session_start();

$db = null;
include "../../private/connect.php";
include "../../private/user.php";

$users = array();
$sort = "ASC";
$from = 0;
$range = 10000;
check_and_create($db);
header('Content-Type: application/json');

// check session
if (!isset($_SESSION["id"]) || !isset($_SESSION["role"]) || $_SESSION["role"] != 1) {
    echo json_encode(["error" => "Unauthorized access!"]);
    exit();
}

$statement = "select id, type from user order by id " . $sort . " limit " . $range . " offset " . $from;
$result = $db->query($statement);
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $tmp = new User (
        $row["id"],
        "",
        $row["type"],
    );
    array_push($users, $tmp);
}

echo json_encode($users);
close_db($db);
