<?php
class Manage_model extends CI_Model {

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
        public function course_total(){
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata("user");
          $this->db->select('LMS_COS.cname_th,LMS_COS.cname_eng,LMS_COS.cos_pic,LMS_COS_ENROLL.cosen_status,LMS_COS_ENROLL.cosen_status_sub,LMS_COS_ENROLL.cosen_grade,LMS_COS_ENROLL.cosen_score,LMS_COS_ENROLL.cosen_firsttime,LMS_COS_DETAIL.date_start,LMS_COS_DETAIL.date_end');
          $this->db->from('LMS_COS');
          $this->db->join('LMS_COS_ENROLL','LMS_COS.cos_id = LMS_COS_ENROLL.cos_id');
          $this->db->join('LMS_COS_DETAIL','LMS_COS.cos_id = LMS_COS_DETAIL.cos_id','LEFT');
          $this->db->where('LMS_COS_ENROLL.emp_id',$user['emp_id']);
          $this->db->where('LMS_COS_DETAIL.date_start<=',date('Y-m-d'));
          $this->db->where('LMS_COS.cos_status','1');
          $this->db->where('LMS_COS_DETAIL.cosde_status','1');
          $this->db->where('LMS_COS_ENROLL.cosen_status!=','2');
          $this->db->order_by('LMS_COS_DETAIL.date_end','ASC');
          $this->db->limit(4);
          $query = $this->db->get();
          $fetch = $query->result_array();
          return $fetch;
        }
        public function countamount_emp($type=""){
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata("user");
          $this->load->model('Course_model', 'course', TRUE);
          if($type=="coursetotal"){
              $where = "LMS_COS_DETAIL_UG.posi_id = '".$user['posi_id']."' and LMS_COS_DETAIL.cosde_status = '1' and ((LMS_COS_DETAIL.date_start <= '".date('Y-m-d H:i')."' and LMS_COS_DETAIL.date_end >='".date('Y-m-d H:i')."') OR (LMS_COS_DETAIL.date_start = '0000-00-00 00:00:00' and LMS_COS_DETAIL.date_end = '0000-00-00 00:00:00'))";
              $this->db->where($where);
              $this->db->from('LMS_COS');
              $this->db->join('LMS_COS_DETAIL','LMS_COS.cos_id = LMS_COS_DETAIL.cos_id');
              $this->db->join('LMS_COS_DETAIL_UG','LMS_COS_DETAIL_UG.cosde_id = LMS_COS_DETAIL.cosde_id');
              $this->db->select('LMS_COS.cos_id');
              $query = $this->db->get();
              return $query->num_rows();
          }else if($type=="enroll"){
              $this->db->where('LMS_COS_ENROLL.emp_id',$user['emp_id']);
              $this->db->where('LMS_COS_ENROLL.cosen_status','1');
              $this->db->from('LMS_COS_ENROLL');
              $query = $this->db->get();
              return $query->num_rows();
          }else if($type=="inProcess"){
              $this->db->where('LMS_COS_ENROLL.emp_id',$user['emp_id']);
              $this->db->where('LMS_COS_ENROLL.cosen_status','1');
              $this->db->where('LMS_COS_ENROLL.cosen_status_sub','2');
              $this->db->where('LMS_COS_ENROLL.cosen_firsttime!=','0000-00-00 00:00:00');
              $this->db->from('LMS_COS_ENROLL');
              $query = $this->db->get();
              return $query->num_rows();
          }else if($type=="success"){
              $this->db->where('LMS_COS_ENROLL.emp_id',$user['emp_id']);
              $this->db->where('LMS_COS_ENROLL.cosen_status','1');
              $this->db->where('LMS_COS_ENROLL.cosen_status_sub','1');
              $this->db->where('LMS_COS_ENROLL.cosen_firsttime!=','0000-00-00 00:00:00');
              $this->db->where('LMS_COS_ENROLL.cosen_finishtime!=','0000-00-00 00:00:00');
              $this->db->from('LMS_COS_ENROLL');
              $query = $this->db->get();
              return $query->num_rows();
          }else{
              $this->db->where('LMS_COS_ENROLL.emp_id',$user['emp_id']);
              $this->db->where('LMS_COS_ENROLL.cosen_status','1');
              $this->db->where('LMS_COS_ENROLL.cosen_firsttime','0000-00-00 00:00:00');
              $this->db->from('LMS_COS_ENROLL');
              $query = $this->db->get();
              return $query->num_rows();
          }
        }
        public function create_company($data,$data_period)
        {
          date_default_timezone_set("Asia/Bangkok");
          $data_typecos = array(
            '0' =>array('tc_name_th'=>'E-learning','tc_name_en'=>'E-learning','tc_lesson'=>'1','tc_pretest'=>'1','tc_questionnaire'=>'1','tc_qrcode'=>'0','tc_student_enroll'=>'1'),
            '1' =>array('tc_name_th'=>'ห้องเรียน','tc_name_en'=>'Classroom','tc_lesson'=>'0','tc_pretest'=>'0','tc_questionnaire'=>'0','tc_qrcode'=>'1','tc_student_enroll'=>'0'),
          );
          $this->db->from('LMS_COMPANY');
          $this->db->where('com_code', $data['com_code']);
          $this->db->where('com_name_th', $data['com_name_th']);
          $this->db->where('com_name_eng', $data['com_name_eng']);
          $this->db->where('com_status', '1');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_COMPANY', $data);
            $id = $this->db->insert_id();
            if($id!=""){
              $data_period['com_id'] = $id;
              $data_period['compe_year'] = date('Y');
              $data_period['compe_createby'] = $data['com_createby'];
              $data_period['compe_createdate'] = date('Y-m-d H:i');
              $data_period['compe_modifiedby'] = $data['com_createby'];
              $data_period['compe_modifieddate'] = date('Y-m-d H:i');
              $this->db->insert('LMS_COMPANY_PERIOD',$data_period);
              foreach ($data_typecos as $key => $value) {
                $value['com_id'] = $id;
                $value['tc_createdate'] = date('Y-m-d H:i');
                $value['tc_modifeddate'] = date('Y-m-d H:i');
                $this->db->insert('LMS_TYPECOS', $value);
              }
              return "2";
            }else{
              return "3";
            }
          }else{
            return "1";
          }
        }
        public function create_company_score($data)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->from('LMS_COMPANY_SCORE');
          $this->db->where('com_id', $data['com_id']);
          $this->db->where('coms_amount', $data['coms_amount']);
          $this->db->where('coms_type', $data['coms_type']);
          $this->db->where('coms_cond', $data['coms_cond']);
          $this->db->where('coms_isDelete', '0');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_COMPANY_SCORE', $data);
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

        public function chk_permission($mu_path,$field){
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata("user");

          $field = str_replace("ru_","rgu_",$field);
          $this->db->from('LMS_ROLE_GP');
          $this->db->join('LMS_MENU','LMS_ROLE_GP.mu_id = LMS_MENU.mu_id');
          $this->db->where($field, '1');
          $this->db->where('LMS_MENU.mu_path', $mu_path);
          $this->db->where('ug_id', $user['ug_id']);
          $query = $this->db->get();
          $fetch = $query->row_array();
          if(count($fetch)>0){
            return 1;
          }else{
            return 0;
          }
        }
        public function chk_permission_page(){
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata("user");

          $this->db->from('LMS_MENU');
          /*if($user['com_admin']=="com_associated"){
            $this->db->where('mu_customer', '1');
          }*/
          if($this->isMobile()){
            $where = "mu_id in (SELECT mu_id FROM LMS_MENU where mu_path NOT LIKE '%managecourse%' and mu_path NOT IN ('quiz/create_template','certificate/certificateall','quiz/create_template','questionnaire/create','learning_system','survey/list_survey','manage_courses'))";
            $this->db->where($where);
          }
          $query = $this->db->get();
          $fetch = $query->result_array();
          $arr = array();
          foreach ($fetch as $key => $value) {
            $val_chk = $this->chk_permission($value['mu_path'],'ru_view');
            if($val_chk=="0"){
              unset($fetch[$key]);
            }else{
              array_push($arr, $value['mu_path']);
            }
          }

          return $arr;
        }

        public function update_company($data,$data_period,$com_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $sess = $this->session->userdata("user");
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->db->where('com_id', $com_id);
          $this->db->update('LMS_COMPANY', $data);
          $fetch_chk = $this->func_query->query_row('LMS_COMPANY_PERIOD','','','','com_id = "'.$com_id.'" and compe_year="'.date('Y').'"');
          if(count($fetch_chk)>0){
              $data_period['compe_modifiedby'] = $sess['u_id'];
              $data_period['compe_modifieddate'] = date('Y-m-d H:i');
              $this->db->where('compe_id',$fetch_chk['compe_id']);
              $this->db->update('LMS_COMPANY_PERIOD',$data_period);
          }else{
              $data_period['com_id'] = $com_id;
              $data_period['compe_year'] = date('Y');
              $data_period['compe_createby'] = $sess['u_id'];
              $data_period['compe_createdate'] = date('Y-m-d H:i');
              $data_period['compe_modifiedby'] = $sess['u_id'];
              $data_period['compe_modifieddate'] = date('Y-m-d H:i');
              $this->db->insert('LMS_COMPANY_PERIOD',$data_period);
          }
          return "2";
        }

        public function update_company_score($data,$coms_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('coms_id', $coms_id);
          $this->db->update('LMS_COMPANY_SCORE', $data);
          return "2";
        }

        public function update_division($data,$div_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('div_id', $div_id);
          $this->db->update('LMS_DIVISION', $data);
          return "2";
        }

        public function update_level($data,$lv_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('lv_id', $lv_id);
          $this->db->update('LMS_LEVEL', $data);
          return "2";
        }

        public function update_store($data,$st_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('st_id', $st_id);
          $this->db->update('LMS_STORE', $data);
          return "2";
        }

        public function update_position($data,$posi_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('posi_id', $posi_id);
          $this->db->update('LMS_POSITION', $data);
          return "2";
        }

        public function update_group($data,$group_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('group_id', $group_id);
          $this->db->update('LMS_GROUP', $data);
          return "2";
        }
        public function delete_company($com_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('com_id', $com_id);
          $this->db->delete('LMS_COMPANY');
          return "2";
        }

        public function create_department($data)
        {
          date_default_timezone_set("Asia/Bangkok");

          $this->db->from('LMS_DEPART');
          $this->db->where('dep_code', $data['dep_code']);
          $this->db->where('dep_name_th', $data['dep_name_th']);
          $this->db->where('dep_name_en', $data['dep_name_en']);
          $this->db->where('group_id', $data['group_id']);
          $this->db->where('dep_isDelete', '1');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $data['dep_createdate'] = date("Y-m-d H:i");
            $this->db->insert('LMS_DEPART', $data);
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

        public function create_section($data)
        {
          date_default_timezone_set("Asia/Bangkok");

          $this->db->from('LMS_SECTION');
          $this->db->where('section_code', $data['section_code']);
          $this->db->where('section_name_en', $data['section_name_en']);
          $this->db->where('section_name_th', $data['section_name_th']);
          $this->db->where('dep_id', $data['dep_id']);
          $this->db->where('section_isDelete', '1');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_SECTION', $data);
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

        public function create_area($data)
        {
          date_default_timezone_set("Asia/Bangkok");

          $this->db->from('LMS_AREA');
          $this->db->where('salearea_code', $data['salearea_code']);
          $this->db->where('salearea_name_en', $data['salearea_name_en']);
          $this->db->where('salearea_name_th', $data['salearea_name_th']);
          $this->db->where('section_id', $data['section_id']);
          $this->db->where('salearea_isDelete', '1');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_AREA', $data);
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

        public function update_department($data,$dep_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('dep_id', $dep_id);
          $this->db->update('LMS_DEPART', $data);
          return "2";
        }

        public function update_section($data,$section_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('section_id', $section_id);
          $this->db->update('LMS_SECTION', $data);
          return "2";
        }

        public function update_area($data,$salearea_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('salearea_id', $salearea_id);
          $this->db->update('LMS_AREA', $data);
          return "2";
        }
        /*public function delete_department($dep_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('dep_id', $dep_id);
          $this->db->delete('LMS_DEPART');
          return "2";
        }*/

        public function create_groupuser($data,$fd_id)
        {
          date_default_timezone_set("Asia/Bangkok");

          $this->db->from('LMS_USP_GP');
          $this->db->where('ug_name_th', $data['ug_name_th']);
          $this->db->where('ug_name_en', $data['ug_name_en']);
          $this->db->where('ug_for', $data['ug_for']);
          $this->db->where('ug_status', '1');
          $this->db->where('ug_isDelete', '0');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $data['ug_createdate'] = date("Y-m-d H:i");
            $this->db->insert('LMS_USP_GP', $data);
            $id = $this->db->insert_id();
            if($id!=""){
              if(count($fd_id)>0){
                  for ($i=0; $i < count($fd_id); $i++) { 
                    $arr_insert = array(
                      'ug_id' => $id,
                      'fd_id' => $fd_id[$i],
                    );
                    $this->db->insert('LMS_ROLE_FD',$arr_insert);
                  }
              }
              return "2";
            }else{
              return "3";
            }
          }else{
            return "1";
          }
        }



        public function fetch_data_log($sday,$eday,$com_id,$length,$start,$order,$search) {
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;

          $arrMonthThaiTextShort = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย","ธ.ค.");
          $arrMonthThaiTextFull = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $this->load->model('Log_model', 'lg', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->lg->loadDB();
          $sqlDate = array();
          
          $var_and = "LMS_EMP.emp_isDelete='0'";
          $var_and .= " and LMS_EMP.com_id='".$com_id."'";
          if(($sday!=""&&$eday!="")){
            $var_and .= " and (LMS_LG.log_time between '".$sday."' and '".$eday."')";
          }
          $col = 0;
          $dir = "";
          if(!empty($order))
          {
              foreach($order as $o)
              {
                  $col = $o['column'];
                  $dir= $o['dir'];
              }
          }

          if($dir != "asc" && $dir != "desc")
          {
              $dir = "desc";
          }
          $valid_columns = array(
              0=>'LMS_LG.emp_id',
              1=>'LMS_LG.emp_id',
              2=>'LMS_LG.emp_id',
              3=>'LMS_LG.emp_id',
              4=>'LMS_LG.ip',
              5=>'LMS_LG.device',
              6=>'LMS_LG.massage',
              7=>'LMS_LG.log_time',
              8=>'LMS_LG.log_time',
          );
          if(!isset($valid_columns[$col]))
          {
              $order = null;
          }
          else
          {
              $order = $valid_columns[$col];
          }
          if($order !=null)
          {
              $this->db->order_by($order, $dir);
          }
          if($search!=""){
            $var_and .= "(LMS_EMP.emp_c like '%".$search."%' or LMS_EMP.fullname_th like '%".$search."%' or LMS_EMP.fullname_en like '%".$search."%' or LMS_USP_GP.ug_name_th like '%".$search."%' or LMS_USP_GP.ug_name_en like '%".$search."%' or LMS_LG.massage like '%".$search."%')";
          }
          $this->db->where($var_and);
          $this->db->join('LMS_EMP','LMS_LG.emp_id = LMS_EMP.emp_id');
          $this->db->join('LMS_DIVISION','LMS_EMP.div_id = LMS_DIVISION.div_id','LEFT');
          $this->db->join('LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id');
          $this->db->join('LMS_USP_GP','LMS_USP.ug_id = LMS_USP_GP.ug_id');
          $this->db->from("LMS_LG");
         /* if($length>=0){
            $this->db->limit($length,$start);
          }*/
          $query = $this->db->get();
          $fetch = $query->result_array();

          //$fetch = $this->func_query->query_result("tbl_customer","tbl_branch","tbl_branch.b_id = tbl_customer.b_id","",$var_and,"cus_id DESC");
          $num = $start+1;$count = 0;
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $output = array();
              $string_msg = "";
              $fetch_usp = 
              /*$pos = strpos($value['massage'], 'logged in website');
              if($pos === false){
                $pos = strpos($value['massage'], 'logged in fail');
                if($pos){
                  $string_msg = "logged in fail";
                }
              }else{
                $string_msg = "logged in website";
              }*/
              $string_msg = $value['massage'];
              $output['0'] = $value['emp_c'];
              $fullname = "";
              $fullname = $lang=="thai"?$value['fullname_th']:$value['fullname_en'];
              $ug_name = $lang=="thai"?$value['ug_name_th']:$value['ug_name_en'];
              $div_name = isset($value['div_code'])?($lang=="thai"?$value['div_name_th']:$value['div_name_en']):"";
              $output['1'] = $fullname;
              $output['2'] = $div_name;
              $output['3'] = $ug_name;
              $output['4'] = $value['ip'];
              $output['5'] = $value['device'];
              $output['6'] = $string_msg;
              if($lang=="thai"){
              $output['7'] = date('d/m/',strtotime($value['log_time'])).(date('Y',strtotime($value['log_time']))+543);
              }else{
              $output['7'] = date('d/m/Y',strtotime($value['log_time']));
              }
              $output['8'] = date('H:i',strtotime($value['log_time']));
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function create_emp($data)
        {
          date_default_timezone_set("Asia/Bangkok");

          $this->db->from('LMS_EMP');
          $this->db->where('emp_c', $data['emp_c']);
          $this->db->where('com_id',$data['com_id']);
          $this->db->where('emp_isDelete', '0');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_EMP', $data);
            $id = $this->db->insert_id();
            return $id;
          }else{
            return "0";
          }
        }
        public function update_emp($data,$emp_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('emp_id', $emp_id);
          $this->db->update('LMS_EMP', $data);
          return "2";
        }
        public function rechk_role($u_id,$ug_id){
          date_default_timezone_set("Asia/Bangkok");
          $this->db->from('LMS_ROLE_USP');
          $this->db->where('u_id', $u_id);
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->from('LMS_ROLE_GP');
            $this->db->where('ug_id', $ug_id);
            $query = $this->db->get();
            $result_ques = $query->result_array();
            $num = 1;
            foreach ($result_ques as $key => $value) {
              $data = array(
                'u_id' => $u_id,
                'mu_id' => $value['mu_id'],
                'ru_view' => $value['rgu_view'],
                'ru_add' => $value['rgu_add'],
                'ru_edit' => $value['rgu_edit'],
                'ru_del' => $value['rgu_del'],
                'ru_print' => $value['rgu_print']
              );
              $this->db->insert('LMS_ROLE_USP', $data);
            }
          }else{
            $this->db->from('LMS_USP');
            $this->db->where('u_id', $u_id);
            $this->db->where('ug_id', $ug_id);
            $query = $this->db->get();
            if($query->num_rows()>0){
              $this->db->where('u_id',$u_id);
              $this->db->delete('LMS_ROLE_USP');

              $this->db->from('LMS_ROLE_GP');
              $this->db->where('ug_id', $ug_id);
              $query = $this->db->get();
              $result_ques = $query->result_array();
              $num = 1;
              foreach ($result_ques as $key => $value) {
                $data = array(
                  'u_id' => $u_id,
                  'mu_id' => $value['mu_id'],
                  'ru_view' => $value['rgu_view'],
                  'ru_add' => $value['rgu_add'],
                  'ru_edit' => $value['rgu_edit'],
                  'ru_del' => $value['rgu_del'],
                  'ru_print' => $value['rgu_print']
                );
                $this->db->insert('LMS_ROLE_USP', $data);
              }
            }
          }
        }
        public function chk_company($dep_id){
          date_default_timezone_set("Asia/Bangkok");
          $this->db->from('LMS_DEPART');
          $this->db->where('dep_id',$dep_id);
          $query = $this->db->get();
          $fetch = $query->row_array();
          return $fetch['com_id'];
        }
        public function create_user($data)
        {
          date_default_timezone_set("Asia/Bangkok");
          //$com_id = $this->chk_company($data['dep_id']);
          $this->db->from('LMS_USP');
          //$this->db->join('LMS_DEPART','LMS_USP.dep_id = LMS_DEPART.dep_id');
          //$this->db->where('LMS_DEPART.com_id', $com_id);
          $this->db->where('LMS_USP.useri', $data['useri']);
          $this->db->where('LMS_USP.emp_id', $data['emp_id']);
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_USP', $data);
            $id = $this->db->insert_id();
            if($id!=""){
              //$this->rechk_role($id,$data['ug_id']);
              return "2";
            }else{
              return "3";
            }
          }else{
            return "1";
          }
        }
        public function update_user($data,$u_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('u_id', $u_id);
          $this->db->update('LMS_USP', $data);
          //$this->rechk_role($u_id,$data['ug_id']);
          return "2";
        }

        public function chkbox_user($data_chk)
        {
          date_default_timezone_set("Asia/Bangkok");

          $this->db->from('LMS_ROLE_USP');
          $this->db->where('u_id', $data_chk['u_idonrole_ug']);
          $this->db->where('mu_id', $data_chk['mu_idonrole_ug']);
          $query = $this->db->get();
          if($query->num_rows()==0){
            $data = array(
              'u_id' => $data_chk['u_idonrole_ug'],
              'mu_id' => $data_chk['mu_idonrole_ug'],
              $data_chk['field_sql_ug'] => $data_chk['value_chk_ug']
            );
            $this->db->insert('LMS_ROLE_USP', $data);
          }else{
            $data = array(
              $data_chk['field_sql_ug'] => $data_chk['value_chk_ug']
            );
            $this->db->where('u_id', $data_chk['u_idonrole_ug']);
            $this->db->where('mu_id', $data_chk['mu_idonrole_ug']);
            $this->db->update('LMS_ROLE_USP', $data);
          }
        }
        public function insert_arr($name_table,$arr){
          $this->db->insert($name_table, $arr);
        }
        public function arr_menu_query(){
          $this->db->from('LMS_MENU');
          $this->db->order_by('mu_num','ASC');
          $query = $this->db->get();
          $row = $query->result();
          $result_ques = $query->result_array();
          return $result_ques;
        }
        public function chkbox_col_user($data_chk){
          $this->db->from('LMS_MENU');
          $this->db->order_by('mu_num','ASC');
          $query = $this->db->get();
          $row = $query->result();
          $result_ques = $query->result_array();
          $num = 1;
          foreach ($result_ques as $key => $value) {
            $this->db->from('LMS_ROLE_USP');
            $this->db->where('u_id', $data_chk['u_idonrole_ug']);
            $this->db->where('mu_id', $value['mu_id']);
            $query = $this->db->get();
            if($query->num_rows()==0){
              $data = array(
                'u_id' => $data_chk['u_idonrole_ug'],
                'mu_id' => $value['mu_id'],
                $data_chk['field_sql_ug'] => $data_chk['value_chk_ug']
              );
              $this->db->insert('LMS_ROLE_USP', $data);
            }else{
              $data = array(
                $data_chk['field_sql_ug'] => $data_chk['value_chk_ug']
              );
              $this->db->where('u_id', $data_chk['u_idonrole_ug']);
              $this->db->where('mu_id', $value['mu_id']);
              $this->db->update('LMS_ROLE_USP', $data);
            }
          }
        }
        public function chkbox_col_groupuser($data_chk){
          $this->db->from('LMS_MENU');
          $this->db->order_by('mu_num','ASC');
          $query = $this->db->get();
          $row = $query->result();
          $result_ques = $query->result_array();
          $num = 1;
          foreach ($result_ques as $key => $value) {
            $this->db->from('LMS_ROLE_GP');
            $this->db->where('ug_id', $data_chk['ug_idonrole_ug']);
            $this->db->where('mu_id', $value['mu_id']);
            $query = $this->db->get();
            if($query->num_rows()==0){
              $data = array(
                'ug_id' => $data_chk['ug_idonrole_ug'],
                'mu_id' => $value['mu_id'],
                $data_chk['field_sql_ug'] => $data_chk['value_chk_ug']
              );
              $this->db->insert('LMS_ROLE_GP', $data);

              $this->db->where('ug_id',$data_chk['ug_idonrole_ug']);
              $this->db->from('LMS_USP');
              $query_usp = $this->db->get();
              $num_usp = $query_usp->num_rows();
              if($num_usp>0){
                  $fetch_usp = $query_usp->result_array();
                  foreach ($fetch_usp as $key_usp => $value_usp) {
                        $field_usp = str_replace("g","",$data_chk['field_sql_ug']);
                        $this->db->where('u_id', $value_usp['u_id']);
                        $this->db->where('mu_id', $value['mu_id']);
                        $this->db->from('LMS_ROLE_USP');
                        $query = $this->db->get();
                        $num_chk = $query->num_rows();
                        if($num_chk>0){
                          $data_usp = array(
                            $field_usp => $data_chk['value_chk_ug']
                          );
                          $this->db->where('u_id', $value_usp['u_id']);
                          $this->db->where('mu_id', $value['mu_id']);
                          $this->db->update('LMS_ROLE_USP', $data_usp);
                        }else{
                          $data_usp = array(
                            'u_id' => $value_usp['u_id'],
                            'mu_id' => $value['mu_id'],
                            $field_usp => $data_chk['value_chk_ug']
                          );
                          $this->db->insert('LMS_ROLE_USP', $data_usp);
                        }
                  }
              }
            }else{
              $data = array(
                $data_chk['field_sql_ug'] => $data_chk['value_chk_ug']
              );
              $this->db->where('ug_id', $data_chk['ug_idonrole_ug']);
              $this->db->where('mu_id', $value['mu_id']);
              $this->db->update('LMS_ROLE_GP', $data);

              $this->db->where('ug_id',$data_chk['ug_idonrole_ug']);
              $this->db->from('LMS_USP');
              $query_usp = $this->db->get();
              $num_usp = $query_usp->num_rows();
              if($num_usp>0){
                  $fetch_usp = $query_usp->result_array();
                  foreach ($fetch_usp as $key_usp => $value_usp) {
                        $field_usp = str_replace("g","",$data_chk['field_sql_ug']);
                        $this->db->where('u_id', $value_usp['u_id']);
                        $this->db->where('mu_id', $value['mu_id']);
                        $this->db->from('LMS_ROLE_USP');
                        $query = $this->db->get();
                        $num_chk = $query->num_rows();
                        if($num_chk>0){
                          $data_usp = array(
                            $field_usp => $data_chk['value_chk_ug']
                          );
                          $this->db->where('u_id', $value_usp['u_id']);
                          $this->db->where('mu_id', $value['mu_id']);
                          $this->db->update('LMS_ROLE_USP', $data_usp);
                        }else{
                          $data_usp = array(
                            'u_id' => $value_usp['u_id'],
                            'mu_id' => $value['mu_id'],
                            $field_usp => $data_chk['value_chk_ug']
                          );
                          $this->db->insert('LMS_ROLE_USP', $data_usp);
                        }
                  }
              }

            }
          }
        }
        public function chkbox_groupuser($data_chk)
        {
          date_default_timezone_set("Asia/Bangkok");
          $arr_field = array('rgu_view','rgu_add','rgu_edit','rgu_del','rgu_print');
          $this->db->from('LMS_ROLE_GP');
          $this->db->where('ug_id', $data_chk['ug_idonrole_ug']);
          $this->db->where('mu_id', $data_chk['mu_idonrole_ug']);
          $query = $this->db->get();
          if($query->num_rows()==0){
            if($data_chk['field_sql_ug']=="chkrowall"){
              for ($i=0; $i < 5 ; $i++) { 
                $data = array();
                $data['ug_id'] = $data_chk['ug_idonrole_ug'];
                $data['mu_id'] = $data_chk['mu_idonrole_ug'];;
                $data[$arr_field[$i]] = $data_chk['value_chk_ug'];
                $this->insert_arr('LMS_ROLE_GP',$data);

                $this->db->where('ug_id',$data_chk['ug_idonrole_ug']);
                $this->db->from('LMS_USP');
                $query_usp = $this->db->get();
                $num_usp = $query_usp->num_rows();
                if($num_usp>0){
                    $fetch_usp = $query_usp->result_array();
                    foreach ($fetch_usp as $key_usp => $value_usp) {
                          $field_usp = str_replace("g","",$arr_field[$i]);
                          $this->db->where('u_id', $value_usp['u_id']);
                          $this->db->where('mu_id', $data_chk['mu_idonrole_ug']);
                          $this->db->from('LMS_ROLE_USP');
                          $query = $this->db->get();
                          $num_chk = $query->num_rows();
                          if($num_chk>0){
                            $data_usp = array(
                              $field_usp => $data_chk['value_chk_ug']
                            );
                            $this->db->where('u_id', $value_usp['u_id']);
                            $this->db->where('mu_id', $data_chk['mu_idonrole_ug']);
                            $this->db->update('LMS_ROLE_USP', $data_usp);
                          }else{
                            $data_usp = array(
                              'u_id' => $value_usp['u_id'],
                              'mu_id' => $data_chk['mu_idonrole_ug'],
                              $field_usp => $data_chk['value_chk_ug']
                            );
                            $this->db->insert('LMS_ROLE_USP', $data_usp);
                          }
                    }
                }

              }
            }else{
              $data = array(
                'ug_id' => $data_chk['ug_idonrole_ug'],
                'mu_id' => $data_chk['mu_idonrole_ug'],
                $data_chk['field_sql_ug'] => $data_chk['value_chk_ug']
              );
              $this->db->insert('LMS_ROLE_GP', $data);

              $this->db->where('ug_id',$data_chk['ug_idonrole_ug']);
              $this->db->from('LMS_USP');
              $query_usp = $this->db->get();
              $num_usp = $query_usp->num_rows();
              if($num_usp>0){
                  $fetch_usp = $query_usp->result_array();
                  foreach ($fetch_usp as $key_usp => $value_usp) {
                        $field_usp = str_replace("g","",$data_chk['field_sql_ug']);
                        $this->db->where('u_id', $value_usp['u_id']);
                        $this->db->where('mu_id', $data_chk['mu_idonrole_ug']);
                        $this->db->from('LMS_ROLE_USP');
                        $query = $this->db->get();
                        $num_chk = $query->num_rows();
                        if($num_chk>0){
                          $data_usp = array(
                            $field_usp => $data_chk['value_chk_ug']
                          );
                          $this->db->where('u_id', $value_usp['u_id']);
                          $this->db->where('mu_id', $data_chk['mu_idonrole_ug']);
                          $this->db->update('LMS_ROLE_USP', $data_usp);
                        }else{
                          $data_usp = array(
                            'u_id' => $value_usp['u_id'],
                            'mu_id' => $data_chk['mu_idonrole_ug'],
                            $field_usp => $data_chk['value_chk_ug']
                          );
                          $this->db->insert('LMS_ROLE_USP', $data_usp);
                        }
                  }
              }

            }
          }else{
            if($data_chk['field_sql_ug']=="chkrowall"){
              for ($i=0; $i < 5 ; $i++) { 
                $data = array(
                  $arr_field[$i] => $data_chk['value_chk_ug']
                );
                $this->db->where('ug_id', $data_chk['ug_idonrole_ug']);
                $this->db->where('mu_id', $data_chk['mu_idonrole_ug']);
                $this->db->update('LMS_ROLE_GP', $data);

                

                $this->db->where('ug_id',$data_chk['ug_idonrole_ug']);
                $this->db->from('LMS_USP');
                $query_usp = $this->db->get();
                $num_usp = $query_usp->num_rows();
                if($num_usp>0){
                    $fetch_usp = $query_usp->result_array();
                    foreach ($fetch_usp as $key_usp => $value_usp) {
                          $field_usp = str_replace("g","",$arr_field[$i]);
                          $this->db->where('u_id', $value_usp['u_id']);
                          $this->db->where('mu_id', $data_chk['mu_idonrole_ug']);
                          $this->db->from('LMS_ROLE_USP');
                          $query = $this->db->get();
                          $num_chk = $query->num_rows();
                          if($num_chk>0){
                            $data_usp = array(
                              $field_usp => $data_chk['value_chk_ug']
                            );
                            $this->db->where('u_id', $value_usp['u_id']);
                            $this->db->where('mu_id', $data_chk['mu_idonrole_ug']);
                            $this->db->update('LMS_ROLE_USP', $data_usp);
                          }else{
                            $data_usp = array(
                              'u_id' => $value_usp['u_id'],
                              'mu_id' => $data_chk['mu_idonrole_ug'],
                              $field_usp => $data_chk['value_chk_ug']
                            );
                            $this->db->insert('LMS_ROLE_USP', $data_usp);
                          }
                    }
                }

              }
            }else{
                $data = array(
                  $data_chk['field_sql_ug'] => $data_chk['value_chk_ug']
                );
                $this->db->where('ug_id', $data_chk['ug_idonrole_ug']);
                $this->db->where('mu_id', $data_chk['mu_idonrole_ug']);
                $this->db->update('LMS_ROLE_GP', $data);


                $this->db->where('ug_id',$data_chk['ug_idonrole_ug']);
                $this->db->from('LMS_USP');
                $query_usp = $this->db->get();
                $num_usp = $query_usp->num_rows();
                if($num_usp>0){
                    $fetch_usp = $query_usp->result_array();
                    foreach ($fetch_usp as $key_usp => $value_usp) {
                          $field_usp = str_replace("g","",$data_chk['field_sql_ug']);
                          $this->db->where('u_id', $value_usp['u_id']);
                          $this->db->where('mu_id', $data_chk['mu_idonrole_ug']);
                          $this->db->from('LMS_ROLE_USP');
                          $query = $this->db->get();
                          $num_chk = $query->num_rows();
                          if($num_chk>0){
                            $data_usp = array(
                              $field_usp => $data_chk['value_chk_ug']
                            );
                            $this->db->where('u_id', $value_usp['u_id']);
                            $this->db->where('mu_id', $data_chk['mu_idonrole_ug']);
                            $this->db->update('LMS_ROLE_USP', $data_usp);
                          }else{
                            $data_usp = array(
                              'u_id' => $value_usp['u_id'],
                              'mu_id' => $data_chk['mu_idonrole_ug'],
                              $field_usp => $data_chk['value_chk_ug']
                            );
                            $this->db->insert('LMS_ROLE_USP', $data_usp);
                          }
                    }
                }

            }
          }
        }

        public function chkdataRoleUsergroup($ug_id){
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
          $user = $this->session->userdata("user");
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $num = 1;
          $where = 'LMS_MENU.mu_parent="0" and LMS_MENU.mu_status="1" and LMS_MENU.mu_path !="dashboard"';
          if($user['com_admin']=="com_associated"){
            $where = 'mu_customer="1"';
          }
          $fetch_user_gp = $this->func_query->query_row('LMS_USP_GP','','','','ug_id="'.$ug_id.'"');
          $result_menu = $this->func_query->query_result('LMS_MENU','','','',$where,'mu_num ASC');
          $num_ques = 0;
          foreach ($result_menu as $key => $value) {
            $li_arr_sub = $this->checkmenu_sub($value['mu_id']);

            if(count($li_arr_sub)>0){
              $num_secord = 1;
              foreach ($li_arr_sub as $key_li_sub => $value_li_sub) {
                if($value_li_sub['mu_id']==$value['mu_id']){
                  unset($result_menu[$key]);
                }
              }
            }
          }
          foreach ($result_menu as $key => $value) {
            $chkenable = 0;
            $chkadd = 0;
            $chkedit = 0;
            $chkdel = 0;
            $chkprint = 0;
            $this->db->from('LMS_ROLE_GP');
            $this->db->where('ug_id',$ug_id);
            $this->db->where('mu_id',$value['mu_id']);
            $query_chk = $this->db->get();
            if($query_chk->num_rows()>0){

              $fetch_chk = $query_chk->row_array();
              $chkenable = intval($fetch_chk['rgu_view']);
              $chkadd = intval($fetch_chk['rgu_add']);
              $chkedit = intval($fetch_chk['rgu_edit']);
              $chkdel = intval($fetch_chk['rgu_del']);
              $chkprint = intval($fetch_chk['rgu_print']);
            }
            echo '<tr>';
            echo '<td align="left" width="10%">'.$num.'</td>';
            if($lang=="thai"){
              echo '<td align="left" width="30%">'.$value["mu_name_th"].'</td>';
            }else if($lang=="english"){
              echo '<td align="left" width="30%">'.$value["mu_name_en"].'</td>';
            }
            $li_arr_sub = $this->checkmenu_sub($value['mu_id']);
            if(count($li_arr_sub)==0){
            if($chkenable==1&&$chkadd==1&&$chkedit==1&&$chkdel==1&&$chkprint==1){ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" class="chkall_row" id="chkrowall_<?php echo $value['mu_id'];?>" name="chkrowall_<?php echo $value['mu_id'];?>" onchange='chk_chkbox("chkrowall","<?php echo $value['mu_id'];?>","<?php echo $ug_id;?>")' value="1" checked><label for="chkrowall_<?php echo $value['mu_id'];?>"></label></div></td>
            <?php }else{ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" class="chkall_row" id="chkrowall_<?php echo $value['mu_id'];?>" name="chkrowall_<?php echo $value['mu_id'];?>" onchange='chk_chkbox("chkrowall","<?php echo $value['mu_id'];?>","<?php echo $ug_id;?>")' value="1"><label for="chkrowall_<?php echo $value['mu_id'];?>"></label></div></td>
            <?php }
            if($chkenable==1){ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkenable_<?php echo $value['mu_id'];?>" name="chkenable_<?php echo $value['mu_id'];?>" class="chkrow_<?php echo $value['mu_id'];?> chkcol_rgu_view" onchange='chk_chkbox("chkenable","<?php echo $value['mu_id'];?>","<?php echo $ug_id;?>")' value="1" checked><label for="chkenable_<?php echo $value['mu_id'];?>"></label></div></td>
           <?php }else{ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkenable_<?php echo $value['mu_id'];?>" name="chkenable_<?php echo $value['mu_id'];?>" class="chkrow_<?php echo $value['mu_id'];?> chkcol_rgu_view" onchange='chk_chkbox("chkenable","<?php echo $value['mu_id'];?>","<?php echo $ug_id;?>")' value="1"><label for="chkenable_<?php echo $value['mu_id'];?>"></label></div></td>
          <?php  }
            if($chkadd==1){ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkadd_<?php echo $value['mu_id'];?>" name="chkadd_<?php echo $value['mu_id'];?>" class="chkrow_<?php echo $value['mu_id'];?>  chkcol_rgu_add" onchange='chk_chkbox("chkadd","<?php echo $value['mu_id'];?>","<?php echo $ug_id;?>")' value="1" checked><label for="chkadd_<?php echo $value['mu_id'];?>"></label></div></td>
           <?php }else{ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkadd_<?php echo $value['mu_id'];?>" name="chkadd_<?php echo $value['mu_id'];?>" class="chkrow_<?php echo $value['mu_id'];?>  chkcol_rgu_add" onchange='chk_chkbox("chkadd","<?php echo $value['mu_id'];?>","<?php echo $ug_id;?>")' value="1"><label for="chkadd_<?php echo $value['mu_id'];?>"></label></div></td>
           <?php }
            if($chkedit==1){ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkedit_<?php echo $value['mu_id'];?>" name="chkedit_<?php echo $value['mu_id'];?>" class="chkrow_<?php echo $value['mu_id'];?> chkcol_rgu_edit" onchange='chk_chkbox("chkedit","<?php echo $value['mu_id'];?>","<?php echo $ug_id;?>")' value="1" checked><label for="chkedit_<?php echo $value['mu_id'];?>"></label></div></td>
           <?php }else{ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkedit_<?php echo $value['mu_id'];?>" name="chkedit_<?php echo $value['mu_id'];?>" class="chkrow_<?php echo $value['mu_id'];?> chkcol_rgu_edit" onchange='chk_chkbox("chkedit","<?php echo $value['mu_id'];?>","<?php echo $ug_id;?>")' value="1"><label for="chkedit_<?php echo $value['mu_id'];?>"></label></div></td>
          <?php  }
            if($chkdel==1){ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkdel_<?php echo $value['mu_id'];?>" name="chkdel_<?php echo $value['mu_id'];?>" class="chkrow_<?php echo $value['mu_id'];?> chkcol_rgu_del" onchange='chk_chkbox("chkdel","<?php echo $value['mu_id'];?>","<?php echo $ug_id;?>")' value="1" checked><label for="chkdel_<?php echo $value['mu_id'];?>"></label></div></td>
          <?php  }else{ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkdel_<?php echo $value['mu_id'];?>" name="chkdel_<?php echo $value['mu_id'];?>" class="chkrow_<?php echo $value['mu_id'];?> chkcol_rgu_del" onchange='chk_chkbox("chkdel","<?php echo $value['mu_id'];?>","<?php echo $ug_id;?>")' value="1"><label for="chkdel_<?php echo $value['mu_id'];?>"></label></div></td>
           <?php }
            if($chkprint==1){ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkprint_<?php echo $value['mu_id'];?>" name="chkprint_<?php echo $value['mu_id'];?>" class="chkrow_<?php echo $value['mu_id'];?> chkcol_rgu_print" onchange='chk_chkbox("chkprint","<?php echo $value['mu_id'];?>","<?php echo $ug_id;?>")' value="1" checked><label for="chkprint_<?php echo $value['mu_id'];?>"></label></div></td>
          <?php  }else{ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkprint_<?php echo $value['mu_id'];?>" name="chkprint_<?php echo $value['mu_id'];?>" class="chkrow_<?php echo $value['mu_id'];?> chkcol_rgu_print" onchange='chk_chkbox("chkprint","<?php echo $value['mu_id'];?>","<?php echo $ug_id;?>")' value="1"><label for="chkprint_<?php echo $value['mu_id'];?>"></label></div></td>
          <?php  }
            }else{
              echo '<td colspan="6"></td>';
            } 
            echo '</tr>';
            if(count($li_arr_sub)>0){
              $num_secord = 1;

              foreach ($li_arr_sub as $key_li_sub => $value_li_sub) {
                  $chkenable = 0;
                  $chkadd = 0;
                  $chkedit = 0;
                  $chkdel = 0;
                  $chkprint = 0;
                  $this->db->from('LMS_ROLE_GP');
                  $this->db->where('ug_id',$ug_id);
                  $this->db->where('mu_id',$value_li_sub['mu_id']);
                  $query_chk = $this->db->get();
                  if($query_chk->num_rows()>0){
                    $fetch_chk = $query_chk->row_array();
                    $chkenable = intval($fetch_chk['rgu_view']);
                    $chkadd = intval($fetch_chk['rgu_add']);
                    $chkedit = intval($fetch_chk['rgu_edit']);
                    $chkdel = intval($fetch_chk['rgu_del']);
                    $chkprint = intval($fetch_chk['rgu_print']);
                  }
                  echo '<tr>';
                  echo '<td align="center" width="10%">'.$num.'.'.$num_secord.'</td>';
                  if($lang=="thai"){
                    echo '<td align="left" width="30%">'.$value_li_sub["mu_name_th"].'</td>';
                  }else if($lang=="english"){
                    echo '<td align="left" width="30%">'.$value_li_sub["mu_name_en"].'</td>';
                  }
                  $li_arr_sub_b = $this->checkmenu_sub($value_li_sub['mu_id']);
                  if(count($li_arr_sub_b)==0){
                    if($chkenable==1&&$chkadd==1&&$chkedit==1&&$chkdel==1&&$chkprint==1){ ?>
                <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" class="chkall_row" id="chkrowall_<?php echo $value_li_sub['mu_id'];?>" name="chkrowall_<?php echo $value_li_sub['mu_id'];?>" onchange='chk_chkbox("chkrowall","<?php echo $value_li_sub['mu_id'];?>","<?php echo $ug_id;?>")' value="1" checked><label for="chkrowall_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
              <?php }else{ ?>
                <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" class="chkall_row" id="chkrowall_<?php echo $value_li_sub['mu_id'];?>" name="chkrowall_<?php echo $value_li_sub['mu_id'];?>" onchange='chk_chkbox("chkrowall","<?php echo $value_li_sub['mu_id'];?>","<?php echo $ug_id;?>")' value="1"><label for="chkrowall_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
              <?php }
              if($chkenable==1){ ?>
                <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkenable_<?php echo $value_li_sub['mu_id'];?>" name="chkenable_<?php echo $value_li_sub['mu_id'];?>" class="chkrow_<?php echo $value_li_sub['mu_id'];?> chkcol_rgu_view" onchange='chk_chkbox("chkenable","<?php echo $value_li_sub['mu_id'];?>","<?php echo $ug_id;?>")' value="1" checked><label for="chkenable_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
             <?php }else{ ?>
                <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkenable_<?php echo $value_li_sub['mu_id'];?>" name="chkenable_<?php echo $value_li_sub['mu_id'];?>" class="chkrow_<?php echo $value_li_sub['mu_id'];?> chkcol_rgu_view" onchange='chk_chkbox("chkenable","<?php echo $value_li_sub['mu_id'];?>","<?php echo $ug_id;?>")' value="1"><label for="chkenable_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
            <?php  }
              if($chkadd==1){ ?>
                <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkadd_<?php echo $value_li_sub['mu_id'];?>" name="chkadd_<?php echo $value_li_sub['mu_id'];?>" class="chkrow_<?php echo $value_li_sub['mu_id'];?>  chkcol_rgu_add" onchange='chk_chkbox("chkadd","<?php echo $value_li_sub['mu_id'];?>","<?php echo $ug_id;?>")' value="1" checked><label for="chkadd_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
             <?php }else{ ?>
                <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkadd_<?php echo $value_li_sub['mu_id'];?>" name="chkadd_<?php echo $value_li_sub['mu_id'];?>" class="chkrow_<?php echo $value_li_sub['mu_id'];?>  chkcol_rgu_add" onchange='chk_chkbox("chkadd","<?php echo $value_li_sub['mu_id'];?>","<?php echo $ug_id;?>")' value="1"><label for="chkadd_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
             <?php }
              if($chkedit==1){ ?>
                <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkedit_<?php echo $value_li_sub['mu_id'];?>" name="chkedit_<?php echo $value_li_sub['mu_id'];?>" class="chkrow_<?php echo $value_li_sub['mu_id'];?> chkcol_rgu_edit" onchange='chk_chkbox("chkedit","<?php echo $value_li_sub['mu_id'];?>","<?php echo $ug_id;?>")' value="1" checked><label for="chkedit_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
             <?php }else{ ?>
                <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkedit_<?php echo $value_li_sub['mu_id'];?>" name="chkedit_<?php echo $value_li_sub['mu_id'];?>" class="chkrow_<?php echo $value_li_sub['mu_id'];?> chkcol_rgu_edit" onchange='chk_chkbox("chkedit","<?php echo $value_li_sub['mu_id'];?>","<?php echo $ug_id;?>")' value="1"><label for="chkedit_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
            <?php  }
              if($chkdel==1){ ?>
                <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkdel_<?php echo $value_li_sub['mu_id'];?>" name="chkdel_<?php echo $value_li_sub['mu_id'];?>" class="chkrow_<?php echo $value_li_sub['mu_id'];?> chkcol_rgu_del" onchange='chk_chkbox("chkdel","<?php echo $value_li_sub['mu_id'];?>","<?php echo $ug_id;?>")' value="1" checked><label for="chkdel_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
            <?php  }else{ ?>
                <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkdel_<?php echo $value_li_sub['mu_id'];?>" name="chkdel_<?php echo $value_li_sub['mu_id'];?>" class="chkrow_<?php echo $value_li_sub['mu_id'];?> chkcol_rgu_del" onchange='chk_chkbox("chkdel","<?php echo $value_li_sub['mu_id'];?>","<?php echo $ug_id;?>")' value="1"><label for="chkdel_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
             <?php }
              if($chkprint==1){ ?>
                <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkprint_<?php echo $value_li_sub['mu_id'];?>" name="chkprint_<?php echo $value_li_sub['mu_id'];?>" class="chkrow_<?php echo $value_li_sub['mu_id'];?> chkcol_rgu_print" onchange='chk_chkbox("chkprint","<?php echo $value_li_sub['mu_id'];?>","<?php echo $ug_id;?>")' value="1" checked><label for="chkprint_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
            <?php  }else{ ?>
                <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkprint_<?php echo $value_li_sub['mu_id'];?>" name="chkprint_<?php echo $value_li_sub['mu_id'];?>" class="chkrow_<?php echo $value_li_sub['mu_id'];?> chkcol_rgu_print" onchange='chk_chkbox("chkprint","<?php echo $value_li_sub['mu_id'];?>","<?php echo $ug_id;?>")' value="1"><label for="chkprint_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
            <?php  }
                  }else{
                    echo '<td colspan="6"></td>';
                  }
                  echo '</tr>';
                  if(count($li_arr_sub_b)>0){
                    $num_three = 1;

                    foreach ($li_arr_sub_b as $key_li_sub_b => $value_li_sub_b) {
                        $chkenable = 0;
                        $chkadd = 0;
                        $chkedit = 0;
                        $chkdel = 0;
                        $chkprint = 0;
                        $this->db->from('LMS_ROLE_GP');
                        $this->db->where('ug_id',$ug_id);
                        $this->db->where('mu_id',$value_li_sub_b['mu_id']);
                        $query_chk = $this->db->get();
                        if($query_chk->num_rows()>0){

                          $fetch_chk = $query_chk->row_array();
                          $chkenable = intval($fetch_chk['rgu_view']);
                          $chkadd = intval($fetch_chk['rgu_add']);
                          $chkedit = intval($fetch_chk['rgu_edit']);
                          $chkdel = intval($fetch_chk['rgu_del']);
                          $chkprint = intval($fetch_chk['rgu_print']);
                        }
                        echo '<tr>';
                        echo '<td align="right" width="10%">'.$num.'.'.$num_secord.'.'.$num_three.'</td>';
                        if($lang=="thai"){
                          echo '<td align="left" width="30%">'.$value_li_sub_b["mu_name_th"].'</td>';
                        }else if($lang=="english"){
                          echo '<td align="left" width="30%">'.$value_li_sub_b["mu_name_en"].'</td>';
                        }
                        if($chkenable==1&&$chkadd==1&&$chkedit==1&&$chkdel==1&&$chkprint==1){ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" class="chkall_row" id="chkrowall_<?php echo $value_li_sub_b['mu_id'];?>" name="chkrowall_<?php echo $value_li_sub_b['mu_id'];?>" onchange='chk_chkbox("chkrowall","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $ug_id;?>")' value="1" checked><label for="chkrowall_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                  <?php }else{ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" class="chkall_row" id="chkrowall_<?php echo $value_li_sub_b['mu_id'];?>" name="chkrowall_<?php echo $value_li_sub_b['mu_id'];?>" onchange='chk_chkbox("chkrowall","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $ug_id;?>")' value="1"><label for="chkrowall_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                  <?php }
                  if($chkenable==1){ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkenable_<?php echo $value_li_sub_b['mu_id'];?>" name="chkenable_<?php echo $value_li_sub_b['mu_id'];?>" class="chkrow_<?php echo $value_li_sub_b['mu_id'];?> chkcol_rgu_view" onchange='chk_chkbox("chkenable","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $ug_id;?>")' value="1" checked><label for="chkenable_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                 <?php }else{ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkenable_<?php echo $value_li_sub_b['mu_id'];?>" name="chkenable_<?php echo $value_li_sub_b['mu_id'];?>" class="chkrow_<?php echo $value_li_sub_b['mu_id'];?> chkcol_rgu_view" onchange='chk_chkbox("chkenable","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $ug_id;?>")' value="1"><label for="chkenable_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                <?php  }
                  if($chkadd==1){ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkadd_<?php echo $value_li_sub_b['mu_id'];?>" name="chkadd_<?php echo $value_li_sub_b['mu_id'];?>" class="chkrow_<?php echo $value_li_sub_b['mu_id'];?>  chkcol_rgu_add" onchange='chk_chkbox("chkadd","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $ug_id;?>")' value="1" checked><label for="chkadd_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                 <?php }else{ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkadd_<?php echo $value_li_sub_b['mu_id'];?>" name="chkadd_<?php echo $value_li_sub_b['mu_id'];?>" class="chkrow_<?php echo $value_li_sub_b['mu_id'];?>  chkcol_rgu_add" onchange='chk_chkbox("chkadd","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $ug_id;?>")' value="1"><label for="chkadd_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                 <?php }
                  if($chkedit==1){ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkedit_<?php echo $value_li_sub_b['mu_id'];?>" name="chkedit_<?php echo $value_li_sub_b['mu_id'];?>" class="chkrow_<?php echo $value_li_sub_b['mu_id'];?> chkcol_rgu_edit" onchange='chk_chkbox("chkedit","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $ug_id;?>")' value="1" checked><label for="chkedit_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                 <?php }else{ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkedit_<?php echo $value_li_sub_b['mu_id'];?>" name="chkedit_<?php echo $value_li_sub_b['mu_id'];?>" class="chkrow_<?php echo $value_li_sub_b['mu_id'];?> chkcol_rgu_edit" onchange='chk_chkbox("chkedit","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $ug_id;?>")' value="1"><label for="chkedit_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                <?php  }
                  if($chkdel==1){ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkdel_<?php echo $value_li_sub_b['mu_id'];?>" name="chkdel_<?php echo $value_li_sub_b['mu_id'];?>" class="chkrow_<?php echo $value_li_sub_b['mu_id'];?> chkcol_rgu_del" onchange='chk_chkbox("chkdel","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $ug_id;?>")' value="1" checked><label for="chkdel_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                <?php  }else{ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkdel_<?php echo $value_li_sub_b['mu_id'];?>" name="chkdel_<?php echo $value_li_sub_b['mu_id'];?>" class="chkrow_<?php echo $value_li_sub_b['mu_id'];?> chkcol_rgu_del" onchange='chk_chkbox("chkdel","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $ug_id;?>")' value="1"><label for="chkdel_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                 <?php }
                  if($chkprint==1){ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkprint_<?php echo $value_li_sub_b['mu_id'];?>" name="chkprint_<?php echo $value_li_sub_b['mu_id'];?>" class="chkrow_<?php echo $value_li_sub_b['mu_id'];?> chkcol_rgu_print" onchange='chk_chkbox("chkprint","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $ug_id;?>")' value="1" checked><label for="chkprint_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                <?php  }else{ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkprint_<?php echo $value_li_sub_b['mu_id'];?>" name="chkprint_<?php echo $value_li_sub_b['mu_id'];?>" class="chkrow_<?php echo $value_li_sub_b['mu_id'];?> chkcol_rgu_print" onchange='chk_chkbox("chkprint","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $ug_id;?>")' value="1"><label for="chkprint_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                <?php  }
                        $num_three++;
                        $num_ques++;
                    }
                  }
                  $num_secord++;
                  $num_ques++;
              }
            }
            $num++;
            $num_ques++;
          }
          echo '<input type="hidden" id="count_menu" name="count_menu" value="'.$num_ques.'">';
        }

        public function chkdataRoleUser($u_id){
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;
          $user = $this->session->userdata("user");
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $where = 'LMS_MENU.mu_parent="0" and LMS_MENU.mu_status="1" and LMS_MENU.mu_path !="dashboard"';
          if($user['com_admin']=="com_associated"){
            $where = 'mu_customer="1"';
          }
          $fetch_user = $this->func_query->query_row('LMS_USP','','','','u_id="'.$u_id.'"');
          $result_menu = $this->func_query->query_result('LMS_MENU','','','',$where,'mu_num ASC');
          $arr_sub = array();
          foreach ($result_menu as $key => $value) {
            $num_chk = 0;
            $li_arr_sub = $this->checkmenu_sub($value['mu_id']);
            if(count($li_arr_sub)>0){
              foreach ($li_arr_sub as $key_li_sub => $value_li_sub) {
                  $li_arr_sub_b = $this->checkmenu_sub($value_li_sub['mu_id']);
                  array_push($arr_sub, $value_li_sub['mu_id']);
                  if(count($li_arr_sub_b)>0){
                    foreach ($li_arr_sub_b as $key_sub_b => $value_sub_b) {
                      array_push($arr_sub, $value_sub_b['mu_id']);
                      $fetch_chk = $this->func_query->numrows('LMS_ROLE_GP','','','','mu_id="'.$value_sub_b['mu_id'].'" and ug_id="'.$fetch_user['ug_id'].'" and rgu_view="1"');
                      if($fetch_chk>0){
                        array_push($arr_sub, $value_sub_b['mu_id']);
                        $num_chk++;
                      }
                    }
                  }else{
                      $fetch_chk = $this->func_query->numrows('LMS_ROLE_GP','','','','mu_id="'.$value_li_sub['mu_id'].'" and ug_id="'.$fetch_user['ug_id'].'" and rgu_view="1"');
                      if($fetch_chk>0){
                        $num_chk++;
                      }
                  }
              }
            }else{
                      $fetch_chk = $this->func_query->numrows('LMS_ROLE_GP','','','','mu_id="'.$value['mu_id'].'" and ug_id="'.$fetch_user['ug_id'].'" and rgu_view="1"');
                      if($fetch_chk>0){
                        $num_chk++;
                      }
            }
            if($num_chk==0){
              unset($result_menu[$key]);
            }
          }
          foreach ($result_menu as $key => $value) {
            if(in_array($value['mu_id'], $arr_sub)){
              unset($result_menu[$key]);
            }
          }
          $num_ques=0;
          $num = 1;
          foreach ($result_menu as $key => $value) {
            $chkenable = 0;
            $chkadd = 0;
            $chkedit = 0;
            $chkdel = 0;
            $chkprint = 0;
            $this->db->from('LMS_ROLE_USP');
            $this->db->where('u_id',$u_id);
            $this->db->where('mu_id',$value['mu_id']);
            $query_chk = $this->db->get();
            if($query_chk->num_rows()>0){

              $fetch_chk = $query_chk->row_array();
              $chkenable = intval($fetch_chk['ru_view']);
              $chkadd = intval($fetch_chk['ru_add']);
              $chkedit = intval($fetch_chk['ru_edit']);
              $chkdel = intval($fetch_chk['ru_del']);
              $chkprint = intval($fetch_chk['ru_print']);
            }
            echo '<tr>';
            echo '<td align="left" width="10%">'.$num.'</td>';
            if($lang=="thai"){
              echo '<td align="left" width="30%">'.$value["mu_name_th"].'</td>';
            }else if($lang=="english"){
              echo '<td align="left" width="30%">'.$value["mu_name_en"].'</td>';
            }
            $li_arr_sub = $this->checkmenu_sub($value['mu_id']);
            if(count($li_arr_sub)==0){
            if($chkenable==1&&$chkadd==1&&$chkedit==1&&$chkdel==1&&$chkprint==1){ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" class="chkall_row" id="chkrowall_<?php echo $value['mu_id'];?>" name="chkrowall_<?php echo $value['mu_id'];?>" onchange='chk_chkbox("chkrowall","<?php echo $value['mu_id'];?>","<?php echo $u_id;?>")' value="1" checked><label for="chkrowall_<?php echo $value['mu_id'];?>"></label></div></td>
            <?php }else{ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" class="chkall_row" id="chkrowall_<?php echo $value['mu_id'];?>" name="chkrowall_<?php echo $value['mu_id'];?>" onchange='chk_chkbox("chkrowall","<?php echo $value['mu_id'];?>","<?php echo $u_id;?>")' value="1"><label for="chkrowall_<?php echo $value['mu_id'];?>"></label></div></td>
            <?php }
            if($chkenable==1){ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkenable_<?php echo $value['mu_id'];?>" name="chkenable_<?php echo $value['mu_id'];?>" class="chkrow_<?php echo $value['mu_id'];?> chkcol_ru_view" onchange='chk_chkbox("chkenable","<?php echo $value['mu_id'];?>","<?php echo $u_id;?>")' value="1" checked><label for="chkenable_<?php echo $value['mu_id'];?>"></label></div></td>
           <?php }else{ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkenable_<?php echo $value['mu_id'];?>" name="chkenable_<?php echo $value['mu_id'];?>" class="chkrow_<?php echo $value['mu_id'];?> chkcol_ru_view" onchange='chk_chkbox("chkenable","<?php echo $value['mu_id'];?>","<?php echo $u_id;?>")' value="1"><label for="chkenable_<?php echo $value['mu_id'];?>"></label></div></td>
          <?php  }
            if($chkadd==1){ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkadd_<?php echo $value['mu_id'];?>" name="chkadd_<?php echo $value['mu_id'];?>" class="chkrow_<?php echo $value['mu_id'];?>  chkcol_ru_add" onchange='chk_chkbox("chkadd","<?php echo $value['mu_id'];?>","<?php echo $u_id;?>")' value="1" checked><label for="chkadd_<?php echo $value['mu_id'];?>"></label></div></td>
           <?php }else{ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkadd_<?php echo $value['mu_id'];?>" name="chkadd_<?php echo $value['mu_id'];?>" class="chkrow_<?php echo $value['mu_id'];?>  chkcol_ru_add" onchange='chk_chkbox("chkadd","<?php echo $value['mu_id'];?>","<?php echo $u_id;?>")' value="1"><label for="chkadd_<?php echo $value['mu_id'];?>"></label></div></td>
           <?php }
            if($chkedit==1){ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkedit_<?php echo $value['mu_id'];?>" name="chkedit_<?php echo $value['mu_id'];?>"class="chkrow_<?php echo $value['mu_id'];?> chkcol_ru_edit" onchange='chk_chkbox("chkedit","<?php echo $value['mu_id'];?>","<?php echo $u_id;?>")' value="1" checked><label for="chkedit_<?php echo $value['mu_id'];?>"></label></div></td>
           <?php }else{ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkedit_<?php echo $value['mu_id'];?>" name="chkedit_<?php echo $value['mu_id'];?>"class="chkrow_<?php echo $value['mu_id'];?> chkcol_ru_edit" onchange='chk_chkbox("chkedit","<?php echo $value['mu_id'];?>","<?php echo $u_id;?>")' value="1"><label for="chkedit_<?php echo $value['mu_id'];?>"></label></div></td>
          <?php  }
            if($chkdel==1){ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkdel_<?php echo $value['mu_id'];?>" name="chkdel_<?php echo $value['mu_id'];?>" class="chkrow_<?php echo $value['mu_id'];?> chkcol_ru_del" onchange='chk_chkbox("chkdel","<?php echo $value['mu_id'];?>","<?php echo $u_id;?>")' value="1" checked><label for="chkdel_<?php echo $value['mu_id'];?>"></label></div></td>
          <?php  }else{ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkdel_<?php echo $value['mu_id'];?>" name="chkdel_<?php echo $value['mu_id'];?>" class="chkrow_<?php echo $value['mu_id'];?> chkcol_ru_del" onchange='chk_chkbox("chkdel","<?php echo $value['mu_id'];?>","<?php echo $u_id;?>")' value="1"><label for="chkdel_<?php echo $value['mu_id'];?>"></label></div></td>
           <?php }
            if($chkprint==1){ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkprint_<?php echo $value['mu_id'];?>" name="chkprint_<?php echo $value['mu_id'];?>" class="chkrow_<?php echo $value['mu_id'];?> chkcol_ru_print" onchange='chk_chkbox("chkprint","<?php echo $value['mu_id'];?>","<?php echo $u_id;?>")' value="1" checked><label for="chkprint_<?php echo $value['mu_id'];?>"></label></div></td>
          <?php  }else{ ?>
              <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkprint_<?php echo $value['mu_id'];?>" name="chkprint_<?php echo $value['mu_id'];?>" class="chkrow_<?php echo $value['mu_id'];?> chkcol_ru_print" onchange='chk_chkbox("chkprint","<?php echo $value['mu_id'];?>","<?php echo $u_id;?>")' value="1"><label for="chkprint_<?php echo $value['mu_id'];?>"></label></div></td>
          <?php  }
            }else{
              echo '<td colspan="6"></td>';
            }
            echo '</tr>';
            if(count($li_arr_sub)>0){
              $num_secord = 1;

              foreach ($li_arr_sub as $key_li_sub => $value_li_sub) {
                  $num_chk = 0;
                  $li_arr_sub_b = $this->checkmenu_sub($value_li_sub['mu_id']);
                  if(count($li_arr_sub_b)>0){
                    foreach ($li_arr_sub_b as $key_sub_b => $value_sub_b) {
                      $fetch_chk = $this->func_query->numrows('LMS_ROLE_GP','','','','mu_id="'.$value_sub_b['mu_id'].'" and ug_id="'.$fetch_user['ug_id'].'" and rgu_view="1"');
                      if($fetch_chk>0){
                        $num_chk++;
                      }
                    }
                  }else{
                      $fetch_chk = $this->func_query->numrows('LMS_ROLE_GP','','','','mu_id="'.$value_li_sub['mu_id'].'" and ug_id="'.$fetch_user['ug_id'].'" and rgu_view="1"');
                      if($fetch_chk>0){
                        $num_chk++;
                      }
                  }
                  if($num_chk==0){
                    unset($li_arr_sub[$key_li_sub]);
                  }
              }
              foreach ($li_arr_sub as $key_li_sub => $value_li_sub) {
                  $chkenable = 0;
                  $chkadd = 0;
                  $chkedit = 0;
                  $chkdel = 0;
                  $chkprint = 0;
                  $this->db->from('LMS_ROLE_USP');
                  $this->db->where('u_id',$u_id);
                  $this->db->where('mu_id',$value_li_sub['mu_id']);
                  $query_chk = $this->db->get();
                  if($query_chk->num_rows()>0){

                    $fetch_chk = $query_chk->row_array();
                    $chkenable = intval($fetch_chk['ru_view']);
                    $chkadd = intval($fetch_chk['ru_add']);
                    $chkedit = intval($fetch_chk['ru_edit']);
                    $chkdel = intval($fetch_chk['ru_del']);
                    $chkprint = intval($fetch_chk['ru_print']);
                  }
                  echo '<tr>';
                  echo '<td align="center" width="10%">'.$num.'.'.$num_secord.'</td>';
                  if($lang=="thai"){
                    echo '<td align="left" width="30%">'.$value_li_sub["mu_name_th"].'</td>';
                  }else if($lang=="english"){
                    echo '<td align="left" width="30%">'.$value_li_sub["mu_name_en"].'</td>';
                  }
                  $li_arr_sub_b = $this->checkmenu_sub($value_li_sub['mu_id']);
                  if(count($li_arr_sub_b)==0){
                  if($chkenable==1&&$chkadd==1&&$chkedit==1&&$chkdel==1&&$chkprint==1){ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" class="chkall_row" id="chkrowall_<?php echo $value_li_sub['mu_id'];?>" name="chkrowall_<?php echo $value_li_sub['mu_id'];?>" onchange='chk_chkbox("chkrowall","<?php echo $value_li_sub['mu_id'];?>","<?php echo $u_id;?>")' value="1" checked><label for="chkrowall_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
                  <?php }else{ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" class="chkall_row" id="chkrowall_<?php echo $value_li_sub['mu_id'];?>" name="chkrowall_<?php echo $value_li_sub['mu_id'];?>" onchange='chk_chkbox("chkrowall","<?php echo $value_li_sub['mu_id'];?>","<?php echo $u_id;?>")' value="1"><label for="chkrowall_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
                  <?php }
                  if($chkenable==1){ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkenable_<?php echo $value_li_sub['mu_id'];?>" name="chkenable_<?php echo $value_li_sub['mu_id'];?>" class="chkrow_<?php echo $value_li_sub['mu_id'];?> chkcol_ru_view" onchange='chk_chkbox("chkenable","<?php echo $value_li_sub['mu_id'];?>","<?php echo $u_id;?>")' value="1" checked><label for="chkenable_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
                 <?php }else{ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkenable_<?php echo $value_li_sub['mu_id'];?>" name="chkenable_<?php echo $value_li_sub['mu_id'];?>" class="chkrow_<?php echo $value_li_sub['mu_id'];?> chkcol_ru_view" onchange='chk_chkbox("chkenable","<?php echo $value_li_sub['mu_id'];?>","<?php echo $u_id;?>")' value="1"><label for="chkenable_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
                <?php  }
                  if($chkadd==1){ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkadd_<?php echo $value_li_sub['mu_id'];?>" name="chkadd_<?php echo $value_li_sub['mu_id'];?>" class="chkrow_<?php echo $value_li_sub['mu_id'];?>  chkcol_ru_add" onchange='chk_chkbox("chkadd","<?php echo $value_li_sub['mu_id'];?>","<?php echo $u_id;?>")' value="1" checked><label for="chkadd_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
                 <?php }else{ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkadd_<?php echo $value_li_sub['mu_id'];?>" name="chkadd_<?php echo $value_li_sub['mu_id'];?>" class="chkrow_<?php echo $value_li_sub['mu_id'];?>  chkcol_ru_add" onchange='chk_chkbox("chkadd","<?php echo $value_li_sub['mu_id'];?>","<?php echo $u_id;?>")' value="1"><label for="chkadd_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
                 <?php }
                  if($chkedit==1){ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkedit_<?php echo $value_li_sub['mu_id'];?>" name="chkedit_<?php echo $value_li_sub['mu_id'];?>"class="chkrow_<?php echo $value_li_sub['mu_id'];?> chkcol_ru_edit" onchange='chk_chkbox("chkedit","<?php echo $value_li_sub['mu_id'];?>","<?php echo $u_id;?>")' value="1" checked><label for="chkedit_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
                 <?php }else{ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkedit_<?php echo $value_li_sub['mu_id'];?>" name="chkedit_<?php echo $value_li_sub['mu_id'];?>"class="chkrow_<?php echo $value_li_sub['mu_id'];?> chkcol_ru_edit" onchange='chk_chkbox("chkedit","<?php echo $value_li_sub['mu_id'];?>","<?php echo $u_id;?>")' value="1"><label for="chkedit_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
                <?php  }
                  if($chkdel==1){ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkdel_<?php echo $value_li_sub['mu_id'];?>" name="chkdel_<?php echo $value_li_sub['mu_id'];?>" class="chkrow_<?php echo $value_li_sub['mu_id'];?> chkcol_ru_del" onchange='chk_chkbox("chkdel","<?php echo $value_li_sub['mu_id'];?>","<?php echo $u_id;?>")' value="1" checked><label for="chkdel_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
                <?php  }else{ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkdel_<?php echo $value_li_sub['mu_id'];?>" name="chkdel_<?php echo $value_li_sub['mu_id'];?>" class="chkrow_<?php echo $value_li_sub['mu_id'];?> chkcol_ru_del" onchange='chk_chkbox("chkdel","<?php echo $value_li_sub['mu_id'];?>","<?php echo $u_id;?>")' value="1"><label for="chkdel_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
                 <?php }
                  if($chkprint==1){ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkprint_<?php echo $value_li_sub['mu_id'];?>" name="chkprint_<?php echo $value_li_sub['mu_id'];?>" class="chkrow_<?php echo $value_li_sub['mu_id'];?> chkcol_ru_print" onchange='chk_chkbox("chkprint","<?php echo $value_li_sub['mu_id'];?>","<?php echo $u_id;?>")' value="1" checked><label for="chkprint_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
                <?php  }else{ ?>
                    <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkprint_<?php echo $value_li_sub['mu_id'];?>" name="chkprint_<?php echo $value_li_sub['mu_id'];?>" class="chkrow_<?php echo $value_li_sub['mu_id'];?> chkcol_ru_print" onchange='chk_chkbox("chkprint","<?php echo $value_li_sub['mu_id'];?>","<?php echo $u_id;?>")' value="1"><label for="chkprint_<?php echo $value_li_sub['mu_id'];?>"></label></div></td>
                <?php  }
                  }else{
                    echo '<td colspan="6"></td>';
                  }
                  echo '</tr>';

                  if(count($li_arr_sub_b)>0){
                    $num_three = 1;

              
                    foreach ($li_arr_sub_b as $key_li_sub_b => $value_li_sub_b) {
                      $fetch_chk = $this->func_query->numrows('LMS_ROLE_GP','','','','mu_id="'.$value_li_sub_b['mu_id'].'" and ug_id="'.$fetch_user['ug_id'].'" and rgu_view="1"');
                      if($fetch_chk==0){
                        unset($li_arr_sub_b[$key_li_sub_b]);
                      }
                    }
                    foreach ($li_arr_sub_b as $key_li_sub_b => $value_li_sub_b) {
                        $chkenable = 0;
                        $chkadd = 0;
                        $chkedit = 0;
                        $chkdel = 0;
                        $chkprint = 0;
                        $this->db->from('LMS_ROLE_USP');
                        $this->db->where('u_id',$u_id);
                        $this->db->where('mu_id',$value_li_sub_b['mu_id']);
                        $query_chk = $this->db->get();
                        if($query_chk->num_rows()>0){

                          $fetch_chk = $query_chk->row_array();
                          $chkenable = intval($fetch_chk['ru_view']);
                          $chkadd = intval($fetch_chk['ru_add']);
                          $chkedit = intval($fetch_chk['ru_edit']);
                          $chkdel = intval($fetch_chk['ru_del']);
                          $chkprint = intval($fetch_chk['ru_print']);
                        }
                        echo '<tr>';
                        echo '<td align="right" width="10%">'.$num.'.'.$num_secord.'.'.$num_three.'</td>';
                        if($lang=="thai"){
                          echo '<td align="left" width="30%">'.$value_li_sub_b["mu_name_th"].'</td>';
                        }else if($lang=="english"){
                          echo '<td align="left" width="30%">'.$value_li_sub_b["mu_name_en"].'</td>';
                        }
                        if($chkenable==1&&$chkadd==1&&$chkedit==1&&$chkdel==1&&$chkprint==1){ ?>
                      <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" class="chkall_row" id="chkrowall_<?php echo $value_li_sub_b['mu_id'];?>" name="chkrowall_<?php echo $value_li_sub_b['mu_id'];?>" onchange='chk_chkbox("chkrowall","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $u_id;?>")' value="1" checked><label for="chkrowall_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                    <?php }else{ ?>
                      <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" class="chkall_row" id="chkrowall_<?php echo $value_li_sub_b['mu_id'];?>" name="chkrowall_<?php echo $value_li_sub_b['mu_id'];?>" onchange='chk_chkbox("chkrowall","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $u_id;?>")' value="1"><label for="chkrowall_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                    <?php }
                    if($chkenable==1){ ?>
                      <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkenable_<?php echo $value_li_sub_b['mu_id'];?>" name="chkenable_<?php echo $value_li_sub_b['mu_id'];?>" class="chkrow_<?php echo $value_li_sub_b['mu_id'];?> chkcol_ru_view" onchange='chk_chkbox("chkenable","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $u_id;?>")' value="1" checked><label for="chkenable_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                   <?php }else{ ?>
                      <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkenable_<?php echo $value_li_sub_b['mu_id'];?>" name="chkenable_<?php echo $value_li_sub_b['mu_id'];?>" class="chkrow_<?php echo $value_li_sub_b['mu_id'];?> chkcol_ru_view" onchange='chk_chkbox("chkenable","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $u_id;?>")' value="1"><label for="chkenable_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                  <?php  }
                    if($chkadd==1){ ?>
                      <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkadd_<?php echo $value_li_sub_b['mu_id'];?>" name="chkadd_<?php echo $value_li_sub_b['mu_id'];?>" class="chkrow_<?php echo $value_li_sub_b['mu_id'];?>  chkcol_ru_add" onchange='chk_chkbox("chkadd","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $u_id;?>")' value="1" checked><label for="chkadd_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                   <?php }else{ ?>
                      <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkadd_<?php echo $value_li_sub_b['mu_id'];?>" name="chkadd_<?php echo $value_li_sub_b['mu_id'];?>" class="chkrow_<?php echo $value_li_sub_b['mu_id'];?>  chkcol_ru_add" onchange='chk_chkbox("chkadd","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $u_id;?>")' value="1"><label for="chkadd_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                   <?php }
                    if($chkedit==1){ ?>
                      <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkedit_<?php echo $value_li_sub_b['mu_id'];?>" name="chkedit_<?php echo $value_li_sub_b['mu_id'];?>"class="chkrow_<?php echo $value_li_sub_b['mu_id'];?> chkcol_ru_edit" onchange='chk_chkbox("chkedit","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $u_id;?>")' value="1" checked><label for="chkedit_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                   <?php }else{ ?>
                      <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkedit_<?php echo $value_li_sub_b['mu_id'];?>" name="chkedit_<?php echo $value_li_sub_b['mu_id'];?>"class="chkrow_<?php echo $value_li_sub_b['mu_id'];?> chkcol_ru_edit" onchange='chk_chkbox("chkedit","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $u_id;?>")' value="1"><label for="chkedit_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                  <?php  }
                    if($chkdel==1){ ?>
                      <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkdel_<?php echo $value_li_sub_b['mu_id'];?>" name="chkdel_<?php echo $value_li_sub_b['mu_id'];?>" class="chkrow_<?php echo $value_li_sub_b['mu_id'];?> chkcol_ru_del" onchange='chk_chkbox("chkdel","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $u_id;?>")' value="1" checked><label for="chkdel_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                  <?php  }else{ ?>
                      <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkdel_<?php echo $value_li_sub_b['mu_id'];?>" name="chkdel_<?php echo $value_li_sub_b['mu_id'];?>" class="chkrow_<?php echo $value_li_sub_b['mu_id'];?> chkcol_ru_del" onchange='chk_chkbox("chkdel","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $u_id;?>")' value="1"><label for="chkdel_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                   <?php }
                    if($chkprint==1){ ?>
                      <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkprint_<?php echo $value_li_sub_b['mu_id'];?>" name="chkprint_<?php echo $value_li_sub_b['mu_id'];?>" class="chkrow_<?php echo $value_li_sub_b['mu_id'];?> chkcol_ru_print" onchange='chk_chkbox("chkprint","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $u_id;?>")' value="1" checked><label for="chkprint_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                  <?php  }else{ ?>
                      <td align="center" width="10%"><div class="checkbox checkbox-success"><input type="checkbox" id="chkprint_<?php echo $value_li_sub_b['mu_id'];?>" name="chkprint_<?php echo $value_li_sub_b['mu_id'];?>" class="chkrow_<?php echo $value_li_sub_b['mu_id'];?> chkcol_ru_print" onchange='chk_chkbox("chkprint","<?php echo $value_li_sub_b['mu_id'];?>","<?php echo $u_id;?>")' value="1"><label for="chkprint_<?php echo $value_li_sub_b['mu_id'];?>"></label></div></td>
                  <?php  }
                        echo '</tr>';
                        $num_three++;
                        $num_ques++;
                    }
                  }
                  $num_secord++;
                  $num_ques++;
              }
            }
            $num++;
            $num_ques++;
          }
          echo '<input type="hidden" id="count_menu" name="count_menu" value="'.$num_ques.'">';
        }
        public function update_groupuser($data,$ug_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('ug_id', $ug_id);
          $this->db->update('LMS_USP_GP', $data);
          return "2";
        }
        public function delete_groupuser($ug_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('ug_id', $ug_id);
          $this->db->delete('LMS_USP_GP');
          return "2";
        }
        public function query_data_onupdate($id, $datatable,$fieldname) {
          $user = $this->session->userdata('user');
          $this->db->from($datatable);
          if($datatable=="LMS_USP"){
            //$this->db->select('LMS_USP.u_id, LMS_EMP.lang,LMS_EMP.emp_c,LMS_EMP.emp_id, LMS_EMP.prefix_th, LMS_EMP.fname_th, LMS_EMP.lname_th,LMS_EMP.fullname_th,LMS_EMP.fullname_en, LMS_EMP.prefix_en, LMS_EMP.fname_en, LMS_EMP.lname_en,LMS_EMP.gender,LMS_EMP.address_th,LMS_EMP.address_en,LMS_EMP.work_phone,LMS_EMP.phone,LMS_EMP.email,LMS_EMP.employ_date,LMS_USP.useri, LMS_USP_GP.ug_id, LMS_USP_GP.ug_name_en,LMS_USP_GP.ug_for,LMS_USP.dep_id, LMS_DEPART.dep_name_th,LMS_DEPART.dep_name_en,LMS_COMPANY.com_id, LMS_COMPANY.com_name_th,LMS_COMPANY.com_name_eng,LMS_COMPANY.com_bgpic_user,LMS_EMP.status, LMS_EMP.lang,LMS_EMP.is_manager,LMS_USP.login ,LMS_USP.last_act,LMS_USP.firsttime,LMS_USP.expiredate,LMS_USP.img_profile,LMS_POSITION.posi_id,LMS_POSITION.posi_name_th,LMS_POSITION.posi_name_en');
            $this->db->join('LMS_EMP','LMS_USP.emp_id = LMS_EMP.emp_id');
            //$this->db->join('LMS_DEPART','LMS_USP.dep_id = LMS_DEPART.dep_id');
            $this->db->join('LMS_COMPANY','LMS_EMP.com_id = LMS_COMPANY.com_id');
            $this->db->join('LMS_USP_GP','LMS_USP.ug_id = LMS_USP_GP.ug_id');
            //$this->db->join('LMS_POSITION','LMS_USP.posi_id = LMS_POSITION.posi_id');
          }else if($datatable=="LMS_LES"){
            $this->db->join('LMS_COS','LMS_LES.cos_id = LMS_COS.cos_id');
            if($user['ug_name_en']=="User"){
              $this->db->where('LMS_COS.com_id', $user['com_id']);
            }
          }
          $this->db->where($fieldname, $id);
          $query = $this->db->get();
          return $query->row_array();
        }

        public function query_multi_data_onupdate($id, $datatable,$fieldname) {
          $user = $this->session->userdata('user');
          $this->db->from($datatable);
          if($datatable=="LMS_USP"){
            //$this->db->select('LMS_USP.u_id, LMS_EMP.lang,LMS_EMP.emp_c,LMS_EMP.emp_id, LMS_EMP.prefix_th, LMS_EMP.fname_th, LMS_EMP.lname_th,LMS_EMP.fullname_th,LMS_EMP.fullname_en, LMS_EMP.prefix_en, LMS_EMP.fname_en, LMS_EMP.lname_en,LMS_EMP.gender,LMS_EMP.address_th,LMS_EMP.address_en,LMS_EMP.work_phone,LMS_EMP.phone,LMS_EMP.email,LMS_EMP.employ_date,LMS_USP.useri, LMS_USP_GP.ug_id, LMS_USP_GP.ug_name_en,LMS_USP_GP.ug_for,LMS_USP.dep_id, LMS_DEPART.dep_name_th,LMS_DEPART.dep_name_en,LMS_COMPANY.com_id, LMS_COMPANY.com_name_th,LMS_COMPANY.com_name_eng,LMS_COMPANY.com_bgpic_user,LMS_EMP.status, LMS_EMP.lang,LMS_EMP.is_manager,LMS_USP.login ,LMS_USP.last_act,LMS_USP.firsttime,LMS_USP.expiredate,LMS_USP.img_profile,LMS_POSITION.posi_id,LMS_POSITION.posi_name_th,LMS_POSITION.posi_name_en');
            $this->db->join('LMS_EMP','LMS_USP.emp_id = LMS_EMP.emp_id');
            //$this->db->join('LMS_DEPART','LMS_USP.dep_id = LMS_DEPART.dep_id');
            $this->db->join('LMS_COMPANY','LMS_EMP.com_id = LMS_COMPANY.com_id');
            $this->db->join('LMS_USP_GP','LMS_USP.ug_id = LMS_USP_GP.ug_id');
            //$this->db->join('LMS_POSITION','LMS_USP.posi_id = LMS_POSITION.posi_id');
          }else if($datatable=="LMS_LES"){
            $this->db->join('LMS_COS','LMS_LES.cos_id = LMS_COS.cos_id');
            if($user['ug_name_en']=="User"){
              $this->db->where('LMS_COS.com_id', $user['com_id']);
            }
          }
          $this->db->where($fieldname, $id);
          $query = $this->db->get();
          return $query->result_array();
        }

        public function query_data_chkheadcol($ug_id){
          $arr_field = array('rgu_view','rgu_add','rgu_edit','rgu_del','rgu_print');
          $this->db->from('LMS_MENU');
          $this->db->order_by('mu_num','ASC');
          $query = $this->db->get();
          $row = $query->result();
          $result_ques = $query->num_rows();

          $rgu_view = 0;
          $rgu_add = 0;
          $rgu_edit = 0;
          $rgu_del = 0;
          $rgu_print = 0;

          $this->db->from('LMS_ROLE_GP');
          $this->db->where('ug_id',$ug_id);
          $query = $this->db->get();
          $result_ques = $query->num_rows();
          $this->db->select('sum(rgu_view)as rgu_view,sum(rgu_add)as rgu_add,sum(rgu_edit)as rgu_edit,sum(rgu_del)as rgu_del,sum(rgu_print)as rgu_print');
          $this->db->from('LMS_ROLE_GP');
          $this->db->where('ug_id',$ug_id);
          $query = $this->db->get();
          $fetch = $query->row_array();
          $rgu_view = $fetch['rgu_view'];
          $rgu_add = $fetch['rgu_add'];
          $rgu_edit = $fetch['rgu_edit'];
          $rgu_del = $fetch['rgu_del'];
          $rgu_print = $fetch['rgu_print'];
          /*$rgu_view = $this->countrecordheadcol("rgu_view",$ug_id);
          $rgu_add = $this->countrecordheadcol("rgu_add",$ug_id);
          $rgu_edit = $this->countrecordheadcol("rgu_edit",$ug_id);
          $rgu_del = $this->countrecordheadcol("rgu_del",$ug_id);
          $rgu_print = $this->countrecordheadcol("rgu_print",$ug_id);*/
          $arr = array(
            'countmenu' => $result_ques,
            'rgu_view' => $rgu_view,
            'rgu_add' => $rgu_add,
            'rgu_edit' => $rgu_edit,
            'rgu_del' => $rgu_del,
            'rgu_print' => $rgu_print
          );
          return $arr;
        }

        public function getSVQ($sv_id,$val){
            $this->db->select('LMS_QN_USER_DE.svde_id,LMS_QN_USER_DE.qnude_var');
            $this->db->from('LMS_SURVEY_DE');
            $this->db->join('LMS_QN_USER_DE', 'LMS_SURVEY_DE.svde_id = LMS_QN_USER_DE.svde_id');
            $this->db->where('LMS_SURVEY_DE.sv_id', $sv_id);
            $this->db->where('LMS_QN_USER_DE.qnude_var', $val);
            $query = $this->db->get();
            return $query->result_array();
        }

        public function query_data_chkheadcol_user($u_id){
          $arr_field = array('ru_view','ru_add','ru_edit','ru_del','ru_print');
          $this->db->from('LMS_MENU');
          $this->db->order_by('mu_num','ASC');
          $query = $this->db->get();
          $row = $query->result();
          $result_ques = $query->num_rows();

          $ru_view = 0;
          $ru_add = 0;
          $ru_edit = 0;
          $ru_del = 0;
          $ru_print = 0;

          $ru_view = $this->countrecordheadcoluser("ru_view",$u_id);
          $ru_add = $this->countrecordheadcoluser("ru_add",$u_id);
          $ru_edit = $this->countrecordheadcoluser("ru_edit",$u_id);
          $ru_del = $this->countrecordheadcoluser("ru_del",$u_id);
          $ru_print = $this->countrecordheadcoluser("ru_print",$u_id);
          $arr = array(
            'countmenu' => $result_ques,
            'ru_view' => $ru_view,
            'ru_add' => $ru_add,
            'ru_edit' => $ru_edit,
            'ru_del' => $ru_del,
            'ru_print' => $ru_print
          );
          return $arr;
        }

        public function countrecordheadcol($field="",$ug_id=""){
          $this->db->from('LMS_ROLE_GP');
          $this->db->where($field,'1');
          $this->db->where('ug_id',$ug_id);
          $query = $this->db->get();
          $row = $query->num_rows();
          return $row;
        }
        public function countrecordheadcoluser($field="",$ug_id=""){
          $this->db->from('LMS_ROLE_USP');
          $this->db->where($field,'1');
          $this->db->where('u_id',$ug_id);
          $query = $this->db->get();
          $row = $query->num_rows();
          return $row;
        }

        public function countrecordcos_sort($com_id=""){
          $this->db->from('LMS_COS_SORT');
          $this->db->join('LMS_COS','LMS_COS_SORT.cos_id = LMS_COS.cos_id');
          $this->db->where('LMS_COS.com_id',$com_id);
          $query = $this->db->get();
          $row = $query->num_rows();
          return $row;
        }
        public function getCompany($wg_code="") {
          $user = $this->session->userdata('user');
          $ar_return = array();
            $this->db->select('com_id,com_name_th,com_name_eng,com_admin');
            $this->db->distinct();
            if($user['com_admin']=="com_associated"){
              $this->db->where('com_id', $user['com_id'] );
            }else{
              if($user['ug_id']!="1"){
              $this->db->where('com_id', $user['com_id'] );
              }
            }
            $this->db->where('com_status','1');
            $this->db->where('com_isDelete','0');
            $this->db->where('com_id!=','1');
            $query = $this->db->get('LMS_COMPANY');
            $ar_return = $query->result_array();
          return $ar_return;
        }

        public function getUser($useri, $lang) {
          $this->db->select('LMS_USP.u_id,LMS_EMP.emp_c, LMS_EMP.fullname_th, LMS_EMP.fullname_en,LMS_USP.useri, LMS_USP_GP.ug_id, LMS_USP_GP.ug_name_th,LMS_USP_GP.ug_name_en,LMS_USP_GP.Is_admin,LMS_USP_GP.ug_for,LMS_DEPART.dep_id, LMS_DEPART.dep_name_th,LMS_DEPART.dep_name_en,LMS_COMPANY.com_id, LMS_COMPANY.com_name_th,LMS_COMPANY.com_name_eng,LMS_EMP.status, LMS_EMP.lang,LMS_EMP.is_manager,LMS_USP.login ,LMS_USP.last_act,LMS_USP.firsttime,LMS_USP.expiredate,LMS_USP.img_profile');
          $this->db->from('LMS_USP');
          $this->db->join('LMS_EMP','LMS_USP.emp_id = LMS_EMP.emp_id');
          $this->db->join('LMS_DEPART','LMS_USP.dep_id = LMS_DEPART.dep_id');
          $this->db->join('LMS_COMPANY','LMS_DEPART.com_id = LMS_COMPANY.com_id');
          $this->db->join('LMS_USP_GP','LMS_USP.ug_id = LMS_USP_GP.ug_id');
          $this->db->where('LMS_USP.useri', $useri);
          //$this->db->where('lang', $lang);
          $query = $this->db->get();
          return $query->row_array();
        }

        public function checkdepartment($com_id) {
          $this->db->from('LMS_DEPART');
          $this->db->where('LMS_DEPART.dep_status', '1');
          $this->db->where('LMS_DEPART.dep_isDelete', '0');
          $this->db->where('LMS_DEPART.com_id', $com_id);
          //$this->db->where('lang', $lang);
          $query = $this->db->get();
          return $query->result_array();
        }

        public function isMobile() {
            return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
        }

        public function checklesson($cos_id,$les_lang) {
          $this->db->from('LMS_LES');
          $this->db->where('LMS_LES.les_status', '1');
          $this->db->where('LMS_LES.les_isDelete', '0');
          $this->db->where('LMS_LES.cos_id', $cos_id);
         //$this->db->where('LMS_LES.les_lang', $les_lang);
          $this->db->order_by('les_sequences', 'ASC');
          //$this->db->where('lang', $lang);
          $query = $this->db->get();
          return $query->result_array();
        }
        public function checkmenu() {
          $this->db->from('LMS_MENU');
          $this->db->where('LMS_MENU.mu_status', '1');
          $this->db->where('LMS_MENU.mu_parent', '0');
          $this->db->where("mu_path NOT LIKE '%home%'");
          $this->db->order_by('mu_num', 'ASC');
          //$this->db->where('lang', $lang);
          if($this->isMobile()){
            $where = "mu_id in (SELECT mu_id FROM LMS_MENU where mu_path NOT LIKE '%managecourse%' and mu_path NOT IN ('home','quiz/create_template','certificate/certificateall','quiz/create_template','questionnaire/create','learning_system','survey/list_survey','manage_courses'))";
            $this->db->where($where);
          }
          $query = $this->db->get();
          $fetch = $query->result_array();

          return $query->result_array();
        }
        public function get_namemenu($mu_path){
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;

          $this->load->model('Function_query_model', 'fn_query', FALSE);
          $this->fn_query->loadDB();
          $where_com="mu_path = '".$mu_path."' and mu_status = '1'";
          $fetch = $this->fn_query->query_row("LMS_MENU","","","",$where_com);
          if($lang=="thai"){
            return $fetch['mu_name_th'];
          }else if($lang=="english"){
            return $fetch['mu_name_en'];
          }
        }

        public function get_namemenu_sub($mu_path){
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang") ;

          $this->load->model('Function_query_model', 'fn_query', FALSE);
          $this->fn_query->loadDB();
          $where_com="mu_path = '".$mu_path."' and mu_status = '1'";
          $fetch = $this->fn_query->query_row("LMS_MENU","","","",$where_com);
          if($fetch['mu_parent']!="0"){
            $fetch = $this->fn_query->query_row("LMS_MENU","","","","mu_id=".$fetch['mu_parent']);
            if($lang=="thai"){
              return $fetch['mu_name_th'];
            }else if($lang=="english"){
              return $fetch['mu_name_en'];
            }
          }else{
            return "";
          }
        }

        public function checkmenu_sub($mu_id) {
          $this->db->from('LMS_MENU');
          $this->db->where('LMS_MENU.mu_status', '1');
          $this->db->where('LMS_MENU.mu_parent', $mu_id);
          $this->db->order_by('mu_num', 'ASC');
          //$this->db->where('lang', $lang);
          if($this->isMobile()){
            $where = "mu_id in (SELECT mu_id FROM LMS_MENU where mu_path NOT LIKE '%managecourse%' and mu_path NOT IN ('quiz/create_template','certificate/certificateall','quiz/create_template','questionnaire/create','learning_system','survey/list_survey','manage_courses'))";
            $this->db->where($where);
          }
          $query = $this->db->get();
          return $query->result_array();
        }

        public function checkposition($dep_id){
          $this->db->from('LMS_POSITION');
          $this->db->where('LMS_POSITION.posi_status', '1');
          $this->db->where('LMS_POSITION.posi_isDelete', '0');
          $this->db->where('LMS_POSITION.dep_id', $dep_id);
          //$this->db->where('lang', $lang);
          $query = $this->db->get();
          return $query->result_array();
        }
        public function checkusergroup($com_id){
          $this->db->from('LMS_COMPANY');
          $this->db->where('LMS_COMPANY.com_id', $com_id);
          $query = $this->db->get();
          $fetch = $query->row_array();
          $this->db->from('LMS_USP_GP');
          $this->db->where('LMS_USP_GP.ug_status', '1');
          $this->db->where('LMS_USP_GP.ug_isDelete', '0');
          $this->db->where('LMS_USP_GP.ug_for', $fetch['com_admin']);
          //$this->db->where('lang', $lang);
          $query = $this->db->get();
          return $query->result_array();
        }
        public function fetch_data_company() {
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "manage/companydata";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          $sess = $this->session->userdata("user");
          $where = '';
          if($sess['ug_viewdata']!="1"){
            $where = ' and com_id = "'.$sess['com_id'].'"';
          }
          $fetch = $this->func_query->query_result('LMS_COMPANY','','','','LMS_COMPANY.com_isDelete="0" and com_id != "1"'.$where,'com_id DESC');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $Score_criteria = '<button type="button" name="Score_criteria" id="'.$value['com_id'].'" title="'.label('Score_criteria').'" class="btn btn-success btn-xs Score_criteria"><i class="mdi mdi-percent"></i></button>';
            $banner = '<button type="button" name="bannerbtn" id="'.$value['com_id'].'" title="'.label('banner').'" class="btn btn-info btn-xs bannerbtn"><i class="mdi mdi-image-area"></i></button>';
            $update = '<button type="button" name="update" id="'.$value['com_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['com_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            $com_name = $value['com_name_th'];
            if($lang!="thai"){
              $com_name = $value['com_name_eng'];
            }
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            $output['2'] = "<center>".$value['com_code']."</center>";
            $output['3'] = $com_name;
            $output['4'] = "<center>".label($value['com_admin'])."</center>";
              if($lang=="thai"){
              $output['5'] = $value['com_modifieddate']!="0000-00-00 00:00:00"?date('d/m/',strtotime($value['com_modifieddate'])).(date('Y',strtotime($value['com_modifieddate']))+543)." ".date('H:i',strtotime($value['com_modifieddate'])):"<center>-</center>";
              }else{
              $output['5'] = $value['com_modifieddate']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['com_modifieddate'])):"<center>-</center>";
              }

            if($btn_update!="1"){
              $update = "";
            }
            if($btn_delete!="1"){
              $delete = "";
            }
            //$import.
            $output['0'] = "<center>".$Score_criteria.$banner.$update."</center>";
            $output['6'] = "<center>".$delete."</center>";
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }
        public function fetch_data_company_score($com_id,$isActive) {
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "manage/companydata";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          $sess = $this->session->userdata("user");
          $where = '';
          $where = ' and com_id = "'.$com_id.'"';
          $fetch = $this->func_query->query_result('LMS_COMPANY_SCORE','','','','LMS_COMPANY_SCORE.coms_isDelete="0"'.$where,'coms_calculate DESC');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $update = '<button type="button" name="update_score" id="'.$value['coms_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update_score"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete_score" id="'.$value['coms_id'].'" class="btn btn-danger btn-xs delete_score" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            $coms_amount = '';
            $coms_cond = '< ';
            if($value['coms_cond']=="2"){
              $coms_cond = '> ';
            }
            if($value['coms_type']=="1"){
              $coms_amount = $coms_cond.$value['coms_amount'].' '.label('month');
            }else{
              $coms_amount = $coms_cond.$value['coms_amount'].' '.label('year');
            }
            if($btn_update!="1"){
              $update = "";
            }
            $numcol = 0;
            if($isActive!="1"){
              //$import.
              $update = "-";
            }
            $output[$numcol] = "<center>".$update."</center>";$numcol++;
            $output[$numcol] = "<span style='float:right;'>".$num."</span>";$num++;$numcol++;
            $output[$numcol] = "<center>".$coms_amount."</center>";$numcol++;
            $output[$numcol] = "<center>".$value['coms_a_plus']."</center>";$numcol++;
            $output[$numcol] = "<center>".$value['coms_a']."</center>";$numcol++;
            $output[$numcol] = "<center>".$value['coms_b_plus']."</center>";$numcol++;
            $output[$numcol] = "<center>".$value['coms_b']."</center>";$numcol++;
            $output[$numcol] = "<center>".$value['coms_c_plus']."</center>";$numcol++;
            $output[$numcol] = "<center>".$value['coms_c']."</center>";$numcol++;
            $output[$numcol] = "<center>".$value['coms_d_plus']."</center>";$numcol++;
            $output[$numcol] = "<center>".$value['coms_d']."</center>";$numcol++;
            $output[$numcol] = $value['coms_status']=="1"?"<center>".label('open')."</center>":"<center>".label('close')."</center>";$numcol++;

            if($btn_delete!="1"){
              $delete = "";
            }
            if($isActive!="1"){
              $delete = "-";
            }
            $output[$numcol] = "<center>".$delete."</center>";
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }
        public function fetch_data_conmsg() {
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "setting/ManageECT";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');

          $fetch = $this->func_query->query_result('LMS_CONFIRMMSG','','','','LMS_CONFIRMMSG.conmsg_isDelete="0"','conmsg_id DESC');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $update = '<button type="button" name="update" id="'.$value['conmsg_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['conmsg_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            $output['2'] = $value['conmsg_title_eng'];
            $output['3'] = $value['conmsg_title_th'];

              if($value['conmsg_status']=="1"){
                $output['4'] = "<center>".label('open')."</center>";
              }else{
                $output['4'] = "<center>".label('close')."</center>";
              }
            $output['5'] = $value['conmsg_modifieddate']!=""?date('d/m/Y H:i',strtotime($value['conmsg_modifieddate'])):"<center>-</center>";

            if($btn_update!="1"){
              $update = "";
            }
            if($btn_delete!="1"){
              $delete = "";
            }
            $output['0'] = "<center>".$update."</center>";
            $output['6'] = "<center>".$delete."</center>";
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }
        public function fetch_data_division($com_id) {
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "infodata/division";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');

          $fetch = $this->func_query->query_result('LMS_DIVISION','','','','LMS_DIVISION.div_isDelete="0" and LMS_DIVISION.com_id = "'.$com_id.'"','div_id DESC');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $update = '<button type="button" name="update" id="'.$value['div_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['div_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            $output['2'] = $value['div_code'];
            $output['3'] = $lang=="thai"?$value['div_name_th']:$value['div_name_eng'];

              if($value['div_status']=="1"){
                $output['4'] = "<center>".label('open')."</center>";
              }else{
                $output['4'] = "<center>".label('close')."</center>";
              }
            $output['5'] = $value['div_modifieddate']!=""?date('d/m/Y H:i',strtotime($value['div_modifieddate'])):"<center>-</center>";

                $output['6'] = "<center>".$delete."</center>";
            if($btn_update!="1"){
              $update = "";
            }
            if($btn_delete!="1"){
              $delete = "";
            }
            $output['0'] = "<center>".$update."</center>";
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }
        public function fetch_data_position($com_id) {
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "infodata/position";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');

          $fetch = $this->func_query->query_result('LMS_POSITION','','','','LMS_POSITION.posi_isDelete="0" and LMS_POSITION.com_id = "'.$com_id.'"','posi_id DESC');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $update = '<button type="button" name="update" id="'.$value['posi_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['posi_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            $output['2'] = $value['posi_code'];
            $output['3'] = $lang=="thai"?$value['posi_name_th']:$value['posi_name_en'];

              if($value['posi_status']=="1"){
                $output['4'] = "<center>".label('open')."</center>";
              }else{
                $output['4'] = "<center>".label('close')."</center>";
              }
            $output['5'] = $value['posi_modifieddate']!=""?date('d/m/Y H:i',strtotime($value['posi_modifieddate'])):"<center>-</center>";

            if($btn_update!="1"){
              $update = "";
            }
            if($btn_delete!="1"){
              $delete = "";
            }
            $output['0'] = "<center>".$update."</center>";
            $output['6'] = "<center>".$delete."</center>";
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }
        public function fetch_data_level($com_id) {
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "infodata/level";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');

          $fetch = $this->func_query->query_result('LMS_LEVEL','','','','LMS_LEVEL.lv_isDelete="0" and LMS_LEVEL.com_id = "'.$com_id.'"','lv_id DESC');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $update = '<button type="button" name="update" id="'.$value['lv_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['lv_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            $output['2'] = $value['lv_code'];
            $output['3'] = $lang=="thai"?$value['lv_name_th']:$value['lv_name_en'];

              if($value['lv_status']=="1"){
                $output['4'] = "<center>".label('open')."</center>";
              }else{
                $output['4'] = "<center>".label('close')."</center>";
              }
            $output['5'] = $value['lv_modifieddate']!=""?date('d/m/Y H:i',strtotime($value['lv_modifieddate'])):"<center>-</center>";

            if($btn_update!="1"){
              $update = "";
            }
            if($btn_delete!="1"){
              $delete = "";
            }
            $output['0'] = "<center>".$update."</center>";
            $output['6'] = "<center>".$delete."</center>";
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }
        public function fetch_data_store($com_id) {
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "infodata/store";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');

          $fetch = $this->func_query->query_result('LMS_STORE','','','','LMS_STORE.st_isDelete="0" and LMS_STORE.com_id = "'.$com_id.'"','st_id DESC');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $update = '<button type="button" name="update" id="'.$value['st_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['st_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            $output['2'] = $value['st_code'];
            $output['3'] = $value['st_cus_code'];
            $output['4'] = $value['st_group'];
            $output['5'] = $lang=="thai"?$value['st_name_th']:$value['st_name_en'];

              if($value['st_status']=="1"){
                $output['6'] = "<center>".label('open')."</center>";
              }else{
                $output['6'] = "<center>".label('close')."</center>";
              }
            $output['7'] = $value['st_modifieddate']!=""?date('d/m/Y H:i',strtotime($value['st_modifieddate'])):"<center>-</center>";

            if($btn_update!="1"){
              $update = "";
            }
            if($btn_delete!="1"){
              $delete = "";
            }
            $output['0'] = "<center>".$update."</center>";
            $output['8'] = "<center>".$delete."</center>";
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }
        public function fetch_data_group($com_id) {
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "infodata/group";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');

          $fetch = $this->func_query->query_result('LMS_GROUP','LMS_DIVISION','LMS_DIVISION.div_id = LMS_GROUP.div_id','','LMS_GROUP.group_isDelete="0" and LMS_DIVISION.com_id = "'.$com_id.'"','group_id DESC');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $update = '<button type="button" name="update" id="'.$value['group_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['group_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            $output['2'] = $lang=="thai"?$value['div_name_th']:$value['div_name_eng'];
            $output['3'] = "<center>".$value['group_code']."</center>";
            $output['4'] = $lang=="thai"?$value['group_name_th']:$value['group_name_en'];

              if($value['group_status']=="1"){
                $output['5'] = "<center>".label('open')."</center>";
              }else{
                $output['5'] = "<center>".label('close')."</center>";
              }
            $output['6'] = $value['group_modifieddate']!=""?date('d/m/Y H:i',strtotime($value['group_modifieddate'])):"<center>-</center>";

            if($btn_update!="1"){
              $update = "";
            }
            if($btn_delete!="1"){
              $delete = "";
            }
            $output['0'] = "<center>".$update."</center>";
            $output['7'] = "<center>".$delete."</center>";
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }
        public function fetch_data_department($com_id) {
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "infodata/department";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');

          $sess = $this->session->userdata("user");
          $fetch = $this->func_query->query_result('LMS_DEPART','LMS_GROUP','LMS_GROUP.group_id = LMS_DEPART.group_id','','LMS_DEPART.dep_isDelete="0" and LMS_GROUP.div_id in (select LMS_DIVISION.div_id from LMS_DIVISION where LMS_DIVISION.com_id = "'.$com_id.'" and LMS_DIVISION.div_isDelete = "0") and LMS_GROUP.group_isDelete = "0"');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $update = '<button type="button" name="update" id="'.$value['dep_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['dep_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            $output['2'] = $lang=="thai"?$value['group_name_th']:$value['group_name_en'];
            $output['3'] = "<center>".$value['dep_code']."</center>";
            $output['4'] = $lang=="thai"?$value['dep_name_th']:$value['dep_name_en'];
            //if($lang=="thai"){ $output['4'] = $value['com_name_th']; }else{ $output['4'] = $value['com_name_eng']; }
              if($value['dep_status']=="1"){
                $output['5'] = "<center>".label('open')."</center>";
              }else{
                $output['5'] = "<center>".label('close')."</center>";
              }
              $output['6'] = $value['dep_modifieddate']!=""?date('d/m/Y H:i',strtotime($value['dep_modifieddate'])):"<center>-</center>";

            if($btn_update!="1"){
              $update = "";
            }
            if($btn_delete!="1"){
              $delete = "";
            }
            $output['0'] = "<center>".$update."</center>";
            $output['7'] = "<center>".$delete."</center>";
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }
        public function fetch_data_section($com_id) {
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "infodata/section";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');

          $sess = $this->session->userdata("user");
          $fetch = $this->func_query->query_result('LMS_SECTION','LMS_DEPART','LMS_SECTION.dep_id = LMS_DEPART.dep_id','','LMS_SECTION.section_isDelete="0" and LMS_DEPART.group_id in (select LMS_GROUP.group_id from LMS_GROUP inner join LMS_DIVISION on LMS_GROUP.div_id = LMS_DIVISION.div_id where LMS_DIVISION.com_id = "'.$com_id.'" and LMS_DIVISION.div_isDelete = "0" and LMS_GROUP.group_isDelete = "0") and LMS_DEPART.dep_isDelete = "0"');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $update = '<button type="button" name="update" id="'.$value['section_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['section_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            $output['2'] = $lang=="thai"?$value['dep_name_th']:$value['dep_name_en'];
            $output['3'] = "<center>".$value['section_code']."</center>";
            $output['4'] = $lang=="thai"?$value['section_name_th']:$value['section_name_en'];
            //if($lang=="thai"){ $output['4'] = $value['com_name_th']; }else{ $output['4'] = $value['com_name_eng']; }
              if($value['section_status']=="1"){
                $output['5'] = "<center>".label('open')."</center>";
              }else{
                $output['5'] = "<center>".label('close')."</center>";
              }
              $output['6'] = $value['section_modifieddate']!=""?date('d/m/Y H:i',strtotime($value['section_modifieddate'])):"<center>-</center>";

            if($btn_update!="1"){
              $update = "";
            }
            if($btn_delete!="1"){
              $delete = "";
            }
            $output['0'] = "<center>".$update."</center>";
            $output['7'] = "<center>".$delete."</center>";
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }
        public function fetch_data_area($com_id) {
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "infodata/area";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');

          $sess = $this->session->userdata("user");
          $fetch = $this->func_query->query_result('LMS_AREA','LMS_SECTION','LMS_SECTION.section_id = LMS_AREA.section_id','','LMS_SECTION.section_isDelete="0" and LMS_SECTION.dep_id in (select LMS_DEPART.dep_id from LMS_DEPART inner join LMS_GROUP on LMS_GROUP.group_id = LMS_DEPART.group_id inner join LMS_DIVISION on LMS_GROUP.div_id = LMS_DIVISION.div_id where LMS_DIVISION.com_id = "'.$com_id.'" and LMS_DIVISION.div_isDelete = "0" and LMS_GROUP.group_isDelete = "0") and LMS_AREA.salearea_isDelete = "0"');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $update = '<button type="button" name="update" id="'.$value['salearea_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['salearea_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            $output['2'] = $lang=="thai"?$value['section_name_th']:$value['section_name_en'];
            $output['3'] = "<center>".$value['salearea_code']."</center>";
            $output['4'] = $lang=="thai"?$value['salearea_name_th']:$value['salearea_name_en'];
            //if($lang=="thai"){ $output['4'] = $value['com_name_th']; }else{ $output['4'] = $value['com_name_eng']; }
              if($value['salearea_status']=="1"){
                $output['5'] = "<center>".label('open')."</center>";
              }else{
                $output['5'] = "<center>".label('close')."</center>";
              }
              $output['6'] = $value['salearea_modifieddate']!=""?date('d/m/Y H:i',strtotime($value['salearea_modifieddate'])):"<center>-</center>";

            if($btn_update!="1"){
              $update = "";
            }
            if($btn_delete!="1"){
              $delete = "";
            }
            $output['0'] = "<center>".$update."</center>";
            $output['7'] = "<center>".$delete."</center>";
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }
        public function fetch_data_groupuser() {
          $sess = $this->session->userdata("user");
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->manage->loadDB();
          $page = "manage/groupuserdata";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          $this->db->from('LMS_USP_GP');
          $this->db->where('LMS_USP_GP.ug_isDelete', '0');
          if($sess['com_admin']=="com_associated"){
              $this->db->where('LMS_USP_GP.ug_for', 'com_associated');
          }
          $query = $this->db->get();
          $fetch = $query->result_array();
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $license = '<button type="button" name="license" id="'.$value['ug_id'].'" title="'.label('m_permission_ug').'" class="btn btn-info btn-xs license"><i class="mdi mdi-account-key"></i></button>';
            $update = '<button type="button" name="update" id="'.$value['ug_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['ug_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            $output['2'] = $value['ug_name_th'];
            $output['3'] = $value['ug_name_en'];
            if($btn_update!="1"){
              $update = "";
            }
            if($btn_delete!="1"){
              $delete = "";
            }
            if($sess['u_id']!="1"){
              $delete = "";
            }
            if($sess['ug_for']=="com_central"){
              $output['4'] = "<center>".label($value['ug_for'])."</center>";

              if($lang=="thai"){
              $output['5'] = $value['ug_modifieddate']!="0000-00-00 00:00:00"?date('d/m/',strtotime($value['ug_modifieddate'])).(date('Y',strtotime($value['ug_modifieddate']))+543)." ".date('H:i',strtotime($value['ug_modifieddate'])):"<center>-</center>";
              }else{
              $output['5'] = $value['ug_modifieddate']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['ug_modifieddate'])):"<center>-</center>";
              }
              $output['0'] = "<center>".$license.$update."</center>";
              $output['6'] = "<center>".$delete."</center>";
            }else{
              if($lang=="thai"){
              $output['4'] = $value['ug_modifieddate']!="0000-00-00 00:00:00"?date('d/m/',strtotime($value['ug_modifieddate'])).(date('Y',strtotime($value['ug_modifieddate']))+543)." ".date('H:i',strtotime($value['ug_modifieddate'])):"<center>-</center>";
              }else{
              $output['4'] = $value['ug_modifieddate']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['ug_modifieddate'])):"<center>-</center>";
              }
              $output['0'] = "<center>".$license.$update."</center>";
              $output['5'] = "<center>".$delete."</center>";
            }
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_data_user($com_id) {
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $sess = $this->session->userdata("user");
          $this->manage->loadDB();
          $page = "manage/userdata";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          $this->db->from('LMS_USP');
          $this->db->join('LMS_EMP','LMS_USP.emp_id = LMS_EMP.emp_id');
          //$this->db->join('LMS_DEPART','LMS_USP.dep_id = LMS_DEPART.dep_id','RIGHT');
          $this->db->join('LMS_COMPANY','LMS_EMP.com_id = LMS_COMPANY.com_id');
          $this->db->join('LMS_USP_GP','LMS_USP.ug_id = LMS_USP_GP.ug_id');
          //$this->db->join('LMS_POSITION','LMS_USP.posi_id = LMS_POSITION.posi_id','RIGHT');
          $this->db->where('LMS_EMP.emp_isDelete', '0');
          $user = $this->session->userdata('user');
          if($user['u_id']!="1"){
          $this->db->where('LMS_USP.u_id!=', '1');
          }else{
          $this->db->where('LMS_USP.useri!=', 'admin_toa');
          }

          $this->db->where('LMS_COMPANY.com_id', $com_id);
          $query = $this->db->get();
          $fetch = $query->result_array();
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $license = '<button type="button" name="license" id="'.$value['u_id'].'" title="'.label('m_permission').'" class="btn btn-info btn-xs license"><i class="mdi mdi-account-key"></i></button>';
            $update = '<button type="button" name="update" id="'.$value['u_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['emp_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            $output['2'] = $value['useri'];
            if($lang=="thai"){
              $output['3'] = $value['fullname_th'];
              $output['4'] = "<center>".$value['ug_name_th']."</center>";
              $output['5'] = "<center>".$value['com_code']."</center>";
            }else{
              $output['3'] = $value['fullname_en'];
              $output['4'] = "<center>".$value['ug_name_en']."</center>";
              $output['5'] = "<center>".$value['com_code']."</center>";
            }
            if($btn_update!="1"){
              $update = "";
            }
            if($btn_delete!="1"){
              $delete = "";
            }
            if($user['ug_id']!="1"){
              $license = "";
            }
            if($sess['ug_id']>1){
              if($value['ug_id']==1){
                $update = "";
                $delete = "";
                $license = "";
              }
            }
            $output['0'] = "<center>".$update.$delete."</center>";
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_data_qrcode($com_id="") {
          $sess = $this->session->userdata("user");
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "qrcode/create";

          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          $where = "";
          $where = ' and LMS_QRCODE.com_id ="'.$com_id.'"';
          $fetch = $this->func_query->query_result('LMS_QRCODE','LMS_COMPANY','LMS_QRCODE.com_id = LMS_COMPANY.com_id','left','qr_isDelete="0"'.$where,'qr_id  DESC');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $update = '<button type="button" name="update" id="'.$value['qr_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['qr_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $downloadqr = '<a title="'.label('qr_download').'" class="btn btn-info btn-xs" href="'.REAL_PATH.'/uploads/qrcode_file/'.$value['qr_id'].'.png" download><i class="mdi mdi-download"></i></a>';
            $output = array();
            if($btn_update!="1"){
              $update = "";
            }
            if($btn_delete!="1"){
              $delete = "";
            }
            $qr_type = "";
            if($value['qr_type']=="1"){
            $qr_type = label('qr_typefile_a');
            }else if($value['qr_type']=="2"){
            $qr_type = label('qr_typefile_b');
            }else if($value['qr_type']=="3"){
            $qr_type = label('qr_typefile_c');
            }else{
            $qr_type = label('qr_typefile_d');
            }
            /*if($btn_delete=="1"||$btn_update=="1"){*/
              $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
              $output['2'] = $value['com_code'];
              $output['3'] = $qr_type;
              $output['4'] = $value['qr_name'];
              $output['5'] = '<a target="_blank" href="'.base_url().'qrcode/view/'.$value['qr_id'].'">'.base_url().'qrcode/view/'.$value['qr_id'].'</a>';
              $output['0'] = "<center>".$downloadqr.$update.$delete."</center>";

              if($value['qr_status']=="1"){
                $output['6'] = "<center>".label('open')."</center>";
              }else{
                $output['6'] = "<center>".label('close')."</center>";
              }
            /*}else{
              $output['0'] = "<span style='float:right;'>".$num."</span>";$num++;
              $output['1'] = $qr_type;
              $output['2'] = $value['qr_name'];
              $output['3'] = '<a target="_blank" href="'.REAL_PATH.'/qrcode/'.$value['qr_id'].'">'.REAL_PATH.'/qrcode/'.$value['qr_id'].'</a>';

              if($value['qr_status']=="1"){
                $output['4'] = "<center>".label('open')."</center>";
              }else{
                $output['4'] = "<center>".label('close')."</center>";
              }
            }*/
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_data_position_detail($dep_id) {
          $sess = $this->session->userdata("user");
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->manage->loadDB();
          $page = "manage/departmentdata";

          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');

          $this->db->from('LMS_POSITION');
          $this->db->where('LMS_POSITION.dep_id', $dep_id);
          $this->db->where('LMS_POSITION.posi_isDelete', '0');
          $query = $this->db->get();
          $fetch = $query->result_array();
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $update = '<button type="button" name="update_detail" id="'.$value['posi_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update_detail"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete_detail" id="'.$value['posi_id'].'" class="btn btn-danger btn-xs delete_detail" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            if($btn_update!="1"){
              $update = "";
            }
            if($btn_delete!="1"){
              $delete = "";
            }
            if($btn_delete=="1"||$btn_update=="1"){
              $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
              $output['2'] = $value['posi_name_en'];
              $output['3'] = $value['posi_name_th'];
              $output['4'] = $value['posi_remark'];
              $output['0'] = "<center>".$update.$delete."</center>";
            }else{
              $output['0'] = "<span style='float:right;'>".$num."</span>";$num++;
              $output['1'] = $value['posi_name_en'];
              $output['2'] = $value['posi_name_th'];
              $output['3'] = $value['posi_remark'];
            }
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }


        public function create_position($data)
        {
          date_default_timezone_set("Asia/Bangkok");

          $this->db->from('LMS_POSITION');
          $this->db->where('com_id', $data['com_id']);
          $this->db->where('posi_code', $data['posi_code']);
          $this->db->where('posi_name_th', $data['posi_name_th']);
          $this->db->where('posi_name_en', $data['posi_name_en']);
          $this->db->where('posi_group', $data['posi_group']);
          $this->db->where('posi_isDelete', '0');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_POSITION', $data);
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

        public function create_division($data)
        {
          date_default_timezone_set("Asia/Bangkok");

          $this->db->from('LMS_DIVISION');
          $this->db->where('com_id', $data['com_id']);
          $this->db->where('div_code', $data['div_code']);
          $this->db->where('div_name_en', $data['div_name_en']);
          $this->db->where('div_name_th', $data['div_name_th']);
          $this->db->where('div_isDelete', '0');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_DIVISION', $data);
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

        public function create_level($data)
        {
          date_default_timezone_set("Asia/Bangkok");

          $this->db->from('LMS_LEVEL');
          $this->db->where('com_id', $data['com_id']);
          $this->db->where('lv_code', $data['lv_code']);
          $this->db->where('lv_name_en', $data['lv_name_en']);
          $this->db->where('lv_name_th', $data['lv_name_th']);
          $this->db->where('lv_isDelete', '0');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_LEVEL', $data);
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

        public function create_store($data)
        {
          date_default_timezone_set("Asia/Bangkok");

          $this->db->from('LMS_STORE');
          $this->db->where('com_id', $data['com_id']);
          $this->db->where('st_code', $data['st_code']);
          $this->db->where('st_group', $data['st_group']);
          $this->db->where('st_name_en', $data['st_name_en']);
          $this->db->where('st_name_th', $data['st_name_th']);
          $this->db->where('st_isDelete', '0');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_STORE', $data);
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

        public function create_group($data)
        {
          date_default_timezone_set("Asia/Bangkok");

          $this->db->from('LMS_GROUP');
          $this->db->where('div_id', $data['div_id']);
          $this->db->where('group_code', $data['group_code']);
          $this->db->where('group_name_th', $data['group_name_th']);
          $this->db->where('group_name_en', $data['group_name_en']);
          $this->db->where('group_isDelete', '0');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_GROUP', $data);
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

        public function create_conmsg($data)
        {
          date_default_timezone_set("Asia/Bangkok");

          $this->db->from('LMS_CONFIRMMSG');
          $this->db->where('conmsg_title_th', $data['conmsg_title_th']);
          $this->db->where('conmsg_title_eng', $data['conmsg_title_eng']);
          $this->db->where('conmsg_isDelete', '0');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_CONFIRMMSG', $data);
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

        public function create_qrcode_detail($data)
        {
          date_default_timezone_set("Asia/Bangkok");

          $this->db->from('LMS_QRCODE');
          $this->db->where('qr_name', $data['qr_name']);
          $this->db->where('com_id', $data['com_id']);
          $this->db->where('qr_isDelete', '0');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_QRCODE', $data);
            $id = $this->db->insert_id();
            if($id!=""){

              include ROOT_DIR."assets/plugins/phpqrcode/qrlib.php"; 
              $errorCorrectionLevel = 'L';
              $matrixPointSize = 6;
              $filename = ROOT_DIR."uploads/qrcode_file/".$id.".png";
              QRcode::png(base_url().'qrcode/view/'.$id, $filename, $errorCorrectionLevel, $matrixPointSize, 2);  
              return "2";
            }else{
              return "3";
            }
          }else{
            return "1";
          }
        }

        public function update_position_detail($data,$id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('posi_id', $id);
          $this->db->update('LMS_POSITION', $data);
          return "2";
        }

        public function update_conmsg($data,$conmsg_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('conmsg_id', $conmsg_id);
          $this->db->update('LMS_CONFIRMMSG', $data);
          return "2";
        }

        public function update_web($data,$web_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('web_id', $web_id);
          $this->db->update('LMS_WEB', $data);
          return "2";
        }

        public function update_qrcode_detail($data,$id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('qr_id', $id);
          $this->db->update('LMS_QRCODE', $data);
              include ROOT_DIR."assets/plugins/phpqrcode/qrlib.php"; 
              $errorCorrectionLevel = 'L';
              $matrixPointSize = 6;
              $filename = ROOT_DIR."uploads/qrcode_file/".$id.".png";
              QRcode::png(base_url().'qrcode/view/'.$id, $filename, $errorCorrectionLevel, $matrixPointSize, 2);  
          return "2";
        }

        
        public function checkUser($useri) {
          $this->db->where('LMS_USP.useri', $useri);
          $this->db->join('LMS_EMP','LMS_EMP.emp_id = LMS_USP.emp_id');
          $query = $this->db->get('LMS_USP');
          $row = $query->row_array();

          $user = $this->session->userdata("user");
          if(empty($row)) {
            return 'EMPTY';
          }else{
            if(in_array($user['ug_id'], array('2','6'))){
              if($user['com_id']==$row['com_id']){
                return 'FALSE';
              }else{
                return 'TRUE';
              }
            }else if($user['ug_id']=="1"){
              return 'FALSE';
            }else{
              return 'TRUE';
            }
          }
        }

        public function chk_grade($grade){
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata("user");
          $this->db->from('LMS_COS_ENROLL');
          $this->db->where('emp_id',$user['emp_id']);
          $this->db->where('cosen_grade',$grade);
          $query = $this->db->get();
          $num = $query->num_rows();
          return $num;
        }

        public function chk_scoretotal(){
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata("user");
          $this->db->from('LMS_COS_ENROLL');
          $this->db->where('emp_id',$user['emp_id']);
          $this->db->where_not_in('cosen_score','');
          $query = $this->db->get();
          $fetch = $query->result_array();
          $score = 0;
          foreach ($fetch as $key => $value) {
            $score += floatval($value['cosen_score']);
          }
          $scoretotal = 0;
          if($score>0){
            $scoretotal = ($score*100)/(count($fetch)*100);
          }
          return $scoretotal;
        }

        public function query_course_registered(){
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata("user");
          $this->db->from('LMS_COS_ENROLL');
          $this->db->join('LMS_COS','LMS_COS_ENROLL.cos_id=LMS_COS.cos_id');
          $this->db->where('LMS_COS_ENROLL.emp_id',$user['emp_id']);
          //$this->db->where('cosen_status','2');
          $query_ens = $this->db->get();
          $num_ens = $query_ens->num_rows();
          $fetch = $query_ens->result_array();
          return $fetch;
        }

        public function chk_course_registered(){
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata("user");

          $this->db->from('LMS_COS_DETAIL');
          $this->db->join('LMS_COS_DETAIL_UG','LMS_COS_DETAIL.cosde_id=LMS_COS_DETAIL_UG.cosde_id');
          $this->db->where('LMS_COS_DETAIL_UG.posi_id',$user['posi_id']);
          $query = $this->db->get();
          $num = $query->num_rows();


          $this->db->from('LMS_COS_ENROLL');
          $this->db->where('LMS_COS_ENROLL.emp_id',$user['emp_id']);
          $this->db->where('cosen_status','2');
          $query_ens = $this->db->get();
          $num_ens = $query_ens->num_rows();
          return $num-$num_ens;
        }

        public function chk_course_not_register(){

          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata("user");

          $this->db->from('LMS_COS_DETAIL');
          $this->db->join('LMS_COS_DETAIL_UG','LMS_COS_DETAIL.cosde_id=LMS_COS_DETAIL_UG.cosde_id');
          $this->db->where('LMS_COS_DETAIL_UG.posi_id',$user['posi_id']);
          $query_registered = $this->db->get();
          $num_registered = $query_registered->num_rows();

          $this->db->from('LMS_COS_ENROLL');
          $this->db->where('LMS_COS_ENROLL.emp_id',$user['emp_id']);
          $query = $this->db->get();
          $num = $query->num_rows();
          return intval($num_registered)-intval($num);
        }

        public function chk_course_status($status){
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata("user");
          $this->db->from('LMS_COS_ENROLL');
          $this->db->where('LMS_COS_ENROLL.emp_id',$user['emp_id']);
          if($status=="2"){
            $this->db->where('LMS_COS_ENROLL.cosen_status!=','2');
            $this->db->where('LMS_COS_ENROLL.cosen_status_sub!=','1');
          }else{
            $this->db->where('LMS_COS_ENROLL.cosen_firsttime!=','0000-00-00 00:00:00');
            $this->db->where('LMS_COS_ENROLL.cosen_finishtime!=','0000-00-00 00:00:00');
            $this->db->where('LMS_COS_ENROLL.cosen_status',$status);
          }
          $query = $this->db->get();
          $num = $query->num_rows();
          return $num;
        }

        public function chk_total_status($status){
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata("user");
          if($status=="1"){
            $this->db->from('LMS_COS');
            $this->db->where('LMS_COS.cos_status','1');
            if($user['com_admin']=="com_associated"){
              $this->db->where('LMS_COS.com_id',$user['com_id']);
            }
          }else{
            $this->db->from('LMS_USP');
            $this->db->join('LMS_USP_GP','LMS_USP.ug_id = LMS_USP_GP.ug_id');
            $this->db->where('LMS_USP.login','1');
            $this->db->where('LMS_USP_GP.Is_admin','0');
            $this->db->where('LMS_USP.dummy_status','0');
          }
          $query = $this->db->get();
          $num = $query->num_rows();
          return $num;
        }

}
