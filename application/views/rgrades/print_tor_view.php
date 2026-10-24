<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Official Transcript of Records</title>
    <?php
    $mag_data = file_exists(APPPATH . 'views/rgrades/font_magneto.php') ? include(APPPATH . 'views/rgrades/font_magneto.php') : '';
    $mat_data = file_exists(APPPATH . 'views/rgrades/font_matura.php') ? include(APPPATH . 'views/rgrades/font_matura.php') : '';
    ?>
    <style>
        @font-face {
            font-family: 'MagnetoBold';
            src: <?php if (!empty($mag_data)): ?>url('data:font/ttf;charset=utf-8;base64,<?= $mag_data ?>') format('truetype'), <?php endif; ?> url('<?= base_url("assets/fonts/MAGNETOB.TTF") ?>') format('truetype'),
                local('Magneto Bold'), local('Magneto'), local('MAGNETOB');
            font-weight: bold;
            font-style: normal;
        }

        @font-face {
            font-family: 'MaturaScriptCapitals';
            src: <?php if (!empty($mat_data)): ?>url('data:font/ttf;charset=utf-8;base64,<?= $mat_data ?>') format('truetype'), <?php endif; ?> url('<?= base_url("assets/fonts/MATURASC.TTF") ?>') format('truetype'),
                local('Matura MT Script Capitals'), local('Matura MT Script'), local('MATURASC');
            font-weight: normal;
            font-style: normal;
        }

        @font-face {
            font-family: 'SimSunExtB';
            src: url('<?= base_url("assets/fonts/simsunb.ttf") ?>') format('truetype'),
                local('SimSun-ExtB'), local('SimSun'), local('NSimSun');
            font-weight: normal;
            font-style: normal;
        }

        @media print {
            @page {
                size: 8.5in 13in;
                margin: 8mm 6mm 10mm 6mm;
                @bottom-center {
                    content: "Page " counter(page) " of " counter(pages);
                    font-family: 'Times New Roman', Times, serif;
                    font-size: 10px;
                    font-weight: bold;
                    color: #000000;
                }
            }

            html,
            body {
                margin: 0 !important;
                padding: 0 !important;
                background: #ffffff !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }

            header,
            nav,
            .navbar,
            .topbar,
            .app-header,
            .layout-navbar,
            .main-header,
            .sidebar,
            .no-print {
                display: none !important;
            }

            thead {
                display: table-header-group !important;
            }

            tfoot {
                display: table-footer-group !important;
            }

            tr.term-header-row {
                page-break-after: avoid !important;
                page-break-inside: avoid !important;
            }

            tr {
                page-break-inside: avoid !important;
            }

            .watermark-seal {
                position: fixed !important;
                top: 50% !important;
                left: 50% !important;
                transform: translate(-50%, -50%) !important;
                width: 600px !important;
                max-width: 90% !important;
                opacity: 0.18 !important;
                z-index: 0 !important;
                pointer-events: none !important;
                display: block !important;
            }
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 6px;
            font-family: 'Times New Roman', Times, serif;
            color: #000000;
            background: #ffffff;
            font-size: 10px;
        }

        header,
        nav,
        .navbar,
        .topbar,
        .app-header,
        .layout-navbar,
        .main-header,
        .sidebar {
            display: none !important;
        }

        .watermark-seal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 600px;
            max-width: 90%;
            opacity: 0.18;
            z-index: 0;
            pointer-events: none;
        }

        /* DIRECT TOP LEVEL TABLE */
        table.tor-main-table {
            position: relative;
            z-index: 1;
            width: 100%;
            border-collapse: collapse;
            font-family: 'Times New Roman', Times, serif;
            table-layout: fixed;
            background: transparent !important;
        }

        table.tor-main-table td {
            color: #000000;
            background: transparent !important;
            font-family: 'Times New Roman', Times, serif;
        }

        .header-inner-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 2px;
        }

        .header-inner-table td {
            vertical-align: middle;
            border: none !important;
            color: #000000;
            padding: 0;
            font-family: 'Times New Roman', Times, serif;
        }

        .school-title {
            font-family: 'MagnetoBold', 'Magneto', 'Magneto Bold', 'Brush Script MT', cursive, serif !important;
            font-size: 22px;
            font-style: italic;
            color: #316bbb !important;
            margin: 1px 0;
            letter-spacing: 0.5px;
            text-align: left;
        }

        .doc-office {
            font-family: 'MaturaScriptCapitals', 'Matura MT Script Capitals', 'Matura MT Script', cursive, serif !important;
            font-size: 18px;
            text-align: center;
            margin-top: 4px;
            margin-bottom: 1px;
            color: #000000;
        }

        .doc-title {
            font-family: 'SimSunExtB', 'SimSun-ExtB', 'SimSun', 'NSimSun', serif !important;
            font-size: 13px;
            font-weight: bold;
            text-align: center;
            letter-spacing: 1px;
            margin-bottom: 4px;
            color: #000000;
        }

        .student-info-inner-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 4px;
            font-size: 12px;
            line-height: 1.3;
            color: #000000;
            font-family: 'SimSunExtB', 'SimSun-ExtB', 'SimSun', 'NSimSun', serif !important;
        }

        .student-info-inner-table td {
            border: none !important;
            padding: 1px 2px;
            vertical-align: top;
            color: #000000;
            font-family: 'SimSunExtB', 'SimSun-ExtB', 'SimSun', 'NSimSun', serif !important;
        }

        /* Column Headers for Grades Table (Title Table - keeps borders) */
        .col-header th {
            border: 1px solid #000000 !important;
            padding: 4px 2px;
            font-weight: bold;
            text-align: center;
            font-size: 12px;
            background: #ffffff !important;
            text-transform: uppercase;
            color: #000000;
            font-family: 'SimSunExtB', 'SimSun-ExtB', 'SimSun', 'NSimSun', serif !important;
        }

        /* Subject rows inside tbody - REMOVED BORDERS */
        .subject-row td {
            border: none !important;
            padding: 2.5px 4px;
            font-size: 12px;
            color: #000000;
            font-family: 'SimSunExtB', 'SimSun-ExtB', 'SimSun', 'NSimSun', serif !important;
        }

        .term-header-row td {
            border-top: 1px solid #000000 !important;
            border-bottom: 1px solid #000000 !important;
            border-left: none !important;
            border-right: none !important;
            font-weight: bold;
            text-align: center;
            font-size: 12px;
            background: #ffffff !important;
            padding: 3px 0;
            color: #000000;
            font-family: 'SimSunExtB', 'SimSun-ExtB', 'SimSun', 'NSimSun', serif !important;
        }

        .closed-row td {
            border-top: 1px solid #000000 !important;
            border-bottom: 1px solid #000000 !important;
            border-left: none !important;
            border-right: none !important;
            text-align: center;
            padding: 4px;
            font-size: 12px;
            font-style: italic;
            color: #000000;
            background: #ffffff !important;
            font-family: 'SimSunExtB', 'SimSun-ExtB', 'SimSun', 'NSimSun', serif !important;
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

        .grading-system-section {
            font-size: 12px;
            line-height: 1.3;
            margin-top: 6px;
            font-family: 'Times New Roman', Times, serif;
            color: #000000;
        }

        .signature-inner-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
            font-size: 10.5px;
            color: #000000;
            font-family: 'SimSunExtB', 'SimSun-ExtB', 'SimSun', 'NSimSun', serif !important;
        }

        .signature-inner-table td {
            border: none !important;
            vertical-align: bottom;
            color: #000000;
            font-family: 'SimSunExtB', 'SimSun-ExtB', 'SimSun', 'NSimSun', serif !important;
        }

        .sig-line {
            border-bottom: 1px solid #000;
            display: inline-block;
            min-width: 170px;
            text-align: center;
            font-weight: bold;
            color: #000000;
        }

        .tor-page-number::before {
            content: "Page " counter(page) " of " counter(pages);
        }
    </style>
</head>

<body>

    <?php
    $studentId = $this->uri->segment(5);
    $query = $this->db->get("tbl_websettings");
    foreach ($query->result() as $row) {
        $logo1 = base_url('assets/img/' . $row->IMS_WEB_IMG);
        $logo2 = base_url('assets/img/' . $row->IMS_WEB_IMG2);
        $school_name = $row->IMS_WEB_NOS;
        $school_address = $row->IMS_WEB_ADDRESS;
        $school_email = $row->IMS_WEB_EMAIL;
    }
    $sig_row = $this->db->get("tbl_signatories")->row();
    $sig_reg = ($sig_row && !empty($sig_row->SIG_REG)) ? $sig_row->SIG_REG : 'HANIA M. SULTAN';

    $r = $this->db->where("SP_STUDID", $studentId)->get("tbl_studprof")->row();
    $transId = $r ? $r->SP_TRANSID : '';
    $rows = !empty($transId) ? $this->db->where("SP_TRANSID", $transId)->get("tbl_studprof_school")->result() : [];
    $rows1 = $this->db->where("ER_STUDENTID", $studentId)->order_by("ID", "DESC")->get("tbl_enrollment")->row();
    $sg_row = $this->db->where("G_STUDENTID", $studentId)->get("tbl_studentgrades")->row();

    $picture = ($r && !empty($r->SP_IMAGE)) ? base_url("uploads/" . $r->SP_IMAGE) : base_url("assets/img/avatars/1.png");

    $fullname = $r ? trim($r->SP_LASTNAME . ', ' . $r->SP_FIRSTNAME . ' ' . $r->SP_MIDDLENAME) : ($sg_row ? $sg_row->G_FULLNAME : $studentId);
    $gender = $r ? $r->SP_GENDER : ($sg_row ? $sg_row->G_GENDER : 'N/A');
    $program_code = $rows1 ? $rows1->ER_PROGRAM : ($sg_row ? $sg_row->G_PROGRAM : '');
    $program = $rows1 ? $rows1->ER_PROGRAM . (!empty($rows1->ER_MAJOR) ? ' (' . $rows1->ER_MAJOR . ')' : '') : 'Bachelor of Elementary Education';
    $start_ay = $rows1 && !empty($rows1->ER_ACADEMICYEAR) ? (int)$rows1->ER_ACADEMICYEAR : 2022;
    $ay_admitted = 'Academic Year ' . $start_ay . '-' . ($start_ay + 1);

    $elem_school = '';
    $hs_school = '';
    $shs_school = '';
    $last_year_attended = '';
    $entrance_data = '';

    if (!empty($rows)) {
        foreach ($rows as $r1) {
            if ($r1->EDUC_ATTAIN == 'Elementary') $elem_school = $r1->EDUC_NAMEOFSCHOOL;
            if ($r1->EDUC_ATTAIN == 'High School' || $r1->EDUC_ATTAIN == 'Junior High School') $hs_school = $r1->EDUC_NAMEOFSCHOOL;
            if ($r1->EDUC_ATTAIN == 'Senior High School') {
                $shs_school = $r1->EDUC_NAMEOFSCHOOL;
                if (!empty($r1->EDUC_YEAR)) $last_year_attended = $r1->EDUC_YEAR;
            }
        }
    }
    ?>

    <!-- PURE DIRECT TOP-LEVEL TABLE -->
    <table class="tor-main-table">
        <colgroup>
            <col style="width: 13%;">
            <col style="width: 55%;">
            <col style="width: 11%;">
            <col style="width: 11%;">
            <col style="width: 10%;">
        </colgroup>
        <thead>
            <!-- Top Header, Logos, Title, Student Info Grid -->
            <tr>
                <td colspan="5" style="border: none !important; padding-bottom: 4px;">
                    <!-- Watermark Seal inside thead for multi-page repeat -->
                    <?php if (!empty($logo2)): ?>
                        <img src="<?= $logo2 ?>" alt="Watermark Seal" class="watermark-seal">
                    <?php endif; ?>

                    <table class="header-inner-table">
                        <tr>
                            <td style="width: 15%; text-align: left; vertical-align: middle;">
                                <?php if (!empty($logo2)): ?>
                                    <img src="<?= $logo2 ?>" alt="School Logo" style="width: 95px; height: auto;">
                                <?php endif; ?>
                            </td>
                            <td style="width: 67%; text-align: left; vertical-align: middle; padding-left: 6px; line-height: 1.25;">
                                <div style="font-size: 12px; font-family: 'Times New Roman', Times, serif; color: #000000;">Republic of the Philippines</div>
                                <div class="school-title">Lanao College of Criminology, Inc.</div>
                                <div style="font-size: 10.5px; font-family: 'Times New Roman', Times, serif; color: #000000;">Sheik Macalawi Village, Buadiamaloy, Masiu, Lanao Del Sur</div>
                                <div style="font-size: 10.5px; font-family: 'Times New Roman', Times, serif; color: #000000;">Reg. Sec No. CN 200431360 / TIN No. 630-176-362-00000</div>
                                <div style="font-size: 10.5px; font-family: 'Times New Roman', Times, serif; color: #000000;">Email: <span style="text-decoration: underline; color: #316bbb;"><?= htmlspecialchars($school_email ?: 'lccr.lanaocollegeofcriminology@gmail.com') ?></span></div>
                            </td>
                            <td style="width: 18%; text-align: right; vertical-align: middle;">
                                <img src="<?= $picture ?>" alt="Student Photo" style="width: 1.15in; height: 1.15in; object-fit: cover; border: 1px solid #000; padding: 1px;">
                            </td>
                        </tr>
                    </table>

                    <div class="doc-office">Office of the Registrar</div>
                    <div class="doc-title">OFFICIAL TRANSCRIPT OF RECORDS</div>

                    <table class="student-info-inner-table">
                        <tr>
                            <td style="width: 50%;">
                                <div><span style="display: inline-block; width: 70px;">Name</span>: <strong style="text-transform: uppercase;"><?= htmlspecialchars($fullname) ?></strong></div>
                                <div><span style="display: inline-block; width: 70px;">Gender</span>: <strong><?= htmlspecialchars($gender) ?></strong></div>
                                <div><span style="display: inline-block; width: 70px;">I.D No.</span>: <strong><?= htmlspecialchars($studentId) ?></strong></div>
                                <div><span style="display: inline-block; width: 70px;">Course</span>: <strong><?= htmlspecialchars($program) ?></strong></div>
                                <div><span style="display: inline-block; width: 70px;">Admitted</span>: <strong><?= htmlspecialchars($ay_admitted) ?></strong></div>
                                <div><span style="display: inline-block; width: 70px;">Graduation</span>: <strong>January 20, 2026</strong></div>
                            </td>
                            <td style="width: 50%; padding-left: 15px;">
                                <div class="fw-bold" style="text-decoration: underline; margin-bottom: 2px;">Record of Preliminary Education</div>
                                <div><span style="display: inline-block; width: 120px;">Elementary</span>: <strong><?= htmlspecialchars($elem_school) ?></strong></div>
                                <div><span style="display: inline-block; width: 120px;">High School</span>: <strong><?= htmlspecialchars($hs_school) ?></strong></div>
                                <div><span style="display: inline-block; width: 120px;">Senior High School</span>: <strong><?= htmlspecialchars($shs_school) ?></strong></div>
                                <div><span style="display: inline-block; width: 120px;">Last Year Attended</span>: <strong><?= htmlspecialchars($last_year_attended) ?></strong></div>
                                <div><span style="display: inline-block; width: 120px;">Entrance Data</span>: <strong><?= htmlspecialchars($entrance_data) ?></strong></div>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Column Headers (Repeated on top of EVERY printed page!) -->
            <tr class="col-header">
                <th>COURSE CODE</th>
                <th>DESCRIPTIVE TITLE</th>
                <th>FINAL GRADE</th>
                <th>COMPILE GRADE</th>
                <th>CREDIT</th>
            </tr>
        </thead>

        <tbody>
            <?php
            // Query program curriculum subjects from tbl_subject
            $subjects = [];
            if (!empty($program_code)) {
                $this->db->where("S_SELECTPROG", $program_code);
                if (!empty($rows1->ER_MAJOR)) {
                    $this->db->where("S_MAJOR", $rows1->ER_MAJOR);
                }
                $subjects = $this->db
                    ->order_by("FIELD(S_YRLVL, '1ST YEAR', '2ND YEAR', '3RD YEAR', '4TH YEAR')")
                    ->order_by("FIELD(S_SEM, '1ST TRIMESTER', '1ST SEMESTER', '2ND TRIMESTER', '2ND SEMESTER', '3RD TRIMESTER', 'SUMMER')")
                    ->get("tbl_subject")
                    ->result();
            }

            $terms = [];
            if (!empty($subjects)) {
                foreach ($subjects as $s) {
                    $yrlvl = $s->S_YRLVL;
                    $sem = $s->S_SEM;

                    $yr_offset = 0;
                    if (strpos(strtoupper($yrlvl), '2ND') !== false) $yr_offset = 1;
                    elseif (strpos(strtoupper($yrlvl), '3RD') !== false) $yr_offset = 2;
                    elseif (strpos(strtoupper($yrlvl), '4TH') !== false) $yr_offset = 3;

                    $ay_num = $start_ay + $yr_offset;
                    $ay_title = $ay_num . '-' . ($ay_num + 1);

                    if (strpos(strtoupper($sem), '1ST') !== false) $sem_name = 'First Semester';
                    elseif (strpos(strtoupper($sem), '2ND') !== false) $sem_name = 'Second Semester';
                    elseif (strpos(strtoupper($sem), '3RD') !== false) $sem_name = 'Third Trimester';
                    elseif (strpos(strtoupper($sem), 'SUMMER') !== false) $sem_name = 'Summer Term';
                    else $sem_name = $sem;

                    $term_key = $sem_name . ', ' . $ay_title;
                    if (!isset($terms[$term_key])) {
                        $terms[$term_key] = [];
                    }
                    $terms[$term_key][] = $s;
                }
            } else {
                $sg_list = $this->db->where("G_STUDENTID", $studentId)->get("tbl_studentgrades")->result();
                foreach ($sg_list as $g) {
                    $term_key = $g->G_SEMESTER . ', ' . $g->G_ACADEMICYEAR . '-' . ((int)$g->G_ACADEMICYEAR + 1);
                    if (!isset($terms[$term_key])) {
                        $terms[$term_key] = [];
                    }
                    $terms[$term_key][] = (object)[
                        'S_SCODE' => 'GEC 001',
                        'S_SDESCRIPTION' => $g->G_SUBJECT,
                        'S_UNITS' => 3
                    ];
                }
            }

            if (!empty($terms)) {
                if (!function_exists('to_custom_title_case')) {
                    function to_custom_title_case($title)
                    {
                        $title = html_entity_decode($title, ENT_QUOTES, 'UTF-8');
                        $title = mb_strtolower($title, 'UTF-8');

                        $minor_words = ['on', 'in', 'the', 'for', 'and', 'of', 'to', 'with', 'a', 'an', 'by', 'at'];
                        $roman_numerals = ['i', 'ii', 'iii', 'iv', 'v', 'vi', 'vii', 'viii', 'ix', 'x', 'xi', 'xii'];

                        $words = explode(' ', $title);
                        $count = count($words);

                        for ($i = 0; $i < $count; $i++) {
                            $word = $words[$i];
                            if ($word === '') continue;

                            $clean_word = preg_replace('/[^a-zA-Z]/', '', $word);
                            $clean_lower = strtolower($clean_word);

                            if (in_array($clean_lower, $roman_numerals)) {
                                $words[$i] = preg_replace_callback('/\b[a-zA-Z]+\b/', function ($m) {
                                    return strtoupper($m[0]);
                                }, $word);
                            } elseif ($i > 0 && in_array($clean_lower, $minor_words)) {
                                $words[$i] = strtolower($word);
                            } else {
                                $words[$i] = mb_convert_case($word, MB_CASE_TITLE, 'UTF-8');
                            }
                        }

                        return implode(' ', $words);
                    }
                }

                foreach ($terms as $term_title => $subjs_in_term) {
                    echo '<tr class="term-header-row"><td colspan="5">' . htmlspecialchars(html_entity_decode($term_title, ENT_QUOTES, 'UTF-8')) . '</td></tr>';
                    foreach ($subjs_in_term as $s) {
                        $desc = is_object($s) ? $s->S_SDESCRIPTION : $s['S_SDESCRIPTION'];
                        $code = is_object($s) ? $s->S_SCODE : $s['S_SCODE'];
                        $units = is_object($s) ? $s->S_UNITS : $s['S_UNITS'];

                        $desc_decoded = html_entity_decode($desc, ENT_QUOTES, 'UTF-8');
                        $code_decoded = html_entity_decode($code, ENT_QUOTES, 'UTF-8');

                        $clean_desc = htmlspecialchars(to_custom_title_case($desc_decoded), ENT_QUOTES, 'UTF-8');
                        $clean_code = htmlspecialchars($code_decoded, ENT_QUOTES, 'UTF-8');

                        $gr = $this->db->group_start()
                            ->where('G_SUBJECT', $desc)
                            ->or_where('G_SUBJECT', $desc_decoded)
                            ->group_end()
                            ->where('G_STUDENTID', $studentId)
                            ->get('tbl_studentgrades')
                            ->row();

                        $fgrade = ($gr && !empty($gr->G_GRADE)) ? htmlspecialchars($gr->G_GRADE) : '';
                        $reexam = ($gr && !empty($gr->G_REEXAM)) ? htmlspecialchars($gr->G_REEXAM) : '';

                        echo '<tr class="subject-row">';
                        echo '<td class="text-left">' . $clean_code . '</td>';
                        echo '<td class="text-left">' . $clean_desc . '</td>';
                        echo '<td class="text-center fw-bold">' . $fgrade . '</td>';
                        echo '<td class="text-center">' . $reexam . '</td>';
                        echo '<td class="text-center fw-bold">' . htmlspecialchars($units) . '</td>';
                        echo '</tr>';
                    }
                }
            } else {
                echo '<tr class="subject-row"><td colspan="5" class="text-center py-2">No grade records found.</td></tr>';
            }
            ?>
            <tr class="closed-row">
                <td colspan="5">XXXXXXXXXXXXXXXXXXXXXXXXXXXXX Transcript Closed XXXXXXXXXXXXXXXXXXXXXXXXXXXXX</td>
            </tr>
        </tbody>

        <tfoot>
            <!-- Footer (Repeated at the bottom of EVERY printed page!) -->
            <tr>
                <td colspan="5" style="border: none !important; padding-top: 6px;">
                    <div class="grading-system-section">
                        <div class="fw-bold mb-1">Remarks: Issued for any Legal Purposes.</div>
                        <table style="width: 100%; border-collapse: collapse; border: none;">
                            <tr>
                                <td style="width: 50%; border: none; vertical-align: top; padding: 0;">
                                    <div class="fw-bold">Grading System for GE and Mandated Courses: (50%)</div>
                                    <div>1.00-1.50 – 89-100% &nbsp;&nbsp;&nbsp; Excellent</div>
                                    <div>1.60-2.00 – 78-88% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Very Good</div>
                                    <div>2.10-2.10 – 76-77% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Good</div>
                                    <div>2.20-2.70 – 61-75% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Satisfactory</div>
                                    <div>2.80-3.00 – 50-60% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Passing</div>
                                    <div>5.00 – 49% below &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Failure</div>
                                </td>
                                <td style="width: 50%; border: none; vertical-align: top; padding: 0;">
                                    <div class="fw-bold">Grading System for Major and Elective Courses: (60%)</div>
                                    <table style="width: 100%; border-collapse: collapse; border: none;">
                                        <tr>
                                            <td style="border: none; padding: 0;">1.00-1.50 – 90-100% &nbsp;&nbsp;&nbsp; Excellent</td>
                                            <td style="border: none; padding: 0; width: 140px;">P - Passing</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none; padding: 0;">1.60-2.00 – 80-89% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Very Good</td>
                                            <td style="border: none; padding: 0; width: 140px;">F – Failure (5.00), no credit</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none; padding: 0;">2.10-2.10 – 78-79% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Good</td>
                                            <td style="border: none; padding: 0; width: 140px;">INC - Incomplete</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none; padding: 0;">2.20-2.70 – 66-77% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Satisfactory</td>
                                            <td style="border: none; padding: 0; width: 140px;">DRP - Dropped</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none; padding: 0;">2.80-3.00 – 60-67% &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Passing</td>
                                            <td style="border: none; padding: 0; width: 140px;">OD– Official Dropped</td>
                                        </tr>
                                        <tr>
                                            <td style="border: none; padding: 0;">5.00 – 59% below &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Failure</td>
                                            <td style="border: none; padding: 0;"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                        <div style="font-size: 10px; line-height: 1.3; margin-top: 4px;">
                            <strong>Note:</strong> This transcript is valid only when it bears the seal of LCCr and the original signature in ink of the Registrar. Any alteration made on this copy renders the whole transcript invalid.
                        </div>
                    </div>

                    <table class="signature-inner-table">
                        <tr>
                            <td style="width: 33%;">
                                <div>Evaluated by: <span style="border-bottom: 1px solid #000; min-width: 120px; display: inline-block;"></span></div>
                                <div style="font-size: 10px; margin-left: 70px;">Department Chairperson</div>
                            </td>
                            <td style="width: 33%;">
                                <div>Checked by: <span style="border-bottom: 1px solid #000; min-width: 120px; display: inline-block;"></span></div>
                                <div style="font-size: 10px; margin-left: 65px;">College Dean</div>
                            </td>
                            <td style="width: 34%; text-align: center;">
                                <span class="sig-line"><?= strtoupper(htmlspecialchars($sig_reg)) ?></span>
                                <div style="font-size: 10px; font-weight: bold;">Registrar</div>
                            </td>
                        </tr>
                    </table>

                    <table style="width: 100%; border-collapse: collapse; border: none; margin-top: 8px; font-size: 10px;">
                        <tr>
                            <td style="border: none; text-align: left; width: 33%;">Date Issued: <?= date('M. d, Y') ?></td>
                            <td style="border: none; text-align: center; width: 34%; font-weight: bold;" class="tor-page-number"></td>
                            <td style="border: none; text-align: right; width: 33%; font-style: italic; font-weight: bold;">Not Valid Without College Dry Seal</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </tfoot>
    </table>

    <script>
        function checkSemesterPageSplits() {
            var mainTable = document.querySelector('.tor-main-table');
            if (!mainTable) return;

            var tbody = mainTable.querySelector('tbody');
            if (!tbody) return;

            var rows = Array.from(tbody.children);
            var termGroups = [];
            var currentGroup = null;

            rows.forEach(function(row) {
                if (row.classList.contains('term-header-row')) {
                    var cell = row.querySelector('td');
                    var title = cell ? cell.textContent.trim() : '';
                    currentGroup = {
                        headerRow: row,
                        title: title,
                        subjectRows: []
                    };
                    termGroups.push(currentGroup);
                } else if (row.classList.contains('subject-row')) {
                    if (currentGroup) {
                        currentGroup.subjectRows.push(row);
                    }
                }
            });

            var totalPageHeight = 1180;
            var thead = document.querySelector('thead');
            var tfoot = document.querySelector('tfoot');
            var theadHeight = thead ? thead.offsetHeight : 320;
            var tfootHeight = tfoot ? tfoot.offsetHeight : 280;
            var availableBodyHeight = totalPageHeight - theadHeight - tfootHeight;

            if (availableBodyHeight <= 200) availableBodyHeight = 580;

            var tbodyTop = tbody.getBoundingClientRect().top + window.scrollY;

            termGroups.forEach(function(group) {
                if (group.subjectRows.length <= 1) return;

                for (var i = 0; i < group.subjectRows.length - 1; i++) {
                    var curRow = group.subjectRows[i];
                    var nextRow = group.subjectRows[i + 1];

                    var curTop = curRow.getBoundingClientRect().top + window.scrollY - tbodyTop;
                    var nextTop = nextRow.getBoundingClientRect().top + window.scrollY - tbodyTop;

                    var curPage = Math.floor(curTop / availableBodyHeight);
                    var nextPage = Math.floor(nextTop / availableBodyHeight);

                    if (nextPage > curPage) {
                        var noteRow = document.createElement('tr');
                        noteRow.className = 'closed-row semester-split-note';
                        noteRow.innerHTML = '<td colspan="5" style="text-align: center; font-style: italic; font-weight: bold; font-size: 10.5px; padding: 3px 0; border-top: 1px solid #000 !important; border-bottom: 1px solid #000 !important;">*** Note: The other subjects in this semester are on the next page ***</td>';

                        curRow.parentNode.insertBefore(noteRow, nextRow);

                        var contRow = document.createElement('tr');
                        contRow.className = 'term-header-row term-continued-header';
                        contRow.innerHTML = '<td colspan="5">' + group.title + ' (Continued)</td>';

                        curRow.parentNode.insertBefore(contRow, nextRow);
                        break;
                    }
                }
            });
        }

        window.onload = function() {
            try {
                checkSemesterPageSplits();
            } catch (e) {
                console.error(e);
            }
            window.print();
        };
        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>

</html>