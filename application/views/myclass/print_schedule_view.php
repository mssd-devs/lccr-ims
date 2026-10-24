<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Class Schedule - <?= htmlspecialchars($this->session->userdata('fullname')) ?></title>
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
            font-size: 11px;
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
            grid-template-columns: repeat(4, 1fr);
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
            width: 100%;
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
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* ── TABLE STYLE ── */
        .table-schedule {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            font-size: 11px;
        }

        .table-schedule th,
        .table-schedule td {
            border: 1px solid #cbd5e1;
            padding: 8px 10px;
            text-align: left;
        }

        .table-schedule th {
            background-color: #f1f5f9;
            color: #334155;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 9.5px;
            letter-spacing: 0.5px;
        }

        .table-schedule tr:nth-child(even) {
            background-color: #f8fafc;
        }

        /* ── FOOTER & WATERMARK ── */
        .footer-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 40px;
            padding-top: 15px;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 9px;
        }

        .footer-info {
            display: flex;
            align-items: center;
        }

        .footer-timestamp {
            font-weight: 500;
        }

        .watermark-container {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: -1;
            opacity: 0.05;
            pointer-events: none;
        }

        .watermark-container img {
            max-width: 450px;
            width: 450px;
        }
    </style>
</head>

<body>

    <?php
    $logo1 = "";
    $logo2 = "";
    $school_name = "Institutional System";
    $school_address = "";
    $school_email = "";
    if (!empty($school_info)) {
        $logo1 = base_url('assets/img/' . $school_info->IMS_WEB_IMG);
        $logo2 = base_url('assets/img/' . $school_info->IMS_WEB_IMG2);
        $school_name = $school_info->IMS_WEB_NOS;
        $school_address = $school_info->IMS_WEB_ADDRESS;
        $school_email = $school_info->IMS_WEB_EMAIL;
    }
    ?>

    <!-- Watermark Logo -->
    <?php if (!empty($logo2)): ?>
        <div class="watermark-container">
            <img src="<?= $logo2 ?>" alt="School Watermark">
        </div>
    <?php endif; ?>

    <div class="container">
        <!-- School Header -->
        <div class="header-container">
            <div class="logo-side">
                <?php if (!empty($logo1)): ?>
                    <img src="<?= $logo1 ?>" alt="School Logo 1">
                <?php endif; ?>
            </div>
            <div class="header-center">
                <div class="school-name"><?= htmlspecialchars($school_name) ?></div>
                <div class="school-address"><?= htmlspecialchars($school_address) ?></div>
                <?php if (!empty($school_email)): ?>
                    <div class="school-contact">Email: <?= htmlspecialchars($school_email) ?></div>
                <?php endif; ?>
            </div>
            <div class="logo-side">
                <?php if (!empty($logo2)): ?>
                    <img src="<?= $logo2 ?>" alt="School Logo 2">
                <?php endif; ?>
            </div>
        </div>

        <!-- Document Title -->
        <div class="doc-title-container">
            <h1 class="doc-title">Faculty Class Schedule</h1>
            <div class="doc-subtitle">Teaching Load and Schedule Details</div>
        </div>

        <!-- Metadata Grid -->
        <div class="meta-grid">
            <!-- Faculty Card -->
            <div class="meta-card">
                <div class="meta-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <div class="meta-content">
                    <span class="meta-label">Faculty Member</span>
                    <span class="meta-value" title="<?= htmlspecialchars($this->session->userdata('fullname')) ?>"><?= htmlspecialchars($this->session->userdata('fullname')) ?></span>
                </div>
            </div>
            <!-- Semester Card -->
            <div class="meta-card">
                <div class="meta-icon">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="meta-content">
                    <span class="meta-label">Academic Sem / AY</span>
                    <span class="meta-value">
                        <?php 
                        $sem_text = !empty($filters['sem']) ? $filters['sem'] : 'All Sem';
                        $ay_text = !empty($filters['ay']) ? $filters['ay'] . '-' . ($filters['ay'] + 1) : 'All AY';
                        echo htmlspecialchars($sem_text . ' (' . $ay_text . ')');
                        ?>
                    </span>
                </div>
            </div>
            <!-- Total Units Card -->
            <div class="meta-card">
                <div class="meta-icon" style="color: #2563eb;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path>
                    </svg>
                </div>
                <div class="meta-content">
                    <span class="meta-label">Total Load Units</span>
                    <span class="meta-value" style="color: #2563eb;"><?= number_format($total_units, 1) ?> Units</span>
                </div>
            </div>
            <!-- Overload Card -->
            <div class="meta-card">
                <div class="meta-icon" style="color: #dc2626;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="meta-content">
                    <span class="meta-label">Overload Units</span>
                    <span class="meta-value" style="color: #dc2626;"><?= number_format($overload_units, 1) ?> Units</span>
                </div>
            </div>
        </div>

        <!-- Schedule Table -->
        <table class="table-schedule">
            <thead>
                <tr>
                    <th style="width: 25%;">Subject Description</th>
                    <th style="width: 20%;">Program</th>
                    <th style="width: 10%;">Year Level</th>
                    <th style="width: 12%;">Time</th>
                    <th style="width: 10%;">Day</th>
                    <th style="width: 10%;">Room</th>
                    <th style="width: 8%;">Units</th>
                    <th style="width: 5%;">Section</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($schedules)): ?>
                    <tr>
                        <td colspan="8" style="text-align: center; color: #64748b; padding: 15px;">No class schedules found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($schedules as $sched): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($sched->SC_SDESC) ?></strong></td>
                            <td>
                                <?= htmlspecialchars($sched->SC_PROG) ?>
                                <?php if (!empty($sched->SC_MAJOR)): ?>
                                    <br><small style="color: #64748b;">(<?= htmlspecialchars($sched->SC_MAJOR) ?>)</small>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($sched->SC_YEARLEVEL) ?></td>
                            <td><?= htmlspecialchars($sched->SC_STARTTIME . ' - ' . $sched->SC_ENDTIME) ?></td>
                            <td><?= htmlspecialchars($sched->SC_DAY) ?></td>
                            <td><?= htmlspecialchars($sched->SC_ROOM) ?></td>
                            <td><?= number_format(is_numeric($sched->S_UNITS) ? floatval($sched->S_UNITS) : 0, 1) ?></td>
                            <td><?= htmlspecialchars($sched->SC_SECTION) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Footer -->
        <div class="footer-container">
            <div class="footer-info">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="vertical-align: middle; margin-right: 4px; color: #94a3b8;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
                <span>Official Faculty Class Schedule &bull; Institution Management System</span>
            </div>
            <div class="footer-timestamp">
                <span>Printed on: </span><strong id="pd"></strong> at <strong id="pt"></strong>
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
