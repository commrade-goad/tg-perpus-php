var page = 0;
var data_len = 10;
var gquery = 0;
var max_page = 0;

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
            label.className = 'flex items-center px-4 py-2';
            label.innerHTML = `
                <input type="checkbox" value="${tag.id}" class="mr-2" onchange="updateSelectedTags(this)">
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
        const response = await fetch('/api/get_book/');
        const prodis = await response.json();
        console.log('Prodi data:', prodis); // Debug output
        const dropdownProdiMenu = document.getElementById('dropdownProdiMenu');
        dropdownProdiMenu.innerHTML = '';

        prodis.forEach(prodi => {
            const label = document.createElement('label');
            label.className = 'flex items-center px-4 py-2';
            label.innerHTML = `
                <input type="checkbox" value="${prodi.id}" class="mr-2 item" onchange="updateSelectedProdi(this)">
                ${prodi.name}
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

async function fetch_get_book_from_id(query, from, range) {
    gquery = query;
    const c = await fetch(`/api/get_book_from_tag?id=${encodeURIComponent(gquery)}`).then(r => r.json());
    const a = fetch(`/api/get_book_from_tag?id=${encodeURIComponent(gquery)}&from=${from}&range=${range}`)
    .then(response => response.json())
    .then(data => {
        let new_arr = [];
        data.forEach(element => {
            new_arr.push(element);
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
    // TODO: make get('tag') use the get_book_from_tag api
    //gquery = urlParams.get('query') || urlParams.get('tag') || "";
    gquery = urlParams.get('query');
    if (gquery == null) {
        gquery = urlParams.get('tag');
        if (gquery) {
            document.getElementById('searchInput').value = gquery;
            fetch_get_book_from_id(gquery, page * data_len, data_len);
        } else {
            if (page <= 0) {
                fetch_book(page, data_len);
            } else {
                fetch_book(page * data_len, data_len);
            }
        }
    } else {
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
