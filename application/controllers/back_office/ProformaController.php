<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('BaseSessionController.php');
class ProformaController extends BaseSessionController {
	public function __construct()
    {
        parent::__construct();
		$this->load->model('back_office/Fournisseur_model');
		$this->load->model('back_office/Proforma_model');
    }

	public function index() {
        $data['proforma'] = $this->Proforma_model->getProforma();
		$data['content'] = 'back_office/proforma/list';
        $this->load->view('back_office/main',$data);
    }

    public function demande($id){
		$data['proforma'] = $this->Proforma_model->getProformaById($id);
		$data['global'] = $this->Proforma_model->getGlobal($data['proforma']['idglobal'],3, $id);
		$data['content'] = 'back_office/proforma/demande';
		echo 'idsent is ' . $id;
		// var_dump($data['global']);
		$this->load->view('back_office/main', $data);
	}

	public function adddemandeproforma() {
		$data['fournisseur'] = $this->Fournisseur_model->get_all_fournisseurs();
		$data['global'] = $this->Proforma_model->getAllGlobal();
		$data['content'] = 'back_office/proforma/addDemandeProforma';
        $this->load->view('back_office/main',$data);
    }

	public function insertProforma(){
		$data = array(
            'idfournisseur'        => $this->input->post('fou'),
            'idglobal'     => $this->input->post('glo')
        );
		$this->Proforma_model->addDmdProforma($data);
		redirect('back_office/ProformaController');
	}
}
