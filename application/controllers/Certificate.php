<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Certificate extends CI_Controller {
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

	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));  
	}

	public function createfile(){
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
		$user = $this->session->userdata('user');
		$this->lang->load($lang,$lang);
		$this->load->model('Certificate_model', 'cartificate', TRUE);
		$this->cartificate->loadDB();
		$query = $this->cartificate->createfile($user,$_REQUEST['cos_id']);
      	echo json_encode($query);
	}

	public function certificateall() {
		$arr['page'] = "certificate/certificateall";

		$this->load->model('User_model', 'login', TRUE);
		!$this->login->checkSession($arr['page']) ? : $arr['page'];
		$lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);

		$arr['lang'] = $lang;
		$this->load->model('Certificate_model', 'certificate', TRUE);
		$this->load->model('Log_model', 'lg', FALSE);
		$this->load->model('Footer_model', 'foot', FALSE);
		$this->load->model('Manage_model', 'manage', FALSE);
        $this->manage->loadDB();
		$this->foot->loadDB();
		$this->lg->loadDB();
		$this->certificate->loadDB();
		$this->login->loadDB();
		if($this->login->checkSession($arr['page'])){
			$user = $this->session->userdata('user');
			$arr['emp_c'] = $user['emp_c'];
			$arr['com_admin'] = $user['com_admin'];
			$arr['com_id'] = $user['com_id'];
			$arr['user'] = $user;
			if($lang=="thai"){
				$arr['com_name'] = $user['com_name_th'];
			}else{
				$arr['com_name'] = $user['com_name_eng'];
			}
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
			//Record Log activity
			$this->lg->record('Certificate', 'enter create certificate');

			$arr['foote'] = $this->foot->getfooter();
			$this->load->view('frontend/certificateall', $arr );
		}
	}


	public function generate()
	{
		$image_data = array();
		$document_data = array();
			if(isset($_FILES['cert_image'])&&$_FILES['cert_image']!=""){
				if( isset( $_FILES['cert_image']) ){
					$imageSourcePath = $_FILES['cert_image']['tmp_name'];
					$imageTargetPath = ROOT_DIR."uploads/temp/certificate_img.jpg";
					if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
					}
				}
			}
			if(isset($_FILES['excel'])&&$_FILES['excel']!=""){
				if( isset( $_FILES['excel']) ){
					$imageSourcePath = $_FILES['excel']['tmp_name'];
					$imageTargetPath = ROOT_DIR."uploads/temp/certificate_excel.xlsx";
					if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
					}
				}
			}
		/*// load library only once
		$this->load->library('upload');

		// image configuration
		$image_config['upload_path'] = '../uploads/temp/';
		$image_config['allowed_types'] = 'jpg';
		$image_config['overwrite'] = TRUE;
		$image_config['file_name'] = 'certificate_img';

		$this->upload->initialize($image_config);

		// process image upload
		$this->upload->do_upload('cert_image');

		$image_data = $this->upload->data();

		// document configuration
		$document_config['upload_path'] = '../uploads/temp/';
		$document_config['allowed_types'] = 'xlsx';		
		$document_config['overwrite'] = TRUE;
		$document_config['file_name'] = 'certificate_excel';

		$this->upload->initialize($document_config);
		   
		// process excel upload
		$this->upload->do_upload('excel');

		$document_data = $this->upload->data();*/

		if (empty($_FILES['cert_image']['name'])) {
			$this->load->view('frontend/certificateViewDefault');
		}else{
			$this->load->view('frontend/certificateViewUpload');	
		}	
	}
/*
	public function create()
	{
		$lang = $this->session->userdata("lang") == null ? "thailand" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);

		$arr['page'] = 'certificate/create';

		$this->load->model('Lang_model', 'langM', TRUE);
		$this->load->model('Course_model', 'course', TRUE);
		$this->load->model('User_model', 'user', TRUE);
		$this->load->model('Footer_model', 'foot', FALSE);

		$this->langM->loadDB();
		$this->course->loadDB();
		$this->user->loadDB();
		$this->foot->loadDB();

		!$this->user->checkSession($arr['page']) ? : $arr['page'];
		$user = $this->session->userdata("user");
		in_array($user['role'], array("superadmin","admintis", "admin", "manager")) ? : redirect(base_url().'dashboard') ;

		$arr['lang'] = $lang;

		$arr['langs'] = $this->langM->getAllLangs();
		$arr['lang_tab'] = $lang;
		$arr['emp_c'] = $user['emp_c'];
		$arr['role'] = $user['role'];
		$arr['ccode'] = $this->course->getCode();
		$arr['allplv'] = array();
		$arr['isGrading'] = array();
		$arr['type'] = $this->user->getAllPos($lang);
		$arr['group'] = $this->course->getAllGup();
		$arr['courses'] = $this->course->getAllCos($lang, $arr['role'],TRUE);
		$arr['actionNormal'] = 'course/normalCreated';
		$arr['actionScorm'] = 'course/scormCreated';
		$arr['actionNormalCreate'] = 'course/normalCreated';
		$arr['actionScormCreate'] = 'course/scormCreated';		
		$arr['foote'] = $this->foot->getfooter();

		$this->load->view('frontend/certificateCreate', $arr );
	}
*/
}
