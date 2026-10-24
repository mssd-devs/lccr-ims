<div class="container-xxl flex-grow-1 container-p-y">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb breadcrumb-style1">
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">Grading System</a>
            </li>
            <li class="breadcrumb-item">
                <a href="javascript:void(0);">List of Classes</a>
            </li>
            <li class="breadcrumb-item active">Encoding of Grades</li>
        </ol>
    </nav>

    <div class="row gy-4">
        <div class="col-md-12">
            <div class="card">
                <form action="">
                    <div class="card-body">

                        <!-- HEADER INFO -->
                        <div class="text-center mb-4">
                            <h4 class="fw-bold">FINAL GRADES COMPUTATION</h4>
                        </div>
                        <?php
                        $query = $this->db->where("ID", $this->uri->segment(4))->get("tbl_scheduling");
                        foreach ($query->result() as $rows) {
                            if ($rows->ID == $this->uri->segment(4)) {
                                $disableSave = false; // Restriction removed — pending enrollment no longer blocks saving

                                // Retrieve S_SUBTYPE for the subject
                                $subject_row = $this->db->get_where("tbl_subject", [
                                    "S_SDESCRIPTION" => $rows->SC_SDESC,
                                    "S_SELECTPROG" => $rows->SC_PROG,
                                    "S_MAJOR" => $rows->SC_MAJOR
                                ])->row();

                                if (!$subject_row) {
                                    $subject_row = $this->db->get_where("tbl_subject", [
                                        "S_SDESCRIPTION" => $rows->SC_SDESC,
                                        "S_SELECTPROG" => $rows->SC_PROG
                                    ])->row();
                                }
                                if (!$subject_row) {
                                    $subject_row = $this->db->get_where("tbl_subject", [
                                        "S_SDESCRIPTION" => $rows->SC_SDESC
                                    ])->row();
                                }
                                $subject_subtype = ($subject_row && !empty($subject_row->S_SUBTYPE)) ? strtoupper(trim($subject_row->S_SUBTYPE)) : 'MINOR';
                        ?>
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
                                                    <td><strong>Teaching Method :</strong> <?= $rows->SC_TEACHMODELS; ?> | <strong>Subject Type :</strong> <?= $subject_subtype; ?></td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <!-- TABLE -->
                                <div class="table-responsive" style="overflow-x: auto; max-width: 100%;">
                                    <table class="table table-bordered text-center align-middle" style="font-size: 1rem; min-width: 1800px;">
                                        <thead class="table-dark">
                                            <tr>
                                                <th rowspan="2">No.</th>
                                                <th rowspan="2" style="min-width: 200px; white-space: nowrap;">NAME OF STUDENTS</th>
                                                <th rowspan="2">ATTENDANCE<br><small>10%</small></th>
                                                <th colspan="3">EXAM</th>
                                                <th rowspan="2">FINAL REQUIREMENT<br><small>10%</small></th>
                                                <th rowspan="2">PERFORMANCE TASKS<br><small>20%</small></th>
                                                <th rowspan="2">WRITTEN TASKS<br><small>15%</small></th>
                                                <th rowspan="2">FINAL<br><small>100%</small></th>
                                                <th rowspan="2">TRANSMUTED GRADE</th>
                                                <th rowspan="2">REMARKS</th>
                                            </tr>
                                            <tr class="table-light">
                                                <th>P<br><small>10%</small></th>
                                                <th>M<br><small>15%</small></th>
                                                <th>F<br><small>20%</small></th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbl_body">
                                            <?php
                                            $i = 1;
                                            $query = $this->db->where("ER_SEMESTER", $rows->SC_SEMESTER)->get("tbl_enrollment");
                                            foreach ($query->result() as $r) {
                                                if ($r->ER_SECTION == $rows->SC_SECTION) {
                                                    $stud = $this->db->where("SP_STUDID", $r->ER_STUDENTID)->get("tbl_studprof")->row();
                                                    if ($stud) {
                                                        $student_id = $r->ER_STUDENTID;
                                                        $query2 = $this->db->where("GS_STUDENTID", $r->ER_STUDENTID)->get("tbl_gradingsystem");
                                                        foreach ($query2->result() as $r1) {
                                                            if ($r1->G_SCHEDID == $this->uri->segment(4)) {
                                            ?>
                                                                <tr>
                                                                    <td><?= $i++; ?></td>
                                                                    <td>
                                                                        <input type="hidden" id="GS_STUDENTID" name="GS_STUDENTID[]" value="<?= $r1->GS_STUDENTID; ?>">
                                                                        <input type="hidden" id="GS_FULLNAME" name="GS_FULLNAME[]" value="<?= $r1->GS_FULLNAME; ?>">
                                                                        <?= $r1->GS_FULLNAME; ?>
                                                                    </td>
                                                                    <td><input type="number" name="GS_ATTENDANCE[]" class="form-control grade attendance" step="0.01"></td>
                                                                    <td><input type="number" name="GS_EXAMPRELIM[]" class="form-control grade exam-p" step="0.01"></td>
                                                                    <td><input type="number" name="GS_EXAMMIDTERM[]" class="form-control grade exam-m" step="0.01"></td>
                                                                    <td><input type="number" name="GS_EXAMFINAL[]" class="form-control grade exam-f" step="0.01"></td>
                                                                    <td><input type="number" name="GS_FINALREQ[]" class="form-control grade final-req" step="0.01"></td>
                                                                    <td><input type="number" name="GS_PERFORMANCE[]" class="form-control grade performance" step="0.01"></td>
                                                                    <td><input type="number" name="GS_WRITTEN[]" class="form-control grade written" step="0.01"></td>
                                                                    <td><input type="number" name="GS_FINALGRADE[]" class="form-control final-grade" readonly></td>
                                                                    <td><input type="number" name="GS_TRANSMUTED[]" class="form-control transmuted-grade" readonly></td>
                                                                    <td><input type="text" name="GS_REMARKS[]" class="form-control form-control-sm remarks" readonly></td>
                                                                </tr>
                                                                </tr>
                                            <?php
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                        <tr>
                                            <td colspan="5"><strong>Total Students:</strong> <?= $i - 1; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <script>
                                    document.addEventListener("input", function(e) {
                                        if (!e.target.classList.contains("grade")) return;

                                        const row = e.target.closest("tr");

                                        const attendance = parseFloat(row.querySelector(".attendance").value) || 0;
                                        const examP = parseFloat(row.querySelector(".exam-p").value) || 0;
                                        const examM = parseFloat(row.querySelector(".exam-m").value) || 0;
                                        const examF = parseFloat(row.querySelector(".exam-f").value) || 0;
                                        const finalReq = parseFloat(row.querySelector(".final-req").value) || 0;
                                        const performance = parseFloat(row.querySelector(".performance").value) || 0;
                                        const written = parseFloat(row.querySelector(".written").value) || 0;

                                        const finalGrade =
                                            (attendance * 0.10) +
                                            (examP * 0.10) +
                                            (examM * 0.15) +
                                            (examF * 0.20) +
                                            (finalReq * 0.10) +
                                            (performance * 0.20) +
                                            (written * 0.15);

                                        row.querySelector(".final-grade").value = finalGrade.toFixed(2);

                                        const subjectSubtype = "<?= $subject_subtype; ?>";

                                        function transmuteGrade(fg) {
                                            if (subjectSubtype === "MAJOR") {
                                                if (fg >= 100) return { grade: "1.0", remarks: "Excellent" };
                                                if (fg >= 98) return { grade: "1.1", remarks: "Excellent" };
                                                if (fg >= 96) return { grade: "1.2", remarks: "Excellent" };
                                                if (fg >= 94) return { grade: "1.3", remarks: "Excellent" };
                                                if (fg >= 92) return { grade: "1.4", remarks: "Excellent" };
                                                if (fg >= 90) return { grade: "1.5", remarks: "Excellent" };
                                                if (fg >= 88) return { grade: "1.6", remarks: "Very Good" };
                                                if (fg >= 86) return { grade: "1.7", remarks: "Very Good" };
                                                if (fg >= 84) return { grade: "1.8", remarks: "Very Good" };
                                                if (fg >= 82) return { grade: "1.9", remarks: "Very Good" };
                                                if (fg >= 80) return { grade: "2.0", remarks: "Very Good" };
                                                if (fg >= 78) return { grade: "2.1", remarks: "Good" };
                                                if (fg >= 76) return { grade: "2.2", remarks: "Satisfactory" };
                                                if (fg >= 74) return { grade: "2.3", remarks: "Satisfactory" };
                                                if (fg >= 72) return { grade: "2.4", remarks: "Satisfactory" };
                                                if (fg >= 70) return { grade: "2.5", remarks: "Satisfactory" };
                                                if (fg >= 68) return { grade: "2.6", remarks: "Satisfactory" };
                                                if (fg >= 66) return { grade: "2.7", remarks: "Satisfactory" };
                                                if (fg >= 64) return { grade: "2.8", remarks: "Passing" };
                                                if (fg >= 62) return { grade: "2.9", remarks: "Passing" };
                                                if (fg >= 60) return { grade: "3.0", remarks: "Passing" };
                                                return { grade: "5.0", remarks: "Failure" };
                                            } else {
                                                if (fg >= 99) return { grade: "1.0", remarks: "Excellent" };
                                                if (fg >= 97) return { grade: "1.1", remarks: "Excellent" };
                                                if (fg >= 95) return { grade: "1.2", remarks: "Excellent" };
                                                if (fg >= 93) return { grade: "1.3", remarks: "Excellent" };
                                                if (fg >= 91) return { grade: "1.4", remarks: "Excellent" };
                                                if (fg >= 89) return { grade: "1.5", remarks: "Excellent" };
                                                if (fg >= 87) return { grade: "1.6", remarks: "Very Good" };
                                                if (fg >= 85) return { grade: "1.7", remarks: "Very Good" };
                                                if (fg >= 83) return { grade: "1.8", remarks: "Very Good" };
                                                if (fg >= 80) return { grade: "1.9", remarks: "Very Good" };
                                                if (fg >= 78) return { grade: "2.0", remarks: "Very Good" };
                                                if (fg >= 76) return { grade: "2.1", remarks: "Good" };
                                                if (fg >= 74) return { grade: "2.2", remarks: "Satisfactory" };
                                                if (fg >= 72) return { grade: "2.3", remarks: "Satisfactory" };
                                                if (fg >= 70) return { grade: "2.4", remarks: "Satisfactory" };
                                                if (fg >= 67) return { grade: "2.5", remarks: "Satisfactory" };
                                                if (fg >= 64) return { grade: "2.6", remarks: "Satisfactory" };
                                                if (fg >= 61) return { grade: "2.7", remarks: "Satisfactory" };
                                                if (fg >= 57) return { grade: "2.8", remarks: "Passing" };
                                                if (fg >= 54) return { grade: "2.9", remarks: "Passing" };
                                                if (fg >= 50) return { grade: "3.0", remarks: "Passing" };
                                                return { grade: "5.0", remarks: "Failure" };
                                            }
                                        }

                                        const result = transmuteGrade(finalGrade);

                                        row.querySelector(".transmuted-grade").value = result.grade;
                                        row.querySelector(".remarks").value = result.remarks;
                                    });
                                </script>
                                <!-- Save Buttons -->
                                <div class="row" style="margin-top:15px;">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success btn-lg btnSave">Save</button>
                                            <button type="button" class="btn btn-warning btn-lg btnDraft">Save as Draft</button>
                                        </div>
                                    </div>
                                </div>



                        <?php
                            }
                        }
                        ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Transmutation Reference Modal -->
<div class="modal fade" id="transmutationTableModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header" style="background: #343a55;">
                <h5 class="modal-title text-white"><i class="ri-file-list-3-line me-2"></i>Grade Transmutation Reference Table</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <!-- GE / Minor Courses Column -->
                    <div class="col-md-6 border-end">
                        <div class="p-3 text-center bg-light fw-bold border-bottom d-flex align-items-center justify-content-center gap-2">
                            <span class="fs-6 text-primary"><i class="ri-book-read-line me-1"></i>GE / Minor &amp; Mandated Courses (50% Passing)</span>
                            <?php if ($subject_subtype !== 'MAJOR'): ?>
                                <span class="badge bg-primary rounded-pill"><i class="ri-checkbox-circle-line me-1"></i>Active</span>
                            <?php endif; ?>
                        </div>
                        <div class="table-responsive" style="max-height: 450px;">
                            <table class="table table-bordered table-striped text-center mb-0 table-sm align-middle">
                                <thead class="table-warning sticky-top" style="z-index: 10;">
                                    <tr>
                                        <th>Final Grade (%)</th>
                                        <th>Transmuted Grade</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>99 – 100</td><td><strong>1.0</strong></td><td class="text-success fw-bold">Excellent</td></tr>
                                    <tr><td>97 – 98</td><td><strong>1.1</strong></td><td class="text-success fw-bold">Excellent</td></tr>
                                    <tr><td>95 – 96</td><td><strong>1.2</strong></td><td class="text-success fw-bold">Excellent</td></tr>
                                    <tr><td>93 – 94</td><td><strong>1.3</strong></td><td class="text-success fw-bold">Excellent</td></tr>
                                    <tr><td>91 – 92</td><td><strong>1.4</strong></td><td class="text-success fw-bold">Excellent</td></tr>
                                    <tr><td>89 – 90</td><td><strong>1.5</strong></td><td class="text-success fw-bold">Excellent</td></tr>
                                    <tr><td>87 – 88</td><td><strong>1.6</strong></td><td class="text-success">Very Good</td></tr>
                                    <tr><td>85 – 86</td><td><strong>1.7</strong></td><td class="text-success">Very Good</td></tr>
                                    <tr><td>83 – 84</td><td><strong>1.8</strong></td><td class="text-success">Very Good</td></tr>
                                    <tr><td>80 – 82</td><td><strong>1.9</strong></td><td class="text-success">Very Good</td></tr>
                                    <tr><td>78 – 79</td><td><strong>2.0</strong></td><td class="text-success">Very Good</td></tr>
                                    <tr><td>76 – 77</td><td><strong>2.1</strong></td><td class="text-info">Good</td></tr>
                                    <tr><td>74 – 75</td><td><strong>2.2</strong></td><td class="text-warning">Satisfactory</td></tr>
                                    <tr><td>72 – 73</td><td><strong>2.3</strong></td><td class="text-warning">Satisfactory</td></tr>
                                    <tr><td>70 – 71</td><td><strong>2.4</strong></td><td class="text-warning">Satisfactory</td></tr>
                                    <tr><td>67 – 69</td><td><strong>2.5</strong></td><td class="text-warning">Satisfactory</td></tr>
                                    <tr><td>64 – 66</td><td><strong>2.6</strong></td><td class="text-warning">Satisfactory</td></tr>
                                    <tr><td>61 – 63</td><td><strong>2.7</strong></td><td class="text-warning">Satisfactory</td></tr>
                                    <tr><td>57 – 60</td><td><strong>2.8</strong></td><td class="text-warning">Passing</td></tr>
                                    <tr><td>54 – 56</td><td><strong>2.9</strong></td><td class="text-warning">Passing</td></tr>
                                    <tr><td>50 – 53</td><td><strong>3.0</strong></td><td class="text-warning">Passing</td></tr>
                                    <tr class="table-danger"><td><strong>Below 50</strong></td><td><strong>5.0</strong></td><td class="text-danger fw-bold">Failure</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Major Courses Column -->
                    <div class="col-md-6">
                        <div class="p-3 text-center bg-light fw-bold border-bottom d-flex align-items-center justify-content-center gap-2">
                            <span class="fs-6 text-info"><i class="ri-honor-line me-1"></i>Major Courses &amp; Elective Majors (60% Passing)</span>
                            <?php if ($subject_subtype === 'MAJOR'): ?>
                                <span class="badge bg-info rounded-pill"><i class="ri-checkbox-circle-line me-1"></i>Active</span>
                            <?php endif; ?>
                        </div>
                        <div class="table-responsive" style="max-height: 450px;">
                            <table class="table table-bordered table-striped text-center mb-0 table-sm align-middle">
                                <thead class="table-warning sticky-top" style="z-index: 10;">
                                    <tr>
                                        <th>Final Grade (%)</th>
                                        <th>Transmuted Grade</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr><td>100</td><td><strong>1.0</strong></td><td class="text-success fw-bold">Excellent</td></tr>
                                    <tr><td>98 – 99</td><td><strong>1.1</strong></td><td class="text-success fw-bold">Excellent</td></tr>
                                    <tr><td>96 – 97</td><td><strong>1.2</strong></td><td class="text-success fw-bold">Excellent</td></tr>
                                    <tr><td>94 – 95</td><td><strong>1.3</strong></td><td class="text-success fw-bold">Excellent</td></tr>
                                    <tr><td>92 – 93</td><td><strong>1.4</strong></td><td class="text-success fw-bold">Excellent</td></tr>
                                    <tr><td>90 – 91</td><td><strong>1.5</strong></td><td class="text-success fw-bold">Excellent</td></tr>
                                    <tr><td>88 – 89</td><td><strong>1.6</strong></td><td class="text-success">Very Good</td></tr>
                                    <tr><td>86 – 87</td><td><strong>1.7</strong></td><td class="text-success">Very Good</td></tr>
                                    <tr><td>84 – 85</td><td><strong>1.8</strong></td><td class="text-success">Very Good</td></tr>
                                    <tr><td>82 – 83</td><td><strong>1.9</strong></td><td class="text-success">Very Good</td></tr>
                                    <tr><td>80 – 81</td><td><strong>2.0</strong></td><td class="text-success">Very Good</td></tr>
                                    <tr><td>78 – 79</td><td><strong>2.1</strong></td><td class="text-info">Good</td></tr>
                                    <tr><td>76 – 77</td><td><strong>2.2</strong></td><td class="text-warning">Satisfactory</td></tr>
                                    <tr><td>74 – 75</td><td><strong>2.3</strong></td><td class="text-warning">Satisfactory</td></tr>
                                    <tr><td>72 – 73</td><td><strong>2.4</strong></td><td class="text-warning">Satisfactory</td></tr>
                                    <tr><td>70 – 71</td><td><strong>2.5</strong></td><td class="text-warning">Satisfactory</td></tr>
                                    <tr><td>68 – 69</td><td><strong>2.6</strong></td><td class="text-warning">Satisfactory</td></tr>
                                    <tr><td>66 – 67</td><td><strong>2.7</strong></td><td class="text-warning">Satisfactory</td></tr>
                                    <tr><td>64 – 65</td><td><strong>2.8</strong></td><td class="text-warning">Passing</td></tr>
                                    <tr><td>62 – 63</td><td><strong>2.9</strong></td><td class="text-warning">Passing</td></tr>
                                    <tr><td>60 – 61</td><td><strong>3.0</strong></td><td class="text-warning">Passing</td></tr>
                                    <tr class="table-danger"><td><strong>Below 60</strong></td><td><strong>5.0</strong></td><td class="text-danger fw-bold">Failure</td></tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        function initializeDataTable() {
            $('#dataTable').DataTable({
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
        }

        initializeDataTable();
    });
</script>