<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/inc/inc-meta.php'); ?>

<link type="text/css" rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>style.css?v=3" />
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>jquery.min.js"></script>
</head>

<body class="page-contact">
	<?php $this->load->view('frontend/inc/inc-icon.php'); ?>
  <?php $this->load->view('frontend/inc/inc-header.php'); ?>

<div class="wrapper">

    <div class="section-contact">
        <div class="container">
        	<div id="map"></div>
        </div>
        <div class="section-topic">
            <div class="topic-group">
                <div class="topic-icon"><img src="<?php echo base_url(); ?>assets/img/skin/icon_main-contact.svg"></div>
                <h1>ติดต่อเรา</h1>
            </div>
        </div>
        <div class="container">
            <div class="row">
            	<div class="col-md-5 col-sm-5 col-xs-12 contact-info ">
                	<div class="box-content">
                        <h2>มูลนิธิหัวใจแห่งประเทศไทย ในพระบรมราชูปถัมภ์<br>(The Heart Foundation of Thailand Office )</h2>
                        <p>
                        เลขที่ 2 ชั้น 5 อาคารเฉลิมพระบารมี 50 ปี<br>ซ.ศูนย์วิจัย (เพชรบุรี 47) ถ.เพชรบุรีตัดใหม่<br>
                        แขวงบางกะปิ เขตห้วยขวาง กรุงเทพฯ 10310<br>
                        </p>
                        <ul class="list-infoContact">
                            <li><img src="<?php echo base_url(); ?>assets/img/skin/icon-mobile.svg"> <span><a href="tel:027166658">0-2716-6658</a>, <a href="tel:027166843">0-2716-6843</a></span></li>
                            <li><img src="<?php echo base_url(); ?>assets/img/skin/icon-fax.svg"> <span>0-2716-5813</span></li>
                            <li><img src="<?php echo base_url(); ?>assets/img/skin/icon-email.svg"> <span><a href="mailto:thaiheart_fd@hotmail.com">thaiheart_fd@hotmail.com</a></span></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-7 col-sm-7 col-xs-12 contact-form">
                	<!--<img style=" max-width:100%;" src="assets/img/skin/image-map.jpg">-->
                	<div class="row">
                        <form id="contact-form" method="post" action="<?php echo base_url().'contact/sendEmail'; ?>">
													<div class="listfeild col-md-6 col-sm-6 col-xs-12"><div class="checkvalid">กรุณากรอกชื่อ</div><input type="text" name="firstname" placeholder="ชื่อ"></div>
													<div class="listfeild col-md-6 col-sm-6 col-xs-12"><div class="checkvalid">กรุณากรอกนามสกุล</div><input type="text" name="lastname" placeholder="นามสกุล"></div>
													<div class="listfeild col-md-6 col-sm-6 col-xs-12"><div class="checkvalid">กรุณากรอกอีเมล</div><input type="text" name="email" placeholder="อีเมล"></div>
													<div class="listfeild col-md-6 col-sm-6 col-xs-12"><div class="checkvalid">กรุณากรอกเบอร์โทร</div><input type="text" name="telephone" placeholder="เบอร์โทรศัพท์" maxlength="10"></div>
													<div class="listfeild col-md-12 col-sm-12 col-xs-12"><textarea name="message" placeholder="ข้อความ"></textarea> </div>
													<div class="submit-form  col-md-12 col-sm-12 col-xs-12"><input type="submit" value="ส่ง"></div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<?php $this->load->view('frontend/inc/inc-footer.php'); ?>

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyBtJBuLdgv-hEpjZXkdlKWGbULBJUwZAb4"></script>
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>map.js"></script>
<script src="//apis.google.com/js/platform.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>main.js"></script>
</body>
</html>
