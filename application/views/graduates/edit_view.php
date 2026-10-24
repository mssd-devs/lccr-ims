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
    if ($FetchStudentProfile->num_rows() > 0) {
        foreach ($FetchStudentProfile->result() as $rows) {
            $SP_SUFFIX = ($rows->SP_SUFFIX != '') ? ', ' . $rows->SP_SUFFIX : '';
            $fullname = $rows->SP_FIRSTNAME . ' ' . $rows->SP_MIDDLENAME . ' ' . $rows->SP_LASTNAME . '' . $SP_SUFFIX;


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
                                                <span class="fw-medium">Status</span><br>
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
                                                <p><?= $rows->SP_STUDID; ?></p>
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
                                <button type="button" class="nav-link  active" role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-personal" aria-controls="navs-personal" aria-selected="true">
                                    <i class="tf-icons ri-user-line me-1_5"></i> Personal Background
                                </button>
                            </li>
                            <li class="nav-item mb-1 mb-sm-0">
                                <button type="button" class="nav-link " role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-educational" aria-controls="navs-educational" aria-selected="false">
                                    <i class="tf-icons ri-school-line me-1_5"></i> Educational Background
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link " role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-family" aria-controls="navs-family" aria-selected="false">
                                    <i class="tf-icons ri-team-line me-1_5"></i> Family Background
                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link " role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-documents" aria-controls="navs-documents" aria-selected="false">
                                    <i class="tf-icons ri-file-check-line me-1_5"></i> Documents Checklist

                                </button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="nav-link " role="tab" data-bs-toggle="tab"
                                    data-bs-target="#navs-enrolled" aria-controls="navs-enrolled" aria-selected="false">
                                    <i class="tf-icons ri-book-line me-1_5"></i> Enrolled Programs

                                </button>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="navs-personal" role="tabpanel">
                                <div class="row mt-3">
                                    <div class="col-md-12">
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
                            </div>
                            <div class="tab-pane fade " id="navs-educational" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="width: 100%;">
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
                            <div class="tab-pane fade " id="navs-family" role="tabpanel">
                                <div class="table-responsive">
                                    <table class="table table-bordered" style="width: 100%;">
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
                            <div class="tab-pane fade " id="navs-documents" role="tabpanel">
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
                            </div>
                            <div class="tab-pane fade " id="navs-enrolled" role="tabpanel">
                                <div class="row">
                                    <?php
                                    // Get the student ID based on the segment in the URI
                                    $get_studid = $this->db->where("SP_TRANSID", $this->uri->segment(4))->get("tbl_studprof")->row("SP_STUDID");

                                    // Load enrolled data for the student, ordered by ID in descending order
                                    $load_enrolled = $this->db->where("ER_STUDENTID", $get_studid)->order_by("ID", "ASC")->get("tbl_enrollment");

                                    // Check if there are any enrolled records
                                    if ($load_enrolled->num_rows() > 0) {
                                        foreach ($load_enrolled->result() as $row) {
                                    ?>
                                            <div class="col-md-4 mb-3">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5>Year Level: <?= ucwords(strtolower($row->ER_YEARLEVEL)); ?></h5>
                                                        <ul>
                                                            <li>Program: <?= ucwords(strtolower($row->ER_PROGRAM)); ?></li>
                                                            <li>Major: <?= ucwords(strtolower($row->ER_MAJOR)) ?? "*Not available"; ?>
                                                            </li>
                                                            <li>Academic Year:
                                                                <?= $row->ER_ACADEMICYEAR . '-' . ($row->ER_ACADEMICYEAR + 1); ?> </li>
                                                            <li>Semester: <?= ucwords(strtolower($row->ER_SEMESTER)); ?></li>
                                                            <li>Status: <?= ucwords(strtolower($row->ER_ENSTATUS)); ?></li>
                                                        </ul>
                                                        <div class="table-responsive">
                                                            <table class="table table-sm">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Code</th>
                                                                        <th>Subjects</th>
                                                                        <th>Units</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    // Assuming ER_SUBJECTS stores comma-separated subject IDs,
                                                                    // you need to explode it into an array and then implode it
                                                                    // with single quotes for the SQL IN clause.
                                                                    // It's crucial to ensure that ER_SUBJECTS contains valid, comma-separated IDs.
                                                                    if (!empty($row->ER_SUBJECTS)) {
                                                                        $subject_ids = explode(',', $row->ER_SUBJECTS);
                                                                        // Sanitize each ID to prevent SQL injection (important for security)
                                                                        // Assuming IDs are integers, you can cast them to int.
                                                                        $sanitized_ids = array_map('intval', $subject_ids);
                                                                        $subject_ids_string = implode("','", $sanitized_ids); // Create a string like '1','2','3'

                                                                        // Construct the SQL query. It's safer to use query binding if available in your CI version.
                                                                        // For direct query, ensure IDs are properly quoted.
                                                                        $get_subjects = $this->db->query("SELECT * FROM tbl_subject WHERE ID IN('" . $subject_ids_string . "')");

                                                                        if ($get_subjects->num_rows() > 0) {
                                                                            foreach ($get_subjects->result() as $s) {
                                                                    ?>
                                                                                <tr>
                                                                                    <td><?= $s->S_SCODE ?></td>
                                                                                    <td><?= $s->S_SDESCRIPTION ?></td>
                                                                                    <td><?= $s->S_UNITS ?></td>
                                                                                </tr>
                                                                    <?php
                                                                            }
                                                                        } else {
                                                                            // Optional: Display a message if no subjects are found for the given IDs
                                                                            echo '<tr><td colspan="2">No subjects found for this enrollment.</td></tr>';
                                                                        }
                                                                    } else {
                                                                        // Optional: Display a message if ER_SUBJECTS is empty
                                                                        echo '<tr><td colspan="2">No subjects listed for this enrollment.</td></tr>';
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="2" style="text-align: end;">Total Units</td>
                                                                        <td><?= $row->ER_UNITS; ?></td>
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
                                        // Optional: Display a message if no enrolled records are found
                                        echo '<div class="col-md-12"><p>No enrollment records found for this student.</p></div>';
                                    }
                                    ?>
                                </div>
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
function calculate_age($birthdate)
{
    $today = new DateTime();
    $birthDate = new DateTime($birthdate);
    $age = $today->diff($birthDate)->y;
    return $age;
}
?>