<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class FacultyEvaluationController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['form', 'url', 'security']);
        $this->load->library(['session']);
        $this->load->model('FacultyEvaluation_Model');

        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    public function index()
    {
        $data['main'] = 'facultyevaluation/index_view';
        $this->load->view('layouts/main_view', $data);
    }

    public function save()
    {
        if ($this->input->method() !== 'post') {
            redirect(base_url("facultyevaluation"));
        }

        // Get POST data safely
        $postData = $this->input->post(NULL, TRUE);

        $result = $this->FacultyEvaluation_Model->save($postData);

        if ($result) {
            $this->session->set_flashdata("success", "Faculty evaluation saved successfully.");
        } else {
            $this->session->set_flashdata("error", "Failed to save faculty evaluation.");
        }

        redirect(base_url("facultyevaluation"));
    }

    public function ratings($id = NULL)
    {
        if (empty($id)) {
            $this->session->set_flashdata("error", "Invalid evaluation identifier.");
            redirect(base_url("facultyevaluation"));
        }

        $evaluation = $this->FacultyEvaluation_Model->get_evaluation_by_id($id);
        if (!$evaluation) {
            $this->session->set_flashdata("error", "Faculty evaluation record not found.");
            redirect(base_url("facultyevaluation"));
        }

        // Calculate explicit ratings (questions 1 to 15)
        $explicit_scores = [];
        for ($i = 1; $i <= 15; $i++) {
            $field = 'explicit_' . $i;
            if (isset($evaluation->$field) && $evaluation->$field !== NULL) {
                $explicit_scores[] = (int)$evaluation->$field;
            }
        }
        $explicit_avg = count($explicit_scores) > 0 ? array_sum($explicit_scores) / count($explicit_scores) : 0;

        // Calculate implicit ratings (questions 16 to 29)
        $implicit_scores = [];
        for ($i = 16; $i <= 29; $i++) {
            $field = 'implicit_' . $i;
            if (isset($evaluation->$field) && $evaluation->$field !== NULL) {
                $implicit_scores[] = (int)$evaluation->$field;
            }
        }
        $implicit_avg = count($implicit_scores) > 0 ? array_sum($implicit_scores) / count($implicit_scores) : 0;

        // Overall rating (all 29 questions)
        $all_scores = array_merge($explicit_scores, $implicit_scores);
        $overall_avg = count($all_scores) > 0 ? array_sum($all_scores) / count($all_scores) : 0;

        // Qualitative scale mapping
        $get_qualitative = function ($score) {
            if ($score >= 4.5) return ['label' => 'Outstanding', 'class' => 'bg-label-success', 'text_class' => 'text-success'];
            if ($score >= 3.5) return ['label' => 'Very Satisfactory', 'class' => 'bg-label-primary', 'text_class' => 'text-primary'];
            if ($score >= 2.5) return ['label' => 'Satisfactory', 'class' => 'bg-label-info', 'text_class' => 'text-info'];
            if ($score >= 1.5) return ['label' => 'Unsatisfactory', 'class' => 'bg-label-warning', 'text_class' => 'text-warning'];
            return ['label' => 'Poor', 'class' => 'bg-label-danger', 'text_class' => 'text-danger'];
        };

        $data['evaluation'] = $evaluation;
        $data['explicit_avg'] = round($explicit_avg, 2);
        $data['implicit_avg'] = round($implicit_avg, 2);
        $data['overall_avg'] = round($overall_avg, 2);
        $data['explicit_qualitative'] = $get_qualitative($explicit_avg);
        $data['implicit_qualitative'] = $get_qualitative($implicit_avg);
        $data['overall_qualitative'] = $get_qualitative($overall_avg);

        $data['main'] = 'facultyevaluation/ratings_view';
        $this->load->view('layouts/main_view', $data);
    }

    public function print_report($id = NULL)
    {
        if (empty($id)) {
            $this->session->set_flashdata("error", "Invalid evaluation identifier.");
            redirect(base_url("facultyevaluation"));
        }

        $evaluation = $this->FacultyEvaluation_Model->get_evaluation_by_id($id);
        if (!$evaluation) {
            $this->session->set_flashdata("error", "Faculty evaluation record not found.");
            redirect(base_url("facultyevaluation"));
        }

        // Calculate explicit ratings (questions 1 to 15)
        $explicit_scores = [];
        for ($i = 1; $i <= 15; $i++) {
            $field = 'explicit_' . $i;
            if (isset($evaluation->$field) && $evaluation->$field !== NULL) {
                $explicit_scores[] = (int)$evaluation->$field;
            }
        }
        $explicit_avg = count($explicit_scores) > 0 ? array_sum($explicit_scores) / count($explicit_scores) : 0;

        // Calculate implicit ratings (questions 16 to 29)
        $implicit_scores = [];
        for ($i = 16; $i <= 29; $i++) {
            $field = 'implicit_' . $i;
            if (isset($evaluation->$field) && $evaluation->$field !== NULL) {
                $implicit_scores[] = (int)$evaluation->$field;
            }
        }
        $implicit_avg = count($implicit_scores) > 0 ? array_sum($implicit_scores) / count($implicit_scores) : 0;

        // Overall rating (all 29 questions)
        $all_scores = array_merge($explicit_scores, $implicit_scores);
        $overall_avg = count($all_scores) > 0 ? array_sum($all_scores) / count($all_scores) : 0;

        // Qualitative scale mapping
        $get_qualitative = function ($score) {
            if ($score >= 4.5) return ['label' => 'Outstanding', 'class' => 'bg-success text-white', 'text_class' => 'text-success'];
            if ($score >= 3.5) return ['label' => 'Very Satisfactory', 'class' => 'bg-primary text-white', 'text_class' => 'text-primary'];
            if ($score >= 2.5) return ['label' => 'Satisfactory', 'class' => 'bg-info text-white', 'text_class' => 'text-info'];
            if ($score >= 1.5) return ['label' => 'Unsatisfactory', 'class' => 'bg-warning text-white', 'text_class' => 'text-warning'];
            return ['label' => 'Poor', 'class' => 'bg-danger text-white', 'text_class' => 'text-danger'];
        };

        $data['evaluation'] = $evaluation;
        $data['explicit_avg'] = round($explicit_avg, 2);
        $data['implicit_avg'] = round($implicit_avg, 2);
        $data['overall_avg'] = round($overall_avg, 2);
        $data['explicit_qualitative'] = $get_qualitative($explicit_avg);
        $data['implicit_qualitative'] = $get_qualitative($implicit_avg);
        $data['overall_qualitative'] = $get_qualitative($overall_avg);

        $data['main'] = 'facultyevaluation/print_view';
        $this->load->view('layouts/main_view', $data);
    }
}
