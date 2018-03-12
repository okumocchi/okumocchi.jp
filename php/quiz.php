<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Script-Type" content="text/javascript" />
  <meta http-equiv="Content-Style-type" content="text/css" />
  <title>quiz</title>
  <link rel="stylesheet" type="text/css" href="quiz.css" />
 </head>
 <body>
 <p id="q">Quiz:朝日洋一はどれでしょう？</p>
 <fieldset>
   <legend>選択肢</legend>
   <input type="button" value="朝日洋一" onclick="$name=朝日洋一" />
   <input type="button" value="朝日陽一" onclick="$name=朝日陽一" />
   <input type="button" value="旭洋一" onclick="$name=旭洋一" />
   <input type="button" value="奥本常在" onclick="$name=奥本常在" />
   <?php 
     if (strpos($name, "朝日洋一") !== false) {
       echo "正解";
     } else if (strpos($name, "朝日陽一") !== false) {
       echo "不正解";
     } else if (strpos($name, "旭洋一") !== false) {
       echo "不正解";
     } else {
       echo "不正解";
     }
   ?>
</fieldset>
</body>
</html>
