<?php
#[AllowDynamicProperties]
class Dashboard_Model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    public function validate_data($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function LoadPrograms()
    {
        $query = $this->db->query("SELECT DISTINCT P_PDESCRIPTIONS FROM tbl_program");
        return $query;
    }

    public function program_with_enrollment($FTR_AY = null, $FTR_YL = null, $FTR_SEM = null, $FTR_PROGRAM = null)
    {
        $params = [];

        $sql = "SELECT 
            p.P_PDESCRIPTIONS AS ER_PROGRAM,
            e.ER_ACADEMICYEAR,
            COUNT(DISTINCT(e.ER_STUDENTID)) AS total_enrolled,
            SUM(CASE WHEN sp.SP_GENDER = 'MALE' THEN 1 ELSE 0 END) AS total_male,
            SUM(CASE WHEN sp.SP_GENDER = 'FEMALE' THEN 1 ELSE 0 END) AS total_female
        FROM tbl_enrollment e
        LEFT JOIN tbl_studprof sp ON sp.SP_STUDID = e.ER_STUDENTID
        LEFT JOIN tbl_program p ON p.P_PDESCRIPTIONS = e.ER_PROGRAM
        WHERE 1=1";

        if (!empty($FTR_YL)) {
            $sql .= " AND e.ER_YEARLEVEL = ?";
            $params[] = $FTR_YL;
        }
        if (!empty($FTR_SEM)) {
            $sql .= " AND e.ER_SEMESTER = ?";
            $params[] = $FTR_SEM;
        }
        if (!empty($FTR_PROGRAM)) {
            $sql .= " AND e.ER_PROGRAM = ?";
            $params[] = $FTR_PROGRAM;
        }
        if (!empty($FTR_AY)) {
            $sql .= " AND e.ER_ACADEMICYEAR = ?";
            $params[] = substr($FTR_AY, 0, 4);
        }

        $sql .= " GROUP BY p.P_PDESCRIPTIONS, e.ER_ACADEMICYEAR ORDER BY p.P_PDESCRIPTIONS ASC";

        return $this->db->query($sql, $params)->result();
    }

    function FilterDashboardHeader()
    {
        $FTR_AY = $this->input->post("FTR_AY");
        $FTR_SEM = $this->input->post("FTR_SEM");
        $FTR_PROGRAM = $this->input->post("FTR_PROGRAM");
        $FTR_YL = $this->input->post("FTR_YL");


        // ----------- TOTAL ENROLLED MALE STUDENTS ----------
        $sql_enrolledmale = "SELECT COUNT(*) AS total_enrolled_male
                     FROM tbl_enrollment e
                     LEFT JOIN tbl_studprof AS s ON e.ER_STUDENTID = s.SP_STUDID 
                     WHERE s.SP_GENDER = 'MALE'";
        $params_enrolled_male = [];
        if (!empty($FTR_YL)) {
            $sql_enrolledmale .= " AND e.ER_YEARLEVEL = ?";
            $params_enrolled_male[] = $FTR_YL;
        }
        if (!empty($FTR_SEM)) {
            $sql_enrolledmale .= " AND e.ER_SEMESTER = ?";
            $params_enrolled_male[] = $FTR_SEM;
        }
        if (!empty($FTR_PROGRAM)) {
            $sql_enrolledmale .= " AND e.ER_PROGRAM = ?";
            $params_enrolled_male[] = $FTR_PROGRAM;
        }
        if (!empty($FTR_AY)) {
            $sql_enrolledmale .= " AND e.ER_ACADEMICYEAR = ?";
            $params_enrolled_male[] = substr($FTR_AY, 0, 4); // Only starting year
        }
        $total_enrolled_male = $this->db
            ->query($sql_enrolledmale, $params_enrolled_male)
            ->row("total_enrolled_male") ?? "0";



        // ----------- TOTAL ENROLLED FEMALE STUDENTS ----------
        $sql_enrolledfemale = "SELECT COUNT(*) AS total_enrolled_female
                     FROM tbl_enrollment e
                     LEFT JOIN tbl_studprof AS s ON e.ER_STUDENTID = s.SP_STUDID 
                     WHERE s.SP_GENDER = 'FEMALE'";
        $params_enrolled_female = [];
        if (!empty($FTR_YL)) {
            $sql_enrolledfemale .= " AND e.ER_YEARLEVEL = ?";
            $params_enrolled_female[] = $FTR_YL;
        }
        if (!empty($FTR_SEM)) {
            $sql_enrolledfemale .= " AND e.ER_SEMESTER = ?";
            $params_enrolled_female[] = $FTR_SEM;
        }
        if (!empty($FTR_PROGRAM)) {
            $sql_enrolledfemale .= " AND e.ER_PROGRAM = ?";
            $params_enrolled_female[] = $FTR_PROGRAM;
        }
        if (!empty($FTR_AY)) {
            $sql_enrolledfemale .= " AND e.ER_ACADEMICYEAR = ?";
            $params_enrolled_female[] = substr($FTR_AY, 0, 4); // Only starting year
        }
        $total_enrolled_female = $this->db
            ->query($sql_enrolledfemale, $params_enrolled_female)
            ->row("total_enrolled_female") ?? "0";



        // ----------- TOTAL ENROLLED STUDENTS ----------
        $sql_enrolled = "SELECT COUNT(*) AS total_enrolled_students
                     FROM tbl_enrollment e
                     WHERE 1=1";
        $params_enrolled = [];
        if (!empty($FTR_YL)) {
            $sql_enrolled .= " AND e.ER_YEARLEVEL = ?";
            $params_enrolled[] = $FTR_YL;
        }
        if (!empty($FTR_SEM)) {
            $sql_enrolled .= " AND e.ER_SEMESTER = ?";
            $params_enrolled[] = $FTR_SEM;
        }
        if (!empty($FTR_PROGRAM)) {
            $sql_enrolled .= " AND e.ER_PROGRAM = ?";
            $params_enrolled[] = $FTR_PROGRAM;
        }
        if (!empty($FTR_AY)) {
            $sql_enrolled .= " AND e.ER_ACADEMICYEAR = ?";
            $params_enrolled[] = substr($FTR_AY, 0, 4); // Only starting year
        }
        $total_enrolled_students = $this->db
            ->query($sql_enrolled, $params_enrolled)
            ->row("total_enrolled_students") ?? "0";



        // ----------- TOTAL ENROLLED STUDENTS PENDING ----------
        $sql_enrolled_pending = "SELECT COUNT(*) AS total_enrolled_students_pending
                     FROM tbl_enrollment e
                     WHERE e.ER_ENSTATUS = 'PENDING'";
        $params_enrolled_pending = [];
        if (!empty($FTR_YL)) {
            $sql_enrolled_pending .= " AND e.ER_YEARLEVEL = ?";
            $params_enrolled_pending[] = $FTR_YL;
        }
        if (!empty($FTR_SEM)) {
            $sql_enrolled_pending .= " AND e.ER_SEMESTER = ?";
            $params_enrolled_pending[] = $FTR_SEM;
        }
        if (!empty($FTR_PROGRAM)) {
            $sql_enrolled_pending .= " AND e.ER_PROGRAM = ?";
            $params_enrolled_pending[] = $FTR_PROGRAM;
        }
        if (!empty($FTR_AY)) {
            $sql_enrolled_pending .= " AND e.ER_ACADEMICYEAR = ?";
            $params_enrolled_pending[] = substr($FTR_AY, 0, 4); // Only starting year
        }
        $total_enrolled_students_pending = $this->db
            ->query($sql_enrolled_pending, $params_enrolled_pending)
            ->row("total_enrolled_students_pending") ?? "0";



        // ----------- TOTAL ENROLLED STUDENTS ACTIVE ----------
        $sql_enrolled_active = "SELECT COUNT(*) AS total_enrolled_students_active
                     FROM tbl_enrollment e
                     WHERE e.ER_ENSTATUS = 'ACTIVE'";
        $params_enrolled_active = [];
        if (!empty($FTR_YL)) {
            $sql_enrolled_active .= " AND e.ER_YEARLEVEL = ?";
            $params_enrolled_active[] = $FTR_YL;
        }
        if (!empty($FTR_SEM)) {
            $sql_enrolled_active .= " AND e.ER_SEMESTER = ?";
            $params_enrolled_active[] = $FTR_SEM;
        }
        if (!empty($FTR_PROGRAM)) {
            $sql_enrolled_active .= " AND e.ER_PROGRAM = ?";
            $params_enrolled_active[] = $FTR_PROGRAM;
        }
        if (!empty($FTR_AY)) {
            $sql_enrolled_active .= " AND e.ER_ACADEMICYEAR = ?";
            $params_enrolled_active[] = substr($FTR_AY, 0, 4); // Only starting year
        }
        $total_enrolled_students_active = $this->db
            ->query($sql_enrolled_active, $params_enrolled_active)
            ->row("total_enrolled_students_active") ?? "0";



        // ----------- TOTAL STUDENT PROFILE ----------
        $sql_student_profile = "SELECT COUNT(*) AS total_student_profile
                        FROM tbl_studprof sp
                        WHERE 1=1";
        $params_student_profile = [];

        if (!empty($FTR_AY)) {
            $sql_student_profile .= " AND YEAR(sp.SP_DATESUBMITTED) = ?";
            $params_student_profile[] = substr($FTR_AY, 0, 4); // Only starting year (e.g., '2025')
        }

        $total_student_profile = $this->db
            ->query($sql_student_profile, $params_student_profile)
            ->row("total_student_profile") ?? "0";



        // ----------- TOTAL STUDENT PROFILE SAVED ----------
        $sql_student_profile_saved = "SELECT COUNT(*) AS total_student_profile_saved
                     FROM tbl_studprof sp
                     WHERE sp.SP_STATUS = 'SAVED'";
        $params_student_profile_saved = [];
        if (!empty($FTR_AY)) {
            $sql_student_profile_saved .= " AND YEAR(sp.SP_DATESUBMITTED) = ?";
            $params_student_profile_saved[] = substr($FTR_AY, 0, 4); // Only starting year
        }
        $total_student_profile_saved = $this->db
            ->query($sql_student_profile_saved, $params_student_profile_saved)
            ->row("total_student_profile_saved") ?? "0";



        // ----------- TOTAL STUDENT PROFILE DRAFT ----------
        $sql_student_profile_draft = "SELECT COUNT(*) AS total_student_profile_draft
                     FROM tbl_studprof sp
                     WHERE sp.SP_STATUS = 'DRAFT'";
        $params_student_profile_draft = [];
        if (!empty($FTR_AY)) {
            $sql_student_profile_draft .= " AND YEAR(sp.SP_DATESUBMITTED) = ?";
            $params_student_profile_draft[] = substr($FTR_AY, 0, 4); // Only starting year
        }
        $total_student_profile_draft = $this->db
            ->query($sql_student_profile_draft, $params_student_profile_draft)
            ->row("total_student_profile_draft") ?? "0";



        // ----------- TOTAL EMPLOYEE PROFILE ----------
        $sql_employee_profile = "SELECT COUNT(*) AS total_employee_profile
                     FROM tbl_facprof fp
                     WHERE 1=1";
        $params_employee_profile = [];
        if (!empty($FTR_AY)) {
            $sql_employee_profile .= " AND YEAR(fp.FP_DATESUBMITTED) = ?";
            $params_employee_profile[] = substr($FTR_AY, 0, 4); // Only starting year
        }
        $total_employee_profile = $this->db
            ->query($sql_employee_profile, $params_employee_profile)
            ->row("total_employee_profile") ?? "0";



        // ----------- TOTAL EMPLOYEE PROFILE TEACHING ----------
        $sql_employee_profile_teaching = "SELECT COUNT(*) AS total_employee_profile_teaching
                     FROM tbl_facprof fp
                     WHERE fp.FP_EMPLOYEETYPE = 'TEACHING'";
        $params_employee_profile_teaching = [];
        if (!empty($FTR_AY)) {
            $sql_employee_profile_teaching .= " AND YEAR(fp.FP_DATESUBMITTED) = ?";
            $params_employee_profile_teaching[] = substr($FTR_AY, 0, 4); // Only starting year
        }
        $total_employee_profile_teaching = $this->db
            ->query($sql_employee_profile_teaching, $params_employee_profile_teaching)
            ->row("total_employee_profile_teaching") ?? "0";



        // ----------- TOTAL EMPLOYEE PROFILE NON-TEACHING ----------
        $sql_employee_profile_nonteaching = "SELECT COUNT(*) AS total_employee_profile_nonteaching
                     FROM tbl_facprof fp
                     WHERE fp.FP_EMPLOYEETYPE = 'NON-TEACHING'";
        $params_employee_profile_nonteaching = [];
        if (!empty($FTR_AY)) {
            $sql_employee_profile_nonteaching .= " AND YEAR(fp.FP_DATESUBMITTED) = ?";
            $params_employee_profile_nonteaching[] = substr($FTR_AY, 0, 4); // Only starting year
        }
        $total_employee_profile_nonteaching = $this->db
            ->query($sql_employee_profile_nonteaching, $params_employee_profile_nonteaching)
            ->row("total_employee_profile_nonteaching") ?? "0";


        // ----------- TOTAL PROGRAMS ----------
        $sql_programs = "SELECT COUNT(*) AS total_programs
                     FROM tbl_program p
                     WHERE 1=1";

        $total_programs = $this->db
            ->query($sql_programs)
            ->row("total_programs") ?? "0";

        // ----------- TOTAL PROGRAMS ACTIVE ----------
        $sql_programs_active = "SELECT COUNT(*) AS total_programs_active
                     FROM tbl_program p
                     WHERE p.P_PROGSTATUS = 'ACTIVE'";

        $total_programs_active = $this->db
            ->query($sql_programs_active)
            ->row("total_programs_active") ?? "0";


        // ----------- TOTAL PROGRAMS INACTIVE ----------
        $sql_programs_inactive = "SELECT COUNT(*) AS total_programs_inactive
                     FROM tbl_program p
                     WHERE P_PROGSTATUS = 'INACTIVE'";

        $total_programs_inactive = $this->db
            ->query($sql_programs_inactive)
            ->row("total_programs_inactive") ?? "0";


        // ----------- TOTAL VISUAL IMPAIRMENT ----------
        $sql_pwd_visual_impairment = "SELECT COUNT(*) AS total_pwd_visual_impairment
                     FROM tbl_studprof sp
                     WHERE sp.SP_PWD_SPECIFY = 'VISUAL IMPAIRMENT'";

        $params_pwd_visual_impairment = [];
        if (!empty($FTR_AY)) {
            $sql_pwd_visual_impairment .= " AND YEAR(sp.SP_DATESUBMITTED) = ?";
            $params_pwd_visual_impairment[] = substr($FTR_AY, 0, 4); // Only starting year
        }

        $total_pwd_visual_impairment = $this->db
            ->query($sql_pwd_visual_impairment, $params_pwd_visual_impairment)
            ->row("total_pwd_visual_impairment") ?? "0";


        // ----------- TOTAL HEARING LOSS ----------
        $sql_pwd_hearing_loss = "SELECT COUNT(*) AS total_pwd_hearing_loss
                     FROM tbl_studprof sp
                     WHERE sp.SP_PWD_SPECIFY = 'HEARING LOSS'";

        $params_pwd_hearing_loss = [];
        if (!empty($FTR_AY)) {
            $sql_pwd_hearing_loss .= " AND YEAR(sp.SP_DATESUBMITTED) = ?";
            $params_pwd_hearing_loss[] = substr($FTR_AY, 0, 4); // Only starting year
        }

        $total_pwd_hearing_loss = $this->db
            ->query($sql_pwd_hearing_loss, $params_pwd_hearing_loss)
            ->row("total_pwd_hearing_loss") ?? "0";


        // ----------- TOTAL ORTHOPEDIC DISABILITY ----------
        $sql_pwd_orthopedic_disability = "SELECT COUNT(*) AS total_pwd_orthopedic_disability
                     FROM tbl_studprof sp
                     WHERE sp.SP_PWD_SPECIFY = 'ORTHOPEDIC DISABILITY'";

        $params_pwd_orthopedic_disability = [];
        if (!empty($FTR_AY)) {
            $sql_pwd_orthopedic_disability .= " AND YEAR(sp.SP_DATESUBMITTED) = ?";
            $params_pwd_orthopedic_disability[] = substr($FTR_AY, 0, 4); // Only starting year
        }

        $total_pwd_orthopedic_disability = $this->db
            ->query($sql_pwd_orthopedic_disability, $params_pwd_orthopedic_disability)
            ->row("total_pwd_orthopedic_disability") ?? "0";


        // ----------- TOTAL LEARNING DISABILITY ----------
        $sql_pwd_learning_disability = "SELECT COUNT(*) AS total_pwd_learning_disability
                     FROM tbl_studprof sp
                     WHERE sp.SP_PWD_SPECIFY = 'LEARNING DISABILITY'";

        $params_pwd_learning_disability = [];
        if (!empty($FTR_AY)) {
            $sql_pwd_learning_disability .= " AND YEAR(sp.SP_DATESUBMITTED) = ?";
            $params_pwd_learning_disability[] = substr($FTR_AY, 0, 4); // Only starting year
        }

        $total_pwd_learning_disability = $this->db
            ->query($sql_pwd_learning_disability, $params_pwd_learning_disability)
            ->row("total_pwd_learning_disability") ?? "0";


        // ----------- TOTAL PSYCHOSOCIAL DISABILITY ----------
        $sql_pwd_psychosocial_disability = "SELECT COUNT(*) AS total_pwd_psychosocial_disability
                     FROM tbl_studprof sp
                     WHERE sp.SP_PWD_SPECIFY = 'PSYCHOSOCIAL DISABILITY'";

        $params_pwd_psychosocial_disability = [];
        if (!empty($FTR_AY)) {
            $sql_pwd_psychosocial_disability .= " AND YEAR(sp.SP_DATESUBMITTED) = ?";
            $params_pwd_psychosocial_disability[] = substr($FTR_AY, 0, 4); // Only starting year
        }

        $total_pwd_psychosocial_disability = $this->db
            ->query($sql_pwd_psychosocial_disability, $params_pwd_psychosocial_disability)
            ->row("total_pwd_psychosocial_disability") ?? "0";


        // ----------- TOTAL CHRONIC ILLNESS ----------
        $sql_pwd_chronic_illness = "SELECT COUNT(*) AS total_pwd_chronic_illness
                     FROM tbl_studprof sp
                     WHERE sp.SP_PWD_SPECIFY = 'CHRONIC ILLNESS'";

        $params_pwd_chronic_illness = [];
        if (!empty($FTR_AY)) {
            $sql_pwd_chronic_illness .= " AND YEAR(sp.SP_DATESUBMITTED) = ?";
            $params_pwd_chronic_illness[] = substr($FTR_AY, 0, 4); // Only starting year
        }

        $total_pwd_chronic_illness = $this->db
            ->query($sql_pwd_chronic_illness, $params_pwd_chronic_illness)
            ->row("total_pwd_chronic_illness") ?? "0";


        // ----------- TOTAL MENTAL DISABILITY ----------
        $sql_pwd_mental_disability = "SELECT COUNT(*) AS total_pwd_mental_disability
                     FROM tbl_studprof sp
                     WHERE sp.SP_PWD_SPECIFY = 'MENTAL DISABILITY'";

        $params_pwd_mental_disability = [];
        if (!empty($FTR_AY)) {
            $sql_pwd_mental_disability .= " AND YEAR(sp.SP_DATESUBMITTED) = ?";
            $params_pwd_mental_disability[] = substr($FTR_AY, 0, 4); // Only starting year
        }

        $total_pwd_mental_disability = $this->db
            ->query($sql_pwd_mental_disability, $params_pwd_mental_disability)
            ->row("total_pwd_mental_disability") ?? "0";


        return [
            'total_enrolled_male' => $total_enrolled_male,
            'total_enrolled_female' => $total_enrolled_female,
            'total_enrolled_students' => $total_enrolled_students,
            'total_enrolled_students_pending' => $total_enrolled_students_pending,
            'total_enrolled_students_active' => $total_enrolled_students_active,
            'total_student_profile' => $total_student_profile,
            'total_student_profle_saved' => $total_student_profile_saved,
            'total_student_profle_draft' => $total_student_profile_draft,
            'total_employee_profile' => $total_employee_profile,
            'total_employee_profile_teaching' => $total_employee_profile_teaching,
            'total_employee_profile_nonteaching' => $total_employee_profile_nonteaching,
            'total_programs' => $total_programs,
            'total_programs_active' => $total_programs_active,
            'total_programs_inactive' => $total_programs_inactive,
            'total_pwd_visual_impairment' => $total_pwd_visual_impairment,
            'total_pwd_hearing_loss' => $total_pwd_hearing_loss,
            'total_pwd_orthopedic_disability' => $total_pwd_orthopedic_disability,
            'total_pwd_learning_disability' => $total_pwd_learning_disability,
            'total_pwd_psychosocial_disability' => $total_pwd_psychosocial_disability,
            'total_pwd_chronic_illness' => $total_pwd_chronic_illness,
            'total_pwd_mental_disability' => $total_pwd_mental_disability
        ];
    }


    public function chart_enrollment_by_sexandyearlevel($FTR_YL = null, $FTR_SEM = null, $FTR_PROGRAM = null, $FTR_AY = null)
    {
        $sql = "SELECT 
        COUNT(CASE WHEN e.ER_YEARLEVEL = '1ST YEAR' AND sp.SP_GENDER = 'MALE' THEN 1 END) AS firstyear_male,
        COUNT(CASE WHEN e.ER_YEARLEVEL = '1ST YEAR' AND sp.SP_GENDER = 'FEMALE' THEN 1 END) AS firstyear_female,
        
        COUNT(CASE WHEN e.ER_YEARLEVEL = '2ND YEAR' AND sp.SP_GENDER = 'MALE' THEN 1 END) AS secondyear_male,
        COUNT(CASE WHEN e.ER_YEARLEVEL = '2ND YEAR' AND sp.SP_GENDER = 'FEMALE' THEN 1 END) AS secondyear_female,
        
        COUNT(CASE WHEN e.ER_YEARLEVEL = '3RD YEAR' AND sp.SP_GENDER = 'MALE' THEN 1 END) AS thirdyear_male,
        COUNT(CASE WHEN e.ER_YEARLEVEL = '3RD YEAR' AND sp.SP_GENDER = 'FEMALE' THEN 1 END) AS thirdyear_female,
        
        COUNT(CASE WHEN e.ER_YEARLEVEL = '4TH YEAR' AND sp.SP_GENDER = 'MALE' THEN 1 END) AS fourthyear_male,
        COUNT(CASE WHEN e.ER_YEARLEVEL = '4TH YEAR' AND sp.SP_GENDER = 'FEMALE' THEN 1 END) AS fourthyear_female
        FROM tbl_enrollment e
        LEFT JOIN tbl_studprof AS sp ON e.ER_STUDENTID = sp.SP_STUDID
        WHERE 1=1";

        $params = [];

        if (!empty($FTR_YL)) {
            $sql .= " AND e.ER_YEARLEVEL = ?";
            $params[] = $FTR_YL;
        }
        if (!empty($FTR_SEM)) {
            $sql .= " AND e.ER_SEMESTER = ?";
            $params[] = $FTR_SEM;
        }
        if (!empty($FTR_PROGRAM)) {
            $sql .= " AND e.ER_PROGRAM = ?";
            $params[] = $FTR_PROGRAM;
        }
        if (!empty($FTR_AY)) {
            $sql .= " AND e.ER_ACADEMICYEAR = ?";
            $params[] = substr($FTR_AY, 0, 4); // adjust only if A.Y. is like "2024-2025"
        }

        return $this->db->query($sql, $params)->row_array();
    }

    public function chart_pwd_statistics($FTR_AY = null)
    {
        $sql = "SELECT 
        COUNT(CASE WHEN sp.SP_PWD = 'YES' THEN 1 END) AS total_pwd_yes,
        COUNT(CASE WHEN sp.SP_PWD = 'NO' THEN 1 END) AS total_pwd_no
        FROM tbl_studprof sp
        WHERE 1=1";

        $params = [];

        if (!empty($FTR_AY)) {
            $sql .= " AND YEAR(sp.SP_DATESUBMITTED) = ?";
            $params[] = substr($FTR_AY, 0, 4); // adjust only if A.Y. is like "2024-2025"
        }

        return $this->db->query($sql, $params)->row_array();
    }

    public function chart_employee_status($FTR_AY = null)
    {
        $sql = "SELECT 
        COUNT(CASE WHEN fp.FP_EMPLOYEETYPE = 'TEACHING' THEN 1 END) AS total_teaching,
        COUNT(CASE WHEN fp.FP_EMPLOYEETYPE = 'NON-TEACHING' THEN 1 END) AS total_non_teaching
        FROM tbl_facprof fp
        WHERE 1=1";

        $params = [];

        if (!empty($FTR_AY)) {
            $sql .= " AND YEAR(fp.FP_DATESUBMITTED) = ?";
            $params[] = substr($FTR_AY, 0, 4); // adjust only if A.Y. is like "2024-2025"
        }

        return $this->db->query($sql, $params)->row_array();
    }

    public function chart_grades_performance($FTR_YL = null, $FTR_AY = null)
    {
        $sql = "SELECT 
        COUNT(CASE WHEN sg.G_YEARLEVEL = '1ST YEAR' AND sg.G_REMARKS = 'PASSED' THEN 1 END) AS totalfirstpassed,
        COUNT(CASE WHEN sg.G_YEARLEVEL = '2ND YEAR' AND sg.G_REMARKS = 'PASSED' THEN 1 END) AS totalsecondpassed,
        COUNT(CASE WHEN sg.G_YEARLEVEL = '3RD YEAR' AND sg.G_REMARKS = 'PASSED' THEN 1 END) AS totalthirdpassed,
        COUNT(CASE WHEN sg.G_YEARLEVEL = '4TH YEAR' AND sg.G_REMARKS = 'PASSED' THEN 1 END) AS totalfourthpassed,

        COUNT(CASE WHEN sg.G_YEARLEVEL = '1ST YEAR' AND sg.G_REMARKS = 'FAILED' THEN 1 END) AS totalfirstfailed,
        COUNT(CASE WHEN sg.G_YEARLEVEL = '2ND YEAR' AND sg.G_REMARKS = 'FAILED' THEN 1 END) AS totalsecondfailed,
        COUNT(CASE WHEN sg.G_YEARLEVEL = '3RD YEAR' AND sg.G_REMARKS = 'FAILED' THEN 1 END) AS totalthirdfailed,
        COUNT(CASE WHEN sg.G_YEARLEVEL = '4TH YEAR' AND sg.G_REMARKS = 'FAILED' THEN 1 END) AS totalfourthfailed,

        COUNT(CASE WHEN sg.G_YEARLEVEL = '1ST YEAR' AND sg.G_REMARKS = 'INCOMPLETE' THEN 1 END) AS totalfirstinc,
        COUNT(CASE WHEN sg.G_YEARLEVEL = '2ND YEAR' AND sg.G_REMARKS = 'INCOMPLETE' THEN 1 END) AS totalsecondinc,
        COUNT(CASE WHEN sg.G_YEARLEVEL = '3RD YEAR' AND sg.G_REMARKS = 'INCOMPLETE' THEN 1 END) AS totalthirdinc,
        COUNT(CASE WHEN sg.G_YEARLEVEL = '4TH YEAR' AND sg.G_REMARKS = 'INCOMPLETE' THEN 1 END) AS totalfourthinc,

        COUNT(CASE WHEN sg.G_YEARLEVEL = '1ST YEAR' AND sg.G_REMARKS = 'DROPPED' THEN 1 END) AS totalfirstdrp,
        COUNT(CASE WHEN sg.G_YEARLEVEL = '2ND YEAR' AND sg.G_REMARKS = 'DROPPED' THEN 1 END) AS totalseconddrp,
        COUNT(CASE WHEN sg.G_YEARLEVEL = '3RD YEAR' AND sg.G_REMARKS = 'DROPPED' THEN 1 END) AS totalthirddrp,
        COUNT(CASE WHEN sg.G_YEARLEVEL = '4TH YEAR' AND sg.G_REMARKS = 'DROPPED' THEN 1 END) AS totalfourthdrp
        FROM tbl_studentgrades sg
        WHERE 1=1";

        $params = [];

        if (!empty($FTR_YL)) {
            $sql .= " AND sg.G_YEARLEVEL = ?";
            $params[] = $FTR_YL;
        }

        if (!empty($FTR_AY)) {
            $sql .= " AND YEAR(sg.G_DATESUBMITTED) = ?";
            $params[] = substr($FTR_AY, 0, 4); // adjust only if A.Y. is like "2024-2025"
        }

        return $this->db->query($sql, $params)->row_array();
    }

    public function chart_enrollment_trends()
    {
        $currentAY = date('Y');
        $previousAY = $currentAY - 1;
        $previousAY2 = $currentAY - 2;
        $previousAY3 = $currentAY - 3;
        $previousAY4 = $currentAY - 4;

        $sql = "SELECT
        COUNT(CASE WHEN e.ER_ACADEMICYEAR = '$currentAY' THEN 1 END) AS totalcurrentenroll,
        COUNT(CASE WHEN e.ER_ACADEMICYEAR = '$previousAY' THEN 1 END) AS totalpreviousenroll,
        COUNT(CASE WHEN e.ER_ACADEMICYEAR = '$previousAY2' THEN 1 END) AS totalpreviousenroll2,
        COUNT(CASE WHEN e.ER_ACADEMICYEAR = '$previousAY3' THEN 1 END) AS totalpreviousenroll3,
        COUNT(CASE WHEN e.ER_ACADEMICYEAR = '$previousAY4' THEN 1 END) AS totalpreviousenroll4
        FROM tbl_enrollment e
        WHERE 1=1";

        return $this->db->query($sql)->row_array();
    }
}
