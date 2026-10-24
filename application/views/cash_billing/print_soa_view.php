<!DOCTYPE html>
<html>

<head>
    <title>Print - Statement of Account</title>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
                font-size: 14px;
            }

            .separator {
                display: flex;
                justify-content: center;
                align-items: center;
                border-bottom: 2px dashed #000;
                padding: 10px 0;
                width: 100%;
                box-sizing: border-box;
                page-break-inside: avoid;
                margin-bottom: 30px;
            }

            .receipt:last-child {
                border-bottom: none;
            }
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .receipt {
            width: 100%;
            height: 50vh;
            border-bottom: 1px dashed #000;
            padding: 20px;
            box-sizing: border-box;
        }

        .title {
            font-size: 18px;
            font-weight: bold;
        }

        .line {
            margin: 5px 0;
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
            margin-bottom: 5px;
        }

        .content {
            margin-bottom: 10px;
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

<body>

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
                        |
                        <small> Contact No. <?= $row->IMS_WEB_CONTACT ?> </small><br>
                    </td>
                    <td><img src="<?= $logo2 ?>" alt="Logo 2" style="max-width: 100px;"></td>
                </center>
            </tr>
        </table>
        <h2>STATEMENT OF ACCOUNT</h2>
    </div>
    <div class="content">
        <?php
        foreach ($LoadStudentEnrolled->result() as $rows) {
        ?>
            <span style="font-size: 10px; text-align: left; margin-bottom: 15px;">Date Issued
                <?= date('Y-m-d') ?></span><br>
            <table class="table table-bordered">
                <tr>
                    <td><strong>Year Level :</strong> <?= substr($rows->ER_YEARLEVEL, 0, 3); ?></td>
                    <td><strong>Academic Term :</strong> <?= $rows->ER_SEMESTER; ?></td>
                    <td><strong>Academic Year :</strong> <?= $rows->ER_ACADEMICYEAR . '-' . ($rows->ER_ACADEMICYEAR + 1); ?>
                    </td>
                </tr>
                <tr>
                    <td><strong>Student Number :</strong> <?= $rows->ER_STUDENTID; ?></td>
                    <td><strong>Type :</strong> <?= ucfirst(strtolower(isset($rows->ER_STATUS) ? $rows->ER_STATUS : "")); ?>
                    </td>
                    <td><strong>Status :</strong>
                        <?= ucfirst(strtolower(isset($rows->ER_CLASSIFICATION) ? $rows->ER_CLASSIFICATION : "")); ?></td>
                </tr>
                <tr>
                    <td><strong>Name :</strong>
                        <?= $rows->SP_LASTNAME . ', ' .  $rows->SP_FIRSTNAME . ' ' . $rows->SP_MIDDLENAME; ?></td>
                    <td><strong>Sex :</strong> <?= ucfirst(strtolower(isset($rows->SP_GENDER) ? $rows->SP_GENDER : "")); ?>
                    </td>
                    <td><strong>Program and Major :</strong> <?= $rows->P_PCODE; ?></td>
                </tr>
            </table>

            <br>

            <div style="display:flex; gap:20px">
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
                    <br>
                    <table class="table table-bordered" style="width: 100%;">
                        <tr>
                            <th colspan="4" style="font-weight: bold;">PAYMENT HISTORY</th>
                        </tr>
                        <tr style="font-weight: 700;">
                            <td style="font-style: italic;">OR/Transaction No.</td>
                            <td style="font-style: italic;">Date Paid</td>
                            <td style="font-style: italic;">Particulars</td>
                            <td style="font-style: italic;">Amount</td>
                        </tr>

                        <?php
                        $total_paid = 0;
                        foreach ($load_soa_payments->result() as $r) {

                            $total_paid += str_replace(',', '', $r->P_AMOUNT);
                        ?>
                            <tr>
                                <td><?= $r->OR_NUM ?></td>
                                <td><?= $r->P_DATESUBMITTED ?></td>
                                <td>
                                    <?= $r->P_DESC ?><br>
                                </td>
                                <td style="text-align: end;"><?= $r->P_AMOUNT ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td colspan="3" style="text-align: end; font-weight: bold;">TOTAL PAID</td>
                            <td style="font-weight: bold; text-align: end;"><?= number_format($total_paid, 2); ?></td>
                        </tr>


                    </table>
                    <br>
                    <table style="width: 100%;">
                        <tr>
                            <td style="width: 65%;">
                                <strong>Notes:</strong>
                                <ul style="font-size:11px; margin-top:5px; padding-left:18px;">
                                    <li>This Statement of Account (SOA) reflects your current financial obligations with the
                                        school.</li>
                                    <li>Please settle your outstanding balance on or before the due dates to avoid penalties
                                        or restrictions.</li>
                                    <li>For questions regarding your SOA, contact the school's accounting or cashier's
                                        office.</li>
                                    <li>This document is system-generated and does not require a physical signature.</li>
                                </ul>
                            </td>
                            <!-- <td style="text-align: center;">
                        <strong>Confirmed by:</strong>
                        <br><br><br>
                        ___________________________<br>
                        <span style="font-size: 11px;">Signature</span>
                    </td> -->
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

                                // foreach ($get_enrollment->result() as $r) {
                                //     if ($r->ER_CLASSIFICATION === "IRREGULAR" && !empty($r->ER_SUBJECTS)) {
                                //         $subject_ids = array_map('intval', explode(',', $r->ER_SUBJECTS));
                                //         $subject_ids_str = implode(',', $subject_ids);

                                //         $get_subjects = $this->db->query("SELECT * FROM tbl_subject WHERE ID IN($subject_ids_str)");

                                //         foreach ($get_subjects->result() as $s) {
                                //             $S_SELECTPROG = $s->S_SELECTPROG;
                                //             $S_MAJOR = $s->S_MAJOR;
                                //             $S_YRLVL = $s->S_YRLVL;
                                //             $S_SEM = $s->S_SEM;
                                //             $S_UNITS = floatval($s->S_UNITS);

                                //             $get_fees = $this->db->query("
                                //                 SELECT FEES_AMOUNTPERUNIT 
                                //                 FROM tbl_fees_tuitions 
                                //                 WHERE FEES_PROGRAM = ? AND FEES_MAJOR = ? AND FEES_YEARLEVEL = ? AND FEES_SEMESTER = ?
                                //                 LIMIT 1
                                //             ", [$S_SELECTPROG, $S_MAJOR, $S_YRLVL, $S_SEM]);

                                //             if ($get_fees->num_rows() > 0) {
                                //                 $fee = $get_fees->row();
                                //                 $unit_rate = floatval(str_replace(',', '', $fee->FEES_AMOUNTPERUNIT));
                                //                 $FEES_AMOUNTPERUNIT += $unit_rate * $S_UNITS;
                                //             }
                                //         }
                                //     }
                                // }

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
                                $total_tuition = $FEES_AMOUNTPERUNIT;

                                // if ($FEES_AMOUNTPERUNIT > 0) {
                                //     $total_tuition = $FEES_AMOUNTPERUNIT;
                                // } else {
                                //     $total_tuition = isset($load_soa_fees->totalTuition) ? (float) str_replace(',', '', $load_soa_fees->totalTuition) : 0;
                                // }

                                $total_miscellaneous = isset($load_soa_fees->totalMisc) ? (float) $load_soa_fees->totalMisc : 0;
                                $total_other_fee = isset($load_soa_fees->totalOther) ? (float) $load_soa_fees->totalOther : 0;

                                // Get Account Payable for this specific enrollment
                                $ap_amount = $this->db->where("ER_UID", $rows->ID)->get("tbl_enrollment_ap")->row("AP_AMOUNT") ?? 0;

                                // Compute totals
                                $current_assessment = $total_tuition + $total_miscellaneous + $total_other_fee + str_replace(',', '', $partial_enrollment_fee);
                                $overall_total = $current_assessment + floatval($ap_amount);

                                $result_tuition = '
                                 <p>Miscellaneous Fee: ........................ <span style="float:right;">₱' . number_format($total_miscellaneous, 2) . '</span></p> 
                                 <p>Other Fees: ............................... <span style="float:right;">₱' . number_format($total_other_fee, 2) . '</span></p>
                                 <p>Tuition Fee: .............................. <span style="float:right;">₱' . number_format($total_tuition, 2) . '</span></p>
                                 <p>Enrollment Fee/Downpayment: ........... <span style="float:right;">₱' . $partial_enrollment_fee . '</span></p>';

                                if ($ap_amount > 0) {
                                    $result_tuition .= '<p style="color:#b8860b;">Previous Balance (AP): ................... <span style="float:right;">₱' . number_format($ap_amount, 2) . '</span></p>';
                                }

                                $result_tuition .= '<p><span style="font-weight:bold">TOTAL ASSESSMENT:</span> <span style="float:right; font-size:13px; font-weight:bold;">₱' . number_format($overall_total, 2) . '</span></p>';
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
                                            echo '<p><small>***' . $voucher->D_DESC . '</small>  <span style="float:right;"> - (₱' . number_format($voucher_amount, 2) . ')</span></p>';
                                        }
                                        $voucher_available = true;
                                    }
                                }
                                if ($voucher_available == false) {
                                    echo "<small>***Not Available</small>";
                                }
                                ?>
                                <p style="margin-top: 10px;  text-align:start;"><span style="font-weight:bold;">PAYMENT
                                        REMAINING:</span></p>

                                <?php
                                $balance_due = ($overall_total - $total_voucher) - $total_paid;
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
                                    $each_amount = !empty($unpaidStages) ? $balance_due / count($unpaidStages) : 0;

                                    // Show Downpayment only if not paid
                                    if (!in_array("Downpayment", $paidDescriptions) && $partial_enrollment_fee > 0) {
                                        $enrollment_fee_amount = str_replace(',', '', $partial_enrollment_fee);
                                        echo '<p><strong><span>Downpayment</span> <span style="float:right;">' . number_format($enrollment_fee_amount, 2) . '</span></strong></p>';
                                    }

                                    // Display unpaid stages
                                    foreach ($unpaidStages as $stage) {
                                        if ($stage == "Forced Deduction") continue;
                                        echo '<p><span>' . $stage . '</span> <span style="float:right;">' . number_format($each_amount, 2) . '</span></p>';
                                    }
                                }
                                ?>
                                <p style="margin-top: 10px;  text-align:start;"><span style="font-weight:bold;">BALANCE
                                        DUE:</span> <span
                                        style="float:right; font-size:15px; font-weight:bold;">₱<?= number_format($balance_due, 2) ?></span>
                                </p>
                            </td>
                        </tr>
                    </table>


                </div>
            </div>


        <?php
        }
        ?>

    </div>







    <script>
        window.addEventListener("load", function() {
            window.print();
        });

        window.addEventListener("afterprint", function() {
            window.close();
        });
    </script>


</body>

</html>