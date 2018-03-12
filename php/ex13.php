<?php
	$arr = array("d"=>"lemon", "a"=>"orange", "b"=>"banana", "c"=>"apple");
	
	sort($arr);
	foreach($arr as $key=>$val) {
		print("$key=$val<br>");
	}
?>