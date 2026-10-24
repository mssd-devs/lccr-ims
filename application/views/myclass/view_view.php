<style>
    /* Stylish & Simple Screen Styles */
    .print-header {
        display: none;
        /* Hidden on screen view */
        align-items: center;
        justify-content: space-between;
        border-bottom: 2px solid #1e293b;
        padding-bottom: 18px;
        margin-bottom: 25px;
    }

    .print-header img {
        max-height: 80px;
        width: auto;
    }

    .school-details {
        text-align: center;
        flex-grow: 1;
        padding: 0 20px;
    }

    .school-name {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        text-transform: uppercase;
        margin: 0 0 4px 0;
        letter-spacing: 0.5px;
    }

    .school-info {
        font-size: 12px;
        color: #64748b;
        margin: 2px 0;
    }

    .doc-title {
        text-align: center;
        font-size: 20px;
        font-weight: 800;
        margin: 15px 0 25px 0;
        text-transform: uppercase;
        letter-spacing: 1.5px;
        color: #1e293b;
    }

    /* Modern Class Header Card (Matching User Screenshot) */
    .class-header-card {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 24px;
        margin-bottom: 30px;
    }

    .schedule-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background-color: #f3e8ff;
        color: #7c3aed;
        padding: 6px 12px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 12px;
    }

    .class-title-row {
        margin-bottom: 10px;
    }

    .class-subject-title {
        font-size: 24px;
        font-weight: 800;
        color: #0f172a;
        margin: 0;
    }

    .class-meta-inline {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 16px;
        font-size: 13px;
        color: #64748b;
        margin-bottom: 24px;
        border-bottom: 1px solid #e2e8f0;
        padding-bottom: 16px;
    }

    .meta-inline-item {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .meta-inline-item i {
        font-size: 14px;
    }

    .meta-inline-label {
        font-weight: 700;
        color: #64748b;
    }

    .meta-inline-value {
        color: #94a3b8;
    }

    /* 4-Box Row Layout */
    .meta-boxes-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
    }

    .meta-box {
        display: flex;
        align-items: center;
        gap: 12px;
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 16px;
    }

    .meta-box-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 40px;
        height: 40px;
        border-radius: 8px;
        font-size: 20px;
    }

    /* Icon Colors mapping from user's image */
    .icon-blue {
        background-color: #e0f2fe;
        color: #0284c7;
    }

    .icon-yellow {
        background-color: #fef9c3;
        color: #ca8a04;
    }

    .icon-green {
        background-color: #dcfce7;
        color: #16a34a;
    }

    .icon-red {
        background-color: #fee2e2;
        color: #dc2626;
    }

    .meta-box-content {
        display: flex;
        flex-direction: column;
    }

    .meta-box-label {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        font-weight: 700;
    }

    .meta-box-value {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
    }

    /* Print-Only Details Table (Hidden on Screen) */
    .print-details-table {
        display: none;
    }

    /* Student Table Styles */
    .student-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-top: 10px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
    }

    .student-table th {
        background-color: #f1f5f9;
        color: #475569;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 11px;
        letter-spacing: 0.8px;
        border-bottom: 1px solid #e2e8f0;
        padding: 14px 18px;
        text-align: left;
    }

    .student-table td {
        padding: 12px 18px;
        border-bottom: 1px solid #e2e8f0;
        font-size: 13px;
        color: #334155;
        vertical-align: middle;
    }

    .student-table tr:last-child td {
        border-bottom: none;
    }

    .student-table tr:hover {
        background-color: #f8fafc;
    }

    /* Stylish Status Badges */
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 4px 10px;
        border-radius: 30px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .status-active {
        background-color: #dcfce7;
        color: #15803d;
    }

    .status-pending {
        background-color: #fef9c3;
        color: #a16207;
    }

    .status-other {
        background-color: #f1f5f9;
        color: #475569;
    }

    /* Print Styles */
    @media print {
        body {
            background: none !important;
            color: #000 !important;
            font-size: 11pt;
        }

        .layout-navbar,
        .layout-menu,
        .menu-vertical,
        .breadcrumb,
        .nav-link,
        .footer,
        .btn,
        nav,
        .card:not(#listofstudent) {
            display: none !important;
        }

        .content-wrapper,
        .container-xxl,
        .row,
        .col-md-12 {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
        }

        .card#listofstudent {
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        .card-body {
            padding: 0 !important;
        }

        .print-header {
            display: flex !important;
            /* Visible when printing */
            border-bottom: 2px solid #000;
        }

        .class-header-card {
            display: none !important;
            /* Hide screen card on print */
        }

        .print-details-table {
            display: table !important;
            /* Show print table */
            width: 100% !important;
            border-collapse: collapse !important;
            margin-top: 10px !important;
            margin-bottom: 25px !important;
        }

        .print-details-table th,
        .print-details-table td {
            border: 1px solid #000 !important;
            padding: 6px 10px !important;
            font-size: 10pt !important;
            text-align: left !important;
            vertical-align: middle !important;
            color: #000 !important;
        }

        .print-details-table th {
            background-color: #f1f5f9 !important;
            font-weight: 700 !important;
            width: 18% !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .print-details-table td {
            width: 32% !important;
        }

        .student-table {
            border: 1px solid #000 !important;
            border-radius: 0 !important;
        }

        .student-table th {
            background-color: #f1f5f9 !important;
            border-bottom: 1px solid #000 !important;
            border-right: 1px solid #000 !important;
            color: #000 !important;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        .student-table td {
            border-bottom: 1px solid #000 !important;
            border-right: 1px solid #000 !important;
            color: #000 !important;
        }

        .student-table th:last-child,
        .student-table td:last-child {
            border-right: none !important;
        }

        .status-badge {
            background: transparent !important;
            color: #000 !important;
            padding: 0 !important;
            font-weight: normal !important;
        }
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="d-print-none">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Faculty Class</a>
            </li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card" id="listofstudent">
                <div class="card-body">
                    <div class="print-header">
                        <?php
                        $query = $this->db->get("tbl_websettings");
                        $row = $query->row();
                        if ($row) {
                            $logo1 = base_url('assets/img/' . $row->IMS_WEB_IMG);
                            $logo2 = base_url('assets/img/' . $row->IMS_WEB_IMG2);
                            $school_name = $row->IMS_WEB_NOS;
                            $school_address = $row->IMS_WEB_ADDRESS;
                            $school_email = $row->IMS_WEB_EMAIL;
                            $school_contact = $row->IMS_WEB_CONTACT;
                        }
                        ?>
                        <?php if (!empty($logo1)): ?>
                            <img src="<?= $logo1 ?>" alt="Logo 1">
                        <?php endif; ?>

                        <div class="school-details">
                            <h3 class="school-name"><?= $school_name ?? '' ?></h3>
                            <p class="school-info"><?= $school_address ?? '' ?></p>
                            <p class="school-info">
                                Email: <?= isset($school_email) ? strtolower($school_email) : '' ?>
                                <?php if (!empty($school_contact)): ?>
                                    | Contact No. <?= $school_contact ?>
                                <?php endif; ?>
                            </p>
                        </div>

                        <?php if (!empty($logo2)): ?>
                            <img src="<?= $logo2 ?>" alt="Logo 2">
                        <?php endif; ?>
                    </div>

                    <?php
                    $query = $this->db->where("ID", $this->uri->segment(4))->get("tbl_scheduling");
                    foreach ($query->result() as $rows) {
                        if ($rows->ID == $this->uri->segment(4)) {
                    ?>
                            <div class="class-header-card d-print-none">
                                <div class="schedule-badge">
                                    <i class="ri-calendar-todo-line"></i> Class Schedule
                                </div>
                                <div class="class-title-row">
                                    <h1 class="class-subject-title"><?= $rows->SC_SDESC; ?></h1>
                                </div>
                                <div class="class-meta-inline">
                                    <div class="meta-inline-item">
                                        <i class="ri-hashtag"></i>
                                        <span class="meta-inline-label">Code:</span>
                                        <span class="meta-inline-value"><?= $rows->SC_CLASSCODE; ?></span>
                                    </div>
                                    <div class="meta-inline-item">
                                        <i class="ri-graduation-cap-line"></i>
                                        <span class="meta-inline-label">Program:</span>
                                        <span class="meta-inline-value"><?= $rows->SC_PROG; ?></span>
                                    </div>
                                    <div class="meta-inline-item">
                                        <i class="ri-building-line"></i>
                                        <span class="meta-inline-label">Dept:</span>
                                        <span class="meta-inline-value"><?= $rows->SC_DEPT; ?></span>
                                    </div>
                                    <div class="meta-inline-item">
                                        <i class="ri-slideshow-line"></i>
                                        <span class="meta-inline-label">Method:</span>
                                        <span class="meta-inline-value"><?= $rows->SC_TEACHMODELS; ?></span>
                                    </div>
                                </div>

                                <div class="meta-boxes-row">
                                    <!-- Box 1 -->
                                    <div class="meta-box">
                                        <div class="meta-box-icon icon-blue">
                                            <i class="ri-calendar-2-line"></i>
                                        </div>
                                        <div class="meta-box-content">
                                            <span class="meta-box-label">Academic Year</span>
                                            <span class="meta-box-value"><?= $rows->SC_ACADEMICYEAR . '-' . ($rows->SC_ACADEMICYEAR + 1); ?></span>
                                        </div>
                                    </div>
                                    <!-- Box 2 -->
                                    <div class="meta-box">
                                        <div class="meta-box-icon icon-yellow">
                                            <i class="ri-compass-3-line"></i>
                                        </div>
                                        <div class="meta-box-content">
                                            <span class="meta-box-label">Semester / Year Level</span>
                                            <span class="meta-box-value"><?= $rows->SC_SEMESTER . ' • ' . $rows->SC_YEARLEVEL; ?></span>
                                        </div>
                                    </div>
                                    <!-- Box 3 -->
                                    <div class="meta-box">
                                        <div class="meta-box-icon icon-green">
                                            <i class="ri-community-line"></i>
                                        </div>
                                        <div class="meta-box-content">
                                            <span class="meta-box-label">Section & Room</span>
                                            <span class="meta-box-value"><?= $rows->SC_SECTION . ' • Room ' . $rows->SC_ROOM; ?></span>
                                        </div>
                                    </div>
                                    <!-- Box 4 -->
                                    <div class="meta-box">
                                        <div class="meta-box-icon icon-red">
                                            <i class="ri-time-line"></i>
                                        </div>
                                        <div class="meta-box-content">
                                            <span class="meta-box-label">Schedule</span>
                                            <span class="meta-box-value"><?= $rows->SC_STARTTIME . ' - ' . $rows->SC_ENDTIME . ' (' . $rows->SC_DAY . ')'; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h2 class="doc-title">LIST OF STUDENTS</h2>
                            <table class="print-details-table">
                                <tr>
                                    <th>Subject</th>
                                    <td><?= $rows->SC_SDESC; ?></td>
                                    <th>Sched Code</th>
                                    <td><?= $rows->SC_CLASSCODE; ?></td>
                                </tr>
                                <tr>
                                    <th>Program</th>
                                    <td><?= $rows->SC_PROG; ?></td>
                                    <th>Major</th>
                                    <td><?= $rows->SC_MAJOR; ?></td>
                                </tr>
                                <tr>
                                    <th>Academic Year</th>
                                    <td><?= $rows->SC_ACADEMICYEAR . '-' . ($rows->SC_ACADEMICYEAR + 1); ?></td>
                                    <th>Semester</th>
                                    <td><?= $rows->SC_SEMESTER; ?></td>
                                </tr>
                                <tr>
                                    <th>Year Level</th>
                                    <td><?= $rows->SC_YEARLEVEL; ?></td>
                                    <th>Section</th>
                                    <td><?= $rows->SC_SECTION; ?></td>
                                </tr>
                                <tr>
                                    <th>Room</th>
                                    <td><?= $rows->SC_ROOM; ?></td>
                                    <th>Department</th>
                                    <td><?= $rows->SC_DEPT; ?></td>
                                </tr>
                                <tr>
                                    <th>Schedule Time / Day</th>
                                    <td><?= $rows->SC_STARTTIME . ' - ' . $rows->SC_ENDTIME . ' (' . $rows->SC_DAY . ')'; ?></td>
                                    <th>Teaching Method</th>
                                    <td><?= $rows->SC_TEACHMODELS; ?></td>
                                </tr>
                            </table>

                            <div class="table-responsive">
                                <table id="myTable" class="student-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 80px; text-align: center;">No</th>
                                            <th>Name of Students</th>
                                            <th style="width: 150px;">Gender</th>
                                            <th style="width: 220px;">Enrollment Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $query = $this->db->where("ER_SECTION", $rows->SC_SECTION)->get("tbl_enrollment");
                                        foreach ($query->result() as $r) {
                                            if ($r->ER_SECTION == $rows->SC_SECTION) {
                                                $stud = $this->db->where("SP_STUDID", $r->ER_STUDENTID)->get("tbl_studprof")->row();
                                                if ($stud) {
                                                    $status = trim($r->ER_ENSTATUS);
                                                    $status_class = 'status-other';
                                                    if (stripos($status, 'enrol') !== false || stripos($status, 'active') !== false) {
                                                        $status_class = 'status-active';
                                                    } elseif (stripos($status, 'pend') !== false) {
                                                        $status_class = 'status-pending';
                                                    }
                                        ?>
                                                    <tr>
                                                        <td style="text-align: center; font-weight: 600; color: #64748b;"><?= $i++; ?></td>
                                                        <td style="font-weight: 600; color: #0f172a;"><?= $stud->SP_FIRSTNAME . ' ' . $stud->SP_MIDDLENAME . ' ' . $stud->SP_LASTNAME; ?></td>
                                                        <td><?= $stud->SP_GENDER; ?></td>
                                                        <td>
                                                            <span class="status-badge <?= $status_class ?>"><?= $status; ?></span>
                                                        </td>
                                                    </tr>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                    <?php
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="card d-print-none mt-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <button onclick="printContainerBox()" class="btn btn-secondary btn-lg"><i class="ri-printer-line"></i> Print</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function printContainerBox() {
        window.print();
    }
</script>
<!-- / Content -->