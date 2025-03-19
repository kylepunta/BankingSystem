 // Author   : Oliwier Jakubiec
// ID       : C00296807
// Date     : Mar 2025
// Purpose  : This file contains the javascript functions for the amend/view loan account page

 // function to display a customer and their account details based on the value in listbox
function populate() {
    // get the listbox element
    var sel = document.getElementById("listbox");
    // get the selected item in the dropdown
    var result = sel.options[sel.selectedIndex].value;
    document.getElementById("submit").disabled = true;

    if (result == "placeholder") {
        // if the placeholder is selected clear the fields
        document.getElementById("custID").value = "";
        document.getElementById("address").value = "";
        document.getElementById("eircode").value = "";
        document.getElementById("dob").value = "";
        document.getElementById("phone").value = "";
        document.getElementById("closeAccountNumber").value = "";
        document.getElementById("balance").value = "";
        return;
    }
    // make an array of the customer details by splitting the result by the delimitter '#'
    var personDetails = result.split('#');

    // get elements and display the results in the array

    document.getElementById("custID").value = personDetails[0];
    document.getElementById("address").value = personDetails[1];
    document.getElementById("eircode").value = personDetails[2];
    document.getElementById("dob").value = personDetails[3];
    document.getElementById("phone").value = personDetails[4];
    document.getElementById("closeAccountNumber").value = personDetails[5];
    document.getElementById("balance").value = personDetails[6];
}

// function to check if the user wants to really submit the updated form 
function confirmCheck() {
    // check if the form is valid first
    if (!checkValid()) {return false;}
    
    // declare variable
    var response;
    // confirm returns true if the Ok option is selected
    response = confirm('Are you sure you want to delete this account?');
    if (response) { // check for "ok"
        return true;	// returns trues
    } else {	// the user cancelled the confirmation 
        return false;
    }
}

// function to check if the form is valid
function checkValid() {

    // get the balance value
    var balance = document.getElementById("balance").value; 
    // check if the balance is not 0
    if (balance != 0) {
        alert("Balance must be 0 to close the account");
        return false;
    }
    return true;
}

// function to disable the submit button
function disableSubmit() {
    var submit = document.getElementById("submit");
    submit.disabled = true;
}
