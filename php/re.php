<!doctype html>
<html lang="jp">
<head>
<meta charset="utf-8">
<title>正規表現チェッカー PHP: preg_match() / JavaScript: match()</title>
<meta name="description" content="PHP: preg_match()とJavaScript: match()による正規表現チェッカー">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<style type="text/css">
body {
  line-height:1.4;
  font-size:16px;
}

h1 {
	font-size:1.2em;
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
  background: #ffe;
}

h3 {
	font-size:0.8em;
	color: #555555;
	margin-left:20px;
}
	#result {
		width: 80%;
		margin: 10px;
		padding: 10px;
		font-size: 0.8em;
		color: #995522;
		background: #ffeeaa;
		border-radius:10px;
	}
#result_js {
	width: 80%;
	margin: 10px;
	padding: 10px;
	font-size:0.8em;
	color:#333388;
	background: #aaaaff;
	border-radius:10px;
}
	button#check-button {
		width:800px;
		line-height: 200%;
		height:40px;
		font-size: 1.4em;
	}

</style>
<script type="text/javascript" src="../js/jquery-1.9.1.min.js"></script>

</head>
<body>
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- ビッグバナー -->
    <ins class="adsbygoogle"
    style="display:inline-block;width:728px;height:90px"
    data-ad-client="ca-pub-6223159363060020"
    data-ad-slot="3273402797"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>


	<div>
		<!-- a href="http://chronicles.link" target="_blank"><img src="../images/chronicles_banner.jpg"></a -->
		<!-- a href="https://geo.itunes.apple.com/jp/app/sinker/id1040508844?mt=8" target="_blank"><img src="../images/ad_banner_pc.jpg"></a -->
		<a href="https://itunes.apple.com/jp/app/goroku/id1084210999?mt=8" target="_blank"><img src="../images/goroku_banner.png"></a>

	</div>

    <!-- ラージビッグバナー
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <ins class="adsbygoogle"
    style="display:inline-block;width:970px;height:90px"
    data-ad-client="ca-pub-6223159363060020"
    data-ad-slot="7843203196"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    -->



<h1>PHP: preg_match() / JavaScript: match() 正規表現チェッカー ver3.0</h1>
<p>PHP及びJavaScriptコーディング中に正規表現を記述する際の動作チェック等にご利用ください。<br />
正規表現と対象文字列を入力し、[チェック！]ボタンをクリックすると、PHP: preg_match()と JavaScript: match()の実行結果がフィードバックされます。</p>

<table border="1">
<tr><th>正規表現</th><td><input type="text" id="re" name="re"  size="80"></td></tr>
<tr><th>文字列</th><td><textarea id="str" name="str" rows="5" cols="65"></textarea></td></tr>
</table>
<div style="color:red;font-size:80%">※正規表現の前後に必ずデリミタ（/などの記号）を記述してください。（JavaScriptではデリミタとして/のみ使用可能です。）</div>

<button value="test" id="check-button">チェック！</button>

<hr size="1">

	<h3>PHP: preg_match()の結果</h3>
	<div id="result">
		<div class="message"></div>
		<div class="matches"></div>
	</div>
	<h3>JavaScript: match()の結果</h3>
	<div id="result_js">
		<div class="message"></div>
		<div class="matches"></div>
	</div>


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
<tr><th>\d</th><td>[0-9]と同じ</td><th>s</th><td colspan="3">シングルラインモードにする(.が改行にマッチする) PHPのみ</td></tr>
<tr><th>\D</th><td>[^0-9]と同じ</td><th>m</th><td colspan="3">マルチラインモードにする(^と$が改行の直前直後にマッチ)</td></tr>
<tr><th>\s</th><td>空白1文字 （[ \r\t\n\f\v] と同じ）</td><th>u</th><td colspan="3">マルチバイト（UTF-8）対応 PHPのみ</td></tr>
<tr><th>\S</th><td>空白以外1文字 （[^ \r\t\n\f\v] と同じ）</td><th>g</th><td colspan="3">繰り返しマッチングを行う JavaScriptのみ</td></tr>
<tr><th>\n</th><td>改行</td><th></th><td colspan="3"></td></tr>
<tr><th>\t</th><td>タブ</td><th></th><td colspan="3"></td></tr>
</table>
<div style="color:red;font-size:80%">※メタ文字は \  ^   .   $   *   ?   |   (   )   [   ]   {   } </div>
<div style="color:red;font-size:80%">※[ ]内はメタ文字は通常の文字として扱われるのでエスケープする必要はありません。</div>
<div style="color:red;font-size:80%">※量指定子に続けて?を記述すると、最短でのマッチングを行います。</div>

<h2>関数リファレンス（PHP）</h2>
<a href="http://jp.php.net/manual/ja/function.preg-match.php">preg_match()</a>
<br>
<a href="http://jp.php.net/manual/ja/function.preg-match-all.php">preg_match_all()</a> ← 繰り返しマッチングさせたい場合はこちら
<br>
<a href="http://jp.php.net/manual/ja/function.preg-replace.php">preg_replace()</a> ← マッチング箇所を別の文字列に置換させたい場合はこちら


<br>
<h2>サンプル（PHP）</h2>
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

			/* Javascriptによるチェック */
			$('#result_js .matches').text('');
			if (ret[1] != '/')  {
				$('#result_js .message').html('JavaScriptではデリミタはスラッシュ(/)のみ使用可能です。');
			} else {
				try {
					eval('var result = "' + str +'".match(' + re + ');');
					if (result) {
						$('#result_js .message').html('一致しました。<br>var m = "' + escapeHTML(str) + '".match(' + escapeHTML(re) + ');<br>の結果は以下の通りです。');
						$.each(result, function(k, v) {
							$('#result_js .matches').append('m[' + k + '] = ' + v + '<br>');
						});

					} else {
						$('#result_js .message').text('一致しません。');
					}
				} catch(e){
					$('#result_js .message').text(e);

				}
			}


			/* PHPによるチェック */
			$.ajax({
				type: 'POST',
				url: 're_exec.php',
				data: {re: re, str: str},
				dataType: 'json',
				success: function(ret) {

					if (ret.ret) {
						if (!ret.matches[0]) { // マルチバイトでuオプションが付いてない場合の対応
							$('#result .message').html('一致しません。');
							$('#result .matches').text('');
						} else {
							$('#result .message').html("一致しました。<br>" + " preg_match('" + escapeHTML(re) + "', '" + escapeHTML(str) + "', $m); <br>の結果は以下の通りです。");
							var matches = "";
							$.each(ret.matches, function(idx, m) {
								matches += '$m[' + idx + '] = ' + escapeHTML(m) + "<br>";
							});
							$('#result .matches').html(matches);
						}

					} else {
						$('#result .message').html('一致しません。');
						$('#result .matches').text('');
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


	<script>
		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		ga('create', 'UA-6543396-1', 'auto');
		ga('send', 'pageview');

	</script>
</body>
</html>