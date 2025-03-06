/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 03/03/2025
Close Current Account */

// function that handles the customerNo from the inputbox
function inputCustomerCid(input) {
  // gets the customerNo from the input
  const id = input.value;
  // gets the select element
  const select = document.getElementById("name");
  let i = 0;
  // compares each select option to the given id
  while (i < select.options.length &&
    // compares the id in the select option to the given id
    select.options[i].value.split(" §")[0] != id) {
    // no matching select option found, continue
    i++;
  }
  // checks if the correct select option was found
  if (i < select.options.length) {
    // show to the user that the input was valid
    input.setCustomValidity("");
    // updates the select
    select.selectedIndex = i;
  } else {
    // show to the user that the input was invalid
    input.setCustomValidity(input.value + " isn't a customer number.");
    // no matching select option found
    // updates the select to default
    select.selectedIndex = 0;
  }
  // updates the customer details in the form
  populate(select);
}

// function that handles displaying the customer details in the form
function populate(select) {
  // get and store the form displays
  const cid = document.getElementById("cid");
  const addr = document.getElementById("address");
  const eircode = document.getElementById("eircode");
  const dob = document.getElementById("dob");

  // customer has changed, always clear the inputted account number
  const accountno = document.getElementById("accountno");
  accountno.value = "";
  // call the related function to clear the ac
  inputAccount(accountno);

  // checks that the default (none) customer is selected
  if (select.selectedIndex == 0) {
    // clears the customer details in the form
    addr.value = "";
    eircode.value = "";
    dob.value = "";
    // removes the account number from the form
    // showAccountNo(false);
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
  // showAccountNo(true);

  updateAccountOptions();
}

// function that checks the user wants to submit the form
function confirmSubmit() {
  // TODO is popup or setCustomValidity better?
  const value = document.getElementById("accountbal").value;
  // parses the value from the input display
  const bal = parseInt(value.split("€")[1]);
  // checks that the account balance is 0
  if (bal != 0) {
    // alerts the user if the account balance isn't 0
    alert("The account balance must be 0. Please change to the Withdrawals screen to empty the customers account.")
    return false;
  }

  // displays a confirmation box to the user, the form will be submitted if they press OK
  return confirm("Are you sure you want to close this current account?")
}

// TODO do I need to allow for input of the account number straight away? (without choosing a customer first, it would then need to show the customer details)

// function that handles the accountNo from the inputbox
function inputAccount(input) {
  // get and store the form displays
  const cid = document.getElementById("cid");
  const bal = document.getElementById("accountbal");
  const odlimit = document.getElementById("overdraftlimit");

  // initialise loop variables
  let i = 0;
  let continueLoop = true;

  // skip checking if there's no input
  if (!input.value) continueLoop = false, i = accounts.length;

  // loop through all the accounts
  // to find if the inputted account belongs to the customer
  while (continueLoop && i < accounts.length) {
    // stores information about the current account
    const acc = accounts[i]
    const customerNo = acc[0];
    const accountNo = acc[2];

    // checks that the user inputted account number matches this one
    // AND that the user inputted customer matches this one
    if (input.value == accountNo && cid.value == customerNo) {
      // stop looping, the inputted account does belong to the inputted customer
      continueLoop = false;
    } else {
      // continue looping
      i++;
    }
  }

  // check that a matching account was found
  if (i < accounts.length) {
    // a matching account was found, clear any errors on the input
    input.setCustomValidity("");

    // store the balance of the account
    let balance = accounts[i][3];

    // check if the account is in credit or debit
    if (balance == 0) {
      // update the form display with the balance value
      bal.value = "€" + balance;
    } else if (balance < 0) {
      // remove the negative sign
      balance *= -1;
      // update the form display with the balance value
      bal.value = "Debit €" + balance;
    } else {
      // update the form display with the balance value
      bal.value = "Credit €" + balance;
    }
    // update the form display with the overdraft value
    odlimit.value = accounts[i][4];

    // checks that the balance isn't 0
    if (balance != 0) {
      // error the balance must be 0
      input.setCustomValidity("The account balance must be 0 before it can be closed. Please change to the Withdrawals screen to make it so.");
    }
  } else {
    // error the account doesnt belong to the inputted customer or it doesn't exist
    input.setCustomValidity("Account number " + input.value + " doesn't belong to this customer, or it doesn't exist.");

    // update the form displays with their values
    bal.value = "";
    odlimit.value = "";
  }
}

// function that updates the datalist with the accounts for the selected customer
function updateAccountOptions() {
  // get and store the form displays
  const cid = document.getElementById("cid");
  const datalist = document.getElementById("accounts");

  // string that will be used to store the account options
  let options = "";

  // loops through the accounts
  accounts.forEach(acc => {
    // stores the customerNo of the current account
    const customerNo = acc[0];

    // checks that the customer is the selected customer
    if (customerNo == cid.value) {
      // appends the account as an option
      options += "<option value='" + acc[2] + "' />";
    }
  });

  // updates the options in the form
  datalist.innerHTML = options;
}