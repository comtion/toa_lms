<?php
class Pretest_model extends CI_Model {

    public function __construct()
    {
      // Call the CI_Model constructor
      parent::__construct();
    }

    public function loadDB()
    {
      $this->load->database();
    }

    public function closeDB()
    {
      $this->db->close();
    }
    public function createPL($pre_id, $pLv)
    {
      $this->db->where('pre_id', $pre_id);
      $this->db->delete('LMS_PRE_PLV');
      foreach ($pLv as $each) {
        if ($each != 'on'){
          $data = array(
            'pre_id' => $pre_id,
            'org_c' => $each
          );
          $this->db->insert('LMS_PRE_PLV', $data);
        }
      }
    }
    public function checkPlv($pre_id)
    {
      $user = $this->session->userdata("user");
      //print_r($user);
      $this->db->from('LMS_PRE_PLV');
      $this->db->where('pre_id', $pre_id);
      $this->db->where('org_c', $user['plv']);
      $query = $this->db->get();
      return ($query->num_rows() > 0);
    }
    public function insertPretestName($data)
    {
      date_default_timezone_set("Asia/Bangkok");
      $time = date('Y-m-d H:i');
      $data['time_create'] = date("Y-m-d H:i");
      $data['time_mod'] = date("Y-m-d H:i");
      $this->db->insert('LMS_PTN', $data);

      $this->db->select('max(id) as id');
      $this->db->from('LMS_PTN');
      $query = $this->db->get();
      $result = $query->result_array();
      return $result[0]['id'];
    }

    public function updatePretestName($data)
    {
      date_default_timezone_set("Asia/Bangkok");
      $data['time_mod'] =  date("Y-m-d H:i");
      $this->db->where('id', $data['id'])
               ->update('LMS_PTN', $data);
    }

    public function insertPretestQuestion($data)
    {
      date_default_timezone_set("Asia/Bangkok");
      $time = date('Y-m-d H:i');
      $data['time_create'] = date("Y-m-d H:i");
      $data['time_mod'] = date("Y-m-d H:i");
      $this->db->insert('LMS_PTQ', $data);
    }

    public function updatePretestQuestion($data)
    {
      date_default_timezone_set("Asia/Bangkok");
      $time = date('Y-m-d H:i');
      $data['time_mod'] = date("Y-m-d H:i");
      $this->db->where('id', $data['id'])
               ->update('LMS_PTQ', $data);
    }

    public function insertCategoryName($data)
    {
      date_default_timezone_set("Asia/Bangkok");
      $time = date('Y-m-d H:i');
      $data['time_create'] = date("Y-m-d H:i");
      $data['time_mod'] = date("Y-m-d H:i");
      $this->db->insert('LMS_PTC', $data);
    }


    public function getAllEmp( $lang , $org4inzone,$to_select=''){
      $dataReturn = Array();
      //print_r( $allplv );
      $this->load->model('Manage_model', 'manage', FALSE);
      $this->manage->loadDB();
      if($to_select!=''||$org4inzone!=''){
        //print_r($to_select);
        if($to_select!=''){
          foreach ($to_select as $to_sel ) {
                $org = $this->manage->checkOrgStatus($to_sel);
                $select = "LMS_EMP.emp_c,LMS_EMP.prefix,LMS_EMP.fname,LMS_EMP.lname,LMS_EMP.org1,LMS_EMP.org2,LMS_EMP.org3,LMS_EMP.main_pos,LMS_EMP.status";

                $this->db->select($select);
                $this->db->distinct();
                $this->db->join('LMS_POS', 'LMS_POS.pos_code = LMS_EMP.main_pos', 'LEFT');
                if($org4inzone!=''){
                  $this->db->where('LMS_EMP.org4', $org4inzone);
                }
                $this->db->where('LMS_EMP.lang', $lang);

                if ($org=="org1"){
                    $this->db->where('LMS_EMP.org1', $to_sel);
                }else if($org=="org2"){
                    $this->db->where('LMS_EMP.org2', $to_sel);
                }else if($org=="org3"){
                    $this->db->where('LMS_EMP.org3', $to_sel);
                }
                $query = $this->db->get('LMS_EMP');
                $result = $query->result_array();
                foreach( $result as $res ){
                  array_push( $dataReturn, $res );
                }
          }
        }else{
                $select = "LMS_EMP.emp_c,LMS_EMP.prefix,LMS_EMP.fname,LMS_EMP.lname,LMS_EMP.org1,LMS_EMP.org2,LMS_EMP.org3,LMS_EMP.main_pos,LMS_EMP.status";

                $this->db->select($select);
                $this->db->distinct();
                $this->db->join('LMS_POS', 'LMS_POS.pos_code = LMS_EMP.main_pos', 'LEFT');
                if($org4inzone!=''){
                  $this->db->where('LMS_EMP.org4', $org4inzone);
                }
                $this->db->where('LMS_EMP.lang', $lang);
                $query = $this->db->get('LMS_EMP');
                $result = $query->result_array();
                foreach( $result as $res ){
                  array_push( $dataReturn, $res );
                }
        }
      }
          
      return $dataReturn;
    }

    public function getValOrg($numorg = '',$val=''){
      $this->db->select('LMS_ORG'.$numorg.'.name')
               ->from('LMS_ORG'.$numorg)
               ->where('LMS_ORG'.$numorg.'.code',$val);
      $query = $this->db->get();
      $fetch = $query->row_array();
      return $fetch['name'];
    }

      public function fetch_report($lang , $org4inzone,$to_select=''){

          $lang = $this->session->userdata("lang") == null ? "thailand" : $this->session->userdata("lang") ;
          $all_emp = $this->getAllEmp( $lang,$org4inzone,$to_select);
                              
                    
          $data = array();
          $num = 1;
          foreach( $all_emp as $empset ){ 
              $this->db->where('LMS_PTS.emp_c', $empset['emp_c']);
              $this->db->join('LMS_PTN','LMS_PTS.CourseCode = LMS_PTN.pre_code');
              $query = $this->db->get('LMS_PTS');
              $result = $query->result_array();

              //print_r( $result );
              if( sizeof($result) > 0 ){ // check for registered : isRegistered
                foreach( $result as $res ){
                  $output = array(
                      $org4inzone,
                      $this->getValOrg('1',$empset['org1']),
                      $this->getValOrg('2',$empset['org2']),
                      $this->getValOrg('3',$empset['org3']),
                      $empset['emp_c'],
                      $empset['prefix'].$empset['fname']." ".$empset['lname'],
                      $res['TotalScore'],
                      $res['pre_score'],
                      $res['Score01'],
                      $res['Score02'],
                      $res['Score03'],
                      $res['Score04'],
                      $res['Score05'],
                      $res['Score06'],
                      $res['Score07'],
                      $res['Score08'],
                      $res['Score09'],
                      $res['Score10'],
                      date('d/m/Y H:i',strtotime($res['CreateDate']))
                  );

                  array_push($data, $output);
                }
              }

              $num++;
          }
          /*$learnData = $this->getLearningAll( $all_emp_must_learn, $lang );
          $learnData['mustlearn'] = sizeof( $all_emp_must_learn );
          $learnData['company'] = 'ทั้งหมด';*/
          //print_r($data);

        return $data;
      }

    public function setPTNIDforCategoryName($ptn_id,$preCodeOld)
    {
      date_default_timezone_set("Asia/Bangkok");
      $time_mod = date("Y-m-d H:i");
      $this->db->set('ptn_id',$ptn_id)
               ->set('time_mod',$time_mod)
               ->where('pre_code',$preCodeOld)
               ->update('LMS_PTC');
    }

    public function updateCategoryName($data,$ptn_id)
    {
      date_default_timezone_set("Asia/Bangkok");
      $time = date('Y-m-d H:i');
      $data['time_mod'] = date("Y-m-d H:i");
      $this->db->set('pre_code',$data['pre_code'])
               ->set('category_name',$data['category_name'])
               ->where('ptn_id', $ptn_id)
               ->where('category_code',$data['category_code'])
               ->update('LMS_PTC',$data);
    }

    public function updatePTUQ($pre_code,$ptn_id)
    {
      date_default_timezone_set("Asia/Bangkok");
      $time_mod = date("Y-m-d H:i");
      $this->db->set('pre_code',$pre_code)
               ->set('time_mod',$time_mod)
               ->where('ptn_id', $ptn_id)
               ->update('LMS_PTU_Q');
    }

    public function updatePTUN($pre_code,$ptn_id)
    {
      date_default_timezone_set("Asia/Bangkok");
      $time_mod = date("Y-m-d H:i");
      $this->db->set('pre_code',$pre_code)
               ->set('time_mod',$time_mod)
               ->where('ptn_id', $ptn_id)
               ->update('LMS_PTU_N');
    }

    public function updatePTS($pre_code,$ptn_id)
    {
      date_default_timezone_set("Asia/Bangkok");
      $this->db->set('CourseCode',$pre_code)
               ->where('ptn_id', $ptn_id)
               ->update('LMS_PTS');
    }

    function get_data()
    {
        return $this->db->get('LMS_PTN')->result();
    }
    function get_data_array()
    {
        return $this->db->get('LMS_PTN')->result_array();
    }

    function get_ptq($pre_code)
    {
        $this->db->where('pre_code', $pre_code);
        $query = $this->db->get('LMS_PTQ');
        return $query->result();
    }

    function get_pts($pre_code,$emp_c)
    {
        $this->db->where('CourseCode', $pre_code)
                 ->where('emp_c', $emp_c)
                 ->order_by('id','desc')
                 ->limit(1);
        $query = $this->db->get('LMS_PTS');
        return $query->result();
    }

    function get_ptuq($pre_code,$emp_c)
    {
        $this->db->where('pre_code', $pre_code)
                 ->where('emp_c', $emp_c);
        $query = $this->db->get('LMS_PTU_Q');
        return $query->result();
    }

    function get_pretest_name_by_id($id= '')
    {
        $this->db->where('pre_code', $id);
        $query = $this->db->get('LMS_PTN');
        return $query->result();
    }

    function get_pretest_question_by_id($id= '')
    {
      $this->db->select('LMS_PTN.id,LMS_PTN.pre_code,LMS_PTN.pre_name,LMS_PTN.pre_des,LMS_PTN.pre_random, LMS_PTQ.id, LMS_PTQ.pre_code, LMS_PTQ.pre_no, LMS_PTQ.category_code, LMS_PTQ.question, LMS_PTQ.choice1, LMS_PTQ.choice2, LMS_PTQ.choice3, LMS_PTQ.choice4, LMS_PTQ.ans')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->where('LMS_PTQ.pre_code', $id);
      $query = $this->db->get();
      return $query->result();
    }

    function selectQuestionWhereCode_1($id= '')
    {
      $this->db->select('LMS_PTN.id,LMS_PTN.pre_code,LMS_PTN.pre_name,LMS_PTN.pre_des,LMS_PTN.pre_random, LMS_PTQ.id, LMS_PTQ.pre_code, LMS_PTQ.pre_no, LMS_PTQ.category_code, LMS_PTQ.question, LMS_PTQ.choice1, LMS_PTQ.choice2, LMS_PTQ.choice3, LMS_PTQ.choice4, LMS_PTQ.ans')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->where('LMS_PTQ.pre_code', $id)
               ->where('LMS_PTQ.category_code', 1);
      $query = $this->db->get();
      return $query->result();
    }

    function selectQuestionWhereCode_2($id= '')
    {
      $this->db->select('LMS_PTN.id,LMS_PTN.pre_code,LMS_PTN.pre_name,LMS_PTN.pre_des,LMS_PTN.pre_random, LMS_PTQ.id, LMS_PTQ.pre_code, LMS_PTQ.pre_no, LMS_PTQ.category_code, LMS_PTQ.question, LMS_PTQ.choice1, LMS_PTQ.choice2, LMS_PTQ.choice3, LMS_PTQ.choice4, LMS_PTQ.ans')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->where('LMS_PTQ.pre_code', $id)
               ->where('LMS_PTQ.category_code', 2);
      $query = $this->db->get();
      return $query->result();
    }

    function selectQuestionWhereCode_3($id= '')
    {
      $this->db->select('LMS_PTN.id,LMS_PTN.pre_code,LMS_PTN.pre_name,LMS_PTN.pre_des,LMS_PTN.pre_random, LMS_PTQ.id, LMS_PTQ.pre_code, LMS_PTQ.pre_no, LMS_PTQ.category_code, LMS_PTQ.question, LMS_PTQ.choice1, LMS_PTQ.choice2, LMS_PTQ.choice3, LMS_PTQ.choice4, LMS_PTQ.ans')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->where('LMS_PTQ.pre_code', $id)
               ->where('LMS_PTQ.category_code', 3);
      $query = $this->db->get();
      return $query->result();
    }

    function selectQuestionWhereCode_4($id= '')
    {
      $this->db->select('LMS_PTN.id,LMS_PTN.pre_code,LMS_PTN.pre_name,LMS_PTN.pre_des,LMS_PTN.pre_random, LMS_PTQ.id, LMS_PTQ.pre_code, LMS_PTQ.pre_no, LMS_PTQ.category_code, LMS_PTQ.question, LMS_PTQ.choice1, LMS_PTQ.choice2, LMS_PTQ.choice3, LMS_PTQ.choice4, LMS_PTQ.ans')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->where('LMS_PTQ.pre_code', $id)
               ->where('LMS_PTQ.category_code', 4);
      $query = $this->db->get();
      return $query->result();
    }

    function selectQuestionWhereCode_5($id= '')
    {
      $this->db->select('LMS_PTN.id,LMS_PTN.pre_code,LMS_PTN.pre_name,LMS_PTN.pre_des,LMS_PTN.pre_random, LMS_PTQ.id, LMS_PTQ.pre_code, LMS_PTQ.pre_no, LMS_PTQ.category_code, LMS_PTQ.question, LMS_PTQ.choice1, LMS_PTQ.choice2, LMS_PTQ.choice3, LMS_PTQ.choice4, LMS_PTQ.ans')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->where('LMS_PTQ.pre_code', $id)
               ->where('LMS_PTQ.category_code', 5);
      $query = $this->db->get();
      return $query->result();
    }


    function selectQuestionWhereCode_6($id= '')
    {
      $this->db->select('LMS_PTN.id,LMS_PTN.pre_code,LMS_PTN.pre_name,LMS_PTN.pre_des,LMS_PTN.pre_random, LMS_PTQ.id, LMS_PTQ.pre_code, LMS_PTQ.pre_no, LMS_PTQ.category_code, LMS_PTQ.question, LMS_PTQ.choice1, LMS_PTQ.choice2, LMS_PTQ.choice3, LMS_PTQ.choice4, LMS_PTQ.ans')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->where('LMS_PTQ.pre_code', $id)
               ->where('LMS_PTQ.category_code', 6);
      $query = $this->db->get();
      return $query->result();
    }

    function selectQuestionWhereCode_7($id= '')
    {
      $this->db->select('LMS_PTN.id,LMS_PTN.pre_code,LMS_PTN.pre_name,LMS_PTN.pre_des,LMS_PTN.pre_random, LMS_PTQ.id, LMS_PTQ.pre_code, LMS_PTQ.pre_no, LMS_PTQ.category_code, LMS_PTQ.question, LMS_PTQ.choice1, LMS_PTQ.choice2, LMS_PTQ.choice3, LMS_PTQ.choice4, LMS_PTQ.ans')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->where('LMS_PTQ.pre_code', $id)
               ->where('LMS_PTQ.category_code', 7);
      $query = $this->db->get();
      return $query->result();
    }

    function selectQuestionWhereCode_8($id= '')
    {
      $this->db->select('LMS_PTN.id,LMS_PTN.pre_code,LMS_PTN.pre_name,LMS_PTN.pre_des,LMS_PTN.pre_random, LMS_PTQ.id, LMS_PTQ.pre_code, LMS_PTQ.pre_no, LMS_PTQ.category_code, LMS_PTQ.question, LMS_PTQ.choice1, LMS_PTQ.choice2, LMS_PTQ.choice3, LMS_PTQ.choice4, LMS_PTQ.ans')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->where('LMS_PTQ.pre_code', $id)
               ->where('LMS_PTQ.category_code', 8);
      $query = $this->db->get();
      return $query->result();
    }

    function selectQuestionWhereCode_9($id= '')
    {
      $this->db->select('LMS_PTN.id,LMS_PTN.pre_code,LMS_PTN.pre_name,LMS_PTN.pre_des,LMS_PTN.pre_random, LMS_PTQ.id, LMS_PTQ.pre_code, LMS_PTQ.pre_no, LMS_PTQ.category_code, LMS_PTQ.question, LMS_PTQ.choice1, LMS_PTQ.choice2, LMS_PTQ.choice3, LMS_PTQ.choice4, LMS_PTQ.ans')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->where('LMS_PTQ.pre_code', $id)
               ->where('LMS_PTQ.category_code', 9);
      $query = $this->db->get();
      return $query->result();
    }

    function selectQuestionWhereCode_10($id= '')
    {
      $this->db->select('LMS_PTN.id,LMS_PTN.pre_code,LMS_PTN.pre_name,LMS_PTN.pre_des,LMS_PTN.pre_random, LMS_PTQ.id, LMS_PTQ.pre_code, LMS_PTQ.pre_no, LMS_PTQ.category_code, LMS_PTQ.question, LMS_PTQ.choice1, LMS_PTQ.choice2, LMS_PTQ.choice3, LMS_PTQ.choice4, LMS_PTQ.ans')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->where('LMS_PTQ.pre_code', $id)
               ->where('LMS_PTQ.category_code', 10);
      $query = $this->db->get();
      return $query->result();
    }


    function selectCategoryWhereCode_1($id= '')
    {
      $this->db->select('*')
               ->from('LMS_PTQ')
               ->join('LMS_PTC', 'LMS_PTQ.pre_code = LMS_PTC.pre_code')
               ->where('LMS_PTC.pre_code', $id)
               ->where('LMS_PTC.category_code', 1);
      $query = $this->db->get('',1);
      return $query->result();
    }

    function selectCategoryWhereCode_2($id= '')
    {
      $this->db->select('*')
               ->from('LMS_PTQ')
               ->join('LMS_PTC', 'LMS_PTQ.pre_code = LMS_PTC.pre_code')
               ->where('LMS_PTC.pre_code', $id)
               ->where('LMS_PTC.category_code', 2);
      $query = $this->db->get('',1);
      return $query->result();
    }

    function selectCategoryWhereCode_3($id= '')
    {
      $this->db->select('*')
               ->from('LMS_PTQ')
               ->join('LMS_PTC', 'LMS_PTQ.pre_code = LMS_PTC.pre_code')
               ->where('LMS_PTC.pre_code', $id)
               ->where('LMS_PTC.category_code', 3);
      $query = $this->db->get('',1);
      return $query->result();
    }

    function selectCategoryWhereCode_4($id= '')
    {
      $this->db->select('*')
               ->from('LMS_PTQ')
               ->join('LMS_PTC', 'LMS_PTQ.pre_code = LMS_PTC.pre_code')
               ->where('LMS_PTC.pre_code', $id)
               ->where('LMS_PTC.category_code', 4);
      $query = $this->db->get('',1);
      return $query->result();
    }

    function selectCategoryWhereCode_5($id= '')
    {
      $this->db->select('*')
               ->from('LMS_PTQ')
               ->join('LMS_PTC', 'LMS_PTQ.pre_code = LMS_PTC.pre_code')
               ->where('LMS_PTC.pre_code', $id)
               ->where('LMS_PTC.category_code', 5);
      $query = $this->db->get('',1);
      return $query->result();
    }

    function selectCategoryWhereCode_6($id= '')
    {
      $this->db->select('*')
               ->from('LMS_PTQ')
               ->join('LMS_PTC', 'LMS_PTQ.pre_code = LMS_PTC.pre_code')
               ->where('LMS_PTC.pre_code', $id)
               ->where('LMS_PTC.category_code', 6);
      $query = $this->db->get('',1);
      return $query->result();
    }

    function selectCategoryWhereCode_7($id= '')
    {
      $this->db->select('*')
               ->from('LMS_PTQ')
               ->join('LMS_PTC', 'LMS_PTQ.pre_code = LMS_PTC.pre_code')
               ->where('LMS_PTC.pre_code', $id)
               ->where('LMS_PTC.category_code', 7);
      $query = $this->db->get('',1);
      return $query->result();
    }

    function selectCategoryWhereCode_8($id= '')
    {
      $this->db->select('*')
               ->from('LMS_PTQ')
               ->join('LMS_PTC', 'LMS_PTQ.pre_code = LMS_PTC.pre_code')
               ->where('LMS_PTC.pre_code', $id)
               ->where('LMS_PTC.category_code', 8);
      $query = $this->db->get('',1);
      return $query->result();
    }

    function selectCategoryWhereCode_9($id= '')
    {
      $this->db->select('*')
               ->from('LMS_PTQ')
               ->join('LMS_PTC', 'LMS_PTQ.pre_code = LMS_PTC.pre_code')
               ->where('LMS_PTC.pre_code', $id)
               ->where('LMS_PTC.category_code', 9);
      $query = $this->db->get('',1);
      return $query->result();
    }

    function selectCategoryWhereCode_10($id= '')
    {
      $this->db->select('*')
               ->from('LMS_PTQ')
               ->join('LMS_PTC', 'LMS_PTQ.pre_code = LMS_PTC.pre_code')
               ->where('LMS_PTC.pre_code', $id)
               ->where('LMS_PTC.category_code', 10);
      $query = $this->db->get('',1);
      return $query->result();
    }

    function checkUserAnswer_1($id= '',$emp_c,$time)
    {
      $this->db->select('*')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->join('LMS_PTU_Q', 'LMS_PTU_Q.pre_no = LMS_PTQ.pre_no')
               ->where('LMS_PTQ.pre_code = LMS_PTU_Q.pre_code')
               ->where('LMS_PTQ.pre_no = LMS_PTU_Q.pre_no')
               ->where('LMS_PTQ.category_code = LMS_PTU_Q.category_code')
               ->where('LMS_PTU_Q.question_id = LMS_PTQ.id')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $id)
               ->where('LMS_PTU_Q.category_code', 1)
               ->where('LMS_PTU_Q.time', $time);
      $query = $this->db->get();
      return $query->result();
    }

    function checkUserAnswer_2($id= '',$emp_c,$time)
    {
      $this->db->select('*')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->join('LMS_PTU_Q', 'LMS_PTU_Q.pre_no = LMS_PTQ.pre_no')
               ->where('LMS_PTQ.pre_code = LMS_PTU_Q.pre_code')
               ->where('LMS_PTQ.pre_no = LMS_PTU_Q.pre_no')
               ->where('LMS_PTQ.category_code = LMS_PTU_Q.category_code')
               ->where('LMS_PTU_Q.question_id = LMS_PTQ.id')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $id)
               ->where('LMS_PTU_Q.category_code', 2)
               ->where('LMS_PTU_Q.time', $time);
      $query = $this->db->get();
      return $query->result();
    }

    function checkUserAnswer_3($id= '',$emp_c,$time)
    {
      $this->db->select('*')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->join('LMS_PTU_Q', 'LMS_PTU_Q.pre_no = LMS_PTQ.pre_no')
               ->where('LMS_PTQ.pre_code = LMS_PTU_Q.pre_code')
               ->where('LMS_PTQ.pre_no = LMS_PTU_Q.pre_no')
               ->where('LMS_PTQ.category_code = LMS_PTU_Q.category_code')
               ->where('LMS_PTU_Q.question_id = LMS_PTQ.id')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $id)
               ->where('LMS_PTU_Q.category_code', 3)
               ->where('LMS_PTU_Q.time', $time);
      $query = $this->db->get();
      return $query->result();
    }

    function checkUserAnswer_4($id= '',$emp_c,$time)
    {
      $this->db->select('*')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->join('LMS_PTU_Q', 'LMS_PTU_Q.pre_no = LMS_PTQ.pre_no')
               ->where('LMS_PTQ.pre_code = LMS_PTU_Q.pre_code')
               ->where('LMS_PTQ.pre_no = LMS_PTU_Q.pre_no')
               ->where('LMS_PTQ.category_code = LMS_PTU_Q.category_code')
               ->where('LMS_PTU_Q.question_id = LMS_PTQ.id')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $id)
               ->where('LMS_PTU_Q.category_code', 4)
               ->where('LMS_PTU_Q.time', $time);
      $query = $this->db->get();
      return $query->result();
    }

    function checkUserAnswer_5($id= '',$emp_c,$time)
    {
      $this->db->select('*')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->join('LMS_PTU_Q', 'LMS_PTU_Q.pre_no = LMS_PTQ.pre_no')
               ->where('LMS_PTQ.pre_code = LMS_PTU_Q.pre_code')
               ->where('LMS_PTQ.pre_no = LMS_PTU_Q.pre_no')
               ->where('LMS_PTQ.category_code = LMS_PTU_Q.category_code')
               ->where('LMS_PTU_Q.question_id = LMS_PTQ.id')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $id)
               ->where('LMS_PTU_Q.category_code', 5)
               ->where('LMS_PTU_Q.time', $time);
      $query = $this->db->get();
      return $query->result();
    }

    function checkUserAnswer_6($id= '',$emp_c,$time)
    {
      $this->db->select('*')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->join('LMS_PTU_Q', 'LMS_PTU_Q.pre_no = LMS_PTQ.pre_no')
               ->where('LMS_PTQ.pre_code = LMS_PTU_Q.pre_code')
               ->where('LMS_PTQ.pre_no = LMS_PTU_Q.pre_no')
               ->where('LMS_PTQ.category_code = LMS_PTU_Q.category_code')
               ->where('LMS_PTU_Q.question_id = LMS_PTQ.id')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $id)
               ->where('LMS_PTU_Q.category_code', 6)
               ->where('LMS_PTU_Q.time', $time);
      $query = $this->db->get();
      return $query->result();
    }

    function checkUserAnswer_7($id= '',$emp_c,$time)
    {
      $this->db->select('*')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->join('LMS_PTU_Q', 'LMS_PTU_Q.pre_no = LMS_PTQ.pre_no')
               ->where('LMS_PTQ.pre_code = LMS_PTU_Q.pre_code')
               ->where('LMS_PTQ.pre_no = LMS_PTU_Q.pre_no')
               ->where('LMS_PTQ.category_code = LMS_PTU_Q.category_code')
               ->where('LMS_PTU_Q.question_id = LMS_PTQ.id')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $id)
               ->where('LMS_PTU_Q.category_code', 7)
               ->where('LMS_PTU_Q.time', $time);
      $query = $this->db->get();
      return $query->result();
    }

    function checkUserAnswer_8($id= '',$emp_c,$time)
    {
      $this->db->select('*')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->join('LMS_PTU_Q', 'LMS_PTU_Q.pre_no = LMS_PTQ.pre_no')
               ->where('LMS_PTQ.pre_code = LMS_PTU_Q.pre_code')
               ->where('LMS_PTQ.pre_no = LMS_PTU_Q.pre_no')
               ->where('LMS_PTQ.category_code = LMS_PTU_Q.category_code')
               ->where('LMS_PTU_Q.question_id = LMS_PTQ.id')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $id)
               ->where('LMS_PTU_Q.category_code', 8)
               ->where('LMS_PTU_Q.time', $time);
      $query = $this->db->get();
      return $query->result();
    }

    function checkUserAnswer_9($id= '',$emp_c,$time)
    {
      $this->db->select('*')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->join('LMS_PTU_Q', 'LMS_PTU_Q.pre_no = LMS_PTQ.pre_no')
               ->where('LMS_PTQ.pre_code = LMS_PTU_Q.pre_code')
               ->where('LMS_PTQ.pre_no = LMS_PTU_Q.pre_no')
               ->where('LMS_PTQ.category_code = LMS_PTU_Q.category_code')
               ->where('LMS_PTU_Q.question_id = LMS_PTQ.id')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $id)
               ->where('LMS_PTU_Q.category_code', 9)
               ->where('LMS_PTU_Q.time', $time);
      $query = $this->db->get();
      return $query->result();
    }

    function checkUserAnswer_10($id= '',$emp_c,$time)
    {
      $this->db->select('*')
               ->from('LMS_PTN')
               ->join('LMS_PTQ', 'LMS_PTN.pre_code = LMS_PTQ.pre_code')
               ->join('LMS_PTU_Q', 'LMS_PTU_Q.pre_no = LMS_PTQ.pre_no')
               ->where('LMS_PTQ.pre_code = LMS_PTU_Q.pre_code')
               ->where('LMS_PTQ.pre_no = LMS_PTU_Q.pre_no')
               ->where('LMS_PTQ.category_code = LMS_PTU_Q.category_code')
               ->where('LMS_PTU_Q.question_id = LMS_PTQ.id')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $id)
               ->where('LMS_PTU_Q.category_code', 10)
               ->where('LMS_PTU_Q.time', $time);
      $query = $this->db->get();
      return $query->result();
    }

    public function insertUserDataWithPretestName($data)
    {
      date_default_timezone_set("Asia/Bangkok");
      $time = date('Y-m-d H:i');
      $data['time_create'] = date("Y-m-d H:i");
      $this->db->insert('LMS_PTU_N', $data);
    }

    public function selectBy_precode_empc($code,$emp_c)
    {
      $this->db->select('LMS_PTU_N.emp_c,LMS_PTU_N.pre_code')
              ->from('LMS_PTU_N')
              ->where('LMS_PTU_N.pre_code', $code)
              ->where('LMS_PTU_N.emp_c', $emp_c);
      $query = $this->db->get();
      return $query->result();
    }

    public function insertUsertPretestQuestion($data)
    {
      date_default_timezone_set("Asia/Bangkok");
      $time = date('Y-m-d H:i');
      $data['time_create'] = date("Y-m-d H:i");
      $data['time_mod'] = date("Y-m-d H:i");
      $this->db->insert('LMS_PTU_Q', $data);
    }

    public function updateUsertPretestQuestion($data,$emp_c)
    {
      date_default_timezone_set("Asia/Bangkok");
      $time = date('Y-m-d H:i');
      $data['time_mod'] = date("Y-m-d H:i");
      $this->db->where('emp_c', $emp_c)
               ->where('question_id', $data['question_id'])
               ->where('time', $data['time']);
      $this->db->update('LMS_PTU_Q', $data);
    }

    function check_answer($pre_code,$pre_id)
    {
      $this->db->select('LMS_PTQ.pre_code, LMS_PTQ.pre_no, LMS_PTQ.ans')
               ->from('LMS_PTQ')
               ->where('LMS_PTQ.pre_code', $pre_code)
               ->where('LMS_PTQ.id', $pre_id);
        $query = $this->db->get();
        return $query->result();
    }

    function getUserAnswer($pre_code,$emp_c,$time) //for report page
    {
      $this->db->select('LMS_PTU_Q.pre_code, LMS_PTU_Q.pre_no, LMS_PTU_Q.user_ans, LMS_PTU_Q.real_ans')
               ->from('LMS_PTU_Q')
               ->where('LMS_PTU_Q.pre_code', $pre_code)
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.time', $time);
        $query = $this->db->get();
        return $query->result();
    }

    function getFullScore($pre_code) //for report page
    {
      $this->db->select('LMS_PTQ.pre_code, LMS_PTQ.pre_no')
               ->from('LMS_PTQ')
               ->where('LMS_PTQ.pre_code', $pre_code);
        $query = $this->db->get();
        return $query->result();
    }

    function getUserScore($pre_code,$emp_c,$time)
    {
      $this->db->select('LMS_PTU_Q.emp_c ,LMS_PTU_Q.pre_code, LMS_PTU_Q.user_ans, LMS_PTU_Q.real_ans')
               ->from('LMS_PTU_Q')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $pre_code)
               ->where('LMS_PTU_Q.user_ans = LMS_PTU_Q.real_ans')
               ->where('LMS_PTU_Q.time', $time);
        $query = $this->db->get();
        return $query->result();
    }

    function getUserScoreByCategory_1($pre_code,$emp_c,$time)
    {
      $this->db->select('LMS_PTU_Q.emp_c ,LMS_PTU_Q.pre_code ,LMS_PTU_Q.category_code, LMS_PTU_Q.user_ans, LMS_PTU_Q.real_ans')
               ->from('LMS_PTU_Q')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $pre_code)
               ->where('LMS_PTU_Q.category_code', 1)
               ->where('LMS_PTU_Q.user_ans = LMS_PTU_Q.real_ans')
               ->where('LMS_PTU_Q.time', $time);
        $query = $this->db->get();
        return $query->result();
    }

    function getUserScoreByCategory_2($pre_code,$emp_c,$time)
    {
      $this->db->select('LMS_PTU_Q.emp_c ,LMS_PTU_Q.pre_code ,LMS_PTU_Q.category_code, LMS_PTU_Q.user_ans, LMS_PTU_Q.real_ans')
               ->from('LMS_PTU_Q')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $pre_code)
               ->where('LMS_PTU_Q.category_code', 2)
               ->where('LMS_PTU_Q.user_ans = LMS_PTU_Q.real_ans')
               ->where('LMS_PTU_Q.time', $time);
        $query = $this->db->get();
        return $query->result();
    }

    function getUserScoreByCategory_3($pre_code,$emp_c,$time)
    {
      $this->db->select('LMS_PTU_Q.emp_c ,LMS_PTU_Q.pre_code ,LMS_PTU_Q.category_code, LMS_PTU_Q.user_ans, LMS_PTU_Q.real_ans')
               ->from('LMS_PTU_Q')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $pre_code)
               ->where('LMS_PTU_Q.category_code', 3)
               ->where('LMS_PTU_Q.user_ans = LMS_PTU_Q.real_ans')
               ->where('LMS_PTU_Q.time', $time);
        $query = $this->db->get();
        return $query->result();
    }

    function getUserScoreByCategory_4($pre_code,$emp_c,$time)
    {
      $this->db->select('LMS_PTU_Q.emp_c ,LMS_PTU_Q.pre_code ,LMS_PTU_Q.category_code, LMS_PTU_Q.user_ans, LMS_PTU_Q.real_ans')
               ->from('LMS_PTU_Q')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $pre_code)
               ->where('LMS_PTU_Q.category_code', 4)
               ->where('LMS_PTU_Q.user_ans = LMS_PTU_Q.real_ans')
               ->where('LMS_PTU_Q.time', $time);
        $query = $this->db->get();
        return $query->result();
    }

    function getUserScoreByCategory_5($pre_code,$emp_c,$time)
    {
      $this->db->select('LMS_PTU_Q.emp_c ,LMS_PTU_Q.pre_code ,LMS_PTU_Q.category_code, LMS_PTU_Q.user_ans, LMS_PTU_Q.real_ans')
               ->from('LMS_PTU_Q')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $pre_code)
               ->where('LMS_PTU_Q.category_code', 5)
               ->where('LMS_PTU_Q.user_ans = LMS_PTU_Q.real_ans')
               ->where('LMS_PTU_Q.time', $time);
        $query = $this->db->get();
        return $query->result();
    }

    function getUserScoreByCategory_6($pre_code,$emp_c,$time)
    {
      $this->db->select('LMS_PTU_Q.emp_c ,LMS_PTU_Q.pre_code ,LMS_PTU_Q.category_code, LMS_PTU_Q.user_ans, LMS_PTU_Q.real_ans')
               ->from('LMS_PTU_Q')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $pre_code)
               ->where('LMS_PTU_Q.category_code', 6)
               ->where('LMS_PTU_Q.user_ans = LMS_PTU_Q.real_ans')
               ->where('LMS_PTU_Q.time', $time);
        $query = $this->db->get();
        return $query->result();
    }

    function getUserScoreByCategory_7($pre_code,$emp_c,$time)
    {
      $this->db->select('LMS_PTU_Q.emp_c ,LMS_PTU_Q.pre_code ,LMS_PTU_Q.category_code, LMS_PTU_Q.user_ans, LMS_PTU_Q.real_ans')
               ->from('LMS_PTU_Q')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $pre_code)
               ->where('LMS_PTU_Q.category_code', 7)
               ->where('LMS_PTU_Q.user_ans = LMS_PTU_Q.real_ans')
               ->where('LMS_PTU_Q.time', $time);
        $query = $this->db->get();
        return $query->result();
    }

    function getUserScoreByCategory_8($pre_code,$emp_c,$time)
    {
      $this->db->select('LMS_PTU_Q.emp_c ,LMS_PTU_Q.pre_code ,LMS_PTU_Q.category_code, LMS_PTU_Q.user_ans, LMS_PTU_Q.real_ans')
               ->from('LMS_PTU_Q')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $pre_code)
               ->where('LMS_PTU_Q.category_code', 8)
               ->where('LMS_PTU_Q.user_ans = LMS_PTU_Q.real_ans')
               ->where('LMS_PTU_Q.time', $time);
        $query = $this->db->get();
        return $query->result();
    }

    function getUserScoreByCategory_9($pre_code,$emp_c,$time)
    {
      $this->db->select('LMS_PTU_Q.emp_c ,LMS_PTU_Q.pre_code ,LMS_PTU_Q.category_code, LMS_PTU_Q.user_ans, LMS_PTU_Q.real_ans')
               ->from('LMS_PTU_Q')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $pre_code)
               ->where('LMS_PTU_Q.category_code', 9)
               ->where('LMS_PTU_Q.user_ans = LMS_PTU_Q.real_ans')
               ->where('LMS_PTU_Q.time', $time);
        $query = $this->db->get();
        return $query->result();
    }

    function getUserScoreByCategory_10($pre_code,$emp_c,$time)
    {
      $this->db->select('LMS_PTU_Q.emp_c ,LMS_PTU_Q.pre_code ,LMS_PTU_Q.category_code, LMS_PTU_Q.user_ans, LMS_PTU_Q.real_ans')
               ->from('LMS_PTU_Q')
               ->where('LMS_PTU_Q.emp_c', $emp_c)
               ->where('LMS_PTU_Q.pre_code', $pre_code)
               ->where('LMS_PTU_Q.category_code', 10)
               ->where('LMS_PTU_Q.user_ans = LMS_PTU_Q.real_ans')
               ->where('LMS_PTU_Q.time', $time);
        $query = $this->db->get();
        return $query->result();
    }

    public function insertUserScore($data)
    {
      date_default_timezone_set("Asia/Bangkok");
      $data['CreateDate'] = date("Y-m-d H:i");
      $this->db->insert('LMS_PTS', $data);
    }

    public function get_pts_id_from_lms_pts($data)
    {
      $this->db->select('*')
               ->from('LMS_PTS')
               ->where('LMS_PTS.emp_c', $data['emp_c'])
               ->where('LMS_PTS.CourseCode', $data['CourseCode'])
               ->order_by('LMS_PTS.id','DESC')
               ->limit(1);
      $query = $this->db->get();
      return $query->result();
    }

    public function insertPTUN_pts_id($get_pts_id,$data)
    {
      date_default_timezone_set("Asia/Bangkok");
      $time = date('Y-m-d H:i');
      $this->db->where('pre_code', $data['CourseCode'])
               ->where('emp_c', $data['emp_c'])
               ->set('pts_id', $get_pts_id)
               ->set('time_mod', $time)
               ->update('LMS_PTU_N');
    }

    public function checkAlready($emp_c)
    {
      $this->db->select('LMS_PTN.pre_code, LMS_PTN.pre_name, LMS_PTN.pre_score, LMS_PTS.id, LMS_PTS.emp_c, LMS_PTS.CourseCode, LMS_PTS.TotalScore, LMS_PTS.CreateDate')
               ->from('LMS_PTN')
               ->join('LMS_PTS', 'LMS_PTS.CourseCode = LMS_PTN.pre_code')
               // ->group_by('LMS_PTS.CourseCode')
               // ->order_by('LMS_PTS.id','DESC')
               ->where('LMS_PTS.emp_c', $emp_c);
      $query = $this->db->get();
      return $query->result();
    }

    public function getUserScoreFromPTUN($emp_c)
    {
      $this->db->select('*')
               ->from('LMS_PTU_N')
               ->where('emp_c', $emp_c);
      $query = $this->db->get();

      return $query->result();
    }

    public function check_pts($emp_c)
    {
      $this->db->select('LMS_PTS.emp_c, LMS_PTS.CourseCode')
               ->from('LMS_PTS')
               ->where('LMS_PTS.emp_c', $emp_c);
      $query = $this->db->get();
      return $query->result();
    }

    public function check_ptun($emp_c)
    {
      $this->db->select('LMS_PTU_N.emp_c, LMS_PTU_N.pre_code')
               ->from('LMS_PTU_N')
               ->where('LMS_PTU_N.emp_c', $emp_c);
      $query = $this->db->get();
      return $query->result();
    }

    public function checkAlreadyByemp_c($emp_c,$testIntersect)
    {
      $this->db->select('LMS_PTN.id, LMS_PTN.pre_code, LMS_PTN.pre_name, LMS_PTN.pre_des, LMS_PTN.pre_random, LMS_PTS.emp_c, LMS_PTS.CourseCode')
               ->from('LMS_PTS')
               ->join('LMS_PTN', 'LMS_PTS.CourseCode = LMS_PTN.pre_code' ,'Right')
               ->where('LMS_PTN.pre_code =' ,$testIntersect);
     $query = $this->db->get();
     return $query->result();
    }

    function viewFullScore($pre_code,$emp_c) //for view page
    {
      $this->db->select('LMS_PTQ.pre_code, LMS_PTQ.pre_no')
               ->from('LMS_PTQ')
               ->where('LMS_PTQ.pre_code', $pre_code);
        $query = $this->db->get();
        return $query->result();
    }

    function checkRandom($pre_code)
    {
        $this->db->select('LMS_PTN.pre_code, LMS_PTN.pre_name, LMS_PTN.pre_score, LMS_PTN.pre_des, LMS_PTN.pre_random')
                 ->from('LMS_PTN')
                 ->where('pre_code', $pre_code);
        $query = $this->db->get();
        return $query->result();
    }

    function checkFullScore($pre_code)
    {
        $this->db->select('LMS_PTQ.pre_code, LMS_PTQ.pre_no')
                 ->from('LMS_PTQ')
                 ->where('LMS_PTQ.pre_code', $pre_code)
                 ->where('LMS_PTQ.pre_no != 0');
        $query = $this->db->get();
        return $query->result();
    }

    function updateFullScore($pre_code,$fullscore,$mod_by)
    {
      date_default_timezone_set("Asia/Bangkok");
      $time_mod = date("Y-m-d H:i");

      $this->db->where('pre_code', $pre_code)
               ->set('pre_score',$fullscore)
               ->set('time_mod',$time_mod)
               ->set('mod_by',$mod_by)
               ->update('LMS_PTN');
    }

    function removeFromPTQ($pre_code,$category_code,$pre_no)
    {
      $this->db->where('pre_code',$pre_code)
               ->where('category_code',$category_code)
               ->where('pre_no',$pre_no)
               ->delete('LMS_PTQ');
    }

    function checkOldNo($pre_code,$category_code)
    {
      $this->db->select('*')
               ->from('LMS_PTQ')
               ->where('LMS_PTQ.pre_code',$pre_code)
               ->where('LMS_PTQ.category_code',$category_code);
      $query = $this->db->get();
      return $query->result();
    }

    function runNewNo($data)
    {
      date_default_timezone_set("Asia/Bangkok");
      $data['time_mod'] = date('Y-m-d H:i');
      $this->db->where('id', $data['id'])
               ->where('pre_code', $data['pre_code'])
               ->where('category_code', $data['category_code'])
               ->update('LMS_PTQ', $data);
    }

    public function insertZero($pre_code)
    {
      $this->db->set('pre_code', $pre_code)
               ->set('pre_no',0)
               ->set('category_code',0)
               ->insert('LMS_PTQ');
    }

    public function removeZero($pre_code)
    {
      $this->db->where('pre_code',$pre_code)
               ->where('pre_no',0)
               ->where('category_code',0)
               ->delete('LMS_PTQ');
    }

    public function deletePretest($pre_code)
    {
      $this->db->where('pre_code',$pre_code)
               ->delete('LMS_PTN');
      $this->db->where('pre_code',$pre_code)
               ->delete('LMS_PTC');
      $this->db->where('pre_code',$pre_code)
               ->delete('LMS_PTQ');
    }

    public function generateCode()
    {
      $this->db->order_by('id',"desc")
               ->limit(1);
      $query = $this->db->get('LMS_PTN');
      return $query->result();
    }

    public function CheckIdAvailable($data)
    {
     $this->db->where('id', $data);
     $query = $this->db->get('LMS_PTN');
     if($query->num_rows() > 0)
     return $query->result();
    }
    
    public function CheckCodeAvailable($data)
    {
     $this->db->where('pre_code', $data);
     $query = $this->db->get('LMS_PTN');
     if($query->num_rows() > 0)
     return $query->result();
    }

    public function removeDataFromPTU_Q($emp_c,$pre_code)
    {
      $this->db->where('pre_code',$pre_code)
               ->where('emp_c',$emp_c)
               ->delete('LMS_PTU_Q');
    }

    public function checkUserPTS($emp_c,$pre_code){
      $this->db->where('CourseCode', $pre_code)
               ->where('emp_c', $emp_c);
      $query = $this->db->get('LMS_PTS');
      return $query->result();
    }

    public function getPTS($emp_c,$pre_code){
      $this->db->where('emp_c', $emp_c)
               ->where('CourseCode', $pre_code);
      $query = $this->db->get('LMS_PTS');
      return $query->result();
    }

    public function checkPretestTime($pre_code,$emp_c){
      $this->db->select('time')
               ->from('LMS_PTU_Q')
               ->where('pre_code',$pre_code)
               ->where('emp_c',$emp_c)
               ->limit(1)
               ->order_by('id','DESC');
      $query = $this->db->get();
      return $query->result();         
    }
}
