<?php
// item_detail.php（脆弱サイト）

session_start();
echo $_SESSION["name"] . "さんがログイン中<br><br>";

echo "アイテムID:" . $_GET["id"];
echo "<br>のアイテムを購入しました";

?>
