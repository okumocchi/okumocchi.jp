<?php
function okumoto($col, $size) {
  echo "<div style=\"color:{$col};font-size:{$size}\">���{�ł��B�ŋ߂͎d����mixi�A�v����������肵�Ă܂��B</div>";
}
$hoge = "hogehoge";

function getCarrier($email) {
  if (strpos($email, "docomo") !== false) {
    return "DoCoMo";
  }
  if (strpos($email, "ezweb") !== false) {
    return "AU";
  }
  if (strpos($email, "softbank") !== false) {
    return "SoftBank" . $hoge;
  }
  return "PC";
}
?>
