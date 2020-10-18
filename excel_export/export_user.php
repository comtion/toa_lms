<?php

header('Content-type: application/vnd.ms-excel');

//// It will be called file.xls

header('Content-Disposition: attachment; filename="User Information.xls"');

$com_id = isset($_REQUEST['com_id']) ? $_REQUEST['com_id'] : '';
// Create new PHPExcel object

$letters=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');

include("conn.php");
mysqli_query($conndb,"SET NAMES 'utf8'");

  $arr_ug = array();
  $arr_depart = array();
  $arr_posi = array();

  $sql_ug = "select * from LMS_USP_GP";
  $query_ug = mysqli_query($conndb,$sql_ug);
  $num_ug = mysqli_num_rows($query_ug);
  if($num_ug>0){
      while ($fetch_ug = mysqli_fetch_array($query_ug)) {
        $arr_ug[$fetch_ug['ug_id']]['name_th'] = $fetch_ug['ug_name_th'];
        $arr_ug[$fetch_ug['ug_id']]['name_en'] = $fetch_ug['ug_name_en'];
      }
  }
  $sql_dep = "select * from LMS_DEPART";
  $query_dep = mysqli_query($conndb,$sql_dep);
  $num_dep = mysqli_num_rows($query_dep);
  if($num_dep>0){
      while ($fetch_dep = mysqli_fetch_array($query_dep)) {
        $arr_dep[$fetch_dep['dep_id']]['name_th'] = $fetch_dep['dep_name_th'];
        $arr_dep[$fetch_dep['dep_id']]['name_en'] = $fetch_dep['dep_name_en'];
      }
  }
  $sql_posi = "select * from LMS_POSITION";
  $query_posi = mysqli_query($conndb,$sql_posi);
  $num_posi = mysqli_num_rows($query_posi);
  if($num_posi>0){
      while ($fetch_posi = mysqli_fetch_array($query_posi)) {
        $arr_posi[$fetch_posi['posi_id']]['name_th'] = $fetch_posi['posi_name_th'];
        $arr_posi[$fetch_posi['posi_id']]['name_en'] = $fetch_posi['posi_name_en'];
      }
  }

  $sql_com = "select * from LMS_COMPANY where com_id='".$com_id."'";
  $query_com = mysqli_query($conndb,$sql_com);
  $fetch_com = mysqli_fetch_array($query_com);

  $sql_emp = "select * from LMS_EMP inner join LMS_USP on LMS_EMP.emp_id = LMS_USP.emp_id where LMS_EMP.com_id='".$com_id."' and LMS_EMP.emp_isDelete='0' and LMS_USP.u_isDelete='0'";
  $query_emp = mysqli_query($conndb,$sql_emp);
?>

<?php 

  function data_rechk($conndb,$sv_id='',$num=''){
	$sql_detail = "select LMS_QN_USER_DE.svde_id,LMS_QN_USER_DE.qnude_var from LMS_SURVEY_DE inner join LMS_QN_USER_DE on LMS_SURVEY_DE.svde_id = LMS_QN_USER_DE.svde_id where LMS_SURVEY_DE.sv_id = '".$sv_id."' and LMS_QN_USER_DE.qnude_var='".$num."'";
	$query_detail = mysqli_query($conndb,$sql_detail);
	$num_detail = mysqli_num_rows($query_detail);
    return $query_detail;
  }

  echo '<html xmlns:o="urn:schemas-microsoft-com:office:office"xmlns:x="urn:schemas-microsoft-com:office:excel"xmlns="http://www.w3.org/TR/REC-html40">';
?>
<meta http-equiv=Content-Type content="text/html; charset=utf-8">

<body>
 
<table width="100%"  id="tbl1" class="table2excel" border="1" style="border-collapse: collapse;border: 1px solid black;">
  <thead>
    <tr>
      <th>Company's email*</th>
      <th>User Group*</th>
      <th>Company Code (Nick Name)*</th>
      <th>Department*</th>
      <th>Position*</th>
      <th>Manager 1 company's Email*</th>
      <th>Manager 2 company's Email</th>
      <th>Name TH*</th>
      <th>Lastname TH*</th>
      <th>Name ENG*</th>
      <th>Lastname ENG*</th>
      <!-- <th>Phone</th>
      <th>Mobile</th>
      <th>Date of employment (28/03/2019)</th> -->
      <th>System start date*</th>
      <th>System usage end date</th>
    </tr>
  </thead>
  <tbody>
    <?php
      $num_emp = mysqli_num_rows($query_emp); 
      if($num_emp>0){
        while($fetch_emp = mysqli_fetch_array($query_emp)){
    ?>
    <tr>
      <td><?php echo $fetch_emp['useri']; ?></td>
      <td><?php echo $arr_ug[$fetch_emp['ug_id']]['name_en']; ?></td>
      <td><?php echo $fetch_com['com_code']; ?></td>
      <td><?php echo $arr_dep[$fetch_emp['dep_id']]['name_en']; ?></td>
      <td><?php echo $arr_posi[$fetch_emp['posi_id']]['name_en']; ?></td>
      <td><?php echo $fetch_emp['emp_manage_a']; ?></td>
      <td><?php echo $fetch_emp['emp_manage_b']; ?></td>
      <td><?php echo $fetch_emp['fname_th']; ?></td>
      <td><?php echo $fetch_emp['lname_th']; ?></td>
      <td><?php echo $fetch_emp['fname_en']; ?></td>
      <td><?php echo $fetch_emp['lname_en']; ?></td>
      <!-- <td><?php echo $fetch_emp['work_phone']; ?></td>
      <td><?php echo $fetch_emp['phone']; ?></td>
      <td><?php echo $fetch_emp['employ_date']!="0000-00-00"?date('d/m/Y',strtotime($fetch_emp['employ_date'])):""; ?></td> -->
      <td><?php echo $fetch_emp['u_firstdate']!="0000-00-00 00:00:00"?date('d/m/Y',strtotime($fetch_emp['u_firstdate'])):""; ?></td>
      <td><?php echo $fetch_emp['inactivedate']!="0000-00-00"?date('d/m/Y',strtotime($fetch_emp['inactivedate'])):""; ?></td>
    </tr>
  <?php } 
      }
  ?>
  </tbody>
</table>
 
</body>
</html>