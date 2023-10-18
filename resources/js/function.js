function isNull(elem){
  const element = document.querySelectorAll(elem);
  return element.length < 1 ? true : false;
}

function addEvent(element, type, callback, selector = "single"){
  const target = 
  selector === "all" ? 
  document.querySelectorAll(element) : 
  document.querySelector(element);

  if(target === null || target.length == 0) return

  if(selector === "single"){
    target.addEventListener(type, callback);
    return
  }
  
  target.forEach(el => {
    el.addEventListener(type, callback);
  })
}

function showLoader(){
  const loader = document.querySelector('.loader');
  loader.classList.add('show');
}

function hideLoader(){
  const loader = document.querySelector('.loader');
  loader.classList.remove('show');
}

function dynamicStyling(elem, style, type = "add"){
  const element = document.querySelectorAll(elem);

  element.forEach(el => {
    type === "remove" ? el.classList.remove(style) : el.classList.add(style);
  })
}

function modal(target, isVisible){
  const element = document.querySelector(target);

  const keyframes = { visibility: "visible", opacity: "100%" } 

  if(!isVisible){
    location.reload();
    return
  }
  
  animated(element, keyframes, {
    duration: 300,
    easing: "ease-in-out",
    fill: "forwards"
  });
}

function previewUpload(e){
  const accepted = ["image/jpeg", "image/png", "image/svg+xml"];
  
  if(!accepted.includes(e.target.files[0].type)){
    toast("Invalid image extension", "error");
    return
  }

  const parent = e.target.parentElement;
  const image = parent.querySelector(".upload-overview");
  const icon = parent.querySelector(".icon");

  const fileReader = new FileReader();

  fileReader.onload = (e) => {
    icon.classList.add("hidden");
    image.removeAttribute("hidden");
    image.src = e.target.result;
  }

  fileReader.readAsDataURL(e.target.files[0]);
}

function resetUpload(form){
  const image = form.querySelector(".upload-overview");
  const icon = form.querySelector(".icon");

  icon.classList.remove("hidden");
  image.setAttribute("hidden", "");
  image.src = "";
}

function setCheckbox(e, elem, type = "set"){
  const parent = e.target.parentElement;
  const input = parent.querySelector("input");

  if(type === "set"){
    input.value = e.target.dataset.value;
    dynamicStyling(elem, "selected", "remove");
    e.target.classList.add("selected");
    return
  }
  input.value = "";
  dynamicStyling(elem, "selected", "remove");
}

// function to allow only numbers to the input field
function isNumeric(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode (key);
  var regex = /[0-9]|\./;
  if ( !regex.test(key) ) {
      theEvent.returnValue = false;
      if(theEvent.preventDefault) theEvent.preventDefault();
  }
}