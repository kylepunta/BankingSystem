/*
    Name: Kyle Purcell
    Student Number: C00301808
    Date: 24/03/2025
    Description: A JS file that adds functionality to the Delete Customer screen
*/

const form = document.querySelector("#delete-customer-form"); // selects the form element

function confirmDeletion() {
    // if the users confirms deletion, it submits the form. Otherwise, it returns to the previous screen
    let response = confirm("Are you sure you want to delete this customer?");
    if (response) {
        return true;
    } else {
        return false;
    }
}

// event listener that invokes the confirmDeletion function when the form submits
form.addEventListener("submit", confirmDeletion);

