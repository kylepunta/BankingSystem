const form = document.querySelector("#add-customer-form");

function confirmChanges() {
    let response = confirm("Are you sure you want to add a new customer?");
    if (response) {
        return true;
    } else {
        return false;
    }
}

form.addEventListener("submit", confirmChanges);