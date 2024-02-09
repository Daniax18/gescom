

<?php

class GlobalDataHook
{
    protected $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
        $this->CI->load->library('session');
        $this->CI->load->model('back_office/dep_logistique/Papier');
        // selection de papier
        $this->CI->load->model('back_office/dep_finance/Reception');
    }

    public function load_global_data()
    {
        $CI =& get_instance();      
        $data['user_session'] = $CI->session->userdata('user_data');
        $data['dep_achat_id'] = $CI->session->userdata('dep_achat');
        $data['paperasse'] = $CI->Papier->getaLL();  
        $data['detail_categorie'] = $CI->Reception->getDetail();
        $data['user'] = $CI->session->userdata('user_data');
        $data['cars'] = $CI->Reception->getPV();
        $data['departement_achat'] = $CI->session->userdata('dep_achat');
        $data['departement_finance'] = $CI->session->userdata('dep_finance');
        $data['departement_log'] = $CI->session->userdata('dep_logistique');
        $data['departement_vente'] = $CI->session->userdata('dep_vente');
        $CI->load->vars($data);
    }
}