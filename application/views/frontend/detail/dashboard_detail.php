    
                  <div class="col-lg-4 ">
                      <div class="card" style="max-height:350px;">
                        <div class="card-body little-profile text-center h-100">
                          <div class="pro-img m-t-5">
                                  <?php if(isset($profile['img_profile'])&&$profile['img_profile']!=""){ ?>
                                    <img src="<?php echo REAL_PATH;?>/uploads/profile/<?php echo $profile['img_profile']; ?>" onerror="this.src='<?php echo REAL_PATH;?>/uploads/profile/default_profile.jpg'"/>
                                  <?php }else{ ?>
                                    <img src="<?php echo REAL_PATH;?>/uploads/profile/default_profile.jpg"/>
                                  <?php } ?></div>
                          <h3 class="m-b-0" style="font-family: 'Prompt', sans-serif;">
                            
                                      <?php 
                                        if($lang=="thai"){
                                          echo $profile['fullname_th'];
                                        }else{
                                          echo $profile['fullname_en'];
                                        }
                                      ?>
                          </h3>
                          <h6 class="text-muted" style="font-family: 'Prompt', sans-serif;">
                            <?php 
                                                  if($lang=="thai"){
                                                    $ugname = $profile['ug_name_th'];
                                                  }else{
                                                    $ugname = $profile['ug_name_en'];
                                                  } 
                                                  echo $ugname; ?>
                          </h6>
                        </div>

                        <?php if($user['Is_admin']=="0"){ ?>
                          <?php if($user['Is_instructor']=="1"){ ?>
                                <!-- INSTRUCTOR BUTTON -->
                                <div class="switch text-center">
                                    <label>
                                      <?php echo label('dash_show_learner_dashboard'); ?>
                                      <input type="checkbox" id="dashboard_instructor" checked><span class="lever switch-col-grey"></span>
                                      <?php echo label('dash_show_instructor_dashboard'); ?>
                                    </label>
                                </div>
                                <div class="card-body text-center button-group" id="show_learner_dashboard_ins">
                                  <div class="row">
                                    <div class="col-6" style="padding-right: 2.5px;">
                                      <!-- profile setting Button -->
                                      <a href="<?php echo REAL_PATH;?>/dashboard/profile/setting" class="btn btn-block waves-effect waves-light btn-secondary" title="<?php echo label('dash_btn_edit_profile'); ?>">
                                        <i class="mdi mdi-account-edit"></i> <?php echo label('dash_btn_edit_profile'); ?>
                                      </a>
                                    </div>
                                    <div class="col-6" style="padding-left: 2.5px;">                            
                                      <!-- manage user Button -->
                                      <?php if(in_array('managecourse/courses_all', $arr_permission)){ ?>
                                      <a href="<?php echo REAL_PATH;?>/managecourse/courses_all" class="btn btn-block waves-effect waves-light btn-secondary" title="<?php echo label('dash_btn_courses'); ?>">
                                        <i class="mdi mdi-lead-pencil"></i> <?php echo label('dash_btn_courses'); ?>
                                      </a>
                                    <?php } ?>
                                    </div>                            
                                  </div>
                                </div>

                                <div class="card-body text-center button-group" id="show_instructor_dashboard_ins">
                                  <div class="row">
                                    <div class="col-6" style="padding-right: 2.5px;">
                                      <!-- edit profile Button -->
                                      <a href="<?php echo REAL_PATH;?>/dashboard/profile/setting" class="btn btn-block waves-effect waves-light btn-secondary" title="<?php echo label('dash_btn_edit_profile'); ?>"><i class="mdi mdi-account-edit"></i> <?php echo label('dash_btn_edit_profile'); ?>
                                      </a>
                                    </div>
                                  
                                    <div class="col-6" style="padding-left: 2.5px;">   
                                      <a href="<?php echo REAL_PATH;?>/dashboard/profile/certificate" class="btn btn-block waves-effect waves-light btn-secondary" title="<?php echo label('dash_btn_certificate'); ?>"><i class="mdi mdi-certificate"></i> <?php echo label('dash_btn_certificate'); ?></a>
                                    </div>                            
                                  </div>
                                </div>
                          <?php }else{ ?>
                                <!-- USER BUTTON -->
                                <div class="card-body text-center button-group">
                                  <div class="row">
                                    <div class="col-6" style="padding-left: 2.5px;">
                                      <a href="<?php echo REAL_PATH;?>/dashboard/profile/setting" class="btn btn-block waves-effect waves-light btn-secondary">
                                        <i class="mdi mdi-account-edit"></i> <?php echo label('dash_btn_edit_profile'); ?>
                                      </a>
                                    </div>
                                    <div class="col-6" style="padding-right: 2.5px;">
                                      <a href="<?php echo REAL_PATH;?>/dashboard/profile/certificate" class="btn btn-block waves-effect waves-light btn-secondary">
                                        <i class="mdi mdi-certificate"></i> <?php echo label('dash_btn_certificate'); ?>
                                      </a>
                                    </div>
                                  </div>
                                </div>
                          <?php } ?>
                        <?php }else{ ?>
                        <!-- ADMIN BUTTON -->
                        <div class="switch text-center">
                            <label>
                              <?php echo label('dash_show_learner_dashboard'); ?>
                              <input type="checkbox" id="dashboard" checked><span class="lever switch-col-grey"></span>
                              <?php echo label('dash_show_admin_dashboard'); ?>
                            </label>
                        </div>
                        <div class="card-body text-center button-group" id="show_learner_dashboard">
                          <div class="row">
                            <div class="col-6" style="padding-right: 2.5px;">
                              <!-- profile setting Button -->
                              <a href="<?php echo REAL_PATH;?>/dashboard/profile/setting" class="btn btn-block waves-effect waves-light btn-secondary" title="<?php echo label('dash_btn_edit_profile'); ?>">
                                <i class="mdi mdi-account-edit"></i> <?php echo label('dash_btn_edit_profile'); ?>
                              </a>
                            </div>
                            <div class="col-6" style="padding-left: 2.5px;">                            
                              <!-- manage user Button -->
                              <?php if(in_array('manage/userdata', $arr_permission)){ ?>
                              <a href="<?php echo REAL_PATH;?>/manage/userdata" class="btn btn-block waves-effect waves-light btn-secondary" title="<?php echo label('dash_btn_manage_user'); ?>">
                                <i class="mdi mdi-lead-pencil"></i> <?php echo label('dash_btn_manage_user'); ?>
                              </a>
                            <?php } ?>
                            </div>                            
                          </div>
                        </div>

                        <div class="card-body text-center button-group" id="show_admin_dashboard">
                          <div class="row">
                            <div class="col-6" style="padding-right: 2.5px;">
                              <!-- edit profile Button -->
                              <a href="<?php echo REAL_PATH;?>/dashboard/profile/setting" class="btn btn-block waves-effect waves-light btn-secondary" title="<?php echo label('dash_btn_edit_profile'); ?>"><i class="mdi mdi-account-edit"></i> <?php echo label('dash_btn_edit_profile'); ?>
                              </a>
                            </div>
                          
                            <div class="col-6" style="padding-left: 2.5px;">   
                              <a href="<?php echo REAL_PATH;?>/dashboard/profile/certificate" class="btn btn-block waves-effect waves-light btn-secondary" title="<?php echo label('dash_btn_certificate'); ?>"><i class="mdi mdi-certificate"></i> <?php echo label('dash_btn_certificate'); ?></a>
                            </div>                            
                          </div>
                        </div>

                        <?php } ?>
                      </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card">
                            <?php $da_banner_delay = isset($foote[0]['da_banner_delay'])&&intval($foote[0]['da_banner_delay'])>0?intval($foote[0]['da_banner_delay'])*1000:10000; ?>
                            <div id="carouselExampleIndicators3" class="carousel slide" data-ride="carousel" data-interval="<?php echo $da_banner_delay; ?>">
                              <ol class="carousel-indicators">
                                <?php if(isset($pic)&&count($pic)>0){
                                        if($pic != null&&$page=='dashboard'){?>
                                            <?php $count_num = 0;$n=1;foreach ($pic as $row) {
                                              if($n==1){ ?>
                                                <li data-target="#carouselExampleIndicators3" data-slide-to="<?php echo $count_num; ?>" class="active"></li>
                                              <?php }else{?>
                                                <li data-target="#carouselExampleIndicators3" data-slide-to="<?php echo $count_num; ?>"></li>
                                            <?php }$n++;$count_num++;}?>
                                  <?php }
                                      } ?>
                              </ol>
                              <div class="carousel-inner" role="listbox">

                                <?php if(isset($pic)&&count($pic)>0){
                                  if($pic != null&&$page=='dashboard'){?>
                                    <?php $n=1;foreach ($pic as $row) {
                                      $file = ROOT_DIR.'uploads/banner/'.$row['banner'];
                                      if(is_file($file)) {
                                      $array_pathext = explode('.', $row['banner']);
                                            $extension = end($array_pathext);
                                        if($n==1){ 
                                          if($extension=="mp4"){
                                      ?>
                                        <div class="carousel-item active"  style="width: 100%; text-align: center; max-height: 350px;">
                                            <video autoplay muted loop alt="First slide" style="width: 100%;">
                                              <source src="<?php echo REAL_PATH;?>/uploads/banner/<?php echo $row['banner']; ?>" type="video/mp4">
                                            </video>
                                        </div>
                                        <?php 
                                          }else{ ?>
                                        <div class="carousel-item active" style="width: 100%; text-align: center; max-height:350px;"> <img class="img-fluid" width="100%" style="max-height:350px;" src="<?php echo REAL_PATH;?>/uploads/banner/<?php echo $row['banner']; ?>" alt="">
                                        </div>
                                        <?php 
                                          }
                                        }else{
                                          if($extension=="mp4"){
                                        ?>
                                        <div class="carousel-item"  style="width: 100%; text-align: center; max-height: 350px;">
                                            <video autoplay muted loop alt="First slide" style="width: 100%;">
                                              <source src="<?php echo REAL_PATH;?>/uploads/banner/<?php echo $row['banner']; ?>" type="video/mp4">
                                            </video>
                                        </div>
                                      <?php 
                                          }else{ ?>
                                        <div class="carousel-item" style="width: 100%; text-align: center; max-height:350px;"> <img class="img-fluid" width="100%" style="max-height:350px;" src="<?php echo REAL_PATH;?>/uploads/banner/<?php echo $row['banner']; ?>" alt="">
                                        </div>
                                      <?php 
                                          }
                                        }$n++;
                                      }
                                  }?>
                                  <?php }
                                      } ?>
                              </div>
                              <a class="carousel-control-prev" href="#carouselExampleIndicators3" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a> <a class="carousel-control-next" href="#carouselExampleIndicators3" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a> 
                            </div>
                          </div>
                        </div>


                <!-- ============================================================== -->
                <!-- Start ADMIN Content -->
                <!-- ============================================================== -->
                        <div class="col-md-12 div_admin div_instructor" id="admin_1" style="display: none;">
                                <div class="card card-body">
                                    <div class="card-title">
                                      <div class="row">                                
                                        <div class="col-md-12 col-lg-4">
                                          <h4 class="card-title m-b-0"><span class="lstick"></span><?php echo label('dash_b_course_detail'); ?></h4>
                                        </div>
                                        <div class="col-md-12 col-lg-8 text-right">
                                            <div class="row">
                                                <div class="col-md-12 offset-xl-1 col-xl-2 m-auto text-left">
                                                    <p class="m-auto"><?php echo label('dash_b_choose_period'); ?>: </p>
                                                </div>
                                                <select class="col-md-12 col-xl-2 custom-select b-0" id="selectcourse_start_month" onchange="onqueryadmin_course()">
                                                    <option value="" hidden><?php echo label('dash_b_choosemonth'); ?></option>
                                                    <?php 
                                                    if(count($arr_month)>0){
                                                        for ($i=0; $i < count($arr_month); $i++) { 
                                                            ?>
                                                            <option value="<?php echo $arr_month[$i]; ?>" <?php if(date('m')==$arr_month[$i]){echo "selected";} ?>><?php echo $thaimonth[intval($arr_month[$i])]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <select class="col-md-12 col-xl-2 custom-select b-0" id="selectcourse_start_year" onchange="onqueryadmin_course()">
                                                    <option value="" hidden><?php echo label('dash_b_chooseyear'); ?></option>
                                                    <?php 
                                                    if(count($arr_year)>0){
                                                        for ($i=0; $i < count($arr_year); $i++) { 
                                                            ?>
                                                            <option value="<?php echo $arr_year[$i]; ?>" <?php if(date('Y')==$arr_year[$i]){echo "selected";} ?>><?php echo $arr_year[$i]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <div class="col-md-12 col-xl-auto m-auto text-left">
                                                    <p class="m-auto"><?php echo label('dash_b_to'); ?></p>
                                                </div>
                                                <select class="col-md-12 col-xl-2 custom-select b-0" id="selectcourse_end_month" onchange="onqueryadmin_course()">
                                                    <option value="" hidden><?php echo label('dash_b_choosemonth'); ?></option>
                                                    <?php 
                                                    if(count($arr_month)>0){
                                                        for ($i=0; $i < count($arr_month); $i++) { 
                                                            ?>
                                                            <option value="<?php echo $arr_month[$i]; ?>" <?php if(date('m')==$arr_month[$i]){echo "selected";} ?>><?php echo $thaimonth[intval($arr_month[$i])]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <select class="col-md-12 col-xl-2 custom-select b-0" id="selectcourse_end_year" onchange="onqueryadmin_course()">
                                                    <option value="" hidden><?php echo label('dash_b_chooseyear'); ?></option>
                                                    <?php 
                                                    if(count($arr_year)>0){
                                                        for ($i=0; $i < count($arr_year); $i++) { 
                                                            ?>
                                                            <option value="<?php echo $arr_year[$i]; ?>" <?php if(date('Y')==$arr_year[$i]){echo "selected";} ?>><?php echo $arr_year[$i]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                      </div>
                                      <hr>
                                    </div>
                                <div class="row">
                                    <div class="col-lg-3 col-md-6 m-t-20">
                                      <div class="text-center m-b-20">
                                            <input data-plugin="knob" data-width="150" data-height="150" data-linecap="round" data-fgColor="#ec2029" id="chart_course_ongoing" value="0" data-skin="tron" data-angleOffset="0" data-readOnly=true data-thickness=".125" />
                                            <br><small><?php echo label('dash_b_on_going'); ?></small>
                                      </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 m-t-20">
                                       <div class="text-center m-b-20">
                                          <input data-plugin="knob" data-width="150" data-height="150" data-linecap="round" data-fgColor="#10316b" id="chart_course_incoming" value="0" data-skin="tron" data-angleOffset="0" data-readOnly=true data-thickness=".125" />
                                          <br><small><?php echo label('dash_b_incoming'); ?></small>
                                       </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 m-t-20">
                                      <div class="text-center m-b-20">
                                          <input data-plugin="knob" data-width="150" data-height="150" data-linecap="round" data-fgColor="#ffd800" id="chart_course_completed" value="0" data-skin="tron" data-angleOffset="0" data-readOnly=true data-thickness=".125" />
                                          <br><small><?php echo label('dash_b_completed'); ?></small>
                                      </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 m-t-20">
                                      <div class="text-center m-b-20">
                                          <input data-plugin="knob" data-width="150" data-height="150" data-linecap="round" data-fgColor="#9c9fa4" id="chart_course_close" value="0" data-skin="tron" data-angleOffset="0" data-readOnly=true data-thickness=".125" />
                                          <br><small><?php echo label('dash_b_closed'); ?></small>
                                      </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 div_admin div_instructor" style="display: none;">
                            <div class="card card-body" style="min-height: 500px;margin: auto;">
                                <div class="card-title">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                          <h4 class="card-title m-b-0"><span class="lstick"></span><?php echo label('dash_h_access_system'); ?></h4>
                                          <small class="card-subtitle hidden-sm-down"><a href="<?php echo base_url()."log/view"; ?>"><?php echo label('see_more'); ?></a></small>
                                        </div>
                                        <div class="col-lg-6 col-md-6 text-right">
                                            <div class="row">
                                                <select class="col-6 custom-select b-0" id="select_month_devicelog" name="select_month_devicelog" onchange="onqueryadmin_devicelog();">
                                                    <option hidden><?php echo label('dash_b_choosemonth'); ?></option>
                                                    <?php 
                                                    if(count($arr_month_log)>0){
                                                        for ($i=0; $i < count($arr_month_log); $i++) { 
                                                            ?>
                                                            <option value="<?php echo $arr_month_log[$i]; ?>" <?php if(date('m')==$arr_month_log[$i]){echo "selected";} ?>><?php echo $thaimonth[intval($arr_month_log[$i])]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <select class="col-6 custom-select b-0" id="select_year_devicelog" name="select_year_devicelog" onchange="onqueryadmin_devicelog();">
                                                    <option hidden><?php echo label('dash_b_chooseyear'); ?></option>
                                                    <?php 
                                                    if(count($arr_year_log)>0){
                                                        for ($i=0; $i < count($arr_year_log); $i++) { 
                                                            ?>
                                                            <option value="<?php echo $arr_year_log[$i]; ?>" <?php if(date('Y')==$arr_year_log[$i]){echo "selected";} ?>><?php echo $arr_year_log[$i]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="m-0">
                                <div class="row p-t-20">
                                    <div class="col-md-12">
                                        <canvas id="device_log" height="150" style="margin-top: 30px;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-12 div_admin" style="display: none;">
                            <div class="card card-body" style="min-height: 500px;">
                                <div class="card-title">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                          <h4 class="card-title m-b-0"><span class="lstick"></span><?php echo label('dash_h_amountaccess_system'); ?></h4>
                                          <small class="card-subtitle hidden-sm-down"><a href="<?php echo base_url()."log/view"; ?>"><?php echo label('see_more'); ?></a></small>
                                        </div>
                                        <div class="col-lg-6 col-md-6 text-right">
                                            <div class="row">
                                                <select class="col-6 custom-select b-0" id="select_month_userlog" name="select_month_userlog" onchange="onqueryadmin_devicelogbymonth();">
                                                    <option value="" hidden><?php echo label('dash_b_choosemonth'); ?></option>
                                                    <?php 
                                                    if(count($arr_month_log)>0){
                                                        for ($i=0; $i < count($arr_month_log); $i++) { 
                                                            ?>
                                                            <option value="<?php echo $arr_month_log[$i]; ?>" <?php if(date('m')==$arr_month_log[$i]){echo "selected";} ?>><?php echo $thaimonth[intval($arr_month_log[$i])]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <select class="col-6 custom-select b-0" id="select_year_userlog" name="select_year_userlog" onchange="onqueryadmin_devicelogbymonth();">
                                                    <option value="" hidden><?php echo label('dash_b_chooseyear'); ?></option>
                                                    <?php 
                                                    if(count($arr_year_log)>0){
                                                        for ($i=0; $i < count($arr_year_log); $i++) { 
                                                            ?>
                                                            <option value="<?php echo $arr_year_log[$i]; ?>" <?php if(date('Y')==$arr_year_log[$i]){echo "selected";} ?>><?php echo $arr_year_log[$i]; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="m-0">
                                <div class="row p-t-20">
                                    <div class="col-md-12">
                                        <canvas id="user_log" height="150"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="col-lg-6 col-md-12 div_instructor" style="display: none;">
                        <div class="card card-body" style="min-height: 500px; max-height: 500px;">
                            <div class="card-title">
                                <div class="row">
                                    <div class="col-md-12 col-lg-6">
                                      <h4 class="card-title m-b-0"><span class="lstick"></span><?php echo label('d_coursecreated'); ?></h4>
                                    </div>
                                    <div class="col-md-12 col-lg-6 text-right">
                                        <small class="card-subtitle hidden-md-down"><a href="<?php echo base_url()."managecourse/courses_all"; ?>"><?php echo label('see_more'); ?></a></small>
                                    </div>
                                </div>
                            </div>
                            <hr class="m-0">
                            <div class="row p-t-20">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="instructor_create" class="table table-hover" width="100%">
                                            <style>
                                                div#instructor_create_wrapper.dataTables_wrapper.container-fluid.dt-bootstrap4.no-footer{
                                                    padding:0 !important;
                                                }
                                            </style>
                                            <thead>
                                                <tr>
                                                    <th style="min-width: 200px !important;"><center><b><?php echo label('r_course_name'); ?></b></center></th>
                                                    <th style="min-width: 111px !important;"><center><b><?php echo label('number_of_register'); ?></b></center></th>
                                                    <th style="min-width: 150px !important;"><center><b><?php echo label('r_best_score'); ?></b></center></th>
                                                    <th style="min-width: 111px !important;"><center><b><?php echo label('r_high_score'); ?></b></center></th>
                                                    <th style="min-width: 111px !important;"><center><b><?php echo label('r_average_score'); ?></b></center></th>
                                                    <th style="min-width: 111px !important;"><center><b>Rating</b></center></th>
                                                    <th style="min-width: 111px !important;"><center><b><?php echo label('sv_btn_action'); ?></b></center></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>   
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-12 div_admin" style="display: none;">
                        <div class="card card-body" style="min-height: 300px;">
                            <div class="card-title">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                      <h4 class="card-title m-b-0"><span class="lstick"></span><?php echo label('dash_b_total_course'); ?></h4>
                                    </div>
                                    <div class="col-lg-6 col-md-6 text-right">
                                        <small class="card-subtitle hidden-sm-down"><a href="<?php echo base_url()."managecourse/courses_all"; ?>"><?php echo label('see_more'); ?></a></small>
                                    </div>
                                </div>
                            </div>
                            <hr class="m-0">
                            <div class="row p-t-20">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="all_course_table" class="table table-hover" width="100%">
                                            <style>
                                                div#all_course_table_wrapper.dataTables_wrapper.container-fluid.dt-bootstrap4.no-footer{
                                                    padding:0 !important;
                                                }
                                            </style>
                                            <thead>
                                                <tr>
                                                    <th width="65%"><b><?php echo label('division_title'); ?></b></th>
                                                    <th width="35%"><b><?php echo label('num_course'); ?></b></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>   
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 div_admin" style="display: none;">
                        <div class="card card-body" style="min-height: 300px;">
                            <div class="card-title">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                      <h4 class="card-title m-b-0"><span class="lstick"></span><?php echo label('dash_b_total_users'); ?></h4>
                                    </div>
                                    <div class="col-lg-6 col-md-6 text-right">
                                        <small class="card-subtitle hidden-sm-down"><a href="<?php echo base_url()."manage/userdata"; ?>"><?php echo label('see_more'); ?></a></small>
                                    </div>
                                </div>
                            </div>
                            <hr class="m-0">
                            <div class="row p-t-20">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="all_user_table" class="table table-hover" width="100%">
                                            <style>
                                                div#all_user_table_wrapper.dataTables_wrapper.container-fluid.dt-bootstrap4.no-footer{
                                                    padding:0 !important;
                                                }
                                            </style>
                                            <thead>
                                                <tr>
                                                    <th width="70%"><b><?php echo label('division_title'); ?></b></th>
                                                    <th width="30%"><b><?php echo label('num_user'); ?></b></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                </div>   
                            </div>
                        </div>
                    </div>


                     <div class="col-md-12 div_instructor" style="display: none;">
                        <div class="card">
                            <div class="card-body">
                                <div class="card-title">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6">
                                      <h4 class="card-title m-b-0"><span class="lstick"></span><?php echo label('d_lastcompleted'); ?></h4>
                                      <small class="card-subtitle hidden-md-down"><a href="javascript:void(0)"><?php echo label('see_more'); ?></a></small>
                                    </div>
                                    <div class="col-md-6 col-lg-6 text-right">
                                        <div class="row">
                                            <select class="custom-select b-0" id="course_select_instructor">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="table-responsive no-wrap">
                                    <style>
                                        div#instructor_latest_complete_wrapper.dataTables_wrapper.container-fluid.dt-bootstrap4.no-footer{
                                            padding:0 !important;
                                        }
                                    </style>
                                    <table id="instructor_latest_complete" class="table vm no-th-brd pro-of-month no-wrap" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="min-width: 92px !important;"></th>
                                                <th style="min-width: 152px !important;"><b><?php echo label('m_name'); ?></b></th>
                                                <th style="min-width: 336px !important;"><b><?php echo label('course'); ?></b></th>
                                                <th style="min-width: 100px !important;"><b><?php echo label('status'); ?></b></th>
                                                <th style="min-width: 94px !important;"><b><?php echo label('score'); ?></b></th>
                                                <th style="min-width: 292px !important;"><b><?php echo label('com_createdate'); ?></b></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>