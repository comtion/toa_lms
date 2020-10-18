<?php
require('watermark/rotation.php');


    $id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';
    $field = isset($_REQUEST['field']) ? $_REQUEST['field'] : '';
    $emp_id = isset($_REQUEST['emp_id']) ? $_REQUEST['emp_id'] : '';
@session_start();
date_default_timezone_set("Asia/Bangkok");
include("conn.php");
mysqli_query($conndb,"SET NAMES 'utf8'");

if($field=="course"){
  $sql = "select * from LMS_COS_FIL where fil_cos_id = '".$id."'";
  $query = mysqli_query($conndb,$sql);
}else{
  $sql = "select * from LMS_FIL where id = '".$id."'";
  $query = mysqli_query($conndb,$sql);
}
$fetch = mysqli_fetch_array($query);
$sql_user = "select * from LMS_EMP where emp_id = '".$emp_id."'";
$query_user = mysqli_query($conndb,$sql_user);
$fetch_user = mysqli_fetch_array($query_user);
$fullname = $fetch_user['fullname_en'];
if(strpos($fetch['path_file'], '.pdf') !== false){
  class PDF extends PDF_Rotate{
            protected $_outerText1;// dynamic text
        protected $_outerText2;

        function setWaterText($txt1="", $txt2=""){
            $this->_outerText1 = $txt1;
            $this->_outerText2 = $txt2;
        }

        function Header(){
            //Put the watermark
            $this->SetFont('Arial','B',40);
            $this->SetTextColor(255,192,203);
                    $this->SetAlpha(1);
            $this->RotatedText(35,20, $this->_outerText1,330);
            $this->RotatedText(75,190, $this->_outerText2, 45);
        }

        function RotatedText($x, $y, $txt, $angle){
            //Text rotated around its origin
            $this->Rotate($angle,$x,$y);
            $this->Text($x,$y,$txt);
            $this->Rotate(0);
        }
    }

    $file = $fetch['path_file'];// path: file name
    $pdf = new PDF();

    if (file_exists($file)){
        $pagecount = $pdf->setSourceFile($file);
    } else {
        return FALSE;
    }

   $pdf->setWaterText($fullname);

  /* loop for multipage pdf */
   for($i=1; $i <= $pagecount; $i++) { 
     $tpl = $pdf->importPage($i);    
     $pdf->GetPageWidth();
     $size = $pdf->getTemplateSize($tpl, null, null);
     $orientation = $size['w'] > $size['h'] ? 'L' : 'P';
      $pdf->addPage($orientation); 
     $pdf->useTemplate($tpl, 1, 1, 0, 0, TRUE);  
   }
    $pdf->Output('D','document_lesson.pdf');
}else{
  $file = $fetch['path_file'];

  if (file_exists($file)) {
      header('Content-Description: File Transfer');
      header('Content-Type: application/octet-stream');
      header('Content-Disposition: attachment; filename="'.basename($file).'"');
      header('Expires: 0');
      header('Cache-Control: must-revalidate');
      header('Pragma: public');
      header('Content-Length: ' . filesize($file));
      readfile($file);
      exit;
  }
}

     //specify path filename to save or keep as it is to view in browser

 /* rotation.php */
 
?>
