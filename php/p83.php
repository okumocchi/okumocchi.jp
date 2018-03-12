<?php
$fn = $_GET["user_name"];
include "/var/user/" . $fn ;

$fc = file_get_contents($fn);
echo $fc;
?>
