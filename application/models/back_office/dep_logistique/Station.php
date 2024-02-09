<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Station extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->model('back_office/dep_finance/Reception');
    }
    public function getaLL(){
        $sql = "SELECT * FROM STATION";
        $query = $this->db->query($sql);
        $result = $query->result_array();
        return $result;
    }
    public function insert($data) {
        $this->db->insert('carburant', $data);
        return $this->db->insert_id();
    }
    public function getCarburant($idvoiture){
        $this->db->select('*');
        $this->db->from('v_carburant');
        $this->db->where('idvoiture', $idvoiture);
        $query = $this->db->get();
        $voiture = $this->Reception->getDetailEtat($idvoiture);
        $result = $query->result_array();
        $kilometre = 0;
        foreach ($result as &$res) {
            $res['prix']= $this->getPrixCarburant($res['date']);
            $res['prix'] = $res['prix']['valeur'];
            $res['prixTotal']=$res['prix']*$res['litre'];
            $res['consommation'] = $voiture[0]['consommation'];
            $res['kilometre'] = ($voiture[0]['consommation'] * 100) / $res['litre'];
            $kilometre += $res['kilometre'];
            $res['kilometreTotal'] = $kilometre;
        }
        unset($res);
        return $result;
    }
//  prendre le cotas du carburant avant une date specifique
    public function getCarburantWithDate($idvoiture,$date){
        $sql = sprintf("select * from v_carburant where idvoiture ='%s' and date <='%s'" , $idvoiture,$date);
        $query = $this->db->query($sql);
        $voiture = $this->Reception->getDetailEtat($idvoiture);
        $result = $query->result_array();
        $kilometre = 0;
        foreach ($result as &$res) {
            $res['prix']= $this->getPrixCarburant($res['date']);
            $res['prix'] = $res['prix']['valeur'];
            $res['prixTotal']=$res['prix']*$res['litre'];
            $res['consommation'] = $voiture[0]['consommation'];
            $res['kilometre'] = ($voiture[0]['consommation'] * 100) / $res['litre'];
            $kilometre += $res['kilometre'];
            $res['kilometreTotal'] = $kilometre;
        }
        unset($res);
        return $result;
    }
    public function getPrixCarburant($date){
        $sql = sprintf("SELECT * from prix_carburant where date <='%s' order by date desc limit 1" , $date);
        $query = $this->db->query($sql);
        $result = $query->row_array();
        if($result == null ){
            $sql = sprintf("SELECT * from prix_carburant  order by date desc limit 1" , $date);
            $query = $this->db->query($sql);
            $result = $query->row_array();
        }
        return $result;
    }
}