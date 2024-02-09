<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class EntretienController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('user_data');
        $departement_log =  $this->session->userdata('dep_logistique');
        if($user['iddepartement'] != $departement_log){
            redirect('back_office/LoginController/logout');
        }

        $this->load->model('back_office/dep_logistique/gestion_auto/Entretien');
    }

    public function getHistoriqueVoiture($id_voiture){
        $voiture = $this -> Entretien -> getVoitureById($id_voiture);
        $voiture['last'] = $this -> Entretien -> getLastKilometrageSaved($id_voiture);
        $data['voiture'] = $voiture;
        $data['historiques'] = $this -> Entretien -> getHistoriqueActiviteOfVoiture($id_voiture);
        $data['content'] = 'back_office/dep_logistique/gestion_auto/historique'; 
        $this->load->view('back_office/main',$data);
    }

    // PRENDRE DETAIL CATEGORIE D'UNE VOITURE
    public function getDetailCategorieVoiture($id_voiture, $iddetail){
        $voiture = $this -> Entretien -> getVoitureById($id_voiture);
        $voiture['last'] = $this -> Entretien -> getLastKilometrageSaved($id_voiture);
        $data['voiture'] = $voiture;
        $data['entretiens'] = $this -> Entretien -> getAllDetailCategorieByVoiture($id_voiture, $iddetail);
        $data['content'] = 'back_office/dep_logistique/gestion_auto/detail_entretien'; 
        $this->load->view('back_office/main',$data);
    }


    // SAVE AN ENTRETIEN
    public function saveEntretien(){
        $id_voiture = $this -> input -> post('id_voiture');
        $iddetail = $this -> input -> post('iddetail');
        $id_entretien = $this -> input -> post('id_entretien');
        $kilometrage = $this -> input -> post('kilometrage');
        $prix = $this -> input -> post('prix');

        $status = $this -> Entretien -> saveEntretienVoiture($id_voiture, $iddetail, $id_entretien, $kilometrage, $prix);
        redirect(base_url().'back_office/dep_logistique/EntretienController/getEntetienVoiture?id_voiture='.$id_voiture.'&&status='.$status);
    }
    


    // GET LA LISTE DES DETAILS PAR CATEGORIES
    public function getDetailsByCategorie(){
        $idcategorie = $this -> input -> get('id');
        header('Content-Type: application/json');
        echo json_encode($this -> Entretien -> getDetailsByCategorie($idcategorie));
    }

    // DETAIL REPARATION D'UNE VOITURE
    public function getEntetienVoiture(){
        $id_voiture = $this -> input -> get('id_voiture');
        $status = $this -> input -> get('status');
        if($status != null && $status == 1){
            $data['status'] = 'Erreur d\'insertion d\'entretien';
        }
        $voiture = $this -> Entretien -> getVoitureById($id_voiture);
        $voiture['last'] = $this -> Entretien -> getLastKilometrageSaved($id_voiture);
        $data['voiture'] = $voiture;
        $data['type_entretien'] = $this -> Entretien -> getTypeEntretien();
        $data['categories'] = $this -> Entretien -> getCategories();
        $data['entretiens'] = $this -> Entretien -> getEntretiensByVoiture($id_voiture);
        $data['content'] = 'back_office/dep_logistique/gestion_auto/entretien_auto'; 
        $this->load->view('back_office/main',$data);
    }
    
    // FABRICATION DE LA FACTURE PDF
    public function getControleKilometre(){
        $data['controles'] = $this -> Entretien -> getControleKilometrage();
        $data['content'] = 'back_office/dep_logistique/gestion_auto/controle_km';        // Its a page
        $this->load->view('back_office/main',$data);
    }
}
