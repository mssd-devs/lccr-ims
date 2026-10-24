<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.85);
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
        background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
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
    }

    .table-glass tr:hover {
        background: rgba(105, 108, 255, 0.1);
        transform: scale(1.01);
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
        border: 1px solid rgba(0, 0, 0, 0.05);
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

    .filter-card {
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .text-muted-custom {
        color: #566a7f;
        font-size: 0.85rem;
        font-weight: 500;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb" class="glass-card glass-header p-3 rounded-3 mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-label-primary me-3 mb-0">
                    <i class="ri-bank-line ri-24px"></i>
                </div>
                <div>
                    <h4 class="mb-0 fw-bold text-primary">Financial Dashboard</h4>
                    <p class="mb-0 text-muted-custom small">Live financial monitoring & transaction analysis</p>
                </div>
            </div>
            <div class="d-none d-md-flex align-items-center">
                <div class="badge bg-label-success rounded-pill px-3 py-2 me-3 pulse-success">
                    <span class="d-flex align-items-center"><i class="ri-record-circle-line me-1"></i> Live Data</span>
                </div>
                <div class="text-end">
                    <p class="mb-0 text-muted-custom small">Academic Year</p>
                    <h6 class="mb-0 fw-bold" id="header-academic-year"><?= date('Y') ?>-<?= date('Y') + 1 ?></h6>
                </div>
            </div>
        </div>
    </nav>

    <!-- Card Border Shadow -->
    <div class="row g-4 mb-4">
        <!-- Total Amount Billed -->
        <div class="col-sm-6 col-lg-4">
            <div class="card card-stats glass-card h-100 border-start border-primary border-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-primary me-4 mb-0">
                            <i class="ri-money-dollar-box-line"></i>
                        </div>
                        <div>
                            <h6 class="text-muted-custom mb-1">Total Amount Billed</h6>
                            <h4 class="mb-0 fw-bold counter" id="total-amount-billed">0</h4>
                        </div>
                    </div>
                    <p class="mb-0 mt-2 small text-primary"><i class="ri-arrow-up-line"></i> Total Revenue Potential</p>
                </div>
            </div>
        </div>

        <!-- Total Payments Received -->
        <div class="col-sm-6 col-lg-4">
            <div class="card card-stats glass-card h-100 border-start border-success border-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-success me-4 mb-0">
                            <i class="ri-currency-line"></i>
                        </div>
                        <div>
                            <h6 class="text-muted-custom mb-1">Payments Received</h6>
                            <h4 class="mb-0 fw-bold counter" id="total-payments-received">0</h4>
                        </div>
                    </div>
                    <p class="mb-0 mt-2 small text-success"><i class="ri-checkbox-circle-line"></i> Actual Collections</p>
                </div>
            </div>
        </div>

        <!-- Total Discount Tuition -->
        <div class="col-sm-6 col-lg-4">
            <div class="card card-stats glass-card h-100 border-start border-warning border-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-warning me-4 mb-0">
                            <i class="ri-discount-percent-line"></i>
                        </div>
                        <div>
                            <h6 class="text-muted-custom mb-1">Total Discount Tuition</h6>
                            <h4 class="mb-0 fw-bold counter" id="total-discount-payment">0</h4>
                        </div>
                    </div>
                    <p class="mb-0 mt-2 small text-warning"><i class="ri-gift-line"></i> Vouchers & Scholarships</p>
                </div>
            </div>
        </div>

        <!-- Outstanding Balances -->
        <div class="col-sm-6 col-lg-4">
            <div class="card card-stats glass-card h-100 border-start border-danger border-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-danger me-4 mb-0">
                            <i class="ri-bank-card-line"></i>
                        </div>
                        <div>
                            <h6 class="text-muted-custom mb-1">Outstanding Balances</h6>
                            <h4 class="mb-0 fw-bold counter" id="total-outstanding-balances">0</h4>
                        </div>
                    </div>
                    <p class="mb-0 mt-2 small text-danger"><i class="ri-error-warning-line"></i> Pending Receivables</p>
                </div>
            </div>
        </div>

        <!-- Fully Paid Students -->
        <div class="col-sm-6 col-lg-4">
            <div class="card card-stats glass-card h-100 border-start border-info border-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-info me-4 mb-0">
                            <i class="ri-user-follow-line"></i>
                        </div>
                        <div>
                            <h6 class="text-muted-custom mb-1">Fully Paid Students</h6>
                            <h4 class="mb-0 fw-bold counter" id="number-fully-paid-students">0</h4>
                        </div>
                    </div>
                    <p class="mb-0 mt-2 small text-info"><i class="ri-check-double-line"></i> Cleared Accounts</p>
                </div>
            </div>
        </div>

        <!-- Students with Balance -->
        <div class="col-sm-6 col-lg-4">
            <div class="card card-stats glass-card h-100 border-start border-secondary border-3">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-2">
                        <div class="stat-icon bg-label-secondary me-4 mb-0">
                            <i class="ri-user-received-line"></i>
                        </div>
                        <div>
                            <h6 class="text-muted-custom mb-1">Students w/ Balance</h6>
                            <h4 class="mb-0 fw-bold counter" id="number-students-with-balance">0</h4>
                        </div>
                    </div>
                    <p class="mb-0 mt-2 small text-secondary"><i class="ri-time-line"></i> Installment / Unpaid</p>
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
                        <h5 class="card-title mb-0"><i class="ri-filter-3-line me-2"></i>Filter Financial Data</h5>
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill" id="btn_reset_filter">
                            <i class="ri-refresh-line me-1"></i> Reset Filters
                        </button>
                    </div>
                </div>
                <div class="card-body pt-4">
                    <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FTR_AY" name="FTR_AY" data-allow-clear="true">
                                    <option value="">-- All Data --</option>
                                    <?php
                                    $current_year = date('Y');
                                    for ($start_year = $current_year; $start_year >= 2021; $start_year--) : ?>
                                        <option value="<?php echo $start_year; ?>" <?php echo ($start_year == $current_year) ? 'selected' : ''; ?>>
                                            <?php echo $start_year . '-' . ($start_year + 1); ?></option>
                                    <?php endfor; ?>
                                </select>
                                <label>Academic Year</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FTR_SEM" name="FTR_SEM" data-allow-clear="true">
                                    <option value="">-- All Data --</option>
                                    <?php
                                    $query = $this->db->get("tbl_semestertype");
                                    foreach ($query->result() as $r) {
                                        echo "<option>{$r->SEM_NAME}</option>";
                                    }
                                    ?>
                                </select>
                                <label>Semester</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FTR_PROGRAM" name="FTR_PROGRAM" data-allow-clear="true">
                                    <option value="">-- All Data --</option>
                                    <?php
                                    foreach ($LoadPrograms->result() as $r) {
                                        echo "<option>{$r->P_PDESCRIPTIONS}</option>";
                                    }
                                    ?>
                                </select>
                                <label>Programs</label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FTR_YL" name="FTR_YL" data-allow-clear="true">
                                    <option value="">-- All Data --</option>
                                    <option>1ST YEAR</option>
                                    <option>2ND YEAR</option>
                                    <option>3RD YEAR</option>
                                    <option>4TH YEAR</option>
                                    <option>5TH YEAR</option>
                                </select>
                                <label>Year Level</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row gy-4 mb-4">
        <div class="col-md-5">
            <div class="card glass-card h-100 border-top border-primary border-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Billing Status Breakdown</h5>
                    <div class="badge bg-label-primary rounded-pill">Student Pmt Status</div>
                </div>
                <div class="card-body">
                    <div id="billing_breakdown_chart"></div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card glass-card h-100 border-top border-info border-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Voucher Breakdown</h5>
                    <div class="badge bg-label-info rounded-pill">Discount Distribution</div>
                </div>
                <div class="card-body">
                    <div id="voucher_breakdown_chart"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Collection & Transactions -->
    <div class="row gy-4 mb-4">
        <div class="col-md-12">
            <div class="row g-4">
                <div class="col-md-6 col-xxl-6">
                    <div class="card glass-card h-100 border-top border-success border-3">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="card-title m-0">Fee Collection by Program</h5>
                            <div class="badge bg-label-success rounded-pill">Collection Analytics</div>
                        </div>
                        <div class="card-body" id="fee_collection_program"></div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card glass-card h-100 border-top border-warning border-3">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title m-0">Recent Transactions</h5>
                            <div class="badge bg-label-warning rounded-pill">Latest Payments</div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-glass" id="recent_transactions_table">
                                    <thead>
                                        <tr>
                                            <th class="d-none">ID</th>
                                            <th>Student Name</th>
                                            <th>OR Number</th>
                                            <th>Amount</th>
                                            <th>Date & Time</th>
                                            <th>Encoder</th>
                                        </tr>
                                    </thead>
                                    <tbody id="recent_transactions"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).on("click", "#btn_reset_filter", function() {
        window.location.reload();
    });
</script>

<?= $financial_script; ?>