<?php
defined('BASEPATH') or exit('No direct script access allowed');
require('BaseSessionController.php');
class HomeController extends BaseSessionController
{
    public function index()
    {
        
        $data['content'] = 'back_office/home';
        $this->load->view('back_office/main',$data);
        
    }
}
