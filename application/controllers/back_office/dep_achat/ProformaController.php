<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class ProformaController extends BaseSessionController {
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

    // CREER LES PROFORMAS
    public function createProforma(){
        $idglobal = $this->input->post('idglobal');
        $this -> Proforma -> createProformaOfGlobal($idglobal);
        redirect('back_office/dep_achat/ProformaController/getDetaiGlobalProforma/'. $idglobal);
    }

    

    // PRENDRE TOUS LES DETAIL D'UN GLOBAL
    public function getDetaiGlobalProforma($idglobal){
        $global = $this -> BesoinAchat -> globalById($idglobal);
        $data['global'] =  $global;
        $data['mydetails'] = $this -> BesoinAchat -> besoinsOfGlobal($idglobal);
        if($global['status'] >= 0){
            $data['suppliers'] = $this -> Proforma -> getSuppliersDetailsConcerned($idglobal);
        }
        
        $data['materiels'] = $this -> BesoinAchat -> getDetailGlobalMateriel($idglobal);
        $data['content'] = 'back_office/dep_achat/detail_global';
        $this->load->view('back_office/main', $data);
    }

}
