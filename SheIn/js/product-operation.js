/**
 * Adds a new genre to the database.
 * @param {String} name the name of the new genre.
 *  Strings with no whitespaces will be considered invalid.
 * @returns {String} the error message of the operation, null if the operation was successful
 */
async function addGenre(name) {
    const url = "../genres/genres-api.php";

    const requestData = new FormData();
    requestData.append("operation", "add");
    requestData.append("new_genre", name);

    let error_message = null;

    const response = await fetch(url, {
        method: "POST",
        body: requestData
    });
    
    if(response.ok) {
        const responseJson = await response.json();
        if(responseJson.error_msg) {
            error_message = responseJson.error_msg;
        }
    } else {
        error_message = "Si è verificato un errore nella comunicazione con il server";
    }

    return error_message;
}

/**
 * Returns the ID corresponding to the given name
 * @param {String} name the name to convert
 * @returns {String} the corresponding ID
 */
function getNameID(name) {
    return name.replace(/\s+/g, "_").toLowerCase();
}

/**
 * Returns the given string without any space characters.
 * @param {String} string the input string
 */
function removeSpaces(string) {
    return string.replace(/\s+/g, "");
}

/**
 * Displays a popup with the given error message
 * @param {String} errorMsg the error message to show
 */
function showErrorMessage(errorMsg) {
    document.getElementById("popup-genre-error-msg").innerText = errorMsg;
    document.getElementById("popup-add-genre").style.display = "flex";
}

/**
 * Hides the error message popup
 */
function removeErrorMessage() {
    document.getElementById("popup-add-genre").style.display = "none";
}

/**
 * Inserts the given genre as a checkbox option inside the form
 * @param {String} genreName the name of the genre 
 */
function insertGenreCheckbox(genreName) {
    const genreCheckbox = `
        <div>
            <input type="checkbox" name="${genreName}" id="${getNameID(genreName)}" value="${genreName}" />
            <label for="${getNameID(genreName)}">${genreName}</label>
        </div>`;
    document.getElementById("container-genre").innerHTML += genreCheckbox;
}

async function processGenreForm() {
    const newGenreTextField = document.getElementById("new-genre-text");
    const newGenre = newGenreTextField.value;

    let errorMsg = null;
    if(removeSpaces(newGenre) !== "") {
        errorMsg = await addGenre(newGenre);
    } else {
        errorMsg = "Il nome inserito per il genere non è valido.";
    }

    if(errorMsg) {
        showErrorMessage(errorMsg);
    } else {
        insertGenreCheckbox(newGenre);
        removeErrorMessage();
        newGenreTextField.value = "";
    }
}

/**
 * Sets the handlers for every event in the page.
 */
function setHandlers() {
    document.getElementById("new-genre-form").addEventListener("submit", (e) => {
        e.preventDefault();
        e.target.checkValidity();
        processGenreForm();
    });
    document.getElementById("close-genre-popup-button")
        .addEventListener("click", removeErrorMessage);
    window.onclick = removeErrorMessage;
}

setHandlers();