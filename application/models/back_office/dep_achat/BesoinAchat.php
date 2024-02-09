<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BesoinAchat extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('back_office/achat/Besoin');
    }

    // UPDATE STATUS BESOIN GLOBAL
    public function updateGlobal($idglobal, $status){
        $query = sprintf("UPDATE global SET status = %u WHERE idglobal = '%s'", $status, $idglobal);
        $sql = $this->db->query($query);
    }

    // DEGROUPER UN BESOIN GLOBAL
    public function degroupGlobal($idglobal){
        $this->db->trans_start(); // Start a transaction

        $this -> updateStatusBesoins($idglobal, 1);

        $this->db->where('idglobal', $idglobal);
        $this->db->delete('detailglobal');

        $this->db->where('idglobal', $idglobal);
        $this->db->delete('global');  

        $this->db->trans_complete(); // Complete the transaction
    }

    
    // UPDATE LES BESOINS D'UN GLOBAL
    public function updateStatusBesoins($idglobal, $status){
        $besoins = $this -> BesoinAchat -> besoinsOfGlobal($idglobal);
        $this->load->model('back_office/achat/Besoin');
        $this->db->trans_start();

        foreach($besoins as $besoin){
            $this -> Besoin -> updateBesoinStatus($besoin['idbesoin'], $status);
        }

        $this->db->trans_complete(); 
    }

    // GROUPER LES MATERIELS D'UN BESOIN GLOBAL
    public function getDetailGlobalMateriel($idglobal){
        $query = sprintf("select v_materiel_detail.*, t1.total
            from
            (select t.idmateriel, sum(qte) as total
            from (select v_besoin_detail.*, detailglobal.idglobal
            from detailglobal
            inner join v_besoin_detail on v_besoin_detail.idbesoin = detailglobal.idbesoin
            where detailglobal.idglobal = '%s') as t
            group by t.idmateriel) as t1
            inner join v_materiel_detail on v_materiel_detail.idmateriel = t1.idmateriel", $idglobal);
        $sql = $this->db->query($query);
        $count = 0;

        foreach ($sql-> result_array() as $row){
            $count++;
            $result[] = $row; 
        }
        if($count == 0) return 0;
        return $result;
    }

    // PRENDRE LA LISTE DES BESOINS OU LES PROFORMAS SONT DEJA ENVOYE (STATUS 1)
    public function getBesoinsHasProformas(){
        $this->db->select('*');
        $this->db->from('v_global_general');
        $this->db->where('status >=', 0);
        $this->db->order_by('date', 'DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    // PRENDRE LA LISTE DES BESOINS
    public function getBesoinsGlobaux(){
        $query = $this->db->get('v_global_general');
        return $query->result_array();
    }

    // GROUPER LES BESOINS valide par chef de departement -> GLOBAL
    public function groupeBesoinsToGlobal($idemploye){
        $this->db->trans_start();

        $idglobal = $this -> createGlobalBesoins($idemploye); // inserer nouvelle
        $besoins = $this -> besoins();             

        foreach($besoins as $besoin){
            $this -> insertDetailGlobal($idglobal, $besoin['idbesoin']);
        }
        $this -> updateStatusBesoins($idglobal, 2);
        $this->db->trans_complete();
        return $idglobal;
    }

    // INSERT DETAILGLOBAL
    public function insertDetailGlobal($idGlobal, $idbesoin){
        $query = $this->db->query("SELECT nextval('seq_detail_global')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'GLO_DET_' . $sequence_value;

        $data['iddetailglobal'] = $id;
        $data['idglobal'] = $idGlobal;
        $data['idbesoin'] = $idbesoin;

        $this->db->insert('detailglobal', $data);
        return $id;
    }

    // CREATION D'UN BESOIN GLOBAL
    public function createGlobalBesoins($idemploye){
        $query = $this->db->query("SELECT nextval('seq_global')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'GLO_' . $sequence_value;

        $data['idglobal'] = $id;
        $data['date'] = date('Y-m-d');
        $data['idemployee'] = $idemploye;
        $data['status'] = -1;

        $this->db->insert('global', $data);
        return $id;
    }

    // PRENDRE LA LISTE DE TOUS LES DEMANDES DE TOUS DEPARTEMENT
    public function besoins() {
       
        $this->db->select('*');
        $this->db->from('v_besoin_general');
        $this->db->where('situation', 1);   // Situation valider par 
        $query = $this->db->get();

        $data = $query->result_array();
        $result = array();
        for($i = 0; $i < count($data); $i++){
            $result[$i] = $data[$i];
            $temp = $this -> Besoin -> my_status($data[$i]['situation']);
            $result[$i]['status'] = $temp;
        }
        return $result;
    }

    // PRENDRE UN BESOIN SPECIFIC PAR ID
    public function besoinGeneralById($idbesoin){
        $this->db->select('*');
        $this->db->from('v_besoin_general');
        $this->db->where('idbesoin', $idbesoin);
        $query = $this->db->get();

        return $query->row_array();
    }

    // PRENDRE UN BESOIN GLOBAL PAR SON ID
    public function globalById($idglobal){
        $this->db->select('*');
        $this->db->from('v_global_general');
        $this->db->where('idglobal', $idglobal);
        $query = $this->db->get();

        return $query->row_array();
    }

    // PRENDRE LES GLOBALS FILLES
    public function besoinsOfGlobal($idglobal){
        $this->db->select('*');
        $this->db->from('detailglobal');
        $this->db->where('idglobal', $idglobal);
        $query = $this->db->get();

        return $query->result_array();
    }
}
