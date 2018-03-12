<?php
require_once 'app/libdb.php';

$musicId = $_POST['music_id'];

if (!$musicId) {
    die('Illegal Access!');
}

$ret = array('result'=>'ok');

$sql = 'UPDATE musics SET dl_count=dl_count+1 WHERE id=:music_id';
$sth = $db->prepare($sql);
$params = array('music_id'=>$musicId);
$sth->execute($params);

$sql = 'SELECT dl_count FROM musics  WHERE id=:music_id';
$sth = $db->prepare($sql);
$sth->execute($params);
$dlCount = $sth->fetchColumn();

$ret['dl_count'] = $dlCount;

echo json_encode($ret);
?>