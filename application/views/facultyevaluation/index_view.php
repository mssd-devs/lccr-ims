<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Faculty Evaluation</a>
            </li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </nav>

    <div class="row gy-4 mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Filter by:</h5>
                        <button type="button" class="btn btn-warning btn-sm" id="btn_reset_filter"><i
                                class="ri-filter-line"></i> Reset</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_YL" aria-label="Year Level Filter">
                                    <option value="">ALL</option>
                                    <option value="1ST YEAR">1ST YEAR</option>
                                    <option value="2ND YEAR">2ND YEAR</option>
                                    <option value="3RD YEAR">3RD YEAR</option>
                                    <option value="4TH YEAR">4TH YEAR</option>
                                    <option value="5TH YEAR">5TH YEAR</option>
                                </select>
                                <label for="FILTER_YL">Year Level</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FILTER_SEM" aria-label="Semester Filter">
                                    <option value="">ALL</option>
                                    <?php
                                    $sem_query = $this->db->get("tbl_semestertype");
                                    foreach ($sem_query->result() as $sem_row) {
                                    ?>
                                        <option><?= $sem_row->SEM_NAME; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="FILTER_SEM">Semester</label>
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
                    <h4>Evaluation</h4>
                    <div class="table-responsive">
                        <table id="evaluationDataTable" class="table table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Faculty Name</th>
                                    <th>Course Title/Code</th>
                                    <th>Class Schedule</th>
                                    <th>Academic Year and Semester:</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbl_body">
                                <?php
                                $query = $this->db->query("SELECT * FROM tbl_evaluation WHERE status = 'EVALUATED'");
                                $count = 1;
                                foreach ($query->result() as $row) {
                                ?>
                                    <tr>
                                        <td><?= $count++; ?></td>
                                        <td><?= $row->instructor_name; ?></td>
                                        <td><?= $row->course_title; ?></td>
                                        <td><?= $row->class_schedule; ?></td>
                                        <td><?= $row->academic_period; ?></td>
                                         <td>
                                             <div class="d-flex gap-2">
                                                 <a href="<?= base_url('FacultyEvaluationController/ratings/' . $row->ID); ?>" class="btn btn-primary btn-sm"><i class="ri-eye-line"></i> View</a>
                                                 <a href="<?= base_url('FacultyEvaluationController/print_report/' . $row->ID); ?>" target="_blank" class="btn btn-warning btn-sm"><i class="ri-printer-line"></i> Report</a>
                                             </div>
                                         </td>
                                    </tr>
                                <?php
                                }
                                ?>
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
        var table = $('#evaluationDataTable').DataTable({
            destroy: true,
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
            responsive: true,
            autoWidth: true,
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

        // Custom search filter for Year Level and Semester
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var yearFilter = $('#FILTER_YL').val() || "";
                var semFilter = $('#FILTER_SEM').val() || "";
                
                // Academic Period is index 4
                var academicPeriod = data[4] || ""; 

                if (yearFilter !== "") {
                    if (academicPeriod.toUpperCase().indexOf(yearFilter.toUpperCase()) === -1) {
                        return false;
                    }
                }

                if (semFilter !== "") {
                    if (academicPeriod.toUpperCase().indexOf(semFilter.toUpperCase()) === -1) {
                        return false;
                    }
                }

                return true;
            }
        );

        // Redraw table when filters change
        $('#FILTER_YL, #FILTER_SEM').on('change', function() {
            table.draw();
        });

        // Reset filter values and redraw table
        $('#btn_reset_filter').on('click', function() {
            $('#FILTER_YL').val('').trigger('change');
            $('#FILTER_SEM').val('').trigger('change');
        });
    });
</script>