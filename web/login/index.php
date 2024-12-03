<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan UKDC</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style >
        body {
            font-family: 'Poppins', sans-serif;
            ;
        }
        input:-webkit-autofill {
            color: white !important;
            background-color: #3b82f6 !important;
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
</head>
<body>
<div class="bg-blue-800 font-bold font-['Poppins'] text-center text-4xl p-5 border-b-4 flex items-center justify-between">
        <div class="flex-1 text-white text-4xl text-center">
            PERPUSTAKAAN UKDC
        </div>
    </div>

    <div class="bg-blue-600 h-screen flex flex-col items-center justify-center text-center">
    <div class="bg-blue-500 rounded-xl shadow-lg p-8 w-full max-w-xs">
        <h1 class="p-5 text-3xl font-semibold text-white font-['Poppins']">LOGIN PERPUSTAKAAN UKDC</h1>
        
            <form id="loginForm" method="POST">
                <div>
                    <label for="npm" class="sr-only">NIM</label>
                    <input type="text" name="npm" id="npm" class="bg-blue-300 w-full p-2 text-xl rounded-xl 
                    border-white border-2 focus:border-blue-600 focus:outline-none text-gray-50 " 
                     placeholder="NIM" required>
                </div>
                <div class="mt-3">
                    <label for="password" class="sr-only">Password</label>
                    <input type="password" name="password" id="password" class="bg-blue-300 w-full p-2 text-xl 
                    rounded-xl border-white border-2 focus:border-blue-600 focus:outline-none text-white" 
                    placeholder="Password" required>
                </div>
                <div class="mt-2">
                    <label for="showPassword" class="flex items-center text-gray-50">
                        <input type="checkbox" id="showPassword" class="mr-2 ml-1 font-['Poppins']">
                        Tampilkan Kata Sandi
                    </label>
                </div>
                <button type="submit" class="bg-blue-400 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded mt-3 w-full transition-shadow duration-400 hover:shadow-2xl">
                    Login
                </button>
            </form>
            <p id="loginMessage" class="text-white mt-4"></p>
        </div>
    </div>

    <script>
        const showPassword = document.getElementById('showPassword');
        const passwordInput = document.getElementById('password');
        const npmInput = document.getElementById('npm');
        const loginForm = document.getElementById('loginForm');
        const loginMessage = document.getElementById('loginMessage');

        showPassword.addEventListener("change", (e) => {
            passwordInput.setAttribute("type", e.target.checked ? "text" : "password");
        });

        loginForm.addEventListener('submit', async function(event) {
            event.preventDefault();

            const id = npmInput.value;
            const password = passwordInput.value;

            try {
                const response = await fetch(`/api/auth_user?id=${id}&password=${password}`, {
                    method: 'GET',
                    headers: {
                        'Content-Type': 'application/json'
                    }
                });
                
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                
                const result = await response.json();
                console.log("API Response:", result);

                if (result.success === 1) {
                    window.location.href = '/dashboard/index.php'; 
                } else {
                    loginMessage.textContent = "Login gagal. Silakan periksa NIM dan Password Anda.";
                }
            } catch (error) {
                console.error("Error during login:", error);
                loginMessage.textContent = "Terjadi kesalahan saat mencoba login.";
            }
        });
    </script>
</body>
</html>