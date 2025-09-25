document.addEventListener("DOMContentLoaded", function () {
    const logoToggle = document.getElementById("logoToggle");
    const navLink = document.getElementById("navLink");

    logoToggle.addEventListener("click", function () {
        navLink.classList.toggle("show");
    });
});
