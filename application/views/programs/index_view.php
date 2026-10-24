<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Data Entry</a>
            </li>
            <li class="breadcrumb-item active">Programs</li>
        </ol>
    </nav>

    <div class="row gy-4 mb-4">
        <div class="col-md-12">
            <div class="card">
                <form action="<?= base_url("ProgramsController/SavePrograms") ?>" method="post" id="programForm">
                    <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                    <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <div class="card-body">
                        <h5 class="card-title">Create Programs</h5>
                        <p>Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required.</p>
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="P_PCODE" placeholder="Program Acronym/Code" required />
                                    <label for="basic-default-fullname">Program Acronym/Code<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="P_PDESCRIPTIONS" placeholder="Enter Program/Course Description" required />
                                    <label for="basic-default-fullname">Program/Course Description<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="P_MAJOR" placeholder="Enter Major (Optional)" />
                                    <label for="basic-default-fullname">Major (Optional)</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="P_SEMTYPE" id="P_SEMTYPE" aria-label="Default select example" required>
                                        <option value="">--Select--</option>
                                        <option value="REGULAR SEMESTER (2 SEMESTER)">REGULAR SEMESTER (2 SEMESTER)</option>
                                        <option value="TRIMESTER (3 SEMESTER)">TRIMESTER (3 SEMESTER)</option>
                                    </select>
                                    <label for="basic-default-fullname">Semester Type<span class="text-danger">*</span></label>
                                    <div class="invalid-feedback">
                                        Please select a valid.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="P_PROGTYPE" id="P_PROGTYPE" aria-label="Default select example" required>
                                        <option value="">--Select--</option>
                                        <option value="BASIC">BASIC</option>
                                        <option value="BACCALAUREATE">BACCALAUREATE</option>
                                        <option value="POST-BACCALAUREATE">POST-BACCALAUREATE</option>
                                        <option value="PRE-BACCALAUREATE">PRE-BACCALAUREATE</option>
                                        <option value="MASTERAL">MASTERAL</option>
                                        <option value="DOCTORAL">DOCTORAL</option>
                                    </select>
                                    <label for="basic-default-fullname">Program Type<span class="text-danger">*</span></label>
                                    <div class="invalid-feedback">
                                        Please select a valid.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <h6>Authority to offer Program:</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="P_CATEGORY" id="P_CATEGORY" aria-label="Default select example" required>
                                            <option value="">--Select Category--</option>
                                            <option value="INITIAL PERMIT">INITIAL PERMIT</option>
                                            <option value="GOVERNMENT PERMIT">GOVERNMENT PERMIT</option>
                                            <option value="GOVERNMENT RECOGNITION">GOVERNMENT RECOGNITION</option>
                                            <option value="BOARD RESOLUTION">BOARD RESOLUTION</option>
                                        </select>
                                        <label for="basic-default-fullname">Category<span class="text-danger">*</span></label>
                                        <div class="invalid-feedback">
                                            Please select a valid.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="P_SERIALCODE" placeholder="Serial Code" required />
                                    <label for="basic-default-fullname">Serial No.<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="P_YEARISSUED" aria-label="Default select example" required>
                                        <option selected="">--Select Series Year--</option>
                                        <?php for ($start_year = date('Y'); $start_year >= 2018; $start_year--) : ?>
                                            <option value="<?php echo $start_year; ?>"><?php echo $start_year; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <label for="basic-default-fullname">Series Year<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="P_PROGSTATUS" id="exampleFormControlSelect1" aria-label="Default select example" required>
                                        <option selected="">--Select Status--</option>
                                        <option value="ACTIVE">ACTIVE</option>
                                        <option value="INACTIVE">INACTIVE</option>
                                    </select>
                                    <label for="basic-default-fullname">Program Status<span class="text-danger">*</span></label>
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
                    <h5 class="card-title">List of Programs</h5>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Program Code</th>
                                    <th>Program Description</th>
                                    <th>Major</th>
                                    <th>Semester Type</th>
                                    <th>Program Type</th>
                                    <th>Program Category</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;
                                foreach ($LoadPrograms->result() as $r) {
                                ?>
                                    <tr>
                                        <td><?= $i++; ?></td>
                                        <td><?= $r->P_PCODE; ?></td>
                                        <td><?= $r->P_PDESCRIPTIONS; ?></td>
                                        <td><?= $r->P_MAJOR; ?></td>
                                        <td><?= $r->P_SEMTYPE; ?></td>
                                        <td><?= $r->P_PROGTYPE; ?></td>
                                        <td><?= $r->P_CATEGORY; ?></td>
                                        <td><?php if ($r->P_PROGSTATUS == "ACTIVE") {
                                                echo "<span class='badge rounded-pill bg-success'>$r->P_PROGSTATUS</span>";
                                            } else {
                                                echo "<span class='badge rounded-pill bg-danger'>$r->P_PROGSTATUS</span>";
                                            } ?></td>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="ri-more-2-fill"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="<?= base_url("ims/entries/programs/edit/" . $r->ID); ?>"><i class="ri-edit-line me-1"></i> Edit</a>
                                                    <a class="dropdown-item btnDelete" href="javascript:void(0);" data-id="<?= $r->ID; ?>" type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="ri-delete-bin-line me-1"></i> Delete</a>
                                                    <a class="dropdown-item" href="<?= base_url("ims/entries/programs/prospectus/" . $r->ID); ?>"><i class="ri-eye-line me-1"></i> View Prospectus</a>
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
        <form class="modal-content" action="<?= base_url("ProgramsController/DeletePrograms"); ?>" method="POST">
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
    document.getElementById('programForm').addEventListener('submit', function(event) {
        // Check if the Year Level dropdown has a valid selection
        var semtype = document.getElementById('P_SEMTYPE');
        if (semtype.value === "") {
            semtype.classList.add('is-invalid');
            event.preventDefault(); // Stop the form submission
        } else {
            semtype.classList.remove('is-invalid');
        }

        // Check if the Semester dropdown has a valid selection
        var progtype = document.getElementById('P_PROGTYPE');
        if (progtype.value === "") {
            progtype.classList.add('is-invalid');
            event.preventDefault(); // Stop the form submission
        } else {
            progtype.classList.remove('is-invalid');
        }

        // Check if the Semester dropdown has a valid selection
        var category = document.getElementById('P_CATEGORY');
        if (category.value === "") {
            category.classList.add('is-invalid');
            event.preventDefault(); // Stop the form submission
        } else {
            category.classList.remove('is-invalid');
        }

        // Check if the Semester dropdown has a valid selection
        var yearissued = document.getElementById('P_YEARISSUED');
        if (yearissued.value === "") {
            yearissued.classList.add('is-invalid');
            event.preventDefault(); // Stop the form submission
        } else {
            yearissued.classList.remove('is-invalid');
        }


    });
</script>