<!DOCTYPE html>
<html>

<head>
    <title>Promotional Report</title>
    <style>
        @media print {
            @page {
                size: 13in 8.5in landscape;
                margin: 15mm 3mm 15mm 3mm;
            }

            body {
                font-family: Arial, sans-serif;
                font-size: 12px;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            th,
            td {
                border: 1px solid #000;
                padding: 4px 8px;
                text-align: center;
            }

            th {
                background: #f0f8fa;
                font-weight: bold;
            }

            .header-group th {
                background: #e0eaf1;
            }

            .highlight {
                background: #6ec1e4;
                color: #000;
            }
        }

        /* For screen preview */
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 4px 8px;
            text-align: center;
        }

        th {
            background: #f0f8fa;
            font-weight: bold;
        }

        .header-group th {
            background: #e0eaf1;
        }

        .highlight {
            background: #6ec1e4;
            color: #000;
        }
    </style>
</head>
<script>
    window.onload = function() {
        document.body.style.margin = "0";
        window.print();
    };
    window.onafterprint = function() {
        window.close();
    };
</script>

<body>
    <?php
    $query = $this->db->get("tbl_websettings");
    foreach ($query->result() as $row) {
        $logo1 = base_url('assets/img/' . $row->IMS_WEB_IMG);
        $logo2 = base_url('assets/img/' . $row->IMS_WEB_IMG2);
        $school_acro = $row->IMS_WEB_ACRO;
        $school_name = $row->IMS_WEB_NOS;
        $school_address = $row->IMS_WEB_ADDRESS;
        $school_email = $row->IMS_WEB_EMAIL;
    }
    ?>
    <center>
        <span><b style="font-size: 14px;"><?= $school_name ?></b></span><br>
        <span style="font-size: 12px;"><?= $school_address ?></span><br>
    </center>
    <h2 style="text-align:center;">Promotional Report</h2>
    <table>
        <thead>
            <tr>
                <th rowspan="2">Program</th>
                <th colspan="2" class="header-group">Academic</th>
                <th rowspan="2">Semester</th>
                <th rowspan="2">Surname, First name, Middle Name</th>
                <th colspan="2" class="header-group">Address</th>
                <th rowspan="2">SEX</th>
                <th rowspan="2">Birthdate</th>
                <th rowspan="2">Course Title</th>
                <th rowspan="2">Units</th>
                <th rowspan="2" class="highlight">Total Units</th>
                <th rowspan="2">Grade</th>
                <th rowspan="2" class="highlight">GWA</th>
            </tr>
            <tr>
                <th>Year</th>
                <th>Level</th>
                <th>Municipality</th>
                <th>Province</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Get selected students from query string if present
            $selected_students = [];
            if (isset($_GET['students'])) {
                $students_json = $_GET['students'];
                $selected_students = json_decode($students_json, true);
                // Extract student IDs, academic years, and semesters for filtering
                $selected_keys = [];
                foreach ($selected_students as $stud) {
                    // Use a composite key: student_id|academic_year|semester
                    $selected_keys[] = $stud['student_id'] . '|' . $stud['academic_year'] . '|' . $stud['semester'];
                }
            } else {
                $selected_keys = [];
            }

            // Fetch data with LEFT JOINs from the database and sum S_UNITS per student per academic year and semester
            $this->db->select('
            tbl_enrollment.ER_STUDENTID as student_id,
            tbl_enrollment.ER_PROGRAM as program,
            tbl_enrollment.ER_ACADEMICYEAR as academic_year,
            tbl_enrollment.ER_YEARLEVEL as level,
            tbl_enrollment.ER_SEMESTER as semester,
            CONCAT(tbl_studprof.SP_LASTNAME, ", ", tbl_studprof.SP_FIRSTNAME, " ", tbl_studprof.SP_MIDDLENAME) as full_name,
            tbl_studprof.SP_MUNICIPALITY as municipality,
            tbl_studprof.SP_PROVINCE as province,
            tbl_studprof.SP_GENDER as sex,
            tbl_studprof.SP_BIRTHDAY as birthdate,
            tbl_subject.S_SDESCRIPTION as course_title,
            tbl_subject.S_UNITS as units,
            tbl_gradingsystem.GS_TRANSMUTED as grade
            ');
            $this->db->from('tbl_enrollment');
            $this->db->join('tbl_studprof', 'tbl_enrollment.ER_STUDENTID = tbl_studprof.SP_STUDID', 'left');
            $this->db->join('tbl_subject', 'tbl_enrollment.ER_SUBJECTS = tbl_subject.ID', 'left');
            $this->db->join('tbl_gradingsystem', 'tbl_enrollment.ER_STUDENTID = tbl_gradingsystem.GS_STUDENTID', 'left');
            if (!empty($selected_keys)) {
                // Build a grouped where clause for (student_id, academic_year, semester)
                $this->db->group_start();
                foreach ($selected_keys as $key) {
                    list($sid, $ay, $sem) = explode('|', $key);
                    $this->db->or_group_start();
                    $this->db->where('tbl_enrollment.ER_STUDENTID', $sid);
                    $this->db->where('tbl_enrollment.ER_ACADEMICYEAR', $ay);
                    $this->db->where('tbl_enrollment.ER_SEMESTER', $sem);
                    $this->db->group_end();
                }
                $this->db->group_end();
            }
            $query = $this->db->get();
            $data = $query->result_array();

            // Group data by student_id + academic_year + semester
            $students = [];
            foreach ($data as $row) {
                $group_key = $row['student_id'] . '|' . $row['academic_year'] . '|' . $row['semester'];
                if (!isset($students[$group_key])) {
                    $students[$group_key] = [
                        'student_id' => $row['student_id'],
                        'program' => $row['program'],
                        'academic_year' => $row['academic_year'],
                        'level' => $row['level'],
                        'semester' => $row['semester'],
                        'full_name' => $row['full_name'],
                        'municipality' => $row['municipality'],
                        'province' => $row['province'],
                        'sex' => $row['sex'],
                        'birthdate' => $row['birthdate'],
                        'courses' => [],
                        'total_units' => 0,
                        'grade' => $row['grade'],
                        'gwa' => '', // You can calculate GWA if needed
                    ];
                }
                $students[$group_key]['courses'][] = [
                    'course_title' => $row['course_title'],
                    'units' => $row['units'],
                    'grade' => $row['grade'],
                ];
                $students[$group_key]['total_units'] += (float)$row['units'];
            }

            if (count($students) > 0) {
                foreach ($students as $student) {
                    $rowspan = count($student['courses']);
                    $first = true;
                    foreach ($student['courses'] as $course) {
                        echo '<tr>';
                        if ($first) {
                            // Add academic year and semester to the id attribute for the row (optional)
                            $row_id = htmlspecialchars($student['student_id'] . '-' . $student['academic_year'] . '-' . $student['semester']);
                            echo '<td rowspan="' . $rowspan . '" id="program-' . $row_id . '">' . htmlspecialchars($student['program'] ?? '') . '</td>';
                            echo '<td rowspan="' . $rowspan . '" id="year-' . $row_id . '">' . htmlspecialchars($student['academic_year'] ?? '') . '</td>';
                            echo '<td rowspan="' . $rowspan . '" id="level-' . $row_id . '">' . htmlspecialchars($student['level'] ?? '') . '</td>';
                            echo '<td rowspan="' . $rowspan . '" id="semester-' . $row_id . '">' . htmlspecialchars($student['semester'] ?? '') . '</td>';
                            echo '<td rowspan="' . $rowspan . '" id="name-' . $row_id . '">' . htmlspecialchars($student['full_name'] ?? '') . '</td>';
                            echo '<td rowspan="' . $rowspan . '" id="municipality-' . $row_id . '">' . htmlspecialchars($student['municipality'] ?? '') . '</td>';
                            echo '<td rowspan="' . $rowspan . '" id="province-' . $row_id . '">' . htmlspecialchars($student['province'] ?? '') . '</td>';
                            echo '<td rowspan="' . $rowspan . '" id="sex-' . $row_id . '">' . htmlspecialchars($student['sex'] ?? '') . '</td>';
                            echo '<td rowspan="' . $rowspan . '" id="birthdate-' . $row_id . '">' . htmlspecialchars($student['birthdate'] ?? '') . '</td>';
                        }
                        echo '<td>' . htmlspecialchars($course['course_title'] ?? '') . '</td>';
                        echo '<td>' . htmlspecialchars($course['units'] ?? '') . '</td>';
                        if ($first) {
                            echo '<td class="highlight" rowspan="' . $rowspan . '" id="totalunits-' . $row_id . '">' . htmlspecialchars($student['total_units']) . '</td>';
                        }
                        echo '<td>' . htmlspecialchars($course['grade'] ?? '') . '</td>';
                        if ($first) {
                            echo '<td class="highlight" rowspan="' . $rowspan . '" id="gwa-' . $row_id . '">' . htmlspecialchars($student['gwa'] ?? '') . '</td>';
                        }
                        echo '</tr>';
                        $first = false;
                    }
                }
            } else {
                echo '<tr><td colspan="14">No data available.</td></tr>';
            }
            ?>
        </tbody>
    </table>
</body>

</html>