const popup_notify = document.getElementById("pop-up-notify");
const button_notify = document.querySelector("#container-notify-sct #pop-up-notify .close");
button_notify.addEventListener("click", () => {
    popup_notify.style.display = "none";
});

window.onclick = function(event) {
    popup_notify.style.display = "none";
}

/**
 * Shows notification on the type.
 * @param type the type of the notification: 0 for "unread", 1 for "read"
 */
async function showNotifications(type) {
    const url = `notification-api.php?type=${type}`;
    const response = await fetch(url);

    if(!response.ok) {
        throw new Error("Response status: " + response.status);
    }

    const data = await response.json();

    if(data["user_login"] === false) {
        window.location.replace("../user_management/login.php");
    }

    let section_content = "";
    if(type === 1) {
        section_content = "<h3>Notifiche lette</h3>";
    } else {
        section_content = "<h3>Notifiche da leggere</h3>"
    }

    let notifications = data["notifications"];
    if(notifications.length == 0) {
        section_content += "<p>Non ci sono notifiche</p>";
    } else {
        for(let i = 0; i < notifications.length; i++) {
            if(type) {
                section_content += `
                <article id="article-notify${notifications[i]["codNotifica"]}">
                    <p>${notifications[i]["messaggio"]}</p>
                    <p>Data: ${notifications[i]["data"]}</p>
                    <button onclick="deleteNotification(${notifications[i]["codNotifica"]})">Rimuovi</button>
                </article>`;
            } else {
                section_content += `
                <article id="article-notify${notifications[i]["codNotifica"]}">
                    <p>${notifications[i]["messaggio"]}</p>
                    <p>Data: ${notifications[i]["data"]}</p>
                    <div>
                    <button onclick="deleteNotification(${notifications[i]["codNotifica"]})">Rimuovi</button>
                    <button onclick="readNotification(${notifications[i]["codNotifica"]})">Leggi</button>
                    </div>
                </article>`;
            }
        }
    }

    document.getElementById("notification").innerHTML = section_content;
}

/**
 * Removes the notification dot in the navbar icon in case there are no more unread notifications.
 */
function removeNotificationDot() {
    const notifications = document.querySelectorAll("#notification > article");
    if(notifications.length === 0) {
        document.getElementById("notification-dot").remove();
    }
}

/**
 * Reads notification by the id.
 * @param notify_id the id of the notification 
 */
async function readNotification(notify_id) {
    //const notify = [];
    //const checkbox = document.getElementById("notification").querySelectorAll("input");
    //const url = `notification/notification-api.php?id=${checkbox[0].id.split("checkbox")[1]}`;
    //const checkbox = document.getElementById(`checkbox${notify_id}`).checked;    
    //const url =`notification-api.php?id=${notify_id}&action=read&checkbox=${checkbox}`;
    const url = `notification-api.php?id=${notify_id}&action=read`;
    const response = await fetch(url);

    if(!response.ok) {
        throw new Error("Response status: " + response.status);
    }

    const data = await response.json();
    if(data["user_login"] === false) {
        window.location.replace("../user_management/login.php");
    }
    
    document.getElementById("article-notify" + notify_id).remove();
    // Displays the confirmation message
    showPopup(data["message"]);
    removeNotificationDot();
}

/**
 * Deletes notification by the id.
 * @param notify_id the id of the notification 
 */
async function deleteNotification(notify_id) {
    //const checkbox = document.getElementById(`checkbox${notify_id}`).checked;
    //const url =`notification-api.php?id=${notify_id}&action=delete&checkbox=${checkbox}`;
    const url =`notification-api.php?id=${notify_id}&action=delete`;
    const response = await fetch(url);

    if(!response.ok) {
        throw new Error("Response status: " + response.status);
    }

    const data = await response.json();
    if(data["user_login"] === false) {
        window.location.replace("../user_management/login.php");
    }

    document.getElementById("article-notify" + notify_id).remove();

    showPopup(data["message"]);
    removeNotificationDot();
}

/**
 * Sets the handlers for every event in the page.
 */
function setHandlers() {
    document.getElementById("show-unread-button")
        .addEventListener("click", () => showNotifications(0));
    document.getElementById("show-read-button")
        .addEventListener("click", () => showNotifications(1));
}

/**
 * Creates the structure for the pop-up
 * @param string message, the text to show 
 */
function showPopup(message) {
    document.querySelector("#container-notify-sct > #pop-up-notify").style.display = "flex";
    pop_up_text = document.querySelector("main > #container-notify-sct .pop-up-msg > p");
    /*pop_up_text.insertAdjacentHTML("afterbegin", pop_up);*/
    pop_up_text.textContent = message;
}

setHandlers();
showNotifications(0);