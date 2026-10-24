<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Student Profile</a>
            </li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </nav>

    <?php
    $permission = [];
    $is_admin = in_array(strtolower(trim($this->session->userdata("usertype") ?? '')), ["administrator", "superadmin", "super admin", "admin"]);
    if ($rbac->num_rows() > 0 || $is_admin) {
        foreach ($rbac->result() as $rows) {
            $actions = explode(',', $rows->ACTIONS);
            $permission = array_merge($permission, array_map('trim', $actions));
        }

        // Check if 'Create' exists in the permission list, or if user is admin
        if (in_array("Create", $permission) || $is_admin) {

    ?>
            <div class="row gy-4 mb-4">
                <div class="col-md-12">
                    <div class="card">
                        <form class="needs-validation" novalidate id="studentProfileForm">
                            <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>">
                            <div class="card-body">
                                <h5 class="card-title">New Student Profile</h5>
                                <div class="row">
                                    <div class="col-md-3">
                                        <label for="NEW_FNAME">First Name</label> <span class="text-danger">*</span>
                                        <input type="text" name="NEW_FNAME" class="form-control" id="NEW_FNAME" required>
                                        <div class="invalid-feedback">First Name is required.</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="NEW_MNAME">Middle Name</label> <span>(Optional)</span>
                                        <input type="text" name="NEW_MNAME" class="form-control" id="NEW_MNAME">
                                    </div>
                                    <div class="col-md-3">
                                        <label for="NEW_LNAME">Last Name</label> <span class="text-danger">*</span>
                                        <input type="text" name="NEW_LNAME" class="form-control" id="NEW_LNAME" required>
                                        <div class="invalid-feedback">Last Name is required.</div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="NEW_DATE">Date of Birth</label> <span class="text-danger">*</span>
                                        <input type="date" name="NEW_DATE" class="form-control" id="NEW_DATE"
                                            max="<?= date('Y-m-d'); ?>" required>
                                        <div class="invalid-feedback">Date of Birth is required.</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success btn-lg btnSave" id="button-addon2">
                                    <i class="ri-save-line"></i> Save
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    <?php
        }
    }
    ?>




    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0">List of Student Profile</h5>
                        <div>
                            <button type="button" id="btnGenerateSelected" class="btn btn-secondary me-2">
                                <i class="ri-checkbox-multiple-line"></i> Generate Selected
                            </button>
                        </div>
                    </div>
                    <div class="table-responsive pt-0">
                        <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>">
                        <table class="table table-bordered" id="fixedColumnDataTable">
                            <thead>
                                <tr>
                                    <th style="width: 40px; text-align: center;"><input type="checkbox" class="form-check-input" id="selectAllCheckbox"></th>
                                    <th class="d-none">ID</th>
                                    <th>Student I.D</th>
                                    <th>Name</th>
                                    <th>Gender</th>
                                    <th>Contact #</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbl_body">

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
        LoadStudentProfile();

        function LoadStudentProfile() {

            $.ajax({
                url: "<?= base_url("StudentProfileController/LoadStudentProfile"); ?>",
                method: "POST",
                dataType: 'json',
                data: {
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                },
                success: function(result) {
                    // Update CSRF hash
                    $('.txt_csrfname').val(result.token);
                    // Destroy datatable
                    $("#fixedColumnDataTable").DataTable().clear().destroy();
                    // Load data into table body
                    $("#tbl_body").html(result.output);
                    // Reload DataTable
                    initializeDataTable();
                },
                error: function(jqXHR, errorType, error) {
                    alert(error);
                }
            });
        }

        function initializeDataTable() {
            $('#fixedColumnDataTable').DataTable({
                dom: '<"d-flex justify-content-between align-items-center"<"export-dropdown"B><"search-box"f>>rtip', // Custom layout
                buttons: [{
                    extend: 'collection',
                    text: '<i class="ri-download-2-line"></i> Export Data',
                    buttons: [{
                            extend: 'copy',
                            text: 'Copy to Clipboard'
                        },
                        {
                            extend: 'csv',
                            text: 'Export as CSV'
                        },
                        {
                            extend: 'excel',
                            text: 'Export as Excel'
                        },
                        {
                            extend: 'pdf',
                            text: 'Export as PDF'
                        },
                        {
                            extend: 'print',
                            text: 'Print Table'
                        }
                    ]
                }],
                responsive: false,
                autoWidth: true,
                order: [0, 'desc'],
                fixedColumns: {
                    left: 1, // Freezes first column
                    right: 1 // Freezes last column
                },
                pageLength: 5,
                lengthMenu: [5, 10, 25, 50, 75, 100],
                language: {
                    search: "Search:",
                    lengthMenu: "Display _MENU_ records per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });
        }

        $("#studentProfileForm").on("submit", function(event) {
            event.preventDefault();
            var form = $(this);
            if (form[0].checkValidity() === false) {
                event.stopPropagation();
            } else {
                var NEW_FNAME = $("#NEW_FNAME").val();
                var NEW_MNAME = $("#NEW_MNAME").val();
                var NEW_LNAME = $("#NEW_LNAME").val();
                var NEW_DATE = $("#NEW_DATE").val();
                $.ajax({
                    url: "<?= base_url('StudentProfileController/checkNewEntry'); ?>",
                    type: "POST",
                    dataType: "json",
                    data: {
                        NEW_FNAME: NEW_FNAME,
                        NEW_MNAME: NEW_MNAME,
                        NEW_LNAME: NEW_LNAME,
                        NEW_DATE: NEW_DATE,
                        [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                    },
                    success: function(data) {
                        // Update CSRF hash
                        $('.txt_csrfname').val(data.token);
                        if (data.output === "not exist") {
                            Swal.fire({
                                title: 'Proceed?',
                                text: "The student profile does not exist. Do you want to proceed?",
                                icon: 'warning',
                                showCancelButton: false,
                                customClass: {
                                    confirmButton: 'btn btn-primary',
                                    cancelButton: 'btn btn-secondary'
                                },
                                buttonsStyling: false,
                                confirmButtonText: 'Proceed'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href =
                                        "<?= base_url('ims/studentprofile/create'); ?>";
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: 'Student profile already exists.',
                                icon: 'error',
                                customClass: {
                                    confirmButton: 'btn btn-primary'
                                },
                                buttonsStyling: false,
                                confirmButtonText: 'OK'
                            });
                        }

                    }
                });
            }
            form.addClass('was-validated');
        });

        // Select All Checkbox Logic (cross-page)
        $('#selectAllCheckbox').on('click', function(){
            var table = $("#fixedColumnDataTable").DataTable();
            var rows = table.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"].row-checkbox', rows).prop('checked', this.checked);
        });

        $('#fixedColumnDataTable tbody').on('change', 'input[type="checkbox"].row-checkbox', function(){
            if(!this.checked){
                var el = $('#selectAllCheckbox').get(0);
                if(el && el.checked && ('indeterminate' in el)){
                    el.indeterminate = true;
                }
            }
        });

        // Generate Selected Button Logic
        $("#btnGenerateSelected").on("click", function() {
            var selectedIds = [];
            var table = $("#fixedColumnDataTable").DataTable();
            var rows = table.rows().nodes();
            
            $('input[type="checkbox"].row-checkbox:checked', rows).each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire({
                    title: 'No students selected',
                    text: 'Please select at least one student from the table.',
                    icon: 'warning',
                    customClass: { confirmButton: 'btn btn-primary' },
                    buttonsStyling: false
                });
                return;
            }

            var btn = $(this);
            var originalText = btn.html();
            btn.html('<i class="ri-loader-4-line ri-spin"></i> Checking...').prop('disabled', true);

            $.ajax({
                url: "<?= base_url('ims/studentprofile/count_selected_eligible'); ?>",
                type: "POST",
                dataType: "json",
                data: {
                    student_ids: selectedIds,
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                },
                success: function(data) {
                    if (data.output.token) {
                        $('.txt_csrfname').val(data.output.token);
                    }
                    btn.html(originalText).prop('disabled', false);

                    var total = data.output.total;
                    var eligible = data.output.eligible;
                    var exist = data.output.exist;

                    if (eligible > 0) {
                        Swal.fire({
                            title: 'Generate Passwords?',
                            html: `You have selected <b>${total}</b> student(s).<br>` +
                                  `<b>${eligible}</b> will have a password generated.<br>` +
                                  `<b>${exist}</b> already have passwords (or are not enrolled).<br><br>` +
                                  `Proceed with generation?`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonText: 'Yes, generate',
                            cancelButtonText: 'Cancel',
                            customClass: {
                                confirmButton: 'btn btn-primary me-2',
                                cancelButton: 'btn btn-secondary'
                            },
                            buttonsStyling: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                var form = $('<form>', {
                                    'method': 'POST',
                                    'action': '<?= base_url('ims/studentprofile/generate_selected_accounts'); ?>',
                                    'target': '_blank'
                                });
                                
                                form.append($('<input>', {
                                    'type': 'hidden',
                                    'name': '<?= $this->security->get_csrf_token_name(); ?>',
                                    'value': $('.txt_csrfname').val()
                                }));

                                $.each(selectedIds, function(i, id) {
                                    form.append($('<input>', {
                                        'type': 'hidden',
                                        'name': 'student_ids[]',
                                        'value': id
                                    }));
                                });

                                $('body').append(form);
                                form.submit();
                                form.remove();
                            }
                        });
                    } else {
                        Swal.fire({
                            title: 'No Eligible Students',
                            html: `Out of <b>${total}</b> selected student(s), <b>${exist}</b> already have passwords (or are not enrolled).<br>There are no passwords to generate.`,
                            icon: 'info',
                            customClass: { confirmButton: 'btn btn-primary' },
                            buttonsStyling: false
                        });
                    }
                },
                error: function() {
                    btn.html(originalText).prop('disabled', false);
                    Swal.fire({
                        title: 'Error',
                        text: 'An error occurred while checking eligible students.',
                        icon: 'error',
                        customClass: { confirmButton: 'btn btn-primary' },
                        buttonsStyling: false
                    });
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
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
                        url: "<?= base_url('StudentProfileController/deleteSP'); ?>",
                        type: "POST",
                        data: {
                            ID: id,
                            [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                        },
                        success: function(data) {
                            // Update CSRF hash
                            $('.txt_csrfname').val(data.token);
                            if (data.output) {
                                Swal.fire({
                                    title: "Success!",
                                    text: "Data has been deleted!",
                                    icon: "success",
                                    customClass: {
                                        confirmButton: 'btn btn-primary waves-effect waves-light'
                                    },
                                    buttonsStyling: false
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'There was an error deleting the student profile.',
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