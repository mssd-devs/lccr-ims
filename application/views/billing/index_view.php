<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Billing</a>
            </li>
            <li class="breadcrumb-item active">Views</li>
        </ol>
    </nav>
    <div class="row gy-4 mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5>Filter by:</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="" aria-label="Default select example">
                                    <option selected="">--Select Program--</option>
                                </select>
                                <label for="basic-default-fullname">Program</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="" aria-label="Default select example">
                                    <option selected="">--Select Year Level--</option>
                                    <option value="1st">1st Year</option>
                                    <option value="2nd">2nd Year</option>
                                    <option value="3rd">3rd Year</option>
                                    <option value="4th">4nd Year</option>
                                    <option value="5th">5th Year</option>
                                </select>
                                <label for="basic-default-fullname">Year Level</label>
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="" aria-label="Default select example">
                                    <option selected="">--Select Academic Year--</option>
                                    <?php for ($start_year = date('Y'); $start_year >= 2000; $start_year--) : ?>
                                        <option value="<?php echo $start_year; ?>"><?php echo $start_year . '-' . ($start_year + 1); ?></option>
                                    <?php endfor; ?>
                                </select>
                                <label for="basic-default-fullname">Academic Year</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="FTR_SEMESTER" aria-label="Default select example">
                                    <option selected="">--Select Semester--</option>
                                    <option value="1st">1st</option>
                                    <option value="2nd">2nd</option>
                                    <option value="Summer">Summer</option>
                                </select>
                                <label for="basic-default-fullname">Semester</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="input-group">
                                <button class="btn btn-primary btn-lg" type="button" id="button-addon2">FILTER</button>
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
                <div class="card-header">
                    <div class="card-body">
                        <h4>List of Students Billing Statement</h4>
                        <div class="table-responsive">
                            <table id="dataTable" class="table table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Gender</th>
                                        <th>Program(Major)</th>
                                        <th>Year Level</th>
                                        <th>Semester</th>
                                        <th>Enrollement Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- / Content -->
<script>
    $(document).ready(function() {
        $('#myTable').DataTable({
            dom: 'Bfrtip', // 'B' for buttons
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });
</script>