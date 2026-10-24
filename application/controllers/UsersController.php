<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class UsersController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['Users_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    public function logout()
    {
        $uname = $this->session->userdata('username') ?: $this->session->userdata('fullname');
        log_audit("USER LOGGED OUT", "Username: " . $uname);
        $this->session->sess_destroy(); // Destroy session
        $csrf_token = $this->security->get_csrf_hash(); // Generate new CSRF token

        echo json_encode([
            'success' => true,
            'message' => 'Logged out successfully.',
            'token' => $csrf_token
        ]);
    }

    function users()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadUsers' => $this->Users_Model->LoadUsers(),
            'main' => 'users/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function edit()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadUsers' => $this->db->where("ID", $this->uri->segment(4))->get("tbl_users"),
            'main' => 'users/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function saveUsers()
    {
        $this->Users_Model->saveUsers();
    }
    function updateUsers()
    {
        $this->Users_Model->updateUsers();
    }
    function deleteUsers()
    {
        $this->Users_Model->deleteUsers();
    }

    public function get_permission()
    {
        $ID = $this->input->post('ID');
        $result = "";
        $pages = [
            "Student Profile",
            "Enrollment",
            "Registrar Grades",
            "Graduates",
            "Promotional",
            "Employee Profile",
            "Data Management",
            "Scheduling",
            "Evaluation",
            "Reports",
            "Fees Section",
            "Billing Section",
            "My Class",
            "Grading System",
            "Financial Dashboard",
            "Analytics Dashboard",
            "User Management",
            "Audit Trail",
            "Web Settings",
            "About"
        ];
        $permissionActions = ["Create", "Edit", "View", "Delete"];

        $existing_permissions = $this->Users_Model->get_user_permissions($ID);

        foreach ($pages as $index => $page) {
            $result .= '<tr>
                <td>
                    <div class="form-check mt-4">
                        <input class="form-check-input page-checkbox" type="checkbox" 
                            value="' . $page . '" 
                            id="page_' . $index . '" 
                            ' . (isset($existing_permissions[$page]) ? 'checked' : '') . '/>
                        <label class="form-check-label" for="page_' . $index . '">' . $page . '</label>
                    </div>
                </td>
                <td>';

            foreach ($permissionActions as $actionIndex => $action) {
                $checked = isset($existing_permissions[$page]) &&
                    in_array($action, explode(',', $existing_permissions[$page])) ? 'checked' : '';
                $result .= '
                    <div class="form-check form-check-inline align-items-center">
                        <input class="form-check-input action-checkbox" type="checkbox" 
                            value="' . $action . '" 
                            id="action_' . $index . '_' . $actionIndex . '" 
                            ' . $checked . '/>
                        <label class="form-check-label ms-1" 
                            for="action_' . $index . '_' . $actionIndex . '">' . $action . '</label>
                    </div>';
            }

            $result .= '</td></tr>';
        }

        $response = [
            'output' => $result,
            'ID' => $ID,
            'token' => $this->security->get_csrf_hash()
        ];

        echo json_encode($response);
    }

    public function save_permissions()
    {
        $ID = $this->input->post('ID');
        $permissions = json_decode($this->input->post('permissions'), true);

        $result = $this->Users_Model->save_permissions($ID, $permissions);

        $response = [
            'status' => $result,
            'token' => $this->security->get_csrf_hash()
        ];

        echo json_encode($response);
    }
}
