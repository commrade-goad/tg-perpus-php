var page = 0;
var data_len = 10;
var gquery = 0;
var max_page = 0;
var gbook_data = [];
var full_book_data = [];

// Dropdown functionality for Prodi
document.getElementById('dropdownProdiButton').addEventListener('click', function() {
    const dropdownProdiMenu = document.getElementById('dropdownProdiMenu');
    dropdownProdiMenu.style.display = dropdownProdiMenu.style.display === 'none' || dropdownProdiMenu.style.display === '' ? 'block' : 'none';
});

let selectedProdi = []; // Variabel untuk menyimpan Prodi yang dipilih

function updateSelectedProdi(checkbox) {
    const value = checkbox.value;
    if (checkbox.checked) {
        selectedProdi.push(value);
    } else {
        selectedProdi = selectedProdi.filter(item => item !== value);
    }
    console.log('Selected Prodi:', selectedProdi); // Handle nilai yang dipilih sesuai kebutuhan
}

// Dropdown functionality for Tags
document.getElementById('dropdownTagButton').addEventListener('click', function() {
    const dropdownTagMenu = document.getElementById('dropdownTagMenu');
    dropdownTagMenu.style.display = dropdownTagMenu.style.display === 'none' || dropdownTagMenu.style.display === '' ? 'block' : 'none';
});

// Close dropdowns if clicked outside
window.addEventListener('click', function(event) {
    const dropdownProdiMenu = document.getElementById('dropdownProdiMenu');
    const dropdownTagMenu = document.getElementById('dropdownTagMenu');
    if (!event.target.matches('#dropdownProdiButton') && !dropdownProdiMenu.contains(event.target)) {
        dropdownProdiMenu.style.display = 'none';
    }
    if (!event.target.matches('#dropdownTagButton') && !dropdownTagMenu.contains(event.target)) {
        dropdownTagMenu.style.display = 'none';
    }
});

let selectedTags = [];

function updateSelectedTags(checkbox) {
    const value = checkbox.value;
    if (checkbox.checked) {
        selectedTags.push(value);
    } else {
        selectedTags = selectedTags.filter(item => item !== value);
    }
    console.log('Selected Tags:', selectedTags); // Handle selected values as needed
}

// Fungsi untuk mendapatkan data Tag
async function fetchTags() {
    try {
        const response = await fetch('/api/get_tag/');
        const tags = await response.json();
        const dropdownTagMenu = document.getElementById('dropdownTagMenu');
        dropdownTagMenu.innerHTML = ''; // Kosongkan konten sebelumnya

        tags.forEach(tag => {
            const label = document.createElement('label');
            label.className = 'flex items-center px-4 py-2 overflow-hidden';
            const status = gquery == tag.id ? "checked" : "";
            label.innerHTML = `
                <input type="checkbox" value="${tag.id}" class="mr-2" onchange="updateSelectedTags(this)" ${status}>
                ${tag.name}
            `;
            dropdownTagMenu.appendChild(label);
        });
    } catch (error) {
        console.error('Error fetching tags:', error);
    }
}

async function fetchProdi() {
    try {
        const response = await fetch('/api/get_prodi');
        const prodis = await response.json();
        const dropdownProdiMenu = document.getElementById('dropdownProdiMenu');
        dropdownProdiMenu.innerHTML = '';

        prodis.forEach(prodi => {
            const label = document.createElement('label');
            label.className = 'flex items-center px-4 py-2 overflow-hidden';
            label.innerHTML = `
                <input type="checkbox" value="${prodi}" class="mr-2 item" onchange="updateSelectedProdi(this)">
                ${prodi}
            `;
            dropdownProdiMenu.appendChild(label);
        });
    } catch (error) {
        console.error('Error fetching prodi:', error);
    }
}

// Panggil fungsi saat DOM selesai dimuat
document.addEventListener('DOMContentLoaded', () => {
    fetchTags();
    fetchProdi();
});

// Function to render books
function render_book(book_arr) {
    const booksContainer = document.getElementById('booksContainer');
    booksContainer.innerHTML = '';
    book_arr.forEach(book => {
        const bookElement = document.createElement('div');
        bookElement.className = 'p-4 bg-blue-300 rounded-lg shadow hover:shadow-xl transition-shadow';

        var coverImage = book.cover
        if (coverImage === "" || null) {
            '/src/cover.jpg'
        };

        bookElement.innerHTML = `
        <a href="book_detail.php?id=${book.id}">
            <div class="flex flex-col items-center text-center h-full" book_id="${book.id}" id="sendThis">
                <div class="w-[100%] h-[100%] overflow-hidden">
                    <img src="${coverImage}" alt="Cover Book" class="w-full h-full object-cover rounded-lg mb-2">
                </div>
                <!-- Ensure this container stretches and pushes mt-auto div to the bottom -->
                <div class="flex flex-col flex-grow">
                    <div class="mt-auto">
                        <div class="text-lg font-semibold judul">${book.title}</div>
                        <div class="text-sm text-gray-500 author">${book.author}</div>
                    </div>
                </div>
            </div>
        </a>
        `;

        booksContainer.appendChild(bookElement);
    });
}

// Function to render current page of books
function render_current_page() {
    const start = page * data_len;
    const end = start + data_len;
    const books_to_render = gbook_data.slice(start, end);
    render_book(books_to_render);
}

// Fetch all books and store in global variable
async function fetch_all_books() {
    try {
        const response = await fetch(`/api/get_book_count`);
        const book_count = await response.json();
        max_page = book_count.count;

        const all_books_response = await fetch(`/api/get_book`);
        full_book_data = await all_books_response.json();

        gbook_data = full_book_data; // Initially set global data to all books
        render_current_page();
    } catch (error) {
        console.error('Error fetching all books:', error);
    }
}

// Fetch all books from a tag and store in global variable
async function fetch_all_books_from_tag(tag) {
    try {
        const response = await fetch(`/api/get_book_from_tag?id=${encodeURIComponent(tag)}`);
        full_book_data = await response.json();
        gbook_data = full_book_data; // Set global data to books from tag
        max_page = gbook_data.length;
        render_current_page();
    } catch (error) {
        console.error('Error fetching books from tag:', error);
    }
}

// Fetch all search results and store in global variable
async function fetch_all_search_results(query) {
    gquery = query;
    try {
        const response = await fetch(`/api/search?q=${encodeURIComponent(gquery)}`);
        full_book_data = await response.json();
        gbook_data = full_book_data.map(item => item.book); // Extract books from search results
        max_page = gbook_data.length;
        render_current_page();
    } catch (error) {
        console.error('Error fetching search results:', error);
    }
}

function do_search() {
    const query = document.getElementById('searchInput').value.trim();
    if (query) {
        gquery = query;
        fetch_all_search_results(gquery);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const urlParams = new URLSearchParams(window.location.search);
    const query = urlParams.get('query');
    const tag = urlParams.get('tag');
    
    if (query) {
        document.getElementById('searchInput').value = query;
        fetch_all_search_results(query);
    } else if (tag) {
        fetch_all_books_from_tag(tag);
    } else {
        fetch_all_books();
    }
});

let debounceTimeout;
document.getElementById('searchInput').addEventListener('change', () => {
    clearTimeout(debounceTimeout);
    debounceTimeout = setTimeout(() => {
        const query = document.getElementById('searchInput').value.trim();
        if (query === "") {
            fetch_all_books();
        } else {
            do_search();
        }
    }, 400); // Adjust debounce time as needed
});

const prev_button = document.getElementById("prev");
const refresh = document.getElementById("curr");
const next_button = document.getElementById("next");
const ap_fil = document.getElementById("apply-filter");

next_button.addEventListener("click", () => {
    if ((page + 1) * data_len < max_page) {
        page += 1;
        render_current_page();
        refresh.innerHTML = page + 1;
    }   
});

prev_button.addEventListener("click", () => {
    if (page > 0) {
        page -= 1;
        render_current_page();
        refresh.innerHTML = page + 1;
    }   
});

ap_fil.addEventListener("click", () => {
    const booksContainer = document.getElementById('booksContainer');
    booksContainer.innerHTML = '';

    if (selectedProdi.length == 0 && selectedTags == 0) {
        render_book(gbook_data);
    }

    let nbook = [];

    for (let i = 0; i < gbook_data.length; i++) {
        let found = false;
        for (const el of gbook_data[i].tags) {
            if (selectedTags.includes(String(el.id))) {
                found = true;
                break;
            }
        }
        if (!found && selectedProdi.includes(gbook_data[i].prodi)) {
            found = true;
        }
        if (found) {
            nbook.push(gbook_data[i]);
        }
    }

    if (selectedTags.length > 0 && selectedProdi.length === 0 ||
                selectedProdi.length > 0 && selectedTags.length === 0) {
        render_book(nbook);
    }
});
