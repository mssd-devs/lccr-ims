<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Data Entry</a>
            </li>
            <li class="breadcrumb-item active">Edit Subject</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="card">
            <form action="<?= base_url("SubjectController/UpdateSubjects") ?>" method="post">
                <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="ID" value="<?= $this->uri->segment(5); ?>">
                <?php
                foreach ($LoadSubjects->result() as $r) {
                ?>
                    <div class="card-body">
                        <h5 class="card-title">Edit Subjects</h5>
                        <p>Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required.</p>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" id="S_SELECTPROG" name="S_SELECTPROG" aria-label="Default select example">
                                        <option value="">--Select Program--</option>
                                        <?php
                                        foreach ($LoadPrograms->result() as $rows) {
                                        ?>
                                            <option <?php if ($r->S_SELECTPROG == $rows->P_PDESCRIPTIONS) {
                                                        echo "selected";
                                                    } ?>><?= $rows->P_PDESCRIPTIONS; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <label for="basic-default-fullname">Program<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" id="S_MAJOR" name="S_MAJOR" aria-label="Default select example">
                                        <option value=""></option>
                                        <?php
                                        $major = $this->db->where("P_PDESCRIPTIONS", $r->S_SELECTPROG)->get("tbl_program");
                                        if ($major->num_rows() > 0) {
                                            foreach ($major->result() as $row) {
                                        ?>
                                                <option <?php if ($row->P_MAJOR == $r->S_MAJOR) {
                                                            echo "selected";
                                                        } ?> value="<?= $row->P_MAJOR; ?>"><?= $row->P_MAJOR; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <label for="basic-default-fullname">Major</label>
                                    <script>
                                        $(document).ready(function() {
                                            $("#S_SELECTPROG").change(function() {
                                                var maj = $(this).val();
                                                loadmajor(maj);
                                            });

                                            function loadmajor(major) {
                                                $.ajax({
                                                    url: '<?= base_url("SubjectController/LoadMajor"); ?>',
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: {
                                                        maj: major,
                                                        [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                                                    },
                                                    success: function(response) {
                                                        // if success
                                                        $('.txt_csrfname').val(response.token);
                                                        $("#S_MAJOR").html(response.result);
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
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="S_SCODE" value="<?= $r->S_SCODE; ?>" placeholder="Course No." />
                                    <label for="basic-default-fullname">Course No.<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="S_SDESCRIPTION" value="<?= $r->S_SDESCRIPTION; ?>" placeholder="Descriptive Title" />
                                    <label for="basic-default-fullname">Descriptive Title<span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" class="form-control" id="basic-default-fullname" name="S_UNITS" value="<?= $r->S_UNITS; ?>" placeholder="Units" />
                                    <label for="basic-default-fullname">Units<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="S_PREREQ" value="<?= $r->S_PREREQ; ?>" placeholder="Pre-Requisit" />
                                    <label for="basic-default-fullname">Pre-Requisite</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="S_SUBTYPE" id="S_SUBTYPE" aria-label="Default select example">
                                        <option value="">--Select Subject Type--</option>
                                        <option <?php if ($r->S_SUBTYPE == "MINOR") {
                                                    echo "selected";
                                                } ?>>MINOR</option>
                                        <option <?php if ($r->S_SUBTYPE == "MAJOR") {
                                                    echo "selected";
                                                } ?>>MAJOR</option>
                                    </select>
                                    <label for="basic-default-fullname">Subject Type<span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="S_YRLVL" id="S_YRLVL" aria-label="Default select example">
                                        <option value="">--Select Year Level--</option>
                                        <option <?php if ($r->S_YRLVL == "1ST YEAR") {
                                                    echo "selected";
                                                } ?>>1ST YEAR</option>
                                        <option <?php if ($r->S_YRLVL == "2ND YEAR") {
                                                    echo "selected";
                                                } ?>>2ND YEAR</option>
                                        <option <?php if ($r->S_YRLVL == "3RD YEAR") {
                                                    echo "selected";
                                                } ?>>3RD YEAR</option>
                                        <option <?php if ($r->S_YRLVL == "4TH YEAR") {
                                                    echo "selected";
                                                } ?>>4TH YEAR</option>
                                        <option <?php if ($r->S_YRLVL == "5TH YEAR") {
                                                    echo "selected";
                                                } ?>>5TH YEAR</option>
                                    </select>
                                    <label for="basic-default-fullname">Year Level<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="S_SEM" id="S_SEM" aria-label="Default select example" required>
                                        <option value="">--Select Semester--</option>
                                        <?php
                                        $major = $this->db
                                            ->where("P_PDESCRIPTIONS", $r->S_SELECTPROG)
                                            ->where("P_MAJOR", $r->S_MAJOR)
                                            ->get("tbl_program");

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
                                                            if ($r->S_SEM == $sem->SEM_NAME) {
                                                                echo "selected";
                                                            }
                                                        }
                                                        ?>>
                                                        <?= htmlspecialchars($sem->SEM_NAME, ENT_QUOTES); ?>
                                                    </option>
                                        <?php
                                                }
                                            }
                                        }
                                        ?>
                                    </select>
                                    <script>
                                        $(document).ready(function() {
                                            $("#S_SELECTPROG, #S_MAJOR").change(function() {
                                                var prog = $("#S_SELECTPROG").val();
                                                var maj = $("#S_MAJOR").val();
                                                loadsemester(prog, maj);
                                            });

                                            function loadsemester(program, major) {
                                                $.ajax({
                                                    url: '<?= base_url("SubjectController/LoadSemester"); ?>',
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
                                                        $("#S_SEM").html(response.result);
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
                    </div>
                <?php
                }
                ?>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-lg">Save Changes</button>
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

<script>
    document.getElementById('subjectForm').addEventListener('submit', function(event) {
        // Check if the Year Level dropdown has a valid selection
        var yearLevel = document.getElementById('S_YRLVL');
        if (yearLevel.value === "") {
            yearLevel.classList.add('is-invalid');
            event.preventDefault(); // Stop the form submission
        } else {
            yearLevel.classList.remove('is-invalid');
        }

        // Check if the Semester dropdown has a valid selection
        var semester = document.getElementById('S_SEM');
        if (semester.value === "") {
            semester.classList.add('is-invalid');
            event.preventDefault(); // Stop the form submission
        } else {
            semester.classList.remove('is-invalid');
        }
    });
</script>