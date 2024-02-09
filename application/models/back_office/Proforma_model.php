<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proforma_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }


    public function getProformaById($id) {
        $query = $this->db->get_where('v_proforma_detail', array('idproforma' => $id));
        return $query->row_array();
    }

    public function getProforma() {
        $query = $this->db->get('v_proforma_detail');
        return $query->result_array();
    }

    public function getAllGlobal() {
        $query = $this->db->get('global');
        return $query->result_array();
    }

    public function getGlobal($id,$situation) {
        $query = $this->db->get_where('v_global_besoin', array('idglobal' => $id, 'situation' => $situation));
        // $query = $this->db->get_where('v_global_besoin_2', array('idglobal' => $id, 'situation' => $situation, 'idproforma' =>));
        return $query->result_array();
    }

    public function addDmdProforma($data) {
        $this->db->insert('proforma', $data);
        return $this->db->insert_id();
    }

     public function updateStatusTo1($idproforma) {
        $data = array(
            'status' => 1
        );
        $this->db->where('idproforma', $idproforma);
        $this->db->update('proforma', $data);
        $this->load->model('back_office/dep_achat/BesoinAchat');
        $proforma = $this -> getProformaById($idproforma);
        $this -> BesoinAchat -> updateStatusBesoins($proforma['idglobal'], 4);
    }

}
?>
