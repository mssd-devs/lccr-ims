<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class GradesController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['Grade_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'grades/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function encodegrades()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'grades/encode_grades_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function edit()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'grades/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function print()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'grades/print_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function saveUpdateForm()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->Grade_Model->saveUpdateForm()
        ];
        $this->outputJSON($data);
    }

    private function outputJSON($data)
    {
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
    function LoadGradeClass()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->Grade_Model->LoadGradeClass()
        ];
        echo json_encode($data);
    }
    function getStudentValidationData($student_id)
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->Grade_Model->getStudentValidationData($student_id)
        ];
        echo json_encode($data);
    }
}
