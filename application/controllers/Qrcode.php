<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Qrcode extends CI_Controller {

	function get_client_ip()
	{
	      $ipaddress = '';
	      if (getenv('HTTP_CLIENT_IP'))
	          $ipaddress = getenv('HTTP_CLIENT_IP');
	      else if(getenv('HTTP_X_FORWARDED_FOR'))
	          $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	      else if(getenv('HTTP_X_FORWARDED'))
	          $ipaddress = getenv('HTTP_X_FORWARDED');
	      else if(getenv('HTTP_FORWARDED_FOR'))
	          $ipaddress = getenv('HTTP_FORWARDED_FOR');
	      else if(getenv('HTTP_FORWARDED'))
	          $ipaddress = getenv('HTTP_FORWARDED');
	      else if(getenv('REMOTE_ADDR'))
	          $ipaddress = getenv('REMOTE_ADDR');
	      else
	          $ipaddress = 'UNKNOWN';

	      return $ipaddress;
	}

	public function detail($cos_id,$lang_again="")
	{
		$arr['page'] = 'qrcode/detail/'.$cos_id;
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$lang_select = isset($_REQUEST['course_lang'])?$_REQUEST['course_lang']:"";
		$lang_select = $lang_again!=""?$lang_again:$lang_select;
		/*if($lang_select!=""){
		    if($lang_select=="th"){
		    	$lang = 'thai';
		    }else if($lang_select=="eng"){
		    	$lang = 'english';
		    }else{
		    	$lang = 'japan';
		    }
		}*/
		$sess = $this->session->userdata("user");
			if(empty($sess)){
				redirect(base_url().'dashboard/logout?redirect='.$arr['page']) ;
			}

		$this->session->set_userdata('viewcourse', 'real' );
   		$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		$arr['lang_select'] = $lang_select;
		$arr['isFirsttime'] = "0";
		$arr['emp_c'] = $sess['emp_c'];
		$arr['com_admin'] = $sess['com_admin'];
		$arr['com_id'] = $sess['com_id'];
		$arr['lang'] = $lang;
		$arr['user'] = $sess;
		$this->load->model('Home_model', 'home', FALSE);
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$this->manage->loadDB();
		$this->home->loadDB();
		$this->setting->loadDB();

		$arr['foote'] = $this->foot->getfooter();

		date_default_timezone_set("Asia/Bangkok");
		$date_now = date('Y-m-d H:i');
		$arr['arr_permission'] = $this->manage->chk_permission_page();
		$arr['main_menu'] = $this->manage->checkmenu();
		$arr['title'] = $this->manage->get_namemenu($arr['page']);
		$arr['title_main'] = $this->manage->get_namemenu_sub($arr['page']);
		$arr['submenu'] = array();
		$arr['submenu_b'] = array();
		foreach ($arr['main_menu'] as $key_mainmenu => $value_mainmenu) {
			$li_arr_sub = $this->manage->checkmenu_sub($value_mainmenu['mu_id']);
			if(count($li_arr_sub)){
				$arr['submenu'][$value_mainmenu['mu_id']] = $li_arr_sub;
				foreach ($li_arr_sub as $key_sub => $value_sub) {
					$li_arr_sub_b = $this->manage->checkmenu_sub($value_sub['mu_id']);
					if(count($li_arr_sub_b)>0){
						$arr['submenu_b'][$value_sub['mu_id']] = $li_arr_sub_b;
					}
				}
			}
		}

			$fetchchk_period = $this->func_query->query_row('LMS_COMPANY_PERIOD','','','','com_id = "'.$sess['com_id'].'" and compe_year = "'.date('Y').'" and (("'.date('m').'" between compe_montha_start and compe_montha_end) or ("'.date('m').'" between compe_monthb_start and compe_monthb_end))');
			if(count($fetchchk_period)==0){
				redirect(base_url().'dashboard') ;
			}
		$cosen_id = "";
		$fetch_chkenroll = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$cos_id.'" and emp_id="'.$sess['emp_id'].'" and cosen_isDelete="0" and cosen_status="1" and cosen_isActive="1"');
		$cosen_id = $fetch_chkenroll['cosen_id'];
		if(count($fetch_chkenroll)>0&&$lang_select!=""){
			if($fetch_chkenroll['cosen_firsttime']=="0000-00-00 00:00:00"){
				$arr_updateenroll = array(
					'cosen_firsttime' => date('Y-m-d H:i'),
					'cosen_status' => '1',
					'cosen_status_sub' => '2',
					'cosen_modifiedby' => $sess['u_id'],
					'cosen_modifieddate' => date('Y-m-d H:i'),
				);
				$this->db->where('cosen_id',$fetch_chkenroll['cosen_id']);
				$this->db->update('LMS_COS_ENROLL',$arr_updateenroll);
			}

				if($fetch_chkenroll['cosen_lang']==""||$fetch_chkenroll['cosen_lang']!=$lang_select){
					$arr_updateenroll = array(
						'cosen_lang' => $lang_select,
						'cosen_modifiedby' => $sess['u_id'],
						'cosen_modifieddate' => date('Y-m-d H:i'),
					);
					$this->db->where('cosen_id',$fetch_chkenroll['cosen_id']);
					$this->db->update('LMS_COS_ENROLL',$arr_updateenroll);
				}
			$this->endcos($cos_id);
			$ip = $this->get_client_ip();

            $device = '';
            $platform = '';
            $u_agent = $_SERVER['HTTP_USER_AGENT']; 
            if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])){
                $device = 'Mobile';
                if (preg_match('/Mac OS/i', $u_agent)) {
                    $platform = 'Apple';
                }elseif (preg_match('/Android/i', $u_agent)) {
                    $platform = 'Android';
                }
            }else if(preg_match("/(tablet|iPad)/i", $_SERVER["HTTP_USER_AGENT"])){
                $device = 'Tablet';
            }else{
                $device = 'PC';
                if (preg_match('/linux/i', $u_agent)) {
                    $platform = 'linux';
                }elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
                    $platform = 'mac';
                }elseif (preg_match('/windows|win32/i', $u_agent)) {
                    $platform = 'windows';
                }
            }
			$arr_updatelog = array(
				'cosen_id' => $fetch_chkenroll['cosen_id'],
				'cosqr_effective' => date('Y-m-d'),
				'cosqr_logtime' => date('Y-m-d H:i'),
			    'cosqr_ip' => $ip,
			    'cosqr_device' => $device." : ".$platform
			);
			$this->db->insert('LMS_COS_QRCODE',$arr_updatelog);
		}
		if($lang_select==""){
			$lang_select = $lang;
			$arr['isFirsttime'] = "1";
		}
		$arr_statuscos = "1";//Online
		$arr['course_main'] = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'" and LMS_COS.cos_public="1" and LMS_COS.cos_status="1" and LMS_COS.cos_isDelete="0"');
	    if(count($arr['course_main'])==0){
	        //redirect(base_url().'coursemain/my_course') ;
	        $arr_statuscos = "2";//Not found
	    }
		$arr['enroll'] = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$cos_id.'" and emp_id="'.$sess['emp_id'].'" and cosen_isDelete="0"');
		/*if(count($arr['enroll'])==0){

		}*/
        $result_chkcg = $this->func_query->numrows('LMS_COSINCG','LMS_COG','LMS_COSINCG.cg_id = LMS_COG.cg_id','','LMS_COSINCG.course_id="'.$cos_id.'" and LMS_COG.cg_status="1" and LMS_COG.cg_approve="1" and LMS_COG.cg_isDelete="0"');
	    if($result_chkcg==0){
	        //redirect(base_url().'coursemain/my_course') ;
	        $arr_statuscos = "2";//Not found
	    }
		
		/*if(!in_array($cos_langtxt,$cos_lang)){
			redirect(base_url().'dashboard') ;
		}*/
		$arr['cosen_id'] = $cosen_id;
		$txt_period_course = label('UnlimitedTime');
		$arr['canstudy'] = "1";
		$where = 'cos_id = "'.$cos_id.'" and cosde_isDelete="0" and cosde_status="1"';
		//((date_start="0000-00-00 00:00:00" and date_end="0000-00-00 00:00:00") or (date_start <= "'.$date_now.'" and "'.$date_now.'" <= date_end)) and 
		$result_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','', $where,'cosde_id DESC');
		if(count($result_detail)>0){
			if($result_detail['date_start']!="0000-00-00 00:00:00"&&$result_detail['date_end']!="0000-00-00 00:00:00"){
				if(date('Y-m-d H:i')<date('Y-m-d H:i',strtotime($result_detail['date_start']))){
					redirect(base_url());
					// $arr_statuscos = "2";//Not found
				}else{
					if(count($arr['enroll'])==0){
						$fetch_chk_posi = $this->func_query->numrows('LMS_COS_DETAIL_UG','','','','cosde_id="'.$result_detail['cosde_id'].'" and posi_id="'.$sess['posi_id'].'"');
						if($fetch_chk_posi==0){
							$arr_statuscos = "2";//Not found
						}
					}
				}
				if(date('Y-m-d H:i')>date('Y-m-d H:i',strtotime($result_detail['date_end']))){
					//redirect(base_url().'coursemain/my_course') ;
					$arr_statuscos = "3";//Expire
				}else{
					if(count($arr['enroll'])==0){
						$fetch_chk_posi = $this->func_query->numrows('LMS_COS_DETAIL_UG','','','','cosde_id="'.$result_detail['cosde_id'].'" and posi_id="'.$sess['posi_id'].'"');
						if($fetch_chk_posi==0){
							$arr_statuscos = "2";//Not found
						}
					}
				}
				if($lang=="thai"){
					$txt_period_course = date('d',strtotime($result_detail['date_start']))." ".$thaimonth[intval(date('m',strtotime($result_detail['date_start'])))]." ".(date('Y',strtotime($result_detail['date_start']))+543)." ".date('H:i',strtotime($result_detail['date_start']))." -<br>".date('d',strtotime($result_detail['date_end']))." ".$thaimonth[intval(date('m',strtotime($result_detail['date_end'])))]." ".(date('Y',strtotime($result_detail['date_end']))+543)." ".date('H:i',strtotime($result_detail['date_end']));
				}else{
					$txt_period_course = date('d F Y H:i',strtotime($result_detail['date_start']))." -<br>".date('d F Y H:i',strtotime($result_detail['date_end']));
				}
			}else{
				if(count($arr['enroll'])==0){
					$fetch_chk_posi = $this->func_query->numrows('LMS_COS_DETAIL_UG','','','','cosde_id="'.$result_detail['cosde_id'].'" and posi_id="'.$sess['posi_id'].'"');
					if($fetch_chk_posi==0){
						$arr_statuscos = "2";//Not found
					}
				}
			}
		}
		$arr['arr_statuscos'] = $arr_statuscos;
		if($arr_statuscos=="1"){
		$cos_lang = explode(',', $arr['course_main']['cos_lang']);
		$arr['course_main']['isTH'] = in_array('th',$cos_lang)?"1":"0";
		$arr['course_main']['isENG'] = in_array('eng',$cos_lang)?"1":"0";
		$cname = "";
		$cdetail = "";
		$cos_langtxt = "";

						$arr['course_main']['isCondition'] = "0";
						$arr['course_main']['msgCondition'] = "";
						if($arr['course_main']['condition']!=""){
							$var_cos = "";
							$condition = explode(',', $arr['course_main']['condition']);
							if(count($condition)>0){
								$fetch_chk_con = $this->func_query->query_result('LMS_COS','','','','LMS_COS.cos_public="1" and LMS_COS.cos_status="1" and LMS_COS.cos_isDelete="0" and cos_id in ('.$arr['course_main']['condition'].')');
								if(count($fetch_chk_con)>0){
									$numloop_chk = 1;
									foreach ($fetch_chk_con as $key_chk_con => $value_chk_con) {
										if($value_chk_con['cos_id']!=$arr['course_main']['cos_id']){
											$fetch_chkenroll = $this->func_query->numrows('LMS_COS_ENROLL','','','','cos_id="'.$value_chk_con['cos_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_status="1" and cosen_status_sub="1" and cosen_isDelete="0"');
											if($fetch_chkenroll==0){
								                if($lang=="thai"){ 
								                  $cname_con = $value_chk_con['cname_th']!=""?$value_chk_con['cname_th']:$value_chk_con['cname_eng'];
								                }else{ 
								                  $cname_con = $value_chk_con['cname_eng']!=""?$value_chk_con['cname_eng']:$value_chk_con['cname_th'];
								                }
								               // echo "::".$cname_con."<br>";
								                $var_cos .= $cname_con;
								                if($numloop_chk<count($fetch_chk_con)){
								                	$var_cos .= ",";
								                }
											}
										}
							                $numloop_chk++;
									}
									if($var_cos!=""){
										$arr['course_main']['isCondition'] = "1";
										$arr['course_main']['msgCondition'] = $var_cos;
									}
								}
							}
						}
		$arr['cos_id'] = $cos_id;
		if($lang_select=="thai"){
			$cos_langtxt = "th";
		    $arr['course_main']['select_lang'] = 'th';
		    $arr['course_main']['is_lang_user_th'] = 'selected';
				if($arr['course_main']['isTH']=="1"){
					$cname = $arr['course_main']['cname_th'];
					$cdetail = $arr['course_main']['cdesc_th'];
				}else{
					if($arr['course_main']['cname_th']==""){
						$cos_langtxt = "eng";
					    $arr['course_main']['select_lang'] = 'eng';
					    $arr['course_main']['is_lang_user_eng'] = 'selected';
						$cname = $arr['course_main']['cname_eng'];
						$cdetail = $arr['course_main']['cdesc_eng'];
					}
				}
		}else{
			$cos_langtxt = "eng";
		    $arr['course_main']['select_lang'] = 'eng';
		    $arr['course_main']['is_lang_user_eng'] = 'selected';
				if($arr['course_main']['isENG']=="1"){
					$cname = $arr['course_main']['cname_eng'];
					$cdetail = $arr['course_main']['cdesc_eng'];
				}else{
					if($arr['course_main']['cname_eng']==""){
						$cos_langtxt = "th";
					    $arr['course_main']['select_lang'] = 'th';
					    $arr['course_main']['is_lang_user_th'] = 'selected';
						$cname = $arr['course_main']['cname_th'];
						$cdetail = $arr['course_main']['cdesc_th'];
					}
				}
		}
		if($arr['isFirsttime'] == "1"){
			$this->load->model('Log_model', 'lg', FALSE);
			$this->lg->loadDB();
			$this->lg->record('Course', 'Username: '.$sess['useri'].' Course ('.$cname.')');
			//$this->lg->closeDB();
		}
		$fetch_com = $this->func_query->query_row('LMS_COMPANY','','','','com_id="'.$arr['course_main']['com_id'].'"');
		$arr['course_main']['cname'] = $cname;
		$arr['course_main']['cdetail'] = $cdetail;
		$arr['course_main']['com_name'] = $lang_select=="thai"?$fetch_com['com_name_th']:$fetch_com['com_name_eng'];
		$arr['course_main']['txt_period_course'] = $txt_period_course;
		$arr['lesson_status'] = 0;
		$arr['lesson_arr'] = $this->func_query->query_result('LMS_LES','','','','cos_id="'.$cos_id.'" and les_isDelete="0" and les_status="1" and ((time_start="0000-00-00 00:00:00" and time_end="0000-00-00 00:00:00") or (time_start <= "'.$date_now.'" and  time_end >= "'.$date_now.'"))','les_sequences ASC');
		if(count($arr['lesson_arr'])>0){
			$arr_les_id = array();
			foreach ($arr['lesson_arr'] as $key_lesson => $value_lesson) {

                if($lang_select=="thai"){ 
                    $les_name = $value_lesson['les_name_th']!=""?$value_lesson['les_name_th']:$value_lesson['les_name_eng'];
                    $les_info = $value_lesson['les_info_th']!=""?$value_lesson['les_info_th']:$value_lesson['les_info_eng'];
                }else if($lang_select=="english"){ 
                    $les_name = $value_lesson['les_name_eng']!=""?$value_lesson['les_name_eng']:$value_lesson['les_name_th'];
                    $les_info = $value_lesson['les_info_eng']!=""?$value_lesson['les_info_eng']:$value_lesson['les_info_th'];
                }else{
                    $les_name = $value_lesson['les_name_jp']!=""?$value_lesson['les_name_jp']:$value_lesson['les_name_eng'];
                    $les_info = $value_lesson['les_info_jp']!=""?$value_lesson['les_info_jp']:$value_lesson['les_info_eng'];
                }
                $arr['lesson_arr'][$key_lesson]['les_name'] = $les_name;
                $arr['lesson_arr'][$key_lesson]['les_info'] = $les_info;
		    	if($value_lesson['les_type']=="2"){
		    		$fetch_scm = $this->func_query->query_row('LMS_SCM','','','','lessons_id="'.$value_lesson['les_id'].'"');
		    		$arr['lesson_arr'][$key_lesson]['scm_data'] = $fetch_scm;
		    	}else{
		    		$fetch_med = $this->func_query->query_result('LMS_MED','','','','lessons_id="'.$value_lesson['les_id'].'"');
		    		foreach ($fetch_med as $key_med => $value_med) {
		    			$fetch_medtc = $this->func_query->query_row('LMS_MED_TC','','','','emp_id="'.$sess['emp_id'].'" and med_id="'.$value_med['id'].'" and cosen_id="'.$cosen_id.'"');
		    			$fetch_med[$key_med]['arr_status'] = count($fetch_medtc)>0?1:0;
		    		}
		    		$arr['lesson_arr'][$key_lesson]['med_data'] = $fetch_med;
		    		$fetch_doc = $this->func_query->query_result('LMS_FIL','','','','lessons_id="'.$value_lesson['les_id'].'"');
		    		foreach ($fetch_doc as $key_doc => $value_doc) {
		    			$fetch_doctc = $this->func_query->query_row('LMS_FIL_LOG','','','','emp_id="'.$sess['emp_id'].'" and fil_id="'.$value_doc['id'].'" and cosen_id="'.$cosen_id.'"');
		    			$fetch_doc[$key_doc]['arr_status'] = count($fetch_doctc)>0?1:0;
		    		}
		    		$arr['lesson_arr'][$key_lesson]['doc_data'] = $fetch_doc;
		    	}
				if(!in_array($value_lesson['les_id'], $arr_les_id)){
					array_push($arr_les_id, $value_lesson['les_id']);
				}
			}
			$txt_les_id = implode(',', $arr_les_id);
			$value_status = 0;
			$fetch_chktc = $this->func_query->query_result('LMS_LES_TC','','','','les_id in ('.$txt_les_id.') and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'"');
			if(count($fetch_chktc)){
				foreach ($fetch_chktc as $key_chktc => $value_chktc) {
					if($value_chktc['learn_status']=="2"){
						$value_status++;
					}
				}
			}
			$arr['lesson_status'] = $value_status;
		}
		$arr['pretest_arr'] = $this->func_query->query_result('LMS_QIZ','','','','cos_id="'.$cos_id.'" and quiz_isDelete="0" and quiz_status="1" and quiz_show="1" and quiz_type="1" and ((period_open="0000-00-00 00:00:00" and period_end="0000-00-00 00:00:00") or (period_open <= "'.$date_now.'" and  period_end >= "'.$date_now.'"))','LMS_QIZ.qiz_id ASC');
		$loop_run = 1;
		if(count($arr['pretest_arr'])>0){
				foreach ($arr['pretest_arr'] as $key_pretest => $value_pretest) {
	                $fetch_chkques = $this->func_query->numrows('LMS_QUES','','','','qiz_id="'.$value_pretest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
	                if($fetch_chkques==0){
	                 	unset($arr['pretest_arr'][$key_pretest]);
	                }
				}
				if(count($arr['pretest_arr'])>0){
					foreach ($arr['pretest_arr'] as $key_pretest => $value_pretest) {
							$fetch_chktc = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$value_pretest['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and qiztc_isDelete="0" and cosen_id="'.$cosen_id.'"','qiztc_id DESC');
							$per_score = 0;
							$qiztc_id = "";
							$ques_id_arr = array();
							$arr['pretest_arr'][$key_pretest]['isNull'] = "1";
							$arr['pretest_arr'][$key_pretest]['endstatus'] = "0";
							if(count($fetch_chktc)>0){
		                        $fetch_chk_ques = $this->func_query->query_row('LMS_QUES','','','','qiz_id="'.$value_pretest['qiz_id'].'" and ques_isDelete="0"','','sum(LMS_QUES.ques_score) as total_score');
		                        $arr['pretest_arr'][$key_pretest]['fullscore'] = floatval($fetch_chk_ques['total_score']);
								$arr['pretest_arr'][$key_pretest]['isNull'] = "0";
								$arr['pretest_arr'][$key_pretest]['status_tc'] = $fetch_chktc['qiz_status'];
								$arr['pretest_arr'][$key_pretest]['sum_score'] = $fetch_chktc['sum_score'];
								$arr['pretest_arr'][$key_pretest]['per_score'] = $fetch_chktc['per_score'];

		                        $arr['pretest_arr'][$key_pretest]['statustxt'] = floatval($fetch_chktc['per_score'])>=floatval($value_pretest['quiz_maxscore'])?'Pass':'Fail';
								$num_loop = $this->func_query->numrows('LMS_QIZ_TC','','','','qiz_id="'.$value_pretest['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and qiztc_isDelete="0" and qiz_status="3" and cosen_id="'.$cosen_id.'"');
								$quiz_limitval = 1;
								if($value_pretest['quiz_limit']=="1"){
									$quiz_limitval = intval($value_pretest['quiz_limitval']);
									if($num_loop>=$quiz_limitval){
										$arr['pretest_arr'][$key_pretest]['endstatus'] = "1";
										if($fetch_chktc['qiz_status']!="3"){
										$arr['pretest_arr'][$key_pretest]['endstatus'] = "0";
										}
									}else{
										if(floatval($value_pretest['quiz_maxscore'])==0){
											if(floatval($fetch_chktc['per_score'])>0){
												if($fetch_chktc['qiz_status']=="3"){
													$arr['pretest_arr'][$key_pretest]['endstatus'] = "1";
												}
											}
										}else{
											if(floatval($fetch_chktc['per_score'])>=floatval($value_pretest['quiz_maxscore'])){
												if($fetch_chktc['qiz_status']=="3"){
													$arr['pretest_arr'][$key_pretest]['endstatus'] = "1";
												}
											}
										}
									}
								}else{
											if(floatval($fetch_chktc['per_score'])>=floatval($value_pretest['quiz_maxscore'])){
												if($fetch_chktc['qiz_status']=="3"){
													$arr['pretest_arr'][$key_pretest]['endstatus'] = "1";
												}
											}
								}
								$fetch_chksh_lg = $this->func_query->numrows('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_pretest['qiz_id'].'" and ques_status="1" and ques_isDelete="0" and ques_type in ("sub","sa")');
								if($fetch_chktc['qiz_status']=="3"){
									if($fetch_chksh_lg>0){
										$arr['pretest_arr'][$key_pretest]['endstatus'] = "1";
									}
								    if(floatval($fetch_chktc['per_score'])<floatval($value_pretest['quiz_maxscore'])&&$fetch_chksh_lg==0){
										if($arr['pretest_arr'][$key_pretest]['endstatus']!="1"){
										    $fetch_loop = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$value_pretest['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and qiztc_isDelete="0" and cosen_id="'.$cosen_id.'"','limit_val DESC');
										    $limit_val = count($fetch_loop)>0?intval($fetch_loop['limit_val'])+1:1;
										    $arr_main = array(
										        'qiz_id' => $value_pretest['qiz_id'],
										        'emp_id' => $sess['emp_id'],
										        'time_start' => date('Y-m-d H:i'),
										        'time_mod' => date('Y-m-d H:i'),
										        'qiz_status' => '1',
										        'limit_val' => $limit_val,
										        'cosen_id' => $cosen_id
										    );
										    $this->db->insert('LMS_QIZ_TC',$arr_main);
			      							$qiztc_id = $this->db->insert_id();
									    	$loop_run=0;
									    }else{
									    	$qiztc_id = $fetch_chktc['qiztc_id'];
									    }
								    }else{
									    $qiztc_id = $fetch_chktc['qiztc_id'];
									}
								}else{
									$loop_run=0;
									$qiztc_id = $fetch_chktc['qiztc_id'];
								}
								$fetch_chk_ques = $this->func_query->query_result('LMS_QUES_TC','','','','qiztc_id="'.$qiztc_id.'" and emp_id="'.$sess['emp_id'].'" and qiz_id="'.$value_pretest['qiz_id'].'" and cosen_id="'.$cosen_id.'"');

								$quiz_numofshown = $value_pretest['quiz_numofshown'];
								if(count($fetch_chk_ques)>0){
									if(intval($quiz_numofshown)==count($fetch_chk_ques)){
										foreach ($fetch_chk_ques as $key_chkques => $value_chkques) {
											if(!in_array($value_chkques['ques_id'], $ques_id_arr)){
											    array_push($ques_id_arr, $value_chkques['ques_id']);
											}
										}
									}else if(intval($quiz_numofshown)>count($fetch_chk_ques)){
										$amount = intval($quiz_numofshown)-count($fetch_chk_ques);
										$arr_ques_ori = array();
										foreach ($fetch_chk_ques as $key_chkques => $value_chkques) {
											if(!in_array($value_chkques['ques_id'], $arr_ques_ori)){
											    array_push($arr_ques_ori, $value_chkques['ques_id']);
											    array_push($ques_id_arr, $value_chkques['ques_id']);
											}
										}

										$order_question = "LMS_QUES.ques_id ASC";
										if($value_pretest['quiz_random']=="1"){
											$order_question = "RAND()";
										}
										$where_arr = ' and ques_id not in ('.implode(',', $arr_ques_ori).')';
										$fetch_ques = $this->func_query->query_result('LMS_QUES','','','','qiz_id="'.$value_pretest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"'.$where_arr,$order_question,'',$amount);

										if(count($fetch_ques)>0){
											foreach ($fetch_ques as $key_ques => $value_ques) {
											      $fetch_chk_ques = $this->func_query->numrows('LMS_QUES_TC','','','','qiztc_id="'.$qiztc_id.'" and emp_id="'.$sess['emp_id'].'" and qiz_id="'.$value_pretest['qiz_id'].'" and ques_id="'.$value_ques['ques_id'].'" and cosen_id="'.$cosen_id.'"');

											      $arr_main = array(
											          'qiztc_id' => $qiztc_id,
											          'qiz_id' => $value_pretest['qiz_id'],
											          'ques_id' => $value_ques['ques_id'],
											          'emp_id' => $sess['emp_id'],
										        	  'cosen_id' => $cosen_id
											      );
											      if($fetch_chk_ques==0){
											      	if(!in_array($value_ques['ques_id'], $ques_id_arr)){
											      		array_push($ques_id_arr, $value_ques['ques_id']);
											      	}
											        $this->db->insert('LMS_QUES_TC',$arr_main);
											      }
											}
										}
									}else{
										$amount = count($fetch_chk_ques)-intval($quiz_numofshown);
										//echo "974::".$amount;
										$fetch_chk_ques = $this->func_query->query_result('LMS_QUES_TC','','','','qiztc_id="'.$qiztc_id.'" and emp_id="'.$sess['emp_id'].'" and qiz_id="'.$value_pretest['qiz_id'].'" and cosen_id="'.$cosen_id.'"','LMS_QUES_TC.ques_id DESC','',$amount);
										foreach ($fetch_chk_ques as $key_questc => $value_questc) {
											$this->db->where('tc_id',$value_questc['tc_id']);
											$this->db->delete('LMS_QUES_TC');
										}

										$order_question = "LMS_QUES.ques_id ASC";
										if($value_pretest['quiz_random']=="1"){
											$order_question = "RAND()";
										}
										$fetch_ques = $this->func_query->query_result('LMS_QUES','','','','qiz_id="'.$value_pretest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"',$order_question,'',$amount);

										if(count($fetch_ques)>0){
											foreach ($fetch_ques as $key_ques => $value_ques) {
											      $fetch_chk_ques = $this->func_query->numrows('LMS_QUES_TC','','','','qiztc_id="'.$qiztc_id.'" and emp_id="'.$sess['emp_id'].'" and qiz_id="'.$value_pretest['qiz_id'].'" and cosen_id="'.$cosen_id.'" and ques_id="'.$value_ques['ques_id'].'"');

											      $arr_main = array(
											          'qiztc_id' => $qiztc_id,
											          'qiz_id' => $value_pretest['qiz_id'],
											          'ques_id' => $value_ques['ques_id'],
											          'emp_id' => $sess['emp_id'],
										        	  'cosen_id' => $cosen_id
											      );
											      if($fetch_chk_ques==0){
											      	if(!in_array($value_ques['ques_id'], $ques_id_arr)){
											      		array_push($ques_id_arr, $value_ques['ques_id']);
											      	}
											        $this->db->insert('LMS_QUES_TC',$arr_main);
											      }
											}
										}
									}
								}else{
									$order_question = "LMS_QUES.ques_id ASC";
									$quiz_numofshown = $value_pretest['quiz_numofshown'];
									if($value_pretest['quiz_random']=="1"){
										$order_question = "RAND()";
									}
									
									$fetch_ques = $this->func_query->query_result('LMS_QUES','','','','qiz_id="'.$value_pretest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"',$order_question,'',$quiz_numofshown);
									if(count($fetch_ques)>0){
										foreach ($fetch_ques as $key_ques => $value_ques) {
										      $fetch_chk_ques = $this->func_query->numrows('LMS_QUES_TC','','','','qiztc_id="'.$qiztc_id.'" and emp_id="'.$sess['emp_id'].'" and qiz_id="'.$value_pretest['qiz_id'].'" and cosen_id="'.$cosen_id.'" and ques_id="'.$value_ques['ques_id'].'"');

										      $arr_main = array(
										          'qiztc_id' => $qiztc_id,
										          'qiz_id' => $value_pretest['qiz_id'],
										          'ques_id' => $value_ques['ques_id'],
										          'emp_id' => $sess['emp_id'],
										          'cosen_id' => $cosen_id
										      );
										      if($fetch_chk_ques==0){
										      	if(!in_array($value_ques['ques_id'], $ques_id_arr)){
										      		array_push($ques_id_arr, $value_ques['ques_id']);
										      	}
										        $this->db->insert('LMS_QUES_TC',$arr_main);
										      }
										}
									}
								}
								$arr['pretest_arr'][$key_pretest]['qiztc_id'] = $qiztc_id;
							}else{
								$arr['pretest_arr'][$key_pretest]['status_tc'] = "0";
								$arr['pretest_arr'][$key_pretest]['sum_score'] = "0";
								$arr['pretest_arr'][$key_pretest]['per_score'] = "0";
								$arr['pretest_arr'][$key_pretest]['endstatus'] = "0";

								    $fetch_loop = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$value_pretest['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and qiztc_isDelete="0" and cosen_id="'.$cosen_id.'"','limit_val DESC');
								    $limit_val = count($fetch_loop)>0?intval($fetch_loop['limit_val'])+1:1;
								    $arr_main = array(
								        'qiz_id' => $value_pretest['qiz_id'],
								        'emp_id' => $sess['emp_id'],
								        'time_start' => date('Y-m-d H:i'),
								        'time_mod' => date('Y-m-d H:i'),
								        'qiz_status' => '1',
								        'limit_val' => $limit_val,
										'cosen_id' => $cosen_id
								    );
								    $this->db->insert('LMS_QIZ_TC',$arr_main);
	      							$qiztc_id = $this->db->insert_id();
								$arr['pretest_arr'][$key_pretest]['qiztc_id'] = $qiztc_id;

								$order_question = "LMS_QUES.ques_id ASC";
								$quiz_numofshown = $value_pretest['quiz_numofshown'];
								if($value_pretest['quiz_random']=="1"){
									$order_question = "RAND()";
								}
								
								$fetch_ques = $this->func_query->query_result('LMS_QUES','','','','qiz_id="'.$value_pretest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"',$order_question,'',$quiz_numofshown);
								if(count($fetch_ques)>0){
									foreach ($fetch_ques as $key_ques => $value_ques) {
									      $fetch_chk_ques = $this->func_query->numrows('LMS_QUES_TC','','','','qiztc_id="'.$qiztc_id.'" and emp_id="'.$sess['emp_id'].'" and qiz_id="'.$value_pretest['qiz_id'].'" and cosen_id="'.$cosen_id.'" and ques_id="'.$value_ques['ques_id'].'"');

									      $arr_main = array(
									          'qiztc_id' => $qiztc_id,
									          'qiz_id' => $value_pretest['qiz_id'],
									          'ques_id' => $value_ques['ques_id'],
									          'emp_id' => $sess['emp_id'],
										      'cosen_id' => $cosen_id
									      );
									      if($fetch_chk_ques==0){
									      	if(!in_array($value_ques['ques_id'], $ques_id_arr)){
									      		array_push($ques_id_arr, $value_ques['ques_id']);
									      	}
									        $this->db->insert('LMS_QUES_TC',$arr_main);
									      }
									}
								}

							}
							if(count($ques_id_arr)>0){
								$order_question = "LMS_QUES.ques_id ASC";
								if($value_pretest['quiz_random']=="1"){
									$order_question = "RAND()";
								}
								$where_arr = 'and ques_id in ('.implode(',', $ques_id_arr).')';
								$fetch_ques = $this->func_query->query_result('LMS_QUES','','','','qiz_id="'.$value_pretest['qiz_id'].'" and ques_status="1" and ques_isDelete="0" '.$where_arr,$order_question);
							}else{
								$fetch_ques = array();
							}
							if(count($fetch_ques)>0){
								foreach ($fetch_ques as $key_ques => $value_ques) {
									if($value_ques['ques_type']=="multi"||$value_ques['ques_type']=="2choice"){
										$fetch_multi = $this->func_query->query_row('LMS_QUES_MUL','','','','LMS_QUES_MUL.ques_id="'.$value_ques['ques_id'].'"');
										$fetch_ques[$key_ques]['multi'] = $fetch_multi;
									}
									$fetch_chktc_ques = $this->func_query->query_row('LMS_QUES_TC','','','','qiz_id="'.$value_pretest['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'" and ques_id="'.$value_ques['ques_id'].'" and qiztc_id="'.$qiztc_id.'"');
									if(count($fetch_chktc_ques)>0){
										$fetch_ques[$key_ques]['tc'] = $fetch_chktc_ques;
										$fetch_ques[$key_ques]['tc_isSavescore'] = $fetch_chktc_ques['tc_isSavescore'];
									}
								}
							}
							$arr['pretest_arr'][$key_pretest]['question'] = $fetch_ques;
					}
				}
		}
		$arr['loop_run'] = $loop_run;
		$where = 'cos_id="'.$cos_id.'" and quiz_isDelete="0" and quiz_status="1" and quiz_show="1" and quiz_type="2" and ((period_open="0000-00-00 00:00:00" and period_end="0000-00-00 00:00:00") or (period_open <= "'.$date_now.'" and  period_end >= "'.$date_now.'"))';
		$arr['posttest_arr'] = $this->func_query->query_result('LMS_QIZ','','','',$where,'LMS_QIZ.qiz_id ASC');
		if(count($arr['posttest_arr'])>0){

				foreach ($arr['posttest_arr'] as $key_posttest => $value_posttest) {
	                $fetch_chkques = $this->func_query->numrows('LMS_QUES','','','','qiz_id="'.$value_posttest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
	                if($fetch_chkques==0){
	                 	unset($arr['posttest_arr'][$key_posttest]);
	                }
				}
				if(count($arr['posttest_arr'])>0){
					foreach ($arr['posttest_arr'] as $key_posttest => $value_posttest) {
							$fetch_chktc = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$value_posttest['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and qiztc_isDelete="0" and cosen_id="'.$cosen_id.'"','qiztc_id DESC');
							$per_score = 0;
							$qiztc_id = "";
							$ques_id_arr = array();
							$arr['posttest_arr'][$key_posttest]['endstatus'] = "0";
							$arr['posttest_arr'][$key_posttest]['isPass'] = "";
							$arr['posttest_arr'][$key_posttest]['isNull'] = "1";
							if(count($fetch_chktc)>0){
		                        $fetch_chk_ques = $this->func_query->query_row('LMS_QUES','','','','qiz_id="'.$value_posttest['qiz_id'].'" and ques_isDelete="0"','','sum(LMS_QUES.ques_score) as total_score');
		                        $arr['posttest_arr'][$key_posttest]['fullscore'] = floatval($fetch_chk_ques['total_score']);
								$arr['posttest_arr'][$key_posttest]['isNull'] = "0";
								$arr['posttest_arr'][$key_posttest]['status_tc'] = $fetch_chktc['qiz_status'];
								$arr['posttest_arr'][$key_posttest]['sum_score'] = $fetch_chktc['sum_score'];
								$arr['posttest_arr'][$key_posttest]['per_score'] = $fetch_chktc['per_score'];

		                        $arr['posttest_arr'][$key_posttest]['statustxt'] = floatval($fetch_chktc['per_score'])>=floatval($value_posttest['quiz_maxscore'])?'Pass':'Fail';
								$num_loop = $this->func_query->numrows('LMS_QIZ_TC','','','','qiz_id="'.$value_posttest['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and qiztc_isDelete="0" and cosen_id="'.$cosen_id.'" and qiz_status="3"');
								$quiz_limitval = 1;
								if($value_posttest['quiz_limit']=="1"){
									$quiz_limitval = intval($value_posttest['quiz_limitval']);
									if($num_loop>=$quiz_limitval){
										$arr['posttest_arr'][$key_posttest]['endstatus'] = "1";
										$arr['posttest_arr'][$key_posttest]['isPass'] = "1";
										if($fetch_chktc['qiz_status']!="3"){
										$arr['posttest_arr'][$key_posttest]['endstatus'] = "0";
										$arr['posttest_arr'][$key_posttest]['isPass'] = "0";
										}
									}else{
										/*if(floatval($value_posttest['quiz_maxscore'])==0){
											if(floatval($fetch_chktc['per_score'])>0){
												if($fetch_chktc['qiz_status']=="3"){
													$arr['posttest_arr'][$key_posttest]['endstatus'] = "1";
												}
											}
										}else{*/
											if(floatval($fetch_chktc['per_score'])>=floatval($value_posttest['quiz_maxscore'])){
												if($fetch_chktc['qiz_status']=="3"){
													$arr['posttest_arr'][$key_posttest]['endstatus'] = "1";
													$arr['posttest_arr'][$key_posttest]['isPass'] = "1";
												}
											}else{
												if($fetch_chktc['qiz_status']=="3"){
													$arr['posttest_arr'][$key_posttest]['isPass'] = "0";
												}
											}
										//}
									}
								}else{
											if(floatval($fetch_chktc['per_score'])>=floatval($value_posttest['quiz_maxscore'])){
												if($fetch_chktc['qiz_status']=="3"){
													$arr['posttest_arr'][$key_posttest]['endstatus'] = "1";
												}
											}
											$arr['posttest_arr'][$key_posttest]['isPass'] = "1";
								}
								$fetch_chksh_lg = $this->func_query->numrows('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_posttest['qiz_id'].'" and ques_status="1" and ques_isDelete="0" and ques_type in ("sub","sa")');
								if($fetch_chktc['qiz_status']=="3"&&$arr['posttest_arr'][$key_posttest]['endstatus']=="0"){
									if($fetch_chksh_lg>0){
										$arr['posttest_arr'][$key_posttest]['endstatus'] = "1";
									}
								    if(floatval($fetch_chktc['per_score'])<floatval($value_posttest['quiz_maxscore'])&&$fetch_chksh_lg==0){
										if($arr['posttest_arr'][$key_posttest]['endstatus']!="1"){
										    $fetch_loop = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$value_posttest['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'" and qiztc_isDelete="0"','limit_val DESC');
										    $limit_val = count($fetch_loop)>0?intval($fetch_loop['limit_val'])+1:1;
										    $arr_main = array(
										        'qiz_id' => $value_posttest['qiz_id'],
										        'emp_id' => $sess['emp_id'],
										        'time_start' => date('Y-m-d H:i'),
										        'time_mod' => date('Y-m-d H:i'),
										        'qiz_status' => '1',
										        'limit_val' => $limit_val,
										        'cosen_id' => $cosen_id
										    );
										    $this->db->insert('LMS_QIZ_TC',$arr_main);
			      							$qiztc_id = $this->db->insert_id();
									    }else{
									    	$qiztc_id = $fetch_chktc['qiztc_id'];
									    }
								    }else{
									    $qiztc_id = $fetch_chktc['qiztc_id'];
									}
								}else{
									$qiztc_id = $fetch_chktc['qiztc_id'];
								}
								$fetch_chk_ques = $this->func_query->query_result('LMS_QUES_TC','','','','qiztc_id="'.$qiztc_id.'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'" and qiz_id="'.$value_posttest['qiz_id'].'"');

								$quiz_numofshown = $value_posttest['quiz_numofshown'];
								if(count($fetch_chk_ques)>0){
									if(intval($quiz_numofshown)==count($fetch_chk_ques)){
										foreach ($fetch_chk_ques as $key_chkques => $value_chkques) {
											if(!in_array($value_chkques['ques_id'], $ques_id_arr)){
											    array_push($ques_id_arr, $value_chkques['ques_id']);
											}
										}
									}else if(intval($quiz_numofshown)>count($fetch_chk_ques)){
										$amount = intval($quiz_numofshown)-count($fetch_chk_ques);
										$arr_ques_ori = array();
										foreach ($fetch_chk_ques as $key_chkques => $value_chkques) {
											if(!in_array($value_chkques['ques_id'], $arr_ques_ori)){
											    array_push($arr_ques_ori, $value_chkques['ques_id']);
											    array_push($ques_id_arr, $value_chkques['ques_id']);
											}
										}

										$order_question = "LMS_QUES.ques_id ASC";
										if($value_posttest['quiz_random']=="1"){
											$order_question = "RAND()";
										}
										$where_arr = ' and ques_id not in ('.implode(',', $arr_ques_ori).')';
										$fetch_ques = $this->func_query->query_result('LMS_QUES','','','','qiz_id="'.$value_posttest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"'.$where_arr,$order_question,'',$amount);

										if(count($fetch_ques)>0){
											foreach ($fetch_ques as $key_ques => $value_ques) {
											      $fetch_chk_ques = $this->func_query->numrows('LMS_QUES_TC','','','','qiztc_id="'.$qiztc_id.'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'" and qiz_id="'.$value_posttest['qiz_id'].'" and ques_id="'.$value_ques['ques_id'].'"');

											      $arr_main = array(
											          'qiztc_id' => $qiztc_id,
											          'qiz_id' => $value_posttest['qiz_id'],
											          'ques_id' => $value_ques['ques_id'],
											          'emp_id' => $sess['emp_id'],
										        	  'cosen_id' => $cosen_id
											      );
											      if($fetch_chk_ques==0){
											      	if(!in_array($value_ques['ques_id'], $ques_id_arr)){
											      		array_push($ques_id_arr, $value_ques['ques_id']);
											      	}
											        $this->db->insert('LMS_QUES_TC',$arr_main);
											      }
											}
										}
									}else{
										$amount = count($fetch_chk_ques)-intval($quiz_numofshown);
										if($amount>0){
										$fetch_chk_ques = $this->func_query->query_result('LMS_QUES_TC','','','','qiztc_id="'.$qiztc_id.'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'" and qiz_id="'.$value_posttest['qiz_id'].'"','','',$amount);
										if(count($fetch_chk_ques)>0){
											foreach ($fetch_chk_ques as $key_questc => $value_questc) {
												$this->db->where('tc_id',$value_questc['tc_id']);
												$this->db->delete('LMS_QUES_TC');
											}
										}
										}

										
										$order_question = "LMS_QUES.ques_id ASC";
										if($value_posttest['quiz_random']=="1"){
											$order_question = "RAND()";
										}
										$fetch_ques = $this->func_query->query_result('LMS_QUES','','','','qiz_id="'.$value_posttest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"',$order_question,'',$amount);

										if(count($fetch_ques)>0){
											foreach ($fetch_ques as $key_ques => $value_ques) {
											      $fetch_chk_ques = $this->func_query->numrows('LMS_QUES_TC','','','','qiztc_id="'.$qiztc_id.'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'" and qiz_id="'.$value_posttest['qiz_id'].'" and ques_id="'.$value_ques['ques_id'].'"');

											      $arr_main = array(
											          'qiztc_id' => $qiztc_id,
											          'qiz_id' => $value_posttest['qiz_id'],
											          'ques_id' => $value_ques['ques_id'],
											          'emp_id' => $sess['emp_id'],
										        	  'cosen_id' => $cosen_id
											      );
											      if($fetch_chk_ques==0){
											      	if(!in_array($value_ques['ques_id'], $ques_id_arr)){
											      		array_push($ques_id_arr, $value_ques['ques_id']);
											      	}
											        $this->db->insert('LMS_QUES_TC',$arr_main);
											      }
											}
										}
									}
								}else{
									$order_question = "LMS_QUES.ques_id ASC";
									$quiz_numofshown = $value_posttest['quiz_numofshown'];
									if($value_posttest['quiz_random']=="1"){
										$order_question = "RAND()";
									}
									
									$fetch_ques = $this->func_query->query_result('LMS_QUES','','','','qiz_id="'.$value_posttest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"',$order_question,'',$quiz_numofshown);
									if(count($fetch_ques)>0){
										foreach ($fetch_ques as $key_ques => $value_ques) {
										      $fetch_chk_ques = $this->func_query->numrows('LMS_QUES_TC','','','','qiztc_id="'.$qiztc_id.'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'" and qiz_id="'.$value_posttest['qiz_id'].'" and ques_id="'.$value_ques['ques_id'].'"');

										      $arr_main = array(
										          'qiztc_id' => $qiztc_id,
										          'qiz_id' => $value_posttest['qiz_id'],
										          'ques_id' => $value_ques['ques_id'],
										          'emp_id' => $sess['emp_id'],
										          'cosen_id' => $cosen_id
										      );
										      if($fetch_chk_ques==0){
										      	if(!in_array($value_ques['ques_id'], $ques_id_arr)){
										      		array_push($ques_id_arr, $value_ques['ques_id']);
										      	}
										        $this->db->insert('LMS_QUES_TC',$arr_main);
										      }else{
										      	if(!in_array($value_ques['ques_id'], $ques_id_arr)){
										      		array_push($ques_id_arr, $value_ques['ques_id']);
										      	}
										      }
										}
									}
								}
								$arr['posttest_arr'][$key_posttest]['qiztc_id'] = $qiztc_id;
							}else{
								$arr['posttest_arr'][$key_posttest]['status_tc'] = "0";
								$arr['posttest_arr'][$key_posttest]['sum_score'] = "0";
								$arr['posttest_arr'][$key_posttest]['per_score'] = "0";
								$arr['posttest_arr'][$key_posttest]['endstatus'] = "0";

								    $fetch_loop = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$value_posttest['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'" and qiztc_isDelete="0"','limit_val DESC');
								    $limit_val = count($fetch_loop)>0?intval($fetch_loop['limit_val'])+1:1;
								    $arr_main = array(
								        'qiz_id' => $value_posttest['qiz_id'],
								        'emp_id' => $sess['emp_id'],
								        'time_start' => date('Y-m-d H:i'),
								        'time_mod' => date('Y-m-d H:i'),
								        'qiz_status' => '1',
								        'limit_val' => $limit_val,
										'cosen_id' => $cosen_id
								    );
								    $this->db->insert('LMS_QIZ_TC',$arr_main);
	      							$qiztc_id = $this->db->insert_id();
								$arr['posttest_arr'][$key_posttest]['qiztc_id'] = $qiztc_id;

								$order_question = "LMS_QUES.ques_id ASC";
								$quiz_numofshown = $value_posttest['quiz_numofshown'];
								if($value_posttest['quiz_random']=="1"){
									$order_question = "RAND()";
								}
								
								$fetch_ques = $this->func_query->query_result('LMS_QUES','','','','qiz_id="'.$value_posttest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"',$order_question,'',$quiz_numofshown);
								if(count($fetch_ques)>0){
									foreach ($fetch_ques as $key_ques => $value_ques) {
									      $fetch_chk_ques = $this->func_query->numrows('LMS_QUES_TC','','','','qiztc_id="'.$qiztc_id.'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'" and qiz_id="'.$value_posttest['qiz_id'].'" and ques_id="'.$value_ques['ques_id'].'"');

									      $arr_main = array(
									          'qiztc_id' => $qiztc_id,
									          'qiz_id' => $value_posttest['qiz_id'],
									          'ques_id' => $value_ques['ques_id'],
									          'emp_id' => $sess['emp_id'],
										      'cosen_id' => $cosen_id
									      );
									      if($fetch_chk_ques==0){
									      	if(!in_array($value_ques['ques_id'], $ques_id_arr)){
									      		array_push($ques_id_arr, $value_ques['ques_id']);
									      	}
									        $this->db->insert('LMS_QUES_TC',$arr_main);
									      }else{
									      	if(!in_array($value_ques['ques_id'], $ques_id_arr)){
									      		array_push($ques_id_arr, $value_ques['ques_id']);
									      	}
									      }
									}
								}

							}
							if(count($ques_id_arr)>0){
								$order_question = "LMS_QUES.ques_id ASC";
								if($value_posttest['quiz_random']=="1"){
									$order_question = "RAND()";
								}
								$where_arr = 'and ques_id in ('.implode(',', $ques_id_arr).')';
								$fetch_ques = $this->func_query->query_result('LMS_QUES','','','','qiz_id="'.$value_posttest['qiz_id'].'" and ques_status="1" and ques_isDelete="0" '.$where_arr,$order_question);
							}else{
								$fetch_ques = array();
							}
							if(count($fetch_ques)>0){
								foreach ($fetch_ques as $key_ques => $value_ques) {
									if($value_ques['ques_type']=="multi"||$value_ques['ques_type']=="2choice"){
										$fetch_multi = $this->func_query->query_row('LMS_QUES_MUL','','','','LMS_QUES_MUL.ques_id="'.$value_ques['ques_id'].'"');
										$fetch_ques[$key_ques]['multi'] = $fetch_multi;
									}
									$fetch_chktc_ques = $this->func_query->query_row('LMS_QUES_TC','','','','qiz_id="'.$value_posttest['qiz_id'].'" and cosen_id="'.$cosen_id.'" and emp_id="'.$sess['emp_id'].'" and ques_id="'.$value_ques['ques_id'].'" and qiztc_id="'.$qiztc_id.'"');
									if(count($fetch_chktc_ques)>0){
										$fetch_ques[$key_ques]['tc'] = $fetch_chktc_ques;
										$fetch_ques[$key_ques]['tc_isSavescore'] = $fetch_chktc_ques['tc_isSavescore'];
									}
								}
							}
							$arr['posttest_arr'][$key_posttest]['question'] = $fetch_ques;
					}
				}
		}
		$arr['document_cos'] = $this->func_query->query_result('LMS_COS_FIL','','','','cos_id="'.$cos_id.'" and fil_status="1" and fil_isDelete="0"');

		$arr['survey_arr'] = $this->func_query->query_result('LMS_SURVEY','','','','cos_id="'.$cos_id.'" and sv_isDelete="0" and sv_status="1" and ((survey_open="0000-00-00 00:00:00" and survey_end="0000-00-00 00:00:00") or (survey_open <= "'.$date_now.'" and  survey_end >= "'.$date_now.'"))','sv_id ASC');
		if(count($arr['survey_arr'])>0){

				foreach ($arr['survey_arr'] as $key_survey => $value_survey) {
	                $fetch_chkques = $this->func_query->numrows('LMS_SURVEY_DE','','','','sv_id="'.$value_survey['sv_id'].'" and svde_status="1" and svde_isDelete="0"');
	                if($fetch_chkques==0){
	                 	unset($arr['survey_arr'][$key_survey]);
	                }
				}
				if(count($arr['survey_arr'])>0){
					foreach ($arr['survey_arr'] as $key_sv => $value_sv) {
						$qnu_id = "";
						$fetch_status = $this->func_query->query_row('LMS_QN_USER','','','','emp_id="'.$sess['emp_id'].'" and sv_id="'.$value_sv['sv_id'].'" and cosen_id="'.$cosen_id.'"');
						if(count($fetch_status)>0){
							$arr['survey_arr'][$key_sv]['status_tc'] = $fetch_status['qnu_status'];
							$arr['survey_arr'][$key_sv]['date_tc'] = $fetch_status['qnu_datetime'];
							$arr['survey_arr'][$key_sv]['suggestion_tc'] = $fetch_status['qnu_suggestion'];
							$qnu_id = $fetch_status['qnu_id'];
						}else{
							$arr['survey_arr'][$key_sv]['status_tc'] = '0';
							$arr['survey_arr'][$key_sv]['date_tc'] = '';
							$arr['survey_arr'][$key_sv]['suggestion_tc'] = '';
						}
						$fetch_detail = $this->func_query->query_result('LMS_SURVEY_DE','','','','sv_id="'.$value_sv['sv_id'].'" and svde_status="1" and svde_isDelete="0"','svde_id ASC');
						if(count($fetch_detail)>0){
							foreach ($fetch_detail as $key_detail => $value_detail) {
								if($qnu_id!=""){
									$fetch_detailtc = $this->func_query->query_row('LMS_QN_USER_DE','','','','svde_id="'.$value_detail['svde_id'].'" and qnu_id="'.$qnu_id.'"');
									if(count($fetch_detailtc)>0){
										$fetch_detail[$key_detail]['detail_tc'] = $fetch_detailtc;
									}
								}
							}
						}
						$arr['survey_arr'][$key_sv]['sv_detail'] = $fetch_detail;
					}
				}
		}
		}
		$this->home->closeDB();
		$this->foot->closeDB();
		$this->load->view('frontend/course_detail', $arr );
	}
}
?>