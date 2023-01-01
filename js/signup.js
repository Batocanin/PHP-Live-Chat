"use strict";

const form = document.querySelector(".signup form");
const registerBtn = document.querySelector(".button input");
const errorText = document.querySelector(".error-txt");

registerBtn.addEventListener("click", function (e) {
  e.preventDefault();
  const xhr = new XMLHttpRequest(); // XML object
  xhr.open("POST", "includes/signup.inc.php", true);
  xhr.addEventListener("load", function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const data = xhr.response;
        if (data == "success") {
          location.href = "users.php";
        } else {
          errorText.textContent = data;
          errorText.style.display = "block";
        }
      }
    }
  });
  const formData = new FormData(form); // formData object
  xhr.send(formData);
});
