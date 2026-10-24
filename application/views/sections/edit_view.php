<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Data Entry</a>
            </li>
            <li class="breadcrumb-item active">Edit Section</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="card">
            <form action="<?= base_url("SectionsController/UpdateSections") ?>" method="post" id="sectionForm">
                <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="ID" value="<?= $this->uri->segment(5); ?>">
                <?php
                foreach ($LoadSections->result() as $r) {
                ?>
                    <div class="card-body">
                        <h5 class="card-title">Edit Section</h5>
                        <p>Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required.</p>
                        <div class="row">
                            <!-- <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="SEC_SCODE" value="<?= $r->SEC_SCODE; ?>" placeholder="Deepartment Code" required />
                                    <label for="basic-default-fullname">Room Code<span class="text-danger">*</span></label>
                                </div>
                            </div> -->
                            <div class="col-md-8">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="SEC_SDESC" value="<?= $r->SEC_SDESC; ?>" placeholder="Enter Section Name" required />
                                    <label for="basic-default-fullname">Section Name<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" class="form-control" id="basic-default-fullname" name="SEC_NOCAP" value="<?= $r->SEC_NOCAP; ?>" placeholder="Enter No. of Capacity" required />
                                    <label for="basic-default-fullname">No. of Capacity<span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-floating form-floating-outline mb-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="SEC_SPROG" id="SEC_SPROG" aria-label="Default select example" required>
                                            <option value="">--Select Program--</option>
                                            <?php
                                            foreach ($LoadPrograms->result() as $row) {
                                            ?>
                                                <option <?php if ($r->SEC_SPROG == $row->P_PDESCRIPTIONS) {
                                                            echo "selected";
                                                        } ?>><?= $row->P_PDESCRIPTIONS; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="basic-default-fullname">Program</label>
                                        <div class="invalid-feedback">
                                            Please select a valid.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" id="SEC_PROGMAJOR" name="SEC_PROGMAJOR" aria-label="Default select example">
                                        <option value=""></option>
                                        <?php
                                        $major = $this->db->where("P_PDESCRIPTIONS", $r->SEC_SPROG)->get("tbl_program");
                                        if ($major->num_rows() > 0) {
                                            foreach ($major->result() as $row) {
                                        ?>
                                                <option <?php if ($row->P_MAJOR == $r->SEC_PROGMAJOR) {
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
                                            $("#SEC_SPROG").change(function() {
                                                var maj = $(this).val();
                                                loadmajor(maj);
                                            });

                                            function loadmajor(major) {
                                                $.ajax({
                                                    url: '<?= base_url("SectionsController/LoadMajor"); ?>',
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: {
                                                        maj: major,
                                                        [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                                                    },
                                                    success: function(response) {
                                                        // if success
                                                        $('.txt_csrfname').val(response.token);
                                                        $("#SEC_PROGMAJOR").html(response.result);
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
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select class="form-select select2" name="SEC_SYRLVL" id="SEC_SYRLVL" aria-label="Default select example" required>
                                                <option value="">--Select Year Level--</option>
                                                <option <?php if ($r->SEC_SYRLVL == "1ST YEAR") {
                                                            echo "selected";
                                                        } ?>>1ST YEAR</option>
                                                <option <?php if ($r->SEC_SYRLVL == "2ND YEAR") {
                                                            echo "selected";
                                                        } ?>>2ND YEAR</option>
                                                <option <?php if ($r->SEC_SYRLVL == "3RD YEAR") {
                                                            echo "selected";
                                                        } ?>>3RD YEAR</option>
                                                <option <?php if ($r->SEC_SYRLVL == "4TH YEAR") {
                                                            echo "selected";
                                                        } ?>>4TH YEAR</option>
                                                <option <?php if ($r->SEC_SYRLVL == "5TH YEAR") {
                                                            echo "selected";
                                                        } ?>>5TH YEAR</option>
                                            </select>
                                            <label for="basic-default-fullname">Year Level<span class="text-danger">*</span></label>
                                            <div class="invalid-feedback">
                                                Please select a valid.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select class="form-select select2" name="SEC_SSEM" id="SEC_SSEM" aria-label="Default select example" required>
                                                <option value="">--Select Semester--</option>
                                                <?php
                                                $major = $this->db
                                                    ->where("P_PDESCRIPTIONS", $r->SEC_SPROG)
                                                    ->where("P_MAJOR", $r->SEC_PROGMAJOR)
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
                                                                    if ($r->SEC_SSEM == $sem->SEM_NAME) {
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
                                                    $("#SEC_SPROG, #SEC_PROGMAJOR").change(function() {
                                                        var prog = $("#SEC_SPROG").val();
                                                        var maj = $("#SEC_PROGMAJOR").val();
                                                        loadsemester(prog, maj);
                                                    });

                                                    function loadsemester(program, major) {
                                                        $.ajax({
                                                            url: '<?= base_url("SectionsController/LoadSemester"); ?>',
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
                                                                $("#SEC_SSEM").html(response.result);
                                                            },
                                                            error: function(xhr, status, error) {
                                                                alert('Failed to save form. Please try again later.');
                                                            }
                                                        });
                                                    }
                                                });
                                            </script>
                                            <label for="basic-default-fullname">Semester<span class="text-danger">*</span></label>
                                            <div class="invalid-feedback">
                                                Please select a valid.
                                            </div>
                                        </div>
                                    </div>
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

<script>
    document.getElementById('sectionForm').addEventListener('submit', function(event) {
        // Check if the Year Level dropdown has a valid selection
        var semtype = document.getElementById('SEC_SSEM');
        if (semtype.value === "") {
            semtype.classList.add('is-invalid');
            event.preventDefault(); // Stop the form submission
        } else {
            semtype.classList.remove('is-invalid');
        }

        // Check if the Semester dropdown has a valid selection
        var progtype = document.getElementById('SEC_SYRLVL');
        if (progtype.value === "") {
            progtype.classList.add('is-invalid');
            event.preventDefault(); // Stop the form submission
        } else {
            progtype.classList.remove('is-invalid');
        }

        // Check if the Semester dropdown has a valid selection
        var category = document.getElementById('SEC_SPROG');
        if (category.value === "") {
            category.classList.add('is-invalid');
            event.preventDefault(); // Stop the form submission
        } else {
            category.classList.remove('is-invalid');
        }
    });
</script>
<!-- / Content -->