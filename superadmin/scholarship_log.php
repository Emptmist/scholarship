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
$filterScholarship = $conn->real_escape_string($_GET['filter-scholarship'] ?? '');

// // Construct the SQL query based on the selected filter
// if ($filterScholarship == 'archived') {
//     $sqlScholarship = "
//         SELECT scholarship_no, scholarship_name, scholarship_processed, Admin_id
//         FROM tbl_scholarship_archive
//         ORDER BY scholarship_processed DESC";
// } elseif ($filterScholarship == 'ongoing') {
//     $sqlScholarship = "
//         SELECT scholarship_no, scholarship_name, scholarship_processed, Admin_id
//         FROM tbl_scholarship
//         ORDER BY scholarship_processed DESC";
// } else{
    // Default case: Show all data from both tables
    $sqlScholarship = "
        SELECT scholarship_no, scholarship_name, scholarship_processed, Admin_id
        FROM tbl_scholarship
        ORDER BY scholarship_processed DESC";


$resultScholarship = $conn->query($sqlScholarship);

if (!$resultScholarship) {
    die("Error fetching scholarship logs: " . $conn->error);
}

// Display results in a table
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

    $row_count = 0;
    while ($row = $resultScholarship->fetch_assoc()) {
        $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
        $row_count++;
        echo "<tr class='$row_class'>
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

// Close connection
$conn->close();
?>