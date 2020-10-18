<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Coursemain extends CI_Controller {

	public function all_courses()
	{
		$arr['page'] = 'coursemain/all_courses';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
			if(empty($sess)){
				redirect(base_url().'dashboard/logout?redirect='.$arr['page']) ;
			}
		$arr['emp_c'] = $sess['emp_c'];
		$arr['com_admin'] = $sess['com_admin'];
		$arr['com_id'] = $sess['com_id'];
		$arr['lang'] = $lang;
		$arr['user'] = $sess;
		$this->load->model('Home_model', 'home', FALSE);
		$this->home->loadDB();
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();

		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();

		$this->load->model('Manage_model', 'manage', FALSE);
        $this->manage->loadDB();
    		date_default_timezone_set("Asia/Bangkok");
    		$date_now = date('Y-m-d H:i');
        	$arr['arr_permission'] = $this->manage->chk_permission_page();
			$arr['btn_add'] = $this->manage->chk_permission($arr['page'],'ru_add');
			$arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
			$arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
			$arr['btn_view'] = $this->manage->chk_permission($arr['page'],'ru_view');
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
			$arr['company_arr'] = $this->func_query->query_result('LMS_COMPANY','','','','com_isDelete="0" and com_status="1" and com_id != "1"');
			if($arr['btn_view']!="1"){
				redirect(base_url().'dashboard') ;
			}
			$arr['banner'] = $this->func_query->query_result('LMS_BAN_COS','','','','bc_type="1" and bc_isDelete="0" and bc_status="1"');
			$lang_select = "th";
			if($lang=="english"){
				$lang_select = "eng";
			}else if($lang=="japan"){
				$lang_select = "jp";
			}
			// and LMS_COS.cos_id  in (select distinct cos_id from LMS_COS_DETAIL Left join LMS_COS_DETAIL_UG on LMS_COS_DETAIL.cosde_id = LMS_COS_DETAIL_UG.cosde_id where LMS_COS_DETAIL_UG.posi_id = "'.$sess['posi_id'].'")LMS_COS.com_id="'.$sess['com_id'].'" and com_id="'.$sess['com_id'].'" and 
			$arr['list_coursegroup'] = $this->func_query->query_result('LMS_COG','','','','cg_approve="1" and cg_isDelete="0" and cg_status="1"','cgtitle_en ASC');
			$fetchchk_period = $this->func_query->query_row('LMS_COMPANY_PERIOD','','','','com_id = "'.$sess['com_id'].'" and compe_year = "'.date('Y').'" and (("'.date('m').'" between compe_montha_start and compe_montha_end) or ("'.date('m').'" between compe_monthb_start and compe_monthb_end))');
			if(count($fetchchk_period)>0){
				$arr['list_course'] = $this->func_query->query_result('LMS_COS','','','',' LMS_COS.cos_public="1" and LMS_COS.cos_status="1" and LMS_COS.cos_isDelete="0"','cos_id DESC','LMS_COS.cos_id,LMS_COS.ccode,LMS_COS.cos_lang,LMS_COS.cname_th,LMS_COS.cdesc_th,LMS_COS.cname_eng,LMS_COS.cdesc_eng,LMS_COS.sub_description_th,LMS_COS.sub_description_eng,LMS_COS.cos_pic,LMS_COS.seat_count,LMS_COS.condition');
			}else{
				$arr['list_course'] = array();
			}
			if(count($arr['list_course'])>0){
				foreach ($arr['list_course'] as $key_list => $value_list) {

	                $value_chk = 1;
	                $arr['list_course'][$key_list]['date_start'] = "0000-00-00 00:00:00";
	                $arr['list_course'][$key_list]['date_end'] = "0000-00-00 00:00:00";
	                $fetch_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id="'.$value_list['cos_id'].'" and LMS_COS_DETAIL.cosde_isDelete="0"');
	                if(count($fetch_detail)>0){
	                  if(($fetch_detail['date_start']!="0000-00-00 00:00:00"&&$fetch_detail['date_end']!="0000-00-00 00:00:00")&&(date('Y-m-d H:i',strtotime($fetch_detail['date_start']))>date('Y-m-d H:i')||date('Y-m-d H:i',strtotime($fetch_detail['date_end']))<date('Y-m-d H:i'))){
	                    $value_chk = 0;
	                  }else{
	                    $arr['list_course'][$key_list]['date_start'] = $fetch_detail['date_start'];
	                    $arr['list_course'][$key_list]['date_end'] = $fetch_detail['date_end'];
	                  }
	                }
	                if($value_chk==1){
						$fetch_status = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$value_list['cos_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_isDelete="0"');
						if(count($fetch_status)==0){
							$fetch_chk_ug = $this->func_query->query_result('LMS_COS_POSITION','LMS_TYPECOS','LMS_COS_POSITION.tc_id = LMS_TYPECOS.tc_id','','LMS_COS_POSITION.posi_id = "'.$sess['posi_id'].'" and LMS_COS_POSITION.cos_id = "'.$value_list['cos_id'].'" and LMS_TYPECOS.tc_status = "1"');
							if(count($fetch_chk_ug)==0){
								unset($arr['list_course'][$key_list]);
							}
						}
						if(isset($arr['list_course'][$key_list])){
                  			$result_chkcg = $this->func_query->numrows('LMS_COSINCG','LMS_COG','LMS_COSINCG.cg_id = LMS_COG.cg_id','','LMS_COSINCG.course_id="'.$value_list['cos_id'].'" and LMS_COG.cg_status="1" and LMS_COG.cg_approve="1" and LMS_COG.cg_isDelete="0"');
	                  		if($result_chkcg==0){
	                  			unset($arr['list_course'][$key_list]);
	                  		}
						}
	                }else{
	                  unset($arr['list_course'][$key_list]);
	                }
				}
			}
			if(count($arr['list_course'])>0){
				$arr_cg = array();
				foreach ($arr['list_course'] as $key_list => $value_list) {
					$fetch_seat = $this->func_query->numrows('LMS_COS_ENROLL','','','','cos_id="'.$value_list['cos_id'].'" and cosen_isDelete="0"');
					$arr['list_course'][$key_list]['isseatFull'] = "0";
					if(intval($value_list['seat_count'])>0&&$fetch_seat>=intval($value_list['seat_count'])){
						$arr['list_course'][$key_list]['isseatFull'] = "1";
					}
					$cos_lang = explode(',', $value_list['cos_lang']);
					$value_list['isTH'] = in_array('th',$cos_lang)?"1":"0";
					$value_list['isENG'] = in_array('eng',$cos_lang)?"1":"0";
					$value_list['isJP'] = in_array('jp',$cos_lang)?"1":"0";

					$cname = "";
					$cos_langtxt = "";

		            if($lang=="thai"){
						$cos_langtxt = "th";
		                if($value_list['isTH']=="1"){
		                  $cname = $value_list['cname_th'];
		                }else{
		                  if($cname==""&&$value_list['isENG']=="1"){
		                    $cname = $value_list['cname_eng'];
		                  }
		                }
		            }else{
						$cos_langtxt = "eng";
		                if($value_list['isENG']=="1"){
		                  $cname = $value_list['cname_eng'];
		                }else{
		                  if($cname==""&&$value_list['isTH']=="1"){
		                    $cname = $value_list['cname_th'];
		                  }
		                }
		            }
					//if(in_array($cos_langtxt,$cos_lang)){
						$fetch_cg = $this->func_query->query_result('LMS_COSINCG','','','','course_id="'.$value_list['cos_id'].'" and status_cg="1"');
						$arr['list_course'][$key_list]['cg_arr'] = array();
						if(count($fetch_cg)>0){
							foreach ($fetch_cg as $key_cg => $value_cg) {
								if(!in_array($value_cg['cg_id'], $arr_cg)){
									array_push($arr_cg,$value_cg['cg_id']);
								}
								if(!in_array($value_cg['cg_id'], $arr['list_course'][$key_list]['cg_arr'])){
									array_push($arr['list_course'][$key_list]['cg_arr'],$value_cg['cg_id']);
								}
							}
						}
						$arr['list_course'][$key_list]['isCondition'] = "0";
						$arr['list_course'][$key_list]['msgCondition'] = "";
						if($value_list['condition']!=""){
							$var_cos = "";
							$condition = explode(',', $value_list['condition']);
							if(count($condition)>0){
								$fetch_chk_con = $this->func_query->query_result('LMS_COS','','','','LMS_COS.cos_public="1" and LMS_COS.cos_status="1" and LMS_COS.cos_isDelete="0" and cos_id in ('.$value_list['condition'].')');
								if(count($fetch_chk_con)>0){
									$numloop_chk = 1;
									foreach ($fetch_chk_con as $key_chk_con => $value_chk_con) {
										if($value_chk_con['cos_id']!=$value_list['cos_id']){
											$fetch_chkenroll = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$value_chk_con['cos_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_status="1" and cosen_status_sub="1" and cosen_isDelete="0"');
											if(count($fetch_chkenroll)==0){
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
											}else{					
								            	$fetch_qiz_query = $this->func_query->query_result('LMS_QIZ','','','','quiz_isDelete="0" and quiz_show="1" and cos_id="'.$value_chk_con['cos_id'].'"');
								            	if(count($fetch_qiz_query)>0){
								            		$total_couse = 0;
								            		$val_cosen = 0;
								            		foreach ($fetch_qiz_query as $key_qiz_query => $value_qiz_query) {
														$fetch_chksh_lg = $this->func_query->numrows('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_qiz_query['qiz_id'].'" and ques_status="1" and ques_isDelete="0" and ques_type in ("sub","sa")');
														if($fetch_chksh_lg>0){
															$total_couse++;
															$fetch_chktc_sa = $this->func_query->numrows('LMS_QUES_TC','','','','cosen_id="'.$fetch_chkenroll['cosen_id'].'" and tc_isSavescore="1" and LMS_QUES_TC.ques_id in (select LMS_QUES.ques_id from LMS_QUES where LMS_QUES.qiz_id="'.$value_qiz_query['qiz_id'].'" and ques_status="1" and ques_isDelete="0" and ques_type in ("sub","sa"))');
															if($fetch_chktc_sa>=$fetch_chksh_lg){
																$val_cosen++;
															}
														}

								            		}
								            		if($val_cosen<$total_couse){
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
											}
										}
							                $numloop_chk++;
									}
									if($var_cos!=""){
										$arr['list_course'][$key_list]['isCondition'] = "1";
										$arr['list_course'][$key_list]['msgCondition'] = $var_cos;
									}
								}
							}
						}
						$arr['list_course'][$key_list]['cname'] = $cname;
						$arr['list_course'][$key_list]['seat'] = $this->func_query->numrows('LMS_COS_ENROLL','','','','cos_id="'.$value_list['cos_id'].'" and cosen_isDelete="0"');
						$fetch_status = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$value_list['cos_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_isDelete="0"');
						$arr['list_course'][$key_list]['status'] = label('inProgress');
						if(count($fetch_status)>0){
							//&&$fetch_status['cosen_firsttime']!="0000-00-00 00:00:00"
							$arr['list_course'][$key_list]['isRegister'] = "1";
							if($fetch_status['cosen_status_sub']=="1"){
								$arr['list_course'][$key_list]['status'] = label('done');
							}else if($fetch_status['cosen_status_sub']=="2"){
								$arr['list_course'][$key_list]['status'] = label('inProgress');
							}else if($fetch_status['cosen_status_sub']=="0"){
								//if($fetch_status['cosen_firsttime']=="0000-00-00 00:00:00"){
									$arr['list_course'][$key_list]['status'] = label('not_start');/*
								}else{
									$arr['list_course'][$key_list]['status'] = label('inProgress');
								}*/
							}else{
								$arr['list_course'][$key_list]['status'] = label('inProgress');
							}
						}else{
							$arr['list_course'][$key_list]['status'] = label('r_notregister');
							$arr['list_course'][$key_list]['isRegister'] = "0";
						}
					/*}else{
						unset($arr['list_course'][$key_list]);
					}*/
				}
				if(count($arr['list_coursegroup'])>0){
					foreach ($arr['list_coursegroup'] as $key_cog => $value_cog) {
						$cg_name = "";
						if($lang=="thai"){
							$cg_name = $value_cog['cgtitle_th'];
						}else{
							$cg_name = $value_cog['cgtitle_en'];
						}
						if(!in_array($value_cog['cg_id'], $arr_cg)){
							unset($arr['list_coursegroup'][$key_cog]);
						}else{
							$arr['list_coursegroup'][$key_cog]['cgname'] = $cg_name;
						}
					}
				}
			}else{
				if(count($arr['list_coursegroup'])>0){
					foreach ($arr['list_coursegroup'] as $key_cog => $value_cog) {
							unset($arr['list_coursegroup'][$key_cog]);
					}
				}
			}
		$this->home->closeDB();
		$this->foot->closeDB();
		$this->load->view('frontend/courseall_frontend', $arr );
	}

	public function my_course()
	{
		$arr['page'] = 'coursemain/my_course';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");


			if(empty($sess)){
				redirect(base_url().'dashboard/logout?redirect='.$arr['page']) ;
			}
		$arr['emp_c'] = $sess['emp_c'];
		$arr['com_admin'] = $sess['com_admin'];
		$arr['com_id'] = $sess['com_id'];
		$arr['lang'] = $lang;
		$arr['user'] = $sess;
		$this->load->model('Home_model', 'home', FALSE);
		$this->home->loadDB();
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();

		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();

		$this->load->model('Manage_model', 'manage', FALSE);
        $this->manage->loadDB();
    		date_default_timezone_set("Asia/Bangkok");
    		$date_now = date('Y-m-d H:i');
        	$arr['arr_permission'] = $this->manage->chk_permission_page();
			$arr['btn_add'] = $this->manage->chk_permission($arr['page'],'ru_add');
			$arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
			$arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
			$arr['btn_view'] = $this->manage->chk_permission($arr['page'],'ru_view');
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
			$arr['company_arr'] = $this->func_query->query_result('LMS_COMPANY','','','','com_isDelete="0" and com_status="1" and com_id != "1"');
			if($arr['btn_view']!="1"){
				redirect(base_url().'dashboard') ;
			}
			$arr['banner'] = $this->func_query->query_result('LMS_BAN_COS','','','','bc_type="2" and bc_isDelete="0" and bc_status="1"');
			$lang_select = "th";
			if($lang=="english"){
				$lang_select = "eng";
			}else if($lang=="japan"){
				$lang_select = "jp";
			}
			$arr['list_coursegroup'] = $this->func_query->query_result('LMS_COG','','','','cg_approve="1" and cg_isDelete="0" and cg_status="1"','cgtitle_en ASC');
			//LMS_COS.com_id="'.$sess['com_id'].'" and com_id="'.$sess['com_id'].'" and 

			$fetchchk_period = $this->func_query->query_row('LMS_COMPANY_PERIOD','','','','com_id = "'.$sess['com_id'].'" and compe_year = "'.date('Y').'" and (("'.date('m').'" between compe_montha_start and compe_montha_end) or ("'.date('m').'" between compe_monthb_start and compe_monthb_end))');
			if(count($fetchchk_period)>0){
				$arr['list_course'] = $this->func_query->query_result('LMS_COS','','','','LMS_COS.cos_public="1" and LMS_COS.cos_status="1" and LMS_COS.cos_isDelete="0"','cos_id DESC','LMS_COS.cos_id,LMS_COS.ccode,LMS_COS.cos_lang,LMS_COS.cname_th,LMS_COS.cdesc_th,LMS_COS.cname_eng,LMS_COS.cdesc_eng,LMS_COS.sub_description_th,LMS_COS.sub_description_eng,LMS_COS.cos_pic,LMS_COS.condition');
			}else{
				$arr['list_course'] = array();
			}
			if(count($arr['list_course'])>0){
				foreach ($arr['list_course'] as $key_list => $value_list) {
	                $value_chk = 1;
	                $arr['list_course'][$key_list]['date_start'] = "0000-00-00 00:00:00";
	                $arr['list_course'][$key_list]['date_end'] = "0000-00-00 00:00:00";
	                $fetch_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id="'.$value_list['cos_id'].'" and LMS_COS_DETAIL.cosde_isDelete="0"');
	                if(count($fetch_detail)>0){
	                  if(($fetch_detail['date_start']!="0000-00-00 00:00:00"&&$fetch_detail['date_end']!="0000-00-00 00:00:00")&&(date('Y-m-d H:i',strtotime($fetch_detail['date_start']))>date('Y-m-d H:i')||date('Y-m-d H:i',strtotime($fetch_detail['date_end']))<date('Y-m-d H:i'))){
	                    $value_chk = 0;
	                  }else{
	                    $arr['list_course'][$key_list]['date_start'] = $fetch_detail['date_start'];
	                    $arr['list_course'][$key_list]['date_end'] = $fetch_detail['date_end'];
	                  }
	                }
	                if($value_chk==1){
						$fetch_status = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$value_list['cos_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_isDelete="0"');
						if(count($fetch_status)==0){
							$fetch_chk_ug = $this->func_query->query_result('LMS_COS_POSITION','LMS_TYPECOS','LMS_COS_POSITION.tc_id = LMS_TYPECOS.tc_id','','LMS_COS_POSITION.posi_id = "'.$sess['posi_id'].'" and LMS_COS_POSITION.cos_id = "'.$value_list['cos_id'].'" and LMS_TYPECOS.tc_status = "1"');
							if(count($fetch_chk_ug)==0){
								unset($arr['list_course'][$key_list]);
							}
						}
						if(isset($arr['list_course'][$key_list])){
                  			$result_chkcg = $this->func_query->numrows('LMS_COSINCG','LMS_COG','LMS_COSINCG.cg_id = LMS_COG.cg_id','','LMS_COSINCG.course_id="'.$value_list['cos_id'].'" and LMS_COG.cg_status="1" and LMS_COG.cg_approve="1" and LMS_COG.cg_isDelete="0"');
	                  		if($result_chkcg==0){
	                  			unset($arr['list_course'][$key_list]);
	                  		}
						}
	                }else{
	                  unset($arr['list_course'][$key_list]);
	                }
				}
			}
			
			if(count($arr['list_course'])>0){
				$arr_cg = array();
				foreach ($arr['list_course'] as $key_list => $value_list) {
					$fetch_enroll = $this->func_query->numrows('LMS_COS_ENROLL','','','','cos_id="'.$value_list['cos_id'].'" and emp_id="'.$sess['emp_id'].'"');
					if($fetch_enroll>0){
						$cos_lang = explode(',', $value_list['cos_lang']);
						$value_list['isTH'] = in_array('th',$cos_lang)?"1":"0";
						$value_list['isENG'] = in_array('eng',$cos_lang)?"1":"0";

						$cname = "";
						$cos_langtxt = "";
						if($lang=="thai"){
								$cos_langtxt = "th";
								if($value_list['isTH']=="1"){
									$cname = $value_list['cname_th'];
								}else{
									if($value_list['cname_th']==""){
										$cname = $value_list['cname_eng'];
									}
								}
						}else{
								$cos_langtxt = "eng";
								if($value_list['isENG']=="1"){
									$cname = $value_list['cname_eng'];
								}else{
									if($value_list['cname_eng']==""){
										$cname = $value_list['cname_th'];
									}
								}
						}
						//if(in_array($cos_langtxt,$cos_lang)){
							$fetch_cg = $this->func_query->query_result('LMS_COSINCG','','','','course_id="'.$value_list['cos_id'].'" and status_cg="1"');
							$arr['list_course'][$key_list]['cg_arr'] = array();
							if(count($fetch_cg)>0){
								foreach ($fetch_cg as $key_cg => $value_cg) {
									if(!in_array($value_cg['cg_id'], $arr_cg)){
										array_push($arr_cg,$value_cg['cg_id']);
									}
									if(!in_array($value_cg['cg_id'], $arr['list_course'][$key_list]['cg_arr'])){
										array_push($arr['list_course'][$key_list]['cg_arr'],$value_cg['cg_id']);
									}
								}
							}
							$arr['list_course'][$key_list]['cname'] = $cname;
							$arr['list_course'][$key_list]['seat'] = $this->func_query->numrows('LMS_COS_ENROLL','','','','cos_id="'.$value_list['cos_id'].'" and cosen_isDelete="0"');
							$fetch_status = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$value_list['cos_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_isDelete="0"');
							$arr['list_course'][$key_list]['status'] = label('inProgress');
							if(count($fetch_status)>0){
								$arr['list_course'][$key_list]['isRegister'] = "1";
								if($fetch_status['cosen_status_sub']=="1"){
									$arr['list_course'][$key_list]['status'] = label('done');
								}else if($fetch_status['cosen_status_sub']=="2"){
									$arr['list_course'][$key_list]['status'] = label('inProgress');
								}else if($fetch_status['cosen_status_sub']=="0"){
									//if($fetch_status['cosen_firsttime']=="0000-00-00 00:00:00"){
										$arr['list_course'][$key_list]['status'] = label('not_start');/*
									}else{
										$arr['list_course'][$key_list]['status'] = label('inProgress');
									}*/
								}else{
									$arr['list_course'][$key_list]['status'] = label('inProgress');
								}
							}else{
								$arr['list_course'][$key_list]['status'] = label('r_notregister');
								$arr['list_course'][$key_list]['isRegister'] = "0";
							}

						$arr['list_course'][$key_list]['isCondition'] = "0";
						$arr['list_course'][$key_list]['msgCondition'] = "";
						if($value_list['condition']!=""){
							$var_cos = "";
							$condition = explode(',', $value_list['condition']);
							if(count($condition)>0){
								$fetch_chk_con = $this->func_query->query_result('LMS_COS','','','','LMS_COS.cos_public="1" and LMS_COS.cos_status="1" and LMS_COS.cos_isDelete="0" and cos_id in ('.$value_list['condition'].')');
								if(count($fetch_chk_con)>0){
									$numloop_chk = 1;
									foreach ($fetch_chk_con as $key_chk_con => $value_chk_con) {
										if($value_chk_con['cos_id']!=$value_list['cos_id']){
											$fetch_chkenroll = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$value_chk_con['cos_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_status="1" and cosen_status_sub="1" and cosen_isDelete="0"');
											if(count($fetch_chkenroll)==0){
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
											}else{					
								            	$fetch_qiz_query = $this->func_query->query_result('LMS_QIZ','','','','quiz_isDelete="0" and quiz_show="1" and cos_id="'.$value_chk_con['cos_id'].'"');
								            	if(count($fetch_qiz_query)>0){
								            		$total_couse = 0;
								            		$val_cosen = 0;
								            		foreach ($fetch_qiz_query as $key_qiz_query => $value_qiz_query) {
														$fetch_chksh_lg = $this->func_query->numrows('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_qiz_query['qiz_id'].'" and ques_status="1" and ques_isDelete="0" and ques_type in ("sub","sa")');
														if($fetch_chksh_lg>0){
															$total_couse++;
															$fetch_chktc_sa = $this->func_query->numrows('LMS_QUES_TC','','','','cosen_id="'.$fetch_chkenroll['cosen_id'].'" and tc_isSavescore="1" and LMS_QUES_TC.ques_id in (select LMS_QUES.ques_id from LMS_QUES where LMS_QUES.qiz_id="'.$value_qiz_query['qiz_id'].'" and ques_status="1" and ques_isDelete="0" and ques_type in ("sub","sa"))');
															if($fetch_chktc_sa>=$fetch_chksh_lg){
																$val_cosen++;
															}
														}

								            		}
								            		if($val_cosen<$total_couse){
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
											}
										}
							                $numloop_chk++;
									}
									if($var_cos!=""){
										$arr['list_course'][$key_list]['isCondition'] = "1";
										$arr['list_course'][$key_list]['msgCondition'] = $var_cos;
									}
								}
							}
						}
						/*}else{
							unset($arr['list_course'][$key_list]);
						}*/
					}else{
						unset($arr['list_course'][$key_list]);
					}
				}
				if(count($arr['list_coursegroup'])>0){
					foreach ($arr['list_coursegroup'] as $key_cog => $value_cog) {
						$cg_name = "";
						if($lang=="thai"){
							$cg_name = $value_cog['cgtitle_th'];
						}else{
							$cg_name = $value_cog['cgtitle_en'];
						}
						if(!in_array($value_cog['cg_id'], $arr_cg)){
							unset($arr['list_coursegroup'][$key_cog]);
						}else{
							$arr['list_coursegroup'][$key_cog]['cgname'] = $cg_name;
						}
					}
				}
			}else{
				if(count($arr['list_coursegroup'])>0){
					foreach ($arr['list_coursegroup'] as $key_cog => $value_cog) {
							unset($arr['list_coursegroup'][$key_cog]);
					}
				}
			}
		$this->home->closeDB();
		$this->foot->closeDB();
		$this->load->view('frontend/my_course', $arr );
	}

	public function endcos($cos_id){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    $this->load->model('Course_model', 'course', FALSE);
	    date_default_timezone_set("Asia/Bangkok");
	    $sess = $this->session->userdata("user");
	    $this->func_query->loadDB();
	    $fetch_chkcos = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');
	    if(count($fetch_chkcos)>0){

            $fetch_enroll = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$cos_id.'" and emp_id="'.$sess['emp_id'].'" and cosen_status="1" and cosen_finishtime="0000-00-00 00:00:00" and cosen_lang!="" and cosen_isDelete="0"','cosen_id DESC');
            if(count($fetch_enroll)>0){
            	$cosen_id = $fetch_enroll['cosen_id'];
		    	$status_cos = 0;
		    	$amount_les = 0;
		    	$amount_qiz = 0;
	            $score = 0;
	            $total = 0;
		    	$fetch_qiz = $this->func_query->query_result('LMS_QIZ','','','','cos_id="'.$cos_id.'" and quiz_type="2" and quiz_show="1" and quiz_status="1" and quiz_isDelete="0"');
		    	$num_chk_qiz = 0;
		    	$numloopqiz = 0; 
		    	$numloopqizpass = 0; 
		    	if(count($fetch_qiz)>0){
	              	foreach ($fetch_qiz as $key_qiz => $value_qiz) {
	                    $fetch_chk = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$value_qiz['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and qiz_status="3" and cosen_id="'.$cosen_id.'"','qiztc_id DESC');
	                    if(count($fetch_chk)>0){
	                    	$qizlv_goalscore = 0;
	                    	$fetch_chklv = $this->func_query->query_row('LMS_QIZ_LEVEL','','','','qiz_id="'.$value_qiz['qiz_id'].'" and lv_id = "'.$sess['lv_id'].'"');
	                    	if(count($fetch_chklv)>0){
	                    		$qizlv_goalscore = floatval($fetch_chklv['qizlv_goalscore']);
	                    	}
		              		if($value_qiz['quiz_limit']=="1"){
		              			if($fetch_chk['limit_val']<=intval($value_qiz['quiz_limitval'])){
		              				if(floatval($fetch_chk['per_score'])>=floatval($qizlv_goalscore)){
		              					$numloopqizpass++;
		              				}else{
		              					if($fetch_chk['limit_val']==intval($value_qiz['quiz_limitval'])){
		              						$numloopqizpass++;
		              					}
		              				}
		              			}
		              		}else{
		              				if(floatval($fetch_chk['per_score'])>=floatval($qizlv_goalscore)){
		              					$numloopqizpass++;
		              				}
		              		}
		              	}
		              	$numloopqiz++;
	                    $score_total = 0;
	                    $fetch_chk = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$value_qiz['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and qiz_status="3" and cosen_id="'.$cosen_id.'"','qiztc_id DESC');
	                    if(count($fetch_chk)>0){
	                    	$amount_qiz++;
		                    $fetch_questc = $this->func_query->query_result('LMS_QUES_TC','','','','qiz_id="'.$value_qiz['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'" and qiztc_id="'.$fetch_chk['qiztc_id'].'"');
		                    if(count($fetch_questc)==intval($value_qiz['quiz_numofshown'])){
		                      $num_chk_qiz++;
		                    }
		                    /*if(count($fetch_questc)>0){
			                    foreach ($fetch_questc as $key => $value) {
			                    	$fetch_sum = $this->func_query->query_row('LMS_QUES','','','','ques_id="'.$value['ques_id'].'" and qiz_id="'.$value_qiz['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
			                      	$score_total += count($fetch_sum)>0?floatval($fetch_sum['ques_score']):0;
			                    }
		                    }*/
			                
		                    
		                    $score += count($fetch_chk)>0?floatval($fetch_chk['sum_score']):0;
	                    }
	                    $fetch_sum = $this->func_query->query_row('LMS_QUES','','','','qiz_id="'.$value_qiz['qiz_id'].'" and ques_id in (select LMS_QUES_TC.ques_id from LMS_QUES_TC where qiz_id="'.$value_qiz['qiz_id'].'" and cosen_id="'.$cosen_id.'") and ques_status="1" and ques_isDelete="0"','','SUM(ques_score) as total_score');
		                $total += count($fetch_sum)>0?floatval($fetch_sum['total_score']):0;
	                }
		    	}
		    	$fetch_lesson = $this->func_query->query_result('LMS_LES','','','','cos_id="'.$cos_id.'" and les_isDelete="0" and les_status="1"');
		    	if(count($fetch_lesson)>0){
		    		foreach ($fetch_lesson as $key_lesson => $value_lesson) {
		    			$fetch_lestc = $this->func_query->query_row('LMS_LES_TC','','','','les_id="'.$value_lesson['les_id'].'" and cosen_id="'.$cosen_id.'" and emp_id="'.$sess['emp_id'].'"');
		    			if(count($fetch_lestc)>0){
		    				if($fetch_lestc['learn_status']=="2"){
		    					$amount_les++;
		    				}
		    			}
		    		}
		    	}
		    	$cosen_grade = "";
	            $cosen_score = 0;
	            $cosen_score_per = 0;

	            $cosen_status_sub = '2';
	            $cosen_finishtime = '0000-00-00 00:00:00';
			                	//echo "518:".$total."::".$score;
	            $val_cosen = 0;
	            $total_couse = 0;
	            
	            $fetch_les = $this->func_query->numrows('LMS_LES','','','','les_isDelete="0" and les_status="1" and cos_id="'.$cos_id.'"');
	            $fetch_lestc = $this->func_query->numrows('LMS_LES_TC','','','','learn_status="2" and cosen_id="'.$cosen_id.'"');
	            $fetch_qiz = $this->func_query->numrows('LMS_QIZ','','','','quiz_isDelete="0" and quiz_show="1" and cos_id="'.$cos_id.'" and qiz_id in (select LMS_QUES.qiz_id from LMS_QUES where ques_status = "1" and ques_isDelete = "0")');
	            $fetch_qiztc = $this->func_query->numrows('LMS_QIZ_TC','','','','qiz_status="3" and cosen_id="'.$cosen_id.'"');
	            $fetch_sv = $this->func_query->numrows('LMS_SURVEY','','','','sv_isDelete="0" and sv_status="1" and cos_id="'.$cos_id.'"');
	            $fetch_svtc = $this->func_query->numrows('LMS_QN_USER','','','','qnu_status="1" and cosen_id="'.$cosen_id.'"');
	            if($fetch_les>0){
	            	$total_couse++;
		            if($fetch_les<=$fetch_lestc){
		            	$val_cosen++;
		            }
	            }
	            if($fetch_qiz>0){
	            	$total_couse++;
		            if($fetch_qiz<=$fetch_qiztc){
		            	$val_cosen++;
		            }
	            	$fetch_qiz_query = $this->func_query->query_result('LMS_QIZ','','','','quiz_isDelete="0" and quiz_show="1" and cos_id="'.$cos_id.'"');
	            	if(count($fetch_qiz_query)>0){
	            		foreach ($fetch_qiz_query as $key_qiz_query => $value_qiz_query) {
							$fetch_chksh_lg = $this->func_query->numrows('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_qiz_query['qiz_id'].'" and ques_status="1" and ques_isDelete="0" and ques_type in ("sub","sa")');
							if($fetch_chksh_lg>0){
								$total_couse++;
								$fetch_chktc_sa = $this->func_query->numrows('LMS_QUES_TC','','','','cosen_id="'.$cosen_id.'" and LMS_QUES_TC.ques_id in (select LMS_QUES.ques_id from LMS_QUES where LMS_QUES.qiz_id="'.$value_qiz_query['qiz_id'].'" and ques_status="1" and ques_isDelete="0" and ques_type in ("sub","sa"))');
								if($fetch_chktc_sa>=$fetch_chksh_lg){
									$val_cosen++;
								}
							}

	            		}
	            	}
	            }
	           	$cosen_isActive = 0; 
	            if($total>0){
	            	if($score>=0&&$total>0){
	            		$cosen_score = $score;
			            $cosen_score_per = ($score/$total)*100;
			            $fetch_cug = $this->func_query->query_row('LMS_CUG','','','','course_id="'.$cos_id.'"');
			            if(count($fetch_cug)>0){
			            	if($fetch_chkcos['cos_typegrading']=="1"){
				                if($cosen_score_per>=floatval($fetch_cug['mina_plus'])){
				                  	$cosen_grade = "A+";
				                }else if($cosen_score_per>=floatval($fetch_cug['mina'])){
				                  	$cosen_grade = "A";
				                }else if($cosen_score_per>=floatval($fetch_cug['minb_plus'])){
				                  	$cosen_grade = "B+";
				                }else if($cosen_score_per>=floatval($fetch_cug['minb'])){
				                  	$cosen_grade = "B";
				                }else if($cosen_score_per>=floatval($fetch_cug['minc_plus'])){
				                  	$cosen_grade = "C+";
				                }else if($cosen_score_per>=floatval($fetch_cug['minc'])){
				                  	$cosen_grade = "C";
				                }else if($cosen_score_per>=floatval($fetch_cug['mind_plus'])){
				                  	$cosen_grade = "D+";
				                }else if($cosen_score_per>=floatval($fetch_cug['mind'])){
				                  	$cosen_grade = "D";
				                }else{
				                  	$cosen_grade = "F";
				                }
			            	}else{
			            		if($cosen_score_per>=floatval($fetch_cug['mina'])){
				                  	$cosen_grade = "P";
				                }else{
				                  	$cosen_grade = "F";
				                }
			            	}
			            }
			           	if(floatval($cosen_score_per)>=floatval($fetch_chkcos['goal_score'])){
			                $cosen_status_sub = 1;
			                $cosen_finishtime = date('Y-m-d H:i');
			                $cosen_isActive = 1;
			            }else{
			            	if($numloopqizpass==$numloopqiz){
			            		$cosen_status_sub = 1;
			                	$cosen_finishtime = date('Y-m-d H:i');
			            	}else{
			                	$cosen_status_sub = 2;
			            	}
			            }
		            }
	            }else{
	            	$cosen_score = 100;
	            	$cosen_score_per = 100;
					$cosen_status_sub = 1;
					$cosen_finishtime = date('Y-m-d H:i');

			        $fetch_cug = $this->func_query->query_row('LMS_CUG','','','','course_id="'.$cos_id.'"');
			        if(count($fetch_cug)>0){
			            	if($fetch_chkcos['cos_typegrading']=="1"){
				                if($cosen_score_per>=floatval($fetch_cug['mina_plus'])){
				                  	$cosen_grade = "A+";
				                }else if($cosen_score_per>=floatval($fetch_cug['mina'])){
				                  	$cosen_grade = "A";
				                }else if($cosen_score_per>=floatval($fetch_cug['minb_plus'])){
				                  	$cosen_grade = "B+";
				                }else if($cosen_score_per>=floatval($fetch_cug['minb'])){
				                  	$cosen_grade = "B";
				                }else if($cosen_score_per>=floatval($fetch_cug['minc_plus'])){
				                  	$cosen_grade = "C+";
				                }else if($cosen_score_per>=floatval($fetch_cug['minc'])){
				                  	$cosen_grade = "C";
				                }else if($cosen_score_per>=floatval($fetch_cug['mind_plus'])){
				                  	$cosen_grade = "D+";
				                }else if($cosen_score_per>=floatval($fetch_cug['mind'])){
				                  	$cosen_grade = "D";
				                }else{
				                  	$cosen_grade = "F";
				                }
			            	}else{
			            		if($cosen_score_per>=floatval($fetch_cug['mina'])){
				                  	$cosen_grade = "P";
				                }else{
				                  	$cosen_grade = "F";
				                }
			            	}
			        }
	            }
	            if($total_couse==$val_cosen){
		            if($cosen_finishtime!="0000-00-00 00:00:00"&&$cosen_finishtime!=""){
		            	$fetch_bad = $this->func_query->query_row('LMS_BAD','','','','courses_id="'.$cos_id.'"');
		                if(count($fetch_bad)>0){
		                	$score_pass = 0;
		                	if($fetch_bad['badges_condition']=="P"){
		                		$score_pass = floatval($fetch_cug['mina']);
		                	}else{
		                		if($fetch_bad['badges_condition']=="A+"){
		                			$score_pass = floatval($fetch_cug['mina_plus']);
		                		}else if($fetch_bad['badges_condition']=="A"){
		                			$score_pass = floatval($fetch_cug['mina']);
		                		}else if($fetch_bad['badges_condition']=="B+"){
		                			$score_pass = floatval($fetch_cug['minb_plus']);
		                		}else if($fetch_bad['badges_condition']=="B"){
		                			$score_pass = floatval($fetch_cug['minb']);
		                		}else if($fetch_bad['badges_condition']=="C+"){
		                			$score_pass = floatval($fetch_cug['minc_plus']);
		                		}else if($fetch_bad['badges_condition']=="C"){
		                			$score_pass = floatval($fetch_cug['minc']);
		                		}else if($fetch_bad['badges_condition']=="D+"){
		                			$score_pass = floatval($fetch_cug['mind_plus']);
		                		}else if($fetch_bad['badges_condition']=="D"){
		                			$score_pass = floatval($fetch_cug['mind']);
		                		}else{
		                			$score_pass = 0;
		                		}
		                	}
							$cosen_score_per = round($cosen_score_per);
		                	if($cosen_score_per>=$score_pass){
		                   		$this->course->update_cert($cos_id,$sess);	
		                	}
		                }
		            }
			        $cosen_status_sub = 1;
			       	$cosen_finishtime = date('Y-m-d H:i');
	            }else{
			        $cosen_grade = '';
			        $cosen_score = 0;
			        $cosen_score_per = 0;
			        $cosen_status_sub = 2;
			       	$cosen_finishtime = '0000-00-00 00:00:00';
	            }
            	$arr_update = array(
	            	'cosen_grade' => $cosen_grade,
	            	'cosen_score' => $cosen_score,
	            	'cosen_score_per' => $cosen_score_per,
	            	'cosen_status_sub' => $cosen_status_sub,
	            	'cosen_finishtime' => $cosen_finishtime,
	            	'cosen_modifiedby' => $sess['u_id'],
	            	'cosen_modifieddate' => date('Y-m-d H:i')
	            );

	            if($fetch_qiz>0&&$cosen_status_sub==1){
	            	if(floatval($cosen_score_per)>=floatval($fetch_chkcos['goal_score'])){
	            		$arr_update['cosen_isActive'] = "1";
	            		$cosen_round = intval($fetch_enroll['cosen_round']);
	            		if($cosen_round>1){
	            			$arr_update['cosen_score_per'] = $fetch_chkcos['goal_score'];
	            		}
	            	}else{
	            		$arr_update['cosen_isActive'] = "0";
	            	}
	            }
	            $cosen_point = 0;
	            $cosen_ispoint = 0;
	            if($cosen_status_sub==1&&floatval($cosen_score_per)>=floatval($fetch_chkcos['goal_score'])&&!in_array($cosen_grade, array('','F'))&&isset($sess['emp_join_date'])&&$sess['emp_join_date']!=""&&$sess['emp_join_date']!="0000-00-00"){
							$condif = '';
							if($cosen_grade=="A"){
								$condif = 'coms_a';
							}else if($cosen_grade=="A+"){
								$condif = 'coms_a_plus';
							}else if($cosen_grade=="B"){
								$condif = 'coms_b';
							}else if($cosen_grade=="B+"){
								$condif = 'coms_b_plus';
							}else if($cosen_grade=="C"){
								$condif = 'coms_c';
							}else if($cosen_grade=="C+"){
								$condif = 'coms_c_plus';
							}else if($cosen_grade=="D"){
								$condif = 'coms_d';
							}else if($cosen_grade=="D+"){
								$condif = 'coms_d_plus';
							}
	            	$fetch_comscore = $this->func_query->query_result('LMS_COMPANY_SCORE','','','','com_id = "'.$sess['com_id'].'" and coms_isDelete="0" and coms_status="1" and coms_year="'.date('Y').'"','','coms_amount,coms_cond,coms_type,'.$condif,'coms_id');
	            	if(count($fetch_comscore)>0){
	            			$now = time(); // or your date as well
							$your_date = strtotime($sess['emp_join_date']);
							$datediff = $now - $your_date;
							$empdateagework = round($datediff / (60 * 60 * 24));
							$arr_cond = array();
	            			foreach ($fetch_comscore as $key_comscore => $value_comscore) {
	            				if(intval($value_comscore['coms_amount'])>0){
			            				$value_cond = "-".$value_comscore['coms_amount']." years";
			            				if($value_comscore['coms_type']=="1"){
			            					$value_cond = "-".$value_comscore['coms_amount']." month";
			            				}
										$cond_date = strtotime(date('Y-m-d',strtotime($value_cond)));
										$datediffcond = $now - $cond_date;
										$empdateagecond = round($datediffcond / (60 * 60 * 24));
										$fetch_comscore[$key_comscore]['datediffcond'] = $empdateagecond;
	            				}else{
	            					unset($fetch_comscore[$key_comscore]);
	            				}
	            			}

	            			if(count($fetch_comscore)>0){
	            				$numrow_cond = 1;
	            				foreach ($fetch_comscore as $key_comscore => $value_comscore) {
	            					if($value_comscore['coms_cond']=="1"){
	            						if($empdateagework<=intval($value_comscore['datediffcond'])&&$numrow_cond==1){
	            							$cosen_point = $value_comscore[$condif];
	            						}
	            					}else{
	            						if($empdateagework>intval($value_comscore['datediffcond'])&&$numrow_cond==1){
	            							$cosen_point = $value_comscore[$condif];
	            						}
	            					}
	            					$numrow_cond++;
	            				}
	            				$arr_update['cosen_point'] = $cosen_point;
	            				$fetch_enroll_month = $this->func_query->query_row('LMS_ENROLL_SUMMARY','','','','emp_id = "'.$sess['emp_id'].'" and ensm_month = "'.date('Y-m').'"');
	            				if(count($fetch_enroll_month)==0){
	            					$arr_insert_enrollmonth = array(
	            						'emp_id' => $sess['emp_id'],
	            						'ensm_month' => date('Y-m'),
	            						'ensm_point' => $cosen_point,
	            						'ensm_score' => $cosen_score_per,
	            						'ensm_grade' => $cosen_grade,
	            						'ensm_fullscore' => '100',
	            						'ensm_modifieddate' => date('Y-m-d H:i:s'),
	            					);
	            					$this->db->insert('LMS_ENROLL_SUMMARY',$arr_insert_enrollmonth);
	            					$cosen_ispoint = 1;
	            				}
	            			}
	            	}
	            }
	            $this->db->where('cosen_id',$fetch_enroll['cosen_id']);
	            $this->db->update('LMS_COS_ENROLL',$arr_update);
	            if(isset($arr_update['cosen_point'])&&intval($arr_update['cosen_point'])>0&&$cosen_ispoint==0){
	            	$fetch_enroll_month = $this->func_query->query_row('LMS_ENROLL_SUMMARY','','','','emp_id = "'.$sess['emp_id'].'" and ensm_month = "'.date('Y-m').'"');
	            	if(count($fetch_enroll_month)>0){
	            		$fetch_chkenroll = $this->func_query->query_result('LMS_COS_ENROLL','','','','emp_id = "'.$sess['emp_id'].'" and cosen_finishtime like "%'.date('Y-m').'%" and cosen_status_sub="1"','');
	            		if(count($fetch_chkenroll)>0){
	            			$ensm_point = 0;
	            			$ensm_score = 0;
	            			$ensm_fullscore = 0;
	            			foreach ($fetch_chkenroll as $key_chkenroll => $value_chkenroll) {
	            				$ensm_point += floatval($value_chkenroll['cosen_point']);
		            			$ensm_score += floatval($value_chkenroll['cosen_score_per']);
		            			$ensm_fullscore += 100;
	            			}
	            			$arr_update_enrollmonth = array(
	            				'ensm_point' => $ensm_point,
	            				'ensm_score' => $ensm_score,
	            				'ensm_fullscore' => $ensm_fullscore,
	            				'ensm_modifieddate' => date('Y-m-d H:i:s'),
	            			);
	            			$this->db->where('emp_id',$sess['emp_id']);
	            			$this->db->where('ensm_month',date('Y-m'));
	            			$this->db->update('LMS_ENROLL_SUMMARY',$arr_update_enrollmonth);
	            		}
	            	}
	            }
	            if($cosen_status_sub==1&&$arr_update['cosen_isActive']=="0"&&floatval($cosen_score_per)<floatval($fetch_chkcos['goal_score'])){
	            	$cosen_round = intval($fetch_enroll['cosen_round'])+1;
	                $arr_insert = array(
	                  'cosen_round'=>$cosen_round,
	                  'cos_id'=>$cos_id,
	                  'emp_id'=>$sess['emp_id'],
	                  'cosen_status' => '1',//ผู้เรียนปัจจุบัน
	                  'cosen_isActive' => '1',//ผู้เรียนปัจจุบัน
	                  'cosen_createby' => $sess['u_id'],
	                  'cosen_createdate' => date('Y-m-d H:i'),
	                  'cosen_modifiedby' => $sess['u_id'],
	                  'cosen_modifieddate' => date('Y-m-d H:i'),
	                  'cosen_timerequest' => date('Y-m-d H:i')
	                );
	                $this->db->insert('LMS_COS_ENROLL',$arr_insert);
	            }
            }else{
				$fetch_enroll = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$cos_id.'" and emp_id="'.$sess['emp_id'].'" and cosen_status="1" and cosen_isDelete="0" and cosen_lang!=""','cosen_id DESC');
				if(count($fetch_enroll)>0){
					$cosen_id = $fetch_enroll['cosen_id'];
		    		$fetch_qiz = $this->func_query->query_result('LMS_QIZ','','','','cos_id="'.$cos_id.'" and quiz_type="2" and quiz_show="1" and quiz_status="1" and quiz_isDelete="0"');
		    		if(count($fetch_qiz)>0){
		    				$new_value = 0;
			              	$cosen_round = intval($fetch_enroll['cosen_round']);
			              	foreach ($fetch_qiz as $key_qiz => $value_qiz) {
			                    $num_rechk = $this->func_query->numrows('LMS_QIZ_TC','','','','qiz_id="'.$value_qiz['qiz_id'].'" and qiz_status="3" and cosen_id="'.$cosen_id.'"');
			                    if($cosen_round<$num_rechk){
			                    	$new_value++;
			                    }
			                }
			                if($new_value>0){
			                	$cosen_round++;
						    	$status_cos = 0;
						    	$amount_les = 0;
						    	$amount_qiz = 0;
					            $score = 0;
					            $total = 0;

						    	$num_chk_qiz = 0;
						    	$numloopqiz = 0; 
						    	$numloopqizpass = 0; 
				              	foreach ($fetch_qiz as $key_qiz => $value_qiz) {
				                    $fetch_chk = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$value_qiz['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and qiz_status="3" and cosen_id="'.$cosen_id.'"','qiztc_id DESC');
				                    if(count($fetch_chk)>0){
				                    	$qizlv_goalscore = 0;
				                    	$fetch_chklv = $this->func_query->query_row('LMS_QIZ_LEVEL','','','','qiz_id="'.$value_qiz['qiz_id'].'" and lv_id = "'.$sess['lv_id'].'"');
				                    	if(count($fetch_chklv)>0){
				                    		$qizlv_goalscore = floatval($fetch_chklv['qizlv_goalscore']);
				                    	}
					              		if($value_qiz['quiz_limit']=="1"){
					              			if($fetch_chk['limit_val']<=intval($value_qiz['quiz_limitval'])){
					              				if(floatval($fetch_chk['per_score'])>=floatval($qizlv_goalscore)){
					              					$numloopqizpass++;
					              				}else{
					              					if($fetch_chk['limit_val']==intval($value_qiz['quiz_limitval'])){
					              						$numloopqizpass++;
					              					}
					              				}
					              			}
					              		}else{
					              				if(floatval($fetch_chk['per_score'])>=floatval($qizlv_goalscore)){
					              					$numloopqizpass++;
					              				}
					              		}
					              	}
					              	$numloopqiz++;
				                    $score_total = 0;
				                    $fetch_chk = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$value_qiz['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and qiz_status="3" and cosen_id="'.$cosen_id.'"','qiztc_id DESC');
				                    if(count($fetch_chk)>0){
				                    	$amount_qiz++;
					                    $fetch_questc = $this->func_query->query_result('LMS_QUES_TC','','','','qiz_id="'.$value_qiz['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'" and qiztc_id="'.$fetch_chk['qiztc_id'].'"');
					                    if(count($fetch_questc)==intval($value_qiz['quiz_numofshown'])){
					                      $num_chk_qiz++;
					                    }
					                    /*if(count($fetch_questc)>0){
						                    foreach ($fetch_questc as $key => $value) {
						                    	$fetch_sum = $this->func_query->query_row('LMS_QUES','','','','ques_id="'.$value['ques_id'].'" and qiz_id="'.$value_qiz['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
						                      	$score_total += count($fetch_sum)>0?floatval($fetch_sum['ques_score']):0;
						                    }
					                    }*/
					                    $score += count($fetch_chk)>0?floatval($fetch_chk['sum_score']):0;
					                    
				                    }
				                    $fetch_sum = $this->func_query->query_row('LMS_QUES','','','','qiz_id="'.$value_qiz['qiz_id'].'" and ques_id in (select LMS_QUES_TC.ques_id from LMS_QUES_TC where qiz_id="'.$value_qiz['qiz_id'].'" and cosen_id="'.$cosen_id.'") and ques_status="1" and ques_isDelete="0"','','SUM(ques_score) as total_score');
				                    $total += count($fetch_sum)>0?floatval($fetch_sum['total_score']):0;
				                }

						    	$cosen_grade = "";
					            $cosen_score = 0;
					            $cosen_score_per = 0;

					            $cosen_status_sub = '2';
					            $cosen_finishtime = '0000-00-00 00:00:00';

					            if($total>0){
					            	if($score>=0&&$total>0){
					            		$cosen_score = $score;
							            $cosen_score_per = ($score/$total)*100;
							            $fetch_cug = $this->func_query->query_row('LMS_CUG','','','','course_id="'.$cos_id.'"');
							            if(count($fetch_cug)>0){
							            	if($fetch_chkcos['cos_typegrading']=="1"){
								                if($cosen_score_per>=floatval($fetch_cug['mina_plus'])){
								                  	$cosen_grade = "A+";
								                }else if($cosen_score_per>=floatval($fetch_cug['mina'])){
								                  	$cosen_grade = "A";
								                }else if($cosen_score_per>=floatval($fetch_cug['minb_plus'])){
								                  	$cosen_grade = "B+";
								                }else if($cosen_score_per>=floatval($fetch_cug['minb'])){
								                  	$cosen_grade = "B";
								                }else if($cosen_score_per>=floatval($fetch_cug['minc_plus'])){
								                  	$cosen_grade = "C+";
								                }else if($cosen_score_per>=floatval($fetch_cug['minc'])){
								                  	$cosen_grade = "C";
								                }else if($cosen_score_per>=floatval($fetch_cug['mind_plus'])){
								                  	$cosen_grade = "D+";
								                }else if($cosen_score_per>=floatval($fetch_cug['mind'])){
								                  	$cosen_grade = "D";
								                }else{
								                  	$cosen_grade = "F";
								                }
							            	}else{
							            		if($cosen_score_per>=floatval($fetch_cug['mina'])){
								                  	$cosen_grade = "P";
								                }else{
								                  	$cosen_grade = "F";
								                }
							            	}
							            }
							           	if(floatval($cosen_score_per)>=floatval($fetch_chkcos['goal_score'])){
							                $cosen_status_sub = 1;
							                $cosen_finishtime = date('Y-m-d H:i');
							            }else{
							            	if($numloopqizpass==$numloopqiz){
							            		$cosen_status_sub = 1;
							                	$cosen_finishtime = date('Y-m-d H:i');
							            	}else{
							                	$cosen_status_sub = 2;
							            	}
							            }
						            }


							            $val_cosen = 0;
							            $total_couse = 0;
							            
							            $fetch_les = $this->func_query->numrows('LMS_LES','','','','les_isDelete="0" and les_status="1" and cos_id="'.$cos_id.'"');
							            $fetch_lestc = $this->func_query->numrows('LMS_LES_TC','','','','learn_status="2" and cosen_id="'.$cosen_id.'"');
							            $fetch_qiz = $this->func_query->numrows('LMS_QIZ','','','','quiz_isDelete="0" and quiz_show="1" and cos_id="'.$cos_id.'"');
							            $fetch_qiztc = $this->func_query->numrows('LMS_QIZ_TC','','','','qiz_status="3" and cosen_id="'.$cosen_id.'"');
							            $fetch_sv = $this->func_query->numrows('LMS_SURVEY','','','','sv_isDelete="0" and sv_status="1" and cos_id="'.$cos_id.'"');
							            $fetch_svtc = $this->func_query->numrows('LMS_QN_USER','','','','qnu_status="1" and cosen_id="'.$cosen_id.'"');
							            if($fetch_les>0){
							            	$total_couse++;
								            if($fetch_les<=$fetch_lestc){
								            	$val_cosen++;
								            }
							            }
							            if($fetch_qiz>0){
							            	$total_couse++;
								            if($fetch_qiz<=$fetch_qiztc){
								            	$val_cosen++;
								            }
							            }
							            /*if($fetch_sv>0){
							            	$total_couse++;
								            if($fetch_sv==$fetch_svtc){
								            	$val_cosen++;
								            }
							            }*/
								        $score_pass = 0;
							            if($total_couse==$val_cosen){
								            if($cosen_finishtime!="0000-00-00 00:00:00"&&$cosen_finishtime!=""){
								            	$fetch_bad = $this->func_query->query_row('LMS_BAD','','','','courses_id="'.$cos_id.'"');
								                if(count($fetch_bad)>0){
								                	if($fetch_bad['badges_condition']=="P"){
								                		$score_pass = floatval($fetch_cug['mina']);
								                	}else{
								                		if($fetch_bad['badges_condition']=="A+"){
								                			$score_pass = floatval($fetch_cug['mina_plus']);
								                		}else if($fetch_bad['badges_condition']=="A"){
								                			$score_pass = floatval($fetch_cug['mina']);
								                		}else if($fetch_bad['badges_condition']=="B+"){
								                			$score_pass = floatval($fetch_cug['minb_plus']);
								                		}else if($fetch_bad['badges_condition']=="B"){
								                			$score_pass = floatval($fetch_cug['minb']);
								                		}else if($fetch_bad['badges_condition']=="C+"){
								                			$score_pass = floatval($fetch_cug['minc_plus']);
								                		}else if($fetch_bad['badges_condition']=="C"){
								                			$score_pass = floatval($fetch_cug['minc']);
								                		}else if($fetch_bad['badges_condition']=="D+"){
								                			$score_pass = floatval($fetch_cug['mind_plus']);
								                		}else if($fetch_bad['badges_condition']=="D"){
								                			$score_pass = floatval($fetch_cug['mind']);
								                		}else{
								                			$score_pass = 0;
								                		}
								                	}
	            
								                	if($cosen_score_per>=$score_pass){
								                   		$this->course->update_cert($cos_id,$sess);	
								                	}
								                }
								            }
									        $cosen_status_sub = 1;
									       	$cosen_finishtime = date('Y-m-d H:i');
							            }else{
									        $cosen_grade = '';
									        $cosen_score = 0;
									        $cosen_score_per = 0;
									        $cosen_status_sub = 2;
									       	$cosen_finishtime = '0000-00-00 00:00:00';
							            }
							            $cosen_score_per = round($cosen_score_per);
						            	$arr_update = array(
						            		'cosen_round' => $cosen_round,
							            	'cosen_grade' => $cosen_grade,
							            	'cosen_score' => $cosen_score,
							            	'cosen_score_per' => $cosen_score_per,
							            	'cosen_status_sub' => $cosen_status_sub,
							            	'cosen_finishtime' => $cosen_finishtime,
							            	'cosen_modifiedby' => $sess['u_id'],
							            	'cosen_modifieddate' => date('Y-m-d H:i')
							            );
							            $this->db->where('cosen_id',$fetch_enroll['cosen_id']);
							            $this->db->update('LMS_COS_ENROLL',$arr_update);
					            }
			                }
		    		}
				}
            }
            
	    }
	}

	public function endcos_update($cos_id,$emp_id){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    $this->load->model('Course_model', 'course', FALSE);
	    date_default_timezone_set("Asia/Bangkok");
	    $sess = $this->session->userdata("user");
	    $this->func_query->loadDB();
	    $fetch_chkcos = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');
	    if(count($fetch_chkcos)>0){
	    	$fetch_emp = $this->func_query->query_row('LMS_EMP','','','','emp_id = "'.$emp_id.'"');
            $fetch_enroll = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$cos_id.'" and emp_id="'.$emp_id.'" and cosen_isDelete="0" and cosen_lang!=""','cosen_id DESC');
            if(count($fetch_enroll)>0){
            	$cosen_id = $fetch_enroll['cosen_id'];
		    	$status_cos = 0;
		    	$amount_les = 0;
		    	$amount_qiz = 0;
	            $score = 0;
	            $total = 0;
		    	$fetch_qiz = $this->func_query->query_result('LMS_QIZ','','','','cos_id="'.$cos_id.'" and quiz_type="2" and quiz_show="1" and quiz_status="1" and quiz_isDelete="0"');
		    	$num_chk_qiz = 0;
		    	$numloopqiz = 0; 
		    	$numloopqizpass = 0; 
		    	if(count($fetch_qiz)>0){
	              	foreach ($fetch_qiz as $key_qiz => $value_qiz) {
	                    $fetch_chk = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$value_qiz['qiz_id'].'" and emp_id="'.$emp_id.'" and qiz_status="3" and cosen_id="'.$cosen_id.'"','qiztc_id DESC');
	                    if(count($fetch_chk)>0){
				            $qizlv_goalscore = 0;
				            $fetch_chklv = $this->func_query->query_row('LMS_QIZ_LEVEL','','','','qiz_id="'.$value_qiz['qiz_id'].'" and lv_id = "'.$fetch_emp['lv_id'].'"');
				            if(count($fetch_chklv)>0){
				             	$qizlv_goalscore = floatval($fetch_chklv['qizlv_goalscore']);
				            }
		              		if($value_qiz['quiz_limit']=="1"){
		              			if($fetch_chk['limit_val']<=intval($value_qiz['quiz_limitval'])){
		              				if(floatval($fetch_chk['per_score'])>=floatval($qizlv_goalscore)){
		              					$numloopqizpass++;
		              				}else{
		              					if($fetch_chk['limit_val']==intval($value_qiz['quiz_limitval'])){
		              						$numloopqizpass++;
		              					}
		              				}
		              			}
		              		}else{
		              				if(floatval($fetch_chk['per_score'])>=floatval($qizlv_goalscore)){
		              					$numloopqizpass++;
		              				}
		              		}
		              	}
		              	$numloopqiz++;
	                    $score_total = 0;
	                    $fetch_chk = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$value_qiz['qiz_id'].'" and emp_id="'.$emp_id.'" and qiz_status="3" and cosen_id="'.$cosen_id.'"','qiztc_id DESC');
	                    if(count($fetch_chk)>0){
	                    	$amount_qiz++;
		                    $fetch_questc = $this->func_query->query_result('LMS_QUES_TC','','','','qiz_id="'.$value_qiz['qiz_id'].'" and emp_id="'.$emp_id.'" and cosen_id="'.$cosen_id.'" and qiztc_id="'.$fetch_chk['qiztc_id'].'"');
		                    if(count($fetch_questc)==intval($value_qiz['quiz_numofshown'])){
		                      $num_chk_qiz++;
		                    }
		                    $score += count($fetch_chk)>0?floatval($fetch_chk['sum_score']):0;
	                    }
	                    $fetch_sum = $this->func_query->query_row('LMS_QUES','','','','qiz_id="'.$value_qiz['qiz_id'].'" and ques_id in (select LMS_QUES_TC.ques_id from LMS_QUES_TC where qiz_id="'.$value_qiz['qiz_id'].'" and cosen_id="'.$cosen_id.'") and ques_status="1" and ques_isDelete="0"','','SUM(ques_score) as total_score');
		                $total += count($fetch_sum)>0?floatval($fetch_sum['total_score']):0;
	                }
		    	}
		    	$cosen_grade = "";
	            $cosen_score = 0;
	            $cosen_score_per = 0;

	            $cosen_status_sub = '2';
	            $cosen_finishtime = '0000-00-00 00:00:00';
			                	//echo "518:".$total."::".$score;
	            if($total>0){
	            	if($score>=0&&$total>0){
	            		$cosen_score = $score;
			            $cosen_score_per = ($score/$total)*100;
			            $fetch_cug = $this->func_query->query_row('LMS_CUG','','','','course_id="'.$cos_id.'"');
			            if(count($fetch_cug)>0){
			            	if($fetch_chkcos['cos_typegrading']=="1"){
				                if($cosen_score_per>=floatval($fetch_cug['mina_plus'])){
				                  	$cosen_grade = "A+";
				                }else if($cosen_score_per>=floatval($fetch_cug['mina'])){
				                  	$cosen_grade = "A";
				                }else if($cosen_score_per>=floatval($fetch_cug['minb_plus'])){
				                  	$cosen_grade = "B+";
				                }else if($cosen_score_per>=floatval($fetch_cug['minb'])){
				                  	$cosen_grade = "B";
				                }else if($cosen_score_per>=floatval($fetch_cug['minc_plus'])){
				                  	$cosen_grade = "C+";
				                }else if($cosen_score_per>=floatval($fetch_cug['minc'])){
				                  	$cosen_grade = "C";
				                }else if($cosen_score_per>=floatval($fetch_cug['mind_plus'])){
				                  	$cosen_grade = "D+";
				                }else if($cosen_score_per>=floatval($fetch_cug['mind'])){
				                  	$cosen_grade = "D";
				                }else{
				                  	$cosen_grade = "F";
				                }
			            	}else{
			            		if($cosen_score_per>=floatval($fetch_cug['mina'])){
				                  	$cosen_grade = "P";
				                }else{
				                  	$cosen_grade = "F";
				                }
			            	}
			            }
			           	if(floatval($cosen_score_per)>=floatval($fetch_chkcos['goal_score'])){
			                $cosen_status_sub = 1;
			                $cosen_finishtime = date('Y-m-d H:i');
			            }else{
			            	if($numloopqizpass==$numloopqiz){
			            		$cosen_status_sub = 1;
			                	$cosen_finishtime = date('Y-m-d H:i');
			            	}else{
			                	$cosen_status_sub = 2;
			            	}
			            }
		            }
	            }else{
	            	$cosen_score = 100;
	            	$cosen_score_per = 100;

			        $fetch_cug = $this->func_query->query_row('LMS_CUG','','','','course_id="'.$cos_id.'"');
			        if(count($fetch_cug)>0){
			            	if($fetch_chkcos['cos_typegrading']=="1"){
				                if($cosen_score_per>=floatval($fetch_cug['mina_plus'])){
				                  	$cosen_grade = "A+";
				                }else if($cosen_score_per>=floatval($fetch_cug['mina'])){
				                  	$cosen_grade = "A";
				                }else if($cosen_score_per>=floatval($fetch_cug['minb_plus'])){
				                  	$cosen_grade = "B+";
				                }else if($cosen_score_per>=floatval($fetch_cug['minb'])){
				                  	$cosen_grade = "B";
				                }else if($cosen_score_per>=floatval($fetch_cug['minc_plus'])){
				                  	$cosen_grade = "C+";
				                }else if($cosen_score_per>=floatval($fetch_cug['minc'])){
				                  	$cosen_grade = "C";
				                }else if($cosen_score_per>=floatval($fetch_cug['mind_plus'])){
				                  	$cosen_grade = "D+";
				                }else if($cosen_score_per>=floatval($fetch_cug['mind'])){
				                  	$cosen_grade = "D";
				                }else{
				                  	$cosen_grade = "F";
				                }
			            	}else{
			            		if($cosen_score_per>=floatval($fetch_cug['mina'])){
				                  	$cosen_grade = "P";
				                }else{
				                  	$cosen_grade = "F";
				                }
			            	}
			        }
			        
	            }
	            $val_cosen = 0;
	            $total_couse = 0;
	            $fetch_les = $this->func_query->numrows('LMS_LES','','','','les_isDelete="0" and les_status="1" and cos_id="'.$cos_id.'"');
	            $fetch_lestc = $this->func_query->numrows('LMS_LES_TC','','','','learn_status="2" and cosen_id="'.$cosen_id.'"');
	            $fetch_qiz = $this->func_query->numrows('LMS_QIZ','','','','quiz_isDelete="0" and quiz_show="1" and cos_id="'.$cos_id.'"');
	            $fetch_qiztc = $this->func_query->numrows('LMS_QIZ_TC','','','','qiz_status="3" and cosen_id="'.$cosen_id.'"');
	            $fetch_sv = $this->func_query->numrows('LMS_SURVEY','','','','sv_isDelete="0" and sv_status="1" and cos_id="'.$cos_id.'"');
	            $fetch_svtc = $this->func_query->numrows('LMS_QN_USER','','','','qnu_status="1" and cosen_id="'.$cosen_id.'"');
	            if($fetch_les>0){
	            	$total_couse++;
		            if($fetch_les<=$fetch_lestc){
		            	$val_cosen++;
		            }
	            }
	            if($fetch_qiz>0){
	            	$total_couse++;
		            if($fetch_qiz<=$fetch_qiztc){
		            	$val_cosen++;
		            }
	            	$fetch_qiz_query = $this->func_query->query_result('LMS_QIZ','','','','quiz_isDelete="0" and quiz_show="1" and cos_id="'.$cos_id.'"');
	            	if(count($fetch_qiz_query)>0){
	            		foreach ($fetch_qiz_query as $key_qiz_query => $value_qiz_query) {
							$fetch_chksh_lg = $this->func_query->numrows('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_qiz_query['qiz_id'].'" and ques_status="1" and ques_isDelete="0" and ques_type in ("sub","sa")');
							if($fetch_chksh_lg>0){
								$total_couse++;
								$fetch_chktc_sa = $this->func_query->numrows('LMS_QUES_TC','','','','cosen_id="'.$cosen_id.'" and tc_isSavescore="1" and LMS_QUES_TC.ques_id in (select LMS_QUES.ques_id from LMS_QUES where LMS_QUES.qiz_id="'.$value_qiz_query['qiz_id'].'" and ques_status="1" and ques_isDelete="0" and ques_type in ("sub","sa"))');
								if($fetch_chktc_sa>=$fetch_chksh_lg){
									$val_cosen++;
								}
							}

	            		}
	            	}
	            }
	            if($total_couse==$val_cosen){
		            if($cosen_finishtime!="0000-00-00 00:00:00"&&$cosen_finishtime!=""){
		            	$fetch_bad = $this->func_query->query_row('LMS_BAD','','','','courses_id="'.$cos_id.'"');
		                if(count($fetch_bad)>0){
		                	$score_pass = 0;
		                	if($fetch_bad['badges_condition']=="P"){
		                		$score_pass = floatval($fetch_cug['mina']);
		                	}else{
		                		if($fetch_bad['badges_condition']=="A+"){
		                			$score_pass = floatval($fetch_cug['mina_plus']);
		                		}else if($fetch_bad['badges_condition']=="A"){
		                			$score_pass = floatval($fetch_cug['mina']);
		                		}else if($fetch_bad['badges_condition']=="B+"){
		                			$score_pass = floatval($fetch_cug['minb_plus']);
		                		}else if($fetch_bad['badges_condition']=="B"){
		                			$score_pass = floatval($fetch_cug['minb']);
		                		}else if($fetch_bad['badges_condition']=="C+"){
		                			$score_pass = floatval($fetch_cug['minc_plus']);
		                		}else if($fetch_bad['badges_condition']=="C"){
		                			$score_pass = floatval($fetch_cug['minc']);
		                		}else if($fetch_bad['badges_condition']=="D+"){
		                			$score_pass = floatval($fetch_cug['mind_plus']);
		                		}else if($fetch_bad['badges_condition']=="D"){
		                			$score_pass = floatval($fetch_cug['mind']);
		                		}else{
		                			$score_pass = 0;
		                		}
		                	}
							$cosen_score_per = round($cosen_score_per);
		                	if($cosen_score_per>=$score_pass){
		                   		$this->course->update_cert_answer($cos_id,$emp_id);	
		                	}
		                }
		            }
			        $cosen_status_sub = 1;
			       	$cosen_finishtime = date('Y-m-d H:i');
	            }else{
			        $cosen_grade = '';
			        $cosen_score = 0;
			        $cosen_score_per = 0;
			        $cosen_status_sub = 2;
			       	$cosen_finishtime = '0000-00-00 00:00:00';
	            }

	            	//'cosen_finishtime' => $cosen_finishtime,
            	$arr_update = array(
	            	'cosen_grade' => $cosen_grade,
	            	'cosen_score' => $cosen_score,
	            	'cosen_score_per' => $cosen_score_per,
	            	'cosen_status_sub' => $cosen_status_sub,
	            	'cosen_modifiedby' => $sess['u_id'],
	            	'cosen_modifieddate' => date('Y-m-d H:i')
	            );

	            if($fetch_qiz>0&&$cosen_status_sub==1){
	            	if(floatval($cosen_score_per)>=floatval($fetch_chkcos['goal_score'])){
	            		$arr_update['cosen_isActive'] = "1";
	            	}else{
	            		$arr_update['cosen_isActive'] = "0";
	            	}
	            }

	            $this->db->where('cosen_id',$fetch_enroll['cosen_id']);
	            $this->db->update('LMS_COS_ENROLL',$arr_update);

	            if($cosen_status_sub==1&&$arr_update['cosen_isActive']=="0"){
	                $arr_insert = array(
	                  'cos_id'=>$cos_id,
	                  'emp_id'=>$sess['emp_id'],
	                  'cosen_status' => '1',//ผู้เรียนปัจจุบัน
	                  'cosen_isActive' => '1',//ผู้เรียนปัจจุบัน
	                  'cosen_createby' => $sess['u_id'],
	                  'cosen_createdate' => date('Y-m-d H:i'),
	                  'cosen_modifiedby' => $sess['u_id'],
	                  'cosen_modifieddate' => date('Y-m-d H:i'),
	                  'cosen_timerequest' => date('Y-m-d H:i')
	                );
	                $this->db->insert('LMS_COS_ENROLL',$arr_insert);
	            }
            }
            
	    }
	}

	public function detail($cos_id,$lang_again="")
	{
		$arr['page'] = 'coursemain/detail/'.$cos_id;
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
		                    	$qizlv_goalscore = 0;
		                    	$fetch_chklv = $this->func_query->query_row('LMS_QIZ_LEVEL','','','','qiz_id="'.$value_pretest['qiz_id'].'" and lv_id = "'.$sess['lv_id'].'"');
		                    	if(count($fetch_chklv)>0){
		                    		$qizlv_goalscore = floatval($fetch_chklv['qizlv_goalscore']);
		                    	}
		                        $fetch_chk_ques = $this->func_query->query_row('LMS_QUES','','','','qiz_id="'.$value_pretest['qiz_id'].'" and ques_isDelete="0"','','sum(LMS_QUES.ques_score) as total_score');
		                        $arr['pretest_arr'][$key_pretest]['fullscore'] = floatval($fetch_chk_ques['total_score']);
								$arr['pretest_arr'][$key_pretest]['isNull'] = "0";
								$arr['pretest_arr'][$key_pretest]['status_tc'] = $fetch_chktc['qiz_status'];
								$arr['pretest_arr'][$key_pretest]['sum_score'] = $fetch_chktc['sum_score'];
								$arr['pretest_arr'][$key_pretest]['per_score'] = $fetch_chktc['per_score'];

		                        $arr['pretest_arr'][$key_pretest]['statustxt'] = floatval($fetch_chktc['per_score'])>=floatval($qizlv_goalscore)?'Pass':'Fail';
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
											if(floatval($fetch_chktc['per_score'])>=floatval($qizlv_goalscore)){
												if($fetch_chktc['qiz_status']=="3"){
													$arr['pretest_arr'][$key_pretest]['endstatus'] = "1";
												}
											}
										}
									}
								}else{
											if(floatval($fetch_chktc['per_score'])>=floatval($qizlv_goalscore)){
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
								    if(floatval($fetch_chktc['per_score'])<floatval($qizlv_goalscore)&&$fetch_chksh_lg==0){
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
		                    	$qizlv_goalscore = 0;
		                    	$fetch_chklv = $this->func_query->query_row('LMS_QIZ_LEVEL','','','','qiz_id="'.$value_posttest['qiz_id'].'" and lv_id = "'.$sess['lv_id'].'"');
		                    	if(count($fetch_chklv)>0){
		                    		$qizlv_goalscore = floatval($fetch_chklv['qizlv_goalscore']);
		                    	}
		                        $fetch_chk_ques = $this->func_query->query_row('LMS_QUES','','','','qiz_id="'.$value_posttest['qiz_id'].'" and ques_isDelete="0"','','sum(LMS_QUES.ques_score) as total_score');
		                        $arr['posttest_arr'][$key_posttest]['fullscore'] = floatval($fetch_chk_ques['total_score']);
								$arr['posttest_arr'][$key_posttest]['isNull'] = "0";
								$arr['posttest_arr'][$key_posttest]['status_tc'] = $fetch_chktc['qiz_status'];
								$arr['posttest_arr'][$key_posttest]['sum_score'] = $fetch_chktc['sum_score'];
								$arr['posttest_arr'][$key_posttest]['per_score'] = $fetch_chktc['per_score'];

		                        $arr['posttest_arr'][$key_posttest]['statustxt'] = floatval($fetch_chktc['per_score'])>=floatval($qizlv_goalscore)?'Pass':'Fail';
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
										/*if(floatval($qizlv_goalscore)==0){
											if(floatval($fetch_chktc['per_score'])>0){
												if($fetch_chktc['qiz_status']=="3"){
													$arr['posttest_arr'][$key_posttest]['endstatus'] = "1";
												}
											}
										}else{*/
											if(floatval($fetch_chktc['per_score'])>=floatval($qizlv_goalscore)){
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
											if(floatval($fetch_chktc['per_score'])>=floatval($qizlv_goalscore)){
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
								    if(floatval($fetch_chktc['per_score'])<floatval($qizlv_goalscore)&&$fetch_chksh_lg==0){
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
