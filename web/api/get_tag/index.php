<?php

$db = null;
include "../../../private/connect.php";
include "../../../private/book.php";
include "../../../private/tag.php";

$tags = array();
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

if (isset($_GET["id"])) {
    $tmp = $_GET["id"];
    $id = (int)$tmp;
    $statement = "select * from all_tags where tags_id = " . $id;
    $result = $db->query($statement);
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $tmp = new Tag (
            $row["tags_id"],
            $row["name"],
            $row["img"],
        );
        array_push($tags, $tmp);
    }

    echo json_encode($tags);
    exit();
}

if (isset($_GET["from"])) {
    $tmp = $_GET["from"];
    $from = (int)$tmp;
}

if (isset($_GET["range"])) {
    $tmp = $_GET["range"];
    $range = (int)$tmp;
}

$statement = "select * from all_tags order by name " . $sort . " limit " . $range . " offset " . $from;
$result = $db->query($statement);
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $tmp = new Tag (
        $row["tags_id"],
        $row["name"],
        $row["img"],
    );
    array_push($tags, $tmp);
}

echo json_encode($tags);
close_db($db);

