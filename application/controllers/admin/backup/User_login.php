<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
* User_Login Controller Class
* =====================
* @Filename: User_Login.php
* @Location: ./application/controllers/backoffice/User_Login.php
* @Description : User_Login is a PHP class of backoffice for manage user login.
*
* @Creator Wutikorn Jitpruegsa <wutikorn@digitalnex.com>
*/
class User_Login extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}
/**
* Index Page for this controller.
* ================================
* @Description : Load view file ./application/view/backoffice/user_login.php to display
*/
	public function index()
	{
		$this->load->view('admin/user_login');
		/*$ip = $_SERVER['REMOTE_ADDR'];
		//echo $ip ;
		if( $ip == "180.183.250.211" || $ip == "198.143.39.97" ){
			$this->load->view('backoffice/user_login');
		}else{
			header('Location: '.base_url() );
		}*/
	}

/**
* Logout from backoffice.
* ================================
* @Description : return json data for login correct or not correct.
* @param : username and password
* @Check : username and password in database
* @return : true,false and message when try to login
*/
	public function login()
	{
		$input = $this->input->post();

		$username = $this->db->escape_str($input['USR']);
		$password = $this->db->escape_str($input['PSW']);

		$result = array();

		if(isset($username) && isset($password)){

			$this->db->select('id, count(*) as total');
			$query = $this->db->get_where(' tb_user',array('username' => $username,'password' => $password), 1 );

			$data = $query->result_array();

			$total = $data[0]['total'];
			$user_id = $data[0]['id'];

			if( $total > 0 ){

				$this->session->set_userdata(array('is_login' => true));
				$this->session->set_userdata(array('user_id' => $user_id));
				$this->session->set_userdata(array('user_name' => $username ));
				$result['rs'] = true;//array('rs' => true);

			}else{
				$result = array('rs' => false, 'msg' => "Login incorrect !");
			}

		}else{
			$result = array('rs' => false, 'msg' => "Wrong Solution Login");
		}

		echo json_encode($result);
	}

/**
* Logout from backoffice.
* ================================
* @Description : return json data when logout.
* @param : username and password
* @Check : username and password in database
* @return : true when logout success
*/
	public function logout()
	{
		$arr_result = array();
		$this->session->unset_userdata('is_login');
		$this->session->unset_userdata('user_id');
		$this->session->unset_userdata('user_name');
		$arr_result['rs'] = true;

		echo json_encode($arr_result);
	}

}

/* End of file User_login.php */
