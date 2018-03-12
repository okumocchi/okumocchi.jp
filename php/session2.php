<?php
session_id($_GET["PHPSESSID"]);
session_start();
$user_id = $_SESSION["user_id"];
echo $user_id;
?>
