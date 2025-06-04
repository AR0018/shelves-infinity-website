/**
 * Sets the handlers for every event in the page.
 */
function setHandlers() {
    const popup_rgst = document.getElementById("pop-up-register");
    if(popup_rgst) {
        popup_rgst.style.display = "flex";

        // Sets the handlers for closing the popup

        document.querySelector(".register #pop-up-register .close")
            .addEventListener("click", () => {
                popup_rgst.style.display = "none";
        });
        
        window.onclick = () => popup_rgst.style.display = "none";
    }
}

setHandlers();
