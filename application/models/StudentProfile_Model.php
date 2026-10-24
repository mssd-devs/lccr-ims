<?php

#[AllowDynamicProperties]
class StudentProfile_Model extends CI_Model
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

    function update_remarks()
    {
        $SP_TRANSID = $this->input->post("SP_TRANSID");
        $SP_DOCS_REMARKS = $this->input->post("SP_DOCS_REMARKS");

        $data = [
            "SP_DOCS_REMARKS" => $SP_DOCS_REMARKS
        ];

        $this->db->where("SP_TRANSID", $SP_TRANSID);
        if ($this->db->update("tbl_studprof", $data)) {
            return "Remarks updated successfully.";
        } else {
            return "Error updating remarks.";
        }
    }


    function load_active_enrollemt()
    {
        $SP_STUDID = $this->db->where("SP_TRANSID", $this->uri->segment(4))->get("tbl_studprof")->row("SP_STUDID");
        // get the enrollment active program enrolled by the student
        $query = $this->db->where("ER_STUDENTID", $SP_STUDID)->where("ER_ENSTATUS", "ACTIVE")->get("tbl_enrollment");
        return $query;
    }



    function LoadProvince($regCode)
    {
        $query = $this->db->where('regCode', $regCode)->order_by('regCode', 'ASC')->get('refprovince');
        $output = '<option value="">--Select--</option>';
        foreach ($query->result() as $row) {
            $output .= '<option value="' . $row->provCode . '">' . $row->provDesc . '</option>';
        }
        return $output;
    }
    function LoadCity($provCode)
    {
        $query = $this->db->where('provCode', $provCode)->order_by('provCode', 'ASC')->get('refcitymun');
        $output = '<option value="">--Select--</option>';
        foreach ($query->result() as $row) {
            $output .= '<option value="' . $row->citymunCode . '">' . $row->citymunDesc . '</option>';
        }
        return $output;
    }
    function LoadBrgy($citymunCode)
    {
        $query = $this->db->where('citymunCode', $citymunCode)->order_by('citymunCode', 'ASC')->get('refbrgy');
        $output = '<option value="">--Select--</option>';
        foreach ($query->result() as $row) {
            $output .= '<option value="' . $row->brgyCode . '">' . strtoupper($row->brgyDesc) . '</option>';
        }
        return $output;
    }


    public function generate_transaction_id()
    {
        date_default_timezone_set("Asia/Manila");
        // Get the current date and time
        $current_datetime = new DateTime();
        $date_time_string = $current_datetime->format('YmdHis');
        // Combine the date and time to create the transaction ID
        $transaction_id = $date_time_string;
        return $transaction_id;
    }


    // public function uploadImage()
    // {
    //     $imageName = "";
    //     $capturedImage = $this->input->post("capturedImage");
    //     $SP_TRANSID = $this->input->post("SP_TRANSID");

    //     if ($SP_TRANSID) {
    //         $getImage = $this->db->where("SP_TRANSID", $SP_TRANSID)->get("tbl_studprof");
    //         if ($getImage->num_rows() > 0) {
    //             $r = $getImage->row();
    //             // remove old image if exists
    //             if (!empty($r->SP_IMAGE) && file_exists("./uploads/" . $r->SP_IMAGE)) {
    //                 @unlink("./uploads/" . $r->SP_IMAGE);
    //             }
    //         }
    //     }

    //     if (!empty($capturedImage)) {
    //         // sanitize base64 string
    //         if (preg_match('/^data:image\/(\w+);base64,/', $capturedImage, $type)) {
    //             $capturedImage = substr($capturedImage, strpos($capturedImage, ',') + 1);
    //             $type = strtolower($type[1]); // jpg, png, gif

    //             if (!in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
    //                 throw new \Exception('Invalid image type');
    //             }
    //         } else {
    //             throw new \Exception('Did not match data URI with image data.');
    //         }

    //         $capturedImage = str_replace(' ', '+', $capturedImage);
    //         $decodedImageData = base64_decode($capturedImage);

    //         if ($decodedImageData === false) {
    //             throw new \Exception('Base64 decode failed');
    //         }

    //         $baseUploadPath = './uploads/';
    //         if (!is_dir($baseUploadPath)) {
    //             mkdir($baseUploadPath, 0755, true);
    //         }

    //         $imageName = uniqid('img_') . '.' . $type;
    //         $imagePath = $baseUploadPath . $imageName;

    //         if (file_put_contents($imagePath, $decodedImageData) === false) {
    //             throw new \Exception('Failed to save file');
    //         }
    //     }

    //     return $imageName;
    // }




    function uploadImage()
    {
        $imageName = "";
        $capturedImage = $this->input->post("capturedImage");
        $SP_TRANSID = $this->input->post("SP_TRANSID");

        if ($SP_TRANSID) {
            $getImage = $this->db->where("SP_TRANSID", $SP_TRANSID)->get("tbl_studprof");
            if ($getImage->num_rows() > 0) {
                $r = $getImage->row();
                if ($r->SP_IMAGE == $capturedImage) {
                    return $r->SP_IMAGE;
                } else {
                    @unlink("./uploads/" . $r->SP_IMAGE);
                }
            }
        }

        if (!empty($capturedImage)) {
            $baseUploadPath = './uploads/';
            $imageName = uniqid('img_') . '.jpeg';
            $imagePath = $baseUploadPath . $imageName;
            $decodedImageData = base64_decode($capturedImage);
            file_put_contents($imagePath, $decodedImageData);
        }

        return $imageName;
    }

    function checkNewEntry()
    {
        $NEW_FNAME = $this->input->post('NEW_FNAME');
        $NEW_MNAME = $this->input->post('NEW_MNAME');
        $NEW_LNAME = $this->input->post('NEW_LNAME');
        $NEW_DATE = $this->input->post('NEW_DATE');

        $this->db->where("SP_FIRSTNAME", $NEW_FNAME)
            ->where("SP_LASTNAME", $NEW_LNAME)
            ->where("SP_BIRTHDAY", $NEW_DATE);
        if (!empty($NEW_MNAME)) {
            $this->db->where("SP_MIDDLENAME", $NEW_MNAME);
        }
        $query = $this->db->get("tbl_studprof");
        if ($query->num_rows() > 0) {
            return "exist";
        } else {

            $data = [
                "SP_FIRSTNAME" => $NEW_FNAME,
                "SP_MIDDLENAME" => $NEW_MNAME,
                "SP_LASTNAME" => $NEW_LNAME,
                "SP_BIRTHDAY" => $NEW_DATE
            ];
            $this->session->set_userdata($data);
            return "not exist";
        }
    }


    // function saveSP()
    // {
    //     $logsData = $this->getLogsData();
    //     $result = "";
    //     $data = $this->getDataSP();
    //     $SP_TRANSID = $this->generate_transaction_id();
    //     $data["SP_TRANSID"] = $SP_TRANSID; // FOR INSERT ONLY
    //     $data["SP_STUDID"] =  $this->generate_unique_series(); // FOR INSERT ONLY
    //     if ($this->db->insert("tbl_studprof", $data)) {
    //         $countEduc = $this->input->post("EDUC_ATTAIN") ?? 0;
    //         if ($countEduc > 0) {
    //             for ($i = 0; $i < count($countEduc); $i++) {
    //                 $data = [
    //                     "EDUC_ATTAIN" => $this->input->post("EDUC_ATTAIN")[$i],
    //                     "EDUC_NAMEOFSCHOOL" => $this->input->post("EDUC_NAMEOFSCHOOL")[$i],
    //                     "EDUC_ADDRESS" => $this->input->post("EDUC_ADDRESS")[$i],
    //                     "EDUC_YEAR" => $this->input->post("EDUC_YEAR")[$i],
    //                     "EDUC_PROGRAM" => $this->input->post("EDUC_PROGRAM")[$i] ?? "",
    //                     "SP_TRANSID" => $SP_TRANSID
    //                 ];
    //                 $this->db->insert("tbl_studprof_school", $data);
    //                 $this->db->insert("tbl_audit", $logsData);
    //             }
    //         }

    //         $countFamily = $this->input->post("FAM_NAME") ?? 0;
    //         if ($countFamily > 0) {
    //             for ($i = 0; $i < count($countFamily); $i++) {
    //                 $data = [
    //                     "FAM_NAME" => $this->input->post("FAM_NAME")[$i],
    //                     "FAM_CONTACT" => $this->input->post("FAM_CONTACT")[$i],
    //                     "FAM_ADDRESS" => $this->input->post("FAM_ADDRESS")[$i],
    //                     "FAM_RELATIONSHIP" => $this->input->post("FAM_RELATIONSHIP")[$i],
    //                     "FAM_RELATIONSHIP_SPECIFY" => $this->input->post("FAM_RELATIONSHIP_SPECIFY")[$i] ?? "",
    //                     "SP_TRANSID" => $SP_TRANSID
    //                 ];
    //                 $this->db->insert("tbl_studprof_family", $data);
    //             }
    //         }
    //         if ($this->input->post("SP_STATUS") == "DRAFT") {
    //             $result = "Data has been saved as draft.";
    //         } else {
    //             $result = "Data has been saved.";
    //         }
    //     } else {
    //         $result = "Data error saving..";
    //     }
    //     return $result;
    // }

    function saveUpdateSP()
    {
        date_default_timezone_set("Asia/Manila");

        $result = "";
        $isUpdate = isset($_POST['ID']) && !empty($_POST['ID']);
        $spTransId = $this->input->post("SP_TRANSID") ?? "";

        $data = $this->getDataSP();
        $studentName = trim(($data['SP_FNAME'] ?? '') . ' ' . ($data['SP_LNAME'] ?? ''));

        if ($isUpdate) {
            // UPDATE
            $this->db->where("ID", $this->input->post("ID"));
            $this->db->where("SP_TRANSID", $spTransId);

            if ($this->db->update("tbl_studprof", $data)) {
                // Cleanup old records
                $this->db->where("SP_TRANSID", $spTransId)->delete("tbl_studprof_school");
                $this->db->where("SP_TRANSID", $spTransId)->delete("tbl_studprof_family");
                $spStudId = $this->db->where("SP_TRANSID", $spTransId)->get("tbl_studprof")->row("SP_STUDID") ?? "";
                log_audit("UPDATED STUDENT PROFILE", "Student ID: " . $spStudId . " (" . $studentName . ")");
            } else {
                return "Error updating data.";
            }
        } else {
            // INSERT
            $spTransId = $this->generate_transaction_id();
            $spStudId = $this->generate_unique_series();
            $data["SP_TRANSID"] = $spTransId;
            $data["SP_STUDID"] = $spStudId;

            if (!$this->db->insert("tbl_studprof", $data)) {
                return "Error saving data.";
            }
            log_audit("SAVED NEW STUDENT PROFILE", "Student ID: " . $spStudId . " (" . $studentName . ")");
        }

        // Handle School Data
        $educAttain = $this->input->post("EDUC_ATTAIN") ?? [];
        $educNameOfSchool = $this->input->post("EDUC_NAMEOFSCHOOL") ?? [];
        $educAddress = $this->input->post("EDUC_ADDRESS") ?? [];
        $educYear = $this->input->post("EDUC_YEAR") ?? [];
        $educProgram = $this->input->post("EDUC_PROGRAM") ?? [];

        $countEduc = count($educAttain);
        for ($i = 0; $i < $countEduc; $i++) {
            $schoolData = [
                "EDUC_ATTAIN" => $educAttain[$i] ?? "",
                "EDUC_NAMEOFSCHOOL" => $educNameOfSchool[$i] ?? "",
                "EDUC_ADDRESS" => $educAddress[$i] ?? "",
                "EDUC_YEAR" => $educYear[$i] ?? "",
                "EDUC_PROGRAM" => ($educAttain[$i] == 'College') ? ($educProgram[$i] ?? "") : "",
                "SP_TRANSID" => $spTransId
            ];
            $this->db->insert("tbl_studprof_school", $schoolData);
        }

        // Handle Family Data
        $famName = $this->input->post("FAM_NAME") ?? [];
        $famContact = $this->input->post("FAM_CONTACT") ?? [];
        $famAddress = $this->input->post("FAM_ADDRESS") ?? [];
        $famRelationship = $this->input->post("FAM_RELATIONSHIP") ?? [];
        $famRelationshipSpecify = $this->input->post("FAM_RELATIONSHIP_SPECIFY") ?? [];

        $countFamily = count($famName);
        for ($i = 0; $i < $countFamily; $i++) {
            $familyData = [
                "FAM_NAME" => $famName[$i] ?? "",
                "FAM_CONTACT" => $famContact[$i] ?? "",
                "FAM_ADDRESS" => $famAddress[$i] ?? "",
                "FAM_RELATIONSHIP" => $famRelationship[$i] ?? "",
                "FAM_RELATIONSHIP_SPECIFY" => $famRelationshipSpecify[$i] ?? "",
                "SP_TRANSID" => $spTransId
            ];
            $this->db->insert("tbl_studprof_family", $familyData);
        }

        if ($data["SP_STATUS"] === "DRAFT") {
            $result = $isUpdate ? "Draft has been updated." : "Data has been saved as draft.";
        } else {
            $result = $isUpdate ? "Data has been updated." : "Data has been saved.";
        }

        return $result;
    }



    function getDataSP()
    {
        date_default_timezone_set("Asia/Manila");

        $imageName = $this->uploadImage() ?? "";

        $attachmentsFreshmen = $this->input->post("SP_ATTACHMENTS_FRESHMEN") ?? [];
        $attachmentsTransferee = $this->input->post("SP_ATTACHMENTS_TRANSFEREE") ?? [];

        $data = [
            "SP_LRN" => $this->validate_data($this->input->post('SP_LRN')),
            "SP_FIRSTNAME" => $this->validate_data($this->input->post('SP_FIRSTNAME')),
            "SP_MIDDLENAME" => $this->validate_data($this->input->post('SP_MIDDLENAME')),
            "SP_LASTNAME" => $this->validate_data($this->input->post('SP_LASTNAME')),
            "SP_SUFFIX" => $this->validate_data($this->input->post('SP_SUFFIX')),
            "SP_GENDER" => $this->input->post('SP_GENDER') ?? "",
            "SP_BIRTHDAY" => $this->input->post('SP_BIRTHDAY') ?? "",
            "SP_PWD" => $this->input->post('SP_PWD') ?? "",
            "SP_PWD_SPECIFY" => $this->input->post('SP_PWD_SPECIFY') ?? "",
            "SP_REGION" => $this->input->post('SP_REGION') ?? "",
            "SP_PROVINCE" => $this->input->post('SP_PROVINCE') ?? "",
            "SP_MUNICIPALITY" => $this->input->post('SP_MUNICIPALITY') ?? "",
            "SP_BRGY" => $this->input->post('SP_BRGY') ?? "",
            "SP_STRT" => $this->validate_data($this->input->post('SP_STRT')),
            "SP_BIRTHPLACE" => $this->validate_data($this->input->post('SP_BIRTHPLACE')),
            "SP_ZCODE" => $this->input->post('SP_ZCODE') ?? "",
            "SP_CPNUMBER" => $this->input->post('SP_CPNUMBER') ?? "",
            "SP_EMAIL" => $this->input->post('SP_EMAIL') ?? "",
            "SP_CIVILSTATUS" => $this->input->post('SP_CIVILSTATUS') ?? "",
            "SP_NATIONALITY" => $this->input->post('SP_NATIONALITY') ?? "",
            "SP_RELIGION" => $this->input->post('SP_RELIGION') ?? "",
            "SP_TRIBE" => $this->input->post('SP_TRIBE') ?? "",
            "SP_ATTACHMENTS_FRESHMEN" => implode(",", $attachmentsFreshmen),
            "SP_ATTACHMENTS_TRANSFEREE" => implode(",", $attachmentsTransferee),
            "SP_DATESUBMITTED" => date('Y-m-d H:i:s'),
            "SP_ENCODER" => $this->session->userdata("fullname") ?? "Unknown",
            "SP_IMAGE" => $imageName,
            "SP_STATUS" => $this->input->post("SP_STATUS") ?? "DRAFT"
        ];

        return $data;
    }



    function check_permission()
    {
        if (in_array(strtolower(trim($this->session->userdata("usertype") ?? '')), ["administrator", "superadmin", "super admin", "admin"])) {
            return ['View', 'Edit', 'Delete', 'Create'];
        }

        $permission = [];
        $query = $this->db->where([
            "USER_ID" => $this->session->userdata("id"),
            "PAGE" => "Student Profile"
        ])->get("tbl_permissions");

        foreach ($query->result() as $row) {
            $actions = array_map('trim', explode(',', $row->ACTIONS));
            $permission = array_merge($permission, $actions);
        }

        return array_unique($permission); // avoid duplicate actions
    }


    function LoadStudentProfile()
    {
        $permissions = $this->check_permission();
        $is_admin = in_array(strtolower(trim($this->session->userdata("usertype") ?? '')), ["administrator", "superadmin", "super admin", "admin"]);
        $result = "";

        foreach ($this->db->get("tbl_studprof")->result() as $r) {
            $full_name = ($r->SP_SUFFIX)
                ? "{$r->SP_LASTNAME} {$r->SP_SUFFIX}, {$r->SP_FIRSTNAME} {$r->SP_MIDDLENAME}"
                : "{$r->SP_LASTNAME}, {$r->SP_FIRSTNAME} {$r->SP_MIDDLENAME}";

            $status_badge = "<span class='badge rounded-pill bg-" .
                ($r->SP_STATUS === "DRAFT" ? "danger" : "success") . "'>{$r->SP_STATUS}</span>";

            $actions = [];
            if ($is_admin || in_array("View", $permissions)) {
                $actions[] = '<a class="dropdown-item" href="' . base_url("ims/studentprofile/view/{$r->SP_TRANSID}") . '"><i class="ri-eye-line me-1"></i> View</a>';
            }
            if ($is_admin || in_array("Edit", $permissions)) {
                $actions[] = '<a class="dropdown-item" href="' . base_url("ims/studentprofile/edit/{$r->SP_TRANSID}") . '"><i class="ri-edit-line me-1"></i> Edit</a>';
            }
            if ($is_admin || in_array("Delete", $permissions)) {
                $actions[] = '<a class="dropdown-item btnDelete" href="javascript:void(0);" data-id="' . $r->ID . '"><i class="ri-delete-bin-line me-1"></i> Delete</a>';
            }

            $dropdown = $actions ? '
            <div class="dropdown" style="z-index: 2000;">
                <button type="button"  class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="ri-more-2-fill"></i>
                </button>
                <div class="dropdown-menu" style="z-index: 2000; ">' . implode('', $actions) . '</div>
            </div>' : '';

            $result .= "
        <tr>
            <td><input type='checkbox' class='form-check-input row-checkbox' value='" . htmlspecialchars($r->SP_STUDID) . "'></td>
            <td class='d-none'>" . htmlspecialchars($r->ID) . "</td>
            <td>" . htmlspecialchars($r->SP_STUDID) . "</td>
            <td>" . htmlspecialchars($full_name) . "</td>
            <td>" . htmlspecialchars($r->SP_GENDER) . "</td>
            <td>" . htmlspecialchars($r->SP_CPNUMBER) . "</td>
            <td>" . htmlspecialchars($r->SP_EMAIL) . "</td>
            <td>{$status_badge}</td>
            <td>{$dropdown}</td>
        </tr>";
        }

        return $result;
    }

    function generate_unique_series()
    {
        $year = date('Y');
        $prefix = 'LCCr-';

        // Get the highest existing series for the current year
        $this->db->select('SP_STUDID');
        $this->db->like('SP_STUDID', $prefix, 'after');
        $this->db->order_by('SP_STUDID', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_studprof');
        if ($query->num_rows() > 0) {
            $lastSeries = $query->row()->SP_STUDID;
            $lastNumber = intval(substr($lastSeries, strrpos($lastSeries, '-') + 1));
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }

        $series = $prefix . sprintf('%04d', $newNumber);
        return $series;
    }


    function deleteSP()
    {
        $id = $this->input->post("ID");
        $getImage = $this->db->where("ID", $id)->get("tbl_studprof");
        $r = $getImage->row();
        if ($r) {
            @unlink("./uploads/" . $r->SP_IMAGE);
            $details = "Student ID: " . $r->SP_STUDID . " (" . $r->SP_FNAME . " " . $r->SP_LNAME . ")";
        } else {
            $details = "ID: " . $id;
        }

        $this->db->where("ID", $id)->delete("tbl_studprof");
        log_audit("DELETED STUDENT PROFILE", $details);
        return true;
    }

    function getLogsData()
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "AT_DATE" => date('F j, Y / H:i:s'),
            "AT_NAME" => $this->session->userdata('fullname'),
            "AT_ACTION" => "SAVED NEW STUDENT PROFILE"
        ];
        return $data;
    }

    function getLogsDelete()
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "AT_DATE" => date('F j, Y / H:i:s'),
            "AT_NAME" => $this->session->userdata('fullname'),
            "AT_ACTION" => "DELETED STUDENT PROFILE"
        ];
        return $data;
    }
    function getLogsUpdate()
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "AT_DATE" => date('F j, Y / H:i:s'),
            "AT_NAME" => $this->session->userdata('fullname'),
            "AT_ACTION" => "UPDATED STUDENT PROFILE"
        ];
        return $data;
    }

    function FetchEducationAttainment()
    {
        $result = '<div class="col-md-12 mb-2 education-item">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Educational Attainment <small class="textEducAttainment">(--select--)</small></span>
            <button type="button" class="btn btn-danger btn-sm btn-delete-school"><i class="ri-close-line"></i></button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-4">
                        <select class="form-select select2" name="EDUC_ATTAIN[]" required data-allow-clear="true">
                            <option value="">--Select--</option>
                            <option>Elementary</option>
                            <option>Junior High School</option>
                            <option>Senior High School</option>
                            <option>College</option>
                        </select>
                        <label for="EDUC_ATTAIN">Educational Attainment <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" required name="EDUC_NAMEOFSCHOOL[]"
                            placeholder="Enter name of school" />
                        <label for="EDUC_NAMEOFSCHOOL">Name of School <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" required name="EDUC_ADDRESS[]"
                            placeholder="Enter school address" />
                        <label for="EDUC_ADDRESS">School Address <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" required name="EDUC_YEAR[]" placeholder="Enter year" />
                        <label for="EDUC_YEAR">Year <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-12 d-none showCourseTaken">
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control EDUC_PROGRAM" name="EDUC_PROGRAM[]"
                            placeholder="Enter course taken" />
                        <label for="EDUC_PROGRAM">Course Taken <span class="text-danger">*</span></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>';
        return $result;
    }

    function FetchFamilyBackground()
    {
        $result = ' <div class="col-md-12 mb-3 family-item">
        <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Parent/Guardian Details <small class="textFamilyBackground">(--select--)</small></span>
            <button type="button" class="btn btn-danger btn-sm btn-delete-parent"><i class="ri-close-line"></i></button>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" name="FAM_NAME[]" id="FAM_NAME"
                            placeholder="Enter parent/guardian full name" required />
                        <label for="FAM_NAME">Full Name of Parent/Guardian <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-4">
                        <input class="form-control" type="text" name="FAM_CONTACT[]" required />
                        <label for="basic-default-fullname">Contact # <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" name="FAM_ADDRESS[]" id="FAM_ADDRESS"
                            placeholder="Enter Guardian Complete Address" required />
                        <label for="FAM_ADDRESS">Complete address <span class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-floating form-floating-outline mb-4">
                        <select class="form-select select2" name="FAM_RELATIONSHIP[]" data-allow-clear="true" required>
                            <option value="">--Select--</option>
                            <option>Spouse</option>
                            <option>Son/Daughter</option>
                            <option>Sibling (Sister/Brother)</option>
                            <option>Parent</option>
                            <option>Grandparent</option>
                            <option>Grandchild</option>
                            <option>Son-in-law/Daughter-in-law</option>
                            <option>Other relatives, specify</option>
                        </select>
                        <label for="FAM_RELATIONSHIP">Relationship With Guardian <span
                                class="text-danger">*</span></label>
                    </div>
                </div>
                <div class="col-md-12 d-none" id="showSpecify">
                    <div class="form-floating form-floating-outline mb-4">
                        <input type="text" class="form-control" name="FAM_RELATIONSHIP_SPECIFY[]"
                            id="FAM_RELATIONSHIP_SPECIFY" placeholder="Please, specify relationship" />
                        <label for="FAM_RELATIONSHIP_SPECIFY">Please, specify relationship <span
                                class="text-danger">*</span></label>
                    </div>
                </div>
            </div>
        </div>
        </div>
        </div>';
        return $result;
    }


    function countSelectedEligible($student_ids = [])
    {
        if (empty($student_ids)) {
            return 0;
        }

        $this->db->select('s.ID');
        $this->db->from('tbl_studprof s');
        $this->db->join('tbl_enrollment e', 's.SP_STUDID = e.ER_STUDENTID', 'inner');
        $this->db->group_start();
        $this->db->where('s.SP_PORTAL_PASSWORD', NULL);
        $this->db->or_where('s.SP_PORTAL_PASSWORD', '');
        $this->db->group_end();
        $this->db->group_start();
        $this->db->where('s.SP_EMAIL !=', '');
        $this->db->where('s.SP_EMAIL IS NOT NULL', NULL, FALSE);
        $this->db->group_end();
        $this->db->where_in('s.SP_STUDID', $student_ids);
        $this->db->group_by('s.ID');
        
        $query = $this->db->get();
        return $query->num_rows();
    }

    function generateSelectedPortalAccounts($student_ids = [])
    {
        if (empty($student_ids)) {
            return [];
        }

        $this->db->select('s.*');
        $this->db->from('tbl_studprof s');
        $this->db->join('tbl_enrollment e', 's.SP_STUDID = e.ER_STUDENTID', 'inner');
        $this->db->group_start();
        $this->db->where('s.SP_PORTAL_PASSWORD', NULL);
        $this->db->or_where('s.SP_PORTAL_PASSWORD', '');
        $this->db->group_end();
        $this->db->group_start();
        $this->db->where('s.SP_EMAIL !=', '');
        $this->db->where('s.SP_EMAIL IS NOT NULL', NULL, FALSE);
        $this->db->group_end();
        $this->db->where_in('s.SP_STUDID', $student_ids);
        $this->db->group_by('s.ID');

        $query = $this->db->get();
        $students = $query->result();

        $generated_accounts = [];

        foreach ($students as $student) {
            $raw_password = substr(str_shuffle('23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ'), 0, 8);
            $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

            $this->db->where('ID', $student->ID);
            $this->db->update('tbl_studprof', ['SP_PORTAL_PASSWORD' => $hashed_password]);

            $full_name = ($student->SP_SUFFIX)
                ? "{$student->SP_LASTNAME} {$student->SP_SUFFIX}, {$student->SP_FIRSTNAME} {$student->SP_MIDDLENAME}"
                : "{$student->SP_LASTNAME}, {$student->SP_FIRSTNAME} {$student->SP_MIDDLENAME}";

            $generated_accounts[] = [
                'SP_STUDID' => $student->SP_STUDID,
                'FULL_NAME' => $full_name,
                'RAW_PASSWORD' => $raw_password,
                'SP_EMAIL' => $student->SP_EMAIL
            ];

            log_audit("GENERATED PORTAL ACCOUNT", "Student ID: " . $student->SP_STUDID . " (" . $full_name . ")");
        }

        return $generated_accounts;
    }
}
