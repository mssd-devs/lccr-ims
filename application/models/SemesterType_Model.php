<?php
#[AllowDynamicProperties]
class SemesterType_Model extends CI_Model
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

    function LoadSemesterType()
    {
        $query = $this->db->query("SELECT * FROM tbl_semestertype ORDER BY id DESC");
        return $query;
    }

    function SaveSemester()
    {
        $semType = $this->input->post("SEM_TYPE");
        $semName = $this->validate_data($this->input->post("SEM_NAME"));

        $this->db->where('SEM_NAME', $semName);
        $exists = $this->db->get('tbl_semestertype')->num_rows();

        if ($exists > 0) {
            $this->session->set_flashdata('error', "Duplicate entry: Semester type already exists.");
            redirect(base_url() . 'ims/entries/semestertype');
            return;
        }

        $data = [
            "SEM_TYPE" => $semType,
            "SEM_NAME" => $semName
        ];

        if ($this->db->insert("tbl_semestertype", $data)) {
            $details = $semName . " (" . $semType . ")";
            log_audit("SAVED NEW SEMESTER TYPE", $details);
            $this->session->set_flashdata('success', "Data has been saved.");
        } else {
            $this->session->set_flashdata('error', "Error saving data.");
        }

        redirect(base_url() . 'ims/entries/semestertype');
    }

    public function validate_updatedata($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function UpdateSemester()
    {
        $id = $this->input->post("ID");
        $semType = $this->input->post("SEM_TYPE");
        $semName = $this->validate_updatedata($this->input->post("SEM_NAME"));

        $this->db->where('SEM_NAME', $semName);
        $this->db->where('ID !=', $id);
        $exists = $this->db->get('tbl_semestertype')->num_rows();

        if ($exists > 0) {
            $this->session->set_flashdata('error', "Duplicate entry: Semester type already exists.");
            redirect(base_url() . 'ims/entries/semestertype');
            return;
        }

        $data = [
            "SEM_TYPE" => $semType,
            "SEM_NAME" => $semName,
        ];

        $this->db->where("ID", $id);
        if ($this->db->update("tbl_semestertype", $data)) {
            $details = $semName . " (" . $semType . ")";
            log_audit("UPDATED SEMESTER TYPE", $details);
            $this->session->set_flashdata('success', "Data has been saved.");
        } else {
            $this->session->set_flashdata('error', "Error saving data.");
        }

        redirect(base_url() . 'ims/entries/semestertype');
    }

    public function DeleteSemester()
    {
        $id = $this->input->post("ID");
        $sem = $this->db->where("ID", $id)->get("tbl_semestertype")->row();
        $details = $sem ? ($sem->SEM_NAME . " (" . $sem->SEM_TYPE . ")") : ("ID: " . $id);

        $this->db->where("ID", $id)->delete("tbl_semestertype");
        log_audit("DELETED SEMESTER TYPE", $details);
        $this->session->set_flashdata('success', "Data has been deleted.");
        redirect(base_url() . 'ims/entries/semestertype');
    }
}
