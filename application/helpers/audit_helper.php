<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('log_audit')) {
    /**
     * Log an audit trail entry into tbl_audit
     *
     * @param string $action  The main action name (e.g., 'SAVED NEW DEPARTMENT', 'USER LOGGED IN')
     * @param string $details Details of what was added/updated/deleted (e.g. entity name, code, ID)
     * @return bool
     */
    function log_audit($action, $details = '')
    {
        $CI = &get_instance();
        
        $name = $CI->session->userdata('fullname');
        if (empty($name)) {
            $name = $CI->session->userdata('username') ?: 'System';
        }

        $ip = $CI->input->ip_address();
        date_default_timezone_set("Asia/Manila");

        $fullAction = !empty($details) ? trim($action . " - " . $details) : $action;

        $logsData = [
            "AT_DATE"   => date('F j, Y / H:i:s'),
            "AT_NAME"   => $name,
            "AT_ACTION" => $fullAction,
            "AT_IP"     => $ip
        ];

        return $CI->db->insert("tbl_audit", $logsData);
    }
}
