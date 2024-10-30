<?php
session_start();

$valid_npm = "123456";
$valid_password = "password";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $npm = $_POST['npm'];
    $password = $_POST['password'];

    echo "NPM: $npm<br>";
    echo "Password: $password<br>";

    if ($npm === $valid_npm && $password === $valid_password) {
        $_SESSION['npm'] = $npm;
        header('Location: /dashboard');
        exit();
    } else {
        echo "NPM atau password salah!";
    }
} else {
    echo "Metode permintaan tidak valid!";
}
?>