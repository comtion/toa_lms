<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/inc/inc-meta.php'); ?>

<link type="text/css" rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>bootstrap-datepicker.min.css?v=2" />
<link type="text/css" rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>style.css?v=3" />
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>jquery.min.js"></script>
</head>

<body class="page-category page-<?php echo $page; ?>">

	<?php $this->load->view('frontend/inc/inc-icon.php'); ?>
	<?php $this->load->view('frontend/inc/inc-header.php'); ?>
	<?php $this->load->view('frontend/inc/inc-popupVideo.php'); ?>

<div class="wrapper">
	<?php
		if( $page == "food"){
			$headimg = "head-content-food.jpg";
			$title = "อาหาร...ดีต่อใจ";
			$icon = "icon_main-food.svg";
		}
		if( $page == "exercise"){
			$headimg = "head-content-exercise.jpg";
			$title = "ออกกำลังกาย...ดีต่อใจ";
			$icon = "icon_main-exercise.svg";
		}
		if( $page == "mood"){
			$headimg = "head-content-emotion.jpg";
			$title = "อารมณ์...ดีต่อใจ";
			$icon = "icon_main-mood.svg";
		}
		if( $page == "news"){
			$headimg = "head-content-emotion.jpg";
			$title = "ข่าวและกิจกรรม";
			$icon = "icon_main-news.svg";
		}
  ?>
<?php if( $page !== "news" ){ ?>
    <div class="section-headcontent" style="background-image:url(<?php echo base_url(); ?>assets/img/demo/<?php echo $headimg; ?>);">
    	<div class="container">
        	<div class="headcontent-imgblank"><img class="mobileHide" src="<?php echo base_url(); ?>assets/img/thumb/thumb-headcontent.png"><img class="mobileShow" src="<?php echo base_url(); ?>assets/img/thumb/thumb-banner-m.png"></div>
        </div>
    </div>
<?php } ?>
    <div class="section-topic">
    	<div class="topic-group">
        	<div class="topic-icon"><img src="<?php echo base_url(); ?>assets/img/skin/<?php echo $icon; ?>"></div>
            <h1><?php echo $title; ?></h1>
        </div>
    </div>
    <div class="section-post">
    	<div class="container">
        	<div class="row">
            	<div class="listload">
                    <?php foreach( $lists as $list ){ ?>
	                    <div class="col-md-4 col-sm-6 col-xs-6 col-ss-12 clear-article-row">
	                        <a class="thumb thumb-verticle" href="<?php echo base_url().'category/details/'.$page.'/'.$list['cpid']; ?>">
	                            <div class="thumb-img" style="background-image:url(<?php echo base_url(); ?>uploads/<?php echo $list['cp_titleimg']; ?>);"><img src="<?php echo base_url(); ?>assets/img/thumb/thumb-380X190.png"></div>
	                            <div class="thumb-detail">
																<h3 class="thumb-title"><?php echo $list['cp_titlehead']; ?></h3>
																<p class="thumb-desc"><?php echo $list['cp_titletext']; ?></p>
	                            </div>
	                        </a>
	                    </div>
                    <?php } ?>
                </div>

                <!-- <div class="box-readmore readmore-arrowdown">
                	<a href="javascript:void(0)" class="btn-readmore load-more"><i><img src="assets/img/skin/icon-play.svg"></i><span>เพิ่มเติม</span></a>
                </div> -->
                <!-- <div class="hidden-content is-hidden">
                    <?php //for($i=0;$i<6;$i++){ ?>
                    <div class="col-md-4 col-sm-6 col-xs-6 col-ss-12 clear-article-row">
                        <a class="thumb thumb-verticle" href="">
                            <div class="thumb-img" style="background-image:url(assets/img/thumb/thumb_demo.png);"><img src="assets/img/thumb/thumb-380X190.png"></div>
                            <div class="thumb-detail">
                                <h3 class="thumb-title">แค่ไหนเรียกว่าอ้วน ?</h3>
                                <p class="thumb-desc">คำว่า “อ้วน” พูดเบาๆก็เจ็บ <br>นอกจากเจ็บจิต ยังอาจป่วยหัวใจ<br>และอีกหลายที่อีกด้วย! ... </p>
                            </div>
                        </a>
                    </div>
                    <?php //} ?>
                </div> -->
            </div>
        </div>
    </div>



    <!-- <div class="homesec-reccommend">
        <div class="section-topic">
            <div class="topic-group">
                <div class="topic-icon"><img src="assets/img/skin/icon_main-recommend.svg"></div>
                <h1>บทความยอดนิยม</h1>
            </div>
        </div>
        <div class="section-post">
            <div class="container">
                <div class="row">
                    <?php for($i=0;$i<4;$i++){?>
                    <div class="col-md-3 col-sm-6 col-xs-6 col-ss-12">
                        <a class="thumb thumb-verticle" href="">
                            <div class="thumb-icon"><img src="assets/img/skin/icon_main-food.svg"></div>
                            <div class="thumb-img" style="background-image:url(assets/img/thumb/thumb_demo.png);"><img src="assets/img/thumb/thumb-300X300.png"></div>
                            <div class="thumb-detail">
                                <h3 class="thumb-title">ส่องเศรษฐกิจโลก เศรษฐกิจไทย IMF ชี้เศรษฐกิจโลกปี 2559 ขยายตัวร้อยละ 3.4 ประเทศพัฒนาแล้ว</h3>
                            </div>
                        </a>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </div> -->



    <?php $this->load->view('frontend/inc/inc-partner.php'); ?>

</div>

<?php $this->load->view('frontend/inc/inc-footer.php'); ?>

<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>swiper.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>scrolltoload.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>main.js"></script>

</body>
</html>
