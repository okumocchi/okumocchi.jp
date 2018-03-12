<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>自分史チェッカー</title>
</head>
<body>
<?php
$start_date = trim($_POST['start_date']);
$event = trim($_POST['event']);
require_once "libdb.php";


// 日付と内容が送信されている場合は登録
if ($start_date && $event) {
	$sql = 'insert into events(start_date, event) values(?, ?)';
	$stmt = $db->prepare($sql);
	$stmt->execute(array($start_date, $event));
	
	$start_date="";
	$event="";
}

// 全レコードの読み込み

$stmt = $db->query('select * from events order by start_date');
if (!$stmt) {
  $info = $db->errorInfo();
  exit($info[2]);
}
?>
<h2>出来事登録</h2>
<form action="regist.php" method="post">
発生日：<input type="text" size="15" name="start_date" value="<?php echo $start_date?>"><br>
内　容：<textarea cols="30" rows="3" name="event"><?php echo $event ?></textarea><br>
<input type="submit" value="登録">

</form>

<hr>

<table border="1">
  <tr><th>発生日</th><th>内容</th></tr>
<?php
while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
  echo '<tr><td>' . $data['start_date'] . '</td><td>' . $data['event'] . "</td></tr>\n";
}
?>
</table>

<?php
$pdo = null;

?>
</body>
</html>