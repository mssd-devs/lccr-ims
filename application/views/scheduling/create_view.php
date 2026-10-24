<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Schedule</a>
            </li>
            <li class="breadcrumb-item active">Data Entry</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="card">
            <form action="<?= base_url("SchedulingController/SaveSchedules") ?>" method="post">
                <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="card-title mb-0">Create Schedule</h5>
                            <p class="mb-0">Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required.</p>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="SC_MERGE" value="YES" id="defaultCheck3" />
                            <label class="form-check-label" for="defaultCheck3">Allow merge schedule.</label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" name="SC_PROG" id="SC_PROG" aria-label="Default select example" required>
                                    <option value="">--Select Programs--</option>
                                    <?php
                                    foreach ($LoadPrograms->result() as $r) {
                                    ?>
                                        <option><?= $r->P_PDESCRIPTIONS ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="basic-default-fullname">Programs<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" name="SC_MAJOR" id="SC_MAJOR" aria-label="Default select example" readonly>
                                    <option value=""></option>
                                </select>
                                <label for="basic-default-fullname">Major<span class="text-danger">*</span></label>
                                <script>
                                    $(document).ready(function() {
                                        $("#SC_PROG").change(function() {
                                            var maj = $(this).val();
                                            loadmajor(maj);
                                        });

                                        function loadmajor(major) {
                                            $.ajax({
                                                url: '<?= base_url("SchedulingController/LoadMajor"); ?>',
                                                type: 'POST',
                                                dataType: 'json',
                                                data: {
                                                    maj: major,
                                                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                                                },
                                                success: function(response) {
                                                    // if success
                                                    $('.txt_csrfname').val(response.token);
                                                    $("#SC_MAJOR").html(response.result);
                                                },
                                                error: function(xhr, status, error) {
                                                    alert('Failed to save form. Please try again later.');
                                                }
                                            });
                                        }
                                    });
                                </script>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" name="SC_ACADEMICYEAR" id="SC_ACADEMICYEAR" aria-label="Default select example" required>
                                    <option value="">Select Academic Year</option>
                                    <?php for ($start_year = date('Y'); $start_year >= 2018; $start_year--) : ?>
                                        <option value="<?php echo $start_year; ?>"><?php echo $start_year . '-' . ($start_year + 1); ?></option>
                                    <?php endfor; ?>
                                </select>
                                <label for="basic-default-fullname">Academic Year<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" name="SC_SEMESTER" id="SC_SEMESTER" aria-label="Default select example" required>
                                    <option value="">--Select Semester--</option>
                                </select>
                                <script>
                                    $(document).ready(function() {
                                        $("#SC_PROG, #SC_MAJOR").change(function() {
                                            var prog = $("#SC_PROG").val();
                                            var maj = $("#SC_MAJOR").val();
                                            loadsemester(prog, maj);
                                        });

                                        function loadsemester(program, major) {
                                            $.ajax({
                                                url: '<?= base_url("SchedulingController/LoadSemester"); ?>',
                                                type: 'POST',
                                                dataType: 'json',
                                                data: {
                                                    prog: program,
                                                    maj: major,
                                                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                                                },
                                                success: function(response) {
                                                    // if success
                                                    $('.txt_csrfname').val(response.token);
                                                    $("#SC_SEMESTER").html(response.result);
                                                },
                                                error: function(xhr, status, error) {
                                                    alert('Failed to save form. Please try again later.');
                                                }
                                            });
                                        }
                                    });
                                </script>
                                <label for="basic-default-fullname">Semester<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="SC_YEARLEVEL" name="SC_YEARLEVEL" aria-label="Default select example" required>
                                    <option value="">--Select Year Level--</option>
                                    <option>1ST YEAR</option>
                                    <option>2ND YEAR</option>
                                    <option>3RD YEAR</option>
                                    <option>4TH YEAR</option>
                                    <option>5TH YEAR</option>
                                </select>
                                <label for="basic-default-fullname">Year Level<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class=" form-floating form-floating-outline mb-4">
                                <select class="form-select select2" name="SC_SDESC" id="SC_SDESC" aria-label="Default select example" required>
                                    <option value="">--Select Subject--</option>
                                    <script>
                                        $(document).ready(function() {
                                            // Trigger the change event when any of the dropdowns change
                                            $("#SC_PROG, #SC_MAJOR, #SC_YEARLEVEL, #SC_SEMESTER").change(function() {
                                                var prog = $("#SC_PROG").val();
                                                var maj = $("#SC_MAJOR").val();
                                                var yr = $("#SC_YEARLEVEL").val();
                                                var sem = $("#SC_SEMESTER").val();

                                                loadsubject(prog, maj, yr, sem);
                                            });

                                            // Function to make the AJAX request and load subjects
                                            function loadsubject(program, major, yearlvl, semester) {
                                                $.ajax({
                                                    url: '<?= base_url("SchedulingController/LoadSubject"); ?>', // URL to your controller function
                                                    type: 'POST',
                                                    dataType: 'json', // Expect JSON response
                                                    data: {
                                                        prog: program,
                                                        maj: major,
                                                        yr: yearlvl,
                                                        sem: semester,
                                                        [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val() // CSRF token
                                                    },
                                                    success: function(response) {
                                                        // Update the CSRF token value
                                                        $('.txt_csrfname').val(response.token);

                                                        // Populate the subject dropdown with the returned options
                                                        $("#SC_SDESC").html(response.result);
                                                    },
                                                    error: function(xhr, status, error) {
                                                        alert('Failed to load subjects. Please try again later.');
                                                    }
                                                });
                                            }
                                        });
                                    </script>

                                </select>
                                <label for="basic-default-fullname">Descriptive Title<span class="text-danger">*</span></label>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" name="SC_DEPT" id="SC_DEPT" aria-label="Default select example" required>
                                    <option value="">--Select Department--</option>
                                    <?php
                                    foreach ($LoadDepartment->result() as $r) {
                                    ?>
                                        <option><?= $r->D_DEPTDESCRIPTION; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="basic-default-fullname">Department<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" name="SC_SECTION" id="SC_SECTION" aria-label="Default select example" required>
                                    <option value="">--Select Section--</option>
                                </select>

                                <label for="SC_SECTION">Section <span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                $("#SC_PROG, #SC_MAJOR, #SC_YEARLEVEL, #SC_SEMESTER").change(function() {
                                    var yl = $("#SC_YEARLEVEL").val();
                                    var prog = $("#SC_PROG").val();
                                    var maj = $("#SC_MAJOR").val();
                                    var sem = $("#SC_SEMESTER").val();
                                    loadSection(yl, prog, maj, sem);
                                });

                                function loadSection(yearlevel, program, major, semester) {
                                    $.ajax({
                                        url: '<?= base_url("SchedulingController/LoadSection"); ?>',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            sec: yearlevel,
                                            prog: program,
                                            maj: major,
                                            sem: semester,
                                            [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                                        },
                                        success: function(response) {
                                            $('.txt_csrfname').val(response.token);
                                            $("#SC_SECTION").html(response.result);
                                        },
                                        error: function() {
                                            alert('Failed to load sections. Please try again.');
                                        }
                                    });
                                }
                            });
                        </script>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" name="SC_ROOM" id="SC_ROOM" aria-label="Default select example" required>
                                    <option value=''>--Select Room--</option>
                                </select>
                                <label for="basic-default-fullname">Room<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                $("#SC_DEPT").change(function() {
                                    var rm = $(this).val();
                                    loadroom(rm);
                                });

                                function loadroom(room) {
                                    $.ajax({
                                        url: '<?= base_url("SchedulingController/LoadRoom"); ?>',
                                        type: 'POST',
                                        dataType: 'json',
                                        data: {
                                            rm: room,
                                            [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                                        },
                                        success: function(response) {
                                            // if success
                                            $('.txt_csrfname').val(response.token);
                                            $("#SC_ROOM").html(response.result);
                                        },
                                        error: function(xhr, status, error) {
                                            alert('Failed to save form. Please try again later.');
                                        }
                                    });

                                }
                            });
                        </script>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" name="SC_DAY" id="" aria-label="Default select example" required>
                                    <option value="">--Select Day--</option>
                                    <option>MWF</option>
                                    <option>TTH</option>
                                    <option>M</option>
                                    <option>T</option>
                                    <option>W</option>
                                    <option>TH</option>
                                    <option>F</option>
                                    <option>SAT</option>
                                    <option>SUN</option>
                                </select>
                                <label for="basic-default-fullname">Day<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="time" class="form-control" name="SC_STARTTIME" id="basic-default-fullname" required />
                                <label for="basic-default-fullname">Start Time<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="time" class="form-control" name="SC_ENDTIME" id="basic-default-fullname" required />
                                <label for="basic-default-fullname">End Time<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" name="SC_TEACHMODELS" id="" aria-label="Default select example" required>
                                    <option value="">--Select Teaching Models--</option>
                                    <option>FACE TO FACE</option>
                                    <option>ONLINE</option>
                                    <option>HYBRID</option>
                                </select>
                                <label for="basic-default-fullname">Teaching Models<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" name="SC_FACULTY" id="exampleFormControlSelect1" aria-label="Default select example" required>
                                    <option value="">--Select Faculty--</option>
                                    <?php
                                    foreach ($LoadFaculty->result() as $r) {
                                    ?>
                                        <option><?= $r->FP_LASTNAME . ', ' . $r->FP_FIRSTNAME . ' ' . $r->FP_MIDDLENAME; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="basic-default-fullname">Faculty<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-lg">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- / Content -->

<!-- FOR UPPERCASE -->
<script>
    $(document).on('input', '[type="text"], textarea', function() {
        var inputText = $(this).val();
        var uppercaseText = inputText.toUpperCase();
        var textWithoutDoubleSpaces = uppercaseText.replace(/  +/g, ' ');
        $(this).val(textWithoutDoubleSpaces);
    });
</script>