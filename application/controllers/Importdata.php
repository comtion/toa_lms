<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Importdata extends CI_Controller {


	public function datauser()
	{
  		require_once(APPPATH.'libraries/FPDF/Classes/PHPExcel.php');
		$lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
		$this->lang->load($lang,$lang);
		$sess = $this->session->userdata("user");
		date_default_timezone_set("Asia/Bangkok");

		$emp_c = $sess['emp_c'];
		$com_admin = $sess['com_admin'];
		$com_id = $sess['com_id'];
		$lang = $lang;
		$user = $sess;
		$this->load->model('Home_model', 'home', FALSE);
		$this->load->model('Function_query_model', 'func_query', FALSE);
		$this->load->model('Setting_model', 'setting', FALSE);
		$this->load->model('Manage_model', 'manage', FALSE);
		$this->load->model('Log_model', 'lg', FALSE);

		$this->home->loadDB();
		$this->setting->loadDB();
        $this->manage->loadDB();

        
	    $arr_output = array();
	    $result_str = "";


        $result_arr = array();
        $result_arr['success_count'] = 0;
        $result_arr['duplicate_count'] = 0;
        $result_arr['error_count'] = 0;
        $result_arr['line_error'] = array();
        $result_arr['success_data'] = array();
        $result_arr['duplicate_data'] = array();
        $result_arr['error_data'] = array();

		$file_import = $_FILES["file_import"]["name"];

		$excel_file = $_FILES['file_import']['tmp_name'];
		$path_parts = pathinfo($file_import);
		$excel_path = "importuser_".date('YmdHis').".".$path_parts['extension'];
		$com_id_main = isset($_REQUEST['com_id_import_user'])?$_REQUEST['com_id_import_user']:"";
		$excelTargetPath = ROOT_DIR."uploads/excel/".$excel_path;
		if( move_uploaded_file( $excel_file,$excelTargetPath ) ){
				$phpexcel_filename = './uploads/excel/'.basename($excel_path);
			  	$phpexcel_filetype = PHPExcel_IOFactory::identify($phpexcel_filename);
			  	$phpexcel_objReader = PHPExcel_IOFactory::createReader($phpexcel_filetype);
			  	$phpexcel_objPHPExcel = $phpexcel_objReader->load($phpexcel_filename);

			  	//division
				$phpexcel_sheet = $phpexcel_objPHPExcel->getSheet( 2 );
				$phpexcel_highestRow = $phpexcel_sheet->getHighestRow();
				$phpexcel_highestColumn = $phpexcel_sheet->getHighestColumn();
				$phpexcel_array = $phpexcel_sheet->toArray();

				for( $i = 1 ; $i < sizeof($phpexcel_array) ; $i++ ){
					    $storeData = array();
					    $storeData['div_code'] = $phpexcel_array[$i][0];
					    $storeData['div_shot'] = $phpexcel_array[$i][1];
					    $storeData['div_name_th'] = $phpexcel_array[$i][2];
					    $storeData['div_name_en'] = $phpexcel_array[$i][3];
					    $com_code = $phpexcel_array[$i][4];
					    $storeData['div_modifiedby'] = $sess['u_id'];
					    $storeData['div_modifieddate'] = date('Y-m-d H:i:s');

					    $fetch_chkcom = $this->func_query->query_row('LMS_COMPANY','','','','com_code="'.$com_code.'" and com_isDelete="0"');
					    if($com_id_main==$fetch_chkcom['com_id']){
						    $fetch_chkdiv = $this->func_query->query_row('LMS_DIVISION','','','','div_code="'.$storeData['div_code'].'" and div_isDelete="0"');
						    if(count($fetch_chkdiv)>0){
						    	$this->db->where('div_id',$fetch_chkdiv['div_id']);
						    	$this->db->update('LMS_DIVISION',$storeData);
						    }else{
						    	$storeData['com_id'] = $fetch_chkcom['com_id'];
						    	$storeData['div_createby'] = $sess['u_id'];
						    	$storeData['div_createdate'] = date('Y-m-d H:i:s');
						    	$this->db->insert('LMS_DIVISION',$storeData);
						    }
					    }
				}

			  	//group
				$phpexcel_sheet = $phpexcel_objPHPExcel->getSheet( 3 );
				$phpexcel_highestRow = $phpexcel_sheet->getHighestRow();
				$phpexcel_highestColumn = $phpexcel_sheet->getHighestColumn();
				$phpexcel_array = $phpexcel_sheet->toArray();

				for( $i = 1 ; $i < sizeof($phpexcel_array) ; $i++ ){
					    $storeData = array();
					    $storeData['group_code'] = $phpexcel_array[$i][0];
					    $storeData['group_shot'] = $phpexcel_array[$i][1];
					    $storeData['group_name_th'] = $phpexcel_array[$i][2];
					    $storeData['group_name_en'] = $phpexcel_array[$i][3];
					    $div_code = $phpexcel_array[$i][4];
					    $storeData['group_modifiedby'] = $sess['u_id'];
					    $storeData['group_modifieddate'] = date('Y-m-d H:i:s');

					    $fetch_chkdiv = $this->func_query->query_row('LMS_DIVISION','','','','div_code="'.$div_code.'" and div_isDelete="0"');

					    $fetch_chkgroup = $this->func_query->query_row('LMS_GROUP','','','','group_code="'.$storeData['group_code'].'" and group_isDelete="0"');
					    if(count($fetch_chkgroup)>0){
					    	$this->db->where('group_id',$fetch_chkgroup['group_id']);
					    	$this->db->update('LMS_GROUP',$storeData);
					    }else{
					    	$storeData['div_id'] = $fetch_chkdiv['div_id'];
					    	$storeData['group_createby'] = $sess['u_id'];
					    	$storeData['group_createdate'] = date('Y-m-d H:i:s');
					    	$this->db->insert('LMS_GROUP',$storeData);
					    }
				}

			  	//department
				$phpexcel_sheet = $phpexcel_objPHPExcel->getSheet( 4 );
				$phpexcel_highestRow = $phpexcel_sheet->getHighestRow();
				$phpexcel_highestColumn = $phpexcel_sheet->getHighestColumn();
				$phpexcel_array = $phpexcel_sheet->toArray();

				for( $i = 1 ; $i < sizeof($phpexcel_array) ; $i++ ){
					    $storeData = array();
					    $storeData['dep_code'] = $phpexcel_array[$i][0];
					    $storeData['dep_shot'] = $phpexcel_array[$i][1];
					    $storeData['dep_name_th'] = $phpexcel_array[$i][2];
					    $storeData['dep_name_en'] = $phpexcel_array[$i][3];
					    $group_code = $phpexcel_array[$i][4];
					    $storeData['dep_modifiedby'] = $sess['u_id'];
					    $storeData['dep_modifieddate'] = date('Y-m-d H:i:s');

					    $fetch_chkgroup = $this->func_query->query_row('LMS_GROUP','','','','group_code="'.$group_code.'" and group_isDelete="0"');

					    $fetch_chkdep = $this->func_query->query_row('LMS_DEPART','','','','dep_code="'.$storeData['dep_code'].'" and dep_isDelete="0"');
					    if(count($fetch_chkdep)>0){
					    	$this->db->where('dep_id',$fetch_chkdep['dep_id']);
					    	$this->db->update('LMS_DEPART',$storeData);
					    }else{
					    	$storeData['group_id'] = $fetch_chkgroup['group_id'];
					    	$storeData['dep_createby'] = $sess['u_id'];
					    	$storeData['dep_createdate'] = date('Y-m-d H:i:s');
					    	$this->db->insert('LMS_DEPART',$storeData);
					    }
				}

			  	//section
				$phpexcel_sheet = $phpexcel_objPHPExcel->getSheet( 5 );
				$phpexcel_highestRow = $phpexcel_sheet->getHighestRow();
				$phpexcel_highestColumn = $phpexcel_sheet->getHighestColumn();
				$phpexcel_array = $phpexcel_sheet->toArray();

				for( $i = 1 ; $i < sizeof($phpexcel_array) ; $i++ ){
					    $storeData = array();
					    $storeData['section_code'] = $phpexcel_array[$i][0];
					    $storeData['section_shot'] = $phpexcel_array[$i][1];
					    $storeData['section_name_th'] = $phpexcel_array[$i][2];
					    $storeData['section_name_en'] = $phpexcel_array[$i][3];
					    $dep_code = $phpexcel_array[$i][4];
					    $storeData['section_modifiedby'] = $sess['u_id'];
					    $storeData['section_modifieddate'] = date('Y-m-d H:i:s');

					    $fetch_chkdep = $this->func_query->query_row('LMS_DEPART','','','','dep_code="'.$dep_code.'" and dep_isDelete="0"');

					    $fetch_chksection = $this->func_query->query_row('LMS_SECTION','','','','section_code="'.$storeData['section_code'].'" and section_isDelete="0"');
					    if(count($fetch_chksection)>0){
					    	$this->db->where('section_id',$fetch_chksection['section_id']);
					    	$this->db->update('LMS_SECTION',$storeData);
					    }else{
					    	$storeData['dep_id'] = $fetch_chkdep['dep_id'];
					    	$storeData['section_createby'] = $sess['u_id'];
					    	$storeData['section_createdate'] = date('Y-m-d H:i:s');
					    	$this->db->insert('LMS_SECTION',$storeData);
					    }
				}

			  	//salearea
				$phpexcel_sheet = $phpexcel_objPHPExcel->getSheet( 6 );
				$phpexcel_highestRow = $phpexcel_sheet->getHighestRow();
				$phpexcel_highestColumn = $phpexcel_sheet->getHighestColumn();
				$phpexcel_array = $phpexcel_sheet->toArray();

				for( $i = 1 ; $i < sizeof($phpexcel_array) ; $i++ ){
					    $storeData = array();
					    $storeData['salearea_code'] = $phpexcel_array[$i][0];
					    $storeData['salearea_shot'] = $phpexcel_array[$i][1];
					    $storeData['salearea_name_th'] = $phpexcel_array[$i][2];
					    $storeData['salearea_name_en'] = $phpexcel_array[$i][3];
					    $section_code = $phpexcel_array[$i][4];
					    $storeData['salearea_modifiedby'] = $sess['u_id'];
					    $storeData['salearea_modifieddate'] = date('Y-m-d H:i:s');

					    $fetch_chksection = $this->func_query->query_row('LMS_SECTION','','','','section_code="'.$section_code.'" and section_isDelete="0"');

					    $fetch_chksection = $this->func_query->query_row('LMS_AREA','','','','salearea_code="'.$storeData['salearea_code'].'" and salearea_isDelete="0"');
					    if(count($fetch_chksection)>0){
					    	$this->db->where('section_id',$fetch_chksection['section_id']);
					    	$this->db->update('LMS_AREA',$storeData);
					    }else{
					    	$storeData['section_id'] = $fetch_chksection['section_id'];
					    	$storeData['salearea_createby'] = $sess['u_id'];
					    	$storeData['salearea_createdate'] = date('Y-m-d H:i:s');
					    	$this->db->insert('LMS_AREA',$storeData);
					    }
				}

			  	//position
				$phpexcel_sheet = $phpexcel_objPHPExcel->getSheet( 1 );
				$phpexcel_highestRow = $phpexcel_sheet->getHighestRow();
				$phpexcel_highestColumn = $phpexcel_sheet->getHighestColumn();
				$phpexcel_array = $phpexcel_sheet->toArray();

				for( $i = 1 ; $i < sizeof($phpexcel_array) ; $i++ ){
					    $storeData = array();
					    $storeData['posi_code'] = $phpexcel_array[$i][0];
					    $storeData['posi_shot'] = $phpexcel_array[$i][1];
					    $storeData['posi_name_th'] = $phpexcel_array[$i][2];
					    $storeData['posi_name_en'] = $phpexcel_array[$i][3];
					    $storeData['posi_group'] = $phpexcel_array[$i][4];
					    $com_code = $phpexcel_array[$i][5];
					    $storeData['posi_modifiedby'] = $sess['u_id'];
					    $storeData['posi_modifieddate'] = date('Y-m-d H:i:s');

					    $fetch_chkcom = $this->func_query->query_row('LMS_COMPANY','','','','com_code="'.$com_code.'" and com_isDelete="0"');
					    if($com_id_main==$fetch_chkcom['com_id']){
						    $fetch_chkdiv = $this->func_query->query_row('LMS_POSITION','','','','posi_code="'.$storeData['posi_code'].'" and posi_isDelete="0"');
						    if(count($fetch_chkdiv)>0){
						    	$this->db->where('posi_id',$fetch_chkdiv['posi_id']);
						    	$this->db->update('LMS_POSITION',$storeData);
						    	$posi_id = $fetch_chkdiv['posi_id'];
						    }else{
						    	$storeData['com_id'] = $fetch_chkcom['com_id'];
						    	$storeData['posi_createby'] = $sess['u_id'];
						    	$storeData['posi_createdate'] = date('Y-m-d H:i:s');
						    	$this->db->insert('LMS_POSITION',$storeData);
						    	$posi_id = $this->db->insert_id();
						    }
						}


				}

			  	//employee_data
				$phpexcel_sheet = $phpexcel_objPHPExcel->getSheet( 0 );
				$phpexcel_highestRow = $phpexcel_sheet->getHighestRow();
				$phpexcel_highestColumn = $phpexcel_sheet->getHighestColumn();
				$phpexcel_array = $phpexcel_sheet->toArray();

				for( $i = 1 ; $i < sizeof($phpexcel_array) ; $i++ ){
					    $storeData = array();
					    $storeData['useri'] = $phpexcel_array[$i][0];
					    $storeData['userp'] = $phpexcel_array[$i][1];
					    $storeData['email'] = $phpexcel_array[$i][2];
					    $storeData['status'] = $phpexcel_array[$i][3];
					    $storeData['emp_c'] = $phpexcel_array[$i][4];
					    $storeData['fname_th'] = $phpexcel_array[$i][5];
					    $storeData['lname_th'] = $phpexcel_array[$i][6];
					    $storeData['fullname_th'] = $phpexcel_array[$i][7];
					    $storeData['fname_en'] = $phpexcel_array[$i][8];
					    $storeData['lname_en'] = $phpexcel_array[$i][9];
					    $storeData['fullname_en'] = $phpexcel_array[$i][10];
					    $storeData['posi_code'] = $phpexcel_array[$i][11];
					    $storeData['posi_name'] = $phpexcel_array[$i][12];
					    $storeData['emp_level'] = $phpexcel_array[$i][13];
					    $storeData['emp_manage_a'] = $phpexcel_array[$i][14];//emp_parent_id
					    $storeData['salearea_code'] = $phpexcel_array[$i][15];
					    $storeData['salearea_shot'] = $phpexcel_array[$i][16];
					    $storeData['salearea_name'] = $phpexcel_array[$i][17];
					    $storeData['section_code'] = $phpexcel_array[$i][18];
					    $storeData['section_name'] = $phpexcel_array[$i][19];
					    $storeData['emp_zone'] = $phpexcel_array[$i][20];
					    $storeData['dep_code'] = $phpexcel_array[$i][21];
					    $storeData['dep_name'] = $phpexcel_array[$i][22];
					    $storeData['group_code'] = $phpexcel_array[$i][23];
					    $storeData['group_name'] = $phpexcel_array[$i][24];
					    $storeData['div_code'] = $phpexcel_array[$i][25];
					    $storeData['div_name'] = $phpexcel_array[$i][26];
					    $storeData['com_code'] = $phpexcel_array[$i][27];
					    $storeData['st_cus_code'] = $phpexcel_array[$i][28];
					    $storeData['st_code'] = $phpexcel_array[$i][29];
					    $storeData['st_group'] = $phpexcel_array[$i][30];
					    $storeData['st_name'] = $phpexcel_array[$i][31];
					    $storeData['emp_join_date'] = $phpexcel_array[$i][32];
					    $storeData['path_img'] = $phpexcel_array[$i][33];
					    $storeData['emp_rate'] = $phpexcel_array[$i][34];
					    $storeData['emp_observer'] = $phpexcel_array[$i][35];

					    $varrechk = 1;
						$message = "";
						$com_id = "";
						$posi_id = "";
						$div_id = "";
						$group_id = "";
						$dep_id = "";
						$section_id = "";
						$salearea_id = "";
					    $fetch_chkcom = $this->func_query->query_row('LMS_COMPANY','','','','com_code="'.$storeData['com_code'].'" and com_isDelete="0"');
					    if(count($fetch_chkcom)==0){
					    	$varrechk = 3;
							if($message!=""){
								$message .= ", ";
							}
					    	$message .= "Company not found";

					    	if($com_id_main==$fetch_chkcom['com_id']){
								if($message!=""){
									$message .= ", ";
								}
						    	$message .= "Incorrect company";
					    	}
					    }else{
					    	$com_id = $fetch_chkcom['com_id'];
					    }
					    $fetch_chkdiv = $this->func_query->query_row('LMS_DIVISION','','','','div_code="'.$storeData['div_code'].'" and com_id = "'.$com_id.'" and div_isDelete="0"');
					    if(count($fetch_chkdiv)>0){
					    	$div_id = $fetch_chkdiv['div_id'];
					    }else{
					    	$varrechk = 3;
							if($message!=""){
								$message .= ", ";
							}
					    	$message .= "Division not found";
					    }
					    $fetch_chkposi = $this->func_query->query_row('LMS_POSITION','','','','posi_code="'.$storeData['posi_code'].'" and com_id = "'.$com_id.'" and posi_isDelete="0"');
					    if(count($fetch_chkposi)>0){
					    	$posi_id = $fetch_chkposi['posi_id'];
					    }else{
					    	$varrechk = 3;
							if($message!=""){
								$message .= ", ";
							}
					    	$message .= "Position not found";
					    }
					    $fetch_chkgroup = $this->func_query->query_row('LMS_GROUP','','','','group_code="'.$storeData['group_code'].'" and div_id = "'.$div_id.'" and group_isDelete="0"');
					    if(count($fetch_chkgroup)>0){
					    	$group_id = $fetch_chkgroup['group_id'];
					    }else{
					    	$varrechk = 3;
							if($message!=""){
								$message .= ", ";
							}
					    	$message .= "Group not found";
					    }
					    $fetch_chkdep = $this->func_query->query_row('LMS_DEPART','','','','dep_code="'.$storeData['dep_code'].'" and group_id = "'.$group_id.'" and dep_isDelete="0"');
					    if(count($fetch_chkdep)>0){
					    	$dep_id = $fetch_chkdep['dep_id'];
					    }else{
					    	$varrechk = 3;
							if($message!=""){
								$message .= ", ";
							}
					    	$message .= "Department not found";
					    }
					    $fetch_chksection = $this->func_query->query_row('LMS_SECTION','','','','section_code="'.$storeData['section_code'].'" and dep_id = "'.$dep_id.'" and section_isDelete="0"');
					    if(count($fetch_chksection)>0){
					    	$section_id = $fetch_chksection['section_id'];
					    }else{
					    	$varrechk = 3;
							if($message!=""){
								$message .= ", ";
							}
					    	$message .= "Section not found";
					    }
					    $fetch_chksalearea = $this->func_query->query_row('LMS_AREA','','','','salearea_code="'.$storeData['salearea_code'].'" and section_id = "'.$section_id.'" and salearea_isDelete="0"');
					    if(count($fetch_chksalearea)>0){
					    	$salearea_id = $fetch_chksalearea['salearea_id'];
					    }else{

						    $area_arr = array();
						    $area_arr['salearea_code'] = $storeData['salearea_code'];
						    $area_arr['salearea_shot'] = $storeData['salearea_shot'];
						    $area_arr['salearea_name_th'] = $storeData['salearea_name'];
						    $area_arr['salearea_name_en'] = $storeData['salearea_name'];
						    $area_arr['salearea_modifiedby'] = $sess['u_id'];
						    $area_arr['salearea_modifieddate'] = date('Y-m-d H:i:s');

						    $fetch_chksection = $this->func_query->query_row('LMS_SECTION','','','','section_code="'.$storeData['section_code'].'" and section_isDelete="0"');
						   	$area_arr['section_id'] = $fetch_chksection['section_id'];
						    $area_arr['salearea_createby'] = $sess['u_id'];
						    $area_arr['salearea_createdate'] = date('Y-m-d H:i:s');
						    $this->db->insert('LMS_AREA',$area_arr);
						    $salearea_id = $this->db->insert_id();
					    }

					    if($varrechk==1){
					    	$st_id = "";
					    	if($storeData['st_code']!=""){
					    		$fetch_chkstore = $this->func_query->query_row('LMS_STORE','','','','st_code="'.$storeData['st_code'].'" and com_id = "'.$com_id.'" and st_isDelete="0"');
					    		$arr_store = array(
					    			'st_cus_code' => $storeData['st_cus_code'],
					    			'st_group' => $storeData['st_group'],
					    			'st_name_th' => $storeData['st_name'],
					    			'st_name_en' => $storeData['st_name'],
					    			'st_modifiedby' => $sess['u_id'],
					    			'st_modifieddate' => date('Y-m-d H:i:s'),
					    		);
					    		if(count($fetch_chkstore)>0){
					    			$this->db->where('st_id',$fetch_chkstore['st_id']);
					    			$this->db->update('LMS_STORE',$arr_store);
					    		}else{
					    			$arr_store['st_code'] = $storeData['st_code'];
					    			$arr_store['st_createby'] = $sess['u_id'];
					    			$arr_store['st_createdate'] = date('Y-m-d H:i:s');
					    			$this->db->insert('LMS_STORE',$arr_store);
					    			$st_id = $this->db->insert_id();
					    		}
					    	}
					    	$arr_employee = array(
					    		'emp_c' => $storeData['emp_c'],
					    		'fname_th' => $storeData['fname_th'],
					    		'lname_th' => $storeData['lname_th'],
					    		'fullname_th' => $storeData['fullname_th'],
					    		'fname_en' => $storeData['fname_en'],
					    		'lname_en' => $storeData['lname_en'],
					    		'fullname_en' => $storeData['fullname_en'],
					    		'status' => $storeData['status'],
					    		'email' => $storeData['email'],
					    		'emp_manage_a' => $storeData['emp_manage_a'],
					    		'lang' => 'thai',
					    		'com_id' => $com_id,
					    		'div_id' => $div_id,
					    		'group_id' => $group_id,
					    		'dep_id' => $dep_id,
					    		'section_id' => $section_id,
					    		'salearea_id' => $salearea_id,
					    		'posi_id' => $posi_id,
					    		'emp_level' => $storeData['emp_level'],
					    		'emp_zone' => $storeData['emp_zone'],
					    		'st_id' => $st_id,
					    		'emp_join_date' => $storeData['emp_join_date'],
					    		'emp_photo_url' => $storeData['path_img'],
					    		'emp_rate' => $storeData['emp_rate'],
					    		'emp_observer' => $storeData['emp_observer'],
					    		'emp_modifiedby' => $sess['u_id'],
					    		'emp_modifieddate' => date('Y-m-d H:i:s'),
					    	);
					    	$emp_id = '';
					    	$fetch_chkemp = $this->func_query->query_row('LMS_EMP','','','','emp_c="'.$storeData['emp_c'].'" and emp_isDelete="0"');
					    	if(count($fetch_chkemp)>0){
					    		$this->db->where('emp_id',$fetch_chkemp['emp_id']);
					    		$this->db->update('LMS_EMP',$arr_employee);
					    		$emp_id = $fetch_chkemp['emp_id'];
					    	}else{
					    		$arr_employee['emp_createby'] = $sess['u_id'];
					    		$arr_employee['emp_createdate'] = date('Y-m-d H:i:s');
					    		$this->db->insert('LMS_EMP',$arr_employee);
					    		$emp_id = $this->db->insert_id();
					    	}
					    	if($emp_id!=""){
					    		$fetch_ug = $this->func_query->query_row('LMS_USP_GP','','','','ug_name_th="Learner" and ug_for="'.$fetch_chkcom['com_admin'].'" and ug_isDelete="0"');
					    		$fetch_user = $this->func_query->query_row('LMS_USP','','','','useri="'.$storeData['useri'].'" and emp_id = "'.$emp_id.'" and u_isDelete="0"');
					    		$arr_user = array(
					    			'emp_id' => $emp_id,
					    			'useri' => $storeData['useri'],
					    			'userp' => $storeData['userp'],
					    			'path_img' => $storeData['path_img'],
					    			'u_modifiedby' => $sess['u_id'],
					    			'u_modifieddate' => date('Y-m-d H:i:s'),
					    		);
					    		if(count($fetch_user)>0){
					    			$this->db->where('u_id',$fetch_user['u_id']);
					    			$this->db->update('LMS_USP',$arr_user);
									$result_arr['duplicate_count']++;
							        array_push($result_arr['duplicate_data'], $arr_employee['emp_c']);
					    		}else{
						    		$arr_user['ug_id'] = $fetch_ug['ug_id'];
						    		$arr_user['u_createby'] = $sess['u_id'];
						    		$arr_user['u_createdate'] = date('Y-m-d H:i:s');
					    			$this->db->insert('LMS_USP',$arr_user);
									$result_arr['success_count']++;
									array_push($result_arr['success_data'], $arr_employee['emp_c']);
					    		}
					    	}
					    }else{
							$result_arr['error_count']++;
				            array_push($result_arr['line_error'], '2213');
				            array_push($result_arr['error_data'], $storeData['emp_c']." (".$message.")");
						}
				}
				$fetch_userall = $this->func_query->query_result('LMS_EMP','','','','(emp_parent_id is null or emp_parent_id="" or emp_parent_id = "0") and emp_manage_a!="" and emp_isDelete="0"');
				if(count($fetch_userall)>0){
					foreach ($fetch_userall as $key_userall => $value_userall) {
							$fetch_chkmanager = $this->func_query->query_row('LMS_EMP','','','','emp_c = "'.$value_userall['emp_manage_a'].'" and emp_isDelete="0"');
							if(count($fetch_chkmanager)>0){
									$arr_update = array(
										'emp_parent_id' => $fetch_chkmanager['emp_id']
									);
									$this->db->where('emp_id',$value_userall['emp_id']);
									$this->db->update('LMS_EMP',$arr_update);
							}
					}
				}
				$fetch_position = $this->func_query->query_result('LMS_POSITION','LMS_EMP','LMS_POSITION.posi_id = LMS_EMP.posi_id','','');
				foreach ($fetch_position as $key_posi => $value_posi) {
					if($value_posi['posi_group']=="division"){
						$fetch_chkdiv = $this->func_query->numrows('LMS_DIVISION','','','','div_id = "'.$value_posi['div_id'].'"');
						if($fetch_chkdiv>0){
							$fetch_posival = $this->func_query->numrows('LMS_POSITION_FIELD','','','','posifd_group = "'.$value_posi['posi_group'].'" and posifd_val="'.$value_posi['div_id'].'" and posi_id = "'.$value_posi['posi_id'].'"');
							if($fetch_posival==0){
								$arr_div = array(
									'posifd_group' => $value_posi['posi_group'],
									'posi_id' => $value_posi['posi_id'],
									'posifd_val' => $value_posi['div_id']
								);
								$this->db->insert('LMS_POSITION_FIELD',$arr_div);
							}
						}
					}else if($value_posi['posi_group']=="group"){
						$fetch_chkdiv = $this->func_query->numrows('LMS_GROUP','','','','group_id = "'.$value_posi['group_id'].'"');
						if($fetch_chkdiv>0){
							$fetch_posival = $this->func_query->numrows('LMS_POSITION_FIELD','','','','posifd_group = "'.$value_posi['posi_group'].'" and posifd_val="'.$value_posi['group_id'].'" and posi_id = "'.$value_posi['posi_id'].'"');
							if($fetch_posival==0){
								$arr_div = array(
									'posifd_group' => $value_posi['posi_group'],
									'posi_id' => $value_posi['posi_id'],
									'posifd_val' => $value_posi['group_id']
								);
								$this->db->insert('LMS_POSITION_FIELD',$arr_div);
							}
						}
					}else if($value_posi['posi_group']=="department"){
						$fetch_chkdiv = $this->func_query->numrows('LMS_DEPART','','','','dep_id = "'.$value_posi['dep_id'].'"');
						if($fetch_chkdiv>0){
							$fetch_posival = $this->func_query->numrows('LMS_POSITION_FIELD','','','','posifd_group = "'.$value_posi['posi_group'].'" and posifd_val="'.$value_posi['dep_id'].'" and posi_id = "'.$value_posi['posi_id'].'"');
							if($fetch_posival==0){
								$arr_div = array(
									'posifd_group' => $value_posi['posi_group'],
									'posi_id' => $value_posi['posi_id'],
									'posifd_val' => $value_posi['dep_id']
								);
								$this->db->insert('LMS_POSITION_FIELD',$arr_div);
							}
						}
					}else if($value_posi['posi_group']=="section"){
						$fetch_chkdiv = $this->func_query->numrows('LMS_SECTION','','','','section_id = "'.$value_posi['section_id'].'"');
						if($fetch_chkdiv>0){
							$fetch_posival = $this->func_query->numrows('LMS_POSITION_FIELD','','','','posifd_group = "'.$value_posi['posi_group'].'" and posifd_val="'.$value_posi['section_id'].'" and posi_id = "'.$value_posi['posi_id'].'"');
							if($fetch_posival==0){
								$arr_div = array(
									'posifd_group' => $value_posi['posi_group'],
									'posi_id' => $value_posi['posi_id'],
									'posifd_val' => $value_posi['section_id']
								);
								$this->db->insert('LMS_POSITION_FIELD',$arr_div);
							}
						}
					}else if($value_posi['posi_group']=="sale"){
						$fetch_chkdiv = $this->func_query->numrows('LMS_AREA','','','','salearea_id = "'.$value_posi['salearea_id'].'"');
						if($fetch_chkdiv>0){
							$fetch_posival = $this->func_query->numrows('LMS_POSITION_FIELD','','','','posifd_group = "'.$value_posi['posi_group'].'" and posifd_val="'.$value_posi['salearea_id'].'" and posi_id = "'.$value_posi['posi_id'].'"');
							if($fetch_posival==0){
								$arr_div = array(
									'posifd_group' => $value_posi['posi_group'],
									'posi_id' => $value_posi['posi_id'],
									'posifd_val' => $value_posi['salearea_id']
								);
								$this->db->insert('LMS_POSITION_FIELD',$arr_div);
							}
						}
					}

					$fetch_chklv = $this->func_query->query_row('LMS_LEVEL','','','','lv_code = "'.$value_posi['emp_level'].'"');
						if(count($fetch_chklv)>0){
							$fetch_posival = $this->func_query->numrows('LMS_POSITION_LEVEL','','','','lv_id="'.$fetch_chklv['lv_id'].'" and posi_id = "'.$value_posi['posi_id'].'"');
							if($fetch_posival==0){
								$arr_div = array(
									'posi_id' => $value_posi['posi_id'],
									'lv_id' => $fetch_chklv['lv_id'],
						    		'posilv_createby' => $sess['u_id'],
						    		'posilv_createdate' => date('Y-m-d H:i:s'),
						    		'posilv_modifiedby' => $sess['u_id'],
						    		'posilv_modifieddate' => date('Y-m-d H:i:s'),
								);
								$this->db->insert('LMS_POSITION_LEVEL',$arr_div);
							}
						}
				}
			            $result_str = "";
			            $result_str .= label('result_success')." : ".$result_arr['success_count']."<br>";
			            if(count($result_arr['success_data'])>0){
			              $result_str .= "<ol>";
			              for ($i=0; $i < count($result_arr['success_data']); $i++) { 
			                if($result_arr['success_data'][$i]!=""){
			                  $result_str .= "<li>".$result_arr['success_data'][$i]."</li>";
			                }
			              }
			              $result_str .= "</ol><hr><br>";
			            }
			            $result_str .= label('result_duplicate')." : ".$result_arr['duplicate_count']."<br>";
			            if(count($result_arr['duplicate_data'])>0){
			              $result_str .= "<ol>";
			              for ($i=0; $i < count($result_arr['duplicate_data']); $i++) { 
			                if($result_arr['duplicate_data'][$i]!=""){
			                  $result_str .= "<li>".$result_arr['duplicate_data'][$i]."</li>";
			                }
			              }
			              $result_str .= "</ol><hr><br>";
			            }
			            $result_str .= label('result_fail')." : ".$result_arr['error_count']."<br>";
			            if(count($result_arr['error_data'])>0){
			              $result_str .= "<ol>";
			              for ($i=0; $i < count($result_arr['error_data']); $i++) { 
			                if($result_arr['error_data'][$i]!=""){
			                  $result_str .= "<li>".$result_arr['error_data'][$i]."</li>";
			                }
			              }
			              $result_str .= "</ol><br>";
			            }
	        $result_arr['status'] = "2";
          	$result_arr['result'] = $result_str;
	    	//$this->lg->record('Setting', 'Import User By '.$sess['fullname_th']);
		}else{
	        $result_arr['status'] = "0";
		}
		echo json_encode($result_arr);


    }


}
?>