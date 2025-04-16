console.log("popup.js is loaded");

document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM fully loaded and parsed");

    const triggers = document.querySelectorAll(".trigger");
    const popups = document.querySelectorAll(".popup");
    const closeButtons = document.querySelectorAll(".close-button");

    triggers.forEach(trigger => {
        console.log("Attaching event listener to trigger");
        trigger.addEventListener("click", () => {
            console.log("Trigger clicked");
            const popupId = trigger.getAttribute("data-popup");
            const popup = document.getElementById(popupId);
            if (popup) {
                console.log("Showing popup: " + popupId);
                popup.style.display = "block";
            } else {
                console.error("Popup not found: " + popupId);
            }
        });
    });

    closeButtons.forEach(button => {
        button.addEventListener("click", () => {
            console.log("Close button clicked");
            popups.forEach(popup => {
                popup.style.display = "none";
            });
        });
    });

    window.addEventListener("click", (event) => {
        popups.forEach(popup => {
            if (event.target === popup) {
                console.log("Clicked outside popup, hiding popup");
                popup.style.display = "none";
            }
        });
    });
});
