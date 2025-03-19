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
    document.getElementById("toggle").disabled = true;

    if (result == "placeholder") {
        // if the placeholder is selected clear the fields
        document.getElementById("custID").value = "";
        document.getElementById("address").value = "";
        document.getElementById("eircode").value = "";
        document.getElementById("dob").value = "";
        document.getElementById("phone").value = "";
        document.getElementById("AccountNumber").value = "";
        document.getElementById("balance").value = "";
        document.getElementById("loanAmount").value = "";
        document.getElementById("term").value = "";
        document.getElementById("repayments").value = "";
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
    document.getElementById("AccountNumber").value = personDetails[5];
    document.getElementById("balance").value = personDetails[6];
    document.getElementById("repayments").value = personDetails[7];
    document.getElementById("term").value = personDetails[8];
    document.getElementById("loanAmount").value = personDetails[9];

}

// function to check if the user wants to really submit the updated form 
function confirmCheck() {
    
    // declare variable
    var response;
    // confirm returns true if the Ok option is selected
    response = confirm('Are you sure you want to save these changes?');
    if (response) { // check for "ok"
        return true;	// returns trues
    } else {	// the user cancelled the confirmation 
        return false;
    }
}

// function to disable the fields when the user changes account
function unconfirmAccount() {
    document.getElementById("term").disabled = true;
    document.getElementById("loanAmount").disabled = true;
    document.getElementById("toggle").disabled = true;
    document.getElementById("submit").disabled = true;
}

// function to toggle the form between view and amend
function toggleForm() {
    
    // get the value of the button
    var toggleButton = document.getElementById("toggle").value;
    // if its set to amend details, change it to view details
    // and enable the fields
    if (toggleButton == "Amend Details") {
        document.getElementById("toggle").value = "View Details";
        document.getElementById("term").disabled = false;
        document.getElementById("loanAmount").disabled = false;
        document.getElementById("submit").disabled = false;
    }
    else { // if its set to view details, change it to amend details and disable the fields
        document.getElementById("toggle").value = "Amend Details";
        document.getElementById("term").disabled = true;
        document.getElementById("loanAmount").disabled = true;
        document.getElementById("submit").disabled = true;
    }
    
}