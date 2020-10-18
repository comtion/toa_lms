<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php $this->output->set_header('X-FRAME-OPTIONS: DENY'); ?>
    <title>Week management</title>
	<!-- Bootstrap Styles-->
    <link href="<?php echo base_url() ?>assets/backoffice/css/bootstrap.css" rel="stylesheet" />
     <!-- FontAwesome Styles-->
    <link href="<?php echo base_url() ?>assets/backoffice/css/font-awesome.css" rel="stylesheet" />
     <!-- Custom Styles-->
    <link href="<?php echo base_url() ?>assets/backoffice/css/custom-styles.css" rel="stylesheet" />
     <!-- TABLE STYLES-->
    <link href="<?php echo base_url() ?>assets/backoffice/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
    <!-- Datepicker STYLES-->
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/backoffice/css/jquery-ui.css" />
  <script>
   if ( top != self ) 
   {
      top.location=self.location;
   }
</script>
</head>
<body class="week">
<div class="section-pop update-week">
    <div class="pop-container">
        <div class="pop-close"></div>
        <div class="pop-content">
          <form class="update-form">
          	<input type="hidden" name="id" class="id"/>
            <label>Week : </label><input type="text" name="week" class="week" />
            <label>From : </label><input type="text" name="date_from" class="date_from" id="update-date-from" />
            <label>To : </label><input type="text" name="date_to" class="date_to" id="update-date-to" />
           	<input type="button" value="EDIT" name="update-week" class="update-week" />
          </form>
        </div>
    </div>
</div>
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
                        <a class="" href="<?php echo base_url(); ?>backoffice/winner" ><i class="fa fa-table"></i> ผู้ชนะ </a>
                    </li>
                    <li>
                        <a class="active-menu" href="<?php echo base_url(); ?>backoffice/week" ><i class="fa fa-table"></i> กำหนดวันประกาศผล </a>
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
                            Week management
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
                             <a href="javascript:void(0);" class="export-excel">Export Excel</a>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Week</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Date Add</th>
                                            <th>Add By</th>
                                            <th>Action</th>
                                        </tr>
                                        <tr class="gradeX">
                                        <form id="add-form">
                                            <td class="center"><input type="text" name="week" class="week" value="" /></td>
                                            <td class="center"><input type="text" name="date_from" class="date_from" id="date-from-add" value="" /></td>
                                            <td class="center"><input type="text" name="date_to" class="date_to" id="date-to-add" value="" /></td>
                                            <td class="center"></td>
                                            <td class="center"></td>
                                            <td class="center">
                                                <input type="button" value="ADD" name="add-week" class="add-week" />
                                             </td>
                                          </form>
                                        </tr>
                                    </thead>
                                    <tbody>
                                     <?php foreach( $week_list as $week ) { ?>
                                        <tr class="gradeX">
                                        <form class="edit-form">
                                        	<input type="hidden" name="id" class="id" value="<?php echo $week['id']  ?>" />
                                        	<input type="hidden" name="week" class="week" value="<?php echo $week['week']  ?>" />
                                            <input type="hidden" name="date_from" class="date_from" value="<?php echo $week['date_from']  ?>"  />
                                            <input type="hidden" name="date_to" class="date_to" value="<?php echo $week['date_to']  ?>" />
                                            <td class="center"><?php echo $week['week']  ?></td>
                                            <td class="center"><?php echo $week['date_from']  ?></td>
                                            <td class="center"><?php echo $week['date_to']  ?></td>
                                            <td class="center"><?php echo $week['c_date']  ?></td>
                                            <td class="center"><?php echo $week['c_by']  ?></td>
                                             <td class="center">
                                             	<input type="button" value="EDIT" name="edit-week" class="edit-week" />
                                                <input type="button" value="DELETE" name="delete-week" class="delete-week" /> 
                                             </td>
                                          </form>
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
    <script type="text/javascript" src="<?php echo base_url() ?>assets/backoffice/js/jquery-ui.js"></script>
    <script src="<?php echo base_url() ?>assets/backoffice/js/custom-scripts.js"></script>
    <script src="<?php echo base_url() ?>assets/backoffice/js/main.js"></script>
    
   
</body>
</html>
