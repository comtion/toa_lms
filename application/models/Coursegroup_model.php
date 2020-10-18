<?php
class Coursegroup_model extends CI_Model {

  public function __construct()
  {
    // Call the CI_Model constructor
    parent::__construct();
  }
  public function loadDB(){ $this->load->database(); }
  public function closeDB(){ $this->db->close(); }

  public function rechk_permission_cg(){
    $user = $this->session->userdata('user');
    date_default_timezone_set("Asia/Bangkok");
    $this->db->distinct();
    $this->db->select('LMS_COS_DETAIL.cos_id');
    $this->db->from('LMS_COS_DETAIL');
    $this->db->join('LMS_COS_DETAIL_UG','LMS_COS_DETAIL.cosde_id = LMS_COS_DETAIL_UG.cosde_id');
    $this->db->where('LMS_COS_DETAIL_UG.ug_id',$user['ug_id']);
    $this->db->where('LMS_COS_DETAIL.status', '1' );
      $where = "((LMS_COS_DETAIL.date_start <= '".date('Y-m-d H:i')."' and LMS_COS_DETAIL.date_end >='".date('Y-m-d H:i')."') OR (LMS_COS_DETAIL.date_start = '0000-00-00 00:00:00' and LMS_COS_DETAIL.date_end = '0000-00-00 00:00:00'))";
      $this->db->where($where);
    $query = $this->db->get();
    $fetch = $query->result_array();
    $cg_id = array();
    if(count($fetch)>0){
      foreach ($fetch as $key => $value) {
          $this->db->select('cg_id');
          $this->db->from('LMS_COSINCG');
          $this->db->where('course_id',$value['cos_id']);
          $this->db->where('status_cg','1');
          $query_cos = $this->db->get();
          $row_cos = $query_cos->row_array();
          if(count($row_cos)>0){
            if(!in_array($row_cos['cg_id'], $cg_id)){
              array_push($cg_id, $row_cos['cg_id']);
            }
          }
      }
    }
    return $cg_id;
  }
  public function rechk_permission_course_people(){
    $user = $this->session->userdata('user');
    date_default_timezone_set("Asia/Bangkok");
    $this->db->distinct();
    $this->db->select('LMS_COS_DETAIL.cos_id');
    $this->db->from('LMS_COS_DETAIL');
    $this->db->join('LMS_COS_DETAIL_UG','LMS_COS_DETAIL.cosde_id = LMS_COS_DETAIL_UG.cosde_id');
    $this->db->where('LMS_COS_DETAIL_UG.ug_id',$user['ug_id']);
    $this->db->where('LMS_COS_DETAIL.status', '1' );
      $where = "((LMS_COS_DETAIL.date_start <= '".date('Y-m-d H:i')."' and LMS_COS_DETAIL.date_end >='".date('Y-m-d H:i')."') OR (LMS_COS_DETAIL.date_start = '0000-00-00 00:00:00' and LMS_COS_DETAIL.date_end = '0000-00-00 00:00:00'))";
      $this->db->where($where);
    $query = $this->db->get();
    $fetch = $query->result_array();
    $cg_id = array();
    if(count($fetch)>0){
      foreach ($fetch as $key => $value) {
              array_push($cg_id, $value['cos_id']);
      }
    }
    return $cg_id;
  }
  public function rechk_permission_cos(){
    $user = $this->session->userdata('user');
    date_default_timezone_set("Asia/Bangkok");
    $this->db->distinct();
    $this->db->select('LMS_COS_DETAIL.cos_id');
    $this->db->from('LMS_COS_DETAIL');
    $this->db->where('LMS_COS_DETAIL.status', '1' );
      $where = "((LMS_COS_DETAIL.date_start <= '".date('Y-m-d H:i')."' and LMS_COS_DETAIL.date_end >='".date('Y-m-d H:i')."') OR (LMS_COS_DETAIL.date_start = '0000-00-00 00:00:00' and LMS_COS_DETAIL.date_end = '0000-00-00 00:00:00'))";
      $this->db->where($where);
    $query = $this->db->get();
    $fetch = $query->result_array();
    $cg_id = array();
    if(count($fetch)>0){
      foreach ($fetch as $key => $value) {
              array_push($cg_id, $value['cos_id']);
      }
    }
    return $cg_id;
  }
  public function getAllCoursegroup( $wg_id = "" , $txt_search = ""){
    $user = $this->session->userdata('user');
    date_default_timezone_set("Asia/Bangkok");
    $ar_return = array();
    if($user['com_admin']=="CUSTOMER"||$user['Is_admin']=="0"){
      $this->db->from('LMS_WKG');
      $this->db->order_by('c_date', 'ASC');
      $this->db->where('wstatus', '1' );
      $this->db->where('com_id', $user['com_id'] );
      $query_loop = $this->db->get();
      $fetch_loop = $query_loop->result_array();
      foreach ($fetch_loop as $key) {
          $this->db->from('LMS_COG');
          $this->db->where('wg_id', $key['id'] );
          $this->db->where('cg_status', '1' );
          if($txt_search!=""){
            $where = "(cgtitle_th like '%".$txt_search."%' OR cgtitle_en like '%".$txt_search."%')";
            $this->db->where($where);
          }
          $this->db->order_by('c_date', 'ASC');
          $query = $this->db->get();
          $ar = $query->result_array();
          if(count($ar)>0){
            foreach ($ar as $key => $value) {
            array_push($ar_return, $ar[$key]);
            }
          }
      }
    }else{
      $this->db->from('LMS_COG');
      $this->db->where('cg_status', '1' );
      if( $wg_id != "" ){
        $this->db->where('wg_id', $wg_id );
      }
      if($txt_search!=""){
        $where = "(cgtitle_th like '%".$txt_search."%' OR cgtitle_en like '%".$txt_search."%')";
        $this->db->where($where);
      }
      $this->db->order_by('c_date', 'ASC');
      $query = $this->db->get();
      $ar_return = $query->result_array();
    }
    
    return $ar_return;
  }

  public function create_coursegroup($data)
  {
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');
          $this->db->from('LMS_COG');
          $this->db->where('wg_id', $data['wg_id']);
          $this->db->where('cgcode', $data['cgcode']);
          $this->db->where('cgtitle_th', $data['cgtitle_th']);
          $this->db->where('cgtitle_en', $data['cgtitle_en']);
          $this->db->where('cg_status', '1');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $data['c_date'] = date("Y-m-d H:i");
            $data['c_by'] = $user['emp_c'];
            $this->db->insert('LMS_COG', $data);
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

  public function update_coursegroup($data,$id)
  {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('id', $id);
          
          	if ($this->db->update('LMS_COG', $data)) {
			    return "2";
			}else{
				return "0";
			}
  }


  public function rechkUsecoursegroup( $id ){
    $this->db->from('LMS_COSINCG');
    $this->db->where('cg_id', $id );
    $this->db->where('status_cg', '1' );
    $query = $this->db->get();
    return $query->result_array();
  }
}
