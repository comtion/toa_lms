<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/inc/inc-meta.php'); ?>

    <link href="<?php echo HTTP_CSS_PATH; ?>home.css" rel="stylesheet">

    <style>
      @media screen and (max-height: 600px) {
          .footer{
            display: none !important;
          }
      }

      @media (min-width:1025px) {
        .footer-con {
              padding: 0;
        }
      }
      @media (min-width:1400px) {
        .footer-con {
              padding: 25px 15px;
        }
      }

      @supports (-ms-ime-align: auto) {
        .footer-con {
              padding: 0 !important;
        }
      }
    </style>
  </head>
  <body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css  class="fix-header card-no-border fix-sidebar" -->
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
        <?php if (!empty($emp_c)){ $this->load->view('frontend/inc/inc-sidemenu.php'); } ?>
        

        <?php if (empty($emp_c)){?> 
        <style>
          .fix-header.fix-sidebar .page-wrapper{
            padding-top: 70px !important;
          }

        </style>
        <?php } ?>
        <?php if (!empty($emp_c)){?> 
        <style>

        </style>
        <?php } ?>
        
      <div class="page-wrapper"> 
          <div class="container-fluid"> 
             <div class="row banner-text">
                <div class="col-lg-4 col-md-12" style="<?php if (!empty($emp_c)){ ?>display:none;<?php } ?>">
                  <div class="card">
                    <div class="card-body">
                      
                          <form class="form-horizontal form-material" autocomplete="off" id="loginform" method="POST">
                              <h3 class="box-title m-b-20">
                                  <?php echo label('login'); ?>
                              </h3>
                              <div class="form-group ">
                                  <div class="col-md-12">
                                      <input class="form-control" onkeyup="return forceLower(this);" id="inpUname" name="inpUname" type="text" required="" autofocus placeholder="<?php echo label('username') ?>"> </div>
                              </div>
                              <div class="form-group">
                                  <div class="col-md-12">
                                      <input class="form-control chkinputENOnly" id="inpPwd" name="inpPwd" type="password" required="" placeholder="<?php echo label('password') ?>"> 
                                      <span toggle="#inpPwd" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                  </div>
                              </div>
                              <input type="hidden" id="dest" name="dest" value="<?php echo $dest; ?>">
                              <div class="form-group ">
                                    <a href="javascript:void(0)" id="to-recover" class="text-muted float-right"><i class="fa fa-lock"></i> <?php echo label('forgot_pass'); ?></a> 
                              </div>
                              <div class="form-group text-center">
                                  <div class="col-md-12  p-b-20">
                                      <button class="btn btn-block btn-outline-success" id="btnlogin" type="submit"><i class="icon-login"></i> <?php echo label('login') ?></button>
                                  </div>
                              </div>
                          </form>

                          <form class="form-horizontal" id="recoverform" autocomplete="off" method="POST">
                              <div class="form-group ">
                                  <div class="col-md-12">
                                      <h3><?php echo label('forgot_pass'); ?></h3>
                                      <p class="text-muted"><?php echo label('forgot_pass_noti'); ?></p>
                                  </div>
                              </div>
                              <div class="form-group">
                                  <div class="col-md-12">
                                      <input class="form-control" type="text" name="useri" placeholder="<?php echo label('pholder_usn') ?>"> </div>
                              </div>
                              <div class="form-group text-center m-t-20">
                                  <div class="col-md-12">
                                      <button type="reset" value="Reset" class="btn btn-outline-info pull-right return_login"><i class=" fas fa-chevron-circle-left"></i><span> <?php echo label('m_previous'); ?></span></button>
                                      <button class="btn btn-outline-success text-uppercase waves-effect waves-light" type="submit"><?php echo label('m_ok'); ?></button>
                                  </div>
                              </div>
                          </form>
                    </div>
                  </div>
                </div>
                <?php if(isset($pic)&&count($pic)>0){ ?>
                <div class="<?php if (empty($emp_c)){ ?>col-lg-8 col-md-12<?php }else{ ?>col-lg-12<?php } ?>">

                    <div class="card">
                      <?php $da_banner_delay = isset($foote[0]['da_banner_delay'])&&intval($foote[0]['da_banner_delay'])>0?intval($foote[0]['da_banner_delay'])*1000:10000; ?>
                      <div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel" data-interval="<?php echo $da_banner_delay; ?>".,>
                        <ol class="carousel-indicators">
                          <?php if(isset($pic)&&count($pic)>0){
                                  if($pic != null&&$page=='home'){?>
                                      <?php $count_num = 0;$n=1;foreach ($pic as $row) {
                                        if($n==1){ ?>
                                          <li data-target="#carouselExampleIndicators3" data-slide-to="<?php echo $count_num; ?>" class="active" ></li>
                                        <?php }else{?>
                                          <li data-target="#carouselExampleIndicators3" data-slide-to="<?php echo $count_num; ?>"></li>
                                      <?php }$n++;$count_num++;}?>
                            <?php }
                                } ?>
                        </ol>
                        <div class="carousel-inner" role="listbox">

                          <?php if(isset($pic)&&count($pic)>0){
                                  if($pic != null&&$page=='home'){?>
                                      <?php $n=1;foreach ($pic as $row) {
                                            $array_pathext = explode('.', $row['banner']);
                                            $extension = end($array_pathext);
                                        if($n==1){ 
                                          if($extension=="mp4"){
                                      ?>
                                        <div class="carousel-item active"  style="width: 100%; text-align: center; max-height: 350px;">
                                            <video autoplay muted loop alt="First slide" style="width: 100%;">
                                              <source src="<?php echo REAL_PATH;?>/uploads/banner/<?php echo $row['banner']; ?>" type="video/mp4">
                                            </video>
                                        </div>
                                        <?php 
                                          }else{ ?>
                                        <div class="carousel-item active" style="width: 100%; text-align: center; max-height:350px;"> <img class="img-fluid" width="100%" style="max-height:350px;" src="<?php echo REAL_PATH;?>/uploads/banner/<?php echo $row['banner']; ?>" alt="">
                                        </div>
                                        <?php 
                                          }
                                        }else{
                                          if($extension=="mp4"){
                                        ?>
                                        <div class="carousel-item"  style="width: 100%; text-align: center; max-height: 350px;">
                                            <video autoplay muted loop alt="First slide" style="width: 100%;">
                                              <source src="<?php echo REAL_PATH;?>/uploads/banner/<?php echo $row['banner']; ?>" type="video/mp4">
                                            </video>
                                        </div>
                                      <?php 
                                          }else{ ?>
                                        <div class="carousel-item" style="width: 100%; text-align: center; max-height:350px;"> <img class="img-fluid" width="100%" style="max-height:350px;" src="<?php echo REAL_PATH;?>/uploads/banner/<?php echo $row['banner']; ?>" alt="">
                                        </div>
                                      <?php 
                                          }
                                        }$n++;}?>
                            <?php }
                                } ?>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators3" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carouselExampleIndicators3" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> 
                      </div>
                    </div>

                </div>
                <?php } ?>
            </div>
                <?php if (empty($emp_c)){?> 
                <?php if (count($cos_sample)>0){?> 
            <div class="row m-t-20">
                <div class="col-12">
                    <h4 class="d-inline"><?php echo label('sample_course'); ?></h4><br>
                    <small class="text-muted m-t-0"><?php echo label('sample_course_title'); ?> <?php echo date('Y'); ?></small>
                    <div class="card-group card row">
                        <?php foreach ($cos_sample as $key_cos_sample => $value_cos_sample) { 
                                $fetch_employee = $this->func_query->query_row('LMS_EMP','LMS_USP','LMS_EMP.emp_id = LMS_USP.emp_id','','LMS_USP.u_id = "'.$value_cos_sample['cos_createby'].'"');
                                $fetch_division = $this->func_query->query_row('LMS_DIVISION','','','','div_id = "'.$fetch_employee['div_id'].'"');
                                $txt_name = $lang=="thai"?$fetch_employee['fullname_th']:$fetch_employee['fullname_en'];
                                $txt_div = $lang=="thai"?$fetch_division['div_name_th']:$fetch_division['div_name_en'];
                                $cos_lang = explode(',', $value_cos_sample['cos_lang']);
                                $value_cos_sample['isTH'] = in_array('th',$cos_lang)?"1":"0";
                                $value_cos_sample['isENG'] = in_array('eng',$cos_lang)?"1":"0";
                                $cname = "";
                                if($lang=="thai"){
                                    if($value_cos_sample['isTH']=="1"){
                                      $cname = $value_cos_sample['cname_th'];
                                    }else{
                                      if($value_cos_sample['cname_th']==""){
                                        $cname = $value_cos_sample['cname_eng'];
                                      }
                                    }
                                }else if($lang=="english"){
                                    if($value_cos_sample['isENG']=="1"){
                                      $cname = $value_cos_sample['cname_eng'];
                                    }else{
                                      if($value_cos_sample['cname_eng']==""){
                                        $cname = $value_cos_sample['cname_th'];
                                      }
                                    }
                                }
                        ?>
                        <div class="col-3">
                            <img class="card-img-top img-responsive" src="<?php echo REAL_PATH; ?>/uploads/course/<?php echo $value_cos_sample['cos_pic']; ?>" alt="<?php echo $cname; ?>" onerror="this.src='<?php echo REAL_PATH;?>/images/cover_course.jpg';">
                            <div class="card-body">
                                <h4 class="card-title h4-two-line-ellipsis mb-0" alt="<?php echo $cname; ?>"><?php echo $cname; ?></h4>
                                <small class="text-muted small-one-line-ellipsis" alt="<?php echo label('Course_by'); ?> : <?php echo $txt_name; ?> / <?php echo $txt_div; ?>"><?php echo label('Course_by'); ?> : <?php echo $txt_name; ?> / <?php echo $txt_div; ?></small>
                                <button type="button" class="btn btn-block btn-outline-info mt-3 cos_preview" id="<?php echo $value_cos_sample['cos_id']; ?>" data-toggle="modal" data-target=".course-ex-modal" alt="<?php echo label('Preview'); ?>"><i class="mdi mdi-magnify"></i> <?php echo label('Preview'); ?></button>
                            </div>
                        </div>
                        <?php } ?>
                    </div>

                </div>
            </div>
              <?php } ?>
              <?php if(count($web_recom)){ ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card p-b-20">
                        <div class="card-body">
                            <div class="d-flex">
                                <div>
                                    <h3 class="card-title m-b-0"><span class="lstick"></span> <?php echo label('recommended_sites_title'); ?> </h3>
                                    <small class="card-subtitle"><?php echo label('recommended_sites_titledetail'); ?> <?php echo date('Y'); ?></small>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                              <?php foreach ($web_recom as $key_web => $value_web) { 
                                        $web_name = $lang=="thai"?$value_web['web_name_th']:$value_web['web_name_en'];
                              ?>
                                <a class="col-md-2 m-t-20" target="_blank" href="<?php echo $value_web['web_path']; ?>">
                                    <img class="card-img-top img-responsive" src="<?php echo REAL_PATH; ?>/uploads/file_forwebrecommended/<?php echo $value_web['web_pathimg']; ?>" alt="<?php echo $web_name; ?>" onerror="this.src='<?php echo REAL_PATH;?>/images/logo-light-text.png';">
                                </a>
                              <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
                  <?php } ?>
                <?php } ?>
          </div>
      </div>
    </div>
    <?php $this->load->view('frontend/inc/inc-footer.php'); ?>

    <div class="modal fade course-ex-modal" role="dialog" aria-labelledby="myLargeCourseModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeCourseModalLabel"><?php echo label('sample_course'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="img_headcourse" class="card-img-top img-responsive" src="../assets/images/big/img2.jpg" alt="">
                        </div>
                        <div class="col-md-8">
                            <h4 id="txt_headcourse"></h4>
                            <small class="text-muted small-one-line-ellipsis" id="txt_course_by" alt=""></small>
                            <hr>
                            <div style="height: 200px; overflow-y: scroll;" id="txt_detailcourse">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn waves-effect waves-light btn-outline-secondary" data-dismiss="modal">ปิด</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- This is for the animation -->
    <script src="<?php echo REAL_PATH;?>/assets/plugins/aos/dist/aos.js"></script>
    <script src="<?php echo REAL_PATH;?>/assets/plugins/prism/prism.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="<?php echo REAL_PATH;?>/assets/js/perfect-scrollbar.jquery.min.js"></script>
    <!--Menu sidebar -->
    <script src="<?php echo REAL_PATH; ?>/assets/js/sidebarmenu.js"></script>
    <script type="text/javascript">
      document.getElementById('inpPwd').addEventListener('keypress', function(event) {
        if (event.keyCode == 13) {
            document.getElementById('btnlogin').click();
        }
      });
      $(function(){
          $(".chkinputENOnly").keypress(function(event){
              var ew = event.which;
              if(ew == 32)
                  return true;
              if(48 <= ew && ew <= 57)
                  return true;
              if(65 <= ew && ew <= 90)
                  return true;
              if(97 <= ew && ew <= 122)
                  return true;
              return false;
          });
      });
      $(".toggle-password").click(function() {

        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
          input.attr("type", "text");
        } else {
          input.attr("type", "password");
        }
      });
      function forceLower(strInput) 
      {
        strInput.value=strInput.value.toLowerCase();
      }
    $("#recoverform").slideUp();
    //document.getElementById('recoverform').style.display = "none";
      /*$(document).ready(function() {
        $(document).on('submit', '#register_form', function(event){
              event.preventDefault(); 
              document.getElementById("action").disabled = true;
                $.ajax({
                  url:"<?=base_url()?>index.php/manage/register_user",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  success:function(data)
                  {

                    document.getElementById("action").disabled = false;
                    if(data=="2"){
                        $('#register_form')[0].reset();
                        $('#modal-register').modal('hide');
                        swal({
                            title: "<?php echo label("com_msg_success"); ?>",
                            text: "",
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                          location.reload();
                        })
                    }else if(data=="1"){
                        swal({
                            title: "<?php echo label("com_msg_duplicate"); ?>",
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                        })
                    }else{
                        swal({
                            title: "<?php echo label("com_msg_error_save"); ?>",
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        })
                    }
                   
                  }
                });
            });
      });*/
      



         $(document).on('click', '.cos_preview', function(){
            var cos_id = $(this).attr("id");
            $.ajax({
              url:"<?=base_url()?>index.php/querydata/query_cos_preview",
              method:"POST",
              data:{cos_id:cos_id},
              dataType:"json",
              success:function(data)
              {
                  $('#img_headcourse').attr('src', data.img_headcourse);
                  $('#txt_headcourse').html(data.txt_headcourse);
                  $('#txt_course_by').html(data.txt_course_by);
                  $('#txt_detailcourse').html(data.txt_detailcourse);
              }
            });
          });
         $(document).on('click', '.readmore', function(){
            var id = $(this).attr("id");
            var title = $(this).attr("title");
            var detail = $(this).attr("detail");
            $('#modal-readmore').modal('show');
            $('#title_readmore').text(title);
            $('#detail_readmore').html(detail);
          });
         $(document).on('click', '.btn_example', function(){
            var id = $(this).attr("id");
            $.ajax({
              url:"<?=base_url()?>index.php/course/update_course_data",
              method:"POST",
              data:{id_update:id},
              dataType:"json",
              success:function(data)
              {
                <?php if($lang=="thai"){ ?>
                  $('#txt_coursehead').text(data.cname_th);
                  $('#description_course').html(data.cdesc_th);
                <?php }else{ ?>
                  $('#txt_coursehead').text(data.cname_en);
                  $('#description_course').html(data.cdesc_en);
                <?php } ?>
                rating_course(data.cos_rating);
                document.getElementById("img_coursehead").src = "<?php echo REAL_PATH;?>/uploads/course/"+data.pic;
                $("#img_coursehead").on("error", function(){
                    $(this).attr('src', '<?php echo REAL_PATH;?>/uploads/course/default_profile.jpg');
                });
              }
            });
          });
         function rating_course(rating_course){
            var str = 'Rating : ';
            for (var i = 1; i <=parseInt(rating_course); i++) {
              str += '<i class="fa fa-star text-warning"></i>';
            }
            for (var i = 1; i <=(5-parseInt(rating_course)); i++) {
              str += '<i class="fa fa-star text-default"></i>';
            }
            $('#rating_course').html(str);
         }
         function run_analytic(cos_id){
            window.location.href = '<?=base_url()?>course/analytic_course/'+cos_id;
         }

         $(document).on('click', '.btn_detail', function(){
            var id = $(this).attr("id");
            window.location.href = '<?=base_url()?>index.php/course/detail/'+id+'/<?php echo "1"; ?>';
          });
          $(document).on('submit', '#recoverform', function(event){
              event.preventDefault(); 
              var username = $('#useri').val();
                $.ajax({
                  url:"<?=base_url()?>index.php/dashboard/resetPassSubmit",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  dataType:'json',
                  success:function(data)
                  {
                    if(data.rs==true){
                        $('#recoverform')[0].reset();

                        swal({
                            title: data.msg,
                            text: "",
                            type: 'success',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                          window.location.href = '<?php echo base_url()."index.php/home"; ?>';
                          //window.location.href = '<?php echo base_url()."contact/form_chk/"; ?>'+data.emp_id+'/';
                        })
                    }else{
                        swal({
                            title: data.msg,
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            window.location.href = '<?php echo base_url()."index.php/home"; ?>';
                        })
                    }                   
                  }
                });
            });
          
          $(document).on('submit', '#loginform', function(event){
              event.preventDefault(); 
              var username = $('#inpUname').val();
              var password = $('#inpPwd').val();
              var dest = $('#dest').val();
                $.ajax({
                  url:"<?=base_url()?>index.php/dashboard/chk_login",
                  method:'POST',
                  data:new FormData(this),
                  dataType: 'json',
                  cache: false,
                  processData: false,
                  contentType: false,
                  timeout: 15000,
                  async: true,
                  headers: {
                    "cache-control": "no-cache"
                  },
                  success:function(data)
                  {
                    if(data.status_msg=="complete"){
                        $('#loginform')[0].reset();
                        $.ajax({
                          url:"<?=base_url()?>index.php/dashboard/chk_firsttime_user",
                          method:'POST',
                          data:{username:username,password:password,dest:dest},
                          dataType: 'json',
                          success:function(data_chk)
                          {
                            if(data_chk.status=="0"){
                                swal({
                                    title: '<?php echo label("login_msg"); ?>',
                                    text: "",
                                    type: 'success',
                                    showCancelButton: false,
                                    confirmButtonClass: 'btn btn-primary',
                                    confirmButtonText: '<?php echo label("m_ok"); ?>'
                                }).then(function () {
                                  window.location.href = data_chk.redirect_val;
                                })
                            }else if(data_chk.status=="4"){
                                swal({
                                    title: '<?php echo label("login_passexpire"); ?>',
                                    text: "",
                                    type: 'warning',
                                    showCancelButton: false,
                                    confirmButtonClass: 'btn btn-primary',
                                    confirmButtonText: '<?php echo label("m_ok"); ?>'
                                }).then(function () {
                                  window.location.href = data_chk.redirect_val;
                                })
                            }else{
                                swal({
                                    title: '<?php echo label("login_firsttime"); ?>',
                                    text: "",
                                    type: 'success',
                                    showCancelButton: false,
                                    confirmButtonClass: 'btn btn-primary',
                                    confirmButtonText: '<?php echo label("m_ok"); ?>'
                                }).then(function () {
                                  window.location.href = data_chk.redirect_val;
                                })
                            }
                          }
                        });
                        
                    }else if(data.status_msg=="company_expire"){
                        swal({
                            title: '<?php echo label("msg_company_expire"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            $('#inpPwd').val('');
                            $('#inpPwd').focus();
                        })
                    }else if(data.status_msg=="account_locked"){
                        swal({
                            title: '<?php echo label("account_locked"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            window.location.href = '<?php echo base_url()."contact/form_chk/"; ?>'+data.emp_id+'/<?php echo $lang; ?>/';
                        })
                    }else if(data.status_msg=="login_failed_4_time"){
                        swal({
                            title: '<?php echo label("login_failed_4_time"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            $('#inpPwd').val('');
                            $('#inpPwd').focus();
                        })
                    }else if(data.status_msg=="login_failed"){
                        swal({
                            title: '<?php echo label("login_failed"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            $('#inpPwd').val('');
                            $('#inpPwd').focus();
                        })
                    }else if(data.status_msg=="notfound"){
                        swal({
                            title: '<?php echo label("datauser_notfound"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            $('#inpUname').val('');
                            $('#inpPwd').val('');
                            $('#inpUname').focus();
                        })
                    }else if(data.status_msg=="passnotfound"){
                        swal({
                            title: '<?php echo label("password_failed"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            $('#inpPwd').val('');
                            $('#inpPwd').focus();
                        })
                    }
                   
                  }
                });
            });
        $(function() {
            $(".preloader").fadeOut();
        });
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });
        // ============================================================== 
        // Login and Recover Password 
        // ============================================================== 
        $('#to-recover').on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
            document.getElementById('loginform').style.display = "none";
            document.getElementById('recoverform').style.display = "";
        });
        $('.btn_register').on("click",function(){
            $('#modal-register').modal('show');

              document.getElementById("action").disabled = false;
        });
        $('.return_login').on("click", function(){
            document.getElementById("inpUname").focus();
            $("#loginform").fadeIn();
            $("#recoverform").slideUp();
            document.getElementById('loginform').style.display = "";
            document.getElementById('recoverform').style.display = "none";
        });
        function register_course(id,enroll_seat,seat_count){
            if((parseInt(enroll_seat)+1)<parseInt(seat_count)){
              status = "1";
            }else{
              status = "0";
            }
            if(parseInt(seat_count)==0){
              status = "1";
            }
                    $.ajax({
                      url:"<?=base_url()?>index.php/course/register_course",
                      method:'POST',
                      data:{cos_id:id,status:status},
                      success:function(data)
                      {
                        if(data=="2"){
                            swal(
                                '<?php echo label("enroll_reuse_success"); ?>!',
                                '',
                                'success'
                            ).then(function () {
                              window.location.href = '<?=base_url()?>index.php/course/detail/'+id;
                            })
                        }else{
                            swal({
                                title: '<?php echo label("enroll_reuse_error"); ?>',
                                text: "",
                                type: 'warning',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-primary',
                                confirmButtonText: '<?php echo label("m_ok"); ?>'
                            }).then(function () {
                                location.reload();
                            })
                        }
                       
                      }
                    });
        }
         /*$(document).on('click', '.btn_register', function(){
            var id = $(this).attr("id");
            var enroll_seat = '<?php echo $courses['enroll_seat'] ?>';
            var seat_count = '<?php echo $courses['seat_count'] ?>';
            
          });*/
    </script>
  </body>
</html>
