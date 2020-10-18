<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php $this->load->view('frontend/inc/inc-meta-dashboard.php'); ?>
<?php 
            $widthdivv = 0;
            if(!isMobile()){ 
              $widthdivv = 240;
            }else{
              $widthdivv = 60;
            }
?>
    <link rel="stylesheet" type="text/css" href="<?php echo REAL_PATH; ?>/assets/plugins/datatables/media/css/dataTables.bootstrap4.css">
    <link href="<?php echo REAL_PATH; ?>/assets/plugins/wizard/steps.css" rel="stylesheet">
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label"><?php if($lang=="thai"){echo $foote[0]['da_title_th'];}else{echo $foote[0]['da_title_en'];} ?></p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <?php $this->load->view('frontend/inc/inc-header.php'); ?>
        <?php $this->load->view('frontend/inc/inc-sidemenu.php'); ?>
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row col-12 page-titles">
                    <div class="col-md-5 align-self-center">
                        <b><?php echo ucwords(strtolower($title)); ?></b>
                    </div>
                    <div class="col-md-7 align-self-right">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo REAL_PATH;?>/dashboard"><?php echo ucwords(label('dashboard')); ?></a></li>
                            <?php if($title_main!=""){ ?>
                            <li class="breadcrumb-item active"><?php echo ucwords(strtolower($title_main)); ?></li>
                            <?php } ?>
                            <li class="breadcrumb-item active"><?php echo ucwords(strtolower($title)); ?></li>
                        </ol>
                    </div>
                </div>  

                <div class="row col-12 page-titles">
                  <div class="col-md-12 card">
                    <div class="card-body">
                      <div class="col-md-12" align="right">
                        <?php if($btn_add=="1"){ ?>
                          <button name="add_button" id="add_button" class="btn btn-outline-info add_button" data-toggle="modal" data-target="#modal-default"><i class="mdi mdi-plus-box-outline"></i> <?php echo label('create_user'); ?></button>
                          <button name="import_button" id="import_button" class="btn btn-outline-primary import_button" data-toggle="modal" data-target="#modal-import"><i class="mdi mdi-import"></i> <?php echo label('import_user'); ?></button>
                        <?php } ?>
                        <?php if($btn_print=="1"){ ?>
                          <button name="export_button" id="export_button" class="btn btn-outline-success export_button"><i class="mdi mdi-export"></i> <?php echo label('export_user'); ?></button>
                        <?php } ?>
                      </div>
                        <?php if($com_admin!="com_associated"&&($user['ug_id']=="1")){ ?>
                            <div class="col-md-6" align="left">
                                  <label for="com_id"><?php echo label('com_name'); ?>:</label>
                                  <select class="form-control select2" id="com_id_search" name="com_id_search"  style="width: 100%;">
                                    <?php   if(count($company_arr)>0){ ?>
                                                <optgroup label="<?php echo label('please_com_name'); ?>">
                                        <?php   $numloop = 1;
                                                foreach ($company_arr as $key_com => $value_com) { ?>
                                                    <option value="<?php echo $value_com['com_id']; ?>" <?php if($numloop==1){echo "selected";}$numloop++; ?>><?php echo $lang=="thai"?$value_com['com_name_th']:$value_com['com_name_eng']; ?></option>
                                        <?php   } ?>
                                                </optgroup>
                                    <?php   } ?>
                                  </select>
                            </div>
                        <?php }else{ ?>
                            <input type="hidden" id="com_id_search" name="com_id_search" value="<?php echo $com_id; ?>">
                        <?php } ?>
                      <div class="table-responsive">
                          <table id="myTable" width="100%" class="table table-bordered">
                            <thead>
                              <tr>
                                <th style="min-width: 80px !important;" align="center"><center><?php echo label('manage'); ?></center></th>
                                <th width="5%"><?php echo label('number'); ?></th>
                                <th width="15%" align="center"><center><?php echo label('m_username'); ?></center></th>
                                <th width="25%" align="center"><center><?php echo label('m_name'); ?></center></th>
                                <th width="25%" align="center"><center><?php echo label('m_usergroup'); ?></center></th>
                                <!--<th width="10%" align="center"><center><?php echo label('m_department'); ?></center></th>-->
                                <th width="20%" align="center"><center><?php echo label('m_company'); ?></center></th><!-- 
                                <th width="10%" align="center"><?php echo label('m_status'); ?></th> -->
                              </tr>
                            </thead>
                          </table>
                      </div>
                      <p><?php echo label('preNote'); ?>: <?php if($btn_update=="1"){ ?><button type="button" class="btn btn-warning btn-xs"><i class="mdi mdi-lead-pencil"></i></button> = <b><?php echo label('m_edit'); ?></b><?php } ?><?php if($btn_delete=="1"&&$btn_update=="1"){echo " , ";} if($btn_delete=="1"){ ?><button type="button" class="btn btn-danger btn-xs"><i class="mdi mdi-window-close"></i></button> = <b><?php echo label('delete'); ?></b><?php } ?></p>
                      <!-- <?php if($user['ug_id']=="1"){ ?><button type="button" class="btn btn-info btn-xs"><i class="mdi mdi-account-key"></i></button> = <b><?php echo label('m_permission'); ?></b><?php } if($user['ug_id']=="1"&&$btn_update=="1"){echo " , ";} ?> -->
                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('frontend/inc/inc-footer.php'); ?>

    <div class="modal fade bs-example-modal-lg" id="modal-default" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <div class="modal-body">
                <div class="card wizard-content">
                            <div class="card-body">
                                <form method="post" id="user_form" autocomplete="off" name="user_form" enctype="multipart/form-data" class="validation-wizard wizard-circle">
                                    <input type="hidden" id="operation" name="operation" value="Add">
                                    <input type="hidden" id="u_id" name="u_id">
                                    <input type="hidden" id="emp_id" name="emp_id">
                                    <input type="hidden" id="img_profile_ori" name="img_profile_ori">
                                    <input type="hidden" id="employ_date" name="employ_date">
                                    <input type="hidden" id="employ_date_var" name="employ_date_var">
                                    <input type="hidden" id="com_id" name="com_id">
                                    <!-- Step 1 -->
                                    <h6><?php echo label('m_general_information'); ?></h6>
                                    <section>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                  <label for="div_id"><b style="color: #FF2D00">*</b><?php echo label('div_name'); ?>:</label>
                                                  <select class="form-control select2" required id="div_id" name="div_id" onchange="divisionchk($(this).val())" style="width: 100%;">
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                  <label for="group_id"><?php echo label('group_name'); ?>:</label>
                                                  <select class="form-control select2" id="group_id" name="group_id"  onchange="grouponchk($(this).val())" style="width: 100%;">
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                  <label for="dep_id"><?php echo label('dep_name'); ?>:</label>
                                                  <select class="form-control select2"  id="dep_id" name="dep_id" onchange="departmentonchk($(this).val())"  style="width: 100%;">
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                  <label for="section_id"><?php echo label('section_name'); ?>:</label>
                                                  <select class="form-control select2"  id="section_id" name="section_id" onchange="sectiononchk($(this).val())" style="width: 100%;">
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                  <label for="salearea_id"><?php echo label('salearea_name'); ?>:</label>
                                                  <select class="form-control select2"  id="salearea_id" name="salearea_id"  style="width: 100%;">
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                  <label for="posi_id"><b style="color: #FF2D00">*</b><?php echo label('posi_name'); ?>:</label>
                                                  <select class="form-control select2" required id="posi_id" name="posi_id" onchange="positiononchk(this.value)" style="width: 100%;">
                                                  </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="emp_level"><?php echo label('level'); ?>:</label>
                                                    <select class="form-control select2" id="emp_level" name="emp_level"  style="width: 100%;">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="emp_parent_id"><?php echo label('p_lead'); ?>:</label>
                                                    <select class="form-control select2" id="emp_parent_id" name="emp_parent_id"  style="width: 100%;">
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="st_id"><?php echo label('store_name'); ?>:</label>
                                                    <select class="form-control select2" id="st_id" name="st_id"  style="width: 100%;">
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                          <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="emp_c"> <b style="color: #FF2D00">*</b><?php echo label('m_emp_c'); ?>: </label>
                                                    <input type="text" class="form-control required" id="emp_c" name="emp_c"> 
                                                </div>
                                            </div>
                                          </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fname_th"> <b style="color: #FF2D00">*</b><?php echo label('m_fname')." TH"; ?>: </label>
                                                    <input type="text" class="form-control required" id="fname_th" name="fname_th"> </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lname_th"> <b style="color: #FF2D00">*</b><?php echo label('m_lname')." TH"; ?>: </label>
                                                    <input type="text" class="form-control required" id="lname_th" name="lname_th"> </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fname_en"> <b style="color: #FF2D00">*</b><?php echo label('m_fname')." EN"; ?>: </label>
                                                    <input type="text" class="form-control required" id="fname_en" name="fname_en"> </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lname_en"> <b style="color: #FF2D00">*</b><?php echo label('m_lname')." EN"; ?>: </label>
                                                    <input type="text" class="form-control required" id="lname_en" name="lname_en"> </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="emp_observer"><?php echo label('is_Observer'); ?>:</label>
                                                    <div class="switch">
                                                        <label><?php echo label('no'); ?><input type="checkbox"  id="emp_observer" name="emp_observer" value="1"><span class="lever switch-col-indigo"></span><?php echo label('yes'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="status"><?php echo label('status'); ?>:</label>
                                                    <div class="switch">
                                                        <label><?php echo label('close'); ?><input type="checkbox"  id="status" name="status" value="1"><span class="lever switch-col-indigo"></span><?php echo label('open'); ?></label>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </section>
                                    <!-- Step 3 -->
                                    <h6><?php echo label('m_user_information'); ?></h6>
                                    <section>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="useri"><b style="color: #FF2D00">*</b><?php echo label('m_username'); ?>: </label>
                                                    <input type="text" class="form-control " required id="useri" name="useri" > 
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="ug_id"><b style="color: #FF2D00">*</b><?php echo label('ug_name'); ?>:</label>
                                                    <select class="form-control select2 " id="ug_id" name="ug_id"  style="width: 100%;" required>
                                                         <!--  <option value=""><?php echo label('กรุณาเลือกบริษัทก่อนนะครับ'); ?></option> -->
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="u_firstdate"><b style="color: #FF2D00">*</b><?php echo label('m_firstdate'); ?>:</label>
                                                    <input type="text" class="form-control" id="u_firstdate" name="u_firstdate" required onchange="caldate('u_firstdate')">
                                                    <input type="hidden" id="u_firstdate_var" name="u_firstdate_var">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="inactivedate"><?php echo label('m_usage_enddate'); ?>:</label>
                                                    <input type="text" class="form-control" id="inactivedate" name="inactivedate" onchange="caldate('inactivedate')">
                                                    <input type="hidden" id="inactivedate_var" name="inactivedate_var">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="lang"> <?php echo label('faqlang'); ?>: </label>
                                                    <select class="custom-select form-control" id="lang" name="lang">
                                                      <option selected value="thai"><?php echo label('thai'); ?></option>
                                                      <option value="english"><?php echo label('eng'); ?></option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="email"> <?php echo label('m_mail'); ?>: </label>
                                                    <input type="text" class="form-control" id="email" name="email" required> </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="control-label text-right"><?php echo label('m_profile'); ?></label>
                                                    <input type="file" name="img_profile" id="img_profile" class="dropify" accept="image/png, image/jpeg, image/gif" />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="path_img"> <?php echo label('path_img'); ?>: </label>
                                                    <input type="text" class="form-control" id="path_img" name="path_img">
                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                </form>
                            </div>
                        </div>
              </div>
              <!--<div class="modal-footer">
                  <input type="submit" name="action" id="action" class="btn btn-outline-success btn-flat pull-left" value="<?php echo label('saveR'); ?>" />
                  <button type="button" class="btn btn-outline-danger btn-flat" data-dismiss="modal"><?php echo label('m_cancel'); ?></button>
              </div>-->
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <div class="modal fade bs-example-modal-lg" id="modal-license" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="mt-0" id="myLargeModalLabel"><i class="mdi mdi-account-key"></i> <?php echo label('m_permission'); ?></h5>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <div class="modal-body">
                <form method="post" id="checkpermission_form" autocomplete="off" name="checkpermission_form" enctype="multipart/form-data"  class="form-horizontal" role="form">
                  <div class="table-responsive" align="center">
                    <table id="datatable" class="table table-bordered table-striped">
                      <thead>
                        <tr>
                          <td align="center" width="10%"><?php echo label('m_number'); ?></td>
                          <td align="center" width="30%"><?php echo label('m_menu'); ?></td>
                          <td align="center" width="10%"><?php echo label('m_select_all'); ?></td>
                          <td align="center" width="10%">
                            <?php echo label('m_enable'); ?>
                            <div class="mt-auto" style="bottom:0px">
                              <div class="checkbox checkbox-success">
                                <input type="checkbox" id="chkcolall_view" class="chkcolall_view checkboxheader" name="chkcolall_view" onchange='chk_chkbox_allcol("ru_view")' value="1">
                                <label for="chkcolall_view"></label>
                              </div>
                            </div>
                          </td>
                          <td align="center" width="10%">
                            <?php echo label('m_add'); ?>
                            <div class="mt-auto" style="bottom:0px">
                              <div class="checkbox checkbox-success">
                                <input type="checkbox" id="chkcolall_add" class="chkcolall_add checkboxheader" name="chkcolall_add" onchange='chk_chkbox_allcol("ru_add")' value="1">
                                <label for="chkcolall_add"></label>
                              </div>
                            </div>
                          </td>
                          <td align="center" width="10%">
                            <?php echo label('m_edit'); ?>
                            <div class="mt-auto" style="bottom:0px">
                              <div class="checkbox checkbox-success">
                                <input type="checkbox" id="chkcolall_edit" class="chkcolall_edit checkboxheader" name="chkcolall_edit" onchange='chk_chkbox_allcol("ru_edit")' value="1">
                                <label for="chkcolall_edit"></label>
                              </div>
                            </div>
                          </td>
                          <td align="center" width="10%">
                            <?php echo label('m_del'); ?>
                            <div class="mt-auto" style="bottom:0px">
                              <div class="checkbox checkbox-success">
                                <input type="checkbox" id="chkcolall_del" class="chkcolall_del checkboxheader" name="chkcolall_del" onchange='chk_chkbox_allcol("ru_del")' value="1">
                                <label for="chkcolall_del"></label>
                              </div>
                            </div>
                          </td>
                          <td align="center" width="10%">
                            <?php echo label('m_export'); ?>
                            <div class="mt-auto" style="bottom:0px">
                              <div class="checkbox checkbox-success">
                                <input type="checkbox" id="chkcolall_print" class="chkcolall_print checkboxheader" name="chkcolall_print" onchange='chk_chkbox_allcol("ru_print")' value="1">
                                <label for="chkcolall_print"></label>
                              </div>
                            </div>
                          </td>
                        </tr>
                      </thead>
                      <tbody id="load_detail">
                        
                      </tbody>
                    </table>

                    <input type="hidden" id="u_id_role" name="u_id_role">
                  </div>
                </form>
              </div>
              <div class="modal-footer" align="center">
                  <button type="button" class="btn btn-outline-danger btn-flat" data-dismiss="modal"><i class="mdi mdi-window-close"></i> <?php echo label('close'); ?></button>
              </div>
          </div><!-- /.modal-content -->
         </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="modal-import_user" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h4><?php echo label('import_user'); ?></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <form method="post" id="import_user_form" autocomplete="off" name="import_user_form" enctype="multipart/form-data"  class="form-horizontal" role="form">
              <div class="modal-body row">
                    <div class="col-md-6">
                        <label for="file_import"><b style="color: #FF2D00">*</b><?php echo 'Excel File'; ?>:</label>
                        <input type="file" name="file_import" required id="file_import" class="dropify"  accept=".xls,.xlsx" />
                        <?php echo label('certificate_example').": "; ?><a href="<?php echo REAL_PATH;?>/uploads/format/format_import_user.xlsx" download>format_import_user.xlsx</a>
                    </div>
                    <div class="col-md-6">
                        <h4><i class="mdi mdi-format-list-numbers"></i> <?php echo label('result_import'); ?>:</h4>
                        <div id="result_import_user" class="slimtest1" style="max-height: 300px;position: relative;"></div>
                    </div>
              </div>
              <input type="hidden" id="operation_import_user" name="operation_import_user" value="Add">
              <input type="hidden" id="com_id_import_user" name="com_id_import_user">
              <div class="modal-footer">
                  <button type="submit" class="btn btn-outline-success btn-flat pull-left" name="action" id="action"><i class="mdi mdi-content-save"></i> <?php echo label('saveR'); ?></button>
                  <button type="button" class="btn btn-outline-danger btn-flat" data-dismiss="modal"><i class="mdi mdi-window-close"></i> <?php echo label('m_cancel'); ?></button>
              </div>
              </form>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/bootstrap-datepicker/bootstrap-datepicker-custom/dist/js/bootstrap-datepicker-custom.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/bootstrap-datepicker/bootstrap-datepicker-custom/dist/locales/bootstrap-datepicker.th.min.js" charset="UTF-8"></script>

      <div id="myModal_process" class="modal fade bs-example-modal-lg" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-body" align="center">
                <img src="<?php echo REAL_PATH; ?>/assets/images/01-progress.gif" style="width: 50%">
                <br>
                <h3 style="color: black;"><?php echo label('please_wait'); ?></h3>
              </div>
            </div>
        </div>
      </div>

    <script type="text/javascript">var base_url = "<?php echo REAL_PATH; ?>";</script>
    <!-- This is data table -->
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/datatables/datatables.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/moment/moment.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/wizard/jquery.steps.min.js"></script>
    <script src="<?php echo REAL_PATH; ?>/assets/plugins/wizard/jquery.validate.min.js"></script>

    <!--stickey kit -->
    <script type="text/javascript">
        $('.slimtest1').perfectScrollbar();
        $.fn.steps.setStep = function (step)
        {
          var currentIndex = $(this).steps('getCurrentIndex');
          for(var i = 0; i < Math.abs(step - currentIndex); i++){
            if(step > currentIndex) {
              $(this).steps('next');
            }
            else{
              $(this).steps('previous');
            }
          } 
        };
        function changedate(value){
            var res_date = value.split("/");
            <?php if($lang=="thai"){ ?>
            return (parseInt(res_date[2])-543)+"-"+res_date[1]+"-"+res_date[0];
            <?php }else{ ?>
            return (parseInt(res_date[2]))+"-"+res_date[1]+"-"+res_date[0];
            <?php } ?>
        }
        function onchkempc(emp_c){
            var operation = $('#operation').val();
            if(operation=="Add"){

            }
        }

        function clear_dropify(id){
            var drEvent = $(id).dropify(
                    {
                      defaultFile: ''
                    });
                    drEvent = drEvent.data('dropify');
                    drEvent.resetPreview();
                    drEvent.clearElement();
                    drEvent.settings.defaultFile = '';
                    drEvent.destroy();
                    drEvent.init();
        }


        function caldate(id){
            var val_change = changedate($('#'+id).val());  
            $('#'+id+'_var').val(val_change);
        }
        $(document).on('submit', '#import_user_form', function(event){
              event.preventDefault(); 
              $("#myModal_process").modal({backdrop: false});
              $( "body" ).addClass( "modal-open" );
              var com_id = $('#com_id_import_user').val();
              var file_import = $('#file_import').val();
              if(file_import!=""){
                $.ajax({
                  url:"<?=base_url()?>index.php/importdata/datauser",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  dataType:"json",
                  success:function(data)
                  {
                    $( "#myModal_process" ).modal( "hide" );
                    $('.modal-backdrop').remove();
                    document.getElementById('myModal_process').style.display = 'none';
                    $( "body" ).removeClass( "modal-open" );
                    $('body').css('padding-right','0');
                    topFunction();
                    if(data.status=="2"){
                        $('#import_user_form')[0].reset();
                        swal(
                            '<?php echo label("after_upload_file"); ?>!',
                            ''
                        ).then(function () {
                            console.log(data.result);
                            topFunction();
                            fetch_data(0);
                            $('#com_id_search').val(com_id);
                            $('#result_import_user').html(data.result);
                            clear_dropify('#file_import');
                        })
                    }else if(data.status=="1"){
                        swal({
                            title: '<?php echo label("manageimport_msgerror"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            document.getElementById("file_import").focus();
                        })
                    }else{
                        swal({
                            title: '<?php echo label("com_msg_error_save"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        })
                    }
                   
                  }
                });
              }else{
                
                        swal({
                            title: '<?php echo label("manageimport_msgerror"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            document.getElementById("file_import").focus();
                        })
              }
         });
        fetch_data(0);
        function fetch_data(page_num)
         {
            var com_id = $('#com_id_search').val();
            $('#myTable').DataTable().destroy();
            var table = $('#myTable').DataTable({
            "language": {
              "zeroRecords": "<?php echo label('wg_datanotfound'); ?>",
              "infoEmpty": "<?php echo label('wg_datanotfound'); ?>",
              "sInfo":           "<?php echo label('sInfo'); ?>",
              "sInfoEmpty":      "<?php echo label('sInfoEmpty'); ?>",
              "decimal":        "",
              "emptyTable":     "<?php echo label('wg_datanotfound'); ?>",
              "infoPostFix":    "",
              "thousands":      ",",
              //"lengthMenu":     "แสดง _MENU_ รายการ",
              "lengthMenu":     "<?php echo label('lengthMenu'); ?>",
              "loadingRecords": "<?php echo label('loadingRecords'); ?>",
              "processing":     "<?php echo label('processing'); ?>",
              "search":         "<?php echo label('filter_bar'); ?>",
              "zeroRecords":    "<?php echo label('wg_datanotfound'); ?>",
              "paginate": {
                  "first":      "<?php echo label('firstpage'); ?>",
                  "last":       "<?php echo label('last'); ?>",
                  "next":       "<?php echo label('lrn_btn_next'); ?>",
                  "previous":   "<?php echo label('previous'); ?>"
                       },
            },
            "scrollX": true,
                "ajax": {
                    url: '<?=base_url()?>index.php/manage/fetch_detail_user/',
                    type : 'GET',
                    data : {com_id:com_id},
                },
                  "initComplete": function () {
                    setTimeout( function () {
                      var info = table.page.info();
                      var length = info.pages;
                      var page_current = info.page;
                      if((page_num+1)>length){
                        page_num = length-1;
                      }
                      table.page(page_num).draw(false);
                    }, 10 );
                  }
            });
         }
        $('select[name="com_id_search"]').on('change', function(){
          var com_id = $(this).val();
          fetch_data(0);
        });
      function forceLower(strInput) 
      {
        strInput.value=strInput.value.toLowerCase();
        $('#email').val(strInput.value);
      }
      
            function divisionchk(div_id){
                                $.ajax({
                                  url: '<?=base_url()?>index.php/manage/recheckgroup',
                                  type: 'POST',
                                  data:{group_id:'',div_id:div_id},
                                  success: function(data){
                                      $('#group_id').html(data);
                                      $('#group_id').val($('#group_id option:first-child').val()).trigger('change');
                                  }
                                });               
            }
            function grouponchk(group_id){
                                $.ajax({
                                  url: '<?=base_url()?>index.php/manage/recheckdepartment',
                                  type: 'POST',
                                  data:{dep_id:'',group_id:group_id},
                                  success: function(data){
                                      $('#dep_id').html(data);
                                      $('#dep_id').val($('#dep_id option:first-child').val()).trigger('change');
                                  }
                                }); 
            }
            function departmentonchk(dep_id){
                                            $.ajax({
                                              url: '<?=base_url()?>index.php/manage/rechecksection',
                                              type: 'POST',
                                              data:{section_id:'',dep_id:dep_id},
                                              success: function(data){
                                                  $('#section_id').html(data);
                                                  $('#section_id').val($('#section_id option:first-child').val()).trigger('change');
                                                  //var section_id = $('#section_id').val();
                                              }
                                            }); 
            }
            function sectiononchk(section_id){
                  $.ajax({
                    url: '<?=base_url()?>index.php/manage/rechecksalearea',
                    type: 'POST',
                    data:{salearea_id:'',section_id:section_id},
                    success: function(data){
                        $('#salearea_id').html(data);
                        $('#salearea_id').val($('#salearea_id option:first-child').val()).trigger('change');
                        var salearea_id = $('#salearea_id').val();
                    }
                  }); 
            }
            function positiononchk(posi_id){
                var com_id = $('#com_id_search').val(); 
                                $.ajax({
                                  url: '<?=base_url()?>index.php/manage/rechecklevel',
                                  type: 'POST',
                                  data:{com_id:com_id,posi_id:posi_id},
                                  success: function(data){
                                      $('#emp_level').html(data);
                                      $('#emp_level').val($('#emp_level option:first-child').val()).trigger('change');
                                  }
                                }); 
            }

           $('#add_button').click(function(){
                $('.modal-title').text('<?php echo label("create_user"); ?>');
                var com_id = $('#com_id_search').val(); 
                $("#modal-default").modal({backdrop: false});
                $('#user_form')[0].reset();
                $('#operation').val("Add");
                $('#com_id').val(com_id);
                $('.dropify').dropify();  
                $('#dep_id').empty();
                $('#ug_id').empty();
                $('#posi_id').empty();
                  $('.dropify').dropify({
                       defaultFile: "",
                  });

                                      $("#user_form").steps("setStep", 0);
                  clear_dropify('#img_profile');
                  //clear_dropify('#bgpic_user');
                  document.getElementById("useri").readOnly = false; 

                          $.ajax({
                            url: '<?=base_url()?>index.php/manage/recheckhead',
                            type: 'POST',
                            data:{com_id:com_id},
                            success: function(data){
                                $('#emp_parent_id').html(data);
                                $('#emp_parent_id').val($('#emp_parent_id option:first-child').val()).trigger('change');
                            }
                          }); 

                          $.ajax({
                            url: '<?=base_url()?>index.php/manage/recheckstore',
                            type: 'POST',
                            data:{com_id:com_id},
                            success: function(data){
                                $('#st_id').html(data);
                                $('#st_id').val($('#st_id option:first-child').val()).trigger('change');
                            }
                          }); 

                          $.ajax({
                            url: '<?=base_url()?>index.php/manage/recheckposition',
                            type: 'POST',
                            data:{com_id:com_id},
                            success: function(data){
                                $('#posi_id').html(data);
                                $('#posi_id').val($('#posi_id option:first-child').val()).trigger('change');
                                var posi_id = $('#posi_id option:first-child').val();
                                $.ajax({
                                  url: '<?=base_url()?>index.php/manage/rechecklevel',
                                  type: 'POST',
                                  data:{com_id:com_id,posi_id:posi_id},
                                  success: function(data){
                                      $('#emp_level').html(data);
                                      $('#emp_level').val($('#emp_level option:first-child').val()).trigger('change');
                                  }
                                }); 
                            }
                          }); 
                    
                          $.ajax({
                            url: '<?=base_url()?>index.php/manage/recheckdivision',
                            type: 'POST',
                            data:{com_id:com_id,div_id:""},
                            success: function(data){
                                $('#div_id').html(data);
                                $('#div_id').val($('#div_id option:first-child').val()).trigger('change');
                                var div_id = $('#div_id').val();
                                $.ajax({
                                  url: '<?=base_url()?>index.php/manage/recheckgroup',
                                  type: 'POST',
                                  data:{group_id:'',div_id:div_id},
                                  success: function(data){
                                      $('#group_id').html(data);
                                      $('#group_id').val($('#group_id option:first-child').val()).trigger('change');
                                      var group_id = $('#group_id').val();
                                      $.ajax({
                                        url: '<?=base_url()?>index.php/manage/recheckdepartment',
                                        type: 'POST',
                                        data:{group_id:group_id,dep_id:''},
                                        success: function(data){
                                            $('#dep_id').html(data);
                                            $('#dep_id').val($('#dep_id option:first-child').val()).trigger('change');
                                            var dep_id = $('#dep_id').val();

                                            $.ajax({
                                              url: '<?=base_url()?>index.php/manage/rechecksection',
                                              type: 'POST',
                                              data:{section_id:'',dep_id:dep_id},
                                              success: function(data){
                                                  $('#section_id').html(data);
                                                  $('#section_id').val($('#section_id option:first-child').val()).trigger('change');
                                                  var section_id = $('#section_id').val();

                                                  $.ajax({
                                                    url: '<?=base_url()?>index.php/manage/rechecksalearea',
                                                    type: 'POST',
                                                    data:{salearea_id:'',section_id:section_id},
                                                    success: function(data){
                                                        $('#salearea_id').html(data);
                                                        $('#salearea_id').val($('#salearea_id option:first-child').val()).trigger('change');
                                                        var salearea_id = $('#salearea_id').val();
                                                    }
                                                  }); 
                                              }
                                            }); 
                                        }
                                      }); 
                                  }
                                }); 
                            }
                          });
                          $.ajax({
                            url: '<?=base_url()?>index.php/manage/recheckusergroup',
                            type: 'POST',
                            data:{com_id:com_id},
                            success: function(data){
                                $('#ug_id').html(data);
                                $('#ug_id').val($('#ug_id option:first-child').val()).trigger('change');
                            }
                          }); 

                      /*  to = $('#employ_date').datepicker({
                                  <?php if($lang=="thai"){ ?>
                                        language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                                        thaiyear: true,  
                                  <?php } ?>
                            format: 'dd/mm/yyyy',
                            autoclose: true
                        })*/

                        to = $('#inactivedate').datepicker({
                                  <?php if($lang=="thai"){ ?>
                                        language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                                        thaiyear: true,  
                                  <?php } ?>
                            format: 'dd/mm/yyyy',
                            autoclose: true
                        })
                        to = $('#u_firstdate').datepicker({
                                  <?php if($lang=="thai"){ ?>
                                        language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                                        thaiyear: true,  
                                  <?php } ?>
                            format: 'dd/mm/yyyy',
                            autoclose: true
                        })
                        var startDate = new Date();
                        $('#u_firstdate').datepicker('setStartDate',startDate);
            });
         $(document).on('click', '.delete', function(){
            var emp_id = $(this).attr("id");
            swal({
                title: '<?php echo label('wg_delete_msg'); ?>',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: '<?php echo label('wg_delete'); ?>',
                cancelButtonText: '<?php echo label('cancel'); ?>'
            }).then(function (isChk) {
              if(isChk.value){
                $.ajax({
                    url:"<?=base_url()?>index.php/manage/delete_user_data",
                    method:"POST",
                    data:{emp_id_delete:emp_id},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("com_msg_delete"); ?>!',
                            '',
                            'success'
                        ).then(function () {
                          var table = $('#myTable').DataTable();
                          var info = table.page.info();
                          var length = info.pages;
                          var page_current = info.page;
                          fetch_data(page_current);
                        })
                      }else if(data == "1"){
                         swal({
                            title: '<?php echo label("wg_msg_use"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label('m_ok'); ?>'
                        })
                      }else{
                         swal({
                            title: '<?php echo label('com_msg_error_save'); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label('m_ok'); ?>'
                        })
                      }
                    }
                });
              }
            })
          });


            $(document).on('click', '.update', function(){
              var u_id = $(this).attr("id");
              
                  clear_dropify('.dropify');
                  /*clear_dropify('.dropify_bg');*/

                        to = $('#employ_date').datepicker({
                                  <?php if($lang=="thai"){ ?>
                                        language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                                        thaiyear: true,  
                                  <?php } ?>
                            format: 'dd/mm/yyyy',
                            autoclose: true
                        })
                        
                        to = $('#inactivedate').datepicker({
                                  <?php if($lang=="thai"){ ?>
                                        language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                                        thaiyear: true,  
                                  <?php } ?>
                            format: 'dd/mm/yyyy',
                            autoclose: true
                        })
                        to = $('#u_firstdate').datepicker({
                                  <?php if($lang=="thai"){ ?>
                                        language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                                        thaiyear: true,  
                                  <?php } ?>
                            format: 'dd/mm/yyyy',
                            autoclose: true
                        })
              $.ajax({
                url:"<?=base_url()?>index.php/manage/update_user_data",
                method:"POST",
                data:{u_id_update:u_id},
                dataType:"json",
                success:function(data)
                {
                  $('#user_form')[0].reset();
                  $("#user_form").steps("setStep", 0);
                  $("#modal-default").modal({backdrop: false});
                  $('.modal-title').text('<?php echo label("edit_user"); ?>');
                  $('#operation').val("Edit");
                  $('#com_id').val(data.com_id);   

                  $.ajax({
                    url: '<?=base_url()?>index.php/manage/recheckusergroup',
                    type: 'POST',
                    data:{com_id:data.com_id,ug_id:data.ug_id},
                    success: function(dataug){
                      
                      $('#ug_id').html(dataug);
                      $('#ug_id').val(data.ug_id).trigger('change');
                    }
                  });  
                     
                  $('#emp_c').val(data.emp_c);  
                  $('#lang').val(data.lang);        
                  $('#fname_th').val(data.fname_th);     
                  $('#lname_th').val(data.lname_th);        
                  $('#fname_en').val(data.fname_en);     
                  $('#lname_en').val(data.lname_en);    /*
                  $('#address_th').val(data.address_th);     
                  $('#address_en').val(data.address_en);     */
                  document.getElementById("useri").readOnly = true;  
                  $('#useri').val(data.useri);    
                  $('#img_profile_ori').val(data.img_profile);     

                    $('#inactivedate_var').val(data.inactivedate_var);
                    $('#u_firstdate_var').val(data.u_firstdate_var);

                    if(data.inactivedate!=""){
                      $( "#inactivedate" ).datepicker( "setDate", data.inactivedate);
                    }else{
                        $('#inactivedate').val('');
                    }   
                    if(data.u_firstdate!=""){
                        $('#u_firstdate').datepicker('setStartDate', data.u_firstdate);
                        $( "#u_firstdate" ).datepicker( "setDate", data.u_firstdate);
                    }else{
                        $('#u_firstdate').val('');
                    }   


                          $.ajax({
                            url: '<?=base_url()?>index.php/manage/recheckhead',
                            type: 'POST',
                            data:{com_id:data.com_id,emp_id:data.emp_parent_id},
                            success: function(data_parent){
                                $('#emp_parent_id').html(data_parent);
                                $('#emp_parent_id').val(data.emp_parent_id).trigger('change');
                            }
                          }); 

                          $.ajax({
                            url: '<?=base_url()?>index.php/manage/recheckstore',
                            type: 'POST',
                            data:{com_id:data.com_id,st_id:data.st_id},
                            success: function(data_store){
                                $('#st_id').html(data_store);
                                $('#st_id').val(data.st_id).trigger('change');
                            }
                          }); 

                          $.ajax({
                            url: '<?=base_url()?>index.php/manage/recheckposition',
                            type: 'POST',
                            data:{com_id:data.com_id,posi_id:data.posi_id},
                            success: function(data_position){
                                $('#posi_id').html(data_position);
                                $('#posi_id').val(data.posi_id).trigger('change');
                            }
                          }); 
                                $.ajax({
                                  url: '<?=base_url()?>index.php/manage/rechecklevel',
                                  type: 'POST',
                                  data:{com_id:data.com_id,posi_id:data.posi_id,lv_id:data.lv_id},
                                  success: function(data_level){
                                      $('#emp_level').html(data_level);
                                      $('#emp_level').val(data.lv_id).trigger('change');
                                  }
                                }); 
                    
                          $.ajax({
                            url: '<?=base_url()?>index.php/manage/recheckdivision',
                            type: 'POST',
                            data:{com_id:data.com_id,div_id:data.div_id},
                            success: function(data_div){
                                $('#div_id').html(data_div);
                                $('#div_id').val(data.div_id).trigger('change');
                            }
                          });   
                                
                          $.ajax({
                            url: '<?=base_url()?>index.php/manage/recheckgroup',
                            type: 'POST',
                            data:{group_id:data.group_id,div_id:data.div_id},
                            success: function(data_group){
                                $('#group_id').html(data_group);
                                $('#group_id').val(data.group_id).trigger('change');
                            }
                          }); 
                          $.ajax({
                            url: '<?=base_url()?>index.php/manage/recheckdepartment',
                            type: 'POST',
                            data:{group_id:data.group_id,dep_id:data.dep_id},
                            success: function(data_dep){
                                $('#dep_id').html(data_dep);
                                $('#dep_id').val(data.dep_id).trigger('change');
                            }
                          }); 

                          $.ajax({
                            url: '<?=base_url()?>index.php/manage/rechecksection',
                            type: 'POST',
                            data:{section_id:data.section_id,dep_id:data.dep_id},
                            success: function(data_sections){
                                $('#section_id').html(data_sections);
                                $('#section_id').val(data.section_id).trigger('change');
                            }
                          }); 
                          $.ajax({
                            url: '<?=base_url()?>index.php/manage/rechecksalearea',
                            type: 'POST',
                            data:{salearea_id:data.salearea_id,section_id:data.section_id},
                            success: function(data_salearea){
                                $('#salearea_id').html(data_salearea);
                                $('#salearea_id').val(data.salearea_id).trigger('change');
                            }
                          }); 
                    $('#u_id').val(data.u_id);         
                    $('#emp_id').val(data.emp_id); 
                    $('#email').val(data.email);
                    $('#emp_manage_a').val(data.emp_manage_a);
                    $('#emp_manage_b').val(data.emp_manage_b);
                    $('#path_img').val(data.path_img);

                    if(data.emp_observer=="1"){
                        document.getElementById("emp_observer").checked = true;
                    }else{
                        document.getElementById("emp_observer").checked = false;
                    }
                    if(data.status=="1"){
                        document.getElementById("status").checked = true;
                    }else{
                        document.getElementById("status").checked = false;
                    }

                    if(data.img_profile!=""){
                        var nameImage = "<?php echo REAL_PATH;?>/uploads/profile/"+data.img_profile
                        var drEvent = $('#img_profile').dropify(
                        {
                          defaultFile: nameImage
                        });
                        drEvent = drEvent.data('dropify');
                        drEvent.resetPreview();
                        drEvent.clearElement();
                        drEvent.settings.defaultFile = nameImage;
                        drEvent.destroy();
                        drEvent.init();

                        var drEvent = $('.dropify').dropify({
                            defaultFile: "<?php echo REAL_PATH;?>/uploads/profile/"+data.img_profile ,
                        });

                        drEvent.on('dropify.beforeClear', function(event, element){
                                $('#img_profile_ori').val("");
                                return true; 
                        });
                    }else{
                        $('.dropify').dropify();
                    }

                }
              });
            });   
       
            runwizard();
            function runwizard(){
                var form = $(".validation-wizard").show();
                $(".validation-wizard").steps({
                    startIndex: 0,
                    headerTag: "h6"
                    , bodyTag: "section"
                    , transitionEffect: "fade"
                    , titleTemplate: '<span class="step">#index#</span> #title#'
                    , labels: {
                        finish: "<?php echo label('saveR'); ?>",
                        previous:"<?php echo label('m_previous'); ?>",
                        next:"<?php echo label('m_next'); ?>"
                    }
                    , onStepChanging: function (event, currentIndex, newIndex) {
                        return currentIndex > newIndex || !(3 === newIndex && Number($("#age-2").val()) < 18) && (currentIndex < newIndex && (form.find(".body:eq(" + newIndex + ") label.error").remove(), form.find(".body:eq(" + newIndex + ") .error").removeClass("error")), form.validate().settings.ignore = ":disabled,:hidden", form.valid())
                    }
                    , onFinishing: function (event, currentIndex) {
                        return form.validate().settings.ignore = ":disabled", form.valid()
                    }
                    , onFinished: function (event, currentIndex) {
                       // var formdata = $('#user_form').serializeArray();
                        var formData = new FormData(document.querySelector('#user_form'));

                        var varchk=1;
                        var path_img = $('#img_profile').val();
                        var fileExtension = ['jpg','png','gif'];
                        if(path_img!=""){
                            if($.inArray($('#img_profile').val().split('.').pop().toLowerCase(), fileExtension) == -1){
                                  varchk = 3;
                                  swal({
                                      title: '<?php echo label("media_type_dontmatch"); ?>',
                                      text: "",
                                      type: 'warning',
                                      showCancelButton: false,
                                      confirmButtonClass: 'btn btn-primary',
                                      confirmButtonText: '<?php echo label("m_ok"); ?>'
                                  })
                            }
                        }
                        if(varchk==1){
                            $.ajax({
                                url:"<?=base_url()?>index.php/manage/insert_user",
                                method:'POST',
                                data:formData,
                                contentType:false,
                                processData:false,
                                success:function(data)
                                {
                                  
                                    if(data=="2"){
                                        $('#user_form')[0].reset();
                                        $('#modal-default').modal('hide');
                                        swal(
                                              '<?php echo label("com_msg_success"); ?>!',
                                              '',
                                              'success'
                                        ).then(function () {
                                              var table = $('#myTable').DataTable();
                                              var info = table.page.info();
                                              var length = info.pages;
                                              var page_current = info.page;
                                              fetch_data(page_current);
                                              $("#user_form").steps("setStep", 0);
                                        })
                                    }else if(data=="1"){
                                        swal({
                                              title: '<?php echo label("sv_p_duplicate"); ?>',
                                              text: "",
                                              type: 'warning',
                                              showCancelButton: false,
                                              confirmButtonClass: 'btn btn-primary',
                                              confirmButtonText: '<?php echo label("m_ok"); ?>'
                                        })
                                    }else if(data=="9"){
                                        swal({
                                            title: '<?php echo label("email_domain_not_match"); ?>',
                                            text: "",
                                            type: 'warning',
                                            showCancelButton: false,
                                            confirmButtonClass: 'btn btn-primary',
                                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                                        })
                                    }else{
                                        swal({
                                              title: '<?php echo label("sv_p_error_save"); ?>',
                                              text: "",
                                              type: 'warning',
                                              showCancelButton: false,
                                              confirmButtonClass: 'btn btn-primary',
                                              confirmButtonText: '<?php echo label("m_ok"); ?>'
                                        })
                                    }
                                 
                                }
                              });
                        }
                    }
                }), $(".validation-wizard").validate({
                    ignore: "input[type=hidden]"
                    , errorClass: "text-danger"
                    , successClass: "text-success"
                    , highlight: function (element, errorClass) {
                        $(element).removeClass(errorClass)
                    }
                    , unhighlight: function (element, errorClass) {
                        $(element).removeClass(errorClass)
                    }
                    , errorPlacement: function (error, element) {
                        error.insertAfter(element)
                    }
                    , rules: {
                        email: {
                            email: !0
                        }
                    }
                });
                $('.select2').select2();
            }
           $('#import_button').click(function(){
                $("#modal-import_user").modal({backdrop: false});
                clear_dropify('#file_import');
                var com_id = $('#com_id_search').val();
                $('#com_id_import_user').val(com_id);
                $('#result_import_user').html('');
           });
           $('#export_button').click(function(){
                var com_id = $('#com_id_search').val(); 
                window.open('<?=base_url()?>excel_export/export_user/'+com_id);
           });
    </script>
</body>

</html>