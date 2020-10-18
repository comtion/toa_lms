<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fetchdata extends CI_Controller {

  public function fetch_detail_allcourseadmin(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_detail_allcourseadmin();
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

  public function fetch_detail_instructor_create(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_detail_instructor_create();
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

  public function fetch_detail_instructor_latest_complete(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_detail_instructor_latest_complete();
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
  
  public function fetch_detail_ongoninglearner(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_detail_ongoninglearner();
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
  
  public function fetch_detail_incominglearner(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_detail_incominglearner();
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

  public function fetch_detail_alluseradmin(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_detail_alluseradmin();
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

  public function fetch_detail_workgroup(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_data_workgroup($_REQUEST['com_id']);
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

  public function fetch_detail_coursegroup(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_data_coursegroup();
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

  public function fetch_detail_ongoing(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_data_courseongoing($_REQUEST['com_id'],$_REQUEST['type']);
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

  public function fetch_detail_incoming(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_data_courseincoming($_REQUEST['com_id'],$_REQUEST['type']);
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

  public function fetch_detail_course(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_data_course($_REQUEST['com_id']);
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

  public function fetch_public_survey(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_data_publicsurvey($_REQUEST['com_id']);
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

  public function fetch_public_survey_detail(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_data_publicsurvey_detail($_REQUEST['sv_id']);
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

  public function fetch_public_survey_listuser(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_data_publicsurvey_listuser($_REQUEST['sv_id']);
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

  public function fetch_cos_document(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_data_cos_document($_REQUEST['cos_id']);
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

  public function fetch_course_detail(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_data_course_detail($_REQUEST['cos_id']);
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

  public function fetch_videocourse(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $user = $this->session->userdata('user');
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', TRUE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_videocourse($_REQUEST['cos_id']);
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
  
  public function fetch_course_enroll(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $user = $this->session->userdata('user');
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', TRUE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_data_enroll_detail($_REQUEST['cos_id']);
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

  public function fetch_course_lesson(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $user = $this->session->userdata('user');
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', TRUE);
    $this->fetch->loadDB();
    $status_user = isset($_REQUEST['status_user']) ? $_REQUEST['status_user'] : '';
    $query = $this->fetch->fetch_course_lesson($_REQUEST['cos_id'],$status_user);
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

  public function fetch_course_qiz_criteriascore(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $user = $this->session->userdata('user');
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', TRUE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_course_qiz_criteriascore($_REQUEST['qiz_id']);
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

  public function fetch_course_quiz(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $user = $this->session->userdata('user');
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', TRUE);
    $this->fetch->loadDB();
    $status_user = isset($_REQUEST['status_user']) ? $_REQUEST['status_user'] : '';
    $query = $this->fetch->fetch_course_quiz($_REQUEST['cos_id'],$status_user);
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

  public function fetch_course_question(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $user = $this->session->userdata('user');
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', TRUE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_course_question($_REQUEST['quiz']);
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

  public function fetch_quiz_question_check(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $user = $this->session->userdata('user');
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', TRUE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_quiz_question_check($_REQUEST['ques_id']);
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

  public function fetch_course_survey(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $user = $this->session->userdata('user');
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', TRUE);
    $this->fetch->loadDB();
    $status_user = isset($_REQUEST['status_user']) ? $_REQUEST['status_user'] : '';
    $query = $this->fetch->fetch_course_survey($_REQUEST['cos_id'],$status_user);
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

  public function fetch_course_survey_detail(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $user = $this->session->userdata('user');
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', TRUE);
    $this->fetch->loadDB();
    $query = $this->fetch->fetch_course_survey_detail($_REQUEST['sv_id']);
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
}