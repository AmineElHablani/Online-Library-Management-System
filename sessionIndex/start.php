<?php

session_start();

if(isset($_GET['name'])){
    $_SESSION["category"]=$_GET['name'];
}

header("location:../index.php?category=".$_GET['name'].".php");


?>