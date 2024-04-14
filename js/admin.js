function editStudent(id) {
  window.location.href = "edit.php?id=" + id;
}

function deleteStudent(id) {
  window.location.href = "delete.php?id=" + id;
}

function createNewRecord() {
  window.location.href = "create.php";
}

let searchbar = document.querySelector("#search-bar");

document.querySelector("#search-icon").onclick = () => {
    searchbar.classList.toggle("drop");
}

function showHideRow(row) {
    $("#"+row).toggle();
}

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
  element.value = element.value.replace(/[^a-zA-Z0-9!@#$%^&*\-_=+,./?\\|`~ ]/g, "");
}
