<?php

use LDAP\Result;

include "../../include/functions.php";
$conn = connect();

$name=$_GET['name'];
$Email=$_GET['Email'];
$id=$_GET['id'];
$action=$_GET['action'];

if($action == 'suspend'){
    $request = "UPDATE users SET Statut = 'suspended' where Id=$id";
}else{
    $request = "UPDATE users SET Statut = 'active' where Id=$id";
}

$result = $conn->query($request);

if($result){
    header("location:listCustomers.php?name=".$name."&action=".$action."&id=".$id);
}


?>