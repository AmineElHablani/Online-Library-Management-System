<?php
session_start();

include "../../include/functions.php";

$transactionId = $_GET["id"];
$customerID = $_GET['customerID'];
$name = $_GET["name"];
$ISBN = $_GET["ISBN"];
$type = "delete";
$adminID = $_SESSION['Id'];
$date=date("y-m-d");



$conn = connect();
$requestTrnasation = "UPDATE emprunt set returned = 'yes' WHERE Id = '$transactionId'";

$requestBOOKs = "UPDATE books set stock = stock + 1  WHERE ISBN = '$ISBN'";


$resultTransation = $conn->query($requestTrnasation);
$resultbooks = $conn->query($requestBOOKs);

if($resultbooks && $resultTransation){
    header("location:listOrders.php?name=".$name."&returned=done");
}

?>