<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Bandcommande extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->model('Back_office/achat/Materiel');
        $this->load->model('Back_office/Fournisseur_model');
    }

    // PRENDRE LES BONS DE COMMANDES ENVOYES
    public function getBonCommandeSent(){
        $this->db->select('*');
        $this->db->from('v_bon_commande_general');
        $this->db->where('status >=', 2);
        $this->db->order_by('datecommande', 'DESC');
        $query = $this->db->get();
        return $query->result_array();
    }


    // CHIFFRE EN LETTRE
    public function chiffreEnLettre($nombre) {
        $formatter = new NumberFormatter('fr_FR', NumberFormatter::SPELLOUT);
        return $formatter->format($nombre);
    }

    // ----- DSI
    public function getCommandeForAdjoint(){
        $this->db->select('*');
        $this->db->from('v_bon_commande_general');
        $this->db->where('status >=', 1);
        $query = $this->db->get();
        return $query->result_array();
    }

    // ------ FINANCE
    public function getCommandeForFinance(){
        $this->db->select('*');
        $this->db->from('v_bon_commande_general');
        $this->db->where('status >=', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    // PRENDRE LES GLOBAL QUI ONT DES B.C
    public function getBesoinHasBc(){
        $this->db->select('*');
        $this->db->from('v_global_general');
        $this->db->where('status >=', 1);
        $this->db->order_by('date', 'DESC');
        $query = $this->db->get();

        return $query->result_array();
    }

    // PRENDRE LES BON DE COMMANDES PAR ID_GLOBAL
    public function getBonCommandePerGlobal($idglobal){
        $this->db->select('*');
        $this->db->from('v_bon_commande_general');
        $this->db->where('idglobal', $idglobal);
        $query = $this->db->get();
        $data = $query->result_array();

        $result = array();
        for($i = 0; $i < count($data); $i++){
            $result[$i] = $data[$i];
            $temp = $this -> commande_status($data[$i]['status']);
            $result[$i]['my_status'] = $temp;
        }
        return $result;
    }

    // GET STATUS
    public function commande_status($situation){
        $donnes = array("Attente validation Chef Finance", "Attente validation Adjoint", "Attente envoie", "Bon Commande Envoye");
        $progress = (($situation + 1) / count($donnes)) * 100;
        $result = array();
        $result[] = $donnes[$situation];
        $result[] = $progress;
        return $result;
    }

    public function bandcommande($idglobal) {
        $query = sprintf("SELECT SUM(qte) as qte, idmateriel,idglobal FROM v_globalcomplete  WHERE status =0 AND idglobal='%s' GROUP BY idmaterieL,idglobal ",$idglobal);
        $result = $this->db->query($query);
        // var_dump($result);
    
        if ($result->num_rows() > 0) {
            $rows = $result->result_array(); // Récupère un tableau d'objets
            $result = array();
            for($i = 0; $i < count($rows); $i++){
                $result[$i] = $rows[$i];
                $result[$i]['materiel'] = $this->Materiel->getMaterielById($rows[$i]['idmateriel']);
                $indice =0; 
                
                $reste = $result[$i]['qte'];
                $moves = $this->correspondingproforma($rows[$i]['idmateriel'], $rows[$i]['idglobal']);
                while ($reste > 0){
                    if(count($moves)>$indice){
                       
                        if($reste - $moves[$indice]['qte'] < 0){
                            $moves[$indice]['qte'] = $reste;
                            $reste =0;
                        }else{
                            $reste = $reste - $moves[$indice]['qte'];
                        }
                        $result[$i]['proforma'][] = $moves[$indice];
                        $indice ++;
                    }else{
                        break;
                    }
                }    
                
            }
            
            $ind =0;
            $indice =0;
            $fournisseurs= $this->Fournisseur_model->get_all_fournisseurs() ;
            for($j = 0; $j < count($fournisseurs); $j++){
                $indice =0;
                for($i = 0; $i < count($result); $i++){
                    if(isset($result[$i]['proforma'])){
                        for($u = 0; $u < count($result[$i]['proforma']); $u++){
                            if($result[$i]['proforma'][$u]['idfournisseur']== $fournisseurs[$j]['idfournisseur']){
                                $fournisseurs[$j]['bandcommande'][$indice] = $result[$i];
                                $fournisseurs[$j]['bandcommande'][$indice]['proforma'] = $result[$i]['proforma'][$u];
                                $indice++;
                            }
                        }
                    }
                }        
            }
            // var_dump($fournisseurs);
            $fournisseurFinal =array();
            for($j = 0; $j < count($fournisseurs); $j++){
            if(isset($fournisseurs[$j]['bandcommande'])){
                $fournisseurs[$j]['sum'] =0;
                for($u =0 ; $u < count($fournisseurs[$j]['bandcommande']) ;$u++ ){ 
                    $fournisseurs[$j]['bandcommande'][$u]['proforma']["ht"] = $fournisseurs[$j]['bandcommande'][$u]['proforma']["pu"]* $fournisseurs[$j]['bandcommande'][$u]['proforma']["qte"];
                    $fournisseurs[$j]['bandcommande'][$u]['proforma']["ttc"] = $fournisseurs[$j]['bandcommande'][$u]['proforma']["pu"]+( ($fournisseurs[$j]['bandcommande'][$u]['proforma']["tva"]*$fournisseurs[$j]['bandcommande'][$u]['proforma']["pu"])/100);
                    $fournisseurs[$j]['bandcommande'][$u]['proforma']["totalttc"] =$fournisseurs[$j]['bandcommande'][$u]['proforma']["ttc"] * $fournisseurs[$j]['bandcommande'][$u]['proforma']["qte"];
                    $fournisseurs[$j]['sum'] =  $fournisseurs[$j]['sum']+$fournisseurs[$j]['bandcommande'][$u]['proforma']["totalttc"];
                    
                }
                $fournisseurFinal[]= $fournisseurs[$j];
            }
        }
            // 
            // var_dump($fournisseurFinal[0]['bandcommande']);
            return $fournisseurFinal; // Retourne le tableau modifié d'objets
        } else {
            return array(); // Retourne un tableau vide si aucune ligne n'est trouvée
        }
    }


    public function correspondingproforma($idmateriel,$idglobal) {

        $query = sprintf(" select * from v_proformacomplete where idmateriel ='%s' AND idglobal = '%s' AND status = 2 order by pu asc", $idmateriel, $idglobal);
        $result = $this->db->query($query);
    
        if ($result->num_rows() > 0) {
            $rows = $result->result_array(); // Récupère un tableau d'objets
            $result = array();
            for($i = 0; $i < count($rows); $i++){
                $result[$i] = $rows[$i];
                $result[$i]['materiel'] = $this->Materiel->getMaterielById($rows[$i]['idmateriel']);
            }   
            return $result; // Retourne le tableau modifié d'objets
        } else {
            return array(); // Retourne un tableau vide si aucune ligne n'est trouvée
        }
    }


    public function updatestatus($id){
        $data['status'] = 1;
        $this->db->update('global', $data, array('idglobal' => $id));
    }


    public function getBoncommandes(){
        $query = $this->db->get('global');
        return $query->result_array();
    }
    
    public function getBoncommandesNonValid(){
        $this->db->select('*');
        $this->db->from('global');
        $this->db->where('status', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getBoncommandesOnceValid(){
        $this->db->select('*');
        $this->db->from('boncommande');
        // $this->db->order_by('status', 'asc');
        $this->db->where('status', 0);
        $query = $this->db->get();
        return $query->result_array();
    }


    public function createBoncommande($idglobal) {
        $this->db->trans_start();
        $boncommandes = $this->Bandcommande-> bandcommande($idglobal);
       
        foreach($boncommandes as $boncommande){
            $query = $this->db->query("SELECT nextval('seq_commande')");
            $row = $query->row_array();
            $sequence_value = $row['nextval'];
            $id = 'COM_' . $sequence_value;
            $data['idboncommande'] = $id;
                $data['idfournisseur'] = $boncommande['idfournisseur'];
                $data['total'] = $boncommande['sum'];
                $data['idglobal'] = $idglobal;
                $data['validationfinance'] = 0;
                $data['validationadjoint'] = 0;
               
                $this->db->insert('boncommande', $data);
            foreach($boncommande['bandcommande'] as $detail){
                // var_dump($detail);
                $this->createdetail($detail,$id);
            }
            $this->updateGlobal(1,$idglobal);
            $this->db->trans_complete(); 
        }
    }


    public function createdetail($detail,$id){
            $data['qte'] = $detail['proforma']["qte"];
            $data['idmateriel']= $detail['materiel']["idmateriel"];
            $data['pu'] = $detail['proforma']['pu'];
            $data['montantht'] = $detail['proforma']['ht'];
            $data['montantttc'] = $detail['proforma']['totalttc'];
            $data['idboncommande'] = $id;
            $this->db->insert('detailcommande', $data);
    
    }

    
    public function updateGlobal($status,$idglobal){
        $data['status'] = $status;
        $this->db->update('global', $data, array('idglobal' => $idglobal));
    }

    // PRENDRE LES BONS COMMANDES PAR STATUS
    public function getCommandes(){
        $this->db->select('*');
        $this->db->from('boncommande');
        $this->db->order_by('status', 'asc');
        // $this->db->where('status', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    // PRENDRE LE DETAILS DES BON DE COMMANDES
    public function getCommandesComplete($id){
        $this->db->select('*');
        $this->db->from('v_commandes');
        $this->db->where('idboncommande', $id);
        
        $query = $this->db->get();
        return $query->result_array();
    }
    public function validate($commande, $status){
        date_default_timezone_set('Europe/Moscow') ;
        $data['status'] = $status;
        $data['datecommande'] = date('Y-m-d');
        $this->db->update('boncommande', $data, array('idboncommande' => $commande));
    }

    public function lastvalidation($commande, $status){
        date_default_timezone_set('Europe/Moscow') ;
        $data['status'] = $status;
        // $data['datecommande'] = date('Y-m-d');
        $this->db->update('boncommande', $data, array('idboncommande' => $commande));
    }
}