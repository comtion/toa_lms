<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/inc/inc-meta-dashboard.php'); ?>
<?php 
          $arrMonthThaiTextShort = array("","ม.ค.","ก.พ.","มี.ค.","เม.ย","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย","ธ.ค.");
          $arrMonthThaiTextFull = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
?>
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
                      <div class="table-responsive">
                          <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                              <tr>
                                <th width="10%"><center><!-- <?php echo label('number'); ?> --></center></th>
                                <!-- <th width="15%"><center><?php echo label('emp_id'); ?></center></th> -->
                                <th width="20%"><center><?php echo label('username'); ?></center></th>
                                <th width="35%"><center><?php echo label('name'); ?></center></th>
                                <th width="20%"><center><?php echo label('unlock_account'); ?></center></th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php $number = 1; foreach ($accounts as $row) {?>
                                <tr>
                                  <td><?php echo $number; ?></td>
                                  <!-- <td style="min-width:auto;"><?php echo $row['emp_c'] ?></td> -->
                                  <td style="min-width:auto;"><?php echo $row['useri']; ?></td>
                                  <td style="min-width:auto;"><?php if($lang=="thai"){ echo $row['fullname_th']; }else{ echo $row['fullname_en']; } ?></td>
                                  <td style="min-width:auto;" align="center">
                                      <form action="<?php echo REAL_PATH.'/dashboard/unlockUser'; ?>" class="form-inline" method="post">
                                        <input type="hidden" name="emp_id" value="<?php echo $row['emp_id']; ?>">
                                        <input type="hidden" name="useri" value="<?php echo $row['useri']; ?>">
                                        <button class="btn btn-default display" type="submit" ><i class="mdi mdi-lock-open"></i> <?php echo label('unlock') ?></button>
                                      </form>
                                  </td>
                                </tr><?php $number++;
                              } ?>
                            </tbody>
                          </table>
                      </div>
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('frontend/inc/inc-footer.php'); ?>
    <!-- This is data table -->
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/datatables/datatables.min.js"></script>
    <!-- start - This is for export functionality only -->
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

    <script type="text/javascript">
    $('.slimtest1').perfectScrollbar();
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
    });
    </script>
</body>

</html>