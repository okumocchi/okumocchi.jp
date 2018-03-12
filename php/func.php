<?php
require("lib.php");

okumoto("red", 20);
okumoto("blue",50);

for($i=1; $i < 30; $i++) {
  okumoto("green", $i);
}


$email = "okumocchi@i.softbank.jp";

echo getCarrier($email);

?>
