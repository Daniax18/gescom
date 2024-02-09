<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Besoin extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    // MAKE A RECEPTION
    public function makeReceptionMateriel($idbonsortie){
        $this -> load -> model('Back_office/dep_logistique/BonSortie');
        $this -> BonSortie -> updateStatusBonSortie($idbonsortie, 1);
    }

    // PRENDRE LES BESOINS RECUS
    public function getMaterielsReceived($iddepartement){
        $this->db->select('*');
        $this->db->from('v_general_sortie');
        $this->db->where('iddepartement', $iddepartement);
        $this->db->where('status_sortie >= ', 0);
        $query = $this->db->get();

        return $query->result_array();
    }

    // PRENDRE LA LISTE DE TOUS LES DEMANDES DEJA FAIT
    // Besoins an departement misy anazy ihany
    public function besoins($iddepartement) {
        $this->db->select('*');
        $this->db->from('v_besoin_general');
        $this->db->where('iddepartement', $iddepartement);
        $query = $this->db->get();

        $data = $query->result_array();
        
        $result = array();
        for($i = 0; $i < count($data); $i++){
            $result[$i] = $data[$i];
            $temp = $this -> my_status($data[$i]['situation']);
            $result[$i]['status'] = $temp;
        }
        return $result;
    }

    // PRENDRE LE STATUS D'UN BESOIN
    public function my_status($situation){
        $donnes = array("Attente validation chef", "Valide par chef departement", "Grouper en Besoin Global", "Proforma cree", "Proforma envoye", "Proforma recu", "Bon Commande Envoye");
        $progress = (($situation + 1) / count($donnes)) * 100;
        $result = array();
        $result[] = $donnes[$situation];
        $result[] = $progress;
        return $result;
    }

    // ENREGISTRER UN BESOIN 
    public function saveBesoin($idbesoin){
        $this -> updateBesoinStatus($idbesoin, 0);
    }

    // MODIFIER STATUS D'UN BESOIN
    public function updateBesoinStatus($idbesoin, $status) {
        $query = sprintf("UPDATE besoin SET situation = %u WHERE idbesoin = '%s'", $status, $idbesoin);
        $sql = $this->db->query($query);
    }

    // AJOUTER UN MATERIEL DANS UN BESOIN
    public function addDetailBesoin($idbesoin, $idmateriel, $qty){
        $query = $this->db->query("SELECT nextval('seq_detailbesoin')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'DET_' . $sequence_value;
        $data['iddetail'] = $id;
        $data['idmateriel'] =  $idmateriel;
        $data['idbesoin'] = $idbesoin;
        $data['qte'] = $qty;

        $this->db->insert('detailbesoin', $data);
    }

    // LISTE DES MATERIELS POUR UN BESOIN SPECIFIC
    public function getBesoinDetail($idBesoin){
        $this->db->select('*');
        $this->db->from('v_besoin_detail');
        $this->db->where('idbesoin', $idBesoin);
        $query = $this->db->get();

        return $query->result_array();
    }

    // CREER EN PREMIER UN BESOIN
    // prendre le departement et l'employee
    public function createBesoin($iddepartement, $idemployee) {
        
        $query = $this->db->query("SELECT nextval('seq_besoin')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'BES_' . $sequence_value;
        $data['idbesoin'] = $id;
        $data['date'] = date('Y-m-d');

        $data['iddepartement'] = $iddepartement;
        $data['idemployee'] = $idemployee;
        $data['situation'] = -1;

        $this->db->insert('besoin', $data);

        return $id;
    }

    // SUPPRIMER LES BESOIN QUI N'ONT PAS ETE SAUBVEGARDER
    public function deleteUnsavedBesoin() {
        $this->db->trans_start(); // Start a transaction

        // Delete from 'detailbesoin' where 'idbesoin' matches the deleted records from 'besoin'
        $this->db->where('idbesoin IN (SELECT idbesoin FROM besoin WHERE situation = -1)', NULL, FALSE);
        $this->db->delete('detailbesoin');

        // Delete from 'besoin' where 'situation' equals -1
        $this->db->where('situation', -1);
        $this->db->delete('besoin');

        $this->db->trans_complete(); // Complete the transaction
    }

    // AJOUTER UN MATERIEL DANS UN BESOIN
    public function updateDetailBesoin($id, $qty){
        $data['qte'] = $qty;

        $this->db->update('detailbesoin', $data, array('iddetail' => $id));
    }
    public function deleteDetailBesoin($id){
        $this->db->delete('detailbesoin', array('iddetail' => $id));
    }
}
