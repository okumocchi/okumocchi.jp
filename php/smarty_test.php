<?php
  require_once('/home/sites/lolipop.jp/users/lolipop.jp-dp45103889/web/libs/Smarty.class.php');
  
  $tpl = new Smarty;

  // 1つずつアサイン
  $name = "Taro";
  $gender = 1;
  $tpl->assign("name", $name);
  $tpl->assign("gender", $gender);

  // まとめてアサイン
  $vals = array("name2"=>"Hanako", "gender2"=>2);
  $tpl->assign($vals);
  
  // 配列をアサイン
  $arr = array("Hiroshi", 1);
  $tpl->assign("data", $arr);

  // 連想配列をアサイン
  $arr2 = array("name"=>"Kenta", "gender"=>1);
  $tpl->assign("data2", $arr2);
  
  // 二次元配列をアサイン
  // ＤＢのテーブルから値を抽出してきた場合はこのケースが多い 
  $arr3 = array(
    array("name"=>"Kyoko", "gender"=>2),
    array("name"=>"Hiromi", "gender"=>3),
    array("name"=>"Mei", "gender"=>2),
    array("name"=>"Takashi", "gender"=>1)
  );
  $tpl->assign("data3", $arr3);
  
  
  $tpl->display("smarty_test.tpl");
?>
