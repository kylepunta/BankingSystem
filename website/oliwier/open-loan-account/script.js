// Name: Oliwier Jakubiec
// Date: Feb 2025
// ID : C00296807
// Title: js file for the open loan account page

// function to display a customer details based on the value in listbox
function populate() {
    // get the listbox element
    var sel = document.getElementById("listbox");
    // get the selected item in the dropdown
    var result = sel.options[sel.selectedIndex].value;

    if (result == "placeholder") {
        // if the placeholder is selected clear the fields
        document.getElementById("custID").value = "";
        document.getElementById("address").value = "";
        document.getElementById("eircode").value = "";
        document.getElementById("dob").value = "";
        document.getElementById("phone").value = "";
        document.getElementById("accountNumber").value = "";
        document.getElementById("loanAmount").disabled = true;
        document.getElementById("loanAmount").value= "";
        document.getElementById("term").disabled = true;
        document.getElementById("term").value = "";
        document.getElementById("repayments").value = "";
        return;
    }
    // make an array of the customer details by splitting the result by the delimitter ','
    var personDetails = result.split('#');

    // get elements and display the results in the array
    document.getElementById("custID").value = personDetails[0];
    document.getElementById("address").value = personDetails[1];
    document.getElementById("eircode").value = personDetails[2];
    document.getElementById("dob").value = personDetails[3];
    document.getElementById("phone").value = personDetails[4];

    document.getElementById("loanAmount").disabled = false;
    document.getElementById("term").disabled = false;
}

// function to check if the user wants to really submit the updated form 
function confirmCheck() {
    // chek if the form is valid first
    if (!checkValid()) {return false;}
    
    // declare variable
    var response;
    // confirm returns true if the Ok option is selected
    response = confirm('Are you sure you want to save these changes?');
    if (response) { // check for "ok"
        // enable the textboxes as disabled boxes cannot send their data
        document.getElementById("repayments").disabled = false;
        return true;	// returns trues
    } else {	// the user cancelled the confirmation 
        return false;
    }
}

// check if the form is valid
function checkValid() {

    // get the elements to check
    var loanAmount = document.getElementById("loanAmount");
    var term = document.getElementById("term");
    var payments = document.getElementById("repayments");
    var accountNo = document.getElementById("accountNumber");
    // get the listbox element
    var sel = document.getElementById("listbox");
    // get the selected item in the dropdown
    var result = sel.options[sel.selectedIndex].value;

    // the dropdown is set to placeholder
    if (result == "placeholder") {
        alert("Please select a customer");
        return false;
    }
    // check if the loan amount is a positive number
    if (loanAmount.value == "" || loanAmount.value < 0) {
        alert("Please enter the loan amount as a positive number");
        return false;
    }
    // check if the term is a positive number
    if (term.value== "" || loanAmount.value < 0) {
        alert("Please enter the term length as a positive number");
        return false;
    }
    // check if the repayments are calculated
    if (payments.value == "") {
        alert("Please calculate the repayment amounts");
        return false;
    }
    // check if the account number is generated
    if (accountNo.value == "") {
        alert("Please confirm the customer to generate the account number");
        return false;
    }
    // return true if all checks pass
    return true;
}

// function to clear repayments when the user changes the loan amount or term
function clearRepayments() {
    // get the repayments element
    var payments = document.getElementById("repayments").value;
    // clear the field
    payments = "";
    document.getElementById("repayments").disabled = false;
    document.getElementById("repayments").value = "";
    document.getElementById("repayments").disabled = true;
}

// function to check if repayments are valid
function checkValidRepay() {
    // get the element to check
    var term = document.getElementById("term").value;
    if (term == 0) {
        alert("Please enter the term length as a positive number");
        return false;
    }
    return true;

}