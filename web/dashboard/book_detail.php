<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Buku</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <div class="bg-yellow-500 font-bold text-center text-4xl p-5 border-b-4 flex items-center justify-between">
        <div class="flex-1 text-white text-4xl text-center">
            PERPUSTAKAAN UKDC
        </div>
    </div>

    <div class="bg-blue-600 font-bold p-5 text-right">
        <form action="/dashboard/logout.php" method="POST">
            <button type="submit" class="bg-white text-blue-500 font-bold py-2 px-2 text-sm rounded">Logout</button>
        </form>
    </div>

    <div class="bg-blue-600 p-3 flex">
        <img src="/src/cover.jpg" alt="Cover">
        <div class="p-3 text-3xl text-white">
            <div class="p-3" id="title">Title :</div>
            <div class="p-3" id="author">Author :</div>
            <div class="p-3" id="year">Tahun :</div>
            <div class="p-3">
                <div class="bg-gray-600 text-center p-2 rounded-xl" id="tag">Tag</div>
            </div>
        </div>
    </div>

    <div class="bg-blue-600 font-bold text-center text-2xl p-5 border-t-4 text-white font-['Poppins']">© Copyright IF UKDC 2023</div>
</body>
<script>

        // Untuk timeout
        const timeoutDuration = <?php echo isset($timeout_duration) ? $timeout_duration : 6000; ?>;
        setTimeout(async () => {
            try {
                const response = await fetch('/api/auth_destroy', { method: 'POST' });

                alert("Sesi Anda telah habis. Silakan masuk lagi.");
                window.location.href = '/login';

            } catch (error) {
                console.error("Error destroying session:", error);
            }
            
        }, timeoutDuration * 1000);

        // Ini untuk API ambil data Buku menggunakan ID
        async function getData(id) {
            try {
                const response = await fetch(`/api/get_book?id=${id}`);

                const data = await response.json();

                document.getElementById('title').textContent = `Title: ${data.title}`;
                document.getElementById('author').textContent = `Author: ${data.author}`;
                document.getElementById('year').textContent = `Tahun: ${data.year}`;

                const tagNames = data.tags.map(tag => tag.name).join(', ');
                document.getElementById('tag').textContent = tagNames;

            } catch (error) {
                console.error("Error fetching book:", error);
            }
        }

    const urlParams = new URLSearchParams(window.location.search);

    const val = urlParams.get('id');

    if (val) {
        getData(val);
        console.log(val)
    }
</script>
</html>
