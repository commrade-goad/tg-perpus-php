var page = 1;

// Ini untuk API ambil Buku dari DB
async function fetchBooks(from = 0, range = 10) {
    try {
        const response = await fetch(`/api/get_book?from=${from}&range=${range}&sort=ASC`);

        const data = await response.json();

        const booksContainer = document.getElementById('booksContainer');
        booksContainer.innerHTML = '';

        data.forEach(book => {
            const bookElement = document.createElement('div');
            bookElement.className = 'p-4 bg-blue-300 rounded-lg shadow hover:shadow-xl transition-shadow';

            const coverImage = book.cover || '/src/cover.jpg';

            bookElement.innerHTML = `
                <a href="book_detail.php?id=${book.id}">
                    <div class="flex flex-col items-center text-center" book_id="${book.id}" id="sendThis">
                        <div class="w-50 h-50">
                            <img src="${coverImage}" alt="ini gambar" class="w-full h-full object-cover rounded-lg mb-2">
                        </div>
                        <div class="text-lg font-semibold judul">${book.title}</div>
                        <div class="text-sm text-gray-500 author">${book.author}</div>
                    </div>
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

        // Kalau Bukunya tidak ada
        if (data.length === 0) {
            booksContainer.innerHTML = `
                <div class="flex text-center text-white text-lg items-center">
                    Tidak ada buku yang ditemukan untuk pencarian "${query}".
                </div>`
            return;
        }

        // Menampilkan hasil dari AJAX search
        data.forEach(result => {
            const book = result.book;
            const bookElement = document.createElement('div');
            bookElement.className = 'p-4 bg-blue-300 rounded-lg shadow hover:shadow-xl transition-shadow';

            const coverImage = book.cover || '/src/cover.jpg';

            bookElement.innerHTML = `
                <a href="/dashboard/book_detail.php?id=${book.id}" class="flex flex-col items-center text-center">
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

// Mengambil data dari /dashboard/index.php apabila search akan sesuai pada book.php
function handleSearchClick() {
    const query = document.getElementById('searchInput').value.trim();
    if (query) {
        searchBooks(query);
    }
}

// Ajax Search
document.getElementById('searchInput').addEventListener('input', (event) => {
    const query = event.target.value.trim();
    if (query) {
        searchBooks(query);
    } else {
        fetchBooks();
    }
});

// Menampilkan search buku dari tag
document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const query = urlParams.get('search');
    const tag = urlParams.get('tag'); // Dapatkan parameter tag jika ada

    if (query) {
        document.getElementById('searchInput').value = query;
        searchBooks(query);
    } else if (tag) {
        document.getElementById('searchInput').value = tag;
        searchBooks(tag); // Lakukan pencarian berdasarkan tag
    } else {
        fetchBooks();
    }
});

const prev_button = document.getElementById("prev");
const refresh = document.getElementById("curr");
const next_button = document.getElementById("next");

prev_button.addEventListener("click", function () {
    if (page > 1) {
        page -= 1;
        refresh.innerHTML = page;
        let from = (page - 1) * 10;
        fetchBooks(from, 10);
    }
});

next_button.addEventListener("click", function () {
    console.log("Click");
    fetch(`/api/get_book_count`)
        .then(response => response.json())
        .then(data => {
            refresh.innerHTML = page + 1;
            if (page * 1 < data.count) {
                page += 1;
                let from = (page - 1) * 10;
                fetchBooks(from, 10);
            }
        });
});
