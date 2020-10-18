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

    <div class="section-cate section-video">
    	<div class="section-topic">
            <div class="topic-group">
                <div class="topic-icon"><img src="<?php echo base_url(); ?>assets/img/skin/icon_main-video.svg"></div>
                <h1>วิดีโอ</h1>
            </div>
        </div>
    	<div class="container">
            <div class="box-listVideo row">
                <div class="listload">
                    <?php foreach( $lists as $list ){ ?>
                    <div class="col-md-4 col-sm-4 col-xs-6 col-ss-12 clear-article-row">
                        <a class="thumb thumb-verticle thumb-video" href="javascript:void(0)"  data-id="<?php echo $video['cp_video']; ?>">
                            <div class="thumb-img" style="background-image:url(<?php echo base_url(); ?>uploads/<?php echo $list['cp_titleimg']; ?>);"><img src="<?php echo base_url(); ?>assets/img/thumb/thumb-380X190.png"></div>
                            <div class="thumb-detail"><h3 class="thumb-title"><?php echo $list['cp_titlehead']; ?></h3></div>
                        </a>
                    </div>
                    <?php } ?>
                </div>

                <!-- <div class="box-readmore readmore-arrowdown">
                	<a href="javascript:void(0)" class="btn-readmore load-more"><i><img src="assets/img/skin/icon-play.svg"></i><span>เพิ่มเติม</span></a>
                </div>
                <div class="hidden-content is-hidden">
                    <?php //for($i=0;$i<6;$i++){ ?>
                    <div class="col-md-4 col-sm-4 col-xs-6 col-ss-12 clear-article-row">
                        <a class="thumb thumb-verticle thumb-video" href="javascript:void(0)" onClick="clickVideo('H36gQxICaM8');">
                            <div class="thumb-img" style="background-image:url(assets/img/thumb/thumb_demo.png);"><img src="assets/img/thumb/thumb-380X190.png"></div>
                            <div class="thumb-detail"><h3 class="thumb-title">News Title</h3></div>
                        </a>
                    </div>
                    <?php //} ?>
                </div> -->
            </div>
        </div>
    </div>



</div>

<?php $this->load->view('frontend/inc/inc-footer.php'); ?>

<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>scrolltoload.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>main.js"></script>

</body>
</html>
