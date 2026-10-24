<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class FinDasController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt']);
        $this->load->helper(['form', 'url', 'security']);
        $this->load->model(['FinDas_Model', 'Dashboard_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function financial_dashboard()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadPrograms' => $this->Dashboard_Model->LoadPrograms(),
            'main' => 'dashboards/financial_view',
            'financial_script' => $this->load->view('dashboards/financial_script', '', TRUE) // include the script code 
        ];
        $this->load->view('layouts/main_view', $data);
    }

    public function FilterDashboardHeader()
    {

        $data = [
            'token'  => $this->security->get_csrf_hash(),
            'output' => $this->FinDas_Model->FilterDashboardHeader()
        ];

        $this->outputJson($data);
    }
    public function fee_collection_program()
    {
        $data = [
            'token'  => $this->security->get_csrf_hash(),
            'output' => $this->FinDas_Model->fee_collection_program()
        ];
        $this->outputJson($data);
    }
    public function recent_transactions()
    {
        $data = [
            'token'  => $this->security->get_csrf_hash(),
            'output' => $this->FinDas_Model->recent_transactions()
        ];
        $this->outputJson($data);
    }
    public function chart_voucher_breakdown()
    {
        $data = [
            'token'  => $this->security->get_csrf_hash(),
            'output' => $this->FinDas_Model->chart_voucher_breakdown()
        ];
        $this->outputJson($data);
    }

    public function chart_billing_breakdown()
    {
        $FTR_YL = $this->input->post('FTR_YL');
        $FTR_SEM = $this->input->post('FTR_SEM');
        $FTR_PROGRAM = $this->input->post('FTR_PROGRAM');
        $FTR_AY = $this->input->post('FTR_AY');

        $result = $this->FinDas_Model->chart_billing_breakdown($FTR_YL, $FTR_SEM, $FTR_PROGRAM, $FTR_AY);

        $data = [
            'token' => $this->security->get_csrf_hash(),
            'output' => $result
        ];
        $this->outputJson($data);
    }

    private function outputJson($data)
    {
        $this->output
            //   ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }
}
