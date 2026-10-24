<?php
#[AllowDynamicProperties]
class FinDas_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }




    function query_enrolled_students($FTR_YL, $FTR_SEM, $FTR_PROGRAM, $FTR_AY)
    {

        // ----------- TOTAL ENROLLED STUDENTS ----------
        $sql_enrolled = "SELECT COUNT(*) AS total_enrolled_students 
                     FROM tbl_enrollment e
                     WHERE 1=1";
        $params_enrolled = [];
        if (!empty($FTR_YL)) {
            $sql_enrolled .= " AND e.ER_YEARLEVEL = ?";
            $params_enrolled[] = $FTR_YL;
        }
        if (!empty($FTR_SEM)) {
            $sql_enrolled .= " AND e.ER_SEMESTER = ?";
            $params_enrolled[] = $FTR_SEM;
        }
        if (!empty($FTR_PROGRAM)) {
            $sql_enrolled .= " AND e.ER_PROGRAM = ?";
            $params_enrolled[] = $FTR_PROGRAM;
        }
        if (!empty($FTR_AY)) {
            $sql_enrolled .= " AND e.ER_ACADEMICYEAR = ?";
            $params_enrolled[] = substr($FTR_AY, 0, 4); // Only starting year
        }
        $total_enrolled_students = $this->db
            ->query($sql_enrolled, $params_enrolled)
            ->row("total_enrolled_students") ?? "0";

        return $total_enrolled_students;
    }

    function query_amount_billed($FTR_PROGRAM, $FTR_SEM, $FTR_YL)
    {
        // --------------- TOTAL AMOUNT BILLED -----------------------------------
        $filter_conditions = "";
        $params = [];

        if (!empty($FTR_PROGRAM)) {
            $filter_conditions .= " AND FEES_PROGRAM = ?";
            $params[] = $FTR_PROGRAM;
        }
        if (!empty($FTR_SEM)) {
            $filter_conditions .= " AND FEES_SEMESTER = ?";
            $params[] = $FTR_SEM;
        }
        if (!empty($FTR_YL)) {
            $filter_conditions .= " AND FEES_YEARLEVEL = ?";
            $params[] = $FTR_YL;
        }

        // Final query with subqueries
        $sql_billed = "SELECT FORMAT(
                IFNULL(t.total_tuition, 0) + IFNULL(o.total_other_fees, 0) + IFNULL(m.total_misc_fees, 0),
                2
            ) AS total_amount_billed
            FROM
                (
                    SELECT SUM(REPLACE(FEES_TOTALTUITION, ',', '')) AS total_tuition
                    FROM tbl_fees_tuitions
                    WHERE 1=1 $filter_conditions
                ) AS t
            LEFT JOIN
                (
                    SELECT SUM(REPLACE(FO.FEES_OTHER_AMOUNT, ',', '')) AS total_other_fees
                    FROM tbl_fees_otherfees FO
                    WHERE FO.FEES_TUITION_ID IN (
                        SELECT FEES_KEY FROM tbl_fees_tuitions WHERE 1=1 $filter_conditions
                    )
                ) AS o ON 1=1
            LEFT JOIN
                (
                    SELECT SUM(REPLACE(FM.FEES_MISC_AMOUNT, ',', '')) AS total_misc_fees
                    FROM tbl_fees_miscellaneous FM
                    WHERE FM.FEES_TUITION_ID IN (
                        SELECT FEES_KEY FROM tbl_fees_tuitions WHERE 1=1 $filter_conditions
                    )
                ) AS m ON 1=1";
        // Triple the parameters because filters are reused in all subqueries
        $final_params = array_merge($params, $params, $params);

        $total_amount_billed = $this->db
            ->query($sql_billed, $final_params)
            ->row("total_amount_billed") ?? "0.00";

        return $total_amount_billed;
    }

    function query_payments_received($FTR_PROGRAM, $FTR_SEM, $FTR_YL)
    {
        // ---------- TOTAL PAYMENTS RECEIVED ----------
        $sql_payments = "SELECT FORMAT(SUM(REPLACE(p.P_AMOUNT, ',', '')), 2) AS total_payments_received
                     FROM tbl_enrollment e
                     LEFT JOIN tbl_payment p ON e.ER_TRANSNO = p.ER_TRANSNO
                     WHERE 1=1";
        $params_payments = [];

        if (!empty($FTR_YL)) {
            $sql_payments .= " AND e.ER_YEARLEVEL = ?";
            $params_payments[] = $FTR_YL;
        }
        if (!empty($FTR_SEM)) {
            $sql_payments .= " AND e.ER_SEMESTER = ?";
            $params_payments[] = $FTR_SEM;
        }
        if (!empty($FTR_PROGRAM)) {
            $sql_payments .= " AND e.ER_PROGRAM = ?";
            $params_payments[] = $FTR_PROGRAM;
        }
        if (!empty($FTR_AY)) {
            $sql_payments .= " AND e.ER_ACADEMICYEAR = ?";
            $params_payments[] = substr($FTR_AY, 0, 4); // Only starting year
        }

        $total_payments_received = $this->db
            ->query($sql_payments, $params_payments)
            ->row("total_payments_received") ?? "0.00";

        return $total_payments_received;
    }

    function query_discount_voucher($FTR_YL, $FTR_SEM, $FTR_PROGRAM, $FTR_AY)
    {
        // ---------- TOTAL DISCOUNT ---------- //
        $sql_discount = "SELECT 
                     SUM(REPLACE(d.D_AMOUNT,',','')) AS total_discount_voucher
                     FROM tbl_enrollment e
                     LEFT JOIN tbl_payment p ON e.ER_TRANSNO = p.ER_TRANSNO
                     LEFT JOIN tbl_payment_discount d ON d.P_VOUCHERNO = p.P_VOUCHERNO
                     WHERE 1=1";
        $params_discount = [];

        if (!empty($FTR_YL)) {
            $sql_discount .= " AND e.ER_YEARLEVEL = ?";
            $params_discount[] = $FTR_YL;
        }
        if (!empty($FTR_SEM)) {
            $sql_discount .= " AND e.ER_SEMESTER = ?";
            $params_discount[] = $FTR_SEM;
        }
        if (!empty($FTR_PROGRAM)) {
            $sql_discount .= " AND e.ER_PROGRAM = ?";
            $params_discount[] = $FTR_PROGRAM;
        }
        if (!empty($FTR_AY)) {
            $sql_discount .= " AND e.ER_ACADEMICYEAR = ?";
            $params_discount[] = substr($FTR_AY, 0, 4); // Only starting year
        }

        $total_discount_voucher = $this->db
            ->query($sql_discount, $params_discount)
            ->row("total_discount_voucher") ?? "0.00";

        return $total_discount_voucher;
    }

    function FilterDashboardHeader()
    {
        $FTR_AY = $this->input->post("FTR_AY");
        $FTR_YL = $this->input->post("FTR_YL");
        $FTR_SEM = $this->input->post("FTR_SEM");
        $FTR_PROGRAM = $this->input->post("FTR_PROGRAM");

        // get the enrollment fee
        $IMS_WEB_ENROLLMENT_FEE = $this->db->get("tbl_websettings")->row("IMS_WEB_ENROLLMENT_FEE")  ?? "0.00";

        // load the enrolled students
        $total_enrolled_students = $this->query_enrolled_students($FTR_YL, $FTR_SEM, $FTR_PROGRAM, $FTR_AY);

        // load the total amount billed
        $total_amount_billed = $this->query_amount_billed($FTR_PROGRAM, $FTR_SEM, $FTR_YL);

        // load the total payments received
        $total_payments_received = $this->query_payments_received($FTR_PROGRAM, $FTR_SEM, $FTR_YL);

        // load the total discount voucher
        $total_discount_voucher = $this->query_discount_voucher($FTR_YL, $FTR_SEM, $FTR_PROGRAM, $FTR_AY);



        // get sub-total
        $sub_total_enrollment_fee = str_replace(',', '', $IMS_WEB_ENROLLMENT_FEE) * $total_enrolled_students; // ex. 2 x 2,000 = 4,000.00


        $sub_total_amount_billed = str_replace(',', '', $total_amount_billed) + $sub_total_enrollment_fee; // ex.  9,120 + 4,000.00 = 13,120.00


        // ---------- NUMBER OF PAID AND WITH BALANCE STUDENTS ----------
        $sql_fully_paid = "SELECT 
        COUNT(CASE 
            WHEN e.ER_PAYMENTSTATUS = 'UNPAID' OR e.ER_PAYMENTSTATUS = 'INSTALLMENT' 
            THEN 1 
        END) AS total_with_balance_students,

        COUNT(CASE 
            WHEN e.ER_PAYMENTSTATUS = 'PAID' 
            THEN 1 
        END) AS total_paid_students
        FROM tbl_enrollment e
        WHERE 1=1";

        $params_fully_paid = [];

        if (!empty($FTR_YL)) {
            $sql_fully_paid .= " AND e.ER_YEARLEVEL = ?";
            $params_fully_paid[] = $FTR_YL;
        }
        if (!empty($FTR_SEM)) {
            $sql_fully_paid .= " AND e.ER_SEMESTER = ?";
            $params_fully_paid[] = $FTR_SEM;
        }
        if (!empty($FTR_PROGRAM)) {
            $sql_fully_paid .= " AND e.ER_PROGRAM = ?";
            $params_fully_paid[] = $FTR_PROGRAM;
        }
        if (!empty($FTR_AY)) {
            $sql_fully_paid .= " AND e.ER_ACADEMICYEAR = ?";
            $params_fully_paid[] = substr($FTR_AY, 0, 4); // Only starting year
        }

        $result = $this->db->query($sql_fully_paid, $params_fully_paid)->row_array();

        // Assign to variables
        $total_paid_students = $result['total_paid_students'] ?? 0;
        $total_with_balance_students = $result['total_with_balance_students'] ?? 0;

        // ---------- RETURN FINAL RESULT ----------
        return [
            'total_amount_billed' => number_format(($sub_total_amount_billed * $total_enrolled_students) - $sub_total_enrollment_fee, 2),
            'total_payments_received' => $total_payments_received,
            'total_enrolled_students' => $total_enrolled_students,
            'total_paid_students' => $total_paid_students,
            'total_with_balance_students' => $total_with_balance_students,
            'total_discount_voucher' => $total_discount_voucher
        ];
    }





    public function chart_billing_breakdown($FTR_YL = null, $FTR_SEM = null, $FTR_PROGRAM = null, $FTR_AY = null)
    {
        $sql = "SELECT 
        COUNT(CASE WHEN e.ER_PAYMENTSTATUS = 'UNPAID' THEN 1 END) AS total_unpaid_students,
        COUNT(CASE WHEN e.ER_PAYMENTSTATUS = 'INSTALLMENT' THEN 1 END) AS total_installment_students,
        COUNT(CASE WHEN e.ER_PAYMENTSTATUS = 'PAID' THEN 1 END) AS total_paid_students
        FROM tbl_enrollment e
        WHERE 1=1";

        $params = [];

        if (!empty($FTR_YL)) {
            $sql .= " AND e.ER_YEARLEVEL = ?";
            $params[] = $FTR_YL;
        }
        if (!empty($FTR_SEM)) {
            $sql .= " AND e.ER_SEMESTER = ?";
            $params[] = $FTR_SEM;
        }
        if (!empty($FTR_PROGRAM)) {
            $sql .= " AND e.ER_PROGRAM = ?";
            $params[] = $FTR_PROGRAM;
        }
        if (!empty($FTR_AY)) {
            $sql .= " AND e.ER_ACADEMICYEAR = ?";
            $params[] = substr($FTR_AY, 0, 4);
        }

        return $this->db->query($sql, $params)->row_array();
    }


    public function fee_collection_program()
    {
        $FTR_AY = $this->input->post("FTR_AY");
        $FTR_YL = $this->input->post("FTR_YL");
        $FTR_SEM = $this->input->post("FTR_SEM");
        $FTR_PROGRAM = $this->input->post("FTR_PROGRAM");

        $params = [];
        $result = "";

        $sql = "SELECT 
                p.P_PDESCRIPTIONS, 
                SUM(REPLACE(pm.P_AMOUNT, ',', '')) AS total_amount_program
            FROM
                tbl_program p
            LEFT JOIN tbl_enrollment e ON p.P_PDESCRIPTIONS = e.ER_PROGRAM AND p.P_MAJOR = e.ER_MAJOR
            LEFT JOIN tbl_payment pm ON pm.ER_TRANSNO = e.ER_TRANSNO
            WHERE 1=1";

        if (!empty($FTR_YL)) {
            $sql .= " AND e.ER_YEARLEVEL = ?";
            $params[] = $FTR_YL;
        }
        if (!empty($FTR_SEM)) {
            $sql .= " AND e.ER_SEMESTER = ?";
            $params[] = $FTR_SEM;
        }
        if (!empty($FTR_PROGRAM)) {
            $sql .= " AND p.P_PDESCRIPTIONS = ?";
            $params[] = $FTR_PROGRAM;
        }
        if (!empty($FTR_AY)) {
            $sql .= " AND e.ER_ACADEMICYEAR = ?";
            $params[] = substr($FTR_AY, 0, 4);
        }

        // Fix for ONLY_FULL_GROUP_BY
        $sql .= " GROUP BY p.P_PDESCRIPTIONS";

        $query = $this->db->query($sql, $params);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $r) {
                $amount = ($r->total_amount_program == 0) ? 0 : number_format($r->total_amount_program, 2);
                $result .= '
            <div class="d-flex justify-content-between">
                <div class="d-flex align-items-center mb-4">
                    <div>
                        <div class="d-flex align-items-center gap-1 mb-1">
                            <i class="ri-checkbox-blank-circle-fill ri-12px text-success"></i>
                            <h6 class="mb-0">' . htmlspecialchars($r->P_PDESCRIPTIONS) . '</h6>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <h6 class="mb-1 fw-bold">₱' . $amount . '</h6>
                </div>
            </div>';
            }
        } else {
            $result = "<p>No result found</p>";
        }

        return $result;
    }
    public function recent_transactions()
    {
        $FTR_AY = $this->input->post("FTR_AY");
        $FTR_YL = $this->input->post("FTR_YL");
        $FTR_SEM = $this->input->post("FTR_SEM");
        $FTR_PROGRAM = $this->input->post("FTR_PROGRAM");

        $params = [];
        $result = "";

        $sql = "SELECT 
                pm.ID,
                pm.P_ENCODER,
                s.SP_FIRSTNAME,
                s.SP_MIDDLENAME,
                s.SP_LASTNAME,
                pm.P_AMOUNT,
                pm.OR_NUM,
                pm.P_DATESUBMITTED
            FROM tbl_payment pm
            LEFT JOIN tbl_enrollment e ON pm.ER_TRANSNO = e.ER_TRANSNO 
            LEFT JOIN tbl_studprof s ON s.SP_STUDID = e.ER_STUDENTID
            WHERE 1=1";

        if (!empty($FTR_YL)) {
            $sql .= " AND e.ER_YEARLEVEL = ?";
            $params[] = $FTR_YL;
        }
        if (!empty($FTR_SEM)) {
            $sql .= " AND e.ER_SEMESTER = ?";
            $params[] = $FTR_SEM;
        }
        if (!empty($FTR_PROGRAM)) {
            $sql .= " AND e.ER_PROGRAM = ?";
            $params[] = $FTR_PROGRAM;
        }
        if (!empty($FTR_AY)) {
            $sql .= " AND e.ER_ACADEMICYEAR = ?";
            $params[] = substr($FTR_AY, 0, 4);
        }

        $sql .= " ORDER BY pm.ID DESC LIMIT 50";

        $query = $this->db->query($sql, $params);

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $r) {
                $fullname = htmlspecialchars($r->SP_FIRSTNAME . ' ' .
                    ($r->SP_MIDDLENAME ? $r->SP_MIDDLENAME[0] . '. ' : '') .
                    $r->SP_LASTNAME);

                $amount = $r->P_AMOUNT;
                $result .= '
                <tr>
                    <td class="d-none">' . htmlspecialchars($r->ID) . '</td>
                    <td>' . $fullname . '</td>
                    <td>' . htmlspecialchars($r->OR_NUM) . '</td>
                    <td>' . $amount . '</td>
                    <td>' . date('F j, Y g:ia', strtotime($r->P_DATESUBMITTED)) . '</td>
                    <td>' . htmlspecialchars($r->P_ENCODER) . '</td>
                </tr>';
            }
        }

        return $result;
    }


    public function chart_voucher_breakdown()
    {
        $FTR_AY = $this->input->post("FTR_AY");
        $FTR_YL = $this->input->post("FTR_YL");
        $FTR_SEM = $this->input->post("FTR_SEM");
        $FTR_PROGRAM = $this->input->post("FTR_PROGRAM");

        $params = [];

        $sql = "SELECT 
                d.D_DESC, 
                COUNT(e.ER_STUDENTID) AS total_student_availed,
                SUM(REPLACE(d.D_AMOUNT, ',', '')) AS total_discount
            FROM tbl_payment_discount d
            LEFT JOIN tbl_enrollment e ON d.ER_TRANSNO = e.ER_TRANSNO 
            WHERE 1=1";

        if (!empty($FTR_YL)) {
            $sql .= " AND e.ER_YEARLEVEL = ?";
            $params[] = $FTR_YL;
        }
        if (!empty($FTR_SEM)) {
            $sql .= " AND e.ER_SEMESTER = ?";
            $params[] = $FTR_SEM;
        }
        if (!empty($FTR_PROGRAM)) {
            $sql .= " AND e.ER_PROGRAM = ?";
            $params[] = $FTR_PROGRAM;
        }
        if (!empty($FTR_AY)) {
            $sql .= " AND e.ER_ACADEMICYEAR = ?";
            $params[] = substr($FTR_AY, 0, 4);
        }

        $sql .= " GROUP BY d.D_DESC";

        $query = $this->db->query($sql, $params);
        return $query->result_array(); // return array for controller to use
    }
}
