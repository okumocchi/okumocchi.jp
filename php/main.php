<?php
	require('Smarty.class.php');
	$smarty = new Smarty;


	require_once('lot.php');
	$lot = new Lot;
	$result = $lot->draw();
	
	$smarty->assign('result', $result);
	$smarty->display('lot.tpl');
 	
 //	function initSmarty() {
//		$this->smarty->template_dir = './templates/';
//		$this->smarty->compile_dir = './templates_c/';
 //	}
 ?> 