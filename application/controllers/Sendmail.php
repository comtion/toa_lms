<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sendmail extends CI_Controller {



	public function sentmail_cosuser_single(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
	    date_default_timezone_set("Asia/Bangkok");
	    $sess = $this->session->userdata("user");
   		$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			//print_r($_REQUEST);
   		$status_save = "";
   		$output = array();
		if(count($_REQUEST)>0){
			$cosen_id = isset($_REQUEST['cosen_id'])?$_REQUEST['cosen_id']:"";	
			if($cosen_id!=""){
				$fetch_cosen = $this->func_query->query_row('LMS_COS_ENROLL','LMS_COS','LMS_COS_ENROLL.cos_id = LMS_COS.cos_id','','LMS_COS_ENROLL.cosen_id = "'.$cosen_id.'" and LMS_COS_ENROLL.cosen_status_sub != "1" and LMS_COS.cos_isDelete = "0" and LMS_COS.cos_public = "1"');
				if(count($fetch_cosen)>0){
	                $fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
	                $date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
	                if($lang!="thai"){
	                  $date = date('d F Y');
	                }
					$cos_lang = explode(',', $fetch_cosen['cos_lang']);
                    $fetch_cosen['isTH'] = in_array('th',$cos_lang)?"1":"0";
                    $fetch_cosen['isENG'] = in_array('eng',$cos_lang)?"1":"0";
                    $cname = "";
                    if($lang=="thai"){
                        if($fetch_cosen['isTH']=="1"){
                          $cname = $fetch_cosen['cname_th'];
                        }else{
                          if($cname==""){
                            $cname = $fetch_cosen['cname_eng'];
                          }
                        }
                    }else{
                        if($fetch_cosen['isENG']=="1"){
                          $cname = $fetch_cosen['cname_eng'];
                        }else{
                          if($cname==""){
                            $cname = $fetch_cosen['cname_th'];
                          }
                        }
                    }
                	$date_end = "-";
                    $period = "Unlimited time";//label('UnlimitedTime');
	                $fetch_cos_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id="'.$fetch_cosen['cos_id'].'" and cosde_status="1" and cosde_isDelete="0"');
	                if(count($fetch_cos_detail)>0){
	                  if($fetch_cos_detail['date_start']!="0000-00-00 00:00:00"&&$fetch_cos_detail['date_end']!="0000-00-00 00:00:00"){
		                  if($lang=="thai"){
		                  $periodstart = $fetch_cos_detail['date_start']!="0000-00-00 00:00:00"?date('d ',strtotime($fetch_cos_detail['date_start'])).$thaimonth[intval(date('m',strtotime($fetch_cos_detail['date_start'])))]." ".(date('Y',strtotime($fetch_cos_detail['date_start']))+543)." ".date('H:i',strtotime($fetch_cos_detail['date_start'])):"";
		                  $periodend = $fetch_cos_detail['date_end']!="0000-00-00 00:00:00"?date('d ',strtotime($fetch_cos_detail['date_end'])).$thaimonth[intval(date('m',strtotime($fetch_cos_detail['date_end'])))]." ".(date('Y',strtotime($fetch_cos_detail['date_end']))+543)." ".date('H:i',strtotime($fetch_cos_detail['date_end'])):"";
                		  $date_end = $periodend;
		                  }else{
		                  $periodstart = $fetch_cos_detail['date_start']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($fetch_cos_detail['date_start'])):"";
		                  $periodend = $fetch_cos_detail['date_end']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($fetch_cos_detail['date_end'])):"";
                		  $date_end = $periodend;
		                  }
		                  $periodstart = $fetch_cos_detail['date_start']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($fetch_cos_detail['date_start'])):"";
		                  $periodend = $fetch_cos_detail['date_end']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($fetch_cos_detail['date_end'])):"";
                		  $date_end = $periodend;
		                  
		                  if($periodstart!=""&&$periodend!=""){
		                      $period = $periodstart." - ".$periodend;
		                  }
	                  }
	                }
	                $fetch_user = $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.emp_id="'.$fetch_cosen['emp_id'].'" and LMS_USP.u_isDelete="0" and LMS_EMP.emp_isDelete="0" and (LMS_USP.inactivedate > "'.date('Y-m-d H:i').'" or LMS_USP.inactivedate = "0000-00-00")');
	                $fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="14"');
	                if(count($fetch_formatmail)>0&&count($fetch_user)>0){
		                $fetch_company = $this->func_query->query_row('LMS_COMPANY','','','','com_id="'.$fetch_user['com_id'].'"');
		                $subject_th = $fetch_formatmail['smf_subject_th'];
		                $subject_en = $fetch_formatmail['smf_subject_en'];
		                $message_th = $fetch_formatmail['smf_message_th'];
		                $message_en = $fetch_formatmail['smf_message_en'];
		                $cos_hour = intval($fetch_cosen['cos_hour'])>0?$fetch_cosen['cos_hour']:"No information";
	                    if($subject_th!=""){
	                      $subject_th = str_replace("#fullname",$fetch_user['fullname_th'],$subject_th);
	                      $subject_th = str_replace("#username",$fetch_user['useri'],$subject_th);
	                      $subject_th = str_replace("#email",$fetch_user['email'],$subject_th);
	                      $subject_th = str_replace("#coursename",$cname,$subject_th);
	                      $subject_th = str_replace("#link_frontend",base_url()."coursemain/detail/".$fetch_cosen['cos_id'],$subject_th);
	                      $subject_th = str_replace("#date",$date,$subject_th);
	                      $subject_th = str_replace("#time",date('H:i'),$subject_th);
	                      $subject_th = str_replace("#perioddate",$period,$subject_th);
	                      $subject_th = str_replace("#durationofstudy",$cos_hour,$subject_th);
	                      $subject_th = str_replace("#companyname",$fetch_company['com_code'],$subject_th);
	                      $subject_th = str_replace("#expiredate",$date_end,$subject_th);
	                    }
	                    if($subject_en!=""){
	                      $subject_en = str_replace("#fullname",$fetch_user['fullname_en'],$subject_en);
	                      $subject_en = str_replace("#username",$fetch_user['useri'],$subject_en);
	                      $subject_en = str_replace("#email",$fetch_user['email'],$subject_en);
	                      $subject_en = str_replace("#coursename",$cname,$subject_en);
	                      $subject_en = str_replace("#link_frontend",base_url()."coursemain/detail/".$fetch_cosen['cos_id'],$subject_en);
	                      $subject_en = str_replace("#date",$date,$subject_en);
	                      $subject_en = str_replace("#time",date('H:i'),$subject_en);
	                      $subject_en = str_replace("#perioddate",$period,$subject_en);
	                      $subject_en = str_replace("#durationofstudy",$cos_hour,$subject_en);
	                      $subject_en = str_replace("#companyname",$fetch_company['com_code'],$subject_en);
	                      $subject_en = str_replace("#expiredate",$date_end,$subject_en);
	                    }
	                      if(isset($fetch_formatmail['smf_importimage'])&&$fetch_formatmail['smf_importimage']!=""){
	                          $img_val = '<img src="'.base_url().'/uploads/formatmail_img/'.$fetch_formatmail['smf_importimage'].'" style="max-width:800px">';
	                      }else{
	                          $img_val = '';
	                      }
	                    if($message_th!=""){
	                      $message_th = str_replace("#fullname",$fetch_user['fullname_th'],$message_th);
	                      $message_th = str_replace("#username",$fetch_user['useri'],$message_th);
	                      $message_th = str_replace("#email",$fetch_user['email'],$message_th);
	                      $message_th = str_replace("#coursename",$cname,$message_th);
	                      $message_th = str_replace("#link_frontend",base_url()."coursemain/detail/".$fetch_cosen['cos_id'],$message_th);
	                      $message_th = str_replace("#date",$date,$message_th);
	                      $message_th = str_replace("#time",date('H:i'),$message_th);
	                      $message_th = str_replace("#perioddate",$period,$message_th);
	                      $message_th = str_replace("#image",$img_val,$message_th);
	                      $message_th = str_replace("#durationofstudy",$cos_hour,$message_th);
	                      $message_th = str_replace("#companyname",$fetch_company['com_code'],$message_th);
	                      $message_th = str_replace("#expiredate",$date_end,$message_th);
	                    }
	                    if($message_en!=""){
	                      $message_en = str_replace("#fullname",$fetch_user['fullname_en'],$message_en);
	                      $message_en = str_replace("#username",$fetch_user['useri'],$message_en);
	                      $message_en = str_replace("#email",$fetch_user['email'],$message_en);
	                      $message_en = str_replace("#coursename",$cname,$message_en);
	                      $message_en = str_replace("#link_frontend",base_url()."coursemain/detail/".$fetch_cosen['cos_id'],$message_en);
	                      $message_en = str_replace("#date",$date,$message_en);
	                      $message_en = str_replace("#time",date('H:i'),$message_en);
	                      $message_en = str_replace("#perioddate",$period,$message_en);
	                      $message_en = str_replace("#image",$img_val,$message_en);
	                      $message_en = str_replace("#durationofstudy",$cos_hour,$message_en);
	                      $message_en = str_replace("#companyname",$fetch_company['com_code'],$message_en);
	                      $message_en = str_replace("#expiredate",$date_end,$message_en);
	                    }
	                    if($lang == "thai") {
	                    $this->db->sendEmail( $fetch_user['email'] , $message_th, $subject_th,$fetch_setmail);
	                    } else {
	                    $this->db->sendEmail( $fetch_user['email'] , $message_en, $subject_en,$fetch_setmail);
	                    }
	                	$output['status'] = "2";
	                }else{
						$output['status'] = "0";
	                }
				}else{
					$output['status'] = "0";
				}
			}else{
				$output['status'] = "0";
			}	
		}else{
			$output['status'] = "0";
		}
		echo json_encode($output);
	}


}
?>