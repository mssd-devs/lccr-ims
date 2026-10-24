<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Fees</a>
            </li>
            <li class="breadcrumb-item active">Add Fees</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Fees:</h5>
                    <form action="<?= base_url("FeesController/saveFees"); ?>" method="post">
                        <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                        <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <input type="hidden" name="ID" value="">
                        <input type="hidden" name="FEES_KEY" value="">
                        <div class="card-body">
                            <p>Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required and type Not Applicable (if not applicable)</p>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="FEES_PROGRAM" id="FEES_PROGRAM" aria-label="Default select example" required>
                                            <option value="">--Select Programs--</option>
                                            <?php
                                            foreach ($LoadPrograms->result() as $r) {
                                            ?>
                                                <option><?= $r->P_PDESCRIPTIONS ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="FEES_PROGRAM">Programs<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="FEES_MAJOR" id="FEES_MAJOR" aria-label="Default select example" readonly>
                                            <option value=""></option>
                                        </select>
                                        <label for="FEES_MAJOR">Major<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="FEES_YEARLEVEL" id="FEES_YEARLEVEL" aria-label="Default select example" required>
                                            <option value="">--Select Year Level--</option>
                                            <option value="1ST YEAR">1ST YEAR</option>
                                            <option value="2ND YEAR">2ND YEAR</option>
                                            <option value="3RD YEAR">3RD YEAR</option>
                                            <option value="4TH YEAR">4TH YEAR</option>
                                            <option value="5TH YEAR">5TH YEAR</option>
                                        </select>
                                        <label for="FEES_YEARLEVEL">Year Level<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <select class="form-select select2" name="FEES_SEMESTER" id="FEES_SEMESTER" aria-label="Default select example" required>
                                            <option value="">--Select Semester--</option>
                                        </select>
                                        <label for="FEES_SEMESTER">Semester<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <h5>Tuition Fee</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="FEES_AMOUNTPERUNIT" id="FEES_AMOUNTPERUNIT" required />
                                        <label for="FEES_AMOUNTPERUNIT">Amount/Rate Per Unit<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="number" class="form-control" name="FEES_UNITS" id="FEES_UNITS" required />
                                        <label for="FEES_UNITS">Total Units<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating form-floating-outline mb-4">
                                        <input type="text" class="form-control" name="FEES_TOTALTUITION" id="FEES_TOTALTUITION" required readonly />
                                        <label for="FEES_TOTALTUITION">Total Tuition Fee<span class="text-danger">*</span></label>
                                    </div>
                                </div>
                            </div>
                            <script>
                                $(document).ready(function() {
                                    function loadmajor(major, callback) {
                                        $.ajax({
                                            url: '<?= base_url("FeesController/LoadMajor"); ?>',
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {
                                                maj: major,
                                                [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                                            },
                                            success: function(response) {
                                                if (response.token) {
                                                    $('.txt_csrfname').val(response.token);
                                                }
                                                $("#FEES_MAJOR").html(response.result).trigger('change');
                                                if (typeof callback === 'function') {
                                                    callback();
                                                }
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Failed to load major.');
                                            }
                                        });
                                    }

                                    function loadsemester(program, major, callback) {
                                        $.ajax({
                                            url: '<?= base_url("FeesController/LoadSemester"); ?>',
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {
                                                prog: program,
                                                majo: major,
                                                [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                                            },
                                            success: function(response) {
                                                if (response.token) {
                                                    $('.txt_csrfname').val(response.token);
                                                }
                                                $("#FEES_SEMESTER").html(response.result).trigger('change');
                                                if (typeof callback === 'function') {
                                                    callback();
                                                }
                                            },
                                            error: function(xhr, status, error) {
                                                console.error('Failed to load semester.');
                                            }
                                        });
                                    }

                                    function loadsum() {
                                        var prog = $('#FEES_PROGRAM').val();
                                        var maj = $('#FEES_MAJOR').val();
                                        var yr = $('#FEES_YEARLEVEL').val();
                                        var sem = $('#FEES_SEMESTER').val();

                                        if (!prog || !yr || !sem) {
                                            return;
                                        }

                                        $.ajax({
                                            url: '<?= base_url("FeesController/LoadSumUnits"); ?>',
                                            type: 'POST',
                                            dataType: 'json',
                                            data: {
                                                prog: prog,
                                                maj: maj,
                                                yr: yr,
                                                sem: sem,
                                                [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                                            },
                                            success: function(response) {
                                                if (response.token) {
                                                    $('.txt_csrfname').val(response.token);
                                                }
                                                $('#FEES_UNITS').val(response.units).trigger('input');
                                            },
                                            error: function() {
                                                console.error('Error loading total units.');
                                            }
                                        });
                                    }

                                    $("#FEES_PROGRAM").change(function() {
                                        var prog = $(this).val();
                                        loadmajor(prog, function() {
                                            var majo = $("#FEES_MAJOR").val();
                                            loadsemester(prog, majo, function() {
                                                loadsum();
                                            });
                                        });
                                    });

                                    $("#FEES_MAJOR").change(function() {
                                        var prog = $("#FEES_PROGRAM").val();
                                        var majo = $(this).val();
                                        loadsemester(prog, majo, function() {
                                            loadsum();
                                        });
                                    });

                                    $("#FEES_YEARLEVEL, #FEES_SEMESTER").change(function() {
                                        loadsum();
                                    });
                                });
                            </script>
                            <h5>Miscellaneous Fee</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="tbl_mics" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Amount</th>
                                                    <th>
                                                        <button type="button" class="btn btn-primary add-mics"><i class="ri-add-line"></i></button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbl_body">
                                            </tbody>
                                            <tfoot>
                                                <th>Total</th>
                                                <th colspan="2"><span id="textTotal"></span></th>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <h5>Other Fees</h5>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="tbl_other" style="width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Amount</th>
                                                    <th>
                                                        <button type="button" class="btn btn-primary add-other"><i class="ri-add-line"></i></button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbl_body1">
                                            </tbody>
                                            <tfoot>
                                                <th>Total</th>
                                                <th colspan="2"><span id="textTotal1"></span></th>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-lg">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- / Content -->

<!-- FOR UPPERCASE -->
<script>
    $(document).on('input', '[type="text"], textarea', function() {
        var inputText = $(this).val();
        var uppercaseText = inputText.toUpperCase();
        var textWithoutDoubleSpaces = uppercaseText.replace(/  +/g, ' ');
        $(this).val(textWithoutDoubleSpaces);
    });
</script>

<!-- FOR ADD AND DELETE ROW -->
<script>
    $(document).ready(function() {
        // Add rows
        $("#tbl_other").on("click", ".add-pip", function() {
            var newRow = $("#tbl_other tbody tr:first").clone();
            newRow.find("input").val(''); // Clear input values
            $("#tbl_other tbody").append(newRow);
            newRow.find(".remove-pip").remove(); // Remove "Add Row" button from the new row
            newRow.find("td:last").append('<button type="button" class="btn btn-danger remove-pip"><i class="ri-delete-bin-line me-1"></i></button>');
            otherfees();
        });

        // Remove rows
        $("#tbl_other").on("click", ".remove-pip", function() {
            if ($("#tbl_other tbody tr").length > 1) {
                $(this).closest("tr").remove();
                otherfees();
            }
        });

    });
</script>

<!-- SUM OF MISCELLANEOUS FEE -->
<script>
    $(document).ready(function() {

        addMiscellaneous();

        // Function to calculate and display total BP amount
        function updateTotalAmount() {
            var totalAmount = 0;
            $('input[id^="FEES_MISC_AMOUNT"]').each(function() {
                var value = parseFloat($(this).val().replace(/,/g, '')) || 0;
                totalAmount += value;
            });

            $('#textTotal').text(number_format(totalAmount, 2, '.', ','));
        }


        $("#tbl_mics").on("click", ".add-mics", function() {
            addMiscellaneous();
        });


        function addMiscellaneous() {
            $.ajax({
                url: "<?= base_url("FeesController/addMiscellaneous"); ?>",
                method: "POST",
                dataType: 'json',
                data: {
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                },
                success: function(data) {
                    $('.txt_csrfname').val(data.token);
                    $("#tbl_body").append(data.result);
                    formatAmount($('input[id^="FEES_MISC_AMOUNT"]'));
                },
                error: function(jqXHR, errorType, error) {
                    alert(error);
                }
            });
        }

        // Function to format BP_AMOUNT inputs
        function formatAmount(element) {
            element.keyup(function(event) {
                if (event.which >= 37 && event.which <= 40) {
                    event.preventDefault();
                }
                $(this).val(function(index, value) {
                    return value.replace(/\D/g, "")
                        .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
                });
                updateTotalAmount();
            });
        }



        // Remove rows
        $("#tbl_mics").on("click", ".remove-mics", function() {
            if ($("#tbl_mics tbody tr").length > 1) {
                $(this).closest("tr").remove();
            }
            updateTotalAmount();
        });



        // Custom number_format function
        function number_format(number, decimals, dec_point, thousands_sep) {
            number = parseFloat(number);
            decimals = decimals || 0;
            dec_point = dec_point || '.';
            thousands_sep = thousands_sep || ',';
            let roundedNumber = Math.round(Math.abs(number) * ('1e' + decimals)) + '';
            let decimalsPosition = roundedNumber.length - decimals;
            let formattedNumber = (roundedNumber.slice(0, decimalsPosition) || '0') + dec_point + roundedNumber.slice(decimalsPosition);
            let thousandsPattern = /(\d)(?=(\d{3})+\b)/g;
            return (number < 0 ? '-' : '') + (thousands_sep ? formattedNumber.replace(thousandsPattern, '$1' + thousands_sep) : formattedNumber);
        }
    });
</script>

<!-- SUM OF OTHERS FEE -->
<script>
    $(document).ready(function() {

        addOtherFees();

        // Function to calculate and display total BP amount
        function updateTotalAmount() {
            var totalAmount = 0;
            $('input[id^="FEES_OTHER_AMOUNT"]').each(function() {
                var value = parseFloat($(this).val().replace(/,/g, '')) || 0;
                totalAmount += value;
            });

            $('#textTotal1').text(number_format(totalAmount, 2, '.', ','));
        }


        $("#tbl_other").on("click", ".add-other", function() {
            addOtherFees();
        });


        function addOtherFees() {
            $.ajax({
                url: "<?= base_url("FeesController/addOtherFees"); ?>",
                method: "POST",
                dataType: 'json',
                data: {
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                },
                success: function(data) {
                    $('.txt_csrfname').val(data.token);
                    $("#tbl_body1").append(data.result);
                    formatAmount($('input[id^="FEES_OTHER_AMOUNT"]'));
                },
                error: function(jqXHR, errorType, error) {
                    alert(error);
                }
            });
        }
        // Function to format BP_AMOUNT inputs
        function formatAmount(element) {
            element.keyup(function(event) {
                if (event.which >= 37 && event.which <= 40) {
                    event.preventDefault();
                }
                $(this).val(function(index, value) {
                    return value.replace(/\D/g, "")
                        .replace(/([0-9])([0-9]{2})$/, '$1.$2')
                        .replace(/\B(?=(\d{3})+(?!\d)\.?)/g, ",");
                });
                updateTotalAmount();
            });
        }



        // Remove rows
        $("#tbl_other").on("click", ".remove-other", function() {
            if ($("#tbl_other tbody tr").length > 1) {
                $(this).closest("tr").remove();
            }
            updateTotalAmount();
        });



        // Custom number_format function
        function number_format(number, decimals, dec_point, thousands_sep) {
            number = parseFloat(number);
            decimals = decimals || 0;
            dec_point = dec_point || '.';
            thousands_sep = thousands_sep || ',';
            let roundedNumber = Math.round(Math.abs(number) * ('1e' + decimals)) + '';
            let decimalsPosition = roundedNumber.length - decimals;
            let formattedNumber = (roundedNumber.slice(0, decimalsPosition) || '0') + dec_point + roundedNumber.slice(decimalsPosition);
            let thousandsPattern = /(\d)(?=(\d{3})+\b)/g;
            return (number < 0 ? '-' : '') + (thousands_sep ? formattedNumber.replace(thousandsPattern, '$1' + thousands_sep) : formattedNumber);
        }
    });
</script>


<script>
    $(document).ready(function() {
        // Attach events to the input field for formatting
        $("input[id='FEES_AMOUNTPERUNIT']").on("input", function() {
            formatAmount($(this));
        });
    });

    function formatAmount(element) {
        let value = element.val();

        // Remove all non-numeric characters except for the decimal point
        value = value.replace(/[^0-9.]/g, "");

        // Prevent more than one decimal point
        const parts = value.split(".");
        let whole = parts[0]; // Whole number part
        let decimal = parts[1] || ""; // Decimal part, default to empty if not present

        // Add commas to the whole number part
        whole = whole.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        // Limit the decimal part to two digits
        if (decimal.length > 2) {
            decimal = decimal.substring(0, 2);
        }

        // Construct the formatted value
        value = decimal.length > 0 ? `${whole}.${decimal}` : whole;

        // Set the formatted value back to the input field
        element.val(value);
    }
</script>

<!-- FOR TOTAL TUITIONS -->
<script>
    $(document).ready(function() {
        // Attach events to the input field for formatting
        $("input[id='FEES_TOTALTUITION']").on("input", function() {
            formatAmount($(this));
        });
    });

    function formatAmount(element) {
        let value = element.val();

        // Remove all non-numeric characters except for the decimal point
        value = value.replace(/[^0-9.]/g, "");

        // Prevent more than one decimal point
        const parts = value.split(".");
        let whole = parts[0]; // Whole number part
        let decimal = parts[1] || ""; // Decimal part, default to empty if not present

        // Add commas to the whole number part
        whole = whole.replace(/\B(?=(\d{3})+(?!\d))/g, ",");

        // Limit the decimal part to two digits
        if (decimal.length > 2) {
            decimal = decimal.substring(0, 2);
        }

        // Construct the formatted value
        value = decimal.length > 0 ? `${whole}.${decimal}` : whole;

        // Set the formatted value back to the input field
        element.val(value);
    }
</script>



<!-- SUM OF AMOUNT PER UNIT -->
<script>
    $(document).ready(function() {
        // Initialize the calculation on page load
        calculateSumPerUnit();

        // Add event listener for input changes on both fields
        $("#FEES_AMOUNTPERUNIT, #FEES_UNITS").on("input", calculateSumPerUnit);
    });

    function calculateSumPerUnit() {
        // Get input values and default to 0 if empty or invalid
        const amountPerUnit = parseNumber($("#FEES_AMOUNTPERUNIT").val());
        const units = parseNumber($("#FEES_UNITS").val());

        // Calculate the total amount
        const total = amountPerUnit * units;

        // Update the total tuition field with the formatted total
        $("#FEES_TOTALTUITION").val(formatNumber(total));
    }

    function parseNumber(value) {
        // Convert a string to a number, removing commas and defaulting to 0 if invalid
        const number = parseFloat(value.replace(/,/g, ""));
        return isNaN(number) ? 0 : number;
    }

    function formatNumber(num) {
        // Format the number with commas and two decimal places
        return num.toLocaleString("en-US", {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }
</script>