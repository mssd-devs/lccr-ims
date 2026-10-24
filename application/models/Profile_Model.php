<?php
#[AllowDynamicProperties]
class Profile_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function save_base64_image($base64, $filename = null, $prefix = 'userimage')
    {
        if (empty($base64)) return null;

        $uploadPath = './assets/img/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Handle both full data URL and clean base64 string
        if (strpos($base64, 'data:image') === 0) {
            // Full data URL format: data:image/png;base64,xxxxx
            $parts = explode(";base64,", $base64);
            if (count($parts) !== 2) return null;

            $typePart = explode("image/", $parts[0]);
            $imageType = isset($typePart[1]) ? $typePart[1] : 'png';
            $imageData = base64_decode($parts[1]);
        } else {
            // Clean base64 string
            $imageData = base64_decode($base64);
            $imageType = 'png'; // Default to PNG
        }

        if (!$imageData) return null;

        // Use provided filename or generate one
        if (empty($filename)) {
            $filename = $prefix . '_' . time() . '.' . $imageType;
        }

        $fullPath = $uploadPath . $filename;
        if (file_put_contents($fullPath, $imageData)) {
            return $filename;
        }

        return null;
    }


    function updateProfile()
    {
        // Handle both old and new field names for compatibility
        $imageUserBase64 = $this->input->post('IMS_USERS_IMAGE_BASE64') ?: $this->input->post('IMS_USERS_IMAGE');
        $imageFilename = $this->input->post('IMS_USERS_IMAGE_FILENAME');

        if (empty($imageUserBase64)) {
            $errorMessage = "No image data provided.";
            if ($this->input->is_ajax_request()) {
                return ['success' => false, 'message' => $errorMessage];
            } else {
                $this->session->set_flashdata('error', $errorMessage);
                redirect(base_url() . 'ims/profile');
                return;
            }
        }

        $imageFile = $this->save_base64_image($imageUserBase64, $imageFilename, 'userimage');
        $data = [];

        if ($imageFile) {
            // Get existing user data
            $existingUser = $this->db->get_where('tbl_users', ['ID' => $this->session->userdata("id")])->row_array();

            // Delete old image file if exists
            if ($existingUser && !empty($existingUser['IMS_USERS_IMAGE'])) {
                $existingImagePath = './assets/img/' . $existingUser['IMS_USERS_IMAGE'];
                if (file_exists($existingImagePath)) {
                    unlink($existingImagePath);
                }
            }

            $data['IMS_USERS_IMAGE'] = $imageFile;
            $this->session->set_userdata("user_image", $imageFile);

            // Update database
            $this->db->where("ID", $this->session->userdata("id"));

            if ($this->db->update("tbl_users", $data)) {
                if ($this->input->is_ajax_request()) {
                    return ['success' => true, 'message' => 'Profile image updated successfully.', 'image_url' => base_url('assets/img/' . $imageFile)];
                } else {
                    $this->session->set_flashdata('success', "Image has been updated successfully.");
                    redirect(base_url() . 'ims/profile');
                }
            } else {
                if ($this->input->is_ajax_request()) {
                    return ['success' => false, 'message' => 'Failed to update profile image.'];
                } else {
                    $this->session->set_flashdata('error', "An error occurred while saving the data.");
                    redirect(base_url() . 'ims/profile');
                }
            }
        } else {
            $errorMessage = "Failed to process the image. Please try again.";
            if ($this->input->is_ajax_request()) {
                return ['success' => false, 'message' => $errorMessage];
            } else {
                $this->session->set_flashdata('error', $errorMessage);
                redirect(base_url() . 'ims/profile');
            }
        }
    }

    public function getUserById($userId)
    {
        return $this->db->get_where('tbl_users', ['ID' => $userId])->row();
    }

    public function updatePassword($userId, $hashedPassword)
    {
        $this->db->where('ID', $userId);
        return $this->db->update('tbl_users', ['IMS_USERS_PWORD' => $hashedPassword]);
    }
}
