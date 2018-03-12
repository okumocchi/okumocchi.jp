<?php
function okumoto($col, $size) {
  echo "<div style=\"color:{$col};font-size:{$size}\">奥本です。最近は仕事でmixiアプリを作ったりしてます。</div>";
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
