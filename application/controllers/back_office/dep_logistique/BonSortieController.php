<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class BonSortieController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('user_data');
        $departemet_logistique =  $this->session->userdata('dep_logistique');
        if($user['iddepartement'] != $departemet_logistique){
            redirect('back_office/LoginController/logout');
        }

        $this->load->model('back_office/dep_logistique/BonSortie');
        $this->load->model('back_office/achat/Materiel');
    }

    // PRINT BR
    public function printBonSortie($idbonsortie){
        $data['sortie'] = $this -> BonSortie -> getBonSortieById($idbonsortie);
        $data['details'] = $this -> BonSortie -> getDetailSortie($idbonsortie);
        $data['content'] = 'back_office/dep_logistique/apercu_sortie';
        $this->load->view('back_office/main',$data);
    }

    // APERCU DU PDF BON DE SORTIE
    public function apercu_bs($path){
        $document_path = "assets/data_company/bon_sortie/" . $path;
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . basename($document_path) . '"');
        readfile($document_path);
        exit;
    }

    // ENREGISTRER B.S
    public function saveBonSortie(){
        $user = $this->session->userdata('user_data');
        $idbonsortie =  $this->input->post('idbonsortie');
        date_default_timezone_set('Indian/Antananarivo');

        if (isset($_FILES["file"])) {
            $uploadDir = "assets/data_company/bon_sortie/"; // Dossier où seront stockés les fichiers téléchargés
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
        
        $this -> BonSortie -> saveBonEntreeWithPdf($idbonsortie, $namefile, $user['idemployee']);
        redirect(base_url().'back_office/dep_logistique/BonSortieController/getDetailSortie/'.$idbonsortie);
    }

    // AJOUT DETAIL MATERIEL DANS LIVRAISON
    public function addDetailSortie(){
        $idbonsortie =  $this->input->post('idbonsortie');
        $idmateriel = $this->input->post('idmateriel');
        $qty = $this->input->post('qty');
        $remarque = $this->input->post('remarque');

        $status = $this -> BonSortie -> saveDetailSortie($idbonsortie, $idmateriel, $qty, $remarque);
        if($status['succes'] == 0){
            $data['sortie'] = $this -> BonSortie -> getBonSortieById($idbonsortie);
            $data['details'] = $this -> BonSortie -> getDetailSortie($idbonsortie);
            $data['materiels'] = $this -> Materiel -> materiels();
            $data['error'] = $status;
            $data['content'] = 'back_office/dep_logistique/detail_Sortie';
            $this->load->view('back_office/main',$data);
        } else {
            redirect(base_url().'back_office/dep_logistique/BonSortieController/getDetailSortie/'.$idbonsortie);
        }  
    }

    // CREATION BON DE RECEPTION
    public function createBonSortie(){
        $user = $this->session->userdata('user_data');
        $iddepartement = $this->input->post('iddepartement');
        $datesortie = $this->input->post('datesortie');
        $id = $this-> BonSortie -> createMainBonSortie($iddepartement, $datesortie, $user['idemployee']);
        
        redirect(base_url().'back_office/dep_logistique/BonSortieController/getDetailSortie/'.$id);
    }

    // PRENDRE LE DETAIL D'UN BON D'Sortie
    public function getDetailSortie($idbonsortie){
        $data['sortie'] = $this -> BonSortie -> getBonSortieById($idbonsortie);
        $data['details'] = $this -> BonSortie -> getDetailSortie($idbonsortie);
        $data['materiels'] = $this -> Materiel -> materiels();
        $data['content'] = 'back_office/dep_logistique/detail_Sortie';
        $this->load->view('back_office/main',$data);
    }

    // PRENDRE LA LISTE DES BON D'Sortie
    public function getBonSortie(){
        $this-> BonSortie -> deleteCacheBonSortie();
        $this->load->model('back_office/Employee_model');
        $data['sorties'] = $this-> BonSortie -> getRecentBonSortie();
        $data['departements'] = $this -> Employee_model -> getAllDepartements();
        $data['content'] = 'back_office/dep_logistique/liste_sorties';
        $this->load->view('back_office/main', $data);
    }

    // GET AN UPDATE ETAT DE STOCK -> INPUT SELECT
    public function getEtatStock(){
        $idmateriel = $this -> input -> get('id');
        $this->load->model('back_office/stock_option/Stock');
        date_default_timezone_set('Indian/Antananarivo');
        $currentDateTime = date('Y-m-d');
        $etat = $this -> Stock -> etat_stock_materiel($idmateriel, $currentDateTime);
        $responseData = array(
            'stockQuantity' => $etat['qty'],
            'unityValue' => $etat['nomunite']
        );


        header('Content-Type: application/json');
        echo json_encode($responseData);
    }
}
