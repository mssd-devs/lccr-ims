<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Data Entry</a>
            </li>
            <li class="breadcrumb-item active">Section</li>
        </ol>
    </nav>

    <div class="row gy-4 mb-4">
        <div class="col-md-12">
            <div class="card">
                <form action="<?= base_url("SectionsController/SaveSections") ?>" method="post" id="sectionForm">
                    <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                    <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <div class="card-body">
                        <h5 class="card-title"> Create Section</h5>
                        <p>Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required.</p>
                        <div class="row">
                            <!-- <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="SEC_SCODE" placeholder="Section Code" required />
                                    <label for="basic-default-fullname">Section Code<span class="text-danger">*</span></label>
                                </div>
                            </div> -->
                            <div class="col-md-8">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="SEC_SDESC" placeholder="Enter Section Name" required />
                                    <label for="basic-default-fullname">Section Name<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="number" class="form-control" id="basic-default-fullname" name="SEC_NOCAP" placeholder="Enter No. of Capacity" required />
                                    <label for="basic-default-fullname">No. of Capacity<span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-floating form-floating-outline mb-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="SEC_SPROG" id="SEC_SPROG" aria-label="Default select example" required>
                                            <option selected="">--Select Program--</option>
                                            <?php
                                            foreach ($LoadPrograms->result() as $r) {
                                            ?>
                                                <option><?= $r->P_PDESCRIPTIONS; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="basic-default-fullname">Program<span class="text-danger">*</span></label>
                                        <div class="invalid-feedback">
                                            Please select a valid.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="SEC_PROGMAJOR" id="SEC_PROGMAJOR" aria-label="Default select example" readonly>
                                        <option selected=""></option>
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
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="SEC_SYRLVL" id="SEC_SYRLVL" aria-label="Default select example" required>
                                            <option selected="">--Select Year Level--</option>
                                            <option value="1ST YEAR">1ST YEAR</option>
                                            <option value="2ND YEAR">2ND YEAR</option>
                                            <option value="3RD YEAR">3RD YEAR</option>
                                            <option value="4TH YEAR">4TH YEAR</option>
                                            <option value="5TH YEAR">5TH YEAR</option>
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
                                            <option selected="">--Select Semester--</option>
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
                    <h5 class="card-title">List of Section</h5>
                    <div class="table-responsive pt-0">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Section Code</th>
                                    <th>Section Name</th>
                                    <th>Program</th>
                                    <th>Major</th>
                                    <th>Year Level</th>
                                    <th>Semester</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($LoadSections->result() as $r) {
                                ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $r->SEC_SCODE; ?></td>
                                        <td><?= $r->SEC_SDESC; ?></td>
                                        <td><?= $r->SEC_SPROG; ?></td>
                                        <td><?= $r->SEC_PROGMAJOR; ?></td>
                                        <td><?= $r->SEC_SYRLVL; ?></td>
                                        <td><?= $r->SEC_SSEM; ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="ri-more-2-fill"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="<?= base_url("ims/entries/sections/edit/" . $r->ID); ?>"><i class="ri-edit-line me-1"></i> Edit</a>
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
<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="<?= base_url("SectionsController/DeleteSections"); ?>" method="POST">
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
        var yearlvl = document.getElementById('SEC_SYRLVL');
        if (yearlvl.value === "") {
            yearlvl.classList.add('is-invalid');
            event.preventDefault(); // Stop the form submission
        } else {
            progtype.classList.remove('is-invalid');
        }

        // Check if the Semester dropdown has a valid selection
        var prog = document.getElementById('SEC_SPROG');
        if (prog.value === "") {
            prog.classList.add('is-invalid');
            event.preventDefault(); // Stop the form submission
        } else {
            prog.classList.remove('is-invalid');
        }
    });
</script>