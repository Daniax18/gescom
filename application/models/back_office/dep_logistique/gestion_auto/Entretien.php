
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entretien extends CI_Model {
    public function __construct(){
        parent::__construct();
    }


    // PRENDRE LES HISTORIQUE D'ACTIVITE D'UNE VOITURE
    public function getHistoriqueActiviteOfVoiture($id_voiture){
        $this->db->select('*');
        $this->db->from('v_historique_activite');
        $this->db->where('idvoiture', $id_voiture);
        $query = $this->db->get();
        
        $data = $query->result_array();
        return $data;
    }

    // PRENDRE LES DETEAILS D'ENTRETIENS D'UN DETAIL CATEGORIE D'UNE VOITURE
    public function getAllDetailCategorieByVoiture($id_voiture, $iddetail_categorie){
        $this->db->select('*');
        $this->db->from('v_detail_entretien');
        $this->db->where('idvoiture', $id_voiture);
        $this->db->where('iddetail_categorie', $iddetail_categorie);
        $this->db->order_by('date_entretien', 'DESC');
        $query = $this->db->get();
        
        $data = $query->result_array();
        return $data;
    }

    // PRENDRE LES DETAILS D'ENTRETIENS D'UNE VOITURE
    public function getEntretiensByVoiture($id_voiture){
        $this->db->select('*');
        $this->db->from('v_detail_last_entretien');
        $this->db->where('idvoiture', $id_voiture);
        $query = $this->db->get();
        
        $data = $query->result_array();
        return $data;
    }

    // SAVE AN ENTRETIEN OF VOITURE
    public function saveEntretienVoiture($id_voiture, $iddetail_categorie, $id_type_entretien, $kilometrage, $price){

        $last_kilometer = $this -> getLastKilometrageSaved($id_voiture);
        if($last_kilometer > $kilometrage) return 1;

        $query = $this->db->query("SELECT nextval('seq_entretien')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'ENTRETIEN_' . $sequence_value;

        $data['id_entretien_voiture'] = $id;
        $data['idvoiture'] = $id_voiture;
        $data['iddetail_categorie'] = $iddetail_categorie;
        $data['kilometrage'] = $kilometrage;
        $data['next_controle'] = $this -> getNextKilometreChecking($kilometrage, $iddetail_categorie);
        $data['id_type_entretien'] = $id_type_entretien;
        $data['prix_entretien'] = $price;
        $count_reparation = $this -> getNombreReparationVoiture($id_voiture, $iddetail_categorie);
        
        $newEtat = 8 - ($count_reparation / 10);
        // echo 'count is ' . $newEtat;
        $this->db->trans_start(); // Start a transaction
            $this->db->insert('entretien_voiture', $data);
            $this -> changeEtatDetailCategorieOfVoiture($id_voiture, $iddetail_categorie, $newEtat);     
        $this->db->trans_complete(); // Complete the transaction

        
        return 0;
    }

    // CHANGE THE ETAT OF VOITURE
    public function changeEtatDetailCategorieOfVoiture($id_voiture, $iddetail_categorie, $newValue){
        $query = sprintf("UPDATE etat SET valeur = %g WHERE idvoiture = '%s' AND iddetail_categorie = '%s' ", $newValue, $id_voiture, $iddetail_categorie);
        echo $query;
        $sql = $this->db->query($query);
    }

    // GET THE ETAT OF THE VOITURE BY DETAIL CATEGORIES
    public function getEtatOfVoitureByDetailCategorie($id_voiture, $iddetail_categorie){
        $this->db->select('*');
        $this->db->from('etat');
        $this->db->where('idvoiture', $id_voiture);
        $this->db->where('iddetail_categorie', $iddetail_categorie);
        $query = $this->db->get();

        return $query->row_array();
    }

    // NOMBRE DE REPARATION D'UNE CATEGORIES
    public function getNombreReparationVoiture($id_voiture, $iddetail_categorie){
        $this->db->select('COUNT(idvoiture) as total');
        $this->db->from('entretien_voiture');
        $this->db->where('idvoiture', $id_voiture);
        $this->db->where('iddetail_categorie', $iddetail_categorie);
        $this->db->where('id_type_entretien', 'ENTR_1');

        $query = $this->db->get();
        $result = $query->row_array();
        $totalCount = $result['total'];
        return $totalCount;
    }

    // CALCULATE NEXT CONTROLE BY DETAIL CATEGORIES
    public function getNextKilometreChecking($kilometrage, $iddetail_categorie){
        $new_duration = $this -> getControleByDetailCategorie($iddetail_categorie);
        return $kilometrage + $new_duration['nombre_km'];
    }

    // Avoir le controle kilometrage de chaque detail de categories
    public function getControleByDetailCategorie($iddetail_categorie){
        $this->db->select('*');
        $this->db->from('controle_km');
        $this->db->where('iddetail_categorie', $iddetail_categorie);
        $query = $this->db->get();

        return $query->row_array();
    }

    // PRENDRE LES DETAILS D'ENTRETIEN PAR CATEGORIE
    public function getDetailsByCategorie($id_categorie){
        $this->db->select('*');
        $this->db->from('v_detail_categorie');
        $this->db->where('idcategorie', $id_categorie);
        $query = $this->db->get();
        
        $data = $query->result_array();
        return $data;
    }

    // PRENDRE LES DIFFERENTS CATEGORIES
    public function getCategories(){
        $this->db->select('*');
        $this->db->from('categorie');
        $query = $this->db->get();
        
        $data = $query->result_array();
        return $data;
    }

    // PRENDRE LES TYPES D'ENTRETIEN
    public function getTypeEntretien(){
        $this->db->select('*');
        $this->db->from('type_entretien');
        $query = $this->db->get();
        
        $data = $query->result_array();
        return $data;
    }

    // DETAIL D'UNE VOITURE BY ID
    public function getVoitureById($id_voiture){
        $this->db->select('*');
        $this->db->from('v_voiture');
        $this->db->where('idvoiture', $id_voiture);
        $query = $this->db->get();

        return $query->row_array();
    }

    // PRENDRE LE DERNIER KILOMETRAGE DE LA VOITURE
    public function getLastKilometrageSaved($id_voiture){
        $this->db->select('*');
        $this->db->from('utilisation');
        $this->db->where('idvoiture', $id_voiture);
        $this->db->order_by('fin_kilometrage', 'DESC'); // Assuming there's a 'date' field to determine the latest record
        $this->db->limit(1); // Limiting the result to 1 record
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $data = $query->row_array();;
            return $data['fin_kilometrage'];
        } else {
            $this->db->select('*');
            $this->db->from('voiture');
            $this->db->where('idvoiture', $id_voiture);
            $query = $this->db->get();
            $data = $query->row_array();;
            return $data['kilometrage'];
        }
    }

    // PRENDRE LES REGLES DE GESTION DE CONTROLE
    public function getControleKilometrage(){
        $this->db->select('*');
        $this->db->from('v_controle_kilometre');
        $query = $this->db->get();
        
        $data = $query->result_array();
        return $data;
    }
}