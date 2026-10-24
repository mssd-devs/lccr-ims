<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class FacultyprofController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['FacultyProfile_Model']);

        $public_methods = ['register', 'savePublicFP', 'LoadProvince', 'LoadCity', 'LoadBrgy', 'fetchEducationAttainment'];
        if (!in_array($this->router->fetch_method(), $public_methods)) {
            if (empty($this->session->userdata("fullname"))) {
                $this->session->set_flashdata("error", "You need to log in first.");
                redirect(base_url("login"));
            }
        }
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'rbac' => $this->db->where("USER_ID", $this->session->userdata("id"))->where("PAGE", "Employee Profile")->get("tbl_permissions"),
            'LoadFacultyProfile' => $this->FacultyProfile_Model->LoadFacultyProfile(),
            'LoadTenure' => $this->db->get("ref_tenure"),
            'main' => 'facultyprof/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function checkNewEntry()
    {
        $this->outputJson($this->FacultyProfile_Model->checkNewEntry());
    }

    function create()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadRegion' => $this->db->get("refregion"),
            'LoadTribes' => $this->db->get("tbl_tribes"),
            'LoadProfLicense' => $this->db->get("ref_proflicense"),
            'LoadTenure' => $this->db->get("ref_tenure"),
            'LoadFacultyRank' => $this->db->get("ref_facultyrank"),
            'LoadTeachLoad' => $this->db->get("ref_teachload"),
            'LoadAnnualSalary' => $this->db->get("ref_annualsalary"),
            'main' => 'facultyprof/create_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function register()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadRegion' => $this->db->get("refregion"),
            'LoadTribes' => $this->db->get("tbl_tribes"),
            'LoadProfLicense' => $this->db->get("ref_proflicense"),
            'LoadTenure' => $this->db->get("ref_tenure"),
            'LoadFacultyRank' => $this->db->get("ref_facultyrank"),
            'LoadTeachLoad' => $this->db->get("ref_teachload"),
            'LoadAnnualSalary' => $this->db->get("ref_annualsalary")
        ];
        $this->load->view('facultyprof/public_register_view', $data);
    }

    function savePublicFP()
    {
        $this->outputJson($this->FacultyProfile_Model->saveFP());
    }

    function edit()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'FetchFacultyProfile' => $this->db->where("FP_TRANSID", $this->uri->segment(4))->get("tbl_facprof"),
            'EditSchool' => $this->db->where("FP_TRANSID", $this->uri->segment(4))->get("tbl_facprof_school"),
            'LoadRegion' => $this->db->get("refregion"),
            'LoadTribes' => $this->db->get("tbl_tribes"),
            'LoadProfLicense' => $this->db->get("ref_proflicense"),
            'LoadTenure' => $this->db->get("ref_tenure"),
            'LoadFacultyRank' => $this->db->get("ref_facultyrank"),
            'LoadTeachLoad' => $this->db->get("ref_teachload"),
            'LoadAnnualSalary' => $this->db->get("ref_annualsalary"),
            'main' => 'facultyprof/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function view()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'FetchFacultyProfile' => $this->db->where("FP_TRANSID", $this->uri->segment(4))->get("tbl_facprof"),
            'FetchSchool' => $this->db->where("FP_TRANSID", $this->uri->segment(4))->get("tbl_facprof_school"),
            'rbac' => $this->db->where("USER_ID", $this->session->userdata("id"))->where("PAGE", "Employee Profile")->get("tbl_permissions"),
            'main' => 'facultyprof/view_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function LoadProvince()
    {
        $this->outputJson($this->FacultyProfile_Model->LoadProvince($this->input->post("regCode")));
    }
    function LoadCity()
    {
        $this->outputJson($this->FacultyProfile_Model->LoadCity($this->input->post("provCode")));
    }
    function LoadBrgy()
    {
        $this->outputJson($this->FacultyProfile_Model->LoadBrgy($this->input->post("citymunCode")));
    }
    function fetchEducationAttainment()
    {
        $this->outputJson($this->FacultyProfile_Model->fetchEducationAttainment());
    }
    private function outputJson($output)
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'output' => $output
        ];
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    function saveFP()
    {
        $this->outputJson($this->FacultyProfile_Model->saveFP());
    }
    function updateFP()
    {
        $this->outputJson($this->FacultyProfile_Model->updateFP());
    }
    function deleteFP()
    {
        $this->outputJson($this->FacultyProfile_Model->deleteFP());
    }

    function GenerateFacultyID()
    {
        // Read new token and assing in $data['token']
        $data['token'] = $this->security->get_csrf_hash();
        $data['output'] = $this->FacultyProfile_Model->GenerateFacultyID();
        echo json_encode($data);
    }
}
