<?php
session_start();

if (!isset($_SESSION['npm'])) {
    header('Location: /login');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Selamat datang, <?php echo htmlspecialchars($_SESSION['npm']); ?>!</h1>

    <!-- Form untuk logout -->
    <form action="/dashboard/logout.php" method="POST">
        <button type="submit">Logout</button>
    </form>
</body>
</html>