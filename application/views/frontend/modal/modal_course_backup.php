
    <div class="modal fade bs-example-modal-lg" tabindex="-1" id="modal-default" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myLargeModalLabel">Large modal</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <form  enctype="multipart/form-data" id="course_form" name="course_form" autocomplete="off" method="POST" accept-charset="utf-8" class="form-horizontal p-t-20">
                    <div class="modal-body">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-file-document"></i></span> <span class="hidden-xs-down"><?php echo label('ceGen'); ?></span></a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-certificate"></i></span> <span class="hidden-xs-down"><?php echo label('certificate'); ?></span></a> </li>
                            <li class="nav-item" id="nav-item_document"> <a class="nav-link" data-toggle="tab" href="#document" role="tab"><span class="hidden-sm-up"><i class="mdi mdi-file-document"></i></span> <span class="hidden-xs-down"><?php echo label('lesson_file'); ?></span></a> </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane active" id="home" role="tabpanel">
                                <div class="p-20 card">

                                    <div class="card-body row">
                                      <?php if($com_admin=="OWNER"){ ?>
                                        <div class="form-group col-md-6">
                                            <label for="status_cr"><b style="color: #FF2D00">*</b><?php echo label('com_name'); ?>:</label>
                                            <select class="form-control" required id="com_id" name="com_id"  style="width: 100%;">
                                                <option value=""><?php echo label('please_com_name'); ?></option>
                                                <?php foreach( $company_select as $company ){ ?>
                                                <option value="<?php echo $company['com_id']; ?>"><?php if($lang=="thai"){ echo $company['com_name_th']; }else{ echo $company['com_name_en']; } ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                        </div>
                                      <?php }else{ ?>
                                        <input type="hidden" id="com_id" name="com_id" value="<?php echo $com_id; ?>">
                                      <?php } ?>
                                        <div class="form-group col-md-6">
                                            <label for="status_cr"><b style="color: #FF2D00">*</b><?php echo label('wtitle'); ?>:</label>
                                            <select class="form-control" required id="wg_id" name="wg_id"  style="width: 100%;">
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="status_cr"><b style="color: #FF2D00">*</b><?php echo label('cgtitle'); ?>:</label>
                                            <select class="form-control select2" required id="cg_id" name="cg_id[]" multiple  style="width: 100%;">
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label for="tc_id"><b style="color: #FF2D00">*</b><?php echo label('ceCtype'); ?>:</label>
                                            <select class="form-control" required id="tc_id" name="tc_id"  style="width: 100%;">
                                            </select>
                                        </div>
                                        <div class="form-group col-md-6">
                                        </div>
                                        <div class="col-md-12">
                                            <hr>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('cosCode'); ?></label>
                                            <input required name="ccode" type="text" class="form-control" id="ccode">
                                        </div>
                                        <div class="form-group col-md-6">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('ceCname')." TH"; ?></label>
                                            <input required name="cname_th" type="text" class="form-control" id="cname_th">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('ceCname')." EN"; ?></label>
                                            <input required name="cname_en" type="text" class="form-control" id="cname_en">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label text-right"><?php echo label('sub_description')." TH (".label('maximum_char').")"; ?></label>
                                            <input name="sub_description_th" maxlength="75" type="text" class="form-control" id="sub_description_th">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label text-right"><?php echo label('sub_description')." EN (".label('maximum_char').")"; ?></label>
                                            <input name="sub_description_en" maxlength="75" type="text" class="form-control" id="sub_description_en">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label text-right"><?php echo label('ceDsc')." TH"; ?></label>
                                            <textarea name="cdesc_th" id="cdesc_th" rows="10" cols="80"></textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label text-right"><?php echo label('ceDsc')." EN"; ?></label>
                                            <textarea name="cdesc_en" id="cdesc_en" rows="10" cols="80"></textarea>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label text-right"><?php echo label('ceCbef'); ?></label>
                                            <select class="form-control" id="condition" name="condition"  style="width: 100%;">
                                            </select>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('ceCvis'); ?></label>
                                            <div class="m-b-10">
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" id="radio1" name="status" checked value="1" class="custom-control-input">
                                                    <span class="custom-control-label"><?php echo label('sh_cos'); ?></span>
                                                </label>
                                                <label class="custom-control custom-radio">
                                                    <input type="radio" id="radio2" name="status" value="0" class="custom-control-input">
                                                    <span class="custom-control-label"><?php echo label('hi_cos'); ?></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-4">
                                            <div class="checkbox checkbox-success">
                                                <input type="checkbox" id="chk_cos_public" name="chk_cos_public" value="1">
                                                <label for="chk_cos_public"><?php echo label('cos_public'); ?></label>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('ccond'); ?></label>
                                            <input name="goal_score"  type="number" min="0"   step="0.01" pattern="[0123456789.]" class="form-control" id="goal_score">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('numSeat'); ?></label>
                                            <input name="seat_count"  type="number" min="0"   step="0.01" pattern="[0123456789.]" class="form-control" id="seat_count">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('ceCpic'); ?></label>
                                            <input type="file" name="image" id="input-file-now-custom-1" class="dropify_main" accept="image/png, image/jpeg, image/gif" />
                                            <input type="hidden" id="image_ori" name="image_ori">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label text-right"><b style="color: #FF2D00">*</b>ระยะเวลาที่ใช้ในการเรียน (นาที)</label>
                                            <input name="hour" type="number" min="0" step=".5" class="form-control" id="hour">
                                            <input type="hidden" id="image_ori" name="image_ori">
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane p-20 card" id="profile" role="tabpanel">
                                <div class="card-body row">
                                        <div class="form-group col-md-6">
                                            <label class="control-label text-right"><?php echo label('certName'); ?></label>
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
                                            <label class="control-label text-right"><?php echo label('customCert'); ?></label>
                                            <textarea class="form-control" name="badges_desc" id="badges_desc" rows="8" style="width: 100%"></textarea>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label text-right"><?php echo label('certpic'); ?></label>
                                            <input type="file" name="badges_img" id="input-file-now-custom-2" class="dropify" accept="image/png, image/jpeg, image/gif" />
                                            <input type="hidden" id="badges_img_ori" name="badges_img_ori">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <hr>
                                            <h5 align="left"><?php echo label('grading'); ?></h5>
                                            <hr>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label text-right"><?php echo label('cusGrade')."A"; ?></label>
                                            <input required name="mina" type="number" class="form-control" min="0" max="100" id="mina" value="80">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label text-right"><?php echo label('cusGrade')."B"; ?></label>
                                            <input required name="minb" type="number" class="form-control" min="0" max="100" id="minb" value="70">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label text-right"><?php echo label('cusGrade')."C"; ?></label>
                                            <input required name="minc" type="number" class="form-control" min="0" max="100" id="minc" value="60">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label text-right"><?php echo label('cusGrade')."D"; ?></label>
                                            <input required name="mind" type="number" class="form-control" min="0" max="100" id="mind" value="50">
                                        </div>
                                </div>
                            </div>


                            <div class="tab-pane p-20 card" id="document" role="tabpanel">
                                <div class="card-body row">

                                    <div class="col-md-12 row" align="">
                                        <?php if($btn_add=="1"){ ?>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label"><?php echo label('file_name')." TH"; ?></label>
                                                            <input name="name_fileth" type="text" class="form-control" id="name_fileth">
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label"><?php echo label('file_name')." EN"; ?></label>
                                                            <input name="name_fileen" type="text" class="form-control" id="name_fileen">
                                                        </div>
                                                        <div class="form-group col-md-12" id="cos_filedocument">
                                                        <h5 align="left"><?php echo label('Les_file'); ?></h5>
                                                        <input type="file" name="document_cos_file[]" id="input-file-now-custom-document_cos" multiple class="dropify" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.pdf" />
                                                        <input type="hidden" id="document_cos_file_original" name="document_cos_file_original">
                                                        <input type="hidden" id="fil_cos_id" name="fil_cos_id">
                                                        </div >
                                        <?php } ?>

                                                        <div class="col-md-12 table-responsive" id="tb_cos_document">
                                                          <table id="myTable_cos_document" width="100%" class="table table-bordered table-striped">
                                                            <thead>
                                                              <tr>
                                                                <th width="10%"></th>
                                                                <th width="70%" align="center"><?php echo label('file_name'); ?></th>
                                                                <th width="20%" align="center"><?php echo label('action'); ?></th>
                                                              </tr>
                                                            </thead>
                                                          </table>
                                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                            <div class="row col-md-12 progress" id="progress_div">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id="txt_progress"></span></div>
                            </div>
                    </div>
                    <input type="hidden" id="operation" name="operation" value="Add">
                    <input type="hidden" id="id" name="id">
                    <div class="modal-footer">
                        <input type="submit" name="action" id="action" class="btn btn-outline-success btn-flat pull-left" value="<?php echo label('saveR'); ?>" />
                        <button type="button" class="btn btn-outline-danger btn-flat" data-dismiss="modal"><?php echo label('m_cancel'); ?></button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    

    <div class="modal fade bs-example-modal-lg" tabindex="-1" id="modal-viewfiledocument" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="myLargeModalLabel">File Document</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body ">
                    <iframe id="iframe_view" width="100%" height="500"></iframe>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-flat" onclick="reset_model('modal-coursedetail','modal-viewfiledocument')" data-dismiss="modal"><?php echo label('m_cancel'); ?></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade bs-example-modal-lg" tabindex="-1" id="modal-viewfilevideo" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="myLargeModalLabel">File Video</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body ">
                    <video width="100%" id="video_player" controls>
                    </video>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger btn-flat" onclick="reset_model('modal-coursedetail','modal-viewfilevideo')" data-dismiss="modal"><?php echo label('m_cancel'); ?></button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    
    <div class="modal fade bs-example-modal-lg" tabindex="-1" id="modal-coursedetail" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="myLargeModalLabel"><?php echo label('ceDetailCourse'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button><!-- onclick="location.reload()"  -->
                </div>
                    <div class="modal-body ">
                        <input type="hidden" id="course_id" name="course_id">
                        <input type="hidden" id="com_id_detail" name="com_id_detail">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#period_and_permission" role="tab" title="<?php echo label('period_and_permission'); ?>" onclick="display_disable('div_create_pp','div_pp')"><span class="hidden-sm-up"><i class="mdi mdi-file-document"></i></span> <span class="hidden-xs-down"><?php echo label('period_and_permission'); ?></span></a> </li>
                            <li class="nav-item" id="li_lesson"> <a class="nav-link" data-toggle="tab" onclick="display_disable('div_create_lesson','div_lesson')" href="#lesson" role="tab" title="<?php echo label('lesson'); ?>"><span class="hidden-sm-up"><i class="mdi mdi-file-document"></i></span> <span class="hidden-xs-down"><?php echo label('lesson'); ?></span></a> </li>
                            <li class="nav-item" id="li_quiz"> <a class="nav-link" data-toggle="tab" onclick="display_disable('div_create_quiz','div_quiz')" href="#quiz" role="tab" title="<?php echo label('quiz'); ?>"><span class="hidden-sm-up"><i class="mdi mdi-file-document"></i></span> <span class="hidden-xs-down"><?php echo label('quiz'); ?></span></a> </li>
                            <li class="nav-item" id="li_survey"> <a class="nav-link" data-toggle="tab" onclick="display_disable('div_create_survey','div_survey')" href="#survey" role="tab" title="<?php echo label('survey'); ?>"><span class="hidden-sm-up"><i class="mdi mdi-file-document"></i></span> <span class="hidden-xs-down"><?php echo label('survey'); ?></span></a> </li>
                            <li class="nav-item" id="li_enroll"> <a class="nav-link" data-toggle="tab" onclick="display_disable('div_enroll_cancel','div_enroll_main')" href="#enroll" role="tab" title="<?php echo label('student').label('enroll'); ?>"><span class="hidden-sm-up"><i class="mdi mdi-file-document"></i></span> <span class="hidden-xs-down"><?php echo label('student').label('enroll'); ?></span></a> </li>
                            <li class="nav-item" id="li_videocourse"> <a class="nav-link" data-toggle="tab" href="#videocourse" onclick="display_disable('div_create_videocourse','div_videocourse')" role="tab" title="<?php echo label('video_course'); ?>"><span class="hidden-sm-up"><i class="fas fa-file-video"></i></span> <span class="hidden-xs-down"><?php echo label('video_course'); ?></span></a> </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content tabcontent-border">
                            <div class="tab-pane p-20 card" id="videocourse" role="tabpanel">
                                <div class="card-body row">
                                    <div class="col-md-12" align="right">
                                        <?php if($btn_add=="1"){ ?>
                                            <button name="add_videocourse" onclick="create_div('div_create_videocourse','div_videocourse','videocourse_form')" id="add_videocourse" class="btn btn-outline-info add_videocourse"><i class="mdi mdi-plus-box-outline"></i> <?php echo label('create').label('video_course'); ?></button>
                                        <?php } ?>
                                    </div>
                                    <div id="div_create_videocourse" style="display: none;">
                                        <form  enctype="multipart/form-data" id="videocourse_form" name="videocourse_form" autocomplete="off" method="POST" accept-charset="utf-8"  class="form-horizontal p-t-20 row">
                                            <input type="hidden" id="operation_cosv" name="operation_cosv" value="Add">
                                            <input type="hidden" id="course_id_cosv" name="course_id_cosv">
                                                    <div class="form-group col-md-12" style="margin: 0px auto 10px auto;">
                                                        <label for="status_cr"><?php echo label('sqtype')." Media"; ?>:</label>
                                                        <select class="form-control" id="type_media_cosv" name="type_media_cosv"  style="width: 100%;">
                                                            <option value="1"><?php echo "URL"; ?></option>
                                                            <option value="2"><?php echo "Upload File"; ?></option>
                                                        </select>
                                                        <div class="" id="div_multifile_url_videocourse" style="display: none;">
                                                            <textarea class="form-control" name="url_media_cosv" id="url_media_cosv" rows="5" style="width: 100%"></textarea>
                                                            <label class="control-label text-right"><?php echo label('les_url_msg'); ?></label>
                                                        </div>
                                                        <div class="" id="div_multifile_upload_file_videocourse" style="display: none;">
                                                            <div class="row">
                                                                <div class="form-group col-md-6">
                                                                    <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('file_name')." TH"; ?></label>
                                                                    <input name="cosv_th" type="text" class="form-control" id="cosv_th">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('file_name')." EN"; ?></label>
                                                                    <input name="cosv_en" type="text" class="form-control" id="cosv_en">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('thumbnail_med'); ?></label><input type="file" name="cosv_thumbnail" id="input-file-now-custom-cosv_thumbnail" class="dropify" accept="image/jpeg" />
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('media_file')." (".label('max_file').")"; ?></label>
                                                                    <input type="file" name="cosv_video" id="input-file-now-custom-cosv_video" class="dropify" accept="video/mp4" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <div class="col-md-12 progress" id="progress_videocourse_div">
                                                    <div class="progress-barvideocourse bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id="txt_progressvideocourse"></span></div>
                                                </div>
                                                <div class="form-group col-md-2" align="center">
                                                    <br>
                                                    <input type="submit" name="action" id="action" class="btn btn-outline-success btn-block pull-left" value="<?php echo label('saveR'); ?>" />
                                                </div>
                                                <div class="form-group col-md-2" align="center">
                                                    <br>
                                                    <button type="reset" class="btn btn-outline-danger btn-block" onclick="display_style('div_create_videocourse','div_videocourse')"><?php echo label('m_cancel'); ?></button>
                                                </div>
                                        </form>
                                    </div>
                                    <div id="div_videocourse" class="col-md-12">
                                        <div class="table-responsive">
                                          <table id="myTable_videocourse" width="100%" class="table table-bordered table-striped">
                                            <thead>
                                              <tr>
                                                    <th width="10%"></th>
                                                    <th width="30%" align="center"><?php echo label('file_name'); ?></th>
                                                    <th width="40%" align="center"><?php echo label('menu_path'); ?></th>
                                                    <th width="20%" align="center"><?php echo label('action'); ?></th>
                                              </tr>
                                            </thead>
                                          </table>
                                      </div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane p-20 card active" id="period_and_permission" role="tabpanel">
                                <div class="card-body row">
                                    <div class="col-md-12" align="right">
                                        <?php if($btn_add=="1"){ ?>
                                            <button name="add_period_and_permission" onclick="create_div('div_create_pp','div_pp','period_and_permission_form')" id="add_period_and_permission" class="btn btn-outline-info add_period_and_permission"><i class="mdi mdi-plus-box-outline"></i> <?php echo label('create').label('period_and_permission'); ?></button>
                                        <?php } ?>
                                    </div>
                                    <div id="div_create_pp" style="display: none;">
                                        <form  enctype="multipart/form-data" id="period_and_permission_form" name="period_and_permission_form" autocomplete="off" method="POST" accept-charset="utf-8"  class="form-horizontal p-t-20">
                                        <input type="hidden" id="cosde_id" name="cosde_id">
                                        <input type="hidden" id="operation_pp" name="operation_pp" value="Add">
                                        <input type="hidden" id="course_id_pp" name="course_id_pp">
                                        <div class="col-md-12 row" style="">
                                                <div class="form-group col-md-12">
                                                    <label class="control-label text-right"><?php echo label('period'); ?></label>
                                                    <div class='input-group mb-3'>
                                                        <input type='text' id="daterange_period" name="daterange_period" class="form-control timeseconds" />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <span class="ti-calendar"></span>
                                                            </span>
                                                                <span class="input-group-text hover_cleartxt" onclick="clear_txt('daterange_period','date_start_var','date_end_var')">
                                                                    <span class="mdi mdi-close-box"></span>
                                                                </span>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" id="date_start_var" name="date_start_var">
                                                    <input type="hidden" id="date_end_var" name="date_end_var">
                                                    <!--<div class="input-group">
                                                        <input type="text" class="form-control" required name="date_start" id="date_start" />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text bg-info b-0 text-white"><?php echo label('to'); ?></span>
                                                        </div>
                                                        <input type="text" class="form-control" required name="date_end" id="date_end" />
                                                    </div>-->
                                                </div>
                                                <div class="form-group col-md-12 row">
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><?php echo label('point_redeem'); ?></label>
                                                        <input name="point_redeem" type="number" min="0" max="100"   step="0.01" pattern="[0123456789.]" class="form-control" id="point_redeem">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><?php echo label('get_point'); ?></label>
                                                        <input name="get_point" type="number" min="0" max="100"   step="0.01" pattern="[0123456789.]" class="form-control" id="get_point">
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <hr>
                                                    <label class="control-label text-right"><?php echo label('permission'); ?></label>
                                                    <div id="permission_div">
                                                    </div>
                                                    <hr>
                                                </div>

                                                <div class="col-md-12 progress" id="progress_pp_div">
                                                    <div class="progress-barpp bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id="txt_progresspp"></span></div>
                                                </div>

                                                <div class="form-group col-md-2" align="center">
                                                    <input type="submit" name="action" id="action" class="btn btn-outline-success btn-block pull-left" value="<?php echo label('saveR'); ?>" />
                                                </div>
                                                <div class="form-group col-md-2" align="center">
                                                    <button type="reset" class="btn btn-outline-danger btn-block" onclick="display_style('div_create_pp','div_pp')"><?php echo label('m_cancel'); ?></button>
                                                </div>
                                        </div>
                                        </form>
                                    </div>
                                    <div id="div_pp" class="col-md-12">
                                        <div class="table-responsive">
                                          <table id="myTable_pp" width="100%" class="table table-bordered table-striped">
                                            <thead>
                                              <tr>
                                                <th width="10%"></th>
                                                <th width="40%" align="center"><?php echo label('r_start_on'); ?></th>
                                                <th width="40%" align="center"><?php echo label('r_finish_on'); ?></th>
                                                <th width="10%" align="center"><?php echo label('action'); ?></th>
                                              </tr>
                                            </thead>
                                          </table>
                                      </div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane p-20 card" id="lesson" role="tabpanel">
                                <div class="card-body row">
                                    <div class="col-md-12" align="right">
                                        <?php if($btn_update=="1"){ ?>
                                            <button name="edit_order_lesson" id="edit_order_lesson" class="btn btn-outline-primary edit_order_lesson"  onclick="create_div('div_order_lesson','div_lesson','lesson_order_form')"><i class="mdi mdi-lead-pencil"></i> <?php echo label('edit_lesson_sequences'); ?></button>
                                        <?php } ?>
                                        <?php if($btn_add=="1"){ ?>
                                            <button name="add_lesson" id="add_lesson" class="btn btn-outline-info add_lesson"  onclick="create_div('div_create_lesson','div_lesson','lesson_form')"><i class="mdi mdi-plus-box-outline"></i> <?php echo label('create').label('lesson'); ?></button>
                                        <?php } ?>
                                    </div>
                                    
                                    <div id="div_order_lesson" class="col-md-12" style="display: none;">
                                        <form  enctype="multipart/form-data" id="lesson_order_form" name="lesson_order_form" autocomplete="off" method="POST" accept-charset="utf-8"  class="form-horizontal p-t-20">
                                            <input type="hidden" id="les_id_order" name="les_id_order">
                                            <input type="hidden" id="operation_lesson_order" name="operation_lesson_order" value="Add">
                                        </form>
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="myadmin-dd dd" id="nestable">
                                                    <ol class="dd-list" id="load_li_lesson" style="width: 100%;font-size: 20px">
                                                    </ol>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="div_create_lesson" class="col-md-12" style="display: none;">
                                        <form  enctype="multipart/form-data" id="lesson_form" name="lesson_form" autocomplete="off" method="POST" accept-charset="utf-8"  class="form-horizontal p-t-20">
                                        <input type="hidden" id="les_id" name="les_id">
                                        <input type="hidden" id="operation_lesson" name="operation_lesson" value="Add">
                                        <input type="hidden" id="course_id_lesson" name="course_id_lesson">
                                            <div class="col-md-12 row" style="">
                                                <div class="form-group col-md-6">
                                                    <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('lName')." TH"; ?></label>
                                                    <input required name="les_name_th" type="text" class="form-control" id="les_name_th">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('lName')." EN"; ?></label>
                                                    <input required name="les_name_en" type="text" class="form-control" id="les_name_en">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="control-label text-right"><?php echo label('less_detail')." TH"; ?></label>
                                                    <textarea name="les_info_th" id="les_info_th" rows="10" cols="80"></textarea>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="control-label text-right"><?php echo label('less_detail')." EN"; ?></label>
                                                    <textarea name="les_info_en" id="les_info_en" rows="10" cols="80"></textarea>
                                                </div>
                                                <div class="form-group col-md-12">
                                                    <label class="control-label text-right"><?php echo label('period_les'); ?></label>
                                                    <div class='input-group mb-3'>
                                                        <input type='text' id="daterange_lesson" name="daterange_lesson" class="form-control timeseconds" />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text">
                                                                <span class="ti-calendar"></span>
                                                            </span>
                                                            <span class="input-group-text hover_cleartxt" onclick="clear_txt('daterange_lesson','time_start_var','time_end_var')">
                                                                <span class="mdi mdi-close-box"></span>
                                                            </span>
                                                        </div>
                                                        <input type="hidden" id="time_start_var" name="time_start_var">
                                                        <input type="hidden" id="time_end_var" name="time_end_var">
                                                    </div>
                                                    <!--<div class="input-daterange input-group" id="date-range_les">
                                                        <input type="text" class="form-control" name="time_start" id="time_start" />
                                                        <div class="input-group-append">
                                                            <span class="input-group-text bg-info b-0 text-white"><?php echo label('to'); ?></span>
                                                        </div>
                                                        <input type="text" class="form-control" name="time_end" id="time_end" />
                                                        <input type="hidden" id="time_start_var" name="time_start_var">
                                                        <input type="hidden" id="time_end_var" name="time_end_var">
                                                    </div>-->
                                                </div>

                                                <div class="form-group col-md-6">
                                                    <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('less_visible'); ?></label>
                                                    <div class="m-b-10">
                                                        <label class="custom-control custom-radio">
                                                            <input type="radio" id="radio_les1" name="status_les" checked value="1" class="custom-control-input">
                                                            <span class="custom-control-label"><?php echo label('show').label('lesson'); ?></span>
                                                        </label>
                                                        <label class="custom-control custom-radio">
                                                            <input type="radio" id="radio_les2" name="status_les" value="0" class="custom-control-input">
                                                            <span class="custom-control-label"><?php echo label('hide').label('lesson'); ?></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('qr_typefile'); ?></label>
                                                    <div class="m-b-10">
                                                        <label class="custom-control custom-radio">
                                                            <input type="radio" id="radio_les_type1" onclick="changeValEnableDivMedia('1')" name="les_type" checked value="1" class="custom-control-input">
                                                            <span class="custom-control-label"><?php echo "Media"; ?></span>
                                                        </label>
                                                        <label class="custom-control custom-radio">
                                                            <input type="radio" id="radio_les_type2" onclick="changeValEnableDivMedia('2')" name="les_type" value="2" class="custom-control-input">
                                                            <span class="custom-control-label"><?php echo "Scorm"; ?></span>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 row" id="div_media">
                                                    <div class="form-group col-md-6" style="margin: 0px auto 10px auto;">
                                                        <h5 align="left"><?php echo label('Les_video'); ?></h5>
                                                        <label for="status_cr"><?php echo label('sqtype')." Media"; ?>:</label>
                                                        <select class="form-control" id="type_media" name="type_media"  style="width: 100%;">
                                                            <option value="0" selected><?php echo label('none'); ?></option>
                                                            <option value="1"><?php echo "URL"; ?></option>
                                                            <option value="2"><?php echo "Upload File"; ?></option>
                                                        </select>
                                                        <div class="" id="div_multifile_url" style="display: none;">
                                                            <textarea class="form-control" name="url_media" id="url_media" rows="5" style="width: 100%"></textarea>
                                                            <label class="control-label text-right"><?php echo label('les_url_msg'); ?></label>
                                                        </div>
                                                        <div class="" id="div_multifile_upload_file" style="display: none;">
                                                            <div class="row">
                                                                <div class="form-group col-md-6">
                                                                    <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('file_name')." TH"; ?></label>
                                                                    <input name="med_th" type="text" class="form-control" id="med_th">
                                                                </div>
                                                                <div class="form-group col-md-6">
                                                                    <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('file_name')." EN"; ?></label>
                                                                    <input name="med_en" type="text" class="form-control" id="med_en">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="form-group col-md-12">
                                                                    <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('thumbnail_med'); ?></label><input type="file" name="thumbnail_med" id="input-file-now-custom-thumbnail_med" class="dropify" accept="image/jpeg" />
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('media_file')." (".label('max_file').")"; ?></label>
                                                                    <input type="file" name="media_file" id="input-file-now-custom-media" class="dropify" accept="video/mp4" />
                                                                </div>
                                                            </div>
                                                            <br>
                                                            <div class="table-responsive" id="tb_media" style="display: none;">
                                                              <table id="myTable_media" width="100%" class="table table-bordered table-striped">
                                                                <thead>
                                                                  <tr>
                                                                    <th width="10%"></th>
                                                                    <th width="30%" align="center"><?php echo label('file_name'); ?></th>
                                                                    <th width="40%" align="center"><?php echo label('menu_path'); ?></th>
                                                                    <th width="20%" align="center"><?php echo label('action'); ?></th>
                                                                  </tr>
                                                                </thead>
                                                              </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6" style="margin: 0px auto 10px auto;"></div>
                                                    <div class="form-group col-md-12" style="margin: 0px auto 10px auto;">
                                                        <h5 align="left"><?php echo label('Les_file'); ?>  <button name="add_file_lesson" id="add_file_lesson" onclick="return false;" class="btn btn-twitter waves-effect waves-light add_file_lesson"><i class="mdi mdi-plus-box-outline"></i></button></h5>

                                                        <!--<input type="file" name="document_file[]" id="input-file-now-custom-document" multiple class="dropify" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.pdf" />-->
                                                        <input type="hidden" id="count_file" name="count_file" value="0">
                                                        <br>
                                                        <div class="table-responsive" id="tb_document">
                                                          <table id="myTable_document" width="1000" class="table table-bordered table-striped">
                                                            <thead>
                                                              <tr>
                                                                <th width="100"></th>
                                                                <th width="300" class="text-center"><?php echo label('file_name')." TH"; ?></th>
                                                                <th width="300" class="text-center"><?php echo label('file_name')." EN"; ?></th>
                                                                <th width="300" class="text-center"><?php echo label('menu_path'); ?></th>
                                                              </tr>
                                                            </thead>
                                                            <tbody id="tb_document_body"></tbody>
                                                          </table>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 row" id="div_scorm">
                                                    <div class="form-group col-md-6">
                                                        <h5 align="left"><?php echo label('les_scorm'); ?></h5>
                                                        <input type="file" name="scorm_file" id="input-file-now-custom-scorm" class="dropify" accept="application/zip,application/x-zip,application/x-zip-compressed" />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('les_type_scorm'); ?></label>
                                                        <div class="m-b-10">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="radio_scm_type1" name="scm_type" checked value="0" class="custom-control-input">
                                                                <span class="custom-control-label"><?php echo label('lesson'); ?></span>
                                                            </label>
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="radio_scm_type2" name="scm_type" value="1" class="custom-control-input">
                                                                <span class="custom-control-label"><?php echo label('quiz'); ?></span>
                                                            </label>
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="radio_scm_type3" name="scm_type" value="2" class="custom-control-input">
                                                                <span class="custom-control-label"><?php echo label('lesson')." + ".label('quiz'); ?></span>
                                                            </label>
                                                        </div><hr>
                                                        <span id="txt_scormoriginal"></span>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 progress" id="progress_lesson_div">
                                                    <div class="progress-barlesson bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id="txt_progresslesson"></span></div>
                                                </div>
                                                <div class="form-group col-md-2" align="center">
                                                    <br>
                                                    <input type="submit" name="btn_add_lesson" id="btn_add_lesson" class="btn btn-outline-success btn-block pull-left " value="<?php echo label('saveR'); ?>" />
                                                </div>
                                                <div class="form-group col-md-2" align="center">
                                                    <br>
                                                    <button type="reset" class="btn btn-outline-danger btn-block" onclick="display_style('div_create_lesson','div_lesson')"><?php echo label('m_cancel'); ?></button>
                                                </div>

                                            </div>
                                        </form>
                                    </div>
                                    <div id="div_lesson" class="col-md-12">
                                        <div class="table-responsive">
                                          <table id="myTable_lesson" width="100%" class="table table-bordered table-striped">
                                            <thead>
                                              <tr>
                                                <th width="10%"></th>
                                                <th width="30%" align="center"><?php echo label('lName'); ?></th>
                                                <th width="25%" align="center"><?php echo label('dateStart'); ?></th>
                                                <th width="25%" align="center"><?php echo label('dateExpired'); ?></th>
                                                <th width="10%" align="center"><?php echo label('action'); ?></th>
                                              </tr>
                                            </thead>
                                          </table>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane p-20 card" id="quiz" role="tabpanel">
                                <div class="card-body">
                                    <div id="div_quiz_main" class="row">
                                        <div class="col-md-12" align="right">
                                            <?php if($btn_add=="1"){ ?>
                                                <button name="add_quiz" id="add_quiz" class="btn btn-outline-info add_quiz" onclick="create_div('div_create_quiz','div_quiz','quiz_form')"><i class="mdi mdi-plus-box-outline"></i> <?php echo label('create').label('quiz'); ?></button>
                                            <?php } ?>
                                        </div>
                                        <div id="div_create_quiz" style="display: none;">
                                            <form  enctype="multipart/form-data" id="quiz_form" name="quiz_form" autocomplete="off" method="POST" accept-charset="utf-8"  class="form-horizontal p-t-20">
                                                <input type="hidden" id="qiz_id" name="qiz_id">
                                                <input type="hidden" id="operation_quiz" name="operation_quiz" value="Add">
                                                <input type="hidden" id="course_id_quiz" name="course_id_quiz">
                                                <div class="col-md-12 row" style="">
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('specificName')." TH"; ?></label>
                                                        <input required name="quiz_name_th" type="text" class="form-control" id="quiz_name_th">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('specificName')." EN"; ?></label>
                                                        <input required name="quiz_name_en" type="text" class="form-control" id="quiz_name_en">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><?php echo label('summary')." TH"; ?></label>
                                                        <textarea name="quiz_info_th" id="quiz_info_th" rows="10" cols="80"></textarea>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><?php echo label('summary')." EN"; ?></label>
                                                        <textarea name="quiz_info_en" id="quiz_info_en" rows="10" cols="80"></textarea>
                                                    </div>
                                                    <div class="form-group col-md-12">
                                                        <label class="control-label text-right"><?php echo label('period_specific'); ?></label>
                                                        <div class='input-group mb-3'>
                                                            <input type='text' id="daterange_quiz" name="daterange_quiz" class="form-control timeseconds" />
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <span class="ti-calendar"></span>
                                                                </span>
                                                                <span class="input-group-text hover_cleartxt" onclick="clear_txt('daterange_quiz','period_open_var','period_end_var')">
                                                                    <span class="mdi mdi-close-box"></span>
                                                                </span>
                                                            </div>
                                                            <input type="hidden" id="period_open_var" name="period_open_var">
                                                            <input type="hidden" id="period_end_var" name="period_end_var">
                                                        </div>

                                                        <!-- <div class="input-daterange input-group" id="date-range_quiz">
                                                            <input type="text" class="form-control" name="period_open" id="period_open" />
                                                            <div class="input-group-append">
                                                                <span class="input-group-text bg-info b-0 text-white"><?php echo label('to'); ?></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="period_end" id="period_end" />
                                                            <input type="hidden" id="period_open_var" name="period_open_var">
                                                            <input type="hidden" id="period_end_var" name="period_end_var">
                                                        </div> -->
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('random'); ?></label>
                                                        <div class="m-b-10">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="radio_random1" name="quiz_random" checked value="1" class="custom-control-input">
                                                                <span class="custom-control-label"><?php echo label('enable').label('random'); ?></span>
                                                            </label>
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="radio_random2" name="quiz_random" value="0" class="custom-control-input">
                                                                <span class="custom-control-label"><?php echo label('disable').label('random'); ?></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('qiz_visible'); ?></label>
                                                        <div class="m-b-10">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="radio_show1" name="quiz_show" checked value="1" class="custom-control-input">
                                                                <span class="custom-control-label"><?php echo label('show').label('quiz'); ?></span>
                                                            </label>
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="radio_show2" name="quiz_show" value="0" class="custom-control-input">
                                                                <span class="custom-control-label"><?php echo label('hide').label('quiz'); ?></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-12">
                                                        <label for="example-search-input" class="row col-md-4 col-form-label"><?php echo label('quiz_numofshown'); ?><b class="text-danger">**</b></label>
                                                        <div class="row">
                                                        <div class="col-md-5">
                                                            <input type="number" min="0" style="width: 70%" onchange="onchk_numofshow(this.value)" step="1" pattern="[0123456789]" class="form-control" name="quiz_numofshown" id="quiz_numofshown"><span id="txt_totalquiz"></span>
                                                            <input type="hidden" id="totalquiz" name="totalquiz">
                                                        </div>
                                                        <div class="col-md-7 text-danger" style="font-size: 14px;"><br><?php echo label('quiz_numofshown_note'); ?></div>
                                                        </div>
                                                    </div>
                                                    <script type="text/javascript">
                                                        function onchk_numofshow(value=""){
                                                            var totalquiz = parseInt($('#totalquiz').val());
                                                            if(parseInt(value)>totalquiz){
                                                                $('#quiz_numofshown').val(totalquiz);
                                                            }
                                                        }
                                                    </script>
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('show').label('grade'); ?></label>
                                                        <div class="m-b-10">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="radio_grade1" name="quiz_grade" checked value="1" class="custom-control-input">
                                                                <span class="custom-control-label"><?php echo label('show').label('grade'); ?></span>
                                                            </label>
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="radio_grade2" name="quiz_grade" value="0" class="custom-control-input">
                                                                <span class="custom-control-label"><?php echo label('hide').label('grade'); ?></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('qiz_type'); ?></label>
                                                        <div class="m-b-10">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="radio_type1" name="quiz_type" onclick="display('1','div_answer')" checked value="1" class="custom-control-input">
                                                                <span class="custom-control-label"><?php echo label('preExam'); ?></span>
                                                            </label>
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="radio_type2" name="quiz_type" onclick="display('2','div_answer')" value="2" class="custom-control-input">
                                                                <span class="custom-control-label"><?php echo label('finalExam'); ?></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <div id="div_answer" style="display: none;">
                                                            <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('preAns'); ?></label>
                                                            <div class="m-b-10">
                                                                <label class="custom-control custom-radio">
                                                                    <input type="radio" id="radio_answer1" name="quiz_answer" value="1" class="custom-control-input">
                                                                    <span class="custom-control-label"><?php echo label('enable').label('preAns'); ?></span>
                                                                </label>
                                                                <label class="custom-control custom-radio">
                                                                    <input type="radio" id="radio_answer2" name="quiz_answer" checked value="0" class="custom-control-input">
                                                                    <span class="custom-control-label"><?php echo label('disable').label('preAns'); ?></span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                    </div>
                                                    <script type="text/javascript">
                                                        function Select_quiz_type(value="",value_limit="1",status_limit="0"){
                                                            if(value=="1"){
                                                                document.getElementById('radio_limit1').checked = true;
                                                                document.getElementById('radio_limit2').checked = false;
                                                                $('#quiz_limitval').val(value_limit);
                                                                document.getElementById("quiz_limitval").readOnly = true;
                                                                $(".radio_chklimit").attr('disabled', true);
                                                            }else{
                                                                //console.log('821::'+status_limit);
                                                                if(status_limit=="1"){
                                                                    document.getElementById('radio_limit1').checked = true;
                                                                    document.getElementById('radio_limit2').checked = false;
                                                                    document.getElementById("quiz_limitval").readOnly = false;
                                                                }else{
                                                                    document.getElementById('radio_limit1').checked = false;
                                                                    document.getElementById('radio_limit2').checked = true;
                                                                    document.getElementById("quiz_limitval").readOnly = true;
                                                                }
                                                                $('#quiz_limitval').val(value_limit);
                                                                $(".radio_chklimit").attr('disabled', false);
                                                            }
                                                        }
                                                    </script>
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('qiz_num'); ?></label>
                                                        <div class="m-b-10">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="radio_limit1" onclick="readonly('1','quiz_limitval')" name="quiz_limit" value="1" class="custom-control-input radio_chklimit">
                                                                <span class="custom-control-label"><?php echo label('yes'); ?></span>
                                                            </label>
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="radio_limit2" onclick="readonly('0','quiz_limitval')" name="quiz_limit" checked value="0" class="custom-control-input radio_chklimit">
                                                                <span class="custom-control-label"><?php echo label('no'); ?></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><?php echo label('number_of'); ?></label>
                                                        <input name="quiz_limitval"  type="number" min="0"   step="0.01" pattern="[0123456789.]" class="form-control" id="quiz_limitval" readonly>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('ccond')." (%)"; ?></label>
                                                        <input name="quiz_maxscore" required  type="number" min="0" max="100"   step="0.01" pattern="[0123456789.]" class="form-control" id="quiz_maxscore">
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <div id="div_template_qize">
                                                            <label><?php echo label('quiz_ex'); ?>:</label>
                                                            <select class="form-control" id="qize_id" name="qize_id"  style="width: 100%;">
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12 progress" id="progress_quiz_div">
                                                        <div class="progress-barquiz bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id="txt_progressquiz"></span></div>
                                                    </div>
                                                    <div class="form-group col-md-2" align="center">
                                                        <br>
                                                        <input type="submit" name="action" id="action" class="btn btn-outline-success btn-block pull-left" value="<?php echo label('saveR'); ?>" />
                                                    </div>
                                                    <div class="form-group col-md-2" align="center">
                                                        <br>
                                                        <button type="reset" class="btn btn-outline-danger btn-block" onclick="display_style('div_create_quiz','div_quiz')"><?php echo label('m_cancel'); ?></button>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>

                                        <div id="div_quiz" class="col-md-12">
                                            <div class="table-responsive">
                                              <table id="myTable_quiz" width="100%" class="table table-bordered table-striped">
                                                <thead>
                                                  <tr>
                                                    <th width="10%"></th>
                                                    <th width="50%" align="center"><?php echo label('specificName'); ?></th>
                                                    <th width="20%" align="center"><?php echo label('qiz_type'); ?></th>
                                                    <th width="10%" align="center"><?php echo label('maxScore'); ?></th>
                                                    <th width="10%" align="center"><?php echo label('action'); ?></th>
                                                  </tr>
                                                </thead>
                                              </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="div_question_check" style="display: none;">
                                        <div class="col-md-12" align="right">
                                            <button name="back_quiz_check" id="back_quiz_check" class="btn btn-outline-success back_quiz_check" onclick="display_style('div_question_check','div_quiz_detail')"><i class="mdi mdi-keyboard-return"></i> <?php echo label('m_previous'); ?></button>
                                        </div>
                                        <h4 id="quiz_name_txt_question"></h4>
                                        <hr>
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                              <table id="myTable_quiz_question_check" width="100%" class="table table-bordered table-striped">
                                                <thead>
                                                  <tr>
                                                    <th width="20%" align="center"><?php echo label('emp_id'); ?></th>
                                                    <th width="10%" align="center"><?php echo label('r_name'); ?></th>
                                                    <th width="15%" align="center"><?php echo label('answer'); ?></th>
                                                    <th width="25%" align="center"><?php echo label('msg_fromadmin'); ?></th>
                                                    <th width="30%" align="center"><?php echo label('score'); ?></th>
                                                  </tr>
                                                </thead>
                                              </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="div_quiz_detail" style="display: none;">
                                        <div class="col-md-12" align="right">
                                            <button name="back_quiz" id="back_quiz" class="btn btn-outline-success back_quiz" onclick="display_style('div_quiz_detail','div_quiz_main')"><i class="mdi mdi-keyboard-return"></i> <?php echo label('m_previous'); ?></button>
                                            <?php if($btn_add=="1"){ ?>
                                                <button name="add_question" id="add_question" class="btn btn-outline-info add_question" onclick="create_div('div_create_question','div_quiz_question','question_form')"><i class="mdi mdi-plus-box-outline"></i> <?php echo label('create').label('squestion'); ?></button>
                                                <button name="import_question" id="import_question" class="btn btn-outline-info import_question" onclick="create_div('div_import_question','div_quiz_question','question_import_form')"><i class="mdi mdi-plus-box-outline"></i> <?php echo label('import_data').label('squestion'); ?></button>
                                            <?php } ?>
                                        </div>
                                        <h4 id="quiz_name_txt"></h4>
                                        <hr>
                                        <div id="div_quiz_question" class="col-md-12">
                                            <div class="table-responsive">
                                              <table id="myTable_quiz_question" width="100%" class="table table-bordered table-striped">
                                                <thead>
                                                  <tr>
                                                    <th width="5%" align="center"></th>
                                                    <th width="15%" align="center"><?php echo label('quest_type'); ?></th>
                                                    <th width="40%" align="center"><?php echo label('squestion'); ?></th>
                                                    <th width="30%" align="center"><?php echo label('choice'); ?></th>
                                                    <th width="10%" align="center"><?php echo label('manage'); ?></th>
                                                  </tr>
                                                </thead>
                                              </table>
                                            </div>
                                        </div>

                                        <div id="div_import_question" style="display: none;">
                                            <form  enctype="multipart/form-data" id="question_import_form" name="question_import_form" autocomplete="off" method="POST" accept-charset="utf-8"  class="form-horizontal p-t-20">
                                                    <div class="row col-md-12">
                                                        <label for="file_import_question"><b style="color: #FF2D00">*</b><?php echo 'Excel File'; ?>:</label>
                                                        <input type="file" name="file_import_question" required id="file_import_question" class="dropify"  accept=".xls,.xlsx" />
                                                        <?php echo label('certificate_example')." : "; ?><a href="<?php echo REAL_PATH;?>/uploads/format/format_import_qiz.xlsx" download>format_import_question.xlsx</a>
                                                        <input type="hidden" id="operation_import_question" name="operation_import_question" value="Add">
                                                        <input type="hidden" id="qiz_id_question_import" name="qiz_id_question_import">
                                                    </div>

                                                    <div class="row col-md-12 progress" id="progress_import_question_div">
                                                        <div class="progress-bar_importquestion bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id="txt_progressimport_question"></span></div>
                                                    </div>
                                                    <div class="form-group row col-md-2" align="center">
                                                        <br>
                                                        <input type="submit" name="action" id="action" class="btn btn-outline-success btn-block pull-left" value="<?php echo label('import_data'); ?>" />
                                                    </div>
                                            </form>
                                        </div>
                                        <div id="div_create_question" style="display: none;" class="col-md-12">
                                            <form  enctype="multipart/form-data" id="question_form" name="question_form" autocomplete="off" method="POST" accept-charset="utf-8"  class="form-horizontal p-t-20">
                                                <input type="hidden" id="qiz_id_question" name="qiz_id_question">
                                                <input type="hidden" id="cos_id_question" name="cos_id_question">
                                                <input type="hidden" id="ques_id" name="ques_id">
                                                <input type="hidden" id="operation_question" name="operation_question" value="Add">
                                                <div class="col-md-12 row" style="">
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><?php echo label('squestion')." TH"; ?></label>
                                                        <textarea name="ques_name_th" id="ques_name_th" rows="10" cols="80"></textarea>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><?php echo label('squestion')." EN"; ?></label>
                                                        <textarea name="ques_name_en" id="ques_name_en" rows="10" cols="80"></textarea>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><?php echo label('summary')." TH"; ?></label>
                                                        <textarea name="ques_info_th" id="ques_info_th" rows="10" cols="80"></textarea>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><?php echo label('summary')." EN"; ?></label>
                                                        <textarea name="ques_info_en" id="ques_info_en" rows="10" cols="80"></textarea>
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><b style="color: #FF2D00">*</b><?php echo label('quest_visible'); ?></label>
                                                        <div class="m-b-10">
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="radio_ques_show1" name="ques_show" checked value="1" class="custom-control-input">
                                                                <span class="custom-control-label"><?php echo label('show').label('squestion'); ?></span>
                                                            </label>
                                                            <label class="custom-control custom-radio">
                                                                <input type="radio" id="radio_ques_show2" name="ques_show" value="0" class="custom-control-input">
                                                                <span class="custom-control-label"><?php echo label('hide').label('squestion'); ?></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label class="control-label text-right"><?php echo label('maxScore'); ?></label>
                                                        <input name="ques_score"  type="number" min="0"   step="0.01" pattern="[0123456789.]" class="form-control" id="ques_score">
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                        <label><?php echo label('quest_type'); ?>:</label>
                                                        <select class="form-control" required id="ques_type" name="ques_type"  style="width: 100%;">
                                                            <option value="0" selected><?php echo label('choose').label('quest_type') ?></option>
                                                            <option value="sa"><?php echo label('qt_sa'); ?></option>
                                                            <option value="sub"><?php echo label('qt_sub'); ?></option>
                                                            <option value="multi"><?php echo label('qt_multi'); ?></option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                    </div>

                                                    <div class="col-md-12 row" id="div_question_mul" style="display: none;">
                                                        <div class="form-group col-md-6 courseCat">
                                                            <h4><?php echo label('quest_detail'); ?></h4>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                            <label class="control-label text-right"><?php echo label('choice')." 1 TH"; ?></label>
                                                            <textarea name="mul_c1_th" id="mul_c1_th" rows="10" cols="80"></textarea>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label text-right"><?php echo label('choice')." 1 EN"; ?></label>
                                                            <textarea name="mul_c1_en" id="mul_c1_en" rows="10" cols="80"></textarea>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label text-right"><?php echo label('choice')." 2 TH"; ?></label>
                                                            <textarea name="mul_c2_th" id="mul_c2_th" rows="10" cols="80"></textarea>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label text-right"><?php echo label('choice')." 2 EN"; ?></label>
                                                            <textarea name="mul_c2_en" id="mul_c2_en" rows="10" cols="80"></textarea>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label text-right"><?php echo label('choice')." 3 TH"; ?></label>
                                                            <textarea name="mul_c3_th" id="mul_c3_th" rows="10" cols="80"></textarea>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label text-right"><?php echo label('choice')." 3 EN"; ?></label>
                                                            <textarea name="mul_c3_en" id="mul_c3_en" rows="10" cols="80"></textarea>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label text-right"><?php echo label('choice')." 4 TH"; ?></label>
                                                            <textarea name="mul_c4_th" id="mul_c4_th" rows="10" cols="80"></textarea>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label text-right"><?php echo label('choice')." 4 EN"; ?></label>
                                                            <textarea name="mul_c4_en" id="mul_c4_en" rows="10" cols="80"></textarea>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label text-right"><?php echo label('choice')." 5 TH"; ?></label>
                                                            <textarea name="mul_c5_th" id="mul_c5_th" rows="10" cols="80"></textarea>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                            <label class="control-label text-right"><?php echo label('choice')." 5 EN"; ?></label>
                                                            <textarea name="mul_c5_en" id="mul_c5_en" rows="10" cols="80"></textarea>
                                                        </div>

                                                        <div class="form-group col-md-6">
                                                                <label for="status_cr"><b style="color: #FF2D00">*</b><?php echo label('answer'); ?>:</label>
                                                                <select class="form-control select2" id="mul_answer" name="mul_answer[]" multiple  style="width: 100%;">
                                                                    <option value="mul_c1"><?php echo label('choice')." 1"; ?></option>
                                                                    <option value="mul_c2"><?php echo label('choice')." 2"; ?></option>
                                                                    <option value="mul_c3"><?php echo label('choice')." 3"; ?></option>
                                                                    <option value="mul_c4"><?php echo label('choice')." 4"; ?></option>
                                                                    <option value="mul_c5"><?php echo label('choice')." 5"; ?></option>
                                                                </select>
                                                        </div>
                                                        <div class="form-group col-md-6">
                                                        </div>
                                                    </div>


                                                    <div class="col-md-12 progress" id="progress_question_div">
                                                        <div class="progress-barquestion bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id="txt_progressquestion"></span></div>
                                                    </div>
                                                    <div class="form-group col-md-2" align="center">
                                                        <br>
                                                        <input type="submit" name="action" id="action" class="btn btn-outline-success btn-block pull-left" value="<?php echo label('saveR'); ?>" />
                                                    </div>
                                                    <div class="form-group col-md-2" align="center">
                                                        <br>
                                                        <button type="reset" class="btn btn-outline-danger btn-block" onclick="display_style('div_create_question','div_quiz_question')"><?php echo label('m_cancel'); ?></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane p-20 card" id="survey" role="tabpanel">
                                <div class="card-body">
                                    <div id="div_survey_main" class="row">
                                        <div class="col-md-12" align="right">
                                            <?php if($btn_add=="1"){ ?>
                                                <button name="add_survey" id="add_survey" class="btn btn-outline-info add_survey" onclick="create_div('div_create_survey','div_survey','survey_form')"><i class="mdi mdi-plus-box-outline"></i> <?php echo label('create').label('survey'); ?></button>
                                            <?php } ?>
                                        </div>

                                        <div id="div_survey" class="col-md-12">
                                            <div class="table-responsive">
                                              <table id="myTable_cos_id_survey" width="100%" class="table table-bordered table-striped">
                                                <thead>
                                                  <tr>
                                                    <th width="10%"></th>
                                                    <th width="40%" align="center"><?php echo label('sName'); ?></th>
                                                    <th width="20%" align="center"><?php echo label('r_start_on'); ?></th>
                                                    <th width="20%" align="center"><?php echo label('r_finish_on'); ?></th>
                                                    <th width="10%" align="center"><?php echo label('action'); ?></th>
                                                  </tr>
                                                </thead>
                                              </table>
                                            </div>
                                        </div>

                                        <div id="div_create_survey" style="display: none;">
                                            <form enctype="multipart/form-data" id="survey_form" name="survey_form" autocomplete="off" method="POST" accept-charset="utf-8" class="form-horizontal p-t-20">
                                                <input type="hidden" id="sv_id" name="sv_id">
                                                <input type="hidden" id="operation_survey" name="operation_survey" value="Add">
                                                <input type="hidden" id="course_id_survey" name="course_id_survey">
                                                <input type="hidden" id="com_id_survey" name="com_id_survey">
                                                <div class="col-md-12 row" style="">

                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                        <label for="sv_title_th"><b style="color: #FF2D00">*</b><?php echo label('sName')." TH"; ?>:</label>
                                                        <input type="text" id="sv_title_th" name="sv_title_th" class="form-control" required> 
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                        <label for="sv_title_en"><b style="color: #FF2D00">*</b><?php echo label('sName')." EN"; ?>:</label>
                                                        <input type="text" id="sv_title_en" name="sv_title_en" class="form-control" required> 
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                        <label for="sv_explanation_th"><b style="color: #FF2D00">*</b><?php echo label('svdesc')." TH"; ?>:</label>
                                                        <input type="text" id="sv_explanation_th" name="sv_explanation_th" class="form-control" required> 
                                                      </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                        <label for="sv_explanation_en"><b style="color: #FF2D00">*</b><?php echo label('svdesc')." EN"; ?>:</label>
                                                        <input type="text" id="sv_explanation_en" name="sv_explanation_en" class="form-control" required> 
                                                      </div>
                                                    </div>

                                                    <div class="form-group col-md-12">
                                                        <label class="control-label text-right"><?php echo label('period_specific'); ?></label>

                                                        <div class='input-group mb-3'>
                                                            <input type='text' id="daterange_survey" name="daterange_survey" class="form-control timeseconds" />
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">
                                                                    <span class="ti-calendar"></span>
                                                                </span>
                                                                <span class="input-group-text hover_cleartxt" onclick="clear_txt('daterange_survey','survey_open_var','survey_end_var')">
                                                                    <span class="mdi mdi-close-box"></span>
                                                                </span>
                                                            </div>
                                                            <input type="hidden" id="survey_open_var" name="survey_open_var">
                                                            <input type="hidden" id="survey_end_var" name="survey_end_var">
                                                        </div>

                                                        <!-- <div class="input-daterange input-group" id="date-range_survey">
                                                            <input type="text" class="form-control" name="survey_open" id="survey_open" />
                                                            <div class="input-group-append">
                                                                <span class="input-group-text bg-info b-0 text-white"><?php echo label('to'); ?></span>
                                                            </div>
                                                            <input type="text" class="form-control" name="survey_end" id="survey_end" />
                                                            <input type="hidden" id="survey_open_var" name="survey_open_var">
                                                            <input type="hidden" id="survey_end_var" name="survey_end_var">
                                                        </div> -->
                                                    </div>

                                                    <div class="form-group col-md-6">
                                                      <label class="control-label"><b style="color: #FF2D00">*</b><?php echo label('quessuggestion_status'); ?></label>
                                                      <div class="m-b-10">
                                                          <label class="custom-control custom-radio">
                                                              <input type="radio" id="radio_sv_suggestion_status1" name="sv_suggestion_status" checked value="1" class="custom-control-input">
                                                              <span class="custom-control-label"><?php echo  label('have'); ?></span>
                                                          </label>
                                                          <label class="custom-control custom-radio">
                                                              <input type="radio" id="radio_sv_suggestion_status2" name="sv_suggestion_status" value="0" class="custom-control-input">
                                                              <span class="custom-control-label"><?php echo label('none'); ?></span>
                                                          </label>
                                                      </div>
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="status_cr"><?php echo label('svtheme'); ?>:</label>
                                                        <select class="form-control select2" id="qn_id" name="qn_id"  style="width: 100%;">
                                                        </select>
                                                    </div>

                                                    <div class="col-md-12 progress" id="progress_survey_div">
                                                        <div class="progress-barsurvey bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id="txt_progresssurvey"></span></div>
                                                    </div>
                                                    <div class="form-group col-md-2" align="center">
                                                        <br>
                                                        <input type="submit" name="action" id="action" class="btn btn-outline-success btn-block pull-left" value="<?php echo label('saveR'); ?>" />
                                                    </div>
                                                    <div class="form-group col-md-2" align="center">
                                                        <br>
                                                        <button type="reset" class="btn btn-outline-danger btn-block" onclick="display_style('div_create_survey','div_survey')"><?php echo label('m_cancel'); ?></button>
                                                    </div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div id="div_survey_detail" style="display: none;">

                                        <div class="col-md-12" align="right">
                                            <button name="back_survey_detail" id="back_survey_detail" class="btn btn-outline-success back_survey_detail" onclick="display_style('div_survey_detail','div_survey_main')"><i class="mdi mdi-keyboard-return"></i> <?php echo label('m_previous'); ?></button>
                                            <?php if($btn_add=="1"){ ?>
                                                <button name="add_survey_detail" id="add_survey_detail" class="btn btn-outline-info add_survey_detail" onclick="create_div('div_create_survey_detail','div_sv_survey_detail','survey_detail_form')"><i class="mdi mdi-plus-box-outline"></i> <?php echo label('create').label('squestion'); ?></button>
                                                <button name="import_question" id="import_survey_detail" class="btn btn-outline-info import_survey_detail" onclick="create_div('div_import_survey_detail','div_sv_survey_detail','survey_detail_import_form')"><i class="mdi mdi-plus-box-outline"></i> <?php echo label('import_data').label('squestion'); ?></button>
                                            <?php } ?>
                                        </div>
                                        <h4 id="sv_name_txt"></h4>
                                        <hr>
                                        <div id="div_sv_survey_detail" class="col-md-12">
                                            <div class="table-responsive">
                                              <table id="myTable_survey_detail" width="100%" class="table table-bordered table-striped">
                                                <thead>
                                                  <tr>
                                                    <th width="10%" align="center"></th>
                                                    <th width="40%" align="center"><?php echo label('stitle'); ?></th>
                                                    <th width="40%" align="center"><?php echo label('squestion'); ?></th>
                                                    <th width="10%" align="center"><?php echo label('manage'); ?></th>
                                                  </tr>
                                                </thead>
                                              </table>
                                            </div>
                                        </div>
                                        <div id="div_import_survey_detail" style="display: none;">
                                            <form  enctype="multipart/form-data" id="survey_detail_import_form" name="survey_detail_import_form" autocomplete="off" method="POST" accept-charset="utf-8"  class="form-horizontal p-t-20">
                                                    <div class="row col-md-12">
                                                        <label for="file_import_survey"><b style="color: #FF2D00">*</b><?php echo 'Excel File'; ?>:</label>
                                                        <input type="file" name="file_import_survey" required id="file_import_survey" class="dropify"  accept=".xls,.xlsx" />
                                                        <?php echo label('certificate_example')." : "; ?><a href="<?php echo REAL_PATH;?>/uploads/format/format_import_survey.xlsx" download>format_import_survey.xlsx</a>
                                                        <input type="hidden" id="operation_import_survey" name="operation_import_survey" value="Add">
                                                        <input type="hidden" id="sv_id_detail_import" name="sv_id_detail_import">
                                                    </div>

                                                    <div class="row col-md-12 progress" id="progress_import_survey_div">
                                                        <div class="progress-bar_importsurvey bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id="txt_progressimport_survey"></span></div>
                                                    </div>
                                                    <div class="form-group row col-md-2" align="center">
                                                        <br>
                                                        <input type="submit" name="action" id="action" class="btn btn-outline-success btn-block pull-left" value="<?php echo label('import_data'); ?>" />
                                                    </div>
                                            </form>
                                        </div>
                                        <div id="div_create_survey_detail" style="display: none;" class="col-md-12">

                                            <form  enctype="multipart/form-data" id="survey_detail_form" name="survey_detail_form" autocomplete="off" method="POST" accept-charset="utf-8"  class="form-horizontal p-t-20">
                                                <input type="hidden" id="sv_id_detail" name="sv_id_detail">
                                                <input type="hidden" id="cos_id_detail" name="cos_id_detail">
                                                <input type="hidden" id="svde_id" name="svde_id">
                                                <input type="hidden" id="operation_survey_detail" name="operation_survey_detail" value="Add">
                                                <div class="col-md-12 row" style="">
                                                    <div class="form-group col-md-6">
                                                        <label for="svde_heading_th"><b style="color: #FF2D00">*</b><?php echo label('stitle')." TH"; ?>:</label>
                                                        <input type="text" id="svde_heading_th" name="svde_heading_th" class="form-control" required> 
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="svde_heading_en"><b style="color: #FF2D00">*</b><?php echo label('stitle')." EN"; ?>:</label>
                                                        <input type="text" id="svde_heading_en" name="svde_heading_en" class="form-control" required> 
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="svde_detail_th"><b style="color: #FF2D00">*</b><?php echo label('squestion')." TH"; ?>:</label>
                                                        <input type="text" id="svde_detail_th" name="svde_detail_th" class="form-control" required> 
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label for="svde_detail_en"><b style="color: #FF2D00">*</b><?php echo label('squestion')." EN"; ?>:</label>
                                                        <input type="text" id="svde_detail_en" name="svde_detail_en" class="form-control" required> 
                                                    </div>
                                                    <div class="col-md-12 progress" id="progress_survey_detail_div">
                                                        <div class="progress-barsurvey_detail bg-success" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id="txt_progresssurvey_detail"></span></div>
                                                    </div>
                                                    <div class="form-group col-md-2" align="center">
                                                        <br>
                                                        <input type="submit" name="action" id="action" class="btn btn-outline-success btn-block pull-left" value="<?php echo label('saveR'); ?>" />
                                                    </div>
                                                    <div class="form-group col-md-2" align="center">
                                                        <br>
                                                        <button type="reset" class="btn btn-outline-danger btn-block" onclick="display_style('div_create_survey_detail','div_sv_survey_detail')"><?php echo label('m_cancel'); ?></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane p-20 card" id="enroll" role="tabpanel">
                                <div class="card-body">
                                    <div id="div_enroll_main" class="row">
                                        <div class="col-md-12" align="right">
                                            <button name="manage_quiz" id="manage_quiz" class="btn btn-outline-info manage_quiz"><i class="mdi mdi-plus-box-outline"></i> <?php echo label('manage').label('quiz'); ?></button>
                                            <hr>
                                        </div>
                                        <div class="form-group col-md-6" align="left">
                                            <label for="emp_c"><b style="color: #FF2D00">*</b><?php echo label('p_emp_c'); ?> : </label>
                                            <input type="text" id="emp_c" name="emp_c" class="form-control"> 
                                        </div>
                                        <div class="form-group col-md-2" align="left"><br>
                                            <button type="button" onclick="add_employeetocourse()" class="btn btn-outline-info btn-block"><?php echo label('e_add'); ?></button>
                                        </div>
                                        <div class="form-group col-md-6" align="left">
                                            <label for="cosen_score_all"><b style="color: #FF2D00">*</b><?php echo label('saveR').label('point').label('r_company'); ?> : </label>
                                            <input type="text" id="cosen_score_all" name="cosen_score_all" class="form-control"> <br>
                                        </div>
                                        <div class="form-group col-md-2" align="left"><br>
                                            <button type="button" class="btn btn-outline-success btn-block" onclick="update_score_all()"><?php echo label('saveR'); ?></button>
                                        </div>
                                        <div id="div_enroll" class="col-md-12">
                                            <hr>
                                            <div class="table-responsive">
                                                <table id="myTable_enroll" width="100%" class="table table-bordered table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th width="10%" align="center"></th>
                                                        <th width="40%" align="center"><?php echo label('r_name'); ?></th>
                                                        <th width="20%" align="center"><?php echo label('com_admin'); ?></th>
                                                        <th width="20%" align="center"><?php echo label('score'); ?></th>
                                                        <th width="10%" align="center"><?php echo label('manage'); ?></th>
                                                      </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="div_enroll_cancel" class="row">
                                        <div class="col-md-12">
                                            <form  enctype="multipart/form-data" id="enroll_cancel_form" name="enroll_cancel_form" autocomplete="off" method="POST" accept-charset="utf-8"  class="form-horizontal p-t-20 row">
                                                <input type="hidden" id="cos_id_enroll" name="cos_id_enroll">
                                                <input type="hidden" id="cosen_id_enroll" name="cosen_id_enroll">
                                                <div class="form-group col-md-12">
                                                    <label for="cosen_cancelnote"><b style="color: #FF2D00">*</b><?php echo label('preNote').label('e_remove'); ?>:</label>
                                                    <textarea name="cosen_cancelnote" id="cosen_cancelnote" required style="width: 100%"></textarea>
                                                </div>
                                                    <div class="form-group col-md-2" align="center">
                                                        <br>
                                                        <input type="submit" name="action" id="action" class="btn btn-outline-warning btn-block pull-left" value="<?php echo label('e_remove'); ?>" />
                                                    </div>
                                                    <div class="form-group col-md-2" align="center">
                                                        <br>
                                                        <button type="reset" class="btn btn-outline-danger btn-block" onclick="display_style('div_enroll_cancel','div_enroll_main')"><?php echo label('m_cancel'); ?></button>
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div id="div_enroll_qiz" class="row">
                                        <div class="col-md-12" align="right">
                                            <button name="back_enroll" id="back_enroll" class="btn btn-outline-success back_enroll" onclick="display_style('div_enroll_qiz','div_enroll_main')"><i class="mdi mdi-keyboard-return"></i> <?php echo label('m_previous'); ?></button>
                                        </div>
                                        <div class="col-md-12 row">
                                            <div class="form-group col-md-6" align="left">
                                                <label for="qiz_id_enroll"><b style="color: #FF2D00">*</b><?php echo label('quiz'); ?> : </label>
                                                <select class="form-control" required id="qiz_id_enroll" name="qiz_id_enroll"  style="width: 100%;">
                                                </select>
                                            </div>
                                            <div class="form-group col-md-6" align="left">
                                                <label for="qiz_score_all"><b style="color: #FF2D00">*</b><?php echo label('saveR').label('point').label('r_company'); ?> : </label>
                                                <input type="text" id="qiz_score_all" name="qiz_score_all" class="form-control"> <br>
                                                <button type="button" class="btn btn-outline-success btn-block" onclick="qiz_update_score_all()"><?php echo label('saveR'); ?></button>
                                            </div>
                                            <div id="div_enroll" class="col-md-12">
                                                <hr>
                                                <div class="table-responsive">
                                                    <table id="myTable_enroll_qiz" width="100%" class="table table-bordered table-striped">
                                                        <thead>
                                                          <tr>
                                                            <th width="10%" align="center"></th>
                                                            <th width="40%" align="center"><?php echo label('r_name'); ?></th>
                                                            <th width="10%" align="center"><?php echo label('com_admin'); ?></th>
                                                            <th width="20%" align="center"><?php echo label('score'); ?></th>
                                                          </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="operation" name="operation" value="Add">
                    <input type="hidden" id="id" name="id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger btn-flat" data-dismiss="modal"><?php echo label('close'); ?></button>
                    </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->