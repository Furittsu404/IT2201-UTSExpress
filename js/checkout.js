function numberOnly(id) {
  var element = document.getElementById(id);
  element.value = element.value.replace(/[^0-9]/gi, "");
}

function letterOnly(id) {
  var element = document.getElementById(id);
  element.value = element.value.replace(/[^a-zA-Z0-9@-_,.`~ ]/g, "");
}
function validSymbol(id) {
  var element = document.getElementById(id);
  element.value = element.value.replace(
    /[^a-zA-Z0-9!@#$%^&*\-_=+,./?\\|`~ ]/g,
    ""
  );
}
