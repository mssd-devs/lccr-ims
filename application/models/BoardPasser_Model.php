<?php
class BoardPasser_Model extends CI_Model
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

    function LoadBoardPasser()
    {
        $query = $this->db->query("SELECT * FROM tbl_boardpasser ORDER BY ID DESC");
        return $query;
    }

    function LoadPrograms()
    {
        $query = $this->db->query("SELECT DISTINCT P_PDESCRIPTIONS FROM tbl_program");
        return $query;
    }


    function check_permission()
    {
        if ($this->session->userdata("usertype") === "Administrator") {
            return ['View', 'Edit', 'Delete', 'Create'];
        }

        $permission = [];
        $query = $this->db->where([
            "USER_ID" => $this->session->userdata("id"),
            "PAGE" => "Scheduling"
        ])->get("tbl_permissions");

        foreach ($query->result() as $row) {
            $actions = array_map('trim', explode(',', $row->ACTIONS));
            $permission = array_merge($permission, $actions);
        }

        return array_unique($permission); // avoid duplicate actions
    }


    function LoadMajor()
    {
        $result = "";
        $maj = $this->input->post("maj");
        $query = $this->db->where("P_PDESCRIPTIONS", $maj)->get("tbl_program");
        $result .= "<option selected=''></option>";
        foreach ($query->result() as $r) {
            $result .= "<option>" . $r->P_MAJOR . "</option>";
        }
        return $result;
    }


    function saveBoardPasser()
    {

        date_default_timezone_set("Asia/Manila");
        $data = [
            "PROGRAM" => $this->validate_data($this->input->post("PROGRAM")),
            "MAJOR" => $this->validate_data($this->input->post("MAJOR")),
            "YEAR" => $this->validate_data($this->input->post("YEAR")),
            "MONTH" => $this->validate_data($this->input->post("MONTH")),
            "FT_PASSED" => $this->validate_data($this->input->post("FT_PASSED")),
            "FT_FAILED" => $this->validate_data($this->input->post("FT_FAILED")),
            "FT_SUBTOTAL" => $this->input->post("FT_SUBTOTAL"),
            "FT_TOTALPERCENT" => $this->input->post("FT_TOTALPERCENT"),
            "RT_PASSED" => $this->validate_data($this->input->post("RT_PASSED")),
            "RT_FAILED" => $this->validate_data($this->input->post("RT_FAILED")),
            "RT_SUBTOTAL" => $this->input->post("RT_SUBTOTAL"),
            "RT_TOTALPERCENT" => $this->input->post("RT_TOTALPERCENT"),
            "OP_PASSED" => $this->input->post("OP_PASSED"),
            "OP_FAILED" => $this->input->post("OP_FAILED"),
            "OP_GRANDTOTAL" => $this->input->post("OP_GRANDTOTAL"),
            "OP_GRANDTOTALPERCENT" => $this->input->post("OP_GRANDTOTALPERCENT"),
            "DATE_SUBMITTED" => date('Y-m-d H:i:s')
        ];


        // 3. Insert new schedule
        if ($this->db->insert("tbl_boardpasser", $data)) {
            $details = "Program: " . $data['PROGRAM'] . ", Year/Month: " . $data['YEAR'] . " " . $data['MONTH'];
            log_audit("SAVED BOARD PASSER RECORD", $details);
            $this->session->set_flashdata('success', "Data has been saved.");
        } else {
            $this->session->set_flashdata('error', "Data error saving.");
        }

        redirect(base_url() . 'ims/boardpasser');
    }

    public function validate_updatedata($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function updateBoardPasser()
    {

        $id = $this->input->post("ID");

        $data = [
            "PROGRAM" => $this->validate_updatedata($this->input->post("PROGRAM")),
            "MAJOR" => $this->validate_updatedata($this->input->post("MAJOR")),
            "YEAR" => $this->validate_updatedata($this->input->post("YEAR")),
            "MONTH" => $this->validate_updatedata($this->input->post("MONTH")),
            "FT_PASSED" => $this->validate_updatedata($this->input->post("FT_PASSED")),
            "FT_FAILED" => $this->validate_updatedata($this->input->post("FT_FAILED")),
            "FT_SUBTOTAL" => $this->input->post("FT_SUBTOTAL"),
            "FT_TOTALPERCENT" => $this->input->post("FT_TOTALPERCENT"),
            "RT_PASSED" => $this->validate_updatedata($this->input->post("RT_PASSED")),
            "RT_FAILED" => $this->validate_updatedata($this->input->post("RT_FAILED")),
            "RT_SUBTOTAL" => $this->input->post("RT_SUBTOTAL"),
            "RT_TOTALPERCENT" => $this->input->post("RT_TOTALPERCENT"),
            "OP_PASSED" => $this->input->post("OP_PASSED"),
            "OP_FAILED" => $this->input->post("OP_FAILED"),
            "OP_GRANDTOTAL" => $this->input->post("OP_GRANDTOTAL"),
            "OP_GRANDTOTALPERCENT" => $this->input->post("OP_GRANDTOTALPERCENT"),
            "DATE_SUBMITTED" => date('Y-m-d H:i:s')
        ];


        // 3. Proceed to update
        $this->db->where("ID", $id);
        if ($this->db->update("tbl_boardpasser", $data)) {
            $details = "Program: " . $data['PROGRAM'] . " (ID: " . $id . ")";
            log_audit("UPDATED BOARD PASSER RECORD", $details);
            $this->session->set_flashdata('success', "Board Passer has been updated.");
        } else {
            $this->session->set_flashdata('error', "Failed to update Board Passer.");
        }

        redirect(base_url() . 'ims/boardpasser');
    }


    public function deleteBoardPasser()
    {

        $id = $this->input->post("ID");
        if (!$id) {
            $this->session->set_flashdata('error', "Invalid Board Passer ID.");
            redirect(base_url('ims/boardpasser'));
        }

        $bp = $this->db->where("ID", $id)->get("tbl_boardpasser")->row();
        $details = $bp ? ("Program: " . $bp->PROGRAM . ", Year/Month: " . $bp->YEAR . " " . $bp->MONTH) : ("ID: " . $id);

        // Perform delete
        $this->db->where("ID", $id);
        if ($this->db->delete("tbl_boardpasser")) {
            log_audit("DELETED BOARD PASSER RECORD", $details);
            $this->session->set_flashdata('success', "Board Passer has been deleted.");
        } else {
            $this->session->set_flashdata('error', "Failed to delete Board Passer.");
        }

        redirect(base_url('ims/boardpasser'));
    }
}
