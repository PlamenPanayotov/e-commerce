let img = document.getElementById('admin_product_images');
let sortable = document.getElementById('sortable');
function previewFile(input) {
    let files = input.files
    for (let i of files) {
        let reader = new FileReader();
        let div = document.createElement('div');
        div.className = 'col-sm';
        let newImg = document.createElement('img');
        newImg.style.height = '150px';
        newImg.style.width = '150px';
        newImg.style.margin = '10px';
        reader.onload = function () {
            let result = reader.result;
            newImg.src = result;
        };
        reader.readAsDataURL(i);
        div.appendChild(newImg);
        sortable.appendChild(div);
    }
}


























// TO DO:
// I have to add onload function in html and add event listener on the current element!!!

// let input = document.getElementById('admin_product_images');
// input.addEventListener('change', previewFile);

// function previewFile() {

//     let files = input.files;
//     renderImages(files);
//     console.log(input.value);
//     let n = files.length;
//     input.value = `${n} files selected`;
// }

// function checkInput() {
//     if (input.value !== 'No files selected.') {
//         console.log(input)
//         renderImages(input.files);
//     }
// }

// function renderImages(files) {
//     for (let i of files) {
//         let reader = new FileReader();
//         let newImg = document.createElement('img');
//         newImg.style.height = '100px';
//         newImg.style.width = '100px';
//         newImg.style.margin = '10px';
//         reader.onload = function () {
//             let result = reader.result;
//             newImg.src = result;
//         };
//         reader.readAsDataURL(i);
//         input.after(newImg);
//         let radio = document.createElement('input');
//         radio.setAttribute('type', 'radio');
//         radio.setAttribute('id', i.name);
//         radio.setAttribute('class', 'checkbox');
//         radio.setAttribute('name', i.name);
//         newImg.after(radio);
//     }
// }
// checkInput();