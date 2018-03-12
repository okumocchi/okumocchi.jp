<?php 
session_start();
$userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
$handleName = isset($_SESSION['handlename']) ? $_SESSION['handlename'] : null;
if (!$userId) {
	header("location: index.php");
}

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>BIOGRAM</title>


<link href="./css/sample_cpick.css" type="text/css" rel="stylesheet">
<script type="text/javascript" src="./js/endering-mode.js"></script>
<script type="text/javascript" src="./js/cpick.js"></script>

</head>
<body>
<h1>編集</h1>
<ul>
<?php
	
	// 年齢と日数を求める
	require_once "libdb.php";
	$sql = "select birthday from users where id=?";
	$sth = $db->prepare($sql);
	$sth->execute(array($userId));
	$row = $sth->fetch();
	$birthday = strtotime($row["birthday"]);
	
	$bd = (int)date("Ymd", $birthday);
	$td = (int)date("Ymd");
	$age = floor(($td - $bd) / 10000);
	
	$bds = getdate($birthday);
	$last_bd = mktime( 0, 0, 0, $bds["mon"], $bds["mday"], $bds["year"] + $age);
	$days = floor((time() - $last_bd) / (60 * 60 * 24));
	


	
	// ライフタイトルがPOSTされた場合は更新
	$lifeTitle = isset($_POST["lifetitle"]) ? trim($_POST["lifetitle"]) : "";
	if ($lifeTitle) {
		$sql = "update users set title=? where id=?";
		$sth = $db->prepare($sql);
		$sth->execute(array($lifeTitle, $userId));
	}
	// カラーがPOSTされた場合は更新
	$color = isset($_POST["color"]) ? trim($_POST["color"]) : "";
	if ($color) {
		$sql = "update users set color=? where id=?";
		$sth = $db->prepare($sql);
		$sth->execute(array($color, $userId));
	}



	// ライフタイトルとカラーをDBから取得
	$sql = "select title,color from users where id=?";
	$sth = $db->prepare($sql);
	$sth->execute(array($userId));
	$row = $sth->fetch();
	$lifeTitle = $row["title"] ? $row["title"] : "○○人生";
	$color = $row["color"] ? $row["color"] : "#aaaaff";



	// すべてのユーザイベントを取得
	$sql = "select ue.id, ue.event_date, ue.date_type, c.name as category, ue.title, ue.comment"
		. " from user_events ue join categories c on ue.category_id=c.id"
		. " where user_id=? order by event_date";
	$sth = $db->prepare($sql);
	$sth->execute(array($userId));
	$events = $sth->fetchAll();

?>
     <a href="./">トップ</a> <a href="./logout.php">ログアウト</a>


	<h2><?php echo $handleName ?>さんの人生</h2>
	<table>
	<form action="./edit.php" method="post"><tr><th>人生のタイトル</th><td><input type="text" size="30" name="lifetitle" value="<?php echo $lifeTitle ?>"/><input type="submit" value="更新"></td></tr></form>
	
	<form action="./edit.php" method="post"><tr><th>好きな色</th><td><input type="text" name="color" value="<?php echo $color ?>" size="12" id="t2" class="html5jp-cpick [coloring:true]" /><input type="submit" value="更新"></td></tr></form>
	</table>
	
	<p><a href="registuserevent.php">出来事を登録</a></p>
	<table border="1">
		<tr><th>年月日</th><th>年齢</th><th>カテゴリ</th><th>出来事</th><th>コメント</th></tr>
		<?php
		foreach ($events as $event) {
			$eventId = $event["id"];
			$event_ts =  strtotime($event["event_date"]);
			$dateType = $event["date_type"];
			$event_date = $dateType == 'd' ? date("Y年n月j日",$event_ts) : ($dateType == 'm' ? date("Y年n月",$event_ts) : date("Y年",$event_ts));
			$ed = (int)date("Ymd", $event_ts);
			$age = floor(($ed - $bd) / 10000);
 			$category = $event["category"];
 			$title = $event["title"];
 			$comment = $event["comment"];
 			echo "<tr><td><a href=\"registuserevent.php?id={$eventId}\">{$event_date}</a></td><td>{$age}歳</td><td>{$category}</dh><td>{$title}</dh><td>{$comment}</td></tr>\n";
		}
		?>
	</table>

</body>
</html>