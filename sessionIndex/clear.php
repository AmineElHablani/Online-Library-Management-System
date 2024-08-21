<?php

session_start();

if(isset($_SESSION["category"])){
    unset($_SESSION["category"]);
}
header("location:../index.php");

?>