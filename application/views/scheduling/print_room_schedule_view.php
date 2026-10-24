<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Room Schedule - <?= htmlspecialchars($room) ?></title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap');

        @page {
            size: 8.5in 13in;
            margin: 12mm 12mm 18mm 12mm;
        }

        * {
            box-sizing: border-box;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 0;
            font-size: 10.5px;
            line-height: 1.5;
            background-color: #fff;
        }

        .container {
            width: 100%;
        }

        /* ── HEADER ── */
        .header-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 15px;
            border-bottom: 3px double #cbd5e1;
            margin-bottom: 20px;
        }

        .logo-side {
            width: 90px;
            min-width: 90px;
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-side img {
            max-width: 90px;
            max-height: 90px;
            width: auto;
            height: auto;
            object-fit: contain;
            display: block;
        }

        .header-center {
            text-align: center;
            flex-grow: 1;
            padding: 0 20px;
        }

        .school-name {
            font-family: 'Outfit', sans-serif;
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }

        .school-address {
            font-size: 10px;
            color: #475569;
            margin-bottom: 2px;
        }

        .school-contact {
            font-size: 10px;
            color: #64748b;
            font-weight: 500;
        }

        /* ── DOCUMENT TITLE ── */
        .doc-title-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .doc-title {
            font-family: 'Outfit', sans-serif;
            font-size: 22px;
            font-weight: 700;
            color: #1e3a8a;
            /* Deep blue academic accent */
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin: 0 0 4px 0;
        }

        .doc-subtitle {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-weight: 500;
        }

        /* ── METADATA GRID ── */
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .meta-card {
            display: flex;
            align-items: center;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px 15px;
        }

        .meta-icon {
            color: #2563eb;
            margin-right: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .meta-content {
            display: flex;
            flex-direction: column;
        }

        .meta-label {
            font-size: 8.5px;
            font-weight: 600;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }

        .meta-value {
            font-family: 'Outfit', sans-serif;
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
        }

        /* ── SECTION HEADER ── */
        .section-title-wrapper {
            display: flex;
            align-items: center;
            margin-top: 25px;
            margin-bottom: 10px;
            border-bottom: 2px solid #cbd5e1;
            padding-bottom: 6px;
            page-break-after: avoid;
        }

        .section-badge {
            padding: 4px 10px;
            font-weight: 700;
            font-size: 9px;
            border-radius: 4px;
            color: #fff;
            margin-right: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .section-title {
            font-family: 'Outfit', sans-serif;
            font-size: 12.5px;
            font-weight: 600;
            color: #334155;
            margin: 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Accents */
        .mwf-accent .section-badge {
            background-color: #2563eb;
        }

        /* Royal Blue */
        .mwf-accent {
            border-color: #3b82f6;
        }

        .tth-accent .section-badge {
            background-color: #0d9488;
        }

        /* Teal */
        .tth-accent {
            border-color: #0f766e;
        }

        .other-accent .section-badge {
            background-color: #4f46e5;
        }

        /* Indigo */
        .other-accent {
            border-color: #4338ca;
        }

        /* ── SCHEDULE TABLE ── */
        .sched-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            margin-bottom: 20px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            page-break-inside: avoid;
        }

        .sched-table thead th {
            background-color: #0f172a;
            color: #f8fafc;
            font-family: 'Outfit', sans-serif;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.75px;
            padding: 10px 14px;
            border-bottom: 2px solid #1e293b;
            text-align: left;
        }

        .sched-table thead th.col-time {
            text-align: center;
        }

        .sched-table thead th.col-day,
        .sched-table thead th.col-yl,
        .sched-table thead th.col-sec {
            text-align: center;
        }

        .sched-table tbody td {
            padding: 10px 14px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 10px;
            color: #334155;
            vertical-align: middle;
        }

        .sched-table tbody tr:last-child td {
            border-bottom: none;
        }

        .sched-table tbody tr.row-even {
            background-color: #ffffff;
        }

        .sched-table tbody tr.row-odd {
            background-color: #f8fafc;
        }

        .sched-table tbody tr:hover {
            background-color: #f1f5f9;
        }

        /* Column widths */
        .col-time {
            width: 15%;
            text-align: center;
        }

        .time-block {
            display: inline-block;
            background-color: #f1f5f9;
            color: #1e3a8a;
            font-weight: 700;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 9.5px;
            border: 1px solid #dbeafe;
            white-space: nowrap;
        }

        .col-subject {
            width: 32%;
        }

        .class-code-badge {
            display: inline-block;
            background-color: #dbeafe;
            color: #1e40af;
            font-weight: 700;
            font-size: 8.5px;
            padding: 2px 6px;
            border-radius: 4px;
            margin-right: 6px;
            text-transform: uppercase;
            border: 1px solid #bfdbfe;
        }

        .subject-title {
            font-weight: 600;
            color: #1e293b;
        }

        .col-prog {
            width: 14%;
        }

        .prog-badge {
            display: inline-block;
            background-color: #f0fdf4;
            color: #166534;
            font-weight: 700;
            font-size: 8.5px;
            padding: 2px 6px;
            border-radius: 4px;
            border: 1px solid #bbf7d0;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .merged-badge {
            background-color: #eff6ff;
            color: #1e40af;
            border-color: #bfdbfe;
            display: block;
            margin-bottom: 3px;
            width: fit-content;
        }

        .merged-badge:last-child {
            margin-bottom: 0;
        }

        .prog-list {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        /* Section badges (stacked in merged rows) */
        .sec-badge {
            display: block;
            background-color: #f5f3ff;
            color: #5b21b6;
            font-weight: 700;
            font-size: 8.5px;
            padding: 2px 6px;
            border-radius: 4px;
            border: 1px solid #ddd6fe;
            width: fit-content;
            margin-bottom: 2px;
        }

        .sec-badge:last-child {
            margin-bottom: 0;
        }

        .sec-list {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        /* Merged indicator pill below the time block */
        .merge-indicator {
            display: inline-block;
            margin-top: 4px;
            font-size: 7.5px;
            font-weight: 700;
            color: #6366f1;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        /* Merged rows get a subtle left accent */
        .row-merged td:first-child {
            border-left: 3px solid #6366f1;
        }

        .col-day {
            width: 10%;
            text-align: center;
        }

        .day-text {
            font-weight: 500;
            color: #475569;
            text-transform: uppercase;
        }

        .col-yl {
            width: 8%;
            text-align: center;
            font-weight: 600;
        }

        .col-sec {
            width: 8%;
            text-align: center;
            font-weight: 600;
            color: #0d9488;
        }

        .col-faculty {
            width: 22%;
        }

        .faculty-name {
            font-weight: 600;
            color: #0f172a;
        }

        .faculty-tba {
            color: #94a3b8;
            font-style: italic;
            font-weight: 400;
        }

        /* ── NO DATA CARD ── */
        .no-data-card {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 15px;
            background-color: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            color: #64748b;
            font-style: italic;
            margin-bottom: 20px;
            font-size: 9.5px;
        }

        .no-data-icon {
            margin-right: 8px;
            color: #94a3b8;
        }

        /* ── FOOTER & WATERMARK ── */
        .footer-container {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #cbd5e1;
            padding-top: 8px;
            font-size: 8px;
            color: #64748b;
            background-color: #fff;
        }

        .footer-info {
            display: flex;
            align-items: center;
        }

        .footer-timestamp {
            text-align: right;
        }

        /* ── PRINT RULES ── */
        @media print {
            body {
                margin: 0;
                background-color: #fff;
            }

            .no-print {
                display: none;
            }

            /* Avoid breaking elements */
            tr {
                page-break-inside: avoid;
            }

            .sched-table {
                page-break-inside: avoid;
            }
        }
    </style>
</head>

<body>
    <?php
    /* ── Time formatter ── */
    if (!function_exists('fmtTime')) {
        function fmtTime($t)
        {
            return date('h:i A', strtotime($t));
        }
    }

    /* ── Render a schedule table with merge support ── */
    if (!function_exists('renderScheduleGrid')) {
        function renderScheduleGrid($schedules)
        {
            if (empty($schedules)) {
                echo '<div class="no-data-card">
                <svg class="no-data-icon" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>No scheduled classes assigned to this room for this schedule block.</span>
            </div>';
                return;
            }

            /* Sort by start time */
            usort($schedules, function ($a, $b) {
                return strcmp($a->SC_STARTTIME, $b->SC_STARTTIME);
            });

            /*
             * Auto-merge: rows with the same room + day + time + subject + year level
             * are always collapsed into ONE display row.
             * Programs and sections from all matching rows are combined and shown stacked.
             * SC_MERGE = YES rows are also merged (already included by default).
             */
            $merged = [];
            foreach ($schedules as $s) {
                // Build merge key: room + day + time + subject + year
                $key = implode('||', [
                    strtolower(trim($s->SC_ROOM      ?? '')),
                    strtoupper(trim($s->SC_DAY       ?? '')),
                    trim($s->SC_STARTTIME  ?? ''),
                    trim($s->SC_ENDTIME    ?? ''),
                    strtolower(trim($s->SC_SDESC     ?? '')),
                    strtolower(trim($s->SC_YEARLEVEL ?? '')),
                ]);

                if (isset($merged[$key])) {
                    // Append program (unique, non-empty)
                    $prog = trim($s->SC_PROG ?? '');
                    if ($prog !== '' && !in_array($prog, $merged[$key]['programs'])) {
                        $merged[$key]['programs'][] = $prog;
                    }
                    // Append section (unique, non-empty)
                    $sec = trim($s->SC_SECTION ?? '');
                    if ($sec !== '' && !in_array($sec, $merged[$key]['sections'])) {
                        $merged[$key]['sections'][] = $sec;
                    }
                    // Append faculty (unique, non-empty)
                    $fac = trim($s->SC_FACULTY ?? '');
                    if ($fac !== '' && !in_array($fac, $merged[$key]['faculties'])) {
                        $merged[$key]['faculties'][] = $fac;
                    }
                } else {
                    $merged[$key] = [
                        'row'       => $s,
                        'programs'  => array_values(array_filter([trim($s->SC_PROG    ?? '')])),
                        'sections'  => array_values(array_filter([trim($s->SC_SECTION ?? '')])),
                        'faculties' => array_values(array_filter([trim($s->SC_FACULTY ?? '')])),
                    ];
                }
            }


            echo '<table class="sched-table">';
            echo '<thead><tr>';
            echo '<th class="col-time">Time Slot</th>';
            echo '<th class="col-subject">Subject &amp; Descriptive Title</th>';
            echo '<th class="col-day">Day</th>';
            echo '<th class="col-prog">Program(s)</th>';
            echo '<th class="col-yl">Year</th>';
            echo '<th class="col-sec">Section(s)</th>';
            echo '<th class="col-faculty">Assigned Faculty</th>';
            echo '</tr></thead>';
            echo '<tbody>';

            $i = 0;
            foreach ($merged as $entry) {
                $s         = $entry['row'];
                $programs  = $entry['programs'];
                $sections  = $entry['sections'];
                $faculties = $entry['faculties'];
                $isMerged  = (count($programs) > 1 || count($sections) > 1);


                $time      = fmtTime($s->SC_STARTTIME) . ' &ndash; ' . fmtTime($s->SC_ENDTIME);
                $row_class = ($i % 2 === 0) ? 'row-even' : 'row-odd';
                $i++;

                // Faculty
                $fac_display = implode(' / ', array_map('htmlspecialchars', $faculties));
                if (empty($fac_display) || strtoupper($fac_display) === 'TBA') {
                    $faculty_html = '<span class="faculty-tba">To Be Assigned (TBA)</span>';
                } else {
                    $faculty_html = '<span class="faculty-name">' . $fac_display . '</span>';
                }

                // Programs — stacked badges when multiple
                if (count($programs) > 1) {
                    $prog_parts = '';
                    foreach ($programs as $prog) {
                        $prog_parts .= '<span class="prog-badge merged-badge">' . htmlspecialchars($prog) . '</span>';
                    }
                    $prog_html = '<div class="prog-list">' . $prog_parts . '</div>';
                } else {
                    $p = htmlspecialchars($programs[0] ?? '');
                    $prog_html = $p !== '' ? '<span class="prog-badge">' . $p . '</span>' : '<span class="faculty-tba">—</span>';
                }

                // Sections — stacked badges when multiple
                if (count($sections) > 1) {
                    $sec_parts = '';
                    foreach ($sections as $sec) {
                        $sec_parts .= '<span class="sec-badge">' . htmlspecialchars($sec) . '</span>';
                    }
                    $sec_html = '<div class="sec-list">' . $sec_parts . '</div>';
                } else {
                    $sv = htmlspecialchars($sections[0] ?? '');
                    $sec_html = $sv !== '' ? '<span class="sec-badge">' . $sv . '</span>' : '<span class="faculty-tba">—</span>';
                }

                // Merged indicator
                $merge_indicator = $isMerged
                    ? '<div class="merge-indicator">&#9741; Merged ' . count($sections) . ' sections</div>'
                    : '';

                echo '<tr class="' . $row_class . ($isMerged ? ' row-merged' : '') . '">';
                echo '<td class="col-time"><span class="time-block">' . $time . '</span>' . $merge_indicator . '</td>';
                echo '<td class="col-subject"><span class="subject-title">' . htmlspecialchars($s->SC_SDESC ?? '') . '</span></td>';
                echo '<td class="col-day"><span class="day-text">' . htmlspecialchars($s->SC_DAY ?? '') . '</span></td>';
                echo '<td class="col-prog">' . $prog_html . '</td>';
                echo '<td class="col-yl">' . htmlspecialchars($s->SC_YEARLEVEL ?? '') . '</td>';
                echo '<td class="col-sec">' . $sec_html . '</td>';
                echo '<td class="col-faculty">' . $faculty_html . '</td>';
                echo '</tr>';
            }

            echo '</tbody></table>';
        }
    }
    ?>

    <div class="container">

        <!-- ── HEADER ── -->
        <?php
        $logo1 = $logo2 = $school_name = $school_address = $school_email = '';
        $settings = $this->db->get("tbl_websettings");
        if ($settings->num_rows() > 0) {
            $row = $settings->row();
            $logo1 = base_url('assets/img/' . $row->IMS_WEB_IMG);
            $logo2 = base_url('assets/img/' . $row->IMS_WEB_IMG2);
            $school_name    = $row->IMS_WEB_NOS;
            $school_address = $row->IMS_WEB_ADDRESS;
            $school_email   = $row->IMS_WEB_EMAIL;
        }
        ?>
        <div class="header-container">
            <div class="logo-side">
                <?php if ($logo1): ?><img src="<?= $logo1 ?>" alt="School Logo"><?php endif; ?>
            </div>
            <div class="header-center">
                <div class="school-name"><?= htmlspecialchars($school_name) ?></div>
                <div class="school-address"><?= htmlspecialchars($school_address) ?></div>
                <?php if ($school_email): ?>
                    <div class="school-contact">Email: <?= htmlspecialchars(strtolower($school_email)) ?></div>
                <?php endif; ?>
            </div>
            <div class="logo-side">
                <?php if ($logo2): ?><img src="<?= $logo2 ?>" alt="School Logo"><?php endif; ?>
            </div>
        </div>

        <!-- ── DOCUMENT TITLE ── -->
        <div class="doc-title-container">
            <h1 class="doc-title">Classroom Schedule</h1>
        </div>

        <!-- ── METADATA GRID ── -->
        <div class="meta-grid">
            <div class="meta-card">
                <div class="meta-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div class="meta-content">
                    <span class="meta-label">Room / Facility</span>
                    <span class="meta-value"><?= htmlspecialchars($room) ?></span>
                </div>
            </div>
            <div class="meta-card">
                <div class="meta-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                </div>
                <div class="meta-content">
                    <span class="meta-label">Academic Year</span>
                    <span class="meta-value"><?= is_numeric($ay) ? htmlspecialchars($ay) . '–' . (intval($ay) + 1) : htmlspecialchars($ay) ?></span>
                </div>
            </div>
            <div class="meta-card">
                <div class="meta-icon">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="meta-content">
                    <span class="meta-label">Semester / Term</span>
                    <span class="meta-value"><?= htmlspecialchars($sem) ?: 'All Semesters' ?></span>
                </div>
            </div>
        </div>

        <!-- ── MWF ── -->
        <div class="section-title-wrapper mwf-accent">
            <div class="section-badge">MWF</div>
            <h2 class="section-title">Monday, Wednesday, Friday</h2>
        </div>
        <?php renderScheduleGrid($mwf_schedules ?? []); ?>

        <!-- ── TTH ── -->
        <div class="section-title-wrapper tth-accent">
            <div class="section-badge">TTH</div>
            <h2 class="section-title">Tuesday, Thursday</h2>
        </div>
        <?php renderScheduleGrid($tth_schedules ?? []); ?>

        <!-- ── OTHER ── -->
        <?php if (!empty($other_schedules)): ?>
            <div class="section-title-wrapper other-accent">
                <div class="section-badge">Other</div>
                <h2 class="section-title">Other Days Schedule (SAT, SUN, etc.)</h2>
            </div>
            <?php renderScheduleGrid($other_schedules ?? []); ?>
        <?php endif; ?>

        <!-- ── FOOTER & WATERMARK ── -->
        <div class="footer-container">
            <div class="footer-info">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align: middle; margin-right: 4px; color: #94a3b8;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <span>Official Classroom Schedule &bull; Institution Management System</span>
            </div>
            <div class="footer-timestamp">
                <span>Printed & Posted on: </span><strong id="pd"></strong> at <strong id="pt"></strong>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("pd").innerText = new Date().toLocaleDateString(undefined, {
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        document.getElementById("pt").innerText = new Date().toLocaleTimeString(undefined, {
            hour: '2-digit',
            minute: '2-digit'
        });
        window.onload = function() {
            window.print();
        };
        window.onafterprint = function() {
            window.close();
        };
    </script>
</body>

</html>