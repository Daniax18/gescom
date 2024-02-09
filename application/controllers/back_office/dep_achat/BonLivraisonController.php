<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class BonLivraisonController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('user_data');
        $departemet_achat =  $this->session->userdata('dep_achat');
        if($user['iddepartement'] != $departemet_achat){
            redirect('back_office/LoginController/logout');
        }

        $this->load->model('back_office/dep_achat/BonLivraison');
        $this->load->model('back_office/achat/Materiel');
    }

    // APERCU DU PDF
    public function apercu_bl($path){
        $document_path = "assets/back_office/pdf/bl/" . $path;
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($document_path) . '"');
        readfile($document_path);
        exit;
    }

    // ENREGISTRER B.L
    public function saveBonLivraison(){
        $idlivraison =  $this->input->post('idbonlivraison');
        $namefile = "";

        if (isset($_FILES["file"])) {
            $uploadDir = "assets/back_office/pdf/bl/"; // Dossier où seront stockés les fichiers téléchargés
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
        
       $this -> BonLivraison -> saveLivraisonWithPdf($idlivraison, $namefile);
        redirect(base_url().'back_office/dep_achat/BonLivraisonController/getDetailLivraison/'.$idlivraison);
    }

    // AJOUT DETAIL MATERIEL DANS LIVRAISON
    public function addDetailLivraison(){
        $idlivraison =  $this->input->post('idlivraison');
        $idmateriel = $this->input->post('idmateriel');
        $qty = $this->input->post('qty');
        $remarque = $this->input->post('remarque');

        $this -> BonLivraison -> saveDetailLivraison($idlivraison, $idmateriel, $qty, $remarque);
        redirect(base_url().'back_office/dep_achat/BonLivraisonController/getDetailLivraison/'.$idlivraison);
    }


    // CREER UN BON DE LIVRAISON
    public function createBonLivraison(){
        $user = $this->session->userdata('user_data');
        $date = $this->input->post('datelivraison');
        $numero = $this->input->post('numero');
        $idcommande = $this->input->post('idcommande');
        if(trim($idcommande) == '') $idcommande = null;

        $idlivraison = $this -> BonLivraison -> createMainLivraison($numero, $idcommande, $date, $user['idemployee']);
        redirect(base_url().'back_office/dep_achat/BonLivraisonController/getDetailLivraison/'.$idlivraison);
    }

    // AVOIR PAGE DETAIL LIVRAISONS
    public function getDetailLivraison($idlivraison){
        $data['bl'] = $this -> BonLivraison -> getBonLivraisonById($idlivraison);
        $data['details'] = $this -> BonLivraison -> getDetailLivraison($idlivraison);
        $data['materiels'] = $this -> Materiel -> materiels();
        $data['content'] = 'back_office/dep_achat/detail_livraison';
        $this->load->view('back_office/main',$data);
    }

    // AVOIR LES BONS DE LIVRAISONS
    public function getBonLivraison(){
        $this -> BonLivraison -> deleteCacheLivraison();
        $this->load->model('back_office/achat/Bandcommande');
        $data['commande_sent'] = $this -> Bandcommande -> getBonCommandeSent();
        $data['bls'] = $this-> BonLivraison -> getRecentBonLivraison();
        $data['content'] = 'back_office/dep_achat/liste_bl';
        $this->load->view('back_office/main', $data);
    }
}
