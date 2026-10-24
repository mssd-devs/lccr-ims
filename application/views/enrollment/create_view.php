<style>
    /* Sticky column styles */
    .sticky-col {
        position: sticky;
        right: 0;
        z-index: 2;
        background: #ffffff;
        /* Light theme default */
    }

    /* Ensure sticky td stays behind th for proper layering */
    tbody .sticky-col {
        z-index: 2;
    }

    /* Dark theme override */
    [data-bs-theme="dark"] .sticky-col {
        background: #1e1e1e;
        color: #fff;
    }
</style>


<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Enrollment</a>
            </li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <br>
                    <p>Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required and
                        type Not Applicable (if not applicable)</p>
                    <form id="submitEnrollmentForm" method="post">
                        <input type="hidden" name="ID" value="">
                        <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4 mb-4">
                                    <label for="">Student ID Number</label><span class="text-danger">*</span>
                                    <input type="text" class="form-control" name="ER_STUDENTID" readonly required
                                        id="ER_STUDENTID" placeholder="Student ID" aria-describedby="button-addon2" />
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="">Full Name</label> <span class="text-danger">*</span>
                                    <div class="input-group">
                                        <input type="text" class="form-control ER_FULLNAME"
                                            placeholder="Name of Student" required name="ER_FULLNAME" id="ER_FULLNAME"
                                            readonly />
                                        <button class="btn btn-outline-primary btn-search-student" type="button"><i
                                                class="ri-search-line"></i> Search Student</button>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <label for="">Curriculum Type</label>
                                    <input type="text" class="form-control" id="SP_CURRICULUM" name="SP_CURRICULUM" readonly placeholder="Curriculum Type" />
                                </div>

                                <!-- Modal for Student Search -->
                                <div class="modal fade" id="modalStudentSearch" data-bs-backdrop="static" tabindex="-1"
                                    aria-labelledby="modalStudentSearchLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalStudentSearchLabel">Search Student</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered" id="dataTable">
                                                        <thead>
                                                            <tr>
                                                                <th class="d-none">ID</th>
                                                                <th>ID Number</th>
                                                                <th>Full Name</th>
                                                                <th>Sex</th>
                                                                <th>Payment Status</th>
                                                                <th>Promotional Status</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $sql = "SELECT s.*, 
                                                                    (SELECT ER_PAYMENTSTATUS 
                                                                     FROM tbl_enrollment e 
                                                                     WHERE e.ER_STUDENTID = s.SP_STUDID 
                                                                     ORDER BY e.ID DESC 
                                                                     LIMIT 1) as LATEST_PAYMENT_STATUS,
                                                                    (SELECT ER_PROMOTIONALSTATUS 
                                                                     FROM tbl_enrollment e 
                                                                     WHERE e.ER_STUDENTID = s.SP_STUDID 
                                                                     ORDER BY e.ID DESC 
                                                                     LIMIT 1) as LATEST_PROMOTIONAL_STATUS
                                                                    FROM tbl_studprof s 
                                                                    ORDER BY s.ID DESC";
                                                            $query = $this->db->query($sql);
                                                            foreach ($query->result() as $r) {
                                                                $payment_status = $r->LATEST_PAYMENT_STATUS ?? 'NO RECORD';
                                                                $promotional_status = $r->LATEST_PROMOTIONAL_STATUS ?? 'NO RECORD';

                                                                $badge_class = 'bg-secondary';
                                                                if ($payment_status == 'PAID') $badge_class = 'bg-success';
                                                                elseif ($payment_status == 'INSTALLMENT') $badge_class = 'bg-warning';
                                                                elseif ($payment_status == 'UNPAID') $badge_class = 'bg-danger';

                                                                $promo_badge_class = 'bg-secondary';
                                                                if ($promotional_status == 'PROMOTED') $promo_badge_class = 'bg-success';
                                                                elseif ($promotional_status == 'CONDITIONAL PROMOTION') $promo_badge_class = 'bg-info';
                                                                elseif ($promotional_status == 'UNPROMOTED') $promo_badge_class = 'bg-danger';
                                                            ?>
                                                                <tr>
                                                                    <td class="d-none"><?= $r->ID; ?></td>
                                                                    <td><?= $r->SP_STUDID ?></td>
                                                                    <td><?= $r->SP_LASTNAME . ', ' . $r->SP_FIRSTNAME . ' ' . $r->SP_MIDDLENAME ?>
                                                                    </td>
                                                                    <td><?= $r->SP_GENDER ?></td>
                                                                    <td><span
                                                                            class="badge rounded-pill <?= $badge_class ?>"><?= $payment_status ?></span>
                                                                    </td>
                                                                    <td><span
                                                                            class="badge rounded-pill <?= $promo_badge_class ?>"><?= $promotional_status ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <button type="button"
                                                                            class="btn btn-primary btn-select-student"
                                                                            <?= ($promotional_status == 'UNPROMOTED' || $promotional_status == '') ? 'disabled' : '' ?>
                                                                            data-name="<?= htmlspecialchars($r->SP_LASTNAME . ', ' . $r->SP_FIRSTNAME . ' ' . $r->SP_MIDDLENAME) ?>"
                                                                            data-payment-status="<?= $payment_status ?>"
                                                                            data-curriculum="<?= htmlspecialchars($r->SP_CURRICULUM) ?>"
                                                                            data-id="<?= $r->SP_STUDID ?>">Select</button>
                                                                    </td>
                                                                </tr>
                                                            <?php
                                                            }
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script>
                                    $(function() {
                                        // Show modal on button click
                                        $('.btn-search-student').on('click', function() {
                                            $('#modalStudentSearch').modal('show');
                                            $('#searchStudentInput').val('');
                                        });


                                        // Select student from modal
                                        $(document).on('click', '.btn-select-student', function() {
                                            let id = $(this).data('id');
                                            let name = $(this).data('name');
                                            let paymentStatus = $(this).data('payment-status');
                                            let curriculum = $(this).data('curriculum');

                                            $('#ER_STUDENTID').val(id);
                                            $('.ER_FULLNAME').val(name);
                                            $('#SP_CURRICULUM').val(curriculum);
                                            $('#modalStudentSearch').modal('hide');

                                            // Auto-fill enrollment data
                                            $.ajax({
                                                url: "<?= base_url("EnrollmentController/GetLastEnrollment"); ?>",
                                                method: "POST",
                                                dataType: 'json',
                                                data: {
                                                    studentID: id,
                                                    [$('.txt_csrfname').attr('name')]: $(
                                                        '.txt_csrfname').val()
                                                },
                                                success: function(result) {
                                                    $('.txt_csrfname').val(result.token);
                                                    if (result.output) {
                                                        const data = result.output;

                                                        // Set Program and trigger change to load Majors
                                                        if (data.ER_PROGRAM) {
                                                            $('#ER_PROGRAM').val(data
                                                                .ER_PROGRAM).trigger(
                                                                'change');

                                                            // We need to wait for majors to load before setting the major
                                                            // Since LoadProgramMajor is async, we can use a slight timeout or modify the efficient way
                                                            // For now, let's use a timeout as a simple solution since LoadProgramMajor is triggered by change
                                                            setTimeout(() => {
                                                                if (data.ER_MAJOR) {
                                                                    $('#ER_MAJOR').val(
                                                                            data
                                                                            .ER_MAJOR)
                                                                        .trigger(
                                                                            'change');
                                                                }
                                                            }, 500);
                                                        }

                                                        if (data.ER_YEARLEVEL) {
                                                            $('#ER_YEARLEVEL').val(data
                                                                .ER_YEARLEVEL).trigger(
                                                                'change');
                                                        }
                                                    }
                                                },
                                                error: function(xhr, status, error) {
                                                    console.error(
                                                        "Error fetching last enrollment:",
                                                        error);
                                                }
                                            });
                                        });
                                    });
                                </script>


                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" id="ER_PROGRAM" name="ER_PROGRAM" required
                                            aria-label="Default select example">
                                            <option value="">--Select Program--</option>
                                            <?php
                                            $query = $this->db->query("SELECT DISTINCT(P_PDESCRIPTIONS) FROM tbl_program");
                                            foreach ($query->result() as $r) {
                                            ?>
                                                <option><?= $r->P_PDESCRIPTIONS; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="basic-default-fullname">Program <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" id="ER_MAJOR" name="ER_MAJOR"
                                            aria-label="Default select example">
                                            <option value="">--Select Major--</option>
                                        </select>
                                        <label for="basic-default-fullname">Major</label>
                                    </div>
                                </div>
                                <script>
                                    $(document).ready(function() {
                                        $("#ER_PROGRAM").on("change", function() {
                                            if ($(this).val() != "") {
                                                LoadProgramMajor($(this).val());
                                                LoadSemester($(this).val());
                                            }
                                        });

                                        function LoadProgramMajor(ER_PROGRAM) {
                                            $.ajax({
                                                url: "<?= base_url("EnrollmentController/LoadProgramMajor"); ?>",
                                                method: "POST",
                                                dataType: 'json',
                                                data: {
                                                    ER_PROGRAM: ER_PROGRAM,
                                                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname')
                                                        .val()
                                                },
                                                success: function(result) {
                                                    // Update CSRF hash
                                                    $('.txt_csrfname').val(result.token);
                                                    $('#ER_MAJOR').html(result.output);
                                                },
                                                error: function(jqXHR, errorType, error) {
                                                    alert(error);
                                                }
                                            });
                                        }

                                        // load the data of semester
                                        function LoadSemester(PROGRAM) {
                                            $.ajax({
                                                url: "<?= base_url("EnrollmentController/LoadSemester"); ?>",
                                                method: "POST",
                                                dataType: 'json',
                                                data: {
                                                    PROGRAM: PROGRAM,
                                                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname')
                                                        .val()
                                                },
                                                success: function(result) {
                                                    // Update CSRF hash
                                                    $('.txt_csrfname').val(result.token);
                                                    $('#ER_SEMESTER').html(result.output);
                                                },
                                                error: function(jqXHR, errorType, error) {
                                                    alert(error);
                                                }
                                            });
                                        }
                                    });
                                </script>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" id="ER_YEARLEVEL" name="ER_YEARLEVEL"
                                            required aria-label="Default select example">
                                            <option value="">--Select Year Level--</option>
                                            <option value="1ST YEAR">1st Year</option>
                                            <option value="2ND YEAR">2nd Year</option>
                                            <option value="3RD YEAR">3rd Year</option>
                                            <option value="4TH YEAR">4th Year</option>
                                            <option value="5TH YEAR">5th Year</option>
                                        </select>
                                        <label for="basic-default-fullname">Year Level <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" id="ER_SEMESTER" name="ER_SEMESTER" required
                                            aria-label="Default select example">
                                            <option value="">-- Select --</option>

                                        </select>
                                        <label for="basic-default-fullname">Semester <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" id="ER_SECTION" name="ER_SECTION" required
                                            aria-label="Default select example">
                                            <option value="">--Select Section--</option>

                                        </select>
                                        <label for="basic-default-fullname">Section <span
                                                class="text-danger">*</span></label>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            // Attach event listener to all relevant fields
                                            $("#ER_PROGRAM, #ER_YEARLEVEL, #ER_SEMESTER").on("change", function() {
                                                // Check if all fields are filled before calling LoadSection
                                                if ($("#ER_PROGRAM").val() && $("#ER_YEARLEVEL").val() && $(
                                                        "#ER_SEMESTER").val()) {
                                                    LoadSection();
                                                }
                                            });

                                            function LoadSection() {
                                                $.ajax({
                                                    url: "<?= base_url('EnrollmentController/LoadSection'); ?>",
                                                    type: "POST",
                                                    dataType: "json",
                                                    data: {
                                                        ER_PROGRAM: $("#ER_PROGRAM").val(),
                                                        ER_YEARLEVEL: $("#ER_YEARLEVEL").val(),
                                                        ER_SEMESTER: $("#ER_SEMESTER").val(),
                                                        [$('.txt_csrfname').attr('name')]: $(
                                                            '.txt_csrfname').val() // CSRF token
                                                    },
                                                    success: function(response) {
                                                        // Update CSRF token
                                                        $('.txt_csrfname').val(response.token);

                                                        // Update the E_SECTION dropdown with the result
                                                        $('#ER_SECTION').html(response.output);
                                                    },
                                                    error: function(jqXHR, textStatus, errorThrown) {
                                                        // Provide more detailed error feedback
                                                        console.error("Error: ", textStatus,
                                                            errorThrown);
                                                        alert(
                                                            "An error occurred while loading the section. Please try again."
                                                        );
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
                                        <select class="form-select select2" id="ER_STATUS" name="ER_STATUS" required
                                            aria-label="Default select example">
                                            <option value="">--Select Status--</option>
                                            <option value="FRESHMEN">Freshmen</option>
                                            <option value="OLD">Old</option>
                                            <option value="TRANSFEREE">Transferee</option>
                                        </select>
                                        <label for="basic-default-fullname">Enrollment Type <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" id="ER_CLASSIFICATION"
                                            name="ER_CLASSIFICATION" required aria-label="Default select example">
                                            <option value="">--Select--</option>
                                            <option value="REGULAR">Regular</option>
                                            <option value="IRREGULAR">Irregular</option>
                                        </select>
                                        <label for="basic-default-fullname">Academic Load <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" id="ER_ACADEMICYEAR" name="ER_ACADEMICYEAR"
                                            required aria-label="Default select example">
                                            <?php for ($start_year = date('Y'); $start_year >= 1990; $start_year--) : ?>
                                                <option value="<?php echo $start_year; ?>">
                                                    <?php echo $start_year . '-' . ($start_year + 1); ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <label for="basic-default-fullname">Academic Year <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-primary mt-2 d-none" id="btnLoadSubjects"><i
                                            class="ri-refresh-line"></i> Load Current Subjects</button>

                                    <button type="button" class="btn btn-info mt-2 d-none btnAddSubject"
                                        data-bs-toggle="modal" data-bs-target="#modalSubjects"><i
                                            class="ri-search-line"></i> Add/Search Subject</button>

                                    <script>
                                        $(document).ready(function() {
                                            $("#ER_CLASSIFICATION").on("change", function() {
                                                if ($(this).val() === "IRREGULAR") {
                                                    $(".btnAddSubject").removeClass('d-none');
                                                } else {
                                                    $(".btnAddSubject").addClass('d-none');
                                                }
                                            });
                                        });
                                    </script>
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-12">
                                    <h5>LIST OF SUBJECT LOADS <span class="alert-icon rounded" style="cursor:pointer;"
                                            data-bs-toggle="popover" data-bs-placement="top"
                                            data-bs-content="To load the subjects, select the Program, Year Level, Semester, and Section first."
                                            title="Load Subjects">
                                            <i class="ri-information-line ri-22px"></i>
                                        </span></h5>

                                    <!-- Table for selected subjects -->
                                    <div class="table-responsive">
                                        <table id="subjectTable" class="table display" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>NO</th>
                                                    <th>Subject Code</th>
                                                    <th>Subject Description</th>
                                                    <th>Modality</th>
                                                    <th>Time</th>
                                                    <th>Days</th>
                                                    <th>Room</th>
                                                    <th>Section</th>
                                                    <th>Units</th>
                                                    <th>Faculty</th>
                                                    <th>Pre-Requisite</th>
                                                    <th class="sticky-col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbl_subjects">
                                            </tbody>
                                            <tfoot>
                                                <tr id="totalUnitsRow">
                                                    <td colspan="8" class="text-end fw-bold">Total Units</td>
                                                    <td id="totalUnits">0</td>
                                                    <td colspan="3"><input type="hidden" name="ER_UNITS" id="ER_UNITS">
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="margin-top:15px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-lg"><i
                                                class="ri ri-save-line"></i> Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalSubjects" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add/Search Subjects</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="fixedColumnDataTable" class="table display" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Subject Code</th>
                                <th>Subject Description</th>
                                <th>Modality</th>
                                <th>Time</th>
                                <th>Days</th>
                                <th>Room</th>
                                <th>Section</th>
                                <th>Units</th>
                                <th>Faculty</th>
                                <th>Pre-Requisite</th>
                                <th>Year Level</th>
                                <th>Semester</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $num = 0;
                            foreach ($LoadModalSubjects->result() as $r) {
                                $num++;
                            ?>
                                <tr>
                                    <td><?= $num; ?></td>
                                    <td><?= $r->S_SCODE; ?></td>
                                    <td><?= $r->S_SDESCRIPTION; ?></td>
                                    <td><?= $r->SC_TEACHMODELS; ?></td>
                                    <td>
                                        <?php
                                        $start = !empty($r->SC_STARTTIME) ? date("h:i A", strtotime($r->SC_STARTTIME)) : '';
                                        $end = !empty($r->SC_ENDTIME) ? date("h:i A", strtotime($r->SC_ENDTIME)) : '';
                                        echo ($start || $end) ? $start . ($start && $end ? '-' : '') . $end : '';
                                        ?>
                                    </td>
                                    <td><?= $r->SC_DAY; ?></td>
                                    <td><?= $r->SC_ROOM; ?></td>
                                    <td><?= $r->SC_SECTION; ?></td>
                                    <td><?= $r->S_UNITS; ?></td>
                                    <td><?= $r->SC_FACULTY; ?></td>
                                    <td><?= $r->S_PREREQ; ?></td>
                                    <td><?= $r->S_YRLVL; ?></td>
                                    <td><?= $r->S_SEM; ?></td>
                                    <td>
                                        <?php
                                        $start = !empty($r->SC_STARTTIME) ? date("h:i A", strtotime($r->SC_STARTTIME)) : '';
                                        $end = !empty($r->SC_ENDTIME) ? date("h:i A", strtotime($r->SC_ENDTIME)) : '';
                                        $time = ($start || $end) ? $start . ($start && $end ? '-' : '') . $end : '';
                                        ?>
                                        <button type="button" class="btn btn-xs btn-secondary add-subject"
                                            data-subject-id="<?= $r->ID ?>" data-code="<?= $r->S_SCODE ?>"
                                            data-description="<?= $r->S_SDESCRIPTION ?>" data-units="<?= $r->S_UNITS ?>"
                                            data-time="<?= $time ?>" data-modality="<?= $r->SC_TEACHMODELS ?>"
                                            data-day="<?= $r->SC_DAY ?>" data-room="<?= $r->SC_ROOM ?>"
                                            data-faculty="<?= $r->SC_FACULTY ?>" data-section="<?= $r->SC_SECTION ?>"
                                            data-year="<?= $r->S_YRLVL ?>" data-sem="<?= $r->S_SEM ?>"
                                            data-prereq="<?= $r->S_PREREQ ?>">Add Subject</button>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->








<script>
    $(function() {

        $("#submitEnrollmentForm").on("submit", function(e) {
            e.preventDefault();

            // Validate required fields before continuing
            if (!validateRequiredFields(this)) {
                Swal.fire({
                    title: "Validation Error",
                    text: "Please fill in all required fields before submitting.",
                    icon: "warning",
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
                return;
            }

            // Show confirmation dialog
            Swal.fire({
                title: "Are you sure?",
                text: "You want to save the enrollment data!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, submit it!",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    submitForm($(this));
                }
            });
        });

        function validateRequiredFields(form) {
            let isValid = true;

            $(form).find("[required]").each(function() {
                if (!$(this).val()) {
                    $(this).addClass("is-invalid"); // Add Bootstrap style (optional)
                    isValid = false;
                } else {
                    $(this).removeClass("is-invalid");
                }
            });

            return isValid;
        }

        function submitForm($form) {
            var $submitBtn = $form.find('button[type="submit"]');
            var originalBtnHtml = $submitBtn.html();

            Swal.fire({
                title: "Saving Enrollment",
                html: "Please wait while the enrollment data is being saved...",
                allowOutsideClick: false,
                allowEscapeKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
            $submitBtn.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Saving...'
            );

            $.ajax({
                url: "<?= base_url("EnrollmentController/saveUpdate"); ?>",
                type: "POST",
                dataType: "json",
                data: $form.serialize(),
                success: function(data) {

                    if (data.output.result == "save") {
                        Swal.fire({
                            title: "Success!",
                            text: "Data has been saved successfully!",
                            icon: "success",
                            customClass: {
                                confirmButton: 'btn btn-primary waves-effect waves-light'
                            },
                            buttonsStyling: false
                        }).then(() => {
                            window.location.href = "<?= base_url('ims/enrollment/view/'); ?>" +
                                data.output.id;

                        });
                    } else {
                        $submitBtn.prop('disabled', false).html(originalBtnHtml);
                        Swal.fire({
                            title: "Error!",
                            text: data.output || "An unexpected error occurred.",
                            icon: "error",
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false,
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    $submitBtn.prop('disabled', false).html(originalBtnHtml);
                    Swal.fire({
                        title: "Error!",
                        text: "An unexpected error occurred while saving. Please try again.",
                        icon: "error",
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false,
                    });
                }
            });
        }

    });
</script>









<script>
    $(document).ready(function() {
        // Trigger LoadSubjects on button click
        $("#btnLoadSubjects").on("click", function() {
            if ($("#ER_PROGRAM").val() && $("#ER_YEARLEVEL").val() && $("#ER_SEMESTER").val()) {
                LoadSubjects();
            } else {
                Swal.fire({
                    title: "Required Fields",
                    text: "Please complete the required fields.",
                    icon: "info",
                    customClass: {
                        confirmButton: 'btn btn-primary waves-effect waves-light'
                    },
                    buttonsStyling: false
                });
            }
        });

        // Show loading form while data is being retrieved
        function showLoadingForm() {
            Swal.fire({
                title: "Loading Data",
                html: "Please wait while the data is being retrieved...",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                },
            });
        }

        $("#ER_SECTION").on("change", function() {
            if ($(this).val() !== "") {
                // Check section capacity limit
                $.ajax({
                    url: "<?= base_url('EnrollmentController/CheckSectionCapacity'); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        ER_PROGRAM: $("#ER_PROGRAM").val(),
                        ER_YEARLEVEL: $("#ER_YEARLEVEL").val(),
                        ER_SEMESTER: $("#ER_SEMESTER").val(),
                        ER_SECTION: $(this).val(),
                        ER_ACADEMICYEAR: $("#ER_ACADEMICYEAR").val(),
                        [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                    },
                    success: function(response) {
                        $('.txt_csrfname').val(response.token);
                        if (response.output && response.output.status === "full") {
                            Swal.fire({
                                title: "Section Limit Reached!",
                                text: "The selected section (" + $("#ER_SECTION").val() + ") has reached its maximum capacity of " + response.output.capacity + " students.",
                                icon: "error",
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false
                            });
                            // Reset section dropdown
                            $("#ER_SECTION").val("").trigger("change");
                        } else {
                            $("#btnLoadSubjects").removeClass('d-none');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Capacity check error:", textStatus, errorThrown);
                        $("#btnLoadSubjects").removeClass('d-none');
                    }
                });
            } else {
                $("#btnLoadSubjects").addClass('d-none');
                // Update subjects table
                $('#tbl_subjects').html("");
                updateTable();
            }
        });

        // Load subjects using AJAX
        function LoadSubjects() {
            $.ajax({
                url: "<?= base_url('EnrollmentController/LoadSubjects'); ?>",
                type: "POST",
                dataType: "json",
                data: {
                    ER_PROGRAM: $("#ER_PROGRAM").val(),
                    ER_MAJOR: $("#ER_MAJOR").val(),
                    ER_YEARLEVEL: $("#ER_YEARLEVEL").val(),
                    ER_SEMESTER: $("#ER_SEMESTER").val(),
                    ER_SECTION: $("#ER_SECTION").val(),
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val() // CSRF token
                },
                success: function(response) {
                    // Update CSRF token
                    $('.txt_csrfname').val(response.token);

                    // Update subjects table
                    $('#tbl_subjects').html(response.output);
                    updateTable();

                    //      Swal.fire("Success!", "Subjects loaded successfully.", "success");
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error: ", textStatus, errorThrown);
                    Swal.fire("Error",
                        "An error occurred while loading the subjects. Please try again.", "error");
                }
            });
        }

        // Add subject to table when clicked
        $(document).on('click', '.add-subject', function() {
            var subjectID = $(this).data('subject-id');
            // Check if subject already exists based on hidden input field
            if ($("#tbl_subjects input[value='" + subjectID + "']").length > 0) {
                Swal.fire({
                    title: "Warning!",
                    text: "This subject has already been added.",
                    icon: "warning",
                    customClass: {
                        confirmButton: 'btn btn-primary waves-effect waves-light'
                    },
                    buttonsStyling: false
                });
                return;
            }

            // Extract subject details
            var subjectCode = $(this).data('code');
            var description = $(this).data('description');
            var units = parseInt($(this).data('units'));
            var year = $(this).data('year');
            var sem = $(this).data('sem');
            var prereq = $(this).data('prereq');
            var time = $(this).data('time');
            var modality = $(this).data('modality');
            var day = $(this).data('day');
            var room = $(this).data('room');
            var faculty = $(this).data('faculty');
            var section = $(this).data('section');

            // Create new row with hidden input for subject ID
            var newRow = `<tr data-subject-id="${subjectID}">
                        <td></td>
                        <td><input type="hidden" name="ER_SUBJECTS[]" id="E_SID" value="${subjectID}">${subjectCode}</td>
                        <td>${description}</td>
                        <td>${modality}</td>
                        <td>${time}</td>
                        <td>${day}</td>
                        <td>${room}</td>
                        <td>${section}</td>
                        <td>${units}</td>
                        <td>${faculty}</td>
                        <td>${prereq}</td>
                        <td class="sticky-col"><button type="button" class="btn btn-danger deleteSubject"><i class="ri-delete-bin-line"></i></button></td>
                    </tr>`;

            // Append the new row
            $('#tbl_subjects').append(newRow);
            Swal.fire({
                title: "Success!",
                text: "This subject has been added.",
                icon: "success",
                customClass: {
                    confirmButton: 'btn btn-primary waves-effect waves-light'
                },
                buttonsStyling: false
            });
            // Update numbering and total units
            updateTable();
        });

        // Update table numbering and total units
        function updateTable() {
            var totalUnits = 0;
            var num = 1;

            $('#tbl_subjects tr').each(function() {
                $(this).find('td:first-child').text(num); // Update numbering
                var rowUnits = parseInt($(this).find('td:nth-child(9)').text());
                totalUnits += isNaN(rowUnits) ? 0 : rowUnits;
                num++;
            });

            $('#totalUnits').text(totalUnits); // Update total units in footer
            $('#ER_UNITS').val(totalUnits); // Update total units in footer
        }

        // Bind delete functionality for dynamically added rows with confirmation
        $(document).on('click', '.deleteSubject', function() {
            var row = $(this).closest('tr');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                customClass: {
                    confirmButton: 'btn btn-primary me-3 waves-effect waves-light',
                    cancelButton: 'btn btn-outline-secondary waves-effect'
                },
                buttonsStyling: false,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    row.remove();
                    updateTable(); // Update table after row removal
                }
            });
        });
    });
</script>