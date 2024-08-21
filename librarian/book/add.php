<?php
session_start();

$BookTitle = $_POST["BookTitle"];
$BookAuthor = $_POST["BookAuthor"];
$PublishYear = $_POST["PublishYear"];
$Publisher = $_POST["Publisher"];
$ImageURL = $_POST["Image-URL-L"];
$PublishMonth = $_POST["PublishMonth"];
$PublishDay = $_POST["PublishDay"];
$Language = $_POST["Language"];
$Description = $_POST["Description"];
$previewLink = $_POST["previewLink"];
$infoLink = $_POST["infoLink"];
$categories = $_POST["categories"];
$Price = $_POST["Price"];
$librarianID = $_POST["librarianID"];
$date = date("y-m-d");
$type="add";
$stock = $_POST["stock"];



//add product 

include "../../include/functions.php";

$conn = connect();


//test UNIQ id (make sure that id do not exist)
do {
    // uniq id for ISBN
    $rnd_id = uniqid();
    //id : ISBN
    $id = substr($rnd_id,3);
    $reqTEST ="SELECT * FROM books where ISBN='$id'";
    $resTEST = $conn->query($reqTEST);
    $bookTEST = $resTEST->fetchALL();


} while (count($bookTEST)!=0);


//add book 

$requestBOOK = "INSERT INTO books(ISBN, BookTitle, BookAuthor, PublishYear, Publisher, `Image-URL-L`, PublishMonth, PublishDay, `Language`, `Description`, previewLink, infoLink, categories, Price,stock) VALUES ('$id', '$BookTitle', '$BookAuthor', '$PublishYear', '$Publisher', '$ImageURL', '$PublishMonth', '$PublishDay', '$Language', '$Description', '$previewLink', '$infoLink', '$categories', '$Price','$stock')";
$requestBM="INSERT INTO bookmanagement(librarianID,bookID,dateM,TypeManagement) VALUES('$librarianID','$id','$date','$type')";
$resultBOOK = $conn->query($requestBOOK);
$resultBM = $conn->query($requestBM);

if($resultBOOK &&  $resultBM){
    header("location:listBooks.php?name=".$BookTitle."&add=done");
}else{
    header("location:listBooks.php?name=".$BookTitle."&add=error");
}





?>