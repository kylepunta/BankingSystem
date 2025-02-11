// function that handles the customerNo from the inputbox
function inputCustomer(input) {
  // gets the customerNo from the input
  const id = input.value;
  // gets the select element
  const select = document.getElementById("name");
  let i = 0;
  // compares each select option to the given id
  while (i < select.options.length &&
    // compares the id in the select option to the given id
    select.options[i].value.split(",")[0] != id) {
    // no matching select option found, continue
    i++;
  }
  // checks if the correct select option was found
  if (i < select.options.length) {
    // updates the select
    select.selectedIndex = i;
  } else {
    // no matching select option found
    input.value = "";
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

  // checks that the default (none) customer is selected
  if (select.selectedIndex == 0) {
    // clears the customer details in the form
    cid.value = "";
    addr.value = "";
    eircode.value = "";
    dob.value = "";
    return;
  }

  // stores the currently selected customer details
  const result = select.options[select.selectedIndex].value;
  // splits the customer details into an array
  const details = result.split(",");
  // takes the customer details out of the array
  // updates the customer details in the form
  cid.value = details[0];
  addr.value = details[1];
  eircode.value = details[2];
  dob.value = details[3];
}

// function that checks the user wants to submit the form
function confirmSubmit() {
  // displays a confirmation box to the user, the form will be submitted if they press OK
  return confirm("Are you sure you want to open this current account?")
}
