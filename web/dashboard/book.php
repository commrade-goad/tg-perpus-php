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
            Perpustakaan UKDC
        </div>
    </div>

    <div class="bg-blue-600 font-bold p-5 text-right">
        <form action="/dashboard/logout.php" method="POST">
            <button type="submit" class="bg-white text-blue-500 font-bold py-2 px-2 text-sm rounded">Logout</button>
        </form>
    </div>

    <div class="bg-blue-600 flex p-10 justify-center items-center -m-10">
        <input type="text" id="searchInput" class="bg-blue-300 text-white w-1/2 p-2 text-xl rounded-xl 
            border-white border-2 focus:border-blue-600 focus:outline-none" placeholder="Telusuri">
        <a href="#" class="ml-3 text-2xl text-white">
            <i class="fas fa-search"></i>
        </a>
    </div>

    <div class="bg-blue-600">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 p-4" id="booksContainer">
            <?php foreach ($books as $book): ?>
                <div class="p-4 bg-blue-300 rounded-lg shadow hover:shadow-xl transition-shadow">
                    <a href="/dashboard/book_detail.php" class="flex flex-col items-center text-center">
                        <div class="w-50 h-50">
                            <img src="<?php echo htmlspecialchars($book['image'] ?: '/src/cover.jpg'); ?>" alt="ini gambar" class="w-full h-full object-cover rounded-lg mb-2">
                        </div>
                        <div class="text-lg font-semibold judul"><?php echo htmlspecialchars($book['title']); ?></div>
                        <div class="text-sm text-gray-500 author"><?php echo htmlspecialchars($book['author']); ?></div>
                    </a>
                </div>
            <?php endforeach; ?>
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

        // Ini untuk API ambil Buku dari DB
        async function fetchBooks() {
            try {
                const response = await fetch('/api/get_book?from=0&range=20&sort=ASC');

                const data = await response.json();

                const booksContainer = document.getElementById('booksContainer');
                booksContainer.innerHTML = '';

                data.forEach(book => {
                    const bookElement = document.createElement('div');
                    bookElement.className = 'p-4 bg-blue-300 rounded-lg shadow hover:shadow-xl transition-shadow';

                    const coverImage = book.cover || '/src/cover.jpg';

                    bookElement.innerHTML = `
                    <a href="#">
                    <div class="flex flex-col items-center text-center" book_id="${book.id}" id="sendThis">
                        <div class="w-50 h-50">
                            <img src="${coverImage}" alt="ini gambar" class="w-full h-full object-cover rounded-lg mb-2">
                        </div>
                        <div class="text-lg font-semibold judul">${book.title}</div>
                        <div class="text-sm text-gray-500 author">${book.author}</div>
                    </div>
                    </a>`;
                    
                    booksContainer.appendChild(bookElement);
                    const sendThis = document.querySelector(`[book_id="${book.id}"]`);
                    
                    if (sendThis) {
                        sendThis.addEventListener("click", () => {
                            const bookId = sendThis.getAttribute("book_id");
                            console.log("Clicked book with ID:", bookId);
                            window.location.href = `/dashboard/book_detail.php?id=${bookId}`;
                            });
                        };
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

                    const coverImage = book.cover || '/src/cover.jpg';

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