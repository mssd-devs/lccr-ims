<?php
#[AllowDynamicProperties]
class AuditTrail_Model extends CI_Model
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

    function LoadAudit()
    {
        $query = $this->db->query("SELECT * FROM tbl_audit ORDER BY id DESC");
        return $query;
    }

    public function log($action, $details = '')
    {
        return log_audit($action, $details);
    }
}
