<?php
class Calendar_model extends CI_Model {

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
        
        public function getAdjacentM($date, $btn) {
          if($btn == 'n') {
            $date = date('M Y', strtotime('+1 month', strtotime($date)));
          } elseif($btn == 'p') {
            $date = date('M Y', strtotime('-1 month', strtotime($date)));
          }
          return $date;
        }
        
        public function getAllCos($filter) {
          $this->db->select('ccode, cname, time_open, time_end, coursetype, lang');
          $this->db->from('LMS_COS');
          empty($filter) ?: $this->db->where('coursetype', $filter);
          $this->db->where('status', 1);
          $this->db->order_by('time_open', 'ASC');
          $this->db->order_by('time_end', 'ASC');
          $query = $this->db->get();
          return $query->result_array();
        }
        
        public function getMyCos($emp_c, $filter) {
          $this->db->select('LMS_COS.ccode, LMS_COS.cname, LMS_COS.time_open, LMS_COS.time_end, LMS_COS.coursetype, lang');
          $this->db->from('LMS_COS');
          $this->db->join('LMS_ENS', 'LMS_ENS.course_id = LMS_COS.ccode');
          $this->db->where('LMS_ENS.emp_c', $emp_c);
          empty($filter) ?: $this->db->where('LMS_COS.coursetype', $filter);
          $this->db->where('LMS_COS.status', 1);
          $this->db->order_by('LMS_ENS.time_request', 'DESC');
          $query = $this->db->get();
          return $query->result_array();
        }
        
        public function cc($courses) {
          $cc = array();
          foreach($courses as $key=>$course) {
            $cc[$course['ccode']] = $this->getColor($course['coursetype']);
          }
          return $cc;
        }
        
        public function getColor($coursetype) {
          switch($coursetype) {
            case "Core Programme":
              return 0;
            case "Professional Programme":
              return 3;
            case "Leadership Programme":
              return 2;
            default:
              return 5;
          }
        }
}
