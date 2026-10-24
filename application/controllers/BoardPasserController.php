<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BoardPasserController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['BoardPasser_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function boardpasser()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadBoardPasser' => $this->BoardPasser_Model->LoadBoardPasser(),
            'main' => 'board_passer/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function create()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadPrograms' => $this->BoardPasser_Model->LoadPrograms(),
            'main' => 'board_passer/create_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function edit($id = NULL)
    {
        if (empty($id)) {
            $id = $this->uri->segment(4);
        }
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadPrograms' => $this->BoardPasser_Model->LoadPrograms(),
            'LoadBoardPasser' => $this->db->where("ID", $id)->get("tbl_boardpasser"),
            'main' => 'board_passer/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function generateExcel()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->BoardPasser_Model->LoadBoardPasser()
        ];
        $this->load->view('board_passer/generate_excel', $data);
    }

    function saveBoardPasser()
    {
        $this->BoardPasser_Model->saveBoardPasser();
    }
    function updateBoardPasser()
    {
        $this->BoardPasser_Model->updateBoardPasser();
    }
    function deleteBoardPasser()
    {
        $this->BoardPasser_Model->deleteBoardPasser();
    }
}
