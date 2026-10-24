<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class GraduatesController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['form', 'url', 'security']);
        $this->load->library(['session', 'encrypt']);
        $this->load->model(["Graduates_Model"]);
        $this->load->model(["StudentProfile_Model"]);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }
    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'graduates/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function LoadEnrollment()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->Graduates_Model->LoadEnrollment()
        ];
        echo json_encode($data);
    }
    function view()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadTribes' => $this->db->get("tbl_tribes"),
            'FetchStudentProfile' => $this->db->where("SP_TRANSID", $this->uri->segment(4))->get("tbl_studprof"),
            'load_active_enrollemt' => $this->StudentProfile_Model->load_active_enrollemt(),
            // 'load_graduate' => $this->Graduates_Model->load_graduate($this->uri->segment(4)),
            'rbac' => $this->db->where("USER_ID", $this->session->userdata("id"))->where("PAGE", "Student Profile")->get("tbl_permissions"),
            'main' => 'graduates/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    public function saveGraduateValidation()
    {
        $this->load->model('Graduates_Model');
        $result = $this->Graduates_Model->saveGraduateValidation();

        // Always return JSON once
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }
}
