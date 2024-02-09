<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class BonLivraisonClientController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('user_data');
        $departement_log =  $this->session->userdata('dep_logistique');
        if($user['iddepartement'] != $departement_log){
            redirect('back_office/LoginController/logout');
        }

        $this->load->model('back_office/dep_logistique/BonLivraisonClient');
    }

    // APERCU DU PDF BON LIVRAISON
    public function apercu_pdf_bon_livraison($path){
        $document_path = "assets/data_company/bon_livraison/" . $path;
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
    public function saveBonLivraisonPdf(){
        $idlivraisonclient =  $this->input->post('idlivraisonclient');
        $namefile = "";

        if (isset($_FILES["file"])) {
            $uploadDir = "assets/data_company/bon_livraison/"; // Dossier où seront stockés les fichiers téléchargés
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
        $this -> BonLivraisonClient -> saveBonLivraisonClientPdfSent($idlivraisonclient, $namefile);
        redirect(base_url().'back_office/dep_logistique/BonLivraisonClientController/getBonLivraisonClient');
    }

    // APERCU DU PDF
    public function apercu_livraison($path){
        $document_path = "assets/data_company/facture/" . $path;
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($document_path) . '"');
        readfile($document_path);
        exit;
    }

    // FABRICATION DE LA B.L PDF
    public function createPdfBonLivraisonClient($idlivraisonclient){
        $data['livraison'] = $this -> BonLivraisonClient -> getBonLivraisonById($idlivraisonclient);
        $data['details'] = $this -> BonLivraisonClient -> getDetailLivraisonById($idlivraisonclient);
        $data['content'] = 'back_office/dep_logistique/apercu_bl_client';        // Its a page
        $this->load->view('back_office/main',$data);
    }

    // LIVRER UN BON DE COMMANDE
    public function makeLivraisonClientCommande(){
        $user = $this->session->userdata('user_data');
        $date = $this->input->post('datelivraison');
        $commande = $this->input->post('idcommandeclient');

        $idbonlivraison = $this -> BonLivraisonClient -> makeLivraisonBonCommande($commande, $date, $user['idemployee']);
        redirect(base_url().'back_office/dep_logistique/BonLivraisonClientController/createPdfBonLivraisonClient/'.$idbonlivraison);
    }

    // DETAIL D;;UNE BL ENVOYE
    public function getDetailBlMade($idlivraisonclient){
        $data['livraison'] = $this -> BonLivraisonClient -> getBonLivraisonById($idlivraisonclient);
        $data['details'] = $this -> BonLivraisonClient -> getDetailLivraisonById($idlivraisonclient);
        $data['content'] = 'back_office/dep_logistique/detail_bl_made';
        $this->load->view('back_office/main',$data);
    }

    // AVOIR PAGE DETAIL DETAIL COMMANDE
    public function getDetailCommandeNeedBonLivraisonClient($idcommandeclient){
        $this->load->model('back_office/dep_vente/Commande_client');
        $commande = $this -> Commande_client -> getCommandeClientById($idcommandeclient);
        $data['commande'] = $commande;
        $data['details'] = $this -> Commande_client -> getDetailCommandeClient($idcommandeclient);
        $data['content'] = 'back_office/dep_logistique/detail_commande_bl';
        $this->load->view('back_office/main',$data);
    }

    // AVOIR LES COMMANDES RECUS
    public function getCommadeNeedBonLivraisonClient(){
        $data['commandes'] = $this-> BonLivraisonClient -> getCommandeNeedBonLivraison();
        $data['content'] = 'back_office/dep_logistique/liste_bc_need_livraison';
        $this->load->view('back_office/main', $data);
    }

    // AVOIR LES B.L Client FABRIQUES
    public function getBonLivraisonClient(){
        $data['livraisons'] = $this-> BonLivraisonClient -> getBonLivraisonClientMade();
        $data['content'] = 'back_office/dep_logistique/liste_bl_made';
        $this->load->view('back_office/main', $data);
    }
}
