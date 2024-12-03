var page = 0;

// Kirim data ke book.php bagian Search
function handleSearch() {
    const searchInput = document.getElementById('search').value.trim();
    if (searchInput) {
        window.location.href = `/dashboard/book.php?search=${encodeURIComponent(searchInput)}`;
        return false;
    }
    return true;
}

// Ambil tag untuk display
async function fetchTags(from, range) {
    try {
        const response = await fetch(`/api/get_tag?from=${from}&range=${range}&sort=ASC`);

        if (!response.ok) {
            throw new Error("Failed to fetch tags");
        }

        const tags = await response.json();
        const tagList = document.getElementById('tagList');
        tagList.innerHTML = ''; // Clear existing content

        // Add the "Previous" button
        const prevButton = document.createElement('span');
        prevButton.id = 'prev';
        prevButton.className = 'flex items-center justify-center text-white text-2xl';
        prevButton.textContent = '<';
        tagList.appendChild(prevButton);

        // Add tags
        tags.forEach(tag => {
            const li = document.createElement('li');
            li.className = 'bg-blue-400 hover:bg-blue-600 text-gray-50 py-2 px-2 rounded-lg';

            const a = document.createElement('a');
            a.href = `/dashboard/book.php?tag=${encodeURIComponent(tag.name)}`;
            a.textContent = tag.name;

            li.appendChild(a);
            tagList.appendChild(li);
        });

        // Add the "Next" button
        const nextButton = document.createElement('span');
        nextButton.id = 'next';
        nextButton.className = 'flex items-center justify-center text-white text-2xl';
        nextButton.textContent = '>';
        tagList.appendChild(nextButton);

        // Add event listeners to the buttons after they are created
        prevButton.addEventListener('click', function () {
            if (page > 0) {
                page -= 1;
                const from = page * 4;
                fetchTags(from, 4);
            }
        });

        nextButton.addEventListener('click', function () {
            fetch(`/api/get_tag_count`)
                .then(response => response.json())
                .then(data => {
                    if ((page + 1) * 4 < data.count) {
                        page += 1;
                        const from = page * 4;
                        fetchTags(from, 4);
                    }
                });
        });

    } catch (error) {
        console.error("Error fetching tags:", error);
    }
}

// Initialize tags when the page loads
document.addEventListener('DOMContentLoaded', function () {
    fetchTags(0, 4);
});
