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

// Number of records per page
$records_per_page = 10;

// Get the current page number from AJAX, default to 1 if not set
$current_page = isset($_POST['page']) ? intval($_POST['page']) : 1;
$current_page = ($current_page > 0) ? $current_page : 1;

// Calculate the starting record
$start_from = ($current_page - 1) * $records_per_page;

// Get the search term from AJAX
$search_term = isset($_POST['search_student']) ? $conn->real_escape_string(trim($_POST['search_student'])) : '';

// Modify the SQL query to include a search filter
$search_condition = !empty($search_term) 
    ? "WHERE Student_No LIKE '%$search_term%' 
        OR Last_name LIKE '%$search_term%' 
        OR First_name LIKE '%$search_term%' 
        OR CVSU_Email LIKE '%$search_term%'" 
    : '';

// Query to get total number of records with the search condition
$total_records_sql = "SELECT COUNT(*) AS total FROM tbl_cvsu_students $search_condition";
$total_records_result = $conn->query($total_records_sql);
$total_records_row = $total_records_result->fetch_assoc();
$total_records = $total_records_row['total'];

// Calculate total number of pages
$total_pages = ceil($total_records / $records_per_page);

// Query to fetch the records with the search condition and pagination
$sql = "SELECT * FROM tbl_cvsu_students $search_condition LIMIT $start_from, $records_per_page";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>
            <tr>
                <th>STUDENT ID</th>
                <th>LAST NAME</th>
                <th>FIRST NAME</th>
                <th>EMAIL ADDRESS</th>
                <th style='text-align: center;'>ACTION</th>                              
            </tr>";
    
    $row_count = 0; // Counter for row colors

    while ($row = $result->fetch_assoc()) {
        // Alternate row color
        $row_class = ($row_count % 2 == 0) ? 'even' : 'odd';
        $row_count++;

        echo "<tr class='$row_class'>
                <td>".$row["Student_No"]."</td>
                <td>".$row["Last_name"]."</td>
                <td>".$row["First_name"]."</td>
                <td>".$row["CVSU_Email"]."</td>
                <td style='text-align: center;'>
                    <form method='POST' action=''>
                        <input type='hidden' name='student_no' value='".$row["Student_No"]."'>
                        <button type='submit' name='delete' id='delete' value='".$row["Student_No"]."'class='bx bxs-trash-alt' style='color: red; width: 20px;'></button>
                    </form>
                </td>
            </tr>";
    }
    echo "</table><br><br>";

    // Add pagination links
    echo "<div class='pagination'>";
    if ($current_page > 1) {
        echo "<a href='#' class='pagination-link' data-page='" . ($current_page - 1) . "'>&laquo; Previous</a>";
    }
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='#' class='pagination-link' data-page='$i'>$i</a>";
    }
    if ($current_page < $total_pages) {
        echo "<a href='#' class='pagination-link' data-page='" . ($current_page + 1) . "'>Next &raquo;</a>";
    }
    echo "</div>";
} else {
    echo "<table>
            <tr>
                <th>STUDENT ID</th>
                <th>LAST NAME</th>
                <th>FIRST NAME</th>
                <th>EMAIL ADDRESS</th>
                <th style='text-align: center;'>ACTION</th>                              
            </tr>
            <tr>
                <td colspan = '5' style='text-align: center;'> NO DATA AVAILABLE!</td>
            </tr>
        </table>";
}

$conn->close();
?>
