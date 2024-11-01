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
<<<<<<< Updated upstream
=======

$books = [
    [
        'image' => 'https://waifu2x.booru.pics/outfiles/891050a5d362d586dbf746b0420cf92563d40acb_s2_n3_y1.jpg',
        'title' => 'Judul 1',
        'author' => 'Author 1'
    ],
    [
        'image' => 'https://waifu2x.booru.pics/outfiles/891050a5d362d586dbf746b0420cf92563d40acb_s2_n3_y1.jpg',
        'title' => 'Judul 2',
        'author' => 'Author 2'
    ],
    [
        'image' => 'https://waifu2x.booru.pics/outfiles/891050a5d362d586dbf746b0420cf92563d40acb_s2_n3_y1.jpg',
        'title' => 'Judul 3',
        'author' => 'Author 3'
    ],
    [
        'image' => 'https://waifu2x.booru.pics/outfiles/891050a5d362d586dbf746b0420cf92563d40acb_s2_n3_y1.jpg',
        'title' => 'Judul 4',
        'author' => 'Author 4'
    ],
    [
        'image' => 'https://waifu2x.booru.pics/outfiles/891050a5d362d586dbf746b0420cf92563d40acb_s2_n3_y1.jpg',
        'title' => 'Judul 5',
        'author' => 'Author 5'
    ],
    [
        'image' => 'https://waifu2x.booru.pics/outfiles/891050a5d362d586dbf746b0420cf92563d40acb_s2_n3_y1.jpg',
        'title' => 'Judul 5',
        'author' => 'Author 5'
    ],
];
>>>>>>> Stashed changes
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

    <div class="bg-blue-800 font-bold font-['Poppins'] text-center text-4xl p-5 border-b-4 flex items-center justify-between">
        <div class="flex-1 text-gray-50 text-4xl text-center">
            PERPUSTAKAAN UKDC
        </div>
    </div>

    <div class="bg-blue-600 font-bold p-5 text-right">
        <form action="/dashboard/logout.php" method="POST">
            <button type="submit" class="bg-white text-blue-500 font-bold py-2 px-2 text-sm rounded">Logout</button>
        </form>
    </div>

<<<<<<< Updated upstream
    <div class="bg-blue-600 flex p-10 justify-center items-center -m-10">
        <input type="text" id="searchInput" class="bg-blue-300 text-white w-1/2 p-2 text-xl rounded-xl 
=======
    <div class="bg-blue-600 flex p-6 justify-center items-center">
        <input type="text" class="bg-blue-300 text-white w-1/2 p-2 text-xl rounded-xl 
>>>>>>> Stashed changes
            border-white border-2 focus:border-blue-600 focus:outline-none" placeholder="Telusuri">
        <a href="#" class="ml-3 text-2xl text-white">
            <i class="fas fa-search"></i>
        </a>
    </div>

<<<<<<< Updated upstream
    <div class="bg-blue-600">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 p-4" id="booksContainer">
=======
    <div class="bg-blue-600 p-5">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5 p-4">
>>>>>>> Stashed changes
            <?php foreach ($books as $book): ?>
                <div class="p-4 bg-blue-300 rounded-lg shadow hover:shadow-xl transition-shadow">
                    <a href="/dashboard/book_detail.php" class="flex flex-col items-center text-center">
                        <div class="w-50 h-50">
<<<<<<< Updated upstream
                            <img src="<?php echo htmlspecialchars($book['image'] ?: 'https://waifu2x.booru.pics/outfiles/891050a5d362d586dbf746b0420cf92563d40acb_s2_n3_y1.jpg'); ?>" alt="ini gambar" class="w-full h-full object-cover rounded-lg mb-2">
=======
                            <img src="<?php echo htmlspecialchars($book['image']); ?>" alt="ini gambar" class="w-full h-full object-cover rounded-lg mb-2 hover:brightness-75">
>>>>>>> Stashed changes
                        </div>
                        <div class="text-lg font-semibold font-['Poppins'] judul"><?php echo htmlspecialchars($book['title']); ?></div>
                        <div class="text-sm text-gray-500 font-['Poppins'] author"><?php echo htmlspecialchars($book['author']); ?></div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="bg-blue-800 font-bold text-center text-2xl p-5 border-t-4 text-gray-50 font-['Poppins']">© Copyright IF UKDC 2023</div>

    <script>
        // Ini untuk API Timeout
        const timeoutDuration = <?php echo $timeout_duration; ?>;
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

        // Ini untuk API ambil Buku dari DB
        async function fetchBooks() {
            try {
                const response = await fetch('/api/get_book?from=0&range=20&sort=ASC');
                
                if (!response.ok) {
                    throw new Error("Failed to fetch books");
                }

                const data = await response.json();

                if (!Array.isArray(data)) {
                    throw new Error("Invalid data format");
                }

                const booksContainer = document.getElementById('booksContainer');
                booksContainer.innerHTML = '';

                data.forEach(book => {
                    const bookElement = document.createElement('div');
                    bookElement.className = 'p-4 bg-blue-300 rounded-lg shadow hover:shadow-xl transition-shadow';

                    const coverImage = book.cover || 'https://waifu2x.booru.pics/outfiles/891050a5d362d586dbf746b0420cf92563d40acb_s2_n3_y1.jpg'; // Gambar default jika cover kosong

                    bookElement.innerHTML = `
                        <a href="/dashboard/book_detail.php" class="flex flex-col items-center text-center">
                            <div class="w-50 h-50">
                                <img src="${coverImage}" alt="ini gambar" class="w-full h-full object-cover rounded-lg mb-2">
                            </div>
                            <div class="text-lg font-semibold judul">${book.title}</div>
                            <div class="text-sm text-gray-500 author">${book.author}</div>
                        </a>
                    `;

                    booksContainer.appendChild(bookElement);
                });

            } catch (error) {
                console.error("Error fetching books:", error);
            }
        }
        
        // Ini untuk API Search Book
        async function searchBooks(query) {
            try {
                const response = await fetch(`/api/search?q=${encodeURIComponent(query)}`);
                
                if (!response.ok) {
                    throw new Error("Gagal mencari buku");
                }

                const data = await response.json();

                const booksContainer = document.getElementById('booksContainer');
                booksContainer.innerHTML = '';

                data.forEach(result => {
                    const book = result.book;
                    const bookElement = document.createElement('div');
                    bookElement.className = 'p-4 bg-blue-300 rounded-lg shadow hover:shadow-xl transition-shadow';

                    const coverImage = book.cover || 'https://waifu2x.booru.pics/outfiles/891050a5d362d586dbf746b0420cf92563d40acb_s2_n3_y1.jpg'; // Gambar default jika cover kosong

                    bookElement.innerHTML = `
                        <a href="/dashboard/book_detail.php" class="flex flex-col items-center text-center">
                            <div class="w-50 h-50">
                                <img src="${coverImage}" alt="ini gambar" class="w-full h-full object-cover rounded-lg mb-2">
                            </div>
                            <div class="text-lg font-semibold judul">${book.title}</div>
                            <div class="text-sm text-gray-500 author">${book.author}</div>
                        </a>
                    `;

                    booksContainer.appendChild(bookElement);
                });

            } catch (error) {
                console.error("Error searching books:", error);
            }
        }

        document.getElementById('searchInput').addEventListener('input', (event) => {
            const query = event.target.value.trim();
            if (query) {
                searchBooks(query);
            } else {
                fetchBooks();
            }
        });

        document.addEventListener('DOMContentLoaded', fetchBooks);
    </script>

</body>
</html>