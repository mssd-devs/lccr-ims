<?php
#[AllowDynamicProperties]
class Login_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function SubmitLogin($uname, $pword)
    {
        // Sanitize input to prevent SQL injection
        $uname = $this->db->escape_str($uname);
        $query = $this->db->get_where('tbl_users', ['IMS_USERS_UNAME' => $uname]);
        $user = $query->row();

        // VALIDATE USERNAME AND PASSWORD
        if ($user && password_verify($pword, $user->IMS_USERS_PWORD)) {

            // SESSION FOR FULLNAME AND USER TYPE
            $data = [
                "fullname" => $user->IMS_USERS_NAME,
                "usertype" => $user->IMS_USERS_ROLE,
                "username" => $user->IMS_USERS_UNAME,
                "user_image" => $user->IMS_USERS_IMAGE,
                "id" => $user->ID
            ];

            // IF THE USER IS ACTIVE
            if ($user->IMS_USERS_STATUS == "Active") {

                $this->session->set_userdata($data);
                log_audit("USER LOGGED IN", "Username: " . $user->IMS_USERS_UNAME . " (" . $user->IMS_USERS_NAME . ", Role: " . $user->IMS_USERS_ROLE . ")");

                // Use switch statement for role-based actions
                switch ($user->IMS_USERS_ROLE) {
                    case "Registrar":
                        redirect(base_url('ims/profile'));
                        break;
                    case "School President":
                        redirect(base_url('ims/profile'));
                        break;
                    case "Cashier":
                        redirect(base_url('ims/profile'));
                        break;
                    case "Faculty":
                        redirect(base_url('ims/profile'));
                        break;
                    default:
                        redirect(base_url('ims/dashboards/analytics'));
                        break;
                }
            }
            // IF THE USER IS INACTIVE
            else {
                $this->session->set_flashdata('error', 'Your account is <b>Inactive</b>. Please contact the system administrator.');
                redirect(base_url('login'));
            }
        } else {
            $this->session->set_flashdata('error', 'Invalid username or password');
            redirect(base_url('login'));
        }
    }
}
