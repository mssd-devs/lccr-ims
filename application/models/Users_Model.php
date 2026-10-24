<?php

#[AllowDynamicProperties]
class Users_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function validate_data($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function LoadUsers()
    {
        $query = $this->db->query("SELECT * FROM tbl_users WHERE IMS_USERS_ROLE != 'Super Admin' ORDER BY ID DESC");
        return $query;
    }

    public function saveUsers()
    {
        date_default_timezone_set("Asia/Manila");
        $data = $this->getUserData();

        if ($this->db->insert("tbl_users", $data)) {
            $details = "Username: " . $data['IMS_USERS_UNAME'] . " (" . $data['IMS_USERS_NAME'] . ", Role: " . $data['IMS_USERS_ROLE'] . ")";
            log_audit("SAVED NEW USER", $details);
            $this->setSuccessFlashMessage("Data has been saved.");
        } else {
            $this->setErrorFlashMessage("Data error saving.");
        }

        $this->redirectUsersPage();
    }

    public function updateUsers()
    {
        date_default_timezone_set("Asia/Manila");
        $data = $this->getUserData();
        $id = $this->input->post("ID");

        if ($this->db->where("ID", $id)->update("tbl_users", $data)) {
            $details = "Username: " . $data['IMS_USERS_UNAME'] . " (" . $data['IMS_USERS_NAME'] . ", Role: " . $data['IMS_USERS_ROLE'] . ")";
            log_audit("UPDATED USER", $details);
            $this->setSuccessFlashMessage("Data has been updated.");
        } else {
            $this->setErrorFlashMessage("Data error updating.");
        }

        $this->redirectUsersPage();
    }

    public function deleteUsers()
    {
        $id = $this->input->post("ID");
        $user = $this->db->where("ID", $id)->get("tbl_users")->row();
        $details = $user ? ("Username: " . $user->IMS_USERS_UNAME . " (" . $user->IMS_USERS_NAME . ")") : ("ID: " . $id);

        $this->db->where("ID", $id)->delete("tbl_users");
        log_audit("DELETED USER", $details);
        $this->setSuccessFlashMessage("Data has been deleted.");
        $this->redirectUsersPage();
    }

    private function getUserData()
    {
        $data = [
            "IMS_USERS_NAME" => $this->validate_data($this->input->post("IMS_USERS_NAME")),
            "IMS_USERS_ROLE" => $this->input->post("IMS_USERS_ROLE"),
            "IMS_USERS_UNAME" => $this->validate_data($this->input->post("IMS_USERS_UNAME")),
            "IMS_USERS_STATUS" => $this->input->post("IMS_USERS_STATUS"),
            "IMS_USERS_DATE" => date('Y-m-d H:i:s')
        ];

        $dp = $this->db->where("ID", $this->input->post("ID"))->get("tbl_users")->row("IMS_USERS_DP");
        if ($dp === "0") {
            $data["IMS_USERS_DP"] = "0";
        } else {
            $data["IMS_USERS_DP"] = "1";
        }

        // Check if password is provided
        if ($this->input->post("IMS_USERS_PWORD") !== "") {
            $data["IMS_USERS_PWORD"] = password_hash($this->input->post("IMS_USERS_PWORD"), PASSWORD_BCRYPT);
        }

        return $data;
    }

    private function setSuccessFlashMessage($message)
    {
        $this->session->set_flashdata('success', $message);
    }

    private function setErrorFlashMessage($message)
    {
        $this->session->set_flashdata('error', $message);
    }

    private function redirectUsersPage()
    {
        redirect(base_url() . 'ims/users');
    }

    public function get_user_permissions($ID)
    {
        $query = $this->db->where('USER_ID', $ID)->get('tbl_permissions');
        $permissions = [];

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $permissions[$row->PAGE] = $row->ACTIONS;
            }
        }

        return $permissions;
    }

    public function save_permissions($ID, $permissions)
    {
        // First delete existing permissions
        $this->db->where('USER_ID', $ID)->delete('tbl_permissions');

        // Insert new permissions
        $batch_data = [];
        foreach ($permissions as $permission) {
            $batch_data[] = [
                'USER_ID' => $ID,
                'PAGE' => $permission['page'],
                'ACTIONS' => $permission['actions'],
                'CREATED_AT' => date('Y-m-d H:i:s')
            ];
        }

        $user = $this->db->where("ID", $ID)->get("tbl_users")->row();
        $uname = $user ? $user->IMS_USERS_UNAME : "ID: " . $ID;
        log_audit("UPDATED USER PERMISSIONS", "User: " . $uname);

        if (!empty($batch_data)) {
            return $this->db->insert_batch('tbl_permissions', $batch_data);
        }

        return true;
    }
}
