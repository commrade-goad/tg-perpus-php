<?php
session_start();

$timeout_duration = 6000;

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
        <title>Book</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="min-h-screen flex flex-col bg-blue-600">
<div class="bg-blue-800 font-bold font-['Poppins'] text-center p-5 border-b-4 flex items-center justify-between">
        <div class="flex-1 text-white text-4xl text-center" onclick="window.location.href='/dashboard/index.php'">
            PERPUSTAKAAN UKDC
        </div>
    </div>

    <div class="bg-blue-600 font-bold p-5 text-right">
        <form action="/dashboard/logout.php" method="POST">
        <button type="submit" class="bg-blue-400 hover:bg-blue-700 text-gray-50 font-bold py-2 px-2 text-sm rounded">Logout</button>
        </form>
    </div>

<!-- Centered Search and Filter Section -->
<div class="bg-blue-600 flex flex-col items-center p-3">
        <input type="text" id="searchInput" class="bg-blue-400 text-white w-1/2 p-2 text-xl rounded-xl 
            border-white border-2 focus:border-blue-600 focus:outline-none mb-3" placeholder="Telusuri">

        <div class="flex space-x-4 mb-5">
            <!-- Dropdown for Prodi Filter -->
            <div class="relative inline-block text-left">
                <div>
                    <button type="button" class="inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-blue-500 text-sm font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="dropdownProdiButton" aria-haspopup="true" aria-expanded="true">
                        Filter Prodi
                    </button>
                </div>

                <div class="absolute inset-x-0 top-full z-[100] -m-px rounded shadow-sm bg-[#2d2e32] text-white mt-1 pb-2.5" id="dropdownProdiMenu" role="menu" aria-orientation="vertical" aria-labelledby="dropdownProdiButton" tabindex="-1" style="display: none;">
                    
                </div>
            </div>

            <!-- Dropdown for Tags Filter -->
            <div class="relative inline-block text-left">
                <div>
                    <button type="button" class=" inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-blue-500 text-sm font-medium text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" id="dropdownTagButton" aria-haspopup="true" aria-expanded="true">
                        Filter Tags
                    </button>
                </div>

                <div class="absolute inset-x-0 top-full z-[100] -m-px rounded shadow-sm bg-[#2d2e32] text-white mt-1 pb-2.5" id="dropdownTagMenu" role="menu" aria-orientation="vertical" aria-labelledby="dropdownTagButton" tabindex="-1" style="display: none;">
                    
                </div>
            </div>
        </div>
    </div>

        <div class="bg-blue-600">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 p-4" id="booksContainer">
                <!-- Buku akan ditampilkan di sini -->
            </div>

            <!-- Untuk Tombol Panah -->
            <div class="flex justify-center items-center text-white text-xl mt-auto">
                <span id="prev" class="p-3 text-2xl"><</span>
                <span id="curr" class="mx-5">1</span>
                <span id="next" class="p-3 text-2xl">></span>
            </div>

        </div>
    </body>
        <footer class="bg-blue-800 font-bold text-center text-2xl p-5 text-gray-50 font-['Poppins'] mt-auto" style="font-family: 'Poppins';">Licensed with GNU GPL v2.0</footer>
        <script>
        // Ini untuk API Timeout
        const timeoutDuration = <?php echo isset($timeout_duration) ? $timeout_duration : 6000; ?>;
        setTimeout(async () => {
            try {
                const response = await fetch('/api/auth_destroy', { method: 'POST' });

                if (!response.ok) {
                    throw new Error("Failed to destroy session");
                }

                alert("Sesi Anda telah habis. Silakan masuk lagi.");
                window.location.href = '/login';

            } catch (error) {
                console.error("Error destroying session:", error);
            }

        }, timeoutDuration * 1000);
        </script>
        <script src="book.js"></script>
</html>
