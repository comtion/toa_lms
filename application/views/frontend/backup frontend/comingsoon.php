<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/inc/inc-meta.php'); ?>

<link type="text/css" rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>bootstrap-datepicker.min.css?v=2" />
<link type="text/css" rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>style.css?v=3" />
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>jquery.min.js"></script>
</head>

<body class="page-vdo">

	<?php $this->load->view('frontend/inc/inc-icon.php'); ?>
	<?php $this->load->view('frontend/inc/inc-header.php'); ?>
	<?php $this->load->view('frontend/inc/inc-popupVideo.php'); ?>

<div class="wrapper">

    <div class="section-cate">

    	<div class="container">
        <img src="<?php echo base_url().'assets/img/skin/comingsoon.jpg' ?>" width="100%" />
      </div>
    </div>



</div>

<?php $this->load->view('frontend/inc/inc-footer.php'); ?>

<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>scrolltoload.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>main.js"></script>

</body>
</html>
