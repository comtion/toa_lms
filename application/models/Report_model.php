<?php
class Report_model extends CI_Model
{
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

    public function fetch_course_company($user,$com_id=""){

          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $this->db->from('LMS_COMPANY');
          if($user['ug_id']!="1"){ 
            $this->db->where('LMS_COMPANY.com_id',$user['com_id']);
          }/*else{
            if($com_id!=""){
            $this->db->where('LMS_COMPANY.com_id',$com_id);
            }
          }*/
            if($com_id!=""){
            $this->db->where('LMS_COMPANY.com_id',$com_id);
            }
          //$this->db->where('LMS_COMPANY.com_admin','com_associated');
          $this->db->where('LMS_COMPANY.com_isDelete','0');
          $this->db->where('LMS_COMPANY.com_status','1');
          $this->db->where('LMS_COMPANY.com_id!=','1');
          $query = $this->db->get();
          $fetch = $query->result_array();
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
              $output = array();
              $numloop = 1;
              if($user['ug_id']=="1"){
                $output['0'] = $lang=="thai"?$value['com_name_th']:$value['com_name_eng'];
              }else{
                $numloop = 0;
              }
              $numaccount = $this->func_query->numrows('LMS_EMP','','','','com_id="'.$value['com_id'].'" and emp_isDelete="0"');
              $numaccount_admin = $this->func_query->numrows('LMS_EMP','','','','com_id="'.$value['com_id'].'" and emp_isDelete="0" and emp_id in (select emp_id from LMS_USP where ug_id in (select ug_id from LMS_USP_GP where Is_admin="1"))');
              if($value['com_admin']=="com_central"){
              $numaccount_instructor = $this->func_query->numrows('LMS_EMP','','','','com_id="'.$value['com_id'].'" and emp_isDelete="0" and emp_id in (select emp_id from LMS_USP where ug_id in (select ug_id from LMS_USP_GP where ug_name_en="Instructor"))');
              $numaccount_learner = $this->func_query->numrows('LMS_EMP','','','','com_id="'.$value['com_id'].'" and emp_isDelete="0" and emp_id in (select emp_id from LMS_USP where ug_id in (5,8))');

              }else{
              $numaccount_instructor = $this->func_query->numrows('LMS_EMP','','','','com_id="'.$value['com_id'].'" and emp_isDelete="0" and emp_id in (select emp_id from LMS_USP where ug_id in (select ug_id from LMS_USP_GP where ug_name_en="Instructor"))');
              $numaccount_learner = $this->func_query->numrows('LMS_EMP','','','','com_id="'.$value['com_id'].'" and emp_isDelete="0" and emp_id in (select emp_id from LMS_USP where ug_id in (4,14))');
              
              }
              $numaccount = $numaccount_admin+$numaccount_instructor+$numaccount_learner;
              $output[$numloop] = "<span style='float:right'>".number_format($numaccount)."</span>";$numloop++;
              $output[$numloop] = "<span style='float:right'>".number_format($numaccount_admin)."</span>";$numloop++;
              $output[$numloop] = "<span style='float:right'>".number_format($numaccount_instructor)."</span>";$numloop++;
              $output[$numloop] = "<span style='float:right'>".number_format($numaccount_learner)."</span>";$numloop++;
              
              $numcourse = $this->func_query->numrows('LMS_COS','','','','com_id="'.$value['com_id'].'" and cos_isDelete="0"');
              $output[$numloop] = "<span style='float:right'>".number_format($numcourse)."</span>";

              /*$this->db->from('LMS_USP');
              $this->db->join('LMS_EMP','LMS_USP.emp_id = LMS_EMP.emp_id');
              $this->db->join('LMS_USP_GP','LMS_USP.ug_id = LMS_USP_GP.ug_id');
              $this->db->where('LMS_EMP.com_id',$value['com_id']);
              $this->db->where('LMS_USP.dummy_status','0');
              $this->db->where('LMS_USP_GP.Is_admin','0');
              $query_user = $this->db->get();
              $num_user = $query_user->num_rows();
              $output['3'] = "<span style='float:right'>".number_format($num_user)."</span>";

              $this->db->from('LMS_COS');
              $this->db->where('LMS_COS.com_id',$value['com_id']);
              $this->db->where('LMS_COS.cos_status','1');
              $query_cos = $this->db->get();
              $num_cos = $query_cos->num_rows();
              $output['4'] = "<span style='float:right'>".number_format($num_cos)."</span>";
              if($lang=="thai"){
                $date_create = date('d',strtotime($value['com_createdate']))." ".$thaimonth[intval(date('m',strtotime($value['com_createdate'])))]." ".(date('Y',strtotime($value['com_createdate'])));
              }else{
                $date_create = date('d F Y',strtotime($value['com_createdate']));
              }
              $output['5'] = $date_create;*/
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
    }

    public function fetch_course_survey($user,$com_id=""){

          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $this->db->from('LMS_COS');
          if($user['com_admin']=="com_associated"||$com_id!=""){ 
            $this->db->where('LMS_COS.com_id',$com_id);
          }
          if($user['ug_id']=="7"||$user['ug_id']=="9"){
            $this->db->where('LMS_COS.cos_createby',$user['u_id']);
          }
          $this->db->join('LMS_COMPANY','LMS_COS.com_id = LMS_COMPANY.com_id');
          $this->db->join('LMS_SURVEY','LMS_COS.cos_id = LMS_SURVEY.cos_id');
          $this->db->where('LMS_COMPANY.com_isDelete','0');
          $this->db->where('LMS_COS.cos_isDelete','0');
          $this->db->where('LMS_SURVEY.sv_status','1');
          $this->db->where('LMS_SURVEY.sv_isDelete','0');
          $query = $this->db->get();
          $fetch = $query->result_array();
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
              $output = array();

              if($lang=="thai"){ 
                $cname = $value['cname_th']!=""?$value['cname_th']:$value['cname_eng'];
                $sv_title = $value['sv_title_th']!=""?$value['sv_title_th']:$value['sv_title_eng'];
              }else{ 
                $cname = $value['cname_eng']!=""?$value['cname_eng']:$value['cname_th'];
                $sv_title = $value['sv_title_eng']!=""?$value['sv_title_eng']:$value['sv_title_th'];
              }
              $numloop = 1;
              if($user['ug_id']=="1"){
                $output['0'] = '<center>'.$value['com_code'].'</center>';
              }else{
                $numloop = 0;
              }
              $output[$numloop] = $cname;$numloop++;
              $output[$numloop] = $sv_title;$numloop++;
              $num_total = $this->func_query->numrows('LMS_QN_USER','','','','sv_id="'.$value['sv_id'].'"');
              $num_complete = $this->func_query->numrows('LMS_QN_USER','','','','sv_id="'.$value['sv_id'].'" and qnu_status="1"');
              $num_incomplete = $this->func_query->numrows('LMS_QN_USER','','','','sv_id="'.$value['sv_id'].'" and qnu_status="0"');
              $output[$numloop] = "<span style='float:right'>".number_format($num_total)."</span>";$numloop++;
              $output[$numloop] = "<span style='float:right'>".number_format($num_complete)."</span>";$numloop++;
              $output[$numloop] = "<span style='float:right'>".number_format($num_incomplete)."</span>";$numloop++;
              $output[$numloop] = '<center><button type="button" name="view_survey" id="'.$value['sv_id'].'" data-toggle="modal" data-target="#modal-survey" class="btn btn-info btn-xs view_survey" title="'.label('r_viewDetail').'"><i class="mdi mdi-format-list-bulleted"></i></button></center>';
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
    }

    public function fetch_coursename_company($user,$com_id="",$cg_id){

          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $this->db->from('LMS_COS');
          if($user['com_admin']=="com_associated"||$com_id!=""){ 
            $this->db->where('LMS_COS.com_id',$com_id);
          }
          if($cg_id!=""){
            $this->db->where('(LMS_COS.cos_id in (select course_id from LMS_COSINCG where cg_id="'.$cg_id.'"))');
          }
          if($user['ug_id']=="7"||$user['ug_id']=="9"){
            $this->db->where('LMS_COS.cos_createby',$user['u_id']);
          }
          $this->db->join('LMS_COMPANY','LMS_COS.com_id = LMS_COMPANY.com_id');
          /*$this->db->where('LMS_COS.cos_status','1');*/
          $this->db->where('LMS_COMPANY.com_isDelete','0');
          $query = $this->db->get();
          $fetch = $query->result_array();
          $num = 1;$count = 0;
          $fetch_arr = array();
          foreach ($fetch as $key => $value) {
              $output = array();
              $output['0'] = '<center><button type="button" name="view_detail" id="'.$value['cos_id'].'" class="btn btn-info btn-xs view_detail" title="'.label('r_viewDetail').'"><i class="mdi mdi-format-list-bulleted"></i></button></center>';
              $output['1'] = $num;$num++;
              if($lang=="thai"){ 
                    $cname = $value['cname_th']!=""?$value['cname_th']:$value['cname_eng'];
                  }else{ 
                    $cname = $value['cname_eng']!=""?$value['cname_eng']:$value['cname_th'];
                  }
              $output['2'] = $cname;
              $average_score = 0;
              $this->db->where('cos_id',$value['cos_id']);
              $this->db->where('cosen_status_sub','1');
              $this->db->where('LMS_COS_ENROLL.cosen_isDelete','0');
              $this->db->from('LMS_COS_ENROLL');
              $query_enroll = $this->db->get();
              $num_enroll = $query_enroll->num_rows();
              if($num_enroll>0){
                $fetch_enroll = $query_enroll->result_array();
                foreach ($fetch_enroll as $key_score => $value_score) {
                  $average_score+=floatval($value_score['cosen_score']);
                }
                if($average_score>0){
                  $average_score = $average_score/$num_enroll;
                }
              }
              $this->db->from('LMS_COS_ENROLL');
              $this->db->where('LMS_COS_ENROLL.cosen_isDelete','0');
              $this->db->where('cos_id',$value['cos_id']);
              $query_enr = $this->db->get();
              $fetch_enr = $query_enr->result_array();
              $complete = 0;
              $inProgress = 0;
              $notStart = 0;
              foreach ($fetch_enr as $key_enr => $value_enr) {
                if($value_enr['cosen_status_sub']=="1"){
                  $complete++;
                }else if($value_enr['cosen_status_sub']=="2"){
                  $inProgress++;
                }else{
                  $notStart++;
                }
              }
              $status_course = label('open');
              $fetch_chk_status = $this->func_query->query_row('LMS_COS_DETAIL','','','','LMS_COS_DETAIL.cos_id = "'.$value['cos_id'].'"');
              if(count($fetch_chk_status)>0){
                if($fetch_chk_status['date_end']!="0000-00-00 00:00:00"&&date('Y-m-d H:i',strtotime($fetch_chk_status['date_end']))<date('Y-m-d H:i')){
                  $status_course = label('sv_b_close');
                }
              }
              if($value['cos_status']=="0"){
                  $status_course = label('sv_b_close');
              }
              $result_chkcg = $this->func_query->numrows('LMS_COSINCG','LMS_COG','LMS_COSINCG.cg_id = LMS_COG.cg_id','','LMS_COSINCG.course_id="'.$value['cos_id'].'" and LMS_COG.cg_status="1" and LMS_COG.cg_approve="1" and LMS_COG.cg_isDelete="0"');
              if($result_chkcg==0){
                  $status_course = label('close');
              }
              if($user['ug_id']=="1"){
                $output['3'] = '<center>'.$value['com_code'].'</center>';
                $output['4'] = '<center>'.$status_course.'</center>';
                $output['5'] = $average_score>0?"<span style='float:right'>".number_format($average_score)."</span>":"<center>-</center>";
                $output['6'] = "<span style='float:right'>".count($fetch_enr)."</span>";
                $output['7'] = "<span style='float:right'>".number_format($complete)."</span>";
                $output['8'] = "<span style='float:right'>".number_format($inProgress)."</span>";
                $output['9'] = "<span style='float:right'>".number_format($notStart)."</span>";
              }else{
                $output['3'] = '<center>'.$status_course.'</center>';
                $output['4'] = $average_score>0?"<span style='float:right'>".number_format($average_score)."</span>":"<center>-</center>";
                $output['5'] = "<span style='float:right'>".count($fetch_enr)."</span>";
                $output['6'] = "<span style='float:right'>".number_format($complete)."</span>";
                $output['7'] = "<span style='float:right'>".number_format($inProgress)."</span>";
                $output['8'] = "<span style='float:right'>".number_format($notStart)."</span>";
              }
              //$output['2'] = $lang=="thai"?$value['com_name_th']:$value['com_name_eng'];


              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
    }
    
      function fetch_Suggestion($svde_id){
        $this->db->select("qnude_suggestion"); 
        $this->db->from('LMS_QN_USER_DE');
        $this->db->where('svde_id', $svde_id);
        $this->db->where_not_in('qnude_suggestion', "");
        $query = $this->db->get();
        return $query->result();
      }


      function fetch_Suggestion_head($sv_id){
        $this->db->select("qnu_suggestion"); 
        $this->db->from('LMS_QN_USER');
        $this->db->where('sv_id', $sv_id);
        $this->db->where_not_in('qnu_suggestion', "");
        $query = $this->db->get();
        return $query->result();
      }


    public function fetch_course_student($user,$com_id="",$dep_id="",$cos_id="",$course_status="",$cosen_status_sub="",$date_start="",$date_end=""){

          date_default_timezone_set("Asia/Bangkok");
          $sess = $this->session->userdata('user');
          $date_now = date('Y-m-d H:i');
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $this->db->from('LMS_COS_ENROLL');
          $this->db->join('LMS_COS','LMS_COS_ENROLL.cos_id = LMS_COS.cos_id');
          $this->db->join('LMS_COMPANY','LMS_COS.com_id = LMS_COMPANY.com_id');
          $this->db->join('LMS_EMP','LMS_COS_ENROLL.emp_id = LMS_EMP.emp_id');
          //$this->db->where('LMS_COMPANY.com_admin','com_associated');
          $user = $this->session->userdata('user');
          $this->db->where('LMS_COMPANY.com_isDelete','0');
          $this->db->where('LMS_COS.cos_isDelete','0');
          $this->db->where('LMS_EMP.emp_isDelete','0');
          $this->db->where('LMS_COS_ENROLL.cosen_isDelete','0');
          $this->db->where('cos_public','1');
          /*if(intval($user['ug_id'])>3){
              $com_id = $user['com_id'];
          }
          if($com_id!=""){
            $this->db->where('LMS_COS.com_id',$com_id);
          }
          if($dep_id!=""){
            $where_dep = '(LMS_EMP.emp_id in (select LMS_USP.emp_id from LMS_USP where LMS_USP.dep_id="'.$dep_id.'"))';
            $this->db->where($where_dep);
          }*/
          $where_emp = '(LMS_EMP.emp_manage_a ="'.$sess['emp_c'].'") and (LMS_EMP.emp_manage_a != LMS_EMP.emp_c)';
          $this->db->where($where_emp);
          if($course_status!=""){
            if($course_status=="1"){
              //$this->db->where('LMS_COS.cos_status','1');
              $where = 'LMS_COS.cos_id in (select LMS_COS_DETAIL.cos_id from LMS_COS_DETAIL where ((LMS_COS_DETAIL.date_end="0000-00-00 00:00:00") or (LMS_COS_DETAIL.date_end >= "'.$date_now.'")) and cos_status="1" and cosde_isDelete="0")';
              $this->db->where($where);
            }else{
              //$this->db->where('LMS_COS.cos_status','0');
              $where = 'LMS_COS.cos_id in (select LMS_COS_DETAIL.cos_id from LMS_COS_DETAIL where LMS_COS_DETAIL.date_end!="0000-00-00 00:00:00" and LMS_COS_DETAIL.date_end < "'.$date_now.'" and cosde_status="1" and cosde_isDelete="0")';
              $this->db->where($where);
            }
          }
          if($cos_id!=""){
            $this->db->where('LMS_COS_ENROLL.cos_id',$cos_id);
          }
          if($cosen_status_sub!=""){
            if($cosen_status_sub=="0"){
            $this->db->where('LMS_COS_ENROLL.cosen_status_sub','0');
            //$this->db->where('LMS_COS_ENROLL.cosen_firsttime','0000-00-00 00:00:00');
            }else if($cosen_status_sub=="2"){
            //$this->db->where('LMS_COS_ENROLL.cosen_firsttime!=','0000-00-00 00:00:00');
            $this->db->where('LMS_COS_ENROLL.cosen_status_sub','2');
            }else{
            $this->db->where('LMS_COS_ENROLL.cosen_status_sub',$cosen_status_sub);
            }
          }
          if($date_start!=""&&$date_end!=""){
            $where = "(LMS_COS_ENROLL.cosen_finishtime BETWEEN '".$date_start."' AND '".$date_end."')";
            $this->db->where($where);
          }
          $query = $this->db->get();
          $fetch = $query->result_array();
          $num = 1;$count = 0;
          $fetch_arr = array();
          

          if($course_status!=""){
            if($course_status=="1"){
              foreach ($fetch as $key => $value) {
                $result_chkcg = $this->func_query->numrows('LMS_COSINCG','LMS_COG','LMS_COSINCG.cg_id = LMS_COG.cg_id','','LMS_COSINCG.course_id="'.$value['cos_id'].'" and LMS_COG.cg_status="1" and LMS_COG.cg_approve="1" and LMS_COG.cg_isDelete="0"');
                if($result_chkcg==0){
                  unset($fetch[$key]);
                }
              }
            }
          }
          foreach ($fetch as $key => $value) {
              $where_shlg = 'cos_id = "'.$value['cos_id'].'" and qiz_id in (select LMS_QUES.qiz_id from LMS_QUES where ques_type in ("sa","sub") and ques_isDelete="0")';
              $fetch_chk_shlg = $this->func_query->numrows('LMS_QIZ','','','',$where_shlg);
              $output = array();
              $output['0'] = $fetch_chk_shlg>0&&$value['cosen_status_sub']=="1"?'<center><button type="button" name="view_answer" id="'.$value['cosen_id'].'" data-toggle="modal" data-target="#modal-view_answer" class="btn btn-info btn-xs view_answer" title="'.label('answer').'"><i class="mdi mdi-comment-text-outline"></i></button></center>':'<center>-</center>';
              $output['1'] = $num;$num++;
              $output['2'] = $value['emp_c'];
              $output['3'] = $lang=="thai"?$value['fullname_th']:$value['fullname_en'];

              if($lang=="thai"){ 
                $cname = $value['cname_th']!=""?$value['cname_th']:$value['cname_eng'];
                $cname = $cname!=""?$cname:$value['cname_jp'];
              }else if($lang=="english"){ 
                $cname = $value['cname_eng']!=""?$value['cname_eng']:$value['cname_th'];
                $cname = $cname!=""?$cname:$value['cname_jp'];
              }else{
                $cname = $value['cname_jp']!=""?$value['cname_jp']:$value['cname_eng'];
                $cname = $cname!=""?$cname:$value['cname_th'];
              }

              $output['4'] = $cname;
              $fetch_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id="'.$value['cos_id'].'" and cosde_isDelete="0"');
              $cos_status = label('open');
              if(count($fetch_detail)>0){
                if($fetch_detail['date_end']!="0000-00-00 00:00:00"&&date('Y-m-d H:i')>date('Y-m-d H:i',strtotime($fetch_detail['date_end']))){
                  $cos_status = label('sv_b_close');
                }
              }
              $result_chkcg = $this->func_query->numrows('LMS_COSINCG','LMS_COG','LMS_COSINCG.cg_id = LMS_COG.cg_id','','LMS_COSINCG.course_id="'.$value['cos_id'].'" and LMS_COG.cg_status="1" and LMS_COG.cg_approve="1" and LMS_COG.cg_isDelete="0"');
              if($result_chkcg==0){
                  $cos_status = label('sv_b_close');
              }
              if($value['cos_status']=="0"){
                  $cos_status = label('sv_b_close');
              }
              $output['5'] = $cos_status;
              if($value['cosen_status_sub']=="0"){
                $output['6'] = label('not_start');
              }else if($value['cosen_status_sub']=="1"){
                $output['6'] = label('r_pass');
              }else if($value['cosen_status_sub']=="2"){
                /*if($value['cosen_firsttime']=="0000-00-00 00:00:00"){
                  $output['6'] = label('not_start');
                }else{*/
                  $output['6'] = label('inProgress');
                //}
              }else{
                $output['6'] = label('not_start');
              }
              $score_pretest = 0;
              $score_posttest = 0;
              $score_pretest_full = 0;
              $score_posttest_full = 0;
              $fetch_pretest = $this->func_query->query_result('LMS_QIZ','','','','cos_id="'.$value['cos_id'].'" and quiz_type="1" and quiz_status="1" and quiz_isDelete="0"');
              $fetch_posttest = $this->func_query->query_result('LMS_QIZ','','','','cos_id="'.$value['cos_id'].'" and quiz_type="2" and quiz_status="1" and quiz_isDelete="0"');
              if(count($fetch_pretest)>0){
                  foreach ($fetch_pretest as $key_pretest => $value_pretest) {
                      $sum_score_all = 0;
                      $sum_score_quesall = 0;
                      $fetch_chkpretest = $this->func_query->query_row('LMS_QIZ_TC','','','','LMS_QIZ_TC.cosen_id="'.$value['cosen_id'].'" and LMS_QIZ_TC.qiz_id="'.$value_pretest['qiz_id'].'" and qiztc_isDelete="0" and qiz_status="3"','qiztc_id DESC');
                      if(count($fetch_chkpretest)>0){

                        $fetch_chkques = $this->func_query->query_result('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_pretest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
                        if(count($fetch_chkques)>0){
                            foreach ($fetch_chkques as $key_chkques => $value_chkques) {
                                $fetch_tc = $this->func_query->query_row('LMS_QUES_TC','','','','LMS_QUES_TC.ques_id="'.$value_chkques['ques_id'].'"  and LMS_QUES_TC.cosen_id="'.$value['cosen_id'].'" and LMS_QUES_TC.qiztc_id="'.$fetch_chkpretest['qiztc_id'].'"');
                                if(count($fetch_tc)>0){
                                $score_pretest+=floatval($fetch_tc['tc_score']);
                                }else{
                                $score_pretest+=0;
                                }
                                $sum_score_all+=floatval($value_chkques['ques_score']);
                            }
                        }
                      }else{
                        $fetch_chkques = $this->func_query->query_result('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_pretest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
                        if(count($fetch_chkques)>0){
                            foreach ($fetch_chkques as $key_chkques => $value_chkques) {
                                $sum_score_quesall+=floatval($value_chkques['ques_score']);
                            }
                        }
                      }


                      $fetch_sum = $this->func_query->query_row('LMS_QUES','','','','qiz_id="'.$value_pretest['qiz_id'].'" and ques_id in (select LMS_QUES_TC.ques_id from LMS_QUES_TC where qiz_id="'.$value_pretest['qiz_id'].'" and cosen_id="'.$value['cosen_id'].'") and ques_status="1" and ques_isDelete="0"','','SUM(ques_score) as total_score');

                      if(count($fetch_sum)>0){
                        $score_pretest_full += count($fetch_sum)>0&&floatval($fetch_sum['total_score'])>0?floatval($fetch_sum['total_score']):$sum_score_quesall;
                      }else{
                        $score_pretest_full += $value_pretest['quiz_numofshown']==count($fetch_chkques)?$sum_score_all:$sum_score_quesall;
                      }
                  }
              }
              if(count($fetch_posttest)>0){
                  foreach ($fetch_posttest as $key_posttest => $value_posttest) {
                      $sum_score_all = 0;
                      $sum_score_quesall = 0;
                      $fetch_chkposttest = $this->func_query->query_row('LMS_QIZ_TC','','','','LMS_QIZ_TC.cosen_id="'.$value['cosen_id'].'" and LMS_QIZ_TC.qiz_id="'.$value_posttest['qiz_id'].'" and qiztc_isDelete="0" and qiz_status="3"','qiztc_id DESC');
                      if(count($fetch_chkposttest)>0){

                        $fetch_chkques = $this->func_query->query_result('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_posttest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
                        if(count($fetch_chkques)>0){
                            foreach ($fetch_chkques as $key_chkques => $value_chkques) {
                                $fetch_tc = $this->func_query->query_row('LMS_QUES_TC','','','','LMS_QUES_TC.ques_id="'.$value_chkques['ques_id'].'"  and LMS_QUES_TC.cosen_id="'.$value['cosen_id'].'" and LMS_QUES_TC.qiztc_id="'.$fetch_chkposttest['qiztc_id'].'"');
                                if(count($fetch_tc)>0){
                                $score_posttest+=floatval($fetch_tc['tc_score']);
                                }else{
                                $score_posttest+=0;
                                }
                                $sum_score_all+=floatval($value_chkques['ques_score']);
                            }
                        }
                      }else{
                        $fetch_chkques = $this->func_query->query_result('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_posttest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
                        if(count($fetch_chkques)>0){
                            foreach ($fetch_chkques as $key_chkques => $value_chkques) {
                                $sum_score_quesall+=floatval($value_chkques['ques_score']);
                            }
                        }
                      }
                      $fetch_sum = $this->func_query->query_row('LMS_QUES','','','','qiz_id="'.$value_posttest['qiz_id'].'" and ques_id in (select LMS_QUES_TC.ques_id from LMS_QUES_TC where qiz_id="'.$value_posttest['qiz_id'].'" and cosen_id="'.$value['cosen_id'].'") and ques_status="1" and ques_isDelete="0"','','SUM(ques_score) as total_score');
                      
                      if(count($fetch_sum)>0){
                        $score_posttest_full += count($fetch_sum)>0&&floatval($fetch_sum['total_score'])>0?floatval($fetch_sum['total_score']):$sum_score_quesall;
                      }else{
                        $score_posttest_full += $sum_score_quesall;
                      }
                  }
              }
              $fetch_qiz = $this->func_query->numrows('LMS_QIZ','','','','cos_id="'.$value['cos_id'].'" and quiz_status="1" and quiz_isDelete="0"');
             /* $output['6'] = "<span style='float:right'>".number_format($score_pretest)."</span>";
              $output['7'] = "<span style='float:right'>".number_format($score_posttest)."</span>";  
              $output['8'] = "<span style='float:right'>".number_format($score_pretest)."</span>";
              $output['9'] = "<span style='float:right'>".number_format($score_posttest_full)."</span>"; */

              $output['7'] = "<span style='float:right'>".number_format($score_pretest)."</span>";
              $output['8'] = "<span style='float:right'>".number_format($score_pretest_full)."</span>";   
              if($fetch_qiz>0){
                $output['9'] = "<span style='float:right'>".number_format($score_posttest)."</span>";
                $output['10'] = "<span style='float:right'>".number_format($score_posttest_full)."</span>";  
              }else{
                if($value['cosen_status_sub']!="1"){
                $output['9'] = "<span style='float:right'>0</span>";
                $output['10'] = "<span style='float:right'>0</span>";
                }else{
                $output['9'] = "<span style='float:right'>".number_format($value['cosen_score'])."</span>";
                $max_score = number_format($value['max_score'])==0?number_format('100'):number_format($value['max_score']);
                $output['10'] = "<span style='float:right'>".$max_score."</span>";  
                }
              }
              $preReport = '-'; 
                $var_rechk = 1;
                $fetch_chkques_shlo = $this->func_query->query_result('LMS_QUES','','','','ques_type in ("sub","sa") and qiz_id in (select LMS_QIZ.qiz_id from LMS_QIZ where LMS_QIZ.cos_id = "'.$value['cos_id'].'") and ques_isDelete="0"');
                if(count($fetch_chkques_shlo)>0){
                  foreach ($fetch_chkques_shlo as $key_chkques_shlo => $value_chkques_shlo) {
                      $fetch_chktc = $this->func_query->query_row('LMS_QUES_TC','','','','LMS_QUES_TC.ques_id="'.$value_chkques_shlo['ques_id'].'"  and LMS_QUES_TC.cosen_id="'.$value['cosen_id'].'"','LMS_QUES_TC.tc_id DESC'); 
                      if(count($fetch_chktc)>0){
                        if($fetch_chktc['tc_isSavescore']=="0"){
                          $var_rechk = 0;
                        }
                      }
                  }
                }
              if($value['cosen_status_sub']=="1"&&$var_rechk==1){
                if($value['cos_typegrading']=="1"){
                    $preReport = $value['cosen_grade']!=""?$value['cosen_grade']:'-'; 
                }else{
                  if(intval($value['cosen_score_per'])>=intval($value['goal_score'])){
                    $preReport = label('pass'); 
                  }else{
                    $preReport = label('fail'); 
                  }
                }
              }
              $output['11'] = "<center>".$preReport."</center>";  
               /*
              $output['9'] = "<span style='float:right'>".number_format($value['cosen_score'])."</span>";  */
              if($sess['is_manager']!="1"){
             /* if($lang=="thai"){
              $output['11'] = $value['cosen_finishtime']!="0000-00-00 00:00:00"?date('d',strtotime($value['cosen_finishtime']))." ".$thaimonth[intval(date('m',strtotime($value['cosen_finishtime'])))]." ".(date('d',strtotime($value['cosen_finishtime']))+543)." ".date('H:i',strtotime($value['cosen_finishtime'])):"<center>-</center>";
              }else{
              $output['11'] = $value['cosen_finishtime']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($value['cosen_finishtime'])):"<center>-</center>";
              }*/
              $output['12'] = $value['cosen_finishtime']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['cosen_finishtime'])):"<center>-</center>";
              }
              /*$this->db->from('LMS_USP');
              $this->db->join('LMS_USP_GP','LMS_USP.ug_id = LMS_USP_GP.ug_id');
              $this->db->where('LMS_USP.emp_id',$value['emp_id']);
              $query_usp = $this->db->get();
              $fetch_usp = $query_usp->row_array();
              $cosen_reward = intval($value['cosen_reward']) == 0 ? "-" : number_format($value['cosen_reward']);
              if($btn_status==""){
                $cosen_pfm = "";
                if(intval($value['cosen_pfm']) == 0){
                    for ($i=0; $i < 5; $i++) { 
                      $cosen_pfm .= '<i class="mdi mdi-star text-default"></i>';
                    }
                }else{
                  for ($i=0; $i < intval($value['cosen_pfm']); $i++) { 
                    $cosen_pfm .= '<i class="mdi mdi-star text-warning"></i>';
                  }
                  $num_point = 5-intval($value['cosen_pfm']);
                  if($num_point>0){
                    for ($i=0; $i < $num_point; $i++) { 
                      $cosen_pfm .= '<i class="mdi mdi-star text-default"></i>';
                    }
                  }
                }
                //$cosen_pfm = intval($value['cosen_pfm']) == 0 ? "-" : number_format($value['cosen_pfm']);
              }else{
                $cosen_pfm = "";
                if(intval($value['cosen_pfm']) == 0){
                  $cosen_pfm ='<input type="hidden" id="php1_hidden'.$value['cosen_id'].'" value="1"><i class="mdi mdi-star php1'.$value['cosen_id'].'" onclick="change(this.title,this.id)" title="php1" id="'.$value['cosen_id'].'"></i><input type="hidden" id="php2_hidden'.$value['cosen_id'].'" value="2"><i class="mdi mdi-star php2'.$value['cosen_id'].'" onclick="change(this.title,this.id)" title="php2" id="'.$value['cosen_id'].'"></i><input type="hidden" id="php3_hidden'.$value['cosen_id'].'" value="3"><i class="mdi mdi-star php3'.$value['cosen_id'].'" onclick="change(this.title,this.id)" title="php3" id="'.$value['cosen_id'].'"></i><input type="hidden" id="php4_hidden'.$value['cosen_id'].'" value="4"><i class="mdi mdi-star php4'.$value['cosen_id'].'" onclick="change(this.title,this.id)" title="php4" id="'.$value['cosen_id'].'"></i><input type="hidden" id="php5_hidden'.$value['cosen_id'].'" value="5"><i class="mdi mdi-star php5'.$value['cosen_id'].' p-r-10" onclick="change(this.title,this.id)" title="php5" id="'.$value['cosen_id'].'"></i><input type="hidden" name="phprating[]" id="phprating'.$value['cosen_id'].'" value="0"><input type="hidden" name="emp_id[]" id="emp_id" value="'.$value['emp_id'].'"><input type="hidden" name="cos_id[]" id="cos_id" value="'.$value['cos_id'].'">';  
                }else{
                  for ($i=1; $i <= intval($value['cosen_pfm']); $i++) { 
                    $cosen_pfm .= '<input type="hidden" id="php'.$i.'_hidden'.$value['cosen_id'].'" value="'.$i.'"><i class="mdi mdi-star text-warning php'.$i.''.$value['cosen_id'].'" onclick="change(this.title,this.id)" title="php'.$i.'" id="'.$value['cosen_id'].'"></i>';
                  }
                  $num_point = 5-intval($value['cosen_pfm']);
                  if($num_point>0){
                    for ($i=intval($value['cosen_pfm'])+1; $i <= 5; $i++) { 
                      $cosen_pfm .= '<input type="hidden" id="php'.$i.'_hidden'.$value['cosen_id'].'" value="'.$i.'"><i class="mdi mdi-star text-default php'.$i.''.$value['cosen_id'].'" onclick="change(this.title,this.id)" title="php'.$i.'" id="'.$value['cosen_id'].'"></i>';
                    }
                  }
                  $cosen_pfm .= '<input type="hidden" name="phprating[]" id="phprating'.$value['cosen_id'].'" value="'.(intval($value['cosen_pfm'])).'"><input type="hidden" name="emp_id[]" id="emp_id" value="'.$value['emp_id'].'"><input type="hidden" name="cos_id[]" id="cos_id" value="'.$value['cos_id'].'">';
                }
              }
              */
                                  


              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
    }

    public function fetch_coursename_detail($user,$cos_id=""){

          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          $fetch = $this->func_query->query_result('LMS_COS_ENROLL','LMS_EMP','LMS_COS_ENROLL.emp_id = LMS_EMP.emp_id','','cos_id="'.$cos_id.'" and cosen_isDelete="0"');
          //$this->db->where('LMS_COMPANY.com_admin','com_associated');
          $user = $this->session->userdata('user');
          if(intval($user['ug_id'])>3){
              $com_id = $user['com_id'];
          }
          $num = 1;$count = 0;
          $fetch_arr = array();
          $fetch_qiz = $this->func_query->numrows('LMS_QIZ','','','','cos_id="'.$cos_id.'" and quiz_isDelete="0"');
          $fetch_pretest = $this->func_query->query_result('LMS_QIZ','','','','cos_id="'.$cos_id.'" and quiz_type="1" and quiz_status="1" and quiz_isDelete="0"');
          $fetch_posttest = $this->func_query->query_result('LMS_QIZ','','','','cos_id="'.$cos_id.'" and quiz_type="2" and quiz_status="1" and quiz_isDelete="0"');
          $fetch_cos = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');
          foreach ($fetch as $key => $value) {
              $fetch_company = $this->func_query->query_row('LMS_COMPANY','','','','com_id = "'.$value['com_id'].'"');
              $fetch_user = $this->func_query->query_row('LMS_EMP','LMS_POSITION','LMS_EMP.posi_id = LMS_POSITION.posi_id','','LMS_EMP.emp_id = "'.$value['emp_id'].'"');
              $output = array();
              $output['0'] = $value['emp_c'];              
              $output['1'] = $lang=="thai"?$value['fullname_th']:$value['fullname_en'];
              $output['2'] = $lang=="thai"?$fetch_company['com_name_th']:$fetch_company['com_name_eng'];
              $output['3'] = $lang=="thai"?$fetch_user['posi_name_th']:$fetch_user['posi_name_en'];
                                  
              if($value['cosen_status_sub']=="0"){
                $output['4'] = "<center>".label('not_start')."</center>";
              }else if($value['cosen_status_sub']=="1"){
                $output['4'] = "<center>".label('r_pass')."</center>";
              }else if($value['cosen_status_sub']=="2"){
                /*if($value['cosen_firsttime']=="0000-00-00 00:00:00"){
                  $output['4'] = "<center>".label('not_start')."</center>";
                }else{*/
                  $output['4'] = "<center>".label('inProgress')."</center>";
                //}
              }else{
                $output['4'] = "<center>".label('not_start')."</center>";
              }
              $score_pretest = 0;
              $score_posttest = 0;
              $score_pretest_full = 0;
              $score_posttest_full = 0;
              if(count($fetch_pretest)>0){
                  foreach ($fetch_pretest as $key_pretest => $value_pretest) {
                      $sum_score_all = 0;
                      $sum_score_quesall = 0;
                      $fetch_chkpretest = $this->func_query->query_row('LMS_QIZ_TC','','','','LMS_QIZ_TC.cosen_id="'.$value['cosen_id'].'" and LMS_QIZ_TC.qiz_id="'.$value_pretest['qiz_id'].'" and qiztc_isDelete="0" and qiz_status="3"','qiztc_id DESC');
                      if(count($fetch_chkpretest)>0){

                        $fetch_chkques = $this->func_query->query_result('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_pretest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
                        if(count($fetch_chkques)>0){
                            foreach ($fetch_chkques as $key_chkques => $value_chkques) {
                                $fetch_tc = $this->func_query->query_row('LMS_QUES_TC','','','','LMS_QUES_TC.ques_id="'.$value_chkques['ques_id'].'"  and LMS_QUES_TC.cosen_id="'.$value['cosen_id'].'" and LMS_QUES_TC.qiztc_id="'.$fetch_chkpretest['qiztc_id'].'"');
                                if(count($fetch_tc)>0){
                                $score_pretest+=floatval($fetch_tc['tc_score']);
                                }else{
                                $score_pretest+=0;
                                }
                                $sum_score_all+=floatval($value_chkques['ques_score']);
                            }
                        }
                      }else{
                        $fetch_chkques = $this->func_query->query_result('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_pretest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
                        if(count($fetch_chkques)>0){
                            foreach ($fetch_chkques as $key_chkques => $value_chkques) {
                                $sum_score_quesall+=floatval($value_chkques['ques_score']);
                            }
                        }
                      }
                      $fetch_sum = $this->func_query->query_row('LMS_QUES','','','','qiz_id="'.$value_pretest['qiz_id'].'" and ques_id in (select LMS_QUES_TC.ques_id from LMS_QUES_TC where qiz_id="'.$value_pretest['qiz_id'].'" and cosen_id="'.$value['cosen_id'].'") and ques_status="1" and ques_isDelete="0"','','SUM(ques_score) as total_score');
                      if(count($fetch_sum)>0){
                        $score_pretest_full += count($fetch_sum)>0&&floatval($fetch_sum['total_score'])>0?floatval($fetch_sum['total_score']):$sum_score_quesall;
                      }else{
                        $score_pretest_full += $value_pretest['quiz_numofshown']==count($fetch_chkques)?$sum_score_all:$sum_score_quesall;
                      }
                  }
              }
              if(count($fetch_posttest)>0){
                  foreach ($fetch_posttest as $key_posttest => $value_posttest) {
                      $sum_score_all = 0;
                      $sum_score_quesall = 0;
                      $fetch_chkposttest = $this->func_query->query_row('LMS_QIZ_TC','','','','LMS_QIZ_TC.cosen_id="'.$value['cosen_id'].'" and LMS_QIZ_TC.qiz_id="'.$value_posttest['qiz_id'].'" and qiztc_isDelete="0" and qiz_status="3"','qiztc_id DESC');
                      if(count($fetch_chkposttest)>0){

                        $fetch_chkques = $this->func_query->query_result('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_posttest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
                        if(count($fetch_chkques)>0){
                            foreach ($fetch_chkques as $key_chkques => $value_chkques) {
                                $fetch_tc = $this->func_query->query_row('LMS_QUES_TC','','','','LMS_QUES_TC.ques_id="'.$value_chkques['ques_id'].'"  and LMS_QUES_TC.cosen_id="'.$value['cosen_id'].'" and LMS_QUES_TC.qiztc_id="'.$fetch_chkposttest['qiztc_id'].'"');
                                if(count($fetch_tc)>0){
                                $score_posttest+=floatval($fetch_tc['tc_score']);
                                }else{
                                $score_posttest+=0;
                                }
                                $sum_score_all+=floatval($value_chkques['ques_score']);
                            }
                        }
                      }else{
                        $fetch_chkques = $this->func_query->query_result('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_posttest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
                        if(count($fetch_chkques)>0){
                            foreach ($fetch_chkques as $key_chkques => $value_chkques) {
                                $sum_score_quesall+=floatval($value_chkques['ques_score']);
                            }
                        }
                      }
                      $fetch_sum = $this->func_query->query_row('LMS_QUES','','','','qiz_id="'.$value_posttest['qiz_id'].'" and ques_id in (select LMS_QUES_TC.ques_id from LMS_QUES_TC where qiz_id="'.$value_posttest['qiz_id'].'" and cosen_id="'.$value['cosen_id'].'") and ques_status="1" and ques_isDelete="0"','','SUM(ques_score) as total_score');
                      if(count($fetch_sum)>0){
                        $score_posttest_full += count($fetch_sum)>0&&floatval($fetch_sum['total_score'])>0?floatval($fetch_sum['total_score']):$sum_score_quesall;
                      }else{
                        $score_posttest_full += $sum_score_quesall;
                      }
                  }
              }

              $output['5'] = "<span style='float:right'>".number_format($score_pretest)."</span>";
              $output['6'] = "<span style='float:right'>".number_format($score_pretest_full)."</span>";   
              if($fetch_qiz>0){
                $output['7'] = "<span style='float:right'>".number_format($score_posttest)."</span>";
                $output['8'] = "<span style='float:right'>".number_format($score_posttest_full)."</span>";  
              }else{
                if($value['cosen_status_sub']!="1"){
                $output['7'] = "<span style='float:right'>0</span>";
                $output['8'] = "<span style='float:right'>0</span>";
                }else{
                $output['7'] = "<span style='float:right'>".number_format($value['cosen_score'])."</span>";
                $max_score = number_format($fetch_cos['max_score'])==0?number_format('100'):number_format($fetch_cos['max_score']);
                $output['8'] = "<span style='float:right'>".$max_score."</span>";  
                }
              } 
              $preReport = '-'; 
              $var_rechk=1;
                $fetch_chkques_shlo = $this->func_query->query_result('LMS_QUES','','','','ques_type in ("sub","sa") and qiz_id in (select LMS_QIZ.qiz_id from LMS_QIZ where LMS_QIZ.cos_id = "'.$value['cos_id'].'") and ques_isDelete="0"');
                if(count($fetch_chkques_shlo)>0){
                  foreach ($fetch_chkques_shlo as $key_chkques_shlo => $value_chkques_shlo) {
                      $fetch_chktc = $this->func_query->query_row('LMS_QUES_TC','','','','LMS_QUES_TC.ques_id="'.$value_chkques_shlo['ques_id'].'"  and LMS_QUES_TC.cosen_id="'.$value['cosen_id'].'"','LMS_QUES_TC.tc_id DESC'); 
                      if(count($fetch_chktc)>0){
                        if($fetch_chktc['tc_isSavescore']=="0"){
                          $var_rechk = 0;
                        }
                      }
                  }
                }
              if($value['cosen_status_sub']=="1"&&$var_rechk==1){

                if($fetch_cos['cos_typegrading']=="1"){
                    $preReport = $value['cosen_grade']!=""?$value['cosen_grade']:'-'; 
                }else{
                  if(intval($value['cosen_score_per'])>=intval($fetch_cos['goal_score'])){
                    $preReport = label('pass'); 
                  }else{
                    $preReport = label('fail'); 
                  }
                }
              }
              $output['9'] = "<center>".$preReport."</center>";  

              /*if($lang=="thai"){
              $output['10'] = $value['cosen_finishtime']!="0000-00-00 00:00:00"?date('d',strtotime($value['cosen_finishtime']))." ".$thaimonth[intval(date('m',strtotime($value['cosen_finishtime'])))]." ".(date('d',strtotime($value['cosen_finishtime']))+543)." ".date('H:i',strtotime($value['cosen_finishtime'])):"<center>-</center>";
              }else{
              $output['10'] = $value['cosen_finishtime']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($value['cosen_finishtime'])):"<center>-</center>";
              }
*/
              $output['10'] = $value['cosen_finishtime']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['cosen_finishtime'])):"<center>-</center>";
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
    }

    public function fetch_course_personal($user,$course_status="",$cosen_status_sub="",$date_start="",$date_end=""){

          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
          $this->load->model('Manage_model', 'manage', FALSE);
          $this->load->model('Function_query_model', 'func_query', FALSE);
          $this->manage->loadDB();
          date_default_timezone_set("Asia/Bangkok");
          $date_end = $date_end!=""&&$date_end!="0000-00-00 00:00:00"?$date_end:date('Y-m-d H:i');
          $this->db->from('LMS_COS_ENROLL');
          $this->db->join('LMS_COS','LMS_COS_ENROLL.cos_id = LMS_COS.cos_id');
          $this->db->join('LMS_COMPANY','LMS_COS.com_id = LMS_COMPANY.com_id');
          $this->db->join('LMS_EMP','LMS_COS_ENROLL.emp_id = LMS_EMP.emp_id');
          $this->db->where('LMS_COS_ENROLL.emp_id',$user['emp_id']);
          $this->db->where('LMS_COS.cos_isDelete','0');
          $this->db->where('LMS_EMP.emp_isDelete','0');
          $this->db->where('LMS_COMPANY.com_isDelete','0');
          $this->db->where('LMS_COS_ENROLL.cosen_isDelete','0');
          $this->db->where('LMS_COS.cos_public','1');
          if($course_status!=""){
            if($course_status=="1"){
              //$this->db->where('LMS_COS.cos_status','1');
              $where = 'LMS_COS.cos_id in (select LMS_COS_DETAIL.cos_id from LMS_COS_DETAIL where ((LMS_COS_DETAIL.date_end="0000-00-00 00:00:00") or (LMS_COS_DETAIL.date_end >= "'.$date_end.'")) and cos_status="1" and cosde_isDelete="0")';
              $this->db->where($where);
            }else{
              //$this->db->where('LMS_COS.cos_status','0');
              $where = 'LMS_COS.cos_id in (select LMS_COS_DETAIL.cos_id from LMS_COS_DETAIL where LMS_COS_DETAIL.date_end!="0000-00-00 00:00:00" and LMS_COS_DETAIL.date_end < "'.$date_end.'" and cosde_status="1" and cosde_isDelete="0")';
              $this->db->where($where);
            }
          }
          if($cosen_status_sub!=""){
            if($cosen_status_sub=="0"){
            $this->db->where('LMS_COS_ENROLL.cosen_status_sub','0');
            //$this->db->where('LMS_COS_ENROLL.cosen_firsttime','0000-00-00 00:00:00');
            }else if($cosen_status_sub=="2"){
           // $this->db->where('LMS_COS_ENROLL.cosen_firsttime!=','0000-00-00 00:00:00');
            $this->db->where('LMS_COS_ENROLL.cosen_status_sub','2');
            }else{
            $this->db->where('LMS_COS_ENROLL.cosen_status_sub',$cosen_status_sub);
            }
          }
          if($date_start!=""&&$date_end!=""){
            $where = "(LMS_COS_ENROLL.cosen_finishtime BETWEEN '".$date_start."' AND '".$date_end."')";
            $this->db->where($where);
          }
          $query = $this->db->get();
          $fetch = $query->result_array();
          $num = 1;$count = 0;
          $fetch_arr = array();

          if($course_status!=""){
            if($course_status=="1"){
              foreach ($fetch as $key => $value) {
                $result_chkcg = $this->func_query->numrows('LMS_COSINCG','LMS_COG','LMS_COSINCG.cg_id = LMS_COG.cg_id','','LMS_COSINCG.course_id="'.$value['cos_id'].'" and LMS_COG.cg_status="1" and LMS_COG.cg_approve="1" and LMS_COG.cg_isDelete="0"');
                if($result_chkcg==0){
                  unset($fetch[$key]);
                }
              }
            }
          }
          foreach ($fetch as $key => $value) {
              $fetch_qiz = $this->func_query->numrows('LMS_QIZ','','','','cos_id="'.$value['cos_id'].'" and quiz_isDelete="0"');
              $average_score = 0;
              if($lang=="thai"){ 
                $cname = $value['cname_th']!=""?$value['cname_th']:$value['cname_eng'];
              }else{ 
                $cname = $value['cname_eng']!=""?$value['cname_eng']:$value['cname_th'];
              }

              $where_shlg = 'cos_id = "'.$value['cos_id'].'" and qiz_id in (select LMS_QUES.qiz_id from LMS_QUES where ques_type in ("sa","sub") and ques_isDelete="0")';
              $fetch_chk_shlg = $this->func_query->numrows('LMS_QIZ','','','',$where_shlg);
              $output = array();
              $output['0'] = $fetch_chk_shlg>0&&$value['cosen_status_sub']=="1"?'<center><button type="button" name="view_answer" id="'.$value['cosen_id'].'" data-toggle="modal" data-target="#modal-view_answer" class="btn btn-info btn-xs view_answer" title="'.label('answer').'"><i class="mdi mdi-comment-text-outline"></i></button></center>':'<center>-</center>';

              $output['1'] = $cname;
              $fetch_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id="'.$value['cos_id'].'" and cosde_isDelete="0"');
              $cos_status = label('open');
              if(count($fetch_detail)>0){
                if($fetch_detail['date_end']!="0000-00-00 00:00:00"&&date('Y-m-d H:i')>date('Y-m-d H:i',strtotime($fetch_detail['date_end']))){
                  $cos_status = label('sv_b_close');
                }
              }
              if($value['cos_status']=="0"){
                  $cos_status = label('sv_b_close');
              }
              $output['2'] = $cos_status;
              if($value['cosen_status_sub']=="0"){
                $output['3'] = label('not_start');
              }else if($value['cosen_status_sub']=="1"){
                $output['3'] = label('r_pass');
              }else if($value['cosen_status_sub']=="2"){
                /*if($value['cosen_firsttime']=="0000-00-00 00:00:00"){
                  $output['2'] = label('not_start');
                }else{*/
                  $output['3'] = label('inProgress');
                //}
              }else{
                $output['3'] = label('not_start');
              }
              $score_pretest = 0;
              $score_posttest = 0;
              $score_pretest_full = 0;
              $score_posttest_full = 0;
              $fetch_pretest = $this->func_query->query_result('LMS_QIZ','','','','cos_id="'.$value['cos_id'].'" and quiz_type="1" and quiz_status="1" and quiz_isDelete="0"');
              $fetch_posttest = $this->func_query->query_result('LMS_QIZ','','','','cos_id="'.$value['cos_id'].'" and quiz_type="2" and quiz_status="1" and quiz_isDelete="0"');
              if(count($fetch_pretest)>0){
                  foreach ($fetch_pretest as $key_pretest => $value_pretest) {
                      $sum_score_all = 0;
                      $sum_score_quesall = 0;
                      $fetch_chkpretest = $this->func_query->query_row('LMS_QIZ_TC','','','','LMS_QIZ_TC.cosen_id="'.$value['cosen_id'].'" and LMS_QIZ_TC.qiz_id="'.$value_pretest['qiz_id'].'" and qiztc_isDelete="0" and qiz_status="3"','qiztc_id DESC');
                      if(count($fetch_chkpretest)>0){/*
                        $fetch_chkques = $this->func_query->query_result('LMS_QUES','LMS_QUES_TC','LMS_QUES.ques_id = LMS_QUES_TC.ques_id','','LMS_QUES.qiz_id="'.$value_pretest['qiz_id'].'" and LMS_QUES_TC.cosen_id="'.$value['cosen_id'].'" and LMS_QUES_TC.qiztc_id="'.$fetch_chkpretest['qiztc_id'].'"');
                        if(count($fetch_chkques)>0){
                            foreach ($fetch_chkques as $key_chkques => $value_chkques) {
                                $score_pretest+=floatval($value_chkques['tc_score']);
                                $score_pretest_full+=floatval($value_chkques['ques_score']);
                            }
                        }*/
                        $fetch_chkques = $this->func_query->query_result('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_pretest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
                        if(count($fetch_chkques)>0){
                            foreach ($fetch_chkques as $key_chkques => $value_chkques) {
                                $fetch_tc = $this->func_query->query_row('LMS_QUES_TC','','','','LMS_QUES_TC.ques_id="'.$value_chkques['ques_id'].'"  and LMS_QUES_TC.cosen_id="'.$value['cosen_id'].'" and LMS_QUES_TC.qiztc_id="'.$fetch_chkpretest['qiztc_id'].'"');
                                if(count($fetch_tc)>0){
                                $score_pretest+=floatval($fetch_tc['tc_score']);
                                }else{
                                $score_pretest+=0;
                                }
                                $sum_score_all+=floatval($value_chkques['ques_score']);
                            }
                        }
                      }else{
                        $fetch_chkques = $this->func_query->query_result('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_pretest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
                        if(count($fetch_chkques)>0){
                            foreach ($fetch_chkques as $key_chkques => $value_chkques) {
                                $sum_score_quesall+=floatval($value_chkques['ques_score']);
                            }
                        }
                      }
                      $fetch_sum = $this->func_query->query_row('LMS_QUES','','','','qiz_id="'.$value_pretest['qiz_id'].'" and ques_id in (select LMS_QUES_TC.ques_id from LMS_QUES_TC where qiz_id="'.$value_pretest['qiz_id'].'" and cosen_id="'.$value['cosen_id'].'") and ques_status="1" and ques_isDelete="0"','','SUM(ques_score) as total_score');
                      if(count($fetch_sum)>0){
                        $score_pretest_full += count($fetch_sum)>0&&floatval($fetch_sum['total_score'])>0?floatval($fetch_sum['total_score']):$sum_score_quesall;
                      }else{
                        $score_pretest_full += $value_pretest['quiz_numofshown']==count($fetch_chkques)?$sum_score_all:$sum_score_quesall;
                      }
                  }
              }
              if(count($fetch_posttest)>0){
                  foreach ($fetch_posttest as $key_posttest => $value_posttest) {
                      $sum_score_all = 0;
                      $sum_score_quesall = 0;
                      $fetch_chkposttest = $this->func_query->query_row('LMS_QIZ_TC','','','','LMS_QIZ_TC.cosen_id="'.$value['cosen_id'].'" and LMS_QIZ_TC.qiz_id="'.$value_posttest['qiz_id'].'" and qiztc_isDelete="0" and qiz_status="3"','qiztc_id DESC');
                      if(count($fetch_chkposttest)>0){
                        $fetch_chkques = $this->func_query->query_result('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_posttest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
                        if(count($fetch_chkques)>0){
                            foreach ($fetch_chkques as $key_chkques => $value_chkques) {
                                $fetch_tc = $this->func_query->query_row('LMS_QUES_TC','','','','LMS_QUES_TC.ques_id="'.$value_chkques['ques_id'].'"  and LMS_QUES_TC.cosen_id="'.$value['cosen_id'].'" and LMS_QUES_TC.qiztc_id="'.$fetch_chkposttest['qiztc_id'].'"');
                                if(count($fetch_tc)>0){
                                $score_posttest+=floatval($fetch_tc['tc_score']);
                                }else{
                                $score_posttest+=0;
                                }
                                $sum_score_all+=floatval($value_chkques['ques_score']);
                            }
                        }
                      }else{
                        $fetch_chkques = $this->func_query->query_result('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_posttest['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
                        if(count($fetch_chkques)>0){
                            foreach ($fetch_chkques as $key_chkques => $value_chkques) {
                                $sum_score_quesall+=floatval($value_chkques['ques_score']);
                            }
                        }
                      }
                      $fetch_sum = $this->func_query->query_row('LMS_QUES','','','','qiz_id="'.$value_posttest['qiz_id'].'" and ques_id in (select LMS_QUES_TC.ques_id from LMS_QUES_TC where qiz_id="'.$value_posttest['qiz_id'].'" and cosen_id="'.$value['cosen_id'].'") and ques_status="1" and ques_isDelete="0"','','SUM(ques_score) as total_score');
                      if(count($fetch_sum)>0){
                        $score_posttest_full += count($fetch_sum)>0&&floatval($fetch_sum['total_score'])>0?floatval($fetch_sum['total_score']):$sum_score_quesall;
                      }else{
                        $score_posttest_full += $sum_score_quesall;
                      }
                  }
              }
              $output['4'] = "<span style='float:right'>".number_format($score_pretest)."</span>";
              $output['5'] = "<span style='float:right'>".number_format($score_pretest_full)."</span>";  

              if($fetch_qiz>0){
                $output['6'] = "<span style='float:right'>".number_format($score_posttest)."</span>";
                $output['7'] = "<span style='float:right'>".number_format($score_posttest_full)."</span>";  
              }else{
                if($value['cosen_status_sub']!="1"){
                $output['6'] = "<span style='float:right'>0</span>";
                $output['7'] = "<span style='float:right'>0</span>";
                }else{
                $output['6'] = "<span style='float:right'>".number_format($value['cosen_score'])."</span>";
                $max_score = number_format($value['max_score'])==0?number_format('100'):number_format($value['max_score']);
                $output['7'] = "<span style='float:right'>".$max_score."</span>";  
                } 
              }

              $preReport = '-'; 
              $var_rechk = 1;
                $fetch_chkques_shlo = $this->func_query->query_result('LMS_QUES','','','','ques_type in ("sub","sa") and qiz_id in (select LMS_QIZ.qiz_id from LMS_QIZ where LMS_QIZ.cos_id = "'.$value['cos_id'].'") and ques_isDelete="0"');
                if(count($fetch_chkques_shlo)>0){
                  foreach ($fetch_chkques_shlo as $key_chkques_shlo => $value_chkques_shlo) {
                      $fetch_chktc = $this->func_query->query_row('LMS_QUES_TC','','','','LMS_QUES_TC.ques_id="'.$value_chkques_shlo['ques_id'].'"  and LMS_QUES_TC.cosen_id="'.$value['cosen_id'].'"','LMS_QUES_TC.tc_id DESC'); 
                      if(count($fetch_chktc)>0){
                        if($fetch_chktc['tc_isSavescore']=="0"){
                          $var_rechk = 0;
                        }
                      }
                  }
                }
              if($value['cosen_status_sub']=="1"&&$var_rechk==1){
                if($value['cos_typegrading']=="1"){
                    $preReport = $value['cosen_grade']!=""?$value['cosen_grade']:'-'; 
                }else{
                  if(intval($value['cosen_score_per'])>=intval($value['goal_score'])){
                    $preReport = label('pass'); 
                  }else{
                    $preReport = label('fail'); 
                  }
                }
              }
              $output['8'] = "<center>".$preReport."</center>";  
             /* if($lang=="thai"){
              $output['8'] = $value['cosen_finishtime']!="0000-00-00 00:00:00"?date('d',strtotime($value['cosen_finishtime']))." ".$thaimonth[intval(date('m',strtotime($value['cosen_finishtime'])))]." ".(date('d',strtotime($value['cosen_finishtime']))+543)." ".date('H:i',strtotime($value['cosen_finishtime'])):"<center>-</center>";
              }else{
              $output['8'] = $value['cosen_finishtime']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($value['cosen_finishtime'])):"<center>-</center>";
              }*/
              $output['9'] = $value['cosen_finishtime']!="0000-00-00 00:00:00"?date('d/m/Y H:i',strtotime($value['cosen_finishtime'])):"<center>-</center>";
              $count++;
              array_push($fetch_arr, $output);
          }
          return $fetch_arr;
    }

}
