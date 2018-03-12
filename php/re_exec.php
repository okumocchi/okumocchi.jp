<?php
	$re = $_POST['re'];
	$str = $_POST['str'];
	
	$result = array();

	$ret = @preg_match($re, $str, $m);
	$result['ret'] = $ret;
	if ($ret) {
	    $result['matches'] = $m;
	}
	
	echo json_encode($result);
?>
