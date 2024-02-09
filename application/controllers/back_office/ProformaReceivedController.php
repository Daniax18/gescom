<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('BaseSessionController.php');
class ProformaReceivedController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
		$this->load->model('back_office/ProformaReceived_model');
		$this->load->model('back_office/achat/Materiel');
    }

	public function proforma(){
		$data['content'] = 'back_office/proforma/listeproforma';
		$user = $this->session->userdata('user_data'); 
		$this->load->model('back_office/dep_achat/BesoinAchat');
		$this -> load -> model('back_office/dep_achat/Proforma');
        // $data['proformas'] = $this->ProformaReceived_model->get_all_proformas();
		$data['globals'] = $this -> BesoinAchat -> getBesoinsHasProformas();
		$this->load->view('back_office/main',$data);
	}

	// LISTE DES MATERIELS POUR UN BESOIN SPECIFIC
	public function listeProformaCtrl($status,$idproforma){
		$data['detail_proformas'] = $this -> ProformaReceived_model -> getProformaDetail($idproforma);
		$data['content'] = 'back_office/proforma/detail_proforma';
		$data['materiels'] = $this -> Materiel -> materiels();
		$data['idproforma'] = $idproforma;
		$data['status'] = $status;
		$this->load->view('back_office/main',$data);
	}
	public function receive($idproforma){
		$data['detail_proformas'] = $this -> ProformaReceived_model -> getupdate($idproforma);
		$this->proforma();
	}
	public function updateDetailProformaCtrl(){
		$idproforma = $this->input->post('idproforma');
		$status = $this->input->post('status');
		// echo $idproforma;
		$id = $this->input->post('iddetail');
		$qty = $this->input->post('quantite');
		$pu = $this->input->post('pu');
		$this -> ProformaReceived_model ->updateDetailProforma($id, $qty,$pu);
		redirect(base_url().'back_office/ProformaReceivedController/listeProformaCtrl/'.$status.'/'.$idproforma);
	}
	public function deleteDetailProformaCtrl($status,$idproforma ,$id){
		$this -> ProformaReceived_model -> deleteDetailProforma($id);
		redirect(base_url().'back_office/ProformaReceivedController/listeProformaCtrl/'.$status.'/'.$idproforma);
	}

}
