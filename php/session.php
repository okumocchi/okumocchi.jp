<?php
session_id($_GET["PHPSESSID"]);
session_start();
//session_regenerate_id();
echo session_name() . "<br>";
echo session_id() . "<br>";
var_dump($_COOKIE);

$_SESSION["user_id"] = "hoge";
?>
