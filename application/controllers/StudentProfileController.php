<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class StudentProfileController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['StudentProfile_Model', 'CashierBilling_Model', 'Enrollment_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadStudentProfile' => $this->StudentProfile_Model->LoadStudentProfile(),
            'rbac' => $this->db->where("USER_ID", $this->session->userdata("id"))->where("PAGE", "Student Profile")->get("tbl_permissions"),
            'main' => 'studprof/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function update_remarks()
    {
        $this->outputJson($this->StudentProfile_Model->update_remarks());
    }

    function checkNewEntry()
    {
        $this->outputJson($this->StudentProfile_Model->checkNewEntry());
    }

    function create()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadRegion' => $this->db->get("refregion"),
            'LoadTribes' => $this->db->get("tbl_tribes"),
            'main' => 'studprof/create_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function edit()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadRegion' => $this->db->get("refregion"),
            'LoadTribes' => $this->db->get("tbl_tribes"),
            'FetchStudentProfile' => $this->db->where("SP_TRANSID", $this->uri->segment(4))->get("tbl_studprof"),
            'EditFamily' => $this->db->where("SP_TRANSID", $this->uri->segment(4))->get("tbl_studprof_family"),
            'EditSchool' => $this->db->where("SP_TRANSID", $this->uri->segment(4))->get("tbl_studprof_school"),
            'main' => 'studprof/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function view()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadTribes' => $this->db->get("tbl_tribes"),
            'query' => $this->db->get("tbl_websettings"),
            'FetchStudentProfile' => $this->db->where("SP_TRANSID", $this->uri->segment(4))->get("tbl_studprof"),
            'load_active_enrollemt' => $this->StudentProfile_Model->load_active_enrollemt(),
            // 'load_enrolled_programs' => $this->StudentProfile_Model->load_enrolled_programs(),
            'EditFamily' => $this->db->where("SP_TRANSID", $this->uri->segment(4))->get("tbl_studprof_family"),
            'EditSchool' => $this->db->where("SP_TRANSID", $this->uri->segment(4))->get("tbl_studprof_school"),
            'rbac' => $this->db->where("USER_ID", $this->session->userdata("id"))->where("PAGE", "Student Profile")->get("tbl_permissions"),
            'main' => 'studprof/view_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function LoadProvince()
    {
        $this->outputJson($this->StudentProfile_Model->LoadProvince($this->input->post("regCode")));
    }
    function LoadCity()
    {
        $this->outputJson($this->StudentProfile_Model->LoadCity($this->input->post("provCode")));
    }
    function LoadBrgy()
    {
        $this->outputJson($this->StudentProfile_Model->LoadBrgy($this->input->post("citymunCode")));
    }

    function saveUpdateSP()
    {
        $this->outputJson($this->StudentProfile_Model->saveUpdateSP());
    }
    // function updateSP()
    // {
    //     $this->outputJson($this->StudentProfile_Model->updateSP());
    // }
    function deleteSP()
    {
        $this->outputJson($this->StudentProfile_Model->deleteSP());
    }
    function fetchEducationAttainment()
    {
        $this->outputJson($this->StudentProfile_Model->fetchEducationAttainment());
    }

    function fetchFamilyBackground()
    {
        $this->outputJson($this->StudentProfile_Model->fetchFamilyBackground());
    }

    function LoadStudentProfile()
    {
        $this->outputJson($this->StudentProfile_Model->LoadStudentProfile());
    }



    function generateSelectedAccounts()
    {
        $is_admin = in_array(strtolower(trim($this->session->userdata("usertype") ?? '')), ["administrator", "superadmin", "super admin", "admin"]);
        
        if (!$is_admin) {
            $rbac = $this->db->where("USER_ID", $this->session->userdata("id"))->where("PAGE", "Student Profile")->get("tbl_permissions");
            $permission = [];
            foreach ($rbac->result() as $rows) {
                $actions = explode(',', $rows->ACTIONS);
                $permission = array_merge($permission, array_map('trim', $actions));
            }
            if (!in_array("Create", $permission) && !in_array("Edit", $permission)) {
                show_error('You do not have permission to perform this action.', 403);
                return;
            }
        }

        $student_ids = $this->input->post('student_ids');
        
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'accounts' => $this->StudentProfile_Model->generateSelectedPortalAccounts($student_ids),
            'query' => $this->db->get("tbl_websettings") // for school header info if needed
        ];
        
        $this->load->view('studprof/print_accounts_view', $data);
    }

    function countSelectedEligible()
    {
        $student_ids = $this->input->post('student_ids') ?: [];
        $total = count($student_ids);
        $eligible = $this->StudentProfile_Model->countSelectedEligible($student_ids);
        
        $this->outputJson([
            'token' => $this->security->get_csrf_hash(),
            'total' => $total,
            'eligible' => $eligible,
            'exist' => $total - $eligible
        ]);
    }

    public function update_student_id()
    {
        $userId = $this->session->userdata('id');
        $recordId = $this->input->post('record_id');
        $oldStudentId = $this->input->post('old_student_id');
        $newStudentId = $this->input->post('new_student_id');
        $overridePassword = $this->input->post('override_password');

        $user = $this->db->where('ID', $userId)->get('tbl_users')->row();

        if ($user && password_verify($overridePassword, $user->IMS_USERS_PWORD)) {
            // Check if new student ID already exists
            $exists = $this->db->where('SP_STUDID', $newStudentId)->where('ID !=', $recordId)->get('tbl_studprof')->num_rows();
            if ($exists > 0) {
                echo json_encode(['status' => 'error', 'message' => 'Student ID already exists in another record.', 'token' => $this->security->get_csrf_hash()]);
                return;
            }

            // Update tbl_studprof
            $this->db->where('ID', $recordId)->update('tbl_studprof', ['SP_STUDID' => $newStudentId]);
            // Update tbl_enrollment
            $this->db->where('ER_STUDENTID', $oldStudentId)->update('tbl_enrollment', ['ER_STUDENTID' => $newStudentId]);

            // Add audit trail log
            log_audit("STUDENT ID UPDATED", "Changed Student ID from {$oldStudentId} to {$newStudentId} for record ID {$recordId}");

            echo json_encode(['status' => 'success', 'message' => 'Student ID successfully updated.', 'token' => $this->security->get_csrf_hash()]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Incorrect authorization password.', 'token' => $this->security->get_csrf_hash()]);
        }
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
}
