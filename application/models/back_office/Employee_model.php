<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // GET ALL DEPARTEMENT
    public function getAllDepartements(){
        $this->db->select('*');
        $this->db->from('departement');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function check_credentials($email, $password) {
        $query = $this->db->get_where('v_employee_detail', array('email' => $email, 'pwd' => $password));
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return false;
        }
    }

}
