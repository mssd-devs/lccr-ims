<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">My Profile</a>
            </li>
            <!-- <li class="breadcrumb-item active">List</li> -->
        </ol>
    </nav>
    <div class="row">
        <!-- User Sidebar -->
        <div class="col-xl-12 col-lg-5 col-md-5 order-1 order-md-0">
            <!-- User Card -->
            <div class="card mb-6">
                <div class="card-body pt-12">
                    <div class="user-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                            <!-- src="../../" -->
                            <img class="img-fluid rounded mb-4" height="120" width="120"
                                src="<?= ($this->session->userdata("user_image") != "")  ? base_url("assets/img/" . $this->session->userdata("user_image")) : base_url("assets/img/avatars/10.png") ?>"
                                id="previewImage" alt="User avatar" />
                            <div class="user-info text-center">
                                <h5><?= $this->session->userdata('fullname'); ?></h5>
                                <span
                                    class="badge bg-label-info rounded-pill"><?= $this->session->userdata('usertype'); ?></span>
                            </div>


                            <form id="profileImageForm" action="<?= base_url("ProfileController/updateProfile") ?>"
                                method="post" enctype="multipart/form-data">
                                <!-- CSRF token -->
                                <input type="hidden" class="txt_csrfname"
                                    name="<?= $this->security->get_csrf_token_name(); ?>"
                                    value="<?= $this->security->get_csrf_hash(); ?>">
                                <div class="row">
                                    <div class="col-sm-10">
                                        <label class="col-form-label">Change Photo</label>
                                        <input type="file" id="uploadImage"
                                            accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                            class="form-control mb-2">
                                        <input type="hidden" name="IMS_USERS_IMAGE_BASE64" id="imageCropped">
                                        <input type="hidden" name="IMS_USERS_IMAGE_FILENAME" id="imageFilename">
                                        <button type="submit" class="btn btn-primary btn-xs">Save Changes</button>
                                        <div class="text-muted small mt-1">Recommended size: 200x200px</div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <h5 class="pb-4 border-bottom mb-4">Details</h5>
                    <div class="info-container">
                        <ul class="list-unstyled mb-6">
                            <li class="mb-2">
                                <span class="h6">Username:</span>
                                <span><?= $this->session->userdata("username"); ?></span>
                            </li>
                            <li class="mb-2">
                                <span class="h6">Status:</span>
                                <span class="badge bg-label-success rounded-pill">Active</span>
                            </li>
                            <li class="mb-2">
                                <span class="h6">Role:</span>
                                <span><?= $this->session->userdata('usertype'); ?></span>
                            </li>
                        </ul>
                        <div class="d-flex justify-content-center">
                            <button class="btn btn-outline-danger" data-bs-target="#changePasswordModal"
                                data-bs-toggle="modal">Change Password</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Change Password Modal -->
<div class="modal fade" id="changePasswordModal" data-bs-backdrop="static" tabindex="-1"
    aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="changePasswordForm" method="post">
                <!-- CSRF Token hidden input -->
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                    value="<?= $this->security->get_csrf_hash(); ?>" class="txt_csrfname" />

                <div class="modal-body">
                    <div class="mb-3">
                        <div class="input-group">
                            <input class="form-control" type="password" id="currentPassword" required
                                name="currentPassword" placeholder="Current Password" />
                            <span class="input-group-text cursor-pointer toggle-password" data-target="currentPassword">
                                <i class="ri-eye-off-line ri-20px"></i>
                            </span>
                        </div>
                        <div class="text-danger mt-1" id="passwordInvalid" style="display: none;">Incorrect current
                            password!</div>
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <input class="form-control" type="password" id="newPassword" required name="newPassword"
                                placeholder="New Password" />
                            <span class="input-group-text cursor-pointer toggle-password" data-target="newPassword">
                                <i class="ri-eye-off-line ri-20px"></i>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="input-group">
                            <input class="form-control" type="password" name="confirmPassword" required
                                id="confirmPassword" placeholder="Confirm New Password" />
                            <span class="input-group-text cursor-pointer toggle-password" data-target="confirmPassword">
                                <i class="ri-eye-off-line ri-20px"></i>
                            </span>
                        </div>
                        <div class="text-danger mt-1" id="passwordError" style="display: none;">Passwords do not match!
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Handle form submission
        $('#changePasswordForm').on('submit', function(e) {
            e.preventDefault();

            var newPassword = $('#newPassword').val();
            var confirmPassword = $('#confirmPassword').val();

            if (newPassword !== confirmPassword) {
                $('#passwordError').show();
                return;
            } else {
                $('#passwordError').hide();
            }

            var currentPassword = $("#currentPassword").val();

            $.ajax({
                url: "<?= base_url('ProfileController/changePassword') ?>",
                dataType: "json",
                type: "POST",
                data: {
                    currentPassword: currentPassword,
                    newPassword: newPassword,
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                },
                success: function(response) {
                    // Update CSRF token
                    $('.txt_csrfname').val(response.token);

                    if (response.status === "error") {
                        $('#passwordInvalid').show().text(response.message);
                    } else {
                        $('#passwordInvalid').hide();
                        $('#changePasswordModal').modal('hide');
                        $('#changePasswordForm')[0].reset();
                        Swal.fire({
                            title: "Success!",
                            text: response.message,
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
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        });

        // Real-time password match validation
        $('#confirmPassword, #newPassword').on('keyup', function() {
            var newPassword = $('#newPassword').val();
            var confirmPassword = $('#confirmPassword').val();

            if (newPassword !== confirmPassword) {
                $('#passwordError').show();
            } else {
                $('#passwordError').hide();
            }
        });

        // Toggle password visibility
        $('.toggle-password').on('click', function() {
            var targetId = $(this).attr('data-target');
            var input = $('#' + targetId);
            var icon = $(this).find('i');

            if (input.attr('type') === 'password') {
                input.attr('type', 'text');
                icon.removeClass('ri-eye-off-line').addClass('ri-eye-line');
            } else {
                input.attr('type', 'password');
                icon.removeClass('ri-eye-line').addClass('ri-eye-off-line');
            }
        });
    });
</script>


<!-- Crop Modal -->
<div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cropperModalLabel">
                    <i class="ri-crop-line me-2"></i>Crop Profile Image
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <small class="text-muted">Drag to move, use corners to resize the crop area</small>
                </div>
                <div class="crop-container" style="max-height: 400px; overflow: hidden;">
                    <img id="imageToCrop" src="" class="img-fluid" style="max-width: 100%; display: block;"
                        alt="Image to crop" />
                </div>
                <div class="mt-3">
                    <label for="zoomSlider" class="form-label">Zoom Level</label>
                    <input type="range" id="zoomSlider" class="form-range" min="0.5" max="3" step="0.01" value="1" />
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">0.5x</small>
                        <small class="text-muted">3x</small>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="ri-close-line me-1"></i>Cancel
                </button>
                <button type="button" id="cropImageBtn" class="btn btn-primary">
                    <i class="ri-crop-line me-1"></i>Crop & Use
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let cropper;
        let currentTarget = null;

        function openCropper(fileInputId, previewId, hiddenInputId) {
            const fileInput = document.getElementById(fileInputId);
            const file = fileInput.files[0];

            if (!file) {
                return;
            }

            // Validate file type
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
            if (!validTypes.includes(file.type.toLowerCase())) {
                Swal.fire({
                    title: 'Invalid File Type',
                    text: 'Please select a valid image file (JPEG, PNG, GIF, or WebP).',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                fileInput.value = '';
                return;
            }

            // Check file size (max 5MB)
            const maxSize = 5 * 1024 * 1024;
            if (file.size > maxSize) {
                Swal.fire({
                    title: 'File Too Large',
                    text: 'Please select an image smaller than 5MB.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                fileInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imageToCrop').attr('src', e.target.result);
                $('#cropperModal').modal('show');
                currentTarget = {
                    previewId: previewId,
                    hiddenInputId: hiddenInputId,
                    fileInputId: fileInputId,
                    originalFile: file
                };
            };
            reader.onerror = function() {
                Swal.fire({
                    title: 'Error Reading File',
                    text: 'Unable to read the selected file. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            };
            reader.readAsDataURL(file);
        }

        $('#uploadImage').on('change', function() {
            openCropper('uploadImage', 'previewImage', 'imageCropped');
        });

        $('#cropperModal').on('shown.bs.modal', function() {
            try {
                const imageElement = document.getElementById('imageToCrop');

                cropper = new Cropper(imageElement, {
                    aspectRatio: 1,
                    viewMode: 1,
                    dragMode: 'move',
                    autoCropArea: 0.8,
                    restore: false,
                    guides: true,
                    center: true,
                    highlight: false,
                    cropBoxMovable: true,
                    cropBoxResizable: true,
                    ready() {
                        $('#zoomSlider').val(1);
                    }
                });

                $('#zoomSlider').off('input').on('input', function() {
                    const zoomValue = parseFloat(this.value);
                    if (cropper) {
                        cropper.zoomTo(zoomValue);
                    }
                });
            } catch (error) {
                console.error('Error initializing cropper:', error);
                Swal.fire({
                    title: 'Cropper Error',
                    text: 'Unable to initialize image cropper. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                $('#cropperModal').modal('hide');
            }
        }).on('hidden.bs.modal', function() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
            $('#zoomSlider').val(1);
        });

        $('#cropImageBtn').on('click', function() {
            if (!cropper) {
                Swal.fire({
                    title: 'Error',
                    text: 'Cropper is not initialized. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return;
            }

            try {
                const canvas = cropper.getCroppedCanvas({
                    width: 200,
                    height: 200,
                    imageSmoothingEnabled: true,
                    imageSmoothingQuality: 'high'
                });

                if (!canvas) {
                    throw new Error('Failed to create canvas');
                }

                // Generate high-quality base64 image
                canvas.toBlob(function(blob) {
                    const reader = new FileReader();
                    reader.onload = function() {
                        const base64Data = reader.result;

                        // Extract only the base64 string (remove data:image/png;base64, prefix)
                        const base64String = base64Data.split(',')[1];
                        const mimeType = base64Data.split(',')[0].split(':')[1].split(';')[0];

                        // Generate filename
                        const timestamp = new Date().getTime();
                        const extension = mimeType.split('/')[1];
                        const filename = `profile_${timestamp}.${extension}`;

                        // Update preview and hidden fields
                        $(`#${currentTarget.previewId}`).attr('src', base64Data).show();
                        $(`#${currentTarget.hiddenInputId}`).val(base64String);
                        $('#imageFilename').val(filename);


                        $('#cropperModal').modal('hide');
                    };
                    reader.readAsDataURL(blob);
                }, 'image/png', 0.9);

            } catch (error) {
                console.error('Error cropping image:', error);
                Swal.fire({
                    title: 'Crop Error',
                    text: 'Unable to crop the image. Please try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }
        });

        // Profile image form AJAX submission
        $('#profileImageForm').on('submit', function(e) {
            e.preventDefault();

            // Check if image is selected and cropped
            if (!$('#imageCropped').val()) {
                Swal.fire({
                    title: 'No Image Selected',
                    text: 'Please select and crop an image before saving.',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                });
                return;
            }

            // Show loading state
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.text();
            submitBtn.prop('disabled', true).html('<i class="ri-loader-4-line me-1"></i>Saving...');

            // Submit form via AJAX
            const formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function(response) {
                    // Update CSRF token
                    if (response.token) {
                        $('.txt_csrfname').val(response.token);
                    }

                    if (response.output) {
                        // Update navbar avatar if image_url is provided
                        if (response.image_url) {
                            $('.navbar .avatar img, .layout-menu .avatar img').attr('src',
                                response.image_url);
                        }

                        Swal.fire({
                            title: 'Success!',
                            text: response.message ||
                                'Profile image updated successfully!',
                            icon: 'success',
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            // Reset form
                            $('#uploadImage').val('');
                            $('#imageCropped').val('');
                            $('#imageFilename').val('');
                        });
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: response.message || 'Failed to update profile image.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    let errorMessage = 'An error occurred while updating profile image.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    }

                    Swal.fire({
                        title: 'Error!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                },
                complete: function() {
                    // Restore button state
                    submitBtn.prop('disabled', false).text(originalText);
                }
            });
        });
    });
</script>