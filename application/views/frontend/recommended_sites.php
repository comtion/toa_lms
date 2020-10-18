<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/inc/inc-meta-dashboard.php'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo REAL_PATH; ?>/assets/plugins/datatables/media/css/dataTables.bootstrap4.css">
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

                <div class="row col-12 page-titles">
                  <div class="col-md-12 card">
                    <div class="card-body">
                      <div class="col-md-12" align="right">
                        <?php if($btn_add=="1"){ ?>
                          <button name="add_button" id="add_button" class="btn btn-outline-info add_button" data-toggle="modal" data-target="#modal-default"><i class="mdi mdi-plus-box-outline"></i> <?php echo label('addrecommended_sites'); ?></button>
                        <?php } ?>
                      </div>
                      <div class="table-responsive">
                          <table id="myTable" width="100%" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th width="5%" align="center"><?php echo label('manage'); ?></th>
                                <th width="5%"></th>
                                <th width="45%" align="center"><?php echo label('mpic'); ?></th>
                                <th width="40%" align="center"><?php echo label('file_name'); ?></th>
                                <th width="5%" align="center"></th>
                              </tr>
                            </thead>
                          </table>
                      </div>
                      <p><?php echo label('preNote'); ?> : <?php if($btn_update=="1"){ ?><button type="button" class="btn btn-warning btn-xs"><i class="mdi mdi-lead-pencil"></i></button> = <b><?php echo label('m_edit'); ?></b><?php } ?><?php if($btn_update=="1"&&$btn_delete=="1"){ ?> , <?php } ?><?php if($btn_delete=="1"){ ?><button type="button" class="btn btn-danger btn-xs"><i class="mdi mdi-window-close"></i></button> = <b><?php echo label('delete'); ?></b><?php } ?></p>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('frontend/inc/inc-footer.php'); ?>

    <div class="modal fade bs-example-modal-lg" id="modal-default" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myLargeModalLabel"><?php echo label('addrecommended_sites'); ?></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <form method="post" id="recommended_sites_form" autocomplete="off" name="recommended_sites_form" enctype="multipart/form-data"  class="form-horizontal" role="form">
              <div class="modal-body row">
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="web_name_th"><b style="color: #FF2D00">*</b><?php echo label('stitle')." TH"; ?>:</label>
                    <input type="text" id="web_name_th" name="web_name_th" class="form-control" required> 
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="web_name_en"><b style="color: #FF2D00">*</b><?php echo label('stitle')." ENG"; ?>:</label>
                    <input type="text" id="web_name_en" name="web_name_en" class="form-control" required> 
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="web_path"><b style="color: #FF2D00">*</b><?php echo label('link'); ?>:</label>
                    <input type="text" id="web_path" name="web_path" class="form-control" required> <br><br>
                    <label for="web_status"><b style="color: #FF2D00">*</b><?php echo label('com_admin'); ?>:</label>
                    <div class="switch">
                        <label><?php echo label('close'); ?><input type="checkbox"  id="web_status" name="web_status" value="1" checked><span class="lever switch-col-indigo"></span><?php echo label('open'); ?></label>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                      <label class="control-label text-right"><?php echo label('svpic'); ?>:</label>
                      <input type="file" name="web_pathimg" id="web_pathimg" class="dropifymain" accept="image/png, image/jpeg, image/gif" />
                  </div>
                </div>
              </div>
              <input type="hidden" id="operation" name="operation" value="Add">
              <input type="hidden" id="web_id" name="web_id">
              <input type="hidden" id="web_pathimg_ori" name="web_pathimg_ori">
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
    <!-- wysuhtml5 Plugin JavaScript -->
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/tinymce/tinymce.min.js"></script>
    <!-- This is data table -->
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/datatables/datatables.min.js"></script>
    <script type="text/javascript">

        function clear_dropify(id){
                    $('#'+id).dropify(); 
        }
           $('#add_button').click(function(){
                $("#modal-default").modal({backdrop: false});
                $('.modal-title').text('<?php echo label("addrecommended_sites"); ?>');
                $('#recommended_sites_form')[0].reset();
                $('.dropifymain').dropify();
                var nameImage = "";
                    var drEvent = $('#web_pathimg').dropify(
                    {
                      defaultFile: nameImage
                    });
                    drEvent = drEvent.data('dropify');
                    drEvent.resetPreview();
                    drEvent.clearElement();
                    drEvent.settings.defaultFile = nameImage;
                    drEvent.destroy();
                    drEvent.init();
                    $('.dropify').dropify({
                        defaultFile: "" ,
                    }); 

            });
           fetch_data();
         function fetch_data()
         {
            $('#myTable').DataTable().destroy();
            $('#myTable').DataTable({
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
                    url : '<?=base_url()?>index.php/setting/fetch_recommended_sites/',
                    type : 'GET'
                },
            });
         }

         $(document).on('click', '.delete', function(){
            var web_id = $(this).attr("id");
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
                    url:"<?=base_url()?>index.php/manage/delete_recommended_sites",
                    method:"POST",
                    data:{web_id:web_id,table_name:"LMS_WEB"},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("com_msg_delete"); ?>',
                            '',
                            'success'
                        ).then(function () {
                          fetch_data();
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
            var web_id = $(this).attr("id");
            $.ajax({
              url:"<?=base_url()?>index.php/manage/update_recommended_sites_data",
              method:"POST",
              data:{web_id:web_id},
              dataType:"json",
              success:function(data)
              {
                $("#modal-default").modal({backdrop: false});
                $('.modal-title').text('<?php echo label("editrecommended_sites"); ?>');
                $('#recommended_sites_form')[0].reset();
                $('#operation').val("Edit");
                $('#web_name_th').val(data.web_name_th);
                $('#web_name_en').val(data.web_name_en);
                $('#web_path').val(data.web_path);
                $('#web_id').val(data.web_id);      
                $('#web_pathimg_ori').val(data.web_pathimg);      
                if(data.web_status=="1"){
                  document.getElementById('web_status').checked = true;
                }else{
                  document.getElementById('web_status').checked = false;
                }
                    if(data.web_pathimg!=""){
                        var nameImage = "<?php echo REAL_PATH;?>/uploads/file_forwebrecommended/"+data.web_pathimg
                        var drEvent = $('#web_pathimg').dropify(
                        {
                          defaultFile: nameImage
                        });
                        drEvent = drEvent.data('dropify');
                        drEvent.resetPreview();
                        drEvent.clearElement();
                        drEvent.settings.defaultFile = nameImage;
                        drEvent.destroy();
                        drEvent.init();

                        var drEvent = $('.dropifymain').dropify({
                            defaultFile: "<?php echo REAL_PATH;?>/uploads/file_forwebrecommended/"+data.web_pathimg ,
                        });

                        drEvent.on('dropify.beforeClear', function(event, element){
                                $('#web_pathimg_ori').val("");
                                return true; 
                        });
                    }else{
                        $('.dropifymain').dropify();
                    }
              }
            });
            
          });

        $(document).on('submit', '#recommended_sites_form', function(event){
              event.preventDefault(); 
                $.ajax({
                  url:"<?=base_url()?>index.php/setting/insert_recommended_sites",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  dataType:"json",
                  success:function(data)
                  {
                    if(data.status=="2"){
                        $('#recommended_sites_form')[0].reset();
                        swal(
                            '<?php echo label("com_msg_success"); ?>!',
                            '',
                            'success'
                        ).then(function () {
                            fetch_data();
                            $('#modal-default').modal('hide');
                            var imagenUrl = "";
                            var drEvent = $('#web_pathimg').dropify(
                            {
                              defaultFile: imagenUrl
                            });
                            drEvent = drEvent.data('dropify');
                            drEvent.resetPreview();
                            drEvent.clearElement();
                            drEvent.settings.defaultFile = imagenUrl;
                            drEvent.destroy();
                            drEvent.init();
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