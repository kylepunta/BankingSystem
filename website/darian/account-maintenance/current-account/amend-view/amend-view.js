/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 06/03/2025
Amend/View Current Account */

// function that checks the user wants to submit the form
function confirmSubmit() {
    // displays a confirmation box to the user, the form will be submitted if they press OK
    if (confirm("Are you sure you want to amend this current account?")) {
        document.getElementById("confirmed").value = "1";
        return true;
    } else {
        return false;
    }
}

// function that handles the account number from the inputbox
function inputAccount(input) {
    // gets the form display for the account number from the form
    const cid = document.getElementById("cid");
    // const accountno = document.getElementById("accountno");

    // gets the form on the page
    const form = document.querySelector("form");
    // temporarily stores the account number
    // let accno = accountno.value;
    // resets the inputs in the form
    // form.reset();
    // updates the account number on the form
    // accountno.value = accno;
    // updates the account number on the form
    if (input.value) cid.value = "";
    // submits the form so that the accounts details can be queried
    form.submit();
}

// function that handles the cancel
function cancel() {
    // gets the form inputs
    const cid = document.getElementById("cid");
    const accountno = document.getElementById("accountno");
    // gets the form on the page
    const form = document.querySelector("form");

    // clears the values on the form
    cid.value = "";
    accountno.value = "";
    // submits the form so that the screen is fresh
    form.submit();
}

// function that toggles between amend/view
function toggleLock() {
    // checks the state of the amend button
    if (document.getElementById("amendViewbutton").value == "Amend Details") {
        // amend state, change to view state
        // disables the text inputs
        document.getElementById("overdraftlimit").disabled = false;
        // updates the label on the button
        document.getElementById("amendViewbutton").value = "View Details";
    } else {
        // view state, change to amend state
        // enables the text inputs
        document.getElementById("overdraftlimit").disabled = true;
        // updates the label on the button
        document.getElementById("amendViewbutton").value = "Amend Details";

        // gets the form on the page
        const form = document.querySelector("form");
        // resets the form back to the details from the database
        form.reset();
    }
}
