"use strict";

const passwordField = document.querySelector('.form input[type="password"]');
const showPasswordBtn = document.querySelector(".form .field i");

showPasswordBtn.addEventListener("click", function () {
  if (passwordField.type == "password") {
    passwordField.type = "text";
    showPasswordBtn.classList.add("active");
  } else if (passwordField.type == "text") {
    passwordField.type = "password";
    showPasswordBtn.classList.remove("active");
  }
});
