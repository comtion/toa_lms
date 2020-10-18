<!DOCTYPE html>
<html itemscope itemtype="http://schema.org/Product">
<?php
  function isMobile() {
      return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
  }
  header ("Last-Modified: " . gmdate ("D, d M Y H:i") . " GMT");
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>
  <?php if(!isset($title)){if($lang=="thai"){echo $foote[0]['da_title_th'];}else{echo $foote[0]['da_title_en'];}}else{ echo $title; } ?>
</title>
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo REAL_PATH; ?>/assets/images/logo/logo-text.png">
<!-- Bootstrap Core CSS -->
<link href="<?php echo REAL_PATH; ?>/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="<?php echo REAL_PATH; ?>/assets/plugins/icheck/skins/all.css" rel="stylesheet">
<link href="<?php echo REAL_PATH;?>/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css" />
<!-- icheck css -->
<link href="<?php echo REAL_PATH; ?>/assets/css/pages/form-icheck.css" rel="stylesheet">
<!--alerts CSS -->
<link href="<?php echo REAL_PATH; ?>/assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
<!--datepicker CSS -->
<link href="<?php echo REAL_PATH;?>/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet" type="text/css" />
<!--dropify CSS -->
<link rel="stylesheet" href="<?php echo REAL_PATH; ?>/assets/plugins/dropify/dist/css/dropify.min.css">
<!--multiselect CSS -->
<link href="<?php echo REAL_PATH; ?>/assets/plugins/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" />
<!--c3 CSS -->
  <link href="<?php echo REAL_PATH;?>/assets/plugins/c3-master/c3.min.css" rel="stylesheet">
<!-- page css -->
<link href="<?php echo REAL_PATH; ?>/assets/css/pages/card-page.css" rel="stylesheet">
<!-- animate css -->
<link href="<?php echo REAL_PATH;?>/assets/css/footers.css" rel="stylesheet">
<link href="<?php echo REAL_PATH;?>/assets/plugins/aos/dist/aos.css" rel="stylesheet">
<link href="<?php echo REAL_PATH;?>/assets/plugins/prism/prism.css" rel="stylesheet">
<!-- chartist CSS -->
    <link href="<?php echo REAL_PATH;?>/assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="<?php echo REAL_PATH;?>/assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
<!-- Dashboard 1 Page CSS -->
<link href="<?php echo REAL_PATH; ?>/assets/css/pages/dashboard1.css" rel="stylesheet">
<!-- Custom CSS -->
<link href="<?php echo REAL_PATH; ?>/assets/css/style.css" rel="stylesheet">
<!-- You can change the theme colors from here -->
<link href="<?php echo REAL_PATH; ?>/assets/css/colors/default.css" id="theme" rel="stylesheet">
<link href="<?php echo REAL_PATH; ?>/assets/css/custom_toa.css" rel="stylesheet">

<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->
<script src="<?php echo REAL_PATH; ?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap tether Core JavaScript -->
<script src="<?php echo REAL_PATH; ?>/assets/plugins/bootstrap/js/popper.min.js"></script>
<script src="<?php echo REAL_PATH; ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!--Wave Effects -->
<script src="<?php echo REAL_PATH; ?>/assets/js/waves.js"></script>
<!--Menu sidebar -->
<script src="<?php echo REAL_PATH; ?>/assets/js/sidebarmenu.js"></script>
<!-- CHART -->
<script src="<?php echo REAL_PATH; ?>/assets/plugins/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js"></script>
<script src="<?php echo REAL_PATH; ?>/assets/plugins/Chart.js/Chart.min.js"></script>
<script src="<?php echo REAL_PATH; ?>/assets/plugins/knob/jquery.knob.js"></script>
<!--Custom JavaScript -->
<script src="<?php echo REAL_PATH; ?>/assets/js/custom.min.js"></script>
<script src="<?php echo REAL_PATH; ?>/assets/js/custom_toa.js"></script>
<!-- ============================================================== -->
<!-- This page plugins -->
<!-- ============================================================== -->
<!-- <script src="<?php //echo REAL_PATH; ?>/assets/js/dashboard1.js"></script>
<script src="<?php //echo REAL_PATH; ?>/assets/plugins/moment/moment.js"></script> -->
<!-- ============================================================== -->
<!-- Style switcher -->
<!-- ============================================================== -->
<script src="<?php echo REAL_PATH; ?>/assets/js/perfect-scrollbar.jquery.min.js"></script>
<script src="<?php echo REAL_PATH; ?>/assets/plugins/dropify/dist/js/dropify.min.js"></script>
<!-- Sweet-Alert  -->
<script src="<?php echo REAL_PATH; ?>/assets/plugins/sweetalert/sweetalert.min.js"></script>
<script src="<?php echo REAL_PATH; ?>/assets/plugins/sweetalert/jquery.sweet-alert.custom.js"></script>
<script src="<?php echo REAL_PATH; ?>/assets/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
<script src="<?php echo REAL_PATH; ?>/assets/plugins/select2/dist/js/select2.min.js"></script>
<style type="text/css">
        #myBtn {
          background-color: rgb(156,159,164);
          width: 40px;
          height: 40px;
          display: none;
          position: fixed;
          bottom: 20px;
          right: 30px;
          z-index: 99;
          border: none;
          outline: none;
          color: white;
          cursor: pointer;
          border-radius: 4px;
        }

        #myBtn:hover {
          background-color: rgb(236,32,41);
        }
</style>