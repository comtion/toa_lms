<?php
class Workgroup_model extends CI_Model {

  public function __construct()
  {
    // Call the CI_Model constructor
    parent::__construct();
  }
  public function loadDB(){ $this->load->database(); }
  public function closeDB(){ $this->db->close(); }

  public function rechk_permission_wg(){
    $user = $this->session->userdata('user');
    $this->db->distinct();
    $this->db->select('LMS_COS_DETAIL.cos_id');
    $this->db->from('LMS_COS_DETAIL');
    $this->db->join('LMS_COS_DETAIL_UG','LMS_COS_DETAIL.cosde_id = LMS_COS_DETAIL_UG.cosde_id');
    $this->db->where('LMS_COS_DETAIL_UG.ug_id',$user['ug_id']);
    $this->db->where('LMS_COS_DETAIL.status', '1' );
      $where = "((LMS_COS_DETAIL.date_start <= '".date('Y-m-d H:i')."' and LMS_COS_DETAIL.date_end >='".date('Y-m-d H:i')."') OR (LMS_COS_DETAIL.date_start = '0000-00-00 00:00:00' and LMS_COS_DETAIL.date_end = '0000-00-00 00:00:00'))";
      $this->db->where($where);/*
    $this->db->where('LMS_COS_DETAIL.date_start <=', date('Y-m-d') );
    $this->db->where('LMS_COS_DETAIL.date_end >=', date('Y-m-d') );*/
    $query = $this->db->get();
    $fetch = $query->result_array();
    $wg_id = array();
    if(count($fetch)>0){
      foreach ($fetch as $key => $value) {
          $this->db->select('wg_id');
          $this->db->from('LMS_COS');
          $this->db->where('id',$value['cos_id']);
          $query_cos = $this->db->get();
          $row_cos = $query_cos->row_array();
          if(count($row_cos)>0){
            if(!in_array($row_cos['wg_id'], $wg_id)){
              array_push($wg_id, $row_cos['wg_id']);
            }
          }
      }
    }
    return $wg_id;
  }
  public function getAllWorkgroup( $id = "",$txt_search="", $wcode_set = array()){
    $user = $this->session->userdata('user');
   // $role = $user['role'];
    $ar_return = array();
    if( sizeof( $wcode_set ) == 0 ){
      $this->db->from('LMS_WKG');
      $this->db->order_by('c_date', 'DESC');
      $this->db->where('wstatus', '1' );
      if($id!=""){
        $this->db->where('id', $id );
      }
      if($txt_search!=""){
        $where = "(wtitle_th like '%".$txt_search."%' OR wtitle_en like '%".$txt_search."%')";
        $this->db->where($where);
      }
      if($user['com_admin']=="CUSTOMER"){
        $this->db->where('com_id', $user['com_id'] );
      }else{
        if($user['Is_admin']=="0"){
          $this->db->where('com_id', $user['com_id'] );
        }
      }
      $query = $this->db->get();
      $ar_return = $query->result_array();
    }else{
        foreach( $wcode_set as $set ){
            $this->db->from('LMS_WKG');
            $this->db->where('id', $set );
            $this->db->where('wstatus', '1' );
            if($user['com_admin']=="CUSTOMER"){
              $this->db->where('com_id', $user['com_id'] );
            }
            $this->db->order_by('c_date', 'DESC');
            $query = $this->db->get();
            foreach( $query->result_array() as $row ){
              if(!in_array( $row , $ar_return )){
                array_push( $ar_return ,  $row );
              }
            }
        }
    }
    return $ar_return;
  }
  public function getWorkgroup( $id ){
    $this->db->from('LMS_WKG');
    $this->db->where('id', $id );
    $this->db->order_by('c_date', 'DESC');
    $query = $this->db->get();
    return $query->result_array();
  }
  public function selectSurvey( $cos_id ){
    $this->db->from('LMS_SURVEY');
    $this->db->where('cos_id', $cos_id );
    $this->db->where('sv_status','1');
    $query = $this->db->get();
    return $query->result_array();
  }
  public function getCourseGroup( $course_id ){
    $this->db->from('LMS_COSINCG');
    $this->db->where('course_id', $course_id );
    $this->db->where('status_cg','1');
    $query = $this->db->get();
    return $query->result_array();
  }

        public function getCostype($com_id="") {
          $ar_return = array();
            $this->db->select('tc_id,tc_name_th,tc_name_en');
            $this->db->distinct();
            $this->db->where('tc_status','1');
            $this->db->where('com_id',$com_id);
            $query = $this->db->get('LMS_TYPECOS');
            $ar_return = $query->result_array();
          return $ar_return;
        }
  public function rechkUseWorkgroup( $id ){
    $this->db->from('LMS_COG');
    $this->db->where('wg_id', $id );
    $this->db->where('cg_status', '1' );
    $query = $this->db->get();
    return $query->result_array();
  }

  public function rechkComIdWorkgroup(){
    $this->db->distinct();
    $this->db->select('LMS_WKG.com_id');
    $this->db->from('LMS_WKG');
    $this->db->where('wstatus', '1');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function selectComId($com_id){
    $this->db->distinct();
    $this->db->select('LMS_WKG.wtitle_th,LMS_WKG.wtitle_en,LMS_WKG.id');
    $this->db->from('LMS_WKG');
    $this->db->where('wstatus', '1');
    $this->db->where('com_id', $com_id);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function selectWorkgoup($wg_id){
    $this->db->distinct();
    $this->db->select('LMS_COG.cgtitle_th,LMS_COG.cgtitle_en,LMS_COG.id');
    $this->db->from('LMS_COG');
    $this->db->where('cg_status', '1');
    $this->db->where('wg_id', $wg_id);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function selectCondition($com_id){
    $this->db->distinct();
    $this->db->select('LMS_COS.cname_th,LMS_COS.cname_eng,LMS_COS.cos_id');
    $this->db->from('LMS_COS');
    $this->db->where('status', '1');
    $this->db->where('com_id', $com_id);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function selectquize($com_id,$quiz_lang){
    $user = $this->session->userdata('user');
    $this->db->distinct();
    $this->db->select('LMS_QIZ_EXP.qize_name,LMS_QIZ_EXP.qize_id');
    $this->db->from('LMS_QIZ_EXP');
    $this->db->where('LMS_QIZ_EXP.com_id', $com_id);
    $this->db->where('LMS_QIZ_EXP.qize_lang', $quiz_lang);
    $this->db->where('LMS_QIZ_EXP.qize_status', '1');
    $this->db->where('LMS_QIZ_EXP.qize_isDelete', '0');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function selectcos($com_id){
    $user = $this->session->userdata('user');
    $this->db->distinct();
    $this->db->select('LMS_COS.cos_id,LMS_COS.cname_th,LMS_COS.cname_eng');
    $this->db->from('LMS_COS');
    $this->db->where('LMS_COS.com_id', $com_id);
    $this->db->where('cos_isDelete','0');
    $this->db->where('cos_public','1');
    if($user['ug_viewdata']=="2"){
    $this->db->where('LMS_COS.com_id', $user['com_id']);
    }else if($user['ug_viewdata']=="3"){
      $this->db->where('LMS_COS.cos_createby', $user['u_id']);
    }else{
    $this->db->where('LMS_COS.com_id', $com_id);
    }
    $query = $this->db->get();
    return $query->result_array();
  }

  public function selectcos_report($com_id){
    $user = $this->session->userdata('user');
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->db->distinct();
    $this->db->select('LMS_COS.cos_id,LMS_COS.cname_th,LMS_COS.cname_eng');
    $this->db->from('LMS_COS');
   /* $this->db->where('LMS_COS.com_id', $com_id);*/
    $this->db->where('cos_isDelete','0');
    $this->db->where('cos_public','1');
    /*if($user['ug_viewdata']=="2"){
    $this->db->where('LMS_COS.com_id', $user['com_id']);
    }else if($user['ug_viewdata']=="3"){
      $this->db->where('LMS_COS.cos_createby', $user['u_id']);
    }else{
    $this->db->where('LMS_COS.com_id', $com_id);
    }*/
    $query = $this->db->get();
    $fetch = $query->result_array();
    if(count($fetch)>0){
        foreach ($fetch as $key => $value) {
            $where = 'LMS_COS_ENROLL.emp_id in (select LMS_EMP.emp_id from LMS_EMP where (LMS_EMP.emp_manage_a="'.$user['emp_c'].'") and LMS_EMP.emp_isDelete="0") and LMS_COS_ENROLL.cosen_isDelete="0" and LMS_COS_ENROLL.cos_id="'.$value['cos_id'].'"';
            $fetch_chk = $this->func_query->numrows('LMS_COS_ENROLL','','','',$where);
            if($fetch_chk==0){
                unset($fetch[$key]);
            }
        }
    }
    return $fetch;
  }

  public function selectQuestionnaire(){
    $user = $this->session->userdata('user');
    $this->db->distinct();
    $this->db->select('LMS_QUESTIONNAIRE.qn_title_th,LMS_QUESTIONNAIRE.qn_title_en,LMS_QUESTIONNAIRE.qn_id');
    $this->db->from('LMS_QUESTIONNAIRE');
    $this->db->where('LMS_QUESTIONNAIRE.qn_status', '1');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function selectcos_id($com_id){
    $user = $this->session->userdata('user');
    $this->db->distinct();
    $this->db->select('LMS_COS.cos_id,LMS_COS.cname_th,LMS_COS.cname_eng');
    $this->db->from('LMS_COS');
    $this->db->where('LMS_COS.status', '1');
    $this->db->where('LMS_COS.com_id', $com_id);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function selectfil($les_id){
    $user = $this->session->userdata('user');
    $this->db->distinct();
    $this->db->from('LMS_FIL');
    $this->db->where('LMS_FIL.lessons_id', $les_id);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function selectQuiz($cos_id){
    $user = $this->session->userdata('user');
    $this->db->distinct();
    $this->db->select('LMS_QIZ.quiz_name_th,LMS_QIZ.quiz_name_en,LMS_QIZ.qiz_id');
    $this->db->from('LMS_QIZ');
    $this->db->where('LMS_QIZ.quiz_status', '1');
    $this->db->where('LMS_QIZ.cos_id', $cos_id);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function create_workgroup($data)
  {
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');
          $this->db->from('LMS_WKG');
          $this->db->where('com_id', $data['com_id']);
          $this->db->where('wcode', $data['wcode']);
          $this->db->where('wtitle_th', $data['wtitle_th']);
          $this->db->where('wtitle_en', $data['wtitle_en']);
          $this->db->where('wstatus', '1');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $data['c_date'] = date("Y-m-d H:i");
            $data['c_by'] = $user['emp_c'];
            $data['u_date'] = date("Y-m-d H:i");
            $data['u_by'] = $user['emp_c'];
            $this->db->insert('LMS_WKG', $data);
            $id = $this->db->insert_id();
            if($id!=""){
              return "2";
            }else{
              return "3";
            }
          }else{
            return "1";
          }
  }

  public function update_workgroup($data,$id)
  {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('id', $id);
          $this->db->update('LMS_WKG', $data);
          return "2";
  }
}
