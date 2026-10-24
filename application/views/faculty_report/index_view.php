<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Employee Profile Report</a>
            </li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </nav>
    <div class="row gy-4 mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title">Filter by:</h5>
                        <button type="button" class="btn btn-warning btn-sm" id="btn_reset_filter"><i
                                class="ri-filter-line"></i> Reset</button>
                        <script>
                            $(document).on("click", "#btn_reset_filter", function() {
                                window.location.reload();
                            });
                        </script>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" class="txt_csrfname"
                                name="<?= $this->security->get_csrf_token_name(); ?>"
                                value="<?= $this->security->get_csrf_hash(); ?>">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_TENURE" name="FILTER_TENURE"
                                    aria-label="Default select example">
                                    <option value="">ALL</option>
                                    <?php
                                    foreach ($LoadTenure->result() as $r) {
                                    ?>
                                        <option><?= $r->REF_DESC; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="basic-default-fullname">Tenure of Employment</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_EMPLOYEE_TYPE" name="FILTER_EMPLOYEE_TYPE"
                                    aria-label="Default select example">
                                    <option value="">ALL</option>
                                    <option value="Teaching">Teaching</option>
                                    <option value="Non-Teaching">Non-Teaching</option>
                                </select>
                                <label for="basic-default-fullname">Employee Type</label>
                            </div>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Employee Profile Report</h5>
                    <p class="alert alert-danger" role="alert">This report displays the profile of all employees including their
                        employment status, rank/position, and tenure of employment.</p>
                    <?php
                    $query = $this->db->query("SELECT COUNT(*) AS total_teaching FROM tbl_facprof WHERE FP_EMPLOYEETYPE = 'TEACHING'");
                    $teaching_count = $query->row()->total_teaching;
                    $query1 = $this->db->query("SELECT COUNT(*) AS total_non_teaching FROM tbl_facprof WHERE FP_EMPLOYEETYPE = 'NON-TEACHING' OR FP_EMPLOYEETYPE IS NULL OR FP_EMPLOYEETYPE = ''");
                    $non_teaching_count = $query1->row()->total_non_teaching;
                    ?>
                    <div class="row mb-3">
                        <div class="col-sm-6 col-lg-6 mb-6">
                            <div class="card card-border-shadow-primary h-100">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar me-4">
                                            <span class="avatar-initial rounded bg-label-primary"><i
                                                    class="ri-user-line ri-24px"></i></span>
                                        </div>
                                        <h4 class="mb-0" id="total-amount-billed"><?= $teaching_count ?></h4>
                                    </div>
                                    <h6 class="mb-0 fw-normal">Total Teaching Employee</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-6 mb-6">
                            <div class="card card-border-shadow-success h-100">
                                <div class="card-body">
                                    <div class="d-flex  align-items-center justify-content-between">
                                        <div class="d-flex align-items-center mb-2">
                                            <div class="avatar me-4">
                                                <span class="avatar-initial rounded bg-label-success"><i
                                                        class="ri-user-line ri-24px"></i></span>
                                            </div>
                                            <h4 class="mb-0" id="total-payments-received"><?= $non_teaching_count ?></h4>
                                        </div>
                                    </div>
                                    <h6 class="mb-0 fw-normal">Total Non-Teaching Employee</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive pt-0">
                        <table id="dataTable" class="table table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Employee I.D</th>
                                    <th>Name of Employee</th>
                                    <th>Gender</th>
                                    <th>Rank/Position</th>
                                    <th>Tenure of Employment</th>
                                    <th>Employee Status</th>
                                </tr>
                            </thead>
                            <tbody id="tbl_body">
                                <!-- Data will be populated here via AJAX -->

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        LoadEmployee();
        const filterSelectors = "#FILTER_TENURE, #FILTER_EMPLOYEE_TYPE";
        $(filterSelectors).on("change", function() {
            // showLoadingForm();
            LoadEmployee();

        });

        // LoadEnrollment function to fetch and display enrollment data
        function LoadEmployee() {

            $.ajax({
                url: "<?= base_url("FacultyReportController/LoadEmployee"); ?>",
                method: "POST",
                dataType: 'json',
                data: {
                    FILTER_TENURE: $("#FILTER_TENURE").val(),
                    FILTER_EMPLOYEE_TYPE: $("#FILTER_EMPLOYEE_TYPE").val(),
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                },
                success: function(result) {
                    // Update CSRF hash
                    $('.txt_csrfname').val(result.token);
                    // Destroy datatable
                    $("#dataTable").DataTable().clear().destroy();
                    // Load data into table body
                    $("#tbl_body").html(result.output);
                    // Reload DataTable
                    initializeDataTable();

                },
                error: function(jqXHR, errorType, error) {
                    alert(error);
                }
            });
        }
    });


    function initializeDataTable() {
        $('#dataTable').DataTable({
            dom: '<"d-flex justify-content-between align-items-center"<"export-dropdown"B><"search-box"f>>rtip', // Custom layout
            buttons: [{
                extend: 'collection',
                text: '<i class="ri-download-2-line"></i> Export Data',
                buttons: [{
                        extend: 'copy',
                        text: 'Copy to Clipboard'
                    },
                    {
                        extend: 'csv',
                        text: 'Export as CSV'
                    },
                    {
                        extend: 'excel',
                        text: 'Export as Excel'
                    },
                    {
                        extend: 'pdf',
                        text: 'Export as PDF'
                    },
                    {
                        extend: 'print',
                        text: 'Print Table'
                    }
                ]
            }],
            responsive: false,
            autoWidth: true,
            fixedColumns: {
                left: 1, // Freezes first column
                right: 1 // Freezes last column
            },
            order: [
                [0, 'desc'] // Default sorting by the second column (No.)
            ],
            pageLength: 10,
            lengthMenu: [5, 10, 25, 50, 75, 100],
            language: {
                search: "Search:",
                lengthMenu: "Display _MENU_ records per page",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            }
        });
    }
</script>