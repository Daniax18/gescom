<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BonLivraisonClient extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->model('Back_office/dep_vente/Commande_client');
    }

    
    // ENREGISTRER LE BON DE COMMANDE ENVOYE

    public function saveBonLivraisonClientPdfSent($idlivraisonclient, $namefile){
        $query = sprintf("UPDATE bon_livraison_client SET pathjustificatif = '%s' WHERE idlivraisonclient = '%s'", $namefile, $idlivraisonclient);
        $sql = $this->db->query($query);
    }

    // ENREGISTER STOCK SORTIE
    public function makeSortie($idlivraisonclient, $idboncommande, $date, $idemployee){
        $details = $this -> getDetailLivraisonById($idlivraisonclient);
        $this->load->model('Back_office/stock_option/Stock');

        $this->db->trans_start(); // Start a transaction
        foreach($details as $detail){
            $this -> Stock -> make_sortie($detail['idmateriel'], $detail['qty_request'], $date, $idemployee, $detail['unit_price_ht'], null);
        }

        $this->db->trans_complete(); // Complete the transaction
    }


    // LIVRERE UN BON DE COMMANDE
    public function makeLivraisonBonCommande($idboncommande, $date, $idemployee){

        $query = $this->db->query("SELECT nextval('seq_bl_client')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'BL_CLI_' . $sequence_value;

        $data['idlivraisonclient'] = $id;
        $data['idcommandeclient'] = $idboncommande;
        $data['idemployee'] = $idemployee;
        $data['date_livraison'] = $date;
        $this->db->trans_start(); // Start a transaction
        $this -> Commande_client -> updateStatusCommandeClient($idboncommande, 3);
        $this->db->insert('bon_livraison_client', $data);
        $this -> makeSortie($id, $idboncommande, $date, $idemployee);
        $this->db->trans_complete(); // Complete the transaction
        return $id;
    }

    // PRENDRE DETAIL BON DE LIVRAISON par ID
    public function getDetailLivraisonById($idlivraisonclient){
        $this->db->select('*');
        $this->db->from('v_detail_livraison_client');
        $this->db->where('idlivraisonclient', $idlivraisonclient);
        $query = $this->db->get();

        $data = $query->result_array();
        return $data;
    }

    // PRENDRE UN BON DE LIVRAISON PAR ID
    public function getBonLivraisonById($idlivraisonclient){
        $this->db->select('*');
        $this->db->from('v_general_livraison_client');
        $this->db->where('idlivraisonclient', $idlivraisonclient);
        $query = $this->db->get();

        return $query->row_array();
    }

    // TOUS LES B.L EMIS
    public function getBonLivraisonClientMade(){
        $this->db->select('*');
        $this->db->from('v_general_livraison_client');
        $this->db->order_by('date_livraison', 'DESC');
        $query = $this->db->get();

        $data = $query->result_array();
        return $data;
    }

    // PRENDRE LES BONS DE COMMANDES A LIVRER
    public function getCommandeNeedBonLivraison(){
        $this->db->select('*');
        $this->db->from('v_general_commande_client');
        $this->db->where('status_commande_client', 2);
        $this->db->order_by('date_commande_client_received ', 'DESC');
        $query = $this->db->get();

        $data = $query->result_array();
        return $data;
    }    

}