<?php 
session_start();
$userId = isset($_SESSION['userid']) ? $_SESSION['userid'] : null;
$handleName = isset($_SESSION['handlename']) ? $_SESSION['handlename'] : null;

//$selectedUserId = isset($_POST['userid']) ? $_POST['userid'] : $userId;
$selectedUserId = isset($_GET['userid']) ? $_GET['userid'] : null;
if ($selectedUserId) {
	$size = "l" ;
} else {
	$size = isset($_GET['sz']) ? $_GET['sz'] : "l";
	$selectedUserId = $userId;
}

require_once "libdb.php";
if ($userId) {
	// ユーザ一覧を取得
	$users = array();
	$sql = "select id, handle_name, title, birthday,color from users order by id";
	$sth = $db->prepare($sql);
	$sth->execute();
	$_users = $sth->fetchAll(PDO::FETCH_ASSOC);
	foreach ($_users as $u) {
		$users[$u['id']] = $u;
	}
	
	// ユーザイベントを取得
	// ⇒sizeがLのときはすべて、Mのときは3以上、Sのときは５のみ
	$fromLv = $size == "l" ? 1 : ($size == "m" ? 4 : 5);

	if ($size == "s") {
		$userIdList = join(",", array_keys($users));
	} else {
		$userIdList = $selectedUserId;
	}

	$sql = "select ue.user_id, ue.id, ue.event_date, ue.date_type, c.name as category, c.caption, ue.title, ue.comment, c.level"
		. " from user_events ue join categories c on ue.category_id=c.id"
		. " where user_id in($userIdList) and level>={$fromLv} order by event_date";
	$sth = $db->prepare($sql);
	$sth->execute(array($selectedUserId));
	$_events = $sth->fetchAll();
	$eventsList = array();
	foreach ($_events as $e) {
		$eventsList[$e['user_id']][] = $e;
	}
	
}

?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="style.css" />
<script type="text/javascript" src="./js/jquery-1.7.min.js"></script>



<title>LifeNote</title>
</head>
<body>

<div id="header">
	<div id="loginform">
	<?php 
		if ($userId) {
	    	echo '<a href="./logout.php">ログアウト</a>';
		} else {
			echo<<<EOF
			<form action="login.php" method="post">
	  			ﾛｸﾞｲﾝﾈｰﾑ<input type="text" name="loginname"> ﾊﾟｽﾜｰﾄﾞ<input type="password" name="password"> <input type="submit" value="ﾛｸﾞｲﾝ"><br><br>
      			<a href="./regist.php">ユーザ登録</a>
			</form>
EOF;
		}
	?>
	</div>	
	<div id="title">LifeNote</div>
</div>


<?php 
if ($userId) { 
	$thisYear = date("Y");
	$thisMon = date("m");
	
	// 表示開始年 （複数表示の場合はもっとも年上の人に合わせる）
	$minYear =  9999;
	foreach ($users as $u) {
		$y = date("Y", strtotime($u['birthday']));
		if ($y < $minYear) {
			$minYear = $y;
		}
	}
	
	$birthYear = date("Y", strtotime($users[$selectedUserId]["birthday"]));
	
	$y = $size == "s" ? $minYear : $birthYear;
	
	// グローバルイベントを取得
	$fromLv = $size == "l" ? 4 : 5;
	$sql = "select * from events where event_date between ? and ? and level >= $fromLv order by event_date";
	$sth = $db->prepare($sql);
	$sth->execute(array("{$y}-1-1", "{$thisYear}-12-31"));
	$globalEvents = $sth->fetchAll(PDO::FETCH_ASSOC);

?>

<div id="navi">
	
	<!-- div class="userlist">
	<form action="index.php" method="post">
	<select name="userid" onchange="submit()">
	<?php
	foreach ($users as $user) {
		$selected = $user['id'] == $selectedUserId ? "selected" : "";
		echo "<option value=\"{$user['id']}\" $selected>{$user['handle_name']}</option>\n";
	}
	?>
	</select>
	</form>
	</div -->
	<div id="size">
	<a href="./?sz=s">小</a> <!-- a href="./?sz=m">中</a--> <a href="./?sz=l">大</a> <a href="./admin/">admin</a>
	</div>
	
</div>
	
<div id="main">
	<div id="global-events">
		<div id="years"></div>
		<?php
		$yearH = $size == "l" ? 60 : ($size == "m" ? 24 : 10);
		$monH = floor($yearH / 12);	

		
		$topYear = $size =="l" || $size == "m" ? $birthYear : floor($minYear / 10) * 10;
		//++
		// グローバルイベントの表示
		//--
		$_top = -100; // 一つ前の項目の位置
		foreach ($globalEvents as $e) {
			$ed = getdate(strtotime($e["event_date"]));
			$top = ($ed["year"] - $topYear) * $yearH + ($ed["mon"] - 1) * $monH;
			if ($top < $_top + 13) {
				$top = $_top + 13;
			}
			$_top = $top;
			echo "<div class=\"item\"  id=\"{$e['id']}\" style=\"top:{$top}px\">{$e['title']}</div>\n";
		}
		?>
	</div>
	
	<?php
	$left = 100;
	foreach ($users as $uId => $user) {
		
		if ($size != "s" && $uId != $selectedUserId) {
			continue;
		}
		$left += 150;
	?>
	
	<div class="personal-events" style="left:<?php echo $left ?>">
		<?php
		// 年齢と日数を求める
		$birthday = strtotime($users[$uId]["birthday"]);
		
		$bd = (int)date("Ymd", $birthday);
		$td = (int)date("Ymd");
		$age = floor(($td - $bd) / 10000);
		
		$bds = getdate($birthday);
		$last_bd = mktime( 0, 0, 0, $bds["mon"], $bds["mday"], $bds["year"] + $age);
		$days = floor((time() - $last_bd) / (60 * 60 * 24));

		$birthYear = $bds["year"];
		$birthMon = $bds["mon"];

		
		// ラインの表示
		$top = ($birthYear - $topYear) * $yearH + ($birthMon- 1) * $monH;
		$height = ($thisYear - $topYear) * $yearH + $thisMon * $monH - $top;
		$color = $users[$uId]["color"]  ? $users[$uId]["color"] : "#aaf";
		echo "<div class=\"bar\" style=\"top:{$top}; height:{$height}; background:{$color}\"></div>\n";
		
		?>
		<div class="profile" style="top: <?php echo $top - 70 ?>">
			<div class="handlename"><?php echo $users[$uId]['handle_name'] ?><span style="font-size:70%">の</span></div>
			
			<?php
			$lifeTitle =  $users[$uId]['title'] ? $users[$uId]['title'] : "○○人生";
			echo "<div class=\"life-title\"><a href=\"./?userid={$uId}\">{$lifeTitle}</a></div>\n";
			?>
			<div class="age">現在<?php echo $age ?>歳と<?php echo $days ?>日
			<?php
			if ($uId == $userId) {
				echo "<a href=\"./edit.php\">編集</a>";
			}
			?>
			</div>
		</div>
		
		
		
		
		<?php
		$events = $eventsList[$uId];
		$_top = -100; // 一つ前の項目の位置
		foreach ($events as $event) {
			$event_ts =  strtotime($event["event_date"]);
			$dateType = $event["date_type"];
			$event_date = $dateType == 'd' ? date("Y年n月j日",$event_ts) : ($dateType == 'm' ? date("Y年n月",$event_ts) : date("Y年",$event_ts));
			$ed = (int)date("Ymd", $event_ts);
			$age = floor(($ed - $bd) / 10000);
 			$category = $event["category"];
 			$title = $event["title"];
 			$comment = $event["comment"];
 			$level = $event["level"];
 			
 			$ed = getdate($event_ts);
			$top =($ed["year"] - $topYear) * $yearH + ($ed["mon"] - 1) * $monH;
			
			if ($top - $_top < 15) {
				$top = $_top + 15;
			}
			$_top = $top;
			
			$caption = $event["caption"];
			$fontSize = 90 - (5 - $level) * 6; 
			$itemStr = $size == "s" ? $category : "<span class=\"caption\">{$caption}</span>" . $title;

 			echo "<div class=\"item\" id=\"{$event['id']}\" style=\"top:{$top};font-size:{$fontSize}%\">{$itemStr}</div>\n";
 			//echo "<tr><td>{$event_date}</td><td>{$title}</dh></tr>\n";
		}?>
		
		</div>
	<?php
	}
	?>
	</div>
	<div id="footer"></div>

	<div id ="comment">
	</div>
<?php } ?>

</body>
</html>

<script type="text/javascript">
$(function() {
	// イベント詳細を配列に入れておく
	var globalEvents = new Array();
	var personalEvents = new Array();
	
	var yearH = <?php echo $yearH ?>;
	var monH = <?php echo $monH ?>;
	var topYear = <?php echo $topYear ?>;
	var size = "<?php echo $size ?>";
	
	<?php
		foreach ($globalEvents as $e) {
			$detail = preg_replace( '/\r\n/', "<br>", $e['detail'] );
			$detail = preg_replace( '/\n|\r|(\r\n)/', "<br>", $detail );
			echo "globalEvents[{$e['id']}] = \"{$detail}\";\n";
		}

		foreach ($events as $e) {
			$comment = preg_replace( '/\r\n/', "<br>", $e['comment'] );
			$comment = preg_replace( '/\n|\r|(\r\n)/', "<br>", $comment );
			echo "personalEvents[{$e['id']}] = \"{$comment}\";\n";
		}
	?>

	// メインペインの高さを調節
	var thisYear = <?php echo $thisYear ?>;
	var birthYear = <?php echo $birthYear ?>;
	var endYear = size == "s" ? Math.floor(thisYear / 10) * 10 + 9: thisYear; 
	$('#main').css("height", (endYear - topYear + 1) * yearH).css('background-image', 'url(./images/bg_' + size +'.png)');

	// 西暦を表示
	for (var i = topYear ; i <= <?php echo date("Y") ?>; i++) {
		if (size == "s" && i % 10 > 0) continue;
		$("#global-events #years").append('<div class="year">' + i + '</div>');
	}
	$('.year').css('height', size == "s" ? yearH * 10 : yearH).css('font-size', 20);
	
	// グローバルイベント
	$('#global-events .item').mouseout(function(){
		$('#comment').hide();
	});
	$('#global-events .item').mouseover(function(){
		var id = $(this).attr('id');
		if (globalEvents[id]) {
			var top  = $(this).offset().top + 12;   
			$('#comment').html(globalEvents[id]).css('left', 50).css('top', top).show();
		}
	
	});
	
	// パーソナルイベント
	$('.personal-events .item').mouseout(function(){
		$('#comment').hide();
	});
	$('.personal-events .item').mouseover(function(){
		var id = $(this).attr('id');
		var top  = $(this).offset().top + 16;   
		$('#comment').html(personalEvents[id]).css('left',250). css('top', top).show();
	
	});
	
	$('#comment').click(function() {
		$(this).hide();
	});
});

</script>
