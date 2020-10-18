<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Insertdata extends CI_Controller {

  public function insert_workgroup(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $emp_c = $sess['emp_c'];
    $this->fetch->loadDB();
    $output = array();
    if(isset($_REQUEST)&&!empty($sess['emp_c'])){
        $wtitle_th = isset($_REQUEST['wtitle_th'])?$_REQUEST['wtitle_th']:"";
        $wtitle_en = isset($_REQUEST['wtitle_en'])?$_REQUEST['wtitle_en']:"";
        $wdesc_th = isset($_REQUEST['wdesc_th'])?$_REQUEST['wdesc_th']:"";
        $wdesc_en = isset($_REQUEST['wdesc_en'])?$_REQUEST['wdesc_en']:"";
        $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
        $wg_status = isset($_REQUEST['wg_status'])?$_REQUEST['wg_status']:"0";
        $wg_id = isset($_REQUEST['wg_id'])?$_REQUEST['wg_id']:"";
        //$cg_approve_by = isset($_REQUEST['cg_approve_by'])&&count($_REQUEST['cg_approve_by'])?implode(',', $_REQUEST['cg_approve_by']):"";
        $arr = array(
            'wtitle_th' => $wtitle_th,
            'wtitle_en' => $wtitle_en,
            'wdesc_th' => $wdesc_th,
            'wdesc_en' => $wdesc_en,
            'com_id' => $com_id,
            'wg_status' => $wg_status,
            'wg_modifieddate' => date('Y-m-d H:i'),
            'wg_modifiedby' => $sess['u_id'],
        );

        if(isset($_FILES['wthumb'])&&$_FILES['wthumb']!=""){
          if( isset( $_FILES['wthumb']) ){
              $imageSourcePath = $_FILES['wthumb']['tmp_name'];
              $pathBG = $_FILES['wthumb']['name'];
              if($pathBG!=""){
                  $array_pathext = explode('.', $pathBG);
                  $extension = end($array_pathext);
                  $wthumb = "cog_".date('YmdHis').".".$extension;
                  $imageTargetPath = ROOT_DIR."uploads/work_group/".$wthumb;
                  if($_REQUEST['operation']=="Edit"){
                      $fetch_img = $this->func_query->query_row('LMS_WKG','','','','wg_id="'.$_REQUEST['wg_id'].'"');
                      if(count($fetch_img)>0&&$fetch_img['wthumb']!=""){
                          if(is_file(ROOT_DIR."uploads/work_group/".$fetch_img['wthumb'])) {
                                unlink(ROOT_DIR."uploads/work_group/".$fetch_img['wthumb']);
                          }
                      }
                  }
                  if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
                      $arr['wthumb'] = $wthumb;
                  }
              }
          }
        }

        if($_REQUEST['operation']=="Add"){

              $fetch_company = $this->func_query->query_row('LMS_COMPANY','','','','com_id = "'.$com_id.'"');

              $fetch_id = $this->func_query->query_row('LMS_WKG','','','','','wg_id desc');
              $id2="";
                if(count($fetch_id)>0){
                    $id1 = intval(substr($fetch_id["wcode"],-4));
                    $id1++;
                    if($id1==0||$id1<10){
                       $id2 = $fetch_company['com_code']."000".$id1;
                    }else if($id1==10||$id1<100){
                       $id2 = $fetch_company['com_code']."00".$id1;
                    }else if($id1==100||$id1<1000){
                       $id2 = $fetch_company['com_code']."0".$id1;
                    }else{
                       $id2 = $fetch_company['com_code'].$id1;
                    }
                }else{
                  $id2 = $fetch_company['com_code']."0001";
                }
                $arr['wcode'] = $id2;

            $arr['wg_createdate'] = date('Y-m-d H:i');
            $arr['wg_createby'] = $sess['u_id'];
            $fetch_chk = $this->func_query->numrows('LMS_WKG','','','','wtitle_th="'.$arr['wtitle_th'].'" and wtitle_en="'.$arr['wtitle_en'].'" and com_id="'.$com_id.'" and wg_isDelete="0"');
            if($fetch_chk==0){
              $this->db->insert('LMS_WKG', $arr);
              $id = $this->db->insert_id();
              if($id!=""){
                $output['status'] = "2";
              }else{
                $output['status'] = "3";
              }
            }else{
              $output['status'] = "1";
            }
        }else{
            $arr['wthumb'] = isset($arr['wthumb'])?$arr['wthumb']:$_REQUEST['wthumb_ori'];
            $this->db->where('wg_id',$_REQUEST['wg_id']);
            $this->db->update('LMS_WKG', $arr);  
            $output['status'] = "2";
        }
    }else{
        $output['status'] = "0";
    }
    echo json_encode($output);
  }

  public function insert_coursegroup(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $emp_c = $sess['emp_c'];
    $this->fetch->loadDB();
    $output = array();
    if(isset($_REQUEST)&&!empty($sess['emp_c'])){
        $cgtitle_th = isset($_REQUEST['cgtitle_th'])?$_REQUEST['cgtitle_th']:"";
        $cgtitle_en = isset($_REQUEST['cgtitle_en'])?$_REQUEST['cgtitle_en']:"";
        $cgdesc_th = isset($_REQUEST['cgdesc_th'])?$_REQUEST['cgdesc_th']:"";
        $cgdesc_en = isset($_REQUEST['cgdesc_en'])?$_REQUEST['cgdesc_en']:"";
        $div_id = isset($_REQUEST['div_id'])?$_REQUEST['div_id']:"";
        $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
        $cg_status = isset($_REQUEST['cg_status'])?$_REQUEST['cg_status']:"0";
        $cg_id = isset($_REQUEST['cg_id'])?$_REQUEST['cg_id']:"";
        //$cg_approve_by = isset($_REQUEST['cg_approve_by'])&&count($_REQUEST['cg_approve_by'])?implode(',', $_REQUEST['cg_approve_by']):"";
        $arr = array(
            'cgtitle_th' => $cgtitle_th,
            'cgtitle_en' => $cgtitle_en,
            'cgdesc_th' => $cgdesc_th,
            'cgdesc_en' => $cgdesc_en,
            'com_id' => $com_id,
            'cg_status' => $cg_status,
            'cg_modifieddate' => date('Y-m-d H:i'),
            'cg_modifiedby' => $sess['u_id'],
        );

        if(isset($_FILES['cgthumb'])&&$_FILES['cgthumb']!=""){
          if( isset( $_FILES['cgthumb']) ){
              $imageSourcePath = $_FILES['cgthumb']['tmp_name'];
              $pathBG = $_FILES['cgthumb']['name'];
              if($pathBG!=""){
                  $array_pathext = explode('.', $pathBG);
                  $extension = end($array_pathext);
                  $cgthumb = "cog_".date('YmdHis').".".$extension;
                  $imageTargetPath = ROOT_DIR."uploads/course_group/".$cgthumb;
                  if($_REQUEST['operation']=="Edit"){
                      $fetch_img = $this->func_query->query_row('LMS_COG','','','','cg_id="'.$_REQUEST['cg_id'].'"');
                      if(count($fetch_img)>0&&$fetch_img['cgthumb']!=""){
                          if(is_file(ROOT_DIR."uploads/course_group/".$fetch_img['cgthumb'])) {
                                unlink(ROOT_DIR."uploads/course_group/".$fetch_img['cgthumb']);
                          }
                      }
                  }
                  if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
                      $arr['cgthumb'] = $cgthumb;
                  }
              }
          }
        }

        if($_REQUEST['operation']=="Add"){

              $fetch_company = $this->func_query->query_row('LMS_COMPANY','','','','com_id = "'.$com_id.'"');

              $fetch_id = $this->func_query->query_row('LMS_COG','','','','','cg_id desc');
              $id2="";
                if(count($fetch_id)>0){
                    $id1 = intval(substr($fetch_id["cgcode"],-4));
                    $id1++;
                    if($id1==0||$id1<10){
                       $id2 = $fetch_company['com_code']."000".$id1;
                    }else if($id1==10||$id1<100){
                       $id2 = $fetch_company['com_code']."00".$id1;
                    }else if($id1==100||$id1<1000){
                       $id2 = $fetch_company['com_code']."0".$id1;
                    }else{
                       $id2 = $fetch_company['com_code'].$id1;
                    }
                }else{
                  $id2 = $fetch_company['com_code']."0001";
                }
                $arr['cgcode'] = $id2;

            $arr['cg_createdate'] = date('Y-m-d H:i');
            $arr['cg_createby'] = $sess['u_id'];
            $arr['cg_approve'] = '1';
            $fetch_chk = $this->func_query->numrows('LMS_COG','','','','cgtitle_th="'.$arr['cgtitle_th'].'" and cgtitle_en="'.$arr['cgtitle_en'].'" and com_id="'.$com_id.'" and cg_isDelete="0"');
            if($fetch_chk==0){
              $this->db->insert('LMS_COG', $arr);
              $id = $this->db->insert_id();
              if($id!=""){
                if(count($div_id)>0){
                    for ($i=0; $i < count($div_id); $i++) { 
                      $arr_insert = array(
                          'div_id' => $div_id[$i],
                          'cg_id' => $id,
                          'cgdiv_modifiedby' => $sess['u_id'],
                          'cgdiv_modifieddate' => date('Y-m-d H:i')
                      );
                      $arr_insert['cgdiv_createby'] = $sess['u_id'];
                      $arr_insert['cgdiv_createdate'] = date('Y-m-d H:i');
                      $this->db->insert('LMS_COGINDIV',$arr_insert);
                    }
                }
                $output['status'] = "2";
              }else{
                $output['status'] = "3";
              }
            }else{
              $output['status'] = "1";
            }
        }else{
            $result_cg = $this->func_query->query_row('LMS_COG','','','','cg_id="'.$_REQUEST['cg_id'].'"');
            $this->db->where('cg_id',$_REQUEST['cg_id']);
            $this->db->update('LMS_COG', $arr);  
            if(count($div_id)>0){
                $arrrechk_div = implode(",",$div_id);
                $arr_update = array(
                  'cgdiv_isDelete' => '1',
                  'cgdiv_modifiedby' => $sess['u_id'],
                  'cgdiv_modifieddate' => date('Y-m-d H:i')
                );
                $this->db->where('div_id not in ('.$arrrechk_div.') and cg_id = "'.$_REQUEST['cg_id'].'"');
                $this->db->update('LMS_COGINDIV',$arr_update);
            }else{
                $arr_update = array(
                  'cgdiv_isDelete' => '1',
                  'cgdiv_modifiedby' => $sess['u_id'],
                  'cgdiv_modifieddate' => date('Y-m-d H:i')
                );
                $this->db->where('cg_id = "'.$_REQUEST['cg_id'].'"');
                $this->db->update('LMS_COGINDIV',$arr_update);
            }
                if(count($div_id)>0){
                    for ($i=0; $i < count($div_id); $i++) { 
                      $arr_insert = array(
                          'div_id' => $div_id[$i],
                          'cg_id' => $_REQUEST['cg_id'],
                          'cgdiv_modifiedby' => $sess['u_id'],
                          'cgdiv_modifieddate' => date('Y-m-d H:i')
                      );
                      $arr_insert['cgdiv_createby'] = $sess['u_id'];
                      $arr_insert['cgdiv_createdate'] = date('Y-m-d H:i');
                      $this->db->insert('LMS_COGINDIV',$arr_insert);
                    }
                }
            $output['status'] = "2";
        }
    }else{
        $output['status'] = "0";
    }
    echo json_encode($output);
  }

  public function insert_cosmain(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $emp_c = $sess['emp_c'];
    $this->fetch->loadDB();
    $output = array();
    if(isset($_REQUEST)&&!empty($sess['emp_c'])){
        $com_id = isset($_REQUEST['com_id'])?$_REQUEST['com_id']:"";
        $ccode = isset($_REQUEST['ccode'])?$_REQUEST['ccode']:"";
        $wg_id = isset($_REQUEST['wg_id'])?$_REQUEST['wg_id']:"";
        $cg_id = isset($_REQUEST['cg_id'])?$_REQUEST['cg_id']:"";
        $tc_id = isset($_REQUEST['tc_id'])?$_REQUEST['tc_id']:"";
        $cos_lang = isset($_REQUEST['cos_lang'])?implode(',', $_REQUEST['cos_lang']):"";
        $cname_th = isset($_REQUEST['cname_th'])?$_REQUEST['cname_th']:"";
        $sub_description_th = isset($_REQUEST['sub_description_th'])?$_REQUEST['sub_description_th']:"";
        $cdesc_th = isset($_REQUEST['cdesc_th'])?$_REQUEST['cdesc_th']:"";
        $cname_eng = isset($_REQUEST['cname_eng'])?$_REQUEST['cname_eng']:"";
        $sub_description_eng = isset($_REQUEST['sub_description_eng'])?$_REQUEST['sub_description_eng']:"";
        $cdesc_eng = isset($_REQUEST['cdesc_eng'])?$_REQUEST['cdesc_eng']:"";
        $condition = isset($_REQUEST['condition'])?implode(',', $_REQUEST['condition']):"";
        $cos_status = isset($_REQUEST['cos_status'])?$_REQUEST['cos_status']:"0";
        $goal_score = isset($_REQUEST['goal_score'])?$_REQUEST['goal_score']:"";
        $cos_typegrading = isset($_REQUEST['cos_typegrading'])?$_REQUEST['cos_typegrading']:"";
        $seat_count = isset($_REQUEST['seat_count'])?$_REQUEST['seat_count']:"";
        $cos_hour = isset($_REQUEST['cos_hour'])?$_REQUEST['cos_hour']:"";
        $badges_name = isset($_REQUEST['badges_name'])?$_REQUEST['badges_name']:"";
        $badges_condition = isset($_REQUEST['badges_condition'])?$_REQUEST['badges_condition']:"";
        $badges_desc = isset($_REQUEST['badges_desc'])?$_REQUEST['badges_desc']:"";
        $mina_plus = isset($_REQUEST['mina_plus'])?$_REQUEST['mina_plus']:"";
        $mina = isset($_REQUEST['mina'])?$_REQUEST['mina']:"";
        $minb_plus = isset($_REQUEST['minb_plus'])?$_REQUEST['minb_plus']:"";
        $minb = isset($_REQUEST['minb'])?$_REQUEST['minb']:"";
        $minc_plus = isset($_REQUEST['minc_plus'])?$_REQUEST['minc_plus']:"";
        $minc = isset($_REQUEST['minc'])?$_REQUEST['minc']:"";
        $mind_plus = isset($_REQUEST['mind_plus'])?$_REQUEST['mind_plus']:"";
        $mind = isset($_REQUEST['mind'])?$_REQUEST['mind']:"";
        $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
        $cos_expire_noti = isset($_REQUEST['cos_expire_noti'])?$_REQUEST['cos_expire_noti']:"0";
        $cos_iscutgrade = isset($_REQUEST['cos_iscutgrade'])?$_REQUEST['cos_iscutgrade']:"0";
        $cos_ispassquizendcos = isset($_REQUEST['cos_ispassquizendcos'])?$_REQUEST['cos_ispassquizendcos']:"0";
        if($cos_typegrading!="1"){
          $mina = isset($_REQUEST['mina_b'])?$_REQUEST['mina_b']:"";
          $mina_plus = 0;
          $minb_plus = 0;
          $minb = 0;
          $minc_plus = 0;
          $minc = 0;
          $mind_plus = 0;
          $mind = 0;
        }
        $arr_cos = array(
            'com_id' => $com_id,
            'ccode' => $ccode,
            'wg_id' => $wg_id,
            'tc_id' => $tc_id,
            'cos_lang' => $cos_lang,
            'cname_th' => $cname_th,
            'sub_description_th' => $sub_description_th,
            'cdesc_th' => $cdesc_th,
            'cname_eng' => $cname_eng,
            'sub_description_eng' => $sub_description_eng,
            'cdesc_eng' => $cdesc_eng,
            'condition' => $condition,
            'cos_status' => $cos_status,
            'goal_score' => $goal_score,
            'cos_typegrading' => $cos_typegrading,
            'seat_count' => $seat_count,
            'cos_expire_noti' => $cos_expire_noti,
            'cos_iscutgrade' => $cos_iscutgrade,
            'cos_ispassquizendcos' => $cos_ispassquizendcos,
            'cos_hour' => $cos_hour,
            'cos_modifiedby' => $sess['u_id'],
            'cos_modifieddate' => date('Y-m-d H:i')
        );


        if(isset($_FILES['cos_pic'])&&$_FILES['cos_pic']!=""){
          if( isset( $_FILES['cos_pic']) ){
              $imageSourcePath = $_FILES['cos_pic']['tmp_name'];
              $pathBG = $_FILES['cos_pic']['name'];
              if($pathBG!=""){
                  $array_pathext = explode('.', $pathBG);
                  $extension = end($array_pathext);
                  $cos_pic = "cos_".date('YmdHis').".".$extension;
                  $imageTargetPath = ROOT_DIR."uploads/course/".$cos_pic;
                  if($_REQUEST['operation']=="Edit"){
                      $fetch_img = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$_REQUEST['cos_id'].'"');
                      if(count($fetch_img)>0&&$fetch_img['cos_pic']!=""){
                        if(is_file(ROOT_DIR."uploads/course/".$fetch_img['cos_pic'])) {
                          unlink(ROOT_DIR."uploads/course/".$fetch_img['cos_pic']);
                        }
                      }
                  }
                  if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
                      $arr_cos['cos_pic'] = $cos_pic;
                  }
              }
          }
        }

        if($lang=="thai"){ 
          $cname = $arr_cos['cname_th']!=""?$arr_cos['cname_th']:$arr_cos['cname_eng'];
        }else if($lang=="english"){ 
          $cname = $arr_cos['cname_eng']!=""?$arr_cos['cname_eng']:$arr_cos['cname_th'];
        }
        if($_REQUEST['operation']=="Add"){
            $arr_cos['cos_createdate'] = date('Y-m-d H:i');
            $arr_cos['cos_createby'] = $sess['u_id'];

            $where = '';
            if($arr_cos['cname_th']!=""){
              $where .= ' and cname_th="'.$arr_cos['cname_th'].'"';
            }
            if($arr_cos['cname_eng']!=""){
              $where .= ' and cname_eng="'.$arr_cos['cname_eng'].'"';
            }
            $fetch_chk = $this->func_query->numrows('LMS_COS','','','','com_id = "'.$com_id.'" and cos_isDelete="0"'.$where);
            if($fetch_chk==0){
              include ROOT_DIR."assets/plugins/phpqrcode/qrlib.php"; 
              $errorCorrectionLevel = 'L';
              $matrixPointSize = 6;
              $this->db->insert('LMS_COS', $arr_cos);
              $id = $this->db->insert_id();
              if($id!=""){
                $link = base_url()."qrcode/detail/".$id;
                $filename = ROOT_DIR."uploads/qrcode/".$id.".png";
                QRcode::png($arr_cos['ccode'], $filename, $errorCorrectionLevel, $matrixPointSize, 2);  
                if(count($cg_id)>0){
                  for ($i=0; $i < count($cg_id); $i++) { 
                    $arr_cg = array(
                      'course_id' => $id,
                      'cg_id' => $cg_id[$i]
                    );
                    $this->db->insert('LMS_COSINCG',$arr_cg);
                  }
                }
                $arr_cug = array(
                  'course_id' => $id,
                  'mina_plus' => $mina_plus,
                  'mina' => $mina,
                  'minb_plus' => $minb_plus,
                  'minb' => $minb,
                  'minc_plus' => $minc_plus,
                  'minc' => $minc,
                  'mind_plus' => $mind_plus,
                  'mind' => $mind,
                );
                $this->db->insert('LMS_CUG',$arr_cug);

                if($badges_name!=""){
                    $arr_badges = array(
                      'courses_id' => $id,
                      'badges_name' => $badges_name,
                      'badges_desc' => $badges_desc,
                      'badges_condition' => $badges_condition,
                      'time_create' => date('Y-m-d H:i'),
                    );
                    if(isset($_FILES['badges_img'])&&$_FILES['badges_img']!=""){
                      if( isset( $_FILES['badges_img']) ){
                          $imageSourcePath = $_FILES['badges_img']['tmp_name'];
                          $pathBG = $_FILES['badges_img']['name'];
                          if($pathBG!=""){
                              $array_pathext = explode('.', $pathBG);
                              $extension = end($array_pathext);
                              $badges_img = "cog_".date('YmdHis').".".$extension;
                              $imageTargetPath = ROOT_DIR."uploads/badges/".$badges_img;
                              if($_REQUEST['operation']=="Edit"){
                                  $fetch_img = $this->func_query->query_row('LMS_BAD','','','','courses_id="'.$_REQUEST['cos_id'].'"');
                                  if(count($fetch_img)>0&&$fetch_img['badges_img']!=""){
                                      if(is_file(ROOT_DIR."uploads/badges/".$fetch_img['badges_img'])) {
                                        unlink(ROOT_DIR."uploads/badges/".$fetch_img['badges_img']);
                                      }
                                  }
                              }
                              if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
                                  $arr_badges['badges_img'] = $badges_img;
                              }
                          }
                      }
                    }
                    $this->db->insert('LMS_BAD',$arr_badges);
                }
                $output['status'] = "2";
              }else{
                $output['status'] = "3";
              }
            }else{
              $output['status'] = "1";
            }
        }else{
          if($sess['ug_id']!="1"){
              $arr_cos['cos_public'] = "0";
          }
            $this->db->where('cos_id',$_REQUEST['cos_id']);
            $this->db->update('LMS_COS', $arr_cos);
                $this->db->where('course_id',$_REQUEST['cos_id']);
                $this->db->delete('LMS_COSINCG');
                if(count($cg_id)>0){
                  for ($i=0; $i < count($cg_id); $i++) { 
                    $arr_cg = array(
                      'course_id' => $_REQUEST['cos_id'],
                      'cg_id' => $cg_id[$i]
                    );
                    $this->db->insert('LMS_COSINCG',$arr_cg);
                  }
                }
                $arr_cug = array(
                  'mina_plus' => $mina_plus,
                  'mina' => $mina,
                  'minb_plus' => $minb_plus,
                  'minb' => $minb,
                  'minc_plus' => $minc_plus,
                  'minc' => $minc,
                  'mind_plus' => $mind_plus,
                  'mind' => $mind,
                );
                $this->db->where('course_id',$_REQUEST['cos_id']);
                $this->db->update('LMS_CUG',$arr_cug);

                if($badges_name!=""){
                    $arr_badges = array(
                      'courses_id' => $_REQUEST['cos_id'],
                      'badges_name' => $badges_name,
                      'badges_desc' => $badges_desc,
                      'badges_condition' => $badges_condition,
                      'time_create' => date('Y-m-d H:i'),
                    );
                    if(isset($_FILES['badges_img'])&&$_FILES['badges_img']!=""){
                      if( isset( $_FILES['badges_img']) ){
                          $imageSourcePath = $_FILES['badges_img']['tmp_name'];
                          $pathBG = $_FILES['badges_img']['name'];
                          if($pathBG!=""){
                              $array_pathext = explode('.', $pathBG);
                              $extension = end($array_pathext);
                              $badges_img = "cog_".date('YmdHis').".".$extension;
                              $imageTargetPath = ROOT_DIR."uploads/badges/".$badges_img;
                              if($_REQUEST['operation']=="Edit"){
                                  $fetch_img = $this->func_query->query_row('LMS_BAD','','','','courses_id="'.$_REQUEST['cos_id'].'"');
                                  if(count($fetch_img)>0&&$fetch_img['badges_img']!=""){
                                      if(is_file(ROOT_DIR."uploads/badges/".$fetch_img['badges_img'])) {
                                        unlink(ROOT_DIR."uploads/badges/".$fetch_img['badges_img']);
                                      }
                                  }
                              }
                              if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
                                  $arr_badges['badges_img'] = $badges_img;
                              }
                          }
                      }
                    }
                    $fetch_chk = $this->func_query->query_row('LMS_BAD','','','','courses_id="'.$_REQUEST['cos_id'].'"');
                    if(count($fetch_chk)==0){
                      $this->db->insert('LMS_BAD',$arr_badges);
                    }else{
                      $this->db->where('courses_id',$_REQUEST['cos_id']);
                      $this->db->update('LMS_BAD',$arr_badges);
                    }
                }
            $output['status'] = "2";
        }
    }else{
        $output['status'] = "0";
    }
    echo json_encode($output);
  }

  public function insert_documentincos(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $emp_c = $sess['emp_c'];
    $this->fetch->loadDB();
    $output = array();
    if(isset($_REQUEST)&&!empty($sess['emp_c'])){
        $fil_lang = isset($_REQUEST['fil_lang'])?$_REQUEST['fil_lang']:"";
        $name_file_th = isset($_REQUEST['name_file_th'])?$_REQUEST['name_file_th']:"";
        $name_file_eng = isset($_REQUEST['name_file_eng'])?$_REQUEST['name_file_eng']:"";
        $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";

        $arr_doccos = array(
          'cos_id' => $cos_id,
          'fil_lang' => $fil_lang,
          'name_file_th' => $name_file_th,
          'name_file_eng' => $name_file_eng,
          'fil_modifiedby' => $sess['u_id'],
          'fil_modifieddate' => date('Y-m-d H:i')
        );

        $arr_update = array('cos_modifieddate'=>date('Y-m-d H:i:s'));
        $this->db->where('cos_id',$cos_id);
        $this->db->update('LMS_COS',$arr_update);
        if(isset($_FILES['path_file'])&&$_FILES['path_file']!=""){
          if( isset( $_FILES['path_file']) ){
              $imageSourcePath = $_FILES['path_file']['tmp_name'];
              $pathBG = $_FILES['path_file']['name'];
              if($pathBG!=""){
                  $array_pathext = explode('.', $pathBG);
                  $extension = end($array_pathext);
                  $path_file = "cosdoc_".date('YmdHis').".".$extension;
                  $imageTargetPath = ROOT_DIR."uploads/document/".$path_file;
                  if($_REQUEST['operation_doccos']=="Edit"){
                      $fetch_img = $this->func_query->query_row('LMS_COS_FIL','','','','fil_cos_id="'.$_REQUEST['fil_cos_id'].'"');
                      if(count($fetch_img)>0&&$fetch_img['path_file']!=""){
                          if(is_file(ROOT_DIR."uploads/document/".$fetch_img['path_file'])) {
                                unlink(ROOT_DIR."uploads/document/".$fetch_img['path_file']);
                          }
                      }
                  }
                  if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
                      $arr_doccos['path_file'] = $path_file;
                  }
              }
          }
        }
        if($_REQUEST['fil_cos_id']==""){
          $fetch_chk = $this->func_query->numrows('LMS_COS_FIL','','','',' fil_lang="'.$arr_doccos['fil_lang'].'" and name_file_th="'.$arr_doccos['name_file_th'].'" and name_file_eng="'.$arr_doccos['name_file_eng'].'" and cos_id="'.$arr_doccos['cos_id'].'" and fil_isDelete="0"');
            if($fetch_chk==0){
              $this->db->insert('LMS_COS_FIL', $arr_doccos);
              $id = $this->db->insert_id();
              if($id!=""){
                $output['status'] = "2";
              }else{
                $output['status'] = "3";
              }
            }else{
              $output['status'] = "1";
            }
        }else{
            $this->db->where('fil_cos_id',$_REQUEST['fil_cos_id']);
            $this->db->update('LMS_COS_FIL', $arr_doccos);
            $output['status'] = "2";
        }
    }else{
        $output['status'] = "0";
    }
    echo json_encode($output);

  }

  public function insert_periodandpermission(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $emp_c = $sess['emp_c'];
    $this->fetch->loadDB();
    $output = array();
    if(isset($_REQUEST)&&!empty($sess['emp_c'])){
        $cos_id = isset($_REQUEST['course_id_pp'])?$_REQUEST['course_id_pp']:"";
        $time_start = isset($_REQUEST['time_start'])?$_REQUEST['time_start'].":00":"00:00:00";
        $time_end = isset($_REQUEST['time_end'])?$_REQUEST['time_end'].":00":"00:00:00";
        $date_start = isset($_REQUEST['date_start_var'])&&$_REQUEST['date_start_var']!=""?$_REQUEST['date_start_var']." ".$time_start:"0000-00-00 00:00:00";
        $date_end = isset($_REQUEST['date_end_var'])&&$_REQUEST['date_end_var']!=""?$_REQUEST['date_end_var']." ".$time_end:"0000-00-00 00:00:00";
        $point_redeem = isset($_REQUEST['point_redeem'])?$_REQUEST['point_redeem']:"";
        $get_point = isset($_REQUEST['get_point'])?$_REQUEST['get_point']:"";
        $posi_var = isset($_REQUEST['posi_var'])?$_REQUEST['posi_var']:"";
        $posi_id = isset($_REQUEST['posi_id'])?$_REQUEST['posi_id']:"";
        $cosde_status = isset($_REQUEST['cosde_status'])?$_REQUEST['cosde_status']:"0";
        $cosde_id = isset($_REQUEST['cosde_id'])?$_REQUEST['cosde_id']:"";
        $arr_period = array(
            'cos_id' => $cos_id,
            'date_start' => $date_start,
            'date_end' => $date_end,
            'point_redeem' => $point_redeem,
            'get_point' => $get_point,
            'cosde_status' => $cosde_status,
            'cosde_modifiedby' => $sess['u_id'],
            'cosde_modifieddate' => date('Y-m-d H:i:s')
        );

        $fetch_les = $this->func_query->query_result('LMS_LES','','','','cos_id="'.$cos_id.'" and time_start!="0000-00-00 00:00:00" and time_end!="0000-00-00 00:00:00" and les_isDelete="0"');
        $fetch_qiz = $this->func_query->query_result('LMS_QIZ','','','','cos_id="'.$cos_id.'" and period_open!="0000-00-00 00:00:00" and period_end!="0000-00-00 00:00:00" and quiz_isDelete="0"');
        $fetch_sv = $this->func_query->query_result('LMS_SURVEY','','','','cos_id="'.$cos_id.'" and survey_open!="0000-00-00 00:00:00" and survey_end!="0000-00-00 00:00:00" and sv_isDelete="0"');

        $arr_update = array('cos_modifieddate'=>date('Y-m-d H:i:s'));
        $this->db->where('cos_id',$cos_id);
        $this->db->update('LMS_COS',$arr_update);
        if(count($fetch_les)>0){
          foreach ($fetch_les as $key => $value) {
            $arr_update = array();
            if($value['time_start']!=$date_start){
              $arr_update['time_start'] = $date_start;
            }
            if($value['time_end']!=$date_end){
              $arr_update['time_end'] = $date_end;
            }
            if(count($arr_update)>0){
                $this->db->where('les_id',$value['les_id']);
                $this->db->update('LMS_LES',$arr_update);
            }
          }
        }
        if(count($fetch_qiz)>0){
          foreach ($fetch_qiz as $key => $value) {
            $arr_update = array();
            if($value['period_open']!=$date_start){
              $arr_update['period_open'] = $date_start;
            }
            if($value['period_end']!=$date_end){
              $arr_update['period_end'] = $date_end;
            }
            if(count($arr_update)>0){
                $this->db->where('qiz_id',$value['qiz_id']);
                $this->db->update('LMS_QIZ',$arr_update);
            }
          }
        }
        if(count($fetch_sv)>0){
          foreach ($fetch_sv as $key => $value) {
            $arr_update = array();
            if($value['survey_open']!=$date_start){
              $arr_update['survey_open'] = $date_start;
            }
            if($value['survey_end']!=$date_end){
              $arr_update['survey_end'] = $date_end;
            }
            if(count($arr_update)>0){
                $this->db->where('sv_id',$value['sv_id']);
                $this->db->update('LMS_SURVEY',$arr_update);
            }
          }
        }
        if($_REQUEST['operation_pp']=="Add"){

              $fetch_chk = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id="'.$cos_id.'" and cosde_isDelete="0"');
              if(count($fetch_chk)==0){
                $arr_period['cosde_createby'] = $sess['u_id'];
                $arr_period['cosde_createdate'] = date('Y-m-d H:i');
                $this->db->insert('LMS_COS_DETAIL',$arr_period);
                $cosde_id = $this->db->insert_id();
                if($cosde_id!=""&&count($posi_var)>0){
                  for ($i=0; $i < count($posi_var); $i++) { 
                    if(isset($posi_var[$i])&&isset($posi_id[$i])&&$posi_var[$i]!=""){
                      $arr_ug = array(
                        'cos_id' =>  $cos_id,
                        'posi_id' =>  $posi_id[$i],
                        'tc_id' =>  $posi_var[$i],
                        'cosposi_createdate' =>  date('Y-m-d H:i')
                      );
                      $this->db->insert('LMS_COS_POSITION',$arr_ug);
                    }
                  }
                }
              }else{
                $this->db->where('cosde_id',$fetch_chk['cosde_id']);
                $this->db->update('LMS_COS_DETAIL',$arr_period);
                if($cosde_id!=""&&count($posi_var)>0){
                  $this->db->where('cos_id',$cos_id);
                  $this->db->delete('LMS_COS_POSITION');
                  for ($i=0; $i < count($posi_var); $i++) { 
                      if(isset($posi_var[$i])&&isset($posi_id[$i])&&$posi_var[$i]!=""){
                        $arr_ug = array(
                          'cos_id' =>  $cos_id,
                          'posi_id' =>  $posi_id[$i],
                          'tc_id' =>  $posi_var[$i],
                          'cosposi_createdate' =>  date('Y-m-d H:i')
                        );
                        $this->db->insert('LMS_COS_POSITION',$arr_ug);
                      }   
                  }
                }
              }
                $output['status'] = "2";
          
        }else{
          $this->db->where('cosde_id',$cosde_id);
          $this->db->update('LMS_COS_DETAIL',$arr_period);
          if($cosde_id!=""&&count($posi_var)>0){
            $this->db->where('cos_id',$cos_id);
            $this->db->delete('LMS_COS_POSITION');
            for ($i=0; $i < count($posi_var); $i++) { 
                if(isset($posi_var[$i])&&isset($posi_id[$i])&&$posi_var[$i]!=""){
                  $arr_ug = array(
                    'cos_id' =>  $cos_id,
                    'posi_id' =>  $posi_id[$i],
                    'tc_id' =>  $posi_var[$i],
                    'cosposi_createdate' =>  date('Y-m-d H:i')
                  );
                  $this->db->insert('LMS_COS_POSITION',$arr_ug);
                }   
            }
          }
          $output['status'] = "2";
        }
    }else{
        $output['status'] = "0";
    }
    echo json_encode($output);
  }


  private function getYoutubeEmbedUrl($url){

      $urlParts   = explode('/', $url);
      $vidid      = explode( '&', str_replace('watch?v=', '', end($urlParts) ) );

      return '//www.youtube.com/embed/' . $vidid[0] ;
  }

  private function reArrayFiles($file)
  {
      $file_ary = array();
      $file_count = count($file['name']);
      $file_key = array_keys($file);

      for($i=0;$i<$file_count;$i++)
      {
          foreach($file_key as $val)
          {
              $file_ary[$i][$val] = $file[$val][$i];
          }
      }
      return $file_ary;
  }


  public function insert_lesson(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->load->model('Course_model', 'course', FALSE);
    $this->load->model('Log_model', 'lg', FALSE);
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $emp_c = $sess['emp_c'];
    $this->fetch->loadDB();
    $output = array();
    if(isset($_REQUEST)&&!empty($sess['emp_c'])){

        function getContentUrl($url) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/21.0 (compatible; MSIE 8.01; Windows NT 5.0)');
            curl_setopt($ch, CURLOPT_TIMEOUT, 200);
            curl_setopt($ch, CURLOPT_AUTOREFERER, false);
            curl_setopt($ch, CURLOPT_REFERER, 'http://google.com');
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);    // Follows redirect responses
            // gets the file content, trigger error if false
            $file = curl_exec($ch);
            if($file === false) trigger_error(curl_error($ch));
            curl_close ($ch);
            return $file;
        }
        $course_id_lesson = isset($_REQUEST['course_id_lesson']) ? $_REQUEST['course_id_lesson'] : '';
        $les_lang = isset($_REQUEST['les_lang']) ? $_REQUEST['les_lang'] : '';
        $les_name_th = isset($_REQUEST['les_name_th']) ? $_REQUEST['les_name_th'] : '';
        $les_info_th = isset($_REQUEST['les_info_th']) ? $_REQUEST['les_info_th'] : '';
        $les_name_eng = isset($_REQUEST['les_name_eng']) ? $_REQUEST['les_name_eng'] : '';
        $les_info_eng = isset($_REQUEST['les_info_eng']) ? $_REQUEST['les_info_eng'] : '';
        $time_start = isset($_REQUEST['time_start_les']) ? $_REQUEST['time_start_les'] : '00:00:00';
        $time_end = isset($_REQUEST['time_end_les']) ? $_REQUEST['time_end_les'] : '00:00:00';
        $date_start = isset($_REQUEST['date_start_les_var']) ? $_REQUEST['date_start_les_var']." ". $time_start : '0000-00-00 00:00:00';
        $date_end = isset($_REQUEST['date_end_les_var']) ? $_REQUEST['date_end_les_var']." ".$time_end : '0000-00-00 00:00:00';
        $status_les = isset($_REQUEST['status_les']) ? $_REQUEST['status_les'] : '0';
        $les_type = isset($_REQUEST['les_type']) ? $_REQUEST['les_type'] : '1';
        $scm_type = isset($_REQUEST['scm_type']) ? $_REQUEST['scm_type'] : '0';
        $les_isSeekbar = isset($_REQUEST['les_isSeekbar']) ? $_REQUEST['les_isSeekbar'] : '0';
        $data = array(
            'cos_id' => $course_id_lesson,
            'les_lang' => $les_lang,
            'les_name_th' => $les_name_th,
            'les_info_th' => $les_info_th,
            'les_name_eng' => $les_name_eng,
            'les_info_eng' => $les_info_eng,
            'les_type' => $les_type,
            'scm_type' => $scm_type,
            'les_isSeekbar' => $les_isSeekbar,
            'time_start' => $date_start,
            'time_end' => $date_end,
            'les_status' => $status_les,
            'les_modifiedby' => $sess['u_id'],
            'les_modifieddate' => date('Y-m-d H:i')
        );
        $arr_update = array('cos_modifieddate'=>date('Y-m-d H:i:s'));
        $this->db->where('cos_id',$course_id_lesson);
        $this->db->update('LMS_COS',$arr_update);
        if($_REQUEST['operation_lesson']=="Add"){
          $data['les_createby'] = $sess['u_id'];
          $data['les_createdate'] = date('Y-m-d H:i');
          $this->db->insert('LMS_LES',$data);
          $lesson_id = $this->db->insert_id();

          $courses = $this->course->query_data_onupdate($course_id_lesson, 'LMS_COS','cos_id');
          $this->lg->record('course', 'Create Lesson : '.$les_name_th.' of course '.$courses['cname_th'].'('.$courses['ccode'].')'.' By '.$sess['fullname_th']);
          if($les_type=="1"){
            if($_REQUEST['type_media']=="1"){
              if($_REQUEST['url_media']!=""){
                $arrurl = explode(",", $_REQUEST['url_media']);
                for($num_url=0;$num_url<count($arrurl);$num_url++){
                  $url = $this->getYoutubeEmbedUrl($arrurl[$num_url]);
                  $arr_youtube =  explode("//www.youtube.com/embed/",$url);
                  $id_yt = isset($arr_youtube[1])?str_replace(array("\n", "\r"), '', $arr_youtube[1]):"";
                  //$input = 'https://img.youtube.com/vi/'.$id_youtube[1].'/hqdefault.jpg';
                            $dirimg = ROOT_DIR.'uploads/thumbnail/';            // directory in which the image will be saved
                            $localfile = 'thumbnail_'.date('dmYHis').$num_url.'.jpg';         // set image name the same as the file name of the source
                            // create the file with the image on the server
        $varyoutube =  json_decode(getContentUrl('http://www.youtube.com/oembed?format=json&url=https://www.youtube.com/watch?v='.$id_yt), true);
                    if(isset($varyoutube['thumbnail_url'])&&$varyoutube['thumbnail_url']!=""){

                      $r = file_put_contents($dirimg.$localfile, getContentUrl($varyoutube['thumbnail_url']));
                            /*if(getContentUrl($input)!=""){
                              $r = file_put_contents($dirimg.$localfile, getContentUrl($input));*/
                              if(!$r){
                                  $localfile = "default_cover.jpg";
                              }
                            }else{
                              $localfile = "default_cover.jpg";
                            }
                  $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$id_yt);
                  $title = isset($ytarr['title'])?$ytarr['title']:"";
                  parse_str($content, $ytarr);
                  $each = array(
                    'lessons_id' => $lesson_id,
                    'med_name_th' => $title,
                    'med_name_eng' => $title,
                    'thumbnail_med' => $localfile,
                    'type' => 'url',
                    'video' => $url
                  );
                  $this->course->insert_data_media($each,$lesson_id,'url',$url);
                }
              }
            }else if($_REQUEST['type_media']=="2"){
              if(!empty($_FILES['media_file'])){
                    $thumbnail = "";
                    if(!empty($_FILES['thumbnail_med'])){
                        if($_FILES['thumbnail_med']['tmp_name']!=""){
                            $thumbnail = 'thumbnail_'.date('dmYHis').'.jpg';
                            if(!move_uploaded_file($_FILES['thumbnail_med']['tmp_name'],ROOT_DIR."uploads/thumbnail/".$thumbnail)){
                              $thumbnail = "";
                            }
                        }
                    }
                      $newname = 'MediaLesson_'.date('dmYHis').'.mp4';
                      if(move_uploaded_file($_FILES['media_file']['tmp_name'],ROOT_DIR."uploads/media/".$newname)){
                        $each = array(
                          'lessons_id' => $lesson_id,
                          'med_name_th' => isset($_REQUEST['med_name_th'])?$_REQUEST['med_name_th']:"",
                          'med_name_eng' => isset($_REQUEST['med_name_eng'])?$_REQUEST['med_name_eng']:"",
                          'thumbnail_med' => $thumbnail,
                          'type' => 'upload',
                          'video' => $newname
                        );
                        $this->course->insert_data_media($each,$lesson_id,'upload',$newname);
                      }
              }
            }

            if(!empty($_FILES['path_file'])){

              $path_file = $this->reArrayFiles($_FILES['path_file']);
                //print_r($path_file);
              $name_file_th = isset($_REQUEST['name_file_th']) ? $_REQUEST['name_file_th'] : '';
              $name_file_eng = isset($_REQUEST['name_file_eng']) ? $_REQUEST['name_file_eng'] : '';
              $path_file_ori = $_REQUEST['path_file_ori'];
              $id_fil = $_REQUEST['id_fil'];
              $num_doc = 1;$num_count = 0;
              if(count($path_file)>0){
                foreach($path_file as $val)
                {
                  if($val['name']!=""){
                    if($id_fil[$num_count]==""){
                      $path_parts = pathinfo($val['name']);
                      if(count($path_parts)>0){
                          $newname = 'DocumentLesson_'.date('dmYHis').$num_doc.".".$path_parts['extension'];
                          if(move_uploaded_file($val['tmp_name'],ROOT_DIR."uploads/document/".$newname)){
                              $each = array(
                                'lessons_id' => $lesson_id,
                                'path_file' => $newname,
                                'name_file_th' => isset($name_file_th[$num_count])?$name_file_th[$num_count]:"",
                                'name_file_eng' => isset($name_file_eng[$num_count])?$name_file_eng[$num_count]:"",
                              );
                              $this->course->insert_data_document($each);
                          }
                      }
                    }
                      $num_doc++;
                  }
                  $num_count++;
                }
              }
            }
          }else{
            if(!empty($_FILES['scorm_file'])){
              $scmCode = $this->course->create_scorm_id($lesson_id);
              $path = "scorm_".$lesson_id."_".$scmCode;
                  $newDir = ROOT_DIR."uploads/scorm/".$path;
                  mkdir($newDir);
                  $scormFile = $_FILES['scorm_file'];
                  $sourcePath = $scormFile['tmp_name'];
                  $path_parts = pathinfo($scormFile['name']);
                  $targetPath = $newDir."/".$path.".".$path_parts['extension'];
                  if( move_uploaded_file( $sourcePath,$targetPath ) ){
                    $zip = new ZipArchive;
                      $openZip = $zip->open($targetPath);
                      $zip->extractTo($newDir);
                      $zip->close();
                      $this->course->update_scorm_id($scmCode,$path);
                  }else{
                    $this->course->delete_data($scmCode,'id','LMS_SCM');
                    rmdir($newDir);
                  }
            }
          }
        }else{
          $this->db->where('les_id',$_REQUEST['les_id']);
          $this->db->update('LMS_LES',$data);

          $courses = $this->course->query_data_onupdate($course_id_lesson, 'LMS_COS','cos_id');
          $this->lg->record('course', 'Update Lesson : '.$les_name_th.' of course '.$courses['cname_th'].'('.$courses['ccode'].')'.' By '.$sess['fullname_th']);
          $les_id = $_REQUEST['les_id'];
          if($data['les_type']=="1"){

              $path = $this->course->check_scorm($_REQUEST['les_id']);
              if($path!=""){
                    $newDir = ROOT_DIR."uploads/scorm/".$path;
                    $this->course->delete_data($les_id,'lessons_id','LMS_SCM');

                    $newDir = ROOT_DIR."uploads/scorm/".$path;
                    function emptyDir($dir) {
                    if (is_dir($dir)) {
                        $scn = scandir($dir);
                        foreach ($scn as $files) {
                            if ($files !== '.') {
                                if ($files !== '..') {
                                    if (!is_dir($dir . '/' . $files)) {
                                        unlink($dir . '/' . $files);
                                    } else {
                                        emptyDir($dir . '/' . $files);
                                        rmdir($dir . '/' . $files);
                                    }
                                }
                            }
                        }
                    }
                }

                emptyDir($newDir);
                rmdir($newDir);
              }
            if($_REQUEST['type_media']=="1"){
              if($_REQUEST['url_media']!=""){
                $arrurl = explode(",", $_REQUEST['url_media']);
                $arr_checkmed = $this->course->check_media($les_id,'url');
                foreach ($arr_checkmed as $key) {
                  if(!in_array($key['video'], $arrurl)){
                    $this->course->delete_med($les_id,'url',$key['video']);
                  }
                }
                for($num_url=0;$num_url<count($arrurl);$num_url++){
                  $url = $this->getYoutubeEmbedUrl($arrurl[$num_url]);
                  $var_chkupload = $this->course->chk_uploadfileyoutube($les_id,$url);
                  if($var_chkupload==0){
                    $id_youtube = substr($url,24);
                    $arr_youtube =  explode("//www.youtube.com/embed/",$url);
                  $id_yt = isset($arr_youtube[1])?str_replace(array("\n", "\r"), '', $arr_youtube[1]):"";
                  //$input = 'https://img.youtube.com/vi/'.$id_youtube[1].'/hqdefault.jpg';

                            $dirimg = ROOT_DIR.'uploads/thumbnail/';            // directory in which the image will be saved
                            $localfile = 'thumbnail_'.date('dmYHis').$num_url.'.jpg';         // set image name the same as the file name of the source
                            // create the file with the image on the server
                           // echo $id_yt."<br>";
                      $varyoutube =  json_decode(getContentUrl('http://www.youtube.com/oembed?format=json&url=https://www.youtube.com/watch?v='.$id_yt), true);
                    if(isset($varyoutube['thumbnail_url'])&&$varyoutube['thumbnail_url']!=""){

                      $r = file_put_contents($dirimg.$localfile, getContentUrl($varyoutube['thumbnail_url']));
                            /*if(getContentUrl($input)!=""){
                              $r = file_put_contents($dirimg.$localfile, getContentUrl($input));*/
                              if(!$r){
                                  $localfile = "default_cover.jpg";
                              }
                            }else{
                              $localfile = "default_cover.jpg";
                            }
                  $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$id_yt);
                    $title = isset($ytarr['title'])?$ytarr['title']:"";
                    parse_str($content, $ytarr);
                    $each = array(
                      'lessons_id' => $les_id,
                      'med_name_th' => $title,
                      'med_name_eng' => $title,
                      'thumbnail_med' => $localfile,
                      'type' => 'url',
                      'video' => $url
                    );
                    $this->course->insert_data_media($each,$les_id,'url',$url);
                  }
                }
              }else{
                $this->db->where('lessons_id',$les_id);
                $this->db->delete('LMS_MED');
              }
            }else if($_REQUEST['type_media']=="2"){
              if(!empty($_FILES['media_file'])){
                  $thumbnail = "";
                  if(!empty($_FILES['thumbnail_med'])){
                      if($_FILES['thumbnail_med']['tmp_name']!=""){
                          $thumbnail = 'thumbnail_'.date('dmYHis').'.jpg';
                          if(!move_uploaded_file($_FILES['thumbnail_med']['tmp_name'],ROOT_DIR."uploads/thumbnail/".$thumbnail)){
                            $thumbnail = "";
                          }
                      }
                  }
                    if($_FILES['media_file']['tmp_name']!=""){
                        $newname = 'MediaLesson_'.date('dmYHis').'.mp4';
                        if(move_uploaded_file($_FILES['media_file']['tmp_name'],ROOT_DIR."uploads/media/".$newname)){
                          $each = array(
                            'lessons_id' => $les_id,
                            'med_name_th' => isset($_REQUEST['med_name_th'])?$_REQUEST['med_name_th']:"",
                            'med_name_eng' => isset($_REQUEST['med_name_eng'])?$_REQUEST['med_name_eng']:"",
                            'thumbnail_med' => $thumbnail,
                            'type' => 'upload',
                            'video' => $newname
                          );
                          $this->course->insert_data_media($each,$les_id,'upload',$newname);
                        }
                    }
              }
            }

            if(!empty($_FILES['path_file'])){
              $path_file = $this->reArrayFiles($_FILES['path_file']);
              $name_file_th = isset($_REQUEST['name_file_th']) ? $_REQUEST['name_file_th'] : '';
              $name_file_eng = isset($_REQUEST['name_file_eng']) ? $_REQUEST['name_file_eng'] : '';

              $path_file_ori = isset($_REQUEST['path_file_ori']) ? $_REQUEST['path_file_ori'] : '';
              $id_fil = isset($_REQUEST['id_fil']) ? $_REQUEST['id_fil'] : '';
              $path_file_ori = $path_file_ori;
              $id_fil = $id_fil;
              $num_doc = 1;$num_count = 0;
              if(count($path_file)>0){
                foreach($path_file as $val)
                {
                  if($val['name']!=""){
                      $path_parts = pathinfo($val['name']);
                      if(count($path_parts)>0){
                          $newname = 'DocumentLesson_'.date('dmYHis').$num_doc.".".$path_parts['extension'];
                          if(move_uploaded_file($val['tmp_name'],ROOT_DIR."uploads/document/".$newname)){
                              $each = array(
                            'lessons_id' => $les_id,
                            'path_file' => $newname,
                            'name_file_th' => isset($name_file_th[$num_count])?$name_file_th[$num_count]:"",
                            'name_file_eng' => isset($name_file_eng[$num_count])?$name_file_eng[$num_count]:"",
                          );
                          $this->course->insert_data_document($each);
                          }
                      }
                      $num_doc++;
                  }
                  $num_count++;
                }
              }
              if(isset($_REQUEST['id_filedit'])){
                $name_file_th = isset($_REQUEST['name_file_thedit']) ? $_REQUEST['name_file_thedit'] : '';
                $name_file_eng = isset($_REQUEST['name_file_engedit']) ? $_REQUEST['name_file_engedit'] : '';
                $path_file_ori = isset($_REQUEST['path_file_oriedit']) ? $_REQUEST['path_file_oriedit'] : '';
                $id_fil = isset($_REQUEST['id_filedit']) ? $_REQUEST['id_filedit'] : '';
                $path_file_ori = $path_file_ori;
                $id_fil = $id_fil;
                $num_doc = 1;$num_count = 0;
                if(count($id_fil)>0){
                  for($i=0;$i<count($id_fil);$i++)
                  {
                      if($id_fil[$i]!=""){
                        $each = array(
                              'id' => $id_fil[$i],
                              'lessons_id' => $les_id,
                              'path_file' => $path_file_ori[$i],
                              'name_file_th' => isset($name_file_th[$num_count])?$name_file_th[$num_count]:"",
                              'name_file_eng' => isset($name_file_eng[$num_count])?$name_file_eng[$num_count]:"",
                        );
                        $this->course->insert_data_document($each);
                      }
                        $num_doc++;$num_count++;
                  }
                }
              }
            }else{
                $name_file_th = isset($_REQUEST['name_file_thedit']) ? $_REQUEST['name_file_thedit'] : '';
                $name_file_eng = isset($_REQUEST['name_file_engedit']) ? $_REQUEST['name_file_engedit'] : '';
                $path_file_oriedit = isset($_REQUEST['path_file_oriedit']) ? $_REQUEST['path_file_oriedit'] : '';
                $id_filedit = isset($_REQUEST['id_filedit']) ? $_REQUEST['id_filedit'] : '';
                $path_file_ori = $path_file_oriedit;
                $id_fil = $id_filedit;
                $num_doc = 1;$num_count = 0;
                if(count($id_fil)>0){
                  for($i=0;$i<count($id_fil);$i++)
                  {
                      if(isset($id_fil[$i])&&$id_fil[$i]!=""){
                        $each = array(
                              'id' => $id_fil[$i],
                              'lessons_id' => $les_id,
                              'path_file' => $path_file_ori[$i],
                              'name_file_th' => isset($name_file_th[$num_count])?$name_file_th[$num_count]:"",
                              'name_file_eng' => isset($name_file_eng[$num_count])?$name_file_eng[$num_count]:"",
                        );
                        $this->course->insert_data_document($each);
                      }
                        $num_doc++;$num_count++;
                  }
                }
            }
          }else{
            if(!empty($_FILES['scorm_file'])){
              if($_FILES['scorm_file']['name']!=""){

                $scorm_file = $this->reArrayFiles($_FILES['scorm_file']);
                foreach ($scorm_file as $val) {
                  if($val['name']!=""){

                    $path = $this->course->check_scorm($les_id);
                    if($path!=""){
                          $newDir = ROOT_DIR."uploads/scorm/".$path;
                          function emptyDir($dir) {
                              if (is_dir($dir)) {
                                  $scn = scandir($dir);
                                  foreach ($scn as $files) {
                                      if ($files !== '.') {
                                          if ($files !== '..') {
                                              if (!is_dir($dir . '/' . $files)) {
                                                  unlink($dir . '/' . $files);
                                              } else {
                                                  emptyDir($dir . '/' . $files);
                                                  rmdir($dir . '/' . $files);
                                              }
                                          }
                                      }
                                  }
                              }
                          }
                          emptyDir($newDir);
                          rmdir($newDir);
                          $this->course->delete_data($les_id,'lessons_id','LMS_SCM');
                          $this->course->delete_document($les_id);
                          $this->course->delete_med_video($les_id,'upload');
                          $this->course->delete_med_video($les_id,'url');
                          //rmdir($newDir);
                    }

                    $scmCode = $this->course->create_scorm_id($les_id);
                    $path = "scorm_".$les_id."_".$scmCode;
                        $newDir = ROOT_DIR."uploads/scorm/".$path;
                        mkdir($newDir);
                        $scormFile = $_FILES['scorm_file'];
                        $sourcePath = $scormFile['tmp_name'];
                        $path_parts = pathinfo($scormFile['name']);
                        $targetPath = $newDir."/".$path.".".$path_parts['extension'];
                        if( move_uploaded_file( $sourcePath,$targetPath ) ){
                          $zip = new ZipArchive;
                            $openZip = $zip->open($targetPath);
                            $zip->extractTo($newDir);
                            $zip->close();
                            $this->course->update_scorm_id($scmCode,$path);
                        }else{
                          $this->course->delete_data($scmCode,'id','LMS_SCM');

                          function emptyDir($dir) {
                            if (is_dir($dir)) {
                                $scn = scandir($dir);
                                foreach ($scn as $files) {
                                    if ($files !== '.') {
                                        if ($files !== '..') {
                                            if (!is_dir($dir . '/' . $files)) {
                                                unlink($dir . '/' . $files);
                                            } else {
                                                emptyDir($dir . '/' . $files);
                                                rmdir($dir . '/' . $files);
                                            }
                                        }
                                    }
                                }
                            }
                          }

                          emptyDir($newDir);
                          rmdir($newDir);
                        }
                  }
                }
              }
            }
          }
        }
        $output['status'] = "2";
    }else{
        $output['status'] = "0";
    }
    echo json_encode($output);
  }

  public function insert_quiz(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $emp_c = $sess['emp_c'];
    $this->fetch->loadDB();
    $output = array();
    if(isset($_REQUEST)&&!empty($sess['emp_c'])){
        $cos_id = isset($_REQUEST['course_id_quiz'])?$_REQUEST['course_id_quiz']:"";
        $quiz_lang = isset($_REQUEST['quiz_lang'])?$_REQUEST['quiz_lang']:"";
        $quiz_name_th = isset($_REQUEST['quiz_name_th'])?$_REQUEST['quiz_name_th']:"";
        $quiz_info_th = isset($_REQUEST['quiz_info_th'])?$_REQUEST['quiz_info_th']:"";
        $quiz_name_eng = isset($_REQUEST['quiz_name_eng'])?$_REQUEST['quiz_name_eng']:"";
        $quiz_info_eng = isset($_REQUEST['quiz_info_eng'])?$_REQUEST['quiz_info_eng']:"";
        $time_start = isset($_REQUEST['time_start_quiz'])?$_REQUEST['time_start_quiz']:"00:00:00";
        $time_end = isset($_REQUEST['time_end_quiz'])?$_REQUEST['time_end_quiz']:"00:00:00";
        $period_open = isset($_REQUEST['period_open_var'])&&$_REQUEST['period_open_var']!=""?$_REQUEST['period_open_var']." ".$time_start:"";
        $period_end = isset($_REQUEST['period_end_var'])&&$_REQUEST['period_end_var']!=""?$_REQUEST['period_end_var']." ".$time_end:"";
        $quiz_answer = isset($_REQUEST['quiz_answer'])?$_REQUEST['quiz_answer']:"0";
        $quiz_limit = isset($_REQUEST['quiz_limit'])?$_REQUEST['quiz_limit']:"0";
        $quiz_limitval = isset($_REQUEST['quiz_limitval'])?$_REQUEST['quiz_limitval']:"";
        $qize_id = isset($_REQUEST['qize_id'])?$_REQUEST['qize_id']:"";
        $quiz_numofshown = isset($_REQUEST['quiz_numofshown'])?$_REQUEST['quiz_numofshown']:"";
        $totalquiz = isset($_REQUEST['totalquiz'])?$_REQUEST['totalquiz']:"";
        $quiz_settime = isset($_REQUEST['quiz_settime'])?$_REQUEST['quiz_settime']:"";
        $quiz_random = isset($_REQUEST['quiz_random'])?$_REQUEST['quiz_random']:"0";
        $quiz_random_choice = isset($_REQUEST['quiz_random_choice'])?$_REQUEST['quiz_random_choice']:"0";
        $quiz_show = isset($_REQUEST['quiz_show'])?$_REQUEST['quiz_show']:"0";
        $quiz_ishint = isset($_REQUEST['quiz_ishint'])?$_REQUEST['quiz_ishint']:"0";
        $quiz_model = isset($_REQUEST['quiz_model'])?$_REQUEST['quiz_model']:"0";
        $quiz_grade = isset($_REQUEST['quiz_grade'])?$_REQUEST['quiz_grade']:"0";
        $quiz_type = isset($_REQUEST['quiz_type'])?$_REQUEST['quiz_type']:"1";

        $data = array(
            'cos_id' => $cos_id,
            'quiz_lang' => $quiz_lang,
            'quiz_name_th' => $quiz_name_th,
            'quiz_info_th' => $quiz_info_th,
            'quiz_name_eng' => $quiz_name_eng,
            'quiz_info_eng' => $quiz_info_eng,
            'period_open' => $period_open,
            'period_end' => $period_end,
            'quiz_random' => $quiz_random,
            'quiz_random_choice' => $quiz_random_choice,
            'quiz_show' => $quiz_show,
            'quiz_grade' => $quiz_grade,
            'quiz_type' => $quiz_type,
            'quiz_answer' => $quiz_answer,
            'quiz_limit' => $quiz_limit,
            'quiz_limitval' => $quiz_limitval,
            'quiz_settime' => $quiz_settime,
            'quiz_ishint' => $quiz_ishint,
            'quiz_model' => $quiz_model,
            'quiz_numofshown' => $quiz_numofshown,
            'quiz_modifiedby' => $sess['u_id'],
            'quiz_modifieddate' => date('Y-m-d H:i')
        );
        $arr_update = array('cos_modifieddate'=>date('Y-m-d H:i:s'));
        $this->db->where('cos_id',$cos_id);
        $this->db->update('LMS_COS',$arr_update);
        if($_REQUEST['operation_quiz']=="Add"){
          $data['quiz_createby'] = $sess['u_id'];
          $data['quiz_createdate'] = date('Y-m-d H:i');

          $fetch_chk = $this->func_query->numrows('LMS_QIZ','','','','(quiz_name_th="'.$data['quiz_name_th'].'" and quiz_name_eng="'.$data['quiz_name_eng'].'") and cos_id="'.$data['cos_id'].'" and quiz_isDelete="0"');
            if($fetch_chk==0){
              $this->db->insert('LMS_QIZ', $data);
              $id = $this->db->insert_id();
              if($id!=""){

                if($_REQUEST['qize_id']!=""){
                  $qize_id = $_REQUEST['qize_id'];
                  $numques = 0;
                  $fetch_data = $this->func_query->query_result('LMS_QUESE','','','','qize_id="'.$qize_id.'"');
                  if(count($fetch_data)>0){
                    foreach ($fetch_data as $key_qn => $value_qn) {
                      $var_rechk_type = 1;
                      if($quiz_random_choice=="1"||$quiz_ishint=="1"||$quiz_model=="1"){
                        if($value_qn['quese_type']=="sa"||$value_qn['quese_type']=="sub"){
                          unset($fetch_data[$key_qn]);
                        }
                      }
                    }
                  }
                  if(count($fetch_data)>0){
                    foreach ($fetch_data as $key_qn => $value_qn) {
                      $data_qn = array(
                        'qiz_id' => $id,
                        'ques_type' => $value_qn['quese_type'],
                        'ques_score' => $value_qn['quese_score'],
                        'ques_name_th' => $value_qn['quese_name_th'],
                        'ques_info_th' => $value_qn['quese_info_th'],
                        'ques_name_eng' => $value_qn['quese_name_eng'],
                        'ques_info_eng' => $value_qn['quese_info_eng'],
                        'ques_createby' => $sess['u_id'],
                        'ques_createdate' => date('Y-m-d H:i'),
                        'ques_modifiedby' => $sess['u_id'],
                        'ques_modifieddate' => date('Y-m-d H:i')
                      );
                      $this->db->insert('LMS_QUES',$data_qn);
                      $ques_id = $this->db->insert_id();
                      if($value_qn['quese_type']=="multi"||$value_qn['quese_type']=="2choice"){
                        $fetch_muli = $this->func_query->query_row('LMS_QUESE_MUL','','','','quese_id="'.$value_qn['quese_id'].'"');
                         if(count($fetch_muli)>0){
                            $data_mul = array(
                              'ques_id'  => $ques_id,
                              'mul_c1_th'  => $fetch_muli['mule_c1_th'],
                              'mul_c2_th'  => $fetch_muli['mule_c2_th'],
                              'mul_c3_th'  => $fetch_muli['mule_c3_th'],
                              'mul_c4_th'  => $fetch_muli['mule_c4_th'],
                              'mul_c5_th'  => $fetch_muli['mule_c5_th'],
                              'mul_c1_eng'  => $fetch_muli['mule_c1_eng'],
                              'mul_c2_eng'  => $fetch_muli['mule_c2_eng'],
                              'mul_c3_eng'  => $fetch_muli['mule_c3_eng'],
                              'mul_c4_eng'  => $fetch_muli['mule_c4_eng'],
                              'mul_c5_eng'  => $fetch_muli['mule_c5_eng'],
                              'mul_answer'  => $fetch_muli['mule_answer'],
                              'mul_createby'  => $sess['u_id'],
                              'mul_createdate'  => date('Y-m-d H:i'),
                              'mul_modifiedby'  => $sess['u_id'],
                              'mul_modifieddate'  => date('Y-m-d H:i')
                            );
                            $this->db->insert('LMS_QUES_MUL',$data_mul);
                         }
                      }
                      $numques++;
                    }
                  }
                  $data = array(
                      'quiz_numofshown' => $numques
                  );
                  $this->db->where('qiz_id',$id);
                  $this->db->update('LMS_QIZ',$data);
                }
                $output['status'] = "2";
              }else{
                $output['status'] = "3";
              }
            }else{
              $output['status'] = "1";
            }
        }else{


                if($_REQUEST['qize_id']!=""){
                  $qize_id = $_REQUEST['qize_id'];
                  $numques = 0;
                  $fetch_data = $this->func_query->query_result('LMS_QUESE','','','','qize_id="'.$qize_id.'"');
                  foreach ($fetch_data as $key_qn => $value_qn) {
                    $data_qn = array(
                      'qiz_id' => $_REQUEST['qiz_id'],
                      'ques_type' => $value_qn['quese_type'],
                      'ques_score' => $value_qn['quese_score'],
                      'ques_name_th' => $value_qn['quese_name_th'],
                      'ques_info_th' => $value_qn['quese_info_th'],
                      'ques_name_eng' => $value_qn['quese_name_eng'],
                      'ques_info_eng' => $value_qn['quese_info_eng'],
                      'ques_createby' => $sess['u_id'],
                      'ques_createdate' => date('Y-m-d H:i'),
                      'ques_modifiedby' => $sess['u_id'],
                      'ques_modifieddate' => date('Y-m-d H:i')
                    );
                    $fetch_data_detail = $this->func_query->numrows('LMS_QUES','','','','qiz_id="'.$_REQUEST['qiz_id'].'" and ques_isDelete="0" and (ques_name_th="'.$data_qn['ques_name_th'].'" and ques_name_eng="'.$data_qn['ques_name_eng'].'")');
                    if($fetch_data_detail==0){
                        $this->db->insert('LMS_QUES',$data_qn);
                        $ques_id = $this->db->insert_id();
                        if($value_qn['quese_type']=="multi"||$value_qn['quese_type']=="2choice"){
                          $fetch_muli = $this->func_query->query_row('LMS_QUESE_MUL','','','','quese_id="'.$value_qn['quese_id'].'"');
                           if(count($fetch_muli)>0){
                              $data_mul = array(
                                'ques_id'  => $ques_id,
                                'mul_c1_th'  => $fetch_muli['mule_c1_th'],
                                'mul_c2_th'  => $fetch_muli['mule_c2_th'],
                                'mul_c3_th'  => $fetch_muli['mule_c3_th'],
                                'mul_c4_th'  => $fetch_muli['mule_c4_th'],
                                'mul_c5_th'  => $fetch_muli['mule_c5_th'],
                                'mul_c1_eng'  => $fetch_muli['mule_c1_eng'],
                                'mul_c2_eng'  => $fetch_muli['mule_c2_eng'],
                                'mul_c3_eng'  => $fetch_muli['mule_c3_eng'],
                                'mul_c4_eng'  => $fetch_muli['mule_c4_eng'],
                                'mul_c5_eng'  => $fetch_muli['mule_c5_eng'],
                                'mul_answer'  => $fetch_muli['mule_answer'],
                                'mul_createby'  => $sess['u_id'],
                                'mul_createdate'  => date('Y-m-d H:i'),
                                'mul_modifiedby'  => $sess['u_id'],
                                'mul_modifieddate'  => date('Y-m-d H:i')
                              );
                              $this->db->insert('LMS_QUES_MUL',$data_mul);
                           }
                        }
                        $numques++;
                    }else{
                      $this->db->where('ques_id',$fetch_data_detail['ques_id']);
                      $this->db->update('LMS_QUES',$data_qn);
                        if($value_qn['quese_type']=="multi"||$value_qn['quese_type']=="2choice"){
                          $fetch_muli = $this->func_query->query_row('LMS_QUESE_MUL','','','','quese_id="'.$value_qn['quese_id'].'"');
                          if(count($fetch_muli)>0){
                              $fetch_muli_chk = $this->func_query->query_row('LMS_QUES_MUL','','','','ques_id="'.$fetch_data_detail['ques_id'].'"');
                                  $data_mul = array(
                                    'ques_id'  => $fetch_data_detail['ques_id'],
                                    'mul_c1_th'  => $fetch_muli['mule_c1_th'],
                                    'mul_c2_th'  => $fetch_muli['mule_c2_th'],
                                    'mul_c3_th'  => $fetch_muli['mule_c3_th'],
                                    'mul_c4_th'  => $fetch_muli['mule_c4_th'],
                                    'mul_c5_th'  => $fetch_muli['mule_c5_th'],
                                    'mul_c1_eng'  => $fetch_muli['mule_c1_eng'],
                                    'mul_c2_eng'  => $fetch_muli['mule_c2_eng'],
                                    'mul_c3_eng'  => $fetch_muli['mule_c3_eng'],
                                    'mul_c4_eng'  => $fetch_muli['mule_c4_eng'],
                                    'mul_c5_eng'  => $fetch_muli['mule_c5_eng'],
                                    'mul_answer'  => $fetch_muli['mule_answer'],
                                    'mul_createby'  => $sess['u_id'],
                                    'mul_createdate'  => date('Y-m-d H:i'),
                                    'mul_modifiedby'  => $sess['u_id'],
                                    'mul_modifieddate'  => date('Y-m-d H:i')
                                  );

                               if(count($fetch_muli_chk==0)){
                                  $this->db->insert('LMS_QUES_MUL',$data_mul);
                               }else{
                                  $this->db->where('ques_id',$fetch_data_detail['ques_id']);
                                  $this->db->update('LMS_QUES_MUL',$data_mul);
                               }
                          }
                        }
                        $numques++;
                    }
                  }
                  $data = array(
                      'quiz_numofshown' => $numques
                  );
                  $this->db->where('qiz_id',$_REQUEST['qiz_id']);
                  $this->db->update('LMS_QIZ',$data);
                }
          $this->db->where('qiz_id',$_REQUEST['qiz_id']);
          $this->db->update('LMS_QIZ',$data);
          $output['status'] = "2";
        }
    }else{
        $output['status'] = "0";
    }
    echo json_encode($output);
  }

  public function insert_question(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $emp_c = $sess['emp_c'];
    $this->fetch->loadDB();
    $output = array();
    if(isset($_REQUEST)&&!empty($sess['emp_c'])){
        $qiz_id = isset($_REQUEST['qiz_id_question'])?$_REQUEST['qiz_id_question']:"";
        $cos_id = isset($_REQUEST['cos_id_question'])?$_REQUEST['cos_id_question']:"";
        $ques_id = isset($_REQUEST['ques_id'])?$_REQUEST['ques_id']:"";
        $ques_name_th = isset($_REQUEST['ques_name_th'])?$_REQUEST['ques_name_th']:"";
        $ques_name_eng = isset($_REQUEST['ques_name_eng'])?$_REQUEST['ques_name_eng']:"";
        $ques_info_th = isset($_REQUEST['ques_info_th'])?$_REQUEST['ques_info_th']:"";
        $ques_info_eng = isset($_REQUEST['ques_info_eng'])?$_REQUEST['ques_info_eng']:"";
        $ques_type = isset($_REQUEST['ques_type'])?$_REQUEST['ques_type']:"";
        $ques_score = isset($_REQUEST['ques_score'])?$_REQUEST['ques_score']:"";
        $mul_answer = isset($_REQUEST['mul_answer'])?$_REQUEST['mul_answer']:"";
        $mul_c1_th = isset($_REQUEST['mul_c1_th'])?$_REQUEST['mul_c1_th']:"";
        $mul_c2_th = isset($_REQUEST['mul_c2_th'])?$_REQUEST['mul_c2_th']:"";
        $mul_c3_th = isset($_REQUEST['mul_c3_th'])?$_REQUEST['mul_c3_th']:"";
        $mul_c4_th = isset($_REQUEST['mul_c4_th'])?$_REQUEST['mul_c4_th']:"";
        $mul_c5_th = isset($_REQUEST['mul_c5_th'])?$_REQUEST['mul_c5_th']:"";
        $mul_c1_eng = isset($_REQUEST['mul_c1_eng'])?$_REQUEST['mul_c1_eng']:"";
        $mul_c2_eng = isset($_REQUEST['mul_c2_eng'])?$_REQUEST['mul_c2_eng']:"";
        $mul_c3_eng = isset($_REQUEST['mul_c3_eng'])?$_REQUEST['mul_c3_eng']:"";
        $mul_c4_eng = isset($_REQUEST['mul_c4_eng'])?$_REQUEST['mul_c4_eng']:"";
        $mul_c5_eng = isset($_REQUEST['mul_c5_eng'])?$_REQUEST['mul_c5_eng']:"";

        $ques_hintname_th = isset($_REQUEST['ques_hintname_th'])?$_REQUEST['ques_hintname_th']:"";
        $ques_hintdetail_th = isset($_REQUEST['ques_hintdetail_th'])?$_REQUEST['ques_hintdetail_th']:"";
        $ques_hintname_eng = isset($_REQUEST['ques_hintname_eng'])?$_REQUEST['ques_hintname_eng']:"";
        $ques_hintdetail_eng = isset($_REQUEST['ques_hintdetail_eng'])?$_REQUEST['ques_hintdetail_eng']:"";
        $ques_show = isset($_REQUEST['ques_show'])?$_REQUEST['ques_show']:"0";
        $fetch_qiz = $this->func_query->query_row('LMS_QIZ','','','','qiz_id="'.$qiz_id.'"');
        $arr_update = array('cos_modifieddate'=>date('Y-m-d H:i:s'));
        $this->db->where('cos_id',$fetch_qiz['cos_id']);
        $this->db->update('LMS_COS',$arr_update);
        $data = array(
          'qiz_id' => $qiz_id,
          'ques_type' => $ques_type,
          'ques_name_th' => $ques_name_th,
          'ques_name_eng' => $ques_name_eng,
          'ques_info_th' => $ques_info_th,
          'ques_info_eng' => $ques_info_eng,
          'ques_hintname_th' => $ques_hintname_th,
          'ques_hintdetail_th' => $ques_hintdetail_th,
          'ques_hintname_eng' => $ques_hintname_eng,
          'ques_hintdetail_eng' => $ques_hintdetail_eng,
          'ques_score' => $ques_score,
          'ques_status' => $ques_show,
          'ques_modifiedby' => $sess['u_id'],
          'ques_modifieddate' => date('Y-m-d H:i')
        );

          if(isset($_FILES['ques_hintimg'])&&$_FILES['ques_hintimg']!=""){
            if( isset( $_FILES['ques_hintimg']) ){
                $imageSourcePath = $_FILES['ques_hintimg']['tmp_name'];
                $pathBG = $_FILES['ques_hintimg']['name'];
                if($pathBG!=""){
                    $array_pathext = explode('.', $pathBG);
                    $extension = end($array_pathext);
                    $ques_hintimg = "Hint_".date('YmdHis').".".$extension;
                    $imageTargetPath = ROOT_DIR."uploads/hint/".$ques_hintimg;
                    if($_REQUEST['operation_question']=="Edit"){
                        $fetch_img = $this->func_query->query_row('LMS_QUES','','','','ques_id="'.$_REQUEST['ques_id'].'"');
                        if(count($fetch_img)>0&&$fetch_img['ques_hintimg']!=""){
                          if(is_file(ROOT_DIR."uploads/hint/".$fetch_img['ques_hintimg'])) {
                                unlink(ROOT_DIR."uploads/hint/".$fetch_img['ques_hintimg']);
                          }
                        }
                    }
                    if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
                        $data['ques_hintimg'] = $ques_hintimg;
                    }
                }
            }
          }
        if($_REQUEST['operation_question']=="Add"){
          $data['ques_createby'] = $sess['u_id'];
          $data['ques_createdate'] = date('Y-m-d H:i');

                    $where_ques = "";
                    if($data['ques_name_th']!=""){
                      $where_ques .= "ques_name_th = '".htmlentities($data['ques_name_th'])."'";
                    }
                    if($data['ques_name_eng']!=""){
                       if($where_ques!=""){
                        $where_ques .= ' and ';
                       }
                      $where_ques .= "ques_name_eng = '".htmlentities($data['ques_name_eng'])."'";
                    }
          $where = 'qiz_id="'.$data['qiz_id'].'" and ques_type="'.$data['ques_type'].'" and ('.$where_ques.') and ques_isDelete="0"';
          $fetch_chk = $this->func_query->numrows('LMS_QUES','','','',$where);
            if($fetch_chk==0){
              $this->db->insert('LMS_QUES', $data);
              $id = $this->db->insert_id();
              if($id!=""){
                $fetch_qiz = $this->func_query->query_row('LMS_QIZ','','','','qiz_id="'.$qiz_id.'"');
                if(count($fetch_qiz)>0&&$ques_show=="1"){
                  $quiz_numofshown = intval($fetch_qiz['quiz_numofshown'])+1;
                  $dataupdate = array(
                      'quiz_numofshown' => $quiz_numofshown,
                      'quiz_modifiedby' => $sess['u_id'],
                      'quiz_modifieddate' => date('Y-m-d H:i')
                  );
                  $this->db->where('qiz_id',$qiz_id);
                  $this->db->update('LMS_QIZ',$dataupdate);
                }
                if($ques_type=="multi"||$ques_type=="2choice"){
                  $mul_answer = $mul_answer!=""?implode(',', $mul_answer):"";
                  $data_mul = array(
                    'ques_id'  => $id,
                    'mul_c1_th'  => $mul_c1_th,
                    'mul_c2_th'  => $mul_c2_th,
                    'mul_c3_th'  => $mul_c3_th,
                    'mul_c4_th'  => $mul_c4_th,
                    'mul_c5_th'  => $mul_c5_th,
                    'mul_c1_eng'  => $mul_c1_eng,
                    'mul_c2_eng'  => $mul_c2_eng,
                    'mul_c3_eng'  => $mul_c3_eng,
                    'mul_c4_eng'  => $mul_c4_eng,
                    'mul_c5_eng'  => $mul_c5_eng,
                    'mul_answer'  => $mul_answer,
                    'mul_createby'  => $sess['u_id'],
                    'mul_createdate'  => date('Y-m-d H:i'),
                    'mul_modifiedby'  => $sess['u_id'],
                    'mul_modifieddate'  => date('Y-m-d H:i')
                  );
                  $this->db->insert('LMS_QUES_MUL',$data_mul);
                }
                $output['status'] = "2";
              }else{
                $output['status'] = "3";
              }
            }else{
              $output['status'] = "1";
            }
        }else{
          $this->db->where('ques_id',$_REQUEST['ques_id']);
          $this->db->update('LMS_QUES',$data);

          if($ques_type=="multi"||$ques_type=="2choice"){
              $fetch_mul = $this->func_query->query_row('LMS_QUES_MUL','','','','ques_id="'.$_REQUEST['ques_id'].'"');
              $mul_answer = $mul_answer!=""?implode(',', $mul_answer):"";
              $data_mul = array(
                    'ques_id'  => $_REQUEST['ques_id'],
                    'mul_c1_th'  => $mul_c1_th,
                    'mul_c2_th'  => $mul_c2_th,
                    'mul_c3_th'  => $mul_c3_th,
                    'mul_c4_th'  => $mul_c4_th,
                    'mul_c5_th'  => $mul_c5_th,
                    'mul_c1_eng'  => $mul_c1_eng,
                    'mul_c2_eng'  => $mul_c2_eng,
                    'mul_c3_eng'  => $mul_c3_eng,
                    'mul_c4_eng'  => $mul_c4_eng,
                    'mul_c5_eng'  => $mul_c5_eng,
                    'mul_answer'  => $mul_answer,
                    'mul_modifiedby'  => $sess['u_id'],
                    'mul_modifieddate'  => date('Y-m-d H:i')
              );
              if(count($fetch_mul)>0){
                  $this->db->where('ques_id',$_REQUEST['ques_id']);
                  $this->db->update('LMS_QUES_MUL',$data_mul);
              }else{
                  $data_mul['mul_createby'] = $sess['u_id'];
                  $data_mul['mul_createdate'] = date('Y-m-d H:i');
                  $this->db->insert('LMS_QUES_MUL',$data_mul);
              }
          }else{
              $this->db->where('ques_id',$_REQUEST['ques_id']);
              $this->db->delete('LMS_QUES_MUL');
          }
          $output['status'] = "2";
        }
    }else{
        $output['status'] = "0";
    }
    echo json_encode($output);
  }

  public function insert_videocourse(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Fetchdata_model', 'fetch', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata("user");
    $emp_c = $sess['emp_c'];
    $this->fetch->loadDB();
    $output = array();
    if(isset($_REQUEST)&&!empty($sess['emp_c'])){
        $cosv_lang = isset($_REQUEST['cosv_lang'])?implode(',', $_REQUEST['cosv_lang']):"";
        $cosv_type = isset($_REQUEST['type_media_cosv'])?$_REQUEST['type_media_cosv']:"";
        $url_media = isset($_REQUEST['url_media_cosv'])?$_REQUEST['url_media_cosv']:"";
        $cosv_th = isset($_REQUEST['cosv_th'])?$_REQUEST['cosv_th']:"";
        $cosv_eng = isset($_REQUEST['cosv_eng'])?$_REQUEST['cosv_eng']:"";
        $cosv_id = isset($_REQUEST['cosv_id'])?$_REQUEST['cosv_id']:"";
        $operation = isset($_REQUEST['operation_cosv'])?$_REQUEST['operation_cosv']:"";


        function getContentUrl($url) {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/21.0 (compatible; MSIE 8.01; Windows NT 5.0)');
            curl_setopt($ch, CURLOPT_TIMEOUT, 200);
            curl_setopt($ch, CURLOPT_AUTOREFERER, false);
            curl_setopt($ch, CURLOPT_REFERER, 'http://google.com');
            curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);    // Follows redirect responses
            // gets the file content, trigger error if false
            $file = curl_exec($ch);
            if($file === false) trigger_error(curl_error($ch));
            curl_close ($ch);
            return $file;
        }
        $data = array(
          'cos_id' => $_REQUEST['course_id_cosv'],
          'cosv_type' => $cosv_type,
          'cosv_lang' => $cosv_lang,
          'cosv_modifiedby' => $sess['u_id'],
          'cosv_modifieddate' => date('Y-m-d H:i')
        );
        if($cosv_type=="1"){
            if($url_media!=""){
              $arrurl = explode(",", $url_media);
                for($num_url=0;$num_url<count($arrurl);$num_url++){
                  $url = $this->getYoutubeEmbedUrl($arrurl[$num_url]);
                  $fetch_numchk = $this->func_query->numrows('LMS_COS_VIDEO','','','','cos_id="'.$_REQUEST['course_id_cosv'].'" and cosv_type="'.$cosv_type.'" and cosv_video="'.$url.'" and cosv_isDelete="0"');
                  if($fetch_numchk==0){
                    $id_youtube = substr($url,24);
                    $input = 'https://img.youtube.com/vi/'.$id_youtube.'/hqdefault.jpg';

                    $dirimg = ROOT_DIR.'uploads/thumbnail/';            // directory in which the image will be saved
                    $localfile = 'thumbnailCos_'.date('dmYHis').'.jpg';         // set image name the same as the file name of the source
                    // create the file with the image on the server
        $varyoutube =  json_decode(getContentUrl('http://www.youtube.com/oembed?format=json&url=https://www.youtube.com/watch?v='.$id_youtube), true);
                    if(isset($varyoutube['thumbnail_url'])&&$varyoutube['thumbnail_url']!=""){

                      $r = file_put_contents($dirimg.$localfile, getContentUrl($varyoutube['thumbnail_url']));
                      if(!$r){
                          $localfile = "default_cover.jpg";
                      }
                    }else{
                      $localfile = "default_cover.jpg";
                    }
                    $content = file_get_contents("http://youtube.com/get_video_info?video_id=".$id_youtube);
                    $title = isset($ytarr['title'])?$ytarr['title']:"";
                    parse_str($content, $ytarr);

                    $data['cosv_th'] = $title;
                    $data['cosv_eng'] = $title;
                    $data['cosv_thumbnail'] = $localfile;
                    $data['cosv_video'] = $url;
                  }
                }
            }
        }else{
            $data['cosv_th'] = $cosv_th;
            $data['cosv_eng'] = $cosv_eng;
            
            if(isset($_FILES['cosv_thumbnail'])&&$_FILES['cosv_thumbnail']!=""){
              if( isset( $_FILES['cosv_thumbnail']) ){
                $imageSourcePath = $_FILES['cosv_thumbnail']['tmp_name'];
                $path_parts = pathinfo($_FILES['cosv_thumbnail']['name']);
                if(isset($path_parts['extension'])){
                  $cosv_thumbnail = "cosv_thumbnail_".date('YmdHis').".".$path_parts['extension'];

                  $imageTargetPath = ROOT_DIR."uploads/thumbnail/".$cosv_thumbnail;
                  if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
                    $data['cosv_thumbnail'] = $cosv_thumbnail;
                    if($operation=="Edit"){
                      $fetch_chk = $this->func_query->query_row('LMS_COS_VIDEO','','','','cosv_id="'.$cosv_id.'"');
                      if($fetch_chk['cosv_thumbnail']!=""){
                          if(is_file(ROOT_DIR."uploads/thumbnail/".$fetch_chk['cosv_thumbnail'])) {
                                unlink(ROOT_DIR."uploads/thumbnail/".$fetch_chk['cosv_thumbnail']);
                          }
                      }

                    }
                  }
                }
              }
            }
            
            if(isset($_FILES['cosv_video'])&&$_FILES['cosv_video']!=""){
              if( isset( $_FILES['cosv_video']) ){
                $imageSourcePath = $_FILES['cosv_video']['tmp_name'];
                $path_parts = pathinfo($_FILES['cosv_video']['name']);
                if(isset($path_parts['extension'])){
                  $cosv_video = "cosv_video_".date('YmdHis').".".$path_parts['extension'];

                  $imageTargetPath = ROOT_DIR."uploads/cosvideo/".$cosv_video;
                  if( move_uploaded_file( $imageSourcePath,$imageTargetPath ) ){
                    $data['cosv_video'] = $cosv_video;
                    if($operation=="Edit"){
                      $fetch_chk = $this->func_query->query_row('LMS_COS_VIDEO','','','','cosv_id="'.$cosv_id.'"');
                      if($fetch_chk['cosv_video']!=""){
                          if(is_file(ROOT_DIR."uploads/cosvideo/".$fetch_chk['cosv_video'])) {
                                unlink(ROOT_DIR."uploads/cosvideo/".$fetch_chk['cosv_video']);
                          }
                      }

                    }
                  }
                }
              }
            }

        }
        if($_REQUEST['operation_cosv']=="Add"){
          $data['cosv_createby'] = $sess['u_id'];
          $data['cosv_createdate'] = date('Y-m-d H:i');

        if($cosv_type=="1"){
          $fetch_chk = $this->func_query->numrows('LMS_COS_VIDEO','','','',' cosv_video="'.$data['cosv_video'].'" and cosv_lang="'.$cosv_lang.'" and cos_id="'.$data['cos_id'].'" and cosv_isDelete="0"');
        }else{
          $fetch_chk = $this->func_query->numrows('LMS_COS_VIDEO','','','',' cosv_th="'.$data['cosv_th'].'" and cos_id="'.$data['cos_id'].'" and cosv_isDelete="0"');
        }
            if($fetch_chk==0){
              $this->db->insert('LMS_COS_VIDEO', $data);
              $id = $this->db->insert_id();
              if($id!=""){
                $output['status'] = "2";
              }else{
                $output['status'] = "3";
              }
            }else{
              $output['status'] = "1";
            }
        }else{
          $this->db->where('cosv_id',$cosv_id);
          $this->db->update('LMS_COS_VIDEO', $data);
          $output['status'] = "2";
        }
    }else{
        $output['status'] = "0";
    }
    echo json_encode($output);
  }

  public function insert_emptocourse(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    $user = $this->session->userdata('user');
    $this->load->model('Course_model', 'course', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
      $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    $this->course->loadDB();
    $msg = "";
    $useri = $this->input->post('useri');
    $cos_id = $this->input->post('cos_id');
      $data = array(
        'useri' => $useri,
        'cos_id' => $cos_id
      );
      $msg = $this->course->create_emptocourse($data);

        $arr_update = array('cos_modifieddate'=>date('Y-m-d H:i:s'));
        $this->db->where('cos_id',$cos_id);
        $this->db->update('LMS_COS',$arr_update);
      $fetch_cos = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');
      if($fetch_cos['cos_public']=="1"&&$msg=="2"){
                $fetch_setmail = $this->func_query->query_row('LMS_SETTING_MAIL','','','','sm_id="1"');
                $date = date('d ').$thaimonth[intval(date('m'))]." ".(date('Y')+543);
                if($lang!="thai"){
                  $date = date('d F Y');
                }
                if($lang=="thai"){ 
                    $cname = $fetch_cos['cname_th']!=""?$fetch_cos['cname_th']:$fetch_cos['cname_eng'];
                }else if($lang=="english"){ 
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
                  $periodstart = $fetch_cos_detail['date_start']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($fetch_cos_detail['date_start'])):"";
                  $periodend = $fetch_cos_detail['date_end']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($fetch_cos_detail['date_end'])):"";
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
                $fetch_user = $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.useri="'.$data['useri'].'"');
                $fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="10"');
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
                      $subject_th = str_replace("#link_frontend",base_url()."coursemain/detail/".$cos_id,$subject_th);
                      $subject_th = str_replace("#date",$date,$subject_th);
                      $subject_th = str_replace("#time",date('H:i'),$subject_th);
                      $subject_th = str_replace("#perioddate",$period,$subject_th);
                    }
                    if($subject_en!=""){
                      $subject_en = str_replace("#fullname",$fetch_user['fullname_en'],$subject_en);
                      $subject_en = str_replace("#username",$fetch_user['useri'],$subject_en);
                      $subject_en = str_replace("#email",$fetch_user['email'],$subject_en);
                      $subject_en = str_replace("#coursename",$cname,$subject_en);
                      $subject_en = str_replace("#link_frontend",base_url()."coursemain/detail/".$cos_id,$subject_en);
                      $subject_en = str_replace("#date",$date,$subject_en);
                      $subject_en = str_replace("#time",date('H:i'),$subject_en);
                      $subject_en = str_replace("#perioddate",$period,$subject_en);
                    }
                    if($message_th!=""){
                      $message_th = str_replace("#fullname",$fetch_user['fullname_th'],$message_th);
                      $message_th = str_replace("#username",$fetch_user['useri'],$message_th);
                      $message_th = str_replace("#email",$fetch_user['email'],$message_th);
                      $message_th = str_replace("#coursename",$cname,$message_th);
                      $message_th = str_replace("#link_frontend",base_url()."coursemain/detail/".$cos_id,$message_th);
                      $message_th = str_replace("#date",$date,$message_th);
                      $message_th = str_replace("#time",date('H:i'),$message_th);
                      $message_th = str_replace("#perioddate",$period,$message_th);
                    }
                    if($message_en!=""){
                      $message_en = str_replace("#fullname",$fetch_user['fullname_en'],$message_en);
                      $message_en = str_replace("#username",$fetch_user['useri'],$message_en);
                      $message_en = str_replace("#email",$fetch_user['email'],$message_en);
                      $message_en = str_replace("#coursename",$cname,$message_en);
                      $message_en = str_replace("#link_frontend",base_url()."coursemain/detail/".$cos_id,$message_en);
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
      }
    echo $msg;
  }

  public function upload_student(){
      require_once(APPPATH.'libraries/FPDF/Classes/PHPExcel.php');
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    $user = $this->session->userdata('user');
    $this->load->model('Course_model', 'course', TRUE);
    $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
    $this->course->loadDB();
    $arr_output = array();
    $result_str = "";
    if(count($_REQUEST)>0){
      if($_REQUEST['operation_student']=="Add"){
        $cos_id = $_REQUEST['course_id_student'];

        $importstudent = $_FILES["importstudent"]["name"];

        $excel_file = $_FILES['importstudent']['tmp_name'];
        $path_parts = pathinfo($importstudent);
        if(isset($path_parts['extension'])){
            $excel_path = "importques_".date('YmdHis').".".$path_parts['extension'];

            $excelTargetPath = ROOT_DIR."uploads/excel/".$excel_path;
            if( move_uploaded_file( $excel_file,$excelTargetPath ) ){
              $path = './uploads/excel/'.$excel_path;
              $objPHPExcel = PHPExcel_IOFactory::load($path);
              $result_arr = array();
              $result_arr['success_count'] = 0;
              $result_arr['duplicate_count'] = 0;
              $result_arr['error_count'] = 0;
              $result_arr['success_data'] = array();
              $result_arr['duplicate_data'] = array();
              $result_arr['error_data'] = array();
              foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $worksheetTitle     = $worksheet->getTitle();
                $highestRow         = $worksheet->getHighestRow(); // e.g. 10
                $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
                $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
                $nrColumns = ord($highestColumn) - 64;
                $output = array();
                $heading = "";
                $detail = "";
                $output_array = array();
                for ($row =2; $row <= $highestRow; ++ $row) {
                  for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                          $cell = $worksheet->getCellByColumnAndRow($col, $row);
                            $val = $cell->getValue();
                            $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
                    if($col==0){
                      if($val!=""){
                        if(!in_array($val, $output_array)){
                          array_push($output_array, $val);
                        } 
                      }
                    }
                  }
                }
                if(count($output_array)>0){
                  for ($i=0; $i < count($output_array); $i++) { 
                    if($output_array[$i]!=""&&$output_array[$i]!="Employee ID"){
                      $data = array(
                        'useri' => $output_array[$i],
                        'cos_id' => $cos_id
                      );
                      $msg = $this->course->create_emptocourse($data);
                       $fetch_cos = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');
                        if($fetch_cos['cos_public']=="1"&&$msg=="2"){
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
                                    $periodstart = $fetch_cos_detail['date_start']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($fetch_cos_detail['date_start'])):"";
                                    $periodend = $fetch_cos_detail['date_end']!="0000-00-00 00:00:00"?date('d F Y H:i',strtotime($fetch_cos_detail['date_end'])):"";
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
                                  $fetch_user = $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_USP.emp_id = LMS_EMP.emp_id','','LMS_USP.useri="'.$data['useri'].'"');
                                  $fetch_formatmail = $this->func_query->query_row('LMS_SENDMAIL_FORM','','','','smf_show="1" and smf_type="10"');
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
                                        $subject_th = str_replace("#link_frontend",base_url()."coursemain/detail/".$cos_id,$subject_th);
                                        $subject_th = str_replace("#date",$date,$subject_th);
                                        $subject_th = str_replace("#time",date('H:i'),$subject_th);
                                        $subject_th = str_replace("#perioddate",$period,$subject_th);
                                      }
                                      if($subject_en!=""){
                                        $subject_en = str_replace("#fullname",$fetch_user['fullname_en'],$subject_en);
                                        $subject_en = str_replace("#username",$fetch_user['useri'],$subject_en);
                                        $subject_en = str_replace("#email",$fetch_user['email'],$subject_en);
                                        $subject_en = str_replace("#coursename",$cname,$subject_en);
                                        $subject_en = str_replace("#link_frontend",base_url()."coursemain/detail/".$cos_id,$subject_en);
                                        $subject_en = str_replace("#date",$date,$subject_en);
                                        $subject_en = str_replace("#time",date('H:i'),$subject_en);
                                        $subject_en = str_replace("#perioddate",$period,$subject_en);
                                      }
                                      if($message_th!=""){
                                        $message_th = str_replace("#fullname",$fetch_user['fullname_th'],$message_th);
                                        $message_th = str_replace("#username",$fetch_user['useri'],$message_th);
                                        $message_th = str_replace("#email",$fetch_user['email'],$message_th);
                                        $message_th = str_replace("#coursename",$cname,$message_th);
                                        $message_th = str_replace("#link_frontend",base_url()."coursemain/detail/".$cos_id,$message_th);
                                        $message_th = str_replace("#date",$date,$message_th);
                                        $message_th = str_replace("#time",date('H:i'),$message_th);
                                        $message_th = str_replace("#perioddate",$period,$message_th);
                                      }
                                      if($message_en!=""){
                                        $message_en = str_replace("#fullname",$fetch_user['fullname_en'],$message_en);
                                        $message_en = str_replace("#username",$fetch_user['useri'],$message_en);
                                        $message_en = str_replace("#email",$fetch_user['email'],$message_en);
                                        $message_en = str_replace("#coursename",$cname,$message_en);
                                        $message_en = str_replace("#link_frontend",base_url()."coursemain/detail/".$cos_id,$message_en);
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
                        }
                      if($msg=="1"){
                        $result_arr['duplicate_count']++;
                        array_push($result_arr['duplicate_data'], $output_array[$i]);
                      }else if($msg=="2"){
                        $result_arr['success_count']++;
                        array_push($result_arr['success_data'], $output_array[$i]);
                      }else{
                        $result_arr['error_count']++;
                        array_push($result_arr['error_data'], $output_array[$i]);
                      }
                    }
                  }
                }
                $result_str = "";
                $result_str .= label('result_success')." : ".$result_arr['success_count']."<br>";
                if(count($result_arr['success_data'])>0){
                  $result_str .= "<ol>";
                  for ($i=0; $i < count($result_arr['success_data']); $i++) { 
                    if($result_arr['success_data'][$i]!=""){
                      $result_str .= "<li>".$result_arr['success_data'][$i]."</li>";
                    }
                  }
                  $result_str .= "</ol><hr><br>";
                }
                $result_str .= label('result_duplicate')." : ".$result_arr['duplicate_count']."<br>";
                if(count($result_arr['duplicate_data'])>0){
                  $result_str .= "<ol>";
                  for ($i=0; $i < count($result_arr['duplicate_data']); $i++) { 
                    if($result_arr['duplicate_data'][$i]!=""){
                      $result_str .= "<li>".$result_arr['duplicate_data'][$i]."</li>";
                    }
                  }
                  $result_str .= "</ol><hr><br>";
                }
                $result_str .= label('result_fail')." : ".$result_arr['error_count']."<br>";
                if(count($result_arr['error_data'])>0){
                  $result_str .= "<ol>";
                  for ($i=0; $i < count($result_arr['error_data']); $i++) { 
                    if($result_arr['error_data'][$i]!=""){
                      $result_str .= "<li>".$result_arr['error_data'][$i]."</li>";
                    }
                  }
                  $result_str .= "</ol><br>";
                }
              }
              $arr_output['status'] = "2";
              $arr_output['result'] = $result_str;
            }else{
              $arr_output['status'] = "0";
            } 
        }else{
            $arr_output['status'] = "0";
        }
      }else{
        $arr_output['status'] = "0";
      }
    }else{
      $arr_output['status'] = "0";
    }
    echo json_encode($arr_output);
  }

  public function insert_survey(){
    date_default_timezone_set("Asia/Bangkok");
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    $sess = $this->session->userdata('user');
    $this->load->model('Course_model', 'course', FALSE);
    $this->load->model('Log_model', 'lg', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->course->loadDB();
    $this->lg->loadDB();
    $output = array();
    if(count($_REQUEST)>0){
      $qn_id = isset($_REQUEST['qn_id']) ? $_REQUEST['qn_id'] : '';
      $course_id_survey = isset($_REQUEST['course_id_survey']) ? $_REQUEST['course_id_survey'] : '';
      $sv_lang = isset($_REQUEST['sv_lang']) ? $_REQUEST['sv_lang'] : '';
      $sv_title_th = isset($_REQUEST['sv_title_th']) ? $_REQUEST['sv_title_th'] : '';
      $sv_explanation_th = isset($_REQUEST['sv_explanation_th']) ? $_REQUEST['sv_explanation_th'] : '';
      $sv_title_eng = isset($_REQUEST['sv_title_eng']) ? $_REQUEST['sv_title_eng'] : '';
      $sv_explanation_eng = isset($_REQUEST['sv_explanation_eng']) ? $_REQUEST['sv_explanation_eng'] : '';
      $sv_suggestion_status = isset($_REQUEST['sv_suggestion_status']) ? $_REQUEST['sv_suggestion_status'] : '0';
      $sv_status = isset($_REQUEST['sv_status']) ? $_REQUEST['sv_status'] : '0';
      $time_start = isset($_REQUEST['time_start_survey']) ? $_REQUEST['time_start_survey'].":00" : '';
      $time_end = isset($_REQUEST['time_end_survey']) ? $_REQUEST['time_end_survey'].":00" : '';
      $survey_open_var = isset($_REQUEST['survey_open_var']) ? $_REQUEST['survey_open_var']." ".$time_start : '';
      $survey_end_var = isset($_REQUEST['survey_end_var']) ? $_REQUEST['survey_end_var']." ".$time_end : '';
      $sv_rank = isset($_REQUEST['sv_rank']) ? $_REQUEST['sv_rank'] : '5';
      $data = array(
        'cos_id' => $course_id_survey,
        'sv_lang' => $sv_lang,
        'sv_title_th' => $sv_title_th,
        'sv_explanation_th' => $sv_explanation_th,
        'sv_title_eng' => $sv_title_eng,
        'sv_explanation_eng' => $sv_explanation_eng,
        'sv_suggestion_status' => $sv_suggestion_status,
        'survey_open' => $survey_open_var,
        'survey_end' => $survey_end_var,
        'sv_status' => $sv_status,
        'sv_rank' => $sv_rank,
        'sv_modifiedby' => $sess['u_id'],
        'sv_modifieddate' => date('Y-m-d H:i')
      );
            $arr_update = array('cos_modifieddate'=>date('Y-m-d H:i:s'));
            $this->db->where('cos_id',$course_id_survey);
            $this->db->update('LMS_COS',$arr_update);
      if($_REQUEST['operation_survey']=="Add"){
        $data['sv_createby'] = $sess['u_id'];
        $data['sv_createdate'] = date('Y-m-d H:i');
        $data['qn_id'] = $qn_id;

          $fetch_chk = $this->func_query->numrows('LMS_SURVEY','','','','(sv_title_th="'.$data['sv_title_th'].'" and sv_title_eng="'.$data['sv_title_eng'].'") and cos_id="'.$data['cos_id'].'" and sv_isDelete="0"');
            if($fetch_chk==0){
              $this->db->insert('LMS_SURVEY', $data);
              $id = $this->db->insert_id();
              if($id!=""){
                if(isset($_REQUEST['qn_id'])&&$_REQUEST['qn_id']!=""){
                  $qn_id = $_REQUEST['qn_id'];
                  $fetch_data = $this->func_query->query_result('LMS_QUESTIONNAIRE_DE','','','','qn_id="'.$qn_id.'" and qnde_isDelete="0"');
                  foreach ($fetch_data as $key_qn => $value_qn) {
                    $data_qn = array(
                      'sv_id' => $id,
                      'svde_heading_th' => $data['sv_title_th']!=""?$value_qn['qnde_heading_th']:"",
                      'svde_detail_th' => $data['sv_title_th']!=""?$value_qn['qnde_detail_th']:"",
                      'svde_heading_eng' => $data['sv_title_eng']!=""?$value_qn['qnde_heading_eng']:"",
                      'svde_detail_eng' => $data['sv_title_eng']!=""?$value_qn['qnde_detail_eng']:"",
                      'svde_createby' => $sess['u_id'],
                      'svde_createdate' => date('Y-m-d H:i'),
                      'svde_modifiedby' => $sess['u_id'],
                      'svde_modifieddate' => date('Y-m-d H:i')
                    );
                    $this->course->create_survey_detail($data_qn);
                  }
                }
                $output['status'] = "2";
              }else{
                $output['status'] = "3";
              }
            }else{
              $output['status'] = "1";
            }
            $courses = $this->course->query_data_onupdate($_REQUEST['course_id_survey'], 'LMS_COS','cos_id');
            $this->lg->record('course', 'Create Survey : '.$sv_title_th.' in course '.$courses['cname_th'].' By '.$sess['fullname_th']);
      }else{
          $this->course->update_survey($data,$_REQUEST['sv_id']);
                if(isset($_REQUEST['qn_id'])&&$_REQUEST['qn_id']!=""){
                  $qn_id = $_REQUEST['qn_id'];
                  $fetch_data = $this->func_query->query_result('LMS_QUESTIONNAIRE_DE','','','','qn_id="'.$qn_id.'" and qnde_isDelete="0"');
                  foreach ($fetch_data as $key_qn => $value_qn) {
                    $data_qn = array(
                      'sv_id' => $_REQUEST['sv_id'],
                      'svde_heading_th' => $data['sv_title_th']!=""?$value_qn['qnde_heading_th']:"",
                      'svde_detail_th' => $data['sv_title_th']!=""?$value_qn['qnde_detail_th']:"",
                      'svde_heading_eng' => $data['sv_title_eng']!=""?$value_qn['qnde_heading_eng']:"",
                      'svde_detail_eng' => $data['sv_title_eng']!=""?$value_qn['qnde_detail_eng']:"",
                      'svde_createby' => $sess['u_id'],
                      'svde_createdate' => date('Y-m-d H:i'),
                      'svde_modifiedby' => $sess['u_id'],
                      'svde_modifieddate' => date('Y-m-d H:i')
                    );
                    $this->course->create_survey_detail($data_qn);
                  }
                }
          $output['status'] = "2";
          $courses = $this->course->query_data_onupdate($_REQUEST['course_id_survey'], 'LMS_COS','cos_id');
          $this->lg->record('course', 'Update Survey : '.$sv_title_th.' in course '.$courses['cname_th'].' By '.$sess['fullname_th']);
      }
    }
    echo json_encode($output);
  }

  public function insert_survey_detail(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata('user');
    $this->load->model('Course_model', 'course', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->load->model('Log_model', 'lg', FALSE);
    $this->lg->loadDB();
    $this->course->loadDB();
    if(count($_REQUEST)>0){

      $sv_id_detail = isset($_REQUEST['sv_id_detail']) ? $_REQUEST['sv_id_detail'] : '';
      $svde_heading_th = isset($_REQUEST['svde_heading_th']) ? $_REQUEST['svde_heading_th'] : '';
      $svde_detail_th = isset($_REQUEST['svde_detail_th']) ? $_REQUEST['svde_detail_th'] : '';
      $svde_heading_eng = isset($_REQUEST['svde_heading_eng']) ? $_REQUEST['svde_heading_eng'] : '';
      $svde_detail_eng = isset($_REQUEST['svde_detail_eng']) ? $_REQUEST['svde_detail_eng'] : '';
      $svde_suggestionactive = isset($_REQUEST['svde_suggestionactive']) ? $_REQUEST['svde_suggestionactive'] : '0';
      $data = array(
        'sv_id' => $sv_id_detail,
        'svde_heading_th' => $svde_heading_th,
        'svde_detail_th' => $svde_detail_th,
        'svde_heading_eng' => $svde_heading_eng,
        'svde_detail_eng' => $svde_detail_eng,
        'svde_suggestionactive' => $svde_suggestionactive,
        'svde_modifiedby' => $sess['u_id'],
        'svde_modifieddate' => date('Y-m-d H:i')
      );
      $sv_data = $this->func_query->query_row('LMS_SURVEY','','','','sv_id = "'.$sv_id_detail.'"');
      $courses = $this->course->query_data_onupdate($sv_data['cos_id'], 'LMS_COS','cos_id');
      if($_REQUEST['operation_survey_detail']=="Add"){
          $data['svde_createby'] = $sess['u_id'];
          $data['svde_createdate'] = date('Y-m-d H:i');
          $this->lg->record('course', 'Create question Survey : '.$sv_data['sv_title_th'].' in course '.$courses['cname_th'].' By '.$sess['fullname_th']);

          $fetch_chk = $this->func_query->numrows('LMS_SURVEY_DE','','','','svde_heading_th="'.$data['svde_heading_th'].'" and svde_detail_th="'.$data['svde_detail_th'].'" and svde_heading_eng="'.$data['svde_heading_eng'].'" and svde_detail_eng="'.$data['svde_detail_eng'].'" and sv_id="'.$data['sv_id'].'" and svde_isDelete="0"');
            if($fetch_chk==0){
              $this->db->insert('LMS_SURVEY_DE', $data);
              $id = $this->db->insert_id();
              if($id!=""){
                $output['status'] = "2";
              }else{
                $output['status'] = "3";
              }
            }else{
              $output['status'] = "1";
            }
      }else{
        $this->course->update_survey_detail($data,$_REQUEST['svde_id']);
        $this->lg->record('course', 'Update question Survey : '.$sv_data['sv_title_th'].' in course '.$courses['cname_th'].' By '.$sess['fullname_th']);
        $output['status'] = "2";
      }
    }
    echo json_encode($output);
  }

  public function insert_criteria_score(){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $this->lang->load($lang,$lang);
    date_default_timezone_set("Asia/Bangkok");
    $sess = $this->session->userdata('user');
    $this->load->model('Course_model', 'course', FALSE);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->load->model('Log_model', 'lg', FALSE);
    $this->lg->loadDB();
    $this->course->loadDB();
    if(count($_REQUEST)>0){

      $lv_id = isset($_REQUEST['lv_id']) ? $_REQUEST['lv_id'] : '';
      $qizlv_id = isset($_REQUEST['qizlv_id']) ? $_REQUEST['qizlv_id'] : '';
      $qizlv_goalscore = isset($_REQUEST['qizlv_goalscore']) ? $_REQUEST['qizlv_goalscore'] : '';
      $qiz_id = isset($_REQUEST['qiz_id_criteriascore']) ? $_REQUEST['qiz_id_criteriascore'] : '';
      $operation_criteriascore = isset($_REQUEST['operation_criteriascore']) ? $_REQUEST['operation_criteriascore'] : '';

      if($lv_id!=""&&count($lv_id)>0){
          for ($i=0; $i < count($lv_id); $i++) { 
            $arr_insert = array(
                'lv_id' => $lv_id[$i],
                'qiz_id' => $qiz_id,
                'qizlv_goalscore' => $qizlv_goalscore,
                'qizlv_modifiedby' => $sess['u_id'],
                'qizlv_modifieddate' => date('Y-m-d H:i')
            );
            $fetch_rechk = $this->func_query->query_row('LMS_QIZ_LEVEL','','','','qiz_id="'.$qiz_id.'" and lv_id = "'.$lv_id[$i].'" and qizlv_isDelete = 0');
            if(count($fetch_rechk)>0){
              $this->db->where('qizlv_id',$fetch_rechk['qizlv_id']);
              $this->db->update('LMS_QIZ_LEVEL',$arr_insert);
            }else{
              $arr_insert['qizlv_createby'] = $sess['u_id'];
              $arr_insert['qizlv_createdate'] = date('Y-m-d H:i');
              $this->db->insert('LMS_QIZ_LEVEL',$arr_insert);
            }
          }
          $this->lg->record('course', 'Update Qiz Criteria Score : '.$qiz_id.' By '.$sess['fullname_th']);
          $output['status'] = "2";
      }else{
        if($operation_criteriascore=="Edit"){
            $arr_insert = array(
                'qizlv_goalscore' => $qizlv_goalscore,
                'qizlv_modifiedby' => $sess['u_id'],
                'qizlv_modifieddate' => date('Y-m-d H:i')
            );
            $fetch_rechk = $this->func_query->query_row('LMS_QIZ_LEVEL','','','','qizlv_id="'.$qizlv_id.'"');
            if(count($fetch_rechk)>0){
              $this->db->where('qizlv_id',$qizlv_id);
              $this->db->update('LMS_QIZ_LEVEL',$arr_insert);
              $this->lg->record('course', 'Update Qiz Criteria Score : '.$qiz_id.' By '.$sess['fullname_th']);
              $output['status'] = "2";
            }else{
              $output['status'] = "1";
            }
        }else{
          $output['status'] = "1";
        }
      }
    }
    echo json_encode($output);
  }

}