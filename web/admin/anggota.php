<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

  

    <section class="p-4">
        <div class="bg-blue-800 w-auto h-auto rounded-md">
            <div class="p-4 flex justify-between items-center rounded text-gray-50">
                <div class="text-3xl font-semibold font-['Poppins']">Data Anggota</div>
                <button class="bg-blue-400 hover:bg-blue-600 px-2 py-1 text-lg rounded font-semibold font-['Poppins']" onclick="openModal()">Add Anggota</button>
            </div>
            <div class="p-4 flex justify-between items-center rounded text-gray-50">
                <div>
                    <label for="" class="mr-1">Search</label>
                    <input type="text" id="search" class="text-gray-900 pl-1" placeholder="Search...">
                </div>
            </div>
            <div class="p-4">
                <table class="w-full table-auto" id="user-table">
                    <thead>
                        <tr class="bg-blue-700 text-gray-50">
                            <th class="px-4 py-2 text-left">Npm</th>
                            <th class="px-4 py-2 text-left">Type</th>
                            <th class="px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="user-table-body">
                    </tbody>
                </table>
            </div>
            <div class="p-4 flex justify-between items-center rounded text-gray-50">
                <div>Menampilkan 0 Sampai -</div>
                <div>
                    <button class="bg-blue-400 hover:bg-blue-600 px-2 py-1 rounded mr-2">Sebelumnya</button>
                    <button class="bg-blue-400 hover:bg-blue-600 px-2 py-1 rounded">Selanjutnya</button>
                </div>
            </div>
        </div>
    </section>

    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75 hidden"> 
        <div class="bg-white shadow-2xl rounded-lg w-1/2">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-4">Tambah Anggota</h2>
                <form id="add-user-form">
                    <div class="mb-4">
                        <label for="npm" class="text-gray-700">NPM</label>
                        <input type="text" name="id" id="id" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="NPM" required>
                    </div>
                    <div class="mb-4">
                        <label for="password" class="text-gray-700">Password</label>
                        <input type="password" name="password" id="password" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Password" required>
                    </div>
                    <div class="mb-4">
                        <label for="type" class="text-gray-700">Tipe</label>
                        <input type="text" name="type" id="type" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Tipe" required>
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="batal" onclick="closeModal()" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded mr-2">Batal</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="editModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75 hidden"> 
    <div class="bg-white shadow-2xl rounded-lg w-1/2">
        <div class="p-4">
            <h2 class="text-lg font-semibold mb-4">Edit Anggota</h2>
            <form id="edit-user-form">
                <div class="mb-4">
                    <label for="npm" class="text-gray-700">NPM</label>
                    <input type="text" name="npm" id="npm" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="NPM" disabled>
                </div>
                <div class="mb-4">
                        <label for="password" class="text-gray-700">Password</label>
                        <input type="password" name="password" id="password-new" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Password" required>
                    </div>
                <div class="mb-4">
                    <label for="type" class="text-gray-700">Tipe</label>
                    <input type="text" name="type" id="typeed" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="type" disabled>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="batal" onclick="closeEditModal()" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded mr-2">Batal</button>
                    <button type="submit" id="submitEditAnggota" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


    
<script src="anggota.js"></script>

<div class="bg-blue-800 font-bold text-center text-2xl p-5 border-t-4 text-gray-50 font-['Poppins']" style="font-family: 'Poppins'; margin-top:31vh";>© Copyright IF UKDC 2023</div>
<!-- <footer class="bg-blue-700 p-4 text-gray-50 text-center" style="font-family: 'Poppins'; margin-top:31vh";>© Copyright IF UKDC 2023</footer> -->
</body>
</html>
