<?php
session_start();

$timeout_duration = 6000;

// Timing Session
if (!isset($_SESSION['id'])) {
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

</head>
<body class="bg-blue-600">
<div class="bg-blue-800 font-bold font-['Poppins'] text-center p-5 border-b-4 flex items-center justify-between">
        <div class="flex-1 text-white text-4xl text-center">
            PERPUSTAKAAN UKDC
        </div>
    </div>

    <div class="bg-blue-600 font-bold p-5 text-right">
        <form action="/dashboard/logout.php" method="POST">
        <button type="submit" class="bg-blue-400 hover:bg-blue-700 text-gray-50 font-bold py-2 px-2 text-sm rounded">Logout</button>
        </form>
    </div>

    <div class="bg-blue-600 h-screen flex flex-col items-center justify-center text-center">
        <div class="bg-blue-500 rounded-xl shadow-lg p-8 w-full max-w-xl -mt-80">
            <div class="text-gray-50 text-2xl p-3">
                <h1 class="text-2xl font-semibold font-['Poppins']">Welcome, <?php echo htmlspecialchars($_SESSION['id']); ?>!</h1>
            </div>
            <h1 class="pb-5 text-4xl font-semibold font-['Poppins'] text-gray-50">Mau cari buku apa? </h1>
            <form action="/dashboard/book.php" method="GET" class="flex justify-center w-full items-center" onsubmit="return handleSearch()">
                <div class="flex justify-center items-center w-full">
                    <label for="search" class="sr-only"></label>
                    <input type="text" name="search" id="search" class="bg-blue-400 w-full p-2 text-lg placeholder-gray-100
                    rounded-xl border-white border-2 focus:border-blue-600 text-gray-50 font-['Poppins']
                    focus:outline-none" placeholder="Contoh: Programming">
                    <button type="submit"><i class="fas fa-search ml-3 text-white text-2xl"></i></button>
                </div>
            </form>
                
            <div>
                <ul id="tagList" class="flex justify-center space-x-4 mt-5 text-lg font-['Poppins']">
                    <span id="prev"></span>
                    <span id="next"></span>
                </ul>
            </div>
        </div>
    </div>

    <div class="bg-blue-800 font-bold text-center text-2xl p-5 border-t-4 text-gray-50 font-['Poppins']">Licensed with GNU GPL v2.0</div>

</body>
    <script>
// kalo timeout
const timeoutduration = <? php echo isset($timeout_duration) ? $timeout_duration : 6000; ?>; // durasi
settimeout(async () => {
    try {
        const response = await fetch('/api/auth_destroy', { method: 'post' });

        alert("sesi anda telah habis. silakan masuk lagi.");
        window.location.href = '/login';
    } catch (error) {
        console.error("error destroying session:", error);
    }
}, timeoutduration * 1000);
    </script>
    <script src="/dashboard/script.js"></script>
</html>
