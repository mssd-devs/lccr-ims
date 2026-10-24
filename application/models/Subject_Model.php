<?php

#[AllowDynamicProperties]
class Subject_Model extends CI_Model
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

    function LoadSubjects()
    {
        $query = $this->db->query("SELECT * FROM tbl_subject ORDER BY ID ASC");
        return $query;
    }

    function LoadPrograms()
    {
        $query = $this->db->query("SELECT DISTINCT P_PDESCRIPTIONS FROM tbl_program WHERE P_PROGSTATUS = 'ACTIVE'");
        return $query;
    }

    function LoadMajor()
    {
        $result = "";
        $maj = $this->input->post("maj");
        $query = $this->db->where("P_PDESCRIPTIONS", $maj)->get("tbl_program");
        $result .= "<option value=''>--Select Major--</option>";
        foreach ($query->result() as $r) {
            $result .= "<option>" . $r->P_MAJOR . "</option>";
        }
        return $result;
    }

    function LoadSemester()
    {
        $result = "<option value=''>--Select Semester--</option>";
        $prog = $this->input->post("prog");
        $maj = $this->input->post("maj");

        $this->db->where("P_PDESCRIPTIONS", $prog);
        if (!empty($maj)) {
            $this->db->where("P_MAJOR", $maj);
        }
        $query = $this->db->get("tbl_program");

        $added_semesters = [];
        foreach ($query->result() as $r) {
            $semesters = $this->db
                ->order_by("SEM_NAME", "ASC")
                ->get("tbl_semestertype")
                ->result();

            foreach ($semesters as $semester) {
                if ($r->P_SEMTYPE == $semester->SEM_TYPE && !in_array($semester->SEM_NAME, $added_semesters)) {
                    $result .= "<option value='" . htmlspecialchars($semester->SEM_NAME, ENT_QUOTES) . "'>" . htmlspecialchars($semester->SEM_NAME, ENT_QUOTES) . "</option>";
                    $added_semesters[] = $semester->SEM_NAME;
                }
            }
        }

        if (empty($added_semesters) && !empty($maj)) {
            $query = $this->db->where("P_PDESCRIPTIONS", $prog)->get("tbl_program");
            foreach ($query->result() as $r) {
                $semesters = $this->db
                    ->order_by("SEM_NAME", "ASC")
                    ->get("tbl_semestertype")
                    ->result();

                foreach ($semesters as $semester) {
                    if ($r->P_SEMTYPE == $semester->SEM_TYPE && !in_array($semester->SEM_NAME, $added_semesters)) {
                        $result .= "<option value='" . htmlspecialchars($semester->SEM_NAME, ENT_QUOTES) . "'>" . htmlspecialchars($semester->SEM_NAME, ENT_QUOTES) . "</option>";
                        $added_semesters[] = $semester->SEM_NAME;
                    }
                }
            }
        }

        if (empty($added_semesters)) {
            $semesters = $this->db->order_by("SEM_NAME", "ASC")->get("tbl_semestertype")->result();
            foreach ($semesters as $semester) {
                if (!in_array($semester->SEM_NAME, $added_semesters)) {
                    $result .= "<option value='" . htmlspecialchars($semester->SEM_NAME, ENT_QUOTES) . "'>" . htmlspecialchars($semester->SEM_NAME, ENT_QUOTES) . "</option>";
                    $added_semesters[] = $semester->SEM_NAME;
                }
            }
        }

        return $result;
    }

    function SaveSubjects()
    {
        $prog     = $this->input->post("S_SELECTPROG");
        $major    = $this->validate_data($this->input->post("S_MAJOR"));
        $scode    = $this->validate_data($this->input->post("S_SCODE"));
        $sdesc    = $this->validate_data($this->input->post("S_SDESCRIPTION"));
        $units    = $this->validate_data($this->input->post("S_UNITS"));
        $prereq   = $this->validate_data($this->input->post("S_PREREQ"));
        $yrlvl    = $this->input->post("S_YRLVL");
        $sem      = $this->input->post("S_SEM");
        $subtype  = $this->input->post("S_SUBTYPE");

        $this->db->where([
            'S_SELECTPROG' => $prog,
            'S_MAJOR' => $major,
            'S_SCODE' => $scode,
            'S_SDESCRIPTION' => $sdesc,
            'S_UNITS' => $units,
            'S_PREREQ' => $prereq,
            'S_YRLVL' => $yrlvl,
        ]);
        $fullDup = $this->db->get('tbl_subject')->num_rows();

        if ($fullDup > 0) {
            $this->session->set_flashdata('error', "Duplicate entry: Subject with the exact same details already exists.");
            redirect(base_url() . 'ims/entries/subject');
            return;
        }

        $data = [
            "S_SELECTPROG" => $prog,
            "S_MAJOR" => $major,
            "S_SCODE" => $scode,
            "S_SDESCRIPTION" => $sdesc,
            "S_UNITS" => $units,
            "S_PREREQ" => $prereq,
            "S_YRLVL" => $yrlvl,
            "S_SEM" => $sem,
            "S_SUBTYPE" => $subtype
        ];

        if ($this->db->insert("tbl_subject", $data)) {
            $details = $scode . " - " . $sdesc . " (" . $prog . ")";
            log_audit("SAVED NEW SUBJECT", $details);
            $this->session->set_flashdata('success', "Data has been saved.");
        } else {
            $this->session->set_flashdata('error', "Error saving data.");
        }
        redirect(base_url() . 'ims/entries/subject');
    }

    public function validate_updatedata($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function UpdateSubjects()
    {
        $id = $this->input->post("ID");
        $data = [
            "S_SELECTPROG" => $this->input->post("S_SELECTPROG"),
            "S_MAJOR" => $this->validate_updatedata($this->input->post("S_MAJOR")),
            "S_SCODE" => $this->validate_updatedata($this->input->post("S_SCODE")),
            "S_SDESCRIPTION" => $this->validate_updatedata($this->input->post("S_SDESCRIPTION")),
            "S_UNITS" => $this->validate_updatedata($this->input->post("S_UNITS")),
            "S_PREREQ" => $this->validate_updatedata($this->input->post("S_PREREQ")),
            "S_YRLVL" => $this->input->post("S_YRLVL"),
            "S_SEM" => $this->input->post("S_SEM"),
            "S_SUBTYPE" => $this->input->post("S_SUBTYPE")
        ];

        $this->db->where("ID", $id);
        if ($this->db->update("tbl_subject", $data)) {
            $details = $data['S_SCODE'] . " - " . $data['S_SDESCRIPTION'];
            log_audit("UPDATED SUBJECT", $details);
            $this->session->set_flashdata('success', "Data has been saved.");
        } else {
            $this->session->set_flashdata('error', "Data error saving.");
        }
        redirect(base_url() . 'ims/entries/subject');
    }

    public function DeleteSubjects()
    {
        $id = $this->input->post("ID");
        $subj = $this->db->where("ID", $id)->get("tbl_subject")->row();
        $details = $subj ? ($subj->S_SCODE . " - " . $subj->S_SDESCRIPTION) : ("ID: " . $id);

        $this->db->where("ID", $id)->delete("tbl_subject");
        log_audit("DELETED SUBJECT", $details);
        $this->session->set_flashdata('success', "Data has been deleted.");
        redirect(base_url() . 'ims/entries/subject');
    }
}
