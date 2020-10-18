<?php
class Log_model extends CI_Model {

  //  public $title;
  //  public $content;
  //  public $date;

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

  public function record($activity, $message)
  {
                      $device = '';
                      $platform = '';
                      $u_agent = $_SERVER['HTTP_USER_AGENT']; 
                        if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])){
                          $device = 'Mobile';
                          if (preg_match('/Mac OS/i', $u_agent)) {
                              $platform = 'Apple';
                          }
                          elseif (preg_match('/Android/i', $u_agent)) {
                              $platform = 'Android';
                          }
                        }else if(preg_match("/(tablet|iPad)/i", $_SERVER["HTTP_USER_AGENT"])){
                          $device = 'Tablet';
                        }else{
                          $device = 'PC';
                          if (preg_match('/linux/i', $u_agent)) {
                              $platform = 'linux';
                          }
                          elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
                              $platform = 'mac';
                          }
                          elseif (preg_match('/windows|win32/i', $u_agent)) {
                              $platform = 'windows';
                          }
                        }
    $sess = $this->session->userdata("user");
    $ip = $this->get_client_ip();
    $this->db->set('log_time', 'NOW()', FALSE);
    $data = array(
      'log_type' => $activity,
      'massage' => $message,
      'ip' => $ip,
      'device' => $device." : ".$platform
    );
    !isset($sess['emp_id'])?:$data['emp_id'] = $sess['emp_id'];
    $this->db->insert('LMS_LG', $data);
  }
function get_client_ip()
 {
      $ipaddress = '';
      if (getenv('HTTP_CLIENT_IP'))
          $ipaddress = getenv('HTTP_CLIENT_IP');
      else if(getenv('HTTP_X_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
      else if(getenv('HTTP_X_FORWARDED'))
          $ipaddress = getenv('HTTP_X_FORWARDED');
      else if(getenv('HTTP_FORWARDED_FOR'))
          $ipaddress = getenv('HTTP_FORWARDED_FOR');
      else if(getenv('HTTP_FORWARDED'))
          $ipaddress = getenv('HTTP_FORWARDED');
      else if(getenv('REMOTE_ADDR'))
          $ipaddress = getenv('REMOTE_ADDR');
      else
          $ipaddress = 'UNKNOWN';

      return $ipaddress;
 }
  public function getRecords($date)
  {
    //
    $this->db->from('LMS_LG');
    //$this->db->where('LMS_EMP.lang', $lang);
	    if(isset($date['s'])&&isset($date['e'])){
	    	if($date['s']!="0000-00-00"&&$date['e']!="0000-00-00"){
			      $this->db->where('LMS_LG.log_time >=', date('Y-m-d H:i:00',strtotime($date['s'])));
			      $this->db->where('LMS_LG.log_time <=', date('Y-m-d H:i:00',strtotime($date['e'])));
	    	}
	    }
    //$where = "(LMS_LG.massage LIKE '%logged in website%' OR LMS_LG.massage LIKE '%logged in fail%')";
   	//$this->db->where($where);
    //$this->db->limit(10);
    $this->db->order_by('log_time', 'DESC');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getAllEmp($search="")
  {
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang") ;
    $user = $this->session->userdata("user");
    $this->db->select('LMS_USP.u_id,LMS_EMP.emp_c,LMS_EMP.emp_id,LMS_EMP.fullname_en,LMS_EMP.fullname_th,LMS_USP.useri, LMS_USP_GP.ug_id, LMS_USP_GP.ug_name_th, LMS_USP_GP.ug_name_en,LMS_USP_GP.ug_for,LMS_COMPANY.com_id, LMS_COMPANY.com_name_th, LMS_COMPANY.com_name_eng,LMS_EMP.status, LMS_EMP.lang,LMS_EMP.is_manager,LMS_USP.login ,LMS_USP.last_act,LMS_USP.firsttime,LMS_USP.expiredate,LMS_USP.img_profile');
    $this->db->from('LMS_USP');
    $this->db->join('LMS_EMP','LMS_USP.emp_id = LMS_EMP.emp_id');
    $this->db->join('LMS_COMPANY','LMS_EMP.com_id = LMS_COMPANY.com_id');
    $this->db->join('LMS_USP_GP','LMS_USP.ug_id = LMS_USP_GP.ug_id');
    $this->db->where('LMS_EMP.status', '1');
    if($user['ug_for']=="CUSTOMER"){
      $this->db->where('LMS_COMPANY.com_id', $user['com_id']);
    }
    if(isset($search['com_id'])&&$search['com_id']!=""){
      $this->db->where('LMS_COMPANY.com_id', $search['com_id']);
    }
    $query = $this->db->get();
    $all = $query->result_array();
    $emps = array();
    foreach ($all as $row) {
      $emps[$row['emp_id']]['fullname_th'] = $row['fullname_th'];
      $emps[$row['emp_id']]['fullname_en'] = $row['fullname_en'];
      if($lang=="thai"){
        $emps[$row['emp_id']]['com_name'] = $row['com_name_th'];
        $emps[$row['emp_id']]['ug_name'] = $row['ug_name_th'];
      }else{
        $emps[$row['emp_id']]['com_name'] = $row['com_name_eng'];
        $emps[$row['emp_id']]['ug_name'] = $row['ug_name_en'];
      }
      $emps[$row['emp_id']]['emp_id'] = $row['emp_id'];
      $emps[$row['emp_id']]['emp_c'] = $row['emp_c'];
      $emps[$row['emp_id']]['useri'] = $row['useri'];
    } return $emps;
  }
}
