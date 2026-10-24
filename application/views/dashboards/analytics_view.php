<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
        /* Increased opacity for better contrast in light mode */
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(225, 230, 240, 0.6);
        box-shadow: 0 4px 12px 0 rgba(0, 0, 0, 0.05);
        position: relative;
        overflow: hidden;
        transition: all 0.3s ease-in-out;
    }

    /* Standardized Premium Borders for Stat Cards */
    .card-stats.border-start {
        border-left-width: 5px !important;
    }

    .card-stats.border-danger {
        border-left-color: #ff3e1d !important;
        box-shadow: 0 4px 12px rgba(255, 62, 29, 0.08);
    }

    .card-stats.border-info {
        border-left-color: #03c3ec !important;
        box-shadow: 0 4px 12px rgba(3, 195, 236, 0.08);
    }

    .card-stats.border-secondary {
        border-left-color: #8592a3 !important;
        box-shadow: 0 4px 12px rgba(133, 146, 163, 0.08);
    }

    .card-stats.border-primary {
        border-left-color: #696cff !important;
        box-shadow: 0 4px 12px rgba(105, 108, 255, 0.08);
    }

    .card-stats.border-success {
        border-left-color: #71dd37 !important;
        box-shadow: 0 4px 12px rgba(113, 221, 55, 0.08);
    }

    .card-stats.border-warning {
        border-left-color: #ffab00 !important;
        box-shadow: 0 4px 12px rgba(255, 171, 0, 0.08);
    }

    .card-stats:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
    }

    .glass-card::after {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg,
                transparent,
                rgba(255, 255, 255, 0.1),
                transparent);
        transform: rotate(45deg);
        transition: 0.5s;
        pointer-events: none;
    }

    .glass-card:hover::after {
        left: 100%;
        top: 100%;
    }

    [data-theme='dark'] .glass-card,
    .dark-style .glass-card {
        background: rgba(30, 31, 48, 0.7) !important;
        border: 1px solid rgba(255, 255, 255, 0.1) !important;
        box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.5) !important;
    }

    /* Table Glassmorphism */
    .table-glass {
        border-collapse: separate;
        border-spacing: 0 8px;
    }

    .table-glass tr {
        background: rgba(255, 255, 255, 0.6);
        transition: all 0.3s ease;
    }

    [data-theme='dark'] .table-glass tr,
    .dark-style .table-glass tr {
        background: rgba(255, 255, 255, 0.05) !important;
        color: #d1d1d1 !important;
        /* Lighter text for better contrast */
    }

    [data-theme='dark'] .table-glass thead th,
    .dark-style .table-glass thead th {
        color: #fff !important;
        background-color: rgba(0, 0, 0, 0.2) !important;
    }

    [data-theme='dark'] .table-glass .text-muted,
    .dark-style .table-glass .text-muted {
        color: #a3acb9 !important;
        /* Slightly lighter than default muted for dark mode */
    }

    .table-glass tr:hover {
        background: rgba(105, 108, 255, 0.1);
        transform: scale(1.01);
    }

    [data-theme='dark'] .table-glass tr:hover,
    .dark-style .table-glass tr:hover {
        background: rgba(105, 108, 255, 0.2) !important;
    }

    /* Precise Dark Mode Override for the "TOTAL" row cells */
    [data-theme='dark'] .table-glass tr.table-secondary th,
    .dark-style .table-glass tr.table-secondary th,
    [data-theme='dark'] .table-glass tr.table-secondary td,
    .dark-style .table-glass tr.table-secondary td {
        background-color: #323249 !important;
        /* Slightly lighter than card to be distinct */
        color: #ffffff !important;
        border-bottom-color: rgba(255, 255, 255, 0.1) !important;
    }

    /* bg-light override for dark mode (PWD section) */
    [data-theme='dark'] .bg-light,
    .dark-style .bg-light {
        background-color: rgba(255, 255, 255, 0.05) !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
    }

    /* Enhanced side borders for dark mode */
    [data-theme='dark'] .border-start,
    .dark-style .border-start {
        border-left-width: 5px !important;
    }

    .bg-gradient-glass {
        background: linear-gradient(135deg, rgba(105, 108, 255, 0.9), rgba(255, 62, 29, 0.7));
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    [data-theme='dark'] .bg-gradient-glass,
    .dark-style .bg-gradient-glass {
        background: linear-gradient(135deg, rgba(105, 108, 255, 0.5), rgba(255, 62, 29, 0.4));
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .card-stats {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
    }

    .card-stats:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card-stats .card-body {
        padding: 1.5rem;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin-bottom: 1rem;
    }

    .bg-gradient-primary {
        background: linear-gradient(45deg, #696cff, #8592ff);
        color: #fff;
    }

    .bg-gradient-success {
        background: linear-gradient(45deg, #71dd37, #93e86c);
        color: #fff;
    }

    .bg-gradient-info {
        background: linear-gradient(45deg, #03c3ec, #49d5f3);
        color: #fff;
    }

    .bg-gradient-warning {
        background: linear-gradient(45deg, #ffab00, #ffc54d);
        color: #fff;
    }

    /* Premium Welcome Card Gradient - Sharpened */
    .bg-gradient-glass {
        background: linear-gradient(135deg, #696cff 0%, #ff3e1d 100%) !important;
        border: none !important;
        box-shadow: 0 4px 12px rgba(105, 108, 255, 0.2) !important;
    }

    .bg-gradient-secondary {
        background: linear-gradient(45deg, #8592a3, #a3afbb);
        color: #fff;
    }

    .badge-soft-primary {
        background-color: rgba(105, 108, 255, 0.15);
        color: #435971;
        font-weight: 600;
    }

    .badge-soft-success {
        background-color: rgba(113, 221, 55, 0.15);
        color: #3e8e04;
        font-weight: 600;
    }

    .badge-soft-warning {
        background-color: rgba(255, 171, 0, 0.15);
        color: #855d00;
        font-weight: 600;
    }

    .badge-soft-info {
        background-color: rgba(3, 195, 236, 0.15);
        color: #02718a;
        font-weight: 600;
    }

    .text-muted-custom {
        color: #566a7f;
        /* Darker color for better readability in light mode */
        font-size: 0.85rem;
        font-weight: 500;
    }

    /* Override template label badges for high contrast in light mode */
    .bg-label-danger {
        background-color: rgba(255, 62, 29, 0.12) !important;
        color: #d92305 !important;
    }

    .bg-label-info {
        background-color: rgba(3, 195, 236, 0.12) !important;
        color: #028eb0 !important;
    }

    .bg-label-primary {
        background-color: rgba(105, 108, 255, 0.12) !important;
        color: #5156f7 !important;
    }

    .bg-label-success {
        background-color: rgba(113, 221, 55, 0.12) !important;
        color: #3e8e04 !important;
    }

    .bg-label-warning {
        background-color: rgba(255, 171, 0, 0.12) !important;
        color: #855d00 !important;
    }

    .bg-label-secondary {
        background-color: rgba(133, 146, 163, 0.12) !important;
        color: #566a7f !important;
    }

    /* Maintain vibrant colors in dark mode */
    [data-theme='dark'] .bg-label-danger,
    .dark-style .bg-label-danger {
        color: #ff6e54 !important;
    }

    [data-theme='dark'] .bg-label-info,
    .dark-style .bg-label-info {
        color: #49d5f3 !important;
    }

    [data-theme='dark'] .bg-label-primary,
    .dark-style .bg-label-primary {
        color: #8592ff !important;
    }

    [data-theme='dark'] .bg-label-success,
    .dark-style .bg-label-success {
        color: #93e86c !important;
    }

    [data-theme='dark'] .bg-label-warning,
    .dark-style .bg-label-warning {
        color: #ffc54d !important;
    }

    [data-theme='dark'] .bg-label-secondary,
    .dark-style .bg-label-secondary {
        color: #a3afbb !important;
    }

    .stat-icon {
        border: 1px solid rgba(0, 0, 0, 0.05);
        /* Subtle border for icons in light mode */
    }

    [data-theme='dark'] .stat-icon,
    .dark-style .stat-icon {
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .glass-header {
        border-radius: 12px !important;
        border-left: 5px solid #696cff !important;
        background: rgba(255, 255, 255, 0.9) !important;
    }

    [data-theme='dark'] .glass-header,
    .dark-style .glass-header {
        background: rgba(30, 31, 48, 0.8) !important;
        border-left: 5px solid #696cff !important;
    }

    /* Pulse animation for Live Data */
    .pulse-success {
        animation: pulse-success 2s infinite;
    }

    @keyframes pulse-success {
        0% {
            box-shadow: 0 0 0 0 rgba(113, 221, 55, 0.4);
        }

        70% {
            box-shadow: 0 0 0 10px rgba(113, 221, 55, 0);
        }

        100% {
            box-shadow: 0 0 0 0 rgba(113, 221, 55, 0);
        }
    }

    .dashboard-header {
        margin-bottom: 2rem;
    }

    .filter-card {
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="glass-card glass-header p-3 rounded-3 mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-label-primary me-3">
                    <i class="ri-dashboard-3-line ri-24px"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-primary">Dashboard Analytics</h4>
                    <p class="mb-0 text-muted-custom small">Real-time data visualization & student insights</p>
                </div>
            </div>
            <div class="d-none d-md-flex align-items-center">
                <div class="badge bg-label-success rounded-pill px-3 py-2 me-3 pulse-success">
                    <span class="d-flex align-items-center"><i class="ri-record-circle-line me-1"></i> Live Data</span>
                </div>
                <div class="text-end">
                    <p class="mb-0 text-muted-custom small">Academic Year</p>
                    <h6 class="mb-0 fw-bold"><?= date('Y') ?>-<?= date('Y') + 1 ?></h6>
                </div>
            </div>
        </div>
    </nav>
    <!-- Summary Cards -->
    <div class="row g-4 mb-4">
        <!-- Female Enrolled -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats glass-card h-100 border-start border-danger border-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="stat-icon bg-label-danger">
                            <i class="ri-women-line"></i>
                        </div>
                        <div class="badge bg-label-danger rounded-pill">
                            AY: <span id="display-academic-year-female">All</span>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-muted-custom mb-1">Female Students</h6>
                        <h3 class="mb-0 fw-bold counter" id="number-enrolled-female">0</h3>
                        <p class="mb-0 mt-2 small text-danger"><i class="ri-arrow-up-line"></i> Enrolled</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Male Enrolled -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats glass-card h-100 border-start border-info border-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="stat-icon bg-label-info">
                            <i class="ri-men-line"></i>
                        </div>
                        <div class="badge bg-label-info rounded-pill">
                            AY: <span id="display-academic-year-male">All</span>
                        </div>
                    </div>
                    <div>
                        <h6 class="text-muted-custom mb-1">Male Students</h6>
                        <h3 class="mb-0 fw-bold counter" id="number-enrolled-male">0</h3>
                        <p class="mb-0 mt-2 small text-info"><i class="ri-arrow-up-line"></i> Enrolled</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Student Profile -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats glass-card h-100 border-start border-secondary border-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="stat-icon bg-label-secondary">
                            <i class="ri-file-user-line"></i>
                        </div>
                        <div class="badge bg-label-secondary rounded-pill">
                            Profiles
                        </div>
                    </div>
                    <div>
                        <h6 class="text-muted-custom mb-1">Student Profiles</h6>
                        <h3 class="mb-0 fw-bold counter" id="number-student-profile">0</h3>
                        <div class="mt-2">
                            <span class="badge badge-soft-success me-1">Saved: <b class="counter" id="number-student-profile-saved">0</b></span>
                            <span class="badge badge-soft-warning">Draft: <b class="counter" id="number-student-profile-draft">0</b></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Employee -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats glass-card h-100 border-start border-primary border-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="stat-icon bg-label-primary">
                            <i class="ri-user-3-line"></i>
                        </div>
                        <div class="badge bg-label-primary rounded-pill">
                            Staff
                        </div>
                    </div>
                    <div>
                        <h6 class="text-muted-custom mb-1">Total Employees</h6>
                        <h3 class="mb-0 fw-bold counter" id="number-employee-profile">0</h3>
                        <div class="mt-2">
                            <span class="badge badge-soft-primary me-1">Teaching: <b class="counter" id="number-employee-profile-teaching">0</b></span>
                            <span class="badge badge-soft-info">Non-T: <b class="counter" id="number-employee-profile-nonteaching">0</b></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Officially Enrolled -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats glass-card h-100 border-start border-success border-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="stat-icon bg-label-success">
                            <i class="ri-group-line"></i>
                        </div>
                        <div class="badge bg-label-success rounded-pill">
                            Active
                        </div>
                    </div>
                    <div>
                        <h6 class="text-muted-custom mb-1">Officially Enrolled</h6>
                        <h3 class="mb-0 fw-bold counter" id="number-enrolled-students">0</h3>
                        <div class="mt-2">
                            <span class="badge badge-soft-success me-1">Done: <b class="counter" id="number-enrolled-students-pending">0</b></span>
                            <span class="badge badge-soft-warning">Pending: <b class="counter" id="number-enrolled-students-active">0</b></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Programs -->
        <div class="col-xl-3 col-md-6">
            <div class="card card-stats glass-card h-100 border-start border-warning border-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div class="stat-icon bg-label-warning">
                            <i class="ri-file-list-3-line"></i>
                        </div>
                        <div class="badge bg-label-warning rounded-pill">
                            Courses
                        </div>
                    </div>
                    <div>
                        <h6 class="text-muted-custom mb-1">Total Programs</h6>
                        <h3 class="mb-0 fw-bold counter" id="number-programs">0</h3>
                        <div class="mt-2">
                            <span class="badge badge-soft-success me-1">Active: <b class="counter" id="number-programs-active">0</b></span>
                            <span class="badge badge-soft-danger">Inactive: <b class="counter" id="number-programs-inactive">0</b></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Welcome Card -->
        <div class="col-xl-6 col-md-12">
            <div class="card h-100 bg-gradient-glass text-white card-stats">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <?php
                        date_default_timezone_set('Asia/Manila');
                        $hour = date('H');
                        $greeting = ($hour < 12) ? 'Good Morning' : (($hour < 18) ? 'Good Afternoon' : 'Good Evening');
                        ?>
                        <h4 class="text-white mb-2 fw-bold"><?= $greeting ?>, <?= $this->session->userdata('fullname') ?>!</h4>
                        <p class="mb-0 opacity-75">Your dashboard is ready with the latest student analytics and enrollment data.</p>
                        <div class="mt-4">
                            <span class="badge bg-white text-primary rounded-pill px-3 py-2">
                                <i class="ri-calendar-line me-1"></i> <span id="display-academic-year-trans">Current Academic Year</span>
                            </span>
                        </div>
                    </div>
                    <img src="<?= base_url() ?>assets/img/illustrations/illustration-2.png" alt="illustration" class="d-none d-sm-block" width="150">
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="row gy-4 mb-4">
        <div class="col-md-12">
            <div class="card filter-card">
                <div class="card-header bg-label-primary border-bottom py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="ri-filter-3-line me-2"></i>Filter Dashboard</h5>
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" id="btn_reset_filter">
                            <i class="ri-refresh-line me-1"></i> Reset Filters
                        </button>
                        <script>
                            $(document).on("click", "#btn_reset_filter", function() {
                                window.location.reload();
                            });
                        </script>
                    </div>
                </div>
                <div class="card-body">
                    <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <div class="row mt-5">
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FTR_AY" name="FTR_AY"
                                    aria-label="Default select example" data-allow-clear="true">
                                    <option value="">-- All Data --</option>
                                    <?php
                                    $current_year = date('Y');
                                    for ($start_year = $current_year; $start_year >= 2021; $start_year--) : ?>
                                        <option value="<?php echo $start_year; ?>"
                                            <?php echo ($start_year == $current_year) ? 'selected' : ''; ?>>
                                            <?php echo $start_year . '-' . ($start_year + 1); ?></option>
                                    <?php endfor; ?>
                                </select>
                                <label for="basic-default-fullname">Academic Year</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FTR_SEM" name="FTR_SEM"
                                    aria-label="Default select example" data-allow-clear="true">
                                    <option value="">-- All Data --</option>
                                    <?php
                                    $query = $this->db->get("tbl_semestertype");
                                    foreach ($query->result() as $r) {
                                    ?>
                                        <option><?= $r->SEM_NAME; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="basic-default-fullname">Semester</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FTR_PROGRAM" name="FTR_PROGRAM"
                                    aria-label="Default select example" data-allow-clear="true">
                                    <option value="">-- All Data --</option>
                                    <?php

                                    foreach ($LoadPrograms->result() as $r) {
                                    ?>
                                        <option><?= $r->P_PDESCRIPTIONS ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="basic-default-fullname">Programs</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FTR_YL" name="FTR_YL"
                                    aria-label="Default select example" data-allow-clear="true">
                                    <option value="">-- All Data --</option>
                                    <option>1ST YEAR</option>
                                    <option>2ND YEAR</option>
                                    <option>3RD YEAR</option>
                                    <option>4TH YEAR</option>
                                    <option>5TH YEAR</option>
                                </select>
                                <label for="basic-default-fullname">Year Level</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- 3 -->
    <div class="row gy-4 mb-4">
        <div class="col-md-12 col-xxl-12 order-0 order-sm-2 order-xxl-0">
            <!-- Course datatable -->
            <!-- Course datatable -->
            <div class="card mb-4 card-stats border-top border-primary border-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Enrollment by Program and Sex</h5>
                    <div class="badge bg-label-primary rounded-pill">Detailed View</div>
                </div>
                <div class="table-responsive mb-3">
                    <table class="table table-glass datatables-academy-course">
                        <thead>
                            <tr>
                                <th>Program</th>
                                <th>Academic Year</th>
                                <th>Male</th>
                                <th>Female</th>
                                <th>Total Enrolled</th>
                            </tr>
                        </thead>
                        <tbody id="program_with_enrollment">
                            <!-- AJAX will inject rows here -->
                        </tbody>

                    </table>
                </div>

            </div>
            <!-- Course datatable End -->
        </div>
    </div>

    <!-- 4 -->
    <div class="row gy-4 mb-4">
        <div class="col-md-6">
            <div class="card-body">
                <div class="row">
                    <section class="col-lg-12 connectedSortable">
                        <!-- BAR CHART -->
                        <div class="card card-dark">
                            <div class="card-header">
                                <h3 class="card-title">Enrollment by Sex and Year Level</h3>
                                <div class="badge bg-label-secondary rounded-pill mb-xl-1">
                                    Academic Year: <span id="display-academic-year">All Data</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id="enrollment_chart"></div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </section>
                    <!-- Left col -->
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-body">
                <div class="row">
                    <section class="col-lg-12 connectedSortable">
                        <!-- BAR CHART -->
                        <div class="card card-dark">
                            <div class="card-header">
                                <h3 class="card-title">Enrollment Trends</h3>
                            </div>
                            <div class="card-body">
                                <div id="enrollment_trends_chart"></div> <!-- Chart will render here -->
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </section>
                </div>
            </div>
        </div>
    </div>

    <!-- 5 -->
    <div class="row gy-4 mb-4">
        <div class="col-md-12">
            <div class="row g-6">
                <!-- PWD & Statistics -->
                <div class="row g-4 mb-4">
                    <div class="col-xl-6">
                        <div class="card h-100 card-stats">
                            <div class="card-header d-flex align-items-center justify-content-between border-bottom mb-3">
                                <h5 class="card-title m-0">PWD Distribution</h5>
                                <div class="badge bg-label-secondary rounded-pill">
                                    AY: <span id="display-academic-year-pwd">All Data</span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center p-3 border rounded-3 bg-light">
                                            <div class="avatar me-3">
                                                <span class="avatar-initial rounded bg-label-primary"><i class="ri-eye-line"></i></span>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Visual Impairment</small>
                                                <h5 class="mb-0 fw-bold" id="number-visual-impairment">0</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center p-3 border rounded-3 bg-light">
                                            <div class="avatar me-3">
                                                <span class="avatar-initial rounded bg-label-info"><i class="ri-volume-down-line"></i></span>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Hearing Loss</small>
                                                <h5 class="mb-0 fw-bold" id="number-hearing-loss">0</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center p-3 border rounded-3 bg-light">
                                            <div class="avatar me-3">
                                                <span class="avatar-initial rounded bg-label-warning"><i class="ri-walk-line"></i></span>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Orthopedic</small>
                                                <h5 class="mb-0 fw-bold" id="number-orthopedic-disability">0</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center p-3 border rounded-3 bg-light">
                                            <div class="avatar me-3">
                                                <span class="avatar-initial rounded bg-label-danger"><i class="ri-brain-line"></i></span>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Learning Disability</small>
                                                <h5 class="mb-0 fw-bold" id="number-learning-disability">0</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center p-3 border rounded-3 bg-light">
                                            <div class="avatar me-3">
                                                <span class="avatar-initial rounded bg-label-success"><i class="ri-heart-pulse-line"></i></span>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Psychosocial</small>
                                                <h5 class="mb-0 fw-bold" id="number-psychosocial-disability">0</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center p-3 border rounded-3 bg-light">
                                            <div class="avatar me-3">
                                                <span class="avatar-initial rounded bg-label-secondary"><i class="ri-mental-health-line"></i></span>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Mental Disability</small>
                                                <h5 class="mb-0 fw-bold" id="number-mental-disability">0</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="d-flex align-items-center p-3 border rounded-3 bg-light">
                                            <div class="avatar me-3">
                                                <span class="avatar-initial rounded bg-label-dark"><i class="ri-hospital-line"></i></span>
                                            </div>
                                            <div>
                                                <small class="text-muted d-block">Chronic Illness</small>
                                                <h5 class="mb-0 fw-bold" id="number-chronic-illness">0</h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Transactions -->

                    <!-- Upgrade Plan -->
                    <div class="col-md-6 col-xxl-6">
                        <div class="card">
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <div>
                                        <h5 class="card-title mb-0">PWD's</h5>
                                        <p class="text-body mb-0">Showing the Statistical Data below:</p>
                                        <div class="badge bg-label-secondary rounded-pill mb-xl-1">
                                            Academic Year: <span id="display-academic-year-pwd2">All Data</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="pwd_statistic_chart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Upgrade Plan -->
                </div>
            </div>
        </div>

        <!-- 6 -->
        <div class="row gy-4 mb-4">
            <div class="col-md-6">
                <div class="card-body">
                    <div class="row">
                        <section class="col-lg-12 connectedSortable">
                            <!-- BAR CHART -->
                            <div class="card card-dark">
                                <div class="card-header">
                                    <h3 class="card-title">Grade Perfomance Summary</h3>
                                    <div class="badge bg-label-secondary rounded-pill mb-xl-1">
                                        Academic Year: <span id="display-academic-year-grades">All Data</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="grade_performance_chart"></div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </section>
                        <!-- Left col -->
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-body">
                    <div class="row">
                        <section class="col-lg-12 connectedSortable">
                            <!-- BAR CHART -->
                            <div class="card card-dark">
                                <div class="card-header">
                                    <h3 class="card-title">Employee Status</h3>
                                    <div class="badge bg-label-secondary rounded-pill mb-xl-1">
                                        Academic Year: <span id="display-academic-year-status">All Data</span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div id="employee_status_chart"></div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </section>
                        <!-- Left col -->
                    </div>
                </div>
            </div>
        </div>

        <div class="row gy-4 mb-4">

        </div>
    </div>

    <?= $analytics_script; ?>