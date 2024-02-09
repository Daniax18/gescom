<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inventaire extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->model('Back_office/achat/Materiel');
        $this->load->model('Back_office/Fournisseur_model');
        $this->load->model('Back_office/stock_option/Ecart');
    }


    // UPDATE STATUS OF BON SORTIE
    public function updateStatusBonSortie($idbonsortie, $status){
        $query = sprintf("UPDATE bon_sortie SET status_sortie = %u WHERE idbonsortie = '%s'", $status, $idbonsortie);
        $sql = $this->db->query($query);
    }


    
    // SAVE GENERAL INVENTAIRE WITH DETAIL_INVENTAIRE
    public function saveGeneralInventaire($dateinventaire, $namefile, $idemployee){
        $result = 0;
        $this->db->trans_start(); // Start a transaction
        $inventaire = $this -> createMainInventaire($dateinventaire, $idemployee, $namefile);
        $result = $this -> saveDetailInventaireByCsv($inventaire['idinventaire'], $inventaire['idecart'], $dateinventaire);
        $this->db->trans_complete(); // Complete the transaction

        return $inventaire['idinventaire'];
    }
    
    // UPDATE STATUS OF INVENTAIRE
    public function updateStatusInventaire($idinventaire, $status_inventaire){
        $query = sprintf("UPDATE inventaire SET status_inventaire = %u WHERE idinventaire = '%s'", $status_inventaire, $idinventaire);
        $sql = $this->db->query($query);
    }

    // MODIFIRE DETAIL INVENTAIRE AVEC ECART

    // MODIFIER DETAIL D'INVENTAIRE
    public function updateDetailInventaire($iddetail, $qty, $remarque){
        $query = sprintf("UPDATE detail_inventaire SET qty_inventaire = %f, remarque = '%s' WHERE iddetail_inventaire = '%s'", $qty, $remarque, $iddetail);
        // echo $query;
        $sql = $this->db->query($query);
    }

    // SAVE DETAIL OF INVENTAIRE BY CSV
    public function saveDetailInventaireByCsv($idinventaire, $idecart, $dateinventaire){
        $csvdata = $this -> getDataCsv($idinventaire);
        // var_dump($csvdata);
        $index = 0;

        try{
            $this->db->trans_start(); // Start a transaction
            foreach($csvdata as $csv){
                $index++;
                $this -> saveDetailInventaire($idinventaire, $idecart, $csv[0], $csv[2], $csv[3], $dateinventaire);
            }
            $this->db->trans_complete(); // Complete the transaction
            $index = 0;
            return $index;
        }catch (Exception $e) {
            $this->db->trans_rollback(); // Annulation de la transaction en cas d'exception
            return $index;
        }
    }

    // SAVE DETAIL INVENTAIRE
    public function saveDetailInventaire($idinventaire, $idecart, $idmateriel, $qty, $remarque, $dateinventaire){
        $query = $this->db->query("SELECT nextval('seq_detail_inventaire')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'INV_DET_' . $sequence_value;
        $data['iddetail_inventaire'] = $id;
        $data['idinventaire'] = $idinventaire;
        $data['idmateriel'] = $idmateriel;
        $data['qty_inventaire'] = $qty;
        $data['remarque'] = $remarque;
        $this->load->model('Back_office/stock_option/Stock');
        $etat = $this -> Stock -> etat_stock_materiel($idmateriel, $dateinventaire);    // Pour prendre le PU
        $data['pu_materiel'] = $etat['pu'];
        // $ecart = $qty - $etat['qty'];       // Stock digital - stock physique -->> Normalement tokony 0

        try{
            $this->db->trans_start(); // Start a transaction

            $this->db->insert('detail_inventaire', $data);
            $this -> Ecart -> saveDetailEcart($idecart, $idmateriel, $etat['pu'], $etat['qty'], $qty, '');      // REMARQUE MBOLA TSY MISY

            $this->db->trans_complete(); // Complete the transaction
        }catch (PDOException  $e) {
            $this->db->trans_rollback(); // Annulation de la transaction en cas d'exception
        }
    }

    // GET DATA FROM CSV
    public function getDataCsv($idinventaire){
        $inventaire = $this -> getInventaireById($idinventaire);
        var_dump($inventaire);
        $filename = "assets/data_company/inventaire/" . $inventaire['pathcsv'];
        $result = array();

        if (($handle = fopen($filename, 'r')) !== false) {
            $firstRow = true;
            // Output one line until end-of-file
            while (($data = fgetcsv($handle, 1000, ';')) !== false) {
                // $data is an array containing the values read from the CSV
                if ($firstRow) {
                    $firstRow = false;
                    continue; // Skip the first row
                } else{
                    $result[] = $data;
                }
            }
            fclose($handle);
        }
        
        return $result;
    }

    // AJOUT GENERAL INVENTAIRE
    public function createMainInventaire($dateinventaire, $idemployee, $namefile){

        $query = $this->db->query("SELECT nextval('seq_inventaire')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'INV_' . $sequence_value;
        $data['idinventaire'] = $id;
        $data['dateinventaire'] = $dateinventaire;
        $data['idemployee'] = $idemployee;
        $data['pathcsv'] = $namefile;
        $data['status_inventaire'] = 0;

        $idecart = "";
        $previous_inventaire = $this -> getPreviousInventaire($dateinventaire);

        $this->db->trans_start(); // Start a transaction

        $this->db->insert('inventaire', $data);
        if($previous_inventaire != null){
            $idecart = $this -> Ecart -> createMainEcart($previous_inventaire['idinventaire'], $id);
        }

        $this->db->trans_complete(); // Complete the transaction

        return array(
            'idecart' => $idecart,
            'idinventaire' => $id
        );
    }

    // AVOIR LE DETAIL D'UN INVENTAIRE
    public function getDetailInventaire($idinventaire){
        $this->db->select('*');
        $this->db->from('v_detail_inventaire');
        $this->db->where('idinventaire', $idinventaire);
        $query = $this->db->get();
        return $query->result_array();
    }

    // PRENDRE UN INVENTAIRE PAR ID
    public function getInventaireById($idinventaire){
        $this->db->select('*');
        $this->db->from('v_general_inventaire');
        $this->db->where('idinventaire', $idinventaire);
        $query = $this->db->get();

        $temp =  $query->row_array();
        $temp['status'] = $this -> get_inventaire_status($temp['status_inventaire']);
        $value_ecart =  $this -> Ecart -> sommeEcartValue($idinventaire);
        $temp['valeurEcart'] = $value_ecart['total'];
        if($value_ecart['total'] < 0){
            $temp['color'] = 'red';
        } else {
            $temp['color'] = 'black';
        }
        return $temp;
    }

    // PRENDRE LES INVENTAIRE RECENTS
    public function getRecentInventaire(){
        $this->db->select('*');
        $this->db->from('v_general_inventaire');
        $this->db->order_by('dateinventaire', 'DESC');
        $query = $this->db->get();
        
        $data = $query->result_array();
        
        $result = array();
        for($i = 0; $i < count($data); $i++){
            $result[$i] = $data[$i];
            $temp = $this -> get_inventaire_status($data[$i]['status_inventaire']);
            $result[$i]['status'] = $temp;
        }
        return $result;
    }

    // PRENDRE LE STATUS D'UN INVENTAIRE
    public function get_inventaire_status($situation){
        $donnes = array("Brouillon", "Attente validation Chef", "Valider");
        $progress = (($situation + 1) / count($donnes)) * 100;
        $result = array();
        $result[] = $donnes[$situation];
        $result[] = $progress;
        return $result;
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