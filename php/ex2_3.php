<?php
$tokuten = array(90, 85, 76,43,98, 78);

$sum = 0;
$max = 0;
foreach($tokuten as $ten) {
  $sum += $ten;
  if ($ten > $max) {
    $max = $ten;
  }
}

$ave = $sum / count($tokuten);

echo "平均点は{$ave}点です。<br>";
echo "最高点は{$max}点です。<br>";
?>


