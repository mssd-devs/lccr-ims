<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class RoomsController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['Rooms_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function rooms()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadRooms' => $this->Rooms_Model->LoadRooms(),
            'LoadDepartment' => $this->Rooms_Model->LoadDepartment(),
            'main' => 'rooms/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function edit()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadRooms' => $this->db->where("ID", $this->uri->segment(5))->get("tbl_rooms"),
            'LoadDepartment' => $this->Rooms_Model->LoadDepartment(),
            'main' => 'rooms/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function SaveRooms()
    {
        $this->Rooms_Model->SaveRooms();
    }
    function UpdateRooms()
    {
        $this->Rooms_Model->UpdateRooms();
    }
    function DeleteRooms()
    {
        $this->Rooms_Model->DeleteRooms();
    }
}
