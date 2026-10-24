<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class EnrollmentReportController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['form', 'url', 'security']);
        $this->load->library(['session', 'encrypt']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }
    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'enrollment_report/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
}
