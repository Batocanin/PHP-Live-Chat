"use strict";

const form = document.querySelector(".typing-area");
const inputField = form.querySelector(".input-field");
const sendBtn = form.querySelector("button");
const chatBox = document.querySelector(".chat-box");

sendBtn.addEventListener("click", function (e) {
  e.preventDefault();
  const xhr = new XMLHttpRequest(); // XML object
  xhr.open("POST", "includes/insert-chat.php", true);
  xhr.addEventListener("load", function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        inputField.value = "";
        scrollToBottom();
      }
    }
  });
  const formData = new FormData(form); // formData object
  xhr.send(formData);
});

chatBox.addEventListener("mouseenter", function () {
  chatBox.classList.add("active");
});

chatBox.addEventListener("mouseleave", function () {
  chatBox.classList.remove("active");
});

setInterval(function () {
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "includes/get-chat.php", true);
  xhr.addEventListener("load", function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const data = xhr.response;
        chatBox.innerHTML = data;
        if (!chatBox.classList.contains("active")) {
          scrollToBottom();
        }
      }
    }
  });
  const formData = new FormData(form);
  xhr.send(formData);
}, 500);

function scrollToBottom() {
  chatBox.scrollTop = chatBox.scrollHeight;
}
