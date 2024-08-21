<?php
session_start();

include "../../include/functions.php";

$librarianID = $_GET["id"];
$name = $_GET["name"];
$LibrarianEmail = $_GET["Email"];
$type = "delete";
$adminID = $_SESSION['idAdmin'];
$date=date("y-m-d");



$conn = connect();
$requestLibrarians = "DELETE FROM librarian WHERE Id = '$librarianID'";

$requestLM="INSERT INTO librarianmanagement(adminID,librarianID,dateM,TypeManagement,LibrarianEmail) VALUES('$adminID','$librarianID','$date','$type','$LibrarianEmail')";


$resultLibrarians = $conn->query($requestLibrarians);
$resultLM = $conn->query($requestLM);

if($resultLibrarians && $resultLM){
    echo $LibrarianEmail;
    header("location:listLibrarians.php?name=".$name."&delete=done");
}

?>