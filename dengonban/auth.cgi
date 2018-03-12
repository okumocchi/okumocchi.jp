#!/usr/bin/perl

$DATA_FILE = 'users.dat';


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

#++
# もしパラメータが渡されていたならば、配列の最後に新規ユーザを追加登録
#--
if($post_data) {
	$user_name = &ParseTag($post_data,'user_name');
	$passwd = &ParseTag($post_data,'password');
	if($user_name && $passwd) {
	
		#++
		# 読み書き両用でファイルを開く
		#--
		open(DATA,"+<$DATA_FILE");
		#++
		# 排他ロック
		#--
		flock(DATA, 2);	
		@Data = <DATA>;
		
		$max_id = 0;
		$exist_flag = 0;
		foreach (@Data){
			$_user_name = &ParseTag($_, 'name');
			if($_user_name && $_user_name eq $user_name) {
				$exist_flag = 1;
				break;
			}
			$_id = &ParseTag($_, 'id');
			if($_id && $_id > $max_id) {
				$max_id = $_id;
			}
		}
	
		if($exist_flag) {
			$result_code = 2;
		}
		else {
			$id = $max_id + 1;
			$data = "<user>\n<id>$id</id>\n<name>$user_name</name>\n<password>$passwd</password>\n</user>\n";
			unshift(@Data, $data);
			
			seek DATA,0,0;
			print DATA @Data;
			$result_code = 1;
		}
		
		#++
		# ロック解除
		#--
		flock(DATA, 8);
		close(DATA);
	}
}
#++
# パラメータが与えられていないときは読み出しのみ（ファイルロックの必要なし）
#--
else {
	$result_code = 1;
	open(DATA,"$DATA_FILE");
	@Data = <DATA>;
	close(DATA);

	foreach (@Data){
		$data .= $_;
	}
}

#	$Data =~ s/\n//g;
#	$Data =~ s/<br>/\r/g;
#	$Data =~ s/(http:\/\/[\w\.\~\-\/\?\&\=\@\;\#\:\%\+]+)/\$a href="$1" title="$1" target="_blank"\$LINK\$\/a\$/g;
$data = "<status>$result_code</status>\n<users>$data</users>";
print "Content-type: text/html\n\n";
print $data;

exit;


sub ParseTag {
	my($Element,$ElementName) = @_;
	my($s,$n);
	$s = index($Element,'<'.$ElementName.'>',0)+length('<'.$ElementName.'>');
	$n = index($Element,'</'.$ElementName.'>',0) - $s;
	substr($Element,$s,$n);
}

