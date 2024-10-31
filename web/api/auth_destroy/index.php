<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION["id"])) {
    unset($_SESSION["id"]);
}
if (isset($_SESSION["role"])) {
    unset($_SESSION['role']);
}

echo json_encode(["success" => 1]);
