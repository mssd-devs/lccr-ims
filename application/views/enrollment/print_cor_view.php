<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print - Certificate of Registration</title>
    <style>
        @media print {
            @page {
                size: portrait;
                margin: 5mm 8mm 5mm 8mm;
            }

            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
                background: #ffffff !important;
                padding: 0 !important;
                margin: 0 !important;
            }

            .no-print {
                display: none !important;
            }
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Times New Roman', Times, serif;
            margin: 0;
            padding: 10px;
            color: #000000;
            background: #ffffff;
        }

        .cor-page {
            max-width: 850px;
            margin: 0 auto;
            background: #ffffff;
        }

        .cor-wrapper {
            position: relative;
            background: #ffffff;
            padding: 6px 15px;
            margin-bottom: 5px;
            page-break-inside: avoid;
        }

        .watermark-seal {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 450px;
            max-width: 95%;
            opacity: 0.13;
            z-index: 0;
            pointer-events: none;
        }

        .cor-content {
            position: relative;
            z-index: 1;
        }

        .header-section {
            text-align: center;
            margin-bottom: 6px;
            position: relative;
        }

        .copy-label {
            position: absolute;
            top: 0;
            right: 0;
            font-family: Arial, sans-serif;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #444;
            border: 1px solid #666;
            padding: 2px 6px;
            border-radius: 3px;
        }

        .school-name {
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #000000;
            margin: 0 0 1px 0;
        }

        .school-address {
            font-family: 'Times New Roman', Times, serif;
            font-size: 11px;
            color: #000000;
            margin: 0;
        }

        .doc-title {
            font-family: 'Arial Black', 'Impact', 'Trebuchet MS', sans-serif;
            font-size: 20px;
            font-weight: 900;
            color: #3b76ad;
            text-align: center;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin: 4px 0 6px 0;
            line-height: 1.1;
        }

        .student-info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
            font-size: 11px;
            line-height: 1.45;
            font-family: 'Times New Roman', Times, serif;
        }

        .student-info-table td {
            border: none !important;
            padding: 1px 0;
            vertical-align: top;
        }

        .course-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5px;
            margin-bottom: 10px;
            font-family: Arial, Helvetica, sans-serif;
        }

        .course-table th {
            background-color: #000000 !important;
            color: #ffffff !important;
            border: 1px solid #000000 !important;
            padding: 3px 3px;
            font-weight: bold;
            text-align: center;
            font-size: 9.5px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .course-table td {
            border: 1px solid #000000 !important;
            padding: 2px 4px;
            font-size: 9.5px;
            color: #000000;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .fw-bold {
            font-weight: bold;
        }

        .signature-section {
            margin-top: 10px;
            font-size: 11px;
            font-family: 'Times New Roman', Times, serif;
        }

        .signature-box {
            display: inline-block;
            text-align: center;
            margin-top: 6px;
        }

        .signature-line {
            font-weight: bold;
            text-decoration: underline;
            font-size: 12px;
            display: block;
        }

        .divider-cut {
            border-top: 1px dashed #888;
            margin: 10px 0 12px 0;
            position: relative;
            text-align: center;
        }

        .divider-cut-text {
            font-size: 8px;
            font-family: Arial, sans-serif;
            color: #666;
            background: #fff;
            padding: 0 10px;
            position: relative;
            top: -7px;
            display: inline-block;
        }
    </style>
</head>

<body>

    <?php
    $logo1 = '';
    $logo2 = '';
    $school_name = 'LANAO COLLEGE OF CRIMINOLOGY, INC.';
    $school_address = 'Masiu, Lanao Del Sur';

    foreach ($query->result() as $row) {
        $logo1 = base_url('assets/img/' . $row->IMS_WEB_IMG);
        $logo2 = base_url('assets/img/' . $row->IMS_WEB_IMG2);
        if (!empty($row->IMS_WEB_NOS)) {
            $school_name = $row->IMS_WEB_NOS;
            if (strpos(strtoupper($school_name), 'INC') === false && strpos(strtoupper($school_name), 'LANAO COLLEGE OF CRIMINOLOGY') !== false) {
                $school_name .= ', INC.';
            }
        }
        if (!empty($row->IMS_WEB_ADDRESS)) {
            $school_address = $row->IMS_WEB_ADDRESS;
        }
    }

    $sig_row = $this->db->get("tbl_signatories")->row();
    $sig_reg = ($sig_row && !empty($sig_row->SIG_REG)) ? $sig_row->SIG_REG : 'Hania M. Sultan';

    $copies = [
        'STUDENT COPY',
        'REGISTRAR COPY'
    ];
    ?>

    <div class="cor-page">
        <?php foreach ($copies as $copy_index => $copy_title): ?>
            <div class="cor-wrapper">
                <!-- Watermark Seal -->
                <?php if (!empty($logo2)): ?>
                    <img src="<?= $logo2 ?>" alt="Watermark Seal" class="watermark-seal">
                <?php endif; ?>

                <div class="cor-content">
                    <!-- Header Section -->
                    <div class="header-section">
                        <!-- <span class="copy-label"><?= $copy_title ?></span> -->
                        <div class="school-name"><?= htmlspecialchars($school_name) ?></div>
                        <div class="school-address"><?= htmlspecialchars($school_address) ?></div>
                        <div class="doc-title">CERTIFICATE OF REGISTRATION</div>
                    </div>

                    <!-- Student Profile Section -->
                    <?php foreach ($LoadStudentEnrolled->result() as $rows): ?>
                        <table class="student-info-table">
                            <tr>
                                <td style="width: 60%;">
                                    <div>Name: <?= htmlspecialchars(trim($rows->SP_FIRSTNAME . ' ' . $rows->SP_MIDDLENAME . ' ' . $rows->SP_LASTNAME)) ?></div>
                                    <div>Course: <?= htmlspecialchars($rows->ER_PROGRAM) ?><?php if (!empty($rows->ER_MAJOR)) {
                                                                                                echo ' major in ' . htmlspecialchars($rows->ER_MAJOR);
                                                                                            } ?></div>
                                    <div>Year level: <?= htmlspecialchars($rows->ER_YEARLEVEL) ?></div>
                                    <div>Gender: <?= htmlspecialchars($rows->SP_GENDER) ?></div>
                                </td>
                                <td style="width: 40%;">
                                    <div>I.D Number: <?= htmlspecialchars($rows->ER_STUDENTID) ?></div>
                                    <div>School Year: <?= htmlspecialchars($rows->ER_ACADEMICYEAR) . '-' . htmlspecialchars((int)$rows->ER_ACADEMICYEAR + 1) ?></div>
                                    <div>Semester: <?= htmlspecialchars($rows->ER_SEMESTER) ?></div>
                                </td>
                            </tr>
                        </table>
                    <?php endforeach; ?>

                    <!-- Enrolled Subjects Table -->
                    <table class="course-table">
                        <thead>
                            <tr>
                                <th style="width: 12%;">Course Code</th>
                                <th style="width: 36%;">Course Title</th>
                                <th style="width: 20%;">Class Schedule</th>
                                <th style="width: 8%;">Section</th>
                                <th style="width: 14%;">Instructor</th>
                                <th style="width: 5%;">Room</th>
                                <th style="width: 5%;">Unit</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $totalUnits = 0;
                            foreach ($LoadEditSubjects->result() as $r) {
                                $totalUnits += floatval($r->S_UNITS);
                                $sched = trim(($r->SC_DAY ?: '') . ' ' . ($r->SC_STARTTIME ?: '') . ($r->SC_ENDTIME ? '-' . $r->SC_ENDTIME : ''));
                                if (empty($sched)) {
                                    $sched = 'TBA';
                                }
                            ?>
                                <tr>
                                    <td class="fw-bold text-center"><?= htmlspecialchars($r->S_SCODE) ?></td>
                                    <td class="text-left"><?= htmlspecialchars($r->S_SDESCRIPTION) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($sched) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($r->SC_SECTION) ?></td>
                                    <td class="text-center"><?= htmlspecialchars($r->SC_FACULTY ?: 'TBA') ?></td>
                                    <td class="text-center"><?= htmlspecialchars($r->SC_ROOM ?: 'TBA') ?></td>
                                    <td class="text-center fw-bold"><?= htmlspecialchars($r->S_UNITS) ?></td>
                                </tr>
                            <?php } ?>
                            <tr>
                                <td colspan="6" class="fw-bold text-left" style="padding-left: 6px;">Total Units Enrolled:</td>
                                <td class="text-center fw-bold"><?= $totalUnits ?></td>
                            </tr>
                        </tbody>
                    </table>

                    <!-- Signature Section -->
                    <div class="signature-section">
                        <div>Approved by:</div>
                        <div class="signature-box" style="margin-left: 80px;">
                            <span class="signature-line"><?= htmlspecialchars($sig_reg) ?></span>
                            <div>Registrar</div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($copy_index == 0): ?>
                <div class="divider-cut">
                    <span class="divider-cut-text">✂ ---------------------------------------------------------------------------------------------------------------------------------</span>
                </div>
            <?php endif; ?>

        <?php endforeach; ?>
    </div>

    <script>
        window.onload = function() {
            window.print();
        };
        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>

</html>