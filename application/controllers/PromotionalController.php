<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class PromotionalController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['Promotional_Model']);
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
            'main' => 'promotional/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function LoadEnrollment()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->Promotional_Model->LoadEnrollment()
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
}
