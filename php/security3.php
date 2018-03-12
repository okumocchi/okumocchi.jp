<html>
<body>
<form action="security3.php" method="post">
メニューから項目を選択<br>
<select name="menu">
<option value="melon">メロン</option>
<option value="lemon">レモン</option>
<option value="apple">リンゴ</option>
</select>
<input type="submit" value="送信">
</form>
<hr>
<?php
switch($_POST["menu"]) {
  case "melon":
  $msg = "メロン";
  break;
  case "lemon":
  $msg = "レモン";
  break;
  case "apple":
  $msg = "リンゴ";
  break;
  default:  
  exit();
}
?>
選択された項目は<?php echo $msg; ?>です。
</body>
</html>

