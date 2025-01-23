const dropdownChildren = document.querySelectorAll(".dropdown > *:not(button)");
const dropdowns = document.querySelectorAll(".dropdown");

dropdownChildren.forEach((dropdownChildren) => {
    dropdownChildren.classList.toggle("hidden");
})

dropdowns.forEach((dropdown) => {
    dropdown.addEventListener("click", (event) => {
        // Prevent event from bubbling up and affecting parent dropdowns
        event.stopPropagation();

        // Toggle the 'hidden' class for all child elements of the clicked dropdown
        const children = dropdown.querySelectorAll(":scope > *:not(button)"); // Select all child elements except <h3>
        children.forEach((child) => {
            child.classList.toggle("hidden");
        });
    });
});