<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class DashboardController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['Dashboard_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function analytics_dashboard()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadPrograms' => $this->Dashboard_Model->LoadPrograms(),
            // 'program_with_enrollment' => $this->Dashboard_Model->program_with_enrollment(),
            'main' => 'dashboards/analytics_view',
            'analytics_script' => $this->load->view('dashboards/analytics_script', '', TRUE) // include the script code 
        ];
        $this->load->view('layouts/main_view', $data);
    }


    public function FilterDashboardHeader()
    {
        $data = [
            'token'  => $this->security->get_csrf_hash(),
            'output' => $this->Dashboard_Model->FilterDashboardHeader()
        ];

        $this->outputJson($data);
    }


    private function outputJson($data)
    {
        $this->output
            //   ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    public function program_with_enrollment()
    {
        $FTR_AY = $this->input->post("FTR_AY");
        $FTR_SEM = $this->input->post("FTR_SEM");
        $FTR_PROGRAM = $this->input->post("FTR_PROGRAM");
        $FTR_YL = $this->input->post("FTR_YL");

        $results = $this->Dashboard_Model->program_with_enrollment($FTR_AY, $FTR_YL, $FTR_SEM, $FTR_PROGRAM);

        $output = '';
        $grand_total_male = 0;
        $grand_total_female = 0;
        $grand_total_enrolled = 0;

        if (count($results) > 0) {
            foreach ($results as $row) {
                $program = htmlspecialchars($row->ER_PROGRAM);
                $total_male = $row->total_male ?? 0;
                $total_female = $row->total_female ?? 0;
                $total_enrolled = $row->total_enrolled ?? 0;

                $academic_year = is_numeric($row->ER_ACADEMICYEAR)
                    ? $row->ER_ACADEMICYEAR . '-' . ($row->ER_ACADEMICYEAR + 1)
                    : '';

                $grand_total_male += $total_male;
                $grand_total_female += $total_female;
                $grand_total_enrolled += $total_enrolled;

                $output .= "
        <tr>
            <td>{$program}</td>
            <td>{$academic_year}</td>
            <td><strong>{$total_male}</strong></td>
            <td><strong>{$total_female}</strong></td>
            <td><strong>{$total_enrolled}</strong></td>
        </tr>";
            }
        } else {
            $output .= "
        <tr>
            <td colspan='5' class='text-center text-muted'>No data available for the selected filters.</td>
        </tr>";
        }
        $output .= "
        <tr class='table-secondary'>
            <th colspan='2' class='text-end'>Total:</th>
            <th><strong>{$grand_total_male}</strong></th>
            <th><strong>{$grand_total_female}</strong></th>
            <th><strong>{$grand_total_enrolled}</strong></th>
        </tr>";

        echo json_encode([
            'token' => $this->security->get_csrf_hash(),
            'output' => $output
        ]);
    }

    public function chart_enrollment_by_sexandyearlevel()
    {
        $FTR_YL = $this->input->post('FTR_YL');
        $FTR_SEM = $this->input->post('FTR_SEM');
        $FTR_PROGRAM = $this->input->post('FTR_PROGRAM');
        $FTR_AY = $this->input->post('FTR_AY');

        $result = $this->Dashboard_Model->chart_enrollment_by_sexandyearlevel($FTR_YL, $FTR_SEM, $FTR_PROGRAM, $FTR_AY);

        $data = [
            'token' => $this->security->get_csrf_hash(),
            'output' => $result
        ];
        $this->outputJson($data);
    }

    public function chart_grades_performance()
    {
        $FTR_YL = $this->input->post('FTR_YL');
        // $FTR_SEM = $this->input->post('FTR_SEM');
        // $FTR_PROGRAM = $this->input->post('FTR_PROGRAM');
        $FTR_AY = $this->input->post('FTR_AY');

        $result = $this->Dashboard_Model->chart_grades_performance($FTR_YL, $FTR_AY);

        $data = [
            'token' => $this->security->get_csrf_hash(),
            'output' => $result
        ];
        $this->outputJson($data);
    }

    public function chart_pwd_statistics()
    {
        // $FTR_YL = $this->input->post('FTR_YL');
        // $FTR_SEM = $this->input->post('FTR_SEM');
        // $FTR_PROGRAM = $this->input->post('FTR_PROGRAM');
        $FTR_AY = $this->input->post('FTR_AY');

        $result = $this->Dashboard_Model->chart_pwd_statistics($FTR_AY);

        $data = [
            'token' => $this->security->get_csrf_hash(),
            'output' => $result
        ];
        $this->outputJson($data);
    }

    public function chart_employee_status()
    {
        // $FTR_YL = $this->input->post('FTR_YL');
        // $FTR_SEM = $this->input->post('FTR_SEM');
        // $FTR_PROGRAM = $this->input->post('FTR_PROGRAM');
        $FTR_AY = $this->input->post('FTR_AY');

        $result = $this->Dashboard_Model->chart_employee_status($FTR_AY);

        $data = [
            'token' => $this->security->get_csrf_hash(),
            'output' => $result
        ];
        $this->outputJson($data);
    }

    public function chart_enrollment_trends()
    {
        $result = $this->Dashboard_Model->chart_enrollment_trends();

        $data = [
            'token' => $this->security->get_csrf_hash(),
            'output' => $result
        ];
        $this->outputJson($data);
    }
}
