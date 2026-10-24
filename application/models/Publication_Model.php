<?php
#[AllowDynamicProperties]
class Publication_Model extends CI_Model
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

    public function savePublication()
    {
        date_default_timezone_set("Asia/Manila");
        $data = $this->getPublication();

        if ($this->db->insert("tbl_publication", $data)) {
            log_audit("SAVED NEW PUBLICATION", $data['P_TITLENAME'] . " (" . $data['P_CATEGORY'] . ")");
            $this->setSuccessFlashMessage("Successfully saved.");
        } else {
            $this->setErrorFlashMessage("Data error saving.");
        }

        $this->redirectUsersPage();
    }

    public function updatePublication($id)
    {
        $data = [
            "P_TITLENAME" => $this->validate_data($this->input->post("P_TITLENAME")),
            "P_AUTHOR" => $this->validate_data($this->input->post("P_AUTHOR")),
            "P_PUBLICATIONDATE" => $this->validate_data($this->input->post("P_PUBLICATIONDATE")),
            "P_CATEGORY" => $this->validate_data($this->input->post("P_CATEGORY")),
            "P_DESCRIPTION" => $this->validate_data($this->input->post("P_DESCRIPTION")),
            "P_STATUS" => $this->validate_data($this->input->post("P_STATUS"))
        ];

        if (!empty($_FILES['P_IMAGE']['name'])) {
            $config['upload_path'] = './uploads/publications/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 20480;
            $config['encrypt_name'] = TRUE;
            $this->load->library('upload', $config);
            if ($this->upload->do_upload('P_IMAGE')) {
                $uploadData = $this->upload->data();
                $data['P_FILEPDF'] = $uploadData['file_name'];
                $old = $this->db->get_where('tbl_publication', ['ID' => $id])->row();
                if ($old && !empty($old->P_FILEPDF)) {
                    $oldPath = FCPATH . 'uploads/publications/' . $old->P_FILEPDF;
                    if (file_exists($oldPath)) {
                        @unlink($oldPath);
                    }
                }
            }
        }

        $this->db->where('ID', $id);
        if ($this->db->update('tbl_publication', $data)) {
            log_audit("UPDATED PUBLICATION", $data['P_TITLENAME'] . " (" . $data['P_CATEGORY'] . ")");
            $this->setSuccessFlashMessage('Publication updated successfully.');
        } else {
            $this->setErrorFlashMessage('Error updating publication.');
        }
        $this->redirectUsersPage();
    }

    public function deletePublication($id)
    {
        $publication = $this->db->get_where('tbl_publication', ['ID' => $id])->row();
        if ($publication && !empty($publication->P_FILEPDF)) {
            $filePath = FCPATH . 'uploads/publications/' . $publication->P_FILEPDF;
            if (file_exists($filePath)) {
                @unlink($filePath);
            }
        }
        $title = $publication ? $publication->P_TITLENAME : "ID: " . $id;
        $this->db->where('ID', $id);
        if ($this->db->delete('tbl_publication')) {
            log_audit("DELETED PUBLICATION", $title);
            $this->setSuccessFlashMessage('Publication deleted successfully.');
        } else {
            $this->setErrorFlashMessage('Error deleting publication.');
        }
        $this->redirectUsersPage();
    }

    public function getPublication()
    {
        date_default_timezone_set("Asia/Manila");

        $data = [
            "P_TITLENAME" => $this->validate_data($this->input->post("P_TITLENAME")),
            "P_AUTHOR" => $this->validate_data($this->input->post("P_AUTHOR")),
            "P_PUBLICATIONDATE" => $this->validate_data($this->input->post("P_PUBLICATIONDATE")),
            "P_CATEGORY" => $this->validate_data($this->input->post("P_CATEGORY")),
            "P_DESCRIPTION" => $this->validate_data($this->input->post("P_DESCRIPTION")),
            "P_STATUS" => $this->validate_data($this->input->post("P_STATUS")),
            "P_FILEPDF" => NULL
        ];
        if (!empty($_FILES['P_IMAGE']['name'])) {
            $config['upload_path'] = './uploads/publications/';
            $config['allowed_types'] = 'jpg|jpeg|png|gif';
            $config['max_size'] = 20480;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            if ($this->upload->do_upload('P_IMAGE')) {
                $uploadData = $this->upload->data();
                $data['P_FILEPDF'] = $uploadData['file_name'];
            }
        }
        return $data;
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
        redirect(base_url() . 'ims/publications');
    }
}
