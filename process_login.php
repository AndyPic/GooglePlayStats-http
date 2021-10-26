<?php

session_start();

include("../apickard01_connect.php");

$sentemail = $_POST['authoremail'];

$signin = "SELECT * FROM news11_creators WHERE email_address='$sentemail'";

$result = $conn->query($signin);

if (!$result) {
    echo $conn->error;
}


$numberofrows = $result->num_rows;

if ($numberofrows > 0) {

    // row of data to assoc array
    $singlerow = $result->fetch_assoc();
    // store id in var
    $id = $singlerow['id'];
    // set session
    $_SESSION['news11_creator'] = $id;


} else {
    echo "incorrect user";
}