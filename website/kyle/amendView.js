const select = document.querySelector("#select-customer");
const options = document.querySelectorAll("option");
const formInputs = document.querySelectorAll(".customer-info > p > input:not(.form-buttons > input)");
const customerIDInput = document.querySelector("#customerID");
const amendViewBtn = document.querySelector("#amend-view-button");
const form = document.querySelector("form");

document.addEventListener("DOMContentLoaded", () => {
    formInputs.forEach((input) => {
        input.disabled = true;
    })
})

function populateFields() {
    const result = select.options[select.selectedIndex].value;
    const customerDetails = result.split(",");
    formInputs.forEach((input, index) => {
        input.value = customerDetails[index];
    });
}

function depopulateFields() {
    formInputs.forEach((input) => {
        input.value = "";
    })
}

function selectCustomerByID() {
    console.log(customerIDInput.value);
    if (customerIDInput.value) {
        let customerID = customerIDInput.value;
        select.value = options[customerID - 1].value;
        populateFields();    
    } else {
        depopulateFields();
    }
}

function toggleSwitch() {
    if (amendViewBtn.value === "Amend Details") {
        amendViewBtn.value = "View Details";
        formInputs.forEach((input) => {
            enableFormInputs();
        })
    } else {
        amendViewBtn.value = "Amend Details";
        formInputs.forEach((input) => {
            disableFormInputs();
        })
    }
}

function disableFormInputs() {
    formInputs.forEach((input) => {
        input.disabled = true;
    })
}

function enableFormInputs() {
    formInputs.forEach((input) => {
        input.disabled = false;
    })
}

function confirmDetails() {
    let response = confirm("Are you sure you want to amend this customer's details?");

    if (response) {
        enableFormInputs();
        return true;
    } else {
        populateFields();
        return false;
    }
}

function showConfirmation() {
    const main = document.querySelector("main");
    const confirmationDialog = document.createElement("dialog");
    const confirmation = document.createElement("h2");
    confirmation.textContent = "The selected customer has been successfully amended";

    confirmationDialog.appendChild(confirmation);
    main.appendChild(confirmationDialog);
}

select.addEventListener("click", populateFields);

customerIDInput.addEventListener("input", selectCustomerByID);

amendViewBtn.addEventListener("click", toggleSwitch);

form.addEventListener("submit", confirmDetails);