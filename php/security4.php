<html>
<body>
<form action="security4.php" method="get">
任意の値<input type="text" name="comment">
<input type="submit" value="送信">
</form>
<?php echo $_GET["comment"]; ?>
</body>
</html>
