<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
	header('Cache-Control: no-cache');
	header('Pragma: no-cache');
	header('Expires: 0');

	// REAL PATH
	define('FPDF_FONTPATH','./application/libraries/FPDF/font/');
	require('./application/libraries/FPDF/fpdf.php');
	require_once ('./application/libraries/FPDF/Classes/PHPExcel.php');

	// XAMPP PATH
	// define('FPDF_FONTPATH','./application/libraries/FPDF/font/');
	// require('./application/libraries/FPDF/fpdf.php');
	// require_once ('./application/libraries/FPDF/Classes/PHPExcel.php');

	$tmpfname = "./uploads/temp/certificate_excel.xlsx";
	$excelReader = PHPExcel_IOFactory::createReaderForFile($tmpfname);
	$excelObj = $excelReader->load($tmpfname);
	$worksheet = $excelObj->getSheet(0);
	$lastRow = $worksheet->getHighestRow();

	$pdf = new FPDF('L','mm','A4');

    $pdf->AddFont('FREEDB','','FREEDB.php');
	$pdf->AddFont('helvetica-med-ext','','DB Helvethaica X Med Ext v3.2.php');
	$pdf->AddFont('helvetica-med','','DB Helvethaica X Med v3.2.php');
	$pdf->AddFont('helvetica-li','','DB Helvethaica X Li.php');
	$pdf->SetTopMargin(85);

	for ($row = 1; $row <= $lastRow; $row++) {
		if($worksheet->getCell('A'.$row)->getValue()!="Fullname"){
			$pdf->AddPage();
			$pdf->Image('./uploads/certificate/certificate_original.jpg',0,0,297.01,209.97); //mm 

			$pdf->SetFont('FREEDB','',35);
			$pdf->SetTextColor(0,0,0);	
			/*$pdf->Cell(0,5,iconv('UTF-8','cp874',''),0,1,'C'); //space
			$pdf->Cell(0,5,iconv('UTF-8','cp874',''),0,1,'C'); //space
			$pdf->Cell(0,5,iconv('UTF-8','cp874',''),0,1,'C'); //space*/
			$pdf->Cell(0,10,iconv('UTF-8','cp874',$worksheet->getCell('A'.$row)->getValue()),0,1,'C');
			$pdf->SetFont('FREEDB','',27);
			$pdf->SetTextColor(0,0,0);	
			$pdf->Cell(0,15,iconv('UTF-8','cp874',$worksheet->getCell('B'.$row)->getValue()),0,1,'C');
			$pdf->Cell(0,5,iconv('UTF-8','cp874',''),0,1,'C'); //space

			$pdf->SetFont('FREEDB','',27);
			$pdf->SetTextColor(0,0,0);	
			$pdf->Cell(0,5,iconv('UTF-8','cp874',''),0,1,'C'); //space
			$pdf->Cell(0,5,iconv('UTF-8','cp874',''),0,1,'C'); //space
			$pdf->Cell(0,5,iconv('UTF-8','cp874',''),0,1,'C'); //space
			$pdf->Cell(0,3,iconv('UTF-8','cp874',$worksheet->getCell('C'.$row)->getValue()),0,1,'C');
			$pdf->Cell(0,15,iconv('UTF-8','cp874',$worksheet->getCell('D'.$row)->getValue()),0,1,'C');
			$pdf->Cell(0,3,iconv('UTF-8','cp874',$worksheet->getCell('E'.$row)->getValue()),0,1,'C');
			$pdf->Cell(0,3,iconv('UTF-8','cp874',''),0,1,'C'); //space

			$pdf->SetFont('FREEDB','',25);
			$pdf->SetTextColor(0,0,0);	
			//$pdf->SetTextColor(237,54,61);		
			$pdf->Cell(0,13,iconv('UTF-8','cp874','Issued on '.$worksheet->getCell('F'.$row)->getValue()),0,1,'C');
		}

	}

	$pdf->Output('certificate.pdf' , 'D');

?>