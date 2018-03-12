<?php
	// 
	// メッセージデータ処理
	//
	/////////////////////////////////////////////////////////////////////////////////////////
	// グローバル変数
	/////////////////////////////////////////////////////////////////////////////////////////
	$DATA_FILE = "dengonban.dat";
	
	// 何秒に1px上昇するか。ステージの高さを500pxとした場合
	// 1時間で1pxなら、1周期500時間＝20日
	// 20分で1pxなら、1周期10000分＝167時間＝6.94日（約一週間）	1日で72pix
	// 10分で1pxなら、1周期5000分＝83時間＝3.47日				1日で144pix
	// 1分で1pxなら、1周期500分＝8.3時間
	// 1秒で1pxなら、1周期500秒＝8.3分							
	$SCROLL_RATE = 20 * 60;
	
	
	//
	// POSTデータの取得
	//
	$op 		= $_POST['op'];			// "get" 一覧取得 / "add" 追加 / "upd" 更新 / "del" 削除
	$no			= $_POST['no'];			// messege number 新規追加の場合はNULL
	$message 	= $_POST['message'];
	$owner 		= $_POST['owner'];
	$password 	= $_POST['password'];
	$color	 	= $_POST['color'];
	$x			= $_POST['x'];
	$y			= $_POST['y'];
	$width		= $_POST['width'];
	$height		= $_POST['height'];
	
	if (!$op) {
		$op = "get";
	}
	
//	if ($op == "add" || $op == "upd") {
		$post_message = new Message($no, $message, $owner, $password, $color, $x, $y, $width, $height);
//	}

//$fp = fopen("debug.txt", "a");
//fwrite($fp, "op:{$op}, no:{$no}\n");
//fclose($fp);


	//++
	// データファイルの更新時刻を取得し、ｙ座標の移動量を計算
	//--
	if(!($last_update_time = filemtime($DATA_FILE))) {
		$last_update_time = time();
	}
	$scroll_val = (int)((time() - $last_update_time) / $SCROLL_RATE);
	
	//
	// $op=="get" で　$scroll_valが0のときはファイル情報を更新する必要がない
	//
	$update_flag = ($op == "get" && $scroll_val==0)? false : true;
	
	
	//
	// 	データファイルの読み込み
	// php < 5 だとsimpleXMLが使用できないのでfile_get_contents()を使用
	// -->ロックをするため、fopen()を使用
	//
	
	if (!$update_flag) {
	 	$xml = file_get_contents($DATA_FILE);
	} else {
		if (!($fh = fopen($DATA_FILE, "r+"))) {
			echo "データファイル[{$DATA_FILE}]が開けません。\n";
			exit;
		}
		flock($fh, LOCK_EX);
		$buf = fread($fh, filesize($DATA_FILE));
	
		$message_list = array();
		$max_no = 0;
		
		if (!$buf) {
			$version = "1.0";
		} else {
			//
			// versionの抽出
			//
			preg_match('/<dengonban.+?version="(.+)".*?>/', $buf, $matches);
			$version =  $matches[1];
			
			//
			// メッセージデータの抽出
			//
			preg_match('@<messages>(.*?)</messages>@s', $buf, $messages);
			preg_match_all('@<message.*?>(.*?)</message>@s', $messages[1], $message_xml_list);
			foreach($message_xml_list[0] as $message_xml) {
				//echo $message_xml . "\n";
				$msg = new Message();
				$msg->createFromXML($message_xml);
				if ($msg->no > $max_no) {
					$max_no = $msg->no;
				}
				// y座標の更新
				$msg->y -= $scroll_val;
				$message_list[] = $msg;
			}
		}		
	}
	//
	// オペレーションごとの処理
	//
	switch($op) {
		case "get":
			break;
		case "add":
			$post_message->no = $max_no + 1;
			$message_list[] = $post_message;
			break;
		case "upd":
		case "del":
			// 対象レコードを探す
			$target_idx = null;
			foreach($message_list as $idx=>$msg) {
				if ($msg->no == $post_message->no) {
					$target_idx = $idx;
					break;
				}
			}
			if ($target_idx === null) {
				if ($op == "upd") {
					$message_list[] = $post_message;
				}
			} else {
				if ($op == "upd") {
					$message_list[$target_idx] = $post_message;
				} else {
					unset($message_list[$target_idx]);
					
				}	
			}	
			break;
	}


	if ($update_flag) {
		//
		// ファイル内容を更新
		//
		ftruncate($fh, 0);
		rewind($fh);
		
		
		$xml = makeXML();
		//if(!($fh = fopen($DATA_FILE, "w"))) {
		//	echo "データファイル[{$DATA_FILE}]の更新に失敗しました。\n";
		//	exit;
		//}
		fwrite($fh, $xml);
		flock($fh, LOCK_UN);
		fclose($fh);
	}
	
	//
	// レスポンスコードを作成
	//
//	echo "Content-type: text/html\n\n";
	echo $xml;
//print_r($message_list);


	/////////////////////////////////////////////////////////////////////////////////////////
	// グローバル関数
	/////////////////////////////////////////////////////////////////////////////////////////
	function makeXML() {
		global $version;
		global $message_list;
		
		$xml_str = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
		$xml_str .= "<dengonban version=\"{$version}\">\n";
		$xml_str .= "\t<author>okumocchi.jp</author>\n";
		$xml_str .= "\t<messages>\n";
	
		//++
		// メッセージをすべてXML文字列に変換して追加
		// このとき画面から消えてしまったものは外す
		//--
		foreach($message_list as $msg) {
			//$msg->text = $msg->y . ">" . $msg->height * -1;
			if ($msg->y > $msg->height * -1) {
				$xml_str .= $msg->toXML();
			}
		}
		$xml_str .= "\t</messages>\n";
		$xml_str .= "</dengonban>\n";
		return $xml_str;
	}

	/////////////////////////////////////////////////////////////////////////////////////////
	// クラス定義
	/////////////////////////////////////////////////////////////////////////////////////////
	//
	// メッセージクラス
	//
	class Message {
		var $no;
		var $owner;
		var $text;
		var $color;
		var $x;
		var $y;
		var $width;
		var $height;
		var $post_time;
		
		function Message($no=null, $text=null, $owner=null, $password=null, $color=null, $x=null, $y=null, $width=null, $height=null) 
		{
			$this->no 		= $no;
			$this->text 	= $text;
			$this->owner	= $owner;
			$this->password	= $password;
			$this->color 	= $color;
			$this->x 		= $x;
			$this->y 		= $y;
			$this->width 	= $width;
			$this->height 	= $height;
			
			$this->post_time = time();
		}
		
		function createFromXML($message_xml) 
		{
		
			$reg = '@<message.+?no="([0-9]*)".*?>.*?<text>(.*?)</text>.*?<owner>(.*?)</owner>.*?'
				. '<password>(.*?)</password>.*?<color>([0-9]*)</color>.*?'
				. '<x>(.*?)</x>.*?<y>(.*?)</y>.*?<width>(.*?)</width>.*?<height>(.*?)</height>.*?'
				. '<post_time>([0-9]*)</post_time>.*?</message>@s';
			preg_match($reg, $message_xml, $matches);
			$this->no 			= $matches[1];
			$this->text 		= $matches[2];
			$this->owner 		= $matches[3];
			$this->password 	= $matches[4];
			$this->color 		= $matches[5];
			$this->x 			= $matches[6];
			$this->y			= $matches[7];
			$this->width 		= $matches[8];
			$this->height 		= $matches[9];
			$this->post_time	= $matches[10];
			
		}
		
		function toXML() {
			$message_xml_str = "\t\t<message no=\"{$this->no}\">\n"
				. "\t\t\t<text>{$this->text}</text>\n"
				. "\t\t\t<owner>{$this->owner}</owner>\n"
				. "\t\t\t<password>{$this->password}</password>\n"
				. "\t\t\t<color>{$this->color}</color>\n"
				. "\t\t\t<x>{$this->x}</x>\n"
				. "\t\t\t<y>{$this->y}</y>\n"
				. "\t\t\t<width>{$this->width}</width>\n"
				. "\t\t\t<height>{$this->height}</height>\n"
				. "\t\t\t<post_time>{$this->post_time}</post_time>\n"
				. "\t\t</message>\n"
			;
			return $message_xml_str;
		}
	}
?>