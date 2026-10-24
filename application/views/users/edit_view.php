<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">User Management</a>
            </li>
            <li class="breadcrumb-item active">Edit Entry</li>
        </ol>
    </nav>

    <div class="row gy-4">
        <div class="card">
            <div class="card-header">
                <h5>Edit Users</h5>
            </div>
            <form action="<?= base_url("UsersController/updateUsers") ?>" method="post">
                <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="ID" value="<?= $this->uri->segment(4); ?>">
                <?php
                foreach ($LoadUsers->result() as $r) {
                ?>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" value="<?= $r->IMS_USERS_NAME; ?>" name="IMS_USERS_NAME" id="basic-default-fullname" required placeholder="Enter your Full Name" />
                                    <label for="basic-default-fullname">Full Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="IMS_USERS_ROLE" required id="exampleFormControlSelect1" aria-label="Default select example">
                                        <option value="">--Select--</option>
                                        <option <?php if ($r->IMS_USERS_ROLE == "Administrator") {
                                                    echo "selected";
                                                } ?>>Administrator</option>
                                        <option <?php if ($r->IMS_USERS_ROLE == "School President") {
                                                    echo "selected";
                                                } ?>>School President</option>
                                        <option <?php if ($r->IMS_USERS_ROLE == "HR Officer") {
                                                    echo "selected";
                                                } ?>>HR Officer</option>
                                        <option <?php if ($r->IMS_USERS_ROLE == "Registrar") {
                                                    echo "selected";
                                                } ?>>Registrar</option>
                                        <option <?php if ($r->IMS_USERS_ROLE == "Dean") {
                                                    echo "selected";
                                                } ?>>Dean</option>
                                        <option <?php if ($r->IMS_USERS_ROLE == "Program Head") {
                                                    echo "selected";
                                                } ?>>Program Head</option>
                                        <option <?php if ($r->IMS_USERS_ROLE == "Faculty") {
                                                    echo "selected";
                                                } ?>>Faculty</option>
                                        <option <?php if ($r->IMS_USERS_ROLE == "Head Cashier") {
                                                    echo "selected";
                                                } ?>>Head Cashier</option>
                                        <option <?php if ($r->IMS_USERS_ROLE == "Assistant Cashier") {
                                                    echo "selected";
                                                } ?>>Assistant Cashier</option>
                                        <option <?php if ($r->IMS_USERS_ROLE == "Admission Officer") {
                                                    echo "selected";
                                                } ?>>Admission Officer</option>
                                        <option <?php if ($r->IMS_USERS_ROLE == "IT Staff") {
                                                    echo "selected";
                                                } ?>>IT Staff</option>
                                    </select>
                                    <label for="basic-default-fullname">User Role</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" name="IMS_USERS_UNAME" value="<?= $r->IMS_USERS_UNAME; ?>" required id="IMS_USERS_UNAME" placeholder="Enter Username" />
                                    <label for="basic-default-fullname">Username</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="password" class="form-control" name="IMS_USERS_PWORD" id="IMS_USERS_PWORD" placeholder="Enter Password" />
                                    <label for="basic-default-fullname">Password</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="IMS_USERS_STATUS" required id="exampleFormControlSelect1" aria-label="Default select example">
                                        <option value="">--Select--</option>
                                        <option <?php if ($r->IMS_USERS_STATUS == "Active") {
                                                    echo "selected";
                                                } ?>>Active</option>
                                        <option <?php if ($r->IMS_USERS_STATUS == "Inactive") {
                                                    echo "selected";
                                                } ?>>Inactive</option>
                                    </select>
                                    <label for="basic-default-fullname">User Status</label>
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