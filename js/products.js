$(document).ready(function () {
  $('.trash-btn').on('click', function (e) {
      e.preventDefault();
      let productId = $(this).data('id');
      $.ajax({
          url: '../includes/addToCart.php',
          type: 'POST',
          data: { id: productId, delete: true },
          success: function (response) {
              $('#cart-icon').text(response);
          }
      });
      $.ajax({
          url: '../includes/cartUpdate.php',
          type: 'POST',
          data: { id: productId, delete: true },
          success: function (response) {
              $('#cart-content').html(response);
          }
      });
  });
});

$(document).ready(function () {
  $('.cartbtn').on('click', function (e) {
      e.preventDefault();
      let productId = $(this).data('id');
      $.ajax({
          url: '../includes/addToCart.php',
          type: 'POST',
          data: { id: productId },
          success: function (response) {
              $('#cart-icon').text(response);
          }
      });
      $.ajax({
          url: '../includes/cartUpdate.php',
          type: 'POST',
          data: { id: productId },
          success: function (response) {
              $('#cart-content').html(response);
          }
      });
      showModal('addCartModal');
  });
});

function showModal(var_id) {
  var modal = document.getElementById(var_id);
  modal.classList.add("active-modal");
  setTimeout(function() {
    modal.style.display = "block";
  }, 50);
}

function closeModal(var_id) {
  var modal = document.getElementById(var_id);
  modal.classList.remove("active-modal");
  setTimeout(function() {
    modal.style.display = "none";
  }, 250);
}

function resetSort(sortType) {
  window.location.href = `?sort=${sortType}&search=${document.getElementById('search-box').value}`;
}
function searchQuery() {
  if (document.getElementById('search-box').value !== '') {
      return '&search=' + document.getElementById('search-box').value;
  }
  return '';
}


window.onclick = function (event) {
  if (event.target == document.querySelector(".active-modal")) {
    document.querySelector(".active-modal").style.display = "none";
    document.querySelector(".active-modal").classList.remove("active-modal");
  }
};

function numberOnly(id) {
  var element = document.getElementById(id);
  element.value = element.value.replace(/[^0-9]/gi, "");
}

function letterOnly(id) {
  var element = document.getElementById(id);
  element.value = element.value.replace(/[^a-zA-Z-_,.`~ ]/g, "");
}
function validSymbol(id) {
  var element = document.getElementById(id);
  element.value = element.value.replace(
    /[^a-zA-Z0-9!@#$%^&*\-_=+,./?\\|`~ ]/g,
    ""
  );
}

$(document).ready(function () {
  $(".createimg").change(function () {
    var file = this.files[0];
    if (file) {
      var reader = new FileReader();
      reader.onload = function (event) {
        $("#createImg-container").css("display", "flex");
        $("#createImg").attr("src", event.target.result);
        $("#createImg").fadeIn(1000);
      };
      reader.readAsDataURL(file);
    }
  });
});
$(document).ready(function () {
  $(".editimg").change(function () {
    var file = this.files[0];
    if (file) {
      var reader = new FileReader();
      reader.onload = function (event) {
        $(".editimg-container").css("display", "flex");
        $(".editedimg").attr("src", event.target.result);
        $(".editedimg").fadeIn(1000);
      };
      reader.readAsDataURL(file);
    }
  });
});

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

let shoppingCart = document.querySelector(".shopping-cart");

document.querySelector("#cart-btn").onclick = () => {
  shoppingCart.classList.toggle("active");
  navbar.classList.remove("active");
  userWindow.classList.remove("active");
};

let navbar = document.querySelector(".navbar");

document.querySelector("#menu-btn").onclick = () => {
  navbar.classList.toggle("active");
  shoppingCart.classList.remove("active");
  userWindow.classList.remove("active");
};

let userWindow = document.querySelector(".user-window");

document.querySelector("#user-btn").onclick = () => {
  userWindow.classList.toggle("active");
  shoppingCart.classList.remove("active");
  navbar.classList.remove("active");
};

document.addEventListener("mouseup", function (e) {
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
