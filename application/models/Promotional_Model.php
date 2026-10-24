<?php
#[AllowDynamicProperties]
class Promotional_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function LoadEnrollment()
    {
        $filters = [
            'ER_PROGRAM' => $this->input->post("FILTER_PROGRAM"),
            'ER_MAJOR' => $this->input->post("FILTER_MAJOR"),
            'ER_YEARLEVEL' => $this->input->post("FILTER_YL"),
            'ER_ACADEMICYEAR' => $this->input->post("FILTER_AY"),
            'ER_SEMESTER' => $this->input->post("FILTER_SEM"),
        ];

        $sql = "SELECT
                s.SP_STUDID,
                s.SP_LASTNAME,
                s.SP_MIDDLENAME,
                s.SP_FIRSTNAME,
                s.SP_GENDER,
                s.SP_CPNUMBER,
                e.*
            FROM tbl_enrollment AS e
            LEFT JOIN tbl_studprof AS s ON e.ER_STUDENTID = s.SP_STUDID
            WHERE e.ER_STUDENTID != ''";

        foreach ($filters as $col => $val) {
            if (!empty($val)) $sql .= " AND e.$col = " . $this->db->escape($val);
        }

        $query = $this->db->query($sql);
        $result = '';

        foreach ($query->result() as $r) {
            $major = $r->ER_MAJOR ? "<small><b>({$r->ER_MAJOR})</b></small>" : '';

            if (is_null($r->ER_PROMOTIONALSTATUS) || $r->ER_PROMOTIONALSTATUS === '') {
                $status_badge = "<span class='badge rounded-pill bg-secondary'>NOT YET PROMOTED</span>";
            } elseif ($r->ER_PROMOTIONALSTATUS === "PROMOTED") {
                $status_badge = "<span class='badge rounded-pill bg-success'>PROMOTED</span>";
            } elseif ($r->ER_PROMOTIONALSTATUS === "UNPROMOTED") {
                $status_badge = "<span class='badge rounded-pill bg-danger'>UNPROMOTED</span>";
            } else {
                $status_badge = "<span class='badge rounded-pill bg-warning'>" . htmlspecialchars($r->ER_PROMOTIONALSTATUS) . "</span>";
            }

            $checkbox = "<input type='checkbox' class='form-check-input select-checkbox' value='{$r->ID}'>";

            $result .= "
            <tr>
                <td class='d-none'>{$r->ID}</td>
                <td><div class='form-check form-check-success'>{$checkbox}</div></td>
                <td>{$r->SP_STUDID}</td>
                <td>{$r->SP_LASTNAME}, {$r->SP_FIRSTNAME} {$r->SP_MIDDLENAME}</td>
                <td>{$r->SP_GENDER}</td>
                <td>{$r->ER_PROGRAM} {$major}</td>
                <td>{$r->ER_YEARLEVEL}</td>
                <td>{$r->ER_SEMESTER}</td>
                <td>{$status_badge}</td>
            </tr>";
        }
        return $result;
    }

    function updatePromotionStatus()
    {
        $ids = $this->input->post("ids");
        $status = $this->input->post("status");

        if (empty($ids) || empty($status)) {
            return false;
        }

        if (is_string($ids)) {
            $ids = explode(',', $ids);
        }

        foreach ($ids as $id) {
            $this->db->where('ID', $id);
            $this->db->update('tbl_enrollment', ['ER_PROMOTIONALSTATUS' => $status]);
        }

        $details = "Status: " . $status . " (" . count($ids) . " records updated)";
        log_audit("UPDATED PROMOTIONAL STATUS", $details);
        return true;
    }
}
