<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reception extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->model('back_office/dep_logistique/Utilisation');
    }
    public function getPV(){
        $sql = "SELECT * FROM v_voiture";
        date_default_timezone_set('Europe/Moscow');
        $date = $utilisation1 =new DateTime();
        $query = $this->db->query($sql);
        $result = $query->result_array();
        foreach ($result as &$res) {
            $res['reste_kilometre'] = $this->Utilisation->getRoute($res['idvoiture'], $date->format('Y-m-d H:i:s') );
        }
        return $result;
    }
    public function getmodele(){
        $sql = "SELECT * FROM modele";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
    public function getFinKilometrage($idvoiture){
        $sql = sprintf("select coalesce( fin_kilometrage,0) as km from utilisation where idvoiture='%s' order by debut desc limit 1", $idvoiture);
        $query = $this->db->query($sql);
        $result = $query->row_array();
        return $result['km'];
    }
    public function getdetail(){
        $sql = "SELECT * FROM v_detail_categorie";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
    public function insertVoiture($data) {

        $this->db->insert('voiture', $data);
        return $this->db->insert_id();
    }
    public function insertEtat($data) {

        $this->db->insert('etat', $data);
        return $this->db->insert_id();
    }
    public function getDetailEtat($idvoiture){
        $this->db->select('*');
        $this->db->from('v_etat_voiture');
        $this->db->where('idvoiture', $idvoiture);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function voiture($idvoiture){
        $this->db->select('*');
        $this->db->from('voiture');
        $this->db->where('idvoiture', $idvoiture);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function v_voiture($idvoiture){
        $this->db->select('*');
        $this->db->from('v_voiture');
        $this->db->where('idvoiture', $idvoiture);
        $query = $this->db->get();
        return $query->row_array();
    }
// donne les caracteistique en considerant les coefficient
    public function getDetailEtatWithPrecision($idvoiture){
        $this->db->select('*');
        $this->db->from('v_etat_voiture');
        $this->db->where('idvoiture', $idvoiture);
        $query = $this->db->get();
        $result =  $query->result_array();
        $coefficient = 0;
        $sum =0;
        
        foreach ($result as &$res) {
            $res['valeurCoefficent']= $res['coefficient']*$res['valeur'];
            $coefficient = $coefficient + $res['coefficient'];
            $sum = $sum + $res['valeurCoefficent'];
        }
        
        unset($res);
        if($coefficient >0){
            $result['note'] = $sum/ $coefficient;
        }else{
            $result['note'] =0;
        }
        if($result['note'] > 0 && $result['note'] <= 3){
            $result['etat'] = "Inutilisable";
        }
        if($result['note'] > 2 && $result['note'] <= 5){
            $result['etat'] = "Besoin de maintenance immediat";
        }
        if($result['note'] > 5 && $result['note'] <= 8){
            $result['etat'] = "Bon etat";
        }       
         if($result['note'] > 8 && $result['note'] < 11){
            $result['etat'] = "Tres bon etat";
        }
       
      $result['main_voiture'] = $this-> v_voiture($idvoiture);
        return $result;
    }

    public function getDetailEtatWithPrecisionGlobal(){
        $this->db->select('*');
        $this->db->from('v_voiture');
        $query = $this->db->get();
        $result =  $query->result_array();
        $coefficient = 0;
        $sum =0;
        $resultGlobal = array();
        foreach ($result as $res) {
           $resultGlobal[] = $this->getDetailEtatWithPrecision($res['idvoiture']);
        }
        return $resultGlobal;
    }
    public function getAllEmployee(){
        $this->db->select('*');
        $this->db->from('employee');
        $query = $this->db->get();

        return $query->result_array();
    }


}
