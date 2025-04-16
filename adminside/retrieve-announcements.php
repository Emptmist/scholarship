<?php
// Database connection details
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

$limit = 9;
$sql = "SELECT title, zwhen, zwhere, body, post_date, ann_pic FROM tbl_announcement ORDER BY no_announcement DESC limit $limit";
$result = $conn->query($sql);

$announcements = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $announcements[] = $row;
    }
}

echo json_encode($announcements);

$conn->close();
?>
