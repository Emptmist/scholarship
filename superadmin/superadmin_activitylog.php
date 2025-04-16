<?php
// $servername = "localhost";
// $username = "root";
// $password = "";
// $dbname = "db_scholarship_system";

// $conn = new mysqli($servername, $username, $password, $dbname);

// if ($conn->connect_error) {
//     die("Connection failed: " . $conn->connect_error);
// }

// $scholarship_no = isset($_GET['scholarship_no']) ? $_GET['scholarship_no'] : '';
// $status = isset($_GET['status']) ? $_GET['status'] : '';
// $announcement_no = isset($_GET['announcement_no']) ? $_GET['announcement_no'] : '';
// $activity_date = isset($_GET['activity_date']) ? $_GET['activity_date'] : '';
// $search = isset($_GET['search']) ? $_GET['search'] : '';

// // Initialize where clauses array
// $whereClausesApplication = [];
// $whereClausesScholarship = [];
// $whereClausesAnnouncement = [];

// // Add filters based on input
// if (!empty($scholarship_no)) {
//     $whereClausesApplication[] = "tbl_application_scholarship.scholarship_no = '" . $conn->real_escape_string($scholarship_no) . "'";
// }
// if (!empty($status)) {
//     $whereClausesApplication[] = "tbl_application_scholarship.C_status = '" . $conn->real_escape_string($status) . "'";
// }
// if (!empty($announcement_no)) {
//     $whereClausesAnnouncement[] = "tbl_announcement.no_announcement = '" . $conn->real_escape_string($announcement_no) . "'";
// }
// if (!empty($search)) {
//     $search_wildcard = "%" . $conn->real_escape_string($search) . "%";
//     $whereClausesScholarship[] = "tbl_scholarship.scholarship_name LIKE '$search_wildcard'";
//     $whereClausesAnnouncement[] = "tbl_announcement.title LIKE '$search_wildcard'";
// }

// // Combine where clauses into a single string
// $whereClauseApplication = !empty($whereClausesApplication) ? 'WHERE ' . implode(' AND ', $whereClausesApplication) : '';
// $whereClauseScholarship = !empty($whereClausesScholarship) ? 'WHERE ' . implode(' AND ', $whereClausesScholarship) : '';
// $whereClauseAnnouncement = !empty($whereClausesAnnouncement) ? 'WHERE ' . implode(' AND ', $whereClausesAnnouncement) : '';

// // Prepare the SQL query
// $sql = "SELECT tbl_application_scholarship.application_date AS activity_date, 
//                'Application' AS type, 
//                tbl_scholarship.scholarship_name AS title_desc, 
//                tbl_application_scholarship.C_status AS status, 
//                tbl_application_scholarship.Admin_id AS Admin_id
//         FROM tbl_application_scholarship
//         LEFT JOIN tbl_scholarship ON tbl_application_scholarship.scholarship_no = tbl_scholarship.scholarship_no
//         $whereClauseApplication
//         UNION
//         SELECT tbl_scholarship.end_of_applications AS activity_date, 
//                'Scholarship' AS type, 
//                tbl_scholarship.scholarship_name AS title_desc, 
//                'N/A' AS status, 
//                tbl_scholarship.Admin_id AS Admin_id
//         FROM tbl_scholarship
//         $whereClauseScholarship
//         UNION
//         SELECT tbl_announcement.post_date AS activity_date, 
//                'Announcement' AS type, 
//                tbl_announcement.title AS title_desc, 
//                'N/A' AS status, 
//                'N/A' AS Admin_id
//         FROM tbl_announcement
//         $whereClauseAnnouncement
//         ORDER BY activity_date DESC";

// // Execute the query
// $result = $conn->query($sql);


// if ($result->num_rows > 0) {
//     echo "<table id='activity-log-table'>
//             <thead>
//                 <tr>
//                     <th>Date</th>
//                     <th>Type</th>
//                     <th>Title/Description</th>
//                     <th>Status</th>
//                     <th>Admin ID</th>
//                     <th>Actions</th>
//                 </tr>
//             </thead>
//             <tbody>";
    
//     $row_count = 0;

//     while ($row = $result->fetch_assoc()) {
//         $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
//         $row_count++;

//         // Set the color based on the type
//         $type_color = '';
//         switch ($row["type"]) {
//             case 'Application':
//                 $type_color = 'color: blue;';
//                 break;
//             case 'Scholarship':
//                 $type_color = 'color: green;';
//                 break;
//             case 'Announcement':
//                 $type_color = 'color: orange;';
//                 break;
//             default:
//                 $type_color = 'color: black;';
//                 break;
//         }

//         // Set the color based on the status
//         $status_color = '';
//         switch ($row["status"]) {
//             case 'approved':
//                 $status_color = 'color: green;';
//                 break;
//             case 'rejected':
//                 $status_color = 'color: red;';
//                 break;
//             case 'pending':
//                 $status_color = 'color: gray;';
//                 break;
//             default:
//                 $status_color = 'color: #346473;';
//                 break;
//         }

//         echo "<tr class='$row_class'>
//                 <td>".(!empty($row["activity_date"]) ? htmlspecialchars($row["activity_date"]) : 'No Date')."</td>
//                 <td style='$type_color'>".(!empty($row["type"]) ? htmlspecialchars($row["type"]) : 'No Type')."</td>
//                 <td>".(!empty($row["title_desc"]) ? htmlspecialchars($row["title_desc"]) : 'No Description')."</td>
//                 <td style='$status_color'>".(!empty($row["status"]) ? htmlspecialchars($row["status"]) : 'No Status')."</td>
//                 <td>".(!empty($row["Admin_id"]) ? htmlspecialchars($row["Admin_id"]) : 'No Admin ID')."</td>
//                 <td>
//                     <form method='POST' action=''>
//                         <input type='hidden' name='activity_id' value='".htmlspecialchars($row["Admin_id"])."'>
//                         <button type='submit' name='delete' id='delete' value='".htmlspecialchars($row["Admin_id"])."' class='bx bxs-trash-alt' style='color: red; width: 20px;'></button>
//                     </form>
//                 </td>
//             </tr>";
//     }
//     echo "</tbody></table><br><br>";
// } else {
//     echo "No records found.";
// }

// $conn->close();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_scholarship_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data for each activity log

// Scholarship creation/deletion log
$sqlScholarship = "
    SELECT scholarship_no, scholarship_name, scholarship_processed, Admin_id
    FROM tbl_scholarship
    UNION
    SELECT scholarship_no, scholarship_name, scholarship_processed, Admin_id
    FROM tbl_scholarship_archive
    ORDER BY scholarship_processed DESC";

$resultScholarship = $conn->query($sqlScholarship);

// Application status modification log
$sqlApplication = "
    SELECT tbl_application_scholarship.Student_No, tbl_scholarship.scholarship_name, tbl_application_scholarship.C_status, tbl_application_scholarship.processed_date, tbl_application_scholarship.Admin_id
    FROM tbl_application_scholarship
    LEFT JOIN tbl_scholarship ON tbl_application_scholarship.scholarship_no = tbl_scholarship.scholarship_no
    ORDER BY tbl_application_scholarship.processed_date DESC";

$resultApplication = $conn->query($sqlApplication);

// Announcement creation log
$sqlAnnouncement = "
    SELECT no_announcement, title, posted_to, post_date, Admin_id
    FROM tbl_announcement
    ORDER BY post_date DESC";

$resultAnnouncement = $conn->query($sqlAnnouncement);

// Display the logs

// Scholarship Log
echo "<h2>Scholarship Activity Log</h2>";
if ($resultScholarship->num_rows > 0) {
    echo "<table>
            <thead>
                <tr>
                    <th>Scholarship No</th>
                    <th>Scholarship Name</th>
                    <th>Processed Date</th>
                    <th>Admin ID</th>
                </tr>
            </thead>
            <tbody>";
    while ($row = $resultScholarship->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['scholarship_no']) . "</td>
                <td>" . htmlspecialchars($row['scholarship_name']) . "</td>
                <td>" . htmlspecialchars($row['scholarship_processed']) . "</td>
                <td>" . htmlspecialchars($row['Admin_id']) . "</td>
            </tr>";
    }
    echo "</tbody></table><br><br>";
} else {
    echo "No scholarship activity found.<br><br>";
}

// Application Log
echo "<h2>Application Status Modification Log</h2>";
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
    while ($row = $resultApplication->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['Student_No']) . "</td>
                <td>" . htmlspecialchars($row['scholarship_name']) . "</td>
                <td>" . htmlspecialchars($row['C_status']) . "</td>
                <td>" . htmlspecialchars($row['processed_date']) . "</td>
                <td>" . htmlspecialchars($row['Admin_id']) . "</td>
            </tr>";
    }
    echo "</tbody></table><br><br>";
} else {
    echo "No application status modification activity found.<br><br>";
}

// Announcement Log
echo "<h2>Announcement Creation Log</h2>";
if ($resultAnnouncement->num_rows > 0) {
    echo "<table>
            <thead>
                <tr>
                    <th>Announcement No</th>
                    <th>Title</th>
                    <th>Posted To</th>
                    <th>Post Date</th>
                    <th>Admin ID</th>
                </tr>
            </thead>
            <tbody>";
    while ($row = $resultAnnouncement->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row['no_announcement']) . "</td>
                <td>" . htmlspecialchars($row['title']) . "</td>
                <td>" . htmlspecialchars($row['posted_to']) . "</td>
                <td>" . htmlspecialchars($row['post_date']) . "</td>
                <td>" . htmlspecialchars($row['Admin_id']) . "</td>
            </tr>";
    }
    echo "</tbody></table><br><br>";
} else {
    echo "No announcement creation activity found.<br><br>";
}

$conn->close();
?>
