<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class SemesterTypeController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['SemesterType_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function semestertype()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadSemesterType' => $this->SemesterType_Model->LoadSemesterType(),
            'main' => 'semestertype/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function edit()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadSemesterType' => $this->db->where("ID", $this->uri->segment(5))->get("tbl_semestertype"),
            'main' => 'semestertype/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function SaveSemester()
    {
        $this->SemesterType_Model->SaveSemester();
    }
    function UpdateSemester()
    {
        $this->SemesterType_Model->UpdateSemester();
    }
    function DeleteSemester()
    {
        $this->SemesterType_Model->DeleteSemester();
    }
}
