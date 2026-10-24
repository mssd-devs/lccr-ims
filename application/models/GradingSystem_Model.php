<?php
#[AllowDynamicProperties]
class GradingSystem_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function validate_data($data)
    {
        if ($data === null) {
            return "";
        }
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function LoadGradeClass()
    {
        $result = "";
        $FILTER_PROGRAM = $this->input->post("FILTER_PROGRAM");
        $FILTER_MAJOR = $this->input->post("FILTER_MAJOR");
        $FILTER_YL = $this->input->post("FILTER_YL");
        $FILTER_AY = $this->input->post("FILTER_AY");
        $FILTER_SEM = $this->input->post("FILTER_SEM");

        $params = [];
        $sql = "SELECT * FROM tbl_scheduling WHERE SC_FACULTY = ?";
        $params[] = $this->session->userdata('fullname');

        if (!empty($FILTER_PROGRAM)) {
            $sql .= " AND SC_PROG = ?";
            $params[] = $FILTER_PROGRAM;
        }
        if (!empty($FILTER_MAJOR)) {
            $sql .= " AND SC_MAJOR = ?";
            $params[] = $FILTER_MAJOR;
        }
        if (!empty($FILTER_YL)) {
            $sql .= " AND SC_YEARLEVEL = ?";
            $params[] = $FILTER_YL;
        }
        if (!empty($FILTER_AY)) {
            $sql .= " AND SC_ACADEMICYEAR = ?";
            $params[] = $FILTER_AY;
        }
        if (!empty($FILTER_SEM)) {
            $sql .= " AND SC_SEMESTER = ?";
            $params[] = $FILTER_SEM;
        }

        $query = $this->db->query($sql, $params);

        foreach ($query->result() as $r) {
            $major = !empty($r->SC_MAJOR) ? '<small><b>(' . $r->SC_MAJOR . ')</b></small>' : '';

            $result .= '<tr>';
            $result .= '<td>' . $r->SC_SDESC . '</td>';
            $result .= '<td>' . $r->SC_PROG . ' ' . $major . '</td>';
            $result .= '<td>' . $r->SC_YEARLEVEL . '</td>';
            $result .= '<td>' . $r->SC_SEMESTER . '</td>';
            $result .= '<td>' . $r->SC_SECTION . '</td>';

            $gradeQuery = $this->db->where("GS_SCHEDID", $r->ID)->get("tbl_gradingsystem");

            $status = "";
            $showEnter = false;
            $showEdit = false;
            $showPrint = false;
            $badge = '<span class="badge rounded-pill bg-danger">NO GRADES</span>';

            if ($gradeQuery->num_rows() > 0) {
                $row = $gradeQuery->row();
                $status = strtoupper($row->GS_STATUS);

                if ($status === "SAVED") {
                    $badge = '<span class="badge rounded-pill bg-success">SAVED</span>';
                    $showPrint = true;
                } elseif ($status === "DRAFT") {
                    $badge = '<span class="badge rounded-pill bg-warning">DRAFT</span>';
                    $showEdit = true;
                } else {
                    $badge = '<span class="badge rounded-pill bg-primary">' . $status . '</span>';
                }
            } else {
                // NO GRADES
                $showEnter = true;
            }

            $result .= '<td>' . $badge . '</td>';

            // Action buttons
            $result .= '<td>';
            if ($showEnter) {
                $result .= '<a type="button" class="btn btn-xs btn-primary" href="' . base_url("ims/gradingsystem/encodegrades/$r->ID") . '"><i class="ri-add-line"></i> Enter Grades</a> ';
            }
            if ($showEdit) {
                $result .= '<a type="button" class="btn btn-xs btn-warning" href="' . base_url("ims/gradingsystem/edit/$r->ID") . '"><i class="ri-pencil-line"></i> Edit Grades</a> ';
            }
            if ($showPrint) {
                $result .= '<button type="button" class="btn btn-xs btn-secondary btn-class-grades" data-id="' . $r->ID . '"><i class="ri-printer-line"></i> Print Grades</a> ';
            }
            $result .= '</td>';
            $result .= '</tr>';
        }

        return $result;
    }

    public function generate_gradekey_id()
    {
        date_default_timezone_set("Asia/Manila");
        // Get the current date and time
        $current_datetime = new DateTime();
        $date_time_string = $current_datetime->format('YmdHis') . rand();
        // Combine the date and time to create the transaction ID
        $transaction_id = $date_time_string;
        return $transaction_id;
    }

    public function saveUpdateForm()
    {
        // Get shared data
        $schedid = $this->validate_data($this->input->post("GS_SCHEDID"));
        $classcode = $this->validate_data($this->input->post("GS_CLASSCODE"));
        $ay = $this->validate_data($this->input->post("GS_ACADEMICYEAR"));
        $sem = $this->validate_data($this->input->post("GS_SEMESTER"));
        $subject = $this->validate_data($this->input->post("GS_SUBJECT"));
        $year_level = $this->validate_data($this->input->post("GS_YEARLEVEL"));
        $section = $this->validate_data($this->input->post("GS_SECTION"));
        $status = $this->validate_data($this->input->post("GS_STATUS"));
        $encoder = $this->session->userdata('fullname');

        // Check if a GS_UID already exists for this schedule
        $existing_uid_query = $this->db->select("GS_UID")
            ->where("GS_SCHEDID", $schedid)
            ->limit(1)
            ->get("tbl_gradingsystem");

        if ($existing_uid_query->num_rows() > 0) {
            $GS_UID = $existing_uid_query->row()->GS_UID;
        } else {
            $GS_UID = $this->generate_gradekey_id();
        }

        // Get student lists
        $student_ids = $this->input->post("GS_STUDENTID");
        $fullnames = $this->input->post("GS_FULLNAME");
        $remarks = $this->input->post("GS_REMARKS") ?: [];
        $attendance = $this->input->post("GS_ATTENDANCE") ?: [];
        $prelim = $this->input->post("GS_EXAMPRELIM") ?: [];
        $midterm = $this->input->post("GS_EXAMMIDTERM") ?: [];
        $final_exam = $this->input->post("GS_EXAMFINAL") ?: [];
        $finalreq = $this->input->post("GS_FINALREQ") ?: [];
        $performance = $this->input->post("GS_PERFORMANCE") ?: [];
        $written = $this->input->post("GS_WRITTEN") ?: [];
        $finalgrade_sum = $this->input->post("GS_FINALGRADE") ?: [];
        $transmuted = $this->input->post("GS_TRANSMUTED") ?: [];

        if (!empty($student_ids) && is_array($student_ids)) {
            foreach ($student_ids as $i => $student_id) {
                $data = [
                    "GS_UID" => $GS_UID,
                    "GS_STUDENTID" => $this->validate_data($student_ids[$i]),
                    "GS_FULLNAME" => $this->validate_data($fullnames[$i]),
                    "GS_REMARKS" => isset($remarks[$i]) ? $this->validate_data($remarks[$i]) : "",
                    "GS_SCHEDID" => $schedid,
                    "GS_CLASSCODE" => $classcode,
                    "GS_ACADEMICYEAR" => $ay,
                    "GS_SEMESTER" => $sem,
                    "GS_SUBJECT" => $subject,
                    "GS_YEARLEVEL" => $year_level,
                    "GS_SECTION" => $section,
                    "GS_STATUS" => $status,
                    "GS_ATTENDANCE" => isset($attendance[$i]) ? $attendance[$i] : "",
                    "GS_EXAMPRELIM" => isset($prelim[$i]) ? $prelim[$i] : "",
                    "GS_EXAMMIDTERM" => isset($midterm[$i]) ? $midterm[$i] : "",
                    "GS_EXAMFINAL" => isset($final_exam[$i]) ? $final_exam[$i] : "",
                    "GS_FINALREQ" => isset($finalreq[$i]) ? $finalreq[$i] : "",
                    "GS_PERFORMANCE" => isset($performance[$i]) ? $performance[$i] : "",
                    "GS_WRITTEN" => isset($written[$i]) ? $written[$i] : "",
                    "GS_FINALGRADE" => isset($finalgrade_sum[$i]) ? $finalgrade_sum[$i] : "",
                    "GS_TRANSMUTED" => isset($transmuted[$i]) ? $transmuted[$i] : "",
                    "GS_FACULTY" => $encoder
                ];

                // Check for existing record
                $existing = $this->db
                    ->where("GS_SCHEDID", $schedid)
                    ->where("GS_STUDENTID", $student_ids[$i])
                    ->get("tbl_gradingsystem")
                    ->row();

                if ($existing) {
                    $this->db
                        ->where("GS_SCHEDID", $schedid)
                        ->where("GS_STUDENTID", $student_ids[$i])
                        ->update("tbl_gradingsystem", $data);
                } else {
                    $this->db->insert("tbl_gradingsystem", $data);
                }

                // Keep tbl_studentgrades in sync
                $transmuted_val = isset($transmuted[$i]) ? $transmuted[$i] : "";
                $raw_remarks    = isset($remarks[$i]) ? $remarks[$i] : "";
                $norm_remarks   = ($transmuted_val == '5.0' || $transmuted_val == '5.00' || $raw_remarks == 'Failure') ? 'FAILED' : (($transmuted_val == 'INC' || $raw_remarks == 'INC') ? 'INCOMPLETE' : (($transmuted_val == 'DRP' || $raw_remarks == 'DROPPED') ? 'DROPPED' : 'PASSED'));

                $sg_existing = $this->db
                    ->where("G_SCHEDID", $schedid)
                    ->where("G_STUDENTID", $student_ids[$i])
                    ->get("tbl_studentgrades")
                    ->row();

                $sg_data = [
                    "G_UID"            => $GS_UID,
                    "G_STUDENTID"      => $this->validate_data($student_ids[$i]),
                    "G_FULLNAME"       => $this->validate_data($fullnames[$i]),
                    "G_GRADE"          => $transmuted_val,
                    "G_REMARKS"        => $norm_remarks,
                    "G_SCHEDID"        => $schedid,
                    "G_CLASSCODE"      => $classcode,
                    "G_ACADEMICYEAR"   => $ay,
                    "G_SEMESTER"       => $sem,
                    "G_SUBJECT"        => $subject,
                    "G_YEARLEVEL"      => $year_level,
                    "G_SECTION"        => $section,
                    "G_STATUS"         => $status,
                    "G_ENCODERTEACHER" => $encoder,
                    "G_DATESUBMITTED"  => date('Y-m-d H:i:s')
                ];

                if ($sg_existing) {
                    $this->db
                        ->where("G_SCHEDID", $schedid)
                        ->where("G_STUDENTID", $student_ids[$i])
                        ->update("tbl_studentgrades", $sg_data);
                } else {
                    $this->db->insert("tbl_studentgrades", $sg_data);
                }
            }

            // Audit Log
            log_audit("SUBMITTED GRADES", "Classcode: " . $classcode . ", Status: " . $status);

            $this->session->set_flashdata("success", $status === "SAVED"
                ? "All grades have been successfully submitted."
                : "All grades have been saved as draft.");
        }

        return ["status" => true];
    }

    private function getLogsData()
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "AT_DATE" => date('F j, Y / H:i:s'),
            "AT_NAME" => $this->session->userdata('fullname'),
            "AT_ACTION" => "SAVED AND UPDATED GRADE RECORD"
        ];
        return $data;
    }

    public function saveConfig()
    {
        $schedid = $this->validate_data($this->input->post("GC_SCHEDID"));
        if (empty($schedid)) {
            return ["status" => false, "message" => "Schedule ID is required."];
        }

        $data = [
            "GC_SCHEDID" => $schedid,
            "GC_ATTENDANCE_ACTIVE" => $this->input->post("GC_ATTENDANCE_ACTIVE") ? 1 : 0,
            "GC_ATTENDANCE_PCT" => floatval($this->input->post("GC_ATTENDANCE_PCT")),
            "GC_ATTENDANCE_MAX" => floatval($this->input->post("GC_ATTENDANCE_MAX")),
            "GC_EXAMPRELIM_ACTIVE" => $this->input->post("GC_EXAMPRELIM_ACTIVE") ? 1 : 0,
            "GC_EXAMPRELIM_PCT" => floatval($this->input->post("GC_EXAMPRELIM_PCT")),
            "GC_EXAMPRELIM_MAX" => floatval($this->input->post("GC_EXAMPRELIM_MAX")),
            "GC_EXAMMIDTERM_ACTIVE" => $this->input->post("GC_EXAMMIDTERM_ACTIVE") ? 1 : 0,
            "GC_EXAMMIDTERM_PCT" => floatval($this->input->post("GC_EXAMMIDTERM_PCT")),
            "GC_EXAMMIDTERM_MAX" => floatval($this->input->post("GC_EXAMMIDTERM_MAX")),
            "GC_EXAMFINAL_ACTIVE" => $this->input->post("GC_EXAMFINAL_ACTIVE") ? 1 : 0,
            "GC_EXAMFINAL_PCT" => floatval($this->input->post("GC_EXAMFINAL_PCT")),
            "GC_EXAMFINAL_MAX" => floatval($this->input->post("GC_EXAMFINAL_MAX")),
            "GC_FINALREQ_ACTIVE" => $this->input->post("GC_FINALREQ_ACTIVE") ? 1 : 0,
            "GC_FINALREQ_PCT" => floatval($this->input->post("GC_FINALREQ_PCT")),
            "GC_FINALREQ_MAX" => floatval($this->input->post("GC_FINALREQ_MAX")),
            "GC_PERFORMANCE_ACTIVE" => $this->input->post("GC_PERFORMANCE_ACTIVE") ? 1 : 0,
            "GC_PERFORMANCE_PCT" => floatval($this->input->post("GC_PERFORMANCE_PCT")),
            "GC_PERFORMANCE_MAX" => floatval($this->input->post("GC_PERFORMANCE_MAX")),
            "GC_WRITTEN_ACTIVE" => $this->input->post("GC_WRITTEN_ACTIVE") ? 1 : 0,
            "GC_WRITTEN_PCT" => floatval($this->input->post("GC_WRITTEN_PCT")),
            "GC_WRITTEN_MAX" => floatval($this->input->post("GC_WRITTEN_MAX"))
        ];

        $existing = $this->db->get_where("tbl_grading_config", ["GC_SCHEDID" => $schedid])->row();
        if ($existing) {
            $this->db->where("GC_SCHEDID", $schedid)->update("tbl_grading_config", $data);
            $action = "UPDATED";
        } else {
            $this->db->insert("tbl_grading_config", $data);
            $action = "CREATED";
        }

        log_audit("GRADING STRUCTURE " . $action, "Sched ID: " . $schedid);

        return ["status" => true, "message" => "Grading structure saved successfully."];
    }
}
