<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BonEntree extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->model('Back_office/achat/Materiel');
        $this->load->model('Back_office/Fournisseur_model');
        $this->load->model('back_office/dep_achat/BonReception');
    }

    // SAVE MAIN B L WITH PDF
    public function saveBonEntreeWithReceptionPdf($idbonentree, $file){
        $this->db->trans_start(); // Start a transaction
        $this -> savePdfBonEntreeReception($idbonentree, $file);
        $this -> saveGeneralBonEntree($idbonentree);
        $this->db->trans_complete(); // Complete the transaction
    }

    // ENREGISTRER UN BON D'ENTREE
    public function saveGeneralBonEntree($idbonentree){
        $this->db->trans_start(); // Start a transaction
        $data = $this -> getBonEntreeById($idbonentree);
        $this -> BonReception -> updateStatusBonReception($data['idbonreception'], 1);
        $this -> updateStatusBonEntree($idbonentree, 0);

        $this->db->trans_complete(); // Complete the transaction
    }

    // SAVE PDF APERCU B RECEPTION
    public function savePdfBonEntreeReception($idbonentree, $file){
        $query = sprintf("UPDATE bon_entree SET pathjustificatif = '%s' WHERE idbonentree = '%s'", $file, $idbonentree);
        $sql = $this->db->query($query);
    }

    // UPDATE STATUS OF BON ENTREE
    public function updateStatusBonEntree($idbonentree, $status){
        $query = sprintf("UPDATE bon_entree SET status_entree = %u WHERE idbonentree = '%s'", $status, $idbonentree);
        $sql = $this->db->query($query);
    }

    // PRENDRE DETAIL_BON_ENTREE
    public function getDetailEntree($idbonentree){
        $this->db->select('*');
        $this->db->from('v_detail_entree');
        $this->db->where('idbonentree', $idbonentree);
        $query = $this->db->get();
        return $query->result_array();
    }

    // PRENDRE UN BON D'ENTREE PAR ID
    public function getBonEntreeById($idbonentree){
        $this->db->select('*');
        $this->db->from('v_general_entree');
        $this->db->where('idbonentree', $idbonentree);
        $query = $this->db->get();

        return $query->row_array();
    }

    // DELETE CACHE OF BON ENTREE
    public function deleteCacheBonEntree(){
        $this->db->trans_start(); // Start a transaction

        $this->db->where('idbonentree IN (SELECT idbonentree FROM bon_entree WHERE status_entree = -1)', NULL, FALSE);
        $this->db->delete('detail_entree');

        $this->db->where('status_entree', -1);
        $this->db->delete('bon_entree');

        $this->db->trans_complete(); // Complete the transaction
    }

    // AJOUT DETAIL BON D'ENTREE
    public function saveDetailEntree($idbonentree, $idmateriel, $qty, $remarque){
        $query = $this->db->query("SELECT nextval('seq_detail_entree')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'BE_DET_' . $sequence_value;
        $data['iddetailentree'] = $id;
        $data['idbonentree'] = $idbonentree;
        $data['idmateriel'] = $idmateriel;
        $data['qty_received'] = $qty;
        $data['remarque'] = $remarque;

        $this->db->insert('detail_entree', $data);
    }

    // AJOUT GENERAL BON ENTREE
    public function createMainBonEntree($idreception, $dateEntree, $idemployee){
        $query = $this->db->query("SELECT nextval('seq_bon_entree')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'BE_' . $sequence_value;
        $data['idbonentree'] = $id;
        $data['dateentree'] = $dateEntree;
        $data['idbonreception'] = $idreception;
        $data['idemployee'] = $idemployee;
        $data['status_entree'] = -1;

        $this->db->insert('bon_entree', $data);

        return $id;
    }

    // PRENDRE LES BONS D'ENTREE RECENTS
    public function getRecentBonEntree(){
        $this->db->select('*');
        $this->db->from('v_general_entree');
        $this->db->order_by('dateentree', 'DESC');
        $query = $this->db->get();
        
        $data = $query->result_array();
        
        return $data;
    }
}