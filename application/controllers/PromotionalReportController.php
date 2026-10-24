<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class PromotionalReportController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['PromotionalReport_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'rbac' => $this->db->where("USER_ID", $this->session->userdata("id"))->where("PAGE", "Enrollment")->get("tbl_permissions"),
            'main' => 'promotional_report/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function printView()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->PromotionalReport_Model->LoadEnrollment()
        ];
        $this->load->view('promotional_report/print_view', $data);
    }

    function LoadEnrollment()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->PromotionalReport_Model->LoadEnrollment()
        ];
        echo json_encode($data);
    }

    function updatePromotionStatus()
    {
        $this->form_validation->set_rules('ids', 'IDs', 'required|trim');
        $this->form_validation->set_rules('status', 'Status', 'required|trim');

        if ($this->form_validation->run() == FALSE) {
            $response = [
                'status' => 'error',
                'message' => validation_errors()
            ];
        } else {
            $ids = $this->input->post('ids');
            $status = $this->input->post('status');

            // Update promotional status in the database
            $this->db->where_in('ID', explode(',', $ids));
            $this->db->update('tbl_enrollment', ['ER_PROMOTIONALSTATUS' => $status]);

            $response = [
                'status' => 'success',
                'message' => 'Promotional status updated successfully.'
            ];
        }

        echo json_encode($response);
    }

    function generatePDFSelected()
    {
        $ids = $this->input->post("ids");
        if (empty($ids)) {
            return false;
        }

        // Convert IDs to array if it's a string
        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }

        // Fetch selected enrollment records
        $this->db->select('e.*, s.SP_LASTNAME, s.SP_FIRSTNAME, s.SP_MIDDLENAME, s.SP_GENDER, s.SP_STUDID, s.SP_CPNUMBER');
        $this->db->from('tbl_enrollment e');
        $this->db->join('tbl_studprof s', 'e.ER_STUDENTID = s.SP_STUDID', 'left');
        $this->db->where_in('e.ID', $ids);
        $query = $this->db->get();
        $data = $query->result();
        return $data;
    }
}
