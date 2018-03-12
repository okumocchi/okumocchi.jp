<?php

/*

// �����o�[�̏����Ǘ�
$name1 = "��؃C�`���[";
$name2 = "�ΐ��";

$birthday1 = "1973-10-22";
$birthday2 = "1991-9-17";

echo $name1 . "����͌���" . getAge($birthday1) . "�΂ł��B<br>";
echo $name2 . "����͌���" . getAge($birthday2) . "�΂ł��B<br>";

function getAge($bd) {
 $age = floor((date("Ymd") - date("Ymd", strtotime($bd))) / 10000);
 return $age;
}


// �N���X��p���Đl���ƂɃf�[�^�Ǝ葱�����܂Ƃ߂�

class Member {
  public $name;
  public $birthday;
  
  public function getAge() {
   $age = floor((date("Ymd") - date("Ymd", strtotime($this->birthday))) / 10000);
   return $age;
  }
}  

$m1 = new Member;
$m1->name = "��؃C�`���[";
$m1->birthday = "1973-10-22";
echo $m1->name . "����͌���" . $m1->getAge() . "�΂ł��B<br>";


// private�A�N�Z�X�w��q��p���ăf�[�^���O������B��

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
$m->setName( "��؃C�`���[");
$m->setBirthday("1973-10-22");
echo $m->getName() . "����͌���" . $m->getAge() . "�΂ł��B<br>";

*/


// �R���X�g���N�^��p���ăf�[�^������������

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
  
  // �N���X���\�b�h
  public static function help() {
    echo "���̃N���X�̓����o�[�Ǘ��p�ł��B<br>";
  }
}  

$m = new Member("��؃C�`���[", "1973-10-22");
echo $m->getName() . "����͌���" . $m->getAge() . "�΂ł��B<br>";

$m->help();
Member::help();
$m->st = "age";
echo $m->st;
echo Member::$st;
?>
