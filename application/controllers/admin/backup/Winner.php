<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 /**
 * Winner Controller Class
 * =====================
 * @Filename: Winner.php
 * @Location: ./application/controllers/backoffice/Winner.php
 * @Description : Winner is a PHP class of backoffice for load winner data.
 *
 * @Creator Wutikorn Jitpruegsa <wutikorn@digitalnex.com>
 */
class Winner extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->session->userdata('is_login')){
			redirect(base_url().'backoffice/user_login', 'refresh');
		}
	}


	/**
	 * Index Page for this controller.
	 * ================================
	 * @Description : Load view file ./application/view/backoffice/winner.php to display
	 */
	public function index()
	{
		$data = array();
		
		//Query for get total pass
		$query = "select fb_id,fb_name,image,c_date from tb_winner order by c_date desc";
		$result = $this->db->query( $query );
		$data['winner_list'] = $result->result_array();
	
		
		$this->load->view( 'backoffice/winner',$data );
	}

}

/* End of file Winner.php */