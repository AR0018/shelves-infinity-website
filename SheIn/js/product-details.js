//Form submit product
const popup_product = document.getElementById("pop-up-product");
const popup_msg = document.querySelector(".product-details > #pop-up-product > .pop-up-msg");

//Pop-up product
const button_product = document.querySelector(".product-details #pop-up-product .close");
button_product.addEventListener("click", () => {
    popup_product.style.display = "none";
});

window.onclick = function(event) {
    popup_product.style.display = "none";
}

/**
 * Adds a product to the cart
 * @param product_id the ID of the product
 */
async function addToCart(product_id) {
    const quantity = document.getElementById("quantity").value;
    const url = `../shopping-cart/cart-api.php?id=${product_id}&quantity=${quantity}&action=add`;
    const response = await fetch(url);

    if(!response.ok) {
        throw new Error("Response status: " + response.status);
    }

    const data = await response.json();

    if(data["user_login"] === false) {
        window.location.replace("../user_management/login.php");
    }

    popup_product.style.display = "flex";
    if(!document.getElementById("popup_msg")) {
        const text = document.createElement("p");
        text.id = "popup_msg";
        text.innerText = data["message"];
        popup_msg.appendChild(text);
    } else {
        document.getElementById("popup_msg").innerText = data["message"];
    }

    // Sets the colour of the popup depending on the result of the operation
    const popupClass = data["success"] ? "pop-up good" : "pop-up error";
    document.getElementById("pop-up-product").className = popupClass;
}

/**
 * Adds a product as favourite
 * @param product_id the ID of the product
 */
async function addToFavourite(product_id) {
    const url = `../favourite/favourite-api.php?id=${product_id}&action=add`;
    const response = await fetch(url);

    if(!response.ok) {
        throw new Error("Response status: " + response.status);
    }

    const data = await response.json();
    if(data["user_login"] === false) {
        window.location.replace("../user_management/login.php");
    }

    popup_product.style.display = "flex";
    if(!document.getElementById("popup_msg")) {
        const text = document.createElement("p");
        text.id = "popup_msg";
        text.innerText = data["message"];
        popup_msg.appendChild(text);
    } else {
        document.getElementById("popup_msg").innerText = data["message"];
    }

    const popupClass = "pop-up good";
    document.getElementById("pop-up-product").className = popupClass;
}

/**
 * Sets the handlers for every event in the page.
 */
function setHandlers() {
    const productId = document.getElementById("articleID_input")
        .getAttribute("value");
    const favouriteButton = document.getElementById("favouriteButton");
    if(favouriteButton != null) {
        favouriteButton.addEventListener("click", () => addToFavourite(productId));
    }
    const cartButton = document.getElementById("cartButton");
    if (cartButton != null) {
        cartButton.addEventListener("click", () => addToCart(productId));
    }
}

setHandlers();
