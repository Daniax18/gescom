<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class StockController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('user_data');
        $departement_finance =  $this->session->userdata('dep_finance');
        if($user['iddepartement'] != $departement_finance){
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
        //     redirect(base_url().'back_office/dep_finance/StockController/getEtatStockGeneral/');
        // }
        $data['stock'] = $this -> Stock -> etat_stock_materiel($materiel, $date);
        $data['materiels'] = $this -> Materiel -> materiels();
        $data['content'] = 'back_office/dep_finance/etat_stock_search';        // Its a page
        $this->load->view('back_office/main',$data);
    }


    // TOTAL ETAT STOCK
    public function getEtatStockGeneral(){
        $date = $this -> input -> post('datestock');
        $this->load->model('back_office/achat/Materiel');
        // date_default_timezone_set('Indian/Antananarivo');
        // $currentDateTime = date('Y-m-d');
        $data['stock'] = $this -> Stock -> get_all_etat_stock($date);
        $data['total'] = $this -> Stock -> getTotalValueEnStock($date);
        $data['date'] = $date;
        $data['materiels'] = $this -> Materiel -> materiels();
        $data['content'] = 'back_office/dep_finance/etat_stock';        // Its a page
        $this->load->view('back_office/main',$data);
    }
}
