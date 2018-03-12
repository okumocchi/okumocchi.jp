<?php
  require_once('/home/sites/lolipop.jp/users/lolipop.jp-dp45103889/web/libs/Smarty.class.php');
  
  $tpl = new Smarty;
  
  $var_name = "ŽR“c ‘¾˜Y";
  $var_email = "yamada@example.net";

  $tpl->assign("name", $var_name);
  $tpl->assign("email", $var_email);
  
  $tpl->display("smarty1.tpl");
?>
