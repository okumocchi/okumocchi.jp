#!/usr/bin/perl

#########################################################################################
#���̃t�@�C���̓����}�KFLASH�̎}��Lesson�p�t�@�C���ł��B                                #
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
print "<html><head></head><title>���M�e�X�g</title><body>\n";
print "<center>���͊������܂����B�����͂������e�͈ȉ��̒ʂ�ł��BFlash�̃t�H�[��LoadVars.send()���\\�b�h���g�p���ĕϐ��𑗐M���܂����B</center><hr /><br>\n";
print "<b>���b�Z�[�W�F</b>$in{'message'}<br>\n";
print "<hr />\n";
print "<div align=center><a href=http://1art.jp/flash/le/lesson45/lesson45.htm target=_top>�߂�</a></div>\n";
print "</body></html>";

