<?php
class Compliance_model extends CI_Model {
      public function __construct(){
        // Call the CI_Model constructor
        parent::__construct();
      }
      public function loadDB(){
        $this->load->database();
      }
      public function closeDB(){
        $this->db->close();
      }
      public function insertSendmail($sm_subject,$sm_desc,$com_p,$time_create,$time_modified)
      {
        date_default_timezone_set("Asia/Bangkok");
        $time = date('Y-m-d H:i');
          $data['sm_subject'] = $sm_subject;
          $data['sm_desc'] = $sm_desc;
          $data['com_p'] = $com_p;
          $data['sm_createtime'] = $time_create;
          $data['sm_modifiedtime'] = $time_modified;
          $this->db->insert('LMS_COMP_SENTMAIL', $data);
          $id = $this->db->insert_id();
          return $id;
      }

      public function updateSendmail($sm_id,$sm_subject,$sm_desc,$com_p,$time_create,$time_modified)
      {
        date_default_timezone_set("Asia/Bangkok");
        $time = date('Y-m-d H:i');
          $data['sm_subject'] = $sm_subject;
          $data['sm_desc'] = $sm_desc;
          $data['com_p'] = $com_p;
          $data['sm_createtime'] = $time_create;
          $data['sm_modifiedtime'] = $time_modified;
          $this->db->where('sm_id',$sm_id);
          $this->db->update('LMS_COMP_SENTMAIL', $data);
      }

      public function getlist_sendmail($id= '')
      {
        $this->db->select('LMS_EMP.email')
                 ->distinct()
                 ->from('LMS_COMP_EMP')
                 ->join('LMS_COMP_SENTMAIL','LMS_COMP_EMP.com_p = LMS_COMP_SENTMAIL.com_p','INNER')
                 ->join('LMS_EMP','LMS_COMP_EMP.emp_c = LMS_EMP.emp_c','INNER')
                 ->where('LMS_COMP_SENTMAIL.sm_id', $id)
                 ->where('LMS_EMP.status', 'Active')
                 ->where('LMS_EMP.status', 'active')
                 ->where('LMS_EMP.lang', 'thailand')
                 ->where_not_in('LMS_COMP_EMP.status', '1');
        $query = $this->db->get();
        $result = $query->result_array();
        $arr_empc = array();
        foreach ($result as $key => $value) {
         array_push($arr_empc, $value['email']);
        }
        return $arr_empc;
      }

      public function insertComplianceHead($topic_name_th,$topic_name_en,$name_the_executive_th,$name_the_executive_en,$message_from_the_executive_th,$message_from_the_executive_en,$recommendation_th,$recommendation_en,$position_the_executive_th,$position_the_executive_en,$image_file,$lang,$time_start,$time_end,$company_level,$chkbox_showtopic)
      {
        date_default_timezone_set("Asia/Bangkok");
        $time = date('Y-m-d H:i');
          $data['topic_name_th'] = $topic_name_th;
          $data['topic_name_en'] = $topic_name_en;
          $data['name_the_executive_th'] = $name_the_executive_th;
          $data['name_the_executive_en'] = $name_the_executive_en;
          $data['message_from_the_executive_th'] = $message_from_the_executive_th;
          $data['message_from_the_executive_en'] = $message_from_the_executive_en;
          $data['recommendation_th'] = $recommendation_th;
          $data['recommendation_en'] = $recommendation_en;
          $data['position_the_executive_th'] = $position_the_executive_th;
          $data['position_the_executive_en'] = $position_the_executive_en;
          $data['image_the_executive'] = $image_file;
          $data['chkbox_showtopic'] = $chkbox_showtopic;
          $data['org_code'] = $company_level;
          $data['time_start'] = date("Y-m-d H:i",strtotime($time_start));
          $data['time_end'] = date("Y-m-d H:i",strtotime($time_end));
          $data['time_create'] = date("Y-m-d H:i");
          $data['time_mod'] = date("Y-m-d H:i");
          $data['lang'] = $lang;
          $this->db->insert('LMS_COMP', $data);
          $id = $this->db->insert_id();
          return $id;
      }
      public function updateComplianceHead($comp_id,$topic_name_th,$topic_name_en,$name_the_executive_th,$name_the_executive_en,$message_from_the_executive_th,$message_from_the_executive_en,$recommendation_th,$recommendation_en,$position_the_executive_th,$position_the_executive_en,$image_file,$lang,$time_start,$time_end,$company_level,$chkbox_showtopic)
      {
        date_default_timezone_set("Asia/Bangkok");
        $time = date('Y-m-d H:i');
          $data['topic_name_th'] = $topic_name_th;
          $data['topic_name_en'] = $topic_name_en;
          $data['name_the_executive_th'] = $name_the_executive_th;
          $data['name_the_executive_en'] = $name_the_executive_en;
          $data['message_from_the_executive_th'] = $message_from_the_executive_th;
          $data['message_from_the_executive_en'] = $message_from_the_executive_en;
          $data['chkbox_showtopic'] = $chkbox_showtopic;
          $data['recommendation_th'] = $recommendation_th;
          $data['recommendation_en'] = $recommendation_en;
          $data['position_the_executive_th'] = $position_the_executive_th;
          $data['position_the_executive_en'] = $position_the_executive_en;
          $data['image_the_executive'] = $image_file;
          $data['org_code'] = $company_level;
          $data['time_start'] = date("Y-m-d H:i",strtotime($time_start));
          $data['time_end'] = date("Y-m-d H:i",strtotime($time_end));
          $data['time_mod'] = date("Y-m-d H:i");
          $data['lang'] = $lang;
          $this->db->where('id',$comp_id);
          $this->db->update('LMS_COMP', $data);
      }

      function selectCompliance($id= '')
      {
        $this->db->from('LMS_COMP')
                 ->where('LMS_COMP.id', $id);
        $query = $this->db->get();
        $result = $query->result_array();
        return $query->result_array();
      }
      function selectTopic($id= '')
      {
        $this->db->select('LMS_COMP_TOP.id,LMS_COMP_TOP.title_name_th,LMS_COMP_TOP.title_name_en,LMS_COMP_TOP.explanation_begins_th,LMS_COMP_TOP.explanation_begins_en,LMS_COMP_TOP.end_quote_th,LMS_COMP_TOP.end_quote_en')
                 ->from('LMS_COMP_TOP')
                 ->where('LMS_COMP_TOP.comp_id', $id)
                 ->where('LMS_COMP_TOP.status', '1');
        $query = $this->db->get();
        return $query->result();
      }
      function selectTopicDetail($id= '')
      {
        $this->db->from('LMS_COMP_TOP')
                 ->join('LMS_COMP_QUES', 'LMS_COMP_TOP.id = LMS_COMP_QUES.ctop_id')
                 ->where('LMS_COMP_TOP.comp_id', $id)
                 ->where('LMS_COMP_QUES.hidden', '1');
        $query = $this->db->get();
        return $query->result();
      }


      public function insertComplianceTOP($data)
      {
        date_default_timezone_set("Asia/Bangkok");
        $time = date('Y-m-d H:i');
        $this->db->insert('LMS_COMP_TOP', $data);
        $id = $this->db->insert_id();
        return $id;
      }

      public function updateComplianceTOP($data,$id)
      {
        date_default_timezone_set("Asia/Bangkok");
        $time = date('Y-m-d H:i');
        $this->db->where('id', $id)
                 ->update('LMS_COMP_TOP', $data);
      }

      public function insertComplianceQUES($data)
      {
        date_default_timezone_set("Asia/Bangkok");
        $time = date('Y-m-d H:i');
        $this->db->insert('LMS_COMP_QUES', $data);
        $id = $this->db->insert_id();
                $com_p = "";
                $ctop_id = "";
                $this->db->from('LMS_COMP_TOP')
                         ->join('LMS_COMP_QUES', 'LMS_COMP_TOP.id = LMS_COMP_QUES.ctop_id')
                         ->where('LMS_COMP_QUES.id', $id);
                $query = $this->db->get();
                $row = $query->row_array();
                $result = $query->result_array();

                foreach ($result as $each) {
                  $com_p = $each['comp_id'];
                  $ctop_id = $each['ctop_id'];
                }
                $this->db->select('emp_c');
                $this->db->distinct();
                $this->db->from('LMS_EMP');
                $this->db->where('org1', 'TIS');
                $query = $this->db->get();
                $row = $query->row_array();
                $result = $query->result_array();

                foreach ($result as $each) {
                  $emp_c = $each['emp_c'];
                  $this->db->from('LMS_COMP_EMP');
                  $this->db->where('emp_c', $emp_c);
                  $this->db->where('com_p', $com_p);
                  $query = $this->db->get();
                  $row = $query->row_array();
                  $comp_emp_id = "";
                  if($row>0){
                    $result = $query->result_array();
                    foreach ($result as $each) {
                      $comp_emp_id = $each['id'];
                    }
                  }else{
                    $data = array(
                        'emp_c'     => $emp_c,
                        'com_p' => $com_p,
                        'status' => '2',
                        'time_create' => date('Y-m-d H:i'),
                        'time_mod' => date('Y-m-d H:i')
                    );
                    $this->db->insert('LMS_COMP_EMP', $data);
                    $comp_emp_id = $this->db->insert_id();
                  }
                  if($comp_emp_id!=""){
                      $emp_c = $each['emp_c'];
                      $this->db->from('LMS_COMP_EMP_DE');
                      $this->db->where('comp_emp_id', $comp_emp_id);
                      $this->db->where('ctop_id', $ctop_id);
                      $this->db->where('ques_id', $id);
                      $query = $this->db->get();
                      $row = $query->row_array();
                      if($row==0){
                        $data = array(
                          'comp_emp_id'     => $comp_emp_id,
                          'ctop_id' => $ctop_id,
                          'ques_id' => $id,
                          'time_mod' => date('Y-m-d H:i')
                        );
                        $this->db->insert('LMS_COMP_EMP_DE', $data);
                      }
                  }
                }
        return $id;
      }


      public function updateComplianceQUES($data,$id)
      {
        date_default_timezone_set("Asia/Bangkok");
        $time = date('Y-m-d H:i');
        $this->db->where('id', $id)
                 ->update('LMS_COMP_QUES', $data);
                $com_p = "";
                $ctop_id = "";
                $this->db->from('LMS_COMP_TOP')
                         ->join('LMS_COMP_QUES', 'LMS_COMP_TOP.id = LMS_COMP_QUES.ctop_id')
                         ->where('LMS_COMP_QUES.id', $id);
                $query = $this->db->get();
                $row = $query->row_array();
                $result = $query->result_array();

                foreach ($result as $each) {
                  $com_p = $each['comp_id'];
                  $ctop_id = $each['ctop_id'];
                }
                $this->db->select('emp_c');
                $this->db->distinct();
                $this->db->from('LMS_EMP');
                $this->db->where('org1', 'TIS');
                $query = $this->db->get();
                $row = $query->row_array();
                $result = $query->result_array();

                foreach ($result as $each) {
                  $emp_c = $each['emp_c'];
                  $this->db->from('LMS_COMP_EMP');
                  $this->db->where('emp_c', $emp_c);
                  $this->db->where('com_p', $com_p);
                  $query = $this->db->get();
                  $row = $query->row_array();
                  $comp_emp_id = "";
                  if($row>0){
                    $result = $query->result_array();
                    foreach ($result as $each) {
                      $comp_emp_id = $each['id'];
                    }
                  }else{
                    $data = array(
                        'emp_c'     => $emp_c,
                        'com_p' => $com_p,
                        'status' => '2',
                        'time_create' => date('Y-m-d H:i'),
                        'time_mod' => date('Y-m-d H:i')
                    );
                    $this->db->insert('LMS_COMP_EMP', $data);
                    $comp_emp_id = $this->db->insert_id();
                  }
                  if($comp_emp_id!=""){
                      $emp_c = $each['emp_c'];
                      $this->db->from('LMS_COMP_EMP_DE');
                      $this->db->where('comp_emp_id', $comp_emp_id);
                      $this->db->where('ctop_id', $ctop_id);
                      $this->db->where('ques_id', $id);
                      $query = $this->db->get();
                      $row = $query->row_array();
                      if($row==0){
                        $data = array(
                          'comp_emp_id'     => $comp_emp_id,
                          'ctop_id' => $ctop_id,
                          'ques_id' => $id,
                          'time_mod' => date('Y-m-d H:i')
                        );
                        $this->db->insert('LMS_COMP_EMP_DE', $data);
                      }
                  }
                }
      }

      public function removeFromQUE_DE($id)
      {
        $this->db->where('ques_id', $id);
        $this->db->delete('LMS_COMP_EMP_DE');

        $this->db->where('id',$id)
                 ->set('time_create',date('Y-m-d H:i'))
                 ->set('hidden', '0')
                 ->update('LMS_COMP_QUES');
      }

      public function removeFromTopic($id)
      {
        $this->db->where('ctop_id', $id);
        $this->db->delete('LMS_COMP_EMP_DE');

        $this->db->where('id',$id)
                 ->set('time_create',date('Y-m-d H:i'))
                 ->set('status', '0')
                 ->update('LMS_COMP_TOP');
      }

      public function get_data()
      {
          $query  = $this->db->where('LMS_COMP.status', '1')
                             ->get('LMS_COMP');
          $result = $query->result();
          return $result;
      }

      public function get_data_sendmail()
      {
          $query  = $this->db->where('LMS_COMP_SENTMAIL.sm_status', '1')
                             ->join('LMS_COMP','LMS_COMP_SENTMAIL.com_p = LMS_COMP.id')
                             ->get('LMS_COMP_SENTMAIL');
          $result = $query->result();
          return $result;
      }


        public function getCompliance_select() {
          $this->db->select('id,topic_name_th');
          $this->db->distinct();
          $this->db->where('status','1');
          $query = $this->db->get('LMS_COMP');
          return $query->result_array();
        }

      public function getData_sendmail($sm_id)
        {
          $this->db->from('LMS_COMP_SENTMAIL');
          $this->db->where('sm_id', $sm_id);
          $query = $this->db->get();
          if ($query->num_rows() > 0){
            $sendmail = $query->result_array();
            return $sendmail[0];
          }
        }

      public function removeFromCOMP($id)
      {

        $this->db->where('com_p', $id);
        $this->db->delete('LMS_COMP_EMP');

        $this->db->where('id',$id)
                 ->set('time_mod',date('Y-m-d H:i'))
                 ->set('hidden', '0')
                 ->update('LMS_COMP');
      }


      public function removeFromSendmail($id)
      {

        $this->db->where('sm_id', $id);
        $this->db->delete('LMS_COMP_SENTMAIL');

      }

      public function get_data_activity()
      {
          $query  = $this->db->order_by('id', 'desc')
                             ->where('LMS_COMP.status', '1')
                             ->get('LMS_COMP');
          $result = $query->result();
          return $result;
      }

      public function get_data_activity_person($emp_c)
      {
        $this->db->select('LMS_COMP.topic_name_th,LMS_COMP.org_code,LMS_COMP.topic_name_en,LMS_COMP_EMP.status,LMS_COMP.hidden,LMS_COMP.id,LMS_COMP_EMP.time_mod')
                 ->from('LMS_COMP_EMP')
                 ->join('LMS_COMP', 'LMS_COMP_EMP.com_p = LMS_COMP.id')
                 ->where('LMS_COMP_EMP.emp_c', $emp_c)
                 ->where('LMS_COMP.hidden', '1');
        $query = $this->db->get();
        return $query->result();
      }

      public function get_data_finish_msg()
      {
        $this->db->from('LMS_COMP_FINISH_MSG')
                 ->where('LMS_COMP_FINISH_MSG.id', '1');
        $query = $this->db->get();
        return $query->result_array();
      }

      public function chkreommendation($ques_id , $ctop_id)
      {
          $query  = $this->db->select('LMS_COMP_QUES.suggestion_th,LMS_COMP_QUES.suggestion_en')
                             ->where('LMS_COMP_QUES.id', $ques_id)
                             ->where('LMS_COMP_QUES.ctop_id', $ctop_id)
                             ->get('LMS_COMP_QUES');
          $result = $query->result();
          return $result;
      }

      public function isCheckActivity($comp_emp_id){
                $this->db->from('LMS_COMP_EMP_DE');
                $this->db->where('comp_emp_id', $comp_emp_id);
                $query = $this->db->get();
                $row = $query->row_array();
                $result = $query->result_array();
                $num = 0;
                foreach ($result as $each) {
                  if($each['status']=="0"){
                    $num++;
                  }
                }
                if($num==0){
                    $this->db->where('id',$comp_emp_id)
                             ->set('time_mod',date('Y-m-d H:i'))
                             ->set('status', '1')
                             ->update('LMS_COMP_EMP');
                }
                if($num!=0&&$num<$row){
                    $this->db->where('id',$comp_emp_id)
                             ->set('time_mod',date('Y-m-d H:i'))
                             ->set('status', '0')
                             ->update('LMS_COMP_EMP');
                }
                return $num;
      }

      public function isCheckDateExp($com_p){
                $this->db->from('LMS_COMP');
                $this->db->where('id', $com_p);
                $query = $this->db->get();
                $row = $query->row_array();
                $result = $query->result_array();
                $num = 0;
                foreach ($result as $each) {
                  if(date('Y-m-d H:i',strtotime($each['time_end']))>date('Y-m-d H:i')){
                    $num++;
                  }
                }
                if($num>0){
                  $this->db->where('com_p',$com_p)
                           ->where_not_in('status','1')
                             ->set('time_mod',date('Y-m-d H:i'))
                             ->set('status', '3')
                             ->update('LMS_COMP_EMP');
                }
                return $num;
      }

      public function getDataActivity($emp_c , $com_p , $chkbox_showtopic)
      {
        date_default_timezone_set("Asia/Bangkok");
          $this->db->from('LMS_COMP_EMP');
          $this->db->where('emp_c', $emp_c);
          $this->db->where('com_p', $com_p);
          $query = $this->db->get();
          $row = $query->row_array();
          if($row>0){
            $result = $query->result_array();
            foreach ($result as $each) {
              $num = $this->isCheckActivity($each['id']);
                if($num>0){
                  if($each['status']!="1"){
                    $this->db->from('LMS_COMP_EMP_DE');
                    $this->db->join('LMS_COMP_QUES', 'LMS_COMP_EMP_DE.ques_id = LMS_COMP_QUES.id');
                    $this->db->where('LMS_COMP_EMP_DE.comp_emp_id', $each['id']);
                    $this->db->where('LMS_COMP_EMP_DE.status', '0');
                    $this->db->order_by('LMS_COMP_QUES.numeral', 'asc');
                    $query = $this->db->get();
                    $row = $query->row_array();
                    $result = $query->result_array();
                    $num = 1;
                    $ques_id = "";
                    $ctop_id = "";
                    $title_name_th = "";
                    $title_name_en = "";
                    foreach ($result as $each) {
                      if($num==1){
                        $ques_id = $each['ques_id'];
                      }
                      $num++;
                    }
                    if($chkbox_showtopic=="1"){
                      $this->db->select('LMS_COMP_QUES.ctop_id,LMS_COMP_TOP.title_name_th,LMS_COMP_TOP.title_name_en')
                               ->from('LMS_COMP_TOP')
                               ->join('LMS_COMP_QUES', 'LMS_COMP_TOP.id = LMS_COMP_QUES.ctop_id')
                               ->where('LMS_COMP_QUES.id', $ques_id)
                               ->order_by('LMS_COMP_QUES.numeral', 'asc')
                               ->order_by('LMS_COMP_QUES.ctop_id', 'asc');
                    }else{
                      $this->db->select('LMS_COMP_QUES.ctop_id,LMS_COMP_TOP.title_name_th,LMS_COMP_TOP.title_name_en')
                               ->from('LMS_COMP_TOP')
                               ->join('LMS_COMP_QUES', 'LMS_COMP_TOP.id = LMS_COMP_QUES.ctop_id')
                               ->where('LMS_COMP_QUES.id', $ques_id)
                               ->order_by('LMS_COMP_QUES.numeral', 'asc');
                    }
                    $query = $this->db->get();
                    $result = $query->result_array();

                    $num_rechk = count($result);
                    foreach ($result as $each) {
                        $title_name_th = $each['title_name_th'];
                        $title_name_en = $each['title_name_en'];
                        $ctop_id = $each['ctop_id'];
                    }
                    $data_resend = array(
                        'num_rechk'     => $num_rechk,
                        'status'     => '0',
                        'ques_id' => $ques_id,
                        'ctop_id' => $ctop_id,
                        'title_name_th' => $title_name_th,
                        'title_name_en' => $title_name_en
                    );
                  }else{
                    $data_resend = array(
                        'num_rechk'     => '0',
                        'status'     => $each['status'],
                        'ques_id' => '0',
                        'ctop_id' => '0',
                        'title_name_th' => '',
                        'title_name_en' => ''
                    );
                  }
                }else{
                  $data_resend = array(
                        'num_rechk'     => '0',
                        'status'     => '5',
                        'ques_id' => '0',
                        'ctop_id' => '0',
                        'title_name_th' => '',
                        'title_name_en' => ''
                  );
                }
              
            }
          }else{
            $data = array(
                'emp_c'     => $emp_c,
                'com_p' => $com_p,
                'time_create' => date('Y-m-d H:i'),
                'time_mod' => date('Y-m-d H:i')
            );
            $this->db->insert('LMS_COMP_EMP', $data);
            $comp_emp_id = $this->db->insert_id();
            $this->db->select('LMS_COMP_QUES.ctop_id,LMS_COMP_QUES.id,LMS_COMP_TOP.title_name_th,LMS_COMP_TOP.title_name_en')
                     ->from('LMS_COMP_TOP')
                     ->join('LMS_COMP_QUES', 'LMS_COMP_TOP.id = LMS_COMP_QUES.ctop_id')
                     ->where('LMS_COMP_TOP.comp_id', $com_p)
                     ->where('LMS_COMP_QUES.hidden', '1')
                     ->order_by('LMS_COMP_QUES.numeral', 'asc');
            $query = $this->db->get();
            $result = $query->result_array();
            $num = 1;
            $ctop_id = "";
            $ques_id = "";
            $title_name_th = "";
            $title_name_en = "";
            $num_rechk = count($result);
            foreach ($result as $each) {
              if($num==1){
                $ctop_id = $each['ctop_id'];
                $ques_id = $each['id'];
                $title_name_th = $each['title_name_th'];
                $title_name_en = $each['title_name_en'];
              }
              $data = array(
                'comp_emp_id'     => $comp_emp_id,
                'ctop_id' => $each['ctop_id'],
                'ques_id' => $each['id'],
                'time_mod' => date('Y-m-d H:i')
              );
              $this->db->insert('LMS_COMP_EMP_DE', $data);
              $num++;
            }
            $data_resend = array(
                'num_rechk'     => $num_rechk,
                'status'     => '0',
                'ques_id' => $ques_id,
                'ctop_id' => $ctop_id,
                'title_name_th' => $title_name_th,
                'title_name_en' => $title_name_en
            );
          }
          //print_r($data_resend);
          return $data_resend;
      }
       public function getDataActivityDemo($emp_c , $com_p , $chkbox_showtopic,$arr)
      {
        //print_r($arr);
        if($arr!="0"){
          $array_test = array();
          if($chkbox_showtopic=="1"){
            $this->db->select('LMS_COMP_QUES.ctop_id,LMS_COMP_QUES.id,LMS_COMP_TOP.title_name_th,LMS_COMP_TOP.title_name_en')
                     ->from('LMS_COMP_TOP')
                     ->join('LMS_COMP_QUES', 'LMS_COMP_TOP.id = LMS_COMP_QUES.ctop_id')
                     ->where('LMS_COMP_TOP.comp_id', $com_p)
                     ->order_by('LMS_COMP_QUES.numeral', 'asc')
                     ->order_by('LMS_COMP_QUES.ctop_id', 'asc');
          }else{
            $this->db->select('LMS_COMP_QUES.ctop_id,LMS_COMP_QUES.id,LMS_COMP_TOP.title_name_th,LMS_COMP_TOP.title_name_en')
                     ->from('LMS_COMP_TOP')
                     ->join('LMS_COMP_QUES', 'LMS_COMP_TOP.id = LMS_COMP_QUES.ctop_id')
                     ->where('LMS_COMP_TOP.comp_id', $com_p)
                     ->where('LMS_COMP_QUES.hidden', '1')
                     ->order_by('LMS_COMP_QUES.numeral', 'asc');
          }
            foreach ($arr as $key => $value) {
              array_push($array_test, $value);
            }
          //echo $arr;
            $query = $this->db->get();
            $result = $query->result_array();
            $num = 1;
            $ctop_id = "";
            $ques_id = "";
            $title_name_th = "";
            $title_name_en = "";
            $num_rechk = count($result);
            foreach ($result as $each) {
              if(!in_array($each['id'], $array_test)){
                if($num==1){
                  $ctop_id = $each['ctop_id'];
                  $ques_id = $each['id'];
                  $title_name_th = $each['title_name_th'];
                  $title_name_en = $each['title_name_en'];
                }
                $num++;
              }
            }
            if(count($arr)==count($result)){
              $data_resend = array(
                  'num_rechk'     => $num_rechk,
                  'status'     => '5',
                  'ques_id' => $ques_id,
                  'ctop_id' => $ctop_id,
                  'title_name_th' => $title_name_th,
                  'title_name_en' => $title_name_en
              );
            }else{
              $data_resend = array(
                  'num_rechk'     => $num_rechk,
                  'status'     => '0',
                  'ques_id' => $ques_id,
                  'ctop_id' => $ctop_id,
                  'title_name_th' => $title_name_th,
                  'title_name_en' => $title_name_en
              );
            }
        }else{
          if($chkbox_showtopic=="1"){
            $this->db->select('LMS_COMP_QUES.ctop_id,LMS_COMP_QUES.id,LMS_COMP_TOP.title_name_th,LMS_COMP_TOP.title_name_en')
                     ->from('LMS_COMP_TOP')
                     ->join('LMS_COMP_QUES', 'LMS_COMP_TOP.id = LMS_COMP_QUES.ctop_id')
                     ->where('LMS_COMP_TOP.comp_id', $com_p)
                     ->order_by('LMS_COMP_QUES.ctop_id', 'asc')
                     ->order_by('LMS_COMP_QUES.numeral', 'asc');
          }else{
            $this->db->select('LMS_COMP_QUES.ctop_id,LMS_COMP_QUES.id,LMS_COMP_TOP.title_name_th,LMS_COMP_TOP.title_name_en')
                     ->from('LMS_COMP_TOP')
                     ->join('LMS_COMP_QUES', 'LMS_COMP_TOP.id = LMS_COMP_QUES.ctop_id')
                     ->where('LMS_COMP_TOP.comp_id', $com_p)
                     ->where('LMS_COMP_QUES.hidden', '1')
                     ->order_by('LMS_COMP_QUES.numeral', 'asc');
          }
            $query = $this->db->get();
            $result = $query->result_array();
            $num = 1;
            $ctop_id = "";
            $ques_id = "";
            $title_name_th = "";
            $title_name_en = "";
            $num_rechk = count($result);
            foreach ($result as $each) {
              if($num==1){
                $ctop_id = $each['ctop_id'];
                $ques_id = $each['id'];
                $title_name_th = $each['title_name_th'];
                $title_name_en = $each['title_name_en'];
              }
              $num++;
            }
            $data_resend = array(
                'num_rechk'     => $num_rechk,
                'status'     => '0',
                'ques_id' => $ques_id,
                'ctop_id' => $ctop_id,
                'title_name_th' => $title_name_th,
                'title_name_en' => $title_name_en
            );
        }
        return $data_resend;
      }

       public function getDataQuestion($ques_id , $ctop_id , $com_p ,$emp_c)
      {
          $result = array();
          if($ctop_id!=""&&$ques_id!=""){
              $this->db->from('LMS_COMP_EMP_DE')
                       ->join('LMS_COMP_EMP','LMS_COMP_EMP_DE.comp_emp_id = LMS_COMP_EMP.id')
                       ->where('LMS_COMP_EMP.emp_c', $emp_c)
                       ->where('LMS_COMP_EMP.com_p', $com_p)
                       ->where('LMS_COMP_EMP_DE.status', '0');
              $query_count = $this->db->get();
            if($query_count->num_rows() > 0){
            $this->db->from('LMS_COMP_QUES')
                           ->where('LMS_COMP_QUES.id', $ques_id)
                           ->where('LMS_COMP_QUES.ctop_id', $ctop_id);
            $query = $this->db->get();
            $result = $query->result_array();

              
              $this->db->from('LMS_COMP_EMP_DE')
                       ->join('LMS_COMP_EMP','LMS_COMP_EMP_DE.comp_emp_id = LMS_COMP_EMP.id')
                       ->where('LMS_COMP_EMP.emp_c', $emp_c)
                       ->where('LMS_COMP_EMP_DE.ctop_id', $ctop_id)
                       ->where('LMS_COMP_EMP_DE.status', '1');
              $query_counttopic = $this->db->get();
              $result_counttopic = $query_counttopic->result_array();
              $this->db->from('LMS_COMP_QUES')
                       ->join('LMS_COMP_TOP','LMS_COMP_QUES.ctop_id = LMS_COMP_TOP.id')
                       ->where('LMS_COMP_TOP.comp_id', $com_p);
              $query_main = $this->db->get();
              $result_main = $query_main->result_array();

              $this->db->from('LMS_COMP_EMP_DE')
                       ->join('LMS_COMP_EMP','LMS_COMP_EMP_DE.comp_emp_id = LMS_COMP_EMP.id')
                       ->where('LMS_COMP_EMP.emp_c', $emp_c)
                       ->where('LMS_COMP_EMP.com_p', $com_p)
                       ->where('LMS_COMP_EMP_DE.status', '1');
              $query_count = $this->db->get();
              $result_count = $query_count->result_array();
              $this->db->from('LMS_COMP_QUES')
                       ->join('LMS_COMP_TOP','LMS_COMP_QUES.ctop_id = LMS_COMP_TOP.id')
                       ->where('LMS_COMP_QUES.ctop_id', $ctop_id)
                       ->where('LMS_COMP_TOP.comp_id', $com_p);
              $query_maintopic = $this->db->get();
              $result_maintopic = $query_maintopic->result_array();
              
              $arr = array();
                $arr1 = array('correct_choice' => 'choice_a', 'choice_th' => $result[0]['choice_a_th'],'choice_en' =>$result[0]['choice_a_en'],'image_choice' => $result[0]['image_choice_a']);
                $arr2 = array('correct_choice' => 'choice_b', 'choice_th' => $result[0]['choice_b_th'],'choice_en' =>$result[0]['choice_b_en'],'image_choice' => $result[0]['image_choice_b']);
                array_push($arr, $arr1);
                array_push($arr, $arr2);
                shuffle($arr);
              //print_r($arr);
              $result[0]['choice_a_data'] = $arr[0];
              $result[0]['choice_b_data'] = $arr[1];
              $result[0]['maintopic'] = count($result_maintopic);
              $result[0]['correct_answer'] = $result_maintopic[0]['correct_answer'];
              $result[0]['title_name_th'] = $result_maintopic[0]['title_name_th'];
              $result[0]['title_name_en'] = $result_maintopic[0]['title_name_en'];
              $result[0]['question_th'] = $result[0]['question_th'];
              $result[0]['question_en'] = $result[0]['question_en'];
              $result[0]['explanation_begins_th'] = $result_maintopic[0]['explanation_begins_th'];
              $result[0]['explanation_begins_en'] = $result_maintopic[0]['explanation_begins_en'];
              $result[0]['end_quote_th'] = $result_maintopic[0]['end_quote_th'];
              $result[0]['end_quote_en'] = $result_maintopic[0]['end_quote_en'];
              $result[0]['counttopic'] = count($result_counttopic);
              $result[0]['count_question'] = (count($result_count)+1)." / ".count($result_main);
              $result[0]['count_total'] = count($result_main);
              $result[0]['count_success'] = count($result_count);
              $result[0]['maintopic'] = count($result_maintopic);
            }else{

              $this->db->from('LMS_COMP_EMP_DE')
                       ->join('LMS_COMP_EMP','LMS_COMP_EMP_DE.comp_emp_id = LMS_COMP_EMP.id')
                       ->where('LMS_COMP_EMP.emp_c', $emp_c)
                       ->where('LMS_COMP_EMP_DE.ctop_id', $ctop_id)
                       ->where('LMS_COMP_EMP_DE.status', '1');
              $query_counttopic = $this->db->get();
              $result_counttopic = $query_counttopic->result_array();
              $this->db->from('LMS_COMP_QUES')
                       ->join('LMS_COMP_TOP','LMS_COMP_QUES.ctop_id = LMS_COMP_TOP.id')
                       ->where('LMS_COMP_TOP.comp_id', $com_p);
              $query_main = $this->db->get();
              $result_main = $query_main->result_array();

              $this->db->from('LMS_COMP_EMP_DE')
                       ->join('LMS_COMP_EMP','LMS_COMP_EMP_DE.comp_emp_id = LMS_COMP_EMP.id')
                       ->where('LMS_COMP_EMP.emp_c', $emp_c)
                       ->where('LMS_COMP_EMP.com_p', $com_p)
                       ->where('LMS_COMP_EMP_DE.status', '1');
              $query_count = $this->db->get();
              $result_count = $query_count->result_array();
              $this->db->from('LMS_COMP_QUES')
                       ->join('LMS_COMP_TOP','LMS_COMP_QUES.ctop_id = LMS_COMP_TOP.id')
                       ->where('LMS_COMP_QUES.ctop_id', $ctop_id)
                       ->where('LMS_COMP_TOP.comp_id', $com_p);
              $query_maintopic = $this->db->get();
              $result_maintopic = $query_maintopic->result_array();
              $result[0]['counttopic'] = count($result_counttopic);
              $result[0]['count_question'] = (count($result_count)+1)." / ".count($result_main);
              $result[0]['count_total'] = count($result_main);
              $result[0]['count_success'] = count($result_count);
              $result[0]['maintopic'] = count($result_maintopic);
            }
          }
          //print_r($result);
          return $result;
      }
      public function getDataQuestionDemo($ques_id , $ctop_id , $com_p ,$emp_c ,$arr_topic)
      {
          $array_test = array();
          $this->db->from('LMS_COMP_QUES')
                         ->where('LMS_COMP_QUES.id', $ques_id)
                         ->where('LMS_COMP_QUES.ctop_id', $ctop_id);
          $query = $this->db->get();
          $result = $query->result_array();
          $this->db->from('LMS_COMP_QUES')
                   ->join('LMS_COMP_TOP','LMS_COMP_QUES.ctop_id = LMS_COMP_TOP.id')
                   ->where('LMS_COMP_TOP.comp_id', $com_p);
          $query_main = $this->db->get();
          $result_main = $query_main->result_array();

          $this->db->from('LMS_COMP_QUES')
                   ->join('LMS_COMP_TOP','LMS_COMP_QUES.ctop_id = LMS_COMP_TOP.id')
                   ->where('LMS_COMP_QUES.ctop_id', $ctop_id)
                   ->where('LMS_COMP_TOP.comp_id', $com_p);
          $query_maintopic = $this->db->get();
          $result_maintopic = $query_maintopic->result_array();

          $result[0]['key'] =  "key:".count($result_maintopic);
          $num = 0;
          if(isset($arr_topic)){
            if($arr_topic!="0"){
              $num =  count($arr_topic)+1;
              foreach ($arr_topic as $key => $value) {
                array_push($array_test, $value);
              }
            }else{
              $num = 0;
            }
          }else{
            $num = 0;
          }
            $result[0]['line'] = count($arr_topic);
          $arr = array();
          $arr1 = array('correct_choice' => 'choice_a', 'choice' => $result[0]['choice_a_th'],'choice_a_en' =>$result[0]['choice_a_en'],'image_choice' => $result[0]['image_choice_a']);
          $arr2 = array('correct_choice' => 'choice_b', 'choice' => $result[0]['choice_b_th'],'choice_b_en' =>$result[0]['choice_b_en'],'image_choice' => $result[0]['image_choice_b']);
          array_push($arr, $arr1);
          array_push($arr, $arr2);
          shuffle($arr);
          $result[0]['choice_a_data'] = $arr[0];
          $result[0]['choice_b_data'] = $arr[1];
          $result[0]['title_name_th'] = $result_maintopic[0]['title_name_th'];
          $result[0]['title_name_en'] = $result_maintopic[0]['title_name_en'];
          $result[0]['question_th'] = $result[0]['question_th'];
          $result[0]['question_en'] = $result[0]['question_en'];
          $result[0]['explanation_begins_th'] = $result_maintopic[0]['explanation_begins_th'];
          $result[0]['explanation_begins_en'] = $result_maintopic[0]['explanation_begins_en'];
          $result[0]['end_quote_th'] = $result_maintopic[0]['end_quote_th'];
          $result[0]['end_quote_en'] = $result_maintopic[0]['end_quote_en'];
          $result[0]['choice_a'] = $arr[0]['correct_choice'];
          $result[0]['choice_b'] = $arr[1]['correct_choice'];
          $result[0]['choicebtn1'] = $arr[0]['choice'];
          $result[0]['choicebtn2'] = $arr[1]['choice'];
          $result[0]['image_choice_a'] = $arr[0]['image_choice'];
          $result[0]['image_choice_b'] = $arr[1]['image_choice'];
          //echo count($arr_topic);
          if($arr_topic!="0"){
            if(count($arr_topic)>0){
              if(in_array($ctop_id, $arr_topic)){
                $result[0]['counttopic'] = count($arr_topic);
              }else{
                $result[0]['counttopic'] = '0';
              }
              //print_r($counts);
              
              //echo $counts[$ctop_id];
            }else{
              $result[0]['counttopic'] = count($arr_topic);
            }
          }else{
            $result[0]['counttopic'] = "0";
          }
          $result[0]['count_question'] = count($result_main);
          $result[0]['count_total'] = count($result_main);
          $result[0]['count_success'] = count($arr_topic);
          $result[0]['maintopic'] = count($result_maintopic);
          return $result;
      }

      public function rechkCountQuestion($comp_id)
      {
          $this->db->from('LMS_COMP_QUES')
                   ->join('LMS_COMP_TOP', 'LMS_COMP_QUES.ctop_id = LMS_COMP_TOP.id')
                   ->where('LMS_COMP_TOP.comp_id', $comp_id);
          $query = $this->db->get();
          $result = $query->result();
          $row = $query->row_array();
          return $row;
      }

      public function rechkDataAnswer($emp_c , $ques_id , $ctop_id , $type_answer ,$correct_answer)
      {
        date_default_timezone_set("Asia/Bangkok");
          $count_answer = 0;
          $id = "";
          $status = "";
          $this->db->select('LMS_COMP_EMP_DE.id,LMS_COMP_EMP_DE.count_answer,LMS_COMP_EMP_DE.status')
                   ->from('LMS_COMP_EMP_DE')
                   ->join('LMS_COMP_EMP', 'LMS_COMP_EMP_DE.comp_emp_id = LMS_COMP_EMP.id')
                   ->where('LMS_COMP_EMP.emp_c', $emp_c)
                   ->where('LMS_COMP_EMP_DE.ctop_id', $ctop_id)
                   ->where('LMS_COMP_EMP_DE.ques_id', $ques_id);
          $query = $this->db->get();
          $result = $query->result_array();

          foreach ($result as $each) {
            $status = $each['status'];
            $count_answer = intval($each['count_answer']);
            $id = $each['id'];
          }
          if($status!='1'){
            $count_answer++;
          }
          $status_ans = "";
          if($correct_answer!=$type_answer){
            $status_ans = "0";
            $this->db->where('id',$id)
                     ->set('time_mod',date('Y-m-d H:i'))
                     ->set('count_answer', $count_answer)
                     ->set('status', '0')
                     ->update('LMS_COMP_EMP_DE');
          }else{
            $status_ans = "1";
            $this->db->where('id',$id)
                     ->set('time_mod',date('Y-m-d H:i'))
                     ->set('count_answer', $count_answer)
                     ->set('status', '1')
                     ->update('LMS_COMP_EMP_DE');
          }

          return $status_ans;
      }

      public function rechkDataAnswerDemo($emp_c , $ques_id , $ctop_id , $type_answer)
      {
        date_default_timezone_set("Asia/Bangkok");
          $count_answer = 0;
          $id = "";
          $status = "";
          $status_ans = "";
          $this->db->from('LMS_COMP_QUES')
                   ->where('LMS_COMP_QUES.ctop_id', $ctop_id)
                   ->where('LMS_COMP_QUES.id', $ques_id)
                   ->where('LMS_COMP_QUES.correct_answer', $type_answer);
          $query = $this->db->get();
          $row = $query->row_array();
          if($row>0){
            $status_ans = "1";
          }else{
            $status_ans = "0";
          }

          return $status_ans;
      }

      public function getCompliance()
      {
        $this->db->from('LMS_COMP')
                 ->where('LMS_COMP.hidden', '1')
                 ->order_by('id', 'desc');
        $query = $this->db->get();
        return $query->result();
      }
      public function getFinishMSG()
      {
        $this->db->from('LMS_COMP_FINISH_MSG');
        $query = $this->db->get();
        return $query->result_array();
      }

      public function rechktopic_incompliance($com_p)
      {
        $this->db->distinct();
        $this->db->select('LMS_COMP_TOP.id,LMS_COMP_TOP.title_name_th,LMS_COMP_TOP.title_name_en');
        $this->db->from('LMS_COMP_TOP')
                 ->where('LMS_COMP_TOP.status','1')
                 ->where('LMS_COMP_TOP.comp_id', $com_p);
        $query = $this->db->get();
        return $query->result_array();
      }

      public function rechkcompany_level()
      {
        $this->db->distinct();
        $this->db->select('LMS_ORG1.code,LMS_ORG1.name');
        $this->db->from('LMS_ORG1')
                 ->where('LMS_ORG1.orgfor', 'tis');
        $query = $this->db->get();
        return $query->result_array();
      }

      public function countReportStaff($comp_id,$lang){
        $output = array();
        $this->db->select('LMS_COMP_EMP.emp_c,LMS_COMP_EMP.status')
             ->distinct()
             ->from('LMS_COMP_EMP')
             ->join('LMS_EMP','LMS_COMP_EMP.emp_c = LMS_EMP.emp_c')
             ->where('LMS_EMP.lang',$lang)
             ->where('LMS_COMP_EMP.com_p', $comp_id);
        $this->db->where('LMS_EMP.org1', 'TIS');
        $this->db->join('LMS_USP','LMS_EMP.emp_c = LMS_USP.emp_c');
        $this->db->where('LMS_USP.dummy_status', '0');
        $this->db->where('(LMS_EMP.status = "active"', NULL, FALSE);
        $this->db->or_where("LMS_EMP.status = 'Active')", NULL, FALSE);
        $query = $this->db->get();
        $row = $query->result();
        $result_ques = $query->result_array();
        $completed = 0;
        $not_respond = 0;
        $not_completed = 0;
        foreach ($result_ques as $key) {
          if($key['status']=="1"){
            $completed++;
          }else if($key['status']=="2"){
            $not_respond++;
          }else{
            $not_completed++;
          }
        }
        $output['completed'] = $completed;
        $output['not_respond'] = $not_respond;
        $output['not_completed'] = $not_completed;
        $output['total'] = count($row);
        return $output;
      }
      public function chkdataComplianceStatus($comp_id,$lang){
        $msg='';
        $msg .= '<tr>';
        $msg .= '<th width="100px"></th>';
        $msg .= '<th width="100px">Employee no.</th>';
        $msg .= '<th width="100px">Name</th>';
        $msg .= '<th width="100px">Surname</th>';
        $msg .= '<th width="100px">Department</th>';
        $msg .= '<th width="100px">E-Mail</th>';
        $msg .= '<th width="100px" align="center">Status</th>';
        $msg .= '</tr>';
        return $msg;
      }
      
      public function chkdataCompliance($comp_id,$lang){
        echo '<tr>';
        echo '<th width="100px">Employee no.</th>';
        echo '<th width="100px">Name</th>';
        echo '<th width="100px">Surname</th>';
        echo '<th width="100px">Department</th>';
                    $this->db->select('LMS_COMP_QUES.id,LMS_COMP_QUES.ctop_id')
                             ->from('LMS_COMP_TOP')
                             ->join('LMS_COMP_QUES', 'LMS_COMP_TOP.id = LMS_COMP_QUES.ctop_id')
                             ->where('LMS_COMP_TOP.comp_id', $comp_id);
                    $query = $this->db->get();
                    $row = $query->result();
                    $result_ques = $query->result_array();
        for($num=1;$num<=count($row);$num++){
          echo '<th width="50px" align="center">Q'.$num.'</th>';
        }
        echo '</tr>';
      }
    function getValOrg($numorg = '',$val=''){
      $this->db->select('LMS_ORG'.$numorg.'.name')
               ->from('LMS_ORG'.$numorg)
               ->where('LMS_ORG'.$numorg.'.code',$val);
      $query = $this->db->get();
      $fetch = $query->row_array();
      return $fetch['name'];
    }
      function fetch_report_staff($comp_id,$lang){

                    $this->db->select('LMS_COMP_QUES.id,LMS_COMP_QUES.ctop_id')
                             ->from('LMS_COMP_TOP')
                             ->join('LMS_COMP_QUES', 'LMS_COMP_TOP.id = LMS_COMP_QUES.ctop_id')
                             ->where('LMS_COMP_TOP.comp_id', $comp_id);
                    $query = $this->db->get();
                    $row = $query->result();
                    $result_ques = $query->result_array();
        $this->db->select('LMS_EMP.emp_c,LMS_EMP.fname,LMS_EMP.lname,LMS_EMP.org1,LMS_EMP.org2,LMS_EMP.email');
        $this->db->distinct();
        $this->db->from('LMS_EMP');
        $this->db->join('LMS_USP','LMS_EMP.emp_c = LMS_USP.emp_c');
        $this->db->where('LMS_EMP.org1', 'TIS');
        $this->db->where('LMS_USP.dummy_status', '0');
        $this->db->where('(LMS_EMP.status = "active"', NULL, FALSE);
        $this->db->or_where("LMS_EMP.status = 'Active')", NULL, FALSE);
        $this->db->where('LMS_EMP.lang', 'english');
        $query = $this->db->get();
        $row = $query->row_array();
        $result = $query->result_array();

        $data = array();
        $num = 1;
        foreach ($result as $each) {

          $output = array(
              $each['emp_c'],
              $each['fname'],
              $each['lname'],
              $this->getValOrg('2',$each['org2']) 
          );
          foreach ($result_ques as $ques) {
            $this->db->select('LMS_COMP_EMP_DE.count_answer')
                     ->from('LMS_COMP_EMP')
                     ->join('LMS_COMP_EMP_DE', 'LMS_COMP_EMP.id = LMS_COMP_EMP_DE.comp_emp_id')
                     ->where('LMS_COMP_EMP.emp_c', $each['emp_c'])
                     ->where('LMS_COMP_EMP_DE.ctop_id', $ques['ctop_id'])
                     ->where('LMS_COMP_EMP_DE.ques_id', $ques['id']);
            $query = $this->db->get();
            $row = $query->result();
            $count_answer = 0;
            if(count($row)>0){
              $result_emp = $query->result_array();
              foreach ($result_emp as $emp) {
                $count_answer = intval($emp['count_answer']);
              }
            }
            array_push($output, $count_answer);
            //echo '<td width="50px" align="center">'.$count_answer.'</td>';
          }
          array_push($data, $output);
          $num++;
        }
        return $data;
      }


      function fetch_report_status($comp_id,$lang){

                    $this->db->select('LMS_COMP_QUES.id,LMS_COMP_QUES.ctop_id')
                             ->from('LMS_COMP_TOP')
                             ->join('LMS_COMP_QUES', 'LMS_COMP_TOP.id = LMS_COMP_QUES.ctop_id')
                             ->where('LMS_COMP_TOP.comp_id', $comp_id);
                    $query = $this->db->get();
                    $row = $query->result();
                    $result_ques = $query->result_array();
        $this->db->select('LMS_EMP.emp_c,LMS_EMP.fname,LMS_EMP.lname,LMS_EMP.org1,LMS_EMP.org2,LMS_EMP.email');
        $this->db->distinct();
        $this->db->from('LMS_EMP');
        $this->db->join('LMS_USP','LMS_EMP.emp_c = LMS_USP.emp_c');
        $this->db->where('LMS_USP.dummy_status', '0');
        $this->db->where('LMS_EMP.org1', 'TIS');
        $this->db->where('LMS_EMP.lang', 'english');
        $this->db->where('(LMS_EMP.status = "active"', NULL, FALSE);
        $this->db->or_where("LMS_EMP.status = 'Active')", NULL, FALSE);

        $query = $this->db->get();
        $row = $query->row_array();
        $result = $query->result_array();

        $data = array();
        $num = 1;
        foreach ($result as $each) {
          $msg_status = "";
            $this->db->select('LMS_COMP_EMP.status')
                     ->from('LMS_COMP_EMP')
                     ->where('LMS_COMP_EMP.emp_c', $each['emp_c'])
                     ->where('LMS_COMP_EMP.com_p', $comp_id);
            $query = $this->db->get();
            $row = $query->result();
            $count_answer = 0;
            if(count($row)>0){
              $result_emp = $query->result_array();
              foreach ($result_emp as $emp) {
                if($emp['status']=="1"){
                  $msg_status = "Complete";
                }else if($emp['status']=="2"){
                  $msg_status = "No Response";
                }else{
                  $msg_status = "Not Complete";
                }
              }
            }

          $output = array(
              $each['emp_c'],
              $each['fname'],
              $each['lname'],
              $this->getValOrg('2',$each['org2']),
              $each['email'],
              $msg_status
          );
            //echo '<td width="50px" align="center">'.$count_answer.'</td>';
          array_push($data, $output);
          $num++;
        }
        return $data;
      }


      function fetch_report_question($comp_id,$lang){

        $this->db->select('LMS_COMP_TOP.title_name_th,LMS_COMP_TOP.title_name_en,LMS_COMP_QUES.question_th,LMS_COMP_QUES.question_en,LMS_COMP_QUES.id,LMS_COMP_QUES.ctop_id')
                 ->from('LMS_COMP_TOP')
                 ->join('LMS_COMP_QUES', 'LMS_COMP_TOP.id = LMS_COMP_QUES.ctop_id')
                 ->where('LMS_COMP_TOP.comp_id', $comp_id);
        $query = $this->db->get();
        $row = $query->row_array();
        $result = $query->result_array();

        $data = array();
        $num = 1;
        foreach ($result as $each) {
          $title_name = "";
          if($lang=="thailand"){
            $title_name = $each['title_name_th'];
          }else{
            $title_name = $each['title_name_en'];
          }
          $output = array(
              "Q".$num,
              $title_name,
              $each['question_en'],
              $each['question_th']
          );
          $first = 0;
          $second = 0;
          $third = 0;
          $fourth = 0;
          $fifth = 0;
          $more_than = 0;

            $this->db->select('LMS_COMP_EMP_DE.count_answer')
                     ->from('LMS_COMP_EMP')
                     ->join('LMS_USP', 'LMS_COMP_EMP.emp_c = LMS_USP.emp_c')
                     ->join('LMS_COMP_EMP_DE', 'LMS_COMP_EMP.id = LMS_COMP_EMP_DE.comp_emp_id')
                     ->where('LMS_USP.dummy_status', '0')
                     ->where('LMS_COMP_EMP_DE.ctop_id', $each['ctop_id'])
                     ->where('LMS_COMP_EMP_DE.ques_id', $each['id']);
            $query = $this->db->get();
            $row = $query->result();
            $count_answer = 0;
            if(count($row)>0){
              $result_emp = $query->result_array();
              foreach ($result_emp as $emp) {
                $count_answer = intval($emp['count_answer']);
                if($count_answer==1){
                  $first++;
                }else if($count_answer==2){
                  $second++;
                }else if($count_answer==3){
                  $third++;
                }else if($count_answer==4){
                  $fourth++;
                }else if($count_answer==5){
                  $fifth++;
                }else if($count_answer>5){
                  $more_than++;
                }
              }
            }

          array_push($output, $first);
          array_push($output, $second);
          array_push($output, $third);
          array_push($output, $fourth);
          array_push($output, $fifth);
          array_push($output, $more_than);
          array_push($data, $output);
          $num++;
        }
        return $data;
      }


      public function create_finish($data)
      {
        date_default_timezone_set("Asia/Bangkok");
        if($data['id']!=""){
          $this->db->where('id',$data['id']);
          $this->db->update('LMS_COMP_FINISH_MSG', $data);
          $id = $data['id'];
        }else{
          $this->db->insert('LMS_COMP_FINISH_MSG', $data);
          $id = $this->db->insert_id();
        }
        return $id;
      }
}
?>
