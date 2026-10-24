<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Report</a>
            </li>
            <li class="breadcrumb-item active">Edit Board Passer</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="card">
            <form action="<?= base_url("BoardPasserController/updateBoardPasser") ?>" method="post">
                <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <?php foreach ($LoadBoardPasser->result() as $boardpasser) : ?>
                    <input type="hidden" name="ID" value="<?= $boardpasser->ID; ?>">
                    <div class="card-body">
                        <h5 class="card-title">Edit Board Passer</h5>
                        <p>Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required.</p>

                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="PROGRAM" id="PROGRAM" aria-label="Default select example" required>
                                        <option value="">--Select Programs--</option>
                                        <?php
                                        foreach ($LoadPrograms->result() as $row) {
                                        ?>
                                            <option <?php if ($boardpasser->PROGRAM == $row->P_PDESCRIPTIONS) {
                                                        echo "selected";
                                                    } ?>><?= $row->P_PDESCRIPTIONS; ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                    <label for="PROGRAM">Programs<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="MAJOR" id="MAJOR" aria-label="Default select example" readonly>
                                        <option value=""></option>
                                        <?php
                                        $major = $this->db->where("P_PDESCRIPTIONS", $boardpasser->PROGRAM)->get("tbl_program");
                                        if ($major->num_rows() > 0) {
                                            foreach ($major->result() as $row) {
                                        ?>
                                                <option <?php if ($row->P_MAJOR == $boardpasser->MAJOR) {
                                                            echo "selected";
                                                        } ?> value="<?= $row->P_MAJOR; ?>"><?= $row->P_MAJOR; ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                    <label for="MAJOR">Major<span class="text-danger">*</span></label>
                                    <script>
                                        $(document).ready(function() {
                                            $("#PROGRAM").change(function() {
                                                var maj = $(this).val();
                                                loadmajor(maj);
                                            });

                                            function loadmajor(major) {
                                                $.ajax({
                                                    url: '<?= base_url("SchedulingController/LoadMajor"); ?>',
                                                    type: 'POST',
                                                    dataType: 'json',
                                                    data: {
                                                        maj: major,
                                                        [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                                                    },
                                                    success: function(response) {
                                                        // if success
                                                        $('.txt_csrfname').val(response.token);
                                                        $("#MAJOR").html(response.result);
                                                    },
                                                    error: function(xhr, status, error) {
                                                        alert('Failed to save form. Please try again later.');
                                                    }
                                                });
                                            }
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="YEAR" id="YEAR" aria-label="Default select example">
                                        <option value="">-- Select Year --</option>
                                        <?php for ($start_year = date('Y'); $start_year >= 2020; $start_year--) : ?>
                                            <option value="<?php echo $start_year; ?>" <?= ($boardpasser->YEAR == $start_year) ? 'selected' : ''; ?>><?php echo $start_year; ?></option>
                                        <?php endfor; ?>
                                    </select>
                                    <label for="YEAR">Year<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating form-floating-outline mb-4">
                                    <select class="form-select select2" name="MONTH" id="MONTH" aria-label="Default select example" required>
                                        <option value="">-- Select Month --</option>
                                        <option <?php if ($boardpasser->MONTH == "January") {
                                                    echo "selected";
                                                } ?>>January</option>
                                        <option <?php if ($boardpasser->MONTH == "February") {
                                                    echo "selected";
                                                } ?>>February</option>
                                        <option <?php if ($boardpasser->MONTH == "March") {
                                                    echo "selected";
                                                } ?>>March</option>
                                        <option <?php if ($boardpasser->MONTH == "April") {
                                                    echo "selected";
                                                } ?>>April</option>
                                        <option <?php if ($boardpasser->MONTH == "May") {
                                                    echo "selected";
                                                } ?>>May</option>
                                        <option <?php if ($boardpasser->MONTH == "June") {
                                                    echo "selected";
                                                } ?>>June</option>
                                        <option <?php if ($boardpasser->MONTH == "July") {
                                                    echo "selected";
                                                } ?>>July</option>
                                        <option <?php if ($boardpasser->MONTH == "August") {
                                                    echo "selected";
                                                } ?>>August</option>
                                        <option <?php if ($boardpasser->MONTH == "September") {
                                                    echo "selected";
                                                } ?>>September</option>
                                        <option <?php if ($boardpasser->MONTH == "October") {
                                                    echo "selected";
                                                } ?>>October</option>
                                        <option <?php if ($boardpasser->MONTH == "November") {
                                                    echo "selected";
                                                } ?>>November</option>
                                        <option <?php if ($boardpasser->MONTH == "December") {
                                                    echo "selected";
                                                } ?>>December</option>
                                    </select>
                                    <label for="MONTH">Month<span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <h5>FIRST TIMER:</h5>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="FT_PASSED" name="FT_PASSED" placeholder="Passed" value="<?php echo $boardpasser->FT_PASSED; ?>" required />
                                    <label for="FT_PASSED">Passed<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="FT_FAILED" name="FT_FAILED" placeholder="Failed" value="<?php echo $boardpasser->FT_FAILED; ?>" required />
                                    <label for="FT_FAILED">Failed<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="FT_SUBTOTAL" name="FT_SUBTOTAL" placeholder="Total" value="<?php echo $boardpasser->FT_SUBTOTAL; ?>" readonly />
                                    <label for="FT_SUBTOTAL">Total<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="FT_TOTALPERCENT" name="FT_TOTALPERCENT" placeholder="%Total" value="<?php echo $boardpasser->FT_TOTALPERCENT; ?>" readonly />
                                    <label for="FT_TOTALPERCENT">%Total<span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <h5>REPEATER:</h5>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="RT_PASSED" name="RT_PASSED" placeholder="Passed" value="<?php echo $boardpasser->RT_PASSED; ?>" required />
                                    <label for="RT_PASSED">Passed<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="RT_FAILED" name="RT_FAILED" placeholder="Failed" value="<?php echo $boardpasser->RT_FAILED; ?>" required />
                                    <label for="RT_FAILED">Failed<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="RT_SUBTOTAL" name="RT_SUBTOTAL" placeholder="Total" value="<?php echo $boardpasser->RT_SUBTOTAL; ?>" readonly />
                                    <label for="RT_SUBTOTAL">Total<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="RT_TOTALPERCENT" name="RT_TOTALPERCENT" placeholder="%Total" value="<?php echo $boardpasser->RT_TOTALPERCENT; ?>" readonly />
                                    <label for="RT_TOTALPERCENT">%Total<span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                        <script>
                            function calcTotals(prefix) {
                                let passed = parseInt($('#' + prefix + '_PASSED').val()) || 0;
                                let failed = parseInt($('#' + prefix + '_FAILED').val()) || 0;
                                let subtotal = passed + failed;
                                let percent = subtotal > 0 ? ((passed / subtotal) * 100).toFixed(2) : '';
                                $('#' + prefix + '_SUBTOTAL').val(subtotal ? subtotal : '');
                                $('#' + prefix + '_TOTALPERCENT').val(percent ? percent + '%' : '');
                            }

                            $(document).ready(function() {
                                $('#FT_PASSED, #FT_FAILED').on('input', function() {
                                    calcTotals('FT');
                                });
                                $('#RT_PASSED, #RT_FAILED').on('input', function() {
                                    calcTotals('RT');
                                });
                            });
                        </script>

                        <div class="row">
                            <h5>OVERALL PERFORMANCE:</h5>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="OP_PASSED" name="OP_PASSED" placeholder="Passed" value="<?php echo $boardpasser->OP_PASSED; ?>" readonly />
                                    <label for="OP_PASSED">Total Passed<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="OP_FAILED" name="OP_FAILED" placeholder="Failed" value="<?php echo $boardpasser->OP_FAILED; ?>" readonly />
                                    <label for="OP_FAILED">Total Failed<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="OP_GRANDTOTAL" name="OP_GRANDTOTAL" placeholder="Total" value="<?php echo $boardpasser->OP_GRANDTOTAL; ?>" readonly />
                                    <label for="OP_GRANDTOTAL">Grand Total<span class="text-danger">*</span></label>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-floating form-floating-outline mb-4">
                                    <input type="text" class="form-control" id="OP_GRANDTOTALPERCENT" name="OP_GRANDTOTALPERCENT" placeholder="%Total" value="<?php echo $boardpasser->OP_GRANDTOTALPERCENT; ?>" readonly />
                                    <label for="OP_GRANDTOTALPERCENT">Grand Total %<span class="text-danger">*</span></label>
                                </div>
                            </div>
                        </div>
                        <script>
                            function calcOverallPerformance() {
                                // Get values from FT and RP fields
                                let ft_passed = parseInt($('#FT_PASSED').val()) || 0;
                                let ft_failed = parseInt($('#FT_FAILED').val()) || 0;
                                let rt_passed = parseInt($('#RT_PASSED').val()) || 0;
                                let rt_failed = parseInt($('#RT_FAILED').val()) || 0;

                                // Calculate totals
                                let total_passed = ft_passed + rt_passed;
                                let total_failed = ft_failed + rt_failed;
                                let grand_total = total_passed + total_failed;
                                let grand_percent = grand_total > 0 ? ((total_passed / grand_total) * 100).toFixed(2) : '';

                                // Set values to OP fields
                                $('#OP_PASSED').val(total_passed ? total_passed : '');
                                $('#OP_FAILED').val(total_failed ? total_failed : '');
                                $('#OP_GRANDTOTAL').val(grand_total ? grand_total : '');
                                $('#OP_GRANDTOTALPERCENT').val(grand_percent ? grand_percent + '%' : '');
                            }

                            $(document).ready(function() {
                                // When FT or RT fields change, recalculate overall performance
                                $('#FT_PASSED, #FT_FAILED, #RT_PASSED, #RT_FAILED').on('input', function() {
                                    calcOverallPerformance();
                                });

                                // Optionally, recalculate on page load
                                calcOverallPerformance();
                            });
                        </script>
                    </div>
                <?php endforeach; ?>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-lg">Save Changes</button>
                </div>
            </form>

        </div>
    </div>
</div>