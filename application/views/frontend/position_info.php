<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/inc/inc-meta-dashboard.php'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo REAL_PATH; ?>/assets/plugins/datatables/media/css/dataTables.bootstrap4.css">
    <!-- page css -->
    <link href="<?php echo REAL_PATH; ?>/assets/css/pages/ribbon-page.css" rel="stylesheet">
    <!-- Page plugins css -->
    <link href="<?php echo REAL_PATH;?>/assets/plugins/clockpicker/dist/jquery-clockpicker.min.css" rel="stylesheet">
    <!-- Clock Plugin JavaScript -->
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/clockpicker/dist/jquery-clockpicker.min.js"></script>
    <!--nestable CSS -->
    <link href="<?php echo REAL_PATH; ?>/assets/plugins/nestable/nestable.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
      .test[style] {
          padding-right:0 !important;
      }
      .test.modal-open {
          overflow: auto;
      }    
      .modal {
          padding-right: 0px !important;
      }
      .text-wrap{
        white-space:normal;overflow-wrap: anywhere;
      }
    </style>

    <link href="<?php echo REAL_PATH; ?>/assets/css/pages/tab-page.css" rel="stylesheet">
    <link href="<?php echo REAL_PATH; ?>/assets/css/custom_imat.css" rel="stylesheet">
    <link href="<?php echo REAL_PATH; ?>/assets/css/bootstrap-select.min.css" rel="stylesheet">
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
                

                <div class="row col-12 page-titles" id="div_maincourse">
                  <div class="col-md-12 card">
                    <div class="card-body">
                      <div class="col-md-12">
                        <?php if($btn_add=="1"){ ?>
                          <button name="add_button" id="add_button" class="btn btn-outline-info add_button float-right" data-toggle="modal" data-target="#modal-default"><i class="mdi mdi-plus-box-outline"></i> <?php echo label('addposition'); ?></button>
                        <?php } ?>
                        <?php if($com_admin!="com_associated"&&($user['ug_id']=="1")){ ?>
                        <div class="row">
                            <div class="col-md-6">
                                  <label for="com_id_search"><?php echo label('sv_b_com_name'); ?>: </label>
                                  <select class="form-control select2" id="com_id_search" name="com_id_search" style="width: 100%;" onchange="fetch_data_main(0);">
                                    <?php   if(count($company_arr)>0){ ?>
                                                <optgroup label="<?php echo label('sv_b_select_com_name'); ?>">
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
                      </div><br>
                      <div class="table-responsive">
                          <table id="myTable" width="100%" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                  <th width="10%"><center><?php echo label('manage'); ?></center></th>
                                  <th width="5%"></th>
                                  <th width="10%"><center><?php echo label('post_code'); ?></center></th>
                                  <th width="45%"><center><?php echo label('post_name'); ?></center></th>
                                  <th width="10%"><center><?php echo label('status'); ?></center></th>
                                  <th width="15%"><center><?php echo label('m_updatedate'); ?></center></th>
                                  <th width="5%"><center></center></th>
                              </tr>
                            </thead>
                          </table>
                      </div>
                      <p><?php echo label('preNote'); ?>: <?php if($btn_update=="1"){ ?><button type="button" class="btn btn-warning btn-xs"><i class="mdi mdi-lead-pencil"></i></button> = <b><?php echo label('m_edit'); ?></b><?php } ?><?php if($btn_update=="1"&&$btn_delete=="1"){ ?> , <?php } ?><?php if($btn_delete=="1"){ ?><button type="button" class="btn btn-danger btn-xs"><i class="mdi mdi-window-close"></i></button> = <b><?php echo label('delete'); ?></b><?php } ?></p>
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
              <form method="post" id="position_form" autocomplete="off" name="position_form" enctype="multipart/form-data"  class="form-horizontal" role="form">
              <div class="modal-body row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="posi_code"><b style="color: #FF2D00">*</b><?php echo label('post_code'); ?>:</label>
                    <input type="text" id="posi_code" name="posi_code" class="form-control" required> 
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="posi_shot"><b style="color: #FF2D00">*</b><?php echo label('acronym'); ?>:</label>
                    <input type="text" id="posi_shot" name="posi_shot" class="form-control" required> 
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="posi_group"><b style="color: #FF2D00">*</b><?php echo label('post_group'); ?>:</label>
                    <select id="posi_group" name="posi_group" class="form-control" onchange="onchk_posigroup(this.value)" required>
                      <option value="division" selected><?php echo label('division_title'); ?></option>
                      <option value="group"><?php echo label('group_title'); ?></option>
                      <option value="department"><?php echo label('m_department'); ?></option>
                      <option value="section"><?php echo label('section_title'); ?></option>
                      <option value="sale"><?php echo label('sale_title'); ?></option>
                    </select>
                    <!-- <input type="text" id="posi_group" name="posi_group" class="form-control" required>  -->
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="posi_name_th"><b style="color: #FF2D00">*</b><?php echo label('post_name')." TH"; ?>:</label>
                    <input type="text" id="posi_name_th" name="posi_name_th" class="form-control" required> 
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="posi_name_en"><b style="color: #FF2D00">*</b><?php echo label('post_name')." EN"; ?>:</label>
                    <input type="text" id="posi_name_en" name="posi_name_en" class="form-control" required> 
                  </div>
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label"><b style="color: #FF2D00">*</b><?php echo label('level'); ?>:</label>
                    <select class="form-control select2" multiple id="lv_id" name="lv_id[]" required style="width: 100%;">
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label class="control-label" id="txt_posifd"></label>
                    <select class="form-control select2" multiple id="posifd_val" name="posifd_val[]" required style="width: 100%;">
                    </select>
                </div>
              </div>
              <input type="hidden" id="operation" name="operation" value="Add">
              <input type="hidden" id="com_id" name="com_id">
              <input type="hidden" id="posi_id" name="posi_id">
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
    <!--Nestable js -->
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/nestable/jquery.nestable.js"></script>

    <script src="<?php echo REAL_PATH; ?>/assets/plugins/bootstrap-datepicker/bootstrap-datepicker-custom/dist/js/bootstrap-datepicker-custom.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/bootstrap-datepicker/bootstrap-datepicker-custom/dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>
    

    <script src="<?php echo REAL_PATH; ?>/assets/js/bootstrap-select.min.js"></script>

    <script type="text/javascript">
        $('.select2').select2();
      
         function onchk_posigroup(value,posi_id=""){
                  var com_id = $('#com_id_search').val();
                  if(value=="division"){
                    $('#txt_posifd').text('<?php echo label("division_title"); ?>');
                  }else if(value=="group"){
                    $('#txt_posifd').text('<?php echo label("group_title"); ?>');
                  }else if(value=="department"){
                    $('#txt_posifd').text('<?php echo label("m_department"); ?>');
                  }else if(value=="section"){
                    $('#txt_posifd').text('<?php echo label("section_title"); ?>');
                  }else if(value=="sale"){
                    $('#txt_posifd').text('<?php echo label("sale_title"); ?>');
                  }
                      $.ajax({
                            url: '<?=base_url()?>index.php/querydata/recheckposifdmulti',
                            type: 'POST',
                            data:{posi_id:posi_id,com_id:com_id,posi_group:value},
                            success: function(data_posifd){
                              $('#posifd_val').html(data_posifd);
                            }
                      });
         }
      fetch_data_main(0);
      function fetch_data_main(page_num)
         {
            var com_id = $('#com_id_search').val();
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
            "scrollX": true,
                "ajax": {
                    url : '<?=base_url()?>index.php/manage/fetch_detail_position/',
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

    $(document).ready(function() {
        $('.dropify').dropify();
        //$('#myTable').DataTable();
        $(document).on('submit', '#position_form', function(event){
              event.preventDefault(); 
                $.ajax({
                  url:"<?=base_url()?>index.php/manage/insert_position",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  success:function(data)
                  {
                    console.log(data);
                    if(data=="2"){
                        $('#position_form')[0].reset();
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
                                      /*location.reload();*/
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
         $(document).on('click', '.delete', function(){
            var posi_id = $(this).attr("id");
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
                    url:"<?=base_url()?>index.php/manage/delete_position_data",
                    method:"POST",
                    data:{posi_id:posi_id},
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
                            title: '<?php echo label("cannot_delcom_ifuseractive"); ?>',
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

           $('#add_button').click(function(){
                  var com_id = $('#com_id_search').val();
                  $("#modal-default").modal({backdrop: false});
                  $('.modal-title').text('<?php echo label("addposition"); ?>');
                  $('#position_form')[0].reset();
                  $('#operation').val("Add");
                  $('#com_id').val(com_id);

                  onchk_posigroup($('#posi_group').val());
                      $.ajax({
                            url: '<?=base_url()?>index.php/querydata/rechecklevelmulti',
                            type: 'POST',
                            data:{posi_id:'',com_id:com_id},
                            success: function(data_lv){
                              $('#lv_id').html(data_lv);
                            }
                      });
            });

          $(document).on('click', '.update', function(){
            var posi_id = $(this).attr("id");
            
            $.ajax({
              url:"<?=base_url()?>index.php/manage/update_position_data",
              method:"POST",
              data:{posi_id:posi_id},
              dataType:"json",
              success:function(data)
              {         
                  $("#modal-default").modal({backdrop: false});
                  $('.modal-title').text('<?php echo label("editposition"); ?>');
                  $('#position_form')[0].reset();
                  $('#operation').val("Edit");

                $('#posi_id').val(data.posi_id);
                $('#posi_code').val(data.posi_code);
                $('#posi_shot').val(data.posi_shot);
                $('#posi_group').val(data.posi_group);
                $('#posi_name_en').val(data.posi_name_en);
                $('#posi_name_th').val(data.posi_name_th);
                $('#com_id').val(data.com_id); 

                  onchk_posigroup($('#posi_group').val(),data.posi_id);

                      $.ajax({
                            url: '<?=base_url()?>index.php/querydata/rechecklevelmulti',
                            type: 'POST',
                            data:{posi_id:data.posi_id,com_id:data.com_id},
                            success: function(data_lv){
                              $('#lv_id').html(data_lv);
                            }
                      });
              }
            });
            
          });
    });
    </script>
</body>

</html>