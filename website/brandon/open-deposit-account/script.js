/* Name: Brandon Jaroszczak
Student ID: C00296052
Month: February 2025
Purpose: javascript functions used by the main HTML page for opening a new deposit account */

// populates all relevant form fields with data from the dropdown menu
function populate() {
    // get the value from the dropdown menu and put them into the fields
    const sel = document.getElementById("listbox");
    const result = sel.options[sel.selectedIndex].value;
    const personDetails = result.split(' ¬'); // ¬ has to be used as addresses may contain a , inside them breaking the string
	// populate the fields
	document.getElementById("number").value = personDetails[0];
    document.getElementById("name").value = personDetails[1];
    document.getElementById("address").value = personDetails[2];
    document.getElementById("eircode").value = personDetails[3];
    document.getElementById("dob").value = personDetails[4];
}

// Function run when the "Confirm details" button is pressed
function confirmSubmit() {
	if (document.activeElement.value === "Confirm details") {
		const name = document.getElementById("name").value;
		const address = document.getElementById("address").value;
		const eircode = document.getElementById("eircode").value;
		const dob = document.getElementById("dob").value;

		// If form fields are not filled in (i.e. a customer was not selected, don't submit the form)
		if (!name || !address || !eircode || !dob) {
			return false; 
		}
	}
	// Submit the form
	return true;
}

// Function ran when the page is loaded, if the accountNo value is generated this means that the customer is selected and locks the selection fields and dropdown to prevent tampering
function toggleInputs() {
	// get the value of accNo field
    const accNo = document.getElementById("accNo").value;
	// If field has something in it (generated account number), lock/unlock the relevant fields, dropdown and buttons
    if (accNo) {
        document.getElementById("balance").disabled = false;
		document.getElementById("listbox").disabled = true;
		document.getElementById("chooseCustomerButton").disabled = true;
		document.getElementById("confirmCustomerButton").disabled = true;
		document.getElementById("number").readOnly = true;
		document.getElementById("submitCustomer").disabled = false;
		document.getElementById("clearButton").disabled = false;
	}
}

// asks the user for confirmation for creating a new account
function finalCheck() {
	return confirm("Are you sure you want to create a new deposit account?");
}

// asks the user for confirmation for resetting the form
function resetPage() {
	if (confirm("Are you sure you want to cancel creating an account?")) {
		// Submit the form with javascript to run session_destroy() in php later
		document.getElementById("lowerForm").submit();
	}
}