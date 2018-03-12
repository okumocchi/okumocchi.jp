<html>
<body>
<form action="security2.php" method="post">
メニューから項目を選択<br>
<select name="menu">
<option value="melon">メロン</option>
<option value="lemon">レモン</option>
<option value="apple">リンゴ</option>
</select>
<input type="submit" value="送信">
</form>
<hr>
選択された項目は<?php echo $_POST["menu"];?>です。
</body>
</html>
?>
