<?php 
session_start();
unset($_SESSION['userid']);
unset($_SESSION['loginname']);
unset($_SESSION['handlename']);
header("location: index.php");
?>
