<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CashierBillingController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['CashierBilling_Model', 'Enrollment_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'cash_billing/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }



    function print_receipt()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadPayments' => $this->CashierBilling_Model->LoadPayments(),
            'query' => $this->db->get("tbl_websettings"),
            'LoadStudentEnrolled' => $this->Enrollment_Model->LoadStudentEnrolled()
        ];
        $this->load->view('cash_billing/print_view', $data);
    }
    function print_soa()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'load_soa_fees' => $this->CashierBilling_Model->load_soa_fees(),
            'load_soa_payments' => $this->CashierBilling_Model->load_soa_payments(),
            'LoadOthersFee' => $this->Enrollment_Model->LoadOthersFee(),
            'LoadMiscFee' => $this->Enrollment_Model->LoadMiscFee(),
            'query' => $this->db->get("tbl_websettings"),
            'LoadStudentEnrolled' => $this->Enrollment_Model->LoadStudentEnrolled()
        ];
        $this->load->view('cash_billing/print_soa_view', $data);
    }


    function payment()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadStudentEnrolled' => $this->CashierBilling_Model->LoadStudentEnrolled(),
            //   'LoadPayments' => $this->CashierBilling_Model->LoadPayments(),
            //  'LoadTuitions' => $this->CashierBilling_Model->LoadTuitions(),
            'main' => 'cash_billing/cash_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function edit()
    {
        $data = [
            // 'token' => $this->security->get_csrf_hash(),
            // 'LoadApplication' => $this->Form1_Model->LoadApplication(),
            // 'LoadNomInfo' => $this->Form2_Model->LoadNomInfo(),
            // 'LoadPSRInfo' => $this->Form3_Model->LoadPSRInfo(),
            'main' => 'cash_billing/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function LoadProgramMajor()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->CashierBilling_Model->LoadProgramMajor()
        ];
        echo json_encode($data);
    }

    function savePayment()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->CashierBilling_Model->savePayment()
        ];
        echo json_encode($data);
    }

    function delete_summary_voucher()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->CashierBilling_Model->delete_summary_voucher()
        ];
        echo json_encode($data);
    }

    function delete_summary_payment()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->CashierBilling_Model->delete_summary_payment()
        ];
        echo json_encode($data);
    }

    function load_tuition_and_fees()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->CashierBilling_Model->load_tuition_and_fees()
        ];
        echo json_encode($data);
    }

    function LoadEnrollment()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->CashierBilling_Model->LoadEnrollment()
        ];
        echo json_encode($data);
    }


    function saveTypeofDiscount()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->CashierBilling_Model->saveTypeofDiscount()
        ];
        echo json_encode($data);
    }

    function deleteTypeofDiscount()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->CashierBilling_Model->deleteTypeofDiscount()
        ];
        echo json_encode($data);
    }

    function load_type_of_discount()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->CashierBilling_Model->load_type_of_discount()
        ];
        echo json_encode($data);
    }

    function load_discount_select()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->CashierBilling_Model->load_discount_select()
        ];
        echo json_encode($data);
    }

    function addDiscountFields()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->CashierBilling_Model->addDiscountFields()
        ];
        echo json_encode($data);
    }
}
