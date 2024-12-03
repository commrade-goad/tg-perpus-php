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
    <body>

        <div class="bg-yellow-500 font-bold text-center text-4xl p-5 border-b-4 flex items-center justify-between">
            <div class="flex-1 text-white text-4xl text-center">
                PERPUSTAKAAN UKDC
            </div>
        </div>

        <div class="bg-blue-600 font-bold p-5 text-right">
            <form action="/dashboard/logout.php" method="POST">
                <button type="submit" class="bg-white text-blue-500 font-bold py-2 px-2 text-sm rounded">Logout</button>
            </form>
        </div>

        <div class="bg-blue-600 flex p-3 justify-center items-center ">
            <input type="text" id="searchInput" class="bg-blue-300 text-white w-1/2 p-2 text-xl rounded-xl 
                border-white border-2 focus:border-blue-600 focus:outline-none" placeholder="Telusuri">
            <!-- <a href="#" class="ml-3 text-2xl text-white" onclick="handleSearchClick()"> -->
                <!-- <i class="fas fa-search"></i> -->
            <!-- </a> -->
        </div>

        <div class="bg-blue-600">
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 p-4" id="booksContainer">
                <!-- Buku akan ditampilkan di sini -->
            </div>

            <!-- Untuk Tombol Panah -->
            <div class="flex justify-center items-center text-white text-xl">
                <span id="prev" class="p-3 text-2xl"><</span>
                <span id="curr" class="mx-5">1</span>
                <span id="next" class="p-3 text-2xl">></span>
            </div>

        </div>

        <div class="bg-blue-600 font-bold text-center text-2xl p-5 border-t-4 text-white font-['Poppins']">© Copyright IF UKDC 2023</div>

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
    </body>
</html>
