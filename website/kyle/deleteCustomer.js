const form = document.querySelector("#delete-customer-form");

function confirmDeletion() {
    let response = confirm("Are you sure you want to delete this customer?");
    if (response) {
        return true;
    } else {
        return false;
    }
}

form.addEventListener("submit", confirmDeletion);

