<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class BesoinController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('user_data');
        $departemet_achat =  $this->session->userdata('dep_achat');

        $departemet_finance =  $this->session->userdata('dep_finance');
        if($user['iddepartement'] != $departemet_achat && $user['iddepartement'] != $departemet_finance){
            redirect('back_office/LoginController/logout');
        }

		$this->load->model('back_office/achat/Materiel');
        $this->load->model('back_office/dep_achat/BesoinAchat');
        $this->load->model('back_office/dep_achat/Proforma');
    }

    // DEGROUPER UN BESOIN GLOBAL
    public function degroupeBesoinGlobalCtrl(){
        $idglobal = $this->input->post('idglobal');
        $this -> BesoinAchat -> degroupGlobal($idglobal);
        redirect('back_office/dep_achat/BesoinController/getAllBesoinsCtrl');
    }
    

    // PRENDRE TOUS LES BESOINS GLOBAAUX
    public function getBesoinGlobalCtrl(){
        $data['globals'] = $this -> BesoinAchat -> getBesoinsGlobaux();
        $data['content'] = 'back_office/dep_achat/besoin_global';
        $this->load->view('back_office/main', $data);
    }

    // GROUPER LES BESOINS -> BESOIN GLOBAL
    public function groupeBesoinsCtrl(){
        $user = $this->session->userdata('user_data');
        $idglobal = $this-> BesoinAchat -> groupeBesoinsToGlobal($user['idemployee']);
        redirect('back_office/dep_achat/BesoinController/getBesoinGlobalCtrl');
    }

    // LISTE DES BESOINS DE TOUS LES DEPARTEMENTS
    public function getAllBesoinsCtrl(){

        $data['besoins'] = $this -> BesoinAchat -> besoins();
        $data['content'] = 'back_office/dep_achat/liste_demandes';
        $this->load->view('back_office/main', $data);
    }
}
