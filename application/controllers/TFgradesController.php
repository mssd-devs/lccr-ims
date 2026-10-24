<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class TFgradesController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'security']);
        $this->load->model(['TFgrades_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'transferee_grades/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function create()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadPrograms' => $this->TFgrades_Model->LoadPrograms(),
            'main' => 'transferee_grades/create_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function edit()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadPrograms' => $this->TFgrades_Model->LoadPrograms(),
            'main' => 'transferee_grades/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function SaveTFGrades()
    {
        $this->TFgrades_Model->SaveTFGrades();
    }
    function UpdateTFGrades()
    {
        $this->TFgrades_Model->UpdateTFGrades();
    }
    function DeleteTFGrades()
    {
        $this->TFgrades_Model->DeleteTFGrades();
    }

    function LoadMajor()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->TFgrades_Model->LoadMajor()
        ];
        echo json_encode($data);
    }

    function LoadSemester()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->TFgrades_Model->LoadSemester()
        ];
        echo json_encode($data);
    }

    function LoadTFGrades()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->TFgrades_Model->LoadTFGrades()
        ];
        echo json_encode($data);
    }

    function addGrades()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->TFgrades_Model->addGrades()
        ];
        echo json_encode($data);
    }
}
