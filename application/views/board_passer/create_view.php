<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Report</a>
            </li>
            <li class="breadcrumb-item active">Board Passer</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="card">
            <form action="<?= base_url("BoardPasserController/saveBoardPasser") ?>" method="post">
                <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <div class="card-body">
                    <h5 class="card-title">Add Board Passer</h5>
                    <p>Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required.</p>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" name="PROGRAM" id="PROGRAM" aria-label="Default select example" required>
                                    <option value="">--Select Programs--</option>
                                    <?php
                                    foreach ($LoadPrograms->result() as $r) {
                                    ?>
                                        <option><?= $r->P_PDESCRIPTIONS ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label for="basic-default-fullname">Programs<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" name="MAJOR" id="MAJOR" aria-label="Default select example" readonly>
                                    <option value=""></option>
                                </select>
                                <label for="basic-default-fullname">Major<span class="text-danger">*</span></label>
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
                                        <option value="<?php echo $start_year; ?>"><?php echo $start_year; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <label for="basic-default-fullname">Year<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" name="MONTH" id="MONTH" aria-label="Default select example" required>
                                    <option value="">---------</option>
                                    <option value="January">January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                                <label for="basic-default-fullname">Month<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <h5>FIRST TIMER:</h5>
                        <!-- <div class="info">
                            <strong>Note:</strong> First Timer includes all first-time takers of the board exam, regardless of whether they graduated in the current or previous academic year.
                        </div>
                        <br> -->
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="FT_PASSED" name="FT_PASSED" placeholder="Passed" required />
                                <label for="FT_PASSED">Passed<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="FT_FAILED" name="FT_FAILED" placeholder="Failed" required />
                                <label for="FT_FAILED">Failed<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="FT_SUBTOTAL" name="FT_SUBTOTAL" placeholder="Total" readonly />
                                <label for="FT_SUBTOTAL">Total<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="FT_TOTALPERCENT" name="FT_TOTALPERCENT" placeholder="%Total" readonly />
                                <label for="FT_TOTALPERCENT">%Total<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <h5>REPEATER:</h5>
                        <!-- <div class="info">
                            <strong>Note:</strong> Repeater includes all repeater takers of the board exam, regardless of whether they graduated in the current or previous academic year.
                        </div>
                        <br> -->
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="RT_PASSED" name="RT_PASSED" placeholder="Passed" required />
                                <label for="RT_PASSED">Passed<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="RT_FAILED" name="RT_FAILED" placeholder="Failed" required />
                                <label for="RT_FAILED">Failed<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="RT_SUBTOTAL" name="RT_SUBTOTAL" placeholder="Total" readonly />
                                <label for="RT_SUBTOTAL">Total<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="RT_TOTALPERCENT" name="RT_TOTALPERCENT" placeholder="%Total" readonly />
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
                        <!-- <div class="info">
                            <strong>Note:</strong> Overall performance includes all takers of the board exam, regardless of whether they graduated in the current or previous academic year.
                        </div>
                        <br> -->
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="OP_PASSED" name="OP_PASSED" placeholder="Passed" readonly />
                                <label for="OP_PASSED">Total Passed<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="OP_FAILED" name="OP_FAILED" placeholder="Failed" readonly />
                                <label for="OP_FAILED">Total Failed<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="OP_GRANDTOTAL" name="OP_GRANDTOTAL" placeholder="Total" readonly />
                                <label for="OP_GRANDTOTAL">Grand Total<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" id="OP_GRANDTOTALPERCENT" name="OP_GRANDTOTALPERCENT" placeholder="%Total" readonly />
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
                <div class="card-footer">
                    <button type="submit" class="btn btn-success btn-lg">Save Changes</button>
                </div>
            </form>

        </div>
    </div>
</div>