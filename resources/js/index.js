showLoader();

window.addEventListener('load', () => {
  hideLoader();
})

addEvent("body", "click", () => {
  const searchBar = document.querySelector(".searchbar");
  if(!isNull(".searchbar")) searchBar.style.display = "none";
})

addEvent(".menu-btn", "click", () => {
  dynamicStyling(".header__menu", "show");
})

addEvent(".close-menu", "click", () => {
  dynamicStyling(".header__menu", "show", "remove");
})

addEvent(".login-btn", "click", () => {
  dynamicStyling(".header__menu", "show", "remove");
  dynamicStyling(".modal", "show");
  dynamicStyling(".signup-container", "show", "remove");
  dynamicStyling(".login-container", "show");
}, "all")

addEvent(".close-modal", "click", () => {
  dynamicStyling(".modal", "show", "remove");
}, "all")

addEvent(".show-create-account", "click", () => {
  dynamicStyling(".login-container", "show", "remove");
  dynamicStyling(".signup-container", "show");
})

addEvent(".show-login", "click", () => {
  dynamicStyling(".signup-container", "show", "remove");
  dynamicStyling(".login-container", "show");
})

addEvent(".upload-container", "click", (e) => {
  const upload = e.target.querySelector("input");
  upload.click();
})

addEvent(".upload-input", "change", (e) => {
  previewUpload(e);
})

addEvent(".cancel-order-btn", "click", (e) => {
  const parent = e.target.parentElement.parentElement.parentElement;
  const cancelContainer = parent.querySelector(".cancel-order");
  cancelContainer.classList.add("show");
}, "all")

addEvent(".confirm-btn", "click", (e) => {
  const parent = e.target.parentElement.parentElement;
  parent.classList.remove("show");
}, "all")

addEvent(".cancel-btn", "click", (e) => {
  const parent = e.target.parentElement.parentElement;
  parent.classList.remove("show");
}, "all")

addEvent(".search-btn", "click", (e) => {
  e.stopPropagation();
  const searchBar = document.querySelector(".searchbar");
  searchBar.style.display = "block";
})

addEvent(".searchbar", "click", (e) => {
  e.stopPropagation();
})

addEvent(".upload-profile", "click", () => {
  const dpInput = document.querySelector(".dp-input");
  dpInput.click();
})

addEvent(".dp-input", "change", (e) => {
  const accepted = ["image/jpeg", "image/png", "image/svg+xml"];
  
  if(!accepted.includes(e.target.files[0].type)){
    toast("Invalid image extension", "error");
    return
  }

  const image = document.querySelector(".profile-image");

  const fileReader = new FileReader();

  fileReader.onload = (e) => {
    image.src = e.target.result;
  }

  fileReader.readAsDataURL(e.target.files[0]);
})

addEvent(".order-type", "click", (e) => {
  setCheckbox(e, ".order-type", "set");
}, "all")

addEvent(".pmethod", "click", (e) => {
  setCheckbox(e, ".pmethod", "set");
}, "all")

addEvent(".menu-size", "click", ({ target }) => {
  const parent = target.parentElement;
  const menuSizes = parent.querySelectorAll(".menu-size");
  menuSizes.forEach(menuSize => menuSize.classList.remove("active"));
  target.classList.add("active");
}, "all")

addEvent(".notification", "click", ({ currentTarget }) => {
  const notifDropdown = currentTarget.querySelector('.notification-dropdown');
  notifDropdown.classList.toggle('hidden');
}, "all")

addEvent(".addons", "click", ({ target }) => {
  target.classList.toggle("active");
}, "all")

addEvent(".code-input", "input", ({ target }) => {
  const nextInput = target.nextElementSibling;

  if (target.value !== "" && nextInput) {
    nextInput.focus();
  } 
}, "all")

addEvent(".code-input", "keydown", (e) => {
  const { key, target } = e;
  const prevInput = target.previousElementSibling;

  if (target.value === "" && key === "Backspace" && prevInput) {
    prevInput.focus();
  } 
}, "all")