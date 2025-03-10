function populate() {
    // get the value from the dropdown menu and put them into the fields
    const sel = document.getElementById("listbox");
    const result = sel.options[sel.selectedIndex].value;
    const personDetails = result.split(' ¬');
	document.getElementById("custNumber").value = personDetails[0];
    document.getElementById("name").value = personDetails[1];
	document.getElementById("accNumber").value = personDetails[2];
}

function checkDates() {
    if (document.getElementById("startDate").value && document.getElementById("endDate").value) {
        const startDate = new Date(document.getElementById("startDate").value);
        const endDate = new Date(document.getElementById("endDate").value);

        if (endDate < startDate) {
            alert("End date must not be before starting date!");
            return false;
        }
    }
    return true;
}