<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProformaReceived_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getProformaById($id) {
        $query = $this->db->get_where('v_proforma_detail', array('idproforma' => $id));
        return $query->row_array();
    }
    // PRENDRE LE STATUS D'UN BESOIN
    public function my_status($situation){
        $donnes = array("Cree", "Sent", "Received");
        $progress = (($situation + 1) / count($donnes)) * 100;
        $result = array();
        $result[] = $donnes[$situation];
        $result[] = $progress;
        return $result;
    }

    // PRENDRE TOUS LES PROFORMAS
    public function get_all_proformas() {
        $this->db->select('*');
        $this->db->from('v_proformafournisseur');
        $this->db->where('status >', 0);
        $query = $this->db->get();

        $data = $query->result_array();
        
        $result = array();
        for($i = 0; $i < count($data); $i++){
            $result[$i] = $data[$i];
            $result[$i]['status'] = $this -> my_status($data[$i]['status']);
        }
        return $result;
    } 
    public function getProformaDetail($idProforma){
        $this->db->select('*');
        $this->db->from('v_proformacomplete');
        $this->db->where('idproforma', $idProforma);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getupdate($idProforma){
        $this->load->model('back_office/dep_achat/BesoinAchat');
        $proforma = $this -> getProformaById($idProforma);
        $this -> BesoinAchat -> updateStatusBesoins($proforma['idglobal'], 5);
        $this->updateProformaStatus($idProforma,2);
    }
    public function updateDetailProforma($id, $qty,$pu){
        $data['qte'] = $qty;
        $data['pu'] = $pu;
        $this->db->update('detailproforma', $data, array('iddetail' => $id));
    }
    public function deleteDetailProforma($id){
        $this->db->delete('detailproforma', array('iddetail' => $id));
    }
    public function updateProformaStatus($idproforma, $status) {
        $query = sprintf("UPDATE proforma SET status = %u  , dateproformareceived = now() WHERE idproforma = '%s'", $status, $idproforma);
        $sql = $this->db->query($query);
    }

}
?>
