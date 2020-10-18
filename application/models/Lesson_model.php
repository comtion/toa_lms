<?php
class Lesson_model extends CI_Model {
  public function __construct()
  {
    // Call the CI_Model constructor
    parent::__construct();
  }

    /*These Function is Open/Close the database.*/
    public function loadDB(){
      $this->load->database();
    }

    public function closeDB(){
      $this->db->close();
    }

    private function updateStatus()
    {
      $this->db->select('id, lcode, time_start, time_end, hidden');
      $this->db->from('LMS_LES');
      $query = $this->db->get();
      $current_time = date('Y-m-d H:i');
      foreach ($query->result_array() as $row) {
        if($current_time >= $row['time_start'] && $current_time < $row['time_end'] || $row['time_end'] == '0000-00-00 00:00:00'){
          $data = array(
            'hidden' => 1
          );
        } else {
          $data = array(
            'hidden' => 0
          );
        }
        $this->db->where('lcode', $row['lcode']);
        $this->db->update('LMS_LES', $data);
      }
    }

    private function updateStatus_course($courses_id = '')
    {
      $this->db->select('id, lcode, time_start, time_end, hidden');
      $this->db->from('LMS_LES');
      $this->db->where('courses_id',$courses_id);
      $query = $this->db->get();
      $current_time = date('Y-m-d H:i');
      foreach ($query->result_array() as $row) {
        if($current_time >= $row['time_start'] && $current_time < $row['time_end'] || $row['time_end'] == '0000-00-00 00:00:00'){
          $data = array(
            'hidden' => 1
          );
        } else {
          $data = array(
            'hidden' => 0
          );
        }
        $this->db->where('lcode', $row['lcode']);
        $this->db->update('LMS_LES', $data);
      }
    }

    public function edit($data)
    {
      $this->db->set('time_mod', 'NOW()', FALSE);
      $this->db->update('LMS_LES', $data, array('lcode' => $data['lcode'], 'lang' => $data['lang']));
    }

    public function create($data){
      $this->db->set('time_create', 'NOW()', FALSE);
      $this->db->set('time_mod', 'NOW()', FALSE);
      $this->db->insert('LMS_LES', $data);
    }

    private function delete($code, $table)
    {
      $table = strtoupper($table);
      $table == 'LMS_LES' ? $this->db->where('lcode', $code) :$this->db->where('lessons_id', $code);
      $this->db->delete($table);
    }

    public function deleteLesson($lcode)
    {
      $this->delete($lcode, 'LMS_MED');
      $this->delete($lcode, 'LMS_FIL');
      $this->delete($lcode, 'LMS_LES_TC');
      $this->delete($lcode, 'LMS_LES');
    }

    public function getAllData( $code )
    {
      $this->db->from('LMS_LES');
      $this->db->where('lcode', $code);
      $query = $this->db->get();
      $rows = $query->result_array();
      foreach ($rows as $row) {
        $result[$row['lang']] = $row ;
      }
      return $result;
    }

    public function getCode()
    {
      $this->db->select_max('lcode');
      $this->db->from('LMS_LES');
      $query = $this->db->get();
      $row = $query->row();

      return ($row->lcode) == '' ? 1 : ($row->lcode) + 1;
    }

    public function getAllLesson($ccode, $lang)
    {
      $user = $this->session->userdata('user');
      if (!in_array($user['role'], array("superadmin","admintis","admindealer","adminzone", "admin", "manager"))){
        $this->db->from('LMS_ENS');
        $this->db->where('emp_c', $user['emp_c']);
        $this->db->where('course_id', $ccode);
        $query = $this->db->get();
        $result = $query->result_array();
        if ($query->num_rows() > 0) {
          $this->updateStatus_course($ccode);
          $this->db->distinct();
          $this->db->select('lcode,les_name,lang');
          $this->db->from('LMS_LES');
          $this->db->where('courses_id', $ccode);
          $this->db->where('lang', $lang);
          $this->db->where('hidden', '1');
          $this->db->order_by('lcode', 'ASC');
          $query = $this->db->get();
          $result = $query->result_array();
          if ($query->num_rows() > 0) {
            foreach ($result as $key => $row) {
              $result[$key]['isScorm'] = $this->isScorm($row['lcode']);
            }
          }
        }
      }else{
          $this->updateStatus_course($ccode);
          $this->db->distinct();
          $this->db->select('lcode,les_name,lang');
          $this->db->from('LMS_LES');
          $this->db->where('courses_id', $ccode);
          $this->db->where('lang', $lang);
          $this->db->where('hidden', '1');
          $this->db->order_by('lcode', 'ASC');
          $query = $this->db->get();
          $result = $query->result_array();
          if ($query->num_rows() > 0) {
            foreach ($result as $key => $row) {
              $result[$key]['isScorm'] = $this->isScorm($row['lcode']);
            }
          }
      }
      return $result;
    }


    public function count_leason($ccode, $lang)
    {
                    $this->db->from('LMS_LES');
                    $this->db->where('courses_id', $ccode);
                    $this->db->where('lang', $lang);
                    $this->db->where('hidden', '1');
                    $this->db->order_by('lcode', 'ASC');
                    $query = $this->db->get();
                    $result = $query->result_array();
                    return $query->num_rows();
    }

    public function getCcode($lcode)
    {
      $this->db->select('courses_id');
      $this->db->distinct();
      $this->db->from('LMS_LES');
      $this->db->where('lcode', $lcode);
      $query = $this->db->get();
      $result = $query->result_array();
      return $query->num_rows() > 0 ? $result[0]['courses_id'] : FALSE;
    }

    public function getLessLang($lcode)
    {
      $this->db->select('lang');
      $this->db->from('LMS_LES');
      $this->db->where('lcode', $lcode);
      $query = $this->db->get();
      $result = $query->result_array();

      $lang = $this->session->userdata("lang") == null ? "thailand" : $this->session->userdata("lang") ;
      foreach ($result as $each) {
        $lang = $each['lang'];
      }
      return $lang;
    }

    public function getLesson($lcode, $lang)
    {
      $this->updateStatus();
      $this->db->from('LMS_LES');
      $this->db->where('lcode', $lcode);
      $this->db->where('lang', $lang);
      $this->db->where('hidden', 1);
      $query = $this->db->get();
      if ($query->num_rows() > 0){
        $result = $query->result_array();
        return $result[0];
      }
      return FALSE;
    }

    public function getLessons($lcode)
    {
      $this->updateStatus();
      $this->db->from('LMS_LES');
      $this->db->where('lcode', $lcode);
      $query = $this->db->get();
      if ($query->num_rows() > 0){
        $result = $query->result_array();
        $lessons = array();
        foreach ($result as $row) {
          $lessons[$row['lang']] = $row;
        }
        return $lessons;
      }
    }

    public function getNextLess($lessons, $lcode)
    {
      $flag = FALSE;
      $next = 'none';
      //print_r($lessons);
  		foreach ($lessons as $key=>$lesson) {
        if ($flag) {
          $next = $lesson;
          break;
        }
  			($lesson['lcode'] != $lcode)?: $flag = TRUE;
  		}
      return $next;
    }
    public function getBackLess($lessons, $lcode)
    {
      $flag = FALSE;
      $back = 'none';
      //print_r($lessons);
  		foreach ($lessons as $key=>$lesson) {
  			($lesson['lcode'] != $lcode)? : $flag = TRUE;
        if ($flag) {
          if( ($key-1) >= 0 ){
            $back = $lessons[$key-1];
            break;
          }else{
            break;
          }
        }
  		}
      return $back;
    }

    private function getLangs()
    {
      $this->db->from('LMS_LAG');
      $query = $this->db->get();
      return $query->result_array();
    }

    public function createTC($data)
    {
        $this->db->from('LMS_LES_TC');
        $this->db->where('LMS_LES_TC.les_id', $data['les_id']);
        $this->db->where('LMS_LES_TC.emp_id', $data['emp_id']);
        $query = $this->db->get();
        $result = $query->result_array();
        if ($query->num_rows() == 0){
          $this->db->from('LMS_LES');
          $this->db->where('les_id',$data['les_id']);
          $query_les = $this->db->get();
          $fetch_les =$query_les->row_array();
          $this->db->select('LMS_LOG_ENROLL.id_log');
          $this->db->from('LMS_COS_ENROLL');
          $this->db->join('LMS_LOG_ENROLL','LMS_COS_ENROLL.cosen_id=LMS_LOG_ENROLL.cosen_id');
          $this->db->where('emp_id',$data['emp_id']);
          $this->db->where('cos_id',$fetch_les['cos_id']);
          $query_chk = $this->db->get();
          $fetch_chk = $query_chk->row_array();
          $data['id_log'] = $fetch_chk['id_log'];
          $this->db->insert('LMS_LES_TC', $data);
        }
    }

    public function getAllStatus($lessons, $emp_c)
    {
      $allStatus = array();
      foreach ($lessons as $lesson) {
        $allStatus[$lesson['lcode']] = $this->getLearnStatus($lesson, $emp_c);
      }
      return $allStatus;
    }

    private function getLearnStatus($lesson, $emp_c)
    {
      $this->db->select('learn_status');
      $this->db->from('LMS_LES_TC');
      $this->db->where('lessons_id', $lesson['lcode']);
      $this->db->where('emp_c', $emp_c);
      $this->db->where('lang', $lesson['lang']);
      $query = $this->db->get();
      $result = $query->result_array();
      if ($query->num_rows() > 0)
        return $result[0]['learn_status'];
      return 'noProgress';
    }

    public function checkCode($code)
    {
      $this->db->select('id');
      $this->db->from('LMS_LES');
      $this->db->where('lcode', $code);
      $query = $this->db->get();
      return $query->num_rows() > 0 ? TRUE: FALSE;
    }

    public function createMed($data)
    {
      foreach ($data as $each) {
        $this->db->insert('LMS_MED', $each);
      }
    }

    public function createFil($data)
    {
      foreach ($data as $each) {
        $this->db->insert('LMS_FIL', $each);
      }
    }

    public function update_log_fil($id,$emp_c)
    {
          $this->db->select('LMS_EMP.id');
          $this->db->from('LMS_EMP');
          $this->db->where('LMS_EMP.emp_c', $emp_c);
          $query = $this->db->get();
          $fetch=$query->row_array();

          $this->db->select('LMS_LOG_ENROLL.id_log');
          $this->db->from('LMS_COS_ENROLL');
          $this->db->join('LMS_LOG_ENROLL','LMS_COS_ENROLL.cosen_id=LMS_LOG_ENROLL.cosen_id');
          $this->db->where('emp_id',$emp_c);
          $this->db->where('cos_id',$result[0]['cos_id']);
          $query_chk = $this->db->get();
          $fetch_chk = $query_chk->row_array();
          $data = array(
            'fil_id' => $id,
            'emp_id' => $fetch['id'],
            'id_log' => $fetch_chk['id_log']
          );
          $this->db->insert('LMS_FIL_LOG', $data);
    }

    public function editFil($data, $lcode)
    {
      $this->db->where('lessons_id', $lcode);
      $this->db->delete('LMS_FIL');
      $this->createFil($data);
    }

    public function editMed($data, $lcode)
    {
      $this->db->where('lessons_id', $lcode);
      $this->db->delete('LMS_MED');
      $this->createMed($data);
    }

    public function getMedia($lcode)
    {
      $this->db->from('LMS_MED');
      $this->db->where('lessons_id', $lcode);
      $query = $this->db->get();
      return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

    public function countrow_fillog($fil_id)
    {
      $this->db->from('LMS_FIL_LOG');
      $this->db->where('fil_id', $fil_id);
      $query = $this->db->get();
      return $query->num_rows();
    }

    public function countrow_fillog_detail($fil_id,$emp_id)
    {
      $this->db->from('LMS_FIL_LOG');
      $this->db->where('fil_id', $fil_id);
      $this->db->where('emp_id', $emp_id);
      $query = $this->db->get();
      return $query->num_rows();
    }

function query_org($number,$code){
  $this->db->from('LMS_ORG'.$number);
  $this->db->where('code', $code);
  $query = $this->db->get();
  $fetch=$query->row_array();
  return $fetch['name'];
}


      function fetch_report_status($id,$lang){
        $this->db->select('LMS_EMP.emp_c,LMS_EMP.fname,LMS_EMP.lname,LMS_EMP.prefix,LMS_EMP.org1,LMS_EMP.org2,LMS_EMP.org3,LMS_FIL_LOG.emp_id');
        $this->db->distinct();
        $this->db->join('LMS_FIL_LOG', 'LMS_FIL_LOG.emp_id = LMS_EMP.id');
        $this->db->from('LMS_EMP');
        $this->db->where('LMS_FIL_LOG.fil_id', $id);
        $this->db->where('LMS_EMP.lang', $lang);
        $query = $this->db->get();
        $row = $query->row_array();
        $result = $query->result_array();

        $data = array();
        $num = 1;
        foreach ($result as $each) {
          $numcount = $this->countrow_fillog_detail($id,$each['emp_id']);
          $org1 =$this->query_org('1',$each['org1']);
          $org2 =$this->query_org('2',$each['org2']);
          $org3 =$this->query_org('3',$each['org3']);
          $output = array(
              $num,
              $each['prefix'].$each['fname']." ".$each['lname'],
              $org1,
              $org2,
              $org3,
              number_format($numcount)
          );
          array_push($data, $output);
          $num++;
        }
        return $data;
      }

    public function getFiles($lcode)
    {
      $this->db->from('LMS_FIL');
      $this->db->where('lessons_id', $lcode);
      $query = $this->db->get();
      $fetch = $query->result_array();
      return $fetch;
    }

    public function countTC($trans)
    {
      $count = 0;
      foreach ($trans as $each) {
        ($each != 'done') ? : $count++;
      }
      return (count($trans) == $count && $count != 0) ? 'true': (($count > 0)? "half": 'false');
    }

    public function isScorm($lcode)
    {
      $this->db->from('LMS_SCM');
      $this->db->where('lcode', $lcode);
      $query = $this->db->get();

      return ($query->num_rows() > 0);
    }

    public function getTC($data)
    {
      $this->db->select("emp_c, lessons_id, learn_video, learn_status, lang");
      $this->db->from('LMS_LES_TC');
      $this->db->where($data);
      $query = $this->db->get();
      $result = $query->result_array();

      foreach ($result as $row) {
        if (strpos($row['learn_video'], 'no')){
          $row['learn_video'] = 0;
        }
        $row['learn_video'] = (intval($row['learn_video']));
      }
      return $result;
    }

    public function updateTrans($data)
    {
      $data = $this->getTC($data);
      foreach ($data as $row) {
        $row['learn_video']++;
        $this->updateTc($row);
      }
    }

    public function updateTc($data)
    {
      $count = $this->countAllMedia($data['lessons_id']);
      if ($data['learn_video'] >= $count){
        $data['learn_video'] = $count;
        $data['learn_status'] = 'done';
      }
      $this->db->where('lessons_id', $data['lessons_id']);
      $this->db->where('emp_c', $data['emp_c']);
      $this->db->where('lang', $data['lang']);
      $this->db->update("LMS_LES_TC", $data);
    }

    public function countAllMedia($lcode)
    {
    //  return $this->count('LMS_MED', 'lessons_id', $lcode) + $this->count('LMS_FIL', 'lessons_id', $lcode);//
      return $this->count('LMS_MED', 'lessons_id', $lcode);
    }

    public function count($table, $attr, $val)
    {
      $this->db->from($table);
      $this->db->where($attr, $val);
      $query = $this->db->get();
      return $query->num_rows();
    }

    public function update($table, $data)
    {
      $this->db->where('lessons_id', $data['lessons_id']);
      $this->db->where('emp_c', $data['emp_c']);
      $this->db->update($table, $data);
    }

    public function getEditIntro($lcode)
    {
      $this->db->from('LMS_LAG');
      $query = $this->db->get();
      $langs = $query->result_array();
      $editIntro = array();
      foreach ($langs as $row) {
        $lang = $row['lang'];
        if ($this->getLesson($lcode, $lang)){
          array_push($editIntro, $lang);
        }
      }
      return $editIntro;
    }
}
?>
