/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 03/03/2025
Close Current Account */

// function that checks the user wants to submit the form
function confirmSubmit() {
    // displays a confirmation box to the user, the form will be submitted if they press OK
    if (confirm("Are you sure you want to close this current account?")) {
        // sets the hidden confirmed value for the server to read
        document.getElementById("confirmed").value = "1";
        return true;
    } else {
        return false;
    }
}
