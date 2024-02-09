<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class StockController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('user_data');
        $departement_log =  $this->session->userdata('dep_logistique');
        if($user['iddepartement'] != $departement_log){
            redirect('back_office/LoginController/logout');
        }

        $this->load->model('back_office/stock_option/Stock');
    }

    // GET ETAT STOCK PRODUIT
    public function getEtatStockProduct(){
        $date = $this -> input -> post('datestock');
        $this->load->model('back_office/achat/Materiel');
        // date_default_timezone_set('Indian/Antananarivo');
        // $currentDateTime = date('Y-m-d');
        $materiel = $this->input->post('idmateriel');
        // if($materiel == '%'){
        //     redirect(base_url().'back_office/dep_logistique/StockController/getEtatStockGeneral/');
        // }
        $data['stock'] = $this -> Stock -> get_etat_stock_product($materiel, $date);
        $data['materiels'] = $this -> Materiel -> materiels();
        $data['content'] = 'back_office/dep_logistique/etat_stock_search';        // Its a page
        $this->load->view('back_office/main',$data);
    }

    // Faire des demandes JOUR J FOANA ZANY
    public function makeDemande(){
        date_default_timezone_set('Indian/Antananarivo');
        $currentDateTime = date('Y-m-d');
        $user = $this->session->userdata('user_data');

        $idbesoin = $this -> Stock -> makeDemandeAchatMateriel($currentDateTime, $user['idemployee'], $user['iddepartement']);
        redirect(base_url().'back_office/BesoinController/listeDetailBesoinCtrl/'.$idbesoin);

    }
    
    // FABRICATION DE LA FACTURE PDF
    public function getEtatStockGeneral(){
        $date = $this -> input -> post('datestock');
        $this->load->model('back_office/achat/Materiel');
        // date_default_timezone_set('Indian/Antananarivo');
        // $currentDateTime = date('Y-m-d');
        $data['stock'] = $this -> Stock -> get_all_etat_stock($date);
        $data['date'] = $date;
        $data['materiels'] = $this -> Materiel -> materiels();
        $data['content'] = 'back_office/dep_logistique/etat_stock';        // Its a page
        $this->load->view('back_office/main',$data);
    }
}
