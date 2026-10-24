<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class WebSettingsController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['WebSettings_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadWebSettings' => $this->WebSettings_Model->LoadWebSettings(),
            'main' => 'websettings/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function about()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'load_about' => $this->db->get("tbl_websettings")->row("IMS_WEB_ABOUT"),
            'main' => 'about_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function updatesettings()
    {
        // Check if it's an AJAX request
        if ($this->input->is_ajax_request()) {
            $result = $this->WebSettings_Model->updatesettings();
            $data = [
                'token' => $this->security->get_csrf_hash(),
                'output' => $result['success'],
                'message' => $result['message']
            ];
            echo json_encode($data);
        } else {
            $this->WebSettings_Model->updatesettings();
        }
    }

    function updateSignatories()
    {
        $data = [
            // Read new token and assing in $data['token']
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->WebSettings_Model->updateSignatories()
        ];
        echo json_encode($data);
    }
    public function fetchSignatories()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->WebSettings_Model->fetchSignatories()
        ];
        echo json_encode($data);
    }
}
