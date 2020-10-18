<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Updatedatacourse extends CI_Controller {

  	public function update_fil(){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    date_default_timezone_set("Asia/Bangkok");
	    $sess = $this->session->userdata("user");
	    $this->func_query->loadDB();
	    $fil_id = isset($_REQUEST['fil_id'])?$_REQUEST['fil_id']:"";
	    $cosen_id = isset($_REQUEST['cosen_id'])?$_REQUEST['cosen_id']:"";
	    $fetch_chkles = $this->func_query->query_row('LMS_FIL','','','','id="'.$fil_id.'"');
	    $numchk = $this->func_query->numrows('LMS_FIL_LOG','','','','fil_id="'.$fil_id.'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'"');
	    if($numchk==0){
	    	$arr_insert = array(
	    		'emp_id'=>$sess['emp_id'],
	    		'fil_id'=>$fil_id,
				'cosen_id' => $cosen_id
	    	);
	    	$this->db->insert('LMS_FIL_LOG',$arr_insert);
	    	$this->update_lesson($fetch_chkles['lessons_id']);
	    }
	}

	public function rechk_status_cosenroll(){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    date_default_timezone_set("Asia/Bangkok");
	    $sess = $this->session->userdata("user");
	    $this->func_query->loadDB();
	    $cosen_id = isset($_REQUEST['cosen_id'])?$_REQUEST['cosen_id']:"";
	    $result = $this->func_query->query_row('LMS_COS_ENROLL','','','','cosen_id="'.$cosen_id.'"');
	    echo json_encode($result);
	    exit();
	}

  	public function update_med(){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    date_default_timezone_set("Asia/Bangkok");
	    $sess = $this->session->userdata("user");
	    $this->func_query->loadDB();
	    $med_id = isset($_REQUEST['med_id'])?$_REQUEST['med_id']:"";
	    $cosen_id = isset($_REQUEST['cosen_id'])?$_REQUEST['cosen_id']:"";
	    $fetch_chkles = $this->func_query->query_row('LMS_MED','','','','id="'.$med_id.'"');
	    $numchk = $this->func_query->numrows('LMS_MED_TC','','','','med_id="'.$med_id.'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'"');
	    if($numchk==0){
	    	$arr_insert = array(
	    		'emp_id'=>$sess['emp_id'],
	    		'med_id'=>$med_id,
	    		'medtc_datetime'=>date('Y-m-d H:i'),
				'cosen_id' => $cosen_id
	    	);
	    	$this->db->insert('LMS_MED_TC',$arr_insert);
	    	$this->update_lesson($fetch_chkles['lessons_id']);
	    }
	}

	public function update_lessonlog($les_id){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    date_default_timezone_set("Asia/Bangkok");
	    $sess = $this->session->userdata("user");
	    $this->func_query->loadDB();
	    $cosen_id = isset($_REQUEST['cosen_id'])?$_REQUEST['cosen_id']:"";
        $fetch_enroll = $this->func_query->query_row('LMS_COS_ENROLL','','','','cosen_id="'.$cosen_id.'"');
        $fetch_leslog = $this->func_query->query_row('LMS_LES_LOG','','','','cosen_id="'.$cosen_id.'" and les_id="'.$les_id.'"','leslg_id DESC');
        $leslg_round = count($fetch_leslog)>0?intval($fetch_leslog['leslg_round'])+1:1;
        if(count($fetch_enroll)>0){
		        $arr_insert = array(
		        	'cosen_id' => $cosen_id,
		        	'emp_id' => $fetch_enroll['emp_id'],
		        	'les_id' => $les_id,
		        	'leslg_round' => $leslg_round,
		        	'leslg_datetime' => date('Y-m-d H:i:s')
		        );
		        $this->db->insert('LMS_LES_LOG',$arr_insert);
        }
	}

	public function update_lesson($les_id){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    date_default_timezone_set("Asia/Bangkok");
	    $sess = $this->session->userdata("user");
	    $this->func_query->loadDB();
	    $cosen_id = isset($_REQUEST['cosen_id'])?$_REQUEST['cosen_id']:"";
	    $fetch_chkles = $this->func_query->query_row('LMS_LES','','','','les_id="'.$les_id.'"');
		$value_total = 0;
		$total = 0;
		$output = array();
	    if($fetch_chkles['les_type']=="1"){
		    $fetch_chkmed = $this->func_query->query_result('LMS_MED','','','','lessons_id="'.$les_id.'"');
		    $fetch_chkfil = $this->func_query->query_result('LMS_FIL','','','','lessons_id="'.$les_id.'"');
		    $total = count($fetch_chkmed);//+count($fetch_chkfil)
		    if(count($fetch_chkmed)>0){
			    foreach ($fetch_chkmed as $key_chkmed => $value_chkmed) {
			    	$fetch_chkmedtc = $this->func_query->numrows('LMS_MED_TC','','','','med_id="'.$value_chkmed['id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'"');
			    	if($fetch_chkmedtc>0){
			    		$value_total++;
			    	}
			    }
		    }
		    /*if(count($fetch_chkfil)>0){
			    foreach ($fetch_chkfil as $key_chkfil => $value_chkfil) {
			    	$fetch_chkfiltc = $this->func_query->numrows('LMS_FIL_LOG','','','','fil_id="'.$value_chkfil['id'].'" and emp_id="'.$sess['emp_id'].'"');
			    	if($fetch_chkfiltc>0){
			    		$value_total++;
			    	}
			    }
		    }*/
		    $learn_status = "0";
		    if($value_total>0){
		    	if($value_total==$total){
		    		$learn_status = "2";
		    	}else{
		    		$learn_status = "1";
		    	}
		    }else{
		    	if(count($fetch_chkmed)==0){
		    		$learn_status = "2";
		    	}
		    }
		    if($sess['emp_id']!=""&&$les_id!=""){
			    $fetch_chkstatus = $this->func_query->query_row('LMS_LES_TC','','','','les_id="'.$les_id.'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'"');
			    if(count($fetch_chkstatus)>0){
			    	if($fetch_chkstatus['learn_status']!="2"){
				    	$arr_insert = array(
				    		'emp_id'=>$sess['emp_id'],
				    		'les_id'=>$les_id,
				    		'learn_status'=>$learn_status
				    	);
				    	$this->db->where('lestc_id',$fetch_chkstatus['lestc_id']);
				    	$this->db->update('LMS_LES_TC',$arr_insert);
			    	}
			    }else{
			    	$arr_insert = array(
			    		'emp_id'=>$sess['emp_id'],
			    		'les_id'=>$les_id,
			    		'learn_status'=>$learn_status,
						'cosen_id' => $cosen_id
			    	);
			    	$this->db->insert('LMS_LES_TC',$arr_insert);
			    }
		    }
		    $output['status'] = $learn_status;
	    }else{
	    	$fetch_chkstatus = $this->func_query->query_row('LMS_LES_TC','','','','les_id="'.$les_id.'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'"');
	    	$output['status'] = $fetch_chkstatus['learn_status'];
	    }
	    echo json_encode($output);
	}

	public function rechk_status_lessontc(){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    date_default_timezone_set("Asia/Bangkok");
	    $sess = $this->session->userdata("user");
	    $this->func_query->loadDB();
	    $cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
	    $cosen_id = isset($_REQUEST['cosen_id'])?$_REQUEST['cosen_id']:"";
	    $les_id = isset($_REQUEST['les_id'])?$_REQUEST['les_id']:"";
	    $med_id = isset($_REQUEST['med_id'])?$_REQUEST['med_id']:"";
	    $fetch_chkles = $this->func_query->query_row('LMS_LES','','','','les_id="'.$les_id.'"');
		$value_total = 0;
		$total = 0;
		$output = array();

		    $fetch_chkmed = $this->func_query->query_result('LMS_MED','','','','lessons_id="'.$les_id.'"');
		    $fetch_chkfil = $this->func_query->query_result('LMS_FIL','','','','lessons_id="'.$les_id.'"');
		    $total = count($fetch_chkmed);//+count($fetch_chkfil)
		    if(count($fetch_chkmed)>0){
			    foreach ($fetch_chkmed as $key_chkmed => $value_chkmed) {
			    	$fetch_chkmedtc = $this->func_query->numrows('LMS_MED_TC','','','','med_id="'.$value_chkmed['id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'"');
			    	if($fetch_chkmedtc>0){
			    		$value_total++;
			    	}
			    }
		    }
		    $learn_status = "0";
		    if($value_total>0){
		    	if($value_total==$total){
		    		$learn_status = "2";
		    	}else{
		    		$learn_status = "1";
		    	}
		    }else{
		    	if(count($fetch_chkmed)==0){
		    		$learn_status = "2";
		    	}
		    }
		    if($sess['emp_id']!=""&&$les_id!=""){
			    $fetch_chkstatus = $this->func_query->query_row('LMS_LES_TC','','','','les_id="'.$les_id.'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'"');
			    if(count($fetch_chkstatus)>0){
			    	if($fetch_chkstatus['learn_status']!="2"){
				    	$arr_insert = array(
				    		'emp_id'=>$sess['emp_id'],
				    		'les_id'=>$les_id,
				    		'learn_status'=>$learn_status
				    	);
				    	$this->db->where('lestc_id',$fetch_chkstatus['lestc_id']);
				    	$this->db->update('LMS_LES_TC',$arr_insert);
			    	}
			    	$lestc_id = $fetch_chkstatus['lestc_id'];
			    }else{
			    	$arr_insert = array(
			    		'emp_id'=>$sess['emp_id'],
			    		'les_id'=>$les_id,
			    		'learn_status'=>$learn_status,
						'cosen_id' => $cosen_id
			    	);
			    	$this->db->insert('LMS_LES_TC',$arr_insert);
			    	$lestc_id = $this->db->insert_id();
			    }
			    if($lestc_id!=""){
				    $fetch_les = $this->func_query->query_row('LMS_LES_TC','','','','lestc_id = "'.$lestc_id.'"');
				    $fetch_les['fetch_med_tc'] = $this->func_query->numrows('LMS_MED_TC','','','','med_id="'.$med_id.'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'"');
			    	$output = $fetch_les;
			    }
		    }

	    echo json_encode($output);
	}

	public function rechk_status_lesson(){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
    	date_default_timezone_set("Asia/Bangkok");
		$date_now = date('Y-m-d H:i');
	    $sess = $this->session->userdata("user");
	    $this->func_query->loadDB();
		$output = array();
		$cos_id = isset($_REQUEST['cos_id'])?$_REQUEST['cos_id']:"";
		$cosen_id = isset($_REQUEST['cosen_id'])?$_REQUEST['cosen_id']:"";
		if($cos_id!=""){

			$value_status = 0;
			$numles = $this->func_query->numrows('LMS_LES','','','','cos_id="'.$cos_id.'" and les_isDelete="0" and les_status="1" and ((time_start="0000-00-00 00:00:00" and time_end="0000-00-00 00:00:00") or (time_start <= "'.$date_now.'" and  time_end >= "'.$date_now.'"))');
			$fetch_chktc = $this->func_query->query_result('LMS_LES_TC','','','','les_id in (select les_id from LMS_LES where cos_id="'.$cos_id.'" and les_isDelete="0" and les_status="1" and ((time_start="0000-00-00 00:00:00" and time_end="0000-00-00 00:00:00") or (time_start <= "'.$date_now.'" and  time_end >= "'.$date_now.'"))) and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'"');
			if(count($fetch_chktc)){
				foreach ($fetch_chktc as $key_chktc => $value_chktc) {
					if($value_chktc['learn_status']=="2"){
						$value_status++;
					}
				}
			}
		    $output['status'] = $value_status;
		    $output['numles'] = $numles;
		    if($value_status==$numles){
		    	$this->endcos($cos_id);
		    }
		}else{
			$output['status'] = 'error';
		}
	    echo json_encode($output);
	}

	public function insert_survey_tc(){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    date_default_timezone_set("Asia/Bangkok");
	    $sess = $this->session->userdata("user");
	    $this->func_query->loadDB();
	    $sv_id = isset($_REQUEST['sv_id'])?$_REQUEST['sv_id']:"";
	    $cosen_id = isset($_REQUEST['cosen_id'])?$_REQUEST['cosen_id']:"";
	    $qnu_suggestion = isset($_REQUEST['qnu_suggestion'])?$_REQUEST['qnu_suggestion']:"";

	    $svde_id = isset($_REQUEST['svde_id'])?$_REQUEST['svde_id']:"";
	    $qnude_var = isset($_REQUEST['qnude_var'])?$_REQUEST['qnude_var']:"";
	    $qnude_suggestion = isset($_REQUEST['qnude_suggestion'])?$_REQUEST['qnude_suggestion']:"";
	    $fetch_main = $this->func_query->query_row('LMS_QN_USER','','','','emp_id="'.$sess['emp_id'].'" and sv_id="'.$sv_id.'" and cosen_id="'.$cosen_id.'"');
	    $output = array();
	    if(count($fetch_main)==0){
	    	$arr_main = array(
	    		'sv_id' => $sv_id,
	    		'emp_id' => $sess['emp_id'],
	    		'qnu_suggestion' => $qnu_suggestion,
	    		'qnu_datetime' => date('Y-m-d H:i'),
	    		'qnu_status' => '1',
	    		'cosen_id' => $cosen_id
	    	);
	    	$this->db->insert('LMS_QN_USER',$arr_main);
	    	$qnu_id = $this->db->insert_id();
	    	if($qnu_id!=""){
	    		if(count($svde_id)>0){
	    			for ($i=0; $i < count($svde_id); $i++) { 
	    				if(isset($svde_id[$i])){
		    				$arr_detail = array(
		    					'qnu_id' => $qnu_id,
		    					'svde_id' => $svde_id[$i],
		    					'qnude_var' => isset($qnude_var[$i])?$qnude_var[$i]:"",
		    					'qnude_suggestion' => isset($qnude_suggestion[$i])?$qnude_suggestion[$i]:""
		    				);
		    				$fetch_chkdetail = $this->func_query->numrows('LMS_QN_USER_DE','','','','qnu_id="'.$qnu_id.'" and svde_id="'.$svde_id[$i].'"');
		    				if($fetch_chkdetail==0){
		    					$this->db->insert('LMS_QN_USER_DE',$arr_detail);
		    				}
	    				}
	    			}
	    		}
	    		$output['status'] = "1";
	    	}else{
	    		$output['status'] = "0";
	    	}
	    }else{
	    	$output['status'] = "0";
	    }
	    echo json_encode($output);
	}

	public function endcos($cos_id){
	    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
	    $this->lang->load($lang,$lang);
	    $this->load->model('Function_query_model', 'func_query', FALSE);
	    $this->load->model('Course_model', 'course', FALSE);
	    date_default_timezone_set("Asia/Bangkok");
	    $sess = $this->session->userdata("user");
	    $this->func_query->loadDB();
	    $fetch_chkcos = $this->func_query->query_row('LMS_COS','','','','cos_id="'.$cos_id.'"');
	    if(count($fetch_chkcos)>0){

            $fetch_enroll = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$cos_id.'" and emp_id="'.$sess['emp_id'].'" and cosen_status="1" and cosen_lang!="" and cosen_finishtime="0000-00-00 00:00:00" and cosen_isDelete="0"','cosen_id DESC');
            if(count($fetch_enroll)>0){
            	$cosen_id = $fetch_enroll['cosen_id'];
		    	$status_cos = 0;
		    	$amount_les = 0;
		    	$amount_qiz = 0;
	            $score = 0;
	            $total = 0;
		    	$fetch_qiz = $this->func_query->query_result('LMS_QIZ','','','','cos_id="'.$cos_id.'" and quiz_type="2" and quiz_show="1" and quiz_status="1" and quiz_isDelete="0"');
		    	$num_chk_qiz = 0;
		    	$numloopqiz = 0; 
		    	$numloopqizpass = 0; 
		    	if(count($fetch_qiz)>0){
	              	foreach ($fetch_qiz as $key_qiz => $value_qiz) {
		                    	$qizlv_goalscore = 0;
		                    	$fetch_chklv = $this->func_query->query_row('LMS_QIZ_LEVEL','','','','qiz_id="'.$value_qiz['qiz_id'].'" and lv_id = "'.$sess['lv_id'].'"');
		                    	if(count($fetch_chklv)>0){
		                    		$qizlv_goalscore = floatval($fetch_chklv['qizlv_goalscore']);
		                    	}
	                    $fetch_chk = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$value_qiz['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and qiz_status="3" and cosen_id="'.$cosen_id.'"','qiztc_id DESC');
	                    if(count($fetch_chk)>0){
		              		if($value_qiz['quiz_limit']=="1"){
		              			if($fetch_chk['limit_val']<=intval($value_qiz['quiz_limitval'])){
		              				if(floatval($fetch_chk['per_score'])>=floatval($qizlv_goalscore)){
		              					$numloopqizpass++;
		              				}else{
		              					if($fetch_chk['limit_val']==intval($value_qiz['quiz_limitval'])){
		              						$numloopqizpass++;
		              					}
		              				}
		              			}
		              		}else{
		              				if(floatval($fetch_chk['per_score'])>=floatval($qizlv_goalscore)){
		              					$numloopqizpass++;
		              				}
		              		}
		              	}
		              	$numloopqiz++;
	                    $score_total = 0;
	                    $fetch_chk = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$value_qiz['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and qiz_status="3" and cosen_id="'.$cosen_id.'"','qiztc_id DESC');
	                    if(count($fetch_chk)>0){
	                    	$amount_qiz++;
		                    $fetch_questc = $this->func_query->query_result('LMS_QUES_TC','','','','qiz_id="'.$value_qiz['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'" and qiztc_id="'.$fetch_chk['qiztc_id'].'"');
		                    if(count($fetch_questc)==intval($value_qiz['quiz_numofshown'])){
		                      $num_chk_qiz++;
		                    }
		                    /*if(count($fetch_questc)>0){
			                    foreach ($fetch_questc as $key => $value) {
			                    	$fetch_sum = $this->func_query->query_row('LMS_QUES','','','','ques_id="'.$value['ques_id'].'" and qiz_id="'.$value_qiz['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
			                      	$score_total += count($fetch_sum)>0?floatval($fetch_sum['ques_score']):0;
			                    }
		                    }*/
			                
		                    
		                    $score += count($fetch_chk)>0?floatval($fetch_chk['sum_score']):0;
	                    }
	                    $fetch_sum = $this->func_query->query_row('LMS_QUES','','','','qiz_id="'.$value_qiz['qiz_id'].'" and ques_id in (select LMS_QUES_TC.ques_id from LMS_QUES_TC where qiz_id="'.$value_qiz['qiz_id'].'" and cosen_id="'.$cosen_id.'") and ques_status="1" and ques_isDelete="0"','','SUM(ques_score) as total_score');
		                $total += count($fetch_sum)>0?floatval($fetch_sum['total_score']):0;
	                }
		    	}
		    	$fetch_lesson = $this->func_query->query_result('LMS_LES','','','','cos_id="'.$cos_id.'" and les_isDelete="0" and les_status="1"');
		    	if(count($fetch_lesson)>0){
		    		foreach ($fetch_lesson as $key_lesson => $value_lesson) {
		    			$fetch_lestc = $this->func_query->query_row('LMS_LES_TC','','','','les_id="'.$value_lesson['les_id'].'" and cosen_id="'.$cosen_id.'" and emp_id="'.$sess['emp_id'].'"');
		    			if(count($fetch_lestc)>0){
		    				if($fetch_lestc['learn_status']=="2"){
		    					$amount_les++;
		    				}
		    			}
		    			/*if($value_lesson['les_type']=="2"){
		    				$fetch_scm = $this->func_query->query_row('LMS_SCM','LMS_SCM_VAL','LMS_SCM.id = LMS_SCM_VAL.scm_id','','LMS_SCM.lessons_id="'.$value_lesson['les_id'].'" and LMS_SCM_VAL.emp_id="'.$sess['emp_id'].'" and LMS_SCM_VAL.var_name="cmi_core_lesson_status" and (LMS_SCM_VAL.var_value="completed" or LMS_SCM_VAL.var_value="passed")');
		    				if(count($fetch_scm)>0){
		    					$fetch_rawscm = $this->func_query->query_row('LMS_SCM','LMS_SCM_VAL','LMS_SCM.id = LMS_SCM_VAL.scm_id','','LMS_SCM.lessons_id="'.$value_lesson['les_id'].'" and LMS_SCM_VAL.emp_id="'.$sess['emp_id'].'" and LMS_SCM_VAL.var_name="cmi_core_score_raw" and LMS_SCM_VAL.var_value!=""');
		    					if(count($fetch_rawscm)>0){
		    						$fetch_maxscm = $this->func_query->query_row('LMS_SCM','LMS_SCM_VAL','LMS_SCM.id = LMS_SCM_VAL.scm_id','','LMS_SCM.lessons_id="'.$value_lesson['les_id'].'" and LMS_SCM_VAL.emp_id="'.$sess['emp_id'].'" and LMS_SCM_VAL.var_name="cmi_core_score_max" and LMS_SCM_VAL.var_value!=""');
		    						if(count($fetch_maxscm)>0){
					                    $total += floatval($fetch_maxscm['var_value']);
					                    $score += floatval($fetch_rawscm['var_value']);
		    						}
		    					}
		    				}
		    			}*/
		    		}
		    	}
		    	$cosen_grade = "";
	            $cosen_score = 0;
	            $cosen_score_per = 0;

	            $cosen_status_sub = '2';
	            $cosen_finishtime = '0000-00-00 00:00:00';
			                	//echo "518:".$total."::".$score;
	            if($total>0){
	            	if($score>=0&&$total>0){
	            		$cosen_score = $score;
			            $cosen_score_per = ($score/$total)*100;
			            $fetch_cug = $this->func_query->query_row('LMS_CUG','','','','course_id="'.$cos_id.'"');
			            if(count($fetch_cug)>0){
			            	if($fetch_chkcos['cos_typegrading']=="1"){
				                if($cosen_score_per>=floatval($fetch_cug['mina'])){
				                  	$cosen_grade = "A";
				                }else if($cosen_score_per>=floatval($fetch_cug['minb'])){
				                  	$cosen_grade = "B";
				                }else if($cosen_score_per>=floatval($fetch_cug['minc'])){
				                  	$cosen_grade = "C";
				                }else if($cosen_score_per>=floatval($fetch_cug['mind'])){
				                  	$cosen_grade = "D";
				                }else{
				                  	$cosen_grade = "F";
				                }
			            	}else{
			            		if($cosen_score_per>=floatval($fetch_cug['mina'])){
				                  	$cosen_grade = "P";
				                }else{
				                  	$cosen_grade = "F";
				                }
			            	}
			            }
			           	if(floatval($cosen_score_per)>=floatval($fetch_chkcos['goal_score'])){
			                $cosen_status_sub = 1;
			                $cosen_finishtime = date('Y-m-d H:i');
			            }else{
			            	if($numloopqizpass==$numloopqiz){
			            		$cosen_status_sub = 1;
			                	$cosen_finishtime = date('Y-m-d H:i');
			            	}else{
			                	$cosen_status_sub = 2;
			            	}
			            }
		            }
	            }else{
	            	$cosen_score = 100;
	            	$cosen_score_per = 100;
					$cosen_status_sub = 1;
					$cosen_finishtime = date('Y-m-d H:i');

			        $fetch_cug = $this->func_query->query_row('LMS_CUG','','','','course_id="'.$cos_id.'"');
			        if(count($fetch_cug)>0){
			            	if($fetch_chkcos['cos_typegrading']=="1"){
				                if($cosen_score_per>=floatval($fetch_cug['mina'])){
				                  	$cosen_grade = "A";
				                }else if($cosen_score_per>=floatval($fetch_cug['minb'])){
				                  	$cosen_grade = "B";
				                }else if($cosen_score_per>=floatval($fetch_cug['minc'])){
				                  	$cosen_grade = "C";
				                }else if($cosen_score_per>=floatval($fetch_cug['mind'])){
				                  	$cosen_grade = "D";
				                }else{
				                  	$cosen_grade = "F";
				                }
			            	}else{
			            		if($cosen_score_per>=floatval($fetch_cug['mina'])){
				                  	$cosen_grade = "P";
				                }else{
				                  	$cosen_grade = "F";
				                }
			            	}
			        }
			        
					/*if($amount_les==0&&$amount_qiz==0){
					        $status_rechk = 0;
					    	$fetch_qiz = $this->func_query->query_result('LMS_QIZ','','','','cos_id="'.$cos_id.'" and quiz_type="1" and quiz_show="1" and quiz_status="1" and quiz_isDelete="0"');
					    	if(count($fetch_qiz)>0){
					    		foreach ($fetch_qiz as $key_qiz => $value_qiz) {
				                    $fetch_chk = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$value_qiz['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'" and qiz_status="3"','qiztc_id DESC');
				                    if(count($fetch_chk)>0){
				                    	$status_rechk++;
				                    }
					    		}
					    	}
					    	$fetch_survey = $this->func_query->query_result('LMS_SURVEY','','','','cos_id="'.$cos_id.'" and sv_status="1" and sv_isDelete="0"');
					    	if(count($fetch_survey)>0){
					    		foreach ($fetch_survey as $key_sv => $value_sv) {
				                    $fetch_chk = $this->func_query->query_row('LMS_QN_USER','','','','sv_id="'.$value_sv['sv_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'" and qnu_status="1"','qnu_id DESC');
				                    if(count($fetch_chk)>0){
				                    	$status_rechk++;
				                    }
					    		}
					    	}
					    	$caltotal = count($fetch_qiz)+count($fetch_survey);
					    	if($status_rechk==$caltotal){
					                $cosen_status_sub = 1;
					                $cosen_finishtime = date('Y-m-d H:i');
					    	}
					}*/
	            }
	            $val_cosen = 0;
	            $total_couse = 0;
	            
	            $fetch_les = $this->func_query->numrows('LMS_LES','','','','les_isDelete="0" and les_status="1" and cos_id="'.$cos_id.'"');
	            $fetch_lestc = $this->func_query->numrows('LMS_LES_TC','','','','learn_status="2" and cosen_id="'.$cosen_id.'"');
	            $fetch_qiz = $this->func_query->numrows('LMS_QIZ','','','','quiz_isDelete="0" and quiz_show="1" and cos_id="'.$cos_id.'"');
	            $fetch_qiztc = $this->func_query->numrows('LMS_QIZ_TC','','','','qiz_status="3" and cosen_id="'.$cosen_id.'"');
	            $fetch_sv = $this->func_query->numrows('LMS_SURVEY','','','','sv_isDelete="0" and sv_status="1" and cos_id="'.$cos_id.'"');
	            $fetch_svtc = $this->func_query->numrows('LMS_QN_USER','','','','qnu_status="1" and cosen_id="'.$cosen_id.'"');
	            if($fetch_les>0){
	            	$total_couse++;
		            if($fetch_les<=$fetch_lestc){
		            	$val_cosen++;
		            }
	            }
	            if($fetch_qiz>0){
	            	$total_couse++;
		            if($fetch_qiz<=$fetch_qiztc){
		            	$val_cosen++;
		            }
	            	$fetch_qiz_query = $this->func_query->query_result('LMS_QIZ','','','','quiz_isDelete="0" and quiz_show="1" and cos_id="'.$cos_id.'"');
	            	if(count($fetch_qiz_query)>0){
	            		foreach ($fetch_qiz_query as $key_qiz_query => $value_qiz_query) {
							$fetch_chksh_lg = $this->func_query->numrows('LMS_QUES','','','','LMS_QUES.qiz_id="'.$value_qiz_query['qiz_id'].'" and ques_status="1" and ques_isDelete="0" and ques_type in ("sub","sa")');
							if($fetch_chksh_lg>0){
								$total_couse++;
								$fetch_chktc_sa = $this->func_query->numrows('LMS_QUES_TC','','','','cosen_id="'.$cosen_id.'" and tc_isSavescore="1" and LMS_QUES_TC.ques_id in (select LMS_QUES.ques_id from LMS_QUES where LMS_QUES.qiz_id="'.$value_qiz_query['qiz_id'].'" and ques_status="1" and ques_isDelete="0" and ques_type in ("sub","sa"))');
								if($fetch_chktc_sa>=$fetch_chksh_lg){
									$val_cosen++;
								}
							}

	            		}
	            	}
	            }
	            /*if($fetch_sv>0){
	            	$total_couse++;
		            if($fetch_sv==$fetch_svtc){
		            	$val_cosen++;
		            }
	            }*/
	           // echo $total_couse."::".$val_cosen;
	            if($total_couse==$val_cosen){
		            if($cosen_finishtime!="0000-00-00 00:00:00"&&$cosen_finishtime!=""){
		            	$fetch_bad = $this->func_query->query_row('LMS_BAD','','','','courses_id="'.$cos_id.'"');
		                if(count($fetch_bad)>0){
		                	$score_pass = '';
		                	if($fetch_bad['badges_condition']=="P"){
		                		$score_pass = floatval($fetch_cug['mina']);
		                	}else{
		                		if($fetch_bad['badges_condition']=="A"){
		                			$score_pass = floatval($fetch_cug['mina']);
		                		}else if($fetch_bad['badges_condition']=="B"){
		                			$score_pass = floatval($fetch_cug['minb']);
		                		}else if($fetch_bad['badges_condition']=="C"){
		                			$score_pass = floatval($fetch_cug['minc']);
		                		}else if($fetch_bad['badges_condition']=="D"){
		                			$score_pass = floatval($fetch_cug['mind']);
		                		}else{
		                			$score_pass = 0;
		                		}
		                	}
							$cosen_score_per = round($cosen_score_per);

	           // echo $score_pass."::".$cosen_score_per;
		                	if($cosen_score_per>=$score_pass){
		                   		$this->course->update_cert($cos_id,$sess);	
		                	}
		                }
		            }
			        $cosen_status_sub = 1;
			       	$cosen_finishtime = date('Y-m-d H:i');
	            }else{
			        $cosen_grade = '';
			        $cosen_score = 0;
			        $cosen_score_per = 0;
			        $cosen_status_sub = 2;
			       	$cosen_finishtime = '0000-00-00 00:00:00';
	            }

            	$arr_update = array(
	            	'cosen_grade' => $cosen_grade,
	            	'cosen_score' => $cosen_score,
	            	'cosen_score_per' => $cosen_score_per,
	            	'cosen_status_sub' => $cosen_status_sub,
	            	'cosen_finishtime' => $cosen_finishtime,
	            	'cosen_modifiedby' => $sess['u_id'],
	            	'cosen_modifieddate' => date('Y-m-d H:i')
	            );
	            $this->db->where('cosen_id',$fetch_enroll['cosen_id']);
	            $this->db->update('LMS_COS_ENROLL',$arr_update);
            }else{
				$fetch_enroll = $this->func_query->query_row('LMS_COS_ENROLL','','','','cos_id="'.$cos_id.'" and emp_id="'.$sess['emp_id'].'" and cosen_status="1" and cosen_lang!="" and cosen_isDelete="0"','cosen_id DESC');
				if(count($fetch_enroll)>0){
					$cosen_id = $fetch_enroll['cosen_id'];
		    		$fetch_qiz = $this->func_query->query_result('LMS_QIZ','','','','cos_id="'.$cos_id.'" and quiz_type="2" and quiz_show="1" and quiz_status="1" and quiz_isDelete="0"');
		    		if(count($fetch_qiz)>0){
		    				$new_value = 0;
			              	$cosen_round = intval($fetch_enroll['cosen_round']);
			              	foreach ($fetch_qiz as $key_qiz => $value_qiz) {
			                    $num_rechk = $this->func_query->numrows('LMS_QIZ_TC','','','','qiz_id="'.$value_qiz['qiz_id'].'" and qiz_status="3" and cosen_id="'.$cosen_id.'"');
			                    if($cosen_round<$num_rechk){
			                    	$new_value++;
			                    }
			                }
			                if($new_value>0){
			                	$cosen_round++;
						    	$status_cos = 0;
						    	$amount_les = 0;
						    	$amount_qiz = 0;
					            $score = 0;
					            $total = 0;

						    	$num_chk_qiz = 0;
						    	$numloopqiz = 0; 
						    	$numloopqizpass = 0; 
				              	foreach ($fetch_qiz as $key_qiz => $value_qiz) {
			                    	$qizlv_goalscore = 0;
			                    	$fetch_chklv = $this->func_query->query_row('LMS_QIZ_LEVEL','','','','qiz_id="'.$value_qiz['qiz_id'].'" and lv_id = "'.$sess['lv_id'].'"');
			                    	if(count($fetch_chklv)>0){
			                    		$qizlv_goalscore = floatval($fetch_chklv['qizlv_goalscore']);
			                    	}
				                    $fetch_chk = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$value_qiz['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and qiz_status="3" and cosen_id="'.$cosen_id.'"','qiztc_id DESC');
				                    if(count($fetch_chk)>0){
					              		if($value_qiz['quiz_limit']=="1"){
					              			if($fetch_chk['limit_val']<=intval($value_qiz['quiz_limitval'])){
					              				if(floatval($fetch_chk['per_score'])>=floatval($qizlv_goalscore)){
					              					$numloopqizpass++;
					              				}else{
					              					if($fetch_chk['limit_val']==intval($value_qiz['quiz_limitval'])){
					              						$numloopqizpass++;
					              					}
					              				}
					              			}
					              		}else{
					              				if(floatval($fetch_chk['per_score'])>=floatval($qizlv_goalscore)){
					              					$numloopqizpass++;
					              				}
					              		}
					              	}
					              	$numloopqiz++;
				                    $score_total = 0;
				                    $fetch_chk = $this->func_query->query_row('LMS_QIZ_TC','','','','qiz_id="'.$value_qiz['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and qiz_status="3" and cosen_id="'.$cosen_id.'"','qiztc_id DESC');
				                    if(count($fetch_chk)>0){
				                    	$amount_qiz++;
					                    $fetch_questc = $this->func_query->query_result('LMS_QUES_TC','','','','qiz_id="'.$value_qiz['qiz_id'].'" and emp_id="'.$sess['emp_id'].'" and cosen_id="'.$cosen_id.'" and qiztc_id="'.$fetch_chk['qiztc_id'].'"');
					                    if(count($fetch_questc)==intval($value_qiz['quiz_numofshown'])){
					                      $num_chk_qiz++;
					                    }
					                    /*if(count($fetch_questc)>0){
						                    foreach ($fetch_questc as $key => $value) {
						                    	$fetch_sum = $this->func_query->query_row('LMS_QUES','','','','ques_id="'.$value['ques_id'].'" and qiz_id="'.$value_qiz['qiz_id'].'" and ques_status="1" and ques_isDelete="0"');
						                      	$score_total += count($fetch_sum)>0?floatval($fetch_sum['ques_score']):0;
						                    }
					                    }*/
					                    $score += count($fetch_chk)>0?floatval($fetch_chk['sum_score']):0;
					                    
				                    }
				                    $fetch_sum = $this->func_query->query_row('LMS_QUES','','','','qiz_id="'.$value_qiz['qiz_id'].'" and ques_id in (select LMS_QUES_TC.ques_id from LMS_QUES_TC where qiz_id="'.$value_qiz['qiz_id'].'" and cosen_id="'.$cosen_id.'") and ques_status="1" and ques_isDelete="0"','','SUM(ques_score) as total_score');
				                    $total += count($fetch_sum)>0?floatval($fetch_sum['total_score']):0;
				                }

						    	$cosen_grade = "";
					            $cosen_score = 0;
					            $cosen_score_per = 0;

					            $cosen_status_sub = '2';
					            $cosen_finishtime = '0000-00-00 00:00:00';

					            if($total>0){
					            	if($score>=0&&$total>0){
					            		$cosen_score = $score;
							            $cosen_score_per = ($score/$total)*100;
							            $fetch_cug = $this->func_query->query_row('LMS_CUG','','','','course_id="'.$cos_id.'"');
							            if(count($fetch_cug)>0){
							            	if($fetch_chkcos['cos_typegrading']=="1"){
								                if($cosen_score_per>=floatval($fetch_cug['mina'])){
								                  	$cosen_grade = "A";
								                }else if($cosen_score_per>=floatval($fetch_cug['minb'])){
								                  	$cosen_grade = "B";
								                }else if($cosen_score_per>=floatval($fetch_cug['minc'])){
								                  	$cosen_grade = "C";
								                }else if($cosen_score_per>=floatval($fetch_cug['mind'])){
								                  	$cosen_grade = "D";
								                }else{
								                  	$cosen_grade = "F";
								                }
							            	}else{
							            		if($cosen_score_per>=floatval($fetch_cug['mina'])){
								                  	$cosen_grade = "P";
								                }else{
								                  	$cosen_grade = "F";
								                }
							            	}
							            }
							           	if(floatval($cosen_score_per)>=floatval($fetch_chkcos['goal_score'])){
							                $cosen_status_sub = 1;
							                $cosen_finishtime = date('Y-m-d H:i');
							            }else{
							            	if($numloopqizpass==$numloopqiz){
							            		$cosen_status_sub = 1;
							                	$cosen_finishtime = date('Y-m-d H:i');
							            	}else{
							                	$cosen_status_sub = 2;
							            	}
							            }
						            }


							            $val_cosen = 0;
							            $total_couse = 0;
							            
							            $fetch_les = $this->func_query->numrows('LMS_LES','','','','les_isDelete="0" and les_status="1" and cos_id="'.$cos_id.'"');
							            $fetch_lestc = $this->func_query->numrows('LMS_LES_TC','','','','learn_status="2" and cosen_id="'.$cosen_id.'"');
							            $fetch_qiz = $this->func_query->numrows('LMS_QIZ','','','','quiz_isDelete="0" and quiz_show="1" and cos_id="'.$cos_id.'"');
							            $fetch_qiztc = $this->func_query->numrows('LMS_QIZ_TC','','','','qiz_status="3" and cosen_id="'.$cosen_id.'"');
							            $fetch_sv = $this->func_query->numrows('LMS_SURVEY','','','','sv_isDelete="0" and sv_status="1" and cos_id="'.$cos_id.'"');
							            $fetch_svtc = $this->func_query->numrows('LMS_QN_USER','','','','qnu_status="1" and cosen_id="'.$cosen_id.'"');
							            if($fetch_les>0){
							            	$total_couse++;
								            if($fetch_les<=$fetch_lestc){
								            	$val_cosen++;
								            }
							            }
							            if($fetch_qiz>0){
							            	$total_couse++;
								            if($fetch_qiz<=$fetch_qiztc){
								            	$val_cosen++;
								            }
							            }
							            /*if($fetch_sv>0){
							            	$total_couse++;
								            if($fetch_sv==$fetch_svtc){
								            	$val_cosen++;
								            }
							            }*/
								        $score_pass = '';
							            if($total_couse==$val_cosen){
								            if($cosen_finishtime!="0000-00-00 00:00:00"&&$cosen_finishtime!=""){
								            	$fetch_bad = $this->func_query->query_row('LMS_BAD','','','','courses_id="'.$cos_id.'"');
								                if(count($fetch_bad)>0){
								                	if($fetch_bad['badges_condition']=="P"){
								                		$score_pass = floatval($fetch_cug['mina']);
								                	}else{
								                		if($fetch_bad['badges_condition']=="A"){
								                			$score_pass = floatval($fetch_cug['mina']);
								                		}else if($fetch_bad['badges_condition']=="B"){
								                			$score_pass = floatval($fetch_cug['minb']);
								                		}else if($fetch_bad['badges_condition']=="C"){
								                			$score_pass = floatval($fetch_cug['minc']);
								                		}else if($fetch_bad['badges_condition']=="D"){
								                			$score_pass = floatval($fetch_cug['mind']);
								                		}else{
								                			$score_pass = 0;
								                		}
								                	}
								                }
								            }
									        $cosen_status_sub = 1;
									       	$cosen_finishtime = date('Y-m-d H:i');
							            }else{
									        $cosen_grade = '';
									        $cosen_score = 0;
									        $cosen_score_per = 0;
									        $cosen_status_sub = 2;
									       	$cosen_finishtime = '0000-00-00 00:00:00';
							            }
							            $cosen_score_per = round($cosen_score_per);
						            	$arr_update = array(
						            		'cosen_round' => $cosen_round,
							            	'cosen_grade' => $cosen_grade,
							            	'cosen_score' => $cosen_score,
							            	'cosen_score_per' => $cosen_score_per,
							            	'cosen_status_sub' => $cosen_status_sub,
							            	'cosen_finishtime' => $cosen_finishtime,
							            	'cosen_modifiedby' => $sess['u_id'],
							            	'cosen_modifieddate' => date('Y-m-d H:i')
							            );
							            $this->db->where('cosen_id',$fetch_enroll['cosen_id']);
							            $this->db->update('LMS_COS_ENROLL',$arr_update);

								                	if($cosen_score_per>=$score_pass){
								                   		$this->course->update_cert($cos_id,$sess);	
								                	}
					            }
			                }
		    		}
				}
            }
            
	    }
	}
}