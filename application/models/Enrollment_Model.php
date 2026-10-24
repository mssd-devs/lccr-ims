<?php
class Enrollment_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }


    function LoadStudentEnrolled()
    {
        $sql = "SELECT
        s.SP_LASTNAME,
        s.SP_MIDDLENAME,
        s.SP_FIRSTNAME,
        s.SP_GENDER,
        s.SP_CPNUMBER,
        s.SP_CIVILSTATUS,
        s.SP_BIRTHDAY,
        s.SP_STRT,
        s.SP_CURRICULUM,
        r.regDesc,
        p.provDesc,
        c.citymunDesc,
        b.brgyDesc,
        pm.P_PCODE,
        e.*
    FROM
        tbl_enrollment AS e
    LEFT JOIN
        tbl_studprof AS s ON e.ER_STUDENTID = s.SP_STUDID
    LEFT JOIN
        refregion AS r ON s.SP_REGION = r.regCode
    LEFT JOIN
        refprovince AS p ON s.SP_PROVINCE = p.provCode
    LEFT JOIN
        refcitymun AS c ON s.SP_MUNICIPALITY = c.citymunCode
    LEFT JOIN
        refbrgy AS b ON s.SP_BRGY = b.brgyCode
    LEFT JOIN 
        tbl_program as pm ON e.ER_PROGRAM = pm.P_PDESCRIPTIONS AND e.ER_MAJOR = pm.P_MAJOR
        
        
    WHERE e.ER_STUDENTID !='' AND e.ID = {$this->uri->segment(4)}";
        $query = $this->db->query($sql);
        return $query;
    }


    function DeleteEnrollment()
    {
        $result = "";
        $id = $this->input->post("id");
        $ER_TRANSNO = $this->db->where("ID", $id)->get("tbl_enrollment")->row("ER_TRANSNO");
        if ($ER_TRANSNO) {
            $this->db->where("ID", $id)->delete("tbl_enrollment");
            $this->db->where("ER_TRANSNO", $ER_TRANSNO)->delete("tbl_payment");
            $this->db->where("ER_TRANSNO", $ER_TRANSNO)->delete("tbl_payment_discount");
            $result = "success";
        } else {
            $result = "error";
        }
        return $result;
    }



    function SearchStudentID()
    {
        $result = "";
        $ER_STUDENTID = $this->input->post("ER_STUDENTID");
        $query = $this->db->where("SP_STUDID", $ER_STUDENTID)->get("tbl_studprof");
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $r) {
                $result = $r->SP_LASTNAME . (!empty($r->SP_SUFFIX) ? ' ' . $r->SP_SUFFIX : '') . ', ' . $r->SP_FIRSTNAME . ' ' . $r->SP_MIDDLENAME;
            }
        } else {
            $result = 0;
        }
        return $result;
    }

    function GetLastEnrollment()
    {
        $studentID = $this->input->post("studentID");
        $this->db->select("ER_PROGRAM, ER_MAJOR, ER_YEARLEVEL");
        $this->db->where("ER_STUDENTID", $studentID);
        $this->db->order_by("ID", "DESC");
        $this->db->limit(1);
        $query = $this->db->get("tbl_enrollment");
        return $query->row();
    }

    function LoadProgramMajor()
    {
        $query = $this->db->where("P_PDESCRIPTIONS", $this->input->post("ER_PROGRAM"))->get("tbl_program");
        $result = '<option value="">--SELECT--</option>';
        foreach ($query->result() as $r) {
            $result .= '<option>' . $r->P_MAJOR . '</option>';
        }
        return $result;
    }

    function LoadSemester()
    {
        $this->db->where("P_PDESCRIPTIONS", $this->input->post("PROGRAM"));
        $getSem = $this->db->get("tbl_program")->row("P_SEMTYPE");
        $query = $this->db->where("SEM_TYPE", $getSem)
            ->order_by("SEM_NAME", "ASC")
            ->get("tbl_semestertype");
        $result = '<option value="">--SELECT--</option>';
        foreach ($query->result() as $r) {
            $result .= '<option>' . $r->SEM_NAME . '</option>';
        }
        return $result;
    }

    function LoadSection()
    {
        $query = $this->db
            ->where("SEC_SPROG", $this->input->post("ER_PROGRAM"))
            ->where("SEC_SYRLVL", $this->input->post("ER_YEARLEVEL"))
            ->where("SEC_SSEM", $this->input->post("ER_SEMESTER"))
            ->get("tbl_section");
        $result = '<option value="">--SELECT--</option>';
        foreach ($query->result() as $r) {
            $result .= '<option>' . $r->SEC_SDESC . '</option>';
        }
        return $result;
    }

    function CheckSectionCapacity()
    {
        $program = $this->input->post("ER_PROGRAM");
        $yearlevel = $this->input->post("ER_YEARLEVEL");
        $semester = $this->input->post("ER_SEMESTER");
        $section = $this->input->post("ER_SECTION");
        $academicyear = $this->input->post("ER_ACADEMICYEAR");
        $id = $this->input->post("ID");

        // Query tbl_section to find SEC_NOCAP
        $this->db->where("SEC_SPROG", $program);
        $this->db->where("SEC_SYRLVL", $yearlevel);
        $this->db->where("SEC_SSEM", $semester);
        $this->db->where("SEC_SDESC", $section);
        $sec_query = $this->db->get("tbl_section");

        if ($sec_query->num_rows() > 0) {
            $sec_row = $sec_query->row();
            $capacity = (int)$sec_row->SEC_NOCAP;

            if ($capacity > 0) {
                // Count current enrollments in this section
                $this->db->where("ER_PROGRAM", $program);
                $this->db->where("ER_YEARLEVEL", $yearlevel);
                $this->db->where("ER_SEMESTER", $semester);
                $this->db->where("ER_SECTION", $section);
                $this->db->where("ER_ACADEMICYEAR", $academicyear);
                if (!empty($id)) {
                    $this->db->where("ID !=", $id);
                }
                $current_count = $this->db->count_all_results("tbl_enrollment");

                if ($current_count >= $capacity) {
                    return [
                        "status" => "full",
                        "capacity" => $capacity,
                        "enrolled" => $current_count
                    ];
                }
            }
        }
        return ["status" => "available"];
    }


    function LoadOthersFee()
    {

        $ID = $this->uri->segment(4);
        $enrollment = $this->db->select('ER_PROGRAM, ER_MAJOR')
            ->where('ID', $ID)
            ->get('tbl_enrollment')
            ->row();

        $program = $enrollment->ER_PROGRAM;
        $major = $enrollment->ER_MAJOR;

        $feeKey = $this->db->select('FEES_KEY')
            ->where('FEES_PROGRAM', $program)
            ->where('FEES_MAJOR', $major)
            ->get('tbl_fees_tuitions')
            ->row('FEES_KEY');


        $query = $this->db->where('FEES_TUITION_ID', $feeKey)
            ->get('tbl_fees_otherfees');

        return $query;
    }

    function LoadMiscFee()
    {

        $ID = $this->uri->segment(4);
        $enrollment = $this->db->select('ER_PROGRAM, ER_MAJOR')
            ->where('ID', $ID)
            ->get('tbl_enrollment')
            ->row();

        $program = $enrollment->ER_PROGRAM;
        $major = $enrollment->ER_MAJOR;

        $feeKey = $this->db->select('FEES_KEY')
            ->where('FEES_PROGRAM', $program)
            ->where('FEES_MAJOR', $major)
            ->get('tbl_fees_tuitions')
            ->row('FEES_KEY');


        $query = $this->db->where('FEES_TUITION_ID', $feeKey)
            ->get('tbl_fees_miscellaneous');

        return $query;
    }

    function LoadModalSubjects()
    {
        $query = $this->db->query(
            "SELECT 
                sc.SC_TEACHMODELS,
                sc.SC_STARTTIME,
                sc.SC_ENDTIME,
                sc.SC_DAY,
                sc.SC_SECTION,
                sc.SC_ROOM,
                sc.SC_FACULTY,
                s.ID,
                s.S_UNITS,
                s.S_PREREQ,
                s.S_SCODE,
                s.S_SDESCRIPTION,
                s.S_YRLVL,
                s.S_SEM
            FROM 
                tbl_subject AS s
            LEFT JOIN 
                tbl_scheduling  AS sc
                ON s.S_SELECTPROG = sc.SC_PROG
                AND s.S_MAJOR = sc.SC_MAJOR
                AND s.S_YRLVL = sc.SC_YEARLEVEL
                AND s.S_SEM = sc.SC_SEMESTER
                AND s.S_SDESCRIPTION = sc.SC_SDESC"
        );
        return $query;
    }

    function LoadEditSubjects()
    {
        $enrollmentId = $this->uri->segment(4);

        // Fetch the subjects associated with the enrollment ID
        $enrollmentRecord = $this->db->select('ER_SUBJECTS')
            ->where('ID', $enrollmentId)
            ->get('tbl_enrollment')
            ->row();

        if (!$enrollmentRecord) {
            return false; // Return or handle cases where the enrollment record is not found
        }

        $subjectIds = explode(',', $enrollmentRecord->ER_SUBJECTS);

        // Prepare query with bindings to prevent SQL injection
        $this->db->select('
                sc.SC_TEACHMODELS,
                sc.SC_STARTTIME,
                sc.SC_ENDTIME,
                sc.SC_DAY,
                sc.SC_SECTION,
                sc.SC_ROOM,
                sc.SC_FACULTY,
                s.ID,
                s.S_UNITS,
                s.S_PREREQ,
                s.S_SCODE,
                s.S_SDESCRIPTION,
                s.S_YRLVL,
                s.S_SEM
            ')
            ->from('tbl_subject AS s')
            ->join(
                'tbl_scheduling AS sc',
                's.S_SELECTPROG = sc.SC_PROG
                AND s.S_MAJOR = sc.SC_MAJOR
                AND s.S_YRLVL = sc.SC_YEARLEVEL
                AND s.S_SEM = sc.SC_SEMESTER
                AND s.S_SDESCRIPTION = sc.SC_SDESC',
                'left'
            )
            ->where_in('s.ID', $subjectIds);

        $query = $this->db->get();
        return $query;
    }


    function LoadSubjects()
    {
        $ER_PROGRAM = $this->input->post("ER_PROGRAM");
        $ER_MAJOR = $this->input->post("ER_MAJOR");
        $ER_YEARLEVEL = $this->input->post("ER_YEARLEVEL");
        $ER_SEMESTER = $this->input->post("ER_SEMESTER");
        $ER_SECTION = $this->input->post("ER_SECTION");

        // Initialize the result string and the counter
        $result = "";
        $num = 0;

        $query = $this->db->query(
            "SELECT 
                sc.SC_TEACHMODELS,
                sc.SC_STARTTIME,
                sc.SC_ENDTIME,
                sc.SC_DAY,
                sc.SC_SECTION,
                sc.SC_ROOM,
                sc.SC_FACULTY,
                s.ID,
                s.S_UNITS,
                s.S_PREREQ,
                s.S_SCODE,
                s.S_SDESCRIPTION
            FROM 
                tbl_scheduling AS sc
            INNER JOIN 
                tbl_subject AS s 
                ON s.S_SELECTPROG = sc.SC_PROG
                AND s.S_MAJOR = sc.SC_MAJOR
                AND s.S_YRLVL = sc.SC_YEARLEVEL
                AND s.S_SEM = sc.SC_SEMESTER
                AND s.S_SDESCRIPTION = sc.SC_SDESC
            WHERE
                sc.SC_PROG = ? 
                AND sc.SC_MAJOR = ? 
                AND sc.SC_YEARLEVEL = ? 
                AND sc.SC_SEMESTER = ? 
                AND sc.SC_SECTION = ?",
            array($ER_PROGRAM, $ER_MAJOR, $ER_YEARLEVEL, $ER_SEMESTER, $ER_SECTION)
        );



        // Check if the query returned results
        if ($query->num_rows() > 0) {
            // Loop through the query results and build table rows
            foreach ($query->result() as $r) {
                $num++;
                $result .= '<tr>';
                $result .= '<td>' . $num . '</td>';
                $result .= '<td><input type="hidden" name="ER_SUBJECTS[]" id="E_SID" value="' . htmlspecialchars($r->ID) . '">' . htmlspecialchars($r->S_SCODE) . '</td>';
                $result .= '<td>' . $r->S_SDESCRIPTION . '</td>';
                $result .= '<td>' . htmlspecialchars($r->SC_TEACHMODELS) . '</td>';
                $startTime = !empty($r->SC_STARTTIME) ? date("h:i A", strtotime($r->SC_STARTTIME)) : '';
                $endTime = !empty($r->SC_ENDTIME) ? date("h:i A", strtotime($r->SC_ENDTIME)) : '';
                $result .= '<td>' . $startTime . ($startTime && $endTime ? '-' : '') . $endTime . '</td>';
                $result .= '<td>' . htmlspecialchars($r->SC_DAY) . '</td>';
                $result .= '<td>' . htmlspecialchars($r->SC_ROOM) . '</td>';
                $result .= '<td>' . htmlspecialchars($r->SC_SECTION) . '</td>';
                $result .= '<td>' . htmlspecialchars($r->S_UNITS) . '</td>';
                $result .= '<td>' . htmlspecialchars($r->SC_FACULTY) . '</td>';
                $result .= '<td>' . htmlspecialchars($r->S_PREREQ) . '</td>';
                $result .= '<td class="sticky-col"><button type="button" class="btn btn-danger deleteSubject"><i class="ri-delete-bin-line"></i></button></td>';
                $result .= '</tr>';
            }
        } else {
            // Optionally handle the case where no subjects were found
            $result .= '<tr><td colspan="11" class="text-center">No subjects found.</td></tr>';
        }

        return $result;
    }




    function generate_transaction_no()
    {
        do {
            $date = date('YmdHis'); // Current date and time
            $randomNumber = rand(1000, 9999); // Generate a random 4-digit number
            $letters = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 3); // Generate 3 random letters
            $transactionNo = $date . $letters . $randomNumber; // Concatenate date, letters, and random number

            // Check if the generated transaction number already exists in the database
            $exists = $this->db->where('ER_TRANSNO', $transactionNo)->count_all_results('tbl_enrollment') > 0;
        } while ($exists); // Repeat if the transaction number already exists

        return $transactionNo;
    }



    // GENERATE STUDENT ID format YYYY-XXXXXX (6 digits), continuous increment, does not reset every year
    function generate_student_id()
    {
        $year = date('Y');
        $lastId = $this->db->select('SP_STUDID')
            ->order_by('SP_STUDID', 'DESC')
            ->limit(1)
            ->get('tbl_studprof')
            ->row('SP_STUDID');

        if ($lastId && preg_match('/^\d{4}-(\d{6})$/', $lastId, $matches)) {
            $number = (int)$matches[1] + 1;
        } else {
            $number = 1;
        }

        return sprintf('%s-%06d', $year, $number); // Format as YYYY-XXXXXX
    }

    function get_account_payable($student_id, $transno)
    {
        $total_account_payable = 0;

        // Get all enrollments for this student excluding the current transaction and which are not PAID
        $this->db->where("ER_STUDENTID", $student_id);
        $this->db->where("ER_TRANSNO !=", $transno);
        $this->db->where_in("ER_PAYMENTSTATUS", ["UNPAID", "INSTALLMENT"]);
        $get_enrollments = $this->db->get("tbl_enrollment");

        foreach ($get_enrollments->result() as $enrollment) {
            $FEES_AMOUNTPERUNIT = 0;
            $ER_TRANSNO = $enrollment->ER_TRANSNO;

            // Compute Tuition Fee based on subjects
            if (!empty($enrollment->ER_SUBJECTS)) {
                $subject_ids = array_map('intval', explode(',', $enrollment->ER_SUBJECTS));
                $subject_ids_str = implode(',', $subject_ids);

                $get_subjects = $this->db->query("SELECT * FROM tbl_subject WHERE ID IN($subject_ids_str)");
                foreach ($get_subjects->result() as $s) {
                    $get_fees = $this->db->query(
                        "SELECT FEES_AMOUNTPERUNIT FROM tbl_fees_tuitions WHERE FEES_PROGRAM = ? AND FEES_MAJOR = ? AND FEES_YEARLEVEL = ? AND FEES_SEMESTER = ? LIMIT 1",
                        [$s->S_SELECTPROG, $s->S_MAJOR, $s->S_YRLVL, $s->S_SEM]
                    );
                    if ($get_fees->num_rows() > 0) {
                        $fee = $get_fees->row();
                        $unit_rate = floatval(str_replace(',', '', $fee->FEES_AMOUNTPERUNIT));
                        $FEES_AMOUNTPERUNIT += $unit_rate * floatval($s->S_UNITS);
                    }
                }
            }

            // Get total fees and payments for this specific enrollment
            $query = $this->db->query("SELECT 
                f.FEES_TOTALTUITION AS totalTuition,
                (SELECT COALESCE(SUM(REPLACE(mf.FEES_MISC_AMOUNT, ',', '')), 0) 
                 FROM tbl_fees_miscellaneous mf 
                 WHERE mf.FEES_TUITION_ID = f.FEES_KEY) AS totalMisc,
                (SELECT COALESCE(SUM(REPLACE(otf.FEES_OTHER_AMOUNT, ',', '')), 0) 
                 FROM tbl_fees_otherfees otf 
                 WHERE otf.FEES_TUITION_ID = f.FEES_KEY) AS totalOther,
                (SELECT COALESCE(SUM(REPLACE(p.P_AMOUNT, ',', '')), 0) 
                 FROM tbl_payment p 
                 WHERE p.ER_TRANSNO = e.ER_TRANSNO) AS totalPayment,
                (SELECT COALESCE(SUM(REPLACE(d.D_AMOUNT, ',', '')), 0) 
                 FROM tbl_payment_discount d 
                 WHERE d.ER_TRANSNO = e.ER_TRANSNO) AS totalDiscount
            FROM tbl_enrollment e
            LEFT JOIN tbl_fees_tuitions f 
                ON e.ER_PROGRAM = f.FEES_PROGRAM 
                AND e.ER_MAJOR = f.FEES_MAJOR 
                AND e.ER_YEARLEVEL = f.FEES_YEARLEVEL 
                AND e.ER_SEMESTER = f.FEES_SEMESTER
            WHERE e.ER_TRANSNO = ?
            LIMIT 1", [$ER_TRANSNO])->row();

            $total_tuition = $FEES_AMOUNTPERUNIT;
            $total_miscellaneous = isset($query->totalMisc) ? floatval($query->totalMisc) : 0;
            $total_other_fee = isset($query->totalOther) ? floatval($query->totalOther) : 0;
            $total_payment = isset($query->totalPayment) ? floatval($query->totalPayment) : 0;
            $total_discount = isset($query->totalDiscount) ? floatval($query->totalDiscount) : 0;

            $partial_enrollment_fee = $this->db->get("tbl_websettings")->row("IMS_WEB_ENROLLMENT_FEE") ?? 0;

            $overall_total = $total_tuition + $total_miscellaneous + $total_other_fee + floatval(str_replace(',', '', $partial_enrollment_fee));
            $total_paid = $total_payment + $total_discount;
            $balance = $overall_total - $total_paid;

            if ($balance > 0) {
                $total_account_payable += $balance;
            }
        }

        return $total_account_payable;
    }


    function saveUpdate()
    {
        date_default_timezone_set("Asia/Manila");
        $result = "";
        $id = null;
        // Get and process input data
        $ER_SUBJECTS = $this->input->post('ER_SUBJECTS') ? implode(', ', $this->input->post('ER_SUBJECTS')) : '';
        $data = [
            "ER_PROGRAM" => $this->input->post("ER_PROGRAM"),
            "ER_MAJOR" => $this->input->post("ER_MAJOR"),
            "ER_YEARLEVEL" => $this->input->post("ER_YEARLEVEL"),
            "ER_SEMESTER" => $this->input->post("ER_SEMESTER"),
            "ER_SECTION" => $this->input->post("ER_SECTION"),
            "ER_STATUS" => $this->input->post("ER_STATUS"),
            "ER_ACADEMICYEAR" => $this->input->post("ER_ACADEMICYEAR"),
            "ER_UNITS" => $this->input->post("ER_UNITS"),
            "ER_CLASSIFICATION" => $this->input->post("ER_CLASSIFICATION"),
            "ER_SUBJECTS" => $ER_SUBJECTS,
            "ER_DATESUBMITTED" => date('Y-m-d H:i:s'),
            "ER_ENCODER" => $this->session->userdata("fullname") ?? ""
        ];
        if (empty($this->input->post("ID"))) {
            $ER_TRANSNO = $this->generate_transaction_no();
            $data["ER_ENSTATUS"] = "PENDING";
            $data["ER_PAYMENTSTATUS"] = "UNPAID";
            $data["ER_TRANSNO"] = $ER_TRANSNO;
            $data["ER_STUDENTID"] = $this->input->post("ER_STUDENTID");


            $this->db->insert("tbl_enrollment", $data);
            if ($this->db->affected_rows() > 0) {
                $result = "save";
                $id = $this->db->insert_id();

                //trigger account_payable calculation for the student
                $ap_amount = $this->get_account_payable($this->input->post("ER_STUDENTID"), $ER_TRANSNO);

                $ap_data = [
                    'AP_AMOUNT' => $ap_amount,
                    'ER_STUDENTID' => $this->input->post("ER_STUDENTID"),
                    'ER_UID' => $id
                ];
                //delete existing AP record for the enrollment if exists to avoid duplicates
                $this->db->where("ER_STUDENTID", $this->input->post("ER_STUDENTID"))->delete("tbl_enrollment_ap");
                $this->db->insert("tbl_enrollment_ap", $ap_data);

                // First enrollment for this student: issue student-portal login
                // credentials (student ID + generated password) and email them.
                // No-op if this student already has credentials on file.
                $this->load->helper('student_portal');
                issue_student_portal_credentials($this->input->post("ER_STUDENTID"));
            } else {
                $result = "error";
            }
        } else {
            // update
            if ($this->db->where("ID", $this->input->post("ID"))->update("tbl_enrollment", $data)) {
                $result = "update";

                //trigger account_payable calculation for the student
                $ap_amount = $this->get_account_payable($this->input->post("ER_STUDENTID"), $this->input->post("ER_TRANSNO"));
                $ap_data = [
                    'AP_AMOUNT' => $ap_amount,
                ];
                $this->db->where("ER_UID", $this->input->post("ID"))->update("tbl_enrollment_ap", $ap_data);

                $id = $this->input->post("ID");
            } else {
                $result = "error";
            }
        }

        $data = [
            "result" => $result,
            "id" => $id
        ];

        return $data;
    }


    function check_permission()
    {
        if ($this->session->userdata("usertype") === "Superadmin") {
            return ['View', 'Edit', 'Delete', 'Create'];
        }

        $permission = [];
        $query = $this->db->where([
            "USER_ID" => $this->session->userdata("id"),
            "PAGE" => "Enrollment"
        ])->get("tbl_permissions");

        foreach ($query->result() as $row) {
            $actions = array_map('trim', explode(',', $row->ACTIONS));
            $permission = array_merge($permission, $actions);
        }

        return array_unique($permission); // avoid duplicate actions
    }



    function LoadEnrollment()
    {
        $permissions = $this->check_permission();
        $is_admin = $this->session->userdata("usertype") === "Superadmin";

        $filters = [
            'ER_PROGRAM' => $this->input->post("FILTER_PROGRAM"),
            'ER_MAJOR' => $this->input->post("FILTER_MAJOR"),
            'ER_YEARLEVEL' => $this->input->post("FILTER_YL"),
            'ER_ACADEMICYEAR' => $this->input->post("FILTER_AY"),
            'ER_SEMESTER' => $this->input->post("FILTER_SEM")
        ];

        $sql = "SELECT
                s.SP_STUDID,
                s.SP_LASTNAME,
                s.SP_MIDDLENAME,
                s.SP_FIRSTNAME,
                s.SP_GENDER,
                s.SP_CPNUMBER,
                e.*
            FROM tbl_enrollment AS e
            LEFT JOIN tbl_studprof AS s ON e.ER_STUDENTID = s.SP_STUDID
            WHERE e.ER_STUDENTID != ''";

        foreach ($filters as $col => $val) {
            if (!empty($val)) $sql .= " AND e.$col = " . $this->db->escape($val);
        }

        $sql .= " ORDER BY CASE 
                    WHEN e.ER_PAYMENTSTATUS = 'UNPAID' THEN 1 
                    WHEN e.ER_PAYMENTSTATUS = 'INSTALLMENT' THEN 2 
                    ELSE 3 
                END, e.ID DESC";

        $query = $this->db->query($sql);
        $result = '';


        foreach ($query->result() as $r) {
            $major = $r->ER_MAJOR ? "<small><b>({$r->ER_MAJOR})</b></small>" : '';
            $status_badge = "<span class='badge rounded-pill bg-" .
                ($r->ER_ENSTATUS === "ACTIVE" ? "success" : "warning") . "'>" .
                htmlspecialchars($r->ER_ENSTATUS) . "</span>";

            // Build dropdown actions
            $actions = [];

            if ($is_admin || in_array("Edit", $permissions)) {
                $actions[] = '<a class="dropdown-item" href="' . base_url("ims/enrollment/edit/$r->ID") . '"><i class="ri-edit-line me-1"></i> Edit</a>';
            }

            if ($is_admin || in_array("View", $permissions)) {
                $actions[] = '<a class="dropdown-item" href="' . base_url("ims/enrollment/view/$r->ID") . '"><i class="ri-eye-line me-1"></i> View</a>';
            }

            // Print is allowed to everyone
            $actions[] = '<button class="dropdown-item btnPrint" data-id="' . $r->ID . '" data-trno="' . $r->ER_TRANSNO . '"><i class="ri-printer-line me-1"></i> Print</button>';
            $actions[] = '<button class="dropdown-item btnPrintCert" data-id="' . $r->ID . '" data-trno="' . $r->ER_TRANSNO . '"><i class="ri-printer-line me-1"></i> Print COE</button>';
            $actions[] = '<button class="dropdown-item btnPrintCOR" data-id="' . $r->ID . '" data-trno="' . $r->ER_TRANSNO . '"><i class="ri-printer-line me-1"></i> Print COR</button>';
            $actions[] = '<button class="dropdown-item btnPrintHD" data-id="' . $r->ID . '" data-trno="' . $r->ER_TRANSNO . '"><i class="ri-printer-line me-1"></i> Print Honorable Dismissal</button>';

            if ($is_admin || in_array("Delete", $permissions)) {
                $actions[] = '<a class="dropdown-item" href="javascript:void(0);" id="btnDelete" data-id="' . $r->ID . '"><i class="ri-delete-bin-line me-1"></i> Delete</a>';
            }

            $dropdown = '
            <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="ri-more-2-fill"></i>
                </button>
                <div class="dropdown-menu">' . implode('', $actions) . '</div>
            </div>';

            $payment_status_badge = '<span class="badge rounded-pill bg-';
            switch ($r->ER_PAYMENTSTATUS) {
                case 'UNPAID':
                    $payment_status_badge .= 'danger';
                    break;
                case 'INSTALLMENT':
                    $payment_status_badge .= 'warning';
                    break;
                case 'PAID':
                    $payment_status_badge .= 'success';
                    break;
                default:
                    $payment_status_badge .= 'secondary';
            }
            $payment_status_badge .= '">' . htmlspecialchars($r->ER_PAYMENTSTATUS) . '</span>';

            $result .= "
        <tr>
            <td class='d-none'>{$r->ID}</td>
            <td>{$r->SP_STUDID}</td>
            <td>{$r->SP_LASTNAME}, {$r->SP_FIRSTNAME} {$r->SP_MIDDLENAME}</td>
            <td>{$r->SP_CPNUMBER}</td>
            <td>{$r->SP_GENDER}</td>
            <td>{$r->ER_PROGRAM} {$major}</td>
            <td>{$r->ER_YEARLEVEL}</td>
            <td>{$r->ER_SEMESTER}</td>
            <td>{$status_badge}</td>
            <td>{$payment_status_badge}</td>
            <td>{$r->ER_STATUS}</td>
            <td>{$dropdown}</td>
        </tr>";
        }

        return $result;
    }
}
