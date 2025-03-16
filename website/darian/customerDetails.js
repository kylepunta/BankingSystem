/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 15/03/2025
Customer Details */

// function that handles the customerNo from the inputbox
function inputCustomer(input) {
    // gets the form display for the customer id from the form
    const cid = document.getElementById("cid");

    // checks if the function is being run from select or not
    if (input.id == "name") {
        // checks that there is input
        if (input.value) {
            // splits the customer details from the selected customer
            const details = input.value.split(" §"); // details split by § as it shouldn't appear in a persons address (unlike commas)
            // sets the id from the customer details
            cid.value = details[0];
        } else {
            // sets the id to 0 if there's no input
            cid.value = "0";
        }
    }

    // gets the form on the page
    const form = document.querySelector("form");
    // temporarily stores the id
    let id = cid.value;
    // resets the inputs in the form
    form.reset();
    // updates the id on the form
    cid.value = id;
    // submits the form so that the customers details can be queried
    form.submit();
}
