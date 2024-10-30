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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>
    <div class="bg-blue-500 font-bold text-center text-4xl p-5 border-b-4 flex items-center justify-between">
        <div class="flex-1 text-white text-4xl text-center">
            Perpustakaan UKDC
        </div>
    </div>

    <div class="bg-blue-500 font-bold p-5 text-right">
        <form action="/dashboard/logout.php" method="POST">
            <button type="submit" class="bg-white text-blue-500 font-bold py-2 px-2 text-sm rounded">Logout</button>
        </form>
    </div>

    <div class="bg-blue-500 h-screen flex flex-col items-center justify-center text-center">
        <div class="bg-blue-400 rounded-xl shadow-lg p-8 w-full max-w-xl -mt-80">
            <div class="text-white text-2xl p-3">
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['npm']); ?>!</h1>
            </div>
            <h1 class="pb-5 text-4xl font-bold text-white">Mau cari buku apa?</h1>
            <form action="/login/proses.php" method="POST">
                <div>
                    <label for="npm" class="sr-only"></label>
                    <input type="text" name="npm" id="npm" class="bg-blue-200 w-full p-2 text-base border text-xl rounded-xl border-white border-4 focus:border-blue-500 focus:outline-none" placeholder="Contoh: Programming" required>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-blue-500 font-bold text-center text-2xl p-5 border-t-4">@Copyright UKDC IF23</div>
</body>
</html>
