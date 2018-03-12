<?php
	class MyClass {
		public static $bar = "bat";
		public static function baz() {
			echo "Hello<br>";
		}
	}
	
	$obj = new MyClass;
	$obj->baz();
	echo $obj->bar . "<br>";
	echo MyClass::$bar . "<br>";
?>