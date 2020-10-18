<?php
class Contact_model extends CI_model {
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

  public function getemp($emp_c,$lang)
  {
    $this->db->from('LMS_EMP');
    $this->db->where('emp_c', $emp_c);
    $this->db->where('lang', $lang);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function gete()
  {
    $this->db->from('LMS_ADM');
    $query = $this->db->get();
    return $query->result_array();
  }

  public function deletee($id)
  {
    $this->db->where('id', $id);
    $this->db->delete('LMS_ADM');
  }

  public function savee($newemail)
  {
    $this->db->set('email', $newemail);
    $this->db->set('setct', 'no');
    $this->db->insert('LMS_ADM');
  }

  public function editeed($id, $newemail)
  {
    $this->db->from('LMS_ADM');
    $this->db->where('id', $id);
    $this->db->set('email', $newemail);
    $this->db->update('LMS_ADM');
  }

  public function setme($id)
  {
    $this->updatee();
    $this->db->from('LMS_ADM');
    $this->db->where('id', $id);
    $this->db->set('setct', 'yes');
    $this->db->update('LMS_ADM');
  }

  private function updatee()
  {
    $this->db->from('LMS_ADM');
    $this->db->where('setct', 'yes');
    $this->db->set('setct', 'no');
    $this->db->update('LMS_ADM');
  }
}
