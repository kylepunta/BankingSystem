/* Name: Brandon Jaroszczak
Student ID: C00296052
Month: March 2025
Purpose: javascript functions used by the main HTML page for deposit account history */

// populates all relevant form fields with data from the dropdown menu
function populate() {
    // get the value from the dropdown menu and put them into the fields
    const sel = document.getElementById("listbox");
    const result = sel.options[sel.selectedIndex].value;
    const personDetails = result.split(' ¬'); // ¬ is used as the delimiter
    // populate the fields
	document.getElementById("custNumber").value = personDetails[0];
    document.getElementById("name").value = personDetails[1];
	document.getElementById("accNumber").value = personDetails[2];
}

// checks is the end date not before the start date
function checkDates() {
    // if the start date and end date both have values in them check, otherwise dont check
    if (document.getElementById("startDate").value && document.getElementById("endDate").value) {
        const startDate = new Date(document.getElementById("startDate").value);
        const endDate = new Date(document.getElementById("endDate").value);

        if (endDate < startDate) {
            // if end date is before the start date alert user and prevent form from submitting
            alert("End date must not be before starting date!");
            return false;
        }
    }
    return true;
}