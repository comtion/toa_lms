<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 /**
 * Password Controller Class
 * =====================
 * @Filename: Week.php
 * @Location: ./application/controllers/backoffice/Week.php
 * @Description : Week is a PHP class of backoffice for manage announcement week.
 *
 * @Creator Wutikorn Jitpruegsa <wutikorn@digitalnex.com>
 */
class Week extends CI_Controller {

	public function __construct() {
		parent::__construct();
		if(!$this->session->userdata('is_login')){
			redirect(base_url().'backoffice/user_login', 'refresh');
		}
	}

/**
* Index Page for this controller.
* ================================
* @Description : Load view file ./application/view/backoffice/user_login.php to display
*/
	public function index()
	{
		$data = array();
		//Query for get total pass
		$query = "select id,week,date_from,date_to,c_by,c_date from tb_week ";
		$result = $this->db->query( $query );
		$data['week_list'] = $result->result_array();
		
		$this->load->view( 'backoffice/week',$data );
	}

/**
* Insert week record.
* ================================
* @Description : return json data when success  or not success.
* @param : week, date_from, date_to
* @return : true,false and message when try to insert
*/	
	public function addWeek(){
		
		$input = $this->input->post();
		$arr_result = array();
		
		$this->db->insert( 'tb_week' , array(	'week' => $input['week'], 
												'date_from' => $input['date_from'],
												'date_to' => $input['date_to'] ,
												'c_by' => $this->session->userdata('user_id')
												));
		
		if($this->db->affected_rows() > 0){
			$arr_result['rs'] = true;
		}else{
			$arr_result['rs'] = false;
			$arr_result['msg'] = 'Cannot insert week';
		}
		

		echo json_encode($arr_result);
		
	}
	
/**
* Update week record.
* ================================
* @Description : return json data when success  or not success.
* @param : id,week, date_from, date_to
* @Check : week id in database
* @return : true,false and message when try to update
*/			
	public function updateWeek(){
		
		$input = $this->input->post();
		$result = array();
		date_default_timezone_set("Asia/Bangkok");
		$today = getdate();
		
		$u_date = $today['year'].$today['mon'].$today['mday'].' '.$today['hours'].$today['minutes'].$today['seconds'];
		
		$this->db->where("id", $input['id']);
		$query = $this->db->get( "tb_week" );
		if ($query->num_rows() > 0){
			$this->db->update( "tb_week" , array( "week"=> $input['week'] ,
												  "date_from"=> $input['date_from'],
												  "date_to"=> $input['date_to'],
												  "u_date"=> $u_date,
												  "u_by"=> $this->session->userdata('user_id') ), 
										  array('id' => $input['id']));
			if($this->db->affected_rows() > 0){
				
				$result['rs'] = true;
				
			}else{
				$result['rs'] = false;
				$result['msg'] = 'Cannot Update Week';
			}
		}else{
			$result['rs'] = false;
			$result['msg'] = 'Not Found Week ID';
		}
		
		echo json_encode($result);
	}
	
/**
* Delete week record.
* ================================
* @Description : return json data when success  or not success.
* @param : id
* @Check : week id in database
* @return : true,false and message when try to delete
*/			
	public function deleteWeek(){
		
		$input = $this->input->post();
		$arr_result = array();
		
		$this->db->where('id',$input['id']); 
  		$this->db->delete('tb_week');
		
		if($this->db->affected_rows() > 0){
			$arr_result['rs'] = true;
		}else{
			$arr_result['rs'] = false;
			$arr_result['msg'] = 'Cannot delete week';
		}
		

		echo json_encode($arr_result);
		
	}


}

/* End of file Week.php */