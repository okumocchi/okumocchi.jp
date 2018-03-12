<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ユーザ登録 - 自分史チェッカー</title>
</head>
<body>
<h2>ユーザ登録</h2>
<?php
$loginName = trim($_POST['loginname']);
$password = trim($_POST['password']);
$handleName = trim($_POST['handlename']);
$birthday_y = $_POST['birthday_y'];
$birthday_m = $_POST['birthday_m'];
$birthday_d = $_POST['birthday_d'];
$gender = $_POST['gender'];

require_once "libutil.php";

if (!$loginName || !$password || !$handleName || !$gender) {
	message("すべての項目を入力してください");
}

if (!checkdate($birthday_m, $birthday_d, $birthday_y)) {
	message("生年月日が存在しない日付です");
}
$birthday = $birthday_y . "-" . $birthday_m . "-" . $birthday_d;

// ログインネームの重複をチェック
require_once "libdb.php";

$sql = "select count(id) as cnt from users where login_name=?";
$sth = $db->prepare($sql);
$sth->execute(array($loginName));
$row = $sth->fetch();
$cnt = $row['cnt'];
if ($cnt) {
	message ("すでに使われているログインネームです。異なるログインネームを入力ください");
}

$sql = "insert into users(login_name, password, handle_name, birthday, gender) values(?,?,?,?,?)";
$sth = $db->prepare($sql);
$ret = $sth->execute(array($loginName, md5($password), $handleName, $birthday, $gender));
if (!$ret) {
	$err = $sth->errorInfo();
	message($err[2]);
}

// user_eventsテーブルに誕生イベントを登録しておく
$userId = $db->lastInsertId();

$sql = "insert into user_events(user_id, event_date, category_id) values(?, ?, 1)";
$sth = $db->prepare($sql);
$ret = $sth->execute(array($userId, $birthday));
if (!$ret) {
	$err = $sth->errorInfo();
	message($err[2]);
}



?>
<p>ユーザ登録が完了しました。トップページよりログインしてください。<a href="./">トップに戻る</a></p>
</body>
</html>