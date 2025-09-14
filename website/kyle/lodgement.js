/*
    Name: Kyle Purcell
    Student Number: C00301808
    Date: 24/03/2025
    Description: A JS file that adds functionality to the Lodgements screen
*/

// document event listener that invokes a callback function when DOM content is loaded
document.addEventListener("DOMContentLoaded", () => {
    // selects elements in the DOM
    const form = document.querySelector("#lodgements-form");
    const accountTypeDropdown = document.querySelector("#account-type");
    const customerAccountDropdown = document.querySelector("#account-dropdown");
    const customerOptions = document.querySelectorAll("#account-dropdown > option");
    const formInputs = document.querySelectorAll("input:not(#submitBtn)");
    const customerIDInput = document.querySelector("#customerID");
    const accountNumberInput = document.querySelector("#accountNumber");
    const lodgementAmount = document.querySelector("#lodgementAmount");

    // event listener that invokes a callback function when the select value changes
    accountTypeDropdown.addEventListener("change", () => {
        enableFormInputs(); // invokes the enableFormInputs function
        form.submit(); // submits the form
    })
    
    // function that retrieves the selected customer account's values and populates the input fields 
    // with their corresponding values
    function populateFields() {
        const result = customerAccountDropdown.options[customerAccountDropdown.selectedIndex].value;
        const customerDetails = result.split(";");
        formInputs.forEach((input, index) => {
            input.value = customerDetails[index];
        });
        lodgementAmount.value = 0;
    }
    
    // function that clears the values from the input fields
    function depopulateFields() {
        formInputs.forEach((input) => {
            input.value = "";
        })
    }
    
    // function that selects a customer by their ID and populates the input fields
    function selectCustomerByID() {
        if (customerIDInput.value) {
            let customerID = customerIDInput.value;
            customerAccountDropdown.value = customerOptions[customerID - 1].value;
            populateFields();    
        } else {
            depopulateFields();
        }
    }
    
    // functon that selects a customer by their account number and populates the input fields
    function selectCustomerByAccountNumber() {
        if (accountNumberInput.value) {
            let accountNumber = accountNumberInput.value;
            let customerArray = Array.from(customerOptions); // creates an array from the customer options node list
            let accountNumbers = customerArray.map((option) => {
                // map returns a new array from the data in customerArray
                let result = option.value.split(";"); // returns the values as an array, split by ";"
                return result[1]; // returns the element at index 1 (accountNumber)
            })
            for (let i = 0; i < accountNumbers.length; i++) {
                // loop through each accountNumber and check if it matches the account number input field's value
                if (accountNumbers[i] == accountNumberInput.value) {
                    // if true, customerAccountDropdown value is assigned the value of the customer account option element
                    customerAccountDropdown.value= customerOptions[i].value;
                    populateFields();
                }
            }
        } else {
            depopulateFields();
        }
    }
    
    // function that disables form inputs
    function disableFormInputs() {
        formInputs[2].disabled = true;
        formInputs[3].disabled = true;
        formInputs[4].disabled = true;
        formInputs[5].disabled = true;
        formInputs[6].disabled = true;
        formInputs[7].disabled = true;
        formInputs[8].disabled = true;
        formInputs[9].disabled = true;
    }

    // function that enables form inputs
    function enableFormInputs() {
        formInputs.forEach((input) => {
            input.disabled = false;
        })
    }
    
    // function that prompts the user to confirm their changes
    function confirmLodgement(event) {
        let lodgementAmount = document.querySelector("#lodgementAmount");
        let response = confirm(`Are you sure you want to lodge the following amount: ${lodgementAmount.value}?`);
    
        if (response) { // user clicks confirm
            form.action = "./transaction.php"; // sets the action of the form element
            enableFormInputs();
        } else { // user clicks cancel
            populateFields();
            event.preventDefault();
        }
    }

    populateFields(); // invokes populateFields when DOM content is loaded

    disableFormInputs(); // invokes disableFormInputs when DOM content is loaded
    
    // event listener that invokes populateFields when user clicks on customer account dropdown
    customerAccountDropdown.addEventListener("click", populateFields);
    
    // event listener that invokes selectCustomerByID when user types in the customer ID input field
    customerIDInput.addEventListener("input", selectCustomerByID);
    
    // event listener that invokes selectCustomerByAccountNumber when user types in the account number input field
    accountNumberInput.addEventListener("input", selectCustomerByAccountNumber);
    
    // event listener that invokes confirmLodgement when user submits the form
    form.addEventListener("submit", confirmLodgement);
})