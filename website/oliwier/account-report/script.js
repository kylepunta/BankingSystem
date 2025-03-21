// Author   : Oliwier Jakubiec
// ID       : C00296807
// Date     : Mar 2025
// Purpose  : This file contains the javascript functions for the account-report page

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
        document.getElementById("dob").value = "";
        document.getElementById("phone").value = "";

        return;
    }
    // make an array of the customer details by splitting the result by the delimitter '#'
    var personDetails = result.split('#');
   
    // get elements and display the results in the array

    document.getElementById("custID").value = personDetails[0];
    document.getElementById("address").value = personDetails[1];
    document.getElementById("dob").value = personDetails[2];
    document.getElementById("phone").value = personDetails[3];


}

// function to undisable the fields so that they can be posted
function uncheckID() {
    // set all the fields to be enabled
    document.getElementById("custID").disabled = false;
    document.getElementById("address").disabled = false;
    document.getElementById("dob").disabled = false;
    document.getElementById("phone").disabled = false;
    return true;
}

// function to select the account
function showDetails(element) {

    // if the element is already selected, deselect it
    if (element.classList.contains("selectedAccount")) {
        element.classList.remove("selectedAccount");
        document.getElementById("submit").disabled = true;
        document.getElementById("accountNumber").value = "";
        return; // return to avoid the rest of the function
    }

    // get all the elements with the class name accountRow
    var array = document.getElementsByClassName("accountRow");
    // for each element in the array, remove the selectedAccount class
    for (var i = 0; i < array.length; i++) {
        array[i].classList.remove("selectedAccount")
    }

    // add the selectedAccount class to the clicked element
    element.classList.add("selectedAccount");
    // enable the submit button
    document.getElementById("submit").disabled = false;
    // set the value of the accountNumber hidden field to the id of the selected account
    document.getElementById("accountNumber").value = element.id;
}