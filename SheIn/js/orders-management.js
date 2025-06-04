/**
 * Updates the state of the specified order and sends a notification to the user.
 * @param order_id the ID of the order to be updated
 * @param action the action with which to update the state of the order
 */
async function updateOrderState(order_id, action) {
    const url = `update-order.php?id=${order_id}&action=${action}`;
    const response = await fetch(url);

    if(!response.ok) {
        throw new Error("Response status: " + response.status);
    }

    const data = await response.json();

    if(data["user_login"] === false) {
        window.location.replace("../user_management/login.php");
    }

    if(data["error_msg"]) {
        throw new Error(data["error_msg"]);
    }

    if(data["new_text"]) {
        document.getElementById(`order_button${order_id}`).innerText = data["new_text"];
        document.getElementById(`action${order_id}`).value = "deliver";
    } else {
        document.getElementById(`order_button${order_id}`).remove();
        document.getElementById(`action${order_id}`).remove();
    }

    document.getElementById(`order_status${order_id}`).innerText = `Stato: ${data["new_state"]}`;
}

/**
 * Sets the handlers for every event in the page.
 */
function setHandlers() {
    const orderButtons = document.getElementsByClassName("order_button");
    for(let i = 0; i < orderButtons.length; i++) {
        const orderButton = orderButtons.item(i);
        const orderId = orderButton.getAttribute("id").slice(12);
        orderButton.addEventListener("click", () =>
            {
                const action = document.getElementById("action" + orderId).getAttribute("value");
                updateOrderState(orderId, action);
            });
    }
}

setHandlers();
