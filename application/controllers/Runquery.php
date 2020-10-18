<?php header("Content-Type: text/html; charset=utf-8"); ?>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Runquery extends CI_Controller {

	public function runcourseexpirenoti(){
  		date_default_timezone_set("Asia/Bangkok");
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->func_query->loadDB();
		$lang = "english";

        $fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
   		$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
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
		}

                	$arr_email = array();
		if(count($fetch_courseexp)>0){
			foreach ($fetch_courseexp as $key_courseexp => $value_courseexp) {

              	$date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
              	if($lang!="thai"){
                 	$date = date('d F Y');
              	}
                if($lang=="thai"){ 
                    $cname = $value_courseexp['cname_th']!=""?$value_courseexp['cname_th']:$value_courseexp['cname_eng'];
                }else if($lang=="english"){ 
                    $cname = $value_courseexp['cname_eng']!=""?$value_courseexp['cname_eng']:$value_courseexp['cname_th'];
                }

                	if($value_courseexp['date_start']!="0000-00-00 00:00:00"&&$value_courseexp['date_end']!="0000-00-00 00:00:00"){
			            if($lang=="thai"){
			            $periodstart = $value_courseexp['date_start']!="0000-00-00 00:00:00"?date('d',strtotime($value_courseexp['date_start'])).$thaimonth[intval(date('m',strtotime($value_courseexp['date_start'])))].(date('Y',strtotime($value_courseexp['date_start']))+543)." ".date('H:i',strtotime($value_courseexp['date_start'])):"";
			            $periodend = $value_courseexp['date_end']!="0000-00-00 00:00:00"?date('d',strtotime($value_courseexp['date_end'])).$thaimonth[intval(date('m',strtotime($value_courseexp['date_end'])))].(date('Y',strtotime($value_courseexp['date_end']))+543)." ".date('H:i',strtotime($value_courseexp['date_end'])):"";
			            }else{
			            $periodstart = $value_courseexp['date_start']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($value_courseexp['date_start'])):"";
			            $periodend = $value_courseexp['date_end']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($value_courseexp['date_end'])):"";
			            }
			            
			            if($periodstart!=""&&$periodend!=""){
			              	$period = $periodstart." - ".$periodend;
			            }
		              	$date = date('d ',strtotime($value_courseexp['date_end'])).$thaimonth[intval(date('m',strtotime($value_courseexp['date_end'])))]." ".(date('Y',strtotime($value_courseexp['date_end']))+543);
		              	if($lang!="thai"){
		                 	$date = date('d F Y',strtotime($value_courseexp['date_end']));
		              	}
                	}
					$fetch_chk_position = $this->func_query->query_result('LMS_COS_DETAIL_UG','','','','cosde_id in (select LMS_COS_DETAIL.cosde_id from LMS_COS_DETAIL where cos_id = "'.$value_courseexp['cos_id'].'" and cosde_isDelete="0")');
                	if(count($fetch_chk_position)>0){
		           		$fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="14"');
                		foreach ($fetch_chk_position as $key_chk_position => $value_chk_position) {
						    if(count($fetch_formatmail)>0){
		            		$fetch_userposi = $this->func_query->query_result('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.posi_id="'.$value_chk_position['posi_id'].'" and LMS_USP.u_isDelete="0" and LMS_EMP.emp_isDelete="0"');
		            		if(count($fetch_userposi)>0){
		            			foreach ($fetch_userposi as $key_userposi => $value_userposi) {
		            					$varsend = 0;
		            					$fetch_chkuser = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$value_courseexp['cos_id'].'" and emp_id="'.$value_userposi['emp_id'].'" and cosen_status="1" and cosen_isDelete="0"','cosen_id DESC');
		            					if(count($fetch_chkuser)>0){
		            						if($fetch_chkuser['cosen_status_sub']!="1"){
		            							$varsend = 1;
		            						}
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
							                  $subject_th = str_replace("#coursename",$cname,$subject_th);
							                  $subject_th = str_replace("#link_frontend",base_url()."coursemain/detail/".$value_courseexp['cos_id'],$subject_th);
							                  $subject_th = str_replace("#date",$date,$subject_th);
							                  $subject_th = str_replace("#time",date('H:i'),$subject_th);
							                  $subject_th = str_replace("#perioddate",$period,$subject_th);
							                }
							                if($subject_en!=""){
							                  $subject_en = str_replace("#fullname",$value_userposi['fullname_en'],$subject_en);
							                  $subject_en = str_replace("#username",$value_userposi['useri'],$subject_en);
							                  $subject_en = str_replace("#email",$value_userposi['email'],$subject_en);
							                  $subject_en = str_replace("#coursename",$cname,$subject_en);
							                  $subject_en = str_replace("#link_frontend",base_url()."coursemain/detail/".$value_courseexp['cos_id'],$subject_en);
							                  $subject_en = str_replace("#date",$date,$subject_en);
							                  $subject_en = str_replace("#time",date('H:i'),$subject_en);
							                  $subject_en = str_replace("#perioddate",$period,$subject_en);
							                }
							                if($message_th!=""){
							                  $message_th = str_replace("#fullname",$value_userposi['fullname_th'],$message_th);
							                  $message_th = str_replace("#username",$value_userposi['useri'],$message_th);
							                  $message_th = str_replace("#email",$value_userposi['email'],$message_th);
							                  $message_th = str_replace("#coursename",$cname,$message_th);
							                  $message_th = str_replace("#link_frontend",base_url()."coursemain/detail/".$value_courseexp['cos_id'],$message_th);
							                  $message_th = str_replace("#date",$date,$message_th);
							                  $message_th = str_replace("#time",date('H:i'),$message_th);
							                  $message_th = str_replace("#perioddate",$period,$message_th);
							                }
							                if($message_en!=""){
							                  $message_en = str_replace("#fullname",$value_userposi['fullname_en'],$message_en);
							                  $message_en = str_replace("#username",$value_userposi['useri'],$message_en);
							                  $message_en = str_replace("#email",$value_userposi['email'],$message_en);
							                  $message_en = str_replace("#coursename",$cname,$message_en);
							                  $message_en = str_replace("#link_frontend",base_url()."coursemain/detail/".$value_courseexp['cos_id'],$message_en);
							                  $message_en = str_replace("#date",$date,$message_en);
							                  $message_en = str_replace("#time",date('H:i'),$message_en);
							                  $message_en = str_replace("#perioddate",$period,$message_en);
							                }
							                if($lang == "thai") {
							                $this->db->sendEmail( $value_userposi['email'] , $message_th, $subject_th,$fetch_setmail);
							                } else {
							                $this->db->sendEmail( $value_userposi['email'] , $message_en, $subject_en,$fetch_setmail);
							                }
		            					}
		            			}
		            		}
						    }
                			# code...
                		}
                	}
		            	$fetch_chkuser = $this->func_query->query_result('LMS_COS_ENROLL','','','','cos_id="'.$value_courseexp['cos_id'].'" and cosen_status="1" and cosen_status_sub!="1" and cosen_isDelete="0"','cosen_id DESC');
				        if(count($fetch_chkuser)>0){
				        		foreach ($fetch_chkuser as $key_chkuser => $value_chkuser) {
				            		$fetch_userposi = $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_EMP.emp_id="'.$value_chkuser['emp_id'].'" and LMS_USP.u_isDelete="0" and LMS_EMP.emp_isDelete="0"');
				            		if(count($fetch_userposi)>0&&!in_array($fetch_userposi['email'], $arr_email)){
		            						array_push($arr_email, $value_userposi['email']);
									              	$subject_th = $fetch_formatmail['smf_subject_th'];
									              	$subject_en = $fetch_formatmail['smf_subject_en'];
									              	$message_th = $fetch_formatmail['smf_message_th'];
									              	$message_en = $fetch_formatmail['smf_message_en'];
									                if($subject_th!=""){
									                  $subject_th = str_replace("#fullname",$fetch_userposi['fullname_th'],$subject_th);
									                  $subject_th = str_replace("#username",$fetch_userposi['useri'],$subject_th);
									                  $subject_th = str_replace("#email",$fetch_userposi['email'],$subject_th);
									                  $subject_th = str_replace("#coursename",$cname,$subject_th);
									                  $subject_th = str_replace("#link_frontend",base_url()."coursemain/detail/".$value_courseexp['cos_id'],$subject_th);
									                  $subject_th = str_replace("#date",$date,$subject_th);
									                  $subject_th = str_replace("#time",date('H:i'),$subject_th);
									                  $subject_th = str_replace("#perioddate",$period,$subject_th);
									                }
									                if($subject_en!=""){
									                  $subject_en = str_replace("#fullname",$fetch_userposi['fullname_en'],$subject_en);
									                  $subject_en = str_replace("#username",$fetch_userposi['useri'],$subject_en);
									                  $subject_en = str_replace("#email",$fetch_userposi['email'],$subject_en);
									                  $subject_en = str_replace("#coursename",$cname,$subject_en);
									                  $subject_en = str_replace("#link_frontend",base_url()."coursemain/detail/".$value_courseexp['cos_id'],$subject_en);
									                  $subject_en = str_replace("#date",$date,$subject_en);
									                  $subject_en = str_replace("#time",date('H:i'),$subject_en);
									                  $subject_en = str_replace("#perioddate",$period,$subject_en);
									                }
									                if($message_th!=""){
									                  $message_th = str_replace("#fullname",$fetch_userposi['fullname_th'],$message_th);
									                  $message_th = str_replace("#username",$fetch_userposi['useri'],$message_th);
									                  $message_th = str_replace("#email",$fetch_userposi['email'],$message_th);
									                  $message_th = str_replace("#coursename",$cname,$message_th);
									                  $message_th = str_replace("#link_frontend",base_url()."coursemain/detail/".$value_courseexp['cos_id'],$message_th);
									                  $message_th = str_replace("#date",$date,$message_th);
									                  $message_th = str_replace("#time",date('H:i'),$message_th);
									                  $message_th = str_replace("#perioddate",$period,$message_th);
									                }
									                if($message_en!=""){
									                  $message_en = str_replace("#fullname",$fetch_userposi['fullname_en'],$message_en);
									                  $message_en = str_replace("#username",$fetch_userposi['useri'],$message_en);
									                  $message_en = str_replace("#email",$fetch_userposi['email'],$message_en);
									                  $message_en = str_replace("#coursename",$cname,$message_en);
									                  $message_en = str_replace("#link_frontend",base_url()."coursemain/detail/".$value_courseexp['cos_id'],$message_en);
									                  $message_en = str_replace("#date",$date,$message_en);
									                  $message_en = str_replace("#time",date('H:i'),$message_en);
									                  $message_en = str_replace("#perioddate",$period,$message_en);
									                }
									                if($lang == "thai") {
									                $this->db->sendEmail( $fetch_userposi['email'] , $message_th, $subject_th,$fetch_setmail);
									                } else {
									                $this->db->sendEmail( $fetch_userposi['email'] , $message_en, $subject_en,$fetch_setmail);
									                }
				            		}
				        		}
				        }
                	
			}
		}
	}

	public function runsurveyexpirenoti(){
  		date_default_timezone_set("Asia/Bangkok");
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->func_query->loadDB();
		$lang = "english";
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
   		$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		$fetch_svexp = $this->func_query->query_result('LMS_SV','','','','LMS_SV.sv_approve="1" and LMS_SV.sv_public="1" and LMS_SV.sv_expire_noti>0 and LMS_SV.sv_status="1" and LMS_SV.sv_isDelete="0" and LMS_SV.sv_end!="0000-00-00 00:00:00"');

        $fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
		if(count($fetch_svexp)>0){
			foreach ($fetch_svexp as $key_svexp => $value_svexp) {
				if($value_courseexp['sv_expire_noti']!=""){
					$sv_expire_noti = explode(",",$value_courseexp['sv_expire_noti']);
					$numrechk = 0;
					$numtotal = 0;
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
									unset($fetch_svexp[$key_svexp]);
								}

							}else{
								unset($fetch_svexp[$key_svexp]);
							}
						}
					}
					if($numrechk==0){
						unset($fetch_svexp[$key_svexp]);
					}
				}else{
					unset($fetch_courseexp[$key_svexp]);
				}
			}
		}

        $arr_email = array();
		if(count($fetch_svexp)>0){
			foreach ($fetch_svexp as $key_svexp => $value_svexp) {

              	$date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
              	if($lang!="thai"){
                 	$date = date('d F Y');
              	}
                if($lang=="thai"){ 
                    $sv_title = $value_svexp['sv_title_th']!=""?$value_svexp['sv_title_th']:$value_svexp['sv_title_eng'];
                }else if($lang=="english"){ 
                    $sv_title = $value_svexp['sv_title_eng']!=""?$value_svexp['sv_title_eng']:$value_svexp['sv_title_th'];
                }

                	if($value_svexp['sv_open']!="0000-00-00 00:00:00"&&$value_svexp['sv_end']!="0000-00-00 00:00:00"){
			            if($lang=="thai"){
			            $periodstart = $value_svexp['sv_open']!="0000-00-00 00:00:00"?date('d ',strtotime($value_svexp['sv_open'])).$thaimonth[intval(date('m',strtotime($value_svexp['sv_open'])))]." ".(date('Y',strtotime($value_svexp['sv_open']))+543)." ".date('H:i',strtotime($value_svexp['sv_open'])):"";
			            $periodend = $value_svexp['sv_end']!="0000-00-00 00:00:00"?date('d ',strtotime($value_svexp['sv_end'])).$thaimonth[intval(date('m',strtotime($value_svexp['sv_end'])))]." ".(date('Y',strtotime($value_svexp['sv_end']))+543)." ".date('H:i',strtotime($value_svexp['sv_end'])):"";
			            }else{
			            $periodstart = $value_svexp['sv_open']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($value_svexp['sv_open'])):"";
			            $periodend = $value_svexp['sv_end']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($value_svexp['sv_end'])):"";
			            }
			            
			            if($periodstart!=""&&$periodend!=""){
			              	$period = $periodstart." - ".$periodend;
			            }
		              	$date = date('d ',strtotime($value_svexp['sv_end'])).$thaimonth[intval(date('m',strtotime($value_svexp['sv_end'])))]." ".(date('Y',strtotime($value_svexp['sv_end']))+543);
		              	if($lang!="thai"){
		                 	$date = date('d F Y',strtotime($value_svexp['sv_end']));
		              	}
                	}
					$fetch_chk_position = $this->func_query->query_result('LMS_SV_PM','','','','sv_id = "'.$value_svexp['sv_id'].'"');
                	if(count($fetch_chk_position)>0){
		           		$fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="15"');
                		foreach ($fetch_chk_position as $key_chk_position => $value_chk_position) {
						    if(count($fetch_formatmail)>0){
				            		$fetch_userposi = $this->func_query->query_result('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.posi_id="'.$value_chk_position['posi_id'].'" and LMS_USP.u_isDelete="0" and LMS_EMP.emp_isDelete="0"');
				            		if(count($fetch_userposi)>0){
				            			foreach ($fetch_userposi as $key_userposi => $value_userposi) {
				            					$varsend = 0;
				            					$fetch_chkuser = $this->func_query->query_row('LMS_SV_TC','','','','sv_id="'.$value_svexp['sv_id'].'" and emp_id="'.$value_userposi['emp_id'].'" and svtc_isDelete="0"','svtc_id DESC');
				            					if(count($fetch_chkuser)>0){
				            						if($fetch_chkuser['svtc_finishtime']!="0000-00-00 00:00:00"){
				            							$varsend = 1;
				            						}
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
									                }
									                if($lang == "thai") {
									                $this->db->sendEmail( $value_userposi['email'] , $message_th, $subject_th,$fetch_setmail);
									                } else {
									                $this->db->sendEmail( $value_userposi['email'] , $message_en, $subject_en,$fetch_setmail);
									                }
				            					}
				            			}
				            		}
						    }
                			# code...
                		}
                	}
				        $fetch_chkuser = $this->func_query->query_result('LMS_SV_TC','','','','sv_id="'.$value_svexp['sv_id'].'" and svtc_finishtime="0000-00-00 00:00:00" and svtc_isDelete="0"','svtc_id DESC');
				        if(count($fetch_chkuser)>0){
				        		foreach ($fetch_chkuser as $key_chkuser => $value_chkuser) {
				            		$fetch_userposi = $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_EMP.emp_id="'.$value_chkuser['emp_id'].'" and LMS_USP.u_isDelete="0" and LMS_EMP.emp_isDelete="0"');
				            		if(count($fetch_userposi)>0&&!in_array($fetch_userposi['email'], $arr_email)){
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
									                }
									                if($lang == "thai") {
									                $this->db->sendEmail( $fetch_userposi['email'] , $message_th, $subject_th,$fetch_setmail);
									                } else {
									                $this->db->sendEmail( $fetch_userposi['email'] , $message_en, $subject_en,$fetch_setmail);
									                }
				            		}
				        		}
				        }
			}
		}
	}
}
