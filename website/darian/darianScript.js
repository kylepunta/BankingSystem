/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 17/03/2025
Scripts */

// function that handles the account number from the inputbox
function inputAccount(input) {
    // gets the form display for the account number from the form
    const cid = document.getElementById("cid");
    // const accountno = document.getElementById("accountno");

    // gets the form on the page
    const form = document.querySelector("form");

    // updates the account number on the form
    if (input.value) cid.value = "";
    // submits the form so that the accounts details can be queried
    form.submit();
}

// function that handles the cancel
function cancel() {
    // gets the form inputs
    const cid = document.getElementById("cid");
    const accountno = document.getElementById("accountno");
    // gets the form on the page
    const form = document.querySelector("form");

    // clears the values on the form
    cid.value = "";
    accountno.value = "";
    // submits the form so that the screen is fresh
    form.submit();
}

// function that handles hiding the display message on the form
function hide(span) {
    // gets the paragraph surrounding the button
    const parent = span.parentElement;
    // removes the paragraph
    parent.remove();
}