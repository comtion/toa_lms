<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$arr['lang'] = $lang;
		$arr['page'] = "dashboard";

    	$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	    $this->load->model('Manage_model', 'manage', FALSE);
	    $this->manage->loadDB();
	    $this->load->model('Dashboard_model', 'dashboard', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
	    $this->dashboard->loadDB();
	    $arr['arr_permission'] = $this->manage->chk_permission_page();
		$this->load->model('User_model', 'login', FALSE);
		$this->load->model('Home_model', 'home', FALSE);
		$this->home->loadDB();
		if($this->login->checkSession($arr['page'])){
			$sess = $this->session->userdata("user");
    		date_default_timezone_set("Asia/Bangkok");
			
			$arr['emp_c'] = $sess['emp_c'];
			$arr['com_admin'] = $sess['com_admin'];
			$arr['com_id'] = $sess['com_id'];
			$arr['user'] = $sess;	
			$arr['thaimonth'] = $thaimonth;	
			$arr_role_fd = array();

			$fetch_chkfirsttime = $this->func_query->query_row('LMS_EMP','','','','emp_id="'.$sess['emp_id'].'"');
			$arr['emp_firsttime'] = isset($fetch_chkfirsttime['emp_firsttime'])?$fetch_chkfirsttime['emp_firsttime']:"";
			if($arr['emp_firsttime']=="1"){
				$fetch_company = $this->func_query->query_row('LMS_COMPANY','','','','com_id="'.$sess['com_id'].'"');
				$fetch_detail = $this->func_query->query_row('LMS_ABOUT','','','','da_id="1"');
				$arr_welcome = array();
				$arr_welcome['wctitle_a'] = $fetch_detail['da_wctitle_th'];
				$arr_welcome['wcmessage_a'] = $fetch_detail['da_wcmessage_th'];
				$arr_welcome['wctitle_b'] = $fetch_company['com_wctitle_th'];
				$arr_welcome['wcmessage_b'] = $fetch_company['com_wcmessage_th'];

				if($lang=="english"){
					$arr_welcome['wctitle_a'] = $fetch_detail['da_wctitle_en'];
					$arr_welcome['wcmessage_a'] = $fetch_detail['da_wcmessage_en'];
					$arr_welcome['wctitle_b'] = $fetch_company['com_wctitle_eng'];
					$arr_welcome['wcmessage_b'] = $fetch_company['com_wcmessage_eng'];
				}
				$arr['arr_welcome'] = $arr_welcome;
				$arr['arr_msg_confirm'] = $this->func_query->query_result('LMS_CONFIRMMSG','','','','conmsg_isDelete="0" and conmsg_status="1"');
			}

			$arr_year = array();
			$arr_month = array();
			if($sess['Is_admin']=="1"||$sess['Is_instructor']=="1"){
				$fetch_select = $this->func_query->query_result('LMS_COS','','','','LMS_COS.cos_isDelete = 0','','YEAR(cos_createdate) as year_select,MONTH(cos_createdate) as month_select');
				if(count($fetch_select)>0){
						foreach ($fetch_select as $key_select => $value_select) {
								if(!in_array($value_select['year_select'], $arr_year)){
									array_push($arr_year, $value_select['year_select']);
								}
								if(intval($value_select['month_select'])<10){
									$value_select['month_select'] = "0".$value_select['month_select'];
								}
								if(!in_array($value_select['month_select'], $arr_month)){
									array_push($arr_month, $value_select['month_select']);
								}
						}
				}
				$arr['arr_year'] = $arr_year;
				$arr['arr_month'] = $arr_month;
				$arr_year = array();
				$arr_month = array();
				$fetch_lg = $this->func_query->query_result('LMS_LG','','','','LMS_LG.emp_id in (select LMS_EMP.emp_id from LMS_EMP where LMS_EMP.com_id = "'.$sess['com_id'].'" and emp_isDelete = "0") and log_time!="0000-00-00 00:00:00" and massage like "%logged in success%"','','YEAR(log_time) as year_select,MONTH(log_time) as month_select');
				if(count($fetch_lg)>0){
						foreach ($fetch_lg as $key_lg => $value_lg) {
									if(!in_array($value_lg['year_select'], $arr_year)){
										array_push($arr_year, $value_lg['year_select']);
									}
									if(intval($value_lg['month_select'])<10){
										$value_lg['month_select'] = "0".$value_lg['month_select'];
									}
									if(!in_array($value_lg['month_select'], $arr_month)){
										array_push($arr_month, $value_lg['month_select']);
									}
						}
				}
				$arr['arr_year_log'] = $arr_year;
				$arr['arr_month_log'] = $arr_month;
			}
			$arr_year = array();
			$arr_month = array();
			$fetch_enroll = $this->func_query->query_result('LMS_COS_ENROLL','','','','LMS_COS_ENROLL.emp_id = "'.$sess['emp_id'].'" and LMS_COS_ENROLL.cosen_isActive = "1" and cosen_finishtime!="0000-00-00 00:00:00" and cosen_isDelete = "0"','','YEAR(cosen_finishtime) as year_select,MONTH(cosen_finishtime) as month_select');
			if(count($fetch_enroll)>0){
					foreach ($fetch_enroll as $key_enroll => $value_enroll) {
								if(!in_array($value_enroll['year_select'], $arr_year)){
									array_push($arr_year, $value_enroll['year_select']);
								}
									if(intval($value_enroll['month_select'])<10){
										$value_enroll['month_select'] = "0".$value_enroll['month_select'];
									}
								if(!in_array($value_enroll['month_select'], $arr_month)){
									array_push($arr_month, $value_enroll['month_select']);
								}
					}
			}
			$arr['arr_year_enroll'] = $arr_year;
			$arr['arr_month_enroll'] = $arr_month;
			$arr['fetch_typecos'] = $this->func_query->query_result('LMS_TYPECOS','','','','com_id = "'.$sess['com_id'].'" and tc_status = "1"');

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
			
			$arr['profile'] = $this->manage->query_data_onupdate($arr['user']['u_id'], 'LMS_USP','u_id');
			$arr['course_total'] = $this->manage->course_total();

			$PC_log = $this->dashboard->log_usersys('PC');
			$Mobile_log = $this->dashboard->log_usersys('Mobile');
			$Tablet_log = $this->dashboard->log_usersys('Tablet');
			$arr['course_select'] = $this->dashboard->course_select();

			/*$arr['coursetotal'] = $this->manage->countamount_emp('coursetotal');
			$arr['enroll'] = $this->manage->countamount_emp('enroll');
			$arr['success'] = $this->manage->countamount_emp('success');
			$arr['inProcess'] = $this->manage->countamount_emp('inProcess');
			$arr['not_start'] = $this->manage->countamount_emp('not_start');*/
			

			$arr['company_arr'] = $this->func_query->query_result('LMS_COMPANY','','','','com_isDelete="0" and com_status="1" and com_id != "1"');

			if(!isset($PC_log)){
				$PC_log = 0;
			}
			if(!isset($Mobile_log)){
				$Mobile_log = 0;
			}
			if(!isset($Tablet_log)){
				$Tablet_log = 0;
			}
			$total_log = $PC_log+$Mobile_log+$Tablet_log;
			$arr['PC_log'] = $total_log>0?number_format(($PC_log/$total_log)*100,2):0;
			$arr['Mobile_log'] = $total_log>0?number_format(($Mobile_log/$total_log)*100,2):0;
			$arr['Tablet_log'] = $total_log>0?number_format(($Tablet_log/$total_log)*100,2):0;
			$lang_select = "";
			if($lang=="thai"){
				$lang_select = "th";
			}else if($lang=="english"){
				$lang_select = "eng";
			}
			/*$arr['scoreAvg'] = $this->manage->chk_scoretotal();
			$arr['can_registered'] = $this->manage->chk_course_registered();
			$arr['query_registered'] = $this->manage->query_course_registered();
			$arr['course_not_register'] = $this->manage->chk_course_not_register();
			$arr['course_pass'] = $this->manage->chk_course_status('1');
			$arr['course_wait'] = $this->manage->chk_course_status('2');
			$arr['total_student'] = $this->manage->chk_total_status('2');
			$arr['total_course'] = $this->manage->chk_total_status('1');
			$arr['course_not_study'] = $this->manage->chk_course_status('0');*/
			$arr['pic'] = $this->home->getpic_all();
			//Record Log activity
			$this->load->model('Log_model', 'lg', FALSE);
			$this->lg->loadDB();
			$this->lg->record('dashboard', 'enter dashboard.');
			$this->lg->closeDB();

			$this->load->model('Footer_model', 'foot', FALSE);
			$this->foot->loadDB();
			$arr['foote'] = $this->foot->getfooter();
			$this->foot->closeDB();

			$this->load->view('frontend/dashboard', $arr );
		}
	}

	public function sortArrayByKey(&$array,$key,$string = false,$asc = true){
				    if($string){
				        usort($array,function ($a, $b) use(&$key,&$asc)
				        {
				            if($asc)    return strcmp(strtolower($a{$key}), strtolower($b{$key}));
				            else        return strcmp(strtolower($b{$key}), strtolower($a{$key}));
				        });
				    }else{
				        usort($array,function ($a, $b) use(&$key,&$asc)
				        {
				            if($a[$key] == $b{$key}){return 0;}
				            if($asc) return ($a{$key} < $b{$key}) ? -1 : 1;
				            else     return ($a{$key} > $b{$key}) ? -1 : 1;

				        });
				    }
	}

	public function profile($tab='setting'){

		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$arr['lang'] = $lang;
		$arr['page'] = "profile";

	    $this->load->model('Manage_model', 'manage', FALSE);
	    $this->manage->loadDB();
	    $this->load->model('Profile_model', 'profile', FALSE);
	    $this->profile->loadDB();
	    $arr['arr_permission'] = $this->manage->chk_permission_page();
		$this->load->model('User_model', 'login', FALSE);
		if($this->login->checkSession($arr['page'])){
			$sess = $this->session->userdata("user");
			$arr['emp_c'] = $sess['emp_c'];
			$arr['com_admin'] = $sess['com_admin'];
			$arr['com_id'] = $sess['com_id'];
			$arr['user'] = $sess;
			$arr['tabshow'] = $tab;
			if($sess['Is_admin']=="0"){
				$yourArray = $this->profile->query_timeline($sess);
				$this->sortArrayByKey($yourArray,"datetime_run",true,false);
				$arr['timeline'] = $yourArray;
			}else{
				$arr['timeline'] = "";
			}


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
			$this->load->model('Course_model', 'course', TRUE);
			$this->course->loadDB();
			$arr['company_detail'] = $this->course->query_data_onupdate($arr['com_id'], 'LMS_COMPANY','com_id');
			$arr['certshow'] = $this->profile->loaddata_cert($sess);
			$arr['profile'] = $this->manage->query_data_onupdate($arr['user']['u_id'], 'LMS_USP','u_id');
			$this->load->model('Footer_model', 'foot', FALSE);
			$this->foot->loadDB();
			$arr['foote'] = $this->foot->getfooter();
			$this->foot->closeDB();
			$this->load->view('frontend/profile', $arr );
		}
	}

	public function change_pass(){

		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$arr['lang'] = $lang;
		$arr['page'] = "dashboard/change_pass";

	    $this->load->model('Manage_model', 'manage', FALSE);
	    $this->manage->loadDB();
	    $this->load->model('Profile_model', 'profile', FALSE);
	    $this->profile->loadDB();
	    $arr['arr_permission'] = $this->manage->chk_permission_page();
		$this->load->model('User_model', 'login', FALSE);
		if($this->login->checkSession($arr['page'])){
			$sess = $this->session->userdata("user");
			$arr['emp_c'] = $sess['emp_c'];
			$arr['com_admin'] = $sess['com_admin'];
			$arr['com_id'] = $sess['com_id'];
			$arr['user'] = $sess;
			
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
			$this->load->model('Course_model', 'course', TRUE);
			$this->course->loadDB();
			$arr['profile'] = $this->manage->query_data_onupdate($arr['user']['u_id'], 'LMS_USP','u_id');
			$this->load->model('Footer_model', 'foot', FALSE);
			$this->foot->loadDB();
			$arr['foote'] = $this->foot->getfooter();
			$this->foot->closeDB();
			$this->load->view('frontend/change_pass', $arr );
		}
	}

	public function loopchk_expireuser(){
		$lang = "english";
		$this->load->model('Function_query_model', 'func_query', TRUE);
		$this->func_query->loadDB();
        date_default_timezone_set("Asia/Bangkok");
    	$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		$dateexpire = date('Y-m-d H:i');
		$msg = "";
		$fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
        $fetch_chk_exp = $this->func_query->query_result('LMS_USP','LMS_EMP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.expiredate<"'.$dateexpire.'" and LMS_EMP.emp_isDelete="0" and LMS_USP.u_isDelete="0"');
        if(count($fetch_chk_exp)>0){
        	$num_exp = 0;
        	$list_usp = "";
        	foreach ($fetch_chk_exp as $key_exp => $value_exp) {

              $date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
              if($lang!="thai"){
                 $date = date('d F Y');
              }
						$fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="2"');
						if(count($fetch_formatmail)>0){
							$list_usp .= " - ".$value_exp['fullname_en']."<br>";
							$num_exp++;
		                    $subject_th = $fetch_formatmail['smf_subject_th'];
		                    $subject_en = $fetch_formatmail['smf_subject_en'];
		                    $message_th = $fetch_formatmail['smf_message_th'];
		                    $message_en = $fetch_formatmail['smf_message_en'];
		                    if($subject_th!=""){
		                        $subject_th = str_replace("#fullname",$value_exp['fullname_th'],$subject_th);
		                        $subject_th = str_replace("#username",$value_exp['useri'],$subject_th);
		                        $subject_th = str_replace("#email",$value_exp['email'],$subject_th);
		                        $subject_th = str_replace("#coursename","",$subject_th);
		                        $subject_th = str_replace("#password","",$subject_th);
                          		$subject_th = str_replace("#link_frontend",base_url().'dashboard/passexpireonmail/'.$value_exp['u_id'],$subject_th);
		                        $subject_th = str_replace("#date",$date,$subject_th);
		                        $subject_th = str_replace("#time",date('H:i'),$subject_th);
		                    }
		                    if($subject_en!=""){
		                        $subject_en = str_replace("#fullname",$value_exp['fullname_en'],$subject_en);
		                        $subject_en = str_replace("#username",$value_exp['useri'],$subject_en);
		                        $subject_en = str_replace("#email",$value_exp['email'],$subject_en);
		                        $subject_en = str_replace("#coursename","",$subject_en);
		                        $subject_en = str_replace("#password","",$subject_en);
                          		$subject_en = str_replace("#link_frontend",base_url().'dashboard/passexpireonmail/'.$value_exp['u_id'],$subject_en);
		                        $subject_en = str_replace("#date",$date,$subject_en);
		                        $subject_en = str_replace("#time",date('H:i'),$subject_en);
		                    }
		                    if($message_th!=""){
		                        $message_th = str_replace("#fullname",$value_exp['fullname_th'],$message_th);
		                        $message_th = str_replace("#username",$value_exp['useri'],$message_th);
		                        $message_th = str_replace("#email",$value_exp['email'],$message_th);
		                        $message_th = str_replace("#coursename","",$message_th);
		                        $message_th = str_replace("#password","",$message_th);
                          		$message_th = str_replace("#link_frontend",base_url().'dashboard/passexpireonmail/'.$value_exp['u_id'],$message_th);
		                        $message_th = str_replace("#date",$date,$message_th);
		                        $message_th = str_replace("#time",date('H:i'),$message_th);
		                    }
		                   	if($message_en!=""){
		                        $message_en = str_replace("#fullname",$value_exp['fullname_en'],$message_en);
		                        $message_en = str_replace("#username",$value_exp['useri'],$message_en);
		                        $message_en = str_replace("#email",$value_exp['email'],$message_en);
		                        $message_en = str_replace("#coursename","",$message_en);
		                        $message_en = str_replace("#password","",$message_en);
                          		$message_en = str_replace("#link_frontend",base_url().'dashboard/passexpireonmail/'.$value_exp['u_id'],$message_en);
		                        $message_en = str_replace("#date",$date,$message_en);
		                        $message_en = str_replace("#time",date('H:i'),$message_en);
		                    }
		                    if($lang == "thai") {
		                        $this->db->sendEmail( $value_exp['email'] , $message_th, $subject_th,$fetch_setmail);
		                    }else{
		                        $this->db->sendEmail( $value_exp['email'] , $message_en, $subject_en,$fetch_setmail);
		                    }
						}
        	}

        	$msg = "List User Expire (".$num_exp."): <br>".$list_usp;
        }else{
        	$msg = "USER EXPIRE : Not Found";
        }
        $this->db->sendEmail( 'it.bangkok@verztec.com' , $msg, 'Notification : USER Expire for LMS IMAT',$fetch_setmail);
        echo $msg;
	}
	
	public function update_password(){
		$sess = $this->session->userdata("user");
		$useri = $sess['useri'];

		$confirm_pass = isset($_REQUEST['confirmpass'])?$_REQUEST['confirmpass']:"";
		$u_id = isset($_REQUEST['u_id'])?$_REQUEST['u_id']:$sess['u_id'];
		$useri = isset($_REQUEST['useri'])?$_REQUEST['useri']:$sess['useri'];
		$this->load->model('Function_query_model', 'func_query', TRUE);
		$this->load->model('Log_model', 'lg', FALSE);
		$this->lg->loadDB();
		if($confirm_pass!=""){
			if(!empty($sess)||isset($_REQUEST['u_id'])){
				$password_enc = hash('sha256', $confirm_pass);
					$status_duplicate = 0;
					$fetch_logpass = $this->func_query->query_result('LMS_LOG_PASSWORD','LMS_USP','LMS_USP.u_id = LMS_LOG_PASSWORD.u_id','','LMS_USP.useri="'.$useri.'" and LMS_USP.u_isDelete="0"','LMS_LOG_PASSWORD.lp_id DESC','',3);
					if(count($fetch_logpass)>0){
						$chkpass = 0;
						foreach ($fetch_logpass as $key_logpass => $value_logpass) {
							if($password_enc==$value_logpass['lp_password']){
								$chkpass++;
							}
						}
						if($chkpass>0){
							$status_duplicate = 1;
						}
					}
					if($status_duplicate==0){
						$this->lg->record('dashboard', 'user name '.$useri.' Change Password.');
			    		$date = date('Y-m-d H:i') ;
			    		$date = new DateTime($date);
			    		$date->modify('+90 day');
			    		$dateexpire = date_format($date, 'Y-m-d H:i');
						$data = array(
							'userp' => $password_enc,
							'expiredate' => $dateexpire
						);
						$this->db->where('u_id',$u_id);
						$this->db->update('LMS_USP',$data);
						
				        $arr_logpass = array(
				          'u_id' =>  $u_id,
				          'lp_datetime' => date('Y-m-d H:i'),
				          'lp_password' => $password_enc
				        );
				        $this->db->insert('LMS_LOG_PASSWORD',$arr_logpass);
						$arr_result['rs'] = true;
						$arr_result['msg'] = "050";//เปลี่ยนรหัสผ่านเรียบร้อย
						echo json_encode( $arr_result ) ;
					}else{
						$arr_result['rs'] = false;
						$arr_result['msg'] = "055";//รหัสผ่านซ้ำกับของเก่า 
						echo json_encode( $arr_result ) ;
					}
				$this->lg->closeDB();
			}else{
				$arr_result['rs'] = false;
				$arr_result['msg'] = "056";//ไม่พบข้อมูล 
				echo json_encode( $arr_result ) ;
			}
		}else{
			$arr_result['rs'] = false;
			$arr_result['msg'] = "056";//ไม่พบรหัสผ่าน 
			echo json_encode( $arr_result ) ;
		}
	}


	public function fetch_grade(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
		$user = $this->session->userdata('user');
		$this->lang->load($lang,$lang);
		$this->load->model('Dashboard_model', 'dashboard', TRUE);
		$this->dashboard->loadDB();
		$grade = isset($_REQUEST['grade']) ? $_REQUEST['grade'] : '';
		$query = $this->dashboard->fetch_grade($user,$grade);
		$num = 1;
      	$draw = intval($this->input->get("draw"));
      	$start = intval($this->input->get("start"));
      	$length = intval($this->input->get("length"));
     	$data = [];
      	$count = count($query);
      	$result = array(
            "draw" => $draw,
            "recordsTotal" => $count,
            "recordsFiltered" => $count,
            "data" => $query
        );
      	echo json_encode($result);
      	exit();
	}

	public function unlockAcc()
	{
		$arr['page'] = 'dashboard/unlockAcc';
		$this->load->model('User_model', 'login', TRUE);
	    $this->load->model('Manage_model', 'manage', FALSE);
	    $this->manage->loadDB();
	    $arr['btn_view'] = $this->manage->chk_permission($arr['page'],'ru_view');
			if($arr['btn_view']!="1"){
				redirect(base_url().'dashboard') ;
			}
	    $this->load->model('Manage_model', 'manage', FALSE);
	    $this->manage->loadDB();
	    $arr['arr_permission'] = $this->manage->chk_permission_page();
		!$this->login->checkSession($arr['page']) ? : $arr['page'];
		$user = $this->session->userdata("user");
		$arr['user'] = $user;
			$arr['emp_c'] = $user['emp_c'];
			$arr['com_admin'] = $user['com_admin'];
			$arr['com_id'] = $user['com_id'];

	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
	    $this->lang->load($lang,$lang);
	    $arr['lang'] = $lang;
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
		$arr['accounts'] = $this->login->getLockedAcc();
    	$arr['company_select'] = $this->manage->getCompany();
		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();
		$this->foot->closeDB();
		$this->manage->closeDB();

    	$this->load->view('frontend/unlockAcc', $arr);
	}

	public function fetch_detail_unlockacc(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('User_model', 'user', FALSE);
		$this->user->loadDB();
		$query = $this->user->fetch_data_unlockacc();
		$num = 1;
      	$draw = intval($this->input->get("draw"));
      	$start = intval($this->input->get("start"));
      	$length = intval($this->input->get("length"));
     	$data = [];
      	$count = count($query);
      	$result = array(
               "draw" => $draw,
                 "recordsTotal" => $count,
                 "recordsFiltered" => $count,
                 "data" => $query
        );
      	echo json_encode($result);
      	exit();
	}

	public function unlockUser()
	{
		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();
		$this->foot->closeDB();
		$user = $this->session->userdata('user');

		$emp_id = $this->input->post('emp_id');
		$useri = $this->input->post('useri');
		$this->load->model('User_model', 'user', FALSE);
		$this->user->loadDB();
		$this->user->unlock($emp_id);
		$this->unlockpass($useri);
		$this->load->model('Log_model', 'lg', FALSE);
	    $this->lg->loadDB();
	    $this->lg->record('user', 'Unlock user : '.$useri.' By '.$user['fullname_th']);
		$this->user->closeDB();
		redirect(base_url().'dashboard/unlockAcc');
	}


	public function confim_account($emp_id){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('User_model', 'login', TRUE);
		$this->login->loadDB();
		$data = array('confirm_status'=>'1');
		$this->db->where('emp_id',$emp_id);
		$this->db->update('LMS_USP',$data);
		
		$redirect = isset( $_GET['redirect'] ) ? $_GET['redirect'] : 'dashboard';
		$this->login->sendLogin($redirect);
	}

	public function chk_firsttime_user(){
		$this->load->model('User_model', 'login', TRUE);
		$this->load->model('Function_query_model', 'func_query', TRUE);
		$this->login->loadDB();
		$password = hash('sha256', $_REQUEST['password']);
		$arr_output = array();
		$dest = isset($_REQUEST['dest'])&&$_REQUEST['dest']!=""?$_REQUEST['dest']:"";
		if($this->login->checkfirsttime( $_REQUEST['username'], $_REQUEST['password'])){
			if($this->login->checkconfirm_status( $_REQUEST['username'], $_REQUEST['password'])){
		        $this->session->set_userdata('username_firsttime', $_REQUEST['username'] );
		        $this->session->set_userdata('firsttime', true );
				$arr_output['status']="1";
				$arr_output['redirect_val']=base_url()."dashboard/firsttime";
			}else{
		        $this->session->set_userdata('firsttime', true );
		        $this->session->set_userdata('username_firsttime', $_REQUEST['username'] );
				$arr_output['status']="3";
				$arr_output['redirect_val']=base_url()."dashboard/firsttime";
			}
		}else{
			$username = $_REQUEST['username'];
			$fetch_chkuser = $this->func_query->query_row('LMS_USP','','','','useri="'.$username.'" and u_isDelete="0"');

	        date_default_timezone_set("Asia/Bangkok");
	        $date_now = date('Y-m-d H:i') ;
	        $dateExpire    = date('Y-m-d H:i',strtotime($fetch_chkuser['expiredate']));
	        if ($date_now > $dateExpire) {
	          	$this->session->set_userdata('username_firsttime', $username );
	          	$this->session->set_userdata('passexpire', true );
	          	//redirect(base_url().'dashboard/passexpire');
	          	$arr_output['status']="4";
				$arr_output['redirect_val']=base_url()."dashboard/passexpire";
	        }else{
	          	$this->session->set_userdata('passexpire', false );
				$this->login->checkLogin( $_REQUEST['username'], $password );
				$arr_output['status']="0";
				$arr_output['redirect_val']=$dest!=""?base_url().$dest:base_url()."dashboard";
	        }

		}
		echo json_encode($arr_output);
	}
	
	public function unlockpass($useri){
		$arr_result = array();
   		$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$arr['lang'] = $lang;

		$emp_c = $useri;
		if( $emp_c == "" ){
			redirect(base_url().'home');
		}else{
			$this->load->model('User_model', 'login', TRUE);
			$this->load->model('Function_query_model', 'func_query', TRUE);
			$this->login->loadDB();
			$emp = $this->login->getUser( $emp_c );
			if( sizeof( $emp ) > 0 ){
				if( $emp['email'] != "" ){
					$password = $this->generateRandomString();
					$password_enc = hash('sha256', $password);
					if($this->login->updatePass( $emp_c, $password_enc, $password )){
						$this->login->setFirstTime($emp_c);
						$fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');

						$fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="3"');
						if(count($fetch_formatmail)>0){
		                    $subject_th = $fetch_formatmail['smf_subject_th'];
		                    $subject_en = $fetch_formatmail['smf_subject_en'];
		                    $message_th = $fetch_formatmail['smf_message_th'];
		                    $message_en = $fetch_formatmail['smf_message_en'];
              $date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
              if($lang!="thai"){
                 $date = date('d F Y');
              }
		                    if($subject_th!=""){
		                        $subject_th = str_replace("#fullname",$emp['fullname_th'],$subject_th);
		                        $subject_th = str_replace("#username",$emp['useri'],$subject_th);
		                        $subject_th = str_replace("#email",$emp['email'],$subject_th);
		                        $subject_th = str_replace("#coursename","",$subject_th);
		                        $subject_th = str_replace("#link_frontend",base_url(),$subject_th);
		                        $subject_th = str_replace("#password",$password,$subject_th);
		                        $subject_th = str_replace("#date",$date,$subject_th);
		                        $subject_th = str_replace("#time",date('H:i'),$subject_th);
		                    }
		                    if($subject_en!=""){
		                        $subject_en = str_replace("#fullname",$emp['fullname_en'],$subject_en);
		                        $subject_en = str_replace("#username",$emp['useri'],$subject_en);
		                        $subject_en = str_replace("#email",$emp['email'],$subject_en);
		                        $subject_en = str_replace("#coursename","",$subject_en);
		                        $subject_en = str_replace("#link_frontend",base_url(),$subject_en);
		                        $subject_en = str_replace("#password",$password,$subject_en);
		                        $subject_en = str_replace("#date",$date,$subject_en);
		                        $subject_en = str_replace("#time",date('H:i'),$subject_en);
		                    }
		                    if($message_th!=""){
		                        $message_th = str_replace("#fullname",$emp['fullname_th'],$message_th);
		                        $message_th = str_replace("#username",$emp['useri'],$message_th);
		                        $message_th = str_replace("#email",$emp['email'],$message_th);
		                        $message_th = str_replace("#coursename","",$message_th);
		                        $message_th = str_replace("#link_frontend",base_url(),$message_th);
		                        $message_th = str_replace("#password",$password,$message_th);
		                        $message_th = str_replace("#date",$date,$message_th);
		                        $message_th = str_replace("#time",date('H:i'),$message_th);
		                    }
		                   	if($message_en!=""){
		                        $message_en = str_replace("#fullname",$emp['fullname_en'],$message_en);
		                        $message_en = str_replace("#username",$emp['useri'],$message_en);
		                        $message_en = str_replace("#email",$emp['email'],$message_en);
		                        $message_en = str_replace("#coursename","",$message_en);
		                        $message_en = str_replace("#link_frontend",base_url(),$message_en);
		                        $message_en = str_replace("#password",$password,$message_en);
		                        $message_en = str_replace("#date",$date,$message_en);
		                        $message_en = str_replace("#time",date('H:i'),$message_en);
		                    }
		                    if($lang == "thai") {
		                        $this->db->sendEmail( $emp['email'] , $message_th, $subject_th,$fetch_setmail);
		                    }else{
		                        $this->db->sendEmail( $emp['email'] , $message_en, $subject_en,$fetch_setmail);
		                    }
						}
						$arr_result['rs'] = true;
						echo json_encode( $arr_result ) ;
					}else{
						$arr_result['rs'] = false;
						$arr_result['msg'] = label('cannot_sent_password');
						echo json_encode( $arr_result ) ;
					}
				}else{
					$arr_result['rs'] = false;
					$arr_result['msg'] = label('notfound_email');
					echo json_encode( $arr_result ) ;
				}
			}else{
				$arr_result['rs'] = false;
				$arr_result['msg'] = label('notfound_user');
				echo json_encode( $arr_result ) ;
			}
		}
	}

	public function login()
	{
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);

		$arr['lang'] = $lang;
		$arr['page'] = "login";
		$redirect = isset( $_GET['redirect'] ) ? $_GET['redirect'] : 'home';
		$arr['dest'] = $redirect;
		$this->load->model('User_model', 'login', TRUE);
		//$this->login->sendLogin($redirect);

		redirect(base_url().'home', 'refresh');
	}
	public function firsttime(){
		$arr = array();
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$arr['lang'] = $lang;
		$arr['page'] = "firsttime";
		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();
		$this->foot->closeDB();

		if( $this->session->userdata("firsttime") ){
			$this->load->view('frontend/updatepass', $arr );
		}else{
			redirect(base_url().'home');
		}
	}
	public function passexpire(){
		$arr = array();
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$arr['lang'] = $lang;
		$arr['page'] = "passexpire";
		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();
		$this->foot->closeDB();
		if( $this->session->userdata("passexpire") ){
			$this->load->view('frontend/updatepass', $arr );
		}else{
			redirect(base_url().'home');
		}
	}
	public function passexpireonmail($u_id){
		$arr = array();
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$arr['lang'] = $lang;
		$arr['page'] = "dashboard/passexpireonmail";
    	date_default_timezone_set("Asia/Bangkok");
		$this->load->model('Footer_model', 'foot', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->foot->loadDB();
		$fetch_chk_user = $this->func_query->query_row('LMS_USP','','','','u_id="'.$u_id.'"');
		$arr['userdata'] = $fetch_chk_user;
		$arr['foote'] = $this->foot->getfooter();
		$this->foot->closeDB();
		if( count($arr['userdata'])>0 ){
			$this->load->view('frontend/updatepass_expire', $arr );
		}else{
			redirect(base_url().'home');
		}
	}
	public function testDate(){
		date_default_timezone_set("Asia/Bangkok");
		$date = date('Y-m-d H:i') ;
		$date = new DateTime($date);
		$date->modify('+60 day');
		echo date_format($date, 'Y-m-d H:i');
	}
	public function updatePass( $resetPass = 0 ){
		$this->load->model('Function_query_model', 'func_query', TRUE);
		$this->func_query->loadDB();
		$arr_result = array();
		if( null !== $this->session->userdata('username_firsttime') ){
			if( $this->session->userdata('username_firsttime') != '' ){
				// code here
				$password = isset( $_POST['newpass'] ) ? $_POST['newpass'] : '';
				if( $password != '' ){
					$user = $this->session->userdata('username_firsttime');
					$password_enc = hash('sha256', $password);// and LMS_USP.userp="'.$password_enc.'"
					$status_duplicate = 0;
					$fetch_logpass = $this->func_query->query_result('LMS_LOG_PASSWORD','LMS_USP','LMS_USP.u_id = LMS_LOG_PASSWORD.u_id','','LMS_USP.useri="'.$user.'" and LMS_USP.u_isDelete="0"','LMS_LOG_PASSWORD.lp_id DESC','',3);
					if(count($fetch_logpass)>0){
						$chkpass = 0;
						foreach ($fetch_logpass as $key_logpass => $value_logpass) {
							if($password_enc==$value_logpass['lp_password']){
								$chkpass++;
							}
						}
						if($chkpass>0){
							$status_duplicate = 1;
						}
					}
					if($status_duplicate==0){
						$this->load->model('User_model', 'login', TRUE);
						$this->login->loadDB();
						if($this->login->updatePass( $this->session->userdata('username_firsttime'), $password_enc, $password, $resetPass )){
							$arr_result['rs'] = true;
							$arr_result['msg'] = "050";//เปลี่ยนรหัสผ่านเรียบร้อย
							echo json_encode( $arr_result ) ;
						}else{
							$arr_result['rs'] = false;
							$arr_result['msg'] = "054";//รหัสผ่านซ้ำกับของก่อนหน้านี้
							echo json_encode( $arr_result ) ;
						}
					}else{
						$arr_result['rs'] = false;
						$arr_result['msg'] = "055";//รหัสผ่านซ้ำกับของเก่า 
						echo json_encode( $arr_result ) ;
					}
				}else{
					$arr_result['rs'] = false;
					$arr_result['msg'] = "กรุณากรอกรหัสผ่านใหม่ของคุณ";
					echo json_encode( $arr_result ) ;
				}
			}else{
				redirect(base_url().'home');
			}
		}else{
			redirect(base_url().'home');
		}
	}
	public function forgotpass(){
		$arr_result = array();
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$arr['lang'] = $lang;

		$emp_c = isset( $_POST['emp_c'] ) ? $_POST['emp_c'] : '';
		if( $emp_c == "" ){
			redirect(base_url().'home');
		}else{
			$this->load->model('User_model', 'login', TRUE);
			$this->login->loadDB();
			$password = $this->generateRandomString();
			$password_enc = hash('sha256', $password);
			$emp = $this->login->getEmp( $emp_c );
			if( sizeof( $emp ) > 0 ){
					$password_enc = hash('sha256', $password_enc);
					if($this->login->updatePass( $emp_c, $password_enc, $password ,'1')){
						$this->login->setFirstTime($emp_c);
						$arr_result['rs'] = true;
						echo json_encode( $arr_result ) ;
					}else{
						$arr_result['rs'] = false;
						$arr_result['msg'] = "ไม่สามารถส่งรหัสผ่านใหม่ได้";
						echo json_encode( $arr_result ) ;
					}
			}else{
				$arr_result['rs'] = false;
				$arr_result['msg'] = "ไม่พบรหัสผู้ใช้งานของคุณ";
				echo json_encode( $arr_result ) ;
			}
		}
	}
	public function resetPass(){

		$arr_result = array();
		$arr = array();
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$arr['lang'] = $lang;
		$arr['page'] = 'dashboard/resetPass';
		$this->load->model('User_model', 'login', FALSE);
		if($this->login->checkSession($arr['page'])){
			$sess = $this->session->userdata("user");
			$arr['user'] = $sess;
			$arr['emp_c'] = $sess['emp_c'];
			$arr['com_admin'] = $sess['com_admin'];
			$arr['com_id'] = $sess['com_id'];
		}
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$arr['arr_permission'] = $this->manage->chk_permission_page();
		$arr['btn_view'] = $this->manage->chk_permission($arr['page'],'ru_view');
			if($arr['btn_view']!="1"){
				redirect(base_url().'dashboard') ;
			}
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
		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();
		$this->foot->closeDB();
		$this->load->view('frontend/resetpass', $arr );

	}
	
	public function resetPassSubmit(){
		$arr_result = array();
		$arr = array();
   		$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$arr['lang'] = $lang;
		$arr['page'] = 'resetpass';
		$this->load->model('User_model', 'login', FALSE);
		$this->login->loadDB();
		$user = $this->session->userdata('user');
		$useri = isset( $_POST['useri'] ) ? $_POST['useri']  : '';

		$this->load->model('Log_model', 'lg', FALSE);
		$this->load->model('Function_query_model', 'func_query', TRUE);
	    $this->lg->loadDB();
	    $this->lg->record('user', 'Reset user : '.$useri.' By '.$user['fullname_th']);
		$this->load->model('Manage_model', 'manage', FALSE);
        $this->manage->loadDB();
		if( $useri == "" ){
			$arr_result['rs'] = false;
			$arr_result['msg'] = label('com_msg_form_error');
			echo json_encode( $arr_result ) ;
		}else{
			$empdata = $this->login->getUser($useri);
			$chkuser = 1;
			/*if($user['ug_id']!="1"){
				if($empdata['ug_id']=="1"){
					$chkuser = 0;
				}
			}*/
			if( sizeof( $empdata ) > 0 &&$chkuser == 1){
				$password = $this->generateRandomString();
				$password_enc = hash('sha256', $password);
				$this->login->updatePass( $useri, $password_enc, '', 1 );
				$this->login->setFirstTime($useri);

              $date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
              if($lang!="thai"){
                 $date = date('d F Y');
              }
				$fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
				$fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="2"');
				if(count($fetch_formatmail)>0){
		            $subject_th = $fetch_formatmail['smf_subject_th'];
		            $subject_en = $fetch_formatmail['smf_subject_en'];
		            $message_th = $fetch_formatmail['smf_message_th'];
		            $message_en = $fetch_formatmail['smf_message_en'];
		            if($subject_th!=""){
		                $subject_th = str_replace("#fullname",$empdata['fullname_th'],$subject_th);
		                $subject_th = str_replace("#username",$empdata['useri'],$subject_th);
		                $subject_th = str_replace("#email",$empdata['email'],$subject_th);
		                $subject_th = str_replace("#password",$password,$subject_th);
		                $subject_th = str_replace("#coursename","",$subject_th);
		                $subject_th = str_replace("#date",$date,$subject_th);
		                $subject_th = str_replace("#time",date('H:i'),$subject_th);
		            }
		            if($subject_en!=""){
		                $subject_en = str_replace("#fullname",$empdata['fullname_en'],$subject_en);
		                $subject_en = str_replace("#username",$empdata['useri'],$subject_en);
		                $subject_en = str_replace("#email",$empdata['email'],$subject_en);
		                $subject_en = str_replace("#password",$password,$subject_en);
		                $subject_en = str_replace("#coursename","",$subject_en);
		                $subject_en = str_replace("#date",$date,$subject_en);
		                $subject_en = str_replace("#time",date('H:i'),$subject_en);
		            }
                      if(isset($fetch_formatmail['smf_importimage'])&&$fetch_formatmail['smf_importimage']!=""){
                          $img_val = '<img src="'.base_url().'/uploads/formatmail_img/'.$fetch_formatmail['smf_importimage'].'" width="100%">';
                      }else{
                          $img_val = '';
                      }
		            if($message_th!=""){
		                $message_th = str_replace("#fullname",$empdata['fullname_th'],$message_th);
		                $message_th = str_replace("#username",$empdata['useri'],$message_th);
		                $message_th = str_replace("#email",$empdata['email'],$message_th);
		                $message_th = str_replace("#password",$password,$message_th);
		                $message_th = str_replace("#coursename","",$message_th);
		                $message_th = str_replace("#date",$date,$message_th);
		                $message_th = str_replace("#time",date('H:i'),$message_th);
                        $message_th = str_replace("#image",$img_val,$message_th);
		            }
		            if($message_en!=""){
		                $message_en = str_replace("#fullname",$empdata['fullname_en'],$message_en);
		                $message_en = str_replace("#username",$empdata['useri'],$message_en);
		                $message_en = str_replace("#email",$empdata['email'],$message_en);
		                $message_en = str_replace("#password",$password,$message_en);
		                $message_en = str_replace("#coursename","",$message_en);
		                $message_en = str_replace("#date",$date,$message_en);
		                $message_en = str_replace("#time",date('H:i'),$message_en);
                        $message_en = str_replace("#image",$img_val,$message_en);
		            }
		            if($lang == "thai") {
		                $this->db->sendEmail( $empdata['email'] , $message_th, $subject_th,$fetch_setmail);
		            }else{
		                $this->db->sendEmail( $empdata['email'] , $message_en, $subject_en,$fetch_setmail);
		            }
				}
				$arr_result['msg'] = label('sentmail_success');
				$arr_result['rs'] = true;
				$arr_result['emp_id'] = $empdata['emp_id'];
			}else{
				$arr_result['rs'] = false;
				$arr_result['msg'] = label('datauser_notfound');
			}
			echo json_encode( $arr_result ) ;
			$this->login->closeDB();
		}
	}
	
	public function resetPassSubmit_page(){
		$arr_result = array();
		$arr = array();
   		$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$arr['lang'] = $lang;
		$arr['page'] = 'resetpass';
		$this->load->model('User_model', 'login', FALSE);
		$this->login->loadDB();
		$user = $this->session->userdata('user');
		$useri = isset( $_POST['useri'] ) ? $_POST['useri']  : '';

		$this->load->model('Log_model', 'lg', FALSE);
		$this->load->model('Function_query_model', 'func_query', TRUE);
	    $this->lg->loadDB();
	    $this->lg->record('user', 'Reset user : '.$useri.' By '.$user['fullname_th']);
		$this->load->model('Manage_model', 'manage', FALSE);
        $this->manage->loadDB();
		if( $useri == "" ){
			$arr_result['rs'] = false;
			$arr_result['msg'] = label('com_msg_form_error');
			echo json_encode( $arr_result ) ;
		}else{
			$empdata = $this->login->getUser($useri);
			$chkuser = 1;
			if($user['ug_id']!="1"){
				if($empdata['ug_id']=="1"){
					$chkuser = 0;
				}
			}
			if($chkuser == 1){
				if( sizeof( $empdata ) > 0 ){
					$password = $this->generateRandomString();
					$password_enc = hash('sha256', $password);
					$this->login->updatePass( $useri, $password_enc, '', 1 );
					$this->login->setFirstTime($useri);

	              $date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
	              if($lang!="thai"){
	                 $date = date('d F Y');
	              }
					$fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
					$fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="2"');
					if(count($fetch_formatmail)>0){
			            $subject_th = $fetch_formatmail['smf_subject_th'];
			            $subject_en = $fetch_formatmail['smf_subject_en'];
			            $message_th = $fetch_formatmail['smf_message_th'];
			            $message_en = $fetch_formatmail['smf_message_en'];
			            if($subject_th!=""){
			                $subject_th = str_replace("#fullname",$empdata['fullname_th'],$subject_th);
			                $subject_th = str_replace("#username",$empdata['useri'],$subject_th);
			                $subject_th = str_replace("#email",$empdata['email'],$subject_th);
			                $subject_th = str_replace("#password",$password,$subject_th);
			                $subject_th = str_replace("#coursename","",$subject_th);
			                $subject_th = str_replace("#date",$date,$subject_th);
			                $subject_th = str_replace("#time",date('H:i'),$subject_th);
			            }
			            if($subject_en!=""){
			                $subject_en = str_replace("#fullname",$empdata['fullname_en'],$subject_en);
			                $subject_en = str_replace("#username",$empdata['useri'],$subject_en);
			                $subject_en = str_replace("#email",$empdata['email'],$subject_en);
			                $subject_en = str_replace("#password",$password,$subject_en);
			                $subject_en = str_replace("#coursename","",$subject_en);
			                $subject_en = str_replace("#date",$date,$subject_en);
			                $subject_en = str_replace("#time",date('H:i'),$subject_en);
			            }
	                      if(isset($fetch_formatmail['smf_importimage'])&&$fetch_formatmail['smf_importimage']!=""){
	                          $img_val = '<img src="'.base_url().'/uploads/formatmail_img/'.$fetch_formatmail['smf_importimage'].'" width="100%">';
	                      }else{
	                          $img_val = '';
	                      }
			            if($message_th!=""){
			                $message_th = str_replace("#fullname",$empdata['fullname_th'],$message_th);
			                $message_th = str_replace("#username",$empdata['useri'],$message_th);
			                $message_th = str_replace("#email",$empdata['email'],$message_th);
			                $message_th = str_replace("#password",$password,$message_th);
			                $message_th = str_replace("#coursename","",$message_th);
			                $message_th = str_replace("#date",$date,$message_th);
			                $message_th = str_replace("#time",date('H:i'),$message_th);
	                        $message_th = str_replace("#image",$img_val,$message_th);
			            }
			            if($message_en!=""){
			                $message_en = str_replace("#fullname",$empdata['fullname_en'],$message_en);
			                $message_en = str_replace("#username",$empdata['useri'],$message_en);
			                $message_en = str_replace("#email",$empdata['email'],$message_en);
			                $message_en = str_replace("#password",$password,$message_en);
			                $message_en = str_replace("#coursename","",$message_en);
			                $message_en = str_replace("#date",$date,$message_en);
			                $message_en = str_replace("#time",date('H:i'),$message_en);
	                        $message_en = str_replace("#image",$img_val,$message_en);
			            }
			            if($lang == "thai") {
			                $this->db->sendEmail( $empdata['email'] , $message_th, $subject_th,$fetch_setmail);
			            }else{
			                $this->db->sendEmail( $empdata['email'] , $message_en, $subject_en,$fetch_setmail);
			            }
					}
					$arr_result['msg'] = label('sentmail_success');
					$arr_result['rs'] = true;
					$arr_result['emp_id'] = $empdata['emp_id'];
				}else{
					$arr_result['rs'] = false;
					$arr_result['msg'] = label('datauser_notfound');
				}
			}else{
				$arr_result['rs'] = false;
				$arr_result['msg'] = label('permisson_password');
			}
			echo json_encode( $arr_result ) ;
			$this->login->closeDB();
		}
	}

	private function sendEmail_main($email, $message,$subject){
		require_once 'class/class.simple_mail.php';
		/*$mail_to = $aemail;*/

		$mail = new SimpleMail();
		 //$mail->SMTPAuth = false;
		 // SMTP server
		 //$mail->Host = "172.20.102.105";

		 // set the SMTP port for the outMail server
		 // use either 25, 587, 2525 or 8025
		 //$mail->Port = 25;

		$mail->setTo($email,'')
			->setFrom(SERVER_EMAIL, 'no-reply@verztec.com')
			->setSubject($subject)
			->addGenericHeader('MIME-Version', '1.0')
			->addGenericHeader('Content-Type', 'text/html; charset="utf-8"')
			->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
			->setMessage($message);
		$mail->send();

	}

	public function generateRandomString($length = 8) {
	    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}
	public function updateCondition(){
		$arr_result = array();
		$this->session->set_userdata('acceptCondition', 1 );
		$arr_result['rs'] = true;
		echo json_encode( $arr_result ) ;
	}
	public function chk_login(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$username = $_REQUEST['inpUname'];
		$password = $_REQUEST['inpPwd'];
		$password_enc = hash('sha256', $password);
		$count = 1;
		$this->load->model('User_model', 'login', TRUE);
    	date_default_timezone_set("Asia/Bangkok");
		$this->load->model('Function_query_model', 'func_query', TRUE);
		$this->login->loadDB();
		$arr_output = array();
		$fetch_chk = $this->func_query->query_row('LMS_USP','','','','useri="'.$username.'" and u_isDelete="0"');
		$chk_date = 1;
		if(count($fetch_chk)>0){
			if(isset($fetch_chk['inactivedate'])&&$fetch_chk['inactivedate']!="0000-00-00"&&$fetch_chk['inactivedate']!=""){
				if(date('Y-m-d')>date('Y-m-d',strtotime($fetch_chk['inactivedate']))){
					$chk_date = 0;
				}
			}
			if($password_enc!=$fetch_chk['userp']){
				$chk_date = 4;
			}
		}else{
			$chk_date = 3;
		}
		if($chk_date==1){
				if($this->login->rechk_login( $username, $password_enc )){
					$arr_output['status_msg'] = "complete";
				}else{
					$count_error = 0;
					if ($this->session->userdata("login") == null){
						$this->session->set_userdata('login', array($username => 1));
					} else {
						$counter = $this->session->userdata("login");
						if (isset($counter[$username]))
							$counter[$username] = intval($counter[$username]) + 1;
						else {
							$counter[$username] = 1;
						}
						$this->session->set_userdata('login', $counter);
						if($counter[$username] > 4 ){
							$this->login->lockUser($username);
							$this->session->sess_destroy();
							$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
							$this->output->set_header("Pragma: no-cache");
						}else{
							if (intval($counter[$username]) > 3 ){
								$count_error = 3;
							}
						}
					}
					if ($this->login->isLocked($username)){
						$this->login->closeDB();
						$arr_output['status_msg'] = "account_locked";
						$fetch_usp = $this->func_query->query_row('LMS_USP','','','','useri="'.$username.'" and LMS_USP.u_isDelete="0"');
						$arr_output['emp_id'] = $fetch_usp['emp_id'];
						//Record Log activity
						$this->load->model('Log_model', 'lg', FALSE);
						$this->lg->loadDB();
						$this->lg->record('login', 'Username: '.$username.' is locked.');
						$this->lg->closeDB();
					} else {
						if($count_error==3){
							$arr_output['status_msg'] = "login_failed_4_time";
						}else{
							$arr_output['status_msg'] = "login_failed";
						}
						$this->login->closeDB();
						//Record Log activity
						$this->load->model('Log_model', 'lg', FALSE);
						$this->lg->loadDB();
						$this->lg->record('login', 'Username: '.$username.' logged in fail.');
						$this->lg->closeDB();
					}
				}
		}else{
			if($chk_date == 3){
				$arr_output['status_msg'] = "notfound";
			}else if($chk_date == 4){
				$arr_output['status_msg'] = "passnotfound";
			}else{
				$arr_output['status_msg'] = "login_failed";
			}
			if($chk_date != 3){
					$count_error = 0;
					if ($this->session->userdata("login") == null){
						$this->session->set_userdata('login', array($username => 1));
					} else {
						$counter = $this->session->userdata("login");
						if (isset($counter[$username]))
							$counter[$username] = intval($counter[$username]) + 1;
						else {
							$counter[$username] = 1;
						}
						$this->session->set_userdata('login', $counter);
						if($counter[$username] > 4 ){
							$this->login->lockUser($username);
							$this->session->sess_destroy();
							$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
							$this->output->set_header("Pragma: no-cache");
						}else{
							if (intval($counter[$username]) > 3 ){
								$count_error = 3;
							}
						}
					}
					if ($this->login->isLocked($username)){
						$this->login->closeDB();
						$arr_output['status_msg'] = "account_locked";
						$fetch_usp = $this->func_query->query_row('LMS_USP','','','','useri="'.$username.'"');
						$arr_output['emp_id'] = $fetch_usp['emp_id'];
						//Record Log activity
						$this->load->model('Log_model', 'lg', FALSE);
						$this->lg->loadDB();
						$this->lg->record('login', 'Username: '.$username.' is locked.');
						$this->lg->closeDB();
					} else {
						if($count_error==3){
							$arr_output['status_msg'] = "login_failed_4_time";
						}/*else{
							$arr_output['status_msg'] = "login_failed";
						}*/
						$this->login->closeDB();
						//Record Log activity
						$this->load->model('Log_model', 'lg', FALSE);
						$this->lg->loadDB();
						$this->lg->record('login', 'Username: '.$username.' logged in fail.');
						$this->lg->closeDB();
					}
			}
		}
		echo json_encode($arr_output);
	}
	public function loggedIn()
	{
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);

		$username = isset($_REQUEST['username'])?$_REQUEST['username']:"";
		$password = isset($_REQUEST['password'])?$_REQUEST['password']:"";
		$redirect = 'dashboard';
		
		//$this->load->model('AES_model', 'aes', TRUE);
		//$password_enc = $this->aes->encrypt($password);
		$password_enc = hash('sha256', $password);
		$count = 1;
		$arr_output = array();
		$this->load->model('User_model', 'login', TRUE);
		$this->login->loadDB();
		if($this->login->checkLogin( $username, $password_enc )){
			//Record Log activity
			$sess = $this->session->userdata("user");
			$emp_c = $sess['emp_c'];
			$this->load->model('Log_model', 'lg', FALSE);
			$this->lg->loadDB();
			$this->lg->record('home', 'user id '.$emp_c.' logged in website.');
			$this->lg->closeDB();
			$this->login->closeDB();
			$arr_output['status']="1";
			$arr_output['text_msg']="";
			$arr_output['redirect']=base_url().$redirect;
			//redirect(base_url().$redirect);
		}else{
			$count_error = 0;
			if ($this->session->userdata("login") == null){
				$this->session->set_userdata('login', array($username => 1));
			} else {
				$counter = $this->session->userdata("login");
				if (isset($counter[$username]))
					$counter[$username] = intval($counter[$username]) + 1;
				else {
					$counter[$username] = 1;
				}
				$this->session->set_userdata('login', $counter);
				if($counter[$username] > 4 ){
					$this->login->lockUser($username);
					$this->session->sess_destroy();
					$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
					$this->output->set_header("Pragma: no-cache");
				}else{
					if (intval($counter[$username]) > 3 ){
						$count_error = 3;
						//$path = base_url()."home";
						//$text = label('login_failed_4_time');
					}
				}
			}
			if ($this->login->isLocked($username)){
				$this->login->closeDB();
				$path = base_url()."contact";
				$text = label('account_locked');
				//Record Log activity
				$this->load->model('Log_model', 'lg', FALSE);
				$this->lg->loadDB();
				$this->lg->record('login', 'Username: '.$username.' is locked.');
				$this->lg->closeDB();
			} else {
				if($count_error==3){
					$text = label('login_failed_4_time');
				}else{
					$text = label('login_failed');
				}
				$this->login->closeDB();
				$path = base_url()."home";
				//Record Log activity
				$this->load->model('Log_model', 'lg', FALSE);
				$this->lg->loadDB();
				$this->lg->record('login', 'Username: '.$username.' logged in fail.');
				$this->lg->closeDB();
			}
			$arr_output['status']="0";
			$arr_output['text_msg']=$text;
			$arr_output['redirect']=$path;
			/*echo"<script language='JavaScript'>";
			echo"alert('".$text."');";
			echo"window.location='".$path."';";
			echo"</script>";*/
		}
		echo json_encode($arr_output);
	}

	public function logout() {
		$sess = $this->session->userdata("user");
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$emp_c = $sess['emp_c'];
		$this->load->model('User_model', 'login', TRUE);
		$this->login->loadDB();
		$arr_update = array(
			'lang_last' => $lang
		);
		$this->db->where('u_id',$sess['u_id']);
		$this->db->update('LMS_USP',$arr_update);

		$redirect = isset( $_GET['redirect'] ) ? $_GET['redirect'] : 'dashboard';
		$this->login->logout($emp_c);
		$this->load->model('Log_model', 'lg', FALSE);
		$this->lg->loadDB();
		$this->lg->record('home', 'user id '.$emp_c.'logged out.');
		$this->lg->closeDB();
		$this->session->sess_destroy();
		$this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, no-transform, max-age=0, post-check=0, pre-check=0");
		$this->output->set_header("Pragma: no-cache");
		redirect(base_url().'home?redirect='.$redirect, 'refresh');
	}

}
