<?php

session_start();

if(!isset($_SESSION["Connexion"])){
    header("location:../connection.php");
    exit();
}

//if connected 

$userID=$_SESSION["idUser"];
$bookID=$_POST["bookID"];
$dateE= date("Y-m-d");


include "../include/functions.php";

$conn = connect();

$requestBOOK = "UPDATE books SET stock = stock - 1 WHERE ISBN = '$bookID'";
$requestBorrow = "INSERT INTO emprunt(userID,bookID,DateE) VALUES('$userID','$bookID','$dateE')";

$resultBOOK = $conn->query($requestBOOK);
$resultBorrow = $conn->query($requestBorrow);

header("Location: {$_SERVER['HTTP_REFERER']}&borrow=done");
#header("Location: produit.php?isbn='.bookID.'&borrow=done");
exit;




?>