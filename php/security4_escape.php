<html>
<body>
<form action="security4_escape.php" method="post">
任意の値<input type="text" name="comment">
<input type="submit" value="送信">
</form>
<?php 
$e_comment = htmlspecialchars($_POST["comment"], ENT_QUOTES);
echo $e_comment;
 ?>
</body>
</html>
