<?php

include "../include/functions.php";

if(isset($_POST["search"])){
    $booksTitle = $_POST["search"];
}

//if($_SERVER['HTTP_REFERER'] == "http://localhost/bibliotheque/index.php"){
//}
if(strpos($_SERVER['HTTP_REFERER'], "bookTitle") !== false){
    $_SERVER['HTTP_REFERER'] = preg_replace('/\b&bookTitle.*$/i', '', $_SERVER['HTTP_REFERER']);
}else{
    $_SERVER['HTTP_REFERER'] = "http://localhost/bibliotheque/books.php?p=1&selection=latestRelease";
}

header("Location: {$_SERVER['HTTP_REFERER']}&bookTitle=".$booksTitle."");



?>