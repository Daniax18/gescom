<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ecart extends CI_Model {
    public function __construct(){
        parent::__construct();
        
        $this->load->model('Back_office/Fournisseur_model');
    }

    // PRENDRE TOTAL DES ECARTS DE L'ENTREPRISE
    public function getTotalEcart(){
        $query = sprintf("select sum(qty_ecart * pu_materiel) as total from detail_ecart_materiel");
        $sql = $this->db->query($query);
        $temp =  $sql->row_array();
        return $temp['total'];
    }
    
    // GET INVENTAIRE VALIDATE WITH DETAILS ECART
    public function getValidateInventaire(){
        $this->db->select('*');
        $this->db->from('v_general_inventaire');
        $this->db->where('status_inventaire', 2);
        $this->db->order_by('dateinventaire', 'DESC');
        $query = $this->db->get();
        
        $data = $query->result_array();
        $result = array();
        for($i = 0; $i < count($data); $i++){
            $result[$i] = $data[$i];
            $value = $this -> sommeEcartValue($data[$i]['idinventaire']);
            $result[$i]['ecart'] = $value['total'];
            if($value['total'] < 0){
                 $result[$i]['color'] = 'red';
            }else{
                 $result[$i]['color'] = 'black';
            }
        }
        return $result;
    }

    // GET SOMME DES ECART DANS UN INVENTAIRE
    public function sommeEcartValue($idinventaire){
        $query = sprintf("select idinventaire, sum(value_ecart) as total
            from v_detail_ecart
            where idinventaire = '%s'
            group by idinventaire", $idinventaire);
        $sql = $this->db->query($query);
        $temp =  $sql->row_array();
        return $temp;
    }

    // UPDATE STATUS OF ECART BY IDINVENTAIRE
    public function updateStatusEcart($idinventaire, $status_ecart){
        $query = sprintf("UPDATE ecart SET status_ecart = %u WHERE idinventaire = '%s'", $status_ecart, $idinventaire);
        $sql = $this->db->query($query);
    }

    // UPDATE ECART DETAIL
    public function updateDetailInventaire($idmateriel, $idinventaire, $new_qty){
        $detail = $this -> getMaterielEcart($idmateriel, $idinventaire);
        $qty = $new_qty - $detail['qty_normal'];
        $query = sprintf("UPDATE detail_ecart_materiel SET qty_inventaire = %f, qty_ecart = %f WHERE iddetail_ecart = '%s'", $new_qty, $qty, $detail['iddetail_ecart']);
        $sql = $this->db->query($query);
    }

    // GET ECART PER MATERIEL
    public function getMaterielEcart($idmateriel, $idinventaire){
        $this->db->select('*');
        $this->db->from('v_detail_ecart');
        $this->db->where('idinventaire', $idinventaire);
        $this->db->where('idmateriel', $idmateriel);
        $query = $this->db->get();

        $temp =  $query->row_array();
        if($temp['qty_ecart'] < 0){
            $temp['color'] = 'red';
        } else {
            $temp['color'] = 'black';
        }
        return $temp;
    }

    // AJOUT DETAIL ECART
    public function saveDetailEcart($idecart, $idmateriel, $pu, $qty_normal, $qty_inventaire, $remarque){
        $query = $this->db->query("SELECT nextval('seq_detail_ecart')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'EC_DET_' . $sequence_value;
        $data['iddetail_ecart'] = $id;
        $data['idecart'] = $idecart;
        $data['idmateriel'] = $idmateriel;
        $data['pu_materiel'] = $pu;
        $data['qty_normal'] = $qty_normal;
        $data['qty_inventaire'] = $qty_inventaire;
        $data['qty_ecart'] = $qty_inventaire - $qty_normal;
        $data['remarque'] = $remarque;

        $this->db->insert('detail_ecart_materiel', $data);

        return $id;
    }

    // AJOUT GENERAL ECART
    public function createMainEcart($idlastinventaire, $idinventaire){
        $query = $this->db->query("SELECT nextval('seq_ecart')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'EC_' . $sequence_value;
        $data['idecart'] = $id;
        $data['idlastinventaire'] = $idlastinventaire;
        $data['idinventaire'] = $idinventaire;
        $data['status_ecart'] = 0;

        $this->db->insert('ecart', $data);

        return $id;
    }

}