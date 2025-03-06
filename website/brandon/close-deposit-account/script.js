function populate() {
    // get the value from the dropdown menu and put them into the fields
    const sel = document.getElementById("listbox");
    const result = sel.options[sel.selectedIndex].value;
    const personDetails = result.split(' ¬'); // ¬ has to be used as addresses may contain a , inside them breaking the string
	document.getElementById("custNumber").value = personDetails[0];
    document.getElementById("name").value = personDetails[1];
    document.getElementById("address").value = personDetails[2];
    document.getElementById("eircode").value = personDetails[3];
    document.getElementById("dob").value = personDetails[4];
	document.getElementById("accNumber").value = personDetails[5];
    document.getElementById("balance").value = personDetails[6];

    const value = parseFloat(document.getElementById("balance").value);

    if (value === 0) {
        document.getElementById("message").innerHTML = "";
        document.getElementById("deleteCustomer").disabled = false;
    } else {
        document.getElementById("message").innerHTML = "Account cannot be closed as its balance is not 0!<br>Please withdraw any remaining funds and try again."
        document.getElementById("deleteCustomer").disabled = true;
    }
}

function submitForm() {
    populate();
    document.getElementById('customerDetailsForm').submit();
}

function submitCheck() {
    if (document.activeElement.value === "Close account") {
		return confirm("Are you sure you want to close this account?");
	} else {
	    return true;
    }
}