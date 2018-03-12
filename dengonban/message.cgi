#!/usr/bin/perl

use POSIX 'strftime';

#+++++++++++++++++++++++++++++++++++++++
# �萔
#---------------------------------------
# �f�[�^�t�@�C����
$DATA_FILE = 'messages.dat';

#��ʑS�̂̃T�C�Y
$STAGE_W = 800;
$STAGE_H = 600;

#���b�Z�[�W�g�̃T�C�Y�i���m�łȂ��Ƃ��\���܂��񂪁A���ۂ̕\���ƍ��킹�Ă��������j
$MESSAGE_W = 192;
$MESSAGE_H = 52;

#1px�ړ�����b����ݒ�1�i1��10�������A60��10���Ԏ����A144��1���A600��4.2������ ������600px�̏ꍇ�j
$SECONDS_A_PIXEL = 144;


#++
# �t�@�C�����烆�[�U�f�[�^���擾
#--

#++
# �p�����[�^���擾
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
# �p�����[�^���n����Ă���ꍇ
# no���w�聨�����f�[�^�̏C��
# no�����w�聨�V�K
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
	# �ǂݏ������p�Ńt�@�C�����J��
	#--
	open(DATA,"+<$DATA_FILE");
	#++
	# �r�����b�N
	#--
	flock(DATA, 2);	
	@Data = <DATA>;
	@UpdatedData = ();
	
	$max_no = 0;
	# �ŏI�X�V��������̌o�ߎ��ԁi�b�j
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
			#�o�ߕb��
			$past_time = time() - $_update_time;
		}
		#++
		#�����̃f�[�^�̌v�Z�i���S�ɕ\���̈�O�Ȃ珑�����݃��X�g����O���j
		#--
		$_y = &ParseTag($_, 'y');
		if ($_y) {
			#�ړ�����
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
	# ���b�N����
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
# �p�����[�^���^�����Ă��Ȃ��Ƃ��͓ǂݏo���̂݁i�t�@�C�����b�N�̕K�v�Ȃ��j
#--
#else {
	$result_code = 1;
	open(DATA,"$DATA_FILE");
	@Data = <DATA>;
	close(DATA);

	#++
	# ���ʒu���X�V����
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
			#�o�ߕb��
			$past_time = time() - $_update_time;
		}

		$_y = &ParseTag($_, 'y');
		if ($_y) {
			#�ړ�����
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



