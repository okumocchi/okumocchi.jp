<?php

// Smartyƒ‰ƒCƒuƒ‰ƒŠ‚ð“Ç‚Ýž‚Þ
require('Smarty.class.php');

$smarty = new Smarty;

$smarty->template_dir = './templates/';
$smarty->compile_dir = './templates_c/';
$smarty->config_dir = './configs/';
$smarty->cache_dir = './cache/';

$smarty->assign('name','Ned');

$smarty->display('index.tpl');
?> 