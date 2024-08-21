<?php
session_start();

include "../../include/functions.php";

/*$conn = connect();

$old = $_POST["old"];
$numc = $_POST['id'];
$name = $_POST["categoryNAME"];
$date = date("y-m-d");
$librarianID = $_SESSION["Id"];
$type="edit";



try{
    $requestCategories = "UPDATE categories SET categoryNAME = '$name' where NUMC = '$numc' ";
    $requestCM="INSERT INTO categoriesmanagement(librarianID,category,dateM,TypeManagement) VALUES('$librarianID','$name','$date','$type')";




    $resultCategories = $conn->query($requestCategories);
    $resultCM = $conn->query($requestCM);
    
    if($resultCategories && $resultCM){
        header("location:listCategories.php?old=".$old."&new=".$name."&edit=done");
    }
}catch(PDOException $e){
    if($e->getCode() == 23000){
        header("location:listCategories.php?name=".$name."&error=duplicated");
    }
}*/
header("location:listCategories.php?result=notDevelopped");

?>