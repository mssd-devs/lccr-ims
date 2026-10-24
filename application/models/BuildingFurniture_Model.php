<?php
class BuildingFurniture_Model extends CI_Model
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

    function LoadBuildingFurniture()
    {
        $query = $this->db->query("SELECT * FROM tbl_buildingfurniture ORDER BY ID DESC");
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

        return array_unique($permission);
    }

    function saveBuildingFurniture()
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "USEBYSTUDENT" => $this->validate_data($this->input->post("USEBYSTUDENT")),
            "USEBYFACULTY" => $this->validate_data($this->input->post("USEBYFACULTY")),
            "CLASSROOMSUBTOTAL" => $this->validate_data($this->input->post("CLASSROOMSUBTOTAL")),
            "WITHTOILET" => $this->validate_data($this->input->post("WITHTOILET")),
            "WITHOUTTOILET" => $this->validate_data($this->input->post("WITHOUTTOILET")),
            "COMMONTOILET" => $this->validate_data($this->input->post("COMMONTOILET")),
            "BUILDINGGOOD" => $this->validate_data($this->input->post("BUILDINGGOOD")),
            "BUILDINGMINOR" => $this->validate_data($this->input->post("BUILDINGMINOR")),
            "BUILDINGMAJOR" => $this->validate_data($this->input->post("BUILDINGMAJOR")),
            "REPAIRSUBTOTAL" => $this->validate_data($this->input->post("REPAIRSUBTOTAL")),
            "DEMOLITION" => $this->validate_data($this->input->post("DEMOLITION")),
            "CONSTRUCTION" => $this->validate_data($this->input->post("CONSTRUCTION")),
            "MAKESHIFT" => $this->validate_data($this->input->post("MAKESHIFT")),
            "DATE_SUBMITTED" => date('Y-m-d H:i:s')
        ];

        if ($this->db->insert("tbl_buildingfurniture", $data)) {
            $insert_id = $this->db->insert_id();
            $details = "Record ID: " . $insert_id . " (Classroom Subtotal: " . $data['CLASSROOMSUBTOTAL'] . ")";
            log_audit("SAVED BUILDING & FURNITURE RECORD", $details);
            $this->session->set_flashdata('success', "Data has been saved.");
        } else {
            $this->session->set_flashdata('error', "Data error saving.");
        }

        redirect(base_url() . 'ims/buildingsfurniture');
    }

    public function validate_updatedata($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function updateBuildingFurniture()
    {
        $id = $this->input->post("ID");

        $data = [
            "USEBYSTUDENT" => $this->validate_updatedata($this->input->post("USEBYSTUDENT")),
            "USEBYFACULTY" => $this->validate_updatedata($this->input->post("USEBYFACULTY")),
            "CLASSROOMSUBTOTAL" => $this->validate_updatedata($this->input->post("CLASSROOMSUBTOTAL")),
            "WITHTOILET" => $this->validate_updatedata($this->input->post("WITHTOILET")),
            "WITHOUTTOILET" => $this->validate_updatedata($this->input->post("WITHOUTTOILET")),
            "COMMONTOILET" => $this->validate_updatedata($this->input->post("COMMONTOILET")),
            "BUILDINGGOOD" => $this->validate_updatedata($this->input->post("BUILDINGGOOD")),
            "BUILDINGMINOR" => $this->validate_updatedata($this->input->post("BUILDINGMINOR")),
            "BUILDINGMAJOR" => $this->validate_updatedata($this->input->post("BUILDINGMAJOR")),
            "REPAIRSUBTOTAL" => $this->validate_updatedata($this->input->post("REPAIRSUBTOTAL")),
            "DEMOLITION" => $this->validate_updatedata($this->input->post("DEMOLITION")),
            "CONSTRUCTION" => $this->validate_updatedata($this->input->post("CONSTRUCTION")),
            "MAKESHIFT" => $this->validate_updatedata($this->input->post("MAKESHIFT")),
            "DATE_SUBMITTED" => date('Y-m-d H:i:s')
        ];

        $this->db->where("ID", $id);
        if ($this->db->update("tbl_buildingfurniture", $data)) {
            $details = "Record ID: " . $id;
            log_audit("UPDATED BUILDING & FURNITURE RECORD", $details);
            $this->session->set_flashdata('success', "Building & Furniture has been updated.");
        } else {
            $this->session->set_flashdata('error', "Failed to update Building & Furniture.");
        }

        redirect(base_url() . 'ims/buildingsfurniture');
    }

    public function deleteBuildingFurniture()
    {
        $id = $this->input->post("ID");
        if (!$id) {
            $this->session->set_flashdata('error', "Invalid Building & Furniture ID.");
            redirect(base_url('ims/buildingsfurniture'));
        }

        $this->db->where("ID", $id);
        if ($this->db->delete("tbl_buildingfurniture")) {
            log_audit("DELETED BUILDING & FURNITURE RECORD", "Record ID: " . $id);
            $this->session->set_flashdata('success', "Building & Furniture has been deleted.");
        } else {
            $this->session->set_flashdata('error', "Failed to delete Building & Furniture.");
        }

        redirect(base_url('ims/buildingsfurniture'));
    }
}
