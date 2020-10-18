<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Querydata_select extends CI_Controller {

	public function query_admin_course(){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    $this->func_query->loadDB();
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');
	    $selectcourse_start_month = isset($_REQUEST['selectcourse_start_month'])?$_REQUEST['selectcourse_start_month']:"";
	    $selectcourse_start_year = isset($_REQUEST['selectcourse_start_year'])?$_REQUEST['selectcourse_start_year']:"";
	    $selectcourse_end_month = isset($_REQUEST['selectcourse_end_month'])?$_REQUEST['selectcourse_end_month']:"";
	    $selectcourse_end_year = isset($_REQUEST['selectcourse_end_year'])?$_REQUEST['selectcourse_end_year']:"";

	    $date_start = $selectcourse_start_year."-".$selectcourse_start_month."-01";
	    $date_end = $selectcourse_end_year."-".$selectcourse_end_month."-".date('t',strtotime($selectcourse_end_year."-".$selectcourse_end_month."-01"));

	    $chart_course_ongoing = 0;
	    $chart_course_incoming = 0;
	    $chart_course_completed = 0;
	    $chart_course_close = 0;
	    $fetch_course = $this->func_query->query_result('LMS_COS','','','','LMS_COS.cos_isDelete = 0 and (cos_createdate between "'.$date_start.'" and "'.$date_end.'")');
	    if(count($fetch_course)>0){
	    	foreach ($fetch_course as $key_course => $value_course) {
	    		$fetch_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id = "'.$value_course['cos_id'].'" and cosde_status = 1');
	    		if(count($fetch_detail)>0){
	    			if($fetch_detail['date_start']!="0000-00-00 00:00:00"&&$fetch_detail['date_end']!="0000-00-00 00:00:00"){
	    				if(date('Y-m-d H:i',strtotime($fetch_detail['date_start']))<=date('Y-m-d 00:00',strtotime($date_start))&&date('Y-m-d H:i',strtotime($fetch_detail['date_end']))>=date('Y-m-d 00:00',strtotime($date_end))){
	    					$chart_course_ongoing++;
	    				}else{
	    					if(date('Y-m-d H:i',strtotime($fetch_detail['date_start']))>date('Y-m-d 00:00',strtotime($date_start))){
	    						$chart_course_incoming++;
	    					}else{
	    						$chart_course_close++;
	    					}
	    				}
	    			}else{
	    				$chart_course_ongoing++;
	    			}
	    			$fetch_complete = $this->func_query->numrows('LMS_COS_ENROLL','','','','cos_id = "'.$value_course['cos_id'].'" and cosen_isDelete = 0 and cosen_status_sub = 1 and cosen_isActive = 1');
	    			$chart_course_completed += $fetch_complete;
	    		}
	    	}
	    }
	    $output = array(
	    	'chart_course_ongoing' => $chart_course_ongoing,
	    	'chart_course_incoming' => $chart_course_incoming,
	    	'chart_course_completed' => $chart_course_completed,
	    	'chart_course_close' => $chart_course_close
	    );
	    echo json_encode($output);
	}

	public function query_learner_course_chart(){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    $this->func_query->loadDB();
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');
	    $select_monthstart_learner = isset($_REQUEST['select_monthstart_learner'])?$_REQUEST['select_monthstart_learner']:"";
	    $select_yearstart_learner = isset($_REQUEST['select_yearstart_learner'])?$_REQUEST['select_yearstart_learner']:"";
	    $select_monthend_learner = isset($_REQUEST['select_monthend_learner'])?$_REQUEST['select_monthend_learner']:"";
	    $select_yearend_learner = isset($_REQUEST['select_yearend_learner'])?$_REQUEST['select_yearend_learner']:"";
	    $tc_id = isset($_REQUEST['tc_id'])?$_REQUEST['tc_id']:"";

	    $date_start = $select_yearstart_learner."-".$select_monthstart_learner."-01";
	    $date_end = $select_yearend_learner."-".$select_monthend_learner."-".date('t',strtotime($select_yearend_learner."-".$select_monthend_learner."-01"));

	    $chart_coursetotal = 0;
	    $chart_register = 0;
	    $chart_inprogress = 0;
	    $chart_complete = 0;
	    //(LMS_COS.cos_createdate between "'.$date_start.'" and "'.$date_end.'") and 
	    $fetch_course = $this->func_query->query_result('LMS_COS','LMS_COS_POSITION','LMS_COS_POSITION.cos_id = LMS_COS.cos_id','','LMS_COS.cos_isDelete = 0 and LMS_COS_POSITION.tc_id = "'.$tc_id.'" and LMS_COS_POSITION.posi_id = "'.$user['posi_id'].'"');
	    if(count($fetch_course)>0){
	    	foreach ($fetch_course as $key_course => $value_course) {
	    		$fetch_detail = $this->func_query->query_row('LMS_COS_DETAIL','','','','cos_id = "'.$value_course['cos_id'].'" and cosde_status = 1');
	    		if(count($fetch_detail)>0){
	    			$courseisActive = 1;
	    			if($fetch_detail['date_start']!="0000-00-00 00:00:00"&&$fetch_detail['date_end']!="0000-00-00 00:00:00"){
	    				if(date('Y-m-d H:i',strtotime($fetch_detail['date_start']))<=date('Y-m-d 00:00',strtotime($date_start))&&date('Y-m-d H:i',strtotime($fetch_detail['date_end']))>=date('Y-m-d 00:00',strtotime($date_end))){
	    					$chart_coursetotal++;
	    				}else{
	    					if(date('Y-m-d H:i',strtotime($fetch_detail['date_start']))>date('Y-m-d 00:00',strtotime($date_start))){
	    						$chart_coursetotal++;
	    					}else{
	    						$courseisActive = 0;
	    					}
	    				}
	    			}else{
	    				$chart_coursetotal++;
	    			}
	    			$fetch_register = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id = "'.$value_course['cos_id'].'" and emp_id = "'.$user['emp_id'].'" and cosen_isDelete = 0 and cosen_isActive = 1');
	    			if(count($fetch_register)>0){
	    				$chart_register += 1;
	    				if($fetch_register['cosen_status_sub']=="1"){
	    					$chart_complete++;
	    				}else{
	    					$chart_inprogress++;
	    				}
	    			}
	    		}
	    	}
	    }
	    $output = array(
	    	'chart_coursetotal' => $chart_coursetotal,
	    	'chart_register' => $chart_register,
	    	'chart_inprogress' => $chart_inprogress,
	    	'chart_complete' => $chart_complete
	    );
	    echo json_encode($output);
	}

	public function query_learner_course(){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    $this->func_query->loadDB();
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');
	    $select_monthstart_learner = isset($_REQUEST['select_monthstart_learner'])?$_REQUEST['select_monthstart_learner']:"";
	    $select_yearstart_learner = isset($_REQUEST['select_yearstart_learner'])?$_REQUEST['select_yearstart_learner']:"";
	    $select_monthend_learner = isset($_REQUEST['select_monthend_learner'])?$_REQUEST['select_monthend_learner']:"";
	    $select_yearend_learner = isset($_REQUEST['select_yearend_learner'])?$_REQUEST['select_yearend_learner']:"";

	    $date_start = $select_yearstart_learner."-".$select_monthstart_learner."-01";
	    $date_end = $select_yearend_learner."-".$select_monthend_learner."-".date('t',strtotime($select_yearend_learner."-".$select_monthend_learner."-01"));

	    $txt_rewardpoint = 0;
	    $txt_gpa = 0;
	    $txt_star = 0;
	    $numallcourse = 0;
	    while (strtotime($date_start) <= strtotime($date_end)) { 
	    	$fetch_course = $this->func_query->query_row('LMS_ENROLL_SUMMARY','','','','LMS_ENROLL_SUMMARY.emp_id = "'.$user['emp_id'].'" and (ensm_month = "'.date ("Y-m", strtotime($date_start)).'")');
	    	if(count($fetch_course)>0){
	    		$txt_rewardpoint += floatval($fetch_course['ensm_point']);
	    		// A+ = 1,A = 2,B+ = 3,B = 4,C+ = 5,C = 6,D+ = 7,D = 8, F = 9
	    		if($fetch_course['ensm_grade']=="A+"||$fetch_course['ensm_grade']=="P"){
					$txt_gpa += 1;
	    		}else if($fetch_course['ensm_grade']=="A"){
	    			$txt_gpa += 2;
	    		}else if($fetch_course['ensm_grade']=="B+"){
	    			$txt_gpa += 3;
	    		}else if($fetch_course['ensm_grade']=="B"){
	    			$txt_gpa += 4;
	    		}else if($fetch_course['ensm_grade']=="C+"){
	    			$txt_gpa += 5;
	    		}else if($fetch_course['ensm_grade']=="C"){
	    			$txt_gpa += 6;
	    		}else if($fetch_course['ensm_grade']=="D+"){
	    			$txt_gpa += 7;
	    		}else if($fetch_course['ensm_grade']=="D"){
	    			$txt_gpa += 8;
	    		}else{
	    			$txt_gpa += 9;
	    		}
	    		$txt_star += floatval($fetch_course['ensm_star']);
	    		$numallcourse++;
	    	}
	    	/*array_push($labels, $nummonth);$nummonth++;
	    	array_push($dataall, $fetch_['total_log']);*/
	    	$date_start = date ("Y-m-d", strtotime("+1 month", strtotime($date_start)));
	    }
	    $calgrade = $numallcourse>0?$txt_gpa/$numallcourse:0;
	    $calstar = $numallcourse>0?$txt_star/$numallcourse:0;
	    if(round($calgrade)==1){
	    	$txt_gpa = "A+";
	    }else if(round($calgrade)==2){
	    	$txt_gpa = "A";
	    }else if(round($calgrade)==3){
	    	$txt_gpa = "B+";
	    }else if(round($calgrade)==4){
	    	$txt_gpa = "B";
	    }else if(round($calgrade)==5){
	    	$txt_gpa = "C+";
	    }else if(round($calgrade)==6){
	    	$txt_gpa = "C";
	    }else if(round($calgrade)==7){
	    	$txt_gpa = "D+";
	    }else if(round($calgrade)==8){
	    	$txt_gpa = "D";
	    }else{
	    	$txt_gpa = "F";
	    }
	    $varstar = "";
	    $loopstar = floor($calstar);
	    for ($i=1; $i <= $loopstar; $i++) { 
	    	$varstar .= '<i class="fas fa-star"></i>';
	    }
	    $calstar = $calstar-$loopstar;
	    if($calstar>0){
	    	$varstar .= '<i class="fas fa-star-half"></i>';
	    }
	    $output = array(
	    	'txt_rewardpoint' => $txt_rewardpoint>0?number_format($txt_rewardpoint):"-",
	    	'txt_gpa' => $txt_gpa,
	    	'txt_star' => $varstar
	    );
	    echo json_encode($output);
	}

	public function query_admin_devicelog(){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    $this->func_query->loadDB();
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');
	    $select_month_devicelog = isset($_REQUEST['select_month_devicelog'])?$_REQUEST['select_month_devicelog']:"";
	    $select_year_devicelog = isset($_REQUEST['select_year_devicelog'])?$_REQUEST['select_year_devicelog']:"";

	    $date_start = $select_year_devicelog."-".$select_month_devicelog;

	    $chart_Desktop = 0;
	    $chart_Tablet = 0;
	    $chart_Mobile = 0;
	    $fetch_desktop = $this->func_query->query_row('LMS_LG','','','','LMS_LG.emp_id in (select LMS_EMP.emp_id from LMS_EMP where LMS_EMP.com_id = "'.$user['com_id'].'" and emp_isDelete = "0") and log_time!="0000-00-00 00:00:00" and log_time like "%'.$date_start.'%" and LMS_LG.device like "%PC%"','','count(emp_id) as total_log');
	    $fetch_mobile = $this->func_query->query_row('LMS_LG','','','','LMS_LG.emp_id in (select LMS_EMP.emp_id from LMS_EMP where LMS_EMP.com_id = "'.$user['com_id'].'" and emp_isDelete = "0") and log_time!="0000-00-00 00:00:00" and log_time like "%'.$date_start.'%" and LMS_LG.device like "%Mobile%"','','count(emp_id) as total_log');
	    $fetch_tablet = $this->func_query->query_row('LMS_LG','','','','LMS_LG.emp_id in (select LMS_EMP.emp_id from LMS_EMP where LMS_EMP.com_id = "'.$user['com_id'].'" and emp_isDelete = "0") and log_time!="0000-00-00 00:00:00" and log_time like "%'.$date_start.'%" and LMS_LG.device like "%Tablet%"','','count(emp_id) as total_log');
	    $chart_Desktop = $fetch_desktop['total_log'];
	    $chart_Tablet = $fetch_mobile['total_log'];
	    $chart_Mobile = $fetch_tablet['total_log'];
	    $output = array();
	    array_push($output, $chart_Desktop);
	    array_push($output, $chart_Tablet);
	    array_push($output, $chart_Mobile);
	    echo json_encode($output);
	}

	public function query_admin_devicelogbymonth(){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    $this->func_query->loadDB();
          date_default_timezone_set("Asia/Bangkok");
          $user = $this->session->userdata('user');
	    $select_month_userlog = isset($_REQUEST['select_month_userlog'])?$_REQUEST['select_month_userlog']:"";
	    $select_year_userlog = isset($_REQUEST['select_year_userlog'])?$_REQUEST['select_year_userlog']:"";

	    $date_start = $select_year_userlog."-".$select_month_userlog."-01";
	    $date_end = $select_year_userlog."-".$select_month_userlog."-".date('t',strtotime($date_start));

	    $nummonth = 1;
	    $dataall = array();
	    $labels = array();

	    $output = array();
	    while (strtotime($date_start) <= strtotime($date_end)) { 
	    	$fetch_ = $this->func_query->query_row('LMS_LG','','','','LMS_LG.emp_id in (select LMS_EMP.emp_id from LMS_EMP where LMS_EMP.com_id = "'.$user['com_id'].'" and emp_isDelete = "0") and log_time!="0000-00-00 00:00:00" and log_time like "%'.$date_start.'%"','','count(emp_id) as total_log');
	    	array_push($labels, $nummonth);$nummonth++;
	    	array_push($dataall, $fetch_['total_log']);
	    	$date_start = date ("Y-m-d", strtotime("+1 day", strtotime($date_start)));
	    }
	    $output['labels'] = $labels;
	    $output['dataall'] = $dataall;

	    echo json_encode($output);
	}

	public function recheckcos(){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
	    $this->lang->load($lang,$lang);
        $user = $this->session->userdata('user');
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    $this->func_query->loadDB();
	    $fetch_query = $this->func_query->query_result('LMS_COS','','','','LMS_COS.cos_isDelete = 0 and LMS_COS.cos_createby = "'.$user['u_id'].'"','cos_id ASC');
	    if(count($fetch_query)>0){
	      echo "<optgroup label='".label('Choosecourse')."'>";
	      echo "<option value=''>".label('r_company')."</option>";
	      foreach ($fetch_query as $key) {
	        $select_val = "";

              if($lang=="thai"){ 
                $cname = $key['cname_th']!=""?$key['cname_th']:$key['cname_eng'];
              }else{ 
                $cname = $key['cname_eng']!=""?$key['cname_eng']:$key['cname_th'];
              }
	          echo "<option value='".$cname."' ".$select_val.">".$cname."</option>";
	      }
	      $this->func_query->closeDB();
	      echo "</optgroup>";
	    }else{
	      echo "<optgroup label='".label('wg_datanotfound')."'></optgroup>";
	    }
	}
}