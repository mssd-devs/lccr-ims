<?php
#[AllowDynamicProperties]
class Programs_Model extends CI_Model
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

    function LoadPrograms()
    {
        $query = $this->db->query("SELECT * FROM tbl_program ORDER BY id DESC");
        return $query;
    }

    function SavePrograms()
    {
        $data = [
            "P_PCODE" => $this->validate_data($this->input->post("P_PCODE")),
            "P_PDESCRIPTIONS" => $this->validate_data($this->input->post("P_PDESCRIPTIONS")),
            "P_MAJOR" => $this->validate_data($this->input->post("P_MAJOR")),
            "P_SEMTYPE" => $this->input->post("P_SEMTYPE"),
            "P_PROGTYPE" => $this->input->post("P_PROGTYPE"),
            "P_CATEGORY" => $this->input->post("P_CATEGORY"),
            "P_SERIALCODE" => $this->validate_data($this->input->post("P_SERIALCODE")),
            "P_YEARISSUED" => $this->input->post("P_YEARISSUED"),
            "P_PROGSTATUS" => $this->input->post("P_PROGSTATUS")
        ];

        $this->db->where('P_PCODE', $data['P_PCODE']);
        $this->db->or_where('P_SERIALCODE', $data['P_SERIALCODE']);
        $duplicate = $this->db->get('tbl_program')->row();

        if ($duplicate) {
            $this->session->set_flashdata('error', "Duplicate entry detected: PCODE, Serial Code, or Description already exists.");
            redirect(base_url() . 'ims/entries/programs');
            return;
        }

        if ($this->db->insert("tbl_program", $data)) {
            $details = $data['P_PCODE'] . " - " . $data['P_PDESCRIPTIONS'];
            log_audit("SAVED NEW PROGRAM", $details);
            $this->session->set_flashdata('success', "Data has been saved.");
        } else {
            $this->session->set_flashdata('error', "Error saving data.");
        }

        redirect(base_url() . 'ims/entries/programs');
    }

    public function validate_updatedata($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function UpdatePrograms()
    {
        $id = $this->input->post("ID");

        $data = [
            "P_PCODE" => $this->validate_updatedata($this->input->post("P_PCODE")),
            "P_PDESCRIPTIONS" => $this->validate_updatedata($this->input->post("P_PDESCRIPTIONS")),
            "P_MAJOR" => $this->validate_updatedata($this->input->post("P_MAJOR")),
            "P_SEMTYPE" => $this->input->post("P_SEMTYPE"),
            "P_PROGTYPE" => $this->input->post("P_PROGTYPE"),
            "P_CATEGORY" => $this->input->post("P_CATEGORY"),
            "P_SERIALCODE" => $this->validate_updatedata($this->input->post("P_SERIALCODE")),
            "P_YEARISSUED" => $this->input->post("P_YEARISSUED"),
            "P_PROGSTATUS" => $this->input->post("P_PROGSTATUS")
        ];

        $this->db->group_start();
        $this->db->where('P_PCODE', $data['P_PCODE']);
        $this->db->or_where('P_SERIALCODE', $data['P_SERIALCODE']);
        $this->db->group_end();
        $this->db->where('ID !=', $id);
        $duplicate = $this->db->get('tbl_program')->row();

        if ($duplicate) {
            $this->session->set_flashdata('error', "Duplicate entry detected: PCODE, Serial Code, or Description already exists.");
            redirect(base_url() . 'ims/entries/programs');
            return;
        }

        $this->db->where("ID", $id);
        if ($this->db->update("tbl_program", $data)) {
            $details = $data['P_PCODE'] . " - " . $data['P_PDESCRIPTIONS'];
            log_audit("UPDATED PROGRAM", $details);
            $this->session->set_flashdata('success', "Data has been saved.");
        } else {
            $this->session->set_flashdata('error', "Error saving data.");
        }

        redirect(base_url() . 'ims/entries/programs');
    }

    public function DeletePrograms()
    {
        $id = $this->input->post("ID");
        $prog = $this->db->where("ID", $id)->get("tbl_program")->row();
        $details = $prog ? ($prog->P_PCODE . " - " . $prog->P_PDESCRIPTIONS) : ("ID: " . $id);

        $this->db->where("ID", $id)->delete("tbl_program");
        log_audit("DELETED PROGRAM", $details);
        $this->session->set_flashdata('success', "Data has been deleted.");
        redirect(base_url() . 'ims/entries/programs');
    }
}
