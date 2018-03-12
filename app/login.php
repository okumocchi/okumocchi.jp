<?php 
$password = trim($_POST['password']);
$loginName = trim($_POST['loginname']);
require_once "libutil.php";

if (!$loginName || !$password) {
	message("ログインネームとパスワードの両方を入力してください。");
} else {
	require_once "libdb.php";
	$sql = "select id, handle_name from users where login_name=? and password=?";
	$sth = $db->prepare($sql);
	$sth->execute(array($loginName, md5($password)));
	$rows = $sth->fetch();
	if (!$rows) {
		message("ログインネーム、またはパスワードが違います。");
	}
	$handleName = $rows["handle_name"];
	$userId = $rows["id"];

	session_start();
	$_SESSION['loginname'] = $loginName;
	$_SESSION['handlename'] = $handleName;
	$_SESSION['userid'] = $userId;
	header("location: index.php");
}
?>
