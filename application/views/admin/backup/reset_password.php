<!DOCTYPE html>
<html class="bg-black">
<head>
    <meta charset="UTF-8">
    <?php $this->output->set_header('X-FRAME-OPTIONS: DENY'); ?>
    <title>Reset password</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <link href="<?php echo base_url() ?>assets/backoffice/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>assets/backoffice/css/font-awesome.css" rel="stylesheet" type="text/css" />
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
                    <h1><strong>Password</strong> Reset Form</h1>
                    <div class="description">
                        <p>
                            Welcome to reset password system
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <div class="form-top-left">
                            <h3>Reset your password</h3>
                            <p>Enter your password and confirm password to reset:</p>
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-key"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <form role="form" method="post" class="reset-form" id="form-reset">
                            <div class="form-group">
                                <label class="sr-only" for="form-password">Password</label>
                                <input type="text" name="PW" placeholder="New Password" class="form-password form-control" id="form-password" required>
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="form-con-password">Confirm Password</label>
                                <input type="password" name="COPW" placeholder="Confirm Password" class="form-con-password form-control" id="form-con-password" required>
                            </div>
                            <button type="submit" class="btn">Reset</button>
                        </form>
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