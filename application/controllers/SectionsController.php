<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class SectionsController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['Sections_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function sections()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadSections' => $this->Sections_Model->LoadSections(),
            'LoadPrograms' => $this->Sections_Model->LoadPrograms(),
            'main' => 'sections/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function edit()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadSections' => $this->db->where("ID", $this->uri->segment(5))->get("tbl_section"),
            'LoadPrograms' => $this->Sections_Model->LoadPrograms(),
            'main' => 'sections/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function SaveSections()
    {
        $this->Sections_Model->SaveSections();
    }
    function UpdateSections()
    {
        $this->Sections_Model->UpdateSections();
    }
    function DeleteSections()
    {
        $this->Sections_Model->DeleteSections();
    }
    function LoadMajor()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->Sections_Model->LoadMajor()
        ];
        echo json_encode($data);
    }
    function LoadSemester()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->Sections_Model->LoadSemester()
        ];
        echo json_encode($data);
    }
}
