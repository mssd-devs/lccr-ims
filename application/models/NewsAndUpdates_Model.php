<?php
#[AllowDynamicProperties]
class NewsAndUpdates_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function validate_data($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function saveNewsAndUpdate()
    {
        $data = [
            "NU_TITLENAME"   => $this->validate_data($this->input->post("NU_TITLENAME")),
            "NU_AUTHOR"      => $this->validate_data($this->input->post("NU_AUTHOR")),
            "NU_DATE"        => $this->validate_data($this->input->post("NU_DATE")),
            "NU_CATEGORY"    => $this->validate_data($this->input->post("NU_CATEGORY")),
            "NU_DESCRIPTION" => $this->validate_data($this->input->post("NU_DESCRIPTION")),
            "NU_STATUS"      => $this->validate_data($this->input->post("NU_STATUS")),
        ];

        // ===== HANDLE IMAGE UPLOAD =====
        if (!empty($_FILES['NU_FILEIMG']['name'])) {

            $config['upload_path']   = FCPATH . 'uploads/newsandupdates/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size']      = 20480; // 20MB
            $config['encrypt_name']  = TRUE;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('NU_FILEIMG')) {
                $this->setErrorFlashMessage($this->upload->display_errors());
                $this->redirectUsersPage();
                return;
            } else {
                $uploadData = $this->upload->data();
                $data['NU_FILEIMG'] = $uploadData['file_name'];
            }
        }

        // ===== INSERT TO DATABASE =====
        if ($this->db->insert('tbl_newsandupdates', $data)) {
            log_audit("SAVED NEW NEWS & UPDATE", $data['NU_TITLENAME'] . " (" . $data['NU_CATEGORY'] . ")");
            $this->setSuccessFlashMessage('News and update added successfully.');
        } else {
            $this->setErrorFlashMessage('Error saving news and update.');
        }

        $this->redirectUsersPage();
    }

    public function deleteNewsAndUpdates($id)
    {
        $newsandupdate = $this->db->get_where('tbl_newsandupdates', ['ID' => $id])->row();
        if ($newsandupdate && !empty($newsandupdate->NU_FILEIMG)) {
            $filePath = FCPATH . 'uploads/newsandupdates/' . $newsandupdate->NU_FILEIMG;
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }
        $title = $newsandupdate ? $newsandupdate->NU_TITLENAME : "ID: " . $id;
        $this->db->where('ID', $id);
        if ($this->db->delete('tbl_newsandupdates')) {
            log_audit("DELETED NEWS & UPDATE", $title);
            $this->setSuccessFlashMessage('News and update deleted successfully.');
        } else {
            $this->setErrorFlashMessage('Error deleting news and update.');
        }
        $this->redirectUsersPage();
    }

    private function setSuccessFlashMessage($message)
    {
        $this->session->set_flashdata('success', $message);
    }

    private function setErrorFlashMessage($message)
    {
        $this->session->set_flashdata('error', $message);
    }

    private function redirectUsersPage()
    {
        redirect(base_url() . 'ims/newsandupdates');
    }
}
