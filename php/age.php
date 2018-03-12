<?php

/*

// メンバーの情報を管理
$name1 = "鈴木イチロー";
$name2 = "石川遼";

$birthday1 = "1973-10-22";
$birthday2 = "1991-9-17";

echo $name1 . "さんは現在" . getAge($birthday1) . "歳です。<br>";
echo $name2 . "さんは現在" . getAge($birthday2) . "歳です。<br>";

function getAge($bd) {
 $age = floor((date("Ymd") - date("Ymd", strtotime($bd))) / 10000);
 return $age;
}


// クラスを用いて人ごとにデータと手続きをまとめる

class Member {
  public $name;
  public $birthday;
  
  public function getAge() {
   $age = floor((date("Ymd") - date("Ymd", strtotime($this->birthday))) / 10000);
   return $age;
  }
}  

$m1 = new Member;
$m1->name = "鈴木イチロー";
$m1->birthday = "1973-10-22";
echo $m1->name . "さんは現在" . $m1->getAge() . "歳です。<br>";


// privateアクセス指定子を用いてデータを外部から隠す

class Member {
  private $name;
  private $birthday;
  
  public function getAge() {
   $age = floor((date("Ymd") - date("Ymd", strtotime($this->birthday))) / 10000);
   return $age;
  }
  public function setName($name) {
    $this->name = $name;
  }
  public function setBirthday($birthday) {
    $this->birthday = $birthday;
  }
  public function getName() {
    return $this->name;
  }
}  

$m = new Member;
$m->setName( "鈴木イチロー");
$m->setBirthday("1973-10-22");
echo $m->getName() . "さんは現在" . $m->getAge() . "歳です。<br>";

*/


// コンストラクタを用いてデータを初期化する

class Member {
  private $name;
  private $birthday;
  public static $st = "hoge";
  
  public function getAge() {
   $age = floor((date("Ymd") - date("Ymd", strtotime($this->birthday))) / 10000);
   return $age;
  }
  public function setName($name) {
    $this->name = $name;
  }
  public function setBirthday($birthday) {
    $this->birthday = $birthday;
  }
  public function getName() {
    return $this->name;
  }
  public function __construct($name, $birthday) {
    $this->name = $name;
    $this->birthday = $birthday;
  }
  
  // クラスメソッド
  public static function help() {
    echo "このクラスはメンバー管理用です。<br>";
  }
}  

$m = new Member("鈴木イチロー", "1973-10-22");
echo $m->getName() . "さんは現在" . $m->getAge() . "歳です。<br>";

$m->help();
Member::help();
$m->st = "age";
echo $m->st;
echo Member::$st;
?>
