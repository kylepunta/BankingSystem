function populate() {
    // get the value from the dropdown menu and put them into the fields
    var sel = document.getElementById("listbox");
    var result;
    result = sel.options[sel.selectedIndex].value;
    var personDetails = result.split(',');
	document.getElementById("number").value = personDetails[0];
    document.getElementById("name").value = personDetails[1];
    document.getElementById("address").value = personDetails[2];
    document.getElementById("eircode").value = personDetails[3];
    document.getElementById("dob").value = personDetails[4];
}

function confirmSubmit() {
    const name = document.getElementById("name").value;
    const address = document.getElementById("address").value;
    const eircode = document.getElementById("eircode").value;
    const dob = document.getElementById("dob").value;

    if (!name || !address || !eircode || !dob) {
        return false; 
    } else {
        return confirm("Are you sure you want to use this account?")
    }
}

function toggleInputs() {
    const accNo = document.getElementById("accNo").value;

    if (accNo) {
        document.getElementById("balance").disabled = false;
		document.getElementById("listbox").disabled = true;
		document.getElementById("chooseCustomerButton").disabled = true;
		document.getElementById("confirmCustomerButton").disabled = true;
		document.getElementById("number").disabled = true;
		document.getElementById("submitCustomer").disabled = false;
    } 
}

function finalCheck() {
	return confirm("Are you sure you want to create a new deposit account?");
}