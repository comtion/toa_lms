<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/inc/inc-meta.php'); ?>

<link type="text/css" rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>swiper.min.css?v=2" />
<link type="text/css" rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>style.css?v=3" />
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>jquery.min.js"></script>
</head>

<body class="page-home">
<?php //echo phpversion(); ?>
	<?php $this->load->view('frontend/inc/inc-icon.php'); ?>
  <?php $this->load->view('frontend/inc/inc-header.php'); ?>
  <?php $this->load->view('frontend/inc/inc-popupVideo.php'); ?>

<div class="wrapper">

    <div class="section-banner">
    	<div class="swiper-container">
            <div class="swiper-wrapper">
							<?php //print_r( $banners ); ?>
							<?php foreach( $banners as $banner){ ?>
								<div class="swiper-slide" style="background-image:url(<?php echo base_url(); ?>uploads/<?php echo $banner['slide_img']; ?>);">
                	<div class="container">
                    	<div class="banner-content">
                        	<h1><a href="<?php echo base_url().'category/details/'.getCatTitle($banner['cp_category']).'/'.$banner['cpid']; ?>"><?php echo $banner['cp_titlehead']; ?></a></h1>
                            <p><a href="<?php echo base_url().'category/details/'.getCatTitle($banner['cp_category']).'/'.$banner['cpid']; ?>"><?php echo $banner['cp_titletext']; ?></a></p>
                            <a class="banner-taggroup" href="<?php echo base_url().'category/lists/'.getCatTitle($banner['cp_category']); ?>">
															<span class="banner-tag">
																<img src="<?php echo base_url(); ?>assets/img/skin/icon_main-<?php echo getCatTitle($banner['cp_category']); ?>.svg">
																<span>
																	<?php echo getCatText( getCatTitle($banner['cp_category']) ); ?>
																</span>
															</span>
														</a>
                        </div>
                    	<div class="img-blank"><img class="mobileHide" src="<?php echo base_url(); ?>assets/img/thumb/thumb-banner.png"><img class="mobileShow" src="<?php echo base_url(); ?>assets/img/thumb/thumb-banner-m.png"></div>
                    </div>
                </div>
							<?php } ?>

								<div class="swiper-slide" style="background-image:url(<?php echo base_url(); ?>uploads/<?php echo 'banner-4.jpg'; ?>);">
                	<div class="container">
                    	<div class="banner-content">
                        	<h1><a href="http://www.jumpropeforheart.in.th" target="_blank">โครงการกระโดดเชือกทางเลือกเยาวชน พ้นโรคหัวใจ</a></h1>
                        </div>
                    	<div class="img-blank">
												<a href="http://www.jumpropeforheart.in.th" target="_blank">
													<img class="mobileHide" src="<?php echo base_url(); ?>assets/img/thumb/thumb-banner.png">
													<img class="mobileShow" src="<?php echo base_url(); ?>assets/img/thumb/thumb-banner-m.png">
												</a>
											</div>
                    </div>
                </div>
								<div class="swiper-slide" style="background-image:url(<?php echo base_url(); ?>uploads/<?php echo 'banner-5.jpg'; ?>);">
                	<div class="container">
										<div class="banner-content">
												<h1><a href="http://www.thaifoodgoodheart.in.th" target="_blank">โครงการอาหารไทยหัวใจดี</a></h1>
											</div>
										<div class="img-blank">
											<a href="http://www.thaifoodgoodheart.in.th" target="_blank">
												<img class="mobileHide" src="<?php echo base_url(); ?>assets/img/thumb/thumb-banner.png">
												<img class="mobileShow" src="<?php echo base_url(); ?>assets/img/thumb/thumb-banner-m.png">
											</a>
										</div>
                  </div>
                </div>
								<div class="swiper-slide" style="background-image:url(<?php echo base_url(); ?>uploads/<?php echo 'banner-6.jpg'; ?>);">
                	<div class="container">
										<div class="banner-content">
												<h1><a href="http://www.cpr.in.th" target="_blank">โครงการฝึกอบรมช่วยชีวิตขั้นพื้นฐาน (CPR)</a></h1>
											</div>
										<div class="img-blank">
											<a href="http://www.cpr.in.th" target="_blank">
												<img class="mobileHide" src="<?php echo base_url(); ?>assets/img/thumb/thumb-banner.png">
												<img class="mobileShow" src="<?php echo base_url(); ?>assets/img/thumb/thumb-banner-m.png">
											</a>
										</div>
                  </div>
                </div>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

		<div class="homesec-reccommend">
				<div class="section-topic">
						<div class="topic-group">
								<div class="topic-icon"><img src="assets/img/skin/icon_main-recommend.svg"></div>
								<h1>บทความยอดนิยม</h1>
						</div>
				</div>
				<div class="section-post">
						<div class="container">
								<div class="row">
										<?php foreach( $hots as $hot ){?>
										<div class="col-md-3 col-sm-6 col-xs-6 col-ss-12">
												<a class="thumb thumb-verticle" href="<?php echo base_url().'category/details/'.getCatTitle($hot['cp_category']).'/'.$hot['cpid']; ?>">
														<div class="thumb-icon"><img src="assets/img/skin/icon_main-<?php echo getCatTitle($hot['cp_category']); ?>.svg"></div>
														<div class="thumb-img" style="background-image:url(<?php echo base_url(); ?>uploads/<?php echo $hot['cp_titleimg']; ?>);"><img src="assets/img/thumb/thumb-380X190.png"></div>
														<div class="thumb-detail">
																<h3 class="thumb-title"><?php echo $hot['cp_titlehead']; ?></h3>
														</div>
												</a>
										</div>

										<?php }?>

								</div>
						</div>
				</div>
		</div>

    <div class="homesec-food">
        <div class="section-topic">
            <div class="topic-group">
                <div class="topic-icon"><img src="<?php echo base_url(); ?>assets/img/skin/icon_main-food.svg"></div>
                <h1>อาหาร...ดีต่อใจ</h1>
            </div>
        </div>
        <div class="section-post">
            <div class="container">
                <div class="row">
									<?php foreach( $foods as $food ){?>
										<div class="col-md-4 col-sm-4 col-xs-6 col-ss-12">
                        <a class="thumb thumb-verticle" href="<?php echo base_url().'category/details/'.getCatTitle($food['cp_category']).'/'.$food['cpid']; ?>">
                            <div class="thumb-img" style="background-image:url(<?php echo base_url(); ?>uploads/<?php echo $food['cp_titleimg']; ?>);"><img src="<?php echo base_url(); ?>assets/img/thumb/thumb-380X190.png"></div>
                            <div class="thumb-detail">
                                <h3 class="thumb-title"><?php echo $food['cp_titlehead']; ?></h3>
                                <p class="thumb-desc"><?php echo $food['cp_titletext']; ?></p>
                            </div>
                        </a>
                    </div>
									<?php }?>

                    <div class="box-readmore">
                        <a href="<?php echo base_url().'category/lists/food'; ?>" class="btn-readmore"><i><img src="<?php echo base_url(); ?>assets/img/skin/icon-play.svg"></i><span>อ่านทั้งหมด</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="homesec-exercise">
        <div class="section-topic">
            <div class="topic-group">
                <div class="topic-icon"><img src="<?php echo base_url(); ?>assets/img/skin/icon_main-exercise.svg"></div>
                <h1>ออกกำลังกาย...ดีต่อใจ</h1>
            </div>
        </div>
        <div class="section-post">
            <div class="container">
                <div class="row">
									<?php foreach( $exercises as $exercise ){?>
										<div class="col-md-4 col-sm-4 col-xs-6 col-ss-12">
												<a class="thumb thumb-verticle" href="<?php echo base_url().'category/details/'.getCatTitle($exercise['cp_category']).'/'.$exercise['cpid']; ?>">
														<div class="thumb-img" style="background-image:url(<?php echo base_url(); ?>uploads/<?php echo $exercise['cp_titleimg']; ?>);"><img src="<?php echo base_url(); ?>assets/img/thumb/thumb-380X190.png"></div>
														<div class="thumb-detail">
																<h3 class="thumb-title"><?php echo $exercise['cp_titlehead']; ?></h3>
																<p class="thumb-desc"><?php echo $exercise['cp_titletext']; ?></p>
														</div>
												</a>
										</div>
									<?php }?>
                    <div class="box-readmore">
                        <a href="<?php echo base_url().'category/lists/exercise'; ?>" class="btn-readmore"><i><img src="<?php echo base_url(); ?>assets/img/skin/icon-play.svg"></i><span>อ่านทั้งหมด</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="homesec-emotion">
        <div class="section-topic">
            <div class="topic-group">
                <div class="topic-icon"><img src="<?php echo base_url(); ?>assets/img/skin/icon_main-mood.svg"></div>
                <h1>อารมณ์...ดีต่อใจ</h1>
            </div>
        </div>
        <div class="section-post">
            <div class="container">
                <div class="row">
									<?php foreach( $moods as $mood ){?>
										<div class="col-md-4 col-sm-4 col-xs-6 col-ss-12">
												<a class="thumb thumb-verticle" href="<?php echo base_url().'category/details/'.getCatTitle($mood['cp_category']).'/'.$mood['cpid']; ?>">
														<div class="thumb-img" style="background-image:url(<?php echo base_url(); ?>uploads/<?php echo $mood['cp_titleimg']; ?>);"><img src="<?php echo base_url(); ?>assets/img/thumb/thumb-380X190.png"></div>
														<div class="thumb-detail">
																<h3 class="thumb-title"><?php echo $mood['cp_titlehead']; ?></h3>
																<p class="thumb-desc"><?php echo $mood['cp_titletext']; ?></p>
														</div>
												</a>
										</div>
									<?php }?>
                    <div class="box-readmore">
                        <a href="<?php echo base_url().'category/lists/mood'; ?>" class="btn-readmore"><i><img src="<?php echo base_url(); ?>assets/img/skin/icon-play.svg"></i><span>อ่านทั้งหมด</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="group3col">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="section-topic">
                        <div class="topic-group">
                            <div class="topic-icon"><img src="assets/img/skin/icon_main-talk.svg"></div>
                            <h1>คุยกับหมอ</h1>
                        </div>
                    </div>
                    <div class="section-post">

                        <div class="thumb thumb-verticle" href="javascript:void(0);">
                            <div class="thumb-img" style="background-image:url(assets/img/demo/content-doctor-2.jpg);"><img src="assets/img/thumb/thumb-380X190.png"></div>
														<div class="thumb-detail">
                            	<h2 class="talkwithdoc"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-email"></use></svg>ฝากคำถามถึงคุณหมอ</h2>
                              <div class="talkwithdoc thumb-desc" style="margin-top:10px;">COMING SOON</div>
                            </div>

                      	</div>
                      <!--   <div class="box-schedule">
                            <a class="thumb thumb-schedule" href="<?php //echo base_url().'category/lists/comingsoon'; ?>">
                                <div class="thumb-dateNum">20.01.</div>
                                <div class="thumb-detail">
                                    <p class="thumb-desc">คำว่า “อ้วน” พูดเบาๆก็เจ็บ นอกจากเจ็บจิต ยังอาจป่วยหัวใจและอีกหลายที่อีกด้วย!</p>
                                </div>
                            </a>
                            <a class="thumb thumb-schedule" href="<?php //echo base_url().'category/lists/comingsoon'; ?>">
                                <div class="thumb-dateNum">20.01.</div>
                                <div class="thumb-detail">
                                    <p class="thumb-desc">คำว่า “อ้วน” พูดเบาๆก็เจ็บ นอกจากเจ็บจิต ยังอาจป่วยหัวใจและอีกหลายที่อีกด้วย!</p>
                                </div>
                            </a>
                        </div>
                        <div class="box-readmore">
                            <a href="<?php //echo base_url().'category/lists/comingsoon'; ?>" class="btn-readmore"><i><img src="assets/img/skin/icon-play.svg"></i><span>อ่านทั้งหมด</span></a>
                        </div> -->
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="section-topic">
                        <div class="topic-group">
                            <div class="topic-icon"><img src="assets/img/skin/icon_main-news.svg"></div>
                            <h1>ข่าวและกิจกรรม</h1>
                        </div>
                    </div>
                    <div class="section-post">
											<?php if( !empty($events) ){ ?>
                        <a class="thumb thumb-verticle" href="<?php echo base_url().'category/details/'.getCatTitle($events[0]['cp_category']).'/'.$events[0]['cpid']; ?>">
                            <div class="thumb-img" style="background-image:url(<?php echo base_url(); ?>uploads/<?php echo $events[0]['cp_titleimg']; ?>);"><img src="assets/img/thumb/thumb-380X190.png"></div>
                            <div class="thumb-detail text-left">
                                <p class="thumb-desc"><?php echo $events[0]['cp_titlehead']; ?></p>
                            </div>
                        </a>
                        <div class="box-schedule">
                            <a class="thumb thumb-schedule" href="<?php echo base_url().'category/details/'.getCatTitle($events[1]['cp_category']).'/'.$events[1]['cpid']; ?>">
                                <div class="thumb-dateNum"><?php echo changeDateNews( $events[1]['cp_lastupdate'] ); ?></div>
                                <div class="thumb-detail">
                                    <p class="thumb-desc"><?php echo $events[1]['cp_titlehead']; ?></p>
                                </div>
                            </a>
                            <a class="thumb thumb-schedule" href="<?php echo base_url().'category/details/'.getCatTitle($events[2]['cp_category']).'/'.$events[2]['cpid']; ?>">
                                <div class="thumb-dateNum"><?php echo changeDateNews( $events[2]['cp_lastupdate'] ); ?></div>
                                <div class="thumb-detail">
                                    <p class="thumb-desc"><?php echo $events[2]['cp_titlehead']; ?></p>
                                </div>
                            </a>
                        </div>
                        <div class="box-readmore">
                            <a href="<?php echo base_url().'category/lists/news'; ?>" class="btn-readmore"><i><img src="assets/img/skin/icon-play.svg"></i><span>อ่านทั้งหมด</span></a>
                        </div>
											<?php } ?>
                    </div>
                </div>

                <div class="col-md-4 col-sm-4 col-xs-12">
                    <div class="section-topic">
                        <div class="topic-group">
                            <div class="topic-icon"><img src="assets/img/skin/icon_main-event.svg"></div>
                            <h1>Up Coming Event</h1>
                        </div>
                    </div>
                    <div class="section-post">
											<div class="thumb thumb-event" href="javascript:void(0);">
													<div class="thumb-dateNum"><span>11</span><span>MAY</span></div>
													<div class="thumb-detail">
															<p class="thumb-desc">มูลนิธิหัวใจแห่งประเทศไทย ร่วมออกบูธในงาน Money Expo 2017  ณ ชาเลนเจอร์ฮอล <br>อิมแพคเมืองทองธานี</p>
															<span class="thumb-date">วันที่ 11-14 พฤษภาคม 2560</span>
													</div>
											</div>
											<div class="thumb thumb-event" href="javascript:void(0);">
													<div class="thumb-dateNum"><span>31</span><span>MAY</span></div>
													<div class="thumb-detail">
															<p class="thumb-desc">โครงการอาหารไทยหัวใจดี ของมูลนิธิฯ ร่วมออกบูธในงานTHAIFEX 2017 <br>ณ อิมแพคเมืองทองธานี</p>
															<span class="thumb-date">วันที่ 31 พฤษภาคม - 4 มิถุนายน 2560</span>
													</div>
											</div>
											<div class="thumb thumb-event" href="javascript:void(0);">
													<div class="thumb-dateNum"><span>3</span><span>JUN</span></div>
													<div class="thumb-detail">
															<p class="thumb-desc">ประชุมใหญ่สามัญประจำปี2560ของมูลนิธิหัวใจแห่งประเทศไทย</p>
															<span class="thumb-date">วันที่ 3 มิถุนายน 2560</span>
													</div>
											</div>
											<div class="thumb thumb-event" href="javascript:void(0);">
													<div class="thumb-dateNum"><span>25</span><span>SEP</span></div>
													<div class="thumb-detail">
															<p class="thumb-desc">กิจกรรมเดินการกุศล วันหัวใจโลก<br>ณ สวนหลวง ร.๙</p>
															<span class="thumb-date">วันที่ 25 กันยายน 2560</span>
													</div>
											</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="homesec-video">
        <div class="section-topic">
            <div class="topic-group">
                <div class="topic-icon"><img src="<?php echo base_url(); ?>assets/img/skin/icon_main-video.svg"></div>
                <h1>วิดีโอ</h1>
            </div>
        </div>
        <div class="section-post">
            <div class="container">
                <div class="row">
									<?php foreach ( $videos as $video ) { ?>
                    <div class="col-md-4 col-sm-4 col-xs-6 col-ss-12">
                        <a class="thumb thumb-video thumb-verticle" href="javascript:void(0)" data-id="<?php echo $video['cp_video']; ?>" >
                            <div class="thumb-img" style="background-image:url(<?php echo base_url(); ?>uploads/<?php echo $video['cp_titleimg']; ?>);">
															<img src="<?php echo base_url(); ?>assets/img/thumb/thumb-380X190.png">
															<p class="video-title" style="display:none;"><?php echo $video['cp_titlehead']; ?></p>
														</div>
														<div class="thumb-detail">
																<h3 class="thumb-title"><?php echo $video['cp_titlehead']; ?></h3>
														</div>
                        </a>
                    </div>
										<?php } ?>

                    <!--<div class="box-readmore">
                        <a href="<?php //echo base_url().'category/lists/video'; ?>" class="btn-readmore"><i><img src="<?php //echo base_url(); ?>assets/img/skin/icon-play.svg"></i><span>อ่านทั้งหมด</span></a>
                    </div>-->
                </div>
            </div>
        </div>
    </div>

    <?php $this->load->view('frontend/inc/inc-partner.php'); ?>

</div>

<?php $this->load->view('frontend/inc/inc-footer.php'); ?>



<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>swiper.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>main.js"></script>
<script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        spaceBetween: 0
    });
</script>
</body>
</html>
