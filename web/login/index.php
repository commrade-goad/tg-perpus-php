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
    </style>
</head>
<body>
<<<<<<< HEAD
    <div class="bg-blue-500 font-bold text-center text-4xl p-5 border-b-4">Perpustakaan UKDC</div>
    <div class="bg-blue-500 h-screen flex flex-col items-center justify-center text-center">
    <div class="bg-blue-400 rounded-xl shadow-lg p-8 w-full max-w-xs">
        <h1 class="p-5 text-3xl font-bold text-white">Login Perpustakaan UKDC</h1>
        
            <form action="/login/proses.php" method="POST">
                <div>
                    <label for="npm" class="sr-only">NIM</label>
                    <input type="text" name="npm" id="npm" class="bg-blue-200 w-full p-2 text-base border text-xl rounded-xl border-white border-4 focus:border-blue-500 focus:outline-none" placeholder="NIM" required>
                </div>
                <div class="mt-3">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" name="password" id="password" class="bg-blue-200 w-full p-2 text-base border text-xl rounded-xl border-white border-4 focus:border-blue-500 focus:outline-none" placeholder="Password" required>
                </div>
                <div class="mt-2">
                    <label for="showPassword" class="flex items-center text-gray-700">
                        <input type="checkbox" id="showPassword" class="mr-2 ml-1">
                        Tampilkan Kata Sandi
                    </label>
                </div>
                <button type="submit" class="bg-blue-500 text-white font-bold py-2 px-4 rounded mt-3 w-full transition-shadow duration-400 hover:shadow-2xl">
                    Login
                </button>
            </form>
        </div>
=======
    <div class="bg-blue-500 h-screen flex-row text-center content-center">
        <div>
            <h1 class="p-5 text-3xl font-bold text-white">
                Login Perpustakaan UKDC
            </h1>
        </div>
        <form action="/login/proses.php" method="POST">
            <div>
                <label for="npm"></label>
                <input type="text" name="npm" id="npm" class="bg-blue-200 w-1/8 p-2 text-base border text-xl 
                rounded-xl border-white border-4 focus:border-white focus:outline-none shadow-lg" placeholder="NIM">
            </div>
            <div>
                <label for="password"></label>
                <input type="password" name="password" id="password" class="bg-blue-200 w-1/8 p-2 text-base border text-xl 
                rounded-xl border-white border-4 focus:border-white focus:outline-none mt-3 shadow-lg" placeholder="Password">
                <div class="p-5">
                    <label for="showPassword" class="text-white font-medium">
                        <input type="checkbox" id="showPassword" class="w-4 h-4"> Tampilkan Kata Sandi
                    </label>
                </div>
            </div>
            <button type="submit" class="bg-white text-blue-500 font-bold py-2 px-4 rounded mt-3 
            transition transform hover:scale-105 hover:shadow-lg">
                Login
            </button>
        </form>
>>>>>>> 462abab94a5e6c8fdc513783e3017719a851bf74
    </div>
    <div class="bg-blue-500 font-bold text-center text-2xl p-5 border-t-4 ">@Copyright UKDC IF23</div>

    <script>
        const showPassword = document.getElementById('showPassword');
        const passwordInput = document.getElementById('password');

        showPassword.addEventListener("change", (e) => {
            passwordInput.setAttribute("type", e.target.checked ? "text" : "password");
        });
    </script>
</body>
</html>