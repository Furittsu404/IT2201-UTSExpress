let searchbtn = document.querySelector('#search-btn');
let cartbtn = document.querySelector('#cart-btn');
let navbtn = document.querySelector('#menu-btn');
let userbtn = document.querySelector('#user-btn');

let header = document.querySelector(".header");
let navbartxt = document.querySelector(".navtxt");
let navbartxt1 = document.querySelector(".navtxt1");
let navbartxt2 = document.querySelector(".navtxt2");
let navbartxt3 = document.querySelector(".navtxt3");
let navbartxt4 = document.querySelector(".navtxt4");
let activetab = document.querySelector(".active-tab");

let searchForm = document.querySelector(".search-bar");

document.querySelector("#search-btn").onclick = () => {
  searchForm.classList.toggle("active");
  shoppingCart.classList.remove("active");
  navbar.classList.remove("active");
  userWindow.classList.remove("active");
};

let shoppingCart = document.querySelector(".shopping-cart");

document.querySelector("#cart-btn").onclick = () => {
  shoppingCart.classList.toggle("active");
  searchForm.classList.remove("active");
  navbar.classList.remove("active");
  userWindow.classList.remove("active");
};

let navbar = document.querySelector(".navbar");

document.querySelector("#menu-btn").onclick = () => {
  navbar.classList.toggle("active");
  searchForm.classList.remove("active");
  shoppingCart.classList.remove("active");
  userWindow.classList.remove("active");
};

let userWindow = document.querySelector(".user-window");

document.querySelector("#user-btn").onclick = () => {
  userWindow.classList.toggle("active");
  searchForm.classList.remove("active");
  shoppingCart.classList.remove("active");
  navbar.classList.remove("active");
};

document.addEventListener("mouseup", function (e) {
  if (!searchForm.contains(e.target) && !searchbtn.contains(e.target)) {
    searchForm.classList.remove("active");
  }
  if (!shoppingCart.contains(e.target) && !cartbtn.contains(e.target)) {
    shoppingCart.classList.remove("active");
  }
  if (!navbar.contains(e.target) && !navbtn.contains(e.target)) {
    navbar.classList.remove("active");
  }
  if (!userWindow.contains(e.target) && !userbtn.contains(e.target)) {
    userWindow.classList.remove("active");
  }
});
window.onscroll = function () {
  myFunction();
};

var color = header.offsetTop;

function myFunction() {
  if (window.scrollY > color) {
    header.classList.add("color-header");
    navbartxt.classList.add("color-text");
    navbartxt1.classList.add("color-text");
    navbartxt2.classList.add("color-text");
    navbartxt3.classList.add("color-text");
    navbartxt4.classList.add("color-text");
    activetab.classList.add("active-color");
  } else {
    header.classList.remove("color-header");
    navbartxt.classList.remove("color-text");
    navbartxt1.classList.remove("color-text");
    navbartxt2.classList.remove("color-text");
    navbartxt3.classList.remove("color-text");
    navbartxt4.classList.remove("color-text");
    activetab.classList.remove("active-color");
  }
}

var swiper = new Swiper(".product-slider", {
  loop: true,
  spaceBetween: 20,
  autoplay: {
    delay: 7500,
    disableOnInteraction: false,
  },
  centeredSlides: true,
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    768: {
      slidesPerView: 2,
    },
    1020: {
      slidesPerView: 3,
    },
  },
});