<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class ProformaClientController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('user_data');
        $departement_vente =  $this->session->userdata('dep_vente');
        if($user['iddepartement'] != $departement_vente){
            redirect('back_office/LoginController/logout');
        }

        $this->load->model('back_office/dep_vente/Proforma_client');
        $this->load->model('back_office/achat/Materiel');
    }

    // ENVOYER REPONSE CLIENT
    public function envoyerProforma(){ 
        $idproforma =  $this->input->post('idproformaclient');
        $namefile = "";

        if (isset($_FILES["file"])) {
            $uploadDir = "assets/data_company/proforma/"; // Dossier où seront stockés les fichiers téléchargés
            $uploadFile = $uploadDir . basename($_FILES["file"]["name"]);

            // Vérification du type de fichier
            $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
            $allowedExtensions = array("pdf", "jpeg", "jpg", "png");

            if (in_array($fileType, $allowedExtensions)) {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadFile)) {
                    $namefile =  htmlspecialchars(basename($_FILES["file"]["name"]));
                } 
            } 
        }
        
        $this -> Proforma_client -> saveProformaClientWithPdfSent($idproforma, $namefile);
        redirect(base_url().'back_office/dep_vente/ProformaClientController/getDetailProformaClient/'.$idproforma);
    }


    // ENVOYER REPONSE
    public function sendReponse(){ 
        $idproforma =  $this->input->post('idproformaclient');
        $this -> Proforma_client -> getResultatProforma($idproforma);
        redirect(base_url().'back_office/dep_vente/ProformaClientController/apercu_proforma_before/'.$idproforma);
    }

    // Apercu proforma reponse
    public function apercu_proforma_before($idproforma){
        $this->load->model('back_office/achat/Bandcommande');
        $data['proforma'] = $this -> Proforma_client -> getProformaClientById($idproforma);
        $data['details'] = $this -> Proforma_client -> getDetailProformaClient($idproforma);
        $data['total'] = $this -> Proforma_client -> getTotalMontantProformaClient($idproforma);
        $data['content'] = 'back_office/dep_vente/apercu_proforma';
        $this->load->view('back_office/main',$data);
    }

    // APERCU DU PDF
    public function apercu_proforma($path){
        $document_path = "assets/back_office/pdf/proforma/" . $path;
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($document_path) . '"');
        readfile($document_path);
        exit;
    }

    
    // APERCU DU PDF
    public function apercu_proforma_sent($path){
        $document_path = "assets/data_company/proforma/" . $path;
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($document_path) . '"');
        readfile($document_path);
        exit;
    }

    // ENREGISTRER B.L
    public function saveProformaClient(){
        $idproformaclient =  $this->input->post('idproformaclient');
        $namefile = "";

        if (isset($_FILES["file"])) {
            $uploadDir = "assets/back_office/pdf/proforma/"; // Dossier où seront stockés les fichiers téléchargés
            $uploadFile = $uploadDir . basename($_FILES["file"]["name"]);

            // Vérification du type de fichier
            $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
            $allowedExtensions = array("pdf", "jpeg", "jpg", "png");

            if (in_array($fileType, $allowedExtensions)) {
                if (move_uploaded_file($_FILES["file"]["tmp_name"], $uploadFile)) {
                    $namefile =  htmlspecialchars(basename($_FILES["file"]["name"]));
                } 
            } 
        }
        
        $this -> Proforma_client -> saveProformaClientWithPdf($idproformaclient, $namefile);
        redirect(base_url().'back_office/dep_vente/ProformaClientController/getDetailProformaClient/'.$idproformaclient);
    }

    // AJOUT DETAIL MATERIEL DANS PROFORMA CLIENT
    public function addDetailProformaClient(){
        $idproforma =  $this->input->post('idproforma');
        $idmateriel = $this->input->post('idmateriel');
        $qty = $this->input->post('qty');

        $this -> Proforma_client -> saveDetailProformaClient($idproforma, $idmateriel, $qty);
        redirect(base_url().'back_office/dep_vente/ProformaClientController/getDetailProformaClient/'.$idproforma);
    }


    // CREER UN PROFORMA
    public function createProformaClient(){
        $user = $this->session->userdata('user_data');
        $date = $this->input->post('dateproforma');
        $numero = $this->input->post('numero');
        $customer = $this->input->post('idcustomer');

        $idproforma = $this -> Proforma_client -> createMainProformaClient($customer, $numero, $date, $user['idemployee']);
        redirect(base_url().'back_office/dep_vente/ProformaClientController/getDetailProformaClient/'.$idproforma);
    }

    // AVOIR PAGE DETAIL PROFORMA
    public function getDetailProformaClient($idproforma){
        $data['proforma'] = $this -> Proforma_client -> getProformaClientById($idproforma);
        $data['details'] = $this -> Proforma_client -> getDetailProformaClient($idproforma);
        $data['total'] = $this -> Proforma_client -> getTotalMontantProformaClient($idproforma);
        $data['materiels'] = $this -> Materiel -> materiels();
        $data['content'] = 'back_office/dep_vente/detail_proforma_client';
        $this->load->view('back_office/main',$data);
    }

    // AVOIR LES B.C RECUS
    public function getProformaClient(){
        $this -> Proforma_client -> deleteCacheProformaClient();
        $this->load->model('back_office/dep_vente/Customer');
        $data['customers'] = $this -> Customer -> customers();
        $data['proformas'] = $this-> Proforma_client -> getRecentProformaClient();
        $data['content'] = 'back_office/dep_vente/liste_proforma';
        $this->load->view('back_office/main', $data);
    }
}
