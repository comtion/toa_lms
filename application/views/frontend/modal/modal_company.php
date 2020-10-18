

    <div class="modal fade" id="modal-import_user" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h4>Import User</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <form method="post" id="import_user_form" autocomplete="off" name="import_user_form" enctype="multipart/form-data"  class="form-horizontal" role="form">
              <div class="modal-body row">
              		<div class="col-md-12">
	                    <label for="status_cr"><b style="color: #FF2D00">*</b><?php echo label('ug_name'); ?>:</label>
	                    <select class="form-control" required id="ug_id" name="ug_id"  style="width: 100%;">
	                    </select>
              		</div>
              		<div class="col-md-12">
	                    <label for="file_import"><b style="color: #FF2D00">*</b><?php echo 'Excel File'; ?>:</label>
                      	<input type="file" name="file_import" required id="file_import" class="dropify"  accept=".xls,.xlsx" />
                    	<?php echo label('certificate_example')." : "; ?><a href="<?php echo REAL_PATH;?>/uploads/format/format_import_user.xlsx" download>format_import_user.xlsx</a>
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

    <div class="modal fade bs-example-modal-lg" id="modal-default" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <form method="post" id="company_form" autocomplete="off" name="company_form" enctype="multipart/form-data"  class="form-horizontal" role="form">
              <div class="modal-body row">
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="com_code"><b style="color: #FF2D00">*</b><?php echo label('acronym_nickname'); ?>:</label>
                    <input type="text" id="com_code" name="com_code" maxlength="6" class="form-control" required> 
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="com_name_th"><b style="color: #FF2D00">*</b><?php echo label('com_name')." TH"; ?>:</label>
                    <input type="text" id="com_name_th" name="com_name_th" class="form-control" required> 
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="com_name_eng"><b style="color: #FF2D00">*</b><?php echo label('com_name')." EN"; ?>:</label>
                    <input type="text" id="com_name_eng" name="com_name_eng" class="form-control" required> 
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="status_cr"><b style="color: #FF2D00">*</b><?php echo label('com_admin'); ?>:</label>
                    <select class="form-control" id="com_admin" name="com_admin"  style="width: 100%;">
                      <option selected value="com_central"><?php echo label('com_central'); ?></option>
                      <option value="com_associated"><?php echo label('com_associated'); ?></option>
                    </select>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="com_emaildomain"><b style="color: #FF2D00">*</b><?php echo label('com_emaildomain'); ?>: </label>
                    <input type="text" id="com_emaildomain" name="com_emaildomain" onkeyup="return forceLower(this);" pattern="[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="(sample: imat.isuzu.co.th)" class="form-control" required> 
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="com_mail"><?php echo label('com_mail'); ?>:</label>
                    <input type="text" id="com_mail" name="com_mail" class="form-control" > 
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="com_tel"><?php echo label('com_tel'); ?>:</label>
                    <input type="text" id="com_tel" name="com_tel" class="form-control"> 
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="com_fax"><?php echo label('com_fax'); ?>:</label>
                    <input type="text" id="com_fax" name="com_fax" class="form-control"> 
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label><?php echo label('com_add')." TH"; ?>:</label>
                    <textarea class="form-control" rows="8" id="com_add_th" name="com_add_th"></textarea>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label><?php echo label('com_add')." EN"; ?>:</label>
                    <textarea class="form-control" rows="8" id="com_add_eng" name="com_add_eng"></textarea>
                  </div>
                </div>
                <div class="col-md-12">
                    <hr>
                    <h5>PDPA Content</h5>
                </div>
                <div class="form-group col-md-6">
                     <label class="control-label text-right"><?php echo label('sv_b_title'); ?> <?php echo label('acro_th'); ?>:</label>
                     <input name="com_wctitle_th" id="com_wctitle_th" class="form-control" type="text">

                     <label class="control-label text-right"><?php echo label('message'); ?> <?php echo label('acro_th'); ?>:</label>
                     <textarea name="com_wcmessage_th" id="com_wcmessage_th" class="form-control texteditor" style="width: 100%" rows="4"></textarea>
               </div>
               <div class="form-group col-md-6">
                     <label class="control-label text-right"><?php echo label('sv_b_title'); ?> <?php echo label('acro_en'); ?>:</label>
                     <input name="com_wctitle_eng" id="com_wctitle_eng" class="form-control" type="text">

                     <label class="control-label text-right"><?php echo label('message'); ?> <?php echo label('acro_en'); ?>:</label>
                     <textarea name="com_wcmessage_eng" id="com_wcmessage_eng" class="form-control texteditor" style="width: 100%" rows="4"></textarea>
               </div>
               <div class="form-group col-md-6">
               </div>
                <div class="col-md-12">
                    <hr>
                    <h5>Period</h5>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label><b style="color: #FF2D00">*</b><?php echo label('periodlog')." 1"; ?>:</label>
                    <div class="row">
                        <div class="col-md-6">
                          <select class="form-control" id="compe_montha_start" required name="compe_montha_start" onchange="onchange_period_a('1')">
                              <?php for($i=date('Y-01');$i<=date('Y-12');$i++){ ?>
                                <option value="<?php echo date('m',strtotime($i)); ?>"><?php echo $lang=="thai"?$thaimonth[intval(date('m',strtotime($i)))]:date('F',strtotime($i)); ?></option>
                              <?php } ?>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <select class="form-control" id="compe_montha_end" required name="compe_montha_end" onchange="onchange_period_a('2')">
                              <?php for($i=date('Y-01');$i<=date('Y-12');$i++){ ?>
                                <option value="<?php echo date('m',strtotime($i)); ?>"><?php echo $lang=="thai"?$thaimonth[intval(date('m',strtotime($i)))]:date('F',strtotime($i)); ?></option>
                              <?php } ?>
                          </select>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label><b style="color: #FF2D00">*</b><?php echo label('periodlog')." 2"; ?>:</label>
                    <div class="row">
                        <div class="col-md-6">
                          <select class="form-control" id="compe_monthb_start" required name="compe_monthb_start" onchange="onchange_period_b('1')">
                              <?php for($i=date('Y-01');$i<=date('Y-12');$i++){ ?>
                                <option value="<?php echo date('m',strtotime($i)); ?>"><?php echo $lang=="thai"?$thaimonth[intval(date('m',strtotime($i)))]:date('F',strtotime($i)); ?></option>
                              <?php } ?>
                          </select>
                        </div>
                        <div class="col-md-6">
                          <select class="form-control" id="compe_monthb_end" required name="compe_monthb_end" onchange="onchange_period_b('2')">
                              <?php for($i=date('Y-01');$i<=date('Y-12');$i++){ ?>
                                <option value="<?php echo date('m',strtotime($i)); ?>"><?php echo $lang=="thai"?$thaimonth[intval(date('m',strtotime($i)))]:date('F',strtotime($i)); ?></option>
                              <?php } ?>
                          </select>
                        </div>
                    </div>
                  </div>
                </div>
               <div class="col-md-12">
                     <hr>
               </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label><?php echo label('com_logo_top'); ?>:</label>
                    <input type="file" name="com_logo_top" id="com_logo_top" class="dropify_top"  accept="image/png, image/jpeg" />
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group">
                    <label><?php echo label('com_logo_footer'); ?>:</label>
                    <input type="file" name="com_logo_footer" id="com_logo_footer" class="dropify_footer"  accept="image/png, image/jpeg" />
                  </div>
                </div>
              </div>
              <input type="hidden" id="operation" name="operation" value="Add">
              <input type="hidden" id="com_id" name="com_id">
              <input type="hidden" id="com_logo_top_ori" name="com_logo_top_ori">
              <input type="hidden" id="com_logo_footer_ori" name="com_logo_footer_ori">
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

    <div class="modal fade bs-example-modal-lg" id="modal-banner" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
      <div class="modal-dialog modal-lg">
          <div class="modal-content">
              <div class="modal-header">
                  <h4 id="myLargeModalLabel"><?php echo label('banner'); ?></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
              </div>
              <div class="modal-body row">
                <div class="form-group col-md-12 row">
                  <div class="form-group col-md-6">
                    <form method="post" id="banner_form" autocomplete="off" name="banner_form" enctype="multipart/form-data"  class="form-horizontal" role="form">
                      <label class="control-label text-right"><?php echo label('banner_file'); ?></label>
                      <input type="file" name="banner" id="banner" class="dropifymain" accept="image/png, image/jpeg, image/gif,video/mp4" />
                      <br><label class="control-label pull-right"><button type="submit" name="add_banner" id="add_banner" class="btn btn-info btn-sm add_banner" title="upload"><i class="mdi mdi-upload"></i>  <?php echo label('import_btn'); ?></button></label>
                      <input type="hidden" id="com_id_banner" name="com_id_banner">
                    </form>
                  </div>
                  <div class="form-group col-md-6">
                      <div class="table-responsive">
                        <table id="myTable_banner" width="100%" class="table table-bordered table-striped">
                          <thead>
                            <tr>
                              <?php if($btn_delete=="1"){ ?>
                              <th width="5%" align="center"><?php echo label('sv_b_manage'); ?></th>
                              <?php } ?>
                              <th width="10%"></th>
                              <th width="45%" align="center"><?php echo label('image_banner'); ?></th>
                              <th width="40%" align="center"><?php echo label('file_name'); ?></th>
                            </tr>
                          </thead>
                        </table>
                      </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-outline-danger btn-flat" data-dismiss="modal"><i class="mdi mdi-window-close"></i> <?php echo label('close'); ?></button>
              </div>
          </div>
          <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->