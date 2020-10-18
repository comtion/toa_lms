<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require('vendor/autoload.php');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class Exportdata extends CI_Controller {

  public function export_questionofquiz($qiz_id){
    $lang = $this->session->userdata("lang") == null ? "english" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $sess = $this->session->userdata("user");
      
    $arr['emp_c'] = $sess['emp_c'];
    $arr['com_admin'] = $sess['com_admin'];
    $arr['com_id'] = $sess['com_id'];
    $arr['user'] = $sess;
    $fetch_question = $this->func_query->query_result('LMS_QUES','LMS_QUES_MUL','LMS_QUES_MUL.ques_id = LMS_QUES.ques_id','LEFT','qiz_id="'.$qiz_id.'" and ques_isDelete="0"');
    if(count($fetch_question)>0){

          $objPHPExcel = new Spreadsheet();
          $objPHPExcel->setActiveSheetIndex(0);
          $activeSheet = $objPHPExcel->getActiveSheet();
          $activeSheet->getColumnDimension('A')->setAutoSize(true);
          $activeSheet->getColumnDimension('B')->setAutoSize(true);
          $activeSheet->getColumnDimension('C')->setAutoSize(true);
          $activeSheet->getColumnDimension('D')->setAutoSize(true);
          $activeSheet->getColumnDimension('E')->setAutoSize(true);
          $activeSheet->getColumnDimension('F')->setAutoSize(true);
          $activeSheet->getColumnDimension('G')->setAutoSize(true);
          $activeSheet->getColumnDimension('H')->setAutoSize(true);
          $activeSheet->getColumnDimension('I')->setAutoSize(true);
          $activeSheet->getColumnDimension('J')->setAutoSize(true);
          $activeSheet->getColumnDimension('K')->setAutoSize(true);
          $activeSheet->getColumnDimension('L')->setAutoSize(true);
          $activeSheet->getColumnDimension('M')->setAutoSize(true);
          $activeSheet->getColumnDimension('N')->setAutoSize(true);
          $activeSheet->getColumnDimension('O')->setAutoSize(true);
          $activeSheet->getColumnDimension('P')->setAutoSize(true);
          $activeSheet->getColumnDimension('Q')->setAutoSize(true);
          $activeSheet->getColumnDimension('R')->setAutoSize(true);
          $activeSheet->setCellValue('A1', 'Question (TH)');
          $activeSheet->setCellValue('B1', 'Explanation (TH)');
          $activeSheet->setCellValue('C1', 'Question (EN)');
          $activeSheet->setCellValue('D1', 'Explanation (EN)');
          $activeSheet->setCellValue('E1', 'Question display');
          $activeSheet->setCellValue('F1', 'Full score');
          $activeSheet->setCellValue('G1', 'Question type');
          $activeSheet->setCellValue('H1', 'Choice 1 (TH)');
          $activeSheet->setCellValue('I1', 'Choice 2 (TH)');
          $activeSheet->setCellValue('J1', 'Choice 3 (TH)');
          $activeSheet->setCellValue('K1', 'Choice 4 (TH)');
          $activeSheet->setCellValue('L1', 'Choice 5 (TH)');
          $activeSheet->setCellValue('M1', 'Choice 1 (EN)');
          $activeSheet->setCellValue('N1', 'Choice 2 (EN)');
          $activeSheet->setCellValue('O1', 'Choice 3 (EN)');
          $activeSheet->setCellValue('P1', 'Choice 4 (EN)');
          $activeSheet->setCellValue('Q1', 'Choice 5 (EN)');
          $activeSheet->setCellValue('R1', 'Answer (Ex. : 1,3)');
          $numrow = 2;
          foreach ($fetch_question as $key => $value) {
            $qiz_display = $value['ques_status']=="1"?"Display":"Hide";
            if($value['ques_type']=="sa"){
                      $value['ques_type'] = 'Short answer';
            }else if($value['ques_type']=="sub"){
                      $value['ques_type'] = 'Long answer';
            }else if($value['ques_type']=="multi"){
                      $value['ques_type'] = 'Multiple choice';
            }else{
                      $value['ques_type'] = 'Two-choice';
            }
            $choice1_th = isset($value['mul_c1_th'])&&$value['mul_c1_th']!=""?$value['mul_c1_th']:"";
            $choice2_th = isset($value['mul_c2_th'])&&$value['mul_c2_th']!=""?$value['mul_c2_th']:"";
            $choice3_th = isset($value['mul_c3_th'])&&$value['mul_c3_th']!=""?$value['mul_c3_th']:"";
            $choice4_th = isset($value['mul_c4_th'])&&$value['mul_c4_th']!=""?$value['mul_c4_th']:"";
            $choice5_th = isset($value['mul_c5_th'])&&$value['mul_c5_th']!=""?$value['mul_c5_th']:"";
            $choice1_eng = isset($value['mul_c1_eng'])&&$value['mul_c1_eng']!=""?$value['mul_c1_eng']:"";
            $choice2_eng = isset($value['mul_c2_eng'])&&$value['mul_c2_eng']!=""?$value['mul_c2_eng']:"";
            $choice3_eng = isset($value['mul_c3_eng'])&&$value['mul_c3_eng']!=""?$value['mul_c3_eng']:"";
            $choice4_eng = isset($value['mul_c4_eng'])&&$value['mul_c4_eng']!=""?$value['mul_c4_eng']:"";
            $choice5_eng = isset($value['mul_c5_eng'])&&$value['mul_c5_eng']!=""?$value['mul_c5_eng']:"";
            $mul_answer = isset($value['mul_answer'])&&$value['mul_answer']!=""?str_replace("mul_c","",$value['mul_answer']):"";
            $activeSheet->setCellValue('A'.$numrow, $value['ques_name_th']);
            $activeSheet->setCellValue('B'.$numrow, $value['ques_info_th']);
            $activeSheet->setCellValue('C'.$numrow, $value['ques_name_eng']);
            $activeSheet->setCellValue('D'.$numrow, $value['ques_info_eng']);
            $activeSheet->setCellValue('E'.$numrow, $qiz_display);
            $activeSheet->setCellValue('F'.$numrow, $value['ques_score']);
            $activeSheet->setCellValue('G'.$numrow, $value['ques_type']);
            $activeSheet->setCellValue('H'.$numrow, $choice1_th);
            $activeSheet->setCellValue('I'.$numrow, $choice2_th);
            $activeSheet->setCellValue('J'.$numrow, $choice3_th);
            $activeSheet->setCellValue('K'.$numrow, $choice4_th);
            $activeSheet->setCellValue('L'.$numrow, $choice5_th);
            $activeSheet->setCellValue('M'.$numrow, $choice1_eng);
            $activeSheet->setCellValue('N'.$numrow, $choice2_eng);
            $activeSheet->setCellValue('O'.$numrow, $choice3_eng);
            $activeSheet->setCellValue('P'.$numrow, $choice4_eng);
            $activeSheet->setCellValue('Q'.$numrow, $choice5_eng);
            $activeSheet->setCellValue('R'.$numrow, $mul_answer);
            $numrow++;
          }
          $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($objPHPExcel);
          header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
          header('Content-Disposition: attachment;filename="Question'.date('Ymd').'.xlsx"');
          header('Cache-Control: max-age=0');
          $writer->save("php://output");
    }
  }

}
?>