<?php session_start();

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
    <title>Book</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
</head>
<body class="font-poppins">
        <header class="bg-blue-600 p-6 text-2xl font-semibold text-gray-200 text-center" style="font-family: 'Poppins';">
            Perpustakaan
        </header>
    <!-- <div class="flex items-center justify-center p-2">
        <a href="#" class="p-3 bg-blue-300 rounded-lg mr-3 text-gray-600 font-medium">Dashboard</a>
        <a href="#" class="p-3 bg-blue-300 rounded-lg mr-3 text-gray-600 font-medium">Anggota</a>
        <a href="#" class="p-3 bg-blue-300 rounded-lg mr-3 text-gray-600 font-medium">Peminjaman</a>
        <a href="#" class="p-3 bg-blue-300 rounded-lg text-gray-600 font-medium">Pengembalian</a>
    </div> -->
    <div class="bg-blue-400 p-4 flex items-center">
            <div class="flex">
                <div class="mr-2 font-semibold text-lg text-gray-50" style="font-family: 'Poppins';">Selamat Datang <?php echo $_SESSION['id']?>!,</div>
                <div class="mr-2 font-semibold text-lg text-gray-50" style="font-family: 'Poppins';">
                    Tanggal : <?php echo date("l, j F Y"); ?></div>
            </div>
        </div>

    <section class="p-4">
        <div class="bg-blue-700 w-auto h-auto rounded-md">
            <div class="p-4 flex justify-between items-center rounded text-gray-50" style="font-family: 'Poppins';">
                <div>Data Buku</div>
                <button class="bg-blue-400 hover:bg-blue-600 px-2 py-1 rounded" onclick="openModal()">Add Book</button>
            </div>
            <div class="p-4 flex justify-between items-center rounded text-gray-50" style="font-family: 'Poppins';">
                <div>
                    <label for="" class="mr-1">Tampilkan</label>
                    <input type="text" class="text-gray-900 pl-1">
                </div>
                <div>
                    <label for="" class="mr-1">Search</label>
                    <input type="text" class="text-gray-900 pl-1">
                </div>
            </div>
            <div class="p-4">
                <table class="w-full table-auto">
                  <thead>

                    <tr class="bg-blue-600 text-gray-50" style="font-family: 'Poppins';">

                      <th class="px-4 py-2 text-left">Judul</th>
                      <th class="px-4 py-2 text-left">Pengarang</th>
                      <th class="px-4 py-2 text-left">Tags</th>
                      <th class="px-4 py-2 text-left">Tahun Terbit</th>
                      <th class="px-4 py-2 text-left">Aksi</th>
                    </tr>

                  </thead>
                  <tbody>

                    <tr class="border-b border-blue-600 hover:bg-blue-500 text-gray-50" style="font-family: 'Poppins';">
                      <td class="px-4 py-2">Buku 1</td>
                      <td class="px-4 py-2">Pengarang 1</td>
                      <td class="px-4 py-2">Tag</td>
                      <td class="px-4 py-2">2022</td>
                      <td class="px-4 py-2">
                        <button class="bg-blue-400 hover:bg-blue-700 px-2 py-1 rounded mr-2">Edit</button>
                        <button class="bg-blue-400 hover:bg-blue-700 px-2 py-1 rounded">Delete</button>
                      </td>
                    </tr>

                    <tr class="border-b border-blue-600 hover:bg-blue-500 text-gray-50" style="font-family: 'Poppins';">
                      <td class="px-4 py-2">Buku 2</td>
                      <td class="px-4 py-2">Pengarang 2</td>
                      <td class="px-4 py-2">Tag</td>
                      <td class="px-4 py-2">2023</td>
                      <td class="px-4 py-2">
                        <button class="bg-blue-400 hover:bg-blue-700 px-2 py-1 rounded mr-2">Edit</button>
                        <button class="bg-blue-400 hover:bg-blue-700 px-2 py-1 rounded">Delete</button>
                      </td>
                    </tr>

                  </tbody>
                </table>
              </div>
              <div class="p-4 flex justify-between items-center rounded text-gray-50" style="font-family: 'Poppins';">
                    <div>
                        Menampilkan 0 Sampai -
                    </div>
                <div>
                    <button class="bg-blue-400 hover:bg-blue-600 px-2 py-1 rounded mr-2">Sebelumnya</button>
                    <button class="bg-blue-400 hover:bg-blue-600 px-2 py-1 rounded">Selanjutnya</button>
                </div>
            </div>
        </div>
    </section>
    
    <div id="modal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75 hidden ">
        <div class=" bg-white shadow-2xl rounded-lg w-1/2">
            <div class="p-4">
                <h2 class="text-lg font-semibold mb-4">Tambah Buku</h2>
                <form onsubmit="handleSubmit(event)">
                    <div class="mb-4">
                        <label for="" class="text-gray-700">Judul Buku</label>
                        <input type="text" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Judul Buku">
                    </div>
                    <div class="mb-4">
                        <label for="" class="text-gray-700">Gambar Cover</label>
                        <input type="file" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Gambar">
                    </div>
                    <div class="mb-4">
                        <label for="" class="text-gray-700">Pengarang</label>
                        <input type="text" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Pengarang">
                    </div>
                    <div class="mb-4">
                        <label for="" class="text-gray-700">Tags</label>
                        <input type="text" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Tags">
                    </div>
                    <div class="mb-4">
                        <label for="" class="text-gray-700">Tahun Terbit</label>
                        <input type="text" class="border-2 border-gray-300 p-2 rounded w-full" placeholder="Tahun">
                    </div>
                    <div class="flex justify-end">
                        <button type="button" id="batal" onclick="closeModal()" class="bg-gray-300 hover:bg-gray-400 px-4 py-2 rounded mr-2">Batal</button>
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded">Simpan</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
<script type="text/javascript">
    function openModal() {
        document.getElementById('modal').classList.remove('hidden');
    }
    
    function closeModal() {
        document.getElementById('modal').classList.add('hidden');
    }
    
    function handleSubmit(event) {
        event.preventDefault();
    }
    
</script>
    <footer class="bg-blue-700 p-4 text-gray-50 text-center" style="font-family: 'Poppins'; margin-top:31vh";>© Copyright IF UKDC 2023</footer>

</body>
</html> 
