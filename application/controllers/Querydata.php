<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Querydata extends CI_Controller {

  public function query_course(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
    $result = $this->func_query->query_row('LMS_COS','','','','cos_id = "'.$cos_id.'"');
    $cos_lang = explode(',', $result['cos_lang']);
    $result['isTH'] = in_array('th',$cos_lang)?"1":"0";
    $result['isENG'] = in_array('eng',$cos_lang)?"1":"0";
    $result['isJP'] = in_array('jp',$cos_lang)?"1":"0";
    $fetch_cg = $this->func_query->query_result('LMS_COSINCG','','','','course_id="'.$cos_id.'" and status_cg="1"','','cg_id');
    $arr_cg = array();
    if(count($fetch_cg)>0){
      foreach ($fetch_cg as $key => $value) {
        array_push($arr_cg, $value['cg_id']);
      }
      $result['cg_id'] = implode(',', $arr_cg);
    }else{
      $result['cg_id'] = "";
    }
    echo json_encode($result);
    exit();
  }

  public function public_course(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    date_default_timezone_set("Asia/Bangkok");
      $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    $sess = $this->session->userdata("user");
    $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
    $arr_update = array(
      'cos_public' => '1',
      'cos_modifiedby' => $sess['u_id'],
      'cos_modifieddate' => date('Y-m-d H:i')
    );
    $this->db->where('cos_id',$cos_id);
    if($this->db->update('LMS_COS',$arr_update)){

                $arr_email = array();
                $fetch_cos = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');
                if($lang=="thai"){ 
                  $cname = $fetch_cos['cname_th']!=""?$fetch_cos['cname_th']:$fetch_cos['cname_eng'];
                }else{ 
                  $cname = $fetch_cos['cname_eng']!=""?$fetch_cos['cname_eng']:$fetch_cos['cname_th'];
                }
                $fetch_cosincg = $this->func_query->query_result('LMS_COSINCG','','','','course_id="'.$cos_id.'" and status_cg="1"');
                if(count($fetch_cosincg)>0){
                  foreach ($fetch_cosincg as $key_cosincg => $value_cosincg) {
                    $fetch_cg = $this->func_query->query_row('LMS_COG','','','','cg_id="'.$value_cosincg['cg_id'].'"');
                    if(count($fetch_cg)>0){
                        $cg_approve_by = explode(',', $fetch_cg['cg_approve_by']);
                        if(count($cg_approve_by)>0){
                          for ($i=0; $i < count($cg_approve_by); $i++) { 
                            if(isset($cg_approve_by[$i])){
                              $fetch = $this->func_query->query_row('LMS_USP','LMS_EMP','LMS_EMP.emp_id = LMS_USP.emp_id','','LMS_USP.u_id = "'.$cg_approve_by[$i].'"');
                              if(count($fetch)>0){
                                if(!in_array($fetch['email'], $arr_email)){
                                    array_push($arr_email, $fetch['email']);
                                }
                              }
                            }
                          }
                        }
                    }
                  }
                  if(count($arr_email)>0){
                      for ($loopmail=0; $loopmail < count($arr_email); $loopmail++) { 
                          $date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
                          if($lang!="thai"){
                             $date = date('d F Y');
                          }
                            $fetch = $this->func_query->query_row('LMS_USP','LMS_EMP','LMS_EMP.emp_id = LMS_USP.emp_id','','LMS_EMP.email = "'.$arr_email[$loopmail].'" and emp_isDelete="0"');
                            $fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
                            $fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="4"');
                            $fetch_about = $this->func_query->query_row('LMS_ABOUT','','','','da_id="1"');
                            if(count($fetch_formatmail)>0){
                                $subject_th = $fetch_formatmail['smf_subject_th'];
                                $subject_en = $fetch_formatmail['smf_subject_en'];
                                $message_th = $fetch_formatmail['smf_message_th'];
                                $message_en = $fetch_formatmail['smf_message_en'];
                                if($subject_th!=""){
                                    $subject_th = str_replace("#fullname",$fetch['fullname_th'],$subject_th);
                                    $subject_th = str_replace("#username",$fetch['useri'],$subject_th);
                                    $subject_th = str_replace("#email",$fetch['email'],$subject_th);
                                    $subject_th = str_replace("#coursename",$cname,$subject_th);
                                    $subject_th = str_replace("#link_frontend",base_url()."managecourse/courses_demo/".$cos_id,$subject_th);
                                    $subject_th = str_replace("#date",$date,$subject_th);
                                    $subject_th = str_replace("#time",date('H:i'),$subject_th);
                                }
                                if($subject_en!=""){
                                    $subject_en = str_replace("#fullname",$fetch['fullname_en'],$subject_en);
                                    $subject_en = str_replace("#username",$fetch['useri'],$subject_en);
                                    $subject_en = str_replace("#email",$fetch['email'],$subject_en);
                                    $subject_en = str_replace("#coursename",$cname,$subject_en);
                                    $subject_en = str_replace("#link_frontend",base_url()."managecourse/courses_demo/".$cos_id,$subject_en);
                                    $subject_en = str_replace("#date",$date,$subject_en);
                                    $subject_en = str_replace("#time",date('H:i'),$subject_en);
                                }
                                if(isset($fetch_formatmail['smf_importimage'])&&$fetch_formatmail['smf_importimage']!=""){
                                    $img_val = '<img src="'.REAL_PATH.'/uploads/formatmail_img/'.$fetch_formatmail['smf_importimage'].'" width="100%">';
                                }else{
                                    $img_val = '';
                                }
                                if($message_th!=""){
                                    $message_th = str_replace("#fullname",$fetch['fullname_th'],$message_th);
                                    $message_th = str_replace("#username",$fetch['useri'],$message_th);
                                    $message_th = str_replace("#password",'',$message_th);
                                    $message_th = str_replace("#email",$fetch['email'],$message_th);
                                    $message_th = str_replace("#coursename",$cname,$message_th);
                                    $message_th = str_replace("#link_frontend",base_url()."managecourse/courses_demo/".$cos_id,$message_th);
                                    $message_th = str_replace("#date",$date,$message_th);
                                    $message_th = str_replace("#time",date('H:i'),$message_th);
                                    $message_th = str_replace("#image",$img_val,$message_th);
                                }
                                if($message_en!=""){
                                    $message_en = str_replace("#fullname",$fetch['fullname_en'],$message_en);
                                    $message_en = str_replace("#username",$fetch['useri'],$message_en);
                                    $message_en = str_replace("#password",'',$message_en);
                                    $message_en = str_replace("#email",$fetch['email'],$message_en);
                                    $message_en = str_replace("#coursename",$cname,$message_en);
                                    $message_en = str_replace("#link_frontend",base_url()."managecourse/courses_demo/".$cos_id,$message_en);
                                    $message_en = str_replace("#date",$date,$message_en);
                                    $message_en = str_replace("#time",date('H:i'),$message_en);
                                    $message_en = str_replace("#image",$img_val,$message_en);
                                }
                                if($lang == "thai") {
                                    $this->db->sendEmail( $arr_email[$loopmail] , $message_th, $subject_th,$fetch_setmail);
                                } else {
                                    $this->db->sendEmail( $arr_email[$loopmail] , $message_en, $subject_en,$fetch_setmail);
                                }
                            }
                      }
                  }
                }

    }
  }

  public function delete_img_profile(){
      $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
      $this->lang->load($lang,$lang);
      $this->load->model('Function_query_model', 'func_query', FALSE);
      $this->func_query->loadDB();
      date_default_timezone_set("Asia/Bangkok");
      $sess = $this->session->userdata("user");
      $type = isset($_REQUEST['type'])?$_REQUEST['type']:"";
      $fetch_userp = $this->func_query->query_row('LMS_USP','','','','LMS_USP.u_id="'.$sess['u_id'].'"');
      $output = array();
      if(count($fetch_userp)>0){
        if($type=="1"){
          if(is_file(ROOT_DIR."uploads/profile/".$fetch_userp['img_profile'])) {
              unlink(ROOT_DIR."uploads/profile/".$fetch_userp['img_profile']);
              $arr_update = array(
                'img_profile'=>''
              );
              $this->db->where('u_id',$fetch_userp['u_id']);
              $this->db->update('LMS_USP',$arr_update);
          }
        }else{
          $fetch_userp = $this->func_query->query_row('LMS_USP','','','','LMS_USP.u_id="'.$sess['u_id'].'"');
          if(is_file(ROOT_DIR."uploads/bg_user/".$fetch_userp['bgpic_user'])) {
              unlink(ROOT_DIR."uploads/bg_user/".$fetch_userp['bgpic_user']);
              $arr_update = array(
                'bgpic_user'=>''
              );
              $this->db->where('u_id',$fetch_userp['u_id']);
              $this->db->update('LMS_USP',$arr_update);
          }
        }
        $output['status'] = "2";
      }else{
        $output['status'] = "1";
      }
      echo json_encode($output);
  }

  public function delete_img_com_logo(){
      $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
      $this->lang->load($lang,$lang);
      $this->load->model('Function_query_model', 'func_query', FALSE);
      $this->func_query->loadDB();
      date_default_timezone_set("Asia/Bangkok");
      $sess = $this->session->userdata("user");
      $type = isset($_REQUEST['type'])?$_REQUEST['type']:"";
      $fetch_userp = $this->func_query->query_row('LMS_COMPANY','','','','com_id="'.$_REQUEST['com_id'].'"');
      $output = array();
      if(count($fetch_userp)>0){
        if($type=="com_logo_footer"){
          if(is_file(ROOT_DIR."uploads/logo/".$fetch_userp['com_logo_footer'])) {
              unlink(ROOT_DIR."uploads/logo/".$fetch_userp['com_logo_footer']);
              $arr_update = array(
                'com_logo_footer'=>''
              );
              $this->db->where('com_id',$fetch_userp['com_id']);
              $this->db->update('LMS_COMPANY',$arr_update);
          }
        }else{
          $fetch_userp = $this->func_query->query_row('LMS_COMPANY','','','','LMS_COMPANY.com_id="'.$_REQUEST['com_id'].'"');
          if(is_file(ROOT_DIR."uploads/logo/".$fetch_userp['com_logo_top'])) {
              unlink(ROOT_DIR."uploads/logo/".$fetch_userp['com_logo_top']);
              $arr_update = array(
                'com_logo_top'=>''
              );
              $this->db->where('com_id',$fetch_userp['com_id']);
              $this->db->update('LMS_COMPANY',$arr_update);
          }
        }
        $output['status'] = "2";
      }else{
        $output['status'] = "1";
      }
      echo json_encode($output);
  }

  public function delete_logo(){
      $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
      $this->lang->load($lang,$lang);
      $this->load->model('Function_query_model', 'func_query', FALSE);
      $this->func_query->loadDB();
      date_default_timezone_set("Asia/Bangkok");
      $sess = $this->session->userdata("user");
      $type = isset($_REQUEST['type'])?$_REQUEST['type']:"";
      $fetch_userp = $this->func_query->query_row('LMS_USP','','','','LMS_USP.u_id="'.$sess['u_id'].'"');
      $output = array();
      if(count($fetch_userp)>0){
        if($type=="da_logo_elearning"){
          if(is_file(ROOT_DIR."images/elearning_logo.png")){
              unlink(ROOT_DIR."images/elearning_logo.png");
          }
        }else if($type=="da_logo_top"){
          if(is_file(ROOT_DIR."images/logo.png")){
              unlink(ROOT_DIR."images/logo.png");
          }
        }else if($type=="da_logo_footer"){
          if(is_file(ROOT_DIR."images/logo_white.png")){
              unlink(ROOT_DIR."images/logo_white.png");
          }
        }else if($type=="da_footer_background"){
          if(is_file(ROOT_DIR."images/bg.png")){
              unlink(ROOT_DIR."images/bg.png");
          }
        }
        $output['status'] = "2";
      }else{
        $output['status'] = "1";
      }
      echo json_encode($output);
  }

  public function chk_logout(){
    $output = array();
    $sess = $this->session->userdata("user");
    if(empty($sess)){
        $output['status'] = "0";
    }else{  
        $output['status'] = "1";
    }
    echo json_encode($output);
  }
  public function runvideo(){
    $video = isset($_REQUEST['video'])?$_REQUEST['video']:"";
    $id = isset($_REQUEST['id'])?$_REQUEST['id']:"";
    ?>

                    <video id="video_upload" controls preload="none" controls controlsList="nodownload" data-setup="{}" style="width: 100%">
                        <source src="<?php echo REAL_PATH.'/uploads/media/'.$video; ?>" type="video/mp4">
                        <script type="text/javascript">
                                    var myPlayer = videojs('video_upload');
                                    var firsttime = false; // false does't has bookmark, true = has bookmark
                                    var previousTime = 0;
                                    var currentTime = 0;
                                    var seekStart = null;
                                    myPlayer.mobileUi({
                                        fullscreen: {
                                            enterOnRotate: true,
                                            lockOnRotate: false,
                                            //iOS: true // ใช้ได้ตั้งแต่ iOS 10.3.3 ไม่เกิน 12.xx
                                        }
                                    });

                                  if(myPlayer){
                                    myPlayer.ready(function(){
                                      setInterval(function(){
                                          currentTime = myPlayer.currentTime();
                                      },1000);

                                      myPlayer.on("ended", function (event) {
                                          console.log("End");
                                          rechk_onclick('<?php echo $id; ?>');
                                      })
                                    })
                                  }
                        </script>
                    </video>
    <?php
  }

  public function enroll_course_byuser(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
      $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
    $fetch_chk = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');
    $output = array();
    if(count($fetch_chk)>0){
      $condition = $fetch_chk['condition']!=""?explode(",",$fetch_chk['condition']):"";
      $pass = 1;
      $arr_txt = "";
      if($condition!=""&&count($condition)>0){
        $numloop_chk = 1;
        for ($i=0; $i < count($condition); $i++) { 
          $fetch_chkenroll = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$condition[$i].'" and emp_id = "'.$sess['emp_id'].'" and cosen_isDelete="0" and cosen_status="1" and cosen_finishtime!="0000-00-00 00:00:00"');
          if(count($fetch_chkenroll)==0){
           
            $fetch_chkcos = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$condition[$i].'"');
            if(count($fetch_chkcos)>0){
               $pass = 0;
              if($lang=="thai"){ 
                $cname = $fetch_chkcos['cname_th']!=""?$fetch_chkcos['cname_th']:$fetch_chkcos['cname_eng'];
              }else{ 
                $cname = $fetch_chkcos['cname_eng']!=""?$fetch_chkcos['cname_eng']:$fetch_chkcos['cname_th'];
              }
              $arr_txt .= $cname;
              if($numloop_chk<count($condition)){
                  $arr_txt .= ",";
              }
            }
          }
          $numloop_chk++;
        }
      }
      if($pass==1){
            $fetch_chkseat = $this->func_query->numrows('LMS_COS_ENROLL','','','','cos_id="'.$cos_id.'" and cosen_isDelete="0" and cosen_status="1"');
            if($fetch_chkseat<=intval($fetch_chk['seat_count'])){
              $fetch_chkenroll = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$cos_id.'" and emp_id = "'.$sess['emp_id'].'" and cosen_isDelete="0" and cosen_status!="2"');
              if(count($fetch_chkenroll)==0){
                $arr_insert = array(
                  'cos_id'=>$cos_id,
                  'emp_id'=>$sess['emp_id'],
                  'cosen_status' => '1',//ผู้เรียนปัจจุบัน
                  'cosen_createby' => $sess['u_id'],
                  'cosen_createdate' => date('Y-m-d H:i'),
                  'cosen_modifiedby' => $sess['u_id'],
                  'cosen_modifieddate' => date('Y-m-d H:i'),
                  'cosen_timerequest' => date('Y-m-d H:i')
                );
                $this->db->insert('LMS_COS_ENROLL',$arr_insert);

                $fetch_cos = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');
                $fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
                $date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
                if($lang!="thai"){
                  $date = date('d F Y');
                }
                if($lang=="thai"){ 
                    $cname = $fetch_cos['cname_th']!=""?$fetch_cos['cname_th']:$fetch_cos['cname_eng'];
                }else{ 
                    $cname = $fetch_cos['cname_eng']!=""?$fetch_cos['cname_eng']:$fetch_cos['cname_th'];
                }
                $period = label('UnlimitedTime');
                $fetch_cos_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id="'.$cos_id.'" and cosde_status="1" and cosde_isDelete="0"');
                if(count($fetch_cos_detail)>0){
                  if($fetch_cos_detail['date_start']!="0000-00-00 00:00:00"&&$fetch_cos_detail['date_end']!="0000-00-00 00:00:00"){
                    if($lang=="thai"){
                    $periodstart = $fetch_cos_detail['date_start']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_cos_detail['date_start'])).$thaimonth[intval(date('m',strtotime($fetch_cos_detail['date_start'])))].(date('Y',strtotime($fetch_cos_detail['date_start']))+543)." ".date('H:i',strtotime($fetch_cos_detail['date_start'])):"";
                    $periodend = $fetch_cos_detail['date_end']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_cos_detail['date_end'])).$thaimonth[intval(date('m',strtotime($fetch_cos_detail['date_end'])))].(date('Y',strtotime($fetch_cos_detail['date_end']))+543)." ".date('H:i',strtotime($fetch_cos_detail['date_end'])):"";
                    }else{
                    $periodstart = $fetch_cos_detail['date_start']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_cos_detail['date_start'])).$thaimonth[intval(date('m',strtotime($fetch_cos_detail['date_start'])))].(date('Y',strtotime($fetch_cos_detail['date_start'])))." ".date('H:i',strtotime($fetch_cos_detail['date_start'])):"";
                    $periodend = $fetch_cos_detail['date_end']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_cos_detail['date_end'])).$thaimonth[intval(date('m',strtotime($fetch_cos_detail['date_end'])))].(date('Y',strtotime($fetch_cos_detail['date_end'])))." ".date('H:i',strtotime($fetch_cos_detail['date_end'])):"";
                    }
                    
                    if($periodstart!=""&&$periodend!=""){
                        $period = $periodstart." - ".$periodend;
                    }
                  }
                }
                  $date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
                  if($lang!="thai"){
                      $date = date('d F Y');
                  }

                    $fetch_user = $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.u_id="'.$sess['u_id'].'"');
                    $fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="13"');
                    if(count($fetch_formatmail)>0){
                        $subject_th = $fetch_formatmail['smf_subject_th'];
                        $subject_en = $fetch_formatmail['smf_subject_en'];
                        $message_th = $fetch_formatmail['smf_message_th'];
                        $message_en = $fetch_formatmail['smf_message_en'];
                        if($subject_th!=""){
                          $subject_th = str_replace("#fullname",$fetch_user['fullname_th'],$subject_th);
                          $subject_th = str_replace("#username",$fetch_user['useri'],$subject_th);
                          $subject_th = str_replace("#email",$fetch_user['email'],$subject_th);
                          $subject_th = str_replace("#coursename",$cname,$subject_th);
                          $subject_th = str_replace("#link_frontend",base_url()."coursemain/my_course",$subject_th);
                          $subject_th = str_replace("#date",$date,$subject_th);
                          $subject_th = str_replace("#time",date('H:i'),$subject_th);
                          $subject_th = str_replace("#perioddate",$period,$subject_th);
                        }
                        if($subject_en!=""){
                          $subject_en = str_replace("#fullname",$fetch_user['fullname_en'],$subject_en);
                          $subject_en = str_replace("#username",$fetch_user['useri'],$subject_en);
                          $subject_en = str_replace("#email",$fetch_user['email'],$subject_en);
                          $subject_en = str_replace("#coursename",$cname,$subject_en);
                          $subject_en = str_replace("#link_frontend",base_url()."coursemain/my_course",$subject_en);
                          $subject_en = str_replace("#date",$date,$subject_en);
                          $subject_en = str_replace("#time",date('H:i'),$subject_en);
                          $subject_en = str_replace("#perioddate",$period,$subject_en);
                        }
                        if($message_th!=""){
                          $message_th = str_replace("#fullname",$fetch_user['fullname_th'],$message_th);
                          $message_th = str_replace("#username",$fetch_user['useri'],$message_th);
                          $message_th = str_replace("#email",$fetch_user['email'],$message_th);
                          $message_th = str_replace("#coursename",$cname,$message_th);
                          $message_th = str_replace("#link_frontend",base_url()."coursemain/my_course",$message_th);
                          $message_th = str_replace("#date",$date,$message_th);
                          $message_th = str_replace("#time",date('H:i'),$message_th);
                          $message_th = str_replace("#perioddate",$period,$message_th);
                        }
                        if($message_en!=""){
                          $message_en = str_replace("#fullname",$fetch_user['fullname_en'],$message_en);
                          $message_en = str_replace("#username",$fetch_user['useri'],$message_en);
                          $message_en = str_replace("#email",$fetch_user['email'],$message_en);
                          $message_en = str_replace("#coursename",$cname,$message_en);
                          $message_en = str_replace("#link_frontend",base_url()."coursemain/my_course",$message_en);
                          $message_en = str_replace("#date",$date,$message_en);
                          $message_en = str_replace("#time",date('H:i'),$message_en);
                          $message_en = str_replace("#perioddate",$period,$message_en);
                        }
                        if($lang == "thai") {
                        $this->db->sendEmail( $fetch_user['email'] , $message_th, $subject_th,$fetch_setmail);
                        } else {
                        $this->db->sendEmail( $fetch_user['email'] , $message_en, $subject_en,$fetch_setmail);
                        }
                    }
                $output['status'] = "2";
              }else{
                if($fetch_chkenroll['cosen_status']=="0"){
                  $output['status'] = "3";//Wait approve
                }else{
                  $output['status'] = "1";//Duplicate
                }
              }
            }else{
              if(intval($fetch_chk['seat_count'])==0){
                $arr_insert = array(
                  'cos_id'=>$cos_id,
                  'emp_id'=>$sess['emp_id'],
                  'cosen_status' => '1',//ผู้เรียนปัจจุบัน
                  'cosen_createby' => $sess['u_id'],
                  'cosen_createdate' => date('Y-m-d H:i'),
                  'cosen_modifiedby' => $sess['u_id'],
                  'cosen_modifieddate' => date('Y-m-d H:i'),
                  'cosen_timerequest' => date('Y-m-d H:i')
                );
                $this->db->insert('LMS_COS_ENROLL',$arr_insert);

                $fetch_cos = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');
                $fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
                $date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
                if($lang!="thai"){
                  $date = date('d F Y');
                }
                if($lang=="thai"){ 
                    $cname = $fetch_cos['cname_th']!=""?$fetch_cos['cname_th']:$fetch_cos['cname_eng'];
                }else{ 
                    $cname = $fetch_cos['cname_eng']!=""?$fetch_cos['cname_eng']:$fetch_cos['cname_th'];
                }
                $period = label('UnlimitedTime');
                $fetch_cos_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id="'.$cos_id.'" and cosde_status="1" and cosde_isDelete="0"');
                if(count($fetch_cos_detail)>0){
                  if($fetch_cos_detail['date_start']!="0000-00-00 00:00:00"&&$fetch_cos_detail['date_end']!="0000-00-00 00:00:00"){
                    if($lang=="thai"){
                    $periodstart = $fetch_cos_detail['date_start']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_cos_detail['date_start'])).$thaimonth[intval(date('m',strtotime($fetch_cos_detail['date_start'])))].(date('Y',strtotime($fetch_cos_detail['date_start']))+543)." ".date('H:i',strtotime($fetch_cos_detail['date_start'])):"";
                    $periodend = $fetch_cos_detail['date_end']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_cos_detail['date_end'])).$thaimonth[intval(date('m',strtotime($fetch_cos_detail['date_end'])))].(date('Y',strtotime($fetch_cos_detail['date_end']))+543)." ".date('H:i',strtotime($fetch_cos_detail['date_end'])):"";
                    }else{
                    $periodstart = $fetch_cos_detail['date_start']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_cos_detail['date_start'])).$thaimonth[intval(date('m',strtotime($fetch_cos_detail['date_start'])))].(date('Y',strtotime($fetch_cos_detail['date_start'])))." ".date('H:i',strtotime($fetch_cos_detail['date_start'])):"";
                    $periodend = $fetch_cos_detail['date_end']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_cos_detail['date_end'])).$thaimonth[intval(date('m',strtotime($fetch_cos_detail['date_end'])))].(date('Y',strtotime($fetch_cos_detail['date_end'])))." ".date('H:i',strtotime($fetch_cos_detail['date_end'])):"";
                    }
                    
                    if($periodstart!=""&&$periodend!=""){
                        $period = $periodstart." - ".$periodend;
                    }
                  }
                }
                  $date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
                  if($lang!="thai"){
                    $date = date('d F Y');
                  }

                    $fetch_user = $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.u_id="'.$sess['u_id'].'"');
                    $fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="13"');
                    if(count($fetch_formatmail)>0){
                        $subject_th = $fetch_formatmail['smf_subject_th'];
                        $subject_en = $fetch_formatmail['smf_subject_en'];
                        $message_th = $fetch_formatmail['smf_message_th'];
                        $message_en = $fetch_formatmail['smf_message_en'];
                        if($subject_th!=""){
                          $subject_th = str_replace("#fullname",$fetch_user['fullname_th'],$subject_th);
                          $subject_th = str_replace("#username",$fetch_user['useri'],$subject_th);
                          $subject_th = str_replace("#email",$fetch_user['email'],$subject_th);
                          $subject_th = str_replace("#coursename",$cname,$subject_th);
                          $subject_th = str_replace("#link_frontend",base_url()."coursemain/my_course",$subject_th);
                          $subject_th = str_replace("#date",$date,$subject_th);
                          $subject_th = str_replace("#time",date('H:i'),$subject_th);
                          $subject_th = str_replace("#perioddate",$period,$subject_th);
                        }
                        if($subject_en!=""){
                          $subject_en = str_replace("#fullname",$fetch_user['fullname_en'],$subject_en);
                          $subject_en = str_replace("#username",$fetch_user['useri'],$subject_en);
                          $subject_en = str_replace("#email",$fetch_user['email'],$subject_en);
                          $subject_en = str_replace("#coursename",$cname,$subject_en);
                          $subject_en = str_replace("#link_frontend",base_url()."coursemain/my_course",$subject_en);
                          $subject_en = str_replace("#date",$date,$subject_en);
                          $subject_en = str_replace("#time",date('H:i'),$subject_en);
                          $subject_en = str_replace("#perioddate",$period,$subject_en);
                        }
                        if($message_th!=""){
                          $message_th = str_replace("#fullname",$fetch_user['fullname_th'],$message_th);
                          $message_th = str_replace("#username",$fetch_user['useri'],$message_th);
                          $message_th = str_replace("#email",$fetch_user['email'],$message_th);
                          $message_th = str_replace("#coursename",$cname,$message_th);
                          $message_th = str_replace("#link_frontend",base_url()."coursemain/my_course",$message_th);
                          $message_th = str_replace("#date",$date,$message_th);
                          $message_th = str_replace("#time",date('H:i'),$message_th);
                          $message_th = str_replace("#perioddate",$period,$message_th);
                        }
                        if($message_en!=""){
                          $message_en = str_replace("#fullname",$fetch_user['fullname_en'],$message_en);
                          $message_en = str_replace("#username",$fetch_user['useri'],$message_en);
                          $message_en = str_replace("#email",$fetch_user['email'],$message_en);
                          $message_en = str_replace("#coursename",$cname,$message_en);
                          $message_en = str_replace("#link_frontend",base_url()."coursemain/my_course",$message_en);
                          $message_en = str_replace("#date",$date,$message_en);
                          $message_en = str_replace("#time",date('H:i'),$message_en);
                          $message_en = str_replace("#perioddate",$period,$message_en);
                        }
                        if($lang == "thai") {
                        $this->db->sendEmail( $fetch_user['email'] , $message_th, $subject_th,$fetch_setmail);
                        } else {
                        $this->db->sendEmail( $fetch_user['email'] , $message_en, $subject_en,$fetch_setmail);
                        }
                    }
                $output['status'] = "2";
              }else{
                /*$arr_insert = array(
                  'cos_id'=>$cos_id,
                  'emp_id'=>$sess['emp_id'],
                  'cosen_status' => '3',//ผู้เรียนสำรอง
                  'cosen_createby' => $sess['u_id'],
                  'cosen_createdate' => date('Y-m-d H:i'),
                  'cosen_modifiedby' => $sess['u_id'],
                  'cosen_modifieddate' => date('Y-m-d H:i'),
                  'cosen_timerequest' => date('Y-m-d H:i')
                );
                $this->db->insert('LMS_COS_ENROLL',$arr_insert);*/
                $output['status'] = "5"; //Seat Full
              }
            }
      }else{
          $output['status'] = "11"; //condition
          $output['msg'] = $arr_txt;
      }
    }else{
      $output['status'] = "0";
    }
    echo json_encode($output);
  }

  public function update_firsttime(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $emp_id = isset($_REQUEST['emp_id'])?$_REQUEST['emp_id']:"";
    $fetch_chk = $this->func_query->query_row('LMS_EMP','','','','emp_id="'.$emp_id.'"');
    $output = array();
    if(count($fetch_chk)>0){
      $arr = array(
        'emp_firsttime' => '0',
        'emp_modifiedby' => $sess['u_id'],
        'emp_modifieddate' => date('Y-m-d H:i')
      );
      $this->db->where('emp_id',$emp_id);
      $this->db->update('LMS_EMP',$arr);
      $output['status'] = "2";
    }else{
      $output['status'] = "2";
    }
    echo json_encode($output);
  }

  public function detail_publicsurvey_report(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $sv_id = isset($_REQUEST['sv_id'])?$_REQUEST['sv_id']:"";
    $fetch_sv = $this->func_query->query_row('LMS_SV','','','','sv_id="'.$sv_id.'"');
    $fetch_svde = $this->func_query->query_result('LMS_SVDE','','','','sv_id="'.$sv_id.'" and svde_isDelete="0"');
    $numsvde = ((count($fetch_svde)*2)*200)+800;
                  if($lang=="thai"){ 
                    $sv_title = $fetch_sv['sv_title_th']!=""?$fetch_sv['sv_title_th']:$fetch_sv['sv_title_eng'];
                    $sv_title = $sv_title!=""?$sv_title:$fetch_sv['sv_title_jp'];
                    $sv_explanation = $fetch_sv['sv_explanation_th']!=""?$fetch_sv['sv_explanation_th']:$fetch_sv['sv_explanation_eng'];
                    $sv_explanation = $sv_explanation!=""?$sv_explanation:$fetch_sv['sv_explanation_jp'];
                  }else if($lang=="english"){ 
                    $sv_title = $fetch_sv['sv_title_eng']!=""?$fetch_sv['sv_title_eng']:$fetch_sv['sv_title_th'];
                    $sv_title = $sv_title!=""?$sv_title:$fetch_sv['sv_title_jp'];
                    $sv_explanation = $fetch_sv['sv_explanation_eng']!=""?$fetch_sv['sv_explanation_eng']:$fetch_sv['sv_explanation_th'];
                    $sv_explanation = $sv_explanation!=""?$sv_explanation:$fetch_sv['sv_explanation_jp'];
                  }else{
                    $sv_title = $fetch_sv['sv_title_jp']!=""?$fetch_sv['sv_title_jp']:$fetch_sv['sv_title_eng'];
                    $sv_title = $sv_title!=""?$sv_title:$fetch_sv['sv_title_th'];
                    $sv_explanation = $fetch_sv['sv_explanation_jp']!=""?$fetch_sv['sv_explanation_jp']:$fetch_sv['sv_explanation_eng'];
                    $sv_explanation = $sv_explanation!=""?$sv_explanation:$fetch_sv['sv_explanation_th'];
                  }
    ?>
    <h4><?php echo $sv_title; ?></h4><br><hr>
    <?php echo $sv_explanation; ?>
    <div class="table-responsive">
      <table id="myTable_detail" width="" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th width="50" align="center"></th>
            <th width="250" align="center"><center><?php echo label('m_name'); ?></center></th>
            <th width="300" align="center"><center><?php echo label('com_name'); ?></center></th>
            <th width="100" align="center"><center><?php echo label('m_department'); ?></center></th>
            <th width="100" align="center"><center><?php echo label('p_postname'); ?></center></th>
            <?php if(count($fetch_svde)>0){ $numloop = 1;
                      foreach ($fetch_svde as $key_svde => $value_svde) {
            ?>
            <th width="200" align="center"><center><?php echo label('question')."<br>".$numloop; ?></center></th>
            <th width="200" align="center"><center><?php echo label('answer')."<br>".$numloop;$numloop++; ?></center></th>
            <?php     }
                  } ?>
          </tr>
        </thead>
        <tbody>
          <?php
            $fetch_detail = $this->func_query->query_result('LMS_SV_TC','LMS_EMP','LMS_SV_TC.emp_id = LMS_EMP.emp_id','','sv_id="'.$sv_id.'" and svtc_isDelete="0" and svtc_status="1"','svtc_id DESC');
            if(count($fetch_detail)>0){ $numrows = 1;
                foreach ($fetch_detail as $key_detail => $value_detail) {
                  $fetch_emp = $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_EMP.emp_id = LMS_USP.emp_id','','LMS_EMP.emp_id="'.$value_detail['emp_id'].'"');
                  $fetch_com = $this->func_query->query_row('LMS_COMPANY','','','','com_id="'.$fetch_emp['com_id'].'"');
                  $fetch_dep = $this->func_query->query_row('LMS_DEPART','LMS_POSITION','LMS_DEPART.dep_id = LMS_POSITION.dep_id','','LMS_POSITION.posi_id="'.$fetch_emp['posi_id'].'"');
          ?>
          <tr>
            <td align="right"><?php echo $numrows; ?></td>
            <td><?php if($fetch_sv['sv_type']=="1"){ echo $lang=="thai"?$fetch_emp['fullname_th']:$fetch_emp['fullname_en']; }else{ echo "User ".$numrows;} ?></td>
            <td><?php echo $lang=="thai"?$fetch_com['com_name_th']:$fetch_com['com_name_eng']; ?></td>
            <td><?php echo $lang=="thai"?$fetch_dep['dep_name_th']:$fetch_dep['dep_name_en']; ?></td>
            <td><?php echo $lang=="thai"?$fetch_dep['posi_name_th']:$fetch_dep['posi_name_en']; ?></td>
            <?php if(count($fetch_svde)>0){ $numloop = 1;
                      foreach ($fetch_svde as $key_svde => $value_svde) {
                        $tc_answer = "-";
                        $fetch_svdetc = $this->func_query->query_row('LMS_SVDE_TC','','','','svde_id="'.$value_svde['svde_id'].'" and emp_id="'.$value_detail['emp_id'].'"','tc_id DESC');
                        if(count($fetch_svdetc)>0){
                          $tc_answer = $fetch_svdetc['tc_answer'];
                          $tc_answer = str_replace("svde_specify",$fetch_svdetc['tc_note'],$tc_answer);
                          $tc_answer = str_replace("||",",",$tc_answer);
                        }

                  if($lang=="thai"){ 
                    $svde_name = $value_svde['svde_name_th']!=""?$value_svde['svde_name_th']:$value_svde['svde_name_eng'];
                    $svde_name = $svde_name!=""?$svde_name:$value_svde['svde_name_jp'];
                  }else if($lang=="english"){ 
                    $svde_name = $value_svde['svde_name_eng']!=""?$value_svde['svde_name_eng']:$value_svde['svde_name_th'];
                    $svde_name = $svde_name!=""?$svde_name:$value_svde['svde_name_jp'];
                  }else{
                    $svde_name = $value_svde['svde_name_jp']!=""?$value_svde['svde_name_jp']:$value_svde['svde_name_eng'];
                    $svde_name = $svde_name!=""?$svde_name:$value_svde['svde_name_th'];
                  }
            ?>
            <td><?php echo strip_tags($svde_name); ?></td>
            <td><?php echo strip_tags($tc_answer); ?></td>
            <?php     }
                  } ?>
          </tr>
          <?php $numrows++;
                }
            }
          ?>
        </tbody>
      </table>
    </div>
    <script type="text/javascript">

            $('#myTable_detail').DataTable({
              "language": {
                "zeroRecords": "<?php echo label('wg_datanotfound'); ?>",
                "infoEmpty": "<?php echo label('wg_datanotfound'); ?>",
                "sInfo":           "<?php echo label('sInfo'); ?>",
                "sInfoEmpty":      "<?php echo label('sInfoEmpty'); ?>",
                "decimal":        "",
                "emptyTable":     "<?php echo label('wg_datanotfound'); ?>",
                "infoPostFix":    "",
                "thousands":      ",",
                //"lengthMenu":     "แสดง _MENU_ รายการ",
                "lengthMenu":     "<?php echo label('lengthMenu'); ?>",
                "loadingRecords": "<?php echo label('loadingRecords'); ?>",
                "processing":     "<?php echo label('processing'); ?>",
                "search":         "<?php echo label('filter_bar'); ?>",
                "zeroRecords":    "<?php echo label('wg_datanotfound'); ?>",
                "paginate": {
                    "first":      "<?php echo label('firstpage'); ?>",
                    "last":       "<?php echo label('last'); ?>",
                    "next":       "<?php echo label('lrn_btn_next'); ?>",
                    "previous":   "<?php echo label('previous'); ?>"
                         },
              },
              "scrollX": true,
              fixedColumns: true,
              dom: 'Bfrtip',
              buttons: [
                  'copy', 'excel', 'print'
              ],
              columnDefs: [{
                targets: [
                <?php if(count($fetch_svde)>0){ $numloop = 5;
                      $countsvde = count($fetch_svde)*2;
                      for ($i=1;$i<=$countsvde;$i++) { ?>
                        parseInt('<?php echo $numloop;$numloop++; ?>'),
                <?php }
                    }?>
                    ],
                createdCell: function(cell ,td, cellData, rowData, row, col) {
                  var $cell = $(cell);
                  console.log(td.length);
                  if(td.length>20){
                  $(cell).contents().wrapAll("<div class='content'></div>");
                  var $content = $cell.find(".content");
                  $(cell).append($("<button class='btn btn-default btn-sm'>...</button>"));
                  $btn = $(cell).find("button");

                  $content.css({
                    "height": "50px",
                    "overflow": "hidden"
                  })
                  $cell.data("isLess", true);

                  $btn.click(function() {
                    var isLess = $cell.data("isLess");
                    $content.css("height", isLess ? "auto" : "50px")
                    $(this).html(isLess ? "<i class='mdi mdi-arrow-up-bold-circle-outline'></i>" : "...")
                    $cell.data("isLess", !isLess)
                  })
                  }
                }
              }]
            });
    </script>
    <?php

  }

  public function query_list_emp_reportsurveycos(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $sv_id = isset($_REQUEST['sv_id'])?$_REQUEST['sv_id']:"";
    $fetch_sv = $this->func_query->query_row('LMS_SURVEY','LMS_COS','LMS_SURVEY.cos_id = LMS_COS.cos_id','','sv_id="'.$sv_id.'"');
    $fetch_svde = $this->func_query->query_result('LMS_SURVEY_DE','','','','sv_id="'.$sv_id.'" and svde_isDelete="0"');
    $numsvde = ((count($fetch_svde)*2)*200)+800;
                  if($lang=="thai"){ 
                    $sv_title = $fetch_sv['sv_title_th']!=""?$fetch_sv['sv_title_th']:$fetch_sv['sv_title_eng'];
                    $sv_explanation = $fetch_sv['sv_explanation_th']!=""?$fetch_sv['sv_explanation_th']:$fetch_sv['sv_explanation_eng'];
                    $cname = $fetch_sv['cname_th']!=""?$fetch_sv['cname_th']:$fetch_sv['cname_eng'];
                  }else{ 
                    $sv_title = $fetch_sv['sv_title_eng']!=""?$fetch_sv['sv_title_eng']:$fetch_sv['sv_title_th'];
                    $sv_explanation = $fetch_sv['sv_explanation_eng']!=""?$fetch_sv['sv_explanation_eng']:$fetch_sv['sv_explanation_th'];
                    $cname = $fetch_sv['cname_eng']!=""?$fetch_sv['cname_eng']:$fetch_sv['cname_th'];
                  }
    ?>
    <div class="table-responsive">
      <table id="myTable_detail" width="100%" cellspacing="0" class="table table-bordered table-striped">
        <thead>
          <!-- <tr>
                <th colspan="<?php echo (count($fetch_svde))+2; ?>"><center><?php echo $lang=="thai"?"แบบสอบถามสำหรับรายวิชา ":"Survey for courses "; ?><?php echo $cname; ?></center></th>
          </tr>
          <tr>
                <th colspan="<?php echo (count($fetch_svde))+2; ?>"><center><?php echo $sv_title; ?></center></th>
          </tr> -->
          <tr>
                <th>No.</th>
                <?php 
                                        $num = 0;
                    foreach ($fetch_svde as $key_chk => $fetch_chk) {
                     $num++;

                    if($lang=="thai"){ 
                      $svde_detail = $fetch_chk['svde_detail_th']!=""?$fetch_chk['svde_detail_th']:$fetch_chk['svde_detail_eng'];
                      $svde_detail = $svde_detail!=""?$svde_detail:$fetch_chk['svde_detail_jp'];
                    }else if($lang=="english"){ 
                      $svde_detail = $fetch_chk['svde_detail_eng']!=""?$fetch_chk['svde_detail_eng']:$fetch_chk['svde_detail_th'];
                      $svde_detail = $svde_detail!=""?$svde_detail:$fetch_chk['svde_detail_jp'];
                    }else{
                      $svde_detail = $fetch_chk['svde_detail_jp']!=""?$fetch_chk['svde_detail_jp']:$fetch_chk['svde_detail_eng'];
                      $svde_detail = $svde_detail!=""?$svde_detail:$fetch_chk['svde_detail_th'];
                    }
                     ?>
                      <th><center><?php echo $svde_detail; ?></center></th>
                  <?php } ?>
                <th><?php echo $lang=="thai"?"ข้อเสนอแนะท้ายบท":"Suggestion at the end of survey"; ?></th>
          </tr>
          <!-- <tr>
                <th></th>
                <th></th>
            <?php for($a=0;$a<$num;$a++){ ?>
              <th><?php echo label('score'); ?></th>
            <?php } ?>
          </tr> -->
        </thead>
        <tbody>
            <?php 
                $query_head = $this->func_query->query_result('LMS_QN_USER','','','','sv_id="'.$sv_id.'"');
                if(count($query_head)>0){
                    $num = 1;
                    foreach ($query_head as $key_head => $fetch_head) {
            ?>
                <tr>
                    <td><span style="float: right;"><?php echo $num;$num++; ?></span></td>
            <?php 
                    $query_detail = $this->func_query->query_result('LMS_QN_USER_DE','','','','LMS_QN_USER_DE.qnu_id="'.$fetch_head['qnu_id'].'"');
                    foreach ($query_detail as $key_detail => $fetch_detail) {
                      $qnude_suggestion = $fetch_detail['qnude_suggestion']!=""?" (".$fetch_detail['qnude_suggestion'].")":"";
              ?>
                    <td align="center"><?php echo $fetch_detail['qnude_var'].$qnude_suggestion; ?></td>
                    <!-- <td><?php echo $fetch_detail['qnude_suggestion']; ?></td> -->
              <?php   } ?>
                    <td ><?php echo $fetch_head['qnu_suggestion']; ?></td>
                </tr>
            <?php   

                  } 
              }
            ?>
        </tbody>
        <tfoot>
          <tr>
          <th></th>
          <?php 
                $a = 0;
                $out_arr = array();
                $data1 = $this->func_query->query_result('LMS_SURVEY_DE','LMS_QN_USER_DE','LMS_SURVEY_DE.svde_id = LMS_QN_USER_DE.svde_id','','LMS_SURVEY_DE.sv_id="'.$sv_id.'" and LMS_QN_USER_DE.qnude_var="1"','','LMS_QN_USER_DE.svde_id,LMS_QN_USER_DE.qnude_var');
                $data2 = $this->func_query->query_result('LMS_SURVEY_DE','LMS_QN_USER_DE','LMS_SURVEY_DE.svde_id = LMS_QN_USER_DE.svde_id','','LMS_SURVEY_DE.sv_id="'.$sv_id.'" and LMS_QN_USER_DE.qnude_var="2"','','LMS_QN_USER_DE.svde_id,LMS_QN_USER_DE.qnude_var');
                $data3 = $this->func_query->query_result('LMS_SURVEY_DE','LMS_QN_USER_DE','LMS_SURVEY_DE.svde_id = LMS_QN_USER_DE.svde_id','','LMS_SURVEY_DE.sv_id="'.$sv_id.'" and LMS_QN_USER_DE.qnude_var="3"','','LMS_QN_USER_DE.svde_id,LMS_QN_USER_DE.qnude_var');
                $data4 = $this->func_query->query_result('LMS_SURVEY_DE','LMS_QN_USER_DE','LMS_SURVEY_DE.svde_id = LMS_QN_USER_DE.svde_id','','LMS_SURVEY_DE.sv_id="'.$sv_id.'" and LMS_QN_USER_DE.qnude_var="4"','','LMS_QN_USER_DE.svde_id,LMS_QN_USER_DE.qnude_var');
                $data5 = $this->func_query->query_result('LMS_SURVEY_DE','LMS_QN_USER_DE','LMS_SURVEY_DE.svde_id = LMS_QN_USER_DE.svde_id','','LMS_SURVEY_DE.sv_id="'.$sv_id.'" and LMS_QN_USER_DE.qnude_var="5"','','LMS_QN_USER_DE.svde_id,LMS_QN_USER_DE.qnude_var');
                $objQuery = $this->func_query->query_result('LMS_SURVEY_DE','','','','sv_id="'.$sv_id.'" and svde_isDelete="0"');
                foreach ($objQuery as $key_chkobj => $fetch_chk) {
                    $total = 0;
                    $ans1[$a]=0;$ans2[$a]=0;$ans3[$a]=0;$ans4[$a]=0;$ans5[$a]=0;
                    foreach($data1  as $key1 => $rowda) {if(($fetch_chk['svde_id'] == $rowda['svde_id'])&&($rowda['qnude_var'] == '1')):$ans1[$a]++;endif;}
                    foreach($data2  as $key2 => $rowda) {if(($fetch_chk['svde_id'] == $rowda['svde_id'])&&($rowda['qnude_var'] == '2')):$ans2[$a]++;endif;}
                    foreach($data3  as $key3 => $rowda) {if(($fetch_chk['svde_id'] == $rowda['svde_id'])&&($rowda['qnude_var'] == '3')):$ans3[$a]++;endif;}
                    foreach($data4  as $key4 => $rowda) {if(($fetch_chk['svde_id'] == $rowda['svde_id'])&&($rowda['qnude_var'] == '4')):$ans4[$a]++;endif;}
                    foreach($data5  as $key5 => $rowda) {if(($fetch_chk['svde_id'] == $rowda['svde_id'])&&($rowda['qnude_var'] == '5')):$ans5[$a]++;endif;}

                    $val1 = intval($ans1[$a])*1;
                    $val2 = intval($ans2[$a])*2;
                    $val3 = intval($ans3[$a])*3;
                    $val4 = intval($ans4[$a])*4;
                    $val5 = intval($ans5[$a])*5;
                    $total_val = $val1 + $val2 + $val3 + $val4 + $val5;
                    $total = $ans1[$a] + $ans2[$a] + $ans3[$a] + $ans4[$a] + $ans5[$a];
                    $output = array();
                                   if($total_val>0&&$total>0){
                    $calval = $total_val/$total;
                                   }else{
                    $calval = 0;
                                   }
                    $output['mean'] = $calval;
                    $output['percent'] = (($calval)*100)/5;
                    $output['total_val'] = $total;
                                   //print_r($data1);
                      array_push($out_arr, $output);
                      $a++;
                    }
                                        $num = 0;
                    foreach ($objQuery as $key_chkobj => $fetch_chk) { ?>
              <th><span style='float:right;'><?php echo number_format($out_arr[$num]['mean'],2)." : ".number_format($out_arr[$num]['percent'],2)." %" ?></span><?php   $num++;
                    } ?>
          <th></th>
                  </tr>
        </tfoot>
      </table>
    </div>
    <script type="text/javascript">

            $('#myTable_detail').DataTable({
              "language": {
                "zeroRecords": "<?php echo label('wg_datanotfound'); ?>",
                "infoEmpty": "<?php echo label('wg_datanotfound'); ?>",
                "sInfo":           "<?php echo label('sInfo'); ?>",
                "sInfoEmpty":      "<?php echo label('sInfoEmpty'); ?>",
                "decimal":        "",
                "emptyTable":     "<?php echo label('wg_datanotfound'); ?>",
                "infoPostFix":    "",
                "thousands":      ",",
                //"lengthMenu":     "แสดง _MENU_ รายการ",
                "lengthMenu":     "<?php echo label('lengthMenu'); ?>",
                "loadingRecords": "<?php echo label('loadingRecords'); ?>",
                "processing":     "<?php echo label('processing'); ?>",
                "search":         "<?php echo label('filter_bar'); ?>",
                "zeroRecords":    "<?php echo label('wg_datanotfound'); ?>",
                "paginate": {
                    "first":      "<?php echo label('firstpage'); ?>",
                    "last":       "<?php echo label('last'); ?>",
                    "next":       "<?php echo label('lrn_btn_next'); ?>",
                    "previous":   "<?php echo label('previous'); ?>"
                         },
              },
              "scrollX": true,
              dom: 'Bfrtip',
              buttons: [

                { extend: 'copyHtml5', header: true, footer: true,title: '<?php echo $lang=="thai"?"แบบสอบถามสำหรับรายวิชา ":"Survey for courses "; ?><?php echo $cname; ?>',
                message: '<?php echo $sv_title; ?>', },
                { extend: 'excelHtml5', header: true, footer: true,title: '<?php echo $lang=="thai"?"แบบสอบถามสำหรับรายวิชา ":"Survey for courses "; ?><?php echo $cname; ?>',
                message: '<?php echo $sv_title; ?>', },
                { extend: 'print', header: true, footer: true,title: '<?php echo $lang=="thai"?"แบบสอบถามสำหรับรายวิชา ":"Survey for courses "; ?><?php echo $cname; ?>',
                message: '<?php echo $sv_title; ?>', }
              ],
            });
    </script>
    <?php
  }

  public function updateSaveSVTC(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $output = array();
    $sv_id = isset($_REQUEST['sv_id'])?$_REQUEST['sv_id']:"";
    if(isset($_REQUEST['svde_id'])&&count($_REQUEST['svde_id'])>0){
        for ($i=0; $i < count($_REQUEST['svde_id']); $i++) { 
            $svde_id = isset($_REQUEST['svde_id'][$i])?$_REQUEST['svde_id'][$i]:"";
            $tc_answer = isset($_REQUEST['tc_answer'][$i])?$_REQUEST['tc_answer'][$i]:"";
            $tc_note = isset($_REQUEST['tc_note'][$i])?$_REQUEST['tc_note'][$i]:"";
            $arr_data = array(
              'sv_id' => $sv_id,
              'svde_id' => $svde_id,
              'emp_id' => $sess['emp_id'],
              'tc_answer' => $tc_answer,
              'tc_note' => $tc_note,
              'tc_finish' => date('Y-m-d H:i'),
              'tc_flag' => 'true',
              'tc_save' => 'true'
            );
            $fetch_svdetc = $this->func_query->query_row('LMS_SVDE_TC','','','','svde_id="'.$svde_id.'" and emp_id="'.$sess['emp_id'].'" and tc_isDelete="0"');
            $fetch_chk = $this->func_query->query_row('LMS_SV_TC','','','','sv_id="'.$sv_id.'" and emp_id = "'.$sess['emp_id'].'" and svtc_isDelete="0"');
            if(count($fetch_chk)==0){
              $arr_datamain = array(
                'sv_id' => $sv_id,
                'emp_id' => $sess['emp_id'],
                'svtc_firsttime' => date('Y-m-d H:i'),
                'svtc_createby' => $sess['u_id'],
                'svtc_createdate' => date('Y-m-d H:i'),
                'svtc_modifiedby' => $sess['u_id'],
                'svtc_modifieddate' => date('Y-m-d H:i')
              );
              $this->db->insert('LMS_SV_TC',$arr_datamain);
            }else{
              if($fetch_chk['svtc_firsttime']=="0000-00-00 00:00:00"){
                $arr_update = array(
                  'svtc_firsttime' => date('Y-m-d H:i'),
                  'svtc_modifiedby' => $sess['u_id'],
                  'svtc_modifieddate' => date('Y-m-d H:i')
                );
                $this->db->where('svtc_id',$fetch_chk['svtc_id']);
                $this->db->update('LMS_SV_TC',$arr_update);
              }
            }

            if(count($fetch_svdetc)>0){
              $this->db->where('tc_id',$fetch_svdetc['tc_id']);
              $this->db->update('LMS_SVDE_TC',$arr_data);
            }else{
              $this->db->insert('LMS_SVDE_TC',$arr_data);
            }
        }
      $output['msg'] = "2";
    }else{
      $output['msg'] = "0";
    }
    /*
    $svde_id = isset($_REQUEST['svde_id'])?$_REQUEST['svde_id']:"";
    $tc_answer = isset($_REQUEST['tc_answer'])?$_REQUEST['tc_answer']:"";
    $tc_note = isset($_REQUEST['tc_note'])?$_REQUEST['tc_note']:"";
    $emp_id = isset($_REQUEST['emp_id'])?$_REQUEST['emp_id']:"";
      if(count($fetch_chk)==0){
        $arr_datamain = array(
          'sv_id' => $sv_id,
          'emp_id' => $emp_id,
          'svtc_firsttime' => date('Y-m-d H:i'),
          'svtc_createby' => $sess['u_id'],
          'svtc_createdate' => date('Y-m-d H:i'),
          'svtc_modifiedby' => $sess['u_id'],
          'svtc_modifieddate' => date('Y-m-d H:i')
        );
        $this->db->insert('LMS_SV_TC',$arr_datamain);
      }else{
        if($fetch_chk['svtc_firsttime']=="0000-00-00 00:00:00"){
          $arr_update = array(
            'svtc_firsttime' => date('Y-m-d H:i'),
            'svtc_modifiedby' => $sess['u_id'],
            'svtc_modifieddate' => date('Y-m-d H:i')
          );
          $this->db->where('svtc_id',$fetch_chk['svtc_id']);
          $this->db->update('LMS_SV_TC',$arr_update);
        }
      }

    if(count($fetch_svdetc)>0){
      $this->db->where('tc_id',$fetch_svdetc['tc_id']);
      $this->db->update('LMS_SVDE_TC',$arr_data);
    }else{
      $this->db->insert('LMS_SVDE_TC',$arr_data);
    }
    $output['msg'] = "2";*/
    echo json_encode($output);
  }

  public function updateSaveSVMainTC(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user"); 
    $sv_id = isset($_REQUEST['sv_id'])?$_REQUEST['sv_id']:"";
    if(isset($_REQUEST['svde_id'])&&count($_REQUEST['svde_id'])>0){
        for ($i=0; $i < count($_REQUEST['svde_id']); $i++) { 
            $svde_id = isset($_REQUEST['svde_id'][$i])?$_REQUEST['svde_id'][$i]:"";
            $tc_answer = isset($_REQUEST['tc_answer'][$i])?$_REQUEST['tc_answer'][$i]:"";
            $tc_note = isset($_REQUEST['tc_note'][$i])?$_REQUEST['tc_note'][$i]:"";
            $arr_data = array(
              'sv_id' => $sv_id,
              'svde_id' => $svde_id,
              'emp_id' => $sess['emp_id'],
              'tc_answer' => $tc_answer,
              'tc_note' => $tc_note,
              'tc_finish' => date('Y-m-d H:i'),
              'tc_flag' => 'true',
              'tc_save' => 'true'
            );
            $fetch_svdetc = $this->func_query->query_row('LMS_SVDE_TC','','','','svde_id="'.$svde_id.'" and emp_id="'.$sess['emp_id'].'" and tc_isDelete="0"');
            $fetch_chk = $this->func_query->query_row('LMS_SV_TC','','','','sv_id="'.$sv_id.'" and emp_id = "'.$sess['emp_id'].'" and svtc_isDelete="0"');
            if(count($fetch_chk)==0){
              $arr_datamain = array(
                'sv_id' => $sv_id,
                'emp_id' => $sess['emp_id'],
                'svtc_firsttime' => date('Y-m-d H:i'),
                'svtc_createby' => $sess['u_id'],
                'svtc_createdate' => date('Y-m-d H:i'),
                'svtc_modifiedby' => $sess['u_id'],
                'svtc_modifieddate' => date('Y-m-d H:i')
              );
              $this->db->insert('LMS_SV_TC',$arr_datamain);
            }else{
              if($fetch_chk['svtc_firsttime']=="0000-00-00 00:00:00"){
                $arr_update = array(
                  'svtc_modifiedby' => $sess['u_id'],
                  'svtc_modifieddate' => date('Y-m-d H:i')
                );
                $this->db->where('svtc_id',$fetch_chk['svtc_id']);
                $this->db->update('LMS_SV_TC',$arr_update);
              }
            }

            if(count($fetch_svdetc)>0){
              $this->db->where('tc_id',$fetch_svdetc['tc_id']);
              $this->db->update('LMS_SVDE_TC',$arr_data);
            }else{
              $this->db->insert('LMS_SVDE_TC',$arr_data);
            }
        }
    $fetch_chk = $this->func_query->query_row('LMS_SV_TC','','','','sv_id="'.$sv_id.'" and emp_id = "'.$sess['emp_id'].'" and svtc_isDelete="0"');
      if(count($fetch_chk)>0){
        $arr_datamain = array(
          'svtc_status' => '1',
          'svtc_finishtime' => date('Y-m-d H:i'),
          'svtc_modifiedby' => $sess['u_id'],
          'svtc_modifieddate' => date('Y-m-d H:i')
        );
        $this->db->where('svtc_id',$fetch_chk['svtc_id']);
        $this->db->update('LMS_SV_TC',$arr_datamain);
        $output['msg'] = "2";
      }
      $output['msg'] = "2";
    }else{
      $output['msg'] = "0";
    }
    /*$sv_id = isset($_REQUEST['sv_id'])?$_REQUEST['sv_id']:"";
    $emp_id = isset($_REQUEST['emp_id'])?$_REQUEST['emp_id']:"";
    $fetch_chk = $this->func_query->query_row('LMS_SV_TC','','','','sv_id="'.$sv_id.'" and emp_id = "'.$emp_id.'" and svtc_isDelete="0"');
      if(count($fetch_chk)>0){
        $arr_datamain = array(
          'svtc_status' => '1',
          'svtc_finishtime' => date('Y-m-d H:i'),
          'svtc_modifiedby' => $sess['u_id'],
          'svtc_modifieddate' => date('Y-m-d H:i')
        );
        $this->db->where('svtc_id',$fetch_chk['svtc_id']);
        $this->db->update('LMS_SV_TC',$arr_datamain);
        $output['msg'] = "2";
      }else{
        $output['msg'] = "0";
      }*/
    echo json_encode($output);
  }

  public function query_coursemain(){
    $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
    $result = $this->func_query->query_row('LMS_COS','','','','cos_id = "'.$cos_id.'"');
    $result_tc = $this->func_query->query_row('LMS_TYPECOS','','','','tc_id = "'.$result['tc_id'].'"');
    $cos_lang = explode(',', $result['cos_lang']);
    $result['isTH'] = in_array('th',$cos_lang)?"1":"0";
    $result['isENG'] = in_array('eng',$cos_lang)?"1":"0";
    $result['isJP'] = in_array('jp',$cos_lang)?"1":"0";
    $result['is_lang_user_th'] = '';
    $result['is_lang_user_eng'] = '';
    $result['is_lang_user_jp'] = '';
    $result['select_lang'] = '';
    $result['tc_courselearner'] = $result_tc['tc_courselearner'];
    $cname = "";
    if($lang=="thai"){
        $result['select_lang'] = 'th';
        $result['is_lang_user_th'] = 'selected';
        if($result['isTH']=="1"){
          $cname = $result['cname_th'];
        }else{
          if($result['cname_th']==""){
            $cname = $result['cname_eng'];
          }
        }
    }else{
        $result['select_lang'] = 'eng';
        $result['is_lang_user_eng'] = 'selected';
        if($result['isENG']=="1"){
          $cname = $result['cname_eng'];
        }else{
          if($result['cname_eng']==""){
            $cname = $result['cname_th'];
          }
        }
    }
          $fetch_seat = $this->func_query->numrows('LMS_COS_ENROLL','','','','cos_id="'.$cos_id.'" and cosen_isDelete="0"');
          $result['isseatFull'] = "0";
          if(intval($result['seat_count'])>0&&$fetch_seat>=intval($result['seat_count'])){
            $result['isseatFull'] = "1";
          }
    $txt_period_course = label('UnlimitedTime');
    $datetime_now = date('Y-m-d H:i');
    $where = 'cos_id = "'.$cos_id.'" and ((date_start="0000-00-00 00:00:00" and date_end="0000-00-00 00:00:00") or ("$datetime_now" between date_start and date_end)) and cosde_isDelete="0" and cosde_status="1"';
    $result_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','', $where,'cosde_id DESC');
    if(count($result_detail)>0){
      if($result_detail['date_start']!="0000-00-00 00:00:00"&&$result_detail['date_end']!="0000-00-00 00:00:00"){
        if($lang=="thai"){
          $txt_period_course = date('d',strtotime($result_detail['date_start']))." ".$thaimonth[intval(date('m',strtotime($result_detail['date_start'])))]." ".(date('Y',strtotime($result_detail['date_start']))+543)." ".date('H:i',strtotime($result_detail['date_start']))." - ".date('d',strtotime($result_detail['date_end']))." ".$thaimonth[intval(date('m',strtotime($result_detail['date_end'])))]." ".(date('Y',strtotime($result_detail['date_end']))+543)." ".date('H:i',strtotime($result_detail['date_end']));
        }else{
          $txt_period_course = date('d F Y H:i',strtotime($result_detail['date_start']))." - ".date('d F Y H:i',strtotime($result_detail['date_end']));
        }
      }
    }
    $numqiz = $this->func_query->numrows('LMS_QIZ','','','','cos_id="'.$cos_id.'" and quiz_isDelete="0"');
    $result['isQiz'] = $numqiz>0?1:0;
    $fetch_chk = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id = "'.$cos_id.'" and cosde_isDelete="0" and cosde_status="1"','cosde_id DESC');
    if(count($fetch_chk)>0){
      $result['isData_period'] = "1";
      $result['cosde_id'] = $fetch_chk['cosde_id'];
    }else{
      $result['isData_period'] = "0";
    }
    $result['cname_main'] = $cname;
    $result['txt_period_course'] = $txt_period_course;
    echo json_encode($result);
    exit();
  }

  public function select_lang_lesson(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
    $les_lang = isset($_REQUEST['les_lang'])?$_REQUEST['les_lang']:"";
    $result = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');

    $output = array();
    $cos_lang = explode(',', $result['cos_lang']);
    $output['arr_lang'] = $cos_lang;
    $output['val_lang'] = $result['cos_lang'];
    echo json_encode($output);
    /*if(count($cos_lang)>0){

      echo "<optgroup label='".label('Chooselang')."'>";
      foreach ($cos_lang as $key) {
        $select_val = "";
        if($key==$les_lang){
          $select_val = "selected";
        }
        if($key=="th"){
          echo "<option value='".$key."' ".$select_val.">".label('thailand')."</option>";
        }else if($key=="eng"){
          echo "<option value='".$key."' ".$select_val.">".label('english')."</option>";
        }else{
          echo "<option value='".$key."' ".$select_val.">".label('japan')."</option>";
        }
      }
      $this->func_query->closeDB();
      echo "</optgroup>";
    }else{
      echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
    }*/
  }

  public function select_lang_qn(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $qn_id = isset($_REQUEST['qn_id'])?$_REQUEST['qn_id']:"";
    $result = $this->func_query->query_row('LMS_QUESTIONNAIRE','','','','qn_id="'.$qn_id.'"');

    $output = array();
    $qn_lang = explode(',', $result['qn_lang']);
    $output['arr_lang'] = $qn_lang;
    $output['val_lang'] = $result['qn_lang'];
    echo json_encode($output);
  }

  public function select_lang_qizex(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $qize_id = isset($_REQUEST['qize_id'])?$_REQUEST['qize_id']:"";
    $result = $this->func_query->query_row('LMS_QIZ_EXP','','','','qize_id="'.$qize_id.'"');

    $output = array();
    $qize_lang = explode(',', $result['qize_lang']);
    $output['arr_lang'] = $qize_lang;
    $output['val_lang'] = $result['qize_lang'];
    echo json_encode($output);
  }

  public function select_lang_survey(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $sv_id = isset($_REQUEST['sv_id'])?$_REQUEST['sv_id']:"";
    $result = $this->func_query->query_row('LMS_SV','','','','sv_id="'.$sv_id.'"');

    $output = array();
    $sv_lang = explode(',', $result['sv_lang']);
    $output['arr_lang'] = $sv_lang;
    $output['val_lang'] = $result['sv_lang'];
    echo json_encode($output);
  }

  public function select_lang_cosvideo(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
    $cosv_lang = isset($_REQUEST['cosv_lang'])?$_REQUEST['cosv_lang']:"";
    $result = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');

    $cos_lang = explode(',', $result['cos_lang']);
    if(count($cos_lang)>0){

      echo "<optgroup label='".label('Chooselang')."'>";
      foreach ($cos_lang as $key) {
        $select_val = "";
        if($key==$cosv_lang){
          $select_val = "selected";
        }
        if($key=="th"){
          echo "<option value='".$key."' ".$select_val.">".label('thailand')."</option>";
        }else if($key=="eng"){
          echo "<option value='".$key."' ".$select_val.">".label('english')."</option>";
        }else{
          echo "<option value='".$key."' ".$select_val.">".label('japan')."</option>";
        }
      }
      $this->func_query->closeDB();
      echo "</optgroup>";
    }else{
      echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
    }
  }

  public function recheckworkgroup(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
    $wg_id = isset($_REQUEST['wg_id'])?$_REQUEST['wg_id']:"";
    $result = $this->func_query->query_result('LMS_WKG','','','','com_id="'.$com_id.'" and wg_isDelete="0"');
    if(count($result)>0){

      echo "<optgroup label='".label('svplease')."'>";
      foreach ($result as $key => $value) {
        $select_val = "";
        if($key==$wg_id){
          $select_val = "selected";
        }
        $wtitle = $lang=="thai"?$value['wtitle_th']:$value['wtitle_en'];
        echo "<option value='".$value['wg_id']."' ".$select_val.">"."[".$value['wcode']."] ".$wtitle."</option>";
      }
      $this->func_query->closeDB();
      echo "</optgroup>";
    }else{
      echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
    }
  }

  public function rechecklevelmulti(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
    $posi_id = isset($_REQUEST['posi_id'])?$_REQUEST['posi_id']:"";
    $arr_lv = array();
    if($posi_id!=""){
        $fetch_level = $this->func_query->query_result('LMS_POSITION_LEVEL','','','','posi_id="'.$posi_id.'" and posilv_isDelete="0"');
        foreach ($fetch_level as $key => $value) {
            if(!in_array($value['lv_id'], $arr_lv)){
                array_push($arr_lv, $value['lv_id']);
            }
        }
    }
    $result = $this->func_query->query_result('LMS_LEVEL','','','','com_id="'.$com_id.'" and lv_isDelete="0"');
    if(count($result)>0){

      echo "<optgroup label='".label('svplease')."'>";
      foreach ($result as $key => $value) {
        $select_val = "";
        if(in_array($value['lv_id'], $arr_lv)){
          $select_val = "selected";
        }
        echo "<option value='".$value['lv_id']."' ".$select_val.">".$value['lv_code']."</option>";
      }
      $this->func_query->closeDB();
      echo "</optgroup>";
    }else{
      echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
    }
  }

  public function rechecklevelmulti_qiz(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
    $qiz_id = isset($_REQUEST['qiz_id'])?$_REQUEST['qiz_id']:"";
    $lv_id = isset($_REQUEST['lv_id'])?$_REQUEST['lv_id']:"";
    $arr_lv = array();
    if($qiz_id!=""){
        $fetch_level = $this->func_query->query_result('LMS_QIZ_LEVEL','','','','qiz_id="'.$qiz_id.'" and qizlv_isDelete="0"');
        foreach ($fetch_level as $key => $value) {
            if(!in_array($value['lv_id'], $arr_lv)){
                array_push($arr_lv, $value['lv_id']);
            }
        }
    }
    $result = $this->func_query->query_result('LMS_LEVEL','','','','com_id="'.$com_id.'" and lv_isDelete="0"');
    if(count($result)>0){
      if($lv_id==""){
        foreach ($result as $key => $value) {
          if(in_array($value['lv_id'], $arr_lv)){
            unset($result[$key]);
          }
        }
      }
      if(count($result)>0){
        echo "<optgroup label='".label('svplease')."'>";
        foreach ($result as $key => $value) {
          $select_val = "";
          if($value['lv_id'] == $lv_id){
            $select_val = "selected";
          }
          echo "<option value='".$value['lv_id']."' ".$select_val.">".$value['lv_code']."</option>";
        }
        echo "</optgroup>";
      }else{
        echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
      }
      $this->func_query->closeDB();
    }else{
      echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
    }
  }

  public function recheckposifdmulti(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
    $posi_id = isset($_REQUEST['posi_id'])?$_REQUEST['posi_id']:"";
    $posi_group = isset($_REQUEST['posi_group'])?$_REQUEST['posi_group']:"";
    $arr_posifd = array();
    if($posi_id!=""){
        $fetch_level = $this->func_query->query_result('LMS_POSITION_FIELD','','','','posi_id="'.$posi_id.'" and posifd_group="'.$posi_group.'"');
        foreach ($fetch_level as $key => $value) {
            if(!in_array($value['posifd_val'], $arr_posifd)){
                array_push($arr_posifd, $value['posifd_val']);
            }
        }
    }

    if($posi_group=="division"){
        $result = $this->func_query->query_result('LMS_DIVISION','','','','com_id="'.$com_id.'" and div_isDelete="0"','','','','div_id');
        if(count($result)>0){

          echo "<optgroup label='".label('svplease')."'>";
          foreach ($result as $key => $value) {
            $select_val = "";
            if(in_array($value['div_id'], $arr_posifd)){
              $select_val = "selected";
            }
            $div_name = $lang=="thai"?$value['div_name_th']:$value['div_name_en'];
            echo "<option value='".$value['div_id']."' ".$select_val.">".$div_name." (".$value['div_code'].")</option>";
          }
          $this->func_query->closeDB();
          echo "</optgroup>";
        }else{
          echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
        }
    }else if($posi_group=="group"){
        $result = $this->func_query->query_result('LMS_GROUP','','','','div_id in (select LMS_DIVISION.div_id from LMS_DIVISION where com_id = "'.$com_id.'" and div_isDelete = "0") and group_isDelete="0"','','','','group_id');
        if(count($result)>0){

          echo "<optgroup label='".label('svplease')."'>";
          foreach ($result as $key => $value) {
            $select_val = "";
            if(in_array($value['group_id'], $arr_posifd)){
              $select_val = "selected";
            }
            $group_name = $lang=="thai"?$value['group_name_th']:$value['group_name_en'];
            echo "<option value='".$value['group_id']."' ".$select_val.">".$group_name." (".$value['group_code'].")</option>";
          }
          $this->func_query->closeDB();
          echo "</optgroup>";
        }else{
          echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
        }
    }else if($posi_group=="department"){
        $where = 'group_id in (select LMS_GROUP.group_id from LMS_GROUP where div_id in (select LMS_DIVISION.div_id from LMS_DIVISION where com_id = "'.$com_id.'" and div_isDelete = "0") and group_isDelete = "0")';
        $result = $this->func_query->query_result('LMS_DEPART','','','','dep_isDelete="0" and '.$where,'','','','dep_id');
        if(count($result)>0){

          echo "<optgroup label='".label('svplease')."'>";
          foreach ($result as $key => $value) {
            $select_val = "";
            if(in_array($value['dep_id'], $arr_posifd)){
              $select_val = "selected";
            }
            $dep_name = $lang=="thai"?$value['dep_name_th']:$value['dep_name_en'];
            echo "<option value='".$value['dep_id']."' ".$select_val.">".$dep_name." (".$value['dep_code'].")</option>";
          }
          $this->func_query->closeDB();
          echo "</optgroup>";
        }else{
          echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
        }
    }else if($posi_group=="section"){
        $where = 'dep_id in (select LMS_DEPART.dep_id from LMS_DEPART where group_id in (select LMS_GROUP.group_id from LMS_GROUP where div_id in (select LMS_DIVISION.div_id from LMS_DIVISION where com_id = "'.$com_id.'" and div_isDelete = "0") and group_isDelete = "0") and LMS_DEPART.dep_isDelete = "0")';
        $result = $this->func_query->query_result('LMS_SECTION','','','','section_isDelete="0" and '.$where,'','','','section_id');
        if(count($result)>0){

          echo "<optgroup label='".label('svplease')."'>";
          foreach ($result as $key => $value) {
            $select_val = "";
            if(in_array($value['section_id'], $arr_posifd)){
              $select_val = "selected";
            }
            $section_name = $lang=="thai"?$value['section_name_th']:$value['section_name_en'];
            echo "<option value='".$value['section_id']."' ".$select_val.">".$section_name." (".$value['section_code'].")</option>";
          }
          $this->func_query->closeDB();
          echo "</optgroup>";
        }else{
          echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
        }
    }else if($posi_group=="sale"){
        $where = 'section_id  in (select LMS_SECTION.section_id from LMS_SECTION where dep_id in (select LMS_DEPART.dep_id from LMS_DEPART where group_id in (select LMS_GROUP.group_id from LMS_GROUP where div_id in (select LMS_DIVISION.div_id from LMS_DIVISION where com_id = "'.$com_id.'" and div_isDelete = "0") and group_isDelete = "0") and LMS_DEPART.dep_isDelete = "0") and section_isDelete = "0")   ';
        $result = $this->func_query->query_result('LMS_AREA','','','','salearea_isDelete="0" and '.$where,'','salearea_id,salearea_code,salearea_name_th,salearea_name_en','','salearea_id');
        if(count($result)>0){

          echo "<optgroup label='".label('svplease')."'>";
          foreach ($result as $key => $value) {
            $select_val = "";
            if(in_array($value['salearea_id'], $arr_posifd)){
              $select_val = "selected";
            }
            $salearea_name = $lang=="thai"?$value['salearea_name_th']:$value['salearea_name_en'];
            echo "<option value='".$value['salearea_id']."' ".$select_val.">".$salearea_name." (".$value['salearea_code'].")</option>";
          }
          $this->func_query->closeDB();
          echo "</optgroup>";
        }else{
          echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
        }
    }
  }

  public function query_status_cos(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    date_default_timezone_set("Asia/Bangkok");
    $this->func_query->loadDB();
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
    $type = isset($_REQUEST['type'])?$_REQUEST['type']:"";
    $sess = $this->session->userdata("user");
    $date_now = date('Y-m-d H:i');
    if($type=="1"){
      $where = '';
      if($com_id!=""){
        $where = ' and LMS_COS.com_id = "'.$com_id.'"';
      }
      $courses_total = $this->func_query->query_result('LMS_COS','','','','cos_approve="1" and cos_public="1" and cos_status="1" and cos_isDelete="0"'.$where);

      $courses_ongoing = 0;
      $courses_completed = 0;
      $courses_incoming = 0;
      $courses_close = 0;
      if(count($courses_total)>0){
              foreach ($courses_total as $key_list => $value_list) {
                  if(isset($courses_total[$key_list])){
                              $result_chkcg = $this->func_query->numrows('LMS_COSINCG','LMS_COG','LMS_COSINCG.cg_id = LMS_COG.cg_id','','LMS_COSINCG.course_id="'.$value_list['cos_id'].'" and LMS_COG.cg_status="1" and LMS_COG.cg_approve="1" and LMS_COG.cg_isDelete="0"');
                              if($result_chkcg==0){
                                unset($courses_total[$key_list]);
                              }
                  }
              }
      }
      if(count($courses_total)>0){
          foreach ($courses_total as $key_list => $value_list) {
              $completed = $this->func_query->numrows('LMS_COS_ENROLL','','','','cos_id = "'.$value_list['cos_id'].'" and cosen_status="1" and cosen_status_sub="1"');
              $courses_completed += $completed;
              $fetch_chk_ug = $this->func_query->query_row('LMS_COS_DETAIL','','','','LMS_COS_DETAIL.cos_id = "'.$value_list['cos_id'].'"');
              if(count($fetch_chk_ug)>0){
                if($fetch_chk_ug['date_start']!="0000-00-00 00:00:00"&&$fetch_chk_ug['date_end']!="0000-00-00 00:00:00"){
                  if(date('Y-m-d H:i',strtotime($fetch_chk_ug['date_start']))>date('Y-m-d H:i')){
                      $courses_incoming++;
                  }
                  if(date('Y-m-d H:i',strtotime($fetch_chk_ug['date_end']))<date('Y-m-d H:i')){
                      $courses_close++;
                  }
                  if(date('Y-m-d H:i',strtotime($fetch_chk_ug['date_start']))<=date('Y-m-d H:i')&&date('Y-m-d H:i',strtotime($fetch_chk_ug['date_end']))>=date('Y-m-d H:i')){
                      $courses_ongoing++;
                  }
                }else{
                  $courses_ongoing++;
                }
              }else{
                $courses_ongoing++;
              }
          }
      }
      $courses_total = $courses_ongoing+$courses_incoming+$courses_close;
    }else{
      $courses_total = $this->func_query->query_result('LMS_COS','','','','cos_approve="1" and cos_public="1" and cos_status="1" and cos_isDelete="0"');
      $courses_ongoing = 0;
      $courses_completed = 0;
      $courses_incoming = 0;
      $courses_close = 0;
      if(count($courses_total)>0){
              foreach ($courses_total as $key_list => $value_list) {
                  if(isset($courses_total[$key_list])){
                              $result_chkcg = $this->func_query->numrows('LMS_COSINCG','LMS_COG','LMS_COSINCG.cg_id = LMS_COG.cg_id','','LMS_COSINCG.course_id="'.$value_list['cos_id'].'" and LMS_COG.cg_status="1" and LMS_COG.cg_approve="1" and LMS_COG.cg_isDelete="0"');
                              if($result_chkcg==0){
                                unset($courses_total[$key_list]);
                              }
                  }
              }
        foreach ($courses_total as $key_list => $value_list) {
          $fetch_status = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$value_list['cos_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_isDelete="0"');
          if(count($fetch_status)==0){
            $fetch_chk_ug = $this->func_query->query_row('LMS_COS_DETAIL','LMS_COS_DETAIL_UG','LMS_COS_DETAIL.cosde_id = LMS_COS_DETAIL_UG.cosde_id','','LMS_COS_DETAIL_UG.posi_id = "'.$sess['posi_id'].'" and LMS_COS_DETAIL.cos_id = "'.$value_list['cos_id'].'"');
            if(count($fetch_chk_ug)==0){
              unset($courses_total[$key_list]);
            }else{
                  if($fetch_chk_ug['date_start']!="0000-00-00 00:00:00"&&$fetch_chk_ug['date_end']!="0000-00-00 00:00:00"){
                    if(date('Y-m-d H:i',strtotime($fetch_chk_ug['date_start']))>date('Y-m-d H:i')){
                        $courses_incoming++;
                    }
                    if(date('Y-m-d H:i',strtotime($fetch_chk_ug['date_start']))<=date('Y-m-d H:i')&&date('Y-m-d H:i',strtotime($fetch_chk_ug['date_end']))>=date('Y-m-d H:i')){
                        $courses_ongoing++;
                    }
                  }else{
                      $courses_ongoing++;
                  }
            }
          }else{
           // $fetch_chk_ug = $this->func_query->query_row('LMS_COS_DETAIL','LMS_COS_DETAIL_UG','LMS_COS_DETAIL.cosde_id = LMS_COS_DETAIL_UG.cosde_id','','LMS_COS_DETAIL_UG.posi_id = "'.$sess['posi_id'].'" and LMS_COS_DETAIL.cos_id = "'.$value_list['cos_id'].'"');
            $fetch_chk_ug = $this->func_query->query_row('LMS_COS_DETAIL','','','','LMS_COS_DETAIL.cos_id = "'.$value_list['cos_id'].'"');
            if($fetch_status['cosen_status']=="1" && $fetch_status['cosen_status_sub']=="1"){              
              /*if(($fetch_chk_ug['date_start']=="0000-00-00 00:00:00"&&$fetch_chk_ug['date_end']=="0000-00-00 00:00:00")||(date('Y-m-d H:i',strtotime($fetch_chk_ug['date_start']))<=date('Y-m-d H:i')&&date('Y-m-d H:i',strtotime($fetch_chk_ug['date_end']))>=date('Y-m-d H:i'))){
              }*/
                if(count($fetch_chk_ug)>0){
                  if(($fetch_chk_ug['date_start']=="0000-00-00 00:00:00"&&$fetch_chk_ug['date_end']=="0000-00-00 00:00:00")||(date('Y-m-d H:i',strtotime($fetch_chk_ug['date_end']))>=date('Y-m-d H:i')&&date('Y-m-d H:i',strtotime($fetch_chk_ug['date_start']))<=date('Y-m-d H:i'))){

                    $courses_completed++;
                  }
                }else{
                  $courses_completed++;
                }
            }else{
                if(count($fetch_chk_ug)>0){
                  if($fetch_chk_ug['date_start']!="0000-00-00 00:00:00"&&$fetch_chk_ug['date_end']!="0000-00-00 00:00:00"){
                    if(date('Y-m-d H:i',strtotime($fetch_chk_ug['date_start']))>date('Y-m-d H:i')){
                        $courses_incoming++;
                    }
                    if(date('Y-m-d H:i',strtotime($fetch_chk_ug['date_start']))<=date('Y-m-d H:i')&&date('Y-m-d H:i',strtotime($fetch_chk_ug['date_end']))>=date('Y-m-d H:i')){
                        $courses_ongoing++;
                    }
                  }else{
                    $courses_ongoing++;
                  }
                }else{
                  $courses_ongoing++;
                }
            }
          } 
        }
      }
      /*$courses_ongoing = $this->func_query->numrows('LMS_COS','LMS_COS_DETAIL','LMS_COS_DETAIL.cos_id = LMS_COS.cos_id','','LMS_COS.com_id="'.$com_id.'" and LMS_COS.cos_approve="1" and LMS_COS.cos_public="1" and LMS_COS.cos_isDelete="0" and LMS_COS_DETAIL.cosde_isDelete="0" and ((LMS_COS_DETAIL.date_start="0000-00-00 00:00:00" and LMS_COS_DETAIL.date_end="0000-00-00 00:00:00") or (LMS_COS_DETAIL.date_start <= "'.$date_now.'" and  LMS_COS_DETAIL.date_end >= "'.$date_now.'")) and LMS_COS.cos_id  in (select distinct cos_id from LMS_COS_DETAIL inner join LMS_COS_DETAIL_UG on LMS_COS_DETAIL.cosde_id = LMS_COS_DETAIL_UG.cosde_id where LMS_COS_DETAIL_UG.posi_id = "'.$sess['posi_id'].'") and LMS_COS.cos_id not in (select LMS_COS_ENROLL.cos_id from LMS_COS_ENROLL where emp_id ="'.$sess['emp_id'].'" and cosen_status="1" and cosen_status_sub="1" )');
      $courses_completed = $this->func_query->numrows('LMS_COS_ENROLL','','','','cos_id in (select cos_id from LMS_COS where com_id="'.$com_id.'" and cos_approve="1" and cos_public="1" and cos_isDelete="0") and cosen_status="1" and cosen_status_sub="1" and LMS_COS_ENROLL.emp_id="'.$sess['emp_id'].'"');*/

      /*$courses_incoming = $this->func_query->query_result('LMS_COS','LMS_COS_DETAIL','LMS_COS_DETAIL.cos_id = LMS_COS.cos_id','','LMS_COS.com_id="'.$com_id.'" and LMS_COS.cos_approve="1" and LMS_COS.cos_public="1" and LMS_COS.cos_isDelete="0" and LMS_COS_DETAIL.cosde_isDelete="0" and LMS_COS_DETAIL.date_start > "'.$date_now.'" ');
      if(count($courses_incoming)>0){
              foreach ($courses_incoming as $key_list => $value_list) {
                  if(isset($courses_incoming[$key_list])){
                              $result_chkcg = $this->func_query->numrows('LMS_COSINCG','LMS_COG','LMS_COSINCG.cg_id = LMS_COG.cg_id','','LMS_COSINCG.course_id="'.$value_list['cos_id'].'" and LMS_COG.cg_status="1" and LMS_COG.cg_approve="1" and LMS_COG.cg_isDelete="0"');
                              if($result_chkcg==0){
                                unset($courses_incoming[$key_list]);
                              }
                  }
              }
        foreach ($courses_incoming as $key_list => $value_list) {
          $fetch_status = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$value_list['cos_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_isDelete="0"');
          if(count($fetch_status)==0){
            $fetch_chk_ug = $this->func_query->query_result('LMS_COS_DETAIL','LMS_COS_DETAIL_UG','LMS_COS_DETAIL.cosde_id = LMS_COS_DETAIL_UG.cosde_id','','LMS_COS_DETAIL_UG.posi_id = "'.$sess['posi_id'].'" and LMS_COS_DETAIL.cos_id = "'.$value_list['cos_id'].'"');
            if(count($fetch_chk_ug)==0){
              unset($courses_incoming[$key_list]);
            }
          }
        }
      }
      $courses_incoming = count($courses_incoming);*/
      $courses_total = $courses_ongoing+$courses_incoming+$courses_completed;
      //$courses_total = $courses_ongoing+$courses_incoming;
    }
    $output = array();
    $output['courses_total'] = $courses_total;
    $output['courses_ongoing'] = $courses_ongoing;
    $output['courses_incoming'] = $courses_incoming;
    $output['courses_completed'] = $courses_completed;
    $output['courses_close'] = $courses_close;
    echo json_encode($output);
  }

  public function rechk_lang_lesson(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
    $les_id = isset($_REQUEST['les_id'])?$_REQUEST['les_id']:"";
    $result = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');

    $cos_lang = explode(',', $result['cos_lang']);
    $result['isTH'] = in_array('th',$cos_lang)?"1":"0";
    $result['isENG'] = in_array('eng',$cos_lang)?"1":"0";
    $result['isJP'] = in_array('jp',$cos_lang)?"1":"0";

    echo json_encode($result);
    exit();
  }

  public function update_cert_data(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
    $result = $this->func_query->query_row('LMS_BAD','','','','courses_id = "'.$cos_id.'"');

    echo json_encode($result);
    exit();
  }

  public function update_course_detail_data(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
      date_default_timezone_set("Asia/Bangkok");
    $cosde_id = isset($_REQUEST['cosde_id'])?$_REQUEST['cosde_id']:"";
    $result = $this->func_query->query_row('LMS_COS_DETAIL','','','','cosde_id = "'.$cosde_id.'"');
    if(count($result)>0){
        if($result['date_start']!="0000-00-00 00:00:00"){
          $result['date_start_var'] = $result['date_start'];
          $result['time_start'] = date('H:i',strtotime($result['date_start']));
          $result['date_start'] = date('d/m/Y',strtotime($result['date_start']));
        }else{
          $result['date_start'] = "";
          $result['time_start'] = "00:00";
          $result['date_start_var'] = "";
        }

        if($result['date_end']!="0000-00-00 00:00:00"){
          $result['date_end_var'] = $result['date_end'];
          $result['time_end'] = date('H:i',strtotime($result['date_end']));
          $result['date_end'] = date('d/m/Y',strtotime($result['date_end']));
        }else{
          $result['date_end'] = "";
          $result['time_end'] = "23:59";
          $result['date_end_var'] = "";
        }
    }else{
          $result['date_start'] = "";
          $result['time_start'] = "00:00";
          $result['date_start_var'] = "";

          $result['date_end'] = "";
          $result['time_end'] = "23:59";
          $result['date_end_var'] = "";
    }

    $result_cos = $this->func_query->query_row('LMS_COS','','','','cos_id = "'.$result['cos_id'].'"');
          $result['date_start_condition'] = "";
            if($result_cos['condition']!=""){
              $var_cos = "";
              $condition = explode(',', $result_cos['condition']);
              if(count($condition)>0){
                $fetch_chk_con = $this->func_query->query_row('LMS_COS','LMS_COS_DETAIL','LMS_COS_DETAIL.cos_id = LMS_COS.cos_id','','LMS_COS.cos_public="1" and LMS_COS.cos_status="1" and LMS_COS.cos_isDelete="0" and LMS_COS.cos_id in ('.$result_cos['condition'].') and LMS_COS_DETAIL.date_end!="0000-00-00 00:00:00"','LMS_COS_DETAIL.date_end DESC');
                if(count($fetch_chk_con)>0){
                  $result['date_start_condition'] = date('d/m/Y',strtotime($fetch_chk_con['date_end']." +1day"));
                }
              }
            }
    echo json_encode($result);
    exit();
  }

  public function query_course_detail_data(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
      date_default_timezone_set("Asia/Bangkok");
    $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
    $result = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id = "'.$cos_id.'" and cosde_isDelete="0"');
    if(count($result)>0){
        if($result['date_start']!="0000-00-00 00:00:00"){
          $result['date_start_var'] = date('Y-m-d',strtotime($result['date_start']));
          $result['time_start'] = date('H:i',strtotime($result['date_start']));
          $result['date_start'] = date('d/m/Y',strtotime($result['date_start']));
          $result['isData'] = "1";
        }else{
          $result['date_start'] = "";
          $result['time_start'] = "00:00";
          $result['date_start_var'] = "";
          $result['isData'] = "0";
        }

        if($result['date_end']!="0000-00-00 00:00:00"){
          $result['date_end_var'] = date('Y-m-d',strtotime($result['date_end']));
          $result['time_end'] = date('H:i',strtotime($result['date_end']));
          $result['date_end'] = date('d/m/Y',strtotime($result['date_end']));
          $result['isData'] = "1";
        }else{
          $result['isData'] = "0";
          $result['date_end'] = "";
          $result['time_end'] = "23:59";
          $result['date_end_var'] = "";
        }
    }else{
          $result['isData'] = "0";
          $result['date_start'] = "";
          $result['time_start'] = "00:00";
          $result['date_start_var'] = "";

          $result['date_end'] = "";
          $result['time_end'] = "23:59";
          $result['date_end_var'] = "";
    }
    echo json_encode($result);
    exit();
  }


  public function update_quiz_detail_data(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->load->model('Course_model', 'course', FALSE);
    $this->func_query->loadDB();
    $qiz_id = isset($_REQUEST['qiz_id'])?$_REQUEST['qiz_id']:"";
    $result = $this->func_query->query_row('LMS_QIZ','','','','qiz_id = "'.$qiz_id.'"');
      $fetch_ques = $this->func_query->numrows('LMS_QUES','','','','qiz_id="'.$qiz_id.'" and ques_isDelete="0"');
      //$result_ques = $this->course->recheck_total('LMS_QUES','qiz_id',$_REQUEST['qiz_id'],'');
      $result['result_ques'] = $fetch_ques;
        if($result['period_open']!="0000-00-00 00:00:00"){
          $result['time_start'] = date('H:i',strtotime($result['period_open']));
          $result['period_open_var'] = $result['period_open'];
          $result['period_open'] = date('d/m/Y',strtotime($result['period_open']));
        }else{
          $result['period_open'] = "";
          $result['time_start'] = "00:00";
          $result['period_open_var'] = "";
        }

        if($result['period_end']!="0000-00-00 00:00:00"){
          $result['time_end'] = date('H:i',strtotime($result['period_end']));
          $result['period_end_var'] = $result['period_end'];
          $result['period_end'] = date('d/m/Y',strtotime($result['period_end']));
        }else{
          $result['period_end'] = "";
          $result['time_end'] = "23:59";
          $result['period_end_var'] = "";
        }
    echo json_encode($result);
    exit();
  }


  public function update_survey_detail_data(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    $this->load->model('Manage_model', 'manage', FALSE);
    $this->manage->loadDB();
    if(count($_REQUEST)>0){
      $result = $this->manage->query_data_onupdate($_REQUEST['sv_id_update'],'LMS_SURVEY','sv_id');
      if($result['survey_open']!="0000-00-00 00:00:00"){
        $result['time_start'] = date('H:i',strtotime($result['survey_open']));
        $result['survey_open_var'] = $result['survey_open'];
        $result['survey_open'] = date('d/m/Y',strtotime($result['survey_open']));
      }else{
        $result['survey_open_var'] = "";
        $result['survey_open'] = "";
        $result['time_start'] = "00:00";
      }
      if($result['survey_end']!="0000-00-00 00:00:00"){
        $result['time_end'] = date('H:i',strtotime($result['survey_end']));
        $result['survey_end_var'] = $result['survey_end'];
        $result['survey_end'] = date('d/m/Y',strtotime($result['survey_end']));
      }else{
        $result['survey_end_var'] = "";
        $result['survey_end'] = "";
        $result['time_end'] = "23:59";
      }
      if(isset($_REQUEST['type'])){
          if($_REQUEST['lang_select']=="thai"){ 
                    $sv_title = $result['sv_title_th']!=""?$result['sv_title_th']:$result['sv_title_eng'];
                    $sv_title = $sv_title!=""?$sv_title:$result['sv_title_jp'];
                    $sv_explanation = $result['sv_explanation_th']!=""?$result['sv_explanation_th']:$result['sv_explanation_eng'];
                    $sv_explanation = $sv_explanation!=""?$sv_explanation:$result['sv_explanation_jp'];
          }else if($_REQUEST['lang_select']=="english"){ 
                    $sv_title = $result['sv_title_eng']!=""?$result['sv_title_eng']:$result['sv_title_th'];
                    $sv_title = $sv_title!=""?$sv_title:$result['sv_title_jp'];
                    $sv_explanation = $result['sv_explanation_eng']!=""?$result['sv_explanation_eng']:$result['sv_explanation_th'];
                    $sv_explanation = $sv_explanation!=""?$sv_explanation:$result['sv_explanation_jp'];
          }else{
                    $sv_title = $result['sv_title_jp']!=""?$result['sv_title_jp']:$result['sv_title_eng'];
                    $sv_title = $sv_title!=""?$sv_title:$result['sv_title_th'];
                    $sv_explanation = $result['sv_explanation_jp']!=""?$result['sv_explanation_jp']:$result['sv_explanation_eng'];
                    $sv_explanation = $sv_explanation!=""?$sv_explanation:$result['sv_explanation_th'];
          }
          $result['sv_title'] = $sv_title;
          $result['sv_explanation'] = $sv_explanation;
      }
    }
    echo json_encode($result);
    exit();
  }

  public function update_survey_data(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    $this->load->model('Manage_model', 'manage', FALSE);
    $this->manage->loadDB();
    if(count($_REQUEST)>0){
      $result = $this->manage->query_data_onupdate($_REQUEST['sv_id'],'LMS_SV','sv_id');
      if($result['sv_open']!="0000-00-00 00:00:00"){
        $result['time_start'] = date('H:i',strtotime($result['sv_open']));
        $result['sv_open_var'] = $result['sv_open'];
        $result['sv_open'] = date('d/m/Y',strtotime($result['sv_open']));
      }else{
        $result['sv_open_var'] = "";
        $result['sv_open'] = "";
        $result['time_start'] = "00:00";
      }
      if($result['sv_end']!="0000-00-00 00:00:00"){
        $result['time_end'] = date('H:i',strtotime($result['sv_end']));
        $result['sv_end_var'] = $result['sv_end'];
        $result['sv_end'] = date('d/m/Y',strtotime($result['sv_end']));
      }else{
        $result['sv_end_var'] = "";
        $result['sv_end'] = "";
        $result['time_end'] = "23:59";
      }
          if($lang=="thai"){ 
                    $sv_title = $result['sv_title_th']!=""?$result['sv_title_th']:$result['sv_title_eng'];
                    $sv_title = $sv_title!=""?$sv_title:$result['sv_title_jp'];
          }else if($lang=="english"){ 
                    $sv_title = $result['sv_title_eng']!=""?$result['sv_title_eng']:$result['sv_title_th'];
                    $sv_title = $sv_title!=""?$sv_title:$result['sv_title_jp'];
          }else{
                    $sv_title = $result['sv_title_jp']!=""?$result['sv_title_jp']:$result['sv_title_eng'];
                    $sv_title = $sv_title!=""?$sv_title:$result['sv_title_th'];
          }
          $result['sv_titlename'] = $sv_title;

      $sv_lang = explode(',', $result['sv_lang']);
      $result['isTH'] = in_array('th',$sv_lang)?"1":"0";
      $result['isENG'] = in_array('eng',$sv_lang)?"1":"0";
      $result['isJP'] = in_array('jp',$sv_lang)?"1":"0";
    }
    echo json_encode($result);
    exit();
  }

  public function update_score_data(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
    $result = $this->func_query->query_row('LMS_CUG','','','','course_id = "'.$cos_id.'"');

    echo json_encode($result);
    exit();
  }

  public function update_cosvideo_data(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $cosv_id = isset($_REQUEST['cosv_id'])?$_REQUEST['cosv_id']:"";
    $result = $this->func_query->query_row('LMS_COS_VIDEO','','','','cosv_id = "'.$cosv_id.'"');

    echo json_encode($result);
    exit();
  }

  public function update_cosdoc_data(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $fil_cos_id = isset($_REQUEST['fil_cos_id'])?$_REQUEST['fil_cos_id']:"";
    $result = $this->func_query->query_row('LMS_COS_FIL','','','','fil_cos_id = "'.$fil_cos_id.'"');

    echo json_encode($result);
    exit();
  }

  public function query_cos_preview(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
    $result = $this->func_query->query_row('LMS_COS','','','','cos_id = "'.$cos_id.'"');

         $fetch_employee = $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_EMP.emp_id = LMS_USP.emp_id','','LMS_USP.u_id = "'.$result['cos_createby'].'"');
         $fetch_division = $this->func_query->query_row('LMS_DIVISION','','','','div_id = "'.$fetch_employee['div_id'].'"');
         $txt_name = $lang=="thai"?$fetch_employee['fullname_th']:$fetch_employee['fullname_en'];
         $txt_div = $lang=="thai"?$fetch_division['div_name_th']:$fetch_division['div_name_en'];
         $cos_lang = explode(',', $result['cos_lang']);
         $result['isTH'] = in_array('th',$cos_lang)?"1":"0";
         $result['isENG'] = in_array('eng',$cos_lang)?"1":"0";
         $cname = "";
         $cdesc = "";
        if($lang=="thai"){
             if($result['isTH']=="1"){
               $cname = html_entity_decode($result['cname_th'], ENT_QUOTES, "UTF-8");
               $cdesc = html_entity_decode($result['cdesc_th'], ENT_QUOTES, "UTF-8");
             }else{
               if($result['cname_th']==""){
                 $cname = html_entity_decode($result['cname_eng'], ENT_QUOTES, "UTF-8");
                 $cdesc = html_entity_decode($result['cdesc_eng'], ENT_QUOTES, "UTF-8");
               }
             }
        }else if($lang=="english"){
             if($result['isENG']=="1"){
                  $cname = html_entity_decode($result['cname_eng'], ENT_QUOTES, "UTF-8");
                  $cdesc = html_entity_decode($result['cdesc_eng'], ENT_QUOTES, "UTF-8");
             }else{
              if($result['cname_eng']==""){
                  $cname = html_entity_decode($result['cname_th'], ENT_QUOTES, "UTF-8");
                  $cdesc = html_entity_decode($result['cdesc_th'], ENT_QUOTES, "UTF-8");
              }
             }
        }
        $img_headcourse = REAL_PATH."/images/cover_course.jpg";
        if(is_file(ROOT_DIR."uploads/course/".$result['cos_pic'])){
          $img_headcourse = REAL_PATH."uploads/course/".$result['cos_pic'];
        }
        $result['txt_headcourse'] = $cname;
        $result['txt_course_by'] = label('Course_by')." ".$txt_name." / ".$txt_div;
        $result['txt_detailcourse'] = $cdesc;
        $result['img_headcourse'] = $img_headcourse;
    echo json_encode($result);
    exit();
  }

  public function query_lesson(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->load->model('Lesson_model', 'lesson', FALSE);
    $this->load->model('Course_model', 'course', FALSE);
    $this->func_query->loadDB();
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $les_id = isset($_REQUEST['les_id'])?$_REQUEST['les_id']:"";
    $status_study = isset($_REQUEST['status_study'])?$_REQUEST['status_study']:"";
    $result = $this->func_query->query_row('LMS_LES','','','','les_id = "'.$les_id.'"');
    if($status_study=="1"){
      $num_tc = $this->func_query->numrows('LMS_LES_TC','','','','emp_id = "'.$sess['emp_id'].'" and les_id = "'.$les_id.'"');
      if($num_tc==0){
        $arr_lestc = array(
          'emp_id' => $user['emp_id'],
          'les_id' => $_REQUEST['les_id_update'],
          'learn_status' => '1'
        );
        $this->lesson->createTC($arr_lestc);
      }
      $this->course->firsttime_les($result['cos_id']);
    }
    $num_fil = $this->func_query->numrows('LMS_FIL','','','','lessons_id = "'.$les_id.'"');

    $result['num_fil'] = $num_fil;
    if($result['time_start']!="0000-00-00 00:00:00"){
        $result['time_start_les'] = date('H:i',strtotime($result['time_start']));
        $result['date_start_les_var'] = $result['time_start'];
        $result['time_start'] = date('d/m/Y',strtotime($result['time_start']));
    }else{
        $result['time_start'] = "";
        $result['time_start_les'] = "00:00";
        $result['date_start_les_var'] = "";
    }

    if($result['time_end']!="0000-00-00 00:00:00"){
        $result['time_end_les'] = date('H:i',strtotime($result['time_end']));
        $result['date_end_les_var'] = $result['time_end'];
        $result['time_end'] = date('d/m/Y',strtotime($result['time_end']));
    }else{
        $result['time_end'] = "";
        $result['time_end_les'] = "23:59";
        $result['date_end_les_var'] = "";
    }
    if($result['les_type']=="1"){
        $url = $this->query_data_arr($les_id, 'LMS_MED','type','url');
        $result['upload'] = $this->query_data_arr($les_id, 'LMS_MED','type','upload');
        $result['document'] = $this->query_data_arr($les_id, 'LMS_FIL','','');
        $result['url'] = "";
        if(count($url)>0){
          $num_url = 0;
          foreach ($url as $key => $value) {
            $result['url'] .= $value['video'];
              $num_url++;
            if($num_url<count($url)){
              $result['url'] .= ",";
            }
          }
        }
    }else{
        $result['scorm'] = $this->func_query->query_row('LMS_SCM','','','','lessons_id="'.$les_id.'"');
    }
    echo json_encode($result);
    exit();
  }


  public function query_data_arr($id, $datatable,$fieldname,$type) {
      $this->db->from($datatable);
      if($type!=""){
          $this->db->where($fieldname, $type);
      }
      $this->db->where('lessons_id', $id);
      $query = $this->db->get();
      return $query->result_array();
  }

  public function recheckcompany(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
    $result = $this->func_query->query_result('LMS_COMPANY','','','','com_isDelete="0" and com_id!="1"');
    if(count($result)>0){
      echo "<optgroup label='".label('please_com_name')."'>";
      $numloop = 1;
      foreach ($result as $key) {
        $select_val = "";
        if($key['com_id']==$com_id){
          $select_val = "selected";
        }
        $com_code = "";
        if($key['com_code']!=""){
          $com_code = " (".$key['com_code'].")";
        }
        if($lang=="thai"){
          echo "<option value='".$key['com_id']."' ".$select_val.">".$key['com_name_th'].$com_code."</option>";
        }else{
          echo "<option value='".$key['com_id']."' ".$select_val.">".$key['com_name_eng'].$com_code."</option>";
        }
      }
      $this->func_query->closeDB();
      echo "</optgroup>";
    }else{
      echo '<option value="">'.label('wg_datanotfound').'</option>';
    }
  }

  public function recheckcompany_optionreport(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
    $com_admin = isset($_REQUEST['com_admin'])?$_REQUEST['com_admin']:"";
    $result = $this->func_query->query_result('LMS_COMPANY','','','','com_isDelete="0" and com_id!="1" and com_admin="'.$com_admin.'"');
    if(count($result)>0){
      echo "<optgroup label='".label('please_com_name')."'>";
      $numloop = 1;
      foreach ($result as $key) {
        $select_val = "";
        if($key['com_id']==$com_id){
          $select_val = "selected";
        }
        $com_code = "";
        if($key['com_code']!=""){
          $com_code = " (".$key['com_code'].")";
        }
        $com_name = $lang=="thai"?$key['com_name_th'].$com_code:$key['com_name_eng'].$com_code;
        echo "<option value='".$key['com_id']."' ".$select_val.">".$com_name."</option>";
      }
      $this->func_query->closeDB();
      echo "</optgroup>";
    }else{
      echo '<option value="">'.label('wg_datanotfound').'</option>';
    }
  }

  public function recheckdepart_optionreport(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $dep_id = isset($_REQUEST['dep_id'])?$_REQUEST['dep_id']:"";
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
    $result = $this->func_query->query_result('LMS_DEPART','','','','dep_isDelete="0" and dep_status="1" and com_id="'.$com_id.'"');
    if(count($result)>0){
      echo "<optgroup label='".label('svplease')."'>";
      echo '<option value="" selected>'.label('r_company').'</option>';
      $numloop = 1;
      foreach ($result as $key) {
        $select_val = "";
        if($key['dep_id']==$dep_id){
          $select_val = "selected";
        }
        $dep_name = $lang=="thai"?$key['dep_name_th'].$com_code:$key['dep_name_en'];
        echo "<option value='".$key['dep_id']."' ".$select_val.">".$dep_name."</option>";
      }
      $this->func_query->closeDB();
      echo "</optgroup>";
    }else{
      echo '<option value="">'.label('wg_datanotfound').'</option>';
    }
  }

  public function option_coursegroups(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
    $result = $this->func_query->query_result('LMS_COG','','','','wg_id in (select LMS_WKG.wg_id from LMS_WKG where com_id = "'.$com_id.'") and cg_approve="1" and cg_isDelete="0" and cg_status="1"');
    if(count($result)>0){
      echo '<option value="" selected>'.label('allcoursegroup').'</option>';
      $numloop = 1;
      foreach ($result as $key) {
        $select_val = "";
        if($lang=="thai"){ 
            $cgtitle = $key['cgtitle_th']!=""?$key['cgtitle_th']:$key['cgtitle_en'];
        }else{ 
            $cgtitle = $key['cgtitle_en']!=""?$key['cgtitle_en']:$key['cgtitle_th'];
        }
        echo "<option value='".$key['cg_id']."'>".$cgtitle."</option>";
      }
      $this->func_query->closeDB();
    }else{
      echo '<option value="">'.label('wg_datanotfound').'</option>';
    }
  }

  public function save_question($qiz_id){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $output = array();
    /*$ques_id = isset($_REQUEST['ques_id'])?$_REQUEST['ques_id']:"";
    $qiz_id = isset($_REQUEST['qiz_id'])?$_REQUEST['qiz_id']:"";
    $answer = isset($_REQUEST['answer'])?$_REQUEST['answer']:"";
    $cosen_id = isset($_REQUEST['cosen_id'])?$_REQUEST['cosen_id']:"";
    $score = isset($_REQUEST['score'])?$_REQUEST['score']:"0";*/
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $type_qiz = isset($_REQUEST['type_qiz'.$qiz_id])?$_REQUEST['type_qiz'.$qiz_id]:"";
    if($type_qiz!=""){
      $cosen_id = isset($_REQUEST['cosen_id'.$qiz_id])?$_REQUEST['cosen_id'.$qiz_id]:"";
      $tc_answer = isset($_REQUEST['tc_answer_'.$type_qiz.$qiz_id])?$_REQUEST['tc_answer_'.$type_qiz.$qiz_id]:"";
      $ques_id = isset($_REQUEST['ques_id_'.$type_qiz.$qiz_id])?$_REQUEST['ques_id_'.$type_qiz.$qiz_id]:"";
      if(count($ques_id)>0&&$cosen_id!=""){
          $qiztc_id = "";
          $fetch_chk = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$qiz_id.'" and cosen_id="'.$cosen_id.'" and qiztc_isDelete="0" and time_finish="0000-00-00 00:00:00"','qiztc_id DESC');
          if(count($fetch_chk)>0){
            $qiztc_id = $fetch_chk['qiztc_id'];
          }else{
            $fetch_loop = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$qiz_id.'" and cosen_id="'.$cosen_id.'" and qiztc_isDelete="0"','limit_val DESC');
            $limit_val = count($fetch_loop)>0?intval($fetch_loop['limit_val'])+1:1;
            $arr_main = array(
              'qiz_id' => $qiz_id,
              'emp_id' => $sess['emp_id'],
              'time_start' => date('Y-m-d H:i'),
              'time_mod' => date('Y-m-d H:i'),
              'qiz_status' => '1',
              'limit_val' => $limit_val,
              'cosen_id' => $cosen_id
            );
            $this->db->insert('LMS_QIZ_TC',$arr_main);
            $qiztc_id = $this->db->insert_id();
          }
          if($qiztc_id!=""){
              for ($ques=0; $ques < count($ques_id); $ques++) { 
                  $tc_score = 0;
                  $fetch_ques = $this->func_query->query_row('LMS_QUES','','','','ques_id="'.$ques_id[$ques].'" and ques_type in ("multi","2choice")');
                  if(count($fetch_ques)>0){
                    $fetch_quesmulti = $this->func_query->query_row('LMS_QUES_MUL','','','','ques_id="'.$ques_id[$ques].'"');
                    if(count($fetch_quesmulti)>0){
                      $mul_answer = explode(',', $fetch_quesmulti['mul_answer']);
                      if(in_array($tc_answer[$ques], $mul_answer)){
                          $tc_score = floatval($fetch_ques['ques_score']);
                      }
                    }
                  }
                  $fetch_chk_ques = $this->func_query->query_row('LMS_QUES_TC','','','','qiztc_id="'.$qiztc_id.'" and cosen_id="'.$cosen_id.'" and qiz_id="'.$qiz_id.'" and ques_id="'.$ques_id[$ques].'"');
                  $valtc_answer = isset($tc_answer[$ques])?$tc_answer[$ques]:"";
                  $arr_main = array(
                      'qiztc_id' => $qiztc_id,
                      'qiz_id' => $qiz_id,
                      'ques_id' => $ques_id[$ques],
                      'emp_id' => $sess['emp_id'],
                      'tc_answer' => $valtc_answer,
                      'tc_finish' => $valtc_answer!=""?date('Y-m-d H:i'):"0000-00-00 00:00:00",
                      'tc_flag' => $valtc_answer!=""?'true':'false',
                      'tc_save' => $valtc_answer!=""?'true':'false',
                      'tc_score' => $tc_score,
                      'cosen_id' => $cosen_id,
                  );
                  if(count($fetch_chk_ques)>0){
                    $this->db->where('tc_id',$fetch_chk_ques['tc_id']);
                    $this->db->update('LMS_QUES_TC',$arr_main);
                  }else{
                    $this->db->insert('LMS_QUES_TC',$arr_main);
                  }
              }
              $output['status'] = "2";
          }else{
            $output['status'] = "0";
          }
      }else{
        $output['status'] = "0";
      }
    }else{
      $output['status'] = "0";
    }
    /*$fetch_chk = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$qiz_id.'" and emp_id="'.$sess['emp_id'].'" and qiztc_isDelete="0" and time_finish="0000-00-00 00:00:00"','qiztc_id DESC');
    $qiztc_id = "";
    if(count($fetch_chk)>0){
      $qiztc_id = $fetch_chk['qiztc_id'];
    }else{
      $fetch_loop = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$qiz_id.'" and emp_id="'.$sess['emp_id'].'" and qiztc_isDelete="0"','limit_val DESC');
      $limit_val = count($fetch_loop)>0?intval($fetch_loop['limit_val'])+1:1;
      $arr_main = array(
        'qiz_id' => $qiz_id,
        'emp_id' => $sess['emp_id'],
        'time_start' => date('Y-m-d H:i'),
        'time_mod' => date('Y-m-d H:i'),
        'qiz_status' => '1',
        'limit_val' => $limit_val,
        'cosen_id' => $cosen_id
      );
      $this->db->insert('LMS_QIZ_TC',$arr_main);
      $qiztc_id = $this->db->insert_id();
    }
    if($qiztc_id!=""){
      $fetch_chk_ques = $this->func_query->query_row('LMS_QUES_TC','','','','qiztc_id="'.$qiztc_id.'" and emp_id="'.$sess['emp_id'].'" and qiz_id="'.$qiz_id.'" and ques_id="'.$ques_id.'"');

      $arr_main = array(
          'qiztc_id' => $qiztc_id,
          'qiz_id' => $qiz_id,
          'ques_id' => $ques_id,
          'emp_id' => $sess['emp_id'],
          'tc_answer' => $answer,
          'tc_finish' => date('Y-m-d H:i'),
          'tc_flag' => 'true',
          'tc_save' => 'true',
          'tc_score' => $score,
          'cosen_id' => $cosen_id,
      );
      if(count($fetch_chk_ques)>0){
        $this->db->where('tc_id',$fetch_chk_ques['tc_id']);
        $this->db->update('LMS_QUES_TC',$arr_main);
      }else{
        $this->db->insert('LMS_QUES_TC',$arr_main);
      }
      $output['status'] = "2";
    }else{
      $output['status'] = "0";
    }*/
    echo json_encode($output);
  }

  public function send_question($qiz_id){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $output = array();
    $score = 0;

    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $type_qiz = isset($_REQUEST['type_qiz'.$qiz_id])?$_REQUEST['type_qiz'.$qiz_id]:"";
    if($type_qiz!=""){
      $cosen_id = isset($_REQUEST['cosen_id'.$qiz_id])?$_REQUEST['cosen_id'.$qiz_id]:"";
      $tc_answer = isset($_REQUEST['tc_answer_'.$type_qiz.$qiz_id])?$_REQUEST['tc_answer_'.$type_qiz.$qiz_id]:"";
      $ques_id = isset($_REQUEST['ques_id_'.$type_qiz.$qiz_id])?$_REQUEST['ques_id_'.$type_qiz.$qiz_id]:"";
      if(count($ques_id)>0&&$cosen_id!=""){
          $qiztc_id = "";
          $fetch_chk = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$qiz_id.'" and cosen_id="'.$cosen_id.'" and qiztc_isDelete="0" and time_finish="0000-00-00 00:00:00"','qiztc_id DESC');
          if(count($fetch_chk)>0){
            $qiztc_id = $fetch_chk['qiztc_id'];
          }else{
            $fetch_loop = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$qiz_id.'" and cosen_id="'.$cosen_id.'" and qiztc_isDelete="0"','limit_val DESC');
            $limit_val = count($fetch_loop)>0?intval($fetch_loop['limit_val'])+1:1;
            $arr_main = array(
              'qiz_id' => $qiz_id,
              'emp_id' => $sess['emp_id'],
              'time_start' => date('Y-m-d H:i'),
              'time_mod' => date('Y-m-d H:i'),
              'qiz_status' => '1',
              'limit_val' => $limit_val,
              'cosen_id' => $cosen_id
            );
            $this->db->insert('LMS_QIZ_TC',$arr_main);
            $qiztc_id = $this->db->insert_id();
          }
          if($qiztc_id!=""){
              $score_sum = 0;
              $score_per = 0;
              $score = 0;
              for ($ques=0; $ques < count($ques_id); $ques++) { 
                  $tc_score = 0;
                  $fetch_ques = $this->func_query->query_row('LMS_QUES','','','','ques_id="'.$ques_id[$ques].'" and ques_type in ("multi","2choice")');
                  if(count($fetch_ques)>0){
                    $score += floatval($fetch_ques['ques_score']);
                    $fetch_quesmulti = $this->func_query->query_row('LMS_QUES_MUL','','','','ques_id="'.$ques_id[$ques].'"');
                    if(count($fetch_quesmulti)>0){
                      $mul_answer = explode(',', $fetch_quesmulti['mul_answer']);
                      if(in_array($tc_answer[$ques], $mul_answer)){
                          $tc_score = floatval($fetch_ques['ques_score']);
                          $score_sum += floatval($tc_score);
                      }
                    }
                  }
                  $fetch_chk_ques = $this->func_query->query_row('LMS_QUES_TC','','','','qiztc_id="'.$qiztc_id.'" and cosen_id="'.$cosen_id.'" and qiz_id="'.$qiz_id.'" and ques_id="'.$ques_id[$ques].'"');
                  $valtc_answer = isset($tc_answer[$ques])?$tc_answer[$ques]:"";
                  $arr_main = array(
                      'qiztc_id' => $qiztc_id,
                      'qiz_id' => $qiz_id,
                      'ques_id' => $ques_id[$ques],
                      'emp_id' => $sess['emp_id'],
                      'tc_answer' => $valtc_answer,
                      'tc_finish' => $valtc_answer!=""?date('Y-m-d H:i'):"0000-00-00 00:00:00",
                      'tc_flag' => $valtc_answer!=""?'true':'false',
                      'tc_save' => $valtc_answer!=""?'true':'false',
                      'tc_score' => $tc_score,
                      'cosen_id' => $cosen_id,
                  );
                  if(count($fetch_chk_ques)>0){
                    $this->db->where('tc_id',$fetch_chk_ques['tc_id']);
                    $this->db->update('LMS_QUES_TC',$arr_main);
                  }else{
                    $this->db->insert('LMS_QUES_TC',$arr_main);
                  }
              }

              if($score_sum>0){
                $score_per = ($score_sum/$score)*100;
              }

              $arr_update = array(
                'time_mod' => date('Y-m-d H:i'),
                'time_finish' => date('Y-m-d H:i'),
                'sum_score' => $score_sum,
                'per_score' => $score_per,
                'qiz_status' => '3',
              );
              $this->db->where('qiztc_id',$qiztc_id);
              $this->db->where('cosen_id',$cosen_id);
              $this->db->update('LMS_QIZ_TC',$arr_update);

              $output['status'] = "2";
          }else{
            $output['status'] = "0:1871";
          }
      }else{
        $output['status'] = "0:1874";
      }
    }else{
      $output['status'] = "0:1877";
    }

    /*
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $fetch_ques = $this->func_query->query_result('LMS_QUES','','','','qiz_id="'.$qiz_id.'" and ques_isDelete="0" and ques_status="1"');
    if(count($fetch_ques)>0){
        $score_sum = 0;
        $score_per = 0;
        $score = 0;
        foreach ($fetch_ques as $key_ques => $value_ques) {
          $score += floatval($value_ques['ques_score']);
          $fetch_chk = $this->func_query->query_row('LMS_QUES_TC','','','','qiztc_id="'.$qiztc_id.'" and cosen_id="'.$cosen_id.'" and ques_id="'.$value_ques['ques_id'].'" and emp_id="'.$sess['emp_id'].'"');
          if(count($fetch_chk)>0){
            $score_sum += floatval($fetch_chk['tc_score']);
          }
        }
        if($score_sum>0){
          $score_per = ($score_sum/$score)*100;
        }
        $arr_update = array(
          'time_mod' => date('Y-m-d H:i'),
          'time_finish' => date('Y-m-d H:i'),
          'sum_score' => $score_sum,
          'per_score' => $score_per,
          'qiz_status' => '3',
        );
        $this->db->where('qiztc_id',$qiztc_id);
        $this->db->where('cosen_id',$cosen_id);
        $this->db->update('LMS_QIZ_TC',$arr_update);
        $output['status'] = "2";
    }else{
        $output['status'] = "0";
    }*/
    echo json_encode($output);
  }

  public function recheckcondition(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
    $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
    $condition = isset($_REQUEST['condition'])?explode(',', $_REQUEST['condition']):"";
    $where = 'cos_isDelete="0" and com_id="'.$com_id.'"';
    if($cos_id!=""){
        $where .= ' and cos_id != "'.$cos_id.'"';
    }
    $result = $this->func_query->query_result('LMS_COS','','','',$where);
    if(count($result)>0){
      echo "<optgroup label='".label('none')."'>";
      $numloop = 1;
      foreach ($result as $key) {
        $select_val = "";
        if(in_array($key['cos_id'], $condition)){
          $select_val = "selected";
        }
        $ccode = "";
        if($key['ccode']!=""){
          $ccode = " (".$key['ccode'].")";
        }
        if($lang=="thai"){
          $cname = $key['cname_th'];
          if($cname==""){
            $cname = $key['cname_eng'];
          }
          echo "<option value='".$key['cos_id']."' ".$select_val.">".$cname.$ccode."</option>";
        }else{
          $cname = $key['cname_eng'];
          if($cname==""){
            $cname = $key['cname_th'];
          }
          echo "<option value='".$key['cos_id']."' ".$select_val.">".$cname.$ccode."</option>";
        }
      }
      $this->func_query->closeDB();
      echo "</optgroup>";
    }else{
      echo '<option value="">'.label('none').'</option>';
    }
  }

  public function rechecktypecos(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $tc_id = isset($_REQUEST['tc_id'])?$_REQUEST['tc_id']:"";
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
    $result = $this->func_query->query_result('LMS_TYPECOS','','','','tc_status="1" and com_id ="'.$com_id.'"');
    if(count($result)>0){
      echo "<optgroup label='".label('Choosecostype')."'>";
      $numloop = 1;
      foreach ($result as $key) {
        $select_val = "";
        if($key['tc_id']==$tc_id){
          $select_val = "selected";
        }
        if($lang=="thai"){
          echo "<option value='".$key['tc_id']."' ".$select_val.">".$key['tc_name_th']."</option>";
        }else{
          echo "<option value='".$key['tc_id']."' ".$select_val.">".$key['tc_name_en']."</option>";
        }
      }
      $this->func_query->closeDB();
      echo "</optgroup>";
    }else{
      echo '<option value="">'.label('wg_datanotfound').'</option>';
    }
  }

  public function recheckdivision(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $div_id = isset($_REQUEST['div_id'])?$_REQUEST['div_id']:"";
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
    $result = $this->func_query->query_result('LMS_DIVISION','','','','div_status="1" and div_isDelete="0" and com_id ="'.$com_id.'"');
    if(count($result)>0){
      echo "<optgroup label='".label('svplease')."'>";
      $numloop = 1;
      foreach ($result as $key) {
        $select_val = "";
        if($key['div_id']==$div_id){
          $select_val = "selected";
        }
        if($lang=="thai"){
          echo "<option value='".$key['div_id']."' ".$select_val.">[".$key['div_code']."] ".$key['div_name_th']."</option>";
        }else{
          echo "<option value='".$key['div_id']."' ".$select_val.">[".$key['div_code']."] ".$key['div_name_en']."</option>";
        }
      }
      $this->func_query->closeDB();
      echo "</optgroup>";
    }else{
      echo '<option value="">'.label('wg_datanotfound').'</option>';
    }
  }

  public function recheckdivisionmultiple(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $cg_id = isset($_REQUEST['cg_id'])?$_REQUEST['cg_id']:"";
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
    $arr_div = array();
    if($cg_id!=""){
        $fetch_div = $this->func_query->query_result('LMS_COGINDIV','','','','cg_id="'.$cg_id.'" and cgdiv_isDelete="0"');
        foreach ($fetch_div as $key => $value) {
            if(!in_array($value['div_id'], $arr_div)){
                array_push($arr_div, $value['div_id']);
            }
        }
    }
    $result = $this->func_query->query_result('LMS_DIVISION','','','','div_status="1" and div_isDelete="0" and com_id ="'.$com_id.'"');
    if(count($result)>0){
      echo "<optgroup label='".label('svplease')."'>";
      $numloop = 1;
      foreach ($result as $key) {
        $select_val = "";
        if(in_array($key['div_id'], $arr_div)){
          $select_val = "selected";
        }
        if($lang=="thai"){
          echo "<option value='".$key['div_id']."' ".$select_val.">[".$key['div_code']."] ".$key['div_name_th']."</option>";
        }else{
          echo "<option value='".$key['div_id']."' ".$select_val.">[".$key['div_code']."] ".$key['div_name_en']."</option>";
        }
      }
      $this->func_query->closeDB();
      echo "</optgroup>";
    }else{
      echo '<option value="">'.label('wg_datanotfound').'</option>';
    }
  }

  public function recheckgroup(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $group_id = isset($_REQUEST['group_id'])?$_REQUEST['group_id']:"";
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
    $result = $this->func_query->query_result('LMS_GROUP','LMS_DIVISION','LMS_GROUP.div_id = LMS_DIVISION.div_id','','LMS_GROUP.group_status="1" and LMS_GROUP.group_isDelete="0" and LMS_DIVISION.com_id ="'.$com_id.'"');
    if(count($result)>0){
      echo "<optgroup label='".label('svplease')."'>";
      $numloop = 1;
      foreach ($result as $key) {
        $select_val = "";
        if($key['group_id']==$group_id){
          $select_val = "selected";
        }
        if($lang=="thai"){
          echo "<option value='".$key['group_id']."' ".$select_val.">[".$key['group_code']."] ".$key['group_name_th']."</option>";
        }else{
          echo "<option value='".$key['group_id']."' ".$select_val.">[".$key['group_code']."] ".$key['group_name_en']."</option>";
        }
      }
      $this->func_query->closeDB();
      echo "</optgroup>";
    }else{
      echo '<option value="">'.label('wg_datanotfound').'</option>';
    }
  }

  public function recheckdepartment(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $dep_id = isset($_REQUEST['dep_id'])?$_REQUEST['dep_id']:"";
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
    $result = $this->func_query->query_result('LMS_DEPART','LMS_GROUP','LMS_GROUP.group_id = LMS_DEPART.group_id','','LMS_DEPART.dep_isDelete="0" and LMS_GROUP.div_id in (select LMS_DIVISION.div_id from LMS_DIVISION where LMS_DIVISION.com_id = "'.$com_id.'" and LMS_DIVISION.div_isDelete = "0") and LMS_GROUP.group_isDelete = "0"');
    if(count($result)>0){
      echo "<optgroup label='".label('svplease')."'>";
      $numloop = 1;
      foreach ($result as $key) {
        $select_val = "";
        if($key['dep_id']==$dep_id){
          $select_val = "selected";
        }
        if($lang=="thai"){
          echo "<option value='".$key['dep_id']."' ".$select_val.">[".$key['dep_code']."] ".$key['dep_name_th']."</option>";
        }else{
          echo "<option value='".$key['dep_id']."' ".$select_val.">[".$key['dep_code']."] ".$key['dep_name_en']."</option>";
        }
      }
      $this->func_query->closeDB();
      echo "</optgroup>";
    }else{
      echo '<option value="">'.label('wg_datanotfound').'</option>';
    }
  }

  public function rechecksection(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $section_id = isset($_REQUEST['section_id'])?$_REQUEST['section_id']:"";
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
    $result = $this->func_query->query_result('LMS_SECTION','LMS_DEPART','LMS_SECTION.dep_id = LMS_DEPART.dep_id','','LMS_SECTION.section_isDelete="0" and LMS_DEPART.group_id in (select LMS_GROUP.group_id from LMS_GROUP inner join LMS_DIVISION on LMS_GROUP.div_id = LMS_DIVISION.div_id where LMS_DIVISION.com_id = "'.$com_id.'" and LMS_DIVISION.div_isDelete = "0" and LMS_GROUP.group_isDelete = "0") and LMS_DEPART.dep_isDelete = "0"');
    if(count($result)>0){
      echo "<optgroup label='".label('svplease')."'>";
      $numloop = 1;
      foreach ($result as $key) {
        $select_val = "";
        if($key['section_id']==$section_id){
          $select_val = "selected";
        }
        if($lang=="thai"){
          echo "<option value='".$key['section_id']."' ".$select_val.">[".$key['section_code']."] ".$key['section_name_th']."</option>";
        }else{
          echo "<option value='".$key['section_id']."' ".$select_val.">[".$key['section_code']."] ".$key['section_name_en']."</option>";
        }
      }
      $this->func_query->closeDB();
      echo "</optgroup>";
    }else{
      echo '<option value="">'.label('wg_datanotfound').'</option>';
    }
  }


  public function recheckgroupcosmulti(){
    $cg_id = isset($_REQUEST['cg_id'])?$_REQUEST['cg_id']:"";
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
    $cg_id_arr = explode(",",$cg_id);
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $fetch_query = $this->func_query->query_result('LMS_COG','','','','cg_isDelete="0" and cg_status="1" and com_id ="'.$com_id.'"','cg_id ASC');
    if(count($fetch_query)>0){
      echo "<optgroup label='".label('Choosecoursegroup')."'>";
      foreach ($fetch_query as $key) {
        $select_val = "";
        if(isset($_REQUEST['cos_id'])){
            $numchk = $this->func_query->numrows('LMS_COSINCG','','','','course_id="'.$_REQUEST['cos_id'].'" and cg_id="'.$key['cg_id'].'"');
            if($numchk>0){
              $select_val = "selected";
            }
        }/*
        if(count($cg_id_arr)>0&&in_array($key['cg_id'], $cg_id_arr)){
          $select_val = "selected";
        }*/
        if($lang=="thai"){
          echo "<option value='".$key['cg_id']."' ".$select_val.">".$key['cgtitle_th']."</option>";
        }else{
          echo "<option value='".$key['cg_id']."' ".$select_val.">".$key['cgtitle_en']."</option>";
        }
      }
      $this->func_query->closeDB();
      echo "</optgroup>";
    }else{
      echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
    }
  }

  public function recheckcos(){
    $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
    $cos_id_arr = explode(",",$cos_id);
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $fetch_query = $this->func_query->query_result('LMS_COS','','','','cos_isDelete="0" and cos_public="1" and cos_status="1"','cos_id ASC');
    foreach ($fetch_query as $key => $value) {
        $numchk = $this->func_query->numrows('LMS_COS_HIGHLIGHT','','','','cos_id="'.$value['cos_id'].'" and coshl_isDelete="0"');
        if($numchk==0){
            unset($fetch_query[$key]);
        }
    }
    if(count($fetch_query)>0){
      echo "<optgroup label='".label('Choosecourse')."'>";
      foreach ($fetch_query as $key) {
        $select_val = "";

        if($lang=="thai"){
          echo "<option value='".$key['cos_id']."' ".$select_val.">"."[".$key['ccode']."] ".$key['cname_th']."</option>";
        }else{
          echo "<option value='".$key['cos_id']."' ".$select_val.">"."[".$key['ccode']."] ".$key['cname_eng']."</option>";
        }
      }
      $this->func_query->closeDB();
      echo "</optgroup>";
    }else{
      echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
    }
  }
  
  public function update_course_status(){
      $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
      $this->lang->load($lang,$lang);
      $this->load->model('Function_query_model', 'func_query', FALSE);
      $this->func_query->loadDB();
      date_default_timezone_set("Asia/Bangkok");
      $sess = $this->session->userdata("user");
      $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
      $field = isset($_REQUEST['field'])?$_REQUEST['field']:"";
      $fetch_cos = $this->func_query->query_row('LMS_COS','','','','LMS_COS.cos_id="'.$cos_id.'"');
      $output = array();
      if(count($fetch_cos)>0){
        $arr_update = array(
          'cos_modifiedby' => $sess['u_id'],
          'cos_modifieddate' => date('Y-m-d H:i')
        );
        if($field=="public"){
          $arr_update['cos_public'] = "1";
        }else{
          $arr_update['cos_public'] = "0";
        }
        $this->db->where('cos_id',$cos_id);
        $this->db->update('LMS_COS',$arr_update);
        $output['status'] = "2";
        if($field=="public"){
              include ROOT_DIR."assets/plugins/phpqrcode/qrlib.php"; 
              $errorCorrectionLevel = 'L';
              $matrixPointSize = 6;
              $filename = ROOT_DIR."uploads/qrcode/cos_".$cos_id.".png";
              $link_cos = base_url().'coursemain/qrcode/'.$cos_id;

              if(!is_file($filename)) {
                  QRcode::png($link_cos, $filename, $errorCorrectionLevel, $matrixPointSize, 2);  
              }
        }
      }else{
        $output['status'] = "1";
      }
      echo json_encode($output);
  }

  public function reject_cos(){
    $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
    $cosa_note = isset($_REQUEST['cosa_note'])?$_REQUEST['cosa_note']:"";

    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    $arr_update = array(
      'cos_id' => $cos_id,
      'cosa_approve' => '0',
      'cosa_note' => $cosa_note,
      'cosa_createby' => $sess['u_id'],
      'cosa_createdate' => date('Y-m-d H:i'),
    );
    $this->db->insert('LMS_COS_APPROVE',$arr_update);
    $arr_updatecos = array(
      'cos_public' => '0',
      'cos_approve' => '0',
    );
    $this->db->where('cos_id',$cos_id);
    $this->db->update('LMS_COS',$arr_updatecos);

            $fetch_cos = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');
      $fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
                $date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
                if($lang!="thai"){
                  $date = date('d F Y');
                }
                if($lang=="thai"){ 
                    $cname = $fetch_cos['cname_th']!=""?$fetch_cos['cname_th']:$fetch_cos['cname_eng'];
                }else{ 
                    $cname = $fetch_cos['cname_eng']!=""?$fetch_cos['cname_eng']:$fetch_cos['cname_th'];
                }
                $period = label('UnlimitedTime');
                $fetch_cos_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id="'.$cos_id.'" and cosde_status="1" and cosde_isDelete="0"');
                if(count($fetch_cos_detail)>0){
                  if($fetch_cos_detail['date_start']!="0000-00-00 00:00:00"&&$fetch_cos_detail['date_end']!="0000-00-00 00:00:00"){
                  if($lang=="thai"){
                  $periodstart = $fetch_cos_detail['date_start']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_cos_detail['date_start'])).$thaimonth[intval(date('m',strtotime($fetch_cos_detail['date_start'])))].(date('Y',strtotime($fetch_cos_detail['date_start']))+543)." ".date('H:i',strtotime($fetch_cos_detail['date_start'])):"";
                  $periodend = $fetch_cos_detail['date_end']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_cos_detail['date_end'])).$thaimonth[intval(date('m',strtotime($fetch_cos_detail['date_end'])))].(date('Y',strtotime($fetch_cos_detail['date_end']))+543)." ".date('H:i',strtotime($fetch_cos_detail['date_end'])):"";
                  }else{
                  $periodstart = $fetch_cos_detail['date_start']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_cos_detail['date_start'])).$thaimonth[intval(date('m',strtotime($fetch_cos_detail['date_start'])))].(date('Y',strtotime($fetch_cos_detail['date_start'])))." ".date('H:i',strtotime($fetch_cos_detail['date_start'])):"";
                  $periodend = $fetch_cos_detail['date_end']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_cos_detail['date_end'])).$thaimonth[intval(date('m',strtotime($fetch_cos_detail['date_end'])))].(date('Y',strtotime($fetch_cos_detail['date_end'])))." ".date('H:i',strtotime($fetch_cos_detail['date_end'])):"";
                  }
                  
                  if($periodstart!=""&&$periodend!=""){
                      $period = $periodstart." - ".$periodend;
                  }
                  }
                }
                  $date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
                  if($lang!="thai"){
                    $date = date('d F Y');
                  }
                if($fetch_cos['cos_createby']!=""){
                    $fetch_user = $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.u_id="'.$fetch_cos['cos_createby'].'"');
                    $fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="6"');
                    if(count($fetch_formatmail)>0){
                        $subject_th = $fetch_formatmail['smf_subject_th'];
                        $subject_en = $fetch_formatmail['smf_subject_en'];
                        $message_th = $fetch_formatmail['smf_message_th'];
                        $message_en = $fetch_formatmail['smf_message_en'];
                        if($subject_th!=""){
                          $subject_th = str_replace("#fullname",$fetch_user['fullname_th'],$subject_th);
                          $subject_th = str_replace("#username",$fetch_user['useri'],$subject_th);
                          $subject_th = str_replace("#email",$fetch_user['email'],$subject_th);
                          $subject_th = str_replace("#coursename",$cname,$subject_th);
                          $subject_th = str_replace("#link_frontend",base_url()."managecourse/courses_all/",$subject_th);
                          $subject_th = str_replace("#date",$date,$subject_th);
                          $subject_th = str_replace("#time",date('H:i'),$subject_th);
                          $subject_th = str_replace("#perioddate",$period,$subject_th);
                          $subject_th = str_replace("#message",$cosa_note,$subject_th);
                        }
                        if($subject_en!=""){
                          $subject_en = str_replace("#fullname",$fetch_user['fullname_en'],$subject_en);
                          $subject_en = str_replace("#username",$fetch_user['useri'],$subject_en);
                          $subject_en = str_replace("#email",$fetch_user['email'],$subject_en);
                          $subject_en = str_replace("#coursename",$cname,$subject_en);
                          $subject_en = str_replace("#link_frontend",base_url()."managecourse/courses_all/",$subject_en);
                          $subject_en = str_replace("#date",$date,$subject_en);
                          $subject_en = str_replace("#time",date('H:i'),$subject_en);
                          $subject_en = str_replace("#perioddate",$period,$subject_en);
                          $subject_en = str_replace("#message",$cosa_note,$subject_en);
                        }
                        if($message_th!=""){
                          $message_th = str_replace("#fullname",$fetch_user['fullname_th'],$message_th);
                          $message_th = str_replace("#username",$fetch_user['useri'],$message_th);
                          $message_th = str_replace("#email",$fetch_user['email'],$message_th);
                          $message_th = str_replace("#coursename",$cname,$message_th);
                          $message_th = str_replace("#link_frontend",base_url()."managecourse/courses_all/",$message_th);
                          $message_th = str_replace("#date",$date,$message_th);
                          $message_th = str_replace("#time",date('H:i'),$message_th);
                          $message_th = str_replace("#perioddate",$period,$message_th);
                          $message_th = str_replace("#message",$cosa_note,$message_th);
                        }
                        if($message_en!=""){
                          $message_en = str_replace("#fullname",$fetch_user['fullname_en'],$message_en);
                          $message_en = str_replace("#username",$fetch_user['useri'],$message_en);
                          $message_en = str_replace("#email",$fetch_user['email'],$message_en);
                          $message_en = str_replace("#coursename",$cname,$message_en);
                          $message_en = str_replace("#link_frontend",base_url()."managecourse/courses_all/",$message_en);
                          $message_en = str_replace("#date",$date,$message_en);
                          $message_en = str_replace("#time",date('H:i'),$message_en);
                          $message_en = str_replace("#perioddate",$period,$message_en);
                          $message_en = str_replace("#message",$cosa_note,$message_en);
                        }
                        if($lang == "thai") {
                        $this->db->sendEmail( $fetch_user['email'] , $message_th, $subject_th,$fetch_setmail);
                        } else {
                        $this->db->sendEmail( $fetch_user['email'] , $message_en, $subject_en,$fetch_setmail);
                        }
                    }
                }
  }


  public function reject_cog(){
    $cg_id = isset($_REQUEST['cg_id'])?$_REQUEST['cg_id']:"";
    $coga_note = isset($_REQUEST['coga_note'])?$_REQUEST['coga_note']:"";

    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");

      $arr_update = array(
        'cg_id' => $_REQUEST['cg_id'],
        'coga_note' => $coga_note,
        'coga_approve' => '0',
        'coga_createby' => $sess['u_id'],
        'coga_createdate' => date('Y-m-d H:i'),
      );
      $this->db->insert('LMS_COG_APPROVE',$arr_update);
      $arr_update = array(
        'cg_id' => $cg_id,
        'cg_approve' => '0'
      );
      $this->db->where('cg_id',$cg_id);
      $this->db->update('LMS_COG',$arr_update);

      $fetch_cg = $this->func_query->query_row('LMS_COG','','','','cg_id="'.$cg_id.'"');
      $fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
                $date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
                if($lang!="thai"){
                  $date = date('d F Y');
                }
                if($lang=="thai"){ 
                    $cgtitle = $fetch_cg['cgtitle_th']!=""?$fetch_cg['cgtitle_th']:$fetch_cg['cgtitle_en'];
                    $cgtitle = $cgtitle!=""?$cgtitle:$fetch_cg['cgtitle_jp'];
                }else if($lang=="english"){ 
                    $cgtitle = $fetch_cg['cgtitle_en']!=""?$fetch_cg['cgtitle_en']:$fetch_cg['cgtitle_th'];
                    $cgtitle = $cgtitle!=""?$cgtitle:$fetch_cg['cgtitle_jp'];
                }else{
                    $cgtitle = $fetch_cg['cgtitle_jp']!=""?$fetch_cg['cgtitle_jp']:$fetch_cg['cgtitle_en'];
                    $cgtitle = $cgtitle!=""?$cgtitle:$fetch_cg['cgtitle_th'];
                }

                if($fetch_cg['c_by']!=""){
                    $fetch_user = $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.u_id="'.$fetch_cg['c_by'].'"');
                    $fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="6"');
                    if(count($fetch_formatmail)>0){
                        $subject_th = $fetch_formatmail['smf_subject_th'];
                        $subject_en = $fetch_formatmail['smf_subject_en'];
                        $message_th = $fetch_formatmail['smf_message_th'];
                        $message_en = $fetch_formatmail['smf_message_en'];
                        if($subject_th!=""){
                          $subject_th = str_replace("#fullname",$fetch_user['fullname_th'],$subject_th);
                          $subject_th = str_replace("#username",$fetch_user['useri'],$subject_th);
                          $subject_th = str_replace("#email",$fetch_user['email'],$subject_th);
                          $subject_th = str_replace("#coursename",$cgtitle,$subject_th);
                          $subject_th = str_replace("#link_frontend",base_url()."managecourse/course_groups/",$subject_th);
                          $subject_th = str_replace("#date",$date,$subject_th);
                          $subject_th = str_replace("#time",date('H:i'),$subject_th);
                          $subject_th = str_replace("#perioddate",'',$subject_th);
                          $subject_th = str_replace("#message",$coga_note,$subject_th);
                        }
                        if($subject_en!=""){
                          $subject_en = str_replace("#fullname",$fetch_user['fullname_en'],$subject_en);
                          $subject_en = str_replace("#username",$fetch_user['useri'],$subject_en);
                          $subject_en = str_replace("#email",$fetch_user['email'],$subject_en);
                          $subject_en = str_replace("#coursename",$cgtitle,$subject_en);
                          $subject_en = str_replace("#link_frontend",base_url()."managecourse/course_groups/",$subject_en);
                          $subject_en = str_replace("#date",$date,$subject_en);
                          $subject_en = str_replace("#time",date('H:i'),$subject_en);
                          $subject_en = str_replace("#perioddate",'',$subject_en);
                          $subject_en = str_replace("#message",$coga_note,$subject_en);
                        }
                        if($message_th!=""){
                          $message_th = str_replace("#fullname",$fetch_user['fullname_th'],$message_th);
                          $message_th = str_replace("#username",$fetch_user['useri'],$message_th);
                          $message_th = str_replace("#email",$fetch_user['email'],$message_th);
                          $message_th = str_replace("#coursename",$cgtitle,$message_th);
                          $message_th = str_replace("#link_frontend",base_url()."managecourse/course_groups/",$message_th);
                          $message_th = str_replace("#date",$date,$message_th);
                          $message_th = str_replace("#time",date('H:i'),$message_th);
                          $message_th = str_replace("#perioddate",'',$message_th);
                          $message_th = str_replace("#message",$coga_note,$message_th);
                        }
                        if($message_en!=""){
                          $message_en = str_replace("#fullname",$fetch_user['fullname_en'],$message_en);
                          $message_en = str_replace("#username",$fetch_user['useri'],$message_en);
                          $message_en = str_replace("#email",$fetch_user['email'],$message_en);
                          $message_en = str_replace("#coursename",$cgtitle,$message_en);
                          $message_en = str_replace("#link_frontend",base_url()."managecourse/course_groups/",$message_en);
                          $message_en = str_replace("#date",$date,$message_en);
                          $message_en = str_replace("#time",date('H:i'),$message_en);
                          $message_en = str_replace("#perioddate",'',$message_en);
                          $message_en = str_replace("#message",$coga_note,$message_en);
                        }
                        if($lang == "thai") {
                        $this->db->sendEmail( $fetch_user['email'] , $message_th, $subject_th,$fetch_setmail);
                        } else {
                        $this->db->sendEmail( $fetch_user['email'] , $message_en, $subject_en,$fetch_setmail);
                        }
                    }
                }
  }

  public function reject_publicsurvey(){
    $sv_id = isset($_REQUEST['sv_id'])?$_REQUEST['sv_id']:"";
    $sva_note = isset($_REQUEST['sva_note'])?$_REQUEST['sva_note']:"";

    $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $arr_update = array(
      'sv_id' => $sv_id,
      'sva_approve' => '0',
      'sva_note' => $sva_note,
      'sva_createby' => $sess['u_id'],
      'sva_createdate' => date('Y-m-d H:i'),
    );
    $this->db->insert('LMS_SV_APPROVE',$arr_update);
    $arr_updatecos = array(
      'sv_public' => '0',
      'sv_approve' => '0',
    );
    $this->db->where('sv_id',$sv_id);
    $this->db->update('LMS_SV',$arr_updatecos);
              $date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
              if($lang!="thai"){
                 $date = date('d F Y');
              }

        $fetch_sv = $this->func_query->query_row('LMS_SV','','','','sv_id="'.$_REQUEST['sv_id'].'"');
            $fetch_user = $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.u_id="'.$fetch_sv['sv_createby'].'"');
            if($lang=="thai"){
            $periodstart = $fetch_sv['sv_open']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_sv['sv_open'])).$thaimonth[intval(date('m',strtotime($fetch_sv['sv_open'])))].(date('Y',strtotime($fetch_sv['sv_open']))+543)." ".date('H:i',strtotime($fetch_sv['sv_open'])):"";
            $periodend = $fetch_sv['sv_end']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_sv['sv_end'])).$thaimonth[intval(date('m',strtotime($fetch_sv['sv_end'])))].(date('Y',strtotime($fetch_sv['sv_end']))+543)." ".date('H:i',strtotime($fetch_sv['sv_end'])):"";
            }else{
            $periodstart = $fetch_sv['sv_open']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_sv['sv_open'])).$thaimonth[intval(date('m',strtotime($fetch_sv['sv_open'])))].(date('Y',strtotime($fetch_sv['sv_open'])))." ".date('H:i',strtotime($fetch_sv['sv_open'])):"";
            $periodend = $fetch_sv['sv_end']!="0000-00-00 00:00:00"?date('d',strtotime($fetch_sv['sv_end'])).$thaimonth[intval(date('m',strtotime($fetch_sv['sv_end'])))].(date('Y',strtotime($fetch_sv['sv_end'])))." ".date('H:i',strtotime($fetch_sv['sv_end'])):"";
            }
            $period = label('UnlimitedTime');
            if($periodstart!=""&&$periodend!=""){
              $period = $periodstart." - ".$periodend;
            }

                  if($lang=="thai"){ 
                    $sv_title = $fetch_sv['sv_title_th']!=""?$fetch_sv['sv_title_th']:$fetch_sv['sv_title_eng'];
                    $sv_title = $sv_title!=""?$sv_title:$fetch_sv['sv_title_jp'];
                  }else if($lang=="english"){ 
                    $sv_title = $fetch_sv['sv_title_eng']!=""?$fetch_sv['sv_title_eng']:$fetch_sv['sv_title_th'];
                    $sv_title = $sv_title!=""?$sv_title:$fetch_sv['sv_title_jp'];
                  }else{
                    $sv_title = $fetch_sv['sv_title_jp']!=""?$fetch_sv['sv_title_jp']:$fetch_sv['sv_title_eng'];
                    $sv_title = $sv_title!=""?$sv_title:$fetch_sv['sv_title_th'];
                  }
            $fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
            $fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="9"');
            if(count($fetch_formatmail)>0){
              $subject_th = $fetch_formatmail['smf_subject_th'];
              $subject_en = $fetch_formatmail['smf_subject_en'];
              $message_th = $fetch_formatmail['smf_message_th'];
              $message_en = $fetch_formatmail['smf_message_en'];
                if($subject_th!=""){
                  $subject_th = str_replace("#fullname",$fetch_user['fullname_th'],$subject_th);
                  $subject_th = str_replace("#username",$fetch_user['useri'],$subject_th);
                  $subject_th = str_replace("#email",$fetch_user['email'],$subject_th);
                  $subject_th = str_replace("#coursename",$sv_title,$subject_th);
                  $subject_th = str_replace("#link_frontend",base_url()."survey/list_survey/",$subject_th);
                  $subject_th = str_replace("#date",$date,$subject_th);
                  $subject_th = str_replace("#time",date('H:i'),$subject_th);
                  $subject_th = str_replace("#perioddate",$period,$subject_th);
                          $subject_th = str_replace("#message",$sva_note,$subject_th);
                }
                if($subject_en!=""){
                  $subject_en = str_replace("#fullname",$fetch_user['fullname_en'],$subject_en);
                  $subject_en = str_replace("#username",$fetch_user['useri'],$subject_en);
                  $subject_en = str_replace("#email",$fetch_user['email'],$subject_en);
                  $subject_en = str_replace("#coursename",$sv_title,$subject_en);
                  $subject_en = str_replace("#link_frontend",base_url()."survey/list_survey/",$subject_en);
                  $subject_en = str_replace("#date",$date,$subject_en);
                  $subject_en = str_replace("#time",date('H:i'),$subject_en);
                  $subject_en = str_replace("#perioddate",$period,$subject_en);
                          $subject_en = str_replace("#message",$sva_note,$subject_en);
                }
                if($message_th!=""){
                  $message_th = str_replace("#fullname",$fetch_user['fullname_th'],$message_th);
                  $message_th = str_replace("#username",$fetch_user['useri'],$message_th);
                  $message_th = str_replace("#email",$fetch_user['email'],$message_th);
                  $message_th = str_replace("#coursename",$sv_title,$message_th);
                  $message_th = str_replace("#link_frontend",base_url()."survey/list_survey/",$message_th);
                  $message_th = str_replace("#date",$date,$message_th);
                  $message_th = str_replace("#time",date('H:i'),$message_th);
                  $message_th = str_replace("#perioddate",$period,$message_th);
                          $message_th = str_replace("#message",$sva_note,$message_th);
                }
                if($message_en!=""){
                  $message_en = str_replace("#fullname",$fetch_user['fullname_en'],$message_en);
                  $message_en = str_replace("#username",$fetch_user['useri'],$message_en);
                  $message_en = str_replace("#email",$fetch_user['email'],$message_en);
                  $message_en = str_replace("#coursename",$sv_title,$message_en);
                  $message_en = str_replace("#link_frontend",base_url()."survey/list_survey/",$message_en);
                  $message_en = str_replace("#date",$date,$message_en);
                  $message_en = str_replace("#time",date('H:i'),$message_en);
                  $message_en = str_replace("#perioddate",$period,$message_en);
                          $message_en = str_replace("#message",$sva_note,$message_en);
                }
                if($lang == "thai") {
                $this->db->sendEmail( $fetch_user['email'] , $message_th, $subject_th,$fetch_setmail);
                } else {
                $this->db->sendEmail( $fetch_user['email'] , $message_en, $subject_en,$fetch_setmail);
                }
            }
  }

  public function recheckapprovemulti(){
    $cg_approve_by = isset($_REQUEST['cg_approve_by'])?$_REQUEST['cg_approve_by']:"";
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
    $cg_approve_by_arr = explode(",",$cg_approve_by);
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();/*
    $fetch_query = $this->func_query->query_result('LMS_USP','LMS_EMP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.u_isDelete="0" and LMS_USP.u_status="1" and LMS_USP.ug_id in (select ug_id from LMS_USP_GP where ug_approve="1" and ug_status="1" and ug_isDelete="0") and LMS_EMP.email!="" and LMS_EMP.com_id = "'.$com_id.'"','u_id ASC','LMS_USP.u_id,LMS_EMP.fullname_th,LMS_EMP.fullname_en,LMS_EMP.email');
    if(count($fetch_query)>0){
      echo "<optgroup label='".label('choosecg_approve_by')."'>";
      foreach ($fetch_query as $key) {
        $select_val = "";
        if(count($cg_approve_by_arr)>0&&in_array($key['u_id'], $cg_approve_by_arr)){
          $select_val = "selected";
        }
        echo "<option value='".$key['u_id']."' ".$select_val.">".$key['email']."</option>";
        /*if($lang=="thai"){
          echo "<option value='".$key['u_id']."' ".$select_val.">".$key['fullname_th']."</option>";
        }else{
          echo "<option value='".$key['u_id']."' ".$select_val.">".$key['fullname_en']."</option>";
        }
      }
      $this->func_query->closeDB();
      echo "</optgroup>";
    }else{
      echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
    }*/

      $sess = $this->session->userdata("user");
      $arr_user = array();
      if(isset($_REQUEST['cg_id'])&&$_REQUEST['cg_id']!=""){
          $fetch_chk = $this->func_query->query_row('LMS_COG','','','','cg_id="'.$_REQUEST['cg_id'].'"');
          if(count($fetch_chk)>0&&$fetch_chk['cg_approve_by']!=""){
              $arr_user = explode(',', $fetch_chk['cg_approve_by']);
          }
      }
      $result = $this->func_query->query_result('LMS_USP','LMS_EMP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_EMP.com_id="'.$_REQUEST['com_id'].'" and LMS_EMP.emp_isDelete="0" and LMS_EMP.emp_id!="'.$sess['emp_id'].'"');
      if(count($result)>0){
        foreach ($result as $key => $value) {
          $select_val = "";
          $fullname = $lang=="thai"?$value['fullname_th']:$value['fullname_en'];
          if(count($arr_user)>0&&in_array($value['u_id'], $arr_user)){
              $select_val = "selected";
          }
          echo '<option value="'.$value['u_id'].'" '.$select_val.'>'.$fullname.'</option>';
        }
      }else{
        echo '<option value="">'.label('wg_datanotfound').'</option>';
      }
  }

  public function permission_course(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
    $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";

    $sess = $this->session->userdata("user");
    $fetch_comuser = $this->func_query->query_row('LMS_COMPANY','','','','com_id="'.$com_id.'"');
    $fetch_cos = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');
    if(count($fetch_comuser)>0){
          
          $fetch_position_group = $this->func_query->query_result('LMS_POSITION','','','','com_id = "'.$com_id.'" and posi_isDelete="0"','','posi_group');
          if(count($fetch_position_group)>0){
              $fetch_tycos = $this->func_query->query_result('LMS_TYPECOS','','','','com_id = "'.$com_id.'" and tc_status="1"');
            ?>
            <table class="table table-bordered table-striped" width="100%">
              <thead>
                <tr>
                  <th width="40%"><center><?php echo label('r_position'); ?></center></th>
                  <th width="15%"><center><?php echo label('cant_study'); ?></center></th>
                  <?php 
                  if(count($fetch_tycos)>0){ 
                            foreach ($fetch_tycos as $key_tycos => $value_tycos) {
                  ?>
                  <th width="15%"><center><?php echo $lang=="thai"?$value_tycos['tc_name_th']:$value_tycos['tc_name_en']; ?></center></th>
                  <?php     }
                        } ?>
                </tr>
              </thead>
              <tbody>
                <?php 
                  $numarr = 0;
                  foreach ($fetch_position_group as $key_position_group => $value_position_group) {
                      ?>
                      <tr style="background-color: #f5d8d8; font-weight: bold;">
                        <td colspan="<?php echo count($fetch_tycos)+2; ?>"><?php echo label($value_position_group['posi_group']."_title"); ?></td>
                      </tr>
                      <?php
                      $fetch_position = $this->func_query->query_result('LMS_POSITION','','','','com_id="'.$com_id.'" and posi_isDelete="0" and posi_group="'.$value_position_group['posi_group'].'"');
                      if(count($fetch_position)>0){
                          foreach ($fetch_position as $key_position => $value_position) {
                            $fetch_chkposincos = $this->func_query->query_row('LMS_COS_POSITION','','','','cos_id="'.$cos_id.'" and posi_id="'.$value_position['posi_id'].'" ');
                                $is_typccosinposition = 0;
                                if(count($fetch_chkposincos)==0){
                                  $is_typccosinposition = 1;
                                }
                        ?>
                            <input type="hidden" name="posi_id[<?php echo $numarr; ?>]" value="<?php echo $value_position['posi_id']; ?>">
                            <tr>
                              <td><?php echo $lang=="thai"?$value_position['posi_name_th']:$value_position['posi_name_en']; ?></td>
                              <td align="center">
                                <div class="checkbox checkbox-success">
                                  <input type="radio" class="position_permission" id="radio_posi0_<?php echo $value_position['posi_id']; ?>" name="posi_var[<?php echo $numarr; ?>]" value="" <?php if($is_typccosinposition==1){ ?>checked="true"<?php } ?>>
                                  <label for="radio_posi0_<?php echo $value_position['posi_id']; ?>"></label>
                                </div>
                              </td>
                  <?php if(count($fetch_tycos)>0){ 
                            foreach ($fetch_tycos as $key_tycos => $value_tycos) {
                                $fetch_chkposincos = $this->func_query->query_row('LMS_COS_POSITION','','','','cos_id="'.$cos_id.'" and posi_id="'.$value_position['posi_id'].'" and tc_id="'.$value_tycos['tc_id'].'"');
                                $is_typccosinposition = 0;
                                if(count($fetch_chkposincos)>0){
                                  $is_typccosinposition = 1;
                                }
                  ?>
                                <td width="10%" align="center">
                                    <div class="checkbox checkbox-success">
                                      <input type="radio" class="position_permission" id="radio_posi<?php echo $value_tycos['tc_id']; ?>_<?php echo $value_position['posi_id']; ?>" name="posi_var[<?php echo $numarr; ?>]" value="<?php echo $value_tycos['tc_id']; ?>" <?php if($is_typccosinposition==1){ ?>checked="true"<?php } ?>>
                                      <label for="radio_posi<?php echo $value_tycos['tc_id']; ?>_<?php echo $value_position['posi_id']; ?>"></label>
                                    </div>
                                </td>
                  <?php     }
                        } ?>
                            </tr>
                        <?php $numarr++;
                          }
                      }
                  }
                ?>
              </tbody>
            </table>
            <?php 
          }
    }else{
          echo '<h3 align="center">'.label('wg_datanotfound').'</h3>';
    }
  }

  public function permission_survey(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $sv_id = isset($_REQUEST['sv_id'])?$_REQUEST['sv_id']:"";

    $sess = $this->session->userdata("user");
    $fetch_comuser = $this->func_query->query_row('LMS_COMPANY','','','','com_id="'.$sess['com_id'].'"');
    $where = "";
    if($fetch_comuser['com_admin']=="com_associated"){
      $where = " and com_id = '".$sess['com_id']."'";
    }
    $result_com = $this->func_query->query_result('LMS_COMPANY','','','','com_isDelete="0" and com_status="1" and com_id!="1"'.$where);
    $arr_company = array();$arr_department = array();$arr_position = array();
    if($sv_id!=""){
        $fetch_ug = $this->func_query->query_result('LMS_SV_PM','','','','sv_id="'.$sv_id.'"');
        foreach ($fetch_ug as $key_ug => $value_ug) {
          array_push($arr_position, $value_ug['posi_id']);
        }
    }
    $txt_position = "";
    if(count($arr_position)>0){
        $txt_position = implode(',', $arr_position);
        $txt_position = ' and LMS_POSITION.posi_id in ('.$txt_position.')';
    }
    $result_depcom = $this->func_query->query_result('LMS_DEPART','LMS_POSITION','LMS_DEPART.dep_id = LMS_POSITION.dep_id','','LMS_POSITION.posi_isDelete="0" and LMS_POSITION.posi_status = "1" and LMS_DEPART.dep_isDelete = "0" and LMS_DEPART.dep_status = "1"'.$where,'','LMS_DEPART.com_id,LMS_DEPART.dep_id,LMS_POSITION.posi_id');
    $arr_com = array();
    foreach ($result_depcom as $key_depcom => $value_depcom) {
      array_push($arr_com , $value_depcom['com_id']);
      if(count($arr_position)>0&&in_array($value_depcom['posi_id'], $arr_position)&&!in_array($value_depcom['dep_id'], $arr_department)){
          array_push($arr_department , $value_depcom['dep_id']);
      }
      if(count($arr_position)>0&&in_array($value_depcom['posi_id'], $arr_position)&&!in_array($value_depcom['com_id'], $arr_company)){
          array_push($arr_company , $value_depcom['com_id']);
      }
    }
    if(count($result_com)>0){
      $numcom = 1;
      foreach ($result_com as $key_com => $value_com) {
          if(!in_array($value_com['com_id'], $arr_com)){
              unset($result_com[$key_com]);
          }
      }
      foreach ($result_com as $key_com => $value_com) {
        $num_chk = 0;
        $order_by_dep = $lang=='thai'?'dep_name_th ASC':'dep_name_en ASC';
        $order_by_posi = $lang=='thai'?'posi_name_th ASC':'posi_name_en ASC';
        $result_dep = $this->func_query->query_result('LMS_DEPART','','','','dep_isDelete="0" and dep_status="1" and com_id = "'.$value_com['com_id'].'"',$order_by_dep);
        $result_posi = $this->func_query->query_result('LMS_POSITION','LMS_DEPART','LMS_DEPART.dep_id = LMS_POSITION.dep_id','','posi_isDelete="0" and posi_status="1" and dep_isDelete="0" and dep_status="1" and LMS_DEPART.com_id = "'.$value_com['com_id'].'"',$order_by_posi,'LMS_POSITION.dep_id,LMS_POSITION.posi_id,LMS_POSITION.posi_name_th,LMS_POSITION.posi_name_en');
        $arr_dep = array();
        foreach ($result_posi as $key_posi => $value_posi) {
          array_push($arr_dep, $value_posi['dep_id']);
        }
        foreach ($result_dep as $key_dep => $value_dep) {
          if(!in_array($value_dep['dep_id'], $arr_dep)){
              unset($result_dep[$key_dep]);
          }

          if(count($arr_department)>0&&in_array($value_dep['dep_id'], $arr_department)){
            $num_chk++;
          }
        }
      ?>
      <div class="card m-b-0">
        <div class="row">
          <div class="col-auto">
            <input type="checkbox" id="chkcom_<?php echo $value_com['com_id'] ?>" onclick="onchkcom('<?php echo $value_com['com_id']; ?>')" value="<?php echo $value_com['com_id']; ?>" name="company_var[]" class="filled-in chk-col-red" <?php if($num_chk>0){echo "checked";} ?> />
            <label for="chkcom_<?php echo $value_com['com_id']; ?>"><?php if($lang=="thai"){ echo $value_com['com_name_th']; }else{ echo $value_com['com_name_eng']; } echo " [".$value_com['com_code']."]"; ?></label>
          </div>
          <div class="col-auto" id="divallcom_<?php echo $value_com['com_id']; ?>">
            <input type="checkbox" class="filled-in chk-col-red" id="chkallcom_<?php echo $value_com['com_id']; ?>" onclick="onchkallcom('<?php echo $value_com['com_id']; ?>')"><label for="chkallcom_<?php echo $value_com['com_id']; ?>"><?php echo label('r_company'); ?></label>
            <script>
              $( document ).ready(function() {
                <?php if($num_chk==0){ ?>
                $('#divallcom_<?php echo $value_com['com_id']; ?>').hide();
                <?php }else{ ?>
                $('#divallcom_<?php echo $value_com['com_id']; ?>').show();
                <?php } ?>
              });

            </script>
          </div>
        </div>

          <?php $allnum_chkdep = 0;
                foreach ($result_dep as $key_dep => $value_dep) {

                  if(count($arr_department)>0&&in_array($value_dep['dep_id'], $arr_department)){
                    $allnum_chkdep++;
                  }
                }
          ?>
        <hr>
        <div class="col-lg-12">
          <div class="row" id="div_depofcompany<?php echo $value_com['com_id']; ?>" <?php if($allnum_chkdep==0){ ?>style="margin-bottom:2px;display: none;"<?php } ?>>

          <?php foreach ($result_dep as $key_dep => $value_dep) {
              $num_chkdep = 0;
          if(count($arr_department)>0&&in_array($value_dep['dep_id'], $arr_department)){
            $num_chkdep++;
          }
           ?>
                  <div class="col-lg-3 col-md-12 col-sm-12 chkall_<?php echo $value_com['com_id'] ?>" >

                      <input type="checkbox"  onclick="onchkdep('<?php echo $value_dep['dep_id'] ?>','<?php echo $value_com['com_id']; ?>')" id="chkdep_<?php echo $value_dep['dep_id'] ?>" name="dep_var[]" value="<?php echo $value_posi['dep_id'] ?>" data-com="<?php echo $value_com['com_id']; ?>" class="filled-in chk-col-red chkall_<?php echo $value_com['com_id'] ?>" <?php if($num_chkdep>0){echo "checked";} ?> />
                      <label for="chkdep_<?php echo $value_dep['dep_id'] ?>"><?php if($lang=="thai"){ echo $value_dep['dep_name_th']; }else{ echo $value_dep['dep_name_en']; } ?></label>
                      <div>
                      <!-- <hr> -->
                      <div style="top: -10px;" class="card-body row chkall_<?php echo $value_com['com_id'] ?>" <?php if($allnum_chkdep==0){ ?>style="margin-bottom:2px;display: none;"<?php } ?>>
                      <?php foreach ($result_posi as $key_posi => $value_posi) {

                          $num_chkposi = 0;
                      if(count($arr_department)>0&&in_array($value_posi['dep_id'], $arr_department)){
                        $num_chkposi++;
                      }
                      if($value_posi['dep_id']==$value_dep['dep_id']){
                        ?>
                              <div class="col-12 chkall_<?php echo $value_com['com_id'] ?> chkdepall_<?php echo $value_posi['dep_id'] ?>"  <?php if($num_chkposi>0){ ?> style="margin-top:0px;"<?php }else{ ?>style="margin-bottom:2px;display: none;"<?php } ?>>
                                  <input type="checkbox" id="chkposi_<?php echo $value_posi['posi_id'] ?>" name="posi_var[]" class="filled-in chk-col-red chkposiall_<?php echo $value_posi['dep_id'] ?>" onclick="onchkposi('<?php echo $value_posi['posi_id'] ?>','<?php echo $value_com['com_id']; ?>','<?php echo $value_posi['dep_id'] ?>')" data-com="<?php echo $value_com['com_id']; ?>" <?php if(in_array($value_posi['posi_id'], $arr_position)){ echo "checked";} ?> value="<?php echo $value_posi['posi_id'] ?>" data-dep="<?php echo $value_posi['dep_id']; ?>"  />
                                  <label for="chkposi_<?php echo $value_posi['posi_id'] ?>"><?php if($lang=="thai"){ echo $value_posi['posi_name_th']; }else{ echo $value_posi['posi_name_en']; } ?></label>
                              </div>

                      <?php }
                      } ?>
                      </div>
                      </div>
                  </div>
          <?php } ?>
          </div>
        </div>
      </div>
      <?php
        /*if($numcom<count($result_com)){
          echo '<hr>';
        }*/$numcom++;
      }
      $this->func_query->closeDB();
    }else{
      echo '<h3 align="center">'.label('wg_datanotfound').'</h3>';
    }
  }

  public function update_question_detail_data(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    $this->load->model('Manage_model', 'manage', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->manage->loadDB();
    if(count($_REQUEST)>0){
      $result = $this->func_query->query_row('LMS_QUES','','','','ques_id="'.$_REQUEST['ques_id'].'"');
      if($result['ques_type']=="multi"||$result['ques_type']=="2choice"){
        $result_multi = $this->func_query->query_row('LMS_QUES_MUL','','','','ques_id="'.$_REQUEST['ques_id'].'"');
        $result['multi'] = $result_multi;
      }

      $result['counttc'] = $this->func_query->numrows('LMS_QUES_TC','','','','ques_id="'.$_REQUEST['ques_id'].'" and tc_flag="true" and tc_save="true"');
                  if($lang=="thai"){ 
                    $ques_name = $result['ques_name_th']!=""?$result['ques_name_th']:$result['ques_name_eng'];
                    $ques_name = $ques_name!=""?$ques_name:$result['ques_name_jp'];
                  }else if($lang=="english"){ 
                    $ques_name = $result['ques_name_eng']!=""?$result['ques_name_eng']:$result['ques_name_th'];
                    $ques_name = $ques_name!=""?$ques_name:$result['ques_name_jp'];
                  }else{
                    $ques_name = $result['ques_name_jp']!=""?$result['ques_name_jp']:$result['ques_name_eng'];
                    $ques_name = $ques_name!=""?$ques_name:$result['ques_name_th'];
                  }
      $result['ques_score'] = intval($result['ques_score']);
      $result['ques_name'] = $ques_name;
      echo json_encode($result);
    }
  }

  public function rechk_course_incg(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    $this->load->model('Manage_model', 'manage', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->manage->loadDB();
    if(count($_REQUEST)>0){
      date_default_timezone_set("Asia/Bangkok");
      $cg_id = isset($_REQUEST['cg_id'])?$_REQUEST['cg_id']:"";
      $result_cg = $this->func_query->query_row('LMS_COG','','','','cg_id="'.$cg_id.'"');
      $where = 'LMS_COS.cos_id in (select LMS_COSINCG.course_id from LMS_COSINCG where LMS_COSINCG.cg_id = "'.$cg_id.'") and LMS_COS.cos_isDelete="0"';
      $result = $this->func_query->query_result('LMS_COS','','','',$where);
      $output = array();
      $output['status'] = "0";
      $output['cg_status'] = $result_cg['cg_status'];
      $total_cos = 0;
      if(count($result)>0){
        foreach ($result as $key => $value) {
          $fetch_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id="'.$value['cos_id'].'"');
          if(count($fetch_detail)>0){
              if(($fetch_detail['date_start']=="0000-00-00 00:00:00"&&$fetch_detail['date_end']=="0000-00-00 00:00:00")||(date('Y-m-d H:i',strtotime($fetch_detail['date_end']))>=date('Y-m-d H:i'))){
                  $total_cos++;
              }
          }else{
            $total_cos++;
          }
        }
      }
      if($total_cos>0){
        $output['status'] = "1";
      }
      echo json_encode($output);
    }
  }

  public function rechk_course_inwg(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    $this->load->model('Manage_model', 'manage', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->manage->loadDB();
    if(count($_REQUEST)>0){
      date_default_timezone_set("Asia/Bangkok");
      $wg_id = isset($_REQUEST['wg_id'])?$_REQUEST['wg_id']:"";
      $result_wg = $this->func_query->query_row('LMS_WKG','','','','wg_id="'.$wg_id.'"');
      $where = 'LMS_COS.wg_id = "'.$wg_id.'" and LMS_COS.cos_isDelete="0"';
      $result = $this->func_query->query_result('LMS_COS','','','',$where);
      $output = array();
      $output['status'] = "0";
      $output['wg_status'] = $result_wg['wg_status'];
      $total_cos = 0;
      if(count($result)>0){
        foreach ($result as $key => $value) {
          $fetch_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id="'.$value['cos_id'].'"');
          if(count($fetch_detail)>0){
              if(($fetch_detail['date_start']=="0000-00-00 00:00:00"&&$fetch_detail['date_end']=="0000-00-00 00:00:00")||(date('Y-m-d H:i',strtotime($fetch_detail['date_end']))>=date('Y-m-d H:i'))){
                  $total_cos++;
              }
          }else{
            $total_cos++;
          }
        }
      }
      if($total_cos>0){
        $output['status'] = "1";
      }
      echo json_encode($output);
    }
  }

  public function rechkcodeinfo(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    $this->load->model('Manage_model', 'manage', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->manage->loadDB();
    if(count($_REQUEST)>0){
      date_default_timezone_set("Asia/Bangkok");
      $code = isset($_REQUEST['code'])?$_REQUEST['code']:"";
      $field_name = isset($_REQUEST['field_name'])?$_REQUEST['field_name']:"";
      $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
      $val_2 = isset($_REQUEST['val_2'])?$_REQUEST['val_2']:"";
      $output = array();
      $output['status'] = "1";
      if($field_name=="LMS_DIVISION"){
        $fetch_chk = $this->func_query->query_row('LMS_DIVISION','','','','div_code="'.$code.'" and div_isDelete=0 and com_id = "'.$com_id.'"');
        if(count($fetch_chk)>0){
          $output['status'] = "2";
        }
      }else if($field_name=="LMS_DEPART"){
        $fetch_chk = $this->func_query->query_row('LMS_DEPART','','','','dep_code="'.$code.'" and dep_isDelete=0 and group_id = "'.$val_2.'"');
        if(count($fetch_chk)>0){
          $output['status'] = "2";
        }
      }else if($field_name=="LMS_SECTION"){
        $fetch_chk = $this->func_query->query_row('LMS_SECTION','','','','section_code="'.$code.'" and section_isDelete=0 and dep_id = "'.$val_2.'"');
        if(count($fetch_chk)>0){
          $output['status'] = "2";
        }
      }else if($field_name=="LMS_AREA"){
        $fetch_chk = $this->func_query->query_row('LMS_AREA','','','','salearea_code="'.$code.'" and salearea_isDelete=0 and section_id = "'.$val_2.'"');
        if(count($fetch_chk)>0){
          $output['status'] = "2";
        }
      }else if($field_name=="LMS_GROUP"){
        $fetch_chk = $this->func_query->query_row('LMS_GROUP','','','','group_code="'.$code.'" and group_isDelete=0 and div_id = "'.$val_2.'"');
        if(count($fetch_chk)>0){
          $output['status'] = "2";
        }
      }
      echo json_encode($output);
    }
  }

  public function update_sdve_question_detail_data(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    $this->load->model('Manage_model', 'manage', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->manage->loadDB();
    if(count($_REQUEST)>0){
      $result = $this->func_query->query_row('LMS_SVDE','LMS_SV','LMS_SV.sv_id = LMS_SVDE.sv_id','','svde_id="'.$_REQUEST['svde_id'].'"');
      if($result['svde_type']=="multi"||$result['svde_type']=="2choice"){
        $result_multi = $this->func_query->query_row('LMS_SVDE_MUL','','','','svde_id="'.$_REQUEST['svde_id'].'" and mul_isDelete="0"');
        $result['multi'] = $result_multi;
      }
      echo json_encode($result);
    }
  }

  public function user_approve(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    $this->load->model('Manage_model', 'manage', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $sess = $this->session->userdata("user");
    $this->manage->loadDB();
    if(count($_REQUEST)>0){
      $arr_user = array();
      if(isset($_REQUEST['sv_id'])&&$_REQUEST['sv_id']!=""){
          $fetch_chk = $this->func_query->query_row('LMS_SV','','','','sv_id="'.$_REQUEST['sv_id'].'"');
          if(count($fetch_chk)>0&&$fetch_chk['sv_userapprove']!=""){
              $arr_user = explode(',', $fetch_chk['sv_userapprove']);
          }
      }
      $result = $this->func_query->query_result('LMS_USP','LMS_EMP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_EMP.com_id="'.$_REQUEST['com_id'].'" and LMS_EMP.emp_isDelete="0" and LMS_EMP.emp_id!="'.$sess['emp_id'].'"');
      if(count($result)>0){
        foreach ($result as $key => $value) {
          $select_val = "";
          $fullname = $lang=="thai"?$value['fullname_th']:$value['fullname_en'];
          if(count($arr_user)>0&&in_array($value['emp_id'], $arr_user)){
              $select_val = "selected";
          }
          echo '<option value="'.$value['emp_id'].'" '.$select_val.'>'.$fullname.'</option>';
        }
      }else{
        echo '<option value="">'.label('wg_datanotfound').'</option>';
      }
    }
  }

  public function survey_data(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    $this->load->model('Manage_model', 'manage', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $sess = $this->session->userdata("user");
    $this->manage->loadDB();
    if(count($_REQUEST)>0){
      $result = $this->func_query->query_row('LMS_SURVEY','','','','sv_id="'.$_REQUEST['sv_id'].'"');
      $varselect = "";
      if($_REQUEST['lang_select']=="thai"){ 
        $varselect = "svde_heading_th";
      }else if($_REQUEST['lang_select']=="english"){ 
        $varselect = "svde_heading_eng";
      }else{
        $varselect = "svde_heading_jp";
      }
      $result_head = $this->func_query->query_result('LMS_SURVEY_DE','','','','sv_id="'.$_REQUEST['sv_id'].'" and svde_status="1" and svde_isDelete="0"','svde_id ASC',$varselect);
      $qnu_id = "";
      $fetch_status = $this->func_query->query_row('LMS_QN_USER','','','','emp_id="'.$sess['emp_id'].'" and sv_id="'.$_REQUEST['sv_id'].'"');
      if(count($fetch_status)>0&&$_REQUEST['type']=="real"){
        $qnu_id = $fetch_status['qnu_id'];
      }

                if($_REQUEST['lang_select']=="thai"){
                  $questiontxt = "คำถาม";
                  $Suggestiontxt = "ความคิดเห็น (ถ้ามี)";
                  $choice_5txt = "ดีมาก";
                  $choice_4txt = "ดี";
                  $choice_3txt = "ปานกลาง";
                  $choice_2txt = "พอใช้";
                  $choice_1txt = "ควรปรับปรุง";
                  $Suggestion_anothertxt = "ข้อเสนอแนะ (ถ้ามี)";
                }else{
                  $questiontxt = "Question";
                  $Suggestiontxt = "Suggestion";
                  $choice_5txt = "Very good";
                  $choice_4txt = "Good";
                  $choice_3txt = "Moderate";
                  $choice_2txt = "Fair";
                  $choice_1txt = "Need improvement";
                  $Suggestion_anothertxt = "Suggestion";
                }
        $fetch_condquestion = $this->func_query->query_row('LMS_SURVEY_DE','','','','sv_id="'.$_REQUEST['sv_id'].'" and svde_status="1" and svde_isDelete="0"','','MAX(svde_suggestionactive) as suggestionactive');
      ?>
                  <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="align-middle"><p class="text-left"><?php echo $questiontxt; ?></p></th>
                                <?php 
                                  $rank = intval($result['sv_rank']);
                                  $svde_suggestionactive = intval($fetch_condquestion['suggestionactive']);
                                  $coltotal = 1+$rank;
                                  for ($i=$rank; $i >= 1 ; $i--) { ?>
                                <th><center><?php echo $i; ?></center></th>
                                <?php }
                                      if($svde_suggestionactive==1){ $coltotal += 1; ?>
                                <th class="align-middle"><p class="text-left"><?php echo $Suggestiontxt; ?></p></th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                          <?php
                            if(count($result_head)>0){
                              $num=0;
                              $num_head = 1;
                              $txt_head = "";
                              foreach ($result_head as $key_head => $value_head) {
                                $svde_heading_th = isset($value_head['svde_heading_th'])?$value_head['svde_heading_th']:"";
                                $svde_heading_eng = isset($value_head['svde_heading_eng'])?$value_head['svde_heading_eng']:"";
                                if($_REQUEST['lang_select']=="thai"){ 
                                  $svde_heading = $svde_heading_th!=""?$svde_heading_th:$svde_heading_eng;
                                }else{ 
                                  $svde_heading = $svde_heading_eng!=""?$svde_heading_eng:$svde_heading_th;
                                }
                                ?>

                                <tr>
                                  <td colspan="<?php echo $coltotal; ?>"><h4 class="m-auto"><b><?php echo $svde_heading; ?></b></h4></td>
                                </tr>
                                <?php

                                $varselect = "";
                                if($_REQUEST['lang_select']=="thai"){ 
                                  $varselect = 'and svde_heading_th="'.$svde_heading.'"';
                                }else{ 
                                  $varselect = 'and svde_heading_eng="'.$svde_heading.'"';
                                }
                                $where_detail = 'sv_id="'.$_REQUEST['sv_id'].'" and svde_status="1" and svde_isDelete="0" '.$varselect;
                                $result_detail = $this->func_query->query_result('LMS_SURVEY_DE','','','',$where_detail,'svde_id ASC','');
                                foreach ($result_detail as $key_detail => $value_detail) {

                                    if($qnu_id!=""){
                                      $fetch_detailtc = $this->func_query->query_row('LMS_QN_USER_DE','','','','svde_id="'.$value_detail['svde_id'].'" and qnu_id="'.$qnu_id.'"');
                                    }
                                    
                                    if($_REQUEST['lang_select']=="thai"){ 
                                      $svde_detail = $value_detail['svde_detail_th']!=""?$value_detail['svde_detail_th']:$value_detail['svde_detail_eng'];
                                    }else{ 
                                      $svde_detail = $value_detail['svde_detail_eng']!=""?$value_detail['svde_detail_eng']:$value_detail['svde_detail_th'];
                                    }

                          ?>

                          <input type="hidden" name="svde_id[]" value="<?php echo $value_detail['svde_id']; ?>">
                          <tr>
                                <td><?php echo $svde_detail; ?></td>
                                <?php $numcol = 1;
                                      for ($i=$rank; $i >= 1 ; $i--) { ?>
                                <td>
                                  <center>
                                  <input name="qnude_var[<?php echo $num; ?>]" type="radio" value="<?php echo $i; ?>" id="radio_<?php echo $num.$numcol; ?>" required class="with-gap radio-col-red" <?php if(isset($fetch_detailtc['qnude_var'])&&intval($fetch_detailtc['qnude_var'])==$i){echo "checked";} ?>><label for="radio_<?php echo $num.$numcol; ?>"></label>
                                  </center>
                                </td>
                                <?php   
                                        $numcol++;
                                      } ?>
                                <?php if($svde_suggestionactive==1){ ?>
                                <td><?php if($value_detail['svde_suggestionactive']=="1"){ ?>
                                  <textarea class="form-control" name="qnude_suggestion[<?php echo $num; ?>]" id="qnude_suggestion" rows="3" style="min-width: 200px;"><?php if(isset($fetch_detailtc['qnude_suggestion'])&&$fetch_detailtc['qnude_suggestion']!=""){echo $fetch_detailtc['qnude_suggestion'];} ?></textarea><?php }else{ ?>
                                    <input type="hidden"  name="qnude_suggestion[<?php echo $num; ?>]" id="qnude_suggestion" value="">
                                  <?php } ?>
                                </td>
                                <?php } ?>
                          </tr>
                          <?php  $num++;
                                }
                            }
                          }
                          ?>
                        </tbody>
                    </table>
                    <?php if($result['sv_suggestion_status']=="1"){ ?>
                      <?php echo $Suggestion_anothertxt; ?>
                      <textarea id="qnu_suggestion" name="qnu_suggestion" class="form-control" rows="5"><?php if(isset($fetch_status['qnu_suggestion'])&&$fetch_status['qnu_suggestion']!=""&&$_REQUEST['type']=="real"){echo $fetch_status['qnu_suggestion'];} ?></textarea>
                    <?php } ?>
                  </div>
      <?php
    }
  }
}
