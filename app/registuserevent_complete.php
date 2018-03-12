<?php
session_start();
$userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
if (!$userId) {
	header("location: index.php");
	exit();
}

$eventId = $_POST['id'];

$eventdate_y = $_POST['eventdate_y'];
$eventdate_m = $_POST['eventdate_m'];
$eventdate_d = $_POST['eventdate_d'];

// 日付タイプを決定
$dateType = !$eventdate_m ? "y" : (!$eventdate_d ? "m" : "d");
// 月、日が指定されていない場合は便宜的に1を入れる
$eventdate_m = !$eventdate_m ? 1 : $eventdate_m;
$eventdate_d = !$eventdate_d ? 1 : $eventdate_d;

$categoryId = $_POST['category_id'];
$title = trim($_POST['title']);
$comment = trim($_POST['comment']);
require_once "libutil.php";

if (!checkdate($eventdate_m, $eventdate_d, $eventdate_y)) {
	message("存在しない日付です");
}
$eventdate = $eventdate_y . "-" . $eventdate_m . "-" . $eventdate_d;

// DBに登録
require_once "libdb.php";
if (isset($_POST['add'])){
	// 新規登録
	$sql = "insert into user_events(user_id, event_date, date_type, category_id, title, comment) values(?,?,?,?,?,?)";
	$sth = $db->prepare($sql);
	$ret = $sth->execute(array($userId, $eventdate, $dateType, $categoryId, $title, $comment));
} else if(isset($_POST['upd'])) {
	// 更新
	$sql = "update user_events set event_date=?, date_type=?, category_id=?, title=?, comment=?"
		. " where id=? and user_id=?";
	$sth = $db->prepare($sql);
	$ret = $sth->execute(array($eventdate, $dateType, $categoryId, $title, $comment, $eventId, $userId));
} else if (isset($_POST['del'])) {
	// 削除
	$sql = "delete from user_events where id=? and user_id=?";
	$sth = $db->prepare($sql);
	$ret = $sth->execute(array($eventId, $userId));
}

if (!$ret) {
	$err = $sth->errorInfo();
	message($err[2]);
}
header("location: edit.php");
?>
