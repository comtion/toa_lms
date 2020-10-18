<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/inc/inc-meta-dashboard.php');

?>
    <link href="<?php echo REAL_PATH; ?>/assets/css/pages/tab-page.css" rel="stylesheet">
    <link href="<?php echo REAL_PATH; ?>/assets/css/custom_imat.css" rel="stylesheet">
    <link href="<?php echo REAL_PATH; ?>/assets/css/bootstrap-select.min.css" rel="stylesheet">
    <style type="text/css">
      .disable {
         pointer-events: none;
         cursor: default;
      }
      /*.customvtab .tabs-vertical li .nav-link.active, .customvtab .tabs-vertical li .nav-link:hover, .customvtab .tabs-vertical li .nav-link:focus {
          border-right: 2px solid #000000;
          color: #000000;
      }*/
      .les_info img{
          width: 100%;
          height: auto;
      }
        .break-word {
          display: inline-block;
          word-break: break-word;
        }
              a,h3,h4,p{overflow-wrap: break-word;
word-wrap: break-word;

-ms-word-break: break-all;
/* This is the dangerous one in WebKit, as it breaks things wherever */
word-break: break-all;
/* Instead use this non-standard one: */
word-break: break-word;

/* Adds a hyphen where the word breaks, if supported (No Blink) */
-ms-hyphens: auto;
-moz-hyphens: auto;
-webkit-hyphens: auto;
hyphens: auto;
              }
              .btn{overflow-wrap: break-word;
word-wrap: break-word;

-ms-word-break: break-all;
/* This is the dangerous one in WebKit, as it breaks things wherever */
word-break: break-all;
/* Instead use this non-standard one: */
word-break: break-word;

/* Adds a hyphen where the word breaks, if supported (No Blink) */
-ms-hyphens: auto;
-moz-hyphens: auto;
-webkit-hyphens: auto;
hyphens: auto;
              }.btn {
    white-space:normal !important; 
    word-wrap: break-word; 
    word-break: normal;
}

    </style>
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
      <div class="loader">
        <div class="loader__figure"></div>
        <p class="loader__label"><?php if($lang=="thai"){echo $foote[0]['da_title_th'];}else{echo $foote[0]['da_title_en'];} ?></p>
      </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <?php $this->load->view('frontend/inc/inc-header.php'); ?>
        <?php $this->load->view('frontend/inc/inc-sidemenu.php'); ?>
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">

            <div class="container-fluid">                
                <div class="row col-12 page-titles">
                    <div class="col-md-5 align-self-center">
                        <b><?php echo ucwords($course_main['cname']); ?></b>
                    </div>
                    <div class="col-md-7 align-self-right">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo REAL_PATH;?>/dashboard"><?php echo ucwords(label('dashboard')); ?></a></li>
                            <?php if($title_main!=""){ ?>
                            <li class="breadcrumb-item active"><?php echo ucwords(strtolower($title_main)); ?></li>
                            <?php } ?>
                            <li class="breadcrumb-item active"><?php echo ucwords($course_main['cname']); ?></li>
                        </ol>
                    </div>
                </div>  
              <div class="row">
                <div class="card card-body">
                <div class="row">
                    <div class="col-md-4" align="left">
                      <?php 
                        $pageback = REAL_PATH.'/managecourse/courses_all';

                        if($isDashboard=="1"){
                            $pageback = REAL_PATH.'/dashboard';
                        }
                      ?>
                      <button class="btn btn-outline-info " onclick="window.location.href='<?php echo $pageback; ?>'"><i class="mdi mdi-keyboard-return"></i> <?php echo ucwords(label('m_previous')); ?></button>
                    </div>
                    <div class="col-md-8" align="right">

                    <?php if($course_main['cos_public']=="0"){ 
                            if($is_public=="1"&&$course_main['cos_status']=="1"){
                    ?>
                      <button type="button" class="btn waves-effect waves-light btn-outline-success float-right enable_course" name="enable_course" id="<?php echo $course_main['cos_id']; ?>"><i class="mdi mdi-check"></i> <?php echo label('enable_course'); ?></button>
                    <?php   }else{ ?>
                      <h4><span id="txt_approve"><i class="mdi mdi-timer-sand"></i> <?php echo label('d_waitcreate'); ?></span></h4>
                    <?php   }
                          }
                    ?>
                    </div>
                </div>
                </div>
              </div>
                <?php 
                if($lang_select==""){
                  $lang_select = $lang;
                }
                if($lang_select=="thai"){
                  $createBy = "สร้างโดย";
                  $lesson_file = "เอกสารประกอบการเรียน";
                  $survey_txt = "แบบสำรวจ";
                  $pointtxt = "คะแนน";
                  $lessontxt = "บทเรียน";
                  $preNo = "ข้อที่";
                  $summarytxt = "คำอธิบาย";
                  $close = "ปิด";
                  $m_previous = "กลับ";
                  $saveR = "บันทึก";
                  $m_next = "ถัดไป";
                  $preSend = "ส่งคำตอบ";
                  $full_screentxt = "ขยายเต็มจอ";
                  $qiz_starttxt = "เริ่มทำแบบทดสอบ";
                  $download_file = "ดาวน์โหลดไฟล์";
                  $m_ok = "ตกลง";
                  $go_to_course = "เข้าสู่หลักสูตร";
                  $Les_video = "วิดีโอประกอบการสอน";
                  $hinttxt = "คำใบ้";
                  $sent_survey = "ส่งแบบสำรวจ";
                  $periodtxt = "ระยะเวลาที่เปิดหลักสูตร";
                  $Chooselangtxt = "กรุณาเลือกภาษา";
                  $thailandtxt = "ภาษาไทย";
                  $englishtxt = "ภาษาอังกฤษ";
                  $japantxt = "ภาษาญี่ปุ่น";
                  $com_msg_success = "บันทึกข้อมูลสำเร็จ";
                  $com_msg_error_save = "ไม่สามารถบันทึกข้อมูลได้";
                  $d_waitapprove = "อยู่ระหว่างรอการอนุมัติ";
                  $regis_sub = "หลักสูตรนี้เต็มแล้ว ชื่อของคุณจะถูกบันทึกในรายชื่อสำรอง";
                  $r_notregister = "ยังไม่ลงทะเบียน";
                  $wg_datanotfound = "ไม่พบข้อมูล";
                  $cos_expired = "หลักสูตรนี้หมดอายุแล้ว";
                  $qiz_not_complete = "กรุณากดบันทึกคำตอบก่อนทำการยืนยันแบบทดสอบ";
                  $save_complete = "ส่งคำตอบสำเร็จ";
                  $confirm_submit_quiz = "คุณแน่ใจที่จะส่งคำตอบหรือไม่ ?";
                  $noti_clicksave = "กรุณาตอบคำถาม";
                  $answer_wrong = "คุณตอบผิด กรุณาตอบอีกครั้ง";
                  $chk_answer_label = 'ตรวจคำตอบ';
                  $preExam_label = 'แบบทดสอบก่อนเรียน';
                  $finalExam_label = 'แบบทดสอบหลังเรียน';
                  $condition_msg = 'ท่านจะสามารถเรียนหลักสูตรนี้ได้ เมื่อท่านผ่านหลักสูตรตามที่กำหนด <br>&#34;_coursename_&#34;';
                }else if($lang_select=="english"){
                  $createBy = "Created by";
                  $lesson_file = "Course Material";
                  $survey_txt = "Survey";
                  $pointtxt = "Score";
                  $lessontxt = "Lesson";
                  $preNo = "No.";
                  $summarytxt = "Description";
                  $close = "Close";
                  $m_previous = "Back";
                  $saveR = "Save";
                  $m_next = "Next";
                  $preSend = "Submit answer";
                  $full_screentxt = "Enter full screen";
                  $qiz_starttxt = "Start test";
                  $download_file = "Download file";
                  $m_ok = "OK";
                  $go_to_course = "Go to Course";
                  $Les_video = "Video";
                  $hinttxt = "Hint";
                  $sent_survey = "Submit Survey";
                  $periodtxt = "Course period";
                  $Chooselangtxt = "Please select language";
                  $thailandtxt = "Thai";
                  $englishtxt = "English";
                  $japantxt = "Japanese";
                  $com_msg_success = "Saved successful";
                  $com_msg_error_save = "Cannot save information";
                  $d_waitapprove = "Pending approval";
                  $regis_sub = "This course is fully booked. Your name will be in the waiting list.";
                  $r_notregister = "Not registered yet";
                  $wg_datanotfound = "Information not found";
                  $cos_expired = "This course has expired";
                  $qiz_not_complete = "Please save the answer before confirming test";
                  $save_complete = "Submitted successful";
                  $confirm_submit_quiz = "Are you sure you want to submit ?";
                  $noti_clicksave = "Please answer the questions.";
                  $answer_wrong = "Your answer is wrong, Please try again.";
                  $chk_answer_label = 'Review answer';
                  $preExam_label = 'Pre-test';
                  $finalExam_label = 'Post-test';
                  $condition_msg = 'You will be eligible for this course after you have completed a prerequisite<br>&#34;_coursename_&#34;';
                }else{
                  $createBy = "作成者：";
                  $lesson_file = "学習資料";
                  $survey_txt = "アンケート";
                  $pointtxt = "点数";
                  $lessontxt = "レッソン";
                  $preNo = "番号";
                  $summarytxt = "説明";
                  $close = "閉";
                  $m_previous = "戻る";
                  $saveR = "保存";
                  $m_next = "次";
                  $preSend = "回答を提出";
                  $full_screentxt = "ﾌﾙｽｸﾘｰﾝ";
                  $qiz_starttxt = "ﾃｽﾄ開始";
                  $download_file = "ﾀﾞｳﾝﾛｰﾄﾞﾌｧｲﾙ";
                  $m_ok = "OK";
                  $go_to_course = "ｺｰｽへ";
                  $Les_video = "動画";
                  $hinttxt = "ﾋﾝﾄ";
                  $sent_survey = "アンケートを提出する";
                  $periodtxt = "ｺｰｽ期間";
                  $Chooselangtxt = "言語を選択して下さい";
                  $thailandtxt = "ﾀｲ語";
                  $englishtxt = "英語";
                  $japantxt = "日本語";
                  $com_msg_success = "保存完了";
                  $com_msg_error_save = "情報を保存できません。";
                  $d_waitapprove = "承認待ち";
                  $regis_sub = "このｺｰｽは定員に達しています。待機ﾘｽﾄに入りました。";
                  $r_notregister = "未登録";
                  $wg_datanotfound = "情報がありません";
                  $cos_expired = "このｺｰｽは終了しました";
                  $qiz_not_complete = "ﾃｽﾄをｺﾝﾌｧｰﾑする前に回答を保存して下さい。";
                  $save_complete = "提出完了";
                  $confirm_submit_quiz = "本当に提出しますか？";
                  $noti_clicksave = "質問に回答してください。";
                  $answer_wrong = "回答が間違っています。再度回答して下さい。";
                  $chk_answer_label = '回答ﾚﾋﾞｭｰ';
                  $preExam_label = '事前テスト';
                  $finalExam_label = '事後テスト';
                  $condition_msg = 'このコースを受けることにあたり、以下のコースを完了しなければなりません<br>&#34;_coursename_&#34;';
                }
                ?>
                <div class="row">
                  <div class="col-auto col-md-12 col-lg-4 mb-0 card card-body">
                    <img class="card-img-top img-responsive" src="<?php echo REAL_PATH;?>/uploads/course/<?php echo $course_main['cos_pic']; ?>" onerror="this.src='<?php echo REAL_PATH;?>/images/cover_course.jpg';" alt="Card image cap">
                  </div>

                  <div class="col-md-12 col-lg-8 mb-0 card card-body">
                    <h4 class="text-truncate"><?php echo $course_main['cname']; ?></h4>
                    <div class="d-block position-relative">

                        <div class="row">
                          <div class="col-lg-8 col-sm-12 mt-3">
                            <!-- FOR DESKTOP -->
                            <small class="text-muted text-truncate position-absolute col-md-12 col-lg-8 p-0 hidden-xs-down" style="bottom: 0;"><?php echo $createBy.': '.$course_main['com_name']; ?></small>

                            <!-- FOR MOBILE -->
                            <small class="text-muted text-truncate hidden-sm-up"><?php echo $createBy.': '.$course_main['com_name']; ?></small>
                          </div>
                          <div class="col-lg-4 col-sm-12">
                            <?php if(count($document_cos)>0){ ?>

                              <a type="button" title="<?php echo $lesson_file; ?>" href="#" class="btn btn-block waves-effect waves-light btn-secondary float-right dropdown-toggle float-right" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><i class="mdi mdi-file-document"></i><?php echo ' '.$lesson_file; ?></a>
                              <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 40px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <?php foreach ($document_cos as $key_doccos => $value_doccos) { 
                                  
                                      if($lang_select=="thai"){ 
                                        $name_file = $value_doccos['name_file_th']!=""?$value_doccos['name_file_th']:$value_doccos['name_file_eng'];
                                        $name_file = $name_file!=""?$name_file:$value_doccos['name_file_jp'];
                                      }else if($lang_select=="english"){ 
                                        $name_file = $value_doccos['name_file_eng']!=""?$value_doccos['name_file_eng']:$value_doccos['name_file_th'];
                                        $name_file = $name_file!=""?$name_file:$value_doccos['name_file_jp'];
                                      }else{
                                        $name_file = $value_doccos['name_file_jp']!=""?$value_doccos['name_file_jp']:$value_doccos['name_file_eng'];
                                        $name_file = $name_file!=""?$name_file:$value_doccos['name_file_th'];
                                      }
                                ?>
                                  <button class="dropdown-item view_doccos" typevalue="course_filedemo" id="<?php echo $value_doccos['fil_cos_id']; ?>"  path="<?php echo $value_doccos['path_file']; ?>"><?php echo $name_file; ?></button>
                                <?php } ?>
                              </div>
                            <?php } ?>
                          </div>
                        </div>

                    </div>
                    <hr>
                    <?php echo  str_replace('../uploads/texteditor/', base_url().'/uploads/texteditor/',$course_main['cdetail']); ?>
                  </div>
                </div>

            </div>
            
            <?php $this->load->view('frontend/tab/course_demo.php'); ?>

            <?php if(count($survey_arr)>0){
                      foreach ($survey_arr as $key_survey => $value_survey) {

                  if($lang_select=="thai"){ 
                    $sv_title = $value_survey['sv_title_th']!=""?$value_survey['sv_title_th']:$value_survey['sv_title_eng'];
                    $sv_title = $sv_title!=""?$sv_title:$value_survey['sv_title_jp'];
                  }else if($lang_select=="english"){ 
                    $sv_title = $value_survey['sv_title_eng']!=""?$value_survey['sv_title_eng']:$value_survey['sv_title_th'];
                    $sv_title = $sv_title!=""?$sv_title:$value_survey['sv_title_jp'];
                  }else{
                    $sv_title = $value_survey['sv_title_jp']!=""?$value_survey['sv_title_jp']:$value_survey['sv_title_eng'];
                    $sv_title = $sv_title!=""?$sv_title:$value_survey['sv_title_th'];
                  }
            ?>
            <div class="container-fluid p-0 mb-3">
              <a href="" id="<?php echo $value_survey['sv_id']; ?>" status_tc="<?php echo $value_survey['status_tc']; ?>" <?php if($value_survey['status_tc']!="1"){ ?>style="background-color:#95a5a6;border-color:#95a5a6;color: #ecf0f1;"<?php } ?> class="btn btn-block <?php if($value_survey['status_tc']=="1"){ ?>imat-red-bg btn-danger<?php } ?> text-left <?php if($loop_run==1){echo "survey_main";}else{echo "disable";} ?>  break-word" type="button" >
                <?php if($value_survey['status_tc']=="1"){ ?><i class="fa fas fa-check mr-2"></i><?php } ?> <?php echo $survey_txt.': '.$sv_title; ?>
              </a>
            </div>
          <?php         
                      }
                  } ?> 

        </div>
    </div>

    <!-- SELECT LANGUAGE MODAL -->
    <div id="select_lang_modal" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" onclick="window.location.replace('<?php echo REAL_PATH;?>/managecourse/courses_all');">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <form  enctype="multipart/form-data" id="lang_form" name="lang_form" autocomplete="off" method="POST" accept-charset="utf-8" class="form-horizontal p-t-20">
            <div class="col-lg-12 mb-0">
              <h4 class="text-truncate" data-toggle="tooltip" title="<?php echo $course_main['cname']; ?>"><?php echo $course_main['cname']; ?></h4>
            </div>
          <div class="modal-body row pt-0">
            <div class="col-lg-6 pt-3">
              <img class="card-img-top img-responsive" style="max-width: 300px;" src="<?php echo REAL_PATH;?>/uploads/course/<?php echo $course_main['cos_pic']; ?>" onerror="this.src='<?php echo REAL_PATH;?>/images/cover_course.jpg';" alt="Card image cap">
            </div>
            <div class="col-lg-6 pt-3">              
              <p class="card-text"><?php echo $periodtxt.': '; ?>
                <br><?php echo $course_main['txt_period_course']; ?>
              </p>
              <p class="mb-0"><?php echo $Chooselangtxt.': '; ?></p>

              <select id="course_lang" name="course_lang" class="selectpicker">
               <?php if($course_main['isTH']=="1"){ ?><option value="thai" <?php if($course_main['select_lang']=="thai"){ echo "selected"; } ?> data-icon="flag-icon flag-icon-th"><?php echo $thailandtxt; ?></option><?php } ?>
               <?php if($course_main['isENG']=="1"){ ?><option value="english" <?php if($course_main['select_lang']=="english"){ echo "selected"; } ?> data-icon="flag-icon flag-icon-us"><?php echo $englishtxt; ?></option><?php } ?>
               <?php if($course_main['isJP']=="1"){ ?><option value="japan" <?php if($course_main['select_lang']=="japan"){ echo "selected"; } ?> data-icon="flag-icon flag-icon-jp"><?php echo $japantxt; ?></option><?php } ?>
              </select>

            </div>

          </div>
          <div class="modal-footer">
            <button type="submit" title="<?php echo $go_to_course; ?>" class="btn waves-effect waves-light btn-outline-danger btn-danger-hover float-right" name="action" id="action"><i class="mdi mdi-file-document-box"></i> <?php echo $go_to_course; ?></button>
          </div>
        </div>
        </form>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.SELECT LANGUAGE MODAL -->

    <div id="hint_modal" class="modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel"><?php echo $hinttxt; ?></h4>
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          </div>
          <div class="modal-body">
            <img id="imgques_hintimg" class="card-img-top img-responsive mx-auto d-block" style="max-width: 300px;" src="<?php echo REAL_PATH;?>/assets/images/mockup/img4.jpg" onerror="this.src='<?php echo REAL_PATH;?>/images/logo.png';" alt="Card image cap">
            <hr>
            <h4 id="txtques_hintname"></h4>
            <p id="txtques_hintdetail"></p>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn btn-outline-danger waves-effect" data-dismiss="modal"><?php echo $m_ok; ?></button>
          </div>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.HINT MODAL -->

    <div class="modal bs-example-modal-lg" id="modal-viewdocument" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="myLargeModalLabel"><i class="mdi mdi-printer"></i> <?php echo $lesson_file; ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body"><!--
                  <div id="iframe_document"></div> -->
                  <iframe id="iframe_document" style="width:100%; height:500px;" frameborder="0"></iframe>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="fil_id_downloadfile" id="fil_id_downloadfile">
                    <input type="hidden" id="fil_path_downloadfile" name="fil_path_downloadfile">
                    <button type="button" name="btn_downloadfile" class="btn btn-outline-info btn-flat float-left btn_downloadfile"><i class="mdi mdi-download"></i> <?php echo $download_file; ?></button>
                    <button type="button" class="btn btn-outline-danger btn-flat" data-dismiss="modal"><i class="mdi mdi-window-close"></i> <?php echo $close; ?></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal bs-example-modal-lg" id="modal-viewvideo" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-height: 100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="myLargeModalLabel"><i class="fas fa-video"></i> <?php echo $Les_video; ?></h4>
                    <button type="button" class="close" onclick="onResetVideo()" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                  <div id="video_file_view" class="embed-responsive embed-responsive-16by9" style="display: none;">
                  </div>
                  <div id="video_url_view" class="embed-responsive embed-responsive-16by9" style="display: none;"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-flat" onclick="onResetVideo()" data-dismiss="modal"><i class="mdi mdi-window-close"></i> <?php echo $close; ?></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div id="surveyModal" class="modal bs-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header break-word" style="max-width: 100% ">
                    <h4 class="modal-title" id="myLargeModalLabel"><?php echo $survey_txt.': '; ?><span id="txt_headsurvey" class="break-word"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form  enctype="multipart/form-data" id="survey_form" name="survey_form" autocomplete="off" method="POST" accept-charset="utf-8"  class="form-horizontal p-t-20">
                <div class="modal-body" style="">
                    <h5 id="txt_infosurvey"></h5>
                    <div id="survey_data">
                      
                    </div>
                </div>
                <input type="hidden" name="sv_id" id="sv_id">
                <div class="modal-footer" align="right">
                    <button type="submit" class="btn waves-effect waves-light btn-outline-success btn_survey" name="action" id="action"><i class="mdi mdi-send"></i> <?php echo $sent_survey; ?></button>
                    <button type="button" class="btn waves-effect waves-light btn-outline-danger" data-dismiss="modal"><i class="mdi mdi-window-close"></i> <?php echo $close; ?></button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.SURVEY MODAL -->


    <?php $this->load->view('frontend/inc/inc-footer.php'); ?>

      <div id="myModal_process" class="modal bs-example-modal-lg" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-body" align="center">
                <img src="<?php echo REAL_PATH; ?>/assets/images/01-progress.gif" style="width: 50%">
                <br>
                <h3 style="color: black;"><?php echo label('please_wait'); ?></h3>
              </div>
            </div>
        </div>
      </div>
                            <script type="text/javascript">
                              function onclickfirstquestion(tab){

                                $('.nav-tabs a[href="#'+tab+'"]').tab('show');
                              }
                            </script>
    <script type="text/javascript">var base_url = "<?php echo REAL_PATH; ?>";</script>
    <script src="<?php echo REAL_PATH; ?>/assets/js/bootstrap-select.min.js"></script>
    <script type="text/javascript">

      document.addEventListener('contextmenu', event => event.preventDefault());
      $(document).keydown(function(event){
          if(event.keyCode==123){
              return false;
          }
          else if (event.ctrlKey && event.shiftKey && event.keyCode==73){        
                   return false;
          }
      });
        /*window.onclick = function(event) {
           if (event.target.id != "modal-viewvideo") {
              $("#video_url_view").html('');
              $("#video_file_view").html('');

           }
        }*/
            function onResetVideo(){
              $('#video_file_view').html('');
              $('#video_url_view').html('');
            }
            function inArray(needle, haystack) {
                var length = haystack.length;
                for(var i = 0; i < length; i++) {
                    if(haystack[i] == needle) return true;
                }
                return false;
            }
          function createButton(text,classs,style,id, cb) {
            return $(' <button class="'+classs+'" style="'+style+'" id="'+id+'">' + text + '</button>').on('click', cb);
          }
          
                function ongotab(les_id){
                  $('a[href="#' + les_id + '"]').tab('show');
                  $('html,body').animate({scrollTop: $('#less_div').offset().top  - 150},'fast');
                  $('.tab_lesson').animate({scrollTop: 0},'fast');
                }
        function play_scm(numb){
            var link_scm = $('#link_scm'+numb).val();
            $('#scorm_play_iframe' + numb).attr('src',link_scm);
        }
        $(document).click(function(event) {
          //if you click on anything except the modal itself or the "open modal" link, close the modal
          if ($(event.target).closest(".modal,.js-open-modal").length) {
              var video_upload = document.getElementById("video_upload_html5_api");
              if($("#video_upload_html5_api").length > 0){document.getElementById("video_upload_html5_api").pause();}
              var iframe = document.getElementById('video_youtube');
              if($("#video_youtube").length > 0){ iframe.src = iframe.src; }
          }
        });
        function click_next(id,ques_id,qiz_id,type){
              var ques_type = $('#ques_type_'+type+'_'+ques_id).val();
              var ques_score = $('#ques_score_'+type+'_'+ques_id).val();
              var quiz_model = $('#quiz_model_'+type+'_'+qiz_id).val();
              var quiz_ishint = $('#quiz_ishint_'+type+'_'+qiz_id).val();
              var tc_save = $('#tc_save_'+type+'_'+ques_id).val();
              var mul_answer = $('#mul_answer_'+type+'_'+ques_id).val();
              console.log(mul_answer);
              var answer = "";
              var chk_answer = 1;
              if(ques_type=="multi"||ques_type=="2choice"){
                var radioValue = $('input[name=multi_choice_group_'+type+'_'+ques_id+']:checked').val(); 
                if(radioValue&&quiz_model=="1"){
                  answer = radioValue;
                  var res = mul_answer.split(",");
                  if (!inArray(answer, res)) {
                      chk_answer = 0;
                      if(quiz_ishint=="1"){
                        var ques_hintname = $('#ques_hintname_'+type+'_'+ques_id).val();
                        var ques_hintdetail = $('#ques_hintdetail_'+type+'_'+ques_id).val();
                        var ques_hintimg = $('#ques_hintimg_'+type+'_'+ques_id).val();
                        $('#hint_modal').modal('show');
                        $('#txtques_hintname').text(ques_hintname);
                        $('#txtques_hintdetail').text(ques_hintdetail);
                        $("#imgques_hintimg").attr("src","<?php echo REAL_PATH.'/uploads/hint/' ?>"+ques_hintimg);
                      }else{
                        swal({
                            title: '<?php echo $answer_wrong; ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo $m_ok; ?>'
                        })
                      }
                  }
                }
              }else{
                var txtValue = $('#txt_answer_'+type+'_'+ques_id).val();
                if(txtValue!=""){
                  answer = txtValue;
                }else{
                  answer = "";
                }
              }
              var answer_ques = $('#tc_answer_'+type+ques_id).val();
              if(quiz_model=="1"){
                if(answer_ques!=""){
                  if(chk_answer==1){
                      $('a[href="#' + id + '"]').tab('show');
                  }
                }else{
                    swal({
                        title: '<?php echo $noti_clicksave; ?>',
                        text: "",
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonClass: 'btn btn-primary',
                        confirmButtonText: '<?php echo $m_ok; ?>'
                    })
                }
              }else{
                if(chk_answer==1){
                    $('a[href="#' + id + '"]').tab('show');
                }
              }
              
            }
             $(document).on('click', '.btn_send', function(event){
                event.preventDefault();
                var qiz_id = $(this).attr("id");
                var ques_id = $(this).attr("ques_id");
                var type = $(this).attr("typeval");
                
                var amount_ques = parseInt($('#amount_ques_'+type+'_'+qiz_id).val());
                var qiztc_id = $('#qiztc_id_'+type+'_'+qiz_id).val();
                var numloopchk = 1;
                var numchk = 1;
                var pagenumber = 0;
                var formdata = $('#'+type+'_form'+qiz_id).serialize();
                var arr = $('input[name="tc_answer_'+type+qiz_id+'[]"]').map(function () {
                  if(this.value!=""){
                    numloopchk++;
                    return this.value; // $(this).val()
                  }else{
                    if(numchk==1){
                    pagenumber = numloopchk;
                    numchk++;
                    }
                  }
                }).get();
                if(pagenumber!=0){
                    swal({
                        title: '<?php echo $noti_clicksave; ?>',
                        text: "",
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonClass: 'btn btn-primary',
                        confirmButtonText: '<?php echo $m_ok; ?>'
                    }).then(function () {
                        $('.nav-tabs a[href="#quiz_'+qiz_id+'_'+pagenumber+'"]').tab('show');
                    })
                }else{
                    var ques_type = $('#ques_type_'+type+'_'+ques_id).val();
                    var ques_score = $('#ques_score_'+type+'_'+ques_id).val();
                    var quiz_model = $('#quiz_model_'+type+'_'+qiz_id).val();
                    var quiz_ishint = $('#quiz_ishint_'+type+'_'+qiz_id).val();
                    var tc_save = $('#tc_save_'+type+'_'+ques_id).val();
                    var mul_answer = $('#mul_answer_'+type+'_'+ques_id).val();

                    var answer = "";
                    var chk_answer = 1;
                    if(ques_type=="multi"||ques_type=="2choice"){
                      var radioValue = $('input[name=multi_choice_group_'+type+'_'+ques_id+']:checked').val(); 
                      if(radioValue&&quiz_model=="1"){
                        answer = radioValue;
                        var res = mul_answer.split(",");
                        if (!inArray(answer, res)) {
                            chk_answer = 0;
                            if(quiz_ishint=="1"){
                              var ques_hintname = $('#ques_hintname_'+type+'_'+ques_id).val();
                              var ques_hintdetail = $('#ques_hintdetail_'+type+'_'+ques_id).val();
                              var ques_hintimg = $('#ques_hintimg_'+type+'_'+ques_id).val();
                              $('#hint_modal').modal('show');
                              $('#txtques_hintname').text(ques_hintname);
                              $('#txtques_hintdetail').text(ques_hintdetail);
                              $("#imgques_hintimg").attr("src","<?php echo REAL_PATH.'/uploads/hint/' ?>"+ques_hintimg);
                            }else{
                              swal({
                                  title: '<?php echo $answer_wrong; ?>',
                                  text: "",
                                  type: 'warning',
                                  showCancelButton: false,
                                  confirmButtonClass: 'btn btn-primary',
                                  confirmButtonText: '<?php echo $m_ok; ?>'
                              })
                            }
                        }
                      }
                    }else{
                      var txtValue = $('#txt_answer_'+type+'_'+ques_id).val();
                      if(txtValue!=""){
                        answer = txtValue;
                      }else{
                        answer = "";
                      }
                    }
                    if(chk_answer==1){
                                    swal({
                                        title: '<?php echo $save_complete; ?>!',
                                        text: "",
                                        type: 'success',
                                        showCancelButton: false,
                                        confirmButtonClass: 'btn btn-primary',
                                        confirmButtonText: '<?php echo $m_ok; ?>'
                                    }).then(function () {
                                      $(".text_answer").css({"background-color": "#e8fdeb", "color": "#06d79c"});

                                        //location.reload();
                                    })
                    }
                }
            });
            function onselectVal(type,ques_id,value){
              $('#tc_answer_'+type+ques_id).val(value);
            }
        function click_previous(id){
            $('a[href="#' + id + '"]').tab('show');
        }
        function click_save(ques_id,qiz_id,type){
              var ques_type = $('#ques_type_'+type+'_'+ques_id).val();
              var ques_score = $('#ques_score_'+type+'_'+ques_id).val();
              var quiz_model = $('#quiz_model_'+type+'_'+qiz_id).val();
              var mul_answer = $('#mul_answer_'+type+'_'+ques_id).val();
              var answer = "";
              var tc_score = 0;

              var formdata = $('#'+type+'_form'+qiz_id).serialize();

              
              $('#tc_save_'+type+'_'+ques_id).val('1');
              if(ques_type=="multi"||ques_type=="2choice"){
                var radioValue = $('input[name=multi_choice_group_'+type+'_'+ques_id+']:checked').val(); 
                if(radioValue){
                  answer = radioValue;
                  var res = mul_answer.split(",");
                  if (inArray(answer, res)) {
                    tc_score = ques_score;
                  }
                }else{
                  answer = "";
                }
              }else{
                var txtValue = $('#txt_answer_'+type+'_'+ques_id).val();
                if(txtValue!=""){
                  answer = txtValue;
                  tc_score = ques_score;
                }else{
                  answer = "";
                }
              }
                            $('#tc_save'+ques_id).val(1);
                            swal({
                                title: '<?php echo $com_msg_success; ?>!',
                                text: "",
                                type: 'success',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-primary',
                                confirmButtonText: '<?php echo $m_ok; ?>'
                            })
            }

        $(document).on('click', '.enable_course', function(event){
            event.preventDefault();
            var cos_id = $(this).attr("id");
            swal({
                title: '<?php echo label('enablecourse_is'); ?> ',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#1abc9c",   
                cancelButtonColor: "#DD6B55",  
                confirmButtonText: '<?php echo label('yes'); ?>',
                cancelButtonText: '<?php echo label('no'); ?>'
            }).then(function (isChk) {
                  if(isChk.value){
                    $.ajax({
                      url:"<?=base_url()?>index.php/querydata/public_course",
                      method:"POST",
                      data:{cos_id:cos_id},
                      success:function(data)
                      {
                          location.reload();
                      }
                    });
                  }
                });
          });
        $(document).on('click', '.survey_main', function(event){
            event.preventDefault();
            var sv_id = $(this).attr("id");
            var status_tc = $(this).attr("status_tc");
            if(status_tc=="1"){
              $('.btn_survey').hide();
            }else{
              $('.btn_survey').show();
            }
            $("#surveyModal").modal({backdrop: false});
            $('#sv_id').val(sv_id);
                $.ajax({
                  url:"<?=base_url()?>index.php/querydata/update_survey_detail_data",
                  method:"POST",
                  data:{sv_id_update:sv_id,type:"demo",lang_select:"<?php echo $lang_select; ?>"},
                  dataType:"json",
                  success:function(data)
                  {
                      $('#txt_headsurvey').text(data.sv_title);
                      $('#txt_infosurvey').text(data.sv_explanation);
                  }
                });
                $.ajax({
                      url: '<?=base_url()?>index.php/querydata/survey_data',
                      type: 'POST',
                      data:{sv_id:sv_id,type:"demo",lang_select:"<?php echo $lang_select; ?>"},
                      success: function(data_cg){
                        $('#survey_data').html(data_cg);
                      }
                });
          });
        $(document).on('submit', '#survey_form', function(event){
              event.preventDefault(); 
              swal(
                            '<?php echo $com_msg_success; ?>!',
                            '',
                            'success'
                        )
                
            });

        $(document).on('click', '.btn_downloadfile', function(event){
            event.preventDefault();
            var id = $('#fil_id_downloadfile').val();
            var path = $('#fil_path_downloadfile').val();
            window.location.href = "<?php echo base_url().'/uploads/document/' ?>"+path;
          });

        $(document).on('click', '.view_doccos', function(event){
            event.preventDefault();
            var id = $(this).attr("id");
            var typevalue = $(this).attr("typevalue");
            var path = $(this).attr("path");
            var res = path.split(".");
            /*$('#modal-viewlesson').modal('hide');
            $('#modal-viewdocument').modal('show');*/
            $('#fil_id_downloadfile').val(id);
            $('#fil_path_downloadfile').val(path);
            
                  window.open('<?php echo base_url().'viewdoc/fileview/';?>'+id+'/'+typevalue+'/<?php echo $cos_id; ?>', '_blank');
                /*if(res[1]=="pdf"){
                  document.getElementById("iframe_document").src = "<?php echo base_url().'/uploads/document/' ?>"+path;
                }else{*//*
                  document.getElementById("iframe_document").src = "https://docs.google.com/gview?url=<?php echo base_url().'/uploads/document/'; ?>"+path+"&embedded=true";*/
                //}
          });
        function onplayer_video_cos(type='',video=''){
          $('#modal-viewvideo').modal('show');
          if(type=="url"){
              document.getElementById('video_file_view').style.display = 'none';
              document.getElementById('video_url_view').style.display = '';

              var res = video.substring(24);
              //onYouTubeIframeAPIReady(res);
              $('#video_url_view').html('<iframe class="embed-responsive-item youtube-video" id="video_youtube" onclick="chk_youtubeonplay()" src="'+video+'" allowfullscreen></iframe>');
          }else{
              document.getElementById('video_file_view').style.display = '';
              document.getElementById('video_url_view').style.display = 'none';
              $('#video_file_view').html('<video id="video_upload" controls="controls" controlsList="nodownload" style="width: 100%" src="<?php echo base_url()."/uploads/media/";?>'+video+'"></video>');
              document.getElementById('video_upload').play();
          }
        }
      <?php if(count($course_main)==0){ ?>
        swal({
            title: '<?php echo $wg_datanotfound; ?>',
            text: "",
            type: 'warning',
            showCancelButton: false,
            confirmButtonClass: 'btn btn-primary',
            confirmButtonText: '<?php echo $m_ok; ?>'
        }).then(function () {
          window.open("<?php echo REAL_PATH; ?>/dashboard", "_self");
        });
      <?php }else{ 
              if($isFirsttime=="1"){
      ?>
      $(window).on('load',function(){
          $('#select_lang_modal').modal('show');
      });

      $('#select_lang_modal').modal({backdrop: 'static', keyboard: false});
      <?php   }
            } ?>

      $(document).on("keydown",function(ev){
        if(ev.keyCode==27||ev.keyCode==122){
            document.getElementById('scorm_play_iframe').style.width = "100%";
            document.getElementById('scorm_play_iframe').style.height = "100%";
            document.getElementById("div_scorm_ddd").style.height = "500px";
        }
      })

        function openFullscreen(id) {
          var elem = document.getElementById(id);

          if (elem.requestFullscreen) {
            elem.requestFullscreen();
          } else if (elem.mozRequestFullScreen) { /* Firefox */
            elem.mozRequestFullScreen();
          } else if (elem.webkitRequestFullscreen) { /* Chrome, Safari & Opera */
            elem.webkitRequestFullscreen();
          } else if (elem.msRequestFullscreen) { /* IE/Edge */
            elem.msRequestFullscreen();
          }
          if(id=="div_course_detail"){
            var heightdiv_description = $('#div_description_cos');
            if(parseInt(heightdiv_description.outerHeight())>400){
              document.getElementById("contents_main").style.height = "500px";
              document.getElementById("div_description_cos").style.height = "400px";
              document.getElementById("div_description_cos").style.overflow = "hidden";
              document.getElementById("div_description_cos").style.overflowY = "scroll";
            }
          }

          if( isFullScreen()) {
              closeFullscreen(id);
              if(id=="div_course_detail"){
                document.getElementById("contents_main").style.height = "";
                document.getElementById("div_description_cos").style.height = "";
                document.getElementById("div_description_cos").style.overflow = "hidden";
                document.getElementById("div_description_cos").style.overflowY = "hidden";
              }
          }
        }
        function isFullScreen(){
            return window.screenTop == 0 ? true : false;
        }
        function closeFullscreen(id="") {
          var elem = document.getElementById(id);
          if (elem.exitFullscreen) {
            elem.exitFullscreen();
          } else if (elem.mozCancelFullScreen) { /* Firefox */
            elem.mozCancelFullScreen();
          } else if (elem.webkitExitFullscreen) { /* Chrome, Safari and Opera */
            elem.webkitExitFullscreen();
          } else if (elem.msExitFullscreen) { /* IE/Edge */
            elem.msExitFullscreen();
          }
        }

          $(document).on('click', '.btnrefresh', function(e) {
              e.preventDefault();
              location.reload();
          });
         $(document).on('click', '.approve_cos', function(e){
            var cos_id = $(this).attr("id");

            $.ajax({
                  url:"<?=base_url()?>index.php/querydata/rechk_course_period",
                  method:"POST",
                  data:{cos_id:cos_id},
                  dataType:"json",
                  success:function(data)
                  {
                    var title_val = '';
                    if(data.isApprove=="1"){
                        title_val = '<?php echo label('approve_is_course'); ?>';
                        var buttons = $('<div>')
                        .append(createButton('<i class="mdi mdi-check"></i> <?php echo label('d_approve'); ?>','btn btn-flat btnapprove_cos','background-color:#1abc9c;',cos_id, function() {
                        })).append(createButton('<i class="mdi mdi-close-octagon"></i> <?php echo label("d_reject"); ?>','btn btn-flat btnreject_cos','background-color:#DD6B55;',cos_id, function() {
                           swal.close();
                        })).append(createButton('<?php echo label('cancel'); ?>','btn btn-flat btnrefresh','','', function() {
                           swal.close();
                        }));
                    }else{
                        title_val = '<?php echo label('cantapprove_is_course'); ?>';
                        var buttons = $('<div>')
                        .append(createButton('<i class="mdi mdi-close-octagon"></i> <?php echo label("d_reject"); ?>','btn btn-flat btnreject_cos','background-color:#DD6B55;',cos_id, function() {
                           swal.close();
                        })).append(createButton('<?php echo label('cancel'); ?>','btn btn-flat btnrefresh','','', function() {
                           swal.close();
                        }));
                    }
                    e.preventDefault();
                    swal({
                      title: title_val,
                      html: buttons,
                      type: "warning",
                      showConfirmButton: false,
                      showCancelButton: false
                    });
                  }
            });
          });

          $(document).on('click', '.btnapprove_cos', function(e) {
              e.preventDefault();
              var cos_id = $(this).attr("id");
                $("#myModal_process").modal({backdrop: false});
              $.ajax({
                    url:"<?=base_url()?>index.php/manage/approve_cos_data",
                    method:"POST",
                    data:{cos_id:cos_id},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("approve_msg_success"); ?>',
                            '',
                            'success'
                        ).then(function () {
                          location.reload();
                        })
                      }else if(data == "1"){
                         swal({
                            title: '<?php echo label("wg_msg_use"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label('m_ok'); ?>'
                        }).then(function () {
                          location.reload();
                        })
                      }else{
                         swal({
                            title: '<?php echo label('com_msg_error_save'); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label('m_ok'); ?>'
                        }).then(function () {
                          location.reload();
                        })
                      }
                    }
              });
          });

            $(document).on('click', '.les_onclick', function(event){
                event.preventDefault();
                var les_id = $(this).attr("id");
                  $('html,body').animate({scrollTop: $('#less_div').offset().top  - 150},'fast');

            });

          $(document).on('click', '.btnreject_cos', function(e) {
              e.preventDefault();
              var cos_id = $(this).attr("id");
              swal({
                title: '<i class="mdi mdi-close-octagon"></i> <?php echo label("d_reject"); ?>',
                text: "",
                input: 'text',
                showCancelButton: true,
                closeOnConfirm: false,
                confirmButtonColor: "#1abc9c",   
                cancelButtonColor: "#DD6B55",    
                confirmButtonText: '<?php echo label('m_ok'); ?>',
                cancelButtonText: '<?php echo label('cancel'); ?>',
                inputPlaceholder: "<?php echo label('preDetail'); ?>: "
              }).then(function (isChk) {
                  if(isChk.value){
                    $("#myModal_process").modal({backdrop: false});
                    $.ajax({
                      url:"<?=base_url()?>index.php/querydata/reject_cos",
                      method:"POST",
                      data:{cos_id:cos_id,cosa_note:isChk.value},
                      dataType:"json",
                      success:function(data)
                      {
                    location.reload();
                      }
                    });
                  }
              });
          });
    </script>
</body>

</html>
