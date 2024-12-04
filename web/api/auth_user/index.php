<?php
session_start();

$db = null;
$simp_key = "";
include "../../../private/connect.php";
include "../../../private/book.php";
include "../../../private/tag.php";
include "../../../private/config.php";

$id = null;
$password = null;
check_and_create($db);
header('Content-Type: application/json');

// Check session
if (isset($_SESSION["id"]) || isset($_SESSION["role"])) {
    echo json_encode(["success" => 0, "message" => "Please logout first!"]);
    exit();
}

if (isset($_GET["id"])) {
    $id = $_GET["id"];
} else {
    echo json_encode(["success" => 0, "message" => "User ID is required."]);
    exit();
}

if (isset($_GET["password"])) {
    $password = $_GET["password"];
} else {
    echo json_encode(["success" => 0, "message" => "Password is required."]);
    exit();
}

$statement = "SELECT * FROM user WHERE id = 0";
$result = $db->query($statement);

if (!$row = $result->fetchArray(SQLITE3_ASSOC)) {
    $hashed = password_hash($simp_key, PASSWORD_DEFAULT);
    $insertStatement = "INSERT INTO user (id, password, type) VALUES (0, '" . $hashed . "', 1)"; 
    if (!$db->exec($insertStatement)) {
        echo json_encode(["success" => 0, "message" => "Failed to create user id 0."]);
        exit();
    };
}

$insertStatement = $db->prepare("SELECT id, password, type FROM user WHERE id = :id");
if ($insertStatement) {
    $insertStatement->bindValue(':id', $id, SQLITE3_INTEGER);

    $result = $insertStatement->execute();
    if ($result) {
        $user = $result->fetchArray(SQLITE3_ASSOC);
        
        if ($user) {
            $hashedPassword = $user['password'];
            $role = $user["type"];
            $id = $user["id"];

            // Always set the user 0 pass to $simp_key
            if ($role == 1 && $id == 0) {
                if (!password_verify($simp_key, $hashedPassword)) {
                    $updateStatement = $db->prepare("UPDATE user SET password = :pass WHERE id = 0");
                    if ($updateStatement) {
                        $hashed = password_hash($simp_key, PASSWORD_DEFAULT);
                        $updateStatement->bindValue(':pass', $hashed);

                        if (!$updateStatement->execute()) {
                            echo json_encode(["success" => 0, "message" => "Failed to update password for user 0."]);
                            exit();
                        }
                    } else {
                        echo json_encode(["success" => 0, "message" => "Failed to prepare update statement."]);
                        exit();
                    }
                }
            }

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['role'] = $role;
                $_SESSION['id'] = $id;
                echo json_encode([
                    "success" => 1,
                    "message" => "Login successful.",
                    "type" => $role // Mengembalikan type pengguna
                ]);
            } else {
                echo json_encode(["success" => 0, "message" => "Invalid password."]);
            }
        } else {
            echo json_encode(["success" => 0, "message" => "User not found."]);
        }
    } else {
        echo json_encode(["success" => 0, "message" => "Failed to execute query."]);
    }
} else {
    echo json_encode(["success" => 0, "message" => "Failed to prepare statement."]);
}

$db->close();