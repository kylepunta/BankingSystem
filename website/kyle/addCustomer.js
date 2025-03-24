/*
    Name: Kyle Purcell
    Student Number: C00301808
    Date: 24/03/2025
    Description: A JS file that adds functionality to the Add Customer webpage
*/

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