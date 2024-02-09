<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class BonReceptionController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('user_data');
        $departemet_achat =  $this->session->userdata('dep_achat');
        if($user['iddepartement'] != $departemet_achat){
            redirect('back_office/LoginController/logout');
        }

        $this->load->model('back_office/dep_achat/BonLivraison');
        $this->load->model('back_office/dep_achat/BonReception');
        $this->load->model('back_office/achat/Materiel');
    }

    // PRINT BR
    public function printReception($idreception){
        $data['br'] = $this -> BonReception -> getBonReceptionById($idreception);
        $data['details'] = $this -> BonReception -> getDetailReception($idreception);
        $data['content'] = 'back_office/dep_achat/apercu_br';
        $this->load->view('back_office/main',$data);
    }

    // CREATION BON DE RECEPTION
    public function createBonReception(){
        $user = $this->session->userdata('user_data');
        $idlivraison = $this->input->post('idlivraison');
        $details = $this -> BonLivraison -> getDetailLivraison($idlivraison);
        $datereception = $this->input->post('datelivraison');
        
        $this->db->trans_start(); // Start a transaction
        $idreception = $this -> BonReception -> createMainReception($idlivraison, $datereception, $user['idemployee']);
        foreach($details as $detail){
            $qty_received = $this->input->post($detail['idmateriel']);
            $this -> BonReception -> addDetailReception($idreception, $detail['idmateriel'] ,$detail['qty_received'], $qty_received);
        }
        $this->db->trans_complete(); // Complete the transaction
        redirect(base_url().'back_office/dep_achat/BonReceptionController/getDetailReception/'.$idreception);
    }

    // PRENDRE LE DETAIL D'UN BON DE RECEPTION
    public function getDetailReception($idreception){
        $data['br'] = $this -> BonReception -> getBonReceptionById($idreception);
        $data['details'] = $this -> BonReception -> getDetailReception($idreception);
        $data['content'] = 'back_office/dep_achat/detail_reception';
        $this->load->view('back_office/main',$data);
    }

    // PRENDRE LA LISTE DES BON DE RECEPTION
    public function getBonReception(){
        $data['brs'] = $this-> BonReception -> getRecentBonReception();
        $data['content'] = 'back_office/dep_achat/liste_br';
        $this->load->view('back_office/main', $data);
    }
}
