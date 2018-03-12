<?php
	$a = array(1, 2, 3);
	$b = array(4, 5, 6);;
	$c = 1;
	
	$a[$c++] = $b[$c++];
	var_dump($a);
	
?>