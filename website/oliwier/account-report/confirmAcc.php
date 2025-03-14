<?php
session_start();

$_SESSION['customerID']=$_POST['custID'];
$_SESSION['address']=$_POST['address'];
$_SESSION['dob']=$_POST['dob'];
$_SESSION['phone']=$_POST['phone'];

echo $_SESSION['customerID'];
header("Location: index.php");

?>