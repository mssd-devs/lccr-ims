<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class SchedulingController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['Scheduling_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'rbac' => $this->db->where("USER_ID", $this->session->userdata("id"))->where("PAGE", "Scheduling")->get("tbl_permissions"),
            'main' => 'scheduling/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function create()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadPrograms' => $this->Scheduling_Model->LoadPrograms(),
            'LoadSubject' => $this->db->get("tbl_subject"),
            'LoadFaculty' => $this->db->get("tbl_facprof"),
            'LoadDepartment' => $this->db->get("tbl_department"),
            'LoadRoom' => $this->db->get("tbl_rooms"),
            'LoadSection' => $this->db->get("tbl_section"),
            'main' => 'scheduling/create_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function edit()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadSchedules' => $this->db->get("tbl_scheduling"),
            'LoadPrograms' => $this->Scheduling_Model->LoadPrograms(),
            'LoadSubject' => $this->db->get("tbl_subject"),
            'LoadFaculty' => $this->db->get("tbl_facprof"),
            'LoadDepartment' => $this->db->get("tbl_department"),
            'LoadRoom' => $this->db->get("tbl_rooms"),
            'LoadSection' => $this->db->get("tbl_section"),
            'main' => 'scheduling/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function SaveSchedules()
    {
        $this->Scheduling_Model->SaveSchedules();
    }
    function UpdateSchedules()
    {
        $this->Scheduling_Model->UpdateSchedules();
    }
    function DeleteSchedules()
    {
        $this->Scheduling_Model->DeleteSchedules();
    }

    function LoadRoom()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->Scheduling_Model->LoadRoom()
        ];
        echo json_encode($data);
    }
    function LoadYearLevel()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->Scheduling_Model->LoadYearLevel()
        ];
        echo json_encode($data);
    }
    function LoadSemester()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->Scheduling_Model->LoadSemester()
        ];
        echo json_encode($data);
    }

    function LoadSubject()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->Scheduling_Model->LoadSubject()
        ];
        echo json_encode($data);
    }

    function LoadMajor()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->Scheduling_Model->LoadMajor()
        ];
        echo json_encode($data);
    }
    function LoadSection()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'result' => $this->Scheduling_Model->LoadSection()
        ];
        echo json_encode($data);
    }
    function LoadSchedules()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->Scheduling_Model->LoadSchedules()
        ];
        echo json_encode($data);
    }

    function print_room_schedule()
    {
        $room = $this->input->get('room');
        $ay   = $this->input->get('ay');
        $sem  = $this->input->get('sem');

        if (empty($room)) {
            show_error("Room is required for printing schedule.", 400);
        }

        // Only filter on ay/sem when they are non-empty (empty string = no filter)
        $this->db->where('SC_ROOM', $room);
        if (!empty($ay))  $this->db->where('SC_ACADEMICYEAR', $ay);
        if (!empty($sem)) $this->db->where('SC_SEMESTER', $sem);

        $query     = $this->db->get('tbl_scheduling');
        $schedules = $query->result();

        // Separate them
        $mwf_schedules = [];
        $tth_schedules = [];
        $other_schedules = [];

        foreach ($schedules as $sched) {
            $day = strtoupper(trim($sched->SC_DAY));
            if (in_array($day, ['MWF', 'M', 'W', 'F'])) {
                $mwf_schedules[] = $sched;
            } elseif (in_array($day, ['TTH', 'T', 'TH'])) {
                $tth_schedules[] = $sched;
            } else {
                $other_schedules[] = $sched;
            }
        }

        // Sort by start time
        usort($mwf_schedules, function ($a, $b) {
            return strcmp($a->SC_STARTTIME, $b->SC_STARTTIME);
        });
        usort($tth_schedules, function ($a, $b) {
            return strcmp($a->SC_STARTTIME, $b->SC_STARTTIME);
        });
        usort($other_schedules, function ($a, $b) {
            return strcmp($a->SC_STARTTIME, $b->SC_STARTTIME);
        });

        $data = [
            'room' => $room,
            'ay' => $ay,
            'sem' => $sem,
            'mwf_schedules' => $mwf_schedules,
            'tth_schedules' => $tth_schedules,
            'other_schedules' => $other_schedules
        ];

        $this->load->view('scheduling/print_room_schedule_view', $data);
    }
}
