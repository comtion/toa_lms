<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/inc/inc-meta.php'); ?>

<link type="text/css" rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>swiper.min.css?v=2" />
<link type="text/css" rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>style.css?v=3" />
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>jquery.min.js"></script>
</head>

<body class="page-category page-<?php echo $page; ?>">
<script> var base_url = '<?php echo base_url(); ?>'</script>
	<?php $this->load->view('frontend/inc/inc-icon.php'); ?>
  <?php $this->load->view('frontend/inc/inc-header.php'); ?>
  <?php $this->load->view('frontend/inc/inc-popupVideo.php'); ?>
<div class="mail-popup">
	<div class="mail-body">
		<p class="close-mail-pop">x</p>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<form id="share-mail">
					<label >อีเมลผู้รับ</label>
					<input class="form-control" type="text" name="email_to" />
					<input class="form-control" type="button" name="mail-submit" value="ส่งเมล" />
				</form>
			</div>
		</div>
	</div>
</div>
<div class="wrapper">
	<?php
		if( $page == "food"){
			$headimg = "head-content-food.jpg";
			$title = "อาหาร";
			$icon = "icon_main-food.svg";
		}
		if( $page == "exercise"){
			$headimg = "head-content-exercise.jpg";
			$title = "ออกกำลังกาย";
			$icon = "icon_main-exercise.svg";
		}
		if( $page == "mood"){
			$headimg = "head-content-emotion.jpg";
			$title = "อารมณ์";
			$icon = "icon_main-mood.svg";
		}
		if( $page == "news"){
			$headimg = "head-content-emotion.jpg";
			$title = "ข่าวและกิจกรรม";
			$icon = "icon_main-news.svg";
		}
  ?>

    <div class="container">
        <div class="section-topiccontent">
					<div class="topiccontent-title"><h1><?php echo $details[0]['cp_titlehead']; ?></h1></div>
            <div class="topiccontent-desc"><h2><?php echo $details[0]['cp_titletext']; ?></h2></div>
            <div class="topiccontent-tag">
            	<div class="content-taggroup"><span class="content-tag">
								<img src="<?php echo base_url(); ?>assets/img/skin/<?php echo $icon; ?>">
							<span><?php echo $title; ?></span></span></div>
                <div class="content-date"><?php echo changeDate( $details[0]['cp_lastupdate'], $lang ); ?></div>
            </div>
						<?php
							$url = base_url().'category/details/'.$page.'/'.$details[0]['cpid'];
							$text = checkStrLength( $details[0]['cp_titlehead'], 110);
						?>
            <div class="topiccontent-share">
           		<div class="share-content" href="javascript:void(0)"><span>Share on</span></div>
                <ul>
                	<li><a class="iconshare-fb" href="javascript:void(0)" onclick="window.open( 'https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>' ,'newWin','width=600,height=440');"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-fb"></use></svg></a></i>
                    <li><a class="iconshare-tw" href="javascript:void(0)" onclick="window.open( 'https://twitter.com/intent/tweet?text=<?php echo $text; ?>&url=<?php echo $url; ?>&related=' ,'newWin','width=600,height=440');"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-tw"></use></svg></a></i>
                    <li><a class="iconshare-gp" href="javascript:void(0)" onclick="window.open( 'https://plus.google.com/share?url=<?php echo $url; ?>&related=' ,'newWin','width=600,height=440');"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-gplus"></use></svg></a></i>
                    <li><a class="iconshare-pin" href="javascript:void(0)" onclick="window.open( 'https://www.pinterest.com/pin/create/button/?url=<?php echo $url; ?>&media=<?php echo base_url()."uploads/".$details[0]['cp_titleimg']; ?>&description=<?php echo $details[0]['cp_titlehead']; ?>' ,'newWin','width=600,height=440');"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-pin"></use></svg></a></i>
                    <li><a class="iconshare-mail" data-id="<?php echo $details[0]['cpid']?>" href="javascript:void(0)"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-email"></use></svg></a></i>
                </ul>
            </div>
        </div>
        <div class="box-content">
					<?php echo $details[0]['cp_content']; ?>

        </div>
        <div class="box-readmore readmore-arrowleft">
            <a href="<?php echo base_url().'category/lists/'.$page; ?>" class="btn-readmore"><i><img src="<?php echo base_url(); ?>assets/img/skin/icon-play.svg"></i><span>ย้อนกลับ</span></a>
        </div>
    </div>


  <!--   <div class="section-topic">
    	<div class="topic-group">
        	<div class="topic-icon"><img src="assets/img/skin/icon_main-recommend.svg"></div>
            <h1>บทความยอดนิยม</h1>
        </div>
    </div>
    <div class="section-post">
    	<div class="container">
        	<div class="row">
            	<?php //for($i=0;$i<4;$i++){?>
            	<div class="col-md-3">
                    <a class="thumb thumb-verticle" href="">
                        <div class="thumb-img" style="background-image:url(assets/img/thumb/thumb_demo.png);"><img src="assets/img/thumb/thumb-300X300.png"></div>
                        <div class="thumb-detail">
                            <h3 class="thumb-title">ส่องเศรษฐกิจโลก เศรษฐกิจไทย IMF ชี้เศรษฐกิจโลกปี 2559 ขยายตัวร้อยละ 3.4 ประเทศพัฒนาแล้ว</h3>
                        </div>
                    </a>
        		</div>

                <?php //}?>
        	</div>
        </div>
    </div> -->



    <?php $this->load->view('frontend/inc/inc-partner.php'); ?>

</div>

<?php $this->load->view('frontend/inc/inc-footer.php'); ?>



<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>swiper.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>main.js"></script>
<!-- <script>
    var swiper = new Swiper('.swiper-container', {
        pagination: '.swiper-pagination',
        paginationClickable: true,
        spaceBetween: 0
    });
</script> -->
</body>
</html>
