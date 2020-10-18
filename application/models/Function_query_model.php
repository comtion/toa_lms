<?php
class Function_query_model extends CI_Model {

        public function __construct()
        {
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

        public function query_row($table_name="",$join_name="",$join_com="",$join="",$where_com="",$order_by="",$select=""){
          date_default_timezone_set("Asia/Bangkok");
          $this->db->from($table_name);
          if($join_name!=""&&$join_com!=""){
            $this->db->join($join_name,$join_com,$join);
          }
          if($select!=""){
            $this->db->select($select);
          }
          if($where_com!=""){
            $this->db->where($where_com);
          }
          if($order_by!=""){
            $this->db->order_by($order_by);
          }
          $query = $this->db->get();
          return $query->row_array();
        }

        public function query_result($table_name="",$join_name="",$join_com="",$join="",$where_com="",$order_by="",$select="",$limit="",$group_by=""){
          date_default_timezone_set("Asia/Bangkok");
          $this->db->from($table_name);
          if($select!=""){
            $this->db->distinct();
            $this->db->select($select);
          }
          if($group_by!=""){
            $this->db->group_by($group_by);
          }
          if($limit!=""){
            $this->db->limit(intval($limit)); 
          }
          if($join_name!=""&&$join_com!=""){
            $this->db->join($join_name,$join_com,$join);
          }
          if($where_com!=""){
            $this->db->where($where_com);
          }
          if($order_by!=""){
            $this->db->order_by($order_by);
          }
          $query = $this->db->get();
          return $query->result_array();
        }
        
        public function numrows($table_name="",$join_name="",$join_com="",$join="",$where_com="",$order_by="",$select=""){
          date_default_timezone_set("Asia/Bangkok");
          $this->db->from($table_name);
          if($join_name!=""&&$join_com!=""){
            $this->db->join($join_name,$join_com,$join);
          }
          if($select!=""){
            $this->db->distinct();
            $this->db->select($select);
          }
          if($where_com!=""){
            $this->db->where($where_com);
          }
          if($order_by!=""){
            $this->db->order_by($order_by);
          }
          $query = $this->db->get();
          return $query->num_rows();
        }
}
