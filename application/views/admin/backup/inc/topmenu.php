<script> var base_url = '<?php echo base_url(); ?>';</script>
<div class="section-pop">
	<div class="pop-container">
    	<div class="pop-close"></div>
    	<div class="pop-content">
            <p></p>
        </div>
    </div>
</div>
<nav class="navbar navbar-default top-navbar" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo base_url() ?>backoffice/dashboard">Backoffice</a>
    </div>

    <ul class="nav navbar-top-links navbar-right">
        
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="#"><i class="fa fa-user fa-fw"></i> Welcome <?php echo $this->session->userdata('user_name') ?></a>
                </li>
                <li class="divider"></li>
                <li><a class="logout" href="javascript:void(0)"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                </li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
</nav>
        <!--/. NAV TOP  -->