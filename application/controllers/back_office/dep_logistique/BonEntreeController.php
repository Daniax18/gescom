<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class BonEntreeController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('user_data');
        $departemet_logistique =  $this->session->userdata('dep_logistique');
        if($user['iddepartement'] != $departemet_logistique){
            redirect('back_office/LoginController/logout');
        }

        $this->load->model('back_office/dep_logistique/BonEntree');
        $this->load->model('back_office/dep_achat/BonReception');
        $this->load->model('back_office/achat/Materiel');
    }

    // PRINT BR
    public function printReception($idreception){
        $data['br'] = $this -> BonReception -> getBonReceptionById($idreception);
        $data['details'] = $this -> BonReception -> getDetailReception($idreception);
        $data['content'] = 'back_office/dep_logistique/apercu_br';
        $this->load->view('back_office/main',$data);
    }

    // APERCU DU PDF RECEPTION
    public function apercu_be($path){
        $document_path = "assets/back_office/pdf/b_reception/" . $path;
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($document_path) . '"');
        readfile($document_path);
        exit;
    }

    // ENREGISTRER B.L
    public function saveBonEntree(){
        $idbonentree =  $this->input->post('idbonentree');
        $namefile = "";

        if (isset($_FILES["file"])) {
            $uploadDir = "assets/back_office/pdf/b_reception/"; // Dossier où seront stockés les fichiers téléchargés
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
        
        $this -> BonEntree -> saveBonEntreeWithReceptionPdf($idbonentree, $namefile);
        redirect(base_url().'back_office/dep_logistique/BonEntreeController/getDetailEntree/'.$idbonentree);
    }

    // AJOUT DETAIL MATERIEL DANS LIVRAISON
    public function addDetailEntree(){
        $idbonentree =  $this->input->post('idbonentree');
        $idmateriel = $this->input->post('idmateriel');
        $qty = $this->input->post('qty');
        $remarque = $this->input->post('remarque');

        $this -> BonEntree -> saveDetailEntree($idbonentree, $idmateriel, $qty, $remarque);
        redirect(base_url().'back_office/dep_logistique/BonEntreeController/getDetailEntree/'.$idbonentree);
    }

    // CREATION BON DE RECEPTION
    public function createBonEntree(){
        $user = $this->session->userdata('user_data');
        $idreception = $this->input->post('idbonreception');
        $datereception = $this->input->post('dateentree');
        $id = $this-> BonEntree -> createMainBonEntree($idreception, $datereception, $user['idemployee']);
        
        redirect(base_url().'back_office/dep_logistique/BonEntreeController/getDetailEntree/'.$id);
    }

    // PRENDRE LE DETAIL D'UN BON D'ENTREE
    public function getDetailEntree($idbonentree){
        $data['be'] = $this -> BonEntree -> getBonEntreeById($idbonentree);
        $data['details'] = $this -> BonEntree -> getDetailEntree($idbonentree);
        $data['materiels'] = $this -> Materiel -> materiels();
        $data['content'] = 'back_office/dep_logistique/detail_entree';
        $this->load->view('back_office/main',$data);
    }

    // PRENDRE LA LISTE DES BON D'ENTREE
    public function getBonEntree(){
        $this-> BonEntree -> deleteCacheBonEntree();
        $data['bes'] = $this-> BonEntree -> getRecentBonEntree();
        $data['brs'] = $this -> BonReception -> getRecentBrNotAttached();
        $data['content'] = 'back_office/dep_logistique/liste_be';
        $this->load->view('back_office/main', $data);
    }
}
