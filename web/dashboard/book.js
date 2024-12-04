var page = 1;
var query_g = "";

// Function to fetch books
async function fetchBooks(from = 0, range = 1) {
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
                            <img src="${coverImage}" alt="Cover Book" class="w-full h-full object-cover rounded-lg mb-2">
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

// Function to get search result count
async function searchBooksCount(query) {
    const response = await fetch(`/api/search?q=${encodeURIComponent(query)}`);
    if (!response.ok) {
        throw new Error("Gagal mencari buku");
    }
    const data = await response.json();
    return data.length;
}

// Function to search books
async function searchBooks(query, from, range) {
    query_g = query; // Ensure query_g is updated
    try {
        const response = await fetch(`/api/search?q=${encodeURIComponent(query)}&from=${from}&range=${range}`);
        if (!response.ok) {
            throw new Error("Gagal mencari buku");
        }

        const data = await response.json();
        const booksContainer = document.getElementById('booksContainer');
        booksContainer.innerHTML = '';

        if (data.length === 0) {
            booksContainer.innerHTML = `
                <div class="flex text-center text-white text-lg items-center">
                    Tidak ada buku yang ditemukan untuk pencarian "${query}".
                </div>`;
            return;
        }

        data.forEach(result => {
            const book = result.book;
            const bookElement = document.createElement('div');
            bookElement.className = 'p-4 bg-blue-300 rounded-lg shadow hover:shadow-xl transition-shadow';

            const coverImage = book.cover || '/src/cover.jpg';

            bookElement.innerHTML = `
                <a href="/dashboard/book_detail.php?id=${book.id}" class="flex flex-col items-center text-center">
                    <div class="w-50 h-50">
                        <img src="${coverImage}" alt="Cover Book" class="w-full h-full object-cover rounded-lg mb-2">
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

// Handle search input and button click
function handleSearchClick() {
    const query = document.getElementById('searchInput').value.trim();
    if (query) {
        query_g = query;
        searchBooks(query_g, page * 1, 1);
    }
}

// Search input event listener
document.getElementById('searchInput').addEventListener('input', (event) => {
    const query = event.target.value.trim();
    if (query) {
        query_g = query;
        searchBooks(query_g, page * 1, 1);
    } else {
        query_g = "";
        fetchBooks();
    }
});

// On page load
document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    query_g = urlParams.get('search') || urlParams.get('tag') || "";

    if (query_g) {
        document.getElementById('searchInput').value = query_g;
        searchBooks(query_g, page * 1, 1);
    } else {
        fetchBooks();
    }
});

// Pagination controls
const prev_button = document.getElementById("prev");
const refresh = document.getElementById("curr");
const next_button = document.getElementById("next");

prev_button.addEventListener("click", function () {
    if (page > 1) {
        page -= 1;
        refresh.innerHTML = page;
        const from = (page - 1) * 1;
        if (query_g) {
            searchBooks(query_g, from, 1);
        } else {
            fetchBooks(from, 1);
        }
    }
});

next_button.addEventListener("click", async function () {
    try {
        const response = await fetch(`/api/get_book_count`);
        const data = await response.json();
        let totalBooks = data.count;

        if (query_g) {
            totalBooks = await searchBooksCount(query_g);
        }

        if (page < Math.ceil(totalBooks / 1)) {
            page += 1;
            refresh.innerHTML = page;
            const from = (page - 1) * 1;

            if (query_g) {
                await searchBooks(query_g, from, 1);
            } else {
                await fetchBooks(from, 1);
            }
        }
    } catch (error) {
        console.error("Error in pagination:", error);
    }
});

