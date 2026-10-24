<?php
#[AllowDynamicProperties]
class WebSettings_Model extends CI_Model
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
    public function LoadWebSettings()
    {
        $query = $this->db->get('tbl_websettings');
        return $query->result_array(); // Return the result as an array.
    }

    public function save_base64_image($base64, $filename = null, $prefix = 'image')
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

    function updatesettings()
    {
        // Validate and sanitize input
        $web_footer_data = [
            "IMS_WEB_NOS"      => $this->input->post("IMS_WEB_NOS"),
            "IMS_WEB_ACRO"     => $this->input->post("IMS_WEB_ACRO"),
            "IMS_WEB_ADDRESS"  => $this->input->post("IMS_WEB_ADDRESS"),
            "IMS_WEB_EMAIL"    => $this->input->post("IMS_WEB_EMAIL"),
            "IMS_WEB_CONTACT"  => $this->input->post("IMS_WEB_CONTACT"),
            "IMS_WEB_ABOUT"    => $this->input->post("IMS_WEB_ABOUT", true),
            "IMS_WEB_ENROLLMENT_FEE"  => $this->input->post("IMS_WEB_ENROLLMENT_FEE"),
        ];

        // Validate required fields
        foreach ($web_footer_data as $key => $value) {
            if (empty(trim($value))) {
                $fieldName = ucfirst(str_replace(["IMS_WEB_", "_"], ["", " "], $key));
                $errorMessage = $fieldName . " field cannot be empty.";

                if ($this->input->is_ajax_request()) {
                    return ['success' => false, 'message' => $errorMessage];
                } else {
                    $this->session->set_flashdata('error', $errorMessage);
                    redirect(base_url() . 'ims/websettings');
                    return;
                }
            }
            // Apply validation function if needed
            $web_footer_data[$key] = $this->validate_data($value);
        }


        // Handle image uploads with new field names
        $logoSchoolBase64 = $this->input->post('IMS_WEB_LOGO_BASE64');
        $logoSchoolFilename = $this->input->post('IMS_WEB_LOGO_FILENAME');
        $logoSchoolCurrent = $this->input->post('IMS_WEB_LOGO_CURRENT');

        $logoLeftBase64 = $this->input->post('IMS_WEB_IMG_BASE64');
        $logoLeftFilename = $this->input->post('IMS_WEB_IMG_FILENAME');
        $logoLeftCurrent = $this->input->post('IMS_WEB_IMG_CURRENT');

        $logoRightBase64 = $this->input->post('IMS_WEB_IMG2_BASE64');
        $logoRightFilename = $this->input->post('IMS_WEB_IMG2_FILENAME');
        $logoRightCurrent = $this->input->post('IMS_WEB_IMG2_CURRENT');

        $logoSchoolFile = $this->save_base64_image($logoSchoolBase64, $logoSchoolFilename, 'logo_school');
        $logoLeftFile = $this->save_base64_image($logoLeftBase64, $logoLeftFilename, 'logo_left');
        $logoRightFile = $this->save_base64_image($logoRightBase64, $logoRightFilename, 'logo_right');

        if ($logoSchoolFile) {
            $get_exisiting_logo = $this->db->get_where('tbl_websettings', ['ID' => 1])->row_array();
            if ($get_exisiting_logo && !empty($get_exisiting_logo['IMS_WEB_LOGO'])) {
                $existingLogoPath = './assets/img/' . $get_exisiting_logo['IMS_WEB_LOGO'];
                if (file_exists($existingLogoPath)) {
                    unlink($existingLogoPath); // Delete the existing logo file
                }
            }
            $web_footer_data['IMS_WEB_LOGO'] = $logoSchoolFile;
        }
        if ($logoLeftFile) {
            $get_exisiting_logo = $this->db->get_where('tbl_websettings', ['ID' => 1])->row_array();
            if ($get_exisiting_logo && !empty($get_exisiting_logo['IMS_WEB_IMG'])) {
                $existingLogoPath = './assets/img/' . $get_exisiting_logo['IMS_WEB_IMG'];
                if (file_exists($existingLogoPath)) {
                    unlink($existingLogoPath); // Delete the existing logo file
                }
            }
            $web_footer_data['IMS_WEB_IMG'] = $logoLeftFile;
        }

        if ($logoRightFile) {
            $get_exisiting_logo2 = $this->db->get_where('tbl_websettings', ['ID' => 1])->row_array();
            if ($get_exisiting_logo2 && !empty($get_exisiting_logo2['IMS_WEB_IMG2'])) {
                $existingLogoPath2 = './assets/img/' . $get_exisiting_logo2['IMS_WEB_IMG2'];
                if (file_exists($existingLogoPath2)) {
                    unlink($existingLogoPath2); // Delete the existing logo file
                }
            }
            $web_footer_data['IMS_WEB_IMG2'] = $logoRightFile;
        }

        // Update logic - Ensure you set a WHERE condition to avoid updating all records
        $this->db->where("ID", 1);

        if ($this->db->update("tbl_websettings", $web_footer_data)) {
            $details = "School: " . $web_footer_data['IMS_WEB_NOS'] . " (" . $web_footer_data['IMS_WEB_ACRO'] . ")";
            log_audit("UPDATED WEB SETTINGS", $details);
            // For AJAX requests, return success status
            if ($this->input->is_ajax_request()) {
                return ['success' => true, 'message' => 'Data has been updated successfully.'];
            } else {
                $this->session->set_flashdata('success', "Data has been updated successfully.");
                redirect(base_url() . 'ims/websettings');
            }
        } else {
            // For AJAX requests, return error status
            if ($this->input->is_ajax_request()) {
                return ['success' => false, 'message' => 'An error occurred while saving the data.'];
            } else {
                $this->session->set_flashdata('error', "An error occurred while saving the data.");
                redirect(base_url() . 'ims/websettings');
            }
        }
    }



    function updateSignatories()
    {
        $data = [
            "SIG_PRES" => $this->input->post("SIG_PRES"),
            "SIG_REG" => $this->input->post("SIG_REG"),
            "SIG_DEAN" => $this->input->post("SIG_DEAN"),
            "SIG_CASH" => $this->input->post("SIG_CASH")
        ];
        $this->db->update("tbl_signatories", $data);
        $details = "President: " . $data['SIG_PRES'] . ", Registrar: " . $data['SIG_REG'];
        log_audit("UPDATED SYSTEM SIGNATORIES", $details);
        return true;
    }

    public function fetchSignatories()
    {
        return $this->db->get("tbl_signatories")->row_array(); // Returns 1 row as associative array
    }
}
