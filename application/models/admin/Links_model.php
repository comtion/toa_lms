<?php
class Links_model extends CI_Model {

      //  public $title;
      //  public $content;
      //  public $date;

        public function __construct()
        {
                // Call the CI_Model constructor
                parent::__construct();
        }

        public function get_view(){
          $query = "select * from tbl_news where status = 1 order by cp_postview desc limit 5";
          $result = $this->db->query( $query );
          return  $result->result_array();
        }
        public function get_edit(){
          $query = "select * from tbl_news where status = 1 order by cp_edittime desc limit 5";
          $result = $this->db->query( $query );
          return  $result->result_array();
        }

        public function get_all_cat()
        {
              $query = "select * from tbl_link_group";
              $result = $this->db->query( $query );
              return  $result->result_array();
        }
        public function get_detail( $id, $code)
        {
          $return = array();
          $query = "select * from tbl_link_details where status = 1 and code = '".$code."'";
          $result = $this->db->query( $query );
          $ar_data =  $result->result_array();
          foreach( $ar_data as $data ){
            $return[$data['lang']] = $data ;
          }
          //print_r( $return );
          return $return;
        }
        public function get_code()
        {
          $return = array();
          $query = "select max(cp_code) as code from tbl_news ";
          $result = $this->db->query( $query );
          $ar_data =  $result->result_array();
          //$code = intval(str_replace('news','', $ar_data[0]['code'])) + 1;
          $code = intval($ar_data[0]['code']) + 1;
          return $code;
        }
        public function get_last_id()
        {
          $return = array();
          $query = "select max(cpid) as cpid from tbl_news ";
          $result = $this->db->query( $query );
          $ar_data =  $result->result_array();
          //$code = intval(str_replace('news','', $ar_data[0]['code'])) + 1;
          $code = $ar_data[0]['cpid'];
          return $code;
        }
        public function get_lang_tab( $id )
        {
          $return = array();
          $query = "select lang from tbl_link_details where id = '".$id."'";
          $result = $this->db->query( $query );
          $ar_data =  $result->result_array();
          $lang_tab = $ar_data[0]['lang'];
          return $lang_tab;
        }

        public function get_list()
        {
              $query = "select b.id, b.code, b.link_group, a.name as group_name,b.name, ";
              $query .= "b.descirption,b.link,b.lang,b.status,b.c_date from tbl_link_group a ";
              $query .= "inner join tbl_link_details b on a.id = b.link_group";
              $result = $this->db->query( $query );
              return  $result->result_array();
        }

        public function deleteNews( $id ){

              $data = array();
              $data['status'] = 0 ;
              $this->db->where('id', $id);
              $this->db->update('tbl_link_details', $data);
        }


      /*  public function insert_entry()
        {
                $this->title    = $_POST['title']; // please read the below note
                $this->content  = $_POST['content'];
                $this->date     = time();

                $this->db->insert('entries', $this);
        }

        public function update_entry()
        {
                $this->title    = $_POST['title'];
                $this->content  = $_POST['content'];
                $this->date     = time();

                $this->db->update('entries', $this, array('id' => $_POST['id']));
        } */

}