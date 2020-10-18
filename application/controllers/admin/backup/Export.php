<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Rules Controller Class
 * =====================
 * @Filename: Export.php
 * @Location: ./application/controllers/Export.php
 * @Description : Export is a PHP class to export data from database to excel.
 *
 * @Creator Wutikorn Jitpruegsa <wutikorn@digitalnex.com>
 * @Version : 1.0
 */
class Export extends CI_Controller {
	
	public function __construct() {
		parent::__construct();
		if(!$this->session->userdata('is_login')){
			redirect(base_url().'backoffice/user_login', 'refresh');
		}
	}
	
	/**
	 * Gennerate current date function.
	 * ================================
	 * @Description : Gennerate current date format 'Year(4 digit)-Month(2 Digit)-Day(2 digit)'.
	 */
	public function getDatetimeNow() {
		$tz_object = new DateTimeZone('Asia/Bangkok');
		//date_default_timezone_set('Brazil/East');
	
		$datetime = new DateTime();
		$datetime->setTimezone($tz_object);
		return $datetime->format('Y\-m\-d');
	}
	
	/**
	 * Gennerate filename function.
	 * ================================
	 * @Description : Gennerate filename with current date use for excel file.
	 */
	public function createFilename( $name ){
		$date = $this->getDatetimeNow();
		//$date_split = explode(" ", $date);
		
		$filename = $name."_".str_replace(":", "-", str_replace(" ","_",$date) ).".xls";
		return $filename;
	}

	/**
	 * Export general report function.
	 * ================================
	 * @Description : Export general report data to excel format.
	 */
	public function general(){
		
		$data = array();
		//Query for get list of record
		$query = "select cus.fb_id, cus.fb_name, cus.fb_email, cus.c_date , img.image, img.c_date as img_date";
		$query .= " from tb_customer cus inner join tb_image img";
		$query .= " on cus.fb_id = img.fb_id and cus.keygen = img.keygen ";
		$query .= "order by cus.c_date desc";
		$result = $this->db->query( $query );
		$data['list_report'] = $result->result_array();
		
		
		//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('General Report');
		//set cell A1 content with some text
		$i = 1 ;
		$num = 2 ;
		$this->excel->getActiveSheet()->setCellValue('A1','Number');
		$this->excel->getActiveSheet()->setCellValue('B1','FB Id');
		$this->excel->getActiveSheet()->setCellValue('C1','FB Name');
		$this->excel->getActiveSheet()->setCellValue('D1','FB Email');
		$this->excel->getActiveSheet()->setCellValue('E1','Time to play');
		$this->excel->getActiveSheet()->setCellValue('F1','Image');
		$this->excel->getActiveSheet()->setCellValue('G1','Time to image');
		
		foreach( $data['list_report'] as $report ){
			
			$this->excel->getActiveSheet()->setCellValue('A'.$num,$i);
			$this->excel->getActiveSheet()->setCellValue('B'.$num,$report['fb_id'] );
			$this->excel->getActiveSheet()->setCellValue('C'.$num,$report['fb_name']);
			$this->excel->getActiveSheet()->setCellValue('D'.$num,$report['fb_email']);
			$this->excel->getActiveSheet()->setCellValue('E'.$num,$report['c_date']);
			$this->excel->getActiveSheet()->setCellValue('F'.$num,$report['image']);
			$this->excel->getActiveSheet()->setCellValue('G'.$num,$report['img_date']);
			
			$num++;
			$i++;
		}
		 
		$filename = $this->createFilename( 'General' ); //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel;charset=tis-620"'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
	}
	
	/**
	 * Export passed rulues report function.
	 * ================================
	 * @Description : Export data of the rules who passed to excel format.
	 */
	public function passRules(){
		
		$data = array();
		//Query for get total pass
		$query = "select fb_id,fb_name,image,c_date from tb_pass order by c_date desc";
		$result = $this->db->query( $query );
		$data['list_report'] = $result->result_array();
		
		
		//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('General Report');
		//set cell A1 content with some text
		$i = 1 ;
		$num = 2 ;
		$this->excel->getActiveSheet()->setCellValue('A1','Number');
		$this->excel->getActiveSheet()->setCellValue('B1','FB Id');
		$this->excel->getActiveSheet()->setCellValue('C1','FB Name');
		$this->excel->getActiveSheet()->setCellValue('D1','Image');
		$this->excel->getActiveSheet()->setCellValue('E1','Assign Date');
		
		foreach( $data['list_report'] as $report ){
			
			$this->excel->getActiveSheet()->setCellValue('A'.$num,$i);
			$this->excel->getActiveSheet()->setCellValue('B'.$num,$report['fb_id'] );
			$this->excel->getActiveSheet()->setCellValue('C'.$num,$report['fb_name']);
			$this->excel->getActiveSheet()->setCellValue('D'.$num,$report['image']);
			$this->excel->getActiveSheet()->setCellValue('E'.$num,$report['c_date']);
			
			$num++;
			$i++;
		}
		 
		$filename = $this->createFilename( 'Pass-rules' ); //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel;charset=tis-620"'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
	}
	
	/**
	 * Export winner report function.
	 * ================================
	 * @Description : Export data of the winner who passed to excel format.
	 */
	public function winners(){
		
		$data = array();
		
		//Query for get winner
		$query = "select fb_id,fb_name,image,c_date from tb_winner order by c_date desc";
		$result = $this->db->query( $query );
		$data['list_report'] = $result->result_array();
		
		
		//load our new PHPExcel library
		$this->load->library('excel');
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle('General Report');
		//set cell A1 content with some text
		$i = 1 ;
		$num = 2 ;
		$this->excel->getActiveSheet()->setCellValue('A1','Number');
		$this->excel->getActiveSheet()->setCellValue('B1','FB Id');
		$this->excel->getActiveSheet()->setCellValue('C1','FB Name');
		$this->excel->getActiveSheet()->setCellValue('D1','Image');
		$this->excel->getActiveSheet()->setCellValue('E1','Assign Date');
		
		foreach( $data['list_report'] as $report ){
			
			$this->excel->getActiveSheet()->setCellValue('A'.$num,$i);
			$this->excel->getActiveSheet()->setCellValue('B'.$num,$report['fb_id'] );
			$this->excel->getActiveSheet()->setCellValue('C'.$num,$report['fb_name']);
			$this->excel->getActiveSheet()->setCellValue('D'.$num,$report['image']);
			$this->excel->getActiveSheet()->setCellValue('E'.$num,$report['c_date']);
			
			$num++;
			$i++;
		}
		
		 
		$filename = $this->createFilename( 'Winner' ); //save our workbook as this file name
		header('Content-Type: application/vnd.ms-excel;charset=tis-620"'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
					
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');  
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
		
	}
}
