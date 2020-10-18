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
                      <div class="col-md-12">
                        <?php if($btn_add=="1"){ ?>
                          <button name="add_button" id="add_button" class="btn btn-outline-info add_button float-right" data-toggle="modal" data-target="#modal-default"><i class="mdi mdi-plus-box-outline"></i> <?php echo ucwords(label('createcoursegroup')); ?></button>
                        <?php } ?>
                        <?php if($com_admin!="com_associated"&&($user['ug_id']=="1")){ ?>
                        <div class="row">
                            <div class="col-md-6">
                                  <label for="com_id_search"><?php echo label('com_name'); ?>: </label>
                                  <select class="form-control select2" id="com_id_search" name="com_id_search" style="width: 100%;">
                                    <?php   if(count($company_arr)>0){ ?>
                                                <optgroup label="<?php echo label('please_com_name'); ?>">
                                        <?php   $numloop = 1;
                                                foreach ($company_arr as $key_com => $value_com) { ?>
                                                    <option value="<?php echo $value_com['com_id']; ?>" <?php if($numloop==1){echo "selected";}$numloop++; ?>><?php echo $lang=="thai"?$value_com['com_name_th']:$value_com['com_name_eng']; ?></option>
                                        <?php   } ?>
                                                </optgroup>
                                    <?php   } ?>
                                  </select>
                            </div>
                        </div>
                        <?php }else{ ?>
                            <input type="hidden" id="com_id_search" name="com_id_search" value="<?php echo $com_id; ?>">
                        <?php } ?>
                      </div>
                      <div class="table-responsive">
                          <table id="myTable" width="100%" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <?php //if($btn_update=="1"||$btn_delete=="1"){ ?>
                                <th width="10%" align="center"><center><?php echo label('manage'); ?></center></th>
                              <?php //} ?>
                                <!-- <th width="15%" align="center"><center><?php echo label('division_title'); ?></center></th> -->
                                <th width="15%" align="center"><center><?php echo label('cgcode'); ?></center></th>
                                <th width="35%" align="center"><center><?php echo label('cgtitle')." (".label('TH').")"; ?></center></th>
                                <th width="35%" align="center"><center><?php echo label('cgtitle')." (".label('EN').")"; ?></center></th>
                                <th width="5%" align="center"><center><?php echo label('course_status'); ?></center></th>
                                <th width="5%" align="center"></th>
                                <?php //if($is_approve=="1"){ ?>
                                <?php //} ?>
                              </tr>
                            </thead>
                          </table>
                      </div>
                      <p><?php echo label('preNote'); ?>: <?php if($btn_update=="1"){ ?><button type="button" class="btn btn-warning btn-xs"><i class="mdi mdi-lead-pencil"></i></button> = <b><?php echo label('m_edit'); ?></b><?php } ?><?php if($btn_delete=="1"){ ?> , <button type="button" class="btn btn-danger btn-xs"><i class="mdi mdi-window-close"></i></button> = <b><?php echo label('delete'); ?></b><?php } ?></p>
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
                  <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <form method="post" id="course_group_form" autocomplete="off" name="course_group_form" enctype="multipart/form-data"  class="form-horizontal" role="form">
              <div class="modal-body row">
                <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label"><b style="color: #FF2D00">*</b><?php echo label('division_title'); ?>:</label>
                                    <select class="form-control select2" multiple id="div_id" name="div_id[]"  style="width: 100%;" required>
                                    </select>
                                </div>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="cgtitle_th"><b style="color: #FF2D00">*</b><?php echo label('cgtitle')." (".label('TH').")"; ?>:</label>
                    <input type="text" id="cgtitle_th" name="cgtitle_th" class="form-control" required> 
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="cgtitle_en"><b style="color: #FF2D00">*</b><?php echo label('cgtitle')." (".label('EN').")"; ?>:</label>
                    <input type="text" id="cgtitle_en" name="cgtitle_en" class="form-control" required> 
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label><?php echo label('cgdesc')." (".label('TH').")"; ?>:</label>
                    <textarea class="form-control" rows="4" id="cgdesc_th" name="cgdesc_th"></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label><?php echo label('cgdesc')." (".label('EN').")"; ?>:</label>
                    <textarea class="form-control" rows="4" id="cgdesc_en" name="cgdesc_en"></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                          <label class="control-label text-right"><?php echo label('sv_b_pic'); ?></label>

                          <input type="file" name="cgthumb" id="cgthumb" class="dropify" accept="image/png, image/jpeg, image/gif" />
                          <input type="hidden" id="cgthumb_ori" name="cgthumb_ori">
                    </div>
                </div>
                <!-- <div class="col-md-6">
                  <div class="form-group">
                    <label><?php echo label('cgthumb'); ?>:</label>
                    <input type="file" name="cgthumb" id="cgthumb" class="dropify"  accept="image/png, image/jpeg" />
                  </div>
                </div> -->
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="cg_status"><?php echo label('status'); ?>:</label>
                    <div class="switch">
                        <label><?php echo label('close'); ?><input type="checkbox" checked  id="cg_status" name="cg_status" value="1"><span class="lever switch-col-indigo"></span><?php echo label('open'); ?></label>
                    </div>
                  </div>
                </div>
              </div>
              <input type="hidden" id="operation" name="operation" value="Add">
              <input type="hidden" id="cg_id" name="cg_id">
              <input type="hidden" id="com_id" name="com_id">
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

      <div id="myModal_process" class="modal fade bs-example-modal-lg" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-body" align="center">
                <img src="<?php echo REAL_PATH; ?>/assets/images/01-progress.gif" style="width: 50%">
                <br>
                <h3 style="color: black;"><?php echo label('sv_p_please_wait'); ?></h3>
              </div>
            </div>
        </div>
      </div>

    <script type="text/javascript">var base_url = "<?php echo REAL_PATH; ?>";</script>
    <!-- wysuhtml5 Plugin JavaScript -->
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/tinymce/tinymce.min.js"></script>
    <!-- This is data table -->
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/datatables/datatables.min.js"></script>
    <script type="text/javascript">
        $('.select2').select2();
        $("#cg_approve_by").select2({
            maximumSelectionLength: 5,
            language: {
                // You can find all of the options in the language files provided in the
                // build. They all must be functions that return the string that should be
                // displayed.
                maximumSelected: function (e) {
                    var t = "<?php echo label('select_approver'); ?>";
                    return t.replace("_", e.maximum);
                }
            }
        });
      fetch_data_main(0);
      function fetch_data_main(page_num)
         {
            $('#myTable').DataTable().destroy();
            var com_id = $('#com_id_search').val();
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
            "scrollX": true,
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_detail_coursegroup/',
                    type : 'GET',
                    data : {com_id:com_id}
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

        $('select[name="com_id_search"]').on('change', function(){
          var com_id = $(this).val();
          fetch_data_main(0);
          $('#com_id').val(com_id);
        });
        function clear_dropify(id){
                    var imagenUrl = "";
                    var drEvent = $('#'+id).dropify(
                    {
                      defaultFile: imagenUrl
                    });
                    drEvent = drEvent.data('dropify');
                    drEvent.resetPreview();
                    drEvent.clearElement();
                    drEvent.settings.defaultFile = imagenUrl;
                    drEvent.destroy();
                    drEvent.init();
        }
           $('#add_button').click(function(){
                $("#modal-default").modal({backdrop: false});
                $('.modal-title').text('<?php echo label('createcoursegroup'); ?>');
                $('#course_group_form')[0].reset();
                $('#operation').val("Add");
                // clear_dropify('cgthumb');
                var com_id = $('#com_id_search').val();
                $('#com_id').val(com_id);
                
                $.ajax({
                  url: '<?=base_url()?>index.php/querydata/recheckdivisionmultiple',
                  type: 'POST',
                  data:{com_id:com_id,cg_id:""},
                  success: function(data_div){
                      $('#div_id').html(data_div);
                  }
                });
                clear_dropify('cgthumb');
            });

    $(document).ready(function() {
        $('.dropify').dropify();
        //$('#myTable').DataTable();
        $(document).on('submit', '#course_group_form', function(event){
              event.preventDefault(); 
              var operation = $('#operation').val();
              var rechk_val = 1;
              var cg_statusval = document.getElementById('cg_status');
              if(cg_statusval.checked){
              var cg_status = 1;
              }else{
              var cg_status = 0;
              }
              var form_input = new FormData(this);

              var varchk=1;
              var path_cert = $('#cgthumb').val();
              var fileExtension = ['jpg','png','gif'];
              if(path_cert!=""){
                if($.inArray($('#cgthumb').val().split('.').pop().toLowerCase(), fileExtension) == -1){
                        varchk = 3;
                                            swal({
                                                title: '<?php echo label("media_type_dontmatch"); ?>',
                                                text: "",
                                                type: 'warning',
                                                showCancelButton: false,
                                                confirmButtonClass: 'btn btn-primary',
                                                confirmButtonText: '<?php echo label("m_ok"); ?>'
                                            })
                }
              }
              if(varchk==1){
                  if(operation=="Edit"){
                        var cg_id = $('#cg_id').val();
                        $.ajax({
                          url:"<?=base_url()?>index.php/querydata/rechk_course_incg",
                          method:"POST",
                          data:{cg_id:cg_id},
                          dataType:"json",
                          success:function(data)
                          { 
                              if(data.status=="1"&&cg_status==0&&cg_status!=data.cg_status){
                                  swal({
                                      title: '<?php echo label('thiscg_isclose'); ?>',
                                      text: "",
                                      type: 'warning',
                                      showCancelButton: true,
                                      confirmButtonColor: "#1abc9c",  
                                      cancelButtonColor: "#DD6B55",   
                                      confirmButtonText: '<?php echo label('ok'); ?>',
                                      cancelButtonText: '<?php echo label('cancel'); ?>'
                                  }).then(function (isChk) {
                                    if(isChk.value){
                                        $.ajax({
                                          url:"<?=base_url()?>index.php/insertdata/insert_coursegroup",
                                          method:'POST',
                                          data:form_input,
                                          contentType:false,
                                          processData:false,
                                          dataType:"json",
                                          success:function(data)
                                          {
                                            if(data.status=="2"){
                                                $('#course_group_form')[0].reset();
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
                                                              fetch_data_main(page_current);
                                                })
                                            }else if(data.status=="1"){
                                                swal({
                                                    title: '<?php echo label("cg_msg_duplicate"); ?>',
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
                                    }
                                  });
                              }else{
                                  $.ajax({
                                    url:"<?=base_url()?>index.php/insertdata/insert_coursegroup",
                                    method:'POST',
                                    data:form_input,
                                    contentType:false,
                                    processData:false,
                                    dataType:"json",
                                    success:function(data)
                                    {
                                      if(data.status=="2"){
                                          $('#course_group_form')[0].reset();
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
                                                        fetch_data_main(page_current);
                                          })
                                      }else if(data.status=="1"){
                                          swal({
                                              title: '<?php echo label("cg_msg_duplicate"); ?>',
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
                              }
                          }
                        });
                  }else{
                      $.ajax({
                        url:"<?=base_url()?>index.php/insertdata/insert_coursegroup",
                        method:'POST',
                        data:form_input,
                        contentType:false,
                        processData:false,
                        dataType:"json",
                        success:function(data)
                        {
                          if(data.status=="2"){
                              $('#course_group_form')[0].reset();
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
                                            fetch_data_main(page_current);
                              })
                          }else if(data.status=="1"){
                              swal({
                                  title: '<?php echo label("cg_msg_duplicate"); ?>',
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
                  }
              }

            });

         $(document).on('click', '.delete', function(){
            var cg_id = $(this).attr("id");

            $.ajax({
              url:"<?=base_url()?>index.php/querydata/rechk_course_incg",
              method:"POST",
              data:{cg_id:cg_id},
              dataType:"json",
              success:function(data)
              { 
                  if(data.status=="1"){
                      swal({
                                  title: '<?php echo label('thiscg_isdelete'); ?>',
                                  text: "",
                                  type: 'warning',
                                  showCancelButton: true,
                                  confirmButtonColor: "#1abc9c",  
                                  cancelButtonColor: "#DD6B55",   
                                  confirmButtonText: '<?php echo label('ok'); ?>',
                                  cancelButtonText: '<?php echo label('cancel'); ?>'
                      }).then(function (isChk) {
                          if(isChk.value){
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
                                        url:"<?=base_url()?>index.php/manage/delete_cosgroup_data",
                                        method:"POST",
                                        data:{id_delete:cg_id},
                                        success:function(data)
                                        {
                                          if(data == "2"){
                                            swal(
                                                '<?php echo label("com_msg_delete"); ?>',
                                                '',
                                                'success'
                                            ).then(function () {
                                                          var table = $('#myTable').DataTable();
                                                          var info = table.page.info();
                                                          var length = info.pages;
                                                          var page_current = info.page;
                                                          fetch_data_main(page_current);
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
                          }
                      });
                  }else{
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
                              url:"<?=base_url()?>index.php/manage/delete_cosgroup_data",
                              method:"POST",
                              data:{id_delete:cg_id},
                              success:function(data)
                              {
                                if(data == "2"){
                                  swal(
                                      '<?php echo label("com_msg_delete"); ?>',
                                      '',
                                      'success'
                                  ).then(function () {
                                                var table = $('#myTable').DataTable();
                                                var info = table.page.info();
                                                var length = info.pages;
                                                var page_current = info.page;
                                                fetch_data_main(page_current);
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
                  }
              }
            });
          });

          $(document).on('click', '.update', function(){
            var cg_id = $(this).attr("id");
            var com_id = $('#com_id_search').val();
            $.ajax({
              url:"<?=base_url()?>index.php/manage/update_coursegroup_data",
              method:"POST",
              data:{cg_id_update:cg_id},
              dataType:"json",
              success:function(data)
              {                
                  $("#modal-default").modal({backdrop: false});
                  $('.modal-title').text('<?php echo ucwords(label("editcoursegroup")); ?>');
                  $('#course_group_form')[0].reset();
                  $('#operation').val("Edit");


                if(data.cg_status=="1"){
                  document.getElementById('cg_status').checked = true;
                }else{
                  document.getElementById('cg_status').checked = false;
                }
                $('#com_id').val(com_id);
                $('#cgtitle_th').val(data.cgtitle_th);
                $('#cgtitle_en').val(data.cgtitle_en);  
                $('#cgdesc_th').val(data.cgdesc_th);
                $('#cgdesc_en').val(data.cgdesc_en); 
                $('#cg_id').val(data.cg_id);     
                
                $('#cgthumb_ori').val(data.cgthumb); 

                $.ajax({
                  url: '<?=base_url()?>index.php/querydata/recheckdivisionmultiple',
                  type: 'POST',
                  data:{com_id:com_id,cg_id:cg_id},
                  success: function(data_div){
                      $('#div_id').html(data_div);
                  }
                });
                    if(data.cgthumb!=""){
                        var nameImage = "<?php echo REAL_PATH;?>/uploads/course_group/"+data.cgthumb
                        var drEvent = $('#cgthumb').dropify(
                        {
                          defaultFile: nameImage
                        });
                        drEvent = drEvent.data('dropify');
                        drEvent.resetPreview();
                        drEvent.clearElement();
                        drEvent.settings.defaultFile = nameImage;
                        drEvent.destroy();
                        drEvent.init();

                        var drEvent = $('.dropify').dropify({
                            defaultFile: "<?php echo REAL_PATH;?>/uploads/course_group/"+data.cgthumb ,
                        });

                        drEvent.on('dropify.beforeClear', function(event, element){
                                $('#cgthumb_ori').val("");
                                return true; 
                        });
                    }else{
                        $('.dropify').dropify();
                    }

              }
            });
            
          });

    });
    </script>
</body>

</html>