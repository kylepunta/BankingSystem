/* Name: Brandon Jaroszczak
Student ID: C00296052
Month: March 2025
Purpose: javascript functions used by the main HTML page for viewing a new deposit account */

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
}

// When the dropdown value is changed populate fields and submit form using javascript to load in last 10 transactions with PHP
function submitForm() {
    populate();
    document.getElementById('customerDetailsForm').submit();
}