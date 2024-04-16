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
  $("#product_Image").change(function () {
    var file = this.files[0];
    if (file) {
      var reader = new FileReader();
      reader.onload = function (event) {
        $("#productImage-container").css("display", "flex");
        $("#productImage").attr("src", event.target.result);
        $("#productImage").hide(0);
        $("#productImage").fadeIn(1000);
      };
      reader.readAsDataURL(file);
    }
  });
});
