<html>
<body>
<form action="security4_escape.php" method="post">
�C�ӂ̒l<input type="text" name="comment">
<input type="submit" value="���M">
</form>
<?php 
$e_comment = htmlspecialchars($_POST["comment"], ENT_QUOTES);
echo $e_comment;
 ?>
</body>
</html>
