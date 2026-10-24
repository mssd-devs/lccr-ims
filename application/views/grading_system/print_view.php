<style>
    @media print {
        body * {
            visibility: hidden !important;
        }

        .print-area,
        .print-area * {
            visibility: visible !important;
        }

        .print-area {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            background: white !important;
        }

        body {
            margin: 0;
            padding: 0;
            background: none !important;
        }

        :root::after {
            display: none !important;
        }

        @page {
            size: landscape;
            margin: 1.5cm;
        }
    }

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        color: #000;
        background-color: #fff;
    }

    .print-area {
        padding: 10px;
        box-sizing: border-box;
    }

    .header-table {
        width: 100%;
        margin-bottom: 20px;
        border: none !important;
    }

    .header-table td {
        border: none !important;
        padding: 5px !important;
    }

    .school-title {
        font-size: 20px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .school-subtitle {
        font-size: 12px;
        color: #333;
    }

    .doc-title {
        text-align: center;
        margin-top: 10px;
        margin-bottom: 20px;
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 2px solid #000;
        padding-bottom: 5px;
    }

    .info-table {
        width: 100%;
        border-collapse: collapse !important;
        margin-bottom: 20px;
    }

    .info-table td {
        padding: 5px 8px !important;
        font-size: 13px !important;
        border: 1px solid #ddd !important;
        background: none !important;
    }

    .grades-table {
        width: 100%;
        border-collapse: collapse !important;
        margin-bottom: 30px;
    }

    .grades-table th,
    .grades-table td {
        border: 1px solid #000 !important;
        padding: 6px 4px !important;
        font-size: 11px !important;
        text-align: center;
        color: #000 !important;
        background: none !important;
    }

    .grades-table th {
        font-weight: bold;
        background-color: #f2f2f2 !important;
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
    }

    .grades-table td.text-start {
        text-align: left;
        padding-left: 8px !important;
    }

    .signature-section {
        width: 100%;
        margin-top: 40px;
        border: none !important;
    }

    .signature-section td {
        border: none !important;
        padding: 10px !important;
        font-size: 13px;
        vertical-align: top;
    }

    .sig-line {
        margin-top: 50px;
        border-top: 1px solid #000;
        width: 250px;
        display: inline-block;
    }

    .text-bold {
        font-weight: bold;
    }
</style>

<div class="print-area">
    <?php
    $web = $this->db->get("tbl_websettings")->row();
    $logo1 = $web ? base_url('assets/img/' . $web->IMS_WEB_IMG) : '';
    $logo2 = $web ? base_url('assets/img/' . $web->IMS_WEB_IMG2) : '';
    $school_name = $web ? $web->IMS_WEB_NOS : '';
    $school_address = $web ? $web->IMS_WEB_ADDRESS : '';
    $school_email = $web ? $web->IMS_WEB_EMAIL : '';
    $school_contact = $web ? $web->IMS_WEB_CONTACT : '';

    $signatory = $this->db->get("tbl_signatories")->row();
    $registrar_name = $signatory ? $signatory->SIG_REG : '';

    $sched_id = $this->uri->segment(4);
    $rows = $this->db->where("ID", $sched_id)->get("tbl_scheduling")->row();

    if ($rows) {
        $config = $this->db->get_where("tbl_grading_config", ["GC_SCHEDID" => $sched_id])->row();
        if (empty($config)) {
            $config = (object) [
                'GC_ATTENDANCE_ACTIVE' => 1,
                'GC_ATTENDANCE_PCT' => 10,
                'GC_ATTENDANCE_MAX' => 10,
                'GC_EXAMPRELIM_ACTIVE' => 1,
                'GC_EXAMPRELIM_PCT' => 10,
                'GC_EXAMPRELIM_MAX' => 10,
                'GC_EXAMMIDTERM_ACTIVE' => 1,
                'GC_EXAMMIDTERM_PCT' => 15,
                'GC_EXAMMIDTERM_MAX' => 15,
                'GC_EXAMFINAL_ACTIVE' => 1,
                'GC_EXAMFINAL_PCT' => 20,
                'GC_EXAMFINAL_MAX' => 20,
                'GC_FINALREQ_ACTIVE' => 1,
                'GC_FINALREQ_PCT' => 10,
                'GC_FINALREQ_MAX' => 10,
                'GC_PERFORMANCE_ACTIVE' => 1,
                'GC_PERFORMANCE_PCT' => 20,
                'GC_PERFORMANCE_MAX' => 20,
                'GC_WRITTEN_ACTIVE' => 1,
                'GC_WRITTEN_PCT' => 15,
                'GC_WRITTEN_MAX' => 15
            ];
        }
    ?>
        <!-- HEADER SECTION -->
        <table class="header-table">
            <tr>
                <td style="width: 15%; text-align: left;">
                    <?php if ($logo1): ?>
                        <img src="<?= $logo1 ?>" alt="School Logo" style="max-height: 80px;">
                    <?php endif; ?>
                </td>
                <td style="width: 70%; text-align: center; vertical-align: middle;">
                    <div class="school-title"><?= $school_name ?></div>
                    <div class="school-subtitle"><?= $school_address ?></div>
                    <div class="school-subtitle">Email: <?= strtolower($school_email) ?> | Contact: <?= $school_contact ?></div>
                </td>
                <td style="width: 15%; text-align: right;">
                    <?php if ($logo2): ?>
                        <img src="<?= $logo2 ?>" alt="Acro Logo" style="max-height: 80px;">
                    <?php endif; ?>
                </td>
            </tr>
        </table>

        <div class="doc-title">Official Grading Sheet</div>

        <!-- SUBJECT & SCHEDULE INFORMATION -->
        <table class="info-table">
            <tr>
                <td style="width: 35%;"><strong>Subject:</strong> <?= $rows->SC_SDESC; ?></td>
                <td style="width: 30%;"><strong>Sched Code:</strong> <?= $rows->SC_CLASSCODE; ?></td>
                <td style="width: 35%;"><strong>Academic Year / Sem:</strong> <?= $rows->SC_ACADEMICYEAR . '-' . ($rows->SC_ACADEMICYEAR + 1); ?> / <?= $rows->SC_SEMESTER; ?></td>
            </tr>
            <tr>
                <td><strong>Program / Major:</strong> <?= $rows->SC_PROG; ?><?= $rows->SC_MAJOR ? ' (' . $rows->SC_MAJOR . ')' : ''; ?></td>
                <td><strong>Year Level / Section:</strong> <?= $rows->SC_YEARLEVEL; ?> - <?= $rows->SC_SECTION; ?></td>
                <td><strong>Room / Day &amp; Time:</strong> Room <?= $rows->SC_ROOM; ?> / <?= $rows->SC_DAY; ?> (<?= $rows->SC_STARTTIME . ' - ' . $rows->SC_ENDTIME; ?>)</td>
            </tr>
        </table>

        <!-- GRADES TABLE -->
        <table class="grades-table">
            <thead>
                <tr>
                    <th rowspan="2" style="width: 40px; vertical-align: middle;">#</th>
                    <th rowspan="2" style="text-align: left; padding-left: 8px; vertical-align: middle;">Student Name</th>
                    <?php if ($config->GC_ATTENDANCE_ACTIVE): ?>
                        <th style="width: 80px;">Attendance</th>
                    <?php endif; ?>
                    <?php if ($config->GC_EXAMPRELIM_ACTIVE || $config->GC_EXAMMIDTERM_ACTIVE || $config->GC_EXAMFINAL_ACTIVE): ?>
                        <th colspan="<?= ($config->GC_EXAMPRELIM_ACTIVE ? 1 : 0) + ($config->GC_EXAMMIDTERM_ACTIVE ? 1 : 0) + ($config->GC_EXAMFINAL_ACTIVE ? 1 : 0) ?>">Exam Scores</th>
                    <?php endif; ?>
                    <?php if ($config->GC_FINALREQ_ACTIVE): ?>
                        <th style="width: 80px;">Final Req</th>
                    <?php endif; ?>
                    <?php if ($config->GC_PERFORMANCE_ACTIVE): ?>
                        <th style="width: 85px;">Performance</th>
                    <?php endif; ?>
                    <?php if ($config->GC_WRITTEN_ACTIVE): ?>
                        <th style="width: 80px;">Written</th>
                    <?php endif; ?>
                    <th rowspan="2" style="width: 75px; vertical-align: middle;">Final Grade</th>
                    <th rowspan="2" style="width: 75px; vertical-align: middle;">Transmuted</th>
                    <th rowspan="2" style="width: 100px; vertical-align: middle;">Remarks</th>
                </tr>
                <tr>
                    <?php if ($config->GC_ATTENDANCE_ACTIVE): ?>
                        <th>Max <?= $config->GC_ATTENDANCE_MAX; ?> (<?= $config->GC_ATTENDANCE_PCT; ?>%)</th>
                    <?php endif; ?>
                    <?php if ($config->GC_EXAMPRELIM_ACTIVE): ?>
                        <th>Prelim Max <?= $config->GC_EXAMPRELIM_MAX; ?> (<?= $config->GC_EXAMPRELIM_PCT; ?>%)</th>
                    <?php endif; ?>
                    <?php if ($config->GC_EXAMMIDTERM_ACTIVE): ?>
                        <th>Midterm Max <?= $config->GC_EXAMMIDTERM_MAX; ?> (<?= $config->GC_EXAMMIDTERM_PCT; ?>%)</th>
                    <?php endif; ?>
                    <?php if ($config->GC_EXAMFINAL_ACTIVE): ?>
                        <th>Final Max <?= $config->GC_EXAMFINAL_MAX; ?> (<?= $config->GC_EXAMFINAL_PCT; ?>%)</th>
                    <?php endif; ?>
                    <?php if ($config->GC_FINALREQ_ACTIVE): ?>
                        <th>Max <?= $config->GC_FINALREQ_MAX; ?> (<?= $config->GC_FINALREQ_PCT; ?>%)</th>
                    <?php endif; ?>
                    <?php if ($config->GC_PERFORMANCE_ACTIVE): ?>
                        <th>Max <?= $config->GC_PERFORMANCE_MAX; ?> (<?= $config->GC_PERFORMANCE_PCT; ?>%)</th>
                    <?php endif; ?>
                    <?php if ($config->GC_WRITTEN_ACTIVE): ?>
                        <th>Max <?= $config->GC_WRITTEN_MAX; ?> (<?= $config->GC_WRITTEN_PCT; ?>%)</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                $grades = $this->db->where("GS_SCHEDID", $rows->ID)->get("tbl_gradingsystem")->result();
 
                if (!empty($grades)) {
                    foreach ($grades as $grade) {
                ?>
                        <tr>
                            <td><?= $i++; ?></td>
                            <td class="text-start text-bold"><?= $grade->GS_FULLNAME; ?></td>
                            <?php if ($config->GC_ATTENDANCE_ACTIVE): ?>
                                <td><?= $grade->GS_ATTENDANCE !== '' ? $grade->GS_ATTENDANCE : '-'; ?></td>
                            <?php endif; ?>
                            <?php if ($config->GC_EXAMPRELIM_ACTIVE): ?>
                                <td><?= $grade->GS_EXAMPRELIM !== '' ? $grade->GS_EXAMPRELIM : '-'; ?></td>
                            <?php endif; ?>
                            <?php if ($config->GC_EXAMMIDTERM_ACTIVE): ?>
                                <td><?= $grade->GS_EXAMMIDTERM !== '' ? $grade->GS_EXAMMIDTERM : '-'; ?></td>
                            <?php endif; ?>
                            <?php if ($config->GC_EXAMFINAL_ACTIVE): ?>
                                <td><?= $grade->GS_EXAMFINAL !== '' ? $grade->GS_EXAMFINAL : '-'; ?></td>
                            <?php endif; ?>
                            <?php if ($config->GC_FINALREQ_ACTIVE): ?>
                                <td><?= $grade->GS_FINALREQ !== '' ? $grade->GS_FINALREQ : '-'; ?></td>
                            <?php endif; ?>
                            <?php if ($config->GC_PERFORMANCE_ACTIVE): ?>
                                <td><?= $grade->GS_PERFORMANCE !== '' ? $grade->GS_PERFORMANCE : '-'; ?></td>
                            <?php endif; ?>
                            <?php if ($config->GC_WRITTEN_ACTIVE): ?>
                                <td><?= $grade->GS_WRITTEN !== '' ? $grade->GS_WRITTEN : '-'; ?></td>
                            <?php endif; ?>
                            <td class="text-bold"><?= $grade->GS_FINALGRADE !== '' ? $grade->GS_FINALGRADE : '-'; ?></td>
                            <td class="text-bold"><?= $grade->GS_TRANSMUTED !== '' ? $grade->GS_TRANSMUTED : '-'; ?></td>
                            <td class="text-bold"><?= $grade->GS_REMARKS !== '' ? $grade->GS_REMARKS : '-'; ?></td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="12" style="padding: 20px; text-align: center;">No grade data encoded for this class schedule.</td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="text-start" style="font-weight: bold; padding: 6px 8px;">Total Students: <?= $i - 1; ?></td>
                    <td colspan="10"></td>
                </tr>
            </tfoot>
        </table>

        <!-- SIGNATURES SECTION -->
        <table class="signature-section">
            <tr>
                <td style="width: 50%;">
                    <span class="text-bold">Prepared by:</span>
                    <br><br><br>
                    <div class="text-bold" style="text-transform: uppercase;"><?= $rows->SC_FACULTY; ?></div>
                    <div class="sig-line" style="margin-top: 5px;"></div>
                    <div>Instructor / Teacher</div>
                </td>
                <td style="width: 50%;">
                    <span class="text-bold">Approved by:</span>
                    <br><br><br>
                    <div class="text-bold" style="text-transform: uppercase;"><?= $registrar_name ?: 'School Registrar'; ?></div>
                    <div class="sig-line" style="margin-top: 5px;"></div>
                    <div>School Registrar</div>
                </td>
            </tr>
        </table>
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
