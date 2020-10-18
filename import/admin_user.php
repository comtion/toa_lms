<?php
include('config.php');
set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include 'PHPExcel/IOFactory.php';
$storeFilename = 'Dealer_Admin_maping.xlsx';
$storeTableName = 'LMS_USP';
storeData( $db, $storeTableName, $storeFilename );

function storeData( $db, $storeTableName, $filename ){
  $inputFileName = $filename ;

  $lang = array('thailand','english');


  $updateCountTH = 0;
  $insertCountTH = 0;
  $updateCountEN = 0;
  $insertCountEN = 0;

  $phpexcel_filename = $inputFileName;
  $phpexcel_filetype = PHPExcel_IOFactory::identify($phpexcel_filename);
  $phpexcel_objReader = PHPExcel_IOFactory::createReader($phpexcel_filetype);
  $phpexcel_objPHPExcel = $phpexcel_objReader->load($phpexcel_filename);
  // convert one sheet

  //$sheetCount = $phpexcel_objPHPExcel->getAllSheets();
  $phpexcel_sheet = $phpexcel_objPHPExcel->getSheet( 0 );
  $phpexcel_highestRow = $phpexcel_sheet->getHighestRow();
  $phpexcel_highestColumn = $phpexcel_sheet->getHighestColumn();
  $phpexcel_array = $phpexcel_sheet->toArray();

  date_default_timezone_set("Asia/Bangkok");
  $date = date('Y-m-d H:i:s') ;
  $dateOb = new DateTime($date);
  $dateOb = $dateOb->modify('+180 day');
  $expiredate = date_format($dateOb, 'Y-m-d H:i:s');;
  $defaultPass = hash('sha256', 'Init1234');
  $count = 0;

  for( $i = 1 ; $i < sizeof($phpexcel_array) ; $i++ ){
    $data = array();
    $useri = $phpexcel_array[$i][1];
    $userData = array(
      'emp_c'=> $phpexcel_array[$i][0],
      'role' => 'admin',
      'level' => $phpexcel_array[$i][2]
    );
    if( $phpexcel_array[$i][2] == '1' ){
      $userData['org1'] = json_encode( explode(",",$phpexcel_array[$i][3]) );
    }
    if( $phpexcel_array[$i][2] == '2' ){
      $userData['org2'] = json_encode( explode(",",$phpexcel_array[$i][4]) );
    }
    if( $phpexcel_array[$i][2] == '3' ){
      $userData['org3'] = json_encode( explode(",",$phpexcel_array[$i][5]) );
    }
    $db->where('useri', $useri );
    $users = $db->get('LMS_USP');

    if( sizeof($users) > 0 ){
      $db->where('useri', $useri );
      $db->update('LMS_USP', $userData);
    }else{
      $userData['useri'] = $useri;
      $userData['firsttime'] = 1;
      $userData['expiredate'] = $expiredate;
      $userData['userp'] = $defaultPass;
      $db->insert('LMS_USP', $userData);
    }
    $count++;
  }
  echo 'Complete '.(intval($count)).' reccord<br>';
}

?>
