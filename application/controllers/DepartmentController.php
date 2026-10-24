<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class DepartmentController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['Department_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    public function department()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadDepartments' => $this->Department_Model->LoadDepartments(),
            'main' => 'department/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function edit()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadDepartments' => $this->db->where("ID", $this->uri->segment(5))->get("tbl_department"),
            'main' => 'department/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function SaveDepartments()
    {
        $this->Department_Model->SaveDepartments();
    }
    function UpdateDepartments()
    {
        $this->Department_Model->UpdateDepartments();
    }
    function DeleteDepartments()
    {
        $this->Department_Model->DeleteDepartments();
    }
}
