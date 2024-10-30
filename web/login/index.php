<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perpustakaan UKDC</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="bg-blue-500 font-bold text-center text-4xl p-5 border-b-4">Perpustakaan UKDC</div>
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
            rounded-xl border-white border-4 focus:border-white focus:outline-none" placeholder="NIM">
        </div>
        <div>
            <label for="password"></label>
            <input type="password" name="password" id="password" class="bg-blue-200 w-1/8 p-2 text-base border text-xl 
            rounded-xl border-white border-4 focus:border-white focus:outline-none mt-3" placeholder="Password">
        </div>
        <button type="submit" class="bg-white text-blue-500 font-bold py-2 px-4 rounded mt-3">
            Login
        </button>
        </form>
    </div>
    <div class="bg-blue-500 font-bold text-center text-2xl p-5 border-t-4">@Copyright UKDC IF23</div>

    <div>
        <label for=""></label>
    </div>
</body>
</html>