<?php
#[AllowDynamicProperties]
class RGrades_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    function LoadStudentGrades()
    {
        $this->sync_gradingsystem_to_studentgrades();

        $table_rows = "";
        $modals_html = "";

        $FILTER_PROGRAM = $this->input->post("FILTER_PROGRAM");
        $FILTER_MAJOR   = $this->input->post("FILTER_MAJOR");
        $FILTER_YL      = $this->input->post("FILTER_YL");
        $FILTER_AY      = $this->input->post("FILTER_AY");
        $FILTER_SEM     = $this->input->post("FILTER_SEM");

        // Fetch dynamic signatories and web settings
        $signatory = $this->db->get("tbl_signatories")->row();
        $registrar_name = ($signatory && !empty($signatory->SIG_REG)) ? $signatory->SIG_REG : 'School Registrar';
        $ws = $this->db->get("tbl_websettings")->row();

        // Query distinct student semester records
        $sql = "SELECT 
                sg.G_STUDENTID,
                MIN(sg.G_FULLNAME) AS G_FULLNAME,
                sg.G_ACADEMICYEAR,
                sg.G_SEMESTER,
                MIN(sg.G_GENDER) AS G_GENDER,
                MIN(sg.G_YEARLEVEL) AS G_YEARLEVEL,
                MIN(e.ER_PROGRAM) AS ER_PROGRAM,
                MIN(e.ER_MAJOR) AS ER_MAJOR,
                MIN(e.ER_YEARLEVEL) AS ER_YEARLEVEL,
                MIN(e_any.ER_PROGRAM) AS ANY_PROGRAM,
                MIN(e_any.ER_MAJOR) AS ANY_MAJOR,
                MIN(s.SP_LASTNAME) AS SP_LASTNAME,
                MIN(s.SP_FIRSTNAME) AS SP_FIRSTNAME,
                MIN(s.SP_MIDDLENAME) AS SP_MIDDLENAME,
                MIN(s.SP_SUFFIX) AS SP_SUFFIX,
                MIN(s.SP_GENDER) AS SP_GENDER,
                MIN(s.SP_LRN) AS SP_LRN,
                MIN(s.SP_IMAGE) AS SP_IMAGE
            FROM
                tbl_studentgrades AS sg
            LEFT JOIN 
                tbl_enrollment AS e ON (e.ER_STUDENTID = sg.G_STUDENTID AND e.ER_ACADEMICYEAR = sg.G_ACADEMICYEAR AND e.ER_SEMESTER = sg.G_SEMESTER)
            LEFT JOIN 
                tbl_enrollment AS e_any ON (e_any.ER_STUDENTID = sg.G_STUDENTID)
            LEFT JOIN
                tbl_studprof AS s ON sg.G_STUDENTID = s.SP_STUDID
            WHERE 1=1";

        if (!empty($FILTER_PROGRAM)) {
            $sql .= " AND (e.ER_PROGRAM = " . $this->db->escape($FILTER_PROGRAM) . " OR e_any.ER_PROGRAM = " . $this->db->escape($FILTER_PROGRAM) . ")";
        }
        if (!empty($FILTER_MAJOR)) {
            $sql .= " AND (e.ER_MAJOR = " . $this->db->escape($FILTER_MAJOR) . " OR e_any.ER_MAJOR = " . $this->db->escape($FILTER_MAJOR) . ")";
        }
        if (!empty($FILTER_YL)) {
            $sql .= " AND (e.ER_YEARLEVEL = " . $this->db->escape($FILTER_YL) . " OR sg.G_YEARLEVEL = " . $this->db->escape($FILTER_YL) . ")";
        }
        if (!empty($FILTER_AY)) {
            $sql .= " AND (e.ER_ACADEMICYEAR = " . $this->db->escape($FILTER_AY) . " OR sg.G_ACADEMICYEAR = " . $this->db->escape($FILTER_AY) . ")";
        }
        if (!empty($FILTER_SEM)) {
            $sql .= " AND (e.ER_SEMESTER = " . $this->db->escape($FILTER_SEM) . " OR sg.G_SEMESTER = " . $this->db->escape($FILTER_SEM) . ")";
        }

        $sql .= " GROUP BY sg.G_STUDENTID, sg.G_ACADEMICYEAR, sg.G_SEMESTER";
        $sql .= " ORDER BY sg.G_STUDENTID ASC, sg.G_ACADEMICYEAR DESC, sg.G_SEMESTER DESC";

        $query = $this->db->query($sql);
        $modal_index = 0;

        foreach ($query->result() as $r) {
            $student_id    = $r->G_STUDENTID;
            $academic_year = $r->G_ACADEMICYEAR;
            $semester      = $r->G_SEMESTER;
            $program       = !empty($r->ER_PROGRAM) ? $r->ER_PROGRAM : (!empty($r->ANY_PROGRAM) ? $r->ANY_PROGRAM : '');
            $major_val     = !empty($r->ER_MAJOR) ? $r->ER_MAJOR : (!empty($r->ANY_MAJOR) ? $r->ANY_MAJOR : '');
            $major_str     = (!empty($major_val)) ? '<small><b>(' . $major_val . ')</b></small>' : '';
            $fullname      = !empty($r->G_FULLNAME) ? $r->G_FULLNAME : trim($r->SP_FIRSTNAME . ' ' . $r->SP_MIDDLENAME . ' ' . $r->SP_LASTNAME);
            $gender        = !empty($r->SP_GENDER) ? $r->SP_GENDER : $r->G_GENDER;
            $year_level    = !empty($r->ER_YEARLEVEL) ? $r->ER_YEARLEVEL : $r->G_YEARLEVEL;

            // Fetch subjects for this student + AY + Semester
            $subjects = $this->db
                ->where('G_STUDENTID', $student_id)
                ->where('G_ACADEMICYEAR', $academic_year)
                ->where('G_SEMESTER', $semester)
                ->get('tbl_studentgrades')
                ->result();

            $total_weighted = 0;
            $total_units    = 0;

            foreach ($subjects as $s) {
                $sq = $this->db->get_where('tbl_subject', ['S_SDESCRIPTION' => $s->G_SUBJECT])->row();
                $u = ($sq) ? floatval($sq->S_UNITS) : 0;

                $num_grade = null;
                if (is_numeric($s->G_GRADE)) {
                    $num_grade = floatval($s->G_GRADE);
                } elseif (!empty($s->G_REEXAM) && is_numeric($s->G_REEXAM)) {
                    $num_grade = floatval($s->G_REEXAM);
                } elseif (strpos($s->G_GRADE, 'INC/') === 0) {
                    $parts = explode('/', $s->G_GRADE);
                    if (isset($parts[1]) && is_numeric($parts[1])) {
                        $num_grade = floatval($parts[1]);
                    }
                }

                if ($num_grade !== null && $u > 0) {
                    $total_weighted += ($num_grade * $u);
                    $total_units    += $u;
                }
            }

            $gwa = ($total_units > 0) ? number_format($total_weighted / $total_units, 2) : 'N/A';
            $status = ($gwa !== 'N/A') ? (($gwa <= 3.0) ? 'Passed' : 'Failed') : 'Pending';

            $view_modal_id   = "viewModal_" . $modal_index;
            $edit_modal_id   = "editModal_" . $modal_index;
            $print_report_id = "printReportModal_" . $modal_index;
            $print_cert_id   = "printCertModal_" . $modal_index;

            $ay_display  = htmlspecialchars($academic_year . '-' . ((int)$academic_year + 1));
            $sem_display = htmlspecialchars($semester);

            $status_badge_cls = ($status == 'Passed') ? 'bg-success text-success' : (($status == 'Failed') ? 'bg-danger text-danger' : 'bg-warning text-warning');

            // Render Table Row
            $table_rows .= '<tr>';
            $table_rows .= '<td>' . htmlspecialchars($student_id) . '</td>';
            $table_rows .= '<td class="fw-bold">' . htmlspecialchars($fullname) . '</td>';
            $table_rows .= '<td>' . htmlspecialchars($program) . ' ' . $major_str . '</td>';
            $table_rows .= '<td>' . $ay_display . '</td>';
            $table_rows .= '<td><span class="badge bg-light text-dark border">' . $sem_display . '</span></td>';
            $table_rows .= '<td class="fw-bold">' . $gwa . '</td>';
            $table_rows .= '<td><span class="badge rounded-pill ' . $status_badge_cls . ' bg-opacity-10 px-3 border">' . $status . '</span></td>';
            $table_rows .= '<td class="text-end pe-3">
                <div class="d-flex justify-content-end gap-1">
                    <button type="button" class="btn btn-icon btn-outline-info btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#' . $view_modal_id . '" title="View Grades">
                        <i class="ri-eye-line"></i>
                    </button>
                    <button type="button" class="btn btn-icon btn-outline-warning btn-sm rounded-circle" data-bs-toggle="modal" data-bs-target="#' . $edit_modal_id . '" title="Edit Grades">
                        <i class="ri-edit-line"></i>
                    </button>
                    <div class="btn-group">
                        <button type="button" class="btn btn-icon btn-emerald btn-sm rounded-circle" data-bs-toggle="dropdown" aria-expanded="false" title="Print Options">
                            <i class="ri-printer-line"></i>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
                            <li><a class="dropdown-item py-2" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#' . $print_report_id . '">
                                <i class="ri-file-list-3-line me-2 text-emerald"></i> Print Grade Report
                            </a></li>
                            <li><a class="dropdown-item py-2" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#' . $print_cert_id . '">
                                <i class="ri-medal-fill me-2 text-warning"></i> Grade Certificate
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item py-2 btn-class-rgrades" href="javascript:void(0);" data-studentid="' . htmlspecialchars($student_id) . '">
                                <i class="ri-printer-line me-2 text-primary"></i> Print TOR
                            </a></li>
                        </ul>
                    </div>
                </div>
            </td>';
            $table_rows .= '</tr>';

            // Generate Modals HTML
            $modals_html .= $this->_build_modals_html(
                $modal_index,
                $student_id,
                $fullname,
                $year_level,
                $program,
                $major_val,
                $academic_year,
                $semester,
                $subjects,
                $gwa,
                $status,
                $total_units,
                $registrar_name,
                $ws
            );

            $modal_index++;
        }

        return [
            'output' => $table_rows,
            'modals' => $modals_html
        ];
    }

    private function _build_modals_html($modal_index, $student_id, $fullname, $year_level, $program, $major, $academic_year, $semester, $subjects, $gwa, $status, $total_units, $registrar_name, $ws)
    {
        $view_modal_id   = "viewModal_" . $modal_index;
        $edit_modal_id   = "editModal_" . $modal_index;
        $print_report_id = "printReportModal_" . $modal_index;
        $print_cert_id   = "printCertModal_" . $modal_index;

        $ay_str = htmlspecialchars($academic_year . '-' . ((int)$academic_year + 1));
        $sem_str = htmlspecialchars($semester);
        $program_str = htmlspecialchars($program . (!empty($major) ? ' (' . $major . ')' : ''));
        $csrf_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash();
        $base_url = base_url();

        $logo1 = $ws ? base_url('assets/img/' . $ws->IMS_WEB_IMG) : '';
        $logo2 = $ws ? base_url('assets/img/' . $ws->IMS_WEB_IMG2) : '';
        $school_nos = $ws ? htmlspecialchars($ws->IMS_WEB_NOS) : '';
        $school_addr = $ws ? htmlspecialchars($ws->IMS_WEB_ADDRESS) : '';

        $grade_options = [
            '1.00',
            '1.10',
            '1.20',
            '1.25',
            '1.30',
            '1.40',
            '1.50',
            '1.60',
            '1.70',
            '1.75',
            '1.80',
            '1.90',
            '2.00',
            '2.10',
            '2.20',
            '2.25',
            '2.30',
            '2.40',
            '2.50',
            '2.60',
            '2.70',
            '2.75',
            '2.80',
            '2.90',
            '3.00',
            '5.00',
            'INC',
            'DRP'
        ];
        $reexam_options = [
            '1.00',
            '1.10',
            '1.20',
            '1.25',
            '1.30',
            '1.40',
            '1.50',
            '1.60',
            '1.70',
            '1.75',
            '1.80',
            '1.90',
            '2.00',
            '2.10',
            '2.20',
            '2.25',
            '2.30',
            '2.40',
            '2.50',
            '2.60',
            '2.70',
            '2.75',
            '2.80',
            '2.90',
            '3.00',
            '5.00'
        ];

        $html = '';

        // --- 1. VIEW MODAL ---
        $html .= '<div class="modal fade" id="' . $view_modal_id . '" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header p-4">
                        <div>
                            <h5 class="modal-title text-emerald fw-bold mb-1">
                                <i class="ri-book-read-line me-2"></i> Academic Performance Record
                            </h5>
                            <p class="mb-0 text-muted small">
                                Student ID: ' . htmlspecialchars($student_id) . ' | AY ' . $ay_str . ' | ' . $sem_str . '
                            </p>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-0">
                        <div class="p-4 bg-light border-bottom d-flex justify-content-between align-items-center">
                            <div class="d-flex gap-4">
                                <div>
                                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem;">Student Name</small>
                                    <span class="h6 mb-0 fw-bold text-dark">' . htmlspecialchars($fullname) . '</span>
                                </div>
                                <div>
                                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem;">Term GWA</small>
                                    <span class="h5 mb-0 fw-bold text-emerald">' . $gwa . '</span>
                                </div>
                                <div>
                                    <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.65rem;">Total Units</small>
                                    <span class="h5 mb-0 fw-bold text-dark">' . $total_units . '</span>
                                </div>
                            </div>
                            <span class="badge rounded-pill bg-' . (($status == 'Passed') ? 'success' : 'danger') . ' px-3 py-2">
                                ' . strtoupper($status) . '
                            </span>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-emerald-light text-emerald">
                                    <tr>
                                        <th class="ps-4 text-emerald fw-bold">Subject Description</th>
                                        <th class="text-center text-emerald fw-bold">Units</th>
                                        <th class="text-center text-emerald fw-bold">Grade</th>
                                        <th class="text-center text-emerald fw-bold">Compile Grade</th>
                                        <th class="text-emerald fw-bold">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>';
        foreach ($subjects as $s) {
            $sq = $this->db->get_where('tbl_subject', ['S_SDESCRIPTION' => $s->G_SUBJECT])->row();
            $u = ($sq) ? $sq->S_UNITS : '-';
            $reexam_val = !empty($s->G_REEXAM) ? $s->G_REEXAM : '-';
            $rem_cls = ($s->G_REMARKS == 'PASSED' || $s->G_REMARKS == 'Passed') ? 'text-success' : (($s->G_REMARKS == 'FAILED' || $s->G_REMARKS == 'Failed') ? 'text-danger' : 'text-warning');

            $html .= '<tr>
                        <td class="ps-4"><div class="fw-bold text-dark">' . htmlspecialchars($s->G_SUBJECT) . '</div></td>
                        <td class="text-center fw-medium">' . htmlspecialchars($u) . '</td>
                        <td class="text-center"><span class="badge bg-light text-dark border fw-bold">' . htmlspecialchars($s->G_GRADE) . '</span></td>
                        <td class="text-center">' . ($reexam_val !== '-' ? '<span class="badge bg-warning bg-opacity-10 text-warning border border-warning">' . htmlspecialchars($reexam_val) . '</span>' : '<span class="text-muted small">-</span>') . '</td>
                        <td><span class="' . $rem_cls . ' fw-medium">' . htmlspecialchars($s->G_REMARKS) . '</span></td>
                    </tr>';
        }
        $html .= '</tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer bg-light p-3">
                        <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>';

        // --- 2. EDIT MODAL ---
        $html .= '<div class="modal fade" id="' . $edit_modal_id . '" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <form method="post" action="' . $base_url . 'RgradesController/update_grades">
                        <input type="hidden" class="txt_csrfname" name="' . $csrf_name . '" value="' . $csrf_hash . '">
                        <input type="hidden" name="student_id" value="' . htmlspecialchars($student_id) . '">
                        <input type="hidden" name="academic_year" value="' . htmlspecialchars($academic_year) . '">
                        <input type="hidden" name="semester" value="' . htmlspecialchars($semester) . '">

                        <div class="modal-header p-4">
                            <div>
                                <h5 class="modal-title text-emerald fw-bold mb-1">
                                    <i class="ri-edit-box-line me-2"></i> Update Academic Records (Grading System)
                                </h5>
                                <p class="mb-0 text-muted small">
                                    Student: ' . htmlspecialchars($fullname) . ' (' . htmlspecialchars($student_id) . ') | AY ' . $ay_str . ' | ' . $sem_str . '
                                </p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body p-0">
                            <div class="alert alert-warning border-0 rounded-0 mb-0 d-flex align-items-center">
                                <i class="ri-information-line fs-4 me-3"></i>
                                <div>
                                    <small class="fw-bold d-block">Grading System Policy</small>
                                    <span class="small">Grade scale: 1.00–3.00 (Passed), 5.00 (Failed), INC (Incomplete), DRP (Dropped). Select INC to provide a compile grade.</span>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-emerald-light text-emerald">
                                        <tr>
                                            <th class="ps-4 py-3">Subject Description</th>
                                            <th class="text-center text-emerald fw-bold py-3" style="width: 170px;">Final Grade</th>
                                            <th class="text-center text-emerald fw-bold py-3" style="width: 170px;">Compile Grade</th>
                                            <th class="text-center text-emerald fw-bold py-3" style="width: 170px;">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
        foreach ($subjects as $idx => $s) {
            $is_inc = (strpos($s->G_GRADE, 'INC') === 0 || $s->G_GRADE == 'INC');
            $html .= '<tr>
                        <td class="ps-4">
                            <input type="hidden" name="subjects[' . $idx . '][id]" value="' . $s->ID . '">
                            <div class="fw-bold text-dark">' . htmlspecialchars($s->G_SUBJECT) . '</div>
                        </td>
                        <td>
                            <select class="form-select grade-select border-emerald-light text-center fw-bold" name="subjects[' . $idx . '][grade]" data-idx="' . $idx . '">
                                <option value="">-- Select --</option>';
            foreach ($grade_options as $gopt) {
                $sel = '';
                if ($s->G_GRADE === $gopt) {
                    $sel = 'selected';
                } elseif (is_numeric($s->G_GRADE) && is_numeric($gopt) && floatval($s->G_GRADE) == floatval($gopt)) {
                    $sel = 'selected';
                } elseif (strpos($s->G_GRADE, 'INC/') === 0 && $gopt === 'INC') {
                    $sel = 'selected';
                }
                $html .= '<option value="' . $gopt . '" ' . $sel . '>' . $gopt . '</option>';
            }
            $html .= '</select>
                        </td>
                        <td>
                            <select class="form-select reexam-select border-emerald-light text-center fw-bold" name="subjects[' . $idx . '][reexam_grade]" data-idx="' . $idx . '" ' . ($is_inc ? '' : 'disabled') . '>
                                <option value="">-- None --</option>';
            foreach ($reexam_options as $ropt) {
                $rsel = '';
                if (!empty($s->G_REEXAM)) {
                    if ($s->G_REEXAM === $ropt) {
                        $rsel = 'selected';
                    } elseif (is_numeric($s->G_REEXAM) && is_numeric($ropt) && floatval($s->G_REEXAM) == floatval($ropt)) {
                        $rsel = 'selected';
                    }
                }
                $html .= '<option value="' . $ropt . '" ' . $rsel . '>' . $ropt . '</option>';
            }
            $html .= '</select>
                        </td>
                        <td class="pe-4">
                            <input type="text" class="form-control remark-input bg-light border-0 fw-bold text-center small" name="subjects[' . $idx . '][remarks]" value="' . htmlspecialchars($s->G_REMARKS) . '" data-idx="' . $idx . '" readonly>
                        </td>
                    </tr>';
        }
        $html .= '</tbody>
                                </table>
                            </div>
                        </div>

                        <div class="modal-footer bg-light p-3">
                            <button type="button" class="btn btn-light px-4 rounded-pill" data-bs-dismiss="modal">Discard</button>
                            <button type="submit" class="btn btn-emerald px-4 rounded-pill shadow-sm">
                                <i class="ri-save-line me-2"></i> Commit Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>';

        // --- 3. PRINT REPORT MODAL ---
        $html .= '<div class="modal fade" id="' . $print_report_id . '" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg">
                    <div class="modal-header bg-emerald-gradient text-white p-4 no-print">
                        <h5 class="modal-title text-white fw-bold"><i class="ri-printer-fill me-2"></i> Student Grade Report Preview</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4" id="printAreaReport_' . $print_report_id . '" style="background: white; font-family: \'Times New Roman\', Times, serif; color: #000;">
                        <div style="position: relative; padding: 15px 25px;">
                            <!-- Watermark Seal -->
                            ' . ($logo2 ? '<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0.14; z-index: 0; pointer-events: none;"><img src="' . $logo2 . '" style="width: 600px; max-width: 95%;" /></div>' : '') . '

                            <div style="position: relative; z-index: 1;">
                                <!-- Header -->
                                <div style="border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 15px;">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        ' . ($logo1 ? '<img src="' . $logo1 . '" style="width: 85px; height: auto;" />' : '<div style="width:85px;"></div>') . '
                                        <div class="text-center" style="color: #000; line-height: 1.3;">
                                            <div style="font-size: 13px;">Republic of the Philippines</div>
                                            <div style="font-size: 13px;">Bangsamoro Autonomous Region in Muslim Mindanao</div>
                                            <div style="font-size: 13px;">Ministry of Basic, Higher and Technical Education</div>
                                            <div style="font-family: \'Times New Roman\', Times, serif; font-size: 18px; font-weight: bold; text-transform: uppercase; color: #000; margin: 3px 0; letter-spacing: 0.5px;">' . htmlspecialchars($school_nos) . '</div>
                                            <div style="font-size: 11px;">' . htmlspecialchars($school_addr) . '</div>
                                        </div>
                                        ' . ($logo2 ? '<img src="' . $logo2 . '" style="width: 85px; height: auto;" />' : '<div style="width:85px;"></div>') . '
                                    </div>
                                </div>

                                <!-- Document Title -->
                                <div style="text-align: center; margin-top: 15px; margin-bottom: 20px;">
                                    <div style="font-family: Arial, Helvetica, sans-serif; font-size: 18px; font-weight: bold; letter-spacing: 1.5px; display: inline-block; padding: 6px 24px; background: #f1f5f9; border: 1px solid #cbd5e1; border-radius: 4px; color: #0f172a; text-transform: uppercase;">
                                        OFFICIAL GRADE REPORT
                                    </div>
                                </div>

                                <!-- Student Information Grid -->
                                <div style="background: #f8fafc; border: 1px solid #cbd5e1; border-radius: 6px; padding: 12px 18px; margin-bottom: 20px; font-size: 13px; line-height: 1.7; color: #0f172a;">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="d-flex mb-1"><span style="width: 120px; color: #475569; font-weight: 600;">Student Name</span><span style="font-weight: 700;">: ' . strtoupper(htmlspecialchars($fullname)) . '</span></div>
                                            <div class="d-flex mb-1"><span style="width: 120px; color: #475569; font-weight: 600;">Student ID</span><span style="font-weight: 700;">: ' . htmlspecialchars($student_id) . '</span></div>
                                            <div class="d-flex"><span style="width: 120px; color: #475569; font-weight: 600;">Program</span><span style="font-weight: 700;">: ' . $program_str . '</span></div>
                                        </div>
                                        <div class="col-6 border-start ps-4">
                                            <div class="d-flex mb-1"><span style="width: 120px; color: #475569; font-weight: 600;">School Year</span><span style="font-weight: 700;">: ' . $ay_str . '</span></div>
                                            <div class="d-flex mb-1"><span style="width: 120px; color: #475569; font-weight: 600;">Semester</span><span style="font-weight: 700;">: ' . $sem_str . '</span></div>
                                            <div class="d-flex"><span style="width: 120px; color: #475569; font-weight: 600;">Year Level</span><span style="font-weight: 700;">: ' . htmlspecialchars($year_level) . '</span></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Grades Table -->
                                <table class="table table-bordered align-middle mb-3" style="border: 1px solid #000 !important; font-size: 12px; color: #000; font-family: \'Times New Roman\', serif;">
                                    <thead>
                                        <tr style="background-color: #f1f5f9 !important; font-weight: bold; text-align: center;">
                                            <th style="border: 1px solid #000 !important; padding: 6px; width: 48%; text-align: left; font-weight: bold; text-transform: uppercase;">SUBJECT TITLE</th>
                                            <th style="border: 1px solid #000 !important; padding: 6px; width: 10%; text-align: center; font-weight: bold; text-transform: uppercase;">UNITS</th>
                                            <th style="border: 1px solid #000 !important; padding: 6px; width: 14%; text-align: center; font-weight: bold; text-transform: uppercase;">FINAL GRADE</th>
                                            <th style="border: 1px solid #000 !important; padding: 6px; width: 14%; text-align: center; font-weight: bold; text-transform: uppercase;">RE EXAM</th>
                                            <th style="border: 1px solid #000 !important; padding: 6px; width: 14%; text-align: center; font-weight: bold; text-transform: uppercase;">REMARKS</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
        foreach ($subjects as $s) {
            $sq = $this->db->get_where('tbl_subject', ['S_SDESCRIPTION' => $s->G_SUBJECT])->row();
            $u = ($sq) ? $sq->S_UNITS : '-';
            $reexam_val = !empty($s->G_REEXAM) ? $s->G_REEXAM : '-';
            $html .= '<tr>
                        <td class="ps-3 py-1.5" style="border: 1px solid #000 !important; font-weight: 600; text-transform: uppercase;">' . htmlspecialchars($s->G_SUBJECT) . '</td>
                        <td class="text-center py-1.5" style="border: 1px solid #000 !important; font-weight: 600;">' . htmlspecialchars($u) . '</td>
                        <td class="text-center py-1.5" style="border: 1px solid #000 !important; font-weight: 700;">' . htmlspecialchars($s->G_GRADE) . '</td>
                        <td class="text-center py-1.5" style="border: 1px solid #000 !important;">' . htmlspecialchars($reexam_val) . '</td>
                        <td class="text-center py-1.5" style="border: 1px solid #000 !important; font-weight: 600; text-transform: uppercase;">' . htmlspecialchars($s->G_REMARKS) . '</td>
                    </tr>';
        }
        $html .= '</tbody>
                                </table>

                                <!-- GWA Badge -->
                                <div class="d-flex justify-content-end align-items-center mt-3 mb-4">
                                    <div style="border: 2px solid #0f766e; background: #f0fdf4; padding: 8px 20px; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.05);">
                                        <span style="font-size: 13px; font-weight: 700; color: #0f766e; text-transform: uppercase; letter-spacing: 0.5px;">TERM GWA: </span>
                                        <span style="font-size: 16px; font-weight: 800; color: #0f766e; font-family: Arial, sans-serif;">' . $gwa . '</span>
                                    </div>
                                </div>

                                <!-- Signatures Section -->
                                <div style="margin-top: 40px; padding-top: 10px;">
                                    <div class="d-flex justify-content-between align-items-end" style="color: #000; font-size: 13px;">
                                        <div class="text-center" style="min-width: 200px;">
                                            <p style="margin-bottom: 25px; font-style: italic; font-size: 12px; color: #475569;">Prepared by:</p>
                                            <div style="border-bottom: 2px solid #000; font-weight: bold; text-transform: uppercase; padding: 0 15px; display: inline-block; min-width: 180px;">REGISTRAR STAFF</div>
                                            <div style="font-size: 11px; margin-top: 3px; color: #475569;">Office of the Registrar</div>
                                        </div>
                                        <div class="text-center" style="min-width: 220px;">
                                            <p style="margin-bottom: 25px; font-style: italic; font-size: 12px; color: #475569;">Certified Correct:</p>
                                            <div style="border-bottom: 2px solid #000; font-weight: bold; text-transform: uppercase; padding: 0 15px; display: inline-block; min-width: 200px;">' . strtoupper(htmlspecialchars($registrar_name)) . '</div>
                                            <div style="font-size: 11px; margin-top: 3px; color: #475569;">School Registrar</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light no-print">
                        <button type="button" class="btn btn-emerald px-4 rounded-pill shadow-sm" onclick="printDiv(\'printAreaReport_' . $print_report_id . '\')">
                            <i class="ri-printer-line me-2"></i> Print Report
                        </button>
                        <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>';        // --- 4. PRINT CERTIFICATE MODAL ---
        $html .= '<div class="modal fade" id="' . $print_cert_id . '" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-header p-4 no-print">
                        <h5 class="modal-title text-emerald fw-bold"><i class="ri-medal-line me-2"></i> Grade Certificate Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4" id="printAreaCert_' . $print_cert_id . '" style="background: white; font-family: \'Times New Roman\', Times, serif;">
                        <?php
                        $mag_data = file_exists(APPPATH . "views/rgrades/font_magneto.php") ? include(APPPATH . "views/rgrades/font_magneto.php") : "";
                        $mat_data = file_exists(APPPATH . "views/rgrades/font_matura.php") ? include(APPPATH . "views/rgrades/font_matura.php") : "";
                        ?>
                        <style>
                            @font-face {
                                font-family: "MagnetoBold";
                                src: ' . (!empty($mag_data) ? 'url("data:font/ttf;charset=utf-8;base64,' . $mag_data . '") format("truetype"),' : '') . ' url("' . base_url("assets/fonts/MAGNETOB.TTF") . '") format("truetype"), local("Magneto Bold"), local("Magneto");
                            }
                            @font-face {
                                font-family: "MaturaScriptCapitals";
                                src: ' . (!empty($mat_data) ? 'url("data:font/ttf;charset=utf-8;base64,' . $mat_data . '") format("truetype"),' : '') . ' url("' . base_url("assets/fonts/MATURASC.TTF") . '") format("truetype"), local("Matura MT Script Capitals"), local("Matura MT Script");
                            }
                        </style>
                        <div style="position: relative; padding: 10px 20px;">
                            <!-- Watermark Seal -->
                            ' . ($logo2 ? '<div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); opacity: 0.14; z-index: 0; pointer-events: none;"><img src="' . $logo2 . '" style="width: 800px; max-width: 95%;" /></div>' : '') . '

                            <div style="position: relative; z-index: 1;">
                                <!-- Header -->
                                <div style="border-bottom: 2px solid #000; padding-bottom: 8px; margin-bottom: 12px;">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        ' . ($logo1 ? '<img src="' . $logo1 . '" style="width: 85px; height: auto;" />' : '<div style="width:85px;"></div>') . '
                                        <div class="text-center" style="color: #000; font-family: \'Times New Roman\', serif; line-height: 1.3;">
                                            <div style="font-size: 13px;">Republic of the Philippines</div>
                                            <div style="font-size: 13px;">Bangsamoro Autonomous Region in Muslim Mindanao</div>
                                            <div style="font-size: 13px;">Ministry of Basic, Higher and Technical Education</div>
                                            <div style="font-family: \'MagnetoBold\', \'Magneto\', \'Magneto Bold\', cursive, serif; font-size: 24px; font-weight: bold; font-style: italic; color: #316bbb; margin: 2px 0;">' . htmlspecialchars($school_nos) . '</div>
                                            <div style="font-size: 11px;">' . htmlspecialchars($school_addr) . '</div>
                                            <div style="font-size: 11px; font-weight: bold;">Reg. Sec No. CN 200431360 / TIN No. 630-176-362-00000</div>
                                        </div>
                                        ' . ($logo2 ? '<img src="' . $logo2 . '" style="width: 85px; height: auto;" />' : '<div style="width:85px;"></div>') . '
                                    </div>
                                </div>

                                <!-- Office Title -->
                                <div style="text-align: center; margin-top: 15px; margin-bottom: 15px;">
                                    <div style="font-family: \'MaturaScriptCapitals\', \'Matura MT Script Capitals\', \'Matura MT Script\', cursive, serif; font-size: 22px; font-weight: bold; margin-bottom: 12px; color: #000;">Office of the Registrar</div>
                                    <h3 style="font-family: Arial, Helvetica, sans-serif; font-size: 18px; font-weight: bold; letter-spacing: 1px; margin: 0; color: #000;">CERTIFICATE OF GRADES</h3>
                                </div>

                                <!-- To Whom It May Concern -->
                                <div style="margin-top: 25px; margin-bottom: 15px; font-size: 14px; font-weight: bold; color: #000;">
                                    TO WHOM IT MAY CONCERN:
                                </div>

                                <!-- Certification Statement -->
                                <div style="font-size: 14px; line-height: 2.1; text-align: justify; margin-bottom: 18px; color: #000;">
                                    <span style="display: inline-block; text-indent: 40px;">This is to certify that</span>
                                    <span style="border-bottom: 1px solid #000; font-weight: bold; padding: 0 10px; display: inline-block; min-width: 250px; text-align: center; line-height: 1.1;">' . strtoupper(htmlspecialchars($fullname)) . '</span>
                                    <span>with Student Number</span>
                                    <span style="border-bottom: 1px solid #000; font-weight: bold; padding: 0 10px; display: inline-block; min-width: 140px; text-align: center; line-height: 1.1;">' . htmlspecialchars($student_id) . '</span>,
                                    <span>was officially enrolled in the</span>
                                    <span style="border-bottom: 1px solid #000; font-weight: bold; padding: 0 10px; display: inline-block; min-width: 260px; text-align: center; line-height: 1.1;">' . htmlspecialchars($program) . '</span>
                                    <span>during the</span>
                                    <span style="border-bottom: 1px solid #000; font-weight: bold; padding: 0 10px; display: inline-block; min-width: 80px; text-align: center; line-height: 1.1;">' . htmlspecialchars($semester) . '</span>
                                    <span>Semester, A.Y.</span>
                                    <span style="border-bottom: 1px solid #000; font-weight: bold; padding: 0 10px; display: inline-block; min-width: 100px; text-align: center; line-height: 1.1;">' . htmlspecialchars($ay_str) . '</span>
                                    <span>at ' . htmlspecialchars($school_nos) . '.</span>
                                </div>

                                <div style="font-size: 14px; margin-bottom: 12px; color: #000;">
                                    The following are the subjects taken and corresponding grades obtained:
                                </div>

                                <!-- Subjects & Grades Table -->
                                <table class="table table-bordered align-middle mb-3" style="border: 1px solid #000 !important; font-size: 12px; color: #000;">
                                    <thead>
                                        <tr class="text-center" style="background-color: #ffffff !important;">
                                            <th style="border: 1px solid #000 !important; padding: 5px; width: 15%; font-weight: bold;">COURSE NO.</th>
                                            <th style="border: 1px solid #000 !important; padding: 5px; width: 48%; font-weight: bold;">SUBJECT</th>
                                            <th style="border: 1px solid #000 !important; padding: 5px; width: 13%; font-weight: bold;">FINAL GRADE</th>
                                            <th style="border: 1px solid #000 !important; padding: 5px; width: 12%; font-weight: bold;">COMP. GRADE</th>
                                            <th style="border: 1px solid #000 !important; padding: 5px; width: 12%; font-weight: bold;">UNITS</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
        foreach ($subjects as $s) {
            $c = 'N/A';
            $u = 0;
            $sq = $this->db->get_where('tbl_subject', ['S_SDESCRIPTION' => $s->G_SUBJECT])->row();
            if ($sq) {
                $c = $sq->S_SCODE;
                $u = $sq->S_UNITS;
            }
            $reexam_val = !empty($s->G_REEXAM) ? $s->G_REEXAM : '';
            $html .= '<tr>
                        <td class="text-center fw-bold py-1" style="border: 1px solid #000 !important;">' . htmlspecialchars($c) . '</td>
                        <td class="ps-3 py-1" style="border: 1px solid #000 !important;">' . htmlspecialchars($s->G_SUBJECT) . '</td>
                        <td class="text-center fw-bold py-1" style="border: 1px solid #000 !important;">' . htmlspecialchars($s->G_GRADE) . '</td>
                        <td class="text-center py-1" style="border: 1px solid #000 !important;">' . htmlspecialchars($reexam_val) . '</td>
                        <td class="text-center fw-bold py-1" style="border: 1px solid #000 !important;">' . htmlspecialchars($u) . '</td>
                    </tr>';
        }
        $html .= '<tr>
                    <td colspan="5" class="text-center py-1 italic" style="border: 1px solid #000 !important; font-size: 11px;">Nothing Follows</td>
                </tr>
            </tbody>
        </table>

        <!-- Purpose & Date Statement -->
        <div style="font-size: 14px; line-height: 2.0; text-align: justify; margin-bottom: 20px; color: #000;">
            <span>This certificate is issued upon the request of the above-named student in connection with his/her desire to/for</span>
            <span style="border-bottom: 1px solid #000; display: inline-block; min-width: 280px; text-align: center;">any legal purpose(s) it may serve best</span>.
        </div>

        <div style="font-size: 14px; line-height: 2.0; margin-bottom: 35px; color: #000;">
            <span>Issued this</span>
            <span style="border-bottom: 1px solid #000; padding: 0 10px; display: inline-block; min-width: 60px; text-align: center;">' . date('jS') . '</span>
            <span>day of</span>
            <span style="border-bottom: 1px solid #000; padding: 0 15px; display: inline-block; min-width: 140px; text-align: center;">' . date('F, Y') . '</span>
            <span>at ' . htmlspecialchars($school_nos) . ', Masiu Lanao Del Sur.</span>
        </div>

        <!-- Signature Block -->
        <div style="display: flex; justify-content: flex-end; margin-bottom: 25px;">
            <div style="text-align: center; min-width: 220px;">
                <div style="font-weight: bold; text-decoration: underline; font-size: 15px; text-transform: uppercase;">' . strtoupper(htmlspecialchars($registrar_name)) . '</div>
                <div style="font-size: 13px; font-weight: bold;">LCCr Registrar</div>
            </div>
        </div>

        <!-- Seal Notice -->
        <div style="font-style: italic; font-size: 11px; margin-top: 10px; color: #000;">
            Not valid without dry seal
        </div>
    </div>
</div>
                    </div>
                    <div class="modal-footer bg-light no-print">
                        <button type="button" class="btn btn-emerald px-4 rounded-pill shadow-sm" onclick="printDiv(\'printAreaCert_' . $print_cert_id . '\')">
                            <i class="ri-printer-line me-2"></i> Print Certificate
                        </button>
                        <button type="button" class="btn btn-outline-secondary px-4 rounded-pill" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>';

        return $html;
    }

    function LoadStudentEnrolled($studentId = NULL)
    {
        if (empty($studentId)) {
            $studentId = $this->uri->segment(5);
        }

        $sql = "
        SELECT s.*, e.*
        FROM tbl_studprof AS s
        LEFT JOIN tbl_enrollment AS e ON s.SP_STUDID = e.ER_STUDENTID
        WHERE s.SP_STUDID = ? OR e.ER_STUDENTID = ?
        ORDER BY e.ID DESC
        LIMIT 1
    ";

        return $this->db->query($sql, [$studentId, $studentId]);
    }

    public function get_subjects_by_student($student_id, $academic_year, $semester)
    {
        $this->db->select('*');
        $this->db->from('tbl_studentgrades');
        $this->db->where('G_STUDENTID', $student_id);
        $this->db->where('G_ACADEMICYEAR', $academic_year);
        $this->db->where('G_SEMESTER', $semester);
        return $this->db->get()->result();
    }

    public function update_multiple_subjects($subjects_data)
    {
        if (!empty($subjects_data) && is_array($subjects_data)) {
            foreach ($subjects_data as $subject) {
                $id      = $subject['id'];
                $grade   = isset($subject['grade']) ? trim($subject['grade']) : '';
                $reexam  = isset($subject['reexam_grade']) ? trim($subject['reexam_grade']) : null;
                $remarks = isset($subject['remarks']) ? trim($subject['remarks']) : '';

                $update_data = [
                    'G_GRADE'   => $grade,
                    'G_REEXAM'  => !empty($reexam) ? $reexam : null,
                    'G_REMARKS' => $remarks
                ];

                $this->db->where('ID', $id);
                $this->db->update('tbl_studentgrades', $update_data);

                $sg = $this->db->get_where('tbl_studentgrades', ['ID' => $id])->row();
                if ($sg) {
                    $gs_update = [
                        'GS_TRANSMUTED' => $grade,
                        'GS_REMARKS'    => $remarks
                    ];
                    $this->db->where('GS_STUDENTID', $sg->G_STUDENTID)
                        ->where('GS_SUBJECT', $sg->G_SUBJECT)
                        ->where('GS_ACADEMICYEAR', $sg->G_ACADEMICYEAR)
                        ->where('GS_SEMESTER', $sg->G_SEMESTER)
                        ->update('tbl_gradingsystem', $gs_update);
                }
            }
        }
        return true;
    }

    public function sync_gradingsystem_to_studentgrades()
    {
        if (!$this->db->table_exists('tbl_gradingsystem')) return;

        $gs_records = $this->db->get('tbl_gradingsystem')->result();
        foreach ($gs_records as $gs) {
            if (empty($gs->GS_STUDENTID) || empty($gs->GS_SUBJECT)) continue;

            $existing = $this->db
                ->where('G_STUDENTID', $gs->GS_STUDENTID)
                ->where('G_SUBJECT', $gs->GS_SUBJECT)
                ->where('G_ACADEMICYEAR', $gs->GS_ACADEMICYEAR)
                ->where('G_SEMESTER', $gs->GS_SEMESTER)
                ->get('tbl_studentgrades')
                ->row();

            $transmuted_val = !empty($gs->GS_TRANSMUTED) ? $gs->GS_TRANSMUTED : '';
            $raw_remarks    = !empty($gs->GS_REMARKS) ? $gs->GS_REMARKS : '';
            $norm_remarks   = ($transmuted_val == '5.0' || $transmuted_val == '5.00' || $raw_remarks == 'Failure') ? 'FAILED' : (($transmuted_val == 'INC' || $raw_remarks == 'INC') ? 'INCOMPLETE' : (($transmuted_val == 'DRP' || $raw_remarks == 'DROPPED') ? 'DROPPED' : 'PASSED'));

            $data = [
                'G_UID'            => !empty($gs->GS_UID) ? $gs->GS_UID : '',
                'G_STUDENTID'      => $gs->GS_STUDENTID,
                'G_FULLNAME'       => $gs->GS_FULLNAME,
                'G_GRADE'          => $transmuted_val,
                'G_REMARKS'        => $norm_remarks,
                'G_SCHEDID'        => $gs->GS_SCHEDID,
                'G_CLASSCODE'      => $gs->GS_CLASSCODE,
                'G_ACADEMICYEAR'   => $gs->GS_ACADEMICYEAR,
                'G_SEMESTER'       => $gs->GS_SEMESTER,
                'G_SUBJECT'        => $gs->GS_SUBJECT,
                'G_YEARLEVEL'      => $gs->GS_YEARLEVEL,
                'G_SECTION'        => $gs->GS_SECTION,
                'G_STATUS'         => $gs->GS_STATUS,
                'G_ENCODERTEACHER' => !empty($gs->GS_FACULTY) ? $gs->GS_FACULTY : '',
                'G_DATESUBMITTED'  => date('Y-m-d H:i:s')
            ];

            if ($existing) {
                if (empty($existing->G_GRADE) && !empty($transmuted_val)) {
                    $this->db->where('ID', $existing->ID)->update('tbl_studentgrades', $data);
                }
            } else {
                $this->db->insert('tbl_studentgrades', $data);
            }
        }
    }

    public function get_grade_group($group_id)
    {
        $this->db->where('ID', $group_id);
        return $this->db->get('tbl_studentgrades')->row();
    }
}
