<?php
session_start();
include "../../include/functions.php";

$name = $_POST["categoryNAME"];
$librarianID=$_SESSION['idLibrarian'];
$date =date('Y-m-d');
$type="add";

$conn=connect();

try{
    $requestCategories = "INSERT INTO categories (categoryNAME) VALUES('$name')";
    $requestCM="INSERT INTO categoriesmanagement(librarianID,category,dateM,TypeManagement) VALUES('$librarianID','$name','$date','$type')";

    
    $resultCategories = $conn->query($requestCategories);
    $resultCM = $conn->query($requestCM);
    
    if($resultCategories && $resultCM){
        header("location:listCategories.php?name=".$name."&add=done");
    }

}catch(PDOException $e){
    echo " errror ";
    if($e->getCode() == 23000){
        header("location:listCategories.php?name=".$name."&error=duplicated");
    }
}


?>