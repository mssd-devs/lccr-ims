<style>
    #showPicture img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
    }
</style>


<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Student Profile</a>
            </li>
            <li class="breadcrumb-item active">Create</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <!-- Validation Wizard -->
        <div class="col-md-12 mb-6">
            <div id="wizard-validation" class="bs-stepper mt-2">
                <div class="bs-stepper-header">
                    <!-- personal-details-validation -->
                    <div class="step " data-target="#personal-details-validation">
                        <button type="button" class="step-trigger flex-lg-wrap gap-lg-2">
                            <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
                            <span class="bs-stepper-label ms-lg-0">
                                <span class="d-flex flex-column gap-1 text-lg-center">
                                    <span class="bs-stepper-title">Personal Background</span>
                                    <span class="bs-stepper-subtitle">Add personal info</span>
                                </span>
                            </span>
                        </button>
                    </div>
                    <div class="line mt-lg-2 mb-lg-3"></div>
                    <!-- education-details-validation -->
                    <div class="step" data-target="#education-details-validation">
                        <button type="button" class="step-trigger flex-lg-wrap gap-lg-2">
                            <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
                            <span class="bs-stepper-label ms-lg-0">
                                <span class="d-flex flex-column gap-1 text-lg-center">
                                    <span class="bs-stepper-title">Educational Background</span>
                                    <span class="bs-stepper-subtitle">Add educational background</span>
                                </span>
                            </span>
                        </button>
                    </div>
                    <div class="line mt-lg-2 mb-lg-3"></div>
                    <!-- parent-details-validation -->
                    <div class="step" data-target="#parent-details-validation">
                        <button type="button" class="step-trigger flex-lg-wrap gap-lg-2">
                            <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
                            <span class="bs-stepper-label ms-lg-0">
                                <span class="d-flex flex-column gap-1 text-lg-center">
                                    <span class="bs-stepper-title">Family Background</span>
                                    <span class="bs-stepper-subtitle">Add family background</span>
                                </span>
                            </span>
                        </button>
                    </div>
                    <div class="line mt-lg-2 mb-lg-3"></div>
                    <!-- parent-details-validation -->
                    <div class="step" data-target="#documents-details-validation">
                        <button type="button" class="step-trigger flex-lg-wrap gap-lg-2">
                            <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
                            <span class="bs-stepper-label ms-lg-0">
                                <span class="d-flex flex-column gap-1 text-lg-center">
                                    <span class="bs-stepper-title">Documents Checklist</span>
                                    <span class="bs-stepper-subtitle">Check the documents submitted</span>
                                </span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="bs-stepper-content">
                    <form id="wizardForm" class="needs-validation" onsubmit="return false" novalidate
                        enctype="multipart/form-data">
                        <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                        <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="SP_STATUS" id="SP_STATUS">
                        <!-- personal-details-validation -->
                        <div id="personal-details-validation" class="content">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Personal Background</h6>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="SP_LASTNAME"
                                            value="<?= $this->session->userdata("SP_LASTNAME"); ?>"
                                            id="basic-default-fullname" placeholder="Enter your Lastname" readonly
                                            required />
                                        <label for="basic-default-fullname">Last Name <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="SP_FIRSTNAME"
                                            id="basic-default-fullname"
                                            value="<?= $this->session->userdata("SP_FIRSTNAME"); ?>"
                                            placeholder="Enter your Firstname" readonly required />
                                        <label for="basic-default-fullname">First Name <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="SP_MIDDLENAME"
                                            value="<?= $this->session->userdata("SP_MIDDLENAME"); ?>"
                                            id="basic-default-fullname" placeholder="Enter your Middlename" readonly />
                                        <label for="basic-default-fullname">Middle Name</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select id="SP_SUFFIX" name="SP_SUFFIX" class="select2 form-select"
                                            data-allow-clear="true">
                                            <option value="">--Select--</option>
                                            <option>JR</option>
                                            <option>SR</option>
                                            <option>I</option>
                                            <option>II</option>
                                            <option>III</option>
                                            <option>IV</option>
                                            <option>V</option>
                                            <option>VI</option>
                                            <option>VII</option>
                                            <option>VIII</option>
                                        </select>
                                        <label for="SP_SUFFIX">Suffix</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select id="select2Basic" name="SP_GENDER" class="select2 form-select" required
                                            data-allow-clear="true">
                                            <option value="">--Select--</option>
                                            <option>MALE</option>
                                            <option>FEMALE</option>
                                        </select>
                                        <label for="select2Basic">Gender <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="date" class="form-control" required readonly name="SP_BIRTHDAY"
                                            id="SP_BIRTHDAY" value="<?= $this->session->userdata("SP_BIRTHDAY"); ?>"
                                            placeholder="Birthdate" max="<?= date('Y-m-d'); ?>" />
                                        <label for="basic-default-fullname">Date of Birth <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="SP_AGE" readonly id="SP_AGE"
                                            placeholder="Age"
                                            value="<?= calculate_age($this->session->userdata("SP_BIRTHDAY")); ?>" />
                                        <label for="basic-default-fullname">Age</label>
                                    </div>
                                </div>

                                <?php
                                function calculate_age($birthdate)
                                {
                                    $today = new DateTime();
                                    $birthDate = new DateTime($birthdate);
                                    $age = $today->diff($birthDate)->y;
                                    return $age;
                                }
                                ?>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" style="width: 100%;" name="SP_PWD"
                                            id="SP_PWD" required data-allow-clear="true">
                                            <option value="">--Select--</option>
                                            <option>YES</option>
                                            <option>NO</option>
                                        </select>
                                        <label for="basic-default-fullname">Person With Disabilities <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="SP_PWD_SPECIFY" id="SP_PWD_SPECIFY"
                                            data-allow-clear="true" required>
                                            <option value="">--Select--</option>
                                            <option>VISUAL IMPAIRMENT</option>
                                            <option>HEARING LOSS</option>
                                            <option>ORTHOPEDIC DISABILITY</option>
                                            <option>LEARNING DISABILITY</option>
                                            <option>PSYCHOSOCIAL DISABILITY</option>
                                            <option>CHRONIC ILLNESS</option>
                                            <option>MENTAL DISABILITY</option>
                                        </select>
                                        <label for="SP_PWD_SPECIFY">List of PWD Illness <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function() {
                                        $("#SP_PWD").on("change", function() {
                                            var isDisabled = $(this).val() !== "YES";
                                            $("#SP_PWD_SPECIFY").prop("disabled", isDisabled).prop(
                                                "required", !isDisabled);
                                        });
                                    });
                                </script>
                            </div>
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Contact Details</h6>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input class="form-control" type="text" name="SP_CPNUMBER"
                                            placeholder="(+63) 000-0000" oninput="formatPhoneNumber(this)" required />
                                        <label for="basic-default-fullname">Contact # <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="email" class="form-control" name="SP_EMAIL"
                                            id="basic-default-fullname" placeholder="Enter your Email Address" />
                                        <label for="basic-default-fullname">Email Address </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" style="width: 100%;" name="SP_CIVILSTATUS"
                                            required id="" data-allow-clear="true" required>
                                            <option value="">--Select--</option>
                                            <option>SINGLE</option>
                                            <option>MARRIED</option>
                                            <option>DIVORCED/SEPARETED</option>
                                            <option>WIDOWED/WIDOWER</option>
                                            <option>COMMON-LAW/LIVE-IN</option>
                                        </select>
                                        <label for="basic-default-fullname">Civil Status <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="SP_NATIONALITY" required
                                            id="basic-default-fullname" placeholder="Enter your Nationality" required />
                                        <label for="basic-default-fullname">Nationality <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" style="width: 100%;" name="SP_RELIGION"
                                            id="SP_RELIGION" required data-allow-clear="true" required>
                                            <option value="">--Select--</option>
                                            <option>ISLAM</option>
                                            <option>CHRISTIANITY</option>
                                            <option>BUDDHISM</option>
                                            <option>HINDUISM</option>
                                            <option>JUDAISM</option>
                                            <option>JAINISM</option>
                                            <option>IRRELIGIOUS AND ATHEISTS</option>
                                            <option>SIKHISM</option>
                                            <option>ZOROASTRIANISM</option>
                                        </select>
                                        <label for="basic-default-fullname">Religion <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" style="width: 100%;" name="SP_TRIBE" id=""
                                            data-allow-clear="true" required>
                                            <option value="">--Select--</option>
                                            <?php
                                            foreach ($LoadTribes->result() as $r) {
                                            ?>
                                                <option><?= $r->IMS_TRIBES; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="basic-default-fullname">Ethnic Affilation/Tribe <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Complete Address</h6>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" style="width: 100%;" name="SP_REGION"
                                            id="SP_REGION" data-allow-clear="true" required>
                                            <option value="">--Select--</option>
                                            <?php
                                            foreach ($LoadRegion->result() as $r) {
                                            ?>
                                                <option value="<?= $r->regCode; ?>"><?= $r->regDesc; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="basic-default-fullname">Region <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" style="width: 100%;" name="SP_PROVINCE"
                                            id="SP_PROVINCE" data-allow-clear="true" required>
                                            <option value="">--Select--</option>
                                        </select>
                                        <label for="basic-default-fullname">Province <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" style="width: 100%;" name="SP_MUNICIPALITY"
                                            id="SP_MUNICIPALITY" data-allow-clear="true" required>
                                            <option value="">--Select--</option>
                                        </select>
                                        <label for="basic-default-fullname">City/Municipality <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" style="width: 100%;" name="SP_BRGY"
                                            id="SP_BRGY" data-allow-clear="true" required>
                                            <option value="">--Select--</option>
                                        </select>
                                        <label for="basic-default-fullname">Barangay <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="SP_STRT" id="SP_STRT"
                                            placeholder="Enter Streets" />
                                        <label for="basic-default-fullname">Street </span></label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="SP_ZCODE" required maxlength="4"
                                            id="basic-default-fullname" placeholder="Enter your Zip Code" required />
                                        <label for="basic-default-fullname">Zip Code <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="SP_BIRTHPLACE" id="SP_BIRTHPLACE"
                                            required placeholder="Enter Birthplace" />
                                        <label for="basic-default-fullname">Birthplace <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>


                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card shadow-sm">
                                        <div class="card-header text-center bg-primary text-white">
                                            <strong>Take or Upload a Photo</strong>
                                        </div>
                                        <div class="card-body mt-3 text-center">
                                            <button type="button" class="btn btn-outline-primary mb-3" id="btnCamera"
                                                data-bs-toggle="modal" data-bs-target="#cameraModal">
                                                <i class="bi bi-camera"></i> Take Photo
                                            </button>

                                            <div class="my-2 text-muted">or</div>

                                            <input type="file" id="uploadImage" accept="image/*"
                                                class="form-control mb-2">
                                            <small class="text-muted">Upload an image</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card shadow-sm">
                                        <div class="card-header text-center bg-secondary text-white">
                                            <strong>Preview</strong>
                                        </div>
                                        <div class="card-body mt-3 text-center"
                                            style="min-height:220px; display:flex; align-items:center; justify-content:center;">
                                            <img id="previewImage" src="" alt="Preview"
                                                style="max-width:100%; max-height:200px; display:none;" class="rounded">
                                            <span id="noImageText" class="text-muted">No image selected</span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="capturedImage" id="imageCropped">
                                </div>
                            </div>

                            <!-- Crop Modal -->
                            <div class="modal fade" id="cropperModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Crop Image</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <div style="max-width: 100%; overflow-x: auto;">
                                                <img id="imageToCrop" src="" class="img-fluid border"
                                                    style="max-width: 100%; max-height: 300px;" />
                                            </div>

                                            <div class="text-center mt-3">
                                                <input type="range" id="zoomSlider" class="form-range" min="0.5" max="3"
                                                    step="0.01" value="1" />
                                                <small class="text-muted">Resize (Zoom In/Out)</small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" id="cropImageBtn" class="btn btn-success">
                                                Crop & Use
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>




                            <div class="row">
                                <div class="col-12 d-flex gap-2 justify-content-end">
                                    <button class="btn btn-outline-danger btn-draft">
                                        <i class="ri-save-line me-sm-1 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Save as Draft</span>
                                    </button>
                                    <button class="btn btn-primary btn-next-personal">
                                        <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                        <i class="ri-arrow-right-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <!-- education-details-validation -->
                        <div id="education-details-validation" class="content">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Educational Background</h6>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="number" class="form-control" required name="SP_LRN"
                                            id="basic-default-fullname"
                                            placeholder="Learner's Reference Number (LRN)" />
                                        <label for="basic-default-fullname">Learner's Reference Number (LRN) <span
                                                class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="education-container"></div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12 d-flex gap-2 justify-content-end ">
                                    <button class="btn btn-outline-secondary btn-prev p-2">
                                        <i class="ri-arrow-left-line me-sm-1 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-secondary btn-add-school p-2">
                                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Add School
                                                Attainment</span>
                                            <i class="ri-add-line"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-draft">
                                            <i class="ri-save-line me-sm-1 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Save as Draft</span>
                                        </button>
                                        <button class="btn btn-primary btn-next-education p-2">
                                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                            <i class="ri-arrow-right-line"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- parent-details-validation -->
                        <div id="parent-details-validation" class="content">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Family Background</h6>
                            </div>

                            <div class="row family-container"></div>

                            <div class="row mt-4">
                                <div class="col-12 d-flex gap-2 justify-content-end">
                                    <button class="btn btn-outline-secondary btn-prev p-2">
                                        <i class="ri-arrow-left-line me-sm-1 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-secondary btn-add-parent p-2">
                                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Add
                                                Parent/Guardian</span>
                                            <i class="ri-add-line"></i>
                                        </button>
                                        <button class="btn btn-outline-danger btn-draft">
                                            <i class="ri-save-line me-sm-1 me-0"></i>
                                            <span class="align-middle d-sm-inline-block d-none">Save as Draft</span>
                                        </button>
                                        <button class="btn btn-primary btn-next-parent p-2">
                                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Next</span>
                                            <i class="ri-arrow-right-line"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- documents-details-validation -->
                        <div id="documents-details-validation" class="content">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Documents Attachment</h6>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <th>List of Requirements Submitted (Freshmen)</th>
                                                <th>List of Requirements Submitted <small>(for transferee)</small></th>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <?php
                                                        $query = $this->db->where("REQ_CAT", "Freshmen")->get("tbl_requirements");
                                                        if ($query->num_rows() > 0) {
                                                            foreach ($query->result() as $r) {
                                                        ?>
                                                                <div class="form-check form-check-success">
                                                                    <input class="form-check-input"
                                                                        name="SP_ATTACHMENTS_FRESHMEN[]" type="checkbox"
                                                                        value="<?= $r->ID ?>" id="freshmen_<?= $r->REQS ?>" />
                                                                    <label class="form-check-label"
                                                                        for="freshmen_<?= $r->REQS ?>"><?= $r->REQS ?></label>
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>

                                                    </td>
                                                    <td>
                                                        <?php
                                                        $query = $this->db->where("REQ_CAT", "Transferee")->get("tbl_requirements");
                                                        if ($query->num_rows() > 0) {
                                                            foreach ($query->result() as $r) {
                                                        ?>
                                                                <div class="form-check form-check-success">
                                                                    <input class="form-check-input"
                                                                        name="SP_ATTACHMENTS_TRANSFEREE[]" type="checkbox"
                                                                        value="<?= $r->ID ?>" id="transferee_<?= $r->REQS ?>" />
                                                                    <label class="form-check-label"
                                                                        for="transferee_<?= $r->REQS ?>"><?= $r->REQS ?></label>
                                                                </div>
                                                        <?php
                                                            }
                                                        }
                                                        ?>


                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12 d-flex  gap-2 justify-content-end">
                                    <button class="btn btn-outline-secondary btn-prev">
                                        <i class="ri-arrow-left-line me-sm-1 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
                                    </button>
                                    <button class="btn btn-outline-danger btn-draft">
                                        <i class="ri-save-line me-sm-1 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Save as Draft</span>
                                    </button>
                                    <button type="submit" class="btn btn-success" id="btnSubmit">
                                        <span class="align-middle d-sm-inline-block d-none me-sm-1">Submit</span>
                                        <i class="ri-arrow-right-line"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /Validation Wizard -->
    </div>

</div>
<!-- / Content -->

<!-- Modal -->
<div class="modal fade" id="cameraModal" data-bs-backdrop="static" tabindex="-1">
    <div class="modal-dialog">
        <form class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="backDropModalTitle">Camera</h4>
                <button type="button" class="btn-close" id="closeModal" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div>
                    <div id="my_camera" class="d-block mx-auto rounded overflow-hidden"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning mx-auto text-white" id="takephoto">Capture Photo</button>
            </div>
        </form>
    </div>
</div>

<script>

</script>

<!-- school background  -->
<script>
    function reinitializeSelect2(element) {
        element.select2({
            placeholder: "Select an option",
            allowClear: true
        });
    }



    $(document).ready(function() {
        addEducationItem();
        $(".btn-add-school").click(function() {
            addEducationItem();
        });

        function addEducationItem() {
            $.ajax({
                url: "<?= base_url('StudentProfileController/FetchEducationAttainment'); ?>",
                type: "POST",
                dataType: "json",
                data: {
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                },
                success: function(data) {
                    // Update CSRF hash
                    $('.txt_csrfname').val(data.token);
                    $(".education-container").append(data.output);
                    reinitializeSelect2($(".education-container").find('.select2'));
                }
            });
        }


        $(document).on("change", ".education-container .select2", function() {
            var selectedValue = $(this).val();
            var textElement = $(this).closest('.education-item').find(".textEducAttainment");
            if (selectedValue != "") {
                textElement.text("(" + selectedValue + ")");
            } else {
                textElement.text("(--please select--)");
            }

            if (selectedValue == "College") {
                $(this).closest('.education-item').find(".showCourseTaken").removeClass("d-none");
                $(this).closest('.education-item').find(".EDUC_PROGRAM").prop("required", true).prop(
                    "disabled", false);
            } else {
                $(this).closest('.education-item').find(".showCourseTaken").addClass("d-none");
                $(this).closest('.education-item').find(".EDUC_PROGRAM").prop("required", false).prop(
                    "disabled", true);
            }
        });

        $(document).on("click", ".btn-delete-school", function() {
            $(this).closest('.education-item').remove();
        });

        reinitializeSelect2($(".education-container").find('.select2'));
    });

    $(document).ready(function() {
        setTimeout(function() {
            addParentItem();
        }, 500);
        // Function to add a new parent/guardian item
        function addParentItem() {
            $.ajax({
                url: "<?= base_url('StudentProfileController/FetchFamilyBackground'); ?>",
                type: "POST",
                dataType: "json",
                data: {
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                },
                success: function(data) {
                    // Update CSRF hash
                    $('.txt_csrfname').val(data.token);
                    $(".family-container").append(data.output);
                    reinitializeSelect2($(".family-container").find('.select2'));
                }
            });
        }

        // Add parent item on button click
        $(".btn-add-parent").click(function() {
            addParentItem();
        });

        // Delete parent item on button click
        $(document).on("click", ".btn-delete-parent", function() {
            $(this).closest('.family-item').remove();
        });

        // Show specify input if "Other relatives, specify" is selected
        $(document).on("change", ".family-container .select2", function() {

            var selectedValue = $(this).val();
            var textElement = $(this).closest('.family-item').find(".textFamilyBackground");
            if (selectedValue != "") {
                textElement.text("(" + selectedValue + ")");
            } else {
                textElement.text("(--please select--)");
            }
            var specifyElement = $(this).closest('.family-item').find("#showSpecify");
            if (selectedValue == "Other relatives, specify") {
                specifyElement.removeClass("d-none");
                specifyElement.find("#FAM_RELATIONSHIP_SPECIFY").prop("disabled", false).prop("required",
                    true);
            } else {
                specifyElement.addClass("d-none");
                specifyElement.find("#FAM_RELATIONSHIP_SPECIFY").prop("disabled", true).prop("required",
                    false);
            }
        });

        // Initialize select2 for existing elements
        reinitializeSelect2($(".family-container").find('.select2'));
    });
</script>


<script>
    $(document).ready(function() {
        var stepperForm = $('#wizardForm');
        var stepper = new Stepper(document.querySelector('.bs-stepper'));

        // Function to validate the current step
        function validateStep(step) {
            var inputs = step.find('input, select, textarea');
            var isValid = true;

            inputs.each(function() {
                // Check if input is required and if it's empty
                if ($(this).prop('required') && $(this).val().trim() === '') {
                    isValid = false;
                    $(this).addClass('is-invalid');
                } else {
                    $(this).addClass('was-validated');
                    $(this).removeClass('is-invalid');
                }
            });

            return isValid;
        }

        // Function to handle next button click
        function handleNextStep(btn, step) {
            btn.click(function() {
                if (validateStep(step)) {
                    stepper.next();
                }
            });
        }

        handleNextStep($('.btn-next-personal'), $('#personal-details-validation'));
        handleNextStep($('.btn-next-education'), $('#education-details-validation'));
        handleNextStep($('.btn-next-parent'), $('#parent-details-validation'));
        $('.btn-prev').on('click', function() {
            stepper.previous();
        });
        $("#btnSubmit").on("click", function() {
            if (validateStep($('#documents-details-validation'))) {
                showConfirmationDialog();
            }
        });
        $(".btn-draft").on("click", function() {
            Swal.fire({
                title: "Are you sure?",
                text: "You want to save as draft!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, save it!",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#SP_STATUS").val("DRAFT");
                    submitForm();
                }
            });
        });



        function showConfirmationDialog() {
            Swal.fire({
                title: "Are you sure?",
                text: "Once submitted, student profile will be saved!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, submit it!",
                cancelButtonText: "Cancel",
                customClass: {
                    confirmButton: 'btn btn-primary',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    $("#SP_STATUS").val("SAVED");
                    submitForm();
                }
            });
        }

        function submitForm() {
            $.ajax({
                url: "<?= base_url('StudentProfileController/saveUpdateSP'); ?>",
                type: "POST",
                dataType: "json",
                data: stepperForm.serialize(),
                success: function(data) {
                    if (data.output) {
                        Swal.fire({
                            title: "Success!",
                            text: data.output,
                            icon: "success",
                            customClass: {
                                confirmButton: 'btn btn-primary waves-effect waves-light'
                            },
                            buttonsStyling: false
                        });
                        window.location.href = "<?= base_url('ims/studentprofile'); ?>";
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: data.output,
                            icon: "error",
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false,
                        });
                    }
                }
            });
        }
    });
</script>

<script>
    $(document).ready(function() {
        // Attach an event listener to the date input
        $("#SP_BIRTHDAY").change(function() {
            // Get the selected date
            var dob = $(this).val();

            // Calculate age
            var today = new Date();
            var birthDate = new Date(dob);
            var age = today.getFullYear() - birthDate.getFullYear();

            // Check if the birthday has occurred this year
            if (today.getMonth() < birthDate.getMonth() || (today.getMonth() === birthDate.getMonth() &&
                    today.getDate() < birthDate.getDate())) {
                age--;
            }

            // Set the calculated age to the age input
            $("#SP_AGE").val(age);
        });
    });
</script>

<!-- FOR ADDRESS SELECT DYNAMIC -PERSONAL DATA  -->
<script>
    $(document).ready(function() {
        // Event listener for region selection
        $('#SP_REGION').change(function() {
            // Add your code to load province options based on the selected region
            if ($(this).val() != '') {
                var regCode = $(this).val();
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr(
                    'name'); // Value specified in $config['csrf_token_name']
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                $.ajax({
                    url: "<?= base_url("StudentProfileController/LoadProvince"); ?>",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        regCode: regCode,
                        [csrfName]: csrfHash
                    },
                    success: function(data) {
                        // Update CSRF hash
                        $('.txt_csrfname').val(data.token);
                        $('#SP_PROVINCE').html(data.output);
                    },
                    error: function(jqXHR, errorType, error) {
                        alert(error);
                    }
                });
            }
        });
        // Event listener for province selection
        $('#SP_PROVINCE').change(function() {
            // Add your code to load city/municipality options based on the selected province
            if ($(this).val() != '') {
                var provCode = $(this).val();
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr(
                    'name'); // Value specified in $config['csrf_token_name']
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                $.ajax({
                    url: "<?= base_url("StudentProfileController/LoadCity"); ?>",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        provCode: provCode,
                        [csrfName]: csrfHash
                    },
                    success: function(data) {
                        // Update CSRF hash
                        $('.txt_csrfname').val(data.token);
                        $('#SP_MUNICIPALITY').html(data.output);

                    },
                    error: function(jqXHR, errorType, error) {
                        alert(error);
                    }
                });
            }
        });
        // Event listener for city/municipality selection
        $('#SP_MUNICIPALITY').change(function() {
            // Add your code to load barangay options based on the selected city/municipality
            if ($(this).val() != '') {
                var citymunCode = $(this).val();
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr(
                    'name'); // Value specified in $config['csrf_token_name']
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                $.ajax({
                    url: "<?= base_url("StudentProfileController/LoadBrgy"); ?>",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        citymunCode: citymunCode,
                        [csrfName]: csrfHash
                    },
                    success: function(data) {
                        // Update CSRF hash
                        $('.txt_csrfname').val(data.token);
                        $('#SP_BRGY').html(data.output);

                    },
                    error: function(jqXHR, errorType, error) {
                        alert(error);
                    }
                });
            }
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

<script>
    $(document).ready(function() {

        Webcam.set({
            width: 220,
            height: 200,
            imageFormat: 'jpeg',
            jpegQuality: 90
        });

        $('#btnCamera').on('click', function() {
            Webcam.reset();
            Webcam.on('error', function() {
                $('#cameraModal').modal('hide');
                swal({
                    title: 'Warning',
                    text: 'Please give permission to access your webcam',
                    icon: 'warning'
                });
            });
            Webcam.attach('#my_camera');
        });

        $('#takephoto').on('click', function() {
            Webcam.snap(function(data_uri) {
                var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
                $('#previewImage').attr('src', data_uri).show();
                $('#noImageText').hide();
                $('#imageCropped').val(raw_image_data);

            });
            Webcam.reset();
            $('#cameraModal').modal('hide');
        });

        $('#closeModal').click(function() {
            Webcam.reset();
        });


        // ==============================
        // CROPPER
        // ==============================
        let cropper;

        function openCropper(fileInputId) {
            const file = document.getElementById(fileInputId).files[0];
            if (!file || !/^image\//.test(file.type)) {
                alert("Please select a valid image file.");
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                $('#imageToCrop').attr('src', e.target.result);
                $('#cropperModal').modal('show');
            };
            reader.readAsDataURL(file);
        }

        $('#uploadImage').on('change', function() {
            openCropper('uploadImage');
        });

        $('#cropperModal').on('shown.bs.modal', function() {
            cropper = new Cropper(document.getElementById('imageToCrop'), {
                aspectRatio: 1,
                viewMode: 1,
                ready() {
                    $('#zoomSlider').val(1);
                }
            });

            $('#zoomSlider').off('input').on('input', function() {
                const zoomValue = parseFloat(this.value);
                cropper.zoomTo(zoomValue);
            });
        }).on('hidden.bs.modal', function() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        });

        $('#cropImageBtn').on('click', function() {
            const canvas = cropper.getCroppedCanvas({
                width: 200,
                height: 200
            });
            let croppedData = canvas.toDataURL('image/jpeg'); // or 'image/png'
            var raw_image_data = croppedData.replace(/^data\:image\/\w+\;base64\,/, '');
            $('#previewImage').attr('src', croppedData).show();
            $('#noImageText').hide();

            // put entire base64 string (with prefix) into hidden field
            $('#imageCropped').val(raw_image_data);

            $('#cropperModal').modal('hide');
        });

    });
</script>