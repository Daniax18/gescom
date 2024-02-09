<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Commande_client extends CI_Model {
    public function __construct(){
        parent::__construct();
        $this->load->model('Back_office/achat/Materiel');
        $this->load->model('Back_office/dep_vente/Customer');
    }

    // ENREGISTER COMMANDE ENVOYE AVEC PDF
    public function saveCommandeClientAccepted($idcommandeclient){
        $this -> updateStatusCommandeClient($idcommandeclient, 1);
    }
    
    // CALCULER LE TOTAL MONTANT D'UNE COMMANDE
    public function getTotalMontantCommandeClient($idcommandeclient){
        $sql = sprintf("SELECT SUM(montant_ht) as ht, SUM(montant_ttc) as ttc FROM detail_commande_client WHERE idcommandeclient = '%s'", $idcommandeclient);
        $query = $this->db->query($sql);

        $result = $query->row_array();
        return $result;
    }

    // GET RESULTAT D'UN COMMANDE
    public function getResultatCommande($idcommandeclient){
        $general = $this -> getCommandeClientById($idcommandeclient);
        $details = $this -> getDetailCommandeClient($idcommandeclient);
        $this->load->model('Back_office/stock_option/Stock');
        $error = array();

        $this->db->trans_start(); // Start a transaction

        foreach($details as $detail){
            // var_dump($detail);
            $move = $this -> Stock -> can_make_sortie($detail['idmateriel'], $detail['qty_request'], $general['date_commande_client_received']);
            if($move['can_make'] == false){
                $error[] = array(
                    'materiel' => $detail['nommateriel'],
                    'qty_lack' => $move['qty']
                );
            }
            // var_dump($move);
            $montant_ht = $move['unit_sell'] * $move['qty'];
            $montant_ttc = ($montant_ht * 0.2) + $montant_ht;
            $this -> updateCommandeClientDetail($detail['id_detail_commande_client'], $move['unit_sell'], $montant_ht, $montant_ttc); 
        }

        if(count($error) > 0){
            $this->db->trans_rollback(); // Rollback the transaction
            $this -> updateStatusCommandeClient($idcommandeclient, 9);
        }
        // var_dump($error);
        $this->db->trans_complete(); // Complete the transaction
        return $error;
    }

    // UPDATE UNIT_PRICE, MONTANT_HT AND MONTANT_TTC of COMMANDE
    public function updateCommandeClientDetail($id_detail_commande_client, $unit_price, $montant_ht, $montant_ttc){
        $query = sprintf("UPDATE detail_commande_client SET unit_price_ht = %f, montant_ht = %f, montant_ttc = %f WHERE id_detail_commande_client = '%s'", $unit_price, $montant_ht, $montant_ttc, $id_detail_commande_client);
        $sql = $this->db->query($query);
    }

    // SAVE MAIN COMMANDE CLIENT WITH PDF
    public function saveCommandeClientWithPdf($idcommandeclient, $file){
        $this->db->trans_start(); // Start a transaction
        $this -> savePdfCommandeClientReceived($idcommandeclient, $file);
        $this -> updateStatusCommandeClient($idcommandeclient, 0);
        $this->db->trans_complete(); // Complete the transaction
    }

    // GET THE PDF FILE FROM THE CLIENT
    public function savePdfCommandeClientReceived($idcommandeclient, $file){
        $query = sprintf("UPDATE commande_client SET pathjustificatif = '%s' WHERE idcommandeclient = '%s'", $file, $idcommandeclient);
        $sql = $this->db->query($query);
    }

    // UPDATE STATUS OF COMMANDE CLIENT
    public function updateStatusCommandeClient($idcommandeclient, $status){
        $query = sprintf("UPDATE commande_client SET status_commande_client = %u WHERE idcommandeclient = '%s'", $status, $idcommandeclient);
        $sql = $this->db->query($query);
    }

    // PRENDRE DETAIL COMMANDE CLIENT
    public function getDetailCommandeClient($idcommandeclient){
        $this->db->select('*');
        $this->db->from('v_detail_commande_client');
        $this->db->where('idcommandeclient', $idcommandeclient);
        $query = $this->db->get();
        return $query->result_array();
    }

    // PRENDRE UN COMMANDE CLIENT par ID
    public function getCommandeClientById($idcommandeclient){
        $this->db->select('*');
        $this->db->from('v_general_commande_client');
        $this->db->where('idcommandeclient', $idcommandeclient);
        $query = $this->db->get();

        return $query->row_array();
    }

    // DELETE CACHE OF COMMANDE CLIENT
    public function deleteCacheCommandeClient(){
        $this->db->trans_start(); // Start a transaction

        $this->db->where('idcommandeclient IN (SELECT idcommandeclient FROM commande_client WHERE status_commande_client = -1)', NULL, FALSE);
        $this->db->delete('detail_commande_client');

        $this->db->where('status_commande_client', -1);
        $this->db->delete('commande_client');

        $this->db->trans_complete(); // Complete the transaction
    }

    // AJOUT DETAIL COMMANDE CLIENT
    public function saveDetailCommandeClient($idcommandeclient, $idmateriel, $qty){
        $query = $this->db->query("SELECT nextval('seq_detail_proforma_client')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'COM_CLI_DET' . $sequence_value;
        $data['id_detail_commande_client'] = $id;
        $data['idcommandeclient'] = $idcommandeclient;
        $data['idmateriel'] = $idmateriel;
        $data['qty_request'] = $qty;

        $this->db->insert('detail_commande_client', $data);
    }

    // AJOUT GENERAL COMMANDE CLIENT
    public function createMainCommandeClient($idcustomer, $numero, $datecommande, $idemployee){
        $query = $this->db->query("SELECT nextval('seq_commande_client')");
        $row = $query->row_array();
        $sequence_value = $row['nextval'];
        $id = 'COM_CLI_' . $sequence_value;
        $data['idcommandeclient'] = $id;
        $data['idcustomer'] = $idcustomer;
        $data['date_commande_client_received'] = $datecommande;
        $data['numerocommande'] = $numero;
        $data['idemployee'] = $idemployee;
        $data['status_commande_client'] = -1;

        $this->db->insert('commande_client', $data);

        return $id;
    }

    // PRENDRE LES BON COMMANDE DES CLIENTS RECENTS
    public function getRecentCommandeClient(){
        $this->db->select('*');
        $this->db->from('v_general_commande_client');
        $this->db->order_by('date_commande_client_received', 'DESC');
        $query = $this->db->get();
        
        $data = $query->result_array();
        
        $result = array();
        for($i = 0; $i < count($data); $i++){
            $result[$i] = $data[$i];
            $temp = $this -> commande_client_status($data[$i]['status_commande_client']);
            $result[$i]['status'] = $temp;
        }
        return $result;
    }

    // STATUS BON DE COMMANDE CLIENT
    public function commande_client_status($status){
        if($status == 9){
            $result[] = "Annuler";
            $result[] = 0;
            return $result;
        }
        $donnes = array("Recu", "Envoye vers departement", "Facture par Finance", "Bon de Livraison creer");
        $progress = (($status + 1) / count($donnes)) * 100;
        $result = array();
        $result[] = $donnes[$status];
        $result[] = $progress;
        return $result;
    }
}