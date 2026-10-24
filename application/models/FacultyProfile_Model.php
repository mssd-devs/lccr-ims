<?php
#[AllowDynamicProperties]
class FacultyProfile_Model extends CI_Model
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

    function LoadProvince($regCode)
    {
        $query = $this->db->where('regCode', $regCode)->order_by('regCode', 'ASC')->get('refprovince');
        $output = '<option value="">--Select--</option>';
        foreach ($query->result() as $row) {
            $output .= '<option value="' . $row->provCode . '">' . $row->provDesc . '</option>';
        }
        return $output;
    }

    function LoadCity($provCode)
    {
        $query = $this->db->where('provCode', $provCode)->order_by('provCode', 'ASC')->get('refcitymun');
        $output = '<option value="">--Select--</option>';
        foreach ($query->result() as $row) {
            $output .= '<option value="' . $row->citymunCode . '">' . $row->citymunDesc . '</option>';
        }
        return $output;
    }

    function LoadBrgy($citymunCode)
    {
        $query = $this->db->where('citymunCode', $citymunCode)->order_by('citymunCode', 'ASC')->get('refbrgy');
        $output = '<option value="">--Select--</option>';
        foreach ($query->result() as $row) {
            $output .= '<option value="' . $row->brgyCode . '">' . strtoupper($row->brgyDesc) . '</option>';
        }
        return $output;
    }

    function checkNewEntry()
    {
        $NEW_FNAME = $this->input->post('NEW_FNAME');
        $NEW_MNAME = $this->input->post('NEW_MNAME');
        $NEW_LNAME = $this->input->post('NEW_LNAME');
        $NEW_DATE = $this->input->post('NEW_DATE');

        $this->db->where("FP_FIRSTNAME", $NEW_FNAME)
            ->where("FP_LASTNAME", $NEW_LNAME)
            ->where("FP_BIRTHDAY", $NEW_DATE);
        if (!empty($NEW_MNAME)) {
            $this->db->where("FP_MIDDLENAME", $NEW_MNAME);
        }
        $query = $this->db->get("tbl_facprof");
        if ($query->num_rows() > 0) {
            return "exist";
        } else {
            $data = [
                "FP_FIRSTNAME" => $NEW_FNAME,
                "FP_MIDDLENAME" => $NEW_MNAME,
                "FP_LASTNAME" => $NEW_LNAME,
                "FP_BIRTHDAY" => $NEW_DATE
            ];
            $this->session->set_userdata($data);
            return "not exist";
        }
    }

    function FetchEducationAttainment()
    {
        $result = '<div class="col-md-12 mb-2 education-item">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center">
                                                <span>Educational Attainment <small class="textEducAttainment">(--select--)</small></span>
                                                <button type="button" class="btn btn-danger btn-sm btn-delete-school"><i class="ri-close-line"></i></button>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline mb-4">
                                                            <select class="form-select select2"  name="EDUC_ATTAIN[]" required data-allow-clear="true">
                                                                <option value="">--Select--</option>
                                                                <option>Elementary</option>
                                                                <option>Junior High School</option>
                                                                <option>Senior High School</option>
                                                                <option>College</option>
                                                            </select>
                                                            <label for="EDUC_ATTAIN">Educational Attainment <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline mb-4">
                                                            <input type="text" class="form-control" required name="EDUC_NAMEOFSCHOOL[]" placeholder="Enter name of school" />
                                                            <label for="EDUC_NAMEOFSCHOOL">Name of School <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline mb-4">
                                                            <input type="text" class="form-control" required name="EDUC_ADDRESS[]" placeholder="Enter school address" />
                                                            <label for="EDUC_ADDRESS">School Address <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-floating form-floating-outline mb-4">
                                                            <input type="text" class="form-control" required name="EDUC_YEAR[]" placeholder="Enter year" />
                                                            <label for="EDUC_YEAR">Year <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12 d-none showCourseTaken">
                                                        <div class="form-floating form-floating-outline mb-4">
                                                            <input type="text" class="form-control EDUC_PROGRAM" name="EDUC_PROGRAM[]" placeholder="Enter course taken" />
                                                            <label for="EDUC_PROGRAM">Course Taken <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
        return $result;
    }

    public function generate_transaction_id()
    {
        date_default_timezone_set("Asia/Manila");
        $current_datetime = new DateTime();
        $date_time_string = $current_datetime->format('YmdHis');
        $transaction_id = $date_time_string;
        return $transaction_id;
    }

    public function generate_unique_series()
    {
        $baseSeries = date('Y') . '';

        while (true) {
            $randomNumber = random_int(10000, 99999);
            $series = $baseSeries . sprintf("%05d", $randomNumber);
            $query = $this->db->get_where('tbl_facprof', ['FP_FACID' => $series]);
            if ($query->num_rows() === 0) {
                return $series;
            }
        }
    }

    function LoadFacultyProfile()
    {
        $query = $this->db->query("SELECT * FROM tbl_facprof ORDER BY id DESC");
        return $query;
    }

    function getDataFP($isUpdate = false)
    {
        date_default_timezone_set("Asia/Manila");

        $data = [
            "FP_FIRSTNAME" => $this->validate_data($this->input->post('FP_FIRSTNAME')),
            "FP_MIDDLENAME" => $this->validate_data($this->input->post('FP_MIDDLENAME')),
            "FP_LASTNAME" => $this->validate_data($this->input->post('FP_LASTNAME')),
            "FP_SUFFIX" => $this->input->post('FP_SUFFIX'),
            "FP_GENDER" => $this->input->post('FP_GENDER'),
            "FP_BIRTHDAY" => $this->input->post('FP_BIRTHDAY'),
            "FP_AGE" => $this->input->post('FP_AGE'),
            "FP_CPNUMBER" => $this->validate_data($this->input->post('FP_CPNUMBER')),
            "FP_EMAIL" => $this->validate_data($this->input->post('FP_EMAIL')),
            "FP_REGION" => $this->input->post('FP_REGION'),
            "FP_PROVINCE" => $this->input->post('FP_PROVINCE'),
            "FP_MUNICIPALITY" => $this->input->post('FP_MUNICIPALITY'),
            "FP_BRGY" => $this->input->post('FP_BRGY'),
            "FP_STRT" => $this->validate_data($this->input->post('FP_STRT')),
            "FP_ZCODE" => $this->input->post('FP_ZCODE'),
            "FP_CIVILSTAT" => $this->input->post('FP_CIVILSTAT'),
            "FP_NATIONALITY" => $this->input->post('FP_NATIONALITY'),
            "FP_RELIGION" => $this->input->post('FP_RELIGION'),
            "FP_TRIBE" => $this->input->post('FP_TRIBE'),
            "FP_EMPLOYEETYPE" => $this->input->post('FP_EMPLOYEETYPE'),
            "FP_FULLTIME" => $this->input->post('FP_FULLTIME'),
            "FP_HIGHDEGREE" => $this->input->post('FP_HIGHDEGREE'),
            "FP_BDEGREE" => $this->validate_data($this->input->post('FP_BDEGREE')),
            "FP_MDEGREE" => $this->validate_data($this->input->post('FP_MDEGREE')),
            "FP_DDEGRE" => $this->validate_data($this->input->post('FP_DDEGRE')),
            "FP_PLICENSE" => $this->input->post('FP_PLICENSE'),
            "FP_TENURE" => $this->input->post('FP_TENURE'),
            "FP_FACRANK" => $this->input->post('FP_FACRANK'),
            "FP_ASALARY" => $this->input->post('FP_ASALARY'),
            "FP_DATESUBMITTED" => date('Y-m-d H:i:s'),
            "FP_ENCODER" => $this->session->userdata("fullname") ?: "Self-Registered"
        ];

        if (!$isUpdate) {
            $data["FP_TRANSID"] = $this->generate_transaction_id();
            $data["FP_FACID"] = $this->generate_unique_series();
        }

        return $data;
    }

    function saveFP()
    {
        $logsData = $this->getLogsData();
        $result = "";

        $data = $this->getDataFP();
        $FP_TRANSID = $data["FP_TRANSID"];

        if ($this->db->insert("tbl_facprof", $data)) {
            $educAttain = $this->input->post("EDUC_ATTAIN") ?? [];
            for ($i = 0; $i < count($educAttain); $i++) {
                $schoolData = [
                    "EDUC_ATTAIN" => $educAttain[$i],
                    "EDUC_NAMEOFSCHOOL" => $this->input->post("EDUC_NAMEOFSCHOOL")[$i],
                    "EDUC_ADDRESS" => $this->input->post("EDUC_ADDRESS")[$i],
                    "EDUC_YEAR" => $this->input->post("EDUC_YEAR")[$i],
                    "EDUC_PROGRAM" => $this->input->post("EDUC_PROGRAM")[$i] ?? "",
                    "FP_TRANSID" => $FP_TRANSID
                ];
                $this->db->insert("tbl_facprof_school", $schoolData);
            }
            $facName = trim(($data['FP_FNAME'] ?? '') . ' ' . ($data['FP_LNAME'] ?? ''));
            log_audit("SAVED NEW FACULTY PROFILE", "Employee ID: " . ($data['FP_EMPID'] ?? '') . " (" . $facName . ")");
            $result = "Data has been saved.";
        } else {
            $result = "Data error saving..";
        }

        return $result;
    }

    public function validate_updatedata($data)
    {
        $data = trim($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function updateFP()
    {
        $result = "";

        $fpTransId = $this->input->post("FP_TRANSID");
        if (!$fpTransId) {
            return "Missing FP_TRANSID.";
        }

        $data = $this->getDataFP(true);

        $this->db->where("FP_TRANSID", $fpTransId);
        if ($this->db->update("tbl_facprof", $data)) {
            $this->db->where("FP_TRANSID", $fpTransId)->delete("tbl_facprof_school");
            $educAttain = $this->input->post("EDUC_ATTAIN") ?? [];
            for ($i = 0; $i < count($educAttain); $i++) {
                $schoolData = [
                    "EDUC_ATTAIN" => $educAttain[$i],
                    "EDUC_NAMEOFSCHOOL" => $this->input->post("EDUC_NAMEOFSCHOOL")[$i],
                    "EDUC_ADDRESS" => $this->input->post("EDUC_ADDRESS")[$i],
                    "EDUC_YEAR" => $this->input->post("EDUC_YEAR")[$i],
                    "EDUC_PROGRAM" => ($educAttain[$i] == 'College') ? $this->input->post("EDUC_PROGRAM")[$i] : "",
                    "FP_TRANSID" => $fpTransId
                ];
                $this->db->insert("tbl_facprof_school", $schoolData);
            }
            $facName = trim(($data['FP_FNAME'] ?? '') . ' ' . ($data['FP_LNAME'] ?? ''));
            log_audit("UPDATED FACULTY PROFILE", "Employee ID: " . ($data['FP_EMPID'] ?? '') . " (" . $facName . ")");
            $result = "Data has been updated.";
        } else {
            $result = "Error updating data.";
        }

        return $result;
    }

    function deleteFP()
    {
        $id = $this->input->post("ID");
        $fac = $this->db->where("ID", $id)->get("tbl_facprof")->row();
        $details = $fac ? ("Employee ID: " . $fac->FP_EMPID . " (" . $fac->FP_FNAME . " " . $fac->FP_LNAME . ")") : ("ID: " . $id);

        $this->db->where("ID", $id)->delete("tbl_facprof");
        log_audit("DELETED FACULTY PROFILE", $details);
        return true;
    }

    private function getLogsData()
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "AT_DATE" => date('F j, Y / H:i:s'),
            "AT_NAME" => $this->session->userdata('fullname') ?: "Public Registration",
            "AT_ACTION" => "SAVED NEW FACULTY PROFILE"
        ];
        return $data;
    }

    private function getLogsDelete()
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "AT_DATE" => date('F j, Y / H:i:s'),
            "AT_NAME" => $this->session->userdata('fullname') ?: "Public Registration",
            "AT_ACTION" => "DELETED FACULTY PROFILE"
        ];
        return $data;
    }

    private function getLogsUpdate()
    {
        date_default_timezone_set("Asia/Manila");
        $data = [
            "AT_DATE" => date('F j, Y / H:i:s'),
            "AT_NAME" => $this->session->userdata('fullname') ?: "Public Registration",
            "AT_ACTION" => "UPDATED FACULTY PROFILE"
        ];
        return $data;
    }
}
