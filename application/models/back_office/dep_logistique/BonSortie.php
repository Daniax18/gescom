<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BonSortie extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->model('Back_office/achat/Materiel');
        $this->load->model('Back_office/Fournisseur_model');
    }

    // SAVE MAIN B L WITH PDF
    public function saveBonEntreeWithPdf($idbonsortie, $file, $idemployee){
        $this->db->trans_start(); // Start a transaction
        $this -> savePdfBonSortie($idbonsortie, $file);
        $this -> saveGeneralBonSortie($idbonsortie);
        $this -> makeSortieStock($idbonsortie, $idemployee);
        $this->db->trans_complete(); // Complete the transaction
    }

    // SAVE THE PDF OF THE BON DE SORTIE
    public function savePdfBonSortie($idbonsortie, $file){
        $query = sprintf("UPDATE bon_sortie SET pathjustificatif = '%s' WHERE idbonsortie = '%s'", $file, $idbonsortie);
        $sql = $this->db->query($query);
    }

    // ENREGISTRER UN BON DE SORTIE
    public function saveGeneralBonSortie($idbonsortie){
        $this -> updateStatusBonSortie($idbonsortie, 0);
    }

    // FAIRE SORTIE STOCK
    public function makeSortieStock($idbonsortie, $idemployee){
        $this->load->model('back_office/stock_option/Stock');
        $sortie = $this -> getBonSortieById($idbonsortie);
        $details = $this -> getDetailSortie($idbonsortie);
        $this->db->trans_start(); // Start a transaction
        foreach($details as $detail){
            $etat = $this -> Stock -> etat_stock_materiel($detail['idmateriel'], $sortie['datesortie']);
            $this -> Stock -> make_sortie($detail['idmateriel'], $detail['qty_leave'], $sortie['datesortie'] ,$idemployee, $etat['pu'], $sortie['iddepartement']);
        }
        $this->db->trans_complete(); // Complete the transaction
    }


    // UPDATE STATUS OF BON SORTIE
    public function updateStatusBonSortie($idbonsortie, $status){
        $query = sprintf("UPDATE bon_sortie SET status_sortie = %u WHERE idbonsortie = '%s'", $status, $idbonsortie);
        $sql = $this->db->query($query);
    }

    // PRENDRE DETAIL_BON_SORTIE
    public function getDetailSortie($idbonsortie){
        $this->db->select('*');
        $this->db->from('v_detail_sortie');
        $this->db->where('idbonsortie', $idbonsortie);
        $query = $this->db->get();
        return $query->result_array();
    }


    // DELETE CACHE OF BON SORTIE
    public function deleteCacheBonSortie(){
        $this->db->trans_start(); // Start a transaction

        $this->db->where('idbonsortie IN (SELECT idbonsortie FROM bon_sortie WHERE status_sortie = -1)', NULL, FALSE);
        $this->db->delete('detail_sortie');

        $this->db->where('status_sortie', -1);
        $this->db->delete('bon_sortie');

        $this->db->trans_complete(); // Complete the transaction
    }

    // AJOUT DETAIL BON D'ENTREE
    public function saveDetailSortie($idbonsortie, $idmateriel, $qty, $remarque){
        $sortie = $this -> getBonSortieById($idbonsortie);
        $query = $this->db->query("SELECT nextval('seq_detail_sortie')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'BS_DET_' . $sequence_value;
        $data['iddetailsortie'] = $id;
        $data['idbonsortie'] = $idbonsortie;
        $data['idmateriel'] = $idmateriel;
        $data['qty_leave'] = $qty;
        $data['remarque'] = $remarque;
        $this->load->model('back_office/stock_option/Stock');
        $etat = $this -> Stock -> etat_stock_materiel($idmateriel, $sortie['datesortie']);
        if($etat['qty'] < $qty){
            return $result = array(
                'succes' => 0,
                'materiel' => $etat['nommateriel'],
                'left' => $etat['qty']
            );
        } else {
            $this->db->insert('detail_sortie', $data);
            return $result = array(
                'succes' => 1,
                'left' => null
            );
        }
    }

    // AJOUT GENERAL BON DE SORTIE
    public function createMainBonSortie($iddepartement, $datesortie, $idemployee){
        $query = $this->db->query("SELECT nextval('seq_bon_sortie')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'BS_' . $sequence_value;
        $data['idbonsortie'] = $id;
        $data['datesortie'] = $datesortie;
        $data['iddepartement'] = $iddepartement;
        $data['idemployee'] = $idemployee;
        $data['status_sortie'] = -1;

        $this->db->insert('bon_sortie', $data);

        return $id;
    }

    // PRENDRE UN BON DE SORTIE PAR ID
    public function getBonSortieById($idbonsortie){
        $this->db->select('*');
        $this->db->from('v_general_sortie');
        $this->db->where('idbonsortie', $idbonsortie);
        $query = $this->db->get();

        return $query->row_array();
    }

    // PRENDRE LES BONS SORTIES RECENTS
    public function getRecentBonSortie(){
        $this->db->select('*');
        $this->db->from('v_general_sortie');
        $this->db->order_by('datesortie', 'DESC');
        $query = $this->db->get();
        
        $data = $query->result_array();
        
        $result = array();
        for($i = 0; $i < count($data); $i++){
            $result[$i] = $data[$i];
            $temp = $this -> get_sortie_status($data[$i]['status_sortie']);
            $result[$i]['status'] = $temp;
        }
        return $result;
    }

    // PRENDRE LE STATUS D'UN BESOIN
    public function get_sortie_status($situation){
        $donnes = array("Attente Reception", "Accuse Reception");
        $progress = (($situation + 1) / count($donnes)) * 100;
        $result = array();
        $result[] = $donnes[$situation];
        $result[] = $progress;
        return $result;
    }
}