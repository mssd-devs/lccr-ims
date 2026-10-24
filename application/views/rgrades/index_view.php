<style>
    :root {
        --emerald-primary: #1a1a1a;
        --emerald-secondary: #444444;
        --emerald-accent: #e2e8f0;
        --emerald-light: #f8f9fa;
        --gold-primary: #d97706;
        --glass-bg: #ffffff;
        --premium-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        --emerald-gradient: linear-gradient(135deg, #ffffff 0%, #f1f5f9 100%);
    }

    .btn-emerald {
        background: var(--emerald-primary);
        color: white;
        border: none;
    }

    .btn-emerald:hover {
        background: var(--emerald-secondary);
        color: white;
    }

    .bg-emerald-light {
        background-color: var(--emerald-light) !important;
    }

    .text-emerald {
        color: var(--emerald-primary) !important;
    }

    @media print {
        .no-print {
            display: none !important;
        }
    }
</style>

<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Grades</a>
            </li>
            <li class="breadcrumb-item active">List of Student Semester Records</li>
        </ol>
    </nav>
    <div class="row gy-4 mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Filter by:</h5>
                        <button type="button" class="btn btn-warning btn-sm" id="btn_reset_filter"><i class="ri-filter-line me-1"></i> Reset</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_PROGRAM" name="FILTER_PROGRAM" aria-label="Default select example">
                                    <option value="">ALL</option>
                                    <?php
                                    $query = $this->db->query("SELECT DISTINCT(P_PDESCRIPTIONS) FROM tbl_program");
                                    foreach ($query->result() as $r) {
                                    ?>
                                        <option><?= htmlspecialchars($r->P_PDESCRIPTIONS); ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="FILTER_PROGRAM">Program</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_MAJOR" aria-label="Default select example">
                                    <option value="">--SELECT--</option>
                                </select>
                                <label for="FILTER_MAJOR">Major</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_YL" aria-label="Default select example">
                                    <option value="">ALL</option>
                                    <option value="1ST YEAR">1ST YEAR</option>
                                    <option value="2ND YEAR">2ND YEAR</option>
                                    <option value="3RD YEAR">3RD YEAR</option>
                                    <option value="4TH YEAR">4TH YEAR</option>
                                    <option value="5TH YEAR">5TH YEAR</option>
                                </select>
                                <label for="FILTER_YL">Year Level</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_AY" aria-label="Default select example">
                                    <option value="">ALL</option>
                                    <?php for ($start_year = date('Y'); $start_year >= 2000; $start_year--) : ?>
                                        <option value="<?php echo $start_year; ?>"><?php echo $start_year . '-' . ($start_year + 1); ?></option>
                                    <?php endfor; ?>
                                </select>
                                <label for="FILTER_AY">Academic Year</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_SEM" aria-label="Default select example">
                                    <option value="">ALL</option>
                                    <?php
                                    $query = $this->db->get("tbl_semestertype");
                                    foreach ($query->result() as $r) {
                                    ?>
                                        <option><?= htmlspecialchars($r->SEM_NAME); ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="FILTER_SEM">Semester</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Student Grades per Semester</h4>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered align-middle" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Student ID</th>
                                    <th>Name of Student</th>
                                    <th>Program & Major</th>
                                    <th>Academic Year</th>
                                    <th>Semester</th>
                                    <th>Term GWA</th>
                                    <th>Status</th>
                                    <th class="text-end">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="tbl_body">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Container where semester modals (View, Edit, Certificates, Reports) are loaded dynamically -->
<div id="modals_container"></div>

<script>
    function printDiv(divId) {
        var printContents = document.getElementById(divId).innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }

    $(document).ready(function() {
        LoadStudentGrades();

        $("#btn_reset_filter").on("click", function() {
            window.location.reload();
        });

        $("#FILTER_PROGRAM").on("change", function() {
            if ($(this).val() !== "") {
                LoadProgramMajor($(this).val());
            }
        });

        function LoadProgramMajor(FILTER_PROGRAM) {
            $.ajax({
                url: "<?= base_url("EnrollmentController/LoadProgramMajor"); ?>",
                method: "POST",
                dataType: 'json',
                data: {
                    ER_PROGRAM: FILTER_PROGRAM,
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                },
                success: function(result) {
                    $('.txt_csrfname').val(result.token);
                    $('#FILTER_MAJOR').html(result.output);
                }
            });
        }

        const filterSelectors = "#FILTER_PROGRAM, #FILTER_MAJOR, #FILTER_YL, #FILTER_AY, #FILTER_SEM";
        $(filterSelectors).on("change", function() {
            LoadStudentGrades();
        });

        $(document).on("click", ".btn-class-rgrades", function() {
            const studentid = $(this).data("studentid");
            window.open("<?= base_url('ims/grade/rgrades/torprint/') ?>" + studentid, '_blank');
        });

        function LoadStudentGrades() {
            $.ajax({
                url: "<?= base_url("RgradesController/LoadStudentGrades"); ?>",
                method: "POST",
                dataType: 'json',
                data: {
                    FILTER_PROGRAM: $("#FILTER_PROGRAM").val(),
                    FILTER_MAJOR: $("#FILTER_MAJOR").val(),
                    FILTER_YL: $("#FILTER_YL").val(),
                    FILTER_AY: $("#FILTER_AY").val(),
                    FILTER_SEM: $("#FILTER_SEM").val(),
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                },
                success: function(result) {
                    $('.txt_csrfname').val(result.token);
                    if ($.fn.DataTable.isDataTable('#dataTable')) {
                        $('#dataTable').DataTable().clear().destroy();
                    }
                    $("#tbl_body").html(result.output || '');
                    $("#modals_container").html(result.modals || '');
                    initializeDataTable();
                },
                error: function(jqXHR, errorType, error) {
                    console.error(error);
                }
            });
        }

        function initializeDataTable() {
            $('#dataTable').DataTable({
                dom: '<"d-flex justify-content-between align-items-center mb-3"<"export-dropdown"B><"search-box"f>>rtip',
                buttons: [{
                    extend: 'collection',
                    text: '<i class="ri-download-2-line me-1"></i> Export Data',
                    buttons: [
                        { extend: 'copy', text: 'Copy to Clipboard' },
                        { extend: 'csv', text: 'Export as CSV' },
                        { extend: 'excel', text: 'Export as Excel' },
                        { extend: 'pdf', text: 'Export as PDF' },
                        { extend: 'print', text: 'Print Table' }
                    ]
                }],
                responsive: true,
                autoWidth: false,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50, 75, 100],
                language: {
                    search: "Search:",
                    lengthMenu: "Display _MENU_ records per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });
        }

        // --- EDIT MODAL GRADE & RE-EXAM DYNAMIC EVENT HANDLERS ---
        function isNumericGrade(val) {
            return /^\d+(\.\d+)?$/.test(val);
        }

        $(document).on('change', '.grade-select', function() {
            const idx = $(this).data('idx');
            const $modal = $(this).closest('.modal');
            const gradeVal = $(this).val() || '';
            const $reexamSelect = $modal.find(`.reexam-select[data-idx="${idx}"]`);
            const $remarkInput = $modal.find(`.remark-input[data-idx="${idx}"]`);

            if (gradeVal === 'INC') {
                $reexamSelect.prop('disabled', false);
                const reexamVal = $reexamSelect.val() || '';
                if (reexamVal && isNumericGrade(reexamVal)) {
                    $remarkInput.val(parseFloat(reexamVal) <= 3.0 ? 'PASSED' : 'FAILED');
                } else {
                    $remarkInput.val('INCOMPLETE');
                }
            } else {
                $reexamSelect.prop('disabled', true).val('');
                if (gradeVal === 'DRP') {
                    $remarkInput.val('DROPPED');
                } else if (gradeVal === '5.00' || gradeVal === '5.0') {
                    $remarkInput.val('FAILED');
                } else if (isNumericGrade(gradeVal)) {
                    $remarkInput.val(parseFloat(gradeVal) <= 3.0 ? 'PASSED' : 'FAILED');
                } else {
                    $remarkInput.val('');
                }
            }
        });

        $(document).on('change', '.reexam-select', function() {
            const idx = $(this).data('idx');
            const $modal = $(this).closest('.modal');
            const reexamVal = $(this).val() || '';
            const $remarkInput = $modal.find(`.remark-input[data-idx="${idx}"]`);

            if (reexamVal && isNumericGrade(reexamVal)) {
                $remarkInput.val(parseFloat(reexamVal) <= 3.0 ? 'PASSED' : 'FAILED');
            } else {
                $remarkInput.val('INCOMPLETE');
            }
        });
    });
</script>