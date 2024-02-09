<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class InventaireController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('user_data');
        $departement_log =  $this->session->userdata('dep_logistique');
        if($user['iddepartement'] != $departement_log){
            redirect('back_office/LoginController/logout');
        }

        $this->load->model('back_office/dep_logistique/Inventaire');
    }

    // DEMANDE DE REVERIFICATIO UNE INVENTAIRE ALONG WITH ECART
    public function validateInventaire(){
        $idinventaire = $this -> input -> post('inventaire');
        $this->load->model('back_office/stock_option/Ecart');
        $this->db->trans_start(); // Start a transaction
        $this -> Inventaire -> updateStatusInventaire($idinventaire, 2);
        $this -> Ecart -> updateStatusEcart($idinventaire, 1);

        $this->db->trans_complete(); // Complete the transaction
        redirect(base_url().'back_office/dep_logistique/InventaireController/getDetailInventaire/'.$idinventaire);
    }

    // DEMANDE DE REVERIFICATIO UNE INVENTAIRE
    public function reverifyInventaire(){
        $idinventaire = $this -> input -> post('inventaire');
        $this -> Inventaire -> updateStatusInventaire($idinventaire, 0);
        redirect(base_url().'back_office/dep_logistique/InventaireController/getDetailInventaire/'.$idinventaire);
    }

    // ENREGISTRER UNE INVENTAIRE
    public function saveInventaire(){
        $idinventaire = $this -> input -> post('inventaire');
        $this -> Inventaire -> updateStatusInventaire($idinventaire, 1);
        redirect(base_url().'back_office/dep_logistique/InventaireController/getDetailInventaire/'.$idinventaire);
    }

    // MODIFIER DETAIL D'INVENTAIRE
    public function modifyDetailInventaire(){
        $this->load->model('back_office/stock_option/Ecart');
        $idinventaire = $this -> input -> post('inventaire');
        $detail = $this -> input -> post('iddetail_inventaire');
        $qty = $this -> input -> post('qty');
        $remarque = $this -> input -> post('remarque');
        $idmateriel = $this -> input -> post('idmateriel');


        $this->db->trans_start(); // Start a transaction

        $this -> Inventaire -> updateDetailInventaire($detail, $qty, $remarque);
        $this -> Ecart -> updateDetailInventaire($idmateriel, $idinventaire, $qty); 

        $this->db->trans_complete(); // Complete the transaction
        redirect(base_url().'back_office/dep_logistique/InventaireController/getDetailInventaire/'.$idinventaire);
    }

    // PRENDRE LE DETAIL D'UNE INVENTAIRE
    public function getDetailInventaire($idinventaire){
        $this->load->model('back_office/stock_option/Ecart');
        $this->load->model('back_office/stock_option/Stock');
        $inventaire = $this -> Inventaire -> getInventaireById($idinventaire);
        $data['inventaire'] = $inventaire;
        $data['details'] = $this -> Inventaire -> getDetailInventaire($idinventaire);
        $data['last_inventaire'] = $this -> Inventaire -> getPreviousInventaire($inventaire['dateinventaire']);
        $data['content'] = 'back_office/dep_logistique/detail_inventaire';        // Its a page
        $this->load->view('back_office/main',$data);
    }
    
    // SAVE GENERAL INVENTAIRE
    public function createGeneralInventaire(){
        $user = $this->session->userdata('user_data');
        $dateinventaire = $this -> input -> post('dateinvetntaire');
        $namefile = "";

        if (isset($_FILES["file"])) {
            $uploadDir = "assets/data_company/inventaire/"; // Dossier où seront stockés les fichiers téléchargés
            $uploadFile = $uploadDir . basename($_FILES["file"]["name"]);

            // Vérification du type de fichier
            $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
            $allowedExtensions = array("csv");

            if (in_array($fileType, $allowedExtensions)) {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadFile)) {
                    $namefile =  htmlspecialchars(basename($_FILES["file"]["name"]));
                    $id = $this -> Inventaire -> saveGeneralInventaire($dateinventaire, $namefile, $user['idemployee']);
                } 
            } 

           redirect(base_url().'back_office/dep_logistique/InventaireController/getDetailInventaire/'.$id);

        }
    }

    // Telecharger le modele de fichier 
    public function downloadXls(){
        redirect(base_url('assets/data_company/inventaire.xlsx'));
    }
    
    // FABRICATION DE LA FACTURE PDF
    public function getInventaires(){
        $data['inventaires'] = $this -> Inventaire -> getRecentInventaire();
        $data['content'] = 'back_office/dep_logistique/liste_inventaires';        // Its a page
        $this->load->view('back_office/main',$data);
    }
}
