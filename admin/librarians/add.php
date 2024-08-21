<?php
session_start();
include "../../include/functions.php";

//$librarianID = $_POST["Id"];
$adminID=$_SESSION['idAdmin'];
$date =date('Y-m-d');
$type="add";

//data
$Email = $_POST['Email'];
$Name = $_POST['Name'];
$hashPWD = md5($_POST["PWD"]);

$conn=connect();

try{
    $requestLibrarian = "INSERT INTO librarian (Email,`Name`,PWD) VALUES('$Email','$Name','$hashPWD')";
    
    
    $resultLibrarian = $conn->query($requestLibrarian);
    
    if($resultLibrarian){
        $librarianID = $conn->lastInsertId();

        $requestLM="INSERT INTO librarianmanagement(adminID,librarianID,dateM,TypeManagement,LibrarianEmail) VALUES('$adminID','$librarianID','$date','$type','$Email')";
        $resultLM = $conn->query($requestLM);

        if($resultLM){
            header("location:listLibrarians.php?name=".$Name."&add=done");
        }

    }

}catch(PDOException $e){
    echo $e;
    if($e->getCode() == 23000){
        header("location:listLibrarians.php?name=".$Name."&error=duplicated");
    }
}


?>