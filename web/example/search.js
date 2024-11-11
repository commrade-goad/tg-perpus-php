/* function getQueryParam(param) {
    const urlParams = new URLSearchParams(window.location.search);
    return urlParams.get(param);
} */

function searchBook() {
    const getTagValue = document.getElementById("srcbox").value;
    const ptag = document.getElementById("sbook");
    ptag.innerHTML = "";
    // const getTagValue = getQueryParam('query');
    fetch(`/api/search?q=${encodeURIComponent(getTagValue)}`)
        .then(response => response.json())
        .then(data => {
            for (let i = 0; i < data.length; i++) {
                const cur_tag = data[i].book;
                console.log(cur_tag);
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
