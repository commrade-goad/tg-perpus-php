let selectedTagIds = [];
let stringTags = '';
let tagNameMap = {};
let currentBookId;

function resetForm() {
    $('#add_book')[0].reset();
    selectedTagIds = [];
    $('.tag-btn').removeClass('bg-blue-700');
    $('#tag_ids').val('');
}

function openModal() {
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
    resetForm();
}

function openEditModal() {
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}



// Menampilkan buku
function loadBooks() {
    $.ajax({
        type: "GET",
        url: "/api/get_book",
        success: function(response) {
            $('#user-table-book tbody').empty();
            response.forEach(book => {
                addBookToTable(book);
            });
        },
        error: function(err) {
            console.error("Error loading books:", err);
            alert("Error loading books. Please try again.");
        }
    });
}

// Menambahkan Buku
function addBookToTable(book) {
    const tagNames = book.tags ? book.tags.map(tag => tag.name).join(', ') : '-';
    
    const userRow = `
    <tr class="border-b border-blue-600 hover:bg-blue-500 text-gray-50">
        <td class="px-4 py-2">${book.title || '-'}</td>
        <td class="px-4 py-2">${book.author || '-'}</td>
        <td class="px-4 py-2">${tagNames}</td>
        <td class="px-4 py-2">${book.year || '-'}</td>
        <td class="px-4 py-2">
            <button class="bg-blue-400 hover:bg-blue-700 px-2 py-1 rounded mr-2 mb-2" onclick="editBook(${book.id})">Edit</button>
            <button class="bg-blue-400 hover:bg-blue-700 px-2 py-1 rounded" onclick="deleteBook(${book.id})">Delete</button>
        </td>
    </tr>
    `;
    $('#user-table-book tbody').append(userRow);
}

$(document).ready(function() {
    // Load initial data
    loadBooks();

    // Fungsi untuk menangani pencarian
$("#search").on("input", function() {
    const searchQuery = $(this).val().toLowerCase(); // Ambil query pencarian dan ubah ke lowercase untuk pencarian tidak case-sensitive
    filterBooks(searchQuery); // Menyaring data buku berdasarkan query
});

// Fungsi untuk memfilter data buku berdasarkan query
function filterBooks(query) {
    const rows = $('#user-table-book tbody tr'); // Ambil semua baris buku di tabel
    rows.each(function() {
        const row = $(this);
        const title = row.find('td').eq(0).text().toLowerCase(); // Ambil kolom judul buku
        const author = row.find('td').eq(1).text().toLowerCase(); // Ambil kolom pengarang
        const tags = row.find('td').eq(2).text().toLowerCase(); // Ambil kolom tags (label buku)
        const year = row.find('td').eq(3).text().toLowerCase(); // Ambil kolom tahun penerbitan

        // Cek apakah title, author, tags, atau year cocok dengan query
        if (title.includes(query) || author.includes(query) || tags.includes(query) || year.includes(query)) {
            row.show(); // Tampilkan baris yang cocok
        } else {
            row.hide(); // Sembunyikan baris yang tidak cocok
        }
    });
}

    
    
    // Load tags
    $.ajax({
        type: "GET",
        url: "/api/get_tag/",
        success: function(response) {
            displayTags(response);
            response.forEach(tag => {
                tagNameMap[tag.id] = tag.name;
            });
        },
        error: function(err) {
            console.error("Error loading tags:", err);
            alert("Error fetching tags. Please try again.");
        }
    });

    // Function to display tags as clickable buttons
    function displayTags(tags) {
        const tagsContainer = $('#tagsContainer');
        tagsContainer.empty();

        tags.forEach(tag => {
            const tagButton = $(`<button type="button" class="tag-btn bg-blue-400 hover:bg-blue-600 text-white px-2 py-1 rounded m-1" data-id="${tag.id}">${tag.name}</button>`);
            
            tagButton.on('click', function(e) {
                e.preventDefault();
                const tagId = tag.id;
                $(this).toggleClass('bg-blue-700');
                toggleTagSelection(tagId);
            });

            tagsContainer.append(tagButton);
        });
    }

    function toggleTagSelection(tagId) {
        const index = selectedTagIds.indexOf(tagId);
        if (index === -1) {
            selectedTagIds.push(tagId);
        } else {
            selectedTagIds.splice(index, 1);
        }
        $('#tag_ids').val(selectedTagIds.join(' '));
    }


    // Handle form submission
    $("#add_book").submit(function(event) {
        event.preventDefault();
        
        // Create tag objects array from selected IDs
        const tagObjects = selectedTagIds.map(id => ({
            id: parseInt(id),
            name: tagNameMap[id]
            
         }));

         for (let i= 0; i < tagObjects.length; i++) {
            let tmp = tagObjects[i].id;
            stringTags = stringTags.concat(`${tmp} `);
         }
        
        // Gather form data
        var formData = {
            title: $("#title").val(),
            desc: $("#desc").val(),
            img: $("#img").val(),
            author: $("#author").val(),
            tags: stringTags,
            year: $("#year").val(),
            pos: $("#pos").val(),
            prodi: $("#prodi").val(),
       };
        
        // Log the data being sent
        console.log("Sending data:", formData);
        
        // AJAX request to add book
        $.ajax({
            type: "POST", // Menggunakan GET sesuai dengan API
            url: "/api/add_book/",
            data: formData,
            success: function(response) {
                console.log("Success response:", response);
                alert("Buku berhasil ditambahkan!");
                loadBooks(); // Reload the books table
                closeModal();
            },
            error: function(err) {
                console.error("Error adding book:", err);
                alert("Terjadi kesalahan. Silakan coba lagi.");
            }
        });
    });
});


// Edit Book
function editBook(id) {
    currentBookId = id;
    // Mengambil data buku berdasarkan ID
    $.ajax({
        type: "GET",
        url: `/api/get_book?id=${id}`, // URL API untuk mengambil data buku
        success: function(response) {
            // Mengisi data buku ke dalam form modal edit
            $('#edit_title').val(response.title);
            $('#edit_desc').val(response.desc);
            $('#edit_img').val(response.cover);
            $('#edit_author').val(response.author);
            $('#edit_year').val(response.year);
            $('#edit_pos').val(response.pos);
            $('#edit_prodi').val(response.prodi);

            // Reset dan persiapkan pemilihan tag
            selectedTagIds = []; // Kosongkan pilihan sebelumnya
            const editTagsContainer = $('#edit_tagsContainer');
            editTagsContainer.empty();

            // Memuat tag secara dinamis
            $.ajax({
                type: "GET",
                url: "/api/get_tag/",
                success: function(tagResponse) {
                    tagResponse.forEach(tag => {
                        const tagButton = $(`<button type="button" class="tag-btn bg-blue-400 hover:bg-blue-600 text-white px-2 py-1 rounded m-1" data-id="${tag.id}">${tag.name}</button>`);
                        
                        // Tambahkan event click untuk memilih tag
                        tagButton.on('click', function(e) {
                            e.preventDefault();
                            const tagId = tag.id;
                            $(this).toggleClass('bg-blue-700');
                            toggleTagSelection(tagId);
                        });

                        // Menambahkan tombol tag ke dalam container
                        editTagsContainer.append(tagButton);

                        // Pre-select tags untuk buku ini, memastikan tag yang sudah ada sebelumnya dipilih
                        if (response.tags && response.tags.some(t => t.id === tag.id)) {
                            tagButton.addClass('bg-blue-700');
                            // Hanya tambahkan tag jika belum ada di selectedTagIds
                            if (!selectedTagIds.includes(tag.id)) {
                                selectedTagIds.push(tag.id);
                            }
                        }
                    });
                },
                error: function(err) {
                    console.error("Error loading tags:", err);
                }
            });

            // Menampilkan modal edit
            openEditModal();
        },
        error: function(err) {
            console.error("Error loading book:", err);
            alert("Gagal memuat data buku. Silakan coba lagi.");
        }
    });
}

// Toggle tag selection
function toggleTagSelection(tagId) {
    // Cek jika tagId sudah ada di array selectedTagIds
    const index = selectedTagIds.indexOf(tagId);
    if (index === -1) {
        // Jika tidak ada, tambahkan tagId ke array
        selectedTagIds.push(tagId);
    } else {
        // Jika ada, hapus tagId dari array
        selectedTagIds.splice(index, 1);
    }

    // Update nilai tag_ids di input field
    $('#tag_ids').val(selectedTagIds.join(' '));
}

// Update tag selection based on selectedTagIds
function updateTagButtons(selectedTagIds) {
    $(".tag-btn").each(function() {
        const tagId = $(this).data("id");
        if (selectedTagIds.includes(tagId)) {
            $(this).addClass("bg-blue-700"); // Tambahkan kelas jika tag terpilih
        } else {
            $(this).removeClass("bg-blue-700"); // Hapus kelas jika tidak terpilih
        }
    });
}

$("#edit_book").submit(function(event) {
    event.preventDefault();

    // Menghapus tag ID yang duplikat sebelum mengirim data
    selectedTagIds = [...new Set(selectedTagIds)]; // Menghapus duplikat menggunakan Set

    // Membuat objek tag dengan ID dan nama tag
    const tagObjects = selectedTagIds.map(id => ({
        id: parseInt(id),
        name: tagNameMap[id] // Pastikan tagNameMap memiliki data yang valid
    }));

    // Membuat string untuk tags
    let stringTags = selectedTagIds.join(' '); // Menggunakan join untuk membuat string tag ID

    // Assuming 'id' is defined and holds the correct book ID
    const formData = {
        id: currentBookId, // Use 'id' passed from editBook function
        title: $("#edit_title").val(),
        desc: $("#edit_desc").val(),
        img: $("#edit_img").val(),
        author: $("#edit_author").val(),
        tags: stringTags, // Menggunakan stringTags yang sudah diformat
        year: $("#edit_year").val(),
        pos: $("#edit_pos").val(),
        prodi: $("#edit_prodi").val(),
    };

    // AJAX request to update book
    $.ajax({
        type: "POST",
        url: `/api/edit_book`,
        data: formData,
        success: function(response) {
            loadBooks(); // Reload books
            closeEditModal(); // Close modal
        },
        error: function(err) {
            console.error("Error updating book:", err);
            alert("Terjadi kesalahan saat memperbarui buku.");
        }
    });
});

function deleteBook(id) {
    const formData = {id: id};
    if (confirm("Apakah Anda yakin ingin menghapus buku ini?")) {
        $.ajax({
            type: "POST",
            url: `/api/del_book`,
            data: formData,
            success: function(response) {
                alert("Buku berhasil dihapus!");
                loadBooks();
            },
            error: function(err) {
                console.error("Error deleting book:", err);
                alert("Gagal menghapus buku. Silakan coba lagi.");
            }
        });
    }
}
