/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 13/02/2025
Open Current Account */

// function that checks the user wants to submit the form
function confirmSubmit() {
    // displays a confirmation box to the user, the form will be submitted if they press OK
    if (confirm("Are you sure you want to open this current account?")) {
        document.getElementById("confirmed").value = "1";
        return true;
    } else {
        return false;
    }
}

// function that handles the cancel
function cancel() {
    // gets the form inputs
    const cid = document.getElementById("cid");
    // gets the form on the page
    const form = document.querySelector("form");

    // clears the values on the form
    cid.value = "";
    // submits the form so that the screen is fresh
    form.submit();
}