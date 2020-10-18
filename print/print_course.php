<?php

$ccode = isset($_REQUEST['ccode']) ? $_REQUEST['ccode'] : '';
$emp_c = isset($_REQUEST['emp_c']) ? $_REQUEST['emp_c'] : '';
$lang = isset($_REQUEST['lang']) ? $_REQUEST['lang'] : 'thailand';
$org4inzone = isset($_REQUEST['org4inzone']) ? $_REQUEST['org4inzone'] : '';
$wgcode = isset($_REQUEST['wgcode']) ? $_REQUEST['wgcode'] : '';
$to = isset($_REQUEST['to']) ? $_REQUEST['to'] : '';
if($to!=""){
  $to = explode(",",$to);
}
include("../excel_export/conn.php");
mysqli_query($conndb,"SET NAMES 'utf8'");
if($org4inzone!=""){
  $sql_org4 = "select * from LMS_ORG4 where id = '".$org4inzone."'";
  $query_org4 = mysqli_query($conndb,$sql_org4);
  $fetch_org4 = mysqli_fetch_array($query_org4);
  $org4inzone = $fetch_org4['code'];
}
// Create new PHPExcel object

$letters=array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');


function query_org($conndb,$number,$code){
  $sql_chk = "select * from LMS_ORG".$number." where code = '".$code."'";
  $query_chk = mysqli_query($conndb,$sql_chk);
  $fetch_chk = mysqli_fetch_array($query_chk);
  return $fetch_chk['name'];
}
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title></title>
  
    
 <style type="text/css">
 
 </style>

 


</head>

<body>
<script type="text/javascript">window.print();</script>
<?php 
    function getPlvList($conndb, $ccode , $lang )
    {
      $arr = array();
      $sql = "select LMS_PLV.org_c as pos_code, LMS_POS.pos_name from LMS_PLV inner join LMS_POS on LMS_POS.pos_code = LMS_PLV.org_c where LMS_PLV.course_id = '".$ccode."' and LMS_POS.lang = '".$lang."'";
      $query = mysqli_query($conndb,$sql);
      while($fetch = mysqli_fetch_array($query)){
        array_push($arr, $fetch);
      }
      return $arr;
    }
    function checkOrgStatus($conndb,$org_val) {
        $sql_chk1 = "select * from LMS_ORG1 where code = '".$org_val."'";
        $query_chk1 = mysqli_query($conndb,$sql_chk1);
        $num_chk1 = mysqli_num_rows($query_chk1);
        if($num_chk1>0){
          return 'org1';
        }else{
          $sql_chk2 = "select * from LMS_ORG2 where code = '".$org_val."'";
          $query_chk2 = mysqli_query($conndb,$sql_chk2);
          $num_chk2 = mysqli_num_rows($query_chk2);
          if($num_chk2>0){
            return 'org2';
          }else{
            $sql_chk3 = "select * from LMS_ORG3 where code = '".$org_val."'";
            $query_chk3 = mysqli_query($conndb,$sql_chk3);
            $num_chk3 = mysqli_num_rows($query_chk3);
            if($num_chk3>0){
              return 'org3';
            }
          }
        }
    }

    function getAllMustLearn_admin_zone($conndb, $lang , $ccode , $allplv, $org4inzone,$wgcode,$to_select=''){
      $dataReturn = Array();
      //print_r( $allplv );
      if($to_select!=''){
        foreach ($to_select as $to_sel ) {
          foreach( $allplv as $plv ){
              $org = checkOrgStatus($conndb,$to_sel);
              $sql = "select distinct LMS_EMP.emp_c,LMS_EMP.prefix,LMS_EMP.fname,LMS_EMP.lname,LMS_EMP.org1,LMS_EMP.org2,LMS_EMP.org3,LMS_EMP.main_pos from LMS_EMP left join LMS_POS on LMS_POS.pos_code = LMS_EMP.main_pos  where LMS_EMP.main_pos = '".$plv['pos_code']."' and LMS_EMP.lang = '".$lang."' and LMS_EMP.org4 = '".$org4inzone."' and LMS_POS.pos_group = '".$wgcode."'";
              if ($org=="org1"){
                if( $to_sel != "" ){
                  $sql .= " and LMS_EMP.org1 = '".$to_sel."'";
                }
                $query = mysqli_query($conndb,$sql);
                while( $res = mysqli_fetch_array($query) ){
                  array_push( $dataReturn, $res );
                }
              }else if($org=="org2"){
                if( $to_sel != "" ){
                  $sql .= " and LMS_EMP.org2 = '".$to_sel."'";
                }
                $query = mysqli_query($conndb,$sql);
                while( $res = mysqli_fetch_array($query) ){
                  array_push( $dataReturn, $res );
                }
              }else if($org=="org3"){
                if( $to_sel != "" ){
                  $sql .= " and LMS_EMP.org3 = '".$to_sel."'";
                }
                $query = mysqli_query($conndb,$sql);
                while( $res = mysqli_fetch_array($query) ){
                  array_push( $dataReturn, $res );
                }
              }
              
          }
        }
      }else{
        foreach( $allplv as $plv ){
            //$org = checkOrgStatus($conndb,$orgval);
            $sql = "select distinct LMS_EMP.emp_c,LMS_EMP.prefix,LMS_EMP.fname,LMS_EMP.lname,LMS_EMP.org1,LMS_EMP.org2,LMS_EMP.org3,LMS_EMP.main_pos from LMS_EMP left join LMS_POS on LMS_POS.pos_code = LMS_EMP.main_pos  where LMS_EMP.main_pos = '".$plv['pos_code']."' and LMS_EMP.lang = '".$lang."' and LMS_EMP.org4 = '".$org4inzone."' and LMS_POS.pos_group = '".$wgcode."'";
              $query = mysqli_query($conndb,$sql);
              while( $res = mysqli_fetch_array($query) ){
                array_push( $dataReturn, $res );
              }
        }
      }
      return $dataReturn;
    }
    function getAllMustLearn_admin($conndb, $lang , $ccode , $allplv, $allorg){
      $dataReturn = Array();
      //print_r( $allplv );
      foreach( $allplv as $plv ){
        //print_r($allorg);
        foreach( $allorg as $orgval ){ 

          $org = checkOrgStatus($conndb,$orgval);
          $sql = "select distinct LMS_EMP.emp_c,LMS_EMP.prefix,LMS_EMP.fname,LMS_EMP.lname,LMS_EMP.org1,LMS_EMP.org2,LMS_EMP.org3,LMS_EMP.main_pos from LMS_EMP  where LMS_EMP.main_pos = '".$plv['pos_code']."' and LMS_EMP.lang = '".$lang."'";
          if ($org=="org1"){
            if( $orgval != "" ){
              $sql .= " and LMS_EMP.org1 = '".$orgval."'";
            }
            $query = mysqli_query($conndb,$sql);
            while( $res = mysqli_fetch_array($query) ){
              array_push( $dataReturn, $res );
            }
          }else if($org=="org2"){
            if( $orgval != "" ){
              $sql .= " and LMS_EMP.org2 = '".$orgval."'";
            }
            $query = mysqli_query($conndb,$sql);
            while( $res = mysqli_fetch_array($query) ){
              array_push( $dataReturn, $res );
            }
          }else if($org=="org3"){
            if( $orgval != "" ){
              $sql .= " and LMS_EMP.org3 = '".$orgval."'";
            }
            $query = mysqli_query($conndb,$sql);
            while( $res = mysqli_fetch_array($query) ){
              array_push( $dataReturn, $res );
            }
          }
        }
        //$select = "LMS_EMP.emp_c, LMS_EMP.prefix, LMS_EMP.fname, LMS_EMP.lname, LMS_EMP.org1, LMS_EMP.main_pos";
        
      }
      //print_r( $dataReturn );
      return $dataReturn;
    }

    function getAllMustLearn($conndb, $lang , $ccode , $allplv, $org1= "",$org2= "",$org3= "" ){
      $dataReturn = Array();
      //print_r( $allplv );
      foreach( $allplv as $plv ){
        //$select = "LMS_EMP.emp_c, LMS_EMP.prefix, LMS_EMP.fname, LMS_EMP.lname, LMS_EMP.org1, LMS_EMP.main_pos";
        
        $sql = "select distinct LMS_EMP.emp_c,LMS_EMP.prefix,LMS_EMP.fname,LMS_EMP.lname,LMS_EMP.org1,LMS_EMP.org2,LMS_EMP.org3,LMS_EMP.main_pos from LMS_EMP  where LMS_EMP.main_pos = '".$plv['pos_code']."' and LMS_EMP.lang = '".$lang."'";
        if( $org1 != "" ){
          $sql .= " and LMS_EMP.org1 = '".$org1."'";
        }
        if( $org2 != "" ){
          $sql .= " and LMS_EMP.org2 = '".$org2."'";
        }
        if( $org3 != "" ){
          $sql .= " and LMS_EMP.org3 = '".$org3."'";
        }
        $query = mysqli_query($conndb,$sql);
        while( $res = mysqli_fetch_array($query) ){
          array_push( $dataReturn, $res );
        }
      }
      //print_r( $dataReturn );
      return $dataReturn;
    }
    function getLearning($conndb, $all_emp_must_learn, $ccode, $lang ){
      $data = array();
      $data['learning'] = 0;
      $data['notregister'] = 0;
      $data['complete'] = 0;
      $data['registerleave'] = 0;
      //print_r( $all_emp_must_learn );
      foreach( $all_emp_must_learn as $empset ){
        $sql = "select * from LMS_ENS where course_id = '".$ccode."' and emp_c = '".$empset['emp_c']."'";
        $query = mysqli_query($conndb,$sql);
        $result = mysqli_fetch_array($query);
        //print_r( $result );
        if( sizeof($result) > 0 ){ // check for registered : isRegistered
          foreach( $result as $res ){
            if(isset($res['finish_time'])){
              if( $res['finish_time'] != NULL || $res['finish_time'] != "" ){ // Check for complete
                $data['complete']++;
              }else{
                $data['learning']++; // Add for learning

                $sqlEmp = "select * from LMS_EMP where lang = '".$lang."' and emp_c = '".$empset['emp_c']."'";
                $queryEmp = mysqli_query($conndb,$sqlEmp);
                $resultEmp = mysqli_fetch_array($queryEmp);
                foreach( $resultEmp as $emp ){
                  if( $emp['status'] == 'Inactive'/* && $emp['depart_date'] != '' && $emp['depart_date'] != NULL*/ ){ // Check for leave
                    $data['registerleave']++;
                    $data['learning']--;
                  }
                }

              }
            }else{
              //$data['learning']++;
            }
          }
        }else{ // Not register
          $data['notregister'] ++;
        }
      }
      return $data;
    }
  $allplv = getPlvList($conndb, $ccode , $lang );
  $sql_em = "select LMS_USP.emp_c, LMS_USP.useri, LMS_USP.email,LMS_USP.level,LMS_USP.org1 as adminorg1,LMS_USP.org2 as adminorg2,LMS_USP.org3 as adminorg3, LMS_USP.role from LMS_USP where LMS_USP.useri = '".$emp_c."'";
  $query_em = mysqli_query($conndb,$sql_em);
  $fetch_em = mysqli_fetch_array($query_em);
  $emp_c = $fetch_em['emp_c'];
  $useri = $fetch_em['useri'];
  $email = $fetch_em['email'];
  $level = $fetch_em['level'];
  $adminorg1 = $fetch_em['adminorg1'];
  $adminorg2 = $fetch_em['adminorg2'];
  $adminorg3 = $fetch_em['adminorg3'];
  $role = $fetch_em['role'];
  $allorg = array();
  for( $i = 1 ; $i <= 3 ; $i++ ){
    if( $fetch_em['adminorg'.$i] != ""){
        $str_ar = json_decode($fetch_em['adminorg'.$i],true);
        foreach( $str_ar as $str ){
          array_push( $allorg , $str);
        }
    }
  }
  if($role=="admindealer"){
    $all_emp_must_learn = getAllMustLearn_admin( $conndb,$lang , $ccode , $allplv, $allorg);
  }else if($role=="adminzone"){
    $all_emp_must_learn = getAllMustLearn_admin_zone($conndb, $lang , $ccode , $allplv, $org4inzone,$wgcode,$to);
  }else{
            if( $role == "admin" ){
              if( $level == '1' ){
                //echo 1;
                $all_emp_must_learn = getAllMustLearn( $conndb,$lang , $ccode , $allplv, $adminorg1, "" ,"" );
              }else if( $level == '2' ){
                //echo 2;
                //echo $arr['org2'];
                $all_emp_must_learn = getAllMustLearn($conndb, $lang , $ccode , $allplv, "",$adminorg2,"" );
              }else if( $level == '3' ){
                //echo 3;
                $all_emp_must_learn = getAllMustLearn( $conndb,$lang , $ccode , $allplv, "","",$adminorg3 );
              }
            }else{
              $all_emp_must_learn = getAllMustLearn( $conndb,$lang , $ccode , $allplv, "","","" );
            }
  }
  //print_r($all_emp_must_learn);
  $learnData = array();
  $learnData = getLearning( $conndb,$all_emp_must_learn, $ccode, $lang );
  $learnData['mustlearn'] = sizeof( $all_emp_must_learn );
  $learnData['learning'] = sizeof( $all_emp_must_learn )-(intval($learnData['notregister'])+intval($learnData['complete'])+intval($learnData['registerleave']));
  $learnData['company'] = 'ทั้งหมด';
?> 
<table width="100%" class="table2excel" border="1" style="border-collapse: collapse;border: 1px solid black;">
  <thead>
    <tr>
      <th width="100" align="center">ทั้งหมด</th>
      <th width="100" align="center">จำนวนผู้มีสิทธิ์เรียน</th>
      <th width="100" align="center">กำลังเรียน</th>
      <th width="100" align="center">ยังไม่ลงทะเบียน</th>
      <th width="100" align="center">ผ่านหลักสูตร</th>
      <th width="100" align="center">ลงทะเบียนแล้วลาออก</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td align="center"><?php echo $learnData['company']; ?></td>
      <td align="center"><?php echo number_format($learnData['mustlearn']); ?></td>
      <td align="center"><?php echo number_format($learnData['learning']); ?></td>
      <td align="center"><?php echo number_format($learnData['notregister']); ?></td>
      <td align="center"><?php echo number_format($learnData['complete']); ?></td>
      <td align="center"><?php echo number_format($learnData['registerleave']); ?></td>
    </tr>
  </tbody>
</table> 
<br><br><br>
<table width="100%" class="table2excel" border="1" style="border-collapse: collapse;border: 1px solid black;">
  <thead>
    <tr>
      <th width="100" align="center">รหัสพนักงาน</th>
      <th width="100" align="center">ชื่อ-นามสกุล</th>
      <th width="100" align="center">กลุ่มบริษัท</th>
      <th width="100" align="center">บริษัท</th>
      <th width="100" align="center">สาขา</th>
      <th width="100" align="center">กำลังเรียน</th>
      <th width="100" align="center">ยังไม่ลงทะเบียน</th>
      <th width="100" align="center">ผ่านหลักสูตร</th>
      <th width="100" align="center">ลงทะเบียนแล้วลาออก</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach( $all_emp_must_learn as $empset ){ 
        $sql = "select * from LMS_ENS where course_id = '".$ccode."' and emp_c = '".$empset['emp_c']."'";
        $query = mysqli_query($conndb,$sql);
        $result = mysqli_fetch_array($query);
        $complete = 0;
        $learning = 0;
        $registerleave = 0;
        $notregister = 0;
        //print_r( $result );
        if( sizeof($result) > 0 ){ // check for registered : isRegistered
          foreach( $result as $res ){
            if(isset($res['finish_time'])){
              if( $res['finish_time'] != NULL || $res['finish_time'] != "" ){ // Check for complete
                $complete++;
              }else{
                $learning++; // Add for learning

                $sqlEmp = "select * from LMS_EMP where lang = '".$lang."' and emp_c = '".$empset['emp_c']."'";
                $queryEmp = mysqli_query($conndb,$sqlEmp);
                $resultEmp = mysqli_fetch_array($queryEmp);
                  if( $resultEmp['status'] == 'Inactive'/* && $emp['depart_date'] != '' && $emp['depart_date'] != NULL*/ ){ // Check for leave
                    $registerleave++;
                    $learning--;
                  }

              }
            }else{
              $learning = 1;
            }
          }
        }else{ // Not register
          $sqlEmp = "select * from LMS_EMP where lang = '".$lang."' and emp_c = '".$empset['emp_c']."'";
          $queryEmp = mysqli_query($conndb,$sqlEmp);
          $resultEmp = mysqli_fetch_array($queryEmp);
            if( $resultEmp['status'] != 'Inactive'/* && $emp['depart_date'] != '' && $emp['depart_date'] != NULL*/ ){ // Check for leave
              $notregister ++;
            }
        }

        
      ?>
      <tr>
        <td><?php echo $empset['emp_c'] ?></td>
        <td><?php echo $empset['prefix'].$empset['fname']." ".$empset['lname'] ?></td>
        <td><?php echo query_org($conndb,'1',$empset['org1']); ?></td>
        <td><?php echo query_org($conndb,'2',$empset['org2']); ?></td>
        <td><?php echo query_org($conndb,'3',$empset['org3']); ?></td>
        <td align='center'><?php echo $learning; ?></td>
        <td align='center'><?php echo $notregister; ?></td>
        <td align='center'><?php echo $complete; ?></td>
        <td align='center'><?php echo $registerleave; ?></td>
      </tr>
    <?php 
    } ?>
  </tbody>
</table>
 
</body>
</html>