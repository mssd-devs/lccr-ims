<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Transferee Grades</a>
            </li>
            <li class="breadcrumb-item active">Edit Data Entry</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="card">
            <form action="<?= base_url("TFgradesController/UpdateTFGrades"); ?>" method="post">
                <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

                <?php
                $query = $this->db->where("TG_KEY", $this->uri->segment(5))->get("tbl_transfereegrades");
                foreach ($query->result() as $r):
                ?>
                    <input type="hidden" name="ID" id="ID" value="<?= $r->ID; ?>">
                    <input type="hidden" name="TG_KEY" id="TG_KEY" value="<?= $this->uri->segment(5); ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <div>
                                <h5 class="card-title mb-0">Entry Transferee Grades</h5>
                                <p class="mb-0">Note: All fields marked with an asterisk (<span class="text-danger">*</span>) are required.</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="TG_STUDENTID">Student ID Number <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="TG_STUDENTID" readonly required id="TG_STUDENTID" value="<?= $r->TG_STUDENTID; ?>" />
                            </div>
                            <div class="col-md-6">
                                <label for="TG_NAMEOFSTUDENT">Full Name <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" class="form-control TG_NAMEOFSTUDENT" name="TG_NAMEOFSTUDENT" id="TG_NAMEOFSTUDENT" readonly value="<?= $r->TG_NAMEOFSTUDENT; ?>" required />
                                    <button class="btn btn-outline-primary btn-search-student" type="button"><i class="ri-search-line"></i> Search Student</button>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="TG_PROGRAM">Program <span class="text-danger">*</span></label>
                                <select class="form-select select2" name="TG_PROGRAM" id="TG_PROGRAM" required>
                                    <option value="">--Select Programs--</option>
                                    <?php foreach ($LoadPrograms->result() as $row): ?>
                                        <option value="<?= $row->P_PDESCRIPTIONS ?>" <?= $r->TG_PROGRAM == $row->P_PDESCRIPTIONS ? 'selected' : '' ?>><?= $row->P_PDESCRIPTIONS ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-4">
                                <label for="TG_MAJOR">Major</label>
                                <select class="form-select select2" name="TG_MAJOR" id="TG_MAJOR" readonly>
                                    <option value=""></option>
                                    <?php
                                    $major = $this->db->where("P_PDESCRIPTIONS", $r->TG_PROGRAM)->get("tbl_program");
                                    foreach ($major->result() as $mj):
                                    ?>
                                        <option value="<?= $mj->P_MAJOR ?>" <?= $r->TG_MAJOR == $mj->P_MAJOR ? 'selected' : '' ?>><?= $mj->P_MAJOR ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="TG_ACADEMICYEAR">Academic Year <span class="text-danger">*</span></label>
                                <select class="form-select select2" name="TG_ACADEMICYEAR" id="TG_ACADEMICYEAR" required>
                                    <option value="">Select Academic Year</option>
                                    <?php for ($start_year = date('Y'); $start_year >= 1990; $start_year--): ?>
                                        <option value="<?= $start_year ?>" <?= $r->TG_ACADEMICYEAR == $start_year ? 'selected' : '' ?>><?= $start_year . '-' . ($start_year + 1) ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="TG_SEMESTER">Semester <span class="text-danger">*</span></label>
                                <select class="form-select select2" name="TG_SEMESTER" id="TG_SEMESTER" required>
                                    <option value="">--Select Semester--</option>
                                    <?php
                                    $semesters = $this->db
                                        ->join("tbl_semestertype", "tbl_program.P_SEMTYPE = tbl_semestertype.SEM_TYPE")
                                        ->where("P_PDESCRIPTIONS", $r->TG_PROGRAM)
                                        ->where("P_MAJOR", $r->TG_MAJOR)
                                        ->order_by("SEM_NAME")
                                        ->get("tbl_program");
                                    foreach ($semesters->result() as $sem):
                                    ?>
                                        <option value="<?= $sem->SEM_NAME ?>" <?= $r->TG_SEMESTER == $sem->SEM_NAME ? 'selected' : '' ?>><?= $sem->SEM_NAME ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-4">
                                <label for="TG_YEARLEVEL">Year Level <span class="text-danger">*</span></label>
                                <select class="form-select select2" id="TG_YEARLEVEL" name="TG_YEARLEVEL" required>
                                    <option value="">--Select Year Level--</option>
                                    <?php
                                    $levels = ["1ST YEAR", "2ND YEAR", "3RD YEAR", "4TH YEAR", "5TH YEAR"];
                                    foreach ($levels as $lvl):
                                    ?>
                                        <option value="<?= $lvl ?>" <?= $r->TG_YEARLEVEL == $lvl ? 'selected' : '' ?>><?= $lvl ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label for="TG_HEISFROM">Name of Institution From <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="TG_HEISFROM" id="TG_HEISFROM" value="<?= $r->TG_HEISFROM ?>" required />
                            </div>
                        </div>

                        <h5>Subject to credits</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="tbl_subj">
                                <thead>
                                    <tr>
                                        <th>Course No.</th>
                                        <th>Subject</th>
                                        <th>Units</th>
                                        <th>Grades</th>
                                        <th>
                                            <button type="button" class="btn btn-primary btn-sm add-subject"><i class="ri-add-line"></i></button>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $subj = $this->db->where("TG_KEY", $r->TG_KEY)->get("tbl_transfereegrades_subj");
                                    foreach ($subj->result() as $s):
                                    ?>
                                        <tr>
                                            <td><input type="text" name="TG_COURSENO[]" class="form-control" value="<?= $s->TG_COURSENO ?>" required></td>
                                            <td><input type="text" name="TG_SUBJECT[]" class="form-control" value="<?= $s->TG_SUBJECT ?>" required></td>
                                            <td><input type="number" name="TG_UNITS[]" class="form-control" value="<?= $s->TG_UNITS ?>" required></td>
                                            <td>
                                                <select name="TG_GRADES[]" class="form-select" required>
                                                    <option value=""></option>
                                                    <?php
                                                    $grades = ["1.00", "1.25", "1.50", "1.75", "2.00", "2.25", "2.50", "2.75", "3.00", "5.00", "INC", "DRP"];
                                                    foreach ($grades as $g):
                                                    ?>
                                                        <option value="<?= $g ?>" <?= $s->TG_GRADES == $g ? 'selected' : '' ?>><?= $g ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-danger btn-sm remove-subject"><i class="ri-delete-bin-line"></i></button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>

                    </div>
                <?php endforeach; ?>
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

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const tableBody = document.querySelector("#tbl_subj tbody");

        document.querySelector(".add-subject").addEventListener("click", function() {
            const newRow = document.createElement("tr");
            newRow.innerHTML = `
                <td><input type="text" name="TG_COURSENO[]" class="form-control" required></td>
                <td><input type="text" name="TG_SUBJECT[]" class="form-control" required></td>
                <td><input type="number" name="TG_UNITS[]" class="form-control" required></td>
                <td>
                    <select name="TG_GRADES[]" class="form-select">
                        <option value=""></option>
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
                <td><button type="button" class="btn btn-danger btn-sm remove-subject"><i class="ri-delete-bin-line"></i></button></td>
            `;
            tableBody.appendChild(newRow);
        });

        tableBody.addEventListener("click", function(e) {
            if (e.target.closest(".remove-subject")) {
                e.target.closest("tr").remove();
            }
        });
    });
</script>