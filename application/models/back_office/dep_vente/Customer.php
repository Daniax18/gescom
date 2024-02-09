<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // PREDNRE TOUS LES CLIENTS
    public function customers() {
        $query = $this->db->get('customer');
        return $query->result_array();
    }

    // Get CLIENTS per id
    public function customerById($idcustomer){
        $this->db->select('*');
        $this->db->from('customer');
        $this->db->where('idcustomer', $idcustomer);
        $query = $this->db->get();

        return $query->row_array();
    }
}
