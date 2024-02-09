<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Utilisation extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->model('back_office/dep_logistique/Station');
    }

    public function insert($data) {

        $this->db->insert('utilisation', $data);
        return $this->db->insert_id();
    }
    public function isUsed($idvoiture, $debut, $fin){
        $sql = sprintf("SELECT *
        FROM utilisation
        WHERE idvoiture = '%s'
          AND (
            (debut <= '%s' AND '%s' <= fin) OR
            ('%s' <= debut AND fin <= '%s') OR
            (debut <= '%s' AND '%s' <= fin)
          );", $idvoiture,$debut, $debut, $debut,$fin,$fin, $fin);
        $query = $this->db->query($sql);
        $result = $query->result_array();
        if(count($result)){
            return true;
        }
        return false;
}
public function getRoute($idvoiture, $date )
  {
    $sql = sprintf("SELECT sum(fin_kilometrage - debut_kilometrage)  as sum from utilisation where idvoiture ='%s'" , $idvoiture);
    $query = $this->db->query($sql);
    $result = $query->row_array();
    $carburant = $this->Station->getCarburantWithDate($idvoiture,$date);
    if(count($carburant) == 0) return 0;
    return   $carburant[count($carburant)-1]['kilometreTotal'] -$result['sum'];

  }
}