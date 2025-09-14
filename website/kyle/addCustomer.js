/*
    Name: Kyle Purcell
    Student Number: C00301808
    Date: 24/03/2025
    Description: A JS file that adds functionality to the Add Customer webpage
*/

const form = document.querySelector("#add-customer-form"); // selects the form element

function confirmChanges(event) {
    // if the user confirms changes, it submits the form. Otherwise, it returns to the screen
    let response = confirm("Are you sure you want to add a new customer?");
    if (!response) {
        event.preventDefault();
    } 
}

form.addEventListener("submit", confirmChanges); // event listener that invokes the confirmChanges function when form submits