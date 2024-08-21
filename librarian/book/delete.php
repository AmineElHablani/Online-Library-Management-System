<?php
session_start();

include "../../include/functions.php";

$id = $_GET["id"];
$name = $_GET["name"];
$type = "delete";
$librarianID = $_SESSION['idLibrarian'];
$date=date("y-m-d");


$conn = connect();
$requestBooks = "DELETE FROM books WHERE ISBN = '$id'";
$requestBM="INSERT INTO bookmanagement(librarianID,bookID,dateM,TypeManagement) VALUES('$librarianID','$id','$date','$type')";


$resultBooks = $conn->query($requestBooks);
$resultBM = $conn->query($requestBM);

if($resultBooks && $resultBM){
    header("location:listBooks.php?name=".$name."&delete=done");
}

?>