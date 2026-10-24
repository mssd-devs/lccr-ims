<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Data Entry</a>
            </li>
            <li class="breadcrumb-item active">Edit Requirements</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <form action="<?= base_url("RequirementsController/UpdateRequirements") ?>" method="post">
                    <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in config.php file ) -->
                    <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <input type="hidden" name="ID" value="<?= $this->uri->segment(5); ?>">
                    <?php
                    foreach ($LoadRequirements->result() as $r) {
                    ?>
                        <div class="card-body">
                            <h5 class="card-title">Edit Requirements</h5>
                            <p>Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required.</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="REQ_CAT" aria-label="Default select example" data-allow-clear="true" required>
                                            <option value="">--Select--</option>
                                            <option <?php if ($r->REQ_CAT == "Freshmen") {
                                                        echo "selected";
                                                    } ?>>Freshmen</option>
                                            <option <?php if ($r->REQ_CAT == "Transferee") {
                                                        echo "selected";
                                                    } ?>>Transferee</option>
                                        </select>
                                        <label for="basic-default-fullname">Category<span class="text-danger">*</span></label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" id="basic-default-fullname" name="REQS" value="<?= $r->REQS; ?>" placeholder="Enter requirements" required />
                                        <label for="basic-default-fullname">Requirements<span class="text-danger">*</span></label>
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
</div>

<!-- / Content -->