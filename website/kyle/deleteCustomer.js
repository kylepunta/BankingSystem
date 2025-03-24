/*
    Name: Kyle Purcell
    Student Number: C00301808
    Date: 24/03/2025
    Description: A JS file that adds functionality to the Delete Customer screen
*/

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

