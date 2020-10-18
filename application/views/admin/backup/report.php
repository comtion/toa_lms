<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
      <?php $this->output->set_header('X-FRAME-OPTIONS: DENY'); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>General Report</title>
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
                        <a class="active-menu" href="<?php echo base_url(); ?>backoffice/report" ><i class="fa fa-table"></i> รายงาน </a>
                    </li>
                    <li>
                        <a class="" href="<?php echo base_url(); ?>backoffice/passedrules" ><i class="fa fa-table"></i> ผ่านกติกา </a>
                    </li>
                    <li>
                        <a class="" href="<?php echo base_url(); ?>backoffice/winner" ><i class="fa fa-table"></i> ผู้ชนะ </a>
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
                            General Report <small> stat view </small>
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
                             <a href="<?php echo base_url() ?>backoffice/export/general" class="export-excel-new" target="_blank">Export Excel</a>
                        </div>
                        <div class="panel-body">
                        <p><b>Total player : </b> <?php echo $total_player[0]['total_player']; ?></p>
                        <p><b>Total Played : </b> <?php echo $total_play[0]['total_play']; ?></p>
                        <p><b>Total Shared : </b> <?php echo $total_share[0]['total_share']; ?></p>
                        <p><b>Total Images : </b> <?php echo $total_image[0]['total_image']; ?></p>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>FB ID</th>
                                            <th>FB Name</th>
                                            <th>FB Email</th>
                                            <th>Time to play</th>
                                            <th>Image</th>
                                            <th>Time to image</th>
                                            <th>Check Pass</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach( $list_report as $report ) { 
										if( !empty( $pass_list ) ){
											$class = "";
											$check = "";
											$value = "Submit";
											$check_hide = "";
											$bt_disable = "disabled";
											foreach( $pass_list as $pass ) { 
											
												if( $report['image'] == $pass['image'] ){
													$class = "rec_blue";
													$check = "checked";
													$value = "Cancel";
													$check_hide = "hide";
													$bt_disable = "";
												}
											}
										}else{
											
											$class = "";
											$check = "";
											$value = "Submit";
											$check_hide = "";
											$bt_disable = "disabled";
										}
									?>
                                        <tr class="gradeX <?php echo $class  ?>">
                                            <td class="center fb_id">
                                            	<a href="https://www.facebook.com/<?php echo $report['fb_id']  ?>" target="_blank">
													<?php echo $report['fb_id']  ?>
                                                </a>
                                            </td>
                                            <td class="center"><?php echo $report['fb_name']  ?></td>
                                            <td class="center"><?php echo $report['fb_email']  ?></td>
                                            <td class="center"><?php echo $report['c_date']  ?></td>
                                            <td class="center"><img class="img-result" src="<?php echo base_url().'fileup/crop/'.$report['image']  ?>" /></td>
                                            <td class="center"><?php echo $report['img_date']  ?></td>
                                             <td class="center">
                                             	<form class="up-pass">
                                                	<input type="hidden" name="fb_id" value="<?php echo $report['fb_id']  ?>" />
                                                    <input type="hidden" name="fb_name" value="<?php echo $report['fb_name']  ?>" />
                                                    <input type="hidden" name="image" value="<?php echo $report['image']  ?>" />
                                                    <input type="checkbox" class="<?php echo $check_hide  ?>" name="check-pass" value="1" <?php echo $check  ?>/>
                                    <input type="button" value="<?php echo $value  ?>" name="submit-pass" class="submit-pass" <?php echo $bt_disable  ?>/>
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
