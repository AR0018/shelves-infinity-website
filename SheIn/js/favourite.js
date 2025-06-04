/**
 * Removes a product from the favourite.
 * @param codProdotto the ID of the product to remove from the favourite
 */
async function removeFromFavourite(codProdotto) {
    const url = `favourite-api.php?id=${codProdotto}`;
    const response = await fetch(url);

    if(!response.ok) {
        throw new Error("Response status: " + response.status);
    }

    const data = await response.json();
    const popup_fav = document.getElementById("pop-up-favourite");
    const button_fav = document.querySelector("#favourite #pop-up-favourite .close");
    button_fav.addEventListener("click", () => {
        popup_fav.style.display = "none";
    });

	window.onclick = () => popup_fav.style.display = "none";

    if(data["success"]) {
        document.getElementById("article" + codProdotto).remove();
        popup_fav.style.display = "flex";
        document.querySelector("#favourite .pop-up .pop-up-msg > p").innerText = data["message"];
    }
}

/**
 * Sets the handlers for every event in the page.
 */
function setHandlers() {
    const articles = document.getElementsByClassName("favourite-article");
    for(let i = 0; i < articles.length; i++) {
        const article = articles.item(i);
        const productId = article.getAttribute("id").slice(7);
        document.getElementById("remove" + productId)
            .addEventListener("click", () => removeFromFavourite(productId));
    }
}

setHandlers();