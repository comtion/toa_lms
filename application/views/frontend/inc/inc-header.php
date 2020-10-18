<?php 
	if($lang==""){
		$lang = "thai";
	}
?>
<style>
	.elearning-logo{
		left:0; 
		right: 0;
		max-width: 250px;
	}

	@media only screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape) {
	  .elearning-logo{
		max-width: 100px;
	}
	}
</style>
<header class="topbar">
	<nav class="navbar top-navbar navbar-expand-md navbar-light">
		<div class="navbar-header">
	        <a class="navbar-brand" href="<?php echo REAL_PATH; ?>/dashboard">
	            	<img <?php  if(isMobile()){ ?>width="100%" <?php }else{ ?>height="50"<?php } ?> src="<?php echo is_file($foote[0]['da_logo_top'])?$foote[0]['da_logo_top']:REAL_PATH.'/images/logo-light-text.png';?>" class="dark-logo light-logo" />
	        	<!-- <?php if (!empty($emp_c)){ ?>
	            	<img <?php  if(isMobile()){ ?>width="100%" <?php }else{ ?>height="50"<?php } ?> src="<?php echo REAL_PATH;?>/images/logo-light-text.png" class="dark-logo light-logo" />
	            	<img <?php  if(isMobile()){ ?>width="100%" <?php }else{ ?>height="50"<?php } ?> src="<?php echo $foote[0]['da_logo_top']; ?>" class="dark-logo" />
	        	<?php }else{ ?>
	            	<img <?php  if(isMobile()){ ?>width="100%" <?php }else{ ?>height="50"<?php } ?> src="<?php echo REAL_PATH;?>/images/logo.png" class="dark-logo" />
	        	<?php } ?>   -->
	        </a>
	    </div>
	    <div class="navbar-collapse">
	    	<?php if(is_file(ROOT_DIR."images/elearning_logo.png")){ ?><img class="position-absolute m-auto hidden-md-down elearning-logo" <?php  if(isMobile()){ ?>width="100%" <?php }else{ ?>height="50"<?php } ?> src="<?php echo REAL_PATH;?>/images/elearning_logo.png" alt=""> <?php } ?>
	    	
			 <?php if (!empty($emp_c)){ ?>
	        <ul class="navbar-nav mr-auto">
	            <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
	            <li class="nav-item hidden-sm-down"></li>
	        </ul>
	    	<?php }else{ ?>
	        <ul class="navbar-nav mr-auto">
	            <li class="nav-item"> </li>
	            <li class="nav-item hidden-sm-down"></li>
	        </ul>
	    	<?php } ?>
	        <ul class="navbar-nav my-lg-0">
	    	<!-- <?php if(strpos($page, 'home') !== false ){ ?>
                <li class="nav-item hidden-xs-down search-box"> <a class="nav-link hidden-sm-down waves-effect waves-dark"  data-toggle="modal" data-target="#modal-searchform" href="javascript:void(0)"><i class="ti-search"></i></a></li>
            <?php } ?> -->
	        	<li class="nav-item dropdown">
	                <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 
	                <?php if($lang=="thai"){ ?>
	                	<style>
	                		* { font-family: Tahoma, sans-serif; }
	                	</style>
	                	<i class="flag-icon flag-icon-th"></i>
	                <?php }else{ ?>
	                	<style>
	                		* { font-family: Roboto, sans-serif; }
	                	</style>
	                	<i class="flag-icon flag-icon-us"></i>
	                <?php }?>
	                </a>
	                <div class="dropdown-menu dropdown-menu-right animated bounceInDown"> 
	                	<a class="dropdown-item <?php if($lang=="thai"){echo "active";} ?>" href="<?php echo REAL_PATH;?>/home/change_lang/thai"><i class="flag-icon flag-icon-th"></i> <?php echo label('thailand'); ?></a> 
	                	<a class="dropdown-item <?php if($lang=="english"){echo "active";} ?>" href="<?php echo REAL_PATH;?>/home/change_lang/english"><i class="flag-icon flag-icon-us"></i> <?php echo label('english'); ?></a>
	                </div>
	            </li>
	            
	            <li class="nav-item dropdown">
			  		<?php if (!empty($emp_c)){ ?>
		                <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		                	<img src="<?php echo REAL_PATH;?>/uploads/profile/<?php echo $foote[0]['fetch_usp']['img_profile']; ?>" onerror="this.src='<?php echo REAL_PATH;?>/uploads/profile/default_profile.jpg'" alt="user" class="profile-pic" />
		                </a>
		            <?php } ?> 
	                    <div class="dropdown-menu dropdown-menu-right animated flipInY">
	                        <ul class="dropdown-user">
	                        	<?php if (empty($emp_c)){ ?>
					  				<li> <a href="<?php echo REAL_PATH;?>/dashboard/login"><i class="fas fa-key"></i> <?php echo label('login'); ?></a></li>
					  			<?php }else{ ?>
	                            	<li>
	                                	<div class="dw-user-box">
	                                		<?php 
												  $ar_userlist = $this->session->userdata('user') ;
												  if($lang=="thai"){
												  	$lname = $foote[0]['fetch_usp']['fname_th'];
												  	$ugname = $foote[0]['fetch_uspgp']['ug_name_th'];
												  }else{
												  	$lname = $foote[0]['fetch_usp']['fname_en']." ".substr($foote[0]['fetch_usp']['lname_en'],0,1).".";
												  	$ugname = $foote[0]['fetch_uspgp']['ug_name_en'];
												  }
											if(isset($foote[0]['fetch_usp']['img_profile'])&&$foote[0]['fetch_usp']['img_profile']!=""){
											?>
	                                    	<div class="u-img"><img src="<?php echo REAL_PATH;?>/uploads/profile/<?php echo $foote[0]['fetch_usp']['img_profile']; ?>" onerror="this.src='<?php echo REAL_PATH;?>/uploads/profile/default_profile.jpg'" alt="user"></div>
	                                    	<?php }else{ ?>
	                                    	<div class="u-img"><img src="<?php echo REAL_PATH;?>/uploads/profile/default_profile.jpg" alt="user"></div>
	                                    	<?php } ?>
	                                    	<div class="u-text">
	                                        	<h4><?php echo $lname; ?></h4>
                                                <p class="text-muted"><?php echo $ugname; ?></p>
                                                <p class="text-muted"><?php echo $foote[0]['fetch_usp']['email']; ?></p>
	                                        </div>
	                                    </div>
	                                </li>

                                    <li role="separator" class="divider"></li>
                                    <li><a href="<?php echo REAL_PATH;?>/dashboard/profile"><i class="ti-user"></i> <?php echo label('view_profile'); ?></a></li>
			                        <li><a href="<?php echo REAL_PATH;?>/dashboard/change_pass"><i class="fas fa-key"></i> <?php echo label('change_pass'); ?></a></li>
	                                <li><a href="<?php echo REAL_PATH;?>/dashboard/logout"><i class="fa fa-power-off"></i> <?php echo label('logout'); ?></a></li>
	                                <!-- 
									<?php if (isset($emp_c)&&($page=='home'||$page=='home/about'||$page=='home/faq'||$page=='home/privacy_policy'||$page=='home/contact_us')): ?>
										<li><a href="<?php echo REAL_PATH;?>/dashboard"><?php echo label('dashboard'); ?></a></li>
									<?php endif ?> -->
					  			<?php } ?>
	                        </ul>
	                    </div>
	            </li>
	        </ul>
	    </div>
	</nav>
	<!--Slider-->
</header>
	
    <div class="modal fade bs-example-modal-lg" tabindex="-1" id="modal-searchform" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form  enctype="multipart/form-data" autocomplete="off" id="searchform_form" name="searchform_form" method="POST"  class="form-horizontal p-t-20">
                    <div class="modal-body">
                        	<input type="text" id="search_text" name="search_text" class="form-control search_text" onInput="edValueKeyPress()">
                        	<hr>
                        	<div id="div_search" name="div_search"></div>
                    </div>
                    <input type="hidden" id="search_value" name="search_value">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-flat" data-dismiss="modal"><?php echo label('close'); ?></button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <script type="text/javascript">
    		function edValueKeyPress() {
			    var edValue = document.getElementById("search_text");
			    var txtval = edValue.value;

	            $.ajax({
		            url:"<?=base_url()?>index.php/course/search_course",
		            method:"POST",
		            data:{txtval_search:txtval},
		            success:function(data)
		            {
		            	if(txtval==""){
		            		data = '<h4 align="center"><?php echo label('wg_datanotfound'); ?></h4>';
		            	}
		            	$('#div_search').html(data);
		            }
	          	});
			}

		      function onclickdetail_search(cos_id){
		      	<?php if (empty($emp_c)){ ?>
		      			$('#modal-detailcourse').modal('show');
		      			
			            $.ajax({
			              url:"<?=base_url()?>index.php/course/update_course_data",
			              method:"POST",
			              data:{id_update:cos_id},
			              dataType:"json",
			              success:function(data)
			              {
			                <?php if($lang=="thai"){ ?>
			                  $('#txt_coursehead').text(data.cname_th);
			                  $('#description_course').html(data.cdesc_th);
			                <?php }else{ ?>
			                  $('#txt_coursehead').text(data.cname_en);
			                  $('#description_course').html(data.cdesc_en);
			                <?php } ?>
			                document.getElementById("img_coursehead").src = "<?php echo REAL_PATH;?>/uploads/course/"+data.pic;

			              }
			            });
		      	<?php }else{ ?>
			        window.location.href = '<?=base_url()?>index.php/course/detail/'+cos_id+'/1';
			    <?php } ?>
		      }
    </script>

