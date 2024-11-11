const range = 1;
var selected = [];
var book_tag = [];

function showBooks() {
    const page = document.getElementById("page").innerText - 1;
    const from_r = Number(page) * range;

    const ptag = document.getElementById("allbooks");
    ptag.innerHTML = "";
    
    fetch(`/api/get_book?range=${range}&from=${from_r}`)
        .then(response => response.json())
        .then(data => {
            for (let i = 0; i < data.length; i++) {
                const cur_tag = data[i];
                ptag.innerHTML += `
                <div style="display:flex; justify-content: center">
                <a href="/example/book.php?id=${cur_tag.id}">
                <div style="display:flex; flex-direction: column; text-align:center; background-color: grey;">
                    <p style="margin: 7px;"> ${cur_tag.title}</p>
                    <p style="margin: 7px;"> ${cur_tag.author}</p>
                </div>
                </a>
                <button onclick=del(${cur_tag.id})>delete</button>
                <button onclick=edi(${cur_tag.id})>edit</button>
                </div><br>`;
            }
            let s = Number(document.getElementById("page").innerText);
            if (s > data.length) {
                return;
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}

function nextBooks() {
    const pageInput = document.getElementById("page");
    let page_n = Number(pageInput.innerText);

    fetch(`/api/get_book_count`)
        .then(response => response.json())
        .then(data => {
            if (page_n * range < data.count) {
                page_n += 1;
                pageInput.innerText = page_n;  // Update the input field
                showBooks();  // Call showBooks with the updated page number
            }
        })
        .catch(error => console.error('Error fetching data:', error));

}

function prevBooks() {
    const pageInput = document.getElementById("page");
    let page_n = Number(pageInput.innerText);

    if (page_n > 1) {  // Ensure we don't go below page 1
        page_n -= 1;
        pageInput.innerText = page_n;  // Update the input field
        showBooks();  // Call showBooks with the updated page number
    }
}

function searchBookad() {
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
                </a>
                <button onclick=del(${cur_tag.id})>delete</button>
                <button style="margin-right:5px;" onclick=edi(${cur_tag.id})>edit</button>`;
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}

function del(id) {
    fetch(`/api/del_book?id=${encodeURIComponent(id)}`)
        .then(response => response.json())
        .then(data => {
            alert("deleted");
        })
        .catch(error => console.error('Error fetching data:', error));
}

async function getTag() {
    return fetch(`/api/get_tag?range=20`)
        .then(response => response.json())
        .then(data => {
            const copy = data;
            return copy;
        })
        .catch(error => console.error('Error fetching data:', error));
}

async function addbook() {
    book_tag = await getTag();
    const el = document.getElementById("addeditdiv");
    el.innerHTML = `
    <input type="text" placeholder="title" id="title"><br>
    <input type="text" placeholder="author" id="author"><br>
    <input type="text" placeholder="year" id="year"><br>
    <input type="text" placeholder="desc" id="desc"><br>
    <input type="text" placeholder="cover" id="cover"><br>
    <p id="selected-tag"></p>
    <div id="tag-edit"></div>
    <button onclick="submitBook()">submit</button>
    `;
    const el2 = document.getElementById("tag-edit");
    for (let i = 0; i < book_tag.length; i++) {
        const current_tag = book_tag[i];
        el2.innerHTML += `
        <button onclick="addTagToArr(${current_tag.id})">${current_tag.name}</button>
        `; 
    }
    redrawTag();
}

function redrawTag() {
    const sel = document.getElementById("selected-tag");
    sel.innerHTML = "";
    for (let i = 0; i < selected.length; i++) {
        for (let j = 0; j < book_tag.length; j++) {
            if (book_tag[j].id == selected[i]) {
                sel.innerHTML += ` ${book_tag[j].name}`;
            }
        }
    }
}

function addTagToArr(id) {
    let exist = false;
    let index = -1;
    for (let i = 0; i < selected.length; i++) {
        if (selected[i] == id) {
            exist = true;
            index = i;
            break;
        }
    }
    if (exist == true) {
        selected.splice(index, 1);
        redrawTag();
        return;
    }
    selected.push(id);
    redrawTag();
}

function submitBook() {
    const title = document.getElementById("title").value;
    const author = document.getElementById("author").value;
    const year = document.getElementById("year").value;
    const desc = document.getElementById("desc").value;
    const cover = document.getElementById("cover").value;
    let tags = selected[0];
    for (let i = 1; i < selected.length; i++) {
        tags += ` ${selected[i]}`;
    }
    console.log(title);
    console.log(author);
    console.log(year);
    console.log(desc);
    console.log(cover);
    console.log(tags);
}

showBooks();
