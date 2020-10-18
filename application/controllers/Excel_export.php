<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Excel_export extends CI_Controller {

  public function export_user($com_id){
    $lang = $this->session->userdata("lang") == null ? "thai" : $this->session->userdata("lang");
    $this->lang->load($lang,$lang);
    $this->load->model('Function_query_model', 'func_query', FALSE);
    $this->func_query->loadDB();
    $result = array();
    $arr_posi = array();
    $arr_area = array();

    $fetch_company = $this->func_query->query_row('LMS_COMPANY','','','','com_id="'.$com_id.'" and com_isDelete="0"');
    $fetch_user = $this->func_query->query_result('LMS_EMP','LMS_USP','LMS_EMP.emp_id = LMS_USP.emp_id','','LMS_EMP.com_id = "'.$com_id.'" and LMS_EMP.emp_isDelete = "0" and LMS_USP.u_isDelete = "0" and LMS_EMP.emp_id not in (1,2)');
    $fetch_position = $this->func_query->query_result('LMS_POSITION','','','','com_id="'.$com_id.'" and posi_isDelete="0"');
    foreach ($fetch_position as $key_posi => $value_posi) {
      $arr_posi[$value_posi['posi_id']]['posi_code'] = $value_posi['posi_code'];
      $arr_posi[$value_posi['posi_id']]['posi_name'] = $value_posi['posi_name_en'];
    }
    $fetch_area = $this->func_query->query_result('LMS_AREA','','','','salearea_isDelete="0"');
    foreach ($fetch_area as $key_area => $value_area) {
      $arr_area[$value_area['salearea_id']]['salearea_code'] = $value_area['salearea_code'];
      $arr_area[$value_area['salearea_id']]['salearea_shot'] = $value_area['salearea_shot'];
      $arr_area[$value_area['salearea_id']]['salearea_name'] = $value_area['salearea_name_en'];
    }
    $fetch_section = $this->func_query->query_result('LMS_SECTION','','','','section_isDelete="0"');
    foreach ($fetch_section as $key_section => $value_section) {
      $arr_section[$value_section['section_id']]['section_code'] = $value_section['section_code'];
      $arr_section[$value_section['section_id']]['section_shot'] = $value_section['section_shot'];
      $arr_section[$value_section['section_id']]['section_name'] = $value_section['section_name_en'];
    }
    $fetch_department = $this->func_query->query_result('LMS_DEPART','','','','dep_isDelete="0"');
    foreach ($fetch_department as $key_department => $value_department) {
      $arr_department[$value_department['dep_id']]['dep_code'] = $value_department['dep_code'];
      $arr_department[$value_department['dep_id']]['dep_shot'] = $value_department['dep_shot'];
      $arr_department[$value_department['dep_id']]['dep_name'] = $value_department['dep_name_en'];
    }
    $fetch_group = $this->func_query->query_result('LMS_GROUP','','','','group_isDelete="0"');
    foreach ($fetch_group as $key_group => $value_group) {
      $arr_group[$value_group['group_id']]['group_code'] = $value_group['group_code'];
      $arr_group[$value_group['group_id']]['group_shot'] = $value_group['group_shot'];
      $arr_group[$value_group['group_id']]['group_name'] = $value_group['group_name_en'];
    }
    $fetch_div = $this->func_query->query_result('LMS_DIVISION','','','','div_isDelete="0"');
    foreach ($fetch_div as $key_div => $value_div) {
      $arr_div[$value_div['div_id']]['div_code'] = $value_div['div_code'];
      $arr_div[$value_div['div_id']]['div_shot'] = $value_div['div_shot'];
      $arr_div[$value_div['div_id']]['div_name'] = $value_div['div_name_en'];
    }
    $fetch_store = $this->func_query->query_result('LMS_STORE','','','','st_isDelete="0"');
    foreach ($fetch_store as $key_store => $value_store) {
      $arr_store[$value_store['st_id']]['st_cus_code'] = $value_store['st_cus_code'];
      $arr_store[$value_store['st_id']]['st_code'] = $value_store['st_code'];
      $arr_store[$value_store['st_id']]['st_group'] = $value_store['st_group'];
      $arr_store[$value_store['st_id']]['st_name'] = $value_store['st_name_en'];
    }
    header('Content-type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="data_users.xls"');
    ?>
    <!DOCTYPE html>
    <html>
    <head>
    <title>Export Data Users</title>
    </head>
    <body>
        <table border="1">
            <thead>
              <tr>
                <th>username</th>
                <th>user_email</th>
                <th>user_employee_id</th>
                <th>fname_th</th>
                <th>lname_th</th>
                <th>user_fullname_th</th>
                <th>fname_en</th>
                <th>lname_en</th>
                <th>user_fullname_en</th>
                <th>user_position_id</th>
                <th>user_position_name</th>
                <th>user_level</th>
                <th>user_parent_id</th>
                <th>user_area_id</th>
                <th>user_area_code</th>
                <th>user_area_name</th>
                <th>user_section_id</th>
                <th>user_section_name</th>
                <th>user_zone</th>
                <th>user_department_id</th>
                <th>user_department_name</th>
                <th>user_group_id</th>
                <th>user_group_name</th>
                <th>user_division_id</th>
                <th>user_division_name</th>
                <th>user_brand</th>
                <th>user_customer_code</th>
                <th>user_store_code</th>
                <th>user_store_group</th>
                <th>user_store_name</th>
                <th>user_join_date</th>
                <th>user_photo_url</th>
                <th>user_rate</th>
                <th>user_observer</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                if(count($fetch_user)>0){
                    foreach ($fetch_user as $key_user => $value_user) {
                        $fetch_chkmanager = $this->func_query->query_row('LMS_EMP','','','','emp_id = "'.$value_user['emp_parent_id'].'" and LMS_EMP.emp_isDelete = "0"');
                        $emp_c_manager = count($fetch_chkmanager)>0?$fetch_chkmanager['emp_c']:"";
                        ?>
                        <tr>
                          <td><?php echo $value_user['useri']; ?></td>
                          <td><?php echo $value_user['email']; ?></td>
                          <td><?php echo $value_user['emp_c']; ?></td>
                          <td><?php echo $value_user['fname_th']; ?></td>
                          <td><?php echo $value_user['lname_th']; ?></td>
                          <td><?php echo $value_user['fullname_th']; ?></td>
                          <td><?php echo $value_user['fname_en']; ?></td>
                          <td><?php echo $value_user['lname_en']; ?></td>
                          <td><?php echo $value_user['fullname_en']; ?></td>
                          <td><?php echo $arr_posi[$value_user['posi_id']]['posi_code']; ?></td>
                          <td><?php echo $arr_posi[$value_user['posi_id']]['posi_name']; ?></td>
                          <td><?php echo $value_user['emp_level']; ?></td>
                          <td><?php echo $emp_c_manager; ?></td>
                          <td><?php echo $arr_area[$value_user['salearea_id']]['salearea_code']; ?></td>
                          <td><?php echo $arr_area[$value_user['salearea_id']]['salearea_shot']; ?></td>
                          <td><?php echo $arr_area[$value_user['salearea_id']]['salearea_name']; ?></td>
                          <td><?php echo $arr_section[$value_user['section_id']]['section_code']; ?></td>
                          <td><?php echo $arr_section[$value_user['section_id']]['section_name']; ?></td>
                          <td><?php echo $value_user['emp_zone']; ?></td>
                          <td><?php echo $arr_department[$value_user['dep_id']]['dep_code']; ?></td>
                          <td><?php echo $arr_department[$value_user['dep_id']]['dep_name']; ?></td>
                          <td><?php echo $arr_group[$value_user['group_id']]['group_code']; ?></td>
                          <td><?php echo $arr_group[$value_user['group_id']]['group_name']; ?></td>
                          <td><?php echo $arr_div[$value_user['div_id']]['div_code']; ?></td>
                          <td><?php echo $arr_div[$value_user['div_id']]['div_name']; ?></td>
                          <td><?php echo $fetch_company['com_code']; ?></td>
                          <td><?php echo isset($arr_store[$value_user['st_id']])?$arr_store[$value_user['st_id']]['st_cus_code']:""; ?></td>
                          <td><?php echo isset($arr_store[$value_user['st_id']])?$arr_store[$value_user['st_id']]['st_code']:""; ?></td>
                          <td><?php echo isset($arr_store[$value_user['st_id']])?$arr_store[$value_user['st_id']]['st_group']:""; ?></td>
                          <td><?php echo isset($arr_store[$value_user['st_id']])?$arr_store[$value_user['st_id']]['st_name']:""; ?></td>
                          <td><?php echo $value_user['emp_join_date']; ?></td>
                          <td><?php echo $value_user['emp_photo_url']; ?></td>
                          <td><?php echo $value_user['emp_rate']; ?></td>
                          <td><?php echo $value_user['emp_observer']; ?></td>
                        </tr>
                        <?php
                    }
                }
              ?>
            </tbody>
        </table>

    </body>
    </html>
    <?php 

  }
}
?>