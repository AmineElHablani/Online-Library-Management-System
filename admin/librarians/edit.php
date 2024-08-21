<?php
session_start();

include "../../include/functions.php";

$conn = connect();

$old = $_POST["old"];
$librarianID = $_POST['id'];
$name = $_POST["Name"];
$date = date("y-m-d");
$adminID = $_SESSION["idAdmin"];
$type="edit";

//data
$Email = $_POST['Email'];
$Name = $_POST['Name'];
$hashPWD = md5($_POST["PWD"]);



try{
    $requestLibrarian = "UPDATE librarian SET `Name` = '$name', Email = '$Email', PWD = '$hashPWD' where Id = '$librarianID' ";
    $requestLM="INSERT INTO librarianmanagement(adminID,librarianID,dateM,TypeManagement,LibrarianEmail) VALUES('$adminID','$librarianID','$date','$type','$Email')";




    $resultLibrarian = $conn->query($requestLibrarian);
    $resultLM = $conn->query($requestLM);
    
    if($resultLibrarian && $resultLM){
        header("location:listLibrarians.php?old=".$old."&new=".$name."&edit=done");
    }
}catch(PDOException $e){
    if($e->getCode() == 23000){
        header("location:listLibrarians.php?name=".$name."&error=duplicated");
    }
}

?>