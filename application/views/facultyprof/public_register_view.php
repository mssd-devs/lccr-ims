<!DOCTYPE html>
<html lang="en" class="light-style layout-wide" dir="ltr" data-theme="theme-default" data-assets-path="<?= base_url(); ?>assets/" data-template="vertical-menu-template" data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Employee Self-Registration - Institution Management System</title>
    <link rel="icon" type="image/x-icon" href="<?= base_url(); ?>assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/fonts/remixicon/remixicon.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/libs/node-waves/node-waves.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/css/rtl/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/css/rtl/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/demo.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/libs/sweetalert2/sweetalert2.css" />

    <script src="<?= base_url(); ?>assets/vendor/libs/jquery/jquery.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/js/helpers.js"></script>
    <script src="<?= base_url(); ?>assets/js/config.js"></script>

    <style>
        body {
            background-color: #f5f5f9;
            font-family: 'Inter', sans-serif;
        }
        .header-brand {
            background: linear-gradient(135deg, #696cff 0%, #393bbf 100%);
            color: #fff;
            padding: 2.5rem 1rem;
            text-align: center;
            border-radius: 0 0 1.5rem 1.5rem;
            box-shadow: 0 4px 20px rgba(105, 108, 255, 0.2);
            margin-bottom: 2rem;
        }
        .card-register {
            border-radius: 1rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>

<body>
    <div class="header-brand">
        <h2 class="text-white fw-bold mb-1"><i class="ri-user-add-line me-2"></i>Employee Profile Registration</h2>
        <p class="text-white-50 mb-0">Institution Management System — Please complete your profile details below</p>
    </div>

    <div class="container-xxl flex-grow-1 container-p-y mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="card card-register">
                    <div class="card-body p-4">
                        <div id="wizard-validation" class="bs-stepper mt-2">
                            <div class="bs-stepper-header">
                                <div class="step" data-target="#personal-details-validation">
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
                                <div class="step" data-target="#education-details-validation">
                                    <button type="button" class="step-trigger flex-lg-wrap gap-lg-2">
                                        <span class="bs-stepper-circle"><i class="ri-check-line"></i></span>
                                        <span class="bs-stepper-label ms-lg-0">
                                            <span class="d-flex flex-column gap-1 text-lg-center">
                                                <span class="bs-stepper-title">Educational & Employment</span>
                                                <span class="bs-stepper-subtitle">Add background details</span>
                                            </span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <div class="bs-stepper-content pt-4">
                                <form id="wizardForm" class="needs-validation" onsubmit="return false" novalidate>
                                    <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                                    <!-- Personal Details Step -->
                                    <div id="personal-details-validation" class="content">
                                        <div class="content-header mb-4">
                                            <h5 class="mb-0 fw-semibold text-primary"><i class="ri-user-line me-2"></i>Personal Background</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <input type="text" class="form-control" name="FP_LASTNAME" id="FP_LASTNAME" placeholder="Last Name" required />
                                                    <label for="FP_LASTNAME">Last Name <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <input type="text" class="form-control" name="FP_FIRSTNAME" id="FP_FIRSTNAME" placeholder="First Name" required />
                                                    <label for="FP_FIRSTNAME">First Name <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <input type="text" class="form-control" name="FP_MIDDLENAME" id="FP_MIDDLENAME" placeholder="Middle Name" />
                                                    <label for="FP_MIDDLENAME">Middle Name</label>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <select id="FP_SUFFIX" name="FP_SUFFIX" class="select2 form-select" data-allow-clear="true">
                                                        <option value="">--Select--</option>
                                                        <option>JR</option><option>SR</option><option>I</option><option>II</option><option>III</option><option>IV</option><option>V</option>
                                                    </select>
                                                    <label for="FP_SUFFIX">Suffix</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <select id="FP_GENDER" name="FP_GENDER" class="select2 form-select" required data-allow-clear="true">
                                                        <option value="">--Select--</option>
                                                        <option>MALE</option>
                                                        <option>FEMALE</option>
                                                    </select>
                                                    <label for="FP_GENDER">Gender <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <input type="date" class="form-control" required name="FP_BIRTHDAY" id="FP_BIRTHDAY" max="<?= date('Y-m-d'); ?>" />
                                                    <label for="FP_BIRTHDAY">Date of Birth <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <input type="text" class="form-control" name="FP_AGE" readonly id="FP_AGE" placeholder="Age" />
                                                    <label for="FP_AGE">Age</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="content-header my-4">
                                            <h5 class="mb-0 fw-semibold text-primary"><i class="ri-contacts-line me-2"></i>Contact Details</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <input class="form-control" type="text" name="FP_CPNUMBER" placeholder="Contact #" required />
                                                    <label>Contact # <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <input type="email" class="form-control" name="FP_EMAIL" placeholder="Email Address" />
                                                    <label>Email Address</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <select class="form-select select2" name="FP_CIVILSTAT" required data-allow-clear="true">
                                                        <option value="">--Select--</option>
                                                        <option>SINGLE</option>
                                                        <option>MARRIED</option>
                                                        <option>DIVORCED/SEPARATED</option>
                                                        <option>WIDOWED/WIDOWER</option>
                                                    </select>
                                                    <label>Civil Status <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <input type="text" class="form-control" name="FP_NATIONALITY" required placeholder="Nationality" />
                                                    <label>Nationality <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <select class="form-select select2" name="FP_RELIGION" required data-allow-clear="true">
                                                        <option value="">--Select--</option>
                                                        <option>CHRISTIANITY</option>
                                                        <option>ISLAM</option>
                                                        <option>BUDDHISM</option>
                                                        <option>HINDUISM</option>
                                                        <option>OTHERS</option>
                                                    </select>
                                                    <label>Religion <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <select class="form-select select2" name="FP_TRIBE" data-allow-clear="true" required>
                                                        <option value="">--Select--</option>
                                                        <?php
                                                        if (isset($LoadTribes)) {
                                                            foreach ($LoadTribes->result() as $r) {
                                                                echo '<option>' . $r->IMS_TRIBES . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <label>Ethnic Affiliation/Tribe <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="content-header my-4">
                                            <h5 class="mb-0 fw-semibold text-primary"><i class="ri-map-pin-line me-2"></i>Complete Address</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <select class="form-select select2" name="FP_REGION" id="FP_REGION" required data-allow-clear="true">
                                                        <option value="">--Select--</option>
                                                        <?php
                                                        if (isset($LoadRegion)) {
                                                            foreach ($LoadRegion->result() as $r) {
                                                                echo '<option value="' . $r->regCode . '">' . $r->regDesc . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <label>Region <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <select class="form-select select2" name="FP_PROVINCE" id="FP_PROVINCE" required data-allow-clear="true">
                                                        <option value="">--Select--</option>
                                                    </select>
                                                    <label>Province <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <select class="form-select select2" name="FP_MUNICIPALITY" id="FP_MUNICIPALITY" required data-allow-clear="true">
                                                        <option value="">--Select--</option>
                                                    </select>
                                                    <label>City/Municipality <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <select class="form-select select2" name="FP_BRGY" id="FP_BRGY" required data-allow-clear="true">
                                                        <option value="">--Select--</option>
                                                    </select>
                                                    <label>Barangay <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-8">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <input type="text" class="form-control" name="FP_STRT" placeholder="Street Address" />
                                                    <label>Street</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <input type="text" class="form-control" name="FP_ZCODE" required maxlength="4" placeholder="Zip Code" />
                                                    <label>Zip Code <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-end mt-4">
                                            <button type="button" class="btn btn-primary btn-next-personal">
                                                <span class="align-middle me-1">Next: Background & Employment</span>
                                                <i class="ri-arrow-right-line"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Education & Employment Step -->
                                    <div id="education-details-validation" class="content">
                                        <div class="content-header mb-4">
                                            <h5 class="mb-0 fw-semibold text-primary"><i class="ri-briefcase-line me-2"></i>Employment & Education Details</h5>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <select class="form-select select2" name="FP_EMPLOYEETYPE" required data-allow-clear="true">
                                                        <option value="">--Select--</option>
                                                        <option>TEACHING</option>
                                                        <option>NON-TEACHING</option>
                                                    </select>
                                                    <label>Employee Type <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <select class="form-select select2" name="FP_TENURE" data-allow-clear="true">
                                                        <option value="">--Select--</option>
                                                        <?php
                                                        if (isset($LoadTenure)) {
                                                            foreach ($LoadTenure->result() as $r) {
                                                                echo '<option>' . $r->IMS_TENURE . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <label>Tenure of Employment</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating form-floating-outline mb-4">
                                                    <select class="form-select select2" name="FP_FACRANK" data-allow-clear="true">
                                                        <option value="">--Select--</option>
                                                        <?php
                                                        if (isset($LoadFacultyRank)) {
                                                            foreach ($LoadFacultyRank->result() as $r) {
                                                                echo '<option>' . $r->IMS_FACRANK . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <label>Rank / Position</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 d-flex justify-content-between mt-4">
                                            <button type="button" class="btn btn-outline-secondary btn-prev">
                                                <i class="ri-arrow-left-line me-1"></i> Previous
                                            </button>
                                            <button type="button" class="btn btn-success btn-lg" id="btnSubmit">
                                                <i class="ri-check-double-line me-1"></i> Submit Registration
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vendor Scripts -->
    <script src="<?= base_url(); ?>assets/vendor/libs/popper/popper.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/js/bootstrap.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/libs/bs-stepper/bs-stepper.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/libs/select2/select2.js"></script>
    <script src="<?= base_url(); ?>assets/vendor/libs/sweetalert2/sweetalert2.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({ allowClear: true, width: '100%' });

            var stepper = new Stepper(document.querySelector('.bs-stepper'));

            function validateStep(step) {
                let isValid = true;
                step.find('input[required], select[required], textarea[required]').each(function() {
                    if (!$(this).val() || !$(this).val().trim()) {
                        $(this).addClass('is-invalid');
                        isValid = false;
                    } else {
                        $(this).removeClass('is-invalid').addClass('was-validated');
                    }
                });
                return isValid;
            }

            $('.btn-next-personal').click(function() {
                if (validateStep($('#personal-details-validation'))) {
                    stepper.next();
                }
            });

            $('.btn-prev').click(function() {
                stepper.previous();
            });

            $("#FP_BIRTHDAY").on("change input", function() {
                var dob = $(this).val();
                if (!dob) { $("#FP_AGE").val(""); return; }
                var today = new Date();
                var birthDate = new Date(dob);
                var age = today.getFullYear() - birthDate.getFullYear();
                if (today.getMonth() < birthDate.getMonth() || (today.getMonth() === birthDate.getMonth() && today.getDate() < birthDate.getDate())) {
                    age--;
                }
                $("#FP_AGE").val(age >= 0 ? age : "");
            });

            // Address cascading
            $('#FP_REGION').change(function() {
                if ($(this).val() != '') {
                    $.ajax({
                        url: "<?= base_url("FacultyprofController/LoadProvince"); ?>",
                        method: "POST",
                        dataType: 'json',
                        data: { regCode: $(this).val(), [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val() },
                        success: function(data) {
                            $('.txt_csrfname').val(data.token);
                            $('#FP_PROVINCE').html(data.output);
                        }
                    });
                }
            });

            $('#FP_PROVINCE').change(function() {
                if ($(this).val() != '') {
                    $.ajax({
                        url: "<?= base_url("FacultyprofController/LoadCity"); ?>",
                        method: "POST",
                        dataType: 'json',
                        data: { provCode: $(this).val(), [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val() },
                        success: function(data) {
                            $('.txt_csrfname').val(data.token);
                            $('#FP_MUNICIPALITY').html(data.output);
                        }
                    });
                }
            });

            $('#FP_MUNICIPALITY').change(function() {
                if ($(this).val() != '') {
                    $.ajax({
                        url: "<?= base_url("FacultyprofController/LoadBrgy"); ?>",
                        method: "POST",
                        dataType: 'json',
                        data: { citymunCode: $(this).val(), [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val() },
                        success: function(data) {
                            $('.txt_csrfname').val(data.token);
                            $('#FP_BRGY').html(data.output);
                        }
                    });
                }
            });

            $('#btnSubmit').click(function() {
                if (validateStep($('#education-details-validation'))) {
                    Swal.fire({
                        title: "Confirm Registration",
                        text: "Are you sure you want to submit your employee registration?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonText: "Yes, Submit",
                        customClass: { confirmButton: 'btn btn-primary', cancelButton: 'btn btn-secondary' },
                        buttonsStyling: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "<?= base_url('employee/register/save'); ?>",
                                type: "POST",
                                dataType: "json",
                                data: $('#wizardForm').serialize(),
                                success: function(data) {
                                    if (data.output === "Data has been saved.") {
                                        Swal.fire({
                                            title: "Registration Successful!",
                                            text: "Your employee profile has been registered successfully.",
                                            icon: "success",
                                            confirmButtonText: "OK",
                                            customClass: { confirmButton: 'btn btn-primary' },
                                            buttonsStyling: false
                                        }).then(() => {
                                            window.location.reload();
                                        });
                                    } else {
                                        Swal.fire({
                                            title: "Registration Error",
                                            text: data.output || "Error saving profile.",
                                            icon: "error",
                                            confirmButtonText: "OK",
                                            customClass: { confirmButton: 'btn btn-primary' },
                                            buttonsStyling: false
                                        });
                                    }
                                }
                            });
                        }
                    });
                }
            });
        });
    </script>
</body>
</html>
