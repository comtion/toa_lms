<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function change_lang($lang){
		$this->config->set_item('language', $lang);
		$this->session->set_userdata('lang', $lang);
		redirect($_SERVER['HTTP_REFERER']);
	}
	public function index()
	{
		$arr['page'] = 'home';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		//echo $lang;
		$sess = $this->session->userdata("user");
    	date_default_timezone_set("Asia/Bangkok");
    	if(!empty($sess)){
    		redirect(base_url().'dashboard', 'refresh');
    	}
		$arr['dest'] = isset( $_GET['redirect'] ) ? $_GET['redirect'] : 'dashboard';
		$arr['emp_c'] = $sess['emp_c'];
		$arr['lang'] = $lang;
		$arr['user'] = $sess;
		$arr['com_admin'] = $sess['com_admin'];
		$arr['com_id'] = $sess['com_id'];
		$this->load->model('Home_model', 'home', FALSE);
		$this->load->model('Course_model', 'course', FALSE);
    	$this->load->model('Coursegroup_model', 'coursegroup', TRUE);
		$this->home->loadDB();
    	$this->coursegroup->loadDB();
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->func_query->loadDB();
		$arr['useron'] = $this->home->onlineUser();
		$arr['pic'] = $this->home->getpic();
		if(empty($sess)){
				$arr['cos_sample'] = $this->func_query->query_result('LMS_COS_HIGHLIGHT','LMS_COS','LMS_COS_HIGHLIGHT.cos_id = LMS_COS.cos_id','','LMS_COS.cos_isDelete="0" and LMS_COS.cos_public="1" and LMS_COS_HIGHLIGHT.coshl_isDelete="0" and LMS_COS.com_id="2"','LMS_COS_HIGHLIGHT.cos_id DESC','',4);
				$arr['web_recom'] = $this->func_query->query_result('LMS_WEB','','','','web_status="1" and web_isDelete="0"','LMS_WEB.web_id DESC','',8);
		}
		$arr['detail_about'] = $this->course->query_data_onupdate('1', 'LMS_ABOUT','da_id');
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

		$this->home->closeDB();

		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();
		$this->foot->closeDB();
		$this->load->view('frontend/home', $arr );
	}
	public function backoffice()
	{
		$arr['page'] = 'home';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		//echo $lang;
		$sess = $this->session->userdata("user");
		$arr['emp_c'] = $sess['emp_c'];
		$arr['lang'] = $lang;
		$arr['user'] = $sess;
		$arr['com_admin'] = $sess['com_admin'];
		$arr['com_id'] = $sess['com_id'];
		$this->load->model('Home_model', 'home', FALSE);
		$this->load->model('Course_model', 'course', FALSE);
    	$this->load->model('Coursegroup_model', 'coursegroup', TRUE);
		$this->home->loadDB();
    	$this->coursegroup->loadDB();
			$this->load->model('Manage_model', 'manage', FALSE);
			$this->manage->loadDB();
		$arr['useron'] = $this->home->onlineUser();
		$arr['pic'] = $this->home->getpic();
		$arr['testimonials'] = $this->home->gettestimonials();
        	$arr['arr_permission'] = $this->manage->chk_permission_page();
		$arr['detail_about'] = $this->course->query_data_onupdate('1', 'LMS_ABOUT','da_id');
		$arr['main_menu'] = $this->home->getmenu();
		$arr['sample_course'] = $this->home->get_samplecourse();
				$arr['rechk_permission_cg'] = $this->coursegroup->rechk_permission_cos();
					foreach ($arr['sample_course'] as $key_cg => $value_cg) {
						if(!in_array($value_cg['id'], $arr['rechk_permission_cg'])){
							unset($arr['sample_course'][$key_cg]);
						}
					}
		$arr['thefirstofcourse'] = $this->home->get_thefirstofcourse();

		$this->home->closeDB();

		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();
		$this->foot->closeDB();
		if(empty($sess)){
			$this->load->view('frontend/home_backend', $arr );
		}else{
			$this->load->view('frontend/home', $arr );
		}
	}
	public function about()
	{
		$arr['page'] = 'home/about';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		//echo $lang;
		$sess = $this->session->userdata("user");
		$arr['emp_c'] = $sess['emp_c'];
		$arr['lang'] = $lang;
		$arr['user'] = $sess;
		$this->load->model('Home_model', 'home', FALSE);
		$this->home->loadDB();
		$arr['useron'] = $this->home->onlineUser();
		$arr['pic'] = $this->home->getpic();


		$this->home->closeDB();

		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();
		$this->foot->closeDB();
		$this->load->view('frontend/about', $arr );
	}
	public function faq()
	{
		$arr['page'] = 'home/faq';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		//echo $lang;
		$sess = $this->session->userdata("user");
		$arr['emp_c'] = $sess['emp_c'];
		$arr['lang'] = $lang;
		$arr['user'] = $sess;
		$arr['com_admin'] = $sess['com_admin'];
		$arr['com_id'] = $sess['com_id'];
		$this->load->model('Home_model', 'home', FALSE);
		$this->home->loadDB();
			$this->load->model('Manage_model', 'manage', FALSE);
			$this->manage->loadDB();
		$arr['useron'] = $this->home->onlineUser();
		$arr['pic'] = $this->home->getpic();


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
		$arr['faq'] = $this->home->getfaq();
		$arr['faq_detail'] = $this->home->getfaq_detail();
		$num=0;
                      foreach ($arr['faq'] as $key) {
                        if($key['lang']==$lang){ 
                          $num++;
                        }
                      }
                      if($num==0){
                         redirect(base_url().'home', 'refresh');
                      }

		$this->home->closeDB();

		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();
		$this->foot->closeDB();
		$this->load->view('frontend/faq', $arr );
	}
	public function privacy_policy()
	{
		$arr['page'] = 'home/privacy_policy';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		//echo $lang;
		$sess = $this->session->userdata("user");
		$arr['emp_c'] = $sess['emp_c'];
		$arr['lang'] = $lang;
		$arr['user'] = $sess;
		$this->load->model('Home_model', 'home', FALSE);
		$this->home->loadDB();
		$arr['useron'] = $this->home->onlineUser();
		$arr['pic'] = $this->home->getpic();


		$this->home->closeDB();

		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();
		$this->foot->closeDB();
		$this->load->view('frontend/privacy_policy', $arr );
	}
	public function contact_us()
	{
		$arr['page'] = 'home/contact_us';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		//echo $lang;
		$sess = $this->session->userdata("user");
		$arr['emp_c'] = $sess['emp_c'];
		$arr['lang'] = $lang;
		$arr['user'] = $sess;
		$arr['com_admin'] = $sess['com_admin'];
		$arr['com_id'] = $sess['com_id'];
		$this->load->model('Home_model', 'home', FALSE);
		$this->home->loadDB();
		$arr['useron'] = $this->home->onlineUser();
		$arr['pic'] = $this->home->getpic();


		$this->home->closeDB();

		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();
		$this->foot->closeDB();
		$this->load->view('frontend/contact_us', $arr );
	}

	public function send_message()
	{
		$arr['page'] = 'home/send_message';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		//echo $lang;
		$sess = $this->session->userdata("user");
		$arr['emp_c'] = $sess['emp_c'];
		$arr['lang'] = $lang;
		$arr['user'] = $sess;
		$arr['com_admin'] = $sess['com_admin'];
		$arr['com_id'] = $sess['com_id'];
		$this->load->model('Home_model', 'home', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->load->model('User_model', 'login', TRUE);
		$this->login->loadDB();
		$this->home->loadDB();

		$contact_name = $this->input->post('contact_name');
		$contact_tel = $this->input->post('contact_tel');
		$contact_mail = $this->input->post('contact_mail');
		$contact_msg = $this->input->post('contact_msg');
		$contact_about = $this->input->post('contact_about');
		$emp_id = $this->input->post('emp_id');
		$fetch_chk =  $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_EMP.emp_c="'.$contact_mail.'" and LMS_EMP.emp_isDelete="0"');
		$fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
		$message = "Dear  ISUZU E-Learning System Administrator<br><br><br>Please use below information to unlock account.<br><br>Contact name: ".$contact_name."<br>Contact number: ".$contact_tel."<br>E-Mail: ".$contact_mail."<br>Message: ".$contact_msg;
		$output = array();
		if(count($fetch_chk)>0){
			if($fetch_chk['ug_id']=="1"){
					$fetch_super = $this->func_query->query_result('LMS_EMP','','','','emp_id in (select LMS_USP.emp_id from LMS_USP where ug_id="1") and emp_isDelete="0"','','LMS_EMP.email');
					if(count($fetch_super)){
						foreach ($fetch_super as $key_super => $value_super) {
							if($value_super['email']!=""){
								$this->db->sendEmail( $value_super['email'] , $message,'Please unlock account in ISUZU E-Learning System',$fetch_setmail);
							}
						}
						$output['status'] = "2";
					}else{
						$output['status'] = "0";
					}
			}else{
				if(in_array($fetch_chk['ug_id'], array('2','6'))){
					$fetch_super = $this->func_query->query_result('LMS_EMP','','','','emp_id in (select LMS_USP.emp_id from LMS_USP where ug_id="1") and emp_isDelete="0"','','LMS_EMP.email');
					if(count($fetch_super)){
						foreach ($fetch_super as $key_super => $value_super) {
							if($value_super['email']!=""){
								$this->db->sendEmail( $value_super['email'] , $message,'Please unlock account in ISUZU E-Learning System',$fetch_setmail);
							}
						}
						$output['status'] = "2";
					}else{
						$output['status'] = "0";
					}
				}else{
					$fetch_grcom = $this->func_query->query_result('LMS_EMP','','','','emp_id in (select LMS_USP.emp_id from LMS_USP where ug_id in (select LMS_USP_GP.ug_id from LMS_USP_GP where ug_name_en="Gr.Com Admin")) and com_id="'.$fetch_chk['com_id'].'" and emp_isDelete="0"','','LMS_EMP.email');
					if(count($fetch_grcom)){
						foreach ($fetch_grcom as $key_grcom => $value_grcom) {
							if($value_grcom['email']!=""){
								$this->db->sendEmail( $value_grcom['email'] , $message,'Please unlock account in ISUZU E-Learning System',$fetch_setmail);
							}
						}
						$output['status'] = "2";
					}else{
						$output['status'] = "0";
					}
				}
			}
		}else{
			$output['status'] = "11";
		}


		$this->home->closeDB();
		echo json_encode($output);
	}

	public function change( $type ){
		$this->session->set_userdata('lang',$type);
		redirect($_SERVER['HTTP_REFERER']);
	}
}
