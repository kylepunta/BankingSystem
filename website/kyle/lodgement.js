/*
    Name: Kyle Purcell
    Student Number: C00301808
    Date: 24/03/2025
    Description: A JS file that adds functionality to the Lodgements screen
*/

document.addEventListener("DOMContentLoaded", () => {
    const form = document.querySelector("#lodgements-form");
    const accountTypeDropdown = document.querySelector("#account-type");
    const customerAccountDropdown = document.querySelector("#account-dropdown");
    const customerOptions = document.querySelectorAll("#account-dropdown > option");
    const formInputs = document.querySelectorAll("input:not(#submitBtn)");
    const customerIDInput = document.querySelector("#customerID");
    const accountNumberInput = document.querySelector("#accountNumber");
    const lodgementAmount = document.querySelector("#lodgementAmount");

    accountTypeDropdown.addEventListener("change", () => {
        console.log(form);
        enableFormInputs();
        form.submit();
    })
    
    function populateFields() {
        const result = customerAccountDropdown.options[customerAccountDropdown.selectedIndex].value;
        console.log(result);
        const customerDetails = result.split(";");
        formInputs.forEach((input, index) => {
            input.value = customerDetails[index];
        });
        lodgementAmount.value = 0;
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
            customerAccountDropdown.value = customerOptions[customerID - 1].value;
            populateFields();    
        } else {
            depopulateFields();
        }
    }
    
    function selectCustomerByAccountNumber() {
        if (accountNumberInput.value) {
            let accountNumber = accountNumberInput.value;
            let customerArray = Array.from(customerOptions);
            let accountNumbers = customerArray.map((option) => {
                let result = option.value.split(";");
                return result[1];
            })
            for (let i = 0; i < accountNumbers.length; i++) {
                if (accountNumbers[i] == accountNumberInput.value) {
                    customerAccountDropdown.value= customerOptions[i].value;
                    populateFields();
                }
            }
        } else {
            depopulateFields();
        }
    }
    
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

    function enableFormInputs() {
        formInputs.forEach((input) => {
            input.disabled = false;
        })
    }
    
    function confirmLodgement() {
        let lodgementAmount = document.querySelector("#lodgementAmount");
        let response = confirm(`Are you sure you want to lodge the following amount: ${lodgementAmount.value}?`);
    
        if (response) {
            form.action = "./transaction.php";
            enableFormInputs();
            return true;
        } else {
            populateFields();
            return false;
        }
    }

    populateFields();

    disableFormInputs();
    
    customerAccountDropdown.addEventListener("click", populateFields);
    
    customerIDInput.addEventListener("input", selectCustomerByID);
    
    accountNumberInput.addEventListener("input", selectCustomerByAccountNumber);
    
    form.addEventListener("submit", confirmLodgement);
})