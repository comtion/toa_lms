<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 /**
 * Report Controller Class
 * =====================
 * @Filename: Report.php
 * @Location: ./application/controllers/backoffice/Report.php
 * @Description : Report is a PHP class of backoffice for report view.
 *
 * @Creator Wutikorn Jitpruegsa <wutikorn@digitalnex.com>
 */
class Report extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->session->userdata('is_login')){
			redirect(base_url().'backoffice/user_login', 'refresh');
		}
	}

/**
* Index Page for this controller.
* ================================
* @Description : Load view file ./application/view/backoffice/report.php to display with data below.
*			   : Load total player data from database
*			   : Load total play data from database
*			   : Load total share data from database
*			   : Load total image data from database
*			   : Load all record data from database
*			   : Load all player passed rules data from database
*/
	public function index()
	{
		$data = array();
		//Query for get total player
		$query = "select count(*) as total_player from ( select distinct count(fb_id) from tb_customer group by fb_id ) player";
		$result = $this->db->query( $query );
		$data['total_player'] = $result->result_array();
		
		//Query for get total play
		$query = "select count(*) as total_play from tb_play";
		$result = $this->db->query( $query );
		$data['total_play'] = $result->result_array();
		
		//Query for get total share
		$query = "select count(*) as total_share from tb_share";
		$result = $this->db->query( $query );
		$data['total_share'] = $result->result_array();
		
		//Query for get total image
		$query = "select count(*) as total_image from tb_image";
		$result = $this->db->query( $query );
		$data['total_image'] = $result->result_array();
		
		//Query for get list of record
		$query = "select cus.fb_id, cus.fb_name, cus.fb_email, cus.c_date , img.image, img.c_date as img_date";
		$query .= " from tb_customer cus inner join tb_image img";
		$query .= " on cus.fb_id = img.fb_id and cus.keygen = img.keygen ";
		$query .= "order by cus.c_date desc";
		$result = $this->db->query( $query );
		$data['list_report'] = $result->result_array();
		
		//Query for get total pass
		$query = "select image from tb_pass order by c_date desc";
		$result = $this->db->query( $query );
		$data['pass_list'] = $result->result_array();
		
		
		$this->load->view( 'backoffice/report',$data );
	}
	
/**
* Insert passed rules.
* ================================
* @Description : Insert passed rules to database and return json data when success or not success.
* @param : fb_id, fb_name, image
* @return : true,false and message when try to insert
*/	
	public function addPassed(){
		
		$input = $this->input->post();
		$arr_result = array();
		
		$this->db->insert( 'tb_pass' , array(	'fb_id' => $input['fb_id'], 
												'fb_name' => $input['fb_name'],
												'image' => $input['image'] ));
		
		if($this->db->affected_rows() > 0){
			$arr_result['rs'] = true;
		}else{
			$arr_result['rs'] = false;
			$arr_result['msg'] = 'Cannot insert play';
		}
		

		echo json_encode($arr_result);
		
	}
/**
* Delete passed rules record.
* ================================
* @Description : Delete passed rules from database and return json data when success or not success.
* @param : image
* @return : true,false and message when try to delete
*/	

	public function deletePassed(){
		
		$input = $this->input->post();
		$arr_result = array();
		
		$this->db->where('image',$input['image']); 
  		$this->db->delete('tb_pass');
		
		if($this->db->affected_rows() > 0){
			$arr_result['rs'] = true;
		}else{
			$arr_result['rs'] = false;
			$arr_result['msg'] = 'Cannot insert play';
		}
		

		echo json_encode($arr_result);
		
	}
	

/**
* Insert winner.
* ================================
* @Description : addWinner is a php function for insert customer passed rules to database and return json data when success or not success.
* @param : fb_id, fb_name, image
* @return : true,false and message when try to insert
*/	
	public function addWinner(){
		
		$input = $this->input->post();
		$arr_result = array();
		
		$this->db->insert( 'tb_winner' , array(	'fb_id' => $input['fb_id'], 
												'fb_name' => $input['fb_name'],
												'image' => $input['image'] ));
		
		if($this->db->affected_rows() > 0){
			$arr_result['rs'] = true;
		}else{
			$arr_result['rs'] = false;
			$arr_result['msg'] = 'Cannot insert play';
		}
		

		echo json_encode($arr_result);
		
	}
/**
* Delete winner.
* ================================
* @Description : deleteWinner is a php function for delete winner from database and return json data when success or not success.
* @param : fb_id, fb_name, image
* @return : true,false and message when try to insert
*/		
	public function deleteWinner(){
		
		$input = $this->input->post();
		$arr_result = array();
		
		$this->db->where('image',$input['image']); 
  		$this->db->delete('tb_winner');
		
		if($this->db->affected_rows() > 0){
			$arr_result['rs'] = true;
		}else{
			$arr_result['rs'] = false;
			$arr_result['msg'] = 'Cannot insert play';
		}
		

		echo json_encode($arr_result);
		
	}

}

/* End of file Report.php */