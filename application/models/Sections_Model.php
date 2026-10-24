<?php
#[AllowDynamicProperties]
class Sections_Model extends CI_Model
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

    function LoadSections()
    {
        $query = $this->db->query("SELECT * FROM tbl_section ORDER BY ID ASC");
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

    public function generate_section_code()
    {
        $sched_code = 'SC' . rand(1000, 9999);
        return $sched_code;
    }

    function SaveSections()
    {
        $rmCode = $this->generate_section_code();

        $sectionDesc = $this->validate_data($this->input->post("SEC_SDESC"));
        $sectionProg = $this->input->post("SEC_SPROG");
        $sectionMajor = $this->input->post("SEC_PROGMAJOR");
        $sectionYearLevel = $this->input->post("SEC_SYRLVL");
        $sectionSem = $this->input->post("SEC_SSEM");

        $data = [
            "SEC_SCODE" => $rmCode,
            "SEC_SDESC" => $sectionDesc,
            "SEC_NOCAP" => $this->validate_data($this->input->post("SEC_NOCAP")),
            "SEC_SPROG" => $sectionProg,
            "SEC_PROGMAJOR" => $sectionMajor,
            "SEC_SYRLVL" => $sectionYearLevel,
            "SEC_SSEM" => $sectionSem
        ];

        $this->db->where('SEC_SDESC', $sectionDesc);
        $this->db->where('SEC_SPROG !=', $sectionProg);
        $usedInOtherProgram = $this->db->get('tbl_section')->row();

        if ($usedInOtherProgram) {
            $this->session->set_flashdata('error', "Section name already used in a different program.");
            redirect(base_url() . 'ims/entries/sections');
            return;
        }

        $this->db->where([
            'SEC_SDESC' => $sectionDesc,
            'SEC_SPROG' => $sectionProg,
            'SEC_SYRLVL' => $sectionYearLevel,
            'SEC_SSEM' => $sectionSem
        ]);
        $exactDuplicate = $this->db->get('tbl_section')->row();

        if ($exactDuplicate) {
            $this->session->set_flashdata('error', "Duplicate section name already exists for this program, year level, and semester.");
            redirect(base_url() . 'ims/entries/sections');
            return;
        }

        if ($this->db->insert("tbl_section", $data)) {
            $details = $sectionDesc . " (" . $sectionProg . ")";
            log_audit("SAVED NEW SECTION", $details);
            $this->session->set_flashdata('success', "Section has been saved.");
        } else {
            $this->session->set_flashdata('error', "Error saving section.");
        }

        redirect(base_url() . 'ims/entries/sections');
    }

    public function validate_updatedata($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function UpdateSections()
    {
        $id = $this->input->post("ID");

        $data = [
            "SEC_SDESC" => $this->validate_updatedata($this->input->post("SEC_SDESC")),
            "SEC_NOCAP" => $this->validate_updatedata($this->input->post("SEC_NOCAP")),
            "SEC_SPROG" => $this->input->post("SEC_SPROG"),
            "SEC_PROGMAJOR" => $this->input->post("SEC_PROGMAJOR"),
            "SEC_SYRLVL" => $this->input->post("SEC_SYRLVL"),
            "SEC_SSEM" => $this->input->post("SEC_SSEM")
        ];

        $this->db->group_start();
        $this->db->where('SEC_SDESC', $data['SEC_SDESC']);
        $this->db->group_end();
        $this->db->where('ID !=', $id);
        $duplicate = $this->db->get('tbl_section')->row();

        if ($duplicate) {
            $this->session->set_flashdata('error', "Duplicate section code or description already exists.");
            redirect(base_url() . 'ims/entries/sections');
            return;
        }

        $this->db->where("ID", $id);
        if ($this->db->update("tbl_section", $data)) {
            $details = $data['SEC_SDESC'] . " (" . $data['SEC_SPROG'] . ")";
            log_audit("UPDATED SECTION", $details);
            $this->session->set_flashdata('success', "Data has been updated.");
        } else {
            $this->session->set_flashdata('error', "Error saving data.");
        }

        redirect(base_url() . 'ims/entries/sections');
    }

    public function DeleteSections()
    {
        $id = $this->input->post("ID");
        $sec = $this->db->where("ID", $id)->get("tbl_section")->row();
        $details = $sec ? ($sec->SEC_SDESC . " (" . $sec->SEC_SPROG . ")") : ("ID: " . $id);

        $this->db->where("ID", $id)->delete("tbl_section");
        log_audit("DELETED SECTION", $details);
        $this->session->set_flashdata('success', "Data has been deleted.");
        redirect(base_url() . 'ims/entries/sections');
    }
}
