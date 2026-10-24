<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Employee Profile</a>
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
                </div>
                <div class="bs-stepper-content">
                    <form id="wizardForm" class="needs-validation" onsubmit="return false" novalidate enctype="multipart/form-data">
                        <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                        <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <!-- personal-details-validation -->
                        <div id="personal-details-validation" class="content">
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Personal Background</h6>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="FP_LASTNAME" id="FP_LASTNAME" placeholder="Enter your Lastname" required />
                                        <label for="FP_LASTNAME">Last Name <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="FP_FIRSTNAME" id="FP_FIRSTNAME" placeholder="Enter your Firstname" required />
                                        <label for="FP_FIRSTNAME">First Name <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="FP_MIDDLENAME" id="FP_MIDDLENAME" placeholder="Enter your Middlename" />
                                        <label for="FP_MIDDLENAME">Middle Name</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select id="FP_SUFFIX" name="FP_SUFFIX" class="select2 form-select" data-allow-clear="true">
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
                                        <input type="date" class="form-control" required name="FP_BIRTHDAY" id="FP_BIRTHDAY" placeholder="Birthdate" max="<?= date('Y-m-d'); ?>" />
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
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Contact Details</h6>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input class="form-control" type="text" name="FP_CPNUMBER" placeholder="(+63) 000-0000" oninput="formatPhoneNumber(this)" required />
                                        <label for="basic-default-fullname">Contact # <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="email" class="form-control" name="FP_EMAIL" id="FP_EMAIL" placeholder="Enter your Email Address" />
                                        <label for="basic-default-fullname">Email Address </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" style="width: 100%;" name="FP_CIVILSTAT" required id="" data-allow-clear="true" required>
                                            <option value="">--Select--</option>
                                            <option>SINGLE</option>
                                            <option>MARRIED</option>
                                            <option>DIVORCED/SEPARETED</option>
                                            <option>WIDOWED/WIDOWER</option>
                                            <option>COMMON-LAW/LIVE-IN</option>
                                        </select>
                                        <label for="basic-default-fullname">Civil Status <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="FP_NATIONALITY" required id="FP_NATIONALITY" placeholder="Enter your Nationality" required />
                                        <label for="basic-default-fullname">Nationality <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" style="width: 100%;" name="FP_RELIGION" id="FP_RELIGION" required data-allow-clear="true" required>
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
                                        <label for="basic-default-fullname">Religion <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" style="width: 100%;" name="FP_TRIBE" id="FP_TRIBE" data-allow-clear="true" required>
                                            <option value="">--Select--</option>
                                            <?php
                                            foreach ($LoadTribes->result() as $r) {
                                            ?>
                                                <option><?= $r->IMS_TRIBES; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="basic-default-fullname">Ethnic Affilation/Tribe <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="content-header mb-4">
                                <h6 class="mb-0">Complete Address</h6>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" style="width: 100%;" name="FP_REGION" id="FP_REGION" data-allow-clear="true" required>
                                            <option value="">--Select--</option>
                                            <?php
                                            foreach ($LoadRegion->result() as $r) {
                                            ?>
                                                <option value="<?= $r->regCode; ?>"><?= $r->regDesc; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="basic-default-fullname">Region <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" style="width: 100%;" name="FP_PROVINCE" id="FP_PROVINCE" data-allow-clear="true" required>
                                            <option value="">--Select--</option>
                                        </select>
                                        <label for="basic-default-fullname">Province <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" style="width: 100%;" name="FP_MUNICIPALITY" id="FP_MUNICIPALITY" data-allow-clear="true" required>
                                            <option value="">--Select--</option>
                                        </select>
                                        <label for="basic-default-fullname">City/Municipality <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" style="width: 100%;" name="FP_BRGY" id="FP_BRGY" data-allow-clear="true" required>
                                            <option value="">--Select--</option>
                                        </select>
                                        <label for="basic-default-fullname">Barangay <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="FP_STRT" id="FP_STRT" required placeholder="Enter Streets" />
                                        <label for="basic-default-fullname">Street </span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="FP_ZCODE" required maxlength="4" id="FP_ZCODE" placeholder="Enter your Zip Code" required />
                                        <label for="basic-default-fullname">Zip Code <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row mb-5">
                                <div class="col-md-6">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th class="text-center">Take a Picture</th>
                                        </tr>
                                        <tr>
                                            <td class="text-center">
                                                <button type="button" class="btn btn-primary" id="btnCamera" data-bs-toggle="modal" data-bs-target="#cameraModal">Open Camera</button>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <input type="hidden" name="capturedImage" id="capturedImageData">
                                    <div id="showPicture"></div>
                                </div>
                            </div> -->
                            <div class="row">
                                <div class="col-12 d-flex gap-2 justify-content-end">
                                    <button class="btn btn-outline-secondary btn-prev">
                                        <i class="ri-arrow-left-line me-sm-1 me-0"></i>
                                        <span class="align-middle d-sm-inline-block d-none">Previous</span>
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
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select id="FP_EMPLOYEETYPE" name="FP_EMPLOYEETYPE" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--Select--</option>
                                            <option>TEACHING</option>
                                            <option>NON-TEACHING</option>
                                        </select>
                                        <label for="">Employee Type</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select id="FP_FULLTIME" name="FP_FULLTIME" class="select2 form-select" data-allow-clear="true">
                                            <option value="">--Select--</option>
                                            <option>FULL-TIME</option>
                                            <option>PART-TIME</option>
                                        </select>
                                        <label for="">Teaching Status</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select id="FP_HIGHDEGREE" name="FP_HIGHDEGREE" class="select2 form-select" required data-allow-clear="true">
                                            <option value="">--Select--</option>
                                            <option>PRIMARY</option>
                                            <option>SECONDARY</option>
                                            <option>TERTIARY</option>
                                            <option>MASTERS</option>
                                            <option>DOCTORATE</option>
                                        </select>
                                        <label for="">Highest Degree Attainment <span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="FP_BDEGREE" id="FP_BDEGREE" placeholder="Enter Bachelors Degree" required />
                                        <label for="basic-default-fullname">Specific Discipline of Bachelors Degree<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="FP_MDEGREE" id="FP_MDEGREE" placeholder="Enter Masters Degree" />
                                        <label for="basic-default-fullname">Specific Discipline of Masters Degree(Optional)</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="FP_DDEGRE" id="FP_DDEGRE" placeholder="Enter Doctorate Degree" />
                                        <label for="basic-default-fullname">Specific Discipline of Doctorate Degree(Optional)</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="FP_PLICENSE" id="FP_PLICENSE" aria-label="Default select example" required>
                                            <option value="">--Select--</option>
                                            <?php
                                            foreach ($LoadProfLicense->result() as $r) {
                                            ?>
                                                <option><?= $r->REF_DESC; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="basic-default-fullname">Professional License<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="FP_TENURE" id="FP_TENURE" aria-label="Default select example" required>
                                            <option value="">--Select--</option>
                                            <?php
                                            foreach ($LoadTenure->result() as $r) {
                                            ?>
                                                <option><?= $r->REF_DESC; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="basic-default-fullname">Tenure of Employment<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="FP_FACRANK" id="FP_FACRANK" aria-label="Default select example" required>
                                            <option value="">--Select--</option>
                                            <!-- ===================== -->
                                            <!--   ACADEMIC OFFICIALS  -->
                                            <!-- ===================== -->
                                            <option>PRESIDENT</option>
                                            <option>VICE PRESIDENT FOR ACADEMIC AFFAIRS</option>
                                            <option>DEAN</option>
                                            <option>ASSISTANT DEAN</option>
                                            <option>PROGRAM HEAD</option>
                                            <option>COORDINATOR</option>
                                            <option>RESEARCH DIRECTOR</option>
                                            <option>TRAINING DIRECTOR</option>
                                            <option>RESEARCH COORDINATOR</option>
                                            <option>EXTENSION COORDINATOR</option>
                                            <option>QUALITY ASSURANCE COORDINATOR</option>
                                            <option>SCHOOL ADMINISTRATOR</option>
                                            <option>CAMPUS DIRECTOR</option>
                                            <option>CAMPUS SECRETARY</option>

                                            <!-- ===================== -->
                                            <!--    TEACHING POSITIONS -->
                                            <!-- ===================== -->
                                            <option>INSTRUCTOR I</option>
                                            <option>INSTRUCTOR II</option>
                                            <option>INSTRUCTOR III</option>
                                            <option>INSTRUCTOR IV</option>
                                            <option>INSTRUCTOR V</option>

                                            <option>PROFESSOR I</option>
                                            <option>PROFESSOR II</option>
                                            <option>PROFESSOR III</option>
                                            <option>PROFESSOR IV</option>
                                            <option>PROFESSOR V</option>

                                            <!-- ===================== -->
                                            <!-- ADMINISTRATIVE OFFICIALS -->
                                            <!-- ===================== -->
                                            <option>VICE PRESIDENT FOR ADMINISTRATION & FINANCE</option>
                                            <option>EXECUTIVE ASSISTANT</option>
                                            <option>COLLEGE SECRETARY</option>
                                            <option>REGISTRAR</option>
                                            <option>REGISTRAR STAFF</option>
                                            <option>FOCAL PERSON</option>
                                            <option>GAD FOCAL PERSON / CLERK</option>
                                            <option>PROCUREMENT OFFICER</option>
                                            <option>INTERNAL AUDITOR</option>
                                            <option>HUMAN RESOURCE OFFICER</option>
                                            <option>HR ASSISTANT</option>
                                            <option>PLANNING OFFICER</option>
                                            <option>MIS OFFICER</option>
                                            <option>IT SUPPORT STAFF</option>
                                            <option>GUIDANCE COUNSELOR</option>
                                            <option>GUIDANCE STAFF</option>
                                            <option>STUDENT AFFAIRS COORDINATOR</option>
                                            <option>OSA STAFF</option>
                                            <option>SCHOLARSHIP COORDINATOR</option>

                                            <!-- ===================== -->
                                            <!-- ADMIN / FINANCE STAFF -->
                                            <!-- ===================== -->
                                            <option>BUDGET OFFICER</option>
                                            <option>BUDGET STAFF</option>
                                            <option>CASHIER</option>
                                            <option>CASH CLERK</option>

                                            <option>ACCOUNTING OFFICER</option>
                                            <option>ACCOUNTING STAFF</option>
                                            <option>CHIEF ACCOUNTANT</option>
                                            <option>BOOKKEEPER</option>

                                            <option>SUPPLY OFFICER</option>
                                            <option>SUPPLY CLERK</option>

                                            <option>ADMINISTRATIVE OFFICER I</option>
                                            <option>ADMINISTRATIVE OFFICER II</option>
                                            <option>ASSISTANT ADMINISTRATIVE OFFICER I</option>
                                            <option>ADMINISTRATIVE ASSISTANT I</option>
                                            <option>ADMINISTRATIVE ASSISTANT II</option>
                                            <option>ADMINISTRATIVE AIDE I</option>
                                            <option>ADMINISTRATIVE AIDE II</option>
                                            <option>OFFICE STAFF</option>
                                            <option>RECORDS OFFICER</option>
                                            <option>RECORDS CLERK</option>
                                            <option>LIBRARIAN</option>
                                            <option>ASSISTANT LIBRARIAN</option>

                                            <!-- ===================== -->
                                            <!-- SUPPORT STAFF / NON-TEACHING -->
                                            <!-- ===================== -->
                                            <option>PROPERTY CUSTODIAN</option>
                                            <option>CHIEF SECURITY OFFICER</option>
                                            <option>SECURITY OFFICER</option>
                                            <option>SECURITY GUARD</option>
                                            <option>DISCIPLINE OFFICER</option>
                                            <option>DRIVER</option>
                                            <option>JANITOR</option>
                                            <option>UTILITY PERSONNEL</option>
                                            <option>MAINTENANCE PERSONNEL</option>

                                            <option>SCHOOL NURSE</option>
                                            <option>SCHOOL DOCTOR</option>

                                            <option>LABORATORY TECHNICIAN</option>
                                            <option>LABORATORY ASSISTANT</option>

                                        </select>
                                        <label for="basic-default-fullname">Rank/Designation<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="FP_ASALARY" id="FP_ASALARY" aria-label="Default select example" required>
                                            <option value="">--Select--</option>
                                            <?php
                                            foreach ($LoadAnnualSalary->result() as $r) {
                                            ?>
                                                <option><?= $r->REF_DESC; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="basic-default-fullname">Annual Salary<span class="text-danger">*</span></label>
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
                                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Add School Attainment</span>
                                            <i class="ri-add-line"></i>
                                        </button>
                                        <button type="submit" class="btn btn-success" id="btnSubmit">
                                            <span class="align-middle d-sm-inline-block d-none me-sm-1">Submit</span>
                                            <i class="ri-arrow-right-line"></i>
                                        </button>
                                    </div>
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
                <button type="button" class="btn-close" id="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
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
    $(document).ready(function() {
        function reinitializeSelect2(element) {
            if (element.length) {
                element.select2({
                    placeholder: "Select an option",
                    allowClear: true
                });
            }
        }

        function addEducationItem() {
            $.ajax({
                url: "<?= base_url('FacultyprofController/FetchEducationAttainment'); ?>",
                type: "POST",
                dataType: "json",
                data: {
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                },
                success: function(data) {
                    $('.txt_csrfname').val(data.token);
                    $(".education-container").append(data.output);
                    reinitializeSelect2($(".education-container").find('.select2'));
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", status, error);
                }
            });
        }

        $(".btn-add-school").click(function() {
            addEducationItem();
        });

        $(document).on("change", ".education-container .select2", function() {
            let selectedValue = $(this).val();
            let textElement = $(this).closest('.education-item').find(".textEducAttainment");
            textElement.text(selectedValue ? `(${selectedValue})` : "(--please select--)");

            let courseField = $(this).closest('.education-item').find(".showCourseTaken");
            let programInput = $(this).closest('.education-item').find(".EDUC_PROGRAM");

            if (selectedValue === "College") {
                courseField.removeClass("d-none");
                programInput.prop({
                    required: true,
                    disabled: false
                });
            } else {
                courseField.addClass("d-none");
                programInput.prop({
                    required: false,
                    disabled: true
                });
            }
        });

        $(document).on("click", ".btn-delete-school", function() {
            $(this).closest('.education-item').remove();
        });

        // Initialize Select2 for existing elements
        reinitializeSelect2($(".education-container").find('.select2'));

        // Stepper Form Logic
        var stepper = new Stepper(document.querySelector('.bs-stepper'));

        function validateStep(step) {
            let isValid = true;
            step.find('input, select, textarea').each(function() {
                if ($(this).prop('required') && !$(this).val().trim()) {
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

        $('#btnSubmit').click(function() {
            if (validateStep($('#education-details-validation'))) {
                showConfirmationDialog();
            }
        });

        function showConfirmationDialog() {
            Swal.fire({
                title: "Are you sure?",
                text: "Once submitted, faculty profile will be saved!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, submit it!",
                cancelButtonText: "Cancel",
                buttonsStyling: false,
            }).then((result) => {
                if (result.isConfirmed) {
                    submitForm();
                }
            });
        }

        function submitForm() {
            $.ajax({
                url: "<?= base_url('FacultyprofController/saveFP'); ?>",
                type: "POST",
                dataType: "json",
                data: $('#wizardForm').serialize(),
                success: function(data) {
                    if (data.output === "Data has been saved.") {
                        Swal.fire({
                            title: "Success!",
                            text: data.output,
                            icon: "success",
                            buttonsStyling: false,
                        }).then(() => {
                            window.location.href = "<?= base_url('ims/facultyprof'); ?>";
                        });
                    } else {
                        Swal.fire({
                            title: "Error!",
                            text: data.output,
                            icon: "error",
                            buttonsStyling: false,
                        });
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Submit Error: ", status, error);
                }
            });
        }
    });
</script>

<script>
    $(document).ready(function() {
        // Attach an event listener to the date input
        $("#FP_BIRTHDAY").on("change input", function() {
            var dob = $(this).val();
            if (!dob) {
                $("#FP_AGE").val("");
                return;
            }
            var today = new Date();
            var birthDate = new Date(dob);
            var age = today.getFullYear() - birthDate.getFullYear();

            if (today.getMonth() < birthDate.getMonth() || (today.getMonth() === birthDate.getMonth() && today.getDate() < birthDate.getDate())) {
                age--;
            }

            $("#FP_AGE").val(age >= 0 ? age : "");
        });
    });
</script>

<!-- FOR ADDRESS SELECT DYNAMIC -PERSONAL DATA  -->
<script>
    $(document).ready(function() {
        // Event listener for region selection
        $('#FP_REGION').change(function() {
            // Add your code to load province options based on the selected region
            if ($(this).val() != '') {
                var regCode = $(this).val();
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // Value specified in $config['csrf_token_name']
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                $.ajax({
                    url: "<?= base_url("FacultyprofController/LoadProvince"); ?>",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        regCode: regCode,
                        [csrfName]: csrfHash
                    },
                    success: function(data) {
                        // Update CSRF hash
                        $('.txt_csrfname').val(data.token);
                        $('#FP_PROVINCE').html(data.output);
                    },
                    error: function(jqXHR, errorType, error) {
                        alert(error);
                    }
                });
            }
        });
        // Event listener for province selection
        $('#FP_PROVINCE').change(function() {
            // Add your code to load city/municipality options based on the selected province
            if ($(this).val() != '') {
                var provCode = $(this).val();
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // Value specified in $config['csrf_token_name']
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                $.ajax({
                    url: "<?= base_url("FacultyprofController/LoadCity"); ?>",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        provCode: provCode,
                        [csrfName]: csrfHash
                    },
                    success: function(data) {
                        // Update CSRF hash
                        $('.txt_csrfname').val(data.token);
                        $('#FP_MUNICIPALITY').html(data.output);

                    },
                    error: function(jqXHR, errorType, error) {
                        alert(error);
                    }
                });
            }
        });
        // Event listener for city/municipality selection
        $('#FP_MUNICIPALITY').change(function() {
            // Add your code to load barangay options based on the selected city/municipality
            if ($(this).val() != '') {
                var citymunCode = $(this).val();
                // CSRF Hash
                var csrfName = $('.txt_csrfname').attr('name'); // Value specified in $config['csrf_token_name']
                var csrfHash = $('.txt_csrfname').val(); // CSRF hash
                $.ajax({
                    url: "<?= base_url("FacultyprofController/LoadBrgy"); ?>",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        citymunCode: citymunCode,
                        [csrfName]: csrfHash
                    },
                    success: function(data) {
                        // Update CSRF hash
                        $('.txt_csrfname').val(data.token);
                        $('#FP_BRGY').html(data.output);

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

<!-- WEBCAM SCRIPT -->
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

        $('#takephoto').on('click', take_snapshot);
    })

    function take_snapshot() {
        //take snapshot and get image data
        Webcam.snap(function(data_uri) {
            //display result image
            $('#showPicture').html('<img src="' + data_uri + '" class="d-block mx-auto rounded"/>');
            var raw_image_data = data_uri.replace(/^data\:image\/\w+\;base64\,/, '');
            $('#capturedImageData').val(raw_image_data);
        });
        Webcam.reset();
        $('#cameraModal').modal('hide');
    }

    $("#closeModal").click(function() {
        Webcam.reset();
    });
</script>