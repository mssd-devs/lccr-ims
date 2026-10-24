<?php
#[AllowDynamicProperties]
class Fees_Model extends CI_Model
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

    public function LoadFees()
    {
        $result = "";
        $FILTER_PROGRAM = $this->input->post("FILTER_PROGRAM");
        $FILTER_MAJOR = $this->input->post("FILTER_MAJOR");
        $FILTER_YL = $this->input->post("FILTER_YL");
        $FILTER_SEM = $this->input->post("FILTER_SEM");

        // Prepare base SQL query with subqueries to avoid multiplication from joins
        $sql = "SELECT t.*, 
            IFNULL(m.FEES_MISC_AMOUNT, 0) AS FEES_MISC_AMOUNT, 
            IFNULL(o.FEES_OTHER_AMOUNT, 0) AS FEES_OTHER_AMOUNT
        FROM tbl_fees_tuitions AS t
        LEFT JOIN (
            SELECT FEES_TUITION_ID, SUM(CAST(REPLACE(FEES_MISC_AMOUNT, ',', '') AS DECIMAL(12,2))) AS FEES_MISC_AMOUNT
            FROM tbl_fees_miscellaneous
            GROUP BY FEES_TUITION_ID
        ) m ON t.FEES_KEY = m.FEES_TUITION_ID
        LEFT JOIN (
            SELECT FEES_TUITION_ID, SUM(CAST(REPLACE(FEES_OTHER_AMOUNT, ',', '') AS DECIMAL(12,2))) AS FEES_OTHER_AMOUNT
            FROM tbl_fees_otherfees
            GROUP BY FEES_TUITION_ID
        ) o ON t.FEES_KEY = o.FEES_TUITION_ID
        WHERE 1=1";

        // Apply filters if available
        if (!empty($FILTER_PROGRAM)) {
            $sql .= " AND t.FEES_PROGRAM = " . $this->db->escape($FILTER_PROGRAM);
        }
        if (!empty($FILTER_MAJOR)) {
            $sql .= " AND t.FEES_MAJOR = " . $this->db->escape($FILTER_MAJOR);
        }
        if (!empty($FILTER_YL)) {
            $sql .= " AND t.FEES_YEARLEVEL = " . $this->db->escape($FILTER_YL);
        }
        if (!empty($FILTER_SEM)) {
            $sql .= " AND t.FEES_SEMESTER = " . $this->db->escape($FILTER_SEM);
        }

        // No outer GROUP BY needed — aggregation is handled by the subqueries

        // Add ORDER BY clause (descending)
        $sql .= " ORDER BY t.ID DESC";

        // Execute the query
        $query = $this->db->query($sql);

        // Get user permissions
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

        // Initialize row counter
        $i = 1;

        // Build result rows
        foreach ($query->result() as $r) {
            $tuitionFee = floatval(str_replace(',', '', $r->FEES_TOTALTUITION));
            $miscFee = isset($r->FEES_MISC_AMOUNT) ? floatval(str_replace(',', '', $r->FEES_MISC_AMOUNT)) : 0;
            $otherFee = isset($r->FEES_OTHER_AMOUNT) ? floatval(str_replace(',', '', $r->FEES_OTHER_AMOUNT)) : 0;
            $overallTotal = $tuitionFee + $miscFee + $otherFee;

            $tuitionFeeFormatted = number_format($tuitionFee, 2, '.', ',');
            $miscFeeFormatted = number_format($miscFee, 2, '.', ',');
            $otherFeeFormatted = number_format($otherFee, 2, '.', ',');
            $overallTotalFormatted = number_format($overallTotal, 2, '.', ',');

            $major = (!empty($r->FEES_MAJOR)) ? '<small><b>(' . htmlspecialchars($r->FEES_MAJOR) . ')</b></small>' : '';

            $result .= '<tr>';
            $result .= '<td>' . $i++ . '</td>';
            $result .= '<td>' . htmlspecialchars($r->FEES_PROGRAM) . ' ' . $major . '</td>';
            $result .= '<td>' . htmlspecialchars($r->FEES_YEARLEVEL) . '</td>';
            $result .= '<td>' . htmlspecialchars($r->FEES_SEMESTER) . '</td>';
            $result .= '<td>' . $tuitionFeeFormatted . '</td>';
            $result .= '<td>' . $miscFeeFormatted . '</td>';
            $result .= '<td>' . $otherFeeFormatted . '</td>';
            $result .= '<td>' . $overallTotalFormatted . '</td>';
            $result .= '<td>
            <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="ri-more-2-fill"></i>
                </button>
                <div class="dropdown-menu">';

            if (in_array("Edit", $permission)) {
                $result .= '<a class="dropdown-item" href="' . base_url("ims/fees/edit/" . $r->ID) . '">
                        <i class="ri-edit-line me-1"></i> Edit
                    </a>';
            }

            if (in_array("Delete", $permission)) {
                $result .= '<a class="dropdown-item btnDelete" href="javascript:void(0);"
                        data-id="' . $r->ID . '"
                        data-key="' . htmlspecialchars($r->FEES_KEY) . '"
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

    function LoadPrograms()
    {
        $query = $this->db->query("SELECT DISTINCT P_PDESCRIPTIONS FROM tbl_program");
        return $query;
    }

    function LoadTuitions()
    {
        $query = $this->db->query("SELECT DISTINCT * FROM tbl_fees_tuitions");
        return $query;
    }

    function LoadMiscellaneous()
    {
        $query = $this->db->query("SELECT * FROM tbl_fees_miscellaneous");
        return $query;
    }

    function LoadOtherFees()
    {
        $query = $this->db->query("SELECT * FROM tbl_fees_otherfees");
        return $query;
    }

    function LoadSemester()
    {
        $result = "<option value=''>--Select Semester--</option>";
        $prog = $this->input->post("prog");
        $majo = $this->input->post("majo");

        // Adjust query based on whether "maj" is provided or not
        $this->db->where("P_PDESCRIPTIONS", $prog);
        if (!empty($majo)) {
            $this->db->where("P_MAJOR", $majo);
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

        if (empty($added_semesters) && !empty($majo)) {
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

    public function LoadSumUnits($prog, $maj, $yr, $sem)
    {
        $this->db->select_sum('S_UNITS')
            ->from('tbl_subject')
            ->where([
                'S_SELECTPROG' => $prog,
                'S_YRLVL'      => $yr,
                'S_SEM'        => $sem
            ]);

        if (!empty($maj)) {
            $this->db->where('S_MAJOR', $maj);
        }

        $query = $this->db->get();
        $row = $query->row();

        return isset($row->S_UNITS) ? floatval($row->S_UNITS) : 0;
    }


    function LoadMajor()
    {
        $result = "";
        $maj = $this->input->post("maj");
        $query = $this->db->where("P_PDESCRIPTIONS", $maj)->get("tbl_program");
        // $result .= "<option value=''></option>";
        foreach ($query->result() as $r) {
            $result .= "<option>" . $r->P_MAJOR . "</option>";
        }
        return $result;
    }

    function addMiscellaneous()
    {
        $result = "";
        $result .= "<tr>";
        $result .= "<td>";
        $result .= '<input type="text" name="FEES_MISC_DESC[]" required class="form-control" id="FEES_MISC_DESC">';
        $result .= "</td>";
        $result .= "<td>";
        $result .= '<input type="text" name="FEES_MISC_AMOUNT[]" required class="form-control" id="FEES_MISC_AMOUNT">';
        $result .= "</td>";
        $result .= "<td>";
        $result .= '<button type="button" class="btn btn-danger remove-mics"><i class="ri-delete-bin-line me-1"></i></i></button>';
        $result .= "</td>";
        $result .= "</tr>";
        return $result;
    }

    function addOtherFees()
    {
        $result = "";
        $result .= "<tr>";
        $result .= "<td>";
        $result .= '<input type="text" name="FEES_OTHER_DESC[]" required class="form-control" id="FEES_OTHER_DESC">';
        $result .= "</td>";
        $result .= "<td>";
        $result .= '<input type="text" name="FEES_OTHER_AMOUNT[]" required class="form-control" id="FEES_OTHER_AMOUNT">';
        $result .= "</td>";
        $result .= "<td>";
        $result .= '<button type="button" class="btn btn-danger remove-other"><i class="ri-delete-bin-line me-1"></i></button>';
        $result .= "</td>";
        $result .= "</tr>";
        return $result;
    }

    public function generate_fees_id()
    {
        date_default_timezone_set("Asia/Manila");
        // Get the current date and time
        $current_datetime = new DateTime();
        $date_time_string = $current_datetime->format('YmdHis') . rand();
        // Combine the date and time to create the Fees ID
        $fee_id = $date_time_string;
        return $fee_id;
    }

    function saveFees()
    {
        $logsData = $this->getLogsData();
        $ID = $this->input->post("ID");
        $FEES_KEY = $this->input->post("FEES_KEY");
        if ($ID == "") {
            $FEES_KEY = $this->generate_fees_id();
        } else {
            $FEES_KEY = $this->db->where("ID", $ID)->get("tbl_fees_tuitions")->row("FEES_KEY");
        }
        $data = [
            "FEES_KEY" => $FEES_KEY,
            "FEES_PROGRAM" => $this->input->post('FEES_PROGRAM'),
            "FEES_MAJOR" => $this->input->post('FEES_MAJOR'),
            "FEES_YEARLEVEL" => $this->input->post('FEES_YEARLEVEL'),
            "FEES_SEMESTER" => $this->input->post('FEES_SEMESTER'),
            "FEES_AMOUNTPERUNIT" => $this->validate_data($this->input->post('FEES_AMOUNTPERUNIT')),
            "FEES_UNITS" => $this->validate_data($this->input->post('FEES_UNITS')),
            "FEES_LOADS" => $this->validate_data($this->input->post('FEES_LOADS')),
            "FEES_TOTALTUITION" => $this->validate_data($this->input->post('FEES_TOTALTUITION'))
        ];

        $this->db->where("FEES_TUITION_ID", $this->input->post("ID"))->delete("tbl_fees_otherfees");
        $countData = count($_POST["FEES_OTHER_DESC"]);
        if ($countData > 0) {
            for ($i = 0; $i < $countData; $i++) {
                $other = [
                    "FEES_TUITION_ID" => $FEES_KEY,
                    "FEES_OTHER_DESC" => $_POST["FEES_OTHER_DESC"][$i],
                    "FEES_OTHER_AMOUNT" => $_POST["FEES_OTHER_AMOUNT"][$i],
                ];
                $this->db->insert("tbl_fees_otherfees", $other);
            }
        }

        $this->db->where("FEES_TUITION_ID", $this->input->post("ID"))->delete("tbl_fees_miscellaneous");
        $countData = count($_POST["FEES_MISC_DESC"]);
        if ($countData > 0) {
            for ($i = 0; $i < $countData; $i++) {
                $misc = [
                    "FEES_TUITION_ID" => $FEES_KEY,
                    "FEES_MISC_DESC" => $_POST["FEES_MISC_DESC"][$i],
                    "FEES_MISC_AMOUNT" => $_POST["FEES_MISC_AMOUNT"][$i],
                ];
                $this->db->insert("tbl_fees_miscellaneous", $misc);
            }
        }

        if (empty($this->input->post("ID"))) {
            // save
            if ($this->db->insert("tbl_fees_tuitions", $data)) {
                $details = "Program: " . $data['FEES_PROGRAM'] . ", Year: " . $data['FEES_YEARLEVEL'] . ", Sem: " . $data['FEES_SEMESTER'];
                log_audit("SAVED NEW FEE STRUCTURE", $details);
                $this->session->set_flashdata("success", "Data has been saved");
            } else {
                $this->session->set_flashdata("error", "Data error saving..");
            }
        }
        redirect(base_url() . 'ims/fees');
    }

    function updateFees()
    {
        $ID = $this->input->post("ID");
        $FEES_KEY = $this->input->post("FEES_KEY");

        // Generate or retrieve FEES_KEY
        if ($ID == "") {
            $FEES_KEY = $this->generate_fees_id();
        } else {
            $FEES_KEY = $this->db->where("ID", $ID)->get("tbl_fees_tuitions")->row("FEES_KEY");
        }

        // Prepare data for main fees table
        $data = [
            "FEES_KEY" => $FEES_KEY,
            "FEES_PROGRAM" => $this->input->post('FEES_PROGRAM'),
            "FEES_MAJOR" => $this->input->post('FEES_MAJOR'),
            "FEES_YEARLEVEL" => $this->input->post('FEES_YEARLEVEL'),
            "FEES_SEMESTER" => $this->input->post('FEES_SEMESTER'),
            "FEES_AMOUNTPERUNIT" => $this->validate_data($this->input->post('FEES_AMOUNTPERUNIT')),
            "FEES_UNITS" => $this->validate_data($this->input->post('FEES_UNITS')),
            "FEES_LOADS" => $this->validate_data($this->input->post('FEES_LOADS')),
            "FEES_TOTALTUITION" => $this->validate_data($this->input->post('FEES_TOTALTUITION'))
        ];

        // Update or insert into tbl_fees_otherfees
        $this->db->where("FEES_TUITION_ID", $FEES_KEY)->delete("tbl_fees_otherfees");
        $countOtherFees = count($_POST["FEES_OTHER_DESC"]);
        if ($countOtherFees > 0) {
            $otherFeesData = [];
            for ($i = 0; $i < $countOtherFees; $i++) {
                $otherFeesData[] = [
                    "FEES_TUITION_ID" => $FEES_KEY,
                    "FEES_OTHER_DESC" => $_POST["FEES_OTHER_DESC"][$i],
                    "FEES_OTHER_AMOUNT" => $_POST["FEES_OTHER_AMOUNT"][$i],
                ];
            }
            if (!empty($otherFeesData)) {
                $this->db->insert_batch("tbl_fees_otherfees", $otherFeesData);
            }
        }

        // Update or insert into tbl_fees_miscellaneous
        $this->db->where("FEES_TUITION_ID", $FEES_KEY)->delete("tbl_fees_miscellaneous");
        $countMiscFees = count($_POST["FEES_MISC_DESC"]);
        if ($countMiscFees > 0) {
            $miscFeesData = [];
            for ($i = 0; $i < $countMiscFees; $i++) {
                $miscFeesData[] = [
                    "FEES_TUITION_ID" => $FEES_KEY,
                    "FEES_MISC_DESC" => $_POST["FEES_MISC_DESC"][$i],
                    "FEES_MISC_AMOUNT" => $_POST["FEES_MISC_AMOUNT"][$i],
                ];
            }
            if (!empty($miscFeesData)) {
                $this->db->insert_batch("tbl_fees_miscellaneous", $miscFeesData);
            }
        }

        // Insert or update main fees table
        if (empty($ID)) {
            $insertSuccess = $this->db->insert("tbl_fees_tuitions", $data);
            $action = "SAVED NEW FEE STRUCTURE";
        } else {
            $this->db->where("ID", $ID);
            $insertSuccess = $this->db->update("tbl_fees_tuitions", $data);
            $action = "UPDATED FEE STRUCTURE";
        }

        // Audit log
        $details = "Program: " . $data['FEES_PROGRAM'] . ", Year: " . $data['FEES_YEARLEVEL'] . ", Sem: " . $data['FEES_SEMESTER'];
        log_audit($action, $details);

        // Set flash message
        if ($insertSuccess) {
            $this->session->set_flashdata("success", "Data has been updated.");
        } else {
            $this->session->set_flashdata("error", "Error saving data.");
        }

        redirect(base_url() . 'ims/fees');
    }

    public function deleteFees()
    {
        $feesKey = $this->input->post("FEES_KEY");

        if (!$feesKey) {
            $this->session->set_flashdata('error', "Invalid deletion request.");
            redirect(base_url('ims/fees'));
            return;
        }

        $fee = $this->db->where("FEES_KEY", $feesKey)->get("tbl_fees_tuitions")->row();
        $details = $fee ? ("Program: " . $fee->FEES_PROGRAM . ", Year: " . $fee->FEES_YEARLEVEL) : ("Fee Key: " . $feesKey);

        // Delete related fee records
        $this->db->where("FEES_KEY", $feesKey)->delete("tbl_fees_tuitions");
        $this->db->where("FEES_TUITION_ID", $feesKey)->delete("tbl_fees_miscellaneous");
        $this->db->where("FEES_TUITION_ID", $feesKey)->delete("tbl_fees_otherfees");

        // Log action
        log_audit("DELETED FEE STRUCTURE", $details);

        $this->session->set_flashdata('success', "Data has been deleted.");
        redirect(base_url('ims/fees'));
    }

    private function getLogsData()
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "AT_DATE" => date('F j, Y / H:i:s'),
            "AT_NAME" => $this->session->userdata('fullname'),
            "AT_ACTION" => "SAVED NEW PROGRAM FEES"
        ];
        return $data;
    }

    private function getLogsDelete()
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "AT_DATE" => date('F j, Y / H:i:s'),
            "AT_NAME" => $this->session->userdata('fullname'),
            "AT_ACTION" => "DELETED PROGRAM FEES"
        ];
        return $data;
    }
    private function getLogsUpdate()
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "AT_DATE" => date('F j, Y / H:i:s'),
            "AT_NAME" => $this->session->userdata('fullname'),
            "AT_ACTION" => "UPDATED PROGRAM FEES"
        ];
        return $data;
    }
}
