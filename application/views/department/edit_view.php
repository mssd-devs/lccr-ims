<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Data Entry</a>
            </li>
            <li class="breadcrumb-item active">Edit Department</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="card">
            <form action="<?= base_url("DepartmentController/UpdateDepartments") ?>" method="post">
                <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="ID" value="<?= $this->uri->segment(5); ?>">
                <?php
                foreach ($LoadDepartments->result() as $r) {
                ?>
                    <div class="card-body">
                        <h5 class="card-title">Edit Department</h5>
                        <p>Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required.</p>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="D_DEPTCODE" value="<?= $r->D_DEPTCODE; ?>" placeholder="Deepartment Code" required />
                                    <label for="basic-default-fullname">Department Code<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="D_DEPTDESCRIPTION" value="<?= $r->D_DEPTDESCRIPTION; ?>" placeholder="Enter Department Description" required />
                                    <label for="basic-default-fullname">Department Description<span class="text-danger">*</span></label>
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

<!-- FOR UPPERCASE -->
<script>
    $(document).on('input', '[type="text"], textarea', function() {
        var inputText = $(this).val();
        var uppercaseText = inputText.toUpperCase();
        var textWithoutDoubleSpaces = uppercaseText.replace(/  +/g, ' ');
        $(this).val(textWithoutDoubleSpaces);
    });
</script>