<?php
#[AllowDynamicProperties]
class Requirements_Model extends CI_Model
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

    function LoadRequirements()
    {
        $query = $this->db->query("SELECT * FROM tbl_requirements ORDER BY id DESC");
        return $query;
    }

    function SaveRequirements()
    {
        $data = [
            "REQ_CAT" => $this->input->post("REQ_CAT"),
            "REQS" => $this->validate_data($this->input->post("REQS"))
        ];
        if ($this->db->insert("tbl_requirements", $data)) {
            $details = $data['REQS'] . " (" . $data['REQ_CAT'] . ")";
            log_audit("SAVED NEW REQUIREMENT", $details);
            $this->session->set_flashdata('success', "Data has been saved.");
            redirect(base_url() . 'ims/entries/requirements');
        } else {
            $this->session->set_flashdata('error', "Data error saving.");
            redirect(base_url() . 'ims/entries/requirements');
        }
    }

    function UpdateRequirements()
    {
        $id = $this->input->post("ID");
        $data = [
            "REQ_CAT" => $this->input->post("REQ_CAT"),
            "REQS" => $this->validate_data($this->input->post("REQS")),
        ];
        $this->db->where("ID", $id);
        if ($this->db->update("tbl_requirements", $data)) {
            $details = $data['REQS'] . " (" . $data['REQ_CAT'] . ")";
            log_audit("UPDATED REQUIREMENT", $details);
            $this->session->set_flashdata('success', "Data has been updated.");
            redirect(base_url() . 'ims/entries/requirements');
        } else {
            $this->session->set_flashdata('error', "Data error saving.");
            redirect(base_url() . 'ims/entries/requirements');
        }
    }

    public function DeleteRequirements()
    {
        $id = $this->input->post("ID");
        $req = $this->db->where("ID", $id)->get("tbl_requirements")->row();
        $details = $req ? ($req->REQS . " (" . $req->REQ_CAT . ")") : ("ID: " . $id);

        $this->db->where("ID", $id)->delete("tbl_requirements");
        log_audit("DELETED REQUIREMENT", $details);
        $this->session->set_flashdata('success', "Data has been deleted.");
        redirect(base_url() . 'ims/entries/requirements');
    }
}
