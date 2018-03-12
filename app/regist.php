<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ユーザ登録 - 自分史チェッカー</title>
</head>
<body>
<h2>ユーザ登録</h2>
<form action="regist_complete.php" method="post">
<table border="1">
<tr><th>ログインネーム</th><td><input type="text" name="loginname"></td></tr>
<tr><th>パスワード</th><td><input type="password" name="password"></td></tr>
<tr><th>ハンドルネーム（表示名）</th><td><input type="text" name="handlename"></td></tr>
<tr><th>性別</th><td><input type="radio" name="gender" value="m">男<input type="radio" name="gender" value="f">女</td></tr>
<tr><th>生年月日</th><td>
<select name="birthday_y">
<?php 
$y = date("Y");
$_y = $y - 100;
while($y > $_y) {
	echo "<option value=\"{$y}\">{$y}</option>\n";
	$y--;
}
?>
</select>年

<select name="birthday_m">
<?php
for ($i = 1; $i <= 12; $i++) {
	echo "<option value=\"{$i}\">{$i}</option>\n";
}
?>
</select>月

<select name="birthday_d">
<?php
for ($i = 1; $i <= 31; $i++) {
	echo "<option value=\"{$i}\">{$i}</option>\n";
}
?>
</select>日


</td></tr>


<tr><td colspan="2"><input type="submit" value="登録"></td></tr>
</table>

</form>

</body>
</html>