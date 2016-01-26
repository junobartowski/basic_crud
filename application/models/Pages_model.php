<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Pages_model extends CI_Model {

    var $table = 'pages';
    var $column = array('url', 'name', 'title', 'description');
    var $order = array('id' => 'desc');

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //Returns all data from pages table
    public function get_all_data() {
        $query = $this->db->get($this->table);
        return $query->result();
    }

    //Returns specific data from pages table
    public function get_data_by_id($id) {
        $query = $this->db->get_where($this->table, array('id' => $id));
        return $query->result();
    }

    //Saves data to pages table
    public function save($data) {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    //Updates data from pages table
    public function edit($id, $data) {
        return $this->db->update($this->table, $data, array('id' => $id));
    }

    //Deletes data from pages table
    public function delete($id) {
        return $this->db->delete($this->table, array('id' => $id));
    }
    
    //Deletes data from pages table
    public function is_url_exists($url) {
        $query = $this->db->get_where($this->table, array('url' => $url));
        return $query->num_rows();
    }

}
