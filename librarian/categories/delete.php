<?php
session_start();

include "../../include/functions.php";

$id = $_GET["id"];
$name = $_GET["name"];
$type = "delete";
$librarianID = $_SESSION['idLibrarian'];
$date=date("y-m-d");


$conn = connect();
$requestCategories = "DELETE FROM categories WHERE NUMC = '$id'";
$requestCM="INSERT INTO categoriesmanagement(librarianID,category,dateM,TypeManagement) VALUES('$librarianID','$name','$date','$type')";


$resultCategories = $conn->query($requestCategories);
$resultCM = $conn->query($requestCM);

if($resultCategories && $resultCM){
    header("location:listCategories.php?name=".$name."&delete=done");
}

?>