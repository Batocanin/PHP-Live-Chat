"use strict";

const searchBar = document.querySelector(".users .search input");
const searchBtn = document.querySelector(".users .search button");
const usersList = document.querySelector(".users-list");

searchBtn.addEventListener("click", function () {
  searchBar.classList.toggle("active");
  searchBar.focus();
  searchBtn.classList.toggle("active");
  searchBar.value = "";
});

searchBar.addEventListener("keyup", function () {
  const searchTerm = searchBar.value;
  if (searchTerm != "") {
    searchBar.classList.add("active");
  } else {
    searchBar.classList.remove("active");
  }
  const xhr = new XMLHttpRequest();
  xhr.open("POST", "includes/search.php", true);
  xhr.addEventListener("load", function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const data = xhr.response;
        usersList.innerHTML = data;
      }
    }
  });
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("searchTerm=" + searchTerm);
});

setInterval(function () {
  const xhr = new XMLHttpRequest();
  xhr.open("GET", "includes/users.php", true);
  xhr.addEventListener("load", function () {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const data = xhr.response;
        if (!searchBar.classList.contains("active")) {
          // ukoliko search bar ima active, da ne radi update liste
          usersList.innerHTML = data;
        }
      }
    }
  });
  xhr.send();
}, 500);
