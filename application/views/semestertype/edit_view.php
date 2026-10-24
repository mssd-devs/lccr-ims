<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Data Entry</a>
            </li>
            <li class="breadcrumb-item active">Edit Semester Type</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="card">
            <form action="<?= base_url("SemesterTypeController/UpdateSemester") ?>" method="post">
                <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in config.php file ) -->
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="ID" value="<?= $this->uri->segment(5); ?>">
                <?php
                foreach ($LoadSemesterType->result() as $r) {
                ?>
                    <div class="card-body">
                        <h5> Edit Semester Type</h5>
                        <p>Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="SEM_TYPE" id="SEM_TYPE" aria-label="Default select example">
                                        <option selected="">--Select Year Level--</option>
                                        <option <?php if ($r->SEM_TYPE == "REGULAR SEMESTER (2 SEMESTER)") {
                                                    echo "selected";
                                                } ?>>REGULAR SEMESTER (2 SEMESTER)</option>
                                        <option <?php if ($r->SEM_TYPE == "TRIMESTER (3 SEMESTER)") {
                                                    echo "selected";
                                                } ?>>TRIMESTER (3 SEMESTER)</option>
                                    </select>
                                    <label for="basic-default-fullname">Semester Type<span class="text-danger">*</span></label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="SEM_NAME" value="<?= $r->SEM_NAME; ?>" placeholder="Enter Semester Name" required />
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