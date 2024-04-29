const displayedOpts = document.getElementById("displayed-header-opts");

const menuIcon = document.getElementById("menu-icon");

menuIcon.addEventListener("click" , () => {
    displayedOpts.style.display = "flex";
});

const closeMenu = document.getElementById("close-header-opts");

closeMenu.addEventListener("click" , () => {
    displayedOpts.style.display = "none";
})

