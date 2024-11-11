function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
}

function logout() {
    fetch('/api/auth_destroy')
        .then(response => response.json())
        .then(_ => {
            window.location.href = "/example";
        })
        .catch(error => console.error('Error fetching data:', error));
}

function getTag(id) {
    const ptag = document.getElementById("change-me");
    fetch(`/api/get_tag?id=${id}`)
        .then(response => response.json())
        .then(data => {
            const cur_tag = data[0];
            ptag.innerHTML += `: ${cur_tag.name}`;
        })
        .catch(error => console.error('Error fetching data:', error));
}

function back() {
    window.location.href = "/example";
}

function getBookFromTag() {
    const ptag = document.getElementById("ptag");
    const getTagValue = getQueryParam('from_tag');
    getTag(getTagValue);
    fetch(`/api/get_book_from_tag?id=${encodeURIComponent(getTagValue)}&range=20`)
        .then(response => response.json())
        .then(data => {
            for (let i = 0; i < data.length; i++) {
                const cur_tag = data[i];
                ptag.innerHTML += `
                <a href="/example/book.php?id=${cur_tag.id}">
                <div style="display:flex; flex-direction: column; text-align:center; background-color: grey;">
                <p style="margin: 7px;"> ${cur_tag.title}</p>
                <p style="margin: 7px;"> ${cur_tag.author}</p>
                </div>
                </a>`;
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}
getBookFromTag();
