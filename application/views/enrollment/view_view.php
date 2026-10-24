<div class="container-xxl flex-grow-1 container-p-y">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Enrollment</a>
            </li>
            <li class="breadcrumb-item active">View</li>
        </ol>
    </nav>
    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Enrollment Assessment Form</h4>
                </div>
                <div class="card-body">
                    <form action="<?= base_url("EnrollmentController/saveUpdate"); ?>" method="post">
                        <input type="hidden" name="ID" value="">
                        <input type="hidden" class="txt_csrfname" name="<?= $this->security->get_csrf_token_name(); ?>"
                            value="<?= $this->security->get_csrf_hash(); ?>">
                        <?php
                        $ER_TRANSNO = "";
                        foreach ($LoadStudentEnrolled->result() as $rows) {
                            $ER_TRANSNO = $rows->ER_TRANSNO;
                        ?>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-sm w-100">
                                            <tr>
                                                <td><strong>Year Level :</strong> <?= substr($rows->ER_YEARLEVEL, 0, 3); ?>
                                                </td>
                                                <td><strong>Academic Term :</strong> <?= $rows->ER_SEMESTER; ?></td>
                                                <td><strong>Academic Year :</strong>
                                                    <?= $rows->ER_ACADEMICYEAR . '-' . ($rows->ER_ACADEMICYEAR + 1); ?></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Student Number :</strong> <?= $rows->ER_STUDENTID; ?></td>
                                                <td><strong>Type :</strong>
                                                    <?= isset($rows->ER_STATUS) ? ucfirst(strtolower($rows->ER_STATUS)) : ""; ?>
                                                </td>
                                                <td><strong>Status :</strong>
                                                    <?= isset($rows->ER_CLASSIFICATION) ? ucfirst(strtolower($rows->ER_CLASSIFICATION)) : ""; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2"><strong>Full Name :</strong>
                                                    <?= $rows->SP_LASTNAME . ' ' .  $rows->SP_FIRSTNAME . ' ' . $rows->SP_MIDDLENAME; ?>
                                                </td>
                                                <td><strong>Sex :</strong>
                                                    <?= isset($rows->SP_GENDER) ? ucfirst(strtolower($rows->SP_GENDER)) : ""; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Program and Major :</strong> <?= $rows->P_PCODE; ?></td>
                                                <td><strong>Contact No. :</strong> <?= $rows->SP_CPNUMBER; ?></td>
                                                <td><strong>Age :</strong>
                                                    <?= !empty($rows->SP_BIRTHDAY) && strtotime($rows->SP_BIRTHDAY) ? (new DateTime())->diff(new DateTime($rows->SP_BIRTHDAY))->y : "" ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td colspan="3"><strong>Complete Address :</strong>
                                                    <?= "$rows->SP_STRT, $rows->brgyDesc, $rows->citymunDesc, $rows->provDesc, $rows->regDesc"; ?>
                                                </td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <!-- Table for selected subjects -->
                                <div class="table-responsive">
                                    <table id="subjectTable" class="table table-bordered table-sm w-100"
                                        style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Subject Code</th>
                                                <th>Subject Description</th>
                                                <th>Modality</th>
                                                <th>Time</th>
                                                <th>Days</th>
                                                <th>Room</th>
                                                <th>Section</th>
                                                <th>Units</th>
                                                <th>Instructor</th>
                                                <th>Pre-Requisite</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl_subjects">
                                            <?php
                                            $num = 0;
                                            foreach ($LoadEditSubjects->result() as $r) {
                                                $num++;
                                                echo '<tr>';
                                                echo '<td>' . $num . '</td>';
                                                echo '<td><input type="hidden" name="ER_SUBJECTS[]" id="E_SID" value="' . htmlspecialchars($r->ID) . '">' . htmlspecialchars($r->S_SCODE) . '</td>';
                                                echo '<td>' . $r->S_SDESCRIPTION . '</td>';
                                                echo '<td>' . htmlspecialchars($r->SC_TEACHMODELS) . '</td>';
                                                $startTime = !empty($r->SC_STARTTIME) ? date("h:i A", strtotime($r->SC_STARTTIME)) : '';
                                                $endTime = !empty($r->SC_ENDTIME) ? date("h:i A", strtotime($r->SC_ENDTIME)) : '';
                                                echo '<td>' . $startTime . ($startTime && $endTime ? '-' : '') . $endTime . '</td>';
                                                echo '<td>' . htmlspecialchars($r->SC_DAY) . '</td>';
                                                echo '<td>' . htmlspecialchars($r->SC_ROOM) . '</td>';
                                                echo '<td>' . htmlspecialchars($r->SC_SECTION) . '</td>';
                                                echo '<td>' . htmlspecialchars($r->S_UNITS) . '</td>';
                                                echo '<td>' . htmlspecialchars($r->SC_FACULTY) . '</td>';
                                                echo '<td>' . htmlspecialchars($r->S_PREREQ) . '</td>';
                                                echo '</tr>';
                                            }
                                            ?>
                                        </tbody>
                                        <tfoot>
                                            <tr id="totalUnitsRow">
                                                <td colspan="8" class="text-end fw-bold">Total Units</td>
                                                <td id="totalUnits">0</td>
                                                <td colspan="3"><input type="hidden" name="ER_UNITS" id="ER_UNITS"></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <?php
                    $permission = [];

                    if ($rbac->num_rows() > 0 || $this->session->userdata("usertype") == "Administrator") {
                        foreach ($rbac->result() as $rbac_row) {
                            $permission[] = $rbac_row->ACTIONS; // Collect actions into an array
                        }
                        // Check if 'Create' exists in the permission list, or if user is admin
                        if (in_array("Edit", $permission) || $this->session->userdata("usertype") == "Administrator") {
                    ?>
                            <a href="<?= base_url("ims/enrollment/edit/" . $this->uri->segment(4)) ?>" type="button"
                                class="btn btn-primary"><i class="ri ri-edit-line"></i> Edit</a>
                    <?php
                        }
                    }
                    ?>



                    <button type="button" class="btn btn-secondary btnPrint" data-trno="<?= $ER_TRANSNO; ?>"
                        data-id="<?= $this->uri->segment(4); ?>"><i class="ri-printer-line"></i> Print</button>
                </div>
            </div>
        </div>
    </div>
</div>








<!-- / Content -->
<script>
    $(document).ready(function() {

        // Print button click event
        $(document).on("click", ".btnPrint", function() {
            const id = $(this).data("id");
            const trno = $(this).data("trno");
            window.open("<?= base_url('ims/enrollment/print/') ?>" + id + '/' + trno, '_blank');
        });



        updateTable();
        // Update table numbering and total units
        function updateTable() {
            var totalUnits = 0;
            var num = 1;

            $('#tbl_subjects tr').each(function() {
                $(this).find('td:first-child').text(num); // Update numbering
                var rowUnits = parseInt($(this).find('td:nth-child(9)').text());
                totalUnits += isNaN(rowUnits) ? 0 : rowUnits;
                num++;
            });

            $('#totalUnits').text(totalUnits); // Update total units in footer
            $('#ER_UNITS').val(totalUnits); // Update total units in footer
        }


        $('#myTable').DataTable({});
    });
</script>