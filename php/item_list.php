<?php
// item_list.php（脆弱サイト）

session_start();
$_SESSION["name"] = "山田太郎";

echo '<a href="item_detail.php?id=1">あんぱん</a><br>';
echo '<a href="item_detail.php?id=2">メロンパン</a><br>';
echo '<a href="item_detail.php?id=3">クロワッサン</a><br>';
?>
