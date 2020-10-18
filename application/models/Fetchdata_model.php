<?php
class Fetchdata_model extends CI_Model {

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

        public function checknumber($number){ 
            if($number % 2 == 0){ 
                return "Even";  
            } 
            else{ 
                return "Odd"; 
            } 
        } 


        public function fetch_course_qiz_criteriascore($qiz_id) {
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "managecourse/courses_all";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');
          /*$com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";*/
          $where = 'LMS_QIZ_LEVEL.qiz_id="'.$qiz_id.'" and LMS_QIZ_LEVEL.qizlv_isDelete="0"';
          /*if($user['ug_approve']!="1"){
            $where .= ' and cg_approve="1"';
          }*/
          $num_approve = 0;
          $fetch = $this->func_query->query_result('LMS_QIZ_LEVEL','LMS_LEVEL','LMS_LEVEL.lv_id = LMS_QIZ_LEVEL.lv_id','',$where,'qizlv_id DESC');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $update = '<button type="button" name="update_criteriascore" id="'.$value['qizlv_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update_criteriascore"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete_criteriascore" id="'.$value['qizlv_id'].'" class="btn btn-danger btn-xs delete_criteriascore" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();

           // $output['5'] = $value['u_date']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['u_date'])):"<center>-</center>";
            
            if($btn_update!="1"){
                $update = "";
            }
            if($btn_delete!="1"){
                $delete = "";
            }
            $numloop = 1;
            $lv_name = $lang=="thai"?$value['lv_name_th']:$value['lv_name_en'];
            $output['0'] = "<center>".$update."</center>";
            $output[$numloop] = "<span style='float:right;'>".$num."</span>";$num++;$numloop++;
            /*$output[$numloop] = "<center>".$value['cgcode']."</center>";$numloop++;*/
            $output[$numloop] = $lv_name;$numloop++;
            $output[$numloop] = number_format($value['qizlv_goalscore']);$numloop++;

            if($lang=="thai"){
              $output[$numloop] = $value['qizlv_modifieddate']!="0000-00-00 00:00:00"?date('d/m/',strtotime($value['qizlv_modifieddate'])).(date('Y',strtotime($value['qizlv_modifieddate']))+543)." ".date('H:i',strtotime($value['qizlv_modifieddate'])):"<center>-</center>";$numloop++;
            }else{
              $output[$numloop] = $value['qizlv_modifieddate']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['qizlv_modifieddate'])):"<center>-</center>";$numloop++;
            }
            $output[$numloop] = "<center>".$delete."</center>";$numloop++;
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_data_workgroup($com_id) {
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "managecourse/workgroup";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');
          /*$com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";*/
          $where = 'LMS_WKG.com_id="'.$com_id.'" and LMS_WKG.wg_isDelete="0" and LMS_COMPANY.com_isDelete="0" and LMS_COMPANY.com_status="1"';
          /*if($user['ug_approve']!="1"){
            $where .= ' and cg_approve="1"';
          }*/
          $num_approve = 0;
          $fetch = $this->func_query->query_result('LMS_WKG','LMS_COMPANY','LMS_COMPANY.com_id = LMS_WKG.com_id','',$where,'wg_createdate DESC');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $approve = '<button type="button" title="'.label('d_waitapprove').'" id="'.$value['wg_id'].'" class="btn btn-secondary btn-xs active approve"><i class="mdi mdi-alert text-warning"></i></button>';
            $update = '<button type="button" name="update" id="'.$value['wg_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['wg_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();

           // $output['5'] = $value['u_date']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['u_date'])):"<center>-</center>";
            
            if($btn_update!="1"){
                $update = "";
            }
            if($btn_delete!="1"){
                $delete = "";
            }
            $numloop = 1;
            $num_chk = 0;
            if($update==""){
              $num_chk++;
            }
            if($delete==""){
              $num_chk++;
            }
            if($approve==""){
              $num_chk++;
            }
            if($num_chk<3){
              $button_val = "<center>".$update."</center>";
            }else{
              $button_val = "<center>-</center>";
            }
            $output['0'] = $button_val;
           // $output[$numloop] = "<span style='float:right;'>".$num."</span>";$num++;$numloop++;
            /*$output[$numloop] = "<center>".$value['cgcode']."</center>";$numloop++;*/
            $output[$numloop] = $value['wcode'];$numloop++;
            $output[$numloop] = $value['wtitle_th'];$numloop++;
            $output[$numloop] = $value['wtitle_en'];$numloop++;
            /*if($approve_status != label('d_rejected')){*/
            if($value['wg_status']=="1"){ $output[$numloop] = "<center>".label('open')."</center>"; }else{ $output[$numloop] = "<center>".label('close')."</center>"; }$numloop++;
            $output[$numloop] = $delete;$numloop++;
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_data_coursegroup() {
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "managecourse/course_groups";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');
          $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
          $where = 'LMS_COG.com_id="'.$com_id.'" and LMS_COG.cg_isDelete="0"';
          $fetch = $this->func_query->query_result('LMS_COG','','','',$where,'cg_id DESC');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $approve = '<button type="button" title="'.label('d_waitapprove').'" id="'.$value['cg_id'].'" class="btn btn-secondary btn-xs active approve"><i class="mdi mdi-alert text-warning"></i></button>';
            $update = '<button type="button" name="update" id="'.$value['cg_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['cg_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();

           // $output['5'] = $value['u_date']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['u_date'])):"<center>-</center>";
            if($btn_update!="1"){
                $update = "";
            }
            if($btn_delete!="1"){
                $delete = "";
            }
            $numloop = 1;
            $num_chk = 0;
            if($update==""){
              $num_chk++;
            }
            if($delete==""){
              $num_chk++;
            }
            if($approve==""){
              $num_chk++;
            }
            if($num_chk<3){
              $button_val = "<center>".$update."</center>";
            }else{
              $button_val = "<center>-</center>";
            }
            $output['0'] = $button_val;
            $output[$numloop] = $value['cgcode'];$numloop++;
            $output[$numloop] = $value['cgtitle_th'];$numloop++;
            $output[$numloop] = $value['cgtitle_en'];$numloop++;
            if($value['cg_status']=="1"){ $output[$numloop] = "<center>".label('open')."</center>"; }else{ $output[$numloop] = "<center>".label('close')."</center>"; }$numloop++;
            $output[$numloop] = $delete;$numloop++;

            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_data_courseongoing($com_id,$type) {
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $this->manage->loadDB();
          $page = "dashboard";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          date_default_timezone_set("Asia/Bangkok");
          $sess = $this->session->userdata('user');
          $date_now = date('Y-m-d H:i');
          /*if($type=="1"){
            $fetch = $this->func_query->query_result('LMS_COS','LMS_COS_DETAIL','LMS_COS_DETAIL.cos_id = LMS_COS.cos_id','LEFT','LMS_COS.com_id="'.$com_id.'" and LMS_COS.cos_public="1" and LMS_COS.cos_isDelete="0" and LMS_COS_DETAIL.cosde_isDelete="0" and ((LMS_COS_DETAIL.date_start="0000-00-00 00:00:00" and LMS_COS_DETAIL.date_end="0000-00-00 00:00:00") or ( LMS_COS_DETAIL.date_end >= "'.$date_now.'"))','LMS_COS.cos_id DESC','','','','LMS_COS.cos_id');
          }else{*/
            $fetch = $this->func_query->query_result('LMS_COS','','','','LMS_COS.cos_public="1" and LMS_COS.cos_status="1" and LMS_COS.cos_isDelete="0"','LMS_COS.cos_id DESC','','','','LMS_COS.cos_id');

            if(count($fetch)>0){
              foreach ($fetch as $key_list => $value_list) {
                $value_chk = 1;
                $fetch[$key_list]['date_start'] = "0000-00-00 00:00:00";
                $fetch[$key_list]['date_end'] = "0000-00-00 00:00:00";
                $fetch_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id="'.$value_list['cos_id'].'" and LMS_COS_DETAIL.cosde_isDelete="0"');
                if(count($fetch_detail)>0){
                  if(($fetch_detail['date_start']!="0000-00-00 00:00:00"&&$fetch_detail['date_end']!="0000-00-00 00:00:00")&&(date('Y-m-d H:i',strtotime($fetch_detail['date_start']))>date('Y-m-d H:i')||date('Y-m-d H:i',strtotime($fetch_detail['date_end']))<date('Y-m-d H:i'))){
                    $value_chk = 0;
                  }else{
                    $fetch[$key_list]['date_start'] = $fetch_detail['date_start'];
                    $fetch[$key_list]['date_end'] = $fetch_detail['date_end'];
                  }
                }
                if($value_chk==1){
                  $fetch_status = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$value_list['cos_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_isDelete="0"');
                  if(count($fetch_status)==0){
                    $fetch_chk_ug = $this->func_query->query_result('LMS_COS_DETAIL','LMS_COS_DETAIL_UG','LMS_COS_DETAIL.cosde_id = LMS_COS_DETAIL_UG.cosde_id','','LMS_COS_DETAIL_UG.posi_id = "'.$sess['posi_id'].'" and LMS_COS_DETAIL.cos_id = "'.$value_list['cos_id'].'"');
                    if(count($fetch_chk_ug)==0){
                      unset($fetch[$key_list]);
                    }
                  }else{
                    if($fetch_status['cosen_status']=="1" && $fetch_status['cosen_status_sub']=="1"){
                      unset($fetch[$key_list]);
                    }
                  }
                  if(isset($fetch[$key_list])){
                              $result_chkcg = $this->func_query->numrows('LMS_COSINCG','LMS_COG','LMS_COSINCG.cg_id = LMS_COG.cg_id','','LMS_COSINCG.course_id="'.$value_list['cos_id'].'" and LMS_COG.cg_status="1" and LMS_COG.cg_approve="1" and LMS_COG.cg_isDelete="0"');
                              if($result_chkcg==0){
                                unset($fetch[$key_list]);
                              }
                  }
                }else{
                  unset($fetch[$key_list]);
                }
              }
            }
         // }
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $cos_lang = explode(',', $value['cos_lang']);
            $value['isTH'] = in_array('th',$cos_lang)?"1":"0";
            $value['isENG'] = in_array('eng',$cos_lang)?"1":"0";
            $cname = "";
            if($lang=="thai"){
                if($value['isTH']=="1"){
                  $cname = $value['cname_th'];
                }else{
                  if($value['cname_th']==""){
                    $cname = $value['cname_eng'];
                  }
                }
            }else if($lang=="english"){
                if($value['isENG']=="1"){
                  $cname = $value['cname_eng'];
                }else{
                  if($value['cname_eng']==""){
                    $cname = $value['cname_th'];
                  }
                }
            }
            $detail = '<button type="button" name="detail_cos" id="'.$value['cos_id'].'" title="'.label('go_to_course').'" class="btn mdi-btn waves-effect waves-light btn-warning detail_cos"><span class="icon is-medium"><i class="mdi mdi-24px mdi-share mdi-light"></i></span></button>';
            $fetch_chkenroll = $this->func_query->numrows('LMS_COS_ENROLL','','','','cos_id="'.$value['cos_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_isDelete="0"');
            if($fetch_chkenroll==0){
            $detail = '<button type="button" name="btn_register" id="'.$value['cos_id'].'" title="'.label('lrn_btn_register').'" class="btn mdi-btn waves-effect waves-light btn-danger btn_register"><span class="icon is-medium"><i class="mdi mdi-24px mdi-file-document-box mdi-light"></i></span></button>';
            }
            if($lang=="thai"){
              //$value['date_end']!="0000-00-00 00:00:00"?date('d',strtotime($value['date_end']))." ".$thaimonth[intval(date('m',strtotime($value['date_end'])))]." ".(date('Y',strtotime($value['date_end']))+543)." ".date('H:i',strtotime($value['date_end'])):label('UnlimitedTime');
              //$value['date_end']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($value['date_end'])) 
              $date_end = $value['date_end']!="0000-00-00 00:00:00"?date('d/m',strtotime($value['date_end']))."/".(date('Y',strtotime($value['date_end']))+543)." ".date('H:i',strtotime($value['date_end'])):label('UnlimitedTime');
            }else{
              $date_end = $value['date_end']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['date_end'])):label('UnlimitedTime');
            }
            $output = array();
            $output['0'] = $cname;
            $output['1'] = $date_end;
            $output['2'] = "<center>".$detail."</center>";
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_data_courseincoming($com_id,$type) {
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $this->manage->loadDB();
          $page = "dashboard";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          date_default_timezone_set("Asia/Bangkok");
          $sess = $this->session->userdata('user');
          $date_now = date('Y-m-d H:i');
          if($type=="1"){
          $fetch = $this->func_query->query_result('LMS_COS','LMS_COS_DETAIL','LMS_COS_DETAIL.cos_id = LMS_COS.cos_id','','LMS_COS.com_id="'.$com_id.'" and LMS_COS.cos_public="1" and LMS_COS.cos_isDelete="0" and LMS_COS.cos_status="1" and LMS_COS_DETAIL.cosde_isDelete="0" and LMS_COS_DETAIL.date_start > "'.$date_now.'"');
          }else{
            $fetch = $this->func_query->query_result('LMS_COS','LMS_COS_DETAIL','LMS_COS_DETAIL.cos_id = LMS_COS.cos_id','','LMS_COS.com_id="'.$com_id.'" and LMS_COS.cos_public="1" and LMS_COS.cos_isDelete="0" and LMS_COS.cos_status="1" and LMS_COS_DETAIL.cosde_isDelete="0" and LMS_COS_DETAIL.date_start > "'.$date_now.'"');

            if(count($fetch)>0){
              foreach ($fetch as $key_list => $value_list) {
                $fetch_status = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$value_list['cos_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_isDelete="0"');
                if(count($fetch_status)==0){
                  $fetch_chk_ug = $this->func_query->query_result('LMS_COS_DETAIL','LMS_COS_DETAIL_UG','LMS_COS_DETAIL.cosde_id = LMS_COS_DETAIL_UG.cosde_id','','LMS_COS_DETAIL_UG.posi_id = "'.$sess['posi_id'].'" and LMS_COS_DETAIL.cos_id = "'.$value_list['cos_id'].'"');
                  if(count($fetch_chk_ug)==0){
                    unset($fetch[$key_list]);
                  }
                }
              }
            }
          }

            if(count($fetch)>0){
              foreach ($fetch as $key_list => $value_list) {
                  if(isset($fetch[$key_list])){
                              $result_chkcg = $this->func_query->numrows('LMS_COSINCG','LMS_COG','LMS_COSINCG.cg_id = LMS_COG.cg_id','','LMS_COSINCG.course_id="'.$value_list['cos_id'].'" and LMS_COG.cg_status="1" and LMS_COG.cg_approve="1" and LMS_COG.cg_isDelete="0"');
                              if($result_chkcg==0){
                                unset($fetch[$key_list]);
                              }
                  }
              }
            }
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $cos_lang = explode(',', $value['cos_lang']);
            $value['isTH'] = in_array('th',$cos_lang)?"1":"0";
            $value['isENG'] = in_array('eng',$cos_lang)?"1":"0";
            $cname = "";
            if($lang=="thai"){
                if($value['isTH']=="1"){
                  $cname = $value['cname_th'];
                }else{
                  if($value['cname_th']==""){
                    $cname = $value['cname_eng'];
                  }
                }
            }else if($lang=="english"){
                if($value['isENG']=="1"){
                  $cname = $value['cname_eng'];
                }else{
                  if($value['cname_eng']==""){
                    $cname = $value['cname_th'];
                  }
                }
            }
            if($lang=="thai"){
              /*$date_start = $value['date_start']!="0000-00-00 00:00:00"?date('d',strtotime($value['date_start']))." ".$thaimonth[intval(date('m',strtotime($value['date_start'])))]." ".(date('Y',strtotime($value['date_start']))+543)." ".date('H:i',strtotime($value['date_start'])):label('UnlimitedTime');
            }else{
              $date_start = $value['date_start']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($value['date_start'])):label('UnlimitedTime');
            }*/$date_start = $value['date_start']!="0000-00-00 00:00:00"?date('d/m',strtotime($value['date_start']))."/".(date('Y',strtotime($value['date_start']))+543)." ".date('H:i',strtotime($value['date_start'])):label('UnlimitedTime');
            }else{
              $date_start = $value['date_start']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['date_start'])):label('UnlimitedTime');
            }
            $output = array();
            $output['0'] = $cname;
            $output['1'] = $date_start;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }


        public function fetch_data_publicsurvey_report($com_id) {
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "survey/report_survey";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');

          $where = 'LMS_SV.sv_isDelete="0" and sv_approve="1"';
          if($com_id!=""){
            $where .= ' and LMS_SV.com_id="'.$com_id.'"';
          }
          if($user['ug_viewdata']=="3"){
            $where .= ' and sv_createby="'.$user['u_id'].'"';
          }
          $fetch = $this->func_query->query_result('LMS_SV','LMS_COMPANY','LMS_SV.com_id = LMS_COMPANY.com_id','',$where,'sv_id DESC');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $detail = '<button type="button" name="detail" id="'.$value['sv_id'].'" title="'.label('detail').'" class="btn btn-info btn-xs detail"><i class="mdi mdi-format-list-bulleted"></i></button>';
            $output = array();
            $output['0'] = "<span style='float:right;'>".$num."</span>";$num++;
            $output['1'] = $lang=="thai"?$value['com_name_th']:$value['com_name_eng'];
                  if($lang=="thai"){ 
                    $sv_title = $value['sv_title_th']!=""?$value['sv_title_th']:$value['sv_title_eng'];
                  }else if($lang=="english"){ 
                    $sv_title = $value['sv_title_eng']!=""?$value['sv_title_eng']:$value['sv_title_th'];
                  }
            $output['2'] = $sv_title;
            $total_tc = $this->func_query->numrows('LMS_SV_TC','','','','sv_id="'.$value['sv_id'].'" and svtc_isDelete="0"');
            $unsuccess_tc = $this->func_query->numrows('LMS_SV_TC','','','','sv_id="'.$value['sv_id'].'" and svtc_isDelete="0" and svtc_status="0"');
            $success_tc = $this->func_query->numrows('LMS_SV_TC','','','','sv_id="'.$value['sv_id'].'" and svtc_isDelete="0" and svtc_status="1"');
            if($total_tc==0){
              $detail = "-";
            }
            $output['3'] = "<span style='float:right;'>".$total_tc."</span>";
            $output['4'] = "<span style='float:right;'>".$success_tc."</span>";
            $output['5'] = "<span style='float:right;'>".$unsuccess_tc."</span>";
            $output['6'] = "<center>".$detail."</center>";
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_data_publicsurvey($com_id) {
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "survey/list_survey";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');

          $where = 'sv_isDelete="0" and LMS_SV.com_id="'.$com_id.'" and LMS_COMPANY.com_isDelete="0" and LMS_COMPANY.com_status="1"';
          $fetch_ug = $this->func_query->query_row('LMS_USP_GP','','','','ug_id="'.$user['ug_id'].'"');
          if($fetch_ug['ug_viewdata']=="3"){
            $where .= ' and sv_createby="'.$user['u_id'].'"';
          }
          $fetch = $this->func_query->query_result('LMS_SV','LMS_COMPANY','LMS_COMPANY.com_id = LMS_SV.com_id','',$where,'sv_approve ASC,sv_id DESC');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
           /* $demo = '<button type="button" name="demo_course" id="'.$value['cos_id'].'" title="'.label('sample_course').'" class="btn btn-primary btn-xs demo_course"><i class="mdi mdi-eye"></i></button>';
            */
            $demo_sv = '<button type="button" name="demo_sv" id="'.$value['sv_id'].'" title="'.label('sv_b_demo').'" class="btn btn-primary btn-xs demo_sv"><i class="mdi mdi-eye"></i></button>';
            $question = '<button type="button" name="question" id="'.$value['sv_id'].'" title="'.label('question').'" class="btn btn-info btn-xs question"><i class="mdi mdi-comment-question-outline"></i></button>';
            $approve = '<button type="button" name="approve" id="'.$value['sv_id'].'" title="'.label('d_waitapprove').'" class="btn btn-secondary btn-xs active approve"><i class="mdi mdi-alert text-warning"></i></button>';
            $update = '<button type="button" name="update" id="'.$value['sv_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['sv_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $publicsv = '<button type="button" name="publicsv" id="'.$value['sv_id'].'" class="btn btn-default btn-xs publicsv"  style="background-color: #34495e;color: #ecf0f1;" title="'.label('public').'"><i class="mdi mdi-web"></i></button>';
            $list_user = '<button type="button" name="list_user" id="'.$value['sv_id'].'" class="btn btn-default btn-xs list_user" style="background-color:#00d2d3;color:#ecf0f1;" title="'.label('list_userofsv').'"><i class="mdi mdi-format-list-bulleted"></i></button>';
            $output = array();
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;


                  if($lang=="thai"){ 
                    $sv_title = $value['sv_title_th']!=""?$value['sv_title_th']:$value['sv_title_eng'];
                  }else if($lang=="english"){ 
                    $sv_title = $value['sv_title_eng']!=""?$value['sv_title_eng']:$value['sv_title_th'];
                  }
                  $sv_lang = explode(',', $value['sv_lang']);
                  $sv_lang_txt = "";
                  /*if(count($sv_lang)==3){
                    $sv_lang_txt = label('all_lang');
                  }else{*/
                    /*$numloop = 1;
                    for ($i=0; $i < count($sv_lang); $i++) { 
                      if($sv_lang[$i]=="eng"){
                        $sv_lang_txt .= "EN";
                      }else if($sv_lang[$i]=="th"){
                        $sv_lang_txt .= "TH";
                      }else{
                        $sv_lang_txt .= "JP";
                      }
                      if($numloop<count($sv_lang)){
                        $sv_lang_txt .= ",";
                      }
                      $numloop++;
                    }*/
                      if($value['sv_title_eng']!=""){
                        $sv_lang_txt .= "EN";
                      }
                      if($value['sv_title_th']!=""){
                        $sv_lang_txt = $sv_lang_txt!=""?$sv_lang_txt.",":"";
                        $sv_lang_txt .= "TH";
                      }
                      if($value['sv_title_jp']!=""){
                        $sv_lang_txt = $sv_lang_txt!=""?$sv_lang_txt.",":"";
                        $sv_lang_txt .= "JP";
                      }
                 // }
            $output['2'] = $sv_lang_txt;
            $output['3'] = $sv_title;
            $sv_period = label('UnlimitedTime');
            if($value['sv_open']!="0000-00-00 00:00:00"&&$value['sv_end']!="0000-00-00 00:00:00"){
              if($lang=="thai"){
                $sv_open = $value['sv_open']!="0000-00-00 00:00:00"?date('d/m/',strtotime($value['sv_open'])).(date('Y',strtotime($value['sv_open']))+543)." ".date('H:i',strtotime($value['sv_open'])):"";
                $sv_end = $value['sv_end']!="0000-00-00 00:00:00"?date('d/m/',strtotime($value['sv_end'])).(date('Y',strtotime($value['sv_end']))+543)." ".date('H:i',strtotime($value['sv_end'])):"";
              }else{
                $sv_open = $value['sv_open']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['sv_open'])):"";
                $sv_end = $value['sv_end']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['sv_end'])):"";
              }
              $sv_period = $sv_open." - ".$sv_end;
            }
            $output['4'] = "<center>".$sv_period."</center>";
            if(intval($value['sv_public'])==0){
              $sv_approve = label('d_waitcreate');
            }else{
              $sv_approve = label('d_waitapprove');
              if($user['u_id']!="1"){
                $update = "";
                  if($user['ug_id']!="1"){
                    $delete = "";
                  }
                $question = "";
                //$list_user = "";
              }
              if($value['sv_approve']=="1"){
                $sv_approve = label('d_approved');
              }else if($value['sv_approve']=="2"){
                $sv_approve = label('d_rejected');
              }
            }

            $sv_userapprove = explode(",",$value['sv_userapprove']);
            $sv_approve = label('d_waitapprove');
            $fetch_approve = $this->func_query->query_row('LMS_SV_APPROVE','','','','sv_id ="'.$value['sv_id'].'"','sva_id DESC');
            if(count($fetch_approve)>0){
                if($fetch_approve['sva_approve']=="1"){
                    $sv_approve = label('d_approved');
                    $approve = "";
                }else if($fetch_approve['sva_approve']=="2"){
                  if(!in_array($user['emp_id'], $sv_userapprove)){
                    $sv_approve = label('d_waitapprove');
                  }else{
                      $approve = '<button type="button" title="'.label('d_waitapprove').'" id="'.$value['sv_id'].'" class="btn btn-secondary btn-xs active approve"><i class="mdi mdi-alert text-warning"></i></button>';
                  }
                }else if($fetch_approve['sva_approve']=="3"){
                      $approve = "";
                      $sv_approve = label('d_waitcreate');
                }else{
                      $approve = "";
                      $sv_approve = label('d_rejected');
                }
            }else{
              if(intval($value['sv_public'])==0){
                $sv_approve = label('d_waitcreate');
              }              
            }

            $sv_approveby = "<center>-</center>";
            $sv_approvedate = "<center>-</center>";
            if($value['sv_approveby']!=""){
              $fetch_approver = $this->func_query->query_row('LMS_USP','LMS_EMP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.u_id = "'.$value['sv_approveby'].'"');
              if(count($fetch_approver)>0){
                $sv_approveby = $lang=="thai"?$fetch_approver['fullname_th']:$fetch_approver['fullname_en'];
              }
              if($lang=="thai"){
                $sv_approvedate = $value['sv_approvedate']!="0000-00-00 00:00:00"?date('d/m/',strtotime($value['sv_approvedate'])).(date('Y',strtotime($value['sv_approvedate']))+543)." ".date('H:i',strtotime($value['sv_approvedate'])):"";
              }else{
                $sv_approvedate = $value['sv_approvedate']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['sv_approvedate'])):"<center>-</center>";
              }
            }
            //$status_sv = $value['sv_status']=="1"?label('enable'):label('disable');
            $output['5'] = $sv_approve;
            $arr_user = $value['sv_userapprove']!=""?explode(',', $value['sv_userapprove']):array();
            if(count($arr_user)>0){
              if(!in_array($user['emp_id'], $arr_user)){
                  $approve = "";
              }
            }else{
              $approve = "";
            }
            //if($user['ug_approve']=="1"&&$user['ug_id']=="1"){
              $num_question = $this->func_query->numrows('LMS_SVDE','','','','sv_id="'.$value['sv_id'].'" and svde_isDelete="0"');
              if($num_question==0){
                $approve = "";
                //$list_user = "";
                $publicsv = "";
              }
              if($value['sv_approve']=="1"){
                $approve = '';//'<button type="button" class="btn btn-success btn-xs"><i class="mdi mdi-check"></i></button>';
                $publicsv = "";
                if($user['u_id']!="1"){
                  if($user['ug_id']!="1"){
                    $delete = "";
                  }
                $update = "";
                $question = "";
                }
              }else{
                if($value['sv_public']=="0"){
                  $approve = "";
                }else{
                  $publicsv = "";
                }
                $sv_approveby = "<center>-</center>";
                $sv_approvedate = "<center>-</center>";
              }
              $output['7'] = $sv_approveby;
              $output['6'] = $sv_approvedate;
              /*$output['8'] = "<center>".$approve."</center>";*/
              
              $status_cos = label('open');
              if($value['sv_end']!="0000-00-00 00:00:00"&&date('Y-m-d H:i',strtotime($value['sv_end']))<date('Y-m-d H:i')){
                  $status_cos = label('close');
              }
              if($sv_approve==label('d_waitcreate')||$sv_approve==label('d_waitapprove')){
                  $status_cos = "-";
              }
              $numrechk_svde = $this->func_query->numrows('LMS_SVDE','','','','sv_id = "'.$value['sv_id'].'" and svde_isDelete="0"');
              if($numrechk_svde==0){
                  $status_cos = "-";
              }
              $output['8'] = '<center>'.$status_cos.'</center>';
              if($lang=="thai"){
              $output['9'] = $value['sv_modifieddate']!="0000-00-00 00:00:00"?date('d/m/',strtotime($value['sv_modifieddate'])).(date('Y',strtotime($value['sv_modifieddate']))+543)." ".date('H:i',strtotime($value['sv_modifieddate'])):"<center>-</center>";
              }else{
              $output['9'] = $value['sv_modifieddate']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['sv_modifieddate'])):"<center>-</center>";
              }
            /*}else{
              $output['6'] = $sv_approveby;
              $output['7'] = $sv_approvedate;
              $output['8'] = $value['sv_modifieddate']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['sv_modifieddate'])):"<center>-</center>";
            }*/
            $fetch_chkdetail = $this->func_query->numrows('LMS_SVDE','','','','sv_id="'.$value['sv_id'].'" and svde_status="1" and svde_isDelete="0"');
            if($fetch_chkdetail==0){
              $publicsv="";
              $approve="";
            }
            
            if($btn_update!="1"){
                $update = "";
            }
            if($btn_delete!="1"){
                $delete = "";
            }
            $countbtn = 0;
            if($demo_sv!=""&&$demo_sv!="-"){$countbtn++;}
            if($list_user!=""&&$list_user!="-"){$countbtn++;}
            if($publicsv!=""&&$publicsv!="-"){$countbtn++;}
            if($question!=""&&$question!="-"){$countbtn++;}
            if($update!=""&&$update!="-"){$countbtn++;}
            if($delete!=""&&$delete!="-"){$countbtn++;}
            if($approve!=""&&$approve!="-"){$countbtn++;}
            //if($this->checknumber($countbtn)=="Odd"){
            $output['0'] = $demo_sv." ".$list_user." ".$publicsv." ".$question." ".$update." ".$delete." ".$approve;
            /*}else{
            $output['0'] = "<center>".$demo_sv." ".$list_user." ".$publicsv." ".$question." ".$update." ".$delete." ".$approve."</center>";
            }*/
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_data_publicsurvey_detail($sv_id) {
          function str_replace_func($value=""){
              $value = str_replace("<p>","",$value);
              $value = str_replace("</p>","",$value);
              return $value;
          }
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "survey/list_survey";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');

          $where = 'svde_isDelete="0" and sv_id="'.$sv_id.'"';
          $fetch = $this->func_query->query_result('LMS_SVDE','','','',$where,'svde_id ASC');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
           /* $demo = '<button type="button" name="demo_course" id="'.$value['cos_id'].'" title="'.label('sample_course').'" class="btn btn-primary btn-xs demo_course"><i class="mdi mdi-eye"></i></button>';
            */
            $update = '<button type="button" name="update_question" id="'.$value['svde_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update_question"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete_question" id="'.$value['svde_id'].'" class="btn btn-danger btn-xs delete_question" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            $svde_type = "";
            if($value['svde_type']=="sa"){
              $svde_type = label('qt_sa');
            }else if($value['svde_type']=="sub"){
              $svde_type = label('qt_sub');
            }else if($value['svde_type']=="2choice"){
              $svde_type = label('qt_twoChoice');
            }else if($value['svde_type']=="multi"){
              $svde_type = label('qt_multi');
              if($value['svde_isMultichoice']=="1"){
                $svde_type .= "<br><b style='color:red;'>".label('isMultichoice')."</b>";
              }
            }else if($value['svde_type']=="scale"){
              $svde_type = label('qt_scale');
            }
            $output['2'] = "<center>".$svde_type."</center>";
                  if($lang=="thai"){ 
                    $svde_name = $value['svde_name_th']!=""?$value['svde_name_th']:$value['svde_name_eng'];
                  }else if($lang=="english"){ 
                    $svde_name = $value['svde_name_eng']!=""?$value['svde_name_eng']:$value['svde_name_th'];
                  }
            $output['3'] = strip_tags($svde_name);
            $svde_choice = "<center>-</center>";
            $svde_choice = "";
            $fetch_choice = $this->func_query->query_result('LMS_SVDE_MUL','','','','svde_id="'.$value['svde_id'].'" and mul_isDelete="0"');
            if(count($fetch_choice)>0&&($value['svde_type']=="2choice"||$value['svde_type']=="multi")){
              
              foreach ($fetch_choice as $key_choice => $value_choice) {

                      if($lang=="thai"){ 
                        $mul_c1 = $value_choice['mul_c1_th']!=""?$value_choice['mul_c1_th']:$value_choice['mul_c1_eng'];
                        $mul_c2 = $value_choice['mul_c2_th']!=""?$value_choice['mul_c2_th']:$value_choice['mul_c2_eng'];
                        $mul_c3 = $value_choice['mul_c3_th']!=""?$value_choice['mul_c3_th']:$value_choice['mul_c3_eng'];
                        $mul_c4 = $value_choice['mul_c4_th']!=""?$value_choice['mul_c4_th']:$value_choice['mul_c4_eng'];
                        $mul_c5 = $value_choice['mul_c5_th']!=""?$value_choice['mul_c5_th']:$value_choice['mul_c5_eng'];
                      }else if($lang=="english"){ 
                        $mul_c1 = $value_choice['mul_c1_eng']!=""?$value_choice['mul_c1_eng']:$value_choice['mul_c1_th'];
                        $mul_c2 = $value_choice['mul_c2_eng']!=""?$value_choice['mul_c2_eng']:$value_choice['mul_c2_th'];
                        $mul_c3 = $value_choice['mul_c3_eng']!=""?$value_choice['mul_c3_eng']:$value_choice['mul_c3_th'];
                        $mul_c4 = $value_choice['mul_c4_eng']!=""?$value_choice['mul_c4_eng']:$value_choice['mul_c4_th'];
                        $mul_c5 = $value_choice['mul_c5_eng']!=""?$value_choice['mul_c5_eng']:$value_choice['mul_c5_th'];
                      }
                      if($mul_c1!=""){
                        $svde_choice .= "1.".str_replace_func($mul_c1)."<br>";
                      }
                      if($mul_c2!=""){
                        $svde_choice .= "2.".str_replace_func($mul_c2)."<br>";
                      }
                    if($value['svde_type']=="multi"){
                      if($mul_c3!=""){
                        $svde_choice .= "3.".str_replace_func($mul_c3)."<br>";
                      }
                      if($mul_c4!=""){
                        $svde_choice .= "4.".str_replace_func($mul_c4)."<br>";
                      }
                      if($mul_c5!=""){
                        $svde_choice .= "5.".str_replace_func($mul_c5)."<br>";
                      }
                    }
              }
                    if($value['svde_type']=="multi"){
                      if($lang=="thai"){ 
                        $svde_specify_name = $value['svde_specify_name_th']!=""?$value['svde_specify_name_th']:$value['svde_specify_name_eng'];
                        $svde_specify_name = $svde_specify_name!=""?$svde_specify_name:$value['svde_specify_name_jp'];
                      }else if($lang=="english"){ 
                        $svde_specify_name = $value['svde_specify_name_eng']!=""?$value['svde_specify_name_eng']:$value['svde_specify_name_th'];
                        $svde_specify_name = $svde_specify_name!=""?$svde_specify_name:$value['svde_specify_name_jp'];
                      }else{
                        $svde_specify_name = $value['svde_specify_name_jp']!=""?$value['svde_specify_name_jp']:$value['svde_specify_name_eng'];
                        $svde_specify_name = $svde_specify_name!=""?$svde_specify_name:$value['svde_specify_name_th'];
                      }
                      if($value['svde_isSpecify']=="1"&&$svde_specify_name!=""){

                        $svde_choice .= $svde_specify_name." : ...";
                      }
                    }
            }

            $output['4'] = $svde_choice;

              if($lang=="thai"){
              $output['5'] = $value['svde_modifieddate']!="0000-00-00 00:00:00"?date('d/m/',strtotime($value['svde_modifieddate'])).(date('Y',strtotime($value['svde_modifieddate']))+543)." ".date('H:i',strtotime($value['svde_modifieddate'])):"<center>-</center>";
              }else{
              $output['5'] = $value['svde_modifieddate']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['svde_modifieddate'])):"<center>-</center>";
              }
            $output['0'] = "<center>".$update." ".$delete."</center>";
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_data_publicsurvey_listuser($sv_id) {
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "survey/list_survey";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');
          $fetch_main = $this->func_query->query_row('LMS_SV','','','','sv_id = "'.$sv_id.'"');
          $where = 'svtc_isDelete="0" and sv_id="'.$sv_id.'"';
          $fetch = $this->func_query->query_result('LMS_SV_TC','LMS_EMP','LMS_EMP.emp_id = LMS_SV_TC.emp_id','',$where,'svtc_id DESC');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
           /* $demo = '<button type="button" name="demo_course" id="'.$value['cos_id'].'" title="'.label('sample_course').'" class="btn btn-primary btn-xs demo_course"><i class="mdi mdi-eye"></i></button>';
            */
            $fetch_company = $this->func_query->query_row('LMS_COMPANY','','','','com_id="'.$value['com_id'].'"');
            $fetch_position = $this->func_query->query_row('LMS_USP','LMS_POSITION','LMS_POSITION.posi_id = LMS_USP.posi_id','','LMS_USP.emp_id="'.$value['emp_id'].'"');
            $delete = '<button type="button" name="delete_user" id="'.$value['svtc_id'].'" class="btn btn-danger btn-xs delete_user" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $reset = '<button type="button" name="reset_user" id="'.$value['svtc_id'].'" class="btn btn-warning btn-xs reset_user" title="'.label('reset').'"><i class="mdi mdi-backup-restore"></i></button>';
            $sendmail = '<button type="button" name="sendmail_user" id="'.$value['svtc_id'].'" class="btn btn-success btn-xs sendmail_user" title="'.label('sendmail_noti').'"><i class="mdi mdi-email-variant"></i></button>';
            $output = array();
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            $output['2'] = $lang=="thai"?$value['fullname_th']:$value['fullname_en'];
            $output['3'] = $lang=="thai"?$fetch_company['com_name_th']:$fetch_company['com_name_eng'];
            $output['4'] = $lang=="thai"?$fetch_position['posi_name_th']:$fetch_position['posi_name_en'];
              if($lang=="thai"){
              $output['5'] = $value['svtc_firsttime']!="0000-00-00 00:00:00"?date('d/m/',strtotime($value['svtc_firsttime'])).(date('Y',strtotime($value['svtc_firsttime']))+543)." ".date('H:i',strtotime($value['svtc_firsttime'])):"<center>-</center>";
              $output['6'] = $value['svtc_finishtime']!="0000-00-00 00:00:00"?date('d/m/',strtotime($value['svtc_finishtime'])).(date('Y',strtotime($value['svtc_finishtime']))+543)." ".date('H:i',strtotime($value['svtc_finishtime'])):"<center>-</center>";
              }else{
              $output['5'] = $value['svtc_firsttime']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['svtc_firsttime'])):"<center>-</center>";
              $output['6'] = $value['svtc_finishtime']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['svtc_finishtime'])):"<center>-</center>";
              }
            $status = label('not_start');
            if($value['svtc_firsttime']!="0000-00-00 00:00:00"){
                $status = $value['svtc_status']=="0"?label('svUnDone'):label('done');
                if($status==label('done')){
                  $sendmail = '';
                  $delete = '';
                }
            }
            $checkbox = '<div class="checkbox checkbox-success"><input type="checkbox" class="chkall_row" id="selectuser_'.$value['svtc_id'].'" name="selectuser[]" value="'.$value['svtc_id'].'"><label for="selectuser_'.$value['svtc_id'].'"></label>';
            if($value['svtc_finishtime']!="0000-00-00 00:00:00"){
              $checkbox = "-";
              /*$sendmail = "";
              $reset = "";*/
            }
            if($fetch_main['sv_approve']=="0"){
              $sendmail = "";
            }
            $output['7'] = "<center>".$status."</center>";
            $output['8'] = '<center>'.$checkbox.'</center>';
            $output['0'] = "<center>".$sendmail." ".$reset." ".$delete."</center>";
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }


        public function fetch_data_course($com_id) {
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "managecourse/courses_all";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');

          $where = 'cos_isDelete="0" and LMS_COS.com_id="'.$com_id.'" and LMS_COMPANY.com_isDelete="0" and LMS_COMPANY.com_status="1"';
          $fetch_ug = $this->func_query->query_row('LMS_USP_GP','','','','ug_id="'.$user['ug_id'].'"');
          /*if($fetch_ug['ug_viewdata']=="2"){
            $where .= ' and LMS_COS.com_id="'.$user['com_id'].'"';
          }else*/ 
          if($fetch_ug['ug_viewdata']=="3"){
            $where .= ' and cos_createby="'.$user['u_id'].'"';
          }
          
          $fetch = $this->func_query->query_result('LMS_COS','LMS_COMPANY','LMS_COS.com_id = LMS_COMPANY.com_id','',$where,'cos_id DESC');
          $num = 1;$count = 0;
          $fetch_arr = array();
            if(count($fetch)>0){
              foreach ($fetch as $key_list => $value_list) {
                  if(isset($fetch[$key_list])){
                              $result_chkcg = $this->func_query->numrows('LMS_COSINCG','LMS_COG','LMS_COSINCG.cg_id = LMS_COG.cg_id','','LMS_COSINCG.course_id="'.$value_list['cos_id'].'" and LMS_COG.cg_status="1" and LMS_COG.cg_isDelete="0"');
                              if($result_chkcg==0){
                                unset($fetch[$key_list]);
                              }
                  }
              }
            }
          foreach ($fetch as $key => $value) {
            $fetch_cg = $this->func_query->query_result('LMS_COG','LMS_COSINCG','LMS_COSINCG.cg_id = LMS_COG.cg_id','','course_id = "'.$value['cos_id'].'" and status_cg="1"');
            $demo = '<button type="button" name="demo_course" id="'.$value['cos_id'].'" title="'.label('sample_course').'" class="btn btn-primary btn-xs demo_course"><i class="mdi mdi-eye"></i></button>';
            $detail_course = '<button type="button" name="detail_course" id="'.$value['cos_id'].'" title="'.label('ceDetailCourse').'" class="btn btn-info btn-xs detail_course"><i class="mdi mdi-note-multiple"></i></button>';
            $approve = '<button type="button" name="private_btn" id="'.$value['cos_id'].'" title="'.label('d_private').'" class="btn btn-secondary btn-sm active private_btn"><i class="mdi mdi-alert text-warning"></i></button>';
            $update = '<button type="button" name="update" id="'.$value['cos_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['cos_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';

            if($value['cos_public']=="1"){
              $approve='<button type="button" name="public_btn" id="'.$value['cos_id'].'" title="'.label('d_public').'" class="btn btn-success btn-sm active public_btn"><i class="mdi mdi-check"></i></button>';
            }
            $output = array();
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            /*$output['2'] = "<center>".$value['ccode']."</center>";*/
            if($lang=="thai"){ 
              $cname = $value['cname_th']!=""?$value['cname_th']:$value['cname_eng'];
              $output['2'] = $cname; 
            }else if($lang=="english"){ 
              $cname = $value['cname_eng']!=""?$value['cname_eng']:$value['cname_th'];
              $output['2'] = $cname; 
            }
            $cos_lang = explode(',', $value['cos_lang']);
            $cos_lang_txt = "";
              $cos_lang_arr = explode(',', $value['cos_lang']);
                      if(in_array('eng', $cos_lang_arr)){
                        $cos_lang_txt .= "EN";
                      }
                      if(in_array('th', $cos_lang_arr)){
                        $cos_lang_txt = $cos_lang_txt!=""?$cos_lang_txt.",":"";
                        $cos_lang_txt .= "TH";
                      }
            $output['3'] = '<center>'.$cos_lang_txt.'</center>';
            $numloop = 4;
            ///$output[$numloop] = '<center>'.$cos_approve.'</center>';$numloop++;
            
            if($btn_update!="1"){
                $update = "";
            }
            if($btn_delete!="1"){
                $delete = "";
            }

            if(intval($value['cos_public'])!=0&&$user['emp_id']!="1"){
                /*$detail_course = "";
                $update = "";*/
                $delete = "";
            }
            $varchk = 0;
            $fetch_chkqiz = $this->func_query->query_result('LMS_QIZ','','','','cos_id="'.$value['cos_id'].'" and quiz_status="1" and quiz_isDelete="0"');
            if(count($fetch_chkqiz)>0){
              foreach ($fetch_chkqiz as $key_chkqiz => $value_chkqiz) {
                $fetch_chkques = $this->func_query->numrows('LMS_QUES','','','','qiz_id="'.$value_chkqiz['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
                if($fetch_chkques==0){
                  $varchk++;
                }
              }
            }
            $fetch_chksv = $this->func_query->query_result('LMS_SURVEY','','','','cos_id="'.$value['cos_id'].'" and sv_status="1" and sv_isDelete="0"');
            if(count($fetch_chksv)>0){
              foreach ($fetch_chksv as $key_chksv => $value_chksv) {
                $fetch_chkques = $this->func_query->numrows('LMS_SURVEY_DE','','','','sv_id="'.$value_chksv['sv_id'].'" and svde_status="1" and svde_isDelete="0"');
                if($fetch_chkques==0){
                  $varchk++;
                }
              }
            }
              $output['0'] = $demo." ".$approve." ".$detail_course." ".$update;
              /*if($lang=="thai"){
              $output[$numloop] = $value['cos_approvedate']!="0000-00-00 00:00:00"?date('d/m/',strtotime($value['cos_approvedate'])).(date('Y',strtotime($value['cos_approvedate']))+543)." ".date('H:i',strtotime($value['cos_approvedate'])):"<center>-</center>";$numloop++;
              }else{
              $output[$numloop] = $value['cos_approvedate']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['cos_approvedate'])):"<center>-</center>";$numloop++;
              }
              $output[$numloop] = $cos_approveby;$numloop++;*/
              $fetch_chkperiod = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id="'.$value['cos_id'].'"');
              $status_cos = label('open');
              if(count($fetch_chkperiod)>0&&$fetch_chkperiod['date_end']!="0000-00-00 00:00:00"&&date('Y-m-d H:i',strtotime($fetch_chkperiod['date_end']))<date('Y-m-d H:i')){
                  $status_cos = label('close');
                  if($value['cos_status']=="1"){
                    $arr_status = array('cos_status'=>'0');
                    $this->db->where('cos_id',$value['cos_id']);
                    $this->db->update('LMS_COS',$arr_status);
                  }
              }else{
                  $status_cos = $value['cos_status']=="1"?label('open'):label('close');
              }
              $output[$numloop] = '<center>'.$status_cos.'</center>';$numloop++;
              if($lang=="thai"){
              $output[$numloop] = $value['cos_modifieddate']!="0000-00-00 00:00:00"?date('d/m/',strtotime($value['cos_modifieddate'])).(date('Y',strtotime($value['cos_modifieddate']))+543)." ".date('H:i',strtotime($value['cos_modifieddate'])):"<center>-</center>";$numloop++;
              }else{
              $output[$numloop] = $value['cos_modifieddate']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['cos_modifieddate'])):"<center>-</center>";$numloop++;
              }
              //$output[$numloop] = '<center>'.$delete.'</center>';$numloop++;
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_data_cos_document($cos_id) {
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "managecourse/courses_all";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');

          $fetch_course = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');
          $where = 'fil_isDelete="0" and cos_id="'.$cos_id.'"';
          $fetch = $this->func_query->query_result('LMS_COS_FIL','','','',$where,'fil_cos_id DESC');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $update = '<button type="button" name="update_cosdoc" id="'.$value['fil_cos_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update_cosdoc"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete_cosdoc" id="'.$value['fil_cos_id'].'" class="btn btn-danger btn-xs delete_cosdoc" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;

            if($lang=="thai"){ 
              $name_file = $value['name_file_th']!=""?$value['name_file_th']:$value['name_file_eng'];
            }else if($lang=="english"){ 
              $name_file = $value['name_file_eng']!=""?$value['name_file_eng']:$value['name_file_th'];
            }
            $output['2'] = $name_file; 
            $fil_lang = explode(',', $value['fil_lang']);
            $fil_lang_txt = "";
            /*if(count($fil_lang)==3){
              $fil_lang_txt = label('all_lang');
            }else{*/
              /*$numloop = 1;
              for ($i=0; $i < count($fil_lang); $i++) { 
                if($fil_lang[$i]=="eng"){
                  $fil_lang_txt .= "EN";
                }else if($fil_lang[$i]=="th"){
                  $fil_lang_txt .= "TH";
                }else{
                  $fil_lang_txt .= "JP";
                }
                if($numloop<count($fil_lang)){
                  $fil_lang_txt .= ",";
                }
                $numloop++;
              }*/
            //}

                      if($value['name_file_eng']!=""){
                        $fil_lang_txt .= "EN";
                      }
                      if($value['name_file_th']!=""){
                        $fil_lang_txt = $fil_lang_txt!=""?$fil_lang_txt.",":"";
                        $fil_lang_txt .= "TH";
                      }
            $output['3'] = $fil_lang_txt;

              if($lang=="thai"){
              $output['4'] = $value['fil_modifieddate']!="0000-00-00 00:00:00"?date('d/m/',strtotime($value['fil_modifieddate'])).(date('Y',strtotime($value['fil_modifieddate']))+543)." ".date('H:i',strtotime($value['fil_modifieddate'])):"<center>-</center>";
              }else{
              $output['4'] = $value['fil_modifieddate']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['fil_modifieddate'])):"<center>-</center>";
              }
            
            if($btn_update!="1"){
                $update = "";
            }
            if($btn_delete!="1"){
                $delete = "";
            }
                  /*if($fetch_course['cos_approve']=="1"&&$user['u_id']!="1"){
                    $output['0'] = "<center>-</center>";
                  }else{
                  }*/
                    $output['0'] = "<center>".$update." ".$delete."</center>";
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }


        public function fetch_data_course_detail($cos_id) {
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->manage->loadDB();
          $user = $this->session->userdata("user");
          $arr['page'] = "managecourse/courses_all";
          $this->db->select('LMS_COS_DETAIL.cosde_id,LMS_COS_DETAIL.date_start,LMS_COS_DETAIL.date_end');
          $this->db->from('LMS_COS_DETAIL');
          $this->db->where('LMS_COS_DETAIL.cos_id',$cos_id);
          $this->db->where('LMS_COS_DETAIL.cosde_isDelete','0');
          $query = $this->db->get();
          $fetch = $query->result_array();
          $num = 1;$count = 0;
          $fetch_arr = array();
          $arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
          $arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
          foreach ($fetch as $key => $value) {
              $output = array();
              if($arr['btn_update']=="1"||$arr['btn_delete']=="1"){
              $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
              if($value['date_start']!="0000-00-00 00:00:00"&&$value['date_end']!="0000-00-00 00:00:00"){
                  if($lang=="thai"){
                      $output['2'] = date('d',strtotime($value['date_start']))." ".$thaimonth[intval(date('m',strtotime($value['date_start'])))]." ".(date('Y',strtotime($value['date_start']))+543)." ".date('H:i',strtotime($value['date_start']));
                      $output['3'] = date('d',strtotime($value['date_end']))." ".$thaimonth[intval(date('m',strtotime($value['date_end'])))]." ".(date('Y',strtotime($value['date_end']))+543)." ".date('H:i',strtotime($value['date_end']));
                  }else{
                      $output['2'] = date('d F Y H:i',strtotime($value['date_start']));
                      $output['3'] = date('d F Y H:i',strtotime($value['date_end']));
                  }
              }else{
                  $output['2'] = label('UnlimitedTime');
                  $output['3'] = label('UnlimitedTime');
              }
                  $update = '<button type="button" name="update_period" id="'.$value['cosde_id'].'" title="'.label('sedit').'" class="btn btn-warning btn-xs update_period"><i class="mdi mdi-lead-pencil"></i></button>';
                  $delete = '<button type="button" name="delete_period" id="'.$value['cosde_id'].'" class="btn btn-danger btn-xs delete_period" title="'.label('sdelete').'"><i class="mdi mdi-window-close"></i></button>';

                  if($arr['btn_update']!="1"){
                    $update = '';
                  }
                  if($arr['btn_delete']!="1"){
                    $delete = '';
                  }
                $output['0'] = "<center>".$update." ".$delete."</center>";
            }else{
              $output['0'] = "<span style='float:right;'>".$num."</span>";$num++;
              if($value['date_start']!="0000-00-00 00:00:00"&&$value['date_end']!="0000-00-00 00:00:00"){
                  if($lang=="thai"){
                      $output['1'] = date('d',strtotime($value['date_start']))." ".$thaimonth[intval(date('m',strtotime($value['date_start'])))]." ".(date('Y',strtotime($value['date_start']))+543)." ".date('H:i',strtotime($value['date_start']));
                      $output['2'] = date('d',strtotime($value['date_end']))." ".$thaimonth[intval(date('m',strtotime($value['date_end'])))]." ".(date('Y',strtotime($value['date_end']))+543)." ".date('H:i',strtotime($value['date_end']));
                  }else{
                      $output['1'] = date('d F Y H:i',strtotime($value['date_start']));
                      $output['2'] = date('d F Y H:i',strtotime($value['date_end']));
                  }
              }else{
                  $output['1'] = label('UnlimitedTime');
                  $output['2'] = label('UnlimitedTime');
              }
            }
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_course_lesson($cos_id,$status_user) {
          date_default_timezone_set("Asia/Bangkok");
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $user = $this->session->userdata('user');
          $arr['page'] = "managecourse/courses_all";
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $where = 'LMS_LES.cos_id = "'.$cos_id.'" and les_isDelete="0"';
          if($status_user!=""){
            $where .= '((LMS_LES.time_start="0000-00-00 00:00:00" and LMS_LES.time_end="0000-00-00 00:00:00") or ("'.date('Y-m-d H:i').'" between LMS_LES.time_start and LMS_LES.time_end))';
          }
          $fetch_course = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');

          $fetch = $this->func_query->query_result('LMS_LES','','','',$where,'LMS_LES.les_sequences ASC');
          $num = 1;$count = 0;
          $fetch_arr = array();
          $arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
          $arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
          foreach ($fetch as $key => $value) {
              $output = array();
              $time_start_les = "";
              $time_end_les = "";

              if($value['time_start']=="0000-00-00 00:00:00"){
                $value['time_start_var'] = "";
                $value['time_start'] = "";
              }else{
                $value['time_start_var'] = $value['time_start'];
                $value['time_start'] = date('d/F/Y',strtotime($value['time_start']));
              }
              if($value['time_end']=="0000-00-00 00:00:00"){
                $value['time_end_var'] = "";
                $value['time_end'] = "";
              }else{
                $value['time_end_var'] = $value['time_end'];
                $value['time_end'] = date('d/F/Y',strtotime($value['time_end']));
              }
                  if($lang=="thai"){ 
                    $les_name = $value['les_name_th']!=""?$value['les_name_th']:$value['les_name_eng'];
                  }else if($lang=="english"){ 
                    $les_name = $value['les_name_eng']!=""?$value['les_name_eng']:$value['les_name_th'];
                  }
                  $les_lang = explode(',', $value['les_lang']);
                  $les_lang_txt = "";
                  /*if(count($les_lang)==3){
                    $les_lang_txt = label('all_lang');
                  }else{*/
                    /*$numloop = 1;
                    for ($i=0; $i < count($les_lang); $i++) { 
                      if($les_lang[$i]=="eng"){
                        $les_lang_txt .= "EN";
                      }else if($les_lang[$i]=="th"){
                        $les_lang_txt .= "TH";
                      }else{
                        $les_lang_txt .= "JP";
                      }
                      if($numloop<count($les_lang)){
                        $les_lang_txt .= ",";
                      }
                      $numloop++;
                    }*/

                      if($value['les_name_eng']!=""){
                        $les_lang_txt .= "EN";
                      }
                      if($value['les_name_th']!=""){
                        $les_lang_txt = $les_lang_txt!=""?$les_lang_txt.",":"";
                        $les_lang_txt .= "TH";
                      }
                  //}
              if($status_user==""){
                if($arr['btn_update']=="1"||$arr['btn_delete']=="1"){
                  $update = '<button type="button" name="update_lesson" id="'.$value['les_id'].'" title="'.label('sedit').'" class="btn btn-warning btn-xs update_lesson"><i class="mdi mdi-lead-pencil"></i></button>';
                  $delete = '<button type="button" name="delete_lesson" id="'.$value['les_id'].'" class="btn btn-danger btn-xs delete_lesson" title="'.label('sdelete').'"><i class="mdi mdi-window-close"></i></button>';

                  if($arr['btn_update']!="1"){
                    $update = '';
                  }
                  if($arr['btn_delete']!="1"){
                    $delete = '';
                  }
                  $numloop_col = 1;
                 /* if($fetch_course['cos_approve']=="1"&&$user['u_id']!="1"){
                    $output['0'] = "<center>-</center>";
                  }else{
                  }*/
                    $output['0'] = "<center>".$update." ".$delete."</center>";
                  $output[$numloop_col] = "<span style='float:right;'>".$num."</span>";$num++;$numloop_col++;
                  $output[$numloop_col] = "<center>".$les_lang_txt."</center>";$numloop_col++;
                  $output[$numloop_col] = $les_name; $numloop_col++;
                  

                  if($lang=="thai"){

                    if($value['time_start']!=""){
                      $time_start_les = date('d/m',strtotime($value['time_start_var']))."/".(date('Y',strtotime($value['time_start_var']))+543)." ".date('H:i',strtotime($value['time_start_var']));//date('d ',strtotime($value['time_start_var'])).$thaimonth[intval(date('m',strtotime($value['time_start_var'])))]." ".(date('Y',strtotime($value['time_start_var']))+543)." ".date('H:i',strtotime($value['time_start_var']));
                    }else{
                      $time_start_les = "-";
                    }
                    if($value['time_end']!=""){
                      $time_end_les = date('d/m',strtotime($value['time_end_var']))."/".(date('Y',strtotime($value['time_end_var']))+543)." ".date('H:i',strtotime($value['time_end_var']));//date('d ',strtotime($value['time_end_var'])).$thaimonth[intval(date('m',strtotime($value['time_end_var'])))]." ".(date('Y',strtotime($value['time_end_var']))+543)." ".date('H:i',strtotime($value['time_end_var']));
                    }else{
                      $time_end_les = "-";
                    }
                  }else{

                    if($value['time_start']!=""){
                      $time_start_les = date('d/m/Y H:i',strtotime($value['time_start_var']));
                    }else{
                      $time_start_les = "-";
                    }
                    if($value['time_end']!=""){
                      $time_end_les = date('d/m/Y H:i',strtotime($value['time_end_var']));
                    }else{
                      $time_end_les = "-";
                    }
                  }
                  $output[$numloop_col] = "<center>".$time_start_les."</center>";$numloop_col++;
                  $output[$numloop_col] = "<center>".$time_end_les."</center>";$numloop_col++;
                }else{
                  $output['0'] = "<span style='float:right;'>".$num."</span>";$num++;
                  $output['1'] = "<center>".$les_lang_txt."</center>";
                  $output['2'] = $les_name;
                  if($lang=="thai"){

                    if($value['time_start']!=""){
                      $time_start_les = date('d/m',strtotime($value['time_start_var']))."/".(date('Y',strtotime($value['time_start_var']))+543)." ".date('H:i',strtotime($value['time_start_var']));//date('d ',strtotime($value['time_start_var'])).$thaimonth[intval(date('m',strtotime($value['time_start_var'])))]." ".(date('Y',strtotime($value['time_start_var']))+543)." ".date('H:i',strtotime($value['time_start_var']));
                    }else{
                      $time_start_les = "-";
                    }
                    if($value['time_end']!=""){
                      $time_end_les = date('d/m',strtotime($value['time_end_var']))."/".(date('Y',strtotime($value['time_end_var']))+543)." ".date('H:i',strtotime($value['time_end_var']));//date('d ',strtotime($value['time_end_var'])).$thaimonth[intval(date('m',strtotime($value['time_end_var'])))]." ".(date('Y',strtotime($value['time_end_var']))+543)." ".date('H:i',strtotime($value['time_end_var']));
                    }else{
                      $time_end_les = "-";
                    }
                  }else{

                    if($value['time_start']!=""){
                      $time_start_les = date('d/F/Y H:i',strtotime($value['time_start_var']));
                    }
                    if($value['time_end']!=""){
                      $time_end_les = date('d/F/Y H:i',strtotime($value['time_end_var']));
                    }
                  }
                  $output['3'] = "<center>".$time_start_les."</center>";
                  $output['4'] = "<center>".$time_end_les."</center>";
                }
              }else{
                $output['0'] = "<span style='float:right;'>".$num."</span>";$num++;
                $output['1'] = $les_name;
                $status = '<b style="color:#ff0000"><i class="mdi mdi-close-octagon-outline"></i> '.label('not_start').'</b>';
                $fetch_chk = $this->func_query->query_row('LMS_LES_TC','','','','les_id="'.$value['les_id'].'" and emp_id = "'.$user['emp_id'].'"');
                if(count($fetch_chk)>0){
                  if($fetch_chk['learn_status']=="1"){
                    $status = '<b style="color:#e6b800"><i class="mdi mdi-timer-sand"></i> '.label('inProgress').'</b>';
                  }else if($fetch_chk['learn_status']=="2"){
                    $status = '<b style="color:#009933"><i class="mdi mdi-checkbox-marked-circle-outline"></i> '.label('done').'</b>';
                  }else if($fetch_chk['learn_status']=="3"){
                    $status = '<b style="color:orange"><i class="mdi mdi-alert-box"></i> '.label('fail').'</b>';
                  }
                }
                $output['2'] = "<center>".$status."</center>";
                $output['3'] = $value['les_id'];
              }

              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_course_quiz($cos_id,$status_user) {
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $user = $this->session->userdata('user');
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $arr['page'] = "managecourse/courses_all";

          $where = 'LMS_QIZ.cos_id = "'.$cos_id.'" and quiz_isDelete="0"';
          if($status_user!=""){
            $where .= '((LMS_QIZ.period_open="0000-00-00 00:00:00" and LMS_QIZ.period_end="0000-00-00 00:00:00") or ("'.date('Y-m-d H:i').'" between LMS_QIZ.period_open and LMS_QIZ.period_end))';
          }

          $fetch = $this->func_query->query_result('LMS_QIZ','','','',$where,'LMS_QIZ.qiz_id DESC');

          $fetch_course = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');

                 
          $num = 1;$count = 0;
          $fetch_arr = array();

          $arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
          $arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
          foreach ($fetch as $key => $value) {
              $output = array();

                  if($lang=="thai"){ 
                    $quiz_name = $value['quiz_name_th']!=""?$value['quiz_name_th']:$value['quiz_name_eng'];
                  }else if($lang=="english"){ 
                    $quiz_name = $value['quiz_name_eng']!=""?$value['quiz_name_eng']:$value['quiz_name_th'];
                  }
                  $quiz_lang = explode(',', $value['quiz_lang']);
                  $quiz_lang_txt = "";
                      if($value['quiz_name_eng']!=""){
                        $quiz_lang_txt .= "EN";
                      }
                      if($value['quiz_name_th']!=""){
                        $quiz_lang_txt = $quiz_lang_txt!=""?$quiz_lang_txt.",":"";
                        $quiz_lang_txt .= "TH";
                      }
                $quiz_type = $value['quiz_type']=="1"?label('preExam'):label('finalExam');
              if($status_user==""){
                //if($arr['btn_update']=="1"||$arr['btn_delete']=="1"){
                  $numloop_col = 1;
                  if($arr['btn_update']!="1"){
                      $update = '';
                  }
                  if($arr['btn_delete']!="1"){
                      $delete = '';
                  }
                  $criteria_score = '<button type="button" name="criteria_score" id="'.$value['qiz_id'].'" title="'.label('criteria_score').'" class="btn btn-primary btn-xs criteria_score"><i class="mdi mdi-account-settings-variant"></i></button>';
                  $update = '<button type="button" name="update_quiz" id="'.$value['qiz_id'].'" title="'.label('sedit').'" class="btn btn-warning btn-xs update_quiz"><i class="mdi mdi-lead-pencil"></i></button>';
                  $delete = '<button type="button" name="delete_quiz" id="'.$value['qiz_id'].'" class="btn btn-danger btn-xs delete_quiz" title="'.label('sdelete').'"><i class="mdi mdi-window-close"></i></button>';
                  /*if($fetch_course['cos_approve']=="1"&&$user['u_id']!="1"){
                    $output['0'] = '<center><button type="button" name="quiz_detail" id="'.$value['qiz_id'].'" title="'.label('question').'" class="btn btn-info btn-xs quiz_detail"><i class="mdi mdi-comment-question-outline"></i></button></center>';
                  }else{
                  }*/
                    $output['0'] = '<center>'.$criteria_score.'<button type="button" name="quiz_detail" id="'.$value['qiz_id'].'" title="'.label('question').'" class="btn btn-info btn-xs quiz_detail"><i class="mdi mdi-comment-question-outline"></i></button>'.$update.$delete.'</center>';
                  $score_total = 0;
                  $fetch_sum = $this->func_query->query_result('LMS_QUES','','','','qiz_id="'.$value['qiz_id'].'"  and ques_status="1" and ques_isDelete="0"');
                  if(count($fetch_sum)>0){
                    foreach ($fetch_sum as $key_sum => $value_sum) {
                      $score_total += floatval($value_sum['ques_score']);
                    }
                  }
                  $output[$numloop_col] = "<span style='float:right;'>".$num."</span>";$num++;$numloop_col++;
                  $output[$numloop_col] = '<center>'.$quiz_lang_txt.'</center>';$numloop_col++;
                  $output[$numloop_col] = $quiz_name;$numloop_col++;
                  $output[$numloop_col] = '<center>'.$quiz_type.'</center>';$numloop_col++;
                  $output[$numloop_col] = "<span style='float:right;'>".number_format($score_total)."</span>";$numloop_col++;
                  //$output[$numloop_col] = "<span style='float:right;'>".$value['quiz_maxscore']."</span>";$numloop_col++;

                  if($lang=="thai"){

                    if($value['period_open']!=""&&$value['period_open']!="0000-00-00 00:00:00"){
                      $period_open = date('d/m',strtotime($value['period_open']))."/".(date('Y',strtotime($value['period_open']))+543)." ".date('H:i',strtotime($value['period_open']));//date('d ',strtotime($value['time_start_var'])).$thaimonth[intval(date('m',strtotime($value['time_start_var'])))]." ".(date('Y',strtotime($value['time_start_var']))+543)." ".date('H:i',strtotime($value['time_start_var']));
                    }else{
                      $period_open = "-";
                    }
                    if($value['period_end']!=""&&$value['period_end']!="0000-00-00 00:00:00"){
                      $period_end = date('d/m',strtotime($value['period_end']))."/".(date('Y',strtotime($value['period_end']))+543)." ".date('H:i',strtotime($value['period_end']));//date('d ',strtotime($value['time_end_var'])).$thaimonth[intval(date('m',strtotime($value['time_end_var'])))]." ".(date('Y',strtotime($value['time_end_var']))+543)." ".date('H:i',strtotime($value['time_end_var']));
                    }else{
                      $period_end = "-";
                    }
                  }else{

                    if($value['period_open']!=""&&$value['period_open']!="0000-00-00 00:00:00"){
                      $period_open = date('d/m/Y H:i',strtotime($value['period_open']));
                    }else{
                      $period_open = "-";
                    }
                    if($value['period_end']!=""&&$value['period_end']!="0000-00-00 00:00:00"){
                      $period_end = date('d/m/Y H:i',strtotime($value['period_end']));
                    }else{
                      $period_end = "-";
                    }
                  }
                  $output[$numloop_col] = '<center>'.$period_open.'</center>';$numloop_col++;
                  $output[$numloop_col] = '<center>'.$period_end.'</center>';$numloop_col++;
                /*}else{
                  $output['0'] = "<span style='float:right;'>".$num."</span>";$num++;
                  $output['1'] = '<center>'.$quiz_lang_txt.'</center>';
                  $output['2'] = $quiz_name;
                  $output['3'] = '<center>'.$quiz_type.'</center>';
                  $output['4'] = '<center>'.$value['quiz_maxscore'].'</center>';
                }*/
              }else{
                $score = 0;
                $status = '<b style="color:#ff0000"><i class="mdi mdi-close-octagon-outline"></i> '.label('not_start').'</b>';
                $fetch_chk = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$value['qiz_id'].'" and emp_id="'.$user['emp_id'].'"');
                if(count($fetch_chk)>0){
                  $score = floatval($fetch_chk['sum_score']);
                  if($fetch_chk['qiz_status']=="1"){
                    $status = '<b style="color:#e6b800"><i class="mdi mdi-timer-sand"></i> '.label('preUnDone').'</b>';
                  }else if($fetch_chk['qiz_status']=="2"){
                    $status = '<b style="color:orange"><i class="mdi mdi-close-box"></i> '.label('cannot-complete').'</b>';
                  }else if($fetch_chk['qiz_status']=="3"){
                    $status = '<b style="color:#009933"><i class="mdi mdi-checkbox-marked-circle-outline"></i> '.label('done').'</b>';
                  }
                }
                $score_total = 0;
                $fetch_sum = $this->func_query->query_result('LMS_QUES','','','','qiz_id="'.$value['qiz_id'].'"  and ques_status="1" and ques_isDelete="0"');
                if(count($fetch_sum)>0){
                  foreach ($fetch_sum as $key_sum => $value_sum) {
                    $score_total += floatval($value_sum['ques_score']);
                  }
                  $score = (floatval($fetch_chk['sum_score'])/$score_total)*100;
                }

                $output['0'] = "<span style='float:right;'>".$num."</span>";$num++;
                $output['1'] = $quiz_name;
                $output['2'] = '<center>'.$quiz_type.'</center>';
                $output['3'] = number_format($score,2)." / 100";
                $output['4'] = $status;
                $output['5'] = $value['qiz_id'];
              }
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_course_question($qiz_id) {
          function str_replace_func($value=""){
              $value = str_replace("<p>","",$value);
              $value = str_replace("</p>","",$value);
              return $value;
          }
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $user = $this->session->userdata('user');
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $arr['page'] = "managecourse/courses_all";
          $fetch = $this->func_query->query_result('LMS_QUES','','','','qiz_id="'.$qiz_id.'" and ques_isDelete="0"');

          $fetch_qiz = $this->func_query->query_row('LMS_QIZ','','','','qiz_id="'.$qiz_id.'"');
          $cos_id = $fetch_qiz['cos_id'];
          $fetch_course = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');
          $num = 1;$count = 0;
          $fetch_arr = array();
          $arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
          $arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
          foreach ($fetch as $key => $value) {
              $output = array();
              $output['4'] = "";
              $output['1'] = "<span style='float:right;'>".$num."</span>";
              if($value['ques_type']=="sa"){
                $output['2'] = label('qt_sa');
              }else if($value['ques_type']=="sub"){
                $output['2'] = label('qt_sub');
              }else{
                if($value['ques_type']=="2choice"){
                  $output['2'] = label('qt_twoChoice');
                }else{
                  $output['2'] = label('qt_multi');
                }
                $fetch_mul = $this->func_query->query_result('LMS_QUES_MUL','','','','mul_isDelete="0" and ques_id="'.$value['ques_id'].'"');
                if(count($fetch_mul)>0){
                  foreach ($fetch_mul as $key_mul => $value_mul) {

                      if($lang=="thai"){ 
                        $mul_c1 = $value_mul['mul_c1_th']!=""?$value_mul['mul_c1_th']:$value_mul['mul_c1_eng'];
                        $mul_c2 = $value_mul['mul_c2_th']!=""?$value_mul['mul_c2_th']:$value_mul['mul_c2_eng'];
                        $mul_c3 = $value_mul['mul_c3_th']!=""?$value_mul['mul_c3_th']:$value_mul['mul_c3_eng'];
                        $mul_c4 = $value_mul['mul_c4_th']!=""?$value_mul['mul_c4_th']:$value_mul['mul_c4_eng'];
                        $mul_c5 = $value_mul['mul_c5_th']!=""?$value_mul['mul_c5_th']:$value_mul['mul_c5_eng'];
                      }else if($lang=="english"){ 
                        $mul_c1 = $value_mul['mul_c1_eng']!=""?$value_mul['mul_c1_eng']:$value_mul['mul_c1_th'];
                        $mul_c2 = $value_mul['mul_c2_eng']!=""?$value_mul['mul_c2_eng']:$value_mul['mul_c2_th'];
                        $mul_c3 = $value_mul['mul_c3_eng']!=""?$value_mul['mul_c3_eng']:$value_mul['mul_c3_th'];
                        $mul_c4 = $value_mul['mul_c4_eng']!=""?$value_mul['mul_c4_eng']:$value_mul['mul_c4_th'];
                        $mul_c5 = $value_mul['mul_c5_eng']!=""?$value_mul['mul_c5_eng']:$value_mul['mul_c5_th'];
                      }
                      if($mul_c1!=""){
                        $output['4'] .= "1.".str_replace_func($mul_c1)."<br>";
                      }
                      if($mul_c2!=""){
                        $output['4'] .= "2.".str_replace_func($mul_c2)."<br>";
                      }
                      if($value['ques_type']=="multi"){
                        if($mul_c3!=""){
                          $output['4'] .= "3.".str_replace_func($mul_c3)."<br>";
                        }
                        if($mul_c4!=""){
                          $output['4'] .= "4.".str_replace_func($mul_c4)."<br>";
                        }
                        if($mul_c5!=""){
                          $output['4'] .= "5.".str_replace_func($mul_c5)."<br>";
                        }
                      }
                  }
                }
              }
              $statusques = $value['ques_status']=="1"?label('open'):label('close');
              $output['5'] = '<center>'.$statusques.'</center>';
                  if($lang=="thai"){ 
                    $ques_name = $value['ques_name_th']!=""?$value['ques_name_th']:$value['ques_name_eng'];
                  }else if($lang=="english"){ 
                    $ques_name = $value['ques_name_eng']!=""?$value['ques_name_eng']:$value['ques_name_th'];
                  }
              $output['3'] = $ques_name;
              $update = '<button type="button" name="update_ques" id="'.$value['ques_id'].'" title="'.label('sedit').'" class="btn btn-warning btn-xs update_ques"><i class="mdi mdi-lead-pencil"></i></button>';
              $delete = '<button type="button" name="delete_ques" id="'.$value['ques_id'].'" class="btn btn-danger btn-xs delete_ques" title="'.label('sdelete').'"><i class="mdi mdi-window-close"></i></button>';
              $rechk_answer = '<button type="button" name="check_ques" id="'.$value['ques_id'].'" title="'.label('chk_answer').'" class="btn btn-info btn-xs check_ques"><i class="mdi mdi-check-circle"></i></button>';
                  if($arr['btn_update']!="1"){
                    $update = '';
                  }
                  if($arr['btn_delete']!="1"){
                    $delete = '';
                  }

                  if($value['ques_type']=="2choice"||$value['ques_type']=="multi"){
                    $rechk_answer = '';
                  }
                  $numloop_col = 1;

                  /*if($fetch_course['cos_approve']=="1"&&$user['u_id']!="1"){
                    $output['0'] = '<center>'.$rechk_answer.'</center>';
                  }else{
                  }*/
                    $output['0'] = '<center>'.$rechk_answer.$update.$delete.'</center>';
                  $num_chk = 0;
                  if($update==""){
                    $num_chk++;
                  }
                  if($delete==""){
                    $num_chk++;
                  }
                  if($rechk_answer==""){
                    $num_chk++;
                  }
                  if($num_chk>=3){
                    $output['0'] = "<center>-</center>";
                  }
              
              $count++;$num++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_quiz_question_check($ques_id) {

          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $user = $this->session->userdata('user');
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $arr['page'] = "managecourse/courses_all";
          function str_replace_func($value=""){
              $value = str_replace("<p>","",$value);
              $value = str_replace("</p>","",$value);
              return $value;
          }
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $arr_choice = array();
          $fetch_main = $this->func_query->query_row('LMS_QUES','','','','ques_id="'.$ques_id.'"');
          if($fetch_main['ques_type']=="multi"||$fetch_main['ques_type']=="2choice"){
            $fetch_mul = $this->func_query->query_row('LMS_QUES_MUL','','','','ques_id="'.$ques_id.'"');

                      if($lang=="thai"){ 
                        $mul_c1 = $fetch_mul['mul_c1_th']!=""?$fetch_mul['mul_c1_th']:$fetch_mul['mul_c1_eng'];
                        $mul_c2 = $fetch_mul['mul_c2_th']!=""?$fetch_mul['mul_c2_th']:$fetch_mul['mul_c2_eng'];
                        $mul_c3 = $fetch_mul['mul_c3_th']!=""?$fetch_mul['mul_c3_th']:$fetch_mul['mul_c3_eng'];
                        $mul_c4 = $fetch_mul['mul_c4_th']!=""?$fetch_mul['mul_c4_th']:$fetch_mul['mul_c4_eng'];
                        $mul_c5 = $fetch_mul['mul_c5_th']!=""?$fetch_mul['mul_c5_th']:$fetch_mul['mul_c5_eng'];
                      }else if($lang=="english"){ 
                        $mul_c1 = $fetch_mul['mul_c1_eng']!=""?$fetch_mul['mul_c1_eng']:$fetch_mul['mul_c1_th'];
                        $mul_c2 = $fetch_mul['mul_c2_eng']!=""?$fetch_mul['mul_c2_eng']:$fetch_mul['mul_c2_th'];
                        $mul_c3 = $fetch_mul['mul_c3_eng']!=""?$fetch_mul['mul_c3_eng']:$fetch_mul['mul_c3_th'];
                        $mul_c4 = $fetch_mul['mul_c4_eng']!=""?$fetch_mul['mul_c4_eng']:$fetch_mul['mul_c4_th'];
                        $mul_c5 = $fetch_mul['mul_c5_eng']!=""?$fetch_mul['mul_c5_eng']:$fetch_mul['mul_c5_th'];
                      }
                $arr_choice['mul_c1']=str_replace_func($mul_c1);
                $arr_choice['mul_c2']=str_replace_func($mul_c2);
                $arr_choice['mul_c3']=str_replace_func($mul_c3);
                $arr_choice['mul_c4']=str_replace_func($mul_c4);
                $arr_choice['mul_c5']=str_replace_func($mul_c5);
          }
          $fetch = $this->func_query->query_result('LMS_QUES_TC','LMS_EMP','LMS_QUES_TC.emp_id = LMS_EMP.emp_id','','ques_id="'.$ques_id.'" and tc_flag="true" and tc_save="true"','tc_id DESC','','','');
          $num = 1;$count = 0;
          $fetch_arr = array();
          $arr_emp_c = array();
          foreach ($fetch as $key => $value) {
            if(!in_array($value['emp_id'], $arr_emp_c)){
              array_push($arr_emp_c,$value['emp_id']);
            }else{
              unset($fetch[$key]);
            }
          }
          foreach ($fetch as $key => $value) {
              $output = array();
              $output['0'] = $value['emp_c'];
              if($lang=="thai"){
                $output['1'] = $value['fullname_th'];
              }else{
                $output['1'] = $value['fullname_en'];
              }
              if($fetch_main['ques_type']=="multi"||$fetch_main['ques_type']=="2choice"){
                $output['2'] = "<span style='overflow-wrap: anywhere;'>".$arr_choice[$value['tc_answer']]."</span>";
                $output['3'] = "<center>-</center>";
                $output['4'] = "<span style='float:right;'>".intval($fetch_main['ques_score'])."</span>";
                $output['5'] = "<span style='float:right;'>".intval($value['tc_score'])."</span>";
              }else{
                if($value['tc_isSavescore']=="1"){
                $output['2'] = "<span style='overflow-wrap: anywhere;'>".$value['tc_answer']."</span>";
                $output['3'] = $value['tc_note']!=""?$value['tc_note']:"<center>-</center>";
                $output['4'] = "<span style='float:right;'>".intval($fetch_main['ques_score'])."</span>";
                $output['5'] = "<span style='float:right;'>".intval($value['tc_score'])."</span>";
                $output['6'] = "-";
                }else{
                $output['2'] = $value['tc_answer'];
                $output['3'] = '<input type="hidden" id="tc_id_'.$value['tc_id'].'" name="tc_id[]" value="'.$value['tc_id'].'"><textarea class="form-control" maxlength="10000" rows="3" id="tc_note_'.$value['tc_id'].'" name="tc_note[]">'.$value['tc_note'].'</textarea>';
                // onchange="changeNote_tc('.$value['tc_id'].')"
                // onkeyup="changeScore_tc('.$value['tc_id'].')" onchange="changeScore_tc('.$value['tc_id'].')"
                $output['4'] = "<span style='float:right;'>".intval($fetch_main['ques_score'])."</span>";
                $output['5'] = '<input type="hidden" id="ori_score_'.$value['tc_id'].'" name="ori_score[]" value="'.$value['tc_score'].'"><input type="hidden" id="ques_score_'.$value['tc_id'].'" name="ques_score_'.$value['tc_id'].'" value="'.intval($fetch_main['ques_score']).'"><input class="form-control" style="text-align: right;" type="text" id="score_'.$value['tc_id'].'" name="tc_score[]" value="'.intval($value['tc_score']).'" onkeypress="validate(event)" onkeyup="changeScore_tc('.$value['tc_id'].');" onchange="changeScore_tc('.$value['tc_id'].')">';
                $output['6'] = '<button type="button" name="save_answer_tc" id="'.$value['tc_id'].'" title="'.label('saveR').'" class="btn btn-success btn-xs save_answer_tc"><i class="mdi mdi-content-save"></i></button>';
                }
              }
              
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }



        public function fetch_data_enroll_detail($cos_id) {
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");

          $user = $this->session->userdata('user');
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $arr['page'] = "managecourse/courses_all";

          $fetch = $this->func_query->query_result('LMS_COS_ENROLL','LMS_EMP','LMS_COS_ENROLL.emp_id = LMS_EMP.emp_id','','LMS_COS_ENROLL.cos_id="'.$cos_id.'" and LMS_COS_ENROLL.cosen_isDelete="0" and LMS_EMP.emp_isDelete="0"','','LMS_EMP.emp_id,LMS_EMP.emp_c,LMS_EMP.fullname_th,LMS_EMP.fullname_en,LMS_COS_ENROLL.cosen_score,LMS_COS_ENROLL.cosen_grade,LMS_COS_ENROLL.cosen_status,LMS_COS_ENROLL.cosen_id,LMS_COS_ENROLL.cosen_finishtime,LMS_COS_ENROLL.cosen_cancelnote,LMS_COS_ENROLL.cosen_status_sub,LMS_EMP.com_id,LMS_COS_ENROLL.cosen_firsttime','LMS_COS_ENROLL.cosen_status_sub DESC');

          $fetch_qiz = $this->func_query->numrows('LMS_QIZ','','','','cos_id="'.$cos_id.'" and quiz_isDelete="0"');
          $fetch_lesson = $this->func_query->numrows('LMS_LES','','','','cos_id="'.$cos_id.'" and les_isDelete="0"');
          $fetch_cos = $this->func_query->numrows('LMS_COS','','','','cos_id="'.$cos_id.'" ');
          $num = 1;$count = 0;
          $fetch_arr = array();
          $arr['page'] = "managecourse/courses_all";
          $arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
          $arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
          foreach ($fetch as $key => $value) {
              $fetch_company = $this->func_query->query_row('LMS_COMPANY','','','','com_id="'.$value['com_id'].'"');
              $output = array();
              $numrow = 0;
              $checkbox = '<div class="checkbox checkbox-success"><input type="checkbox" class="chkall_row" id="selectuser_'.$value['cosen_id'].'" name="selectuser[]" value="'.$value['cosen_id'].'"><label for="selectuser_'.$value['cosen_id'].'"></label>';
              if($arr['btn_delete']=="1"){
                if($value['cosen_status']=="2"){
                  $output[$numrow] = '<center><button type="button" name="Reenroll" id="'.$value['cosen_id'].'" class="btn btn-warning btn-xs Reenroll" title="Re Enroll"><i class="mdi mdi-backup-restore"></i></button></center>';
                }else{
                  $output[$numrow] = '<center><button type="button" name="delete_enroll" id="'.$value['cosen_id'].'" class="btn btn-danger btn-xs delete_enroll" title="'.label('sdelete').'"><i class="mdi mdi-window-close"></i></button></center>';
                }
                $numrow++;
              }
              $output[$numrow] = "<span style='float:right;'>".$num."</span>";$num++;$numrow++;

              if($lang=="thai"){
                $output[$numrow] = $value['fullname_th'];$numrow++;
                $output[$numrow] = $fetch_company['com_name_th'];$numrow++;
              }else{
                $output[$numrow] = $value['fullname_en'];$numrow++;
                $output[$numrow] = $fetch_company['com_name_eng'];$numrow++;
              }
              $status_student = label('not_start');
              if($value['cosen_status_sub']=="1"){
                $checkbox = "";
                $status_student = label('r_pass');
              }else if($value['cosen_status_sub']=="2"){
                $status_student = label('inProgress');
                $value['cosen_score'] = "-";
              }
                  $output[$numrow] = $value['cosen_status']=="0"?label('not_start'):"<center>".$status_student."</center>";$numrow++;
                  $output[$numrow] = "<span style='float:right;'>".$value['cosen_score']."</span>";$numrow++;
                  $output[$numrow] =  '<center>'.$checkbox.'</center>';
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_videocourse($cos_id) {
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $user = $this->session->userdata('user');
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $fetch = $this->func_query->query_result('LMS_COS_VIDEO','','','','cos_id="'.$cos_id.'" and cosv_isDelete="0"');
          $num = 1;$count = 0;
          $fetch_arr = array();
          $arr['page'] = "managecourse/courses_all";

          $arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
          $arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
          foreach ($fetch as $key => $value) {
              $output = array();
              $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
                  if($lang=="thai"){ 
                    $cosv = $value['cosv_th']!=""?$value['cosv_th']:$value['cosv_eng'];
                  }else if($lang=="english"){ 
                    $cosv = $value['cosv_eng']!=""?$value['cosv_eng']:$value['cosv_th'];
                  }
                $output['2'] = $cosv;

              $output['3'] = $value['cosv_video'];

              $cosv_lang = explode(',', $value['cosv_lang']);
              $cosv_lang_txt = "";

                      if($value['cosv_eng']!=""){
                        $cosv_lang_txt .= "EN";
                      }
                      if($value['cosv_th']!=""){
                        $cosv_lang_txt = $cosv_lang_txt!=""?$cosv_lang_txt.",":"";
                        $cosv_lang_txt .= "TH";
                      }
              //}
              /*else{
                    $numloop = 1;
                      if($value['cosv_th']!=""){
                        $cosv_lang_txt .= "TH";
                      }
                      if($value['cosv_eng']!=""){
                        $cosv_lang_txt = $cosv_lang_txt!=""?$cosv_lang_txt.",":"";
                        $cosv_lang_txt .= "EN";
                      }
                      if($value['cosv_jp']!=""){
                        $cosv_lang_txt = $cosv_lang_txt!=""?$cosv_lang_txt.",":"";
                        $cosv_lang_txt .= "JP";
                      }*/
                      /*if($numloop<count($sv_lang)){
                        $cosv_lang_txt .= ",";
                      }*/
                      $numloop++;
                    //}
                //  }
              $output['4'] = '<center>'.$cosv_lang_txt.'</center>';
              $delete = '<button type="button" name="delete_videocourse" id="'.$value['cosv_id'].'" class="btn btn-danger btn-xs delete_videocourse" title="'.label('sdelete').'"><i class="mdi mdi-window-close"></i></button>';
              $update = '<button type="button" name="update_videocourse" id="'.$value['cosv_id'].'" class="btn btn-warning btn-xs update_videocourse" title="'.label('sedit').'"><i class="mdi mdi-lead-pencil"></i></button>';

                  if($arr['btn_update']!="1"){
                    $update = '';
                  }
                  if($arr['btn_delete']!="1"){
                    $delete = '';
                  }
                  if($value['cosv_type']=="1"){
                    $update = '';
                  }
                $output['0'] = "<center>".$update." ".$delete."</center>";
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_course_survey($cos_id,$status_user) {
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $user = $this->session->userdata('user');
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $arr['page'] = "managecourse/courses_all";
          $fetch = $this->func_query->query_result('LMS_SURVEY','','','','LMS_SURVEY.cos_id="'.$cos_id.'" and LMS_SURVEY.sv_isDelete="0"','sv_id DESC');
          $num = 1;$count = 0;

          $fetch_course = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');
          $fetch_arr = array();
          $arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
          $arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
          foreach ($fetch as $key => $value) {
              $output = array();
              
                $sv_lang = "";

                  if($lang=="thai"){ 
                    $sv_title = $value['sv_title_th']!=""?$value['sv_title_th']:$value['sv_title_eng'];
                  }else if($lang=="english"){ 
                    $sv_title = $value['sv_title_eng']!=""?$value['sv_title_eng']:$value['sv_title_th'];
                  }
                  $sv_lang = explode(',', $value['sv_lang']);
                  $sv_lang_txt = "";
                  /*if(count($sv_lang)==3){
                    $sv_lang_txt = label('all_lang');
                  }else{*/
                    $numloop = 1;
                      if($value['sv_title_eng']!=""){
                        $sv_lang_txt .= "EN";
                      }
                      if($value['sv_title_th']!=""){
                        $sv_lang_txt = $sv_lang_txt!=""?$sv_lang_txt.",":"";
                        $sv_lang_txt .= "TH";
                      }
                      /*if($numloop<count($sv_lang)){
                        $sv_lang_txt .= ",";
                      }*/
                      $numloop++;
                    //}
                 // }
              if($status_user==""){
                $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
                $output['2'] = '<center>'.$sv_lang_txt.'</center>';
                $output['3'] = $sv_title;
                if($lang=="thai"){
                if($value['survey_open']!="0000-00-00 00:00:00"){
                  /*$output['4'] = date('d',strtotime($value['survey_open']))." ".$thaimonth[intval(date('m',strtotime($value['survey_open'])))]." ".(date('Y',strtotime($value['survey_open']))+543)." ".date('H:i',strtotime($value['survey_open']));
                  $output['5'] = date('d',strtotime($value['survey_end']))." ".$thaimonth[intval(date('m',strtotime($value['survey_end'])))]." ".(date('Y',strtotime($value['survey_end']))+543)." ".date('H:i',strtotime($value['survey_end']));*/
                  $output['4'] = date('d/m',strtotime($value['survey_open']))."/".(date('Y',strtotime($value['survey_open']))+543)." ".date('H:i',strtotime($value['survey_open']));
                  $output['5'] = date('d/m',strtotime($value['survey_end']))."/".(date('Y',strtotime($value['survey_end']))+543)." ".date('H:i',strtotime($value['survey_end']));//date('d ',strtotime($value['time_start_var'])).$thaimonth[intval(date('m',strtotime($value['time_start_var'])))]." ".(date('Y',strtotime($value['time_start_var']))+543)." ".date('H:i',strtotime($value['time_start_var']));
                }else{
                  $output['4'] = "";
                  $output['5'] = "";
                }
                }else{
                if($value['survey_open']!="0000-00-00 00:00:00"){
                  $output['4'] = date('d/m/Y H:i',strtotime($value['survey_open']));
                  $output['5'] = date('d/m/Y H:i',strtotime($value['survey_end']));
                }else{
                  $output['4'] = "";
                  $output['5'] = "";
                }                }
                  $update = '<button type="button" name="update_survey" id="'.$value['sv_id'].'" title="'.label('sedit').'" class="btn btn-warning btn-xs update_survey"><i class="mdi mdi-lead-pencil"></i></button>';
                  $delete = '<button type="button" name="delete_survey" id="'.$value['sv_id'].'" class="btn btn-danger btn-xs delete_survey" title="'.label('sdelete').'"><i class="mdi mdi-window-close"></i></button>';

                  if($arr['btn_update']!="1"){
                    $update = '';
                  }
                  if($arr['btn_delete']!="1"){
                    $delete = '';
                  }

                  /*if($fetch_course['cos_approve']=="1"&&$user['u_id']!="1"){
                    $output['0'] = '<center><button type="button" name="survey_detail" id="'.$value['sv_id'].'" title="'.label('question').'" class="btn btn-info btn-xs survey_detail"><i class="mdi mdi-comment-question-outline"></i></button></center>';
                  }else{
                  }*/
                    $output['0'] = '<center><button type="button" name="survey_detail" id="'.$value['sv_id'].'" title="'.label('question').'" class="btn btn-info btn-xs survey_detail"><i class="mdi mdi-comment-question-outline"></i></button>'.$update.$delete.'</center>';
              }else{
                $output['0'] = "<span style='float:right;'>".$num."</span>";$num++;
                $output['1'] = $sv_title;
                $status = '<b style="color:#ff0000"><i class="mdi mdi-close-octagon-outline"></i> '.label('not_start').'</b>';
                $fetch_chk = $this->func_query->query_row('LMS_QN_USER','','','','sv_id="'.$value['sv_id'].'" and emp_id="'.$user['emp_id'].'"');
                if(count($fetch_chk)>0){
                  if($fetch_chk['qnu_status']=="0"){
                    $status = '<b style="color:#e6b800"><i class="mdi mdi-timer-sand"></i> '.label('svUnDone').'</b>';
                  }else if($fetch_chk['qnu_status']=="2"){
                    $status = '<b style="color:#009933"><i class="mdi mdi-checkbox-marked-circle-outline"></i> '.label('done').'</b>';
                  }
                }
                $output['2'] = $status;
                $output['3'] = $value['sv_id'];
              }
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_course_survey_detail($sv_id) {
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $user = $this->session->userdata('user');
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $arr['page'] = "managecourse/courses_all";
          $this->db->from('LMS_SURVEY_DE');
          $this->db->where('LMS_SURVEY_DE.sv_id',$sv_id);
          $query = $this->db->get();
          $fetch = $query->result_array();
          $fetch_sv_id = $this->func_query->query_row('LMS_SURVEY','','','','sv_id="'.$sv_id.'"');
          $cos_id = $fetch_sv_id['cos_id'];
          $fetch_course = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');
          $fetch = $this->func_query->query_result('LMS_SURVEY_DE','','','','sv_id="'.$sv_id.'" and svde_isDelete="0"');
          $num = 1;$count = 0;
          $fetch_arr = array();
          $arr['btn_update'] = $this->manage->chk_permission($arr['page'],'ru_edit');
          $arr['btn_delete'] = $this->manage->chk_permission($arr['page'],'ru_del');
          foreach ($fetch as $key => $value) {
              $output = array();

                  if($lang=="thai"){ 
                    $svde_heading = $value['svde_heading_th']!=""?$value['svde_heading_th']:$value['svde_heading_eng'];
                    $svde_detail = $value['svde_detail_th']!=""?$value['svde_detail_th']:$value['svde_detail_eng'];
                  }else if($lang=="english"){ 
                    $svde_heading = $value['svde_heading_eng']!=""?$value['svde_heading_eng']:$value['svde_heading_th'];
                    $svde_detail = $value['svde_detail_eng']!=""?$value['svde_detail_eng']:$value['svde_detail_th'];
                  }
              if($arr['btn_update']!="1"&&$arr['btn_delete']!="1"){
                $output['0'] = "<span style='float:right;'>".$num."</span>";$num++;
                $output['1'] = $svde_heading;
                $output['2'] = $svde_detail;
              }else{
                $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
                $output['2'] = $svde_heading;
                $output['3'] = $svde_detail;

                    $update = '<button type="button" name="update_survey_detail" id="'.$value['svde_id'].'" title="'.label('sedit').'" class="btn btn-warning btn-xs update_survey_detail"><i class="mdi mdi-lead-pencil"></i></button>';
                    $delete = '<button type="button" name="delete_survey_detail" id="'.$value['svde_id'].'" class="btn btn-danger btn-xs delete_survey_detail" title="'.label('sdelete').'"><i class="mdi mdi-window-close"></i></button>';

                    if($arr['btn_update']!="1"){
                      $update = '';
                    }
                    if($arr['btn_delete']!="1"){
                      $delete = '';
                    }

                  /*if($fetch_course['cos_approve']=="1"&&$user['u_id']!="1"){
                    $output['0'] = "<center>-</center>";
                  }else{
                  }*/
                    $output['0'] = "<center>".$update." ".$delete."</center>";
              }
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_detail_allcourseadmin() {
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $user = $this->session->userdata('user');
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $fetch = $this->func_query->query_result('LMS_WKG','','','','com_id="'.$user['com_id'].'" and wg_status = 1 and wg_isDelete="0"');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
              $output = array();
              $output['0'] = $lang=="thai"?$value['wtitle_th']:$value['wtitle_en'];
              $output['1'] = $this->func_query->numrows('LMS_COS','','','','wg_id = "'.$value['wg_id'].'" and cos_isDelete = 0 and cos_public = 1');
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_detail_alluseradmin() {
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $user = $this->session->userdata('user');
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $fetch = $this->func_query->query_result('LMS_DIVISION','','','','com_id="'.$user['com_id'].'" and div_status = 1 and div_isDelete="0"');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
              $output = array();
              $output['0'] = $lang=="thai"?$value['div_name_th']:$value['div_name_en'];
              $output['1'] = $this->func_query->numrows('LMS_EMP','','','','div_id = "'.$value['div_id'].'" and emp_isDelete = 0');
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_detail_ongoninglearner() {
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $user = $this->session->userdata('user');
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $fetch = $this->func_query->query_result('LMS_COS','LMS_TYPECOS
            ','LMS_TYPECOS.tc_id = LMS_COS.tc_id','','LMS_COS.cos_isDelete = 0 and LMS_COS.cos_public = 1 and LMS_COS.cos_id in (select LMS_COS_POSITION.cos_id from LMS_COS_POSITION where LMS_COS_POSITION.posi_id = "'.$user['posi_id'].'") and LMS_COS.cos_id not in (select LMS_COS_ENROLL.cos_id from LMS_COS_ENROLL where LMS_COS_ENROLL.emp_id = "'.$user['emp_id'].'" and LMS_COS_ENROLL.cosen_isActive = 1) and LMS_COS.cos_id in (select LMS_COS_DETAIL.cos_id from LMS_COS_DETAIL where (LMS_COS_DETAIL.date_start = "0000-00-00 00:00:00" and LMS_COS_DETAIL.date_end = "0000-00-00 00:00:00") or (LMS_COS_DETAIL.date_start <= "'.date('Y-m-d H:i').'" and LMS_COS_DETAIL.date_end >= "'.date('Y-m-d H:i').'"))');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
              $output = array();
              if($lang=="thai"){ 
                $cname = $value['cname_th']!=""?$value['cname_th']:$value['cname_eng'];
                $tc_name = $value['tc_name_th']!=""?$value['tc_name_th']:$value['tc_name_en'];
              }else{ 
                $cname = $value['cname_eng']!=""?$value['cname_eng']:$value['cname_th'];
                $tc_name = $value['tc_name_en']!=""?$value['tc_name_en']:$value['tc_name_th'];
              }
              $output['0'] = $cname;
              $output['1'] = $tc_name;
              $output['2'] = '<center><button type="button" id="'.$value['cos_id'].'" class="btn btn-info btn_register" alt="'.label('lrn_btn_register').'"><i class="mdi mdi-file-document-box"></i></button></center>';
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_detail_incominglearner() {
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $user = $this->session->userdata('user');
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $fetch = $this->func_query->query_result('LMS_COS_ENROLL','LMS_COS
            ','LMS_COS_ENROLL.cos_id = LMS_COS.cos_id','','LMS_COS.cos_isDelete = 0 and LMS_COS.cos_public = 1 and LMS_COS.cos_id in (select LMS_COS_DETAIL.cos_id from LMS_COS_DETAIL where (LMS_COS_DETAIL.date_start = "0000-00-00 00:00:00" and LMS_COS_DETAIL.date_end = "0000-00-00 00:00:00") or (LMS_COS_DETAIL.date_start <= "'.date('Y-m-d H:i').'" and LMS_COS_DETAIL.date_end >= "'.date('Y-m-d H:i').'")) and LMS_COS_ENROLL.emp_id = "'.$user['emp_id'].'" and LMS_COS_ENROLL.cosen_isActive = 1','LMS_COS_ENROLL.cosen_id DESC','','5');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
              $fetch_tc = $this->func_query->query_row('LMS_TYPECOS','','','','tc_id = "'.$value['tc_id'].'"');
              $fetch_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id = "'.$value['cos_id'].'"');
              $output = array();
              if($lang=="thai"){ 
                $cname = $value['cname_th']!=""?$value['cname_th']:$value['cname_eng'];
                $tc_name = $fetch_tc['tc_name_th']!=""?$fetch_tc['tc_name_th']:$fetch_tc['tc_name_en'];
              }else{ 
                $cname = $value['cname_eng']!=""?$value['cname_eng']:$value['cname_th'];
                $tc_name = $fetch_tc['tc_name_en']!=""?$fetch_tc['tc_name_en']:$fetch_tc['tc_name_th'];
              }
              $output['0'] = $cname;
              $output['1'] = $tc_name;

              if($value['cosen_status_sub']=="0"){
                $output['2'] = label('not_start');
              }else if($value['cosen_status_sub']=="1"){
                $output['2'] = label('r_pass');
              }else if($value['cosen_status_sub']=="2"){
                $output['2'] = label('inProgress');
              }else{
                $output['2'] = label('not_start');
              }
              if($fetch_detail['date_end']!="0000-00-00 00:00:00"){
                $output['3'] = $lang=="thai"?date('d/m/',strtotime($fetch_detail['date_end'])).(date('Y',strtotime($fetch_detail['date_end']))+543)." ".date('H:i',strtotime($fetch_detail['date_end'])):date('d/m/Y H:i',strtotime($fetch_detail['date_end']));
              }else{
                $output['3'] = label('lrn_b_unlimited_time');
              }
              $output['4'] = '<center><button type="button" id="'.$value['cos_id'].'" class="btn btn-warning btn_gotocourse" alt="'.label('go_to_course').'"><i class="fas fa-share"></i></button></center>';
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_detail_instructor_create() {
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $user = $this->session->userdata('user');
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $fetch = $this->func_query->query_result('LMS_COS','
            ','','','LMS_COS.cos_isDelete = 0 and LMS_COS.cos_createby = "'.$user['u_id'].'"','LMS_COS.cos_id DESC','');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
              $fetch_tc = $this->func_query->query_row('LMS_TYPECOS','','','','tc_id = "'.$value['tc_id'].'"');
              $fetch_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id = "'.$value['cos_id'].'"');
              $output = array();

              if($lang=="thai"){ 
                $cname = $value['cname_th']!=""?$value['cname_th']:$value['cname_eng'];
              }else{ 
                $cname = $value['cname_eng']!=""?$value['cname_eng']:$value['cname_th'];
              }
              $output['0'] = $cname;
              $output['1'] = $this->func_query->numrows('LMS_COS_ENROLL','','','','cos_id = "'.$value['cos_id'].'" and cosen_isDelete = 0');
              $namebestscore = "-";
              $bestscore = "-";
              $average_score = "-";
              $average_rating = "-";
              $fetch_bestscore = $this->func_query->query_row('LMS_COS_ENROLL','LMS_EMP','LMS_EMP.emp_id = LMS_COS_ENROLL.emp_id','','LMS_COS_ENROLL.cos_id="'.$value['cos_id'].'" and LMS_COS_ENROLL.cosen_status_sub = 1 and LMS_COS_ENROLL.cosen_isDelete = 0 and cosen_isActive = 1','LMS_COS_ENROLL.cosen_score DESC','LMS_EMP.fullname_th,LMS_EMP.fullname_en,LMS_COS_ENROLL.cosen_score,AVG(LMS_COS_ENROLL.cosen_score) as average_score,AVG(LMS_COS_ENROLL.cosen_rating) as average_rating');
              if(count($fetch_bestscore)>0){
                $namebestscore = $lang=="thai"?$fetch_bestscore['fullname_th']:$fetch_bestscore['fullname_en'];
                $bestscore = number_format($fetch_bestscore['cosen_score']);
                $average_score = number_format($fetch_bestscore['average_score']);
                $average_rating = number_format($fetch_bestscore['average_rating'],2);
              }
              $output['2'] = $namebestscore;
              $output['3'] = $bestscore;
              $output['4'] = $average_score;
              $output['5'] = $average_rating;

              $output['6'] = '<center><button type="button" id="'.$value['cos_id'].'" class="btn btn-warning btn_gotocourse" alt="'.label('go_to_course').'"><i class="fas fa-share"></i></button></center>';
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_detail_instructor_latest_complete() {
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $user = $this->session->userdata('user');
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $fetch = $this->func_query->query_result('LMS_COS_ENROLL','LMS_EMP
            ','LMS_COS_ENROLL.emp_id = LMS_EMP.emp_id','','LMS_COS_ENROLL.cos_id in (select LMS_COS.cos_id from LMS_COS where LMS_COS.cos_isDelete = 0 and LMS_COS.cos_createby = "'.$user['u_id'].'") and cosen_isDelete = 0 and cosen_status_sub = 1 and cosen_isActive = 1','LMS_COS_ENROLL.cosen_id DESC','');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
              $fetch_cos = $this->func_query->query_row('LMS_COS','','','','cos_id = "'.$value['cos_id'].'"');
              $fetch_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id = "'.$value['cos_id'].'"');
              $output = array();

              if($lang=="thai"){ 
                $cname = $fetch_cos['cname_th']!=""?$fetch_cos['cname_th']:$fetch_cos['cname_eng'];
              }else{ 
                $cname = $fetch_cos['cname_eng']!=""?$fetch_cos['cname_eng']:$fetch_cos['cname_th'];
              }
              $output['0'] = $num;$num++;
              $output['1'] = $lang=="thai"?$value['fullname_th']:$value['fullname_en'];
              $output['2'] = $cname;
              if(floatval($value['cosen_score'])>=floatval($fetch_cos['goal_score'])){
                $output['3'] = '<center><span class="label label-success label-rounded">'.label('pass').'</span></center>';
              }else{
                $output['3'] = '<center><span class="label label-danger label-rounded">'.label('fail').'</span></center>';
              }
              $output['4'] = number_format($value['cosen_score_per'])."%";
              $output['5'] = $lang=="thai"?date('d/',strtotime($value['cosen_finishtime'])).$thaimonth[intval(date('m',strtotime($value['cosen_finishtime'])))]."/".(date('Y',strtotime($value['cosen_finishtime']))+543)." ".date('H:i',strtotime($value['cosen_finishtime'])):date('d/m/Y H:i',strtotime($value['cosen_finishtime']));
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }
}
?>