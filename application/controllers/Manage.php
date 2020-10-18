<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage extends CI_Controller {
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
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);

		$arr['lang'] = $lang;
		$arr['page'] = "manage";

		redirect(base_url().'manage/manageUser', 'refresh');
	}

	public function companydata(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);

		$arr['lang'] = $lang;
		$arr['page'] = "manage/companydata";

		$this->load->model('User_model', 'login', FALSE);
		if($this->login->checkSession($arr['page'])){
			$sess = $this->session->userdata("user");
			$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			$arr['thaimonth'] = $thaimonth;	
			$arr['emp_c'] = $sess['emp_c'];
			$arr['com_admin'] = $sess['com_admin'];
			$arr['com_id'] = $sess['com_id'];
			$arr['user'] = $sess;
			if($lang=="thai"){
				$arr['com_name'] = $sess['com_name_th'];
			}else{
				$arr['com_name'] = $sess['com_name_eng'];
			}
			$this->load->model('Footer_model', 'foot', FALSE);
			$this->foot->loadDB();
			$arr['foote'] = $this->foot->getfooter();

			
			$this->load->model('Manage_model', 'manage', FALSE);
			$this->manage->loadDB();
        	$arr['arr_permission'] = $this->manage->chk_permission_page();
			$arr['btn_add'] = $this->manage->chk_permission($arr['page'],'ru_add');
			$arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
			$arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
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
			//$arr['data_fetch'] = $this->manage->fetch_data_company();
			$this->manage->closeDB();
			$this->load->view('frontend/managecompany', $arr );
		}else{
			redirect(base_url().'dashboard/login');
		}
	}

	public function departmentdata(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);

		$arr['lang'] = $lang;
		$arr['page'] = "manage/departmentdata";

		$this->load->model('User_model', 'login', FALSE);
		if($this->login->checkSession($arr['page'])){
			$sess = $this->session->userdata("user");
			
			$arr['emp_c'] = $sess['emp_c'];
			$arr['com_admin'] = $sess['com_admin'];
			$arr['com_id'] = $sess['com_id'];
			$arr['user'] = $sess;
			if($lang=="thai"){
				$arr['com_name'] = $sess['com_name_th'];
			}else{
				$arr['com_name'] = $sess['com_name_eng'];
			}
			$this->load->model('Footer_model', 'foot', FALSE);
			$this->foot->loadDB();
			$arr['foote'] = $this->foot->getfooter();
			$this->foot->closeDB();

			$this->load->model('Manage_model', 'manage', FALSE);
			$this->manage->loadDB();
        	$arr['arr_permission'] = $this->manage->chk_permission_page();
			$arr['btn_add'] = $this->manage->chk_permission($arr['page'],'ru_add');
			$arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
			$arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
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
			$arr['data_fetch'] = $this->manage->fetch_data_department();
			$arr['company_select'] = $this->manage->getCompany();
			$this->manage->closeDB();
			$this->load->view('frontend/managedepartment', $arr );
		}else{
			redirect(base_url().'dashboard/login');
		}
	}
	

	public function groupuserdata(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);

		$arr['lang'] = $lang;
		$arr['page'] = "manage/groupuserdata";

		$this->load->model('User_model', 'login', FALSE);
		if($this->login->checkSession($arr['page'])){
			$sess = $this->session->userdata("user");
			
			$arr['emp_c'] = $sess['emp_c'];
			$arr['com_admin'] = $sess['com_admin'];
			$arr['com_id'] = $sess['com_id'];
			$arr['user'] = $sess;
			if($lang=="thai"){
				$arr['com_name'] = $sess['com_name_th'];
			}else{
				$arr['com_name'] = $sess['com_name_eng'];
			}
			$this->load->model('Footer_model', 'foot', FALSE);
			$this->foot->loadDB();
			$arr['foote'] = $this->foot->getfooter();
			$this->foot->closeDB();

			$this->load->model('Manage_model', 'manage', FALSE);
			$this->manage->loadDB();
			$arr['total_menu'] = $this->manage->arr_menu_query();
        	$arr['arr_permission'] = $this->manage->chk_permission_page();
			$arr['btn_add'] = $this->manage->chk_permission($arr['page'],'ru_add');
			$arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
			$arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
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
			$arr['data_fetch'] = $this->manage->fetch_data_groupuser();
			$this->manage->closeDB();
			$this->load->view('frontend/managegroupuser', $arr );
		}else{
			redirect(base_url().'dashboard/login');
		}
	}
	

	public function userdata(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);

		$arr['lang'] = $lang;
		$arr['page'] = "manage/userdata";

		$this->load->model('User_model', 'login', FALSE);
		if($this->login->checkSession($arr['page'])){
			$sess = $this->session->userdata("user");
			
			$arr['emp_c'] = $sess['emp_c'];
			$arr['com_admin'] = $sess['com_admin'];
			$arr['com_id'] = $sess['com_id'];
			$arr['user'] = $sess;
			if($lang=="thai"){
				$arr['com_name'] = $sess['com_name_th'];
			}else{
				$arr['com_name'] = $sess['com_name_eng'];
			}
			$this->load->model('Footer_model', 'foot', FALSE);
			$this->foot->loadDB();
			$arr['foote'] = $this->foot->getfooter();
			$this->foot->closeDB();

			$this->load->model('Manage_model', 'manage', FALSE);
			$this->load->model('Function_query_model', 'func_query', FALSE);
			$this->manage->loadDB();
        	$arr['arr_permission'] = $this->manage->chk_permission_page();
			$arr['btn_add'] = $this->manage->chk_permission($arr['page'],'ru_add');
			$arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
			$arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
			$arr['btn_view'] = $this->manage->chk_permission($arr['page'],'ru_view');
			$arr['btn_print'] = $this->manage->chk_permission($arr['page'],'ru_print');
			if($arr['btn_view']!="1"){
				redirect(base_url().'dashboard') ;
			}
			$arr['company_arr'] = $this->func_query->query_result('LMS_COMPANY','','','','com_isDelete="0" and com_status="1" and com_id != "1"');
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
			$arr['company_select'] = $this->manage->getCompany();
			$this->manage->closeDB();
			$this->load->view('frontend/manageusers', $arr );
		}else{
			redirect(base_url().'dashboard/login');
		}
	}

	public function fetch_detail_user(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$query = $this->manage->fetch_data_user($_REQUEST['com_id']);
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

	public function fetch_detail_qrcode(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$query = $this->manage->fetch_data_qrcode($_REQUEST['com_id']);
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

	public function fetch_detail_usergroup(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$query = $this->manage->fetch_data_groupuser();
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

	public function fetch_detail_company(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$query = $this->manage->fetch_data_company();
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

	public function fetch_detail_company_score(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$query = $this->manage->fetch_data_company_score($_REQUEST['com_id'],$_REQUEST['isActive']);
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

	public function fetch_detail_division(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$query = $this->manage->fetch_data_division($_REQUEST['com_id']);
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

	public function fetch_detail_position(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$query = $this->manage->fetch_data_position($_REQUEST['com_id']);
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


	public function fetch_detail_level(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$query = $this->manage->fetch_data_level($_REQUEST['com_id']);
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

	public function fetch_detail_store(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$query = $this->manage->fetch_data_store($_REQUEST['com_id']);
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

	public function fetch_detail_group(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$query = $this->manage->fetch_data_group($_REQUEST['com_id']);
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

	public function fetch_detail_conmsg(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$query = $this->manage->fetch_data_conmsg();
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

	public function fetch_detail_department(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$query = $this->manage->fetch_data_department($_REQUEST['com_id']);
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

	public function fetch_detail_section(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$query = $this->manage->fetch_data_section($_REQUEST['com_id']);
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

	public function fetch_detail_area(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$query = $this->manage->fetch_data_area($_REQUEST['com_id']);
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

	public function fetch_detail_positionori( $dep_id ){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$query = $this->manage->fetch_data_position_detail($dep_id);
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

	public function fetch_log(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
	    $draw = isset($_REQUEST['draw'])?intval($_REQUEST['draw']):"";
	    $start = isset($_REQUEST['start'])?intval($_REQUEST['start']):"";
	    $length = isset($_REQUEST['length'])?intval($_REQUEST['length']):"";
	    $order = $this->input->post("order");
	    $search = $this->input->post("search");
	    $search = $search['value'];
        $time_start = isset($_REQUEST['time_start']) ? $_REQUEST['time_start'] : '';
        $time_end = isset($_REQUEST['time_end']) ? $_REQUEST['time_end'] : '';
        $date_start = isset($_REQUEST['date_start'])&&$_REQUEST['date_start']!=""?$_REQUEST['date_start']." ".$time_start:"0000-00-00 00:00:00";
        $date_end = isset($_REQUEST['date_end'])&&$_REQUEST['date_end']!=""?$_REQUEST['date_end']." ".$time_end:"0000-00-00 00:00:00";
        $com_id = isset($_REQUEST['com_id']) ? $_REQUEST['com_id'] : '';
		$var_and = "LMS_EMP.emp_isDelete='0'";
	    $var_and .= " and LMS_EMP.com_id='".$com_id."'";
	    if(($date_start!=""&&$date_end!="")){
	    	$var_and .= " and (LMS_LG.log_time between '".$date_start."' and '".$date_end."')";
	    }
          /*if($sday!=""&&$eday!=""){
            $this->db->where('LMS_LG.log_time >=', date('Y-m-d H:i',strtotime($sday)));
            $this->db->where('LMS_LG.log_time <=', date('Y-m-d H:i',strtotime($eday)));
            //$var_and = " and (LMS_LG.log_time between '".date('Y-m-d 00:00:00',strtotime($sday))."' and '".date('Y-m-d 23:59:59',strtotime($eday))."')";
          } */
          if($search!=""){
            $var_and .= "(LMS_EMP.emp_c like '%".$search."%' or LMS_EMP.fullname_th like '%".$search."%' or LMS_EMP.fullname_en like '%".$search."%' or LMS_USP_GP.ug_name_th like '%".$search."%' or LMS_USP_GP.ug_name_en like '%".$search."%' or LMS_LG.massage like '%".$search."%')";
          }
          $this->db->where($var_and);
          $this->db->join('LMS_EMP','LMS_LG.emp_id = LMS_EMP.emp_id');
          $this->db->join('LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id');
          $this->db->join('LMS_USP_GP','LMS_USP.ug_id = LMS_USP_GP.ug_id');
          $this->db->from("LMS_LG");
          $query_count = $this->db->get();
          $fetch_count = $query_count->num_rows();
		$query = $this->manage->fetch_data_log($date_start,$date_end,$com_id,$length,$start,$order,$search);
	   // $fetch_count = $this->func_query->numrows("LMS_LG","LMS_EMP","LMS_EMP.emp_id = LMS_LG.emp_id","",$var_and);
		$num = 1;
     	$data = array();
      	$result = array(
               "draw" => $draw,
                 "recordsTotal" => $fetch_count,
                 "recordsFiltered" => $fetch_count,
                 "data" => $query
        );
      	echo json_encode($result);
      	exit();
	}

	public function loaddetailgroupuser(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$ug_id = $_REQUEST['ug_id'];
			$data_resend = $this->manage->chkdataRoleUsergroup($ug_id);
			echo $data_resend;
		}
	}

	public function loaddetailuser(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$u_id = $_REQUEST['u_id'];
			$data_resend = $this->manage->chkdataRoleUser($u_id);
			echo $data_resend;
		}
	}
	public function chk_chkbox_user(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$msg = $this->manage->chkbox_user($_REQUEST);
		}
		echo $msg;
	}
	public function chk_chkbox_groupuser(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$msg = $this->manage->chkbox_groupuser($_REQUEST);
		}
		echo $msg;
	}

	public function chk_chkboxcol_groupuser(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$msg = $this->manage->chkbox_col_groupuser($_REQUEST);
		}
		echo $msg;
	}
	public function chk_chkboxcol_user(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$msg = $this->manage->chkbox_col_user($_REQUEST);
		}
		echo $msg;
	}

	public function insert_company(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$com_logo = "";
			if( isset( $_FILES['com_logo']) ){
				$imageSourcePath = $_FILES['com_logo']['tmp_name'];
				$imageSourcename = $_FILES['com_logo']['name'];
				$info = new SplFileInfo($imageSourcename);

				$com_logo = date('YmdHis').".".$info->getExtension();
				$imageTargetPath = ROOT_DIR."uploads/logo/".$com_logo;
				if( !move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
					$com_logo = "";
				}
			}
			$data = array(
				'com_code' => $_REQUEST['com_code'],
				'com_name_th' => $_REQUEST['com_name_th'],
				'com_name_eng' => $_REQUEST['com_name_eng'],
				'com_add_th' => $_REQUEST['com_add_th'],
				'com_add_eng' => $_REQUEST['com_add_eng'],
				'com_emaildomain' => $_REQUEST['com_emaildomain'],
				'com_tel' => $_REQUEST['com_tel'],
				'com_fax' => $_REQUEST['com_fax'],
				'com_mail' => $_REQUEST['com_mail'],
				'com_admin' => $_REQUEST['com_admin'],
				'com_wctitle_th' => $_REQUEST['com_wctitle_th'],
				'com_wcmessage_th' => $_REQUEST['com_wcmessage_th'],
				'com_wctitle_eng' => $_REQUEST['com_wctitle_eng'],
				'com_wcmessage_eng' => $_REQUEST['com_wcmessage_eng'],
				'com_modifiedby' => $sess['u_id'],
				'com_modifieddate' => date('Y-m-d H:i')
			);
			$data_period = array(
				'compe_montha_start' => isset($_REQUEST['compe_montha_start'])?$_REQUEST['compe_montha_start']:"",
				'compe_montha_end' => isset($_REQUEST['compe_montha_end'])?$_REQUEST['compe_montha_end']:"",
				'compe_monthb_start' => isset($_REQUEST['compe_monthb_start'])?$_REQUEST['compe_monthb_start']:"",
				'compe_monthb_end' => isset($_REQUEST['compe_monthb_end'])?$_REQUEST['compe_monthb_end']:""
			);
			if(isset($_FILES['com_logo_top'])&&$_FILES['com_logo_top']!=""){
				if( isset( $_FILES['com_logo_top']) ){
					$imageSourcePath = $_FILES['com_logo_top']['tmp_name'];
			        $pathBG = $_FILES['com_logo_top']['name'];
			        if($pathBG!=""){
				        $array_pathext = explode('.', $pathBG);
				        $extension = end($array_pathext);
						$com_logo_top = "logoTop_".date('YmdHis').".".$extension;
						$imageTargetPath = ROOT_DIR."uploads/logo/".$com_logo_top;
						if($_REQUEST['operation']=="Edit"){
							$fetch_m = $this->func_query->query_row('LMS_COMPANY','','','','com_id="'.$_REQUEST['com_id'].'"');
							if(count($fetch_m)>0&&$fetch_m['com_logo_top']!=""){
		                        if(is_file(ROOT_DIR."uploads/logo/".$fetch_m['com_logo_top'])) {
		                                unlink(ROOT_DIR."uploads/logo/".$fetch_m['com_logo_top']);
		                        }
							}
						}
						if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
							$data['com_logo_top'] = $com_logo_top;
						}
			        }
				}
			}
			if(isset($_FILES['com_logo_footer'])&&$_FILES['com_logo_footer']!=""){
				if( isset( $_FILES['com_logo_footer']) ){
					$imageSourcePath = $_FILES['com_logo_footer']['tmp_name'];
			        $pathBG = $_FILES['com_logo_footer']['name'];
			        if($pathBG!=""){
				        $array_pathext = explode('.', $pathBG);
				        $extension = end($array_pathext);
						$com_logo_footer = "logoFooter_".date('YmdHis').".".$extension;
						$imageTargetPath = ROOT_DIR."uploads/logo/".$com_logo_footer;
						if($_REQUEST['operation']=="Edit"){
							$fetch_m = $this->func_query->query_row('LMS_COMPANY','','','','com_id="'.$_REQUEST['com_id'].'"');
							if(count($fetch_m)>0&&$fetch_m['com_logo_footer']!=""){
		                        if(is_file(ROOT_DIR."uploads/logo/".$fetch_m['com_logo_footer'])) {
		                                unlink(ROOT_DIR."uploads/logo/".$fetch_m['com_logo_footer']);
		                        }
							}
						}
						if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
							$data['com_logo_footer'] = $com_logo_footer;
						}
			        }
				}
			}
			if($_REQUEST['operation']=="Add"){
				$data['com_createby'] = $sess['u_id'];
				$data['com_createdate'] = date('Y-m-d H:i');
				$msg = $this->manage->create_company($data,$data_period);
			}else{
				$data['com_logo_top'] = isset($data['com_logo_top'])?$data['com_logo_top']:$_REQUEST['com_logo_top_ori'];
				$data['com_logo_footer'] = isset($data['com_logo_footer'])?$data['com_logo_footer']:$_REQUEST['com_logo_footer_ori'];
				$msg = $this->manage->update_company($data,$data_period,$_REQUEST['com_id']);
			}
		}
		echo $msg;
	}

	public function insert_company_score(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$coms_status = isset($_REQUEST['coms_status'])?$_REQUEST['coms_status']:"0";
			$coms_cond = isset($_REQUEST['coms_cond'])?$_REQUEST['coms_cond']:"1";
			$data = array(
				'coms_year' => $_REQUEST['coms_year'],
				'coms_amount' => $_REQUEST['coms_amount'],
				'coms_cond' => $coms_cond,
				'coms_type' => $_REQUEST['coms_type'],
				'coms_status' => $coms_status,
				'coms_a_plus' => $_REQUEST['coms_a_plus'],
				'coms_a' => $_REQUEST['coms_a'],
				'coms_b_plus' => $_REQUEST['coms_b_plus'],
				'coms_b' => $_REQUEST['coms_b'],
				'coms_c_plus' => $_REQUEST['coms_c_plus'],
				'coms_c' => $_REQUEST['coms_c'],
				'coms_d_plus' => $_REQUEST['coms_d_plus'],
				'coms_d' => $_REQUEST['coms_d'],
				'coms_note' => $_REQUEST['coms_note'],
				'com_id' => $_REQUEST['com_id_score'],
				'coms_calculate' => $_REQUEST['coms_calculate'],
				'coms_modifiedby' => $sess['u_id'],
				'coms_modifieddate' => date('Y-m-d H:i')
			);
			if($_REQUEST['operation_score']=="Add"){
				$data['coms_createby'] = $sess['u_id'];
				$data['coms_createdate'] = date('Y-m-d H:i');
				$msg = $this->manage->create_company_score($data);
			}else{
				$msg = $this->manage->update_company_score($data,$_REQUEST['coms_id']);
			}
		}
		echo $msg;
	}


	public function insert_position_detail(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		date_default_timezone_set("Asia/Bangkok");
		$emp_c = $sess['emp_c'];
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$data = array(
				'dep_id' => $_REQUEST['dep_id_position'],
				'posi_name_th' => $_REQUEST['posi_name_th'],
				'posi_name_en' => $_REQUEST['posi_name_en'],
				'posi_group' => $_REQUEST['posi_group'],
				'posi_remark' => $_REQUEST['posi_remark'],
				'posi_modifiedby' => $sess['u_id'],
				'posi_modifieddate' => date('Y-m-d H:i')
			);
			if($_REQUEST['operation_position']=="Add"){
				$data['posi_createby'] = $sess['u_id'];
				$data['posi_createdate'] = date('Y-m-d H:i');
				$msg = $this->manage->create_position_detail($data);
			}else{
				$msg = $this->manage->update_position_detail($data,$_REQUEST['posi_id']);
			}
		}
		echo $msg;
	}

	public function insert_division(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		date_default_timezone_set("Asia/Bangkok");
		$emp_c = $sess['emp_c'];
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$data = array(
				'com_id' => $_REQUEST['com_id'],
				'div_code' => $_REQUEST['div_code'],
				'div_name_en' => $_REQUEST['div_name_en'],
				'div_name_th' => $_REQUEST['div_name_th'],
				'div_modifiedby' => $sess['u_id'],
				'div_modifieddate' => date('Y-m-d H:i')
			);
			if($_REQUEST['operation']=="Add"){
				$data['div_createby'] = $sess['u_id'];
				$data['div_createdate'] = date('Y-m-d H:i');
				$msg = $this->manage->create_division($data);
			}else{
				$msg = $this->manage->update_division($data,$_REQUEST['div_id']);
			}
		}
		echo $msg;
	}

	public function insert_level(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		date_default_timezone_set("Asia/Bangkok");
		$emp_c = $sess['emp_c'];
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$data = array(
				'com_id' => $_REQUEST['com_id'],
				'lv_code' => $_REQUEST['lv_code'],
				'lv_name_en' => $_REQUEST['lv_name_en'],
				'lv_name_th' => $_REQUEST['lv_name_th'],
				'lv_viewdata' => $_REQUEST['lv_viewdata'],
				'lv_modifiedby' => $sess['u_id'],
				'lv_modifieddate' => date('Y-m-d H:i')
			);
			if($_REQUEST['operation']=="Add"){
				$data['lv_createby'] = $sess['u_id'];
				$data['lv_createdate'] = date('Y-m-d H:i');
				$msg = $this->manage->create_level($data);
			}else{
				$msg = $this->manage->update_level($data,$_REQUEST['lv_id']);
			}
		}
		echo $msg;
	}

	public function insert_store(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		date_default_timezone_set("Asia/Bangkok");
		$emp_c = $sess['emp_c'];
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$data = array(
				'com_id' => $_REQUEST['com_id'],
				'st_cus_code' => $_REQUEST['st_cus_code'],
				'st_code' => $_REQUEST['st_code'],
				'st_group' => $_REQUEST['st_group'],
				'st_name_en' => $_REQUEST['st_name_en'],
				'st_name_th' => $_REQUEST['st_name_th'],
				'st_modifiedby' => $sess['u_id'],
				'st_modifieddate' => date('Y-m-d H:i')
			);
			if($_REQUEST['operation']=="Add"){
				$data['st_createby'] = $sess['u_id'];
				$data['st_createdate'] = date('Y-m-d H:i');
				$msg = $this->manage->create_store($data);
			}else{
				$msg = $this->manage->update_store($data,$_REQUEST['st_id']);
			}
		}
		echo $msg;
	}

	public function insert_position(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		date_default_timezone_set("Asia/Bangkok");
		$emp_c = $sess['emp_c'];
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$data = array(
				'com_id' => $_REQUEST['com_id'],
				'posi_code' => $_REQUEST['posi_code'],
				'posi_name_en' => $_REQUEST['posi_name_en'],
				'posi_name_th' => $_REQUEST['posi_name_th'],
				'posi_group' => $_REQUEST['posi_group'],
				'posi_modifiedby' => $sess['u_id'],
				'posi_modifieddate' => date('Y-m-d H:i')
			);
			if($_REQUEST['operation']=="Add"){
				$data['posi_createby'] = $sess['u_id'];
				$data['posi_createdate'] = date('Y-m-d H:i');

				$fetch_chk = $this->func_query->numrows('LMS_POSITION','','','','com_id="'.$data['com_id'].'" and posi_code="'.$data['posi_code'].'" and posi_group="'.$data['posi_group'].'" and posi_isDelete="0"');
		        if($fetch_chk==0){
		            $this->db->insert('LMS_POSITION', $data);
		            $id = $this->db->insert_id();
		            if($id!=""){
		            	if(count($_REQUEST['posifd_val'])>0){
			            	for ($i=0; $i < count($_REQUEST['posifd_val']); $i++) { 
			            		$arr_insert = array(
			            			'posi_id'=>$id,
			            			'posifd_val'=>$_REQUEST['posifd_val'][$i],
			            			'posifd_group'=>$_REQUEST['posi_group'],
			            		);
			            		$this->db->insert('LMS_POSITION_FIELD',$arr_insert);
			            	}
		            	}
		            	if(count($_REQUEST['lv_id'])>0){
			            	for ($i=0; $i < count($_REQUEST['lv_id']); $i++) { 
			            		$arr_insert = array(
			            			'posi_id'=>$id,
			            			'lv_id'=>$_REQUEST['lv_id'][$i],
			            			'posilv_createby'=>$sess['u_id'],
			            			'posilv_createdate'=>date('Y-m-d H:i'),
			            			'posilv_modifiedby'=>$sess['u_id'],
			            			'posilv_modifieddate'=>date('Y-m-d H:i'),
			            		);
			            		$this->db->insert('LMS_POSITION_LEVEL',$arr_insert);
			            	}
		            	}
		              	$msg = "2";
		            }else{
		              	$msg = "3";
		            }
		        }else{
		            $msg = "1";
		        }
			}else{
				$msg = $this->manage->update_position($data,$_REQUEST['posi_id']);
				if($msg=="2"){
		            if(count($_REQUEST['posifd_val'])>0){
		            	$this->db->where('posi_id',$_REQUEST['posi_id']);
		            	$this->db->delete('LMS_POSITION_FIELD');
			            for ($i=0; $i < count($_REQUEST['posifd_val']); $i++) { 
			            	$arr_insert = array(
			            		'posi_id'=>$_REQUEST['posi_id'],
			            		'posifd_val'=>$_REQUEST['posifd_val'][$i],
			            		'posifd_group'=>$_REQUEST['posi_group'],
			            	);
			            	$this->db->insert('LMS_POSITION_FIELD',$arr_insert);
			            }
		            }
					if(count($_REQUEST['lv_id'])>0){
						$arr_lv_id = implode(",",$_REQUEST['lv_id']);
						$fetch_chk = $this->func_query->query_result('LMS_POSITION_LEVEL','','','','posi_id="'.$_REQUEST['posi_id'].'" and lv_id not in ('.$arr_lv_id.') and posilv_isDelete="0"');
						if(count($fetch_chk)>0){
							foreach ($fetch_chk as $key_chk => $value_chk) {
									$arr_update = array(
										'posilv_isDelete'=>'1',
				            			'posilv_modifiedby'=>$sess['u_id'],
				            			'posilv_modifieddate'=>date('Y-m-d H:i'),
									);
									$this->db->where('posilv_id',$value_chk['posilv_id']);
									$this->db->update('LMS_POSITION_LEVEL',$arr_update);
							}
						}
			            	for ($i=0; $i < count($_REQUEST['lv_id']); $i++) { 
			            		$fetch_rechhk = $this->func_query->numrows('LMS_POSITION_LEVEL','','','','posi_id="'.$_REQUEST['posi_id'].'" and lv_id="'.$_REQUEST['lv_id'][$i].'" and posilv_isDelete="0"');
			            		if($fetch_rechhk==0){
				            		$arr_insert = array(
				            			'posi_id'=>$_REQUEST['posi_id'],
				            			'lv_id'=>$_REQUEST['lv_id'][$i],
				            			'posilv_createby'=>$sess['u_id'],
				            			'posilv_createdate'=>date('Y-m-d H:i'),
				            			'posilv_modifiedby'=>$sess['u_id'],
				            			'posilv_modifieddate'=>date('Y-m-d H:i'),
				            		);
				            		$this->db->insert('LMS_POSITION_LEVEL',$arr_insert);
			            		}
			            	}
					}else{
			            $fetch_rechhk = $this->func_query->numrows('LMS_POSITION_LEVEL','','','','posi_id="'.$_REQUEST['posi_id'].'" and posilv_isDelete="0"');

						if(count($fetch_rechhk)>0){
							foreach ($fetch_rechhk as $key_chk => $value_chk) {
									$arr_update = array(
										'posilv_isDelete'=>'1',
				            			'posilv_modifiedby'=>$sess['u_id'],
				            			'posilv_modifieddate'=>date('Y-m-d H:i'),
									);
									$this->db->where('posilv_id',$value_chk['posilv_id']);
									$this->db->update('LMS_POSITION_LEVEL',$arr_update);
							}
						}
					}
				}
			}
		}
		echo $msg;
	}

	public function insert_group(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		date_default_timezone_set("Asia/Bangkok");
		$emp_c = $sess['emp_c'];
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$data = array(
				'div_id' => $_REQUEST['div_id'],
				'group_code' => $_REQUEST['group_code'],
				'group_name_th' => $_REQUEST['group_name_th'],
				'group_name_en' => $_REQUEST['group_name_en'],
				'group_remark' => $_REQUEST['group_remark'],
				'group_modifiedby' => $sess['u_id'],
				'group_modifieddate' => date('Y-m-d H:i')
			);
			if($_REQUEST['operation']=="Add"){
				$data['group_createby'] = $sess['u_id'];
				$data['group_createdate'] = date('Y-m-d H:i');
				$msg = $this->manage->create_group($data);
			}else{
				$msg = $this->manage->update_group($data,$_REQUEST['group_id']);
			}
		}
		echo $msg;
	}

	public function insert_conmsg(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		date_default_timezone_set("Asia/Bangkok");
		$emp_c = $sess['emp_c'];
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$conmsg_status = isset($_REQUEST['conmsg_status'])?$_REQUEST['conmsg_status']:"0";
			$data = array(
				'conmsg_title_th' => $_REQUEST['conmsg_title_th'],
				'conmsg_title_eng' => $_REQUEST['conmsg_title_eng'],
				'conmsg_modifiedby' => $sess['u_id'],
				'conmsg_status' => $conmsg_status,
				'conmsg_modifieddate' => date('Y-m-d H:i')
			);
			if($_REQUEST['operation']=="Add"){
				$data['conmsg_createby'] = $sess['u_id'];
				$data['conmsg_createdate'] = date('Y-m-d H:i');
				$msg = $this->manage->create_conmsg($data);
			}else{
				$msg = $this->manage->update_conmsg($data,$_REQUEST['conmsg_id']);
			}
		}
		echo $msg;
	}


	public function insert_qrcode(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		date_default_timezone_set("Asia/Bangkok");
		$emp_c = $sess['emp_c'];
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$qr_id = isset($_REQUEST['qr_id'])?$_REQUEST['qr_id']:"";
			$operation = isset($_REQUEST['operation'])?$_REQUEST['operation']:"";
			$qr_status = isset($_REQUEST['qr_status'])?$_REQUEST['qr_status']:"0";

			$data = array(
				'qr_name' => $_REQUEST['qr_name'],
				'qr_type' => $_REQUEST['qr_type'],
				'com_id' => $_REQUEST['com_id'],
				'qr_status' => $qr_status,
				'qr_detail' => $_REQUEST['qr_detail'],
				'qr_modifiedby' => $sess['u_id'],
				'qr_modifieddate' => date('Y-m-d H:i')
			);

			if(isset($_FILES['qr_path'])&&$_FILES['qr_path']!=""){
				if( isset( $_FILES['qr_path']) ){
					$imageSourcePath = $_FILES['qr_path']['tmp_name'];
					$path_parts = pathinfo($_FILES['qr_path']['name']);
					if(isset($path_parts['extension'])){
						$qr_path = "qr_path_".date('YmdHis').".".$path_parts['extension'];

						$imageTargetPath = ROOT_DIR."uploads/file_forqrcode/".$qr_path;
						if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
							$data['qr_path'] = $qr_path;
							if($operation=="Edit"){
								$fetch_chk = $this->func_query->query_row('LMS_QRCODE','','','','qr_id="'.$qr_id.'"');
								if($fetch_chk['qr_path']!=""){
			                        if(is_file(ROOT_DIR."uploads/file_forqrcode/".$fetch_chk['qr_path'])) {
			                                unlink(ROOT_DIR."uploads/file_forqrcode/".$fetch_chk['qr_path']);
			                        }
								}

							}
						}
					}
				}
			}
			if($_REQUEST['operation']=="Add"){
				$data['qr_createby'] = $sess['u_id'];
				$data['qr_createdate'] = date('Y-m-d H:i');
				$msg = $this->manage->create_qrcode_detail($data);
			}else{
				$msg = $this->manage->update_qrcode_detail($data,$qr_id);
			}
		}
		echo $msg;
	}

	public function delete_qrcode_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		date_default_timezone_set("Asia/Bangkok");
		$emp_c = $sess['emp_c'];
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
								$fetch_chk = $this->func_query->query_row('LMS_QRCODE','','','','qr_id="'.$_REQUEST['qr_id_delete'].'"');
								if($fetch_chk['qr_path']!=""){
			                        if(is_file(ROOT_DIR."uploads/file_forqrcode/".$fetch_chk['qr_path'])) {
			                                unlink(ROOT_DIR."uploads/file_forqrcode/".$fetch_chk['qr_path']);
			                        }
								}
			$data = array(
				'qr_isDelete' => '1',
				'qr_modifiedby' => $sess['u_id'],
				'qr_modifieddate' => date('Y-m-d H:i')
			);
			$msg = $this->manage->update_qrcode_detail($data,$_REQUEST['qr_id_delete']);
		}
		echo $msg;
	}

	public function delete_samplecos(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		date_default_timezone_set("Asia/Bangkok");
		$emp_c = $sess['emp_c'];
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$data = array(
				'coshl_isDelete' => '1',
				'coshl_modifiedby' => $sess['u_id'],
				'coshl_modifieddate' => date('Y-m-d H:i')
			);
			$this->db->where('coshl_id',$_REQUEST['coshl_id']);
			$this->db->update('LMS_COS_HIGHLIGHT',$data);
			$msg = '2';
		}
		echo $msg;
	}

	public function delete_recommended_sites(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		date_default_timezone_set("Asia/Bangkok");
		$emp_c = $sess['emp_c'];
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
								$fetch_chk = $this->func_query->query_row('LMS_WEB','','','','web_id="'.$_REQUEST['web_id'].'"');
								if($fetch_chk['web_pathimg']!=""){
			                        if(is_file(ROOT_DIR."uploads/file_forwebrecommended/".$fetch_chk['web_pathimg'])) {
			                                unlink(ROOT_DIR."uploads/file_forwebrecommended/".$fetch_chk['web_pathimg']);
			                        }
								}
			$data = array(
				'web_isDelete' => '1',
				'web_modifiedby' => $sess['u_id'],
				'web_modifieddate' => date('Y-m-d H:i')
			);
			$msg = $this->manage->update_web($data,$_REQUEST['web_id']);
		}
		echo $msg;
	}

	public function delete_faq_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->setting->loadDB();
		if(count($_REQUEST)>0){
			$msg = $this->setting->delete_faq($_REQUEST['id_delete']);
		}
		echo $msg;
	}

	public function insert_department(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		if(count($_REQUEST)>0){
			$data = array(
				'dep_code' => $_REQUEST['dep_code'],
				'dep_shot' => $_REQUEST['dep_shot'],
				'dep_name_th' => $_REQUEST['dep_name_th'],
				'dep_name_en' => $_REQUEST['dep_name_en'],
				'group_id' => $_REQUEST['group_id'],
				'dep_remark' => $_REQUEST['dep_remark'],
				'dep_modifiedby' => $sess['u_id'],
				'dep_modifieddate' => date('Y-m-d H:i')
			);
			if($_REQUEST['operation']=="Add"){
				$data['dep_createby'] = $sess['u_id'];
				$data['dep_createdate'] = date('Y-m-d H:i');
				$msg = $this->manage->create_department($data);
			}else{
				$msg = $this->manage->update_department($data,$_REQUEST['dep_id']);
			}
		}
		echo $msg;
	}

	public function insert_section(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		if(count($_REQUEST)>0){
			$data = array(
				'section_code' => $_REQUEST['section_code'],
				'section_shot' => $_REQUEST['section_shot'],
				'section_name_en' => $_REQUEST['section_name_en'],
				'section_name_th' => $_REQUEST['section_name_th'],
				'dep_id' => $_REQUEST['dep_id'],
				'section_remark' => $_REQUEST['section_remark'],
				'section_modifiedby' => $sess['u_id'],
				'section_modifieddate' => date('Y-m-d H:i')
			);
			if($_REQUEST['operation']=="Add"){
				$data['section_createby'] = $sess['u_id'];
				$data['section_createdate'] = date('Y-m-d H:i');
				$msg = $this->manage->create_section($data);
			}else{
				$msg = $this->manage->update_section($data,$_REQUEST['section_id']);
			}
		}
		echo $msg;
	}

	public function insert_area(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		if(count($_REQUEST)>0){
			$data = array(
				'salearea_code' => $_REQUEST['salearea_code'],
				'salearea_shot' => $_REQUEST['salearea_shot'],
				'salearea_name_en' => $_REQUEST['salearea_name_en'],
				'salearea_name_th' => $_REQUEST['salearea_name_th'],
				'section_id' => $_REQUEST['section_id'],
				'salearea_remark' => $_REQUEST['salearea_remark'],
				'salearea_modifiedby' => $sess['u_id'],
				'salearea_modifieddate' => date('Y-m-d H:i')
			);
			if($_REQUEST['operation']=="Add"){
				$data['salearea_createby'] = $sess['u_id'];
				$data['salearea_createdate'] = date('Y-m-d H:i');
				$msg = $this->manage->create_area($data);
			}else{
				$msg = $this->manage->update_area($data,$_REQUEST['salearea_id']);
			}
		}
		echo $msg;
	}

	public function insert_groupuser(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$Is_admin = isset($_REQUEST['Is_admin']) ? $_REQUEST['Is_admin'] : '0';
			$Is_instructor = isset($_REQUEST['Is_instructor']) ? $_REQUEST['Is_instructor'] : '0';
			$ug_approve = isset($_REQUEST['ug_approve']) ? $_REQUEST['ug_approve'] : '0';
			$fd_id = isset($_REQUEST['fd_id']) ? $_REQUEST['fd_id'] : '';
			$data = array(
				'ug_name_th' => $_REQUEST['ug_name_th'],
				'ug_name_en' => $_REQUEST['ug_name_en'],
				'ug_viewdata' => $_REQUEST['ug_viewdata'],
				'ug_for' => $_REQUEST['ug_for'],
				'Is_admin' => $Is_admin,
				'Is_instructor' => $Is_instructor,
				'ug_approve' => $ug_approve
			);
			if($_REQUEST['operation']=="Add"){
				$msg = $this->manage->create_groupuser($data,$fd_id);
			}else{

              	if(count($fd_id)>0){
              		$this->db->where('ug_id',$_REQUEST['ug_id']);
              		$this->db->delete('LMS_ROLE_FD');
                  	for ($i=0; $i < count($fd_id); $i++) { 
	                    $arr_insert = array(
	                      'ug_id' => $_REQUEST['ug_id'],
	                      'fd_id' => $fd_id[$i],
	                    );
	                    $this->db->insert('LMS_ROLE_FD',$arr_insert);
                  	}
              	}
				$msg = $this->manage->update_groupuser($data,$_REQUEST['ug_id']);
			}
		}
		echo $msg;
	}

	public function update_profile(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$datas = $_REQUEST;
			$data_user = array();
			if(isset($_FILES['img_profile'])&&$_FILES['img_profile']!=""){
				if( isset( $_FILES['img_profile']) ){
					$imageSourcePath = $_FILES['img_profile']['tmp_name'];
					$imageTargetPath = ROOT_DIR."uploads/profile/".$_REQUEST['u_id']."_".date('YmdHis').".jpg";
					if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
						$data_user['img_profile'] = $_REQUEST['u_id']."_".date('YmdHis').".jpg";
					}
				}
			}
				if(isset($_FILES['bgpic_user'])&&$_FILES['bgpic_user']!=""){
					if( isset( $_FILES['bgpic_user']) ){
						$imageSourcePath = $_FILES['bgpic_user']['tmp_name'];
						$imageTargetPath = ROOT_DIR."uploads/bg_user/".$_REQUEST['u_id']."_".date('YmdHis').".jpg";
						if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
							$data_user['bgpic_user'] = $_REQUEST['u_id']."_".date('YmdHis').".jpg";
						}
					}
				}
			$data = array(
				'fname_th' => $datas['fname_th'],
				'lname_th' => $datas['lname_th'],
				'fullname_th' => $datas['fname_th']." ".$datas['lname_th'],
				'fname_en' => $datas['fname_en'],
				'lname_en' => $datas['lname_en'],
				'fullname_en' => $datas['fname_en']." ".$datas['lname_en'],
				/*'address_th' => $datas['address_th'],
				'address_en' => $datas['address_en'],
				'work_phone' => $datas['work_phone'],
				'phone' => $datas['phone'],*/
				'email' => $datas['email'],
				'emp_modifiedby' => $sess['u_id'],
				'emp_modifieddate' => date('Y-m-d H:i')
			);

			$msg = $this->manage->update_emp($data,$_REQUEST['emp_id']);
				if($msg=="2"){
			        date_default_timezone_set("Asia/Bangkok");
			        if(count($data_user)>0){
			        $this->db->where('u_id', $_REQUEST['u_id']);
			        $this->db->update('LMS_USP', $data_user);
			        }

				    $this->db->from('LMS_USP');
				    $this->db->join('LMS_EMP','LMS_USP.emp_id = LMS_EMP.emp_id');
				    $this->db->join('LMS_COMPANY','LMS_EMP.com_id = LMS_COMPANY.com_id');
				    $this->db->join('LMS_USP_GP','LMS_USP.ug_id = LMS_USP_GP.ug_id');
				    $this->db->join('LMS_POSITION','LMS_EMP.posi_id = LMS_POSITION.posi_id');
			        $this->db->where('LMS_USP.u_id', $_REQUEST['u_id']);
				    $query = $this->db->get();
				    $result = $query->row_array();
					$session_data = $result;
				    $this->session->set_userdata('user', $session_data);
				    
					/*if($sess['Is_admin']!="0"){
				        $this->db->where('com_id', $_REQUEST['com_id']);
				        $this->db->update('LMS_COMPANY', $data_com);
				    }*/
				}
				echo "2";
		}
	}


	private function sendEmail($email, $message){
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
			->setSubject('Verztec E-Learning Auto E-mail')
			->addGenericHeader('MIME-Version', '1.0')
			->addGenericHeader('Content-Type', 'text/html; charset="utf-8"')
			->addGenericHeader('X-Mailer', 'PHP/' . phpversion())
			->setMessage($message);
		$mail->send();

	}

	public function generateRandomString($length = 8) {
	    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

	public function insert_user(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
	    date_default_timezone_set("Asia/Bangkok");
	    $sess = $this->session->userdata("user");
   		$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
			//print_r($_REQUEST);
   		$status_save = "";
		if(count($_REQUEST)>0){
			$datas = $_REQUEST;
			$chkmatch = 1;
			if($chkmatch==1){
					include ROOT_DIR."assets/plugins/phpqrcode/qrlib.php"; 
					$errorCorrectionLevel = 'L';
					$matrixPointSize = 6;
					$filename = ROOT_DIR."uploads/qrcode/".$_REQUEST['emp_c'].".png";
			        QRcode::png($_REQUEST['emp_c'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);  

					$com_id = isset($_REQUEST['com_id']) ? $_REQUEST['com_id'] : '';
					$div_id = isset($_REQUEST['div_id']) ? $_REQUEST['div_id'] : '';
					$group_id = isset($_REQUEST['group_id']) ? $_REQUEST['group_id'] : '';
					$dep_id = isset($_REQUEST['dep_id']) ? $_REQUEST['dep_id'] : '';
					$section_id = isset($_REQUEST['section_id']) ? $_REQUEST['section_id'] : '';
					$salearea_id = isset($_REQUEST['salearea_id']) ? $_REQUEST['salearea_id'] : '';
					$posi_id = isset($_REQUEST['posi_id']) ? $_REQUEST['posi_id'] : '';
					$emp_level = isset($_REQUEST['emp_level']) ? $_REQUEST['emp_level'] : '';
					$emp_parent_id = isset($_REQUEST['emp_parent_id']) ? $_REQUEST['emp_parent_id'] : '';
					$st_id = isset($_REQUEST['st_id']) ? $_REQUEST['st_id'] : '';
					$emp_c = isset($_REQUEST['emp_c']) ? $_REQUEST['emp_c'] : '';
					$fname_th = isset($_REQUEST['fname_th']) ? $_REQUEST['fname_th'] : '';
					$lname_th = isset($_REQUEST['lname_th']) ? $_REQUEST['lname_th'] : '';
					$fname_en = isset($_REQUEST['fname_en']) ? $_REQUEST['fname_en'] : '';
					$lname_en = isset($_REQUEST['lname_en']) ? $_REQUEST['lname_en'] : '';
					$emp_observer = isset($_REQUEST['emp_observer']) ? $_REQUEST['emp_observer'] : '0';
					$status = isset($_REQUEST['status']) ? $_REQUEST['status'] : '0';
					$useri = isset($_REQUEST['useri']) ? $_REQUEST['useri'] : '';
					$ug_id = isset($_REQUEST['ug_id']) ? $_REQUEST['ug_id'] : '';
					$u_firstdate = isset($_REQUEST['u_firstdate_var']) ? $_REQUEST['u_firstdate_var'] : '0000-00-00 00:00:00';
					$inactivedate = isset($_REQUEST['inactivedate_var']) ? $_REQUEST['inactivedate_var'] : '0000-00-00';
					$lang = isset($_REQUEST['lang']) ? $_REQUEST['lang'] : 'thai';
					$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : '';
					$path_img = isset($_REQUEST['path_img']) ? $_REQUEST['path_img'] : '';
					$data = array(
						'emp_c' => $emp_c,
						'fname_th' => $fname_th,
						'lname_th' => $lname_th,
						'fullname_th' => $fname_th." ".$lname_th,
						'fname_en' => $fname_en,
						'lname_en' => $lname_en,
						'fullname_en' => $fname_en." ".$lname_en,
						'email' => $email,
						'lang' => $lang,
						'com_id' => $com_id,
						'div_id' => $div_id,
						'group_id' => $group_id,
						'dep_id' => $dep_id,
						'section_id' => $section_id,
						'salearea_id' => $salearea_id,
						'posi_id' => $posi_id,
						'emp_level' => $emp_level,
						'emp_parent_id' => $emp_parent_id,
						'st_id' => $st_id,
						'emp_observer' => $emp_observer,
						'status' => $status,
			            'emp_modifiedby' => date('Y-m-d H:i'),
			            'emp_modifieddate' => $sess['u_id'],
					);
					$data_user = array(
						'useri' => $useri,
						'ug_id' => $ug_id,
						'inactivedate' => $inactivedate,
						'u_firstdate' => $u_firstdate,
						'path_img' => $path_img,
			            'u_modifiedby' => date('Y-m-d H:i'),
			            'u_modifieddate' => $sess['u_id'],
					);
			        if(isset($_FILES['img_profile'])&&$_FILES['img_profile']!=""){
				          	if( isset( $_FILES['img_profile']) ){
					              	$imageSourcePath = $_FILES['img_profile']['tmp_name'];
					              	$pathBG = $_FILES['img_profile']['name'];
					              	if($pathBG!=""){
						                  	$array_pathext = explode('.', $pathBG);
						                  	$extension = end($array_pathext);
						                  	$img_profile = $_REQUEST['emp_c']."_".date('YmdHis').".".$extension;
						                  	$imageTargetPath = ROOT_DIR."uploads/profile/".$img_profile;
						                  	if($_REQUEST['operation']=="Edit"){
						                      	$fetch_img = $this->func_query->query_row('LMS_USP','','','','u_id="'.$_REQUEST['u_id'].'"');
						                      	if(count($fetch_img)>0&&$fetch_img['img_profile']!=""){
								                        if(is_file(ROOT_DIR."uploads/profile/".$fetch_img['img_profile'])) {
								                                unlink(ROOT_DIR."uploads/profile/".$fetch_img['img_profile']);
								                        }
						                      	}
						                  	}
						                  	if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
						                      	$data_user['img_profile'] = $img_profile;
						                  	}
					              	}
				          	}
			        }
			        
					if($_REQUEST['operation']=="Add"){
				        $data['emp_createby'] = $sess['u_id'];
						$data['emp_createdate'] = date('Y-m-d H:i');
						$password = $this->generateRandomString();
						$password_enc = hash('sha256', $password);
						$msg = $this->manage->create_emp($data);
						if($msg!="0"){
				          	$date = date('Y-m-d H:i') ;
				      		$date = new DateTime($date);
				      		$date->modify('+90 day');
				      		$data_user['expiredate'] = date_format($date, 'Y-m-d H:i');
				            $data_user['u_createdate'] = date('Y-m-d H:i');
				            $data_user['u_createby'] = $sess['u_id'];
							$data_user['userp'] = $password_enc;
							$data_user['emp_id'] = $msg;
							$status_save = $this->manage->create_user($data_user);
							//$this->update_manager($data['emp_manage_a'],$data['emp_manage_b']);
							if($status_save=="2"){
								$fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
								$fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="1"');

						              $date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
						              if($lang!="thai"){
						                 $date = date('d F Y');
						              }
									if(count($fetch_formatmail)>0){
				                        $subject_th = $fetch_formatmail['smf_subject_th'];
				                        $subject_en = $fetch_formatmail['smf_subject_en'];
				                        $message_th = $fetch_formatmail['smf_message_th'];
				                        $message_en = $fetch_formatmail['smf_message_en'];
				                        if($subject_th!=""){
				                            $subject_th = str_replace("#fullname",$data['fullname_th'],$subject_th);
				                            $subject_th = str_replace("#username",$data_user['useri'],$subject_th);
				                            $subject_th = str_replace("#email",$data['email'],$subject_th);
				                            $subject_th = str_replace("#coursename","",$subject_th);
				                            $subject_th = str_replace("#password",$password,$subject_th);
				                            $subject_th = str_replace("#link_frontend",base_url(),$subject_th);
				                            $subject_th = str_replace("#date",$date,$subject_th);
				                            $subject_th = str_replace("#time",date('H:i'),$subject_th);
				                        }
				                        if($subject_en!=""){
				                            $subject_en = str_replace("#fullname",$data['fullname_en'],$subject_en);
				                            $subject_en = str_replace("#username",$data_user['useri'],$subject_en);
				                            $subject_en = str_replace("#email",$data['email'],$subject_en);
				                            $subject_en = str_replace("#coursename","",$subject_en);
				                            $subject_en = str_replace("#password",$password,$subject_en);
				                            $subject_en = str_replace("#link_frontend",base_url(),$subject_en);
				                            $subject_en = str_replace("#date",$date,$subject_en);
				                            $subject_en = str_replace("#time",date('H:i'),$subject_en);
				                        }
				                        if($message_th!=""){
				                            $message_th = str_replace("#fullname",$data['fullname_th'],$message_th);
				                            $message_th = str_replace("#username",$data_user['useri'],$message_th);
				                            $message_th = str_replace("#email",$data['email'],$message_th);
				                            $message_th = str_replace("#coursename","",$message_th);
				                            $message_th = str_replace("#password",$password,$message_th);
				                            $message_th = str_replace("#link_frontend",base_url(),$message_th);
				                            $message_th = str_replace("#date",$date,$message_th);
				                            $message_th = str_replace("#time",date('H:i'),$message_th);
				                        }
				                        if($message_en!=""){
				                            $message_en = str_replace("#fullname",$data['fullname_en'],$message_en);
				                            $message_en = str_replace("#username",$data_user['useri'],$message_en);
				                            $message_en = str_replace("#email",$data['email'],$message_en);
				                            $message_en = str_replace("#coursename","",$message_en);
				                            $message_en = str_replace("#password",$password,$message_en);
				                            $message_en = str_replace("#link_frontend",base_url(),$message_en);
				                            $message_en = str_replace("#date",$date,$message_en);
				                            $message_en = str_replace("#time",date('H:i'),$message_en);
				                        }
				                        if($lang == "thai") {
				                          $this->db->sendEmail( $data['email'] , $message_th, $subject_th,$fetch_setmail);
				                        } else {
				                          $this->db->sendEmail( $data['email'] , $message_en, $subject_en,$fetch_setmail);
				                        }
									}
							}else{
								if($status_save!=""){
									$status_save = $status_save;
								}else{
									$status_save = "0";
								}
							}
						}else{
							$status_save = "0";
						}
					}else{
				        $data['emp_modifiedby'] = $sess['u_id'];
						$data['emp_modifieddate'] = date('Y-m-d H:i');
						$msg = $this->manage->update_emp($data,$_REQUEST['emp_id']);
						if($msg=="2"){
							$data_user['emp_id'] = $_REQUEST['emp_id'];
							$status_save = $this->manage->update_user($data_user,$_REQUEST['u_id']);
							//$this->update_manager($data['emp_manage_a'],$data['emp_manage_b']);
						}
					}
			}else{
				$status_save = "9";
			}
		}
		echo $status_save;
	}

	public function update_manager($emp_c_a,$emp_c_b){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");

			            		if($emp_c_a!=""){
				            		$fetch_chkemp = $this->func_query->query_row('LMS_EMP','','','','emp_c="'.$emp_c_a.'" and emp_isDelete="0" and depart_date="0000-00-00"');
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
			            		if($emp_c_b!=""){
				            		$fetch_chkemp = $this->func_query->query_row('LMS_EMP','','','','emp_c="'.$emp_c_b.'" and emp_isDelete="0" and depart_date="0000-00-00"');
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

	public function delete_company_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$fetch_chkuser = $this->func_query->numrows('LMS_EMP','','','','com_id ="'.$_REQUEST['com_id_delete'].'" and emp_isDelete="0"');
		if(count($_REQUEST)>0){
			if($fetch_chkuser==0){
				$data = array(
					'com_isDelete' => '1',
					'com_modifiedby' => $sess['u_id'],
					'com_modifieddate' => date('Y-m-d H:i')
				);
				$msg = $this->manage->update_company($data,$_REQUEST['com_id_delete']);
			}else{
				$msg = "1";
			}
		}
		echo $msg;
	}

	public function delete_company_score_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		if(count($_REQUEST)>0){
				$data = array(
					'coms_isDelete' => '1',
					'coms_modifiedby' => $sess['u_id'],
					'coms_modifieddate' => date('Y-m-d H:i')
				);
				$msg = $this->manage->update_company_score($data,$_REQUEST['coms_id']);
		}
		echo $msg;
	}

	public function delete_division_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$fetch_chkuser = $this->func_query->numrows('LMS_EMP','','','','div_id ="'.$_REQUEST['div_id'].'" and emp_isDelete="0"');
		if(count($_REQUEST)>0){
			if($fetch_chkuser==0){
				$data = array(
					'div_isDelete' => '1',
					'div_modifiedby' => $sess['u_id'],
					'div_modifieddate' => date('Y-m-d H:i')
				);
				$msg = $this->manage->update_division($data,$_REQUEST['div_id']);
			}else{
				$msg = "1";
			}
		}
		echo $msg;
	}

	public function delete_position_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$fetch_chkuser = $this->func_query->numrows('LMS_EMP','','','','posi_id ="'.$_REQUEST['posi_id'].'" and emp_isDelete="0"');
		if(count($_REQUEST)>0){
			if($fetch_chkuser==0){
				$data = array(
					'posi_isDelete' => '1',
					'posi_modifiedby' => $sess['u_id'],
					'posi_modifieddate' => date('Y-m-d H:i')
				);
				$msg = $this->manage->update_division($data,$_REQUEST['posi_id']);
			}else{
				$msg = "1";
			}
		}
		echo $msg;
	}

	public function delete_level_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		if(count($_REQUEST)>0){
				$data = array(
					'lv_isDelete' => '1',
					'lv_modifiedby' => $sess['u_id'],
					'lv_modifieddate' => date('Y-m-d H:i')
				);
				$msg = $this->manage->update_level($data,$_REQUEST['lv_id']);
		}
		echo $msg;
	}

	public function delete_store_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		if(count($_REQUEST)>0){
				$data = array(
					'st_isDelete' => '1',
					'st_modifiedby' => $sess['u_id'],
					'st_modifieddate' => date('Y-m-d H:i')
				);
				$msg = $this->manage->update_store($data,$_REQUEST['st_id']);
		}
		echo $msg;
	}

	public function delete_group_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$fetch_chkuser = $this->func_query->numrows('LMS_EMP','','','','group_id ="'.$_REQUEST['group_id'].'" and emp_isDelete="0"');
		if(count($_REQUEST)>0){
			if($fetch_chkuser==0){
				$data = array(
					'group_isDelete' => '1',
					'group_modifiedby' => $sess['u_id'],
					'group_modifieddate' => date('Y-m-d H:i')
				);
				$msg = $this->manage->update_group($data,$_REQUEST['group_id']);
			}else{
				$msg = "1";
			}
		}
		echo $msg;
	}

	public function delete_department_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$fetch_chkuser = $this->func_query->numrows('LMS_EMP','','','','dep_id ="'.$_REQUEST['dep_id'].'" and emp_isDelete="0"');
		if(count($_REQUEST)>0){
			if($fetch_chkuser==0){
				$data = array(
					'dep_isDelete' => '1',
					'dep_modifiedby' => $sess['u_id'],
					'dep_modifieddate' => date('Y-m-d H:i')
				);
				$msg = $this->manage->update_department($data,$_REQUEST['dep_id']);
			}else{
				$msg = "1";
			}
		}
		echo $msg;
	}

	public function delete_section_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$fetch_chkuser = $this->func_query->numrows('LMS_EMP','','','','section_id ="'.$_REQUEST['section_id'].'" and emp_isDelete="0"');
		if(count($_REQUEST)>0){
			if($fetch_chkuser==0){
				$data = array(
					'section_isDelete' => '1',
					'section_modifiedby' => $sess['u_id'],
					'section_modifieddate' => date('Y-m-d H:i')
				);
				$msg = $this->manage->update_section($data,$_REQUEST['section_id']);
			}else{
				$msg = "1";
			}
		}
		echo $msg;
	}

	public function delete_area_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$fetch_chkuser = $this->func_query->numrows('LMS_EMP','','','','salearea_id ="'.$_REQUEST['salearea_id'].'" and emp_isDelete="0"');
		if(count($_REQUEST)>0){
			if($fetch_chkuser==0){
				$data = array(
					'salearea_isDelete' => '1',
					'salearea_modifiedby' => $sess['u_id'],
					'salearea_modifieddate' => date('Y-m-d H:i')
				);
				$msg = $this->manage->update_area($data,$_REQUEST['salearea_id']);
			}else{
				$msg = "1";
			}
		}
		echo $msg;
	}

	public function delete_conmsg_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		if(count($_REQUEST)>0){
			$data = array(
				'conmsg_isDelete' => '1',
				'conmsg_modifiedby' => $sess['u_id'],
				'conmsg_modifieddate' => date('Y-m-d H:i')
			);
			$msg = $this->manage->update_conmsg($data,$_REQUEST['conmsg_id']);
		}
		echo $msg;
	}

	public function delete_workgroup_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$msg = "";
		if(count($_REQUEST)>0){
			$data = array(
				'wg_isDelete' => '1',
				'wg_modifiedby' => $sess['u_id'],
				'wg_modifieddate' => date('Y-m-d H:i')
			);

            $this->db->where('wg_id',$_REQUEST['id_delete']);
            $this->db->update('LMS_WKG', $data);
			$msg = "2";
		}
		echo $msg;
	}

	public function delete_cosgroup_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$msg = "";
		if(count($_REQUEST)>0){
			$data = array(
				'cg_isDelete' => '1',
				'u_by' => $sess['u_id'],
				'u_date' => date('Y-m-d H:i')
			);

            $this->db->where('wg_id',$_REQUEST['id_delete']);
            $this->db->update('LMS_WKG', $data);
			$msg = "2";
		}
		echo $msg;
	}

	public function approve_cosgroupall(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$fetch = $this->func_query->query_result('LMS_COG','','','','cg_approve="1" and cg_isDelete="0" and cg_id not in (select cg_id from LMS_COG_APPROVE)');
		foreach ($fetch as $key => $value) {
		    $arr_update = array(
		      'cg_id' => $value['cg_id'],
		      'coga_approve' => '1',
		      'coga_createby' => $value['u_by'],
		      'coga_createdate' => $value['u_date'],
		    );
		    $this->db->insert('LMS_COG_APPROVE',$arr_update);
		}
	}

	public function approve_cosgroup_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
   		$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		$msg = "";
		if(count($_REQUEST)>0){
		    $arr_update = array(
		      'cg_id' => $_REQUEST['cg_id'],
		      'coga_approve' => '1',
		      'coga_createby' => $sess['u_id'],
		      'coga_createdate' => date('Y-m-d H:i'),
		    );
		    $this->db->insert('LMS_COG_APPROVE',$arr_update);
			$data = array(
				'cg_approve' => '1',
				'u_by' => $sess['u_id'],
				'u_date' => date('Y-m-d H:i')
			);

            $this->db->where('cg_id',$_REQUEST['cg_id']);
            $this->db->update('LMS_COG', $data);

            $fetch_cg = $this->func_query->query_row('LMS_COG','','','','cg_id="'.$_REQUEST['cg_id'].'"');
			$fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
              	$date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
              	if($lang!="thai"){
                 	$date = date('d F Y');
              	}
                if($lang=="thai"){ 
                    $cgtitle = $fetch_cg['cgtitle_th']!=""?$fetch_cg['cgtitle_th']:$fetch_cg['cgtitle_en'];
                }else if($lang=="english"){ 
                    $cgtitle = $fetch_cg['cgtitle_en']!=""?$fetch_cg['cgtitle_en']:$fetch_cg['cgtitle_th'];
                }

	              	$date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
	              	if($lang!="thai"){
	                 	$date = date('d F Y');
	              	}
                if($fetch_cg['c_by']!=""){
		            $fetch_user = $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.u_id="'.$fetch_cg['c_by'].'"');
		            $fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="5"');
		            if(count($fetch_formatmail)>0){
		              	$subject_th = $fetch_formatmail['smf_subject_th'];
		              	$subject_en = $fetch_formatmail['smf_subject_en'];
		              	$message_th = $fetch_formatmail['smf_message_th'];
		              	$message_en = $fetch_formatmail['smf_message_en'];
		                if($subject_th!=""){
		                  $subject_th = str_replace("#fullname",$fetch_user['fullname_th'],$subject_th);
		                  $subject_th = str_replace("#username",$fetch_user['useri'],$subject_th);
		                  $subject_th = str_replace("#email",$fetch_user['email'],$subject_th);
		                  $subject_th = str_replace("#coursename",$cgtitle,$subject_th);
		                  $subject_th = str_replace("#link_frontend",base_url()."managecourse/course_groups/",$subject_th);
		                  $subject_th = str_replace("#date",$date,$subject_th);
		                  $subject_th = str_replace("#time",date('H:i'),$subject_th);
		                  $subject_th = str_replace("#perioddate",'',$subject_th);
		                }
		                if($subject_en!=""){
		                  $subject_en = str_replace("#fullname",$fetch_user['fullname_en'],$subject_en);
		                  $subject_en = str_replace("#username",$fetch_user['useri'],$subject_en);
		                  $subject_en = str_replace("#email",$fetch_user['email'],$subject_en);
		                  $subject_en = str_replace("#coursename",$cgtitle,$subject_en);
		                  $subject_en = str_replace("#link_frontend",base_url()."managecourse/course_groups/",$subject_en);
		                  $subject_en = str_replace("#date",$date,$subject_en);
		                  $subject_en = str_replace("#time",date('H:i'),$subject_en);
		                  $subject_en = str_replace("#perioddate",'',$subject_en);
		                }
		                if($message_th!=""){
		                  $message_th = str_replace("#fullname",$fetch_user['fullname_th'],$message_th);
		                  $message_th = str_replace("#username",$fetch_user['useri'],$message_th);
		                  $message_th = str_replace("#email",$fetch_user['email'],$message_th);
		                  $message_th = str_replace("#coursename",$cgtitle,$message_th);
		                  $message_th = str_replace("#link_frontend",base_url()."managecourse/course_groups/",$message_th);
		                  $message_th = str_replace("#date",$date,$message_th);
		                  $message_th = str_replace("#time",date('H:i'),$message_th);
		                  $message_th = str_replace("#perioddate",'',$message_th);
		                }
		                if($message_en!=""){
		                  $message_en = str_replace("#fullname",$fetch_user['fullname_en'],$message_en);
		                  $message_en = str_replace("#username",$fetch_user['useri'],$message_en);
		                  $message_en = str_replace("#email",$fetch_user['email'],$message_en);
		                  $message_en = str_replace("#coursename",$cgtitle,$message_en);
		                  $message_en = str_replace("#link_frontend",base_url()."managecourse/course_groups/",$message_en);
		                  $message_en = str_replace("#date",$date,$message_en);
		                  $message_en = str_replace("#time",date('H:i'),$message_en);
		                  $message_en = str_replace("#perioddate",'',$message_en);
		                }
		                if($lang == "thai") {
		                $this->db->sendEmail( $fetch_user['email'] , $message_th, $subject_th,$fetch_setmail);
		                } else {
		                $this->db->sendEmail( $fetch_user['email'] , $message_en, $subject_en,$fetch_setmail);
		                }
		            }
                }
			$msg = "2";
		}
		echo $msg;
	}

	public function delete_cosdoc_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$msg = "";
		if(count($_REQUEST)>0){
			$data = array(
				'fil_isDelete' => '1',
				'fil_modifiedby' => $sess['u_id'],
				'fil_modifieddate' => date('Y-m-d H:i')
			);

            $this->db->where('fil_cos_id',$_REQUEST['id_delete']);
            $this->db->update('LMS_COS_FIL', $data);

	        $fetch = $this->func_query->query_row('LMS_COS_FIL','','','','fil_cos_id="'.$_REQUEST['id_delete'].'"');
	        $arr_update = array('cos_modifieddate'=>date('Y-m-d H:i:s'));
	        $this->db->where('cos_id',$fetch['cos_id']);
	        $this->db->update('LMS_COS',$arr_update);
			$msg = "2";
		}
		echo $msg;
	}

	public function delete_cosdetail_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$msg = "";
		if(count($_REQUEST)>0){
			$data = array(
				'cosde_isDelete' => '1',
				'cosde_modifiedby' => $sess['u_id'],
				'cosde_modifieddate' => date('Y-m-d H:i')
			);

            $this->db->where('cosde_id',$_REQUEST['cosde_id']);
            $this->db->update('LMS_COS_DETAIL', $data);

	        $fetch = $this->func_query->query_row('LMS_COS_DETAIL','','','','cosde_id="'.$_REQUEST['cosde_id'].'"');
	        $arr_update = array('cos_modifieddate'=>date('Y-m-d H:i:s'));
	        $this->db->where('cos_id',$fetch['cos_id']);
	        $this->db->update('LMS_COS',$arr_update);
			$msg = "2";
		}
		echo $msg;
	}

	public function delete_cos_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$msg = "";
		if(count($_REQUEST)>0){
			$data = array(
				'cos_isDelete' => '1',
				'cos_modifiedby' => $sess['u_id'],
				'cos_modifieddate' => date('Y-m-d H:i')
			);

            $this->db->where('cos_id',$_REQUEST['id_delete']);
            $this->db->update('LMS_COS', $data);
			$msg = "2";
		}
		echo $msg;
	}

	public function delete_sv_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$msg = "";
		if(count($_REQUEST)>0){
			$data = array(
				'sv_isDelete' => '1',
				'sv_modifiedby' => $sess['u_id'],
				'sv_modifieddate' => date('Y-m-d H:i')
			);

            $this->db->where('sv_id',$_REQUEST['id_delete']);
            $this->db->update('LMS_SV', $data);
			$msg = "2";
		}
		echo $msg;
	}

	public function delete_sv_question_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$msg = "";
		if(count($_REQUEST)>0){
			$data = array(
				'svde_isDelete' => '1',
				'svde_modifiedby' => $sess['u_id'],
				'svde_modifieddate' => date('Y-m-d H:i')
			);

            $this->db->where('svde_id',$_REQUEST['id_delete']);
            $this->db->update('LMS_SVDE', $data);
			$msg = "2";
		}
		echo $msg;
	}

	public function delete_data_qiz_exp(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$msg = "";
		if(count($_REQUEST)>0){
			$data = array(
				'qize_isDelete' => '1',
				'qize_modifiedby' => $sess['u_id'],
				'qize_modifieddate' => date('Y-m-d H:i')
			);

            $this->db->where('qize_id',$_REQUEST['qize_id']);
            $this->db->update('LMS_QIZ_EXP', $data);
			$msg = "2";
		}
		echo $msg;
	}

	public function delete_data_qiz_exp_question(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		$msg = "";
		if(count($_REQUEST)>0){
			$data = array(
				'quese_isDelete' => '1',
				'quese_modifiedby' => $sess['u_id'],
				'quese_modifieddate' => date('Y-m-d H:i')
			);

            $this->db->where('quese_id',$_REQUEST['quese_id']);
            $this->db->update('LMS_QUESE', $data);
			$msg = "2";
		}
		echo $msg;
	}

	public function recheckmanage_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$emp_manage = $this->input->post('emp_manage');
		$email = $this->input->post('email');
		$emp_manage_type = $this->input->post('emp_manage_type');
		$com_id = $this->input->post('com_id');
		$q = $this->input->post('q');
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$this->load->model('Function_query_model', 'func_query', FALSE);
	    $this->func_query->loadDB();
		$fetch_query = $this->func_query->query_result('LMS_EMP','','','','emp_isDelete="0" and com_id="'.$com_id.'" and email!="" and email!="'.$email.'" and email like "%'.$q.'%"','','email',100);
		$array = array();
		if(count($fetch_query)>0){
			//echo "<optgroup label='".label('sv_b_none')."'>";
			$array[] =  array("id"=> "", "value" => label('sv_b_none') , "selected"=> false);
			$numloop = 1;
			foreach ($fetch_query as $key) {
				$select_val = false;
				if($key['email']==$emp_manage){
					$select_val = true;

				}
				$numloop++;
				//echo "<option value='".$key['cus_id']."' ".$select_val.">".$key['cus_fullname']."</option>"; 
				$array[] =  array("id"=> $key["email"], "value" => $key["email"] , "selected"=> $select_val);
				
			}
			$this->manage->closeDB();
			//echo "</optgroup>";
		}else{
			//echo "<option value=''>".label('datanotfound')."</option>";
			$array[] =  array("id"=> '', "value" => label('wg_datanotfound'));
		}
		echo json_encode($array, JSON_UNESCAPED_UNICODE);
	}

	public function recheckmanage_data_normal(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$emp_manage = $this->input->post('emp_manage');
		$email = $this->input->post('email');
		$emp_manage_type = $this->input->post('emp_manage_type');
		$com_id = $this->input->post('com_id');
		$q = $this->input->post('q');
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$this->load->model('Function_query_model', 'func_query', FALSE);
	    $this->func_query->loadDB();
		$fetch_query = $this->func_query->query_result('LMS_EMP','','','','emp_isDelete="0" and com_id="'.$com_id.'" and email!="" and email!="'.$email.'"','','email',100);
		$array = array();
		if(count($fetch_query)>0){
			echo "<optgroup label='".label('sv_b_none')."'>";
			//$array[] =  array("id"=> "", "value" => label('sv_b_none') , "selected"=> false);
			$numloop = 1;
			foreach ($fetch_query as $key) {
				$select_val = false;
				if($key['email']==$emp_manage){
					$select_val = true;

				}
				$numloop++;
				echo "<option value='".$key['email']."' ".$select_val.">".$key['email']."</option>"; 
				//$array[] =  array("id"=> $key["email"], "value" => $key["email"] , "selected"=> $select_val);
				
			}
			$this->manage->closeDB();
			echo "</optgroup>";
		}else{
			echo "<option value=''>".label('wg_datanotfound')."</option>";
			//$array[] =  array("id"=> '', "value" => label('datanotfound'));
		}
		echo json_encode($array, JSON_UNESCAPED_UNICODE);
	}

	public function approve_cos_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
   		$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		$msg = "";
		if(count($_REQUEST)>0){
		    $arr_update = array(
		      'cos_id' => $_REQUEST['cos_id'],
		      'cosa_approve' => '1',
		      'cosa_createby' => $sess['u_id'],
		      'cosa_createdate' => date('Y-m-d H:i'),
		    );
		    $this->db->insert('LMS_COS_APPROVE',$arr_update);
			$data = array(
				'cos_public' => '1',
				'cos_approve' => '1',
				'cos_approveby' => $sess['u_id'],
				'cos_approvedate' => date('Y-m-d H:i')
			);

            $this->db->where('cos_id',$_REQUEST['cos_id']);
            $this->db->update('LMS_COS', $data);

            $fetch_cos = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$_REQUEST['cos_id'].'"');
			$fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
              	$date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
              	if($lang!="thai"){
                 	$date = date('d F Y');
              	}
                if($lang=="thai"){ 
                    $cname = $fetch_cos['cname_th']!=""?$fetch_cos['cname_th']:$fetch_cos['cname_eng'];
                }else if($lang=="english"){ 
                    $cname = $fetch_cos['cname_eng']!=""?$fetch_cos['cname_eng']:$fetch_cos['cname_th'];
                }
	              	$date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
	              	if($lang!="thai"){
	                 	$date = date('d F Y');
	              	}
                $period = label('UnlimitedTime');
                $fetch_cos_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id="'.$_REQUEST['cos_id'].'" and cosde_status="1" and cosde_isDelete="0"');
                if(count($fetch_cos_detail)>0){
                	if($fetch_cos_detail['date_start']!="0000-00-00 00:00:00"&&$fetch_cos_detail['date_end']!="0000-00-00 00:00:00"){
			            if($lang=="thai"){
			            $periodstart = $fetch_cos_detail['date_start']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_cos_detail['date_start'])).$thaimonth[intval(date('m',strtotime($fetch_cos_detail['date_start'])))].(date('Y',strtotime($fetch_cos_detail['date_start']))+543)." ".date('H:i',strtotime($fetch_cos_detail['date_start'])):"";
			            $periodend = $fetch_cos_detail['date_end']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_cos_detail['date_end'])).$thaimonth[intval(date('m',strtotime($fetch_cos_detail['date_end'])))].(date('Y',strtotime($fetch_cos_detail['date_end']))+543)." ".date('H:i',strtotime($fetch_cos_detail['date_end'])):"";
			            }else{
			            $periodstart = $fetch_cos_detail['date_start']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($fetch_cos_detail['date_start'])):"";
			            $periodend = $fetch_cos_detail['date_end']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($fetch_cos_detail['date_end'])):"";
			            }
			            
			            if($periodstart!=""&&$periodend!=""){
			              	$period = $periodstart." - ".$periodend;
			            }
                	}

                	$fetch_chk_position = $this->func_query->query_result('LMS_COS_DETAIL_UG','','','','cosde_id="'.$fetch_cos_detail['cosde_id'].'"');
                	if(count($fetch_chk_position)>0){
		           		$fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="12"');
                		foreach ($fetch_chk_position as $key_chk_position => $value_chk_position) {
						    if(count($fetch_formatmail)>0){
		            		$fetch_userposi = $this->func_query->query_result('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.posi_id="'.$value_chk_position['posi_id'].'" and LMS_USP.u_isDelete="0" and LMS_EMP.emp_isDelete="0"');
		            		if(count($fetch_userposi)){
		            			foreach ($fetch_userposi as $key_userposi => $value_userposi) {
						              	$subject_th = $fetch_formatmail['smf_subject_th'];
						              	$subject_en = $fetch_formatmail['smf_subject_en'];
						              	$message_th = $fetch_formatmail['smf_message_th'];
						              	$message_en = $fetch_formatmail['smf_message_en'];
						                if($subject_th!=""){
						                  $subject_th = str_replace("#fullname",$value_userposi['fullname_th'],$subject_th);
						                  $subject_th = str_replace("#username",$value_userposi['useri'],$subject_th);
						                  $subject_th = str_replace("#email",$value_userposi['email'],$subject_th);
						                  $subject_th = str_replace("#coursename",$cname,$subject_th);
						                  $subject_th = str_replace("#link_frontend",base_url()."coursemain/all_courses",$subject_th);
						                  $subject_th = str_replace("#date",$date,$subject_th);
						                  $subject_th = str_replace("#time",date('H:i'),$subject_th);
						                  $subject_th = str_replace("#perioddate",$period,$subject_th);
						                }
						                if($subject_en!=""){
						                  $subject_en = str_replace("#fullname",$value_userposi['fullname_en'],$subject_en);
						                  $subject_en = str_replace("#username",$value_userposi['useri'],$subject_en);
						                  $subject_en = str_replace("#email",$value_userposi['email'],$subject_en);
						                  $subject_en = str_replace("#coursename",$cname,$subject_en);
						                  $subject_en = str_replace("#link_frontend",base_url()."coursemain/all_courses",$subject_en);
						                  $subject_en = str_replace("#date",$date,$subject_en);
						                  $subject_en = str_replace("#time",date('H:i'),$subject_en);
						                  $subject_en = str_replace("#perioddate",$period,$subject_en);
						                }
						                if($message_th!=""){
						                  $message_th = str_replace("#fullname",$value_userposi['fullname_th'],$message_th);
						                  $message_th = str_replace("#username",$value_userposi['useri'],$message_th);
						                  $message_th = str_replace("#email",$value_userposi['email'],$message_th);
						                  $message_th = str_replace("#coursename",$cname,$message_th);
						                  $message_th = str_replace("#link_frontend",base_url()."coursemain/all_courses",$message_th);
						                  $message_th = str_replace("#date",$date,$message_th);
						                  $message_th = str_replace("#time",date('H:i'),$message_th);
						                  $message_th = str_replace("#perioddate",$period,$message_th);
						                }
						                if($message_en!=""){
						                  $message_en = str_replace("#fullname",$value_userposi['fullname_en'],$message_en);
						                  $message_en = str_replace("#username",$value_userposi['useri'],$message_en);
						                  $message_en = str_replace("#email",$value_userposi['email'],$message_en);
						                  $message_en = str_replace("#coursename",$cname,$message_en);
						                  $message_en = str_replace("#link_frontend",base_url()."coursemain/all_courses",$message_en);
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
                			# code...
                		}
                	}
                }
                if($fetch_cos['cos_createby']!=""){
		            $fetch_user = $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.u_id="'.$fetch_cos['cos_createby'].'"');
		            $fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="5"');
		            if(count($fetch_formatmail)>0){
		              	$subject_th = $fetch_formatmail['smf_subject_th'];
		              	$subject_en = $fetch_formatmail['smf_subject_en'];
		              	$message_th = $fetch_formatmail['smf_message_th'];
		              	$message_en = $fetch_formatmail['smf_message_en'];
		                if($subject_th!=""){
		                  $subject_th = str_replace("#fullname",$fetch_user['fullname_th'],$subject_th);
		                  $subject_th = str_replace("#username",$fetch_user['useri'],$subject_th);
		                  $subject_th = str_replace("#email",$fetch_user['email'],$subject_th);
		                  $subject_th = str_replace("#coursename",$cname,$subject_th);
		                  $subject_th = str_replace("#link_frontend",base_url()."managecourse/courses_all/",$subject_th);
		                  $subject_th = str_replace("#date",$date,$subject_th);
		                  $subject_th = str_replace("#time",date('H:i'),$subject_th);
		                  $subject_th = str_replace("#perioddate",$period,$subject_th);
		                }
		                if($subject_en!=""){
		                  $subject_en = str_replace("#fullname",$fetch_user['fullname_en'],$subject_en);
		                  $subject_en = str_replace("#username",$fetch_user['useri'],$subject_en);
		                  $subject_en = str_replace("#email",$fetch_user['email'],$subject_en);
		                  $subject_en = str_replace("#coursename",$cname,$subject_en);
		                  $subject_en = str_replace("#link_frontend",base_url()."managecourse/courses_all/",$subject_en);
		                  $subject_en = str_replace("#date",$date,$subject_en);
		                  $subject_en = str_replace("#time",date('H:i'),$subject_en);
		                  $subject_en = str_replace("#perioddate",$period,$subject_en);
		                }
		                if($message_th!=""){
		                  $message_th = str_replace("#fullname",$fetch_user['fullname_th'],$message_th);
		                  $message_th = str_replace("#username",$fetch_user['useri'],$message_th);
		                  $message_th = str_replace("#email",$fetch_user['email'],$message_th);
		                  $message_th = str_replace("#coursename",$cname,$message_th);
		                  $message_th = str_replace("#link_frontend",base_url()."managecourse/courses_all/",$message_th);
		                  $message_th = str_replace("#date",$date,$message_th);
		                  $message_th = str_replace("#time",date('H:i'),$message_th);
		                  $message_th = str_replace("#perioddate",$period,$message_th);
		                }
		                if($message_en!=""){
		                  $message_en = str_replace("#fullname",$fetch_user['fullname_en'],$message_en);
		                  $message_en = str_replace("#username",$fetch_user['useri'],$message_en);
		                  $message_en = str_replace("#email",$fetch_user['email'],$message_en);
		                  $message_en = str_replace("#coursename",$cname,$message_en);
		                  $message_en = str_replace("#link_frontend",base_url()."managecourse/courses_all/",$message_en);
		                  $message_en = str_replace("#date",$date,$message_en);
		                  $message_en = str_replace("#time",date('H:i'),$message_en);
		                  $message_en = str_replace("#perioddate",$period,$message_en);
		                }
		                if($lang == "thai") {
		                $this->db->sendEmail( $fetch_user['email'] , $message_th, $subject_th,$fetch_setmail);
		                } else {
		                $this->db->sendEmail( $fetch_user['email'] , $message_en, $subject_en,$fetch_setmail);
		                }
		            }
                }
            $fetch_tc = $this->func_query->query_result('LMS_COS_ENROLL','','','','cos_id="'.$_REQUEST['cos_id'].'" and  cosen_isDelete="0"');
            if(count($fetch_tc)>0){
            	foreach ($fetch_tc as $key_tc => $value_tc) {
		            $fetch_user = $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_EMP.emp_id="'.$value_tc['emp_id'].'"');
		            $fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="10"');
		            if(count($fetch_formatmail)>0){
		              $subject_th = $fetch_formatmail['smf_subject_th'];
		              $subject_en = $fetch_formatmail['smf_subject_en'];
		              $message_th = $fetch_formatmail['smf_message_th'];
		              $message_en = $fetch_formatmail['smf_message_en'];
		                if($subject_th!=""){
		                  $subject_th = str_replace("#fullname",$fetch_user['fullname_th'],$subject_th);
		                  $subject_th = str_replace("#username",$fetch_user['useri'],$subject_th);
		                  $subject_th = str_replace("#email",$fetch_user['email'],$subject_th);
		                  $subject_th = str_replace("#coursename",$cname,$subject_th);
		                  $subject_th = str_replace("#link_frontend",base_url()."coursemain/detail/".$_REQUEST['cos_id'],$subject_th);
		                  $subject_th = str_replace("#date",$date,$subject_th);
		                  $subject_th = str_replace("#time",date('H:i'),$subject_th);
		                  $subject_th = str_replace("#perioddate",$period,$subject_th);
		                }
		                if($subject_en!=""){
		                  $subject_en = str_replace("#fullname",$fetch_user['fullname_en'],$subject_en);
		                  $subject_en = str_replace("#username",$fetch_user['useri'],$subject_en);
		                  $subject_en = str_replace("#email",$fetch_user['email'],$subject_en);
		                  $subject_en = str_replace("#coursename",$cname,$subject_en);
		                  $subject_en = str_replace("#link_frontend",base_url()."coursemain/detail/".$_REQUEST['cos_id'],$subject_en);
		                  $subject_en = str_replace("#date",$date,$subject_en);
		                  $subject_en = str_replace("#time",date('H:i'),$subject_en);
		                  $subject_en = str_replace("#perioddate",$period,$subject_en);
		                }
		                if($message_th!=""){
		                  $message_th = str_replace("#fullname",$fetch_user['fullname_th'],$message_th);
		                  $message_th = str_replace("#username",$fetch_user['useri'],$message_th);
		                  $message_th = str_replace("#email",$fetch_user['email'],$message_th);
		                  $message_th = str_replace("#coursename",$cname,$message_th);
		                  $message_th = str_replace("#link_frontend",base_url()."coursemain/detail/".$_REQUEST['cos_id'],$message_th);
		                  $message_th = str_replace("#date",$date,$message_th);
		                  $message_th = str_replace("#time",date('H:i'),$message_th);
		                  $message_th = str_replace("#perioddate",$period,$message_th);
		                }
		                if($message_en!=""){
		                  $message_en = str_replace("#fullname",$fetch_user['fullname_en'],$message_en);
		                  $message_en = str_replace("#username",$fetch_user['useri'],$message_en);
		                  $message_en = str_replace("#email",$fetch_user['email'],$message_en);
		                  $message_en = str_replace("#coursename",$cname,$message_en);
		                  $message_en = str_replace("#link_frontend",base_url()."coursemain/detail/".$_REQUEST['cos_id'],$message_en);
		                  $message_en = str_replace("#date",$date,$message_en);
		                  $message_en = str_replace("#time",date('H:i'),$message_en);
		                  $message_en = str_replace("#perioddate",$period,$message_en);
		                }
		                if($lang == "thai") {
		                $this->db->sendEmail( $fetch_user['email'] , $message_th, $subject_th,$fetch_setmail);
		                } else {
		                $this->db->sendEmail( $fetch_user['email'] , $message_en, $subject_en,$fetch_setmail);
		                }
		            }
            	}
            }
			$msg = "2";
		}
		echo $msg;
	}

	public function approve_survey_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
   		$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		$msg = "";
		if(count($_REQUEST)>0){
		    $arr_update = array(
		      'sv_id' => $_REQUEST['sv_id'],
		      'sva_approve' => '1',
		      'sva_createby' => $sess['u_id'],
		      'sva_createdate' => date('Y-m-d H:i'),
		    );
		    $this->db->insert('LMS_SV_APPROVE',$arr_update);
			$data = array(
				'sv_public' => '1',
				'sv_approve' => '1',
				'sv_approveby' => $sess['u_id'],
				'sv_approvedate' => date('Y-m-d H:i')
			);
            $this->db->where('sv_id',$_REQUEST['sv_id']);
            $this->db->update('LMS_SV', $data);
        	$fetch_sv = $this->func_query->query_row('LMS_SV','','','','sv_id="'.$_REQUEST['sv_id'].'"');
			$fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
              	$date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
              	if($lang!="thai"){
                 	$date = date('d F Y');
              	}
                if($lang=="thai"){ 
                    $sv_title = $fetch_sv['sv_title_th']!=""?$fetch_sv['sv_title_th']:$fetch_sv['sv_title_eng'];
                }else if($lang=="english"){ 
                    $sv_title = $fetch_sv['sv_title_eng']!=""?$fetch_sv['sv_title_eng']:$fetch_sv['sv_title_th'];
                }
		            if($lang=="thai"){
		            $periodstart = $fetch_sv['sv_open']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_sv['sv_open'])).$thaimonth[intval(date('m',strtotime($fetch_sv['sv_open'])))].(date('Y',strtotime($fetch_sv['sv_open']))+543)." ".date('H:i',strtotime($fetch_sv['sv_open'])):"";
		            $periodend = $fetch_sv['sv_end']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_sv['sv_end'])).$thaimonth[intval(date('m',strtotime($fetch_sv['sv_end'])))].(date('Y',strtotime($fetch_sv['sv_end']))+543)." ".date('H:i',strtotime($fetch_sv['sv_end'])):"";
		            }else{
		            $periodstart = $fetch_sv['sv_open']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($fetch_sv['sv_open'])):"";
		            $periodend = $fetch_sv['sv_end']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($fetch_sv['sv_end'])):"";
		            }
		            $period = label('UnlimitedTime');
		            if($periodstart!=""&&$periodend!=""){
		              	$period = $periodstart." - ".$periodend;
		            }
	              	$date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
	              	if($lang!="thai"){
	                 	$date = date('d F Y');
	              	}
                if($fetch_sv['sv_createby']!=""){
		            $fetch_user = $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.u_id="'.$fetch_sv['sv_createby'].'"');
		            $fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="8"');
		            if(count($fetch_formatmail)>0){
		              	$subject_th = $fetch_formatmail['smf_subject_th'];
		              	$subject_en = $fetch_formatmail['smf_subject_en'];
		              	$message_th = $fetch_formatmail['smf_message_th'];
		              	$message_en = $fetch_formatmail['smf_message_en'];
		                if($subject_th!=""){
		                  $subject_th = str_replace("#fullname",$fetch_user['fullname_th'],$subject_th);
		                  $subject_th = str_replace("#username",$fetch_user['useri'],$subject_th);
		                  $subject_th = str_replace("#email",$fetch_user['email'],$subject_th);
		                  $subject_th = str_replace("#coursename",$sv_title,$subject_th);
		                  $subject_th = str_replace("#link_frontend",base_url()."survey/list_survey/",$subject_th);
		                  $subject_th = str_replace("#date",$date,$subject_th);
		                  $subject_th = str_replace("#time",date('H:i'),$subject_th);
		                  $subject_th = str_replace("#perioddate",$period,$subject_th);
		                }
		                if($subject_en!=""){
		                  $subject_en = str_replace("#fullname",$fetch_user['fullname_en'],$subject_en);
		                  $subject_en = str_replace("#username",$fetch_user['useri'],$subject_en);
		                  $subject_en = str_replace("#email",$fetch_user['email'],$subject_en);
		                  $subject_en = str_replace("#coursename",$sv_title,$subject_en);
		                  $subject_en = str_replace("#link_frontend",base_url()."survey/list_survey/",$subject_en);
		                  $subject_en = str_replace("#date",$date,$subject_en);
		                  $subject_en = str_replace("#time",date('H:i'),$subject_en);
		                  $subject_en = str_replace("#perioddate",$period,$subject_en);
		                }
		                if($message_th!=""){
		                  $message_th = str_replace("#fullname",$fetch_user['fullname_th'],$message_th);
		                  $message_th = str_replace("#username",$fetch_user['useri'],$message_th);
		                  $message_th = str_replace("#email",$fetch_user['email'],$message_th);
		                  $message_th = str_replace("#coursename",$sv_title,$message_th);
		                  $message_th = str_replace("#link_frontend",base_url()."survey/list_survey/",$message_th);
		                  $message_th = str_replace("#date",$date,$message_th);
		                  $message_th = str_replace("#time",date('H:i'),$message_th);
		                  $message_th = str_replace("#perioddate",$period,$message_th);
		                }
		                if($message_en!=""){
		                  $message_en = str_replace("#fullname",$fetch_user['fullname_en'],$message_en);
		                  $message_en = str_replace("#username",$fetch_user['useri'],$message_en);
		                  $message_en = str_replace("#email",$fetch_user['email'],$message_en);
		                  $message_en = str_replace("#coursename",$sv_title,$message_en);
		                  $message_en = str_replace("#link_frontend",base_url()."survey/list_survey/",$message_en);
		                  $message_en = str_replace("#date",$date,$message_en);
		                  $message_en = str_replace("#time",date('H:i'),$message_en);
		                  $message_en = str_replace("#perioddate",$period,$message_en);
		                }
		                if($lang == "thai") {
		                $this->db->sendEmail( $fetch_user['email'] , $message_th, $subject_th,$fetch_setmail);
		                } else {
		                $this->db->sendEmail( $fetch_user['email'] , $message_en, $subject_en,$fetch_setmail);
		                }
		            }
                }


                	$fetch_chk_position = $this->func_query->query_result('LMS_SV_PM','','','','sv_id="'.$_REQUEST['sv_id'].'"');
                	if(count($fetch_chk_position)>0){
		           		$fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="16"');
                		foreach ($fetch_chk_position as $key_chk_position => $value_chk_position) {
						    if(count($fetch_formatmail)>0){
		            		$fetch_userposi = $this->func_query->query_result('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.posi_id="'.$value_chk_position['posi_id'].'" and LMS_USP.u_isDelete="0" and LMS_EMP.emp_isDelete="0"');
		            		if(count($fetch_userposi)){
		            			foreach ($fetch_userposi as $key_userposi => $value_userposi) {
						              	$subject_th = $fetch_formatmail['smf_subject_th'];
						              	$subject_en = $fetch_formatmail['smf_subject_en'];
						              	$message_th = $fetch_formatmail['smf_message_th'];
						              	$message_en = $fetch_formatmail['smf_message_en'];
						                if($subject_th!=""){
						                  $subject_th = str_replace("#fullname",$value_userposi['fullname_th'],$subject_th);
						                  $subject_th = str_replace("#username",$value_userposi['useri'],$subject_th);
						                  $subject_th = str_replace("#email",$value_userposi['email'],$subject_th);
						                  $subject_th = str_replace("#coursename",$sv_title,$subject_th);
						                  $subject_th = str_replace("#link_frontend",base_url()."survey",$subject_th);
						                  $subject_th = str_replace("#date",$date,$subject_th);
						                  $subject_th = str_replace("#time",date('H:i'),$subject_th);
						                  $subject_th = str_replace("#perioddate",$period,$subject_th);
						                }
						                if($subject_en!=""){
						                  $subject_en = str_replace("#fullname",$value_userposi['fullname_en'],$subject_en);
						                  $subject_en = str_replace("#username",$value_userposi['useri'],$subject_en);
						                  $subject_en = str_replace("#email",$value_userposi['email'],$subject_en);
						                  $subject_en = str_replace("#coursename",$sv_title,$subject_en);
						                  $subject_en = str_replace("#link_frontend",base_url()."survey",$subject_en);
						                  $subject_en = str_replace("#date",$date,$subject_en);
						                  $subject_en = str_replace("#time",date('H:i'),$subject_en);
						                  $subject_en = str_replace("#perioddate",$period,$subject_en);
						                }
						                if($message_th!=""){
						                  $message_th = str_replace("#fullname",$value_userposi['fullname_th'],$message_th);
						                  $message_th = str_replace("#username",$value_userposi['useri'],$message_th);
						                  $message_th = str_replace("#email",$value_userposi['email'],$message_th);
						                  $message_th = str_replace("#coursename",$sv_title,$message_th);
						                  $message_th = str_replace("#link_frontend",base_url()."survey",$message_th);
						                  $message_th = str_replace("#date",$date,$message_th);
						                  $message_th = str_replace("#time",date('H:i'),$message_th);
						                  $message_th = str_replace("#perioddate",$period,$message_th);
						                }
						                if($message_en!=""){
						                  $message_en = str_replace("#fullname",$value_userposi['fullname_en'],$message_en);
						                  $message_en = str_replace("#username",$value_userposi['useri'],$message_en);
						                  $message_en = str_replace("#email",$value_userposi['email'],$message_en);
						                  $message_en = str_replace("#coursename",$sv_title,$message_en);
						                  $message_en = str_replace("#link_frontend",base_url()."survey",$message_en);
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
                			# code...
                		}
                	}

            $fetch_tc = $this->func_query->query_result('LMS_SV_TC','','','','sv_id="'.$_REQUEST['sv_id'].'" and svtc_isMail="0" and svtc_isDelete="0"');
            if(count($fetch_tc)>0){
            	foreach ($fetch_tc as $key_tc => $value_tc) {
		            $fetch_user = $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_EMP.emp_id="'.$value_tc['emp_id'].'"');
		            $fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="11"');
		            if(count($fetch_formatmail)>0){
		              $subject_th = $fetch_formatmail['smf_subject_th'];
		              $subject_en = $fetch_formatmail['smf_subject_en'];
		              $message_th = $fetch_formatmail['smf_message_th'];
		              $message_en = $fetch_formatmail['smf_message_en'];
		                if($subject_th!=""){
		                  $subject_th = str_replace("#fullname",$fetch_user['fullname_th'],$subject_th);
		                  $subject_th = str_replace("#username",$fetch_user['useri'],$subject_th);
		                  $subject_th = str_replace("#email",$fetch_user['email'],$subject_th);
		                  $subject_th = str_replace("#coursename",$sv_title,$subject_th);
		                  $subject_th = str_replace("#link_frontend",base_url()."survey/surveyDetail/".$_REQUEST['sv_id'],$subject_th);
		                  $subject_th = str_replace("#date",$date,$subject_th);
		                  $subject_th = str_replace("#time",date('H:i'),$subject_th);
		                  $subject_th = str_replace("#perioddate",$period,$subject_th);
		                }
		                if($subject_en!=""){
		                  $subject_en = str_replace("#fullname",$fetch_user['fullname_en'],$subject_en);
		                  $subject_en = str_replace("#username",$fetch_user['useri'],$subject_en);
		                  $subject_en = str_replace("#email",$fetch_user['email'],$subject_en);
		                  $subject_en = str_replace("#coursename",$sv_title,$subject_en);
		                  $subject_en = str_replace("#link_frontend",base_url()."survey/surveyDetail/".$_REQUEST['sv_id'],$subject_en);
		                  $subject_en = str_replace("#date",$date,$subject_en);
		                  $subject_en = str_replace("#time",date('H:i'),$subject_en);
		                  $subject_en = str_replace("#perioddate",$period,$subject_en);
		                }
		                if($message_th!=""){
		                  $message_th = str_replace("#fullname",$fetch_user['fullname_th'],$message_th);
		                  $message_th = str_replace("#username",$fetch_user['useri'],$message_th);
		                  $message_th = str_replace("#email",$fetch_user['email'],$message_th);
		                  $message_th = str_replace("#coursename",$sv_title,$message_th);
		                  $message_th = str_replace("#link_frontend",base_url()."survey/surveyDetail/".$_REQUEST['sv_id'],$message_th);
		                  $message_th = str_replace("#date",$date,$message_th);
		                  $message_th = str_replace("#time",date('H:i'),$message_th);
		                  $message_th = str_replace("#perioddate",$period,$message_th);
		                }
		                if($message_en!=""){
		                  $message_en = str_replace("#fullname",$fetch_user['fullname_en'],$message_en);
		                  $message_en = str_replace("#username",$fetch_user['useri'],$message_en);
		                  $message_en = str_replace("#email",$fetch_user['email'],$message_en);
		                  $message_en = str_replace("#coursename",$sv_title,$message_en);
		                  $message_en = str_replace("#link_frontend",base_url()."survey/surveyDetail/".$_REQUEST['sv_id'],$message_en);
		                  $message_en = str_replace("#date",$date,$message_en);
		                  $message_en = str_replace("#time",date('H:i'),$message_en);
		                  $message_en = str_replace("#perioddate",$period,$message_en);
		                }
		                if($lang == "thai") {
		                $this->db->sendEmail( $fetch_user['email'] , $message_th, $subject_th,$fetch_setmail);
		                } else {
		                $this->db->sendEmail( $fetch_user['email'] , $message_en, $subject_en,$fetch_setmail);
		                }
		            }
            	}
            }
			$msg = "2";
		}
		echo $msg;
	}

	public function public_survey_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
   		$thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		$msg = "";
		if(count($_REQUEST)>0){
		    $arr_update = array(
		      'sv_id' => $_REQUEST['sv_id'],
		      'sva_approve' => '2',
		      'sva_createby' => $sess['u_id'],
		      'sva_createdate' => date('Y-m-d H:i'),
		    );
		    $this->db->insert('LMS_SV_APPROVE',$arr_update);
		    $arr_update = array(
		      'sv_id' => $_REQUEST['sv_id'],
		      'sv_public' => '1',
		      'sv_modifiedby' => $sess['u_id'],
		      'sv_modifieddate' => date('Y-m-d H:i'),
		    );
            $this->db->where('sv_id',$_REQUEST['sv_id']);
            $this->db->update('LMS_SV', $arr_update);

        	$fetch_com = $this->func_query->query_row('LMS_COMPANY','','','','com_id="'.$sess['com_id'].'"');
        	if($fetch_com['com_admin']=="com_central"){
        		$fetch_approver = $this->func_query->query_result('LMS_USP','LMS_EMP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.ug_id="6" and u_isDelete="0" and LMS_EMP.com_id="'.$sess['com_id'].'" and LMS_EMP.emp_isDelete="0"');
        	}else{
        	}
      		$arr_user = array();
        	$fetch_sv = $this->func_query->query_row('LMS_SV','','','','sv_id="'.$_REQUEST['sv_id'].'"');
        	$fetch_approver = array();
           	if(count($fetch_sv)>0&&$fetch_sv['sv_userapprove']!=""){
              	$arr_user = explode(',', $fetch_sv['sv_userapprove']);
              	if(count($arr_user)>0){
              		for ($i=0; $i < count($arr_user); $i++) { 
        				$fetch_data = $this->func_query->query_row('LMS_USP','LMS_EMP','LMS_USP.emp_id = LMS_EMP.emp_id','','u_isDelete="0" and LMS_EMP.emp_id="'.$arr_user[$i].'" and LMS_EMP.emp_isDelete="0"');
        				if(count($fetch_data)>0){
        						array_push($fetch_approver, $fetch_data);
        				}
              		}
              	}
          	}
        	if(isset($fetch_approver)&&count($fetch_approver)>0){
        		if($lang=="thai"){ 
                    $sv_title = $fetch_sv['sv_title_th']!=""?$fetch_sv['sv_title_th']:$fetch_sv['sv_title_eng'];
                  }else if($lang=="english"){ 
                    $sv_title = $fetch_sv['sv_title_eng']!=""?$fetch_sv['sv_title_eng']:$fetch_sv['sv_title_th'];
                  }
        			if($lang=="thai"){
		            $periodstart = $fetch_sv['sv_open']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_sv['sv_open'])).$thaimonth[intval(date('m',strtotime($fetch_sv['sv_open'])))].(date('Y',strtotime($fetch_sv['sv_open']))+543)." ".date('H:i',strtotime($fetch_sv['sv_open'])):"";
		            $periodend = $fetch_sv['sv_end']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_sv['sv_end'])).$thaimonth[intval(date('m',strtotime($fetch_sv['sv_end'])))].(date('Y',strtotime($fetch_sv['sv_end']))+543)." ".date('H:i',strtotime($fetch_sv['sv_end'])):"";
		            }else{
		            $periodstart = $fetch_sv['sv_open']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($fetch_sv['sv_open'])):"";
		            $periodend = $fetch_sv['sv_end']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($fetch_sv['sv_end'])):"";
		            }
		            $period = label('UnlimitedTime');
		            if($periodstart!=""&&$periodend!=""){
		              $period = $periodstart." - ".$periodend;
		            }
	              	$date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
	              	if($lang!="thai"){
	                 	$date = date('d F Y');
	             	}
        		foreach ($fetch_approver as $key_approve => $value_approve) {
        			$fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
		            $fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="7"');
		            if(count($fetch_formatmail)>0){
		              $subject_th = $fetch_formatmail['smf_subject_th'];
		              $subject_en = $fetch_formatmail['smf_subject_en'];
		              $message_th = $fetch_formatmail['smf_message_th'];
		              $message_en = $fetch_formatmail['smf_message_en'];
		                if($subject_th!=""){
		                  $subject_th = str_replace("#fullname",$value_approve['fullname_th'],$subject_th);
		                  $subject_th = str_replace("#username",$value_approve['useri'],$subject_th);
		                  $subject_th = str_replace("#email",$value_approve['email'],$subject_th);
		                  $subject_th = str_replace("#coursename",$sv_title,$subject_th);
		                  $subject_th = str_replace("#link_frontend",base_url()."survey/demo/".$_REQUEST['sv_id'],$subject_th);
		                  $subject_th = str_replace("#date",$date,$subject_th);
		                  $subject_th = str_replace("#time",date('H:i'),$subject_th);
		                  $subject_th = str_replace("#perioddate",$period,$subject_th);
		                }
		                if($subject_en!=""){
		                  $subject_en = str_replace("#fullname",$value_approve['fullname_en'],$subject_en);
		                  $subject_en = str_replace("#username",$value_approve['useri'],$subject_en);
		                  $subject_en = str_replace("#email",$value_approve['email'],$subject_en);
		                  $subject_en = str_replace("#coursename",$sv_title,$subject_en);
		                  $subject_en = str_replace("#link_frontend",base_url()."survey/demo/".$_REQUEST['sv_id'],$subject_en);
		                  $subject_en = str_replace("#date",$date,$subject_en);
		                  $subject_en = str_replace("#time",date('H:i'),$subject_en);
		                  $subject_en = str_replace("#perioddate",$period,$subject_en);
		                }
		                if($message_th!=""){
		                  $message_th = str_replace("#fullname",$value_approve['fullname_th'],$message_th);
		                  $message_th = str_replace("#username",$value_approve['useri'],$message_th);
		                  $message_th = str_replace("#email",$value_approve['email'],$message_th);
		                  $message_th = str_replace("#coursename",$sv_title,$message_th);
		                  $message_th = str_replace("#link_frontend",base_url()."survey/demo/".$_REQUEST['sv_id'],$message_th);
		                  $message_th = str_replace("#date",$date,$message_th);
		                  $message_th = str_replace("#time",date('H:i'),$message_th);
		                  $message_th = str_replace("#perioddate",$period,$message_th);
		                }
		                if($message_en!=""){
		                  $message_en = str_replace("#fullname",$value_approve['fullname_en'],$message_en);
		                  $message_en = str_replace("#username",$value_approve['useri'],$message_en);
		                  $message_en = str_replace("#email",$value_approve['email'],$message_en);
		                  $message_en = str_replace("#coursename",$sv_title,$message_en);
		                  $message_en = str_replace("#link_frontend",base_url()."survey/demo/".$_REQUEST['sv_id'],$message_en);
		                  $message_en = str_replace("#date",$date,$message_en);
		                  $message_en = str_replace("#time",date('H:i'),$message_en);
		                  $message_en = str_replace("#perioddate",$period,$message_en);
		                }
		                if($lang == "thai") {
		                $this->db->sendEmail( $value_approve['email'] , $message_th, $subject_th,$fetch_setmail);
		                } else {
		                $this->db->sendEmail( $value_approve['email'] , $message_en, $subject_en,$fetch_setmail);
		                }
		            }
        		}
        	}
        			
            		
			$msg = "2";
		}
		echo $msg;
	}
/*
	public function delete_department_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		if(count($_REQUEST)>0){
			$data = array(
				'dep_isDelete' => '1',
				'dep_modifiedby' => $sess['u_id'],
				'dep_modifieddate' => date('Y-m-d H:i')
			);
			$msg = $this->manage->update_department($data,$_REQUEST['dep_id_delete']);
		}
		echo $msg;
	}*/

	public function delete_svtc_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
   		$output = array();
		if(count($_REQUEST)>0){
			$data = array(
				'svtc_isDelete' => '1',
				'svtc_modifiedby' => $sess['u_id'],
				'svtc_modifieddate' => date('Y-m-d H:i')
			);
			$this->db->where('svtc_id',$_REQUEST['svtc_id']);
			$this->db->update('LMS_SV_TC',$data);
			$fetchchk = $this->func_query->query_row('LMS_SV_TC','','','','svtc_id="'.$_REQUEST['svtc_id'].'"');
			$data = array(
				'tc_isDelete' => '1',
				'tc_modifieddate' => date('Y-m-d H:i')
			);
			$this->db->where('sv_id',$fetchchk['sv_id']);
			$this->db->where('emp_id',$fetchchk['emp_id']);
			$this->db->update('LMS_SVDE_TC',$data);
			$output['status'] = "2";
		}else{
			$output['status'] = "0";
		}
		echo json_encode($output);
	}

	public function reset_svtc_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
   		$output = array();
		if(count($_REQUEST)>0){
			$data = array(
				'svtc_isDelete' => '1',
				'svtc_modifiedby' => $sess['u_id'],
				'svtc_modifieddate' => date('Y-m-d H:i')
			);
			$this->db->where('svtc_id',$_REQUEST['svtc_id']);
			$this->db->update('LMS_SV_TC',$data);
			$fetchchk = $this->func_query->query_row('LMS_SV_TC','','','','svtc_id="'.$_REQUEST['svtc_id'].'"');
			$data = array(
				'tc_isDelete' => '1',
				'tc_modifieddate' => date('Y-m-d H:i')
			);
			$this->db->where('sv_id',$fetchchk['sv_id']);
			$this->db->where('emp_id',$fetchchk['emp_id']);
			$this->db->update('LMS_SVDE_TC',$data);
			$data_insert = array(
				'sv_id' => $fetchchk['sv_id'],
				'emp_id' => $fetchchk['emp_id'],
				'svtc_createby' => $sess['u_id'],
				'svtc_createdate' => date('Y-m-d H:i'),
				'svtc_modifiedby' => $sess['u_id'],
				'svtc_modifieddate' => date('Y-m-d H:i')
			);
			$this->db->insert('LMS_SV_TC',$data_insert);
			$output['status'] = "2";
		}else{
			$output['status'] = "0";
		}
		echo json_encode($output);
	}

	public function delete_position_dataori(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		if(count($_REQUEST)>0){
			$data = array(
				'posi_isDelete' => '1',
				'posi_modifiedby' => $sess['u_id'],
				'posi_modifieddate' => date('Y-m-d H:i')
			);
			$msg = $this->manage->update_position_detail($data,$_REQUEST['posi_id_delete']);
		}
		echo $msg;
	}

	public function delete_groupuser_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		if(count($_REQUEST)>0){
			$data = array(
				'ug_isDelete' => '1',
				'ug_modifiedby' => $sess['u_id'],
				'ug_modifieddate' => date('Y-m-d H:i')
			);
			$msg = $this->manage->update_groupuser($data,$_REQUEST['ug_id_delete']);
		}
		echo $msg;
	}

	public function delete_quiz(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		if(count($_REQUEST)>0){
			$data = array(
				'quiz_isDelete' => '1',
				'quiz_modifiedby' => $sess['u_id'],
				'quiz_modifieddate' => date('Y-m-d H:i')
			);
			$this->db->where('qiz_id',$_REQUEST['qiz_id']);
			$this->db->update('LMS_QIZ',$data);

		        $fetch = $this->func_query->query_row('LMS_QIZ','','','','qiz_id="'.$_REQUEST['qiz_id'].'"');
		        $arr_update = array('cos_modifieddate'=>date('Y-m-d H:i:s'));
		        $this->db->where('cos_id',$fetch['cos_id']);
		        $this->db->update('LMS_COS',$arr_update);
			$msg = "2";
		}
		echo $msg;
	}

	public function delete_criteriascore(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
    	$this->load->model('Log_model', 'lg', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		if(count($_REQUEST)>0){
			$data = array(
				'qizlv_isDelete' => '1',
				'qizlv_modifiedby' => $sess['u_id'],
				'qizlv_modifieddate' => date('Y-m-d H:i')
			);
			$this->db->where('qizlv_id',$_REQUEST['qizlv_id']);
			$this->db->update('LMS_QIZ_LEVEL',$data);
          	$this->lg->record('course', 'Delete Qiz Criteria Score : '.$_REQUEST['qizlv_id'].' By '.$sess['fullname_th']);
			$msg = "2";
		}
		echo $msg;
	}

	public function delete_ques(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		if(count($_REQUEST)>0){
                $fetch_ques = $this->func_query->query_row('LMS_QUES','','','','ques_id="'.$_REQUEST['ques_id'].'"');
                $fetch_qiz = $this->func_query->query_row('LMS_QIZ','','','','qiz_id="'.$fetch_ques['qiz_id'].'"');
                if(count($fetch_qiz)>0){
                  $quiz_numofshown = intval($fetch_qiz['quiz_numofshown'])-1;
                  if($quiz_numofshown<0){
                    $quiz_numofshown = 0;
                  }
                  $dataupdate = array(
                      'quiz_numofshown' => $quiz_numofshown,
                      'quiz_modifiedby' => $sess['u_id'],
                      'quiz_modifieddate' => date('Y-m-d H:i')
                  );
                  $this->db->where('qiz_id',$fetch_ques['qiz_id']);
                  $this->db->update('LMS_QIZ',$dataupdate);
                }
			$data = array(
				'ques_isDelete' => '1',
				'ques_modifiedby' => $sess['u_id'],
				'ques_modifieddate' => date('Y-m-d H:i')
			);
			$this->db->where('ques_id',$_REQUEST['ques_id']);
			$this->db->update('LMS_QUES',$data);
		        $arr_update = array('cos_modifieddate'=>date('Y-m-d H:i:s'));
		        $this->db->where('cos_id',$fetch_qiz['cos_id']);
		        $this->db->update('LMS_COS',$arr_update);
			$msg = "2";
		}
		echo $msg;
	}

	public function delete_survey(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		if(count($_REQUEST)>0){
			$data = array(
				'sv_isDelete' => '1',
				'sv_modifiedby' => $sess['u_id'],
				'sv_modifieddate' => date('Y-m-d H:i')
			);
			$this->db->where('sv_id',$_REQUEST['sv_id']);
			$this->db->update('LMS_SURVEY',$data);

                $fetch = $this->func_query->query_row('LMS_SURVEY','','','','sv_id="'.$_REQUEST['sv_id'].'"');
		        $arr_update = array('cos_modifieddate'=>date('Y-m-d H:i:s'));
		        $this->db->where('cos_id',$fetch['cos_id']);
		        $this->db->update('LMS_COS',$arr_update);
			$msg = "2";
		}
		echo $msg;
	}

	public function delete_survey_detail(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		if(count($_REQUEST)>0){
			$data = array(
				'svde_isDelete' => '1',
				'svde_modifiedby' => $sess['u_id'],
				'svde_modifieddate' => date('Y-m-d H:i')
			);
			$this->db->where('svde_id',$_REQUEST['svde_id']);
			$this->db->update('LMS_SURVEY_DE',$data);
		        $fetch = $this->func_query->query_row('LMS_SURVEY','','','','LMS_SURVEY.sv_id in (select LMS_SURVEY_DE.sv_id from LMS_SURVEY_DE where LMS_SURVEY_DE.svde_id="'.$_REQUEST['svde_id'].'")');
		        $arr_update = array('cos_modifieddate'=>date('Y-m-d H:i:s'));
		        $this->db->where('cos_id',$fetch['cos_id']);
		        $this->db->update('LMS_COS',$arr_update);
			$msg = "2";
		}
		echo $msg;
	}

	public function delete_lesson(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Course_model', 'course', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		date_default_timezone_set("Asia/Bangkok");
		$sess = $this->session->userdata("user");
		if(count($_REQUEST)>0){

            $fetch_les = $this->func_query->query_row("LMS_LES",'','','','les_id = "'.$_REQUEST['les_id'].'"');
            if($fetch_les['les_type']=="2"){
              $path = $this->course->check_scorm($_REQUEST['les_id']);
              $newDir = ROOT_DIR."uploads/scorm/".$path;
                      function emptyDir($dir) {
                          if (is_dir($dir)) {
                              $scn = scandir($dir);
                              foreach ($scn as $files) {
                                  if ($files !== '.') {
                                      if ($files !== '..') {
                                          if (!is_dir($dir . '/' . $files)) {
                                              unlink($dir . '/' . $files);
                                          } else {
                                              emptyDir($dir . '/' . $files);
                                              rmdir($dir . '/' . $files);
                                          }
                                      }
                                  }
                              }
                          }
                      }
                      emptyDir($newDir);
                      rmdir($newDir);
                      $this->course->delete_data($_REQUEST['les_id'],'lessons_id','LMS_SCM');
            }
			$data = array(
				'les_isDelete' => '1',
				'les_modifiedby' => $sess['u_id'],
				'les_modifieddate' => date('Y-m-d H:i')
			);
			$this->db->where('les_id',$_REQUEST['les_id']);
			$this->db->update('LMS_LES',$data);

		        $arr_update = array('cos_modifieddate'=>date('Y-m-d H:i:s'));
		        $this->db->where('cos_id',$fetch_les['cos_id']);
		        $this->db->update('LMS_COS',$arr_update);
			$msg = "2";
		}
		echo $msg;
	}

	public function delete_user_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$data = array(
				'emp_isDelete' => '1',
			);
			$this->db->where('emp_id',$_REQUEST['emp_id_delete']);
			$this->db->update('LMS_EMP',$data);
			$datausp = array(
				'u_isDelete' => '1',
			);
			$this->db->where('emp_id',$_REQUEST['emp_id_delete']);
			$this->db->update('LMS_USP',$datausp);
			$msg = "2";
		}
		echo $msg;
	}

	public function update_company_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['com_id_update'],'LMS_COMPANY','com_id');
			$result['compe_montha_start'] = "";
			$result['compe_montha_end'] = "";
			$result['compe_monthb_start'] = "";
			$result['compe_monthb_end'] = "";
			$fetch_chk = $this->func_query->query_row('LMS_COMPANY_PERIOD','','','','compe_year="'.date('Y').'" and com_id="'.$_REQUEST['com_id_update'].'"');
			if(count($fetch_chk)>0){
				$result['compe_montha_start'] = $fetch_chk['compe_montha_start'];
				$result['compe_montha_end'] = $fetch_chk['compe_montha_end'];
				$result['compe_monthb_start'] = $fetch_chk['compe_monthb_start'];
				$result['compe_monthb_end'] = $fetch_chk['compe_monthb_end'];
			}
			echo json_encode($result);
		}
	}

	public function update_company_score_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['coms_id'],'LMS_COMPANY_SCORE','coms_id');
			echo json_encode($result);
		}
	}

	public function update_division_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['div_id'],'LMS_DIVISION','div_id');
			echo json_encode($result);
		}
	}

	public function update_position_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['posi_id'],'LMS_POSITION','posi_id');
			echo json_encode($result);
		}
	}

	public function update_level_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['lv_id'],'LMS_LEVEL','lv_id');
			echo json_encode($result);
		}
	}

	public function update_store_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['st_id'],'LMS_STORE','st_id');
			echo json_encode($result);
		}
	}

	public function update_group_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['group_id'],'LMS_GROUP','group_id');
			echo json_encode($result);
		}
	}

	public function update_conmsg_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['conmsg_id'],'LMS_CONFIRMMSG','conmsg_id');
			echo json_encode($result);
		}
	}

	public function update_workgroup_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['wg_id'],'LMS_WKG','wg_id');
			echo json_encode($result);
		}
	}

	public function update_coursegroup_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['cg_id_update'],'LMS_COG','cg_id');
			echo json_encode($result);
		}
	}

	public function update_department_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['dep_id_update'],'LMS_DEPART','dep_id');
			echo json_encode($result);
		}
	}

	public function update_section_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['section_id'],'LMS_SECTION','section_id');
			echo json_encode($result);
		}
	}

	public function update_area_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['salearea_id'],'LMS_AREA','salearea_id');
			echo json_encode($result);
		}
	}

	public function rechk_headcol(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_chkheadcol($_REQUEST['ug_id']);
			echo json_encode($result);
		}
	}

	public function rechk_headcol_user(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_chkheadcol_user($_REQUEST['u_id']);
			echo json_encode($result);
		}
	}

	public function update_groupuser_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['ug_id_update'],'LMS_USP_GP','ug_id');
			echo json_encode($result);
		}
	}

	public function update_recommended_sites_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['web_id'],'LMS_WEB','web_id');
			echo json_encode($result);
		}
	}

	public function update_user_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['u_id_update'],'LMS_USP','u_id');
			$result['expiredate'] = date('Y-m-d',strtotime($result['expiredate']));


		    if($result['inactivedate']!="0000-00-00"){
		        $result['inactivedate_var'] = date('Y-m-d',strtotime($result['inactivedate']));
		        $result['inactivedate'] = date('d/m/Y',strtotime($result['inactivedate']));
		    }else{
		        $result['inactivedate'] = "";
		        $result['inactivedate_var'] = "";
		    }

		    if($result['u_firstdate']!="0000-00-00 00:00:00"){
		        $result['u_firstdate_var'] = date('Y-m-d',strtotime($result['u_firstdate']));
		        $result['u_firstdate'] = date('d/m/Y',strtotime($result['u_firstdate']));
		    }else{
		        $result['u_firstdate'] = "";
		        $result['u_firstdate_var'] = "";
		    }
			echo json_encode($result);
		}
	}

	public function update_position_detail(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['posi_id'],'LMS_POSITION','posi_id');
			echo json_encode($result);
		}
	}

	public function update_qrcode_data(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		if(count($_REQUEST)>0){
			$result = $this->manage->query_data_onupdate($_REQUEST['qr_id_update'],'LMS_QRCODE','qr_id');
			echo json_encode($result);
		}
	}

	public function recheckdivision(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$com_id = $this->input->post('com_id');
		$div_id = $this->input->post('div_id');
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		$fetch_select = $this->func_query->query_result('LMS_DIVISION','','','','com_id="'.$com_id.'" and div_isDelete = "0" and div_status="1"');
		if(count($fetch_select)>0){
			echo "<optgroup label='".label('svplease')."'>";
			foreach ($fetch_select as $key => $value) {
				$select_val = "";
				if($value['div_id']==$div_id){
					$select_val = "selected";
				}
				if($lang=="thai"){
					echo "<option value='".$value['div_id']."' ".$select_val.">".'['.$value['div_code'].'] '.$value['div_name_th']."</option>";
				}else{
					echo "<option value='".$value['div_id']."' ".$select_val.">".'['.$value['div_code'].'] '.$value['div_name_en']."</option>";
				}
			}
			$this->manage->closeDB();
			echo "</optgroup>";
		}else{
			echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
		}
	}	

	public function recheckgroup(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$group_id = $this->input->post('group_id');
		$div_id = $this->input->post('div_id');
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		$fetch_select = $this->func_query->query_result('LMS_GROUP','','','','div_id="'.$div_id.'" and group_isDelete = "0" and group_status="1"');
		if(count($fetch_select)>0){
			echo "<optgroup label='".label('svplease')."'>";
			foreach ($fetch_select as $key => $value) {
				$select_val = "";
				if($value['group_id']==$group_id){
					$select_val = "selected";
				}
				if($lang=="thai"){
					echo "<option value='".$value['group_id']."' ".$select_val.">".'['.$value['group_code'].'] '.$value['group_name_th']."</option>";
				}else{
					echo "<option value='".$value['group_id']."' ".$select_val.">".'['.$value['group_code'].'] '.$value['group_name_en']."</option>";
				}
			}
			$this->manage->closeDB();
			echo "</optgroup>";
		}else{
			echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
		}
	}	

	public function recheckdepartment(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$dep_id = $this->input->post('dep_id');
		$group_id = $this->input->post('group_id');
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		$fetch_select = $this->func_query->query_result('LMS_DEPART','','','','group_id="'.$group_id.'" and dep_isDelete = "0" and dep_status="1"');
		if(count($fetch_select)>0){
			echo "<optgroup label='".label('svplease')."'>";
			foreach ($fetch_select as $key => $value) {
				$select_val = "";
				if($value['dep_id']==$dep_id){
					$select_val = "selected";
				}
				if($lang=="thai"){
					echo "<option value='".$value['dep_id']."' ".$select_val.">".'['.$value['dep_shot'].'] '.$value['dep_name_th']."</option>";
				}else{
					echo "<option value='".$value['dep_id']."' ".$select_val.">".'['.$value['dep_shot'].'] '.$value['dep_name_en']."</option>";
				}
			}
			$this->manage->closeDB();
			echo "</optgroup>";
		}else{
			echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
		}
	}	

	public function rechecksection(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$dep_id = $this->input->post('dep_id');
		$section_id = $this->input->post('section_id');
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		$fetch_select = $this->func_query->query_result('LMS_SECTION','','','','dep_id="'.$dep_id.'" and section_isDelete = "0" and section_status="1"');
		if(count($fetch_select)>0){
			echo "<optgroup label='".label('svplease')."'>";
			foreach ($fetch_select as $key => $value) {
				$select_val = "";
				if($value['section_id']==$section_id){
					$select_val = "selected";
				}
				if($lang=="thai"){
					echo "<option value='".$value['section_id']."' ".$select_val.">".'['.$value['section_shot'].'] '.$value['section_name_th']."</option>";
				}else{
					echo "<option value='".$value['section_id']."' ".$select_val.">".'['.$value['section_shot'].'] '.$value['section_name_en']."</option>";
				}
			}
			$this->manage->closeDB();
			echo "</optgroup>";
		}else{
			echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
		}
	}	

	public function rechecksalearea(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$salearea_id = $this->input->post('salearea_id');
		$section_id = $this->input->post('section_id');
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		$fetch_select = $this->func_query->query_result('LMS_AREA','','','','section_id="'.$section_id.'" and salearea_isDelete = "0" and salearea_status="1"');
		if(count($fetch_select)>0){
			echo "<optgroup label='".label('svplease')."'>";
			foreach ($fetch_select as $key => $value) {
				$select_val = "";
				if($value['salearea_id']==$salearea_id){
					$select_val = "selected";
				}
				if($lang=="thai"){
					echo "<option value='".$value['salearea_id']."' ".$select_val.">".'['.$value['salearea_shot'].'] '.$value['salearea_name_th']."</option>";
				}else{
					echo "<option value='".$value['salearea_id']."' ".$select_val.">".'['.$value['salearea_shot'].'] '.$value['salearea_name_en']."</option>";
				}
			}
			$this->manage->closeDB();
			echo "</optgroup>";
		}else{
			echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
		}
	}	

	public function recheckposition(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$posi_id = $this->input->post('posi_id');
		$com_id = $this->input->post('com_id');
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		$fetch_select = $this->func_query->query_result('LMS_POSITION','','','','com_id="'.$com_id.'" and posi_isDelete = "0" and posi_status="1"');
		if(count($fetch_select)>0){
			echo "<optgroup label='".label('svplease')."'>";
			foreach ($fetch_select as $key => $value) {
				$select_val = "";
				if($value['posi_id']==$posi_id){
					$select_val = "selected";
				}
				if($lang=="thai"){
					echo "<option value='".$value['posi_id']."' ".$select_val.">".'['.$value['posi_shot'].'] '.$value['posi_name_th']."</option>";
				}else{
					echo "<option value='".$value['posi_id']."' ".$select_val.">".'['.$value['posi_shot'].'] '.$value['posi_name_en']."</option>";
				}
			}
			$this->manage->closeDB();
			echo "</optgroup>";
		}else{
			echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
		}
	}	

	public function rechecklevel(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$lv_id = $this->input->post('lv_id');
		$com_id = $this->input->post('com_id');
		$posi_id = $this->input->post('posi_id');
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		$where = '';
		if($posi_id!=""){
			$where = ' and lv_id in (select LMS_POSITION_LEVEL.lv_id from LMS_POSITION_LEVEL where posi_id = "'.$posi_id.'" and posilv_isDelete = "0")';
		}
		$fetch_select = $this->func_query->query_result('LMS_LEVEL','','','','com_id="'.$com_id.'" and lv_isDelete = "0" and lv_status="1"'.$where);
		if(count($fetch_select)>0){
			echo "<optgroup label='".label('svplease')."'>";
			foreach ($fetch_select as $key => $value) {
				$select_val = "";
				if($value['lv_id']==$lv_id){
					$select_val = "selected";
				}
				if($lang=="thai"){
					echo "<option value='".$value['lv_id']."' ".$select_val.">".$value['lv_name_th']."</option>";
				}else{
					echo "<option value='".$value['lv_id']."' ".$select_val.">".$value['lv_name_en']."</option>";
				}
			}
			$this->manage->closeDB();
			echo "</optgroup>";
		}else{
			echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
		}
	}	

	public function recheckhead(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$emp_id = $this->input->post('emp_id');
		$com_id = $this->input->post('com_id');
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		$fetch_select = $this->func_query->query_result('LMS_EMP','','','','com_id="'.$com_id.'" and emp_isDelete = "0" and status="1"');
		if(count($fetch_select)>0){
			echo "<optgroup label='".label('svplease')."'>";
			foreach ($fetch_select as $key => $value) {
				$select_val = "";
				if($value['emp_id']==$emp_id){
					$select_val = "selected";
				}
				if($lang=="thai"){
					echo "<option value='".$value['emp_id']."' ".$select_val.">".$value['fullname_th']."</option>";
				}else{
					echo "<option value='".$value['emp_id']."' ".$select_val.">".$value['fullname_en']."</option>";
				}
			}
			$this->manage->closeDB();
			echo "</optgroup>";
		}else{
			echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
		}
	}	

	public function recheckstore(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$st_id = $this->input->post('st_id');
		$com_id = $this->input->post('com_id');
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		$fetch_select = $this->func_query->query_result('LMS_STORE','','','','com_id="'.$com_id.'" and st_isDelete = "0" and st_status="1"');
		if(count($fetch_select)>0){
			echo "<optgroup label='".label('svplease')."'>";
			echo "<option value='' ".$select_val.">".label('Not_specified')."</option>";
			foreach ($fetch_select as $key => $value) {
				$select_val = "";
				if($value['st_id']==$st_id){
					$select_val = "selected";
				}
				if($lang=="thai"){
					echo "<option value='".$value['st_id']."' ".$select_val.">"."[".$value['st_code']."] ".$value['st_name_th']."</option>";
				}else{
					echo "<option value='".$value['st_id']."' ".$select_val.">"."[".$value['st_code']."] ".$value['st_name_en']."</option>";
				}
			}
			$this->manage->closeDB();
			echo "</optgroup>";
		}else{
			echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
		}
	}	

	public function recheckcompany(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$com_id = $this->input->post('com_id');
		$dep_id = $this->input->post('dep_id');
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$org_select = $this->manage->checkdepartment($com_id);
		if(count($org_select)>0){
			echo "<optgroup label='".label('svplease')."'>";
			foreach ($org_select as $key) {
				$select_val = "";
				if($key['dep_id']==$dep_id){
					$select_val = "selected";
				}
				if($lang=="thai"){
					echo "<option value='".$key['dep_id']."' ".$select_val.">".$key['dep_name_th']."</option>";
				}else{
					echo "<option value='".$key['dep_id']."' ".$select_val.">".$key['dep_name_en']."</option>";
				}
			}
			$this->manage->closeDB();
			echo "</optgroup>";
		}else{
			echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
		}
	}	

	public function rechk_funcdashboard(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$ug_id = isset($_REQUEST['ug_id'])?$_REQUEST['ug_id']:"";
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->manage->loadDB();
		$fetch_loop = $this->func_query->query_result('LMS_FUNC_DASHBOARD','','','','');
		if(count($fetch_loop)>0){
			echo "<optgroup label='".label('svplease')."'>";
			$numloop = 1;
			foreach ($fetch_loop as $key) {
				$fetch_chk = $this->func_query->query_row('LMS_ROLE_FD','','','','ug_id="'.$ug_id.'" and fd_id="'.$key['fd_id'].'"');
				$select_val = "";
				if(count($fetch_chk)>0){
					$select_val = "selected";
				}
				$numloop++;
				$fd_name = $lang=="thai"?$key['fd_name_th']:$key['fd_name_eng'];
				echo "<option value='".$key['fd_id']."' ".$select_val.">".$fd_name."</option>";
			}
			$this->func_query->closeDB();
			echo "</optgroup>";
		}else{
			echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
		}
	}	

	public function recheckusergroup(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$com_id = $this->input->post('com_id');
		$ug_id = $this->input->post('ug_id');
		$user = $this->session->userdata('user');
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$org_select = $this->manage->checkusergroup($com_id);
		if(count($org_select)>0){
			echo "<optgroup label='".label('svplease')."'>";
			$num_loop = 1;
			foreach ($org_select as $key) {
				if($user['com_admin']=="com_central"){
					if($user['ug_id']>1){
						if($key['ug_id']!="1"){
							$select_val = "";
							if($key['ug_id']==$ug_id){
								$select_val = "selected";
							}else{
								if($num_loop==1){
									$select_val = "selected";
								}
							}

							if($lang=="thai"){
								echo "<option value='".$key['ug_id']."' ".$select_val.">".$key['ug_name_th']."</option>";
							}else{
								echo "<option value='".$key['ug_id']."' ".$select_val.">".$key['ug_name_en']."</option>";
							}
						}
					}else{
						$select_val = "";
						if($key['ug_id']==$ug_id){
							$select_val = "selected";
						}else{
							if($num_loop==1){
								$select_val = "selected";
							}
						}

						if($lang=="thai"){
							echo "<option value='".$key['ug_id']."' ".$select_val.">".$key['ug_name_th']."</option>";
						}else{
							echo "<option value='".$key['ug_id']."' ".$select_val.">".$key['ug_name_en']."</option>";
						}
					}	
				}else{
					$select_val = "";
					if($key['ug_id']==$ug_id){
						$select_val = "selected";
					}else{
						if($num_loop==1){
							$select_val = "selected";
						}
					}

					if($lang=="thai"){
						echo "<option value='".$key['ug_id']."' ".$select_val.">".$key['ug_name_th']."</option>";
					}else{
						echo "<option value='".$key['ug_id']."' ".$select_val.">".$key['ug_name_en']."</option>";
					}
				}
				$num_loop++;
			}
			$this->manage->closeDB();
			echo "</optgroup>";
		}else{
			echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
		}
	}

	public function recheckdepartmentbk(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$dep_id = $this->input->post('dep_id');
		$posi_id = $this->input->post('posi_id');
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$posi_select = $this->manage->checkposition($dep_id);
		if(count($posi_select)>0){
			echo "<optgroup label='".label('svplease')."'>";
			foreach ($posi_select as $key) {
				$select_val = "";
				if($key['posi_id']==$posi_id){
					$select_val = "selected";
				}
				if($lang=="thai"){
					echo "<option value='".$key['posi_id']."' ".$select_val.">".$key['posi_name_th']."</option>";
				}else{
					echo "<option value='".$key['posi_id']."' ".$select_val.">".$key['posi_name_en']."</option>";
				}
			}
			$this->manage->closeDB();
			echo "</optgroup>";
		}else{
			echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
		}
	}


	public function manageLevel() {
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);

		$arr['lang'] = $lang;
		$arr['page'] = "manage/manageLevel";

		$this->load->model('User_model', 'login', FALSE);
		if($this->login->checkSession($arr['page'])){
			$user = $this->session->userdata('user');
			$arr['emp_c'] = $user['emp_c'];
			$arr['role'] = $user['role'];

			if(!in_array($arr['role'], array("superadmin","admintis", "admin"))) {
				redirect(base_url().'dashboard', 'refresh');
			}

			if(isset($_POST['edit'])) {
				$this->load->model('Manage_model', 'manage', FALSE);
				$this->manage->loadDB();
				$arr['emp'] = $this->manage->getEmp($_POST['edit']);
				$arr['emp']['emp_name'] = $arr['emp']['prefix'].$arr['emp']['fname'].' '.$arr['emp']['lname'];
				$lead_name = $this->manage->getEmp($arr['emp']['lead'], $lang);
				$arr['emp']['lead_name'] = $lead_name['prefix'].$lead_name['fname'].' '.$lead_name['lname'];
				$this->manage->closeDB();

				$this->load->model('Footer_model', 'foot', FALSE);
				$this->foot->loadDB();
				$arr['foote'] = $this->foot->getfooter();
				$this->foot->closeDB();

				$this->load->view('frontend/managelevel', $arr);
			} else {
				$this->load->model('Manage_model', 'manage', FALSE);
				$this->manage->loadDB();
				$arr['users'] = $this->manage->getEmps($lang);
				$this->manage->closeDB();

				$this->load->model('Footer_model', 'foot', FALSE);
				$this->foot->loadDB();
				$arr['foote'] = $this->foot->getfooter();
				$this->foot->closeDB();

				$this->load->view('frontend/manage', $arr);
			}
		}
	}


	public function editPass() {
		if(isset($_POST['cancel'])) {
			redirect(base_url().'manage', 'refresh');
		}

		$user = $this->security->xss_clean($_POST['done']);
		$pass = $this->security->xss_clean($_POST['pass']);

		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$pass = hash('sha256', $pass);
		$this->manage->editPass($user, $pass);
		$this->load->model('Log_model', 'lg', FALSE);
		$this->lg->record('manage', 'change '.$user.'\'s password.');
		$this->manage->closeDB();

		redirect(base_url().'manage', 'refresh');
	}

	public function editLevel() {
		if(isset($_POST['cancel'])) {
			redirect(base_url().'manage/manageLevel', 'refresh');
		}

		$emp_c = $this->security->xss_clean($_POST['emp']);
		$lead = $this->security->xss_clean($_POST['lead']);
		$level = $this->security->xss_clean($_POST['level']);

		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$this->manage->editLevel($emp_c, $lead, $level);
		$this->load->model('Log_model', 'lg', FALSE);
		$this->lg->record('manage', 'edit '.$emp_c.'\'s leader to '.$lead.' and level to '.$level.'.');
		$this->manage->closeDB();

		redirect(base_url().'manage', 'refresh');
	}

	public function checkLead() {
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$emp_c = $_POST['emp'];
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$arr['text'] = $this->manage->checkLead($emp_c, $lang);
		$this->manage->closeDB();
		echo json_encode($arr);
	}

	public function checkEmpC() {
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$emp_c = $_POST['emp'];
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$arr['text'] = $this->manage->checkEmpC($emp_c, $lang);
		$this->manage->closeDB();
		echo json_encode($arr);
	}

	public function checkUser() {
		$useri = $_POST['user'];
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->manage->loadDB();
		$arr['text'] = $this->manage->checkUser($useri);
		$this->manage->closeDB();
		echo json_encode($arr);
	}

}
