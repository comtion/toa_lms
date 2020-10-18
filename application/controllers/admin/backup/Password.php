<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 /**
 * Password Controller Class
 * =====================
 * @Filename: Password.php
 * @Location: ./application/controllers/backoffice/Password.php
 * @Description : Password is a PHP class of backoffice for manage.
 *
 * @Creator Wutikorn Jitpruegsa <wutikorn@digitalnex.com>
 */

class Password extends CI_Controller {

	public function __construct() {
		parent::__construct();
	}
	
	public function index()
	{
		
	}

/**
* Generate random key.
* ================================
* @Description : generateKeygen is a php function for generate random key and insert it to database when create reset password link.
* @param : fb_id, fb_name, image
* @return : true,false and message when try to insert
*/	
	public function generateKeygen(){
		
		$input = $this->input->post();
		$username = $this->db->escape_str($input['username']);
		$arr_result = array();
		
		$this->db->select('id, email');
		$query = $this->db->get_where('tb_user',array('username' => $username), 1 );

		$data = $query->result_array();
		if( $query->num_rows() > 0 ){
			$keyset = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
			$keygen = "";
			for( $i = 0 ; $i < 26 ; $i++ ){
				$ranNum = rand( 0, 25);
				$keygen .= $keyset[$ranNum];
			}
			$insert_data = array( 'userid' => $data[0]['id'], 'keygen' => $keygen );
			
			$this->db->insert('tb_reset_key', $insert_data );
			
			if( $this->db->affected_rows() > 0 ){
				$email_sent = $this->sendEmail( $data[0]['email'] , $keygen );
				if( $email_sent ){
					$arr_result['rs'] = true;
				}else{
					$arr_result['rs'] = false;
					$arr_result['msg'] = "Can not send the email" ;
				}
			}else{
				$arr_result['rs'] = false;
				$arr_result['msg'] = "Can not gennerate keygen" ;
			}
				
		} else{
			$arr_result['rs'] = false;
			$arr_result['msg'] = "Your username not in our system" ;
		}
		
		echo json_encode($arr_result);
	}
	
/**
* Send email reset password
* ================================
* @Description : sendEmail is a php function for send email with reset password link.
* @param : emailTo,keygen
* @return : true,false and message when try to send
*/	
	public function sendEmail( $emailTo, $keygen ){
		
		$emailFrom = "admin@digitalnex.com";
		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => 'wutikorn@digitalnex.com',
			'smtp_pass' => 'ohmdigitalnex',
			'mailtype'  => 'html', 
			'charset'   => 'utf-8'
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		
				
		$this->email->from( $emailFrom );
		$this->email->to( $emailTo );
		
		$this->email->subject('Your password reset link');
		$this->email->message("Please click this link for reset your password : ". base_url()."backoffice/password/resetnow/".$keygen);
		
		if( $this->email->send() ){
			$success = true ;
		}else{
			$success = false ;
		}
		
		return $success;
	}
	
/**
* Send email reset password
* ================================
* @Description : sendEmail is a php function for send email with reset password link.
* @param : emailTo,keygen
* @return : true,false and message when try to send
*/	
	public function resetnow( $keygen ){
		
		$this->db->select('id, keygen');
		$query = $this->db->get_where('tb_reset_key',array('keygen' => $keygen, 'publish' => 1 ), 1 );
		
		if( $query->num_rows() > 0 ){
			$data['reset_detail'] = $query->result_array();
			$data['reset_check'] = true;
			$this->load->view('backoffice/reset_password', $data );
		}else{
			$data['reset_check'] = false;
			$this->load->view('backoffice/reset_password', $data );
		}
		
	}
	
/**
* Submit to update new password
* ================================
* @Description : submit_reset is a php function for update new password when user submit reset password form
* @param : password
* @return : true,false and message when try to update
*/	
	public function submit_reset(){
		
		$result = array();
		
		$input = $this->input->post();
		$keygen = $this->db->escape_str($input['keygen']) ;
		$password = $input['password'] ;
		
		$this->db->select('userid');
		$query = $this->db->get_where('tb_reset_key',array('keygen' => $keygen, 'publish' => 1 ), 1 );
		
		if( $query->num_rows() > 0 ){
			
			$data = $query->result_array();
			date_default_timezone_set("Asia/Bangkok");
			$u_date = date('Y-m-d H:i');
			
			$this->db->update('tb_user', array('password' => $password,'u_date' => $u_date ,'u_by' => 3 ), array('id' => $data[0]['id'] ));
				if($this->db->affected_rows() > 0){
					
					$this->db->update('tb_reset_key', array('publish' => 0,'u_date' => $u_date,'u_by' => 3 ), array('keygen' => $keygen ));
					if($this->db->affected_rows() > 0){
						$result['rs'] = true;
					}else{
						$result['rs'] = false;
						$result['msg'] = 'Cannot remove keygen';
					}
					
				}else{
					$result['rs'] = false;
					$result['msg'] = 'Cannot reset your password';
				}
			
		}else{
			$result['rs'] = false;
			$result['msg'] = 'Your keygen expire or not in our system';
		}
		
		echo json_encode($result);
	}
}

/* End of file Password.php */