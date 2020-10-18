<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends CI_Controller {

	public function ManageECT()
	{
		$arr['page'] = 'setting/ManageECT';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		
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
		$arr['data_fetch'] = $this->setting->fetch_data_ECT();

		$this->load->model('Manage_model', 'manage', FALSE);
        $this->manage->loadDB();
        $arr['arr_permission'] = $this->manage->chk_permission_page();
        $arr['btn_view'] = $this->manage->chk_permission($arr['page'],'ru_view');
		$arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
		$arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
        $arr['btn_add'] = $this->manage->chk_permission($arr['page'],'ru_add');
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
		$this->home->closeDB();
		$this->foot->closeDB();
		$this->load->view('frontend/manageect', $arr );
	}

	public function ManageBanner()
	{
		$arr['page'] = 'setting/ManageBanner';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		
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
		$arr['data_fetch'] = $this->setting->fetch_data_ECT();

		$this->load->model('Manage_model', 'manage', FALSE);
        $this->manage->loadDB();
        $arr['arr_permission'] = $this->manage->chk_permission_page();
        $arr['btn_view'] = $this->manage->chk_permission('setting/ManageECT','ru_view');
		$arr['btn_update'] = $this->manage->chk_permission('setting/ManageECT','ru_edit');
		$arr['btn_delete'] = $this->manage->chk_permission('setting/ManageECT','ru_del');
        $arr['btn_add'] = $this->manage->chk_permission('setting/ManageECT','ru_add');
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
		$this->home->closeDB();
		$this->foot->closeDB();
		$this->load->view('frontend/managebanner', $arr );
	}

	public function sample_course()
	{
		$arr['page'] = 'setting/sample_course';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		
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
		$arr['data_fetch'] = $this->setting->fetch_data_ECT();

		$this->load->model('Manage_model', 'manage', FALSE);
        $this->manage->loadDB();
        $arr['arr_permission'] = $this->manage->chk_permission_page();
        $arr['btn_view'] = $this->manage->chk_permission('setting/ManageECT','ru_view');
		$arr['btn_update'] = $this->manage->chk_permission('setting/ManageECT','ru_edit');
		$arr['btn_delete'] = $this->manage->chk_permission('setting/ManageECT','ru_del');
        $arr['btn_add'] = $this->manage->chk_permission('setting/ManageECT','ru_add');
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
		$this->home->closeDB();
		$this->foot->closeDB();
		$this->load->view('frontend/sample_course', $arr );
	}

	public function recommended_sites()
	{
		$arr['page'] = 'setting/recommended_sites';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		
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
		$arr['data_fetch'] = $this->setting->fetch_data_ECT();

		$this->load->model('Manage_model', 'manage', FALSE);
        $this->manage->loadDB();
        $arr['arr_permission'] = $this->manage->chk_permission_page();
        $arr['btn_view'] = $this->manage->chk_permission('setting/ManageECT','ru_view');
		$arr['btn_update'] = $this->manage->chk_permission('setting/ManageECT','ru_edit');
		$arr['btn_delete'] = $this->manage->chk_permission('setting/ManageECT','ru_del');
        $arr['btn_add'] = $this->manage->chk_permission('setting/ManageECT','ru_add');
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
		$this->home->closeDB();
		$this->foot->closeDB();
		$this->load->view('frontend/recommended_sites', $arr );
	}

	public function ManageBannerCourse()
	{
		$arr['page'] = 'setting/ManageBannerCourse';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		
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
		$arr['data_fetch'] = $this->setting->fetch_data_managebannercourse();

		$this->load->model('Manage_model', 'manage', FALSE);
        $this->manage->loadDB();
        $arr['arr_permission'] = $this->manage->chk_permission_page();
        $arr['btn_view'] = $this->manage->chk_permission('setting/ManageECT','ru_view');
		$arr['btn_update'] = $this->manage->chk_permission('setting/ManageECT','ru_edit');
		$arr['btn_delete'] = $this->manage->chk_permission('setting/ManageECT','ru_del');
        $arr['btn_add'] = $this->manage->chk_permission('setting/ManageECT','ru_add');
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
		$this->home->closeDB();
		$this->foot->closeDB();
		$this->load->view('frontend/managebannercourse', $arr );
	}

	public function ManageSSO()
	{
		$arr['page'] = 'setting/ManageECT';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		
			$arr['emp_c'] = $sess['emp_c'];
			$arr['com_admin'] = $sess['com_admin'];
			$arr['com_id'] = $sess['com_id'];
		$arr['lang'] = $lang;
		$arr['user'] = $sess;
		$this->load->model('Home_model', 'home', FALSE);
		$this->home->loadDB();
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->func_query->loadDB();

		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();
		$arr['data_fetch'] = $this->func_query->query_row("LMS_SETTING_SSO","","","","sso_id='1'");

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
		$this->home->closeDB();
		$this->foot->closeDB();
		$this->load->view('frontend/managesso', $arr );
	}

	public function ManageEvent()
	{
		$arr['page'] = 'setting/ManageEvent';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		
			$arr['emp_c'] = $sess['emp_c'];
			$arr['com_admin'] = $sess['com_admin'];
			$arr['com_id'] = $sess['com_id'];
		$arr['lang'] = $lang;
		$arr['user'] = $sess;
		$this->load->model('Home_model', 'home', FALSE);
		$this->home->loadDB();
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->func_query->loadDB();

		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();

		$this->load->model('Manage_model', 'manage', FALSE);
        $this->manage->loadDB();
        $arr['arr_permission'] = $this->manage->chk_permission_page();
        $arr['btn_view'] = $this->manage->chk_permission($arr['page'],'ru_view');
		$arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
		$arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
        $arr['btn_add'] = $this->manage->chk_permission($arr['page'],'ru_add');
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
		$this->home->closeDB();
		$this->foot->closeDB();
		$this->load->view('frontend/manageevent', $arr );
	}

	public function format_email(){
		$arr['page'] = 'setting/format_email';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		
			$arr['emp_c'] = $sess['emp_c'];
			$arr['com_admin'] = $sess['com_admin'];
			$arr['com_id'] = $sess['com_id'];
		$arr['lang'] = $lang;
		$arr['user'] = $sess;
		$this->load->model('Home_model', 'home', FALSE);
		$this->home->loadDB();
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		$this->load->model('Course_model', 'course', FALSE);
		$this->course->loadDB();

		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();
		$arr['data_fetch'] = $this->course->query_data_onupdate_result('', 'LMS_SENDMAIL_FORM','');

		$this->load->model('Manage_model', 'manage', FALSE);
        $this->manage->loadDB();
		$arr['btn_add'] = $this->manage->chk_permission($arr['page'],'ru_add');
		$arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
		$arr['btn_delete'] = $this->manage->chk_permission('setting/ManageECT','ru_del');
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
		$this->home->closeDB();
		$this->foot->closeDB();
		$this->load->view('frontend/format_email', $arr );
	}

	public function fetch_detail_format_email(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		$query = $this->setting->fetch_data_format_email();
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

	public function fetch_detail_event(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		$query = $this->setting->fetch_data_event();
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

	public function query_rowdata(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$user = $this->session->userdata("user");
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		$fieldname = isset($_REQUEST['fieldname'])?$_REQUEST['fieldname']:"";
		$id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
		$dataname = isset($_REQUEST['dataname'])?$_REQUEST['dataname']:"";
		$this->db->where($fieldname,$id);
		$this->db->from($dataname);
		$query = $this->db->get();
		$fetch = $query->row_array();
		if(count($fetch)>0){
			$fetch['isData'] = "1";
		}else{
			$fetch['isData'] = "0";
		}
		echo json_encode($fetch);
	}

	public function setting_email(){
		$arr['page'] = 'setting/setting_email';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		
			$arr['emp_c'] = $sess['emp_c'];
			$arr['com_admin'] = $sess['com_admin'];
			$arr['com_id'] = $sess['com_id'];
		$arr['lang'] = $lang;
		$arr['user'] = $sess;
		$this->load->model('Home_model', 'home', FALSE);
		$this->home->loadDB();
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		$this->load->model('Course_model', 'course', FALSE);
		$this->course->loadDB();

		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();
		$arr['data_fetch'] = $this->course->query_data_onupdate('1', 'LMS_SETTING_MAIL','sm_id');

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
		$this->home->closeDB();
		$this->foot->closeDB();
		$this->load->view('frontend/setting_email', $arr );
	}

	public function ManageFAQ()
	{
		$arr['page'] = 'setting/ManageFAQ';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		
			$arr['emp_c'] = $sess['emp_c'];
			$arr['com_admin'] = $sess['com_admin'];
			$arr['com_id'] = $sess['com_id'];
		$arr['lang'] = $lang;
		$arr['user'] = $sess;
		$this->load->model('Home_model', 'home', FALSE);
		$this->home->loadDB();
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		$this->load->model('Manage_model', 'manage', FALSE);
        $this->manage->loadDB();
        $arr['arr_permission'] = $this->manage->chk_permission_page();
        $arr['btn_view'] = $this->manage->chk_permission($arr['page'],'ru_view');
		$arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
		$arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
        $arr['btn_add'] = $this->manage->chk_permission($arr['page'],'ru_add');
			if($arr['btn_view']!="1"){
				redirect(base_url().'dashboard') ;
			}
		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();
		$arr['data_fetch'] = $this->setting->fetch_data_faq();

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
		$this->foot->closeDB();
		$this->load->view('frontend/managefaq', $arr );
	}

	public function fetch_sort(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
		$user = $this->session->userdata('user');
		$this->lang->load($lang,$lang);
		$this->load->model('Setting_model', 'setting', TRUE);
		$this->setting->loadDB();

		$query = $this->setting->fetch_data_sort($_REQUEST['com_id']);
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
	public function check_countsortcos(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
		$user = $this->session->userdata('user');
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', TRUE);
		$this->manage->loadDB();

		$arr = array();
		$arr['count_coss'] = $this->manage->countrecordcos_sort($_REQUEST['com_id']);
      	echo json_encode($arr);
      	exit();
	}

	public function fetch_mainmenu(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
		$user = $this->session->userdata('user');
		$this->lang->load($lang,$lang);
		$this->load->model('Setting_model', 'setting', TRUE);
		$this->setting->loadDB();

		$query = $this->setting->fetch_data_mainmenu($_REQUEST['com_id']);
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

	public function fetch_detail_menu(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
		$user = $this->session->userdata('user');
		$this->lang->load($lang,$lang);
		$this->load->model('Setting_model', 'setting', TRUE);
		$this->setting->loadDB();

		$query = $this->setting->fetch_data_menu();
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

	public function fetch_detail_faqmain(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
		$user = $this->session->userdata('user');
		$this->lang->load($lang,$lang);
		$this->load->model('Setting_model', 'setting', TRUE);
		$this->setting->loadDB();

		$query = $this->setting->fetch_data_faq();
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

	public function ManageMainmenu()
	{
		$arr['page'] = 'setting/ManageMainmenu';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		
			$arr['emp_c'] = $sess['emp_c'];
			$arr['com_admin'] = $sess['com_admin'];
			$arr['com_id'] = $sess['com_id'];
		$arr['lang'] = $lang;
		$arr['user'] = $sess;
		$this->load->model('Home_model', 'home', FALSE);
		$this->home->loadDB();
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		$this->load->model('Manage_model', 'manage', FALSE);
        $this->manage->loadDB();
        $arr['arr_permission'] = $this->manage->chk_permission_page();
        $arr['btn_view'] = $this->manage->chk_permission('setting/ManageECT','ru_view');
		$arr['btn_update'] = $this->manage->chk_permission('setting/ManageECT','ru_edit');
		$arr['btn_delete'] = $this->manage->chk_permission('setting/ManageECT','ru_del');
        $arr['btn_add'] = $this->manage->chk_permission('setting/ManageECT','ru_add');
			if($arr['btn_view']!="1"){
				redirect(base_url().'dashboard') ;
			}
		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();
		$arr['company_select'] = $this->manage->getCompany();

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
		$this->foot->closeDB();
		$this->load->view('frontend/managemainmenu', $arr );
	}

	public function ManageMenu()
	{
		$arr['page'] = 'setting/ManageMenu';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		
			$arr['emp_c'] = $sess['emp_c'];
			$arr['com_admin'] = $sess['com_admin'];
			$arr['com_id'] = $sess['com_id'];
		$arr['lang'] = $lang;
		$arr['user'] = $sess;
		$this->load->model('Home_model', 'home', FALSE);
		$this->home->loadDB();
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		$this->load->model('Manage_model', 'manage', FALSE);
        $this->manage->loadDB();
        $arr['arr_permission'] = $this->manage->chk_permission_page();
        $arr['btn_view'] = $this->manage->chk_permission($arr['page'],'ru_view');
		$arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
		$arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
        $arr['btn_add'] = $this->manage->chk_permission($arr['page'],'ru_add');
			if($arr['btn_view']!="1"){
				redirect(base_url().'dashboard') ;
			}
		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();
		$arr['data_fetch'] = $this->setting->fetch_data_menu();

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
		$this->foot->closeDB();
		$this->load->view('frontend/managemenu', $arr );
	}

	public function ManageTestimonials()
	{
		$arr['page'] = 'setting/ManageTestimonials';
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		
			$arr['emp_c'] = $sess['emp_c'];
			$arr['com_admin'] = $sess['com_admin'];
			$arr['com_id'] = $sess['com_id'];
		$arr['lang'] = $lang;
		$arr['user'] = $sess;
		$this->load->model('Home_model', 'home', FALSE);
		$this->home->loadDB();
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();

		$this->load->model('Manage_model', 'manage', FALSE);
        $this->manage->loadDB();
        $arr['arr_permission'] = $this->manage->chk_permission_page();
        $arr['btn_view'] = $this->manage->chk_permission($arr['page'],'ru_view');

		$arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
		$arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
        $arr['btn_add'] = $this->manage->chk_permission($arr['page'],'ru_add');
			if($arr['btn_view']!="1"){
				redirect(base_url().'dashboard') ;
			}
		$this->load->model('Footer_model', 'foot', FALSE);
		$this->foot->loadDB();
		$arr['foote'] = $this->foot->getfooter();
		$arr['data_fetch'] = $this->setting->fetch_data_testimonials();

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
		$this->foot->closeDB();
		$this->load->view('frontend/managetestimonials', $arr );
	}

	public function insert_testimonials(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
        date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$emp_c = $sess['emp_c'];
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		$_REQUEST['tim_file'] = $_REQUEST['tim_file_ori'];
		if( isset( $_FILES['tim_file']) ){
			$imageSourcePath = $_FILES['tim_file']['tmp_name'];
			$imageTargetPath = ROOT_DIR."uploads/brand/".date('YmdHis').".jpg";
			if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
				$_REQUEST['tim_file'] = date('YmdHis').".jpg";
			}
		}
		$data = array(
			'tim_file'=>$_REQUEST['tim_file'],
			'tim_title'=>$_REQUEST['tim_title'],
			'tim_moddate'=>date('Y-m-d H:i')
		);
			if($_REQUEST['operation']=="Add"){
				$date['tim_createdate'] = date('Y-m-d H:i');
				$msg = $this->setting->create_testimonials($data);
			}else{
				$msg = $this->setting->update_testimonials($data,$_REQUEST['tim_id']);
			}
		echo $msg;
	}


	public function insert_bannercourse(){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Fetchdata_model', 'fetch', FALSE);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    date_default_timezone_set("Asia/Bangkok");
	    $sess = $this->session->userdata("user");
	    $emp_c = $sess['emp_c'];
	    $this->fetch->loadDB();
	    $output = array();
	    if(isset($_REQUEST)&&!empty($sess['emp_c'])){
	        $bc_name_th = isset($_REQUEST['bc_name_th'])?$_REQUEST['bc_name_th']:"";
	        $bc_name_eng = isset($_REQUEST['bc_name_eng'])?$_REQUEST['bc_name_eng']:"";
	        $bc_name_jp = isset($_REQUEST['bc_name_jp'])?$_REQUEST['bc_name_jp']:"";
	        $bc_type = isset($_REQUEST['bc_type'])?$_REQUEST['bc_type']:"";
	        $bc_status = isset($_REQUEST['bc_status'])?$_REQUEST['bc_status']:"0";

	        $arr_data = array(
	          'bc_name_th' => $bc_name_th,
	          'bc_name_eng' => $bc_name_eng,
	          'bc_name_jp' => $bc_name_jp,
	          'bc_type' => $bc_type,
	          'bc_status' => $bc_status,
	          'bc_modifiedby' => $sess['u_id'],
	          'bc_modifieddate' => date('Y-m-d H:i')
	        );

	        if(isset($_FILES['bc_image'])&&$_FILES['bc_image']!=""){
	          if( isset( $_FILES['bc_image']) ){
	              $imageSourcePath = $_FILES['bc_image']['tmp_name'];
	              $pathBG = $_FILES['bc_image']['name'];
	              if($pathBG!=""){
	                  $array_pathext = explode('.', $pathBG);
	                  $extension = end($array_pathext);
	                  $bc_image = "bannercos_".date('YmdHis').".".$extension;
	                  $imageTargetPath = ROOT_DIR."uploads/banner_course/".$bc_image;
	                  if($_REQUEST['operation']=="Edit"){
	                      $fetch_img = $this->func_query->query_row('LMS_BAN_COS','','','','bc_id="'.$_REQUEST['bc_id'].'"');
	                      if(count($fetch_img)>0&&$fetch_img['bc_image']!=""){
			                        if(is_file(ROOT_DIR."uploads/banner_course/".$fetch_img['bc_image'])) {
			                                unlink(ROOT_DIR."uploads/banner_course/".$fetch_img['bc_image']);
			                        }
	                      }
	                  }
	                  if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
	                      $arr_data['bc_image'] = $bc_image;
	                  }
	              }
	          }
	        }
	        if($_REQUEST['operation']=="Add"){

	            $arr_data['bc_createdate'] = date('Y-m-d H:i');
	            $arr_data['bc_createby'] = $sess['u_id'];
	          	$fetch_chk = $this->func_query->numrows('LMS_BAN_COS','','','',' bc_name_th="'.$arr_data['bc_name_th'].'" and bc_type="'.$arr_data['bc_type'].'" and bc_isDelete="0"');
	            if($fetch_chk==0){
	              $this->db->insert('LMS_BAN_COS', $arr_data);
	              $id = $this->db->insert_id();
	              if($id!=""){
	                $output['status'] = "2";
	              }else{
	                $output['status'] = "3";
	              }
	            }else{
	              $output['status'] = "1";
	            }
	        }else{
	            $this->db->where('bc_id',$_REQUEST['bc_id']);
	            $this->db->update('LMS_BAN_COS', $arr_data);
	            $output['status'] = "2";
	        }
	    }else{
	        $output['status'] = "0";
	    }
	    echo json_encode($output);

	}

	public function insert_template(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
        date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$emp_c = $sess['emp_c'];
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->setting->loadDB();
		$smf_type = isset($_REQUEST['smf_type'])?$_REQUEST['smf_type']:"";
		$smf_subject_th = isset($_REQUEST['smf_subject_th'])?$_REQUEST['smf_subject_th']:"";
		$smf_subject_en = isset($_REQUEST['smf_subject_en'])?$_REQUEST['smf_subject_en']:"";
		$smf_message_th = isset($_REQUEST['smf_message_th'])?$_REQUEST['smf_message_th']:"";
		$smf_message_en = isset($_REQUEST['smf_message_en'])?$_REQUEST['smf_message_en']:"";
		$smf_show = isset($_REQUEST['smf_show'])?$_REQUEST['smf_show']:"0";
		$operation = isset($_REQUEST['operation'])?$_REQUEST['operation']:"";
		$smf_id = isset($_REQUEST['smf_id'])?$_REQUEST['smf_id']:"";

		$data = array(
			'smf_type'=>$smf_type,
			'smf_subject_th'=>$smf_subject_th,
			'smf_subject_en'=>$smf_subject_en,
			'smf_message_th'=>$smf_message_th,
			'smf_message_en'=>$smf_message_en,
			'smf_show'=>$smf_show,
			'smf_modifiedby'=>$sess['u_id'],
			'smf_modifieddate'=>date('Y-m-d H:i')
		);

        if(isset($_FILES['smf_importimage'])&&$_FILES['smf_importimage']!=""){
          if( isset( $_FILES['smf_importimage']) ){
              $imageSourcePath = $_FILES['smf_importimage']['tmp_name'];
              $pathBG = $_FILES['smf_importimage']['name'];
              if($pathBG!=""){
                  $array_pathext = explode('.', $pathBG);
                  $extension = end($array_pathext);
                  $smf_importimage = "formatmail_".date('YmdHis').".".$extension;
                  $imageTargetPath = ROOT_DIR."uploads/formatmail_img/".$smf_importimage;
                  if($operation=="Edit"){
                      $fetch_img = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_id="'.$smf_id.'"');
                      if(count($fetch_img)>0&&$fetch_img['smf_importimage']!=""){
			                        if(is_file(ROOT_DIR."uploads/formatmail_img/".$fetch_img['smf_importimage'])) {
			                                unlink(ROOT_DIR."uploads/formatmail_img/".$fetch_img['smf_importimage']);
			                        }
                      }
                  }
                  if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
                      $data['smf_importimage'] = $smf_importimage;
                  }
              }
          }
        }

		/*if($smf_show=="1"){
			$data_status = array(
				'smf_show' => '0',
				'smf_modifiedby'=>$sess['u_id'],
				'smf_modifieddate'=>date('Y-m-d H:i')
			);
			$this->db->where('smf_type',$smf_type);
			$this->db->update('LMS_SENDMAIL_FORM',$data_status);
		}*/

			if($operation=="Add"){
				$fetch_rechk = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_type="'.$smf_type.'"');
				if(count($fetch_rechk)>0){
					$this->db->where('smf_type',$smf_type);
					$this->db->update('LMS_SENDMAIL_FORM',$data);
				}else{
					$data['smf_createby'] = $emp_c;
					$data['smf_createdate'] = date('Y-m-d H:i');
					$this->db->insert('LMS_SENDMAIL_FORM',$data);
				}
				$msg = "2";
			}else{
				$this->db->where('smf_id',$smf_id);
				$this->db->update('LMS_SENDMAIL_FORM',$data);
				$msg = "2";
			}
		echo $msg;
	}
	public function insert_banner(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		$emp_c = $sess['emp_c'];
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		$data = array(
			'com_id'=>$_REQUEST['com_id_banner']
		);

		if( isset( $_FILES['banner']) ){
			$imageSourcePath = $_FILES['banner']['tmp_name'];
            $pathBG = $_FILES['banner']['name'];
            $array_pathext = explode('.', $pathBG);
            $extension = end($array_pathext);
			$namefile = "banner_".date('YmdHis').".".$extension;
			$imageTargetPath = ROOT_DIR."uploads/banner/".$namefile;
			if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
				$data['banner'] = $namefile;
			}
		}
		$msg = $this->setting->insert_banner($data);
		echo $msg;
	}
	public function insert_banner_about(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
        date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$emp_c = $sess['emp_c'];
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
        date_default_timezone_set("Asia/Bangkok");
		$data = array(
			'time_created'=>date('Y-m-d H:i'),
			'emp_c'=>$sess['u_id']
		);
		if( isset( $_FILES['banner']) ){
			$imageSourcePath = $_FILES['banner']['tmp_name'];
            $pathBG = $_FILES['banner']['name'];
            $array_pathext = explode('.', $pathBG);
            $extension = end($array_pathext);
			$namefile = "banner_".date('YmdHis').".".$extension;
			$imageTargetPath = ROOT_DIR."uploads/banner/".$namefile;
			if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
				$data['banner'] = $namefile;
			}
		}
		$msg = $this->setting->insert_banner_about($data);
		echo $msg;
	}

	public function insert_settingemail(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		$emp_c = $sess['emp_c'];
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$this->load->model('Log_model', 'lg', FALSE);
	       	$this->lg->loadDB();
	        $this->lg->record('Setting', 'Setting Send Mail By '.$sess['fullname_th']);
			$msg = $this->setting->insert_settingemail($_REQUEST,'1');

		}
		echo $msg;
	}

	public function insert_about(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		$emp_c = $sess['emp_c'];
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$this->load->model('Log_model', 'lg', FALSE);
	       	$this->lg->loadDB();
	        $this->lg->record('Setting', 'Setting About By '.$sess['fullname_th']);
	        
			if(isset($_FILES['da_logo_top'])&&$_FILES['da_logo_top']!=""){
				if( isset( $_FILES['da_logo_top']) ){
					$imageSourcePath = $_FILES['da_logo_top']['tmp_name'];
					$imageTargetPath = ROOT_DIR."images/logo.png";
					move_uploaded_file( $imageSourcePath,$imageTargetPath );
					$_REQUEST['da_logo_top'] = base_url()."images/logo.png";
				}
			}
			if(isset($_FILES['da_logo_elearning'])&&$_FILES['da_logo_elearning']!=""){
				if( isset( $_FILES['da_logo_elearning']) ){
					$imageSourcePath = $_FILES['da_logo_elearning']['tmp_name'];
					$imageTargetPath = ROOT_DIR."images/elearning_logo.png";
					move_uploaded_file( $imageSourcePath,$imageTargetPath );
					$_REQUEST['da_logo_elearning'] = base_url()."images/elearning_logo.png";
				}
			}
			if(isset($_FILES['da_logo_footer'])&&$_FILES['da_logo_footer']!=""){
				if( isset( $_FILES['da_logo_footer']) ){
					$imageSourcePath = $_FILES['da_logo_footer']['tmp_name'];
					$imageTargetPath = ROOT_DIR."images/logo_white.png";
					move_uploaded_file( $imageSourcePath,$imageTargetPath );
					$_REQUEST['da_logo_footer'] = base_url()."images/logo_white.png";
				}
			}
			if(isset($_FILES['da_footer_background'])&&$_FILES['da_footer_background']!=""){
				if( isset( $_FILES['da_footer_background']) ){
					$imageSourcePath = $_FILES['da_footer_background']['tmp_name'];
					$imageTargetPath = ROOT_DIR."images/bg.jpg";
					move_uploaded_file( $imageSourcePath,$imageTargetPath );
					$_REQUEST['da_footer_background'] = base_url()."images/bg.jpg";
				}
			}
			unset($_REQUEST['myTable_length']);
			$msg = $this->setting->insert_about($_REQUEST,'1');
		}
		echo $msg;
	}

	public function insert_sso(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		$emp_c = $sess['emp_c'];
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$this->load->model('Log_model', 'lg', FALSE);
	       	$this->lg->loadDB();
	        $this->lg->record('Setting', 'Setting Single Sign On By '.$sess['fullname_th']);
			$msg = $this->setting->insert_sso($_REQUEST,'1');
		}
		echo $msg;
	}

	public function insert_samplecos(){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Fetchdata_model', 'fetch', FALSE);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	    date_default_timezone_set("Asia/Bangkok");
	    $sess = $this->session->userdata("user");
	    $emp_c = $sess['emp_c'];
	    $this->fetch->loadDB();
	    $output = array();
	    if(isset($_REQUEST)&&!empty($sess['emp_c'])){
	        $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
	        $arr = array(
	            'cos_id' => $cos_id,
	            'coshl_modifieddate' => date('Y-m-d H:i'),
	            'coshl_modifiedby' => $sess['u_id'],
	        );

	            $arr['coshl_createdate'] = date('Y-m-d H:i');
	            $arr['coshl_createby'] = $sess['u_id'];
	            $fetch_chk = $this->func_query->numrows('LMS_COS_HIGHLIGHT','','','','cos_id="'.$arr['cos_id'].'" and coshl_isDelete="0"');
	            if($fetch_chk==0){
	              $this->db->insert('LMS_COS_HIGHLIGHT', $arr);
	              $id = $this->db->insert_id();
	              if($id!=""){
	                $output['status'] = "2";
	              }else{
	                $output['status'] = "3";
	              }
	            }else{
	              $output['status'] = "1";
	            }
	    }else{
	        $output['status'] = "0";
	    }
	    echo json_encode($output);
	}

	public function insert_recommended_sites(){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Fetchdata_model', 'fetch', FALSE);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
	    date_default_timezone_set("Asia/Bangkok");
	    $sess = $this->session->userdata("user");
	    $emp_c = $sess['emp_c'];
	    $this->fetch->loadDB();
	    $output = array();
	    if(isset($_REQUEST)&&!empty($sess['emp_c'])){
	        $web_name_th = isset($_REQUEST['web_name_th'])?$_REQUEST['web_name_th']:"";
	        $web_name_en = isset($_REQUEST['web_name_en'])?$_REQUEST['web_name_en']:"";
	        $web_path = isset($_REQUEST['web_path'])?$_REQUEST['web_path']:"";
	        $web_status = isset($_REQUEST['web_status'])?$_REQUEST['web_status']:"0";
	        $web_id = isset($_REQUEST['web_id'])?$_REQUEST['web_id']:"";
	        $arr = array(
	            'web_name_th' => $web_name_th,
	            'web_name_en' => $web_name_en,
	            'web_path' => $web_path,
	            'web_status' => $web_status,
	            'web_modifieddate' => date('Y-m-d H:i'),
	            'web_modifiedby' => $sess['u_id'],
	        );

	        if(isset($_FILES['web_pathimg'])&&$_FILES['web_pathimg']!=""){
	          if( isset( $_FILES['web_pathimg']) ){
	              $imageSourcePath = $_FILES['web_pathimg']['tmp_name'];
	              $pathBG = $_FILES['web_pathimg']['name'];
	              if($pathBG!=""){
	                  $array_pathext = explode('.', $pathBG);
	                  $extension = end($array_pathext);
	                  $web_pathimg = "web_".date('YmdHis').".".$extension;
	                  $imageTargetPath = ROOT_DIR."uploads/file_forwebrecommended/".$web_pathimg;
	                  if($_REQUEST['operation']=="Edit"){
	                      $fetch_img = $this->func_query->query_row('LMS_WEB','','','','web_id="'.$_REQUEST['web_id'].'"');
	                      if(count($fetch_img)>0&&$fetch_img['web_pathimg']!=""){
	                          if(is_file(ROOT_DIR."uploads/file_forwebrecommended/".$fetch_img['web_pathimg'])) {
	                                unlink(ROOT_DIR."uploads/file_forwebrecommended/".$fetch_img['web_pathimg']);
	                          }
	                      }
	                  }
	                  if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
	                      $arr['web_pathimg'] = $web_pathimg;
	                  }
	              }
	          }
	        }

	        if($_REQUEST['operation']=="Add"){
	            $arr['web_createdate'] = date('Y-m-d H:i');
	            $arr['web_createby'] = $sess['u_id'];
	            $fetch_chk = $this->func_query->numrows('LMS_WEB','','','','web_name_th="'.$arr['web_name_th'].'" and web_name_en="'.$arr['web_name_en'].'" and web_isDelete="0"');
	            if($fetch_chk==0){
	              $this->db->insert('LMS_WEB', $arr);
	              $id = $this->db->insert_id();
	              if($id!=""){
	                $output['status'] = "2";
	              }else{
	                $output['status'] = "3";
	              }
	            }else{
	              $output['status'] = "1";
	            }
	        }else{
	            $arr['web_pathimg'] = isset($arr['web_pathimg'])?$arr['web_pathimg']:$_REQUEST['web_pathimg_ori'];
	            $this->db->where('web_id',$_REQUEST['web_id']);
	            $this->db->update('LMS_WEB', $arr);  
	            $output['status'] = "2";
	        }
	    }else{
	        $output['status'] = "0";
	    }
	    echo json_encode($output);
	}

	public function li_menu(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model','manage',FALSE);
		$this->manage->loadDB();
		$li_arr = $this->manage->checkmenu();
		$detailpos_arr = array();
		if(count($li_arr)>0){
			foreach ($li_arr as $key_li => $value_li) { 
				?>
	            <li class="dd-item" data-id="<?php echo $value_li['mu_id']; ?>" style="width:100%">
	                <div class="dd-handle" style="font-size: 18px;font-family: 'Prompt', sans-serif;"><i class="<?php echo $value_li['mu_icon']; ?>"></i> <?php if($lang=="thai"){echo $value_li['mu_name_th'];}else if($lang=="english"){echo $value_li['mu_name_en'];}else{echo $value_li['mu_name_jp'];} ?> </div>
	                <?php 
					$li_arr_sub = $this->manage->checkmenu_sub($value_li['mu_id']);
							if(count($li_arr_sub)>0){
	                ?>
	                <ol class="dd-list">
	                	<?php foreach ($li_arr_sub as $key_li_sub => $value_li_sub) {  ?>
	                	<li class="dd-item" data-id="<?php echo $value_li_sub['mu_id']; ?>">
	                            <div class="dd-handle" style="font-size: 18px;font-family: 'Prompt', sans-serif;"><i class="<?php echo $value_li_sub['mu_icon']; ?>"></i> <?php if($lang=="thai"){echo $value_li_sub['mu_name_th'];}else if($lang=="english"){echo $value_li_sub['mu_name_en'];}else{echo $value_li_sub['mu_name_jp'];} ?> </div>
	                    </li>
	                	<?php 	
									$li_arr_sub_b = $this->manage->checkmenu_sub($value_li_sub['mu_id']);
									if(count($li_arr_sub_b)>0){ ?>
				                <ol class="dd-list">
				                	<?php foreach ($li_arr_sub_b as $key_li_sub_b => $value_li_sub_b) {  ?>
				                		<li class="dd-item" data-id="<?php echo $value_li_sub_b['mu_id']; ?>">
					                            <div class="dd-handle" style="font-size: 18px;font-family: 'Prompt', sans-serif;"><i class="<?php echo $value_li_sub_b['mu_icon']; ?>"></i> <?php if($lang=="thai"){echo $value_li_sub_b['mu_name_th'];}else if($lang=="english"){echo $value_li_sub_b['mu_name_en'];}else{echo $value_li_sub_b['mu_name_jp'];} ?> </div>
					                    </li>
				                	<?php } ?>
				                </ol>
							<?php 	}
	                			} 
	                	?>
	                </ol>
	                <?php 	} ?>
	            </li>
	  <?php }
		}else{ ?>
			<?php echo label('datanotfound'); ?>	
	<?php }
	}


	public function edit_li_menu(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model','manage',FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$cos_id = "";
			$num = 1;
			$arr_out = array();
			print_r($_REQUEST);
			foreach ($_REQUEST['arr_obj'] as $key => $value) {
		      if(isset($value['children'])&&count($value['children'])>0){
		          $this->db->from('LMS_MENU');
		          $this->db->where('LMS_MENU.mu_status', '1');
		          $this->db->where('LMS_MENU.mu_id', $value['id']);
			      $query_loop = $this->db->get();
			      $fetch_loop = $query_loop->result_array();
			      if(count($fetch_loop)>0){
		            $data = array(
		              'mu_num' => $num,
		              'mu_parent' => ''
		            );
		          	$this->db->where('mu_id', $value['id']);
				    $this->db->update('LMS_MENU', $data);
				    $num++;
			      }
		      	foreach ($value['children'] as $key_child => $value_child) {
				    if(isset($value_child['children'])&&count($value_child['children'])>0){
				          $this->db->from('LMS_MENU');
				          $this->db->where('LMS_MENU.mu_status', '1');
				          $this->db->where('LMS_MENU.mu_id', $value_child['id']);
					      $query_loop = $this->db->get();
					      $fetch_loop = $query_loop->result_array();
					      if(count($fetch_loop)>0){
				            $data = array(
				              'mu_num' => $num,
				              'mu_parent' => ''
				            );
				          	$this->db->where('mu_id', $value_child['id']);
						    $this->db->update('LMS_MENU', $data);
						    $num++;
					      }
				      	foreach ($value_child['children'] as $key_child => $value_child_sub) {
				            $data = array(
				              'mu_num' => $num,
				              'mu_parent' => $value_child['id']
				            );
				          	$this->db->where('mu_id', $value_child_sub['id']);
						    $this->db->update('LMS_MENU', $data);$num++;
				      	}
				    }else{
				    }
			            $data = array(
			              'mu_num' => $num,
			              'mu_parent' => $value['id']
			            );
			          	$this->db->where('mu_id', $value_child['id']);
					    $this->db->update('LMS_MENU', $data);$num++;
		      	}
		      }else{
		          $this->db->from('LMS_MENU');
		          $this->db->where('LMS_MENU.mu_status', '1');
		          $this->db->where('LMS_MENU.mu_id', $value['id']);
			      $query_loop = $this->db->get();
			      $fetch_loop = $query_loop->result_array();
			      if(count($fetch_loop)>0){
		            $data = array(
		              'mu_num' => $num,
		              'mu_parent' => ''
		            );
		          	$this->db->where('mu_id', $value['id']);
				    $this->db->update('LMS_MENU', $data);
				    $num++;
			      }
		      }
			}
			$li_arr = $this->manage->checkmenu();
			foreach ($_REQUEST['arr_obj'] as $key => $value) {
	          $this->db->from('LMS_MENU');
	          $this->db->where('LMS_MENU.mu_status', '1');
	          $this->db->where('LMS_MENU.mu_id', $value['id']);
		      $query_loop = $this->db->get();
		      $fetch_loop = $query_loop->result_array();
		      if(count($fetch_loop)>0){
			    foreach ($li_arr as $key_li => $value_li) { 
			    	if($value_li['mu_id']==$value['id']){
			    		unset($li_arr[$key_li]);
			    	}
			    }
		      }
			}
			if(count($li_arr)>0){
				foreach ($li_arr as $key_li => $value_li) { 
		            $data = array(
		              'mu_num' => $num
		            );
		            $this->db->where('mu_id', $value_li['mu_id']);
				    $this->db->update('LMS_MENU', $data);
				    $num++;
				}
			}
			//$msg = $this->course->delete_data($_REQUEST['id_delete'],$_REQUEST['field'],$_REQUEST['table_name']);
		}
		//echo $msg;
	}

	public function insert_menu(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		$emp_c = $sess['emp_c'];
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->load->model('Log_model', 'lg', FALSE);
	    $this->lg->loadDB();
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$mu_customer = isset($_REQUEST['mu_customer']) ? $_REQUEST['mu_customer'] : '0';
			$data = array(
				'mu_name_th' => $_REQUEST['mu_name_th'],
				'mu_name_en' => $_REQUEST['mu_name_en'],
				'mu_icon' => $_REQUEST['mu_icon'],
				'mu_path' => $_REQUEST['mu_path'],
				'mu_customer' => $mu_customer
			);
			if($_REQUEST['operation']=="Add"){
				$data['mu_num'] = $this->setting->rechk_nummenu();
	        	$this->lg->record('Setting', 'Create Menu '.$_REQUEST['mu_name_th'].' By '.$sess['fullname_th']);
				$msg = $this->setting->create_menu($data);
			}else{
	        	$this->lg->record('Setting', 'Update Menu '.$_REQUEST['mu_name_th'].' By '.$sess['fullname_th']);
				$msg = $this->setting->update_menu($data,$_REQUEST['mu_id']);
			}
		}
		echo $msg;
	}


	public function insert_event(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
        date_default_timezone_set("Asia/Bangkok");
		$emp_c = $sess['emp_c'];
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->load->model('Log_model', 'lg', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$data = array(
				'con_title_th' => $_REQUEST['con_title_th'],
				'con_title_en' => $_REQUEST['con_title_en'],
				'con_detail_th' => $_REQUEST['con_detail_th'],
				'con_detail_en' => $_REQUEST['con_detail_en'],
				'con_datestart' => $_REQUEST['con_datestart'],
				'con_dateend' => $_REQUEST['con_dateend'],
				'con_modifiedby' => $sess['u_id'],
				'con_modifieddate' => date('Y-m-d H:i')
			);
			if($_REQUEST['operation']=="Add"){
				$data['con_createby'] = $sess['u_id'];
				$data['con_createdate'] = date('Y-m-d H:i');
	        	$this->lg->record('Setting', 'Create Event '.$_REQUEST['con_title_th'].' By '.$sess['fullname_th']);
				$msg = $this->setting->create_event($data);
			}else{
	        	$this->lg->record('Setting', 'Update Event '.$_REQUEST['con_title_th'].' By '.$sess['fullname_th']);
				$msg = $this->setting->update_event($data,$_REQUEST['con_id']);
			}
		}
		echo $msg;
	}

	public function insert_sortcourse(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		$emp_c = $sess['emp_c'];
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$this->db->from('LMS_COS_SORT');
			$this->db->join('LMS_COS','LMS_COS_SORT.cos_id = LMS_COS.id');
			$this->db->where('LMS_COS.com_id',$_REQUEST['com_id_sort']);
			$this->db->order_by('LMS_COS_SORT.coss_num','DESC');
			$query = $this->db->get();
			$fetch = $query->row_array();
			if(count($fetch)>0){
				$coss_num = intval($fetch['coss_num'])+1;
			}else{
				$coss_num = 1;
			}
			$data = array(
				'cos_id' => $_REQUEST['cos_id'],
				'coss_num' => $coss_num
			);
			if($_REQUEST['operation_sort']=="Add"){
				$this->db->insert('LMS_COS_SORT',$data);
				$msg = '2';
			}
		}
		echo $msg;
	}

	public function insert_mainmenu(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
        date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$emp_c = $sess['emp_c'];
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$mm_status = isset($_REQUEST['mm_status']) ? $_REQUEST['mm_status'] : '0';
			$data = array(
				'mm_txt_th1' => $_REQUEST['mm_txt_th1'],
				'mm_txt_th2' => $_REQUEST['mm_txt_th2'],
				'mm_txt_en1' => $_REQUEST['mm_txt_en1'],
				'mm_txt_en2' => $_REQUEST['mm_txt_en2'],
				'com_id' => $_REQUEST['com_id'],
				'mm_icon' => $_REQUEST['mm_icon'],
				'mm_status' => $mm_status,
				'mm_modifieddate' => date('Y-m-d H:i'),
				'mm_modifiedby' => $emp_c
			);
			if($_REQUEST['operation']=="Add"){
				$msg = $this->setting->create_mainmenu($data);
			}else{
				$msg = $this->setting->update_mainmenu($data,$_REQUEST['mm_id']);
			}
		}
		echo $msg;
	}

	public function insert_faq(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
        date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$emp_c = $sess['emp_c'];
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$data = array(
				'title' => $_REQUEST['title'],
				'lang' => $_REQUEST['lang'],
				'time_edit' => date('Y-m-d H:i'),
				'emp_c' => $emp_c
			);
			if($_REQUEST['operation']=="Add"){
				$date['time_created'] = date('Y-m-d H:i');
				$msg = $this->setting->create_faq_main($data);
			}else{
				$msg = $this->setting->update_faq($data,$_REQUEST['id']);
			}
		}
		echo $msg;
	}
	public function insert_faq_detail(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
        date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$emp_c = $sess['emp_c'];
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$data = array(
				'question' => $_REQUEST['question'],
				'answer' => $_REQUEST['answer'],
				'tid' => $_REQUEST['tid'],
				'time_edit' => date('Y-m-d H:i'),
				'emp_c' => $emp_c
			);
			if($_REQUEST['operation_detail']=="Add"){
				$date['time_created'] = date('Y-m-d H:i');
				$msg = $this->setting->create_faq_detail($data);
			}else{
				$msg = $this->setting->update_faq_detail($data,$_REQUEST['faq_detail_id']);
			}
		}
		echo $msg;
	}

	public function update_criteriascore(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['qizlv_id'],'LMS_QIZ_LEVEL','qizlv_id');
			echo json_encode($result);
		}
	}


	public function update_testimonials_data(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['tim_id_update'],'LMS_TESTIMONIALS','tim_id');
			echo json_encode($result);
		}
	}

	public function update_bannercourse_data(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['bc_id_update'],'LMS_BAN_COS','bc_id');
			echo json_encode($result);
		}
	}

	public function update_faq(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['id'],'LMS_FAQ','id');
			echo json_encode($result);
		}
	}

	public function update_menu(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['mu_id'],'LMS_MENU','mu_id');
			echo json_encode($result);
		}
	}

	public function update_mainmenu(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['mm_id'],'LMS_MAINMENU','mm_id');
			echo json_encode($result);
		}
	}

	public function update_faq_detail(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['id'],'LMS_FAQ_Q','id');
			echo json_encode($result);
		}
	}

	public function update_event(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['con_id'],'LMS_CONTENT','con_id');
			echo json_encode($result);
		}
	}
	public function delete_formatmail_data(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->load->model('Log_model', 'lg', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$this->load->model('Course_model', 'course', FALSE);
			$fetch = $this->course->query_data_onupdate($_REQUEST['smf_id_delete'],'LMS_SENDMAIL_FORM','smf_id');
	       	$this->lg->record('Setting', 'Delete Format E-Mail '.$fetch['smf_subject_th'].' By '.$sess['fullname_th']);
			$msg = $this->setting->delete_formatmail($_REQUEST['smf_id_delete']);
		}
		echo $msg;
	}

	public function upload_img_texteditor(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->load->model('Log_model', 'lg', FALSE);
		$this->setting->loadDB();

			reset($_FILES);
			$temp = current($_FILES);

			if (is_uploaded_file($temp['tmp_name'])) {
			    if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) {
			        header("HTTP/1.1 400 Invalid file name,Bad request");
			        return;
			    }
			    
			    // Validating File extensions
			    if (! in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array(
			        "gif",
			        "jpg",
			        "png"
			    ))) {
			        header("HTTP/1.1 400 Not an Image");
			        return;
			    }
			    
			    $fileName = ROOT_DIR."uploads/texteditor/". $temp['name'];
			    move_uploaded_file($temp['tmp_name'], $fileName);
			    
			    // Return JSON response with the uploaded file path.
			    echo json_encode(array(
			        'file_path' => base_url()."uploads/texteditor/". $temp['name']
			    ));
			}
	}

	public function delete_mainmenu_data(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->load->model('Log_model', 'lg', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$this->load->model('Course_model', 'course', FALSE);
			$fetch = $this->course->query_data_onupdate($_REQUEST['id_delete'],'LMS_MAINMENU','mm_id');
	       	$this->lg->record('Setting', 'Delete Main menu '.$fetch['mm_txt_th1'].' By '.$sess['fullname_th']);
			$msg = $this->setting->delete_mainmenu($_REQUEST['id_delete']);
		}
		echo $msg;
	}
	public function delete_menu_data(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->load->model('Log_model', 'lg', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$this->load->model('Course_model', 'course', FALSE);
			$fetch = $this->course->query_data_onupdate($_REQUEST['id_delete'],'LMS_MENU','mu_id');
	       	$this->lg->record('Setting', 'Delete Menu '.$fetch['mu_name_th'].' By '.$sess['fullname_th']);
			$msg = $this->setting->delete_menu($_REQUEST['id_delete']);
		}
		echo $msg;
	}

	public function delete_faq_data(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$msg = $this->setting->delete_faq($_REQUEST['id_delete']);
		}
		echo $msg;
	}
	public function delete_event_data(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$msg = $this->setting->delete_event_data($_REQUEST['id_delete']);
		}
		echo $msg;
	}
	public function delete_banner(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$msg = $this->setting->delete_banner($_REQUEST['id_delete']);
		}
		echo $msg;
	}
	public function delete_banner_about(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$msg = $this->setting->delete_banner_about($_REQUEST['id_delete']);
		}
		echo $msg;
	}
	public function delete_testimonials_data(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$msg = $this->setting->delete_testimonials($_REQUEST['tim_id_delete']);
		}
		echo $msg;
	}
	public function delete_faq_data_detail(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$msg = $this->setting->delete_faq_detail($_REQUEST['id_delete']);
		}
		echo $msg;
	}
	public function delete_bannercourse_data(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$msg = $this->setting->delete_bannercourse($_REQUEST['bc_id_delete']);
		}
		echo $msg;
	}

	public function fetch_detail_faq( $tid ){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		$query = $this->setting->fetch_data_faq_detail($tid);
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

	public function fetch_samplecos(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		$query = $this->setting->fetch_data_samplecos();
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

	public function fetch_banner($com_id = ''){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		$query = $this->setting->fetch_data_banner($com_id);
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

	public function fetch_recommended_sites(){
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		$query = $this->setting->fetch_data_recommended_sites();
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

	public function import_question(){
  		require_once(APPPATH.'libraries/FPDF/Classes/PHPExcel.php');
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$user = $this->session->userdata('user');
	    date_default_timezone_set("Asia/Bangkok");
	    $sess = $this->session->userdata("user");
		$this->load->model('Setting_model', 'setting', TRUE);
		$this->load->model('Function_query_model', 'func_query', TRUE);
		$this->load->model('Log_model', 'lg', FALSE);
		$this->setting->loadDB();
	    $arr_output = array();
	    $result_str = "";
		if(count($_REQUEST)>0){
				$fetch_qiz = $this->func_query->query_row('LMS_QIZ','','','','qiz_id="'.$_REQUEST['qiz_id_question_import'].'"');
				if(count($fetch_qiz)>0){
					$quiz_lang = explode(',', $fetch_qiz['quiz_lang']);

					$file_import_question = $_FILES["file_import_question"]["name"];

					$excel_file = $_FILES['file_import_question']['tmp_name'];
					$path_parts = pathinfo($file_import_question);
					$excel_path = "importques_".date('YmdHis').".".$path_parts['extension'];

					$excelTargetPath = ROOT_DIR."uploads/excel/".$excel_path;
					if( move_uploaded_file( $excel_file,$excelTargetPath ) ){

						$path = './uploads/excel/'.basename($excel_path);
						$objPHPExcel = PHPExcel_IOFactory::load($path);
				        $result_arr = array();
				        $result_arr['success_count'] = 0;
				        $result_arr['duplicate_count'] = 0;
				        $result_arr['error_count'] = 0;
				        $result_arr['success_data'] = array();
				        $result_arr['duplicate_data'] = array();
				        $result_arr['error_data'] = array();
						foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
							$worksheetTitle     = $worksheet->getTitle();
							$highestRow         = $worksheet->getHighestRow(); // e.g. 10
							$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
							$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
							//$nrColumns = ord($highestColumn) - 64;

							for ($row = 2; $row <= $highestRow; ++ $row) {
								$dep_name_th = '';
								$dep_name_en = '';
								$posi_name_th = '';
								$posi_name_en = '';
								$rechk_val = 1;
								$arr_ques = array();
								$arr_multi = array();
								$arr_ques['qiz_id'] = $_REQUEST['qiz_id_question_import'];

								for ($col = 0; $col < $highestColumnIndex; ++ $col) {
							        	$cell = $worksheet->getCellByColumnAndRow($col, $row);
							            $val = $cell->getValue();
							            $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
									if($col==0){ $arr_ques['ques_name_th'] = $val; }
									if($col==1){ $arr_ques['ques_info_th'] = $val; }
									if($col==2){ $arr_ques['ques_name_eng'] = $val; }
									if($col==3){ $arr_ques['ques_info_eng'] = $val; }
									if($col==4){ 
										if($val=="Display"){
											$val = '1';
										}else{
											$val = '0';
										}
										$arr_ques['ques_status'] = $val; 
									}
									if($col==5){ $arr_ques['ques_score'] = $val; }
									if($col==6){ 
										if($val=="Short answer"){
											$val = 'sa';
										}else if($val=="Long answer"){
											$val = 'sub';
										}else if($val=="Multiple choice"){
											$val = 'multi';
										}else{
											$val = '2choice';
										}
										$arr_ques['ques_type'] = $val; 
									}
									if($col==7){ $arr_multi['mul_c1_th'] = $val; }
									if($col==8){ $arr_multi['mul_c2_th'] = $val; }
									if($col==9){ $arr_multi['mul_c3_th'] = $val; }
									if($col==10){ $arr_multi['mul_c4_th'] = $val; }
									if($col==11){ $arr_multi['mul_c5_th'] = $val; }
									if($col==12){ $arr_multi['mul_c1_eng'] = $val; }
									if($col==13){ $arr_multi['mul_c2_eng'] = $val; }
									if($col==14){ $arr_multi['mul_c3_eng'] = $val; }
									if($col==15){ $arr_multi['mul_c4_eng'] = $val; }
									if($col==16){ $arr_multi['mul_c5_eng'] = $val; }
									if($col==17){ 
										$val = str_replace(" ","",$val);
										$arr = explode(",",$val);
										$str = "";
										for ($i=0; $i < count($arr); $i++) { 
											if(intval($arr[$i])<=5){
												$str .= "mul_c".$arr[$i];
											}
											if($i<(count($arr)-1)){
												$str .= ",";
											}
										}
										$arr_multi['mul_answer'] = $str; 
									}
								}
								$lang_arr = array();
								$amount_lang = 0;
								if(isset($arr_ques['ques_name_th'])&&$arr_ques['ques_name_th']!=""){
										array_push($lang_arr, 'th');
										$amount_lang++;
								}
								if(isset($arr_ques['ques_name_eng'])&&$arr_ques['ques_name_eng']!=""){
										array_push($lang_arr, 'eng');
										$amount_lang++;
								}
								$chklang = 0;
							                  if($lang=="thai"){ 
							                    $ques_name = $arr_ques['ques_name_th']!=""?$arr_ques['ques_name_th']:$arr_ques['ques_name_eng'];
							                  }else{ 
							                    $ques_name = $arr_ques['ques_name_eng']!=""?$arr_ques['ques_name_eng']:$arr_ques['ques_name_th'];
							                  }
							    $valuechk=1;
							    if($fetch_qiz['quiz_random_choice']=="1"||$fetch_qiz['quiz_ishint']=="1"||$fetch_qiz['quiz_model']=="1"){
							    	if(!in_array($arr_ques['ques_type'], array('multi','2choice'))){
							    		$valuechk=0;
							    	}
							    }
							    $rechk_null = 0;
                                for ($i=0;$i<count($quiz_lang);$i++) {
                                  if($quiz_lang[$i]=="th"){
                                    $ques_name_th = $arr_ques['ques_name_th'];
                                    if($ques_name_th==""){
                                        $rechk_null++;
                                    }
                                    if($arr_ques['ques_type']=="2choice"||$arr_ques['ques_type']=="multi"){
                                      if($arr_multi['mul_c1_th']==""){
                                          $rechk_null++;
                                      }
                                      if($arr_multi['mul_c2_th']==""){
                                          $rechk_null++;
                                      }
                                    }
                                    if($arr_ques['ques_type']=="multi"){
                                    	$arr_mul_answer = explode(',', $arr_multi['mul_answer']);
                                    	if(count($arr_mul_answer)>0){
                                    		for($mul=0;$mul<count($arr_mul_answer);$mul++){
                                    			$var_chkchoice = isset($arr_multi[$arr_mul_answer[$mul].'_th'])?$arr_multi[$arr_mul_answer[$mul].'_th']:"";
                                    			if($var_chkchoice==""){
                                            		$rechk_null++;
                                    			}
                                    		}
                                    	}
                                    }
                                  }
                                  if($quiz_lang[$i]=="eng"){

                                    $ques_name_eng = $arr_ques['ques_name_eng'];
                                    if($ques_name_eng==""){
                                        $rechk_null++;
                                    }
                                    if($arr_ques['ques_type']=="2choice"||$arr_ques['ques_type']=="multi"){
                                      if($arr_multi['mul_c1_eng']==""){
                                          $rechk_null++;
                                      }
                                      if($arr_multi['mul_c2_eng']==""){
                                          $rechk_null++;
                                      }
                                    }
                                    if($arr_ques['ques_type']=="multi"){
                                    	$arr_mul_answer = explode(',', $arr_multi['mul_answer']);
                                    	if(count($arr_mul_answer)>0){
                                    		for($mul=0;$mul<count($arr_mul_answer);$mul++){
                                    			$var_chkchoice = isset($arr_multi[$arr_mul_answer[$mul].'_eng'])?$arr_multi[$arr_mul_answer[$mul].'_eng']:"";
                                    			if($var_chkchoice==""){
                                            		$rechk_null++;
                                    			}
                                    		}
                                    	}
                                    }
                                  }
                                }
                                if($arr_ques['ques_type']=="multi"){
                                  if(count($quiz_lang)>1){
                                      for($chkloop=1;$chkloop<=5;$chkloop++){
                                          $langtotal = 0;
                                          $langtotal_null = 0;
                                          for ($i=0;$i<count($quiz_lang);$i++) {
                                              if($quiz_lang[$i]=="th"){
                                                $mul_th = $arr_multi['mul_c'.$chkloop.'_th'];
                                                if($mul_th!=""){
                                                  $langtotal_null++;
                                                }
                                              }
                                              if($quiz_lang[$i]=="eng"){
                                                $langtotal++;
                                                $mul_eng = $arr_multi['mul_c'.$chkloop.'_eng'];
                                                if($mul_eng!=""){
                                                  $langtotal_null++;
                                                }
                                              }
                                          }
                                          if($langtotal_null>0&&count($quiz_lang)!=$langtotal_null){
                                            $rechk_null++;
                                          }
                                      }
                                  }
                                }
                                if($rechk_null>0){
                                    $rechk_val = 0;
                                }
								if(count($quiz_lang)>0&&count($lang_arr)>0&&$valuechk==1&&$rechk_val==1){
									/*for($a=0;$a<count($quiz_lang);$a++){
										if(in_array($quiz_lang[$a], $lang_arr)){
											$chklang++;
										}
									}
									if($chklang==count($quiz_lang)){*/
										$where_ques = "";
										if($arr_ques['ques_name_th']!=""){
											$where_ques .= "ques_name_th = '".htmlentities($arr_ques['ques_name_th'])."'";
										}
										if($arr_ques['ques_name_eng']!=""){
											 if($where_ques!=""){
											 	$where_ques .= ' and ';
											 }
											$where_ques .= "ques_name_eng = '".htmlentities($arr_ques['ques_name_eng'])."'";
										}
										$where = 'qiz_id="'.$_REQUEST['qiz_id_question_import'].'" and ques_type="'.$arr_ques['ques_type'].'" and ('.$where_ques.') and ques_isDelete="0"';
										$num_chk = $this->func_query->numrows('LMS_QUES','','','',$where);
										if($num_chk==0){
											$arr_ques['ques_modifiedby'] = $sess['u_id']; 
											$arr_ques['ques_modifieddate'] = date('Y-m-d H:i'); 
											$arr_ques['ques_createby'] = $sess['u_id']; 
											$arr_ques['ques_createdate'] = date('Y-m-d H:i'); 
											$this->db->insert('LMS_QUES',$arr_ques);
			                      			$ques_id = $this->db->insert_id();
			                      			if($ques_id==""){
							                    $result_arr['error_count']++;
							                    array_push($result_arr['error_data'], $ques_name);
			                      			}else{
							                    $result_arr['success_count']++;
							                    array_push($result_arr['success_data'], $ques_name);
			                      			}
											if(($arr_ques['ques_type']=="multi"||$arr_ques['ques_type']=="2choice")&&$ques_id!=""){
												$ques_id = $this->db->insert_id();
												$arr_multi['ques_id'] = $ques_id;
												$arr_multi['mul_createby'] = $sess['u_id']; 
												$arr_multi['mul_createdate'] = date('Y-m-d H:i'); 
												$arr_multi['mul_modifiedby'] = $sess['u_id']; 
												$arr_multi['mul_modifieddate'] = date('Y-m-d H:i'); 
												$this->db->insert('LMS_QUES_MUL',$arr_multi);
											}
										}else{
											$result_arr['duplicate_count']++;
							                array_push($result_arr['duplicate_data'], $ques_name);
										}
									/*}else{
										$result_arr['error_count']++;
					                	array_push($result_arr['error_data'], $ques_name);
									}*/
								}else{
									$result_arr['error_count']++;
					                array_push($result_arr['error_data'], $ques_name);
								}
							}
						}


			            $result_str = "";
			            $result_str .= label('result_success')." : ".$result_arr['success_count']."<br>";
			            if(count($result_arr['success_data'])>0){
			            	$quiz_numofshown = intval($fetch_qiz['quiz_numofshown'])+count($result_arr['success_data']);
			            	$arr_update = array(
			            		'quiz_numofshown'=>$quiz_numofshown
			            	);
			            	$this->db->where('qiz_id',$_REQUEST['qiz_id_question_import']);
			            	$this->db->update('LMS_QIZ',$arr_update);
			              $result_str .= "<ol>";
			              for ($i=0; $i < count($result_arr['success_data']); $i++) { 
			                if($result_arr['success_data'][$i]!=""){
			                  $result_str .= "<li>".$result_arr['success_data'][$i]."</li>";
			                }
			              }
			              $result_str .= "</ol><hr><br>";
			            }
			            $result_str .= label('result_duplicate')." : ".$result_arr['duplicate_count']."<br>";
			            if(count($result_arr['duplicate_data'])>0){
			              $result_str .= "<ol>";
			              for ($i=0; $i < count($result_arr['duplicate_data']); $i++) { 
			                if($result_arr['duplicate_data'][$i]!=""){
			                  $result_str .= "<li>".$result_arr['duplicate_data'][$i]."</li>";
			                }
			              }
			              $result_str .= "</ol><hr><br>";
			            }
			            $result_str .= label('result_fail')." : ".$result_arr['error_count']."<br>";
			            if(count($result_arr['error_data'])>0){
			              $result_str .= "<ol>";
			              for ($i=0; $i < count($result_arr['error_data']); $i++) { 
			                if($result_arr['error_data'][$i]!=""){
			                  $result_str .= "<li>".$result_arr['error_data'][$i]."</li>";
			                }
			              }
			              $result_str .= "</ol><br>";
			            }
				        $arr_output['status'] = "2";
				        $arr_output['result'] = $result_str;
					}else{
						$arr_output['status'] = "0";
					}
				}else{
					$arr_output['status'] = "0";
				}
				
		}else{
			$arr_output['status'] = "0";
		}

	    $this->lg->record('Setting', 'Import Question By '.$sess['fullname_th']);

		echo json_encode($arr_output);
	}

	public function import_survey(){
  		require_once(APPPATH.'libraries/FPDF/Classes/PHPExcel.php');
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata('user');
		$this->load->model('Setting_model', 'setting', TRUE);
		$this->load->model('Log_model', 'lg', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->setting->loadDB();

        $result_arr = array();
        $result_arr['success_count'] = 0;
        $result_arr['duplicate_count'] = 0;
        $result_arr['error_count'] = 0;
        $result_arr['success_data'] = array();
        $result_arr['duplicate_data'] = array();
        $result_arr['error_data'] = array();
		if(count($_REQUEST)>0){
				$imageSourcePath = $_FILES['file_import_survey']['tmp_name'];
	            $pathBG = $_FILES['file_import_survey']['name'];
	            if($pathBG!=""){
	            	
	                  $array_pathext = explode('.', $pathBG);
	                  $extension = end($array_pathext);
	                  $file_import_survey = "importxlsxsurvey_".date('YmdHis').".".$extension;
	                  $imageTargetPath = ROOT_DIR."uploads/excel/".$file_import_survey;
	                  if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
	                      $data_user['file_import_survey'] = $file_import_survey;

							$path = './uploads/excel/'.$file_import_survey;
							$objPHPExcel = PHPExcel_IOFactory::load($path);
							foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
								$worksheetTitle     = $worksheet->getTitle();
								$highestRow         = $worksheet->getHighestRow(); // e.g. 10
								$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
								$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
								//$nrColumns = ord($highestColumn) - 64;

								for ($row = 2; $row <= $highestRow; ++ $row) {
									$dep_name_th = '';
									$dep_name_en = '';
									$posi_name_th = '';
									$posi_name_en = '';
									$arr_svde = array();
									$arr_svde['sv_id'] = $_REQUEST['sv_id_detail_import'];

									for ($col = 0; $col < $highestColumnIndex; ++ $col) {
								        $cell = $worksheet->getCellByColumnAndRow($col, $row);
								        $val = $cell->getValue();
								        $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);

										if($col==0){ $arr_svde['svde_heading_eng'] = $val; }
										if($col==1){ $arr_svde['svde_heading_th'] = $val; }
										if($col==2){ $arr_svde['svde_detail_eng'] = $val; }
										if($col==3){ $arr_svde['svde_detail_th'] = $val; }
									}
									$numchk = 0;
									$fetch_sv = $this->func_query->query_row('LMS_SURVEY','','','','sv_id="'.$_REQUEST['sv_id_detail_import'].'"');
									if(count($fetch_sv)>0){
										if($fetch_sv['sv_title_th']!=""&&$arr_svde['svde_detail_th']==""){
											$numchk++;
										}
										if($fetch_sv['sv_title_eng']!=""&&$arr_svde['svde_detail_eng']==""){
											$numchk++;
										}
									}
							                  if($lang=="thai"){ 
							                    $svde_heading = $arr_svde['svde_heading_th']!=""?$arr_svde['svde_heading_th']:$arr_svde['svde_heading_eng'];
							                    $svde_detail = $arr_svde['svde_detail_th']!=""?$arr_svde['svde_detail_th']:$arr_svde['svde_detail_eng'];
							                  }else if($lang=="english"){ 
							                    $svde_heading = $arr_svde['svde_heading_eng']!=""?$arr_svde['svde_heading_eng']:$arr_svde['svde_heading_th'];
							                    $svde_detail = $arr_svde['svde_detail_eng']!=""?$arr_svde['svde_detail_eng']:$arr_svde['svde_detail_th'];
							                  }
									if((($arr_svde['svde_heading_th']!=""&&$arr_svde['svde_detail_th']!="")||($arr_svde['svde_heading_eng']!=""&&$arr_svde['svde_detail_eng']!=""))&&$numchk==0){

										$this->db->from('LMS_SURVEY_DE');
										$this->db->where('sv_id',$_REQUEST['sv_id_detail_import']);
										$this->db->where('svde_heading_th',htmlentities($arr_svde['svde_heading_th']));
										$this->db->where('svde_heading_eng',htmlentities($arr_svde['svde_heading_eng']));
										$this->db->where('svde_detail_th',htmlentities($arr_svde['svde_detail_th']));
										$this->db->where('svde_detail_eng',htmlentities($arr_svde['svde_detail_eng']));
										$this->db->where('svde_isDelete','0');
										$query_chk = $this->db->get();
										$num_chk = $query_chk->num_rows();
										if($num_chk==0){
											$arr_svde['svde_createby'] = $sess['u_id'];
											$arr_svde['svde_createdate'] = date('Y-m-d H:i');
											$arr_svde['svde_modifiedby'] = $sess['u_id'];
											$arr_svde['svde_modifieddate'] = date('Y-m-d H:i');
											$this->db->insert('LMS_SURVEY_DE',$arr_svde);
											$svde_id = $this->db->insert_id();
											if($svde_id!=""){
							                    $result_arr['success_count']++;
							                    array_push($result_arr['success_data'], $svde_detail);
											}else{
												$result_arr['error_count']++;
				                    			array_push($result_arr['error_data'], $svde_detail);
											}
										}else{
						                    $result_arr['duplicate_count']++;
						                    array_push($result_arr['duplicate_data'], $svde_detail);
										}
									}else{
										if($svde_detail!=""){
												$result_arr['error_count']++;
				                    			array_push($result_arr['error_data'], $svde_detail);
										}
									}
								}
							}
	                  }

			            $result_str = "";
			            $result_str .= label('result_success')." : ".$result_arr['success_count']."<br>";
			            if(count($result_arr['success_data'])>0){
			              $result_str .= "<ol>";
			              for ($i=0; $i < count($result_arr['success_data']); $i++) { 
			                if($result_arr['success_data'][$i]!=""){
			                  $result_str .= "<li>".$result_arr['success_data'][$i]."</li>";
			                }
			              }
			              $result_str .= "</ol><hr><br>";
			            }
			            $result_str .= label('result_duplicate')." : ".$result_arr['duplicate_count']."<br>";
			            if(count($result_arr['duplicate_data'])>0){
			              $result_str .= "<ol>";
			              for ($i=0; $i < count($result_arr['duplicate_data']); $i++) { 
			                if($result_arr['duplicate_data'][$i]!=""){
			                  $result_str .= "<li>".$result_arr['duplicate_data'][$i]."</li>";
			                }
			              }
			              $result_str .= "</ol><hr><br>";
			            }
			            $result_str .= label('result_fail')." : ".$result_arr['error_count']."<br>";
			            if(count($result_arr['error_data'])>0){
			              $result_str .= "<ol>";
			              for ($i=0; $i < count($result_arr['error_data']); $i++) { 
			                if($result_arr['error_data'][$i]!=""){
			                  $result_str .= "<li>".$result_arr['error_data'][$i]."</li>";
			                }
			              }
			              $result_str .= "</ol><br>";
			            }

	                  	$result_arr['status'] = "2";
          				$result_arr['result'] = $result_str;
	            }else{
	                 	$result_arr['status'] = "0";
				}
		}else{
	        $result_arr['status'] = "0";
		}

	    $this->lg->record('Setting', 'Import Survey By '.$sess['fullname_th']);
		echo json_encode($result_arr);
	}

	public function generateRandomString($length = 8) {
	    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

	public function import_user(){
  		require_once(APPPATH.'libraries/FPDF/Classes/PHPExcel.php');
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata('user');
		$this->load->model('Setting_model', 'setting', TRUE);
		$this->load->model('Manage_model', 'manage', TRUE);
		$this->load->model('Log_model', 'lg', FALSE);
    	date_default_timezone_set("Asia/Bangkok");
		$this->load->model('Function_query_model', 'func_query', TRUE);
		$this->setting->loadDB();
		$msg = "2";

   		$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $result_arr = array();
        $result_arr['success_count'] = 0;
        $result_arr['duplicate_count'] = 0;
        $result_arr['error_count'] = 0;
        $result_arr['line_error'] = array();
        $result_arr['success_data'] = array();
        $result_arr['duplicate_data'] = array();
        $result_arr['error_data'] = array();
		if(count($_REQUEST)>0){

			if($_REQUEST['operation_import_user']=="Add"){
				$excel_file = $_FILES["file_import"]["name"];
				//$data['file_import'] = $excel_file;

				$imageSourcePath = $_FILES['file_import']['tmp_name'];
	            $pathBG = $_FILES['file_import']['name'];
	            $array_pathext = explode('.', $pathBG);
	            $extension = end($array_pathext);
	            $file_import = "importxlsxuser_".date('YmdHis').".".$extension;
	            $imageTargetPath = ROOT_DIR."uploads/excel/".$file_import;
	            if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
					$path = './uploads/excel/'.$file_import;
					$objPHPExcel = PHPExcel_IOFactory::load($path);
					foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
						$worksheetTitle     = $worksheet->getTitle();
						$highestRow         = $worksheet->getHighestRow(); // e.g. 10
						$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
						$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
						//$nrColumns = ord($highestColumn) - 64;
						$output = array();
						$heading = "";
						$detail = "";

						$output_array = array();
						for ($row = 2; $row <= $highestRow; ++ $row) {
							$dep_name_th = '';
							$dep_name_en = '';
							$posi_name_th = '';
							$posi_name_en = '';
							$arr_emp = array();
							$arr_user = array();
							$arr_user_group = array();
							$arr_company = array();
							$arr_department = array();
							$arr_position = array();

							$data = array(
								'com_id' => $_REQUEST['com_id_import_user']
							);
							for ($col = 0; $col < $highestColumnIndex; ++ $col) {
						        	$cell = $worksheet->getCellByColumnAndRow($col, $row);
						            $val = $cell->getValue();
						            $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
								if($col==0){ $arr_user['useri'] = strtolower($val); }
								if($col==1){ $arr_user_group['ug_name'] = $val; }
								if($col==2){ $arr_company['com_code'] = $val; }
								if($col==3){ $arr_department['dep_name'] = $val; }
								if($col==4){ $arr_position['posi_name'] = $val; }
								if($col==5){ $arr_emp['emp_manage_a'] = strtolower($val); }
								if($col==6){ $arr_emp['emp_manage_b'] = strtolower($val); }
								//if($col==7){ $arr_emp['emp_c'] = $val; }
								if($col==7){ $arr_emp['fname_th'] = $val; }
								if($col==8){ $arr_emp['lname_th'] = $val; }
								if($col==9){ $arr_emp['fname_en'] = $val; }
								if($col==10){ $arr_emp['lname_en'] = $val; }
								/*if($col==11){ $arr_emp['work_phone'] = $val; }
								if($col==12){ $arr_emp['phone'] = $val; }
								if($col==13){ $arr_emp['employ_date'] = date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($cell->getValue()));  }*/
								if($col==11){ $arr_user['u_firstdate'] = $val!=""?date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($cell->getValue())):date('Y-m-d'); }
								if($col==12){ $arr_user['inactivedate'] = $val!=""?date('Y-m-d', PHPExcel_Shared_Date::ExcelToPHP($cell->getValue())):"0000-00-00"; }

								/*if($col==11){ $arr_emp['emp_nationality'] = $val!=""?$val:""; }
								if($col==12){ $arr_emp['gender'] = $val; }*/
							}
							//print_r($arr_emp);
							//print_r($arr_user);
							$message = "";
							if($arr_user['useri']==""&&$arr_user['useri']!="Company's email*"){
								$message = label('error_comp_email');
							}
							if($arr_company['com_code']==""){
									if($message!=""){
										$message .= ", ";
									}
									$message .= label('error_notfound_comp');
							}
							if($arr_user['useri']!=""&&$arr_company['com_code']!=""&&$arr_user['useri']!="Company's email*"){
								$arr_emp['fullname_th'] = $arr_emp['fname_th']." ".$arr_emp['lname_th'];
								$arr_emp['fullname_en'] = $arr_emp['fname_en']." ".$arr_emp['lname_en'];
								$arr_emp['email'] = $arr_user['useri'];
								$arr_emp['emp_c'] = $arr_user['useri']; 
								$arr_emp['emp_createby'] = $sess['u_id'];
								$arr_emp['emp_createdate'] = date('Y-m-d H:i');
								$arr_emp['emp_modifiedby'] = $sess['u_id'];
								$arr_emp['emp_modifieddate'] = date('Y-m-d H:i');
								$fetch_chkcompany = $this->func_query->query_row('LMS_COMPANY','','','','com_code="'.$arr_company['com_code'].'" and com_isDelete="0"');
								$arr_emp['com_id'] = $fetch_chkcompany['com_id'];
								$chkcom = 1;
								if($sess['ug_id']!="1"){
									if($sess['com_id']==$arr_emp['com_id']){
										$chkcom = 0;
									}
								}
								if($chkcom==0){
									if($message!=""){
										$message .= ", ";
									}
									$message .= label('error_comp_notmatch');
								}
								$com_emaildomain = $fetch_chkcompany['com_emaildomain'];
								$email = isset($arr_emp['email'])?explode('@', $arr_emp['email']):"";
								$chkmatch = 1;
								if(isset($email[1])){
									if($email[1]!=$com_emaildomain){
										$chkmatch = 0;
									}
								}else{
									$chkmatch = 0;
								}

								if($chkmatch==0){
									if($message!=""){
										$message .= ", ";
									}
									$message .= label("error_comp_email_notmatch");
								}

								$dep_name = str_replace(" ","",$arr_department['dep_name']);
								$posi_name = str_replace(" ","",$arr_position['posi_name']);
								$fetch_chkdp = $this->func_query->query_row('LMS_DEPART','','','','com_id="'.$fetch_chkcompany['com_id'].'" and (REPLACE(dep_name_th, " ", "")="'.$dep_name.'" or REPLACE(dep_name_en, " ", "")="'.$dep_name.'") and dep_isDelete="0"');
								$dep_id = "";
								$posi_id = "";
								if(count($fetch_chkdp)>0){
									$dep_id = $fetch_chkdp['dep_id'];
									/*$data_dp = array(
										'dep_status' => '1',
										'dep_modifiedby' => $sess['u_id'],
										'dep_modifieddate' => date('Y-m-d H:i')
									);
									$this->db->where('dep_id',$dep_id);
									$this->db->update('LMS_DEPART',$data_dp);*/

									$fetch_chkdp = $this->func_query->query_row('LMS_POSITION','','','','dep_id="'.$dep_id.'" and (REPLACE(posi_name_th, " ", "")="'.$posi_name.'" or REPLACE(posi_name_en, " ", "")="'.$posi_name.'") and posi_isDelete="0"');
									if(count($fetch_chkdp)>0){
										$posi_id = $fetch_chkdp['posi_id'];
										/*$data_dp = array(
											'posi_status' => '1',
											'posi_modifiedby' => $sess['u_id'],
											'posi_modifieddate' => date('Y-m-d H:i')
										);
										$this->db->where('dep_id',$dep_id);
										$this->db->update('LMS_POSITION',$data_dp);*/
									}else{
										if($message!=""){
											$message .= ", ";
										}
										$message .= label("error_notfound_pos");
									}
								}else{
									if($message!=""){
										$message .= ", ";
									}
									$message .= label("error_notfound_dept");
								}
								/*else{
									$data_dp = array(
										'dep_name_th' => $arr_department['dep_name'],
										'dep_name_en' => $arr_department['dep_name'],
										'com_id' => $fetch_chkcompany['com_id'],
										'dep_createby' => $sess['u_id'],
										'dep_createdate' => date('Y-m-d H:i'),
										'dep_modifiedby' => $sess['u_id'],
										'dep_modifieddate' => date('Y-m-d H:i')
									);
									$this->db->insert('LMS_DEPART',$data_dp);
									$dep_id = $this->db->insert_id();
								}*/
								/*else{
									$data_dp = array(
										'posi_name_th' => $arr_position['posi_name'],
										'posi_name_en' => $arr_position['posi_name'],
										'dep_id' => $dep_id,
										'posi_createby' => $sess['u_id'],
										'posi_createdate' => date('Y-m-d H:i'),
										'posi_modifiedby' => $sess['u_id'],
										'posi_modifieddate' => date('Y-m-d H:i')
									);
									$this->db->insert('LMS_POSITION',$data_dp);
									$posi_id = $this->db->insert_id();
								}*/
								$ug_id = "";
								$ug_anme = str_replace(" ","",$arr_user_group['ug_name']);
								$fetch_chkug = $this->func_query->query_row('LMS_USP_GP','','','','ug_for="'.$fetch_chkcompany['com_admin'].'" and (REPLACE(ug_name_th, " ", "")="'.$ug_anme.'" or REPLACE(ug_name_en, " ", "")="'.$ug_anme.'") and ug_isDelete="0"');
								if(count($fetch_chkug)>0){
									$ug_id = $fetch_chkug['ug_id'];
								}else{
									if($message!=""){
										$message .= ", ";
									}
									$message .= label("error_notfound_role");
								}
								$chk_inactive = 1;
								if($arr_user['inactivedate']!="0000-00-00"&&date('Y-m-d')>date('Y-m-d',strtotime($arr_user['inactivedate']))){
									$chk_inactive = 0;
									if($message!=""){
										$message .= ", ";
									}
									$message .= label("error_usage_enddate");
								}
								if($ug_id!=""&&$posi_id!=""&&$dep_id!=""&&$chkmatch==1&&$chkcom==1&&$chk_inactive==1){
									$arr_user['dep_id'] = $dep_id;
									$arr_user['posi_id'] = $posi_id;
									$arr_user['ug_id'] = $ug_id;
									$arr_user['u_modifiedby'] = $sess['u_id'];
									$arr_user['u_modifieddate'] = date('Y-m-d H:i');
									$fetch_chkup = $this->func_query->query_row('LMS_USP','LMS_EMP','LMS_USP.emp_id = LMS_EMP.emp_id','','useri="'.$arr_user['useri'].'" and LMS_USP.u_isDelete="0" and LMS_EMP.emp_isDelete="0"');
									if(count($fetch_chkup)==0){
										$password = $this->generateRandomString();
										$password_enc = hash('sha256', $password);
										$arr_user['userp'] = $password_enc;
										$arr_user['u_createby'] = $sess['u_id'];
										$arr_user['u_createdate'] = date('Y-m-d H:i');
										$this->db->insert('LMS_EMP',$arr_emp);
										$emp_id = $this->db->insert_id();
										$arr_user['emp_id'] = $emp_id;
										$this->db->insert('LMS_USP',$arr_user);
										$u_id = $this->db->insert_id();

										$fetch_chkrole = $this->func_query->query_row('LMS_ROLE_USP','','','','u_id="'.$u_id.'"');
								        if(count($fetch_chkrole)==0){
								        	$result_rolegp = $this->func_query->query_result('LMS_ROLE_GP','','','','ug_id="'.$ug_id.'"');
								            $num = 1;
								            foreach ($result_rolegp as $key => $value) {
								              $data = array(
								                'u_id' => $u_id,
								                'mu_id' => $value['mu_id'],
								                'ru_view' => $value['rgu_view'],
								                'ru_add' => $value['rgu_add'],
								                'ru_edit' => $value['rgu_edit'],
								                'ru_del' => $value['rgu_del'],
								                'ru_print' => $value['rgu_print']
								              );
								              $this->db->insert('LMS_ROLE_USP', $data);
								            }
								        }
								        if($u_id!=""){
									        $result_arr['success_count']++;
									        array_push($result_arr['success_data'], $arr_emp['emp_c']);

								            $date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
								            if($lang!="thai"){
								                $date = date('d F Y');
								            }
											$fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
											$fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="1"');
											if(count($fetch_formatmail)>0){
						                        $subject_th = $fetch_formatmail['smf_subject_th'];
						                        $subject_en = $fetch_formatmail['smf_subject_en'];
						                        $message_th = $fetch_formatmail['smf_message_th'];
						                        $message_en = $fetch_formatmail['smf_message_en'];
						                        if($subject_th!=""){
						                            $subject_th = str_replace("#fullname",$arr_emp['fullname_th'],$subject_th);
						                            $subject_th = str_replace("#username",$arr_user['useri'],$subject_th);
						                            $subject_th = str_replace("#email",$arr_emp['email'],$subject_th);
						                            $subject_th = str_replace("#coursename","",$subject_th);
						                            $subject_th = str_replace("#password",$password,$subject_th);
						                            $subject_th = str_replace("#link_frontend",base_url(),$subject_th);
						                            $subject_th = str_replace("#date",$date,$subject_th);
						                            $subject_th = str_replace("#time",date('H:i'),$subject_th);
						                        }
						                        if($subject_en!=""){
						                            $subject_en = str_replace("#fullname",$arr_emp['fullname_en'],$subject_en);
						                            $subject_en = str_replace("#username",$arr_user['useri'],$subject_en);
						                            $subject_en = str_replace("#email",$arr_emp['email'],$subject_en);
						                            $subject_en = str_replace("#coursename","",$subject_en);
						                            $subject_en = str_replace("#password",$password,$subject_en);
						                            $subject_en = str_replace("#link_frontend",base_url(),$subject_en);
						                            $subject_en = str_replace("#date",$date,$subject_en);
						                            $subject_en = str_replace("#time",date('H:i'),$subject_en);
						                        }
						                        if($message_th!=""){
						                            $message_th = str_replace("#fullname",$arr_emp['fullname_th'],$message_th);
						                            $message_th = str_replace("#username",$arr_user['useri'],$message_th);
						                            $message_th = str_replace("#email",$arr_emp['email'],$message_th);
						                            $message_th = str_replace("#coursename","",$message_th);
						                            $message_th = str_replace("#password",$password,$message_th);
						                            $message_th = str_replace("#link_frontend",base_url(),$message_th);
						                            $message_th = str_replace("#date",$date,$message_th);
						                            $message_th = str_replace("#time",date('H:i'),$message_th);
						                        }
						                        if($message_en!=""){
						                            $message_en = str_replace("#fullname",$arr_emp['fullname_en'],$message_en);
						                            $message_en = str_replace("#username",$arr_user['useri'],$message_en);
						                            $message_en = str_replace("#email",$arr_emp['email'],$message_en);
						                            $message_en = str_replace("#coursename","",$message_en);
						                            $message_en = str_replace("#password",$password,$message_en);
						                            $message_en = str_replace("#link_frontend",base_url(),$message_en);
						                            $message_en = str_replace("#date",$date,$message_en);
						                            $message_en = str_replace("#time",date('H:i'),$message_en);
						                        }
						                        if($lang == "thai") {
						                          $this->db->sendEmail( $arr_emp['email'] , $message_th, $subject_th,$fetch_setmail);
						                        } else {
						                          $this->db->sendEmail( $arr_emp['email'] , $message_en, $subject_en,$fetch_setmail);
						                        }
											}
								        }else{
											$result_arr['error_count']++;
				                    		array_push($result_arr['line_error'], '2199');
					                    	array_push($result_arr['error_data'], $arr_emp['emp_c']);
										}
									}else{
										$this->db->where('emp_id',$fetch_chkup['emp_id']);
										$this->db->update('LMS_EMP',$arr_emp);
										$this->db->where('u_id',$fetch_chkup['u_id']);
										$this->db->update('LMS_USP',$arr_user);

										$fetch_chkrole = $this->func_query->query_row('LMS_ROLE_USP','','','','u_id="'.$u_id.'"');
								        if(count($fetch_chkrole)>0){
								        	if($fetch_chkup['ug_id']!=$ug_id){
									              $this->db->where('u_id',$u_id);
									              $this->db->delete('LMS_ROLE_USP');
										        	$result_rolegp = $this->func_query->query_result('LMS_ROLE_GP','','','','ug_id="'.$ug_id.'"');
										            $num = 1;
										            foreach ($result_rolegp as $key => $value) {
										              $data = array(
										                'u_id' => $u_id,
										                'mu_id' => $value['mu_id'],
										                'ru_view' => $value['rgu_view'],
										                'ru_add' => $value['rgu_add'],
										                'ru_edit' => $value['rgu_edit'],
										                'ru_del' => $value['rgu_del'],
										                'ru_print' => $value['rgu_print']
										              );
										              $this->db->insert('LMS_ROLE_USP', $data);
										            }
								        	}
								        }
										$result_arr['duplicate_count']++;
							            array_push($result_arr['duplicate_data'], $arr_emp['emp_c']);
									}
								}else{
									$result_arr['error_count']++;
				                    array_push($result_arr['line_error'], '2213');
				                    array_push($result_arr['error_data'], $arr_emp['emp_c']." (".$message.")");
								}
								
							}
							//end user
						}
						/*$head = "";
						foreach ($output as $key => $value) {
							if(is_array($value)){
								foreach ($value as $key => $value_b) {
									if($head!=""){
										$head_arr = explode(';', $head);
										$value_arr = explode(';', $value_b);
										$this->questionnaire->insertQuestionnaireDetail($id,$head_arr[0],$value_arr[0],$head_arr[1],$value_arr[1]);
									}
								}
							}else{
								$head = $value;
							}
						}*/
					}
					
			            $result_str = "";
			            $result_str .= label('result_success')." : ".$result_arr['success_count']."<br>";
			            if(count($result_arr['success_data'])>0){
			              $result_str .= "<ol>";
			              for ($i=0; $i < count($result_arr['success_data']); $i++) { 
			                if($result_arr['success_data'][$i]!=""){
			                  $result_str .= "<li>".$result_arr['success_data'][$i]."</li>";
			                }
			              }
			              $result_str .= "</ol><hr><br>";
			            }
			            $result_str .= label('result_duplicate')." : ".$result_arr['duplicate_count']."<br>";
			            if(count($result_arr['duplicate_data'])>0){
			              $result_str .= "<ol>";
			              for ($i=0; $i < count($result_arr['duplicate_data']); $i++) { 
			                if($result_arr['duplicate_data'][$i]!=""){
			                  $result_str .= "<li>".$result_arr['duplicate_data'][$i]."</li>";
			                }
			              }
			              $result_str .= "</ol><hr><br>";
			            }
			            $result_str .= label('result_fail')." : ".$result_arr['error_count']."<br>";
			            if(count($result_arr['error_data'])>0){
			              $result_str .= "<ol>";
			              for ($i=0; $i < count($result_arr['error_data']); $i++) { 
			                if($result_arr['error_data'][$i]!=""){
			                  $result_str .= "<li>".$result_arr['error_data'][$i]."</li>";
			                }
			              }
			              $result_str .= "</ol><br>";
			            }
			            $fetch_user_all = $this->func_query->query_result('LMS_EMP','','','','(emp_manage_a!="" or emp_manage_b!="") and emp_isDelete="0"','','emp_manage_a,emp_manage_b');
			            if(count($fetch_user_all)>0){
			            	$arr_update = array(
			            		'is_manager' => "0"
			            	);
			            	$this->db->update('LMS_EMP',$arr_update);
			            	foreach ($fetch_user_all as $key_userall => $value_userall) {
			            		if($value_userall['emp_manage_a']!=""){
				            		$fetch_chkemp = $this->func_query->query_row('LMS_EMP','','','','emp_c="'.$value_userall['emp_manage_a'].'" and emp_isDelete="0" and depart_date="0000-00-00"');
				            		if(count($fetch_chkemp)>0){
				            			$fetch_usp = $this->func_query->query_row('LMS_USP','LMS_USP_GP','LMS_USP.ug_id = LMS_USP_GP.ug_id','','LMS_USP.emp_id = "'.$fetch_chkemp['emp_id'].'"');
				            			if(count($fetch_usp)>0&&$fetch_usp['ug_name_en']=="Learner"&&$fetch_usp['ug_for']=="com_central"){
				            				$fetch_chkug = $this->func_query->query_row('LMS_USP_GP','','','','ug_name_en="Learner (Manager)" and ug_for="com_central" and ug_isDelete="0" and ug_status="1"','ug_id DESC');
				            				if(count($fetch_chkug)>0){
								            	$arr_update_ug = array(
								            		'ug_id' => $fetch_chkug['ug_id']
								            	);
								            	$this->db->where('emp_id',$fetch_chkemp['emp_id']);
								            	$this->db->update('LMS_USP',$arr_update_ug);
								            	$this->manage->rechk_role($fetch_usp['u_id'],$fetch_chkug['ug_id']);
				            				}
				            			}
				            			if(count($fetch_usp)>0&&$fetch_usp['ug_name_en']=="Learner"&&$fetch_usp['ug_for']=="com_associated"){
				            				$fetch_chkug = $this->func_query->query_row('LMS_USP_GP','','','','ug_name_en="Learner (Manager)" and ug_for="com_associated" and ug_isDelete="0" and ug_status="1"','ug_id DESC');
				            				if(count($fetch_chkug)>0){
								            	$arr_update_ug = array(
								            		'ug_id' => $fetch_chkug['ug_id']
								            	);
								            	$this->db->where('emp_id',$fetch_chkemp['emp_id']);
								            	$this->db->update('LMS_USP',$arr_update_ug);
								            	$this->manage->rechk_role($fetch_usp['u_id'],$fetch_chkug['ug_id']);
				            				}
				            			}
						            	$arr_update = array(
						            		'is_manager' => "1"
						            	);
						            	$this->db->where('emp_id',$fetch_chkemp['emp_id']);
						            	$this->db->update('LMS_EMP',$arr_update);
				            		}
				            	}
			            		if($value_userall['emp_manage_b']!=""){
				            		$fetch_chkemp = $this->func_query->query_row('LMS_EMP','','','','emp_c="'.$value_userall['emp_manage_b'].'" and emp_isDelete="0" and depart_date="0000-00-00"');
				            		if(count($fetch_chkemp)>0){
				            			$fetch_usp = $this->func_query->query_row('LMS_USP','LMS_USP_GP','LMS_USP.ug_id = LMS_USP_GP.ug_id','','LMS_USP.emp_id = "'.$fetch_chkemp['emp_id'].'"');
				            			if(count($fetch_usp)>0&&$fetch_usp['ug_name_en']=="Learner"&&$fetch_usp['ug_for']=="com_central"){
				            				$fetch_chkug = $this->func_query->query_row('LMS_USP_GP','','','','ug_name_en="Learner (Manager)" and ug_for="com_central" and ug_isDelete="0" and ug_status="1"','ug_id DESC');
				            				if(count($fetch_chkug)>0){
								            	$arr_update_ug = array(
								            		'ug_id' => $fetch_chkug['ug_id']
								            	);
								            	$this->db->where('emp_id',$fetch_chkemp['emp_id']);
								            	$this->db->update('LMS_USP',$arr_update_ug);
								            	$this->manage->rechk_role($fetch_usp['u_id'],$fetch_chkug['ug_id']);
				            				}
				            			}
				            			if(count($fetch_usp)>0&&$fetch_usp['ug_name_en']=="Learner"&&$fetch_usp['ug_for']=="com_associated"){
				            				$fetch_chkug = $this->func_query->query_row('LMS_USP_GP','','','','ug_name_en="Learner (Manager)" and ug_for="com_associated" and ug_isDelete="0" and ug_status="1"','ug_id DESC');
				            				if(count($fetch_chkug)>0){
								            	$arr_update_ug = array(
								            		'ug_id' => $fetch_chkug['ug_id']
								            	);
								            	$this->db->where('emp_id',$fetch_chkemp['emp_id']);
								            	$this->db->update('LMS_USP',$arr_update_ug);
								            	$this->manage->rechk_role($fetch_usp['u_id'],$fetch_chkug['ug_id']);
				            				}
				            			}
						            	$arr_update = array(
						            		'is_manager' => "1"
						            	);
						            	$this->db->where('emp_id',$fetch_chkemp['emp_id']);
						            	$this->db->update('LMS_EMP',$arr_update);
				            		}
			            		}
			            	}
			            }
	                  	$result_arr['status'] = "2";
          				$result_arr['result'] = $result_str;
				}else{
	                 	$result_arr['status'] = "0";
				}	
			}
		}else{
	        $result_arr['status'] = "0";
		}
	    $this->lg->record('Setting', 'Import User By '.$sess['fullname_th']);
		echo json_encode($result_arr);
	}

	public function import_departandposi(){
  		require_once(APPPATH.'libraries/FPDF/Classes/PHPExcel.php');
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata('user');
		$this->load->model('Setting_model', 'setting', TRUE);
		$this->load->model('Manage_model', 'manage', TRUE);
		$this->load->model('Log_model', 'lg', FALSE);
    	date_default_timezone_set("Asia/Bangkok");
		$this->load->model('Function_query_model', 'func_query', TRUE);
		$this->setting->loadDB();
		$msg = "2";

   		$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
        $result_arr = array();
        $result_arr['success_count'] = 0;
        $result_arr['duplicate_count'] = 0;
        $result_arr['error_count'] = 0;
        $result_arr['line_error'] = array();
        $result_arr['success_data'] = array();
        $result_arr['duplicate_data'] = array();
        $result_arr['error_data'] = array();
		if(count($_REQUEST)>0){

			if($_REQUEST['operation_import_user']=="Add"){
				$excel_file = $_FILES["file_import"]["name"];
				//$data['file_import'] = $excel_file;

				$imageSourcePath = $_FILES['file_import']['tmp_name'];
	            $pathBG = $_FILES['file_import']['name'];
	            $array_pathext = explode('.', $pathBG);
	            $extension = end($array_pathext);
	            $file_import = "importxlsxdepartposi_".date('YmdHis').".".$extension;
	            $imageTargetPath = ROOT_DIR."uploads/excel/".$file_import;
	            if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
					$path = './uploads/excel/'.$file_import;
					$objPHPExcel = PHPExcel_IOFactory::load($path);
					foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
						$worksheetTitle     = $worksheet->getTitle();
						$highestRow         = $worksheet->getHighestRow(); // e.g. 10
						$highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
						$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
						//$nrColumns = ord($highestColumn) - 64;
						$output = array();
						$heading = "";
						$detail = "";

						$output_array = array();
						for ($row = 2; $row <= $highestRow; ++ $row) {
							$arr_depart = array();
							$arr_posi = array();
							$company_code = "";

							for ($col = 0; $col < $highestColumnIndex; ++ $col) {
						        	$cell = $worksheet->getCellByColumnAndRow($col, $row);
						            $val = $cell->getValue();
						            $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
								if($col==0){ $company_code = $val; }
								if($col==1){ $arr_depart['dep_name_en'] = $val; }
								if($col==2){ $arr_depart['dep_name_th'] = $val; }
								if($col==3){ $arr_posi['posi_name_en'] = $val; }
								if($col==4){ $arr_posi['posi_name_th'] = $val; }
							}

							$message = "";
							if($company_code==""){
								$message .= label('error_comp_notmatch');
							}
							if($arr_depart['dep_name_th']==""||$arr_depart['dep_name_en']==""){
								$message .= label('error_notfound_dept');
							}
							if($arr_posi['posi_name_th']==""||$arr_posi['posi_name_en']==""){
								$message .= label('error_notfound_pos');
							}
							$fetch_company = $this->func_query->query_row('LMS_COMPANY','','','','com_code="'.$company_code.'" and com_isDelete="0"');
							if($company_code!=""&&count($fetch_company)>0){

								$fetch_chkdp = $this->func_query->query_row('LMS_DEPART','','','','com_id="'.$fetch_company['com_id'].'" and (dep_name_th="'.$arr_depart['dep_name_th'].'" and dep_name_en="'.$arr_depart['dep_name_en'].'") and dep_isDelete="0"');
								$dep_id = "";
								$posi_id = "";
								if(count($fetch_chkdp)>0){
									$dep_id = $fetch_chkdp['dep_id'];
									$data_dp = array(
										'dep_name_th' => $arr_depart['dep_name_th'],
										'dep_name_en' => $arr_depart['dep_name_en'],
										'dep_modifiedby' => $sess['u_id'],
										'dep_modifieddate' => date('Y-m-d H:i')
									);
									$this->db->where('dep_id',$dep_id);
									$this->db->update('LMS_DEPART',$data_dp);

								}else{
									$data_dp = array(
										'dep_name_th' => $arr_depart['dep_name_th'],
										'dep_name_en' => $arr_depart['dep_name_en'],
										'com_id' => $fetch_company['com_id'],
										'dep_createby' => $sess['u_id'],
										'dep_createdate' => date('Y-m-d H:i'),
										'dep_modifiedby' => $sess['u_id'],
										'dep_modifieddate' => date('Y-m-d H:i')
									);
									$this->db->insert('LMS_DEPART',$data_dp);
									$dep_id = $this->db->insert_id();
								}

									$fetch_chkdp = $this->func_query->query_row('LMS_POSITION','','','','dep_id="'.$dep_id.'" and (posi_name_th="'.$arr_posi['posi_name_th'].'" and posi_name_en="'.$arr_posi['posi_name_en'].'") and posi_isDelete="0"');
									if(count($fetch_chkdp)>0){
										$posi_id = $fetch_chkdp['posi_id'];
										$data_dp = array(
											'posi_name_th' => $arr_posi['posi_name_th'],
											'posi_name_en' => $arr_posi['posi_name_en'],
											'dep_id' => $dep_id,
											'posi_modifiedby' => $sess['u_id'],
											'posi_modifieddate' => date('Y-m-d H:i')
										);
										$this->db->where('posi_id',$posi_id);
										$this->db->update('LMS_POSITION',$data_dp);
										$result_arr['duplicate_count']++;
							            array_push($result_arr['duplicate_data'], $arr_posi['posi_name_en']);
									}else{
										$data_dp = array(
											'posi_name_th' => $arr_posi['posi_name_th'],
											'posi_name_en' => $arr_posi['posi_name_en'],
											'dep_id' => $dep_id,
											'posi_createby' => $sess['u_id'],
											'posi_createdate' => date('Y-m-d H:i'),
											'posi_modifiedby' => $sess['u_id'],
											'posi_modifieddate' => date('Y-m-d H:i')
										);
										$this->db->insert('LMS_POSITION',$data_dp);
									    $result_arr['success_count']++;
									    array_push($result_arr['success_data'], $arr_posi['posi_name_en']);
									}
								
							}else{
									$result_arr['error_count']++;
				                    array_push($result_arr['line_error'], '2909');
				                    array_push($result_arr['error_data'], $arr_posi['posi_name_en']." (".$message.")");
							}
							//end user
						}
						
					}
					
			            $result_str = "";
			            $result_str .= label('result_success')." : ".$result_arr['success_count']."<br>";
			            if(count($result_arr['success_data'])>0){
			              $result_str .= "<ol>";
			              for ($i=0; $i < count($result_arr['success_data']); $i++) { 
			                if($result_arr['success_data'][$i]!=""){
			                  $result_str .= "<li>".$result_arr['success_data'][$i]."</li>";
			                }
			              }
			              $result_str .= "</ol><hr><br>";
			            }
			            $result_str .= label('result_duplicate')." : ".$result_arr['duplicate_count']."<br>";
			            if(count($result_arr['duplicate_data'])>0){
			              $result_str .= "<ol>";
			              for ($i=0; $i < count($result_arr['duplicate_data']); $i++) { 
			                if($result_arr['duplicate_data'][$i]!=""){
			                  $result_str .= "<li>".$result_arr['duplicate_data'][$i]."</li>";
			                }
			              }
			              $result_str .= "</ol><hr><br>";
			            }
			            $result_str .= label('result_fail')." : ".$result_arr['error_count']."<br>";
			            if(count($result_arr['error_data'])>0){
			              $result_str .= "<ol>";
			              for ($i=0; $i < count($result_arr['error_data']); $i++) { 
			                if($result_arr['error_data'][$i]!=""){
			                  $result_str .= "<li>".$result_arr['error_data'][$i]."</li>";
			                }
			              }
			              $result_str .= "</ol><br>";
			            }
	                  	$result_arr['status'] = "2";
          				$result_arr['result'] = $result_str;
				}else{
	                 	$result_arr['status'] = "0";
				}	
			}
		}else{
	        $result_arr['status'] = "0";
		}
	    $this->lg->record('Setting', 'Import Department & Position By '.$sess['fullname_th']);
		echo json_encode($result_arr);
	}
}
