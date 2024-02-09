<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BonLivraison extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->model('Back_office/achat/Materiel');
        $this->load->model('Back_office/Fournisseur_model');
    }

    // SAVE MAIN B L WITH PDF
    public function saveLivraisonWithPdf($idlivraison, $file){
        $this->db->trans_start(); // Start a transaction
        $this -> savePdfLivraison($idlivraison, $file);
        $this -> saveGeneralLivraison($idlivraison);
        $this->db->trans_complete(); // Complete the transaction
    }

    // ENREGISTRER UN BON LIBVARISON
    public function saveGeneralLivraison($idlivraison){
        $this -> updateStatusBonLivraison($idlivraison, 0);
    }

    // GET THE PDF FILE
    public function savePdfLivraison($idlivraison, $file){
        $query = sprintf("UPDATE bon_livraison SET pathjustificatif = '%s' WHERE idbonlivraison = '%s'", $file, $idlivraison);
        $sql = $this->db->query($query);
    }

    // UPDATE STATUS OF LIVRAISON
    public function updateStatusBonLivraison($idlivraison, $status){
        $query = sprintf("UPDATE bon_livraison SET status_livraison = %u WHERE idbonlivraison = '%s'", $status, $idlivraison);
        $sql = $this->db->query($query);
    }

    // PRENDRE DETAIL_BON_LIVRAISON
    public function getDetailLivraison($idlivraison){
        $this->db->select('*');
        $this->db->from('v_detail_livraison');
        $this->db->where('idbonlivraison', $idlivraison);
        $query = $this->db->get();
        return $query->result_array();
    }

    // PRENDRE UN B.L par ID
    public function getBonLivraisonById($idlivraison){
        $this->db->select('*');
        $this->db->from('v_general_livraison');
        $this->db->where('idbonlivraison', $idlivraison);
        $query = $this->db->get();

        return $query->row_array();
    }

    // DELETE CACHE OF BON LIVRAISON
    public function deleteCacheLivraison(){
        $this->db->trans_start(); // Start a transaction

        $this->db->where('idbonlivraison IN (SELECT idbonlivraison FROM bon_livraison WHERE status_livraison = -1)', NULL, FALSE);
        $this->db->delete('detail_livraison');

        $this->db->where('status_livraison', -1);
        $this->db->delete('bon_livraison');

        $this->db->trans_complete(); // Complete the transaction
    }

    // AJOUT DETAIL BON LIVRAISON
    public function saveDetailLivraison($idlivraison, $idmateriel, $qty, $remarque){
        $query = $this->db->query("SELECT nextval('seq_detail_livraison')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'BL_DET_' . $sequence_value;
        $data['iddetaillivraison'] = $id;
        $data['idbonlivraison'] = $idlivraison;
        $data['idmateriel'] = $idmateriel;
        $data['qty_received'] = $qty;
        $data['remarque'] = $remarque;

        $this->db->insert('detail_livraison', $data);
    }

    // AJOUT GENERAL BON LIVRAISON
    public function createMainLivraison($numero, $idcommande, $datelivraison, $idemployee){
        $query = $this->db->query("SELECT nextval('seq_bon_livraison')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'BL_' . $sequence_value;
        $data['idbonlivraison'] = $id;
        $data['datelivraison'] = $datelivraison;
        $data['numerolivraison'] = $numero;
        $data['idboncommande'] = $idcommande;
        $data['idemployee'] = $idemployee;
        $data['status_livraison'] = -1;

        $this->db->insert('bon_livraison', $data);

        return $id;
    }

    // PRENDRE LES BONS DE LIVRAISONS RECENTS
    public function getRecentBonLivraison(){
        $this->db->select('*');
        $this->db->from('v_general_livraison');
        $this->db->order_by('datelivraison', 'DESC');
        $query = $this->db->get();
        
        $data = $query->result_array();
        
        $result = array();
        for($i = 0; $i < count($data); $i++){
            $result[$i] = $data[$i];
            $temp = $this -> bon_livraison_status($data[$i]['status_livraison']);
            $result[$i]['status'] = $temp;
        }
        return $result;
    }

    // STATUS BON DE LIVRAISON
    public function bon_livraison_status($status){
        $donnes = array("Recu", "Rattache B.R");
        $progress = (($status + 1) / count($donnes)) * 100;
        $result = array();
        $result[] = $donnes[$status];
        $result[] = $progress;
        return $result;
    }
    
}