<?php
#[AllowDynamicProperties]
class TFgrades_Model extends CI_Model
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

    function LoadPrograms()
    {
        $query = $this->db->query("SELECT DISTINCT P_PDESCRIPTIONS FROM tbl_program");
        return $query;
    }

    public function LoadTFGrades()
    {
        $result = "";
        $FILTER_PROGRAM = $this->input->post("FILTER_PROGRAM");
        $FILTER_MAJOR = $this->input->post("FILTER_MAJOR");
        $FILTER_YL = $this->input->post("FILTER_YL");
        $FILTER_AY = $this->input->post("FILTER_AY");
        $FILTER_SEM = $this->input->post("FILTER_SEM");

        // Base subquery to get latest ID per TG_KEY
        $sql = "SELECT t.* 
            FROM tbl_transfereegrades AS t
            WHERE t.TG_KEY IN (
                SELECT MIN(ts.TG_KEY) 
                FROM tbl_transfereegrades_subj ts
                GROUP BY ts.TG_KEY
            )";

        // Apply filters to the outer query
        if (!empty($FILTER_PROGRAM)) {
            $sql .= " AND t.TG_PROGRAM = " . $this->db->escape($FILTER_PROGRAM);
        }
        if (!empty($FILTER_MAJOR)) {
            $sql .= " AND t.TG_MAJOR = " . $this->db->escape($FILTER_MAJOR);
        }
        if (!empty($FILTER_YL)) {
            $sql .= " AND t.TG_YEARLEVEL = " . $this->db->escape($FILTER_YL);
        }
        if (!empty($FILTER_AY)) {
            $sql .= " AND t.TG_ACADEMICYEAR = " . $this->db->escape($FILTER_AY);
        }
        if (!empty($FILTER_SEM)) {
            $sql .= " AND t.TG_SEMESTER = " . $this->db->escape($FILTER_SEM);
        }

        // Execute the query
        $query = $this->db->query($sql);

        // Permissions
        $permission = [];
        if (in_array(strtolower(trim($this->session->userdata("usertype") ?? '')), ["administrator", "superadmin", "super admin", "admin"])) {
            $permission = ['View', 'Edit', 'Delete', 'Create'];
        } else {
            if (isset($this->rbac) && $this->rbac->num_rows() > 0) {
                foreach ($this->rbac->result() as $rbac_row) {
                    $actions = array_map('trim', explode(',', $rbac_row->ACTIONS));
                    $permission = array_merge($permission, $actions);
                }
            }
        }

        // Build result table
        foreach ($query->result() as $r) {
            $major = (!empty($r->TG_MAJOR)) ? '<small><b>(' . htmlspecialchars($r->TG_MAJOR) . ')</b></small>' : '';

            $result .= '<tr>';
            $result .= '<td>' . htmlspecialchars($r->TG_STUDENTID) . '</td>';
            $result .= '<td>' . htmlspecialchars($r->TG_NAMEOFSTUDENT) . '</td>';
            $result .= '<td>' . htmlspecialchars($r->TG_PROGRAM) . ' ' . $major . '</td>';
            $result .= '<td>' . htmlspecialchars($r->TG_YEARLEVEL) . '</td>';
            $result .= '<td>' . htmlspecialchars($r->TG_ACADEMICYEAR . '-' . ($r->TG_ACADEMICYEAR + 1)) . '</td>';
            $result .= '<td>' . htmlspecialchars($r->TG_SEMESTER) . '</td>';
            $result .= '<td>' . htmlspecialchars($r->TG_HEISFROM) . '</td>';
            $result .= '<td>
            <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="ri-more-2-fill"></i>
                </button>
                <div class="dropdown-menu">';

            if (in_array("Edit", $permission)) {
                $result .= '<a class="dropdown-item" href="' . base_url("ims/grade/tfgrades/edit/" . $r->TG_KEY) . '">
                        <i class="ri-edit-line me-1"></i> Edit
                    </a>';
            }

            if (in_array("Delete", $permission)) {
                $result .= '<a class="dropdown-item btnDelete" href="javascript:void(0);"
                        data-id="' . $r->ID . '"
                        data-key="' . htmlspecialchars($r->TG_KEY) . '"
                        data-bs-toggle="modal"
                        data-bs-target="#deleteModal">
                        <i class="ri-delete-bin-line me-1"></i> Delete
                    </a>';
            }

            $result .= '   </div>
            </div>
        </td>';
            $result .= '</tr>';
        }

        return $result;
    }




    function LoadMajor()
    {
        $result = "";
        $maj = $this->input->post("maj");
        $query = $this->db->where("P_PDESCRIPTIONS", $maj)->get("tbl_program");
        $result .= "<option selected=''></option>";
        foreach ($query->result() as $r) {
            $result .= "<option>" . $r->P_MAJOR . "</option>";
        }
        return $result;
    }

    function LoadSemester()
    {
        $result = "<option selected=''>--Select Semester--</option>";
        $prog = $this->input->post("prog");
        $maj = $this->input->post("maj");

        // Adjust query based on whether "maj" is provided or not
        $this->db->where("P_PDESCRIPTIONS", $prog);
        if (!empty($maj)) {
            $this->db->where("P_MAJOR", $maj);
        }
        $query = $this->db->get("tbl_program");

        $added_semesters = [];
        foreach ($query->result() as $r) {
            $semesters = $this->db
                ->order_by("SEM_NAME", "ASC")
                ->get("tbl_semestertype")
                ->result();

            foreach ($semesters as $semester) {
                if ($r->P_SEMTYPE == $semester->SEM_TYPE && !in_array($semester->SEM_NAME, $added_semesters)) {
                    $result .= "<option value='" . htmlspecialchars($semester->SEM_NAME, ENT_QUOTES) . "'>" . htmlspecialchars($semester->SEM_NAME, ENT_QUOTES) . "</option>";
                    $added_semesters[] = $semester->SEM_NAME;
                }
            }
        }

        if (empty($added_semesters) && !empty($maj)) {
            $query = $this->db->where("P_PDESCRIPTIONS", $prog)->get("tbl_program");
            foreach ($query->result() as $r) {
                $semesters = $this->db
                    ->order_by("SEM_NAME", "ASC")
                    ->get("tbl_semestertype")
                    ->result();

                foreach ($semesters as $semester) {
                    if ($r->P_SEMTYPE == $semester->SEM_TYPE && !in_array($semester->SEM_NAME, $added_semesters)) {
                        $result .= "<option value='" . htmlspecialchars($semester->SEM_NAME, ENT_QUOTES) . "'>" . htmlspecialchars($semester->SEM_NAME, ENT_QUOTES) . "</option>";
                        $added_semesters[] = $semester->SEM_NAME;
                    }
                }
            }
        }

        if (empty($added_semesters)) {
            $semesters = $this->db->order_by("SEM_NAME", "ASC")->get("tbl_semestertype")->result();
            foreach ($semesters as $semester) {
                if (!in_array($semester->SEM_NAME, $added_semesters)) {
                    $result .= "<option value='" . htmlspecialchars($semester->SEM_NAME, ENT_QUOTES) . "'>" . htmlspecialchars($semester->SEM_NAME, ENT_QUOTES) . "</option>";
                    $added_semesters[] = $semester->SEM_NAME;
                }
            }
        }

        return $result;
    }

    function addGrades()
    {
        $result = "";
        $result .= "<tr>";

        // SUBJECT COURSE input (text, visible size 15 chars)
        $result .= "<td>";
        $result .= '<input type="text" name="TG_COURSENO[]" id="TG_COURSENO" size="15" required class="form-control">';
        $result .= "</td>";

        // DESCRIPTIVE TITLE input (text, visible size 40 chars)
        $result .= "<td>";
        $result .= '<input type="text" name="TG_SUBJECT[]" id="TG_SUBJECT" size="75" required class="form-control">';
        $result .= "</td>";

        // UNITS input (number, size 5)
        $result .= "<td>";
        $result .= '<input type="number" name="TG_UNITS[]" id="TG_UNITS" min="0" size="1" required class="form-control">';
        $result .= "</td>";

        // GRADE input (number, width controlled)
        $result .= "<td>";
        $result .= '<select class="form-select select2" id="TG_GRADES" name="TG_GRADES[]" style="width: 250px" data-student="<?= $student_id ?>">
                        <option value=""></option>
                        <option>1.00</option>
                        <option>1.25</option>
                        <option>1.50</option>
                        <option>1.75</option>
                        <option>2.00</option>
                        <option>2.25</option>
                        <option>2.50</option>
                        <option>2.75</option>
                        <option>3.00</option>
                        <option>5.00</option>
                        <option>INC</option>
                        <option>DRP</option>
                    </select>';
        $result .= "</td>";


        // Remove button
        $result .= "<td>";
        $result .= '<button type="button" class="btn btn-danger remove-subj"><i class="ri-delete-bin-line me-1"></i></button>';
        $result .= "</td>";

        $result .= "</tr>";
        return $result;
    }


    public function generate_tf_key()
    {
        // Generate a 4-digit random number between 1000 and 9999
        $tf_key = rand();
        return $tf_key;
    }

    function SaveTFGrades()
    {
        $logsData = $this->getLogsData();
        date_default_timezone_set("Asia/Manila");


        $ID = $this->input->post("ID");
        $TG_KEY = $this->input->post("TG_KEY");
        if ($ID == "") {
            $TG_KEY = $this->generate_tf_key();
        } else {
            $TG_KEY = $this->db->where("ID", $ID)->get("tbl_fees_tuitions")->row("TG_KEY");
        }
        $data = [
            "TG_KEY" => $TG_KEY,
            "TG_STUDENTID" => $this->validate_data($this->input->post("TG_STUDENTID")),
            "TG_NAMEOFSTUDENT" => $this->validate_data($this->input->post("TG_NAMEOFSTUDENT")),
            "TG_PROGRAM" => $this->validate_data($this->input->post("TG_PROGRAM")),
            "TG_MAJOR" => $this->validate_data($this->input->post("TG_MAJOR")),
            "TG_ACADEMICYEAR" => $this->validate_data($this->input->post("TG_ACADEMICYEAR")),
            "TG_SEMESTER" => $this->validate_data($this->input->post("TG_SEMESTER")),
            "TG_YEARLEVEL" => $this->validate_data($this->input->post("TG_YEARLEVEL")),
            "TG_HEISFROM" => $this->validate_data($this->input->post("TG_HEISFROM")),
            "TG_DATESUBMITTED" => date('F j, Y')
        ];

        $this->db->where("TG_KEY", $this->input->post("ID"))->delete("tbl_transfereegrades_subj");
        $countData = count($_POST["TG_SUBJECT"]);
        if ($countData > 0) {
            for ($i = 0; $i < $countData; $i++) {
                $other = [
                    "TG_KEY" => $TG_KEY,
                    "TG_COURSENO" => $_POST["TG_COURSENO"][$i],
                    "TG_SUBJECT" => $_POST["TG_SUBJECT"][$i],
                    "TG_UNITS" => $_POST["TG_UNITS"][$i],
                    "TG_GRADES" => $_POST["TG_GRADES"][$i],
                ];
                $this->db->insert("tbl_transfereegrades_subj", $other);
            }
        }

        if (empty($this->input->post("ID"))) {
            // save
            if ($this->db->insert("tbl_transfereegrades", $data)) {
                $details = "Student ID: " . $data['TG_STUDENTID'] . " (" . $data['TG_NAMEOFSTUDENT'] . ")";
                log_audit("SAVED NEW TRANSFEREE GRADES", $details);
                $this->session->set_flashdata("success", "Data has been saved");
            } else {
                $this->session->set_flashdata("error", "Data error saving..");
            }
        }
        redirect(base_url() . 'ims/grade/tfgrades');
    }

    public function UpdateTFGrades()
    {
        date_default_timezone_set("Asia/Manila");

        $ID = $this->input->post("ID");
        $TG_KEY = $this->input->post("TG_KEY");

        // Validate existence of TG_KEY and ID
        if (empty($ID) || empty($TG_KEY)) {
            $this->session->set_flashdata("error", "Missing or invalid record ID.");
            redirect(base_url('ims/grade/tfgrades'));
            return;
        }

        // Main update data
        $data = [
            "TG_STUDENTID" => $this->validate_data($this->input->post("TG_STUDENTID")),
            "TG_NAMEOFSTUDENT" => $this->validate_data($this->input->post("TG_NAMEOFSTUDENT")),
            "TG_PROGRAM" => $this->validate_data($this->input->post("TG_PROGRAM")),
            "TG_MAJOR" => $this->validate_data($this->input->post("TG_MAJOR")),
            "TG_ACADEMICYEAR" => $this->validate_data($this->input->post("TG_ACADEMICYEAR")),
            "TG_SEMESTER" => $this->validate_data($this->input->post("TG_SEMESTER")),
            "TG_YEARLEVEL" => $this->validate_data($this->input->post("TG_YEARLEVEL")),
            "TG_HEISFROM" => $this->validate_data($this->input->post("TG_HEISFROM")),
            "TG_DATESUBMITTED" => date('F j, Y'),
        ];

        // Delete old subject entries related to TG_KEY
        $this->db->where("TG_KEY", $TG_KEY)->delete("tbl_transfereegrades_subj");

        // Re-insert updated subject entries
        $subjects = $this->input->post("TG_SUBJECT");
        if (!empty($subjects)) {
            $countData = count($subjects);
            for ($i = 0; $i < $countData; $i++) {
                $other = [
                    "TG_KEY" => $TG_KEY,
                    "TG_COURSENO" => $_POST["TG_COURSENO"][$i],
                    "TG_SUBJECT" => $_POST["TG_SUBJECT"][$i],
                    "TG_UNITS" => $_POST["TG_UNITS"][$i],
                    "TG_GRADES" => $_POST["TG_GRADES"][$i],
                ];
                $this->db->insert("tbl_transfereegrades_subj", $other);
            }
        }

        // Update the main record
        $this->db->where("TG_KEY", $TG_KEY);
        if ($this->db->update("tbl_transfereegrades", $data)) {
            $details = "Student ID: " . $data['TG_STUDENTID'] . " (" . $data['TG_NAMEOFSTUDENT'] . ")";
            log_audit("UPDATED TRANSFEREE GRADES", $details);
            $this->session->set_flashdata("success", "Data has been updated successfully.");
        } else {
            $this->session->set_flashdata("error", "Failed to update data.");
        }

        redirect(base_url('ims/grade/tfgrades'));
    }


    public function validate_updatedata($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function DeleteTFGrades()
    {
        $TGKey = $this->input->post("TG_KEY");

        if (!$TGKey) {
            $this->session->set_flashdata('error', "Invalid deletion request.");
            redirect(base_url('ims/grade/tfgrades'));
            return;
        }

        $tf = $this->db->where("TG_KEY", $TGKey)->get("tbl_transfereegrades")->row();
        $details = $tf ? ("Student ID: " . $tf->TG_STUDENTID . " (" . $tf->TG_NAMEOFSTUDENT . ")") : ("Key: " . $TGKey);

        // Delete related fee records
        $this->db->where("TG_KEY", $TGKey)->delete("tbl_transfereegrades");
        $this->db->where("TG_KEY", $TGKey)->delete("tbl_transfereegrades_subj");

        // Log action
        log_audit("DELETED TRANSFEREE GRADES", $details);

        $this->session->set_flashdata('success', "Data has been deleted.");
        redirect(base_url('ims/grade/tfgrades'));
    }


    private function getLogsData()
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "AT_DATE" => date('F j, Y / H:i:s'),
            "AT_NAME" => $this->session->userdata('fullname'),
            "AT_ACTION" => "SAVED NEW TRANSFEREE GRADE RECORD"
        ];
        return $data;
    }

    private function getLogsDelete()
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "AT_DATE" => date('F j, Y / H:i:s'),
            "AT_NAME" => $this->session->userdata('fullname'),
            "AT_ACTION" => "DELETED TRANSFEREE GRADE RECORD"
        ];
        return $data;
    }
    private function getLogsUpdate()
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "AT_DATE" => date('F j, Y / H:i:s'),
            "AT_NAME" => $this->session->userdata('fullname'),
            "AT_ACTION" => "UPDATED TRANSFEREE GRADE RECORD"
        ];
        return $data;
    }
}
