<?php
 class Lot {
	
	function draw() {
 		$luck = array("��g", "�g", "���g", "���g", "��");
		$r = array_rand($luck);
		return $luck[$r];
	}
 }
?> 