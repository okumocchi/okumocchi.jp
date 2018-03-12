<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>自分史チェッカー</title>
</head>
<body>
<?php

try {
  $pdo = new PDO('mysql:dbname=LA10284881-app;host=mysql553.phy.lolipop.jp', 'LA10284881', 'digicell');
} catch (PDOException $e) {
  exit('データベースに接続できませんでした。' . $e->getMessage());
}

$stmt = $pdo->query('SET NAMES utf8');
if (!$stmt) {
  $info = $pdo->errorInfo();

  exit($info[2]);
}

$stmt = $pdo->query('select * from events order by start_date');
if (!$stmt) {
  $info = $pdo->errorInfo();

  exit($info[2]);
}

while ($data = $stmt->fetch(PDO::FETCH_ASSOC)) {
  echo '<p>' . $data['start_date'] . ':' . $data['event'] . "</p>\n";
}

$pdo = null;

?>
</body>
</html>