/**
 * Opens the side nav of the web page.
 */
function openNav() {
    document.getElementsByClassName("sidebar")[0].style.width = "250px";
}

/**
 * Closes the side nav of the web page.
 */
function closeNav() {
    document.getElementsByClassName("sidebar")[0].style.width = "0";
}

/**
 * Sets the handlers for every event in the page.
 */
function setHandlers() {
    document.getElementById("close-nav-button")
        .addEventListener("click", closeNav);
    document.getElementById("open-nav-button")
        .addEventListener("click", openNav);
}

setHandlers();


const form = document.createElement("form");
form.role = "search";
form.id = "search-form";
form.method = "get";

const label = document.createElement("label");
label.htmlFor = "nome";

const input = document.createElement("input");
input.id = "nome";
input.name = "nome";
input.type = "search";
input.placeholder = "Cerca..";
input.autocomplete = "off";

const button = document.createElement("button");
button.id = "cerca";
button.type = "submit";

const span = document.createElement("span");
span.className = "material-symbols-outlined";
span.innerText = "search";

button.appendChild(span);
form.appendChild(label);
form.appendChild(input);
form.appendChild(button);

function mediaQueryHeader(x) {
    const header = document.querySelector("body > header");
    const navigator = document.querySelector(".cnt-navigator > nav");
    if (x.matches) { // If media query matches
        let header_form = document.querySelector(".cnt-navigator > nav > #search-form");
        if (document.querySelector("body > header > #search-form") == null) {
            form.action = header_form.action;
            header_form.parentNode.removeChild(header_form);
            header.appendChild(form);
        }
    } else {
        let header_form = document.querySelector("body > header > #search-form")
        if (document.querySelector(".cnt-navigator > nav > #search-form") == null) {
            form.action = header_form.action;
            header_form.parentNode.removeChild(header_form);
            navigator.insertAdjacentElement("afterbegin", form);
        }
    }
  }
  
  const list = document.querySelector("body > header > .cnt-navigator > nav > ul");
  const x = window.matchMedia("(max-width: 640px)");

  mediaQueryHeader(x);
  
  // Attach listener function on state changes
  x.addEventListener("change", function() {
    mediaQueryHeader(x);
});