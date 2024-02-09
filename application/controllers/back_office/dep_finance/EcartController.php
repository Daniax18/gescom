<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class EcartController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('user_data');
        $departement_finance =  $this->session->userdata('dep_finance');
        if($user['iddepartement'] != $departement_finance){
            redirect('back_office/LoginController/logout');
        }

        $this->load->model('back_office/stock_option/Ecart');
    }

    // PRENDRE LE DETAIL D'UNE INVENTAIRE
    public function getDetailInventaire($idinventaire){
        $this->load->model('back_office/stock_option/Ecart');
        $this->load->model('back_office/stock_option/Stock');
        $inventaire = $this -> Inventaire -> getInventaireById($idinventaire);
        $data['inventaire'] = $inventaire;
        $data['details'] = $this -> Inventaire -> getDetailInventaire($idinventaire);
        $data['last_inventaire'] = $this -> Inventaire -> getPreviousInventaire($inventaire['dateinventaire']);
        $data['content'] = 'back_office/dep_finance/detail_inventaire';        // Its a page
        $this->load->view('back_office/main',$data);
    }


    // PRENDRE LES INVENTAIRES VALIDER
    public function getInventaireValidate(){
        $data['perte'] = $this -> Ecart -> getTotalEcart();
        $data['inventaires'] = $this -> Ecart -> getValidateInventaire();
        $data['content'] = 'back_office/dep_finance/liste_inventaires';        // Its a page
        $this->load->view('back_office/main',$data);
    }
}
