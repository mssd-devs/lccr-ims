<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Encoding Grades</a>
            </li>
            <li class="breadcrumb-item active">List</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="card">
            <div class="card-header">
                <h4>Class Grade Encoding
            </div>
            <form id="submitForm" enctype="multipart/form-data" method="post">
                <!-- CSRF token -->
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                <input type="hidden" name="G_UID">
                <input type="hidden" name="ID" value="">

                <div class="card-body">
                    <?php
                    $query = $this->db->where("ID", $this->uri->segment(4))->get("tbl_scheduling");
                    foreach ($query->result() as $rows) {
                        if ($rows->ID == $this->uri->segment(4)) {
                            $disableSave = false; // Initialize save button state
                    ?>
                            <input type="hidden" id="G_SCHEDID" name="G_SCHEDID" value="<?= $this->uri->segment(4); ?>">
                            <input type="hidden" id="G_SUBJECT" name="G_SUBJECT" value="<?= $rows->SC_SDESC; ?>">
                            <input type="hidden" id="G_YEARLEVEL" name="G_YEARLEVEL" value="<?= $rows->SC_YEARLEVEL; ?>">
                            <input type="hidden" id="G_SECTION" name="G_SECTION" value="<?= $rows->SC_SECTION; ?>">
                            <input type="hidden" id="G_CLASSCODE" name="G_CLASSCODE" value="<?= $rows->SC_CLASSCODE; ?>">
                            <input type="hidden" id="G_ACADEMICYEAR" name="G_ACADEMICYEAR" value="<?= $rows->SC_ACADEMICYEAR; ?>">
                            <input type="hidden" id="G_SEMESTER" name="G_SEMESTER" value="<?= $rows->SC_SEMESTER; ?>">

                            <!-- Subject info -->
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm w-100">
                                            <tr>
                                                <td colspan="2"><strong>Subject :</strong> <?= $rows->SC_SDESC; ?></td>
                                                <td><strong>Sched Code :</strong> <?= $rows->SC_CLASSCODE; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><strong>Program :</strong> <?= $rows->SC_PROG; ?></td>
                                                <td><strong>Major :</strong> <?= $rows->SC_MAJOR; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Academic Year :</strong> <?= $rows->SC_ACADEMICYEAR . '-' . ($rows->SC_ACADEMICYEAR + 1); ?></td>
                                                <td><strong>Semester :</strong> <?= $rows->SC_SEMESTER; ?></td>
                                                <td><strong>Year Level :</strong> <?= $rows->SC_YEARLEVEL; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Section :</strong> <?= $rows->SC_SECTION; ?></td>
                                                <td><strong>Room :</strong> <?= $rows->SC_ROOM; ?></td>
                                                <td><strong>Department :</strong> <?= $rows->SC_DEPT; ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Time :</strong> <?= $rows->SC_STARTTIME . ' - ' . $rows->SC_ENDTIME; ?></td>
                                                <td><strong>Day :</strong> <?= $rows->SC_DAY; ?></td>
                                                <td><strong>Teaching Method :</strong> <?= $rows->SC_TEACHMODELS; ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <br>

                            <!-- Students Table -->
                            <div class="row">
                                <div class="separator"></div>
                                <div class="table-responsive">
                                    <h4>List of Students</h4>
                                    <table id="myTable" class="table display">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name of Students</th>
                                                <th>Gender</th>
                                                <th>Enrollment Status</th>
                                                <th>Grades</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $hasData = false;

                                            $query = $this->db->where("ER_SEMESTER", $rows->SC_SEMESTER)->get("tbl_enrollment");
                                            foreach ($query->result() as $r) {
                                                if ($r->ER_SECTION == $rows->SC_SECTION) {
                                                    $stud = $this->db->where("SP_STUDID", $r->ER_STUDENTID)->get("tbl_studprof")->row();
                                                    if ($stud) {
                                                        $hasData = true;
                                                        $student_id = $r->ER_STUDENTID;

                                                        if ($r->ER_ENSTATUS == "PENDING") {
                                                            $disableSave = true; // Disable save if any student is pending
                                                        }
                                            ?>
                                                        <tr>
                                                            <td><?= $i++; ?></td>
                                                            <td>
                                                                <input type="hidden" id="G_STUDENTID" name="G_STUDENTID[]" value="<?= $stud->SP_STUDID; ?>">
                                                                <input type="hidden" id="G_FULLNAME" name="G_FULLNAME[]" value="<?= $stud->SP_FIRSTNAME . ' ' . $stud->SP_MIDDLENAME . ' ' . $stud->SP_LASTNAME; ?>">
                                                                <?= $stud->SP_FIRSTNAME . ' ' . $stud->SP_MIDDLENAME . ' ' . $stud->SP_LASTNAME; ?>
                                                            </td>
                                                            <td><?= $stud->SP_GENDER; ?>
                                                                <input type="hidden" id="G_GENDER" name="G_GENDER[]" value="<?= $stud->SP_GENDER; ?>">
                                                            </td>
                                                            <td><?= $r->ER_ENSTATUS; ?></td>
                                                            <td>
                                                                <select class="form-select grade-select" id="G_GRADE" name="G_GRADE[]" data-student="<?= $student_id ?>" <?= $r->ER_ENSTATUS == "PENDING" ? 'disabled' : '' ?>>
                                                                    <option value="">----</option>
                                                                    <option>1.00</option>
                                                                    <option>1.25</option>
                                                                    <option>1.50</option>
                                                                    <option>1.75</option>
                                                                    <option>2.00</option>
                                                                    <option>2.25</option>
                                                                    <option>2.50</option>
                                                                    <option>2.75</option>
                                                                    <option>3.00</option>
                                                                    <option>5.00</option>
                                                                    <option>INC</option>
                                                                    <option>DRP</option>
                                                                </select>
                                                            </td>
                                                            <td class="remark" id="remark-<?= $student_id ?>">
                                                                <span class="remark-text"></span>
                                                                <input type="hidden" class="remarks-input" name="G_REMARKS[]" value="">
                                                            </td>
                                                        </tr>
                                            <?php
                                                    }
                                                }
                                            }

                                            if (!$hasData) {
                                                echo '<tr><td colspan="6" class="text-center">No student available</td></tr>';
                                            }
                                            ?>
                                        </tbody>

                                        <tr>
                                            <td colspan="5"><strong>Total Students:</strong> <?= $i - 1; ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            <!-- JS for Remarks -->
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const gradeSelects = document.querySelectorAll('.grade-select');

                                    gradeSelects.forEach(select => {
                                        select.addEventListener('change', function() {
                                            const value = this.value;
                                            const studentId = this.getAttribute('data-student');
                                            const remarkCell = document.getElementById('remark-' + studentId);
                                            const remarkText = remarkCell.querySelector('.remark-text');
                                            const hiddenInput = remarkCell.querySelector('input.remarks-input');

                                            let remark = '';

                                            if (parseFloat(value) >= 1.00 && parseFloat(value) <= 3.00) {
                                                remark = 'PASSED';
                                            } else if (value === '5.00') {
                                                remark = 'FAILED';
                                            } else if (value === 'DRP') {
                                                remark = 'DROPPED';
                                            } else if (value === 'INC') {
                                                remark = 'INCOMPLETE';
                                            }

                                            remarkText.textContent = remark;
                                            if (hiddenInput) {
                                                hiddenInput.value = remark;
                                            }
                                        });
                                    });
                                });
                            </script>

                            <input type="hidden" id="G_STATUS" name="G_STATUS">

                            <!-- Save Buttons -->
                            <div class="row" style="margin-top:15px;">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-success btn-lg btnSave" <?= $disableSave ? 'disabled' : '' ?>>Save</button>
                                        <button type="button" class="btn btn-warning btn-lg btnDraft">Save as Draft</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Optional Alert -->
                            <?php if ($disableSave): ?>
                                <div class="alert alert-danger mt-3">
                                    <strong>Note:</strong> Save buttons are disabled because one or more students have a "PENDING" enrollment status.
                                </div>
                            <?php endif; ?>
                    <?php
                        }
                    }
                    ?>
                </div>
            </form>


        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        let btnstatus = null;
        $('.btnSave').click(function(e) {
            btnstatus = "SAVED";
            $("#G_STATUS").val(btnstatus);
            if (!$("#submitForm")[0].checkValidity()) {
                // If required fields are not filled, prevent default form submission
                e.preventDefault();
                e.stopPropagation();
                // Show error message using browser's built-in validation
                $("#submitForm")[0].reportValidity();
                return;
            } else {
                e.preventDefault();
                // Show a SweetAlert2 confirmation dialog
                Swal.fire({
                    title: "Are you sure?",
                    text: "Once submitted, you will not be able to modify the data!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, submit it!",
                    cancelButtonText: "Cancel"
                }).then((result) => {
                    if (!result.isConfirmed) {
                        // If user cancels, prevent form submission
                        e.preventDefault();
                        // Show info message
                    } else {
                        submitForm();
                    }
                });
            }
        });
        $('.btnDraft').click(function() {
            btnstatus = "DRAFT";
            $("#G_STATUS").val(btnstatus);
            confirmDraft();
        });


        function confirmDraft() {
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to save as draft!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
                cancelButtonText: "Cancel"
            }).then((result) => {
                if (result.isConfirmed) {
                    submitForm();
                }
            });
        }

        function submitForm() {
            const formData = new FormData($('#submitForm')[0]);

            $.ajax({
                url: '<?= base_url("GradesController/saveUpdateForm") ?>',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    window.location = '<?= base_url('ims/grades') ?>';
                },
                error: function(xhr, status, error) {
                    try {
                        const response = JSON.parse(xhr.responseText);
                        alert(response.message || 'Failed to save form. Please try again later.');
                    } catch (e) {
                        alert('Failed to save form. Please try again later.');
                    }
                }
            });
        }

    });
</script>
<!-- / Content -->