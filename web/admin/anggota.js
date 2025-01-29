let currentUserId; 

        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }
        
        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
            $('#add-user-form')[0].reset(); // Reset the form fields
        }
        function openEditModal() {
            document.getElementById('editModal').classList.remove('hidden');
            
        }
        // Menutup modal edit dan mereset form
        function closeEditModal() {
            document.getElementById("editModal").classList.add("hidden"); // Menyembunyikan modal
            $('#edit-user-form')[0].reset(); // Reset form setelah menutup modal
        }


// Fungsi untuk membuka modal dan mengisi data pengguna yang dipilih
function editUser(userId, tipe) {
    currentUserId = userId; // Menyimpan ID pengguna yang akan diedit
    document.getElementById("editModal").classList.remove("hidden"); // Menampilkan modal
    const modal_npm = document.getElementById('npm');
    const modal_tipe = document.getElementById('typeed');
    modal_npm.placeholder = currentUserId;
    modal_tipe.placeholder = tipe;

    // Mengambil data pengguna dari server
    $.ajax({
        type: "GET",
        url: `/api/get_user/index.php?id=${userId}`, // Ganti dengan endpoint yang benar untuk mendapatkan data pengguna
        
        success: function(response) {
            // Isi form dengan data pengguna
            $('#npm').val(response.npm);
            $('#password').val(''); // Jangan menampilkan password lama di form
            $('#type').val(response.type);
        },
        error: function(xhr, status, error) {
            console.error("Error:", status, error);
            alert("Terjadi kesalahan saat memuat data pengguna.");
        }
    });
}

// Fungsi untuk menangani pengeditan data pengguna
$("#edit-user-form").submit(function(event) {
    event.preventDefault(); // Mencegah pengiriman form default

    // Ambil data dari form
    const formData = {
        id: currentUserId, // ID pengguna yang sedang diedit
        password: $("#password-new").val(), // Password baru
    };

    // Mengirim data ke server untuk diperbarui
    $.ajax({
        type: "POST",  // Gunakan POST untuk update
        url: `/api/edit_user/index.php${currentUserId}`, // Ganti dengan endpoint yang benar untuk memperbarui data pengguna
        data: formData,
        success: function(response) {
            if (response.success) {
                alert("Pengguna berhasil diperbarui!");
                loadUsers(); // Memuat ulang daftar pengguna
                closeEditModal(); // Menutup modal
            } else {
                alert("Gagal memperbarui pengguna: " + response.message);
            }
        },
        error: function() {
            alert("Terjadi kesalahan saat memperbarui pengguna. Silakan coba lagi.");
        }
    });
});

// Fungsi untuk menutup modal

        
        function loadUsers(){
            const ut = document.getElementById(`user-table-body`);
            ut.innerHTML = '';
            
            $.ajax({
                    type: "GET",
                    url: "/api/get_user/index.php",
                    success: function(response) {
                        // addUserToTable(formData);
                        // closeModal();
                        for (let i = 0; i < response.length; i++) {
                                let tmp = response[i];
                                addUserToTable(tmp);
                                closeModal();
                            }
                    },
                    error: function() {
                        alert("Terjadi kesalahan. Silakan coba lagi.");
                    }
                });
        }
        
        $(document).ready(function() {
            loadUsers();
            

                // Fungsi untuk menangani pencarian
    $("#search").on("input", function() {
        const searchQuery = $(this).val().toLowerCase(); // Ambil query pencarian dan ubah ke lowercase untuk pencarian tidak case-sensitive
        filterUsers(searchQuery); // Menyaring data pengguna berdasarkan query
    });

    // Fungsi untuk memfilter data pengguna berdasarkan query
    function filterUsers(query) {
        const rows = $('#user-table-body tr'); // Ambil semua baris pengguna di tabel
        rows.each(function() {
            const row = $(this);
            const npm = row.find('td').eq(0).text().toLowerCase(); // Ambil kolom NPM
            const type = row.find('td').eq(1).text().toLowerCase(); // Ambil kolom Tipe

            // Cek apakah NPM atau Type cocok dengan query
            if (npm.includes(query) || type.includes(query)) {
                row.show(); // Tampilkan baris yang cocok
            } else {
                row.hide(); // Sembunyikan baris yang tidak cocok
            }
        });
    }


            $("#add-user-form").submit(function(event) {
                event.preventDefault(); // Prevent default form submission
                
                // Gather form data
                var formData = {
                    id: $("#id").val(),
                    password: $("#password").val(),
                    type: $("#type").val(),
                };
                
                // AJAX request to add user
                $.ajax({
                    type: "POST",
                    url: "/api/add_user/.index.php",
                    data: formData,
                    success: function(response) {
                        console.log(formData);
                        addUserToTable(formData);
                        loadUsers();
                        closeModal();
                    },
                    error: function() {
                        alert("Terjadi kesalahan. Silakan coba lagi.");
                    }
                });
            });
        });
        
        function addUserToTable(user) {
    const userRow = `
    <tr id="user-row-${user.id}" class="border-b-2 border-blue-600 hover:bg-blue-500 text-gray-50">
        <td class="px-4 py-2">${user.id}</td>
        <td class="px-4 py-2">${user.type}</td>
        <td class="px-4 py-2">
            <button class="bg-blue-400 hover:bg-blue-700 px-2 py-1 rounded mr-2" onclick="editUser(${user.id}, ${user.type})" data-user-id="${user.id}">Edit</button>
            <button class="bg-blue-400 hover:bg-blue-700 px-2 py-1 rounded" onclick="deleteUser(${user.id})">Delete</button>
        </td>
    </tr>
    `;
    $('#user-table tbody').append(userRow); // Tambahkan baris pengguna baru
}


function deleteUser(userId) {
    if (confirm("Apakah Anda yakin ingin menghapus pengguna ini?")) {
        $.ajax({
            type: "POST", // Menggunakan POST jika DELETE tidak diizinkan
            url: `/api/del_user/index.php`, // Endpoint penghapusan user
            data: { id: userId }, // Kirim data ID user
            success: function(response) {
                if (response.success) { // Pastikan respons API menunjukkan keberhasilan
                    $(`#user-row-${userId}`).remove(); // Hapus baris dari tabel
                    alert("Pengguna berhasil dihapus!");
                } else {
                    alert("Gagal menghapus pengguna: " + response.message);
                }
                loadUsers(); // Refresh tabel
            },
            error: function(err) {
                console.error("Error deleting user:", err);
                alert("Terjadi kesalahan saat menghapus pengguna. Silakan coba lagi.");
            }
        });
    }
}

