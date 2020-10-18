<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/inc/inc-meta-dashboard.php'); 

    $arrMonthThaiTextShort = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย","ธ.ค.");
    $arrMonthThaiTextFull = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
?>

    <!-- chartist CSS -->
    <link href="<?php echo REAL_PATH; ?>/assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="<?php echo REAL_PATH; ?>/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <!-- page css -->
    <link href="<?php echo REAL_PATH; ?>/assets/css/pages/ribbon-page.css" rel="stylesheet">
    <link href="<?php echo REAL_PATH; ?>/assets/plugins/css-chart/css-chart.css" rel="stylesheet">
    <link href="<?php echo REAL_PATH; ?>/assets/css/pages/easy-pie-chart.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo REAL_PATH; ?>/assets/plugins/datatables/media/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="<?php echo REAL_PATH; ?>/assets/css/custom_imat.css">
    <link rel="stylesheet" type="text/css" href="<?php echo REAL_PATH; ?>/assets/css/dashboard.css">
    <!-- Timeline CSS -->
    <link href="<?php echo REAL_PATH; ?>/assets/plugins/horizontal-timeline/css/horizontal-timeline.css" rel="stylesheet">

    <!-- page css -->
    <link href="<?php echo REAL_PATH; ?>/assets/css/pages/timeline-vertical-horizontal.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/round-slider@1.4.0/dist/roundslider.min.css">

    <style type="text/css">
      .dt-head-center {text-align: center;}
    </style>
</head>

<body class="fix-header fix-sidebar card-no-border">
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label"><?php if($lang=="thai"){echo $foote[0]['da_title_th'];}else{echo $foote[0]['da_title_en'];} ?></p>
        </div>
    </div>
    <div id="main-wrapper">
        <?php $this->load->view('frontend/inc/inc-header.php'); ?>
        <?php $this->load->view('frontend/inc/inc-sidemenu.php'); ?>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                  <?php $this->load->view('frontend/detail/dashboard_detail.php'); ?>


                    <?php if(count($arr_year_enroll)>0){ ?>
                    <div class="col-lg-12 div_learner" style="display: none;">
                        <div class="card card-body">
                            <div class="card-title">
                              <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                      <h4 class="card-title m-b-0"><span class="lstick"></span><?php echo label('dash_b_select_point'); ?></h4>
                                    </div>
                                    <!-- <div class="col-lg-6 col-md-6 text-right">
                                        <small class="card-subtitle hidden-sm-down"><a href="javascript:void(0)" class="card-header accordian-style pointer" id="heading11" data-toggle="collapse" data-target="#suggestion_period" aria-expanded="true" aria-controls="suggestion_period" style="border: none; padding: 0;"><?php echo label('dash_b_select_period'); ?></a></small>
                                    </div> -->
                                </div>
                            </div>
                            <hr class="m-t-0">
                            <div class="row">                                
                                <div class="col-md-12 col-xl-12 text-right">
                                        <div class="row">
                                            <select class="col-md-12 col-xl-3 custom-select b-0" id="select_monthstart_learner" name="select_monthstart_learner" onchange="onquerylearner_course();">
                                                    <option hidden><?php echo label('dash_b_choosemonth'); ?></option>
                                                    <?php 
                                                        for ($i=1; $i <= 12; $i++) { 
                                                            ?>
                                                            <option value="<?php echo $i<10?"0".$i:$i; ?>" <?php if(intval(date('m'))==$i){echo "selected";} ?>><?php echo $thaimonth[intval($i)]; ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                            </select>
                                            <select class="col-md-12 col-xl-3 custom-select b-0" id="select_yearstart_learner" name="select_yearstart_learner" onchange="onquerylearner_course();">
                                                    <option hidden><?php echo label('dash_b_chooseyear'); ?></option>
                                                    <?php 
                                                    if(count($arr_year_enroll)>0){
                                                        for ($i=0; $i < count($arr_year_enroll); $i++) { 
                                                            ?>
                                                            <option value="<?php echo $arr_year_enroll[$i]; ?>" <?php if(date('Y')==$arr_year_enroll[$i]){echo "selected";} ?>><?php echo $arr_year_enroll[$i]; ?></option>
                                                            <?php
                                                        }
                                                    }else{
                                                            ?>
                                                            <option value="<?php echo date('Y'); ?>" selected><?php echo date('Y'); ?></option>
                                                            <?php
                                                    }
                                                    ?>
                                            </select>
                                            <select class="col-md-12 col-xl-3 custom-select b-0" id="select_monthend_learner" name="select_monthend_learner" onchange="onquerylearner_course();">
                                                    <option hidden><?php echo label('dash_b_choosemonth'); ?></option>
                                                    <?php 
                                                        for ($i=1; $i <= 12; $i++) { 
                                                            ?>
                                                            <option value="<?php echo $i<10?"0".$i:$i; ?>" <?php if(intval(date('m'))==$i){echo "selected";} ?>><?php echo $thaimonth[intval($i)]; ?></option>
                                                            <?php
                                                        }
                                                    ?>
                                            </select>
                                            <select class="col-md-12 col-xl-3 custom-select b-0" id="select_yearend_learner" name="select_yearend_learner" onchange="onquerylearner_course();">
                                                    <option hidden><?php echo label('dash_b_chooseyear'); ?></option>
                                                    <?php 
                                                    if(count($arr_year_enroll)>0){
                                                        for ($i=0; $i < count($arr_year_enroll); $i++) { 
                                                            ?>
                                                            <option value="<?php echo $arr_year_enroll[$i]; ?>" <?php if(date('Y')==$arr_year_enroll[$i]){echo "selected";} ?>><?php echo $arr_year_enroll[$i]; ?></option>
                                                            <?php
                                                        }
                                                    }else{
                                                            ?>
                                                            <option value="<?php echo date('Y'); ?>" selected><?php echo date('Y'); ?></option>
                                                            <?php
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                </div>
                            </div>
                            <!-- <div id="suggestion_period" class="collapse" aria-labelledby="heading11">
                                <hr>
                                <small>
                                    <b>คำแนะนำการเลือกช่วงเวลาในการดูรายงาน</b>
                                    <br>1. โบลิเวียเตหะรานจีน เมียนมาร์ซูริกนอร์เวย์ คอสตาริกาบาฮามาส เบอร์ลินโอเรกอนคุนหมิง อาบูดาบีฝรั่งเศสไลบีเรีย มะละกากลันตัน มาดริดฮ่องกงอเมริกา โดมินิกัน เจนีวาโซเฟีย ลิเบียเสียมเรียบสเปนลิเบีย มอสโกโซเวียต สิกขิมคีร์กีซสถาน สตอกโฮล์มอัฟกานิสถานเกาหลีเวียดนามชิลี บังกาลอร์นาริตะพาราณสี คุชราตภูฏานแคนเบอร์ราจำปาศักดิ์ อุซเบกิสถานยุโรป
                                    <br>2. อิเควทอเรียลยูโกสลาเวียเสฉวน โอเรกอนกินีนิวยอร์คอินเดียฟิลิปปินส์ สกอตแลนด์ ปะลิสซามัวเวียดนามอีเจียนเซียร์รา นิวเดลี บราซิลอลาสกา มัทราสปีนังลุยเซียนา อัฟกานิสถานฟลอริดาพิหารี มาเก๊าสเปนลิกเตนสไตน์พระตะบองกรีก ซูรินาเมไซบีเรียไอดาโฮ อินเดียนามัณฑะเลย์จอร์แดนแอตแลนตา โอริสสามาเลเซียฟิลิปปินส์ สวีเดนซูริค ลอสแองเจลิสเคปเวิร์ดเม็กซิโกโตรอนโตอิลลินอยส์ มัทราส โปรตุเกสจาการ์ตา
                                    <br>3. แอตแลนติกนิวซีแลนด์เมโสโปเตเมียยุโรป ตรังกานู บริติชมาเลเซีย พนมเปญ เวอร์มอนต์ มิวนิกปะลิสโลซานน์ซูริกแทสเมเนีย โคลอมเบีย พนมเปญทรอย กัลกัตตามาดริดฟลอริดาบิสเซาเวียดนาม เอเดรียติก เคมบริดจ์โดเวอร์เวอร์จิเนียโทรอนโต อาร์กติกกรีกบาฮามาส สุมาตราฉงชิ่ง เวลส์อิตาเลียน เปียงยาง บอมเบย์บอตสวานา
                                    <br>4. ตรินิแดดมะละกาเคนยา เซี่ยงไฮ้มอลตาเปอร์โตริโก เวเนซุเอลาอัฟกานิสถานมิชิแกนอาหรับ แอตแลนตา ลอสแองเจลิสมองโกเลียโดมินิกา เดนเวอร์ เจนไนโอเรกอนนิการากัวอินเดียนาฟิจิ โมร็อกโกเตหะรานลิเบียกินีออสโล มาดริดเอเวอเรสต์จีนมอสโก ยุโรปลาสเวกัสเซี่ยงไฮ้ คาซัคสถาน เทลอาวีฟยะไข่ อชันตาจอร์แดนมาลาวีเบงกอล โรมาเนียโอมาน นิวเจอร์ซีย์ลักเซมเบิร์กลุมพินีจีน เสียมเรียบไทรบุรีแทสเมเนียเพนซิลวาเนีย
                                    <br>5. ลักเซมเบิร์ก คิริบาตี นิวยอร์กมอนแทนาสเปนยูทาห์จอร์แดน เลบานอนมอลโดวานิโคบาร์โซเฟียลุมพินี ลุมพินีเอริเทรียซีอาน โรดไอแลนด์อินเดียนาบุรุนดีอุซเบกิสถาน เอริเทรียเฮอร์เซโกวีนาโคลอมเบีย สวาซิแลนด์ปัฏนารวันดา รัสเซียนลักเซมเบิร์กโกตดิวัวร์ เอมิเรตส์เคนตักกีเบลเกรดเบงกอล เมโสโปเตเมียไซบีเรียแอตแลนติก มิวนิกบอตสวานาแอนติกา ลิสบอนโบลิเวียแอตแลนตาแอลเจียร์ เคปเวิร์ดลาสเวกัสลูเซียทิเบต แอนตาร์กติกาเคย์แมนสกอตแลนด์โตเกียว เดนเวอร์อลาสกาอิรัก
                                </small>
                            </div> -->
                        </div>
                    </div>
                    <?php } ?>
                    <div class="col-lg-4 div_learner" style="display: none;">
                        <div class="card card-body" style="min-height: 150px;">
                            <div class="card-title">
                              <div class="row">                                
                                <div class="col-md-12">
                                  <h4 class="card-title m-b-0"><span class="lstick"></span><?php echo label('dash_b_rewardpoint'); ?></h4>
                                </div>
                              </div>
                            </div>
                            <div class="text-center">
                                <h1 class="m-t-0" id="txt_rewardpoint"><?php if(count($arr_year_enroll)>0){ ?>77<?php } else{ echo "-"; }?></h1>                                
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 div_learner" style="display: none;">
                        <div class="card card-body" style="min-height: 150px;">
                            <div class="card-title">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                      <h4 class="card-title m-b-0"><span class="lstick"></span><?php echo label('dash_b_gpa'); ?></h4>
                                    </div>
                                    <!-- <div class="col-lg-6 col-md-6 text-right">
                                        <small class="card-subtitle hidden-sm-down"><a href="javascript:void(0)" class="card-header accordian-style pointer" id="heading11" data-toggle="collapse" data-target="#grade_info" aria-expanded="true" aria-controls="grade_info" style="border: none; padding: 0;"><?php echo label('dash_b_grade_criteria'); ?></a></small>
                                    </div> -->
                                </div>  
                            </div>
                            <div class="text-center">
                                <h1 class="m-t-0" id="txt_gpa"><?php if(count($arr_year_enroll)>0){ ?>B<?php } else{ echo "-"; }?></h1>                                
                            </div>
                            
                            <!-- <div id="grade_info" class="collapse" aria-labelledby="heading11">
                                <hr>
                                <small>
                                    <b>เกณฑ์การตัดเกรดประจำปี 2563</b>
                                    <br>ผู้เรียนจะได้รับเกรด A เมื่อคะแนนสะสมมากกว่าหรือเท่ากับ 80
                                    <br>ผู้เรียนจะได้รับเกรด B เมื่อคะแนนสะสมมากกว่าหรือเท่ากับ 75
                                    <br>ผู้เรียนจะได้รับเกรด C เมื่อคะแนนสะสมมากกว่าหรือเท่ากับ 70
                                    <br>ผู้เรียนจะได้รับเกรด D เมื่อคะแนนสะสมมากกว่าหรือเท่ากับ 65
                                    <br>ผู้เรียนจะได้รับเกรด F เมื่อคะแนนสะสมน้อยกว่า 65
                                </small>
                            </div> -->
                        </div>
                    </div>
                    <div class="col-lg-4 div_learner" style="display: none;">
                        <div class="card card-body" style="min-height: 150px;">
                            <div class="card-title">
                              <div class="row">                                
                                <div class="col-md-12">
                                  <h4 class="card-title m-b-0"><span class="lstick"></span><?php echo label('dash_b_starts'); ?></h4>
                                </div>
                              </div>
                            </div>
                            <div class="text-center">
                                <?php if(count($arr_year_enroll)>0){ ?>
                                <h1 class="m-t-0 text-warning" id="txt_star">
                                </h1>  
                                <?php } else{ echo '<h1 class="m-t-0" >-</h1> '; }?>                              
                            </div>
                        </div>
                    </div>

                    <?php   if(count($fetch_typecos)){ ?>
                    <div class="col-md-12 div_learner" style="display: none;">
                        <div class="card card-body">
                            <div class="card-title">
                              <div class="row">                                
                                <div class="col-md-12">
                                  <h4 class="card-title m-b-0"><span class="lstick"></span><?php echo label('dash_b_course_detail'); ?></h4>
                                </div>
                              </div>
                              <hr>
                            </div>

                            <div id="accordian">
                                <?php   if(count($fetch_typecos)){ 
                                            $numrow = 1;
                                            foreach ($fetch_typecos as $key_typecos => $value_typecos) {
                                ?>
                                <div class="card m-b-0">
                                    <a class="card-header accordian-style <?php if($numrow!=1){?>collapsed<?php } ?> pointer" id="heading11" data-toggle="collapse" data-target="#collapse<?php echo $value_typecos['tc_id']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $value_typecos['tc_id']; ?>"><?php echo $lang=="thai"?$value_typecos['tc_name_th']:$value_typecos['tc_name_en']; ?>  <i class="fas fa-angle-right float-right"></i></a>
                                    <div id="collapse<?php echo $value_typecos['tc_id']; ?>" class="collapse <?php if($numrow==1){?>show<?php }$numrow++; ?>" aria-labelledby="heading11">
                                        <div class="card-body p-t-0">
                                            <div class="row p-t-20">
                                                <div class="col-lg-3 col-md-6 m-t-20">
                                                    <div class="text-center m-b-20">
                                                        <input data-plugin="knob" id="chart_coursetotal<?php echo $value_typecos['tc_id']; ?>" data-width="150" data-height="150" data-linecap="round" data-fgColor="#ec2029" value="0" data-skin="tron" data-angleOffset="0" data-readOnly=true data-thickness=".125" />
                                                        <br><small><?php echo label('dash_b_total'); ?></small>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6 m-t-20">
                                                    <div class="text-center m-b-20">
                                                        <input data-plugin="knob" id="chart_register<?php echo $value_typecos['tc_id']; ?>" data-width="150" data-height="150" data-linecap="round" data-fgColor="#10316b" value="0" data-skin="tron" data-angleOffset="0" data-readOnly=true data-thickness=".125" />
                                                        <br><small><?php echo label('d_coc_total'); ?></small>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6 m-t-20">
                                                    <div class="text-center m-b-20">
                                                        <input data-plugin="knob" id="chart_inprogress<?php echo $value_typecos['tc_id']; ?>" data-width="150" data-height="150" data-linecap="round" data-fgColor="#ffd800" value="0" data-skin="tron" data-angleOffset="0" data-readOnly=true data-thickness=".125" />
                                                        <br><small><?php echo label('d_coip'); ?></small>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3 col-md-6 m-t-20">
                                                    <div class="text-center m-b-20">
                                                        <input data-plugin="knob" id="chart_complete<?php echo $value_typecos['tc_id']; ?>" data-width="150" data-height="150" data-linecap="round" data-fgColor="#9c9fa4" value="0" data-skin="tron" data-angleOffset="0" data-readOnly=true data-thickness=".125" />
                                                        <br><small><?php echo label('dash_b_completed'); ?></small>
                                                    </div>
                                                </div>
                                            </div>                                      
                                            <small><u><?php echo label('preNote'); ?></u> <?php echo $lang=="thai"?$value_typecos['tc_detail_th']:$value_typecos['tc_detail_en']; ?></small>
                                        </div>
                                    </div>
                                </div>
                                <?php       }
                                        } ?>
                            </div>
                            
                            
                        </div>
                    </div>
                    <?php } ?>

                    <div class="col-lg-6 col-md-12 div_learner" style="display: none;">
                        <div class="card card-body" style="min-height: 600px;">
                            <div class="card-title">
                                <div class="row">
                                    <div class="col-md-12 col-lg-6">
                                      <h4 class="card-title m-b-0"><span class="lstick"></span><?php echo label('d_coc_enr'); ?></h4>
                                    </div>
                                    <div class="col-md-12 col-lg-6 text-right">
                                        <small class="card-subtitle hidden-md-down"><a href="<?php echo base_url()."coursemain/my_course"; ?>"><?php echo label('see_more'); ?></a></small>
                                    </div>
                                </div>
                            </div>
                            <hr class="m-0">
                            <div class="row p-t-20">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="incoming_table" class="table table-hover" width="100%">
                                            <style>
                                                div#incoming_table_wrapper.dataTables_wrapper.container-fluid.dt-bootstrap4.no-footer{
                                                    padding:0 !important;
                                                }
                                            </style>
                                            <style type="text/css">
                                            .one-line-ellipsis {
                                                overflow: hidden;
                                                text-overflow: ellipsis;
                                                white-space: pre-wrap; /* css-3 */
                                                white-space: -moz-pre-wrap; /* Mozilla, since 1999 */
                                                white-space: -pre-wrap; /* Opera 4-6 */
                                                white-space: -o-pre-wrap; /* Opera 7 */
                                                word-wrap: break-word; /* Internet Explorer 5.5+ */
                                                display: -webkit-box;
                                                -webkit-line-clamp: 1;
                                                -webkit-box-orient: vertical;  
                                            }

                                            .lesson-name-incoming-table{
                                                width: 336px !important;
                                                max-width: 336px !important;
                                            }

                                            .lesson-name-ongoing-table{
                                                width: 336px !important;
                                                max-width: 336px !important;
                                            }
                                            </style>
                                            <thead>
                                                <tr>
                                                    <th width="40%"><b><?php echo label('dash_b_course_name'); ?></b></th>
                                                    <th width="20%"><b><?php echo label('cetegoryNo'); ?></b></th>
                                                    <th width="10%"><b><?php echo label('m_status'); ?></b></th>
                                                    <th width="20%"><b><?php echo label('dateExpired'); ?></b></th>
                                                    <th width="10%"><b><?php echo label('sv_b_manage'); ?></b></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>   
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 div_learner" style="display: none;">
                        <div class="card card-body" style="min-height: 600px;">
                            <div class="card-title">
                                <div class="row">
                                    <div class="col-md-12 col-lg-6">
                                      <h4 class="card-title m-b-0"><span class="lstick"></span><?php echo label('course_not_register'); ?></h4>
                                    </div>
                                    <div class="col-md-12 col-lg-6 text-right">
                                        <small class="card-subtitle hidden-md-down"><a href="<?php echo base_url()."coursemain/all_courses"; ?>"><?php echo label('see_more'); ?></a></small>
                                    </div>
                                </div>
                            </div>
                            <hr class="m-0">
                            <div class="row p-t-20">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="ongoing_table" class="table table-hover" width="100%">
                                            <style>
                                                div#ongoing_table_wrapper.dataTables_wrapper.container-fluid.dt-bootstrap4.no-footer{
                                                    padding:0 !important;
                                                }
                                            </style>
                                            <thead>
                                                <tr>
                                                    <th width="50%"><center><b><?php echo label('dash_b_course_name'); ?></center></b></th>
                                                    <th width="30%"><center><b><?php echo label('cetegoryNo'); ?></center></b></th>
                                                    <th width="20%"><center><b><?php echo label('sv_b_manage'); ?></center></b></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>   
                            </div>
                        </div>
                    </div>
                    
                    
                </div>             
            </div>

        </div>
    </div>

    <?php $this->load->view('frontend/inc/inc-footer.php'); ?>

      <div id="myModal_process" class="modal fade bs-example-modal-lg" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
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

    <script src="<?php echo REAL_PATH; ?>/assets/plugins/datatables/datatables.min.js"></script>

    <script src="<?php echo REAL_PATH; ?>/assets/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/js/buttons.flash.min.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/js/jszip.min.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/js/pdfmake.min.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/js/vfs_fonts.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/js/buttons.html5.min.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/js/buttons.print.min.js"></script>
    <!-- EASY PIE CHART JS -->
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/Chart.js/Chart.min.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/knob/jquery.knob.js"></script>

    <!-- Horizontal-timeline JavaScript -->
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/horizontal-timeline/js/horizontal-timeline.js"></script>

    <?php //$this->load->view('frontend/java/dashboard_java.php'); ?>
    <script type="text/javascript">

      $( document ).ready(function() {
        $('#show_admin_dashboard').hide();
        $('#survey_admin_learner').hide();
        $('#admin_learner_approve').hide();
        
        $('#course_admin_learner').hide();
        $('#on_going_course_admin_learner').hide();
        $('#in_coming_course_admin_learner').hide();
        <?php if($user['Is_admin']=="1"){ ?>
              $('#show_learner_dashboard_ins').hide();
              $('#show_instructor_dashboard_ins').hide();
              $('#show_admin_dashboard').hide();
              $('#show_learner_dashboard').show();
              $('.div_learner').hide();
              $('.div_instructor').hide();
              $('.div_admin').show();
              onqueryadmin_devicelog();
              onqueryadmin_course();
              onqueryadmin_devicelogbymonth();
              fetch_data_main_alluseradmin(0);
              fetch_data_main_allcourseadmin(0);
        <?php }else{ ?>
              $('#show_learner_dashboard_ins').hide();
              $('#show_instructor_dashboard_ins').hide();
              $('#show_learner_dashboard').hide();
              $('#show_admin_dashboard').show();
              $('.div_admin').hide();
              $('.div_instructor').hide();
              $('.div_learner').show();
              fetch_data_main_ongoninglearner(0);
              fetch_data_main_incominglearner(0);
              onquerylearner_course();
        <?php } ?>
        <?php if($user['Is_instructor']=="1"){ ?>
              $('#show_learner_dashboard_ins').hide();
              $('#show_instructor_dashboard_ins').show();
              $('#show_learner_dashboard').show();
              $('#show_admin_dashboard').hide();
              $('.div_admin').hide();
              $('.div_learner').hide();
              $('.div_instructor').show();
              onqueryadmin_devicelog();
              fetch_data_main_instructor_create(0);
              fetch_data_main_instructor_latest_complete(0);
        <?php } ?>
      });
      function onquerylearner_course(){
        var select_monthstart_learner = $('#select_monthstart_learner').val();
        var select_yearstart_learner = $('#select_yearstart_learner').val();
        var select_monthend_learner = $('#select_monthend_learner').val();
        var select_yearend_learner = $('#select_yearend_learner').val();
        if(select_monthstart_learner!=""&&select_yearstart_learner!=""&&select_monthend_learner!=""&&select_yearend_learner!=""){
                $.ajax({
                    url:"<?=base_url()?>querydata_select/query_learner_course",
                    method:"POST",
                    data:{select_monthstart_learner:select_monthstart_learner,select_yearstart_learner:select_yearstart_learner,select_monthend_learner:select_monthend_learner,select_yearend_learner:select_yearend_learner},
                    dataType:"json",
                    success:function(data)
                    {
                        $('#txt_rewardpoint').text(data.txt_rewardpoint);
                        $('#txt_gpa').text(data.txt_gpa);
                        $('#txt_star').html(data.txt_star);
                    }
                });
                <?php   
                        if(count($fetch_typecos)){ 
                            $numrow = 1;
                            foreach ($fetch_typecos as $key_typecos => $value_typecos) {
                ?>
                $.ajax({
                    url:"<?=base_url()?>querydata_select/query_learner_course_chart",
                    method:"POST",
                    data:{select_monthstart_learner:select_monthstart_learner,select_yearstart_learner:select_yearstart_learner,select_monthend_learner:select_monthend_learner,select_yearend_learner:select_yearend_learner,tc_id:"<?php echo $value_typecos['tc_id']; ?>"},
                    dataType:"json",
                    success:function(data)
                    {
                        $('#chart_coursetotal<?php echo $value_typecos['tc_id']; ?>').val(data.chart_coursetotal);
                        $("#chart_coursetotal<?php echo $value_typecos['tc_id']; ?>").trigger('change');
                        $('#chart_register<?php echo $value_typecos['tc_id']; ?>').val(data.chart_register);
                        $("#chart_register<?php echo $value_typecos['tc_id']; ?>").trigger('change');
                        $('#chart_inprogress<?php echo $value_typecos['tc_id']; ?>').val(data.chart_inprogress);
                        $("#chart_inprogress<?php echo $value_typecos['tc_id']; ?>").trigger('change');
                        $('#chart_complete<?php echo $value_typecos['tc_id']; ?>').val(data.chart_complete);
                        $("#chart_complete<?php echo $value_typecos['tc_id']; ?>").trigger('change');
                    }
                });
                <?php       }
                        }
                ?>
        }
        
        
        
      }
      function onqueryadmin_course(){
        var selectcourse_start_month = $('#selectcourse_start_month').val();
        var selectcourse_start_year = $('#selectcourse_start_year').val();
        var selectcourse_end_month = $('#selectcourse_end_month').val();
        var selectcourse_end_year = $('#selectcourse_end_year').val();
        if(selectcourse_start_month!=""&&selectcourse_start_year!=""&&selectcourse_end_month!=""&&selectcourse_end_year!=""){
                $.ajax({
                    url:"<?=base_url()?>querydata_select/query_admin_course",
                    method:"POST",
                    data:{selectcourse_start_month:selectcourse_start_month,selectcourse_start_year:selectcourse_start_year,selectcourse_end_month:selectcourse_end_month,selectcourse_end_year:selectcourse_end_year},
                    dataType:"json",
                    success:function(data)
                    {
                        $('#chart_course_ongoing').val(data.chart_course_ongoing);
                        $("#chart_course_ongoing").trigger('change');
                        $('#chart_course_incoming').val(data.chart_course_incoming);
                        $("#chart_course_incoming").trigger('change');
                        $('#chart_course_completed').val(data.chart_course_completed);
                        $("#chart_course_completed").trigger('change');
                        $('#chart_course_close').val(data.chart_course_close);
                        $("#chart_course_close").trigger('change');
                    }
                });
        }

      }

        function renderChart_device_log(data) {
              new Chart(document.getElementById("device_log"),
              {
                  "type":"doughnut",
                  options: {
                      aspectRatio: 1,
                      layout: {
                          padding: {
                              left: 0,
                              right: 0,
                              top: 0,
                              bottom: 0,
                          }
                      },
                      responsive: true,
                      legend: {
                          position : 'bottom',
                          labels: {
                            boxWidth: 10
                          }
                      },
                      cutoutPercentage: 80,
                  },
                  "data":{"labels":["Desktop","Tablet","Mobile"],
                  "datasets":[{
                      "label":"My First Dataset",
                      "data":data,
                      "backgroundColor":["#10316b","#c81912","#feb72b"],
                    borderWidth: 1}
                  ]}
              });
        }

        function renderChart_device_logbymonth(data,labels) {
            new Chart(document.getElementById("user_log"),
            {
                "type":"line",
                "data":{"labels":labels,
                "datasets":[{
                                "label":"",
                                "data":data,
                                "fill":false,
                                "borderColor":"#c81912",
                                "backgroundColor" : "#c81912",
                                "borderWidth":1.5,
                                "lineTension":0.5
                                }
                            ]},
                "options":{
                    "scales":{"yAxes":[{"ticks":{"beginAtZero":true}}]},
                    legend: {
                        display: false
                    }
                }
            });
        }

      function fetch_data_main_allcourseadmin(page_num)
         {
            $('#all_course_table').DataTable().destroy();
            var table = $('#all_course_table').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_detail_allcourseadmin/',
                    type : 'GET'
                },
                  "initComplete": function () {
                    setTimeout( function () {
                      var info = table.page.info();
                      var length = info.pages;
                      var page_current = info.page;
                      if((page_num+1)>length){
                        page_num = length-1;
                      }
                      table.page(page_num).draw(false);
                    }, 10 );
                  }
            });
         }

      function fetch_data_main_alluseradmin(page_num)
         {
            $('#all_user_table').DataTable().destroy();
            var table = $('#all_user_table').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_detail_alluseradmin/',
                    type : 'GET'
                },
                  "initComplete": function () {
                    setTimeout( function () {
                      var info = table.page.info();
                      var length = info.pages;
                      var page_current = info.page;
                      if((page_num+1)>length){
                        page_num = length-1;
                      }
                      table.page(page_num).draw(false);
                    }, 10 );
                  }
            });
         }

      function fetch_data_main_ongoninglearner(page_num)
         {
            $('#ongoing_table').DataTable().destroy();
            var table = $('#ongoing_table').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_detail_ongoninglearner/',
                    type : 'GET'
                },
                  "initComplete": function () {
                    setTimeout( function () {
                      var info = table.page.info();
                      var length = info.pages;
                      var page_current = info.page;
                      if((page_num+1)>length){
                        page_num = length-1;
                      }
                      table.page(page_num).draw(false);
                    }, 10 );
                  }
            });
         }

      function fetch_data_main_incominglearner(page_num)
         {
            $('#incoming_table').DataTable().destroy();
            var table = $('#incoming_table').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_detail_incominglearner/',
                    type : 'GET'
                },
                  "initComplete": function () {
                    setTimeout( function () {
                      var info = table.page.info();
                      var length = info.pages;
                      var page_current = info.page;
                      if((page_num+1)>length){
                        page_num = length-1;
                      }
                      table.page(page_num).draw(false);
                    }, 10 );
                  }
            });
         }

      function fetch_data_main_instructor_create(page_num)
         {
            $('#instructor_create').DataTable().destroy();
            var table = $('#instructor_create').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_detail_instructor_create/',
                    type : 'GET'
                },
                  "initComplete": function () {
                    setTimeout( function () {
                      var info = table.page.info();
                      var length = info.pages;
                      var page_current = info.page;
                      if((page_num+1)>length){
                        page_num = length-1;
                      }
                      table.page(page_num).draw(false);
                    }, 10 );
                  }
            });
         }

      function fetch_data_main_instructor_latest_complete(page_num)
         {
            $('#instructor_latest_complete').DataTable().destroy();
            var table = $('#instructor_latest_complete').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_detail_instructor_latest_complete/',
                    type : 'GET'
                },
                  "initComplete": function () {
                    setTimeout( function () {
                      var info = table.page.info();
                      var length = info.pages;
                      var page_current = info.page;
                      if((page_num+1)>length){
                        page_num = length-1;
                      }
                      table.page(page_num).draw(false);
                    }, 10 );
                  }
            });
            $('#course_select_instructor').on('change', function(){
               table.search(this.value).draw();   
            });
         }

      function onqueryadmin_devicelog(){
        var select_month_devicelog = $('#select_month_devicelog').val();
        var select_year_devicelog = $('#select_year_devicelog').val();
        if(select_month_devicelog!=""&&select_year_devicelog!=""){
                $.ajax({
                    url:"<?=base_url()?>querydata_select/query_admin_devicelog",
                    method:"POST",
                    data:{select_month_devicelog:select_month_devicelog,select_year_devicelog:select_year_devicelog},
                    dataType:"json",
                    success:function(data)
                    {
                        renderChart_device_log(data);
                    }
                });
        }
      }
      function onqueryadmin_devicelogbymonth(){
        var select_month_userlog = $('#select_month_userlog').val();
        var select_year_userlog = $('#select_year_userlog').val();
        if(select_month_userlog!=""&&select_year_userlog!=""){
                $.ajax({
                    url:"<?=base_url()?>querydata_select/query_admin_devicelogbymonth",
                    method:"POST",
                    data:{select_month_userlog:select_month_userlog,select_year_userlog:select_year_userlog},
                    dataType:"json",
                    success:function(data)
                    {
                        renderChart_device_logbymonth(data.dataall,data.labels);
                    }
                });
        }
      }



      $('#dashboard').click(function(){
            if($(this).prop("checked") == true){
              $('#show_learner_dashboard_ins').hide();
              $('#show_instructor_dashboard_ins').hide();
              $('#show_admin_dashboard').hide();
              $('#show_learner_dashboard').show();
              $('.div_admin').show();
              $('.div_learner').hide();
              

              onqueryadmin_course();
              onqueryadmin_devicelog();
              onqueryadmin_devicelogbymonth();
              fetch_data_main_alluseradmin(0);
              fetch_data_main_allcourseadmin(0);
            }else if($(this).prop("checked") == false){
              $('#show_learner_dashboard_ins').hide();
              $('#show_instructor_dashboard_ins').hide();
              $('#show_learner_dashboard').hide();
              $('#show_admin_dashboard').show();
              $('.div_admin').hide();
              $('.div_learner').show();
              fetch_data_main_ongoninglearner(0);
              fetch_data_main_incominglearner(0);
              onquerylearner_course();
            }
      });

      $('#dashboard_instructor').click(function(){
            if($(this).prop("checked") == true){
              $('#show_learner_dashboard_ins').hide();
              $('#show_instructor_dashboard_ins').show();
              $('#show_learner_dashboard').hide();
              $('.div_admin').hide();
              $('.div_learner').hide();
              $('.div_instructor').show();

              fetch_data_main_instructor_create(0);
              fetch_data_main_instructor_latest_complete(0);

                $.ajax({
                    url:"<?=base_url()?>querydata_select/recheckcos",
                    method:"POST",
                    success:function(data)
                    {
                        $('#course_select_instructor').html(data);
                    }
                });
            }else if($(this).prop("checked") == false){
              $('#show_learner_dashboard_ins').show();
              $('#show_instructor_dashboard_ins').hide();
              $('#show_learner_dashboard').hide();
              $('#show_admin_dashboard').hide();
              $('.div_admin').hide();
              $('.div_learner').show();
              $('.div_instructor').hide();
              fetch_data_main_ongoninglearner(0);
              fetch_data_main_incominglearner(0);
              onquerylearner_course();
            }
      });

        $(function() {
            $('[data-plugin="knob"]').knob();
        });


      $(document).on('click', '.btn_gotocourse', function(){
            var cos_id = $(this).attr("id");
            window.location.href = '<?php echo base_url()."coursemain/detail/"; ?>'+cos_id;
        });
      $(document).on('click', '.btn_register', function(){
            var cos_id = $(this).attr("id");
                $("#myModal_process").modal({backdrop: false});
            $.ajax({
                  url:"<?=base_url()?>index.php/querydata/enroll_course_byuser",
                  method:"POST",
                  data:{cos_id:cos_id},
                  dataType:"json",
                  success:function(data)
                  {
                      if(data.status=="2"){
                          swal(
                              '<?php echo label("enroll_reuse_success"); ?>',
                              '',
                              'success'
                          ).then(function () {
                            location.reload();
                          })
                      }else if(data.status=="3"){//Wait approve
                          swal({
                            title: '<?php echo label('lrn_b_approver_student'); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label('lrn_btn_ok'); ?>'
                          }).then(function () {
                            location.reload();
                          })
                      }else if(data.status=="1"){//Duplicate
                          swal({
                            title: '<?php echo label('lrn_btn_re_enroll'); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label('lrn_btn_ok'); ?>'
                          }).then(function () {
                            location.reload();
                          })
                      }else if(data.status=="5"){//Seat Full
                          swal({
                            title: '<?php echo label('lrn_p_regis_sub'); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label('lrn_btn_ok'); ?>'
                          }).then(function () {
                            location.reload();
                          })
                      }else if(data.status=="11"){//condition
                          swal({
                            title: '<?php echo label('register_condition'); ?>'+data.msg,
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label('lrn_btn_ok'); ?>'
                          }).then(function () {
                            location.reload();
                          })
                      }else{
                          swal({
                            title: '<?php echo label('lrn_p_data_not_found'); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label('lrn_btn_ok'); ?>'
                          }).then(function () {
                            location.reload();
                          })
                      }
                  }
            });
      });
    </script>
</body>

</html>