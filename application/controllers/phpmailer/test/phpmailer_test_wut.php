<?php 
require("../class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP(); // telling the class to use SMTP 
$mail->Host     = "mail.info2pres.com"; // SMTP servers
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Username = "webmaster@info2pres.com";  // SMTP username
$mail->Password = "xxxxxxxxxxxxxxxxx"; // SMTP password

$mail->CharSet = "TIS-620"; // Language eg. "iso-8859-1" , "charset=windows-874"
$mail->ConfirmReadingTo = "methasitw@hotmail.com";
$mail->Priority  = 5;

$mail->From     = "webmaster@info2pres.com";
$mail->FromName = "Webmaster";
$mail->AddAddress("methasitw@hotmail.com","Methasit HOT"); 
$mail->AddAddress("methasitw@yahoo.com");               // optional name
$mail->AddReplyTo("info@info2pres.com","Information");

$mail->WordWrap = 50;           // set word wrap
//$mail->AddAttachment("/var/tmp/file.tar.gz");      // attachment
//$mail->AddAttachment("/tmp/image.jpg", "new.jpg"); 
$mail->IsHTML(true);            // send as HTML

$mail->Subject  =  "Here is the subject";
$mail->Body     =  "This is the <b>HTML body</b>";
$mail->AltBody  =  "This is the text-only body";

if(!$mail->Send())
{
   echo "Message was not sent <p>";
   echo "Mailer Error: " . $mail->ErrorInfo;
   exit;
}
else 
{ 
echo "Message has been sent by phpmailer_test_wut.php"; 
} 


?>