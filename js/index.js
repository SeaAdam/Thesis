let menu = document.querySelector('#menu-btn');
let navbar = document.querySelector('.header .nav');
let header = document.querySelector('.header');

menu.onclick = () => {
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');
}

window.onscroll = () => {
    menu.classList.toggle('fa-times');
    navbar.classList.toggle('active');

    if (window.scrollY > 0) {
        header.classList.add('active');
    } else {
        header.classList.remove('active');
    }
}

const images = [
    "assets/StockCake-Doctors in clinic_1721751866.jpg",
    "assets/Home-Health-Care-The-New-Trend-In-India.jpg",
    "assets/new2.jpg"
];

let currentIndex = 0;
const homeSection = document.querySelector('.home');

// Function to change background image
function changeBackground() {
    currentIndex = (currentIndex + 1) % images.length;
    homeSection.style.backgroundImage = `url(${images[currentIndex]})`;
}

// Set initial background image on page load
window.onload = function () {
    homeSection.style.backgroundImage = `url(${images[0]})`;
    setInterval(changeBackground, 2000); 
};


// Get the modal
var modal = document.getElementById("myModal");

var modalReg = document.getElementById("myModalReg");

var modalRegPatient = document.getElementById("myModalRegPatient");



// Get the button that opens the modal
var openModalBtn = document.getElementById("openModalBtn");

var openModalBtnReg = document.getElementById("openModalBtnReg");

var openModalBtnRegPatient = document.getElementById("modalRegPatient");


// Get the close button in the modal footer
var closeModalBtn = document.getElementById("closeModalBtn");

var closeModalBtnReg = document.getElementById("closeModalBtnReg");

var closeModalBtnRegPatient = document.getElementById("closeModalBtnRegPatient");


// When the user clicks the button, open the modal 
openModalBtn.onclick = function () {
    modal.style.display = "block";
}

openModalBtnReg.onclick = function () {
    modalReg.style.display = "block";
}

openModalBtnRegPatient.onclick = function () {
    modalRegPatient.style.display = "block";
}



// When the user clicks the close button, close the modal
closeModalBtn.onclick = function () {
    modal.style.display = "none";
}

closeModalBtnReg.onclick = function () {
    modalReg.style.display = "none";
}

closeModalBtnRegPatient.onclick = function () {
    modalRegPatient.style.display = "none";
}





// When the user clicks anywhere outside of the modal, close it
window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}




