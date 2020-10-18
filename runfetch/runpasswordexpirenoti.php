<?php 
include('config_db.php');
//include('../application/controllers/class/class.simple_mail.php');
include('../application/controllers/class/phpmailer/PHPMailerAutoload.php');
date_default_timezone_set("Asia/Bangkok");
$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

$obj_sql = "select * from LMS_SETTING_MAIL where sm_id='1'";
$query_obj = mysqli_query($conndb,$obj_sql);
$fetch_setmail = mysqli_fetch_array($query_obj);

$expiredate = date('Y-m-d',strtotime('+1 day'));
$where = 'LMS_USP.u_isDelete="0" and LMS_EMP.emp_isDelete="0" and LMS_USP.expiredate like "%'.$expiredate.'%" and LMS_USP.expiredate!="0000-00-00 00:00:00"';
$db->where($where);
$db->join('LMS_EMP','LMS_USP.emp_id = LMS_EMP.emp_id');
$fetch_passexp = $db->get('LMS_USP');
$lang = "english";

$date = date('d ',strtotime($expiredate)).$thaimonth[intval(date('m',strtotime($expiredate)))]." ".(date('Y',strtotime($expiredate))+543);
if($lang!="thai"){
	$date = date('d F Y',strtotime($expiredate));
}
$where = 'smf_show="1" and smf_type="17"';
$db->where($where);
$fetch_formatmail = $db->getOne('LMS_SENDMAIL_FORM');
if(count($fetch_passexp)>0){
	foreach ($fetch_passexp as $key_passexp => $value_passexp) {
		if($value_passexp['email']!=""){
			$subject_th = $fetch_formatmail['smf_subject_th'];
			$subject_en = $fetch_formatmail['smf_subject_en'];
			$message_th = $fetch_formatmail['smf_message_th'];
			$message_en = $fetch_formatmail['smf_message_en'];
			if($subject_th!=""){
				$subject_th = str_replace("#fullname",$value_passexp['fullname_th'],$subject_th);
				$subject_th = str_replace("#username",$value_passexp['useri'],$subject_th);
				$subject_th = str_replace("#email",$value_passexp['email'],$subject_th);
				$subject_th = str_replace("#link_frontend",base_url(),$subject_th);
				$subject_th = str_replace("#date",$date,$subject_th);
				$subject_th = str_replace("#time",date('H:i'),$subject_th);
			}
			if($subject_en!=""){
				$subject_en = str_replace("#fullname",$value_passexp['fullname_en'],$subject_en);
				$subject_en = str_replace("#username",$value_passexp['useri'],$subject_en);
				$subject_en = str_replace("#email",$value_passexp['email'],$subject_en);
				$subject_en = str_replace("#link_frontend",base_url(),$subject_en);
				$subject_en = str_replace("#date",$date,$subject_en);
				$subject_en = str_replace("#time",date('H:i'),$subject_en);
			}
			if($message_th!=""){
				$message_th = str_replace("#fullname",$value_passexp['fullname_th'],$message_th);
				$message_th = str_replace("#username",$value_passexp['useri'],$message_th);
				$message_th = str_replace("#email",$value_passexp['email'],$message_th);
				$message_th = str_replace("#link_frontend",base_url(),$message_th);
				$message_th = str_replace("#date",$date,$message_th);
				$message_th = str_replace("#time",date('H:i'),$message_th);
			}
			if($message_en!=""){
				$message_en = str_replace("#fullname",$value_passexp['fullname_en'],$message_en);
				$message_en = str_replace("#username",$value_passexp['useri'],$message_en);
				$message_en = str_replace("#email",$value_passexp['email'],$message_en);
				$message_en = str_replace("#link_frontend",base_url(),$message_en);
				$message_en = str_replace("#date",$date,$message_en);
				$message_en = str_replace("#time",date('H:i'),$message_en);
			}
			if($lang == "thai") {
				sendEmail( $value_passexp['email'] , $message_th, $subject_th,$fetch_setmail);
			} else {
				sendEmail( $value_passexp['email'] , $message_en, $subject_en,$fetch_setmail);
			}
		}
	}
}

function sendEmail($email, $message ,$subject,$object_connect){
		//require_once 'class/phpmailer/PHPMailerAutoload.php';
		header('Content-Type: text/html; charset=utf-8');
		$sub = "ข้อความจากเว็บไซต์";
		$mail = new PHPMailer;
	    $mail->CharSet = "utf-8";
	     
	    $mail->isSMTP();
	    $mail->Host = $object_connect['sm_host'];//'mail.verztec.com';
	    $mail->Port = $object_connect['sm_port'];//587;
	    //$mail->SMTPSecure = 'tls';
	    if($object_connect['sm_smtpauth']=="true"){
	    	$mail->SMTPAuth = true;
	    }else{
	    	$mail->SMTPAuth = false;
	    }
	    //true;
	     
	    $gmail_username = $object_connect['sm_username'];//"pandora@verztec.com"; // gmail ที่ใช้ส่ง
	    $gmail_password = $object_connect['sm_password'];//"pppp99999"; // รหัสผ่าน gmail
	    // ตั้งค่าอนุญาตการใช้งานได้ที่นี่ https://myaccount.google.com/lesssecureapps?pli=1
	    $mail->SMTPOptions = array(
	            'ssl' => array(
	                'verify_peer' => false,
	                'verify_peer_name' => false,
	                'allow_self_signed' => true
	            )
	        );
	     
	    $sender = $object_connect['sm_sender'];//"THAIHEALTH LMS"; // ชื่อผู้ส่ง
	    $email_sender = $object_connect['sm_emailsender'];//"pandora@verztec.com"; // เมล์ผู้ส่ง 
	    $email_receiver = $email; // เมล์ผู้รับ ***
	     	     
	     
	    $mail->Username = $gmail_username;
	    $mail->Password = $gmail_password;
	    $mail->setFrom($email_sender, $sender);
	    $mail->addAddress($email_receiver);
	    $mail->Subject = $subject;
	    if($email_receiver){
	        $mail->msgHTML($message);
	        if (!$mail->send()) {  // สั่งให้ส่ง email
	            // กรณีส่ง email ไม่สำเร็จ
	            //echo "Error_Sentmail";
	            //echo $mail->ErrorInfo; // ข้อความ รายละเอียดการ error
	        }else{
	            // กรณีส่ง email สำเร็จ
	            //echo "Send Success";
	        }   
	    }

	}

?>