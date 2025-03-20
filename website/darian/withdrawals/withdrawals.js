/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 10/03/2025
Withdrawals */

// function that checks the user wants to submit the form
function confirmSubmit() {
    // displays a confirmation box to the user, the form will be submitted if they press OK
    if (confirm("Are you sure you want to make this withdrawal?")) {
        // the account type needs to be POSTed, it must be enabled before submitting the form
        document.getElementById("accounttype").disabled = false;
        document.getElementById("confirmed").value = "1";
        return true;
    } else {
        return false;
    }
}
