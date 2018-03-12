#!/usr/bin/perl

use POSIX 'strftime';

#+++++++++++++++++++++++++++++++++++++++
# 定数
#---------------------------------------
# データファイル名
$DATA_FILE = 'messages.dat';

#画面全体のサイズ
$STAGE_W = 800;
$STAGE_H = 600;

#メッセージ枠のサイズ（正確でなくとも構いませんが、実際の表示と合わせてください）
$MESSAGE_W = 192;
$MESSAGE_H = 52;

#1px移動する秒数を設定1（1で10分周期、60で10時間周期、144で1日、600で4.2日周期 ※高さ600pxの場合）
$SECONDS_A_PIXEL = 144;


#++
# ファイルからユーザデータを取得
#--

#++
# パラメータを取得
#--
if ($ENV{'REQUEST_METHOD'} eq "POST"){
	read(STDIN,$post_data,$ENV{'CONTENT_LENGTH'});
} else {
	$post_data = $ENV{'QUERY_STRING'};
}

$result_code = 0;

open(FILE,">log.txt");
print FILE "--------------\n";
print FILE $post_data;
close(FILE);



#++
# パラメータが渡されている場合
# noが指定→既存データの修正
# noが無指定→新規
#--
if($post_data) {
	$x 			= &ParseTag($post_data,'x');
	$y 			= &ParseTag($post_data,'y');
	$col 		= &ParseTag($post_data,'col');
	$password	= &ParseTag($post_data,'password');
	$name 		= &ParseTag($post_data,'name');
	$title 		= &ParseTag($post_data,'title');
	$content 	= &ParseTag($post_data,'content');
	$no 		= &ParseTag($post_data,'no');

	#$post_time = strftime "%Y-%m-%d %H:%M:%S", localtime;
	$post_time = time();
	$update_time = $post_time;


	#++
	# 読み書き両用でファイルを開く
	#--
	open(DATA,"+<$DATA_FILE");
	#++
	# 排他ロック
	#--
	flock(DATA, 2);	
	@Data = <DATA>;
	@UpdatedData = ();
	
	$max_no = 0;
	# 最終更新時刻からの経過時間（秒）
	$past_time = 0; 
	foreach (@Data){
		if ($_ =~ /^<message>/) {
			$item = "";
			$del_flag = 0;
		}
		
		$_no = &ParseTag($_, 'no');
		if($_no && $_no > $max_no) {
			$max_no = $_no;
		}
		
		$_w = &ParseTag($_, 'update_time');
		if ($_w) {
			$_update_time = $_w;
			#経過秒数
			$past_time = time() - $_update_time;
		}
		#++
		#既存のデータの計算（完全に表示領域外なら書き込みリストから外す）
		#--
		$_y = &ParseTag($_, 'y');
		if ($_y) {
			#移動距離
			$length = $past_time / $SECONDS_A_PIXEL;
			$_y = $_y - $length;
			
			if ( $_y < - (($STAGE_H + $MESSAGE_H) / 2 )) {
				$del_flag = 1;
			}
		}

		$item .= $_;
		
		if ($_  =~ /^<\/message>/ && $del_flag == 0) {
			unshift(@UpdatedData, $item);
		}	
			 
	}

	if(!$no) {
		$no = $max_no + 1;
	}
	$data = "<message>\n<no>$no</no>\n<password>$password</password>\n<name>$name</name>\n<title>$title</title>\n<post_time>$post_time</post_time>\n<update_time>$update_time</update_time>\n<x>$x</x>\n<y>$y</y>\n<color>$col</color>\n<content>$content</content>\n</message>\n";
	unshift(@UpdatedData, $data);
	
	truncate(DATA, 0);
	
	seek DATA,0,0;
	print DATA @UpdatedData;
	$result_code = 1;
	
	#++
	# ロック解除
	#--
	flock(DATA, 8);
	close(DATA);
	
	
	$result_code = 1;
	open(DATA,"$DATA_FILE");
	@Data = <DATA>;
	close(DATA);

#	foreach (@Data){
#		$data .= $_;
#	}
}


#++
# パラメータが与えられていないときは読み出しのみ（ファイルロックの必要なし）
#--
#else {
	$result_code = 1;
	open(DATA,"$DATA_FILE");
	@Data = <DATA>;
	close(DATA);

	#++
	# ｙ位置を更新する
	#--
	@UpdatedData = ();
	$past_time = 0;
	$data = "";
	foreach (@Data){
		if ($_ =~ /^<message>/) {
			$item = "";
			$del_flag = 0;
		}
		
		$_w = &ParseTag($_, 'update_time');
		if ($_w) {
			$_update_time = $_w;
			#経過秒数
			$past_time = time() - $_update_time;
		}

		$_y = &ParseTag($_, 'y');
		if ($_y) {
			#移動距離
			$length = $past_time / $SECONDS_A_PIXEL;
			$_y = $_y - $length;
			$item .= "<y>$_y</y>\n";
		}
		else {
			$item .= $_;
		}
		
		if ($_  =~ /^<\/message>/ ) {
			$data .= $item;
		}	
	}
#}

#	$Data =~ s/\n//g;
#	$Data =~ s/<br>/\r/g;
#	$Data =~ s/(http:\/\/[\w\.\~\-\/\?\&\=\@\;\#\:\%\+]+)/\$a href="$1" title="$1" target="_blank"\$LINK\$\/a\$/g;
$data = "<status>$result_code</status>\n<messages>$data</messages>";
print "Content-type: text/html\n\n";
print $data;exit;


sub ParseTag {
	my($Element,$ElementName) = @_;
	my($s,$n);
	$s = index($Element,'<'.$ElementName.'>',0);
	$n = index($Element,'</'.$ElementName.'>',0);
	
	if ($s == -1 || $n == -1) {
		return '';
	}

	$s += length('<'.$ElementName.'>');
	$n -= $s;
	substr($Element,$s,$n);
}



