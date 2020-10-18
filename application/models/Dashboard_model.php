<?php
class Dashboard_model extends CI_Model {

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

        public function log_usersys($type_device){
            $user = $this->session->userdata('user');
            $this->db->select('LMS_LG.id');
            $this->db->from('LMS_LG');
            $this->db->join('LMS_EMP','LMS_LG.emp_id = LMS_EMP.emp_id');
            if(in_array($user['ug_id'], array('2','6'))){
              $this->db->where('LMS_EMP.com_id',$user['com_id']);
            }
            $this->db->like('LMS_LG.device',$type_device);
            $query = $this->db->get();
            return $query->num_rows();
        }

        public function course_select(){
            $user = $this->session->userdata('user');
            $this->db->select('cos_id,ccode,cname_th,cname_eng');
            $this->db->from('LMS_COS');
            $this->db->where('LMS_COS.com_id',$user['com_id']);
            $this->db->where('LMS_COS.cos_status','1');
            $query = $this->db->get();
            return $query->result_array();
        }

        public function courseCourses($emp_c, $lang) {
          $this->db->select('LMS_PLV.course_id');
          $this->db->distinct();
          $this->db->from('LMS_PLV');
          $this->db->join('LMS_EMP', 'LMS_PLV.org_c = LMS_EMP.main_pos');
          $this->db->where('LMS_EMP.emp_c', $emp_c);
          $query = $this->db->get();
          return $query->result_array();
        }

        public function getCourses($emp_c, $lang) {
          $this->db->select('LMS_COS.ccode, LMS_COS.cname, LMS_COS.cdesc, LMS_COS.coursetype, LMS_COS.approve_pp, LMS_COS.time_open, LMS_COS.time_end
            , LMS_ENS.enroll_status1, LMS_ENS.enroll_status2');
          $this->db->distinct();
          $this->db->from('LMS_COS');
          $this->db->join('LMS_ENS', 'LMS_ENS.course_id = LMS_COS.ccode');
          $this->db->where('LMS_ENS.emp_c', $emp_c);
          $this->db->where('lang', $lang);
          $this->db->where('LMS_COS.cos_status', 1);
          $this->db->where('LMS_ENS.del_type is null');
          $this->db->order_by('LMS_ENS.time_request', 'DESC');
          $query = $this->db->get();
          return $query->result_array();
        }

        public function divideStatus($emp_c, $course, $role) {//$lesFlag, $qizFlag, $role) {
          date_default_timezone_set("Asia/Bangkok");
          /*$l = $lesFlag == 'true'?TRUE:FALSE;
          $q = $qizFlag == 'true'?TRUE:FALSE;*/

          $this->db->select('LMS_COS.time_end, LMS_ENS.finish_time, LMS_ENS.first_time, LMS_QIZ_TC.sum_score');
          $this->db->distinct();
          $this->db->from('LMS_COS');
          $this->db->join('LMS_ENS', 'LMS_ENS.course_id = LMS_COS.ccode');
          $this->db->join('LMS_QIZ', 'LMS_QIZ.courses_id = LMS_ENS.course_id', 'left');
          $this->db->join('LMS_QIZ_TC', 'LMS_QIZ_TC.quiz_id = LMS_QIZ.qcode', 'left');
          $this->db->where('LMS_COS.ccode', $course);
          $this->db->where('LMS_ENS.emp_c', $emp_c);
          $query = $this->db->get();
          $result = $query->row_array();

          if(is_null($result['first_time'])) {
            $status = 'Not Started';
          } elseif(is_null($result['finish_time']) && $result['time_end'] > strtotime(date('Y-m-d H:i'))) {
            $status = 'In Progress';
          } elseif(!is_null($result['finish_time'])) {
            $status = 'Completed';
          } else {
            $status = 'In Progress';
          }

          /*if(in_array($role, array("superadmin", "admin"))) {
            if(strtotime($course['time_open']) > strtotime(date('Y-m-d H:i'))) $status = 'Not Started';
            elseif($l && $q) $status = 'Completed';
            //elseif(strtotime($course['time_end']) < strtotime(date('Y-m-d H:i'))) $status = 'Completed';
            else $status = 'In Progress';
          } else {
            $level = $this->getLevel($emp_c);

            if($level == '1' && $course['enroll_status1'] == 'no') $status = 'Not Started';
            elseif($level == '2' && ($course['enroll_status1'] == 'no'
              || $course['enroll_status2'] == 'no')) $status = 'Not Started';
            elseif(strtotime($course['time_open']) > strtotime(date('Y-m-d H:i'))) $status = 'Not Started';
            elseif($l && $q) $status = 'Completed';
            //elseif(strtotime($course['time_end']) < strtotime(date('Y-m-d H:i'))) $status = 'Completed';
            else $status = 'In Progress';
          }*/

          return $status;
        }

        public function countCourses($course, $counter) {
          if($course['status'] == 'Completed') $counter['coc']++;
          elseif($course['status'] == 'In Progress') $counter['coip']++;
          elseif($course['status'] == 'Not Started') $counter['cons']++;

          return $counter;
        }

        public function getAnnoucements($emp_c, $emps, $lang) {
          //get all emp_c
          $emps_c = [];
          foreach($emps as $emp) {
            $emps_c[] = $emp['emp_c'];
          }
          //get level-1 emps
          $this->db->select('LMS_EMP.emp_c, LMS_EMP.prefix, LMS_EMP.fname
            , LMS_EMP.lname, LMS_COS.ccode, LMS_COS.cname, LMS_ENS.time_request');
          $this->db->from('LMS_ENS');
          $this->db->join('LMS_EMP', 'LMS_EMP.emp_c = LMS_ENS.emp_c');
          $this->db->join('LMS_COS', 'LMS_COS.ccode = LMS_ENS.course_id');
          $this->db->where('LMS_COS.lang', $lang);
          $this->db->where('LMS_EMP.lang', $lang);
          $this->db->where('LMS_EMP.level', 1);
          $this->db->where('LMS_ENS.enroll_status1 !=', 'yes');
          $this->db->where('LMS_COS.cos_status', 1);

          $this->db->where_in('LMS_ENS.emp_c', $emps_c);

          $this->db->order_by('LMS_ENS.time_request', 'ASC');
          $this->db->limit(2);
          $query = $this->db->get();
          $l1emps = $query->result_array();
          //get level-2 emps
          $this->db->select('LMS_EMP.emp_c, LMS_EMP.prefix, LMS_EMP.fname
            , LMS_EMP.lname, LMS_COS.ccode, LMS_COS.cname, LMS_ENS.time_request');
          $this->db->from('LMS_ENS');
          $this->db->join('LMS_EMP', 'LMS_EMP.emp_c = LMS_ENS.emp_c');
          $this->db->join('LMS_COS', 'LMS_COS.ccode = LMS_ENS.course_id');
          $this->db->where('LMS_COS.lang', $lang);
          $this->db->where('LMS_EMP.lang', $lang);
          $this->db->where('LMS_EMP.level', 2);
          $this->db->where('LMS_EMP.lead', $emp_c);
          $this->db->where('LMS_ENS.enroll_status1 !=', 'yes');
          $this->db->where('LMS_COS.cos_status', 1);

          $this->db->where_in('LMS_ENS.emp_c', $emps_c);

          $this->db->order_by('LMS_ENS.time_request', 'ASC');
          $this->db->limit(2);
          $query = $this->db->get();
          $l2emps = $query->result_array();
          //get level-2 emps for high-level lead
          $this->db->select('LMS_EMP.emp_c, LMS_EMP.prefix, LMS_EMP.fname
            , LMS_EMP.lname, LMS_COS.ccode, LMS_COS.cname, LMS_ENS.time_request');
          $this->db->from('LMS_ENS');
          $this->db->join('LMS_EMP', 'LMS_EMP.emp_c = LMS_ENS.emp_c');
          $this->db->join('LMS_COS', 'LMS_COS.ccode = LMS_ENS.course_id');
          $this->db->where('LMS_COS.lang', $lang);
          $this->db->where('LMS_EMP.lang', $lang);
          $this->db->where('LMS_EMP.level', 2);
          $this->db->where('LMS_EMP.lead !=', $emp_c);
          $this->db->where('LMS_ENS.enroll_status1', 'yes');
          $this->db->where('LMS_ENS.enroll_status2 !=', 'yes');
          $this->db->where('LMS_COS.cos_status', 1);

          $this->db->where_in('LMS_ENS.emp_c', $emps_c);

          $this->db->order_by('LMS_ENS.time_request', 'ASC');
          $this->db->limit(2);
          $query = $this->db->get();
          $l2emps2 = $query->result_array();
          //array concat
          $alemps = [];
          foreach($l1emps as $emp) {
            $alemps[] = $emp;
          }
          foreach($l2emps as $emp) {
            $alemps[] = $emp;
          }
          foreach($l2emps2 as $emp) {
            $alemps[] = $emp;
          }
          return $alemps;
        }

        public function getBadges($emp_c) {
          $this->db->select('LMS_BAD.id , LMS_BAD.badges_name, LMS_BAD.badges_img, LMS_BAD.courses_id, LMS_COS.cname, LMS_ENS.finish_time,LMS_EMP.prefix,LMS_EMP.fname,LMS_EMP.lname,LMS_ORG2.name');
          $this->db->distinct();
          $this->db->from('LMS_UHB_TC');
          $this->db->join('LMS_BAD', 'LMS_BAD.id = LMS_UHB_TC.badges_id');
          $this->db->join('LMS_COS', 'LMS_COS.ccode = LMS_BAD.courses_id');
          $this->db->join('LMS_ENS', 'LMS_ENS.course_id = LMS_COS.ccode');
          $this->db->join('LMS_EMP', 'LMS_EMP.emp_c = LMS_ENS.emp_c');
          $this->db->join('LMS_ORG2', 'LMS_ORG2.code = LMS_EMP.org2');
          $this->db->where('LMS_UHB_TC.emp_c', $emp_c);
          $this->db->where('LMS_ENS.emp_c', $emp_c);
          $this->db->where('LMS_ENS.finish_time is not null');
          $this->db->order_by('LMS_ENS.finish_time', 'DESC');
          $query = $this->db->get();
          return $query->result_array();
        }

        public function getCourse($emp_c, $lang) {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->select('LMS_COS.ccode, LMS_COS.cname, LMS_COS.time_open, LMS_COS.time_end');
          $this->db->distinct();
          $this->db->from('LMS_COS');
          $this->db->join('LMS_ENS', 'LMS_ENS.course_id = LMS_COS.ccode');
          $this->db->where('LMS_ENS.emp_c', $emp_c);
          $this->db->where('lang', $lang);
          $this->db->where('LMS_COS.time_open <=', date('Y-m-d H:i'));
          $this->db->where('LMS_COS.time_end >=', date('Y-m-d H:i'));
          $this->db->where('LMS_COS.cos_status', 1);
          $this->db->order_by('LMS_ENS.time_request', 'DESC');
          $query = $this->db->get();
          return $query->row_array();
        }


        public function fetch_grade($user,$grade='') {
          date_default_timezone_set("Asia/Bangkok");
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->db->from('LMS_COS_ENROLL');
          $this->db->join('LMS_COS','LMS_COS_ENROLL.cos_id = LMS_COS.id');
          $this->db->where('LMS_COS_ENROLL.emp_id',$user['emp_id']);
          $this->db->where('LMS_COS_ENROLL.cosen_grade',$grade);
          $query = $this->db->get();
          $fetch = $query->result_array();
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
              $output = array();
              $output['0'] = $num;$num++;
              if($lang=="thai"){
                $output['1'] = $value['cname_th'];
              }else{
                $output['1'] = $value['cname_eng'];
              }
              $output['2'] = $value['cosen_grade'];
              $output['3'] = $value['cosen_score'];
              if($value['cosen_finishtime']!="0000-00-00 00:00:00"){
                $output['4'] = date('d/m/Y H:i',strtotime($value['cosen_finishtime']));
              }else{
                $output['4'] = '-';
              }
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function getEvents($emp_c, $lang) {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->select('LMS_COS.ccode, LMS_COS.cname, LMS_COS.time_open');
          $this->db->distinct();
          $this->db->from('LMS_COS');
          $this->db->join('LMS_ENS', 'LMS_ENS.course_id = LMS_COS.ccode');
          $this->db->where('LMS_ENS.emp_c', $emp_c);
          $this->db->where('lang', $lang);
          $this->db->where('time_open >', date('Y-m-d H:i'));
          $this->db->where('LMS_COS.cos_status', 1);
          $this->db->order_by('LMS_COS.time_open', 'ASC');
          $this->db->limit(3);
          $query = $this->db->get();
          return $query->result_array();
        }

        public function getOnlineUsers() {
          $this->db->select('useri');
          $this->db->where('st_on', 'online');
          $this->db->order_by('last_act', 'DESC');
          $query = $this->db->get('LMS_USP');

          return $query->result_array();
        }

        public function getEnrollStatus($course_id, $emp_c) {
          $this->db->select('LMS_ENS.course_id, LMS_ENS.emp_c, LMS_ENS.enroll_status1, LMS_ENS.enroll_status2, LMS_EMP.lead, LMS_EMP.level');
          $this->db->from('LMS_ENS');
          $this->db->join('LMS_EMP', 'LMS_EMP.emp_c = LMS_ENS.emp_c');
          $this->db->where('LMS_ENS.course_id', $course_id);
          $this->db->where('LMS_ENS.emp_c', $emp_c);
          $query = $this->db->get();
          return $query->row_array();
        }

        public function approveEmp($emp_c, $status) {
          /*if($status['enroll_status1'] == 'no') {
            $data = array(
              'approver_id1' => $emp_c,
              'enroll_status1' => 'yes'
            );
          } else {
            $data = array(
              'approver_id2' => $emp_c,
              'enroll_status2' => 'yes'
            );
          }

          $this->db->group_start();
          $this->db->or_where('LMS_ENS.approver_id1', NULL);
          $this->db->or_where('LMS_ENS.approver_id1 !=', $emp_c);
          $this->db->group_end();
          $this->db->group_start();
          $this->db->or_where('LMS_ENS.approver_id2', NULL);
          $this->db->or_where('LMS_ENS.approver_id2 !=', $emp_c);
          $this->db->group_end();

          $this->db->where('course_id', $status['course_id']);
          $this->db->where('emp_c', $status['emp_c']);
          $this->db->update('LMS_ENS', $data);*/

          if($status['level'] == 1) {
            $data = array(
              'approver_id1' => $emp_c,
              'enroll_status1' => 'yes'
            );
          } else {
            if($status['lead'] == $emp_c) {
              $data = array(
                'approver_id1' => $emp_c,
                'enroll_status1' => 'yes'
              );
            } else {
              $data = array(
                'approver_id2' => $emp_c,
                'enroll_status2' => 'yes'
              );
            }
          }

          $this->db->where('course_id', $status['course_id']);
          $this->db->where('emp_c', $status['emp_c']);
          $this->db->update('LMS_ENS', $data);
        }

        public function rejectEmp($course_id, $emp_c) {
          $this->db->where('course_id', $course_id);
          $this->db->where('emp_c', $emp_c);
          $this->db->delete('LMS_ENS');
        }

        //for admin
        public function getAllCourses($lang ,$wcode = "") {
          //echo 'Ohm : '.$wcode;
          $this->db->select('ccode, cname, cdesc, coursetype, time_open, time_end');
          $this->db->distinct();
          if( $wcode != "" ){
            $this->db->where('wcode', $wcode);
          }
          $this->db->where('lang', $lang);
          $this->db->where('status', 1);
          $this->db->order_by('time_create', 'DESC');
          $query = $this->db->get('LMS_COS');
          return $query->result_array();
        }

        public function getRecentCourse($lang) {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->select('ccode, cname, time_open, time_end');
          $this->db->distinct();
          $this->db->where('lang', $lang);
          $this->db->where('time_open <=', date('Y-m-d H:i'));
          $this->db->where('time_end >=', date('Y-m-d H:i'));
          $this->db->where('status', 1);
          $this->db->order_by('time_open', 'ASC');
          $this->db->order_by('time_end', 'ASC');
          $query = $this->db->get('LMS_COS');
          return $query->row_array();
        }

        public function getAllEvents($lang) {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->select('ccode, cname, time_open');
          $this->db->distinct();
          $this->db->where('lang', $lang);
          $this->db->where('time_open >', date('Y-m-d H:i'));
          $this->db->where('status', 1);
          $this->db->order_by('time_open', 'ASC');
          $query = $this->db->get('LMS_COS', 3);
          return $query->result_array();
        }

        private function getLevel($emp_c) {
          $this->db->select('level');
          $this->db->where('emp_c', $emp_c);
          $query = $this->db->get('LMS_EMP');
          $row = $query->row_array();
          return $row['level'];
        }

        public function getDetail($employee, $lang) {
          $this->db->select('emp_c, prefix, fname, lname, email ');
          $this->db->where('emp_c', $employee);
          $this->db->where('lang', $lang);
          $query = $this->db->get('LMS_EMP');
      		return $query->row_array();
        }

        public function getCos($ccode, $lang) {
          $this->db->select('ccode, cname');
          $this->db->from('LMS_COS');
          $this->db->where('ccode', $ccode);
          $this->db->where('lang', $lang);
          $query = $this->db->get();
          return $query->row_array();
        }

        public function getL2Head($employee, $lang) {
          $this->db->select('lead');
          $this->db->from('LMS_EMP');
          $this->db->where('emp_c', $employee);
          $this->db->where('lang', $lang);
          $query = $this->db->get();
          $row = $query->row_array();
          $head = $row['lead'];

          $this->db->select('lead');
          $this->db->from('LMS_EMP');
          $this->db->where('emp_c', $head);
          $this->db->where('lang', $lang);
          $query = $this->db->get();
          $row = $query->row_array();
          $head2 = $row['lead'];

          $this->db->select('emp_c, prefix, fname, lname, email, lead');
          $this->db->from('LMS_EMP');
          $this->db->where('emp_c', $head2);
          $this->db->where('lang', $lang);
          $query = $this->db->get();
          return $query->row_array();
        }
}
