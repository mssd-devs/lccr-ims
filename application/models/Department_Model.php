<?php
#[AllowDynamicProperties]
class Department_Model extends CI_Model
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

    public function LoadDepartments()
    {
        $this->db->order_by('ID', 'DESC');
        return $this->db->get('tbl_department')->result();
    }

    function SaveDepartments()
    {
        $data = [
            "D_DEPTCODE" => $this->validate_data($this->input->post("D_DEPTCODE")),
            "D_DEPTDESCRIPTION" => $this->validate_data($this->input->post("D_DEPTDESCRIPTION"))
        ];

        // Duplicate check
        $this->db->group_start();
        $this->db->where('D_DEPTCODE', $data['D_DEPTCODE']);
        $this->db->or_where('D_DEPTDESCRIPTION', $data['D_DEPTDESCRIPTION']);
        $this->db->group_end();
        $duplicate = $this->db->get('tbl_department')->row();

        if ($duplicate) {
            $this->session->set_flashdata('error', "Duplicate department code or description already exists.");
            redirect(base_url() . 'ims/entries/department');
            return;
        }

        // Proceed with insertion if no duplicate
        if ($this->db->insert("tbl_department", $data)) {
            $details = $data['D_DEPTCODE'] . " - " . $data['D_DEPTDESCRIPTION'];
            log_audit("SAVED NEW DEPARTMENT", $details);
            $this->session->set_flashdata('success', "Data has been saved.");
        } else {
            $this->session->set_flashdata('error', "Data error saving.");
        }

        redirect(base_url() . 'ims/entries/department');
    }

    public function validate_updatedata($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function UpdateDepartments()
    {
        $id = $this->input->post("ID");

        $data = [
            "D_DEPTCODE" => $this->validate_updatedata($this->input->post("D_DEPTCODE")),
            "D_DEPTDESCRIPTION" => $this->validate_updatedata($this->input->post("D_DEPTDESCRIPTION")),
        ];

        // Duplicate check excluding the current ID
        $this->db->group_start();
        $this->db->where('D_DEPTCODE', $data['D_DEPTCODE']);
        $this->db->or_where('D_DEPTDESCRIPTION', $data['D_DEPTDESCRIPTION']);
        $this->db->group_end();
        $this->db->where('ID !=', $id);
        $duplicate = $this->db->get('tbl_department')->row();

        if ($duplicate) {
            $this->session->set_flashdata('error', "Duplicate department code or description already exists.");
            redirect(base_url() . 'ims/entries/department');
            return;
        }

        // Proceed with update
        $this->db->where("ID", $id);
        if ($this->db->update("tbl_department", $data)) {
            $details = $data['D_DEPTCODE'] . " - " . $data['D_DEPTDESCRIPTION'];
            log_audit("UPDATED DEPARTMENT", $details);
            $this->session->set_flashdata('success', "Data has been saved.");
        } else {
            $this->session->set_flashdata('error', "Error saving data.");
        }

        redirect(base_url() . 'ims/entries/department');
    }

    public function DeleteDepartments()
    {
        $id = $this->input->post("ID");
        $dept = $this->db->where("ID", $id)->get("tbl_department")->row();
        $details = $dept ? ($dept->D_DEPTCODE . " - " . $dept->D_DEPTDESCRIPTION) : ("ID: " . $id);

        $this->db->where("ID", $id)->delete("tbl_department");
        log_audit("DELETED DEPARTMENT", $details);
        $this->session->set_flashdata('success', "Data has been deleted.");
        redirect(base_url() . 'ims/entries/department');
    }
}
