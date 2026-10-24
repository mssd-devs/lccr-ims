<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class PublicationController extends CI_Controller
{
    // For AJAX: get publication by ID
    function get($id)
    {
        $publication = $this->db->get_where('tbl_publication', ['ID' => $id])->row();
        if (!$publication) {
            show_404();
        }
        echo json_encode($publication);
    }
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['Publication_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'publications/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function savePublication()
    {
        $this->Publication_Model->savePublication();
    }

    function edit($id)
    {
        $publication = $this->db->get_where('tbl_publication', ['ID' => $id])->row();
        if (!$publication) {
            show_404();
        }
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'publications/edit_view',
            'publication' => $publication
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function update($id)
    {
        $this->Publication_Model->updatePublication($id);
    }

    function delete($id)
    {
        $this->Publication_Model->deletePublication($id);
    }
}
