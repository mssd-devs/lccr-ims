<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Employee Profile</a>
            </li>
            <li class="breadcrumb-item active">Edit</li>
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
                                    <span class="bs-stepper-subtitle">Edit personal info</span>
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
                                    <span class="bs-stepper-subtitle">Edit educational background</span>
                                </span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="bs-stepper-content">
                    <?php
                    if ($FetchFacultyProfile->num_rows() > 0) {
                        foreach ($FetchFacultyProfile->result() as $rows) {
                    ?>
                            <form id="wizardForm" class="needs-validation" onsubmit="return false" novalidate enctype="multipart/form-data">
                                <input type="hidden" name="FP_TRANSID" value="<?= $rows->FP_TRANSID; ?>">
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
                                                <input type="text" class="form-control" name="FP_LASTNAME" value="<?= $rows->FP_LASTNAME; ?>" id="FP_LASTNAME" placeholder="Enter your Lastname" readonly required />
                                                <label for="FP_LASTNAME">Last Name <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="text" class="form-control" name="FP_FIRSTNAME" id="FP_FIRSTNAME" value="<?= $rows->FP_FIRSTNAME; ?>" placeholder="Enter your Firstname" readonly required />
                                                <label for="FP_FIRSTNAME">First Name <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="text" class="form-control" name="FP_MIDDLENAME" value="<?= $rows->FP_MIDDLENAME; ?>" id="FP_MIDDLENAME" placeholder="Enter your Middlename" readonly />
                                                <label for="FP_MIDDLENAME">Middle Name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <select id="FP_SUFFIX" name="FP_SUFFIX" class="select2 form-select" data-allow-clear="true">
                                                    <option value="">--Select--</option>
                                                    <option <?= $rows->FP_SUFFIX == "JR" ? "selected" : "" ?>>JR</option>
                                                    <option <?= $rows->FP_SUFFIX == "SR" ? "selected" : "" ?>>SR</option>
                                                    <option <?= $rows->FP_SUFFIX == "I" ? "selected" : "" ?>>I</option>
                                                    <option <?= $rows->FP_SUFFIX == "II" ? "selected" : "" ?>>II</option>
                                                    <option <?= $rows->FP_SUFFIX == "III" ? "selected" : "" ?>>III</option>
                                                    <option <?= $rows->FP_SUFFIX == "IV" ? "selected" : "" ?>>IV</option>
                                                    <option <?= $rows->FP_SUFFIX == "V" ? "selected" : "" ?>>V</option>
                                                    <option <?= $rows->FP_SUFFIX == "VI" ? "selected" : "" ?>>VI</option>
                                                    <option <?= $rows->FP_SUFFIX == "VII" ? "selected" : "" ?>>VII</option>
                                                    <option <?= $rows->FP_SUFFIX == "VIII" ? "selected" : "" ?>>VIII</option>
                                                </select>
                                                <label for="FP_SUFFIX">Suffix</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <select id="" name="FP_GENDER" class="select2 form-select" required data-allow-clear="true">
                                                    <option value="">--Select--</option>
                                                    <option <?= $rows->FP_GENDER == "MALE" ? "selected" : "" ?>>MALE</option>
                                                    <option <?= $rows->FP_GENDER == "FEMALE" ? "selected" : "" ?>>FEMALE</option>
                                                </select>
                                                <label for="">Gender <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="date" class="form-control" required readonly name="FP_BIRTHDAY" id="FP_BIRTHDAY" value="<?= $rows->FP_BIRTHDAY ?>" placeholder="Birthdate" max="<?= date('Y-m-d'); ?>" />
                                                <label for="basic-default-fullname">Date of Birth <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="text" class="form-control" name="FP_AGE" readonly id="FP_AGE" placeholder="Age" value="<?= calculate_age($rows->FP_BIRTHDAY); ?>" />
                                                <label for="basic-default-fullname">Age</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="content-header mb-4">
                                        <h6 class="mb-0">Contact Details</h6>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input class="form-control" type="text" name="FP_CPNUMBER" value="<?= $rows->FP_CPNUMBER; ?>" placeholder="(+63) 000-0000" oninput="formatPhoneNumber(this)" required />
                                                <label for="basic-default-fullname">Contact # <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="email" class="form-control" name="FP_EMAIL" value="<?= $rows->FP_EMAIL; ?>" id="FP_EMAIL" placeholder="Enter your Email Address" />
                                                <label for="basic-default-fullname">Email Address </label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <select class="form-select select2" style="width: 100%;" name="FP_CIVILSTAT" required id="" data-allow-clear="true" required>
                                                    <option value="">--Select--</option>
                                                    <option <?= $rows->FP_CIVILSTAT == "SINGLE" ? "selected" : "" ?>>SINGLE</option>
                                                    <option <?= $rows->FP_CIVILSTAT == "MARRIED" ? "selected" : "" ?>>MARRIED</option>
                                                    <option <?= $rows->FP_CIVILSTAT == "DIVORCED/SEPARETED" ? "selected" : "" ?>>DIVORCED/SEPARETED</option>
                                                    <option <?= $rows->FP_CIVILSTAT == "WIDOWED/WIDOWER" ? "selected" : "" ?>>WIDOWED/WIDOWER</option>
                                                    <option <?= $rows->FP_CIVILSTAT == "COMMON-LAW/LIVE-IN" ? "selected" : "" ?>>COMMON-LAW/LIVE-IN</option>
                                                </select>
                                                <label for="basic-default-fullname">Civil Status <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="text" class="form-control" name="FP_NATIONALITY" value="<?= $rows->FP_NATIONALITY; ?>" required id="FP_NATIONALITY" placeholder="Enter your Nationality" required />
                                                <label for="basic-default-fullname">Nationality <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <select class="form-select select2" style="width: 100%;" name="FP_RELIGION" id="FP_RELIGION" required data-allow-clear="true" required>
                                                    <option value="">--Select--</option>
                                                    <option <?= $rows->FP_RELIGION == "ISLAM" ? "selected" : "" ?>>ISLAM</option>
                                                    <option <?= $rows->FP_RELIGION == "CHRISTIANITY" ? "selected" : "" ?>>CHRISTIANITY</option>
                                                    <option <?= $rows->FP_RELIGION == "BUDDHISM" ? "selected" : "" ?>>BUDDHISM</option>
                                                    <option <?= $rows->FP_RELIGION == "HINDUISM" ? "selected" : "" ?>>HINDUISM</option>
                                                    <option <?= $rows->FP_RELIGION == "JUDAISM" ? "selected" : "" ?>>JUDAISM</option>
                                                    <option <?= $rows->FP_RELIGION == "JAINISM" ? "selected" : "" ?>>JAINISM</option>
                                                    <option <?= $rows->FP_RELIGION == "IRRELIGIOUS AND ATHEISTS" ? "selected" : "" ?>>IRRELIGIOUS AND ATHEISTS</option>
                                                    <option <?= $rows->FP_RELIGION == "SIKHISM" ? "selected" : "" ?>>SIKHISM</option>
                                                    <option <?= $rows->FP_RELIGION == "ZOROASTRIANISM" ? "selected" : "" ?>>ZOROASTRIANISM</option>
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
                                                        <option <?= $rows->FP_TRIBE == $r->IMS_TRIBES ? "selected" : "" ?>><?= $r->IMS_TRIBES; ?></option>
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
                                                        <option <?php if ($r->regCode == $rows->FP_REGION) {
                                                                    echo "selected";
                                                                } ?> value="<?= $r->regCode; ?>"><?= $r->regDesc; ?></option>
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
                                                    <?php
                                                    $prov = $this->db->where("regCode", $rows->FP_REGION)->get("refprovince");
                                                    if ($prov->num_rows() > 0) {
                                                        foreach ($prov->result() as $r) {
                                                    ?>
                                                            <option <?php if ($r->provCode == $rows->FP_PROVINCE) {
                                                                        echo "selected";
                                                                    } ?> value="<?= $r->provCode; ?>"><?= $r->provDesc; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <label for="basic-default-fullname">Province <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <select class="form-select select2" style="width: 100%;" name="FP_MUNICIPALITY" id="FP_MUNICIPALITY" data-allow-clear="true" required>
                                                    <option value="">--Select--</option>
                                                    <?php
                                                    $city = $this->db->where("provCode", $rows->FP_PROVINCE)->get("refcitymun");
                                                    if ($city->num_rows() > 0) {
                                                        foreach ($city->result() as $r) {
                                                    ?>
                                                            <option <?php if ($r->citymunCode == $rows->FP_MUNICIPALITY) {
                                                                        echo "selected";
                                                                    } ?> value="<?= $r->citymunCode; ?>"><?= $r->citymunDesc; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <label for="basic-default-fullname">City/Municipality <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <select class="form-select select2" style="width: 100%;" name="FP_BRGY" id="FP_BRGY" data-allow-clear="true" required>
                                                    <option value="">--Select--</option>
                                                    <?php
                                                    $brgy = $this->db->where("citymunCode", $rows->FP_MUNICIPALITY)->get("refbrgy");
                                                    if ($brgy->num_rows() > 0) {
                                                        foreach ($brgy->result() as $r) {
                                                    ?>
                                                            <option <?php if ($r->brgyCode == $rows->FP_BRGY) {
                                                                        echo "selected";
                                                                    } ?> value="<?= $r->brgyCode; ?>"><?= $r->brgyDesc; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                                <label for="basic-default-fullname">Barangay <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="text" class="form-control" name="FP_STRT" id="FP_STRT" value="<?= $rows->FP_STRT; ?>" required placeholder="Enter Streets" />
                                                <label for="basic-default-fullname">Street </span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="text" class="form-control" name="FP_ZCODE" value="<?= $rows->FP_ZCODE; ?>" required maxlength="4" id="FP_ZCODE" placeholder="Enter your Zip Code" required />
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
                                                    <option <?= $rows->FP_EMPLOYEETYPE == "TEACHING" ? "selected" : "" ?>>TEACHING</option>
                                                    <option <?= $rows->FP_EMPLOYEETYPE == "NON-TEACHING" ? "selected" : "" ?>>NON-TEACHING</option>
                                                </select>
                                                <label for="">Teaching Status</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <select id="FP_FULLTIME" name="FP_FULLTIME" class="select2 form-select" data-allow-clear="true">
                                                    <option value="">--Select--</option>
                                                    <option <?= $rows->FP_FULLTIME == "FULL-TIME" ? "selected" : "" ?>>FULL-TIME</option>
                                                    <option <?= $rows->FP_FULLTIME == "PART-TIME" ? "selected" : "" ?>>PART-TIME</option>
                                                </select>
                                                <label for="">Teaching Status</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <select id="FP_HIGHDEGREE" name="FP_HIGHDEGREE" class="select2 form-select" required data-allow-clear="true">
                                                    <option value="">--Select--</option>
                                                    <option <?= $rows->FP_HIGHDEGREE == "PRIMARY" ? "selected" : "" ?>>PRIMARY</option>
                                                    <option <?= $rows->FP_HIGHDEGREE == "SECONDARY" ? "selected" : "" ?>>SECONDARY</option>
                                                    <option <?= $rows->FP_HIGHDEGREE == "TERTIARY" ? "selected" : "" ?>>TERTIARY</option>
                                                    <option <?= $rows->FP_HIGHDEGREE == "MASTERS" ? "selected" : "" ?>>MASTERS</option>
                                                    <option <?= $rows->FP_HIGHDEGREE == "DOCTORATE" ? "selected" : "" ?>>DOCTORATE</option>
                                                </select>
                                                <label for="">Highest Degree Attainment <span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="text" class="form-control" name="FP_BDEGREE" id="FP_BDEGREE" value="<?= $rows->FP_BDEGREE ?>" placeholder="Enter Bachelors Degree" required />
                                                <label for="basic-default-fullname">Specific Discipline of Bachelors Degree<span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="text" class="form-control" name="FP_MDEGREE" id="FP_MDEGREE" value="<?= $rows->FP_MDEGREE ?>" placeholder="Enter Masters Degree" />
                                                <label for="basic-default-fullname">Specific Discipline of Masters Degree(Optional)</label>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-floating form-floating-outline mb-4">
                                                <input type="text" class="form-control" name="FP_DDEGRE" id="FP_DDEGRE" value="<?= $rows->FP_DDEGRE ?>" placeholder="Enter Doctorate Degree" />
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
                                                        <option <?php if ($r->REF_DESC == $rows->FP_PLICENSE) {
                                                                    echo "selected";
                                                                } ?> value="<?= $r->REF_DESC; ?>"><?= $r->REF_DESC; ?></option>
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
                                                        <option <?php if ($r->REF_DESC == $rows->FP_TENURE) {
                                                                    echo "selected";
                                                                } ?> value="<?= $r->REF_DESC; ?>"><?= $r->REF_DESC; ?></option>
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

                                                    <!-- ============================= -->
                                                    <!--        ACADEMIC OFFICIALS     -->
                                                    <!-- ============================= -->
                                                    <option <?= $rows->FP_FACRANK == "PRESIDENT" ? "selected" : "" ?>>PRESIDENT</option>
                                                    <option <?= $rows->FP_FACRANK == "VICE PRESIDENT FOR ACADEMIC AFFAIRS" ? "selected" : "" ?>>VICE PRESIDENT FOR ACADEMIC AFFAIRS</option>
                                                    <option <?= $rows->FP_FACRANK == "VICE PRESIDENT FOR ADMIN & FINANCE" ? "selected" : "" ?>>VICE PRESIDENT FOR ADMIN & FINANCE</option>
                                                    <option <?= $rows->FP_FACRANK == "CAMPUS DIRECTOR" ? "selected" : "" ?>>CAMPUS DIRECTOR</option>
                                                    <option <?= $rows->FP_FACRANK == "DEAN" ? "selected" : "" ?>>DEAN</option>
                                                    <option <?= $rows->FP_FACRANK == "ASSISTANT DEAN" ? "selected" : "" ?>>ASSISTANT DEAN</option>
                                                    <option <?= $rows->FP_FACRANK == "PROGRAM HEAD" ? "selected" : "" ?>>PROGRAM HEAD</option>
                                                    <option <?= $rows->FP_FACRANK == "COLLEGE SECRETARY" ? "selected" : "" ?>>COLLEGE SECRETARY</option>
                                                    <option <?= $rows->FP_FACRANK == "REGISTRAR" ? "selected" : "" ?>>REGISTRAR</option>
                                                    <option <?= $rows->FP_FACRANK == "CAMPUS SECRETARY" ? "selected" : "" ?>>CAMPUS SECRETARY</option>

                                                    <!-- ============================= -->
                                                    <!--        TEACHING POSITIONS     -->
                                                    <!-- ============================= -->
                                                    <option <?= $rows->FP_FACRANK == "INSTRUCTOR I" ? "selected" : "" ?>>INSTRUCTOR I</option>
                                                    <option <?= $rows->FP_FACRANK == "INSTRUCTOR II" ? "selected" : "" ?>>INSTRUCTOR II</option>
                                                    <option <?= $rows->FP_FACRANK == "INSTRUCTOR III" ? "selected" : "" ?>>INSTRUCTOR III</option>
                                                    <option <?= $rows->FP_FACRANK == "INSTRUCTOR IV" ? "selected" : "" ?>>INSTRUCTOR IV</option>
                                                    <option <?= $rows->FP_FACRANK == "INSTRUCTOR V" ? "selected" : "" ?>>INSTRUCTOR V</option>
                                                    <option <?= $rows->FP_FACRANK == "PROFESSOR I" ? "selected" : "" ?>>PROFESSOR I</option>
                                                    <option <?= $rows->FP_FACRANK == "PROFESSOR II" ? "selected" : "" ?>>PROFESSOR II</option>
                                                    <option <?= $rows->FP_FACRANK == "PROFESSOR III" ? "selected" : "" ?>>PROFESSOR III</option>
                                                    <option <?= $rows->FP_FACRANK == "PROFESSOR IV" ? "selected" : "" ?>>PROFESSOR IV</option>
                                                    <option <?= $rows->FP_FACRANK == "PROFESSOR V" ? "selected" : "" ?>>PROFESSOR V</option>
                                                    <option <?= $rows->FP_FACRANK == "RESEARCH COORDINATOR" ? "selected" : "" ?>>RESEARCH COORDINATOR</option>
                                                    <option <?= $rows->FP_FACRANK == "EXTENSION COORDINATOR" ? "selected" : "" ?>>EXTENSION COORDINATOR</option>
                                                    <option <?= $rows->FP_FACRANK == "QUALITY ASSURANCE COORDINATOR" ? "selected" : "" ?>>QUALITY ASSURANCE COORDINATOR</option>

                                                    <!-- ============================= -->
                                                    <!--      ADMINISTRATIVE STAFF     -->
                                                    <!-- ============================= -->
                                                    <option <?= $rows->FP_FACRANK == "EXECUTIVE ASSISTANT" ? "selected" : "" ?>>EXECUTIVE ASSISTANT</option>
                                                    <option <?= $rows->FP_FACRANK == "HUMAN RESOURCE OFFICER" ? "selected" : "" ?>>HUMAN RESOURCE OFFICER</option>
                                                    <option <?= $rows->FP_FACRANK == "PLANNING OFFICER" ? "selected" : "" ?>>PLANNING OFFICER</option>
                                                    <option <?= $rows->FP_FACRANK == "MIS OFFICER" ? "selected" : "" ?>>MIS OFFICER</option>
                                                    <option <?= $rows->FP_FACRANK == "IT SUPPORT STAFF" ? "selected" : "" ?>>IT SUPPORT STAFF</option>
                                                    <option <?= $rows->FP_FACRANK == "SCHOOL ADMINISTRATOR" ? "selected" : "" ?>>SCHOOL ADMINISTRATOR</option>
                                                    <option <?= $rows->FP_FACRANK == "BUDGET OFFICER" ? "selected" : "" ?>>BUDGET OFFICER</option>
                                                    <option <?= $rows->FP_FACRANK == "CASHIER" ? "selected" : "" ?>>CASHIER</option>
                                                    <option <?= $rows->FP_FACRANK == "CHIEF ACCOUNTANT" ? "selected" : "" ?>>CHIEF ACCOUNTANT</option>
                                                    <option <?= $rows->FP_FACRANK == "ACCOUNTING OFFICER" ? "selected" : "" ?>>ACCOUNTING OFFICER</option>
                                                    <option <?= $rows->FP_FACRANK == "ACCOUNTING STAFF" ? "selected" : "" ?>>ACCOUNTING STAFF</option>
                                                    <option <?= $rows->FP_FACRANK == "BOOKKEEPER" ? "selected" : "" ?>>BOOKKEEPER</option>
                                                    <option <?= $rows->FP_FACRANK == "PROCUREMENT OFFICER" ? "selected" : "" ?>>PROCUREMENT OFFICER</option>
                                                    <option <?= $rows->FP_FACRANK == "INTERNAL AUDITOR" ? "selected" : "" ?>>INTERNAL AUDITOR</option>
                                                    <option <?= $rows->FP_FACRANK == "SUPPLY OFFICER" ? "selected" : "" ?>>SUPPLY OFFICER</option>
                                                    <option <?= $rows->FP_FACRANK == "SUPPLY CLERK" ? "selected" : "" ?>>SUPPLY CLERK</option>
                                                    <option <?= $rows->FP_FACRANK == "PROPERTY CUSTODIAN" ? "selected" : "" ?>>PROPERTY CUSTODIAN</option>
                                                    <option <?= $rows->FP_FACRANK == "RECORDS OFFICER" ? "selected" : "" ?>>RECORDS OFFICER</option>
                                                    <option <?= $rows->FP_FACRANK == "RECORDS CLERK" ? "selected" : "" ?>>RECORDS CLERK</option>
                                                    <option <?= $rows->FP_FACRANK == "ADMINISTRATIVE OFFICER I" ? "selected" : "" ?>>ADMINISTRATIVE OFFICER I</option>
                                                    <option <?= $rows->FP_FACRANK == "ADMINISTRATIVE OFFICER II" ? "selected" : "" ?>>ADMINISTRATIVE OFFICER II</option>
                                                    <option <?= $rows->FP_FACRANK == "ASSISTANT ADMINISTRATIVE OFFICER I" ? "selected" : "" ?>>ASSISTANT ADMINISTRATIVE OFFICER I</option>
                                                    <option <?= $rows->FP_FACRANK == "ADMINISTRATIVE ASSISTANT I" ? "selected" : "" ?>>ADMINISTRATIVE ASSISTANT I</option>
                                                    <option <?= $rows->FP_FACRANK == "ADMINISTRATIVE ASSISTANT II" ? "selected" : "" ?>>ADMINISTRATIVE ASSISTANT II</option>
                                                    <option <?= $rows->FP_FACRANK == "ADMINISTRATIVE AIDE I" ? "selected" : "" ?>>ADMINISTRATIVE AIDE I</option>
                                                    <option <?= $rows->FP_FACRANK == "ADMINISTRATIVE AIDE II" ? "selected" : "" ?>>ADMINISTRATIVE AIDE II</option>

                                                    <!-- ============================= -->
                                                    <!--         SUPPORT STAFF          -->
                                                    <!-- ============================= -->
                                                    <option <?= $rows->FP_FACRANK == "GUIDANCE COUNSELOR" ? "selected" : "" ?>>GUIDANCE COUNSELOR</option>
                                                    <option <?= $rows->FP_FACRANK == "GUIDANCE STAFF" ? "selected" : "" ?>>GUIDANCE STAFF</option>
                                                    <option <?= $rows->FP_FACRANK == "LIBRARIAN" ? "selected" : "" ?>>LIBRARIAN</option>
                                                    <option <?= $rows->FP_FACRANK == "ASSISTANT LIBRARIAN" ? "selected" : "" ?>>ASSISTANT LIBRARIAN</option>
                                                    <option <?= $rows->FP_FACRANK == "REGISTRAR STAFF" ? "selected" : "" ?>>REGISTRAR STAFF</option>
                                                    <option <?= $rows->FP_FACRANK == "BUDGET STAFF" ? "selected" : "" ?>>BUDGET STAFF</option>
                                                    <option <?= $rows->FP_FACRANK == "HR ASSISTANT" ? "selected" : "" ?>>HR ASSISTANT</option>
                                                    <option <?= $rows->FP_FACRANK == "OFFICE STAFF" ? "selected" : "" ?>>OFFICE STAFF</option>
                                                    <option <?= $rows->FP_FACRANK == "OSA STAFF" ? "selected" : "" ?>>OSA STAFF</option>
                                                    <option <?= $rows->FP_FACRANK == "SCHOOL NURSE" ? "selected" : "" ?>>SCHOOL NURSE</option>
                                                    <option <?= $rows->FP_FACRANK == "SCHOOL DOCTOR" ? "selected" : "" ?>>SCHOOL DOCTOR</option>
                                                    <option <?= $rows->FP_FACRANK == "LABORATORY TECHNICIAN" ? "selected" : "" ?>>LABORATORY TECHNICIAN</option>
                                                    <option <?= $rows->FP_FACRANK == "LABORATORY ASSISTANT" ? "selected" : "" ?>>LABORATORY ASSISTANT</option>
                                                    <option <?= $rows->FP_FACRANK == "SECURITY GUARD" ? "selected" : "" ?>>SECURITY GUARD</option>
                                                    <option <?= $rows->FP_FACRANK == "CHIEF SECURITY" ? "selected" : "" ?>>CHIEF SECURITY</option>
                                                    <option <?= $rows->FP_FACRANK == "SECURITY" ? "selected" : "" ?>>SECURITY</option>
                                                    <option <?= $rows->FP_FACRANK == "DRIVER" ? "selected" : "" ?>>DRIVER</option>
                                                    <option <?= $rows->FP_FACRANK == "JANITOR" ? "selected" : "" ?>>JANITOR</option>
                                                    <option <?= $rows->FP_FACRANK == "MAINTENANCE PERSONNEL" ? "selected" : "" ?>>MAINTENANCE PERSONNEL</option>
                                                    <option <?= $rows->FP_FACRANK == "UTILITY" ? "selected" : "" ?>>UTILITY</option>

                                                    <!-- ============================= -->
                                                    <!--       SPECIAL DESIGNATIONS     -->
                                                    <!-- ============================= -->
                                                    <option <?= $rows->FP_FACRANK == "FOCAL PERSON" ? "selected" : "" ?>>FOCAL PERSON</option>
                                                    <option <?= $rows->FP_FACRANK == "GAD FOCAL/CLERK OF FOCAL PERSON" ? "selected" : "" ?>>GAD FOCAL/CLERK OF FOCAL PERSON</option>
                                                    <option <?= $rows->FP_FACRANK == "COORDINATOR" ? "selected" : "" ?>>COORDINATOR</option>
                                                    <option <?= $rows->FP_FACRANK == "DISCIPLINE OFFICER" ? "selected" : "" ?>>DISCIPLINE OFFICER</option>
                                                    <option <?= $rows->FP_FACRANK == "STUDENT AFFAIRS COORDINATOR" ? "selected" : "" ?>>STUDENT AFFAIRS COORDINATOR</option>
                                                    <option <?= $rows->FP_FACRANK == "TRAINING DIRECTOR" ? "selected" : "" ?>>TRAINING DIRECTOR</option>
                                                    <option <?= $rows->FP_FACRANK == "RESEARCH DIRECTOR" ? "selected" : "" ?>>RESEARCH DIRECTOR</option>

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
                                                        <option <?php if ($r->REF_DESC == $rows->FP_ASALARY) {
                                                                    echo "selected";
                                                                } ?> value="<?= $r->REF_DESC; ?>"><?= $r->REF_DESC; ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                                <label for="basic-default-fullname">Annual Salary<span class="text-danger">*</span></label>
                                            </div>
                                        </div>
                                        <div class="education-container">
                                            <?php
                                            if ($EditSchool->num_rows() > 0) {
                                                foreach ($EditSchool->result() as $r) {
                                            ?>
                                                    <div class="col-md-12 mb-2 education-item">
                                                        <div class="card">
                                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                                <span>Educational Attainment <small class="textEducAttainment">(<?= $r->EDUC_ATTAIN ?>)</small></span>
                                                                <button type="button" class="btn btn-danger btn-sm btn-delete-school"><i class="ri-close-line"></i></button>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="form-floating form-floating-outline mb-4">
                                                                            <select class="form-select select2" name="EDUC_ATTAIN[]" required data-allow-clear="true">
                                                                                <option value="">--Select--</option>
                                                                                <option <?= $r->EDUC_ATTAIN == "Elementary" ? "selected" : "" ?>>Elementary</option>
                                                                                <option <?= $r->EDUC_ATTAIN == "Junior High School" ? "selected" : "" ?>>Junior High School</option>
                                                                                <option <?= $r->EDUC_ATTAIN == "Senior High School" ? "selected" : "" ?>>Senior High School</option>
                                                                                <option <?= $r->EDUC_ATTAIN == "College" ? "selected" : "" ?>>College</option>
                                                                            </select>
                                                                            <label for="EDUC_ATTAIN">Educational Attainment <span class="text-danger">*</span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-floating form-floating-outline mb-4">
                                                                            <input type="text" class="form-control" required name="EDUC_NAMEOFSCHOOL[]" value="<?= $r->EDUC_NAMEOFSCHOOL; ?>" placeholder="Enter name of school" />
                                                                            <label for="EDUC_NAMEOFSCHOOL">Name of School <span class="text-danger">*</span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-floating form-floating-outline mb-4">
                                                                            <input type="text" class="form-control" required name="EDUC_ADDRESS[]" value="<?= $r->EDUC_ADDRESS; ?>" placeholder="Enter school address" />
                                                                            <label for="EDUC_ADDRESS">School Address <span class="text-danger">*</span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-floating form-floating-outline mb-4">
                                                                            <input type="text" class="form-control" required name="EDUC_YEAR[]" value="<?= $r->EDUC_YEAR; ?>" placeholder="Enter year" />
                                                                            <label for="EDUC_YEAR">Year <span class="text-danger">*</span></label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-12 <?= $r->EDUC_ATTAIN == "College" ? "" : "d-none" ?> showCourseTaken">
                                                                        <div class="form-floating form-floating-outline mb-4">
                                                                            <input type="text" class="form-control EDUC_PROGRAM" name="EDUC_PROGRAM[]" value="<?= $r->EDUC_PROGRAM; ?>" placeholder="Enter course taken" />
                                                                            <label for="EDUC_PROGRAM">Course Taken <span class="text-danger">*</span></label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                <?php
                            }
                        }
                                ?>
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

<?php
function calculate_age($birthdate)
{
    $today = new DateTime();
    $birthDate = new DateTime($birthdate);
    $age = $today->diff($birthDate)->y;
    return $age;
}
?>

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

        function showConfirmationDialog() {
            Swal.fire({
                title: "Are you sure?",
                text: "Once submitted, employee profile will be saved!",
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
                    submitForm();
                }
            });
        }

        function submitForm() {
            $.ajax({
                url: "<?= base_url('FacultyprofController/updateFP'); ?>",
                type: "POST",
                dataType: "json",
                data: stepperForm.serialize(),
                success: function(data) {
                    if (data.output == "Data has been updated.") {
                        Swal.fire({
                            title: "Success!",
                            text: data.output,
                            icon: "success",
                            customClass: {
                                confirmButton: 'btn btn-primary'
                            },
                            buttonsStyling: false,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "<?= base_url('ims/facultyprof'); ?>";
                            }
                        });
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
<!-- school background  -->
<script>
    function reinitializeSelect2(element) {
        element.select2({
            placeholder: "Select an option",
            allowClear: true
        });
    }



    $(document).ready(function() {

        $(".btn-add-school").click(function() {
            addEducationItem();
        });

        function addEducationItem() {
            $.ajax({
                url: "<?= base_url('FacultyprofController/FetchEducationAttainment'); ?>",
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
                $(this).closest('.education-item').find(".EDUC_PROGRAM").prop("required", true).prop("disabled", false);
            } else {
                $(this).closest('.education-item').find(".showCourseTaken").addClass("d-none");
                $(this).closest('.education-item').find(".EDUC_PROGRAM").prop("required", false).prop("disabled", true);
            }
        });

        $(document).on("click", ".btn-delete-school", function() {
            $(this).closest('.education-item').remove();
        });

        reinitializeSelect2($(".education-container").find('.select2'));
    });
</script>

<script>
    $(document).ready(function() {
        // Attach an event listener to the date input
        $("#FP_BIRTHDAY").change(function() {
            // Get the selected date
            var dob = $(this).val();

            // Calculate age
            var today = new Date();
            var birthDate = new Date(dob);
            var age = today.getFullYear() - birthDate.getFullYear();

            // Check if the birthday has occurred this year
            if (today.getMonth() < birthDate.getMonth() || (today.getMonth() === birthDate.getMonth() && today.getDate() < birthDate.getDate())) {
                age--;
            }

            // Set the calculated age to the age input
            $("#FP_AGE").val(age);
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