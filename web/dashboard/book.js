const state = {
    page: 0,
    itemsPerPage: 6,
    maxPage: 0,
    originalData: [],
    filteredData: [],
    selectedProdi: [],
    selectedTags: [],
    searchQuery: '',
    useTag: false,
};

const DOM = {
    booksContainer: document.getElementById('booksContainer'),
    searchInput: document.getElementById('searchInput'),
    noBook: document.getElementById('no-book'),
    dropdownProdiButton: document.getElementById('dropdownProdiButton'),
    dropdownProdiMenu: document.getElementById('dropdownProdiMenu'),
    dropdownTagButton: document.getElementById('dropdownTagButton'),
    dropdownTagMenu: document.getElementById('dropdownTagMenu'),
    pagination: {
        prev: document.getElementById('prev'),
        current: document.getElementById('curr'),
        next: document.getElementById('next')
    },
    applyFilter: document.getElementById('apply-filter')
};

// Book rendering functions
const BookRenderer = {
    renderBooks(books) {
        DOM.booksContainer.innerHTML = '';
        books.forEach(book => this.createBookElement(book));
    },

    createBookElement(book) {
        const bookElement = document.createElement('div');
        bookElement.className = 'p-4 bg-blue-300 rounded-lg shadow hover:shadow-xl transition-shadow';
        
        const coverImage = book.cover || '/src/cover.jpg';

        bookElement.innerHTML = `
            <a href="book_detail.php?id=${book.id}">
                <div class="flex flex-col items-center text-center h-full" book_id="${book.id}" id="sendThis">
                    <div class="w-[100%] h-[100%] overflow-hidden">
                        <img src="${coverImage}" alt="Cover Book" class="w-full h-full object-cover rounded-lg mb-2">
                    </div>
                    <div class="flex flex-col flex-grow">
                        <div class="mt-auto">
                            <div class="text-lg font-semibold judul">${book.title}</div>
                            <div class="text-sm text-gray-500 author">${book.author}</div>
                        </div>
                    </div>
                </div>
            </a>
        `;

        DOM.booksContainer.appendChild(bookElement);
    }
};

// Dropdown functionality
function setupDropdowns() {
    // Prodi dropdown toggle
    DOM.dropdownProdiButton.addEventListener('click', () => {
        const display = DOM.dropdownProdiMenu.style.display;
        DOM.dropdownProdiMenu.style.display = display === 'none' || display === '' ? 'block' : 'none';
    });

    // Tag dropdown toggle
    DOM.dropdownTagButton.addEventListener('click', () => {
        const display = DOM.dropdownTagMenu.style.display;
        DOM.dropdownTagMenu.style.display = display === 'none' || display === '' ? 'block' : 'none';
    });

    // Close dropdowns when clicking outside
    window.addEventListener('click', (event) => {
        if (!event.target.matches('#dropdownProdiButton') && !DOM.dropdownProdiMenu.contains(event.target)) {
            DOM.dropdownProdiMenu.style.display = 'none';
        }
        if (!event.target.matches('#dropdownTagButton') && !DOM.dropdownTagMenu.contains(event.target)) {
            DOM.dropdownTagMenu.style.display = 'none';
        }
    });
}

// Update functions for selections
function updateSelectedProdi(checkbox) {
    const value = checkbox.value;
    if (checkbox.checked) {
        state.selectedProdi.push(value);
    } else {
        state.selectedProdi = state.selectedProdi.filter(item => item !== value);
    }
    console.log('Selected Prodi:', state.selectedProdi);
}

function updateSelectedTags(checkbox) {
    const value = checkbox.value;
    if (checkbox.checked) {
        state.selectedTags.push(value);
    } else {
        state.selectedTags = state.selectedTags.filter(item => item !== value);
    }
    console.log('Selected Tags:', state.selectedTags);
}

// Fetch functions for dropdowns
async function fetchTags() {
    try {
        const response = await fetch('/api/get_tag/index.php');
        const tags = await response.json();
        
        DOM.dropdownTagMenu.innerHTML = '';
        tags.forEach(tag => {
            const label = document.createElement('label');
            label.className = 'flex items-center px-4 py-2 overflow-hidden';
            const status = state.searchQuery == tag.id ? "checked" : "";
            label.innerHTML = `
                <input type="checkbox" value="${tag.id}" class="mr-2" onchange="updateSelectedTags(this)" ${status}>
                ${tag.name}
            `;
            DOM.dropdownTagMenu.appendChild(label);
        });
    } catch (error) {
        console.error('Error fetching tags:', error);
    }
}

async function fetchProdi() {
    try {
        const response = await fetch('/api/get_prodi/index.php');
        const prodis = await response.json();
        
        DOM.dropdownProdiMenu.innerHTML = '';
        prodis.forEach(prodi => {
            const label = document.createElement('label');
            label.className = 'flex items-center px-4 py-2 overflow-hidden';
            label.innerHTML = `
                <input type="checkbox" value="${prodi}" class="mr-2 item" onchange="updateSelectedProdi(this)">
                ${prodi}
            `;
            DOM.dropdownProdiMenu.appendChild(label);
        });
    } catch (error) {
        console.error('Error fetching prodi:', error);
    }
}

// Data management functions
const DataManager = {
    async initialize() {
        const urlParams = new URLSearchParams(window.location.search);
        const searchQuery = urlParams.get('search');
        const tagQuery = urlParams.get('tag');

        if (searchQuery) {
            state.searchQuery = searchQuery;
            DOM.searchInput.value = searchQuery;
            await this.fetchSearchResults(searchQuery);
        } else if (tagQuery) {
            await this.fetchBooksByTag(tagQuery);
            state.useTag = true;
        } else {
            await this.fetchAllBooks();
        }

        this.updatePagination();
    },

    async fetchAllBooks() {
        try {
            const response = await fetch('/api/get_book/index.php');
            state.originalData = await response.json();
            state.filteredData = [...state.originalData];
            DOM.noBook.innerHTML = "";
            this.renderCurrentPage();
        } catch (error) {
            console.error('Error fetching books:', error);
        }
    },

    async fetchBooksByTag(tag) {
        try {
            const response = await fetch(`/api/get_book_from_tag/index.php?id=${encodeURIComponent(tag)}`);
            state.originalData = await response.json();
            state.filteredData = [...state.originalData];
            DOM.noBook.innerHTML = "";
            if (state.filteredData.length <= 0) {
                DOM.noBook.innerHTML = `Buku yang kamu cari tidak ada.`;
            }
            this.renderCurrentPage();
        } catch (error) {
            console.error('Error fetching books by tag:', error);
        }
    },

    async fetchSearchResults(query) {
        try {
            const response = await fetch(`/api/search/index.php?q=${encodeURIComponent(query)}`);
            const results = await response.json();
            state.originalData = results.map(item => item.book);
            state.filteredData = [...state.originalData];
            DOM.noBook.innerHTML = "";
            if (state.filteredData.length <= 0) {
                DOM.noBook.innerHTML = `Buku yang kamu cari tidak ada.`;
            }
            this.renderCurrentPage();
        } catch (error) {
            console.error('Error fetching search results:', error);
        }
    },

    renderCurrentPage() {
        const startIndex = state.page * state.itemsPerPage;
        const endIndex = startIndex + state.itemsPerPage;
        const currentPageData = state.filteredData.slice(startIndex, endIndex);
        BookRenderer.renderBooks(currentPageData);
        this.updatePagination();
    },

    updatePagination() {
        state.maxPage = Math.ceil(state.filteredData.length / state.itemsPerPage);
        DOM.pagination.current.innerHTML = state.page + 1;
        
        // Update button states
        DOM.pagination.prev.disabled = state.page === 0;
        DOM.pagination.next.disabled = state.page >= state.maxPage - 1;
    },

    async applyFilters() {
        DOM.noBook.innerHTML = "";
        if (state.useTag) {
            await DataManager.fetchAllBooks();
            state.useTag = false;
            this.applyFilters();
        }
        if (state.selectedProdi.length === 0 && state.selectedTags.length === 0) {
            state.filteredData = [...state.originalData];
            this.renderCurrentPage();
            return;
        }

        state.filteredData = [];

        for (const book of state.originalData) {
            let found = false;

            if (state.selectedTags.length > 0) {
                for (const tag of book.tags) {
                    console.log(tag, state.selectedTags);
                    if (state.selectedTags.includes(String(tag.id))) {
                        found = true;
                        break;
                    }
                }
            }

            // Check prodi if any prodi is selected
            if (!found && state.selectedProdi.length > 0) {
                if (state.selectedProdi.includes(book.prodi)) {
                    found = true;
                }
            }

            // Add book to filtered data if it matches any filter
            if (found) {
                state.filteredData.push(book);
            }
        }
        state.page = 0;
        if (state.filteredData.length <= 0) {
                DOM.noBook.innerHTML = `Buku yang kamu cari tidak ada.`;
                console.log(state.filteredData);
        }
        this.renderCurrentPage();
    }
};

// Event handlers
function setupEventListeners() {
    // Pagination events
    DOM.pagination.next.addEventListener('click', () => {
        if (state.page < state.maxPage - 1) {
            state.page++;
            DataManager.renderCurrentPage();
        }
    });

    DOM.pagination.prev.addEventListener('click', () => {
        if (state.page > 0) {
            state.page--;
            DataManager.renderCurrentPage();
        }
    });

    // Search input with debouncing
    let debounceTimeout;
    DOM.searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimeout);
        debounceTimeout = setTimeout(async () => {
            const query = DOM.searchInput.value.trim();
            if (query === '') {
                await DataManager.fetchAllBooks();
            } else {
                await DataManager.fetchSearchResults(query);
            }
        }, 400);
    });

    // Filter application
    DOM.applyFilter.addEventListener('click', () => {
        DataManager.applyFilters();
    });

    // Setup dropdowns
    setupDropdowns();
}

// Initialize the application
document.addEventListener('DOMContentLoaded', () => {
    setupEventListeners();
    DataManager.initialize();
    fetchTags();
    fetchProdi();
});
