    <div class="modal fade bs-example-modal-lg" id="modal-default" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                    <button type="button" class="close btn_close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form  enctype="multipart/form-data" id="course_form" name="course_form" autocomplete="off" method="POST" accept-charset="utf-8" class="form-horizontal p-t-20">
                    <div class="modal-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-file-document"></i></span> <span class="hidden-xs-down"><?php echo label('ceGen'); ?></span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-certificate"></i></span> <span class="hidden-xs-down"><?php echo label('certificate'); ?></span></a> </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active div_home" id="home" role="tabpanel">
                                <div class="p-20 card">

                                    <div class="card-body row">
                                      <?php if($com_admin=="com_central"&&($user['ug_id']=="1")){ ?>
                                        <div class="form-group col-md-6">
                                            <label for="com_id"><b style="color: #FF2D00">*</b><?php echo label('com_name'); ?>:</label>
                                            <select class="form-control select2" required id="com_id" name="com_id" onchange="changecompany_tycos(this.value)" style="width: 100%;">
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                      <?php }else{ ?>
                                        <input type="hidden" id="com_id" name="com_id" value="<?php echo $com_id; ?>">
                                      <?php } ?>
                                        <div class="form-group col-md-6">
                                            <label class="control-label"><b style="color: #FF2D00">*</b><?php echo label('cosCode'); ?>:</label>
                                            <input name="ccode" type="text" required class="form-control" id="ccode"><br><br>
                                            <label for="cg_id"><b style="color: #FF2D00">*</b><?php echo label('cgtitle'); ?>:</label>
                                            <select class="form-control select2" required id="cg_id" name="cg_id[]" multiple  style="width: 100%;">
                                            </select><br><br>
                                            <label for="tc_id"><b style="color: #FF2D00">*</b><?php echo label('ceCtype'); ?>:</label>
                                            <select class="form-control" required id="tc_id" name="tc_id"  style="width: 100%;">
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label><b style="color: #FF2D00">*</b><?php echo label('ceCforlang'); ?>:</label><br>
                                            <input type="checkbox" id="cos_lang_th" name="cos_lang[]" class="filled-in chk-col-red" onclick="chkbox_lang('cos_lang_th','input_th','cname_')" value="th" <?php if($lang=="thai"){ echo "checked";} ?>/>
                                            <label for="cos_lang_th"><i class="flag-icon flag-icon-th"></i> <?php echo label('thailand'); ?></label><br>
                                            <input type="checkbox" id="cos_lang_eng" name="cos_lang[]" class="filled-in chk-col-red" onclick="chkbox_lang('cos_lang_eng','input_eng','cname_')" value="eng" <?php if($lang=="english"){ echo "checked";} ?>/>
                                            <label for="cos_lang_eng"><i class="flag-icon flag-icon-us"></i> <?php echo label('english'); ?></label>
                                            <hr>

                                            <label for="cos_iscutgrade"><?php echo label('cos_iscutgrade'); ?>:</label>
                                            <div class="switch">
                                                <label><?php echo label('no'); ?><input type="checkbox"  id="cos_iscutgrade" name="cos_iscutgrade" value="1"><span class="lever switch-col-indigo"></span><?php echo label('yes'); ?></label>
                                            </div><br>

                                            <label for="cos_ispassquizendcos"><?php echo label('cos_ispassquizendcos'); ?>:</label>
                                            <div class="switch">
                                                <label><?php echo label('no'); ?><input type="checkbox"  id="cos_ispassquizendcos" name="cos_ispassquizendcos" value="1"><span class="lever switch-col-indigo"></span><?php echo label('yes'); ?></label>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>

                                        <div class="col-md-12 input_th" style="display:none;">
                                            <div class="ribbon-wrapper card">
                                                <div class="ribbon ribbon-danger"><i class="flag-icon flag-icon-th"></i> <?php echo label('thailand'); ?></div>
                                                <div class="ribbon-content row">
                                                  <div class="form-group col-md-6">
                                                      <label class="control-label"><b style="color: #FF2D00">*</b><?php echo label('ceCname'); ?>:</label>
                                                      <input name="cname_th" type="text" class="form-control" id="cname_th">
                                                  </div>
                                                  <div class="form-group col-md-6">
                                                      <input type="hidden" id="sub_description_th" name="sub_description_th">
                                                      <!-- <label class="control-label"><?php echo label('sub_description')." (".label('maximum_char').")"; ?>:</label>
                                                      <input name="sub_description_th" maxlength="75" type="text" class="form-control" id="sub_description_th"> -->
                                                  </div>
                                                  <div class="form-group col-md-12">
                                                      <label class="control-label"><?php echo label('ceDsc'); ?>:</label>
                                                      <textarea name="cdesc_th" class="form-control" id="cdesc_th" rows="5"></textarea>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 input_eng" style="display:none;">
                                            <div class="ribbon-wrapper card">
                                                <div class="ribbon ribbon-danger"><i class="flag-icon flag-icon-us"></i> <?php echo label('english'); ?></div>
                                                <div class="ribbon-content row">
                                                  <div class="form-group col-md-6">
                                                      <label class="control-label"><b style="color: #FF2D00">*</b><?php echo label('ceCname'); ?>:</label>
                                                      <input name="cname_eng" type="text" class="form-control" id="cname_eng">
                                                  </div>
                                                  <div class="form-group col-md-6">
                                                      <input type="hidden" id="sub_description_eng" name="sub_description_eng">
                                                      <!-- <label class="control-label"><?php echo label('sub_description')." (".label('maximum_char').")"; ?>:</label>
                                                      <input name="sub_description_eng" maxlength="75" type="text" class="form-control" id="sub_description_eng"> -->
                                                  </div>
                                                  <div class="form-group col-md-12">
                                                      <label class="control-label"><?php echo label('ceDsc'); ?>:</label>
                                                      <textarea name="cdesc_eng" class="form-control" id="cdesc_eng" rows="5"></textarea>
                                                  </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label class="control-label"><?php echo label('ceCbef'); ?>:</label>
                                            <select class="form-control select2" multiple id="condition" name="condition[]"  style="width: 100%;">
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label"><?php echo label('ccond'); ?>:</label>
                                            <input name="goal_score"  type="text" min="0" onkeyup="$('#mina_b').val(this.value);"   step="1" class="form-control" id="goal_score" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>
                                        <div class="col-md-4">
                                          <div class="form-group">
                                            <label for="cos_status"><b style="color: #FF2D00">*</b><?php echo label('ceCvis'); ?>:</label>
                                            <div class="switch">
                                                <label><?php echo label('close'); ?><input type="checkbox"  id="cos_status" checked name="cos_status" value="1"><span class="lever switch-col-indigo"></span><?php echo label('open'); ?></label>
                                            </div>
                                          </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label"><b style="color: #FF2D00">*</b><?php echo label('typegrading'); ?>:</label>
                                            <select id="cos_typegrading" name="cos_typegrading" onchange="cos_typegrading_onchange(this.value)" class="form-control">
                                              <option value="2" selected><?php echo label('typegrading_b'); ?></option>
                                              <option value="1" ><?php echo label('typegrading_a'); ?></option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label"><?php echo label('numSeat'); ?>:</label>
                                            <input name="seat_count"  type="text" min="0"  step="1" class="form-control" id="seat_count" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label"><?php echo label('cos_hour'); ?>:</label>
                                            <input name="cos_hour" type="text" min="0" step="1" class="form-control" id="cos_hour" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>
                                        <div class="form-group col-md-12" id="div_cospicupload">
                                            <label class="control-label"><?php echo label('ceCpic'); ?> (.jpg,.png,.gif):</label>
                                            <input type="file" name="cos_pic" id="cos_pic" class="dropify_main" accept="image/png, image/jpeg, image/gif" />
                                            <input type="hidden" id="cos_pic_ori" name="cos_pic_ori">
                                        </div>
                                        <div class="form-group col-md-12" id="div_cospicview" style="display: none;">
                                            <label class="control-label"><?php echo label('ceCpic'); ?></label><br>
                                            <center><img src="" id="view_img_cos" style="width: 60%" alt=""></center>
                                        </div>
                                        <div class="form-group col-md-12"><hr></div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label"><?php echo label('noti_expire_cos'); ?>:</label>
                                            <input name="cos_expire_noti"  type="text" class="form-control" id="cos_expire_noti" oninput="this.value = this.value.replace(/[^0-9,]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane p-20 card div_certifi" id="profile" role="tabpanel">
                                <div class="card-body row">
                                        <div class="form-group col-md-6">
                                            <label class="control-label"><?php echo label('certName'); ?>:</label>
                                            <input name="badges_name" type="text" class="form-control" id="badges_name">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="status_cr"><?php echo label('condCert'); ?>:</label>
                                            <select class="form-control" id="badges_condition" name="badges_condition"  style="width: 100%;">
                                                <option value="A" selected>A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label"><?php echo label('customCert'); ?>:</label>
                                            <textarea class="form-control" name="badges_desc" id="badges_desc" rows="8" style="width: 100%"></textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label"><?php echo label('certpic'); ?>:</label>
                                            <input type="file" name="badges_img" id="badges_img" class="dropify" accept="image/png, image/jpeg, image/gif" />
                                            <input type="hidden" id="badges_img_ori" name="badges_img_ori">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <hr>
                                            <h5 align="left"><?php echo label('grading'); ?></h5>
                                            <hr>
                                        </div>
                                        <div class="form-group col-md-6 typegrading_a">
                                            <label class="control-label"><?php echo label('cusGrade')." A+ (%)"; ?>:</label>
                                            <input required name="mina_plus" type="text" class="form-control" min="0" step="1" max="100" id="mina_plus" value="85" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>
                                        <div class="form-group col-md-6 typegrading_a">
                                            <label class="control-label"><?php echo label('cusGrade')." A (%)"; ?>:</label>
                                            <input required name="mina" type="text" class="form-control" min="0" step="1" max="100" id="mina" value="80" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>
                                        <div class="form-group col-md-6 typegrading_a">
                                            <label class="control-label"><?php echo label('cusGrade')." B+ (%)"; ?>:</label>
                                            <input required name="minb_plus" type="text" class="form-control" min="0" step="1" max="100" id="minb_plus" value="75" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>
                                        <div class="form-group col-md-6 typegrading_a">
                                            <label class="control-label"><?php echo label('cusGrade')." B (%)"; ?>:</label>
                                            <input required name="minb" type="text" class="form-control" min="0" step="1" max="100" id="minb" value="70" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>
                                        <div class="form-group col-md-6 typegrading_a">
                                            <label class="control-label"><?php echo label('cusGrade')." C+ (%)"; ?>:</label>
                                            <input required name="minc_plus" type="text" class="form-control" min="0" step="1" max="100" id="minc_plus" value="65" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>
                                        <div class="form-group col-md-6 typegrading_a">
                                            <label class="control-label"><?php echo label('cusGrade')." C (%)"; ?>:</label>
                                            <input required name="minc" type="text" class="form-control" min="0" step="1" max="100" id="minc" value="60" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>
                                        <div class="form-group col-md-6 typegrading_a">
                                            <label class="control-label"><?php echo label('cusGrade')." D+ (%)"; ?>:</label>
                                            <input required name="mind_plus" type="text" class="form-control" min="0" step="1" max="100" id="mind_plus" value="55" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>
                                        <div class="form-group col-md-6 typegrading_a">
                                            <label class="control-label"><?php echo label('cusGrade')." D (%)"; ?>:</label>
                                            <input required name="mind" type="text" class="form-control" min="0" step="1" max="100" id="mind" value="50" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>

                                        <div class="form-group col-md-6 typegrading_b" style="display: none;">
                                            <label class="control-label"><?php echo label('ccond'); ?>:</label>
                                            <input required name="mina_b" type="text" class="form-control" min="0" step="1" max="100" id="mina_b" value="50" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');">
                                        </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <input type="hidden" id="operation" name="operation" value="Add">
                    <input type="hidden" id="cos_id" name="cos_id">
                    <div class="modal-footer">
                        <?php if($btn_delete=="1"){ ?>
                            <button type="button" class="btn btn-outline-danger btn-flat btn_delete_cos pull-left" title="<?php echo label('delete'); ?>"><i class="mdi mdi-delete"></i> <?php echo label('delete'); ?></button>
                        <?php } ?>
                        <button type="submit" class="btn btn-outline-success btn-flat pull-left btn_close btn_maincourse" name="action_maincos" id="action_maincos"><i class="mdi mdi-content-save"></i> <?php echo label('saveR'); ?></button>
                        <button type="button" class="btn btn-outline-danger btn-flat btn_close" data-dismiss="modal"><i class="mdi mdi-window-close"></i> <?php echo label('m_cancel'); ?></button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->