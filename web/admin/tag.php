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
    <title>Tag</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="font-poppins bg-blue-600">
    <div class="bg-blue-800 font-bold font-['Poppins'] text-center p-5 border-b-4 flex items-center justify-between">
        <div class="flex-1 text-white text-4xl text-center" onclick="window.location.href='/admin'">
            PERPUSTAKAAN UKDC
        </div>
    </div>
        <!-- <header class="bg-blue-600 p-6 text-2xl font-semibold text-gray-200 text-center" style="font-family: 'Poppins';">
            Perpustakaan
        </header> -->
        <div class="bg-blue-800 p-4 flex justify-between items-center">
            <div class="flex">
                <div class="mr-2 font-semibold text-lg text-gray-50">Selamat Datang <?php echo htmlspecialchars($user); ?>,</div>
                <div class="mr-2 font-semibold text-lg text-gray-50"><?php echo date("d F Y"); ?></div>
            </div>
            <form action="/dashboard/logout.php" method="POST">
                <button type="submit" class="bg-blue-400 text-gray-50 hover:bg-blue-600 font-bold py-2 px-2 text-sm rounded">Logout</button>
            </form>
        </div>
    <!-- <div class="bg-blue-400 p-4 flex items-center">
            <div class="flex">
                <div class="mr-2 font-semibold text-lg text-gray-50" style="font-family: 'Poppins';">Selamat Datang <?php echo $_SESSION['id']?>!,</div>
                <div class="mr-2 font-semibold text-lg text-gray-50" style="font-family: 'Poppins';">
                    Tanggal : <?php echo date("l, j F Y"); ?></div>
            </div>
        </div> -->

    <section class="p-4">
        <div class="bg-blue-700 w-auto h-auto rounded-md p-2">
                <div class="flex justify-between items-center">
                    <p class="text-white font-bold font-poppins text-xl ml-1"> List of tags</p>
                    <input id="sbox" class="w-auto h-auto p-1 text-sm pl-2 pr-2 rounded-md" type="text" placeholder="Search tag...">
                    <button class="text-white bg-blue-500 p-2 rounded-lg" onclick="openModal()">Add tag</button>
                </div>
                <div class="flex justify-center align-center" id="tags-container">
                </div>
                <div class="flex justify-center items-center text-center">
                    <span id="prev" class="text-white text-2xl font-poppins p-2 font-bold"><</span>
                    <span id="next" class="text-white text-2xl font-poppins p-2 font-bold">></span>
                </div>
        </div>
    </section>
    
    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75 hidden ">
        <div class=" bg-white shadow-2xl rounded-lg w-1/2">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-4">Tambah Tag Buku</h2>
                <form onsubmit="handleSubmit(event)">
                    <div class="mb-4">
                        <label for="" class="text-gray-700">Nama Tag</label>
                        <input id="tname" type="text" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Nama Tag">
                    </div>
                    <div class="mb-4">
                        <label for="" class="text-gray-700">Path Gambar Cover</label>
                        <input id="imgp" type="text" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Gambar">
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="batal" onclick="closeModal()" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded mr-2">Batal</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
    <div id="modaledit" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75 hidden ">
        <div class=" bg-white shadow-2xl rounded-lg w-1/2">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-4">Edit Tag Buku</h2>
                <form onsubmit="handleSubmitEdit(event)">
                    <div class="mb-4">
                        <label for="" class="text-gray-700">Tag id</label>
                        <input id="tid" type="text" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Tag id" disabled>
                    </div>
                    <div class="mb-4">
                        <label for="" class="text-gray-700">Nama Tag</label>
                        <input id="tname-e" type="text" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Nama Tag">
                    </div>
                    <div class="mb-4">
                        <label for="" class="text-gray-700">Path Gambar Cover</label>
                        <input id="imgp-e" type="text" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Gambar">
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="batal" onclick="closeModalEdit()" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded mr-2">Batal</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
        <script src="tag.js"></script>
        <div class="bg-blue-800 font-bold text-center text-2xl p-5 border-t-4 text-gray-50 font-['Poppins']" style="font-family: 'Poppins'; margin-top:31vh";>Licensed with GNU GPL v2.0</div>

</body>
</html> 
