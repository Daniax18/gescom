<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('BaseSessionController.php');
class BesoinController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
		$this->load->model('back_office/achat/Materiel');
        $this->load->model('back_office/achat/Besoin');
    }

     // MAKE A RECEPTION
     public function makeReceptionMateriel(){
        $idbonsortie = $this -> input -> post('idbonsortie');
        $this -> Besoin -> makeReceptionMateriel($idbonsortie);
        redirect(base_url().'back_office/BesoinController/getMaterielsReceived');
    }
    
    // GET THE MATERIELS RECU
    public function getMaterielsReceived(){
        $this->load->model('back_office/dep_logistique/BonSortie');
        $user = $this->session->userdata('user_data');
        $data['received'] = $this -> Besoin -> getMaterielsReceived($user['iddepartement']);
        $data['content'] = 'back_office/standart/liste_materiel_get';
        $this->load->view('back_office/main',$data);
    }


    // LISTE DES BESOINS
    public function getBesoinsCtrl(){
        $this -> Besoin -> deleteUnsavedBesoin();
        $user = $this->session->userdata('user_data');

        $data['besoins'] = $this -> Besoin -> besoins($user['iddepartement']);
        $data['content'] = 'back_office/achat/liste_demandes';
        $this->load->view('back_office/main',$data);
    }

    // ENREGISTRER UN BESOIN
    public function saveBesoinCtrl(){
        $idbesoin = $this->input->post('idbesoin');
        $this -> Besoin -> saveBesoin($idbesoin);
        redirect(base_url().'back_office/BesoinController/getBesoinsCtrl');
    }

    // CREER EN PREMIER UN BESOIN
	public function createBesoinCtrl(){
        $this -> Besoin -> deleteUnsavedBesoin();

        $user = $this->session->userdata('user_data');
        $iddepartement = $user['iddepartement'];
        $idemploye = $user['idemployee'];
        
        $idBesoin = $this -> Besoin -> createBesoin($iddepartement,  $idemploye);
        $data['idBesoin'] = $idBesoin;
        redirect(base_url().'back_office/BesoinController/listeDetailBesoinCtrl/'.$idBesoin);
	}

    // LISTE DES MATERIELS POUR UN BESOIN SPECIFIC
    public function listeDetailBesoinCtrl($idbesoin){
        $data['detail_besoins'] = $this -> Besoin -> getBesoinDetail($idbesoin);
        $data['content'] = 'back_office/achat/demande_achat';
        $data['materiels'] = $this -> Materiel -> materiels();
        $data['idbesoin'] = $idbesoin;
		$this->load->view('back_office/main',$data);
    }

    // AJOUTER UN MATERIEL DANS UN BESOIN
    public function addDetailBesoinCtrl(){
        $idbesoin = $this->input->post('idbesoin');
        $idmaterial = $this->input->post('idmateriel');
        $qty = $this->input->post('quantite');

        $this -> Besoin -> addDetailBesoin($idbesoin, $idmaterial, $qty);
        redirect(base_url().'back_office/BesoinController/listeDetailBesoinCtrl/'.$idbesoin);
    }

    // VALIDATION CHEF UN BESOIN
    public function validBesoinCtrl(){
        $idbesoin = $this->input->post('idbesoin');
        $this -> Besoin -> updateBesoinStatus($idbesoin, 1);
        redirect(base_url().'back_office/BesoinController/getBesoinsCtrl');
    }
    // VALIDATION CHEF UN BESOIN
    public function unvalidBesoinCtrl(){
        $idbesoin = $this->input->post('idbesoin');
        $this -> Besoin -> updateBesoinStatus($idbesoin, 0);
        redirect(base_url().'back_office/BesoinController/getBesoinsCtrl');
    }

    // AJOUTER UN MATERIEL DANS UN BESOIN
    public function addDetailBesoinDCCtrl(){
        $idbesoin = $this->input->post('idbesoin');
        $status = $this->input->post('status');
        $idmaterial = $this->input->post('idmateriel');
        $qty = $this->input->post('quantite');

        $this -> Besoin -> addDetailBesoin($idbesoin, $idmaterial, $qty);
        redirect(base_url().'back_office/BesoinController/listeDetailCtrl/'.$status.'/'.$idbesoin);
    }

    // UPDATING
    public function updateDetailBesoinCtrl(){
        $idbesoin = $this->input->post('idbesoin');
        $status = $this->input->post('status');
        $id = $this->input->post('iddetail');
        $qty = $this->input->post('quantite');
        $this -> Besoin -> updateDetailBesoin($id, $qty);
        redirect(base_url().'back_office/BesoinController/listeDetailCtrl/'.$status.'/'.$idbesoin);
    }

    // DELETING
    public function deleteDetailBesoinCtrl($status,$idbesoin ,$id){
        $this -> Besoin -> deleteDetailBesoin($id);
        redirect(base_url().'back_office/BesoinController/listeDetailCtrl/'.$status.'/'.$idbesoin);
    }

    // UPDATE 
    public function updateDetailBesoinCCtrl(){
        $idbesoin = $this->input->post('idbesoin');
        $status = $this->input->post('status');
        $id = $this->input->post('iddetail');
        $qty = $this->input->post('quantite');
        $this -> Besoin -> updateDetailBesoin($id, $qty);
        redirect(base_url().'back_office/BesoinController/listeDetailBesoinCtrl/'.$idbesoin);
    }

    public function deleteDetailBesoinCCtrl($idbesoin,$id){
        $this -> Besoin -> deleteDetailBesoin($id);
        redirect(base_url().'back_office/BesoinController/listeDetailBesoinCtrl/'.$idbesoin);
    }

    // LISTE DES MATERIELS POUR UN BESOIN SPECIFIC
    public function listeDetailCtrl($status, $idbesoin){
        $data['detail_besoins'] = $this -> Besoin -> getBesoinDetail($idbesoin);
        $data['content'] = 'back_office/achat/detail_besoin';
        $data['materiels'] = $this -> Materiel -> materiels();
        $data['idbesoin'] = $idbesoin;
        $data['status'] = $status;
        $this->load->view('back_office/main',$data);
    }

}
