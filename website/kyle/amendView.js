/*
    Name: Kyle Purcell
    Student Number: C00301808
    Date: 24/03/2025
    Description: A JS file that adds functionality to the Amend/View a Customer screen
*/


// select all relevant DOM elements using a querySelector method
const select = document.querySelector("#select-customer");
const options = document.querySelectorAll("option");
const formInputs = document.querySelectorAll("input:not(.form-buttons > input, #amend-view-button)");
const customerIDInput = document.querySelector("#customerID");
const amendViewBtn = document.querySelector("#amend-view-button");
const form = document.querySelector("form");

// event listener that invokes a callback function when DOM content has fully loaded
document.addEventListener("DOMContentLoaded", () => {
    // sets all necessary form inputs to disabled to prevent user making changes
    formInputs.forEach((input) => {
        input.disabled = true;
    })
})

// function that fills the input fields
function populateFields() {
    const result = select.options[select.selectedIndex].value; // stores the current selected value in result
    const customerDetails = result.split(","); // returns result as an array, with each element split by a comma
    // adds the corresponding value to the corresponding input field
    formInputs.forEach((input, index) => {
        input.value = customerDetails[index];
    });
}

// function that clears the necessary form input fields
function depopulateFields() {
    formInputs.forEach((input) => {
        input.value = "";
    })
}

// function that selects a customer by their ID value
function selectCustomerByID() {
    if (customerIDInput.value) { // if the customer ID input field contains a value
        let customerID = customerIDInput.value;
        select.value = options[customerID - 1].value; // assigns the select element value to be the index of the customer ID subtract 1
        populateFields(); // invokes the populateFields function
    } else {
        depopulateFields(); // invokes the depopulateFields function
    }
}

// function that toggles between Amend Details and View Details mode
function toggleSwitch() {
    if (amendViewBtn.value === "Amend Details") {
        amendViewBtn.value = "View Details"; // assigns the value "View Details" if the value is currently "Amend Details"
        enableFormInputs(); // invokes the enableFormInputs function to enable form inputs
    } else {
        amendViewBtn.value = "Amend Details";
        disableFormInputs(); // invokes the disableFormInputs function to disable form inputs
    }
}

// function that sets the necessary form inputs to be disabled
function disableFormInputs() {
    formInputs.forEach((input) => {
        input.disabled = true;
    })
}

// function that sets the necessary form inputs to be enabled
function enableFormInputs() {
    formInputs.forEach((input) => {
        input.disabled = false;
    })
}

// function that prompts the user to confirm their changes
function confirmDetails() {
    let response = confirm("Are you sure you want to amend this customer's details?");

    if (response) {
        // if the user confirms, invokes the enableFormInputs function before submitting the form
        enableFormInputs();
        return true;
    } else {
        // if the user cancels, invokes the populateFields function to repopulate the input fields
        populateFields();
        return false;
    }
}

// function that displays a confirmation dialog
function showConfirmation() {
    const main = document.querySelector("main"); // selects the main HTML element in the DOM
    const confirmationDialog = document.createElement("dialog"); // creates a dialog HTML element
    const confirmation = document.createElement("h2"); // creates a h2 HTML element
    confirmation.textContent = "The selected customer has been successfully amended";

    confirmationDialog.appendChild(confirmation); // appends the h2 element to the dialog element
    main.appendChild(confirmationDialog); // appends the dialog element to the main element
}

select.addEventListener("click", populateFields); // event listener that invokes populateFields when a click event occurs on the select element

customerIDInput.addEventListener("input", selectCustomerByID); // event listener that invokes selectCustomerByID when an input event occurs on the customer ID input element

amendViewBtn.addEventListener("click", toggleSwitch); // event listener that invokes toggleSwitch when a click event occurs on the Amend Details button

form.addEventListener("submit", confirmDetails); // event listner that invokes confirmDetails when the form submits