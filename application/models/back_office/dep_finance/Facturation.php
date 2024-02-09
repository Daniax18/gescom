<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facturation extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->model('Back_office/dep_vente/Commande_client');
    }

    
    // ENREGISTRER LE PROFORMA ENVOYE
    public function saveFactureClientPdfSent($idfacturation, $namefile){
        $query = sprintf("UPDATE facturation SET pathjustificatif = '%s' WHERE idfacturation = '%s'", $namefile, $idfacturation);
        $sql = $this->db->query($query);
    }

    // CALCULER LE TOTAL MONTANT D'UNE FACRURE
    public function getTotalMontantFactureClient($idfacturation){
        $sql = sprintf("SELECT SUM(montant_ht) as ht, SUM(montant_ttc) as ttc FROM v_detail_facturation_client WHERE idfacturation = '%s'", $idfacturation);
        $query = $this->db->query($sql);

        $result = $query->row_array();
        return $result;
    }


    // FACTURATION D'UN BON DE COMMANDE
    public function facturateBonCommande($idboncommande, $date, $idemployee){

        $query = $this->db->query("SELECT nextval('seq_facturation')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'FAC_CLI_' . $sequence_value;

        $data['idfacturation'] = $id;
        $data['idcommandeclient'] = $idboncommande;
        $data['idemployee'] = $idemployee;
        $data['date_facturation'] = $date;
        $this->db->trans_start(); // Start a transaction
        $this -> Commande_client -> updateStatusCommandeClient($idboncommande, 2);
        $this->db->insert('facturation', $data);
        $this->db->trans_complete(); // Complete the transaction
        return $id;
    }

    // PRENDRE DETAIL FACTURATION par ID
    public function getDetailFacturationById($idfacturation){
        $this->db->select('*');
        $this->db->from('v_detail_facturation_client');
        $this->db->where('idfacturation', $idfacturation);
        $query = $this->db->get();

        $data = $query->result_array();
        return $data;
    }

    // PRENDRE UNE FACTURE  par ID
    public function getFacturationById($idfacturation){
        $this->db->select('*');
        $this->db->from('v_general_facturation_client');
        $this->db->where('idfacturation', $idfacturation);
        $query = $this->db->get();

        return $query->row_array();
    }

    // TOUS LES FACTURATIONS
    public function getFacturationMade(){
        $this->db->select('*');
        $this->db->from('v_general_facturation_client');
        $this->db->order_by('date_facturation', 'DESC');
        $query = $this->db->get();

        $data = $query->result_array();
        return $data;
    }

    // PRENDRE LES BONS DE COMMANDES A FACTURER
    public function getCommandeNeedFacturation(){
        $this->db->select('*');
        $this->db->from('v_general_commande_client');
        $this->db->where('status_commande_client', 1);
        $this->db->order_by('date_commande_client_received ', 'DESC');
        $query = $this->db->get();

        $data = $query->result_array();
        return $data;
    }    

}