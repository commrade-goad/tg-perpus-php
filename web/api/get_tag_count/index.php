<?php

$db = null;
include "../../private/connect.php";
include "../../private/book.php";
include "../../private/tag.php";

$count = 0;
check_and_create($db);
header('Content-Type: application/json');

$statement = "select count(*) as count from all_tags";
$result = $db->query($statement);
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $count = $row["count"];
}
echo json_encode(["count" => $count]);
close_db($db);
?>
