<!DOCTYPE html>
<html>

<head>
    <title>Receipt Print</title>
    <?php
    $is_exam_payment = false;
    if (isset($LoadPayments) && $LoadPayments) {
        foreach ($LoadPayments->result() as $p_row) {
            if (in_array($p_row->P_DESC, ["Prelim", "Midterm", "Pre-Final", "Final"])) {
                $is_exam_payment = true;
                break;
            }
        }
    }
    ?>
    <style>
        @media print {
            @page {
                size: portrait;
                margin: 10mm;
            }
            body {
                margin: 0;
                padding: 0;
                font-size: 11px;
            }
            .receipt-container {
                <?php if ($is_exam_payment): ?>
                page-break-after: always;
                border-bottom: none !important;
                <?php else: ?>
                page-break-after: avoid;
                margin-bottom: 30px;
                border-bottom: 2px dashed #000 !important;
                padding-bottom: 30px;
                <?php endif; ?>
                height: auto;
                page-break-inside: avoid;
                box-sizing: border-box;
            }
            .receipt-container:last-of-type {
                page-break-after: avoid;
                border-bottom: none !important;
                margin-bottom: 0;
                padding-bottom: 0;
            }
            .content {
                margin-bottom: 5px;
            }
            .separator {
                display: none !important;
            }
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 10px;
        }

        .receipt-container {
            padding: 15px;
            border-bottom: 2px dashed #000;
            margin-bottom: 20px;
            box-sizing: border-box;
        }

        .receipt-container:last-of-type {
            border-bottom: none;
            margin-bottom: 0;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
        }

        .header {
            text-align: center;
            margin-bottom: 5px;
        }

        .header h2 {
            margin: 5px 0 0 0;
            font-size: 15px;
            letter-spacing: 1px;
        }

        .content {
            margin-bottom: 5px;
        }

        .content table {
            width: 100%;
            border-collapse: collapse;
        }

        .content table,
        .content th,
        .content td {
            border: 1px solid black;
        }

        .content th,
        .content td {
            padding: 2px 4px;
            text-align: left;
            font-size: 10px;
            font-weight: 100;
        }

        .content th {
            font-weight: bold;
            background-color: #f8f9fa;
        }

        p {
            font-size: 10px;
            margin: 2px 0;
        }
    </style>
</head>

<body>

    <div class="receipt-container">
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
                        <td style="width: 10%;">
                            <?php if (!empty($row->IMS_WEB_IMG)): ?>
                                <img src="<?= $logo1 ?>" alt="Logo 1" style="max-height: 50px; max-width: 50px;">
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center; vertical-align: middle;">
                            <span style="font-size: 13px; font-weight: bold;"><?= $school_name ?></span><br>
                            <small style="font-size: 8px;"><?= $school_address ?></small> <br>
                            <small style="font-size: 8px;">Email: <?= strtolower($school_email) ?> | Contact No. <?= $row->IMS_WEB_CONTACT ?></small>
                        </td>
                        <td style="width: 10%; text-align: right;">
                            <?php if (!empty($row->IMS_WEB_IMG2)): ?>
                                <img src="<?= $logo2 ?>" alt="Logo 2" style="max-height: 50px; max-width: 50px;">
                            <?php endif; ?>
                        </td>
                    </center>
                </tr>
            </table>

            <h2>PAYMENT RECEIPT</h2>
        </div>
    <div class="content">
        <?php
        foreach ($LoadStudentEnrolled->result() as $rows) {
            $is_exam_payment = false;
            $exam_name = "";
            foreach ($LoadPayments->result() as $p_row) {
                if (in_array($p_row->P_DESC, ["Prelim", "Midterm", "Pre-Final", "Final"])) {
                    $is_exam_payment = true;
                    $exam_name = $p_row->P_DESC;
                    break;
                }
            }
        ?>
            <span style="font-size: 10px; text-align: left; margin-bottom: 15px;">OR/Transaction No. </span><small style="text-decoration: underline; font-weight: 600;"><?= $this->uri->segment(5); ?></small><br><br>
            <table class="table table-bordered">
                <tr>
                    <td><strong>Year Level :</strong> <?= substr($rows->ER_YEARLEVEL, 0, 3); ?></td>
                    <td><strong>Academic Term :</strong> <?= $rows->ER_SEMESTER; ?></td>
                    <td><strong>Academic Year :</strong> <?= $rows->ER_ACADEMICYEAR . '-' . ($rows->ER_ACADEMICYEAR + 1); ?></td>
                </tr>
                <tr>
                    <td><strong>Student Number :</strong> <?= $rows->ER_STUDENTID; ?></td>
                    <td><strong>Type :</strong> <?= ucfirst(strtolower($rows->ER_STATUS)); ?></td>
                    <td><strong>Status :</strong> <?= ucfirst(strtolower($rows->ER_CLASSIFICATION)); ?></td>
                </tr>
                <tr>
                    <td><strong>Name :</strong> <?= $rows->SP_LASTNAME . ', ' .  $rows->SP_FIRSTNAME . ' ' . $rows->SP_MIDDLENAME; ?></td>
                    <td><strong>Sex :</strong> <?= ucfirst(strtolower($rows->SP_GENDER)); ?></td>
                    <td><strong>Program and Major :</strong> <?= $rows->P_PCODE; ?></td>
                </tr>
            </table>

            <br>
            <table class="table table-bordered">
                <tr>
                    <th style="width: 20%;">Transaction Date</th>
                    <th>Particulars</th>
                    <th>Amount</th>
                </tr>
                <?php
                foreach ($LoadPayments->result() as $row) {
                ?>
                    <tr>
                        <td>
                            <?= $row->P_DATESUBMITTED; ?>
                        </td>
                        <td>
                            <?php 
                            $is_specific_fee = !in_array($row->P_DESC, ["Downpayment", "Prelim", "Midterm", "Pre-Final", "Final", "Full Payment", "Forced Deduction"]);
                            if ($is_specific_fee) {
                                echo '<strong>PAYMENT FOR SPECIFIC FEE:</strong><br>';
                                echo '<span style="font-size: 13px; font-weight: bold; color: #1b5e20;">' . htmlspecialchars($row->P_DESC) . '</span>';
                            } else {
                                echo '<span style="font-weight: bold;">' . htmlspecialchars($row->P_DESC) . '</span>';
                            }
                            echo ($row->P_AMOUNT == 0) ? " <small style='color:red;'>(Promissory Note)</small>" : "";
                            ?>
                            <div style="text-align: center; margin-top: 10px; border-top: 1px dashed #ddd; padding-top: 5px;"><small style="color: #888;">** Nothing Follows **</small></div>
                        </td>
                        <td style="text-align: right; font-weight: bold;">
                            ₱<?= $row->P_AMOUNT; ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="text-align: right; font-weight: bold;">Total Paid:</td>
                        <td style="text-align: right; font-weight: bold; color: #2e7d32;">₱<?= $row->P_AMOUNT; ?></td>
                    </tr>

                <?php
                }
                ?>
            </table>

            <?php if ($is_exam_payment): ?>
                <br>
                <div style="margin-top: 10px; margin-bottom: 10px; page-break-inside: avoid;">
                    <h4 style="margin: 0 0 5px 0; font-size: 12px; text-transform: uppercase; font-weight: bold; color: #1b5e20;">Enrolled Subjects (Permit for <?= htmlspecialchars($exam_name) ?> Exam)</h4>
                    <table class="table table-bordered" style="width: 100%; font-size: 10px;">
                        <thead>
                            <tr style="background-color: #f5f5f5;">
                                <th style="width: 25%; font-weight: bold;">Subject Code</th>
                                <th style="font-weight: bold;">Subject Title</th>
                                <th style="width: 10%; font-weight: bold; text-align: center;">Units</th>
                                <th style="width: 35%; font-weight: bold; text-align: center;">Proctor's Name & Signature</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $subject_ids = array_map('intval', explode(',', $rows->ER_SUBJECTS));
                            if (!empty($subject_ids)) {
                                $subject_ids_str = implode(',', $subject_ids);
                                $get_subjects = $this->db->query("SELECT * FROM tbl_subject WHERE ID IN($subject_ids_str)");
                                foreach ($get_subjects->result() as $subj) {
                                    echo '<tr>';
                                    echo '<td>' . htmlspecialchars($subj->S_SCODE) . '</td>';
                                    echo '<td>' . htmlspecialchars($subj->S_SDESCRIPTION) . '</td>';
                                    echo '<td style="text-align: center;">' . htmlspecialchars($subj->S_UNITS) . '</td>';
                                    echo '<td style="height: 20px; text-align: center; vertical-align: bottom;"><small style="color: #bbb;">_____________________</small></td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="4" style="text-align: center;">No enrolled subjects found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <table style="width: 100%; margin-top: 25px; page-break-inside: avoid;">
                <tr>
                    <td style="width: 75%;">
                        <strong>Notes:</strong>
                        <ul style="font-size:11px; margin-top:5px; padding-left:18px;">
                            <li>Please keep this receipt for your records.</li>
                            <li>All payments are non-refundable unless otherwise stated by the school policy.</li>
                            <li>For inquiries or concerns, contact the school cashier's office.</li>
                            <li>This receipt is system-generated and does not require a physical signature.</li>
                        </ul>
                    </td>
                    <td style="text-align: center; width: 25%; vertical-align: bottom;">
                        <strong>Confirmed by:</strong>
                        <br><br><br>
                        ___________________________<br>
                        <span style="font-size: 9px; color: #666;">Cashier Signature</span>
                    </td>
                </tr>
            </table>
        <?php
        }
        ?>

    </div>
    </div>
    <div class="separator"></div>

    <div class="receipt-container">
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
                        <td style="width: 10%;">
                            <?php if (!empty($row->IMS_WEB_IMG)): ?>
                                <img src="<?= $logo1 ?>" alt="Logo 1" style="max-height: 50px; max-width: 50px;">
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center; vertical-align: middle;">
                            <span style="font-size: 13px; font-weight: bold;"><?= $school_name ?></span><br>
                            <small style="font-size: 8px;"><?= $school_address ?></small> <br>
                            <small style="font-size: 8px;">Email: <?= strtolower($school_email) ?> | Contact No. <?= $row->IMS_WEB_CONTACT ?></small>
                        </td>
                        <td style="width: 10%; text-align: right;">
                            <?php if (!empty($row->IMS_WEB_IMG2)): ?>
                                <img src="<?= $logo2 ?>" alt="Logo 2" style="max-height: 50px; max-width: 50px;">
                            <?php endif; ?>
                        </td>
                    </center>
                </tr>
            </table>

        <h2>PAYMENT RECEIPT</h2>
    </div>
    <div class="content">
        <?php
        foreach ($LoadStudentEnrolled->result() as $rows) {
            $is_exam_payment = false;
            $exam_name = "";
            foreach ($LoadPayments->result() as $p_row) {
                if (in_array($p_row->P_DESC, ["Prelim", "Midterm", "Pre-Final", "Final"])) {
                    $is_exam_payment = true;
                    $exam_name = $p_row->P_DESC;
                    break;
                }
            }
        ?>
            <span style="font-size: 10px; text-align: left; margin-bottom: 15px;">OR/Transaction No. </span><small style="text-decoration: underline; font-weight: 600;"><?= $this->uri->segment(5); ?></small><br><br>
            <table class="table table-bordered">
                <tr>
                    <td><strong>Year Level :</strong> <?= substr($rows->ER_YEARLEVEL, 0, 3); ?></td>
                    <td><strong>Academic Term :</strong> <?= $rows->ER_SEMESTER; ?></td>
                    <td><strong>Academic Year :</strong> <?= $rows->ER_ACADEMICYEAR . '-' . ($rows->ER_ACADEMICYEAR + 1); ?></td>
                </tr>
                <tr>
                    <td><strong>Student Number :</strong> <?= $rows->ER_STUDENTID; ?></td>
                    <td><strong>Type :</strong> <?= ucfirst(strtolower($rows->ER_STATUS)); ?></td>
                    <td><strong>Status :</strong> <?= ucfirst(strtolower($rows->ER_CLASSIFICATION)); ?></td>
                </tr>
                <tr>
                    <td><strong>Name :</strong> <?= $rows->SP_LASTNAME . ', ' .  $rows->SP_FIRSTNAME . ' ' . $rows->SP_MIDDLENAME; ?></td>
                    <td><strong>Sex :</strong> <?= ucfirst(strtolower($rows->SP_GENDER)); ?></td>
                    <td><strong>Program and Major :</strong> <?= $rows->P_PCODE; ?></td>
                </tr>
            </table>

            <br>
            <table class="table table-bordered">
                <tr>
                    <th style="width: 20%;">Transaction Date</th>
                    <th>Particulars</th>
                    <th>Amount</th>
                </tr>
                <?php
                foreach ($LoadPayments->result() as $row) {
                ?>
                    <tr>
                        <td>
                            <?= $row->P_DATESUBMITTED; ?>
                        </td>
                        <td>
                            <?php 
                            $is_specific_fee = !in_array($row->P_DESC, ["Downpayment", "Prelim", "Midterm", "Pre-Final", "Final", "Full Payment", "Forced Deduction"]);
                            if ($is_specific_fee) {
                                echo '<strong>PAYMENT FOR SPECIFIC FEE:</strong><br>';
                                echo '<span style="font-size: 13px; font-weight: bold; color: #1b5e20;">' . htmlspecialchars($row->P_DESC) . '</span>';
                            } else {
                                echo '<span style="font-weight: bold;">' . htmlspecialchars($row->P_DESC) . '</span>';
                            }
                            echo ($row->P_AMOUNT == 0) ? " <small style='color:red;'>(Promissory Note)</small>" : "";
                            ?>
                            <div style="text-align: center; margin-top: 10px; border-top: 1px dashed #ddd; padding-top: 5px;"><small style="color: #888;">** Nothing Follows **</small></div>
                        </td>
                        <td style="text-align: right; font-weight: bold;">
                            ₱<?= $row->P_AMOUNT; ?>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2" style="text-align: right; font-weight: bold;">Total Paid:</td>
                        <td style="text-align: right; font-weight: bold; color: #2e7d32;">₱<?= $row->P_AMOUNT; ?></td>
                    </tr>

                <?php
                }
                ?>
            </table>

            <?php if ($is_exam_payment): ?>
                <br>
                <div style="margin-top: 10px; margin-bottom: 10px; page-break-inside: avoid;">
                    <h4 style="margin: 0 0 5px 0; font-size: 12px; text-transform: uppercase; font-weight: bold; color: #1b5e20;">Enrolled Subjects (Permit for <?= htmlspecialchars($exam_name) ?> Exam)</h4>
                    <table class="table table-bordered" style="width: 100%; font-size: 10px;">
                        <thead>
                            <tr style="background-color: #f5f5f5;">
                                <th style="width: 25%; font-weight: bold;">Subject Code</th>
                                <th style="font-weight: bold;">Subject Title</th>
                                <th style="width: 10%; font-weight: bold; text-align: center;">Units</th>
                                <th style="width: 35%; font-weight: bold; text-align: center;">Proctor's Name & Signature</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $subject_ids = array_map('intval', explode(',', $rows->ER_SUBJECTS));
                            if (!empty($subject_ids)) {
                                $subject_ids_str = implode(',', $subject_ids);
                                $get_subjects = $this->db->query("SELECT * FROM tbl_subject WHERE ID IN($subject_ids_str)");
                                foreach ($get_subjects->result() as $subj) {
                                    echo '<tr>';
                                    echo '<td>' . htmlspecialchars($subj->S_SCODE) . '</td>';
                                    echo '<td>' . htmlspecialchars($subj->S_SDESCRIPTION) . '</td>';
                                    echo '<td style="text-align: center;">' . htmlspecialchars($subj->S_UNITS) . '</td>';
                                    echo '<td style="height: 20px; text-align: center; vertical-align: bottom;"><small style="color: #bbb;">_____________________</small></td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="4" style="text-align: center;">No enrolled subjects found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <table style="width: 100%; margin-top: 25px; page-break-inside: avoid;">
                <tr>
                    <td style="width: 75%;">
                        <strong>Notes:</strong>
                        <ul style="font-size:11px; margin-top:5px; padding-left:18px;">
                            <li>Please keep this receipt for your records.</li>
                            <li>All payments are non-refundable unless otherwise stated by the school policy.</li>
                            <li>For inquiries or concerns, contact the school cashier's office.</li>
                            <li>This receipt is system-generated and does not require a physical signature.</li>
                        </ul>
                    </td>
                    <td style="text-align: center; width: 25%; vertical-align: bottom;">
                        <strong>Confirmed by:</strong>
                        <br><br><br>
                        ___________________________<br>
                        <span style="font-size: 9px; color: #666;">Cashier Signature</span>
                    </td>
                </tr>
            </table>
        <?php
        }
        ?>

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