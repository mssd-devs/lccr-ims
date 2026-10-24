<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class ProfileController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'security']);
        $this->load->model(['Profile_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }


    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadProfile' => $this->db->where("ID", $this->session->userdata("id"))->get("tbl_users"),
            'main' => 'profile_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function updateProfile()
    {
        // Check if it's an AJAX request
        if ($this->input->is_ajax_request()) {
            $result = $this->Profile_Model->updateProfile();
            $data = [
                'token' => $this->security->get_csrf_hash(),
                'output' => $result['success'],
                'message' => $result['message'],
                'image_url' => isset($result['image_url']) ? $result['image_url'] : null
            ];
            echo json_encode($data);
        } else {
            $this->Profile_Model->updateProfile();
        }
    }

    // Validate Current Password
    public function checkCurrentPassword()
    {
        $userId = $this->session->userdata('id');
        $currentPassword = $this->input->post('currentPassword');

        $user = $this->Profile_Model->getUserById($userId);
        $hashedPassword = $user->password;
        // Read new token and assing in $data['token']

        if (password_verify($currentPassword, $hashedPassword)) {
            echo json_encode([
                'status' => 'success',
                'token' => $this->security->get_csrf_hash()
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Incorrect current password',
                'token' => $this->security->get_csrf_hash()
            ]);
        }
    }

    // Update Password
    public function changePassword()
    {
        $userId = $this->session->userdata('id');
        $newPassword = $this->input->post('newPassword');
        $currentPassword = $this->input->post('currentPassword');

        $user = $this->Profile_Model->getUserById($userId);

        if (!$user) {
            echo json_encode([
                'status' => 'error',
                'message' => 'User not found.',
                'token' => $this->security->get_csrf_hash()
            ]);
            return;
        }

        // Use the correct password field name here
        $hashedPassword = $user->IMS_USERS_PWORD;

        if (password_verify($currentPassword, $hashedPassword)) {
            // Hash new password before saving
            $hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            $updateStatus = $this->Profile_Model->updatePassword($userId, $hashedNewPassword);

            if ($updateStatus) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Password updated successfully!',
                    'token' => $this->security->get_csrf_hash()
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to update password.',
                    'token' => $this->security->get_csrf_hash()
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Incorrect current password.',
                'token' => $this->security->get_csrf_hash()
            ]);
        }
    }
}
