<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Student Profile</a>
            </li>
            <li class="breadcrumb-item active">View Record</li>
        </ol>
    </nav>

    <?php
    $ER_ENSTATUS = "";
    $ER_PROGRAM = "";
    $ER_MAJOR = "";
    $ER_YEARLEVEL = "";
    $ER_SEMESTER = "";
    $ER_CLASSIFICATION = "";
    $student_id = "";
    if ($FetchStudentProfile->num_rows() > 0) {
        foreach ($FetchStudentProfile->result() as $rows) {
            $SP_SUFFIX = ($rows->SP_SUFFIX != '') ? ', ' . $rows->SP_SUFFIX : '';
            $fullname = $rows->SP_FIRSTNAME . ' ' . $rows->SP_MIDDLENAME . ' ' . $rows->SP_LASTNAME . '' . $SP_SUFFIX;
            $student_id = $rows->SP_STUDID;

            // load the current enrolled program
            foreach ($load_active_enrollemt->result() as $r) {
                $ER_ENSTATUS = $r->ER_ENSTATUS;
                $ER_PROGRAM = $r->ER_PROGRAM;
                $ER_MAJOR = $r->ER_MAJOR;
                $ER_YEARLEVEL = $r->ER_YEARLEVEL;
                $ER_SEMESTER = $r->ER_SEMESTER;
                $ER_CLASSIFICATION = $r->ER_CLASSIFICATION;
            }

    ?>
            <!-- Header -->
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>"
                        value="<?= $this->security->get_csrf_hash(); ?>">
                    <div class="card mb-5">
                        <div class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-4">
                            <div class="flex-shrink-0 mt-n2 mx-sm-0 mx-auto">
                                <img src="<?= ($rows->SP_IMAGE == "") ? base_url("assets/img/avatars/1.png") : base_url("uploads/" . $rows->SP_IMAGE) ?>"
                                    alt="user image" class="d-block h-auto ms-0 ms-sm-5 rounded user-profile-img" />
                            </div>

                            <div class="flex-grow-1 mt-3">
                                <div
                                    class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-5">
                                    <div class="user-profile-info">
                                        <h4 class="mb-4"><?= $fullname; ?></h4>

                                        <span class="fw-bold mb-1">Current Program</span>
                                        <ul
                                            class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4">
                                            <li class="list-inline-item">
                                                <span class="fw-medium">Program </span>
                                                <p><?= $ER_PROGRAM ?> <span><?= ($ER_MAJOR == '') ? '' : '' ?></span></p>
                                            </li>
                                            <li class="list-inline-item">
                                                <span class="fw-medium">Year Level</span>
                                                <p><?= $ER_YEARLEVEL; ?></p>
                                            </li>
                                            <li class="list-inline-item">
                                                <span class="fw-medium">Semester</span>
                                                <p><?= $ER_SEMESTER; ?></p>
                                            </li>
                                            <li class="list-inline-item">
                                                <span class="fw-medium">Classification</span>
                                                <p><?= $ER_CLASSIFICATION ?></p>
                                            </li>
                                            <li class="list-inline-item">
                                                <span class="fw-medium">Enrollment Status</span><br>
                                                <p
                                                    class="badge rounded-pill bg-<?= ($ER_ENSTATUS != '') ? 'success' : 'danger' ?>">
                                                    <?= ($ER_ENSTATUS != '') ? $ER_ENSTATUS : 'PENDING'; ?></p>
                                            </li>
                                        </ul>
                                        <ul
                                            class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4">
                                            <?php
                                            $permission = [];

                                            if ($rbac->num_rows() > 0 || $this->session->userdata("usertype") == "Administrator") {
                                                foreach ($rbac->result() as $rbac_row) {
                                                    $permission[] = $rbac_row->ACTIONS; // Collect actions into an array
                                                }
                                                // Check if 'Create' exists in the permission list, or if user is admin
                                                if (in_array("Edit", $permission) || $this->session->userdata("usertype") == "Administrator") {
                                            ?>
                                                    <li class="list-inline-item">
                                                        <a href="<?= base_url("ims/studentprofile/edit/" . $this->uri->segment(4)); ?>"
                                                            class="btn btn-secondary">
                                                            <i class="ri-pencil-line ri-16px me-1_5"></i>Edit Profile
                                                        </a>
                                                    </li>
                                            <?php
                                                }
                                            }
                                            ?>
                                            <li class="list-inline-item">
                                                <span class="fw-medium">LRN No. </span>
                                                <p><?= ($rows->SP_LRN == '') ? 'Not Available' : $rows->SP_LRN; ?></p>
                                            </li>
                                            <li class="list-inline-item">
                                                <span class="fw-medium">Student ID Number</span>
                                                <p>
                                                    <span id="display_student_id"><?= $rows->SP_STUDID; ?></span>
                                                    <?php if (in_array("Edit", $permission) || in_array(strtolower(trim($this->session->userdata("usertype") ?? '')), ["administrator", "superadmin", "super admin", "admin"])) { ?>
                                                        <a href="javascript:void(0);" class="text-primary ms-2 btn-edit-student-id" data-current="<?= $rows->SP_STUDID; ?>" data-id="<?= $rows->ID; ?>" title="Edit Student ID"><i class="ri-edit-box-line"></i></a>
                                                    <?php } ?>
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Header -->
            <div class="row gy-4">
                <div class="col-xl-12">
                    <div class="nav-align-top mb-6">
                        <ul class="nav nav-pills mb-4 nav-fill" role="tablist">
                            <li class="nav-item mb-1 mb-sm-0">
                                <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-personal" aria-controls="navs-personal" aria-selected="true">
                                    <i class="tf-icons ri-user-line me-1_5"></i> Personal Information
                                </button>
                            </li>

                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-documents" aria-controls="navs-documents" aria-selected="false">
                                    <i class="tf-icons ri-file-check-line me-1_5"></i> Documents Checklist

                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-enrolled" aria-controls="navs-enrolled" aria-selected="false">
                                    <i class="tf-icons ri-book-line me-1_5"></i> Enrolled Programs

                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link " role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-financial" aria-controls="navs-financial" aria-selected="false">
                                    <i class="tf-icons ri-money-dollar-circle-line me-1_5"></i> Financial Transactions
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link " role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-incomplete-grades" aria-controls="navs-incomplete-grades"
                                    aria-selected="false">
                                    <i class="tf-icons ri-slideshow-line me-1_5"></i> INC
                                    Grades
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link " role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-grades" aria-controls="navs-grades" aria-selected="false">
                                    <i class="tf-icons ri-slideshow-line me-1_5"></i> Grade Record
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-personal" role="tabpanel">
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <h5 class="fw-bold">Personal Background</h5>
                                        <div class="row">
                                            <div class="col-xl-6 col-12">
                                                <dl class="row mb-0 gx-2">
                                                    <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Last Name:
                                                    </dt>
                                                    <dd class="col-sm-8"><?= $rows->SP_LASTNAME; ?></dd>

                                                    <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">First Name:
                                                    </dt>
                                                    <dd class="col-sm-8"><?= $rows->SP_FIRSTNAME; ?></dd>

                                                    <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Middle Name:
                                                    </dt>
                                                    <dd class="col-sm-8"><?= $rows->SP_MIDDLENAME; ?></dd>

                                                    <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Suffix:</dt>
                                                    <dd class="col-sm-8"><?= $rows->SP_SUFFIX; ?></dd>

                                                    <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Date of
                                                        Birth | Age:</dt>
                                                    <dd class="col-sm-8">
                                                        <?= date('M d, Y', strtotime($rows->SP_BIRTHDAY)); ?> |
                                                        <?= calculate_age($rows->SP_BIRTHDAY); ?> years old
                                                    </dd>


                                                    <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Gender:</dt>
                                                    <dd class="col-sm-8"><?= $rows->SP_GENDER; ?></dd>

                                                    <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Person With
                                                        Disabilities:</dt>
                                                    <dd class="col-sm-8">
                                                        <?= $rows->SP_PWD == "NO" ? $rows->SP_PWD : $rows->SP_PWD . ' (' . $rows->SP_PWD_SPECIFY . ')'; ?>
                                                    </dd>
                                                </dl>
                                            </div>
                                            <div class="col-xl-6 col-12">
                                                <dl class="row mb-0 gx-2">

                                                    <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Contact No.:
                                                    </dt>
                                                    <dd class="col-sm-8"><?= $rows->SP_CPNUMBER; ?></dd>

                                                    <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Email
                                                        Address:</dt>
                                                    <dd class="col-sm-8"><?= $rows->SP_EMAIL; ?></dd>

                                                    <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Civil
                                                        Status:</dt>
                                                    <dd class="col-sm-8"><?= $rows->SP_CIVILSTATUS; ?></dd>

                                                    <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Nationality:
                                                    </dt>
                                                    <dd class="col-sm-8"><?= $rows->SP_NATIONALITY; ?></dd>

                                                    <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Religion:
                                                    </dt>
                                                    <dd class="col-sm-8"><?= $rows->SP_RELIGION ?></dd>

                                                    <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Ethnic
                                                        Affilation/Tribe:</dt>
                                                    <dd class="col-sm-8"><?= $rows->SP_TRIBE; ?></dd>
                                                    <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Birth Place:
                                                    </dt>
                                                    <dd class="col-sm-8"><?= $rows->SP_BIRTHPLACE; ?></dd>
                                                </dl>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mt-5">
                                            <div class="col-md-12">
                                                <p class="text-nowrap fw-medium text-heading">Complete Address:</p>
                                                <?php
                                                $reg = $this->db->where("regCode", $rows->SP_REGION)->get("refregion")->row("regDesc");
                                                $prov = $this->db->where("provCode", $rows->SP_PROVINCE)->get("refprovince")->row("provDesc");
                                                $city = $this->db->where("citymunCode", $rows->SP_MUNICIPALITY)->get("refcitymun")->row("citymunDesc");
                                                $brgy = $this->db->where("brgyCode", $rows->SP_BRGY)->get("refbrgy")->row("brgyDesc");
                                                $complete_address = $rows->SP_STRT . ', ' . $brgy . '<br>' . $city . ', ' . $rows->SP_ZCODE .  ' ' . $prov . '<br>' . $reg;
                                                ?>
                                                <p><?= $complete_address; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-md-12">
                                        <h5 class="fw-bold">Family Background</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Complete Name</th>
                                                        <th>Contact No.</th>
                                                        <th>Complete Address</th>
                                                        <th>Relationship with Guardian</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($EditFamily->num_rows() > 0) {
                                                        foreach ($EditFamily->result() as $r) {
                                                    ?>
                                                            <tr>

                                                                <td><?= $r->FAM_NAME; ?></td>
                                                                <td><?= $r->FAM_CONTACT; ?></td>
                                                                <td><?= $r->FAM_ADDRESS; ?></td>

                                                                <td><?= $r->FAM_RELATIONSHIP == "Other relatives, specify" ? $r->FAM_RELATIONSHIP . ' (' . $r->FAM_RELATIONSHIP_SPECIFY . ')' : $r->FAM_RELATIONSHIP; ?>
                                                                </td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <h5 class="fw-bold">Educational Background</h5>
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-sm" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th>Education Attainment</th>
                                                        <th>Name of School</th>
                                                        <th>School Address</th>
                                                        <th>Year</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    if ($EditSchool->num_rows() > 0) {
                                                        foreach ($EditSchool->result() as $r) {
                                                    ?>
                                                            <tr>
                                                                <td><?= $r->EDUC_ATTAIN == "College" ? $r->EDUC_ATTAIN . ' (' . $r->EDUC_PROGRAM . ')' : $r->EDUC_ATTAIN; ?>
                                                                </td>
                                                                <td><?= $r->EDUC_NAMEOFSCHOOL; ?></td>
                                                                <td><?= $r->EDUC_ADDRESS; ?></td>
                                                                <td><?= $r->EDUC_YEAR; ?></td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane fade " id="navs-documents" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-sm">
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
                                                            $isChecked = in_array($r->ID, explode(',', $rows->SP_ATTACHMENTS_FRESHMEN)) ? 'checked' : '';
                                                    ?>
                                                            <div class="form-check form-check-success">
                                                                <input readonly class="form-check-input"
                                                                    name="SP_ATTACHMENTS_FRESHMEN[]" type="checkbox"
                                                                    value="<?= $r->ID ?>" id="freshmen_<?= $r->REQS ?>"
                                                                    <?= $isChecked ?> />
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
                                                            $isChecked = in_array($r->ID, explode(',', $rows->SP_ATTACHMENTS_TRANSFEREE)) ? 'checked' : '';
                                                    ?>
                                                            <div class="form-check form-check-success">
                                                                <input readonly class="form-check-input"
                                                                    name="SP_ATTACHMENTS_TRANSFEREE[]" type="checkbox"
                                                                    value="<?= $r->ID ?>" id="transferee_<?= $r->REQS ?>"
                                                                    <?= $isChecked ?> />
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

                                <!-- add remarks field -->
                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <label for="remarks" class="form-label fw-bold">Remarks:</label>
                                        <textarea class="form-control mb-2" id="SP_DOCS_REMARKS" name="SP_DOCS_REMARKS"
                                            rows="3"><?= $rows->SP_DOCS_REMARKS ?? 'No remarks'; ?></textarea>
                                        <button type="button" class="btn btn-primary btn-save-remarks">Update Remarks</button>
                                    </div>

                                    <script>
                                        $(document).ready(function() {
                                            $(".btn-save-remarks").click(function() {

                                                var remarks = $("#SP_DOCS_REMARKS").val();
                                                var SP_TRANSID =
                                                    "<?= $rows->SP_TRANSID; ?>"; // Get student ID from PHP variable
                                                $.ajax({
                                                    url: "<?= base_url('ims/studentprofile/update_remarks'); ?>",
                                                    type: "POST",
                                                    data: {
                                                        [$('.txt_csrfname').attr('name')]: $(
                                                            '.txt_csrfname').val(),
                                                        SP_TRANSID: SP_TRANSID,
                                                        SP_DOCS_REMARKS: remarks
                                                    },
                                                    success: function(response) {
                                                        // Update CSRF hash
                                                        $('.txt_csrfname').val(response.token);
                                                        Swal.fire(
                                                            'Success!',
                                                            'Remarks updated successfully.',
                                                            'success'
                                                        );
                                                    },
                                                    error: function(xhr, status, error) {
                                                        Swal.fire(
                                                            'Error!',
                                                            'There was an error updating the remarks.',
                                                            'error'
                                                        );
                                                    }
                                                });
                                            });
                                        });
                                    </script>


                                </div>

                            </div>
                            <div class="tab-pane fade " id="navs-enrolled" role="tabpanel">
                                <div class="row">
                                    <?php
                                    $get_studid = $this->db->where("SP_TRANSID", $this->uri->segment(4))->get("tbl_studprof")->row("SP_STUDID");

                                    $load_enrolled = $this->db->where("ER_STUDENTID", $get_studid)->order_by("ID", "ASC")->get("tbl_enrollment");

                                    if ($load_enrolled->num_rows() > 0) {
                                        foreach ($load_enrolled->result() as $row) {
                                    ?>
                                            <div class="col-md-4 mb-2">
                                                <div class="card">
                                                    <div class="card-body p-2">
                                                        <h6 class="mb-1">Year Level:
                                                            <small><?= ucwords(strtolower($row->ER_YEARLEVEL)); ?></small>
                                                        </h6>
                                                        <ul class=" mb-2">
                                                            <li><small>Program:
                                                                    <?= ucwords(strtolower($row->ER_PROGRAM)); ?></small>
                                                            </li>
                                                            <li><small>Major:
                                                                    <?= ucwords(strtolower($row->ER_MAJOR)) ?? "*Not available"; ?></small>
                                                            </li>
                                                            <li><small>Academic Year:
                                                                    <?= $row->ER_ACADEMICYEAR . '-' . ($row->ER_ACADEMICYEAR + 1); ?></small>
                                                            </li>
                                                            <li><small>Semester:
                                                                    <?= ucwords(strtolower($row->ER_SEMESTER)); ?></small>
                                                            </li>
                                                            <li><small>Enrollment Status:
                                                                    <?= ucwords(strtolower($row->ER_ENSTATUS)); ?></small>
                                                            </li>
                                                        </ul>

                                                        <div class="table-responsive">
                                                            <table class="table table-sm table-bordered mb-1">
                                                                <thead class="table-light">
                                                                    <tr>
                                                                        <th><small>Code</small></th>
                                                                        <th><small>Subjects</small></th>
                                                                        <th><small>Units</small></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    if (!empty($row->ER_SUBJECTS)) {
                                                                        $subject_ids = explode(',', $row->ER_SUBJECTS);
                                                                        $sanitized_ids = array_map('intval', $subject_ids);
                                                                        $subject_ids_string = implode("','", $sanitized_ids);

                                                                        $get_subjects = $this->db->query("SELECT * FROM tbl_subject WHERE ID IN('" . $subject_ids_string . "')");

                                                                        if ($get_subjects->num_rows() > 0) {
                                                                            foreach ($get_subjects->result() as $s) {
                                                                    ?>
                                                                                <tr>
                                                                                    <td><small><?= $s->S_SCODE ?></small></td>
                                                                                    <td><small><?= $s->S_SDESCRIPTION ?></small></td>
                                                                                    <td><small><?= $s->S_UNITS ?></small></td>
                                                                                </tr>
                                                                    <?php
                                                                            }
                                                                        } else {
                                                                            echo '<tr><td colspan="3"><small>No subjects found for this enrollment.</small></td></tr>';
                                                                        }
                                                                    } else {
                                                                        echo '<tr><td colspan="3"><small>No subjects listed for this enrollment.</small></td></tr>';
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="2" class="text-end"><small><strong>Total
                                                                                    Units</strong></small></td>
                                                                        <td><small><?= $row->ER_UNITS; ?></small></td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo '<div class="col-md-12"><p><small>No enrollment records found for this student.</small></p></div>';
                                    }
                                    ?>
                                </div>

                            </div>
                            <div class="tab-pane fade " id="navs-financial" role="tabpanel">
                                <div class="row">
                                    <?php
                                    // Get the student ID
                                    $get_studid = $this->db->where("SP_TRANSID", $this->uri->segment(4))
                                        ->get("tbl_studprof")->row("SP_STUDID");

                                    // Load enrolled data
                                    $load_enrolled = $this->db->where("ER_STUDENTID", $get_studid)
                                        ->order_by("ID", "ASC")
                                        ->get("tbl_enrollment");

                                    if ($load_enrolled->num_rows() > 0) {
                                        foreach ($load_enrolled->result() as $row) {
                                            $total_paid = 0;
                                            $previous_balance = 0;
                                            $total_voucher = 0;

                                            $load_soa_payments = $this->db->query("SELECT * FROM tbl_payment WHERE ER_TRANSNO = '{$row->ER_TRANSNO}'");
                                            foreach ($load_soa_payments->result() as $r) {
                                                $total_paid += str_replace(',', '', $r->P_AMOUNT);
                                            }

                                            $load_soa_fees = $this->db->query("
                                        SELECT f.FEES_KEY, e.ER_TRANSNO,
                                            f.FEES_TOTALTUITION AS totalTuition,
                                            (SELECT COALESCE(SUM(REPLACE(mf.FEES_MISC_AMOUNT, ',', '')), 0)
                                                FROM tbl_fees_miscellaneous mf
                                                WHERE mf.FEES_TUITION_ID = f.FEES_KEY) AS totalMisc,
                                            (SELECT COALESCE(SUM(REPLACE(otf.FEES_OTHER_AMOUNT, ',', '')), 0)
                                                FROM tbl_fees_otherfees otf
                                                WHERE otf.FEES_TUITION_ID = f.FEES_KEY) AS totalOther
                                        FROM tbl_enrollment e
                                        LEFT JOIN tbl_fees_tuitions f 
                                            ON e.ER_PROGRAM = f.FEES_PROGRAM 
                                            AND e.ER_MAJOR = f.FEES_MAJOR 
                                            AND e.ER_YEARLEVEL = f.FEES_YEARLEVEL 
                                            AND e.ER_SEMESTER = f.FEES_SEMESTER
                                        WHERE e.ID = ? AND e.ER_TRANSNO = ?
                                        GROUP BY e.ER_TRANSNO, f.FEES_KEY, f.FEES_TOTALTUITION
                                            ", [$row->ID, $row->ER_TRANSNO])->row();
                                    ?>
                                            <div class="col-md-4 mb-3">
                                                <div class="card">
                                                    <div class="card-body p-2">
                                                        <h6 class="mb-1">Year Level:
                                                            <small><?= ucwords(strtolower($row->ER_YEARLEVEL)) ?></small>
                                                        </h6>
                                                        <ul class="mb-2">
                                                            <li><small>Program: <?= ucwords(strtolower($row->ER_PROGRAM)) ?></small>
                                                            </li>
                                                            <li><small>Major:
                                                                    <?= ucwords(strtolower($row->ER_MAJOR)) ?? "*Not available" ?></small>
                                                            </li>
                                                            <li><small>Academic Year:
                                                                    <?= $row->ER_ACADEMICYEAR . '-' . ($row->ER_ACADEMICYEAR + 1) ?></small>
                                                            </li>
                                                            <li><small>Semester:
                                                                    <?= ucwords(strtolower($row->ER_SEMESTER)) ?></small>
                                                            </li>
                                                            <li><small>Enrollment Status:
                                                                    <?= ucwords(strtolower($row->ER_ENSTATUS)) ?></small></li>
                                                            <li><small>Payment Status:
                                                                    <?= ucwords(strtolower($row->ER_PAYMENTSTATUS)) ?></small></li>
                                                        </ul>

                                                        <div class="table-responsive">
                                                            <table class="table table-sm table-bordered mb-1">
                                                                <thead>
                                                                    <tr>
                                                                        <th><small>FEE BREAKDOWN</small></th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <?php
                                                                            $partial_enrollment_fee = $this->db->get("tbl_websettings")->row("IMS_WEB_ENROLLMENT_FEE") ?? 0;
                                                                            $FEES_AMOUNTPERUNIT = 0;

                                                                            $get_enrollment = $this->db->where("ER_TRANSNO", $row->ER_TRANSNO)->get("tbl_enrollment");

                                                                            foreach ($get_enrollment->result() as $r) {
                                                                                if ($r->ER_CLASSIFICATION === "IRREGULAR" && !empty($r->ER_SUBJECTS)) {
                                                                                    $subject_ids = array_map('intval', explode(',', $r->ER_SUBJECTS));
                                                                                    $subject_ids_str = implode(',', $subject_ids);

                                                                                    $get_subjects = $this->db->query("SELECT * FROM tbl_subject WHERE ID IN($subject_ids_str)");
                                                                                    foreach ($get_subjects->result() as $s) {
                                                                                        $get_fees = $this->db->query(
                                                                                            "SELECT FEES_AMOUNTPERUNIT FROM tbl_fees_tuitions WHERE FEES_PROGRAM = ? AND FEES_MAJOR = ? AND FEES_YEARLEVEL = ? AND FEES_SEMESTER = ? LIMIT 1",
                                                                                            [$s->S_SELECTPROG, $s->S_MAJOR, $s->S_YRLVL, $s->S_SEM]
                                                                                        );
                                                                                        if ($get_fees->num_rows() > 0) {
                                                                                            $fee = $get_fees->row();
                                                                                            $unit_rate = floatval(str_replace(',', '', $fee->FEES_AMOUNTPERUNIT));
                                                                                            $FEES_AMOUNTPERUNIT += $unit_rate * floatval($s->S_UNITS);
                                                                                        }
                                                                                    }
                                                                                }
                                                                            }

                                                                            $total_tuition = $FEES_AMOUNTPERUNIT ?: (float) str_replace(',', '', $load_soa_fees->totalTuition ?? 0);
                                                                            $total_miscellaneous = (float) $load_soa_fees->totalMisc ?? 0;
                                                                            $total_other_fee = (float) $load_soa_fees->totalOther ?? 0;

                                                                            $overall_total = $total_tuition + $total_miscellaneous + $total_other_fee + str_replace(',', '', $partial_enrollment_fee);

                                                                            echo '<small>Miscellaneous Fee: <span style="float:right;">₱' . number_format($total_miscellaneous, 2) . '</span></small><br>';
                                                                            echo '<small>Other Fees: <span style="float:right;">₱' . number_format($total_other_fee, 2) . '</span></small><br>';
                                                                            echo '<small>Tuition Fee: <span style="float:right;">₱' . number_format($total_tuition, 2) . '</span></small><br>';
                                                                            echo '<small>Enrollment Fee/Downpayment: <span style="float:right;">₱' . $partial_enrollment_fee . '</span></small><br>';
                                                                            echo '<strong><small>TOTAL ASSESSMENT:</small></strong> <span style="float:right;" class="fw-bold">₱' . number_format($overall_total, 2) . '</span><br>';
                                                                            echo '<strong><small>TOTAL PAID:</small></strong>  <span style="float:right;" class="text-success">(₱' . number_format($total_paid, 2) . ')</span><br>';

                                                                            echo '<small class="d-block text-center mt-1"><strong>*** Voucher/Discount ***</strong></small>';

                                                                            $voucher_available = false;
                                                                            foreach ($load_soa_payments->result() as $r) {
                                                                                $get_exists_voucher = $this->db->query("SELECT * FROM tbl_payment_discount WHERE P_VOUCHERNO = ?", [$r->P_VOUCHERNO]);
                                                                                if ($get_exists_voucher->num_rows() > 0) {
                                                                                    foreach ($get_exists_voucher->result() as $voucher) {
                                                                                        $voucher_amount = str_replace(',', '', $voucher->D_AMOUNT);
                                                                                        $total_voucher += $voucher_amount;
                                                                                        echo '<small>***' . $voucher->D_DESC . '</small> <span style="float:right;"> - (₱' . number_format($voucher_amount, 2) . ')</span><br>';
                                                                                    }
                                                                                    $voucher_available = true;
                                                                                }
                                                                            }

                                                                            if (!$voucher_available) echo "<small>***Not Available</small>";

                                                                            $previous_balance = ($overall_total - $total_voucher) - $total_paid;
                                                                            $transactionId = $row->ER_TRANSNO;

                                                                            echo '<div class="mt-1"><strong><small>PAYMENT REMAINING:</small></strong></div>';

                                                                            $paidDescriptions = [];
                                                                            $payments = $this->db->where("ER_TRANSNO", $transactionId)->get("tbl_payment");
                                                                            foreach ($payments->result() as $payment) $paidDescriptions[] = $payment->P_DESC;

                                                                            if (!in_array("Full Payment", $paidDescriptions)) {
                                                                                $allStages = ["Prelim", "Midterm", "Pre-Final", "Final"];
                                                                                $unpaidStages = array_diff($allStages, $paidDescriptions);
                                                                                $each_amount = !empty($unpaidStages) ? $previous_balance / count($unpaidStages) : 0;

                                                                                if (!in_array("Downpayment", $paidDescriptions) && $partial_enrollment_fee > 0) {
                                                                                    echo '<small><strong>Downpayment</strong> <span style="float:right;">' . $partial_enrollment_fee . '</span></small><br>';
                                                                                }

                                                                                foreach ($unpaidStages as $stage) {
                                                                                    echo '<small>' . $stage . ' <span style="float:right;">' . number_format($each_amount, 2) . '</span></small><br>';
                                                                                }
                                                                            }

                                                                            echo '<div class="mt-1"><strong><small>BALANCE DUE:</small></strong> <span style="float:right;" class="text-danger fw-bold">₱' . number_format($previous_balance, 2) . '</span></div>';
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo '<div class="col-md-12"><p>No enrollment records found for this student.</p></div>';
                                    }
                                    ?>
                                </div>


                            </div>



                            <div class="tab-pane fade" id="navs-incomplete-grades" role="tabpanel">
                                <!-- load the incomplete grades here -->
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Semester</th>
                                            <th>Teacher</th>
                                            <th>Subject Title</th>
                                            <th>Units</th>
                                            <th>Grade</th>
                                            <th>Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Get incomplete grades using JOIN
                                        $subjects = $this->db
                                            ->select('sg.G_SUBJECT, sg.G_GRADE, sg.G_REMARKS, ts.S_UNITS, sg.G_ENCODERTEACHER, sg.G_SEMESTER')
                                            ->from('tbl_studentgrades sg')
                                            ->join('tbl_subject ts', 'sg.G_SUBJECT = ts.S_SDESCRIPTION', 'left')
                                            ->where('sg.G_STUDENTID', $student_id)
                                            ->where('sg.G_REMARKS', 'INC')
                                            ->get()
                                            ->result();


                                        if (count($subjects) > 0) {
                                            foreach ($subjects as $subject) {
                                        ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($subject->G_SEMESTER) ?></td>
                                                    <td><?= htmlspecialchars($subject->G_ENCODERTEACHER) ?></td>
                                                    <td><?= htmlspecialchars($subject->G_SUBJECT) ?></td>
                                                    <td><?= htmlspecialchars($subject->S_UNITS ?? '') ?></td>
                                                    <td><?= htmlspecialchars($subject->G_GRADE) ?></td>
                                                    <td><?= htmlspecialchars($subject->G_REMARKS) ?></td>
                                                </tr>
                                        <?php }
                                        } else {
                                            echo '<tr><td colspan="6"><small>No incomplete grades found for this student.</small></td></tr>';
                                        }
                                        ?>
                                    </tbody>
                                </table>

                            </div>




                            <div class="tab-pane fade" id="navs-grades" role="tabpanel">
                                <!-- load grade here -->
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>Academic Year</th>
                                            <th>Semester</th>
                                            <th>GWA</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Fetch all grades grouped by academic year and semester
                                        $grades_query = $this->db
                                            ->select('G_ACADEMICYEAR, G_SEMESTER')
                                            ->where('G_STUDENTID', $student_id)
                                            ->group_by(['G_ACADEMICYEAR', 'G_SEMESTER'])
                                            ->order_by('G_ACADEMICYEAR', 'DESC')
                                            ->order_by('G_SEMESTER', 'DESC')
                                            ->get('tbl_studentgrades');

                                        $modal_data = [];
                                        $modal_index = 0;
                                        if ($grades_query->num_rows() > 0) {
                                            $grades = $grades_query->result();
                                            foreach ($grades as $grade_group) {
                                                // Get all subjects for this semester/year
                                                $subjects = $this->db
                                                    ->where('G_STUDENTID', $student_id)
                                                    ->where('G_ACADEMICYEAR', $grade_group->G_ACADEMICYEAR)
                                                    ->where('G_SEMESTER', $grade_group->G_SEMESTER)
                                                    ->get('tbl_studentgrades')
                                                    ->result();

                                                $total_grade = 0;
                                                $subject_count = 0;
                                                foreach ($subjects as $subject) {
                                                    if (is_numeric($subject->G_GRADE)) {
                                                        $total_grade += $subject->G_GRADE;
                                                        $subject_count++;
                                                    }
                                                }
                                                $gwa = ($subject_count > 0) ? round($total_grade / $subject_count, 2) : 'N/A';

                                                // Optionally, determine status (e.g., Passed/Failed)
                                                $status = 'N/A';
                                                if ($gwa !== 'N/A') {
                                                    $status = ($gwa <= 3.0) ? 'Passed' : 'Failed';
                                                }

                                                // Modal IDs for this semester/year
                                                $modal_id = "subjectsModal_" . $modal_index;
                                                $print_modal_id = "printModal_" . $modal_index;
                                                $printcert_modal_id = "printCertModal_" . $modal_index;
                                                $edit_modal_id = "editGradesModal_" . $modal_index;

                                                // Store modal data for later rendering
                                                $modal_data[] = [
                                                    'modal_id' => $modal_id,
                                                    'grade_group' => $grade_group,
                                                    'subjects' => $subjects,
                                                    'print_modal_id' => $print_modal_id,
                                                    'printcert_modal_id' => $printcert_modal_id,
                                                    'edit_modal_id' => $edit_modal_id
                                                ];
                                        ?>
                                                <tr>
                                                    <td><?= htmlspecialchars($grade_group->G_ACADEMICYEAR . '-' . ((int)$grade_group->G_ACADEMICYEAR + 1)) ?>
                                                    </td>
                                                    <td><?= htmlspecialchars($grade_group->G_SEMESTER) ?></td>
                                                    <td><?= $gwa ?></td>
                                                    <td><?= $status ?></td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-success view-btn"
                                                            data-bs-toggle="modal" data-bs-target="#<?= $modal_id ?>"
                                                            data-academicyear="<?= htmlspecialchars($grade_group->G_ACADEMICYEAR) ?>"
                                                            data-semester="<?= htmlspecialchars($grade_group->G_SEMESTER) ?>">
                                                            <i class="ri ri-eye-line"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                        <?php $modal_index++;
                                            }
                                        } else {
                                            echo '<tr><td colspan="5"><small>No grades found for this student.</small></td></tr>';
                                        } ?>

                                    </tbody>
                                </table>


                            </div>


                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
    } else {
        echo "No results found";
    }
    ?>
</div>
<!-- / Content -->


<?php
// Render all modals after the table
foreach ($modal_data as $modal) {
    $modal_id = $modal['modal_id'];
    $grade_group = $modal['grade_group'];
    $subjects = $modal['subjects'];
    $print_modal_id = $modal['print_modal_id'];
    $printcert_modal_id = $modal['printcert_modal_id'];
    $edit_modal_id = $modal['edit_modal_id'];
?>

<?php } ?>


<?php
// Render all modals after the table
foreach ($modal_data as $modal) {
    $modal_id = $modal['modal_id'];
    $grade_group = $modal['grade_group'];
    $subjects = $modal['subjects'];
    $student_id = $this->uri->segment(5);
    // --- Begin Modal Templates ---

    // Edit Grades Modal
?>


    <!-- View Modal -->
    <div class="modal fade" id="<?= $modal_id ?>" tabindex="-1" aria-labelledby="<?= $modal_id ?>Label" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="<?= $modal_id ?>Label">
                        Subjects for AY
                        <?= htmlspecialchars($grade_group->G_ACADEMICYEAR . '-' . ($grade_group->G_ACADEMICYEAR + 1)) ?>,
                        Semester <?= htmlspecialchars($grade_group->G_SEMESTER) ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Subject Title</th>
                                <th>Units</th>
                                <th>Grade</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $total_units = 0;
                            foreach ($subjects as $subject) {
                                $units = '';
                                $this->db->select('S_UNITS');
                                $this->db->where('S_SDESCRIPTION', $subject->G_SUBJECT);
                                $subject_query = $this->db->get('tbl_subject');
                                if ($subject_query->num_rows() > 0) {
                                    $units = $subject_query->row()->S_UNITS;
                                    $total_units += floatval($units);
                                }
                            ?>
                                <tr>
                                    <td><?= $subject->G_SUBJECT ?></td>
                                    <td><?= htmlspecialchars($units) ?></td>
                                    <td><?= htmlspecialchars($subject->G_GRADE) ?></td>
                                    <td><?= htmlspecialchars($subject->G_REMARKS) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="1" class="text-end">Total Units:</th>
                                <th><?= $total_units ?></th>
                                <th colspan="2"></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



<?php
    // --- End Modal Templates ---
}
?>


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
        $(document).on('click', '.btn-edit-student-id', function(e) {
            e.preventDefault();
            console.log("Edit Student ID clicked");
            var currentId = $(this).data('current');
            var recordId = $(this).data('id');

            Swal.fire({
                title: 'Override Authorization',
                html: `
            <p>Please enter your password to authorize this change.</p>
            <input type="password" id="override_password" class="swal2-input" placeholder="Password">
            <br><br>
            <p>New Student ID:</p>
            <input type="text" id="new_student_id" class="swal2-input" value="${currentId}" placeholder="New Student ID">
        `,
                showCancelButton: true,
                confirmButtonText: 'Update Student ID',
                preConfirm: () => {
                    const password = Swal.getPopup().querySelector('#override_password').value;
                    const newStudentId = Swal.getPopup().querySelector('#new_student_id').value;
                    if (!password || !newStudentId) {
                        Swal.showValidationMessage(`Please enter both password and new Student ID`);
                    }
                    return {
                        password: password,
                        newStudentId: newStudentId
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    var password = result.value.password;
                    var newStudentId = result.value.newStudentId;

                    if (newStudentId === currentId) {
                        Swal.fire('No Changes', 'The Student ID is identical to the current one.', 'info');
                        return;
                    }

                    $.ajax({
                        url: '<?= base_url("ims/studentprofile/update_student_id"); ?>',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val(),
                            record_id: recordId,
                            old_student_id: currentId,
                            new_student_id: newStudentId,
                            override_password: password
                        },
                        success: function(response) {
                            $('.txt_csrfname').val(response.token);
                            if (response.status === 'success') {
                                Swal.fire('Updated!', response.message, 'success').then(() => {
                                    $('#display_student_id').text(newStudentId);
                                    $('.btn-edit-student-id').data('current', newStudentId);
                                });
                            } else {
                                Swal.fire('Failed!', response.message, 'error');
                            }
                        },
                        error: function() {
                            Swal.fire('Error!', 'Something went wrong.', 'error');
                        }
                    });
                }
            });
        });
    });
</script>