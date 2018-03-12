#!/usr/bin/perl

#########################################################################################
#このファイルはメルマガFLASHの枝のLesson用ファイルです。                                #
#http://www.1art.jp                                                                     #
#########################################################################################


#require 'jcode.pl';
require 'cgi-lib.pl';

&ReadParse;

while(($key,$value)=each %in){
	$value=~s/&/&amp;/g;
	$value=~s/</&lt;/g;
	$value=~s/>/&gt;/g;
	$value=~s/\"/&quot;/g;
	$value=~s/\r\n?/\n/g;
	$value=~s/\n/<BR>/g;
	$value=~s/\t/    /g;
	$key=~s/&/&amp;/g;
	$key=~s/</&lt;/g;
	$key=~s/>/&gt;/g;
	$key=~s/\"/&quot;/g;
	$key=~s/\r\n?/\n/g;
	$key=~s/\n/<br>/g;
	$key=~s/\t/    /g;
	$in{$key}=$value;
}


print "Content-type:text/html\n\n";
print "<html><head></head><title>送信テスト</title><body>\n";
print "<center>入力完了しました。今入力した内容は以下の通りです。FlashのフォームLoadVars.send()メソ\ッドを使用して変数を送信しました。</center><hr /><br>\n";
print "<b>メッセージ：</b>$in{'message'}<br>\n";
print "<hr />\n";
print "<div align=center><a href=http://1art.jp/flash/le/lesson45/lesson45.htm target=_top>戻る</a></div>\n";
print "</body></html>";

