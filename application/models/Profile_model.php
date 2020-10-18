<?php
class Profile_model extends CI_Model {

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

        public function loaddata_cert($user){
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->db->from('LMS_COS_ENROLL');
          $this->db->join('LMS_COS','LMS_COS_ENROLL.cos_id = LMS_COS.cos_id');
          $this->db->join('LMS_BAD','LMS_BAD.courses_id = LMS_COS_ENROLL.cos_id');
          $this->db->where('LMS_COS_ENROLL.emp_id',$user['emp_id']);
          $this->db->where('LMS_COS_ENROLL.cosen_status_sub','1');
          $this->db->where('LMS_COS_ENROLL.cosen_isDelete','0');
          //$this->db->where('LMS_COS_ENROLL.cos_id in (select LMS_CERTIFICATE.cos_id from LMS_CERTIFICATE where emp_id="'.$user['emp_id'].'")');
          $query = $this->db->get();
          $fetch = $query->result_array();
          if(count($fetch)>0){
              foreach ($fetch as $key => $value) {
                  $fetch_cug = $this->func_query->query_row('LMS_CUG','','','','course_id="'.$value['cos_id'].'"');
                  $fetch_bad = $this->func_query->query_row('LMS_BAD','','','','courses_id="'.$value['cos_id'].'"');
                    if(count($fetch_bad)>0){
                      $score_pass = 0;
                      if($fetch_bad['badges_condition']=="P"){
                        $score_pass = floatval($fetch_cug['mina']);
                      }else{
                        if($fetch_bad['badges_condition']=="A"){
                          $score_pass = floatval($fetch_cug['mina']);
                        }else if($fetch_bad['badges_condition']=="B"){
                          $score_pass = floatval($fetch_cug['minb']);
                        }else if($fetch_bad['badges_condition']=="C"){
                          $score_pass = floatval($fetch_cug['minc']);
                        }else if($fetch_bad['badges_condition']=="D"){
                          $score_pass = floatval($fetch_cug['mind']);
                        }else{
                          $score_pass = 0;
                        }
                      }
                      $cosen_score_per = round($value['cosen_score_per']);
                      if($cosen_score_per<$score_pass){
                          unset($fetch[$key]);
                      }
                    }
              }
          }
          return $fetch;
        }

        public function query_timeline($user){
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $arr = array();
          $this->db->from('LMS_COS_ENROLL');
          $this->db->join('LMS_COS','LMS_COS_ENROLL.cos_id = LMS_COS.cos_id');
          $this->db->where('LMS_COS_ENROLL.emp_id',$user['emp_id']);
          $this->db->like('LMS_COS_ENROLL.cosen_firsttime',date('Y-m'));
          $query_firsttime = $this->db->get();
          $fetch_firsttime = $query_firsttime->result_array();
          if(count($fetch_firsttime)>0){
            foreach ($fetch_firsttime as $key_firsttime => $value_firsttime) {
              $arr_set = array();

              if($lang=="thai"){ 
                $cname = $value_firsttime['cname_th']!=""?$value_firsttime['cname_th']:$value_firsttime['cname_eng'];
                $cdesc = $value_firsttime['cdesc_th']!=""?$value_firsttime['cdesc_th']:$value_firsttime['cdesc_eng'];
              }else{ 
                $cname = $value_firsttime['cname_eng']!=""?$value_firsttime['cname_eng']:$value_firsttime['cname_th'];
                $cdesc = $value_firsttime['cdesc_eng']!=""?$value_firsttime['cdesc_eng']:$value_firsttime['cdesc_th'];
              }
              $arr_set['datetime_run'] = $value_firsttime['cosen_firsttime'];
              $arr_set['name_th_run'] = $cname;
              $arr_set['name_en_run'] = $cname;
              $arr_set['detail_th_run'] = $cdesc;
              $arr_set['detail_en_run'] = $cdesc;
              $arr_set['image_run'] = isset($value_firsttime['pic'])?$value_firsttime['pic']:"";
              $arr_set['type_run'] = 'Firsttime';
              $arr_set['file_run'] = '';
              $arr_set['cos_id'] = $value_firsttime['cos_id'];
              array_push($arr,$arr_set);
            }
          }
          $this->db->from('LMS_COS_ENROLL');
          $this->db->join('LMS_COS','LMS_COS_ENROLL.cos_id = LMS_COS.cos_id');
          $this->db->where('LMS_COS_ENROLL.emp_id',$user['emp_id']);
          $this->db->like('LMS_COS_ENROLL.cosen_finishtime',date('Y-m'));
          $query_finishtime = $this->db->get();
          $fetch_finishtime = $query_finishtime->result_array();
          if(count($fetch_finishtime)>0){
            foreach ($fetch_finishtime as $key_finishtime => $value_finishtime) {

              if($lang=="thai"){ 
                $cname = $value_finishtime['cname_th']!=""?$value_finishtime['cname_th']:$value_finishtime['cname_eng'];
                $cdesc = $value_finishtime['cdesc_th']!=""?$value_finishtime['cdesc_th']:$value_finishtime['cdesc_eng'];
              }else{ 
                $cname = $value_finishtime['cname_eng']!=""?$value_finishtime['cname_eng']:$value_finishtime['cname_th'];
                $cdesc = $value_finishtime['cdesc_eng']!=""?$value_finishtime['cdesc_eng']:$value_finishtime['cdesc_th'];
              }
              $arr_set = array();
              $arr_set['datetime_run'] = $value_finishtime['cosen_finishtime'];
              $arr_set['name_th_run'] = $cname;
              $arr_set['name_en_run'] = $cname;
              $arr_set['detail_th_run'] = $cdesc;
              $arr_set['detail_en_run'] = $cdesc;
              $arr_set['image_run'] = isset($value_finishtime['pic'])?$value_finishtime['pic']:"";
              $arr_set['type_run'] = 'Finishtime';
              $arr_set['file_run'] = '';
              $arr_set['cos_id'] = $value_finishtime['cos_id'];
              array_push($arr,$arr_set);
            }
          }
          $this->db->from('LMS_CERTIFICATE');
          $this->db->join('LMS_COS','LMS_CERTIFICATE.cos_id = LMS_COS.cos_id');
          $this->db->join('LMS_BAD','LMS_COS.cos_id = LMS_BAD.courses_id');
          $this->db->where('LMS_CERTIFICATE.emp_id',$user['emp_id']);
          $this->db->like('LMS_CERTIFICATE.cert_createtime',date('Y-m'));
          $query_cert = $this->db->get();
          $fetch_cert = $query_cert->result_array();
          if(count($fetch_cert)>0){
            foreach ($fetch_cert as $key_cert => $value_cert) {

              if($lang=="thai"){ 
                $cname = $value_cert['cname_th']!=""?$value_cert['cname_th']:$value_cert['cname_eng'];
                $cdesc = $value_cert['cdesc_th']!=""?$value_cert['cdesc_th']:$value_cert['cdesc_eng'];
              }else{ 
                $cname = $value_cert['cname_eng']!=""?$value_cert['cname_eng']:$value_cert['cname_th'];
                $cdesc = $value_cert['cdesc_eng']!=""?$value_cert['cdesc_eng']:$value_cert['cdesc_th'];
              }
              $arr_set = array();
              $arr_set['datetime_run'] = $value_cert['cert_createtime'];
              $arr_set['name_th_run'] = $cname;
              $arr_set['name_en_run'] = $cname;
              $arr_set['detail_th_run'] = $cdesc;
              $arr_set['detail_en_run'] = $cdesc;
              $arr_set['image_run'] = $value_cert['badges_img'];
              $arr_set['type_run'] = 'Certificate';
              $arr_set['file_run'] = $value_cert['cert_file'];
              $arr_set['cos_id'] = $value_cert['cos_id'];
              array_push($arr,$arr_set);
            }
          }
          return $arr;
        }

        public function fetch_course_cert($user) {
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->db->from('LMS_COS_ENROLL');
          $this->db->join('LMS_COS','LMS_COS_ENROLL.cos_id = LMS_COS.cos_id');
          $this->db->where('LMS_COS_ENROLL.emp_id',$user['emp_id']);
          $this->db->where('LMS_COS_ENROLL.cosen_status_sub','1');
          $query = $this->db->get();
          $fetch = $query->result_array();
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
              $output = array();
              $output['0'] = $num;$num++;

              if($lang=="thai"){ 
                $cname = $value['cname_th']!=""?$value['cname_th']:$value['cname_eng'];
              }else{ 
                $cname = $value['cname_eng']!=""?$value['cname_eng']:$value['cname_th'];
              }
                $output['1'] = $cname;
              if($value['cosen_score']!=""){
                $output['2'] = $value['cosen_score'];
              }else{
                $output['2'] = "-";
              }
              if($value['cosen_grade']!=""){
                $output['3'] = $value['cosen_grade'];
              }else{
                $output['3'] = "-";
              }
              if($value['cosen_finishtime']!="0000-00-00 00:00:00"){
                if($lang=="thai"){
                  $output['4'] = date('d',strtotime($value['cosen_finishtime']))." ".$thaimonth[intval(date('m',strtotime($value['cosen_finishtime'])))]." ".(date('Y',strtotime($value['cosen_finishtime']))+543)." ".date('H:i',strtotime($value['cosen_finishtime']));
                }else{
                  $output['4'] = date('d F Y H:i',strtotime($value['cosen_finishtime']));
                }
                $this->db->from('LMS_CERTIFICATE');
                $this->db->where('LMS_CERTIFICATE.cos_id',$value['cos_id']);
                $this->db->where('LMS_CERTIFICATE.emp_id',$user['emp_id']);
                $query_cert = $this->db->get();
                $fetch_cert = $query_cert->row_array();
                if(count($fetch_cert)>0){
                  $output['5'] = '<button type="button" name="cert_view" id="'.$fetch_cert['cos_id'].'" title="Certificate View" class="btn btn-info btn-xs cert_view"><i class="mdi mdi-magnify"></i></button>';
                }else{
                  $output['5'] = "-";
                }
              }else{
                $output['4'] = "-";
                $output['5'] = "-";
              }
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }
}
