<?php
session_start();

$timeout_duration = 6000;

if (!isset($_SESSION['id'])) {
    header('Location: /login');
    exit();
}

if (isset($_SESSION['LAST_ACTIVITY'])) {
    if (time() - $_SESSION['LAST_ACTIVITY'] > $timeout_duration) {
        session_unset();
        session_destroy();
        header('Location: /login');
        exit();
    }
}

$_SESSION['LAST_ACTIVITY'] = time();

$books = [
    [
        'image' => 'https://waifu2x.booru.pics/outfiles/891050a5d362d586dbf746b0420cf92563d40acb_s2_n3_y1.jpg',
        'title' => 'Judul 1',
        'author' => 'Author 1'
    ],
    [
        'image' => 'https://waifu2x.booru.pics/outfiles/891050a5d362d586dbf746b0420cf92563d40acb_s2_n3_y1.jpg',
        'title' => 'Judul 2',
        'author' => 'Author 2'
    ],
    [
        'image' => 'https://waifu2x.booru.pics/outfiles/891050a5d362d586dbf746b0420cf92563d40acb_s2_n3_y1.jpg',
        'title' => 'Judul 3',
        'author' => 'Author 3'
    ],
    [
        'image' => 'https://waifu2x.booru.pics/outfiles/891050a5d362d586dbf746b0420cf92563d40acb_s2_n3_y1.jpg',
        'title' => 'Judul 4',
        'author' => 'Author 4'
    ],
    [
        'image' => 'https://waifu2x.booru.pics/outfiles/891050a5d362d586dbf746b0420cf92563d40acb_s2_n3_y1.jpg',
        'title' => 'Judul 5',
        'author' => 'Author 5'
    ],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

    <div class="bg-yellow-500 font-bold text-center text-4xl p-5 border-b-4 flex items-center justify-between">
        <div class="flex-1 text-white text-4xl text-center">
            Perpustakaan UKDC
        </div>
    </div>

    <div class="bg-blue-600 font-bold p-5 text-right">
        <form action="/dashboard/logout.php" method="POST">
            <button type="submit" class="bg-white text-blue-500 font-bold py-2 px-2 text-sm rounded">Logout</button>
        </form>
    </div>

    <div class="bg-blue-600 flex p-10 justify-center items-center -m-10">
        <input type="text" class="bg-blue-300 text-white w-1/2 p-2 text-xl rounded-xl 
            border-white border-2 focus:border-blue-600 focus:outline-none" placeholder="Telusuri">
        <a href="#" class="ml-3 text-2xl text-white">
            <i class="fas fa-search"></i>
        </a>
    </div>

    <div class="bg-blue-600">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4 p-4">
            <?php foreach ($books as $book): ?>
                <div class="p-4 bg-blue-300 rounded-lg shadow hover:shadow-xl transition-shadow">
                    <a href="../book_detail/index.html" class="flex flex-col items-center text-center">
                        <div class="w-50 h-50">
                            <img src="<?php echo htmlspecialchars($book['image']); ?>" alt="ini gambar" class="w-full h-full object-cover rounded-lg mb-2">
                        </div>
                        <div class="text-lg font-semibold judul"><?php echo htmlspecialchars($book['title']); ?></div>
                        <div class="text-sm text-gray-500 author"><?php echo htmlspecialchars($book['author']); ?></div>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="bg-blue-600 font-bold text-center text-2xl p-5 border-t-4 text-white font-['Poppins']">© Copyright IF UKDC 2023</div>

    <script>
        const timeoutDuration = <?php echo $timeout_duration; ?>;
        setTimeout(async () => {
            try {
                const response = await fetch('/api/auth_destroy', { method: 'POST'});

                if (!response.ok) {
                    throw new Error("Failed to destroy session");
                }

                alert("Sesi Anda telah habis. Silakan masuk lagi.");
                window.location.href = '/login';

            } catch (error) {
                console.error("Error destroying session:", error);
            }
            
        }, timeoutDuration * 1000);
    </script>

</body>
</html>