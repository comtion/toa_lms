<?php
class Quizex_model extends CI_Model {
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

  public function create_quiz_ex($data){
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');
          $this->db->from('LMS_QIZ_EXP');
          $this->db->where('qize_name_th', $data['qize_name_th']);
          $this->db->where('qize_name_eng', $data['qize_name_eng']);
          $this->db->where('qize_name_jp', $data['qize_name_jp']);
          $this->db->where('com_id', $data['com_id']);
          $this->db->where('LMS_QIZ_EXP.qize_isDelete','0');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_QIZ_EXP', $data);
            return "2";
          }else{
            return "1";
          }
  }

  public function update_quiz_ex($data,$qize_id)
  {
      date_default_timezone_set("Asia/Bangkok");
      $this->db->where('qize_id', $qize_id);
      $this->db->update('LMS_QIZ_EXP', $data);
      return "2";
  }


        public function fetch_data_quizex($com_id) {
          $user = $this->session->userdata('user');
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $this->db->from('LMS_QIZ_EXP');
          $this->db->join('LMS_COMPANY','LMS_QIZ_EXP.com_id = LMS_COMPANY.com_id');
          $this->db->where('LMS_QIZ_EXP.qize_isDelete','0');
          $arr['page'] = "quiz/create_template";
          $this->db->where('LMS_QIZ_EXP.com_id',$com_id);
          $query = $this->db->get();
          $fetch = $query->result_array();
          $num = 1;$count = 0;
          $fetch_arr = array();

          $arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
          $arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
          foreach ($fetch as $key => $value) {
              $output = array();
              $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            $qize_lang = explode(',', $value['qize_lang']);
            $qize_lang_txt = "";
            /*if(count($qize_lang)==3){
              $qize_lang_txt = label('all_lang');
            }else{
              $numloop = 1;
              for ($i=0; $i < count($qize_lang); $i++) { 
                if($qize_lang[$i]=="eng"){
                  $qize_lang_txt .= "EN";
                }else if($qize_lang[$i]=="th"){
                  $qize_lang_txt .= "TH";
                }else{
                  $qize_lang_txt .= "JP";
                }
                if($numloop<count($qize_lang)){
                  $qize_lang_txt .= ",";
                }
                $numloop++;
              }*/
                if($value['qize_name_eng']!=""){
                  $qize_lang_txt .= "EN";
                }
                if($value['qize_name_th']!=""){
                  if($qize_lang_txt!=""){
                    $qize_lang_txt .= ",";
                  }
                  $qize_lang_txt .= "TH";
                }
                if($value['qize_name_jp']!=""){
                  if($qize_lang_txt!=""){
                    $qize_lang_txt .= ",";
                  }
                  $qize_lang_txt .= "JP";
                }
            //}
              $output['2'] = $qize_lang_txt;

            if($lang=="thai"){ 
              $qize_name = $value['qize_name_th']!=""?$value['qize_name_th']:$value['qize_name_eng'];
              $qize_name = $qize_name!=""?$qize_name:$value['qize_name_jp'];
              $output['3'] = $qize_name; 
              $output['4'] = $value['com_name_th'];
            }else if($lang=="english"){ 
              $qize_name = $value['qize_name_eng']!=""?$value['qize_name_eng']:$value['qize_name_th'];
              $qize_name = $qize_name!=""?$qize_name:$value['qize_name_jp'];
              $output['3'] = $qize_name; 
              $output['4'] = $value['com_name_eng'];
            }else{
              $qize_name = $value['qize_name_jp']!=""?$value['qize_name_jp']:$value['qize_name_eng'];
              $qize_name = $qize_name!=""?$qize_name:$value['qize_name_th'];
              $output['3'] = $qize_name; 
              $output['4'] = $value['com_name_eng'];
            }
              if($lang=="thai"){
              $output['5'] = $value['qize_modifieddate']!="0000-00-00 00:00:00"?date('d/m/',strtotime($value['qize_modifieddate'])).(date('Y',strtotime($value['qize_modifieddate']))+543)." ".date('H:i',strtotime($value['qize_modifieddate'])):"<center>-</center>";
              }else{
              $output['5'] = $value['qize_modifieddate']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['qize_modifieddate'])):"<center>-</center>";
              }
                  $update = '<button type="button" name="update_quiz" id="'.$value['qize_id'].'" title="'.label('sedit').'" class="btn btn-warning btn-xs update_quiz"><i class="mdi mdi-lead-pencil"></i></button>';
                  $delete = '<button type="button" name="delete_quiz" id="'.$value['qize_id'].'" class="btn btn-danger btn-xs delete_quiz" title="'.label('sdelete').'"><i class="mdi mdi-window-close"></i></button>';
                  if($arr['btn_update']!="1"){
                    $update = '';
                  }
                  if($arr['btn_delete']!="1"){
                    $delete = '';
                  }
              $output['0'] = "<center>".'<button type="button" name="quiz_detail" id="'.$value['qize_id'].'" title="'.label('question').'" class="btn btn-info btn-xs quiz_detail"><i class="mdi mdi-comment-question-outline"></i></button>'.$update."</center>";
              $output['6'] = "<center>".$delete."</center>";
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }



        public function fetch_course_question($user,$qize_id) {
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $arr['page'] = "quiz/create_template";
          $this->manage->loadDB();
          $fetch = $this->func_query->query_result('LMS_QUESE','','','','qize_id="'.$qize_id.'" and quese_isDelete="0"');
          $num = 1;$count = 0;
          $fetch_arr = array();
          $arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
          $arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
          foreach ($fetch as $key => $value) {
              $output = array();
              $output['3'] = "";
              if($value['quese_type']=="sa"){
                $output['1'] = label('qt_sa');
              }else if($value['quese_type']=="sub"){
                $output['1'] = label('qt_sub');
              }else if($value['quese_type']=="scale"){
                $output['1'] = label('qt_scale');
              }else if($value['quese_type']=="2choice"){
                $output['1'] = label('qt_twoChoice');
                $fetch_mul = $this->func_query->query_result('LMS_QUESE_MUL','','','','quese_id="'.$value['quese_id'].'"');
                if(count($fetch_mul)>0){
                  foreach ($fetch_mul as $key_mul => $value_mul) {
                      if($lang=="thai"){ 
                        $mule_c1 = $value_mul['mule_c1_th']!=""?$value_mul['mule_c1_th']:$value_mul['mule_c1_eng'];
                        $mule_c1 = $mule_c1!=""?$mule_c1:$value_mul['mule_c1_jp'];
                        $mule_c2 = $value_mul['mule_c2_th']!=""?$value_mul['mule_c2_th']:$value_mul['mule_c2_eng'];
                        $mule_c2 = $mule_c2!=""?$mule_c2:$value_mul['mule_c2_jp'];
                      }else if($lang=="english"){ 
                        $mule_c1 = $value_mul['mule_c1_eng']!=""?$value_mul['mule_c1_eng']:$value_mul['mule_c1_th'];
                        $mule_c1 = $mule_c1!=""?$mule_c1:$value_mul['mule_c1_jp'];
                        $mule_c2 = $value_mul['mule_c2_eng']!=""?$value_mul['mule_c2_eng']:$value_mul['mule_c2_th'];
                        $mule_c2 = $mule_c2!=""?$mule_c2:$value_mul['mule_c2_jp'];
                      }else{
                        $mule_c1 = $value_mul['mule_c1_jp']!=""?$value_mul['mule_c1_jp']:$value_mul['mule_c1_eng'];
                        $mule_c1 = $mule_c1!=""?$mule_c1:$value_mul['mule_c1_th'];
                        $mule_c2 = $value_mul['mule_c2_jp']!=""?$value_mul['mule_c2_jp']:$value_mul['mule_c2_eng'];
                        $mule_c2 = $mule_c2!=""?$mule_c2:$value_mul['mule_c2_th'];
                      }
                      if($mule_c1!=""){
                        $output['3'] .= "1.".strip_tags($mule_c1)."<br>";
                      }
                      if($mule_c2!=""){
                        $output['3'] .= "2.".strip_tags($mule_c2)."<br>";
                      }
                  }
                }
              }else{
                $output['1'] = label('qt_multi');
                $fetch_mul = $this->func_query->query_result('LMS_QUESE_MUL','','','','quese_id="'.$value['quese_id'].'"');
                if(count($fetch_mul)>0){
                  foreach ($fetch_mul as $key_mul => $value_mul) {
                      if($lang=="thai"){ 
                        $mule_c1 = $value_mul['mule_c1_th']!=""?$value_mul['mule_c1_th']:$value_mul['mule_c1_eng'];
                        $mule_c1 = $mule_c1!=""?$mule_c1:$value_mul['mule_c1_jp'];
                        $mule_c2 = $value_mul['mule_c2_th']!=""?$value_mul['mule_c2_th']:$value_mul['mule_c2_eng'];
                        $mule_c2 = $mule_c2!=""?$mule_c2:$value_mul['mule_c2_jp'];
                        $mule_c3 = $value_mul['mule_c3_th']!=""?$value_mul['mule_c3_th']:$value_mul['mule_c3_eng'];
                        $mule_c3 = $mule_c3!=""?$mule_c3:$value_mul['mule_c3_jp'];
                        $mule_c4 = $value_mul['mule_c4_th']!=""?$value_mul['mule_c4_th']:$value_mul['mule_c4_eng'];
                        $mule_c4 = $mule_c4!=""?$mule_c4:$value_mul['mule_c4_jp'];
                        $mule_c5 = $value_mul['mule_c5_th']!=""?$value_mul['mule_c5_th']:$value_mul['mule_c5_eng'];
                        $mule_c5 = $mule_c5!=""?$mule_c5:$value_mul['mule_c5_jp'];
                      }else if($lang=="english"){ 
                        $mule_c1 = $value_mul['mule_c1_eng']!=""?$value_mul['mule_c1_eng']:$value_mul['mule_c1_th'];
                        $mule_c1 = $mule_c1!=""?$mule_c1:$value_mul['mule_c1_jp'];
                        $mule_c2 = $value_mul['mule_c2_eng']!=""?$value_mul['mule_c2_eng']:$value_mul['mule_c2_th'];
                        $mule_c2 = $mule_c2!=""?$mule_c2:$value_mul['mule_c2_jp'];
                        $mule_c3 = $value_mul['mule_c3_eng']!=""?$value_mul['mule_c3_eng']:$value_mul['mule_c3_th'];
                        $mule_c3 = $mule_c3!=""?$mule_c3:$value_mul['mule_c3_jp'];
                        $mule_c4 = $value_mul['mule_c4_eng']!=""?$value_mul['mule_c4_eng']:$value_mul['mule_c4_th'];
                        $mule_c4 = $mule_c4!=""?$mule_c4:$value_mul['mule_c4_jp'];
                        $mule_c5 = $value_mul['mule_c5_eng']!=""?$value_mul['mule_c5_eng']:$value_mul['mule_c5_th'];
                        $mule_c5 = $mule_c5!=""?$mule_c5:$value_mul['mule_c5_jp'];
                      }else{
                        $mule_c1 = $value_mul['mule_c1_jp']!=""?$value_mul['mule_c1_jp']:$value_mul['mule_c1_eng'];
                        $mule_c1 = $mule_c1!=""?$mule_c1:$value_mul['mule_c1_th'];
                        $mule_c2 = $value_mul['mule_c2_jp']!=""?$value_mul['mule_c2_jp']:$value_mul['mule_c2_eng'];
                        $mule_c2 = $mule_c2!=""?$mule_c2:$value_mul['mule_c2_th'];
                        $mule_c3 = $value_mul['mule_c3_jp']!=""?$value_mul['mule_c3_jp']:$value_mul['mule_c3_eng'];
                        $mule_c3 = $mule_c3!=""?$mule_c3:$value_mul['mule_c3_th'];
                        $mule_c4 = $value_mul['mule_c4_jp']!=""?$value_mul['mule_c4_jp']:$value_mul['mule_c4_eng'];
                        $mule_c4 = $mule_c4!=""?$mule_c4:$value_mul['mule_c4_th'];
                        $mule_c5 = $value_mul['mule_c5_jp']!=""?$value_mul['mule_c5_jp']:$value_mul['mule_c5_eng'];
                        $mule_c5 = $mule_c5!=""?$mule_c5:$value_mul['mule_c5_th'];
                      }
                      if($mule_c1!=""){
                        $output['3'] .= "1.".strip_tags($mule_c1)."<br>";
                      }
                      if($mule_c2!=""){
                        $output['3'] .= "2.".strip_tags($mule_c2)."<br>";
                      }
                      if($mule_c3!=""){
                        $output['3'] .= "3.".strip_tags($mule_c3)."<br>";
                      }
                      if($mule_c4!=""){
                        $output['3'] .= "4.".strip_tags($mule_c4)."<br>";
                      }
                      if($mule_c5!=""){
                        $output['3'] .= "5.".strip_tags($mule_c5)."<br>";
                      }
                  }
                }
              }
                  if($lang=="thai"){ 
                    $quese_name = $value['quese_name_th']!=""?$value['quese_name_th']:$value['quese_name_eng'];
                    $quese_name = $quese_name!=""?$quese_name:$value['quese_name_jp'];
                  }else if($lang=="english"){ 
                    $quese_name = $value['quese_name_eng']!=""?$value['quese_name_eng']:$value['quese_name_th'];
                    $quese_name = $quese_name!=""?$quese_name:$value['quese_name_jp'];
                  }else{
                    $quese_name = $value['quese_name_jp']!=""?$value['quese_name_jp']:$value['quese_name_eng'];
                    $quese_name = $quese_name!=""?$quese_name:$value['quese_name_th'];
                  }
                $output['2'] = $quese_name;
                  $update = '<button type="button" name="update_ques" id="'.$value['quese_id'].'" title="'.label('sedit').'" class="btn btn-warning btn-xs update_ques"><i class="mdi mdi-lead-pencil"></i></button>';
                  $delete = '<button type="button" name="delete_ques" id="'.$value['quese_id'].'" class="btn btn-danger btn-xs delete_ques" title="'.label('sdelete').'"><i class="mdi mdi-window-close"></i></button>';

                  if($arr['btn_update']!="1"){
                    $update = '';
                  }
                  if($arr['btn_delete']!="1"){
                    $delete = '';
                  }
              $output['0'] = "<center>".$update."</center>";
              $output['4'] = "<center>".$delete."</center>";
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }



  public function create_question($data)
  {
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');

          $this->load->model('Function_query_model', 'func_query', FALSE);
                    $where_ques = "";
                    if($data['quese_name_th']!=""){
                      $where_ques .= "quese_name_th = '".htmlentities($data['quese_name_th'])."'";
                    }
                    if($data['quese_name_eng']!=""){
                       if($where_ques!=""){
                        $where_ques .= ' and ';
                       }
                      $where_ques .= "quese_name_eng = '".htmlentities($data['quese_name_eng'])."'";
                    }
                    if($data['quese_name_jp']!=""){
                       if($where_ques!=""){
                        $where_ques .= ' and ';
                       }
                      $where_ques .= "quese_name_jp = '".htmlentities($data['quese_name_jp'])."'";
                    }
          $where = 'qize_id="'.$data['qize_id'].'" and ('.$where_ques.') and quese_isDelete="0"';
          $fetch_chk = $this->func_query->numrows('LMS_QUESE','','','',$where);
          if($fetch_chk==0){
            $this->db->insert('LMS_QUESE', $data);
            $id = $this->db->insert_id();
          }
          return $id;
  }
  
  public function create_question_multi($data)
  {
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');
          $this->db->from('LMS_QUESE_MUL');
          $this->db->where('quese_id', $data['quese_id']);
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_QUESE_MUL', $data);
          }else{
            $this->db->where('quese_id', $data['quese_id']);
            $this->db->update('LMS_QUESE_MUL', $data);
          }
  }
  public function update_question($data,$quese_id)
  {
      $this->db->where('quese_id', $quese_id);
      $this->db->update('LMS_QUESE', $data);
  }

}
?>
