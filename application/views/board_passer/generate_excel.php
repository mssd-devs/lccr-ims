
<?php
// Excel headers for HTML table (Excel-compatible)
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=board_passer_report.xls");
header("Pragma: no-cache");
header("Expires: 0");

$query = $this->db->get("tbl_websettings");
foreach ($query->result() as $row) {
    $school_name = $row->IMS_WEB_NOS;
    $school_address = $row->IMS_WEB_ADDRESS;
    $school_email = $row->IMS_WEB_EMAIL;
}

// Get table data from POST request
$tableData = array();
if ($this->input->post('table_data')) {
    $tableData = json_decode($this->input->post('table_data'), true);
}

echo '<h2 style="text-align:center;">Generated Board Passer Report</h2>';
echo '<table border="1">';
echo '<thead>';
echo '<tr>';
echo '<th rowspan="2">PROGRAM</th>';
echo '<th rowspan="2">YEAR</th>';
echo '<th rowspan="2">MONTH</th>';
echo '<th colspan="4">FIRST TIMER</th>';
echo '<th colspan="4">REPEATER</th>';
echo '<th colspan="4">OVERALL PERFORMANCE</th>';
echo '</tr>';
echo '<tr>';
echo '<th>Passed</th>';
echo '<th>Failed</th>';
echo '<th>Total</th>';
echo '<th>% Passed</th>';
echo '<th>Passed</th>';
echo '<th>Failed</th>';
echo '<th>Total</th>';
echo '<th>% Passed</th>';
echo '<th>Passed</th>';
echo '<th>Failed</th>';
echo '<th>Total</th>';
echo '<th>% Passed</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

// Use POST data if available, otherwise fallback to original query
if (!empty($tableData)) {
    foreach ($tableData as $row) {
        echo '<tr>';
        echo '<td>' . $row['program'] . '</td>';
        echo '<td>' . $row['year'] . '</td>';
        echo '<td>' . $row['month'] . '</td>';
        // First Timer
        echo '<td>' . $row['ft_passed'] . '</td>';
        echo '<td>' . $row['ft_failed'] . '</td>';
        echo '<td>' . $row['ft_total'] . '</td>';
        echo '<td>' . $row['ft_percent'] . '</td>';
        // Repeater
        echo '<td>' . $row['rt_passed'] . '</td>';
        echo '<td>' . $row['rt_failed'] . '</td>';
        echo '<td>' . $row['rt_total'] . '</td>';
        echo '<td>' . $row['rt_percent'] . '</td>';
        // Overall Performance
        echo '<td>' . $row['op_passed'] . '</td>';
        echo '<td>' . $row['op_failed'] . '</td>';
        echo '<td>' . $row['op_total'] . '</td>';
        echo '<td>' . $row['op_percent'] . '</td>';
        echo '</tr>';
    }
} else {
    foreach ($LoadBoardPasser->result() as $boardpasser) {
        echo '<tr>';
        echo '<td>' . $boardpasser->PROGRAM . '</td>';
        echo '<td>' . $boardpasser->YEAR . '</td>';
        echo '<td>' . $boardpasser->MONTH . '</td>';
        // First Timer
        echo '<td>' . $boardpasser->FT_PASSED . '</td>';
        echo '<td>' . $boardpasser->FT_FAILED . '</td>';
        echo '<td>' . ($boardpasser->FT_PASSED + $boardpasser->FT_FAILED) . '</td>';
        echo '<td>' . $boardpasser->FT_TOTALPERCENT . '%</td>';
        // Repeater
        echo '<td>' . $boardpasser->RT_PASSED . '</td>';
        echo '<td>' . $boardpasser->RT_FAILED . '</td>';
        echo '<td>' . ($boardpasser->RT_PASSED + $boardpasser->RT_FAILED) . '</td>';
        echo '<td>' . $boardpasser->RT_TOTALPERCENT . '%</td>';
        // Overall Performance
        echo '<td>' . $boardpasser->OP_PASSED . '</td>';
        echo '<td>' . $boardpasser->OP_FAILED . '</td>';
        echo '<td>' . ($boardpasser->OP_PASSED + $boardpasser->OP_FAILED) . '</td>';
        echo '<td>' . $boardpasser->OP_GRANDTOTALPERCENT . '%</td>';
        echo '</tr>';
    }
}
echo '</tbody>';
echo '</table>';
?>