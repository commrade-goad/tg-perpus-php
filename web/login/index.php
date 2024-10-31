<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan UKDC</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        input:-webkit-autofill {
            color: white !important;
            background-color: #3b82f6 !important; /* Sesuaikan dengan warna latar belakang input Anda */
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body>
    <div class="bg-yellow-500 font-bold text-center text-4xl p-5 border-b-4 text-white">Perpustakaan UKDC</div>
    <div class="bg-blue-600 h-screen flex flex-col items-center justify-center text-center">
    <div class="bg-blue-500 rounded-xl shadow-lg p-8 w-full max-w-xs">
        <h1 class="p-5 text-3xl font-bold text-white">Login Perpustakaan UKDC</h1>
        
            <form action="/login/proses.php" method="POST">
                <div>
                    <label for="npm" class="sr-only">NIM</label>
                    <input type="text" name="npm" id="npm" class="bg-blue-300 w-full p-2 text-xl rounded-xl 
                    border-white border-2 focus:border-blue-600 focus:outline-none text-white" 
                     placeholder="NIM" required>
                </div>
                <div class="mt-3">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" name="password" id="password" class="bg-blue-300 w-full p-2 text-xl 
                    rounded-xl border-white border-2 focus:border-blue-600 focus:outline-none text-white" 
                    placeholder="Password" required>
                </div>
                <div class="mt-2">
                    <label for="showPassword" class="flex items-center text-gray-700 text-white">
                        <input type="checkbox" id="showPassword" class="mr-2 ml-1">
                        Tampilkan Kata Sandi
                    </label>
                </div>
                <button type="submit" class="bg-blue-600 text-white font-bold py-2 px-4 rounded mt-3 w-full transition-shadow duration-400 hover:shadow-2xl">
                    Login
                </button>
            </form>
        </div>
    </div>
    <!-- <div class="bg-blue-600 font-bold text-center text-2xl p-5 border-t-4 text-white">@Copyright UKDC IF23</div> -->

    <script>
    const showPassword = document.getElementById('showPassword');
    const passwordInput = document.getElementById('password');
    const npmInput = document.getElementById('npm');

    showPassword.addEventListener("change", (e) => {
        passwordInput.setAttribute("type", e.target.checked ? "text" : "password");
    });

    npmInput.setAttribute("title", "Masukkan NIM Anda");
    npmInput.oninvalid = function() {
        this.setCustomValidity("Mohon isi NIM Anda");
    };
    npmInput.oninput = function() {
        this.setCustomValidity("");
    };

    passwordInput.setAttribute("title", "Masukkan password Anda");
    passwordInput.oninvalid = function() {
        this.setCustomValidity("Mohon isi password Anda");
    };
    passwordInput.oninput = function() {
        this.setCustomValidity("");
    };
</script>

</body>
</html>