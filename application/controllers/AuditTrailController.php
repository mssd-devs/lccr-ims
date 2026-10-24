<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class AuditTrailController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['AuditTrail_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function audittrail()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadAudit' => $this->AuditTrail_Model->LoadAudit(),
            'main' => 'audittrail/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
}
