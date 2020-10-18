<style type="text/css">
  .text-wrap{
    white-space:normal;overflow-wrap: anywhere;
  }
</style>
<script type="text/javascript">
        $('.allownumericwithoutdecimal').keyup(function () { 
            this.value = this.value.replace(/[^0-9,]/g, '').replace(/(\..*)\./g, '$1');
        });
        $("#ccode").keypress(function(event){
            var ew = event.which;
            if(ew == 32)
                return true;
            if(48 <= ew && ew <= 57)
                return true;
            if(65 <= ew && ew <= 90)
                return true;
            if(97 <= ew && ew <= 122)
                return true;
            return false;
        });
        function validate(evt) {
          var theEvent = evt || window.event;

          // Handle paste
          if (theEvent.type === 'paste') {
              key = event.clipboardData.getData('text/plain');
          } else {
          // Handle key press
              var key = theEvent.keyCode || theEvent.which;
              key = String.fromCharCode(key);
          }
          var regex = /[0-9]/;
          if( !regex.test(key) ) {
            theEvent.returnValue = false;
            if(theEvent.preventDefault) theEvent.preventDefault();
          }
        }
     
        function remove_character(str, char_pos) 
        {
            part1 = str.substring(0, char_pos);
            part2 = str.substring(char_pos + 1, str.length);
            return (part1 + part2);
        }
        $('#cos_expire_noti').keyup(function(){
            var value = $(this).val();
            var res = parseInt(value.charAt(value.length-1)); 
            var resBefore = parseInt(value.charAt(value.length-2)); 
            //Number.isInteger(123)
            if(resBefore!=""){
                if(!Number.isInteger(resBefore)){
                    if(!Number.isInteger(res)){
                        $('#cos_expire_noti').val(remove_character(value, value.length-1));
                    }
                }
            }
           // console.log(resBefore,res);
        });
        $('.slimtest1').perfectScrollbar();
	      $('.select2').select2();
        $('.clockpicker').clockpicker({
            placement: 'bottom',
            align: 'left',
            autoclose: true,
            donetext: 'Done',
            'default': 'now'
        }).find('input').change(function() {
        });
        function clicktabdoccos(){
          var cos_id = $('#course_id_pp').val();
          val_lang('0','input_doccos_th','name_file_','th');
          val_lang('0','input_doccos_eng','name_file_','eng');
          fetch_data_document_cos(cos_id,0);
                $.ajax({
                      url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                      type: 'POST',
                      data:{cos_id:cos_id,les_lang:''},
                      dataType:"json",
                      success: function(data){
                        for (var i = data.arr_lang.length - 1; i >= 0; i--) {
                          if(data.arr_lang[i]=="th"){
                            val_lang('1','input_doccos_th','name_file_','th');
                          }
                          if(data.arr_lang[i]=="eng"){
                            val_lang('1','input_doccos_eng','name_file_','eng');
                          }
                        }
                        $('#fil_lang').val(data.val_lang);
                      }
                });
                $.ajax({
                    url:"<?=base_url()?>index.php/querydata/query_coursemain",
                    method:"POST",
                    data:{cos_id:cos_id},
                    dataType:"json",
                    success:function(data)
                    { 
                        $('#cos_document').show();
                        <?php if($user['u_id']!="1"){ ?>
                        if(data.cos_approve=="1"){
                        $('#cos_document').hide();
                        }
                        <?php } ?>
                    }
                });
        }
        var _validFileExtensions = [".xlsx", ".xls", ".doc", ".docx", ".ppt", ".pptx", ".pdf"];    
        function ValidateSingleInput(oInput) {
            if (oInput.type == "file") {
                var sFileName = oInput.value;
                 if (sFileName.length > 0) {
                    var blnValid = false;
                    for (var j = 0; j < _validFileExtensions.length; j++) {
                        var sCurExtension = _validFileExtensions[j];
                        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                            blnValid = true;
                            break;
                        }
                    }
                     
                    if (!blnValid) {

                                          swal({
                                              title: '<?php echo label("media_type_dontmatch"); ?>',
                                              text: "",
                                              type: 'warning',
                                              showCancelButton: false,
                                              confirmButtonClass: 'btn btn-primary',
                                              confirmButtonText: '<?php echo label("m_ok"); ?>'
                                          })
                        oInput.value = "";
                        return false;
                    }
                }
            }
            return true;
        }
        
        $('select[name="type_media_cosv"]').on('change', function(){
          var type_media_cosv = $(this).val();
          if(type_media_cosv=='1'){
            document.getElementById('div_multifile_url_videocourse').style.display = '';
            document.getElementById('div_multifile_upload_file_videocourse').style.display = 'none';
          }else if(type_media_cosv=='2'){
            clear_dropify('cosv_thumbnail');
            clear_dropify('cosv_video');
            document.getElementById('div_multifile_url_videocourse').style.display = 'none';
            document.getElementById('div_multifile_upload_file_videocourse').style.display = '';
          }else{
            document.getElementById('div_multifile_url_videocourse').style.display = 'none';
            document.getElementById('div_multifile_upload_file_videocourse').style.display = 'none';
          }
        });

        function fetch_data_coursevideo(cos_id,page_num)
         {
            $('#myTable_videocourse').DataTable().destroy();
            var table = $('#myTable_videocourse').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_videocourse/',
                    data : {cos_id:cos_id},
                    type : 'GET'
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

        function onchkdep(dep_id,com_id){
          var dep_ = document.getElementById('chkdep_'+dep_id);
          if(dep_.checked == true){
            $('.chkdepall_'+dep_id).show();
            $('#div_posiofdep'+dep_id).show();
            $(".chkposiall_"+dep_id).prop('checked', true);
          }else{
            $('#div_posiofdep'+dep_id).hide();
            // $('.chkdepall_'+dep_id).hide();
            $(".chkposiall_"+dep_id).prop('checked', false);
          }
          if($('[data-com="'+com_id+'"]').is(':checked')){
            $("#chkcom_"+com_id).prop('checked', true); //true
          }else{
            $("#chkcom_"+com_id).prop('checked', false);
          }

              var checkedAry= [];
              $.each($(".chkcompany"+com_id+":checked"), function () {
                  checkedAry.push($(this).attr("id"));
              });
              var checkedAryAll= [];
              $.each($(".chkcompany"+com_id), function () {
                  checkedAryAll.push($(this).attr("id"));
              });
              if(checkedAry.length==checkedAryAll.length){
                $("#chkallcom_"+com_id).prop('checked', true);
              }else{
                $("#chkallcom_"+com_id).prop('checked', false);
              }
        }

        function onchkcom(com_id){
          var com_ = document.getElementById('chkcom_'+com_id);
          if(com_.checked == true){
            $('#div_depofcompany'+com_id).show();
            $('[data-com="'+com_id+'"]').show();
            $('#divallcom_'+com_id).show();
            $('#chkallcom_'+com_id).prop('checked', true);
            $('.chkall_'+com_id).show();
            $('[data-com="'+com_id+'"]').prop('checked', true);
          }else{
            $('#div_depofcompany'+com_id).hide();
            $('[data-com="'+com_id+'"]').hide();
            $('.chkall_'+com_id).hide();
            $('[data-com="'+com_id+'"]').prop('checked', false);
            $('#chkallcom_'+com_id).prop('checked', false);
            $('#divallcom_'+com_id).hide();
          }
        }

        function onchkallcom(com_id){
          var allcom_ = document.getElementById('chkallcom_'+com_id);
          if(allcom_.checked == true){
            $('[data-com="'+com_id+'"]').prop('checked', true);
            $('#chkcom_'+com_id).prop('checked', true);
          }else{
            $('[data-com="'+com_id+'"]').prop('checked', false);
            $('#chkcom_'+com_id).prop('checked', false);
          }
        }

        function changeValEnableDivMedia(){
          var les_type = document.getElementById('les_type');
          var cos_id = $('#course_id_pp').val();

              $.ajax({
                      url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                      type: 'POST',
                      data:{cos_id:cos_id,les_lang:''},
                      dataType:"json",
                      success: function(data){
                        var th_select = 0;
                        var eng_select = 0;
                        for (var i = data.arr_lang.length - 1; i >= 0; i--) {
                          if(data.arr_lang[i]=="th"){
                            th_select = 1;
                          }
                          if(data.arr_lang[i]=="eng"){
                            eng_select = 1;
                          }
                        }
                            if(th_select==1){
                              document.getElementById("med_name_th").required = false;
                            }
                            if(eng_select==1){
                              document.getElementById("med_name_eng").required = false;
                            }
                      }
                });
          if(les_type.checked != true){
            document.getElementById('div_media').style.display = '';
            document.getElementById('div_scorm').style.display = 'none';
          }else{
            document.getElementById('div_media').style.display = 'none';
            document.getElementById('div_scorm').style.display = '';
          }
        }

        function onchkposi(posi_id,com_id,dep_id){
          var posi_ = document.getElementById('chkposi_'+posi_id);
          if($('[data-com="'+com_id+'"]').is(':checked')){
            $("#chkcom_"+com_id).prop('checked', true);
          }else{
            $("#chkcom_"+com_id).prop('checked', false);
          }
          if($('[data-dep="'+dep_id+'"]').is(':checked')){
            $("#chkdep_"+dep_id).prop('checked', true);
          }else{
            $("#chkdep_"+dep_id).prop('checked', false);
          }
              var checkedAry= [];
              $.each($(".chkcompany"+com_id+":checked"), function () {
                  checkedAry.push($(this).attr("id"));
              });
              var checkedAryAll= [];
              $.each($(".chkcompany"+com_id), function () {
                  checkedAryAll.push($(this).attr("id"));
              });
              if(checkedAry.length==checkedAryAll.length){
                $("#chkallcom_"+com_id).prop('checked', true);
              }else{
                $("#chkallcom_"+com_id).prop('checked', false);
              }
          //chkallcom_
        }

          function Select_quiz_type(value,value_limit,status_limit){
              if(!value_limit){
                value_limit="1";
              } 
              if(status_limit==""){
                status_limit="0";
              } 
              if(value=="2"){
                  document.getElementById('quiz_limit').readOnly = false;
                  document.getElementById('quiz_limit').checked = true;
                  document.getElementById("quiz_limitval").readOnly = false;
                  $('#quiz_limitval').val(value_limit);
              }else{
                document.getElementById('quiz_limit').readOnly = true;
                  //if(status_limit!="1"){
                      document.getElementById('quiz_limit').checked = true;
                      $('#quiz_limitval').val('1');
                      document.getElementById("quiz_limitval").readOnly = true;
                  /*}else{
                      document.getElementById('quiz_limit').checked = true;
                      $('#quiz_limitval').val('1');
                      document.getElementById("quiz_limitval").readOnly = true;
                  }*/
              }
          }
          function clickhint_quiz(){
              var ishint = document.getElementById('quiz_ishint');
              var val_chk = 1;
              if(ishint.checked){
                  document.getElementById('quiz_model').checked = true;
                  $('#quiz_limitval').val('1');
                  document.getElementById('quiz_limitval').readOnly = false;

                  var quiz_type = document.getElementById('quiz_type');
                  if(!quiz_type.checked){
                    /*$('#quiz_limitval').val('1');
                    document.getElementById('quiz_limit').readOnly = false;
                    document.getElementById("quiz_limitval").readOnly = false;*/
                 
                    document.getElementById('quiz_limit').readOnly = true;
                    document.getElementById('quiz_limit').checked = true;
                    $('#quiz_limitval').val('1');
                    document.getElementById("quiz_limitval").readOnly = true;
                  }
              }else{
                  document.getElementById('quiz_model').checked = false;
              }
          }

          function readonly_quiz(field_name){
              var remember = document.getElementById('quiz_limit');
              var val_chk = 1;
              if(remember.checked){
                  $('#'+field_name).val('1');
                  document.getElementById(field_name).readOnly = false;
              }else{
                  $('#'+field_name).val('0');
                  document.getElementById(field_name).readOnly = true;
              }
              var quiz_type = document.getElementById('quiz_type');
              if(!quiz_type.checked){
                /*$('#quiz_limitval').val('1');
                document.getElementById('quiz_limit').readOnly = false;
                document.getElementById("quiz_limitval").readOnly = false;*/
             
                document.getElementById('quiz_limit').readOnly = true;
                document.getElementById('quiz_limit').checked = true;
                $('#quiz_limitval').val('1');
                document.getElementById("quiz_limitval").readOnly = true;
              }
              var quiz_model = document.getElementById('quiz_model');
              if(quiz_model.checked){
                //document.getElementById('quiz_ishint').checked = true;
              }else{
                document.getElementById('quiz_ishint').checked = false;
              }
          }
          function display_quiz(field_name){
              var remember = document.getElementById('quiz_type');
              var val_chk = 1;
              if(remember.checked){
                  document.getElementById(field_name).style.display = '';
                  val_chk = 2;
              }else{
                swal({
                    title: '<?php echo label("msg_pretest_only"); ?>',
                    text: "",
                    type: 'warning',
                    showCancelButton: false,
                    confirmButtonClass: 'btn btn-primary',
                    confirmButtonText: '<?php echo label("m_ok"); ?>'
                })
                  document.getElementById(field_name).style.display = 'none';
              }
              Select_quiz_type(val_chk);
          }
          $(document).ready(function () {
              var cos_id = '';
              var updateOutput = function (e) {
                  var list = e.length ? e : $(e.target), output = list.data('output');
                  if (window.JSON) {output.val(window.JSON.stringify(list.nestable('serialize')));//, null, 2));
                  } else {
                      cos_id = $('#course_id_pp').val();
                      output.val('JSON browser support required for this demo.');
                  }
                  var myObj = JSON.parse(window.JSON.stringify(list.nestable('serialize')));
                  $.ajax({
                      url:"<?=base_url()?>index.php/course/edit_li_lesson",
                      method:'POST',
                      data:{arr_obj:myObj,cos_id:cos_id},
                      success:function(data)
                      {
                        
                      }
                  });
              };
              $('#nestable').nestable({
                  group: 1,
                  maxDepth: 7,
              }).on('change', updateOutput);
              var arr_out =  updateOutput($('#nestable').data('output', $('#nestable-output')));

          });
         function fetch_data_lesson(cos_id,page_num){
            $('#myTable_lesson').DataTable().destroy();
            var table = $('#myTable_lesson').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_course_lesson/',
                    data : {cos_id:cos_id,status_user:''},
                    type : 'GET'
                },
              "columnDefs": [
                { "orderable": false, "targets": [4,5] }
              ],
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
                          
        function fetch_data_question(quiz,page_num)
         {
            $('#myTable_quiz_question').DataTable().destroy();
            var table = $('#myTable_quiz_question').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_course_question/',
                    data : {quiz:quiz},
                    type : 'GET'
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
                          
        function fetch_data_quiz(cos_id,page_num)
         {
            $('#myTable_quiz').DataTable().destroy();
            var table = $('#myTable_quiz').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_course_quiz/',
                    data : {cos_id:cos_id},
                    type : 'GET'
                }
            });
         }
        function changedate(value){
            var res_date = value.split("/");
            <?php if($lang=="thai"){ ?>
            return (parseInt(res_date[2])-543)+"-"+res_date[1]+"-"+res_date[0];
            <?php }else{ ?>
            return (parseInt(res_date[2]))+"-"+res_date[1]+"-"+res_date[0];
            <?php } ?>
        }
        
        function date_picker(id){
          jQuery('#'+id).datepicker({
                          format: 'dd/mm/yyyy',
                          language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                          thaiyear: true    
          }).datepicker("setDate", "1");
        }

        function caldate(id){
            var val_change = changedate($('#'+id).val());  
            $('#'+id+'_var').val(val_change);
        }
        function textarea_tinymce(id,img){
            if(img==""){
              img="0";
            }
            if ($("#"+id).length > 0) {
  
                tinymce.init({
                    setup: function (ed) {
                        ed.on('keyup', function (e) { 
                            var count = CountCharacters(id);
                            if(count>10000){
                              var plain_text = $(tinymce.get(id).getBody()).text();
                              $(tinymce.get(id).getBody()).html(plain_text.substring(0, 9999));
                            }
                        });
                    },
                    selector: "textarea#"+id,
                    theme: "modern",
                    height: 300,
                    plugins: [
                        "advlist autolink link image lists charmap hr anchor pagebreak",
                        "searchreplace wordcount visualblocks visualchars code insertdatetime media nonbreaking",
                        "save table contextmenu directionality paste textcolor"
                    ],
                    toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | forecolor backcolor ",

                    images_upload_url : '<?=base_url()?>index.php/setting/upload_img_texteditor',
                    automatic_uploads : false,

                    images_upload_handler : function(blobInfo, success, failure) {
                      var xhr, formData;

                      xhr = new XMLHttpRequest();
                      xhr.withCredentials = false;
                      xhr.open('POST', '<?=base_url()?>index.php/setting/upload_img_texteditor');

                      xhr.onload = function() {
                        var json;

                        if (xhr.status != 200) {
                          if(xhr.status==400){
                            failure('Please use English filename');
                          }else{
                            failure('HTTP Error: ' + xhr.status);
                          }
                          return;
                        }

                        json = JSON.parse(xhr.responseText);

                        if (!json || typeof json.file_path != 'string') {
                          failure('Invalid JSON: ' + xhr.responseText);
                          return;
                        }

                        success(json.file_path);
                      };

                      formData = new FormData();
                      formData.append('file', blobInfo.blob(), blobInfo.filename());

                      xhr.send(formData);
                    },
                });
            }
        }
    function CountCharacters(id) {
        var body = tinymce.get(id).getBody();
        var content = tinymce.trim(body.innerText || body.textContent);

        return content.length;
    };
    function ValidateCharacterLength() {
        var max = 20;
        var count = CountCharacters();
        if (count > max) {
            alert("Maximum " + max + " characters allowed.")
            return false;
        }
        return;
    }
        function onAddFileDocCos(){
            var fil_lang = $('#fil_lang').val();
            var name_file_th = $('#name_file_th').val();
            var name_file_eng = $('#name_file_eng').val();
            var path_file = document.getElementById('path_file').files[0];
            var fil_cos_id = $('#fil_cos_id').val();
            var cos_id = $('#course_id_pp').val();
            var operation_doccos = $('#operation_doccos').val();
            var path_fileval = $('#path_file').val();
            var rechkstatus = 1;
            var fileExtension = ['doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx', 'pdf'];
            if(path_fileval!=""){
              if($.inArray($('#path_file').val().split('.').pop().toLowerCase(), fileExtension) != -1){
                $.ajax({
                      url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                      type: 'POST',
                      data:{cos_id:cos_id,les_lang:''},
                      dataType:"json",
                      success: function(datalang){
                        for (var i = datalang.arr_lang.length - 1; i >= 0; i--) {
                          if(datalang.arr_lang[i]=="th"&&name_file_th==""){
                            rechkstatus=0;
                            document.getElementById("name_file_th").focus();
                          }
                          if(datalang.arr_lang[i]=="eng"&&name_file_eng==""){
                            rechkstatus=0;
                            document.getElementById("name_file_eng").focus();
                          }
                        }
                        if(rechkstatus==1){
                            var form = new FormData();
                            form.append('path_file', path_file);
                            form.append('fil_lang', $('#fil_lang').val());
                            form.append('name_file_th', $('#name_file_th').val());
                            form.append('name_file_eng', $('#name_file_eng').val());
                            form.append('fil_cos_id', $('#fil_cos_id').val());
                            form.append('cos_id', $('#course_id_pp').val());
                            form.append('operation_doccos', $('#operation_doccos').val());
                            $.ajax({
                                url : "<?=base_url()?>index.php/insertdata/insert_documentincos",
                                type: "POST",
                                cache: false,
                                contentType: false,
                                processData: false,
                                data : form,
                                dataType : "json",
                                success: function(data){
                                    if(data.status=="2"){
                                        //$('#course_form')[0].reset();
                                        //$('#modal-default').modal('hide');
                                        //$("#fil_lang").val($("#fil_lang option:first").val());
                                        $('#name_file_th').val('');
                                        $('#name_file_eng').val('');
                                        $('#fil_cos_id').val('');
                                        $('#operation_doccos').val('Add');
                                        clear_dropify('path_file');
                                        swal(
                                            '<?php echo label("com_msg_success"); ?>',
                                            '',
                                            'success'
                                        ).then(function () {
                                          fetch_data_document_cos(cos_id,0);
                                        })
                                    }else if(data.status=="1"){
                                        swal({
                                            title: '<?php echo label("data_msg_duplicate"); ?>',
                                            text: "",
                                            type: 'warning',
                                            showCancelButton: false,
                                            confirmButtonClass: 'btn btn-primary',
                                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                                        }).then(function () {
                                            $("#com_name").val("");
                                            document.getElementById("com_name").focus();
                                        })
                                    }else{
                                        swal({
                                            title: '<?php echo label("com_msg_form_error"); ?>',
                                            text: "",
                                            type: 'warning',
                                            showCancelButton: false,
                                            confirmButtonClass: 'btn btn-primary',
                                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                                        })
                                    }
                                },
                                      error: function (jqXHR, exception) {
                                      $("#myModal_process").removeClass("in");
                                      $("#myModal_process").css("display","none");
                                      $('.btn_close').show();
                                          topFunction();
                                          var msg = '';
                                          if (jqXHR.status === 0) {
                                              msg = 'Not connect.\n Verify Network.';
                                          } else if (jqXHR.status == 404) {
                                              msg = 'Requested page not found. [404]';
                                          } else if (jqXHR.status == 500) {
                                              msg = 'Internal Server Error [500].';
                                          } else if (exception === 'parsererror') {
                                              msg = 'Requested JSON parse failed.';
                                          } else if (exception === 'timeout') {
                                              msg = 'Time out error.';
                                          } else if (exception === 'abort') {
                                              msg = 'Ajax request aborted.';
                                          } else {
                                              msg = 'Uncaught Error.\n' + jqXHR.responseText;
                                          }
                                          swal({
                                              title: msg,
                                              text: "",
                                              type: 'warning',
                                              showCancelButton: false,
                                              confirmButtonClass: 'btn btn-primary',
                                              confirmButtonText: '<?php echo label("m_ok"); ?>'
                                          })
                                      },
                            });
                        }else{

                                          swal({
                                              title: '<?php echo label("com_msg_form_error"); ?>',
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
                  document.getElementById("path_file").focus();
                                          swal({
                                              title: '<?php echo label("media_type_dontmatch"); ?>',
                                              text: "",
                                              type: 'warning',
                                              showCancelButton: false,
                                              confirmButtonClass: 'btn btn-primary',
                                              confirmButtonText: '<?php echo label("m_ok"); ?>'
                                          })
              }
            }else{
              if(operation_doccos=="Add"){
                document.getElementById("path_file").focus();
                                        swal({
                                            title: '<?php echo label("com_msg_form_error"); ?>',
                                            text: "",
                                            type: 'warning',
                                            showCancelButton: false,
                                            confirmButtonClass: 'btn btn-primary',
                                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                                        })
              }else{
                $.ajax({
                      url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                      type: 'POST',
                      data:{cos_id:cos_id,les_lang:''},
                      dataType:"json",
                      success: function(datalang){
                        for (var i = datalang.arr_lang.length - 1; i >= 0; i--) {
                          if(datalang.arr_lang[i]=="th"&&name_file_th==""){
                            rechkstatus=0;
                            document.getElementById("name_file_th").focus();
                          }
                          if(datalang.arr_lang[i]=="eng"&&name_file_eng==""){
                            rechkstatus=0;
                            document.getElementById("name_file_eng").focus();
                          }
                        }
                        if(rechkstatus==1){
                            var form = new FormData();
                            form.append('path_file', path_file);
                            form.append('fil_lang', $('#fil_lang').val());
                            form.append('name_file_th', $('#name_file_th').val());
                            form.append('name_file_eng', $('#name_file_eng').val());
                            form.append('fil_cos_id', $('#fil_cos_id').val());
                            form.append('cos_id', $('#course_id_pp').val());
                            form.append('operation_doccos', $('#operation_doccos').val());
                            $.ajax({
                                url : "<?=base_url()?>index.php/insertdata/insert_documentincos",
                                type: "POST",
                                cache: false,
                                contentType: false,
                                processData: false,
                                data : form,
                                dataType : "json",
                                success: function(data){
                                    if(data.status=="2"){
                                        //$('#course_form')[0].reset();
                                        //$('#modal-default').modal('hide');
                                        //$("#fil_lang").val($("#fil_lang option:first").val());
                                        $('#name_file_th').val('');
                                        $('#name_file_eng').val('');
                                        $('#fil_cos_id').val('');
                                        $('#operation_doccos').val('Add');
                                        clear_dropify('path_file');
                                        swal(
                                            '<?php echo label("com_msg_success"); ?>',
                                            '',
                                            'success'
                                        ).then(function () {
                                          fetch_data_document_cos(cos_id,0);
                                        })
                                    }else if(data.status=="1"){
                                        swal({
                                            title: '<?php echo label("data_msg_duplicate"); ?>',
                                            text: "",
                                            type: 'warning',
                                            showCancelButton: false,
                                            confirmButtonClass: 'btn btn-primary',
                                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                                        }).then(function () {
                                            $("#com_name").val("");
                                            document.getElementById("com_name").focus();
                                        })
                                    }else{
                                        swal({
                                            title: '<?php echo label("com_msg_form_error"); ?>',
                                            text: "",
                                            type: 'warning',
                                            showCancelButton: false,
                                            confirmButtonClass: 'btn btn-primary',
                                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                                        })
                                    }
                                },
                                      error: function (jqXHR, exception) {
                                      $("#myModal_process").removeClass("in");
                                      $("#myModal_process").css("display","none");
                                      $('.btn_close').show();
                                          topFunction();
                                          var msg = '';
                                          if (jqXHR.status === 0) {
                                              msg = 'Not connect.\n Verify Network.';
                                          } else if (jqXHR.status == 404) {
                                              msg = 'Requested page not found. [404]';
                                          } else if (jqXHR.status == 500) {
                                              msg = 'Internal Server Error [500].';
                                          } else if (exception === 'parsererror') {
                                              msg = 'Requested JSON parse failed.';
                                          } else if (exception === 'timeout') {
                                              msg = 'Time out error.';
                                          } else if (exception === 'abort') {
                                              msg = 'Ajax request aborted.';
                                          } else {
                                              msg = 'Uncaught Error.\n' + jqXHR.responseText;
                                          }
                                          swal({
                                              title: msg,
                                              text: "",
                                              type: 'warning',
                                              showCancelButton: false,
                                              confirmButtonClass: 'btn btn-primary',
                                              confirmButtonText: '<?php echo label("m_ok"); ?>'
                                          })
                                      },
                            });
                        }
                      }
                });
              }
            }
            
        }
        function clearDocumentCOS(){
                        //$("#fil_lang").val($("#fil_lang option:first").val());
                        $('#name_file_th').val('');
                        $('#name_file_eng').val('');
                        $('#fil_cos_id').val('');
                        $('#operation_doccos').val('Add');
                        clear_dropify('path_file');
        }
        function chkbox_lang(id,value,required_val){
            var remember = document.getElementById(id);
            var strArray = value.split("_");
            if (remember.checked) {
              $('.'+value).show();
              document.getElementById(required_val+strArray[1]).required = true;
              $('#action_maincos').prop('disabled', false);
            } else {
              var checkedAry= [];
              $.each($("input[name='cos_lang[]']:checked"), function () {
                  checkedAry.push($(this).attr("id"));
              });
              var operation = $('#operation').val();
              if(operation=="Edit"){
                  swal({
                      title: '<?php echo label('noti_lang_uncheck'); ?> ',
                      text: "",
                      type: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: "#1abc9c",   
                      cancelButtonColor: "#DD6B55",   
                      confirmButtonText: '<?php echo label('m_ok'); ?>',
                      cancelButtonText: '<?php echo label('cancel'); ?>'
                  }).then(function (isChk) {
                    if(isChk.value){
                      $('.'+value).hide();
                      document.getElementById(required_val+strArray[1]).required = false;
                      /*if(checkedAry.length>0){
                          $('#action_maincos').prop('disabled', false);
                      }else{
                          $('#action_maincos').prop('disabled', true);
                      }*/
                    }else{
                      $('#'+id).prop('checked', true);
                    }
                  })
              }else{
                  $('.'+value).hide();
                  document.getElementById(required_val+strArray[1]).required = false;
                  /*if(checkedAry.length>0){
                    $('#action_maincos').prop('disabled', false);
                  }else{
                    $('#action_maincos').prop('disabled', true);
                  }*/
              }
            }
        }
        function val_lang(value_chk,value,required_val,lang){
            var strArray = value.split("_");
            $('#'+required_val+lang).val("");
            if (value_chk=="1") {
              $('.'+value).show();
              if(required_val!=""){
                document.getElementById(required_val+lang).required = true;
              }
            } else {
              $('.'+value).hide();
              if(required_val!=""){
                document.getElementById(required_val+lang).required = false;
              }
            }
        }
        function cos_typegrading_onchange(value){
                $("#badges_condition").html('');
                if(value=="1"){
                  $("#badges_condition").append('<option value="A">A</option>');
                  $("#badges_condition").append('<option value="B">B</option>');
                  $("#badges_condition").append('<option value="C">C</option>');
                  $("#badges_condition").append('<option value="D">D</option>');
                  $("#badges_condition").val('A');
                }else{
                  $("#badges_condition").append('<option value="P"><?php echo label('pass'); ?></option>');
                  $("#badges_condition").append('<option value="F"><?php echo label('fail'); ?></option>');
                  $("#badges_condition").val('P');
                }
                if(value=="1"){
                  $('.typegrading_a').show();
                  $('.typegrading_b').hide();
                }else{
                  $('.typegrading_a').hide();
                  $('.typegrading_b').show();
                }
        }
      fetch_data_main(0);
      function fetch_data_main(page_num)
         {
            $('#myTable').DataTable().destroy();
            var com_id = $('#com_id_search').val();
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
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_detail_course/',
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

        function fetch_data_document_cos(cos_id,page_num)
         {
            $('#myTable_cos_document').DataTable().destroy();
            var table = $('#myTable_cos_document').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_cos_document/',
                    data : {cos_id:cos_id,status_user:'100'},
                    type : 'GET'
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


        function fetch_data_detail(cos_id,page_num)
         {
            $('#myTable_pp').DataTable().destroy();
            var table = $('#myTable_pp').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_course_detail/',
                    data : {cos_id:cos_id},
                    type : 'GET'
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
        function clear_dropify(id){
                    var imagenUrl = "";
                    var drEvent = $('#'+id).dropify(
                    {
                      defaultFile: imagenUrl
                    });
                    drEvent = drEvent.data('dropify');
                    drEvent.resetPreview();
                    drEvent.clearElement();
                    drEvent.settings.defaultFile = imagenUrl;
                    drEvent.destroy();
                    drEvent.init();
        }
        function changecompany_tycos(value,isActive){
                  $.ajax({
                        url: '<?=base_url()?>index.php/querydata/rechecktypecos',
                        type: 'POST',
                        data:{com_id:value},
                        success: function(data_typecos){
                          $('#tc_id').html(data_typecos);
                          $('#tc_id').val($('#tc_id option:first-child').val()).trigger('change');
                        }
                  });
                $.ajax({
                      url: '<?=base_url()?>index.php/querydata/recheckcondition',
                      type: 'POST',
                      data:{com_id:value,cos_id:'',condition:''},
                      success: function(datacondition){
                        $('#condition').html(datacondition);
                      }
                });
                
                
                      $.ajax({
                            url: '<?=base_url()?>index.php/querydata/recheckgroupcosmulti',
                            type: 'POST',
                            data:{cg_id:'',com_id:value,cos_id:''},
                            success: function(data_cg){
                              $('#cg_id').html(data_cg);
                            }
                      });
        }

        /*function onchangewkg(wg_id){
                      $.ajax({
                            url: '<?=base_url()?>index.php/querydata/recheckgroupcosmulti',
                            type: 'POST',
                            data:{cg_id:'',wg_id:wg_id,cos_id:''},
                            success: function(data_cg){
                              $('#cg_id').html(data_cg);
                            }
                      });
        }*/
           $('#add_button').click(function(){
                $("#modal-default").modal({backdrop: false});
                $('.modal-title').text('<?php echo label('createcourse'); ?>');
                $('#course_form')[0].reset();
                $('#operation').val("Add");
                $('.btn_delete_cos').hide();
                //document.getElementById('nav-item_document').style.display = 'none';
                clear_dropify('cos_pic');
                clear_dropify('badges_img');
                cos_typegrading_onchange(2);
                textarea_tinymce('cdesc_th','1');
                textarea_tinymce('cdesc_eng','1');
                $('.btn_maincourse').show();

                $('#div_cospicupload').show();
                $('#div_cospicview').hide();
                
                $('.nav-tabs a[href="#home"]').tab('show');
                $("#home").find("input,select,textarea,button").prop("disabled",false);
                $("#profile").find("input,select,textarea,button").prop("disabled",false);
                document.getElementById("cname_th").required = false;
                document.getElementById("cname_eng").required = false;
                $('.input_th').hide();
                $('.input_eng').hide();
                $("input[name='cos_lang[]']:checked").each(function ()
                {
                  if($(this).val()=="th"){
                    chkbox_lang('cos_lang_th','input_th','cname_');
                  }else if($(this).val()=="eng"){
                    chkbox_lang('cos_lang_eng','input_eng','cname_');
                  }
                });
                var com_id = $('#com_id_search').val();


                      $.ajax({
                            url: '<?=base_url()?>index.php/querydata/recheckgroupcosmulti',
                            type: 'POST',
                            data:{cg_id:'',com_id:com_id,cos_id:''},
                            success: function(data_cg){
                              $('#cg_id').html(data_cg);
                            }
                      });
                <?php if($com_admin=="com_central"){ ?>
                  $.ajax({
                        url: '<?=base_url()?>index.php/querydata/recheckcompany',
                        type: 'POST',
                        data:{com_id:''},
                        success: function(data_company){
                          $('#com_id').html(data_company);
                          $("#com_id").val(com_id);
                          changecompany_tycos(com_id);
                        }
                  });
                <?php }else{ ?>
                  changecompany_tycos('<?php echo $com_id; ?>');
                <?php } ?>
            });

    $(document).ready(function() {
        $('.dropify').dropify();
        //$('#myTable').DataTable();
        $(document).on('submit', '#course_form', function(event){
              event.preventDefault(); 
              var value = $('#cos_expire_noti').val();
              var operation = $('#operation').val();
              if(value!=""){
                var res = parseInt(value.charAt(value.length-1)); 
                if(!Number.isInteger(res)){
                        $('#cos_expire_noti').val(remove_character(value, value.length-1));
                }
              }
              var checkedAry= [];
              $.each($("input[name='cos_lang[]']:checked"), function () {
                  checkedAry.push($(this).attr("id"));
              });
              var varchk=1;
              var path_cert = $('#badges_img').val();
              var fileExtension = ['jpg','png','gif'];
              if(path_cert!=""){
                if($.inArray($('#badges_img').val().split('.').pop().toLowerCase(), fileExtension) == -1){
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
              if(checkedAry.length>0&&varchk==1){
                $.ajax({
                  url:"<?=base_url()?>index.php/insertdata/insert_cosmain",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  dataType:"json",
                  success:function(data)
                  {
                    if(data.status=="2"){
                        $('#course_form')[0].reset();
                        $('#modal-default').modal('hide');
                        swal(
                            '<?php echo label("com_msg_success"); ?>',
                            '',
                            'success'
                        ).then(function () {
                                      var table = $('#myTable').DataTable();
                                      var info = table.page.info();
                                      var length = info.pages;
                                      var page_current = info.page;
                                      fetch_data_main(page_current);
                                     // if(operation=="Add"){
                                        location.reload();
                                      //}
                        })
                    }else{
                        swal({
                            title: '<?php echo label("com_msg_error_save"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                                      if(operation=="Add"){
                                        location.reload();
                                      }
                        })
                    }
                   
                  },
                      error: function (jqXHR, exception) {
                          topFunction();
                          var msg = '';
                          if (jqXHR.status === 0) {
                              msg = 'Not connect.\n Verify Network.';
                          } else if (jqXHR.status == 404) {
                              msg = 'Requested page not found. [404]';
                          } else if (jqXHR.status == 500) {
                              msg = 'Internal Server Error [500].';
                          } else if (exception === 'parsererror') {
                              msg = 'Requested JSON parse failed.';
                          } else if (exception === 'timeout') {
                              msg = 'Time out error.';
                          } else if (exception === 'abort') {
                              msg = 'Ajax request aborted.';
                          } else {
                              msg = 'Uncaught Error.\n' + jqXHR.responseText;
                          }
                          swal({
                              title: msg,
                              text: "",
                              type: 'warning',
                              showCancelButton: false,
                              confirmButtonClass: 'btn btn-primary',
                              confirmButtonText: '<?php echo label("m_ok"); ?>'
                          }).then(function () {
                                      if(operation=="Add"){
                                        location.reload();
                                      }
                          })
                      },
                });
              }else{
                if(varchk!=3){
                        swal({
                            title: '<?php echo label("com_msg_form_error"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                                      if(operation=="Add"){
                                        location.reload();
                                      }
                        })
                }
              }
            });

         $(document).on('click', '.btn_delete_cos', function(){
            var cos_id = $(this).attr("id");
            swal({
                title: '<?php echo label('wg_delete_msg'); ?> ',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: '<?php echo label('wg_delete'); ?>',
                cancelButtonText: '<?php echo label('cancel'); ?>'
            }).then(function (isChk) {
              if(isChk.value){
                $.ajax({
                    url:"<?=base_url()?>index.php/manage/delete_cos_data",
                    method:"POST",
                    data:{id_delete:cos_id},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("com_msg_delete"); ?>',
                            '',
                            'success'
                        ).then(function () {
                                      var table = $('#myTable').DataTable();
                                      var info = table.page.info();
                                      var length = info.pages;
                                      var page_current = info.page;
                                      fetch_data_main(page_current);
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

         $(document).on('click', '.delete_cosdoc', function(){
            var fil_cos_id = $(this).attr("id");
            swal({
                title: '<?php echo label('wg_delete_msg'); ?> ',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: '<?php echo label('wg_delete'); ?>',
                cancelButtonText: '<?php echo label('cancel'); ?>'
            }).then(function (isChk) {
              if(isChk.value){
                $.ajax({
                    url:"<?=base_url()?>index.php/manage/delete_cosdoc_data",
                    method:"POST",
                    data:{id_delete:fil_cos_id},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("com_msg_delete"); ?>',
                            '',
                            'success'
                        ).then(function () {
                            var cos_id = $('#course_id_pp').val();
                            fetch_data_document_cos(cos_id,0);
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

          $(document).on('click', '.btnreject', function(e) {
              e.preventDefault();
              var cos_id = $(this).attr("id");
              swal({
                title: '<i class="mdi mdi-close-octagon"></i> <?php echo label("d_reject"); ?>',
                text: "",
                input: 'text',
                showCancelButton: true,
                closeOnConfirm: false,
                confirmButtonColor: "#1abc9c",   
                cancelButtonColor: "#DD6B55",    
                confirmButtonText: '<?php echo label('m_ok'); ?>',
                cancelButtonText: '<?php echo label('cancel'); ?>',
                inputPlaceholder: "<?php echo label('preNote'); ?>: "
              }).then(function (isChk) {
                  if(isChk.value){
                    $("#myModal_process").modal({backdrop: false});
                    $.ajax({
                      url:"<?=base_url()?>index.php/querydata/reject_cos",
                      method:"POST",
                      data:{cos_id:cos_id,cosa_note:isChk.value},
                      dataType:"json",
                      success:function(data)
                      {
                          location.reload();
                             /*         var table = $('#myTable').DataTable();
                                      var info = table.page.info();
                                      var length = info.pages;
                                      var page_current = info.page;
                                      fetch_data_main(page_current);*/
                      }
                    });
                  }
               /* if (inputValue === "") {
                  swal.showInputError("You need to write something!");
                  return false
                }else{
                swal("Nice!", "You wrote: " + inputValue, "success");
                }*/
              });
          });
          function createButton(text,classs,style,id, cb) {
            return $(' <button class="'+classs+'" style="'+style+'" id="'+id+'">' + text + '</button>').on('click', cb);
          }
          
          $(document).on('click', '.btnrefresh', function(e) {
              e.preventDefault();
              location.reload();
          });
          
         $(document).on('click', '.approve', function(e){
            var cos_id = $(this).attr("id");
            var buttons = $('<div>')
            .append(createButton('<i class="mdi mdi-check"></i> <?php echo label('d_approve'); ?>','btn btn-flat btnapprove_cos','background-color:#1abc9c;',cos_id, function() {
            })).append(createButton('<i class="mdi mdi-close-octagon"></i> <?php echo label("d_reject"); ?>','btn btn-flat btnreject','background-color:#DD6B55;',cos_id, function() {
               swal.close();
            })).append(createButton('<?php echo label('cancel'); ?>','btn btn-flat btnrefresh','','', function() {
               swal.close();
            }));
            e.preventDefault();
            swal({
              title: "<?php echo label('approve_is_course'); ?>",
              html: buttons,
              type: "warning",
              showConfirmButton: false,
              showCancelButton: false
            });
          });

          $(document).on('click', '.btnapprove_cos', function(e) {
              e.preventDefault();
              var cos_id = $(this).attr("id");
              $("#myModal_process").modal({backdrop: false});
              $.ajax({
                    url:"<?=base_url()?>index.php/manage/approve_cos_data",
                    method:"POST",
                    data:{cos_id:cos_id},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("approve_msg_success"); ?>',
                            '',
                            'success'
                        ).then(function () {
                          location.reload();
                                     /* var table = $('#myTable').DataTable();
                                      var info = table.page.info();
                                      var length = info.pages;
                                      var page_current = info.page;
                                      fetch_data_main(page_current);*/
                        })
                      }else if(data == "1"){
                         swal({
                            title: '<?php echo label("wg_msg_use"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label('m_ok'); ?>'
                        }).then(function () {
                          location.reload();
                                     /* var table = $('#myTable').DataTable();
                                      var info = table.page.info();
                                      var length = info.pages;
                                      var page_current = info.page;
                                      fetch_data_main(page_current);*/
                        })
                      }else{
                         swal({
                            title: '<?php echo label('com_msg_error_save'); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label('m_ok'); ?>'
                        }).then(function () {
                          location.reload();
                                     /* var table = $('#myTable').DataTable();
                                      var info = table.page.info();
                                      var length = info.pages;
                                      var page_current = info.page;
                                      fetch_data_main(page_current);*/
                        })
                      }
                    }
              });
          });

          $(document).on('click', '.update_cosdoc', function(){
            var fil_cos_id = $(this).attr("id");
            
            $.ajax({
              url:"<?=base_url()?>index.php/querydata/update_cosdoc_data",
              method:"POST",
              data:{fil_cos_id:fil_cos_id},
              dataType:"json",
              success:function(data)
              {
                topFunction();
                $('#operation_doccos').val("Edit");

                var cos_id = $('#course_id_pp').val();
                val_lang('0','input_doccos_th','name_file_','th');
                val_lang('0','input_doccos_eng','name_file_','eng');

                $.ajax({
                      url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                      type: 'POST',
                      data:{cos_id:cos_id,les_lang:''},
                      dataType:"json",
                      success: function(datalang){
                        for (var i = datalang.arr_lang.length - 1; i >= 0; i--) {
                          if(datalang.arr_lang[i]=="th"){
                            val_lang('1','input_doccos_th','name_file_','th');
                            $('#name_file_th').val(data.name_file_th);
                          }
                          if(datalang.arr_lang[i]=="eng"){
                            val_lang('1','input_doccos_eng','name_file_','eng');
                            $('#name_file_eng').val(data.name_file_eng);
                          }
                        }
                        $('#fil_lang').val(datalang.val_lang);
                      }
                });
                $('#fil_cos_id').val(data.fil_cos_id);
                if(data.path_file!=""){
                    var nameImage = "<?php echo REAL_PATH;?>/uploads/document/"+data.path_file
                    var drEvent = $('#path_file').dropify(
                    {
                      defaultFile: nameImage
                    });
                    drEvent = drEvent.data('dropify');
                    drEvent.resetPreview();
                    drEvent.clearElement();
                    drEvent.settings.defaultFile = nameImage;
                    drEvent.destroy();
                    drEvent.init();

                    var drEvent = $('.dropify_main').dropify({
                        defaultFile: "<?php echo REAL_PATH;?>/uploads/document/"+data.path_file ,
                    });
                }else{
                    clear_dropify('path_file');
                }

              }
            });
          });

          $(document).on('click', '.update', function(){
            var cos_id = $(this).attr("id");
            
                $('.btn_delete_cos').show();
                $('.btn_delete_cos').attr('id',cos_id);
                $("#modal-default").modal({backdrop: false});
                document.getElementById("cname_th").required = false;
                document.getElementById("cname_eng").required = false;
                $('.nav-tabs a[href="#home"]').tab('show');
                $('.modal-title').text('<?php echo label("editcourse"); ?>');
                $('#course_form')[0].reset();
                $('#operation').val("Edit");
                $('#div_cospicupload').show();
                $('#div_cospicview').hide();
                var approvechk = 0;
            $.ajax({
              url:"<?=base_url()?>index.php/querydata/query_course",
              method:"POST",
              data:{cos_id:cos_id},
              dataType:"json",
              success:function(data)
              {
                $("#home").find("input,select,textarea,button").prop("disabled",false);
                $("#profile").find("input,select,textarea,button").prop("disabled",false);
                <?php if($user['u_id']!="1"){ ?>
                if(data.cos_approve=="1"){
                $("#home").find("input,select,textarea,button").prop("disabled",true);
                $("#profile").find("input,select,textarea,button").prop("disabled",true);
                //$("#home").children().prop('disabled',true);
                $('.btn_maincourse').hide();
                $('#div_cospicupload').hide();
                $('#div_cospicview').show();
                approvechk = 1;
                }else{
                  $('.btn_maincourse').show();
                }
                <?php }else{ ?>
                  $('.btn_maincourse').show();
                <?php } ?>
                //document.getElementById('nav-item_document').style.display = '';
                $('#goal_score').val(data.goal_score);
                $('#seat_count').val(data.seat_count);
                $('#cos_expire_noti').val(data.cos_expire_noti);
                $('#cos_pic_ori').val(data.cos_pic);
                $('#ccode').val(data.ccode);


                $('#cos_hour').val(data.cos_hour);
                $('#cos_typegrading').val(data.cos_typegrading);
                //cos_typegrading_onchange(data.cos_typegrading);
                  $("#badges_condition").html('');
                if(data.cos_typegrading=="1"){
                  $("#badges_condition").append('<option value="A">A</option>');
                  $("#badges_condition").append('<option value="B">B</option>');
                  $("#badges_condition").append('<option value="C">C</option>');
                  $("#badges_condition").append('<option value="D">D</option>');
                  $('.typegrading_a').show();
                  $('.typegrading_b').hide();
                }else{
                  $("#badges_condition").append('<option value="P"><?php echo label('pass'); ?></option>');
                  $("#badges_condition").append('<option value="F"><?php echo label('fail'); ?></option>');
                  $('.typegrading_a').hide();
                  $('.typegrading_b').show();
                }
                if(data.isTH=="1"){
                    document.getElementById("cos_lang_th").checked = true;
                    chkbox_lang('cos_lang_th','input_th','cname_');
                    $('#cname_th').val(data.cname_th);
                    $('#sub_description_th').val(data.sub_description_th);
                    if(approvechk==1){
                    $('#cdesc_th').val(data.cdesc_th);
                    }else{
                    textarea_tinymce('cdesc_th','1');
                    $('#cdesc_th').html(data.cdesc_th);
                    //$(tinymce.get('cdesc_th').getBody()).html(data.cdesc_th);
                    }
                }else{
                    document.getElementById("cos_lang_th").checked = false;
                    $('.input_th').hide();
                }
                if(data.isENG=="1"){
                    document.getElementById("cos_lang_eng").checked = true;
                    chkbox_lang('cos_lang_eng','input_eng','cname_');
                    $('#cname_eng').val(data.cname_eng);
                    $('#sub_description_eng').val(data.sub_description_eng);
                    if(approvechk==1){
                      $('#cdesc_eng').val(data.cdesc_eng);
                    }else{
                      textarea_tinymce('cdesc_eng','1');
                      $('#cdesc_eng').html(data.cdesc_eng);
                      //$(tinymce.get('cdesc_eng').getBody()).html(data.cdesc_eng);
                    }
                }else{
                    document.getElementById("cos_lang_eng").checked = false;
                    $('.input_eng').hide();
                }
                if(data.cos_status=="1"){
                    document.getElementById("cos_status").checked = true;
                }else{
                    document.getElementById("cos_status").checked = false;
                }
                if(data.cos_iscutgrade=="1"){
                    document.getElementById("cos_iscutgrade").checked = true;
                }else{
                    document.getElementById("cos_iscutgrade").checked = false;
                }
                if(data.cos_ispassquizendcos=="1"){
                    document.getElementById("cos_ispassquizendcos").checked = true;
                }else{
                    document.getElementById("cos_ispassquizendcos").checked = false;
                }
                clear_dropify('path_file');
                clear_dropify('badges_img');
                /*if(data.cos_public=="0"){
                    document.getElementById("chk_cos_public").checked = true;
                }else{
                    document.getElementById("chk_cos_public").checked = false;
                }*/
                //$("#fil_lang").val($("#fil_lang option:first").val());

                <?php if($com_admin=="com_central"){ ?>
                  $.ajax({
                        url: '<?=base_url()?>index.php/querydata/recheckcompany',
                        type: 'POST',
                        data:{com_id:data.com_id},
                        success: function(data_company){
                          $('#com_id').html(data_company);
                          //$('#com_id').val(data.com_id).trigger('change');
                        }
                  });
                <?php }else{ ?>
                  $('#com_id').val(data.com_id);
                <?php } ?>

                      $.ajax({
                            url: '<?=base_url()?>index.php/querydata/recheckgroupcosmulti',
                            type: 'POST',
                            data:{cg_id:'',com_id:data.com_id,cos_id:cos_id},
                            success: function(data_cg){
                              $('#cg_id').html(data_cg);
                            }
                      });
                /*$.ajax({
                      url: '<?=base_url()?>index.php/querydata/recheckgroupcosmulti',
                      type: 'POST',
                      data:{cg_id:data.cg_id,com_id:data.com_id,cos_id:cos_id},
                      success: function(data_cg){
                        $('#cg_id').html(data_cg);
                      }
                });*/
                        $.ajax({
                              url: '<?=base_url()?>index.php/querydata/recheckcondition',
                              type: 'POST',
                              data:{com_id:data.com_id,cos_id:cos_id,condition:data.condition},
                              success: function(datacondition){
                                $('#condition').html(datacondition);
                              }
                        });
                  $.ajax({
                        url: '<?=base_url()?>index.php/querydata/rechecktypecos',
                        type: 'POST',
                        data:{tc_id:data.tc_id,com_id:data.com_id},
                        success: function(data_typecos){
                          $('#tc_id').html(data_typecos);
                          $('#tc_id').val(data.tc_id).trigger('change');
                        }
                  });
                if(data.cos_pic!=""){
                    var nameImage = "<?php echo REAL_PATH;?>/uploads/course/"+data.cos_pic
                    var drEvent = $('#cos_pic').dropify(
                    {
                      defaultFile: nameImage
                    });
                    drEvent = drEvent.data('dropify');
                    drEvent.resetPreview();
                    drEvent.clearElement();
                    drEvent.settings.defaultFile = nameImage;
                    drEvent.destroy();
                    drEvent.init();

                    var drEvent = $('.dropify_main').dropify({
                        defaultFile: "<?php echo REAL_PATH;?>/uploads/course/"+data.cos_pic ,
                    });

                    drEvent.on('dropify.beforeClear', function(event, element){
                            $('#cos_pic_ori').val("");
                            return true; 
                    });
                    $("#view_img_cos").attr("src","<?php echo REAL_PATH;?>/uploads/course/"+data.cos_pic);
                }else{
                    $('.dropify_main').dropify();
                    $('#div_cospicview').hide();
                }

                $('#cos_id').val(data.cos_id);

                cos_id = data.cos_id;
                $.ajax({
                  url:"<?=base_url()?>index.php/querydata/update_cert_data",
                  method:"POST",
                  data:{cos_id:cos_id},
                  dataType:"json",
                  success:function(datacert)
                  {
                    if(datacert!=null){
                        $('#badges_name').val(datacert.badges_name);
                        $('#badges_condition').val(datacert.badges_condition);
                        $('#badges_img_ori').val(datacert.badges_img);
                        $('#badges_desc').val(datacert.badges_desc);
                        if(datacert.badges_img!=""){
                            var nameImage = "<?php echo REAL_PATH;?>/uploads/badges/"+datacert.badges_img
                            var drEvent = $('#badges_img').dropify(
                            {
                              defaultFile: nameImage
                            });
                            drEvent = drEvent.data('dropify');
                            drEvent.resetPreview();
                            drEvent.clearElement();
                            drEvent.settings.defaultFile = nameImage;
                            drEvent.destroy();
                            drEvent.init();
                            var drEvent = $('#badges_img').dropify({
                                defaultFile: "<?php echo REAL_PATH;?>/uploads/badges/"+datacert.badges_img ,
                            });
                            drEvent.on('dropify.beforeClear', function(event, element){
                                    $('#badges_img_ori').val("");
                                    return true; 
                            });
                        }else{
                            $('#badges_img').dropify();
                        }
                    }else{
                            $('#badges_img').dropify();
                    }
                  }
                });
                $.ajax({
                  url:"<?=base_url()?>index.php/querydata/update_score_data",
                  method:"POST",
                  data:{cos_id:cos_id},
                  dataType:"json",
                  success:function(data_score)
                  {
                        if(data.cos_typegrading=="2"){
                          $('#mina_b').val(data_score.mina);
                        }else{
                          $('#mina').val(data_score.mina);
                          $('#minb').val(data_score.minb);
                          $('#minc').val(data_score.minc);
                          $('#mind').val(data_score.mind);
                        }
                  }
                });
              }
            });
            
          });

    });
    $(document).on('submit', '#period_and_permission_form', function(event){
              event.preventDefault(); 
                $("#myModal_process").addClass("in");
                $("body").addClass("modal-open");
                $("#myModal_process").css("display","block");
                $("#myModal_process").modal({backdrop: false});
                var cos_id = $('#course_id_pp').val();

                var date_start_var = $('#date_start_var').val();
                var time_start = $('#time_start').val();
                if(time_start==""){
                  time_start = "00:00";
                }
                var date_end_var = $('#date_end_var').val();
                var time_end = $('#time_end').val();
                if(time_end==""){
                  time_end = "00:00";
                }
                var val_chk = 1;
                var date_start = $('#date_start').val();
                var date_end = $('#date_end').val();
                if(date_start!=""||date_end!=""){
                  if(date_start!=""&&date_end!=""){
                    date_start_var = date_start_var+" "+time_start+":00";
                    date_end_var = date_end_var+" "+time_end+":00";
                    start_date = date_start_var.replace(/-/g, "/");
                    end_date = date_end_var.replace(/-/g, "/");
                    var d_start = new Date(start_date);
                    var d_end = new Date(end_date);
                    if(date_start_var==date_end_var){
                      $('#time_end').focus();
                      val_chk = 0;
                    }else if(d_start>d_end){
                      $('#date_end').val("");
                      $('#date_end_var').val("");
                      $('#date_end').focus();
                      val_chk = 0;
                    }
                  }else if(date_start==""&&date_end!=""){
                    $('#date_start').focus();
                    val_chk = 0;
                  }else if(date_start!=""&&date_end==""){
                    $('#date_end').focus();
                    val_chk = 0;
                  }
                }
                if(val_chk==1){
                  $.ajax({
                    url:"<?=base_url()?>index.php/insertdata/insert_periodandpermission",
                    method:'POST',
                    data:new FormData(this),
                    contentType:false,
                    processData:false,
                    dataType:'json',
                    success:function(data)
                    {
                        $("body").removeClass("modal-open");
                        $("#myModal_process").removeClass("in");
                        $("#myModal_process").css("display","none");
                      topFunction();
                      if(data.status=="2"){
                          //$('#period_and_permission_form')[0].reset();
                          swal(
                              '<?php echo label("com_msg_success"); ?>',
                              '',
                              'success'
                          ).then(function () {
                            $('#div_create_pp').show();
                            //$('#div_pp').show();
                            $('#course_id_pp').val(cos_id);
                            //$('#operation_pp').val('Add');
                            //fetch_data_detail(cos_id);
                          })
                      }else if(data.status=="1"){
                          swal({
                              title: '<?php echo label("data_msg_duplicate"); ?>',
                              text: "",
                              type: 'warning',
                              showCancelButton: false,
                              confirmButtonClass: 'btn btn-primary',
                              confirmButtonText: '<?php echo label("m_ok"); ?>'
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
                        $("body").removeClass("modal-open");
                        $("#myModal_process").removeClass("in");
                        $("#myModal_process").css("display","none");
                        topFunction();
                        swal({
                            title: '<?php echo label("com_msg_error_save"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        })
                }
                /**/
            });


        $(document).on('click', '.update_period', function(){
            var cosde_id = $(this).attr("id");
            var cos_id = $('#course_id_pp').val();
            var com_id = $('#com_id_search').val();

            $('#period_and_permission_form')[0].reset();
            $('#operation_pp').val("Edit");
            $('#cosde_id').val(cosde_id);

            $.ajax({
                  url: '<?=base_url()?>index.php/querydata/permission_course',
                  type: 'POST',
                  data:{cos_id:cos_id,com_id:com_id},
                  success: function(data){
                    
                    $('#permission_div').html(data);
                  }
            });

                $('#txthead_period').text('<?php echo label("edit_period_and_permission"); ?>');
                from = $('#date_start').datepicker({
                        language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                        thaiyear: true,  
                        format: 'dd/mm/yyyy',
                        autoclose: true
                }).on('changeDate', function (selected) {
                    $('#date_end').val('');
                    $('#date_start').datepicker("update", selected.date);
                         to = $('#date_end').datepicker({
                                  <?php if($lang=="thai"){ ?>
                                        language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                                        thaiyear: true,  
                                  <?php } ?>
                                format: 'dd/mm/yyyy',
                                autoclose: true
                        }).datepicker('setStartDate', selected.date).focus().on('changeDate', function (selected) {
                                var maxDate = new Date(selected.date.valueOf()).toLocaleString("en-US", {timeZone: "Asia/Bangkok"});
                                var date_val = moment(maxDate).format('YYYY-MM-DD');
                                var res_date = date_val.split("-");
                                maxDate = res_date[2]+"/"+res_date[1]+"/"+(parseInt(res_date[0]));
                                $('#date_start').datepicker('setEndDate', maxDate);
                            });
                });
                 to = $('#date_end').datepicker({
                                  <?php if($lang=="thai"){ ?>
                                        language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                                        thaiyear: true,  
                                  <?php } ?>
                        format: 'dd/mm/yyyy',
                        autoclose: true
                }).on('changeDate', function (selected) {
                    $('#date_end').datepicker("update", selected.date);
                        var maxDate = new Date(selected.date.valueOf()).toLocaleString("en-US", {timeZone: "Asia/Bangkok"});
                        var date_val = moment(maxDate).format('YYYY-MM-DD');
                        var res_date = date_val.split("-");
                        maxDate = res_date[2]+"/"+res_date[1]+"/"+(parseInt(res_date[0]));
                        $('#date_start').datepicker('setEndDate', maxDate);
                    });
            $.ajax({
                  url:"<?=base_url()?>index.php/querydata/update_course_detail_data",
                  method:"POST",
                  data:{cosde_id:cosde_id},
                  dataType:"json",
                  success:function(data)
                  {
                        if(data.cosde_status=="1"){
                          $("#cosde_status").attr("checked", true);
                        }else{
                          $("#cosde_status").attr("checked", false);
                        }
                        $('#date_start_var').val(data.date_start_var);
                        $('#date_end_var').val(data.date_end_var);
                        $('#time_start').val(data.time_start);
                        $('#time_end').val(data.time_end);
                        $('#get_point').val(data.get_point);
                        $('#point_redeem').val(data.point_redeem);
                        if(data.date_start!=""&&data.date_end!=""){
                          $("#date_start").datepicker("update", data.date_start); 
                          $("#date_end").datepicker("update", data.date_end); 
                        }else{
                          $('#date_start').val('');
                          $('#date_end').val('');
                        }
                  }
            });
            //display_style('div_create_pp','div_pp');
        });


         $(document).on('click', '.delete_period', function(){
            var cosde_id = $(this).attr("id");
            swal({
                title: '<?php echo label('wg_delete_msg'); ?> ',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",   
                confirmButtonText: '<?php echo label('wg_delete'); ?>',
                cancelButtonText: '<?php echo label('cancel'); ?>'
            }).then(function (isChk) {
              if(isChk.value){
                $.ajax({
                    url:"<?=base_url()?>index.php/manage/delete_cosdetail_data",
                    method:"POST",
                    data:{cosde_id:cosde_id},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("com_msg_delete"); ?>',
                            '',
                            'success'
                        ).then(function () {
                            var cos_id = $('#course_id_pp').val();
                            fetch_data_detail(cos_id);
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
         $('select[name="type_media"]').on('change', function(){
          var type_media = $(this).val();
          if(type_media=='1'){
            $('#input-file-now-custom-document').val('');
            document.getElementById('div_multifile_url').style.display = '';
            document.getElementById('div_multifile_upload_file').style.display = 'none';
            document.getElementById('cond_seekbar').style.display = 'none';
          }else if(type_media=='2'){
            document.getElementById('div_multifile_url').style.display = 'none';
            document.getElementById('div_multifile_upload_file').style.display = '';
            document.getElementById('cond_seekbar').style.display = '';
          }else{
            document.getElementById('div_multifile_url').style.display = 'none';
            document.getElementById('div_multifile_upload_file').style.display = 'none';
            document.getElementById('cond_seekbar').style.display = 'none';
          }
          var cos_id = $('#course_id_pp').val();

              $.ajax({
                      url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                      type: 'POST',
                      data:{cos_id:cos_id,les_lang:''},
                      dataType:"json",
                      success: function(data){
                        var th_select = 0;
                        var eng_select = 0;
                        for (var i = data.arr_lang.length - 1; i >= 0; i--) {
                          if(data.arr_lang[i]=="th"){
                            th_select = 1;
                          }
                          if(data.arr_lang[i]=="eng"){
                            eng_select = 1;
                          }
                        }
                        if(type_media=='2'){
                            if(th_select==1){
                              document.getElementById("med_name_th").required = true;
                            }
                            if(eng_select==1){
                              document.getElementById("med_name_eng").required = true;
                            }
                        }else{
                            if(th_select==1){
                              document.getElementById("med_name_th").required = false;
                            }
                            if(eng_select==1){
                              document.getElementById("med_name_eng").required = false;
                            }
                        }
                      }
                });
        });
        $(document).on('click', '.add_file_lesson', function(){
          var count_file = parseInt($('#count_file').val());
          var cos_id = $('#course_id_pp').val();
          count_file++;
          $('#count_file').val(count_file);
          $('#tb_document').show();
              $.ajax({
                      url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                      type: 'POST',
                      data:{cos_id:cos_id,les_lang:''},
                      dataType:"json",
                      success: function(data){
                        var th_select = 0;
                        var eng_select = 0;
                        for (var i = data.arr_lang.length - 1; i >= 0; i--) {
                          if(data.arr_lang[i]=="th"){
                            th_select = 1;
                          }
                          if(data.arr_lang[i]=="eng"){
                            eng_select = 1;
                          }
                        }
                        input_th = '<td><input type="text" class="form-control" name="name_file_th[]" required id="name_file_th"></td>';
                        input_eng = '<td><input type="text" class="form-control" name="name_file_eng[]" required id="name_file_eng"></td>';
                        if(th_select==0){
                            input_th = '';
                        }
                        if(eng_select==0){
                            input_eng = '';
                        }
                        $('#myTable_document tr:last').after('<tr id="row_'+count_file+'" class="row_document"><td align="center"><button name="del_row_lessonfile" id="row_'+count_file+'" title="<?php echo label('delete'); ?>" class="btn btn-sm btn-danger waves-effect waves-light del_row_lessonfile" onclick="return false;"><i class="mdi mdi-window-close"></i></button></td>'+input_th+input_eng+'<td><input type="file" name="path_file[]" required id="path_file" accept=".xlsx,.xls,.doc, .docx,.ppt, .pptx,.pdf"  onchange="ValidateSingleInput(this);"/><input type="hidden" id="path_file_ori_'+count_file+'" name="path_file_ori[]" value=""><input type="hidden" id="id_fil_'+count_file+'" name="id_fil[]" value=""></td></tr>');
                      }
                });
        });


        $(document).on('click', '.del_row_lessonfile', function(){
          var id = $(this).attr("id");
          
          var id_fil = $('#id_fil_'+id.substr(4)).val();
          var id_filedit = $('#id_filedit_'+id.substr(4)).val();
          if(id_filedit!=""){
            swal({
                title: '<?php echo label('wg_delete_msg'); ?> ',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: '<?php echo label('wg_delete'); ?>',
                cancelButtonText: '<?php echo label("m_cancel"); ?>'
            }).then(function (isChk) {
              if(isChk.value){
                  $('#'+id).remove();
                          var tb_document = $('input[name="path_file[]"]').length;
                          var tb_document_edit = $('input[name="path_file_oriedit[]"]').length;
                          if(tb_document==0&&tb_document_edit==0){
                              $('#tb_document').hide();
                          }else{
                              $('#tb_document').show();
                          }
                  $.ajax({
                      url:"<?=base_url()?>index.php/course/delete_data",
                      method:"POST",
                      data:{id_delete:id_filedit,field:"id",table_name:"LMS_FIL"},
                      dataType:"json",
                      success:function(data)
                      {
                      }
                  });
              }
            });
          }else{
             $('#'+id).remove();
          }
        });


         $(document).on('click', '.delete_media', function(){
            var id = $(this).attr("id");
            var cos_id = $('#course_id_lesson').val();
            var les_id = $('#les_id').val();
            swal({
                title: '<?php echo label('wg_delete_msg'); ?> ',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: '<?php echo label('wg_delete'); ?>',
                cancelButtonText: '<?php echo label("m_cancel"); ?>'
            }).then(function (isChk) {
              if(isChk.value){
                $.ajax({
                    url:"<?=base_url()?>index.php/course/delete_data",
                    method:"POST",
                    data:{id_delete:id,table_name:"LMS_MED",field:"id"},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("com_msg_delete"); ?>',
                            '',
                            'success'
                        ).then(function () {
                            var table_media = $('#myTable_media').DataTable();
                            var info_media = table_media.page.info();
                            var length_media = info_media.pages;
                            var page_current_media = info_media.page;
                            fetch_data_media(les_id,page_current_media);
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

        $(document).on('submit', '#lesson_form', function(event){
              event.preventDefault();
                $("#myModal_process").addClass("in");
                $("body").addClass("modal-open");
                $("#myModal_process").css("display","block");
                $("#myModal_process").modal({backdrop: false});
                var course_id = $('#course_id_lesson').val();
                var date_start_les_var = $('#date_start_les_var').val();
                var time_start = $('#time_start_les').val();
                if(time_start==""){
                  time_start = "00:00";
                }
                var date_end_les_var = $('#date_end_les_var').val();
                var time_end = $('#time_end_les').val();
                if(time_end==""){
                  time_end = "00:00";
                }
                var val_chk = 1;
                var start_les = $('#date_start_les').val();
                var end_les = $('#date_end_les').val();
                if(start_les!=""||end_les!=""){
                  if(start_les!=""&&end_les!=""){
                    date_start_les_var = date_start_les_var+" "+time_start+":00";
                    date_end_les_var = date_end_les_var+" "+time_end+":00";
                    start_date = date_start_les_var.replace(/-/g, "/");
                    end_date = date_end_les_var.replace(/-/g, "/");
                    var d_start = new Date(start_date);
                    var d_end = new Date(end_date);
                    if(date_start_les_var==date_end_les_var){
                      $('#time_end_les').focus();
                      val_chk = 0;
                    }else if(d_start>d_end){
                      $('#date_end_les').val("");
                      $('#date_end_les_var').val("");
                      $('#date_end_les').focus();
                      val_chk = 0;
                    }
                  }else if(start_les==""&&end_les!=""){
                    $('#date_start_les').focus();
                    val_chk = 0;
                  }else if(start_les!=""&&end_les==""){
                    $('#date_end_les').focus();
                    val_chk = 0;
                  }
                }
                if(val_chk==1){
                      $.ajax({
                        url:"<?=base_url()?>index.php/insertdata/insert_lesson",
                        method:'POST',
                        data:new FormData(this),
                        contentType:false,
                        processData:false,
                        dataType:"json",
                        success:function(data)
                        {
                            $("body").removeClass("modal-open");
                            $("#myModal_process").removeClass("in");
                            $("#myModal_process").css("display","none");
                          topFunction();
                          if(data.status=="2"){
                              swal(
                                  '<?php echo label("com_msg_success"); ?>',
                                  '',
                                  'success'
                              ).then(function () {
                                  $('#lesson_form')[0].reset();
                                  display_style('div_create_lesson','div_lesson');
                                  $('#course_id_lesson').val(course_id);

                                  $('.dropify').dropify();
                                  $('.dropify_main').dropify();
                                  var table_les = $('#myTable_lesson').DataTable();
                                  var info_les = table_les.page.info();
                                  var length_les = info_les.pages;
                                  var page_current_les = info_les.page;
                                  fetch_data_lesson(course_id,page_current_les);
                              })
                          }else if(data.status=="1"){
                              swal({
                                  title: '<?php echo label("data_msg_duplicate"); ?>',
                                  text: "",
                                  type: 'warning',
                                  showCancelButton: false,
                                  confirmButtonClass: 'btn btn-primary',
                                  confirmButtonText: '<?php echo label("m_ok"); ?>'
                              }).then(function () {
                                  $('#lesson_form')[0].reset();
                                  $('#course_id_lesson').val(course_id);
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

                        },
                            error: function (jqXHR, exception) {
                            $("body").removeClass("modal-open");
                            $("#myModal_process").removeClass("in");
                            $("#myModal_process").css("display","none");
                                topFunction();
                                var msg = '';
                                if (jqXHR.status === 0) {
                                    msg = 'Not connect.\n Verify Network.';
                                } else if (jqXHR.status == 404) {
                                    msg = 'Requested page not found. [404]';
                                } else if (jqXHR.status == 500) {
                                    msg = 'Internal Server Error [500].';
                                } else if (exception === 'parsererror') {
                                    msg = 'Requested JSON parse failed.';
                                } else if (exception === 'timeout') {
                                    msg = 'Time out error.';
                                } else if (exception === 'abort') {
                                    msg = 'Ajax request aborted.';
                                } else {
                                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                                }
                                swal({
                                    title: msg,
                                    text: "",
                                    type: 'warning',
                                    showCancelButton: false,
                                    confirmButtonClass: 'btn btn-primary',
                                    confirmButtonText: '<?php echo label("m_ok"); ?>'
                                })
                            },
                      });
                }else{
                        $("body").removeClass("modal-open");
                        $("#myModal_process").removeClass("in");
                        $("#myModal_process").css("display","none");
                        topFunction();
                        swal({
                            title: '<?php echo label("com_msg_error_save"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        })
                }
        });

        $(document).on('click', '.update_lesson', function(){
            var les_id = $(this).attr("id");
            $('#txthead_lesson').text('<?php echo label("edit_lesson"); ?>');
            $('#operation_lesson').val("Edit");
            $('#les_id').val(les_id);

            $('#txt_scormoriginal').text('');
            clear_dropify('media_file');
            clear_dropify('thumbnail_med');
            //clear_dropify('input-file-now-custom-document');
            clear_dropify('scorm_file');
                $(function () {
                  from = $('#date_start_les').datepicker({
                                  <?php if($lang=="thai"){ ?>
                                        language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                                        thaiyear: true,  
                                  <?php } ?>
                          format: 'dd/mm/yyyy',
                          autoclose: true
                  }).on('changeDate', function (selected) {
                      $('#date_end_les').datepicker('setStartDate', selected.date);
                      $("#date_end_les").datepicker( "setDate", selected.date);
                  });

                  to = $('#date_end_les').datepicker({
                                  <?php if($lang=="thai"){ ?>
                                        language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                                        thaiyear: true,  
                                  <?php } ?>
                          format: 'dd/mm/yyyy',
                          autoclose: true
                  })
                })

            $('table#myTable_document tr.row_document').remove();

            val_lang('0','input_les_th','les_name_','th');
            val_lang('0','input_les_eng','les_name_','eng');
            document.getElementById("les_name_th").required = false;
            document.getElementById("les_name_eng").required = false;
            $.ajax({
                url:"<?=base_url()?>index.php/querydata/query_lesson",
                method:"POST",
                data:{les_id:les_id},
                dataType:"json",
                success:function(data_les)
                {


                      $.ajax({
                            url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                            type: 'POST',
                            data:{cos_id:data_les.cos_id,les_lang:''},
                            dataType:"json",
                            success: function(data){
                              for (var i = data.arr_lang.length - 1; i >= 0; i--) {
                                if(data.arr_lang[i]=="th"){
                                  val_lang('1','input_les_th','les_name_','th');
                                  textarea_tinymce('les_info_th','1');
                                  $(tinymce.get('les_info_th').getBody()).html(data_les.les_info_th);
                                  $('#les_name_th').val(data_les.les_name_th);
                                  $('#les_info_th').val(data_les.les_info_th);
                                }
                                if(data.arr_lang[i]=="eng"){
                                  val_lang('1','input_les_eng','les_name_','eng');
                                  textarea_tinymce('les_info_eng','1');
                                  $(tinymce.get('les_info_eng').getBody()).html(data_les.les_info_eng);
                                  $('#les_name_eng').val(data_les.les_name_eng);
                                  $('#les_info_eng').val(data_les.les_info_eng);
                                }
                              }
                              $('#les_lang').val(data.val_lang);
                                //$('#les_lang').html(data);
                                //$('#les_lang').val($('#les_lang option:first-child').val()).trigger('change');
                            }
                      });
                      $.ajax({
                          url: '<?=base_url()?>index.php/querydata/query_course_detail_data',
                          type: 'POST',
                          data:{cos_id:data_les.cos_id},
                          dataType:"json",
                          success: function(datasetDate){
                            if(datasetDate.isData=="1"){
                                var start_date = datasetDate.date_start_var.split("-");
                                var StartDate = start_date[2]+"/"+start_date[1]+"/"+(parseInt(start_date[0]));
                                var end_date = datasetDate.date_end_var.split("-");
                                var EndDate = end_date[2]+"/"+end_date[1]+"/"+(parseInt(end_date[0]));
                                $('#date_start_les').datepicker('setStartDate', StartDate);
                                $('#date_end_les').datepicker('setStartDate', StartDate);
                                $('#date_end_les').datepicker('setEndDate', EndDate);
                                $('#date_start_les').datepicker('setEndDate', EndDate);
                                //$( "#date_start_les" ).datepicker( "setDate", StartDate);
                            }else{                              
                              var startDate = new Date();
                              $('#date_start_les').datepicker('setStartDate', startDate);
                              $('#date_end_les').datepicker('setStartDate', startDate);
                            }
                          }
                        });

                        if(data_les.les_status=="0"){
                            document.getElementById("status_les").checked = false;
                        }else{
                            document.getElementById("status_les").checked = true;
                        }
                    $('#course_id_lesson').val(data_les.cos_id);
                    if(data_les.scm_type=="0"){
                        document.getElementById("radio_scm_type1").checked = true;
                    }else if(data_les.scm_type=="1"){
                        document.getElementById("radio_scm_type2").checked = true;
                    }else if(data_les.scm_type=="2"){
                        document.getElementById("radio_scm_type3").checked = true;
                    }
                    if(data_les.les_type=="1"){
                        document.getElementById("les_type").checked = false;
                        document.getElementById('div_media').style.display = '';
                        document.getElementById('div_scorm').style.display = 'none';
                        if(parseInt(data_les.num_fil)==0){
                          $('#tb_document').hide();
                          $('#tb_document_body').html('');
                        }else{
                          $('#tb_document').show();
                          $.ajax({
                                url:"<?=base_url()?>index.php/course/query_fil_lesson",
                                method:"POST",
                                data:{les_id:les_id},
                                success:function(data_doc)
                                {
                                    $('#tb_document_body').html(data_doc);
                                }
                          });
                        }
                    }else{
                        document.getElementById("les_type").checked = true;
                        document.getElementById('div_media').style.display = 'none';
                        document.getElementById('div_scorm').style.display = '';
                        if(data_les.scorm['path']!=""){
                            $('#txt_scormoriginal').text("File Scorm Original : "+data_les.scorm['path']);
                        }else{
                            $('#txt_scormoriginal').text('');
                        }
                    }
                    changeValEnableDivMedia();
                    $('#date_start_les_var').val(data_les.date_start_les_var);
                    $('#time_start_les').val(data_les.time_start_les);
                    $('#date_end_les_var').val(data_les.date_end_les_var);
                    $('#time_end_les').val(data_les.time_end_les);
                    $('#count_file').val(data_les.num_fil);

                    if(data_les.time_start!=""&&data_les.time_end!=""){
                      $( "#date_start_les" ).datepicker( "setDate", data_les.time_start);
                      $( "#date_end_les" ).datepicker( "setDate", data_les.time_end);
                    }else{
                        $('#date_start_les').val('');
                        $('#date_end_les').val('');
                    }


                        if(data_les.url!=""){
                            $('#type_media').val("1");
                            $("#url_media").val(data_les.url);
                            document.getElementById('div_multifile_url').style.display = '';
                            document.getElementById('div_multifile_upload_file').style.display = 'none';
                            document.getElementById('cond_seekbar').style.display = 'none';
                        }
                        /*if(data_les.document.length>0){
                            fetch_data_les_document(les_id);
                            document.getElementById('tb_document').style.display = '';
                        }else{
                            document.getElementById('tb_document').style.display = 'none';
                        }*/
                        if(data_les.upload&&data_les.upload.length>0){
                            $('#type_media').val("2");
                            document.getElementById('div_multifile_url').style.display = 'none';
                            document.getElementById('div_multifile_upload_file').style.display = '';
                            document.getElementById('cond_seekbar').style.display = '';
                            var table_media = $('#myTable_media').DataTable();
                            var info_media = table_media.page.info();
                            var length_media = info_media.pages;
                            var page_current_media = info_media.page;
                            fetch_data_media(les_id,page_current_media);
                            document.getElementById('tb_media').style.display = '';
                        }else{
                            document.getElementById('tb_media').style.display = 'none';
                        }
                }
            });
            display_style('div_create_lesson','div_lesson');
        });

                          
        function fetch_data_media(les_id,page_num)
         {
            $('#myTable_media').DataTable().destroy();
            var table = $('#myTable_media').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/course/fetch_lesson_media/',
                    data : {les_id:les_id},
                    type : 'GET'
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

         $(document).on('click', '.delete_lesson', function(){
            var id = $(this).attr("id");
            var cos_id = $('#course_id_pp').val();
            swal({
                title: '<?php echo label('wg_delete_msg'); ?> ',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: '<?php echo label('wg_delete'); ?>',
                cancelButtonText: '<?php echo label("m_cancel"); ?>'
            }).then(function (isChk) {
              if(isChk.value){
                $.ajax({
                    url:"<?=base_url()?>index.php/manage/delete_lesson",
                    method:"POST",
                    data:{les_id:id},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("com_msg_delete"); ?>',
                            '',
                            'success'
                        ).then(function () {
                            fetch_data_lesson(cos_id,0);
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
        
        $(document).on('submit', '#quiz_form', function(event){
              event.preventDefault();
              var course_id = $('#course_id_quiz').val();
              document.getElementById('div_quiz_detail').style.display = 'none';

                var period_open_var = $('#period_open_var').val();
                var time_start = $('#time_start_quiz').val();
                if(time_start==""){
                  time_start = "00:00";
                }
                var period_end_var = $('#period_end_var').val();
                var time_end = $('#time_end_quiz').val();
                if(time_end==""){
                  time_end = "00:00";
                }
                var val_chk = 1;
                var period_open = $('#period_open').val();
                var period_end = $('#period_end').val();
                if(period_open!=""||period_end!=""){
                  if(period_open!=""&&period_end!=""){
                    period_open_var = period_open_var+" "+time_start+":00";
                    period_end_var = period_end_var+" "+time_end+":00";
                    start_date = period_open_var.replace(/-/g, "/");
                    end_date = period_end_var.replace(/-/g, "/");
                    var d_start = new Date(start_date);
                    var d_end = new Date(end_date);
                    if(period_open_var==period_end_var){
                      $('#time_end_quiz').focus();
                      val_chk = 0;
                    }else if(d_start>d_end){
                      $('#period_end').val("");
                      $('#period_end_var').val("");
                      $('#period_end').focus();
                      val_chk = 0;
                    }
                  }else if(period_open==""&&period_end!=""){
                    $('#period_open').focus();
                    val_chk = 0;
                  }else if(period_open!=""&&period_end==""){
                    $('#period_end').focus();
                    val_chk = 0;
                  }
                }

                if(val_chk==1){
                      $.ajax({
                        url:"<?=base_url()?>index.php/insertdata/insert_quiz",
                        method:'POST',
                        data:new FormData(this),
                        contentType:false,
                        processData:false,
                        dataType:"json",
                        success:function(data)
                        {
                          if(data.status=="2"){
                              swal(
                                  '<?php echo label("com_msg_success"); ?>',
                                  '',
                                  'success'
                              ).then(function () {
                                  $('#quiz_form')[0].reset();
                                  display_style('div_create_quiz','div_quiz');
                                  $('#course_id_quiz').val(course_id);
                                  var table_quiz = $('#myTable_quiz').DataTable();
                                  var info_quiz = table_quiz.page.info();
                                  var length_quiz = info_quiz.pages;
                                  var page_current_quiz = info_quiz.page;
                                  fetch_data_quiz(course_id,page_current_quiz);
                              })
                          }else if(data.status=="1"){
                              swal({
                                  title: '<?php echo label("data_msg_duplicate"); ?>',
                                  text: "",
                                  type: 'warning',
                                  showCancelButton: false,
                                  confirmButtonClass: 'btn btn-primary',
                                  confirmButtonText: '<?php echo label("m_ok"); ?>'
                              }).then(function () {
                                  $('#quiz_form')[0].reset();
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

                        },
                            error: function (jqXHR, exception) {
                                topFunction();
                                var msg = '';
                                if (jqXHR.status === 0) {
                                    msg = 'Not connect.\n Verify Network.';
                                } else if (jqXHR.status == 404) {
                                    msg = 'Requested page not found. [404]';
                                } else if (jqXHR.status == 500) {
                                    msg = 'Internal Server Error [500].';
                                } else if (exception === 'parsererror') {
                                    msg = 'Requested JSON parse failed.';
                                } else if (exception === 'timeout') {
                                    msg = 'Time out error.';
                                } else if (exception === 'abort') {
                                    msg = 'Ajax request aborted.';
                                } else {
                                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                                }
                                swal({
                                    title: msg,
                                    text: "",
                                    type: 'warning',
                                    showCancelButton: false,
                                    confirmButtonClass: 'btn btn-primary',
                                    confirmButtonText: '<?php echo label("m_ok"); ?>'
                                })
                            },
                      });
                }else{
                        topFunction();
                        swal({
                            title: '<?php echo label("com_msg_error_save"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        })
                }
        });
        function onchk_lang_qiz(value){
            var cos_id = $('#course_id_pp').val();
                          $.ajax({
                            url:"<?=base_url()?>index.php/querydata/query_course",
                            method:"POST",
                            data:{cos_id:cos_id},
                            dataType:"json",
                            success:function(data_cos)
                            {
                              $.ajax({
                                url: '<?=base_url()?>index.php/workgroup/select_qize',
                                type: 'POST',
                                data:{com_id:data_cos.com_id,cos_lang:data_cos.cos_lang},
                                success: function(data){
                                  
                                  $('#qize_id').html(data);
                                }
                              });
                            }
                          });
        }

        $(document).on('click', '.criteria_score', function(){
            var qiz_id = $(this).attr("id");
            var com_id = $('#com_id_search').val();
            $('#qiz_id_criteriascore').val(qiz_id);
            $("#modal-criteria_score").modal({backdrop: false});
            $('#lv_id').prop('disabled', false);
            $.ajax({
              url: '<?=base_url()?>index.php/querydata/rechecklevelmulti_qiz',
              type: 'POST',
              data:{qiz_id:qiz_id,com_id:com_id,qizlv_id:""},
              success: function(data){
                  $('#lv_id').html(data);
              }
            });
            fetch_data_qizcriteria(0);
        });
        function clear_quizcriteria(){
            var com_id = $('#com_id_search').val();
            var qiz_id = $('#qiz_id_criteriascore').val();
            $('#criteria_score_form')[0].reset();
            $('#qiz_id_criteriascore').val(qiz_id);
            $('#lv_id').val('').trigger('change');
            $('#lv_id').prop('disabled', false);
                          $.ajax({
                            url: '<?=base_url()?>index.php/querydata/rechecklevelmulti_qiz',
                            type: 'POST',
                            data:{qiz_id:qiz_id,com_id:com_id,qizlv_id:""},
                            success: function(data){
                                $('#lv_id').html(data);
                            }
                          });
                          var table = $('#myTable_criteria_score').DataTable();
                          var info = table.page.info();
                          var length = info.pages;
                          var page_current = info.page;
                          fetch_data_qizcriteria(page_current);
        }

         $(document).on('click', '.delete_criteriascore', function(){
            var qizlv_id = $(this).attr("id");
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
                    url:"<?=base_url()?>index.php/manage/delete_criteriascore",
                    method:"POST",
                    data:{qizlv_id:qizlv_id},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("com_msg_delete"); ?>!',
                            '',
                            'success'
                        ).then(function () {
                          clear_quizcriteria();
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
          $(document).on('click', '.update_criteriascore', function(){
            var qizlv_id = $(this).attr("id");
            var com_id = $('#com_id_search').val();
            $.ajax({
              url:"<?=base_url()?>index.php/setting/update_criteriascore",
              method:"POST",
              data:{qizlv_id:qizlv_id},
              dataType:"json",
              success:function(data)
              {
                $('#criteria_score_form')[0].reset();
                $('#operation_criteriascore').val("Edit");
                $('#qiz_id_criteriascore').val(data.qiz_id);
                $('#qizlv_id').val(data.qizlv_id);
                $('#qizlv_goalscore').val(data.qizlv_goalscore);
                $.ajax({
                  url: '<?=base_url()?>index.php/querydata/rechecklevelmulti_qiz',
                  type: 'POST',
                  data:{qiz_id:data.qiz_id,com_id:com_id,lv_id:data.lv_id},
                  success: function(data_lv){
                      $('#lv_id').html(data_lv);
                  }
                });
                $('#lv_id').prop('disabled', true);
              }
            });
          });

        $(document).on('submit', '#criteria_score_form', function(event){
              var com_id = $('#com_id_search').val();
              var qiz_id = $('#qiz_id_criteriascore').val();
              event.preventDefault(); 
                $.ajax({
                  url:"<?=base_url()?>index.php/insertdata/insert_criteria_score",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  dataType:"json",
                  success:function(data)
                  {
                    if(data.status=="2"){
                        $('#criteria_score_form')[0].reset();
                        $('#qiz_id_criteriascore').val(qiz_id);
                        $('#lv_id').val('').trigger('change');
                        $('#lv_id').prop('disabled', false);
                        swal(
                            '<?php echo label("com_msg_success"); ?>!',
                            '',
                            'success'
                        ).then(function () {

                          $.ajax({
                            url: '<?=base_url()?>index.php/querydata/rechecklevelmulti_qiz',
                            type: 'POST',
                            data:{qiz_id:qiz_id,com_id:com_id,qizlv_id:""},
                            success: function(data){
                                $('#lv_id').html(data);
                            }
                          });
                          var table = $('#myTable_criteria_score').DataTable();
                          var info = table.page.info();
                          var length = info.pages;
                          var page_current = info.page;
                          fetch_data_qizcriteria(page_current);
                        })
                    }else if(data.status=="1"){
                        swal({
                            title: '<?php echo label("com_msg_duplicate"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
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
            });
        $(document).on('click', '.update_quiz', function(){
            var qiz_id = $(this).attr("id");
            document.getElementById('div_quiz_detail').style.display = 'none';
            document.getElementById('div_template_qize').style.display = '';
            
            $(".div_lastquiz").removeClass("col-md-4");
            $(".div_lastquiz").addClass("col-md-6");
                $(function () {
                  from = $('#period_open').datepicker({
                                  <?php if($lang=="thai"){ ?>
                                        language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                                        thaiyear: true,  
                                  <?php } ?>
                          format: 'dd/mm/yyyy',
                          autoclose: true
                  }).on('changeDate', function (selected) {
                      $('#period_end').datepicker('setStartDate', selected.date);
                      $("#period_end").datepicker( "setDate", selected.date);
                  });
                   to = $('#period_end').datepicker({
                                  <?php if($lang=="thai"){ ?>
                                        language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                                        thaiyear: true,  
                                  <?php } ?>
                          format: 'dd/mm/yyyy',
                          autoclose: true
                  })
                })

                val_lang('0','input_quiz_th','quiz_name_','th');
                val_lang('0','input_quiz_eng','quiz_name_','eng');
                document.getElementById("quiz_name_th").required = false;
                document.getElementById("quiz_name_eng").required = false;
                textarea_tinymce('quiz_info_th','1');
                textarea_tinymce('quiz_info_eng','1');
            $('#txthead_quiz').text('<?php echo label("edit_quiz"); ?>');
            $('#operation_quiz').val("Edit");
            $('#qiz_id').val(qiz_id);
            $.ajax({
                  url:"<?=base_url()?>index.php/querydata/update_quiz_detail_data",
                  method:"POST",
                  data:{qiz_id:qiz_id},
                  dataType:"json",
                  success:function(data)
                  {
                      $.ajax({
                          url: '<?=base_url()?>index.php/querydata/query_course_detail_data',
                          type: 'POST',
                          data:{cos_id:data.cos_id},
                          dataType:"json",
                          success: function(datasetDate){
                            if(datasetDate.isData=="1"){
                                var start_date = datasetDate.date_start_var.split("-");
                                var StartDate = start_date[2]+"/"+start_date[1]+"/"+(parseInt(start_date[0]));
                                var end_date = datasetDate.date_end_var.split("-");
                                var EndDate = end_date[2]+"/"+end_date[1]+"/"+(parseInt(end_date[0]));
                                $('#period_open').datepicker('setStartDate', StartDate);
                                $('#period_end').datepicker('setStartDate', StartDate);
                                $('#period_end').datepicker('setEndDate', EndDate);
                                $('#period_open').datepicker('setEndDate', EndDate);
                                //$( "#date_start_les" ).datepicker( "setDate", StartDate);
                            }
                          }
                        });

                          $.ajax({
                            url:"<?=base_url()?>index.php/querydata/query_course",
                            method:"POST",
                            data:{cos_id:data.cos_id},
                            dataType:"json",
                            success:function(data_cos)
                            {
                              $.ajax({
                                url: '<?=base_url()?>index.php/workgroup/select_qize',
                                type: 'POST',
                                data:{com_id:data_cos.com_id,quiz_lang:data.quiz_lang},
                                success: function(data_qize){
                                  
                                  $('#qize_id').html(data_qize);
                                }
                              });
                            }
                          });

                        $.ajax({
                              url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                              type: 'POST',
                              data:{cos_id:data.cos_id,les_lang:''},
                              dataType:"json",
                              success: function(data_lang){
                                for (var i = data_lang.arr_lang.length - 1; i >= 0; i--) {
                                  if(data_lang.arr_lang[i]=="th"){
                                    val_lang('1','input_quiz_th','quiz_name_','th');
                                    textarea_tinymce('quiz_info_th','1');
                                    $(tinymce.get('quiz_info_th').getBody()).html(data.quiz_info_th);
                                    $('#quiz_name_th').val(data.quiz_name_th);
                                  }
                                  if(data_lang.arr_lang[i]=="eng"){
                                    val_lang('1','input_quiz_eng','quiz_name_','eng');
                                    textarea_tinymce('quiz_info_eng','1');
                                    $(tinymce.get('quiz_info_eng').getBody()).html(data.quiz_info_eng);
                                    $('#quiz_name_eng').val(data.quiz_name_eng);
                                  }
                                }
                                $('#quiz_lang').val(data_lang.val_lang);
                              }
                        });
                        $('#period_open_var').val(data.period_open_var);
                        $('#period_end_var').val(data.period_end_var);
                        $('#time_start_quiz').val(data.time_start);
                        $('#time_end_quiz').val(data.time_end);
                        $('#course_id_quiz').val(data.cos_id);
                        if(data.period_open!=""&&data.period_end!=""){
                          $("#period_open").datepicker( "setDate", data.period_open);
                          $("#period_end").datepicker( "setDate", data.period_end);
                        }else{
                          $('#period_open').val('');
                          $('#period_end').val('');
                        }

                        if(parseInt(data.result_ques)>0){
                          document.getElementById("quiz_numofshown").readOnly = false;
                          $('#quiz_numofshown').val(data.quiz_numofshown);
                          $('#totalquiz').val(data.result_ques);
                          $('#txt_totalquiz').text(" / "+data.result_ques);
                          document.getElementById("quiz_numofshown").max = data.result_ques;
                        }else{
                          document.getElementById("quiz_numofshown").max = "";
                          document.getElementById("quiz_numofshown").readOnly = true;
                        }
                        /*$('#quiz_name').val(data.quiz_name);
                        $(tinymce.get('quiz_info').getBody()).html(data.quiz_info);*/

                        if(data.quiz_random=="0"){
                            document.getElementById("quiz_random").checked = false;
                        }else{
                            document.getElementById("quiz_random").checked = true;
                        }
                        if(data.quiz_random_choice=="0"){
                            document.getElementById("quiz_random_choice").checked = false;
                        }else{
                            document.getElementById("quiz_random_choice").checked = true;
                        }
                        if(data.quiz_show=="0"){
                            document.getElementById("quiz_show").checked = false;
                        }else{
                            document.getElementById("quiz_show").checked = true;
                        }
                        if(data.quiz_grade=="0"){
                            document.getElementById("quiz_grade").checked = false;
                        }else{
                            document.getElementById("quiz_grade").checked = true;
                        }
                        if(data.quiz_type=="1"){
                            document.getElementById("quiz_type").checked = false;
                            document.getElementById("quiz_limit").checked = true;
                        }else{
                            document.getElementById("quiz_type").checked = true;
                            if(data.quiz_answer=="0"){
                                document.getElementById("quiz_answer").checked = false;
                            }else{
                                document.getElementById("quiz_answer").checked = true;
                            }

                            if(data.quiz_limit=="0"){
                                document.getElementById("quiz_limit").checked = false;
                            }else{
                                document.getElementById("quiz_limit").checked = true;
                            }
                        }
                        if(data.quiz_ishint=="0"){
                            document.getElementById("quiz_ishint").checked = false;
                        }else{
                            document.getElementById("quiz_ishint").checked = true;
                        }
                        if(data.quiz_model=="0"){
                            document.getElementById("quiz_model").checked = false;
                        }else{
                            document.getElementById("quiz_model").checked = true;
                        }
                        //display_quiz('div_answer');
                        readonly_quiz('quiz_limitval');
                        Select_quiz_type(data.quiz_type,data.quiz_limitval,data.quiz_limit);

                        $('#quiz_settime').val(data.quiz_settime);
                        
                  }
            });
            display_style('div_create_quiz','div_quiz');
        });

        $(document).on('click', '.delete_quiz', function(){
            var qiz_id = $(this).attr("id");
            var cos_id = $('#course_id_quiz').val();
            swal({
                title: '<?php echo label('wg_delete_msg'); ?> ',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: '<?php echo label('wg_delete'); ?>',
                cancelButtonText: '<?php echo label("m_cancel"); ?>'
            }).then(function (isChk) {
              if(isChk.value){
                $.ajax({
                    url:"<?=base_url()?>index.php/manage/delete_quiz",
                    method:"POST",
                    data:{qiz_id:qiz_id},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("com_msg_delete"); ?>',
                            '',
                            'success'
                        ).then(function () {
                            var table_quiz = $('#myTable_quiz').DataTable();
                            var info_quiz = table_quiz.page.info();
                            var length_quiz = info_quiz.pages;
                            var page_current_quiz = info_quiz.page;
                            fetch_data_quiz(cos_id,page_current_quiz);
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



         $(document).on('click', '.delete_ques', function(){
            var ques_id = $(this).attr("id");
            var course_id = $('#cos_id_question').val();
            var qiz_id = $('#qiz_id_question').val();
            swal({
                title: '<?php echo label('wg_delete_msg'); ?> ',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: '<?php echo label('wg_delete'); ?>',
                cancelButtonText: '<?php echo label("m_cancel"); ?>'
            }).then(function (isChk) {
              if(isChk.value){
                $.ajax({
                    url:"<?=base_url()?>index.php/manage/delete_ques",
                    method:"POST",
                    data:{ques_id:ques_id},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("com_msg_delete"); ?>',
                            '',
                            'success'
                        ).then(function () {
                            var table_question = $('#myTable_quiz_question').DataTable();
                            var info_question = table_question.page.info();
                            var length_question = info_question.pages;
                            var page_current_question = info_question.page;
                            fetch_data_question(qiz_id,page_current_question);
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

           $('#export_question').click(function(){
                var qiz_id = $('#qiz_id_question_import').val();
                window.open('<?php echo base_url(); ?>exportdata/export_questionofquiz/'+qiz_id);
            });
        $(document).on('click', '.quiz_detail', function(){
            var qiz_id = $(this).attr("id");
            var cos_id = $('#course_id_pp').val();
            document.getElementById('div_quiz').style.display = 'none';
            document.getElementById('div_create_quiz').style.display = 'none';
            document.getElementById('div_import_question').style.display = 'none';
            document.getElementById('div_quiz_main').style.display = 'none';
            document.getElementById('div_quiz_detail').style.display = '';
            display_disable('div_create_question','div_quiz_question');

            $('#question_form')[0].reset();
            $('#qiz_id_question').val(qiz_id);
            $('#qiz_id_question_import').val(qiz_id);
            $('#result_import_question').html('');
            $('#cos_id_question').val(cos_id);
            fetch_data_question(qiz_id,0);
            $.ajax({
                url:"<?=base_url()?>index.php/querydata/update_quiz_detail_data",
                method:"POST",
                data:{qiz_id:qiz_id},
                dataType:"json",
                success:function(data)
                {
                        $('#quiz_name_txt').text(data.quiz_name);
                }
            });

                
                $.ajax({
                    url:"<?=base_url()?>index.php/querydata/query_coursemain",
                    method:"POST",
                    data:{cos_id:cos_id},
                    dataType:"json",
                    success:function(data)
                    {

                    <?php if($btn_add=="1"){ ?>
                        $('#import_question').show();
                        $('#add_question').show();
                    <?php } ?>
                        //$("#quiz").find("input,select,textarea,button").prop("disabled",false);
                        <?php if($user['u_id']!="1"){ ?>
                        if(data.cos_approve=="1"){
                        //$("#quiz").find("input,select,textarea,button").prop("disabled",true);
                        $('#import_question').hide();
                        $('#add_question').hide();
                        }
                        <?php } ?>
                    }
                });
        });

        $('select[name="ques_type"]').on('change', function(){
          var ques_type = $(this).val();
          var qiz_id = $('#qiz_id_question').val();
          var cos_id = $('#course_id_pp').val();
          val_lang('0','input_quesdetail_th','','th');
          val_lang('0','input_quesdetail_eng','','eng');

          document.getElementById('mul_answer').required = false;
          if(ques_type=='multi'){

                document.getElementById('mul_answer').required = true;
                $.ajax({
                      url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                      type: 'POST',
                      data:{cos_id:cos_id,les_lang:''},
                      dataType:"json",
                      success: function(data){
                        for (var i = data.arr_lang.length - 1; i >= 0; i--) {
                          if(data.arr_lang[i]=="th"){
                            val_lang('1','input_quesdetail_th','','th');
                            textarea_tinymce('mul_c1_th','1');
                            textarea_tinymce('mul_c2_th','1');
                            textarea_tinymce('mul_c3_th','1');
                            textarea_tinymce('mul_c4_th','1');
                            textarea_tinymce('mul_c5_th','1');

                            $(tinymce.get('mul_c1_th').getBody()).html('');
                            $(tinymce.get('mul_c2_th').getBody()).html('');
                            $(tinymce.get('mul_c3_th').getBody()).html('');
                            $(tinymce.get('mul_c4_th').getBody()).html('');
                            $(tinymce.get('mul_c5_th').getBody()).html('');
                          }
                          if(data.arr_lang[i]=="eng"){
                            val_lang('1','input_quesdetail_eng','','eng');
                            textarea_tinymce('mul_c1_eng','1');
                            textarea_tinymce('mul_c2_eng','1');
                            textarea_tinymce('mul_c3_eng','1');
                            textarea_tinymce('mul_c4_eng','1');
                            textarea_tinymce('mul_c5_eng','1');

                            $(tinymce.get('mul_c1_eng').getBody()).html('');
                            $(tinymce.get('mul_c2_eng').getBody()).html('');
                            $(tinymce.get('mul_c3_eng').getBody()).html('');
                            $(tinymce.get('mul_c4_eng').getBody()).html('');
                            $(tinymce.get('mul_c5_eng').getBody()).html('');
                          }
                        }
                      }
                });
            $('.mul_c1').show();
            $('.mul_c2').show();
            $('.mul_c3').show();
            $('.mul_c4').show();
            $('.mul_c5').show();
            $("#mul_answer").html('');
            $("#mul_answer").append('<option value="mul_c1"><?php echo label('choice')." 1"; ?></option>');
            $("#mul_answer").append('<option value="mul_c2"><?php echo label('choice')." 2"; ?></option>');
            $("#mul_answer").append('<option value="mul_c3"><?php echo label('choice')." 3"; ?></option>');
            $("#mul_answer").append('<option value="mul_c4"><?php echo label('choice')." 4"; ?></option>');
            $("#mul_answer").append('<option value="mul_c5"><?php echo label('choice')." 5"; ?></option>');
            document.getElementById('div_question_mul').style.display = '';
            $.ajax({
                      url:"<?=base_url()?>index.php/querydata/update_quiz_detail_data",
                      method:"POST",
                      data:{qiz_id:qiz_id},
                      dataType:"json",
                      success:function(data)
                      {
                        if(data.quiz_ishint=="1"){
                            clear_dropify('ques_hintimg');
                            document.getElementById("div_question_hint").style.display = '';
                        }else{
                            document.getElementById("div_question_hint").style.display = 'none';
                        }
                      }
                });
                $("#mul_answer").select2({
                    maximumSelectionLength: 5,
                });
          }else if(ques_type=='2choice'){

                document.getElementById('mul_answer').required = true;
                
                $.ajax({
                      url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                      type: 'POST',
                      data:{cos_id:cos_id,les_lang:''},
                      dataType:"json",
                      success: function(data){
                        for (var i = data.arr_lang.length - 1; i >= 0; i--) {
                          if(data.arr_lang[i]=="th"){
                            val_lang('1','input_quesdetail_th','','th');
                            textarea_tinymce('mul_c1_th','1');
                            textarea_tinymce('mul_c2_th','1');
                            $(tinymce.get('mul_c1_th').getBody()).html('');
                            $(tinymce.get('mul_c2_th').getBody()).html('');
                          }
                          if(data.arr_lang[i]=="eng"){
                            val_lang('1','input_quesdetail_eng','','eng');
                            textarea_tinymce('mul_c1_eng','1');
                            textarea_tinymce('mul_c2_eng','1');
                            $(tinymce.get('mul_c1_eng').getBody()).html('');
                            $(tinymce.get('mul_c2_eng').getBody()).html('');
                          }
                        }
                      }
                });
            $("#mul_answer option[value='mul_c3']").remove();
            $("#mul_answer option[value='mul_c4']").remove();
            $("#mul_answer option[value='mul_c5']").remove();
                $("#mul_answer").select2({
                    maximumSelectionLength: 1,
                });
            $('.mul_c1').show();
            $('.mul_c2').show();
            $('.mul_c3').hide();
            $('.mul_c4').hide();
            $('.mul_c5').hide();
                document.getElementById('div_question_mul').style.display = '';
                //document.getElementById("div_question_hint").style.display = 'none';
                $.ajax({
                      url:"<?=base_url()?>index.php/querydata/update_quiz_detail_data",
                      method:"POST",
                      data:{qiz_id:qiz_id},
                      dataType:"json",
                      success:function(data)
                      {
                        if(data.quiz_ishint=="1"){
                            clear_dropify('ques_hintimg');
                            document.getElementById("div_question_hint").style.display = '';
                        }else{
                            document.getElementById("div_question_hint").style.display = 'none';
                        }
                      }
                });
          }else{
            document.getElementById('div_question_mul').style.display = 'none';
          }
        });

        function select_questype(valueselected){
          var ques_type = valueselected;
          var qiz_id = $('#qiz_id_question').val();
          var cos_id = $('#course_id_pp').val();
          val_lang('0','input_quesdetail_th','','th');
          val_lang('0','input_quesdetail_eng','','eng');

          document.getElementById('mul_answer').required = false;
          if(ques_type=='multi'){

                document.getElementById('mul_answer').required = true;
                $.ajax({
                      url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                      type: 'POST',
                      data:{cos_id:cos_id,les_lang:''},
                      dataType:"json",
                      success: function(data){
                        for (var i = data.arr_lang.length - 1; i >= 0; i--) {
                          if(data.arr_lang[i]=="th"){
                            val_lang('1','input_quesdetail_th','','th');
                            textarea_tinymce('mul_c1_th','1');
                            textarea_tinymce('mul_c2_th','1');
                            textarea_tinymce('mul_c3_th','1');
                            textarea_tinymce('mul_c4_th','1');
                            textarea_tinymce('mul_c5_th','1');

                            $(tinymce.get('mul_c1_th').getBody()).html('');
                            $(tinymce.get('mul_c2_th').getBody()).html('');
                            $(tinymce.get('mul_c3_th').getBody()).html('');
                            $(tinymce.get('mul_c4_th').getBody()).html('');
                            $(tinymce.get('mul_c5_th').getBody()).html('');
                          }
                          if(data.arr_lang[i]=="eng"){
                            val_lang('1','input_quesdetail_eng','','eng');
                            textarea_tinymce('mul_c1_eng','1');
                            textarea_tinymce('mul_c2_eng','1');
                            textarea_tinymce('mul_c3_eng','1');
                            textarea_tinymce('mul_c4_eng','1');
                            textarea_tinymce('mul_c5_eng','1');

                            $(tinymce.get('mul_c1_eng').getBody()).html('');
                            $(tinymce.get('mul_c2_eng').getBody()).html('');
                            $(tinymce.get('mul_c3_eng').getBody()).html('');
                            $(tinymce.get('mul_c4_eng').getBody()).html('');
                            $(tinymce.get('mul_c5_eng').getBody()).html('');
                          }
                        }
                      }
                });
            $('.mul_c1').show();
            $('.mul_c2').show();
            $('.mul_c3').show();
            $('.mul_c4').show();
            $('.mul_c5').show();
            $("#mul_answer").html('');
            $("#mul_answer").append('<option value="mul_c1"><?php echo label('choice')." 1"; ?></option>');
            $("#mul_answer").append('<option value="mul_c2"><?php echo label('choice')." 2"; ?></option>');
            $("#mul_answer").append('<option value="mul_c3"><?php echo label('choice')." 3"; ?></option>');
            $("#mul_answer").append('<option value="mul_c4"><?php echo label('choice')." 4"; ?></option>');
            $("#mul_answer").append('<option value="mul_c5"><?php echo label('choice')." 5"; ?></option>');
                $("#mul_answer").select2({
                    maximumSelectionLength: 5,
                });
            document.getElementById('div_question_mul').style.display = '';
            $.ajax({
                      url:"<?=base_url()?>index.php/querydata/update_quiz_detail_data",
                      method:"POST",
                      data:{qiz_id:qiz_id},
                      dataType:"json",
                      success:function(data)
                      {
                        if(data.quiz_ishint=="1"){
                            clear_dropify('ques_hintimg');
                            document.getElementById("div_question_hint").style.display = '';
                        }else{
                            document.getElementById("div_question_hint").style.display = 'none';
                        }
                      }
                });
          }else if(ques_type=='2choice'){
                document.getElementById('mul_answer').required = true;
                
                $.ajax({
                      url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                      type: 'POST',
                      data:{cos_id:cos_id,les_lang:''},
                      dataType:"json",
                      success: function(data){
                        for (var i = data.arr_lang.length - 1; i >= 0; i--) {
                          if(data.arr_lang[i]=="th"){
                            val_lang('1','input_quesdetail_th','','th');
                            textarea_tinymce('mul_c1_th','1');
                            textarea_tinymce('mul_c2_th','1');
                            $(tinymce.get('mul_c1_th').getBody()).html('');
                            $(tinymce.get('mul_c2_th').getBody()).html('');
                          }
                          if(data.arr_lang[i]=="eng"){
                            val_lang('1','input_quesdetail_eng','','eng');
                            textarea_tinymce('mul_c1_eng','1');
                            textarea_tinymce('mul_c2_eng','1');
                            $(tinymce.get('mul_c1_eng').getBody()).html('');
                            $(tinymce.get('mul_c2_eng').getBody()).html('');
                          }
                        }
                      }
                });
            $("#mul_answer option[value='mul_c3']").remove();
            $("#mul_answer option[value='mul_c4']").remove();
            $("#mul_answer option[value='mul_c5']").remove();
            $('.mul_c1').show();
            $('.mul_c2').show();
            $('.mul_c3').hide();
            $('.mul_c4').hide();
            $('.mul_c5').hide();
                $("#mul_answer").select2({
                    maximumSelectionLength: 1,
                });
                document.getElementById('div_question_mul').style.display = '';
                //document.getElementById("div_question_hint").style.display = 'none';
                /*div_question_hint*/
                $.ajax({
                      url:"<?=base_url()?>index.php/querydata/update_quiz_detail_data",
                      method:"POST",
                      data:{qiz_id:qiz_id},
                      dataType:"json",
                      success:function(data)
                      {
                        if(data.quiz_ishint=="1"){
                            clear_dropify('ques_hintimg');
                            document.getElementById("div_question_hint").style.display = '';
                        }else{
                            document.getElementById("div_question_hint").style.display = 'none';
                        }
                      }
                });
          }else{
            document.getElementById('div_question_mul').style.display = 'none';
          }
        }

        $(document).on('click', '.update_ques', function(){
            var ques_id = $(this).attr("id");

            $('#operation_question').val("Edit");
            $('#ques_id').val(ques_id);
            $('#quiz_name_txt').text('<?php echo label("edit_question"); ?>');
            var qiz_id = $('#qiz_id_question').val();
            var cos_id = $('#course_id_pp').val();
            $('#div_question_hint').hide();
            document.getElementById("ques_name_th").required = false;
            document.getElementById("ques_name_eng").required = false;
            val_lang('0','input_ques_th','','th');
            val_lang('0','input_ques_eng','','eng');
            val_lang('0','input_quesdetail_th','','th');
            val_lang('0','input_quesdetail_eng','','eng');
            $('#cos_id_question').val(cos_id);
            $.ajax({
                  url:"<?=base_url()?>index.php/querydata/update_question_detail_data",
                  method:"POST",
                  data:{ques_id:ques_id},
                  dataType:"json",
                  success:function(data)
                  {
                        $.ajax({
                              url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                              type: 'POST',
                              data:{cos_id:cos_id,les_lang:''},
                              dataType:"json",
                              success: function(data_lang){
                                for (var i = data_lang.arr_lang.length - 1; i >= 0; i--) {
                                  if(data_lang.arr_lang[i]=="th"){
                                    val_lang('1','input_ques_th','','th');
                                    $('#ques_name_th').val(data.ques_name_th);
                                    $('#ques_info_th').val(data.ques_info_th);
                                    textarea_tinymce('ques_name_th','1');
                                    textarea_tinymce('ques_info_th','1');
                                    $(tinymce.get('ques_name_th').getBody()).html(data.ques_name_th);
                                    $(tinymce.get('ques_info_th').getBody()).html(data.ques_info_th);
                                  }
                                  if(data_lang.arr_lang[i]=="eng"){
                                    val_lang('1','input_ques_eng','','eng');
                                    $('#ques_name_eng').val(data.ques_name_eng);
                                    $('#ques_info_eng').val(data.ques_info_eng);
                                    textarea_tinymce('ques_name_eng','1');
                                    textarea_tinymce('ques_info_eng','1');
                                    $(tinymce.get('ques_name_eng').getBody()).html(data.ques_name_eng);
                                    $(tinymce.get('ques_info_eng').getBody()).html(data.ques_info_eng);
                                  }
                                }
                              }
                        });
                        document.getElementById('mul_answer').required = false;
                         $("#ques_type").html('');
                          $("#ques_type").append('<option value="sa"><?php echo label('qt_sa'); ?></option>');
                          $("#ques_type").append('<option value="sub"><?php echo label('qt_sub'); ?></option>');
                          $("#ques_type").append('<option value="2choice"><?php echo label('qt_twoChoice'); ?></option>');
                          $("#ques_type").append('<option value="multi"><?php echo label('qt_multi'); ?></option>');
                        $.ajax({
                              url:"<?=base_url()?>index.php/querydata/update_quiz_detail_data",
                              method:"POST",
                              data:{qiz_id:qiz_id},
                              dataType:"json",
                              success:function(data_hint)
                              {

                                  if(data.ques_type=='multi'||data.ques_type=='2choice'){
                                    if(data_hint.quiz_random_choice=="1"||data_hint.quiz_model=="1"||data_hint.quiz_ishint=="1"){
                                      $("#ques_type").val(data.ques_type);
                                      $("#ques_type option[value='sa']").remove();
                                      $("#ques_type option[value='sub']").remove();
                                      //select_questype(data.ques_type);
                                    }
                                  }
                                  if(data.ques_type=='multi'||data.ques_type=='2choice'){
                                    document.getElementById('mul_answer').required = true;
                                    if(data_hint.quiz_ishint=="1"){
                                        
                                        clear_dropify('ques_hintimg');
                                        document.getElementById("div_question_hint").style.display = '';
                                        $.ajax({
                                              url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                                              type: 'POST',
                                              data:{cos_id:cos_id,les_lang:''},
                                              dataType:"json",
                                              success: function(data_lang){
                                                for (var i = data_lang.arr_lang.length - 1; i >= 0; i--) {
                                                  if(data_lang.arr_lang[i]=="th"){
                                                    val_lang('1','input_quesdetail_th','','th');
                                                    $('#ques_hintname_th').val(data.ques_hintname_th);
                                                    $('#ques_hintdetail_th').val(data.ques_hintdetail_th);
                                                  }
                                                  if(data_lang.arr_lang[i]=="eng"){
                                                    val_lang('1','input_quesdetail_eng','','eng');
                                                    $('#ques_hintname_eng').val(data.ques_hintname_eng);
                                                    $('#ques_hintdetail_eng').val(data.ques_hintdetail_eng);
                                                  }
                                                }
                                              }
                                        });
                                        if(data.ques_hintimg!=""){

                                            var nameImage = "<?php echo REAL_PATH;?>/uploads/hint/"+data.ques_hintimg
                                            var drEvent = $('#ques_hintimg').dropify(
                                            {
                                              defaultFile: nameImage
                                            });
                                            drEvent = drEvent.data('dropify');
                                            drEvent.resetPreview();
                                            drEvent.clearElement();
                                            drEvent.settings.defaultFile = nameImage;
                                            drEvent.destroy();
                                            drEvent.init();

                                            var drEvent = $('.ques_hintimg').dropify({
                                                defaultFile: "<?php echo REAL_PATH;?>/uploads/hint/"+data.ques_hintimg ,
                                            });
                                        }else{
                                            $('.ques_hintimg').dropify();
                                        }
                                    }else{
                                        document.getElementById("div_question_hint").style.display = 'none';
                                    }
                                  }else{
                                        document.getElementById("div_question_hint").style.display = 'none';
                                  }
                              }
                        });
                        $('#ques_type').val(data.ques_type);
                        $('#ques_score').val(data.ques_score);

                        if(data.ques_status=="0"){
                            document.getElementById("ques_show").checked = false;
                        }else{
                            document.getElementById("ques_show").checked = true;
                        }

                        if(data.ques_type=='multi'){
                            document.getElementById('div_question_mul').style.display = '';

                            $('.mul_c1').show();
                            $('.mul_c2').show();
                            $('.mul_c3').show();
                            $('.mul_c4').show();
                            $('.mul_c5').show();
                            $.ajax({
                                  url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                                  type: 'POST',
                                  data:{cos_id:cos_id,les_lang:''},
                                  dataType:"json",
                                  success: function(data_lang){
                                    for (var i = data_lang.arr_lang.length - 1; i >= 0; i--) {
                                      if(data_lang.arr_lang[i]=="th"){
                                        val_lang('1','input_quesdetail_th','','th');
                                        textarea_tinymce('mul_c1_th','1');
                                        textarea_tinymce('mul_c2_th','1');
                                        textarea_tinymce('mul_c3_th','1');
                                        textarea_tinymce('mul_c4_th','1');
                                        textarea_tinymce('mul_c5_th','1');
                                        $(tinymce.get('mul_c1_th').getBody()).html(data.multi['mul_c1_th']);
                                        $(tinymce.get('mul_c2_th').getBody()).html(data.multi['mul_c2_th']);
                                        $(tinymce.get('mul_c3_th').getBody()).html(data.multi['mul_c3_th']);
                                        $(tinymce.get('mul_c4_th').getBody()).html(data.multi['mul_c4_th']);
                                        $(tinymce.get('mul_c5_th').getBody()).html(data.multi['mul_c5_th']);
                                        $('#mul_c1_th').val(data.multi['mul_c1_th']);
                                        $('#mul_c2_th').val(data.multi['mul_c2_th']);
                                        $('#mul_c3_th').val(data.multi['mul_c3_th']);
                                        $('#mul_c4_th').val(data.multi['mul_c4_th']);
                                        $('#mul_c5_th').val(data.multi['mul_c5_th']);
                                      }
                                      if(data_lang.arr_lang[i]=="eng"){
                                        val_lang('1','input_quesdetail_eng','','eng');
                                        textarea_tinymce('mul_c1_eng','1');
                                        textarea_tinymce('mul_c2_eng','1');
                                        textarea_tinymce('mul_c3_eng','1');
                                        textarea_tinymce('mul_c4_eng','1');
                                        textarea_tinymce('mul_c5_eng','1');
                                        $(tinymce.get('mul_c1_eng').getBody()).html(data.multi['mul_c1_eng']);
                                        $(tinymce.get('mul_c2_eng').getBody()).html(data.multi['mul_c2_eng']);
                                        $(tinymce.get('mul_c3_eng').getBody()).html(data.multi['mul_c3_eng']);
                                        $(tinymce.get('mul_c4_eng').getBody()).html(data.multi['mul_c4_eng']);
                                        $(tinymce.get('mul_c5_eng').getBody()).html(data.multi['mul_c5_eng']);
                                        $('#mul_c1_eng').val(data.multi['mul_c1_eng']);
                                        $('#mul_c2_eng').val(data.multi['mul_c2_eng']);
                                        $('#mul_c3_eng').val(data.multi['mul_c3_eng']);
                                        $('#mul_c4_eng').val(data.multi['mul_c4_eng']);
                                        $('#mul_c5_eng').val(data.multi['mul_c5_eng']);
                                      }
                                    }
                                  }
                            });
                            var myarr = data.multi['mul_answer'];
                            if(myarr&&myarr!=""){
                                $.ajax({
                                      url: '<?=base_url()?>index.php/workgroup/recheckmul_answer',
                                      type: 'POST',
                                      data:{ques_id:ques_id,type:'multi'},
                                      success: function(answer){
                                        $('#mul_answer').html(answer);
                                      }
                                });
                            }
                            $("#mul_answer").select2({
                                maximumSelectionLength: 5,
                            });
                        }else if(data.ques_type=='2choice'){
                            document.getElementById('div_question_mul').style.display = '';

                            $('.mul_c1').show();
                            $('.mul_c2').show();
                            $('.mul_c3').hide();
                            $('.mul_c4').hide();
                            $('.mul_c5').hide();
                            $.ajax({
                                  url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                                  type: 'POST',
                                  data:{cos_id:cos_id,les_lang:''},
                                  dataType:"json",
                                  success: function(data_lang){
                                    for (var i = data_lang.arr_lang.length - 1; i >= 0; i--) {
                                      if(data_lang.arr_lang[i]=="th"){
                                        val_lang('1','input_quesdetail_th','','th');
                                        textarea_tinymce('mul_c1_th','1');
                                        textarea_tinymce('mul_c2_th','1');
                                        $(tinymce.get('mul_c1_th').getBody()).html(data.multi['mul_c1_th']);
                                        $(tinymce.get('mul_c2_th').getBody()).html(data.multi['mul_c2_th']);
                                        $('#mul_c1_th').val(data.multi['mul_c1_th']);
                                        $('#mul_c2_th').val(data.multi['mul_c2_th']);
                                      }
                                      if(data_lang.arr_lang[i]=="eng"){
                                        val_lang('1','input_quesdetail_eng','','eng');
                                        textarea_tinymce('mul_c1_eng','1');
                                        textarea_tinymce('mul_c2_eng','1');
                                        $(tinymce.get('mul_c1_eng').getBody()).html(data.multi['mul_c1_eng']);
                                        $(tinymce.get('mul_c2_eng').getBody()).html(data.multi['mul_c2_eng']);
                                        $('#mul_c1_eng').val(data.multi['mul_c1_eng']);
                                        $('#mul_c2_eng').val(data.multi['mul_c2_eng']);
                                      }
                                    }
                                  }
                            });
                            var myarr = data.multi['mul_answer'];
                            if(myarr&&myarr!=""){
                                $.ajax({
                                      url: '<?=base_url()?>index.php/workgroup/recheckmul_answer',
                                      type: 'POST',
                                      data:{ques_id:ques_id,type:'2choice'},
                                      success: function(answer){
                                        $('#mul_answer').html(answer);
                                      }
                                });
                            }
                            
                            $("#mul_answer").select2({
                                maximumSelectionLength: 1,
                            });
                        }else{
                            document.getElementById('div_question_mul').style.display = 'none';
                        }
                        
                  }
            });
            display_style('div_create_question','div_quiz_question');
        });

        function myGetValue(fieldName)
        {
            var values =  [];   $('input[name="'+fieldName+'[]"]:checked').each(function(i) {
                values[i] = $(this).val();
            });
            return values;
        }   
        $(document).on('submit', '#question_form', function(event){
              event.preventDefault();
              var course_id = $('#cos_id_question').val();
              var qiz_id = $('#qiz_id_question').val();
              var rechk_val = 1;
              var cos_id = $('#course_id_pp').val();
              var form = $('#question_form')[0];
              var ques_type = $('#ques_type').val();
                        $.ajax({
                              url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                              type: 'POST',
                              data:{cos_id:cos_id,les_lang:''},
                              dataType:"json",
                              success: function(data_lang){
                                var rechk_null = 0;
                                for (var i = data_lang.arr_lang.length - 1; i >= 0; i--) {
                                  if(data_lang.arr_lang[i]=="th"){
                                    var ques_name_th = $('#ques_name_th').val();
                                    tinymce.get('ques_name_th').focus();
                                    if(ques_name_th==""){
                                        rechk_null++;
                                    }
                                    if(ques_type=="2choice"||ques_type=="multi"){
                                      var mul_c1_th = $('#mul_c1_th').val();
                                      var mul_c2_th = $('#mul_c2_th').val();
                                      if(mul_c1_th==""){
                                          rechk_null++;
                                      }
                                      if(mul_c2_th==""){
                                          rechk_null++;
                                      }
                                    }
                                    if(ques_type=="multi"){
                                      $("#mul_answer option:selected").each(function () {
                                         var $this = $(this);
                                         if ($this.length) {
                                          var selText = $this.val();
                                          var mul_val = $('#'+selText+'_th').val();
                                          if(mul_val==""){
                                            rechk_null++;
                                          }
                                         }
                                      });
                                    }
                                  }
                                  if(data_lang.arr_lang[i]=="eng"){
                                    var ques_name_eng = $('#ques_name_eng').val();
                                    tinymce.get('ques_name_eng').focus();
                                    if(ques_name_eng==""){
                                        rechk_null++;
                                    }
                                    if(ques_type=="2choice"||ques_type=="multi"){
                                      var mul_c1_eng = $('#mul_c1_eng').val();
                                      var mul_c2_eng = $('#mul_c2_eng').val();
                                      if(mul_c1_eng==""){
                                          rechk_null++;
                                      }
                                      if(mul_c2_eng==""){
                                          rechk_null++;
                                      }
                                    }
                                    if(ques_type=="multi"){
                                      $("#mul_answer option:selected").each(function () {
                                         var $this = $(this);
                                         if ($this.length) {
                                          var selText = $this.val();
                                          var mul_val = $('#'+selText+'_eng').val();
                                          if(mul_val==""){
                                            rechk_null++;
                                          }
                                         }
                                      });
                                    }
                                  }
                                }
                                if(ques_type=="multi"){
                                  if(data_lang.arr_lang.length>1){
                                      for(chkloop=1;chkloop<=5;chkloop++){
                                          langtotal = 0;
                                          langtotal_null = 0;
                                          for (var i = data_lang.arr_lang.length - 1; i >= 0; i--) {
                                              if(data_lang.arr_lang[i]=="th"){
                                                var mul_th = $('#mul_c'+chkloop+'_th').val();
                                                if(mul_th!=""){
                                                  langtotal_null++;
                                                }
                                              }
                                              if(data_lang.arr_lang[i]=="eng"){
                                                langtotal++;
                                                var mul_eng = $('#mul_c'+chkloop+'_eng').val();
                                                if(mul_eng!=""){
                                                  langtotal_null++;
                                                }
                                              }
                                          }
                                          if(langtotal_null>0&&data_lang.arr_lang.length!=langtotal_null){
                                            rechk_null++;
                                          }
                                      }
                                  }
                                }
                                if(rechk_null>0){
                                    rechk_val = 0;
                                }
                                if(rechk_val==1){
                                    $("#myModal_process").modal({backdrop: false});
                                    $( "body" ).addClass( "modal-open" );
                                    $.ajax({
                                      url:"<?=base_url()?>index.php/insertdata/insert_question",
                                      method:'POST',
                                      data:new FormData(form),
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
                                            swal(
                                                '<?php echo label("com_msg_success"); ?>',
                                                '',
                                                'success'
                                            ).then(function () {
                                                $('#question_form')[0].reset();
                                                display_style('div_create_question','div_quiz_question');
                                                $('#cos_id_question').val(course_id);
                                                $('#qiz_id_question').val(qiz_id);

                                                $('#qiz_id_question_import').val(qiz_id);
                                                fetch_data_question(qiz_id,0);
                                            })
                                        }else if(data.status=="1"){
                                            swal({
                                                title: '<?php echo label("data_msg_duplicate"); ?>',
                                                text: "",
                                                type: 'warning',
                                                showCancelButton: false,
                                                confirmButtonClass: 'btn btn-primary',
                                                confirmButtonText: '<?php echo label("m_ok"); ?>'
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
                                                title: '<?php echo label("com_msg_form_error"); ?>',
                                                text: "",
                                                type: 'warning',
                                                showCancelButton: false,
                                                confirmButtonClass: 'btn btn-primary',
                                                confirmButtonText: '<?php echo label("m_ok"); ?>'
                                            }).then(function () {
                                                //topFunction();
                                            })
                                }
                              }
                        });
        });
        function strip_html_tags(str)
        {
           if ((str===null) || (str===''))
               return false;
          else
           str = str.toString();
          return str.replace(/<[^>]*>/g, '');
        }
        $(document).on('click', '.check_ques', function(){
            var ques_id = $(this).attr("id");
            document.getElementById('div_question_check').style.display = '';
            document.getElementById('div_quiz_detail').style.display = 'none';
            $('.div_btn_checkquestion').hide();
            $('.tc_set').hide();
            $.ajax({
                  url:"<?=base_url()?>index.php/querydata/update_question_detail_data",
                  method:"POST",
                  data:{ques_id:ques_id},
                  dataType:"json",
                  success:function(data)
                  {
                      $('#quiz_name_txt_question').html('<?php echo label("chk_answer_txt"); ?>'+strip_html_tags(data.ques_name));
                      if(data.ques_type=="sa"||data.ques_type=="sub"){
                        if(parseInt(data.counttc)>0){
                          $('.div_btn_checkquestion').show();
                          $('.tc_set').show();
                        }
                      }
                  }
            });
            $('#ques_idcheck').val(ques_id);
            fetch_data_quiz_question_check(ques_id);
        });
        function changeNote_tc(tc_id){
          var tc_note = $('#tc_note_'+tc_id).val();
          $.ajax({
                url: '<?=base_url()?>index.php/course/update_note_tc',
                type: 'POST',
                data:{tc_id:tc_id,tc_note:tc_note},
                success: function(note){
                }
          });
        }
        function changeScore_tc(tc_id){
          var tc_score = $('#score_'+tc_id).val();
          var ques_score = $('#ques_score_'+tc_id).val();
          var ori_score = $('#ori_score_'+tc_id).val();
          if(parseInt(tc_score) > parseInt(ques_score)){
              swal({
                  title: '<?php echo label("score_over"); ?>',
                  text: "",
                  type: 'warning',
                  showCancelButton: false,
                  confirmButtonClass: 'btn btn-primary',
                  confirmButtonText: '<?php echo label("m_ok"); ?>'
              }).then(function () {
                  $('#score_'+tc_id).val(parseInt(ori_score));
              })
          }/*else{
              $.ajax({
                  url: '<?=base_url()?>index.php/course/update_score_tc',
                  type: 'POST',
                  data:{tc_id:tc_id,tc_score:tc_score},
                  success: function(answer){
                  }
              });
          }*/
        }

         $(document).on('click', '.save_answer_tc', function(){
            var tc_id = $(this).attr("id");
            var ques_id = $('#ques_idcheck').val();
            var tc_note = $('#tc_note_'+tc_id).val();
            var ori_score = $('#ori_score_'+tc_id).val();
            var tc_score = $('#score_'+tc_id).val();            

              swal({
                  title: '<?php echo label('save_is'); ?> ',
                  text: "",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: "#1abc9c",   
                  cancelButtonColor: "#DD6B55",
                  confirmButtonText: '<?php echo label('yes'); ?>',
                  cancelButtonText: '<?php echo label("no"); ?>'
              }).then(function (isChk) {
                if(isChk.value){
                    $.ajax({
                      url:"<?=base_url()?>index.php/course/update_scoreall_qiztc_single",
                      method:'POST',
                      data:{tc_id:tc_id,tc_note:tc_note,tc_score:tc_score,ques_id:ques_id},
                      dataType:"json",
                      success:function(data)
                      {
                          if(data.status=="2"){
                              $('.div_btn_checkquestion').hide();
                              swal(
                                  '<?php echo label("com_msg_success"); ?>',
                                  '',
                                  'success',
                              ).then(function () {
                                  fetch_data_quiz_question_check(ques_id);
                                  if(data.cos_id!=""&&data.emp_id!=""){
                                      $.ajax({
                                          url:"<?=base_url()?>index.php/coursemain/endcos_update/"+data.cos_id+"/"+data.emp_id,
                                          method:'POST',
                                          dataType:"json",
                                          success:function(data_update)
                                          {
                                          }
                                        });
                                  }
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
                }
              });
          });

        function fetch_data_quiz_question_check(ques_id)
         {
            $('#myTable_quiz_question_check').DataTable().destroy();
            $('#myTable_quiz_question_check').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_quiz_question_check/',
                    data : {ques_id:ques_id},
                    type : 'GET'
                },
              columnDefs: [{
                    render: function (data, type, full, meta) {
                        return "<div class='text-wrap'>" + data + "</div>";
                    },
                targets: [2],
                createdCell: function(cell ,td, cellData, rowData, row, col) {
                  var $cell = $(cell);
                  if(td.length>20){
                  $(cell).contents().wrapAll("<div class='content'></div>");
                  var $content = $cell.find(".content");
                  $(cell).append($("<button type='button' class='btn btn-default btn-sm'>...</button>"));
                  $btn = $(cell).find("button");

                  $content.css({
                    "height": "50px",
                    "overflow": "hidden"
                  })
                  $cell.data("isLess", true);

                  $btn.click(function() {
                    var isLess = $cell.data("isLess");
                    $content.css("height", isLess ? "auto" : "50px")
                    $(this).html(isLess ? "<i class='mdi mdi-arrow-up-bold-circle-outline'></i>" : "...")
                    $cell.data("isLess", !isLess)
                  })
                  }
                }
              }]
            });

                $('.allownumericwithoutdecimal').keyup(function () { 
                    this.value = this.value.replace(/[^0-9,]/g, '').replace(/(\..*)\./g, '$1');
                });
             
         }
         
    
        $(document).on('submit', '#checkquestion_form', function(event){
              event.preventDefault();

              var form = $('#checkquestion_form')[0];

            var ques_id = $('#ques_idcheck').val();

              swal({
                  title: '<?php echo label('save_is'); ?> ',
                  text: "",
                  type: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: "#1abc9c",   
                  cancelButtonColor: "#DD6B55",
                  confirmButtonText: '<?php echo label('yes'); ?>',
                  cancelButtonText: '<?php echo label("no"); ?>'
              }).then(function (isChk) {
                if(isChk.value){
                    $.ajax({
                      url:"<?=base_url()?>index.php/course/update_scoreall_qiztc",
                      method:'POST',
                      data:new FormData(form),
                      contentType:false,
                      processData:false,
                      dataType:"json",
                      success:function(data)
                      {
                          if(data.status=="2"){
                              $('.div_btn_checkquestion').hide();
                              swal(
                                  '<?php echo label("com_msg_success"); ?>',
                                  '',
                                  'success',
                              ).then(function () {
                                  fetch_data_quiz_question_check(ques_id);
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
                }
              });
         });          

        $(document).on('submit', '#question_import_form', function(event){
              event.preventDefault();
                $("#myModal_process").addClass("in");
                $("body").addClass("modal-open");
                $("#myModal_process").css("display","block");
                $("#myModal_process").modal({backdrop: false});
              var qiz_id = $('#qiz_id_question_import').val();
              var file_import = $('#file_import_question').val();
              if(file_import!=""){
                $.ajax({
                  url:"<?=base_url()?>index.php/setting/import_question",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  dataType:"json",
                  success:function(data)
                  {
                      $("body").removeClass("modal-open");
                      $("#myModal_process").removeClass("in");
                      $("#myModal_process").css("display","none");
                    topFunction();
                    if(data.status=="2"){
                        $('#question_import_form')[0].reset();
                        swal(
                            '<?php echo label("after_upload_file"); ?>',
                            ''
                        ).then(function () {
                            $('#result_import_question').html(data.result);
                            $('#qiz_id_question_import').val(qiz_id);
                            clear_dropify('file_import_question');
                            fetch_data_question(qiz_id,0);
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
                            document.getElementById("file_import_question").focus();
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
                  },
                      error: function (jqXHR, exception) {
                      $("body").removeClass("modal-open");
                      $("#myModal_process").removeClass("in");
                      $("#myModal_process").css("display","none");
                          topFunction();
                          var msg = '';
                          if (jqXHR.status === 0) {
                              msg = 'Not connect.\n Verify Network.';
                          } else if (jqXHR.status == 404) {
                              msg = 'Requested page not found. [404]';
                          } else if (jqXHR.status == 500) {
                              msg = 'Internal Server Error [500].';
                          } else if (exception === 'parsererror') {
                              msg = 'Requested JSON parse failed.';
                          } else if (exception === 'timeout') {
                              msg = 'Time out error.';
                          } else if (exception === 'abort') {
                              msg = 'Ajax request aborted.';
                          } else {
                              msg = 'Uncaught Error.\n' + jqXHR.responseText;
                          }
                          swal({
                              title: msg,
                              text: "",
                              type: 'warning',
                              showCancelButton: false,
                              confirmButtonClass: 'btn btn-primary',
                              confirmButtonText: '<?php echo label("m_ok"); ?>'
                          })
                      },
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
                            document.getElementById("file_import_question").focus();
                        })
              }
         });
              

                    
        $(document).on('submit', '#videocourse_form', function(event){
              event.preventDefault();
              var cos_id = $('#course_id_cosv').val();
              var type_media = $('#type_media_cosv').val();
                $("#myModal_process").addClass("in");
                $("body").addClass("modal-open");
                $("#myModal_process").css("display","block");
                $("#myModal_process").modal({backdrop: false});
                $.ajax({
                  url:"<?=base_url()?>index.php/insertdata/insert_videocourse",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  dataType:"json",
                  success:function(data)
                  {
                      $("body").removeClass("modal-open");
                      $("#myModal_process").removeClass("in");
                      $("#myModal_process").css("display","none");
                    topFunction();
                    if(data.status=="2"){
                        $('#videocourse_form')[0].reset();

                        $.ajax({
                              url: '<?=base_url()?>index.php/querydata/select_lang_cosvideo',
                              type: 'POST',
                              data:{cos_id:data.cos_id,cosv_lang:''},
                              success: function(data_lang){
                                  $('#cosv_lang').html(data_lang);
                              }
                        });
                        swal(
                            '<?php echo label("com_msg_success"); ?>',
                            '',
                            'success'
                        ).then(function () {
                            $('#course_id_cosv').val(cos_id);
                            fetch_data_coursevideo(cos_id,0);
                            if(type_media=="2"){
                              clear_dropify('cosv_thumbnail');
                              clear_dropify('cosv_video');
                            }
                        })
                    }else if(data.status=="1"){
                        swal({
                            title: '<?php echo label("data_msg_duplicate"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
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
                  },
                      error: function (jqXHR, exception) {
                      $("body").removeClass("modal-open");
                      $("#myModal_process").removeClass("in");
                      $("#myModal_process").css("display","none");
                          topFunction();
                          var msg = '';
                          if (jqXHR.status === 0) {
                              msg = 'Not connect.\n Verify Network.';
                          } else if (jqXHR.status == 404) {
                              msg = 'Requested page not found. [404]';
                          } else if (jqXHR.status == 500) {
                              msg = 'Internal Server Error [500].';
                          } else if (exception === 'parsererror') {
                              msg = 'Requested JSON parse failed.';
                          } else if (exception === 'timeout') {
                              msg = 'Time out error.';
                          } else if (exception === 'abort') {
                              msg = 'Ajax request aborted.';
                          } else {
                              msg = 'Uncaught Error.\n' + jqXHR.responseText;
                          }
                          swal({
                              title: msg,
                              text: "",
                              type: 'warning',
                              showCancelButton: false,
                              confirmButtonClass: 'btn btn-primary',
                              confirmButtonText: '<?php echo label("m_ok"); ?>'
                          })
                      },
                });
         });

         $(document).on('click', '.delete_videocourse', function(){
            var id = $(this).attr("id");
            var cos_id = $('#course_id_cosv').val();
            swal({
                title: '<?php echo label('wg_delete_msg'); ?> ',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: '<?php echo label('wg_delete'); ?>',
                cancelButtonText: '<?php echo label("m_cancel"); ?>'
            }).then(function (isChk) {
              if(isChk.value){
                $.ajax({
                    url:"<?=base_url()?>index.php/course/delete_data",
                    method:"POST",
                    data:{id_delete:id,table_name:"LMS_COS_VIDEO",field:"cosv_id"},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("com_msg_delete"); ?>',
                            '',
                            'success'
                        ).then(function () {
                            var table_coursevideo = $('#myTable_videocourse').DataTable();
                            var info_coursevideo = table_coursevideo.page.info();
                            var length_coursevideo = info_coursevideo.pages;
                            var page_current_coursevideo = info_coursevideo.page;
                            fetch_data_coursevideo(cos_id,page_current_coursevideo);
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

        $(document).on('click', '.update_videocourse', function(){
            var cosv_id = $(this).attr("id");

            $('#operation_cosv').val("Edit");
            $('#cosv_id').val(cosv_id);
            $('#type_media_cosv').val('2');
            clear_dropify('cosv_thumbnail');
            clear_dropify('cosv_video');

            document.getElementById('div_multifile_url_videocourse').style.display = 'none';
            document.getElementById('div_multifile_upload_file_videocourse').style.display = '';
            var cos_id = $('#course_id_cosv').val();
            $.ajax({
                  url:"<?=base_url()?>index.php/querydata/update_cosvideo_data",
                  method:"POST",
                  data:{cosv_id:cosv_id},
                  dataType:"json",
                  success:function(data)
                  {
                        $.ajax({
                              url: '<?=base_url()?>index.php/querydata/select_lang_cosvideo',
                              type: 'POST',
                              data:{cos_id:data.cos_id,cosv_lang:data.cosv_lang},
                              success: function(data_lang){
                                  $('#cosv_lang').html(data_lang);
                              }
                        });

                        $('#cosv_th').val(data.cosv_th);
                        $('#cosv_eng').val(data.cosv_eng);

                if(data.cosv_thumbnail!=""){
                    var nameImage = "<?php echo REAL_PATH;?>/uploads/thumbnail/"+data.cosv_thumbnail
                    var drEvent = $('#cosv_thumbnail').dropify(
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
                        defaultFile: "<?php echo REAL_PATH;?>/uploads/thumbnail/"+data.cosv_thumbnail ,
                    });
                }else{
                    $('.dropify').dropify();
                }

                if(data.cosv_video!=""){
                    var nameImage = "<?php echo REAL_PATH;?>/uploads/cosvideo/"+data.cosv_video
                    var drEvent = $('#cosv_video').dropify(
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
                        defaultFile: "<?php echo REAL_PATH;?>/uploads/cosvideo/"+data.cosv_video ,
                    });
                }else{
                    $('.dropify').dropify();
                }
                        
                  }
            });
        });

        $(document).on('submit', '#upload_student_form', function(event){
              event.preventDefault();
                $("#myModal_process").addClass("in");
                $("body").addClass("modal-open");
                $("#myModal_process").css("display","block");
                $("#myModal_process").modal({backdrop: false});
              var course_id = $('#course_id_student').val();
                $.ajax({
                  url:"<?=base_url()?>index.php/insertdata/upload_student",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  dataType:"json",
                  success:function(data)
                  {
                      $("body").removeClass("modal-open");
                      $("#myModal_process").removeClass("in");
                      $("#myModal_process").css("display","none");
                    topFunction();
                    $('#result_import_student').html('');
                    if(data.status=="2"){
                        swal(
                            '<?php echo label("after_upload_file"); ?>',
                            ''
                        ).then(function () {
                            fetch_data_enroll(course_id,0);
                            topFunction();
                            $('#result_import_student').html(data.result);
                            $('#upload_student_form')[0].reset();
                            $('#course_id_student').val(course_id);
                            clear_dropify('importstudent');
                        })
                    }else if(data.status=="1"){
                        swal({
                            title: '<?php echo label("data_msg_duplicate"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            $('#upload_student_form')[0].reset();
                            $('#course_id_student').val(course_id);
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

                  },
                      error: function (jqXHR, exception) {
                      $("body").removeClass("modal-open");
                      $("#myModal_process").removeClass("in");
                      $("#myModal_process").css("display","none");
                          topFunction();
                          var msg = '';
                          if (jqXHR.status === 0) {
                              msg = 'Not connect.\n Verify Network.';
                          } else if (jqXHR.status == 404) {
                              msg = 'Requested page not found. [404]';
                          } else if (jqXHR.status == 500) {
                              msg = 'Internal Server Error [500].';
                          } else if (exception === 'parsererror') {
                              msg = 'Requested JSON parse failed.';
                          } else if (exception === 'timeout') {
                              msg = 'Time out error.';
                          } else if (exception === 'abort') {
                              msg = 'Ajax request aborted.';
                          } else {
                              msg = 'Uncaught Error.\n' + jqXHR.responseText;
                          }
                          swal({
                              title: msg,
                              text: "",
                              type: 'warning',
                              showCancelButton: false,
                              confirmButtonClass: 'btn btn-primary',
                              confirmButtonText: '<?php echo label("m_ok"); ?>'
                          })
                      },
                });
        });
        function onchange_statusadd(){
            var cos_id = $('#course_id_pp').val();
            var status_add  = document.getElementById('status_add');
            if(!status_add.checked){
                document.getElementById('div_empcode').style.display = '';
                document.getElementById('div_upload').style.display = 'none';
            }else{
                $('#course_id_student').val(cos_id);
                $('#result_import_student').html('');
                clear_dropify('importstudent');
                document.getElementById('div_empcode').style.display = 'none';
                document.getElementById('div_upload').style.display = '';
            }
        }

        function changeScore(cosen_id){
            var cos_id = $('#course_id_pp').val();
            var cosen_score = $('#cosen_score'+cosen_id).val();
              $.ajax({
                  url:"<?=base_url()?>index.php/course/update_score",
                  method:'POST',
                  data:{cosen_id:cosen_id,cosen_score:cosen_score},
                  success:function(data)
                  {
                            fetch_data_enroll(cos_id,0);
                  }
              });
        }

        function add_employeetocourse(){
            var cos_id = $('#course_id_pp').val();
            var useri = $('#useri').val();
            $('.btn_add_lerner').prop('disabled', true);
            if(useri!=""){
              $.ajax({
                  url:"<?=base_url()?>index.php/insertdata/insert_emptocourse",
                  method:'POST',
                  data:{useri:useri,cos_id:cos_id},
                  success:function(data)
                  {
                    if(data=="2"){
                        $('#useri').val('');
                        swal(
                            '<?php echo label("com_msg_success"); ?>',
                            '',
                            'success'
                        ).then(function () {
                            var table_enroll = $('#myTable_enroll').DataTable();
                            var info_enroll = table_enroll.page.info();
                            var length_enroll = info_enroll.pages;
                            var page_current_enroll = info_enroll.page;
                            fetch_data_enroll(cos_id,page_current_enroll);
                            $('.btn_add_lerner').prop('disabled', false);
                        })
                    }else if(data=="1"){
                        swal({
                            title: '<?php echo label("data_msg_duplicate"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            $('#useri').val('');
                            $('.btn_add_lerner').prop('disabled', false);
                        })
                    }else{
                        swal({
                            title: '<?php echo label("add_emptocourse_error"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            $('#useri').val('');
                            document.getElementById("useri").focus();
                            $('.btn_add_lerner').prop('disabled', false);
                        })
                    }

                  }
                });
            }else{
                        swal({
                            title: '<?php echo label("add_emptocourse_error"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            $('#useri').val('');
                            document.getElementById("useri").focus();
                            $('.btn_add_lerner').prop('disabled', false);
                        })
            }
        }
        
        function update_score_all(){
            var cos_id = $('#course_id_pp').val();
            var cosen_score_all = $('#cosen_score_all').val();
            if(qiz_score_all!=""){

              $.ajax({
                  url:"<?=base_url()?>index.php/course/insert_update_scoreall",
                  method:'POST',
                  data:{cosen_score_all:cosen_score_all,cos_id:cos_id},
                  success:function(data)
                  {
                    
                    if(data=="2"){
                        $('#cosen_score_all').val('');
                        swal(
                            '<?php echo label("com_msg_success"); ?>',
                            '',
                            'success'
                        ).then(function () {
                            var table_enroll = $('#myTable_enroll').DataTable();
                            var info_enroll = table_enroll.page.info();
                            var length_enroll = info_enroll.pages;
                            var page_current_enroll = info_enroll.page;
                            fetch_data_enroll(cos_id,page_current_enroll);
                        })
                    }else if(data=="1"){
                        swal({
                            title: '<?php echo label("data_msg_duplicate"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            $('#cosen_score_all').val('');
                        })
                    }else{
                        swal({
                            title: '<?php echo label("add_emptocourse_error"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            $('#cosen_score_all').val('');
                        })
                    }

                  }
                });
            }else{
                            swal({
                                title: '<?php echo label("com_msg_form_error"); ?>',
                                text: "",
                                type: 'warning',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-primary',
                                confirmButtonText: '<?php echo label("m_ok"); ?>'
                            }).then(function () {
                                document.getElementById("cosen_score_all").focus();
                            })
            }
        }
        function fetch_data_enroll(cos_id,page_num)
         {
            $('#myTable_enroll').DataTable().destroy();
            var table = $('#myTable_enroll').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_course_enroll/',
                    data : {cos_id:cos_id},
                    type : 'GET'
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
                  },
                <?php if($btn_print=="1"){?>
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'print'
                ]
                <?php } ?>
            });

           // Handle click on "Select all" control
           $('#chkcolall_view').on('click', function(){
              // Check/uncheck all checkboxes in the table
              var rows = table.rows({ 'search': 'applied' }).nodes();
              $('.chkall_row', rows).prop('checked', this.checked);
           });
         }

        $('.btn_sentmailmulti').click(function(){
          var values = $("input[name='selectuser[]']:checked")
              .map(function(){return $(this).val();}).get();
          var status_output = 0;
          if(values.length>0){
              for (var i = values.length - 1; i >= 0; i--) {
                cosen_id = values[i];
                if(cosen_id!=""){
                    $.ajax({
                        url:"<?=base_url()?>index.php/sendmail/sentmail_cosuser_single",
                        method:"POST",
                        data:{cosen_id:cosen_id},
                        dataType:"json",
                        success:function(data)
                        {
                          if(data.status == "2"){
                            status_output++;
                          }
                        }
                    });   
                }
              }
              //if(status_output>0){
                            swal(
                                '<?php echo label("sentmail_success"); ?>',
                                '',
                                'success'
                            ).then(function () {
                                var cos_id = $('#course_id_pp').val();
                                fetch_data_enroll(cos_id,0);
                            })
              /*}else{
                            swal({
                                title: '<?php echo label('sentmail_error'); ?>',
                                text: "",
                                type: 'warning',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-primary',
                                confirmButtonText: '<?php echo label('sv_btn_save'); ?>'
                            })
              }*/
          }else{
                            swal({
                                title: '<?php echo label('sentmail_error'); ?>',
                                text: "",
                                type: 'warning',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-primary',
                                confirmButtonText: '<?php echo label('sv_btn_save'); ?>'
                            })
          }
        });

         $(document).on('click', '.manage_quiz', function(){
            var cos_id = $('#course_id_pp').val();
            display_style("div_enroll_main","div_enroll_qiz");
            fetch_data_enroll_qiz('',0);

            $.ajax({
                url: '<?=base_url()?>index.php/querydata/select_lang_cosvideo',
                type: 'POST',
                data:{cos_id:cos_id,cosv_lang:''},
                success: function(data_lang){
                    $('#quiz_lang_test').html(data_lang);
                    $('#quiz_lang_test').val($('#quiz_lang_test option:first-child').val()).trigger('change');
                    var quiz_lang_test = $('#quiz_lang_test').val();
                    $.ajax({
                        url: '<?=base_url()?>index.php/workgroup/recheckqiz_enroll',
                        type: 'POST',
                        data:{cos_id:cos_id,cos_lang:quiz_lang_test},
                        success: function(data){
                            $('#qiz_id_enroll').html(data);
                            $('#qiz_id_enroll').val($('#qiz_id_enroll option:first-child').val()).trigger('change');
                        }
                    });
                }
            });
          });
          function onchange_quizlang(value){
            var cos_id = $('#course_id_pp').val();
            $.ajax({
                url: '<?=base_url()?>index.php/workgroup/recheckqiz_enroll',
                type: 'POST',
                data:{cos_id:cos_id,cos_lang:value},
                success: function(data){
                    $('#qiz_id_enroll').html(data);
                    $('#qiz_id_enroll').val($('#qiz_id_enroll option:first-child').val()).trigger('change');
                }
            });
          }             
        function fetch_data_enroll_qiz(qiz_id,page_num)
         {
            $('#myTable_enroll_qiz').DataTable().destroy();
            if(qiz_id!=''){
                var table = $('#myTable_enroll_qiz').DataTable({
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
                    "ajax": {
                        url : '<?=base_url()?>index.php/course/fetch_course_enroll_qiz/',
                        data : {qiz_id:qiz_id},
                        type : 'GET'
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
                  },
                <?php if($btn_print=="1"){?>
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'excel', 'print'
                    ]
                <?php } ?>
                });
            }else{
                var table = $('#myTable_enroll_qiz').DataTable({
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
                    "ajax": {
                        url : '<?=base_url()?>index.php/course/fetch_course_enroll_qiz/',
                        data : {qiz_id:''},
                        type : 'GET'
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
                  },
                <?php if($btn_print=="1"){?>
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'excel', 'print'
                    ]
                <?php } ?>
                });
            }
         }


        function qiz_update_score_all(){
            var qiz_id = $('#qiz_id_enroll').val();
            var qiz_score_all = $('#qiz_score_all').val();
            if(qiz_id!=""){
                if(qiz_score_all!=""&&parseInt(qiz_score_all)!=0){
                  $.ajax({
                      url:"<?=base_url()?>index.php/course/insert_update_scoreall_quiz",
                      method:'POST',
                      data:{qiz_score_all:qiz_score_all,qiz_id:qiz_id},
                      success:function(data)
                      {
                        
                        if(data=="2"){
                            $('#qiz_score_all').val('');
                            swal(
                                '<?php echo label("com_msg_success"); ?>',
                                '',
                                'success'
                            ).then(function () {
                                var table_enrollqiz = $('#myTable_enroll_qiz').DataTable();
                                var info_enrollqiz = table_enrollqiz.page.info();
                                var length_enrollqiz = info_enrollqiz.pages;
                                var page_current_enrollqiz = info_enrollqiz.page;
                                fetch_data_enroll_qiz(qiz_id,page_current_enrollqiz);
                            })
                        }else if(data=="1"){
                            swal({
                                title: '<?php echo label("data_msg_duplicate"); ?>',
                                text: "",
                                type: 'warning',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-primary',
                                confirmButtonText: '<?php echo label("m_ok"); ?>'
                            }).then(function () {
                                $('#qiz_score_all').val('');
                            })
                        }else{
                            swal({
                                title: '<?php echo label("add_emptocourse_error"); ?>',
                                text: "",
                                type: 'warning',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-primary',
                                confirmButtonText: '<?php echo label("m_ok"); ?>'
                            }).then(function () {
                                $('#qiz_score_all').val('');
                            })
                        }
                      }
                    });
                }else{
                            swal({
                                title: '<?php echo label("com_msg_form_error"); ?>',
                                text: "",
                                type: 'warning',
                                showCancelButton: false,
                                confirmButtonClass: 'btn btn-primary',
                                confirmButtonText: '<?php echo label("m_ok"); ?>'
                            }).then(function () {
                                document.getElementById("qiz_score_all").focus();
                            })
                }
            }else{
                swal({
                            title: '<?php echo label("no_quiz"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            $('#qiz_score_all').val('');
                            $('#qiz_id_enroll').focus();
                        })
            }
        }

         $(document).on('click', '.delete_enroll', function(){
            var cosen_id = $(this).attr("id");
            var cos_id = $('#course_id_pp').val();
            $('#cos_id_enroll').val(cos_id);
            $('#cosen_id_enroll').val(cosen_id);
            $('#cosen_cancelnote').val('');

            topFunction();

              swal({
                title: '<?php echo label('wg_delete_msg'); ?> ',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: '<?php echo label('wg_delete'); ?>',
                cancelButtonText: '<?php echo label("m_cancel"); ?>'
            }).then(function (isChk) {
              if(isChk.value){
                $.ajax({
                    url:"<?=base_url()?>index.php/course/enroll_cancel",
                    method:"POST",
                    data:{cosen_id_enroll:cosen_id,cosen_cancelnote:''},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("com_msg_delete"); ?>',
                            '',
                            'success'
                        ).then(function () {
                            topFunction();
                            fetch_data_enroll(cos_id,0);
                            fetch_data_register(cos_id,0);
                        })
                      }else if(data == "1"){
                         swal({
                            title: '<?php echo label('wg_msg_use'); ?>',
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

        $(document).on('submit', '#enroll_cancel_form', function(event){
              event.preventDefault();
              var cos_id_enroll = $('#cos_id_enroll').val();
              var cosen_cancelnote = $('#cosen_cancelnote').val();
              var cosen_id_enroll = $('#cosen_id_enroll').val();
              swal({
                title: '<?php echo label('wg_delete_msg'); ?> ',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: '<?php echo label('wg_delete'); ?>',
                cancelButtonText: '<?php echo label("m_cancel"); ?>'
            }).then(function (isChk) {
              if(isChk.value){
                $.ajax({
                    url:"<?=base_url()?>index.php/course/enroll_cancel",
                    method:"POST",
                    data:{cosen_id_enroll:cosen_id_enroll,cosen_cancelnote:cosen_cancelnote},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("com_msg_delete"); ?>',
                            '',
                            'success'
                        ).then(function () {
                            topFunction();
                            $('#cosen_cancelnote').val('');
                            display_style("div_enroll_main","div_enroll_cancel");
                            fetch_data_enroll(cos_id_enroll,0);
                            fetch_data_register(cos_id_enroll,0);
                        })
                      }else if(data == "1"){
                         swal({
                            title: '<?php echo label('wg_msg_use'); ?>',
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

         $(document).on('click', '.Reenroll', function(){
            var cosen_id = $(this).attr("id");
            var cos_id = $('#course_id_pp').val();
            swal({
                title: '<?php echo label('enroll_msg_reuse'); ?> ',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: '<?php echo label('enroll_reuse'); ?>',
                cancelButtonText: '<?php echo label("m_cancel"); ?>'
            }).then(function (isChk) {
              if(isChk.value){
                $.ajax({
                    url:"<?=base_url()?>index.php/course/delete_data_updateval",
                    method:"POST",
                    data:{id_update:cosen_id,field_id:"cosen_id",table_name:"LMS_COS_ENROLL",field:"cosen_status",val:"1"},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("enroll_reuse_success"); ?>',
                            '',
                            'success'
                        ).then(function () {
                            fetch_data_enroll(cos_id,0);
                        })
                      }else if(data == "1"){
                         swal({
                            title: '<?php echo label('wg_msg_use'); ?>',
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
         
                          
        function fetch_data_qizcriteria(page_num)
         {
            var qiz_id = $('#qiz_id_criteriascore').val();
            $('#myTable_criteria_score').DataTable().destroy();
            var table = $('#myTable_criteria_score').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_course_qiz_criteriascore/',
                    data : {qiz_id:qiz_id},
                    type : 'GET'
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
                          
        function fetch_data_survey(cos_id,page_num)
         {
            $('#myTable_cos_id_survey').DataTable().destroy();
            var table = $('#myTable_cos_id_survey').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_course_survey/',
                    data : {cos_id:cos_id},
                    type : 'GET'
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
                          
        function fetch_data_survey_detail(sv_id,page_num)
         {
            $('#myTable_survey_detail').DataTable().destroy();
            var table = $('#myTable_survey_detail').DataTable({
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
                "ajax": {
                    url : '<?=base_url()?>index.php/fetchdata/fetch_course_survey_detail/',
                    data : {sv_id:sv_id},
                    type : 'GET'
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

        $(document).on('submit', '#survey_form', function(event){
              event.preventDefault();
              var course_id = $('#course_id_pp').val();
                $("#myModal_process").addClass("in");
                $("body").addClass("modal-open");
                $("#myModal_process").css("display","block");
                $("#myModal_process").modal({backdrop: false});

                var survey_open_var = $('#survey_open_var').val();
                var time_start = $('#time_start_survey').val();
                if(time_start==""){
                  time_start = "00:00";
                }
                var survey_end_var = $('#survey_end_var').val();
                var time_end = $('#time_end_survey').val();
                if(time_end==""){
                  time_end = "00:00";
                }
                var val_chk = 1;
                var survey_open = $('#survey_open').val();
                var survey_end = $('#survey_end').val();
                if(survey_open!=""||survey_end!=""){
                  if(survey_open!=""&&survey_end!=""){
                    survey_open_var = survey_open_var+" "+time_start+":00";
                    survey_end_var = survey_end_var+" "+time_end+":00";
                    start_date = survey_open_var.replace(/-/g, "/");
                    end_date = survey_end_var.replace(/-/g, "/");
                    var d_start = new Date(start_date);
                    var d_end = new Date(end_date);
                    if(survey_open_var==survey_end_var){
                      $('#time_end_survey').focus();
                      val_chk = 0;
                    }else if(d_start>d_end){
                      $('#survey_end').val("");
                      $('#survey_end_var').val("");
                      $('#survey_end').focus();
                      val_chk = 0;
                    }
                  }else if(survey_open==""&&survey_end!=""){
                    $('#survey_open').focus();
                    val_chk = 0;
                  }else if(survey_open!=""&&survey_end==""){
                    $('#survey_end').focus();
                    val_chk = 0;
                  }
                }
                if(val_chk==1){
                      $.ajax({
                        url:"<?=base_url()?>index.php/insertdata/insert_survey",
                        method:'POST',
                        data:new FormData(this),
                        contentType:false,
                        processData:false,
                        dataType:"json",
                        success:function(data)
                        {                    
                            $("body").removeClass("modal-open");
                            $("#myModal_process").removeClass("in");
                            $("#myModal_process").css("display","none");
                          topFunction();
                          if(data.status=="2"){
                              swal(
                                  '<?php echo label("com_msg_success"); ?>',
                                  '',
                                  'success'
                              ).then(function () {
                                  $('#survey_form')[0].reset();
                                  display_style('div_create_survey','div_survey');
                                  $('#course_id_survey').val(course_id);
                                  fetch_data_survey(course_id,0);
                              })
                          }else if(data.status=="1"){
                              swal({
                                  title: '<?php echo label("data_msg_duplicate"); ?>',
                                  text: "",
                                  type: 'warning',
                                  showCancelButton: false,
                                  confirmButtonClass: 'btn btn-primary',
                                  confirmButtonText: '<?php echo label("m_ok"); ?>'
                              }).then(function () {
                                  $('#survey_form')[0].reset();
                                  $('#course_id_survey').val(course_id);
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

                        },
                            error: function (jqXHR, exception) {
                            $("body").removeClass("modal-open");
                            $("#myModal_process").removeClass("in");
                            $("#myModal_process").css("display","none");
                                topFunction();
                                var msg = '';
                                if (jqXHR.status === 0) {
                                    msg = 'Not connect.\n Verify Network.';
                                } else if (jqXHR.status == 404) {
                                    msg = 'Requested page not found. [404]';
                                } else if (jqXHR.status == 500) {
                                    msg = 'Internal Server Error [500].';
                                } else if (exception === 'parsererror') {
                                    msg = 'Requested JSON parse failed.';
                                } else if (exception === 'timeout') {
                                    msg = 'Time out error.';
                                } else if (exception === 'abort') {
                                    msg = 'Ajax request aborted.';
                                } else {
                                    msg = 'Uncaught Error.\n' + jqXHR.responseText;
                                }
                                swal({
                                    title: msg,
                                    text: "",
                                    type: 'warning',
                                    showCancelButton: false,
                                    confirmButtonClass: 'btn btn-primary',
                                    confirmButtonText: '<?php echo label("m_ok"); ?>'
                                })
                            },
                      });
                }else{
                        $("body").removeClass("modal-open");
                        $("#myModal_process").removeClass("in");
                        $("#myModal_process").css("display","none");
                        topFunction();
                        swal({
                            title: '<?php echo label("com_msg_error_save"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        })
                }
        });

        $(document).on('click', '.update_survey', function(){
            var sv_id = $(this).attr("id");
            document.getElementById('div_survey_detail').style.display = 'none';
            //var com_id = $('com_id_survey').val();
            var cos_id = $('course_id_survey').val();
            //$('#survey_form')[0].reset();
            $('#operation_survey').val("Edit");
            $('#txthead_survey').text('<?php echo label("edit_survey"); ?>');
            $('#sv_id').val(sv_id);

                        $(function () {
                          from = $('#survey_open').datepicker({
                                  <?php if($lang=="thai"){ ?>
                                        language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                                        thaiyear: true,  
                                  <?php } ?>
                                  format: 'dd/mm/yyyy',
                                  autoclose: true
                          }).on('changeDate', function (selected) {
                              $('#survey_end').datepicker('setStartDate', selected.date);
                              $("#survey_end").datepicker( "setDate", selected.date);
                          });
                           to = $('#survey_end').datepicker({
                                  <?php if($lang=="thai"){ ?>
                                        language: 'th',             //เปลี่ยน label ต่างของ ปฏิทิน ให้เป็น ภาษาไทย   (ต้องใช้ไฟล์ bootstrap-datepicker.th.min.js นี้ด้วย)
                                        thaiyear: true,  
                                  <?php } ?>
                                  format: 'dd/mm/yyyy',
                                  autoclose: true
                          })
                        })
            val_lang('0','input_survey_th','sv_title_','th');
            val_lang('0','input_survey_eng','sv_title_','eng');
            $.ajax({
                  url:"<?=base_url()?>index.php/querydata/update_survey_detail_data",
                  method:"POST",
                  data:{sv_id_update:sv_id},
                  dataType:"json",
                  success:function(data)
                  {

                      $.ajax({
                          url: '<?=base_url()?>index.php/querydata/query_course_detail_data',
                          type: 'POST',
                          data:{cos_id:data.cos_id},
                          dataType:"json",
                          success: function(datasetDate){
                            if(datasetDate.isData=="1"){
                                var start_date = datasetDate.date_start_var.split("-");
                                var StartDate = start_date[2]+"/"+start_date[1]+"/"+(parseInt(start_date[0]));
                                var end_date = datasetDate.date_end_var.split("-");
                                var EndDate = end_date[2]+"/"+end_date[1]+"/"+(parseInt(end_date[0]));
                                $('#survey_open').datepicker('setStartDate', StartDate);
                                $('#survey_end').datepicker('setStartDate', StartDate);
                                $('#survey_end').datepicker('setEndDate', EndDate);
                                $('#survey_open').datepicker('setEndDate', EndDate);
                            }
                          }
                        });
                        $.ajax({
                              url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                              type: 'POST',
                              data:{cos_id:data.cos_id,les_lang:''},
                              dataType:"json",
                              success: function(datalang){
                                for (var i = datalang.arr_lang.length - 1; i >= 0; i--) {
                                  if(datalang.arr_lang[i]=="th"){
                                    val_lang('1','input_survey_th','sv_title_','th');
                                    $('#sv_title_th').val(data.sv_title_th);
                                    $('#sv_explanation_th').val(data.sv_explanation_th);
                                  }
                                  if(datalang.arr_lang[i]=="eng"){
                                    val_lang('1','input_survey_eng','sv_title_','eng');
                                    $('#sv_title_eng').val(data.sv_title_eng);
                                    $('#sv_explanation_eng').val(data.sv_explanation_eng);
                                  }
                                }
                                
                                $('#sv_lang').val(data.val_lang);
                                $.ajax({
                                      url: '<?=base_url()?>index.php/workgroup/recheckquestionnaire',
                                      type: 'POST',
                                      data:{qn_id:data.qn_id,cos_lang:datalang.val_lang,cos_id:data.cos_id},
                                      success: function(dataqn){
                                        
                                        $('#qn_id').html(dataqn);
                                      }
                                });
                              }
                        });
                        $('#course_id_survey').val(data.cos_id);
                        if(data.sv_suggestion_status=="0"){
                            document.getElementById("sv_suggestion_status").checked = false;
                        }else{
                            document.getElementById("sv_suggestion_status").checked = true;
                        }

                        if(data.sv_status=="0"){
                            document.getElementById("sv_status").checked = false;
                        }else{
                            document.getElementById("sv_status").checked = true;
                        }

                        $('#survey_open_var').val(data.survey_open_var);
                        $('#survey_end_var').val(data.survey_end_var);
                        $('#time_start_survey').val(data.time_start);
                        $('#time_end_survey').val(data.time_end);

                        $('#sv_rank').val(data.sv_rank);
                        if(data.survey_open!=""&&data.survey_end!=""){
                          $("#survey_open").datepicker( "setDate", data.survey_open);
                          $("#survey_end").datepicker( "setDate", data.survey_end);
                        }else{
                          $('#survey_open').val('');
                          $('#survey_end').val('');
                        }
                  }
            });
            display_style('div_create_survey','div_survey');
        });
  
        function btnprevious_survey(){
            var course_id = $('#course_id_pp').val();
            fetch_data_survey(course_id,0);
            document.getElementById('div_survey_main').style.display = "";
            document.getElementById('div_survey').style.display = "";
            document.getElementById('div_survey_detail').style.display = "none";
        }

         $(document).on('click', '.delete_survey', function(){
            var sv_id = $(this).attr("id");
            var course_id = $('#course_id_pp').val();
            swal({
                title: '<?php echo label('wg_delete_msg'); ?> ',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: '<?php echo label('wg_delete'); ?>',
                cancelButtonText: '<?php echo label("m_cancel"); ?>'
            }).then(function (isChk) {
              if(isChk.value){
                $.ajax({
                    url:"<?=base_url()?>index.php/manage/delete_survey",
                    method:"POST",
                    data:{sv_id:sv_id},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("com_msg_delete"); ?>',
                            '',
                            'success'
                        ).then(function () {
                            fetch_data_survey(course_id,0);
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


        $(document).on('click', '.survey_detail', function(){
            var sv_id = $(this).attr("id");
            var cos_id = $('#course_id_pp').val();
            document.getElementById('div_survey').style.display = 'none';
            document.getElementById('div_create_survey').style.display = 'none';
            document.getElementById('div_survey_main').style.display = 'none';
            document.getElementById('div_import_survey_detail').style.display = 'none';
            document.getElementById('div_survey_detail').style.display = '';
            display_disable('div_create_survey_detail','div_sv_survey_detail');

            $('#survey_detail_form')[0].reset();
            $('#sv_id_detail').val(sv_id);
            $('#sv_id_detail_import').val(sv_id);
            $('#result_import_survey').html('');
            $('#cos_id_detail').val(cos_id);
            $('#course_id_survey').val(cos_id);
            fetch_data_survey_detail(sv_id,0);
            $.ajax({
                url:"<?=base_url()?>index.php/querydata/update_survey_detail_data",
                method:"POST",
                data:{sv_id_update:sv_id},
                dataType:"json",
                success:function(data)
                {
                    $('#cos_id_detail').val(data.cos_id);
                    $('#course_id_survey').val(data.cos_id);
                    $('#sv_name_txt').text(data.sv_title);
                }
            });
                $.ajax({
                    url:"<?=base_url()?>index.php/querydata/query_coursemain",
                    method:"POST",
                    data:{cos_id:cos_id},
                    dataType:"json",
                    success:function(data)
                    {

                    <?php if($btn_add=="1"){ ?>
                        $('#import_survey_detail').show();
                        $('#add_survey_detail').show();
                    <?php } ?>
                        <?php if($user['u_id']!="1"){ ?>
                        if(data.cos_approve=="1"){
                        $('#import_survey_detail').hide();
                        $('#add_survey_detail').hide();
                        }
                        <?php } ?>
                    }
                });
        });

        $(document).on('click', '.update_survey_detail', function(){
            var svde_id = $(this).attr("id");
            document.getElementById('div_survey_main').style.display = 'none';
            document.getElementById('div_import_survey_detail').style.display = 'none';
            //var com_id = $('com_id_survey').val();
            var cos_id = $('#cos_id_detail').val();
            var sv_id = $('#sv_id_detail').val();
            $('#survey_detail_form')[0].reset();
            $('#operation_survey_detail').val("Edit");
            $('#txthead_survey_detail').text('<?php echo label("edit_question"); ?>');
            $('#svde_id').val(svde_id);
            val_lang('0','input_surveydetail_th','svde_heading_','th');
            val_lang('0','input_surveydetail_eng','svde_heading_','eng');
            document.getElementById('svde_heading_th').required = false;
            document.getElementById('svde_heading_eng').required = false;
            document.getElementById('svde_detail_th').required = false;
            document.getElementById('svde_detail_eng').required = false;
            $.ajax({
                  url:"<?=base_url()?>index.php/course/update_survey_sv_detail_data",
                  method:"POST",
                  data:{svde_id_update:svde_id},
                  dataType:"json",
                  success:function(data)
                  {

                        if(data.svde_suggestionactive=="0"){
                            document.getElementById("svde_suggestionactive").checked = false;
                        }else{
                            document.getElementById("svde_suggestionactive").checked = true;
                        }
                      $.ajax({
                          url:"<?=base_url()?>index.php/querydata/update_survey_detail_data",
                          method:"POST",
                          data:{sv_id_update:data.sv_id},
                          dataType:"json",
                          success:function(datasv)
                          {
                            $.ajax({
                                  url: '<?=base_url()?>index.php/querydata/select_lang_lesson',
                                  type: 'POST',
                                  data:{cos_id:datasv.cos_id,les_lang:''},
                                  dataType:"json",
                                  success: function(datalang){
                                    for (var i = datalang.arr_lang.length - 1; i >= 0; i--) {
                                      if(datalang.arr_lang[i]=="th"){
                                        val_lang('1','input_surveydetail_th','svde_heading_','th');
                                        $('#svde_heading_th').val(data.svde_heading_th);
                                        $('#svde_detail_th').val(data.svde_detail_th);
                                        document.getElementById('svde_heading_th').required = true;
                                        document.getElementById('svde_detail_th').required = true;
                                      }
                                      if(datalang.arr_lang[i]=="eng"){
                                        val_lang('1','input_surveydetail_eng','svde_heading_','eng');
                                        $('#svde_heading_eng').val(data.svde_heading_eng);
                                        $('#svde_detail_eng').val(data.svde_detail_eng);
                                        document.getElementById('svde_heading_eng').required = true;
                                        document.getElementById('svde_detail_eng').required = true;
                                      }
                                    }
                                  }
                            });
                          }
                      });
                  }
            });
            display_style('div_create_survey_detail','div_sv_survey_detail');
        });

        $(document).on('submit', '#survey_detail_form', function(event){
              event.preventDefault();
              var course_id = $('#course_id_survey').val();
              var sv_id = $('#sv_id_detail').val();
                $.ajax({
                  url:"<?=base_url()?>index.php/insertdata/insert_survey_detail",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  dataType:"json",
                  success:function(data)
                  {                    
                    if(data.status=="2"){
                        swal(
                            '<?php echo label("com_msg_success"); ?>',
                            '',
                            'success'
                        ).then(function () {
                            $('#survey_detail_form')[0].reset();
                            display_style('div_create_survey_detail','div_sv_survey_detail');
                            $('#course_id_survey').val(course_id);
                            $('#sv_id_detail').val(sv_id);
                            $('#sv_id_detail_import').val(sv_id);
                            fetch_data_survey_detail(sv_id,0);
                        })
                    }else if(data.status=="1"){
                        swal({
                            title: '<?php echo label("data_msg_duplicate"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            $('#survey_detail_form')[0].reset();
                            $('#course_id_survey').val(course_id);
                            $('#com_id_survey').val(com_id);
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

                  },
                      error: function (jqXHR, exception) {
                          topFunction();
                          var msg = '';
                          if (jqXHR.status === 0) {
                              msg = 'Not connect.\n Verify Network.';
                          } else if (jqXHR.status == 404) {
                              msg = 'Requested page not found. [404]';
                          } else if (jqXHR.status == 500) {
                              msg = 'Internal Server Error [500].';
                          } else if (exception === 'parsererror') {
                              msg = 'Requested JSON parse failed.';
                          } else if (exception === 'timeout') {
                              msg = 'Time out error.';
                          } else if (exception === 'abort') {
                              msg = 'Ajax request aborted.';
                          } else {
                              msg = 'Uncaught Error.\n' + jqXHR.responseText;
                          }
                          swal({
                              title: msg,
                              text: "",
                              type: 'warning',
                              showCancelButton: false,
                              confirmButtonClass: 'btn btn-primary',
                              confirmButtonText: '<?php echo label("m_ok"); ?>'
                          })
                      },
                });
        });

         $(document).on('click', '.delete_survey_detail', function(){
            var svde_id = $(this).attr("id");
            var sv_id = $('#sv_id_detail').val();
            swal({
                title: '<?php echo label('wg_delete_msg'); ?> ',
                text: "",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: '<?php echo label('wg_delete'); ?>',
                cancelButtonText: '<?php echo label("m_cancel"); ?>'
            }).then(function (isChk) {
              if(isChk.value){
                $.ajax({
                    url:"<?=base_url()?>index.php/manage/delete_survey_detail",
                    method:"POST",
                    data:{svde_id:svde_id},
                    success:function(data)
                    {
                      if(data == "2"){
                        swal(
                            '<?php echo label("com_msg_delete"); ?>',
                            '',
                            'success'
                        ).then(function () {
                            fetch_data_survey_detail(sv_id,0);
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

                    
        $(document).on('submit', '#survey_detail_import_form', function(event){
              event.preventDefault();
              var sv_id = $('#sv_id_detail_import').val();
              var file_import = $('#file_import_survey').val();
                $("#myModal_process").addClass("in");
                $("body").addClass("modal-open");
                $("#myModal_process").css("display","block");
                $("#myModal_process").modal({backdrop: false});
              if(file_import!=""){
                $.ajax({
                  url:"<?=base_url()?>index.php/setting/import_survey",
                  method:'POST',
                  data:new FormData(this),
                  contentType:false,
                  processData:false,
                  dataType:"json",
                  success:function(data)
                  {
                      $("body").removeClass("modal-open");
                      $("#myModal_process").removeClass("in");
                      $("#myModal_process").css("display","none");
                    if(data.status=="2"){
                        $('#survey_detail_import_form')[0].reset();
                        swal(
                            '<?php echo label("after_upload_file"); ?>',
                            ''
                        ).then(function () {
                            topFunction();
                            $('#sv_id_detail_import').val(sv_id);
                            $('#result_import_survey').html(data.result);
                            clear_dropify('file_import_survey');
                            fetch_data_survey_detail(sv_id,0);
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
                            document.getElementById("file_import_survey").focus();
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

                  },
                      error: function (jqXHR, exception) {
                      $("body").removeClass("modal-open");
                      $("#myModal_process").removeClass("in");
                      $("#myModal_process").css("display","none");
                          topFunction();
                          var msg = '';
                          if (jqXHR.status === 0) {
                              msg = 'Not connect.\n Verify Network.';
                          } else if (jqXHR.status == 404) {
                              msg = 'Requested page not found. [404]';
                          } else if (jqXHR.status == 500) {
                              msg = 'Internal Server Error [500].';
                          } else if (exception === 'parsererror') {
                              msg = 'Requested JSON parse failed.';
                          } else if (exception === 'timeout') {
                              msg = 'Time out error.';
                          } else if (exception === 'abort') {
                              msg = 'Ajax request aborted.';
                          } else {
                              msg = 'Uncaught Error.\n' + jqXHR.responseText;
                          }
                          swal({
                              title: msg,
                              text: "",
                              type: 'warning',
                              showCancelButton: false,
                              confirmButtonClass: 'btn btn-primary',
                              confirmButtonText: '<?php echo label("m_ok"); ?>'
                          })
                      },
                });
              }else{
                      $("body").removeClass("modal-open");
                      $("#myModal_process").removeClass("in");
                      $("#myModal_process").css("display","none");
                    $( "#myModal_process" ).removeClass( "show" ).addClass( "hide" );
                        swal({
                            title: '<?php echo label("manageimport_msgerror"); ?>',
                            text: "",
                            type: 'warning',
                            showCancelButton: false,
                            confirmButtonClass: 'btn btn-primary',
                            confirmButtonText: '<?php echo label("m_ok"); ?>'
                        }).then(function () {
                            document.getElementById("file_import_survey").focus();
                        })
              }
         });
</script>