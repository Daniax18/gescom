<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class ReceptionController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('user_data');
        $departement_finance =  $this->session->userdata('dep_finance');
        $departement_logistique =  $this->session->userdata('dep_logistique');
        if($user['iddepartement'] != $departement_finance &&  $user['iddepartement'] != $departement_logistique){
            // redirect('back_office/LoginController/logout');
        }
        $this->load->model('back_office/dep_logistique/Station');
        $this->load->model('back_office/dep_finance/Reception');
        $this->load->model('back_office/dep_logistique/Utilisation');
        $this->load->model('back_office/dep_logistique/Papier');
    }
    // replace 
    public function getPV(){
        $data['pv'] = $this->Reception->getPV();
        $data['content'] = 'back_office/dep_logistique/reception';
        $data['employee'] = $this->Reception->getAllEmployee();
        $this->load->view('back_office/main', $data);
    }
     // replace    
    public function getPVError($error){
        $data['error'] = $error;
        $data['pv'] = $this->Reception->getPV();
        $data['employee'] = $this->Reception->getAllEmployee();
        $data['content'] = 'back_office/dep_logistique/reception';

        $this->load->view('back_office/main', $data);
    }




    public function getDetailEtat(){
       $idvoiture =  $_POST['voiture'];
        echo  json_encode($this->Reception->getDetailEtat($idvoiture));
       
    }
    public function getEtat(){
        $idvoiture =  $_GET['voiture'];
        $data['etat']= $this->Reception->getDetailEtatWithPrecision($idvoiture);
        $data['content'] = 'back_office/dep_logistique/etat';
        $this->load->view('back_office/main', $data);

     }
     public function getEtatGlobal(){
        $data['etat'] =$this->Reception->getDetailEtatWithPrecisionGlobal();
        // var_dump();
         $data['content'] = 'back_office/dep_logistique/etatGlobal';
         $this->load->view('back_office/main', $data);
    
     }
    public function insert(){
        $data =array();
        $data['idvoiture']= $_POST['idvoiture'];
        $data['idemployee']= $_POST['idemployee'];
        $data['debut_kilometrage']= $_POST['debut_kilometrage'];
        $data['fin_kilometrage']= $_POST['fin_kilometrage'];
        $data['motif']= $_POST['motif'];
        $data['debut']= $_POST['debut'];
        $data['fin']= $_POST['fin'];
        if($this->Reception->getFinKilometrage($_POST['idvoiture'])!=$_POST['debut_kilometrage'] ){
            redirect('back_office/dep_finance/ReceptionController/getPVError/incoherence_de_kilometrage');
        }

        if($this->Utilisation->getRoute($data['idvoiture'], $data['debut'] ) < ( $data['fin_kilometrage'] - $data['debut_kilometrage'])){
            redirect('back_office/dep_finance/ReceptionController/getPVError/faite_le_plein');
        }
        if($this->Utilisation->isUsed( $data['idvoiture'],$data['debut'],$data['fin'] )){
            redirect('back_office/dep_finance/ReceptionController/getPVError/date_deja_pris');
        }
        $this->Utilisation->insert($data);
        $this->getPV();
    }






    // replace 
    public function insertCarburant(){
        $data =array();
        $data['idvoiture']= $_POST['idvoiture'];
        $data['idemployee']= $_POST['idemployee'];
        $data['litre']= $_POST['litre'];
        $data['idstation']= $_POST['idstation'];
        $data['date']= $_POST['date'];
        $this->Station->insert($data);
        redirect('back_office/dep_finance/ReceptionController/getCarburantContinue/'.$_POST['idvoiture']);
    }




    public function insertVoiture(){
        $data =array();
        $data['idmodele']= $_POST['idmodele'];
        $data['kilometrage']= $_POST['kilometrage'];
        $data['consommation']= $_POST['consommation'];
        $data['matricule']= $_POST['matricule'];
        $data['prix']= $_POST['prix'];
        $data['taux']= $_POST['taux'];
        $data['methode']= $_POST['methode'];
        $voiture =  $this->Reception->insertVoiture($data);
        $voiture ="VTR_".$voiture;
        $detail = $_POST['detail'];
        $value = $_POST['value'];
        for ($i=0; $i <count($detail) ; $i++) { 
           if($value[$i] >0){
            $data =array();
            $data['iddetail_categorie']= $detail[$i];
            $data['valeur']= $value[$i];
            $data['idvoiture'] = $voiture;
                $this->Reception->insertEtat($data);
           }
        }
        
        $this->getPV();
    }



        // replace 
    public function insertPapier(){
        $data =array();
        $data['idvoiture']= $_POST['idvoiture'];
        $data['idemployee']= $_POST['idemployee'];
        $data['idpapier']= $_POST['idpapier'];
        $data['date_debut']= $_POST['date_debut'];
        $data['date_fin']= $_POST['date_fin'];
        $this->Papier->insert($data);
        redirect('back_office/dep_finance/ReceptionController/getPapierContinue/'.$_POST['idpapier'].'/'.$_POST['idvoiture']);
    }
        // replace 
    public function getCarburant(){
        $data['station'] = $this->Station->getAll();
        $data['employee'] = $this->Reception->getAllEmployee();
        $data['carburant'] = $this->Station->getCarburant($_POST['voiture']);
        $data['voiture'] = $this->Reception->voiture($_POST['voiture']);
        $data['content'] = 'back_office/dep_logistique/carburant';
        $this->load->view('back_office/main', $data);
    }
        // replace 
    public function getCarburantContinue($idvoiture){
        $data['station'] = $this->Station->getAll();
        $data['employee'] = $this->Reception->getAllEmployee();
        $data['carburant'] = $this->Station->getCarburant($idvoiture);
        $data['voiture'] = $this->Reception->voiture($idvoiture);
        $data['content'] = 'back_office/dep_logistique/carburant';
        $this->load->view('back_office/main', $data);
    }
        // replace 
    public function getPapier(){
        $data['papierView'] = $this->Papier->papier($_POST['papier']);
        $data['employee'] = $this->Reception->getAllEmployee();
        $data['papier'] = $this->Papier->getPapier($_POST['voiture'],$_POST['papier']);
        $data['content'] = 'back_office/dep_logistique/papier';
        $data['voiture'] = $this->Reception->voiture($_POST['voiture']);
        $this->load->view('back_office/main', $data);
    }
        // replace 
    public function getPapierContinue($papier,$voiture){
        $data['papierView'] = $this->Papier->papier($papier);
        $data['employee'] = $this->Reception->getAllEmployee();
        $data['papier'] = $this->Papier->getPapier($voiture,$papier);
        $data['content'] = 'back_office/dep_logistique/papier';
        $data['voiture'] = $this->Reception->voiture($voiture);
        $this->load->view('back_office/main', $data);
    }
}