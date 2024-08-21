<?php


setcookie("cookieName", "", time() - 3600, "/");
header("location:listCustomers.php");

?>