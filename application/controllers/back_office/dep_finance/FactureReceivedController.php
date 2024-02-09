<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class FactureReceivedController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('user_data');
        $departemet_finance =  $this->session->userdata('dep_finance');
        if($user['iddepartement'] != $departemet_finance){
            redirect('back_office/LoginController/logout');
        }

        $this->load->model('back_office/dep_finance/Facture_received');
        $this->load->model('back_office/achat/Materiel');
    }

    // APERCU DU PDF
    public function apercu_fr($path){
        $document_path = "assets/back_office/pdf/facture/" . $path;
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($document_path) . '"');
        readfile($document_path);
        exit;
    }

    // ENREGISTRER B.L
    public function saveFactureReceived(){
        $idfacturereceived =  $this->input->post('idfacturereceived');
        $namefile = "";

        if (isset($_FILES["file"])) {
            $uploadDir = "assets/back_office/pdf/facture/"; // Dossier où seront stockés les fichiers téléchargés
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
        
       $this -> Facture_received -> saveFactureReceivedWithPdf($idfacturereceived, $namefile);
       redirect(base_url().'back_office/dep_finance/FactureReceivedController/getDetailFactureReceived/'.$idfacturereceived);
    }

    // AJOUT DETAIL MATERIEL DANS FACTURE RECU
    public function addFactureReceivedDetail(){
        $idfacturereceived =  $this->input->post('idfacturereceived');
        $idmateriel = $this->input->post('idmateriel');
        $qty = $this->input->post('qty');
        $remarque = $this->input->post('remarque');

        $this -> Facture_received -> saveDetailFactureReceived($idfacturereceived, $idmateriel, $qty, $remarque);
       redirect(base_url().'back_office/dep_finance/FactureReceivedController/getDetailFactureReceived/'.$idfacturereceived);
    }


    // CREER UNE FACTURE RECU
    public function createFactureReceived(){
        $user = $this->session->userdata('user_data');
        $date = $this->input->post('datefacture');
        $numero = $this->input->post('numero');
        $idcommande = $this->input->post('idcommande');
        if(trim($idcommande) == '') $idcommande = null;

        $idfacture = $this -> Facture_received -> createMainFactureReceived($numero, $idcommande, $date, $user['idemployee']);
        redirect(base_url().'back_office/dep_finance/FactureReceivedController/getDetailFactureReceived/'.$idfacture);
    }

    // AVOIR PAGE DETAIL FACTURE RECU
    public function getDetailFactureReceived($idfacturereceived){
        $data['fr'] = $this -> Facture_received -> getFactureReceivedById($idfacturereceived);
        $data['details'] = $this -> Facture_received -> getDetailFactureReceived($idfacturereceived);
        $data['materiels'] = $this -> Materiel -> materiels();
        $data['content'] = 'back_office/dep_finance/detail_facture_received';
        $this->load->view('back_office/main',$data);
    }

    // AVOIR LES BONS DE LIVRAISONS
    public function getFactureReceived(){
        $this -> Facture_received -> deleteCacheFactureReceived();
        $this->load->model('back_office/achat/Bandcommande');
        $data['commande_sent'] = $this -> Bandcommande -> getBonCommandeSent();
        $data['frs'] = $this-> Facture_received -> getRecentFactureReceived();
        $data['content'] = 'back_office/dep_finance/liste_facture_received';
        $this->load->view('back_office/main', $data);
    }
}
