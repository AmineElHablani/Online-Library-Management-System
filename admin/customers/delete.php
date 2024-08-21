<?php
session_start();

include "../../include/functions.php";

$customerID = $_GET["id"];
$name = $_GET["name"];
$customerEmail = $_GET["Email"];
$type = "delete";
$adminID = $_SESSION['idAdmin'];
$date=date("y-m-d");



$conn = connect();
$requestCustomers = "DELETE FROM users WHERE Id = '$customerID'";

$requestCM="INSERT INTO customersmanagement(adminID,customerID,dateM,TypeManagement,customerEmail) VALUES('$adminID','$customerID','$date','$type','$customerEmail')";


$resultCustomers = $conn->query($requestCustomers);
$resultCM = $conn->query($requestCM);

if($resultCustomers && $resultCM){
    header("location:listCustomers.php?name=".$name."&delete=done");
}

?>