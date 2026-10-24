<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Data Entry</a>
            </li>
            <li class="breadcrumb-item active">Edit Programs</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="card">
            <div class="card-header">
                <h5> Edit Programs</h5>
            </div>
            <form action="<?= base_url("ProgramsController/UpdatePrograms") ?>" method="post" id="programForm">
                <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="ID" value="<?= $this->uri->segment(5); ?>">
                <?php
                foreach ($LoadPrograms->result() as $r) {
                ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="P_PCODE" value="<?= $r->P_PCODE; ?>" placeholder="Program Acronym/Code" />
                                    <label for="basic-default-fullname">Program Acronym/Code<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="P_PDESCRIPTIONS" value="<?= $r->P_PDESCRIPTIONS; ?>" placeholder="Enter Program/Course Description" />
                                    <label for="basic-default-fullname">Program/Course Description<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="P_MAJOR" value="<?= $r->P_MAJOR; ?>" placeholder="Enter Major" />
                                    <label for="basic-default-fullname">Major<span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="P_SEMTYPE" id="P_SEMTYPE" aria-label="Default select example" required>
                                        <option value="">--Select--</option>
                                        <option <?php if ($r->P_SEMTYPE == "REGULAR SEMESTER (2 SEMESTER)") {
                                                    echo "selected";
                                                } ?>>REGULAR SEMESTER (2 SEMESTER)</option>
                                        <option <?php if ($r->P_SEMTYPE == "TRIMESTER (3 SEMESTER)") {
                                                    echo "selected";
                                                } ?>>TRIMESTER (3 SEMESTER)</option>
                                    </select>
                                    <label for="basic-default-fullname">Semester Type<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="P_PROGTYPE" id="P_PROGTYPE" aria-label="Default select example" required>
                                        <option value="">--Select--</option>
                                        <option <?php if ($r->P_PROGTYPE == "BASIC") {
                                                    echo "selected";
                                                } ?>>BASIC</option>
                                        <option <?php if ($r->P_PROGTYPE == "BACCALAUREATE") {
                                                    echo "selected";
                                                } ?>>BACCALAUREATE</option>
                                        <option <?php if ($r->P_PROGTYPE == "POST-BACCALAUREATE") {
                                                    echo "selected";
                                                } ?>>POST-BACCALAUREATE</option>
                                        <option <?php if ($r->P_PROGTYPE == "PRE-BACCALAUREATE") {
                                                    echo "selected";
                                                } ?>>PRE-BACCALAUREATE</option>
                                        <option <?php if ($r->P_PROGTYPE == "MASTERAL") {
                                                    echo "selected";
                                                } ?>>MASTERAL</option>
                                        <option <?php if ($r->P_PROGTYPE == "DOCTORAL") {
                                                    echo "selected";
                                                } ?>>DOCTORAL</option>
                                    </select>
                                    <label for="basic-default-fullname">Status<span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                        <h6>Authority to offer Program:</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select js-example-select" name="P_CATEGORY" id="P_CATEGORY" aria-label="Default select example" required>
                                        <option value="">--Select--</option>
                                        <option <?php if ($r->P_CATEGORY == "INITIAL PERMIT") {
                                                    echo "selected";
                                                } ?>>INITIAL PERMIT</option>
                                        <option <?php if ($r->P_CATEGORY == "GOVERNMENT PERMIT") {
                                                    echo "selected";
                                                } ?>>GOVERNMENT PERMIT</option>
                                        <option <?php if ($r->P_CATEGORY == "GOVERNMENT RECOGNITION") {
                                                    echo "selected";
                                                } ?>>GOVERNMENT RECOGNITION</option>
                                        <option <?php if ($r->P_CATEGORY == "BOARD RESOLUTION") {
                                                    echo "selected";
                                                } ?>>BOARD RESOLUTION</option>
                                    </select>
                                    <label for="basic-default-fullname">Category<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="P_SERIALCODE" value="<?= $r->P_SERIALCODE; ?>" placeholder="Enter Major" />
                                    <label for="basic-default-fullname">Serial No.<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-control select2" name="P_YEARISSUED" id="P_YEARISSUED" aria-label="Default select example" style="width: 100%;" required>
                                        <option selected="">--Select Series Year--</option>
                                        <?php
                                        $currentYear = date('Y');
                                        $startYear = 2018;
                                        for ($year = $currentYear; $year >= $startYear; $year--) :
                                        ?>
                                            <option value="<?= $year ?>" <?= ($r->P_YEARISSUED == $year) ? 'selected' : '' ?>>
                                                <?= $year ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                    <label for="basic-default-fullname">Series Year<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="P_PROGSTATUS" id="P_PROGSTATUS" aria-label="Default select example" required>
                                        <option value="">--Select--</option>
                                        <option <?php if ($r->P_PROGSTATUS == "ACTIVE") {
                                                    echo "selected";
                                                } ?>>ACTIVE</option>
                                        <option <?php if ($r->P_PROGSTATUS == "INACTIVE") {
                                                    echo "selected";
                                                } ?>>INACTIVE</option>
                                    </select>
                                    <label for="basic-default-fullname">Program Status<span class="text-danger">*</span></label>
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
        var category = document.getElementById('P_YEARISSUED');
        if (category.value === "") {
            category.classList.add('is-invalid');
            event.preventDefault(); // Stop the form submission
        } else {
            category.classList.remove('is-invalid');
        }


    });
</script>