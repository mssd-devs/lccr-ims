<?php
#[AllowDynamicProperties]
class Grade_Model extends CI_Model
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

            $gradeQuery = $this->db->where("G_SCHEDID", $r->ID)->get("tbl_studentgrades");

            $status = "";
            $showEnter = false;
            $showEdit = false;
            $showPrint = false;
            $badge = '<span class="badge rounded-pill bg-danger">NO GRADES</span>';

            if ($gradeQuery->num_rows() > 0) {
                $row = $gradeQuery->row();
                $status = strtoupper($row->G_STATUS);

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
                $showEnter = true;
            }

            $result .= '<td>' . $badge . '</td>';
            $result .= '<td>';
            if ($showEnter) {
                $result .= '<a type="button" class="btn btn-xs btn-primary" href="' . base_url("ims/grades/encodegrades/$r->ID") . '"><i class="ri-add-line"></i> Enter Grades</a> ';
            }
            if ($showEdit) {
                $result .= '<a type="button" class="btn btn-xs btn-warning" href="' . base_url("ims/grades/edit/$r->ID") . '"><i class="ri-pencil-line"></i> Edit Grades</a> ';
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
        $current_datetime = new DateTime();
        $date_time_string = $current_datetime->format('YmdHis') . rand();
        return $date_time_string;
    }

    public function saveUpdateForm()
    {
        $ID = $this->input->post("ID");
        $G_UID = $this->input->post("G_UID");

        if (empty($ID)) {
            $G_UID = $this->generate_gradekey_id();
        } else {
            $existing = $this->db->where("ID", $ID)->get("tbl_studentgrades")->row();
            $G_UID = $existing ? $existing->G_UID : $this->generate_gradekey_id();
        }

        $student_ids = $this->input->post("G_STUDENTID");
        $fullnames   = $this->input->post("G_FULLNAME");
        $genders     = $this->input->post("G_GENDER");
        $grades      = $this->input->post("G_GRADE");
        $remarks     = $this->input->post("G_REMARKS");

        $schedid     = $this->validate_data($this->input->post("G_SCHEDID"));
        $classcode   = $this->validate_data($this->input->post("G_CLASSCODE"));
        $ay          = $this->validate_data($this->input->post("G_ACADEMICYEAR"));
        $sem         = $this->validate_data($this->input->post("G_SEMESTER"));
        $subject     = $this->validate_data($this->input->post("G_SUBJECT"));
        $year_level  = $this->validate_data($this->input->post("G_YEARLEVEL"));
        $section     = $this->validate_data($this->input->post("G_SECTION"));
        $status      = $this->validate_data($this->input->post("G_STATUS"));
        $encoder     = $this->session->userdata('fullname');
        $date_submitted = date('Y-m-d H:i:s');

        if (!empty($student_ids) && is_array($student_ids)) {
            foreach ($student_ids as $i => $student_id) {
                $data = [
                    "G_UID"            => $G_UID,
                    "G_STUDENTID"      => $this->validate_data($student_ids[$i]),
                    "G_FULLNAME"       => $this->validate_data($fullnames[$i]),
                    "G_GENDER"         => $this->validate_data($genders[$i]),
                    "G_GRADE"          => $grades[$i],
                    "G_REMARKS"        => $this->validate_data($remarks[$i]),
                    "G_SCHEDID"        => $schedid,
                    "G_CLASSCODE"      => $classcode,
                    "G_ACADEMICYEAR"   => $ay,
                    "G_SEMESTER"       => $sem,
                    "G_SUBJECT"        => $subject,
                    "G_YEARLEVEL"      => $year_level,
                    "G_SECTION"        => $section,
                    "G_STATUS"         => $status,
                    "G_ENCODERTEACHER" => $encoder,
                    "G_DATESUBMITTED"  => $date_submitted
                ];

                $existing = $this->db
                    ->where("G_SUBJECT", $subject)
                    ->where("G_STUDENTID", $student_ids[$i])
                    ->get("tbl_studentgrades")
                    ->row();

                if ($existing) {
                    $this->db
                        ->where("G_SUBJECT", $subject)
                        ->where("G_STUDENTID", $student_ids[$i])
                        ->update("tbl_studentgrades", $data);
                } else {
                    $this->db->insert("tbl_studentgrades", $data);
                }
            }

            $details = "Subject: " . $subject . " (" . count($student_ids) . " students, Section: " . $section . ")";
            log_audit("SAVED/UPDATED STUDENT GRADES", $details);

            $this->session->set_flashdata("success", $status === "SAVED"
                ? "All data have been saved."
                : "All data have been saved as draft.");
        }

        return isset($data) ? $data : [];
    }
}
