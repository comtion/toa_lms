<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php $this->output->set_header('X-FRAME-OPTIONS: DENY'); ?>
    <title>Winner Report</title>
	<!-- Bootstrap Styles-->
    <link href="<?php echo base_url() ?>assets/backoffice/css/bootstrap.css" rel="stylesheet" />
     <!-- FontAwesome Styles-->
    <link href="<?php echo base_url() ?>assets/backoffice/css/font-awesome.css" rel="stylesheet" />
     <!-- Custom Styles-->
    <link href="<?php echo base_url() ?>assets/backoffice/css/custom-styles.css" rel="stylesheet" />
     <!-- TABLE STYLES-->
    <link href="<?php echo base_url() ?>assets/backoffice/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <script>
   if ( top != self ) 
   {
      top.location=self.location;
   }
</script>
    
</head>
<body>
    <div id="wrapper">
    	<?php 
			include('inc/topmenu.php'); 
		?>
         <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li>
                        <a class="" href="<?php echo base_url(); ?>backoffice/report" ><i class="fa fa-table"></i> รายงาน </a>
                    </li>
                    <li>
                        <a class="" href="<?php echo base_url(); ?>backoffice/passedrules" ><i class="fa fa-table"></i> ผ่านกติกา </a>
                    </li>
                    <li>
                        <a class="active-menu" href="<?php echo base_url(); ?>backoffice/winner" ><i class="fa fa-table"></i> ผู้ชนะ </a>
                    </li>
                    <li>
                        <a class="" href="<?php echo base_url(); ?>backoffice/week" ><i class="fa fa-table"></i> กำหนดวันประกาศผล </a>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">
			 <div class="row">
                    <div class="col-md-12">
                        <h1 class="page-header">
                            Winner Report 
                        </h1>
                    </div>
                </div> 
                 <!-- /. ROW  -->
               
            <div class="row">
          
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             Advanced Tables
                             <a href="<?php echo base_url() ?>backoffice/export/winners" class="export-excel-new" target="_blank">Export Excel</a>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>FB ID</th>
                                            <th>FB Name</th>
                                            <th>Image</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <?php foreach( $winner_list as $winner ) { ?>
                                        <tr class="gradeX">
                                            <td class="center fb_id">
                                            	<a href="https://www.facebook.com/<?php echo $winner['fb_id']  ?>" target="_blank">
													<?php echo $winner['fb_id']  ?>
                                                </a>
                                            </td>
                                            <td class="center"><?php echo $winner['fb_name']  ?></td>
                                            <td class="center"><img class="img-result" src="<?php echo base_url().'fileup/crop/'.$winner['image']  ?>" /></td>
                                            <td class="center"><?php echo $winner['c_date']  ?></td>
                                             <td class="center">
                                             	<form class="winner">
                                                	<input type="hidden" name="fb_id" value="<?php echo $winner['fb_id']  ?>" />
                                                    <input type="hidden" name="fb_name" value="<?php echo $winner['fb_name']  ?>" />
                                                    <input type="hidden" name="image" value="<?php echo $winner['image']  ?>" />
                                    				<input type="button" value="Cancel" name="cancel-winner" class="cancel-winner" />
                                                </form>
                                             </td>
                                        </tr>
                                     <?php } ?>
                                       
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                </div>
            </div>
            
        </div>
    </div>
             <!-- /. PAGE INNER  -->
            </div>
         <!-- /. PAGE WRAPPER  -->
     <!-- /. WRAPPER  -->
    <!-- JS Scripts-->
    <!-- jQuery Js -->
    <script src="<?php echo base_url() ?>assets/backoffice/js/jquery-1.10.2.js"></script>
      <!-- Bootstrap Js -->
    <script src="<?php echo base_url() ?>assets/backoffice/js/bootstrap.min.js"></script>
   
    <script src="<?php echo base_url() ?>assets/backoffice/js/tableExport/tableExport.js"></script>
    <script src="<?php echo base_url() ?>assets/backoffice/js/tableExport/jquery.base64.js"></script>
         <!-- Custom Js -->
    <script src="<?php echo base_url() ?>assets/backoffice/js/custom-scripts.js"></script>
    <script src="<?php echo base_url() ?>assets/backoffice/js/main.js"></script>
    
   
</body>
</html>
