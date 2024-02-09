<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fournisseur_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function insert_fournisseur($data) {

        $this->db->insert('fournisseur', $data);
        return $this->db->insert_id();
    }

    public function get_fournisseur($idfournisseur) {
        $query = $this->db->get_where('fournisseur', array('idfournisseur' => $idfournisseur));
        return $query->row_array();
    }

    public function get_all_fournisseurs() {
        $query = $this->db->get('fournisseur');
        return $query->result_array();
    } 

}
?>
