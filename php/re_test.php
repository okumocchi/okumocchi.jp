<?php
$str = "半角全角スペース ＋　全角半角スペース";
$_str = preg_replace('/^[\s　]*(.*?)[\s　]*$/u', '$1', $str);

echo "<pre>$str</pre>";
echo '<br />';
echo "<pre>$_str</pre>";

?>