<?php
$wdays = array("��","��","��","��","��","��","�y");
$today = date("w");
echo "������{$wdays[$today]}�j���ł��B";

$te = array("�O�[","�`���L","�p�[");
$r = array_rand($te);
echo $te[$r];
echo $r;

echo $te[mt_rand(0,2)];
?>
