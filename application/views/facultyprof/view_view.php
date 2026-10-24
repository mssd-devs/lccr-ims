<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="<?= base_url('ims/facultyprof'); ?>">Employee Profile</a>
            </li>
            <li class="breadcrumb-item active">View Record</li>
        </ol>
    </nav>

    <?php
    if ($FetchFacultyProfile && $FetchFacultyProfile->num_rows() > 0) {
        $rows = $FetchFacultyProfile->row();
        $suffix = (!empty($rows->FP_SUFFIX)) ? ' ' . $rows->FP_SUFFIX : '';
        $fullname = $rows->FP_LASTNAME . $suffix . ', ' . $rows->FP_FIRSTNAME . ' ' . $rows->FP_MIDDLENAME;

        function calculate_age_view($birthdate)
        {
            if (empty($birthdate)) return 'N/A';
            $today = new DateTime();
            $birthDate = new DateTime($birthdate);
            return $today->diff($birthDate)->y;
        }
    ?>
        <!-- Header -->
        <div class="row">
            <div class="col-md-12">
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>"
                    value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="card mb-6">
                    <div class="user-profile-header d-flex flex-column flex-lg-row text-sm-start text-center mb-4 pt-4">
                        <div class="flex-shrink-0 mx-sm-0 mx-auto">
                            <div class="avatar avatar-xl ms-0 ms-sm-5 rounded bg-primary text-white d-flex align-items-center justify-content-center" style="width: 100px; height: 100px; font-size: 2.5rem;">
                                <i class="ri-user-3-line"></i>
                            </div>
                        </div>

                        <div class="flex-grow-1 mt-3">
                            <div class="d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start mx-5 flex-md-row flex-column gap-4">
                                <div class="user-profile-info">
                                    <h4 class="mb-2 fw-bold"><?= htmlspecialchars($fullname); ?></h4>
                                    <ul class="list-inline mb-0 d-flex align-items-center flex-wrap justify-content-sm-start justify-content-center gap-4">
                                        <li class="list-inline-item">
                                            <span class="fw-medium">Employee ID: </span>
                                            <span class="badge bg-label-primary fs-6"><?= htmlspecialchars($rows->FP_FACID); ?></span>
                                        </li>
                                        <li class="list-inline-item">
                                            <span class="fw-medium">Employee Type: </span>
                                            <span class="badge bg-label-info fs-6"><?= htmlspecialchars($rows->FP_EMPLOYEETYPE ?: 'N/A'); ?></span>
                                        </li>
                                        <li class="list-inline-item">
                                            <span class="fw-medium">Rank / Position: </span>
                                            <span class="badge bg-label-secondary fs-6"><?= htmlspecialchars($rows->FP_FACRANK ?: 'N/A'); ?></span>
                                        </li>
                                        <li class="list-inline-item">
                                            <span class="fw-medium">Tenure: </span>
                                            <span class="badge bg-label-success fs-6"><?= htmlspecialchars($rows->FP_TENURE ?: 'N/A'); ?></span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="d-flex gap-2">
                                    <?php if (in_array("Edit", $permission ?? []) || $this->session->userdata("usertype") == "Administrator"): ?>
                                        <a href="<?= base_url("ims/facultyprof/edit/" . $rows->FP_TRANSID); ?>" class="btn btn-primary">
                                            <i class="ri-edit-line me-1"></i> Edit Profile
                                        </a>
                                    <?php endif; ?>
                                    <a href="<?= base_url("ims/facultyprof"); ?>" class="btn btn-outline-secondary">
                                        <i class="ri-arrow-left-line me-1"></i> Back to List
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Header -->

        <!-- Details Tabs -->
        <div class="row gy-4">
            <div class="col-xl-12">
                <div class="nav-align-top mb-6">
                    <ul class="nav nav-pills mb-4 nav-fill" role="tablist">
                        <li class="nav-item">
                            <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-personal" aria-controls="navs-personal" aria-selected="true">
                                <i class="ri-user-line me-1"></i> Personal Information
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-employment" aria-controls="navs-employment" aria-selected="false">
                                <i class="ri-briefcase-line me-1"></i> Employment & Rank
                            </button>
                        </li>
                        <li class="nav-item">
                            <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                data-bs-target="#navs-education" aria-controls="navs-education" aria-selected="false">
                                <i class="ri-graduation-cap-line me-1"></i> Educational Background
                            </button>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <!-- Personal Information Tab -->
                        <div class="tab-pane fade show active" id="navs-personal" role="tabpanel">
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h5 class="fw-bold mb-3"><i class="ri-user-3-line me-1"></i> Personal Background</h5>
                                    <div class="row">
                                        <div class="col-xl-6 col-12">
                                            <dl class="row mb-0 gx-2">
                                                <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Last Name:</dt>
                                                <dd class="col-sm-8"><?= htmlspecialchars($rows->FP_LASTNAME); ?></dd>

                                                <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">First Name:</dt>
                                                <dd class="col-sm-8"><?= htmlspecialchars($rows->FP_FIRSTNAME); ?></dd>

                                                <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Middle Name:</dt>
                                                <dd class="col-sm-8"><?= htmlspecialchars($rows->FP_MIDDLENAME ?: 'N/A'); ?></dd>

                                                <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Suffix:</dt>
                                                <dd class="col-sm-8"><?= htmlspecialchars($rows->FP_SUFFIX ?: 'N/A'); ?></dd>

                                                <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Date of Birth | Age:</dt>
                                                <dd class="col-sm-8">
                                                    <?= !empty($rows->FP_BIRTHDAY) ? date('M d, Y', strtotime($rows->FP_BIRTHDAY)) : 'N/A'; ?>
                                                    (<?= calculate_age_view($rows->FP_BIRTHDAY); ?> years old)
                                                </dd>

                                                <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Gender:</dt>
                                                <dd class="col-sm-8"><?= htmlspecialchars($rows->FP_GENDER ?: 'N/A'); ?></dd>
                                            </dl>
                                        </div>
                                        <div class="col-xl-6 col-12">
                                            <dl class="row mb-0 gx-2">
                                                <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Contact No.:</dt>
                                                <dd class="col-sm-8"><?= htmlspecialchars($rows->FP_CPNUMBER ?: 'N/A'); ?></dd>

                                                <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Email Address:</dt>
                                                <dd class="col-sm-8"><?= htmlspecialchars($rows->FP_EMAIL ?: 'N/A'); ?></dd>

                                                <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Civil Status:</dt>
                                                <dd class="col-sm-8"><?= htmlspecialchars($rows->FP_CIVILSTAT ?: 'N/A'); ?></dd>

                                                <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Nationality:</dt>
                                                <dd class="col-sm-8"><?= htmlspecialchars($rows->FP_NATIONALITY ?: 'N/A'); ?></dd>

                                                <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Religion:</dt>
                                                <dd class="col-sm-8"><?= htmlspecialchars($rows->FP_RELIGION ?: 'N/A'); ?></dd>

                                                <dt class="col-sm-4 mb-sm-2 text-nowrap fw-medium text-heading">Ethnic Tribe:</dt>
                                                <dd class="col-sm-8"><?= htmlspecialchars($rows->FP_TRIBE ?: 'N/A'); ?></dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <h5 class="fw-bold mb-3"><i class="ri-map-pin-line me-1"></i> Complete Address</h5>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php
                                            $reg = !empty($rows->FP_REGION) ? $this->db->where("regCode", $rows->FP_REGION)->get("refregion")->row("regDesc") : "";
                                            $prov = !empty($rows->FP_PROVINCE) ? $this->db->where("provCode", $rows->FP_PROVINCE)->get("refprovince")->row("provDesc") : "";
                                            $city = !empty($rows->FP_MUNICIPALITY) ? $this->db->where("citymunCode", $rows->FP_MUNICIPALITY)->get("refcitymun")->row("citymunDesc") : "";
                                            $brgy = !empty($rows->FP_BRGY) ? $this->db->where("brgyCode", $rows->FP_BRGY)->get("refbrgy")->row("brgyDesc") : "";

                                            $address_parts = array_filter([$rows->FP_STRT, $brgy, $city, $prov, $reg, $rows->FP_ZCODE]);
                                            $complete_address = !empty($address_parts) ? implode(', ', $address_parts) : 'No address specified.';
                                            ?>
                                            <p class="fs-6 text-secondary mb-0"><?= htmlspecialchars($complete_address); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Employment & Rank Tab -->
                        <div class="tab-pane fade" id="navs-employment" role="tabpanel">
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h5 class="fw-bold mb-3"><i class="ri-briefcase-3-line me-1"></i> Employment Details</h5>
                                    <div class="row">
                                        <div class="col-xl-6 col-12">
                                            <dl class="row mb-0 gx-2">
                                                <dt class="col-sm-5 mb-sm-2 text-nowrap fw-medium text-heading">Employee Type:</dt>
                                                <dd class="col-sm-7"><?= htmlspecialchars($rows->FP_EMPLOYEETYPE ?: 'N/A'); ?></dd>

                                                <dt class="col-sm-5 mb-sm-2 text-nowrap fw-medium text-heading">Teaching Status:</dt>
                                                <dd class="col-sm-7"><?= htmlspecialchars($rows->FP_FULLTIME ?: 'N/A'); ?></dd>

                                                <dt class="col-sm-5 mb-sm-2 text-nowrap fw-medium text-heading">Tenure of Employment:</dt>
                                                <dd class="col-sm-7"><?= htmlspecialchars($rows->FP_TENURE ?: 'N/A'); ?></dd>
                                            </dl>
                                        </div>
                                        <div class="col-xl-6 col-12">
                                            <dl class="row mb-0 gx-2">
                                                <dt class="col-sm-5 mb-sm-2 text-nowrap fw-medium text-heading">Rank / Position:</dt>
                                                <dd class="col-sm-7"><?= htmlspecialchars($rows->FP_FACRANK ?: 'N/A'); ?></dd>

                                                <dt class="col-sm-5 mb-sm-2 text-nowrap fw-medium text-heading">Professional License:</dt>
                                                <dd class="col-sm-7"><?= htmlspecialchars($rows->FP_PLICENSE ?: 'N/A'); ?></dd>

                                                <dt class="col-sm-5 mb-sm-2 text-nowrap fw-medium text-heading">Annual Salary Grade:</dt>
                                                <dd class="col-sm-7"><?= htmlspecialchars($rows->FP_ASALARY ?: 'N/A'); ?></dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Educational Background Tab -->
                        <div class="tab-pane fade" id="navs-education" role="tabpanel">
                            <div class="row mt-3">
                                <div class="col-md-12">
                                    <h5 class="fw-bold mb-3"><i class="ri-award-line me-1"></i> Highest Degree Attainments</h5>
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <dl class="row mb-0 gx-2">
                                                <dt class="col-sm-5 mb-sm-2 text-nowrap fw-medium text-heading">Highest Degree:</dt>
                                                <dd class="col-sm-7"><?= htmlspecialchars($rows->FP_HIGHDEGREE ?: 'N/A'); ?></dd>

                                                <dt class="col-sm-5 mb-sm-2 text-nowrap fw-medium text-heading">Bachelors Degree:</dt>
                                                <dd class="col-sm-7"><?= htmlspecialchars($rows->FP_BDEGREE ?: 'N/A'); ?></dd>
                                            </dl>
                                        </div>
                                        <div class="col-md-6">
                                            <dl class="row mb-0 gx-2">
                                                <dt class="col-sm-5 mb-sm-2 text-nowrap fw-medium text-heading">Masters Degree:</dt>
                                                <dd class="col-sm-7"><?= htmlspecialchars($rows->FP_MDEGREE ?: 'N/A'); ?></dd>

                                                <dt class="col-sm-5 mb-sm-2 text-nowrap fw-medium text-heading">Doctorate Degree:</dt>
                                                <dd class="col-sm-7"><?= htmlspecialchars($rows->FP_DDEGRE ?: 'N/A'); ?></dd>
                                            </dl>
                                        </div>
                                    </div>
                                    <hr class="my-4">
                                    <h5 class="fw-bold mb-3"><i class="ri-history-line me-1"></i> Educational History</h5>
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Attainment Level</th>
                                                    <th>Name of School</th>
                                                    <th>School Address</th>
                                                    <th>Year</th>
                                                    <th>Course / Program</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (isset($FetchSchool) && $FetchSchool->num_rows() > 0): ?>
                                                    <?php foreach ($FetchSchool->result() as $s): ?>
                                                        <tr>
                                                            <td><?= htmlspecialchars($s->EDUC_ATTAIN); ?></td>
                                                            <td><?= htmlspecialchars($s->EDUC_NAMEOFSCHOOL); ?></td>
                                                            <td><?= htmlspecialchars($s->EDUC_ADDRESS); ?></td>
                                                            <td><?= htmlspecialchars($s->EDUC_YEAR); ?></td>
                                                            <td><?= htmlspecialchars($s->EDUC_PROGRAM ?: 'N/A'); ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <tr>
                                                        <td colspan="5" class="text-center">No educational history records found.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } else { ?>
        <div class="card">
            <div class="card-body text-center p-5">
                <i class="ri-error-warning-line display-3 text-warning"></i>
                <h4 class="mt-3">Employee Profile Not Found</h4>
                <p class="text-muted">The requested employee profile record does not exist or has been removed.</p>
                <a href="<?= base_url('ims/facultyprof'); ?>" class="btn btn-primary">Back to List</a>
            </div>
        </div>
    <?php } ?>
</div>
