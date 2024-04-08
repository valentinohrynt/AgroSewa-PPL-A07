let sideMenu = document.querySelectorAll(".nav-link");
sideMenu.forEach((item) => {
  let li = item.parentElement;

  item.addEventListener("click", () => {
    sideMenu.forEach((link) => {
      link.parentElement.classList.remove("active");
    });
    li.classList.add("active");
  });
});

let menuBar = document.querySelector(".menu-btn");
let sideBar = document.querySelector(".sidebar");
menuBar.addEventListener("click", () => {
  sideBar.classList.toggle("hide");
});

// let switchMode = document.getElementById("switch-mode");
// switchMode.addEventListener("change", (e) => {
//   if (e.target.checked) {
//     document.body.classList.add("dark");
//   } else {
//     document.body.classList.remove("dark");
//   }
// });

window.addEventListener("resize", () => {
  if (window.innerWidth > 576) {
    searchIcon.classList.replace("fa-times", "fa-search");
    searchFrom.classList.remove("show");
  }
  if (window.innerWidth < 768) {
    sideBar.classList.add("hide");
  }
  if (window.innerWidth > 768) {
    sideBar.classList.remove("hide");
  }
});

if (window.innerWidth < 768) {
  sideBar.classList.add("hide");
}
if (window.innerWidth > 768) {
  sideBar.classList.remove("hide");
}