<?php
session_start();

$tag = ["Horror", "Epic", "Educate", "Law"];
$timeout_duration = 6000;

if (!isset($_SESSION['npm'])) {
    header('Location: /login');
    exit();
}

if (isset($_SESSION['LAST_ACTIVITY'])) {
    if (time() - $_SESSION['LAST_ACTIVITY'] > $timeout_duration) {
        session_unset();
        session_destroy();
        header('Location: /login');
        exit();
    }
}

$_SESSION['LAST_ACTIVITY'] = time();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body>

    <div class="bg-yellow-500 font-bold text-center text-4xl p-5 border-b-4 flex items-center justify-between">
        <div class="flex-1 text-white text-4xl text-center">
            Perpustakaan UKDC
        </div>
    </div>

    <div class="bg-blue-600 font-bold p-5 text-right">
        <form action="/dashboard/logout.php" method="POST">
            <button type="submit" class="bg-white text-blue-500 font-bold py-2 px-2 text-sm rounded">Logout</button>
        </form>
    </div>

    <div class="bg-blue-600 h-screen flex flex-col items-center justify-center text-center">
        <div class="bg-blue-500 rounded-xl shadow-lg p-8 w-full max-w-xl -mt-80">
            <div class="text-white text-2xl p-3">
                <h1>Welcome, <?php echo htmlspecialchars($_SESSION['npm']); ?>!</h1>
            </div>
            <h1 class="pb-5 text-4xl font-bold text-white">Mau cari buku apa?</h1>
            <form action="/dashboard/book.php" method="POST" class="flex justify-center w-full items-center">
                <div class="flex justify-center items-center w-full">
                    <label for="search" class="sr-only"></label>
                    <input type="text" name="search" id="search" class="bg-blue-300 w-full p-2 text-xl 
                    rounded-xl border-white border-2 focus:border-blue-600 text-white
                    focus:outline-none" placeholder="Contoh: Programming">
                    <button><i class="fas fa-search ml-3 text-white text-2xl"></i></button>
                </div>
            </form>
            <div>
                <ul class="flex justify-center space-x-4 mt-5">
                    <?php foreach ($tag as $a): ?>
                        <a href="/dashboard/book.php">
                            <li class="bg-blue-600 text-white py-2 px-4 rounded-lg">
                                <?php echo $a; ?>
                            </li>
                        </a>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="bg-blue-600 font-bold text-center text-2xl p-5 border-t-4">@Copyright UKDC IF23</div>

    <script>
        const timeoutDuration = <?php echo $timeout_duration; ?>; 
        setTimeout(() => {
            alert("Sesi Anda telah habis. Silakan masuk lagi.");
            window.location.href = '/login';
        }, timeoutDuration * 1000);
    </script>
</body>
</html>