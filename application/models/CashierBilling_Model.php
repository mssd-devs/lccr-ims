<?php
class CashierBilling_Model extends CI_Model
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

    function LoadPayments()
    {
        $query = $this->db->query("SELECT * FROM tbl_payment WHERE OR_NUM = '{$this->uri->segment(5)}'");
        return $query;
    }


    function load_soa_payments()
    {
        $query = $this->db->query("SELECT * FROM tbl_payment WHERE ER_TRANSNO = '{$this->uri->segment(5)}'");
        return $query;
    }

    function load_soa_fees() // this is for soa
    {
        $ID = $this->uri->segment(4);
        $ER_TRANSNO = $this->uri->segment(5);

        $query = $this->db->query("SELECT
            f.FEES_KEY,
            e.ER_TRANSNO,
            f.FEES_TOTALTUITION AS totalTuition,

            (SELECT COALESCE(SUM(REPLACE(mf.FEES_MISC_AMOUNT, ',', '')), 0)
             FROM tbl_fees_miscellaneous mf
             WHERE mf.FEES_TUITION_ID = f.FEES_KEY) AS totalMisc,

            (SELECT COALESCE(SUM(REPLACE(otf.FEES_OTHER_AMOUNT, ',', '')), 0) 
             FROM tbl_fees_otherfees otf
             WHERE otf.FEES_TUITION_ID = f.FEES_KEY) AS totalOther

            -- (SELECT COALESCE(SUM(REPLACE(p.P_AMOUNT, ',', '')), 0)
            --  FROM tbl_payment p 
            --  WHERE p.ER_TRANSNO = e.ER_TRANSNO) AS totalPayment,

            -- (SELECT COALESCE(SUM(REPLACE(d.D_AMOUNT, ',', '')), 0) 
            --  FROM tbl_payment_discount d 
            --  WHERE d.ER_TRANSNO = e.ER_TRANSNO) AS totalDiscount

            FROM tbl_enrollment e
            LEFT JOIN tbl_fees_tuitions f 
            ON e.ER_PROGRAM = f.FEES_PROGRAM 
            AND e.ER_MAJOR = f.FEES_MAJOR 
            AND e.ER_YEARLEVEL = f.FEES_YEARLEVEL 
            AND e.ER_SEMESTER = f.FEES_SEMESTER
            WHERE e.ID = ? AND e.ER_TRANSNO = ?
            GROUP BY 
            e.ER_TRANSNO, 
            f.FEES_KEY, 
            f.FEES_TOTALTUITION", [$ID, $ER_TRANSNO])->row();

        return $query;
    }

    function LoadTuitionsAndFees()
    {

        $query = $this->db->query("SELECT DISTINCT * FROM tbl_fees_tuitions");
        return $query;
    }

    function load_accountpayable($student_id, $transno)
    {
        $total_account_payable = 0;

        // Get all enrollments for this student excluding the current transaction and which are not PAID
        $this->db->where("ER_STUDENTID", $student_id);
        $this->db->where("ER_TRANSNO !=", $transno);
        $this->db->where_in("ER_PAYMENTSTATUS", ["UNPAID", "INSTALLMENT"]);
        $get_enrollments = $this->db->get("tbl_enrollment");

        foreach ($get_enrollments->result() as $enrollment) {
            $FEES_AMOUNTPERUNIT = 0;
            $ER_TRANSNO = $enrollment->ER_TRANSNO;

            // Compute Tuition Fee based on subjects
            if (!empty($enrollment->ER_SUBJECTS)) {
                $subject_ids = array_map('intval', explode(',', $enrollment->ER_SUBJECTS));
                $subject_ids_str = implode(',', $subject_ids);

                $get_subjects = $this->db->query("SELECT * FROM tbl_subject WHERE ID IN($subject_ids_str)");
                foreach ($get_subjects->result() as $s) {
                    $get_fees = $this->db->query(
                        "SELECT FEES_AMOUNTPERUNIT FROM tbl_fees_tuitions WHERE FEES_PROGRAM = ? AND FEES_MAJOR = ? AND FEES_YEARLEVEL = ? AND FEES_SEMESTER = ? LIMIT 1",
                        [$s->S_SELECTPROG, $s->S_MAJOR, $s->S_YRLVL, $s->S_SEM]
                    );
                    if ($get_fees->num_rows() > 0) {
                        $fee = $get_fees->row();
                        $unit_rate = floatval(str_replace(',', '', $fee->FEES_AMOUNTPERUNIT));
                        $FEES_AMOUNTPERUNIT += $unit_rate * floatval($s->S_UNITS);
                    }
                }
            }

            // Get total fees and payments for this specific enrollment
            $query = $this->db->query("SELECT 
                f.FEES_TOTALTUITION AS totalTuition,
                (SELECT COALESCE(SUM(REPLACE(mf.FEES_MISC_AMOUNT, ',', '')), 0) 
                 FROM tbl_fees_miscellaneous mf 
                 WHERE mf.FEES_TUITION_ID = f.FEES_KEY) AS totalMisc,
                (SELECT COALESCE(SUM(REPLACE(otf.FEES_OTHER_AMOUNT, ',', '')), 0) 
                 FROM tbl_fees_otherfees otf 
                 WHERE otf.FEES_TUITION_ID = f.FEES_KEY) AS totalOther,
                (SELECT COALESCE(SUM(REPLACE(p.P_AMOUNT, ',', '')), 0) 
                 FROM tbl_payment p 
                 WHERE p.ER_TRANSNO = e.ER_TRANSNO) AS totalPayment,
                (SELECT COALESCE(SUM(REPLACE(d.D_AMOUNT, ',', '')), 0) 
                 FROM tbl_payment_discount d 
                 WHERE d.ER_TRANSNO = e.ER_TRANSNO) AS totalDiscount
            FROM tbl_enrollment e
            LEFT JOIN tbl_fees_tuitions f 
                ON e.ER_PROGRAM = f.FEES_PROGRAM 
                AND e.ER_MAJOR = f.FEES_MAJOR 
                AND e.ER_YEARLEVEL = f.FEES_YEARLEVEL 
                AND e.ER_SEMESTER = f.FEES_SEMESTER
            WHERE e.ER_TRANSNO = ?
            LIMIT 1", [$ER_TRANSNO])->row();

            $total_tuition = $FEES_AMOUNTPERUNIT;
            $total_miscellaneous = isset($query->totalMisc) ? floatval($query->totalMisc) : 0;
            $total_other_fee = isset($query->totalOther) ? floatval($query->totalOther) : 0;
            $total_payment = isset($query->totalPayment) ? floatval($query->totalPayment) : 0;
            $total_discount = isset($query->totalDiscount) ? floatval($query->totalDiscount) : 0;

            $partial_enrollment_fee = $this->db->get("tbl_websettings")->row("IMS_WEB_ENROLLMENT_FEE") ?? 0;

            $overall_total = $total_tuition + $total_miscellaneous + $total_other_fee + floatval(str_replace(',', '', $partial_enrollment_fee));
            $total_paid = $total_payment + $total_discount;
            $balance = $overall_total - $total_paid;

            if ($balance > 0) {
                $total_account_payable += $balance;
            }
        }

        return $total_account_payable;
    }


    public function load_tuition_and_fees()
    {
        $ID = $this->input->post("ID");
        $ER_TRANSNO = $this->input->post("ER_TRANSNO");
        $student_id = "";

        $FEES_AMOUNTPERUNIT = 0;
        $other_tuition_fee = 0;
        // Get enrollment data
        $get_enrollment = $this->db->where("ER_TRANSNO", $ER_TRANSNO)->get("tbl_enrollment");
        foreach ($get_enrollment->result() as $r) {
            $student_id = $r->ER_STUDENTID;
            $subject_ids = array_map('intval', explode(',', $r->ER_SUBJECTS));
            $subject_ids_str = implode(',', $subject_ids);

            $get_subjects = $this->db->query("SELECT * FROM tbl_subject WHERE ID IN($subject_ids_str)");
            foreach ($get_subjects->result() as $s) {
                $S_SELECTPROG = $s->S_SELECTPROG;
                $S_MAJOR = $s->S_MAJOR;
                $S_YRLVL = $s->S_YRLVL;
                $S_SEM = $s->S_SEM;
                $S_UNITS = floatval($s->S_UNITS);

                $get_fees = $this->db->query(
                    "SELECT FEES_AMOUNTPERUNIT FROM tbl_fees_tuitions WHERE FEES_PROGRAM = ? AND FEES_MAJOR = ? AND FEES_YEARLEVEL = ? AND FEES_SEMESTER = ? LIMIT 1",
                    [$S_SELECTPROG, $S_MAJOR, $S_YRLVL, $S_SEM]
                );
                if ($get_fees->num_rows() > 0) {
                    $fee = $get_fees->row();
                    $unit_rate = floatval(str_replace(',', '', $fee->FEES_AMOUNTPERUNIT));
                    $FEES_AMOUNTPERUNIT += $unit_rate * $S_UNITS;
                }
            }
        }
        $other_tuition_fee = $FEES_AMOUNTPERUNIT;
        $query = $this->db->query("SELECT 
            f.FEES_KEY,
            e.ER_TRANSNO, 
            f.FEES_TOTALTUITION AS totalTuition,
            (SELECT COALESCE(SUM(REPLACE(mf.FEES_MISC_AMOUNT, ',', '')), 0) 
             FROM tbl_fees_miscellaneous mf 
             WHERE mf.FEES_TUITION_ID = f.FEES_KEY) AS totalMisc,
            (SELECT COALESCE(SUM(REPLACE(otf.FEES_OTHER_AMOUNT, ',', '')), 0) 
             FROM tbl_fees_otherfees otf 
             WHERE otf.FEES_TUITION_ID = f.FEES_KEY) AS totalOther,
            (SELECT COALESCE(SUM(REPLACE(p.P_AMOUNT, ',', '')), 0) 
             FROM tbl_payment p 
             WHERE p.ER_TRANSNO = e.ER_TRANSNO) AS totalPayment,
            (SELECT COALESCE(SUM(REPLACE(d.D_AMOUNT, ',', '')), 0) 
             FROM tbl_payment_discount d 
             WHERE d.ER_TRANSNO = e.ER_TRANSNO) AS totalDiscount
        FROM tbl_enrollment e
        LEFT JOIN tbl_fees_tuitions f 
            ON e.ER_PROGRAM = f.FEES_PROGRAM 
            AND e.ER_MAJOR = f.FEES_MAJOR 
            AND e.ER_YEARLEVEL = f.FEES_YEARLEVEL 
            AND e.ER_SEMESTER = f.FEES_SEMESTER
        WHERE e.ID = ? AND e.ER_TRANSNO = ?
        GROUP BY 
            e.ER_TRANSNO, 
            f.FEES_KEY, 
            f.FEES_TOTALTUITION", [$ID, $ER_TRANSNO])->row();

        // If irregular, use computed tuition, else use regular tuition
        $total_tuition = $other_tuition_fee;
        $total_miscellaneous = isset($query->totalMisc) ? floatval($query->totalMisc) : 0;
        $total_other_fee = isset($query->totalOther) ? floatval($query->totalOther) : 0;
        $total_payment = isset($query->totalPayment) ? floatval($query->totalPayment) : 0;
        $total_discount = isset($query->totalDiscount) ? floatval($query->totalDiscount) : 0;


        $partial_enrollment_fee = $this->db->get("tbl_websettings")->row("IMS_WEB_ENROLLMENT_FEE") ?? 0;


        $get_account_payable = $this->db->where("ER_UID", $ID)->where("ER_STUDENTID", $student_id)->get("tbl_enrollment_ap")->row("AP_AMOUNT") ?? 0;

        // // // Force deduction to zero the account payable if it exists
        // if ($get_account_payable > 0) {
        //     $this->force_deductions($student_id, $ER_TRANSNO, $get_account_payable);
        //     // After deduction, set account payable to zero for display
        //     $get_account_payable = 0;
        // }

        // Compute totals
        $overall_total = $total_tuition + $total_miscellaneous + $total_other_fee + str_replace(',', '', $partial_enrollment_fee);
        $total_paid = $total_payment + $total_discount;
        //  $previous_balance = $overall_total - $total_paid;

        $grand_total =  $overall_total + $get_account_payable;
        $balance_due = $grand_total - $total_paid;

        // Generate the result as HTML

        $result_tuition = '<tr>
            <td class="px-0 py-6 w-px-100">
                <p class="mb-1">Miscellaneous Fee:</p>
                <p class="mb-1">Other Fees:</p>
                <p class="mb-1 ">Tuition Fee:</p>
                <p class="mb-1  text-danger border-bottom">Enrollment Fee/Downpayment:</p>
                <p class="mb-1 fw-bold ">Sub Total Enrollment:</p>
                <p class="mb-1 fw-bold border-bottom">Previous Balance (Account Payable):</p>
                <p class="mb-1 fw-bold">Grand Total Assessment:</p>
                <h5 class="mb-1 fw-bold">Balance Due:</h5>
            </td>
            <td class="text-end px-0 py-6 w-px-100">
                <p class="fw-medium text-heading mb-1">₱' . number_format($total_miscellaneous, 2) . '</p>
                <p class="fw-medium text-heading mb-1">₱' . number_format($total_other_fee, 2) . '</p>
                <p class="fw-medium text-heading mb-1">₱' . number_format($total_tuition, 2) . '</p>
                 <p class="fw-medium border-bottom text-danger enrollment_fee mb-1">₱' . $partial_enrollment_fee . '</p>
                
                <p class="fw-bold text-heading sub-total mb-1" >₱' . number_format($overall_total, 2) . '</p>

                <p class="fw-bold text-warning text-25 mb-1 border-bottom account-payable">₱' . number_format($get_account_payable, 2) . '</p>
                <p class="fw-bold text-success text-25 mb-1 grand-total" >₱' . number_format($grand_total, 2) . '</p>
                <h5 class="fw-bold text-danger text-25 mb-1 balance-due" id="PRE_BALANCE">₱' . number_format($balance_due, 2) . '</h5>
            </td>
        </tr>';

        // check the if downpayment is exists
        $checkpayment = $this->db->where("ER_TRANSNO", $ER_TRANSNO)->get("tbl_payment");


        $total_downpayment = 0;
        $prelim_amount = 0;
        $midterm_amount = 0;
        $prefinal_amount = 0;
        $final_amount = 0;

        $slash_downpayment = false;
        $slash_prelim = false;
        $slash_midterm = false;
        $slash_prefinal = false;
        $slash_final = false;

        $result_select_desc = '';

        if ($checkpayment->num_rows() > 0) {
            foreach ($checkpayment->result() as $r) {
                if ($r->P_DESC == "Downpayment") {
                    $slash_downpayment = true;

                    $total_downpayment = str_replace(',', '', $r->P_AMOUNT);
                    $per_exam_amount = $balance_due / 4;

                    $prelim_amount = $per_exam_amount; // frelim
                    $midterm_amount = $per_exam_amount; // midterm
                    $prefinal_amount = $per_exam_amount; // pre-final
                    $final_amount = $per_exam_amount; // final

                }
                if ($r->P_DESC == "Prelim") {
                    $slash_prelim = true;
                    $prelim_amount = str_replace(',', '', $r->P_AMOUNT);
                    $per_exam_amount = $balance_due / 3;

                    $midterm_amount = $per_exam_amount; // midterm
                    $prefinal_amount = $per_exam_amount; // pre-final
                    $final_amount = $per_exam_amount; // final
                }
                if ($r->P_DESC == "Midterm") {
                    $slash_midterm = true;
                    $midterm_amount = str_replace(',', '', $r->P_AMOUNT);
                    $per_exam_amount = $balance_due / 2;

                    $prefinal_amount = $per_exam_amount; // pre-final
                    $final_amount = $per_exam_amount; // final
                }
                if ($r->P_DESC == "Pre-Final") {
                    $slash_prefinal = true;
                    $prefinal_amount = str_replace(',', '', $r->P_AMOUNT);
                    $per_exam_amount = $balance_due;

                    $final_amount = $per_exam_amount; // final
                }
                if ($r->P_DESC == "Final") {
                    $slash_final = true;
                    $final_amount = str_replace(',', '', $r->P_AMOUNT);
                }
            }
        } else {

            $total_downpayment = str_replace(',', '', $partial_enrollment_fee);
            $check_balance = $grand_total - $total_downpayment;
            $per_exam_amount = $check_balance / 4;
            $prelim_amount = $per_exam_amount;
            $midterm_amount = $per_exam_amount;
            $prefinal_amount = $per_exam_amount;
            $final_amount = $per_exam_amount;


            $result_select_desc .= '<option>Full Payment</option><option>Downpayment</option>';
        }


        $result_paymentmode = '<tr>
            <td class="px-0 py-6 w-px-100">
                <p class="mb-1 fw-bold">Payment Schedule</p>
                <p class="mb-1">Downpayment:</p>
                <p class="mb-1">Prelim:</p>
                <p class="mb-1">Midterm:</p>
                <p class="mb-1">Pre-Final:</p>
                <p class="mb-1">Final:</p>
            </td>
            <td class="text-end px-0 py-6 w-px-100">
                <br>
                <p class="fw-medium ' . ($slash_downpayment == true ? 'text-decoration-line-through' : '') . ' text-heading mb-1">₱' . number_format($total_downpayment, 2) . '</p>
                <p class="fw-medium ' . ($slash_prelim == true ? 'text-decoration-line-through' : '') . ' text-heading mb-1">₱' . number_format($prelim_amount, 2) . '</p>
                <p class="fw-medium ' . ($slash_midterm == true ? 'text-decoration-line-through' : '') . ' text-heading mb-1">₱' . number_format($midterm_amount, 2) . '</p>
                <p class="fw-medium ' . ($slash_prefinal == true ? 'text-decoration-line-through' : '') . ' text-heading mb-1">₱' . number_format($prefinal_amount, 2) . '</p>
                <p class="fw-medium ' . ($slash_final == true ? 'text-decoration-line-through' : '') . ' text-heading mb-1">₱' . number_format($final_amount, 2) . '</p>
            </td>
        </tr>';


        if ($slash_downpayment == true && $slash_prelim == false) {
            $result_select_desc .= '<option>Prelim</option>';
        }
        if ($slash_prelim == true && $slash_midterm == false) {
            $result_select_desc .= '<option>Midterm</option>';
        }
        if ($slash_midterm == true && $slash_prefinal == false) {
            $result_select_desc .= '<option>Pre-Final</option>';
        }
        if ($slash_prefinal == true) {
            $result_select_desc .= '<option>Final</option>';
        }

        // Fetch and append miscellaneous & other fees
        $feeKey = isset($query->FEES_KEY) ? $query->FEES_KEY : null;
        if ($feeKey) {
            // Fetch already paid descriptions for this enrollment to exclude them
            $paid_query = $this->db->select("P_DESC")->where("ER_TRANSNO", $ER_TRANSNO)->get("tbl_payment");
            $paid_fees = [];
            foreach ($paid_query->result() as $p_row) {
                $descs = explode(", ", $p_row->P_DESC);
                foreach ($descs as $d) {
                    $paid_fees[] = strtolower(trim($d));
                }
            }

            $misc_fees = $this->db->where("FEES_TUITION_ID", $feeKey)->get("tbl_fees_miscellaneous")->result();
            foreach ($misc_fees as $mf) {
                $fee_desc_lower = strtolower(trim($mf->FEES_MISC_DESC));
                if (in_array($fee_desc_lower, $paid_fees)) {
                    continue; // Skip if already paid
                }
                $amount = str_replace(',', '', $mf->FEES_MISC_AMOUNT);
                $result_select_desc .= '<option value="' . htmlspecialchars($mf->FEES_MISC_DESC) . '" data-amount="' . $amount . '">' . ucwords(strtolower(htmlspecialchars($mf->FEES_MISC_DESC))) . '</option>';
            }

            $other_fees = $this->db->where("FEES_TUITION_ID", $feeKey)->get("tbl_fees_otherfees")->result();
            foreach ($other_fees as $of) {
                $fee_desc_lower = strtolower(trim($of->FEES_OTHER_DESC));
                if (in_array($fee_desc_lower, $paid_fees)) {
                    continue; // Skip if already paid
                }
                $amount = str_replace(',', '', $of->FEES_OTHER_AMOUNT);
                $result_select_desc .= '<option value="' . htmlspecialchars($of->FEES_OTHER_DESC) . '" data-amount="' . $amount . '">' . ucwords(strtolower(htmlspecialchars($of->FEES_OTHER_DESC))) . '</option>';
            }
        }

        $data = [
            "result_tuition" => $result_tuition,
            "result_paymentmode" => $result_paymentmode,
            "result_select_desc" => $result_select_desc
        ];

        return $data;
    }




    function getpreviousbalance($ID, $ER_TRANSNO)
    {
        $FEES_AMOUNTPERUNIT = 0;
        $other_tuition_fee = 0;
        // Get enrollment data
        $get_enrollment = $this->db->where("ER_TRANSNO", $ER_TRANSNO)->get("tbl_enrollment");
        foreach ($get_enrollment->result() as $r) {
            $subject_ids = array_map('intval', explode(',', $r->ER_SUBJECTS));
            $subject_ids_str = implode(',', $subject_ids);

            $get_subjects = $this->db->query("SELECT * FROM tbl_subject WHERE ID IN($subject_ids_str)");
            foreach ($get_subjects->result() as $s) {
                $S_SELECTPROG = $s->S_SELECTPROG;
                $S_MAJOR = $s->S_MAJOR;
                $S_YRLVL = $s->S_YRLVL;
                $S_SEM = $s->S_SEM;
                $S_UNITS = floatval($s->S_UNITS);

                $get_fees = $this->db->query(
                    "SELECT FEES_AMOUNTPERUNIT FROM tbl_fees_tuitions WHERE FEES_PROGRAM = ? AND FEES_MAJOR = ? AND FEES_YEARLEVEL = ? AND FEES_SEMESTER = ? LIMIT 1",
                    [$S_SELECTPROG, $S_MAJOR, $S_YRLVL, $S_SEM]
                );
                if ($get_fees->num_rows() > 0) {
                    $fee = $get_fees->row();
                    $unit_rate = floatval(str_replace(',', '', $fee->FEES_AMOUNTPERUNIT));
                    $FEES_AMOUNTPERUNIT += $unit_rate * $S_UNITS;
                }
            }
        }
        $other_tuition_fee = $FEES_AMOUNTPERUNIT;
        $query = $this->db->query("SELECT 
            f.FEES_KEY,
            e.ER_TRANSNO, 
            f.FEES_TOTALTUITION AS totalTuition,
            (SELECT COALESCE(SUM(REPLACE(mf.FEES_MISC_AMOUNT, ',', '')), 0) 
             FROM tbl_fees_miscellaneous mf 
             WHERE mf.FEES_TUITION_ID = f.FEES_KEY) AS totalMisc,
            (SELECT COALESCE(SUM(REPLACE(otf.FEES_OTHER_AMOUNT, ',', '')), 0) 
             FROM tbl_fees_otherfees otf 
             WHERE otf.FEES_TUITION_ID = f.FEES_KEY) AS totalOther,
            (SELECT COALESCE(SUM(REPLACE(p.P_AMOUNT, ',', '')), 0) 
             FROM tbl_payment p 
             WHERE p.ER_TRANSNO = e.ER_TRANSNO) AS totalPayment,
            (SELECT COALESCE(SUM(REPLACE(d.D_AMOUNT, ',', '')), 0) 
             FROM tbl_payment_discount d 
             WHERE d.ER_TRANSNO = e.ER_TRANSNO) AS totalDiscount
        FROM tbl_enrollment e
        LEFT JOIN tbl_fees_tuitions f 
            ON e.ER_PROGRAM = f.FEES_PROGRAM 
            AND e.ER_MAJOR = f.FEES_MAJOR 
            AND e.ER_YEARLEVEL = f.FEES_YEARLEVEL 
            AND e.ER_SEMESTER = f.FEES_SEMESTER
        WHERE e.ID = ? AND e.ER_TRANSNO = ?
        GROUP BY 
            e.ER_TRANSNO, 
            f.FEES_KEY, 
            f.FEES_TOTALTUITION", [$ID, $ER_TRANSNO])->row();

        // If irregular, use computed tuition, else use regular tuition
        $total_tuition = $other_tuition_fee;
        $total_miscellaneous = isset($query->totalMisc) ? floatval($query->totalMisc) : 0;
        $total_other_fee = isset($query->totalOther) ? floatval($query->totalOther) : 0;
        $total_payment = isset($query->totalPayment) ? floatval($query->totalPayment) : 0;
        $total_discount = isset($query->totalDiscount) ? floatval($query->totalDiscount) : 0;



        $partial_enrollment_fee = $this->db->get("tbl_websettings")->row("IMS_WEB_ENROLLMENT_FEE") ?? 0;


        // Compute totals
        $overall_total = $total_tuition + $total_miscellaneous + $total_other_fee + str_replace(',', '', $partial_enrollment_fee);
        $total_paid = $total_payment + $total_discount;
        $previous_balance = $overall_total - $total_paid;
        return $previous_balance;
    }

    // public function load_tuition_and_fees()
    // {
    //     $ID = $this->input->post("ID");
    //     $ER_TRANSNO = $this->input->post("ER_TRANSNO");

    //     $FEES_AMOUNTPERUNIT = 0;

    //     // Get enrollment data
    //     $get_enrollment = $this->db->where("ER_TRANSNO", $ER_TRANSNO)->get("tbl_enrollment");

    //     foreach ($get_enrollment->result() as $r) {
    //         if ($r->ER_CLASSIFICATION === "IRREGULAR" && !empty($r->ER_SUBJECTS)) {
    //             $subject_ids = array_map('intval', explode(',', $r->ER_SUBJECTS));
    //             $subject_ids_str = implode(',', $subject_ids);

    //             $get_subjects = $this->db->query("SELECT * FROM tbl_subject WHERE ID IN($subject_ids_str)");

    //             foreach ($get_subjects->result() as $s) {
    //                 $S_SELECTPROG = $s->S_SELECTPROG;
    //                 $S_MAJOR = $s->S_MAJOR;
    //                 $S_YRLVL = $s->S_YRLVL;
    //                 $S_SEM = $s->S_SEM;
    //                 $S_UNITS = floatval($s->S_UNITS);

    //                 $get_fees = $this->db->query("
    //                     SELECT FEES_AMOUNTPERUNIT 
    //                     FROM tbl_fees_tuitions 
    //                     WHERE FEES_PROGRAM = ? AND FEES_MAJOR = ? AND FEES_YEARLEVEL = ? AND FEES_SEMESTER = ?
    //                     LIMIT 1
    //                 ", [$S_SELECTPROG, $S_MAJOR, $S_YRLVL, $S_SEM]);

    //                 if ($get_fees->num_rows() > 0) {
    //                     $fee = $get_fees->row();
    //                     $unit_rate = floatval(str_replace(',', '', $fee->FEES_AMOUNTPERUNIT));
    //                     $FEES_AMOUNTPERUNIT += $unit_rate * $S_UNITS;
    //                 }
    //             }
    //         }
    //     }


    //     // General tuition and fees
    //     $query = $this->db->query("SELECT 
    //         f.FEES_KEY,
    //         e.ER_TRANSNO, 
    //         f.FEES_TOTALTUITION AS totalTuition,
    //         (SELECT COALESCE(SUM(REPLACE(mf.FEES_MISC_AMOUNT, ',', '')), 0) 
    //          FROM tbl_fees_miscellaneous mf 
    //          WHERE mf.FEES_TUITION_ID = f.FEES_KEY) AS totalMisc,
    //         (SELECT COALESCE(SUM(REPLACE(otf.FEES_OTHER_AMOUNT, ',', '')), 0) 
    //          FROM tbl_fees_otherfees otf 
    //          WHERE otf.FEES_TUITION_ID = f.FEES_KEY) AS totalOther,
    //         (SELECT COALESCE(SUM(REPLACE(p.P_AMOUNT, ',', '')), 0) 
    //          FROM tbl_payment p 
    //          WHERE p.ER_TRANSNO = e.ER_TRANSNO) AS totalPayment,
    //         (SELECT COALESCE(SUM(REPLACE(d.D_AMOUNT, ',', '')), 0) 
    //          FROM tbl_payment_discount d 
    //          WHERE d.ER_TRANSNO = e.ER_TRANSNO) AS totalDiscount
    //     FROM tbl_enrollment e
    //             LEFT JOIN tbl_fees_tuitions f 
    //                 ON e.ER_PROGRAM = f.FEES_PROGRAM 
    //                 AND e.ER_MAJOR = f.FEES_MAJOR 
    //                 AND e.ER_YEARLEVEL = f.FEES_YEARLEVEL 
    //                 AND e.ER_SEMESTER = f.FEES_SEMESTER
    //             WHERE e.ID = ? AND e.ER_TRANSNO = ?
    //             GROUP BY e.ER_TRANSNO, f.FEES_KEY, f.FEES_TOTALTUITION
    //         ", [$ID, $ER_TRANSNO])->row();


    //     if ($FEES_AMOUNTPERUNIT > 0) {
    //         $total_tuition = $FEES_AMOUNTPERUNIT;
    //     } else {
    //         $total_tuition =  isset($query->totalTuition) ? floatval(str_replace(',', '', $query->totalTuition)) : 0;
    //     }


    //     $total_miscellaneous = isset($query->totalMisc) ? floatval($query->totalMisc) : 0;
    //     $total_other_fee = isset($query->totalOther) ? floatval($query->totalOther) : 0;
    //     $total_payment = isset($query->totalPayment) ? floatval($query->totalPayment) : 0;
    //     $total_discount = isset($query->totalDiscount) ? floatval($query->totalDiscount) : 0;

    //     $partial_enrollment_fee = floatval(str_replace(',', '', $this->db->get("tbl_websettings")->row("IMS_WEB_ENROLLMENT_FEE") ?? 0));

    //     $overall_total = $total_tuition + $total_miscellaneous + $total_other_fee + $partial_enrollment_fee;
    //     $total_paid = $total_payment + $total_discount;
    //     $previous_balance = $overall_total - $total_paid;

    //     $result_tuition = '<tr>
    //     <td class="px-0 py-6 w-px-100">
    //         <p class="mb-1">Miscellaneous Fee:</p>
    //         <p class="mb-1">Other Fees:</p>
    //         <p class="mb-1">Tuition Fee:</p>
    //         <p class="mb-2 border-bottom pb-2 text-danger ">Enrollment Fee/Downpayment:</p>
    //         <p class="mb-0 fw-bold">Total Assessment:</p>
    //         <h5 class="mb-0 fw-bold">Previous Balance:</h5>
    //     </td>
    //     <td class="text-end px-0 py-6 w-px-100">
    //         <p class="fw-medium text-heading mb-1">₱' . number_format($total_miscellaneous, 2) . '</p>
    //         <p class="fw-medium text-heading mb-1">₱' . number_format($total_other_fee, 2) . '</p>
    //         <p class="fw-medium text-heading mb-1">₱' . number_format($total_tuition, 2) . '</p>
    //         <p class="fw-medium text-danger mb-2 border-bottom pb-2">₱' . number_format($partial_enrollment_fee, 2) . '</p>
    //         <p class="fw-bold text-heading total_tuition text-18 mb-0">₱' . number_format($overall_total, 2) . '</p>
    //         <h5 class="fw-bold text-warning text-25 mb-0" id="PRE_BALANCE">₱' . number_format($previous_balance, 2) . '</h5>
    //     </td>
    //     </tr>';

    //     $checkpayment = $this->db->where("ER_TRANSNO", $ER_TRANSNO)->get("tbl_payment");

    //     $total_downpayment = 0;
    //     $prelim_amount = 0;
    //     $midterm_amount = 0;
    //     $prefinal_amount = 0;
    //     $final_amount = 0;

    //     $slash_downpayment = false;
    //     $slash_prelim = false;
    //     $slash_midterm = false;
    //     $slash_prefinal = false;
    //     $slash_final = false;

    //     $result_select_desc = '<option value="">--Select--</option>';

    //     if ($checkpayment->num_rows() > 0) {
    //         foreach ($checkpayment->result() as $r) {
    //             $desc = $r->P_DESC;
    //             $amount = floatval(str_replace(',', '', $r->P_AMOUNT));
    //             $per_exam_amount = $previous_balance / 4;

    //             switch ($desc) {
    //                 case "Downpayment":
    //                     $slash_downpayment = true;
    //                     $total_downpayment = $amount;
    //                     $prelim_amount = $per_exam_amount;
    //                     $midterm_amount = $per_exam_amount;
    //                     $prefinal_amount = $per_exam_amount;
    //                     $final_amount = $per_exam_amount;
    //                     break;
    //                 case "Prelim":
    //                     $slash_prelim = true;
    //                     $prelim_amount = $amount;
    //                     $per_exam_amount = $previous_balance / 3;
    //                     $midterm_amount = $per_exam_amount;
    //                     $prefinal_amount = $per_exam_amount;
    //                     $final_amount = $per_exam_amount;
    //                     break;
    //                 case "Midterm":
    //                     $slash_midterm = true;
    //                     $midterm_amount = $amount;
    //                     $per_exam_amount = $previous_balance / 2;
    //                     $prefinal_amount = $per_exam_amount;
    //                     $final_amount = $per_exam_amount;
    //                     break;
    //                 case "Pre-Final":
    //                     $slash_prefinal = true;
    //                     $prefinal_amount = $amount;
    //                     $final_amount = $previous_balance;
    //                     break;
    //                 case "Final":
    //                     $slash_final = true;
    //                     $final_amount = $amount;
    //                     break;
    //             }
    //         }
    //     } else {
    //         $total_downpayment = $partial_enrollment_fee;
    //         $per_exam_amount = $overall_total / 4;
    //         $prelim_amount = $midterm_amount = $prefinal_amount = $final_amount = $per_exam_amount;

    //         $result_select_desc .= '<option>Full Payment</option><option>Downpayment</option>';
    //     }

    //     $result_paymentmode = '<tr>
    //     <td class="px-0 py-6 w-px-100">
    //         <p class="mb-1 fw-bold">Payment Schedule</p>
    //         <p class="mb-1">Downpayment:</p>
    //         <p class="mb-1">Prelim:</p>
    //         <p class="mb-1">Midterm:</p>
    //         <p class="mb-1">Pre-Final:</p>
    //         <p class="mb-1">Final:</p>
    //     </td>
    //     <td class="text-end px-0 py-6 w-px-100">
    //         <br>
    //         <p class="fw-medium ' . ($slash_downpayment ? 'text-decoration-line-through' : '') . ' text-heading mb-1">₱' . number_format($total_downpayment, 2) . '</p>
    //         <p class="fw-medium ' . ($slash_prelim ? 'text-decoration-line-through' : '') . ' text-heading mb-1">₱' . number_format($prelim_amount, 2) . '</p>
    //         <p class="fw-medium ' . ($slash_midterm ? 'text-decoration-line-through' : '') . ' text-heading mb-1">₱' . number_format($midterm_amount, 2) . '</p>
    //         <p class="fw-medium ' . ($slash_prefinal ? 'text-decoration-line-through' : '') . ' text-heading mb-1">₱' . number_format($prefinal_amount, 2) . '</p>
    //         <p class="fw-medium ' . ($slash_final ? 'text-decoration-line-through' : '') . ' text-heading mb-1">₱' . number_format($final_amount, 2) . '</p>
    //     </td>
    //          </tr>';

    //     if ($slash_downpayment && !$slash_prelim) {
    //         $result_select_desc .= '<option>Prelim</option>';
    //     }
    //     if ($slash_prelim && !$slash_midterm) {
    //         $result_select_desc .= '<option>Midterm</option>';
    //     }
    //     if ($slash_midterm && !$slash_prefinal) {
    //         $result_select_desc .= '<option>Pre-Final</option>';
    //     }
    //     if ($slash_prefinal && !$slash_final) {
    //         $result_select_desc .= '<option>Final</option>';
    //     }

    //     return [
    //         "result_tuition" => $result_tuition,
    //         "result_paymentmode" => $result_paymentmode,
    //         "result_select_desc" => $result_select_desc
    //     ];
    // }




    function delete_summary_voucher()
    {
        $this->db->where("ID", $this->input->post("ID"))->delete("tbl_payment_discount");
        return true;
    }
    function delete_summary_payment()
    {
        $this->db->where("ID", $this->input->post("ID"))->delete("tbl_payment");
        // Check if the payment has any associated discounts
        $this->db->where("P_VOUCHERNO", $this->input->post("P_VOUCHERNO"))->delete("tbl_payment_discount");

        $get_exists = $this->db->where("ER_TRANSNO", $this->input->post("ER_TRANSNO"))->get("tbl_payment"); // check if the payment has student id
        if ($get_exists->num_rows() > 0) {
            $data = [
                "ER_PAYMENTSTATUS" => "INSTALLMENT",
            ];
            $this->db->where("ER_TRANSNO", $this->input->post("ER_TRANSNO"))->update("tbl_enrollment", $data);
        } else {
            $data = [
                "ER_PAYMENTSTATUS" => "UNPAID",
                "ER_ENSTATUS" => "PENDING"
            ];
            $this->db->where("ER_TRANSNO", $this->input->post("ER_TRANSNO"))->update("tbl_enrollment", $data);
        }
        return true;
    }



    function LoadStudentEnrolled()
    {
        $sql = "SELECT
        s.SP_LASTNAME,
        s.SP_MIDDLENAME,
        s.SP_FIRSTNAME,
        s.SP_GENDER,
        s.SP_CPNUMBER,
        e.*
    FROM
        tbl_enrollment AS e
    LEFT JOIN
        tbl_studprof AS s ON e.ER_STUDENTID = s.SP_STUDID
    WHERE e.ER_STUDENTID !='' AND e.ID = {$this->uri->segment(4)}";
        $query = $this->db->query($sql);
        return $query;
    }

    function LoadProgramMajor()
    {
        $query = $this->db->where("P_PDESCRIPTIONS", $this->input->post("ER_PROGRAM"))->get("tbl_program");
        $result = '<option value="">--SELECT--</option>';
        foreach ($query->result() as $r) {
            $result .= '<option>' . $r->P_MAJOR . '</option>';
        }
        return $result;
    }

    function LoadEnrollment()
    {

        $result = "";
        $FILTER_PROGRAM = $this->input->post("FILTER_PROGRAM");
        $FILTER_MAJOR = $this->input->post("FILTER_MAJOR");
        $FILTER_YL = $this->input->post("FILTER_YL");
        $FILTER_AY = $this->input->post("FILTER_AY");
        $FILTER_SEM = $this->input->post("FILTER_SEM");
        $FILTER_STATUS = $this->input->post("FILTER_STATUS");

        $sql = "SELECT
                    s.SP_STUDID,
                    s.SP_LASTNAME,
                    s.SP_MIDDLENAME,
                    s.SP_FIRSTNAME,
                    s.SP_GENDER,
                    e.*
                FROM
                    tbl_enrollment AS e
                LEFT JOIN
                    tbl_studprof AS s ON e.ER_STUDENTID = s.SP_STUDID
                WHERE e.ER_STUDENTID !='' 
                ";

        if (!empty($FILTER_PROGRAM)) {
            $sql .= " AND e.ER_PROGRAM = '{$FILTER_PROGRAM}'";
        }
        if (!empty($FILTER_MAJOR)) {
            $sql .= " AND e.ER_MAJOR = '{$FILTER_MAJOR}'";
        }
        if (!empty($FILTER_YL)) {
            $sql .= " AND e.ER_YEARLEVEL = '{$FILTER_YL}'";
        }
        if (!empty($FILTER_AY)) {
            $sql .= " AND e.ER_ACADEMICYEAR = '{$FILTER_AY}'";
        }
        if (!empty($FILTER_SEM)) {
            $sql .= " AND e.ER_SEMESTER = '{$FILTER_SEM}'";
        }
        if (!empty($FILTER_STATUS)) {
            $sql .= " AND e.ER_PAYMENTSTATUS = '{$FILTER_STATUS}'";
        }

        $sql .= " ORDER BY CASE 
                    WHEN e.ER_PAYMENTSTATUS = 'UNPAID' THEN 1 
                    WHEN e.ER_PAYMENTSTATUS = 'INSTALLMENT' THEN 2 
                    ELSE 3 
                END, e.ER_TRANSNO DESC";

        $query = $this->db->query($sql);
        $num = 0;
        // Process the results
        foreach ($query->result() as $r) {
            $num++;
            $major = ($r->ER_MAJOR == "") ? '' : '<small><b>(' . $r->ER_MAJOR . ')</b></small>';
            $status = '<span class="badge rounded-pill bg-';
            switch ($r->ER_PAYMENTSTATUS) {
                case 'UNPAID':
                    $status .= 'danger';
                    break;
                case 'INSTALLMENT':
                    $status .= 'warning';
                    break;
                case 'PAID':
                    $status .= 'success';
                    break;
                default:
                    $status .= 'secondary';
            }
            $status .= '">' . htmlspecialchars($r->ER_PAYMENTSTATUS, ENT_QUOTES, 'UTF-8') . '</span>';

            $result .= '<tr>';
            $result .= '<td class="d-none">' . $r->ID . '</td>';
            $result .= '<td>
            <a type="button" class="btn btn-xs btn-rounded btn-primary"  href="' . base_url("ims/cashierbilling/payment/" . $r->ID . "/" . $r->ER_TRANSNO) . '"><i class="ri ri-add-line"></i> Add Payment</a>
        </td>';
            $result .= '<td>' . $r->SP_STUDID . '</td>';
            $result .= '<td>' . $r->SP_LASTNAME . ', ' . $r->SP_FIRSTNAME . ' ' . $r->SP_MIDDLENAME . '</td>';
            $result .= '<td>' . $r->SP_GENDER . '</td>';
            $result .= '<td>' . $r->ER_PROGRAM . ' ' . $major . '</td>';
            $result .= '<td>' . $r->ER_YEARLEVEL . '</td>';
            $result .= '<td>' . $r->ER_SEMESTER . '</td>';
            $result .= '<td>' . $status . '</td>';
            $result .= '<td> <button type="button" class="btn btn-xs btn-secondary btn-statement-account" data-id="' . $r->ID . '" data-trno="' . $r->ER_TRANSNO . '"><i class="ri ri-file-list-3-line"></i> Statement of Account</button></td>';
            $result .= '</tr>';
        }

        return $result;
    }

    function generate_transaction_no()
    {
        do {
            $date = date('YmdHis'); // Current date and time
            $randomNumber = rand(1000, 9999); // Generate a random 4-digit number
            $letters = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3); // Generate 3 random letters
            $transactionNo = $date . $letters . $randomNumber; // Concatenate date, letters, and random number

            // Check if the generated transaction number already exists in the database
            $exists = $this->db->where('P_VOUCHERNO', $transactionNo)->count_all_results('tbl_payment') > 0;
        } while ($exists); // Repeat if the transaction number already exists

        return $transactionNo;
    }


    function generate_or_number()
    {
        do {
            $or_number = str_pad(mt_rand(0, 9999999999), 10, '0', STR_PAD_LEFT);
            $exists = $this->db->where('OR_NUM', $or_number)->count_all_results('tbl_payment') > 0;
        } while ($exists);

        return $or_number;
    }


    function force_deductions($student_id, $current_transno, $payment_amount)
    {
        // Get all enrollments for this student excluding the current transaction and which are not PAID
        $this->db->where("ER_STUDENTID", $student_id);
        $this->db->where("ER_TRANSNO !=", $current_transno);
        $this->db->where_in("ER_PAYMENTSTATUS", ["UNPAID", "INSTALLMENT"]);
        $this->db->order_by("ID", "ASC"); // Oldest first
        $get_enrollments = $this->db->get("tbl_enrollment");

        $remaining_payment = floatval(str_replace(',', '', $payment_amount));
        $total_deducted = 0;

        foreach ($get_enrollments->result() as $enrollment) {
            if ($remaining_payment <= 0) break;

            $FEES_AMOUNTPERUNIT = 0;
            $ER_TRANSNO = $enrollment->ER_TRANSNO;

            // Compute Tuition Fee based on subjects (copied logic from account payable calc)
            if (!empty($enrollment->ER_SUBJECTS)) {
                $subject_ids = array_map('intval', explode(',', $enrollment->ER_SUBJECTS));
                $subject_ids_str = implode(',', $subject_ids);

                $get_subjects = $this->db->query("SELECT * FROM tbl_subject WHERE ID IN($subject_ids_str)");
                foreach ($get_subjects->result() as $s) {
                    $get_fees = $this->db->query(
                        "SELECT FEES_AMOUNTPERUNIT FROM tbl_fees_tuitions WHERE FEES_PROGRAM = ? AND FEES_MAJOR = ? AND FEES_YEARLEVEL = ? AND FEES_SEMESTER = ? LIMIT 1",
                        [$s->S_SELECTPROG, $s->S_MAJOR, $s->S_YRLVL, $s->S_SEM]
                    );
                    if ($get_fees->num_rows() > 0) {
                        $fee = $get_fees->row();
                        $unit_rate = floatval(str_replace(',', '', $fee->FEES_AMOUNTPERUNIT));
                        $FEES_AMOUNTPERUNIT += $unit_rate * floatval($s->S_UNITS);
                    }
                }
            }

            $query = $this->db->query("SELECT 
                (SELECT COALESCE(SUM(REPLACE(mf.FEES_MISC_AMOUNT, ',', '')), 0) FROM tbl_fees_miscellaneous mf WHERE mf.FEES_TUITION_ID = f.FEES_KEY) AS totalMisc,
                (SELECT COALESCE(SUM(REPLACE(otf.FEES_OTHER_AMOUNT, ',', '')), 0) FROM tbl_fees_otherfees otf WHERE otf.FEES_TUITION_ID = f.FEES_KEY) AS totalOther,
                (SELECT COALESCE(SUM(REPLACE(p.P_AMOUNT, ',', '')), 0) FROM tbl_payment p WHERE p.ER_TRANSNO = e.ER_TRANSNO) AS totalPayment,
                (SELECT COALESCE(SUM(REPLACE(d.D_AMOUNT, ',', '')), 0) FROM tbl_payment_discount d WHERE d.ER_TRANSNO = e.ER_TRANSNO) AS totalDiscount
            FROM tbl_enrollment e
            LEFT JOIN tbl_fees_tuitions f ON e.ER_PROGRAM = f.FEES_PROGRAM AND e.ER_MAJOR = f.FEES_MAJOR AND e.ER_YEARLEVEL = f.FEES_YEARLEVEL AND e.ER_SEMESTER = f.FEES_SEMESTER
            WHERE e.ER_TRANSNO = ? LIMIT 1", [$ER_TRANSNO])->row();

            $partial_enrollment_fee = $this->db->get("tbl_websettings")->row("IMS_WEB_ENROLLMENT_FEE") ?? 0;
            $overall_total = $FEES_AMOUNTPERUNIT + floatval($query->totalMisc ?? 0) + floatval($query->totalOther ?? 0) + floatval(str_replace(',', '', $partial_enrollment_fee));
            $total_paid = floatval($query->totalPayment ?? 0) + floatval($query->totalDiscount ?? 0);
            $term_balance = $overall_total - $total_paid;

            if ($term_balance > 0) {
                $deduction = min($remaining_payment, $term_balance);

                // Insert Forced Deduction Payment
                $payment_data = [
                    "P_DESC" => "Forced Deduction",
                    "P_AMOUNT" => number_format($deduction, 2),
                    "ER_STUDENTID" => $student_id,
                    "ER_TRANSNO" => $ER_TRANSNO,
                    "P_ENCODER" => $this->session->userdata("fullname") . " (AUTO)",
                    "P_DATESUBMITTED" => date('Y-m-d H:i:s'),
                    "OR_NUM" => "FD-" . date('Ymd') . "-" . rand(100, 999)
                ];
                $this->db->insert("tbl_payment", $payment_data);

                $remaining_payment -= $deduction;
                $total_deducted += $deduction;

                // Update Term Status
                if (($term_balance - $deduction) <= 0) {
                    $this->db->where("ER_TRANSNO", $ER_TRANSNO)->update("tbl_enrollment", ["ER_PAYMENTSTATUS" => "PAID"]);
                } else {
                    $this->db->where("ER_TRANSNO", $ER_TRANSNO)->update("tbl_enrollment", ["ER_PAYMENTSTATUS" => "INSTALLMENT"]);
                }
            }
        }
        return $total_deducted;
    }

    function savePayment()
    {
        date_default_timezone_set("Asia/Manila");
        $ER_STUDENTID = $this->input->post("ER_STUDENTID");
        $ER_TRANSNO = $this->input->post("ER_TRANSNO");
        $original_payment_amount = floatval(str_replace(',', '', $this->input->post("P_AMOUNT")));

        // Extract P_DESC post value and handle array/string cases
        $P_DESC_post = $this->input->post("P_DESC");
        $P_DESC_str = "";
        $is_full_payment = false;
        $is_final = false;
        
        if (is_array($P_DESC_post)) {
            $P_DESC_str = implode(", ", $P_DESC_post);
            $is_full_payment = in_array("Full Payment", $P_DESC_post);
            $is_final = in_array("Final", $P_DESC_post);
        } else {
            $P_DESC_str = $P_DESC_post;
            $is_full_payment = ($P_DESC_post == "Full Payment");
            $is_final = ($P_DESC_post == "Final");
        }

        // 1. Handle Force Deductions first
        $deducted_amount = $this->force_deductions($ER_STUDENTID, $ER_TRANSNO, $original_payment_amount);
        $remaining_for_current = $original_payment_amount - $deducted_amount;

        // 2. Process Discounts (original logic)
        $countdata = isset($_POST["P_DISCOUNT_AMOUNT"]) && is_array($_POST["P_DISCOUNT_AMOUNT"]) ? count($_POST["P_DISCOUNT_AMOUNT"]) : 0;
        $P_VOUCHERNO = "";
        if ($countdata > 0) {
            $P_VOUCHERNO = $this->generate_transaction_no();
            for ($i = 0; $i < $countdata; $i++) {
                $P_DISCOUNT_NAME = json_decode($_POST["P_DISCOUNT_NAME"][$i] ?? '{}', true);
                $data = [
                    "D_DESC" => $P_DISCOUNT_NAME['TOD_NAME'] ?? '',
                    "D_AMOUNT" => $_POST["P_DISCOUNT_AMOUNT"][$i] ?? 0,
                    "ER_TRANSNO" => $ER_TRANSNO,
                    "P_VOUCHERNO" => $P_VOUCHERNO,
                    "ER_STUDENTID" => $ER_STUDENTID,
                ];
                $this->db->insert("tbl_payment_discount", $data);
            }
        }

        // 3. Insert Payment record for CURRENT enrollment (only if there's remaining amount)
        if ($remaining_for_current > 0 || $original_payment_amount == 0) {
            $data = [
                "P_VOUCHERNO" => $P_VOUCHERNO,
                "P_DESC" => $P_DESC_str,
                "P_AMOUNT" => number_format($remaining_for_current, 2),
                "ER_TRANSNO" => $ER_TRANSNO,
                "ER_STUDENTID" => $ER_STUDENTID,
                "P_ENCODER" => $this->session->userdata("fullname"),
                "P_DATESUBMITTED" => date('Y-m-d H:i:s'),
                'OR_NUM' => $this->generate_or_number()
            ];
            $this->db->insert("tbl_payment", $data);
        }


        $previous_balance = $this->getpreviousbalance($this->input->post("uid"), $this->input->post("ER_TRANSNO"));


        if ($previous_balance == 0) {
            $data = [
                "ER_PAYMENTSTATUS" => "PAID",
                "ER_ENSTATUS" => "ACTIVE"
            ];
            $this->db->where("ER_TRANSNO", $this->input->post("ER_TRANSNO"))->update("tbl_enrollment", $data);
            //  $this->db->where("ER_STUDENTID",  $ER_STUDENTID)->update("tbl_enrollment", $data);
        } else {

            // update the status of enrollment
            // $check_status = $this->db->where("ER_TRANSNO", $this->input->post("ER_TRANSNO"))->get("tbl_payment");
            // if ($check_status->num_rows() < 1) {
            //     // update the enrollment status
            //     $data = [
            //         "ER_ENSTATUS" => "ACTIVE"
            //     ];
            //     $this->db->where("ER_TRANSNO", $this->input->post("ER_TRANSNO"))->update("tbl_enrollment", $data);
            // }

            if ($is_full_payment) {
                $data = [
                    "ER_PAYMENTSTATUS" => "PAID",
                    "ER_ENSTATUS" => "ACTIVE"
                ];
                $this->db->where("ER_TRANSNO", $this->input->post("ER_TRANSNO"))->update("tbl_enrollment", $data);
            } else {

                if ($is_final) {
                    $data = [
                        "ER_PAYMENTSTATUS" => "PAID",
                        "ER_ENSTATUS" => "ACTIVE"
                    ];
                    $this->db->where("ER_TRANSNO", $this->input->post("ER_TRANSNO"))->update("tbl_enrollment", $data);
                } else {
                    $data = [
                        "ER_PAYMENTSTATUS" => "INSTALLMENT",
                        "ER_ENSTATUS" => "ACTIVE"
                    ];
                    $this->db->where("ER_TRANSNO", $this->input->post("ER_TRANSNO"))->update("tbl_enrollment", $data);
                }
            }
        }


        return "success";
    }

    function saveTypeofDiscount()
    {
        $data = [
            "TOD_NAME" => trim($this->input->post("TOD_NAME")),
            "TOD_PERCENT" => trim($this->input->post("TOD_PERCENT"))
        ];
        if (!empty($this->input->post("ID"))) {
            $this->db->where("ID", $this->input->post("ID"))->update("tbl_typediscount", $data); // for update
        } else {
            $this->db->insert("tbl_typediscount", $data); // for save
        }
        return true;
    }
    function deleteTypeofDiscount()
    {
        $this->db->where("ID", $this->input->post("ID"))->delete("tbl_typediscount");
        return true;
    }

    function load_type_of_discount()
    {
        $result = "";
        $query = $this->db->get("tbl_typediscount");
        foreach ($query->result() as $r) {
            $result .= "<tr>
                        <td>{$r->TOD_NAME}</td>            
                        <td>" . str_replace('%', '', $r->TOD_PERCENT) . "</td>
                        <td>
                            <div class='dropdown'>
                                <button type='button' class='btn p-0 dropdown-toggle hide-arrow' data-bs-toggle='dropdown'>
                                    <i class='ri-more-2-line'></i>
                                </button>
                                <div class='dropdown-menu'>
                                    <button class='dropdown-item btn-edit-discount' data-name='" . $r->TOD_NAME . "' data-percent='" . str_replace('%', '', $r->TOD_PERCENT) . "' data-id='" . $r->ID . "'><i class='ri ri-edit-line'></i> Edit</button>
                                    <button class='dropdown-item btn-delete-manage-discount' data-id='" . $r->ID . "'><i class='ri ri-delete-bin-line'></i> Delete</button>
                                </div>
                            </div>
                        </td>
                    </tr>";
        }
        return $result;
    }
    function addDiscountFields()
    {
        $query = $this->db->get("tbl_typediscount");
        $result = "";
        $result = '<tr>
                        <td>
                            <select class="form-select select_discount select2" required aria-label="Default select example" name="P_DISCOUNT_NAME[]">';
        $result .= '<option value="">--Select Discount--</option>';
        foreach ($query->result() as $r) {
            $data = json_encode([
                "TOD_AMOUNT" => str_replace('%', '', $r->TOD_PERCENT),
                "TOD_NAME" => $r->TOD_NAME
            ]);
            $result .= "<option value='{$data}'>{$r->TOD_NAME}</option>";
        }
        $result .= '</select>
                        </td>
                        <td>
                            <input type="text" class="form-control P_DISCOUNT_AMOUNT" name="P_DISCOUNT_AMOUNT[]" readonly required />
                        </td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="ri-more-2-line"></i>
                                </button>
                                <div class="dropdown-menu">
                                   <button class="dropdown-item btn-delete-discount"><i class="ri ri-delete-bin-line"></i> Delete</button>
                                </div>
                            </div>
                        </td>
                    </tr>';
        return $result;
    }

    function load_discount_select()
    {
        $result = "";
        $query = $this->db->get("tbl_typediscount");
        $result = '<option value="">--Select Discount--</option>';
        foreach ($query->result() as $r) {
            $data = json_encode([
                "TOD_AMOUNT" => str_replace('%', '', $r->TOD_PERCENT),
                "TOD_NAME" => $r->TOD_NAME
            ]);
            $result .= "<option value='{$data}'>{$r->TOD_NAME}</option>";
        }
        return $result;
    }
}
