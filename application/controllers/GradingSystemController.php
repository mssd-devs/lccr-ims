<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class GradingSystemController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['GradingSystem_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'grading_system/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function edit()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'grading_system/encoding_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function LoadGradeClass()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->GradingSystem_Model->LoadGradeClass()
        ];
        echo json_encode($data);
    }

    function encodegrades()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'grading_system/encoding_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function saveUpdateForm()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->GradingSystem_Model->saveUpdateForm()
        ];
        $this->outputJSON($data);
    }

    function saveConfig()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->GradingSystem_Model->saveConfig()
        ];
        $this->outputJSON($data);
    }

    function print()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'grading_system/print_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    private function outputJSON($data)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
