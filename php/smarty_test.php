<?php
  require_once('/home/sites/lolipop.jp/users/lolipop.jp-dp45103889/web/libs/Smarty.class.php');
  
  $tpl = new Smarty;

  // 1���A�T�C��
  $name = "Taro";
  $gender = 1;
  $tpl->assign("name", $name);
  $tpl->assign("gender", $gender);

  // �܂Ƃ߂ăA�T�C��
  $vals = array("name2"=>"Hanako", "gender2"=>2);
  $tpl->assign($vals);
  
  // �z����A�T�C��
  $arr = array("Hiroshi", 1);
  $tpl->assign("data", $arr);

  // �A�z�z����A�T�C��
  $arr2 = array("name"=>"Kenta", "gender"=>1);
  $tpl->assign("data2", $arr2);
  
  // �񎟌��z����A�T�C��
  // �c�a�̃e�[�u������l�𒊏o���Ă����ꍇ�͂��̃P�[�X������ 
  $arr3 = array(
    array("name"=>"Kyoko", "gender"=>2),
    array("name"=>"Hiromi", "gender"=>3),
    array("name"=>"Mei", "gender"=>2),
    array("name"=>"Takashi", "gender"=>1)
  );
  $tpl->assign("data3", $arr3);
  
  
  $tpl->display("smarty_test.tpl");
?>
