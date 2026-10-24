<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Data Entry</a>
            </li>
            <li class="breadcrumb-item active">Edit Rooms</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="card">
            <div class="card-header">
                <h5> Edit Rooms</h5>
            </div>
            <form action="<?= base_url("RoomsController/UpdateRooms") ?>" method="post">
                <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="ID" value="<?= $this->uri->segment(5); ?>">
                <input type="hidden" name="R_RMCODE">
                <?php
                foreach ($LoadRooms->result() as $r) {
                ?>
                    <div class="card-body">
                        <h5 class="card-title">Edit Rooms</h5>
                        <p>Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="R_RMDEPT" id="" aria-label="Default select example" required>
                                        <option selected="">--Select Department--</option>
                                        <?php
                                        foreach ($LoadDepartment->result() as $row) {
                                        ?>
                                            <option <?php if ($r->R_RMDEPT == $row->D_DEPTDESCRIPTION) {
                                                        echo "selected";
                                                    } ?>><?= $row->D_DEPTDESCRIPTION; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <label for="basic-default-fullname">Deaprtment<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="R_RMDESCRIPTION" value="<?= $r->R_RMDESCRIPTION; ?>" placeholder="Enter Room Name" required />
                                    <label for="basic-default-fullname">Room Name<span class="text-danger">*</span></label>
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