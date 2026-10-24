<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class BillingController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['form', 'url']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            // 'LoadApplication' => $this->Form1_Model->LoadApplication(),
            // 'LoadNomInfo' => $this->Form2_Model->LoadNomInfo(),
            // 'LoadPSRInfo' => $this->Form3_Model->LoadPSRInfo(),
            'main' => 'billing/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
}
