<?php
#[AllowDynamicProperties]
class Scheduling_Model extends CI_Model
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


    function check_permission()
    {
        if (in_array(strtolower(trim($this->session->userdata("usertype") ?? '')), ["administrator", "superadmin", "super admin", "admin"])) {
            return ['View', 'Edit', 'Delete', 'Create'];
        }

        $permission = [];
        $query = $this->db->where([
            "USER_ID" => $this->session->userdata("id"),
            "PAGE" => "Scheduling"
        ])->get("tbl_permissions");

        foreach ($query->result() as $row) {
            $actions = array_map('trim', explode(',', $row->ACTIONS));
            $permission = array_merge($permission, $actions);
        }

        return array_unique($permission); // avoid duplicate actions
    }

    function LoadSchedules()
    {
        $permissions = $this->check_permission();
        $is_admin = in_array(strtolower(trim($this->session->userdata("usertype") ?? '')), ["administrator", "superadmin", "super admin", "admin"]);

        $filters = [
            'SC_PROG' => $this->input->post("FILTER_PROGRAM"),
            'SC_MAJOR' => $this->input->post("FILTER_MAJOR"),
            'SC_YEARLEVEL' => $this->input->post("FILTER_YL"),
            'SC_ACADEMICYEAR' => $this->input->post("FILTER_AY"),
            'SC_SEMESTER' => $this->input->post("FILTER_SEM"),
            'SC_ROOM' => $this->input->post("FILTER_ROOM"),
        ];

        $sql = "SELECT * FROM tbl_scheduling WHERE 1=1";
        foreach ($filters as $col => $val) {
            if (!empty($val)) $sql .= " AND $col = " . $this->db->escape($val);
        }
        $sql .= " ORDER BY ID DESC";

        $query = $this->db->query($sql);
        $result = '';
        $num = 1;

        foreach ($query->result() as $r) {
            $major = $r->SC_MAJOR ? "<small><b>({$r->SC_MAJOR})</b></small>" : '';

            // Prepare dropdown actions
            $actions = [];

            if ($is_admin || in_array("Edit", $permissions)) {
                $actions[] = '<a class="dropdown-item" href="' . base_url("ims/scheduling/edit/{$r->ID}") . '"><i class="ri-edit-line me-1"></i> Edit</a>';
            }

            if ($is_admin || in_array("Delete", $permissions)) {
                $actions[] = '<a class="dropdown-item delete-btn" href="javascript:void(0);" data-id="' . $r->ID . '" data-sc_classcode="' . $r->SC_CLASSCODE . '" data-bs-toggle="modal" data-bs-target="#deleteModal"><i class="ri-delete-bin-line me-1"></i> Delete</a>';
            }

            $dropdown = $actions ? '
            <div class="dropdown">
                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                    <i class="ri-more-2-fill"></i>
                </button>
                <div class="dropdown-menu">' . implode('', $actions) . '</div>
            </div>' : '';

            // Render table row
            $result .= "
        <tr>
            <td>{$r->ID}</td>
            <td>{$r->SC_CLASSCODE}</td>
            <td>{$r->SC_SDESC}</td>
            <td>{$r->SC_PROG} {$major}</td>
            <td>{$r->SC_ACADEMICYEAR}-" . ($r->SC_ACADEMICYEAR + 1) . "</td>
            <td>{$r->SC_SEMESTER}</td>
            <td>{$r->SC_DAY}</td>
            <td>" . date("h:i A", strtotime($r->SC_STARTTIME)) . " - " . date("h:i A", strtotime($r->SC_ENDTIME)) . "</td>
            <td>{$r->SC_ROOM}</td>
            <td>{$r->SC_FACULTY}</td>
            <td>{$dropdown}</td>
        </tr>";
            $num++;
        }

        return $result;
    }



    function LoadRoom()
    {
        $result = "";
        $rm = $this->input->post("rm");
        $query = $this->db->where("R_RMDEPT", $rm)->get("tbl_rooms");
        $result .= "<option selected=''>--Select Room--</option>";
        foreach ($query->result() as $r) {
            $result .= "<option>" . $r->R_RMDESCRIPTION . "</option>";
        }
        return $result;
    }

    function LoadYearLevel()
    {
        $result = "";
        $yrlvl = $this->input->post("yrlvl");

        // Use distinct() to ensure unique results
        $query = $this->db->distinct()
            ->select("S_YRLVL")
            ->where("S_SELECTPROG", $yrlvl)
            ->get("tbl_subject");

        $result .= "<option selected=''>--Select Year Level--</option>";

        // Loop through the distinct results
        foreach ($query->result() as $r) {
            $result .= "<option>" . $r->S_YRLVL . "</option>";
        }

        return $result;
    }

    function LoadSubject()
    {
        $prog = $this->input->post("prog");
        $maj = $this->input->post("maj");
        $yr = $this->input->post("yr");
        $sem = $this->input->post("sem");

        // Start building the query
        $this->db->where("S_SELECTPROG", $prog)
            ->where("S_YRLVL", $yr)
            ->where("S_SEM", $sem);

        // Only apply the major filter if a major is selected
        if (!empty($maj)) {
            $this->db->where("S_MAJOR", $maj);
        }

        $query = $this->db->get("tbl_subject");

        // Fallback: If no subjects found with major filter, query without major filter
        if ($query->num_rows() == 0 && !empty($maj)) {
            $this->db->where("S_SELECTPROG", $prog)
                ->where("S_YRLVL", $yr)
                ->where("S_SEM", $sem);
            $query = $this->db->get("tbl_subject");
        }

        // Prepare the result as HTML options
        $result = "<option selected=''>--Select Subject--</option>";
        foreach ($query->result() as $r) {
            $result .= "<option>" . $r->S_SDESCRIPTION . "</option>";
        }

        return $result;
    }



    function LoadMajor()
    {
        $result = "";
        $maj = $this->input->post("maj");
        $query = $this->db->where("P_PDESCRIPTIONS", $maj)->get("tbl_program");
        $result .= "<option selected=''></option>";
        foreach ($query->result() as $r) {
            $result .= "<option>" . $r->P_MAJOR . "</option>";
        }
        return $result;
    }

    function LoadSection()
    {
        $result = "";
        $yl = $this->input->post("sec");
        $prog = $this->input->post("prog");
        $maj = $this->input->post("maj");
        $sem = $this->input->post("sem");

        $this->db->where("SEC_SYRLVL", $yl)
            ->where("SEC_SSEM", $sem)
            ->where("SEC_SPROG", $prog);

        // Only apply the major filter if a major is selected
        if (!empty($maj)) {
            $this->db->where("SEC_PROGMAJOR", $maj);
        }
        $query = $this->db->get("tbl_section");
        
        // Fallback if no section matches the specific major
        if ($query->num_rows() == 0 && !empty($maj)) {
            $query = $this->db->where("SEC_SYRLVL", $yl)
                ->where("SEC_SSEM", $sem)
                ->where("SEC_SPROG", $prog)
                ->get("tbl_section");
        }

        $result .= "<option selected=''>--Select Section--</option>";
        foreach ($query->result() as $r) {
            $result .= "<option>" . $r->SEC_SDESC . "</option>";
        }
        return $result;
    }

    function LoadSemester()
    {
        $result = "<option selected=''>--Select Semester--</option>";
        $prog = $this->input->post("prog");
        $maj = $this->input->post("maj");

        // Adjust query based on whether "maj" is provided or not
        $this->db->where("P_PDESCRIPTIONS", $prog);
        if (!empty($maj)) {
            $this->db->where("P_MAJOR", $maj);
        }
        $query = $this->db->get("tbl_program");

        $added_semesters = [];
        foreach ($query->result() as $r) {
            $semesters = $this->db
                ->order_by("SEM_NAME", "ASC")
                ->get("tbl_semestertype")
                ->result();

            foreach ($semesters as $semester) {
                if ($r->P_SEMTYPE == $semester->SEM_TYPE && !in_array($semester->SEM_NAME, $added_semesters)) {
                    $result .= "<option value='" . htmlspecialchars($semester->SEM_NAME, ENT_QUOTES) . "'>" . htmlspecialchars($semester->SEM_NAME, ENT_QUOTES) . "</option>";
                    $added_semesters[] = $semester->SEM_NAME;
                }
            }
        }

        // Fallback 1: If major was provided but no semesters were matched, try querying by program description only
        if (empty($added_semesters) && !empty($maj)) {
            $query = $this->db->where("P_PDESCRIPTIONS", $prog)->get("tbl_program");
            foreach ($query->result() as $r) {
                $semesters = $this->db
                    ->order_by("SEM_NAME", "ASC")
                    ->get("tbl_semestertype")
                    ->result();

                foreach ($semesters as $semester) {
                    if ($r->P_SEMTYPE == $semester->SEM_TYPE && !in_array($semester->SEM_NAME, $added_semesters)) {
                        $result .= "<option value='" . htmlspecialchars($semester->SEM_NAME, ENT_QUOTES) . "'>" . htmlspecialchars($semester->SEM_NAME, ENT_QUOTES) . "</option>";
                        $added_semesters[] = $semester->SEM_NAME;
                    }
                }
            }
        }

        // Fallback 2: If still no semesters found, load all active semesters from tbl_semestertype
        if (empty($added_semesters)) {
            $semesters = $this->db->order_by("SEM_NAME", "ASC")->get("tbl_semestertype")->result();
            foreach ($semesters as $semester) {
                if (!in_array($semester->SEM_NAME, $added_semesters)) {
                    $result .= "<option value='" . htmlspecialchars($semester->SEM_NAME, ENT_QUOTES) . "'>" . htmlspecialchars($semester->SEM_NAME, ENT_QUOTES) . "</option>";
                    $added_semesters[] = $semester->SEM_NAME;
                }
            }
        }

        return $result;
    }

    public function generate_sched_code()
    {
        // Generate a 4-digit random number between 1000 and 9999
        $sched_code = rand(1000, 9999);
        return $sched_code;
    }

    function SaveSchedules()
    {
        $SC_CLASSCODE = $this->generate_sched_code();
        $GETPROG = $this->db
            ->where("SC_CLASSCODE", $SC_CLASSCODE)
            ->get("tbl_scheduling")->row("SC_PROG");
        $GETSUBJ = $this->db
            ->where("SC_CLASSCODE", $SC_CLASSCODE)
            ->get("tbl_scheduling")->row("SC_SDESC");
        $logsData = $this->getLogsData($GETSUBJ, $GETPROG);

        date_default_timezone_set("Asia/Manila");

        $data = [
            "SC_CLASSCODE" => $SC_CLASSCODE,
            "SC_MERGE" => $this->validate_data($this->input->post("SC_MERGE")),
            "SC_PROG" => $this->validate_data($this->input->post("SC_PROG")),
            "SC_MAJOR" => $this->validate_data($this->input->post("SC_MAJOR")),
            "SC_YEARLEVEL" => $this->validate_data($this->input->post("SC_YEARLEVEL")),
            "SC_ACADEMICYEAR" => $this->validate_data($this->input->post("SC_ACADEMICYEAR")),
            "SC_SEMESTER" => $this->validate_data($this->input->post("SC_SEMESTER")),
            "SC_SDESC" => $this->validate_data($this->input->post("SC_SDESC")),
            "SC_STARTTIME" => $this->validate_data($this->input->post("SC_STARTTIME")),
            "SC_ENDTIME" => $this->validate_data($this->input->post("SC_ENDTIME")),
            "SC_DAY" => $this->validate_data($this->input->post("SC_DAY")),
            "SC_SECTION" => $this->validate_data($this->input->post("SC_SECTION")),
            "SC_DEPT" => $this->validate_data($this->input->post("SC_DEPT")),
            "SC_ROOM" => $this->validate_data($this->input->post("SC_ROOM")),
            "SC_TEACHMODELS" => $this->validate_data($this->input->post("SC_TEACHMODELS")),
            "SC_FACULTY" => $this->validate_data($this->input->post("SC_FACULTY"))
        ];

        // 1. Check for exact duplicate schedule
        $this->db->where([
            'SC_CLASSCODE' => $data['SC_CLASSCODE'],
            'SC_PROG' => $data['SC_PROG'],
            'SC_MAJOR' => $data['SC_MAJOR'],
            'SC_YEARLEVEL' => $data['SC_YEARLEVEL'],
            'SC_ACADEMICYEAR' => $data['SC_ACADEMICYEAR'],
            'SC_SEMESTER' => $data['SC_SEMESTER'],
            'SC_SDESC' => $data['SC_SDESC'],
            'SC_STARTTIME' => $data['SC_STARTTIME'],
            'SC_ENDTIME' => $data['SC_ENDTIME'],
            'SC_DAY' => $data['SC_DAY'],
            'SC_SECTION' => $data['SC_SECTION'],
            'SC_ROOM' => $data['SC_ROOM'],
            'SC_FACULTY' => $data['SC_FACULTY']
        ]);
        $query1 = $this->db->get('tbl_scheduling');
        if ($query1->num_rows() > 0) {
            $conflict = $query1->row();
            $this->session->set_flashdata('warning', '<b>Duplicate schedule</b> detected for subject: <b>"' . $conflict->SC_SDESC . '"</b><br><b>Section:</b> "' . $conflict->SC_SECTION . '"<br><b>Year Level:</b> "' . $conflict->SC_YEARLEVEL . '".');
            redirect(base_url() . 'ims/scheduling/create');
            return;
        }

        if ($this->input->post("SC_MERGE") != "YES") {
            // Check for room/time/day conflict (overlap logic)
            $this->db->where([
                'SC_ROOM' => $data['SC_ROOM'],
                'SC_ACADEMICYEAR' => $data['SC_ACADEMICYEAR'],
                'SC_SEMESTER' => $data['SC_SEMESTER']
            ]);
            $query2 = $this->db->get('tbl_scheduling');

            $conflict = null;
            foreach ($query2->result() as $row) {
                if ($this->days_overlap($row->SC_DAY, $data['SC_DAY'])) {
                    if ($row->SC_STARTTIME < $data['SC_ENDTIME'] && $row->SC_ENDTIME > $data['SC_STARTTIME']) {
                        $conflict = $row;
                        break;
                    }
                }
            }

            if ($conflict !== null) {
                $available_times = $this->get_available_times($data['SC_ROOM'], $data['SC_DAY'], $data['SC_ACADEMICYEAR'], $data['SC_SEMESTER']);
                $available_str = !empty($available_times) ? implode('<br> &bull; ', $available_times) : 'None';
                $error_msg = '<b>Room/time conflict</b> with subject: <b>"' . $conflict->SC_SDESC . '"</b><br><b>Section:</b> "' . $conflict->SC_SECTION . '"<br><b>Year Level:</b> "' . $conflict->SC_YEARLEVEL . '"<br><br><b>Available times for Room ' . htmlspecialchars($data['SC_ROOM']) . ' on ' . htmlspecialchars($data['SC_DAY']) . ':</b><br> &bull; ' . $available_str;

                $this->session->set_flashdata('warning', $error_msg);
                redirect(base_url() . 'ims/scheduling/create');
                return;
            }
        }

        // 3. Insert new schedule
        if ($this->db->insert("tbl_scheduling", $data)) {
            $details = "Subject: " . $data['SC_SDESC'] . ", Room: " . $data['SC_ROOM'] . ", Section: " . $data['SC_SECTION'] . ", Day: " . $data['SC_DAY'];
            log_audit("SAVED NEW CLASS SCHEDULE", $details);
            $this->session->set_flashdata('success', "Data has been saved.");
        } else {
            $this->session->set_flashdata('error', "Data error saving.");
        }

        redirect(base_url() . 'ims/scheduling');
    }

    public function validate_updatedata($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function UpdateSchedules()
    {
        $SC_CLASSCODE = $this->input->post("SC_CLASSCODE");
        $GETPROG = $this->db
            ->where("SC_CLASSCODE", $SC_CLASSCODE)
            ->get("tbl_scheduling")->row("SC_PROG");
        $GETSUBJ = $this->db
            ->where("SC_CLASSCODE", $SC_CLASSCODE)
            ->get("tbl_scheduling")->row("SC_SDESC");
        date_default_timezone_set("Asia/Manila");

        $id = $this->input->post("ID");

        $data = [
            "SC_CLASSCODE" => $this->validate_updatedata($this->input->post("SC_CLASSCODE")),
            "SC_MERGE" => $this->validate_updatedata($this->input->post("SC_MERGE")),
            "SC_PROG" => $this->validate_updatedata($this->input->post("SC_PROG")),
            "SC_MAJOR" => $this->validate_updatedata($this->input->post("SC_MAJOR")),
            "SC_YEARLEVEL" => $this->validate_updatedata($this->input->post("SC_YEARLEVEL")),
            "SC_ACADEMICYEAR" => $this->validate_updatedata($this->input->post("SC_ACADEMICYEAR")),
            "SC_SEMESTER" => $this->validate_updatedata($this->input->post("SC_SEMESTER")),
            "SC_SDESC" => $this->validate_updatedata($this->input->post("SC_SDESC")),
            "SC_STARTTIME" => $this->validate_updatedata($this->input->post("SC_STARTTIME")),
            "SC_ENDTIME" => $this->validate_updatedata($this->input->post("SC_ENDTIME")),
            "SC_DAY" => $this->validate_updatedata($this->input->post("SC_DAY")),
            "SC_SECTION" => $this->validate_updatedata($this->input->post("SC_SECTION")),
            "SC_DEPT" => $this->validate_updatedata($this->input->post("SC_DEPT")),
            "SC_ROOM" => $this->validate_updatedata($this->input->post("SC_ROOM")),
            "SC_TEACHMODELS" => $this->validate_updatedata($this->input->post("SC_TEACHMODELS")),
            "SC_FACULTY" => $this->validate_updatedata($this->input->post("SC_FACULTY"))
        ];

        // 1. Check for exact duplicate (excluding current ID)
        $this->db->where([
            'SC_CLASSCODE' => $data['SC_CLASSCODE'],
            'SC_PROG' => $data['SC_PROG'],
            'SC_MAJOR' => $data['SC_MAJOR'],
            'SC_YEARLEVEL' => $data['SC_YEARLEVEL'],
            'SC_ACADEMICYEAR' => $data['SC_ACADEMICYEAR'],
            'SC_SEMESTER' => $data['SC_SEMESTER'],
            'SC_SDESC' => $data['SC_SDESC'],
            'SC_STARTTIME' => $data['SC_STARTTIME'],
            'SC_ENDTIME' => $data['SC_ENDTIME'],
            'SC_DAY' => $data['SC_DAY'],
            'SC_SECTION' => $data['SC_SECTION'],
            'SC_ROOM' => $data['SC_ROOM'],
            'SC_FACULTY' => $data['SC_FACULTY']
        ]);
        $this->db->where('ID !=', $id);
        $query1 = $this->db->get('tbl_scheduling');

        if ($query1->num_rows() > 0) {
            $conflict = $query1->row();
            $this->session->set_flashdata('warning', '<b>Duplicate schedule</b> found for subject: <b>"' . $conflict->SC_SDESC . '"</b><br><b>Section:</b> "' . $conflict->SC_SECTION . '"<br><b>Year Level:</b> "' . $conflict->SC_YEARLEVEL . '".');
            redirect(base_url() . 'ims/scheduling/edit/' . $id);
            return;
        }

        // 2. Check for room/time/day conflict if not merged
        if ($data['SC_MERGE'] != "YES") {
            $this->db->where([
                'SC_ROOM' => $data['SC_ROOM'],
                'SC_ACADEMICYEAR' => $data['SC_ACADEMICYEAR'],
                'SC_SEMESTER' => $data['SC_SEMESTER']
            ]);
            $this->db->where('ID !=', $id); // exclude current schedule
            $query2 = $this->db->get('tbl_scheduling');

            $conflict = null;
            foreach ($query2->result() as $row) {
                if ($this->days_overlap($row->SC_DAY, $data['SC_DAY'])) {
                    if ($row->SC_STARTTIME < $data['SC_ENDTIME'] && $row->SC_ENDTIME > $data['SC_STARTTIME']) {
                        $conflict = $row;
                        break;
                    }
                }
            }

            if ($conflict !== null) {
                $available_times = $this->get_available_times($data['SC_ROOM'], $data['SC_DAY'], $data['SC_ACADEMICYEAR'], $data['SC_SEMESTER'], $id);
                $available_str = !empty($available_times) ? implode('<br> &bull; ', $available_times) : 'None';
                $error_msg = 'Room/time conflict <br> Subject: <b>"' . $conflict->SC_SDESC . '"</b><br>Section: <b>"' . $conflict->SC_SECTION . '"</b><br>Year Level: <b>"' . $conflict->SC_YEARLEVEL . '"</b><br>Time: <b>"' . $conflict->SC_STARTTIME . ' - ' . $conflict->SC_ENDTIME . '"</b><br>Day: <b>"' . $conflict->SC_DAY . '"</b><br>Room: <b>"' . $conflict->SC_ROOM . '"</b><br><br><b>Available times for Room ' . htmlspecialchars($data['SC_ROOM']) . ' on ' . htmlspecialchars($data['SC_DAY']) . ':</b><br> &bull; ' . $available_str;

                $this->session->set_flashdata('warning', $error_msg);
                redirect(base_url() . 'ims/scheduling/edit/' . $id);
                return;
            }
        }

        // 3. Proceed to update
        $this->db->where("ID", $id);
        if ($this->db->update("tbl_scheduling", $data)) {
            $details = "Subject: " . $data['SC_SDESC'] . ", Room: " . $data['SC_ROOM'] . ", Section: " . $data['SC_SECTION'];
            log_audit("UPDATED CLASS SCHEDULE", $details);
            $this->session->set_flashdata('success', "Schedule has been updated.");
        } else {
            $this->session->set_flashdata('error', "Failed to update schedule.");
        }

        redirect(base_url() . 'ims/scheduling');
    }


    public function DeleteSchedules()
    {
        $SC_CLASSCODE = $this->input->post("SC_CLASSCODE");
        $GETPROG = $this->db
            ->where("SC_CLASSCODE", $SC_CLASSCODE)
            ->get("tbl_scheduling")->row("SC_PROG");
        $GETSUBJ = $this->db
            ->where("SC_CLASSCODE", $SC_CLASSCODE)
            ->get("tbl_scheduling")->row("SC_SDESC");
        $id = $this->input->post("ID");
        if (!$id) {
            $this->session->set_flashdata('error', "Invalid schedule ID.");
            redirect(base_url('ims/scheduling'));
        }

        $details = $GETSUBJ ? ("Subject: " . $GETSUBJ . " (" . $GETPROG . ")") : ("ID: " . $id);

        // Perform delete
        $this->db->where("ID", $id);
        if ($this->db->delete("tbl_scheduling")) {
            log_audit("DELETED CLASS SCHEDULE", $details);
            $this->session->set_flashdata('success', "Schedule has been deleted.");
        } else {
            $this->session->set_flashdata('error', "Failed to delete schedule.");
        }

        redirect(base_url('ims/scheduling'));
    }


    private function getLogsData($GETSUBJ, $GETPROG)
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "AT_DATE" => date('F j, Y / H:i:s'),
            "AT_NAME" => $this->session->userdata('fullname'),
            "AT_ACTION" => "SAVED NEW SCHEDULE: Subject: " . $GETSUBJ . ", Program: " . $GETPROG
        ];
        return $data;
    }

    private function getLogsDelete($GETSUBJ, $GETPROG)
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "AT_DATE" => date('F j, Y / H:i:s'),
            "AT_NAME" => $this->session->userdata('fullname'),
            "AT_ACTION" => "DELETED SCHEDULE: Subject: " . $GETSUBJ . ", Program: " . $GETPROG
        ];
        return $data;
    }
    private function getLogsUpdate($GETSUBJ, $GETPROG)
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "AT_DATE" => date('F j, Y / H:i:s'),
            "AT_NAME" => $this->session->userdata('fullname'),
            "AT_ACTION" => "UPDATED SCHEDULE: Subject: " . $GETSUBJ . ", Program: " . $GETPROG
        ];
        return $data;
    }

    private function days_overlap($day1, $day2)
    {
        $map = [
            'MWF' => ['M', 'W', 'F'],
            'TTH' => ['T', 'TH'],
            'M' => ['M'],
            'T' => ['T'],
            'W' => ['W'],
            'TH' => ['TH'],
            'F' => ['F'],
            'SAT' => ['SAT'],
            'SUN' => ['SUN']
        ];

        $days1 = isset($map[$day1]) ? $map[$day1] : [$day1];
        $days2 = isset($map[$day2]) ? $map[$day2] : [$day2];

        return !empty(array_intersect($days1, $days2));
    }

    private function time_to_minutes($time_str)
    {
        $parts = explode(':', $time_str);
        if (count($parts) >= 2) {
            return intval($parts[0]) * 60 + intval($parts[1]);
        }
        return false;
    }

    private function minutes_to_time($minutes)
    {
        $hours = floor($minutes / 60);
        $mins = $minutes % 60;
        $ampm = ($hours >= 12) ? 'PM' : 'AM';
        $display_hours = $hours % 12;
        if ($display_hours == 0) $display_hours = 12;
        return sprintf('%d:%02d %s', $display_hours, $mins, $ampm);
    }

    private function get_available_times($room, $target_day, $academic_year, $semester, $exclude_id = null)
    {
        $this->db->where([
            'SC_ROOM' => $room,
            'SC_ACADEMICYEAR' => $academic_year,
            'SC_SEMESTER' => $semester
        ]);
        if ($exclude_id !== null) {
            $this->db->where('ID !=', $exclude_id);
        }
        $query = $this->db->get('tbl_scheduling');

        $day_start = 7 * 60; // 7:00 AM
        $day_end = 21 * 60; // 9:00 PM

        $occupied = [];
        foreach ($query->result() as $row) {
            if ($this->days_overlap($row->SC_DAY, $target_day)) {
                $start_min = $this->time_to_minutes($row->SC_STARTTIME);
                $end_min = $this->time_to_minutes($row->SC_ENDTIME);
                if ($start_min !== false && $end_min !== false) {
                    $occupied[] = ['start' => $start_min, 'end' => $end_min];
                    if ($start_min < $day_start) {
                        $day_start = $start_min;
                    }
                    if ($end_min > $day_end) {
                        $day_end = $end_min;
                    }
                }
            }
        }

        $merged_occupied = [];
        if (!empty($occupied)) {
            usort($occupied, function ($a, $b) {
                return $a['start'] - $b['start'];
            });

            $current = $occupied[0];
            for ($i = 1; $i < count($occupied); $i++) {
                if ($occupied[$i]['start'] <= $current['end']) {
                    $current['end'] = max($current['end'], $occupied[$i]['end']);
                } else {
                    $merged_occupied[] = $current;
                    $current = $occupied[$i];
                }
            }
            $merged_occupied[] = $current;
        }

        $free_slots = [];
        $current_time = $day_start;

        foreach ($merged_occupied as $block) {
            if ($block['start'] > $current_time) {
                $free_slots[] = ['start' => $current_time, 'end' => $block['start']];
            }
            $current_time = max($current_time, $block['end']);
        }

        if ($current_time < $day_end) {
            $free_slots[] = ['start' => $current_time, 'end' => $day_end];
        }

        $formatted_slots = [];
        foreach ($free_slots as $slot) {
            $formatted_slots[] = $this->minutes_to_time($slot['start']) . ' - ' . $this->minutes_to_time($slot['end']);
        }

        return $formatted_slots;
    }
}
