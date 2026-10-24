<div class="container-xxl flex-grow-1 container-p-y">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Web Settings</a>
            </li>
            <!-- <li class="breadcrumb-item active">Data Entry</li> -->
        </ol>
    </nav>

    <div class="row gy-4">

        <!-- Basic Layout -->
        <div class="col-xxl">
            <div class="card mb-6">
                <div class="card-header px-0 pt-0">
                    <div class="nav-align-top">
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-top-home" aria-controls="navs-top-home" aria-selected="true">
                                    Institution Info
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link " role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-top-profile" aria-controls="navs-top-profile"
                                    aria-selected="false">
                                    Signatories
                                </button>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content p-0">
                        <div class="tab-pane fade show active" id="navs-top-home" role="tabpanel">
                            <?php
                            foreach ($LoadWebSettings as $row) {
                                // Output the form fields with the current setting values
                            ?>
                                <form id="institutionForm" action="<?= base_url("WebSettingsController/updatesettings") ?>"
                                    method="post" enctype="multipart/form-data">
                                    <!-- CSRF token -->
                                    <input type="hidden" class="txt_csrfname"
                                        name="<?= $this->security->get_csrf_token_name(); ?>"
                                        value="<?= $this->security->get_csrf_hash(); ?>">
                                    <div class="row mb-4">
                                        <label class="col-sm-2 col-form-label" for="basic-default-name">Name of
                                            School</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="IMS_WEB_NOS" value="<?= $row["IMS_WEB_NOS"] ?>"
                                                class="form-control" id="basic-default-name"
                                                placeholder="Enter the name of school" />
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-sm-2 col-form-label" for="basic-default-company">School
                                            Abbreviation</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="IMS_WEB_ACRO" value="<?= $row["IMS_WEB_ACRO"] ?>"
                                                class="form-control" id="basic-default-company" placeholder="ACME Inc." />
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-sm-2 col-form-label">School Logo</label>
                                        <div class="col-sm-10">
                                            <input type="file" id="uploadLogoSchool"
                                                accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                                class="form-control mb-2">
                                            <input type="hidden" name="IMS_WEB_LOGO_BASE64" id="logoSchoolCropped">
                                            <input type="hidden" name="IMS_WEB_LOGO_FILENAME" id="logoSchoolFilename">
                                            <input type="hidden" name="IMS_WEB_LOGO_CURRENT"
                                                value="<?= $row["IMS_WEB_LOGO"] ?>">
                                            <div class="mt-2">
                                                <img id="previewLogoSchool"
                                                    src="<?= base_url('assets/img/' . $row["IMS_WEB_LOGO"]) ?>"
                                                    class="img-thumbnail"
                                                    style="max-width: 150px; display:<?= empty($row["IMS_WEB_LOGO"]) ? 'none' : 'block' ?>;">
                                                <div class="text-muted small mt-1">Recommended size: 200x200px</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-sm-2 col-form-label">Paper Logo Left</label>
                                        <div class="col-sm-10">
                                            <input type="file" id="uploadLogoLeft"
                                                accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                                class="form-control mb-2">
                                            <input type="hidden" name="IMS_WEB_IMG_BASE64" id="logoLeftCropped">
                                            <input type="hidden" name="IMS_WEB_IMG_FILENAME" id="logoLeftFilename">
                                            <input type="hidden" name="IMS_WEB_IMG_CURRENT"
                                                value="<?= $row["IMS_WEB_IMG"] ?>">
                                            <div class="mt-2">
                                                <img id="previewLogoLeft"
                                                    src="<?= base_url('assets/img/' . $row["IMS_WEB_IMG"]) ?>"
                                                    class="img-thumbnail"
                                                    style="max-width: 150px; display:<?= empty($row["IMS_WEB_IMG"]) ? 'none' : 'block' ?>;">
                                                <div class="text-muted small mt-1">Recommended size: 200x200px</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-4">
                                        <label class="col-sm-2 col-form-label">Paper Logo Right</label>
                                        <div class="col-sm-10">
                                            <input type="file" id="uploadLogoRight"
                                                accept="image/jpeg,image/jpg,image/png,image/gif,image/webp"
                                                class="form-control mb-2">
                                            <input type="hidden" name="IMS_WEB_IMG2_BASE64" id="logoRightCropped">
                                            <input type="hidden" name="IMS_WEB_IMG2_FILENAME" id="logoRightFilename">
                                            <input type="hidden" name="IMS_WEB_IMG2_CURRENT"
                                                value="<?= $row["IMS_WEB_IMG2"] ?>">
                                            <div class="mt-2">
                                                <img id="previewLogoRight"
                                                    src="<?= base_url('assets/img/' . $row["IMS_WEB_IMG2"]) ?>"
                                                    class="img-thumbnail"
                                                    style="max-width: 150px; display:<?= empty($row["IMS_WEB_IMG2"]) ? 'none' : 'block' ?>;">
                                                <div class="text-muted small mt-1">Recommended size: 200x200px</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-sm-2 col-form-label" for="basic-default-company">Complete
                                            Address</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?= $row["IMS_WEB_ADDRESS"] ?>"
                                                name="IMS_WEB_ADDRESS" id="basic-default-company"
                                                placeholder="Enter complete address" />
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-sm-2 col-form-label" for="basic-default-email">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control" value="<?= $row["IMS_WEB_EMAIL"] ?>"
                                                name="IMS_WEB_EMAIL" id="basic-default-email" placeholder="Enter email" />
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-sm-2 col-form-label" for="basic-default-phone">Contact No.</label>
                                        <div class="col-sm-10">
                                            <input type="text" value="<?= $row["IMS_WEB_CONTACT"] ?>" name="IMS_WEB_CONTACT"
                                                id="basic-default-phone" class="form-control phone-mask"
                                                placeholder="09XXXXXXXXX" aria-label="09XXXXXXXXX"
                                                aria-describedby="basic-default-phone" />
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-sm-2 col-form-label" for="basic-default-phone">Enrollment
                                            Fee</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control IMS_WEB_ENROLLMENT_FEE"
                                                value="<?= $row["IMS_WEB_ENROLLMENT_FEE"] ?>" name="IMS_WEB_ENROLLMENT_FEE"
                                                id="basic-default-fullname" placeholder="" required />
                                        </div>
                                    </div>
                                    <div class="row mb-4">
                                        <label class="col-sm-2 col-form-label" for="basic-default-message">About the
                                            School</label>
                                        <div class="col-sm-10">
                                            <textarea name="IMS_WEB_ABOUT" id="basic-default-message" class="form-control"
                                                placeholder="Write something about the school"
                                                aria-describedby="basic-icon-default-message2"><?= $row["IMS_WEB_ABOUT"] ?></textarea>
                                        </div>
                                    </div>
                                    <div class="row justify-content-end">
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </form>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="tab-pane fade " id="navs-top-profile" role="tabpanel">
                            <form id="submitSignatories" method="post">
                                <!-- CSRF token -->
                                <input type="hidden" class="txt_csrfname"
                                    name="<?= $this->security->get_csrf_token_name(); ?>"
                                    value="<?= $this->security->get_csrf_hash(); ?>">
                                <div class="row mb-4">
                                    <label class="col-sm-2 col-form-label" for="basic-default-company">President</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="SIG_PRES" class="form-control" id="SIG_PRES"
                                            placeholder="Enter the name of school president.." />
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-sm-2 col-form-label" for="basic-default-company">Registrar</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="SIG_REG" class="form-control" id="SIG_REG"
                                            placeholder="Enter the name of school registrar.." />
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-sm-2 col-form-label" for="basic-default-company">Dean</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="SIG_DEAN" class="form-control" id="SIG_DEAN"
                                            placeholder="Enter the name of school dean.." />
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-sm-2 col-form-label" for="basic-default-company">Cashier</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="SIG_CASH" class="form-control" id="SIG_CASH"
                                            placeholder="Enter the name of school cashier.." />
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </div>
                            </form>
                            <script>
                                $(function() {
                                    $("#submitSignatories").on("submit", function(e) {
                                        e.preventDefault();
                                        let valid = true;
                                        ["SIG_PRES", "SIG_REG", "SIG_DEAN", "SIG_CASH"].forEach(f => {
                                            let $el = $("#" + f);
                                            $el.toggleClass("is-invalid", !$el.val().trim());
                                            if (!$el.val().trim()) valid = false;
                                        });
                                        if (!valid) return;
                                        $.post("<?= base_url('WebSettingsController/updateSignatories') ?>",
                                            $(this).serialize(),
                                            function(res) {
                                                $('.txt_csrfname').val(res.token);
                                                Swal.fire({
                                                    title: res.output ? "Success!" : "Error!",
                                                    text: res.output ?
                                                        "Signatories updated successfully!" : "Failed to update signatories.",
                                                    icon: res.output ? "success" : "error",
                                                    customClass: {
                                                        confirmButton: 'btn btn-primary waves-effect waves-light'
                                                    },
                                                    buttonsStyling: false
                                                });
                                            }, "json").fail(function() {
                                            alert("An error occurred while submitting the form.");
                                        });
                                    });

                                    function fetchSignatories() {
                                        $.ajax({
                                            url: "<?= base_url('WebSettingsController/fetchSignatories'); ?>",
                                            type: "POST",
                                            dataType: "json",
                                            data: {
                                                <?= $this->security->get_csrf_token_name(); ?>: "<?= $this->security->get_csrf_hash(); ?>"
                                            },
                                            success: function(response) {
                                                // Update CSRF token
                                                $('.txt_csrfname').val(response.token);

                                                // Set input values directly from the object (no loop)
                                                $("#SIG_PRES").val(response.output.SIG_PRES);
                                                $("#SIG_REG").val(response.output.SIG_REG);
                                                $("#SIG_DEAN").val(response.output.SIG_DEAN);
                                                $("#SIG_CASH").val(response.output.SIG_CASH);
                                            },
                                            error: function(jqXHR, textStatus, errorThrown) {
                                                console.error("Error: ", textStatus, errorThrown);
                                                Swal.fire("Error",
                                                    "An error occurred while loading the signatories. Please try again.",
                                                    "error");
                                            }
                                        });
                                    }

                                    fetchSignatories();

                                });
                            </script>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- Crop Modal -->
        <div class="modal fade" id="cropperModal" tabindex="-1" aria-labelledby="cropperModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="cropperModalLabel">
                            <i class="ri-crop-line me-2"></i>Crop Logo
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
                            <input type="range" id="zoomSlider" class="form-range" min="0.5" max="3" step="0.01"
                                value="1" />
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


        $('#uploadLogoSchool').on('change', function() {
            openCropper('uploadLogoSchool', 'previewLogoSchool', 'logoSchoolCropped');
        });
        $('#uploadLogoLeft').on('change', function() {
            openCropper('uploadLogoLeft', 'previewLogoLeft', 'logoLeftCropped');
        });
        $('#uploadLogoRight').on('change', function() {
            openCropper('uploadLogoRight', 'previewLogoRight', 'logoRightCropped');
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
                        const filename = `cropped_image_${timestamp}.${extension}`;

                        // Update preview and hidden fields
                        $(`#${currentTarget.previewId}`).attr('src', base64Data).show().css(
                            'display', 'block');
                        $(`#${currentTarget.hiddenInputId}`).val(base64String);

                        // Set filename if the field exists
                        const filenameFieldId = currentTarget.hiddenInputId.replace('Cropped',
                            'Filename');
                        if ($(`#${filenameFieldId}`).length) {
                            $(`#${filenameFieldId}`).val(filename);
                        }

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

        // Institution form AJAX submission
        $('#institutionForm').on('submit', function(e) {
            e.preventDefault();

            // Validate required fields
            let isValid = true;
            const requiredFields = ['IMS_WEB_NOS', 'IMS_WEB_ACRO', 'IMS_WEB_ADDRESS', 'IMS_WEB_EMAIL',
                'IMS_WEB_CONTACT', 'IMS_WEB_ENROLLMENT_FEE'
            ];

            // Reset previous validation states
            $(this).find('.form-control').removeClass('is-invalid is-valid');

            // Validate required fields
            requiredFields.forEach(fieldName => {
                const field = $(`[name="${fieldName}"]`);
                const value = field.val().trim();

                if (!value) {
                    field.addClass('is-invalid');
                    isValid = false;
                } else {
                    field.addClass('is-valid');
                }
            });

            // Validate email format
            const email = $('[name="IMS_WEB_EMAIL"]');
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (email.val().trim() && !emailRegex.test(email.val())) {
                email.addClass('is-invalid').removeClass('is-valid');
                isValid = false;
            }

            // Validate contact number
            const contact = $('[name="IMS_WEB_CONTACT"]');
            const contactRegex = /^\d{11}$/;
            if (contact.val().trim() && !contactRegex.test(contact.val().replace(/\D/g, ''))) {
                contact.addClass('is-invalid').removeClass('is-valid');
                isValid = false;
            }

            if (!isValid) {
                Swal.fire({
                    title: 'Validation Error',
                    text: 'Please fill in all required fields correctly.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
                return false;
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

                    Swal.fire({
                        title: response.output ? 'Success!' : 'Error!',
                        text: response.message || (response.output ?
                            'Institution settings updated successfully!' :
                            'Failed to update settings.'),
                        icon: response.output ? 'success' : 'error',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'btn btn-primary'
                        },
                        buttonsStyling: false,
                        confirmButtonText: 'OK'
                    });
                    location.reload();
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                    let errorMessage = 'An error occurred while updating settings.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.responseText) {
                        try {
                            const errorResponse = JSON.parse(xhr.responseText);
                            errorMessage = errorResponse.message || errorMessage;
                        } catch (e) {
                            // Use default message if JSON parsing fails
                        }
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
<script>
    // Function to format BP_AMOUNT inputs

    $(document).on('keyup', '.IMS_WEB_ENROLLMENT_FEE', function(event) {
        if (event.which >= 37 && event.which <= 40) {
            event.preventDefault();
        }
        $(this).val(function(index, value) {
            return value.replace(/\D/g, "")
                .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
        });
    });
</script>