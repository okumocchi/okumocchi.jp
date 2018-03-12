<?php
 class Controller {
 	var $smarty;
 	
	function Controller() {	 	//コンストラクタ
		$this->initSmarty();
	}

 	function execute() {
 		require_once('lot.php');
 		$lot = new Lot;
 		$result = $lot->draw();
		$this->smarty->assign('result', $result);
		$this->showPage();
 	}
 	
 	function showPage() {
		$this->smarty->display('lot.tpl');
 	}
 	
 	function initSmarty() {
		require('Smarty.class.php');
		$this->smarty = new Smarty;
		$this->smarty->template_dir = './templates/';
		$this->smarty->compile_dir = './templates_c/';
 	}
 }
?> 