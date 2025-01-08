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
    <title>Book</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="min-h-screen flex flex-col bg-blue-600">
<div class="bg-blue-800 font-bold font-['Poppins'] text-center p-5 border-b-4 flex items-center justify-between">
        <div class="flex-1 text-white text-4xl text-center" onclick="window.location.href='/admin'">
            PERPUSTAKAAN UKDC
        </div>
    </div>

        <div class="bg-blue-800 p-4 flex justify-between items-center">
            <div class="flex">
                <div class="mr-2 font-semibold text-lg text-gray-50">Selamat Datang <?php echo htmlspecialchars($user); ?>,</div>
                <div class="mr-2 font-semibold text-lg text-gray-50"><?php echo date("d F Y"); ?></div>
            </div>
            <form action="/dashboard/logout.php" method="POST">
                <button type="submit" class="bg-blue-400 hover:bg-blue-600 text-gray-50 font-bold py-2 px-2 text-sm rounded">Logout</button>
            </form>
    </div>

    <section class="p-4">
        <div class="bg-blue-800 w-auto h-auto rounded-md">
            <div class="p-4 flex justify-between items-center rounded text-gray-50" style="font-family: 'Poppins';">
                <div class="text-3xl font-semibold font-['Poppins']">Data Buku</div>
                <button class="bg-blue-400 hover:bg-blue-600 px-2 py-1 rounded text-lg font-semibold font-['Poppins']" onclick="openModal()">Add Book</button>
            </div>
            <div class="p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 items-center rounded text-gray-50 justify-between" style="font-family: 'Poppins';">
                <!-- <div>
                    <label for="" class="block sm:inline mr-1">Tampilkan</label>
                    <input type="text" class="text-gray-900 pl-1">
                </div> -->
                <div>
                    <label for="" class="block sm:inline mr-1">Search</label>
                    <input type="text" id="search" class="text-gray-900 pl-1" placeholder="Search...">
                </div>
            </div>
            <div class="p-4 overflow-x-auto">
                <table class="w-full table-auto sm:table" id="user-table-book">
                  <thead>
                    <tr class="bg-blue-700 text-gray-50 text-lg" style="font-family: 'Poppins';">
                        <th class="px-2 py-1 sm:px-4 sm:py-2 text-left">Judul</th>
                        <th class="px-2 py-1 sm:px-4 sm:py-2 text-left">Pengarang</th>
                        <th class="px-2 py-1 sm:px-4 sm:py-2 text-left">Prodi</th>
                        <th class="px-2 py-1 sm:px-4 sm:py-2 text-left">Posisi</th>
                        <th class="px-2 py-1 sm:px-4 sm:py-2 text-left">Tags</th>
                        <th class="px-2 py-1 sm:px-4 sm:py-2 text-left">Tahun Terbit</th>
                        <th class="px-2 py-1 sm:px-4 sm:py-2 text-left">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($data as $row): ?>
                    <tr class="border-b border-blue-600 hover:bg-blue-500 text-gray-50" style="font-family: 'Poppins';">
                      <td class="px-4 py-2"><?= htmlspecialchars($row['title']); ?></td>
                      <td class="px-4 py-2"><?= htmlspecialchars($row['author']); ?></td>
                      <td class="px-4 py-2"></td>
                      <td class="px-4 py-2"></td>
                      <td class="px-4 py-2"><?= htmlspecialchars($row['tags']); ?></td>
                      <td class="px-4 py-2"><?= htmlspecialchars($row['year']); ?></td>
                      <td class="px-4 py-2">
                            <div class="flex justify-center items-center h-full space-x-2">
                                <button class="bg-blue-400 hover:bg-blue-700 px-2 py-1 rounded mr-2 my-1">Edit</button>
                                <button class="bg-blue-400 hover:bg-blue-700 px-2 py-1 rounded">Delete</button>
                            </div>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
              <div class="p-4 flex flex-col sm:flex-row justify-between items-center gap-2 sm:gap-0 rounded text-gray-50" style="font-family: 'Poppins';">
    <div class="order-2 sm:order-1">
        <button class="bg-blue-400 hover:bg-blue-600 px-4 py-2 rounded">Sebelumnya</button>
    </div>
    <div class="order-1 sm:order-2">
        <button class="bg-blue-400 hover:bg-blue-600 px-4 py-2 rounded">Selanjutnya</button>
    </div>
</div>

        </div>

    </section>

    <div id="profilePopup" class="hidden fixed right-0 top-20 md:right-8 md:left-auto top-1/4 mx-auto w-64 bg-white shadow-lg rounded-lg p-6 text-center z-50 md:w-80 lg:right-2 lg:w-96"
    style="max-width: 90vw;">
   <p class="text-lg font-semibold">Profil</p>
   <div class="rounded-full w-24 h-24 mx-auto overflow-hidden mt-4">
       <img src="/src/gambar2.jpg" class="w-full h-full object-cover">
   </div>
   <p class="text-lg font-semibold mt-2">Admin</p>
   <p class="text-lg font-semibold">NPM</p>
   <button class="bg-blue-400 hover:bg-blue-700 text-white rounded-lg px-4 py-2 mt-4 font-semibold" onclick="closeProfil()">Logout</button>
</div>


    
    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75 hidden ">
        <div class=" bg-white shadow-2xl rounded-lg w-full max-w-lg mx-4 sm:mx-auto overflow-y-auto max-h-screen">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-4">Tambah Buku</h2>
                <form id="add_book">
                    <div class="mb-4">
                        <label for="" class="text-gray-700">Judul Buku</label>
                        <input type="text" name="title" id= "title"  class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Judul Buku">
                    </div>
                    <div class="mb-4">
                        <label for="" class="text-gray-700">Deskripsi Buku</label>
                        <input type="text" name="desc" id= "desc"  class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Deskripsi">
                    </div>
                    <div class="mb-4">
                        <label for="" class="text-gray-700">Gambar</label>
                        <input type="text" name="img" id= "img" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Gambar">
                    </div>
                    <div class="mb-4">
                        <label for="" class="text-gray-700">Pengarang</label>
                        <input type="text" name="author" id= "author" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Pengarang">
                    </div>
                    <div class="mb-4">
                        <label for="" class="text-gray-700">Prodi Buku</label>
                        <input type="text" name="prodi" id= "prodi" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Prodi buku">
                    </div>
                    <div class="mb-4">
                        <label for="" class="text-gray-700">Posisi Buku</label>
                        <input type="text" name="posisi" id= "pos" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Posisi buku">
                    </div>
                    <div class="mb-4">
                        <label for="" class="text-gray-700">Tahun Terbit</label>
                        <input type="text" name="year" id= "year" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Tahun">
                    </div>
                    <div class="mb-4">
                        <label for="" class="text-gray-700">Tags</label>
                        <div id="tagsContainer" class="flex flex-wrap gap-2 mt-2"></div>
                        <input type="hidden" name="tag_ids" id="tag_ids" value="">
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
            <h2 class="text-lg font-semibold mb-4">Edit Buku</h2>
            <form id="edit_book">
                <div class="mb-4">
                    <label for="title" class="text-gray-700">Judul Buku</label>
                    <input type="text" name="title" id="edit_title" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Judul Buku">
                </div>
                <div class="mb-4">
                    <label for="desc" class="text-gray-700">Deskripsi Buku</label>
                    <input type="text" name="desc" id="edit_desc" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Deskripsi">
                </div>
                <div class="mb-4">
                    <label for="img" class="text-gray-700">Gambar</label>
                    <input type="text" name="img" id="edit_img" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Gambar">
                </div>
                <div class="mb-4">
                    <label for="author" class="text-gray-700">Pengarang</label>
                    <input type="text" name="author" id="edit_author" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Pengarang">
                </div>
                <div class="mb-4">
                    <label for="year" class="text-gray-700">Tahun Terbit</label>
                    <input type="text" name="year" id="edit_year" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Tahun">
                </div>
                <div class="mb-4">
                    <label for="" class="text-gray-700">Posisi Buku</label>
                    <input type="text" name="posisi" id= "edit_pos" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Posisi buku">
                </div>
                <div class="mb-4">
                    <label for="" class="text-gray-700">Prodi Buku</label>
                    <input type="text" name="prodi" id= "edit_prodi" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Prodi buku">
                </div>
                <div class="mb-4">
                    <label for="tags" class="text-gray-700">Tags</label>
                    <div id="edit_tagsContainer" class="flex flex-wrap gap-2 mt-2"></div>
                </div>
                <div class="flex justify-end">
                    <button type="button" id="batal" onclick="closeEditModal()" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded mr-2">Batal</button>
                    <button type="submit" id="submitEditBook" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="book.js"></script>
</body>
    <footer class="bg-blue-800 font-bold text-center text-2xl p-5 text-gray-50 font-['Poppins'] mt-auto" style="font-family: 'Poppins';">Licensed with GNU GPL v2.0</footer>
</html> 
