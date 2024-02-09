<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require('BaseSessionController.php');

class SendMail extends BaseSessionController {

    public function __construct() {
        parent::__construct();
        date_default_timezone_set('America/Anchorage');
        $this->load->library('email');
		$this->load->model('back_office/Proforma_model');
    }

    public function sendDemandeProforma(){
		$name = $this->input->post('name');
		$email = $this->input->post('email');
        $this->load->library('email');

		$config = array(
			'protocol' =>'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_timeout' => 30,
			'smtp_port' => 465,
			'smtp_user' => 'marcus.rgb@gmail.com',
			'smtp_pass' =>  'fctr ajbi mmid uvvy',
			'charset' => 'utf-8',
            'mailtype' =>'html',
			'newline' => '\r\n'
		);

		$this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->set_crlf("\r\n");
		$this->email->to($email);
        $this->email->from('marcus.rgb@gmail.com');
		$this->email->subject('Demande de Proforma');
		$this->email->message('Veuillez trouvez ci joint notre demande de proforma.');
        $pdfFilePath = FCPATH . 'assets/back_office/pdf/'.$name . '.pdf';
        $this->email->attach($pdfFilePath);
		//$this->email->attach(base_url($file));//'assets\document\Proformat_20231116234236.pdf'
		if($this->email->send()) 
		{
			$this->Proforma_model->updateStatusTo1($name);
			echo 'successfully Sent Email';
		}
		else 
		{
			echo 'Email Sending Error!';
            show_error($this->email->print_debugger());
		}

		
	}

	public function sendDemandeCommande(){
		$name = $this->input->post('name');
		$email = $this->input->post('email');
        $this->load->library('email');
		$this->load->model('back_office/achat/Bandcommande');
		$config = array(
			'protocol' =>'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_timeout' => 30,
			'smtp_port' => 465,
			'smtp_user' => 'marcus.rgb@gmail.com',
			'smtp_pass' =>  'fctr ajbi mmid uvvy',
			'charset' => 'utf-8',
            'mailtype' =>'html',
			'newline' => '\r\n'
		);

		$this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->set_crlf("\r\n");
		$this->email->to($email);
        $this->email->from('marcus.rgb@gmail.com');
		$this->email->subject('Commande');
		$this->email->message('Veuillez trouvez ci joint notre demande de proforma.');
        $pdfFilePath = FCPATH . 'assets/back_office/pdf/'.$name . '.pdf';
        $this->email->attach($pdfFilePath);
		//$this->email->attach(base_url($file));//'assets\document\Proformat_20231116234236.pdf'
		if($this->email->send()) 
		{
			$this->Bandcommande->validate($name,1);
			// echo 'successfully Sent Email';
			redirect(base_url().'back_office/BandcommandeController/commandes');
		}
		else 
		{
			echo 'Email Sending Error!';
            show_error($this->email->print_debugger());
		}

		
	}

	public function sendBonCommand()
	{
		$name = $this->input->post('name');
		$email = $this->input->post('email');
        $this->load->library('email');

		$config = array(
			'protocol' =>'smtp',
			'smtp_host' => 'ssl://smtp.gmail.com',
			'smtp_timeout' => 30,
			'smtp_port' => 465,
			'smtp_user' => 'marcus.rgb@gmail.com',
			'smtp_pass' =>  'fctr ajbi mmid uvvy',
			'charset' => 'utf-8',
            'mailtype' =>'html',
			'newline' => '\r\n'
		);

		$this->email->initialize($config);
        $this->email->set_newline("\r\n");
        $this->email->set_crlf("\r\n");
		$this->email->to($email);
        $this->email->from('marcus.rgb@gmail.com');
		$this->email->subject('Demande de Proforma');
		$this->email->message('Veuillez trouvez ci joint notre bon de commande.');
        $pdfFilePath = FCPATH . 'assets/back_office/pdf/'.$name . '.pdf';
        $this->email->attach($pdfFilePath);
		//$this->email->attach(base_url($file));//'assets\document\Proformat_20231116234236.pdf'
		if($this->email->send()) 
		{
			echo 'successfully Sent Email';
		}
		else 
		{
			echo 'Email Sending Error!';
            show_error($this->email->print_debugger());
		}
	}
}
