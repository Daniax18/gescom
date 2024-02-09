<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventaire_General extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->model('Back_office/dep_logistique/Inventaire');
        $this->load->model('Back_office/Fournisseur_model');
    }

    // GET PREVIOUS DETAIL INVENTAIRE D'UN PRODUIT
    public function getPreviousMaterialInventaire($idmateriel, $date){
        $last = $this -> getPreviousInventaire($date);
        if($last != null){
            $this->db->select('*');
            $this->db->from('v_detail_inventaire');
            $this->db->where('idinventaire', $last['idinventaire']);
            $this->db->where('idmateriel', $idmateriel);
            $query = $this->db->get();
            
            $temp =  $query->row_array();
            return $temp;
        }
        return null;
    }


    // GET PREVIOUS INVENTAIRE
    public function getPreviousInventaire($date){
        $this->db->select('*');
        $this->db->from('v_general_inventaire');
        $this->db->where('dateinventaire < ', $date);
        $this->db->where('status_inventaire', 2);
        $this->db->limit(1); // Limit the result to 1 row
        $query = $this->db->get();
        
        $temp =  $query->row_array();
        return $temp;
    }

}