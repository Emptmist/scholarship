//For sidebar to close when certain viewport is reached
const sidebar = document.querySelector(".sidebar");
const sidebarBtn = document.querySelector(".bx-menu");

function toggleSidebar() {
    const viewportWidth = window.innerWidth;
    if (viewportWidth > 1210) { // Only allow toggling if viewport is wider than 768px
        sidebar.classList.toggle("close");
    }
}

function handleResize() {
    const viewportWidth = window.innerWidth;
    if (viewportWidth <= 1210) { // Close sidebar and disable toggle for small screens
        sidebar.classList.add("close");
        sidebarBtn.removeEventListener("click", toggleSidebar);
    } else {
        sidebarBtn.addEventListener("click", toggleSidebar);
    }
}

sidebarBtn.addEventListener("click", toggleSidebar);
window.addEventListener("resize", handleResize);

// Initial check
handleResize();

