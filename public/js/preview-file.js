let img = document.getElementById('admin_product_images');
function previewFile(input) {
    let files = input.files
    for (let i of files) {
        let reader = new FileReader();
        let newImg = document.createElement('img');
        newImg.style.height = '100px';
        newImg.style.width = '100px';
        newImg.style.margin = '10px';
        reader.onload = function () {
            let result = reader.result;
            newImg.src = result;
        };
        reader.readAsDataURL(i);
        img.after(newImg);
        let radio = document.createElement('input');
        radio.setAttribute('type', 'radio');
        radio.setAttribute('id', i.name);
        radio.setAttribute('class', 'checkbox');
        radio.setAttribute('name', i.name);
        // radio.setAttribute('onclick', 'choice(this);');
        newImg.after(radio);
    }
}

function choice(input) {
    let radios = document.getElementsByClassName('checkbox');
    for (const radio of radios) {
        if (radio === input) {
            radio.setAttribute('name', 'primary');
            radio.value = true;
        } else {
            radio.setAttribute('name', '');
            radio.checked = false;
            radio.value = false;
        }
    }
}