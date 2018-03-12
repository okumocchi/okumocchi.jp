<?php
$filename = $_GET["file"];
$fc = file_get_contents($filename);
echo $fc;
?>
