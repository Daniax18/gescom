<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class VoitureController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('user_data');
        $departement_finance =  $this->session->userdata('dep_finance');
        if($user['iddepartement'] != $departement_finance){
            redirect('back_office/LoginController/logout');
        }

        $this->load->model('back_office/dep_finance/gestion_auto/Voitures');
    }

    // PRENDRE LES DEPENSE DE VOITURE 
    public function getAllDepenseVoiture(){
        $status = $this -> input -> get("status");
        if($status == 1){
            $data['depenses'] = $this -> Voitures -> getAllDepenseEntretien();
            $data['status'] = 'Liste des depenses des voitures par Entretien :';
            $data['style_entretien'] = 'strong';
            $data['style_carbu'] = 'span';
            $data['style_total'] = 'span';
        } else if($status == 2){
            $data['depenses'] = $this -> Voitures -> getAllDepenseCarburant();
            $data['status'] = 'Liste des depenses des voitures par Carburant :';
            $data['style_entretien'] = 'span';
            $data['style_carbu'] = 'strong';
            $data['style_total'] = 'span';
        } else {
            $data['depenses'] = $this -> Voitures -> getAllTotalDepense();
            $data['status'] = 'Liste des depenses des voitures par Entretien et Carburant :';
            $data['style_entretien'] = 'span';
            $data['style_carbu'] = 'span';
            $data['style_total'] = 'strong';
        }
        $data['content'] = 'back_office/dep_finance/depenses_voiture'; 
       
        $this->load->view('back_office/main',$data);
    }
}
