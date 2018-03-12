<?php
 class Lot {
	
	function draw() {
 		$luck = array("‘å‹g", "‹g", "’†‹g", "¬‹g", "‹¥");
		$r = array_rand($luck);
		return $luck[$r];
	}
 }
?> 