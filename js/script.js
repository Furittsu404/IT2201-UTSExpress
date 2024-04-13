const loginBtn = document.querySelector("#login");
const registerBtn = document.querySelector("#register");
const forgotPasswordBtn = document.querySelector("#forgot-password");
const loginForm = document.querySelector(".login-form");
const registerForm = document.querySelector(".register-form");
const forgotPasswordForm = document.querySelector(".forgot-password-form");


loginBtn.addEventListener("click", () => {
  loginBtn.style.backgroundColor = "green";
  registerBtn.style.backgroundColor = "rgba(255, 255, 255, 0.2)";

  loginForm.style.left = "50%";
  registerForm.style.left = "150%";
  forgotPasswordForm.style.bottom = "-150%";

  loginForm.style.opacity = "1";
  registerForm.style.opacity = "0";
  forgotPasswordForm.style.opacity = "0";
});

registerBtn.addEventListener("click", () => {
  loginBtn.style.backgroundColor = "rgba(255, 255, 255, 0.2)";
  registerBtn.style.backgroundColor = "green";

  loginForm.style.left = "-50%";
  registerForm.style.left = "50%";
  forgotPasswordForm.style.bottom = "-150%";

  loginForm.style.opacity = "0";
  registerForm.style.opacity = "1";
  forgotPasswordForm.style.opacity = "0";
});

forgotPasswordBtn.addEventListener("click", () => {
  loginBtn.style.backgroundColor = "rgba(255, 255, 255, 0.2)";
  registerBtn.style.backgroundColor = "rgba(255, 255, 255, 0.2)";

  loginForm.style.left = "-50%";
  registerForm.style.left = "150%";
  forgotPasswordForm.style.bottom = "35%";

  loginForm.style.opacity = "0";
  registerForm.style.opacity = "0";
  forgotPasswordForm.style.opacity = "1";
});

function register() {
  loginBtn.style.backgroundColor = "rgba(255, 255, 255, 0.2)";
  registerBtn.style.backgroundColor = "green";

  loginForm.style.left = "-50%";
  registerForm.style.left = "50%";
  forgotPasswordForm.style.bottom = "-150%";

  loginForm.style.opacity = "0";
  registerForm.style.opacity = "1";
  forgotPasswordForm.style.opacity = "0";
}
window.onload = function() {
  if (window.location.hash == '#reg') {
      register();
  }
};
