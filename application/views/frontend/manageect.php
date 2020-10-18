<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/inc/inc-meta-dashboard.php'); ?>
    <!-- Dropzone css -->
    <link href="<?php echo REAL_PATH; ?>/assets/plugins/dropzone-master/dist/dropzone.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?php echo REAL_PATH; ?>/assets/plugins/datatables/media/css/dataTables.bootstrap4.css">
</head>

    <!-- Dropzone css -->
    <link href="../assets/plugins/dropzone-master/dist/dropzone.css" rel="stylesheet" type="text/css" />
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
                        <b><?php echo ucwords(strtolower($title)); ?></b>
                    </div>
                    <div class="col-md-7 align-self-right">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo REAL_PATH;?>/dashboard"><?php echo ucwords(label('dashboard')); ?></a></li>
                            <?php if($title_main!=""){ ?>
                            <li class="breadcrumb-item active"><?php echo ucwords(strtolower($title_main)); ?></li>
                            <?php } ?>
                            <li class="breadcrumb-item active"><?php echo ucwords(strtolower($title)); ?></li>
                        </ol>
                    </div>
                </div>  
                <form enctype="multipart/form-data" method="POST" id="about_form" name="about_form" class="form-horizontal p-t-20">
                <input type="hidden" id="da_id" name="da_id" value="1">
                <div class="row col-12 page-titles">
                  
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down"><?php echo label('ManageDATA'); ?></span></a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#welcome_msg" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down"><?php echo label('pdpa_content'); ?></span></a> </li>
                    </ul>
                    <!-- Tab panes -->
                    <div class="tab-content tabcontent-border">
                        <div class="tab-pane active card card-body" id="home" role="tabpanel">
                            <div class="card-body row">
                              <div class="form-group col-md-6">
                                    <label class="control-label text-right"><?php echo label('faqttn'); ?> <?php echo label('acro_en'); ?>:</label>
                                    <input required name="da_title_en" id="da_title_en" class="form-control" value="<?php echo $data_fetch["da_title_en"]; ?>" type="text">
                              </div>
                              <div class="form-group col-md-6">
                                    <label class="control-label text-right"><?php echo label('faqttn'); ?> <?php echo label('acro_th'); ?>:</label>
                                    <input required name="da_title_th" id="da_title_th" class="form-control" value="<?php echo $data_fetch["da_title_th"]; ?>" type="text">
                              </div>
                              <div class="form-group col-md-6">
                                    <label class="control-label text-right"><?php echo label('sv_b_company'); ?> <?php echo label('acro_en'); ?>:</label>
                                    <input required name="da_company_en" id="da_company_en" class="form-control" value="<?php echo $data_fetch["da_company_en"]; ?>" type="text">
                              </div>
                              <div class="form-group col-md-6">
                                    <label class="control-label text-right"><?php echo label('sv_b_company'); ?> <?php echo label('acro_th'); ?>:</label>
                                    <input required name="da_company_th" id="da_company_th" class="form-control" value="<?php echo $data_fetch["da_company_th"]; ?>" type="text">
                              </div>
                              <div class="form-group col-md-12">
                                  <label class="control-label text-right"><?php echo label('m_address'); ?> <?php echo label('acro_en'); ?>:</label>
                                  <textarea name="da_address_en" id="da_address_en" class="form-control" style="width: 100%" rows="4"><?php echo $data_fetch["da_address_en"]; ?></textarea>
                              </div>
                              <div class="form-group col-md-12">
                                  <label class="control-label text-right"><?php echo label('m_address'); ?> <?php echo label('acro_th'); ?>:</label>
                                  <textarea  name="da_address_th" id="da_address_th" class="form-control" style="width: 100%" rows="4"><?php echo $data_fetch["da_address_th"]; ?></textarea>
                              </div>
                              <div class="form-group col-md-6">
                                    <label class="control-label text-right"><?php echo label('com_tel'); ?>:</label>
                                    <input required name="da_contact_main" id="da_contact_main" class="form-control" value="<?php echo $data_fetch["da_contact_main"]; ?>" type="text">
                              </div>
                              <div class="form-group col-md-6">
                                    <label class="control-label text-right"><?php echo label('com_fax'); ?>:</label>
                                    <input required name="da_contact_fax" id="da_contact_fax" class="form-control" value="<?php echo $data_fetch["da_contact_fax"]; ?>" type="text">
                              </div>
                              <!-- <div class="form-group col-md-6">
                                    <label class="control-label text-right">E-Mail A</label>
                                    <input required name="da_email_a" id="da_email_a" class="form-control" value="<?php echo $data_fetch["da_email_a"]; ?>" type="text">
                              </div> -->
                              <input type="hidden" id="da_email_a" name="da_email_a" value="<?php echo $data_fetch["da_email_a"]; ?>">
                              <div class="form-group col-md-6">
                                    <label class="control-label text-right"><?php echo label('com_mail'); ?>:</label>
                                    <input required name="da_email_b" id="da_email_b" class="form-control" value="<?php echo $data_fetch["da_email_b"]; ?>" type="text">
                              </div>
                              <div class="form-group col-md-6">
                                    <label class="control-label text-right">Copyright:</label>
                                    <input required name="da_copyright" id="da_copyright" class="form-control" value="<?php echo $data_fetch["da_copyright"]; ?>" type="text">
                              </div>
                              <div class="form-group col-md-4">
                                    <label class="control-label text-right">Website:</label>
                                    <input required name="da_website" id="da_website" class="form-control" value="<?php echo $data_fetch["da_website"]; ?>" type="text">
                              </div>
                              <div class="form-group col-md-4">
                                    <label class="control-label text-right">Facebook:</label>
                                    <input name="da_facebook" id="da_facebook" class="form-control" value="<?php echo $data_fetch["da_facebook"]; ?>" type="text">
                              </div>
                              <div class="form-group col-md-4">
                                    <label class="control-label text-right">Twitter:</label>
                                    <input name="da_twitter" id="da_twitter" class="form-control" value="<?php echo $data_fetch["da_twitter"]; ?>" type="text">
                              </div>
                              <div class="form-group col-md-6">
                                    <label class="control-label text-right"><?php echo label('privacy_policy'); ?> <?php echo label('acro_en'); ?>:</label>
                                    <textarea name="da_privacy_policy_en" id="da_privacy_policy_en" class="form-control texteditor" style="width: 100%" rows="4"><?php echo $data_fetch["da_privacy_policy_en"]; ?></textarea>
                              </div>
                              <div class="form-group col-md-6">
                                    <label class="control-label text-right"><?php echo label('privacy_policy'); ?> <?php echo label('acro_th'); ?>:</label>
                                    <textarea name="da_privacy_policy_th" id="da_privacy_policy_th" class="form-control texteditor" style="width: 100%" rows="4"><?php echo $data_fetch["da_privacy_policy_th"]; ?></textarea>
                              </div>

                              <div class="col-md-12">
                                    <hr>
                              </div>
                              <div class="form-group col-md-6">
                                    <label class="control-label text-right"><?php echo label('com_logo_top'); ?>:</label>
                                    <input type="file" name="da_logo_top" id="da_logo_top" class="dropify_icon" accept="image/png" src="<?php echo REAL_PATH;?>/images/logo.png" />
                              </div>
                              <div class="form-group col-md-6">
                                    <label class="control-label text-right"><?php echo label('com_logo_elearning'); ?>:</label>
                                    <input type="file" name="da_logo_elearning" id="da_logo_elearning" class="dropify_icon" accept="image/png" src="<?php echo REAL_PATH;?>/images/elearning_logo.png" />
                              </div>
                              <div class="form-group col-md-6">
                                    <label class="control-label text-right"><?php echo label('com_logo_footer'); ?>:</label>
                                    <input type="file" name="da_logo_footer" id="da_logo_footer" class="dropify_icon" accept="image/png" src="<?php echo REAL_PATH;?>/images/logo_white.png" />
                              </div>
                              <div class="form-group col-md-6">
                                    <label class="control-label text-right"><?php echo label('com_background_footer'); ?>:</label>
                                    <input type="file" name="da_footer_background" id="da_footer_background" class="dropify_icon" accept="image/jpg" src="<?php echo REAL_PATH;?>/images/bg.jpg" />
                              </div>
                              <div class="form-group col-md-4">
                                    <label class="control-label text-right"><?php echo label('banner_delay'); ?>:</label>
                                    <input name="da_banner_delay" id="da_banner_delay" class="form-control" value="<?php echo $data_fetch["da_banner_delay"]; ?>" type="text">
                              </div>
                              <div class="col-md-12">
                                    <hr>
                              </div>
                            </div>
                        </div>
                        <div class="tab-pane  p-20 card card-body" id="welcome_msg" role="tabpanel">

                            <div class="card-body row">
                              <div class="form-group col-md-6">
                                    <label class="control-label text-right"><?php echo label('sv_b_title'); ?> <?php echo label('acro_en'); ?>:</label>
                                    <input name="da_wctitle_en" id="da_wctitle_en" class="form-control" value="<?php echo $data_fetch["da_wctitle_en"]; ?>" type="text">

                                    <label class="control-label text-right"><?php echo label('message'); ?> <?php echo label('acro_en'); ?>:</label>
                                    <textarea name="da_wcmessage_en" id="da_wcmessage_en" class="form-control texteditor" style="width: 100%" rows="4"><?php echo $data_fetch["da_wcmessage_en"]; ?></textarea>
                              </div>
                              <div class="form-group col-md-6">
                                    <label class="control-label text-right"><?php echo label('sv_b_title'); ?> <?php echo label('acro_th'); ?>:</label>
                                    <input name="da_wctitle_th" id="da_wctitle_th" class="form-control" value="<?php echo $data_fetch["da_wctitle_th"]; ?>" type="text">

                                    <label class="control-label text-right"><?php echo label('message'); ?> <?php echo label('acro_th'); ?>:</label>
                                    <textarea name="da_wcmessage_th" id="da_wcmessage_th" class="form-control texteditor" style="width: 100%" rows="4"><?php echo $data_fetch["da_wcmessage_th"]; ?></textarea>
                              </div>
                              <div class="col-md-12"><hr><h5><i class="mdi mdi-check"></i> <?php echo label('confirm_msg'); ?></h5></div>

                              <div class="col-md-12 card">
                                <div class="card-body">
                                  <div class="col-md-12" align="right">
                                    <?php if($btn_add=="1"){ ?>
                                      <button name="add_button" type="button" id="add_button" class="btn btn-outline-info add_button" data-toggle="modal" data-target="#modal-default"><i class="mdi mdi-plus-box-outline"></i> <?php echo ucwords(label('addconfirm_msg')); ?></button>
                                    <?php } ?>
                                  </div>
                                  <div class="table-responsive">
                                      <table id="myTable" width="100%" class="table table-bordered table-striped">
                                        <thead>
                                          <tr>
                                            <th width="10%" align="center"><center><?php echo label('manage'); ?></center></th>
                                            <th width="5%"></th>
                                            <th width="20%" align="center"><center><?php echo label('contamess')." ".label('eng'); ?></center></th>
                                            <th width="20%" align="center"><center><?php echo label('contamess')." ".label('thai'); ?></center></th>
                                            <th width="10%" align="center"><center><?php echo label('status'); ?></center></th>
                                            <th width="15%" align="center"><center><?php echo label('m_updatedate'); ?></center></th>
                                            <th width="5%" align="center"><center></center></th>
                                          </tr>
                                        </thead>
                                      </table>
                                  </div>
                                  <p><?php echo label('preNote'); ?> : <?php if($btn_update=="1"){ ?><button type="button" class="btn btn-warning btn-xs"><i class="mdi mdi-lead-pencil"></i></button> = <b><?php echo label('m_edit'); ?></b><?php } ?><?php if($btn_delete=="1"){ ?> , <button type="button" class="btn btn-danger btn-xs"><i class="mdi mdi-window-close"></i></button> = <b><?php echo label('delete'); ?></b><?php } ?></p>
                                </div>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row col-12 page-titles card card-body" align="center">

                                              <div class="card" align="center">
                                                <div>
                                                  <button name="saveRBT" value="normal" class="btn btn-outline-success "  type="submit"><i class="mdi mdi-content-save"></i> <?php echo label('saveR'); ?></button>
                                                  <a href="<?php echo REAL_PATH.'/setting/ManageECT/'; ?>" class="btn btn-outline-danger cancel" ><i class="mdi mdi-close-box-outline"></i> <?php echo label('m_cancel') ?></a>
                                                </div>
                                              </div>
                </div>
              </form>
                    </div>

            </div>
        </div>
    </div>

    <?php $this->load->view('frontend/inc/inc-footer.php'); ?>


    <div class="modal fade bs-example-modal-lg" id="modal-default" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <form method="post" id="conmsg_form" autocomplete="off" name="conmsg_form" enctype="multipart/form-data"  class="form-horizontal" role="form">
              <div class="modal-body row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="conmsg_title_eng"><b style="color: #FF2D00">*</b><?php echo label('contamess')." ".label('eng'); ?>:</label>
                     <textarea name="conmsg_title_eng" id="conmsg_title_eng" class="form-control" required style="width: 100%" rows="4"></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="conmsg_title_th"><b style="color: #FF2D00">*</b><?php echo label('contamess')." ".label('thai'); ?>:</label>
                     <textarea name="conmsg_title_th" id="conmsg_title_th" class="form-control" required style="width: 100%" rows="4"></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="conmsg_status"><b style="color: #FF2D00">*</b><?php echo label('status'); ?>:</label>
                    <div class="switch">
                        <label><?php echo label('close'); ?><input type="checkbox"  id="conmsg_status" name="conmsg_status" value="1" checked><span class="lever switch-col-indigo"></span><?php echo label('open'); ?></label>
                    </div>
                  </div>
                </div>
              </div>
              <input type="hidden" id="operation" name="operation" value="Add">
              <input type="hidden" id="conmsg_id" name="conmsg_id">
              <div class="modal-footer">
                  <button type="submit" class="btn btn-outline-success btn-flat pull-left" name="action" id="action"><i class="mdi mdi-content-save"></i> <?php echo label('saveR'); ?></button>
                  <button type="button" class="btn btn-outline-danger btn-flat" data-dismiss="modal"><i class="mdi mdi-window-close"></i> <?php echo label('m_cancel'); ?></button>
              </div>
              </form>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <script type="text/javascript">var base_url = "<?php echo REAL_PATH; ?>";</script>
    <!-- Dropzone Plugin JavaScript -->
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/dropzone-master/dist/dropzone.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/tinymce/tinymce.min.js"></script>
    <!-- This is data table -->
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/datatables/datatables.min.js"></script>
    <script type="text/javascript">
    $('.slimtest1').perfectScrollbar();

           $('#add_button').click(function(){
                $("#modal-default").modal({backdrop: false});
                $('.modal-title').text('<?php echo ucwords(label("addconfirm_msg")); ?>');
                $('#operation').val("Add");
                $('#conmsg_form')[0].reset();
            });

      fetch_data_conmsg(0);
      function fetch_data_conmsg(page_num)
         {
            $('#myTable').DataTable().destroy();
            var table = $('#myTable').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/manage/fetch_detail_conmsg/',
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
        $(document).on('submit', '#conmsg_form', function(event){
              event.preventDefault(); 
                $.ajax({
                  url:"<?=base_url()?>index.php/manage/insert_conmsg",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  success:function(data)
                  {
                    if(data=="2"){
                        $('#conmsg_form')[0].reset();
                        $('#modal-default').modal('hide');
                        swal(
                            '<?php echo label("com_msg_success"); ?>!',
                            '',
                            'success'
                        ).then(function () {
                                      var table = $('#myTable').DataTable();
                                      var info = table.page.info();
                                      var length = info.pages;
                                      var page_current = info.page;
                                      fetch_data_conmsg(page_current);
                        })
                    }else if(data=="1"){
                        swal({
                            title: '<?php echo label("com_msg_duplicate"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        });
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

         $(document).on('click', '.delete', function(){
            var conmsg_id = $(this).attr("id");
            swal({
                title: '<?php echo label('wg_delete_msg'); ?>',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: '<?php echo label('wg_delete'); ?>',
                cancelButtonText: '<?php echo label('cancel'); ?>'
            }).then(function (isChk) {
              if(isChk.value){
                $.ajax({
                    url:"<?=base_url()?>index.php/manage/delete_conmsg_data",
                    method:"POST",
                    data:{conmsg_id:conmsg_id},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("com_msg_delete"); ?>!',
                            '',
                            'success'
                        ).then(function () {
                                      var table = $('#myTable').DataTable();
                                      var info = table.page.info();
                                      var length = info.pages;
                                      var page_current = info.page;
                                      fetch_data_conmsg(page_current);
                        })
                      }else if(data == "1"){
                         swal({
                            title: '<?php echo label("wg_msg_use"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label('m_ok'); ?>'
                        })
                      }else{
                         swal({
                            title: '<?php echo label('com_msg_error_save'); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label('m_ok'); ?>'
                        })
                      }
                    }
                });
              }
            })
          });

          $(document).on('click', '.update', function(){
            var conmsg_id = $(this).attr("id");
            $.ajax({
              url:"<?=base_url()?>index.php/manage/update_conmsg_data",
              method:"POST",
              data:{conmsg_id:conmsg_id},
              dataType:"json",
              success:function(data)
              {                
                  $("#modal-default").modal({backdrop: false});
                  $('.modal-title').text('<?php echo ucwords(label("editconfirm_msg")); ?>');
                  $('#conmsg_form')[0].reset();
                  $('#operation').val("Edit");
                  $('#conmsg_title_th').val(data.conmsg_title_th);
                  $('#conmsg_title_eng').val(data.conmsg_title_eng);
                  $('#conmsg_id').val(data.conmsg_id);  
                  
                  if(data.conmsg_status=="1"){
                    document.getElementById('conmsg_status').checked = true;
                  }else{
                    document.getElementById('conmsg_status').checked = false;
                  }
              }
            });
            
          });
    $(document).ready(function() {
        $('.dropify').dropify();
        
                  var da_logo_top = $('#da_logo_top').dropify({  
                            <?php  if(is_file(ROOT_DIR."images/logo.png")){ ?>
                               defaultFile: "<?php echo base_url();?>images/logo.png" ,
                     <?php } ?>
                  });
                  da_logo_top.on('dropify.beforeClear', function(event, element){

                      swal({
                          title: '<?php echo label('wg_delete_msg'); ?> ',
                          text: "",
                          type: 'warning',
                          showCancelButton: true,
                          confirmButtonColor: "#DD6B55",
                          confirmButtonText: '<?php echo label('wg_delete'); ?>',
                          cancelButtonText: '<?php echo label("m_cancel"); ?>'
                      }).then(function (isChk) {
                        if(isChk.value){
                            $.ajax({
                                  url:"<?=base_url()?>index.php/querydata/delete_logo",
                                  method:"POST",
                                  dataType:"json",
                                  data : {type:"da_logo_top"},
                                  success:function(data)
                                  {
                                      if(data.status=="2"){
                                          swal(
                                              '<?php echo label("com_msg_delete"); ?>!',
                                              '',
                                              'success'
                                          ).then(function () {
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
                                          })
                                      }
                                  }
                            });
                        }else{
                          var da_logo_top = $('#da_logo_top').dropify({                    
                            <?php  if(is_file(ROOT_DIR."images/logo.png")){ ?>
                               defaultFile: "<?php echo base_url();?>images/logo.png" ,
                     <?php } ?>
                          });
                        }
                      });
                  });
                  var da_logo_elearning = $('#da_logo_elearning').dropify({
                    <?php  if(is_file(ROOT_DIR."images/elearning_logo.png")){ ?>
                       defaultFile: "<?php echo base_url();?>images/elearning_logo.png" ,
                     <?php } ?>
                  });
                  da_logo_elearning.on('dropify.beforeClear', function(event, element){

                      swal({
                          title: '<?php echo label('wg_delete_msg'); ?> ',
                          text: "",
                          type: 'warning',
                          showCancelButton: true,
                          confirmButtonColor: "#DD6B55",
                          confirmButtonText: '<?php echo label('wg_delete'); ?>',
                          cancelButtonText: '<?php echo label("m_cancel"); ?>'
                      }).then(function (isChk) {
                        if(isChk.value){
                            $.ajax({
                                  url:"<?=base_url()?>index.php/querydata/delete_logo",
                                  method:"POST",
                                  dataType:"json",
                                  data : {type:"da_logo_elearning"},
                                  success:function(data)
                                  {
                                      if(data.status=="2"){
                                          swal(
                                              '<?php echo label("com_msg_delete"); ?>!',
                                              '',
                                              'success'
                                          ).then(function () {
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
                                          })
                                      }
                                  }
                            });
                        }else{
                          var da_logo_elearning = $('#da_logo_elearning').dropify({
                    <?php  if(is_file(ROOT_DIR."images/elearning_logo.png")){ ?>
                               defaultFile: "<?php echo base_url();?>images/elearning_logo.png" ,
                     <?php } ?>
                          });
                        }
                      });
                  });
                  var da_logo_footer = $('#da_logo_footer').dropify({
                    <?php  if(is_file(ROOT_DIR."images/logo_white.png")){ ?>
                       defaultFile: "<?php echo base_url();?>images/logo_white.png" ,
                     <?php } ?>
                  });

                  da_logo_footer.on('dropify.beforeClear', function(event, element){

                      swal({
                          title: '<?php echo label('wg_delete_msg'); ?> ',
                          text: "",
                          type: 'warning',
                          showCancelButton: true,
                          confirmButtonColor: "#DD6B55",
                          confirmButtonText: '<?php echo label('wg_delete'); ?>',
                          cancelButtonText: '<?php echo label("m_cancel"); ?>'
                      }).then(function (isChk) {
                        if(isChk.value){
                            $.ajax({
                                  url:"<?=base_url()?>index.php/querydata/delete_logo",
                                  method:"POST",
                                  dataType:"json",
                                  data : {type:"da_logo_footer"},
                                  success:function(data)
                                  {
                                      if(data.status=="2"){
                                          swal(
                                              '<?php echo label("com_msg_delete"); ?>!',
                                              '',
                                              'success'
                                          ).then(function () {
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
                                          })
                                      }
                                  }
                            });
                        }else{
                          var da_logo_footer = $('#da_logo_footer').dropify({
                    <?php  if(is_file(ROOT_DIR."images/logo_white.png")){ ?>
                               defaultFile: "<?php echo base_url();?>images/logo_white.png" ,
                     <?php } ?>
                          });
                        }
                      });
                  });
                  var da_footer_background = $('#da_footer_background').dropify({
                    <?php  if(is_file(ROOT_DIR."images/bg.png")){ ?>
                       defaultFile: "<?php echo base_url();?>images/bg.jpg" ,
                     <?php } ?>
                  });

                  da_footer_background.on('dropify.beforeClear', function(event, element){

                      swal({
                          title: '<?php echo label('wg_delete_msg'); ?> ',
                          text: "",
                          type: 'warning',
                          showCancelButton: true,
                          confirmButtonColor: "#DD6B55",
                          confirmButtonText: '<?php echo label('wg_delete'); ?>',
                          cancelButtonText: '<?php echo label("m_cancel"); ?>'
                      }).then(function (isChk) {
                        if(isChk.value){
                            $.ajax({
                                  url:"<?=base_url()?>index.php/querydata/delete_logo",
                                  method:"POST",
                                  dataType:"json",
                                  data : {type:"da_footer_background"},
                                  success:function(data)
                                  {
                                      if(data.status=="2"){
                                          swal(
                                              '<?php echo label("com_msg_delete"); ?>!',
                                              '',
                                              'success'
                                          ).then(function () {
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
                                          })
                                      }
                                  }
                            });
                        }else{
                          var da_footer_background = $('#da_footer_background').dropify({
                    <?php  if(is_file(ROOT_DIR."images/bg.png")){ ?>
                       defaultFile: "<?php echo base_url();?>images/bg.jpg" ,
                     <?php } ?>
                          });
                        }
                      });
                  });
        if ($(".texteditor").length > 0) {
            tinymce.init({
                selector: "textarea.texteditor",
                theme: "modern",
                height: 300,
                
                    plugins: [
                        "advlist autolink link image lists charmap hr anchor pagebreak",
                        "searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking",
                        "save table contextmenu directionality paste textcolor"
                    ],
                    toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor ",

                    images_upload_url : '<?=base_url()?>index.php/setting/upload_img_texteditor',
                    automatic_uploads : false,

                    images_upload_handler : function(blobInfo, success, failure) {
                      var xhr, formData;

                      xhr = new XMLHttpRequest();
                      xhr.withCredentials = false;
                      xhr.open('POST', '<?=base_url()?>index.php/setting/upload_img_texteditor');

                      xhr.onload = function() {
                        var json;

                        if (xhr.status != 200) {
                          if(xhr.status==400){
                            failure('Please use English filename');
                          }else{
                            failure('HTTP Error: ' + xhr.status);
                          }
                          return;
                        }

                        json = JSON.parse(xhr.responseText);

                        if (!json || typeof json.file_path != 'string') {
                          failure('Invalid JSON: ' + xhr.responseText);
                          return;
                        }

                        success(json.file_path);
                      };

                      formData = new FormData();
                      formData.append('file', blobInfo.blob(), blobInfo.filename());

                      xhr.send(formData);
                    },

            });
        }

        $(document).on('submit', '#about_form', function(event){
              event.preventDefault(); 
                $.ajax({
                  url:"<?=base_url()?>index.php/setting/insert_about",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  success:function(data)
                  {
                    if(data=="2"){
                        swal(
                            '<?php echo label("com_msg_success"); ?>!',
                            '',
                            'success'
                        ).then(function () {
                          location.reload();
                        })
                    }else if(data=="1"){
                        swal({
                            title: '<?php echo label("com_msg_duplicate"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            $("#com_name").val("");
                            document.getElementById("com_name").focus();
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
    });

    </script>
</body>

</html>