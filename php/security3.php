<html>
<body>
<form action="security3.php" method="post">
���j���[���獀�ڂ�I��<br>
<select name="menu">
<option value="melon">������</option>
<option value="lemon">������</option>
<option value="apple">�����S</option>
</select>
<input type="submit" value="���M">
</form>
<hr>
<?php
switch($_POST["menu"]) {
  case "melon":
  $msg = "������";
  break;
  case "lemon":
  $msg = "������";
  break;
  case "apple":
  $msg = "�����S";
  break;
  default:  
  exit();
}
?>
�I�����ꂽ���ڂ�<?php echo $msg; ?>�ł��B
</body>
</html>

