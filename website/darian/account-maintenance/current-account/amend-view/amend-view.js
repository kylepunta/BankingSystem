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
