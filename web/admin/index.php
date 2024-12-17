<?php session_start();

$timeout_duration = 6000;

// Timing Session
if (!isset($_SESSION['id'])) {
    header('Location: /login');
    exit();
}

$user = $_SESSION['id'];

if (isset($_SESSION['role']) && $_SESSION["role"] != 1){
    header('Location: /dashboard/index.php');
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
<body class="bg-blue-600">
    <!-- <header class="bg-blue-600 p-6 text-2xl font-semibold text-gray-200 text-center">PERPUSTAKAAN UKDC</header> -->
    <div class="bg-blue-800 font-bold font-['Poppins'] text-center p-5 border-b-4 flex items-center justify-between">
        <div class="flex-1 text-white text-4xl text-center">
            PERPUSTAKAAN UKDC
        </div>
    </div>

        <div class="bg-blue-800 p-4 flex justify-between items-center">
            <div class="flex">
                <div class="mr-2 font-semibold text-lg text-gray-50">Selamat Datang <?php echo htmlspecialchars($user); ?>,</div>
                <div class="mr-2 font-semibold text-lg text-gray-50"><?php echo date("d F Y"); ?></div>
            </div>
            <form action="/dashboard/logout.php" method="POST">
                <button type="submit" class="bg-blue-400 text-gray-50 hover:bg-blue-600 font-bold py-2 px-2 text-sm rounded">Logout</button>
            </form>
    </div>

    <div class="justify-center items-center">
        <section class="grid grid-cols-1 md:grid-cols-4  gap-4 p-4">
            <div class="w-full bg-blue-400 rounded">
                <a href="../admin/anggota.php">
                <img src="/src/gambar2.jpg" alt="">
                <div class="block relative w-full bg-sky-400 p-1">
                        <div class="flex h-auto md:h-14 lg:h-24 flex-col justify-between p-2 bg-overlay relative">
                            <p class="text-sm line-clamp-2 font-semibold leading-snug lg:leading-normal text-gray-50" style="font-family: 'Poppins';"></p>
                            <p class="text-sm line-clamp-2 font-semibold leading-snug lg:leading-normal text-gray-50" style="font-family: 'Poppins';">Anggota</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="w-full bg-blue-400 rounded">
                <a href="../admin/book.php">
                <img src="/src/gambar2.jpg" alt="">
                <div class="block relative w-full bg-sky-400 p-1">
                        <div class="flex h-auto md:h-14 lg:h-24 flex-col justify-between p-2 bg-overlay relative">
                            <p class="text-sm line-clamp-2 font-semibold leading-snug lg:leading-normal text-gray-50" style="font-family: 'Poppins';"></p>
                            <p class="text-sm line-clamp-2 font-semibold leading-snug lg:leading-normal text-gray-50" style="font-family: 'Poppins';">Buku</p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="w-full bg-blue-400 rounded">
                <a href="../admin/tag.php">
                <img src="/src/gambar2.jpg" alt="">
                <div class="block relative w-full bg-sky-400 p-1">
                        <div class="flex h-auto md:h-14 lg:h-24 flex-col justify-between p-2 bg-overlay relative">
                            <p class="text-sm line-clamp-2 font-semibold leading-snug lg:leading-normal text-gray-50" style="font-family: 'Poppins';"></p>
                            <p class="text-sm line-clamp-2 font-semibold leading-snug lg:leading-normal text-gray-50" style="font-family: 'Poppins';">Tag</p>
                        </div>
                    </div>
                </a>
            </div>
    
        </section>
        
    </div>

    
<div class="bg-blue-800 font-bold text-center text-2xl p-5 border-t-4 text-gray-50 font-['Poppins']" style="font-family: 'Poppins'; margin-top:31vh";>Licensed with GNU GPL v2.0</div>
</body>
</html> 
