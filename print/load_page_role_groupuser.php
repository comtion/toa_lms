<?php 
include("../excel_export/conn.php");
mysqli_query($conndb,"SET NAMES 'utf8'");
    $ug_id = isset($_REQUEST['ug_id']) ? $_REQUEST['ug_id'] : ''; 
    $num_chk = isset($_REQUEST['num_chk']) ? $_REQUEST['num_chk'] : ''; 
?>
<!DOCTYPE html>
<html>
    <head>

    </head>


    <body>

        <!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>
        <br>

                    <div class="page-content-wrapper ">

                        <div class="container-fluid">
                            <div class="card bg-light mb-3">
                              <div class="card-body">
                                    <div id="taa_table" class="table-responsive" >
                                        <?php 

                                                        $sql_menu =  "select * from LMS_MENU";
                                                        $query_menu = mysqli_query($conndb,$sql_menu);
                                                        print_r($query_menu);?>
                                            <table id="datatable" width="100%" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <td align="center" width="10%">ลำดับ</td>
                                                        <td align="center" width="40%">ชื่อเมนู</td>
                                                        <td align="center" width="10%">เปิดใช้งาน</td>
                                                        <td align="center" width="10%">เพิ่ม</td>
                                                        <td align="center" width="10%">แก้ไข</td>
                                                        <td align="center" width="10%">ลบ</td>
                                                        <td align="center" width="10%">พิมพ์</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        $num = 1;
                                                        while($fetch_menu = mysqli_fetch_array($query_menu)){ 
                                                            $chkenable = 0;
                                                            $chkadd = 0;
                                                            $chkedit = 0;
                                                            $chkdel = 0;
                                                            $chkprint = 0;
                                                            $sql_chk = "select * from LMS_ROLE_GP where ug_id = '".$ug_id."' and mu_id = '".$fetch_menu['mu_id']."'";
                                                            $query_chk = mysqli_query($conndb,$sql_chk);
                                                            $num_check = mysqli_num_rows($query_chk);
                                                            if($num_check>0){
                                                                $fetch_chk = mysqli_fetch_array($query_chk);
                                                                $chkenable = intval($fetch_chk['rgu_view']);
                                                                $chkadd = intval($fetch_chk['rgu_add']);
                                                                $chkedit = intval($fetch_chk['rgu_edit']);
                                                                $chkdel = intval($fetch_chk['rgu_del']);
                                                                $chkprint = intval($fetch_chk['rgu_print']);
                                                            }
                                                            ?>
                                                    <tr>
                                                        <td align="center" width="10%"><?php echo $num;$num++; ?></td>
                                                        <td align="left" width="40%"><?php echo $fetch_menu['mu_menu'];?></td>
                                                        <td align="center" width="10%"><input type="checkbox" id="chkenable_<?php echo $fetch_menu['mu_id']; ?>" name="chkenable_<?php echo $fetch_menu['mu_id']; ?>" onchange="chk_chkbox('chkenable','<?php echo $fetch_menu['mu_id'] ?>')" value="1" <?php if($chkenable==1){echo "checked";} ?>></td>
                                                        <td align="center" width="10%"><input type="checkbox" id="chkadd_<?php echo $fetch_menu['mu_id']; ?>" name="chkadd_<?php echo $fetch_menu['mu_id']; ?>" onchange="chk_chkbox('chkadd','<?php echo $fetch_menu['mu_id'] ?>')" value="1" <?php if($chkadd==1){echo "checked";} ?>></td>
                                                        <td align="center" width="10%"><input type="checkbox" id="chkedit_<?php echo $fetch_menu['mu_id']; ?>" name="chkedit_<?php echo $fetch_menu['mu_id']; ?>" onchange="chk_chkbox('chkedit','<?php echo $fetch_menu['mu_id'] ?>')" value="1" <?php if($chkedit==1){echo "checked";} ?>></td>
                                                        <td align="center" width="10%"><input type="checkbox" id="chkdel_<?php echo $fetch_menu['mu_id']; ?>" name="chkdel_<?php echo $fetch_menu['mu_id']; ?>" onchange="chk_chkbox('chkdel','<?php echo $fetch_menu['mu_id'] ?>')" value="1" <?php if($chkdel==1){echo "checked";} ?>></td>
                                                        <td align="center" width="10%"><input type="checkbox" id="chkprint_<?php echo $fetch_menu['mu_id']; ?>" name="chkprint_<?php echo $fetch_menu['mu_id']; ?>" onchange="chk_chkbox('chkprint','<?php echo $fetch_menu['mu_id'] ?>')" value="1" <?php if($chkprint==1){echo "checked";} ?>></td>
                                                    </tr>     
                                                    <?php }
                                                    ?>
                                                </tbody>
                                            </table>
                                    </div>
                              </div>
                            </div>
                        </div><!-- container -->
                    </div> <!-- Page content Wrapper -->



        <!-- jQuery  -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/modernizr.min.js"></script>
        <script src="assets/js/detect.js"></script>
        <script src="assets/js/fastclick.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/jquery.blockUI.js"></script>
        <script src="assets/js/waves.js"></script>
        <script src="assets/js/jquery.nicescroll.js"></script>
        <script src="assets/js/jquery.scrollTo.min.js"></script>
        
        <!-- Required datatable js -->
        <script src="assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="assets/plugins/datatables/dataTables.bootstrap4.min.js"></script>
        <!-- Buttons examples -->
        <script src="assets/plugins/datatables/dataTables.buttons.min.js"></script>
        <script src="assets/plugins/datatables/buttons.bootstrap4.min.js"></script>
        <script src="assets/plugins/datatables/jszip.min.js"></script>
        <script src="assets/plugins/datatables/pdfmake.min.js"></script>
        <script src="assets/plugins/datatables/vfs_fonts.js"></script>
        <script src="assets/plugins/datatables/buttons.html5.min.js"></script>
        <script src="assets/plugins/datatables/buttons.print.min.js"></script>
        <script src="assets/plugins/datatables/buttons.colVis.min.js"></script>
        <!-- Responsive examples -->
        <script src="assets/plugins/datatables/dataTables.responsive.min.js"></script>
        <script src="assets/plugins/datatables/responsive.bootstrap4.min.js"></script>

        <!-- Sweet-Alert  -->
        <script src="assets/plugins/sweet-alert2/sweetalert2.min.js"></script>
        <script src="assets/pages/sweet-alert.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>

        <script type="text/javascript">
            function chk_chkbox(name='',mu_id=''){
                console.log(name,mu_id);
                var ug_id = '<?php echo $ug_id; ?>';
                var value_chk = 0;
                var field_sql = "";
                var remember = document.getElementById(name+'_'+mu_id);
                if (remember.checked){
                    value_chk = 1;
                }
                if(name=="chkenable"){
                    field_sql = "rgu_view";
                }else if(name=="chkadd"){
                    field_sql = "rgu_add";
                }else if(name=="chkedit"){
                    field_sql = "rgu_edit";
                }else if(name=="chkdel"){
                    field_sql = "rgu_del";
                }else if(name=="chkprint"){
                    field_sql = "rgu_print";
                }
                console.log('check_var : '+value_chk);
                $.ajax({
                  url:"process/load_data_groupcus.php",
                  method:"POST",
                  data:{field_sql_ug:field_sql,value_chk_ug:value_chk,ug_idonrole_ug:ug_id,mu_idonrole_ug:mu_id},
                  dataType:"json",
                  success:function(data)
                  {
                    console.log(data);               
                  }
                });
            }
        </script>
    </body>
</html>