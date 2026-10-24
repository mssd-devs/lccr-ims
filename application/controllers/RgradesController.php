<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class RgradesController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'security']);
        $this->load->model(['RGrades_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'rgrades/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function edit()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'rgrades/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function torprint()
    {
        $this->load->view('rgrades/print_tor_view');
    }

    function semprint()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'rgrades/print_semgrade_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function viewprofile()
    {
        redirect(base_url('ims/grade/rgrades'));
    }

    function LoadStudentGrades()
    {
        $res = $this->RGrades_Model->LoadStudentGrades();
        $data = [
            'token'  => $this->security->get_csrf_hash(),
            'output' => is_array($res) ? $res['output'] : $res,
            'modals' => is_array($res) ? $res['modals'] : ''
        ];
        echo json_encode($data);
    }

    public function edit_grades($student_id, $academic_year, $semester)
    {
        $data['student_id']  = $student_id;
        $data['grade_group'] = $this->RGrades_Model->get_grade_group_info($academic_year, $semester);
        $data['subjects']    = $this->RGrades_Model->get_subjects_by_student($student_id, $academic_year, $semester);

        $this->load->view('grades/edit_modal', $data);
    }

    public function update_grades()
    {
        $subjects_data = $this->input->post('subjects');
        $this->RGrades_Model->update_multiple_subjects($subjects_data);

        $this->session->set_flashdata('success', 'Grades updated successfully.');
        redirect($_SERVER['HTTP_REFERER']);
    }
}
