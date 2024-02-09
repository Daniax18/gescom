<?php defined('BASEPATH') OR exit('No direct script access allowed');

class BaseSessionController extends CI_controller{

    public function __construct(){
        parent::__construct();
        if(!$this->session->has_userdata('user_data')){
            redirect(base_url().'back_office/LoginController');
        }
    }
}

?>