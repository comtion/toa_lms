<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/inc/inc-meta-dashboard.php'); ?>

    <link href="<?php echo REAL_PATH;?>/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo REAL_PATH;?>/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo REAL_PATH;?>/assets/plugins/switchery/dist/switchery.min.css" rel="stylesheet" />
    <link href="<?php echo REAL_PATH;?>/assets/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" />
    <link href="<?php echo REAL_PATH;?>/assets/plugins/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" type="text/css" href="<?php echo REAL_PATH; ?>/assets/plugins/datatables/media/css/dataTables.bootstrap4.css">
    <!-- Date picker plugins css -->
    <link href="<?php echo REAL_PATH;?>/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
    <!-- Daterange picker plugins css -->
    <link href="<?php echo REAL_PATH;?>/assets/plugins/timepicker/bootstrap-timepicker.min.css" rel="stylesheet">
    <link href="<?php echo REAL_PATH;?>/assets/plugins/daterangepicker/daterangepicker.css" rel="stylesheet">

    <script type="text/javascript" src="<?php echo REAL_PATH;?>/assets/js/adapter.min.js"></script>
    <script type="text/javascript" src="<?php echo REAL_PATH;?>/assets/js/vue.min.js"></script>
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
                            <div class="row">
                                <?php if($com_admin!="com_associated"&&($user['ug_id']=="1")){ ?>
                                <div class="col-md-6">
                                    <label for="status_cr"><?php echo label('com_name'); ?>:</label>
                                    <select class="form-control select2" id="com_id" name="com_id"  style="width: 100%;">
                                        <option value="" selected><?php echo label('allcompany'); ?></option>
                                        <?php foreach( $company_select as $company ){ ?>
                                            <option value="<?php echo $company['com_id']; ?>"><?php if($lang=="thai"){ echo $company['com_name_th']; }else{ echo $company['com_name_eng']; } ?></option>
                                        <?php  } ?>
                                    </select>
                                </div>
                                <?php }else{ ?>
                                        <input type="hidden" id="com_id" name="com_id" value="<?php echo $com_id; ?>">
                                <?php } ?>
                                <div class="col-md-6">
                                  <div class="form-group">
                                    <label for="cg_id"><?php echo label('r_course_type'); ?>:</label>
                                    <select class="form-control select2" id="cg_id" name="cg_id"  style="width: 100%;">
                                        <option value="" selected><?php echo label('dash_b_please_sel_cos'); ?></option>
                                    </select>
                                  </div>
                                </div>
                            </div>
                            <?php if($com_admin!="com_associated"){ ?>
                            <hr>
                            <?php } ?>
                            <div class="table-responsive">
                                  <table id="myTable" width="100%" class="table table-bordered">
                                    <thead>
                                      <tr>
                                        <th width="5%" ><center><?php echo label('detail'); ?></center></th>
                                        <th width="5%"></th>
                                        <th width="20%" ><center><?php echo label('ceCname'); ?></center></th>
                                        <?php if($user['ug_id']=="1"){ ?>
                                        <th width="10%" ><center><?php echo label('com_name'); ?></center></th>
                                        <?php } ?>
                                        <th width="10%" ><center><?php echo label('course_status'); ?></center></th>
                                        <th width="10%" ><center><?php echo label('r_average_score'); ?></center></th>
                                        <th width="10%" ><center><?php echo label('total_learner'); ?></center></th>
                                        <th width="10%" ><center><?php echo label('lrn_btn_done'); ?></center></th>
                                        <th width="10%" ><center><?php echo label('inProgress'); ?></center></th>
                                        <th width="10%" ><center><?php echo label('not_start'); ?></center></th>
                                      </tr>
                                    </thead>
                                  </table>
                            </div>
                            <p><?php echo label('preNote'); ?>: <button type="button" class="btn btn-info btn-xs"><i class="mdi mdi-format-list-bulleted"></i></button> = <b><?php echo label('r_viewDetail'); ?></b></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    
    <div class="modal fade bs-example-modal-lg" tabindex="-1" id="modal-enroll" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-height: 100%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="myLargeModalLabel"><?php echo label('cos_report_details'); ?>: <span id="txtshow_cosname"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="card-body">
                        <div class="table-responsive">
                                  <table id="myTable_detail" width="1800" class="table table-bordered table-striped">
                                    <thead>
                                      <tr>
                                        <th width="200" ><center><?php echo label('username'); ?></center></th>
                                        <th width="250" ><center><?php echo label('m_name'); ?></center></th>
                                        <th width="200" ><center><?php echo label('m_company'); ?></center></th>
                                        <th width="200" ><center><?php echo label('r_position'); ?></center></th>
                                        <th width="150" ><center><?php echo label('learning_status'); ?></center></th>
                                        <th width="150" ><center><?php echo label('score_pretest'); ?></center></th>
                                        <th width="150" ><center><?php echo label('maxScore')."<br>(".label('score_pretest').")"; ?></center></th>
                                        <th width="150" ><center><?php echo label('score_posttest'); ?></center></th>
                                        <th width="150" ><center><?php echo label('maxScore')."<br>(".label('score_posttest').")"; ?></center></th>
                                        <th width="150" ><center><?php echo label('preReport'); ?></center></th>
                                        <th width="200" ><center><?php echo label('r_finish_emp'); ?></center></th>
                                      </tr>
                                    </thead>
                                  </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-flat" data-dismiss="modal"><?php echo label('close'); ?></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

            <?php $this->load->view('frontend/inc/inc-footer.php'); ?>
    <!-- This is data table -->
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/datatables/datatables.min.js"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>

    <script src="<?php echo REAL_PATH; ?>/assets/js/dataTables.buttons.min.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/js/buttons.flash.min.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/js/jszip.min.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/js/pdfmake.min.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/js/vfs_fonts.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/js/buttons.html5.min.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/js/buttons.print.min.js"></script>
    <script type="text/javascript">
         $('.select2').select2();
        <?php if($com_admin!="com_associated"&&($user['ug_id']=="1")){ ?>
            fetch_data_coursename('');
        <?php }else{ ?>
            fetch_data_coursename('<?php echo $com_id; ?>');
            $.ajax({
                  url:"<?=base_url()?>index.php/querydata/option_coursegroups",
                  method:"POST",
                  data:{com_id:'<?php echo $com_id; ?>'},
                  success:function(data)
                  {
                        $('#cg_id').html(data);
                  }
            });
        <?php } ?>

        $('select[name="com_id"]').on('change', function(){
          var com_id = $(this).val();
          fetch_data_coursename();

            $.ajax({
                  url:"<?=base_url()?>index.php/querydata/option_coursegroups",
                  method:"POST",
                  data:{com_id:com_id},
                  success:function(data)
                  {
                        $('#cg_id').html(data);
                  }
            });
        });

        $('select[name="cg_id"]').on('change', function(){
            fetch_data_coursename();
        });
        function fetch_data_coursename()
         {
            var com_id = $('#com_id').val();
            var cg_id = $('#cg_id').val();
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
                    url: '<?=base_url()?>index.php/report/fetch_coursename_company/',
                    data: {com_id:com_id,cg_id:cg_id},
                    type: 'GET'
                },
                <?php if($btn_print=="1"){?>
                dom: 'Bfrtip',
                buttons: [
                    //'csvHtml5'
                    {
                        extend: 'copy',
                        exportOptions: {
                          <?php if($user['ug_id']=="1"){ ?>
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                          <?php }else{ ?>
                            columns: [1, 2, 3, 4, 5, 6, 7, 8]
                          <?php } ?>
                        },
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                          <?php if($user['ug_id']=="1"){ ?>
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                          <?php }else{ ?>
                            columns: [1, 2, 3, 4, 5, 6, 7, 8]
                          <?php } ?>
                        },
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                          <?php if($user['ug_id']=="1"){ ?>
                            columns: [1, 2, 3, 4, 5, 6, 7, 8, 9]
                          <?php }else{ ?>
                            columns: [1, 2, 3, 4, 5, 6, 7, 8]
                          <?php } ?>
                        },
                    },
                ],
                <?php } ?>
            });
         }
        function fetch_data_course_detail(cos_id)
         {
            $('#myTable_detail').DataTable().destroy();
            $('#myTable_detail').DataTable({
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
                    url: '<?=base_url()?>index.php/report/fetch_coursename_detail/',
                    data: {cos_id:cos_id},
                    type: 'GET'
                },
                <?php if($btn_print=="1"){?>
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'print'
                ]
                <?php } ?>
            });
         }

         $(document).on('click', '.view_detail', function(){
            var id = $(this).attr("id");
            $("#modal-enroll").modal({backdrop: false});
            $.ajax({
                  url:"<?=base_url()?>index.php/querydata/query_coursemain",
                  method:"POST",
                  data:{cos_id:id},
                  dataType:"json",
                  success:function(data)
                  {
                        $('#txtshow_cosname').html(" "+data.cname_main);
                  }
            });
            fetch_data_course_detail(id);
          });
    </script>
</body>

</html>