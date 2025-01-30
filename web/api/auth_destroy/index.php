<?php
session_start();
header('Content-Type: application/json');

$success_id = false;
if (isset($_SESSION["id"])) {
    unset($_SESSION["id"]);
    $success_id = true;
}

if (isset($_SESSION['name'])) {
    unset($_SESSION['name']);
}

$success_role = false;
if (isset($_SESSION["role"])) {
    unset($_SESSION['role']);
    $success_role = true;
}

if ($success_id && $success_role) {
    echo json_encode(["success" => 1]);
} else {
    echo json_encode(["success" => -1]);
}

session_destroy();
