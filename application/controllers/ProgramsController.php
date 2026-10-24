<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class ProgramsController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['Programs_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function programs()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadPrograms' => $this->Programs_Model->LoadPrograms(),
            'main' => 'programs/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function edit()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadPrograms' => $this->db->where("ID", $this->uri->segment(5))->get("tbl_program"),
            'main' => 'programs/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function prospectus()
    {
        $id = $this->uri->segment(5);
        
        // Fetch the program
        $program = $this->db->where("ID", $id)->get("tbl_program")->row();
        if (!$program) {
            $this->session->set_flashdata("error", "Program not found.");
            redirect(base_url("ims/entries/programs"));
            return;
        }

        // Fetch subjects matching the program description and major
        $this->db->where("S_SELECTPROG", $program->P_PDESCRIPTIONS);
        if (!empty($program->P_MAJOR)) {
            $this->db->where("S_MAJOR", $program->P_MAJOR);
        } else {
            $this->db->group_start()
                     ->where("S_MAJOR", "")
                     ->or_where("S_MAJOR IS NULL")
                     ->group_end();
        }
        $subjects = $this->db->get("tbl_subject")->result();

        // Group subjects by Year Level and Semester
        $grouped_subjects = [];
        foreach ($subjects as $subject) {
            $yr = !empty($subject->S_YRLVL) ? trim($subject->S_YRLVL) : 'UNASSIGNED YEAR';
            $sem = !empty($subject->S_SEM) ? trim($subject->S_SEM) : 'UNASSIGNED SEMESTER';
            $grouped_subjects[$yr][$sem][] = $subject;
        }

        // Define ordering weights
        $year_order = [
            '1ST YEAR' => 1,
            '2ND YEAR' => 2,
            '3RD YEAR' => 3,
            '4TH YEAR' => 4,
            '5TH YEAR' => 5
        ];

        $sem_order = [
            '1ST SEMESTER' => 1,
            '2ND SEMESTER' => 2,
            '3RD SEMESTER' => 3,
            'SUMMER' => 4
        ];

        // Sort Year Levels
        uksort($grouped_subjects, function($a, $b) use ($year_order) {
            $valA = isset($year_order[$a]) ? $year_order[$a] : 99;
            $valB = isset($year_order[$b]) ? $year_order[$b] : 99;
            return $valA <=> $valB;
        });

        // Sort Semesters within each Year Level
        foreach ($grouped_subjects as $yr => &$sems) {
            uksort($sems, function($a, $b) use ($sem_order) {
                $valA = isset($sem_order[$a]) ? $sem_order[$a] : 99;
                $valB = isset($sem_order[$b]) ? $sem_order[$b] : 99;
                return $valA <=> $valB;
            });
        }
        unset($sems);

        $data = [
            'token' => $this->security->get_csrf_hash(),
            'program' => $program,
            'grouped_subjects' => $grouped_subjects,
            'main' => 'programs/prospectus_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function SavePrograms()
    {
        $this->Programs_Model->SavePrograms();
    }
    function UpdatePrograms()
    {
        $this->Programs_Model->UpdatePrograms();
    }
    function DeletePrograms()
    {
        $this->Programs_Model->DeletePrograms();
    }
}
