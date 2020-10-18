<?php 
include('config_db.php');
//include('../application/controllers/class/class.simple_mail.php');
include('../application/controllers/class/phpmailer/PHPMailerAutoload.php');
date_default_timezone_set("Asia/Bangkok");
$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

$obj_sql = "select * from LMS_SETTING_MAIL where sm_id='1'";
$query_obj = mysqli_query($conndb,$obj_sql);
$object_connect = mysqli_fetch_array($query_obj);

$where = 'cos_approve="1" and cos_public="1" and cos_expire_noti!="" and cos_status="1" and cos_isDelete="0" and LMS_COS_DETAIL.date_end!="0000-00-00 00:00:00"';
$db->where($where);
$db->join('LMS_COS_DETAIL','LMS_COS_DETAIL.cos_id = LMS_COS.cos_id');
$fetch_courseexp = $db->get('LMS_COS');
$lang = "english";
if(count($fetch_courseexp)>0){
			foreach ($fetch_courseexp as $key_courseexp => $value_courseexp) {
				if($value_courseexp['cos_expire_noti']!=""){
					$cos_expire_noti = explode(",",$value_courseexp['cos_expire_noti']);
					$numrechk = 0;
					$numtotal = 0;
					$num_chk = 0;
					for ($i=0; $i < count($cos_expire_noti); $i++) { 
						$numtotal++;
						if(isset($cos_expire_noti[$i])&&$cos_expire_noti[$i]!=""){
							$numrechk++;
							if(date('Y-m-d')<=date('Y-m-d',strtotime($value_courseexp['date_end']))){
								if($cos_expire_noti[$i]=="0"){
									$date_selectend = date('Y-m-d');
								}else{
									$date_selectend = date('Y-m-d',strtotime($value_courseexp['date_end'].' -'.$cos_expire_noti[$i].'day'));
								}
								$date_now = date('Y-m-d');
								//echo $date_now.":::".$date_selectend."<br>";
								if($date_now!=$date_selectend){
									$num_chk++;
									//unset($fetch_courseexp[$key_courseexp]);
								}
							}else{
								unset($fetch_courseexp[$key_courseexp]);
							}
						}
					}
					if($num_chk>=count($cos_expire_noti)){
						unset($fetch_courseexp[$key_courseexp]);
					}
					if($numrechk==0){
						unset($fetch_courseexp[$key_courseexp]);
					}
				}else{
					unset($fetch_courseexp[$key_courseexp]);
				}
			}
		}
		//print_r($fetch_courseexp);
		if(count($fetch_courseexp)>0){
			foreach ($fetch_courseexp as $key_courseexp => $value_courseexp) {
				
                	$arr_email = array();
                	$arr_emailmanager = array();
              	$date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
              	if($lang!="thai"){
                 	$date = date('d F Y');
              	}
                if($lang=="thai"){ 
                    $cname = $value_courseexp['cname_th']!=""?$value_courseexp['cname_th']:$value_courseexp['cname_eng'];
                    $cname = $cname!=""?$cname:$value_courseexp['cname_jp'];
                }else if($lang=="english"){ 
                    $cname = $value_courseexp['cname_eng']!=""?$value_courseexp['cname_eng']:$value_courseexp['cname_th'];
                    $cname = $cname!=""?$cname:$value_courseexp['cname_jp'];
                }else{
                    $cname = $value_courseexp['cname_jp']!=""?$value_courseexp['cname_jp']:$value_courseexp['cname_eng'];
                    $cname = $cname!=""?$cname:$value_courseexp['cname_th'];
                }
                echo $cname."<br>";
                $date_end = "";
                	if($value_courseexp['date_start']!="0000-00-00 00:00:00"&&$value_courseexp['date_end']!="0000-00-00 00:00:00"){
			            if($lang=="thai"){
			            $periodstart = $value_courseexp['date_start']!="0000-00-00 00:00:00"?date('d ',strtotime($value_courseexp['date_start'])).$thaimonth[intval(date('m',strtotime($value_courseexp['date_start'])))]." ".(date('Y',strtotime($value_courseexp['date_start']))+543)." ".date('H:i',strtotime($value_courseexp['date_start'])):"";
			            $periodend = $value_courseexp['date_end']!="0000-00-00 00:00:00"?date('d ',strtotime($value_courseexp['date_end'])).$thaimonth[intval(date('m',strtotime($value_courseexp['date_end'])))]." ".(date('Y',strtotime($value_courseexp['date_end']))+543)." ".date('H:i',strtotime($value_courseexp['date_end'])):"";
                		$date_end = $periodend;
			            }else{
			            $periodstart = $value_courseexp['date_start']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($value_courseexp['date_start'])):"";
			            $periodend = $value_courseexp['date_end']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($value_courseexp['date_end'])):"";
                		$date_end = $periodend;
			            }
			            
			            if($periodstart!=""&&$periodend!=""){
			              	$period = $periodstart." - ".$periodend;
			            }
		              	$date = date('d ',strtotime($value_courseexp['date_end'])).$thaimonth[intval(date('m',strtotime($value_courseexp['date_end'])))]." ".(date('Y',strtotime($value_courseexp['date_end']))+543);
		              	if($lang!="thai"){
		                 	$date = date('d F Y',strtotime($value_courseexp['date_end']));
		              	}
                	}

					$where = 'cosde_id in (select LMS_COS_DETAIL.cosde_id from LMS_COS_DETAIL where cos_id = "'.$value_courseexp['cos_id'].'" and cosde_isDelete="0")';
					$db->where($where);
					$fetch_chk_position = $db->get('LMS_COS_DETAIL_UG');
                	if(count($fetch_chk_position)>0){

						$where = 'smf_show="1" and smf_type="14"';
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
											$where = 'cos_id="'.$value_courseexp['cos_id'].'" and emp_id="'.$value_userposi['emp_id'].'" and cosen_status="1" and cosen_isDelete="0"';
											$db->where($where);
											$db->orderBy('cosen_id');
											$fetch_chkuser = $db->getOne('LMS_COS_ENROLL');
			            					if(count($fetch_chkuser)>0){
			            						if($fetch_chkuser['cosen_status_sub']!="1"){
			            							$varsend = 1;
			            						}
				            					if($varsend==1&&!in_array($value_userposi['email'], $arr_email)){
				            						echo $value_userposi['email'].":::<br>";
				            						array_push($arr_email, $value_userposi['email']);
				            						if($value_userposi['emp_manage_a']!=""&&$value_userposi['emp_manage_a']!=$value_userposi['email']){
				            							if(isset($arr_emailmanager[$value_userposi['emp_manage_a']])){
				            								array_push($arr_emailmanager[$value_userposi['emp_manage_a']], $value_userposi['email']);
				            							}else{
				            								$arr_emailmanager[$value_userposi['emp_manage_a']] = array();
				            								array_push($arr_emailmanager[$value_userposi['emp_manage_a']], $value_userposi['email']);
				            							}
				            						}
				            						if($value_userposi['emp_manage_b']!=""&&$value_userposi['emp_manage_b']!=$value_userposi['email']){
				            							if(isset($arr_emailmanager[$value_userposi['emp_manage_b']])){
				            								array_push($arr_emailmanager[$value_userposi['emp_manage_b']], $value_userposi['email']);
				            							}else{
				            								$arr_emailmanager[$value_userposi['emp_manage_b']] = array();
				            								array_push($arr_emailmanager[$value_userposi['emp_manage_b']], $value_userposi['email']);
				            							}
				            						}
									              	$subject_th = $fetch_formatmail['smf_subject_th'];
									              	$subject_en = $fetch_formatmail['smf_subject_en'];
									              	$message_th = $fetch_formatmail['smf_message_th'];
									              	$message_en = $fetch_formatmail['smf_message_en'];
									                if($subject_th!=""){
									                  $subject_th = str_replace("#fullname",$value_userposi['fullname_th'],$subject_th);
									                  $subject_th = str_replace("#username",$value_userposi['useri'],$subject_th);
									                  $subject_th = str_replace("#email",$value_userposi['email'],$subject_th);
									                  $subject_th = str_replace("#coursename",$cname,$subject_th);
									                  $subject_th = str_replace("#link_frontend","https://elearning.isuzu.co.th/coursemain/detail/".$value_courseexp['cos_id'],$subject_th);
									                  $subject_th = str_replace("#date",$date,$subject_th);
									                  $subject_th = str_replace("#time",date('H:i'),$subject_th);
									                  $subject_th = str_replace("#perioddate",$period,$subject_th);
									                  $subject_th = str_replace("#expiredate",$date_end,$subject_th);
									                }
									                if($subject_en!=""){
									                  $subject_en = str_replace("#fullname",$value_userposi['fullname_en'],$subject_en);
									                  $subject_en = str_replace("#username",$value_userposi['useri'],$subject_en);
									                  $subject_en = str_replace("#email",$value_userposi['email'],$subject_en);
									                  $subject_en = str_replace("#coursename",$cname,$subject_en);
									                  $subject_en = str_replace("#link_frontend","https://elearning.isuzu.co.th/coursemain/detail/".$value_courseexp['cos_id'],$subject_en);
									                  $subject_en = str_replace("#date",$date,$subject_en);
									                  $subject_en = str_replace("#time",date('H:i'),$subject_en);
									                  $subject_en = str_replace("#perioddate",$period,$subject_en);
									                  $subject_en = str_replace("#expiredate",$date_end,$subject_en);
									                }
									                if($message_th!=""){
									                  $message_th = str_replace("#fullname",$value_userposi['fullname_th'],$message_th);
									                  $message_th = str_replace("#username",$value_userposi['useri'],$message_th);
									                  $message_th = str_replace("#email",$value_userposi['email'],$message_th);
									                  $message_th = str_replace("#coursename",$cname,$message_th);
									                  $message_th = str_replace("#link_frontend","https://elearning.isuzu.co.th/coursemain/detail/".$value_courseexp['cos_id'],$message_th);
									                  $message_th = str_replace("#date",$date,$message_th);
									                  $message_th = str_replace("#time",date('H:i'),$message_th);
									                  $message_th = str_replace("#perioddate",$period,$message_th);
									                  $message_th = str_replace("#expiredate",$date_end,$message_th);
									                }
									                if($message_en!=""){
									                  $message_en = str_replace("#fullname",$value_userposi['fullname_en'],$message_en);
									                  $message_en = str_replace("#username",$value_userposi['useri'],$message_en);
									                  $message_en = str_replace("#email",$value_userposi['email'],$message_en);
									                  $message_en = str_replace("#coursename",$cname,$message_en);
									                  $message_en = str_replace("#link_frontend","https://elearning.isuzu.co.th/coursemain/detail/".$value_courseexp['cos_id'],$message_en);
									                  $message_en = str_replace("#date",$date,$message_en);
									                  $message_en = str_replace("#time",date('H:i'),$message_en);
									                  $message_en = str_replace("#perioddate",$period,$message_en);
									                  $message_en = str_replace("#expiredate",$date_end,$message_en);
									                }
									                if($lang == "thai") {
									                sendEmail( $value_userposi['email'] , $message_th, $subject_th,$object_connect);
									                } else {
									                sendEmail( $value_userposi['email'] , $message_en, $subject_en,$object_connect);
									                }
				            					}
			            					}
			            			}
			            		}
			            	}
		            	}
		            }

					$where = 'cos_id="'.$value_courseexp['cos_id'].'" and cosen_status="1" and cosen_status_sub!="1" and cosen_isDelete="0"';
					$db->where($where);
					$db->orderBy('cosen_id');
					$fetch_chkuser = $db->get('LMS_COS_ENROLL');
					//print_r($fetch_chkuser);
				        if(count($fetch_chkuser)>0){
				        		foreach ($fetch_chkuser as $key_chkuser => $value_chkuser) {
				        			//echo $value_chkuser['emp_id']."::";
									$where_if = 'LMS_EMP.emp_id="'.$value_chkuser['emp_id'].'" and LMS_USP.u_isDelete="0" and LMS_EMP.emp_isDelete="0"';
									$db->where($where_if);
									$db->join('LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id');
									$fetch_userposi = $db->getOne('LMS_EMP');
				            		if(count($fetch_userposi)>0&&!in_array($fetch_userposi['email'], $arr_email)){
									//print_r($fetch_userposi['email']);
				            			echo $fetch_userposi['email'].":::<br>";
		            						array_push($arr_email, $fetch_userposi['email']);
		            						if($fetch_userposi['emp_manage_a']!=""&&$fetch_userposi['emp_manage_a']!=$fetch_userposi['email']){
		            							if(isset($arr_emailmanager[$fetch_userposi['emp_manage_a']])){
		            								array_push($arr_emailmanager[$fetch_userposi['emp_manage_a']], $fetch_userposi['email']);
		            							}else{
		            								$arr_emailmanager[$fetch_userposi['emp_manage_a']] = array();
		            								array_push($arr_emailmanager[$fetch_userposi['emp_manage_a']], $fetch_userposi['email']);
		            							}
		            						}
		            						if($fetch_userposi['emp_manage_b']!=""&&$fetch_userposi['emp_manage_b']!=$fetch_userposi['email']){
		            							if(isset($arr_emailmanager[$fetch_userposi['emp_manage_b']])){
		            								array_push($arr_emailmanager[$fetch_userposi['emp_manage_b']], $fetch_userposi['email']);
		            							}else{
		            								$arr_emailmanager[$fetch_userposi['emp_manage_b']] = array();
		            								array_push($arr_emailmanager[$fetch_userposi['emp_manage_b']], $fetch_userposi['email']);
		            							}
		            						}
		            						//echo $value_userposi['email']."::";
									              	$subject_th = $fetch_formatmail['smf_subject_th'];
									              	$subject_en = $fetch_formatmail['smf_subject_en'];
									              	$message_th = $fetch_formatmail['smf_message_th'];
									              	$message_en = $fetch_formatmail['smf_message_en'];
									                if($subject_th!=""){
									                  $subject_th = str_replace("#fullname",$fetch_userposi['fullname_th'],$subject_th);
									                  $subject_th = str_replace("#username",$fetch_userposi['useri'],$subject_th);
									                  $subject_th = str_replace("#email",$fetch_userposi['email'],$subject_th);
									                  $subject_th = str_replace("#coursename",$cname,$subject_th);
									                  $subject_th = str_replace("#link_frontend","https://elearning.isuzu.co.th/coursemain/detail/".$value_courseexp['cos_id'],$subject_th);
									                  $subject_th = str_replace("#date",$date,$subject_th);
									                  $subject_th = str_replace("#time",date('H:i'),$subject_th);
									                  $subject_th = str_replace("#perioddate",$period,$subject_th);
									                  $subject_th = str_replace("#expiredate",$date_end,$subject_th);
									                }
									                if($subject_en!=""){
									                  $subject_en = str_replace("#fullname",$fetch_userposi['fullname_en'],$subject_en);
									                  $subject_en = str_replace("#username",$fetch_userposi['useri'],$subject_en);
									                  $subject_en = str_replace("#email",$fetch_userposi['email'],$subject_en);
									                  $subject_en = str_replace("#coursename",$cname,$subject_en);
									                  $subject_en = str_replace("#link_frontend","https://elearning.isuzu.co.th/coursemain/detail/".$value_courseexp['cos_id'],$subject_en);
									                  $subject_en = str_replace("#date",$date,$subject_en);
									                  $subject_en = str_replace("#time",date('H:i'),$subject_en);
									                  $subject_en = str_replace("#perioddate",$period,$subject_en);
									                  $subject_en = str_replace("#expiredate",$date_end,$subject_en);
									                }
									                if($message_th!=""){
									                  $message_th = str_replace("#fullname",$fetch_userposi['fullname_th'],$message_th);
									                  $message_th = str_replace("#username",$fetch_userposi['useri'],$message_th);
									                  $message_th = str_replace("#email",$fetch_userposi['email'],$message_th);
									                  $message_th = str_replace("#coursename",$cname,$message_th);
									                  $message_th = str_replace("#link_frontend","https://elearning.isuzu.co.th/coursemain/detail/".$value_courseexp['cos_id'],$message_th);
									                  $message_th = str_replace("#date",$date,$message_th);
									                  $message_th = str_replace("#time",date('H:i'),$message_th);
									                  $message_th = str_replace("#perioddate",$period,$message_th);
									                  $message_th = str_replace("#expiredate",$date_end,$message_th);
									                }
									                if($message_en!=""){
									                  $message_en = str_replace("#fullname",$fetch_userposi['fullname_en'],$message_en);
									                  $message_en = str_replace("#username",$fetch_userposi['useri'],$message_en);
									                  $message_en = str_replace("#email",$fetch_userposi['email'],$message_en);
									                  $message_en = str_replace("#coursename",$cname,$message_en);
									                  $message_en = str_replace("#link_frontend","https://elearning.isuzu.co.th/coursemain/detail/".$value_courseexp['cos_id'],$message_en);
									                  $message_en = str_replace("#date",$date,$message_en);
									                  $message_en = str_replace("#time",date('H:i'),$message_en);
									                  $message_en = str_replace("#perioddate",$period,$message_en);
									                  $message_en = str_replace("#expiredate",$date_end,$message_en);
									                }
									                if($lang == "thai") {
									                sendEmail( $fetch_userposi['email'] , $message_th, $subject_th,$object_connect);
									                } else {
									                sendEmail( $fetch_userposi['email'] , $message_en, $subject_en,$object_connect);
									                }
				            		}
				        		}
				        }

				        if(count($arr_emailmanager)>0){
	                		foreach ($arr_emailmanager as $key_manager => $value_manager) {
				        		$list_emp = "";
	                			if(count($value_manager)>0){
				        		$list_emp = "<ol>";
	                				for ($i=0; $i < count($value_manager); $i++) { 
										$where_if = 'LMS_EMP.emp_c="'.$value_manager[$i].'" and LMS_USP.u_isDelete="0" and LMS_EMP.emp_isDelete="0"';
										$db->where($where_if);
										$db->join('LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id');
										$fetch_emp = $db->getOne('LMS_EMP');
										if(count($fetch_emp)>0){
											if($lang=="thai"){
												$list_emp .= "<li>".$fetch_emp['fullname_th']."</li>";
											}else{
												$list_emp .= "<li>".$fetch_emp['fullname_en']."</li>";
											}
										}
	                				}
		                		$list_emp .= "</ol>";
	                			}
								$where_if = 'LMS_EMP.emp_c="'.$key_manager.'" and LMS_USP.u_isDelete="0" and LMS_EMP.emp_isDelete="0"';
								$db->where($where_if);
								$db->join('LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id');
								$fetch_manager = $db->getOne('LMS_EMP');
								if(count($fetch_manager)>0&&$list_emp!=""){
									$value_message = "";
			                		if($lang=="thai"){
			                			$value_message .= "เรียน ".$fetch_manager['fullname_th']."<br><br>";
			                			$value_message .= "หลักสูตร ".$cname." กำลังจะหมดอายุ<br>";
			                			$value_message .= "ระยะเวลาของหลักสูตร: ".$period."<br>";
			                			$value_message .= "รายชื่อพนักงานภายใต้การดูแลของท่านที่ยังเรียนไม่จบ มีดังนี้<br><br>";
			                			$value_message .= $list_emp;
									    sendEmail( $fetch_manager['email'] , $value_message, $subject_th,$object_connect);
			                		}else{
			                			$value_message .= "Dear ".$fetch_manager['fullname_en']."<br><br>";
			                			$value_message .= "Course: ".$cname."is about to close.<br>";
			                			$value_message .= "Course period: ".$period."<br>";
			                			$value_message .= "Followings are the list of employees under your supervision who haven’t completed the course:<br><br>";
			                			$value_message .= $list_emp;
									    sendEmail( $fetch_manager['email'] , $value_message, $subject_en,$object_connect);
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
		$fetch_courseexp = $this->func_query->query_result('LMS_COS','LMS_COS_DETAIL','LMS_COS_DETAIL.cos_id = LMS_COS.cos_id','','cos_approve="1" and cos_public="1" and cos_expire_noti!="" and cos_status="1" and cos_isDelete="0" and LMS_COS_DETAIL.date_end!="0000-00-00 00:00:00"');

		if(count($fetch_courseexp)>0){
			foreach ($fetch_courseexp as $key_courseexp => $value_courseexp) {
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
									unset($fetch_courseexp[$key_courseexp]);
								}
							}else{
								unset($fetch_courseexp[$key_courseexp]);
							}
						}
					}
					if($numrechk==0){
						unset($fetch_courseexp[$key_courseexp]);
					}
				}else{
					unset($fetch_courseexp[$key_courseexp]);
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
/*function sendEmail($email, $message, $subject, $object_connect) {
		$sub = "ข้อความจากเว็บไซต์";

		$mail = new SimpleMail();

	    $sender = $object_connect['sm_sender'];//"THAIHEALTH LMS"; // ชื่อผู้ส่ง
	    $email_sender = $object_connect['sm_emailsender'];//"pandora@verztec.com"; // เมล์ผู้ส่ง 
	    $email_receiver = $email; // เมล์ผู้รับ ***
    if(!empty($email)) {
	    $mail->setFrom($email_sender, $sender);
  		$mail->setTo($email,'')
  			->setSubject($subject)
  			->addGenericHeader('MIME-Version', '1.0')
  			->addGenericHeader('Content-Type', 'text/html; charset="utf-8"')
  			->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
  			->setMessage($message);
  		$mail->send();
      $GLOBALS['z'][] = $email;
    }
}*/

?>