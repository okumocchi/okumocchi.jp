<?php
$wdays = array("日","月","火","水","木","金","土");
$today = date("w");
echo "今日は{$wdays[$today]}曜日です。";

$te = array("グー","チョキ","パー");
$r = array_rand($te);
echo $te[$r];
echo $r;

echo $te[mt_rand(0,2)];
?>
