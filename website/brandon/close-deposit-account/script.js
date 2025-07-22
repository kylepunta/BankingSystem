/* Name: Brandon Jaroszczak
Student ID: C00296052
Month: March 2025
Purpose: javascript functions used by the main HTML page for closing a new deposit account */

// Populate the form fields with the data from the dropdown box
function populate() {
    // get the value from the dropdown menu and put them into the fields
    const sel = document.getElementById("listbox");
    const result = sel.options[sel.selectedIndex].value;
    const personDetails = result.split(' ¬'); // ¬ has to be used as addresses may contain a , inside them breaking the string
    // populate the fields
	document.getElementById("custNumber").value = personDetails[0];
    document.getElementById("name").value = personDetails[1];
    document.getElementById("address").value = personDetails[2];
    document.getElementById("eircode").value = personDetails[3];
    document.getElementById("dob").value = personDetails[4];
	document.getElementById("accNumber").value = personDetails[5];
    document.getElementById("balance").value = personDetails[6];

    // get the balance of the account and store it
    const value = parseFloat(document.getElementById("balance").value);

    // If balance is === 0 then display no message and unlock the "Delete account" button
    if (value === 0) {
        document.getElementById("message").style.display = "none";
        document.getElementById("message").innerHTML = "";
        document.getElementById("deleteCustomer").disabled = false;
    } else {
        // If balance is anything other than 0 then display a message and lock the "Delete account" button
        document.getElementById("message").style.display = "flex";
        document.getElementById("message").innerHTML = "Account cannot be closed as its balance is not 0!<br>Please withdraw any remaining funds and try again."
        document.getElementById("deleteCustomer").disabled = true;
    }
}

// If the "Close account" button was clicked double check do you want to close the account
function submitCheck() {
    if (document.activeElement.value === "Close account") {
		return confirm("Are you sure you want to close this account?");
	} else {
	    return true;
    }
}