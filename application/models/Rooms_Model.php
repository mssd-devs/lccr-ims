<?php
#[AllowDynamicProperties]
class Rooms_Model extends CI_Model
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

    function LoadRooms()
    {
        $query = $this->db->query("SELECT * FROM tbl_rooms ORDER BY ID ASC");
        return $query;
    }
    function LoadDepartment()
    {
        $query = $this->db->query("SELECT * FROM tbl_department");
        return $query;
    }

    public function generate_room_code()
    {
        $sched_code = 'RM' . rand(1000, 9999);
        return $sched_code;
    }

    function SaveRooms()
    {
        $rmCode = $this->generate_room_code();
        $rmDesc = $this->validate_data($this->input->post("R_RMDESCRIPTION"));
        $rmDept = $this->input->post("R_RMDEPT");

        $this->db->where('R_RMDESCRIPTION', $rmDesc);
        $exists = $this->db->get('tbl_rooms')->num_rows();

        if ($exists > 0) {
            $this->session->set_flashdata('error', "Duplicate entry: Room Name already exist.");
            redirect(base_url() . 'ims/entries/rooms');
            return;
        }

        $data = [
            "R_RMDEPT" => $rmDept,
            "R_RMCODE" => $rmCode,
            "R_RMDESCRIPTION" => $rmDesc
        ];

        if ($this->db->insert("tbl_rooms", $data)) {
            $details = $rmCode . " - " . $rmDesc;
            log_audit("SAVED NEW ROOM", $details);
            $this->session->set_flashdata('success', "Data has been saved.");
        } else {
            $this->session->set_flashdata('error', "Error saving data.");
        }

        redirect(base_url() . 'ims/entries/rooms');
    }

    public function validate_updatedata($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function UpdateRooms()
    {
        $id = $this->input->post("ID");
        $rmDesc = $this->validate_updatedata($this->input->post("R_RMDESCRIPTION"));
        $rmDept = $this->input->post("R_RMDEPT");

        $this->db->where('R_RMDESCRIPTION', $rmDesc);
        $this->db->where('ID !=', $id);
        $exists = $this->db->get('tbl_rooms')->num_rows();

        if ($exists > 0) {
            $this->session->set_flashdata('error', "Duplicate entry: Room Name already exist.");
            redirect(base_url() . 'ims/entries/rooms');
            return;
        }

        $data = [
            "R_RMDEPT" => $rmDept,
            "R_RMDESCRIPTION" => $rmDesc,
        ];

        $this->db->where("ID", $id);
        if ($this->db->update("tbl_rooms", $data)) {
            $details = $rmDesc . " (ID: " . $id . ")";
            log_audit("UPDATED ROOM", $details);
            $this->session->set_flashdata('success', "Data has been saved.");
        } else {
            $this->session->set_flashdata('error', "Error saving data.");
        }

        redirect(base_url() . 'ims/entries/rooms');
    }

    public function DeleteRooms()
    {
        $id = $this->input->post("ID");
        $room = $this->db->where("ID", $id)->get("tbl_rooms")->row();
        $details = $room ? ($room->R_RMCODE . " - " . $room->R_RMDESCRIPTION) : ("ID: " . $id);

        $this->db->where("ID", $id)->delete("tbl_rooms");
        log_audit("DELETED ROOM", $details);
        $this->session->set_flashdata('success', "Data has been deleted.");
        redirect(base_url() . 'ims/entries/rooms');
    }
}
