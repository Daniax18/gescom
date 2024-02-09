<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proforma extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('back_office/dep_achat/BesoinAchat');
    }

    // GET PROFORMAS PAR RAPPORT A UN GLOBAL
    public function getProformaPerGlobal($idglobal){
        $this->db->select('*');
        $this->db->from('v_proformafournisseur');
        $this->db->where('status >=', 0);
        $this->db->where('idglobal', $idglobal);
        $query = $this->db->get();

        $data = $query->result_array();
        
        $result = array();
        for($i = 0; $i < count($data); $i++){
            $result[$i] = $data[$i];
            $result[$i]['status'] = $this -> my_status($data[$i]['status']);
        }
        return $result;
    }

       // PRENDRE LE STATUS D'UN BESOIN
    public function my_status($situation){
        $donnes = array("Cree", "Sent", "Received");
        $progress = (($situation + 1) / count($donnes)) * 100;
        $result = array();
        $result[] = $donnes[$situation];
        $result[] = $progress;
        return $result;
    }

    // GET PROFORMA PAR SUPPLIER DANS UN IDGLOBAL
    public function getDetailProformaPerSupplier($idglobal, $idfournisseur){
        $this->db->select('*');
        $this->db->from('v_proforma_detail');
        $this->db->where('idglobal', $idglobal);
        $this->db->where('idfournisseur', $idfournisseur);
        $query = $this->db->get();

        return $query->result_array();
    }

    // CREER LE PROFORMA D'UN GLOBAL
    public function createProformaOfGlobal($idglobal){
        $this->load->model('back_office/achat/Materiel');
        $materiels = $this -> BesoinAchat -> getDetailGlobalMateriel($idglobal);    // Les materiels d'un global

        $this->db->trans_start();

        $proformas = $this -> createProformasFromSuppliers($idglobal);  // Liste des proformas creer % suppliers concernEs
        $this -> BesoinAchat -> updateGlobal($idglobal, 0);
        
        foreach($materiels as $materiel){
            $supplierConcerned = $this -> Materiel -> getSuppliersOfNature($materiel['idnature']);  // Liste des suppliers concernE pour ce nature specifique
            foreach($supplierConcerned as $supplier){
                $idproforma = $this -> getIdProformaOfProformas($proformas, $supplier['idfournisseur']);    // Prendre le idproforma pour chaque suppliers 
                $this -> createDetailProforma($idproforma, $materiel['idmateriel'], 0, $materiel['total'], 0);
            }
        }
        $this -> BesoinAchat -> updateStatusBesoins($idglobal, 3);
        $this->db->trans_complete();
    }


    // PRENDRE LE IDPROFORMA DANS UNE LISTE DE PROFORMAS
    public function getIdProformaOfProformas($proformas, $idsupplier){
        foreach($proformas as $proforma){
            if($proforma[0] == $idsupplier) return $proforma[1];
        }
        return null;
    }

    // CREER DES PROFORMAS A PARTIR DES FOURNISSEURS CONCERNES D'UN GLOBAL
    public function createProformasFromSuppliers($idglobal){
        $suppliers = $this -> getSuppliersConcerned($idglobal);
        // var_dump($suppliers);
        $result = array();
        foreach($suppliers as $supplier){
            $result[] = $this -> createGeneralProformaGlobal($idglobal, $supplier['idfournisseur']);
        }
        return $result;
    }

    // CREER DETAIL PROFORMA
    public function createDetailProforma($idproforma, $idmateriel, $pu, $qte, $totalmontant){
        $query = $this->db->query("SELECT nextval('seq_detailproforma')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'PRO_DET_' . $sequence_value;

        $data['iddetail'] = $id;
        $data['idproforma'] = $idproforma;
        $data['idmateriel'] =  $idmateriel;
        $data['pu'] = $pu;
        $data['qte'] =  $qte;
        $data['totalmontant'] = $totalmontant;

        $this->db->insert('detailproforma', $data);
    }

    // CREER GENERAL PROFORMA D'UN GLOBAL
    // RETOUR 0 -> IDFOURNISSEUR
    // 1 -> IDPROFORMA CREER
    public function createGeneralProformaGlobal($idglobal, $idfournisseur){
        $query = $this->db->query("SELECT nextval('seq_proforma')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'PRO_' . $sequence_value;

        $data['idproforma'] = $id;
        $data['idfournisseur'] = $idfournisseur;
        $data['idglobal'] =  $idglobal;
        $data['status'] = 0;

        $this->db->insert('proforma', $data);
        $result = array($idfournisseur, $id);
        return $result;
    }

    // PRENDRE DETAILS FOURNISSEUR CONCERNES
    public function getSuppliersDetailsConcerned($idglobal){
        $ids = $this -> getSuppliersConcerned($idglobal);
        $result = array();
        $this->load->model('back_office/achat/Materiel');
        foreach($ids as $id){
            $result[] = $this -> Materiel -> supplierById($id['idfournisseur']);
        }
        return $result;
    }

    // PRENDRE LES FOURNISSEURES CONCERNES
    public function getSuppliersConcerned($idglobal){
        $idnatures = $this -> getNaturesConcerned($idglobal);
        // var_dump($idnatures);
        if(count($idnatures) > 0){
            $this->db->select('idfournisseur');
            $this->db->from('fournisseur_nature');
            $this->db->where('idnature', $idnatures[0]['idnature']);
            if(count($idnatures) >= 2){
                for($i = 1; $i < count($idnatures); $i++){
                    $this->db->or_where('idnature',  $idnatures[$i]['idnature']);
                }
            }
            $this->db->group_by('idfournisseur');
            $query = $this->db->get();
        }

        return $query->result_array();
    }

    // PRENDRE LES NATURES ID D'UN GLOBAL
    public function getNaturesConcerned($idglobal){
        $query = sprintf("select t.idnature
        from (select v_besoin_detail.*, detailglobal.idglobal
        from detailglobal
        inner join v_besoin_detail on v_besoin_detail.idbesoin = detailglobal.idbesoin
        where detailglobal.idglobal = '%s') as t
        group by t.idnature", $idglobal);
        $sql = $this->db->query($query);
        $count = 0;

        foreach ($sql-> result_array() as $row){
            $count++;
            $result[] = $row; 
        }
        if($count == 0) return 0;
        return $result;
    }

    // PRENDRE LE STATUS D'UN BESOIN
    public function proforma_status($situation){
        $donnes = array("Proforma created", "Proforma sent to suppliers", "Proforma received");
        $progress = (($situation + 1) / count($donnes)) * 100;
        $result = array();
        $result[] = $donnes[$situation];
        $result[] = $progress;
        return $result;
    }

}