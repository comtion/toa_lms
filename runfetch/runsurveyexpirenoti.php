<?php 
include('config_db.php');
//include('../application/controllers/class/class.simple_mail.php');
include('../application/controllers/class/phpmailer/PHPMailerAutoload.php');
date_default_timezone_set("Asia/Bangkok");
$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

$obj_sql = "select * from LMS_SETTING_MAIL where sm_id='1'";
$query_obj = mysqli_query($conndb,$obj_sql);
$fetch_setmail = mysqli_fetch_array($query_obj);

$where = 'LMS_SV.sv_approve="1" and LMS_SV.sv_public="1" and LMS_SV.sv_expire_noti>0 and LMS_SV.sv_status="1" and LMS_SV.sv_isDelete="0" and LMS_SV.sv_end!="0000-00-00 00:00:00"';
$db->where($where);
$fetch_svexp = $db->get('LMS_SV');
$lang = "english";
		if(count($fetch_svexp)>0){
			foreach ($fetch_svexp as $key_svexp => $value_svexp) {
				if($value_courseexp['sv_expire_noti']!=""){
					$sv_expire_noti = explode(",",$value_courseexp['sv_expire_noti']);
					$numrechk = 0;
					$numtotal = 0;
					$num_chk = 0;
					for ($i=0; $i < count($sv_expire_noti); $i++) { 
						$numtotal++;
						if(isset($sv_expire_noti[$i])&&$sv_expire_noti[$i]!=""){
							$numrechk++;
							if(date('Y-m-d')<=date('Y-m-d',strtotime($value_svexp['sv_end']))){
								if($sv_expire_noti[$i]=="0"){
									$date_selectend = date('Y-m-d');
								}else{
									$date_selectend = date('Y-m-d',strtotime($value_svexp['sv_end'].' -'.$sv_expire_noti[$i].'day'));
								}
								$date_now = date('Y-m-d');
								if($date_now!=$date_selectend){
									$num_chk++;
									//unset($fetch_svexp[$key_svexp]);
								}

							}else{
								unset($fetch_svexp[$key_svexp]);
							}
						}
					}
					if($num_chk>=count($cos_expire_noti)){
						unset($fetch_courseexp[$key_courseexp]);
					}
					if($numrechk==0){
						unset($fetch_svexp[$key_svexp]);
					}
				}else{
					unset($fetch_courseexp[$key_svexp]);
				}
			}
		}
		if(count($fetch_svexp)>0){
			foreach ($fetch_svexp as $key_svexp => $value_svexp) {
                	$arr_email = array();
	              	$date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
	              	if($lang!="thai"){
	                 	$date = date('d F Y');
	              	}
	                if($lang=="thai"){ 
	                    $sv_title = $value_svexp['sv_title_th']!=""?$value_svexp['sv_title_th']:$value_svexp['sv_title_eng'];
	                    $sv_title = $sv_title!=""?$sv_title:$value_svexp['sv_title_jp'];
	                }else if($lang=="english"){ 
	                    $sv_title = $value_svexp['sv_title_eng']!=""?$value_svexp['sv_title_eng']:$value_svexp['sv_title_th'];
	                    $sv_title = $sv_title!=""?$sv_title:$value_svexp['sv_title_jp'];
	                }else{
	                    $sv_title = $value_svexp['sv_title_jp']!=""?$value_svexp['sv_title_jp']:$value_svexp['sv_title_eng'];
	                    $sv_title = $sv_title!=""?$sv_title:$value_svexp['sv_title_th'];
	                }

                	$date_end = "";
                	if($value_svexp['sv_open']!="0000-00-00 00:00:00"&&$value_svexp['sv_end']!="0000-00-00 00:00:00"){
			            if($lang=="thai"){
			            $periodstart = $value_svexp['sv_open']!="0000-00-00 00:00:00"?date('d ',strtotime($value_svexp['sv_open'])).$thaimonth[intval(date('m',strtotime($value_svexp['sv_open'])))]." ".(date('Y',strtotime($value_svexp['sv_open']))+543)." ".date('H:i',strtotime($value_svexp['sv_open'])):"";
			            $periodend = $value_svexp['sv_end']!="0000-00-00 00:00:00"?date('d ',strtotime($value_svexp['sv_end'])).$thaimonth[intval(date('m',strtotime($value_svexp['sv_end'])))]." ".(date('Y',strtotime($value_svexp['sv_end']))+543)." ".date('H:i',strtotime($value_svexp['sv_end'])):"";
                		$date_end = $periodend;
			            }else{
			            $periodstart = $value_svexp['sv_open']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($value_svexp['sv_open'])):"";
			            $periodend = $value_svexp['sv_end']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($value_svexp['sv_end'])):"";
                		$date_end = $periodend;
			            }
			            
			            if($periodstart!=""&&$periodend!=""){
			              	$period = $periodstart." - ".$periodend;
			            }
		              	$date = date('d ',strtotime($value_svexp['sv_end'])).$thaimonth[intval(date('m',strtotime($value_svexp['sv_end'])))]." ".(date('Y',strtotime($value_svexp['sv_end']))+543);
		              	if($lang!="thai"){
		                 	$date = date('d F Y',strtotime($value_svexp['sv_end']));
		              	}
                	}

					$where = 'sv_id = "'.$value_svexp['sv_id'].'"';
					$db->where($where);
					$fetch_chk_position = $db->get('LMS_SV_PM');
                	if(count($fetch_chk_position)>0){

						$where = 'smf_show="1" and smf_type="15"';
						$db->where($where);
						$fetch_formatmail = $db->getOne('LMS_SENDMAIL_FORM');
                		foreach ($fetch_chk_position as $key_chk_position => $value_chk_position) {
						    if(count($fetch_formatmail)>0){
								$where = 'LMS_USP.posi_id="'.$value_chk_position['posi_id'].'" and LMS_USP.u_isDelete="0" and LMS_EMP.emp_isDelete="0"';
								$db->where($where);
								$db->join('LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id');
								$fetch_userposi = $db->get('LMS_EMP');
			            		if(count($fetch_userposi)>0){
			            			foreach ($fetch_userposi as $key_userposi => $value_userposi) {
			            					$varsend = 0;
											$where = 'sv_id="'.$value_svexp['sv_id'].'" and emp_id="'.$value_userposi['emp_id'].'" and svtc_isDelete="0"';
											$db->where($where);
											$db->orderBy('svtc_id');
											$fetch_chkuser = $db->getOne('LMS_SV_TC');
			            					if(count($fetch_chkuser)>0){
				            					if($fetch_chkuser['svtc_finishtime']!="0000-00-00 00:00:00"){
				            							$varsend = 1;
				            					}
				            					if($varsend==1&&!in_array($value_userposi['email'], $arr_email)){
		            								array_push($arr_email, $value_userposi['email']);
									              	$subject_th = $fetch_formatmail['smf_subject_th'];
									              	$subject_en = $fetch_formatmail['smf_subject_en'];
									              	$message_th = $fetch_formatmail['smf_message_th'];
									              	$message_en = $fetch_formatmail['smf_message_en'];
									                if($subject_th!=""){
									                  $subject_th = str_replace("#fullname",$value_userposi['fullname_th'],$subject_th);
									                  $subject_th = str_replace("#username",$value_userposi['useri'],$subject_th);
									                  $subject_th = str_replace("#email",$value_userposi['email'],$subject_th);
									                  $subject_th = str_replace("#coursename",$sv_title,$subject_th);
									                  $subject_th = str_replace("#link_frontend",base_url()."survey/surveyDetail/".$value_svexp['sv_id'],$subject_th);
									                  $subject_th = str_replace("#date",$date,$subject_th);
									                  $subject_th = str_replace("#time",date('H:i'),$subject_th);
									                  $subject_th = str_replace("#perioddate",$period,$subject_th);
									                  $subject_th = str_replace("#expiredate",$date_end,$subject_th);
									                }
									                if($subject_en!=""){
									                  $subject_en = str_replace("#fullname",$value_userposi['fullname_en'],$subject_en);
									                  $subject_en = str_replace("#username",$value_userposi['useri'],$subject_en);
									                  $subject_en = str_replace("#email",$value_userposi['email'],$subject_en);
									                  $subject_en = str_replace("#coursename",$sv_title,$subject_en);
									                  $subject_en = str_replace("#link_frontend",base_url()."survey/surveyDetail/".$value_svexp['sv_id'],$subject_en);
									                  $subject_en = str_replace("#date",$date,$subject_en);
									                  $subject_en = str_replace("#time",date('H:i'),$subject_en);
									                  $subject_en = str_replace("#perioddate",$period,$subject_en);
									                  $subject_en = str_replace("#expiredate",$date_end,$subject_en);
									                }
									                if($message_th!=""){
									                  $message_th = str_replace("#fullname",$value_userposi['fullname_th'],$message_th);
									                  $message_th = str_replace("#username",$value_userposi['useri'],$message_th);
									                  $message_th = str_replace("#email",$value_userposi['email'],$message_th);
									                  $message_th = str_replace("#coursename",$sv_title,$message_th);
									                  $message_th = str_replace("#link_frontend",base_url()."survey/surveyDetail/".$value_svexp['sv_id'],$message_th);
									                  $message_th = str_replace("#date",$date,$message_th);
									                  $message_th = str_replace("#time",date('H:i'),$message_th);
									                  $message_th = str_replace("#perioddate",$period,$message_th);
									                  $message_th = str_replace("#expiredate",$date_end,$message_th);
									                }
									                if($message_en!=""){
									                  $message_en = str_replace("#fullname",$value_userposi['fullname_en'],$message_en);
									                  $message_en = str_replace("#username",$value_userposi['useri'],$message_en);
									                  $message_en = str_replace("#email",$value_userposi['email'],$message_en);
									                  $message_en = str_replace("#coursename",$sv_title,$message_en);
									                  $message_en = str_replace("#link_frontend",base_url()."survey/surveyDetail/".$value_svexp['sv_id'],$message_en);
									                  $message_en = str_replace("#date",$date,$message_en);
									                  $message_en = str_replace("#time",date('H:i'),$message_en);
									                  $message_en = str_replace("#perioddate",$period,$message_en);
									                  $message_en = str_replace("#expiredate",$date_end,$message_en);
									                }
									                if($lang == "thai") {
									                sendEmail( $value_userposi['email'] , $message_th, $subject_th,$fetch_setmail);
									                } else {
									                sendEmail( $value_userposi['email'] , $message_en, $subject_en,$fetch_setmail);
									                }
				            					}
			            					}
			            			}
			            		}
			            	}
		            	}
		            }
					
					$where = 'sv_id="'.$value_svexp['sv_id'].'" and svtc_finishtime="0000-00-00 00:00:00" and svtc_isDelete="0"';
					$db->where($where);
					$db->orderBy('svtc_id');
					$fetch_chkuser = $db->get('LMS_SV_TC');

				        if(count($fetch_chkuser)>0){
				        		foreach ($fetch_chkuser as $key_chkuser => $value_chkuser) {
									$where = 'LMS_EMP.emp_id="'.$value_chkuser['emp_id'].'" and LMS_USP.u_isDelete="0" and LMS_EMP.emp_isDelete="0"';
									$db->where($where);
									$db->join('LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id');
									$fetch_userposi = $db->getOne('LMS_EMP');
				            		if(count($fetch_userposi)>0&&!in_array($fetch_userposi['email'], $arr_email)){
				            			echo $fetch_userposi['email'].":::<br>";
		            						array_push($arr_email, $value_userposi['email']);
									              	$subject_th = $fetch_formatmail['smf_subject_th'];
									              	$subject_en = $fetch_formatmail['smf_subject_en'];
									              	$message_th = $fetch_formatmail['smf_message_th'];
									              	$message_en = $fetch_formatmail['smf_message_en'];
									                if($subject_th!=""){
									                  $subject_th = str_replace("#fullname",$fetch_userposi['fullname_th'],$subject_th);
									                  $subject_th = str_replace("#username",$fetch_userposi['useri'],$subject_th);
									                  $subject_th = str_replace("#email",$fetch_userposi['email'],$subject_th);
									                  $subject_th = str_replace("#coursename",$sv_title,$subject_th);
									                  $subject_th = str_replace("#link_frontend",base_url()."survey/surveyDetail/".$value_svexp['sv_id'],$subject_th);
									                  $subject_th = str_replace("#date",$date,$subject_th);
									                  $subject_th = str_replace("#time",date('H:i'),$subject_th);
									                  $subject_th = str_replace("#perioddate",$period,$subject_th);
									                  $subject_th = str_replace("#expiredate",$date_end,$subject_th);
									                }
									                if($subject_en!=""){
									                  $subject_en = str_replace("#fullname",$fetch_userposi['fullname_en'],$subject_en);
									                  $subject_en = str_replace("#username",$fetch_userposi['useri'],$subject_en);
									                  $subject_en = str_replace("#email",$fetch_userposi['email'],$subject_en);
									                  $subject_en = str_replace("#coursename",$sv_title,$subject_en);
									                  $subject_en = str_replace("#link_frontend",base_url()."survey/surveyDetail/".$value_svexp['sv_id'],$subject_en);
									                  $subject_en = str_replace("#date",$date,$subject_en);
									                  $subject_en = str_replace("#time",date('H:i'),$subject_en);
									                  $subject_en = str_replace("#perioddate",$period,$subject_en);
									                  $subject_en = str_replace("#expiredate",$date_end,$subject_en);
									                }
									                if($message_th!=""){
									                  $message_th = str_replace("#fullname",$fetch_userposi['fullname_th'],$message_th);
									                  $message_th = str_replace("#username",$fetch_userposi['useri'],$message_th);
									                  $message_th = str_replace("#email",$fetch_userposi['email'],$message_th);
									                  $message_th = str_replace("#coursename",$sv_title,$message_th);
									                  $message_th = str_replace("#link_frontend",base_url()."survey/surveyDetail/".$value_svexp['sv_id'],$message_th);
									                  $message_th = str_replace("#date",$date,$message_th);
									                  $message_th = str_replace("#time",date('H:i'),$message_th);
									                  $message_th = str_replace("#perioddate",$period,$message_th);
									                  $message_th = str_replace("#expiredate",$date_end,$message_th);
									                }
									                if($message_en!=""){
									                  $message_en = str_replace("#fullname",$fetch_userposi['fullname_en'],$message_en);
									                  $message_en = str_replace("#username",$fetch_userposi['useri'],$message_en);
									                  $message_en = str_replace("#email",$fetch_userposi['email'],$message_en);
									                  $message_en = str_replace("#coursename",$sv_title,$message_en);
									                  $message_en = str_replace("#link_frontend",base_url()."survey/surveyDetail/".$value_svexp['sv_id'],$message_en);
									                  $message_en = str_replace("#date",$date,$message_en);
									                  $message_en = str_replace("#time",date('H:i'),$message_en);
									                  $message_en = str_replace("#perioddate",$period,$message_en);
									                  $message_en = str_replace("#expiredate",$date_end,$message_en);
									                }
									                if($lang == "thai") {
									                sendEmail( $fetch_userposi['email'] , $message_th, $subject_th,$fetch_setmail);
									                } else {
									                sendEmail( $fetch_userposi['email'] , $message_en, $subject_en,$fetch_setmail);
									                }
				            		}
				        		}
				        }
                	
			}
		}
/*$sql_courseexp = 'select * from LMS_COS inner join LMS_COS_DETAIL on LMS_COS_DETAIL.cos_id = LMS_COS.cos_id where cos_approve="1" and cos_public="1" and cos_expire_noti!="" and cos_status="1" and cos_isDelete="0" and LMS_COS_DETAIL.date_end!="0000-00-00 00:00:00"';
$query_courseexp = mysqli_query($conndb,$sql_courseexp);

while ($value_courseexp = mysqli_fetch_array($query_courseexp)) {
	# code...
}
		$fetch_svexp = $this->func_query->query_result('LMS_COS','LMS_COS_DETAIL','LMS_COS_DETAIL.cos_id = LMS_COS.cos_id','','cos_approve="1" and cos_public="1" and cos_expire_noti!="" and cos_status="1" and cos_isDelete="0" and LMS_COS_DETAIL.date_end!="0000-00-00 00:00:00"');

		if(count($fetch_svexp)>0){
			foreach ($fetch_svexp as $key_courseexp => $value_courseexp) {
				if($value_courseexp['cos_expire_noti']!=""){
					$cos_expire_noti = explode(",",$value_courseexp['cos_expire_noti']);
					$numrechk = 0;
					$numtotal = 0;
					for ($i=0; $i < count($cos_expire_noti); $i++) { 
						$numtotal++;
						if(isset($cos_expire_noti[$i])&&$cos_expire_noti[$i]!=""&&$cos_expire_noti[$i]!="0"){
							$numrechk++;
							if(date('Y-m-d')<=date('Y-m-d',strtotime($value_courseexp['date_end']))){
								if($cos_expire_noti[$i]=="0"){
									$date_selectend = date('Y-m-d');
								}else{
									$date_selectend = date('Y-m-d',strtotime($value_courseexp['date_end'].' -'.$cos_expire_noti[$i].'day'));
								}
								$date_now = date('Y-m-d');
								if($date_now!=$date_selectend){
									unset($fetch_svexp[$key_courseexp]);
								}
							}else{
								unset($fetch_svexp[$key_courseexp]);
							}
						}
					}
					if($numrechk==0){
						unset($fetch_svexp[$key_courseexp]);
					}
				}else{
					unset($fetch_svexp[$key_courseexp]);
				}
			}
		}*/


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