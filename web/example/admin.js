const range = 2;
var selected = [];
var book_tag = [];

function showBooks() {
    const page = document.getElementById("page").innerText - 1;
    const from_r = Number(page) * range;

    const ptag = document.getElementById("allbooks");
    ptag.innerHTML = "";
    
    fetch(`/api/get_book?range=${encodeURIComponent(range)}&from=${encodeURIComponent(from_r)}`)
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
                <button onclick=edit(${cur_tag.id})>edit</button>
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

async function updateTagList() {
    book_tag = await getTag();
    const el2 = document.getElementById("tag-list");
    el2.innerHTML = ``;
    for (let i = 0; i < book_tag.length; i++) {
        const current_tag = book_tag[i];
        el2.innerHTML += `
        <button onclick="addTagToArr(${current_tag.id})">${current_tag.name}</button>
        `; 
    }
    el2.innerHTML += `
    <button onclick="addNewTagToArrMenu()">[ add new ]</button>
    `;
    el2.innerHTML += `
    <button onclick="delTagToArrMenu()">[ del tag ]</button>`;
    el2.innerHTML += `
    <button onclick="editTagMenu()">[ edit tag ]</button>
    <div id="add-new"></div>`;
    redrawTag();
}

async function getBook(id) {
    const res = fetch(`/api/get_book?id=${encodeURIComponent(id)}`)
        .then(response => response.json())
        .then(data => {return data})
        .catch(error => console.error('Error fetching data:', error));
    return res;
}

function submitEditBook(id) {
    const title = document.getElementById("title").value;
    const author = document.getElementById("author").value;
    const year = document.getElementById("year").value;
    const desc = document.getElementById("desc").value;
    const cover = document.getElementById("cover").value;
    let tags = selected[0];
    for (let i = 1; i < selected.length; i++) {
        tags += ` ${selected[i]}`;
    }
    fetch(`/api/edit_book?id=${encodeURIComponent(id)}&title=${encodeURIComponent(title)}&author=${encodeURIComponent(author)}&desc=${encodeURIComponent(desc)}&tags=${encodeURIComponent(tags)}&year=${encodeURIComponent(year)}&img=${encodeURIComponent(cover)}`)
        .then(response => response.json())
        .then(data => {
        })
        .catch(error => console.error('Error fetching data:', error));
}

async function edit(id) {
    const book = await getBook(id);
    const book_tag = await getTag();
    const el = document.getElementById("addeditdiv");
    el.innerHTML = `
    <h3>Edit book</h3>
    <input type="text" placeholder="title" id="title" value="${book.title}"><br>
    <input type="text" placeholder="author" id="author" value="${book.author}"><br>
    <input type="text" placeholder="year" id="year" value="${book.year}"><br>
    <input type="text" placeholder="desc" id="desc" value="${book.desc}"><br>
    <input type="text" placeholder="cover" id="cover" value="${book.cover}"><br>
    <p id="selected-tag"></p>
    <div id="tag-edit"></div>
    <div id="tag-list"></div>
    <button onclick="submitEditBook(${id})">submit</button>
    `;

    selected = [];
    for (let i = 0; i < book.tags.length; i++) {
        selected.push(book.tags[i].id);
    }
    const el2 = document.getElementById("tag-list");
    for (let i = 0; i < book_tag.length; i++) {
        const current_tag = book_tag[i];
        el2.innerHTML += `
        <button onclick="addTagToArr(${current_tag.id})">${current_tag.name}</button>
        `; 
    }
    el2.innerHTML += `
    <button onclick="addNewTagToArrMenu()">[ add new ]</button>
    `;
    el2.innerHTML += `
    <button onclick="delTagToArrMenu()">[ del tag ]</button>
    `;
    el2.innerHTML += `
    <button onclick="editTagMenu()">[ edit tag ]</button>
    <div id="add-new"></div>`;
    redrawTag();
    updateTagList();
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
    <div id="tag-list"></div>
    <button onclick="submitBook()">submit</button>
    `;
    selected = [];
    const el2 = document.getElementById("tag-list");
    for (let i = 0; i < book_tag.length; i++) {
        const current_tag = book_tag[i];
        el2.innerHTML += `
        <button onclick="addTagToArr(${current_tag.id})">${current_tag.name}</button>
        `; 
    }
    el2.innerHTML += `
    <button onclick="addNewTagToArrMenu()">[ add new ]</button>
    `;
    el2.innerHTML += `
    <button onclick="delTagToArrMenu()">[ del tag ]</button>
    `;
    el2.innerHTML += `
    <button onclick="editTagMenu()">[ edit tag ]</button>
    <div id="add-new"></div>`;
    redrawTag();
}

async function editTagMenu() {
    const res = await fetch(`/api/get_tag`)
        .then(response => response.json())
        .then(data => {
            return data;
        })
        .catch(error => console.error('Error fetching data:', error));
    const el = document.getElementById("add-new");
    if (el.innerHTML === "") {
        el.innerHTML = `<h3>edit tag</h3>`;
        for (let i = 0; i < res.length; i++) {
            el.innerHTML += `<button onclick="stageTwoEditTagForm(${res[i].id})">${res[i].id} : ${res[i].name}</button><br>`;
        }
        el.innerHTML += `<hr><div id="finaledit"></div>`;
    } else {
        el.innerHTML = ``;
    }
}

async function stageTwoEditTagForm(id) {
    const res = await fetch(`/api/get_tag?id=${encodeURIComponent(id)}`)
        .then(response => response.json())
        .then(data => {
            return data;
        })
        .catch(error => console.error('Error fetching data:', error));
    const sel_tag = res[0];
    const el = document.getElementById("finaledit");
    el.innerHTML = "";
    el.innerHTML += `
    <input type="text" placeholder="name" id="tag-name" value="${sel_tag.name}">
    <input type="text" placeholder="img path" id="img-path" value="${sel_tag.img}">
    <button onclick="finalEditTag(${sel_tag.id})">edit tag</button>
    <hr>
    `;
}

function finalEditTag(id) {
    const tn = document.getElementById("tag-name").value;
    const img = document.getElementById("img-path").value;
    const res = fetch(`/api/edit_tag?id=${encodeURIComponent(id)}&name=${encodeURIComponent(tn)}&img=${encodeURIComponent(img)}`)
        .then(response => response.json())
        .then(data => {
            alert("Data berhasil disimpan");
        })
        .catch(error => console.error('Error fetching data:', error));
}

function addNewTagToArrMenu() {
    const el = document.getElementById("add-new");
    if (el.innerHTML === "") {
        el.innerHTML = `<h3>add new tag</h3>`;
        el.innerHTML += `<input type="text" placeholder="name" id="tname">`;
        el.innerHTML += `<br>`;
        el.innerHTML += `<input type="text" placeholder="cover" id="tcover">`;
        el.innerHTML += `<br>`;
        el.innerHTML += `<button onclick="addNewTag()">add</button>`
        el.innerHTML += `<br>`;
    } else {
        el.innerHTML = ``;
    }
}

function addNewTag() {
    const tname = document.getElementById("tname").value;
    const tcover = document.getElementById("tcover").value;
    console.log(tname);
    console.log(tcover);
    fetch(`/api/add_tag?name=${encodeURIComponent(tname)}&img=${encodeURIComponent(tcover)}`)
        .then(response => response.json())
        .then(_ => {
            updateTagList();
        })
        .catch(error => console.error('Error fetching data:', error));
}

async function delTagToArrMenu() {
    const res = await fetch(`/api/get_tag`)
        .then(response => response.json())
        .then(data => {
            return data;
        })
        .catch(error => console.error('Error fetching data:', error));
    const el = document.getElementById("add-new");
    if (el.innerHTML === "") {
        el.innerHTML = `<h3>del tag</h3>`;
        for (let i = 0; i < res.length; i++) {
            el.innerHTML += `<button onclick="deltagfrom(${res[i].id})">${res[i].id} : ${res[i].name}</button><br>`;
        }
        el.innerHTML += `<hr>`;
    } else {
        el.innerHTML = ``;
    }
}

function deltagfrom(id) {
    fetch(`/api/del_tag?id=${encodeURIComponent(id)}`)
        .then(response => response.json())
        .then(data => {
            alert("deleted");
            updateTagList();
        })
        .catch(error => console.error('Error fetching data:', error));
}

function redrawTag() {
    const sel = document.getElementById("selected-tag");
    sel.innerHTML = "";
    console.log(selected);
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

    fetch(`/api/add_book?title=${encodeURIComponent(title)}&author=${encodeURIComponent(author)}&desc=${encodeURIComponent(desc)}&tags=${encodeURIComponent(tags)}&year=${encodeURIComponent(year)}&img=${encodeURIComponent(cover)}`)
        .then(response => response.json())
        .then(data => {
        })
        .catch(error => console.error('Error fetching data:', error));
}

function adduserMenu() {
    const el = document.getElementById("userform");
    if (el.innerHTML == "") {
        el.innerHTML = `<input type="text" placeholder="id" id="idinput"></br>`;
        el.innerHTML += `<input type="password" placeholder="password" id="pwdinput"></br>`;
        el.innerHTML += `<input type="number" placeholder="type" min=0 max=1 id="typeinput"></br>`;
        el.innerHTML += `<button onclick="adduser()">submit</button>`;
    } else {
        el.innerHTML = "";
    }
}

function adduser() {
    const ids = document.getElementById("idinput").value;
    const type = document.getElementById("typeinput").value;
    const password = document.getElementById("pwdinput").value;
    fetch(`/api/add_user?id=${encodeURIComponent(ids)}&password=${encodeURIComponent(password)}&type=${encodeURIComponent(type)}`)
        .then(response => response.json())
        .then(_ => {
            alert("done adding user");
            list_all_user();
        })
        .catch(error => console.error('Error fetching data:', error));
}

function deluser(id) {
    fetch(`/api/del_user?id=${encodeURIComponent(id)}`)
        .then(response => response.json())
        .then(_ => {
            alert("deleted user");
            list_all_user();
        })
        .catch(error => console.error('Error fetching data:', error));
}

function edituserFinal() {
    const id = document.getElementById("idinput").value;
    const password = document.getElementById("pwdinput").value;
    fetch(`/api/edit_user?id=${encodeURIComponent(id)}&password=${encodeURIComponent(password)}`)
        .then(response => response.json())
        .then(_ => {
            alert("edited user");
            list_all_user();
        })
        .catch(error => console.error('Error fetching data:', error));
}

function edituser(id) {
    const el = document.getElementById("userform");
    if (el.innerHTML == "") {
        el.innerHTML = `<input type="text" placeholder="id" id="idinput" value="${id}"></br>`;
        el.innerHTML += `<input type="password" placeholder="password" id="pwdinput"></br>`;
        el.innerHTML += `<button onclick="edituserFinal()">submit</button>`;
    } else {
        el.innerHTML = "";
    }
}

function list_all_user() {
    const el = document.getElementById("userlist");
    el.innerHTML = `<button onclick="adduserMenu()">add user</button>`
    fetch(`/api/get_user`)
        .then(response => response.json())
        .then(data => {
            for (let i = 0; i < data.length; i++) {
                el.innerHTML += `<p>${data[i].id} : ${data[i].type} --> <button onclick="deluser(${data[i].id})">delete</button> <button onclick="edituser(${data[i].id})">edit</button></p>`;
            }
        })
        .catch(error => console.error('Error fetching data:', error));
}

showBooks();
list_all_user();
