<?php 
session_start();
$userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
if (!$userId) {
	header("location: index.php");
	exit();
}

// idが渡されている場合は編集モード
$eventId = isset($_GET['id']) ? $_GET['id'] : 0;

require_once "libutil.php";
require_once "libdb.php";

if ($eventId) {
	// 登録データを読み込む。同時に本人のレコードかどうかチェック
	$sql = "select * from user_events where id=? and user_id=?";
	$sth = $db->prepare($sql);
	$sth->execute(array($eventId, $userId));
	$row = $sth->fetch(PDO::FETCH_ASSOC);
	if (!$row) {
		message("不正なアクセスです。");
	}
	$eventDate 	= $row['event_date'];
	$dateType 	= $row['date_type'];
	$categoryId = $row['category_id'];
	$title 		= $row['title'];
	$comment 	= $row['comment'];
} else {
	$eventDate 	= date("Y-m-d");
	$dateType 	= "d";
	$categoryId = 0;
	$title 		= "";
	$comment 	= "";
}


// usersテーブルから生年月日を取得
$sql = "select birthday from users where id=?";
$sth = $db->prepare($sql);
$sth->execute(array($userId));
$row = $sth->fetch();
$birthday = $row["birthday"];
$birth_y = date("Y", strtotime($birthday));

// 今年
$this_y = date("Y");

// categoriesテーブルから情報を取得
$sql = "select * from categories order by group_no, order_no, id";
$sth = $db->prepare($sql);
$sth->execute();
$categories = $sth->fetchAll();

?>


<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>出来事登録 - BIOGRAM</title>
<script type="text/javascript">
function onChangeDate() {
	var idx = document.fm.eventdate_m.selectedIndex;
	if(idx == 0) {
		document.fm.eventdate_d.selectedIndex = 0;
	}
}
</script>
</head>
<body>
<h2>出来事登録</h2>
<a href="./">トップ</a>
<a href="./edit.php">編集画面</a>
<form name="fm" action="registuserevent_complete.php" method="post">
<table border="1">

<tr><th>発生日</th><td>
<select name="eventdate_y">
<?php 

$selectedDate = getdate(strtotime($eventDate));
if ($dateType == "y")
	$selectedDate["mon"] = $selectedDate["mday"] = 0;
if ($dateType == "m") 
	$selectedDate["mday"] = 0;

$y = $birth_y;
while($y <= $this_y) {
	$age = $y - $birth_y;
	$selected = $y == $selectedDate["year"] ? "selected" : "";
	echo "<option value=\"{$y}\" $selected>{$y}({$age}歳)</option>\n";
	$y++;
}
?>
</select>年

<select name="eventdate_m"   onchange="onChangeDate(this)">
<option value="0">指定しない</option>
<?php
for ($i = 1; $i <= 12; $i++) {
	$selected = $i == $selectedDate["mon"] ? "selected" : "";
	echo "<option value=\"{$i}\" $selected>{$i}</option>\n";
}
?>
</select>月

<select name="eventdate_d"  onchange="onChangeDate(this)">
<option value="0">指定しない</option>
<?php
for ($i = 1; $i <= 31; $i++) {
	$selected = $i == $selectedDate["mday"] ? "selected" : "";
	echo "<option value=\"{$i}\" $selected>{$i}</option>\n";
}
?>
</select>日
</td></tr>

<tr><th>カテゴリ</th><td>
<select name="category_id">
<?php
$_groupNo = 0;
foreach ($categories as $category) {
	$groupNo = $category['group_no'];
	echo $groupNo;
	if ($groupNo != $_groupNo) {
		echo '<option value="999">---------</option>';
		$_groupNo = $groupNo;
	}
	$selected = $eventId && $category['id'] == $categoryId ? "selected" : "";
	if ($categoryId == 1 && $category['id'] == 1 || $categoryId != 1 && $category['id'] != 1) {
		echo "<option value=\"{$category['id']}\" $selected>{$category['name']}</option>\n";
	}
}
?>
</select>

</td></tr>


<tr><th>見出し</th><td><input type="text" name="title" size="50" value="<?php echo $title ?>"></td></tr>
<tr><th>コメント</th><td><textarea name="comment" cols="40" rows="5"><?php echo $comment ?></textarea></tr>


<tr><td colspan="2">
<input type="hidden" name="id" value="<?php echo $eventId ?>">
<?php 
if (!$eventId) {
	echo '<input type="submit" value="登録" name="add">';
} else {
	echo '<input type="submit" value="更新" name="upd">';
	echo '<input type="submit" value="別レコードとして登録" name="add">';
	// 生誕イベントは削除不可
//	if ($categoryId != 1) {
		echo '<input type="submit" value="削除" name="del">';
//	}
}
?>

</td></tr>
</table>

</form>

</body>
</html>