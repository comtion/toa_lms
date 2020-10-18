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
      <div class="section-topic">
          <div class="topic-group">
              <div class="topic-icon"><img src="assets/img/skin/icon_main-register.svg"></div>
              <h1>โครงการต่างๆ</h1>
          </div>
      </div>
      <div class="section-post">
          <div class="container">
              <div class="row">
                  <div class="listload">
                      <div class="col-md-4 col-sm-6 col-xs-6 col-ss-12 clear-article-row">
                          <a class="thumb thumb-verticle" href="">
                              <div class="thumb-img" style="background-image:url(<?php echo base_url(); ?>uploads/project1.png);"><img src="assets/img/thumb/thumb-380X190.png"></div>
                              <div class="thumb-detail">
                                  <h3 class="thumb-title">โครงการฝึกอบรมการช่วยชีวิตขั้นพื้นฐาน (สำหรับประชาชนทั่วไป)</h3>
                                  <p class="thumb-desc">คำว่า “อ้วน” พูดเบาๆก็เจ็บ <br>นอกจากเจ็บจิต ยังอาจป่วยหัวใจ<br>และอีกหลายที่อีกด้วย! ... </p>
                              </div>
                          </a>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-6 col-ss-12 clear-article-row">
                          <a class="thumb thumb-verticle" href="">
                              <div class="thumb-img" style="background-image:url(<?php echo base_url(); ?>uploads/project2.png);"><img src="assets/img/thumb/thumb-380X190.png"></div>
                              <div class="thumb-detail">
                                  <h3 class="thumb-title">โครงการฝึกอบรมการช่วยชีวิตขั้นพื้นฐาน (สำหรับสถาบันทางการแพทย์)</h3>
                                  <p class="thumb-desc">คำว่า “อ้วน” พูดเบาๆก็เจ็บ <br>นอกจากเจ็บจิต ยังอาจป่วยหัวใจ<br>และอีกหลายที่อีกด้วย! ... </p>
                              </div>
                          </a>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-6 col-ss-12 clear-article-row">
                          <a class="thumb thumb-verticle" href="">
                              <div class="thumb-img" style="background-image:url(<?php echo base_url(); ?>uploads/project3.png);"><img src="assets/img/thumb/thumb-380X190.png"></div>
                              <div class="thumb-detail">
                                  <h3 class="thumb-title">จัดทำหุ่น "สมชาย"สำหรับฝึกอบรมการช่วยชีวิตพื้นฐาน</h3>
                                  <p class="thumb-desc">คำว่า “อ้วน” พูดเบาๆก็เจ็บ <br>นอกจากเจ็บจิต ยังอาจป่วยหัวใจ<br>และอีกหลายที่อีกด้วย! ... </p>
                              </div>
                          </a>
                      </div>
                  </div>

              </div>
          </div>
      </div>
  </div>

<?php $this->load->view('frontend/inc/inc-partner.php'); ?>

</div>

<?php $this->load->view('frontend/inc/inc-footer.php'); ?>

<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>scrolltoload.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>main.js"></script>

</body>
</html>
