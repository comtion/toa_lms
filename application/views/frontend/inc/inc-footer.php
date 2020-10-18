<!--footer-->
<style type="text/css">
    .general-listing {
      padding: 0px;
      margin: 0px; }
      .general-listing li {
        list-style: none; }
        .general-listing li a {
          color: #8d97ad;
          display: -webkit-box;
          display: -ms-flexbox;
          display: flex;
          padding: 10px 0;
          -webkit-transition: 0.2s ease-in;
          -o-transition: 0.2s ease-in;
          transition: 0.2s ease-in;
          -webkit-box-align: center;
          -ms-flex-align: center;
          align-items: center; }
        .general-listing li:hover a {
          color: #316ce8;
          padding-left: 10px; }
        .general-listing li i {
          margin-right: 7px;
          vertical-align: middle; }
      .general-listing.two-part li {
        width: 49%;
        display: inline-block; }
      .general-listing.only-li li {
        padding: 5px 0; }
</style>
    <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@7.1.0/dist/promise.min.js"></script>

                                <div id="idle-timeout-dialog" data-backdrop="static" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title"><?php echo label('msg_session'); ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <p>
                                                    <i class="fa fa-warning font-red"></i> <?php echo label('lock_session'); ?>
                                                    <span id="idle-timeout-counter"></span> <?php echo label('second'); ?></p>
                                                <p><?php echo label('question_session'); ?></p>
                                            </div>
                                            <div class="modal-footer text-center">
                                                <button id="idle-timeout-dialog-keepalive" type="button" class="btn btn-success" data-dismiss="modal"><?php echo label('yes_session'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    <!--  background-image:url(<?php echo REAL_PATH; ?>/assets/images/bg.jpg) -->
                    <footer class="text-muted footer-font footer-logo-section" >
                      <div class="container-fluid footer-con">
                        <div class="row">
                          <div class="col-sm-6 col-lg-2 position-relative mt-auto mb-auto">
                            <div style="text-align:left;">
                              <div style="padding:15px; padding-left: 0px;">
                                <img src="<?php echo $foote[0]['da_logo_footer']; ?>" alt="" class="dark-logo img-fluid" />
                              </div>
                          </div>
                          </div>
                          <div class="col-sm-12 col-lg-5">
                            <div style="text-align:left;">
                              <div style="padding-top:15px">
                                <div class="d-flex">
                                  <div class="align-self-center">
                                    <h5 class="footer-font" style="  font-size: 15px !important;">
                                    <b><?php if($lang=="thai"){ echo $foote[0]['da_company_th']; }else{ echo $foote[0]['da_company_en'];} ?></b></h5>
                                    <h6 class="footer-font" style=" font-weight:300; font-size: 14px !important;" class=""><?php if($lang=="thai"){ echo $foote[0]['da_address_th']; }else{ echo $foote[0]['da_address_en']; }?></h6>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <style type="text/css">
                            .email-font{
                              font-size: 14px !important;
                            }

                            @media only screen 
                            and (min-device-width : 768px) 
                            and (max-device-width : 1024px) 
                            and (orientation : landscape) {
                              .email-font{
                                font-size: 12px !important;
                              }
                            }
                          </style>
                          <div class="col-sm-12 col-lg-3">
                            <div style="text-align:left;">
                              <div style="padding-top:15px">
                                <div class="d-flex">
                                  <div class="align-self-center">
                                    <?php if($foote[0]['da_contact_main']!=""){ ?><h5 class="footer-font"><i class="mdi mdi-phone"></i> <a class="footer-font"  href="tel:<?php echo $foote[0]['da_contact_main'];?>" target="_blank" style=" font-size: 14px !important;"><?php echo $foote[0]['da_contact_main'];?></a></h5><?php } ?>
                                    <?php if($foote[0]['da_contact_fax']!=""){ ?><h5 class="footer-font"><i class="mdi mdi-fax"></i> <a class="footer-font" href="tel:<?php echo $foote[0]['da_contact_fax'];?>" target="_blank" style=" font-size: 14px !important;"><?php echo $foote[0]['da_contact_fax'];?></a></h5><?php } ?>
                                    <?php if($foote[0]['da_email_b']!=""){ ?><h5 class="footer-font"><i class="mdi mdi-email"></i> <a class="footer-font"  href="mailto:<?php echo $foote[0]['da_email_b'];?>" target="_blank" style="" class="email-font"><?php echo $foote[0]['da_email_b'];?></a></h5><?php } ?>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12 col-lg-2">
                            <div style="text-align:left;">
                              <div style="padding-top:15px">
                                <div class="d-flex">
                                  <div class="align-self-center ">
                                    <h5 class="footer-font" style="font-size:14px !important;"><a class="footer-font" href="<?php echo REAL_PATH;?>/home" target="_blank"><i class="fa fa-angle-right"></i> <?php echo label('home'); ?></a></h5>
                                    <h5 class="footer-font" style="font-size:14px !important;"><a class="footer-font" href="https://www.toagroup.com/" target="_blank"><i class="fa fa-angle-right"></i> <?php echo label('about'); ?></a></h5>
                                    <h5 class="footer-font" style="font-size:14px !important;"><a class="footer-font" href="<?php echo REAL_PATH;?>/home/faq" target="_blank"><i class="fa fa-angle-right"></i> <?php echo label('faq'); ?></a></h5>
                                    <h5 class="footer-font" style="font-size:14px !important;"><a class="footer-font" href="<?php echo REAL_PATH;?>/home/privacy_policy" target="_blank"><i class="fa fa-angle-right"></i> <?php echo label('privacy_policy'); ?></a></h5>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12 col-lg-2">
                            <button onclick="topFunction()" class="form-control btn btn-success" id="myBtn" title="<?php echo label('back_to_top'); ?>"><i class="mdi mdi-chevron-double-up"></i></button>
                          </div>
                          <script type="text/javascript">

                            function topFunction() {
                              document.body.scrollTop = 0;
                              document.documentElement.scrollTop = 0;
                            }
                          </script>
                          <!-- ============================================================== --> 
                          <!-- End PAge Content --> 
                          <!-- ============================================================== --> 
                          
                        </div>
                        <!-- ============================================================== --> 
                        <!-- End Container fluid  --> 
                        <!-- ============================================================== --> 
                        
                      </div>
                    </footer>
                    <footer class="footer-bg footer-font" style="cursor: pointer; padding:10px 15px; text-align:center">© <b class="footer-font" <?php if($foote[0]['da_website']!=""){ ?>onclick="window.open('<?php echo $foote[0]['da_website'];?>', '_blank')"<?php } ?>><?php echo $foote[0]['da_copyright'];?></b> <?php if($foote[0]['da_facebook']!=""){ ?><a href="<?php echo $foote[0]['da_facebook']; ?>" target="_blank" class="link p-10" title="Facebook"><i class="mdi mdi-facebook-box"></i></a><?php } ?> <?php if($foote[0]['da_twitter']!=""){ ?><a href="<?php echo $foote[0]['da_twitter']; ?>" target="_blank" class="link p-10" title="Twitter"><i class="mdi mdi-twitter-box"></i></a><?php } ?>
                      </div>
                    </footer>
    <!-- <script src="<?php echo REAL_PATH; ?>/assets/plugins/bootstrap/js/popper.min.js"></script> -->
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/sweetalert/sweetalert.min.js"></script>

    <!-- Session-timeout-idle -->
   <!--  <script src="<?php echo REAL_PATH; ?>/assets/plugins/session-timeout/jquery.sessionTimeout.min.js"></script> -->
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/session-timeout/idle/jquery.idletimeout.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/session-timeout/idle/jquery.idletimer.js"></script>
    <script type="text/javascript">
                            window.onscroll = function() {scrollFunction()};

                            function scrollFunction() {
                              var footerHeight = $('footer').outerHeight();
                              if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                                document.getElementById("myBtn").style.display = "block";
                              } else {
                                document.getElementById("myBtn").style.display = "none";
                              }
                            }
                            $( window ).scroll(function() {
                              scrollFunction();
                            });
      var UIIdleTimeout = function() {
          return {
              init: function() {
                  var o;
                  $("body").append(""), $.idleTimeout("#idle-timeout-dialog", ".modal-content button:last", {
                      idleAfter: 1800, //59 min 3540 //30 min 1800
                      timeout: 3e4,
                      pollingInterval: 1800,
                      serverResponseEquals: "OK",
                      onTimeout: function() {
                          window.location = "<?php echo REAL_PATH;?>/dashboard/logout?redirect=<?php echo $page; ?>";
                      },
                      onIdle: function() {
                          $("#idle-timeout-dialog").modal("show"), o = $("#idle-timeout-counter"), $("#idle-timeout-dialog-keepalive").on("click", function() {
                              $("#idle-timeout-dialog").modal("hide");
                              location.reload();
                          })
                      },
                      onCountdown: function(e) {
                          o.html(e)
                      }
                  })
              }
          }
      }();
      jQuery(document).ready(function() {
        <?php if(!empty($user)){ ?>
          UIIdleTimeout.init()
        <?php } ?>
      });
      <?php if(!empty($emp_c)){ ?>
      setInterval(function(){ 
                $.ajax({
                  url:"<?php echo base_url();?>index.php/querydata/chk_logout",
                  method:"POST",
                  dataType:"json",
                  success:function(data)
                  {
                    if(data.status=="0"){
                          window.location = "<?php echo REAL_PATH;?>/dashboard/logout?redirect=<?php echo $page; ?>";
                    }
                  }
                });
      }, 20000);
      <?php } ?>
    </script>
<!--     <script src="<?php echo REAL_PATH; ?>/assets/plugins/bootstrap/js/popper.min.js"></script> -->
    <!-- <script src="<?php echo REAL_PATH; ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script> -->
    <!--Menu sidebar -->
    <script src="<?php echo REAL_PATH; ?>/assets/js/sidebarmenu.js"></script>