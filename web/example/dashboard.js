function logout() {
    fetch('/api/auth_destroy')
        .then(response => response.json())
        .then(_ => {
            window.location.href = "/example";
        })
        .catch(error => console.error('Error fetching data:', error));
}

function getTag() {
    const ptag = document.getElementById("ptag");
    fetch(`/api/get_tag?range=20`)
        .then(response => response.json())
        .then(data => {
            for (let i = 0; i < data.length; i++) {
                const cur_tag = data[i];
                ptag.innerHTML += `<a href="/example/bookshelves.php?from_tag=${cur_tag.id}"><p style="margin: 7px;"> ${cur_tag.name} </p></a>`;
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}
getTag();
