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
}
const balanceInput = document.getElementById('balance');
const message = document.querySelector('.message');

// Function to update the message with the current balance
function updateMessage() {
	const balance = balanceInput.value; // Get the current value of the balance
	message.textContent = `The current balance is: ${balance}`; // Update the message
}

// Initially set the message when the page loads
window.onload = updateMessage;

// Add an event listener to update the message whenever the balance changes
balanceInput.addEventListener('input', updateMessage);

function finalCheck() {
	return confirm("Are you sure you want to create a new deposit account?");
}