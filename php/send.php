<html>
<head>
<title>メール送信：燃えプロ</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
</head>
<link href="./style.css" rel="stylesheet" type="text/css">
<body>
<?php

$sender = $_POST["email"] ? $_POST["email"] : "info@okumocchi.jp";
$subject = $_POST["subject"] ? $_POST["subject"] : "件名なし";
$message = $_POST["message"];


//mb_language("ja");
//mb_internal_encoding("UTF-8");
//mb_send_mail($sender, $subject, $message);
sendMail("info@okumocchi.jp", $subject, $message, $sender, "");

function sendMail($to, $subject, $body, $from_email,$from_name)
 {
$headers  = "MIME-Version: 1.0 \n" ;
$headers .= "From: " .
       "".mb_encode_mimeheader (mb_convert_encoding($from_name,"ISO-2022-JP","AUTO")) ."" .
       "<".$from_email."> \n";
$headers .= "Reply-To: " .
       "".mb_encode_mimeheader (mb_convert_encoding($from_name,"ISO-2022-JP","AUTO")) ."" .
       "<".$from_email."> \n";
 
    
$headers .= "Content-Type: text/plain;charset=ISO-2022-JP \n";

    
/* Convert body to same encoding as stated 
in Content-Type header above */
    
$body = mb_convert_encoding($body, "ISO-2022-JP","AUTO");
    
/* Mail, optional paramiters. */
$sendmail_params  = "-f$from_email";
    
mb_language("ja");
$subject = mb_convert_encoding($subject, "ISO-2022-JP","AUTO");
$subject = mb_encode_mimeheader($subject);

//$result = mail($to, $subject, $body, $headers, $sendmail_params);
$result = mail($to, $subject, $body, $headers);
       
return $result;
}
        
?>

メール送信を完了しました。<br>

<p><a href="./">燃えプロTOPに戻る</a></p>

</form>

</body>
</html>

