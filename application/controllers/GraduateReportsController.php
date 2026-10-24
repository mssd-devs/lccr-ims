<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class GraduateReportsController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['form', 'url', 'security']);
        $this->load->library(['session', 'encrypt']);
        $this->load->model(["GraduateReports_Model"]);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }
    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'graduatereports/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function LoadEnrollment()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->GraduateReports_Model->LoadEnrollment()
        ];
        echo json_encode($data);
    }
}
