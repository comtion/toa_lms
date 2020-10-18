<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
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
    
    public function loadreport_company(){
        $arr['page'] = "report/loadreport_company";
        $this->load->model('User_model', 'login', TRUE);
        $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
        $this->lang->load($lang,$lang);

        $arr['lang'] = $lang;
        $this->load->model('User_model', 'login', TRUE);
        $this->load->model('Course_model', 'course', TRUE);
        $this->load->model('Log_model', 'lg', FALSE);
        $this->load->model('Footer_model', 'foot', FALSE);
        $this->load->model('Manage_model', 'manage', FALSE);

        $this->manage->loadDB();
        $this->login->loadDB();
        $this->course->loadDB();
        $this->lg->loadDB();
        $this->foot->loadDB();
        $arr['arr_permission'] = $this->manage->chk_permission_page();
        if($this->login->checkSession($arr['page'])){
          $user = $this->session->userdata('user');
          $arr['emp_c'] = $user['emp_c'];
          $arr['com_admin'] = $user['com_admin'];
          $arr['com_id'] = $user['com_id'];
          if($lang=="thai"){
            $arr['com_name'] = $user['com_name_th'];
          }else{
            $arr['com_name'] = $user['com_name_eng'];
          }
          $arr['user'] = $user;
          
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
          $arr['btn_view'] = $this->manage->chk_permission($arr['page'],'ru_view');
          $arr['btn_print'] = $this->manage->chk_permission($arr['page'],'ru_print');
          if($arr['btn_view']!="1"){
            redirect(base_url().'dashboard') ;
          }
          $arr['company_select'] = $this->manage->getCompany();
          $arr['foote'] = $this->foot->getfooter();
          $this->load->view('frontend/report_general_company', $arr );
        }
    }

    public function loadreport_coursename(){
        $arr['page'] = "report/loadreport_coursename";
        $this->load->model('User_model', 'login', TRUE);
        $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
        $this->lang->load($lang,$lang);

        $arr['lang'] = $lang;
        $this->load->model('User_model', 'login', TRUE);
        $this->load->model('Course_model', 'course', TRUE);
        $this->load->model('Log_model', 'lg', FALSE);
        $this->load->model('Function_query_model', 'func_query', FALSE);
        $this->load->model('Footer_model', 'foot', FALSE);
        $this->load->model('Manage_model', 'manage', FALSE);

        $this->manage->loadDB();
        $this->login->loadDB();
        $this->course->loadDB();
        $this->lg->loadDB();
        $this->foot->loadDB();
        $arr['arr_permission'] = $this->manage->chk_permission_page();
        if($this->login->checkSession($arr['page'])){
          $user = $this->session->userdata('user');
          $arr['emp_c'] = $user['emp_c'];
          $arr['com_admin'] = $user['com_admin'];
          $arr['com_id'] = $user['com_id'];
          if($lang=="thai"){
            $arr['com_name'] = $user['com_name_th'];
          }else{
            $arr['com_name'] = $user['com_name_eng'];
          }
          $arr['user'] = $user;
          
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
          $arr['btn_view'] = $this->manage->chk_permission($arr['page'],'ru_view');
          $arr['btn_print'] = $this->manage->chk_permission($arr['page'],'ru_print');
          if($arr['btn_view']!="1"){
            redirect(base_url().'dashboard') ;
          }
          $arr['company_select'] = $this->manage->getCompany();
          $arr['foote'] = $this->foot->getfooter();
          $this->load->view('frontend/report_general_coursename', $arr );
        }
    }

    public function loadreport_student(){
        $arr['page'] = "report/loadreport_student";
        $this->load->model('User_model', 'login', TRUE);
        $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
        $this->lang->load($lang,$lang);

        $arr['lang'] = $lang;
        $this->load->model('User_model', 'login', TRUE);
        $this->load->model('Course_model', 'course', TRUE);
        $this->load->model('Log_model', 'lg', FALSE);
        $this->load->model('Footer_model', 'foot', FALSE);
        $this->load->model('Manage_model', 'manage', FALSE);
        $this->load->model('Function_query_model', 'func_query', FALSE);

        $this->manage->loadDB();
        $this->login->loadDB();
        $this->course->loadDB();
        $this->lg->loadDB();
        $this->foot->loadDB();
        $arr['arr_permission'] = $this->manage->chk_permission_page();
        if($this->login->checkSession($arr['page'])){
          $user = $this->session->userdata('user');
          $arr['emp_c'] = $user['emp_c'];
          $arr['com_admin'] = $user['com_admin'];
          $arr['com_id'] = $user['com_id'];
          if($lang=="thai"){
            $arr['com_name'] = $user['com_name_th'];
          }else{
            $arr['com_name'] = $user['com_name_eng'];
          }
          $arr['user'] = $user;
          
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
          $arr['countemployee'] = $this->func_query->numrows('LMS_EMP','','','','emp_manage_a="'.$user['emp_c'].'" and emp_isDelete="0"');
          $arr['btn_view'] = $this->manage->chk_permission($arr['page'],'ru_view');
          $arr['btn_edit'] = $this->manage->chk_permission($arr['page'],'ru_edit');
          $arr['btn_print'] = $this->manage->chk_permission($arr['page'],'ru_print');
          if($arr['btn_view']!="1"){
            redirect(base_url().'dashboard') ;
          }
          $arr['company_select'] = $this->manage->getCompany();
          $arr['foote'] = $this->foot->getfooter();
          $this->load->view('frontend/report_general_student', $arr );
        }
    }

    public function loadreport_personal(){
        $arr['page'] = "report/loadreport_personal";
        $this->load->model('User_model', 'login', TRUE);
        $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
        $this->lang->load($lang,$lang);

        $arr['lang'] = $lang;
        $this->load->model('User_model', 'login', TRUE);
        $this->load->model('Course_model', 'course', TRUE);
        $this->load->model('Log_model', 'lg', FALSE);
        $this->load->model('Footer_model', 'foot', FALSE);
        $this->load->model('Manage_model', 'manage', FALSE);

        $this->manage->loadDB();
        $this->login->loadDB();
        $this->course->loadDB();
        $this->lg->loadDB();
        $this->foot->loadDB();
        $arr['arr_permission'] = $this->manage->chk_permission_page();
        if($this->login->checkSession($arr['page'])){
          $user = $this->session->userdata('user');
          $arr['emp_c'] = $user['emp_c'];
          $arr['com_admin'] = $user['com_admin'];
          $arr['com_id'] = $user['com_id'];
          if($lang=="thai"){
            $arr['com_name'] = $user['com_name_th'];
          }else{
            $arr['com_name'] = $user['com_name_eng'];
          }
          $arr['user'] = $user;
          
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
          $arr['btn_view'] = $this->manage->chk_permission($arr['page'],'ru_view');
          $arr['btn_print'] = $this->manage->chk_permission($arr['page'],'ru_print');
          if($arr['btn_view']!="1"){
            redirect(base_url().'dashboard') ;
          }
          $arr['foote'] = $this->foot->getfooter();
          $this->load->view('frontend/report_general_personal', $arr );
        }
    }

    public function loadreport_survey(){
        $arr['page'] = "report/loadreport_survey";
        $this->load->model('User_model', 'login', TRUE);
        $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
        $this->lang->load($lang,$lang);

        $arr['lang'] = $lang;
        $this->load->model('User_model', 'login', TRUE);
        $this->load->model('Course_model', 'course', TRUE);
        $this->load->model('Log_model', 'lg', FALSE);
        $this->load->model('Footer_model', 'foot', FALSE);
        $this->load->model('Manage_model', 'manage', FALSE);

        $this->manage->loadDB();
        $this->login->loadDB();
        $this->course->loadDB();
        $this->lg->loadDB();
        $this->foot->loadDB();
        $arr['arr_permission'] = $this->manage->chk_permission_page();
        if($this->login->checkSession($arr['page'])){
          $user = $this->session->userdata('user');
          $arr['emp_c'] = $user['emp_c'];
          $arr['com_admin'] = $user['com_admin'];
          $arr['com_id'] = $user['com_id'];
          if($lang=="thai"){
            $arr['com_name'] = $user['com_name_th'];
          }else{
            $arr['com_name'] = $user['com_name_eng'];
          }
          $arr['user'] = $user;
          
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
          $arr['btn_view'] = $this->manage->chk_permission($arr['page'],'ru_view');
          $arr['btn_print'] = $this->manage->chk_permission($arr['page'],'ru_print');
          if($arr['btn_view']!="1"){
            redirect(base_url().'dashboard') ;
          }
          $arr['foote'] = $this->foot->getfooter();
          $this->load->view('frontend/report_survey', $arr );
        }
    }

    public function loadreport_survey_detail($sv_id){
        $arr['page'] = "report/loadreport_survey";
        $this->load->model('User_model', 'login', TRUE);
        $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
        $this->lang->load($lang,$lang);

        $arr['lang'] = $lang;
        $this->load->model('User_model', 'login', TRUE);
        $this->load->model('Course_model', 'course', TRUE);
        $this->load->model('Log_model', 'lg', FALSE);
        $this->load->model('Footer_model', 'foot', FALSE);
        $this->load->model('Manage_model', 'manage', FALSE);
        $this->load->model('Function_query_model', 'func_query', FALSE);

        $this->manage->loadDB();
        $this->login->loadDB();
        $this->course->loadDB();
        $this->lg->loadDB();
        $this->foot->loadDB();
        $arr['arr_permission'] = $this->manage->chk_permission_page();
        if($this->login->checkSession($arr['page'])){
          $user = $this->session->userdata('user');
          $arr['emp_c'] = $user['emp_c'];
          $arr['com_admin'] = $user['com_admin'];
          $arr['com_id'] = $user['com_id'];
          if($lang=="thai"){
            $arr['com_name'] = $user['com_name_th'];
          }else{
            $arr['com_name'] = $user['com_name_eng'];
          }
          $arr['user'] = $user;
          $arr['sv_id'] = $sv_id;
          
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
          $arr['btn_view'] = $this->manage->chk_permission($arr['page'],'ru_view');
          $arr['btn_print'] = $this->manage->chk_permission($arr['page'],'ru_print');
          if($arr['btn_view']!="1"){
            redirect(base_url().'dashboard') ;
          }

          $result = $this->manage->query_data_onupdate($sv_id,'LMS_SURVEY','sv_id');
          $result['survey_detail'] = $this->func_query->query_result('LMS_SURVEY_DE','','','','sv_id="'.$sv_id.'" and svde_isDelete="0"');
          $survey_user = $this->manage->query_multi_data_onupdate($sv_id,'LMS_QN_USER','sv_id');

          $arr['data1'] = $this->manage->getSVQ($sv_id,1);
          $arr['data2'] = $this->manage->getSVQ($sv_id,2);
          $arr['data3'] = $this->manage->getSVQ($sv_id,3);
          $arr['data4'] = $this->manage->getSVQ($sv_id,4);
          $arr['data5'] = $this->manage->getSVQ($sv_id,5);
                $arr['data1'] = $this->func_query->query_result('LMS_SURVEY_DE','LMS_QN_USER_DE','LMS_SURVEY_DE.svde_id = LMS_QN_USER_DE.svde_id','','LMS_SURVEY_DE.sv_id="'.$sv_id.'" and LMS_QN_USER_DE.qnude_var="1"','','LMS_QN_USER_DE.svde_id,LMS_QN_USER_DE.qnude_var');
                $arr['data2'] = $this->func_query->query_result('LMS_SURVEY_DE','LMS_QN_USER_DE','LMS_SURVEY_DE.svde_id = LMS_QN_USER_DE.svde_id','','LMS_SURVEY_DE.sv_id="'.$sv_id.'" and LMS_QN_USER_DE.qnude_var="2"','','LMS_QN_USER_DE.svde_id,LMS_QN_USER_DE.qnude_var');
                $arr['data3'] = $this->func_query->query_result('LMS_SURVEY_DE','LMS_QN_USER_DE','LMS_SURVEY_DE.svde_id = LMS_QN_USER_DE.svde_id','','LMS_SURVEY_DE.sv_id="'.$sv_id.'" and LMS_QN_USER_DE.qnude_var="3"','','LMS_QN_USER_DE.svde_id,LMS_QN_USER_DE.qnude_var');
                $arr['data4'] = $this->func_query->query_result('LMS_SURVEY_DE','LMS_QN_USER_DE','LMS_SURVEY_DE.svde_id = LMS_QN_USER_DE.svde_id','','LMS_SURVEY_DE.sv_id="'.$sv_id.'" and LMS_QN_USER_DE.qnude_var="4"','','LMS_QN_USER_DE.svde_id,LMS_QN_USER_DE.qnude_var');
                $arr['data5'] = $this->func_query->query_result('LMS_SURVEY_DE','LMS_QN_USER_DE','LMS_SURVEY_DE.svde_id = LMS_QN_USER_DE.svde_id','','LMS_SURVEY_DE.sv_id="'.$sv_id.'" and LMS_QN_USER_DE.qnude_var="5"','','LMS_QN_USER_DE.svde_id,LMS_QN_USER_DE.qnude_var');
          $result['survey_count'] = count($survey_user);
          $arr['result_data'] = $result;
          $arr['foote'] = $this->foot->getfooter();
          $this->load->view('frontend/report_survey_detail', $arr );
        }
    }
    public function fetch_detail( $survey_id ){
    $this->load->model('Report_model', 'report', TRUE);
    $this->report->loadDB();
    $query = $this->report->fetch_Suggestion($survey_id);
    //print_r($query);
    $num = 1;
      $draw = intval($this->input->get("draw"));
      $start = intval($this->input->get("start"));
      $length = intval($this->input->get("length"));



      $data = [];
      $count = 0;

      foreach($query as $r) {
          $data[] = array(
              $num,
              $r->qnude_suggestion
          );
      $num++;
      $count++;
      }


      $result = array(
               "draw" => $draw,
                 "recordsTotal" => $count,
                 "recordsFiltered" => $count,
                 "data" => $data
            );


      echo json_encode($result);
      exit();
  }

  public function fetch_detail_head( $scode ){
    $this->load->model('Report_model', 'report', TRUE);
    $this->report->loadDB();
    $query = $this->report->fetch_Suggestion_head($scode);
    //print_r($query);
    $num = 1;
      $draw = intval($this->input->get("draw"));
      $start = intval($this->input->get("start"));
      $length = intval($this->input->get("length"));



      $data = [];
      $count = 0;

      foreach($query as $r) {
          $data[] = array(
              $num,
              $r->qnu_suggestion
          );
      $num++;
      $count++;
      }


      $result = array(
               "draw" => $draw,
                 "recordsTotal" => $count,
                 "recordsFiltered" => $count,
                 "data" => $data
            );


      echo json_encode($result);
      exit();
  }

    public function fetch_course_survey(){
      $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
      $user = $this->session->userdata('user');
      $this->lang->load($lang,$lang);
      $this->load->model('Report_model', 'report', TRUE);
      $this->report->loadDB();
      $query = $this->report->fetch_course_survey($user,$_REQUEST['com_id']);
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


    public function fetch_course_company(){
      $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
      $user = $this->session->userdata('user');
      $this->lang->load($lang,$lang);
      $this->load->model('Report_model', 'report', TRUE);
      $this->report->loadDB();
      $query = $this->report->fetch_course_company($user,$_REQUEST['com_id']);
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

    public function fetch_coursename_company(){
      $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
      $user = $this->session->userdata('user');
      $this->lang->load($lang,$lang);
      $this->load->model('Report_model', 'report', TRUE);
      $this->report->loadDB();
      $query = $this->report->fetch_coursename_company($user,$_REQUEST['com_id'],$_REQUEST['cg_id']);
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

    public function fetch_coursename_detail(){
      $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
      $user = $this->session->userdata('user');
      $this->lang->load($lang,$lang);
      $this->load->model('Report_model', 'report', TRUE);
      $this->report->loadDB();
      $query = $this->report->fetch_coursename_detail($user,$_REQUEST['cos_id']);
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

    public function update_pointof_manager(){
      $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
      $user = $this->session->userdata('user');
      $this->lang->load($lang,$lang);
      $this->load->model('Report_model', 'report', TRUE);
      $this->report->loadDB();

      $phprating = $_REQUEST['phprating'];
      $emp_id = $_REQUEST['emp_id'];
      $cos_id = $_REQUEST['cos_id'];
      for ($i=0; $i < count($cos_id); $i++) { 
        $data = array(
          'cosen_pfm' => $phprating[$i]
        );
        $this->db->where('emp_id',$emp_id[$i]);
        $this->db->where('cos_id',$cos_id[$i]);
        $this->db->update('LMS_COS_ENROLL',$data);
      }
      //print_r($cos_id);
    }


    public function fetch_course_student(){
      $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
      $user = $this->session->userdata('user');
      $this->lang->load($lang,$lang);
      $this->load->model('Report_model', 'report', TRUE);
      $this->report->loadDB();
        $com_id = isset($_REQUEST['com_id']) ? $_REQUEST['com_id'] : '';
        $dep_id = isset($_REQUEST['dep_id']) ? $_REQUEST['dep_id'] : '';
        $time_start = isset($_REQUEST['time_start']) ? $_REQUEST['time_start'] : '';
        $time_end = isset($_REQUEST['time_end']) ? $_REQUEST['time_end'] : '';
        $date_start = isset($_REQUEST['date_start'])&&$_REQUEST['date_start']!=""?$_REQUEST['date_start']." ".$time_start:"";
        $date_end = isset($_REQUEST['date_end'])&&$_REQUEST['date_end']!=""?$_REQUEST['date_end']." ".$time_end:"";
      $query = $this->report->fetch_course_student($user,$com_id,$dep_id,$_REQUEST['cos_id'],$_REQUEST['course_status'],$_REQUEST['cosen_status_sub'],$date_start,$date_end);
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

    public function fetch_course_personal(){
      $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
      $user = $this->session->userdata('user');
      $this->lang->load($lang,$lang);
      $this->load->model('Report_model', 'report', TRUE);
      $this->report->loadDB();
        $time_start = isset($_REQUEST['time_start']) ? $_REQUEST['time_start'] : '';
        $time_end = isset($_REQUEST['time_end']) ? $_REQUEST['time_end'] : '';
        $date_start = isset($_REQUEST['date_start'])&&$_REQUEST['date_start']!=""?$_REQUEST['date_start']." ".$time_start:"";
        $date_end = isset($_REQUEST['date_end'])&&$_REQUEST['date_end']!=""?$_REQUEST['date_end']." ".$time_end:"";
      $query = $this->report->fetch_course_personal($user,$_REQUEST['course_status'],$_REQUEST['cosen_status_sub'],$date_start,$date_end);
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

    public function fetch_detail_answer(){
      $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
      $user = $this->session->userdata('user');
      $this->lang->load($lang,$lang);
      $this->load->model('Report_model', 'report', TRUE);
      $this->load->model('Function_query_model', 'func_query', TRUE);
      $this->report->loadDB();
      $cosen_id = isset($_REQUEST['cosen_id']) ? $_REQUEST['cosen_id'] : '';
      $fetch_chk_enroll = $this->func_query->query_row('LMS_COS_ENROLL','','','','cosen_id="'.$cosen_id.'"');
      if(count($fetch_chk_enroll)>0&&$fetch_chk_enroll['cosen_status_sub']=="1"){
        ?>
        <style type="text/css">
          .tbquery th, .tbquery td { border: 1px solid #ddd!important } 
        </style>
        <?php
        $fetch_chk_pretest = $this->func_query->query_result('LMS_QIZ','','','','cos_id="'.$fetch_chk_enroll['cos_id'].'" and quiz_type="1" and quiz_isDelete="0" and LMS_QIZ.qiz_id in (select LMS_QUES.qiz_id from LMS_QUES where LMS_QUES.ques_type in ("sa","sub"))');
        if(count($fetch_chk_pretest)>0){
          $numloop = 1;
          foreach ($fetch_chk_pretest as $key_pretest => $value_pretest) {

                  if($lang=="thai"){ 
                    $quiz_name = $value_pretest['quiz_name_th']!=""?$value_pretest['quiz_name_th']:$value_pretest['quiz_name_eng'];
                  }else if($lang=="english"){ 
                    $quiz_name = $value_pretest['quiz_name_eng']!=""?$value_pretest['quiz_name_eng']:$value_pretest['quiz_name_th'];
                  }
          ?>
          <h5><?php echo label('preExam').": ".$quiz_name; ?></h5>

          <div class="table-responsive">

                <table id="myTablePretest<?php echo $numloop;$numloop++; ?>" width="100%" style="" class="table table-bordered  table-striped tbquery">
                  <thead>
                    <tr>
                      <th width="10%"><center></center></th>
                      <th width="30%"><center><?php echo label('question'); ?></center></th>
                      <th width="30%"><center><?php echo label('answer'); ?></center></th>
                      <th width="30%"><center><?php echo label('sv_b_comment'); ?></center></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      $fetch_question = $this->func_query->query_result('LMS_QUES','LMS_QUES_TC','LMS_QUES_TC.ques_id = LMS_QUES.ques_id','','LMS_QUES.qiz_id="'.$value_pretest['qiz_id'].'" and LMS_QUES.ques_isDelete="0" and LMS_QUES_TC.cosen_id="'.$cosen_id.'" and LMS_QUES.ques_type in ("sa","sub")','LMS_QUES_TC.tc_id DESC','','','LMS_QUES_TC.ques_id');
                      if(count($fetch_question)>0){
                        $num = 1;
                        foreach ($fetch_question as $key_question => $value_question) {
                                  if($lang=="thai"){ 
                                    $ques_name = $value_question['ques_name_th']!=""?$value_question['ques_name_th']:$value_question['ques_name_eng'];
                                  }else if($lang=="english"){ 
                                    $ques_name = $value_question['ques_name_eng']!=""?$value_question['ques_name_eng']:$value_question['ques_name_th'];
                                  }
                                  if(in_array($value_question['ques_type'], array("sa","sub"))){
                                    $tc_answer = $value_question['tc_answer']!=""?$value_question['tc_answer']:"<center>-</center>";
                                  }else{
                                    $fetch_multi = $this->func_query->query_row('LMS_QUES_MUL','','','','ques_id="'.$value_question['ques_id'].'"');
                                    if(count($fetch_multi)>0&&$value_question['tc_answer']!=""){
                                      if($fetch_chk_enroll['cosen_lang']=="thai"){
                                        $tc_answer = isset($fetch_multi[$value_question['tc_answer'].'_th'])&&$fetch_multi[$value_question['tc_answer'].'_th']!=""?$fetch_multi[$value_question['tc_answer'].'_th']:$fetch_multi[$value_question['tc_answer'].'_eng'];
                                      }else if($fetch_chk_enroll['cosen_lang']=="english"){
                                        $tc_answer = isset($fetch_multi[$value_question['tc_answer'].'_eng'])&&$fetch_multi[$value_question['tc_answer'].'_eng']!=""?$fetch_multi[$value_question['tc_answer'].'_eng']:$fetch_multi[$value_question['tc_answer'].'_th'];
                                      }
                                    }else{
                                        $tc_answer = "<center>-</center>";
                                    }
                                  }
                          ?>
                    <tr>
                      <th width="10%"><center><?php echo $num;$num++; ?></center></th>
                      <th width="30%"><?php echo $ques_name; ?></th>
                      <th width="30%"><?php echo isset($value_question['tc_answer'])?$tc_answer:"<center>-</center>"; ?></th>
                      <th width="30%"><center><?php echo isset($value_question['tc_note'])&&$value_question['tc_note']!=""?$value_question['tc_note']:"<center>-</center>"; ?></center></th>
                    </tr>
                          <?php
                        }
                      }
                    ?>
                  </tbody>
                </table>
          </div><hr>
          <script type="text/javascript">
            $('#myTablePretest<?php echo $numloop;$numloop++; ?>').DataTable();
          </script>
          <?php 
          }
        }
        $fetch_chk_posttest = $this->func_query->query_result('LMS_QIZ','','','','cos_id="'.$fetch_chk_enroll['cos_id'].'" and quiz_type="2" and quiz_isDelete="0" and LMS_QIZ.qiz_id in (select LMS_QUES.qiz_id from LMS_QUES where LMS_QUES.ques_type in ("sa","sub"))');
        if(count($fetch_chk_posttest)>0){
          $numloop = 1;
          foreach ($fetch_chk_posttest as $key_posttest => $value_posttest) {

                  if($lang=="thai"){ 
                    $quiz_name = $value_posttest['quiz_name_th']!=""?$value_posttest['quiz_name_th']:$value_posttest['quiz_name_eng'];
                  }else if($lang=="english"){ 
                    $quiz_name = $value_posttest['quiz_name_eng']!=""?$value_posttest['quiz_name_eng']:$value_posttest['quiz_name_th'];
                  }
          ?>
          <h5><?php echo label('finalExam').": ".$quiz_name; ?></h5>

          <div class="table-responsive">

                <table id="myTablePosttest<?php echo $numloop;$numloop++; ?>" width="100%" style="" class="table table-bordered  table-striped tbquery">
                  <thead>
                    <tr>
                      <th width="10%"><center></center></th>
                      <th width="30%"><center><?php echo label('question'); ?></center></th>
                      <th width="30%"><center><?php echo label('answer'); ?></center></th>
                      <th width="30%"><center><?php echo label('sv_b_comment'); ?></center></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                      $fetch_question = $this->func_query->query_result('LMS_QUES','LMS_QUES_TC','LMS_QUES_TC.ques_id = LMS_QUES.ques_id','','LMS_QUES.qiz_id="'.$value_posttest['qiz_id'].'" and LMS_QUES.ques_isDelete="0" and LMS_QUES_TC.cosen_id="'.$cosen_id.'" and LMS_QUES.ques_type in ("sa","sub")','LMS_QUES_TC.tc_id DESC','','','LMS_QUES_TC.ques_id');
                      if(count($fetch_question)>0){
                        $num = 1;
                        foreach ($fetch_question as $key_question => $value_question) {
                                  if($lang=="thai"){ 
                                    $ques_name = $value_question['ques_name_th']!=""?$value_question['ques_name_th']:$value_question['ques_name_eng'];
                                  }else if($lang=="english"){ 
                                    $ques_name = $value_question['ques_name_eng']!=""?$value_question['ques_name_eng']:$value_question['ques_name_th'];
                                  }
                                  if(in_array($value_question['ques_type'], array("sa","sub"))){
                                    $tc_answer = $value_question['tc_answer']!=""?$value_question['tc_answer']:"<center>-</center>";
                                  }else{
                                    $fetch_multi = $this->func_query->query_row('LMS_QUES_MUL','','','','ques_id="'.$value_question['ques_id'].'"');
                                    if(count($fetch_multi)>0&&$value_question['tc_answer']!=""){
                                      if($fetch_chk_enroll['cosen_lang']=="thai"){
                                        $tc_answer = isset($fetch_multi[$value_question['tc_answer'].'_th'])&&$fetch_multi[$value_question['tc_answer'].'_th']!=""?$fetch_multi[$value_question['tc_answer'].'_th']:$fetch_multi[$value_question['tc_answer'].'_eng'];
                                      }else if($fetch_chk_enroll['cosen_lang']=="english"){
                                        $tc_answer = isset($fetch_multi[$value_question['tc_answer'].'_eng'])&&$fetch_multi[$value_question['tc_answer'].'_eng']!=""?$fetch_multi[$value_question['tc_answer'].'_eng']:$fetch_multi[$value_question['tc_answer'].'_th'];
                                      }
                                    }else{
                                        $tc_answer = "<center>-</center>";
                                    }
                                  }
                          ?>
                    <tr>
                      <th width="10%"><center><?php echo $num;$num++; ?></center></th>
                      <th width="30%"><?php echo $ques_name; ?></th>
                      <th width="30%"><?php echo isset($value_question['tc_answer'])?$tc_answer:"<center>-</center>"; ?></th>
                      <th width="30%"><center><?php echo isset($value_question['tc_note'])&&$value_question['tc_note']!=""?$value_question['tc_note']:"<center>-</center>"; ?></center></th>
                    </tr>
                          <?php
                        }
                      }
                    ?>
                  </tbody>
                </table>
          </div><hr>
          <script type="text/javascript">
            $('#myTablePosttest<?php echo $numloop;$numloop++; ?>').DataTable();
          </script>
          <?php 
          }
        }
      }
    }


}
