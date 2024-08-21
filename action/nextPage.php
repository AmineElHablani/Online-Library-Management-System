<?php

include "../include/functions.php";

if(isset($_POST["search"])){
    $booksTitle = $_POST["search"];
}


//var_dump($_SERVER['HTTP_REFERER']);
//echo "<br>";

//$previeousPage = $_GET["next2"] - 2;
//$nextPage = $_GET["next2"];

//$modifiedReferrer = str_replace("p=".$previeousPage, "p=".$nextPage, $_SERVER['HTTP_REFERER']);
//var_dump($modifiedReferrer);

// if next 

if(isset($_GET["next1"])){
    $previeousPage = $_GET["next1"] - 1;
    $nextPage = $_GET["next1"];

}else if(isset($_GET["next2"])){
    $previeousPage = $_GET["next2"] - 2;
    $nextPage = $_GET["next2"];

}else if(isset($_GET["prev1"])){
    $previeousPage = $_GET["prev1"] + 1;
    $nextPage = $_GET["prev1"];

}else if(isset($_GET["prev2"])){
    $previeousPage = $_GET["prev2"] + 2;
    $nextPage = $_GET["prev2"];
}

$modifiedReferrer = str_replace("p=".$previeousPage, "p=".$nextPage, $_SERVER['HTTP_REFERER']);



header("Location: {$modifiedReferrer}");





?>