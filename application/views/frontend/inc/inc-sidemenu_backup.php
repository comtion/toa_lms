        <aside class="left-sidebar" id="navbar" style="transition: top 0.3s;">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav white-color ">
                    <ul id="sidebarnav">
                        <!-- <li class="<?php echo $page == 'home' ? 'active' : '' ?>"> <a class="waves-effect waves-dark" href="<?php echo REAL_PATH;?>/home" aria-expanded="false"><i class="mdi mdi-home"></i><?php echo label('home'); ?></a> -->

                        <li class="<?php echo $page == 'dashboard' ? 'active' : '' ?>"><a class="waves-effect waves-dark" href="<?php echo REAL_PATH;?>/dashboard"><i class="mdi mdi-view-dashboard" aria-hidden="true"></i><?php echo label('dashboard'); ?></a></li>
                        <?php $target = array( 'course/available', 'course/loadCourse');
                        if(array_intersect($target, $arr_permission)){ ?>
                        <li class="<?php echo (in_array($page, array('course/available','course/loadCourse','course/detail'))) ? 'subactive' : '' ?>"> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-book-open-page-variant"></i><span class="hide-menu"><?php echo label('learningsystem'); ?></span></a>
                            <ul aria-expanded="false" class="collapse">
                              <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-book-open-page-variant"></i><span class="hide-menu"> <?php echo label('coursedata'); ?></span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <!-- <?php if(in_array('workgroup/loadWorkGroup', $arr_permission)){ ?>
                                    <li class="<?php echo $page == 'workgroup/loadWorkGroup'  ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/workgroup/loadWorkGroup"><i class="mdi mdi-group"></i> <?php echo label('allworkgroup'); ?></a></li>
                                    <?php } ?>
                                    <?php if(in_array('coursegroup/loadCourseGroup', $arr_permission)){ ?>
                                    <li class="<?php echo $page == 'coursegroup/loadCourseGroup'  ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/coursegroup/loadCourseGroup"><i class="mdi mdi-group"></i> <?php echo label('allcoursegroup'); ?></a></li>
                                    <?php } ?> -->
                                    <?php if(in_array('course/available', $arr_permission)){ ?>
                                    <li class="<?php echo $page == 'course/available'  ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/course/available"><i class="mdi mdi-file-document"></i> <?php echo label('allcos'); ?></a></li>
                                    <?php } ?>
                                    <?php if(in_array('course/loadCourse', $arr_permission)){ ?>
                                    <?php if($user['Is_admin']!="1"||($user['Is_admin']=="1"&&$user['ug_for']=="CUSTOMER")){ ?>
                                      <li class="<?php echo $page == 'course/loadCourse'  ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/course/loadCourse"><i class="mdi mdi-file-document"></i> <?php echo label('mycos'); ?></a></li>
                                    <?php } ?>
                                    <?php } ?>
                                </ul>
                              </li>
                            </ul>
                        </li>
                        <?php } ?>
                        
                        <?php $target = array('survey/list_survey', 'survey/report_survey');
                        if(array_intersect($target, $arr_permission)){ ?>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-file-document-box"></i><span class="hide-menu"><?php echo label('survey'); ?></span></a>
                            <ul aria-expanded="false" class="collapse">
                              <?php if(in_array('survey/list_survey', $arr_permission)){ ?>
                              <li class="<?php echo $page == 'survey/list_survey' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/survey/list_survey"><i class="mdi mdi-format-list-bulleted"></i> <?php echo label('list_survey'); ?></a></li>
                              <?php } ?>
                              <?php if(in_array('survey/report_survey', $arr_permission)){ ?>
                              <li class="<?php echo $page == 'survey/report_survey' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/survey/report_survey"><i class="mdi mdi-chart-line"></i> <?php echo label('report_survey'); ?></a></li>
                              <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>
                        
                        <?php $target = array('manage/companydata', 'manage/departmentdata', 'manage/userdata', 'dashboard/unlockAcc', 'dashboard/resetPass');
                        if(array_intersect($target, $arr_permission)){ ?>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account-settings"></i> <span class="hide-menu"><?php echo label('manageusers'); ?></span></a>
                            <ul aria-expanded="false" class="collapse">
                              <?php if(in_array('manage/companydata', $arr_permission)){ ?>
                              <?php if($com_admin=="com_central"){ ?>
                              <li class="<?php echo $page == 'manage/companydata' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/manage/companydata"><i class="mdi mdi-account-settings-variant"></i> <?php echo label('managecompany'); ?></a></li>
                              <?php } ?>
                              <?php } ?>
                              <?php if(in_array('manage/departmentdata', $arr_permission)){ ?>
                              <li class="<?php echo $page == 'manage/departmentdata' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/manage/departmentdata"><i class="mdi mdi-account-settings-variant"></i> <?php echo label('managedepartment'); ?></a></li>
                              <?php } ?>
                              <?php if(in_array('manage/userdata', $arr_permission)){ ?>
                              <li class="<?php echo $page == 'manage/userdata' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/manage/userdata"><i class="mdi mdi-account-settings-variant"></i> <?php echo label('manageuser'); ?></a></li>
                              <?php } ?>
                              <?php if(in_array('dashboard/unlockAcc', $arr_permission)){ ?>
                              <li class="<?php echo $page == 'dashboard/unlockAcc' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/dashboard/unlockAcc"><i class="mdi mdi-account-key"></i> <?php echo label('unlock').label('account'); ?></a></li>
                              <?php } ?>
                              <?php if(in_array('dashboard/resetPass', $arr_permission)){ ?>
                              <li class="<?php echo $page == 'dashboard/resetPass' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/dashboard/resetPass"><i class="mdi mdi-account-key"></i> <?php echo label('manage').label('password'); ?></a></li>
                              <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>
                        <?php $target = array('report/loadreport_company', 'report/loadreport_coursename', 'report/loadreport_student', 'report/loadreport_personal', 'log/view');
                        if(array_intersect($target, $arr_permission)){ ?>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-newspaper"></i><span class="hide-menu"><?php echo label('report'); ?></span></a>
                            <ul aria-expanded="false" class="collapse">
                              <?php $target_report = array('report/loadreport_company', 'report/loadreport_coursename', 'report/loadreport_student', 'report/loadreport_personal');
                              if(array_intersect($target_report, $arr_permission)){ ?>
                              <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-file-document-box"></i><span class="hide-menu"> <?php echo label('report_general'); ?></span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <?php if(in_array('report/loadreport_company', $arr_permission)){ ?>
                                      <li class="<?php echo $page == 'report/loadreport_company'  ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/report/loadreport_company"><i class="mdi mdi-file-document-box"></i> <?php echo label('report_company'); ?></a></li>
                                    <?php } ?>
                                    <?php if(in_array('report/loadreport_coursename', $arr_permission)){ ?>
                                      <li class="<?php echo $page == 'report/loadreport_coursename'  ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/report/loadreport_coursename"><i class="mdi mdi-file-document-box"></i> <?php echo label('report_course'); ?></a></li>
                                    <?php } ?>
                                    <?php if(in_array('report/loadreport_student', $arr_permission)){ ?>
                                      <li class="<?php echo $page == 'report/loadreport_student'  ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/report/loadreport_student"><i class="mdi mdi-file-document-box"></i> <?php echo label('report_student'); ?></a></li>
                                    <?php } ?>
                                    <?php if(in_array('report/loadreport_survey', $arr_permission)){ ?>
                                      <li class="<?php echo $page == 'report/loadreport_survey'  ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/report/loadreport_survey"><i class="mdi mdi-file-document-box"></i> <?php echo label('report_survey'); ?></a></li>
                                    <?php } ?>
                                    <?php if(in_array('report/loadreport_personal', $arr_permission)){ ?>
                                      <li class="<?php echo $page == 'report/loadreport_personal'  ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/report/loadreport_personal"><i class="mdi mdi-file-document-box"></i> <?php echo label('report_personal'); ?></a></li>
                                    <?php } ?>
                                </ul>
                              </li>
                              <?php } ?>
                              <?php if(in_array('report/loadreport', $arr_permission)){ ?>
                              <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-file-document-box"></i><span class="hide-menu"> <?php echo label('lesson'); ?></span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li class="<?php echo $page == 'report/loadreport'  ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/report/loadreport"><?php echo label('allreport'); ?></a></li>
                                </ul>
                              </li>
                              <?php } ?>
                              <?php if(in_array('report/loadreport', $arr_permission)){ ?>
                              <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-file-document-box"></i><span class="hide-menu"> <?php echo label('quiz'); ?></span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li class="<?php echo $page == 'report/loadreport'  ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/report/loadreport"><?php echo label('allreport'); ?></a></li>
                                </ul>
                              </li>
                              <?php } ?>
                              <?php if(in_array('report/loadreport', $arr_permission)){ ?>
                              <li><a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-file-document-box"></i><span class="hide-menu"> <?php echo label('survey'); ?></span></a>
                                <ul aria-expanded="false" class="collapse">
                                    <li class="<?php echo $page == 'report/loadreport'  ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/report/loadreport"><?php echo label('allreport'); ?></a></li>
                                </ul>
                              </li>
                              <?php } ?>
                              <?php if(in_array('log/view', $arr_permission)){ ?>
                              <li class="<?php echo $page == 'log/view' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/log/view"><i class="mdi mdi-history"></i> <?php echo label('log_record'); ?></a></li>
                              <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>

                        <?php $target = array('setting/ManageBanner','setting/ManageECT', 'setting/ManageTestimonials', 'manage/groupuserdata', 'setting/ManageFAQ', 'setting/ManageMenu','quiz/create_template','questionnaire/create','setting/ManageMainmenu','setting/setting_email','setting/format_email','coursetype/loadCourseType');
                        if(array_intersect($target, $arr_permission)){ ?>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-settings"></i><span class="hide-menu"><?php echo label('ManageSetting'); ?></span></a>
                            <ul aria-expanded="false" class="collapse">

                              <?php $target = array('setting/ManageECT','setting/ManageMainmenu','setting/ManageBanner','setting/ManageBannerCourse','coursetype/loadCourseType');
                              if(array_intersect($target, $arr_permission)){ ?>
                              <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-settings"></i> <span class="hide-menu"><?php echo label('ManageECT'); ?></span></a>
                                  <ul aria-expanded="false" class="collapse">
                                          <li class="<?php echo $page == 'setting/ManageECT' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/setting/ManageECT"><i class="mdi mdi-settings"></i> <?php echo label('ManageDATA'); ?></a></li>
                                          <li class="<?php echo $page == 'setting/ManageBanner' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/setting/ManageBanner"><i class="mdi mdi-file-image"></i> <?php echo label('banner'); ?></a></li>
                                          <li class="<?php echo $page == 'setting/ManageBannerCourse' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/setting/ManageBannerCourse"><i class="mdi mdi-file-image"></i> <?php echo label('bannercourse'); ?></a></li>
                                          <!-- <li class="<?php echo $page == 'setting/ManageMainmenu' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/setting/ManageMainmenu"><i class="mdi mdi-settings"></i> <?php echo label('ManageMainmenu'); ?></a></li> -->
                                          <!-- <li class="<?php echo $page == 'setting/ManageSSO' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/setting/ManageSSO"><i class="mdi mdi-settings"></i> <?php echo label('ManageSSO'); ?></a></li> -->
                                          <?php if(in_array('coursetype/loadCourseType', $arr_permission)){ ?>
                                          <li class="<?php echo $page == 'coursetype/loadCourseType' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/coursetype/loadCourseType"><i class="mdi mdi-format-list-bulleted-type"></i> <?php echo label('ceCtype'); ?></a></li>
                                          <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>

                              <?php $target = array('setting/setting_email','setting/format_email');
                              if(array_intersect($target, $arr_permission)){ ?>
                              <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-settings"></i> <span class="hide-menu"><?php echo label('EmailSetting'); ?></span></a>
                                  <ul aria-expanded="false" class="collapse">
                                          <li class="<?php echo $page == 'setting/setting_email' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/setting/setting_email"><i class="mdi mdi-settings"></i> <?php echo label('Emailset'); ?></a></li>
                                          <li class="<?php echo $page == 'setting/format_email' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/setting/format_email"><i class="mdi mdi-settings"></i> <?php echo label('TemplateMail'); ?></a></li>
                                  </ul>
                              </li>
                              <?php } ?>
                              
                              <?php if(in_array('setting/ManageFAQ', $arr_permission)){ ?>
                              <li class="<?php echo $page == 'setting/ManageFAQ' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/setting/ManageFAQ"><i class="mdi mdi-settings"></i> <?php echo label('faqman'); ?></a></li>
                              <?php } ?>
                              
                            <?php if($com_admin=="com_central"){ ?>
                              <?php if(in_array('setting/ManageMenu', $arr_permission)){ ?>
                              <li class="<?php echo $page == 'setting/ManageMenu' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/setting/ManageMenu"><i class="mdi mdi-settings"></i> <?php echo label('menu_setting'); ?></a></li>
                              <?php } ?>
                            <?php } ?>

                            

                            <?php $target = array('manage/groupuserdata');
                            if(array_intersect($target, $arr_permission)){ ?>
                            <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-account-settings"></i> <span class="hide-menu"><?php echo label('manageusers'); ?></span></a>
                                <ul aria-expanded="false" class="collapse">
                                  <?php if(in_array('manage/groupuserdata', $arr_permission)){ ?>
                                    <li class="<?php echo $page == 'manage/groupuserdata' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/manage/groupuserdata"><i class="mdi mdi-account-multiple"></i> <?php echo label('managegroupuser'); ?></a></li>
                                  <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>
                            
                            </ul>
                        </li>
                        <?php } ?>

                        <?php $target = array('qrcode/create');
                        if(array_intersect($target, $arr_permission)){ ?>
                        <li class="<?php echo $page == 'qrcode/create' ? 'active' : '' ?>"><a class="waves-effect waves-dark" href="<?php echo REAL_PATH;?>/qrcode/create"><i class="mdi mdi-qrcode" aria-hidden="true"></i> QR Code</a></li>
                        <?php } ?>
                        
                        <?php $target = array( 'managecourse/course_groups', 'managecourse/courses_all','certificate/certificateall');
                        if(array_intersect($target, $arr_permission)){ ?>
                        <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-book-open-page-variant"></i> <span class="hide-menu"><?php echo label('manage_courses'); ?></span></a>
                            <ul aria-expanded="false" class="collapse">
                              <?php if(in_array('managecourse/course_groups', $arr_permission)){ ?>
                              <li class="<?php echo $page == 'managecourse/course_groups' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/managecourse/course_groups"><i class="mdi mdi-group"></i> <?php echo label('allcoursegroup'); ?></a></li>
                              <?php } ?>
                              <?php if(in_array('managecourse/courses_all', $arr_permission)){ ?>
                              <li class="<?php echo $page == 'managecourse/courses_all' ? 'active' : '' ?>"><a href="<?php echo REAL_PATH;?>/managecourse/courses_all"><i class="mdi mdi-file-document"></i> <?php echo label('allcos'); ?></a></li>
                              <?php } ?>
                              
                              <?php if(in_array('certificate/certificateall', $arr_permission)){ ?>
                                    <li class="<?php echo $page == 'certificate/certificateall'  ? 'active' : '' ?>">
                                      <a href="<?php echo REAL_PATH;?>/certificate/certificateall">
                                          <i class="mdi mdi-certificate" aria-hidden="true"></i>
                                        <span class="hide-menu">
                                          <?php echo label('certificate_menu'); ?>
                                        </span>
                                      </a>
                                    </li>
                              <?php } ?>
                              <?php $target_template = array('quiz/create_template', 'questionnaire/create');
                              if(array_intersect($target_template, $arr_permission)){  ?>
                              <li class="<?php echo (in_array($page, array('quiz/create_template', 'questionnaire/create'))) ? 'subactive' : '' ?> context-menu"> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-book-open-page-variant"></i><span class="hide-menu"> <?php echo label('learningsystem'); ?></span></a>
                                <ul aria-expanded="false" class="collapse">
                                  <?php if(in_array('quiz/create_template', $arr_permission)){ ?>
                                    <li class="<?php echo $page == 'quiz/create_template'  ? 'active' : '' ?>">
                                      <a href="<?php echo REAL_PATH;?>/quiz/create_template">
                                          <i class="mdi mdi-file-document" aria-hidden="true"></i>
                                        <span class="hide-menu">
                                          <?php echo label('quiz_ex'); ?>
                                        </span>
                                      </a>
                                    </li>
                                  <?php } ?>
                                  <?php if(in_array('questionnaire/create', $arr_permission)){ ?>
                                    <li class="<?php echo $page == 'questionnaire/create'  ? 'active' : '' ?>">
                                      <a href="<?php echo REAL_PATH;?>/questionnaire/create">
                                          <i class="mdi mdi-file-document" aria-hidden="true"></i>
                                        <span class="hide-menu">
                                          <?php echo label('svtheme'); ?>
                                        </span>
                                      </a>
                                    </li>
                                  <?php } ?>
                                </ul>
                              </li>
                              <?php } ?>
                            </ul>
                        </li>
                        <?php } ?>

                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        
        <!-- HIDE/SHOW MENU BAR -->
        <script>
          $( document ).ready(function() {
            var prevScrollpos = window.pageYOffset;
            window.onscroll = function() {
            var currentScrollPos = window.pageYOffset;
              if (prevScrollpos > currentScrollPos) {
                document.getElementById("navbar").style.top = "0";
              } else {
                document.getElementById("navbar").style.top = "-65px";
              }
              prevScrollpos = currentScrollPos;
            }
          });
        </script>