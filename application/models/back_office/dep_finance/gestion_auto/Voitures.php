
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Voitures extends CI_Model {
    public function __construct(){
        parent::__construct();
    }

   // PRENDRE TOP DEPENSES ENTRETIEN + ENTRETIEN 
   public function getAllTotalDepense(){
        $this->db->select('*');
        $this->db->from('v_general_depense_total');
        $query = $this->db->get();
        
        $data = $query->result_array();
        return $data;
    }

    // PRENDRE TOP DEPENSES ENTRETIEN 
    public function getAllDepenseEntretien(){
        $this->db->select('*');
        $this->db->from('v_general_depense_entretien');
        $query = $this->db->get();
        
        $data = $query->result_array();
        return $data;
    }

    // PRENDRE TOP DEPENSES CARBURANT 
    public function getAllDepenseCarburant(){
        $this->db->select('*');
        $this->db->from('v_general_depense_carburant');
        $query = $this->db->get();
        
        $data = $query->result_array();
        return $data;
    }
}