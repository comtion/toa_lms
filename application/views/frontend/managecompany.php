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
                        <?php if($btn_add=="1"&&$user['ug_viewdata']=="1"){ ?>
                          <button name="add_button" id="add_button" class="btn btn-outline-info add_button" data-toggle="modal" data-target="#modal-default"><i class="mdi mdi-plus-box-outline"></i> <?php echo label('addcompany'); ?></button>
                        <?php } ?>
                      </div>
                      <div class="table-responsive">
                          <table id="myTable" width="100%" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th style="min-width: 80px !important;" align="center"><center><?php echo label('manage'); ?></center></th>
                                <th width="5%"></th>
                                <th width="20%" align="center"><center><?php echo label('acronym_nickname'); ?></center></th>
                                <th width="35%" align="center"><center><?php echo label('com_name'); ?></center></th>
                                <th width="10%" align="center"><center><?php echo label('com_admin'); ?></center></th>
                                <th width="15%" align="center"><center><?php echo label('m_updatedate'); ?></center></th>
                                <th width="5%" align="center"></th>
                              </tr>
                            </thead>
                          </table>
                      </div>
                      <p><?php echo label('preNote'); ?> : <button type="button" class="btn btn-success btn-xs"><i class="mdi mdi-percent"></i></button> = <b><?php echo label('Score_criteria'); ?></b> , <button type="button" class="btn btn-info btn-xs"><i class="mdi mdi-image-area"></i></button> = <b><?php echo label('banner'); ?></b><?php if($btn_update=="1"){ ?> , <button type="button" class="btn btn-warning btn-xs"><i class="mdi mdi-lead-pencil"></i></button> = <b><?php echo label('m_edit'); ?></b><?php } ?><?php if($btn_delete=="1"&&!in_array($user['ug_id'], array('2','6'))){ ?> , <button type="button" class="btn btn-danger btn-xs"><i class="mdi mdi-window-close"></i></button> = <b><?php echo label('delete'); ?></b><?php } ?></p>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('frontend/inc/inc-footer.php'); ?>
    <?php $this->load->view('frontend/modal/modal_company.php'); ?>


    <div class="modal fade bs-example-modal-lg" id="modal-Score_criteria" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 id="myLargeModalLabel"><?php echo label('Score_criteria'); ?></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <div class="modal-body row">
                <div class="form-group col-md-12 row">
                  <div class="col-md-12">
                    <form method="post" id="Score_criteria_form" autocomplete="off" name="Score_criteria_form" enctype="multipart/form-data"  class="form-horizontal card-body" role="form">
                      <div class="row">
                          <div class="col-md-6">
                              <label><b style="color: #FF2D00">*</b><?php echo label('year'); ?></label>
                              <select id="coms_year" name="coms_year" class="form-control" onchange="onchkyear()">
                                <?php for ($i=date('Y',strtotime('2018-09-24')); $i < date('Y',strtotime('+10 year')); $i++) { ?>
                                <option value="<?php echo $i; ?>" <?php if($i==date('Y')){ echo "selected";} ?>>
                                  <?php 
                                      $yearecho = $i;
                                      echo $lang=="thai"?$yearecho+543:$yearecho; 
                                  ?>
                                </option>
                                <?php } ?>
                              </select>
                          </div>
                      </div><br>
                      <div class="row" id="div_form">
                          <div class="col-md-6 ">
                              <label><b style="color: #FF2D00">*</b><?php echo label('working_experience'); ?></label>
                              <div class="row">
                                <div class="col-md-6">
                                  <input type="number" class="form-control " id="coms_amount" name="coms_amount" required min="0" step="1">
                                </div>
                                <div class="col-md-6">
                                  <select id="coms_type" name="coms_type" class="form-control">
                                    <option value="1" selected><?php echo label('month'); ?></option>
                                    <option value="2"><?php echo label('year'); ?></option>
                                  </select>
                                </div>
                              </div><br>
                          </div>
                          <div class="col-md-3">
                              <label class="control-label"><b style="color: #FF2D00">*</b><?php echo label('status'); ?>:</label>
                              <div class="row">
                                <div class="col-4 text-right">
                                  <small><?php echo label('less'); ?></small>
                                </div>
                                <div class="col-4 text-center">
                                  <div class="switch">
                                    <label>
                                      <input type="checkbox"  id="coms_cond" name="coms_cond" checked value="2">
                                      <span class="lever switch-col-indigo"></span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-4">
                                  <small><?php echo label('greater'); ?></small>
                                </div>                                                                  
                              </div> 
                          </div>
                          <div class="col-md-3">
                              <label class="control-label"><b style="color: #FF2D00">*</b><?php echo label('status'); ?>:</label>
                              <div class="row">
                                <div class="col-4 text-right">
                                  <small><?php echo label('disable'); ?></small>
                                </div>
                                <div class="col-4 text-center">
                                  <div class="switch">
                                    <label>
                                      <input type="checkbox"  id="coms_status" name="coms_status" checked value="1">
                                      <span class="lever switch-col-indigo"></span>
                                    </label>
                                  </div>
                                </div>
                                <div class="col-4">
                                  <small><?php echo label('enable'); ?></small>
                                </div>                                                                  
                              </div> 
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>A+</label>
                              <input type="number" class="form-control" id="coms_a_plus" name="coms_a_plus" min="0" step="1">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>A</label>
                              <input type="number" class="form-control" id="coms_a" name="coms_a" min="0" step="1">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>B+</label>
                              <input type="number" class="form-control" id="coms_b_plus" name="coms_b_plus" min="0" step="1">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>B</label>
                              <input type="number" class="form-control" id="coms_b" name="coms_b" min="0" step="1">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>C+</label>
                              <input type="number" class="form-control" id="coms_c_plus" name="coms_c_plus" min="0" step="1">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>C</label>
                              <input type="number" class="form-control" id="coms_c" name="coms_c" min="0" step="1">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>D+</label>
                              <input type="number" class="form-control" id="coms_d_plus" name="coms_d_plus" min="0" step="1">
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label>D</label>
                              <input type="number" class="form-control" id="coms_d" name="coms_d" min="0" step="1">
                            </div>
                          </div>
                          <div class="col-md-12">
                            <div class="form-group">
                              <label><?php echo label('preNote'); ?>:</label>
                              <textarea class="form-control" rows="4" id="coms_note" name="coms_note"></textarea>
                            </div>
                          </div>
                          <div class="col-md-12" align="right">
                              <button type="submit" class="btn btn-outline-success btn-flat pull-right" name="action_score" id="action_score"><i class="mdi mdi-content-save"></i> <?php echo label('saveR'); ?></button>
                          </div>
                      </div>
                      <input type="hidden" id="com_id_score" name="com_id_score">
                      <input type="hidden" id="coms_id" name="coms_id">
                      <input type="hidden" id="coms_isActive" name="coms_isActive" value="1">
                      <input type="hidden" id="coms_calculate" name="coms_calculate">
                      <input type="hidden" id="operation_score" name="operation_score" value="Add">
                    </form>
                  </div>
                  <div class="form-group col-md-12">
                      <div class="table-responsive">
                        <table id="myTable_score" width="100%" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <th width="5%" class="th_manager"><center><?php echo label('sv_b_manage'); ?></center></th>
                              <th width="5%"></th>
                              <th width="24%"><center><?php echo label('working_experience'); ?></center></th>
                              <th width="7%"><center>A+</center></th>
                              <th width="7%"><center>A</center></th>
                              <th width="7%"><center>B+</center></th>
                              <th width="7%"><center>B</center></th>
                              <th width="7%"><center>C+</center></th>
                              <th width="7%"><center>C</center></th>
                              <th width="7%"><center>D+</center></th>
                              <th width="7%"><center>D</center></th>
                              <th width="5%"><center><?php echo label('status'); ?></center></th>
                              <th width="5%" class="th_manager"><center></center></th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-outline-danger btn-flat" data-dismiss="modal"><i class="mdi mdi-window-close"></i> <?php echo label('close'); ?></button>
              </div>
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
$('body').on('hidden.bs.modal', '.modal', function () {
$(this).removeData('bs.modal');
});

        function onchange_period_a(type){
            var compe_montha_start = parseInt($('#compe_montha_start').val());
            var compe_montha_end = parseInt($('#compe_montha_end').val());
            var compe_monthb_start = parseInt($('#compe_monthb_start').val());
            var compe_monthb_end = parseInt($('#compe_monthb_end').val());
            if(compe_montha_start>compe_montha_end){
              console.log(compe_montha_start,compe_montha_end);
              if(type=="1"){
                  $('#compe_montha_start').val($('#compe_montha_end').val());
              }else{
                  $('#compe_montha_end').val($('#compe_montha_start').val());
              }
            }else{
                  if(compe_montha_end>compe_monthb_start||compe_montha_end>compe_monthb_end){
                      $('#compe_monthb_start').val($('#compe_montha_end').val());
                      $('#compe_monthb_end').val($('#compe_montha_end').val());
                  }
            }
        }
        function onchange_period_b(type){
            var compe_montha_start = parseInt($('#compe_montha_start').val());
            var compe_montha_end = parseInt($('#compe_montha_end').val());
            var compe_monthb_start = parseInt($('#compe_monthb_start').val());
            var compe_monthb_end = parseInt($('#compe_monthb_end').val());
            if(compe_monthb_start>compe_monthb_end){
              if(type=="1"){
                  $('#compe_monthb_start').val($('#compe_monthb_start').val());
              }else{
                  $('#compe_monthb_end').val($('#compe_monthb_start').val());
              }
            }else{
                  if(compe_montha_end>compe_monthb_start||compe_montha_end>compe_monthb_end){
                      $('#compe_monthb_start').val($('#compe_montha_end').val());
                      $('#compe_monthb_end').val($('#compe_montha_end').val());
                  }
            }
        }
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

      function onchkyear(){
        var yearnow = parseInt('<?php echo date("Y"); ?>');
        var yearselect = parseInt($('#coms_year').val());
        var com_id = $('#com_id_score').val();
        if(yearnow<=yearselect){
          $('#div_form').show();
          //$('.th_manager').show();
          $('#coms_isActive').val(1);
          fetch_data_score(0,com_id,1);
        }else{
          $('#div_form').hide();
          //$('.th_manager').hide();
          $('#coms_isActive').val(0);
          fetch_data_score(0,com_id,0);
        }
      }
      function forceLower(strInput) 
      {
        strInput.value=strInput.value.toLowerCase();
      }
      fetch_data_main(0);
      function fetch_data_main(page_num)
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
            "scrollX": true,
                "ajax": {
                    url : '<?=base_url()?>index.php/manage/fetch_detail_company/',
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
      function fetch_data_score(page_num,com_id,isActive)
         {
            $('#myTable_score').DataTable();
            $('#myTable_score').DataTable().destroy();
            var table = $('#myTable_score').DataTable({
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
                    url : '<?=base_url()?>index.php/manage/fetch_detail_company_score/',
                    type : 'GET',
                    data : {com_id:com_id,isActive:isActive}
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
        function clear_dropify(id){
                    $('.'+id).dropify(); 
        }
           /*$('#add_button').click(function(){
                $("#modal-default").modal({backdrop: false});
                $('.modal-title').text('<?php echo label("addcompany"); ?>');
                $('#operation').val("Add");
                $('#company_form')[0].reset();

                clear_dropify('com_logo_top');
                clear_dropify('com_logo_footer');
                //clear_dropify('com_logo');
            });*/
         function fetch_data(com_id)
         {
            $('#myTable_banner').DataTable().destroy();
            $('#myTable_banner').DataTable({
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
                    url : '<?=base_url()?>index.php/setting/fetch_banner/'+com_id,
                    type : 'GET'
                },
            });
         }
         $(document).on('click', '.import_user', function(){
            var com_id = $(this).attr("id");
            $('#com_id_import_user').val(com_id);

            clear_dropify('file_import');
            $("#modal-import_user").modal({backdrop: false});

            $.ajax({
              url: '<?=base_url()?>index.php/manage/recheckusergroup',
              type: 'POST',
              data:{com_id:com_id},
              success: function(data){
                $('#ug_id').html(data);
              }
            }); 
          });

        $(document).on('submit', '#import_user_form', function(event){
              event.preventDefault(); 
              var com_id = $('#com_id_import_user').val();
              var file_import = $('#file_import').val();
              if(file_import!=""){
                $.ajax({
                  url:"<?=base_url()?>index.php/setting/import_user",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  success:function(data)
                  {
                    if(data=="2"){
                        $('#import_user_form')[0].reset();
                        swal(
                            '<?php echo label("import_msg_success"); ?>!',
                            '',
                            'success'
                        ).then(function () {
        				            $.ajax({
        				              url: '<?=base_url()?>index.php/manage/recheckusergroup',
        				              type: 'POST',
        				              data:{com_id:com_id},
        				              success: function(data){
        				                $('#ug_id').html(data);
        				              }
        				            }); 
                    				$('#com_id_import_user').val(com_id);

                            var imagenUrl = "";
                            var drEvent = $('#file_import').dropify(
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
                    }else if(data=="1"){
                        swal({
                            title: '<?php echo label("manageimport_msgerror"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            document.getElementById("file_import").focus();
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
              }else{
                
                        swal({
                            title: '<?php echo label("manageimport_msgerror"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            document.getElementById("file_import").focus();
                        })
              }
         });

         $(document).on('click', '.Score_criteria', function(){
            var com_id = $(this).attr("id");
            $("#modal-Score_criteria").modal({backdrop: false});
            $('#Score_criteria_form')[0].reset();
            $('#com_id_score').val(com_id);
            $('#operation_score').val("Add");
            onchkyear();
          });

         $(document).on('click', '.bannerbtn', function(){
            var com_id = $(this).attr("id");
            $('#com_id_banner').val(com_id);
            fetch_data(com_id);
            $('.dropifymain').dropify();
            $("#modal-banner").modal({backdrop: false});
            clear_dropify('banner');
          });
         $(document).on('click', '.delete_banner', function(){
            var id = $(this).attr("id");
            var com_id = $('#com_id_banner').val();
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
                    url:"<?=base_url()?>index.php/setting/delete_banner",
                    method:"POST",
                    data:{id_delete:id,table_name:"LMS_BAN"},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("com_msg_delete"); ?>!',
                            '',
                            'success'
                        ).then(function () {
                          fetch_data(com_id);
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
         

        $(document).on('submit', '#banner_form', function(event){
              event.preventDefault(); 
              var com_id = $('#com_id_banner').val();
              var banner = $('#banner').val();
              if(banner!=""){
                $.ajax({
                  url:"<?=base_url()?>index.php/setting/insert_banner",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  success:function(data)
                  {
                    if(data=="2"){
                        $('#banner_form')[0].reset();
                        swal(
                            '<?php echo label("com_msg_success"); ?>!',
                            '',
                            'success'
                        ).then(function () {
                            fetch_data(com_id);
                            var imagenUrl = "";
                            var drEvent = $('#banner').dropify(
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
                    }else if(data=="1"){
                        swal({
                            title: '<?php echo label("managebanner_msgerror"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            document.getElementById("banner").focus();
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
              }else{
                
                        swal({
                            title: '<?php echo label("managebanner_msgerror"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            document.getElementById("banner").focus();
                        })
              }
                
            });

    $(document).ready(function() {
        $('.dropify').dropify();
        //$('#myTable').DataTable();
        $(document).on('submit', '#company_form', function(event){
              event.preventDefault(); 
              $('#com_admin').prop('disabled', false);
                $.ajax({
                  url:"<?=base_url()?>index.php/manage/insert_company",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  success:function(data)
                  {
                    if(data=="2"){
                        $('#company_form')[0].reset();
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
            })

        $(document).on('submit', '#Score_criteria_form', function(event){
              event.preventDefault(); 
              var com_id = $('#com_id_score').val();
                $.ajax({
                  url:"<?=base_url()?>index.php/manage/insert_company_score",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  success:function(data)
                  {
                    if(data=="2"){
                        $('#Score_criteria_form')[0].reset();
                        swal(
                            '<?php echo label("com_msg_success"); ?>!',
                            '',
                            'success'
                        ).then(function () {
                          $('#com_id_score').val();
                          $('#operation_score').val('Add');
                          var coms_isActive = $('#coms_isActive').val();
                                    var table = $('#myTable_score').DataTable();
                                      var info = table.page.info();
                                      var length = info.pages;
                                      var page_current = info.page;
                                      fetch_data_score(page_current,com_id,coms_isActive);
                                      /*location.reload();*/
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
            var com_id = $(this).attr("id");
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
                    url:"<?=base_url()?>index.php/manage/delete_company_data",
                    method:"POST",
                    data:{com_id_delete:com_id},
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

         $(document).on('click', '.delete_score', function(){
            var coms_id = $(this).attr("id");
            var com_id = $('#com_id_score').val();
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
                    url:"<?=base_url()?>index.php/manage/delete_company_score_data",
                    method:"POST",
                    data:{coms_id:coms_id},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("com_msg_delete"); ?>',
                            '',
                            'success'
                        ).then(function () {
                          var coms_isActive = $('#coms_isActive').val();
                                    var table = $('#myTable_score').DataTable();
                                      var info = table.page.info();
                                      var length = info.pages;
                                      var page_current = info.page;
                                      fetch_data_score(page_current,com_id,coms_isActive);
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

        function clear_dropify(id){
                    var imagenUrl = "";
                    var drEvent = $('.'+id).dropify(
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
                  $('.modal-title').text('<?php echo label("addcompany"); ?>');
                  $('#company_form')[0].reset();
                  $('#operation').val("Add");
                  clear_dropify('dropify_top');
                  clear_dropify('dropify_footer');
                    $('#com_code').attr('readonly', false);
                    $('#com_name_th').attr('readonly', false);
                    $('#com_name_eng').attr('readonly', false);
                    $('#com_admin').attr('readonly', false);
                    $('#com_mail').attr('readonly', false);
                    $('#com_emaildomain').attr('readonly', false);
            });

          $(document).on('click', '.update', function(){
            var com_id = $(this).attr("id");
            
            $.ajax({
              url:"<?=base_url()?>index.php/manage/update_company_data",
              method:"POST",
              data:{com_id_update:com_id},
              dataType:"json",
              success:function(data)
              {                


                  $("#modal-default").modal({backdrop: false});
                  $('.modal-title').text('<?php echo label("editcompany"); ?>');
                  $('#company_form')[0].reset();
                  $('#operation').val("Edit");
                  $('.dropify_top').dropify();
                  $('.dropify_footer').dropify();

                    $('#com_logo_top_ori').val(data.com_logo_top);
                    $('#com_logo_footer_ori').val(data.com_logo_footer);
                    if(data.com_logo_top!=""){
                        var nameImage = "<?php echo REAL_PATH;?>/uploads/logo/"+data.com_logo_top
                        var drEvent_top = $(".dropify_top").dropify(
                        {
                          defaultFile: nameImage
                        });
                        drEvent_top = drEvent_top.data('dropify');
                        drEvent_top.resetPreview();
                        drEvent_top.clearElement();
                        drEvent_top.settings.defaultFile = nameImage;
                        drEvent_top.destroy();
                        drEvent_top.init();

                        var drEvent_top = $('.dropify_top').dropify({
                            defaultFile: "<?php echo REAL_PATH;?>/uploads/logo/"+data.com_logo_top ,
                        });

                        var dropifyElementtop = {};
                        $('.dropify_top').each(function() {
                            dropifyElementtop[this.id] = true;
                        });

                        drEvent_top.on('dropify.beforeClear', function(event, element){
                            $('#com_logo_top_ori').val("");
                        });
                    }else{
                        var nameImage = "";
                        var drEvent_top = $(".dropify_top").dropify(
                        {
                          defaultFile: nameImage
                        });
                        drEvent_top = drEvent_top.data('dropify');
                        drEvent_top.resetPreview();
                        drEvent_top.clearElement();
                        drEvent_top.settings.defaultFile = nameImage;
                        drEvent_top.destroy();
                        drEvent_top.init();
                    }

                    if(data.com_logo_footer!=""){

                        var nameImage = "<?php echo REAL_PATH;?>/uploads/logo/"+data.com_logo_footer
                        var drEvent = $('.dropify_footer').dropify(
                        {
                          defaultFile: nameImage
                        });
                        drEvent = drEvent.data('dropify');
                        drEvent.resetPreview();
                        drEvent.clearElement();
                        drEvent.settings.defaultFile = nameImage;
                        drEvent.destroy();
                        drEvent.init();

                        var drEvent = $('.dropify_footer').dropify({
                            defaultFile: "<?php echo REAL_PATH;?>/uploads/logo/"+data.com_logo_footer ,
                        });
                        var dropifyElementfooter = {};
                        $('.com_logo_footer').each(function() {
                            dropifyElementfooter[this.id] = true;
                        });

                        drEvent.on('dropify.beforeClear', function(event, element){

                            $('#com_logo_footer_ori').val("");
                        });
                    }else{
                        var nameImage = "";
                        var drEvent = $('.dropify_footer').dropify(
                        {
                          defaultFile: nameImage
                        });
                        drEvent = drEvent.data('dropify');
                        drEvent.resetPreview();
                        drEvent.clearElement();
                        drEvent.settings.defaultFile = nameImage;
                        drEvent.destroy();
                        drEvent.init();
                    }
                  <?php if($user['ug_id']!="1"){ ?>
                    $('#com_code').attr('readonly', true);
                    $('#com_name_th').attr('readonly', true);
                    $('#com_name_eng').attr('readonly', true);
                    $('#com_mail').attr('readonly', true);
                    $('#com_admin').prop('disabled', true);
                    $('#com_emaildomain').attr('readonly', true);
                    <?php if(in_array($user['ug_id'], array('2','6'))){ ?>
                    $('#com_mail').attr('readonly', false);
                    <?php } ?>
                  <?php }else{ ?>
                    $('#com_code').attr('readonly', false);
                    $('#com_name_th').attr('readonly', false);
                    $('#com_name_eng').attr('readonly', false);
                    $('#com_admin').attr('readonly', false);
                    $('#com_mail').attr('readonly', false);
                    $('#com_admin').prop('disabled', false);
                    $('#com_emaildomain').attr('readonly', false);
                  <?php } ?>

                $('#com_code').val(data.com_code);
                $('#com_name_th').val(data.com_name_th);
                $('#com_name_eng').val(data.com_name_eng);
                $('#com_admin').val(data.com_admin);
                $('#com_mail').val(data.com_mail);
                $('#com_emaildomain').val(data.com_emaildomain);
                $('#com_tel').val(data.com_tel);
                $('#com_fax').val(data.com_fax);  
                $('#com_add_th').val(data.com_add_th);
                $('#com_add_eng').val(data.com_add_eng); 
                $('#com_id').val(data.com_id); 
                $('#com_wctitle_th').val(data.com_wctitle_th); 
                $('#com_wctitle_eng').val(data.com_wctitle_eng); 
                $('#compe_montha_start').val(data.compe_montha_start);
                $('#compe_montha_end').val(data.compe_montha_end);
                $('#compe_monthb_start').val(data.compe_monthb_start);
                $('#compe_monthb_end').val(data.compe_monthb_end);
                $(tinymce.get('com_wcmessage_th').getBody()).html(data.com_wcmessage_th);
                $(tinymce.get('com_wcmessage_eng').getBody()).html(data.com_wcmessage_eng);
              }
            });
            
          });

          $(document).on('click', '.update_score', function(){
            var coms_id = $(this).attr("id");
            
            $.ajax({
              url:"<?=base_url()?>index.php/manage/update_company_score_data",
              method:"POST",
              data:{coms_id:coms_id},
              dataType:"json",
              success:function(data)
              {                
                  $('#Score_criteria_form')[0].reset();
                  $('#operation_score ').val("Edit");
                $('#coms_id').val(data.coms_id);
                $('#coms_amount').val(data.coms_amount);
                $('#coms_type').val(data.coms_type);
                $('#coms_a_plus').val(data.coms_a_plus);
                $('#coms_a').val(data.coms_a);
                $('#coms_b_plus').val(data.coms_b_plus);
                $('#coms_b').val(data.coms_b);
                $('#coms_c_plus').val(data.coms_c_plus);
                $('#coms_c').val(data.coms_c);  
                $('#coms_d_plus').val(data.coms_d_plus);
                $('#coms_d').val(data.coms_d); 
                $('#coms_note').val(data.coms_note); 
                $('#com_id_score').val(data.com_id); 
                $('#coms_calculate').val(data.coms_calculate); 
                $('#coms_year').val(data.coms_year);
                if(data.coms_status=="1"){
                    document.getElementById("coms_status").checked = true;
                }else{
                    document.getElementById("coms_status").checked = false;
                }
                if(data.coms_cond=="2"){
                    document.getElementById("coms_cond").checked = true;
                }else{
                    document.getElementById("coms_cond").checked = false;
                }
                onchkyear();
              }
            });
            
          });
    });
    </script>
</body>

</html>