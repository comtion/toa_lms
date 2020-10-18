<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/inc/inc-meta.php'); ?>
<?php 
?>
    <link href="<?php echo REAL_PATH;?>/assets/css/footers.css" rel="stylesheet">
    <link href="<?php echo REAL_PATH;?>/assets/plugins/aos/dist/aos.css" rel="stylesheet">
    <link href="<?php echo REAL_PATH;?>/assets/plugins/prism/prism.css" rel="stylesheet">
    <style type="text/css">
    </style>
  </head>
  <body class="fix-header fix-sidebar">

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
        <div class="page-wrapper">
          <div class="container-fluid">
                 <div class="row col-12 page-titles">
                  <div class="col-md-12 card">
                    <div class="card-body row">
                      <div class="col-md-12" align="center">
                        <h4><?php echo label('contact_locked'); ?></h4>
                      </div>
                      <div class="col-md-12 right">
                                <form class="form-material m-t-40" id="contact_form" name="contact_form" autocomplete="off">
                                    <div class="form-group">
                                        <label><b style="color: #FF2D00">*</b><?php echo label('com_contact'); ?></label>
                                        <input type="text" class="form-control form-control-line" required id="contact_name" name="contact_name"> 
                                    </div>
                                    <div class="form-group">
                                        <label><b style="color: #FF2D00">*</b><?php echo label('com_tel'); ?></span></label>
                                        <input type="text" class="form-control form-control-line" required id="contact_tel" name="contact_tel">
                                    </div>
                                    <div class="form-group">
                                        <label><b style="color: #FF2D00">*</b><?php echo label('com_mail'); ?></span></label>
                                        <input type="text" class="form-control form-control-line" required id="contact_mail" name="contact_mail">
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo label('contamess'); ?></label>
                                        <textarea class="form-control" rows="5" id="contact_msg" name="contact_msg"></textarea>
                                    </div>
                                    <input type="hidden" id="contact_about" name="contact_about" value="<?php echo $foote[0]['da_email_b']; ?>">
                                    <input type="hidden" id="emp_id" name="emp_id" value="<?php echo $emp_id; ?>">

                                    <div class="form-actions " align="center">
                                        <button type="submit" class="btn btn-success"> <i class="mdi mdi-send"></i> <?php echo label('sent'); ?></button>
                                        <button type="reset" class="btn btn-danger close_contact"><?php echo label('cancel'); ?></button>
                                    </div>
                                </form>
                      </div>
                    </div>
                  </div>
                </div>
          </div>

        </div>
            <?php $this->load->view('frontend/inc/inc-footer.php'); ?>
    </div>
    
    <!-- This is for the animation -->
    <script src="<?php echo REAL_PATH;?>/assets/plugins/aos/dist/aos.js"></script>
    <script src="<?php echo REAL_PATH;?>/assets/plugins/prism/prism.js"></script>
    <script type="text/javascript">
    $('.slimtest1').perfectScrollbar();

        $(document).on('click', '.close_contact', function(){
            window.location.href = '<?php echo base_url()."dashboard/login"; ?>';
        });
        $(document).on('submit', '#contact_form', function(event){
              var tid = $('#tid').val();
              event.preventDefault(); 
                $.ajax({
                  url:"<?=base_url()?>index.php/home/send_message",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  dataType : "json",
                  success:function(data)
                  {
                    if(data.status=="2"){
                        swal(
                            '<?php echo label("sent_msg"); ?>!',
                            '',
                            'success'
                        ).then(function () {
                          window.location.href = '<?php echo base_url()."dashboard/login"; ?>';
                        })
                    }else if(data.status=="11"){
                        swal({
                            title: '<?php echo label("datauser_notfound"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        })
                    }else{
                        swal({
                            title: '<?php echo label("com_msg_error_save"); ?>',
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
    </script>
  </body>
</html>
