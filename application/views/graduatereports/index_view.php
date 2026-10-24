<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Graduating</a>
            </li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </nav>
    <div class="row gy-4 mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Filter by:</h5>
                        <button type="button" class="btn btn-warning btn-sm" id="btn_reset_filter"><i
                                class="ri-filter-line"></i> Reset</button>
                        <script>
                            $(document).on("click", "#btn_reset_filter", function() {
                                window.location.reload();
                            });
                        </script>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <input type="hidden" class="txt_csrfname"
                                name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_PROGRAM" name="FILTER_PROGRAM"
                                    aria-label="Default select example">
                                    <option value="">ALL</option>
                                    <?php
                                    $query = $this->db->query("SELECT DISTINCT(P_PDESCRIPTIONS) FROM tbl_program");
                                    foreach ($query->result() as $r) {
                                    ?>
                                        <option><?= $r->P_PDESCRIPTIONS; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="basic-default-fullname">Program</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_MAJOR"
                                    aria-label="Default select example">
                                    <option value="">--SELECT--</option>
                                </select>
                                <label for="basic-default-fullname">Major</label>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    $("#FILTER_PROGRAM").on("change", function() {
                                        if ($(this).val() != "") {
                                            LoadProgramMajor($(this).val());
                                        }
                                    });

                                    function LoadProgramMajor(FILTER_MAJOR) {
                                        $.ajax({
                                            url: "<?= base_url("EnrollmentController/LoadProgramMajor"); ?>",
                                            method: "POST",
                                            dataType: 'json',
                                            data: {
                                                ER_PROGRAM: FILTER_MAJOR,
                                                [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                                            },
                                            success: function(result) {
                                                // Update CSRF hash
                                                $('.txt_csrfname').val(result.token);
                                                $('#FILTER_MAJOR').html(result.output);
                                            },
                                            error: function(jqXHR, errorType, error) {
                                                alert(error);
                                            }
                                        });
                                    }
                                });
                            </script>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_AY" aria-label="Default select example">
                                    <?php for ($start_year = date('Y'); $start_year >= 2000; $start_year--) : ?>
                                        <option value="<?php echo $start_year; ?>">
                                            <?php echo $start_year . '-' . ($start_year + 1); ?></option>
                                    <?php endfor; ?>
                                </select>
                                <label for="basic-default-fullname">Academic Year</label>
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
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5>List of Graduating Students</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="dataTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <!-- <th>No.</th> -->
                                    <th>Student I.D</th>
                                    <th>Name</th>
                                    <th>Contact No.</th>
                                    <th>Sex</th>
                                    <th>Program(Major)</th>
                                    <th>Year Level</th>
                                    <th>Semester</th>
                                    <th>Status</th>
                                    <th>Remarks</th>
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

<script>
    $(document).ready(function() {
        // Open modal and populate data
        $(document).on('click', '.btn-validation', function() {
            $('#yearLevel').text($(this).data('yearlevel'));
            $('#academicTerm').text($(this).data('academicterm'));

            let ay = $(this).data('academicyear');
            $('#academicYear').text(ay && !isNaN(ay) ? ay + '-' + (parseInt(ay) + 1) : (ay || ''));

            $('#studentNumber').text($(this).data('studentnumber'));
            $('#studentType').text($(this).data('studenttype'));
            $('#studentStatus').text($(this).data('status'));
            $('#fullName').text($(this).data('fullname'));
            $('#sex').text($(this).data('sex'));
            $('#programMajor').text($(this).data('programmajor'));
            $('#contactNumber').text($(this).data('contactnumber'));

            // Hidden input
            $('#G_STUDENTID').val($(this).data('studentnumber'));

            // Fill saved graduate validation
            $('#validationStatus').val($(this).data('gstatus') || '');
            $('#remarks').val($(this).data('remarks') || '');

            // Reset then re-check requirements
            $('input[name="validation[]"]').prop('checked', false);
            let reqs = $(this).data('requirements');
            if (reqs) {
                reqs.split(',').forEach(function(val) {
                    $('input[name="validation[]"][value="' + val.trim() + '"]').prop('checked', true);
                });
            }

            // Store row for badge & remarks update
            $('#validateModal').data('row', $(this).closest('tr'));

            $('#validateModal').modal('show');
        });

        // Save validation
        $('#btnSaveValidation').on('click', function() {
            let studentId = $('#G_STUDENTID').val();
            let requirements = [];
            $('input[name="validation[]"]:checked').each(function() {
                requirements.push($(this).val());
            });

            let remarks = $('#remarks').val();
            let status = $('#validationStatus').val();

            let csrfName = $('.txt_csrfname').attr('name');
            let csrfHash = $('.txt_csrfname').val();

            if (!studentId || requirements.length === 0 || !status) {
                Swal.fire("Error", "Please fill all required fields and check at least one requirement.", "error");
                return;
            }

            let postData = {
                G_STUDENTID: studentId,
                G_REQUIREMENTS: requirements.join(','),
                G_STATUS: status,
                G_REMARKS: remarks
            };
            postData[csrfName] = csrfHash;

            $.ajax({
                url: "<?= base_url('GraduatesController/saveGraduateValidation'); ?>",
                type: "POST",
                dataType: "json",
                data: postData,
                success: function(result) {
                    if (result && result.token) {
                        $('.txt_csrfname').val(result.token);
                    }

                    if (result.output === "success") {
                        Swal.fire("Success", result.message, "success");
                        $("#validateModal").modal("hide");

                        // Update row badge + remarks immediately
                        let row = $('#validateModal').data('row');
                        if (row && row.length) {
                            // --- Update status badge ---
                            let badge = "";
                            if (!status || status.trim() === "") {
                                badge = "<span class='badge rounded-pill bg-danger'>NOT YET VALIDATED</span>";
                            } else if (status.toUpperCase() === "VALIDATED") {
                                badge = "<span class='badge rounded-pill bg-success'>VALIDATED</span>";
                            } else if (status.toUpperCase() === "NOT VALIDATED") {
                                badge = "<span class='badge rounded-pill bg-danger'>NOT VALIDATED</span>";
                            } else {
                                badge = "<span class='badge rounded-pill bg-warning'>" + status + "</span>";
                            }
                            row.find('.status-col').html(badge);

                            // --- Update remarks column dynamically ---
                            row.find('.remarks-col').text(remarks || '');

                        }

                    } else {
                        Swal.fire("Error", result.message || "Failed to save validation.", "error");
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire("Error", "AJAX error: " + error, "error");
                    console.error("XHR:", xhr.responseText);
                }
            });
        });

        // OPTIONAL: full reload
        function reloadEnrollmentTable() {
            $.post("<?= base_url('GraduatesController/LoadEnrollment'); ?>", {}, function(html) {
                $("#enrollmentTable tbody").html(html);
            });
        }
    });
</script>






<!-- JavaScript -->
<script>
    $(document).on('click', '.btn-validation', function() {
        const id = $(this).data('id');
        $('#modalValidation').modal('show');
    });

    // Enable/disable remarks textbox based on validation status
    $(document).on('change', '#validationStatus', function() {
        if ($(this).val() === 'INC') {
            $('#remarks').prop('disabled', false);
        } else {
            $('#remarks').prop('disabled', true).val('');
        }
    });
</script>

<script>
    $(document).ready(function() {
        LoadEnrollment();
        const filterSelectors = "#FILTER_PROGRAM, #FILTER_MAJOR, #FILTER_AY";
        $(filterSelectors).on("change", function() {
            // showLoadingForm();
            LoadEnrollment();

        });

        // Print button click event
        // $(document).on("click", ".btnPrint", function() {
        //     var id = $(this).data('id');
        //     var trno = $(this).data('trno');
        //     var url = "<?= base_url('ims/enrollment/print/') ?>" + id + "/" + trno;
        //     window.open(url, '_blank');
        // });

        $(document).on("click", ".btnPrint", function() {
            const id = $(this).data("id");
            const trno = $(this).data("trno");
            window.open("<?= base_url('ims/enrollment/print/') ?>" + id + '/' + trno, '_blank');
        });
        $(document).on("click", "#btnDelete", function() {
            const id = $(this).data("id");
            Swal.fire({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this record!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteEnrollment(id);
                }
            });
        });


        function LoadEnrollment() {

            $.ajax({
                url: "<?= base_url("GraduateReportsController/LoadEnrollment"); ?>",
                method: "POST",
                dataType: 'json',
                data: {
                    FILTER_PROGRAM: $("#FILTER_PROGRAM").val(),
                    FILTER_MAJOR: $("#FILTER_MAJOR").val(),
                    FILTER_AY: $("#FILTER_AY").val(),
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                },
                success: function(result) {
                    // Update CSRF hash
                    $('.txt_csrfname').val(result.token);
                    // Destroy datatable
                    $("#fixedColumnDataTable").DataTable().clear().destroy();
                    // Load data into table body
                    $("#tbl_body").html(result.output);
                    // Reload DataTable
                    initializeDataTable();

                },
                error: function(jqXHR, errorType, error) {
                    alert(error);
                }
            });
        }

        function initializeDataTable() {
            $('#fixedColumnDataTable').DataTable({
                dom: '<"d-flex justify-content-between align-items-center"<"export-dropdown"B><"search-box"f>>rtip', // Custom layout
                buttons: [{
                    extend: 'collection',
                    text: '<i class="ri-download-2-line"></i> Export Data',
                    buttons: [{
                            extend: 'copy',
                            text: 'Copy to Clipboard'
                        },
                        {
                            extend: 'csv',
                            text: 'Export as CSV'
                        },
                        {
                            extend: 'excel',
                            text: 'Export as Excel'
                        },
                        {
                            extend: 'pdf',
                            text: 'Export as PDF'
                        },
                        {
                            extend: 'print',
                            text: 'Print Table'
                        }
                    ]
                }],
                responsive: false,
                autoWidth: true,
                fixedColumns: {
                    left: 1, // Freezes first column
                    right: 1 // Freezes last column
                },
                pageLength: 5,
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
    });
</script>