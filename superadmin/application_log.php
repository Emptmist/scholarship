<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_scholarship_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get filter values
$filterAppScholarship = isset($_GET['filter-app-scholarship']) ? $_GET['filter-app-scholarship'] : '';
$filterStatus = isset($_GET['filter-status']) ? $_GET['filter-status'] : '';

// Fetch scholarships for filter options
$sqlOptions = "
    SELECT DISTINCT scholarship_name 
    FROM tbl_scholarship 
    UNION 
    SELECT DISTINCT scholarship_name 
    FROM tbl_scholarship_archive";
$resultOptions = $conn->query($sqlOptions);
$optionsScholarships = "";
while ($row = $resultOptions->fetch_assoc()) {
    $optionsScholarships .= "<option value='" . htmlspecialchars($row['scholarship_name']) . "'" . ($filterAppScholarship == htmlspecialchars($row['scholarship_name']) ? " selected" : "") . ">" . htmlspecialchars($row['scholarship_name']) . "</option>";
}

// Application status modification log
$sqlApplication = "
    SELECT tbl_application_scholarship.Student_No, tbl_scholarship.scholarship_name, tbl_application_scholarship.C_status, tbl_application_scholarship.processed_date, tbl_application_scholarship.Admin_id
    FROM tbl_application_scholarship
    LEFT JOIN tbl_scholarship ON tbl_application_scholarship.scholarship_no = tbl_scholarship.scholarship_no
    WHERE ('$filterAppScholarship' = '' OR tbl_scholarship.scholarship_no= '$filterAppScholarship')
    AND ('$filterStatus' = '' OR C_status = '$filterStatus')
    ORDER BY tbl_application_scholarship.processed_date DESC";

$resultApplication = $conn->query($sqlApplication);

//echo "<h2>Application Status Modification Log</h2>";
if ($resultApplication->num_rows > 0) {
    echo "<table>
            <thead>
                <tr>
                    <th>Student No</th>
                    <th>Scholarship Name</th>
                    <th>Status</th>
                    <th>Processed Date</th>
                    <th>Admin ID</th>
                </tr>
            </thead>
            <tbody>";
            $row_count = 0;
    while ($row = $resultApplication->fetch_assoc()) {
        $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
        $row_count++;

        // Set color based on the C_status value
        $color = '';
        switch ($row['C_status']) {
            case 'approved':
                $color = '#25A55F';
                break;
            case 'rejected':
                $color = 'red';
                break;
            case 'pending':
                $color = 'gray';
                break;
        }

        echo "<tr class='$row_class'>
                <td>" . htmlspecialchars($row['Student_No']) . "</td>
                <td>" . htmlspecialchars($row['scholarship_name']) . "</td>
                <td style='color: $color;'>" . htmlspecialchars($row['C_status']) . "</td>
                <td>" . htmlspecialchars($row['processed_date']) . "</td>
                <td>" . htmlspecialchars($row['Admin_id']) . "</td>
            </tr>";
    }
    echo "</tbody></table><br><br>";
} else {
    echo "No application status modification activity found.<br><br>";
}

$conn->close();
?>


