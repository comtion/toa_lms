<?php
class Setting_model extends CI_Model {

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

        public function rechk_nummenu(){
            $this->db->from('LMS_MENU');
            $this->db->where('LMS_MENU.mu_status','1');
            $this->db->order_by('mu_num','DESC');
            $query = $this->db->get();
            $fetch = $query->row_array();
            return intval($fetch['mu_num'])+1;
        }

        public function create_testimonials($data)
        {
          date_default_timezone_set("Asia/Bangkok");

          $this->db->from('LMS_TESTIMONIALS');
          $this->db->where('tim_title', $data['tim_title']);
          $this->db->where('tim_file', $data['tim_file']);
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_TESTIMONIALS', $data);
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

        public function create_menu($data)
        {
          date_default_timezone_set("Asia/Bangkok");

          $this->db->from('LMS_MENU');
          $this->db->where('mu_name_th', $data['mu_name_th']);
          $this->db->where('mu_name_en', $data['mu_name_en']);
          $this->db->where('mu_path', $data['mu_path']);
          $this->db->where('mu_status', '1');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_MENU', $data);
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

        public function create_mainmenu($data)
        {
          date_default_timezone_set("Asia/Bangkok");

          $this->db->from('LMS_MAINMENU');
          $this->db->where('mm_txt_th1', $data['mm_txt_th1']);
          $this->db->where('mm_txt_th2', $data['mm_txt_th2']);
          $this->db->where('mm_txt_en1', $data['mm_txt_en1']);
          $this->db->where('mm_txt_en2', $data['mm_txt_en2']);
          $this->db->where('com_id', $data['com_id']);
          $this->db->where('mm_status', '1');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_MAINMENU', $data);
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

        public function create_faq_main($data)
        {
          date_default_timezone_set("Asia/Bangkok");

          $this->db->from('LMS_FAQ');
          $this->db->where('title', $data['title']);
          $this->db->where('lang', $data['lang']);
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_FAQ', $data);
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

        public function create_faq_detail($data)
        {
          date_default_timezone_set("Asia/Bangkok");

          $this->db->from('LMS_FAQ_Q');
          $this->db->where('question', $data['question']);
          $this->db->where('answer', $data['answer']);
          $this->db->where('tid', $data['tid']);
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_FAQ_Q', $data);
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
        public function insert_banner($data)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->from('LMS_BAN');
          $this->db->where('banner', $data['banner']);
          $this->db->where('com_id', $data['com_id']);
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_BAN', $data);
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
        public function insert_banner_about($data)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->from('LMS_ABOUT_BAN');
          $this->db->where('banner', $data['banner']);
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_ABOUT_BAN', $data);
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
        public function create_event($data)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->from('LMS_CONTENT');
          $this->db->where('con_title_th', $data['con_title_th']);
          $this->db->where('con_title_en', $data['con_title_en']);
          $this->db->where('con_IsDelete', '0');
          $query = $this->db->get();
          if($query->num_rows()==0){
            $this->db->insert('LMS_CONTENT', $data);
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
        public function insert_settingemail($data,$id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('sm_id','1');
          $this->db->update('LMS_SETTING_MAIL', $data);
          return "2";
        }
        public function insert_about($data,$id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('da_id','1');
          $this->db->update('LMS_ABOUT', $data);
          return "2";
        }
        public function insert_sso($data,$id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('sso_id','1');
          $this->db->update('LMS_SETTING_SSO', $data);
          return "2";
        }
        public function update_testimonials($data,$id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('tim_id', $id);
          $this->db->update('LMS_TESTIMONIALS', $data);
          return "2";
        }
        public function update_faq($data,$id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('id', $id);
          $this->db->update('LMS_FAQ', $data);
          return "2";
        }
        public function update_menu($data,$mu_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('mu_id', $mu_id);
          $this->db->update('LMS_MENU', $data);
          return "2";
        }
        public function update_mainmenu($data,$mm_id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('mm_id', $mm_id);
          $this->db->update('LMS_MAINMENU', $data);
          return "2";
        }
        public function update_faq_detail($data,$id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('id', $id);
          $this->db->update('LMS_FAQ_Q', $data);
          return "2";
        }
        public function update_event($data,$id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('con_id', $id);
          $this->db->update('LMS_CONTENT', $data);
          return "2";
        }

        public function delete_event_data($id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $data = array(
            'con_IsDelete' => '1'
          );
          $this->db->where('con_id', $id);
          $this->db->update('LMS_CONTENT',$data);
          return "2";
        }

        public function delete_banner($id)
        {
          $this->load->model('Function_query_model', 'func_query', FALSE);
          date_default_timezone_set("Asia/Bangkok");
          $fetch = $this->func_query->query_row('LMS_BAN','','','','id = "'.$id.'"');
          if(count($fetch)>0){
              if(is_file(ROOT_DIR."uploads/banner/".$fetch['banner'])) {
                  unlink(ROOT_DIR."uploads/banner/".$fetch['banner']);
              }
          }
          $this->db->where('id', $id);
          $this->db->delete('LMS_BAN');
          return "2";
        }


        public function delete_banner_about($id)
        {
          $this->load->model('Function_query_model', 'func_query', FALSE);
          date_default_timezone_set("Asia/Bangkok");
          $fetch = $this->func_query->query_row('LMS_ABOUT_BAN','','','','id = "'.$id.'"');
          if(count($fetch)>0){
              if(is_file(ROOT_DIR."uploads/banner/".$fetch['banner'])) {
                  unlink(ROOT_DIR."uploads/banner/".$fetch['banner']);
              }
          }
          $this->db->where('id', $id);
          $this->db->delete('LMS_ABOUT_BAN');
          return "2";
        }

        public function delete_testimonials($id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('tim_id', $id);
          $this->db->delete('LMS_TESTIMONIALS');
          return "2";
        }


        public function delete_mainmenu($id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('mm_id', $id);
          $this->db->delete('LMS_MAINMENU');
          return "2";
        }


        public function delete_formatmail($id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('smf_id', $id);
          $this->db->delete('LMS_SENDMAIL_FORM');
          return "2";
        }

        public function delete_menu($id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $data = array(
            'mu_status' => '0'
          );
          $this->db->where('mu_id', $id);
          $this->db->update('LMS_MENU',$data);
          return "2";
        }

        public function delete_faq($id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('id', $id);
          $this->db->delete('LMS_FAQ');
          return "2";
        }

        public function delete_faq_detail($id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->db->where('id', $id);
          $this->db->delete('LMS_FAQ_Q');
          return "2";
        }

        public function delete_bannercourse($id)
        {
          date_default_timezone_set("Asia/Bangkok");
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->func_query->loadDB();
          $fetch_chk = $this->func_query->query_row('LMS_BAN_COS','','','','bc_id="'.$id.'"');
          if(count($fetch_chk)>0&&$fetch_chk['bc_image']!=""){
              if(is_file(ROOT_DIR."uploads/banner_course/".$fetch_chk['bc_image'])) {
                  unlink(ROOT_DIR."uploads/banner_course/".$fetch_chk['bc_image']);
              }
          }
          $this->db->where('bc_id', $id);
          $this->db->delete('LMS_BAN_COS');
          return "2";
        }

        public function fetch_data_ECT() {
          $this->db->from('LMS_ABOUT');
          $this->db->where('da_id','1');
          $query = $this->db->get();
          return $query->row_array();
        }

        public function fetch_data_managebannercourse() {
          $this->db->from('LMS_BAN_COS');
          $this->db->where('bc_isDelete','0');
          $query = $this->db->get();
          return $query->result_array();
        }

        public function fetch_data_faq() {
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->db->from('LMS_FAQ');
          $query = $this->db->get();
          $fetch = $query->result_array();
          $this->load->model('Manage_model', 'manage', FALSE);
          $btn_add = $this->manage->chk_permission('setting/ManageFAQ','ru_add');
          $btn_delete = $this->manage->chk_permission('setting/ManageFAQ','ru_del');
          $btn_update = $this->manage->chk_permission('setting/ManageFAQ','ru_edit');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
              $output = array();
              $add = '<button type="button" name="add_detail" id="'.$value['id'].'" title="'.label('faqafaq').'" class="btn btn-success btn-xs add_detail"><i class="mdi mdi-plus"></i></button>';
              $update = '<button type="button" name="update" id="'.$value['id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
              $delete = '<button type="button" name="delete" id="'.$value['id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';


              if($btn_update!='1'){
                $update = '';
              }
              if($btn_delete!='1'){
                $delete = '';
              }
              $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
                $output['2'] = $value['title'];
                $langval = $value['lang']=="thai"?"TH":"JP";
                $langval = $value['lang']=="english"?"EN":$langval;
                $output['3'] = "<center>".$langval."</center>";
                $output['4'] = date('d/m/Y H:i',strtotime($value['time_edit']));
              $output['0'] = "<center>".$add."".$update."</center>";
              $output['5'] = "<center>".$delete."</center>";
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_data_sort($com_id) {
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->db->from('LMS_COS_SORT');
          $this->db->join('LMS_COS','LMS_COS_SORT.cos_id = LMS_COS.id');
          $this->db->where('LMS_COS.com_id',$com_id);
          $this->db->order_by('LMS_COS_SORT.coss_num','ASC');
          $query = $this->db->get();
          $fetch = $query->result_array();
          $this->load->model('Manage_model', 'manage', FALSE);
          $btn_delete = $this->manage->chk_permission('setting/ManageECT','ru_del');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
              $output = array();
              $delete = '<button type="button" name="delete_sort" id="'.$value['coss_id'].'" class="btn btn-danger btn-xs delete_sort" title="Delete"><i class="mdi mdi-window-close"></i></button>';
              $output['0'] = "<span style='float:right;'>".$num."</span>";$num++;
              if($lang=="thai"){
                $output['1'] = $value['cname_th'];
              }else{
                $output['1'] = $value['cname_en'];
              }
              if($btn_delete!='1'){
                $delete = '';
              }
              $output['2'] = "<center>".$delete."</center>";
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_data_mainmenu($com_id) {
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->db->from('LMS_MAINMENU');
          $this->db->where('LMS_MAINMENU.com_id',$com_id);
          $query = $this->db->get();
          $fetch = $query->result_array();
          $this->load->model('Manage_model', 'manage', FALSE);
          $btn_delete = $this->manage->chk_permission('setting/ManageECT','ru_del');
          $btn_update = $this->manage->chk_permission('setting/ManageECT','ru_edit');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
              $output = array();
              $update = '<button type="button" name="update" id="'.$value['mm_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
              $delete = '<button type="button" name="delete" id="'.$value['mm_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
              $output['0'] = "<span style='float:right;'>".$num."</span>";$num++;
                $output['1'] = $value['mm_icon'];
              if($lang=="thai"){
                $output['2'] = $value['mm_txt_th1'];
                $output['3'] = $value['mm_txt_th2'];
              }else{
                $output['2'] = $value['mm_txt_en1'];
                $output['3'] = $value['mm_txt_en2'];
              }
              if($btn_update!='1'){
                $update = '';
              }
              if($btn_delete!='1'){
                $delete = '';
              }
              if($value['mm_status']=="1"){$output['4'] = label('show');}else{$output['4'] = label('hide');}
              $output['5'] = "<center>".$update." ".$delete."</center>";
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_data_menu() {

          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->db->from('LMS_MENU');
          $this->db->where('mu_status','1');
          $this->db->order_by('mu_num','ASC');
          $query = $this->db->get();
          $fetch = $query->result_array();
          $this->load->model('Manage_model', 'manage', FALSE);
          $btn_delete = $this->manage->chk_permission('setting/ManageMenu','ru_del');
          $btn_update = $this->manage->chk_permission('setting/ManageMenu','ru_edit');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
              $output = array();
              $update = '<button type="button" name="update" id="'.$value['mu_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
              $delete = '<button type="button" name="delete" id="'.$value['mu_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
              $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
                $output['4'] = $value['mu_path'];
              if($value['mu_icon']!=""){
                $output['2'] = "<center>".'<i class="'.$value['mu_icon'].'">'."</center>";
              }else{
                $output['2'] = '<center>-</center>';
              }
              if($lang=="thai"){
                $output['3'] = $value['mu_name_th'];
              }else if($lang=="english"){
                $output['3'] = $value['mu_name_en'];
              }else{
                $output['3'] = $value['mu_name_jp'];
              }
              if($value['mu_customer']=="1"){
                $output['5'] = '<center><i style="color:green" class="mdi mdi-check-circle-outline"></i></center>';
              }else{
                $output['5'] = '<center>-</center>';
              }
              if($btn_update!='1'){
                $update = '';
              }
              if($btn_delete!='1'){
                $delete = '';
              }
              $output['0'] = "<center>".$update."</center>";
              $output['6'] = "<center>".$delete."</center>";
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }


        public function fetch_data_testimonials() {
          $this->db->from('LMS_TESTIMONIALS');
          $query = $this->db->get();
          return $query->result_array();
        }

        public function fetch_data_faq_detail($tid) {
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->manage->loadDB();
          $this->db->from('LMS_FAQ_Q');
          $this->db->where('LMS_FAQ_Q.tid', $tid);
          $page = 'setting/ManageFAQ';
          $query = $this->db->get();
          $fetch = $query->result_array();
          $num = 1;$count = 0;
          $fetch_arr = array();

          $arr['btn_update'] = $this->manage->chk_permission($page,'ru_edit');
          $arr['btn_delete'] = $this->manage->chk_permission($page,'ru_del');
          foreach ($fetch as $key => $value) {
            $output = array();
            if($arr['btn_update']!="1"&&$arr['btn_delete']!="1"){
            $output['0'] = "<span style='float:right;'>".$num."</span>";$num++;
            $output['1'] = $value['question'];
            $output['2'] = $value['answer'];
            }else{
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            $output['2'] = $value['question'];
            $output['3'] = $value['answer'];
                  $update = '<button type="button" name="update_detail" id="'.$value['id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update_detail"><i class="mdi mdi-lead-pencil"></i></button>';
                  $delete = '<button type="button" name="delete_detail" id="'.$value['id'].'" class="btn btn-danger btn-xs delete_detail" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';

                  if($arr['btn_update']!="1"){
                    $update = '';
                  }
                  if($arr['btn_delete']!="1"){
                    $delete = '';
                  }
            $output['0'] = "<center>".$update."</center>";
            $output['4'] = "<center>".$delete."</center>";
            }
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_data_banner($com_id='') {
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->manage->loadDB();
          if($com_id!=""){
            $this->db->from('LMS_BAN');
            $this->db->where('com_id',$com_id);
            $page = "manage/companydata";
          }else{
            $this->db->from('LMS_ABOUT_BAN');
            $page = "setting/ManageECT";
          }
          $query = $this->db->get();
          $fetch = $query->result_array();
          $num = 1;$count = 0;
          $fetch_arr = array();
          $arr['btn_delete'] = $this->manage->chk_permission($page,'ru_del');
          foreach ($fetch as $key => $value) {
            $output = array();
            $delete = '<button type="button" name="delete_banner" id="'.$value['id'].'" class="btn btn-danger btn-xs delete_banner" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $numloop = 1;
            if($arr['btn_delete']=="1"){
                $output['0'] = "<center>".$delete."</center>";
            }else{
                $numloop = 0;
            }
            $array_pathext = explode('.', $value['banner']);
            $extension = end($array_pathext);
            $output[$numloop] = "<span style='float:right;'>".$num."</span>";$num++;$numloop++;
            if($extension=="mp4"){
              $output[$numloop] = '<video muted loop alt="First slide" style="width: 100%;"><source src="../uploads/banner/'.$value['banner'].'" type="video/mp4"></video>';$numloop++;
            }else{
              $output[$numloop] = "<img src='../uploads/banner/".$value['banner']."' width='100%'>";$numloop++;
            }
            $output[$numloop] = $value['banner'];$numloop++;
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }


        public function fetch_data_format_email() {
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "setting/format_email";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');

          $fetch = $this->func_query->query_result('LMS_SENDMAIL_FORM','','','','');
          $user = $this->session->userdata('user');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $update = '<button type="button" name="update" id="'.$value['smf_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['smf_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
                                      $type = label('formattype_1');
                                      if($value['smf_type']=="2"){
                                        $type = label('formattype_2');
                                      }else if($value['smf_type']=="3"){
                                        $type = label('formattype_3');
                                      }else if($value['smf_type']=="4"){
                                        $type = label('formattype_4');
                                      }else if($value['smf_type']=="5"){
                                        $type = label('formattype_5');
                                      }else if($value['smf_type']=="6"){
                                        $type = label('formattype_6');
                                      }else if($value['smf_type']=="7"){
                                        $type = label('formattype_7');
                                      }else if($value['smf_type']=="8"){
                                        $type = label('formattype_8');
                                      }else if($value['smf_type']=="9"){
                                        $type = label('formattype_9');
                                      }else if($value['smf_type']=="10"){
                                        $type = label('formattype_10');
                                      }else if($value['smf_type']=="11"){
                                        $type = label('formattype_11');
                                      }else if($value['smf_type']=="12"){
                                        $type = label('formattype_12');
                                      }else if($value['smf_type']=="13"){
                                        $type = label('formattype_13');
                                      }else if($value['smf_type']=="14"){
                                        $type = label('formattype_14');
                                      }else if($value['smf_type']=="15"){
                                        $type = label('formattype_15');
                                      }else if($value['smf_type']=="16"){
                                        $type = label('formattype_16');
                                      }else if($value['smf_type']=="17"){
                                        $type = label('formattype_17');
                                      }
            $output = array();
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            $output['2'] = $type;
            $output['3'] = $value['smf_subject_th'];
            $output['4'] = $value['smf_subject_en'];
            if($value['smf_show']=="1"){ $output['5'] = "<center>".label('open')."</center>"; }else{ $output['5'] = "<center>".label('close')."</center>"; }
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

        public function fetch_data_event() {
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->manage->loadDB();
          $page = "setting/ManageEvent";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          date_default_timezone_set("Asia/Bangkok");
          $this->db->from('LMS_CONTENT');
          $this->db->where('con_IsDelete','0');
          $user = $this->session->userdata('user');
          $query = $this->db->get();
          $fetch = $query->result_array();
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $update = '<button type="button" name="update" id="'.$value['con_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['con_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            $output['0'] = "<span style='float:right;'>".$num."</span>";$num++;
            if($lang=="thai"){
              $output['1'] = $value['con_title_th'];
              $output['2'] = $value['con_detail_th'];
            }else{
              $output['1'] = $value['con_title_en'];
              $output['2'] = $value['con_detail_en'];
            }
            if($value['con_datestart']!="0000-00-00 00:00:00"&&$value['con_dateend']!="0000-00-00 00:00:00"){
              $output['3'] = date('d/F/Y H:i',strtotime($value['con_datestart']))." - ".date('d/F/Y H:i',strtotime($value['con_dateend']));
            }else{
              $output['3'] = '-';
            }
            
            if($btn_update!="1"){
              $update = "";
            }
            if($btn_delete!="1"){
              $delete = "";
            }
            $output['4'] = "<center>".$update.$delete."</center>";
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_data_recommended_sites() {
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "setting/recommended_sites";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          date_default_timezone_set("Asia/Bangkok");
          $fetch = $this->func_query->query_result('LMS_WEB','','','','web_isDelete="0"');
          $user = $this->session->userdata('user');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $update = '<button type="button" name="update" id="'.$value['web_id'].'" title="'.label('m_edit').'" class="btn btn-warning btn-xs update"><i class="mdi mdi-lead-pencil"></i></button>';
            $delete = '<button type="button" name="delete" id="'.$value['web_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            $array_pathext = explode('.', $value['web_pathimg']);
            $extension = end($array_pathext);

            if($extension=="mp4"){
              $output['2'] = '<video muted loop alt="First slide" style="width: 100%;"><source src="../uploads/file_forwebrecommended/'.$value['web_pathimg'].'" type="video/mp4"></video>';
            }else{
              $output['2'] = "<img src='../uploads/file_forwebrecommended/".$value['web_pathimg']."' width='100%'>";
            }
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            if($lang=="thai"){
              $output['3'] = $value['web_name_th'];
            }else{
              $output['3'] = $value['web_name_en'];
            }
            
            if($btn_update!="1"){
              $update = "";
            }
            if($btn_delete!="1"){
              $delete = "";
            }
            $output['0'] = "<center>".$update."</center>";
            $output['4'] = "<center>".$delete."</center>";
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

        public function fetch_data_samplecos() {
          $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $page = "setting/sample_course";
          $arr_permission = $this->manage->chk_permission_page();
          $btn_add = $this->manage->chk_permission($page,'ru_add');
          $btn_update = $this->manage->chk_permission($page,'ru_edit');
          $btn_delete = $this->manage->chk_permission($page,'ru_del');
          $btn_view = $this->manage->chk_permission($page,'ru_view');
          date_default_timezone_set("Asia/Bangkok");
          $fetch = $this->func_query->query_result('LMS_COS_HIGHLIGHT','LMS_COS','LMS_COS_HIGHLIGHT.cos_id = LMS_COS.cos_id','','LMS_COS_HIGHLIGHT.coshl_isDelete="0" and LMS_COS.cos_isDelete="0" and LMS_COS.cos_public="1" and LMS_COS.cos_status="1"');
          $user = $this->session->userdata('user');
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
            $delete = '<button type="button" name="delete" id="'.$value['coshl_id'].'" class="btn btn-danger btn-xs delete" title="'.label('delete').'"><i class="mdi mdi-window-close"></i></button>';
            $output = array();
            $output['1'] = "<span style='float:right;'>".$num."</span>";$num++;
            if($lang=="thai"){
              $output['2'] = $value['cname_th'];
            }else{
              $output['2'] = $value['cname_eng'];
            }
            
              $output['3'] = date('d/m/Y H:i',strtotime($value['coshl_createdate']));
            if($btn_update!="1"){
              $update = "";
            }
            if($btn_delete!="1"){
              $delete = "";
            }
            $output['0'] = "<center>".$update.$delete."</center>";
            $count++;
            array_push($fetch_arr, $output);
          }
          return $fetch_arr;
        }

}
