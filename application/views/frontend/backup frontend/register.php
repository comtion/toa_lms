<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/inc/inc-meta.php'); ?>

<link type="text/css" rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>bootstrap-datepicker.min.css?v=2" />
<link type="text/css" rel="stylesheet" href="<?php echo HTTP_CSS_PATH; ?>style.css?v=3" />
<script type="text/javascript" src="<?php echo HTTP_JS_PATH; ?>jquery.min.js"></script>
</head>

<body class="page-vdo">

	<?php $this->load->view('frontend/inc/inc-icon.php'); ?>
	<?php $this->load->view('frontend/inc/inc-header.php'); ?>

<div class="wrapper">

  <div class="section-cate">
      <div class="container">
        <div class="section-register">
            <h2 class="register-title">ลงทะเบียนเพื่อรับข่าวสาร</h2>
              <div class="form-register">
                  <form>
                    <div class="row">
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="fill-list">
                                <div class="fill-title">ชื่อ</div>
                                  <label class="fill-input"><input type="text" name="firstname"></label>
                              </div>
                          </div>
                          <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="fill-list">
                                <div class="fill-title">นามสกุล</div>
                                  <label class="fill-input"><input type="text" name="lastname"></label>
                              </div>
                          </div>
                          <div class="col-md-6 col-sm-12 col-xs-12 fill-haft">
                            <div class="fill-list">
                                <div class="fill-title">เพศ</div>
                                  <div class="radio-group radioinline">
                                      <div class="radio-list">
                                          <input id="gender-M" type="radio" name="gender" value="male" class="gender-fill">
                                          <label for="gender-M">ชาย</label>
                                      </div>
                                      <div class="radio-list">
                                          <input id="gender-W" type="radio" name="gender" value="female" class="gender-fill">
                                          <label for="gender-W">หญิง</label>
                                      </div>
                                  </div>
                              </div>
                              <div class="fill-list">
                                <div class="fill-title">อายุ</div>
                                  <label class="fill-input select-group">
                                    <select>
                                      <option>1</option>
                                          <option>2</option>
                                      </select>
                                  </label>
                              </div>
                          </div>
                          <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="fill-list">
                                <div class="fill-title">อีเมลล์</div>
                                  <label class="fill-input"><input type="email" name="email"></label>
                              </div>
                          </div>
                          <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="fill-list">
                                <div class="fill-title">เบอร์โทรศัพท์</div>
                                  <label class="fill-input"><input type="tel" name="phone"></label>
                              </div>
                          </div>
                          <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="fill-list">
                                <div class="fill-title">ที่อยู่</div>
                                  <label class="fill-input"><input type="text" name="address"></label>
                              </div>
                          </div>
                          <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="fill-list">
                                <div class="fill-title">จังหวัด</div>
                                  <label class="fill-input"><input type="text" name="country"></label>
                              </div>
                          </div>
                          <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="fill-list">
                                <div class="fill-title">รหัสไปรษณีย์</div>
                                  <label class="fill-input"><input type="text" name="postcode"></label>
                              </div>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12">
                            <buttons class="stylesubmit" type="submit">ตกลง</button>
                          </div>
                      </div>
                  </form>
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
