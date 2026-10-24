<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="<?= base_url() ?>assets/" data-template="vertical-menu-template"
    data-style="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Institution Management System</title>

    <meta name="description" content="" />
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?= base_url(); ?>assets/img/favicon/favicon.ico" />
    
    <!-- PWA -->
    <link rel="manifest" href="<?= base_url(); ?>manifest.json" />
    <meta name="theme-color" content="#4F46E5" />
    <link rel="apple-touch-icon" href="<?= base_url(); ?>assets/img/logo-icon.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&ampdisplay=swap"
        rel="stylesheet" />

    <!-- Icons -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/fonts/remixicon/remixicon.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/fonts/flag-icons.css" />

    <!-- Menu waves for no-customizer fix -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/libs/node-waves/node-waves.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/css/rtl/core.css"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/css/rtl/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/css/demo.css" />
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/libs/typeahead-js/typeahead.css" />

    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
    <link rel="stylesheet"
        href="<?= base_url(); ?>assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
    <link rel="stylesheet"
        href="<?= base_url(); ?>assets/vendor/libs/datatables-checkboxes-jquery/datatables.checkboxes.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
    <link rel="stylesheet"
        href="<?= base_url(); ?>assets/vendor/libs/datatables-fixedcolumns-bs5/fixedcolumns.bootstrap5.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/libs/flatpickr/flatpickr.css" />
    <!-- Row Group CSS -->
    <link rel="stylesheet"
        href="<?= base_url(); ?>assets/vendor/libs/datatables-rowgroup-bs5/rowgroup.bootstrap5.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/libs/animate-css/animate.css" />

    <!-- Cropper.js -->
    <link href="<?= base_url() ?>assets/css/cropper.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url() ?>assets/vendor/libs/quill/editor.css" />

    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/libs/sweetalert2/sweetalert2.css" />
    <!-- Form Validation -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/libs/@form-validation/form-validation.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/libs/bs-stepper/bs-stepper.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/libs/select2/select2.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/css/pages/dashboards-crm.css" />
    <script src="<?= base_url(); ?>assets/vendor/js/jquery-3.6.0.min.js"></script>

    <!-- Helpers -->
    <script src="<?= base_url(); ?>assets/vendor/js/helpers.js"></script>
    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="<?= base_url(); ?>assets/vendor/js/template-customizer.js"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="<?= base_url(); ?>assets/js/config.js"></script>
    <style>
        #preview {
            max-width: 100%;
            height: auto;
        }

        .cropper-container {
            max-height: 500px;
            width: 100%;
        }
    </style>
</head>

<body>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="#" class="app-brand-link">
                        <span class="app-brand-logo demo me-1">
                            <?php
                            $footer = $this->db->get("tbl_websettings");
                            if ($footer->num_rows() > 0) {
                                foreach ($footer->result() as $row) {
                                    if (!empty($row->IMS_WEB_LOGO)) {
                            ?>
                                        <span class="app-brand-logo demo me-1">
                                            <img width="30" height="27" src="<?= base_url('assets/img/' . $row->IMS_WEB_LOGO) ?>"
                                                alt="">
                                        </span>
                                    <?php
                                    } else {
                                    ?>
                                        <span style="color: var(--bs-primary)">
                                            <svg width="30" height="24" viewBox="0 0 250 196" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M12.3002 1.25469L56.655 28.6432C59.0349 30.1128 60.4839 32.711 60.4839 35.5089V160.63C60.4839 163.468 58.9941 166.097 56.5603 167.553L12.2055 194.107C8.3836 196.395 3.43136 195.15 1.14435 191.327C0.395485 190.075 0 188.643 0 187.184V8.12039C0 3.66447 3.61061 0.0522461 8.06452 0.0522461C9.56056 0.0522461 11.0271 0.468577 12.3002 1.25469Z"
                                                    fill="currentColor" />
                                                <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M0 65.2656L60.4839 99.9629V133.979L0 65.2656Z" fill="black" />
                                                <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M0 65.2656L60.4839 99.0795V119.859L0 65.2656Z" fill="black" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M237.71 1.22393L193.355 28.5207C190.97 29.9889 189.516 32.5905 189.516 35.3927V160.631C189.516 163.469 191.006 166.098 193.44 167.555L237.794 194.108C241.616 196.396 246.569 195.151 248.856 191.328C249.605 190.076 250 188.644 250 187.185V8.09597C250 3.64006 246.389 0.027832 241.935 0.027832C240.444 0.027832 238.981 0.441882 237.71 1.22393Z"
                                                    fill="currentColor" />
                                                <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M250 65.2656L189.516 99.8897V135.006L250 65.2656Z" fill="black" />
                                                <path opacity="0.077704" fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M250 65.2656L189.516 99.0497V120.886L250 65.2656Z" fill="black" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M12.2787 1.18923L125 70.3075V136.87L0 65.2465V8.06814C0 3.61223 3.61061 0 8.06452 0C9.552 0 11.0105 0.411583 12.2787 1.18923Z"
                                                    fill="currentColor" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M12.2787 1.18923L125 70.3075V136.87L0 65.2465V8.06814C0 3.61223 3.61061 0 8.06452 0C9.552 0 11.0105 0.411583 12.2787 1.18923Z"
                                                    fill="white" fill-opacity="0.15" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M237.721 1.18923L125 70.3075V136.87L250 65.2465V8.06814C250 3.61223 246.389 0 241.935 0C240.448 0 238.99 0.411583 237.721 1.18923Z"
                                                    fill="currentColor" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M237.721 1.18923L125 70.3075V136.87L250 65.2465V8.06814C250 3.61223 246.389 0 241.935 0C240.448 0 238.99 0.411583 237.721 1.18923Z"
                                                    fill="white" fill-opacity="0.3" />
                                            </svg>
                                        </span>
                                    <?php
                                    }
                                    ?>
                        </span>
                        <span
                            class="app-brand-text demo menu-text fw-semibold ms-2"><?= ($row->IMS_WEB_ACRO != "") ? $row->IMS_WEB_ACRO : "MOROBYTE"; ?></span>
                <?php
                                }
                            }
                ?>
                    </a>
                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
                        <i class="menu-toggle-icon d-xl-block align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>


                <ul class="menu-inner py-1">

                    <?php
                    $current_user_id = $this->session->userdata("id");
                    $usertype = $this->session->userdata("usertype");
                    $is_admin = in_array(strtolower(trim($usertype ?? '')), ["superadmin", "super admin"]);

                    if (!function_exists('can_access')) {
                        function can_access($page, $user_id, $usertype)
                        {
                            if (in_array(strtolower(trim($usertype ?? '')), ["superadmin", "super admin"]))
                                return true;
                            return get_instance()->db
                                ->where("USER_ID", $user_id)
                                ->where("PAGE", $page)
                                ->get("tbl_permissions")
                                ->num_rows() > 0;
                        }
                    }
                    ?>


                    <li class="menu-item <?= ($this->uri->segment(2) == "dashboards") ? "active open" : "" ?>">
                        <a href="#" class="menu-link menu-toggle">
                            <i class="menu-icon tf-icons ri-home-smile-line"></i>
                            <div>Dashboards</div>
                        </a>
                        <ul class="menu-sub">

                            <?php if (can_access("Analytics Dashboard", $current_user_id, $usertype)): ?>
                                <li class="menu-item <?= ($this->uri->segment(3) == "analytics") ? "active" : "" ?>">
                                    <a href="<?= base_url("ims/dashboards/analytics") ?>" class="menu-link">
                                        <div>Analytics</div>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php if (can_access("Financial Dashboard", $current_user_id, $usertype)): ?>
                                <li class="menu-item <?= ($this->uri->segment(3) == "financial") ? "active" : "" ?>">
                                    <a href="<?= base_url("ims/dashboards/financial") ?>" class="menu-link">
                                        <div>Financial</div>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </li>


                    <li class="menu-item <?= ($this->uri->segment(2) == "profile") ? "active" : "" ?>">
                        <a href="<?= base_url("ims/profile") ?>" class="menu-link">
                            <i class="menu-icon tf-icons ri-user-line"></i>
                            <div>My Profile</div>
                        </a>
                    </li>

                    <?php if ($usertype == "Registrar" || $is_admin): ?>
                        <li class="menu-header small text-uppercase">
                            <span class="menu-header-text">Registrar Menu</span>
                        </li>
                    <?php endif ?>




                    <?php if (can_access("Student Profile", $current_user_id, $usertype)): ?>
                        <li class="menu-item <?= ($this->uri->segment(2) == "studentprofile") ? "active" : "" ?>">
                            <a href="<?= base_url("ims/studentprofile") ?>" class="menu-link">
                                <i class="menu-icon tf-icons ri-user-add-line"></i>
                                <div>Student Profile</div>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (can_access("Enrollment", $current_user_id, $usertype)): ?>
                        <li class="menu-item <?= ($this->uri->segment(2) == "enrollment") ? "active" : "" ?>">
                            <a href="<?= base_url("ims/enrollment") ?>" class="menu-link">
                                <i class="menu-icon tf-icons ri-layout-grid-line"></i>
                                <div>Enrollment</div>
                            </a>
                        </li>
                    <?php endif; ?>


                    <?php if (can_access("Registrar Grades", $current_user_id, $usertype)): ?>
                        <li class="menu-item <?= ($this->uri->segment(2) == "grade") ? "active open" : "" ?>">
                            <a href="#" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons ri-file-list-3-line"></i>
                                <div>Grades Record</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="menu-item <?= ($this->uri->segment(3) == "rgrades") ? "active" : "" ?>">
                                    <a href="<?= base_url("ims/grade/rgrades") ?>" class="menu-link">
                                        <div>Student</div>
                                    </a>
                                </li>
                                <li class="menu-item <?= ($this->uri->segment(3) == "tfgrades") ? "active" : "" ?>">
                                    <a href="<?= base_url("ims/grade/tfgrades") ?>" class="menu-link">
                                        <div>Transferee</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>


                    <?php if (can_access("Graduates", $current_user_id, $usertype)): ?>
                        <li class="menu-item <?= ($this->uri->segment(2) == "graduates") ? "active" : "" ?>">
                            <a href="<?= base_url("ims/graduates") ?>" class="menu-link">
                                <i class="menu-icon tf-icons ri-graduation-cap-line"></i>
                                <div>Graduates</div>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (can_access("Promotional", $current_user_id, $usertype)): ?>
                        <li class="menu-item <?= ($this->uri->segment(2) == "promotional") ? "active" : "" ?>">
                            <a href="<?= base_url("ims/promotional") ?>" class="menu-link">
                                <i class="menu-icon tf-icons ri-user-follow-line"></i>
                                <div>Promotional</div>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (can_access("Employee Profile", $current_user_id, $usertype)): ?>
                        <li class="menu-item <?= ($this->uri->segment(2) == "facultyprof") ? "active" : "" ?>">
                            <a href="<?= base_url("ims/facultyprof") ?>" class="menu-link">
                                <i class="menu-icon tf-icons ri-user-3-line"></i>
                                <div>Employee Profile</div>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (can_access("Data Management", $current_user_id, $usertype)): ?>
                        <li class="menu-item <?= ($this->uri->segment(2) == "entries") ? "active open" : "" ?>">
                            <a href="#" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons ri-pencil-line"></i>
                                <div>Data Management</div>
                            </a>

                            <ul class="menu-sub">
                                <li class="menu-item <?= ($this->uri->segment(3) == "semestertype") ? "active" : "" ?>">
                                    <a href="<?= base_url("ims/entries/semestertype") ?>" class="menu-link">
                                        <div>Semester Type</div>
                                    </a>
                                </li>
                                <li class="menu-item <?= ($this->uri->segment(3) == "programs") ? "active" : "" ?>">
                                    <a href="<?= base_url("ims/entries/programs") ?>" class="menu-link">
                                        <div>Programs</div>
                                    </a>
                                </li>
                                <li class="menu-item <?= ($this->uri->segment(3) == "subject") ? "active" : "" ?>">
                                    <a href="<?= base_url("ims/entries/subject") ?>" class="menu-link">
                                        <div>Subjects</div>
                                    </a>
                                </li>
                                <li class="menu-item <?= ($this->uri->segment(3) == "department") ? "active" : "" ?>">
                                    <a href="<?= base_url("ims/entries/department") ?>" class="menu-link">
                                        <div>Department</div>
                                    </a>
                                </li>
                                <li class="menu-item <?= ($this->uri->segment(3) == "rooms") ? "active" : "" ?>">
                                    <a href="<?= base_url("ims/entries/rooms") ?>" class="menu-link">
                                        <div>Rooms</div>
                                    </a>
                                </li>
                                <li class="menu-item <?= ($this->uri->segment(3) == "sections") ? "active" : "" ?>">
                                    <a href="<?= base_url("ims/entries/sections") ?>" class="menu-link">
                                        <div>Sections</div>
                                    </a>
                                </li>
                                <li class="menu-item <?= ($this->uri->segment(3) == "requirements") ? "active" : "" ?>">
                                    <a href="<?= base_url("ims/entries/requirements") ?>" class="menu-link">
                                        <div>Requirements</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if (can_access("Scheduling", $current_user_id, $usertype)): ?>
                        <li class="menu-item <?= ($this->uri->segment(2) == "scheduling") ? "active" : "" ?>">
                            <a href="<?= base_url("ims/scheduling") ?>" class="menu-link">
                                <i class="menu-icon tf-icons ri-calendar-check-line"></i>
                                <div>Scheduling</div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (can_access("Evaluation", $current_user_id, $usertype)): ?>
                        <li class="menu-item <?= ($this->uri->segment(2) == "facultyevaluation") ? "active" : "" ?>">
                            <a href="<?= base_url("ims/facultyevaluation") ?>" class="menu-link">
                                <i class="menu-icon tf-icons ri-survey-line"></i>
                                <div>Evaluation</div>
                            </a>
                        </li>
                    <?php endif; ?>

                    <?php if (can_access("Reports", $current_user_id, $usertype)): ?>
                        <li class="menu-item <?= ($this->uri->segment(2) == "") ? "active" : "" ?>">
                            <a href="#" class="menu-link menu-toggle">
                                <i class="menu-icon tf-icons ri-bar-chart-line"></i>
                                <div>Reports</div>
                            </a>
                            <ul class="menu-sub">
                                <li class="menu-item <?= ($this->uri->segment(2) == "") ? "active" : "" ?>">
                                    <a href="<?= base_url("ims/enrollment_report") ?>" class="menu-link">
                                        <div>Enrolment List</div>
                                    </a>
                                </li>
                                <li class="menu-item <?= ($this->uri->segment(2) == "") ? "active" : "" ?>">
                                    <a href="<?= base_url("ims/promotionalreport") ?>" class="menu-link">
                                        <div>Promotional List</div>
                                    </a>
                                </li>
                                <li class="menu-item <?= ($this->uri->segment(2) == "") ? "active" : "" ?>">
                                    <a href="#" class="menu-link">
                                        <div>Graduates</div>
                                    </a>
                                </li>
                                <li class="menu-item <?= ($this->uri->segment(2) == "") ? "active" : "" ?>">
                                    <a href="<?= base_url("ims/faculty_report") ?>" class="menu-link">
                                        <div>Faculty List (NT/T)</div>
                                    </a>
                                </li>
                                <li class="menu-item <?= ($this->uri->segment(2) == "boardpasser") ? "active" : "" ?>">
                                    <a href="<?= base_url("ims/boardpasser") ?>" class="menu-link">
                                        <div>Board Passer</div>
                                    </a>
                                </li>

                                <li class="menu-item <?= ($this->uri->segment(2) == "buildingsfurniture") ? "active" : "" ?>">
                                    <a href="<?= base_url("ims/buildingsfurniture") ?>" class="menu-link">
                                        <div>Building & Furniture</div>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <?php if ($usertype == "Cashier" || $is_admin): ?>
                        <li class="menu-header small text-uppercase">
                            <span class="menu-header-text">Cashier Menu</span>
                        </li>
                    <?php endif ?>



                    <?php if (can_access("Fees Section", $current_user_id, $usertype)): ?>
                        <li class="menu-item <?= ($this->uri->segment(2) == "fees") ? "active" : "" ?>">
                            <a href="<?= base_url("ims/fees") ?>" class="menu-link">
                                <i class="menu-icon tf-icons ri-wallet-3-line"></i>
                                <div>Fees Section</div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (can_access("Billing Section", $current_user_id, $usertype)): ?>
                        <li class="menu-item <?= ($this->uri->segment(2) == "cashierbilling") ? "active" : "" ?>">
                            <a href="<?= base_url("ims/cashierbilling") ?>" class="menu-link">
                                <i class="menu-icon tf-icons ri-money-cny-circle-line"></i>
                                <div>Billing Section</div>
                            </a>
                        </li>
                    <?php endif; ?>


                    <?php if ($usertype == "Faculty" || $is_admin): ?>
                        <li class="menu-header small text-uppercase">
                            <span class="menu-header-text">Faculty Menu</span>
                        </li>
                    <?php endif ?>


                    <?php if (can_access("My Class", $current_user_id, $usertype)): ?>
                        <li class="menu-item <?= ($this->uri->segment(2) == "myclass") ? "active" : "" ?>">
                            <a href="<?= base_url("ims/myclass") ?>" target="" class="menu-link">
                                <i class="menu-icon tf-icons ri-file-list-line"></i>
                                <div>My Class</div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (can_access("Grading System", $current_user_id, $usertype)): ?>
                        <li class="menu-item <?= ($this->uri->segment(2) == "gradingsystem") ? "active" : "" ?>">
                            <a href="<?= base_url("ims/gradingsystem") ?>" target="" class="menu-link">
                                <i class="menu-icon tf-icons ri-file-edit-line"></i>
                                <div>Grading System</div>
                            </a>
                        </li>
                    <?php endif; ?>
                    <!-- <?php if (can_access("Faculty Grades", $current_user_id, $usertype)): ?>
                        <li class="menu-item <?= ($this->uri->segment(2) == "grades") ? "active" : "" ?>">
                            <a href="<?= base_url("ims/grades") ?>" target="" class="menu-link">
                                <i class="menu-icon tf-icons ri-file-check-line"></i>
                                <div>Grades</div>
                            </a>
                        </li>
                    <?php endif; ?> -->

                    <?php
                    $hasUserManagement = can_access("User Management", $current_user_id, $usertype);
                    $hasAuditTrail = can_access("Audit Trail", $current_user_id, $usertype);
                    $hasWebSettings = can_access("Web Settings", $current_user_id, $usertype);
                    $hasAbout = can_access("About", $current_user_id, $usertype);

                    if ($hasUserManagement || $hasAuditTrail || $hasWebSettings || $hasAbout || $is_admin) {
                    ?>
                        <li class="menu-header small text-uppercase">
                            <span class="menu-header-text">Others</span>
                        </li>

                        <?php if ($hasUserManagement): ?>
                            <li class="menu-item <?= ($this->uri->segment(2) == "users") ? "active" : "" ?>">
                                <a href="<?= base_url("ims/users") ?>" class="menu-link">
                                    <i class="menu-icon tf-icons ri-account-circle-line"></i>
                                    <div>User Management</div>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ($hasAuditTrail): ?>
                            <li class="menu-item <?= ($this->uri->segment(2) == "audittrail") ? "active" : "" ?>">
                                <a href="<?= base_url("ims/audittrail") ?>" class="menu-link">
                                    <i class="menu-icon tf-icons ri-time-line"></i>
                                    <div>Audit Trail</div>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ($hasWebSettings): ?>
                            <li class="menu-item <?= ($this->uri->segment(2) == "websettings") ? "active" : "" ?>">
                                <a href="<?= base_url("ims/websettings") ?>" class="menu-link">
                                    <i class="menu-icon tf-icons ri-settings-3-line"></i>
                                    <div>Web Settings</div>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ($hasAbout): ?>
                            <li class="menu-item <?= ($this->uri->segment(2) == "about") ? "active" : "" ?>">
                                <a href="<?= base_url("ims/about") ?>" class="menu-link">
                                    <i class="menu-icon tf-icons ri-information-line"></i>
                                    <div>About</div>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php
                    }
                    ?>
                </ul>
            </aside>
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->


                <!-- Navbar -->

                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
                    id="layout-navbar">
                    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-4 me-xl-0 d-xl-none">
                        <a class="nav-item nav-link px-0 me-xl-6" href="javascript:void(0)">
                            <i class="ri-menu-fill ri-24px"></i>
                        </a>
                    </div>

                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <!-- Search -->
                        <div class="navbar-nav align-items-center">
                            <div class="nav-item navbar-search-wrapper mb-0">
                                <span class="fw-bold">Institution Management System</span>
                            </div>
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">


                            <!-- Style Switcher -->
                            <li class="nav-item dropdown-style-switcher dropdown mr-2">
                                <a class="nav-link btn btn-text-secondary rounded-pill btn-icon dropdown-toggle hide-arrow"
                                    href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <i class="ri-22px"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
                                            <span class="align-middle"><i
                                                    class="ri-sun-line ri-22px me-3"></i>Light</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
                                            <span class="align-middle"><i
                                                    class="ri-moon-clear-line ri-22px me-3"></i>Dark</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
                                            <span class="align-middle"><i
                                                    class="ri-computer-line ri-22px me-3"></i>System</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!-- / Style Switcher-->
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown ">
                                <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);"
                                    data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="<?= ($this->session->userdata("user_image") != "") ? base_url("assets/img/" . $this->session->userdata("user_image")) : base_url("assets/img/avatars/1.png") ?>"
                                            alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end mt-3 py-2">
                                    <li>
                                        <a class="dropdown-item" href="">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-2">
                                                    <div class="avatar avatar-online">

                                                        <img src="<?= ($this->session->userdata("user_image") != "") ? base_url("assets/img/" . $this->session->userdata("user_image")) : base_url("assets/img/avatars/1.png") ?>"
                                                            alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-0 small"><?= $this->session->userdata('fullname'); ?>
                                                    </h6>
                                                    <small
                                                        class="text-muted"><?= $this->session->userdata('usertype'); ?></small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="dropdown-divider"></div>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="<?= base_url("ims/profile") ?>">
                                            <i class="ri-user-3-line ri-22px me-2"></i>
                                            <span class="align-middle">My Profile</span>
                                        </a>
                                    </li>
                                    <li>
                                        <div class="d-grid px-4 pt-2 pb-1">
                                            <button class="btn btn-danger btn-logout d-flex" type="button">
                                                <small class="align-middle">Logout</small>
                                                <i class="ri-logout-box-r-line ms-2 ri-16px"></i>
                                            </button>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!--/ User -->
                        </ul>
                    </div>
                </nav>

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->