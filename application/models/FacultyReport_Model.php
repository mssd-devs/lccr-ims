<?php
#[AllowDynamicProperties]
class FacultyReport_Model extends CI_Model
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
    function LoadFacultyProfile()
    {
        $query = $this->db->query("SELECT * FROM tbl_facprof ORDER BY id DESC");
        return $query;
    }

    function LoadEmployee()
    {

        $filters = [
            'FP_TENURE' => $this->input->post("FILTER_TENURE"),
            'FP_EMPLOYEETYPE' => $this->input->post("FILTER_EMPLOYEE_TYPE"),
        ];

        $sql = "SELECT
                *
            FROM tbl_facprof
            WHERE 1=1";

        foreach ($filters as $col => $val) {
            if (!empty($val)) $sql .= " AND $col = " . $this->db->escape($val);
        }

        $query = $this->db->query($sql);
        $result = '';

        foreach ($query->result() as $r) {

            // Determine promotional status badge
            if (is_null($r->FP_EMPLOYEETYPE) || $r->FP_EMPLOYEETYPE === '') {
                $status_badge = "<span class='badge rounded-pill bg-primary>NON-TEACHING</span>";
            } elseif ($r->FP_EMPLOYEETYPE === "TEACHING") {
                $status_badge = "<span class='badge rounded-pill bg-success'>TEACHING</span>";
            } else {
                // Optional: fallback for other unexpected values
                $status_badge = "<span class='badge rounded-pill bg-warning'>" . htmlspecialchars($r->FP_EMPLOYEETYPE) . "</span>";
            }

            // Add checkbox for each row, value is the ID
            $checkbox = "<input type='checkbox' class='form-check-input select-checkbox' value='{$r->ID}'>";

            $result .= "
            <tr>
                <td>{$r->FP_FACID}</td>
                <td>{$r->FP_LASTNAME}, {$r->FP_FIRSTNAME} {$r->FP_MIDDLENAME}</td>
                <td>{$r->FP_GENDER}</td>
                <td>{$r->FP_FACRANK}</td>
                <td>{$r->FP_TENURE}</td>
                <td>{$status_badge}</td>
            </tr>";
        }
        return $result;
    }
}
