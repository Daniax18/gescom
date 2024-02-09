<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proforma_client extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->model('Back_office/achat/Materiel');
        $this->load->model('Back_office/dep_vente/Customer');
    }

    // ENREGISTER PROFORMA ENVOYE AVEC PDF
    public function saveProformaClientWithPdfSent($idproformaclient, $namefile){
        $this->db->trans_start(); // Start a transaction
        $this -> updateStatusProformaClient($idproformaclient, 1);
        $this -> saveProformaClientPdfSent($idproformaclient, $namefile);
        $this->db->trans_complete(); // Complete the transaction
    }

    // ENREGISTRER LE PROFORMA ENVOYE
    public function saveProformaClientPdfSent($idproformaclient, $namefile){
        $query = sprintf("UPDATE proforma_client SET pathjustificatif_sent = '%s' WHERE idproformaclient = '%s'", $namefile, $idproformaclient);
        $sql = $this->db->query($query);
    }

    // CALCULER LE TOTAL MONTANT D'UNE PROFORMA
    public function getTotalMontantProformaClient($idproformaclient){
        $sql = sprintf("SELECT SUM(montant_ht) as ht, SUM(montant_ttc) as ttc FROM detail_proforma_client WHERE idproformaclient = '%s'", $idproformaclient);
        $query = $this->db->query($sql);

        $result = $query->row_array();
        return $result;
    }

    // GET RESULTAT D'UN PROFORMA
    public function getResultatProforma($idproformaclient){
        $general = $this -> getProformaClientById($idproformaclient);
        $details = $this -> getDetailProformaClient($idproformaclient);
        $currentDate = date("Y-m-d");
        $futureDate = date("Y-m-d", strtotime($currentDate . " +15 days"));
        $this->load->model('Back_office/stock_option/Stock');
        $this->db->trans_start(); // Start a transaction
        $this -> updateProformaLastDay($idproformaclient, $futureDate);
        foreach($details as $detail){
            // var_dump($detail);
            $move = $this -> Stock -> can_make_sortie($detail['idmateriel'], $detail['qty_request'], $general['date_proforma_client_received']);
            // var_dump($move);
            $montant_ht = $move['unit_sell'] * $move['qty'];
            $montant_ttc = ($montant_ht * 0.2) + $montant_ht;
            $this -> updateProformaClientDetail($detail['id_detail_proforma_client'], $move['qty'], $move['unit_sell'], $montant_ht, $montant_ttc); 
        }
        $this->db->trans_complete(); // Complete the transaction
    }

    // UPDATE LAST DAY OF PROFORMA
    public function updateProformaLastDay($idproformaclient, $date){
        $query = sprintf("UPDATE proforma_client SET date_proforma_client_last  = '%s' WHERE idproformaclient = '%s'", $date, $idproformaclient);
        $sql = $this->db->query($query);
    }

    // UPDATE QTY IN STOCK, UNIT_PRICE, MONTANT_HT AND MONTANT_TTC of PROFORMA
    public function updateProformaClientDetail($id_detail_proforma_client, $qty_in_stock, $unit_price, $montant_ht, $montant_ttc){
        $query = sprintf("UPDATE detail_proforma_client SET qty_in_stock = %f, unit_price_ht = %f, montant_ht = %f, montant_ttc = %f WHERE id_detail_proforma_client = '%s'", $qty_in_stock, $unit_price, $montant_ht, $montant_ttc, $idproformaclient);
        $sql = $this->db->query($query);
    }

    // SAVE MAIN PROFORMA CLIENT WITH PDF
    public function saveProformaClientWithPdf($idproformaclient, $file){
        $this->db->trans_start(); // Start a transaction
        $this -> savePdfProformaClientReceived($idproformaclient, $file);
        $this -> updateStatusProformaClient($idproformaclient, 0);
        $this->db->trans_complete(); // Complete the transaction
    }

    // GET THE PDF FILE FROM THE CLIENT
    public function savePdfProformaClientReceived($idproformaclient, $file){
        $query = sprintf("UPDATE proforma_client SET pathjustificatif = '%s' WHERE idproformaclient = '%s'", $file, $idproformaclient);
        $sql = $this->db->query($query);
    }

    // UPDATE STATUS OF PROFORMA CLIENT
    public function updateStatusProformaClient($idproformaclient, $status){
        $query = sprintf("UPDATE proforma_client SET status_proforma_client = %u WHERE idproformaclient = '%s'", $status, $idproformaclient);
        $sql = $this->db->query($query);
    }

    // PRENDRE DETAIL PROFROMA CLIENT
    public function getDetailProformaClient($idproformaclient){
        $this->db->select('*');
        $this->db->from('v_detail_proforma_client');
        $this->db->where('idproformaclient', $idproformaclient);
        $query = $this->db->get();
        return $query->result_array();
    }

    // PRENDRE UN PROFORMA CLIENT par ID
    public function getProformaClientById($idproformaclient){
        $this->db->select('*');
        $this->db->from('v_general_proforma_client');
        $this->db->where('idproformaclient', $idproformaclient);
        $query = $this->db->get();

        return $query->row_array();
    }

    // DELETE CACHE OF PROFORMA CLIENT
    public function deleteCacheProformaClient(){
        $this->db->trans_start(); // Start a transaction

        $this->db->where('idproformaclient IN (SELECT idproformaclient FROM proforma_client WHERE status_proforma_client = -1)', NULL, FALSE);
        $this->db->delete('detail_proforma_client');

        $this->db->where('status_proforma_client', -1);
        $this->db->delete('proforma_client');

        $this->db->trans_complete(); // Complete the transaction
    }

    // AJOUT DETAIL PROFORMA CLIENT
    public function saveDetailProformaClient($idproformaclient, $idmateriel, $qty){
        $query = $this->db->query("SELECT nextval('seq_detail_proforma_client')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'PROCLI_DET' . $sequence_value;
        $data['id_detail_proforma_client'] = $id;
        $data['idproformaclient'] = $idproformaclient;
        $data['idmateriel'] = $idmateriel;
        $data['qty_request'] = $qty;

        $this->db->insert('detail_proforma_client', $data);
    }

    // AJOUT GENERAL PROFORMA CLIENT
    public function createMainProformaClient($idcustomer, $numero, $dateproforma, $idemployee){
        $query = $this->db->query("SELECT nextval('seq_proforma_client')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'PROCLI_' . $sequence_value;
        $data['idproformaclient'] = $id;
        $data['idcustomer'] = $idcustomer;
        $data['date_proforma_client_received'] = $dateproforma;
        $data['numeroproforma'] = $numero;
        $data['idemployee'] = $idemployee;
        $data['status_proforma_client'] = -1;

        $this->db->insert('proforma_client', $data);

        return $id;
    }

    // PRENDRE LES PROFORMAS DES CLIENTS RECENTS
    public function getRecentProformaClient(){
        $this->db->select('*');
        $this->db->from('v_general_proforma_client');
        $this->db->order_by('date_proforma_client_received', 'DESC');
        $query = $this->db->get();
        
        $data = $query->result_array();
        
        $result = array();
        for($i = 0; $i < count($data); $i++){
            $result[$i] = $data[$i];
            $temp = $this -> proforma_client_status($data[$i]['status_proforma_client']);
            $result[$i]['status'] = $temp;
        }
        return $result;
    }

    // STATUS BON DE LIVRAISON
    public function proforma_client_status($status){
        $donnes = array("Recu", "Reponse envoye");
        $progress = (($status + 1) / count($donnes)) * 100;
        $result = array();
        $result[] = $donnes[$status];
        $result[] = $progress;
        return $result;
    }
}