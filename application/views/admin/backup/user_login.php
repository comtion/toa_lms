<!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="UTF-8">
    <?php $this->output->set_header('X-FRAME-OPTIONS: DENY'); ?>
    <title>New Backoffice | Log in</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url() ?>assets/backoffice/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url() ?>assets/backoffice/css/login.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>assets/backoffice/css/form-elements.css" rel="stylesheet" type="text/css" />
    <script>
   if ( top != self ) 
   {
      top.location=self.location;
   }
</script>
</head>
<body class="bg-black">
<script> var base_url = '<?php echo base_url(); ?>';</script>
<div class="section-pop">
    <div class="pop-container">
        <div class="pop-close"></div>
        <div class="pop-content">
            <p></p>
        </div>
    </div>
</div>
    <div class="inner-bg">
        <div class="top-content">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1><strong>Backoffice</strong> Login Form</h1>
                    <div class="description">
                        <p>
                            Welcome to  Backoffice System
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3>Login to our site</h3>
                            <p>Enter your username and password to log on:</p>
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-key"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <form role="form" method="post" class="login-form" id="form-login">
                            <div class="form-group">
                                <label class="sr-only" for="form-username">Username</label>
                                <input type="text" name="USR" placeholder="Username..." class="form-username form-control" id="form-username" required>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-password">Password</label>
                                <input type="password" name="PSW" placeholder="Password..." class="form-password form-control" id="form-password" required>
                            </div>
                            <button type="submit" class="btn">Sign in!</button>
                        </form>
                        <p><a href="javascript:void(0)" class="reset-password">Reset Password</a></p>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    
</div>
<script type="text/javascript" src="<?php echo base_url();?>assets/backoffice/js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/backoffice/js/bootstrap.min.js" ></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/backoffice/js/main.js" ></script>
        
</body>
</html>