<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Employee Profile</a>
            </li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </nav>

    <?php
    $permission = [];

    $permission = [];
    $is_admin = in_array(strtolower(trim($this->session->userdata("usertype") ?? '')), ["administrator", "superadmin", "super admin", "admin"]);

    if ($is_admin) {
        // Admin has full access
        $permission = ['View', 'Edit', 'Delete', 'Create'];
    } else {
        // Normal user permissions from RBAC
        if ($rbac->num_rows() > 0) {
            foreach ($rbac->result() as $rbac_row) {
                $actions = array_map('trim', explode(',', $rbac_row->ACTIONS));
                $permission = array_merge($permission, $actions);
            }
        }
    }
    ?>

    <!-- Filter Card -->
    <div class="row gy-4 mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="ri-filter-3-line me-1"></i> Filter Employees</h5>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="btn_reset_filter">
                            <i class="ri-refresh-line me-1"></i> Reset Filters
                        </button>
                    </div>
                </div>
                <div class="card-body pt-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-3">
                                <select class="form-select select2" id="FILTER_EMPLOYEETYPE">
                                    <option value="">ALL</option>
                                    <option value="TEACHING">TEACHING</option>
                                    <option value="NON-TEACHING">NON-TEACHING</option>
                                </select>
                                <label for="FILTER_EMPLOYEETYPE">Employee Type</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-3">
                                <select class="form-select select2" id="FILTER_TENURE">
                                    <option value="">ALL</option>
                                    <?php
                                    if (isset($LoadTenure) && $LoadTenure->num_rows() > 0) {
                                        foreach ($LoadTenure->result() as $t) {
                                            echo '<option value="' . htmlspecialchars($t->IMS_TENURE) . '">' . htmlspecialchars($t->IMS_TENURE) . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                                <label for="FILTER_TENURE">Tenure of Employment</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">List of Employee Profile</h5>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-primary" id="btnCopyRegistrationLink" data-url="<?= base_url('employee/register'); ?>">
                                <i class="ri-links-line me-1"></i> Registration Link
                            </button>
                            <?php if (in_array("Create", $permission) || $this->session->userdata("usertype") == "Superadmin"): ?>
                                <a class="btn btn-primary" href="<?= base_url('ims/facultyprof/create'); ?>">
                                    <i class="ri-add-circle-line me-1"></i> Add Employee Profile
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="table-responsive pt-0">
                        <!-- CSRF token -->
                        <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>">
                        <table id="dataTable" class="table table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Employee I.D</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Employee Type</th>
                                    <th>Rank/Position</th>
                                    <th>Tenure of Employment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($LoadFacultyProfile->num_rows() > 0): ?>
                                    <?php foreach ($LoadFacultyProfile->result() as $r): ?>
                                        <tr>
                                            <td><?= $r->FP_FACID; ?></td>
                                            <td>
                                                <?php if ($r->FP_SUFFIX === ""): ?>
                                                    <?= $r->FP_LASTNAME . ', ' . $r->FP_FIRSTNAME . ' ' . $r->FP_MIDDLENAME; ?>
                                                <?php else: ?>
                                                    <?= $r->FP_LASTNAME . ' ' . $r->FP_SUFFIX . ', ' . $r->FP_FIRSTNAME . ' ' . $r->FP_MIDDLENAME; ?>
                                                <?php endif; ?>
                                            </td>
                                            <td><?= $r->FP_GENDER; ?></td>
                                            <td><?= $r->FP_EMPLOYEETYPE; ?></td>
                                            <td><?= $r->FP_FACRANK; ?></td>
                                            <td><?= $r->FP_TENURE; ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                        data-bs-toggle="dropdown">
                                                        <i class="ri-more-2-fill"></i>
                                                    </button>
                                                    <div class="dropdown-menu">
                                                        <?php if (in_array("View", $permission) || $this->session->userdata("usertype") == "Superadmin"): ?>
                                                            <a class="dropdown-item"
                                                                href="<?= base_url("ims/facultyprof/view/" . $r->FP_TRANSID); ?>">
                                                                <i class="ri-eye-line me-1"></i> View
                                                            </a>
                                                        <?php endif; ?>
                                                        <?php if (in_array("Edit", $permission)): ?>
                                                            <a class="dropdown-item"
                                                                href="<?= base_url("ims/facultyprof/edit/" . $r->FP_TRANSID); ?>">
                                                                <i class="ri-edit-line me-1"></i> Edit
                                                            </a>
                                                        <?php endif; ?>

                                                        <?php if (in_array("Delete", $permission)): ?>
                                                            <a class="dropdown-item btnDelete" href="javascript:void(0);"
                                                                data-id="<?= $r->ID; ?>" data-bs-toggle="modal"
                                                                data-bs-target="#deleteModal">
                                                                <i class="ri-delete-bin-line me-1"></i> Delete
                                                            </a>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No faculty records found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function getTableInstance() {
            if ($.fn.dataTable.isDataTable('#dataTable')) {
                return $('#dataTable').DataTable();
            } else {
                return $('#dataTable').DataTable({
                    retrieve: true
                });
            }
        }

        // Filter by Employee Type (Column 3)
        $('#FILTER_EMPLOYEETYPE').on('change', function() {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            getTableInstance().column(3).search(val ? '^' + val + '$' : '', true, false).draw();
        });

        // Filter by Tenure of Employment (Column 5)
        $('#FILTER_TENURE').on('change', function() {
            var val = $.fn.dataTable.util.escapeRegex($(this).val());
            getTableInstance().column(5).search(val ? '^' + val + '$' : '', true, false).draw();
        });

        // Reset filters
        $('#btn_reset_filter').on('click', function() {
            $('#FILTER_EMPLOYEETYPE').val('');
            $('#FILTER_TENURE').val('');
            var table = getTableInstance();
            table.column(3).search('');
            table.column(5).search('');
            table.draw();
        });

        // Copy Registration Link
        $('#btnCopyRegistrationLink').on('click', function() {
            var regUrl = $(this).data('url');
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(regUrl).then(showSuccessAlert).catch(fallbackCopy);
            } else {
                fallbackCopy();
            }

            function fallbackCopy() {
                var tempInput = $('<input>');
                $('body').append(tempInput);
                tempInput.val(regUrl).select();
                document.execCommand('copy');
                tempInput.remove();
                showSuccessAlert();
            }

            function showSuccessAlert() {
                Swal.fire({
                    title: 'Registration Link Copied!',
                    html: 'Shareable registration link:<br><code class="fs-6">' + regUrl + '</code>',
                    icon: 'success',
                    confirmButtonText: 'OK',
                    customClass: {
                        confirmButton: 'btn btn-primary'
                    },
                    buttonsStyling: false
                });
            }
        });

        $(document).on("click", ".btnDelete", function() {
            var id = $(this).data("id");
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Delete',
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false,
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "<?= base_url('FacultyprofController/deleteFP'); ?>",
                        type: "POST",
                        data: {
                            ID: id,
                            [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                        },
                        success: function(data) {
                            $('.txt_csrfname').val(data.token);
                            if (data.output) {
                                Swal.fire(
                                    'Deleted!',
                                    'The faculty profile has been deleted.',
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'There was an error deleting the faculty profile.',
                                    'error'
                                );
                            }
                        }
                    });
                }
            });
        });
    });
</script>

<script>
    $(document).on('input', '[type="text"], textarea', function() {
        var inputText = $(this).val();
        var uppercaseText = inputText.toUpperCase();
        var textWithoutDoubleSpaces = uppercaseText.replace(/  +/g, ' ');
        $(this).val(textWithoutDoubleSpaces);
    });
</script>