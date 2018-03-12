<?php
try {
  $db = new PDO('mysql:dbname=LA10284881-app;host=mysql553.phy.lolipop.jp', 'LA10284881', 'digicell');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。' . $e->getMessage());
}

$stmt = $db->query('SET NAMES utf8');
if (!$stmt) {
  $info = $db->errorInfo();

  exit($info[2]);
}
?>