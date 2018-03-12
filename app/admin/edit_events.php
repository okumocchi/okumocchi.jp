<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>イベント編集 - BIOGRAM</title>
<script type="text/javascript">
function onChangeDate() {
	var idx = document.fm.datemon.selectedIndex;
	if(idx == 0) {
		document.fm.dateday.selectedIndex = 0;
	}
}
</script>

</head>
<body>
<?php
require_once "../libdb.php";
require_once "../libutil.php";
$id				= isset($_POST["id"]) ? $_POST["id"] : 0;
$dateYear	 	= isset($_POST["dateyear"]) ? $_POST["dateyear"] : "";
$dateMon	 	= isset($_POST["datemon"]) ? $_POST["datemon"] : "";
$dateDay		= isset($_POST["dateday"]) ? $_POST["dateday"] : "";
$title			= isset($_POST["title"]) ? $_POST["title"] : "";
$detail			= isset($_POST["detail"]) ? $_POST["detail"] : "";
$categoryId		= isset($_POST["categoryid"]) ? $_POST["categoryid"] : 999;
$level			= isset($_POST["level"]) ? $_POST["level"] : 3;
$region			= isset($_POST["region"]) ? $_POST["region"] : "";


// 登録/更新
if (isset($_POST['add']) || isset($_POST['upd'])) {
	$dateType = !$dateMon ? "y" : (!$dateDay ? "m" : "d");
	if (!$dateMon) $dateMon = 1;
	if (!$dateDay) $dateDay = 1;

	if (!checkdate($dateMon, $dateDay, $dateYear)) {
		message("存在しない日付です");
	}
	
	$eventDate = $dateYear . "-" . $dateMon . "-" . $dateDay;

	if (!$title) {
		message("タイトルを入力してください");
	}
	
	if (isset($_POST['add'])) {
		$sql = 'insert into events(event_date, date_type, title, detail, category_id, level, region) values(?, ?, ?, ?, ?, ?, ?)';
		$sth = $db->prepare($sql);
		$sth->execute(array($eventDate, $dateType, $title, $detail, $categoryId, $level, $region));
	} else {
		$sql = "update events set event_date=?, date_type=?, title=?, detail=?, category_id=?, level=?, region=? where id=?";
		$sth = $db->prepare($sql);
		$sth->execute(array($eventDate, $dateType, $title, $detail, $categoryId, $level, $region, $id));
	}
}

// 全レコードの読み込み

$stmt = $db->query('select * from events order by event_date, level desc');
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
$eventDate = time();
$dateType = "d";
$title = "";
$detail = "";
$categoryId = 999;
$level = 3;
$region = "";

if ($selectedId) {
	$id = $selectedId;
	$eventDate 	= strtotime($data[$id]["event_date"]);
	$dateType	= $data[$id]["date_type"];
	$title 		= $data[$id]["title"];
	$detail 	= $data[$id]["detail"];
	$categoryId = $data[$id]["category_id"];
	$level 		= $data[$id]["level"];
	$region 	= $data[$id]["region"];
}

$d = getdate($eventDate);
$year = $d["year"];
$mon = $d["mon"];
$day = $d["mday"];


// カテゴリリストを取得
$sql = "select * from event_categories order by order_no";
$sth = $db->prepare($sql);
$sth->execute();
$categories = $sth->fetchAll(PDO::FETCH_ASSOC);

?>
<a href="../">サービストップ</a>
<h2>イベント登録</h2>
<form name="fm" action="./edit_events.php" method="post">
<table>
<tr><th>発生日</th><td>
<select name="dateyear">
<?php
$thisYear = date("Y");
$y = 1900;
while($y <= $thisYear) {
	$selected = $y == $year ? "selected" : "";
	echo "<option value=\"{$y}\" $selected>{$y}</option>\n";
	$y++;
}
?>
</select>年

<select name="datemon" onchange="onChangeDate()">
<option value="0">指定しない</option>
<?php
for ($i = 1; $i <= 12; $i++) {
	$selected = $i == $mon ? "selected" : "";
	echo "<option value=\"{$i}\" $selected>{$i}</option>\n";
}
?>
</select>月

<select name="dateday"  onchange="onChangeDate()">
<option value="0">指定しない</option>
<?php
for ($i = 1; $i <= 31; $i++) {
	$selected = $i == $day ? "selected" : "";
	echo "<option value=\"{$i}\" $selected>{$i}</option>\n";
}
?>
</select>日



</td></tr>
<tr><th>見出し</th><td><input type="text" size="50" name="title" value="<?php echo $title?>"></td></tr>
<tr><th>詳細</th><td><textarea  name="detail" cols="50" rows="5"><?php echo $detail?></textarea></td></tr>
<tr><th>カテゴリ</th><td>
<select name="categoryid">
<?php
foreach ($categories as $category) {
	$selected = $category["id"] == $categoryId ? "selected" : "";
	echo "<option value=\"{$category["id"]}\" $selected>{$category["name"]}</option>\n";
}
?>
</select>
</td></tr>

<tr><th>重要度</th><td>
<?php 
	for ($lv = 1; $lv <= 5; $lv++) {
		$checked = $lv == $level ? "checked" : "";
		echo "<input type=\"radio\" name=\"level\" value=\"{$lv}\" {$checked}>{$lv}&nbsp\n";
	}
?>

</td></tr>
<tr><th>国・地域</th><td>
<select name="region">
<?php
$regions = array("g"=>"指定しない", "jp"=>"日本");
foreach ($regions as $regionKey => $regionVal)  {
	$selected = $regionKey == $region ? "selected" : "";
	echo "<option value=\"{$regionKey}\" $selected>{$regionVal}</option>\n";
}
?>
</select>

</td></tr>
</table>

<?php
if (!$selectedId) {
	echo '<input type="submit" value="登録" name="add">';
} else {
	echo "<input type=\"hidden\" name=\"id\" value=\"{$selectedId}\">";
	echo '<input type="submit" value="更新" name="upd">';
	echo '<input type="submit" value="別レコードとして登録" name="add">';
	echo '<a href="./edit_events.php">クリア</a>';
}
?>
</form>

<table border="1">
  <tr><th>発生日</th><th>見出し</th><th>詳細</th><th>カテゴリ</th><th>重要度</th><th>国・地域</th></tr>
<?php
$categoryNames = array();
foreach ($categories as $category) {
	$categoryNames[$category["id"]] = $category["name"];
}
foreach ($data as $row) {
	$d = getdate(strtotime($row["event_date"]));
	$year = $d["year"];
	$mon = $d["mon"];
	$day = $d["mday"];
	$dateStr = $row["date_type"] == "d" ? "{$year}年{$mon}月{$day}日" : ($row["date_type"] == "m" ?  "{$year}年{$mon}月" : "{$year}年");
	echo "<tr><td>{$dateStr}</td><td><a href=\"./edit_events.php?id={$row["id"]}\">{$row['title']}</a></td><td>{$row['detail']}</td>";
	echo "<td>{$categoryNames[$row["category_id"]]}</td><td>{$row['level']}</td><td>{$regions[$row['region']]}</td></tr>\n";
}
?>
</table>

<?php
$pdo = null;

?>
</body>
</html>