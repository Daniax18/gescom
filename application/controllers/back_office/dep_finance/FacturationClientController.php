<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class FacturationClientController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('user_data');
        $departement_finance =  $this->session->userdata('dep_finance');
        if($user['iddepartement'] != $departement_finance){
            redirect('back_office/LoginController/logout');
        }

        $this->load->model('back_office/dep_finance/Facturation');
    }

    // APERCU DU PDF
    public function apercu_pdf_facture($path){
        $document_path = "assets/data_company/facture/" . $path;
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($document_path) . '"');
        readfile($document_path);
        exit;
    }

    
    // APERCU DU PDF BON COMMANDE
    public function apercu_commande($path){
        $document_path = "assets/back_office/pdf/commande/" . $path;
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($document_path) . '"');
        readfile($document_path);
        exit;
    }

    // enregistret facture avec pdf
    public function saveFacturePdf(){
        $idfacturation =  $this->input->post('idfacturation');
        $namefile = "";

        if (isset($_FILES["file"])) {
            $uploadDir = "assets/data_company/facture/"; // Dossier où seront stockés les fichiers téléchargés
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
        $this -> Facturation -> saveFactureClientPdfSent($idfacturation, $namefile);
        redirect(base_url().'back_office/dep_finance/FacturationClientController/getFacturation');
    }

    // APERCU DU PDF
    public function apercu_facturation($path){
        $document_path = "assets/data_company/facture/" . $path;
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($document_path) . '"');
        readfile($document_path);
        exit;
    }

    // FABRICATION DE LA FACTURE PDF
    public function createPdfFacturation($idfacturation){
        $this->load->model('back_office/achat/Bandcommande');
        $data['facture'] = $this -> Facturation -> getFacturationById($idfacturation);
        $data['details'] = $this -> Facturation -> getDetailFacturationById($idfacturation);
        $data['total'] = $this -> Facturation -> getTotalMontantFactureClient($idfacturation);
        $data['content'] = 'back_office/dep_finance/apercu_facturation';        // Its a page
        $this->load->view('back_office/main',$data);
    }

    // FACTURER UN BON DE COMMANDE
    public function facturationCommande(){
        $user = $this->session->userdata('user_data');
        $date = $this->input->post('datecommande');
        $commande = $this->input->post('idcommandeclient');

        $idfacture = $this -> Facturation -> facturateBonCommande($commande, $date, $user['idemployee']);
        redirect(base_url().'back_office/dep_finance/FacturationClientController/createPdfFacturation/'.$idfacture);
    }

    // DETAIL D;;UNE FACTURE ENVOYE
    public function getDetailFactureMade($idfacturation){
        $data['facture'] = $this -> Facturation -> getFacturationById($idfacturation);
        $data['details'] = $this -> Facturation -> getDetailFacturationById($idfacturation);
        $data['total'] = $this -> Facturation -> getTotalMontantFactureClient($idfacturation);
        $data['content'] = 'back_office/dep_finance/detail_facture_made';
        $this->load->view('back_office/main',$data);
    }

    // AVOIR PAGE DETAIL DETAIL COMMANDE
    public function getDetailCommandeNeedFacturation($idcommandeclient){
        $this->load->model('back_office/dep_vente/Commande_client');
        $commande = $this -> Commande_client -> getCommandeClientById($idcommandeclient);
        $data['commande'] = $commande;
        $data['details'] = $this -> Commande_client -> getDetailCommandeClient($idcommandeclient);
        $data['total'] = $this -> Commande_client -> getTotalMontantCommandeClient($idcommandeclient);
        $data['content'] = 'back_office/dep_finance/detail_commande';
        $this->load->view('back_office/main',$data);
    }

    // AVOIR LES COMMANDES RECUS
    public function getCommadeNeedFacturation(){
        $data['commandes'] = $this-> Facturation -> getCommandeNeedFacturation();
        $data['content'] = 'back_office/dep_finance/liste_bc_need_facture';
        $this->load->view('back_office/main', $data);
    }

    // AVOIR LES FACTURES FABRIQUES
    public function getFacturation(){
        $data['factures'] = $this-> Facturation -> getFacturationMade();
        $data['content'] = 'back_office/dep_finance/liste_facture_made';
        $this->load->view('back_office/main', $data);
    }
}
