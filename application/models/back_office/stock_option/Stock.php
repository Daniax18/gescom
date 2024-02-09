<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stock extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->model('Back_office/achat/Materiel');
        $this->load->model('Back_office/stock_option/Inventaire_General');
    }

    // Faire une demande general des marchandises en manque
    public function makeDemandeAchatMateriel($date, $idemployee, $iddepartement){
        $materiels = $this -> getLackOfMateriels($date);
        $this->load->model('Back_office/achat/Besoin');

        $this->db->trans_start(); // Start a transaction
        $idbesoin = $this -> Besoin -> createBesoin($iddepartement, $idemployee);
        foreach($materiels as $materiel){
            $this -> Besoin -> addDetailBesoin($idbesoin, $materiel['idmateriel'], $materiel['qty_to_ask']); 
        }

        $this->db->trans_complete(); // Complete the transaction
        return $idbesoin;
    }

    // GET MARCHANDISES OU LE STOCK < STOCK ALERTE
    public function getLackOfMateriels($date){
        $stocks = $this -> get_all_etat_stock($date);
        $idmateriels = array();
        foreach($stocks as $stock){
            if($stock['etat']['qty'] < $stock['materiel']['stock_alerte']){
                $idmateriels[] = array(
                    'idmateriel' => $stock['etat']['idmateriel'],
                    'qty_to_ask' => $stock['materiel']['stock_alerte']
                );
            }
        }
        return $idmateriels;
    }

    // ETAT DE STOCK D'UN PRODUIT WITH STOCK ALERT AND MINIMUM
    public function get_etat_stock_product($idmateriel, $date){
        $materiel = $this -> Materiel -> getMaterielDetailById($idmateriel);
        $result = array(
            'etat' => $this -> etat_stock_materiel($idmateriel, $date),
            'materiel' => $materiel
        );
        return $result;
    }

    // GET ETAT STOCK 
    public function get_all_etat_stock($date){
        $materiels = $this -> Materiel -> materiel_stocks();
        $result = array();
        foreach($materiels as $materiel){
            $result[] = array(
                'etat' => $this -> etat_stock_materiel($materiel['idmateriel'], $date),
                'materiel' => $materiel
            );
        }
        return $result;
    }

    // GET VALEUR DU TOTAL VALEUR EN STICK
    public function getTotalValueEnStock($date){
        $result = array();
        $details = $this -> get_all_etat_stock($date);
        $ttc = 0;
        $ht = 0;
        foreach($details as $detail){
            $ttc += $detail['etat']['montant_ttc'];
            $ht += $detail['etat']['montant_ht'];
        }
        $result[] = $ht;
        $result[] = $ttc;
        return $result;
    }


    // MAKE A SORTIE CLIENT
    public function make_sortie($idmateriel, $qty, $date, $idemployee, $unitpricesortie, $iddepartement){
        $query = $this->db->query("SELECT nextval('seq_stock_sortie')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'ST_S_' . $sequence_value;
        $data['idstocksortie'] = $id;
        $data['idmateriel'] = $idmateriel;
        $data['datesortie'] = $date;
        $data['quantity'] = $qty;
        $data['unitpricesortie'] = $unitpricesortie;
        $data['idemployee'] = $idemployee;
        $data['iddepartement'] = $iddepartement;

        $this->db->insert('stock_sortie', $data);
        return $id;
    }

    // CHECK IF POSSIBLE MAKE A SORTIE 
    public function can_make_sortie($idmateriel, $qty, $date){
        $etat = $this -> etat_stock_materiel($idmateriel, $date);
        // var_dump($etat);
        $result = array();
        $result['unit_sell'] = $this -> Materiel -> get_materiel_unit_price_sell($idmateriel);
        // echo $result['unit_sell'];
        if($etat['qty'] < $qty){
            $result['can_make'] = false;
            $result['qty'] = $etat['qty'];
        } else {
            $result['can_make'] = true;
            $result['qty'] = $qty;
        }
        // var_dump($result);
        return $result;
    }

    // CHECK ETAT STOCK D'UN PRODUIT
    public function etat_stock_materiel($idmateriel, $date){
        $data = array();
        $materiel = $this -> Materiel -> getMaterielDetailById($idmateriel);
        $pu = $this -> get_stock_unit_price($idmateriel, $date);
        // var_dump($pu);
        $sum_sortie = $this -> get_sum_stock_sorties($idmateriel, $date);
        $qty_left = $pu['qty_entree'] - $sum_sortie;
        $montant_ht = $pu['pu'] * $qty_left;
        $montant_ttc = ($montant_ht * 0.2) + $montant_ht;

        $data['idmateriel'] = $idmateriel;
        $data['nommateriel'] = $materiel['nommateriel'];
        $data['nomunite'] = $materiel['nomunite'];
        $data['namestockage'] = $materiel['namestockage'];
        $data['date'] = $date;
        $data['pu'] = $pu['pu'];
        $data['qty'] = $qty_left;
        $data['montant_ht'] = $montant_ht;
        $data['montant_ttc'] = $montant_ttc;
        if($qty_left < $materiel['stock_minimum']){
            $data['icon'] = '<i class="link-icon" style="fill: red; color: red; width: 60%" data-feather="flag"></i>';
        } else if($qty_left < $materiel['stock_alerte']){
            $data['icon'] = '<i class="link-icon" style="color: orange;  width: 60%" data-feather="flag"></i>';
        }

        return $data;
    }

    // PRENDRE LE PRIX UNITAIRE D'UN MATERIEL AVEC LE TOTAL DES ENTREES
    public function get_stock_unit_price($idmateriel, $date){
        $last_detail_inventaire = $this -> Inventaire_General -> getPreviousMaterialInventaire($idmateriel, $date); 
        $entries = $this -> get_entries($idmateriel, $date);

        $sum_stock = $last_detail_inventaire['qty_inventaire'];
        $pu = $last_detail_inventaire['pu_materiel'];
        $montant = $sum_stock * $pu;
        if($this -> Materiel -> is_cmup($idmateriel) == true){        
            foreach($entries as $entrie){
                $montant += $entrie['montant_ht'];
                $sum_stock += $entrie['quantity'];
            }
        } else {
            foreach($entries as $entrie){
                $montant += $entrie['unitpriceentree'] * $entrie['availability'];
                $sum_stock += $entrie['quantity'];
            }
        }
        $result = array();
        if($sum_stock == 0){
            $result['pu'] = 0;
            $result['qty_entree'] = $sum_stock;
        } else {
            $result['pu'] = $montant/$sum_stock;
            $result['qty_entree'] = $sum_stock;
        }

        return $result;
    }

    // PRENDRE SOMME DES SORTIES
    public function get_sum_stock_sorties($idmateriel, $date){
        $sorties = $this -> get_sorties($idmateriel, $date);
        $sum_stock = 0;
        foreach($sorties as $sortie){
            $sum_stock += $sortie['quantity'];
        }
        return $sum_stock;
    }


    // PRENDRE LE TOTAL SORTIE D'UN MATERIEL
    public function get_sorties($idmateriel, $date){
        $last_inventaire = $this -> Inventaire_General -> getPreviousInventaire($date);
        $this->db->select('*');
        $this->db->from('stock_sortie');
        $this->db->where('idmateriel', $idmateriel);
        if($last_inventaire != null){
            $this->db->where('datesortie > ', $last_inventaire['dateinventaire']);
        }
        $this->db->where('datesortie <= ', $date);
        $query = $this->db->get();

        return $query->result_array();
    }

    // PRENDRE LE TOTAL ENTREE D'UN MATERIEL
    public function get_entries($idmateriel, $date){
        // Last inventaire
        $last_inventaire = $this -> Inventaire_General -> getPreviousInventaire($date);

        $order = 'DESC';
        if($this -> Materiel -> is_fifo($idmateriel) == true) $order = 'ASC';

        $this->db->select('*');
        $this->db->from('stock_entree');
        $this->db->where('idmateriel', $idmateriel);
        if($last_inventaire != null){
            $this->db->where('dateentree > ', $last_inventaire['dateinventaire']);
        }
        $this->db->where('dateentree <= ', $date);
        $this->db->order_by('dateentree', $order);
        $query = $this->db->get();

        return $query->result_array();
    }

    // INSERTION ENTREE DE PRODUIT
    public function insert_stock_entree($idmateriel, $pu_ht, $date, $qty, $montant_ht, $montant_ttc){
        $query = $this->db->query("SELECT nextval('seq_stock_entree')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'ST_E_' . $sequence_value;
        $data['idstockentree'] = $id;
        $data['idmateriel'] = $idmateriel;
        $data['dateentree'] = $date;
        $data['quantity'] = $qty;
        $data['unitpriceentree'] = $pu_ht;
        $data['montant_ht'] = $montant_ht;
        $data['montant_ttc'] = $montant_ttc;
        $data['availability'] = $qty;
        $data['idemployee'] = 'EMP13';  // TSY METY MINTSY 

        $this->db->insert('stock_entree', $data);
        return $id;
    }


    // PRENDRE LES SORTIES ENTRE 2 DATES
    public function get_sorties_between_dates($idmateriel, $date1, $date2){
        $this->db->select('*');
        $this->db->from('stock_sortie');
        $this->db->where('idmateriel', $idmateriel);
        $this->db->where('datesortie > ', $date1);
        $this->db->where('datesortie <= ', $date2);
        $query = $this->db->get();

        return $query->result_array();
    }


    // PRENDRE LES ENTREES ENTRE 2 DATES
    public function get_entries_between_dates($idmateriel, $date1, $date2){
        $this->db->select('*');
        $this->db->from('stock_entree');
        $this->db->where('idmateriel', $idmateriel);
        $this->db->where('dateentree > ', $date1);
        $this->db->where('dateentree <= ', $date2);
        $query = $this->db->get();

        return $query->result_array();
    }
    
}