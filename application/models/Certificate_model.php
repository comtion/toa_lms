<?php
class Certificate_model extends CI_Model {

        public function __construct()
        {
          // Call the CI_Model constructor
          parent::__construct();
        }
        
        public function loadDB()
        {
          $this->load->database();
        }

        public function closeDB()
        {
          $this->db->close();
        }
        
        public function createfile($arr_user,$cos_id){
          date_default_timezone_set("Asia/Bangkok");
          $thaimonth = array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
          $this->db->from('LMS_CERTIFICATE');
          $this->db->where('cos_id',$cos_id);
          $this->db->where('emp_id',$arr_user['emp_id']);
          $query_chk = $this->db->get();
          $fetch_chk = $query_chk->row_array();
          if(count($fetch_chk)>0){
            return $fetch_chk['cert_file'];
          }else{
            $this->db->from('LMS_BAD');
            $this->db->where('courses_id',$cos_id);
            $query_bad = $this->db->get();
            $fetch_bad = $query_bad->row_array();

            $this->db->from('LMS_COS');
            $this->db->join('LMS_TYPECOS','LMS_COS.tc_id = LMS_TYPECOS.tc_id');
            $this->db->where('cos_id',$cos_id);
            $query_cos = $this->db->get();
            $fetch_cos = $query_cos->row_array();

            $this->db->from('LMS_COS_ENROLL');
            $this->db->where('cos_id',$cos_id);
            $this->db->where('emp_id',$arr_user['emp_id']);
            $query_enroll = $this->db->get();
            $fetch_enroll = $query_enroll->row_array();

            header('Cache-Control: no-cache');
            header('Pragma: no-cache');
            header('Expires: 0');

            
              if(in_array($fetch_enroll['cosen_lang'], array('thai','english'))){ 
                define('FPDF_FONTPATH','assets/FPDF/font/');
                require('assets/FPDF/fpdf.php');
                require_once ('assets/FPDF/Classes/PHPExcel.php');
                $pdf = new FPDF('L','mm','A4');

                $pdf->AddFont('FREEDB','','FREEDB.php');
                $pdf->AddFont('helvetica-med-ext','','DB Helvethaica X Med Ext v3.2.php');
                $pdf->AddFont('helvetica-med','','DB Helvethaica X Med v3.2.php');
                $pdf->AddFont('helvetica-li','','DB Helvethaica X Li.php');
                $pdf->SetTopMargin(85);

                $pdf->AddPage();
                if($fetch_bad['badges_img']!=""){
                    if(is_file(ROOT_DIR."uploads/badges/".$fetch_bad['badges_img'])) {
                      $pdf->Image(base_url().'uploads/badges/'.$fetch_bad['badges_img'],0,0,297.01,209.97); //mm 
                    }else{
                      $pdf->Image(base_url().'uploads/certificate/certificate_original.jpg',0,0,297.01,209.97); //mm 
                    }
                }else{
                    $pdf->Image(base_url().'uploads/certificate/certificate_original.jpg',0,0,297.01,209.97); //mm 
                }

                if($fetch_enroll['cosen_lang']=="thai"){
                  $fullname = $arr_user['fullname_th'];
                  $com_name = $arr_user['com_name_th'];

                  /*$cosen_grade = "ยอดเยี่ยม";
                  if(count($fetch_enroll)>0){
                    if($fetch_enroll['cosen_grade']=="A"){
                      $cosen_grade = "ยอดเยี่ยม";
                    }else if($fetch_enroll['cosen_grade']=="B"){
                      $cosen_grade = "ดี";
                    }else if($fetch_enroll['cosen_grade']=="C"){
                      $cosen_grade = "ปานกลาง";
                    }else{
                      $cosen_grade = "อ่อนมาก";
                    }
                  }*/
                  $label_a = 'สำเร็จหลักสูตร';
                  $label_b = 'ประเภท';
                  $label_c = 'ด้วยคะแนน';
                  $label_d = 'ให้ไว้ ณ วันที่';
                  $tc_name = $fetch_cos['tc_name_th'];
                  $dateval = date('d')." ".$thaimonth[intval(date('m'))]." ".(date('Y')+543);
                }else{
                  $fullname = $arr_user['fullname_en'];
                  $com_name = $arr_user['com_name_eng'];

                  /*$cosen_grade = "Very good";
                  if(count($fetch_enroll)>0){
                    if($fetch_enroll['cosen_grade']=="A"){
                      $cosen_grade = "Very good";
                    }else if($fetch_enroll['cosen_grade']=="B"){
                      $cosen_grade = "Good";
                    }else if($fetch_enroll['cosen_grade']=="C"){
                      $cosen_grade = "Moderate";
                    }else{
                      $cosen_grade = "Need improvement";
                    }
                  }*/
                  if($fetch_enroll['cosen_lang']=="japan"){
                    $label_a = 'Complete the course';
                    $label_b = 'Type';
                    $label_c = 'With score';
                    $label_d = 'Issued on';
                  }else{
                    $label_a = 'Complete the course';
                    $label_b = 'Type';
                    $label_c = 'With score';
                    $label_d = 'Issued on';
                  }
                  $tc_name = $fetch_cos['tc_name_en'];
                  $dateval = date('d F Y');
                }

                if($fetch_enroll['cosen_lang']=="thai"){ 
                    $cname = $fetch_cos['cname_th']!=""?$fetch_cos['cname_th']:$fetch_cos['cname_eng'];
                    $cname = $cname!=""?$cname:$fetch_cos['cname_jp'];
                }else if($fetch_enroll['cosen_lang']=="english"){ 
                    $cname = $fetch_cos['cname_eng']!=""?$fetch_cos['cname_eng']:$fetch_cos['cname_th'];
                    $cname = $cname!=""?$cname:$fetch_cos['cname_jp'];
                }else{
                    $cname = $fetch_cos['cname_jp']!=""?$fetch_cos['cname_jp']:$fetch_cos['cname_eng'];
                    $cname = $cname!=""?$cname:$fetch_cos['cname_th'];
                }

                $pdf->SetFont('FREEDB','',35);
                $pdf->SetTextColor(0,0,0);  
                $pdf->Cell(0,10,iconv('UTF-8','cp874',$fullname),0,1,'C');
                $pdf->SetFont('FREEDB','',27);
                $pdf->SetTextColor(0,0,0);  
                $pdf->Cell(0,15,iconv('UTF-8','cp874',$com_name),0,1,'C');
                $pdf->Cell(0,5,iconv('UTF-8','cp874',''),0,1,'C'); //space

                $pdf->SetFont('FREEDB','',27);
                $pdf->SetTextColor(0,0,0);   
                $pdf->Cell(0,5,iconv('UTF-8','cp874',''),0,1,'C'); //space
                $pdf->Cell(0,5,iconv('UTF-8','cp874',''),0,1,'C'); //space
                $pdf->Cell(0,5,iconv('UTF-8','cp874',''),0,1,'C'); //space
                $pdf->Cell(0,3,iconv('UTF-8','cp874',$cname),0,1,'C');//$label_a.' '.
                $pdf->Cell(0,15,'',0,1,'C');
                $pdf->Cell(0,3,'',0,1,'C');
                $pdf->Cell(0,3,iconv('UTF-8','cp874',''),0,1,'C'); //space

                $pdf->SetFont('FREEDB','',25);
                //$pdf->SetTextColor(237,54,61);    
                $pdf->SetTextColor(0,0,0);  
                $pdf->Cell(0,13,iconv('UTF-8','cp874',$label_d.' '.$dateval),0,1,'C');
                $name_cert = "Certificate_".$cos_id."_".$arr_user['emp_id']."_".date('YmdHis').".pdf";
                $filename = "uploads/certificate/".$name_cert;
                $pdf->Output($filename,'F');
              }else{
                //define('FPDF_FONTPATH',base_url().'assets/tfpdf/font/unifont/');

                //require('assets/FPDF/japanese.php');
                require_once ('assets/TCPDF-master/tcpdf.php');
                /*
                require('assets/tfpdf/tfpdf.php');
                require_once ('assets/FPDF/Classes/PHPExcel.php');*/
                $pdf = new TCPDF();
                //$pdf = new tFPDF('L','mm','A4');
                $pdf->SetTopMargin(80);
                $pdf->AddPage('L','A4');
                $pdf->SetAutoPageBreak(false, 0);
                if($fetch_bad['badges_img']!=""){
                    if(is_file(ROOT_DIR."uploads/badges/".$fetch_bad['badges_img'])) {
                      $pdf->Image(base_url().'uploads/badges/'.$fetch_bad['badges_img'],0,0, 297, 210, '', '', '', false, 300, '', false, false, 0); //mm 
                    }else{
                      $pdf->Image(base_url().'uploads/certificate/certificate_original.jpg',0,0, 297, 210, '', '', '', false, 300, '', false, false, 0); //mm 
                    }
                }else{
                    $pdf->Image(base_url().'uploads/certificate/certificate_original.jpg',0,0, 297, 210, '', '', '', false, 300, '', false, false, 0); //mm 
                }
                
                $fullname = $arr_user['fullname_en'];
                $com_name = $arr_user['com_name_eng'];

                $label_a = 'Complete the course';
                $label_b = 'Type';
                $label_c = 'With score';
                $label_d = 'Issued on';
                $tc_name = $fetch_cos['tc_name_en'];
                $dateval = date('d F Y');

                $cname = $fetch_cos['cname_jp']!=""?$fetch_cos['cname_jp']:$fetch_cos['cname_eng'];
                $cname = $cname!=""?$cname:$fetch_cos['cname_th'];

                $pdf->SetFont('cid0jp','',35);
                $pdf->SetTextColor(0,0,0);  
                $pdf->Cell(0,0,$fullname,0,1,'C');
                $pdf->SetFont('cid0jp','',27);
                $pdf->SetTextColor(0,0,0);  
                $pdf->Cell(0,0,$com_name,0,1,'C');
                $pdf->Cell(0,0,'',0,1,'C'); //space

                $pdf->SetFont('cid0jp','',27);
                $pdf->SetTextColor(0,0,0);   
                $pdf->Cell(0,0,'',0,1,'C'); //space
                $pdf->Cell(0,0,$cname,0,1,'C');//$label_a.' '.
                $pdf->Cell(0,0,'',0,1,'C');

                $pdf->SetFont('cid0jp','',25);
                //$pdf->SetTextColor(237,54,61);    
                $pdf->SetTextColor(0,0,0);  
                $pdf->Cell(0,0,$label_d.' '.$dateval,0,1,'C');
                $name_cert = "Certificate_".$cos_id."_".$arr_user['emp_id']."_".date('YmdHis').".pdf";
                $filename = ROOT_DIR."uploads/certificate/".$name_cert;
                $pdf->Output($filename,'F');
              }
                $data = array(
                  'cos_id' => $cos_id,
                  'emp_id' => $arr_user['emp_id'],
                  'cert_file' => $name_cert,
                  'cert_date' => date('Y-m-d'),
                  'cert_createtime' => date('Y-m-d H:i')
                );
                $this->db->insert('LMS_CERTIFICATE', $data);
            return $name_cert;
          }
        }
}
