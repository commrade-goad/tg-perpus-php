var page = 0;
var data_len = 10;
var gquery = 0;
var max_page = 0;

// TODO: Make ?query or tag right so not broken when searching afterward

function render_book(book_arr) {
    const booksContainer = document.getElementById('booksContainer');
    booksContainer.innerHTML = '';
    book_arr.forEach(book => {
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
}

async function fetch_book(from, range) {
    const b = await fetch(`/api/get_book_count`).then(r => r.json());
    const a = fetch(`/api/get_book?from=${from}&range=${range}`)
    .then(response => response.json())
    .then(data => {
        render_book(data);
        max_page = b.count;
    })
    .catch(error => console.log(error));
}

async function fetch_search_book(query, from, range) {
    gquery = query;
    const c = await fetch(`/api/search?q=${encodeURIComponent(gquery)}`).then(r => r.json());
    const a = fetch(`/api/search?q=${encodeURIComponent(gquery)}&from=${from}&range=${range}`)
    .then(response => response.json())
    .then(data => {
        let new_arr = [];
        data.forEach(element => {
            new_arr.push(element.book);
        });
        max_page = c.length;
        if (data.length <= 0) {
            const booksContainer = document.getElementById('booksContainer');
            booksContainer.innerHTML = '';
            booksContainer.innerHTML = `
            <div class="flex text-center text-white text-lg items-center">
            Tidak ada buku yang ditemukan untuk pencarian "${gquery}".
            </div>`;
            return;
        }
        render_book(new_arr);
    })
    .catch(error => console.log(error));
}

function do_search() {
    const query = document.getElementById('searchInput').value.trim();
    if (query) {
        gquery = query;
        fetch_search_book(gquery, page * data_len, data_len);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    gquery = urlParams.get('query') || urlParams.get('tag') || "";

    if (gquery) {
        document.getElementById('searchInput').value = gquery;
        fetch_search_book(gquery, page * data_len, data_len);
    } else {
        if (page <= 0) {
            fetch_book(page, data_len);
        } else {
            fetch_book(page * data_len, data_len);
        }
    }
});

let debounceTimeout;
document.getElementById('searchInput').addEventListener('change', () => {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
        const query = document.getElementById('searchInput').value.trim();
        if (query === "") {
            if (page <= 0) {
                fetch_book(page, data_len);
            } else {
                fetch_book(page * data_len, data_len);
            }
        } else {
            do_search();
        }
    }, 400); // Adjust debounce time as needed
});

const prev_button = document.getElementById("prev");
const refresh = document.getElementById("curr");
const next_button = document.getElementById("next");

next_button.addEventListener("click", () => {
    if (page + 1 * data_len < max_page) {
        page += 1;
        if (gquery === "") {
            fetch_book(page * data_len, data_len);
        } else {
            fetch_search_book(gquery, page * data_len, data_len);
        }
        refresh.innerHTML = page + 1;
    }   
});

prev_button.addEventListener("click", () => {
    if (page > 0) {
        page -= 1;
        if (gquery === "") {
            fetch_book(page * data_len, data_len);
        } else {
            fetch_search_book(gquery, page * data_len, data_len);
        }
        refresh.innerHTML = page + 1;
    }   
});

// fetch_book(0, 10);
// fetch_search_book("cpp", 0, 2);
