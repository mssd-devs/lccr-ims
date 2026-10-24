<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class MyclassController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'security']);
        $this->load->model(['MyClass_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            // 'LoadSchedules' => $this->MyClass_Model->LoadSchedules(),
            'main' => 'myclass/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function view()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            // 'LoadApplication' => $this->Form1_Model->LoadApplication(),
            'main' => 'myclass/view_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function LoadMyClass()
    {
        $model_data = $this->MyClass_Model->LoadMyClass();
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'output' => $model_data['output'],
            'total_units' => $model_data['total_units'],
            'overload_units' => $model_data['overload_units']
        ];
        echo json_encode($data);
    }

    function print_my_schedule()
    {
        $FILTER_PROGRAM = $this->input->get("program");
        $FILTER_MAJOR = $this->input->get("major");
        $FILTER_YL = $this->input->get("yl");
        $FILTER_AY = $this->input->get("ay");
        $FILTER_SEM = $this->input->get("sem");

        $sql = "SELECT
                    *,
                    COALESCE(
                        (SELECT S_UNITS FROM tbl_subject WHERE S_SDESCRIPTION = tbl_scheduling.SC_SDESC AND S_SELECTPROG = tbl_scheduling.SC_PROG LIMIT 1),
                        (SELECT S_UNITS FROM tbl_subject WHERE S_SDESCRIPTION = tbl_scheduling.SC_SDESC LIMIT 1)
                    ) AS S_UNITS
                FROM
                    tbl_scheduling 
                WHERE SC_FACULTY ='" . $this->session->userdata('fullname') . "' 
                ";

        if (!empty($FILTER_PROGRAM)) {
            $sql .= " AND SC_PROG = '{$FILTER_PROGRAM}'";
        }
        if (!empty($FILTER_MAJOR)) {
            $sql .= " AND SC_MAJOR = '{$FILTER_MAJOR}'";
        }
        if (!empty($FILTER_YL)) {
            $sql .= " AND SC_YEARLEVEL = '{$FILTER_YL}'";
        }
        if (!empty($FILTER_AY)) {
            $sql .= " AND SC_ACADEMICYEAR = '{$FILTER_AY}'";
        }
        if (!empty($FILTER_SEM)) {
            $sql .= " AND SC_SEMESTER = '{$FILTER_SEM}'";
        }

        $query = $this->db->query($sql);
        $schedules = $query->result();

        // Calculate units for metadata
        $total_units = 0;
        foreach ($schedules as $sched) {
            $total_units += is_numeric($sched->S_UNITS) ? floatval($sched->S_UNITS) : 0;
        }
        $overload_units = ($total_units > 18) ? ($total_units - 18) : 0;

        // Get school settings for the header
        $school_query = $this->db->get("tbl_websettings");
        $school_info = $school_query->row();

        $data = [
            'schedules' => $schedules,
            'school_info' => $school_info,
            'total_units' => $total_units,
            'overload_units' => $overload_units,
            'filters' => [
                'program' => $FILTER_PROGRAM,
                'major' => $FILTER_MAJOR,
                'yl' => $FILTER_YL,
                'ay' => $FILTER_AY,
                'sem' => $FILTER_SEM
            ]
        ];

        $this->load->view('myclass/print_schedule_view', $data);
    }
}
