<?php
require_once 'app/libdb.php';

$musicId = $_POST['music_id'];

if (!$musicId) {
    die('Illegal Access!');
}

$ret = array('result'=>'ok');

$sql = 'UPDATE musics SET play_count=play_count+1 WHERE id=:music_id';
$sth = $db->prepare($sql);
$params = array('music_id'=>$musicId);
$sth->execute($params);

$sql = 'SELECT play_count FROM musics  WHERE id=:music_id';
$sth = $db->prepare($sql);
$sth->execute($params);
$playCount = $sth->fetchColumn();

$ret['play_count'] = $playCount;

echo json_encode($ret);
?>