<script>
	//var url = window.location.href.split('?')[0];
	var url = "http://truemoney.dev/";
</script>
<div class="boxlinkHide" style="position:absolute; top:0px; opacity:0; visibility:hidden;"><a class="sl mission" href="#linkMission">1</a><a class="sl testimonials" href="#testimonials">2</a></div>
<div class="section-header">
	<div class="container-fluid">
    	<div class="logo-ascend"><a href="index.php"><img src="<?php echo HTTP_IMAGES_PATH; ?>skin/logo-ascend-white.svg"></a></div>
        <div class="box-menu">
        	<ul>
        		<li class="listmenu menuOnHover"><a href="javascript:void(0)" class="m-menu m-product btn-menuProductjs" data-menu="menu-product"><span>Products & Services</span></a></li>
        		<li class="listmenu"><a href="about.php" class="m-about"><span>About Us</span></a></li>
        		<li class="listmenu"><a href="news.php" class="m-news"><span>News</span></a></li>
        		<li class="listmenu"><a href="contact.php" class="m-contact"><span>Contact Us</span></a></li>
        	</ul>
        </div>

        <div class="box-tools">
        	<div class="list-tools"><a href="javascript:void(0)" class="m-menu btn-location" data-menu="menu-location"><img src="<?php echo HTTP_IMAGES_PATH; ?>skin/icon-lang.svg"><span>Select Country</span></a></div>
            <!--<div class="list-tools">
            	<span class="btn-lang lang-en active">EN</span>
                <span class="sep">|</span>
                <span class="btn-lang lang-en">TH</span>
            </div>-->
            <div class="list-tools"><a href="javascript:void(0)" onClick="window.open('https://www.facebook.com/sharer/sharer.php?u='+url+'&t=ascend money','newWin','width=559,height=440')" class="btn-share"><img src="<?php echo HTTP_IMAGES_PATH; ?>skin/icon-share.svg"></a></div>
        </div>

        <div class="btn-menu">
        	<img src="<?php echo HTTP_IMAGES_PATH; ?>skin/icon-menu.svg">
            <span>Menu</span>
        </div>

        <div class="box-menuMobile">
        	<div class="logo-ascend"><a href="index.php"><img src="<?php echo HTTP_IMAGES_PATH; ?>skin/logo-ascend-white.svg"></a></div>
            <div class="btn-menu">
                <img src="<?php echo HTTP_IMAGES_PATH; ?>skin/btn-close.png">
                <span>CLOSE</span>
            </div>
            <div class="scrollMenu">

                <div class="menuMobile">
                    <ul>
                        <li class="listmenu"><a href="javascript:void(0)" class="m-product menu-toggle" data-menutoggle="menu_1"><span>Products & Services</span></a></li>
                        <div class="menuProduct menumain menu_1">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-4 col-sm-6 groupList">
                                        <h3 class="menuSub-toggle" data-menusub="sub_1"><span>TrueMoney</span><br>Business to Consumer Services</h3>
                                        <ul class="subDetail sub_1">
                                            <li><a href="product-ewallet.php">e-Wallet</a></li>
                                            <li><a href="product-billpayment.php">Bill Payment</a></li>
                                            <li><a href="product-mobiletopup.php">Mobile Topup</a></li>
                                            <li><a href="product-gametopup.php">Game Topup</a></li>
                                            <li><a href="product-transfer.php">Money Transfer</a></li>
                                            <li><a href="product-debitcard.php">Prepaid Debit Card</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-4 col-sm-6 groupList">
                                        <h3 class="menuSub-toggle" data-menusub="sub_2"><span>TrueMoney</span><br>Business to Business Services</h3>
                                        <ul class="subDetail sub_2">
                                            <li><a href="product-payroll.php">Payroll</a></li>
                                            <li><a href="product-gateway.php">Payment Gateway</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-2 col-sm-6 groupList">
                                        <h3 class="menuSub-toggle" data-menusub="sub_4"><span>TrueMoney</span><br>Channels</h3>
                                        <ul class="subDetail sub_4">
                                            <li><a href="channel.php">PayPoint Channels</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-md-2 col-sm-6 groupList">
                                        <h3 class="menuSub-toggle" data-menusub="sub_3"><span>Ascend nano</span><br>factoring</h3>
                                        <ul class="subDetail sub_3">
                                            <li><a href="factoring.php">Factoring</a></li>
                                        </ul>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <li class="listmenu"><a href="about.php" class="m-about"><span>About Us</span></a></li>
                        <li class="listmenu"><a href="news.php" class="m-news"><span>News</span></a></li>
                        <li class="listmenu"><a href="contact.php" class="m-contact"><span>Contact Us</span></a></li>
                        <li class="listmenu"><a href="javascript:void(0)" class="mobile-location"><span>Locations</span></a></li>
                        <div class="menuProduct menumain menuLocation">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-4 col-sm-6 groupList">
                                        <ul class="subDetail sub_1 locationSUB" style="display:block!important">
                                            <li><a href="http://truemoney.com" target="_blank"><img src="./<?php echo HTTP_IMAGES_PATH; ?>skin/flag-1.svg">Thailand</a></li>
                                            <li><a href="http://www.truemoney.com.kh/" target="_blank";><img src="<?php echo HTTP_IMAGES_PATH; ?>skin/flag-2.svg">Cambodia</a></li>
                                            <li><a href="https://www.truemoney.co.id" target="_blank"><img src="<?php echo HTTP_IMAGES_PATH; ?>skin/flag-3.svg">Indonesia</a></li>
                                            <li><a href="http://www.truemoneymyanmar.com" target="_blank"><img src="<?php echo HTTP_IMAGES_PATH; ?>skin/flag-4.svg">Myanmar</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<li class="listmenu lang-menu">
                            <a href="javescript:void(0)"><span>Language</span></a>
                            <div class="mobileLang">
                                <span class="btn-lang lang-en active">EN</span>
                                <span class="sep">|</span>
                                <span class="btn-lang lang-en">TH</span>
                            </div>
                        </li>-->
                        <li class="listmenu"><a href="javascrip:void(0)" onClick="window.open('https://www.facebook.com/sharer/sharer.php?u='+url+'&t=ascend money','newWin','width=559,height=440')" class="m-contact"><span>Share</span></a></li>
                    </ul>
                </div>
            </div>
        </div>


    </div>
    <div class="menuProduct menu-product mHover" data-submenu="menu-product">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-4 col-sm-6 groupList">
                	<h3><a href="product.php"><span>TrueMoney</span><br>Business to Consumer Services</a></h3>
                    <ul>
                    	<li><a href="product-ewallet.php">e-Wallet</a></li>
                        <li><a href="product-billpayment.php">Bill Payment</a></li>
                        <li><a href="product-mobiletopup.php">Mobile Topup</a></li>
                        <li><a href="product-gametopup.php">Game Topup</a></li>
                        <li><a href="product-transfer.php">Money Transfer</a></li>
                        <li><a href="product-debitcard.php">Prepaid Debit Card</a></li>

                    </ul>
                </div>
                <div class="col-md-4 col-sm-6 groupList">
                	<h3><a href="product.php"><span>TrueMoney</span><br>Business to Business Services</h3></a>
                    <ul>
                    	<li><a href="product-payroll.php">Payroll</a></li>
                        <li><a href="product-gateway.php">Payment Gateway</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-sm-6 groupList">
                	<h3><span>TrueMoney</span><br>Channels</h3>
                    <ul>
                    	<li><a href="channel.php">PayPoint Channels</a></li>
                    </ul>
                </div>
                <div class="col-md-2 col-sm-6 groupList">
                	<h3><span>Ascend nano</span><br>factoring</h3>
                    <ul>
                    	<li><a href="factoring.php">Factoring</a></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>

    <div class="menuProduct menu-location mHover" id="locationJs" data-submenu="menu-location">
    	<div class="container">
        	<div class="row">
            	<div class="col-md-12 groupList" style="margin-bottom:0px;">
                	<h3>select country</h3>
                </div>
            	<div class="col-md-3 col-sm-3 col-xs-12 groupList">
                    <ul>
                        <li><a href="http://truemoney.com" target="_blank"><img src="<?php echo HTTP_IMAGES_PATH; ?>skin/flag-1.svg">Thailand</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 groupList">
                    <ul>
                        <li><a href="http://www.truemoney.com.kh/" target="_blank"><img src="<?php echo HTTP_IMAGES_PATH; ?>skin/flag-2.svg">Cambodia</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 groupList">
                    <ul>
                        <li><a  href="https://www.truemoney.co.id" target="_blank"><img src="<?php echo HTTP_IMAGES_PATH; ?>skin/flag-3.svg">Indonesia</a></li>
                    </ul>
                </div>
                <div class="col-md-3 col-sm-3 col-xs-12 groupList">
                    <ul>
                        <li><a href="http://www.truemoneymyanmar.com" target="_blank"><img src="<?php echo HTTP_IMAGES_PATH; ?>skin/flag-4.svg">Myanmar</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
