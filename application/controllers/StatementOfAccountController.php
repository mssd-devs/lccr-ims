<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class StatementOfAccountController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['StatementOfAccount_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadPaidStudent' => $this->StatementOfAccount_Model->LoadPaidStudent(),
            'main' => 'statementofaccount/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function view()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            // 'LoadSections' => $this->Sections_Model->LoadSections(),
            // 'LoadPrograms' => $this->db->get("tbl_program"),
            'main' => 'statementofaccount/statement_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
}
