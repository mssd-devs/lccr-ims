<style>
    /* ── CSS Custom Properties (Light mode defaults) ── */
    :root {
        --gs-card-bg: linear-gradient(135deg, #fbfbfe 0%, #f1f3f9 100%);
        --gs-card-border: #e4e6ec;
        --gs-guide-bg: #f7f8ff;
        --gs-body-text: #3b3c40;
        --gs-muted-text: #555;
        --gs-limits-text: #777;
        --gs-input-border: #d9dee3;
        --gs-input-bg: #ffffff;
        --gs-readonly-bg: #f5f5f9;
        --gs-readonly-border: #e4e6e8;
        --gs-readonly-color: #3b3c40;
        --gs-tfoot-bg: #f8f8fb;
        --gs-hover-bg: rgba(105, 108, 255, 0.025);
        --gs-divider: rgba(0, 0, 0, 0.1);
    }

    /* ── Dark mode overrides ── */
    [data-bs-theme="dark"],
    .dark-style {
        --gs-card-bg: linear-gradient(135deg, #2b2c40 0%, #232333 100%);
        --gs-card-border: #3b3c55;
        --gs-guide-bg: #2a2b44;
        --gs-body-text: #d0d2e0;
        --gs-muted-text: #a0a3b5;
        --gs-limits-text: #8a8da0;
        --gs-input-border: #4a4c65;
        --gs-input-bg: #2b2c40;
        --gs-readonly-bg: #25263a !important;
        --gs-readonly-border: #3b3c55 !important;
        --gs-readonly-color: #c0c3d5;
        --gs-tfoot-bg: #25263a;
        --gs-hover-bg: rgba(105, 108, 255, 0.08);
        --gs-divider: rgba(255, 255, 255, 0.08);
    }

    /* ── Component Styles ── */
    .grade-header-card {
        background: var(--gs-card-bg);
        border: 1px solid var(--gs-card-border);
        border-radius: 0.75rem;
    }

    .guide-card {
        border-left: 4px solid #696cff !important;
        background-color: var(--gs-guide-bg);
    }

    .grade-table-card {
        border-radius: 0.75rem;
        overflow: hidden;
        border: 1px solid var(--gs-card-border);
    }

    /* Grade inputs */
    .grade-input {
        text-align: center;
        font-weight: 600;
        border-radius: 0.375rem;
        transition: all 0.2s ease-in-out;
        border: 1.5px solid var(--gs-input-border);
        background-color: var(--gs-input-bg) !important;
        color: var(--gs-body-text) !important;
        padding: 0.35rem 0.4rem;
        font-size: 0.875rem;
        width: 100%;
    }

    .grade-input:focus {
        border-color: #696cff !important;
        box-shadow: 0 0 0.25rem 0.05rem rgba(105, 108, 255, 0.25) !important;
        background-color: var(--gs-input-bg) !important;
        color: var(--gs-body-text) !important;
        outline: none;
    }

    .grade-input.is-invalid-grade {
        border-color: #ff3e1d !important;
        background-color: rgba(255, 62, 29, 0.06) !important;
        color: #ff3e1d !important;
    }

    .grade-input.is-valid-grade {
        border-color: #71dd37 !important;
        background-color: rgba(113, 221, 55, 0.04) !important;
        color: var(--gs-body-text) !important;
    }

    /* Read-only computed fields */
    .readonly-grade {
        background-color: var(--gs-readonly-bg) !important;
        font-weight: 700;
        text-align: center;
        border: 1.5px solid var(--gs-readonly-border) !important;
        color: var(--gs-readonly-color) !important;
        font-size: 0.875rem;
        padding: 0.35rem 0.4rem;
        width: 100%;
        border-radius: 0.375rem;
    }

    .remarks-input {
        font-size: 0.8rem;
        font-weight: 600;
        width: 100%;
        border-radius: 0.375rem;
        padding: 0.35rem 0.4rem;
        text-align: center;
        color: var(--gs-readonly-color) !important;
        background-color: var(--gs-readonly-bg) !important;
    }

    /* Force correct text color in table body cells (overrides app theme white-text defaults) */
    #tbl_body td,
    #tbl_body th {
        color: var(--gs-body-text) !important;
    }

    .gs-tfoot td {
        color: var(--gs-body-text) !important;
    }

    /* Force thead th to inherit color from tr (e.g. #fff and #cdd0e0) overriding global theme rules */
    .grade-table-card thead th {
        color: inherit !important;
    }

    /* Table hover */
    #tbl_body tr:hover td {
        background-color: var(--gs-hover-bg);
    }

    /* Guide card text */
    .gs-guide-text {
        font-size: 0.83rem;
        color: var(--gs-muted-text);
    }

    .gs-limits-text {
        font-size: 0.8rem;
        color: var(--gs-limits-text);
    }

    /* Table footer */
    .gs-tfoot {
        background-color: var(--gs-tfoot-bg);
    }

    /* Info label in header card */
    .gs-info-label {
        font-size: 0.7rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: var(--gs-limits-text);
    }

    .gs-info-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: var(--gs-body-text);
    }

    .gs-subject-title {
        color: var(--gs-body-text);
    }

    kbd {
        background-color: #435971;
        color: #fff;
        padding: 0.15rem 0.4rem;
        border-radius: 4px;
        font-size: 0.75rem;
        font-family: inherit;
        box-shadow: inset 0 -1px 0 rgba(0, 0, 0, .25);
    }

    .info-item {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .info-item-icon {
        flex-shrink: 0;
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.1rem;
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Grading System</a>
            </li>
            <li class="breadcrumb-item">
                <a href="<?= base_url('ims/gradingsystem') ?>">List of Classes</a>
            </li>
            <li class="breadcrumb-item active">Encoding of Grades</li>
        </ol>
    </nav>

    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card border-0 shadow-none">
                <div class="card-body p-0">

                    <?php
                    $query = $this->db->where("ID", $this->uri->segment(4))->get("tbl_scheduling");
                    foreach ($query->result() as $rows) {
                        if ($rows->ID == $this->uri->segment(4)) {
                            $disableSave = false;

                            // Retrieve S_SUBTYPE for the subject
                            $subject_row = $this->db->get_where("tbl_subject", [
                                "S_SDESCRIPTION" => $rows->SC_SDESC,
                                "S_SELECTPROG" => $rows->SC_PROG,
                                "S_MAJOR" => $rows->SC_MAJOR
                            ])->row();

                            if (!$subject_row) {
                                $subject_row = $this->db->get_where("tbl_subject", [
                                    "S_SDESCRIPTION" => $rows->SC_SDESC,
                                    "S_SELECTPROG" => $rows->SC_PROG
                                ])->row();
                            }
                            if (!$subject_row) {
                                $subject_row = $this->db->get_where("tbl_subject", [
                                    "S_SDESCRIPTION" => $rows->SC_SDESC
                                ])->row();
                            }
                            $subject_subtype = ($subject_row && !empty($subject_row->S_SUBTYPE)) ? strtoupper(trim($subject_row->S_SUBTYPE)) : 'MINOR';

                            $sched_id = $rows->ID;
                            $config = $this->db->get_where("tbl_grading_config", ["GC_SCHEDID" => $sched_id])->row();
                    ?>


                                <!-- ========== SUBJECT INFORMATION CARD ========== -->
                                <div class="card mb-4 grade-header-card shadow-sm border-0">
                                    <div class="card-body p-4">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-lg-8 col-12">
                                                <span class="badge bg-label-primary mb-2 px-2 py-1 text-uppercase fw-semibold" style="font-size: 0.7rem; letter-spacing: 0.05em;">
                                                    <i class="ri-calendar-event-line me-1"></i> Class Schedule
                                                </span>
                                                <h4 class="fw-bold mb-1 gs-subject-title"><?= $rows->SC_SDESC; ?></h4>
                                                <div class="d-flex flex-wrap gap-3 text-muted mt-1" style="font-size: 0.85rem;">
                                                    <span><i class="ri-hashtag me-1"></i><strong>Code:</strong> <?= $rows->SC_CLASSCODE; ?></span>
                                                    <span><i class="ri-book-2-line me-1"></i><strong>Program:</strong> <?= $rows->SC_PROG; ?><?= $rows->SC_MAJOR ? " ({$rows->SC_MAJOR})" : ""; ?></span>
                                                    <span><i class="ri-building-line me-1"></i><strong>Dept:</strong> <?= $rows->SC_DEPT; ?></span>
                                                    <span><i class="ri-slideshow-2-line me-1"></i><strong>Method:</strong> <?= $rows->SC_TEACHMODELS; ?></span>
                                                    <span><i class="ri-price-tag-line me-1"></i><strong>Type:</strong> <span class="badge bg-label-<?= $subject_subtype === 'MAJOR' ? 'info' : 'primary' ?>"><?= $subject_subtype; ?></span></span>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-12 text-lg-end mt-3 mt-lg-0 d-flex flex-wrap gap-2 justify-content-lg-end">
                                                <?php if (!empty($config)): ?>
                                                    <button type="button" class="btn btn-outline-warning shadow-sm" data-bs-toggle="modal" data-bs-target="#adjustStructureModal">
                                                        <i class="ri-settings-4-line me-1"></i> Adjust Weights
                                                    </button>
                                                <?php endif; ?>
                                                <button type="button" class="btn btn-outline-primary shadow-sm" data-bs-toggle="modal" data-bs-target="#transmutationTableModal">
                                                    <i class="ri-file-list-3-line me-1"></i> Transmutation Table
                                                </button>
                                            </div>
                                        </div>
                                        <hr class="my-3 opacity-25">
                                        <div class="row g-3">
                                            <div class="col-6 col-md-3">
                                                <div class="info-item">
                                                    <div class="info-item-icon bg-label-info">
                                                        <i class="ri-calendar-line text-info"></i>
                                                    </div>
                                                    <div>
                                                        <small class="d-block gs-info-label">Academic Year</small>
                                                        <span class="gs-info-value"><?= $rows->SC_ACADEMICYEAR . '-' . ($rows->SC_ACADEMICYEAR + 1); ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="info-item">
                                                    <div class="info-item-icon bg-label-warning">
                                                        <i class="ri-compass-3-line text-warning"></i>
                                                    </div>
                                                    <div>
                                                        <small class="d-block gs-info-label">Semester / Year Level</small>
                                                        <span class="gs-info-value"><?= $rows->SC_SEMESTER; ?> &bull; <?= $rows->SC_YEARLEVEL; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="info-item">
                                                    <div class="info-item-icon bg-label-success">
                                                        <i class="ri-team-line text-success"></i>
                                                    </div>
                                                    <div>
                                                        <small class="d-block gs-info-label">Section &amp; Room</small>
                                                        <span class="gs-info-value"><?= $rows->SC_SECTION; ?> &bull; Room <?= $rows->SC_ROOM; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 col-md-3">
                                                <div class="info-item">
                                                    <div class="info-item-icon bg-label-danger">
                                                        <i class="ri-time-line text-danger"></i>
                                                    </div>
                                                    <div>
                                                        <small class="d-block gs-info-label">Schedule</small>
                                                        <span class="gs-info-value"><?= $rows->SC_STARTTIME . ' – ' . $rows->SC_ENDTIME; ?> (<?= $rows->SC_DAY; ?>)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <?php if (empty($config)): ?>
                                    <!-- Scenario A: Setup grading configuration form -->
                                    <div class="card mb-4 border-0 shadow-sm grade-header-card">
                                        <div class="card-body p-4">
                                            <h5 class="fw-bold mb-3 text-primary"><i class="ri-settings-4-line me-2"></i>Configure Grading System Weights</h5>
                                            <p class="text-muted small">No grading structure configured for this class schedule yet. Please customize the active components, percentage weights, and maximum raw scores below. The sum of all active weights must equal exactly 100%.</p>
                                            
                                            <form id="configForm" method="post">
                                                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                                <input type="hidden" name="GC_SCHEDID" value="<?= $sched_id; ?>">
                                                
                                                <div class="table-responsive">
                                                    <table class="table align-middle table-hover">
                                                        <thead class="table-light">
                                                            <tr>
                                                                <th style="width: 80px;">Active</th>
                                                                <th>Grading Component</th>
                                                                <th style="width: 250px;">Percentage Weight (%)</th>
                                                                <th style="width: 250px;">Maximum Raw Score</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input comp-active" type="checkbox" name="GC_ATTENDANCE_ACTIVE" id="active_attendance" value="1" checked>
                                                                    </div>
                                                                </td>
                                                                <td><label class="fw-semibold" for="active_attendance">Attendance</label></td>
                                                                <td><input type="number" class="form-control comp-weight" name="GC_ATTENDANCE_PCT" value="10" min="0" max="100" step="0.5"></td>
                                                                <td><input type="number" class="form-control comp-max" name="GC_ATTENDANCE_MAX" value="10" min="1"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input comp-active" type="checkbox" name="GC_EXAMPRELIM_ACTIVE" id="active_prelim" value="1" checked>
                                                                    </div>
                                                                </td>
                                                                <td><label class="fw-semibold" for="active_prelim">Prelim Exam</label></td>
                                                                <td><input type="number" class="form-control comp-weight" name="GC_EXAMPRELIM_PCT" value="10" min="0" max="100" step="0.5"></td>
                                                                <td><input type="number" class="form-control comp-max" name="GC_EXAMPRELIM_MAX" value="10" min="1"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input comp-active" type="checkbox" name="GC_EXAMMIDTERM_ACTIVE" id="active_midterm" value="1" checked>
                                                                    </div>
                                                                </td>
                                                                <td><label class="fw-semibold" for="active_midterm">Midterm Exam</label></td>
                                                                <td><input type="number" class="form-control comp-weight" name="GC_EXAMMIDTERM_PCT" value="15" min="0" max="100" step="0.5"></td>
                                                                <td><input type="number" class="form-control comp-max" name="GC_EXAMMIDTERM_MAX" value="15" min="1"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input comp-active" type="checkbox" name="GC_EXAMFINAL_ACTIVE" id="active_final_exam" value="1" checked>
                                                                    </div>
                                                                </td>
                                                                <td><label class="fw-semibold" for="active_final_exam">Final Exam</label></td>
                                                                <td><input type="number" class="form-control comp-weight" name="GC_EXAMFINAL_PCT" value="20" min="0" max="100" step="0.5"></td>
                                                                <td><input type="number" class="form-control comp-max" name="GC_EXAMFINAL_MAX" value="20" min="1"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input comp-active" type="checkbox" name="GC_FINALREQ_ACTIVE" id="active_final_req" value="1" checked>
                                                                    </div>
                                                                </td>
                                                                <td><label class="fw-semibold" for="active_final_req">Final Requirement</label></td>
                                                                <td><input type="number" class="form-control comp-weight" name="GC_FINALREQ_PCT" value="10" min="0" max="100" step="0.5"></td>
                                                                <td><input type="number" class="form-control comp-max" name="GC_FINALREQ_MAX" value="10" min="1"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input comp-active" type="checkbox" name="GC_PERFORMANCE_ACTIVE" id="active_performance" value="1" checked>
                                                                    </div>
                                                                </td>
                                                                <td><label class="fw-semibold" for="active_performance">Performance Tasks</label></td>
                                                                <td><input type="number" class="form-control comp-weight" name="GC_PERFORMANCE_PCT" value="20" min="0" max="100" step="0.5"></td>
                                                                <td><input type="number" class="form-control comp-max" name="GC_PERFORMANCE_MAX" value="20" min="1"></td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                    <div class="form-check form-switch">
                                                                        <input class="form-check-input comp-active" type="checkbox" name="GC_WRITTEN_ACTIVE" id="active_written" value="1" checked>
                                                                    </div>
                                                                </td>
                                                                <td><label class="fw-semibold" for="active_written">Written Tasks</label></td>
                                                                <td><input type="number" class="form-control comp-weight" name="GC_WRITTEN_PCT" value="15" min="0" max="100" step="0.5"></td>
                                                                <td><input type="number" class="form-control comp-max" name="GC_WRITTEN_MAX" value="15" min="1"></td>
                                                            </tr>
                                                        </tbody>
                                                        <tfoot class="table-light">
                                                            <tr>
                                                                <td colspan="2" class="text-end fw-bold">Total Percentage:</td>
                                                                <td class="fw-bold"><span id="config_total_pct" class="text-success">100</span>%</td>
                                                                <td></td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                
                                                <div class="d-flex justify-content-between align-items-center mt-4">
                                                    <a href="<?= base_url('ims/gradingsystem') ?>" class="btn btn-outline-secondary">
                                                        <i class="ri-arrow-left-line me-1"></i> Back to List
                                                    </a>
                                                    <button type="submit" class="btn btn-primary" id="btnSaveConfig" disabled>
                                                        <i class="ri-table-line me-1"></i> Generate Grading Table
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <!-- Scenario B: Config exists, show dynamic grading table -->
                                    <form id="submitForm" action="" method="post">
                                        <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                        <input type="hidden" name="GS_STATUS" id="GS_STATUS">
                                        <input type="hidden" id="GS_SCHEDID" name="GS_SCHEDID" value="<?= $this->uri->segment(4); ?>">
                                        <input type="hidden" id="GS_SUBJECT" name="GS_SUBJECT" value="<?= $rows->SC_SDESC; ?>">
                                        <input type="hidden" id="GS_YEARLEVEL" name="GS_YEARLEVEL" value="<?= $rows->SC_YEARLEVEL; ?>">
                                        <input type="hidden" id="GS_SECTION" name="GS_SECTION" value="<?= $rows->SC_SECTION; ?>">
                                        <input type="hidden" id="GS_CLASSCODE" name="GS_CLASSCODE" value="<?= $rows->SC_CLASSCODE; ?>">
                                        <input type="hidden" id="GS_ACADEMICYEAR" name="GS_ACADEMICYEAR" value="<?= $rows->SC_ACADEMICYEAR; ?>">
                                        <input type="hidden" id="GS_SEMESTER" name="GS_SEMESTER" value="<?= $rows->SC_SEMESTER; ?>">

                                        <!-- ========== GRADING ENTRY GUIDE CARD ========== -->
                                        <div class="card mb-4 guide-card border-0 shadow-sm">
                                            <div class="card-body py-3 px-4">
                                                <div class="row align-items-start g-3">
                                                    <div class="col-auto d-none d-md-block">
                                                        <div style="width:42px; height:42px; border-radius:10px; background: rgba(105,108,255,0.12); display:flex; align-items:center; justify-content:center;">
                                                            <i class="ri-lightbulb-flash-line fs-4 text-primary"></i>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <h6 class="fw-bold text-primary mb-2">How to Enter Grading</h6>
                                                        <div class="row g-2">
                                                            <div class="col-md-4">
                                                                <div class="d-flex align-items-start gap-2">
                                                                    <i class="ri-keyboard-line text-primary mt-1" style="flex-shrink:0;"></i>
                                                                    <div class="gs-guide-text">
                                                                        <strong>Navigate:</strong> Use <kbd>Tab</kbd> to move to the next field, <kbd>Shift + Tab</kbd> to go back.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="d-flex align-items-start gap-2">
                                                                    <i class="ri-shield-check-line text-success mt-1" style="flex-shrink:0;"></i>
                                                                    <div class="gs-guide-text">
                                                                        <strong>Limits:</strong> Each column has a max score. Fields exceeding the limit turn <span style="color:#ff3e1d; font-weight:700;">red</span>. Fix them before saving.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="d-flex align-items-start gap-2">
                                                                    <i class="ri-calculator-line text-info mt-1" style="flex-shrink:0;"></i>
                                                                    <div class="gs-guide-text">
                                                                        <strong>Auto-Computed:</strong> Final Grade, Transmuted Equivalent, and Remarks are calculated automatically — do not edit them.
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="mt-2 pt-2 border-top border-light-subtle gs-limits-text">
                                                            <i class="ri-information-line me-1 text-warning"></i>
                                                            <strong>Column Limits:</strong>
                                                            <?php if ($config->GC_ATTENDANCE_ACTIVE): ?>
                                                                Attendance <span class="badge bg-label-primary" style="font-size:0.7rem;">max <?= $config->GC_ATTENDANCE_MAX; ?> (<?= $config->GC_ATTENDANCE_PCT; ?>%)</span>
                                                            <?php endif; ?>
                                                            <?php if ($config->GC_EXAMPRELIM_ACTIVE): ?>
                                                                &bull; Prelim Exam <span class="badge bg-label-info" style="font-size:0.7rem;">max <?= $config->GC_EXAMPRELIM_MAX; ?> (<?= $config->GC_EXAMPRELIM_PCT; ?>%)</span>
                                                            <?php endif; ?>
                                                            <?php if ($config->GC_EXAMMIDTERM_ACTIVE): ?>
                                                                &bull; Midterm Exam <span class="badge bg-label-info" style="font-size:0.7rem;">max <?= $config->GC_EXAMMIDTERM_MAX; ?> (<?= $config->GC_EXAMMIDTERM_PCT; ?>%)</span>
                                                            <?php endif; ?>
                                                            <?php if ($config->GC_EXAMFINAL_ACTIVE): ?>
                                                                &bull; Final Exam <span class="badge bg-label-info" style="font-size:0.7rem;">max <?= $config->GC_EXAMFINAL_MAX; ?> (<?= $config->GC_EXAMFINAL_PCT; ?>%)</span>
                                                            <?php endif; ?>
                                                            <?php if ($config->GC_FINALREQ_ACTIVE): ?>
                                                                &bull; Final Req <span class="badge bg-label-primary" style="font-size:0.7rem;">max <?= $config->GC_FINALREQ_MAX; ?> (<?= $config->GC_FINALREQ_PCT; ?>%)</span>
                                                            <?php endif; ?>
                                                            <?php if ($config->GC_PERFORMANCE_ACTIVE): ?>
                                                                &bull; Performance <span class="badge bg-label-primary" style="font-size:0.7rem;">max <?= $config->GC_PERFORMANCE_MAX; ?> (<?= $config->GC_PERFORMANCE_PCT; ?>%)</span>
                                                            <?php endif; ?>
                                                            <?php if ($config->GC_WRITTEN_ACTIVE): ?>
                                                                &bull; Written <span class="badge bg-label-primary" style="font-size:0.7rem;">max <?= $config->GC_WRITTEN_MAX; ?> (<?= $config->GC_WRITTEN_PCT; ?>%)</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ========== GRADES ENTRY TABLE ========== -->
                                        <div class="card grade-table-card shadow-sm mb-4 border-0">
                                            <div class="table-responsive" style="overflow-x: auto;">
                                                <table class="table text-center align-middle mb-0" style="min-width: 1580px; font-size: 0.875rem;">
                                                    <thead>
                                                        <tr style="background: #343a55; color: #fff;">
                                                            <th rowspan="2" class="align-middle py-3" style="width: 50px; border-right: 1px solid rgba(255,255,255,0.1);">#</th>
                                                            <th rowspan="2" class="align-middle text-start py-3" style="min-width: 220px; border-right: 1px solid rgba(255,255,255,0.1);">Student Name</th>
                                                            <?php if ($config->GC_ATTENDANCE_ACTIVE): ?>
                                                                <th class="py-2" style="background: rgba(105,108,255,0.3);">Attendance<br><small style="font-weight:400; opacity:0.8;"><?= $config->GC_ATTENDANCE_PCT; ?>%</small></th>
                                                            <?php endif; ?>
                                                            <?php if ($config->GC_EXAMPRELIM_ACTIVE || $config->GC_EXAMMIDTERM_ACTIVE || $config->GC_EXAMFINAL_ACTIVE): ?>
                                                                <th colspan="<?= ($config->GC_EXAMPRELIM_ACTIVE ? 1 : 0) + ($config->GC_EXAMMIDTERM_ACTIVE ? 1 : 0) + ($config->GC_EXAMFINAL_ACTIVE ? 1 : 0) ?>" class="py-2" style="background: rgba(3,195,236,0.2);">Exam Scores</th>
                                                            <?php endif; ?>
                                                            <?php if ($config->GC_FINALREQ_ACTIVE): ?>
                                                                <th class="py-2" style="background: rgba(105,108,255,0.3);">Final Req<br><small style="font-weight:400; opacity:0.8;"><?= $config->GC_FINALREQ_PCT; ?>%</small></th>
                                                            <?php endif; ?>
                                                            <?php if ($config->GC_PERFORMANCE_ACTIVE): ?>
                                                                <th class="py-2" style="background: rgba(105,108,255,0.3);">Performance<br><small style="font-weight:400; opacity:0.8;"><?= $config->GC_PERFORMANCE_PCT; ?>%</small></th>
                                                            <?php endif; ?>
                                                            <?php if ($config->GC_WRITTEN_ACTIVE): ?>
                                                                <th class="py-2" style="background: rgba(105,108,255,0.3);">Written Tasks<br><small style="font-weight:400; opacity:0.8;"><?= $config->GC_WRITTEN_PCT; ?>%</small></th>
                                                            <?php endif; ?>
                                                            <th rowspan="2" class="align-middle py-3" style="background: rgba(255,255,255,0.08); min-width: 90px; border-left: 1px solid rgba(255,255,255,0.1);">Final<br><small style="font-weight:400; opacity:0.8;">100%</small></th>
                                                            <th rowspan="2" class="align-middle py-3" style="background: rgba(255,255,255,0.08); min-width: 90px;">Transmuted</th>
                                                            <th rowspan="2" class="align-middle py-3" style="background: rgba(255,255,255,0.08); min-width: 130px; border-left: 1px solid rgba(255,255,255,0.1);">Remarks</th>
                                                        </tr>
                                                        <tr style="background: #3d4263; color: #cdd0e0; font-size: 0.78rem;">
                                                            <?php if ($config->GC_ATTENDANCE_ACTIVE): ?>
                                                                <th class="py-2" style="background: rgba(105,108,255,0.2);">Max <?= $config->GC_ATTENDANCE_MAX; ?></th>
                                                            <?php endif; ?>
                                                            <?php if ($config->GC_EXAMPRELIM_ACTIVE): ?>
                                                                <th class="py-2" style="background: rgba(3,195,236,0.15); border-left: 1px solid rgba(255,255,255,0.1);">Prelim<br>Max <?= $config->GC_EXAMPRELIM_MAX; ?> (<?= $config->GC_EXAMPRELIM_PCT; ?>%)</th>
                                                            <?php endif; ?>
                                                            <?php if ($config->GC_EXAMMIDTERM_ACTIVE): ?>
                                                                <th class="py-2" style="background: rgba(3,195,236,0.15);">Midterm<br>Max <?= $config->GC_EXAMMIDTERM_MAX; ?> (<?= $config->GC_EXAMMIDTERM_PCT; ?>%)</th>
                                                            <?php endif; ?>
                                                            <?php if ($config->GC_EXAMFINAL_ACTIVE): ?>
                                                                <th class="py-2" style="background: rgba(3,195,236,0.15); border-right: 1px solid rgba(255,255,255,0.1);">Final<br>Max <?= $config->GC_EXAMFINAL_MAX; ?> (<?= $config->GC_EXAMFINAL_PCT; ?>%)</th>
                                                            <?php endif; ?>
                                                            <?php if ($config->GC_FINALREQ_ACTIVE): ?>
                                                                <th class="py-2" style="background: rgba(105,108,255,0.2);">Max <?= $config->GC_FINALREQ_MAX; ?></th>
                                                            <?php endif; ?>
                                                            <?php if ($config->GC_PERFORMANCE_ACTIVE): ?>
                                                                <th class="py-2" style="background: rgba(105,108,255,0.2);">Max <?= $config->GC_PERFORMANCE_MAX; ?></th>
                                                            <?php endif; ?>
                                                            <?php if ($config->GC_WRITTEN_ACTIVE): ?>
                                                                <th class="py-2" style="background: rgba(105,108,255,0.2);">Max <?= $config->GC_WRITTEN_MAX; ?></th>
                                                            <?php endif; ?>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbl_body">
                                                        <?php
                                                        $i = 1;
                                                        $hasData = false;

                                                        $enrollment_query = $this->db->where("ER_SEMESTER", $rows->SC_SEMESTER)->get("tbl_enrollment");
                                                        foreach ($enrollment_query->result() as $r) {
                                                            if ($r->ER_SECTION == $rows->SC_SECTION) {
                                                                $stud = $this->db->where("SP_STUDID", $r->ER_STUDENTID)->get("tbl_studprof")->row();
                                                                if ($stud) {
                                                                    $hasData = true;
                                                                    $student_id = $r->ER_STUDENTID;

                                                                    $existing = $this->db->where([
                                                                        "GS_SCHEDID" => $rows->ID,
                                                                        "GS_STUDENTID" => $student_id
                                                                    ])->get("tbl_gradingsystem")->row();
                                                        ?>
                                                                    <tr>
                                                                        <td class="text-muted" style="font-size: 0.8rem;"><?= $i++; ?></td>
                                                                        <td class="text-start ps-3">
                                                                            <input type="hidden" name="GS_STUDENTID[]" value="<?= $student_id; ?>">
                                                                            <input type="hidden" name="GS_FULLNAME[]"
                                                                                value="<?= $stud->SP_FIRSTNAME . ' ' . $stud->SP_MIDDLENAME . ' ' . $stud->SP_LASTNAME; ?>">
                                                                            <span class="fw-semibold gs-subject-title"><?= $stud->SP_FIRSTNAME . ' ' . ($stud->SP_MIDDLENAME ? $stud->SP_MIDDLENAME[0] . '. ' : '') . $stud->SP_LASTNAME; ?></span>
                                                                        </td>
                                                                        
                                                                        <!-- Attendance -->
                                                                        <?php if ($config->GC_ATTENDANCE_ACTIVE): ?>
                                                                            <td style="padding: 0.4rem 0.3rem;">
                                                                                <input type="number" name="GS_ATTENDANCE[]"
                                                                                    class="grade-input grade attendance" step="0.01" min="0" max="<?= $config->GC_ATTENDANCE_MAX; ?>"
                                                                                    placeholder="0–<?= $config->GC_ATTENDANCE_MAX; ?>"
                                                                                    value="<?= $existing ? $existing->GS_ATTENDANCE : ''; ?>">
                                                                            </td>
                                                                        <?php else: ?>
                                                                            <input type="hidden" name="GS_ATTENDANCE[]" value="">
                                                                        <?php endif; ?>

                                                                        <!-- Prelim Exam -->
                                                                        <?php if ($config->GC_EXAMPRELIM_ACTIVE): ?>
                                                                            <td style="padding: 0.4rem 0.3rem;">
                                                                                <input type="number" name="GS_EXAMPRELIM[]"
                                                                                    class="grade-input grade exam-p" step="0.01" min="0" max="<?= $config->GC_EXAMPRELIM_MAX; ?>"
                                                                                    placeholder="0–<?= $config->GC_EXAMPRELIM_MAX; ?>"
                                                                                    value="<?= $existing ? $existing->GS_EXAMPRELIM : ''; ?>">
                                                                            </td>
                                                                        <?php else: ?>
                                                                            <input type="hidden" name="GS_EXAMPRELIM[]" value="">
                                                                        <?php endif; ?>

                                                                        <!-- Midterm Exam -->
                                                                        <?php if ($config->GC_EXAMMIDTERM_ACTIVE): ?>
                                                                            <td style="padding: 0.4rem 0.3rem;">
                                                                                <input type="number" name="GS_EXAMMIDTERM[]"
                                                                                    class="grade-input grade exam-m" step="0.01" min="0" max="<?= $config->GC_EXAMMIDTERM_MAX; ?>"
                                                                                    placeholder="0–<?= $config->GC_EXAMMIDTERM_MAX; ?>"
                                                                                    value="<?= $existing ? $existing->GS_EXAMMIDTERM : ''; ?>">
                                                                            </td>
                                                                        <?php else: ?>
                                                                            <input type="hidden" name="GS_EXAMMIDTERM[]" value="">
                                                                        <?php endif; ?>

                                                                        <!-- Final Exam -->
                                                                        <?php if ($config->GC_EXAMFINAL_ACTIVE): ?>
                                                                            <td style="padding: 0.4rem 0.3rem;">
                                                                                <input type="number" name="GS_EXAMFINAL[]"
                                                                                    class="grade-input grade exam-f" step="0.01" min="0" max="<?= $config->GC_EXAMFINAL_MAX; ?>"
                                                                                    placeholder="0–<?= $config->GC_EXAMFINAL_MAX; ?>"
                                                                                    value="<?= $existing ? $existing->GS_EXAMFINAL : ''; ?>">
                                                                            </td>
                                                                        <?php else: ?>
                                                                            <input type="hidden" name="GS_EXAMFINAL[]" value="">
                                                                        <?php endif; ?>

                                                                        <!-- Final Req -->
                                                                        <?php if ($config->GC_FINALREQ_ACTIVE): ?>
                                                                            <td style="padding: 0.4rem 0.3rem;">
                                                                                <input type="number" name="GS_FINALREQ[]"
                                                                                    class="grade-input grade final-req" step="0.01" min="0" max="<?= $config->GC_FINALREQ_MAX; ?>"
                                                                                    placeholder="0–<?= $config->GC_FINALREQ_MAX; ?>"
                                                                                    value="<?= $existing ? $existing->GS_FINALREQ : ''; ?>">
                                                                            </td>
                                                                        <?php else: ?>
                                                                            <input type="hidden" name="GS_FINALREQ[]" value="">
                                                                        <?php endif; ?>

                                                                        <!-- Performance -->
                                                                        <?php if ($config->GC_PERFORMANCE_ACTIVE): ?>
                                                                            <td style="padding: 0.4rem 0.3rem;">
                                                                                <input type="number" name="GS_PERFORMANCE[]"
                                                                                    class="grade-input grade performance" step="0.01" min="0" max="<?= $config->GC_PERFORMANCE_MAX; ?>"
                                                                                    placeholder="0–<?= $config->GC_PERFORMANCE_MAX; ?>"
                                                                                    value="<?= $existing ? $existing->GS_PERFORMANCE : ''; ?>">
                                                                            </td>
                                                                        <?php else: ?>
                                                                            <input type="hidden" name="GS_PERFORMANCE[]" value="">
                                                                        <?php endif; ?>

                                                                        <!-- Written -->
                                                                        <?php if ($config->GC_WRITTEN_ACTIVE): ?>
                                                                            <td style="padding: 0.4rem 0.3rem;">
                                                                                <input type="number" name="GS_WRITTEN[]"
                                                                                    class="grade-input grade written" step="0.01" min="0" max="<?= $config->GC_WRITTEN_MAX; ?>"
                                                                                    placeholder="0–<?= $config->GC_WRITTEN_MAX; ?>"
                                                                                    value="<?= $existing ? $existing->GS_WRITTEN : ''; ?>">
                                                                            </td>
                                                                        <?php else: ?>
                                                                            <input type="hidden" name="GS_WRITTEN[]" value="">
                                                                        <?php endif; ?>

                                                                        <td style="padding: 0.4rem 0.3rem;">
                                                                            <input type="number" name="GS_FINALGRADE[]"
                                                                                class="readonly-grade final-grade" readonly
                                                                                value="<?= $existing ? $existing->GS_FINALGRADE : ''; ?>">
                                                                        </td>
                                                                        <td style="padding: 0.4rem 0.3rem;">
                                                                            <input type="text" name="GS_TRANSMUTED[]"
                                                                                class="readonly-grade transmuted-grade" readonly
                                                                                value="<?= $existing ? $existing->GS_TRANSMUTED : ''; ?>">
                                                                        </td>
                                                                        <td style="padding: 0.4rem 0.3rem;">
                                                                            <input type="hidden" name="GS_GRADE[]" class="gs-grade"
                                                                                value="<?= $existing ? $existing->GS_TRANSMUTED : ''; ?>">
                                                                            <input type="text" name="GS_REMARKS[]"
                                                                                class="readonly-grade remarks-input remarks" readonly
                                                                                value="<?= $existing ? $existing->GS_REMARKS : ''; ?>">
                                                                        </td>
                                                                    </tr>
                                                        <?php
                                                                }
                                                            }
                                                        }

                                                        if (!$hasData) {
                                                            echo '<tr><td colspan="12" class="text-center py-5 text-muted">
                                                                <i class="ri-user-unfollow-line fs-2 d-block mb-2"></i>
                                                                No students currently enrolled in this class.
                                                            </td></tr>';
                                                        }
                                                        ?>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr class="gs-tfoot">
                                                            <td colspan="2" class="text-start ps-3 py-3 fw-semibold text-muted" style="font-size: 0.85rem;">
                                                                Total Students: <span class="badge bg-primary rounded-pill ms-1"><?= $i - 1; ?></span>
                                                            </td>
                                                            <td colspan="10"></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Calculation JavaScript Constants -->
                                        <script>
                                            const CONFIG = {
                                                attendance: {
                                                    active: <?= $config->GC_ATTENDANCE_ACTIVE ? 'true' : 'false'; ?>,
                                                    pct: <?= $config->GC_ATTENDANCE_PCT; ?>,
                                                    max: <?= $config->GC_ATTENDANCE_MAX; ?>
                                                },
                                                examP: {
                                                    active: <?= $config->GC_EXAMPRELIM_ACTIVE ? 'true' : 'false'; ?>,
                                                    pct: <?= $config->GC_EXAMPRELIM_PCT; ?>,
                                                    max: <?= $config->GC_EXAMPRELIM_MAX; ?>
                                                },
                                                examM: {
                                                    active: <?= $config->GC_EXAMMIDTERM_ACTIVE ? 'true' : 'false'; ?>,
                                                    pct: <?= $config->GC_EXAMMIDTERM_PCT; ?>,
                                                    max: <?= $config->GC_EXAMMIDTERM_MAX; ?>
                                                },
                                                examF: {
                                                    active: <?= $config->GC_EXAMFINAL_ACTIVE ? 'true' : 'false'; ?>,
                                                    pct: <?= $config->GC_EXAMFINAL_PCT; ?>,
                                                    max: <?= $config->GC_EXAMFINAL_MAX; ?>
                                                },
                                                finalReq: {
                                                    active: <?= $config->GC_FINALREQ_ACTIVE ? 'true' : 'false'; ?>,
                                                    pct: <?= $config->GC_FINALREQ_PCT; ?>,
                                                    max: <?= $config->GC_FINALREQ_MAX; ?>
                                                },
                                                performance: {
                                                    active: <?= $config->GC_PERFORMANCE_ACTIVE ? 'true' : 'false'; ?>,
                                                    pct: <?= $config->GC_PERFORMANCE_PCT; ?>,
                                                    max: <?= $config->GC_PERFORMANCE_MAX; ?>
                                                },
                                                written: {
                                                    active: <?= $config->GC_WRITTEN_ACTIVE ? 'true' : 'false'; ?>,
                                                    pct: <?= $config->GC_WRITTEN_PCT; ?>,
                                                    max: <?= $config->GC_WRITTEN_MAX; ?>
                                                }
                                            };
                                        </script>

                                        <script>
                                            function validateInput(input) {
                                                if (!input) return true;
                                                const val = parseFloat(input.value);
                                                const max = parseFloat(input.getAttribute("max"));
                                                if (input.value !== "" && (isNaN(val) || val < 0 || val > max)) {
                                                    input.classList.add("is-invalid-grade");
                                                    input.classList.remove("is-valid-grade");
                                                    return false;
                                                } else {
                                                    input.classList.remove("is-invalid-grade");
                                                    if (input.value !== "") {
                                                        input.classList.add("is-valid-grade");
                                                    } else {
                                                        input.classList.remove("is-valid-grade");
                                                    }
                                                    return true;
                                                }
                                            }

                                            function applyRemarksColor(row, remarks) {
                                                const remarksEl = row.querySelector(".remarks");
                                                const transmutedEl = row.querySelector(".transmuted-grade");
                                                remarksEl.style.color = "";
                                                transmutedEl.style.color = "";
                                                remarksEl.style.fontWeight = "";
                                                transmutedEl.style.fontWeight = "";

                                                if (remarks === "INC") {
                                                    remarksEl.style.color = "#ffab00";
                                                    transmutedEl.style.color = "#ffab00";
                                                } else if (remarks === "Failure") {
                                                    remarksEl.style.color = "#ff3e1d";
                                                    transmutedEl.style.color = "#ff3e1d";
                                                } else if (["Excellent", "Very Good"].includes(remarks)) {
                                                    remarksEl.style.color = "#71dd37";
                                                    transmutedEl.style.color = "#71dd37";
                                                } else if (remarks === "Good") {
                                                    remarksEl.style.color = "#03c9ec";
                                                    transmutedEl.style.color = "#03c9ec";
                                                } else if (remarks && remarks.trim() !== "") {
                                                    remarksEl.style.color = "#ffab00";
                                                    transmutedEl.style.color = "#ffab00";
                                                }
                                                remarksEl.style.fontWeight = "700";
                                                transmutedEl.style.fontWeight = "700";
                                            }

                                            function calculateRow(row) {
                                                let isComplete = true;
                                                let finalGrade = 0;

                                                // Attendance
                                                if (CONFIG.attendance.active) {
                                                    const el = row.querySelector(".attendance");
                                                    validateInput(el);
                                                    if (el.value.trim() === "") isComplete = false;
                                                    const val = parseFloat(el.value) || 0;
                                                    finalGrade += (val / CONFIG.attendance.max) * CONFIG.attendance.pct;
                                                }
                                                
                                                // Exam Prelim
                                                if (CONFIG.examP.active) {
                                                    const el = row.querySelector(".exam-p");
                                                    validateInput(el);
                                                    if (el.value.trim() === "") isComplete = false;
                                                    const val = parseFloat(el.value) || 0;
                                                    finalGrade += (val / CONFIG.examP.max) * CONFIG.examP.pct;
                                                }

                                                // Exam Midterm
                                                if (CONFIG.examM.active) {
                                                    const el = row.querySelector(".exam-m");
                                                    validateInput(el);
                                                    if (el.value.trim() === "") isComplete = false;
                                                    const val = parseFloat(el.value) || 0;
                                                    finalGrade += (val / CONFIG.examM.max) * CONFIG.examM.pct;
                                                }

                                                // Exam Final
                                                if (CONFIG.examF.active) {
                                                    const el = row.querySelector(".exam-f");
                                                    validateInput(el);
                                                    if (el.value.trim() === "") isComplete = false;
                                                    const val = parseFloat(el.value) || 0;
                                                    finalGrade += (val / CONFIG.examF.max) * CONFIG.examF.pct;
                                                }

                                                // Final Requirement
                                                if (CONFIG.finalReq.active) {
                                                    const el = row.querySelector(".final-req");
                                                    validateInput(el);
                                                    if (el.value.trim() === "") isComplete = false;
                                                    const val = parseFloat(el.value) || 0;
                                                    finalGrade += (val / CONFIG.finalReq.max) * CONFIG.finalReq.pct;
                                                }

                                                // Performance
                                                if (CONFIG.performance.active) {
                                                    const el = row.querySelector(".performance");
                                                    validateInput(el);
                                                    if (el.value.trim() === "") isComplete = false;
                                                    const val = parseFloat(el.value) || 0;
                                                    finalGrade += (val / CONFIG.performance.max) * CONFIG.performance.pct;
                                                }

                                                // Written
                                                if (CONFIG.written.active) {
                                                    const el = row.querySelector(".written");
                                                    validateInput(el);
                                                    if (el.value.trim() === "") isComplete = false;
                                                    const val = parseFloat(el.value) || 0;
                                                    finalGrade += (val / CONFIG.written.max) * CONFIG.written.pct;
                                                }

                                                row.querySelector(".final-grade").value = finalGrade.toFixed(2);

                                                if (!isComplete) {
                                                    row.querySelector(".transmuted-grade").value = "INC";
                                                    row.querySelector(".gs-grade").value = "INC";
                                                    row.querySelector(".remarks").value = "INC";
                                                    applyRemarksColor(row, "INC");
                                                } else {
                                                    const result = transmuteGrade(finalGrade);
                                                    row.querySelector(".transmuted-grade").value = result.grade;
                                                    row.querySelector(".gs-grade").value = result.grade;
                                                    row.querySelector(".remarks").value = result.remarks;
                                                    applyRemarksColor(row, result.remarks);
                                                }
                                            }

                                            const subjectSubtype = "<?= $subject_subtype; ?>";

                                            function transmuteGrade(fg) {
                                                if (subjectSubtype === "MAJOR") {
                                                    if (fg >= 100) return { grade: "1.0", remarks: "Excellent" };
                                                    if (fg >= 98) return { grade: "1.1", remarks: "Excellent" };
                                                    if (fg >= 96) return { grade: "1.2", remarks: "Excellent" };
                                                    if (fg >= 94) return { grade: "1.3", remarks: "Excellent" };
                                                    if (fg >= 92) return { grade: "1.4", remarks: "Excellent" };
                                                    if (fg >= 90) return { grade: "1.5", remarks: "Excellent" };
                                                    if (fg >= 88) return { grade: "1.6", remarks: "Very Good" };
                                                    if (fg >= 86) return { grade: "1.7", remarks: "Very Good" };
                                                    if (fg >= 84) return { grade: "1.8", remarks: "Very Good" };
                                                    if (fg >= 82) return { grade: "1.9", remarks: "Very Good" };
                                                    if (fg >= 80) return { grade: "2.0", remarks: "Very Good" };
                                                    if (fg >= 78) return { grade: "2.1", remarks: "Good" };
                                                    if (fg >= 76) return { grade: "2.2", remarks: "Satisfactory" };
                                                    if (fg >= 74) return { grade: "2.3", remarks: "Satisfactory" };
                                                    if (fg >= 72) return { grade: "2.4", remarks: "Satisfactory" };
                                                    if (fg >= 70) return { grade: "2.5", remarks: "Satisfactory" };
                                                    if (fg >= 68) return { grade: "2.6", remarks: "Satisfactory" };
                                                    if (fg >= 66) return { grade: "2.7", remarks: "Satisfactory" };
                                                    if (fg >= 64) return { grade: "2.8", remarks: "Passing" };
                                                    if (fg >= 62) return { grade: "2.9", remarks: "Passing" };
                                                    if (fg >= 60) return { grade: "3.0", remarks: "Passing" };
                                                    return { grade: "5.0", remarks: "Failure" };
                                                } else {
                                                    if (fg >= 99) return { grade: "1.0", remarks: "Excellent" };
                                                    if (fg >= 97) return { grade: "1.1", remarks: "Excellent" };
                                                    if (fg >= 95) return { grade: "1.2", remarks: "Excellent" };
                                                    if (fg >= 93) return { grade: "1.3", remarks: "Excellent" };
                                                    if (fg >= 91) return { grade: "1.4", remarks: "Excellent" };
                                                    if (fg >= 89) return { grade: "1.5", remarks: "Excellent" };
                                                    if (fg >= 87) return { grade: "1.6", remarks: "Very Good" };
                                                    if (fg >= 85) return { grade: "1.7", remarks: "Very Good" };
                                                    if (fg >= 83) return { grade: "1.8", remarks: "Very Good" };
                                                    if (fg >= 80) return { grade: "1.9", remarks: "Very Good" };
                                                    if (fg >= 78) return { grade: "2.0", remarks: "Very Good" };
                                                    if (fg >= 76) return { grade: "2.1", remarks: "Good" };
                                                    if (fg >= 74) return { grade: "2.2", remarks: "Satisfactory" };
                                                    if (fg >= 72) return { grade: "2.3", remarks: "Satisfactory" };
                                                    if (fg >= 70) return { grade: "2.4", remarks: "Satisfactory" };
                                                    if (fg >= 67) return { grade: "2.5", remarks: "Satisfactory" };
                                                    if (fg >= 64) return { grade: "2.6", remarks: "Satisfactory" };
                                                    if (fg >= 61) return { grade: "2.7", remarks: "Satisfactory" };
                                                    if (fg >= 57) return { grade: "2.8", remarks: "Passing" };
                                                    if (fg >= 54) return { grade: "2.9", remarks: "Passing" };
                                                    if (fg >= 50) return { grade: "3.0", remarks: "Passing" };
                                                    return { grade: "5.0", remarks: "Failure" };
                                                }
                                            }

                                            document.addEventListener("input", function(e) {
                                                if (!e.target.classList.contains("grade")) return;
                                                calculateRow(e.target.closest("tr"));
                                            });

                                            window.addEventListener('DOMContentLoaded', () => {
                                                document.querySelectorAll('#tbl_body tr').forEach(row => {
                                                    if (row.querySelectorAll('.grade').length > 0) {
                                                        calculateRow(row);
                                                    }
                                                });
                                            });
                                        </script>

                                        <!-- ========== ACTION BUTTONS ========== -->
                                        <div class="d-flex flex-wrap justify-content-between align-items-center mt-4 gap-3">
                                            <a href="<?= base_url('ims/gradingsystem') ?>" class="btn btn-outline-secondary shadow-sm">
                                                <i class="ri-arrow-left-line me-1"></i> Back to List
                                            </a>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-outline-warning shadow-sm btnDraft">
                                                    <i class="ri-save-2-line me-1"></i> Save as Draft
                                                </button>
                                                <button type="button" class="btn btn-primary shadow-sm btnSave">
                                                    <i class="ri-check-double-line me-1"></i> Finalize &amp; Submit
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                <?php endif; ?>
                        <?php
                            }
                        }
                        ?>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($config)): ?>
<!-- Adjust Structure Modal -->
<div class="modal fade" id="adjustStructureModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: #343a55;">
                <h5 class="modal-title text-white"><i class="ri-settings-4-line me-2"></i>Adjust Grading System Weights</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning" role="alert">
                    <i class="ri-alert-line me-2"></i><strong>Warning:</strong> Adjusting weights or max scores will cause all student final grades to be recalculated. Disabling an active component will clear saved grades for that component.
                </div>
                <form id="adjustConfigForm" method="post">
                    <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="GC_SCHEDID" value="<?= $sched_id; ?>">
                    
                    <div class="table-responsive">
                        <table class="table align-middle table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th style="width: 80px;">Active</th>
                                    <th>Grading Component</th>
                                    <th style="width: 180px;">Weight (%)</th>
                                    <th style="width: 180px;">Max Raw Score</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Attendance -->
                                <tr>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input comp-active" type="checkbox" name="GC_ATTENDANCE_ACTIVE" id="adj_attendance" value="1" <?= $config->GC_ATTENDANCE_ACTIVE ? 'checked' : ''; ?>>
                                        </div>
                                    </td>
                                    <td><label class="fw-semibold" for="adj_attendance">Attendance</label></td>
                                    <td><input type="number" class="form-control comp-weight" name="GC_ATTENDANCE_PCT" value="<?= $config->GC_ATTENDANCE_PCT; ?>" min="0" max="100" step="0.5"></td>
                                    <td><input type="number" class="form-control comp-max" name="GC_ATTENDANCE_MAX" value="<?= $config->GC_ATTENDANCE_MAX; ?>" min="1"></td>
                                </tr>
                                <!-- Prelim Exam -->
                                <tr>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input comp-active" type="checkbox" name="GC_EXAMPRELIM_ACTIVE" id="adj_prelim" value="1" <?= $config->GC_EXAMPRELIM_ACTIVE ? 'checked' : ''; ?>>
                                        </div>
                                    </td>
                                    <td><label class="fw-semibold" for="adj_prelim">Prelim Exam</label></td>
                                    <td><input type="number" class="form-control comp-weight" name="GC_EXAMPRELIM_PCT" value="<?= $config->GC_EXAMPRELIM_PCT; ?>" min="0" max="100" step="0.5"></td>
                                    <td><input type="number" class="form-control comp-max" name="GC_EXAMPRELIM_MAX" value="<?= $config->GC_EXAMPRELIM_MAX; ?>" min="1"></td>
                                </tr>
                                <!-- Midterm Exam -->
                                <tr>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input comp-active" type="checkbox" name="GC_EXAMMIDTERM_ACTIVE" id="adj_midterm" value="1" <?= $config->GC_EXAMMIDTERM_ACTIVE ? 'checked' : ''; ?>>
                                        </div>
                                    </td>
                                    <td><label class="fw-semibold" for="adj_midterm">Midterm Exam</label></td>
                                    <td><input type="number" class="form-control comp-weight" name="GC_EXAMMIDTERM_PCT" value="<?= $config->GC_EXAMMIDTERM_PCT; ?>" min="0" max="100" step="0.5"></td>
                                    <td><input type="number" class="form-control comp-max" name="GC_EXAMMIDTERM_MAX" value="<?= $config->GC_EXAMMIDTERM_MAX; ?>" min="1"></td>
                                </tr>
                                <!-- Final Exam -->
                                <tr>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input comp-active" type="checkbox" name="GC_EXAMFINAL_ACTIVE" id="adj_final_exam" value="1" <?= $config->GC_EXAMFINAL_ACTIVE ? 'checked' : ''; ?>>
                                        </div>
                                    </td>
                                    <td><label class="fw-semibold" for="adj_final_exam">Final Exam</label></td>
                                    <td><input type="number" class="form-control comp-weight" name="GC_EXAMFINAL_PCT" value="<?= $config->GC_EXAMFINAL_PCT; ?>" min="0" max="100" step="0.5"></td>
                                    <td><input type="number" class="form-control comp-max" name="GC_EXAMFINAL_MAX" value="<?= $config->GC_EXAMFINAL_MAX; ?>" min="1"></td>
                                </tr>
                                <!-- Final Requirement -->
                                <tr>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input comp-active" type="checkbox" name="GC_FINALREQ_ACTIVE" id="adj_final_req" value="1" <?= $config->GC_FINALREQ_ACTIVE ? 'checked' : ''; ?>>
                                        </div>
                                    </td>
                                    <td><label class="fw-semibold" for="adj_final_req">Final Requirement</label></td>
                                    <td><input type="number" class="form-control comp-weight" name="GC_FINALREQ_PCT" value="<?= $config->GC_FINALREQ_PCT; ?>" min="0" max="100" step="0.5"></td>
                                    <td><input type="number" class="form-control comp-max" name="GC_FINALREQ_MAX" value="<?= $config->GC_FINALREQ_MAX; ?>" min="1"></td>
                                </tr>
                                <!-- Performance Tasks -->
                                <tr>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input comp-active" type="checkbox" name="GC_PERFORMANCE_ACTIVE" id="adj_performance" value="1" <?= $config->GC_PERFORMANCE_ACTIVE ? 'checked' : ''; ?>>
                                        </div>
                                    </td>
                                    <td><label class="fw-semibold" for="adj_performance">Performance Tasks</label></td>
                                    <td><input type="number" class="form-control comp-weight" name="GC_PERFORMANCE_PCT" value="<?= $config->GC_PERFORMANCE_PCT; ?>" min="0" max="100" step="0.5"></td>
                                    <td><input type="number" class="form-control comp-max" name="GC_PERFORMANCE_MAX" value="<?= $config->GC_PERFORMANCE_MAX; ?>" min="1"></td>
                                </tr>
                                <!-- Written Tasks -->
                                <tr>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input comp-active" type="checkbox" name="GC_WRITTEN_ACTIVE" id="adj_written" value="1" <?= $config->GC_WRITTEN_ACTIVE ? 'checked' : ''; ?>>
                                        </div>
                                    </td>
                                    <td><label class="fw-semibold" for="adj_written">Written Tasks</label></td>
                                    <td><input type="number" class="form-control comp-weight" name="GC_WRITTEN_PCT" value="<?= $config->GC_WRITTEN_PCT; ?>" min="0" max="100" step="0.5"></td>
                                    <td><input type="number" class="form-control comp-max" name="GC_WRITTEN_MAX" value="<?= $config->GC_WRITTEN_MAX; ?>" min="1"></td>
                                </tr>
                            </tbody>
                            <tfoot class="table-light">
                                <tr>
                                    <td colspan="2" class="text-end fw-bold">Total Percentage:</td>
                                    <td class="fw-bold"><span id="adj_total_pct">100</span>%</td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    
                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="btnSaveAdjustConfig">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- Transmutation Reference Modal -->
<div class="modal fade" id="transmutationTableModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background: #343a55;">
                <h5 class="modal-title text-white"><i class="ri-file-list-3-line me-2"></i>Grade Transmutation Reference Table</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <!-- GE / Minor Courses Column -->
                    <div class="col-md-6 border-end">
                        <div class="p-3 text-center bg-light fw-bold border-bottom d-flex align-items-center justify-content-center gap-2">
                            <span class="fs-6 text-primary"><i class="ri-book-read-line me-1"></i>GE / Minor &amp; Mandated Courses (50% Passing)</span>
                            <?php if ($subject_subtype !== 'MAJOR'): ?>
                                <span class="badge bg-primary rounded-pill"><i class="ri-checkbox-circle-line me-1"></i>Active</span>
                            <?php endif; ?>
                        </div>
                        <div class="table-responsive" style="max-height: 450px;">
                            <table class="table table-bordered table-striped text-center mb-0 table-sm align-middle">
                                <thead class="table-warning sticky-top" style="z-index: 10;">
                                    <tr>
                                        <th>Final Grade (%)</th>
                                        <th>Transmuted Grade</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>99 – 100</td>
                                        <td><strong>1.0</strong></td>
                                        <td class="text-success fw-bold">Excellent</td>
                                    </tr>
                                    <tr>
                                        <td>97 – 98</td>
                                        <td><strong>1.1</strong></td>
                                        <td class="text-success fw-bold">Excellent</td>
                                    </tr>
                                    <tr>
                                        <td>95 – 96</td>
                                        <td><strong>1.2</strong></td>
                                        <td class="text-success fw-bold">Excellent</td>
                                    </tr>
                                    <tr>
                                        <td>93 – 94</td>
                                        <td><strong>1.3</strong></td>
                                        <td class="text-success fw-bold">Excellent</td>
                                    </tr>
                                    <tr>
                                        <td>91 – 92</td>
                                        <td><strong>1.4</strong></td>
                                        <td class="text-success fw-bold">Excellent</td>
                                    </tr>
                                    <tr>
                                        <td>89 – 90</td>
                                        <td><strong>1.5</strong></td>
                                        <td class="text-success fw-bold">Excellent</td>
                                    </tr>
                                    <tr>
                                        <td>87 – 88</td>
                                        <td><strong>1.6</strong></td>
                                        <td class="text-success">Very Good</td>
                                    </tr>
                                    <tr>
                                        <td>85 – 86</td>
                                        <td><strong>1.7</strong></td>
                                        <td class="text-success">Very Good</td>
                                    </tr>
                                    <tr>
                                        <td>83 – 84</td>
                                        <td><strong>1.8</strong></td>
                                        <td class="text-success">Very Good</td>
                                    </tr>
                                    <tr>
                                        <td>80 – 82</td>
                                        <td><strong>1.9</strong></td>
                                        <td class="text-success">Very Good</td>
                                    </tr>
                                    <tr>
                                        <td>78 – 79</td>
                                        <td><strong>2.0</strong></td>
                                        <td class="text-success">Very Good</td>
                                    </tr>
                                    <tr>
                                        <td>76 – 77</td>
                                        <td><strong>2.1</strong></td>
                                        <td class="text-info">Good</td>
                                    </tr>
                                    <tr>
                                        <td>74 – 75</td>
                                        <td><strong>2.2</strong></td>
                                        <td class="text-warning">Satisfactory</td>
                                    </tr>
                                    <tr>
                                        <td>72 – 73</td>
                                        <td><strong>2.3</strong></td>
                                        <td class="text-warning">Satisfactory</td>
                                    </tr>
                                    <tr>
                                        <td>70 – 71</td>
                                        <td><strong>2.4</strong></td>
                                        <td class="text-warning">Satisfactory</td>
                                    </tr>
                                    <tr>
                                        <td>67 – 69</td>
                                        <td><strong>2.5</strong></td>
                                        <td class="text-warning">Satisfactory</td>
                                    </tr>
                                    <tr>
                                        <td>64 – 66</td>
                                        <td><strong>2.6</strong></td>
                                        <td class="text-warning">Satisfactory</td>
                                    </tr>
                                    <tr>
                                        <td>61 – 63</td>
                                        <td><strong>2.7</strong></td>
                                        <td class="text-warning">Satisfactory</td>
                                    </tr>
                                    <tr>
                                        <td>57 – 60</td>
                                        <td><strong>2.8</strong></td>
                                        <td class="text-warning">Passing</td>
                                    </tr>
                                    <tr>
                                        <td>54 – 56</td>
                                        <td><strong>2.9</strong></td>
                                        <td class="text-warning">Passing</td>
                                    </tr>
                                    <tr>
                                        <td>50 – 53</td>
                                        <td><strong>3.0</strong></td>
                                        <td class="text-warning">Passing</td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td><strong>Below 50</strong></td>
                                        <td><strong>5.0</strong></td>
                                        <td class="text-danger fw-bold">Failure</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Major Courses Column -->
                    <div class="col-md-6">
                        <div class="p-3 text-center bg-light fw-bold border-bottom d-flex align-items-center justify-content-center gap-2">
                            <span class="fs-6 text-info"><i class="ri-honor-line me-1"></i>Major Courses &amp; Elective Majors (60% Passing)</span>
                            <?php if ($subject_subtype === 'MAJOR'): ?>
                                <span class="badge bg-info rounded-pill"><i class="ri-checkbox-circle-line me-1"></i>Active</span>
                            <?php endif; ?>
                        </div>
                        <div class="table-responsive" style="max-height: 450px;">
                            <table class="table table-bordered table-striped text-center mb-0 table-sm align-middle">
                                <thead class="table-warning sticky-top" style="z-index: 10;">
                                    <tr>
                                        <th>Final Grade (%)</th>
                                        <th>Transmuted Grade</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>100</td>
                                        <td><strong>1.0</strong></td>
                                        <td class="text-success fw-bold">Excellent</td>
                                    </tr>
                                    <tr>
                                        <td>98 – 99</td>
                                        <td><strong>1.1</strong></td>
                                        <td class="text-success fw-bold">Excellent</td>
                                    </tr>
                                    <tr>
                                        <td>96 – 97</td>
                                        <td><strong>1.2</strong></td>
                                        <td class="text-success fw-bold">Excellent</td>
                                    </tr>
                                    <tr>
                                        <td>94 – 95</td>
                                        <td><strong>1.3</strong></td>
                                        <td class="text-success fw-bold">Excellent</td>
                                    </tr>
                                    <tr>
                                        <td>92 – 93</td>
                                        <td><strong>1.4</strong></td>
                                        <td class="text-success fw-bold">Excellent</td>
                                    </tr>
                                    <tr>
                                        <td>90 – 91</td>
                                        <td><strong>1.5</strong></td>
                                        <td class="text-success fw-bold">Excellent</td>
                                    </tr>
                                    <tr>
                                        <td>88 – 89</td>
                                        <td><strong>1.6</strong></td>
                                        <td class="text-success">Very Good</td>
                                    </tr>
                                    <tr>
                                        <td>86 – 87</td>
                                        <td><strong>1.7</strong></td>
                                        <td class="text-success">Very Good</td>
                                    </tr>
                                    <tr>
                                        <td>84 – 85</td>
                                        <td><strong>1.8</strong></td>
                                        <td class="text-success">Very Good</td>
                                    </tr>
                                    <tr>
                                        <td>82 – 83</td>
                                        <td><strong>1.9</strong></td>
                                        <td class="text-success">Very Good</td>
                                    </tr>
                                    <tr>
                                        <td>80 – 81</td>
                                        <td><strong>2.0</strong></td>
                                        <td class="text-success">Very Good</td>
                                    </tr>
                                    <tr>
                                        <td>78 – 79</td>
                                        <td><strong>2.1</strong></td>
                                        <td class="text-info">Good</td>
                                    </tr>
                                    <tr>
                                        <td>76 – 77</td>
                                        <td><strong>2.2</strong></td>
                                        <td class="text-warning">Satisfactory</td>
                                    </tr>
                                    <tr>
                                        <td>74 – 75</td>
                                        <td><strong>2.3</strong></td>
                                        <td class="text-warning">Satisfactory</td>
                                    </tr>
                                    <tr>
                                        <td>72 – 73</td>
                                        <td><strong>2.4</strong></td>
                                        <td class="text-warning">Satisfactory</td>
                                    </tr>
                                    <tr>
                                        <td>70 – 71</td>
                                        <td><strong>2.5</strong></td>
                                        <td class="text-warning">Satisfactory</td>
                                    </tr>
                                    <tr>
                                        <td>68 – 69</td>
                                        <td><strong>2.6</strong></td>
                                        <td class="text-warning">Satisfactory</td>
                                    </tr>
                                    <tr>
                                        <td>66 – 67</td>
                                        <td><strong>2.7</strong></td>
                                        <td class="text-warning">Satisfactory</td>
                                    </tr>
                                    <tr>
                                        <td>64 – 65</td>
                                        <td><strong>2.8</strong></td>
                                        <td class="text-warning">Passing</td>
                                    </tr>
                                    <tr>
                                        <td>62 – 63</td>
                                        <td><strong>2.9</strong></td>
                                        <td class="text-warning">Passing</td>
                                    </tr>
                                    <tr>
                                        <td>60 – 61</td>
                                        <td><strong>3.0</strong></td>
                                        <td class="text-warning">Passing</td>
                                    </tr>
                                    <tr class="table-danger">
                                        <td><strong>Below 60</strong></td>
                                        <td><strong>5.0</strong></td>
                                        <td class="text-danger fw-bold">Failure</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

        function initConfigValidation(formSelector, totalSpanSelector, submitBtnSelector) {
            const $form = $(formSelector);
            if ($form.length === 0) return;

            function validate() {
                let totalPct = 0;
                let isValid = true;
                
                $form.find('tbody tr').each(function() {
                    const $tr = $(this);
                    const isActive = $tr.find('.comp-active').is(':checked');
                    const $weightInput = $tr.find('.comp-weight');
                    const $maxInput = $tr.find('.comp-max');
                    
                    if (isActive) {
                        $weightInput.prop('disabled', false);
                        $maxInput.prop('disabled', false);
                        
                        const pct = parseFloat($weightInput.val()) || 0;
                        const maxVal = parseFloat($maxInput.val()) || 0;
                        
                        totalPct += pct;
                        
                        if (pct <= 0 || maxVal <= 0) {
                            isValid = false;
                        }
                    } else {
                        $weightInput.prop('disabled', true);
                        $maxInput.prop('disabled', true);
                    }
                });
                
                $(totalSpanSelector).text(totalPct);
                
                if (totalPct === 100 && isValid) {
                    $(submitBtnSelector).prop('disabled', false);
                    $(totalSpanSelector).removeClass('text-danger').addClass('text-success');
                } else {
                    $(submitBtnSelector).prop('disabled', true);
                    $(totalSpanSelector).removeClass('text-success').addClass('text-danger');
                }
            }
            
            $form.on('change input', '.comp-active, .comp-weight, .comp-max', function() {
                validate();
            });
            
            validate(); // Initial run

            // Form submit handler
            $form.on('submit', function(e) {
                e.preventDefault();
                
                // Temporarily enable disabled fields to serialize them
                const disabledFields = $form.find('input:disabled').prop('disabled', false);
                const formData = $form.serialize();
                disabledFields.prop('disabled', true);
                
                $.ajax({
                    url: '<?= base_url("GradingSystemController/saveConfig") ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: formData,
                    success: function(response) {
                        if (response && response.token) {
                            $('.txt_csrfname').val(response.token);
                        }
                        if (response && response.result && response.result.status) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.result.message,
                                icon: 'success',
                                confirmButtonColor: '#696cff'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: (response && response.result && response.result.message) || 'Failed to save config.',
                                icon: 'error',
                                confirmButtonColor: '#696cff'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Config AJAX Error:', status, error);
                        Swal.fire({
                            title: 'Error',
                            text: 'An unexpected error occurred.',
                            icon: 'error',
                            confirmButtonColor: '#696cff'
                        });
                    }
                });
            });
        }

        initConfigValidation('#configForm', '#config_total_pct', '#btnSaveConfig');
        initConfigValidation('#adjustConfigForm', '#adj_total_pct', '#btnSaveAdjustConfig');

        $('.btnSave').click(function() {
            $("#GS_STATUS").val("SAVED");

            // Block if any grade input has exceeded its max
            let hasErrors = false;
            $("#submitForm .grade").each(function() {
                if ($(this).hasClass("is-invalid-grade")) {
                    hasErrors = true;
                    return false;
                }
            });

            if (hasErrors) {
                Swal.fire({
                    title: "Invalid Grades Detected",
                    html: "One or more grade values exceed the allowed maximum.<br>Please correct the <span style='color:#ff3e1d; font-weight:700;'>red-highlighted</span> fields before submitting.",
                    icon: "error",
                    confirmButtonColor: "#696cff"
                });
                return;
            }

            Swal.fire({
                title: "Finalize Grades?",
                text: "Once submitted, you will no longer be able to modify the grades.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#696cff",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Submit",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    submitForm();
                }
            });
        });

        $('.btnDraft').click(function(e) {
            e.preventDefault();
            $('#GS_STATUS').val('DRAFT');

            // Draft allows partial/incomplete data — skip all grade validation
            Swal.fire({
                title: 'Save as Draft?',
                text: 'Incomplete fields are allowed. You can continue editing and finalize later.',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#696cff',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, save draft',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    submitForm();
                }
            });
        });

        function getCookie(name) {
            const match = document.cookie.match(new RegExp('(?:^|; )' + name.replace(/([.$?*|{}()[\]\\/+^])/g, '\\$1') + '=([^;]*)'));
            return match ? decodeURIComponent(match[1]) : '';
        }

        function submitForm() {
            // Disable buttons to prevent double-submit
            $('.btnSave, .btnDraft').prop('disabled', true).css('opacity', '0.65');

            // Collect all form field values into a plain object
            const formArray = $('#submitForm').serializeArray();
            const postData = {};
            $.each(formArray, function(i, field) {
                // Handle array fields (e.g. GS_STUDENTID[])
                if (field.name.endsWith('[]')) {
                    const key = field.name.slice(0, -2);
                    if (!postData[key]) postData[key] = [];
                    postData[key].push(field.value);
                } else {
                    postData[field.name] = field.value;
                }
            });

            // Always read the CSRF token from the live cookie (guaranteed fresh), fallback to input if empty
            const csrfCookieName = '<?= config_item("csrf_cookie_name") ?>';
            const csrfTokenName = '<?= $this->security->get_csrf_token_name() ?>';
            const csrfValue = getCookie(csrfCookieName) || $('.txt_csrfname').val();
            postData[csrfTokenName] = csrfValue;

            $.ajax({
                url: '<?= base_url("GradingSystemController/saveUpdateForm") ?>',
                type: 'POST',
                dataType: 'json',
                data: postData,
                success: function(response) {
                    // Update CSRF token in DOM for any subsequent requests
                    if (response && response.token) {
                        $('.txt_csrfname').val(response.token);
                    }
                    if ($('#GS_STATUS').val() === 'SAVED') {
                        window.open('<?= base_url("ims/gradingsystem/print/") ?>' + $('#GS_SCHEDID').val(), '_blank');
                    }
                    window.location = '<?= base_url('ims/gradingsystem') ?>';
                },
                error: function(xhr, status, error) {
                    // Re-enable buttons on error
                    $('.btnSave, .btnDraft').prop('disabled', false).css('opacity', '');

                    console.error('AJAX Error:', status, error);
                    let msg = 'Failed to save grades. Please try again.';
                    try {
                        const res = JSON.parse(xhr.responseText);
                        msg = res.message || msg;
                        if (res.token) {
                            $('.txt_csrfname').val(res.token);
                        }
                    } catch (e) {}
                    Swal.fire({
                        title: 'Save Failed',
                        text: msg + ' (Status: ' + xhr.status + ')',
                        icon: 'error',
                        confirmButtonColor: '#696cff'
                    });
                }
            });
        }
    });
</script>