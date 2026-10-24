<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Alumni Tracker</a>
            </li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4>List of Alumni</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addAlumniModal">
                            <i class="ri-add-line"></i> Add Alumni
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table id="dataTable" class="table table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Program/Courses</th>
                                    <th>Achievement</th>
                                    <th>Job/Position</th>
                                    <th>Office</th>
                                    <th>Image</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="alumniTableBody">
                                <?php foreach ($alumni as $a): ?>
                                    <tr data-id="<?= $a->ID ?>">
                                        <td><?= htmlspecialchars($a->FULLNAME) ?></td>
                                        <td><?= htmlspecialchars($a->PROGRAM_COURSES) ?></td>
                                        <td><?= htmlspecialchars($a->ACHIEVEMENT) ?></td>
                                        <td><?= htmlspecialchars($a->JOB_POSITION) ?></td>
                                        <td><?= htmlspecialchars($a->OFFICE) ?></td>
                                        <td>
                                            <?php if (!empty($a->IMAGE)): ?>
                                                <img src="<?= base_url('uploads/alumni/' . $a->IMAGE) ?>"
                                                    style="max-width:60px;max-height:60px;border-radius:4px;">
                                            <?php else: ?>
                                                <span class="text-muted">No Image</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-outline-primary edit-btn"
                                                data-id="<?= $a->ID ?>">Edit</button>
                                            <button type="button" class="btn btn-sm btn-outline-danger delete-btn"
                                                data-id="<?= $a->ID ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Alumni Modal -->
<div class="modal fade" id="addAlumniModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Alumni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addAlumniForm" enctype="multipart/form-data" method="post">
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>"
                    value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="FULLNAME" id="add_FULLNAME" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Program/Courses</label>
                        <input type="text" class="form-control" name="PROGRAM_COURSES" id="add_PROGRAM_COURSES" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Achievement</label>
                        <textarea class="form-control" name="ACHIEVEMENT" id="add_ACHIEVEMENT" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Job/Position</label>
                        <input type="text" class="form-control" name="JOB_POSITION" id="add_JOB_POSITION">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Office</label>
                        <input type="text" class="form-control" name="OFFICE" id="add_OFFICE">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Upload Image</label>
                        <input type="file" class="form-control" name="IMAGE" id="add_IMAGE" accept="image/*">
                        <div class="form-text">Only image files allowed. Max size: 20 MB.</div>
                        <div id="add_image_preview" class="mt-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Alumni</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Alumni Modal -->
<div class="modal fade" id="editAlumniModal" data-bs-backdrop="static" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Alumni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editAlumniForm" enctype="multipart/form-data" method="post">
                <input type="hidden" name="ID" id="edit_ID">
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>"
                    value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="FULLNAME" id="edit_FULLNAME" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Program/Courses</label>
                        <input type="text" class="form-control" name="PROGRAM_COURSES" id="edit_PROGRAM_COURSES"
                            required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Achievement</label>
                        <textarea class="form-control" name="ACHIEVEMENT" id="edit_ACHIEVEMENT" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Job/Position</label>
                        <input type="text" class="form-control" name="JOB_POSITION" id="edit_JOB_POSITION">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Office</label>
                        <input type="text" class="form-control" name="OFFICE" id="edit_OFFICE">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Change Image</label>
                        <input type="file" class="form-control" name="IMAGE" id="edit_IMAGE" accept="image/*">
                        <div class="form-text">Only image files allowed. Max size: 20 MB.</div>
                        <div id="edit_image_view" class="mt-2"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Alumni</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Cropper Modal -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop Image</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img id="cropperImage" src="#" style="max-width:100%; max-height:500px; display: block;">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="cropImageBtn">Crop & Use Image</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // DataTable initialization
        window.alumniTable = $('#dataTable').DataTable({
            dom: '<"d-flex justify-content-between align-items-center"<"export-dropdown"B><"search-box"f>>rtip',
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
            responsive: true,
            autoWidth: true,
            pageLength: 10,
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

        // Cropper.js variables
        let cropper = null;
        let currentInput = null;
        let previewTarget = null;

        function openCropper(input, preview) {
            const file = input.files[0];
            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#cropperImage').attr('src', e.target.result);
                    $('#cropperModal').modal('show');
                };
                reader.readAsDataURL(file);
                currentInput = input;
                previewTarget = preview;
            }
        }

        $('#add_IMAGE').on('change', function() {
            openCropper(this, $('#add_image_preview'));
        });
        $('#edit_IMAGE').on('change', function() {
            openCropper(this, $('#edit_image_view'));
        });

        $('#cropperModal').on('shown.bs.modal', function() {
            cropper = new Cropper(document.getElementById('cropperImage'), {
                aspectRatio: 1,
                viewMode: 1,
                autoCropArea: 1
            });
        }).on('hidden.bs.modal', function() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        });

        $('#cropImageBtn').on('click', function() {
            if (cropper && currentInput) {
                cropper.getCroppedCanvas({
                    width: 400,
                    height: 400
                }).toBlob(function(blob) {
                    const dt = new DataTransfer();
                    const fileName = 'cropped_' + Date.now() + '.png';
                    dt.items.add(new File([blob], fileName, {
                        type: 'image/png'
                    }));
                    currentInput.files = dt.files;

                    // Show preview
                    const url = URL.createObjectURL(blob);
                    if (previewTarget) {
                        previewTarget.html('<img src="' + url + '" style="max-width:100px;max-height:100px;border-radius:4px;">');
                    }
                    $('#cropperModal').modal('hide');
                }, 'image/png');
            }
        });

        // AJAX Add Alumni
        $('#addAlumniForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: '<?= base_url('ims/alumni-tracker/save') ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        $('#addAlumniModal').modal('hide');
                        $('#addAlumniForm')[0].reset();
                        $('#add_image_preview').empty();
                        reloadAlumniTable();
                        Swal.fire('Success', 'Alumni added successfully!', 'success');
                    } else {
                        Swal.fire('Error', res.message || 'Failed to add alumni.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Failed to add alumni.', 'error');
                }
            });
        });

        // AJAX Edit Alumni
        $('#editAlumniForm').on('submit', function(e) {
            e.preventDefault();
            var id = $('#edit_ID').val();
            var formData = new FormData(this);
            $.ajax({
                url: '<?= base_url('ims/alumni-tracker/update/') ?>' + id,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(res) {
                    if (res.status === 'success') {
                        $('#editAlumniModal').modal('hide');
                        reloadAlumniTable();
                        Swal.fire('Success', 'Alumni updated successfully!', 'success');
                    } else {
                        Swal.fire('Error', res.message || 'Failed to update alumni.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Failed to update alumni.', 'error');
                }
            });
        });

        // Edit modal logic
        $(document).on('click', '.edit-btn', function() {
            var id = $(this).data('id');
            $.get('<?= base_url('ims/alumni-tracker/get/') ?>' + id, function(data) {
                var alumni = JSON.parse(data);
                $('#edit_ID').val(alumni.ID);
                $('#edit_FULLNAME').val(alumni.FULLNAME);
                $('#edit_PROGRAM_COURSES').val(alumni.PROGRAM_COURSES);
                $('#edit_ACHIEVEMENT').val(alumni.ACHIEVEMENT);
                $('#edit_JOB_POSITION').val(alumni.JOB_POSITION);
                $('#edit_OFFICE').val(alumni.OFFICE);
                if (alumni.IMAGE) {
                    $('#edit_image_view').html('<img src="<?= base_url('uploads/alumni/') ?>' + alumni.IMAGE + '" style="max-width:100px;max-height:100px;border-radius:4px;">');
                } else {
                    $('#edit_image_view').html('<span class="text-muted">No Image</span>');
                }
                $('#editAlumniModal').modal('show');
            });
        });

        // AJAX Delete Alumni
        $(document).on('click', '.delete-btn', function() {
            var id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?= base_url('ims/alumni-tracker/delete/') ?>' + id,
                        type: 'POST',
                        dataType: 'json',
                        success: function(res) {
                            if (res.status === 'success') {
                                reloadAlumniTable();
                                Swal.fire('Deleted!', 'Alumni has been deleted.', 'success');
                            } else {
                                Swal.fire('Error', res.message || 'Failed to delete alumni.', 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error', 'Failed to delete alumni.', 'error');
                        }
                    });
                }
            });
        });

        function reloadAlumniTable() {
            $.get('<?= base_url('ims/alumni-tracker/ajax-list') ?>', function(html) {
                window.alumniTable.clear().destroy();
                $('#alumniTableBody').html(html);
                window.alumniTable = $('#dataTable').DataTable({
                    dom: '<"d-flex justify-content-between align-items-center"<"export-dropdown"B><"search-box"f>>rtip',
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
                    responsive: true,
                    autoWidth: true,
                    pageLength: 10,
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
            });
        }
    });
</script>