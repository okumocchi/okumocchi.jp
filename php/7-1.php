<?php
	$arr1 = array(1, 2, 3);
	$arr2 = $arr1;
	$arr1[0] = 10;
	echo $arr1[0] . "<br>";
	echo $arr2[0] . "<br>";
	
	class MyClass {
		var $num = 10;
	}
	
	$obj1 = new MyClass;
	$obj2 = $obj1;
	$obj1->num = 100;
	echo $obj1->num . "<br>";
	echo $obj2->num . "<br>";
?>