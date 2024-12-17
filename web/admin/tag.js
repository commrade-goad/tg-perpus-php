var all_tags = [];
var page = 0;
var range = 4;

function gen_from() {
    return page * range;
}

async function fetch_tags(from, range){
    const a = await fetch(`/api/get_tag?from=${from}&range=${range}`).then(data => data.json());
    all_tags = a;
    all_tags.forEach(element => {
        render_tag(element);
    });
}

function render_tag(tag) {
    const tc = document.getElementById("tags-container");
    tc.innerHTML += `
    <div class="bg-blue-500 m-3 p-2 text-white rounded-md align-center text-center">
        <p class="p-3">${tag.name}</p>
        <button class="bg-blue-700 p-2 m-1 rounded-lg" onclick="edit_tag(${tag.id})">Edit</button>
        <button class="bg-blue-700 p-2 m-1 rounded-lg" onclick="rem_tag(${tag.id})">Delete</button>
    </div>
`;
}

function cleanup_tag() {
    const tc = document.getElementById("tags-container");
    tc.innerHTML = ``;
}

async function rem_tag(id) {
    const formData = new URLSearchParams();
    formData.append("id", id);

    fetch(`/api/del_tag`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: formData.toString()
    })
        .then(res => res.json())
        .then(data => {
            alert(`Deleted tag ${id}`);
            cleanup_tag();
            fetch_tags(gen_from(), range);
        })
        .catch(
            error => alert(`Failed to delete tag with the id :${id}`)
        );
}
async function add_tag(name, cover) {
    const formData = new URLSearchParams();
    formData.append("name", name);
    formData.append("img", cover);

    fetch(`/api/add_tag`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: formData.toString()
    })
    .then(res => res.json())
    .then(data => {
        alert("Tag Added");
        cleanup_tag();
        fetch_tags(gen_from(), range);
    })
    .catch(error => alert("Failed to add new tag!"));
}

async function edit_tag_real(id, name, cover) {
    const formData = new URLSearchParams();
    formData.append("id", id);
    formData.append("name", name);
    formData.append("img", cover);

    fetch(`/api/edit_tag`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: formData.toString()
    })
    .then(res => res.json())
    .then(data => {
        alert(`Tag with id ${id} Edited`);
        cleanup_tag();
        fetch_tags(gen_from(), range);
    })
    .catch(error => alert(`Failed to edit tag ${id}!`));
}

async function get_tag_count() {
    const response = await fetch(`/api/get_tag_count`);
    const data = await response.json();
    return data.count;
}

// to call the modal and populate input
async function edit_tag(id) {
    const name = document.getElementById("tname-e");
    const imgp = document.getElementById("imgp-e");
    const tid = document.getElementById("tid");

    const a = fetch(`/api/get_tag?id=${encodeURIComponent(id)}`)
    .then(res => res.json())
    .then(data => {
        name.value = data[0].name;
        imgp.value = data[0].img;
        tid.placeholder = data[0].id;
        openModalEdit();
    })
    .catch(error => alert("Failed to add new tag!"))
}

function openModal() {
    document.getElementById('modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('modal').classList.add('hidden');
}

function handleSubmit(event) {
    event.preventDefault();
    const name = document.getElementById("tname");
    const imgp = document.getElementById("imgp");
    add_tag(name.value, imgp.value);
    closeModal();
}

function openModalEdit() {
    document.getElementById('modaledit').classList.remove('hidden');
}

function closeModalEdit() {
    document.getElementById('modaledit').classList.add('hidden');
}

function handleSubmitEdit(event) {
    event.preventDefault();
    const name = document.getElementById("tname-e");
    const imgp = document.getElementById("imgp-e");
    const tid = document.getElementById("tid");
    edit_tag_real(tid.placeholder, name.value, imgp.value);
    closeModalEdit();
}

async function search_tag(query, from, range) {
    const len = await get_tag_count();
    const a = await fetch(`/api/get_tag?from=0&range=${len}`);
    const data = await a.json();
    // let rcounter = 0;
    // let fcounter = 0;
    cleanup_tag();
    data.forEach(element => {
        // if (fcounter >= from) {
        //     if (rcounter > range) {
        //         return;
        //     }
            if (element.name.includes(query)) {
                render_tag(element);
            }
        //     rcounter += 1;
        // }
        // fcounter += 1;
    });
}

fetch_tags(gen_from(), range);

const sbox = document.getElementById("sbox");
const next = document.getElementById("next");
const prev = document.getElementById("prev");

sbox.addEventListener("change", async function() {
    if (sbox.value === "") {
        cleanup_tag();
        fetch_tags(gen_from(), range);
    }
    search_tag(sbox.value, 0, range);
});

next.addEventListener("click", async function() {
    page += 1;
    const len = await get_tag_count();
    if (gen_from() < len) {
        if (sbox.value === "") {
            next.disbled = false;
            cleanup_tag();
            fetch_tags(gen_from(), range);
        } else {
            next.disbled = true;
            // search_tag(sbox.value, gen_from(), range);
        }
    } else {
        page -= 1;
    }
});

prev.addEventListener("click", async function() {
    if (page - 1 >= 0) {
        page -=1;
        if (sbox.value === "") {
            prev.disbled = false;
            cleanup_tag();
            fetch_tags(gen_from(), range);
        } else {
            next.disbled = true;
            // search_tag(sbox.value, gen_from(), range);
        }
    }
});
