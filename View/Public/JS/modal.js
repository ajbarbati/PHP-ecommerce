const modal = document.getElementById('simpleModal')
const modalBtn = document.getElementById('modalButton')
const closeBtn = document.getElementsByClassName('closeBtn')[0]

modalBtn.addEventListener('click', openModal)

closeBtn.addEventListener('click', closeModal)

window.addEventListener('click', clickOutside)

window.addEventListener('click', getScrollY)

function openModal() {
    modal.style.display = 'block';
    window.scrollTo(0, 50); 
}

function closeModal() {
    modal.style.display = 'none';
    subCats.style.display = 'none'
}

function clickOutside(e) {
    if(e.target == modal) {
        modal.style.display = 'none'
        subCats.style.display = 'none'
    }
}


// get y scroll position
function getScrollY() {
    var  scrOfY = 0;
    scrOfY = window.pageYOffset; 
    console.log(scrOfY);
}

const subCatButton = document.getElementById('subCatButton')
const subCats = document.getElementById('subCategories')

subCatButton.addEventListener('click', showSubCats)

function showSubCats () {
    if (subCats.style.display = 'none') {
        subCats.style.display = 'block'
    }
    else if (subCats.style.display = 'block') {
        subCats.style.display = 'none'
    }
}