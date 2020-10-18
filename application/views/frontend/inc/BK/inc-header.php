<div class="loadoverlay"></div>
<div class="section-head">
	<div class="section-menusub">
    	<div class="container">
        	<div class="menusub-box">
            	<ul>
                	<li><a href="<?php echo base_url(); ?>history">ประวัติ</a></li>
                    <li><a href="<?php echo base_url().'category/lists/comingsoon'; ?>">บริจาค</a></li>
                    <li><a href="<?php echo base_url().'project'; ?>">โครงการต่างๆ</a></li>
                    <li><a href="<?php echo base_url().'link'; ?>">Link</a></li>
                    <li><a href="<?php echo base_url(); ?>contact">ติดต่อ</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="section-headmain">
        <div class="container">
            <div class="logo-box">
                <div class="logo-group">
                    <div class="logo-img"><img src="<?php echo base_url(); ?>assets/img/skin/logo.png"></div>
                    <div class="logo-text"><h1>มูลนิธิหัวใจแห่งประเทศไทย<br>ในพระบรมราชูปถัมภ์</h1><h2>หลัก 3 อ ดีต่อใจ</h2></div>
                </div>
            </div>
            <div class="section-menu">
                <div class="menu-box">
                    <ul>
                        <li><a href="<?php echo base_url(); ?>home" class="menu-a menu-home"><i><img src="<?php echo base_url(); ?>assets/img/skin/icon_main-home.svg"></i><span>หน้าหลัก</span></a></li>
                        <li><a href="<?php echo base_url(); ?>category/lists/food" class="menu-a menu-food"><i><img src="<?php echo base_url(); ?>assets/img/skin/icon_main-food.svg"></i><span>อาหาร</span></a></li>
                        <li><a href="<?php echo base_url(); ?>category/lists/exercise" class="menu-a menu-exercise"><i><img src="<?php echo base_url(); ?>assets/img/skin/icon_main-exercise.svg"></i><span>ออกกำลังกาย</span></a></li>
                        <li><a href="<?php echo base_url(); ?>category/lists/mood" class="menu-a menu-emotion"><i><img src="<?php echo base_url(); ?>assets/img/skin/icon_main-mood.svg"></i><span>อารมณ์</span></a></li>
                        <li><a href="<?php echo base_url().'category/lists/comingsoon'; ?>" class="menu-a menu-talk"><i><img src="<?php echo base_url(); ?>assets/img/skin/icon_main-talk.svg"></i><span>คุยกับหมอ</span></a></li>
                        <li><a href="<?php echo base_url().'category/lists/news'; ?>" class="menu-a menu-news"><i><img src="<?php echo base_url(); ?>assets/img/skin/icon_main-news.svg"></i><span>ข่าวและกิจกรรม</span></a></li>
                    </ul>
                </div>
                <div class="menusub-box">
                    <ul>
                        <li><a href="<?php echo base_url(); ?>history">ประวัติ</a></li>
                        <li><a href="<?php echo base_url().'category/lists/comingsoon'; ?>">บริจาค</a></li>
                    	<li><a href="<?php echo base_url().'project'; ?>">โครงการต่างๆ</a></li>
                        <li><a href="<?php echo base_url(); ?>contact">ติดต่อ</a></li>
                        <!--<li><div class="rm-social"><a href="https://www.facebook.com/heartfounda/" target="_blank" class="menu-a menu-home"><span>Follow us on</span><i><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-fb"></use></svg></i></a></div></li>-->
                        <li>
                        <div class="rm-social">
                        	<div class="rm-social-in">
                                <div href="javascript:void(0);" target="_blank" class="menu-a menu-home follow">
                                    <span>Follow us on</span>
                                </div>
                                <a href="https://www.facebook.com/heartfounda/" target="_blank" class="menu-a menu-home facebook">
                                    <i>
                                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-fb"></use></svg>
                                    </i>
                                </a>
                                <a href="https://www.youtube.com/channel/UCC8temQEPNo5ju7cIMQpPKQ" target="_blank" class="menu-a menu-home youtube">
                                    <i>
                                        <svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-youtube"></use></svg>
                                    </i>
                                </a>
                            </div>
                        </div>
                        </li>
                        <li><a href="<?php echo base_url().'link'; ?>">Link</a></li>
                    </ul>
                </div>
            </div>
            <div class="section-rightmenu">
                <div class="rightmenu-box">
                    <div class="rm-search">
                        <form method="get" action="<?php echo base_url().'category/results/'; ?>">
                            <input type="text" name="search" placeholder="ค้นหา">
                            <button type="submit"><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-search"></use></svg></button>
                        </form>
                    </div>
                    <div class="rm-social">
											<div href="javascript:void(0);" target="_blank" class="menu-a menu-home follow">
												<span>Follow us on</span>
											</div>
											<a href="https://www.facebook.com/heartfounda/" target="_blank" class="menu-a menu-home facebook">
												<i>
													<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-fb"></use></svg>
												</i>
											</a>
											<a href="https://www.youtube.com/channel/UCC8temQEPNo5ju7cIMQpPKQ" target="_blank" class="menu-a menu-home youtube">
												<i>
													<svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-youtube"></use></svg>
												</i>
											</a>
										</div>
                    <!--<ul>
                        <li><a href="index.php" class="menu-a menu-home"><span>Follow us on</span><i><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-fb"></use></svg></i></a></li>
                        <li><a href="category.php" class="menu-a menu-talk"><span>Search</span><i><svg><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#icon-search"></use></svg></i></a></li>
                    </ul>-->
                </div>
            </div>
             <div class="box-register">
                <a href="<?php echo base_url().'register'; ?>">
                    <div class="reg-group">
                        <div class="reg-icon"><img src="<?php echo base_url(); ?>assets/img/skin/icon_main-register.svg"></div>
                        <div class="reg-text"><span class="reg-text1">ลงทะเบียน</span><span class="reg-text2">รับข่าวสารฟรี <span>คลิกที่นี่</span></span></div>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="btn-menu">
        <div class="groupMenu">
            <span class="pan1"></span>
            <span class="pan2"></span>
            <span class="pan3"></span>
        </div>
    </div>
    <div class="box-iconlink">
    	<a class="btn-searchBar" href="javascript:void(0)"><img src="<?php echo base_url(); ?>assets/img/skin/icon-search.svg"></a>
     <a class="btn-register" href="<?php echo base_url().'register'; ?>"><img src="<?php echo base_url(); ?>assets/img/skin/icon-register.svg"></a>
    </div>
</div>
