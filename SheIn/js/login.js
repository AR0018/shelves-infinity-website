/**
 * Sets the handlers for every event in the page.
 */
function setHandlers() {
    document.querySelector(".login > .inputs-forms > .switch > label").addEventListener("change", () => {
		let psw = document.getElementById("password-lg");
		if (psw.type === "password") {
			psw.type = "text";
		} else {
			psw.type = "password";
		}
	});

    // Searches for the error message popup
    const popup_lgn = document.getElementById("pop-up-login");

	if(popup_lgn) {
		popup_lgn.style.display = "flex";

		// Sets the handlers for closing the popup

		const button_lgn = document.querySelector(".login #pop-up-login .close");
		button_lgn.addEventListener("click", () => {
			popup_lgn.style.display = "none";
		});

		window.onclick = () => popup_lgn.style.display = "none";
	}
}

setHandlers();