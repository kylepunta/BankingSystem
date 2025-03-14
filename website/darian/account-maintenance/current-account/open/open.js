/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 13/02/2025
Open Current Account */

// function that handles the customerNo from the inputbox
function inputCustomer(input) {
  const form = document.querySelector("form");

  form.submit();
}

// function that handles displaying the customer details in the form
function populate(select) {
  // get and store the form displays
  const cid = document.getElementById("cid");
  const addr = document.getElementById("address");
  const eircode = document.getElementById("eircode");
  const dob = document.getElementById("dob");

  // checks that the default (none) customer is selected
  if (select.selectedIndex == 0) {
    // clears the customer details in the form
    addr.value = "";
    eircode.value = "";
    dob.value = "";
    // removes the account number from the form
    showAccountNo(false);
    return;
  }

  // stores the currently selected customer details
  const result = select.options[select.selectedIndex].value;
  // splits the customer details into an array
  const details = result.split(" §"); // details split by § as it shouldn't appear in a persons address (unlike commas)
  // takes the customer details out of the array
  // updates the customer details in the form
  cid.setCustomValidity("");
  cid.value = details[0];
  addr.value = details[1];
  eircode.value = details[2];
  dob.value = details[3];
  // shows the account number on the form
  showAccountNo(true);
}

// function that checks the user wants to submit the form
function confirmSubmit() {
  // displays a confirmation box to the user, the form will be submitted if they press OK
  return confirm("Are you sure you want to open this current account?")
}
