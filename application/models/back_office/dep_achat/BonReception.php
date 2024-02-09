<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BonReception extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->model('Back_office/achat/Materiel');
        $this->load->model('Back_office/Fournisseur_model');
    }

    // UPDATE STATUS OF BON RECEPTION
    public function updateStatusBonReception($idreception, $status){
        $query = sprintf("UPDATE bon_reception SET status_reception = %u WHERE idbonreception = '%s'", $status, $idreception);
        $sql = $this->db->query($query);
    }

    // PRENDRE DETAIL_BON_RECEPTION
    public function getDetailReception($idreception){
        $this->db->select('*');
        $this->db->from('v_detail_reception');
        $this->db->where('idbonreception', $idreception);
        $query = $this->db->get();
        return $query->result_array();
    }

    // PRENDRE UN B.R par ID
    public function getBonReceptionById($idreception){
        $this->db->select('*');
        $this->db->from('v_general_reception');
        $this->db->where('idbonreception', $idreception);
        $query = $this->db->get();

        return $query->row_array();
    }

    // AJOUT DETAIL BON RECEPTION
    public function addDetailReception($idreception, $idmateriel, $qty_request, $qty_received){
        $query = $this->db->query("SELECT nextval('seq_detail_reception')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'BR_DET_' . $sequence_value;
        $data['iddetailreception'] = $id;
        $data['idbonreception'] = $idreception;
        $data['idmateriel'] = $idmateriel;
        $data['qty_request'] = $qty_request;
        $data['qty_received'] = $qty_received;

        $this->db->insert('detail_reception', $data);
    }

    // AJOUT GENERAL BON RECEPTION
    public function createMainReception($idlivraison, $datereception, $idemployee){
        $this->load->model('Back_office/dep_achat/BonLivraison');
        $query = $this->db->query("SELECT nextval('seq_bon_reception')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'BR_' . $sequence_value;
        $data['idbonreception'] = $id;
        $data['idbonlivraison'] = $idlivraison;
        $data['datereception'] = $datereception;
        $data['idemployee'] = $idemployee;
        $data['status_reception'] = 0;

        $this->db->trans_start(); // Start a transaction
        $this->db->insert('bon_reception', $data);
        $this -> BonLivraison -> updateStatusBonLivraison($idlivraison, 1);
        $this->db->trans_complete(); // Complete the transaction
        return $id;
    }

    // PRENDRE LES BONS DE RECEPTIONS RECENTS
    public function getRecentBrNotAttached(){
        $this->db->select('*');
        $this->db->from('bon_reception');
        $this->db->where('status_reception >= ', 0);
        $this->db->order_by('datereception', 'DESC');
        $query = $this->db->get();
        
        $data = $query->result_array();
        return $data;
    }    

    // PRENDRE LES BONS DE RECEPTIONS RECENTS
    public function getRecentBonReception(){
        $this->db->select('*');
        $this->db->from('v_general_reception');
        $this->db->order_by('datereception', 'DESC');
        $query = $this->db->get();

        $data = $query->result_array();
        
        $result = array();
        for($i = 0; $i < count($data); $i++){
            $result[$i] = $data[$i];
            $temp = $this -> bon_reception_status($data[$i]['status_reception']);
            $result[$i]['status'] = $temp;
        }
        return $result;
    }    

    // STATUS BON DE RECEPTION
    public function bon_reception_status($status){
        $donnes = array("Cree", "Rattache B.Entree");
        $progress = (($status + 1) / count($donnes)) * 100;
        $result = array();
        $result[] = $donnes[$status];
        $result[] = $progress;
        return $result;
    }
}