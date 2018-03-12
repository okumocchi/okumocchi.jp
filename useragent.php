<?php
	$agent = $_SERVER['HTTP_USER_AGENT']; 
	if (ereg("^DoCoMo", $agent)){
		$agent = $_SERVER{'HTTP_USER_AGENT'};
		if (strpos($agent, "DoCoMo/1.0") >= 0 && strpos($agent, "/", 11) >= 0) {
			$device = substr($agent, 11, (strpos($agent, "/", 11) - 11));
		} else if(strpos($agent, "DoCoMo/2.0") >= 0 && strpos($agent, "(", 11) >= 0) {
			$device = substr($agent, 11, (strpos($agent, "(", 11) - 11));
		} else {
			$device = substr($agent, 11);
		}
		$carrier = "docomo";
	} else if (ereg("^J-PHONE|^Vodafone|^SoftBank", $agent)){
		$device = $_SERVER{'HTTP_X_JPHONE_MSNAME'};
		$carrier = "softbank";
	} else if (ereg("^UP.Browser|^KDDI", $agent)){
		$device = substr($agent, (strpos($agent, "-") + 1), (strpos($agent, " ") - strpos($agent, "-") - 1));
		$carrier = "au";
	} else {
		errorMessage("�g�ђ[������A�N�Z�X���Ă��������B");
		exit();
	}
	
	//
	// �L�����A���Ƃ̋@����t�@�C����ǂݍ���
	//
	$models_info_file = "models_{$carrier}.php";
	require_once($models_info_file);
	$height = $models[$device]["height"];
	if (!$height) {
		errorMessage("��Ή��@��ł��B");
		exit();
	} 
	
	$swf_url = "http://sync.jp/test/Luc_{$height}.swf";
	header("HTTP/1.1 301 Moved Permanently");
	header("Location: {$swf_url}");
	
	function errorMessage($msg) {
?>
	<html>
	<body>
	<?php echo $msg ?><br>
	</body>
	</html>

<?php

	}
?>
