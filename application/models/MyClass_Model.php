<?php
#[AllowDynamicProperties]
class MyClass_Model extends CI_Model
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

    function LoadMyClass()
    {
        $result = "";
        $FILTER_PROGRAM = $this->input->post("FILTER_PROGRAM");
        $FILTER_MAJOR = $this->input->post("FILTER_MAJOR");
        $FILTER_YL = $this->input->post("FILTER_YL");
        $FILTER_AY = $this->input->post("FILTER_AY");
        $FILTER_SEM = $this->input->post("FILTER_SEM");

        $sql = "SELECT
                    *,
                    COALESCE(
                        (SELECT S_UNITS FROM tbl_subject WHERE S_SDESCRIPTION = tbl_scheduling.SC_SDESC AND S_SELECTPROG = tbl_scheduling.SC_PROG LIMIT 1),
                        (SELECT S_UNITS FROM tbl_subject WHERE S_SDESCRIPTION = tbl_scheduling.SC_SDESC LIMIT 1)
                    ) AS S_UNITS
                FROM
                    tbl_scheduling 
                WHERE SC_FACULTY ='" . $this->session->userdata('fullname') . "' 
                ";

        if (!empty($FILTER_PROGRAM)) {
            $sql .= " AND SC_PROG = '{$FILTER_PROGRAM}'";
        }
        if (!empty($FILTER_MAJOR)) {
            $sql .= " AND SC_MAJOR = '{$FILTER_MAJOR}'";
        }
        if (!empty($FILTER_YL)) {
            $sql .= " AND SC_YEARLEVEL = '{$FILTER_YL}'";
        }
        if (!empty($FILTER_AY)) {
            $sql .= " AND SC_ACADEMICYEAR = '{$FILTER_AY}'";
        }
        if (!empty($FILTER_SEM)) {
            $sql .= " AND SC_SEMESTER = '{$FILTER_SEM}'";
        }

        $query = $this->db->query($sql);
        $num = 0;
        $total_units = 0;

        // Process the results
        foreach ($query->result() as $r) {
            $num++;
            $major = ($r->SC_MAJOR == "") ? '' : '<small><b>(' . $r->SC_MAJOR . ')</b></small>';
            $units = is_numeric($r->S_UNITS) ? floatval($r->S_UNITS) : 0;
            $total_units += $units;

            $result .= '<tr>';
            $result .= '<td>' . $r->SC_SDESC . '</td>';
            $result .= '<td>' . $r->SC_PROG . ' ' . $major . '</td>';
            $result .= '<td>' . $r->SC_YEARLEVEL . '</td>';
            $result .= '<td>' . $r->SC_ACADEMICYEAR . '-' .  ($r->SC_ACADEMICYEAR + 1) . '</td>';
            $result .= '<td>' . $r->SC_SEMESTER . '</td>';
            $result .= '<td>' . $r->SC_STARTTIME . ' - ' . $r->SC_ENDTIME . '</td>';
            $result .= '<td>' . $r->SC_DAY . '</td>';
            $result .= '<td>' . $r->SC_ROOM . '</td>';
            $result .= '<td>' . $units . '</td>';
            $result .= '<td>
                            <a type="button" class="btn btn-xs btn-primary" href="' . base_url("ims/myclass/view/$r->ID") . '"><i class="ri-eye-line"> </i> View Class</a>
                        </td>';
            $result .= '</tr>';
        }

        $overload_units = ($total_units > 18) ? ($total_units - 18) : 0;

        return [
            'output' => $result,
            'total_units' => $total_units,
            'overload_units' => $overload_units
        ];
    }
}
