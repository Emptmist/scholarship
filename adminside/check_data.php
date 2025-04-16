<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

if ($conn->connect_error) {
    die(json_encode(['success' => false]));
}

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$response = array("scholarship" => false, "rubric" => false);

// Check tbl_scholarship
$scholarship_query = "SELECT COUNT(*) as count FROM tbl_scholarship";
$result = $conn->query($scholarship_query);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
        $response["scholarship"] = true;
    }
}

// Check tbl_rubric
$rubric_query = "SELECT COUNT(*) as count FROM tbl_rubric";
$result = $conn->query($rubric_query);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if ($row['count'] > 0) {
        $response["rubric"] = true;
    }
}

$conn->close();

echo json_encode($response);
?>
