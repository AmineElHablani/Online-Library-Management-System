<?php

include "../include/functions.php";

$conn = connect();
$request = "SELECT * FROM messages";
$result = $conn->query($request);
$messages = $result->fetchAll();


?>