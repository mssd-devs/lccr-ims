<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Scheduling</a>
            </li>
            <li class="breadcrumb-item active">List of Schedules</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <form action="<?= base_url("SchedulingController/UpdateSchedules") ?>" method="post">
                    <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                    <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <?php
                    $query = $this->db->where("ID", $this->uri->segment(4))->get("tbl_scheduling");
                    foreach ($query->result() as $r) {
                    ?>
                        <input type="hidden" name="ID" value="<?= $r->ID; ?>">
                        <input type="hidden" name="SC_CLASSCODE" value="<?= $r->SC_CLASSCODE; ?>">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                                <div>
                                    <h5 class="card-title mb-0">Create Schedule</h5>
                                    <p class="mb-0">Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required.</p>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="SC_MERGE" value="YES" <?= $r->SC_MERGE == "YES" ? "checked" : "" ?> id="defaultCheck3" />
                                    <label class="form-check-label" for="defaultCheck3">Allow merge schedule.</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="SC_PROG" id="SC_PROG" aria-label="Default select example" required>
                                            <option value="">--Select Programs--</option>
                                            <?php
                                            foreach ($LoadPrograms->result() as $row) {
                                            ?>
                                                <option <?php if ($r->SC_PROG == $row->P_PDESCRIPTIONS) {
                                                            echo "selected";
                                                        } ?>><?= $row->P_PDESCRIPTIONS; ?></option>
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
                                            <?php
                                            $major = $this->db->where("P_PDESCRIPTIONS", $r->SC_PROG)->get("tbl_program");
                                            if ($major->num_rows() > 0) {
                                                foreach ($major->result() as $row) {
                                            ?>
                                                    <option <?php if ($row->P_MAJOR == $r->SC_MAJOR) {
                                                                echo "selected";
                                                            } ?> value="<?= $row->P_MAJOR; ?>"><?= $row->P_MAJOR; ?></option>
                                            <?php
                                                }
                                            }
                                            ?>
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
                                        <select class="form-select select2" name="SC_ACADEMICYEAR" id="SC_ACADEMICYEAR" aria-label="Default select example">
                                            <option value="">Select Academic Year</option>
                                            <?php for ($start_year = date('Y'); $start_year >= 1990; $start_year--) : ?>
                                                <option value="<?php echo $start_year; ?>" <?= ($r->SC_ACADEMICYEAR == $start_year) ? 'selected' : ''; ?>><?php echo $start_year . '-' . ($start_year + 1); ?></option>
                                            <?php endfor; ?>
                                        </select>
                                        <label for="basic-default-fullname">Academic Year<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="SC_SEMESTER" id="SC_SEMESTER" aria-label="Default select example" required>
                                            <option value="">--Select Semester--</option>
                                            <?php
                                            $major = $this->db
                                                ->where("P_PDESCRIPTIONS", $r->SC_PROG)
                                                ->where("P_MAJOR", $r->SC_MAJOR)
                                                ->get("tbl_program");

                                            if ($major->num_rows() == 0) {
                                                $major = $this->db
                                                    ->where("P_PDESCRIPTIONS", $r->SC_PROG)
                                                    ->get("tbl_program");
                                            }

                                            if ($major->num_rows() > 0) {
                                                // Fetch semesters only once outside the loop to improve performance

                                                foreach ($major->result() as $row) {
                                                    $semesters = $this->db
                                                        ->order_by("SEM_NAME", "ASC")
                                                        ->where("SEM_TYPE", $row->P_SEMTYPE)
                                                        ->get("tbl_semestertype")
                                                        ->result();
                                                    foreach ($semesters as $sem) {
                                            ?>
                                                        <option
                                                            value="<?= htmlspecialchars($sem->SEM_NAME, ENT_QUOTES); ?>"
                                                            <?php if ($row->P_SEMTYPE == $sem->SEM_TYPE) {
                                                                if ($r->SC_SEMESTER == $sem->SEM_NAME) {
                                                                    echo "selected";
                                                                }
                                                            }
                                                            ?>>
                                                            <?= htmlspecialchars($sem->SEM_NAME, ENT_QUOTES); ?>
                                                        </option>
                                            <?php
                                                    }
                                                }
                                            } else {
                                                $semesters = $this->db
                                                    ->order_by("SEM_NAME", "ASC")
                                                    ->get("tbl_semestertype")
                                                    ->result();
                                                foreach ($semesters as $sem) {
                                            ?>
                                                    <option
                                                        value="<?= htmlspecialchars($sem->SEM_NAME, ENT_QUOTES); ?>"
                                                        <?php if ($r->SC_SEMESTER == $sem->SEM_NAME) { echo "selected"; } ?>>
                                                        <?= htmlspecialchars($sem->SEM_NAME, ENT_QUOTES); ?>
                                                    </option>
                                            <?php
                                                }
                                            }
                                            ?>
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
                                        <select class="form-select select2" name="SC_YEARLEVEL" id="SC_YEARLEVEL" aria-label="Default select example" required>
                                            <option value="">--Select Year Level--</option>
                                            <option <?php if ($r->SC_YEARLEVEL == "1ST YEAR") {
                                                        echo "selected";
                                                    } ?>>1ST YEAR</option>
                                            <option <?php if ($r->SC_YEARLEVEL == "2ND YEAR") {
                                                        echo "selected";
                                                    } ?>>2ND YEAR</option>
                                            <option <?php if ($r->SC_YEARLEVEL == "3RD YEAR") {
                                                        echo "selected";
                                                    } ?>>3RD YEAR</option>
                                            <option <?php if ($r->SC_YEARLEVEL == "4TH YEAR") {
                                                        echo "selected";
                                                    } ?>>4TH YEAR</option>
                                            <option <?php if ($r->SC_YEARLEVEL == "5TH YEAR") {
                                                        echo "selected";
                                                    } ?>>5TH YEAR</option>
                                        </select>
                                        <label for="basic-default-fullname">Year Level<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="SC_SDESC" id="SC_SDESC" required>
                                            <option value="">--Select Subject--</option>
                                            <!-- Will be populated via JavaScript -->
                                        </select>


                                        <label for="basic-default-fullname">Subject Description<span class="text-danger">*</span></label>
                                        <script>
                                            $(document).ready(function() {
                                                const $prog = $("#SC_PROG");
                                                const $major = $("#SC_MAJOR");
                                                const $year = $("#SC_YEARLEVEL");
                                                const $sem = $("#SC_SEMESTER");
                                                const $subject = $("#SC_SDESC");
                                                const csrfTokenField = $('.txt_csrfname');

                                                // Get the selected subject from PHP on page load
                                                const selectedSubject = "<?= htmlspecialchars($r->SC_SDESC); ?>";

                                                // Function to load subjects based on selected filters
                                                function loadSubject(prog, maj, yr, sem) {
                                                    $.ajax({
                                                        url: '<?= base_url("SchedulingController/LoadSubject"); ?>',
                                                        type: 'POST',
                                                        dataType: 'json',
                                                        data: {
                                                            prog: prog,
                                                            maj: maj,
                                                            yr: yr,
                                                            sem: sem,
                                                            [csrfTokenField.attr('name')]: csrfTokenField.val()
                                                        },
                                                        success: function(response) {
                                                            csrfTokenField.val(response.token);
                                                            $subject.html(response.result);

                                                            // Preselect the previously selected subject
                                                            if (selectedSubject) {
                                                                $subject.val(selectedSubject).trigger('change');
                                                            }
                                                        },
                                                        error: function() {
                                                            alert("Unable to load subjects. Please try again.");
                                                        }
                                                    });
                                                }

                                                // Load subjects on page load if all fields are filled
                                                const progVal = $prog.val();
                                                const majVal = $major.val();
                                                const yearVal = $year.val();
                                                const semVal = $sem.val();

                                                if (progVal && yearVal && semVal) {
                                                    loadSubject(progVal, majVal, yearVal, semVal);
                                                }

                                                // Also reload when dropdowns are changed
                                                $prog.add($major).add($year).add($sem).on('change', function() {
                                                    const newProg = $prog.val();
                                                    const newMaj = $major.val();
                                                    const newYr = $year.val();
                                                    const newSem = $sem.val();

                                                    if (newProg && newYr && newSem) {
                                                        loadSubject(newProg, newMaj, newYr, newSem);
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="SC_DEPT" id="SC_DEPT" aria-label="Default select example" required>
                                            <option value="">--Select Department--</option>
                                            <?php
                                            foreach ($LoadDepartment->result() as $row) {
                                            ?>
                                                <option <?php if ($r->SC_DEPT == $row->D_DEPTDESCRIPTION) {
                                                            echo "selected";
                                                        } ?>><?= $row->D_DEPTDESCRIPTION; ?></option>
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
                                        <label for="basic-default-fullname">Section<span class="text-danger">*</span></label>
                                    </div>
                                    <script>
                                        $(document).ready(function() {
                                            const $prog = $("#SC_PROG");
                                            const $major = $("#SC_MAJOR");
                                            const $year = $("#SC_YEARLEVEL");
                                            const $sem = $("#SC_SEMESTER");
                                            const $section = $("#SC_SECTION");
                                            const csrfTokenField = $('.txt_csrfname');

                                            // Get the selected section from PHP on page load
                                            const selectedSection = "<?= htmlspecialchars($r->SC_SECTION ?? ''); ?>";

                                            // Function to load sections based on selected filters
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
                                                        [csrfTokenField.attr('name')]: csrfTokenField.val()
                                                    },
                                                    success: function(response) {
                                                        csrfTokenField.val(response.token);
                                                        $section.html(response.result);

                                                        // Preselect previously selected section
                                                        if (selectedSection) {
                                                            $section.val(selectedSection).trigger('change');
                                                        }
                                                    },
                                                    error: function() {
                                                        alert('Failed to load sections. Please try again.');
                                                    }
                                                });
                                            }

                                            // Load sections on page load if all fields are filled
                                            const progVal = $prog.val();
                                            const majVal = $major.val();
                                            const yearVal = $year.val();
                                            const semVal = $sem.val();

                                            if (progVal && yearVal && semVal) {
                                                loadSection(yearVal, progVal, majVal, semVal);
                                            }

                                            // Reload on dropdown change
                                            $prog.add($major).add($year).add($sem).on('change', function() {
                                                const newProg = $prog.val();
                                                const newMaj = $major.val();
                                                const newYr = $year.val();
                                                const newSem = $sem.val();

                                                if (newProg && newYr && newSem) {
                                                    loadSection(newYr, newProg, newMaj, newSem);
                                                }
                                            });
                                        });
                                    </script>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="SC_ROOM" id="SC_ROOM" aria-label="Default select example" required>
                                            <option value=''>--Select Room--</option>
                                            <?php
                                            foreach ($LoadRoom->result() as $row) {
                                            ?>
                                                <option <?php if ($r->SC_ROOM == $row->R_RMDESCRIPTION) {
                                                            echo "selected";
                                                        } ?>><?= $row->R_RMDESCRIPTION; ?></option>
                                            <?php
                                            }
                                            ?>
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
                                        <select class="form-select select2" name="SC_DAY" id="SC_DAY" aria-label="Default select example" required>
                                            <option value="">--Select Day--</option>
                                            <option <?php if ($r->SC_DAY == "MWF") {
                                                        echo "selected";
                                                    } ?>>MWF</option>
                                            <option <?php if ($r->SC_DAY == "TTH") {
                                                        echo "selected";
                                                    } ?>>TTH</option>
                                            <option <?php if ($r->SC_DAY == "M") {
                                                        echo "selected";
                                                    } ?>>M</option>
                                            <option <?php if ($r->SC_DAY == "T") {
                                                        echo "selected";
                                                    } ?>>T</option>
                                            <option <?php if ($r->SC_DAY == "W") {
                                                        echo "selected";
                                                    } ?>>W</option>
                                            <option <?php if ($r->SC_DAY == "TH") {
                                                        echo "selected";
                                                    } ?>>TH</option>
                                            <option <?php if ($r->SC_DAY == "F") {
                                                        echo "selected";
                                                    } ?>>F</option>
                                            <option <?php if ($r->SC_DAY == "SAT") {
                                                        echo "selected";
                                                    } ?>>SAT</option>
                                            <option <?php if ($r->SC_DAY == "SUN") {
                                                        echo "selected";
                                                    } ?>>SUN</option>
                                        </select>
                                        <label for="basic-default-fullname">Day<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="time" class="form-control" name="SC_STARTTIME" value="<?= $r->SC_STARTTIME; ?>" id="basic-default-fullname" required />
                                        <label for="basic-default-fullname">Start Time<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="time" class="form-control" name="SC_ENDTIME" value="<?= $r->SC_ENDTIME; ?>" id="basic-default-fullname" required />
                                        <label for="basic-default-fullname">End Time<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="SC_TEACHMODELS" id="SC_TEACHMODELS" aria-label="Default select example" required>
                                            <option value="">--Select Teaching Models--</option>
                                            <option <?php if ($r->SC_TEACHMODELS == "FACE TO FACE") {
                                                        echo "selected";
                                                    } ?>>FACE TO FACE</option>
                                            <option <?php if ($r->SC_TEACHMODELS == "ONLINE") {
                                                        echo "selected";
                                                    } ?>>ONLINE</option>
                                            <option <?php if ($r->SC_TEACHMODELS == "HYBRID") {
                                                        echo "selected";
                                                    } ?>>HYBRID</option>
                                        </select>
                                        <label for="basic-default-fullname">Teaching Models<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="SC_FACULTY" id="" aria-label="Default select example" required>
                                            <option value="">--Select Faculty--</option>
                                            <?php
                                            foreach ($LoadFaculty->result() as $row) {
                                                // Safely build the full name, ignoring empty middle name
                                                $middle = $row->FP_MIDDLENAME ? ' ' . $row->FP_MIDDLENAME : '';
                                                $fullName = $row->FP_LASTNAME . ', ' . $row->FP_FIRSTNAME . $middle;
                                            ?>
                                                <option value="<?= htmlspecialchars($fullName) ?>" <?= trim($r->SC_FACULTY) == trim($fullName) ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($fullName) ?>
                                                </option>
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
                                        <button type="submit" class="btn btn-success btn-lg">Save Changes</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </form>
            </div>
        </div>
    </div>
</div>