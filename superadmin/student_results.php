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

$searchTerm = isset($_POST['search_user']) ? trim($_POST['search_user']) : '';
$status = isset($_POST['status_select']) ? $_POST['status_select'] : '';
$scholarshipName = isset($_POST['req_name']) ? $_POST['req_name'] : '';

$searchTermEscaped = $conn->real_escape_string($searchTerm);
$statusEscaped = $conn->real_escape_string($status);
$scholarshipNameEscaped = $conn->real_escape_string($scholarshipName);

// Build the SQL query with dynamic conditions
$sql = "
    SELECT 
        tbl_student_acc.Student_No, 
        tbl_student_acc.First_name, 
        tbl_student_acc.Last_name, 
        tbl_student_acc.Email_Address, 
        tbl_scholarship.scholarship_name,
        tbl_application_scholarship.Admin_id,
        tbl_application_scholarship.C_status
    FROM 
        tbl_student_acc 
    LEFT JOIN 
        tbl_application_scholarship 
    ON 
        tbl_student_acc.Student_No = tbl_application_scholarship.Student_No 
    LEFT JOIN 
        tbl_scholarship 
    ON 
        tbl_scholarship.scholarship_no = tbl_application_scholarship.scholarship_no 
    WHERE 
        1"; // Start with a base condition

// Add conditions based on filters
if (!empty($statusEscaped)) {
    $sql .= " AND tbl_application_scholarship.C_status = '$statusEscaped'";
}

if (!empty($scholarshipNameEscaped)) {
    $sql .= " AND tbl_scholarship.scholarship_no = '$scholarshipNameEscaped'";
}

if (!empty($searchTermEscaped)) {
    $sql .= " AND (
        tbl_student_acc.Student_No LIKE '%$searchTermEscaped%' OR 
        tbl_student_acc.First_name LIKE '%$searchTermEscaped%' OR 
        tbl_student_acc.Last_name LIKE '%$searchTermEscaped%' OR 
        tbl_student_acc.Email_Address LIKE '%$searchTermEscaped%' OR 
        tbl_application_scholarship.Admin_id LIKE '%$searchTermEscaped%'
    )";
}

// Execute the query
$sql .= " ORDER BY tbl_application_scholarship.application_date ASC";
$result = $conn->query($sql);

// Output the results
if ($result->num_rows > 0) {
    $row_count = 0; // Counter for row colors

    while ($row = $result->fetch_assoc()) {
        // Alternate row color
        $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
        $row_count++;

        // Use a placeholder if value is NULL
        $admin_id = !empty($row["Admin_id"]) ? htmlspecialchars($row["Admin_id"]) : 'Not Assigned';
        $scholarship_name = !empty($row["scholarship_name"]) ? htmlspecialchars($row["scholarship_name"]) : 'No Scholarship';
        $c_status = !empty($row["C_status"]) ? htmlspecialchars($row["C_status"]) : 'Status Unknown';

        // Determine the color for status
        $status_color = '#346473'; // Default color
        if (strtolower($c_status) == 'pending') {
            $status_color = 'gray';
        } elseif (strtolower($c_status) == 'approved') {
            $status_color = 'green';
        } elseif (strtolower($c_status) == 'rejected') {
            $status_color = 'red';
        }

        echo "<tr class='$row_class'>
                <td>".htmlspecialchars($row["Student_No"])."</td>
                <td>".htmlspecialchars($row["Last_name"])."</td>
                <td>".htmlspecialchars($row["First_name"])."</td>
                <td>".htmlspecialchars($row["Email_Address"])."</td>
                <td>".$scholarship_name."</td>
                <td style='text-align: center;'>".$admin_id."</td>
                <td style='text-align: center; color: $status_color;'>".$c_status."</td>
            </tr>";
    }
    echo "<br><br>";
} else {
    echo "<tr>
                <td colspan='7' style='text-align: center;'>NO AVAILABLE APPLICATION!</td>
            </tr>
        </table>";
}

$conn->close();
?>
