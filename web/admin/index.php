<?php
session_start();

$timeout_duration = 6000;

// Timing Session
if (!isset($_SESSION['id'])) {
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
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="font-poppins">
    <header class="bg-blue-600 p-6 text-2xl font-semibold text-gray-200 text-center" style="font-family: 'Poppins';">Perpustakaan</header>
    <div class="bg-blue-400 p-4 flex justify-between items-center">
        
        <div class=" text-gray-50 font-semibold text-lg" style="font-family: 'Poppins';">Selamat Datang Admin</div>
        <div class="flex">
            <div class="mr-2 font-semibold text-lg text-gray-50" style="font-family: 'Poppins';">Dashboard,</div>
            <div class="mr-2 font-semibold text-lg text-gray-50" style="font-family: 'Poppins';">Tanggal</div>
        </div>
    </div>

    
    <section class="grid grid-cols-1 md:grid-cols-4 gap-4 p-4">
        <div class="w-full bg-blue-400 rounded">
            <img src="/src/cover.jpg" alt="">
            <div class="block relative w-full bg-sky-400 p-1">
                <div class="flex h-auto md:h-14 lg:h-24 flex-col justify-between p-2 bg-overlay relative">
                    <p class="text-sm line-clamp-2 font-semibold leading-snug lg:leading-normal text-gray-50" style="font-family: 'Poppins';">0</p>
                    <p class="text-sm line-clamp-2 font-semibold leading-snug lg:leading-normal text-gray-50" style="font-family: 'Poppins';">Anggota</p>
                </div>
            </div>
        </div>
        <div class="w-full bg-blue-400 rounded">
            <img src="/src/cover.jpg" alt="">
            <div class="block relative w-full bg-sky-400 p-1">
                <div class="flex h-auto md:h-14 lg:h-24 flex-col justify-between p-2 bg-overlay relative">
                    <p class="text-sm line-clamp-2 font-semibold leading-snug lg:leading-normal text-gray-50" style="font-family: 'Poppins';">0</p>
                    <p class="text-sm line-clamp-2 font-semibold leading-snug lg:leading-normal text-gray-50" style="font-family: 'Poppins';">Buku</p>
                </div>
            </div>
        </div>
        <div class="w-full bg-blue-400 rounded">
            <img src="/src/cover.jpg" alt="">
            <div class="block relative w-full bg-sky-400 p-1">
                <div class="flex h-auto md:h-14 lg:h-24 flex-col justify-between p-2 bg-overlay relative">
                    <p class="text-sm line-clamp-2 font-semibold leading-snug lg:leading-normal text-gray-50" style="font-family: 'Poppins';">0</p>
                    <p class="text-sm line-clamp-2 font-semibold leading-snug lg:leading-normal text-gray-50" style="font-family: 'Poppins';">Peminjaman</p>
                </div>
            </div>
        </div>
        <div class="w-full bg-blue-400 rounded">
            <img src="/src/cover.jpg" alt="">
            <div class="block relative w-full bg-sky-400 p-1">
                <div class="flex h-auto md:h-14 lg:h-24 flex-col justify-between p-2 bg-overlay relative">
                    <p class="text-sm line-clamp-2 font-semibold leading-snug lg:leading-normal text-gray-50" style="font-family: 'Poppins';">0</p>
                    <p class="text-sm line-clamp-2 font-semibold leading-snug lg:leading-normal text-gray-50" style="font-family: 'Poppins';">Pengembalian</p>
                </div>
            </div>
        </div>


    </section>
    
</body>
</html> 
