<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Data Entry</a>
            </li>
            <li class="breadcrumb-item active">Subjects</li>
        </ol>
    </nav>

    <div class="row gy-4 mb-4">
        <div class="col-md-12">
            <div class="card">
                <form action="<?= base_url("SubjectController/SaveSubjects") ?>" method="post" id="subjectForm">
                    <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                    <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                    <div class="card-body">
                        <h5 class="card-title">Create Subjects</h5>
                        <p>Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required.</p>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" id="S_SELECTPROG" name="S_SELECTPROG" aria-label="Default select example" required>
                                        <option value="">--Select Program/Course--</option>
                                        <?php
                                        foreach ($LoadPrograms->result() as $r) {
                                        ?>
                                            <option><?= $r->P_PDESCRIPTIONS ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <label for="basic-default-fullname">Program/Course<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="S_MAJOR" id="S_MAJOR" aria-label="Default select example" readonly>
                                        <option value=""></option>
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
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" id="S_YRLVL" name="S_YRLVL" aria-label="Default select example" required>
                                        <option value="">--Select Year Level--</option>
                                        <option value="1ST YEAR">1ST YEAR</option>
                                        <option value="2ND YEAR">2ND YEAR</option>
                                        <option value="3RD YEAR">3RD YEAR</option>
                                        <option value="4TH YEAR">4TH YEAR</option>
                                        <option value="5TH YEAR">5TH YEAR</option>
                                    </select>
                                    <label for="S_YRLVL">Year Level <span class="text-danger">*</span></label>
                                    <div class="invalid-feedback">
                                        Please select a valid year level.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" id="S_SEM" name="S_SEM" aria-label="Default select example" required>
                                        <option value="">--Select Semester--</option>
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
                                    <label for="S_SEM">Semester <span class="text-danger">*</span></label>
                                    <div class="invalid-feedback">
                                        Please select a valid semester.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="S_SCODE" placeholder="Course No." required />
                                    <label for="basic-default-fullname">Course No.<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="S_SDESCRIPTION" placeholder="Descriptive Title" required />
                                    <label for="basic-default-fullname">Descriptive Title<span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" class="form-control" id="basic-default-fullname" name="S_UNITS" placeholder="Units" required />
                                    <label for="basic-default-fullname">Units<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="S_PREREQ" placeholder="Pre-Requisite" />
                                    <label for="basic-default-fullname">Pre-Requisite</label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" id="S_SUBTYPE" name="S_SUBTYPE" aria-label="Default select example" required>
                                        <option value="">--Select Subject Type--</option>
                                        <option value="MINOR">MINOR</option>
                                        <option value="MAJOR">MAJOR</option>
                                    </select>
                                    <label for="S_SUBTYPE">Subject Type <span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-success btn-lg btnSave"><i class="ri-save-line"></i>Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">List of Subjects by Program</h5>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Program</th>
                                    <th>Major</th>
                                    <th>Course No.</th>
                                    <th>Descriptive Title</th>
                                    <th>Units</th>
                                    <th>Pre-Requisite</th>
                                    <th>Year Level</th>
                                    <th>Semester</th>
                                    <th>Subject Type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($LoadSubjects->result() as $r) {
                                ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $r->S_SELECTPROG; ?></td>
                                        <td><?= $r->S_MAJOR; ?></td>
                                        <td><?= $r->S_SCODE; ?></td>
                                        <td><?= $r->S_SDESCRIPTION; ?></td>
                                        <td><?= $r->S_UNITS; ?></td>
                                        <td><?= $r->S_PREREQ; ?></td>
                                        <td><?= $r->S_YRLVL; ?></td>
                                        <td><?= $r->S_SEM; ?></td>
                                        <td><?= $r->S_SUBTYPE; ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="ri-more-2-fill"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="<?= base_url("ims/entries/subject/edit/" . $r->ID); ?>"><i class="ri-edit-line me-1"></i> Edit</a>
                                                    <a class="dropdown-item btnDelete" href="javascript:void(0);" data-id="<?= $r->ID; ?>" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="ri-delete-bin-line me-1"></i> Delete</a>
                                                </div>
                                            </div>
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
</div>

<!-- / Content -->

<!-- Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="<?= base_url("SubjectController/DeleteSubjects"); ?>" method="POST">
            <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
            <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

            <div class="modal-header">
                <h4 class="modal-title" id="backDropModalTitle">Are you sure?</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                You won't be able to revert this!
                <input type="hidden" name="ID" id="ID">
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

        $(document).on("click", ".btnDelete", function() {
            $("#ID").val($(this).data("id"));
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            dom: 'Bfrtip', // 'B' for buttons
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>

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
        var yearLevel = document.getElementById('S_SELECTPROG');
        if (yearLevel.value === "") {
            yearLevel.classList.add('is-invalid');
            event.preventDefault(); // Stop the form submission
        } else {
            yearLevel.classList.remove('is-invalid');
        }
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