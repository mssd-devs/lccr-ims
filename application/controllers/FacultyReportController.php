<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class FacultyReportController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['form', 'url', 'security']);
        $this->load->library(['session', 'encrypt']);
        $this->load->model(['FacultyReport_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }
    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadTenure' => $this->db->get("ref_tenure"),
            'main' => 'faculty_report/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function LoadEmployee()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->FacultyReport_Model->LoadEmployee()
        ];
        echo json_encode($data);
    }
}
