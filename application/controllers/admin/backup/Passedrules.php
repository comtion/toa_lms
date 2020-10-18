<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 /**
 * Passedrules Controller Class
 * =====================
 * @Filename: Passedrules.php
 * @Location: ./application/controllers/backoffice/Passedrules.php
 * @Description : Passedrules is a PHP class of backoffice for load user passed rules.
 *
 * @Creator Wutikorn Jitpruegsa <wutikorn@digitalnex.com>
 */
class Passedrules extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->session->userdata('is_login')){
			redirect(base_url().'backoffice/user_login', 'refresh');
		}
	}


	/**
	 * Index Page for this controller.
	 * ================================
	 * @Description : Load view file ./application/view/backoffice/passed_rules.php to display
	 */
	public function index()
	{
		$data = array();
		//Query for get total pass
		$query = "select fb_id,fb_name,image,c_date from tb_pass order by c_date desc";
		$result = $this->db->query( $query );
		$data['pass_list'] = $result->result_array();
		
		//Query for get total pass
		$query = "select image from tb_winner order by c_date desc";
		$result = $this->db->query( $query );
		$data['winner_list'] = $result->result_array();
	
		
		$this->load->view( 'backoffice/passed_rules',$data );
	}

}

/* End of file Passedrules.php */