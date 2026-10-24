<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EnrollmentController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['form', 'url', 'security']);
        $this->load->library(['session', 'encrypt']);
        $this->load->model(["Enrollment_Model", "CashierBilling_Model"]);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'rbac' => $this->db->where("USER_ID", $this->session->userdata("id"))->where("PAGE", "Enrollment")->get("tbl_permissions"),
            'main' => 'enrollment/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function create()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadModalSubjects' => $this->Enrollment_Model->LoadModalSubjects(),
            'main' => 'enrollment/create_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function edit()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadStudentEnrolled' => $this->Enrollment_Model->LoadStudentEnrolled(),
            'LoadModalSubjects' => $this->Enrollment_Model->LoadModalSubjects(),
            'LoadEditSubjects' => $this->Enrollment_Model->LoadEditSubjects(),
            'main' => 'enrollment/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function view()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadStudentEnrolled' => $this->Enrollment_Model->LoadStudentEnrolled(),
            'rbac' => $this->db->where("USER_ID", $this->session->userdata("id"))->where("PAGE", "Enrollment")->get("tbl_permissions"),
            'LoadEditSubjects' => $this->Enrollment_Model->LoadEditSubjects(),
            'main' => 'enrollment/view_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function print()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadStudentEnrolled' => $this->Enrollment_Model->LoadStudentEnrolled(),
            'load_soa_fees' => $this->CashierBilling_Model->load_soa_fees(),
            'load_soa_payments' => $this->CashierBilling_Model->load_soa_payments(),
            'LoadOthersFee' => $this->Enrollment_Model->LoadOthersFee(),
            'LoadMiscFee' => $this->Enrollment_Model->LoadMiscFee(),
            'query' => $this->db->get("tbl_websettings"),
            'LoadEditSubjects' => $this->Enrollment_Model->LoadEditSubjects(),
        ];
        $this->load->view('enrollment/print_view', $data);
    }

    function printcert()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadStudentEnrolled' => $this->Enrollment_Model->LoadStudentEnrolled(),
            'load_soa_fees' => $this->CashierBilling_Model->load_soa_fees(),
            'load_soa_payments' => $this->CashierBilling_Model->load_soa_payments(),
            'LoadOthersFee' => $this->Enrollment_Model->LoadOthersFee(),
            'LoadMiscFee' => $this->Enrollment_Model->LoadMiscFee(),
            'query' => $this->db->get("tbl_websettings"),
            'LoadEditSubjects' => $this->Enrollment_Model->LoadEditSubjects(),
        ];
        $this->load->view('enrollment/print_cert_view', $data);
    }

    function printcor()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadStudentEnrolled' => $this->Enrollment_Model->LoadStudentEnrolled(),
            'load_soa_fees' => $this->CashierBilling_Model->load_soa_fees(),
            'load_soa_payments' => $this->CashierBilling_Model->load_soa_payments(),
            'LoadOthersFee' => $this->Enrollment_Model->LoadOthersFee(),
            'LoadMiscFee' => $this->Enrollment_Model->LoadMiscFee(),
            'query' => $this->db->get("tbl_websettings"),
            'LoadEditSubjects' => $this->Enrollment_Model->LoadEditSubjects(),
        ];
        $this->load->view('enrollment/print_cor_view', $data);
    }
    function printhd()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadStudentEnrolled' => $this->Enrollment_Model->LoadStudentEnrolled(),
            'load_soa_fees' => $this->CashierBilling_Model->load_soa_fees(),
            'load_soa_payments' => $this->CashierBilling_Model->load_soa_payments(),
            'LoadOthersFee' => $this->Enrollment_Model->LoadOthersFee(),
            'LoadMiscFee' => $this->Enrollment_Model->LoadMiscFee(),
            'query' => $this->db->get("tbl_websettings"),
            'LoadEditSubjects' => $this->Enrollment_Model->LoadEditSubjects(),
        ];
        $this->load->view('enrollment/print_honorabledismissal_view', $data);
    }

    function SearchStudentID()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->Enrollment_Model->SearchStudentID()
        ];
        echo json_encode($data);
    }
    function LoadProgramMajor()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->Enrollment_Model->LoadProgramMajor()
        ];
        echo json_encode($data);
    }
    function LoadSemester()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->Enrollment_Model->LoadSemester()
        ];
        echo json_encode($data);
    }

    function GetLastEnrollment()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->Enrollment_Model->GetLastEnrollment()
        ];
        echo json_encode($data);
    }
    function LoadSection()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->Enrollment_Model->LoadSection()
        ];
        echo json_encode($data);
    }
    function CheckSectionCapacity()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->Enrollment_Model->CheckSectionCapacity()
        ];
        echo json_encode($data);
    }
    function LoadSubjects()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->Enrollment_Model->LoadSubjects()
        ];
        echo json_encode($data);
    }
    function LoadEnrollment()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->Enrollment_Model->LoadEnrollment()
        ];
        echo json_encode($data);
    }
    function DeleteEnrollment()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->Enrollment_Model->DeleteEnrollment()
        ];
        echo json_encode($data);
    }
    function saveUpdate()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->Enrollment_Model->saveUpdate()
        ];
        echo json_encode($data);
    }
}
