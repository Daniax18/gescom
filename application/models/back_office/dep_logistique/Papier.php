<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Papier extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    public function getaLL(){
        $sql = "SELECT * FROM PAPIER";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
    public function papier($idpapier){
        $this->db->select('*');
        $this->db->from('papier');
        $this->db->where('idpapier', $idpapier);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function insert($data) {
        // if($data['date_debut'] > $data['date_fin']){
            $this->db->insert('admin', $data);
            return $this->db->insert_id();
        // }
        
    }
    public function getPapier($idvoiture, $idpapier){
        $this->db->select('*');
        $this->db->from('v_papier');
        $this->db->where('idvoiture', $idvoiture);
        $this->db->where('idpapier', $idpapier);
        $query = $this->db->get();
        $result = $query->result_array();
        return $result;
    }
}