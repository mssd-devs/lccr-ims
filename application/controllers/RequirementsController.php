<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class RequirementsController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['Requirements_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadRequirements' => $this->Requirements_Model->LoadRequirements(),
            'main' => 'requirements/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function edit()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadRequirements' => $this->db->where("ID", $this->uri->segment(5))->get("tbl_requirements"),
            'main' => 'requirements/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function SaveRequirements()
    {
        $this->Requirements_Model->SaveRequirements();
    }
    function UpdateRequirements()
    {
        $this->Requirements_Model->UpdateRequirements();
    }
    function DeleteRequirements()
    {
        $this->Requirements_Model->DeleteRequirements();
    }
}
