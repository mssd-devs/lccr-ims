<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BuildingsFurnitureController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library(['session', 'encrypt', 'form_validation']);
        $this->load->helper(['form', 'url', 'captcha', 'security']);
        $this->load->model(['BuildingFurniture_Model']);
        if (empty($this->session->userdata("fullname"))) {
            $this->session->set_flashdata("error", "You need to log in first.");
            redirect(base_url("login"));
        }
    }

    function buildings_furniture()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'LoadBuildingFurniture' => $this->BuildingFurniture_Model->LoadBuildingFurniture(),
            'main' => 'buildings_furniture/index_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function create()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'buildings_furniture/create_view'
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
            'LoadBuildingFurniture' => $this->db->where("ID", $id)->get("tbl_buildingfurniture"),
            'main' => 'buildings_furniture/edit_view'
        ];
        $this->load->view('layouts/main_view', $data);
    }
    function generateExcel()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'output' => $this->BuildingFurniture_Model->LoadBuildingFurniture()
        ];
        $this->load->view('buildings_furniture/generate_excel', $data);
    }
    function saveBuildingFurniture()
    {
        $this->BuildingFurniture_Model->saveBuildingFurniture();
    }
    function updateBuildingFurniture()
    {
        $this->BuildingFurniture_Model->updateBuildingFurniture();
    }
    function deleteBuildingFurniture()
    {
        $this->BuildingFurniture_Model->deleteBuildingFurniture();
    }
}
