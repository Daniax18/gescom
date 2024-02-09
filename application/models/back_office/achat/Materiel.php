<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Materiel extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // GET PRIX DE VENTE D'UN MATERIEL
    public function get_materiel_unit_price_sell($idmateriel){
        $taux_benefice = $this -> getTauxBenefice();
        $this->db->select('*');
        $this->db->from('stock_entree');
        $this->db->where('idmateriel', $idmateriel);
        $this->db->order_by('dateentree', 'ASC');
        $this->db->limit(1); 
        $query = $this->db->get();

        $temp = $query->row_array();

        if (empty($temp)) {
            // echo "empty";
            return 0;
        } else {
            return $temp['unitpriceentree'] * $taux_benefice['marge'];
        }   
    }

    // GET BENEFICE SOUTENU
    public function getTauxBenefice(){
        $this->db->select('*');
        $this->db->from('taux_benefice');
        $this->db->order_by('datechoice', 'DESC');
        $this->db->limit(1); 
        $query = $this->db->get();

        $temp = $query->row_array();
        return $temp;
    }

    // BOOLEAN POUR SAVOIR LE TYPE DE STOCKAGE D'UN PRODUIT
    public function is_lifo($idmateriel){
        $detail = $this -> getMaterielDetailById($idmateriel);
        if($detail['idstockage'] == 'ST1') return true;
        return false;
    }

    public function is_fifo($idmateriel){
        $detail = $this -> getMaterielDetailById($idmateriel);
        if($detail['idstockage'] == 'ST2') return true;
        return false;
    }

    public function is_cmup($idmateriel){
        $detail = $this -> getMaterielDetailById($idmateriel);
        if($detail['idstockage'] == 'ST3') return true;
        return false;
    }
    
    // PRENDRE LES SUPPLIERS D'UN NATURE
    public function getSuppliersOfNature($idnature){
        $this->db->select('*');
        $this->db->from('fournisseur_nature');
        $this->db->where('idnature', $idnature);
        $query = $this->db->get();

        return $query->result_array();
    }

    // PRENDRE LES NATURES D'UN FOURNISSEURES
    public function getSupplierNature($idfournisseur){
        $this->db->select('*');
        $this->db->from('fournisseur_nature');
        $this->db->where('idfournisseur', $idfournisseur);
        $query = $this->db->get();

        return $query->result_array();
    }


    // PREDNRE TOUS LES MATERIELS
    public function materiels() {
        $query = $this->db->get('v_materiel_detail');
        return $query->result_array();
    }

    // PREDNRE TOUS LES MATERIELS
    public function materiel_stocks() {
        $query = $this->db->get('v_materiel_detail_stockage');
        return $query->result_array();
    }

    // Get FRN per id
    public function supplierById($idfournisseur){
        $this->db->select('*');
        $this->db->from('fournisseur');
        $this->db->where('idfournisseur', $idfournisseur);
        $query = $this->db->get();

        return $query->row_array();
    }

    public function getMaterielById($idmateriel) {
        $this->db->where('idmateriel', $idmateriel);
        $query = $this->db->get('v_materiel_detail');
    
        if ($query->num_rows() == 1) {
            return $query->row_array(); // Retourne un tableau associatif pour un seul résultat
        } else {
            return null; // Aucun résultat trouvé ou plusieurs résultats (cas d'erreur)
        }
    }

    public function getMaterielDetailById($idmateriel) {
        $this->db->where('idmateriel', $idmateriel);
        $query = $this->db->get('v_materiel_detail_stockage');
    
        if ($query->num_rows() == 1) {
            return $query->row_array(); // Retourne un tableau associatif pour un seul résultat
        } else {
            return null; // Aucun résultat trouvé ou plusieurs résultats (cas d'erreur)
        }
    }


}
