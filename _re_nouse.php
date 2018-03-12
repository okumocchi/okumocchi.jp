<!doctype html>
<html lang="jp">
<head>
<meta charset="utf-8">
<title>preg_match()正規表現チェッカー</title>
<meta name="description" content="preg_match()による正規表現チェッカー">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">
body {
  line-height:1.4;
  font-size:16px;
}

h1 {
  background: #555;
  color: #fff;
  padding: 8px;
}

th {background:#cce;color:#005}
table {border-collapse: collapse;}
table, td, th {border:1px solid #002}
td, th {padding: 5px}

input[type=text], textarea {
  font-size:1.2em;
  background: ffe;
}
</style>
<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>

</head>
<body>

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- ラージビッグバナー
    <ins class="adsbygoogle"
    style="display:inline-block;width:970px;height:90px"
    data-ad-client="ca-pub-6223159363060020"
    data-ad-slot="7843203196"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>


-->

	<div>
		<!-- a href="http://chronicles.link" target="_blank"><img src="../images/chronicles_banner.jpg"></a -->
		<a href="https://geo.itunes.apple.com/jp/app/sinker/id1040508844?mt=8" target="_blank"><img src="../images/ad_banner_pc.jpg"></a>

	</div>

<h1>PHP：preg_match()正規表現チェッカー ver2.0</h1>
<p>PHPコーディング中に正規表現を記述する際の動作チェック等にご利用ください。<br />
正規表現と対象文字列を入力し、[チェック！]ボタンをクリックすると、preg_match()の実行結果がフィードバックされます。</p>

<table border="1">
<tr><th>正規表現</th><td><input type="text" id="re" name="re"  size="80"></td></tr>
<tr><th>文字列</th><td><textarea id="str" name="str" rows="5" cols="65"></textarea></td></tr>
</table>
<div style="color:red;font-size:80%">※正規表現の前後に必ずデリミタ（/などの記号）を記述してください</div>
<input type="button" value="チェック！" id="check-button">


<hr size="1">
<p id="result">ここに結果が表示されます。</p>
<p id="matches"></p>
<hr size="1">


<h2>リファレンス</h2>
<table border="1">
<tr><th colspan="2">文字クラス</th><th colspan="2">量指定子</th><th colspan="2">その他のメタ文字</th></tr>
<tr><th>[abc]</th><td>a,b,cいずれかの1文字</td><th>*</th><td>0回以上の繰り返し</td><th>.</th><td>改行以外の1文字</td></tr>
<tr><th>[^abc]</th><td>a,b,c以外の1文字</td><th>+</th><td>1回以上の繰り返し</td><th>^</th><td>行頭</td></tr>
<tr><th>[A-Z]</th><td>大文字のアルファベット1文字</td><th>?</th><td>0回または1回の出現</td><th>$</th><td>行末</td></tr>
<tr><th>[0-9]</th><td>数字1文字</td><th>{n}</th><td>n回の繰り返し</td><th>|</th><td>いずれかの文字列</td></tr>
<tr><th>[a-zA-Z0-9]</th><td>アルファベットか数字1文字</td><th>{n,m}</th><td>n回以上、m回以下の繰り返し</td><th>()</th><td>グループ化</td></tr>
<tr><th>[!-~]</th><td>半角文字1文字</td><th>{n,}</th><td>n回以上の繰り返し</td><th>\</th><td>直後のメタ文字をエスケープする</td></tr>
<tr><th>\w</th><td>アルファベットか数字かアンダースコア1文字</td><th colspan="4">修飾子（末尾のデリミタの後ろに記述)</th> </tr>
<tr><th>\W</th><td>アルファベット、数字、アンダースコア以外の1文字</td><th>i</th><td colspan="3">大小文字の違いを無視する</td></tr>
<tr><th>\d</th><td>[0-9]と同じ</td><th>s</th><td colspan="3">シングルラインモードにする(.が改行にマッチする)</td></tr>
<tr><th>\D</th><td>[^0-9]と同じ</td><th>m</th><td colspan="3">マルチラインモードにする(^と$が改行の直前直後にマッチ)</td></tr>
<tr><th>\s</th><td>空白1文字 （[ \r\t\n\f\v] と同じ）</td><th>u</th><td colspan="3">マルチバイト（UTF-8）対応</td></tr>
<tr><th>\S</th><td>空白以外1文字 （[^ \r\t\n\f\v] と同じ）</td><th></th><td colspan="3"></td></tr>
<tr><th>\n</th><td>改行</td><th></th><td colspan="3"></td></tr>
<tr><th>\t</th><td>タブ</td><th></th><td colspan="3"></td></tr>
</table>
<div style="color:red;font-size:80%">※メタ文字は \  ^   .   $   *   ?   |   (   )   [   ]   {   } </div>
<div style="color:red;font-size:80%">※[ ]内はメタ文字は通常の文字として扱われるのでエスケープする必要はありません。</div>
<div style="color:red;font-size:80%">※量指定子に続けて?を記述すると、最短でのマッチングを行います。</div>

<h3>関数詳細</h3>
<a href="http://jp.php.net/manual/ja/function.preg-match.php">preg_match()</a>
<br>
<a href="http://jp.php.net/manual/ja/function.preg-match-all.php">preg_match_all()</a> ← 繰り返しマッチングさせたい場合はこちら
<br>
<a href="http://jp.php.net/manual/ja/function.preg-replace.php">preg_replace()</a> ← マッチング箇所を別の文字列に置換させたい場合はこちら


<br>
<h2>サンプル</h2>
<table border="1">
<tr><th></th><th>正規表現</th><th>使用例</th></tr>
<tr><th>郵便番号</th><td>/^[0-9]{3}-[0-9]{4}$/</td><td>if (preg_match('/^[0-9]{3}-[0-9]{4}$/', $str)) { </td></tr>
<tr><th>電話番号</th><td>/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/</td><td>if (preg_match('/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/', $str)) { </td></tr>
<tr><th>Emailアドレス</th><td>|^[0-9a-z_./?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$|</td><td>if (preg_match('|^[0-9a-z_./?-]+@([0-9a-z-]+\.)+[0-9a-z-]+$|', $str)) { </td></tr>
<tr><th>全角空白のトリム</th><td>/^　*(.*?)　*$/u</td><td>$str = preg_replace('/^　*(.*?)　*$/u', '$1', $str);</td></tr>
<tr><th>半角＋全角空白のトリム</th><td>/^[\s　]*(.*?)[\s　]*$/u</td><td>$str = preg_replace('/^[\s　]*(.*?)[\s　]*$/u', '$1', $str);</td></tr>
</table>

<script>
var braceDelimiters = {'(':')', '{':'}', '[':']', '<':'>'};
$(function() {
    $('#check-button').click(function() {
    	var re = $('#re').val(),
    	    str = $('#str').val();
    	    
    	    
    	if (re && str) {
    	
    	
     	//if (!/^[^a-zA-Z0-9\\].*[^a-zA-Z0-9\\][a-zA-Z]*$/.test(re)) {
    	
    	var delimiterFlag = false;
    	if (ret = re.match(/^([^a-zA-Z0-9\\]).*([^a-zA-Z0-9\\])[a-zA-Z]*$/)) {
    		
    		if (braceDelimiters[ret[1]]) {
    		    delimiterFlag = ret[2] == braceDelimiters[ret[1]];
    		} else {
    		    delimiterFlag = ret[1] == ret[2];
    		}
    	}
    	
    	if (!delimiterFlag) {
    		alert('デリミタがありません。デリミタは正規表現の両端に位置する区切り記号で、/、#、~、%などバックスラッシュ以外の記号が使用できます。');
    		return;
		}    
   	
    	
    	    $.ajax({
    	        type: 'POST',
    	        url: 're_exec.php',
    	        data: {re: re, str: str},
    	        dataType: 'json',
    	        success: function(ret) {
    	            console.log(ret);
    	            
    	            
    	            if (ret.ret) {
       	                $('#result').html("一致しました。<br>" + " preg_match('" + escapeHTML(re) + "', '" + escapeHTML(str) + "', $m) <br>の結果は以下の通りです。");
    	            	var matches = "";
    	            	$.each(ret.matches, function(idx, m) {
    	            	    matches += '$m[' + idx + '] = ' + escapeHTML(m) + "<br>";
    	            	});
    	            	$('#matches').html(matches);
    	            
    	            } else {
    	                $('#result').html('一致しません。');
    	                $('#matches').text('');
    	            }
    	            
    	        }
    	    });
    	}
    
    });
});

function escapeHTML(val) {
    return $('<div>').text(val).html();
};
</script>



</body>
</html>