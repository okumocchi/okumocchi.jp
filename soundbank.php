<?php
require_once 'app/libdb.php';

$sql = "SELECT * FROM musics WHERE enabled='t' ORDER BY regist_time DESC";
try {
    $sth = $db->prepare($sql);
    $sth->execute();
    $rows = $sth->fetchAll(PDO::FETCH_ASSOC);
} catch(Exception $e) {
    var_dump($e);
}

$tempoName = array(
    1  => '超低速',
    2  => '非常にゆっくり',
    3  => 'ゆっくり',
    4  => 'ややゆっくり',
    5  => '普通',
    6  => 'やや速い',
    7  => '速い',
    8  => '結構速い',
    9  => '非常に速い',
    10 => '超高速',
);

?>

<!DOCTYPE HTML>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="keywords" content="フリーBGM,フリー音楽素材">
<meta name="description" content="個人・商用利用OKのフリー音楽素材がダウンロードできます">
<title>Jo's Sound Bank</title>
<style type="text/css">
    body {background: #666666;}
    h1 {width:100%;background:#cccccc;color:#333333;text-align: center;}
    table, tr, td, th {border-collapse: collapse;border:1px solid #888888;font-size:10pt}
    td,th {padding:2px 5px;}
    th {background:#aaaaaa;}
    td {background:#eeeeee;}
    table {width:80%;margin:5px auto;}
    td:nth-child(3) { text-align: right;}
    td:nth-child(4) { text-align: center;}
    #note{
        width:90%;
        height:auto;
        margin: 10px auto;
        border-radius: 20px;
        background: #dddddd;
        color: #555;
        font-size: 0.8em;
        padding: 10px;
        line-height: 1.2;

    }
</style>
    <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
</head>
<body>
<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- soundbank -->
<ins class="adsbygoogle"
     style="display:inline-block;width:728px;height:90px"
     data-ad-client="ca-pub-6223159363060020"
     data-ad-slot="3891091999"></ins>
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
</script>

<h1>Jo's Sound Bank 〜フリーBGM素材集〜</h1>
<div id="note">
    サイト管理者が主にスマホアプリのBGM用に自作した音楽データ（mp3）を公開します。<br>
    著作権の放棄は行っていませんが、気に入ったものがあれば商用・非商用問わず自由に使っていただいて構いません。（コピーレフト）<br>
    使用にあたり許可や報告は不要ですが、公開アプリなどに使用される場合はクレジット表記（「Musics from Jo's Apps」とか）や<a href="mailto:info@okumocchi.jp?subject=MUSICダウンロード from Jo's Apps">一報</a>をいただけると嬉しいです。<br>
    また<a href="mailto:info@okumocchi.jp?subject=MUSICに関する感想・要望 to from Jo's Apps"">感想や要望</a>なども気軽にどうぞ。</a>
    ただし趣味の範囲内でのものなので「音楽的におかしい」、「別の曲と似ている」などのご指摘はご容赦ください。<br>
    タイトルは随時追加します。<br>
    <br>
    ※「ループ」が○の曲は組み込む際ループ再生設定をすとスムーズに繋がってリピート再生されます。（サイト上のHTML5機能によるループ再生は一瞬途切れますが、ネイティブアプリの場合はきれいに繋がって聞こえるハズです。）

</div>
<table border="1">
    <tr><th>タイトル</th><th>テンポ</th><th>長さ（秒）</th><th>ループ</th><th colspan="2">再生</th><th colspan="2">ダウンロード</th><th>備考</th><th>登録日</th></tr>
<?php
foreach ($rows as $row) {
?>
    <tr music_id="<?php echo $row['id'];?>">
        <td><?php echo $row['title'] ?></td>
        <td><?php echo $tempoName[$row['tempo']]; ?></td>
        <td><?php echo $row['length'] ?></td>
        <td><?php echo $row['loop_flag']=='t' ? '○' : '' ?></td>
        <td><input type="button" class="play_button" value="再生">
            <audio id="music_<?php echo $row['id'];?>" src="/blog/wp-content/uploads/<?php echo $row['file_name']; ?>" preload="auto"  <?php echo $row['loop_flag'] == 't' ? 'loop' : '';?>></audio>
       </td>
        <td class="play_count"><?php echo $row['play_count']; ?></td>
        <td><a href="<?php echo '/blog/wp-content/uploads/' . $row['file_name']; ?>" download="<?php echo $row['file_name']; ?>" class="dl_button">ダウンロード</a></td>
        <td class="dl_count"><?php echo $row['dl_count']; ?></td>
        <td>
            <?php echo nl2br($row['note']); ?>
        </td>
        <td>
            <?php echo date('Y.n.j', strtotime($row['regist_time'])); ?>
        </td>
    </tr>
<?php
}
?>
    </table>
<script>
    var playingMusicId = 0;
    $(function(){
       $('.play_button').on('click', function(){
           if (playingMusicId) {
               $('audio#music_' + playingMusicId)[0].pause();
               $('tr[music_id=' + playingMusicId + '] input.play_button').val('再生');
           }

           var musicId = $(this).parents('tr').attr('music_id');

           if (playingMusicId == musicId) {
               playingMusicId = 0;
               return;
           }

           $('audio#music_' + musicId)[0].currentTime = 0;
           $('audio#music_' + musicId)[0].play();
           playingMusicId = musicId;
           $(this).val('停止');
           $.ajax('play_count.php', {
               type: 'post',
               dataType: 'json',
               data: {music_id:musicId},
               success: function(ret) {
                   $('tr[music_id=' + musicId + '] td.play_count').text(ret.play_count);

               }
           });


       }) ;

        $('.dl_button').on('click', function(){
            var musicId = $(this).parents('tr').attr('music_id');
            $.ajax('dl_count.php', {
                type: 'post',
                dataType: 'json',
                data: {music_id:musicId},
                success: function(ret) {
                    $('tr[music_id=' + musicId + '] td.dl_count').text(ret.dl_count);

                }
            });
        });

        // ループではない場合の再生終了時処理
        $('audio').on('ended', function(e){
            var musicId = $(this).parents('tr').attr('music_id');
            $('tr[music_id=' + musicId + '] input.play_button').val('再生');
            playingMusicId = 0;
        });
    });

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