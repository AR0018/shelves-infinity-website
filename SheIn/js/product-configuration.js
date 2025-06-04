const popup_admin = document.getElementById("pop-up-admin");

/**
 * Closes the message popup in the page.
 */
function closePopup() {
    popup_admin.style.display = "none";
    window.history.pushState(null, null, "product-configuration.php");
}

/**
 * Sets the handlers for every event in the page.
 */
function setHandlers() {    
    if(popup_admin) {
        popup_admin.style.display = "flex";

        // Sets the handlers for closing the popup
        document.querySelector("#admin-products-page #pop-up-admin .close")
            .addEventListener("click", () => {
                closePopup();
        });

        window.onclick = () => closePopup();
    }
}

setHandlers();
