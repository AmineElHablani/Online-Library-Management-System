<?php
//start session
session_start();

//clear data from session
session_unset();

//delete session
session_destroy();



//redirection
header("location:index.php");

?>