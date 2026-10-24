<?php
#[AllowDynamicProperties]
class Graduates_Model extends CI_Model
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
    function check_permission()
    {
        if (in_array(strtolower(trim($this->session->userdata("usertype") ?? '')), ["administrator", "superadmin", "super admin", "admin"])) {
            return ['View', 'Edit', 'Delete', 'Create'];
        }

        $permission = [];
        $query = $this->db->where([
            "USER_ID" => $this->session->userdata("id"),
            "PAGE" => "Graduate"
        ])->get("tbl_permissions");

        foreach ($query->result() as $row) {
            $actions = array_map('trim', explode(',', $row->ACTIONS));
            $permission = array_merge($permission, $actions);
        }

        return array_unique($permission); // avoid duplicate actions
    }

    function LoadEnrollment()
    {
        $permissions = $this->check_permission();
        $is_admin    = in_array(strtolower(trim($this->session->userdata("usertype") ?? '')), ["administrator", "superadmin", "super admin", "admin"]);

        $filters = [
            'ER_PROGRAM'      => $this->input->post("FILTER_PROGRAM"),
            'ER_MAJOR'        => $this->input->post("FILTER_MAJOR"),
            'ER_ACADEMICYEAR' => $this->input->post("FILTER_AY")
        ];

        $sql = "SELECT
                s.SP_STUDID,
                s.SP_LASTNAME,
                s.SP_MIDDLENAME,
                s.SP_FIRSTNAME,
                s.SP_GENDER,
                s.SP_CPNUMBER,
                e.*,
                g.G_REQUIREMENTS,
                g.G_STATUS,
                g.G_REMARKS
            FROM tbl_enrollment AS e
            LEFT JOIN tbl_studprof AS s ON e.ER_STUDENTID = s.SP_STUDID
            LEFT JOIN tbl_graduates AS g ON e.ER_STUDENTID = g.G_STUDENTID
            WHERE e.ER_STUDENTID != ''";

        foreach ($filters as $col => $val) {
            if (!empty($val)) {
                $sql .= " AND e.$col = " . $this->db->escape($val);
            }
        }

        $query  = $this->db->query($sql);
        $result = '';

        foreach ($query->result() as $r) {
            // Only include 3RD YEAR - 3RD TRIMESTER
            if ($r->ER_YEARLEVEL == '1ST YEAR' && $r->ER_SEMESTER == '1ST SEMESTER') {
                $major   = $r->ER_MAJOR ? "<small><b>({$r->ER_MAJOR})</b></small>" : '';

                // ✅ Escape remarks safely
                $remarks = !empty($r->G_REMARKS) ? htmlspecialchars((string) $r->G_REMARKS) : '';

                // ✅ Normalize G_STATUS (avoid null)
                $g_status = strtoupper((string) $r->G_STATUS);

                // ✅ Status badge
                if (empty($r->G_STATUS)) {
                    $status_badge = "<span class='badge rounded-pill bg-danger'>NOT YET VALIDATED</span>";
                } elseif ($g_status === "VALIDATED") {
                    $status_badge = "<span class='badge rounded-pill bg-success'>VALIDATED</span>";
                } elseif ($g_status === "NOT VALIDATED") {
                    $status_badge = "<span class='badge rounded-pill bg-danger'>NOT VALIDATED</span>";
                } else {
                    $status_badge = "<span class='badge rounded-pill bg-warning'>" . htmlspecialchars((string) $r->G_STATUS) . "</span>";
                }

                // ✅ Button depending on validation
                if ($g_status === "VALIDATED") {
                    $button = '<button 
                    class="btn btn-secondary btn-validation" 
                    type="button" disabled
                    data-id="' . $r->ER_STUDENTID . '"
                    data-yearlevel="' . $r->ER_YEARLEVEL . '"
                    data-academicterm="' . $r->ER_SEMESTER . '"
                    data-academicyear="' . $r->ER_ACADEMICYEAR . '"
                    data-studentnumber="' . $r->SP_STUDID . '"
                    data-studenttype="' . $r->ER_STATUS . '"
                    data-status="' . $r->ER_ENSTATUS . '"
                    data-fullname="' . $r->SP_LASTNAME . ', ' . $r->SP_FIRSTNAME . ' ' . $r->SP_MIDDLENAME . '"
                    data-sex="' . $r->SP_GENDER . '"
                    data-programmajor="' . $r->ER_PROGRAM . ($r->ER_MAJOR ? ' (' . $r->ER_MAJOR . ')' : '') . '"
                    data-contactnumber="' . $r->SP_CPNUMBER . '"
                    data-gstatus="' . htmlspecialchars((string) $r->G_STATUS) . '"
                    data-remarks="' . $remarks . '"
                    data-requirements="' . htmlspecialchars((string) $r->G_REQUIREMENTS) . '"
                ><i class="ri-check-line me-1"></i> Already Validated</button>';
                } else {
                    $button = '<button 
                    class="btn btn-warning btn-validation" 
                    type="button"
                    data-id="' . $r->ER_STUDENTID . '"
                    data-yearlevel="' . $r->ER_YEARLEVEL . '"
                    data-academicterm="' . $r->ER_SEMESTER . '"
                    data-academicyear="' . $r->ER_ACADEMICYEAR . '"
                    data-studentnumber="' . $r->SP_STUDID . '"
                    data-studenttype="' . $r->ER_STATUS . '"
                    data-status="' . $r->ER_ENSTATUS . '"
                    data-fullname="' . $r->SP_LASTNAME . ', ' . $r->SP_FIRSTNAME . ' ' . $r->SP_MIDDLENAME . '"
                    data-sex="' . $r->SP_GENDER . '"
                    data-programmajor="' . $r->ER_PROGRAM . ($r->ER_MAJOR ? ' (' . $r->ER_MAJOR . ')' : '') . '"
                    data-contactnumber="' . $r->SP_CPNUMBER . '"
                    data-gstatus="' . htmlspecialchars((string) $r->G_STATUS) . '"
                    data-remarks="' . $remarks . '"
                    data-requirements="' . htmlspecialchars((string) $r->G_REQUIREMENTS) . '"
                ><i class="ri-check-line me-1"></i> Validate</button>';
                }

                // ✅ Match exactly with <thead> (10 columns)
                $result .= "<tr>
                <td>{$r->SP_STUDID}</td>
                <td>{$r->SP_LASTNAME}, {$r->SP_FIRSTNAME} {$r->SP_MIDDLENAME}</td>
                <td>{$r->SP_CPNUMBER}</td>
                <td>{$r->SP_GENDER}</td>
                <td>{$r->ER_PROGRAM} {$major}</td>
                <td>{$r->ER_YEARLEVEL}</td>
                <td>{$r->ER_SEMESTER}</td>
                <td class='status-col'>{$status_badge}</td>
                <td class='remarks-col'>{$remarks}</td>
                <td class='action-col'>{$button}</td>
            </tr>";
            }
        }

        return $result;
    }



    function LoadStudentEnrolled()
    {
        $sql = "SELECT
        s.SP_LASTNAME,
        s.SP_MIDDLENAME,
        s.SP_FIRSTNAME,
        s.SP_GENDER,
        s.SP_CPNUMBER,
        s.SP_CIVILSTATUS,
        s.SP_BIRTHDAY,
        s.SP_STRT,
        r.regDesc,
        p.provDesc,
        c.citymunDesc,
        b.brgyDesc,
        pm.P_PCODE,
        e.*
    FROM
        tbl_enrollment AS e
    LEFT JOIN
        tbl_studprof AS s ON e.ER_STUDENTID = s.SP_STUDID
    LEFT JOIN
        refregion AS r ON s.SP_REGION = r.regCode
    LEFT JOIN
        refprovince AS p ON s.SP_PROVINCE = p.provCode
    LEFT JOIN
        refcitymun AS c ON s.SP_MUNICIPALITY = c.citymunCode
    LEFT JOIN
        refbrgy AS b ON s.SP_BRGY = b.brgyCode
    LEFT JOIN 
        tbl_program as pm ON e.ER_PROGRAM = pm.P_PDESCRIPTIONS AND e.ER_MAJOR = pm.P_MAJOR
        
        
    WHERE e.ER_STUDENTID !='' AND e.ID = {$this->uri->segment(4)}";
        $query = $this->db->query($sql);
        return $query;
    }
    public function saveGraduateValidation()
    {
        $studentId    = $this->input->post('G_STUDENTID');
        $requirements = $this->input->post('G_REQUIREMENTS'); // already comma separated
        $status       = $this->input->post('G_STATUS');
        $remarks      = $this->input->post('G_REMARKS');

        // Basic validation
        if (empty($studentId) || empty($requirements) || empty($status)) {
            echo json_encode([
                'output'  => 'error',
                'message' => 'Missing required fields.'
            ]);
            exit;
        }

        $data = [
            'G_STUDENTID'    => $studentId,
            'G_REQUIREMENTS' => $requirements,
            'G_STATUS'       => $status,
            'G_REMARKS'      => $remarks
        ];

        $this->db->trans_start();

        $exists = $this->db->where('G_STUDENTID', $studentId)
            ->get('tbl_graduates')
            ->num_rows();

        if ($exists > 0) {
            $this->db->where('G_STUDENTID', $studentId)
                ->update('tbl_graduates', $data);
            log_audit("UPDATED GRADUATE STATUS", "Student ID: " . $studentId . ", Status: " . $status);
        } else {
            $this->db->insert('tbl_graduates', $data);
            log_audit("SAVED GRADUATE STATUS", "Student ID: " . $studentId . ", Status: " . $status);
        }

        $this->db->where('ER_STUDENTID', $studentId)
            ->update('tbl_enrollment', ['ER_GRADUATESTATUS' => $status]);

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            echo json_encode([
                'output'  => 'error',
                'message' => 'Database error while saving.'
            ]);
            exit;
        }

        // return success + new csrf hash
        echo json_encode([
            'output'  => 'success',
            'message' => 'Validation saved successfully.',
            'token'   => $this->security->get_csrf_hash()
        ]);
        exit;
    }
    private function getLogsData()
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "AT_DATE" => date('F j, Y / H:i:s'),
            "AT_NAME" => $this->session->userdata('fullname'),
            "AT_ACTION" => "SAVED NEW GRADUATE RECORD"
        ];
        return $data;
    }

    private function getLogsUpdate()
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "AT_DATE" => date('F j, Y / H:i:s'),
            "AT_NAME" => $this->session->userdata('fullname'),
            "AT_ACTION" => "UPDATED GRADUATE RECORD"
        ];
        return $data;
    }
}
