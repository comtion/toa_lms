<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/inc/inc.meta.php'); ?>

</head>

<body class="index-page">
<div class="loader"></div>
<!-------- Content -->
<?php $this->load->view('frontend/inc/inc.header.php'); ?>

<div class="main-warp">
    <div class="section-banner banner-home">
        <div class="box-banner" style="background-image:url(<?php echo HTTP_IMAGES_PATH; ?>banner/00_home.png)">
        	<div class="banner-mainImg mobileHide"><img src="<?php echo HTTP_IMAGES_PATH; ?>banner/00_home.png"></div>
        	<div class="banner-mainImg mobileShow"><img src="<?php echo HTTP_IMAGES_PATH; ?>banner/00_home_m.png"></div>
            <div class="frame-banner">
            	<div class="img-blank mobileShow"><img src="<?php echo HTTP_IMAGES_PATH; ?>banner/blank.png"></div>
                <a class="btn-viewmoreBanner mobileShow" href="about.php">View More</a>
                <div class="text-bannerHome mobileHide">
                    <img class="logo-banner" src="<?php echo HTTP_IMAGES_PATH; ?>skin/logo-ascend.svg">
                    <!--<div class="mission-text textLoop">
                    	<h1 class="ms-1">our mission</h1>
                        <p class="ms-2">Ascend Money aims to bring a brighter financial future to Southeast Asia</p>
						<p class="ms-3">and provide a low-cost and efficient financial access for the underbanked</p>
						<p class="ms-4">and unbanked population. Our slogan is <span class="redColor">Secure Payment Made Easy.</span></p>
                    </div>-->
                    <div class="about-text textLoop">
                    	<h1 class="ab-1">LEADING FINTECH PROVIDER IN SOUTHEAST ASIA</h1>
                        <!--<h2 class="ab-2">Ascend Money is the FinTech arm of Ascend Group and comprises of</h2>
						<h2 class="ab-3">e-Payment provider WeMoney and financial lender Ascend Nano.</h2>-->
                        <p class="ab-2">With services in 6 ASEAN countries, Ascend Money’s mission is to provide </p>
						<p class="ab-3">a low-cost and efficient financial access for the underbanked </p>
						<p class="ab-4">and unbanked population to create a better everyday living.</p>
                        <a class="btn-viewmoreBanner mobileHide" href="about.php">View More</a>
                    </div>
                </div>

                <div class="text-bannerHome mobileShow">
                    <img class="logo-banner" src="<?php echo HTTP_IMAGES_PATH; ?>skin/logo-ascend.svg">
                    <!--<div class="mission-text textLoop">
                    	<h1 class="ms-1">our mission</h1>
                        <p class="ms-2">Ascend Money aims to bring a brighter financial future to Southeast Asia and provide a low-cost and efficient financial access for the underbanked and unbanked population. Our slogan is <br><span class="redColor">Secure Payment Made Easy.</span></p>
                    </div>-->
                    <div class="about-text textLoop">
                    	<h1 class="ab-1">Leading FinTech Provider in Southeast Asia</h1>
                        <!--<h2 class="ab-2">Ascend Money is the FinTech arm of Ascend Group and comprises of e-Payment provider WeMoney and financial lender Ascend Nano.</h2>-->
                        <p class="ab-2">With services in 6 ASEAN countries, Ascend Money’s mission is to provide a low-cost and efficient financial access for the underbanked and unbanked population to create a better everyday living.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-wrapper">
        <div class="container">
            <div class="container-offset">
                <div class="box-half">
                    <a href="javascript:void(0)"  class="half-list btnToggle" data-toggle="#bodyMenu">
                    	<div class="border-half"></div>
                        <div class="img-half"><div><img src="<?php echo HTTP_IMAGES_PATH; ?>skin/logo-truemoney.png"></div></div>
                        <div class="text-half">
                            <h2 class="extraBold"><span class="redColor">PAYMENT</span> SERVICES</h2>
                            <p>Leading e-Payment Provider in Southeast Asia </p>
                            <div class=" text-viewmore">View more</div>
                        </div>
                    </a>
                    <div class="targetMobile">

                    </div>
                    <a class="half-list" href="factoring.php">
                    	<div class="border-half"></div>
                        <div class="img-half"><div><img src="<?php echo HTTP_IMAGES_PATH; ?>skin/logo-ascendnano.svg"></div></div>
                        <div class="text-half">
                            <h2 class="extraBold"><span class="redColor">LENDING</span> SERVICES</h2>
                            <p>Nano financial lender in Thailand</p>
                            <div class="text-viewmore">View more</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="targetDesktop">
            <div class="bodyMenu targetToggle" id="bodyMenu">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-sm-6 col-xs-12 groupList">
                            <h3><a href="product.php">Business to Consumer Services</a></h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul>
                                        <li><a href="product-ewallet.php">e-Wallet</a></li>
                                        <li><a href="product-billpayment.php">Bill Payment</a></li>
                                        <li><a href="product-mobiletopup.php">Mobile Topup</a></li>
                                        <li><a href="product-gametopup.php">Game Topup</a></li>

                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul>
                                        <li><a href="product-transfer.php">Money Transfer</a></li>
                                        <li><a href="#">Prepaid MasterCard</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 groupList">
                            <h3><a href="product.php">Business to Business Services</a></h3>
                            <ul>
                                <li><a href="product-payroll.php">Palroll</a></li>
                                <li><a href="#">Payment Gateway</a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <div class="container">
        	<div class="gap-30"></div>
            <div class="title-general"><h1><span>HIGHLIGHT </span> SERVICES</h1></div>
            <div class="slideProduct">
            	<a href="product.php" class="btn-slideviewmore">VIEW MORE</a>
                <div class="swiper-container product-slide arrowBlack slideSpace">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide listProduct">
                            <a href="product-ewallet.php" class="">
                                <div class="imgProduct">
                                    <img src="<?php echo HTTP_IMAGES_PATH; ?>product/icon-ewallet.svg">
                                </div>
                                <h3>E-Wallet</h3>
                                <p>Financial Transactions<br>at Your Fingertips</p>
                            </a>
                        </div>
                        <div class="swiper-slide listProduct">
                            <a href="product-billpayment.php" class="">
                                <div class="imgProduct">
                                    <img src="<?php echo HTTP_IMAGES_PATH; ?>product/icon-billpayment.svg">
                                </div>
                                <h3>bill payment</h3>
                                <p>Convenient Scan and Pay</p>
                            </a>
                        </div>
                        <div class="swiper-slide listProduct">
                            <a href="product-mobiletopup.php" class="">
                                <div class="imgProduct">
                                    <img src="<?php echo HTTP_IMAGES_PATH; ?>product/icon-mobiletopup.svg">
                                </div>
                                <h3>mobile topup</h3>
                                <p>Easy Topup Anywhere, Anytime</p>
                            </a>
                        </div>
                        <div class="swiper-slide listProduct">
                            <a href="product-gametopup.php" class="">
                                <div class="imgProduct">
                                    <img src="<?php echo HTTP_IMAGES_PATH; ?>product/icon-gametopup.svg">
                                </div>
                                <h3>game topup</h3>
                                <p>Most Popular<br>Game Topup Brand in Thailand</p>
                            </a>
                        </div>
                        <div class="swiper-slide listProduct">
                            <a href="product-transfer.php" class="">
                                <div class="imgProduct">
                                    <img src="<?php echo HTTP_IMAGES_PATH; ?>product/icon-transfer.svg">
                                </div>
                                <h3>Money Transfer</h3>
                                <p>Transfer money domestically <br>and internationally</p>
                            </a>
                        </div>
                        <div class="swiper-slide listProduct">
                            <a href="product-debitcard.php" class="">
                                <div class="imgProduct">
                                    <img src="<?php echo HTTP_IMAGES_PATH; ?>product/icon-prepaiddebitcard.svg">
                                </div>
                                <h3>Prepaid Debit Card</h3>
                                <p>Make online and offline purchases </p>
                            </a>
                        </div>
                    </div>

                </div>
                <div class="swiper-button-next button-slide"></div>
                <div class="swiper-button-prev button-slide"></div>
                <div class="swiper-pagination"></div>
            </div>

            <div class="gap-30"></div>
            <div class="title-general"><h1><span>IN THE </span> NEWS</h1></div>
            <?php $this->load->view('frontend/inc/inc.news.php'); ?>
        </div>
    </div>
</div>

<?php $this->load->view('frontend/inc/inc.footer.php'); ?>

<!-------- End Content -->
<?php $this->load->view('frontend/inc/inc.script.php'); ?>
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>main.js"></script>

</body>
</html>
