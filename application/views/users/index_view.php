<div class="container-xxl flex-grow-1 container-p-y">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">User Management</a>
            </li>
            <li class="breadcrumb-item active">Data Entry</li>
        </ol>
    </nav>

    <div class="row gy-4 mb-4">
        <div class="col-md-12">
            <div class="card">
                <form action="<?= base_url("UsersController/saveUsers") ?>" method="post">
                    <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                    <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <div class="card-body">
                        <h5 class="card-title">Create Users</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" name="IMS_USERS_NAME" id="basic-default-fullname" required placeholder="Enter your Full Name" />
                                    <label for="basic-default-fullname">Full Name</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="IMS_USERS_ROLE" required id="" aria-label="Default select example">
                                        <option value="">--Select--</option>
                                         <?php if (in_array(strtolower(trim($usertype ?? '')), ["administrator", "superadmin", "super admin", "admin"])) { ?>
                                             <option>Superadmin</option>
                                         <?php } ?>
                                        <option>Administrator</option>
                                        <option>School President</option>
                                        <option>HR Officer</option>
                                        <option>Registrar</option>
                                        <option>Dean</option>
                                        <option>Program Head</option>
                                        <option>Faculty</option>
                                        <option>Admission Officer</option>
                                        <option>Head Cashier</option>
                                        <option>Assistant Cashier</option>
                                        <option>IT Staff</option>
                                    </select>
                                    <label for="basic-default-fullname">User Role</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" name="IMS_USERS_UNAME" required id="IMS_USERS_UNAME" placeholder="Enter Username" />
                                    <label for="basic-default-fullname">Username</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="password" class="form-control" name="IMS_USERS_PWORD" required id="IMS_USERS_PWORD" placeholder="Enter Password" />
                                    <label for="basic-default-fullname">Password</label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="IMS_USERS_STATUS" required id="exampleFormControlSelect1" aria-label="Default select example">
                                        <option value="">--Select--</option>
                                        <option>Active</option>
                                        <option>Inactive</option>
                                    </select>
                                    <label for="basic-default-fullname">User Status</label>
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
                    <div class="card-body">
                        <h5 class="card-title">List of Users</h5>
                        <div class="table-responsive pt-0">
                            <table class="table table-bordered" id="dataTable">
                                <thead>
                                    <tr>
                                        <th>Set Permissions</th>
                                        <th>Name</th>
                                        <th>User Role</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $current_usertype = $this->session->userdata("usertype");
                                    $is_current_admin = in_array(strtolower(trim($current_usertype ?? '')), ["superadmin", "super admin"]);
                                    foreach ($LoadUsers->result() as $r) {
                                        $is_row_admin = in_array(strtolower(trim($r->IMS_USERS_ROLE ?? '')), ["superadmin", "super admin"]);
                                        if ($is_row_admin && !$is_current_admin) {
                                            continue;
                                        }
                                    ?>
                                        <tr>
                                            <td>
                                                <?php
                                                if (!$is_row_admin) {
                                                ?>
                                                    <button class="btn btn-warning btn-permission" data-id="<?= $r->ID; ?>"><i class="ri-shield-user-line me-1"></i> Permissions</button>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <td><?= $r->IMS_USERS_NAME; ?></td>
                                            <td><?= $r->IMS_USERS_ROLE; ?></td>
                                            <td><span class="badge <?php
                                                                    if ($r->IMS_USERS_STATUS == "Active") {
                                                                        echo "bg-label-success";
                                                                    } else {
                                                                        echo "bg-label-warning";
                                                                    }
                                                                    ?> rounded-pill"><?= $r->IMS_USERS_STATUS; ?></span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="ri-more-2-fill"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="<?= base_url("ims/users/edit/" . $r->ID); ?>"><i class="ri-edit-line me-1"></i> Edit</a>

                                                        <a class="dropdown-item" href="javascript:void(0);" data-id="<?= $r->ID; ?>" type="button" id="btnDelete" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="ri-delete-bin-line me-1"></i> Delete</a>
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


    <div class="modal fade" id="permissionsModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form class="modal-content" method="POST">
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="PERMISSIONS_ID" id="PERMISSIONS_ID">
                <div class="modal-header">
                    <h4 class="modal-title" id="backDropModalTitle">Set Permissions</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="permissionsTable">
                            <thead>
                                <tr>
                                    <th>Page</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="permissionsTableBody">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- <script>
        $(document).ready(function() {

            $(".btn-permission").click(function() {
                $.ajax({
                    url: '<?= base_url("UsersController/get_permission") ?>', // PHP file to fetch permissions
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        ID: $(this).data("id"),
                        [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val() // CSRF token
                    }, // Add any data you need to send here
                    success: function(response) {
                        // Update CSRF hash
                        $('.txt_csrfname').val(response.token);
                        $('#permissionsTableBody').html(response.output);
                        $('#permissionsModal').modal('show'); // Show the modal after content loads
                    },
                    error: function() {
                        $('#permissionsModal .modal-body').html('<p>Error fetching data.</p>');
                    }
                });
            });




        });
    </script> -->

    <script>
        $(document).ready(function() {
            // Fetch permissions
            $(".btn-permission").click(function() {
                $.ajax({
                    url: '<?= base_url("UsersController/get_permission") ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        ID: $(this).data("id"),
                        [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                    },
                    success: function(response) {
                        $('.txt_csrfname').val(response.token);
                        $('#permissionsTableBody').html(response.output);
                        $('#PERMISSIONS_ID').val(response.ID);
                        $('#permissionsModal').modal('show');
                    },
                    error: function() {
                        $('#permissionsModal .modal-body').html('<p>Error fetching data.</p>');
                    }
                });
            });

            // Handle page checkbox clicks
            $(document).on('change', '.page-checkbox', function() {
                var isChecked = $(this).prop('checked');
                var row = $(this).closest('tr');
                row.find('.action-checkbox').prop('checked', isChecked);
            });

            // Handle form submission
            $('#permissionsModal form').on('submit', function(e) {
                e.preventDefault();

                var permissions = [];
                $('.page-checkbox:checked').each(function() {
                    var pageRow = $(this).closest('tr');
                    var page = $(this).val();
                    var actions = [];

                    pageRow.find('.action-checkbox:checked').each(function() {
                        actions.push($(this).val());
                    });

                    if (actions.length > 0) {
                        permissions.push({
                            page: page,
                            actions: actions.join(',') // Join actions with comma
                        });
                    }
                });

                $.ajax({
                    url: '<?= base_url("UsersController/save_permissions") ?>',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        ID: $('#PERMISSIONS_ID').val(),
                        permissions: JSON.stringify(permissions),
                        [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                    },
                    success: function(response) {
                        $('.txt_csrfname').val(response.token);
                        if (response.status) {
                            $('#permissionsModal').modal('hide');
                            Swal.fire({
                                title: "Success!",
                                text: "Permissions have been changed successfully.",
                                icon: "success",
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.reload();
                                }
                            });
                        } else {
                            alert('Error saving permissions!');
                        }
                    },
                    error: function() {
                        alert('Error saving permissions!');
                    }
                });
            });
        });
    </script>




    <!-- Modal -->
    <div class="modal fade" id="deleteModal" data-bs-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <form class="modal-content" action="<?= base_url("UsersController/deleteUsers"); ?>" method="POST">
                <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="ID" id="ID">
                <div class="modal-header">
                    <h4 class="modal-title" id="backDropModalTitle">Are you sure?</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    You won't be able to revert this!
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

            $("#btnDelete").click(function() {
                $("#ID").val($(this).data("id"));
            });
            $("#IMS_USERS_UNAME").on("keyup", function() {
                $("#IMS_USERS_PWORD").val($(this).val());
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