<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class CommandeClientController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('user_data');
        $departement_vente =  $this->session->userdata('dep_vente');
        if($user['iddepartement'] != $departement_vente){
            redirect('back_office/LoginController/logout');
        }

        $this->load->model('back_office/dep_vente/Commande_client');
        $this->load->model('back_office/achat/Materiel');
    }

    // ENVOYER VERS DEPARTEMENT
    public function sendToDepartement(){ 
        $idcommandeclient =  $this->input->post('idcommandeclient');
        $getStatus = $this -> Commande_client -> updateStatusCommandeClient($idcommandeclient, 1);
        redirect(base_url().'back_office/dep_vente/CommandeClientController/getCommandeClient');
    }

    // ENVOYER REPONSE
    public function sendReponse($idcommandeclient){ 
        $getStatus = $this -> Commande_client -> getResultatCommande($idcommandeclient);
        if($getStatus != null){
            redirect(base_url().'back_office/dep_vente/CommandeClientController/getDetailCommandeClient/'.$idcommandeclient);
        } else {
            $data['commande'] = $this -> Commande_client -> getCommandeClientById($idcommandeclient);
            $data['details'] = $this -> Commande_client -> getDetailCommandeClient($idcommandeclient);
            $data['total'] = $this -> Commande_client -> getTotalMontantCommandeClient($idcommandeclient);
            $data['error'] = $getStatus;
            $data['content'] = 'back_office/dep_vente/detail_commande';
            $this->load->view('back_office/main',$data);
        }
        
    }

    // APERCU DU PDF
    public function apercu_commande($path){
        $document_path = "assets/back_office/pdf/commande/" . $path;
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($document_path) . '"');
        readfile($document_path);
        exit;
    }


    // ENREGISTRER B.C
    public function saveCommandeClient(){
        $idcommandeclient =  $this->input->post('idcommandeclient');
        $namefile = "";

        if (isset($_FILES["file"])) {
            $uploadDir = "assets/back_office/pdf/commande/"; // Dossier où seront stockés les fichiers téléchargés
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
        
        $this -> Commande_client -> savePdfCommandeClientReceived($idcommandeclient, $namefile);
        redirect(base_url().'back_office/dep_vente/CommandeClientController/sendReponse/'.$idcommandeclient);
    }

    // AJOUT DETAIL MATERIEL DANS COMMANDE CLIENT
    public function addDetailCommandeClient(){
        $idcommandeclient =  $this->input->post('idcommandeclient');
        $idmateriel = $this->input->post('idmateriel');
        $qty = $this->input->post('qty');

        $this -> Commande_client -> saveDetailCommandeClient($idcommandeclient, $idmateriel, $qty);
        redirect(base_url().'back_office/dep_vente/CommandeClientController/getDetailCommandeClient/'.$idcommandeclient);
    }


    // CREER UN BON DE COMMANDE
    public function createCommandeClient(){
        $user = $this->session->userdata('user_data');
        $date = $this->input->post('datecommande');
        $numero = $this->input->post('numero');
        $customer = $this->input->post('idcustomer');

        $idcommandeclient = $this -> Commande_client -> createMainCommandeClient($customer, $numero, $date, $user['idemployee']);
        redirect(base_url().'back_office/dep_vente/CommandeClientController/getDetailCommandeClient/'.$idcommandeclient);
    }

    // AVOIR PAGE DETAIL DETAIL COMMANDE
    public function getDetailCommandeClient($idcommandeclient){
        $commande = $this -> Commande_client -> getCommandeClientById($idcommandeclient);
        $data['commande'] = $commande;
        if($commande['status_commande_client'] == 9){
            $data['error'] = $this -> Commande_client -> getResultatCommande($idcommandeclient);
        }
        $data['details'] = $this -> Commande_client -> getDetailCommandeClient($idcommandeclient);
        $data['total'] = $this -> Commande_client -> getTotalMontantCommandeClient($idcommandeclient);
        $data['materiels'] = $this -> Materiel -> materiels();
        $data['content'] = 'back_office/dep_vente/detail_commande';
        $this->load->view('back_office/main',$data);
    }

    // AVOIR LES COMMANDES RECUS
    public function getCommandeClient(){
        $this -> Commande_client -> deleteCacheCommandeClient();
        $this->load->model('back_office/dep_vente/Customer');
        $data['customers'] = $this -> Customer -> customers();
        $data['commandes'] = $this-> Commande_client -> getRecentCommandeClient();
        $data['content'] = 'back_office/dep_vente/liste_commande';
        $this->load->view('back_office/main', $data);
    }
}
