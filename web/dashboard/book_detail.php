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
<body class="min-h-screen flex flex-col bg-blue-600">
<div class="bg-blue-800 font-bold font-['Poppins'] text-center p-5 border-b-4 flex items-center justify-between">
        <div class="flex-1 text-white text-4xl text-center cursor-pointer" onclick="window.location.href='/dashboard/index.php'">
            PERPUSTAKAAN UKDC
        </div>
    </div>

    <div class="bg-blue-600 font-bold p-5 pb-1 text-right">
        <form action="/dashboard/logout.php" method="POST">
        <button type="submit" class="bg-blue-400 hover:bg-blue-700 text-gray-50 font-bold py-2 px-2 text-sm rounded">Logout</button>
        </form>
    </div>

    <div class="bg-blue-600 p-4 pl-12 flex mb-8 book-container">
        <!--<img id="book-cover" src="/src/cover.jpg" alt="Cover" class="max-w-[350px] aspect-[3/4]">-->
        <img id="book-cover" src="/src/cover.jpg" alt="Cover">
        <div class="p-3 text-3xl text-white">
            <div class="p-3 pb-0 font-bold text-3xl" id="title">Title :</div>
            <div class="p-3 font-bold text-2xl pb-0 italic" id="author">Author :</div>
            <div class="p-3 pb-0 text-xl italic" id="year"></div>
            <div class="p-3 pb-0 text-xl" id="pos">pos</div>
            <div class="p-3 pt-0 text-xl" id="prodi">prodi</div>
            <div class="p-3 flex flex-wrap gap-4 items-center font-bold">
                <div class="flex flex-wrap gap-2 text-base" id="tag"></div>
            </div>
            <div class="p-3">
                <div class="mt-1 text-xl" id="desc">desc</div>
            </div>
        </div>
    </div>

</body>
        <footer class="bg-blue-800 font-bold text-center text-2xl p-5 text-gray-50 font-['Poppins'] mt-auto" style="font-family: 'Poppins';">Licensed with GNU GPL v2.0</footer>
<script>

    function teleport(where) {
        window.location.href=`/dashboard/book.php?tag=${where}`;
    }

        // Untuk timeout
        const timeoutDuration = <?php echo isset($timeout_duration) ? $timeout_duration : 6000; ?>;

        setTimeout(async () => {
            try {
                const response = await fetch('/api/auth_destroy/index.php', { method: 'POST' });

                alert("Sesi Anda telah habis. Silakan masuk lagi.");
                window.location.href = '/login';

            } catch (error) {
                console.error("Error destroying session:", error);
            }
            
        }, timeoutDuration * 1000);

        // Ini untuk API ambil data Buku menggunakan ID
        async function getData(id) {
            try {
                const response = await fetch(`/api/get_book/index.php?id=${id}`);

                const data = await response.json();

                document.getElementById('title').textContent = `${data.title}`;
                document.getElementById('author').textContent = `${data.author}`;
                document.getElementById('year').textContent = `${data.year}`;
                document.getElementById('pos').textContent = `Posisi : ${data.pos}`;
                document.getElementById('prodi').textContent = `Prodi : ${data.prodi}`;
                if (data.cover !== ""){
                    document.getElementById('book-cover').src = `${data.cover}`;
                }
                const tg = document.getElementById('tag');


                for (let i = 0; i < data.tags.length; i++) {
                    const cur_tag = data.tags[i];
                tg.innerHTML += `
                <div onclick="teleport('${cur_tag.id}')" class="tag-btn bg-blue-400 hover:bg-blue-700 text-white p-2 pt-1 pb-1 rounded item-center text-center" data-id="${cur_tag.id}">${cur_tag.name}</div>
                `;
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
    <style>
    @media (max-width: 900px) {
        .book-container {
            flex-direction: column;
            align-items: center;
        }
    }
    #book-cover {
        max-width: 350px;
        max-height: 100%;
        aspect-ratio: 3/4;
    }
    .tag-btn {
        cursor: pointer;
    }
    </style>
</html>
