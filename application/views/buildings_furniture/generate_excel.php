
<?php
// Excel headers for HTML table (Excel-compatible)
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=buildings_furniture_report.xls");
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

echo '<h2 style="text-align:center;">Generated Buildings & Furniture Report</h2>';
echo '<table border="1">';
echo '<thead>';
echo '<tr>';
echo '<th rowspan="2">No.</th>';
echo '<th colspan="3">Number of Academic Classroom</th>';
echo '<th colspan="3">Number of Academic Classroom (Use by Student)</th>';
echo '<th colspan="4">Number of Academic Classroom (Conditions)</th>';
echo '<th colspan="2">Academic Classroom</th>';
echo '<th rowspan="2">Total Number of Makeshift (Institution/PTA Funds)</th>';
echo '</tr>';
echo '<tr>';
echo '<th>Use by Student</th>';
echo '<th>Use by Faculty</th>';
echo '<th>Sub-Total</th>';
echo '<th>With Toilet</th>';
echo '<th>W/O Toilet</th>';
echo '<th>Common Toilet</th>';
echo '<th>Good</th>';
echo '<th>Minor Repair</th>';
echo '<th>Major Repair</th>';
echo '<th>Sub-Total</th>';
echo '<th>For Demolition</th>';
echo '<th>On-Going Construction</th>';
echo '</tr>';
echo '</thead>';
echo '<tbody>';

// Use POST data if available, otherwise fallback to original query
if (!empty($tableData)) {
    foreach ($tableData as $row) {
        echo '<tr>';
        echo '<td>' . $row['no'] . '</td>';
        echo '<td>' . $row['usebystudent'] . '</td>';
        echo '<td>' . $row['usebyfaculty'] . '</td>';
        echo '<td>' . $row['classroomsubtotal'] . '</td>';
        echo '<td>' . $row['withtoilet'] . '</td>';
        echo '<td>' . $row['withouttoilet'] . '</td>';
        echo '<td>' . $row['commontoilet'] . '</td>';
        echo '<td>' . $row['buildinggood'] . '</td>';
        echo '<td>' . $row['buildingminor'] . '</td>';
        echo '<td>' . $row['buildingmajor'] . '</td>';
        echo '<td>' . $row['repairsubtotal'] . '</td>';
        echo '<td>' . $row['demolition'] . '</td>';
        echo '<td>' . $row['construction'] . '</td>';
        echo '<td>' . $row['makeshift'] . '</td>';
        echo '</tr>';
    }
} else {
    $count = 1;
    foreach ($LoadBuildingFurniture->result() as $building) {
        echo '<tr>';
        echo '<td>' . $count++ . '</td>';
        echo '<td>' . $building->USEBYSTUDENT . '</td>';
        echo '<td>' . $building->USEBYFACULTY . '</td>';
        echo '<td>' . $building->CLASSROOMSUBTOTAL . '</td>';
        echo '<td>' . $building->WITHTOILET . '</td>';
        echo '<td>' . $building->WITHOUTTOILET . '</td>';
        echo '<td>' . $building->COMMONTOILET . '</td>';
        echo '<td>' . $building->BUILDINGGOOD . '</td>';
        echo '<td>' . $building->BUILDINGMINOR . '</td>';
        echo '<td>' . $building->BUILDINGMAJOR . '</td>';
        echo '<td>' . $building->REPAIRSUBTOTAL . '</td>';
        echo '<td>' . $building->DEMOLITION . '</td>';
        echo '<td>' . $building->CONSTRUCTION . '</td>';
        echo '<td>' . $building->MAKESHIFT . '</td>';
        echo '</tr>';
    }
}
echo '</tbody>';
echo '</table>';
?>