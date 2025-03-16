<!--
Student Name 	: Darian Byrne
Student Id Number: C00296036
Date 			: 15/03/2025
Customer Details -->

<!-- a div which groups the input box and it's label -->
<div class="inputbox">
    <label for="cid">Customer number:</label>
    <!-- the cid input box -->
    <input type="number" name="cid" id="cid" placeholder="Customer number" onchange="inputCustomer(this)"
           value="<?php if (isset($_POST["cid"])) echo $_POST["cid"]; ?>" min="0" step="1" required>
</div>

<!-- a div which groups the input box and it's label -->
<div class="inputbox">
    <label for="name">Customer Name:</label>
    <!-- the name select box -->
    <select id="name" onchange="inputCustomer(this)" required>
        <option></option>
        <?php require($_SERVER["DOCUMENT_ROOT"] . '/darian/customerListbox.php'); ?>
    </select>
</div>

<!-- a div which groups the input box and it's label -->
<div class="inputbox">
    <label for="address">Address:</label>
    <!-- the address input box -->
    <input type="text" name="address" id="address"
           value="<?php if (isset($_SESSION["address"])) echo $_SESSION["address"] ?>" placeholder="Address" disabled>
</div>

<!-- a div which groups the input box and it's label -->
<div class="inputbox">
    <label for="eircode">Eircode:</label>
    <!-- the eircode input box -->
    <input type="text" name="eircode" id="eircode"
           value="<?php if (isset($_SESSION["eircode"])) echo $_SESSION["eircode"] ?>" placeholder="Eircode" disabled>
</div>

<!-- a div which groups the calendar and it's label -->
<div class="inputbox">
    <label for="dob">Date of Birth:</label>
    <!-- the dob calendar -->
    <input type="date" name="dob" id="dob"
           value="<?php if (isset($_SESSION["dob"])) echo $_SESSION["dob"] ?>" placeholder="Date of Birth" disabled>
</div>