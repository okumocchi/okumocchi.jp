<?php
	if (!$_GET['text']) {
		echo "�Í�������e�L�X�g���A�utext�v�p�����[�^�œn���Ă�������<br>";
		exit;
	}
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $key = "purifla_mcrypt_key";
    $text = $_GET['text'];
    echo strlen($text) . "<br>";

    $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, $text, MCRYPT_MODE_ECB, $iv);
    echo strlen($crypttext) . "<br>";
?> 
