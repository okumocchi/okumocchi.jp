<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理ツール - BIOGRAM</title>
</head>
<body>
<?php
require_once "../libdb.php";
require_once "../libutil.php";
$id				= isset($_POST["id"]) ? $_POST["id"] : 0;
$categoryName 	= isset($_POST["name"]) ? $_POST["name"] : "";
$groupNo		= isset($_POST["groupno"]) ? $_POST["groupno"] : 0;
$level			= isset($_POST["level"]) ? $_POST["level"] : 3;
$orderNo		= isset($_POST["orderno"]) ? $_POST["orderno"] : 0;


// 登録/更新
if (isset($_POST['add']) || isset($_POST['upd'])) {
	if (!$categoryName) {
		message("カテゴリーを入力してください");
	}
	
	if (isset($_POST['add'])) {
		$sql = 'insert into categories(name, group_no, level, order_no) values(?, ?, ?, ?)';
		$sth = $db->prepare($sql);
		$sth->execute(array($categoryName, $groupNo, $level, $orderNo));
	} else {
		$sql = "update categories set name=?, group_no=?, level=?, order_no=? where id=?";
		$sth = $db->prepare($sql);
		$sth->execute(array($categoryName, $groupNo, $level, $orderNo, $id));
	}
	
	$categoryName = "";
	$groupNo = 0;
	$level = 3;
	$orderNo = 0;
}

// 全レコードの読み込み

$stmt = $db->query('select * from categories order by group_no, order_no');
if (!$stmt) {
  $info = $db->errorInfo();
  exit($info[2]);
}

// レコードをidをキーとした配列に変換
$data = array();
while ($row = $stmt->fetch()) {
  $data[$row["id"]]  = $row;
}


$selectedId = isset($_GET["id"]) ? $_GET["id"] : null;
$id = null;
$name = "";
$groupNo = 0;
$level = 3;
if ($selectedId) {
	$id = $selectedId;
	$name = $data[$id]["name"];
	$groupNo = $data[$id]["group_no"];
	$level = $data[$id]["level"];
	$orderNo = $data[$id]["order_no"];
}

?>
<a href="../">サービストップ</a>
<h2>カテゴリー登録</h2>
<form action="./edit_categories.php" method="post">
<table>
<tr><th>カテゴリー</th><td><input type="text" size="15" name="name" value="<?php echo $name?>"></td></tr>
<tr><th>グループNO</th><td><input type="text" size="3" name="groupno" value="<?php echo $groupNo?>"></td></tr>
<tr><th>重要度</th><td>
<?php 
	for ($lv = 1; $lv <= 5; $lv++) {
		$checked = $lv == $level ? "checked" : "";
		echo "<input type=\"radio\" name=\"level\" value=\"{$lv}\" {$checked}>{$lv}&nbsp\n";
	}
?>
<tr><th>表示順</th><td><input type="text" size="3" name="orderno" value="<?php echo $orderNo?>"></td></tr>
</table>

<?php
if (!$selectedId) {
	echo '<input type="submit" value="登録" name="add">';
} else {
	echo "<input type=\"hidden\" name=\"id\" value=\"{$selectedId}\">";
	echo '<input type="submit" value="更新" name="upd">';
	echo '<input type="submit" value="別レコードとして登録" name="add">';
	echo '<a href="./edit_categories.php">クリア</a>';
}
?>
</form>

<table border="1">
  <tr><th>カテゴリー名</th><th>グループNO</th><th>重要度（1-5)</th><th>表示順</th></tr>
<?php
foreach ($data as $row) {
  echo "<tr><td><a href=\"./edit_categories.php?id={$row["id"]}\">{$row['name']}</a></td><td>{$row['group_no']}</td><td>{$row['level']}</td><td>{$row['order_no']}</td></tr>\n";
}
?>
</table>

<?php
$pdo = null;

?>
</body>
</html>