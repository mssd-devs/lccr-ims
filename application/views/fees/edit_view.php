<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Fees</a>
            </li>
            <li class="breadcrumb-item active">Efit Fees</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Fees:</h5>
                    <form action="<?= base_url("FeesController/updateFees"); ?>" method="post">
                        <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                        <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                        <?php
                        $query = $this->db->where("ID", $this->uri->segment(4))->get("tbl_fees_tuitions");
                        foreach ($query->result() as $r) {
                        ?>
                            <input type="hidden" name="ID" value="<?= $r->ID; ?>">
                            <div class="card-body">
                                <p>Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required and type Not Applicable (if not applicable)</p>
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select class="form-select select2" name="FEES_PROGRAM" id="FEES_PROGRAM" aria-label="Default select example" required>
                                                <option value="">--Select Programs--</option>
                                                <?php
                                                foreach ($LoadPrograms->result() as $row) {
                                                ?>
                                                    <option <?php if ($r->FEES_PROGRAM == $row->P_PDESCRIPTIONS) {
                                                                echo "selected";
                                                            } ?>><?= $row->P_PDESCRIPTIONS; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <label for="basic-default-fullname">Programs<span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select class="form-select select2" name="FEES_MAJOR" id="FEES_MAJOR" aria-label="Default select example" readonly>
                                                <option value=""></option>
                                                <?php
                                                $major = $this->db->where("P_PDESCRIPTIONS", $r->FEES_PROGRAM)->get("tbl_program");
                                                if ($major->num_rows() > 0) {
                                                    foreach ($major->result() as $row) {
                                                ?>
                                                        <option <?php if ($row->P_MAJOR == $r->FEES_MAJOR) {
                                                                    echo "selected";
                                                                } ?> value="<?= $row->P_MAJOR; ?>"><?= $row->P_MAJOR; ?></option>
                                                <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <label for="basic-default-fullname">Major<span class="text-danger">*</span></label>
                                            <script>
                                                $(document).ready(function() {
                                                    $("#FEES_PROGRAM").change(function() {
                                                        var maj = $(this).val();
                                                        loadmajor(maj);
                                                    });

                                                    function loadmajor(major) {
                                                        $.ajax({
                                                            url: '<?= base_url("FeesController/LoadMajor"); ?>',
                                                            type: 'POST',
                                                            dataType: 'json',
                                                            data: {
                                                                maj: major,
                                                                [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                                                            },
                                                            success: function(response) {
                                                                // if success
                                                                $('.txt_csrfname').val(response.token);
                                                                $("#FEES_MAJOR").html(response.result);
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
                                            <select class="form-select select2" id="" name="FEES_YEARLEVEL" aria-label="Default select example" required>
                                                <option value="">--Select Year Level--</option>
                                                <option <?php if ($r->FEES_YEARLEVEL == "1ST YEAR") {
                                                            echo "selected";
                                                        } ?>>1ST YEAR</option>
                                                <option <?php if ($r->FEES_YEARLEVEL == "2ND YEAR") {
                                                            echo "selected";
                                                        } ?>>2ND YEAR</option>
                                                <option <?php if ($r->FEES_YEARLEVEL == "3RD YEAR") {
                                                            echo "selected";
                                                        } ?>>3RD YEAR</option>
                                                <option <?php if ($r->FEES_YEARLEVEL == "4TH YEAR") {
                                                            echo "selected";
                                                        } ?>>4TH YEAR</option>
                                                <option <?php if ($r->FEES_YEARLEVEL == "5TH YEAR") {
                                                            echo "selected";
                                                        } ?>>5TH YEAR</option>
                                            </select>
                                            <label for="basic-default-fullname">Year Level<span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <select class="form-select select2" id="" name="FEES_SEMESTER" aria-label="Default select example" required>
                                                <option value="">--Select Semester--</option>
                                                <?php
                                                $major = $this->db
                                                    ->where("P_PDESCRIPTIONS", $r->FEES_PROGRAM)
                                                    ->where("P_MAJOR", $r->FEES_MAJOR)
                                                    ->get("tbl_program");

                                                if ($major->num_rows() > 0) {
                                                    // Fetch semesters only once outside the loop to improve performance

                                                    foreach ($major->result() as $row) {
                                                        $semesters = $this->db
                                                            ->order_by("SEM_NAME", "ASC")
                                                            ->where("SEM_TYPE", $row->P_SEMTYPE)
                                                            ->get("tbl_semestertype")
                                                            ->result();
                                                        foreach ($semesters as $sem) {
                                                ?>
                                                            <option
                                                                value="<?= htmlspecialchars($sem->SEM_NAME, ENT_QUOTES); ?>"
                                                                <?php if ($row->P_SEMTYPE == $sem->SEM_TYPE) {
                                                                    if ($r->FEES_SEMESTER == $sem->SEM_NAME) {
                                                                        echo "selected";
                                                                    }
                                                                }
                                                                ?>>
                                                                <?= htmlspecialchars($sem->SEM_NAME, ENT_QUOTES); ?>
                                                            </option>
                                                <?php
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <label for="basic-default-fullname">Semester<span class="text-danger">*</span></label>

                                            <script>
                                                $(document).ready(function() {
                                                    $("#FEES_PROGRAM, #FEES_MAJOR").change(function() {
                                                        var prog = $("#FEES_PROGRAM").val();
                                                        var majo = $("#FEES_MAJOR").val();
                                                        loadsemester(prog, majo);
                                                    });

                                                    function loadsemester(program, major) {
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
                                                                // if success
                                                                $('.txt_csrfname').val(response.token);
                                                                $("#FEES_SEMESTER").html(response.result);
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
                                <h5>Tuition Fee</h5>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <input type="text" class="form-control" name="FEES_AMOUNTPERUNIT" id="FEES_AMOUNTPERUNIT" value="<?= $r->FEES_AMOUNTPERUNIT; ?>" required />
                                            <label for="basic-default-fullname">Amount/Rate Per Unit<span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <input type="number" class="form-control" name="FEES_UNITS" id="FEES_UNITS" value="<?= $r->FEES_UNITS; ?>" required />
                                            <label for="basic-default-fullname">Total Units<span class="text-danger">*</span></label>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-floating form-floating-outline mb-4">
                                            <input type="text" class="form-control" name="FEES_TOTALTUITION" id="FEES_TOTALTUITION" required readonly />
                                            <label for="basic-default-fullname">Total Tuition Fee<span class="text-danger">*</span></label>
                                        </div>
                                    </div>
                                </div>
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
                                                    <?php
                                                    $query = $this->db->where("FEES_TUITION_ID", $r->FEES_KEY)->get("tbl_fees_miscellaneous");
                                                    if ($query->num_rows() > 0) {
                                                        foreach ($query->result() as $row) {
                                                    ?>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" required name="FEES_MISC_DESC[]" value="<?= $row->FEES_MISC_DESC; ?>" class="form-control">
                                                                </td>
                                                                <td>
                                                                    <input type="text" required name="FEES_MISC_AMOUNT[]" value="<?= number_format((float)str_replace(',', '', $row->FEES_MISC_AMOUNT), 2); ?>" class="form-control fees-amount">
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-danger remove-mics"><i class="ri-delete-bin-line me-1"></i></button>
                                                                </td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th colspan="2"><span id="textTotal"></span></th>
                                                    </tr>
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
                                                    <?php
                                                    $query1 = $this->db->where("FEES_TUITION_ID", $r->FEES_KEY)->get("tbl_fees_otherfees");
                                                    if ($query1->num_rows() > 0) {
                                                        foreach ($query1->result() as $r1) {
                                                    ?>
                                                            <tr>
                                                                <td>
                                                                    <input type="text" required name="FEES_OTHER_DESC[]" value="<?= $r1->FEES_OTHER_DESC; ?>" class="form-control">
                                                                </td>
                                                                <td>
                                                                    <input type="text" required name="FEES_OTHER_AMOUNT[]" value="<?= number_format((float)str_replace(',', '', $r1->FEES_OTHER_AMOUNT), 2); ?>" class="form-control fees-other-amount">
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-danger remove-other"><i class="ri-delete-bin-line me-1"></i></button>
                                                                </td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th>Total</th>
                                                        <th colspan="2"><span id="textTotal1"></span></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-lg">Save Changes</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
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

<!-- SUM OF MISCELLANEOUS FEE -->
<script>
    $(document).ready(function() {
        // Sum and display on load
        updateTotalAmount();

        // Format and listen to amount changes
        formatAmount($('.fees-amount'));

        // Function to calculate and display total
        function updateTotalAmount() {
            let totalAmount = 0;
            $('.fees-amount').each(function() {
                let value = parseFloat($(this).val().replace(/,/g, '')) || 0;
                totalAmount += value;
            });
            $('#textTotal').text(number_format(totalAmount, 2, '.', ','));
        }

        // Format currency and update total
        function formatAmount(elements) {
            elements.on("keyup", function(event) {
                if (event.which >= 37 && event.which <= 40) return;

                let input = $(this);
                let rawVal = input.val().replace(/\D/g, '');

                if (rawVal.length > 2) {
                    rawVal = rawVal.replace(/([0-9]{2})$/, '.$1');
                } else if (rawVal.length === 1) {
                    rawVal = '0.0' + rawVal;
                } else if (rawVal.length === 2) {
                    rawVal = '0.' + rawVal;
                }

                let formatted = number_format(parseFloat(rawVal), 2, '.', ',');
                input.val(formatted);
                updateTotalAmount();
            });

            // Also trigger once on page load
            elements.each(function() {
                $(this).trigger('keyup');
            });
        }

        // Remove row and update total
        $("#tbl_mics").on("click", ".remove-mics", function() {
            $(this).closest("tr").remove();
            updateTotalAmount();
        });

        // Add new row from AJAX and bind formatter
        $("#tbl_mics").on("click", ".add-mics", function() {
            addMiscellaneous();
        });

        function addMiscellaneous() {
            $.ajax({
                url: "<?= base_url('FeesController/addMiscellaneous'); ?>",
                method: "POST",
                dataType: "json",
                data: {
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                },
                success: function(data) {
                    $('.txt_csrfname').val(data.token);
                    if (data.result) {
                        $("#tbl_body").append(data.result);
                        let newFields = $('#tbl_body').find('.fees-amount');
                        formatAmount(newFields); // Apply formatting to new row
                        updateTotalAmount();
                    }
                },
                error: function(jqXHR, errorType, error) {
                    alert("Error: " + error);
                }
            });
        }

        // Utility: Number format
        function number_format(number, decimals, dec_point, thousands_sep) {
            number = parseFloat(number).toFixed(decimals);
            let parts = number.split('.');
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_sep);
            return parts.join(dec_point);
        }
    });
</script>

<!-- SUM OF OTHER FEES -->
<script>
    $(document).ready(function() {
        // On load: sum & format
        updateTotalAmount();
        formatAmount($('.fees-other-amount'));

        // Function to sum total
        function updateTotalAmount() {
            let totalAmount = 0;
            $('.fees-other-amount').each(function() {
                const value = parseFloat($(this).val().replace(/,/g, '')) || 0;
                totalAmount += value;
            });
            $('#textTotal1').text(number_format(totalAmount, 2, '.', ','));
        }

        // Format inputs and bind listeners
        function formatAmount(elements) {
            elements.off("keyup").on("keyup", function(event) {
                if (event.which >= 37 && event.which <= 40) return;

                let input = $(this);
                let rawVal = input.val().replace(/[^\d]/g, '');

                if (rawVal.length > 2) {
                    rawVal = rawVal.replace(/([0-9]{2})$/, '.$1');
                } else if (rawVal.length === 1) {
                    rawVal = '0.0' + rawVal;
                } else if (rawVal.length === 2) {
                    rawVal = '0.' + rawVal;
                }

                const num = parseFloat(rawVal) || 0;
                input.val(number_format(num, 2, '.', ','));
                updateTotalAmount();
            });

            // Trigger formatting once on page load
            elements.each(function() {
                $(this).trigger('keyup');
            });
        }

        // Remove row
        $("#tbl_other").on("click", ".remove-other", function() {
            $(this).closest("tr").remove();
            updateTotalAmount();
        });

        // Add new row
        $("#tbl_other").on("click", ".add-other", function() {
            addOtherFees();
        });

        // Load via AJAX
        function addOtherFees() {
            $.ajax({
                url: "<?= base_url('FeesController/addOtherFees'); ?>",
                method: "POST",
                dataType: "json",
                data: {
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                },
                success: function(data) {
                    $('.txt_csrfname').val(data.token);
                    if (data.result) {
                        $("#tbl_body1").append(data.result);
                        let newFields = $('#tbl_body1 .fees-other-amount');
                        formatAmount(newFields);
                        updateTotalAmount();
                    }
                },
                error: function(jqXHR, errorType, error) {
                    alert("Error: " + error);
                }
            });
        }

        // JS Number Formatter
        function number_format(number, decimals, dec_point, thousands_sep) {
            number = parseFloat(number);
            if (isNaN(number)) return '0.00';
            number = number.toFixed(decimals);
            const parts = number.split('.');
            parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_sep);
            return parts.join(dec_point);
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