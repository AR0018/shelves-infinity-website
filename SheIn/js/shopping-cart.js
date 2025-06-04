/**
 * Checks whether the cart contains any products.
 * @returns True if there are any products in the cart, false otherwise
 */
function areThereAnyProducts() {
    const remainingProducts = document.querySelectorAll("#cart-article > article");
    return remainingProducts.length != 0;
}

/**
 * Shows the "No product in the cart" message.
 */
function showNoProducts() {
    document.getElementById("cart-article").remove();
    document.querySelector("#container-cart > aside").remove();
    document.getElementById("container-cart").innerHTML += `
    <article>
        <p>Nessun prodotto nel carrello.</p>
    </article>`;
}

/**
 * Removes a product from the cart.
 * @param product_id the ID of the product to remove from the cart
 */
async function removeFromCart(product_id) {
    const url = `cart-api.php?id=${product_id}&action=remove`;
    const response = await fetch(url);

    if(!response.ok) {
        throw new Error("Response status: " + response.status);
    }

    const data = await response.json();
    if(data["success"]) {
        document.getElementById("article" + product_id).remove();

        if(areThereAnyProducts()) {
            setTotalPrice();
        } else {
            showNoProducts();
        }
    }
}

/**
 * Modifies the quantity of a product in the cart.
 * @param product_id the ID of the product
 * @param new_quantity the new quantity of the product in the cart
 * @param input_id the value of the "id" attribute of the input tag that called this function 
 */
async function modifyQuantity(product_id, new_quantity, input_id) {
    const url = `cart-api.php?id=${product_id}&quantity=${new_quantity}&action=update`;
    const response = await fetch(url);

    if(!response.ok) {
        throw new Error("Response status: " + response.status);
    }

    const data = await response.json();
    if(data["request_error"]) {
        throw new Error(data["request_error"]);
    }

    const myInputCart =  document.getElementById(input_id);
    myInputCart.addEventListener("animationend", () => {
        myInputCart.classList.remove("active");
    });

    if(data["success"]) {
        setTotalPrice();
    } else {
        myInputCart.value = data["old_quantity"];
        myInputCart.classList.add("active");
    }
}

/**
 * Sets the total price of the items in the cart.
 */
async function setTotalPrice() {
    const url = "shopping-cart-total.php";
    const response = await fetch(url);

    if(!response.ok) {
        throw new Error("Response status: " + response.status);
    }
    const data = await response.json();

    document.getElementById("total_price").innerText = "Totale: " + data["total_price"] + "€";
    if(data["msg"]) {
        let message_paragraph = `<p>${data["msg"]}</p>`;
        let form = document.querySelector("main > section > aside > form");
        form.innerHTML = form.innerHTML + message_paragraph;
    }

    if(!data["can_purchase"]) {
        let submit_button = document.getElementById("purchase_button");
        submit_button.setAttribute("disabled", "true");
    }
}

/**
 * Sets the handlers for every event in the page.
 */
function setHandlers() {
    const articles = document.querySelectorAll("#cart-article > article");
    if(articles.length != 0) {
        for(let i = 0; i < articles.length; i++) {
            const article = articles.item(i);
            const productId = article.getAttribute("id").slice(7);
            const quantityInput = document.getElementById("quantity" + productId);
            quantityInput.addEventListener(
                "input",
                (e) => {
                    modifyQuantity(
                        productId,
                        e.target.value,
                        e.target.id);
                });
            document.getElementById("remove" + productId)
                .addEventListener("click", () => removeFromCart(productId));
        }
    }
}

if(areThereAnyProducts()) {
    setTotalPrice();
}
setHandlers();
