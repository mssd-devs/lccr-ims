<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class FeesController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['Fees_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadTuitions' => $this->Fees_Model->LoadTuitions(),
            'rbac' => $this->db->where("USER_ID", $this->session->userdata("id"))->where("PAGE", "Fees Section")->get("tbl_permissions"),
            'main' => 'fees/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function create()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadPrograms' => $this->Fees_Model->LoadPrograms(),
            'main' => 'fees/create_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function edit()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadPrograms' => $this->Fees_Model->LoadPrograms(),
            'main' => 'fees/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function LoadMajor()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->Fees_Model->LoadMajor()
        ];
        echo json_encode($data);
    }

    function addMiscellaneous()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->Fees_Model->addMiscellaneous()
        ];
        echo json_encode($data);
    }

    function addOtherFees()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->Fees_Model->addOtherFees()
        ];
        echo json_encode($data);
    }
    function LoadSemester()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->Fees_Model->LoadSemester()
        ];
        echo json_encode($data);
    }

    public function LoadSumUnits()
    {
        $prog = $this->input->post("prog", true);
        $maj  = $this->input->post("maj", true);
        $yr   = $this->input->post("yr", true);
        $sem  = $this->input->post("sem", true);

        $totalUnits = $this->Fees_Model->LoadSumUnits($prog, $maj, $yr, $sem);

        echo json_encode([
            'token' => $this->security->get_csrf_hash(),
            'units' => $totalUnits
        ]);
    }


    function LoadFees()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->Fees_Model->LoadFees()
        ];
        echo json_encode($data);
    }


    function saveFees()
    {
        $this->Fees_Model->saveFees();
    }
    function updateFees()
    {
        $this->Fees_Model->updateFees();
    }
    function deleteFees()
    {
        $this->Fees_Model->deleteFees();
    }
}
