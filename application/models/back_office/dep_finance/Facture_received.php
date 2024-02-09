<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Facture_received extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->model('Back_office/achat/Materiel');
    }

    // SAVE MAIN FACTURE RECEIVED WITH PDF
    public function saveFactureReceivedWithPdf($idfacturereceived, $file){
        $this->db->trans_start(); // Start a transaction
        $this -> saveEntreeStock($idfacturereceived);
        $this -> savePdfFactureReceived($idfacturereceived, $file);
        $this -> saveGeneralFactureReceived($idfacturereceived);
        $this->db->trans_complete(); // Complete the transaction
    }

    // SAVE MAIN FACTURE + ENTREE EN STOCK
    public function saveEntreeStock($idfacturereceived){
        $this->load->model('Back_office/stock_option/Stock');
        $details = $this -> getDetailFactureReceived($idfacturereceived);
        $general = $this -> getFactureReceivedById($idfacturereceived);
        $this->db->trans_start(); // Start a transaction
        foreach($details as $detail){
            $this -> Stock -> insert_stock_entree($detail['idmateriel'], $detail['unit_price'], $general['datefacture'], $detail['qty_received'], $detail['montant_detail_ht'], $detail['montant_detail_ttc']);
        }
        $this->db->trans_complete(); // Complete the transaction
    }

    // ENREGISTRER UNE FACTURE RECEIVED
    public function saveGeneralFactureReceived($idfacturereceived){
        $this->db->trans_start(); 
        $this -> updateMontantHtFactureReceived($idfacturereceived);
        $this -> updateMontantTtcFactureReceived($idfacturereceived);
        $this -> updateStatusFactureReceived($idfacturereceived, 0);
        $this->db->trans_complete(); // Complete the transaction
    }

    // GET THE PDF FILE
    public function savePdfFactureReceived($idfacturereceived, $file){
        $query = sprintf("UPDATE facture_received SET pathjustificatif = '%s' WHERE idfacturereceived = '%s'", $file, $idfacturereceived);
        $sql = $this->db->query($query);
    }

    // UPDATE STATUS OF FACTURE RECEIVED
    public function updateStatusFactureReceived($idfacturereceived, $status){
        $query = sprintf("UPDATE facture_received SET status_facture = %u WHERE idfacturereceived = '%s'", $status, $idfacturereceived);
        $sql = $this->db->query($query);
    }
    
    // UPDATE TOTAL MONTANT TTC D'UNE FATCURE
    public function updateMontantTtcFactureReceived($idfacturereceived){
        $montant = $this -> getTotalMontantHtFactureReceived($idfacturereceived);
        $ttc = ($montant * 0.2) + $montant;
        $query = sprintf("UPDATE facture_received SET montant_ttc_facture = %f WHERE idfacturereceived = '%s'", $ttc, $idfacturereceived);
        $sql = $this->db->query($query);
    }

    // UPDATE TOTAL MONTANT HT D'UNE FATCURE
    public function updateMontantHtFactureReceived($idfacturereceived){
        $montant = $this -> getTotalMontantHtFactureReceived($idfacturereceived);
        $query = sprintf("UPDATE facture_received SET montant_ht_facture = %f WHERE idfacturereceived = '%s'", $montant, $idfacturereceived);
        $sql = $this->db->query($query);
    }

    // CALCULER LE TOTAL MONTANT D'UNE FACTURE
    public function getTotalMontantHtFactureReceived($idfacturereceived){
        $sql = sprintf("SELECT SUM(montant_detail_ht) as montant FROM detail_facture_received WHERE idfacturereceived = '%s'", $idfacturereceived);
        $query = $this->db->query($sql);

        $result = $query->row_array();
        if (empty($result['montant'])) {
            return 0;
        } else {
            return $result['montant'];
        }
    }

    // PRENDRE DETAIL FACTURE RECU
    public function getDetailFactureReceived($idfacturereceived){
        $this->db->select('*');
        $this->db->from('v_detail_facture_received');
        $this->db->where('idfacturereceived', $idfacturereceived);
        $query = $this->db->get();
        return $query->result_array();
    }

    // PRENDRE UNE FACTURE RECU PAR ID
    public function getFactureReceivedById($idfacturereceived){
        $this->db->select('*');
        $this->db->from('v_general_facture_received');
        $this->db->where('idfacturereceived', $idfacturereceived);
        $query = $this->db->get();

        return $query->row_array();
    }

    // DELETE CACHE OF FACTURE RECEIVED
    public function deleteCacheFactureReceived(){
        $this->db->trans_start(); // Start a transaction

        $this->db->where('idfacturereceived IN (SELECT idfacturereceived FROM facture_received WHERE status_facture = -1)', NULL, FALSE);
        $this->db->delete('detail_facture_received');

        $this->db->where('status_facture', -1);
        $this->db->delete('facture_received');

        $this->db->trans_complete(); // Complete the transaction
    }

    // AJOUT DETAIL FACTURE RECEIVED
    public function saveDetailFactureReceived($idfacturereceived, $idmateriel, $qty, $remarque){
        $query = $this->db->query("SELECT nextval('seq_detail_facture_received')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'FA_RE_DET_' . $sequence_value;
        $data['iddetailfacturereceived'] = $id;
        $data['idfacturereceived'] = $idfacturereceived;
        $data['idmateriel'] = $idmateriel;
        $data['qty_received'] = $qty;
        $unit_price = $this -> getUnitPriceMateriel($idmateriel, $idfacturereceived);
        $data['unit_price'] = $unit_price;
        $data['montant_detail_ht'] = $unit_price * $qty;
        $data['montant_detail_ttc'] = (($unit_price * 0.2) + $unit_price) * $qty;
        $data['remarque'] = $remarque;

        $this->db->insert('detail_facture_received', $data);
    }

    // PRENDRE LE PRIX UNITAIRE PAR RAPPORT AU BON DE COMMANDE
    public function getUnitPriceMateriel($idmateriel, $idfacturereceived){

        $bc = $this -> getBonCommandeReference($idfacturereceived);
        // var_dump($bc);
        $this->db->select('pu');
        $this->db->from('detailcommande');
        $this->db->where('idboncommande', $bc['idboncommande']);
        $this->db->where('idmateriel', $idmateriel);
        $query = $this->db->get();

        $result = $query->row_array();
        // var_dump($result);

        if (empty($result)) {
            return 0;
        } else {
            return $result['pu'];
        }
    }

    // PRENDRE LE BON DE COMMANDE REFERANT D'UN DETAIL FACTURE RECU
    public function getBonCommandeReference($idfacturereceived){
        $this->db->select('idboncommande');
        $this->db->from('v_general_facture_received');
        $this->db->where('idfacturereceived', $idfacturereceived);
        $query = $this->db->get();

        return $query->row_array();
    }

    // AJOUT GENERAL FACTURE RECU
    public function createMainFactureReceived($numero, $idcommande, $datefacture, $idemployee){
        $query = $this->db->query("SELECT nextval('seq_facture_received')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'FA_RE_' . $sequence_value;
        $data['idfacturereceived'] = $id;
        $data['datefacture'] = $datefacture;
        $data['numerofacture'] = $numero;
        $data['idboncommande'] = $idcommande;
        $data['idemployee'] = $idemployee;
        $data['status_facture'] = -1;

        $this->db->insert('facture_received', $data);
        return $id;
    }

    // PRENDRE LES FACTURES RECUS RECENTS
    public function getRecentFactureReceived(){
        $this->db->select('*');
        $this->db->from('v_general_facture_received');
        $this->db->order_by('datefacture', 'DESC');
        $query = $this->db->get();
        
        $data = $query->result_array();
        return $data;
    }    
}