<?php

$db = null;
include "../../../private/connect.php";
include "../../../private/book.php";
include "../../../private/tag.php";

$prodi = array();
$sort = "ASC";
$from = 0;
$range = 50;
check_and_create($db);
header('Content-Type: application/json');

if (isset($_GET["sort"])) {
    if (strtoupper($_GET["sort"]) == "DESC") {
        $sort = "DESC";
    }
}

if (isset($_GET["from"])) {
    $tmp = $_GET["from"];
    $from = (int)$tmp;
}

if (isset($_GET["range"])) {
    $tmp = $_GET["range"];
    $range = (int)$tmp;
}

$statement = "select * from prodi order by name " . $sort . " limit " . $range . " offset " . $from;
$result = $db->query($statement);
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $tmp = $row["name"];
    array_push($prodi, $tmp);
}

echo json_encode($prodi);
close_db($db);
