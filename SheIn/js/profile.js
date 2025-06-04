// Global variables declaration
const sidenav = document.getElementById("sidenav-profile");
const initialHeight = sidenav.offsetHeight;

/**
 * Changes the username of the current user.
 * @param {String} newUsername the new username
 */
async function modifyUsername(newUsername) {
    const url = "../profile/restore-settings.php";
    const formData = new FormData();
    formData.append("new_usr", newUsername);

    const response = await fetch(url, {
        method: "POST",
        body: formData
    })

    if(!response.ok) {
        throw new Error("Response status: ", response.status);
    }

    const responseJson = await response.json();

    if(responseJson.username_msg) {
        if(responseJson.success) {
            document.querySelector("#profile > h2 > strong").innerText = `Bentornato ${newUsername}`;
            showPopup("Notifica username", responseJson.username_msg, true);
        } else {
            showPopup("Notifica username", responseJson.username_msg, false);
        }
    }
}

/**
 * Changes the password of the current user.
 * @param {String} oldPassword the previous password
 * @param {String} newPassword the new password
 */
async function modifyPassword(oldPassword, newPassword) {
    const url = "../profile/restore-settings.php";
    const formData = new FormData();
    formData.append("old_psw", oldPassword);
    formData.append("new_psw", newPassword);

    const response = await fetch(url, {
        method: "POST",
        body: formData
    })

    if(!response.ok) {
        throw new Error("Response status: ", response.status);
    }

    const responseJson = await response.json();

    if(responseJson.password_msg) {
        if(responseJson.success) {
            showPopup("Notifica password", responseJson.password_msg, true);
        } else {
            showPopup("Notifica password", responseJson.password_msg, false);
        }
    }
}

/**
 * Shows the "general informations" screen in the page.
 */
function showInfo() {
    document.querySelectorAll("#profile .sct-profile").forEach(e => e.style.display = "none");
    document.querySelector("#profile #general-info").style.display = "block";
    sidenav.style.height = initialHeight + "px";
}

const mediaSelection = window.matchMedia("(min-width: 700px)");

/**
 * Shows the "modify username" screen in the page.
 */
function showModifica() {
    document.querySelectorAll("#profile .sct-profile").forEach(e => e.style.display = "block");
    document.querySelector("#profile #general-info").style.display = "none";
    document.querySelector("#profile #modify-username").style.margin = "0px 0px 10px 0px";
    if(window.matchMedia("(min-width: 700px)").matches) {
        sidenav.style.height = document.getElementById("profile-sct").clientHeight + "px";
    }
}

/**
 * This function checks if the window is smaller than the size included in the query.
 * @param {Boolean} x the media query
 */
function mediaMatch(x) {
    if(!x.matches) {
        sidenav.style.height = initialHeight + "px";
    }
}

mediaMatch(mediaSelection);

mediaSelection.addEventListener("change", function() {
    mediaMatch(mediaSelection);
});

/**
 * Shows a popup message in the page
 * @param {String} title the title of the popup
 * @param {String} message the message of the popup
 * @param {Boolean} success whether to show a success popup or an error popup
 */
function showPopup(title, message, success) {
    document.getElementById("pop-up-profile-title").innerText = title;
    document.getElementById("pop-up-profile-message").innerText = message;
    const popupClass = success ? "pop-up good" : "pop-up error";
    document.getElementById("pop-up-profile").className = popupClass;
    document.getElementById("pop-up-profile").style.display = "flex";
}

function setHandlers() {
    //Informazioni generali
    const generali = document.getElementById("generali-link");
    generali.addEventListener("click", showInfo);
    
    //Modifica
    const modifica = document.getElementById("modifica-link");
    modifica.addEventListener("click", showModifica);
    
    const popup = document.getElementById("pop-up-profile");
    popup.style.display = "none";

    //Form submit username
    document.getElementById("modify-username-form").addEventListener("submit", (e) => {
        e.preventDefault();
        e.target.checkValidity();
        const newUsername = document.getElementById("new_usr").value;
        document.getElementById("new_usr").value = "";
        modifyUsername(newUsername);
    })

    //Form submit password
    document.getElementById("modify-password-form").addEventListener("submit", (e) => {
        e.preventDefault();
        e.target.checkValidity();
        const oldPassword = document.getElementById("old_psw").value;
        const newPassword = document.getElementById("new_psw").value;
        const confirmPassword = document.getElementById("confirm-psw").value;
        document.getElementById("old_psw").value = "";
        document.getElementById("new_psw").value = "";
        document.getElementById("confirm-psw").value = "";
        if(newPassword === confirmPassword) {
            modifyPassword(oldPassword, newPassword);
        } else {
            showPopup("Notifica password", "Il campo 'Conferma password' deve corrispondere con la nuova password.", false);
        }
    })

    //Pop-up closing handlers
    const closePopupButton = document.querySelector("#profile #pop-up-profile .close");
    closePopupButton.addEventListener("click", () => {
        popup.style.display = "none";
    });

    window.onclick = () => popup.style.display = "none";
}

setHandlers();
