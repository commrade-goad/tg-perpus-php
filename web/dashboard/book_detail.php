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
<body class="bg-blue-600">
<div class="bg-blue-800 font-bold font-['Poppins'] text-center p-5 border-b-4 flex items-center justify-between">
        <div class="flex-1 text-white text-4xl text-center">
            PERPUSTAKAAN UKDC
        </div>
    </div>

    <div class="bg-blue-600 font-bold p-5 text-right">
        <form action="/dashboard/logout.php" method="POST">
        <button type="submit" class="bg-blue-400 hover:bg-blue-700 text-gray-50 font-bold py-2 px-2 text-sm rounded">Logout</button>
        </form>
    </div>

    <div class="bg-blue-600 p-3 flex">
        <img src="/src/cover.jpg" alt="Cover">
        <div class="p-3 text-3xl text-white">
            <div class="p-3" id="title">Title :</div>
            <div class="p-3" id="author">Author :</div>
            <div class="p-3" id="year">Tahun :</div>
            <div class="p-3 flex flex-wrap gap-4 items-center">
                <div class="flex flex-wrap gap-2" id="tag"></div>
            </div>
            <div class="p-3">Deskripsi :
                <div class="mt-2" id="desc">desc</div>
            </div>
        </div>
    </div>

    <div class="bg-blue-600 font-bold text-center text-2xl p-5 border-t-4 text-white font-['Poppins']">© Copyright IF UKDC 2023</div>
</body>
<script>

    function teleport(where) {
        window.location.href=`/dashboard/book.php?tag=${where}`;
    }

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
                const tg = document.getElementById('tag');


                for (let i = 0; i < data.tags.length; i++) {
                    const cur_tag = data.tags[i];
                tg.innerHTML += `
                <div onclick="teleport('${cur_tag.name}')" class="tag-btn bg-blue-400 hover:bg-blue-700 text-white pb-2 pl-2 pr-2 rounded item-center text-center" data-id="${cur_tag.id}">${cur_tag.name}</div>
                `;
                console.log(data.tags[i].name);
                }           
                document.getElementById('desc').textContent = data.desc;

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
