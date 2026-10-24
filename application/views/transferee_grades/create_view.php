<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Transferee Grades</a>
            </li>
            <li class="breadcrumb-item active">Data Entry</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="card">
            <form action="<?= base_url("TFgradesController/SaveTFGrades"); ?>" method="post">
                <!-- CSRF token (Here, name is 'csrf_hash_name' which is specified in $config['csrf_token_name'] in cofig.php file ) -->
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="ID" value="">
                <input type="hidden" name="TG_KEY" value="">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                        <div>
                            <h5 class="card-title mb-0">Entry Transferee Grades</h5>
                            <p class="mb-0">Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required.</p>
                        </div>
                        <!-- <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="SC_MERGE" value="YES" id="defaultCheck3" />
                            <label class="form-check-label" for="defaultCheck3">Allow merge schedule.</label>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="">Student ID Number</label><span class="text-danger">*</span>
                            <input type="text" class="form-control" name="TG_STUDENTID" readonly required id="TG_STUDENTID" placeholder="Student ID" aria-describedby="button-addon2" />
                        </div>
                        <div class="col-md-6">
                            <label for="">Full Name</label> <span class="text-danger">*</span>
                            <div class="input-group">
                                <input type="text" class="form-control TG_NAMEOFSTUDENT" placeholder="Name of Student" required name="TG_NAMEOFSTUDENT" id="TG_NAMEOFSTUDENT" readonly />
                                <button class="btn btn-outline-primary btn-search-student" type="button"><i class="ri-search-line"></i> Search Student</button>
                            </div>
                        </div>

                        <!-- Modal for Student Search -->
                        <div class="modal fade" id="modalStudentSearch" data-bs-backdrop="static" tabindex="-1" aria-labelledby="modalStudentSearchLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalStudentSearchLabel">Search Student Transferee</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable">
                                                <thead>
                                                    <tr>
                                                        <th>ID Number</th>
                                                        <th>Full Name</th>
                                                        <th>Sex</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $this->db->select('tbl_studprof.*, tbl_enrollment.ER_STATUS');
                                                    $this->db->from('tbl_studprof');
                                                    $this->db->join('tbl_enrollment', 'tbl_enrollment.ER_STUDENTID = tbl_studprof.SP_STUDID', 'left');
                                                    $this->db->where('tbl_enrollment.ER_STATUS', 'Transferee');
                                                    $query = $this->db->get();

                                                    foreach ($query->result() as $r) {
                                                    ?>
                                                        <tr>
                                                            <td><?= $r->SP_STUDID ?></td>
                                                            <td><?= $r->SP_LASTNAME . ', ' . $r->SP_FIRSTNAME . ' ' . $r->SP_MIDDLENAME ?></td>
                                                            <td><?= $r->SP_GENDER ?></td>
                                                            <td>
                                                                <button type="button" class="btn btn-primary btn-select-student"
                                                                    data-name="<?= $r->SP_LASTNAME . ', ' . $r->SP_FIRSTNAME . ' ' . $r->SP_MIDDLENAME ?>"
                                                                    data-id="<?= $r->SP_STUDID ?>">Select</button>
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
                        <script>
                            $(function() {
                                // Show modal on button click
                                $('.btn-search-student').on('click', function() {
                                    $('#modalStudentSearch').modal('show');
                                    $('#searchStudentInput').val('');
                                });

                                // Select student from modal
                                $(document).on('click', '.btn-select-student', function() {
                                    let id = $(this).data('id');
                                    let name = $(this).data('name');
                                    $('#TG_STUDENTID').val(id);
                                    $('.TG_NAMEOFSTUDENT').val(name);
                                    $('#modalStudentSearch').modal('hide');
                                });
                            });
                        </script>
                    </div>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" name="TG_PROGRAM" id="TG_PROGRAM" aria-label="Default select example" required>
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
                                <select class="form-select select2" name="TG_MAJOR" id="TG_MAJOR" aria-label="Default select example" readonly>
                                    <option value=""></option>
                                </select>
                                <label for="basic-default-fullname">Major<span class="text-danger">*</span></label>
                                <script>
                                    $(document).ready(function() {
                                        $("#SC_PROG").change(function() {
                                            var maj = $(this).val();
                                            loadmajor(maj);
                                        });

                                        function loadmajor(major) {
                                            $.ajax({
                                                url: '<?= base_url("TFgradesController/LoadMajor"); ?>',
                                                type: 'POST',
                                                dataType: 'json',
                                                data: {
                                                    maj: major,
                                                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                                                },
                                                success: function(response) {
                                                    // if success
                                                    $('.txt_csrfname').val(response.token);
                                                    $("#SC_MAJOR").html(response.result);
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
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" name="TG_ACADEMICYEAR" id="TG_ACADEMICYEAR" aria-label="Default select example" required>
                                    <option value="">Select Academic Year</option>
                                    <?php for ($start_year = date('Y'); $start_year >= 2018; $start_year--) : ?>
                                        <option value="<?php echo $start_year; ?>"><?php echo $start_year . '-' . ($start_year + 1); ?></option>
                                    <?php endfor; ?>
                                </select>
                                <label for="basic-default-fullname">Academic Year<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" name="TG_SEMESTER" id="TG_SEMESTER" aria-label="Default select example" required>
                                    <option value="">--Select Semester--</option>
                                </select>
                                <script>
                                    $(document).ready(function() {
                                        $("#TG_PROGRAM, #TG_MAJOR").change(function() {
                                            var prog = $("#TG_PROGRAM").val();
                                            var maj = $("#TG_MAJOR").val();
                                            loadsemester(prog, maj);
                                        });

                                        function loadsemester(program, major) {
                                            $.ajax({
                                                url: '<?= base_url("TFgradesController/LoadSemester"); ?>',
                                                type: 'POST',
                                                dataType: 'json',
                                                data: {
                                                    prog: program,
                                                    maj: major,
                                                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                                                },
                                                success: function(response) {
                                                    // if success
                                                    $('.txt_csrfname').val(response.token);
                                                    $("#TG_SEMESTER").html(response.result);
                                                },
                                                error: function(xhr, status, error) {
                                                    alert('Failed to save form. Please try again later.');
                                                }
                                            });
                                        }
                                    });
                                </script>
                                <label for="basic-default-fullname">Semester<span class="text-danger">*</span></label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <select class="form-select select2" id="TG_YEARLEVEL" name="TG_YEARLEVEL" aria-label="Default select example" required>
                                    <option value="">--Select Year Level--</option>
                                    <option>1ST YEAR</option>
                                    <option>2ND YEAR</option>
                                    <option>3RD YEAR</option>
                                    <option>4TH YEAR</option>
                                    <option>5TH YEAR</option>
                                </select>
                                <label for="basic-default-fullname">Year Level<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-4">
                            <div class="form-floating form-floating-outline mb-4">
                                <input type="text" class="form-control" name="TG_HEISFROM" required id="TG_HEISFROM" placeholder="Name of Institution" aria-describedby="button-addon2" />
                                <label for="basic-default-fullname">Name of Institution From<span class="text-danger">*</span></label>
                            </div>
                        </div>
                    </div>
                    <h5>Subject to credits</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="tbl_subj" style="width: 100%;">
                                    <thead>
                                        <tr>
                                            <th>Course No.</th>
                                            <th>Subject</th>
                                            <th>Units</th>
                                            <th>Grades</th>
                                            <th>
                                                <button type="button" class="btn btn-primary add-subj"><i class="ri-add-line"></i></button>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="tbl_body">
                                    </tbody>

                                    <script>
                                        $(document).ready(function() {
                                            // Trigger the change event when any of the dropdowns change
                                            $("#TG_PROGRAM, #TG_MAJOR, #TG_YEARLEVEL, #TG_SEMESTER").change(function() {
                                                var prog = $("#TG_PROGRAM").val();
                                                var maj = $("#TG_MAJOR").val();
                                                var yr = $("#TG_YEARLEVEL").val();
                                                var sem = $("#TG_SEMESTER").val();

                                                loadsubject(prog, maj, yr, sem);
                                            });

                                            // Function to make the AJAX request and load subjects
                                            function loadsubject(program, major, yearlvl, semester) {
                                                $.ajax({
                                                    url: '<?= base_url("SchedulingController/LoadSubject"); ?>', // URL to your controller function
                                                    type: 'POST',
                                                    dataType: 'json', // Expect JSON response
                                                    data: {
                                                        prog: program,
                                                        maj: major,
                                                        yr: yearlvl,
                                                        sem: semester,
                                                        [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val() // CSRF token
                                                    },
                                                    success: function(response) {
                                                        // Update the CSRF token value
                                                        $('.txt_csrfname').val(response.token);

                                                        // Populate the subject dropdown with the returned options
                                                        $("#TG_SUBJECT").html(response.result);
                                                    },
                                                    error: function(xhr, status, error) {
                                                        alert('Failed to load subjects. Please try again later.');
                                                    }
                                                });
                                            }
                                        });
                                    </script>
                                    <tfoot>
                                        <th colspan="2" style="text-align: right;">Total Units: </th>
                                        <th colspan="3"><span id="textTotal"></span></th>
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
        $("#tbl_subj").on("click", ".add-subj", function() {
            var newRow = $("#tbl_subj tbody tr:first").clone();
            newRow.find("input").val(''); // Clear input values
            $("#tbl_subj tbody").append(newRow);
            newRow.find(".remove-subj").remove(); // Remove "Add Row" button from the new row
            newRow.find("td:last").append('<button type="button" class="btn btn-danger remove-subj"><i class="ri-delete-bin-line me-1"></i></button>');
            addGrades();
        });

        // Remove rows
        $("#tbl_subj").on("click", ".remove-subj", function() {
            if ($("#tbl_subj tbody tr").length > 1) {
                $(this).closest("tr").remove();
                addGrades();
            }
        });

    });
</script>

<!-- SUM OF UNITS -->
<script>
    $(document).ready(function() {

        addGrades();

        // Function to calculate and display total BP amount
        function updateTotalAmount() {
            var totalAmount = 0;
            $('input[id^="TG_UNITS"]').each(function() {
                var value = parseFloat($(this).val().replace(/,/g, '')) || 0;
                totalAmount += value;
            });

            $('#textTotal').text(number_format(totalAmount, 2, '.', ','));
        }


        $("#tbl_subj").on("click", ".add-subj", function() {
            addGrades();
        });


        function addGrades() {
            $.ajax({
                url: "<?= base_url("TFgradesController/addGrades"); ?>",
                method: "POST",
                dataType: 'json',
                data: {
                    [$('.txt_csrfname').attr('name')]: $('.txt_csrfname').val()
                },
                success: function(data) {
                    $('.txt_csrfname').val(data.token);
                    $("#tbl_body").append(data.result);
                    formatAmount($('input[id^="TG_UNITS"]'));
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
        $("#tbl_subj").on("click", ".remove-subj", function() {
            if ($("#tbl_subj tbody tr").length > 1) {
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