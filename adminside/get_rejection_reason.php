<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli('localhost', 'root', '', 'db_scholarship_system');

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);
$studentId = $data['studentId'];
$scholarshipNo = $data['scholarshipNo'];

// Prepare and execute the query
$sql = "SELECT rejection_reason FROM tbl_application_scholarship WHERE Student_No = ? AND scholarship_no = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $studentId, $scholarshipNo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode(['success' => true, 'rejectionReason' => $row['rejection_reason']]);
} else {
    echo json_encode(['success' => false, 'message' => 'No rejection reason found.']);
}

$stmt->close();
$conn->close();
?>
