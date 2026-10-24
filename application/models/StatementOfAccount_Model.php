<?php
#[AllowDynamicProperties]
class StatementOfAccount_Model extends CI_Model
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

    function LoadPaidStudent()
    {
        $query = $this->db->query("SELECT DISTINCT * FROM tbl_cashier_billing");
        return $query;
    }
}
