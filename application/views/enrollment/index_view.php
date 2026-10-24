<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Enrollment</a>
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
                        <div class="col-md-6">
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
                        <div class="col-md-6">
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
                                <label for="basic-default-fullname">Year Level</label>
                            </div>
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
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_SEM" aria-label="Default select example">
                                    <option value="">-- Select --</option>
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
                        <h5>List of Enrolled Students</h5>
                        <?php
                        $permission = [];
                        $usertype = $this->session->userdata("usertype");

                        if ($rbac->num_rows() > 0 || $usertype == "Superadmin" || $usertype == "Registrar") {
                            foreach ($rbac->result() as $rows) {
                                $actions = explode(',', $rows->ACTIONS);
                                $permission = array_merge($permission, array_map('trim', $actions));
                            }

                            // Check if 'Create' exists in the permission list, or if user is admin or registrar
                            if (in_array("Create", $permission) || $usertype == "Superadmin" || $usertype == "Registrar") {
                        ?>
                                <a class="btn btn-primary btn-xl float-end d-inline-flex align-items-center"
                                    href="<?= base_url('ims/enrollment/create'); ?>" id="button-addon2">
                                    <i class="ri-add-circle-line me-1"></i> Add Enrollment
                                </a>
                        <?php
                            }
                        }
                        ?>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="fixedColumnDataTable">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>Student I.D</th>
                                    <th>Name</th>
                                    <th>Contact No.</th>
                                    <th>Sex</th>
                                    <th>Program(Major)</th>
                                    <th>Year Level</th>
                                    <th>Semester</th>
                                    <th>Status</th>
                                    <th>Payment Status</th>
                                    <th>Admission Status</th>
                                    <th>Action</th>
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
        LoadEnrollment();
        const filterSelectors = "#FILTER_PROGRAM, #FILTER_MAJOR, #FILTER_YL, #FILTER_AY, #FILTER_SEM";
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
        $(document).on("click", ".btnPrintCert", function() {
            const id = $(this).data("id");
            const trno = $(this).data("trno");
            window.open("<?= base_url('ims/enrollment/printcert/') ?>" + id + '/' + trno, '_blank');
        });

        $(document).on("click", ".btnPrintCOR", function() {
            const id = $(this).data("id");
            const trno = $(this).data("trno");
            window.open("<?= base_url('ims/enrollment/printcor/') ?>" + id + '/' + trno, '_blank');
        });

        $(document).on("click", ".btnPrintHD", function() {
            const id = $(this).data("id");
            const trno = $(this).data("trno");
            window.open("<?= base_url('ims/enrollment/printhd/') ?>" + id + '/' + trno, '_blank');
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


        function deleteEnrollment(id) {
            $.post("<?= base_url('EnrollmentController/DeleteEnrollment'); ?>", {
                id: id,
                [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
            }, function(result) {
                $('.txt_csrfname').val(result.token);
                if (result.output == "success") {
                    Swal.fire({
                        title: "Success!",
                        text: "Data has been deleted.",
                        icon: "success",
                        customClass: {
                            confirmButton: 'btn btn-primary waves-effect waves-light'
                        },
                        buttonsStyling: false
                    });
                    LoadEnrollment();
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: "Error deleting the data..",
                        icon: "error",
                        customClass: {
                            confirmButton: 'btn btn-primary waves-effect waves-light'
                        },
                        buttonsStyling: false
                    });
                }
            }, "json").fail(function() {
                Swal.fire("Error!", "An error occurred while deleting.", "error");
            });
        }

        // Show loading form while data is being retrieved
        // function showLoadingForm() {
        //     Swal.fire({
        //         title: "Loading Data",
        //         html: "Please wait while the data is being retrieved...",
        //         allowOutsideClick: false,
        //         didOpen: () => {
        //             Swal.showLoading();
        //         },
        //     });
        // }

        function LoadEnrollment() {

            $.ajax({
                url: "<?= base_url("EnrollmentController/LoadEnrollment"); ?>",
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
                order: [],
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
    });
</script>