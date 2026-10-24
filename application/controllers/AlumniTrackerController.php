<?php
defined('BASEPATH') or exit('No direct script access allowed');

#[AllowDynamicProperties]
class AlumniTrackerController extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Load necessary models, libraries, helpers here
        $this->load->model('Alumni_model');
        $this->load->helper('url');
    }

    function index()
    {
        $data = [
            'token' => $this->security->get_csrf_hash(),
            'main' => 'alumni_tracker/index_view',
            'alumni' => $this->Alumni_model->get_all()
        ];
        $this->load->view('layouts/main_view', $data);
    }

    public function get($id)
    {
        $alumni = $this->Alumni_model->get($id);
        echo json_encode($alumni);
    }

    public function save()
    {
        $data = [
            'FULLNAME' => $this->input->post('FULLNAME'),
            'PROGRAM_COURSES' => $this->input->post('PROGRAM_COURSES'),
            'ACHIEVEMENT' => $this->input->post('ACHIEVEMENT'),
            'JOB_POSITION' => $this->input->post('JOB_POSITION'),
            'OFFICE' => $this->input->post('OFFICE'),
        ];
        // Handle image upload
        if (!empty($_FILES['IMAGE']['name'])) {
            $config['upload_path'] = './uploads/alumni/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 20480; // 20MB
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('IMAGE')) {
                $upload_data = $this->upload->data();
                $data['IMAGE'] = $upload_data['file_name'];
            }
        }
        $inserted = $this->Alumni_model->insert($data);
        if ($this->input->is_ajax_request()) {
            if ($inserted) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Insert failed.']);
            }
            return;
        }
        redirect('ims/alumni-tracker');
    }

    public function update($id)
    {
        $data = [
            'FULLNAME' => $this->input->post('FULLNAME'),
            'PROGRAM_COURSES' => $this->input->post('PROGRAM_COURSES'),
            'ACHIEVEMENT' => $this->input->post('ACHIEVEMENT'),
            'JOB_POSITION' => $this->input->post('JOB_POSITION'),
            'OFFICE' => $this->input->post('OFFICE'),
        ];
        // Handle image upload
        if (!empty($_FILES['IMAGE']['name'])) {
            $config['upload_path'] = './uploads/alumni/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 20480; // 20MB
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('IMAGE')) {
                $upload_data = $this->upload->data();
                $data['IMAGE'] = $upload_data['file_name'];
            }
        }
        $updated = $this->Alumni_model->update($id, $data);
        if ($this->input->is_ajax_request()) {
            if ($updated) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Update failed.']);
            }
            return;
        }
        redirect('ims/alumni-tracker');
    }

    public function delete($id)
    {
        $deleted = $this->Alumni_model->delete($id);
        if ($this->input->is_ajax_request()) {
            if ($deleted) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Delete failed.']);
            }
            return;
        }
        redirect('ims/alumni-tracker');
    }

    // AJAX endpoint to return table rows only
    public function ajax_list()
    {
        $alumni = $this->Alumni_model->get_all();
        foreach ($alumni as $a) {
            echo '<tr data-id="' . $a->ID . '">';
            echo '<td>' . htmlspecialchars($a->FULLNAME) . '</td>';
            echo '<td>' . htmlspecialchars($a->PROGRAM_COURSES) . '</td>';
            echo '<td>' . htmlspecialchars($a->ACHIEVEMENT) . '</td>';
            echo '<td>' . htmlspecialchars($a->JOB_POSITION) . '</td>';
            echo '<td>' . htmlspecialchars($a->OFFICE) . '</td>';
            echo '<td>';
            if (!empty($a->IMAGE)) {
                echo '<img src="' . base_url('uploads/alumni/' . $a->IMAGE) . '" style="max-width:60px;max-height:60px;border-radius:4px;">';
            } else {
                echo '<span class="text-muted">No Image</span>';
            }
            echo '</td>';
            echo '<td>';
            echo '<button type="button" class="btn btn-sm btn-outline-primary edit-btn" data-id="' . $a->ID . '">Edit</button> ';
            echo '<button type="button" class="btn btn-sm btn-outline-danger delete-btn" data-id="' . $a->ID . '">Delete</button>';
            echo '</td>';
            echo '</tr>';
        }
    }
}
