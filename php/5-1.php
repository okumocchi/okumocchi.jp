<?php
	$i = 10;
	echo $i . "(" . decbin($i) . ")<br>";
	
	$j = $i << 2;
	echo $j . "(" . decbin($j) . ")<br>";
	
	$i = 100;
	echo $i . "(" . decbin($i) . ")<br>";
	
	$j = $i >> 2;
	echo $j . "(" . decbin($j) . ")<br>";
?>