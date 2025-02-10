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
    // updates the customer details in the form
    populate(select);
  } else {
    // no matching select option found
    input.value = "-1"
    // TODO unset customer details in the form
  }
}

// function that handles displaying the customer details in the form
function populate(select) {
  // stores the currently selected customer details
  const result = select.options[select.selectedIndex].value;
  // splits the customer details into an array
  const details = result.split(",");
  // takes the customer details out of the array
  const id = details[0];
  const addr = details[3];
  const eircode = details[4];
  const dob = details[5];

  // updates the customer details in the form
  document.getElementById("cid").value = id
  document.getElementById("address").value = addr
  document.getElementById("eircode").value = eircode
  document.getElementById("dob").value = dob
}