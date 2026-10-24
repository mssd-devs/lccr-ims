<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print - Official Registration Assessment Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            width: 100%;
            max-width: 800px;
            /* margin: 0 auto; */
            margin-top: 0;
        }

        .header,
        .footer {
            text-align: center;
            margin-bottom: 20px;
        }

        .content {
            margin-bottom: 0px;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
            font-size: smaller;
        }

        .content table,
        .content th,
        .content td {
            border: 1px solid black;
        }

        p {
            font-size: 11px;
        }

        .content th,
        .content td {
            padding: 3px;
            text-align: left;
            font-size: 12px;
            font-weight: 100;
        }

        :root::after {
            content: "This is a system generated copy - Date: " attr(data-date) " Time: " attr(data-time);
            bottom: 0px;
            font-size: 8px;
            transform: rotate(0deg);
            position: fixed;
            color: gray;
            background-repeat: repeat;
            z-index: -1;
        }
    </style>
</head>
<script>
    document.documentElement.setAttribute("data-date", new Date().toLocaleDateString());
    document.documentElement.setAttribute("data-time", new Date().toLocaleTimeString());
</script>

<body>

    <div class="container">
        <div class="header">

            <table class="table" style="width: 100%;">
                <?php
                $query = $this->db->get("tbl_websettings");
                foreach ($query->result() as $row) {
                    $logo1 = base_url('assets/img/' . $row->IMS_WEB_IMG);
                    $logo2 = base_url('assets/img/' . $row->IMS_WEB_IMG2);
                    $school_name = $row->IMS_WEB_NOS;
                    $school_address = $row->IMS_WEB_ADDRESS;
                    $school_email = $row->IMS_WEB_EMAIL;
                }
                ?>
                <tr>
                    <center>
                        <td><img src="<?= $logo1 ?>" alt="Logo 1" style="max-width: 100px;"></td>
                        <td>
                            <span><b><?= $school_name ?></b></span><br>
                            <small><?= $school_address ?></small> <br><small>Email: <?= strtolower($school_email) ?></small>

                        </td>
                        <td><img src="<?= $logo2 ?>" alt="Logo 2" style="max-width: 100px;"></td>
                    </center>
                </tr>
            </table>

            <h5 style="font-weight: bold;">OFFICIAL REGISTRATION AND ASSESSMENT FORM</h5>
        </div>
        <div class="content">
            <?php
            foreach ($LoadStudentEnrolled->result() as $rows) {
            ?>
                <table class="table table-bordered">
                    <tr>
                        <td><strong>Year Level :</strong> <?= substr($rows->ER_YEARLEVEL, 0, 3); ?></td>
                        <td><strong>Academic Term :</strong> <?= $rows->ER_SEMESTER; ?></td>
                        <td><strong>Academic Year :</strong> <?= $rows->ER_ACADEMICYEAR . '-' . ($rows->ER_ACADEMICYEAR + 1); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Student Number :</strong> <?= $rows->ER_STUDENTID; ?></td>
                        <td><strong>Type :</strong> <?= isset($rows->ER_STATUS) ? ucfirst(strtolower($rows->ER_STATUS)) : ''; ?></td>
                        <td><strong>Status :</strong> <?= isset($rows->ER_CLASSIFICATION) ? ucfirst(strtolower($rows->ER_CLASSIFICATION)) : ''; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2"><strong>Full Name :</strong> <?= $rows->SP_LASTNAME . ' ' .  $rows->SP_FIRSTNAME . ' ' . $rows->SP_MIDDLENAME; ?></td>
                        <td><strong>Sex :</strong> <?= isset($rows->SP_GENDER) ? ucfirst(strtolower($rows->SP_GENDER)) : ""; ?></td>
                    </tr>
                    <tr>
                        <td><strong>Program and Major :</strong> <?= $rows->P_PCODE; ?></td>
                        <td><strong>Contact No. :</strong> <?= $rows->SP_CPNUMBER; ?></td>
                        <td><strong>Age :</strong>
                            <?= !empty($rows->SP_BIRTHDAY) && strtotime($rows->SP_BIRTHDAY) ? (new DateTime())->diff(new DateTime($rows->SP_BIRTHDAY))->y : "" ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3"><strong>Complete Address :</strong> <?= "$rows->SP_STRT, $rows->brgyDesc, $rows->citymunDesc, $rows->provDesc, $rows->regDesc"; ?></td>
                    </tr>
                </table>
                <br>
                <table class="table table-bordered">
                    <tr>
                        <td colspan="10" style="text-align: center; font-weight: bold;">
                            ACADEMIC
                        </td>
                    </tr>
                    <tr>
                        <th>Subject Code</th>
                        <th>Subject Description</th>
                        <th>Modality</th>
                        <th>Time</th>
                        <th>Days</th>
                        <th>Room</th>
                        <th>Section</th>
                        <th>Units</th>
                        <th>Instructor</th>
                        <th>Pre-Requisite</th>
                    </tr>

                    <?php
                    $num = 0;
                    foreach ($LoadEditSubjects->result() as $r) {
                        $num++;
                        echo '<tr>';
                        echo '<td>' . htmlspecialchars($r->S_SCODE) . '</td>';
                        echo '<td>' . htmlspecialchars($r->S_SDESCRIPTION) . '</td>';
                        echo '<td>' . htmlspecialchars($r->SC_TEACHMODELS == "FACE TO FACE" ? "F2F" : $r->SC_TEACHMODELS) . '</td>';
                        echo '<td>' . date("h:i A", strtotime($r->SC_STARTTIME)) . '-' . date("h:i A", strtotime($r->SC_ENDTIME)) . '</td>';
                        echo '<td>' . htmlspecialchars($r->SC_DAY) . '</td>';
                        echo '<td>' . htmlspecialchars($r->SC_ROOM) . '</td>';
                        echo '<td>' . htmlspecialchars($r->SC_SECTION) . '</td>';
                        echo '<td>' . htmlspecialchars($r->S_UNITS) . '</td>';
                        echo '<td>' . htmlspecialchars($r->SC_FACULTY) . '</td>';
                        echo '<td>' . htmlspecialchars($r->S_PREREQ) . '</td>';
                        echo '</tr>';
                    }
                    ?>
                </table>
                <br>
                <div style="display:flex; gap:20px; font-size:8px;">
                    <?php
                    $total_paid = 0;
                    $previous_balance = 0;
                    $total_voucher = 0;
                    ?>
                    <div style="width: 70%;">
                        <table class="table table-bordered" style="width: 100%; height:fit-content;">
                            <tr>
                                <td style="font-weight: bolder;">
                                    FINANCIAL BREAKDOWN
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <span style="font-weight: bold;">Miscellaneous Fee</span><br>
                                    <?php
                                    $totalMisc = 0;
                                    foreach ($LoadMiscFee->result() as $r) {
                                        $totalMisc += str_replace(',', '', $r->FEES_MISC_AMOUNT);
                                    ?>
                                        <div style="display: flex; justify-content: space-between;">
                                            <span><?= ucwords(strtolower($r->FEES_MISC_DESC)) ?></span>
                                            <span><?= $r->FEES_MISC_AMOUNT ?></span>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div style="display: flex; justify-content: space-between; font-weight: bold;">
                                        <span>Total</span>
                                        <span><?= number_format($totalMisc, 2) ?></span>
                                    </div>
                                    <div style="border-bottom: 1px dashed #000; margin: 8px 0;"></div>
                                    <span style="font-weight: bold;">Others Fee</span><br>
                                    <?php
                                    $totalOthers = 0;
                                    foreach ($LoadOthersFee->result() as $r) {
                                        $totalOthers += str_replace(',', '', $r->FEES_OTHER_AMOUNT);
                                    ?>
                                        <div style="display: flex; justify-content: space-between;">
                                            <span><?= ucwords(strtolower($r->FEES_OTHER_DESC)) ?></span>
                                            <span><?= $r->FEES_OTHER_AMOUNT ?></span>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                    <div style="display: flex; justify-content: space-between; font-weight: bold;">
                                        <span>Total</span>
                                        <span><?= number_format($totalOthers, 2) ?></span>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <?php
                        $total_paid = 0;
                        foreach ($load_soa_payments->result() as $r) {
                            $total_paid += str_replace(',', '', $r->P_AMOUNT);
                        }
                        ?>
                        <table class="table table-bordered" style="width: 100%; margin-top:10px; height:fit-content;">
                            <tr>
                                <td>
                                    <p style="text-align: start;">
                                        <span style="font-weight: bold;">REMARKS</span>
                                        **This document serves as the official registration and assessment form for the current academic term. Please verify all information and fees. For any discrepancies or concerns, contact the Registrar's Office.
                                    </p>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div style="width: 40%;">
                        <table class="table table-bordered" style="width: 100%; height:fit-content;">
                            <tr>
                                <th style="font-weight: bolder;" colspan="">FEE BREAKDOWN</th>
                            </tr>
                            <tr>
                                <td class="px-0 py-6 w-px-100">
                                    <?php
                                    $partial_enrollment_fee = $this->db->get("tbl_websettings")->row("IMS_WEB_ENROLLMENT_FEE") ?? 0;

                                    $FEES_AMOUNTPERUNIT = 0;

                                    // Get enrollment data
                                    $get_enrollment = $this->db->where("ER_TRANSNO", $this->uri->segment(5))->get("tbl_enrollment");

                                    foreach ($get_enrollment->result() as $r) {
                                        if ($r->ER_CLASSIFICATION === "IRREGULAR" && !empty($r->ER_SUBJECTS)) {
                                            $subject_ids = array_map('intval', explode(',', $r->ER_SUBJECTS));
                                            $subject_ids_str = implode(',', $subject_ids);

                                            $get_subjects = $this->db->query("SELECT * FROM tbl_subject WHERE ID IN($subject_ids_str)");

                                            foreach ($get_subjects->result() as $s) {
                                                $S_SELECTPROG = $s->S_SELECTPROG;
                                                $S_MAJOR = $s->S_MAJOR;
                                                $S_YRLVL = $s->S_YRLVL;
                                                $S_SEM = $s->S_SEM;
                                                $S_UNITS = floatval($s->S_UNITS);

                                                $get_fees = $this->db->query("
                                                    SELECT FEES_AMOUNTPERUNIT 
                                                    FROM tbl_fees_tuitions 
                                                    WHERE FEES_PROGRAM = ? AND FEES_MAJOR = ? AND FEES_YEARLEVEL = ? AND FEES_SEMESTER = ?
                                                    LIMIT 1
                                                ", [$S_SELECTPROG, $S_MAJOR, $S_YRLVL, $S_SEM]);

                                                if ($get_fees->num_rows() > 0) {
                                                    $fee = $get_fees->row();
                                                    $unit_rate = floatval(str_replace(',', '', $fee->FEES_AMOUNTPERUNIT));
                                                    $FEES_AMOUNTPERUNIT += $unit_rate * $S_UNITS;
                                                }
                                            }
                                        }
                                    }

                                    if ($FEES_AMOUNTPERUNIT > 0) {
                                        $total_tuition = $FEES_AMOUNTPERUNIT;
                                    } else {
                                        $total_tuition = isset($load_soa_fees->totalTuition) ? (float) str_replace(',', '', $load_soa_fees->totalTuition) : 0;
                                    }

                                    // Ensure valid data is fetched

                                    $total_miscellaneous = isset($load_soa_fees->totalMisc) ? (float) $load_soa_fees->totalMisc : 0;
                                    $total_other_fee = isset($load_soa_fees->totalOther) ? (float) $load_soa_fees->totalOther : 0;

                                    // Compute totals
                                    $overall_total = $total_tuition + $total_miscellaneous + $total_other_fee + str_replace(',', '', $partial_enrollment_fee);

                                    $result_tuition = '
                        <p>Miscellaneous Fee: ........................ <span style="float:right;">₱' . number_format($total_miscellaneous, 2) . '</span></p> 
                        <p>Other Fees: ............................... <span style="float:right;">₱' . number_format($total_other_fee, 2) . '</span></p>
                        <p>Tuition Fee: .............................. <span style="float:right;">₱' . number_format($total_tuition, 2) . '</span></p>
                        <p>Enrollment Fee/Downpayment: ........... <span style="float:right;">₱' . $partial_enrollment_fee . '</span></p>
                        
                        <p><span style="font-weight:bold">TOTAL ASSESSMENT:</span> <span style="float:right; font-size:13px; font-weight:bold;">₱' . number_format($overall_total, 2) . '</span></p>';
                                    echo $result_tuition;
                                    ?>

                                    <?php
                                    $voucher_available = false;
                                    echo '<p style="margin-top: 10px;  text-align:center;"><span style="font-weight:bold;">*** Voucher/Discount ***</span></p>';
                                    foreach ($load_soa_payments->result() as $r) {

                                        $get_exists_voucher = $this->db->query("SELECT * FROM tbl_payment_discount WHERE P_VOUCHERNO = '" . $r->P_VOUCHERNO . "'");

                                        if ($get_exists_voucher->num_rows() > 0) {

                                            foreach ($get_exists_voucher->result() as $voucher) {
                                                $voucher_amount = str_replace(',', '', $voucher->D_AMOUNT);
                                                $total_voucher += $voucher_amount;
                                                echo '<small>***' . $voucher->D_DESC . '</small>  <span style="float:right;"> - (₱' . number_format($voucher_amount, 2) . ')</span></p>';
                                            }
                                            $voucher_available = true;
                                        }
                                    }
                                    if ($voucher_available == false) {
                                        echo "<small>***Not Available</small>";
                                    }
                                    ?>
                                    <p style="margin-top: 10px;  text-align:start;"><span style="font-weight:bold;">PAYMENT REMAINING:</span></p>

                                    <?php
                                    $previous_balance = ($overall_total - $total_voucher) - $total_paid;
                                    $transactionId = $this->uri->segment(5);
                                    $paidDescriptions = [];

                                    $payments = $this->db->where("ER_TRANSNO", $transactionId)->get("tbl_payment");

                                    foreach ($payments->result() as $payment) {
                                        $paidDescriptions[] = $payment->P_DESC;
                                    }

                                    // Wrap everything in a conditional to avoid echoing anything if "Full Payment" was already made
                                    if (!in_array("Full Payment", $paidDescriptions)) {

                                        // Define exam stages
                                        $allStages = ["Prelim", "Midterm", "Pre-Final", "Final"];
                                        $unpaidStages = array_diff($allStages, $paidDescriptions);

                                        // Calculate per-stage amount
                                        $each_amount = !empty($unpaidStages) ? $previous_balance / count($unpaidStages) : 0;

                                        // Show Downpayment only if not paid
                                        if (!in_array("Downpayment", $paidDescriptions) && $partial_enrollment_fee > 0) {
                                            $enrollment_fee_amount = str_replace(',', '', $partial_enrollment_fee);
                                            echo '<p><strong><span>Downpayment</span> <span style="float:right;">' . number_format($enrollment_fee_amount, 2) . '</span></strong></p>';
                                        }

                                        // Display unpaid stages
                                        foreach ($unpaidStages as $stage) {
                                            echo '<p><span>' . $stage . '</span> <span style="float:right;">' . number_format($each_amount, 2) . '</span></p>';
                                        }
                                    }
                                    ?>
                                    <p style="margin-top: 10px;  text-align:start;"><span style="font-weight:bold;">BALANCE DUE:</span> <span style="float:right; font-size:15px; font-weight:bold;">₱<?= number_format($previous_balance, 2) ?></span></p>
                                </td>
                            </tr>
                        </table>


                    </div>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="footer">

        </div>
    </div>

    <script>
        window.onload = function() {
            document.body.style.margin = "0";
            window.print();
        };
        window.onafterprint = function() {
            window.close();
        };
    </script>


</body>

</html>