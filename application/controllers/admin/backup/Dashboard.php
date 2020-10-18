<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

  function __construct()
  {
    parent::__construct();
    if(!$this->session->userdata('is_login')){
			redirect(base_url().'admin/user_login', 'refresh');
		}
  }

  public function index()
  {

    $this->load->view('admin/dashboard_view', $data);
  }
}
