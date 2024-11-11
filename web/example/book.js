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

function getBook() {
    const ptag = document.getElementById("book");
    const getTagValue = getQueryParam('id');
    fetch(`/api/get_book?id=${encodeURIComponent(getTagValue)}`)
        .then(response => response.json())
        .then(data => {
            document.title = data.title;
            ptag.innerHTML += `
            <div style="display:flex; flex-direction: column; text-align:center; background-color: grey;">
            <img src="${data.cover}" style="margin: 7px;"></img>
            <p style="margin: 7px;"> ${data.title}</p>
            <p style="margin: 7px;"> ${data.author}</p>
            <div id="arrtag" style="display:flex; flex-direction: row; justify-content: center"></div>
            <p style="margin: 7px;"> ${data.year}</p>
            <p style="margin: 7px;"> ${data.desc}</p>
            </div>
            `;
            const arrtag = document.getElementById("arrtag");
            for (let i = 0; i < data.tags.length; i++) {
                arrtag.innerHTML += `
                <a href="/example/bookshelves.php?from_tag=${data.tags[i].id}">
                <span style="margin: 3px; color: white; background-color: black; padding: 3px;"> ${data.tags[i].name} </span>
                </a>
                `;
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}
getBook();
