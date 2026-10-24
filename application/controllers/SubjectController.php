<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class SubjectController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['Subject_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function subject()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadSubjects' => $this->Subject_Model->LoadSubjects(),
            'LoadPrograms' => $this->Subject_Model->LoadPrograms(),
            'main' => 'subject/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function edit()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadPrograms' => $this->Subject_Model->LoadPrograms(),
            'LoadSubjects' => $this->db->where("ID", $this->uri->segment(5))->get("tbl_subject"),
            'main' => 'subject/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function SaveSubjects()
    {
        $this->Subject_Model->SaveSubjects();
    }
    function UpdateSubjects()
    {
        $this->Subject_Model->UpdateSubjects();
    }
    function DeleteSubjects()
    {
        $this->Subject_Model->DeleteSubjects();
    }

    function LoadMajor()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->Subject_Model->LoadMajor()
        ];
        echo json_encode($data);
    }

    function LoadSemester()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->Subject_Model->LoadSemester()
        ];
        echo json_encode($data);
    }
}
