<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('/../BaseSessionController.php');
class AmortissementController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
        $user = $this->session->userdata('user_data');
        $departement_finance =  $this->session->userdata('dep_finance');
        if($user['iddepartement'] != $departement_finance){
            redirect('back_office/LoginController/logout');
        }
        $this->load->model('back_office/dep_finance/Reception');
        $this->load->model('back_office/stock_option/Ecart');
    }


public function  amortissement(){
    date_default_timezone_set('Europe/Moscow');
    $produit = $this->Reception->voiture($_POST['produit']);
    $v_b = $produit['prix'];
    $taux = $produit['taux'];
    $utilisation1=new DateTime(date('2003-01-01'));
    $method = $produit['methode'];
    $taux = $this->transformTaux($taux);
    if($method ==0){
        
        $this->amortissement_lin( $v_b , $taux, $utilisation1);
    }else{
        $this->amortissement_deg($v_b , $taux);
    }

}
public function transformTaux($taux){
    // echo $taux/100;
    if($taux > 25){
$taux = 25;
    }
    if($taux < 25){
        $taux = 20;
    }
    return $taux/100;

}
    
    public function amortissement_lin( $v_b , $taux, $utilisation1){
        
        date_default_timezone_set('Europe/Moscow');
        // $v_b = 6000;
        // $taux = 0.25;
        // $utilisation1 =new DateTime(date('Y-01-01'));
        $periodes = 1 / $taux;
        echo $periodes;
        $periode = 1;
        $v_n_c = $v_b;
        $tab_amortissement = array();
        $annee = date("Y",strtotime($utilisation1->format('Y-m-d')));
        $fin_annee = new DateTime(date("Y-m-d", strtotime("$annee-12-31")));
        $difference_en_jours = $fin_annee->diff($utilisation1)->days;
        echo $difference_en_jours;
        if(!date('L', strtotime("$annee-12-31"))){
            $difference_en_jours = $difference_en_jours +1;

        }
        $tab_amortissement[] = array(
            'vb'=>$v_b,
            'acd'=>0,
            'taux' =>$taux,
            'dotation' => $difference_en_jours * (($v_b * $taux) / 365),
            'acf' => $difference_en_jours * (($v_b * $taux) / 365),
            'vnc' => $v_b - $difference_en_jours * (($v_b * $taux) / 365),
            'periode' => $periode ,
        );
        $periode++;
        
        while ($periodes - $periode > -1) {
            $tab_amortissement[] = array(
                'vb' => $v_b,
                'taux' =>$taux,
                'acd' => $tab_amortissement[count($tab_amortissement) - 1]['acf'],
                'dotation' => $v_b * $taux,
                'acf' => $tab_amortissement[count($tab_amortissement) - 1]['acf'] + $v_b * $taux,
                'vnc' => $v_b - ($tab_amortissement[count($tab_amortissement) - 1]['acf'] + $v_b * $taux),
                'periode' =>  $periode ,
            );
            $periode++;
        }
        
        $data['amortissement'] = $tab_amortissement;
        $data['content'] = 'back_office/dep_finance/amortissement';
        $this->load->view('back_office/main', $data);
    }
    public function amortissement_lin_with_dotation( $v_b ,$debut ,$taux, $dotation,$periodes,$periode){
        $v_n_c = $v_b;
        $tab_amortissement = array();
        $tab_amortissement[] = array(
            'vb'=>$v_b,
            'acd'=>$debut,
            'taux' =>$taux,
            'dotation' => $dotation,
            'acf' => $debut+$dotation,
            'vnc' => $v_b - ($debut+$dotation),
            'periode' => $periode ,
        );
        $periode++;
        echo $periodes - $periode;
        while ($periodes - $periode >0 ) {
            $tab_amortissement[] = array(
                'vb' => $v_b,
                'taux' =>$taux,
                'acd' => $tab_amortissement[count($tab_amortissement) - 1]['acf'],
                'dotation' => $dotation,
                'acf' => $tab_amortissement[count($tab_amortissement) - 1]['acf'] + $dotation,
                'vnc' => $v_b - ($tab_amortissement[count($tab_amortissement) - 1]['acf'] +$dotation),
                'periode' => $periode ,
            );
            $periode++;
        }
        
        return $tab_amortissement;
    }
    public function get_taux_deg($taux_lin){

        if( $taux_lin >= 0.17 && $taux_lin <= 0.25){
            return 1.75*$taux_lin;
        }
        return 2.25*$taux_lin;

    }
    public function amortissement_deg($v_b , $taux){
        // 
        date_default_timezone_set('Europe/Moscow');

        // $v_b = 100000;
        // $taux = 0.25;
        $taux_deg = $this->get_taux_deg($taux);
        $periodes = 1 / $taux;
        $periode = 1;
        $v_n_c = $v_b;
        $tab_amortissement = array();
        $tab_amortissement[] = array(
            'vb'=>$v_b,
            'taux' =>$taux,
            'acd'=>0,
            'dotation' => 0,
            'acf' => 0,
            'vnc' => $v_b ,
            'periode' => $periode 
        );
        $periode++;
        
        while ($periodes - $periode > -1) {
            if(($tab_amortissement[count($tab_amortissement) - 1]['vnc'] / ($periodes - $periode))> ($tab_amortissement[count($tab_amortissement) - 1]['vnc']* $taux_deg)){
                $array = $this->amortissement_lin_with_dotation( $v_b ,$tab_amortissement[count($tab_amortissement) - 1]['acf'],$taux, ($tab_amortissement[count($tab_amortissement) - 1]['vnc'] / ($periodes - $periode)),$periodes,$periode);
                $tab_amortissement = array_merge($tab_amortissement , $array);
                break;
            }
            $tab_amortissement[] = array(
                'vb' => $v_b,
                'taux' =>$taux,
                'acd' => $tab_amortissement[count($tab_amortissement) - 1]['acf'],
                'dotation' => $tab_amortissement[count($tab_amortissement) - 1]['vnc']* $taux_deg,
                'acf' => $tab_amortissement[count($tab_amortissement) - 1]['acf'] + ($tab_amortissement[count($tab_amortissement) - 1]['vnc']* $taux_deg),
                'vnc' => $v_b - ($tab_amortissement[count($tab_amortissement) - 1]['acf'] + ($tab_amortissement[count($tab_amortissement) - 1]['vnc']* $taux_deg)),
                'periode' => $periode,
            );
            $periode++;
        }
        
        $data['amortissement'] = $tab_amortissement;
        $data['content'] = 'back_office/dep_finance/amortissement';
        $this->load->view('back_office/main', $data);
    }

}