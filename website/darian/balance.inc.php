<?php
/*
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 17/03/2025
Balance */

// function that accepts a balance value and returns it with a prefix
function displayBalance($bal)
{
    // converts the balance to a float if it's not already
    if (is_string($bal)) {
        $bal = floatval($bal);
    }

    // checks the value of the balance and returns the proper prefix
    if ($bal == 0) {
        return "€" . $bal;
    } else if ($bal < 0) {
        return "Debit €" . (0 - $bal);
    } else {
        return "Credit €" . $bal;
    }
}