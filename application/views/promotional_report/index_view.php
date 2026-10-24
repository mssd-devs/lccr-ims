<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Promotional Report</a>
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
                        <button type="button" class="btn btn-warning btn-sm" id="btn_reset_filter"><i class="ri-filter-line"></i> Reset</button>
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
                            <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_PROGRAM" name="FILTER_PROGRAM" aria-label="Default select example">
                                    <option value="">ALL</option>
                                    <?php
                                    $query = $this->db->query("SELECT DISTINCT(P_PDESCRIPTIONS) FROM tbl_program");
                                    foreach ($query->result() as $r) {
                                    ?>
                                        <option><?= $r->P_PDESCRIPTIONS; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="basic-default-fullname">Program</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_MAJOR" aria-label="Default select example">
                                    <option value="">--SELECT--</option>
                                </select>
                                <label for="basic-default-fullname">Major</label>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    $("#FILTER_PROGRAM").on("change", function() {
                                        if ($(this).val() != "") {
                                            LoadProgramMajor($(this).val());
                                        }
                                    });

                                    function LoadProgramMajor(FILTER_MAJOR) {
                                        $.ajax({
                                            url: "<?= base_url("EnrollmentController/LoadProgramMajor"); ?>",
                                            method: "POST",
                                            dataType: 'json',
                                            data: {
                                                ER_PROGRAM: FILTER_MAJOR,
                                                [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                                            },
                                            success: function(result) {
                                                // Update CSRF hash
                                                $('.txt_csrfname').val(result.token);
                                                $('#FILTER_MAJOR').html(result.output);
                                            },
                                            error: function(jqXHR, errorType, error) {
                                                alert(error);
                                            }
                                        });
                                    }
                                });
                            </script>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_YL" aria-label="Default select example">
                                    <option value="">ALL</option>
                                    <option value="1ST YEAR">1ST YEAR</option>
                                    <option value="2ND YEAR">2ND YEAR</option>
                                    <option value="3RD YEAR">3RD YEAR</option>
                                    <option value="4TH YEAR">4TH YEAR</option>
                                </select>
                                <label for="basic-default-fullname">Year Level</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_AY" aria-label="Default select example">
                                    <?php for ($start_year = date('Y'); $start_year >= 2000; $start_year--) : ?>
                                        <option value="<?php echo $start_year; ?>"><?php echo $start_year . '-' . ($start_year + 1); ?></option>
                                    <?php endfor; ?>
                                </select>
                                <label for="basic-default-fullname">Academic Year</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_SEM" aria-label="Default select example">
                                    <option value="">ALL</option>
                                    <?php
                                    $query = $this->db->get("tbl_semestertype");
                                    foreach ($query->result() as $r) {
                                    ?>
                                        <option><?= $r->SEM_NAME; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="basic-default-fullname">Semester</label>
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
                    <h4>Promotional Report</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" id="dataTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th class="d-none">ID</th>
                                    <th>
                                        <div class="form-check form-check-success">
                                            <input class="form-check-input" type="checkbox" id="selectAll"> Select All
                                        </div>
                                    </th>
                                    <th>Student I.D</th>
                                    <th>Name</th>
                                    <th>Sex</th>
                                    <th>Program(Major)</th>
                                    <th>Year Level</th>
                                    <th>Academic Year</th>
                                    <th>Semester</th>
                                    <th>Promotional Status</th>
                                </tr>
                            </thead>
                            <tbody id="tbl_body">
                            </tbody>
                        </table>
                    </div>
                    <div class="form-group">
                        <!-- <button type="button" class="btn btn-primary btn-sm" onclick="window.open('<?= base_url('ims/promotionalreport/print'); ?>', '_blank')"><i class="ri ri-printer-line"></i> Print Promoted</button> -->
                        <button type="button" class="btn btn-outline-primary btn-sm" id="btnPrintSelected">
                            <i class="ri-printer-line"></i> Print Selected Promoted
                        </button>
                        <script>
                            $(document).on("click", "#btnPrintSelected", function() {
                                const selectedStudents = [];
                                // Ensure only checkboxes with value (ID) are considered
                                $(".select-checkbox:checked").each(function() {
                                    const id = $(this).val();
                                    if (id) {
                                        // Check for PROMOTED status in the row
                                        const $row = $(this).closest('tr');
                                        const statusText = $row.find('td').eq(9).text().trim().toUpperCase();
                                        if (statusText === "PROMOTED") {
                                            // Assuming Student ID is in the 3rd column (index 2)
                                            const studentId = $row.find('td').eq(2).text().trim();
                                            const academicyear = $row.find('td').eq(7).text().trim();
                                            const semester = $row.find('td').eq(8).text().trim();
                                            selectedStudents.push({
                                                id: id,
                                                student_id: studentId,
                                                academic_year: academicyear,
                                                semester: semester
                                            });
                                        }
                                    }
                                });

                                if (selectedStudents.length === 0) {
                                    Swal.fire({
                                        icon: 'warning',
                                        title: 'No Selection',
                                        text: 'Please select at least one promoted student to print.'
                                    });
                                    return;
                                }

                                // Pass both ID and Student ID as JSON string in query parameter
                                const url = "<?= base_url('ims/promotionalreport/print'); ?>?students=" + encodeURIComponent(JSON.stringify(selectedStudents));
                                window.open(url, '_blank');
                            });
                        </script>
                        <button type="button" class="btn btn-outline-danger btn-sm" id="btnGeneratePDFSelected">
                            <i class="ri-file-pdf-2-line"></i> Generate PDF (Selected Promoted)
                        </button>
                        <button type="button" class="btn btn-outline-success btn-sm" id="btnGenerateExcelSelected">
                            <i class="ri-file-excel-2-line"></i> Generate Excel (Selected Promoted)
                        </button>
                    </div>
                    <script>
                        $(document).on("click", "#btnGeneratePDFSelected", function() {
                            const selectedIds = [];
                            $(".select-checkbox:checked").each(function() {
                                selectedIds.push($(this).val());
                            });

                            if (selectedIds.length === 0) {
                                Swal.fire({
                                    icon: 'warning',
                                    title: 'No Selection',
                                    text: 'Please select at least one promoted student.'
                                });
                                return;
                            }

                            // Open PDF in new tab (POST via form)
                            const form = $('<form>', {
                                action: "<?= base_url('PromotionalReportController/generatePDFSelected'); ?>",
                                method: 'POST',
                                target: '_blank'
                            }).append(
                                $('<input>', {
                                    type: 'hidden',
                                    name: 'ids',
                                    value: selectedIds.join(',')
                                }),
                                $('<input>', {
                                    type: 'hidden',
                                    name: $('.txt_csrfname').attr('name'),
                                    value: $('.txt_csrfname').val()
                                })
                            );
                            $('body').append(form);
                            form.submit();
                            form.remove();
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Select All functionality -->
    <script>
        document.getElementById("selectAll").addEventListener("change", function() {
            const checkboxes = document.querySelectorAll(".select-checkbox");
            checkboxes.forEach(checkbox => checkbox.checked = this.checked);
        });
    </script>
</div>

<script>
    $(document).ready(function() {
        LoadEnrollment();
        const filterSelectors = "#FILTER_PROGRAM, #FILTER_MAJOR, #FILTER_YL, #FILTER_AY, #FILTER_SEM";
        $(filterSelectors).on("change", function() {
            // showLoadingForm();
            LoadEnrollment();

        });

        // LoadEnrollment function to fetch and display enrollment data
        function LoadEnrollment() {

            $.ajax({
                url: "<?= base_url("PromotionalReportController/LoadEnrollment"); ?>",
                method: "POST",
                dataType: 'json',
                data: {
                    FILTER_PROGRAM: $("#FILTER_PROGRAM").val(),
                    FILTER_MAJOR: $("#FILTER_MAJOR").val(),
                    FILTER_YL: $("#FILTER_YL").val(),
                    FILTER_AY: $("#FILTER_AY").val(),
                    FILTER_SEM: $("#FILTER_SEM").val(),
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
        // Add a dropdown to choose status
        function showStatusSelect(callback) {
            const modal = $(`
        <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select Promotional Status</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-floating form-floating-outline mb-4">
                            <select class="form-select select2" id="promotionStatusSelect">
                                <option value="">-- Select Status --</option>
                                <option value="PROMOTED">PROMOTED</option>
                                <option value="UNPROMOTED">UNPROMOTED</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="confirmStatusBtn">Confirm</button>
                    </div>
                </div>
            </div>
        </div>
    `);

            $('body').append(modal);
            const modalInstance = new bootstrap.Modal(document.getElementById('statusModal'));
            modalInstance.show();

            $('#confirmStatusBtn').on('click', function() {
                const selectedStatus = $('#promotionStatusSelect').val();
                if (!selectedStatus) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Invalid',
                        text: 'Please select a valid status.'
                    });
                    return;
                }
                modalInstance.hide();
                $('#statusModal').remove(); // Clean up modal from DOM
                callback(selectedStatus);
            });
        }

        // Event listener for the Promote button
        $("#btnPromote").on("click", function() {
            const selectedIds = [];
            $(".select-checkbox:checked").each(function() {
                selectedIds.push($(this).val());
            });

            if (selectedIds.length === 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'No Selection',
                    text: 'Please select at least one student to update.'
                });
                return;
            }

            // Show select modal
            showStatusSelect(function(status) {
                $.ajax({
                    url: "<?= base_url("PromotionalReportController/updatePromotionStatus"); ?>",
                    method: "POST",
                    dataType: 'json',
                    data: {
                        ids: selectedIds.join(','),
                        status: status,
                        [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                    },
                    success: function(response) {
                        $('.txt_csrfname').val(response.token);
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                location.reload(); // Refresh the page
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Failed',
                                text: response.message
                            });
                        }
                    },
                    error: function(jqXHR, errorType, error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error
                        });
                    }
                });
            });
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
    });
</script>