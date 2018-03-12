<?php
	$arr = array('z', 9, 5, 7, 1, 'a', '2');
	
	sort($arr, SORT_STRING);
	
	$keys = array_rand($arr, 3);
	
	var_dump($keys);


?>
