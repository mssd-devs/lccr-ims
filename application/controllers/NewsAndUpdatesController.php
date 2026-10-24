<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class NewsAndUpdatesController extends CI_Controller
{
    // For AJAX: get newsandupdates by ID
    function get($id)
    {
        $newsandupdate = $this->db->get_where('tbl_newsandupdates', ['ID' => $id])->row();
        if (!$newsandupdate) {
            show_404();
        }
        echo json_encode($newsandupdate);
    }
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['NewsAndUpdates_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'newsandupdates/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function saveNewsAndUpdates()
    {
        $this->NewsAndUpdates_Model->saveNewsAndUpdates();
    }

    function edit($id)
    {
        $newsandupdate = $this->db->get_where('tbl_newsandupdates', ['ID' => $id])->row();
        if (!$newsandupdate) {
            show_404();
        }
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'newsandupdates/edit_view',
            'newsandupdate' => $newsandupdate
        ];
        $this->load->view('layouts/main_view', $data);
    }

    function update($id)
    {
        $this->NewsAndUpdates_Model->updateNewsAndUpdates($id);
    }

    function delete($id)
    {
        $this->NewsAndUpdates_Model->deleteNewsAndUpdates($id);
    }
}
