<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BandcommandeController extends CI_controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('Back_office/achat/Bandcommande');
    }

    // DEVALIDATION COMMDANDE PAR Adjoint
    public function devalidateCommandeAdjoint($idcommande){
        $this -> Bandcommande -> lastvalidation($idcommande, 1);
        redirect(base_url().'back_office/BandcommandeController/bonCommandeAdjoint');
    }

    // VALIDATION BC PAR Adjoint
    public function validateCommandeAdjoint($idcommande){
        $this -> Bandcommande -> lastvalidation($idcommande, 2);
        redirect(base_url().'back_office/BandcommandeController/bonCommandeAdjoint');
    }

    // LISTE DES BC  VALIDER POUR ADJOINT
    public function bonCommandeAdjoint(){
        $data['commandes'] =  $this -> Bandcommande -> getCommandeForAdjoint();
        $data['content'] = 'back_office/dep_info/list_bc_adjoint';
        $this->load->view('back_office/main',$data);
    }

    // LISTE DES BC A VALIDER POUR FINANCE
    public function bonCommandeFinance(){
        $data['commandes'] =  $this -> Bandcommande -> getCommandeForFinance();
        $data['content'] = 'back_office/dep_finance/list_bc_finance';
        $this->load->view('back_office/main',$data);
    }

    // PRENDRE LE B.C PAR 
    public function bonCommandePerId($idCommandes){
        $data['commande'] =  $this -> Bandcommande -> getCommandesComplete($idCommandes);
        $data['content'] = 'back_office/achat/commande';
        $this->load->view('back_office/main',$data);
    }

    // DEVALIDATION COMMDANDE PAR FINANCE
    public function devalidateCommandeFinance($idcommande){
        $this -> Bandcommande -> lastvalidation($idcommande, 0);
        redirect(base_url().'back_office/BandcommandeController/bonCommandeFinance');
    }

    // VALIDATION BC PAR FINANCE
    public function validateCommandeFinance($idcommande){
        $this -> Bandcommande -> lastvalidation($idcommande, 1);
        redirect(base_url().'back_office/BandcommandeController/bonCommandeFinance');
    }


    public function sendMail(){
        $global = $this->input->post("global[]");
        $count = $this->input->post("count");
        var_dump($global);
        echo $count;
        for($i = 0 ; $i < count($global); $i++){
        $this->Bandcommande->updatestatus($global[$i]);
        }
    }


    public function verificationcommande(){
        $data['boncommandes'] =  $this->Bandcommande-> bandcommande();
        $data['content'] = 'back_office/achat/validationcommande';
        $this->load->view('back_office/main',$data);
    }

    public function createBoncommande() {
        $idglobal =$this->input->post("global");
        $this->Bandcommande->createBoncommande($idglobal) ;
        redirect(base_url().'back_office/BandcommandeController/getBandCommande');
    }

    // RESPONSABLE ACHAT
    public function commandes(){
        $boncommandes = $this->Bandcommande->getCommandes();
        // var_dump($boncommandes);
        for($i=0;$i< count($boncommandes) ; $i++){
            // echo $boncommandes[$i]['idboncommande'];
            $data['commandes'][]=  $this->Bandcommande-> getCommandesComplete($boncommandes[$i]['idboncommande']);
            $data['commande'][]= $boncommandes[$i];
        }
        // var_dump( $data['commandes']);
        $data['content'] = 'back_office/achat/commande';
        $this->load->view('back_office/main',$data);
        
    }

    // LIST OF BON DE COMMANDES
    public function general_commandes(){
        $boncommandes = $this->Bandcommande->getBesoinHasBc();
        $data['globals'] =  $boncommandes;
        $data['content'] = 'back_office/dep_achat/liste_bc';
        $this->load->view('back_office/main',$data);
    }

    public function commandesOnce(){
        $boncommandes = $this->Bandcommande->getBoncommandesOnceValid();
        // var_dump($boncommandes);
        for($i=0;$i< count($boncommandes) ; $i++){
            echo $boncommandes[$i]['idboncommande'];
            $data['commandes'][]=  $this->Bandcommande-> getCommandesComplete($boncommandes[$i]['idboncommande']);
            $data['commande'][]= $boncommandes[$i];
        }
            // var_dump( $data['commandes']);
        $data['content'] = 'back_office/achat/commande_finance';
        $this->load->view('back_office/main',$data);
        
    }


    public function send($idcommande){
        $this->Bandcommande->validate($idcommande,1);
        redirect(base_url().'back_office/BandcommandeController/commandes');
    }

}

?>