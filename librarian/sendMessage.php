<?php
//
include "../include/functions.php";
session_start();
$conn = connect();


$senderID = $_POST['senderID'];
$receiverID = $_POST["receiverID"];
$content = $_POST["message"];
$dateM = date('Y-m-d H:i:s');

$request = "INSERT INTO messages(senderID,receiverID,content,dateM) VALUES ('$senderID','$receiverID','$content','$dateM')";
echo $request;

$result = $conn->query($request);
if($result){
    header("Location: {$_SERVER['HTTP_REFERER']}");
}

?>