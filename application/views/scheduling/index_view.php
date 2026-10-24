<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Scheduling</a>
            </li>
            <li class="breadcrumb-item active">List of Schedules</li>
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
                        <div class="col-md-3">
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
                        <div class="col-md-3">
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
                        <div class="col-md-3">
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
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_ROOM" aria-label="Default select example">
                                    <option value="">-- Select --</option>
                                    <?php
                                    $query = $this->db->get("tbl_rooms");
                                    foreach ($query->result() as $r) {
                                    ?>
                                        <option><?= $r->R_RMDESCRIPTION; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="basic-default-fullname">Room</label>
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
                    <?php
                    $permission = [];
                    // Normal user permissions from RBAC
                    if ($rbac->num_rows() > 0) {
                        foreach ($rbac->result() as $rbac_row) {
                            $actions = array_map('trim', explode(',', $rbac_row->ACTIONS));
                            $permission = array_merge($permission, $actions);
                        }
                    }
                    // Check if 'Create' exists in the permission list, or if user is admin
                    if (in_array("Create", $permission) || $this->session->userdata("usertype") == "Superadmin") {
                    ?>

                        <a class="btn btn-primary btn-md float-end d-inline-flex align-items-center"
                            href="<?= base_url('ims/scheduling/create'); ?>" id="button-addon2">
                            <i class="ri-add-circle-line me-1"></i> Add Schedules
                        </a>
                    <?php
                    }
                    ?>
                    <button type="button" class="btn btn-info btn-md float-end d-inline-flex align-items-center me-2" id="btn_print_room">
                        <i class="ri-printer-line me-1"></i> Print Room Schedule
                    </button>
                    <h4>List of Schedules</h4>
                    <div class="table-responsive pt-0">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Sched Code</th>
                                    <th>Descriptive Title</th>
                                    <th>Program</th>
                                    <th>Academic Year</th>
                                    <th>Semester</th>
                                    <th>Day</th>
                                    <th>Time</th>
                                    <th>Room</th>
                                    <th>Faculty</th>
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

<!-- / Content -->

<!-- Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="<?= base_url("SchedulingController/DeleteSchedules"); ?>" method="POST">
            <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
            <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>"
                value="<?= $this->security->get_csrf_hash(); ?>">
            <input type="hidden" name="ID" id="ID">
            <input type="hidden" name="SC_CLASSCODE" id="SC_CLASSCODE">
            <div class="modal-header">
                <h4 class="modal-title" id="backDropModalTitle">Are you sure?</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                You won't be able to revert this!

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on("click", ".delete-btn", function() {
            var id = $(this).data("id");
            $("#deleteModal #ID").val(id);
            var sc_classcode = $(this).data("sc_classcode");
            $("#deleteModal #SC_CLASSCODE").val(sc_classcode);
        });
    });
</script>


<script>
    $(document).ready(function() {
        LoadSchedules();
        const filterSelectors = "#FILTER_PROGRAM, #FILTER_MAJOR, #FILTER_YL, #FILTER_AY, #FILTER_SEM, #FILTER_ROOM";
        $(filterSelectors).on("change", function() {
            // showLoadingForm();
            LoadSchedules();

        });

        function LoadSchedules() {
            $.ajax({
                url: "<?= base_url("SchedulingController/LoadSchedules"); ?>",
                method: "POST",
                dataType: 'json',
                data: {
                    FILTER_PROGRAM: $("#FILTER_PROGRAM").val(),
                    FILTER_MAJOR: $("#FILTER_MAJOR").val(),
                    FILTER_YL: $("#FILTER_YL").val(),
                    FILTER_AY: $("#FILTER_AY").val(),
                    FILTER_SEM: $("#FILTER_SEM").val(),
                    FILTER_ROOM: $("#FILTER_ROOM").val(),
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                },
                success: function(result) {
                    // Update CSRF hash
                    $('.txt_csrfname').val(result.token);
                    // Destroy datatable
                    $("#dataTable").DataTable().clear().destroy();
                    // Load data into table body
                    $("#tbl_body").html(result.output);
                    // Reload DataTable
                    initializeDataTable();
                    //   Swal.fire("Success!", "Data successfully loaded.", "success");
                },
                error: function(jqXHR, errorType, error) {
                    alert(error);
                }
            });
        }

        function initializeDataTable() {
            $('#dataTable').DataTable({
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
                fixedColumns: {
                    left: 1, // Freezes first column
                    right: 1 // Freezes last column
                },
                order: [
                    [0, 'desc']
                ],
                autoWidth: true,
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

        $(document).on("click", "#btn_print_room", function() {
            var room = $("#FILTER_ROOM").val();
            var ay = $("#FILTER_AY").val();
            var sem = $("#FILTER_SEM").val();

            if (!room) {
                Swal.fire({
                    title: 'Warning!',
                    text: 'Please select a room first.',
                    icon: 'warning',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false,
                    confirmButtonText: 'OK'
                });
                return;
            }

            var url = "<?= base_url('ims/scheduling/print_room_schedule'); ?>?room=" + encodeURIComponent(room) + "&ay=" + encodeURIComponent(ay) + "&sem=" + encodeURIComponent(sem);
            window.open(url, "_blank");
        });
    });
</script>