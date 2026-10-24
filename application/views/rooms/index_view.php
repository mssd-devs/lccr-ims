<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Data Entry</a>
            </li>
            <li class="breadcrumb-item active">Rooms</li>
        </ol>
    </nav>

    <div class="row gy-4 mb-4">
        <div class="col-md-12">
            <div class="card">
                <form action="<?= base_url("RoomsController/SaveRooms") ?>" method="post">
                    <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                    <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                    <div class="card-body">
                        <h5 class="card-title">Create Rooms</h5>
                        <p>Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required.</p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="R_RMDEPT" id="" aria-label="Default select example">
                                        <option selected="">--Select Department--</option>
                                        <?php
                                        foreach ($LoadDepartment->result() as $r) {
                                        ?>
                                            <option><?= $r->D_DEPTDESCRIPTION; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <label for="basic-default-fullname">Deaprtment<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="basic-default-fullname" name="R_RMDESCRIPTION" placeholder="Enter Room Name" required />
                                    <label for="basic-default-fullname">Room Name<span class="text-danger">*</span></label>
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
                        <h5 class="card-title">List of Rooms</h5>
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Department</th>
                                        <th>Rooms Code</th>
                                        <th>Rooms Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($LoadRooms->result() as $r) {
                                    ?>
                                        <tr>
                                            <td><?= $i++; ?></td>
                                            <td><?= $r->R_RMDEPT; ?></td>
                                            <td><?= $r->R_RMCODE; ?></td>
                                            <td><?= $r->R_RMDESCRIPTION; ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                        <i class="ri-more-2-fill"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="<?= base_url("ims/entries/rooms/edit/" . $r->ID); ?>"><i class="ri-edit-line me-1"></i> Edit</a>
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
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content" action="<?= base_url("RoomsController/DeleteRooms"); ?>" method="POST">
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

<!-- / Content -->
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