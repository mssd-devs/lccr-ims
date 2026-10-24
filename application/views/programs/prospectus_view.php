<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Breadcrumbs and Action Buttons -->
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <nav aria-label="breadcrumb" class="mb-0">
            <ol class="breadcrumb breadcrumb-style1 mb-0">
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Data Entry</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="<?= base_url("ims/entries/programs"); ?>">Programs</a>
                </li>
                <li class="breadcrumb-item active">Prospectus</li>
            </ol>
        </nav>
        <div class="d-flex gap-2">
            <a href="<?= base_url("ims/entries/programs"); ?>" class="btn btn-outline-secondary">
                <i class="ri-arrow-left-line me-1"></i> Back to Programs
            </a>
            <button onclick="window.print();" class="btn btn-primary">
                <i class="ri-printer-line me-1"></i> Print Prospectus
            </button>
        </div>
    </div>

    <!-- Print Header (only visible on print) -->
    <?php
    $web = $this->db->get("tbl_websettings")->row();
    $inst_name = ($web && !empty($web->IMS_WEB_NAME)) ? $web->IMS_WEB_NAME : "INSTITUTION MANAGEMENT SYSTEM";
    $inst_logo = ($web && !empty($web->IMS_WEB_LOGO)) ? base_url('assets/img/' . $web->IMS_WEB_LOGO) : '';
    ?>
    <div class="print-header d-none d-print-block text-center mb-4">
        <?php if ($inst_logo): ?>
            <img src="<?= $inst_logo ?>" alt="Logo" class="mb-2" style="max-height: 80px;">
        <?php endif; ?>
        <h3 class="mb-0 fw-bold"><?= $inst_name ?></h3>
        <h5 class="text-muted">PROGRAM PROSPECTUS / CURRICULUM</h5>
        <hr class="my-2">
    </div>

    <!-- Program Info Card -->
    <?php
    $overall_total_units = 0;
    foreach ($grouped_subjects as $yr => $sems) {
        foreach ($sems as $sem => $subs) {
            foreach ($subs as $sub) {
                $overall_total_units += floatval($sub->S_UNITS);
            }
        }
    }
    ?>
    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                <div>
                    <span class="badge bg-label-primary mb-2"><?= $program->P_PROGTYPE; ?> PROGRAM</span>
                    <h3 class="card-title mb-1 fw-bold text-primary"><?= $program->P_PDESCRIPTIONS; ?></h3>
                    <?php if (!empty($program->P_MAJOR)): ?>
                        <h5 class="text-muted mb-2">Major in <strong><?= $program->P_MAJOR; ?></strong></h5>
                    <?php endif; ?>
                    <p class="mb-0 text-secondary">
                        <i class="ri-code-line me-1"></i> Program Code: <strong class="text-dark"><?= $program->P_PCODE; ?></strong>
                        <span class="mx-2">|</span>
                        <i class="ri-calendar-line me-1"></i> Semester Type: <strong class="text-dark"><?= $program->P_SEMTYPE; ?></strong>
                    </p>
                </div>
                <div class="text-md-end d-flex flex-column align-items-md-end gap-2">
                    <div>
                        <?php if ($program->P_PROGSTATUS == "ACTIVE"): ?>
                            <span class="badge bg-success rounded-pill px-3 py-1">ACTIVE STATUS</span>
                        <?php else: ?>
                            <span class="badge bg-danger rounded-pill px-3 py-1">INACTIVE STATUS</span>
                        <?php endif; ?>
                    </div>
                    <div class="mt-2">
                        <div class="p-2 px-3 bg-label-info rounded text-center">
                            <span class="d-block small text-muted">Total Curriculum Units</span>
                            <span class="h4 mb-0 fw-bold text-info"><?= $overall_total_units; ?> Units</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr class="my-4">
            
            <div class="row g-3">
                <div class="col-sm-6 col-md-3">
                    <span class="text-muted d-block small">Authority Category</span>
                    <strong class="text-dark"><?= $program->P_CATEGORY ?: 'N/A'; ?></strong>
                </div>
                <div class="col-sm-6 col-md-3">
                    <span class="text-muted d-block small">Serial Number</span>
                    <strong class="text-dark"><?= $program->P_SERIALCODE ?: 'N/A'; ?></strong>
                </div>
                <div class="col-sm-6 col-md-3">
                    <span class="text-muted d-block small">Series Year</span>
                    <strong class="text-dark"><?= $program->P_YEARISSUED ?: 'N/A'; ?></strong>
                </div>
                <div class="col-sm-6 col-md-3">
                    <span class="text-muted d-block small">Total Subjects Listed</span>
                    <strong class="text-dark"><?= count($grouped_subjects, COUNT_RECURSIVE) - count($grouped_subjects) - count($grouped_subjects, 1) + count($grouped_subjects); /* Dynamic count helper or calculated */ 
                    $sub_count = 0;
                    foreach ($grouped_subjects as $yr => $sems) {
                        foreach ($sems as $sem => $subs) {
                            $sub_count += count($subs);
                        }
                    }
                    echo $sub_count;
                    ?> Subjects</strong>
                </div>
            </div>
        </div>
    </div>

    <!-- Subjects grouped by Year Level and Semester -->
    <?php if (empty($grouped_subjects)): ?>
        <div class="alert alert-warning border-0 shadow-sm" role="alert">
            <h5 class="alert-heading mb-1 fw-bold"><i class="ri-alert-line me-1"></i> No Subjects Found</h5>
            <p class="mb-0">There are no subjects currently mapped to this program and major. Go to the <a href="<?= base_url("ims/entries/subject"); ?>" class="alert-link fw-semibold">Subjects Data Entry</a> page to associate subjects with this program.</p>
        </div>
    <?php else: ?>
        <div class="row gy-4">
            <?php foreach ($grouped_subjects as $year_level => $semesters): ?>
                <div class="col-12 year-section">
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-header bg-light py-3 d-flex justify-content-between align-items-center">
                            <h4 class="mb-0 fw-bold text-dark"><i class="ri-graduation-cap-line text-primary me-2"></i><?= $year_level; ?></h4>
                            <span class="badge bg-primary rounded-pill"><?= count($semesters); ?> Semesters</span>
                        </div>
                        <div class="card-body pt-3">
                            <div class="row gy-4">
                                <?php foreach ($semesters as $semester_name => $subs): ?>
                                    <div class="col-12 semester-section">
                                        <div class="p-3 border rounded bg-white shadow-xs">
                                            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                                                <h5 class="mb-0 fw-semibold text-primary">
                                                    <i class="ri-book-open-line me-2"></i><?= $semester_name; ?>
                                                </h5>
                                                <?php 
                                                $sem_units = 0;
                                                foreach ($subs as $s) {
                                                    $sem_units += floatval($s->S_UNITS);
                                                }
                                                ?>
                                                <span class="badge bg-label-info text-info fw-bold py-2 px-3">
                                                    Semester Units: <?= $sem_units; ?>
                                                </span>
                                            </div>
                                            
                                            <div class="table-responsive">
                                                <table class="table table-hover table-striped table-bordered align-middle">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th style="width: 15%;">Course No.</th>
                                                            <th style="width: 45%;">Descriptive Title</th>
                                                            <th style="width: 10%;" class="text-center">Units</th>
                                                            <th style="width: 18%;">Pre-Requisite</th>
                                                            <th style="width: 12%;" class="text-center">Type</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($subs as $sub): ?>
                                                            <tr>
                                                                <td class="fw-semibold text-dark"><?= $sub->S_SCODE; ?></td>
                                                                <td><?= $sub->S_SDESCRIPTION; ?></td>
                                                                <td class="text-center fw-semibold"><?= $sub->S_UNITS; ?></td>
                                                                <td><?= !empty($sub->S_PREREQ) ? $sub->S_PREREQ : '<span class="text-muted small">None</span>'; ?></td>
                                                                <td class="text-center">
                                                                    <?php if (strtoupper($sub->S_SUBTYPE) == 'MAJOR'): ?>
                                                                        <span class="badge bg-label-primary px-2.5 py-1">MAJOR</span>
                                                                    <?php else: ?>
                                                                        <span class="badge bg-label-secondary px-2.5 py-1">MINOR</span>
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        <?php endforeach; ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<style>
    .shadow-xs {
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05) !important;
    }
    
    @media print {
        #layout-menu,
        .layout-navbar,
        .content-footer,
        .btn,
        nav[aria-label="breadcrumb"],
        .d-print-none {
            display: none !important;
        }
        
        body {
            background-color: #fff !important;
            color: #000 !important;
        }

        .layout-wrapper,
        .layout-container,
        .layout-page,
        .content-wrapper,
        .container-xxl {
            padding: 0 !important;
            margin: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            background: transparent !important;
            box-shadow: none !important;
        }

        .card {
            border: none !important;
            box-shadow: none !important;
            background: transparent !important;
            margin-bottom: 25px !important;
        }

        .card-body {
            padding: 0 !important;
        }

        .year-section {
            page-break-inside: avoid;
            margin-bottom: 30px;
        }

        .semester-section {
            page-break-inside: avoid;
            margin-bottom: 20px;
        }

        .table-responsive {
            overflow: visible !important;
        }

        .table {
            width: 100% !important;
            border-collapse: collapse !important;
            font-size: 12px !important;
        }

        .table th, .table td {
            border: 1px solid #aaa !important;
            padding: 6px 10px !important;
            background-color: #fff !important;
            color: #000 !important;
        }

        .table-light {
            background-color: #f1f1f1 !important;
        }

        .badge {
            border: 1px solid #555 !important;
            background: transparent !important;
            color: #000 !important;
            font-weight: bold !important;
            padding: 2px 6px !important;
        }
        
        .bg-label-info, .bg-label-primary, .bg-label-secondary {
            background-color: transparent !important;
            color: #000 !important;
            border: 1px solid #777 !important;
        }
    }
</style>
