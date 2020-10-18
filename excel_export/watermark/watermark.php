<?php
require('rotation.php');


    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
    $emp_id = isset($_REQUEST['emp_id']) ? $_REQUEST['emp_id'] : '';
@session_start();
date_default_timezone_set("Asia/Bangkok");
include("../conn.php");
mysqli_query($conndb,"SET NAMES 'utf8'");

$sql = "select * from LMS_FIL where id = '".$id."'";
$query = mysqli_query($conndb,$sql);
$fetch = mysqli_fetch_array($query);

$sql_user = "select * from LMS_EMP where emp_id = '".$emp_id."'";
$query_user = mysqli_query($conndb,$sql_user);
$fetch_user = mysqli_fetch_array($query_user);
$fullname = $fetch_user['fullname_th'];

class PDF extends PDF_Rotate
{
	function Header()
	{
	    //Put the watermark
	    $this->SetFont('Arial','B',50);
	    $this->SetTextColor(255,192,203);
	    $this->RotatedText(35,190,$fullname,45);
	}

	function RotatedText($x, $y, $txt, $angle)
	{
	    //Text rotated around its origin
	    $this->Rotate($angle,$x,$y);
	    $this->Text($x,$y,$txt);
	    $this->Rotate(0);
	}
}

$pdf=new PDF();
  	//$newString= explode(".",$fetch['path_file']);
  	$file = "../".$fetch['path_file'];// path: file name
   // echo $file;
    if (file_exists($file)){
        $pagecount = $pdf->setSourceFile($file);
        echo $pagecount;
    } else {
        return FALSE;
    }


    for($i=1; $i <= $pagecount; $i++) { 
      $tpl = $pdf->importPage($i);               
      $pdf->addPage(); 
      $pdf->useTemplate($tpl, 1, 1, 0, 0, TRUE);  
    }
$pdf->Output();
?>
